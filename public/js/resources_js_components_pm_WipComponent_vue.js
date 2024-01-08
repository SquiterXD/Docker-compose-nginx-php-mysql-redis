(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pm_WipComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/WipComponent.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/WipComponent.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var uuid_v1__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! uuid/v1 */ "./node_modules/uuid/v1.js");
/* harmony import */ var uuid_v1__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(uuid_v1__WEBPACK_IMPORTED_MODULE_2__);


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


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['departments', 'uoms', 'organizations', 'openClass', 'defaultValue', 'old', 'org', 'urlSave', 'urlReset'],
  data: function data() {
    return {
      organization_code: this.defaultValue ? this.defaultValue.organization_code : this.org,
      routing_no: this.old.routing_no ? this.old.routing_no : this.defaultValue ? this.defaultValue.routing_no : '',
      routing_description: this.old.routing_description ? this.old.routing_description : this.defaultValue ? this.defaultValue.routing_description : '',
      active_flag: this.old.active_flag ? this.old.active_flag ? true : false : this.defaultValue ? this.defaultValue.active_flag == 'Y' ? true : false : true,
      disableEdit: this.defaultValue ? true : false,
      lines: [],
      lineDelete: [],
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      check_update: false,
      disableActive: false
    };
  },
  mounted: function mounted() {
    var _this = this;

    if (this.defaultValue) {
      if (this.defaultValue.wip_steps) {
        _.orderBy(this.defaultValue.wip_steps, 'wip_step_id').forEach(function (list_line) {
          if (list_line.web_status != 'DELETE') {
            _this.lines.push({
              id: list_line.routing_step_no,
              // id            : uuidv1(),
              wip_step: list_line.wip_step,
              wip_step_desc: list_line.wip_step_desc,
              uom_code: list_line.uom_code,
              attribute4: list_line.attribute4 == 'Y' ? true : false,
              status: 'update'
            });
          }
        });
      } else {
        this.addLine();
      }

      if (this.defaultValue.active_flag == 'N') {
        this.disableActive = true;
      }
    } else {
      this.addLine();
    }
  },
  methods: {
    addLine: function addLine() {
      var today = new Date();
      var time = moment__WEBPACK_IMPORTED_MODULE_1___default()(today).format('DDMMyyyy') + String(today.getHours()) + String(today.getMinutes()) + String(today.getSeconds());
      this.lines.push({
        // id            : time,
        id: uuid_v1__WEBPACK_IMPORTED_MODULE_2___default()(),
        wip_step: '',
        wip_step_desc: '',
        uom_code: '',
        status: 'new',
        attribute4: true // disabledRow   : false,

      });
    },
    removeRow: function removeRow(row, index) {
      var vm = this;
      swal({
        title: "Warning",
        text: "ต้องการลบขั้นตอนการทำงานหรือไม่?",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: false
      }, function (isConfirm) {
        if (isConfirm) {
          vm.lineDelete.push({
            id: row.id,
            wip_step: row.wip_step,
            wip_step_desc: row.wip_step_desc,
            uom_code: row.uom_code,
            attribute4: row.attribute4,
            status: 'delete'
          });
          vm.lines.splice(index, 1);
          vm.checkUpdate();
          swal({
            title: "Success",
            text: '',
            timer: 3000,
            type: "success",
            showCancelButton: false,
            showConfirmButton: false
          });
        }
      }); // this.lineDelete.push({
      //     id            : row.id,
      //     wip_step      : row.wip_step,
      //     wip_step_desc : row.wip_step_desc,
      //     uom_code      : row.uom_code,
      //     status        : 'delete',
      // });
      // this.lines.splice(index, 1);
    },
    checkForm: function checkForm(e) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var form, inputs;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                form = $('#submitForm');
                inputs = form.serialize();
                _this2.errors = [];

                if (_this2.defaultValue) {
                  if (_this2.check_update) {
                    if (!_this2.active_flag) {
                      _this2.errors.push('ไม่สามารถแก้ไขข้อมูลได้ เนื่องจากขั้นตอนการทำงานปิดการใช้งาน');

                      swal({
                        title: "",
                        text: _this2.errors,
                        timer: 3000,
                        type: "error",
                        showCancelButton: false,
                        showConfirmButton: false
                      });
                    }
                  }
                }

                if (!_this2.routing_description) {
                  _this2.errors.push('คำอธิบายชุดการผลิต');

                  swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: _this2.errors,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                  });
                }

                if (!_this2.lines.length) {
                  _this2.errors.push('ขั้นตอนการทำงาน, ชื่อขั้นตอนการทำงาน, หน่วยนับผลผลิต');

                  console.log('check validate line <---> ' + _this2.lines.length);
                  swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: _this2.errors,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                  });
                }

                if (_this2.lines.length > 0) {
                  _this2.lines.forEach(function (line) {
                    if (!line.wip_step) {
                      _this2.errors.push('ขั้นตอนการทำงาน');

                      swal({
                        title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                        text: _this2.errors,
                        timer: 3000,
                        type: "error",
                        showCancelButton: false,
                        showConfirmButton: false
                      });
                    }

                    if (!line.wip_step_desc) {
                      _this2.errors.push('ชื่อขั้นตอนการทำงาน');

                      swal({
                        title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                        text: _this2.errors,
                        timer: 3000,
                        type: "error",
                        showCancelButton: false,
                        showConfirmButton: false
                      });
                    }

                    if (!line.uom_code) {
                      _this2.errors.push('หน่วยนับผลผลิต');

                      swal({
                        title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                        text: _this2.errors,
                        timer: 3000,
                        type: "error",
                        showCancelButton: false,
                        showConfirmButton: false
                      });
                    }
                  });
                }

                if (!_this2.errors.length) {
                  form.submit();
                }

                e.preventDefault();

              case 9:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    checkDup: function checkDup(row, index) {
      if (row.wip_step) {
        if (index > 0) {
          var idx = this.lines.find(function (line) {
            if (line.id != row.id) {
              if (row.wip_step == line.wip_step) {
                row.wip_step = '';
                swal({
                  title: "มีข้อผิดพลาด",
                  text: 'ไม่สามารถเลือกขั้นตอนการทำงานซ้ำกันได้',
                  type: "error",
                  showCancelButton: false,
                  showConfirmButton: true
                });
              }
            }
          });
        }
      }
    },
    checkUpdate: function checkUpdate() {
      this.check_update = true;
    }
  }
});

