(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_qm_CheckPointsTobaccoBeetle_CreateComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/CheckPointsTobaccoBeetle/CreateComponent.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/CheckPointsTobaccoBeetle/CreateComponent.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['btnTrans'],
  data: function data() {
    return {
      build_name: '',
      department_name: '',
      location_desc: '',
      locator_desc: '',
      building_code: '',
      enable_flag: true,
      fileList: [],
      validate: {
        build_name: false,
        department_name: false,
        location_desc: false,
        locator_desc: false,
        building_code: false
      }
    };
  },
  methods: {
    handleRemove: function handleRemove(file, fileList) {
      console.log(file, fileList);
    },
    handlePreview: function handlePreview(file) {
      console.log(file);
    },
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
    handleChange: function handleChange(file, fileList) {
      this.fileList = fileList;
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

                if (vm.build_name) {
                  _context.next = 7;
                  break;
                }

                vm.validate.build_name = true;
                return _context.abrupt("return");

              case 7:
                vm.validate.build_name = false;

              case 8:
                if (vm.department_name) {
                  _context.next = 13;
                  break;
                }

                vm.validate.department_name = true;
                return _context.abrupt("return");

              case 13:
                vm.validate.department_name = false;

              case 14:
                if (vm.location_desc) {
                  _context.next = 19;
                  break;
                }

                vm.validate.location_desc = true;
                return _context.abrupt("return");

              case 19:
                vm.validate.location_desc = false;

              case 20:
                if (vm.locator_desc) {
                  _context.next = 25;
                  break;
                }

                vm.validate.locator_desc = true;
                return _context.abrupt("return");

              case 25:
                vm.validate.locator_desc = false;

              case 26:
                formData.append('location_desc', vm.location_desc);
                formData.append('locator_desc', vm.locator_desc);
                formData.append('enable_flag', vm.enable_flag);
                formData.append('build_name', vm.build_name);
                formData.append('department_name', vm.department_name);
                vm.fileList.forEach(function (element, index) {
                  formData.append('files[]', vm.fileList[index].raw);
                });
                return _context.abrupt("return", axios.post('/qm/settings/check-points-tobacco-beetle/store', formData, {
                  headers: {
                    'Content-Type': 'multipart/form-data'
                  }
                }).then(function (res) {
                  console.log(res.data);

                  if (res.data.status == 'SUCCESS') {
                    swal({
                      title: "บันทึกสำเร็จ !",
                      text: 'ทำการเพิ่มรายการเรียบร้อยแล้ว',
                      type: "success",
                      showConfirmButton: true
                    });
                    setTimeout(function () {
                      window.location.href = '/qm/settings/check-points-tobacco-beetle';
                    }, 3000);
                  } else {
                    swal({
                      title: "Error !",
                      text: res.data.err_msg,
                      type: "error",
                      showConfirmButton: true
                    });
                  }

                  if (res.data.status == 'Duplicate') {
                    swal({
                      title: "เกิดข้อผิดพลาด !",
                      text: res.data.data,
                      type: "error",
                      showConfirmButton: true
                    });
                  }
                }));

              case 33:
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

/***/ "./resources/js/components/qm/CheckPointsTobaccoBeetle/CreateComponent.vue":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/qm/CheckPointsTobaccoBeetle/CreateComponent.vue ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _CreateComponent_vue_vue_type_template_id_254c72ff___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CreateComponent.vue?vue&type=template&id=254c72ff& */ "./resources/js/components/qm/CheckPointsTobaccoBeetle/CreateComponent.vue?vue&type=template&id=254c72ff&");
/* harmony import */ var _CreateComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CreateComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/qm/CheckPointsTobaccoBeetle/CreateComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _CreateComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _CreateComponent_vue_vue_type_template_id_254c72ff___WEBPACK_IMPORTED_MODULE_0__.render,
  _CreateComponent_vue_vue_type_template_id_254c72ff___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/qm/CheckPointsTobaccoBeetle/CreateComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/qm/CheckPointsTobaccoBeetle/CreateComponent.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************!*\
  !*** ./resources/js/components/qm/CheckPointsTobaccoBeetle/CreateComponent.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./CreateComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/CheckPointsTobaccoBeetle/CreateComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/qm/CheckPointsTobaccoBeetle/CreateComponent.vue?vue&type=template&id=254c72ff&":
/*!****************************************************************************************************************!*\
  !*** ./resources/js/components/qm/CheckPointsTobaccoBeetle/CreateComponent.vue?vue&type=template&id=254c72ff& ***!
  \****************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateComponent_vue_vue_type_template_id_254c72ff___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateComponent_vue_vue_type_template_id_254c72ff___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateComponent_vue_vue_type_template_id_254c72ff___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./CreateComponent.vue?vue&type=template&id=254c72ff& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/CheckPointsTobaccoBeetle/CreateComponent.vue?vue&type=template&id=254c72ff&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/CheckPointsTobaccoBeetle/CreateComponent.vue?vue&type=template&id=254c72ff&":
/*!*******************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/CheckPointsTobaccoBeetle/CreateComponent.vue?vue&type=template&id=254c72ff& ***!
  \*******************************************************************************************************************************************************************************************************************************************************/
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
              _c("label", [_vm._v("อาคาร")]),
              _c("span", { staticClass: "text-danger" }, [_vm._v(" *")]),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.build_name,
                    expression: "build_name"
                  }
                ],
                attrs: { type: "hidden", name: "build_name" },
                domProps: { value: _vm.build_name },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.build_name = $event.target.value
                  }
                }
              }),
              _vm._v(" "),
              _c("el-input", {
                attrs: { placeholder: "กรอกชื่ออาคาร" },
                model: {
                  value: _vm.build_name,
                  callback: function($$v) {
                    _vm.build_name = $$v
                  },
                  expression: "build_name"
                }
              }),
              _vm._v(" "),
              this.validate.build_name
                ? _c("div", { staticClass: "error-message" }, [
                    _c("strong", { staticClass: "font-bold text-danger" }, [
                      _vm._v("กรุณากรอก ชื่ออาคาร")
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
              _c("label", [_vm._v("หน่วยงาน")]),
              _c("span", { staticClass: "text-danger" }, [_vm._v(" *")]),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.department_name,
                    expression: "department_name"
                  }
                ],
                attrs: { type: "hidden", name: "department_name" },
                domProps: { value: _vm.department_name },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.department_name = $event.target.value
                  }
                }
              }),
              _vm._v(" "),
              _c("el-input", {
                attrs: { placeholder: "กรอกชื่อหน่วยงาน" },
                model: {
                  value: _vm.department_name,
                  callback: function($$v) {
                    _vm.department_name = $$v
                  },
                  expression: "department_name"
                }
              }),
              _vm._v(" "),
              this.validate.department_name
                ? _c("div", { staticClass: "error-message" }, [
                    _c("strong", { staticClass: "font-bold text-danger" }, [
                      _vm._v("กรุณากรอก หน่วยงาน")
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
              _c("label", [_vm._v("ชื่อจุดตรวจสอบ")]),
              _c("span", { staticClass: "text-danger" }, [_vm._v(" *")]),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.location_desc,
                    expression: "location_desc"
                  }
                ],
                attrs: { type: "hidden", name: "location_desc" },
                domProps: { value: _vm.location_desc },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.location_desc = $event.target.value
                  }
                }
              }),
              _vm._v(" "),
              _c("el-input", {
                attrs: { placeholder: "กรอกชื่อจุดตรวจสอบ" },
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
              _c("span", { staticClass: "text-danger" }, [_vm._v(" *")]),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.locator_desc,
                    expression: "locator_desc"
                  }
                ],
                attrs: { type: "hidden", name: "locator_desc" },
                domProps: { value: _vm.locator_desc },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.locator_desc = $event.target.value
                  }
                }
              }),
              _vm._v(" "),
              _c("el-input", {
                attrs: { placeholder: "กรอกรายละเอียดจุดตรวจสอบ" },
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
              _c("label", [_vm._v("สถานะการใช้งาน")]),
              _vm._v(" "),
              _c("input", {
                attrs: { type: "hidden", name: "enable_flag" },
                domProps: { value: _vm.enable_flag }
              }),
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
                    action:
                      "http://web-service.test/qm/settings/check-points-tobacco-beetle/create",
                    "on-preview": _vm.handlePreview,
                    "on-remove": _vm.handleRemove,
                    "before-remove": _vm.beforeRemove,
                    "auto-upload": false,
                    "on-change": _vm.handleChange,
                    name: "files[]",
                    multiple: "",
                    limit: 5,
                    "on-exceed": _vm.handleExceed,
                    "file-list": _vm.fileList
                  }
                },
                [
                  _c(
                    "el-button",
                    { attrs: { size: "small", type: "primary" } },
                    [_vm._v("เพิ่มรูปภาพ")]
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
                staticClass: "btnTrans.save.icon",
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
                href: "/qm/settings/check-points-tobacco-beetle",
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