(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_RoleComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/RoleComponent.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/RoleComponent.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************************/
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
  props: ["pModuleList", "pRole", "pMenuByModuleRoute", "pPermissionRoute", "pAssignPermissionRoute", "pRoleRoute", "pRoleStoreRoute", "pRoleUpdateRoute"],
  data: function data() {
    return {
      roleId: this.pRole != undefined && this.pRole != '' ? parseInt(this.pRole.role_id) : '',
      roleName: this.pRole != undefined && this.pRole != '' ? this.pRole.name : '',
      // moduleName: (this.pModuleName != undefined && this.pModuleName != '') ? parseInt(this.pModuleName) : '',
      moduleName: this.pRole != undefined && this.pRole != '' ? this.pRole.module_name : '',
      loading: false,
      menus: [],
      disabled: this.pDisabled ? true : false,
      roleHasPermisions: [],
      permissionList: {}
    };
  },
  mounted: function mounted() {
    if (this.roleId !== "") {
      this.getRoleHasPermision();
    } else {
      this.roleHasPermisions = [];
    }
  },
  methods: {
    getMenus: function getMenus() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this.permissionList = {};

                if (!_this.moduleName) {
                  _context.next = 7;
                  break;
                }

                _this.loading = true;
                _context.next = 5;
                return axios.get(_this.pMenuByModuleRoute + "?module=" + _this.moduleName).then(function (res) {
                  var response = res.data;
                  var menusData = response.data;

                  for (var index in menusData) {
                    _this.loopPerm(menusData[index].permissions);

                    var secondMenu = menusData[index].children_menus;

                    for (var index2 in secondMenu) {
                      _this.loopPerm(secondMenu[index2].permissions);

                      var thirdMenu = secondMenu[index2].children_menus;

                      for (var index3 in thirdMenu) {
                        _this.loopPerm(thirdMenu[index3].permissions);
                      }
                    }
                  }

                  _this.menus = menusData;
                  _this.loading = false;
                });

              case 5:
                _context.next = 8;
                break;

              case 7:
                _this.menus = [];

              case 8:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getRoleHasPermision: function getRoleHasPermision() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _context2.next = 2;
                return axios.get(_this2.pPermissionRoute + "?role_id=" + _this2.roleId).then(function (res) {
                  var response = res.data;
                  _this2.roleHasPermisions = response.data;

                  _this2.getMenus();
                });

              case 2:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    loopPerm: function loopPerm(permissions) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var index;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                if (!(permissions.length == 0)) {
                  _context3.next = 2;
                  break;
                }

                return _context3.abrupt("return");

              case 2:
                for (index in permissions) {
                  _this3.checkHasPerm(permissions[index]);
                }

              case 3:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    checkHasPerm: function checkHasPerm(permission) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        var hasPermission, data;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                if (!(permission.has_permission != undefined)) {
                  _context4.next = 2;
                  break;
                }

                return _context4.abrupt("return");

              case 2:
                hasPermission = false;

                if (!(_this4.roleHasPermisions.length > 0)) {
                  _context4.next = 10;
                  break;
                }

                _context4.next = 6;
                return _this4.roleHasPermisions.filter(function (o) {
                  return o.name === permission.name;
                });

              case 6:
                data = _context4.sent;

                if (data.length > 0) {
                  hasPermission = true;
                } else {
                  hasPermission = false;
                }

                _context4.next = 11;
                break;

              case 10:
                hasPermission = false;

              case 11:
                _this4.$set(permission, 'has_permission', hasPermission);

              case 12:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    changePerm: function changePerm(permission) {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        var url;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                if (!(_this5.roleId == '')) {
                  _context5.next = 3;
                  break;
                }

                if (permission.has_permission) {
                  _this5.permissionList[permission.permission_id] = permission;
                } else {
                  delete _this5.permissionList[permission.permission_id];
                }

                return _context5.abrupt("return");

              case 3:
                // let url = this.pAssignPermissionRoute.replaceAll('xxx', this.roleId);
                url = _this5.pAssignPermissionRoute;
                _context5.next = 6;
                return axios.post(url, {
                  permission_id: permission.permission_id,
                  is_checked: permission.has_permission
                }).then(function (res) {
                  if (res.data.data.status != 'S') {
                    _this5.$set(permission, 'has_permission', !permission.has_permission);
                  }
                });

              case 6:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    save: function save() {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                if (!(_this6.roleId == "")) {
                  _context6.next = 5;
                  break;
                }

                _context6.next = 3;
                return axios.post(_this6.pRoleStoreRoute, {
                  role_name: _this6.roleName,
                  module_name: _this6.moduleName,
                  permission_list: _this6.permissionList
                }).then(function (res) {
                  if (res.data.data.status == 'S') {
                    location.href = _this6.pRoleRoute;
                  }
                });

              case 3:
                _context6.next = 7;
                break;

              case 5:
                _context6.next = 7;
                return axios.patch(_this6.pRoleUpdateRoute, {
                  role_name: _this6.roleName
                }).then(function (res) {
                  if (res.data.data.status == 'S') {
                    location.href = _this6.pRoleRoute;
                  }
                });

              case 7:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      }))();
    }
  }
});

