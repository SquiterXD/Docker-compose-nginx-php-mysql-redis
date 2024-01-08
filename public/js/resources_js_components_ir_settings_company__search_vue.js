(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ir_settings_company__search_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/company/_search.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/company/_search.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'ir-settings-company-search',
  props: ['search', 'btnTrans', 'dataSearch'],
  data: function data() {
    return {
      companies: [],
      loading: false,
      active_flag: '',
      company_id: '',
      search_url: this.dataSearch.search_url,
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
      this.active_flag = this.dataSearch.active_flag;
      this.company_id = this.dataSearch.company_id ? Number(this.dataSearch.company_id) : '';
    }

    this.getCompanies();
  },
  methods: {
    getCompanies: function getCompanies(query) {
      var _this = this;

      this.loading = true;
      this.companies = [];
      axios.get("/ir/ajax/lov/companies", {
        params: {
          company_id: this.company_id,
          query: query
        }
      }).then(function (_ref) {
        var data = _ref.data;
        _this.loading = false;
        _this.companies = data.data;
      })["catch"](function (error) {
        swal("Error", error, "error");
      });
    },
    clickCancel: function clickCancel() {
      window.location.href = '/ir/settings/company';
    },
    clickSearch: function clickSearch() {
      console.log('clickSearch clickSearch 555');
      $("#searchForm").submit();
    }
  }
});

/***/ }),

/***/ "./resources/js/components/ir/settings/company/_search.vue":
/*!*****************************************************************!*\
  !*** ./resources/js/components/ir/settings/company/_search.vue ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _search_vue_vue_type_template_id_657c60f4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./_search.vue?vue&type=template&id=657c60f4& */ "./resources/js/components/ir/settings/company/_search.vue?vue&type=template&id=657c60f4&");
/* harmony import */ var _search_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./_search.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/settings/company/_search.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _search_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _search_vue_vue_type_template_id_657c60f4___WEBPACK_IMPORTED_MODULE_0__.render,
  _search_vue_vue_type_template_id_657c60f4___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/settings/company/_search.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/settings/company/_search.vue?vue&type=script&lang=js&":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/company/_search.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_search_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./_search.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/company/_search.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_search_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/settings/company/_search.vue?vue&type=template&id=657c60f4&":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/company/_search.vue?vue&type=template&id=657c60f4& ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_search_vue_vue_type_template_id_657c60f4___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_search_vue_vue_type_template_id_657c60f4___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_search_vue_vue_type_template_id_657c60f4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./_search.vue?vue&type=template&id=657c60f4& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/company/_search.vue?vue&type=template&id=657c60f4&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/company/_search.vue?vue&type=template&id=657c60f4&":
/*!***************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/company/_search.vue?vue&type=template&id=657c60f4& ***!
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
  return _c("form", { attrs: { action: _vm.search_url, id: "searchForm" } }, [
    _c("div", { staticClass: "row" }, [
      _c(
        "div",
        { staticClass: "col-xl-4 col-md-6 el_select padding_12" },
        [
          _c("input", {
            attrs: { type: "hidden", name: "company_id" },
            domProps: { value: _vm.company_id }
          }),
          _vm._v(" "),
          _c(
            "el-select",
            {
              attrs: {
                filterable: "",
                placeholder: "ระบุข้อมูลผู้รับประกัน",
                "remote-method": _vm.getCompanies,
                loading: _vm.loading,
                remote: "",
                clearable: ""
              },
              model: {
                value: _vm.company_id,
                callback: function($$v) {
                  _vm.company_id = $$v
                },
                expression: "company_id"
              }
            },
            _vm._l(_vm.companies, function(company) {
              return _c("el-option", {
                key: company.company_id,
                attrs: {
                  label: company.company_number + ": " + company.company_name,
                  value: company.company_id
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
        { staticClass: "col-lg-2 col-sm-2 padding_12" },
        [
          _c("input", {
            attrs: { type: "hidden", name: "active_flag" },
            domProps: { value: _vm.active_flag }
          }),
          _vm._v(" "),
          _c(
            "el-select",
            {
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
      _c("div", { staticClass: "col-xl-4 padding_12 margin_auto_btn_search" }, [
        _c(
          "button",
          {
            class: _vm.btnTrans.search.class + " btn-lg tw-w-25",
            attrs: { type: "button" },
            on: {
              click: function($event) {
                $event.preventDefault()
                return _vm.clickSearch($event)
              }
            }
          },
          [
            _c("i", { class: _vm.btnTrans.search.icon }),
            _vm._v("\n        " + _vm._s(_vm.btnTrans.search.text) + "\n      ")
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
            _vm._v("\n        " + _vm._s(_vm.btnTrans.reset.text) + "\n      ")
          ]
        )
      ])
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);