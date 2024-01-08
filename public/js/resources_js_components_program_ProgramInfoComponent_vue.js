(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_program_ProgramInfoComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/program/ProgramInfoComponent.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/program/ProgramInfoComponent.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['programInfo', 'types', 'moduleLists', 'schemaLists', 'sourceTypeLists'],
  data: function data() {
    return {
      name: this.programInfo ? this.programInfo.program_code : '',
      description: this.programInfo ? this.programInfo.description : '',
      module: this.programInfo ? this.programInfo.module_name : '',
      programType: this.programInfo ? this.programInfo.program_type_name : '',
      sourceType: this.programInfo ? this.programInfo.source : '',
      sourceName: this.programInfo ? this.programInfo.source_name : '',
      schema: this.programInfo ? this.programInfo.schemas_name : '',
      enableFlag: this.programInfo.length == 0 ? true : this.programInfo.enable_flag == 'Y' ? true : false,
      insertFlag: this.programInfo.length == 0 ? true : this.programInfo.insert_flag == 'Y' ? true : false,
      updateFlag: this.programInfo.length == 0 ? true : this.programInfo.update_flag == 'Y' ? true : false,
      deleteFlag: this.programInfo.length == 0 ? true : this.programInfo.delete_flag == 'Y' ? true : false,
      //PATH
      archiveDirectory: this.programInfo.length == 0 ? this.programInfo.archive_directory : '',
      outputDirectory: this.programInfo.length == 0 ? this.programInfo.output_directory : '',
      errorDirectory: this.programInfo.length == 0 ? this.programInfo.error_directory : '',
      logDirectory: this.programInfo.length == 0 ? this.programInfo.log_directory : ''
    };
  },
  mounted: function mounted() {// console.log('Component mounted.')
  },
  methods: {
    chooseModule: function chooseModule() {
      // this.schema = this.schemaLists.filter((schema, index) => {
      //     console.log(schema);
      //     console.log(index);
      //     if (this.module == index) {
      //         return schema;
      //     }
      // })
      if (this.module == 'IE') {
        this.schema = 'OAIE';
      } else if (this.module == 'IR') {
        this.schema = 'OAIR';
      } else if (this.module == 'PM') {
        this.schema = 'OAPM';
      } else if (this.module == 'QM') {
        this.schema = 'OAQM';
      } else if (this.module == 'OM') {
        this.schema = 'OAOM';
      } else if (this.module == 'PD') {
        this.schema = 'OAPD';
      } else if (this.module == 'EM') {
        this.schema = 'OAEAM';
      } else if (this.module == 'IN') {
        this.schema = 'OAINV';
      } else if (this.module == 'PP') {
        this.schema = 'OAPP';
      } else if (this.module == 'CT') {
        this.schema = 'OACT';
      }
    }
  }
});

/***/ }),

/***/ "./resources/js/components/program/ProgramInfoComponent.vue":
/*!******************************************************************!*\
  !*** ./resources/js/components/program/ProgramInfoComponent.vue ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ProgramInfoComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ProgramInfoComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/program/ProgramInfoComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");
var render, staticRenderFns
;



/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__.default)(
  _ProgramInfoComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default,
  render,
  staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/program/ProgramInfoComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/program/ProgramInfoComponent.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/components/program/ProgramInfoComponent.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProgramInfoComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ProgramInfoComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/program/ProgramInfoComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProgramInfoComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ })

}]);