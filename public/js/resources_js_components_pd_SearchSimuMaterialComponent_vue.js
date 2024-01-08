(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pd_SearchSimuMaterialComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pd/SearchSimuMaterialComponent.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pd/SearchSimuMaterialComponent.vue?vue&type=script&lang=js& ***!
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['simulationTypes', 'actionUrl', 'defaultValue', 'search_data'],
  data: function data() {
    return {
      simu_type: this.defaultValue ? this.defaultValue : '',
      // simu_raw_num: this.defaultValue ? this.defaultValue : '',
      loading: false,
      inputParams: {
        simu_type_list: [],
        simu_raw_num_list: []
      },
      form: {
        simu_type: null,
        simu_raw_num: null
      }
    };
  },
  mounted: function mounted() {
    this.autoLoad();
  },
  methods: {
    autoLoad: function autoLoad() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                vm = _this;
                vm.form.simu_type = vm.search_data.simu_type != '' ? vm.search_data.simu_type : null, vm.form.simu_raw_num = vm.search_data.simu_raw_num != '' ? vm.search_data.simu_raw_num : null, vm.getParam();

              case 2:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getParam: function getParam() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var vm, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                vm = _this2;
                vm.loading = true;
                params = {
                  action: 'search_get_param',
                  simu_type: vm.form.simu_type,
                  simu_raw_num: vm.form.simu_raw_num
                };
                axios.get(vm.search_data.search_url, {
                  params: params
                }).then(function (res) {
                  var response = res.data;
                  vm.loading = false;
                  vm.inputParams.simu_type_list = response.simu_type_list;
                  vm.inputParams.simu_raw_num_list = response.simu_raw_num_list;
                });

              case 4:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    sortArrays: function sortArrays(arrays) {
      return _.orderBy(arrays, 'value', 'asc');
    }
  }
});

/***/ }),

/***/ "./resources/js/components/pd/SearchSimuMaterialComponent.vue":
/*!********************************************************************!*\
  !*** ./resources/js/components/pd/SearchSimuMaterialComponent.vue ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _SearchSimuMaterialComponent_vue_vue_type_template_id_667384c0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SearchSimuMaterialComponent.vue?vue&type=template&id=667384c0& */ "./resources/js/components/pd/SearchSimuMaterialComponent.vue?vue&type=template&id=667384c0&");
/* harmony import */ var _SearchSimuMaterialComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SearchSimuMaterialComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/pd/SearchSimuMaterialComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _SearchSimuMaterialComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _SearchSimuMaterialComponent_vue_vue_type_template_id_667384c0___WEBPACK_IMPORTED_MODULE_0__.render,
  _SearchSimuMaterialComponent_vue_vue_type_template_id_667384c0___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pd/SearchSimuMaterialComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pd/SearchSimuMaterialComponent.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************!*\
  !*** ./resources/js/components/pd/SearchSimuMaterialComponent.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchSimuMaterialComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SearchSimuMaterialComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pd/SearchSimuMaterialComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchSimuMaterialComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pd/SearchSimuMaterialComponent.vue?vue&type=template&id=667384c0&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/components/pd/SearchSimuMaterialComponent.vue?vue&type=template&id=667384c0& ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchSimuMaterialComponent_vue_vue_type_template_id_667384c0___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchSimuMaterialComponent_vue_vue_type_template_id_667384c0___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchSimuMaterialComponent_vue_vue_type_template_id_667384c0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SearchSimuMaterialComponent.vue?vue&type=template&id=667384c0& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pd/SearchSimuMaterialComponent.vue?vue&type=template&id=667384c0&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pd/SearchSimuMaterialComponent.vue?vue&type=template&id=667384c0&":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pd/SearchSimuMaterialComponent.vue?vue&type=template&id=667384c0& ***!
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
  return _c("div", { staticClass: "row" }, [
    _c(
      "div",
      { staticClass: "col-sm-4" },
      [
        _c("label", [_vm._v(" ประเภทวัตถุดิบจำลอง ")]),
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
              value: _vm.form.simu_type
            },
            on: {
              change: function(value) {
                _vm.form.simu_type = value
                _vm.getParam()
              }
            }
          },
          _vm._l(_vm.sortArrays(_vm.inputParams.simu_type_list), function(
            simulationType
          ) {
            return _c("el-option", {
              key: simulationType.value,
              attrs: {
                label: simulationType.label,
                value: simulationType.value
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
      { staticClass: "col-sm-4" },
      [
        _c("label", [_vm._v(" รหัสวัตถุดิบ ")]),
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
              value: _vm.form.simu_raw_num
            },
            on: {
              change: function(value) {
                _vm.form.simu_raw_num = value
                _vm.getParam()
              }
            }
          },
          _vm._l(_vm.sortArrays(_vm.inputParams.simu_raw_num_list), function(
            simuRawNum
          ) {
            return _c("el-option", {
              key: simuRawNum.value,
              attrs: { label: simuRawNum.value, value: simuRawNum.value }
            })
          }),
          1
        )
      ],
      1
    ),
    _vm._v(" "),
    _c("input", {
      attrs: { type: "hidden", name: "simu_type" },
      domProps: { value: _vm.form.simu_type }
    }),
    _vm._v(" "),
    _c("input", {
      attrs: { type: "hidden", name: "simu_raw_num" },
      domProps: { value: _vm.form.simu_raw_num }
    }),
    _vm._v(" "),
    _c("div", { staticClass: "col-sm-2" }, [
      _c("label", { staticClass: " tw-font-bold tw-uppercase mb-0" }, [
        _vm._v(" ")
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "text-right" }, [
        _vm._m(0),
        _vm._v(" "),
        _c(
          "a",
          {
            staticClass: "btn btn-warning btn-sm",
            attrs: { href: this.actionUrl }
          },
          [
            _c("i", { staticClass: "fa fa-undo" }),
            _vm._v(" รีเซต\n            ")
          ]
        )
      ])
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "button",
      { staticClass: "btn btn-light btn-sm", attrs: { type: "submit" } },
      [
        _c("i", {
          staticClass: "fa fa-search",
          attrs: { "aria-hidden": "true" }
        }),
        _vm._v(" แสดงผล\n            ")
      ]
    )
  }
]
render._withStripped = true



/***/ })

}]);