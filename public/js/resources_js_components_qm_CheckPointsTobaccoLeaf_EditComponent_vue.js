(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_qm_CheckPointsTobaccoLeaf_EditComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/CheckPointsTobaccoLeaf/EditComponent.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/CheckPointsTobaccoLeaf/EditComponent.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ['checkPoints', 'workList', 'btnTrans'],
  data: function data() {
    return {
      location_desc: this.checkPoints ? this.checkPoints[0].location_desc : '',
      locator_desc: this.checkPoints ? this.checkPoints[0].locator_desc : '',
      group_code: this.checkPoints ? this.checkPoints[0].qm_group : '',
      enable_flag: this.checkPoints[0].enabled_flag == 'Y' ? true : false,
      filesUploadList: [],
      organization_id: this.checkPoints ? this.checkPoints[0].organization_id : '',
      subinventory_code: this.checkPoints ? this.checkPoints[0].subinventory_code : '',
      warehouse_code: this.checkPoints ? this.checkPoints[0].building_code : '',
      location_code: this.checkPoints ? this.checkPoints[0].location_code : '',
      limitImage: this.checkPoints ? this.checkPoints[0].limitImage : 0,
      validate: {
        location_desc: false,
        locator_desc: false,
        group_code: false
      }
    };
  },
  mounted: function mounted() {// console.log(this.checkPoints);
  },
  methods: {
    handleRemove: function handleRemove(file, fileList) {
      this.filesUploadList.splice(file, 1);
    },
    handlePreview: function handlePreview(file) {},
    handleExceed: function handleExceed(files, fileList) {
      swal({
        title: "คำเตือน !",
        text: 'ไม่สามารถอัปโหลดรูปภาพเนื่องจากเกินจำนวนของรูปภาพสูงสุดของรูปภาพ',
        type: "warning",
        showConfirmButton: true
      });
    },
    beforeRemove: function beforeRemove(file, fileList) {
      return this.$confirm("\u0E22\u0E01\u0E40\u0E25\u0E34\u0E01\u0E01\u0E32\u0E23\u0E2D\u0E31\u0E1B\u0E42\u0E2B\u0E25\u0E14\u0E44\u0E1F\u0E25\u0E4C\u0E23\u0E39\u0E1B\u0E20\u0E32\u0E1E ".concat(file.name, " \u0E43\u0E0A\u0E48\u0E2B\u0E23\u0E37\u0E2D\u0E44\u0E21\u0E48 ?"));
    },
    onChange: function onChange(file, fileList) {
      this.filesUploadList = fileList;
    },
    save: function save() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var vm, formData;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                vm = _this;
                formData = new FormData();

                if (vm.location_desc) {
                  _context.next = 7;
                  break;
                }

                vm.validate.location_desc = true;
                return _context.abrupt("return");

              case 7:
                vm.validate.location_desc = false;

              case 8:
                if (vm.locator_desc) {
                  _context.next = 13;
                  break;
                }

                vm.validate.locator_desc = true;
                return _context.abrupt("return");

              case 13:
                vm.validate.locator_desc = false;

              case 14:
                if (vm.group_code) {
                  _context.next = 19;
                  break;
                }

                vm.validate.group_code = true;
                return _context.abrupt("return");

              case 19:
                vm.validate.group_code = false;

              case 20:
                formData.append('organization_id', vm.organization_id);
                formData.append('subinventory_code', vm.subinventory_code);
                formData.append('warehouse_code', vm.warehouse_code);
                formData.append('location_code', vm.location_code);
                formData.append('location_desc', vm.location_desc);
                formData.append('locator_desc', vm.locator_desc);
                formData.append('group_code', vm.group_code);
                formData.append('enable_flag', vm.enable_flag);
                vm.filesUploadList.forEach(function (element, index) {
                  formData.append('files[]', vm.filesUploadList[index].raw);
                });
                return _context.abrupt("return", axios.post('/qm/settings/check-points-tobacco-leaf/update', formData, {
                  headers: {
                    'Content-Type': 'multipart/form-data'
                  }
                }).then(function (res) {
                  if (res.data.status == 'SUCCESS') {
                    swal({
                      title: "Success !",
                      text: 'ทำการเปลี่ยนข้อมูลเรียบร้อยแล้ว',
                      type: "success",
                      showConfirmButton: true
                    });
                    setTimeout(function () {
                      window.location.href = '/qm/settings/check-points-tobacco-leaf';
                    }, 3000);
                  } else {
                    swal({
                      title: "Error !",
                      text: res.data.err_msg,
                      type: "error",
                      showConfirmButton: true
                    });
                  }
                }));

              case 30:
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

/***/ "./resources/js/components/qm/CheckPointsTobaccoLeaf/EditComponent.vue":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/qm/CheckPointsTobaccoLeaf/EditComponent.vue ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _EditComponent_vue_vue_type_template_id_75056c24___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./EditComponent.vue?vue&type=template&id=75056c24& */ "./resources/js/components/qm/CheckPointsTobaccoLeaf/EditComponent.vue?vue&type=template&id=75056c24&");
/* harmony import */ var _EditComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./EditComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/qm/CheckPointsTobaccoLeaf/EditComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _EditComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _EditComponent_vue_vue_type_template_id_75056c24___WEBPACK_IMPORTED_MODULE_0__.render,
  _EditComponent_vue_vue_type_template_id_75056c24___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/qm/CheckPointsTobaccoLeaf/EditComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/qm/CheckPointsTobaccoLeaf/EditComponent.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/components/qm/CheckPointsTobaccoLeaf/EditComponent.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./EditComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/CheckPointsTobaccoLeaf/EditComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/qm/CheckPointsTobaccoLeaf/EditComponent.vue?vue&type=template&id=75056c24&":
/*!************************************************************************************************************!*\
  !*** ./resources/js/components/qm/CheckPointsTobaccoLeaf/EditComponent.vue?vue&type=template&id=75056c24& ***!
  \************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponent_vue_vue_type_template_id_75056c24___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponent_vue_vue_type_template_id_75056c24___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponent_vue_vue_type_template_id_75056c24___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./EditComponent.vue?vue&type=template&id=75056c24& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/CheckPointsTobaccoLeaf/EditComponent.vue?vue&type=template&id=75056c24&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/CheckPointsTobaccoLeaf/EditComponent.vue?vue&type=template&id=75056c24&":
/*!***************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/CheckPointsTobaccoLeaf/EditComponent.vue?vue&type=template&id=75056c24& ***!
  \***************************************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "container" }, [
    _c("div", { staticClass: "row justify-content-center" }, [
      _c("div", { staticClass: "col-md-8" }, [
        _c("div", { staticClass: "row" }, [
          _c(
            "div",
            {
              staticClass: "col",
              staticStyle: {
                "margin-right": "125px",
                "margin-left": "125px",
                "padding-top": "15px"
              }
            },
            [
              _c("label", [_vm._v("ชื่อจุดตรวจสอบ")]),
              _c("span", { staticClass: "text-danger" }, [_vm._v(" *")]),
              _vm._v(" "),
              _c("el-input", {
                attrs: { placeholder: "กรอกชื่อจุดตรวจสอบ", disabled: true },
                model: {
                  value: _vm.location_desc,
                  callback: function($$v) {
                    _vm.location_desc = $$v
                  },
                  expression: "location_desc"
                }
              }),
              _vm._v(" "),
              this.validate.location_desc
                ? _c("div", { staticClass: "error-message" }, [
                    _c("strong", { staticClass: "font-bold text-danger" }, [
                      _vm._v("กรุณากรอก ชื่อจุดตรวจสอบ")
                    ])
                  ])
                : _vm._e()
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row" }, [
          _c(
            "div",
            {
              staticClass: "col",
              staticStyle: {
                "margin-right": "125px",
                "margin-left": "125px",
                "padding-top": "15px"
              }
            },
            [
              _c("label", [_vm._v("รายละเอียดจุดตรวจสอบ")]),
              _vm._v(" "),
              _c("el-input", {
                attrs: { placeholder: "กรอกชื่อจุดตรวจสอบ" },
                model: {
                  value: _vm.locator_desc,
                  callback: function($$v) {
                    _vm.locator_desc = $$v
                  },
                  expression: "locator_desc"
                }
              }),
              _vm._v(" "),
              this.validate.locator_desc
                ? _c("div", { staticClass: "error-message" }, [
                    _c("strong", { staticClass: "font-bold text-danger" }, [
                      _vm._v("กรุณากรอก รายละเอียดจุดตรวจสอบ")
                    ])
                  ])
                : _vm._e()
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row" }, [
          _c(
            "div",
            {
              staticClass: "col",
              staticStyle: {
                "margin-right": "125px",
                "margin-left": "125px",
                "padding-top": "15px"
              }
            },
            [
              _c("label", [_vm._v("กลุ่มงาน")]),
              _vm._v(" "),
              _c(
                "el-select",
                {
                  staticClass: "w-100",
                  attrs: {
                    clearable: "",
                    filterable: "",
                    placeholder: "เลือกกลุ่มงาน"
                  },
                  model: {
                    value: _vm.group_code,
                    callback: function($$v) {
                      _vm.group_code = $$v
                    },
                    expression: "group_code"
                  }
                },
                _vm._l(_vm.workList, function(data, index) {
                  return _c("el-option", {
                    key: index,
                    attrs: { label: data.meaning, value: data.meaning }
                  })
                }),
                1
              ),
              _vm._v(" "),
              this.validate.group_code
                ? _c("div", { staticClass: "error-message" }, [
                    _c("strong", { staticClass: "font-bold text-danger" }, [
                      _vm._v("กรุณาเลือก กลุ่มงาน")
                    ])
                  ])
                : _vm._e()
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row" }, [
          _c(
            "div",
            {
              staticClass: "col",
              staticStyle: {
                "margin-right": "125px",
                "margin-left": "125px",
                "padding-top": "15px"
              }
            },
            [
              _c("label", [_vm._v("สถานะการใช้งาน")]),
              _vm._v(" "),
              _c("el-checkbox", {
                staticClass: "w-100",
                model: {
                  value: _vm.enable_flag,
                  callback: function($$v) {
                    _vm.enable_flag = $$v
                  },
                  expression: "enable_flag"
                }
              })
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row" }, [
          _c(
            "div",
            {
              staticClass: "col",
              staticStyle: {
                "margin-right": "125px",
                "margin-left": "125px",
                "padding-top": "15px",
                "padding-bottom": "15px"
              }
            },
            [
              _c("label", [_vm._v("รูปภาพประกอบ")]),
              _vm._v(" "),
              _c(
                "el-upload",
                {
                  staticClass: "upload-demo",
                  attrs: {
                    accept: "image/*",
                    action:
                      "http://web-service.test/qm/settings/check-points-tobacco-leaf/update",
                    "on-preview": _vm.handlePreview,
                    "on-remove": _vm.handleRemove,
                    "before-remove": _vm.beforeRemove,
                    "auto-upload": false,
                    "on-change": _vm.onChange,
                    limit: _vm.limitImage,
                    "on-exceed": _vm.handleExceed,
                    "file-list": _vm.filesUploadList,
                    multiple: ""
                  }
                },
                [
                  _c(
                    "el-button",
                    { attrs: { size: "small", type: "primary" } },
                    [_vm._v("เพิ่มรูปภาพ")]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass: "el-upload__tip",
                      attrs: { slot: "tip" },
                      slot: "tip"
                    },
                    [
                      _vm._v(
                        "สามารถเพิ่มได้อีก " +
                          _vm._s(_vm.limitImage) +
                          " รูป สูงสุดไม่เกิน 5 รูป"
                      )
                    ]
                  )
                ],
                1
              )
            ],
            1
          )
        ])
      ])
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "col-12 mt-3" }, [
      _c("hr"),
      _vm._v(" "),
      _c("div", { staticClass: "row clearfix m-t-lg text-right" }, [
        _c("div", { staticClass: "col-sm-12" }, [
          _c(
            "button",
            {
              class: _vm.btnTrans.save.class,
              attrs: { type: "submit" },
              on: { click: _vm.save }
            },
            [
              _c("i", {
                class: _vm.btnTrans.save.icon,
                attrs: { "aria-hidden": "true" }
              }),
              _vm._v(
                "  \n                        " +
                  _vm._s(_vm.btnTrans.save.text) +
                  "\n                "
              )
            ]
          ),
          _vm._v(" "),
          _c(
            "a",
            {
              class: _vm.btnTrans.cancel.class,
              attrs: {
                href: "/qm/settings/check-points-tobacco-leaf",
                type: "button"
              }
            },
            [
              _c("i", {
                class: _vm.btnTrans.cancel.icon,
                attrs: { "aria-hidden": "true" }
              }),
              _vm._v(
                " \n                    " +
                  _vm._s(_vm.btnTrans.cancel.text) +
                  "\n                "
              )
            ]
          )
        ])
      ])
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);