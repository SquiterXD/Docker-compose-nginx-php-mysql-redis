(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_UserComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/UserComponent.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/UserComponent.vue?vue&type=script&lang=js& ***!
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["pUser", "pRouteList", "pRoleList", "pOrgList"],
  data: function data() {
    return {
      user: null,
      email: null,
      oaUserId: this.pUser != undefined && this.pUser != '' ? parseInt(this.pUser.fnd_user_id) : '',
      loading: false,
      username: this.pUser != undefined && this.pUser != '' ? this.pUser.username : '',
      orgId: this.pUser != undefined && this.pUser != '' ? this.pUser.organization_id : '',
      users: [],
      oaUserList: [],
      roleList: this.pUser != undefined && this.pUser != '' ? this.pUser.role_options : '',
      invOrgOptions: [],
      assignDeptList: {}
    };
  },
  mounted: function mounted() {
    // this.addRow();
    // this.addAssignDeptList();
    // if (this.roleId !== "") {
    //     this.getRoleHasPermision();
    // } else {
    //     this.roleHasPermisions = [];
    // }
    if (this.username != '') {
      this.getUsers({
        username: this.username
      });
    }

    if (this.oaUserId != '') {
      this.getOAUser({
        user_id: this.oaUserId
      });
    }

    if (this.pUser && this.pUser.department_options.length > 0) {
      this.assignDeptList = this.pUser.department_options;
    }

    if (this.pUser && this.pUser.inv_org_options.length > 0) {
      this.invOrgOptions = this.pUser.inv_org_options;
    }

    if (this.pUser && this.pUser.role_options.length > 0) {
      this.roleList = this.pUser.role_options;
    }
  },
  methods: {
    addAssignDeptList: function addAssignDeptList() {
      // let row = Object.keys(this.assignDeptList).length + 1;
      var max = 0;

      for (var property in this.assignDeptList) {
        max = max < parseFloat(property) ? parseFloat(property) : max;
      }

      this.$set(this.assignDeptList, max + 1, {
        department_list: [],
        department_code: null,
        end_date: null
      });
    },
    delAssignDeptList: function delAssignDeptList(index) {
      this.$delete(this.assignDeptList, index);
    },
    remoteMethodOAUser: function remoteMethodOAUser(query) {
      if (query !== "") {
        this.getOAUser({
          name: query
        });
      } else {}
    },
    getOAUser: function getOAUser(params) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var data;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                data = [];
                _context.next = 3;
                return axios.get(_this.pRouteList.ajax_get_oa_user, {
                  params: params
                }).then(function (res) {
                  data = res.data.data;
                });

              case 3:
                _this.oaUserList = data;

              case 4:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    remoteMethodDept: function remoteMethodDept(query, index) {
      if (query !== "") {
        this.getDepartment({
          name: query
        }, index);
      } else {// this.assignDeptList[index].department_list = [];
      }
    },
    getDepartment: function getDepartment(params, index) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var data;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                data = [];
                _context2.next = 3;
                return axios.get(_this2.pRouteList.ajax_get_department, {
                  params: params
                }).then(function (res) {
                  data = res.data.data;
                });

              case 3:
                _this2.assignDeptList[index].department_list = data;

              case 4:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    remoteMethod: function remoteMethod(query) {
      if (query !== "") {
        this.getUsers({
          name: query
        });
      } else {
        this.users = [];
      }
    },
    getUsers: function getUsers(params) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _this3.user = null;
                _this3.loading = true;
                axios.get(_this3.pRouteList.ajax_get_user, {
                  params: params
                }).then(function (res) {
                  _this3.loading = false;
                  _this3.users = res.data.data;

                  _this3.setUser();
                });

              case 3:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    setUser: function setUser() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        var userFilter;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                if (_this4.username && _this4.users.length > 0) {
                  userFilter = _this4.users.filter(function (userData) {
                    return userData.username == _this4.username;
                  });
                  _this4.user = userFilter[0];
                  _this4.email = _this4.user.email;
                } else {
                  _this4.user = null;
                }

              case 1:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    save: function save() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        var name, password, departmentCode;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                if (!(_this5.pUser == '')) {
                  _context5.next = 5;
                  break;
                }

                _context5.next = 3;
                return axios.post(_this5.pRouteList.ajax_users_store, {
                  name: _this5.user.first_name + ' ' + _this5.user.last_name,
                  username: _this5.username,
                  email: _this5.email,
                  password: _this5.user.id_card,
                  department_code: _this5.user.dept_code_account,
                  fnd_user_id: _this5.oaUserId,
                  role_options: _this5.roleList,
                  inv_org_options: _this5.invOrgOptions,
                  department_options: _this5.assignDeptList,
                  organization_id: _this5.orgId
                }).then(function (res) {
                  if (res.data.data.status == 'S') {
                    window.location.href = _this5.pRouteList.users_index;
                  }
                });

              case 3:
                _context5.next = 11;
                break;

              case 5:
                // console.log('url', this.pRouteList.ajax_users_update);
                name = _this5.pUser.name;
                password = '';
                departmentCode = _this5.pUser.department_code;

                if (_this5.user) {
                  name = _this5.user.first_name + ' ' + _this5.user.last_name;
                  password = _this5.user.id_card;
                  departmentCode = _this5.user.dept_code_account;
                }

                _context5.next = 11;
                return axios.patch(_this5.pRouteList.ajax_users_update, {
                  username: _this5.username,
                  name: name,
                  email: _this5.email,
                  password: password,
                  department_code: departmentCode,
                  fnd_user_id: _this5.oaUserId,
                  role_options: _this5.roleList,
                  inv_org_options: _this5.invOrgOptions,
                  department_options: _this5.assignDeptList,
                  organization_id: _this5.orgId
                }).then(function (res) {
                  if (res.data.data.status == 'S') {
                    window.location.href = _this5.pRouteList.users_index;
                  }
                });

              case 11:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    }
  }
});

