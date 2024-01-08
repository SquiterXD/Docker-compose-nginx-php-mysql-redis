(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pm_MachineRelationComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/MachineRelationComponent.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/MachineRelationComponent.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************************/
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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["machineGroups", "assets", "defaultValue", "old", "organizationCode", "org", "urlSave", "urlReset"],
  data: function data() {
    return {
      // organization_id:        this.old ? this.old.organization_id : this.defaultValue ? this.defaultValue.organization_id : '',
      // machine_group_desc:     '',
      machine_group: this.old.machine_group ? this.old.machine_group : this.defaultValue ? this.defaultValue.machine_group : "",
      machine_set: this.old.machine_set ? this.old.machine_set : this.defaultValue ? this.defaultValue.machine_set : "",
      machine_name: this.old.machine_name ? this.old.machine_name : this.defaultValue ? this.defaultValue.machine_name : "",
      // pm_enable_flag:         this.old ? this.old.pm_enable_flag == 'Y' ? true : false : this.defaultValue ? this.defaultValue.pm_enable_flag == 'Y' ? true : false : true,
      pm_enable_flag: this.old.pm_enable_flag ? this.old.pm_enable_flag ? true : false : this.defaultValue ? this.defaultValue.pm_enable_flag == "Y" ? true : false : true,
      // start_date:             moment(String(Date())).format('DD-MM-yyyy'),
      // end_date:               '',
      //ดึงจาก asset
      machine_description: "",
      machine_type: "",
      step_num: "",
      step_description: "",
      machine_speed: "",
      machine_eamperformance: "",
      machine_speed_unit: "",
      //
      assetList: [],
      organization_code: this.organizationCode,
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
      loading: false,
      machine_relation_id: this.defaultValue ? this.defaultValue.machine_relation_id : ""
    };
  },
  mounted: function mounted() {
    if (this.machine_name) {
      this.getAsset(this.machine_name);
    } else {
      this.getAsset();
    }

    this.machine_description = this.defaultValue ? this.defaultValue.machine_description : "", this.machine_type = this.defaultValue ? this.defaultValue.machine_type.description : "", this.step_num = this.defaultValue ? this.defaultValue.step_num : "", this.step_description = this.defaultValue ? this.defaultValue.step_description : "", this.machine_speed = this.defaultValue ? this.defaultValue.machine_speed.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : "", this.machine_eamperformance = this.defaultValue ? this.defaultValue.machine_eamperformance : "", this.machine_speed_unit = this.defaultValue ? this.defaultValue.machine_speed_unit : "", console.log("organizationCode <--> " + this.organizationCode);
    console.log("org <--> " + this.org);
  },
  methods: {
    onlyNumeric: function onlyNumeric() {
      this.machine_set = this.machine_set.replace(/[^0-9 .]/g, "");
    },
    getAsset: function getAsset(query) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this.wip_uom = "";
                _this.assetList = [];
                axios.get("/pm/ajax/get-asset", {
                  params: {
                    query: query
                  },
                  beforeSend: function beforeSend(xhr) {
                    $("#_content_transaction").html('\
                        <div class="m-t-lg m-b-lg">\
                            <div class="text-center sk-spinner sk-spinner-wave">\
                                <div class="sk-rect1"></div>\
                                <div class="sk-rect2"></div>\
                                <div class="sk-rect3"></div>\
                                <div class="sk-rect4"></div>\
                                <div class="sk-rect5"></div>\
                            </div>\
                        </div>');
                  }
                }).then(function (res) {
                  _this.assetList = res.data; // if (this.machine_name) {
                  //     if (this.assetList.length > 0) {
                  //         this.getData();
                  //     }
                  // }
                })["catch"](function (err) {
                  console.log(err);
                });

              case 3:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getData: function getData() {
      var _this2 = this;

      this.machine_description = "";
      this.machine_type = "";
      this.step_num = "";
      this.step_description = "";
      this.machine_speed = "";
      this.machine_eamperformance = "";
      this.machine_speed_unit = "";

      if (this.machine_name) {
        this.selected = this.assetList.find(function (data) {
          return data.asset_number == _this2.machine_name;
        });

        if (this.selected) {
          this.machine_description = this.selected.asset_description;
          this.machine_type = this.selected.machine_type_desc;
          this.step_num = this.selected.wip_step;
          this.step_description = this.selected.wip_step_desc;
          this.machine_speed = this.selected.machine_speed;
          this.machine_eamperformance = this.selected.performance_percent;
          this.machine_speed_unit = this.selected.machine_speed_unit;
        }
      }
    },
    checkForm: function checkForm(e) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var form, vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                form = $("#submitForm");
                vm = _this3;
                axios.get("/pm/ajax/validate-asset", {
                  params: {
                    machine_name: _this3.machine_name,
                    pm_enable_flag: _this3.pm_enable_flag,
                    machine_relation_id: _this3.machine_relation_id
                  }
                }).then(function (res) {
                  if (res.data.data.status == "Y") {
                    swal({
                      title: "Warning",
                      text: "มีข้อมูลเครื่องจักรนี้ เปิดใช้งานอยู่แล้ว ต้องการยืนยันเปิดใช้งานข้อมูลนี้แทนหรือไม่?",
                      type: "warning",
                      showCancelButton: true,
                      closeOnConfirm: false,
                      closeOnCancel: true,
                      showLoaderOnConfirm: true
                    }, function (isConfirm) {
                      if (isConfirm) {
                        form.submit();
                      } else {
                        e.preventDefault();
                        swal({
                          title: "มีข้อผิดพลาด",
                          text: "",
                          timer: 3000,
                          type: "success",
                          showCancelButton: false,
                          showConfirmButton: false
                        });
                      }
                    });
                  } else if (res.data.data.status == "N") {
                    form.submit();
                  }

                  e.preventDefault();
                });

              case 3:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    }
  }
});

