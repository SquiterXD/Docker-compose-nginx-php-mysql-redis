(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_om_CountryComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/CountryComponent.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/CountryComponent.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var element_ui__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! element-ui */ "./node_modules/element-ui/lib/element-ui.common.js");
/* harmony import */ var element_ui__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(element_ui__WEBPACK_IMPORTED_MODULE_0__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ['old', 'continents', 'allCountries', 'defaultValue'],
  data: function data() {
    return {
      selectContinentName: this.defaultValue ? this.defaultValue.continent_name : '',
      selectCountry: this.defaultValue ? this.defaultValue.country_code : '',
      selectStatus: this.defaultValue ? this.defaultValue.status : 'Active',
      geographies: [],
      statusData: [{
        value: 'Active',
        label: 'Active'
      }, {
        value: 'Inactive',
        label: 'Inactive'
      }]
    };
  },
  mounted: function mounted() {// this.getGeographies();
    // if (this.defaultValue) {
    //     console.log('333');
    //     this.getGeographies().then(() => {
    //         this.selectGeographyName = this.defaultValue.country_name || "";
    //     });
    // } 
  },
  methods: {//     findSelected() {
    //         console.log(this.selectGeographyName);
    //         // this.contryCode = '3333';
    //         // console.log(this.selectGeographyName.geography_id);
    //         let geographySelect = this.hzGeographies.find(hzGeography => {
    //             console.log(this.hzGeography);
    //             return hzGeography.geography_id == this.selectGeographyName;
    //         });
    //         // this.contryCode = this.geographySelect.geography_code;
    //         console.log('xxx');
    //         console.log(this.geographySelect);
    //     },
    // getGeographies() {
    //     this.selectGeographyName = '';
    //     // this.item_category_id = [];
    //     this.geographies = [];
    //     axios.get(`/om/ajax/geographies`).then(res => {
    //         this.geographies = res.data.data.geographies;
    //     });
    // },
    // getGeographies() {
    //     this.selectGeographyName = "";
    //     this.geographies = [];
    //     this.defaultValue.reason_id = "";
    //     return axios
    //     .get(`/om/ajax/geographies`)
    //     .then(res => {
    //         this.geographies = res.data.data.geographies;
    //     });
    // },
    // getSelectedGeographyName() {
    //     this.selectGeographyName= this.geographies.find(i => {
    //         return i.geography_name == this.defaultValue.geography_name;
    //     });
    // },
  }
});

/***/ }),

/***/ "./resources/js/components/om/CountryComponent.vue":
/*!*********************************************************!*\
  !*** ./resources/js/components/om/CountryComponent.vue ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _CountryComponent_vue_vue_type_template_id_3bff683d___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CountryComponent.vue?vue&type=template&id=3bff683d& */ "./resources/js/components/om/CountryComponent.vue?vue&type=template&id=3bff683d&");
/* harmony import */ var _CountryComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CountryComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/om/CountryComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _CountryComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _CountryComponent_vue_vue_type_template_id_3bff683d___WEBPACK_IMPORTED_MODULE_0__.render,
  _CountryComponent_vue_vue_type_template_id_3bff683d___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/om/CountryComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/om/CountryComponent.vue?vue&type=script&lang=js&":
/*!**********************************************************************************!*\
  !*** ./resources/js/components/om/CountryComponent.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CountryComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./CountryComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/CountryComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CountryComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/om/CountryComponent.vue?vue&type=template&id=3bff683d&":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/om/CountryComponent.vue?vue&type=template&id=3bff683d& ***!
  \****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CountryComponent_vue_vue_type_template_id_3bff683d___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CountryComponent_vue_vue_type_template_id_3bff683d___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CountryComponent_vue_vue_type_template_id_3bff683d___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./CountryComponent.vue?vue&type=template&id=3bff683d& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/CountryComponent.vue?vue&type=template&id=3bff683d&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/CountryComponent.vue?vue&type=template&id=3bff683d&":
/*!*******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/CountryComponent.vue?vue&type=template&id=3bff683d& ***!
  \*******************************************************************************************************************************************************************************************************************************/
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
    _c("div", { staticClass: "row mt-2" }, [
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _vm._m(0),
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
                name: "continent_name"
              },
              model: {
                value: _vm.selectContinentName,
                callback: function($$v) {
                  _vm.selectContinentName = $$v
                },
                expression: "selectContinentName"
              }
            },
            _vm._l(_vm.continents, function(continent) {
              return _c("el-option", {
                key: continent.value,
                attrs: { label: continent.meaning, value: continent.value }
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
        { staticClass: "col-md-4" },
        [
          _vm._m(1),
          _vm._v(" "),
          _c("input", {
            attrs: { type: "hidden", name: "country_code" },
            domProps: { value: _vm.selectCountry }
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
                value: _vm.selectCountry,
                callback: function($$v) {
                  _vm.selectCountry = $$v
                },
                expression: "selectCountry"
              }
            },
            _vm._l(_vm.allCountries, function(allCountry) {
              return _c("el-option", {
                key: allCountry.country_code,
                attrs: {
                  label: allCountry.country_name,
                  value: allCountry.country_code
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
        { staticClass: "col-md-4" },
        [
          _vm._m(2),
          _vm._v(" "),
          _c(
            "el-select",
            {
              staticClass: "w-100",
              attrs: { name: "status" },
              model: {
                value: _vm.selectStatus,
                callback: function($$v) {
                  _vm.selectStatus = $$v
                },
                expression: "selectStatus"
              }
            },
            _vm._l(_vm.statusData, function(item) {
              return _c("el-option", {
                key: item.value,
                attrs: { label: item.label, value: item.value }
              })
            }),
            1
          )
        ],
        1
      )
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" ทวีป "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" ประเทศ "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" Status "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  }
]
render._withStripped = true



/***/ })

}]);