(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_lookup_SelectComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/lookup/SelectComponent.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/lookup/SelectComponent.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['dataName', 'dataLists', 'defaultValue', 'old', 'programCode', 'programColumn'],
  data: function data() {
    return {
      data_value: this.old ? this.old : this.defaultValue ? this.defaultValue : '',
      remote_flag: false,
      data_Lists: this.dataLists
    };
  },
  mounted: function mounted() {
    var _this = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              console.log(_this.programColumn.remote_search, '<================== this.programColumn.remote_search');
              _context.next = 3;
              return _this.getDataList();

            case 3:
              console.log(_this.programColumn.remote_search);

            case 4:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  methods: {
    handleChange: function handleChange() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                if (_this2.programCode === 'PMS0014' && _this2.programColumn.column_name === 'ATTRIBUTE2') {
                  _.each(_this2.$parent.$children, /*#__PURE__*/function () {
                    var _ref = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2(el, k) {
                      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
                        while (1) {
                          switch (_context2.prev = _context2.next) {
                            case 0:
                              if (el.dataName == 'ATTRIBUTE1') {
                                console.log(_this2.$parent.$children[k]);
                                _this2.$parent.$children[k].$data.data_Lists = [];
                                _this2.$parent.$children[k].$data.data_value = '';
                                setTimeout(function () {
                                  _this2.$parent.$children[k].getDataList();
                                }, 1000);
                              }

                            case 1:
                            case "end":
                              return _context2.stop();
                          }
                        }
                      }, _callee2);
                    }));

                    return function (_x, _x2) {
                      return _ref.apply(this, arguments);
                    };
                  }());
                }

              case 1:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    getDataList: function getDataList(query) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        var data_vaue;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                if (!_this3.programColumn.remote_search) {
                  _context4.next = 5;
                  break;
                }

                data_vaue = '';

                if (_this3.programCode === 'PMS0014' && _this3.programColumn.column_name === 'ATTRIBUTE1') {
                  data_vaue = $('input[name="ATTRIBUTE2"]').val();
                } else {
                  data_vaue = _this3.data_value;
                }

                _context4.next = 5;
                return axios.get("/lookup/search", {
                  params: {
                    program_code: _this3.programCode,
                    program_column: _this3.dataName,
                    search: query,
                    id: data_vaue
                  }
                }).then(function (res) {
                  Vue.set(_this3, 'data_Lists', res.data);
                })["catch"](function (err) {
                  console.log(err);
                });

              case 5:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    sortArrays: function sortArrays(arrays) {
      return _.orderBy(arrays, 'label', 'asc');
    }
  }
});

/***/ }),

/***/ "./resources/js/components/lookup/SelectComponent.vue":
/*!************************************************************!*\
  !*** ./resources/js/components/lookup/SelectComponent.vue ***!
  \************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _SelectComponent_vue_vue_type_template_id_485822b7___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SelectComponent.vue?vue&type=template&id=485822b7& */ "./resources/js/components/lookup/SelectComponent.vue?vue&type=template&id=485822b7&");
/* harmony import */ var _SelectComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SelectComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/lookup/SelectComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _SelectComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _SelectComponent_vue_vue_type_template_id_485822b7___WEBPACK_IMPORTED_MODULE_0__.render,
  _SelectComponent_vue_vue_type_template_id_485822b7___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/lookup/SelectComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/lookup/SelectComponent.vue?vue&type=script&lang=js&":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/lookup/SelectComponent.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SelectComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SelectComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/lookup/SelectComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SelectComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/lookup/SelectComponent.vue?vue&type=template&id=485822b7&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/components/lookup/SelectComponent.vue?vue&type=template&id=485822b7& ***!
  \*******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SelectComponent_vue_vue_type_template_id_485822b7___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SelectComponent_vue_vue_type_template_id_485822b7___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SelectComponent_vue_vue_type_template_id_485822b7___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SelectComponent.vue?vue&type=template&id=485822b7& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/lookup/SelectComponent.vue?vue&type=template&id=485822b7&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/lookup/SelectComponent.vue?vue&type=template&id=485822b7&":
/*!**********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/lookup/SelectComponent.vue?vue&type=template&id=485822b7& ***!
  \**********************************************************************************************************************************************************************************************************************************/
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
      _c("input", {
        attrs: { type: "hidden", name: this.dataName, autocomplete: "off" },
        domProps: { value: _vm.data_value }
      }),
      _vm._v(" "),
      _vm.programColumn.remote_search !== null
        ? _c(
            "el-select",
            {
              staticClass: "w-100",
              attrs: {
                filterable: "",
                remote: "",
                "reserve-keyword": "",
                clearable: "",
                "remote-method": _vm.getDataList
              },
              model: {
                value: _vm.data_value,
                callback: function($$v) {
                  _vm.data_value = $$v
                },
                expression: "data_value"
              }
            },
            _vm._l(_vm.sortArrays(this.data_Lists), function(list) {
              return _c("el-option", {
                key: list.value,
                attrs: { label: list.label, value: list.value }
              })
            }),
            1
          )
        : _c(
            "el-select",
            {
              staticClass: "w-100",
              attrs: {
                filterable: "",
                remote: "",
                "reserve-keyword": "",
                clearable: ""
              },
              on: { change: _vm.handleChange },
              model: {
                value: _vm.data_value,
                callback: function($$v) {
                  _vm.data_value = $$v
                },
                expression: "data_value"
              }
            },
            _vm._l(_vm.sortArrays(this.data_Lists), function(list) {
              return _c("el-option", {
                key: list.value,
                attrs: { label: list.label, value: list.value }
              })
            }),
            1
          )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);