/***/ }),

/***/ "./resources/js/components/RoleComponent.vue":
/*!***************************************************!*\
  !*** ./resources/js/components/RoleComponent.vue ***!
  \***************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _RoleComponent_vue_vue_type_template_id_44f5114c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./RoleComponent.vue?vue&type=template&id=44f5114c& */ "./resources/js/components/RoleComponent.vue?vue&type=template&id=44f5114c&");
/* harmony import */ var _RoleComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./RoleComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/RoleComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _RoleComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _RoleComponent_vue_vue_type_template_id_44f5114c___WEBPACK_IMPORTED_MODULE_0__.render,
  _RoleComponent_vue_vue_type_template_id_44f5114c___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/RoleComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/RoleComponent.vue?vue&type=script&lang=js&":
/*!****************************************************************************!*\
  !*** ./resources/js/components/RoleComponent.vue?vue&type=script&lang=js& ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_RoleComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./RoleComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/RoleComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_RoleComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/RoleComponent.vue?vue&type=template&id=44f5114c&":
/*!**********************************************************************************!*\
  !*** ./resources/js/components/RoleComponent.vue?vue&type=template&id=44f5114c& ***!
  \**********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_RoleComponent_vue_vue_type_template_id_44f5114c___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_RoleComponent_vue_vue_type_template_id_44f5114c___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_RoleComponent_vue_vue_type_template_id_44f5114c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./RoleComponent.vue?vue&type=template&id=44f5114c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/RoleComponent.vue?vue&type=template&id=44f5114c&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/RoleComponent.vue?vue&type=template&id=44f5114c&":
/*!*************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/RoleComponent.vue?vue&type=template&id=44f5114c& ***!
  \*************************************************************************************************************************************************************************************************************************/
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
      _c("div", { staticClass: "col-sm-4 b-r" }, [
        _c("form", { attrs: { role: "form" } }, [
          _c("div", { staticClass: "form-group" }, [
            _c("label", [_vm._v("Role Name")]),
            _vm._v(" "),
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.roleName,
                  expression: "roleName"
                }
              ],
              staticClass: "form-control",
              attrs: { type: "text", placeholder: "" },
              domProps: { value: _vm.roleName },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.roleName = $event.target.value
                }
              }
            })
          ]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "form-group" },
            [
              _c("label", [_vm._v("Module Name ")]),
              _vm._v(" "),
              _c(
                "el-select",
                {
                  staticStyle: { width: "100%" },
                  attrs: {
                    size: "small",
                    filterable: "",
                    disabled: _vm.roleId != "",
                    remote: "",
                    clearable: "",
                    placeholder: "",
                    loading: _vm.loading
                  },
                  on: { change: _vm.getMenus },
                  model: {
                    value: _vm.moduleName,
                    callback: function($$v) {
                      _vm.moduleName = $$v
                    },
                    expression: "moduleName"
                  }
                },
                _vm._l(_vm.pModuleList, function(module) {
                  return _c("el-option", {
                    key: module,
                    attrs: { label: module, value: module }
                  })
                }),
                1
              )
            ],
            1
          )
        ])
      ]),
      _vm._v(" "),
      _c(
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
          staticClass: "col-sm-8"
        },
        [
          _c("table", { staticClass: "table" }, [
            _vm._m(0),
            _vm._v(" "),
            _c(
              "tbody",
              [
                _vm._l(_vm.menus, function(menu) {
                  return [
                    _c("tr", [
                      _c("td", [
                        _c("h3", { staticClass: "no-margins pb-2" }, [
                          _c("strong", { staticClass: "text-navy" }, [
                            _vm._v(_vm._s(menu.menu_title))
                          ])
                        ])
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "text-center" }, [
                        menu.children_menus.length == 0
                          ? _c(
                              "div",
                              [
                                _vm._l(menu.permissions, function(perm) {
                                  return [
                                    _c("el-switch", {
                                      on: {
                                        change: function($event) {
                                          return _vm.changePerm(perm)
                                        }
                                      },
                                      model: {
                                        value: perm.has_permission,
                                        callback: function($$v) {
                                          _vm.$set(perm, "has_permission", $$v)
                                        },
                                        expression: "perm.has_permission"
                                      }
                                    }),
                                    _vm._v(
                                      "  \n                                    "
                                    )
                                  ]
                                })
                              ],
                              2
                            )
                          : _vm._e()
                      ])
                    ]),
                    _vm._v(" "),
                    _vm._l(menu.children_menus, function(secondMenu) {
                      return [
                        _c("tr", [
                          _c("td", [
                            _c("div", { staticClass: "pl-4" }, [
                              _c("div", { staticClass: "pb-1" }, [
                                _c("i", {
                                  staticClass:
                                    "fa fa-arrow-circle-o-right text-muted"
                                }),
                                _vm._v(
                                  "\n                                        " +
                                    _vm._s(secondMenu.program_code) +
                                    "\n                                        " +
                                    _vm._s(secondMenu.menu_title) +
                                    "\n                                    "
                                )
                              ])
                            ])
                          ]),
                          _vm._v(" "),
                          _c("td", { staticClass: "text-center" }, [
                            secondMenu.children_menus.length == 0
                              ? _c(
                                  "div",
                                  [
                                    _vm._l(secondMenu.permissions, function(
                                      perm
                                    ) {
                                      return [
                                        _c("el-switch", {
                                          on: {
                                            change: function($event) {
                                              return _vm.changePerm(perm)
                                            }
                                          },
                                          model: {
                                            value: perm.has_permission,
                                            callback: function($$v) {
                                              _vm.$set(
                                                perm,
                                                "has_permission",
                                                $$v
                                              )
                                            },
                                            expression: "perm.has_permission"
                                          }
                                        }),
                                        _vm._v(
                                          "  \n                                    "
                                        )
                                      ]
                                    })
                                  ],
                                  2
                                )
                              : _vm._e()
                          ])
                        ]),
                        _vm._v(" "),
                        _vm._l(secondMenu.children_menus, function(thirdMenu) {
                          return [
                            _c("tr", [
                              _c("td", [
                                _c("div", { staticClass: "pl-4 ml-4" }, [
                                  _c("div", { staticClass: "pb-1" }, [
                                    _c("i", {
                                      staticClass:
                                        "fa fa-arrow-circle-o-right text-muted"
                                    }),
                                    _vm._v(
                                      "\n                                            " +
                                        _vm._s(thirdMenu.program_code) +
                                        "\n                                            " +
                                        _vm._s(thirdMenu.menu_title) +
                                        "\n                                        "
                                    )
                                  ])
                                ])
                              ]),
                              _vm._v(" "),
                              _c(
                                "td",
                                { staticClass: "text-center" },
                                [
                                  _vm._l(thirdMenu.permissions, function(perm) {
                                    return [
                                      _c("el-switch", {
                                        on: {
                                          change: function($event) {
                                            return _vm.changePerm(perm)
                                          }
                                        },
                                        model: {
                                          value: perm.has_permission,
                                          callback: function($$v) {
                                            _vm.$set(
                                              perm,
                                              "has_permission",
                                              $$v
                                            )
                                          },
                                          expression: "perm.has_permission"
                                        }
                                      }),
                                      _vm._v(
                                        "  \n                                    "
                                      )
                                    ]
                                  })
                                ],
                                2
                              )
                            ])
                          ]
                        })
                      ]
                    })
                  ]
                })
              ],
              2
            )
          ])
        ]
      ),
      _vm._v(" "),
      _c("div", { staticClass: "col-12 mt-3" }, [
        _c("hr"),
        _vm._v(" "),
        _c("div", { staticClass: "row clearfix m-t-lg text-right" }, [
          _c("div", { staticClass: "col-sm-12" }, [
            _c(
              "button",
              {
                staticClass: "btn btn-sm btn-primary",
                attrs: { type: "button" },
                on: { click: _vm.save }
              },
              [_vm._v(" Save ")]
            ),
            _vm._v(" "),
            _c(
              "a",
              {
                staticClass: "btn btn-sm btn-white",
                attrs: { href: _vm.pRoleRoute, type: "button" }
              },
              [_vm._v(" Cancel ")]
            )
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
    return _c("thead", [
      _c("tr", [
        _c("th", [_vm._v("Menu")]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "20%" } }, [
          _vm._v(
            "\n                            Enter | View\n                        "
          )
        ])
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);