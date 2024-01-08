(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ct_helper_ImportXlsx_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/helper/ImportXlsx.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/helper/ImportXlsx.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var xlsx__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! xlsx */ "./node_modules/xlsx/xlsx.js");
/* harmony import */ var xlsx__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(xlsx__WEBPACK_IMPORTED_MODULE_0__);
//
//
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
  mounted: function mounted() {
    this.textXlsx();
  },
  methods: {
    textXlsx: function textXlsx() {},
    handleFileUpload: function handleFileUpload() {
      var _this$file$name, _this$file$name2;

      this.file = this.$refs.file.files[0];
      var file_extension = (_this$file$name = this.file.name) === null || _this$file$name === void 0 ? void 0 : _this$file$name.split(".").pop();
      console.log((_this$file$name2 = this.file.name) === null || _this$file$name2 === void 0 ? void 0 : _this$file$name2.split(".").pop());

      if (file_extension == "csv" || file_extension == "xlsx") {
        var reader = new FileReader();

        reader.onload = function () {
          var fileData = reader.result;
          var wb = xlsx__WEBPACK_IMPORTED_MODULE_0___default().read(fileData, {
            type: "binary"
          });
          wb.SheetNames.forEach(function (sheetName) {
            var rowObj = xlsx__WEBPACK_IMPORTED_MODULE_0___default().utils.sheet_to_row_object_array(wb.Sheets[sheetName]);
            var jsonObj = JSON.stringify(rowObj);
            console.log(JSON.parse(jsonObj));
          });
        };

        reader.readAsBinaryString(this.file);
      } else {
        this.$refs.file.value = "";
        alert("อัพโหลดไม่ได้");
      }
    }
  }
});

/***/ }),

/***/ "./resources/js/components/ct/helper/ImportXlsx.vue":
/*!**********************************************************!*\
  !*** ./resources/js/components/ct/helper/ImportXlsx.vue ***!
  \**********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ImportXlsx_vue_vue_type_template_id_749a2cec___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ImportXlsx.vue?vue&type=template&id=749a2cec& */ "./resources/js/components/ct/helper/ImportXlsx.vue?vue&type=template&id=749a2cec&");
/* harmony import */ var _ImportXlsx_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ImportXlsx.vue?vue&type=script&lang=js& */ "./resources/js/components/ct/helper/ImportXlsx.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _ImportXlsx_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ImportXlsx_vue_vue_type_template_id_749a2cec___WEBPACK_IMPORTED_MODULE_0__.render,
  _ImportXlsx_vue_vue_type_template_id_749a2cec___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ct/helper/ImportXlsx.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ct/helper/ImportXlsx.vue?vue&type=script&lang=js&":
/*!***********************************************************************************!*\
  !*** ./resources/js/components/ct/helper/ImportXlsx.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ImportXlsx_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ImportXlsx.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/helper/ImportXlsx.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ImportXlsx_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ct/helper/ImportXlsx.vue?vue&type=template&id=749a2cec&":
/*!*****************************************************************************************!*\
  !*** ./resources/js/components/ct/helper/ImportXlsx.vue?vue&type=template&id=749a2cec& ***!
  \*****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ImportXlsx_vue_vue_type_template_id_749a2cec___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ImportXlsx_vue_vue_type_template_id_749a2cec___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ImportXlsx_vue_vue_type_template_id_749a2cec___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ImportXlsx.vue?vue&type=template&id=749a2cec& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/helper/ImportXlsx.vue?vue&type=template&id=749a2cec&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/helper/ImportXlsx.vue?vue&type=template&id=749a2cec&":
/*!********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/helper/ImportXlsx.vue?vue&type=template&id=749a2cec& ***!
  \********************************************************************************************************************************************************************************************************************************/
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
    _c("input", {
      ref: "file",
      attrs: { type: "file", id: "myfile", name: "myfile" },
      on: {
        change: function($event) {
          return _vm.handleFileUpload()
        }
      }
    })
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);