/***/ }),

/***/ "./resources/js/components/pm/MachineRelationComponent.vue":
/*!*****************************************************************!*\
  !*** ./resources/js/components/pm/MachineRelationComponent.vue ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _MachineRelationComponent_vue_vue_type_template_id_1467185e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./MachineRelationComponent.vue?vue&type=template&id=1467185e& */ "./resources/js/components/pm/MachineRelationComponent.vue?vue&type=template&id=1467185e&");
/* harmony import */ var _MachineRelationComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./MachineRelationComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/MachineRelationComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _MachineRelationComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _MachineRelationComponent_vue_vue_type_template_id_1467185e___WEBPACK_IMPORTED_MODULE_0__.render,
  _MachineRelationComponent_vue_vue_type_template_id_1467185e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/MachineRelationComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/MachineRelationComponent.vue?vue&type=script&lang=js&":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/pm/MachineRelationComponent.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MachineRelationComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./MachineRelationComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/MachineRelationComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MachineRelationComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/MachineRelationComponent.vue?vue&type=template&id=1467185e&":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/pm/MachineRelationComponent.vue?vue&type=template&id=1467185e& ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MachineRelationComponent_vue_vue_type_template_id_1467185e___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MachineRelationComponent_vue_vue_type_template_id_1467185e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MachineRelationComponent_vue_vue_type_template_id_1467185e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./MachineRelationComponent.vue?vue&type=template&id=1467185e& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/MachineRelationComponent.vue?vue&type=template&id=1467185e&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/MachineRelationComponent.vue?vue&type=template&id=1467185e&":