/***/ }),

/***/ "./resources/js/components/pm/WipComponent.vue":
/*!*****************************************************!*\
  !*** ./resources/js/components/pm/WipComponent.vue ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _WipComponent_vue_vue_type_template_id_6af26c94___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./WipComponent.vue?vue&type=template&id=6af26c94& */ "./resources/js/components/pm/WipComponent.vue?vue&type=template&id=6af26c94&");
/* harmony import */ var _WipComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./WipComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/WipComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _WipComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _WipComponent_vue_vue_type_template_id_6af26c94___WEBPACK_IMPORTED_MODULE_0__.render,
  _WipComponent_vue_vue_type_template_id_6af26c94___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/WipComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/WipComponent.vue?vue&type=script&lang=js&":
/*!******************************************************************************!*\
  !*** ./resources/js/components/pm/WipComponent.vue?vue&type=script&lang=js& ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_WipComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./WipComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/WipComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_WipComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/WipComponent.vue?vue&type=template&id=6af26c94&":
/*!************************************************************************************!*\
  !*** ./resources/js/components/pm/WipComponent.vue?vue&type=template&id=6af26c94& ***!
  \************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_WipComponent_vue_vue_type_template_id_6af26c94___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_WipComponent_vue_vue_type_template_id_6af26c94___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_WipComponent_vue_vue_type_template_id_6af26c94___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./WipComponent.vue?vue&type=template&id=6af26c94& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/WipComponent.vue?vue&type=template&id=6af26c94&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/WipComponent.vue?vue&type=template&id=6af26c94&":
/*!***************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/WipComponent.vue?vue&type=template&id=6af26c94& ***!
  \***************************************************************************************************************************************************************************************************************************/
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
    "form",
    {
      attrs: {
        id: "submitForm",
        action: _vm.urlSave,
        method: "post",
        onkeydown: "return event.key != 'Enter';"
      },
      on: {
        submit: function($event) {
          $event.preventDefault()
          return _vm.checkForm($event)
        }
      }
    },
    [
      _c("input", {
        attrs: { type: "hidden", name: "_token" },
        domProps: { value: _vm.csrf }
      }),
      _vm._v(" "),
      this.defaultValue
        ? _c("input", {
            attrs: { type: "hidden", name: "_method", value: "PUT" }
          })
        : _vm._e(),
      _vm._v(" "),
      _c("div", [
        _c("div", { staticClass: "row" }, [
          _c(
            "div",
            { staticClass: "col-md-4" },
            [
              _vm._m(0),
              _vm._v(" "),
              _c("el-input", {
                attrs: {
                  name: "routing_description",
                  disabled: this.disableActive
                },
                on: {
                  input: function($event) {
                    return _vm.checkUpdate()
                  }
                },
                model: {
                  value: _vm.routing_description,
                  callback: function($$v) {
                    _vm.routing_description = $$v
                  },
                  expression: "routing_description"
                }
              }),
              _vm._v(" "),
              this.disableActive
                ? _c("div", [
                    _c("input", {
                      attrs: { type: "hidden", name: "routing_description" },
                      domProps: { value: this.routing_description }
                    })
                  ])
                : _vm._e()
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-4" },
            [
              _vm._m(1),
              _vm._v(" "),
              _c("input", {
                attrs: {
                  type: "hidden",
                  name: "organization_code",
                  autocomplete: "off"
                },
                domProps: { value: _vm.organization_code }
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
                    disabled: ""
                  },
                  model: {
                    value: _vm.organization_code,
                    callback: function($$v) {
                      _vm.organization_code = $$v
                    },
                    expression: "organization_code"
                  }
                },
                _vm._l(_vm.organizations, function(organization) {
                  return _c("el-option", {
                    key: organization.organization_code,
                    attrs: {
                      label:
                        organization.organization_code +
                        " : " +
                        organization.organization_desc,
                      value: organization.organization_code
                    }
                  })
                }),
                1
              )
            ],
            1
          ),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-2" }, [
            _vm._m(2),
            _vm._v(" "),
            _c("div", [
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.active_flag,
                    expression: "active_flag"
                  }
                ],
                attrs: { type: "checkbox", name: "active_flag" },
                domProps: {
                  checked: Array.isArray(_vm.active_flag)
                    ? _vm._i(_vm.active_flag, null) > -1
                    : _vm.active_flag
                },
                on: {
                  change: function($event) {
                    var $$a = _vm.active_flag,
                      $$el = $event.target,
                      $$c = $$el.checked ? true : false
                    if (Array.isArray($$a)) {
                      var $$v = null,
                        $$i = _vm._i($$a, $$v)
                      if ($$el.checked) {
                        $$i < 0 && (_vm.active_flag = $$a.concat([$$v]))
                      } else {
                        $$i > -1 &&
                          (_vm.active_flag = $$a
                            .slice(0, $$i)
                            .concat($$a.slice($$i + 1)))
                      }
                    } else {
                      _vm.active_flag = $$c
                    }
                  }
                }
              })
            ])
          ])
        ]),
        _vm._v(" "),
        _c("hr"),
        _vm._v(" "),
        _c("div", { staticClass: "mt-3" }, [
          _c("div", { staticClass: "text-right" }, [
            _c(
              "button",
              {
                staticClass: "btn btn-sm btn-success",
                attrs: { type: "submit", disabled: this.disableActive },
                on: {
                  click: function($event) {
                    $event.preventDefault()
                    return _vm.addLine($event)
                  }
                }
              },
              [_c("i", { staticClass: "fa fa-plus" }), _vm._v(" เพิ่ม ")]
            )
          ]),
          _vm._v(" "),
          _c("table", { staticClass: "table table-responsive-sm" }, [
            _vm._m(3),
            _vm._v(" "),
            _c(
              "tbody",
              [
                _vm._l(_vm.lines, function(row, index) {
                  return _c("tr", [
                    _c("input", {
                      attrs: {
                        type: "hidden",
                        name: "listLine[" + row.id + "][status]",
                        autocomplete: "off"
                      },
                      domProps: { value: row.status }
                    }),
                    _vm._v(" "),
                    _c("td", { staticClass: "text-center" }, [
                      _vm._v(" " + _vm._s(index + 1) + " ")
                    ]),
                    _vm._v(" "),
                    _c(
                      "td",
                      [
                        _c("input", {
                          attrs: {
                            type: "hidden",
                            name: "listLine[" + row.id + "][wip_step]",
                            autocomplete: "off"
                          },
                          domProps: { value: row.wip_step }
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
                              disabled: row.status == "update"
                            },
                            on: {
                              change: function($event) {
                                return _vm.checkDup(row, index)
                              }
                            },
                            model: {
                              value: row.wip_step,
                              callback: function($$v) {
                                _vm.$set(row, "wip_step", $$v)
                              },
                              expression: "row.wip_step"
                            }
                          },
                          _vm._l(_vm.openClass, function(option) {
                            return _c("el-option", {
                              key: option.oprn_class_desc,
                              attrs: {
                                label: option.oprn_class_desc,
                                value: option.oprn_class_desc
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
                      "td",
                      [
                        _c("el-input", {
                          attrs: {
                            name: "listLine[" + row.id + "][wip_step_desc]",
                            disabled: _vm.disableActive
                          },
                          on: {
                            input: function($event) {
                              return _vm.checkUpdate()
                            }
                          },
                          model: {
                            value: row.wip_step_desc,
                            callback: function($$v) {
                              _vm.$set(row, "wip_step_desc", $$v)
                            },
                            expression: "row.wip_step_desc"
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
                          attrs: {
                            type: "hidden",
                            name: "listLine[" + row.id + "][uom_code]",
                            autocomplete: "off"
                          },
                          domProps: { value: row.uom_code }
                        }),
                        _vm._v(" "),
                        _c(
                          "el-select",
                          {
                            attrs: {
                              filterable: "",
                              remote: "",
                              "reserve-keyword": "",
                              clearable: "",
                              disabled: _vm.disableActive
                            },
                            on: {
                              change: function($event) {
                                return _vm.checkUpdate()
                              }
                            },
                            model: {
                              value: row.uom_code,
                              callback: function($$v) {
                                _vm.$set(row, "uom_code", $$v)
                              },
                              expression: "row.uom_code"
                            }
                          },
                          _vm._l(_vm.uoms, function(uom) {
                            return _c("el-option", {
                              key: uom.uom_code,
                              attrs: {
                                label: uom.unit_of_measure,
                                value: uom.uom_code
                              }
                            })
                          }),
                          1
                        )
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c("td", { staticClass: "text-center" }, [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: row.attribute4,
                            expression: "row.attribute4"
                          }
                        ],
                        attrs: {
                          type: "checkbox",
                          name: "listLine[" + row.id + "][attribute4]",
                          disabled: _vm.disableActive
                        },
                        domProps: {
                          checked: Array.isArray(row.attribute4)
                            ? _vm._i(row.attribute4, null) > -1
                            : row.attribute4
                        },
                        on: {
                          change: function($event) {
                            var $$a = row.attribute4,
                              $$el = $event.target,
                              $$c = $$el.checked ? true : false
                            if (Array.isArray($$a)) {
                              var $$v = null,
                                $$i = _vm._i($$a, $$v)
                              if ($$el.checked) {
                                $$i < 0 &&
                                  _vm.$set(row, "attribute4", $$a.concat([$$v]))
                              } else {
                                $$i > -1 &&
                                  _vm.$set(
                                    row,
                                    "attribute4",
                                    $$a.slice(0, $$i).concat($$a.slice($$i + 1))
                                  )
                              }
                            } else {
                              _vm.$set(row, "attribute4", $$c)
                            }
                          }
                        }
                      })
                    ]),
                    _vm._v(" "),
                    _c("td", [
                      !row.disabledRow
                        ? _c("div", [
                            !_vm.disableActive
                              ? _c("div", [
                                  _c(
                                    "button",
                                    {
                                      staticClass: "btn btn-sm btn-danger",
                                      on: {
                                        click: function($event) {
                                          $event.preventDefault()
                                          return _vm.removeRow(row, index)
                                        }
                                      }
                                    },
                                    [
                                      _vm._v(
                                        "\n                                    X\n                                    "
                                      )
                                    ]
                                  )
                                ])
                              : _vm._e()
                          ])
                        : _vm._e()
                    ]),
                    _vm._v(" "),
                    _vm.disableActive
                      ? _c("div", [
                          _c("input", {
                            attrs: {
                              type: "hidden",
                              name: "listLine[" + row.id + "][wip_step_desc]",
                              autocomplete: "off"
                            },
                            domProps: { value: row.wip_step_desc }
                          }),
                          _vm._v(" "),
                          _c("input", {
                            attrs: {
                              type: "hidden",
                              name: "listLine[" + row.id + "][attribute4]",
                              autocomplete: "off"
                            },
                            domProps: { value: row.attribute4 }
                          })
                        ])
                      : _vm._e()
                  ])
                }),
                _vm._v(" "),
                _vm._l(_vm.lineDelete, function(row, index) {
                  return _c("div", [
                    _c("input", {
                      attrs: {
                        type: "hidden",
                        name: "lineDelete[" + row.id + "][status]",
                        autocomplete: "off"
                      },
                      domProps: { value: row.status }
                    }),
                    _vm._v(" "),
                    _c("input", {
                      attrs: {
                        type: "hidden",
                        name: "lineDelete[" + row.id + "][wip_step]",
                        autocomplete: "off"
                      },
                      domProps: { value: row.wip_step }
                    }),
                    _vm._v(" "),
                    _c("input", {
                      attrs: {
                        type: "hidden",
                        name: "lineDelete[" + row.id + "][wip_step_desc]",
                        autocomplete: "off"
                      },
                      domProps: { value: row.wip_step_desc }
                    }),
                    _vm._v(" "),
                    _c("input", {
                      attrs: {
                        type: "hidden",
                        name: "lineDelete[" + row.id + "][uom_code]",
                        autocomplete: "off"
                      },
                      domProps: { value: row.uom_code }
                    }),
                    _vm._v(" "),
                    _c("input", {
                      attrs: {
                        type: "hidden",
                        name: "lineDelete[" + row.id + "][attribute4]",
                        autocomplete: "off"
                      },
                      domProps: { value: row.attribute4 }
                    })
                  ])
                })
              ],
              2
            )
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col-12 mt-3" }, [
          _c("hr"),
          _vm._v(" "),
          _c("div", { staticClass: "row clearfix m-t-lg text-right" }, [
            _c("div", { staticClass: "col-sm-12" }, [
              _vm._m(4),
              _vm._v(" "),
              _c(
                "a",
                {
                  staticClass: "btn btn-sm btn-warning",
                  attrs: { href: this.urlReset, type: "button" }
                },
                [_c("i", { staticClass: "fa fa-times" }), _vm._v(" ยกเลิก ")]
              )
            ])
          ])
        ])
      ])
    ]
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", [
      _c("b", [_vm._v("คำอธิบายชุดการผลิต")]),
      _vm._v(" "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")]),
      _c("br"),
      _vm._v(" "),
      _c("small", { staticClass: "text-danger" }, [
        _vm._v("(ไม่สามารถใส่คำอธิบายซ้ำกับข้อมูลที่มีในระบบ)")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", [
      _c("b", [_vm._v("Organization")]),
      _vm._v(" "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")]),
      _vm._v(" "),
      _c("br"),
      _vm._v(" "),
      _c("br")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", [
      _c("b", [_vm._v("สถานะการใช้งาน")]),
      _vm._v(" "),
      _c("br"),
      _vm._v(" "),
      _c("br")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", { attrs: { width: "3%" } }, [_vm._v(" ลำดับ ")]),
        _vm._v(" "),
        _c("th", [
          _vm._v(" ขั้นตอนการทำงาน "),
          _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
        ]),
        _vm._v(" "),
        _c("th", [
          _vm._v(" ชื่อขั้นตอนการทำงาน "),
          _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
        ]),
        _vm._v(" "),
        _c("th", { attrs: { width: "20%" } }, [
          _vm._v(" หน่วยนับผลผลิต "),
          _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
        ]),
        _vm._v(" "),
        _c("th", [_vm._v("WIP ที่ใช้ตัดวัตถุดิบ")]),
        _vm._v(" "),
        _c("th")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "button",
      { staticClass: "btn btn-sm btn-primary", attrs: { type: "submit" } },
      [_c("i", { staticClass: "fa fa-save" }), _vm._v(" บันทึก ")]
    )
  }
]
render._withStripped = true



/***/ })

}]);