(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ir_settings_inventory-not-insurance_IndexComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/inventory-not-insurance/IndexComponent.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/inventory-not-insurance/IndexComponent.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ['urlReset'],
  data: function data() {
    return {
      perPage: 100,
      current_page: 1,
      totalRows: 0,
      per_page: 500,
      sortBy: '',
      sortDesc: false,
      sortDirection: 'asc',
      showLoading: false,
      isBusy: false,
      fields: [{
        key: 'line_no',
        sortable: true,
        "class": 'text-center text-nowrap options-column align-middle'
      }, {
        key: 'status',
        sortable: true,
        "class": 'text-nowrap options-column align-middle',
        tdClass: 'align-middle'
      }, {
        key: 'organization_code',
        sortable: true,
        "class": 'text-nowrap options-column align-middle',
        tdClass: 'align-middle'
      }, {
        key: 'item_number',
        sortable: true,
        "class": 'text-nowrap options-column align-middle',
        tdClass: 'align-middle'
      }, {
        key: 'description',
        sortable: true,
        "class": 'text-nowrap align-middle',
        tdClass: 'align-middle'
      }, {
        key: 'price',
        sortable: true,
        "class": 'text-center text-nowrap align-middle',
        tdClass: 'align-middle'
      }, {
        key: 'expense_flag',
        sortable: true,
        "class": 'text-nowrap align-middle',
        tdClass: 'align-middle'
      }, {
        key: 'inventory_date',
        sortable: true,
        "class": 'text-center text-nowrap align-middle',
        tdClass: 'align-middle'
      }],
      form: {
        tableLine: []
      },
      dataTable: [],
      search: {
        item_number: '',
        organization_code: '',
        status: ''
      }
    };
  },
  methods: {
    rowClass: function rowClass(item, type, test) {
      if (!item || type !== 'row') return;
    },
    clickSearch: function clickSearch() {
      console.log('clickSearch');
    },
    clickCancel: function clickCancel() {
      console.log('clickCancel');
    },
    clickFetch: function clickFetch() {
      console.log('clickFetch');
    }
  },
  watch: {
    'dataTable': function dataTable(newVal, oldVal) {
      // $(`input[name="cars_select_all"]`).prop('checked', false)
      // this.columnSelected = []
      // this.columnSelectedId = []
      this.totalRows = this.dataTable.length;
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/inventory-not-insurance/IndexComponent.vue?vue&type=style&index=0&id=f4343f48&scoped=true&lang=css&":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/inventory-not-insurance/IndexComponent.vue?vue&type=style&index=0&id=f4343f48&scoped=true&lang=css& ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "th[data-v-f4343f48] {\n  z-index: 1;\n  background: white;\n  position: -webkit-sticky;\n  position: sticky;\n  top: 0; /* Don't forget this, required for the stickiness */\n}\n.el-form-item__content[data-v-f4343f48]{\n  line-height: 40px;\n  position: relative;\n  font-size: 14px;\n  margin-left: 0px !important;\n}\n.table.b-table > thead > tr > [aria-sort] > div[data-v-f4343f48] {\n  display: flex;\n  justify-content: space-between;\n  align-items: flex-end;\n}\n.table.b-table > thead > tr > [aria-sort][data-v-f4343f48] {\n  cursor: pointer;\n}\ntable.b-table > thead > tr > th[aria-sort=\"descending\"] > div[data-v-f4343f48]::before,\ntable.b-table > tfoot > tr > th[aria-sort=\"descending\"] > div[data-v-f4343f48]::before {\n  content: \"\";\n  padding-left: 15px;\n}\ntable.b-table > thead > tr > th[aria-sort=\"descending\"] > div[data-v-f4343f48]::after,\ntable.b-table > tfoot > tr > th[aria-sort=\"descending\"] > div[data-v-f4343f48]::after {\n  opacity: 1;\n  content: \"\\2193\";\n  padding-left: 10px;\n}\ntable.b-table > thead > tr > th[aria-sort=\"ascending\"] > div[data-v-f4343f48]::before,\ntable.b-table > tfoot > tr > th[aria-sort=\"ascending\"] > div[data-v-f4343f48]::before {\n  content: \"\";\n  padding-left: 15px;\n}\ntable.b-table > thead > tr > th[aria-sort=\"ascending\"] > div[data-v-f4343f48]::after,\ntable.b-table > tfoot > tr > th[aria-sort=\"ascending\"] > div[data-v-f4343f48]::after {\n  opacity: 1;\n  content: \"\\2191\";\n  padding-left: 10px;\n}\ntable.b-table > thead > tr > th[aria-sort=\"none\"] > div[data-v-f4343f48]::before,\ntable.b-table > tfoot > tr > th[aria-sort=\"none\"] > div[data-v-f4343f48]::before {\n  content: \"\";\n  padding-left: 15px;\n}\ntable.b-table > thead > tr > th[aria-sort=\"none\"] > div[data-v-f4343f48]::after,\ntable.b-table > tfoot > tr > th[aria-sort=\"none\"] > div[data-v-f4343f48]::after {\n  opacity: 1;\n  content: \"\\21C5\";\n  font-weight: normal;\n  padding-left: 10px;\n}\n.table-hover > tbody > tr[data-v-f4343f48]:hover {\n  background-color: #d4edda!important;\n}\n.table-active[data-v-f4343f48], .table-active>td[data-v-f4343f48], .table-active>th[data-v-f4343f48] {\n  background-color: #d4edda!important;\n}\n\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/inventory-not-insurance/IndexComponent.vue?vue&type=style&index=0&id=f4343f48&scoped=true&lang=css&":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/inventory-not-insurance/IndexComponent.vue?vue&type=style&index=0&id=f4343f48&scoped=true&lang=css& ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_IndexComponent_vue_vue_type_style_index_0_id_f4343f48_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./IndexComponent.vue?vue&type=style&index=0&id=f4343f48&scoped=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/inventory-not-insurance/IndexComponent.vue?vue&type=style&index=0&id=f4343f48&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_IndexComponent_vue_vue_type_style_index_0_id_f4343f48_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_IndexComponent_vue_vue_type_style_index_0_id_f4343f48_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/components/ir/settings/inventory-not-insurance/IndexComponent.vue":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/inventory-not-insurance/IndexComponent.vue ***!
  \****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _IndexComponent_vue_vue_type_template_id_f4343f48_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./IndexComponent.vue?vue&type=template&id=f4343f48&scoped=true& */ "./resources/js/components/ir/settings/inventory-not-insurance/IndexComponent.vue?vue&type=template&id=f4343f48&scoped=true&");
/* harmony import */ var _IndexComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./IndexComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/settings/inventory-not-insurance/IndexComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _IndexComponent_vue_vue_type_style_index_0_id_f4343f48_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./IndexComponent.vue?vue&type=style&index=0&id=f4343f48&scoped=true&lang=css& */ "./resources/js/components/ir/settings/inventory-not-insurance/IndexComponent.vue?vue&type=style&index=0&id=f4343f48&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _IndexComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _IndexComponent_vue_vue_type_template_id_f4343f48_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _IndexComponent_vue_vue_type_template_id_f4343f48_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "f4343f48",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/settings/inventory-not-insurance/IndexComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/settings/inventory-not-insurance/IndexComponent.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/inventory-not-insurance/IndexComponent.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_IndexComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./IndexComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/inventory-not-insurance/IndexComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_IndexComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/settings/inventory-not-insurance/IndexComponent.vue?vue&type=style&index=0&id=f4343f48&scoped=true&lang=css&":
/*!*************************************************************************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/inventory-not-insurance/IndexComponent.vue?vue&type=style&index=0&id=f4343f48&scoped=true&lang=css& ***!
  \*************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_IndexComponent_vue_vue_type_style_index_0_id_f4343f48_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/style-loader/dist/cjs.js!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./IndexComponent.vue?vue&type=style&index=0&id=f4343f48&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/inventory-not-insurance/IndexComponent.vue?vue&type=style&index=0&id=f4343f48&scoped=true&lang=css&");


/***/ }),

/***/ "./resources/js/components/ir/settings/inventory-not-insurance/IndexComponent.vue?vue&type=template&id=f4343f48&scoped=true&":
/*!***********************************************************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/inventory-not-insurance/IndexComponent.vue?vue&type=template&id=f4343f48&scoped=true& ***!
  \***********************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_IndexComponent_vue_vue_type_template_id_f4343f48_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_IndexComponent_vue_vue_type_template_id_f4343f48_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_IndexComponent_vue_vue_type_template_id_f4343f48_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./IndexComponent.vue?vue&type=template&id=f4343f48&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/inventory-not-insurance/IndexComponent.vue?vue&type=template&id=f4343f48&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/inventory-not-insurance/IndexComponent.vue?vue&type=template&id=f4343f48&scoped=true&":
/*!**************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/inventory-not-insurance/IndexComponent.vue?vue&type=template&id=f4343f48&scoped=true& ***!
  \**************************************************************************************************************************************************************************************************************************************************************************/
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
    "div",
    [
      _c(
        "el-form",
        {
          ref: "save_table_line",
          staticClass: "demo-dynamic form_table_line",
          attrs: { model: _vm.form, "label-width": "120px" }
        },
        [
          _c("div", { staticClass: "row" }, [
            _c("div", { staticClass: "col-12" }, [
              _c("div", { staticClass: "ibox-title" }, [
                _c("div", { staticClass: "row" }, [
                  _c("div", { staticClass: "col-md-6" }, [
                    _c("h5", [_vm._v("ข้อมูลสินค้าคงคลังไม่ทำประกัน")])
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-md-6 text-right" }, [
                    _c(
                      "button",
                      {
                        staticClass: "btn btn-md btn-success",
                        attrs: { type: "button" },
                        on: {
                          click: function($event) {
                            return _vm.clickFetch()
                          }
                        }
                      },
                      [
                        _c("i", { staticClass: "fa fa-database" }),
                        _vm._v(" ดึงข้อมูล\n                            ")
                      ]
                    )
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "ibox-content" }, [
                _c("div", { staticClass: "row" }, [
                  _c(
                    "div",
                    {
                      staticClass: "col-sm-4",
                      staticStyle: { "text-align": "left" }
                    },
                    [
                      _c("label", [
                        _vm._v(
                          "\n                                รหัสสินค้า\n                            "
                        )
                      ]),
                      _vm._v(" "),
                      _c("input", {
                        attrs: { type: "hidden", name: "item_number" },
                        domProps: { value: _vm.search.item_number }
                      }),
                      _vm._v(" "),
                      _c("el-select", {
                        staticClass: "required",
                        staticStyle: { width: "100%" },
                        attrs: {
                          placeholder: "รหัสสินค้า",
                          size: "small",
                          filterable: "",
                          remote: "",
                          "reserve-keyword": "",
                          clearable: ""
                        },
                        model: {
                          value: _vm.search.item_number,
                          callback: function($$v) {
                            _vm.$set(_vm.search, "item_number", $$v)
                          },
                          expression: "search.item_number"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass: "col-sm-4",
                      staticStyle: { "text-align": "left" }
                    },
                    [
                      _c("label", [
                        _vm._v(
                          "\n                                Organization\n                            "
                        )
                      ]),
                      _vm._v(" "),
                      _c("input", {
                        attrs: { type: "hidden", name: "organization_code" },
                        domProps: { value: _vm.search.organization_code }
                      }),
                      _vm._v(" "),
                      _c("el-select", {
                        staticClass: "required",
                        staticStyle: { width: "100%" },
                        attrs: {
                          placeholder: "Organization",
                          size: "small",
                          filterable: "",
                          remote: "",
                          "reserve-keyword": "",
                          clearable: ""
                        },
                        model: {
                          value: _vm.search.organization_code,
                          callback: function($$v) {
                            _vm.$set(_vm.search, "organization_code", $$v)
                          },
                          expression: "search.organization_code"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass: "col-sm-4",
                      staticStyle: { "text-align": "left" }
                    },
                    [
                      _c("label", [
                        _vm._v(
                          "\n                                Status\n                            "
                        )
                      ]),
                      _vm._v(" "),
                      _c("input", {
                        attrs: { type: "hidden", name: "status" },
                        domProps: { value: _vm.search.status }
                      }),
                      _vm._v(" "),
                      _c("el-select", {
                        staticClass: "required",
                        staticStyle: { width: "100%" },
                        attrs: {
                          placeholder: "Status",
                          size: "small",
                          filterable: "",
                          remote: "",
                          "reserve-keyword": "",
                          clearable: ""
                        },
                        model: {
                          value: _vm.search.status,
                          callback: function($$v) {
                            _vm.$set(_vm.search, "status", $$v)
                          },
                          expression: "search.status"
                        }
                      })
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "row mt-3" }, [
                  _c("div", { staticClass: "col-12 text-right" }, [
                    _c(
                      "button",
                      {
                        staticClass: "btn btn-sm btn-light",
                        attrs: { type: "button" },
                        on: {
                          click: function($event) {
                            return _vm.clickSearch()
                          }
                        }
                      },
                      [
                        _c("i", { staticClass: "fa fa-search" }),
                        _vm._v(" ค้นหา\n                            ")
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "button",
                      {
                        staticClass: "btn btn-sm btn-warning",
                        attrs: { type: "button" },
                        on: {
                          click: function($event) {
                            return _vm.clickCancel()
                          }
                        }
                      },
                      [
                        _c("i", { staticClass: "fa fa-undo" }),
                        _vm._v(" รีเซต\n                            ")
                      ]
                    )
                  ])
                ]),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "table-responsive mt-5" },
                  [
                    _c("b-table", {
                      staticStyle: {
                        display: "block",
                        overflow: "auto",
                        "max-height": "400px"
                      },
                      attrs: {
                        "table-class": "table table-bordered",
                        busy: _vm.isBusy,
                        items: _vm.dataTable,
                        fields: _vm.fields,
                        "current-page": _vm.current_page,
                        "per-page": _vm.perPage,
                        "sort-by": _vm.sortBy,
                        "sort-desc": _vm.sortDesc,
                        "sort-direction": _vm.sortDirection,
                        "tbody-tr-class": _vm.rowClass,
                        "primary-key": "rowId",
                        "show-empty": "",
                        hover: "",
                        small: "",
                        "select-mode": "single",
                        selectable: ""
                      },
                      on: {
                        "update:busy": function($event) {
                          _vm.isBusy = $event
                        },
                        "update:sortBy": function($event) {
                          _vm.sortBy = $event
                        },
                        "update:sort-by": function($event) {
                          _vm.sortBy = $event
                        },
                        "update:sortDesc": function($event) {
                          _vm.sortDesc = $event
                        },
                        "update:sort-desc": function($event) {
                          _vm.sortDesc = $event
                        }
                      },
                      scopedSlots: _vm._u([
                        {
                          key: "head(line_no)",
                          fn: function(header) {
                            return [
                              _c("div", [
                                _vm._v(
                                  "\n                                    Line No\n                                "
                                )
                              ])
                            ]
                          }
                        },
                        {
                          key: "head(status)",
                          fn: function(header) {
                            return [
                              _c("div", [
                                _vm._v(
                                  "\n                                    สถานะ"
                                ),
                                _c("br"),
                                _vm._v(
                                  "(Status) \n                                "
                                )
                              ])
                            ]
                          }
                        },
                        {
                          key: "head(organization_code)",
                          fn: function(header) {
                            return [
                              _c("div", [
                                _vm._v(
                                  "\n                                    Organization\n                                "
                                )
                              ])
                            ]
                          }
                        },
                        {
                          key: "head(item_number)",
                          fn: function(header) {
                            return [
                              _c("div", [
                                _vm._v(
                                  "\n                                    รหัสสินค้า (Item Code)\n                                "
                                )
                              ])
                            ]
                          }
                        },
                        {
                          key: "head(description)",
                          fn: function(header) {
                            return [
                              _c("div", [
                                _vm._v(
                                  "\n                                    คำอธิบาย (Description)\n                                "
                                )
                              ])
                            ]
                          }
                        },
                        {
                          key: "head(price)",
                          fn: function(header) {
                            return [
                              _c("div", [
                                _vm._v(
                                  "\n                                    ราคาต่อหน่วย\n                                "
                                )
                              ])
                            ]
                          }
                        },
                        {
                          key: "head(expense_flag)",
                          fn: function(header) {
                            return [
                              _c("div", [
                                _vm._v(
                                  "\n                                    ทำประกัน\n                                "
                                )
                              ])
                            ]
                          }
                        },
                        {
                          key: "head(inventory_date)",
                          fn: function(header) {
                            return [
                              _c("div", [
                                _vm._v(
                                  "\n                                    วันที่ดึงข้อมูลจากระบบ INV\n                                "
                                )
                              ])
                            ]
                          }
                        },
                        {
                          key: "cell(line_no)",
                          fn: function(row) {
                            return [
                              _c("div", [
                                _vm._v(
                                  "\n                                    " +
                                    _vm._s(row.item.line_no) +
                                    "\n                                "
                                )
                              ])
                            ]
                          }
                        },
                        {
                          key: "cell(status)",
                          fn: function(row) {
                            return [
                              _c("div", [
                                _vm._v(
                                  "\n                                    " +
                                    _vm._s(row.item.status) +
                                    "\n                                "
                                )
                              ])
                            ]
                          }
                        },
                        {
                          key: "cell(organization_code)",
                          fn: function(row) {
                            return [
                              _c("div", [
                                _vm._v(
                                  "\n                                    " +
                                    _vm._s(row.item.organization_code) +
                                    "\n                                "
                                )
                              ])
                            ]
                          }
                        },
                        {
                          key: "cell(item_number)",
                          fn: function(row) {
                            return [
                              _c("div", [
                                _vm._v(
                                  "\n                                    " +
                                    _vm._s(row.item.item_number) +
                                    "\n                                "
                                )
                              ])
                            ]
                          }
                        },
                        {
                          key: "cell(description)",
                          fn: function(row) {
                            return [
                              _c("div", [
                                _vm._v(
                                  "\n                                    " +
                                    _vm._s(row.item.description) +
                                    "\n                                "
                                )
                              ])
                            ]
                          }
                        },
                        {
                          key: "cell(price)",
                          fn: function(row) {
                            return [
                              _c("div", [
                                _vm._v(
                                  "\n                                    " +
                                    _vm._s(row.item.price) +
                                    "\n                                "
                                )
                              ])
                            ]
                          }
                        },
                        {
                          key: "cell(expense_flag)",
                          fn: function(row) {
                            return [
                              _c("div", [
                                _vm._v(
                                  "\n                                    " +
                                    _vm._s(row.item.expense_flag) +
                                    "\n                                "
                                )
                              ])
                            ]
                          }
                        },
                        {
                          key: "cell(inventory_date)",
                          fn: function(row) {
                            return [
                              _c("div", [
                                _vm._v(
                                  "\n                                    " +
                                    _vm._s(row.item.inventory_date) +
                                    "\n                                "
                                )
                              ])
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
                  {
                    directives: [
                      {
                        name: "show",
                        rawName: "v-show",
                        value: _vm.totalRows > _vm.perPage,
                        expression: "totalRows > perPage"
                      }
                    ],
                    staticClass: "row"
                  },
                  [
                    _c(
                      "div",
                      { staticClass: "col-md-12" },
                      [
                        _c("b-pagination", {
                          attrs: {
                            "total-rows": _vm.totalRows,
                            "per-page": _vm.perPage,
                            align: "right"
                          },
                          model: {
                            value: _vm.current_page,
                            callback: function($$v) {
                              _vm.current_page = $$v
                            },
                            expression: "current_page"
                          }
                        })
                      ],
                      1
                    )
                  ]
                )
              ])
            ])
          ])
        ]
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);