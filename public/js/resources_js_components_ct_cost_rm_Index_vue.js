(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ct_cost_rm_Index_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/cost_rm/Index.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/cost_rm/Index.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      cost_center: "",
      org: "",
      options: {
        cost_center: [],
        org: []
      },
      tableData: [],
      addTableData: []
    };
  },
  mounted: function mounted() {
    this.getMasterData();
  },
  methods: {
    getMasterData: function getMasterData() {
      this.getCostCenters();
      this.invOrg();
    },
    getCostCenters: function getCostCenters() {
      var _this = this;

      axios.get("/ct/ajax/cost_center/cost-center-view").then(function (res) {
        _this.options.cost_center = res.data;
      });
    },
    selectCostCenter: function selectCostCenter() {
      this.queryCostRm();
    },
    queryCostRm: function queryCostRm() {
      var _this2 = this;

      axios.get("/ct/ajax/cost_rm?cost_code=".concat(this.cost_center)).then(function (res) {
        var data = res.data.data;
        _this2.tableData = data;
      });
    },
    invOrg: function invOrg() {
      var _this3 = this;

      axios.get("/ct/ajax/cost_center/inv_org").then(function (res) {
        var data = res.data.data;
        _this3.options.org = data;
      });
    },
    confirmDelete: function confirmDelete(index, data) {
      var _this4 = this;

      this.$confirm("เมื่อกดยืนยันข้อมูลนี้จะถูกลบ", "ต้องการลบข้อมูลนี้ใช่หรือไม่", {
        confirmButtonText: "ยืนยัน",
        cancelButtonText: "ยกเลิก"
      }).then(function () {
        console.log("test");

        _this4.deleteOrg(index);
      })["catch"](function () {
        console.log("cancel");
      });
    },
    addOrgToTable: function addOrgToTable() {
      var _this5 = this;

      var item = this.options.org.find(function (item) {
        return item.organization_code == _this5.org;
      });
      var checkDuplicate = this.addTableData.find(function (element) {
        return item.organization_code == element.organization_code;
      });

      if (!checkDuplicate) {
        this.addTableData.push(item);
      }

      this.org = "";
    },
    deleteRow: function deleteRow(index, data) {
      data.splice(index, 1);
    },
    deleteOrg: function deleteOrg(index) {
      var _this6 = this;

      var item = this.tableData[index];
      console.log(item);
      axios["delete"]("/ct/ajax/cost_rm?cost_code=".concat(this.cost_center, "&org_code=").concat(item.org_ingredient, "&org_name=").concat(item.org_ingredient)).then(function (res) {
        swal({
          title: "&nbsp;",
          text: "ลบข้อมูลสำเร็จ",
          type: "success",
          html: true
        });

        _this6.selectCostCenter(); // this.addTableData = [];

      });
    },
    submitOrg: function submitOrg() {
      var _this7 = this;

      if (this.cost_center && this.addTableData.length > 0) {
        // this.addTableData = [];
        var form = {
          cost_code: this.cost_center,
          data: this.addTableData
        };
        axios.post("/ct/ajax/cost_rm", form).then(function (res) {
          swal({
            title: "&nbsp;",
            text: "บันทึกข้อมูลสำเร็จ",
            type: "success",
            html: true
          });

          _this7.selectCostCenter();

          _this7.addTableData = [];
        });
      } else {
        swal("Error", "\u0E01\u0E23\u0E38\u0E13\u0E32\u0E40\u0E25\u0E37\u0E2D\u0E01\u0E28\u0E39\u0E19\u0E22\u0E4C\u0E15\u0E49\u0E19\u0E17\u0E38\u0E19\u0E01\u0E48\u0E2D\u0E19\u0E01\u0E48\u0E2D\u0E19\u0E40\u0E1E\u0E34\u0E48\u0E21 ORG \u0E27\u0E31\u0E15\u0E16\u0E38\u0E14\u0E34\u0E1A", "error");
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/cost_rm/Index.vue?vue&type=style&index=0&id=3cc9b83d&lang=scss&scoped=true&":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/cost_rm/Index.vue?vue&type=style&index=0&id=3cc9b83d&lang=scss&scoped=true& ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, ".flex[data-v-3cc9b83d] {\n  display: flex;\n}\n.items-center[data-v-3cc9b83d] {\n  align-items: center;\n}\n.el-select[data-v-3cc9b83d] {\n  width: 300px;\n}\n.card-custom[data-v-3cc9b83d] {\n  background: white;\n  border-radius: 10px;\n  padding: 20px !important;\n}", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/cost_rm/Index.vue?vue&type=style&index=0&id=3cc9b83d&lang=scss&scoped=true&":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/cost_rm/Index.vue?vue&type=style&index=0&id=3cc9b83d&lang=scss&scoped=true& ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_style_index_0_id_3cc9b83d_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!../../../../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=style&index=0&id=3cc9b83d&lang=scss&scoped=true& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/cost_rm/Index.vue?vue&type=style&index=0&id=3cc9b83d&lang=scss&scoped=true&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_style_index_0_id_3cc9b83d_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_style_index_0_id_3cc9b83d_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/components/ct/cost_rm/Index.vue":
/*!******************************************************!*\
  !*** ./resources/js/components/ct/cost_rm/Index.vue ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_3cc9b83d_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=3cc9b83d&scoped=true& */ "./resources/js/components/ct/cost_rm/Index.vue?vue&type=template&id=3cc9b83d&scoped=true&");
/* harmony import */ var _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js& */ "./resources/js/components/ct/cost_rm/Index.vue?vue&type=script&lang=js&");
/* harmony import */ var _Index_vue_vue_type_style_index_0_id_3cc9b83d_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Index.vue?vue&type=style&index=0&id=3cc9b83d&lang=scss&scoped=true& */ "./resources/js/components/ct/cost_rm/Index.vue?vue&type=style&index=0&id=3cc9b83d&lang=scss&scoped=true&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Index_vue_vue_type_template_id_3cc9b83d_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _Index_vue_vue_type_template_id_3cc9b83d_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "3cc9b83d",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ct/cost_rm/Index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ct/cost_rm/Index.vue?vue&type=script&lang=js&":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/ct/cost_rm/Index.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/cost_rm/Index.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ct/cost_rm/Index.vue?vue&type=style&index=0&id=3cc9b83d&lang=scss&scoped=true&":
/*!****************************************************************************************************************!*\
  !*** ./resources/js/components/ct/cost_rm/Index.vue?vue&type=style&index=0&id=3cc9b83d&lang=scss&scoped=true& ***!
  \****************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_style_index_0_id_3cc9b83d_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!../../../../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=style&index=0&id=3cc9b83d&lang=scss&scoped=true& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/cost_rm/Index.vue?vue&type=style&index=0&id=3cc9b83d&lang=scss&scoped=true&");


/***/ }),

