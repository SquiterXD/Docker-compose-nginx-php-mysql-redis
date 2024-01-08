(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_qm_DefineTests_SearchComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/DefineTests/SearchComponent.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/DefineTests/SearchComponent.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['btnTrans', 'resultSeverites', 'units', 'search', 'testDescList', 'testTypeCode', 'processTestList', 'entityTestList', 'processDistinctTestList'],
  data: function data() {
    return {
      arraySearch: {
        resultSeverites: this.search.resultSeverites ? this.search.resultSeverites : '',
        units: this.search.units ? this.search.units : '',
        enableFlag: this.search.enableFlag ? this.search.enableFlag : '',
        testDesc: this.search.testDesc ? this.search.testDesc : '',
        entity: '',
        process: ''
      },
      options: [{
        value: 'Y',
        label: 'Active'
      }, {
        value: 'N',
        label: 'Inactive'
      }],
      route: window.location.pathname,
      entityTestSearchList: [],
      processTestSearchList: []
    };
  },
  mounted: function mounted() {
    this.showData();
    this.arraySearch.entity = this.search.entity != '' ? this.search.entity : '';
    this.arraySearch.process = this.search.process != '' ? this.search.process : '';
  },
  computed: {},
  methods: {
    showData: function showData() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var vm, selEntity, selProcess;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                vm = _this;

                if (vm.arraySearch.entity == '' || vm.arraySearch.entity == undefined) {
                  vm.entityTestSearchList = vm.entityTestList != undefined && vm.entityTestList ? vm.entityTestList : [];
                }

                if (vm.arraySearch.process == '' || vm.arraySearch.process == undefined) {
                  vm.processTestSearchList = vm.processTestList != undefined && vm.processTestList ? vm.processDistinctTestList : [];
                }

                if (vm.arraySearch.entity) {
                  selEntity = vm.entityTestList.filter(function (o) {
                    return o.entity_code == vm.arraySearch.entity;
                  });

                  if (selEntity.length > 0) {
                    selEntity = selEntity[0];
                    vm.processTestSearchList = vm.processTestList.filter(function (o) {
                      return o.entity_code == selEntity.entity_code;
                    }); // vm.arraySearch.process = selEntity.entity_code;
                  }
                }

                if (vm.arraySearch.process) {
                  selProcess = vm.processTestList.filter(function (o) {
                    return o.process_code == vm.arraySearch.process;
                  });

                  if (selProcess.length > 0) {
                    selProcess = selProcess[0];
                    vm.entityTestSearchList = vm.entityTestList.filter(function (o) {
                      return o.process_code == selProcess.process_code;
                    });
                  }
                }

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

/***/ "./resources/js/components/qm/DefineTests/SearchComponent.vue":
/*!********************************************************************!*\
  !*** ./resources/js/components/qm/DefineTests/SearchComponent.vue ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _SearchComponent_vue_vue_type_template_id_46b3c024___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SearchComponent.vue?vue&type=template&id=46b3c024& */ "./resources/js/components/qm/DefineTests/SearchComponent.vue?vue&type=template&id=46b3c024&");
/* harmony import */ var _SearchComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SearchComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/qm/DefineTests/SearchComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _SearchComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _SearchComponent_vue_vue_type_template_id_46b3c024___WEBPACK_IMPORTED_MODULE_0__.render,
  _SearchComponent_vue_vue_type_template_id_46b3c024___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/qm/DefineTests/SearchComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/qm/DefineTests/SearchComponent.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************!*\
  !*** ./resources/js/components/qm/DefineTests/SearchComponent.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SearchComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/DefineTests/SearchComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/qm/DefineTests/SearchComponent.vue?vue&type=template&id=46b3c024&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/components/qm/DefineTests/SearchComponent.vue?vue&type=template&id=46b3c024& ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchComponent_vue_vue_type_template_id_46b3c024___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchComponent_vue_vue_type_template_id_46b3c024___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchComponent_vue_vue_type_template_id_46b3c024___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SearchComponent.vue?vue&type=template&id=46b3c024& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/DefineTests/SearchComponent.vue?vue&type=template&id=46b3c024&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/DefineTests/SearchComponent.vue?vue&type=template&id=46b3c024&":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/DefineTests/SearchComponent.vue?vue&type=template&id=46b3c024& ***!
  \******************************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "ibox" }, [
    _c("div", { staticClass: "ibox-content" }, [
      _c(
        "div",
        { staticClass: "row", staticStyle: { "padding-top": "15px" } },
        [
          _c(
            "div",
            { staticClass: "col-3" },
            [
              _vm._m(0),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.arraySearch.testDesc,
                    expression: "arraySearch.testDesc"
                  }
                ],
                attrs: {
                  type: "hidden",
                  name: "search[testDesc]",
                  autocomplete: "off"
                },
                domProps: { value: _vm.arraySearch.testDesc },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.$set(_vm.arraySearch, "testDesc", $event.target.value)
                  }
                }
              }),
              _vm._v(" "),
              _c(
                "el-select",
                {
                  staticClass: "w-100",
                  attrs: {
                    placeholder: "โปรดเลือกรายละเอียดการทดสอบ",
                    clearable: "",
                    filterable: "",
                    remote: "",
                    "reserve-keyword": ""
                  },
                  model: {
                    value: _vm.arraySearch.testDesc,
                    callback: function($$v) {
                      _vm.$set(_vm.arraySearch, "testDesc", $$v)
                    },
                    expression: "arraySearch.testDesc"
                  }
                },
                _vm._l(_vm.testDescList, function(data, index) {
                  return _c("el-option", {
                    key: index,
                    attrs: { label: data.test_desc, value: data.test_desc }
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
            { staticClass: "col-3" },
            [
              _vm._m(1),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.arraySearch.units,
                    expression: "arraySearch.units"
                  }
                ],
                attrs: {
                  type: "hidden",
                  name: "search[units]",
                  autocomplete: "off"
                },
                domProps: { value: _vm.arraySearch.units },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.$set(_vm.arraySearch, "units", $event.target.value)
                  }
                }
              }),
              _vm._v(" "),
              _c(
                "el-select",
                {
                  staticClass: "w-100",
                  attrs: {
                    placeholder: "โปรดเลือกหน่วยการทดสอบ",
                    clearable: "",
                    filterable: "",
                    remote: "",
                    "reserve-keyword": ""
                  },
                  model: {
                    value: _vm.arraySearch.units,
                    callback: function($$v) {
                      _vm.$set(_vm.arraySearch, "units", $$v)
                    },
                    expression: "arraySearch.units"
                  }
                },
                _vm._l(_vm.units, function(data, index) {
                  return _c("el-option", {
                    key: index,
                    attrs: { label: data.qcunit_code, value: data.qcunit_code }
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
            { staticClass: "col-3" },
            [
              this.testTypeCode != "2"
                ? _c("label", { staticClass: "w-100 text-left" }, [
                    _c("strong", [
                      _vm._v(" ระดับความรุนแรงของความผิดปกติ (อาการ) ")
                    ])
                  ])
                : _c("label", { staticClass: "w-100 text-left" }, [
                    _c("strong", [_vm._v(" ระดับความรุนแรงของข้อบกพร่อง ")])
                  ]),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.arraySearch.resultSeverites,
                    expression: "arraySearch.resultSeverites"
                  }
                ],
                attrs: {
                  type: "hidden",
                  name: "search[resultSeverites]",
                  autocomplete: "off"
                },
                domProps: { value: _vm.arraySearch.resultSeverites },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.$set(
                      _vm.arraySearch,
                      "resultSeverites",
                      $event.target.value
                    )
                  }
                }
              }),
              _vm._v(" "),
              _c(
                "el-select",
                {
                  staticClass: "w-100",
                  attrs: {
                    placeholder: "โปรดเลือกระดับความรุนแรงของความผิดปกติ",
                    clearable: "",
                    filterable: "",
                    remote: "",
                    "reserve-keyword": ""
                  },
                  model: {
                    value: _vm.arraySearch.resultSeverites,
                    callback: function($$v) {
                      _vm.$set(_vm.arraySearch, "resultSeverites", $$v)
                    },
                    expression: "arraySearch.resultSeverites"
                  }
                },
                _vm._l(_vm.resultSeverites, function(data, index) {
                  return _c("el-option", {
                    key: index,
                    attrs: { label: data.meaning, value: data.meaning }
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
            { staticClass: "col-3" },
            [
              _vm._m(2),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.arraySearch.enableFlag,
                    expression: "arraySearch.enableFlag"
                  }
                ],
                attrs: {
                  type: "hidden",
                  name: "search[enableFlag]",
                  autocomplete: "off"
                },
                domProps: { value: _vm.arraySearch.enableFlag },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.$set(_vm.arraySearch, "enableFlag", $event.target.value)
                  }
                }
              }),
              _vm._v(" "),
              _c(
                "el-select",
                {
                  staticClass: "w-100",
                  attrs: {
                    placeholder: "โปรดเลือกสถานะการใช้งาน",
                    clearable: "",
                    filterable: "",
                    remote: "",
                    "reserve-keyword": ""
                  },
                  model: {
                    value: _vm.arraySearch.enableFlag,
                    callback: function($$v) {
                      _vm.$set(_vm.arraySearch, "enableFlag", $$v)
                    },
                    expression: "arraySearch.enableFlag"
                  }
                },
                _vm._l(_vm.options, function(data, index) {
                  return _c("el-option", {
                    key: index,
                    attrs: { label: data.label, value: data.value }
                  })
                }),
                1
              )
            ],
            1
          )
        ]
      ),
      _vm._v(" "),
      this.testTypeCode == "2"
        ? _c(
            "div",
            { staticClass: "row", staticStyle: { "padding-top": "15px" } },
            [
              _c(
                "div",
                { staticClass: "col-3" },
                [
                  _vm._m(3),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.arraySearch.entity,
                        expression: "arraySearch.entity"
                      }
                    ],
                    attrs: {
                      type: "hidden",
                      name: "search[entity]",
                      autocomplete: "off"
                    },
                    domProps: { value: _vm.arraySearch.entity },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(_vm.arraySearch, "entity", $event.target.value)
                      }
                    }
                  }),
                  _vm._v(" "),
                  _c(
                    "el-select",
                    {
                      staticClass: "w-100",
                      attrs: {
                        placeholder: "โปรดเลือกรายการตรวจสอบคุณภาพบุหรี่",
                        clearable: "",
                        filterable: "",
                        remote: "",
                        "reserve-keyword": ""
                      },
                      on: { change: _vm.showData },
                      model: {
                        value: _vm.arraySearch.entity,
                        callback: function($$v) {
                          _vm.$set(_vm.arraySearch, "entity", $$v)
                        },
                        expression: "arraySearch.entity"
                      }
                    },
                    _vm._l(_vm.entityTestSearchList, function(data, index) {
                      return _c("el-option", {
                        key: index,
                        attrs: {
                          label: data.entity_meaning,
                          value: data.entity_code
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
                { staticClass: "col-3" },
                [
                  _vm._m(4),
                  _vm._v(" "),
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.arraySearch.process,
                        expression: "arraySearch.process"
                      }
                    ],
                    attrs: {
                      type: "hidden",
                      name: "search[process]",
                      autocomplete: "off"
                    },
                    domProps: { value: _vm.arraySearch.process },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.arraySearch,
                          "process",
                          $event.target.value
                        )
                      }
                    }
                  }),
                  _vm._v(" "),
                  _c(
                    "el-select",
                    {
                      staticClass: "w-100",
                      attrs: {
                        placeholder: "โปรดเลือกกระบวนการตรวจคุณภาพบุหรี่",
                        clearable: "",
                        filterable: "",
                        remote: "",
                        "reserve-keyword": ""
                      },
                      on: { change: _vm.showData },
                      model: {
                        value: _vm.arraySearch.process,
                        callback: function($$v) {
                          _vm.$set(_vm.arraySearch, "process", $$v)
                        },
                        expression: "arraySearch.process"
                      }
                    },
                    _vm._l(_vm.processTestSearchList, function(data, index) {
                      return _c("el-option", {
                        key: index,
                        attrs: {
                          label: data.process_meaning,
                          value: data.process_code
                        }
                      })
                    }),
                    1
                  )
                ],
                1
              )
            ]
          )
        : _vm._e(),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "text-right", staticStyle: { "padding-top": "15px" } },
        [
          _c(
            "button",
            { class: _vm.btnTrans.search.class, attrs: { type: "submit" } },
            [
              _c("i", {
                class: _vm.btnTrans.search.icon,
                attrs: { "aria-hidden": "true" }
              }),
              _vm._v(" " + _vm._s(_vm.btnTrans.search.text) + "\n            ")
            ]
          ),
          _vm._v(" "),
          _c(
            "a",
            {
              staticClass: "btn btn-danger",
              attrs: { type: "button", href: _vm.route }
            },
            [_vm._v("\n                ล้าง\n            ")]
          )
        ]
      )
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "w-100 text-left" }, [
      _c("strong", [_vm._v(" รายละเอียดการทดสอบ ")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "w-100 text-left" }, [
      _c("strong", [_vm._v(" หน่วยการทดสอบ ")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "w-100 text-left" }, [
      _c("strong", [_vm._v(" สถานะการใช้งาน ")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "w-100 text-left" }, [
      _c("strong", [_vm._v(" รายการตรวจสอบคุณภาพบุหรี่ ")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "w-100 text-left" }, [
      _c("strong", [_vm._v(" กระบวนการตรวจคุณภาพบุหรี่ ")])
    ])
  }
]
render._withStripped = true



/***/ })

}]);