/*!***************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/MachineRelationComponent.vue?vue&type=template&id=1467185e& ***!
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
  return _c(
    "form",
    {
      attrs: { id: "submitForm", action: _vm.urlSave, method: "post" },
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
        ? _c("div", [
            _c("input", {
              attrs: { type: "hidden", name: "_method", value: "PUT" }
            })
          ])
        : _vm._e(),
      _vm._v(" "),
      _c("div", [
        _c("div", { staticClass: "container" }, [
          _c("div", { staticClass: "row" }, [
            _c(
              "div",
              { staticClass: "col" },
              [
                _vm._m(0),
                _vm._v(" "),
                _c("input", {
                  attrs: {
                    type: "hidden",
                    name: "machine_group",
                    autocomplete: "off"
                  },
                  domProps: { value: _vm.machine_group }
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
                      value: _vm.machine_group,
                      callback: function($$v) {
                        _vm.machine_group = $$v
                      },
                      expression: "machine_group"
                    }
                  },
                  _vm._l(_vm.machineGroups, function(group) {
                    return _c("el-option", {
                      key: group.lookup_code,
                      attrs: { label: group.meaning, value: group.lookup_code }
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
              { staticClass: "col" },
              [
                _vm._m(1),
                _vm._v(" "),
                _c("el-input", {
                  attrs: { name: "machine_set" },
                  on: {
                    input: function($event) {
                      return _vm.onlyNumeric()
                    }
                  },
                  model: {
                    value: _vm.machine_set,
                    callback: function($$v) {
                      _vm.machine_set = $$v
                    },
                    expression: "machine_set"
                  }
                })
              ],
              1
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "row mt-3" }, [
            _c(
              "div",
              { staticClass: "col" },
              [
                _vm._m(2),
                _vm._v(" "),
                _c("input", {
                  attrs: {
                    type: "hidden",
                    name: "machine_name",
                    autocomplete: "off"
                  },
                  domProps: { value: _vm.machine_name }
                }),
                _vm._v(" "),
                _c(
                  "el-select",
                  {
                    staticClass: "w-100",
                    attrs: {
                      "remote-method": _vm.getAsset,
                      filterable: "",
                      remote: "",
                      "reserve-keyword": "",
                      clearable: ""
                    },
                    on: {
                      change: function($event) {
                        return _vm.getData()
                      }
                    },
                    model: {
                      value: _vm.machine_name,
                      callback: function($$v) {
                        _vm.machine_name = $$v
                      },
                      expression: "machine_name"
                    }
                  },
                  _vm._l(_vm.assetList, function(asset) {
                    return _c("el-option", {
                      key: asset.asset_number,
                      attrs: {
                        label:
                          asset.asset_number + " : " + asset.asset_description,
                        value: asset.asset_number
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
              { staticClass: "col" },
              [
                _c("label", [_vm._v(" ประเภทเครื่องจักร ")]),
                _vm._v(" "),
                _c("el-input", {
                  attrs: { name: "machine_type", disabled: "" },
                  model: {
                    value: _vm.machine_type,
                    callback: function($$v) {
                      _vm.machine_type = $$v
                    },
                    expression: "machine_type"
                  }
                })
              ],
              1
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "row mt-3" }, [
            _c(
              "div",
              { staticClass: "col" },
              [
                _c("label", [_vm._v(" ขั้นตอนการทำงาน ")]),
                _vm._v(" "),
                _c("el-input", {
                  attrs: { name: "step_description", disabled: "" },
                  model: {
                    value: _vm.step_description,
                    callback: function($$v) {
                      _vm.step_description = $$v
                    },
                    expression: "step_description"
                  }
                })
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "col" },
              [
                _c("label", [
                  _vm._v(
                    " ความเร็วเครื่องจักร (" +
                      _vm._s(_vm.machine_speed_unit) +
                      ") "
                  )
                ]),
                _vm._v(" "),
                _c("el-input", {
                  attrs: { name: "machine_speed", disabled: "" },
                  model: {
                    value: _vm.machine_speed,
                    callback: function($$v) {
                      _vm.machine_speed = $$v
                    },
                    expression: "machine_speed"
                  }
                })
              ],
              1
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "row mt-3" }, [
            _c(
              "div",
              { staticClass: "col" },
              [
                _c("label", [_vm._v(" % ประสิทธิภาพของ EAM ")]),
                _vm._v(" "),
                _c("el-input", {
                  attrs: { name: "machine_eamperformance", disabled: "" },
                  model: {
                    value: _vm.machine_eamperformance,
                    callback: function($$v) {
                      _vm.machine_eamperformance = $$v
                    },
                    expression: "machine_eamperformance"
                  }
                })
              ],
              1
            ),
            _vm._v(" "),
            _c("div", { staticClass: "col" }, [
              _c("label", [_vm._v(" สถานะการใช้งาน ")]),
              _vm._v(" "),
              _c("div", [
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.pm_enable_flag,
                      expression: "pm_enable_flag"
                    }
                  ],
                  attrs: { type: "checkbox", name: "pm_enable_flag" },
                  domProps: {
                    checked: Array.isArray(_vm.pm_enable_flag)
                      ? _vm._i(_vm.pm_enable_flag, null) > -1
                      : _vm.pm_enable_flag
                  },
                  on: {
                    change: function($event) {
                      var $$a = _vm.pm_enable_flag,
                        $$el = $event.target,
                        $$c = $$el.checked ? true : false
                      if (Array.isArray($$a)) {
                        var $$v = null,
                          $$i = _vm._i($$a, $$v)
                        if ($$el.checked) {
                          $$i < 0 && (_vm.pm_enable_flag = $$a.concat([$$v]))
                        } else {
                          $$i > -1 &&
                            (_vm.pm_enable_flag = $$a
                              .slice(0, $$i)
                              .concat($$a.slice($$i + 1)))
                        }
                      } else {
                        _vm.pm_enable_flag = $$c
                      }
                    }
                  }
                })
              ])
            ])
          ])
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "col-12 mt-3" }, [
        _c("hr"),
        _vm._v(" "),
        _c("div", { staticClass: "row clearfix m-t-lg text-right" }, [
          _c("div", { staticClass: "col-sm-12" }, [
            _vm._m(3),
            _vm._v(" "),
            _c(
              "a",
              {
                staticClass: "btn btn-sm btn-warning",
                attrs: { href: this.urlReset, type: "button" }
              },
              [
                _c("i", { staticClass: "fa fa-times" }),
                _vm._v(" ยกเลิก\n        ")
              ]
            )
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
    return _c("label", [
      _vm._v(" กลุ่มชุดเครื่องจักร "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" เซ็ตเครื่องจักร "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" รหัสเครื่องจักร "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "button",
      { staticClass: "btn btn-sm btn-primary", attrs: { type: "submit" } },
      [_c("i", { staticClass: "fa fa-save" }), _vm._v(" บันทึก\n        ")]
    )
  }
]
render._withStripped = true



/***/ })

}]);