/***/ }),

/***/ "./resources/js/components/UserComponent.vue":
/*!***************************************************!*\
  !*** ./resources/js/components/UserComponent.vue ***!
  \***************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _UserComponent_vue_vue_type_template_id_7f050fd2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./UserComponent.vue?vue&type=template&id=7f050fd2& */ "./resources/js/components/UserComponent.vue?vue&type=template&id=7f050fd2&");
/* harmony import */ var _UserComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./UserComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/UserComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _UserComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _UserComponent_vue_vue_type_template_id_7f050fd2___WEBPACK_IMPORTED_MODULE_0__.render,
  _UserComponent_vue_vue_type_template_id_7f050fd2___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/UserComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/UserComponent.vue?vue&type=script&lang=js&":
/*!****************************************************************************!*\
  !*** ./resources/js/components/UserComponent.vue?vue&type=script&lang=js& ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_UserComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./UserComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/UserComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_UserComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/UserComponent.vue?vue&type=template&id=7f050fd2&":
/*!**********************************************************************************!*\
  !*** ./resources/js/components/UserComponent.vue?vue&type=template&id=7f050fd2& ***!
  \**********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_UserComponent_vue_vue_type_template_id_7f050fd2___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_UserComponent_vue_vue_type_template_id_7f050fd2___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_UserComponent_vue_vue_type_template_id_7f050fd2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./UserComponent.vue?vue&type=template&id=7f050fd2& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/UserComponent.vue?vue&type=template&id=7f050fd2&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/UserComponent.vue?vue&type=template&id=7f050fd2&":
/*!*************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/UserComponent.vue?vue&type=template&id=7f050fd2& ***!
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
  return _c(
    "div",
    [
      _c("div", { staticClass: "row" }, [
        _c(
          "div",
          {
            staticClass:
              "form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2"
          },
          [
            _vm._m(0),
            _vm._v(" "),
            _c(
              "el-select",
              {
                staticStyle: { width: "100%" },
                attrs: {
                  disabled: _vm.pUser != "",
                  filterable: "",
                  clearable: "",
                  remote: "",
                  placeholder: "ชื่อ หรือ นามสกุล",
                  "remote-method": _vm.remoteMethod,
                  loading: _vm.loading
                },
                on: { change: _vm.setUser },
                model: {
                  value: _vm.username,
                  callback: function($$v) {
                    _vm.username = $$v
                  },
                  expression: "username"
                }
              },
              _vm._l(_vm.users, function(user) {
                return _c("el-option", {
                  key: user.lable,
                  attrs: { label: user.lable, value: user.username }
                })
              }),
              1
            )
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row" }, [
        _c(
          "div",
          {
            staticClass:
              "form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2"
          },
          [
            _vm._m(1),
            _vm._v(" "),
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.email,
                  expression: "email"
                }
              ],
              staticClass: "form-control col-12",
              attrs: {
                placeholder: "Email",
                autocomplete: "off",
                type: "text",
                disabled: ""
              },
              domProps: { value: _vm.email },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.email = $event.target.value
                }
              }
            })
          ]
        )
      ]),
      _vm._v(" "),
      _c(
        "transition",
        {
          attrs: {
            "enter-active-class": "animated fadeInUp",
            "leave-active-class": "animated fadeOutDown"
          }
        },
        [
          _vm.user != null
            ? _c("div", { staticClass: "row " }, [
                _c(
                  "div",
                  {
                    staticClass:
                      "form-group pl-12 pr-2 mb-0 col-lg-3 col-md-3 col-sm-3 col-xs-3 offset-md-3 mt-2"
                  },
                  [
                    _c("div", { staticClass: "control-label" }, [
                      _c("strong", [_vm._v("HR: First Name ")])
                    ]),
                    _vm._v(" "),
                    _c("p", { staticClass: "text-muted pl-3 mb-0" }, [
                      _c("strong", [
                        _vm._v(" " + _vm._s(_vm.user.first_name) + " ")
                      ])
                    ])
                  ]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    staticClass:
                      "form-group pl-12 pr-2 mb-0 col-lg-3 col-md-3 col-sm-3 col-xs-3 mt-2"
                  },
                  [
                    _c("div", { staticClass: "control-label " }, [
                      _c("strong", [_vm._v("HR: Last Name ")])
                    ]),
                    _vm._v(" "),
                    _c("p", { staticClass: "text-muted pl-3 mb-0" }, [
                      _c("strong", [
                        _vm._v(" " + _vm._s(_vm.user.last_name) + " ")
                      ])
                    ])
                  ]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    staticClass:
                      "form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6  offset-md-3 mt-2"
                  },
                  [
                    _c("div", { staticClass: "control-label " }, [
                      _c("strong", [_vm._v("HR: Department Code ")])
                    ]),
                    _vm._v(" "),
                    _c("p", { staticClass: "text-muted pl-3 mb-0" }, [
                      _c("strong", [
                        _vm._v(" " + _vm._s(_vm.user.dept_code_account) + " ")
                      ])
                    ]),
                    _vm._v(" "),
                    _vm.pUser != "" &&
                    _vm.user.dept_code_account != _vm.pUser.department_code
                      ? _c("div", { staticClass: "mt-2" }, [
                          _c(
                            "button",
                            {
                              staticClass: "btn btn-w-m btn-primary",
                              attrs: { type: "button" },
                              on: { click: _vm.save }
                            },
                            [
                              _vm._v(
                                "\n                        อัพเดท Department Code\n                    "
                              )
                            ]
                          )
                        ])
                      : _vm._e()
                  ]
                )
              ])
            : _vm._e()
        ]
      ),
      _vm._v(" "),
      _vm._m(2),
      _vm._v(" "),
      _c("div", { staticClass: "row " }, [
        _c(
          "div",
          {
            staticClass:
              "form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 text-right"
          },
          [
            _c(
              "button",
              {
                staticClass: "btn btn-w-m btn-primary",
                attrs: { type: "button" },
                on: { click: _vm.addAssignDeptList }
              },
              [
                _c("i", { staticClass: "fa fa-plus" }),
                _vm._v(" Add Dept.\n            ")
              ]
            )
          ]
        )
      ]),
      _vm._v(" "),
      _vm._l(_vm.assignDeptList, function(assign, index) {
        return _c("div", { staticClass: "row " }, [
          _c(
            "div",
            {
              staticClass:
                "form-group pl-12 pr-2 mb-0 col-lg-3 col-md-3 col-sm-3 col-xs-3 offset-md-3 mt-2"
            },
            [
              _vm._m(3, true),
              _vm._v(" "),
              _c(
                "el-select",
                {
                  staticStyle: { width: "100%" },
                  attrs: {
                    filterable: "",
                    clearable: "",
                    remote: "",
                    placeholder: "Department Code",
                    "remote-method": function(data) {
                      return _vm.remoteMethodDept(data, index)
                    },
                    loading: _vm.loading
                  },
                  model: {
                    value: assign.department_code,
                    callback: function($$v) {
                      _vm.$set(assign, "department_code", $$v)
                    },
                    expression: "assign.department_code"
                  }
                },
                _vm._l(assign.department_list, function(dept) {
                  return _c("el-option", {
                    key: dept.description,
                    attrs: {
                      label: dept.description,
                      value: dept.department_code
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
            {
              staticClass:
                "form-group pl-12 pr-2 mb-0 col-lg-3 col-md-3 col-sm-3 col-xs-3 mt-2"
            },
            [
              _vm._m(4, true),
              _vm._v(" "),
              _c("el-date-picker", {
                staticStyle: { width: "100%" },
                attrs: { type: "date", placeholder: "Pick a day" },
                model: {
                  value: assign.end_date,
                  callback: function($$v) {
                    _vm.$set(assign, "end_date", $$v)
                  },
                  expression: "assign.end_date"
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass:
                "form-group text-left pl-12 pr-2 mb-0 col-lg-1 col-md-1 col-sm-1 col-xs-1 mt-2"
            },
            [
              _c("div", { staticClass: "control-label mb-2" }, [
                _vm._v("\n                 \n            ")
              ]),
              _vm._v(" "),
              _c(
                "a",
                {
                  staticStyle: { cursor: "pointer" },
                  on: {
                    click: function($event) {
                      return _vm.delAssignDeptList(index)
                    }
                  }
                },
                [
                  _c("i", {
                    staticClass: "fa fa-times-circle fa-2x text-danger"
                  })
                ]
              )
            ]
          )
        ])
      }),
      _vm._v(" "),
      _c("div", { staticClass: "row" }, [
        _c(
          "div",
          {
            staticClass:
              "form-group pl-12 pr-2 mb-0 col-lg-3 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2"
          },
          [
            _vm._m(5),
            _vm._v(" "),
            _c(
              "el-select",
              {
                staticStyle: { width: "100%" },
                attrs: {
                  filterable: "",
                  clearable: "",
                  remote: "",
                  placeholder: "",
                  "remote-method": _vm.remoteMethodOAUser,
                  loading: _vm.loading
                },
                model: {
                  value: _vm.oaUserId,
                  callback: function($$v) {
                    _vm.oaUserId = $$v
                  },
                  expression: "oaUserId"
                }
              },
              _vm._l(_vm.oaUserList, function(oaUser) {
                return _c("el-option", {
                  key: oaUser.user_name,
                  attrs: { label: oaUser.user_name, value: oaUser.user_id }
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
          {
            staticClass:
              "form-group pl-12 pr-2 mb-0 col-lg-3 col-md-6 col-sm-6 col-xs-6  mt-2"
          },
          [
            _vm._m(6),
            _vm._v(" "),
            _c(
              "el-select",
              {
                staticStyle: { width: "100%" },
                attrs: { filterable: "", clearable: "", placeholder: "" },
                model: {
                  value: _vm.orgId,
                  callback: function($$v) {
                    _vm.orgId = $$v
                  },
                  expression: "orgId"
                }
              },
              _vm._l(_vm.pOrgList, function(org, i) {
                return _c("el-option", {
                  key: i,
                  attrs: { label: org, value: i }
                })
              }),
              1
            )
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row" }, [
        _c(
          "div",
          {
            staticClass:
              "form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2"
          },
          [
            _vm._m(7),
            _vm._v(" "),
            _c(
              "el-select",
              {
                staticStyle: { width: "100%" },
                attrs: {
                  multiple: "",
                  filterable: "",
                  clearable: "",
                  remote: "",
                  placeholder: ""
                },
                model: {
                  value: _vm.roleList,
                  callback: function($$v) {
                    _vm.roleList = $$v
                  },
                  expression: "roleList"
                }
              },
              _vm._l(_vm.pRoleList, function(role, index) {
                return _c("el-option", {
                  key: role,
                  attrs: { label: role, value: index }
                })
              }),
              1
            )
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row" }, [
        _c(
          "div",
          {
            staticClass:
              "form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2"
          },
          [
            _vm._m(8),
            _vm._v(" "),
            _c(
              "el-select",
              {
                staticStyle: { width: "100%" },
                attrs: {
                  multiple: "",
                  filterable: "",
                  clearable: "",
                  remote: "",
                  placeholder: ""
                },
                model: {
                  value: _vm.invOrgOptions,
                  callback: function($$v) {
                    _vm.invOrgOptions = $$v
                  },
                  expression: "invOrgOptions"
                }
              },
              _vm._l(_vm.pOrgList, function(org, i) {
                return _c("el-option", {
                  key: i,
                  attrs: { label: org, value: i }
                })
              }),
              1
            )
          ],
          1
        )
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
                attrs: { href: _vm.pRouteList.users_index, type: "button" }
              },
              [_vm._v(" Cancel ")]
            )
          ])
        ])
      ])
    ],
    2
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "control-label mb-2" }, [
      _c("strong", [_vm._v(" Username ")]),
      _vm._v(" "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "control-label mb-2" }, [
      _c("strong", [_vm._v(" Email ")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "row " }, [
      _c(
        "div",
        {
          staticClass:
            "form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2"
        },
        [_c("div", { staticClass: "hr-line-dashed" })]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "control-label" }, [
      _c("strong", [_vm._v(" Department Code ")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "control-label " }, [
      _c("strong", [_vm._v(" End Date ")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "control-label mb-2" }, [
      _c("strong", [_vm._v(" OA User ")]),
      _vm._v(" "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "control-label mb-2" }, [
      _c("strong", [_vm._v(" Organization Control ")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "control-label mb-2" }, [
      _c("strong", [_vm._v(" Role ")]),
      _vm._v(" "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "control-label mb-2" }, [
      _c("strong", [_vm._v("Assign Org")])
    ])
  }
]
render._withStripped = true



/***/ })

}]);