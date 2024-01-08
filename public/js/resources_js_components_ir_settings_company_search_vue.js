(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ir_settings_company_search_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/company/search.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/company/search.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'ir-settings-company-search',
  data: function data() {
    return {
      companies: [],
      loading: false,
      create: {
        company_number: '',
        company_name: '',
        company_address: '',
        company_telephone: '',
        vendor_id: '',
        vendor_site_id: '',
        // branch_code: '',
        customer_id: '',
        active_flag: true,
        company_id: ''
      }
    };
  },
  props: ['search', 'btnTrans'],
  methods: {
    remoteMethodCompany: function remoteMethodCompany(query) {
      this.getCompanies({
        company_id: '',
        keyword: query
      });
    },
    getCompanies: function getCompanies(params) {
      var _this = this;

      this.loading = true;
      axios.get("/ir/ajax/lov/companies", {
        params: params
      }).then(function (_ref) {
        var data = _ref.data;
        var response = data.data;
        _this.loading = false;
        _this.companies = response;
      })["catch"](function (error) {
        return consle.log('error ', error);
      });
    },
    clickSearch: function clickSearch() {
      this.$emit('click-search', this.search);
    },
    focusCompany: function focusCompany(event) {
      this.getCompanies({
        company_id: '',
        keyword: ''
      });
    },
    clickCancel: function clickCancel() {
      window.location.href = '/ir/settings/company';
    }
  },
  mounted: function mounted() {
    this.getCompanies({
      company_id: '',
      keyword: ''
    });
  }
});

/***/ }),

/***/ "./resources/js/components/ir/settings/company/search.vue":
/*!****************************************************************!*\
  !*** ./resources/js/components/ir/settings/company/search.vue ***!
  \****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _search_vue_vue_type_template_id_b2d372ea___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./search.vue?vue&type=template&id=b2d372ea& */ "./resources/js/components/ir/settings/company/search.vue?vue&type=template&id=b2d372ea&");
/* harmony import */ var _search_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./search.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/settings/company/search.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _search_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _search_vue_vue_type_template_id_b2d372ea___WEBPACK_IMPORTED_MODULE_0__.render,
  _search_vue_vue_type_template_id_b2d372ea___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/settings/company/search.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/settings/company/search.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/company/search.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_search_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./search.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/company/search.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_search_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/settings/company/search.vue?vue&type=template&id=b2d372ea&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/company/search.vue?vue&type=template&id=b2d372ea& ***!
  \***********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_search_vue_vue_type_template_id_b2d372ea___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_search_vue_vue_type_template_id_b2d372ea___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_search_vue_vue_type_template_id_b2d372ea___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./search.vue?vue&type=template&id=b2d372ea& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/company/search.vue?vue&type=template&id=b2d372ea&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/company/search.vue?vue&type=template&id=b2d372ea&":
/*!**************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/company/search.vue?vue&type=template&id=b2d372ea& ***!
  \**************************************************************************************************************************************************************************************************************************************/
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
      { staticClass: "col-xl-4 col-md-6 el_select padding_12" },
      [
        _c(
          "el-select",
          {
            attrs: {
              filterable: "",
              placeholder: "ระบุข้อมูลผู้รับประกัน",
              name: "company_id",
              "remote-method": _vm.remoteMethodCompany,
              loading: _vm.loading,
              remote: "",
              clearable: ""
            },
            on: { focus: _vm.focusCompany },
            model: {
              value: _vm.search.company_id,
              callback: function($$v) {
                _vm.$set(_vm.search, "company_id", $$v)
              },
              expression: "search.company_id"
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
      { staticClass: "col-xl-4 col-md-6 el_select padding_12" },
      [
        _c(
          "el-select",
          {
            attrs: {
              placeholder: "Status",
              name: "active_flag",
              clearable: true
            },
            model: {
              value: _vm.search.active_flag,
              callback: function($$v) {
                _vm.$set(_vm.search, "active_flag", $$v)
              },
              expression: "search.active_flag"
            }
          },
          [
            _c("el-option", { attrs: { label: "Active", value: "Y" } }),
            _vm._v(" "),
            _c("el-option", { attrs: { label: "Inactive", value: "N" } })
          ],
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
              return _vm.clickSearch()
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
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);