/***/ "./resources/js/components/ct/cost_rm/Index.vue?vue&type=template&id=3cc9b83d&scoped=true&":
/*!*************************************************************************************************!*\
  !*** ./resources/js/components/ct/cost_rm/Index.vue?vue&type=template&id=3cc9b83d&scoped=true& ***!
  \*************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_3cc9b83d_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_3cc9b83d_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_3cc9b83d_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=template&id=3cc9b83d&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/cost_rm/Index.vue?vue&type=template&id=3cc9b83d&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/cost_rm/Index.vue?vue&type=template&id=3cc9b83d&scoped=true&":
/*!****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/cost_rm/Index.vue?vue&type=template&id=3cc9b83d&scoped=true& ***!
  \****************************************************************************************************************************************************************************************************************************************/
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
    _c("div", { staticClass: "row" }, [
      _c("div", { staticClass: "col-lg-6 col-md-12 mt-4 p-4" }, [
        _c(
          "div",
          { staticClass: "card-custom" },
          [
            _vm._m(0),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "form-group text-center" },
              [
                _c("label", { staticClass: "mr-2", attrs: { for: "" } }, [
                  _vm._v("ศูนย์ต้นทุน")
                ]),
                _vm._v(" "),
                _c(
                  "el-select",
                  {
                    attrs: { placeholder: "เลือกศูนย์ต้นทุน" },
                    on: { change: _vm.selectCostCenter },
                    model: {
                      value: _vm.cost_center,
                      callback: function($$v) {
                        _vm.cost_center = $$v
                      },
                      expression: "cost_center"
                    }
                  },
                  _vm._l(_vm.options.cost_center, function(item) {
                    return _c("el-option", {
                      key: item.cost_code,
                      attrs: {
                        label: item.cost_code + "-" + item.description,
                        value: item.cost_code
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
              "el-table",
              {
                staticStyle: { width: "100%" },
                attrs: { border: "", data: _vm.tableData }
              },
              [
                _c("el-table-column", {
                  attrs: {
                    prop: "org_ingredient",
                    label: "ORG วัตถุดิบ",
                    align: "center"
                  }
                }),
                _vm._v(" "),
                _c("el-table-column", {
                  attrs: {
                    prop: "org_description",
                    label: "รายละเอียด",
                    align: "center"
                  }
                }),
                _vm._v(" "),
                _c("el-table-column", {
                  attrs: { width: "120" },
                  scopedSlots: _vm._u([
                    {
                      key: "default",
                      fn: function(scope) {
                        return [
                          _c(
                            "div",
                            { staticClass: "text-center" },
                            [
                              _c(
                                "el-button",
                                {
                                  attrs: { size: "mini", type: "danger" },
                                  nativeOn: {
                                    click: function($event) {
                                      $event.preventDefault()
                                      return _vm.confirmDelete(
                                        scope.$index,
                                        _vm.tableData
                                      )
                                    }
                                  }
                                },
                                [
                                  _c("i", { staticClass: "el-icon-delete" }),
                                  _vm._v("ลบ\n                                ")
                                ]
                              )
                            ],
                            1
                          )
                        ]
                      }
                    }
                  ])
                })
              ],
              1
            )
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "col-lg-6 col-md-12 mt-4 p-4" }, [
        _c(
          "div",
          { staticClass: "card-custom" },
          [
            _vm._m(1),
            _vm._v(" "),
            _c(
              "div",
              { staticStyle: { display: "flex", "justify-content": "center" } },
              [
                _c(
                  "div",
                  { staticClass: "form-group text-center" },
                  [
                    _c(
                      "el-select",
                      {
                        attrs: { placeholder: "เลือก ORG วัตถุดิบ" },
                        model: {
                          value: _vm.org,
                          callback: function($$v) {
                            _vm.org = $$v
                          },
                          expression: "org"
                        }
                      },
                      _vm._l(_vm.options.org, function(item) {
                        return _c("el-option", {
                          key: item.organization_code,
                          attrs: {
                            label:
                              item.organization_code +
                              " - " +
                              item.organization_name,
                            value: item.organization_code
                          }
                        })
                      }),
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "el-button",
                      {
                        staticClass: "btn-success mr-2 btn-p__tr",
                        staticStyle: {
                          "background-color": "#40c8b2",
                          border: "none"
                        },
                        attrs: { id: "add_cost_center", type: "success" },
                        on: { click: _vm.addOrgToTable }
                      },
                      [
                        _vm._v(
                          "\n                            เพิ่ม\n                        "
                        )
                      ]
                    )
                  ],
                  1
                )
              ]
            ),
            _vm._v(" "),
            _c(
              "el-table",
              {
                staticStyle: { width: "100%" },
                attrs: { border: "", data: _vm.addTableData }
              },
              [
                _c("el-table-column", {
                  attrs: {
                    prop: "organization_code",
                    label: "ORG วัตถุดิบ",
                    align: "center"
                  }
                }),
                _vm._v(" "),
                _c("el-table-column", {
                  attrs: {
                    prop: "organization_name",
                    label: "รายละเอียด",
                    align: "center"
                  }
                }),
                _vm._v(" "),
                _c("el-table-column", {
                  attrs: { width: "120" },
                  scopedSlots: _vm._u([
                    {
                      key: "default",
                      fn: function(scope) {
                        return [
                          _c(
                            "div",
                            { staticClass: "text-center" },
                            [
                              _c(
                                "el-button",
                                {
                                  attrs: { size: "mini", type: "danger" },
                                  nativeOn: {
                                    click: function($event) {
                                      $event.preventDefault()
                                      return _vm.deleteRow(
                                        scope.$index,
                                        _vm.addTableData
                                      )
                                    }
                                  }
                                },
                                [
                                  _c("i", { staticClass: "el-icon-delete" }),
                                  _vm._v("ลบ\n                                ")
                                ]
                              )
                            ],
                            1
                          )
                        ]
                      }
                    }
                  ])
                })
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "text-right mt-2" },
              [
                _c(
                  "el-button",
                  {
                    staticClass: "btn-success mr-2 btn-p__tr",
                    staticStyle: {
                      "background-color": "#40c8b2",
                      border: "none"
                    },
                    attrs: { id: "add_cost_center", type: "success" },
                    on: { click: _vm.submitOrg }
                  },
                  [
                    _vm._v(
                      "\n                        บันทึกการเพิ่มวัตถุดิบ\n                    "
                    )
                  ]
                )
              ],
              1
            )
          ],
          1
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
    return _c("div", { staticClass: "text-center" }, [
      _c("h2", [
        _vm._v(
          "\n                        ข้อมูล ORG วัตถุดิบ\n                    "
        )
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "text-center" }, [
      _c("h2", [
        _vm._v(
          "\n                        เพิ่มข้อมูลวัตถุดิบ\n                    "
        )
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);