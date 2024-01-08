(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_qm_ElFileUpload_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/ElFileUpload.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/ElFileUpload.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["id", "name", "action"],
  data: function data() {
    return {
      fileList: []
    };
  },
  methods: {
    submitUpload: function submitUpload() {
      // this.$refs.upload.submit();
      var formData = new FormData();
      formData.append("file", this.fileList[0].raw);
      axios.post(this.action, formData).then(function () {
        alert("upload success");
      })["catch"](function () {
        alert("upload error");
      });
    },
    handleUploadChange: function handleUploadChange(file, fileList) {
      this.fileList = fileList.slice(-1);
    },
    handleBeforeUpload: function handleBeforeUpload(file) {
      var allowedExcelMime = ["text/csv", "text/plain", "application/csv", "text/comma-separated-values", "application/excel", "application/vnd.ms-excel", "application/vnd.msexcel", "text/anytext", "application/octet-stream", "application/txt"];

      if (allowedExcelMime.includes(file.type)) {
        return true;
      } else {
        this.$message.error("You can only upload Excel files. No other file types are allowed");
        this.fileList.pop(file);
      }
    }
  }
});

/***/ }),

/***/ "./resources/js/components/qm/ElFileUpload.vue":
/*!*****************************************************!*\
  !*** ./resources/js/components/qm/ElFileUpload.vue ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ElFileUpload_vue_vue_type_template_id_5f082cdc___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ElFileUpload.vue?vue&type=template&id=5f082cdc& */ "./resources/js/components/qm/ElFileUpload.vue?vue&type=template&id=5f082cdc&");
/* harmony import */ var _ElFileUpload_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ElFileUpload.vue?vue&type=script&lang=js& */ "./resources/js/components/qm/ElFileUpload.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _ElFileUpload_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ElFileUpload_vue_vue_type_template_id_5f082cdc___WEBPACK_IMPORTED_MODULE_0__.render,
  _ElFileUpload_vue_vue_type_template_id_5f082cdc___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/qm/ElFileUpload.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/qm/ElFileUpload.vue?vue&type=script&lang=js&":
/*!******************************************************************************!*\
  !*** ./resources/js/components/qm/ElFileUpload.vue?vue&type=script&lang=js& ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ElFileUpload_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ElFileUpload.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/ElFileUpload.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ElFileUpload_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/qm/ElFileUpload.vue?vue&type=template&id=5f082cdc&":
/*!************************************************************************************!*\
  !*** ./resources/js/components/qm/ElFileUpload.vue?vue&type=template&id=5f082cdc& ***!
  \************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ElFileUpload_vue_vue_type_template_id_5f082cdc___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ElFileUpload_vue_vue_type_template_id_5f082cdc___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ElFileUpload_vue_vue_type_template_id_5f082cdc___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ElFileUpload.vue?vue&type=template&id=5f082cdc& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/ElFileUpload.vue?vue&type=template&id=5f082cdc&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/ElFileUpload.vue?vue&type=template&id=5f082cdc&":
/*!***************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/ElFileUpload.vue?vue&type=template&id=5f082cdc& ***!
  \***************************************************************************************************************************************************************************************************************************/
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
    "el-upload",
    {
      ref: "upload",
      staticClass: "upload-demo",
      attrs: {
        id: _vm.id,
        name: _vm.name,
        action: "",
        "on-change": _vm.handleUploadChange,
        "before-upload": _vm.handleBeforeUpload,
        accept:
          ".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel",
        "file-list": _vm.fileList,
        "auto-upload": false,
        limit: 1
      }
    },
    [
      _c(
        "el-button",
        {
          attrs: { slot: "trigger", size: "medium", type: "success" },
          slot: "trigger"
        },
        [
          _c("i", { staticClass: "fa fa fa-file-excel-o tw-mr-1" }),
          _vm._v(" Choose file\n    ")
        ]
      ),
      _vm._v(" "),
      _c(
        "el-button",
        {
          attrs: { type: "primary", size: "medium" },
          on: { click: _vm.submitUpload }
        },
        [
          _c("i", { staticClass: "fa fa-upload tw-mr-1" }),
          _vm._v(" Upload ผลการทดสอบ\n    ")
        ]
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "el-upload__tip", attrs: { slot: "tip" }, slot: "tip" },
        [_vm._v("\n        .xlxs file with a size less than xxxx mb\n    ")]
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);