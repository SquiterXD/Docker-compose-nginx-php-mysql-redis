(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ir_settings_gas-station__search_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/gas-station/_search.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/gas-station/_search.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'ir-settings-gas-station-search',
  props: ['btnTrans', 'dataSearch'],
  data: function data() {
    return {
      gas_stations: [],
      loading: false,
      type_code: '',
      return_vat_flag: '',
      active_flag: '',
      search_url: this.dataSearch.search_url,
      returnLists: [{
        label: 'ขอคืนภาษีได้',
        value: 'Y'
      }, {
        label: 'ขอคืนภาษีไม่ได้',
        value: 'N'
      }],
      activeLists: [{
        label: 'Active',
        value: 'Y'
      }, {
        label: 'Inactive',
        value: 'N'
      }]
    };
  },
  mounted: function mounted() {
    if (this.dataSearch) {
      this.type_code = this.dataSearch.type_code;
      this.return_vat_flag = this.dataSearch.return_vat_flag;
      this.active_flag = this.dataSearch.active_flag;
    }

    this.getStations();
  },
  methods: {
    getStations: function getStations(query) {
      var _this = this;

      this.loading = true;
      this.policiesLov = [];
      axios.get("/ir/ajax/lov/gas-stations-type", {
        params: {
          keyword: query
        }
      }).then(function (_ref) {
        var data = _ref.data;
        _this.loading = false;
        _this.gas_stations = data.data;
      })["catch"](function (error) {
        swal("Error", error, "error");
      });
    },
    clickCancel: function clickCancel() {
      window.location.href = '/ir/settings/gas-station';
    },
    clickSearch: function clickSearch() {
      $("#searchForm").submit();
    }
  }
});

/***/ }),

/***/ "./resources/js/components/ir/settings/gas-station/_search.vue":
/*!*********************************************************************!*\
  !*** ./resources/js/components/ir/settings/gas-station/_search.vue ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _search_vue_vue_type_template_id_7cd6f6b7___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./_search.vue?vue&type=template&id=7cd6f6b7& */ "./resources/js/components/ir/settings/gas-station/_search.vue?vue&type=template&id=7cd6f6b7&");
/* harmony import */ var _search_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./_search.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/settings/gas-station/_search.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _search_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _search_vue_vue_type_template_id_7cd6f6b7___WEBPACK_IMPORTED_MODULE_0__.render,
  _search_vue_vue_type_template_id_7cd6f6b7___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/settings/gas-station/_search.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/settings/gas-station/_search.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/gas-station/_search.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_search_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./_search.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/gas-station/_search.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_search_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/settings/gas-station/_search.vue?vue&type=template&id=7cd6f6b7&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/gas-station/_search.vue?vue&type=template&id=7cd6f6b7& ***!
  \****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_search_vue_vue_type_template_id_7cd6f6b7___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_search_vue_vue_type_template_id_7cd6f6b7___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_search_vue_vue_type_template_id_7cd6f6b7___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./_search.vue?vue&type=template&id=7cd6f6b7& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/gas-station/_search.vue?vue&type=template&id=7cd6f6b7&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/gas-station/_search.vue?vue&type=template&id=7cd6f6b7&":
/*!*******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/gas-station/_search.vue?vue&type=template&id=7cd6f6b7& ***!
  \*******************************************************************************************************************************************************************************************************************************************/
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
  return _c("form", { attrs: { action: _vm.search_url, id: "searchForm" } }, [
    _c("div", { staticClass: "row" }, [
      _c(
        "div",
        { staticClass: "col-xl-3 col-md-4 padding_12 el_field" },
        [
          _c("input", {
            attrs: { type: "hidden", name: "type_code" },
            domProps: { value: _vm.type_code }
          }),
          _vm._v(" "),
          _c(
            "el-select",
            {
              staticClass: "w-100",
              attrs: {
                filterable: "",
                placeholder: "ระบุประเภทสถานีน้ำมัน",
                "remote-method": _vm.getStations,
                loading: _vm.loading,
                remote: "",
                clearable: ""
              },
              model: {
                value: _vm.type_code,
                callback: function($$v) {
                  _vm.type_code = $$v
                },
                expression: "type_code"
              }
            },
            _vm._l(_vm.gas_stations, function(data, index) {
              return _c("el-option", {
                key: index,
                attrs: { label: data.description, value: data.description }
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
        { staticClass: "col-xl-3 col-md-4 padding_12 el_field" },
        [
          _c("input", {
            attrs: { type: "hidden", name: "return_vat_flag" },
            domProps: { value: _vm.return_vat_flag }
          }),
          _vm._v(" "),
          _c(
            "el-select",
            {
              staticClass: "w-100",
              attrs: {
                filterable: "",
                clearable: "",
                remote: "",
                placeholder: "ขอคืนภาษี"
              },
              model: {
                value: _vm.return_vat_flag,
                callback: function($$v) {
                  _vm.return_vat_flag = $$v
                },
                expression: "return_vat_flag"
              }
            },
            _vm._l(_vm.returnLists, function(data, index) {
              return _c("el-option", {
                key: index,
                attrs: { label: data.label, value: data.value }
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
        { staticClass: "col-xl-3 col-md-4 padding_12 el_field" },
        [
          _c("input", {
            attrs: { type: "hidden", name: "active_flag" },
            domProps: { value: _vm.active_flag }
          }),
          _vm._v(" "),
          _c(
            "el-select",
            {
              staticClass: "w-100",
              attrs: {
                filterable: "",
                clearable: "",
                remote: "",
                placeholder: "Status"
              },
              model: {
                value: _vm.active_flag,
                callback: function($$v) {
                  _vm.active_flag = $$v
                },
                expression: "active_flag"
              }
            },
            _vm._l(_vm.activeLists, function(data, index) {
              return _c("el-option", {
                key: index,
                attrs: { label: data.label, value: data.value }
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
          staticClass: "col-xl-3 padding_12",
          staticStyle: { "margin-top": "auto", "margin-bottom": "auto" }
        },
        [
          _c(
            "button",
            {
              class: _vm.btnTrans.search.class + " btn-lg tw-w-25",
              attrs: { type: "button" },
              on: {
                click: function($event) {
                  $event.preventDefault()
                  return _vm.clickSearch()
                }
              }
            },
            [
              _c("i", { class: _vm.btnTrans.search.icon }),
              _vm._v(
                "\n            " +
                  _vm._s(_vm.btnTrans.search.text) +
                  "\n        "
              )
            ]
          ),
          _vm._v(" "),
          _c(
            "button",
            {
              class: _vm.btnTrans.reset.class + " btn-lg tw-w-25",
              attrs: { type: "button" },
              on: {
                click: function($event) {
                  $event.preventDefault()
                  return _vm.clickCancel()
                }
              }
            },
            [
              _c("i", { class: _vm.btnTrans.reset.icon }),
              _vm._v(
                "\n            " +
                  _vm._s(_vm.btnTrans.reset.text) +
                  "\n        "
              )
            ]
          )
        ]
      )
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);