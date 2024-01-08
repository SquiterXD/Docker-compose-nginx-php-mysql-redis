(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_pm_pages_rawMaterialList_requestMaterial_Index_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/rawMaterialList/requestMaterial/Index.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/rawMaterialList/requestMaterial/Index.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_loading_overlay__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-loading-overlay */ "./node_modules/vue-loading-overlay/dist/vue-loading.min.js");
/* harmony import */ var vue_loading_overlay__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vue_loading_overlay__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var vue_loading_overlay_dist_vue_loading_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue-loading-overlay/dist/vue-loading.css */ "./node_modules/vue-loading-overlay/dist/vue-loading.css");


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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_1___default())
  },
  props: {
    item: {},
    auth: {},
    url_ajax: null,
    btn_trans: {
      type: Object
    },
    machine_relations: {},
    request_ingredients: {}
  },
  data: function data() {
    return {
      machine: null,
      ingredients: null,
      isLoading: true,
      fullPage: true,
      el: {
        machine: null,
        ingredients: null
      },
      validate: {
        machine: null,
        ingredients: null
      }
    };
  },
  mounted: function mounted() {
    console.log(this);
    this.isLoading = false;
  },
  methods: {
    changeMachineSet: function changeMachineSet($event) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                console.log($event);
                _this.machine = $event;

              case 2:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    popoverHide: function popoverHide(el) {
      setTimeout(function () {
        console.log($("#" + el).parents('.el-select').popover('hide'));
      }, 500);
    },
    changeIngredients: function changeIngredients($event) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this2.ingredients = $event;

              case 1:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    resetEl: function resetEl() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _this3.el = {
                  machine: null,
                  ingredients: null
                };

              case 1:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    handleSave: function handleSave(event) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        var url, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                event.preventDefault();

                if (_this4.el.ingredients == null) {
                  _this4.validate.ingredients = "กรุณาเลือกข้อมูลตราบุหรี่";
                  setTimeout(function () {
                    $("#select-box2").parents('.el-select').popover('show');
                  }, 200);
                } else {
                  $("#select-box2").parents('.el-select').popover('hide');
                  _this4.validate.ingredients = "";
                }

                if (_this4.el.machine == null) {
                  _this4.validate.machine = "กรุณาเลือกข้อมูลหมายเลขเครื่อง";
                  setTimeout(function () {
                    $("#select-box1").parents('.el-select').popover('show');
                  }, 200);
                } else {
                  $("#select-box1").parents('.el-select').popover('hide');
                  _this4.validate.machine = "";
                }

                if (!(_this4.el.machine == null || _this4.el.ingredients == null)) {
                  _context4.next = 5;
                  break;
                }

                return _context4.abrupt("return", false);

              case 5:
                url = _this4.url_ajax.raw_material_store;
                params = {
                  machine_set: _this4.el.machine,
                  item_no: _this4.el.ingredients,
                  record_type: "req",
                  organization_id: _this4.item.organization_id,
                  organization_code: _this4.item.organization_code,
                  item_cat_code: _this4.item.item_cat_code,
                  last_updated_by_id: _this4.auth.fnd_user_id,
                  last_updated_by: _this4.auth.user_id,
                  created_by: _this4.auth.user_id,
                  created_by_id: _this4.auth.fnd_user_id
                };
                _this4.isLoading = true;
                _context4.next = 10;
                return axios.post(url, params).then(function (result) {
                  swal("แจ้งเตือน", "ทำรายการสำเร็จ", "success");
                  setTimeout(function () {
                    window.location.href = '/pm/raw_material_list';
                  }, 1000);

                  _this4.resetEl();
                })["catch"](function (ex) {
                  swal("แจ้งเตือน", "กรุณาตรวจสอบข้อมูลใหม่อีกครั้ง", "error");
                });

              case 10:
                _this4.isLoading = false;

              case 11:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/rawMaterialList/requestMaterial/Index.vue?vue&type=style&index=0&id=bc70db90&scoped=true&lang=css&":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/rawMaterialList/requestMaterial/Index.vue?vue&type=style&index=0&id=bc70db90&scoped=true&lang=css& ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, ".image-box[data-v-bc70db90] {\n  max-width: 300px;\n}\n\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/rawMaterialList/requestMaterial/Index.vue?vue&type=style&index=0&id=bc70db90&scoped=true&lang=css&":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/rawMaterialList/requestMaterial/Index.vue?vue&type=style&index=0&id=bc70db90&scoped=true&lang=css& ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_style_index_0_id_bc70db90_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=style&index=0&id=bc70db90&scoped=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/rawMaterialList/requestMaterial/Index.vue?vue&type=style&index=0&id=bc70db90&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_style_index_0_id_bc70db90_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_style_index_0_id_bc70db90_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/pm/pages/rawMaterialList/requestMaterial/Index.vue":
/*!*************************************************************************!*\
  !*** ./resources/js/pm/pages/rawMaterialList/requestMaterial/Index.vue ***!
  \*************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_bc70db90_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=bc70db90&scoped=true& */ "./resources/js/pm/pages/rawMaterialList/requestMaterial/Index.vue?vue&type=template&id=bc70db90&scoped=true&");
/* harmony import */ var _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js& */ "./resources/js/pm/pages/rawMaterialList/requestMaterial/Index.vue?vue&type=script&lang=js&");
/* harmony import */ var _Index_vue_vue_type_style_index_0_id_bc70db90_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Index.vue?vue&type=style&index=0&id=bc70db90&scoped=true&lang=css& */ "./resources/js/pm/pages/rawMaterialList/requestMaterial/Index.vue?vue&type=style&index=0&id=bc70db90&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Index_vue_vue_type_template_id_bc70db90_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _Index_vue_vue_type_template_id_bc70db90_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "bc70db90",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pm/pages/rawMaterialList/requestMaterial/Index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pm/pages/rawMaterialList/requestMaterial/Index.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/pm/pages/rawMaterialList/requestMaterial/Index.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/rawMaterialList/requestMaterial/Index.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/pm/pages/rawMaterialList/requestMaterial/Index.vue?vue&type=style&index=0&id=bc70db90&scoped=true&lang=css&":
/*!**********************************************************************************************************************************!*\
  !*** ./resources/js/pm/pages/rawMaterialList/requestMaterial/Index.vue?vue&type=style&index=0&id=bc70db90&scoped=true&lang=css& ***!
  \**********************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_style_index_0_id_bc70db90_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/style-loader/dist/cjs.js!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=style&index=0&id=bc70db90&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/rawMaterialList/requestMaterial/Index.vue?vue&type=style&index=0&id=bc70db90&scoped=true&lang=css&");


/***/ }),

/***/ "./resources/js/pm/pages/rawMaterialList/requestMaterial/Index.vue?vue&type=template&id=bc70db90&scoped=true&":
/*!********************************************************************************************************************!*\
  !*** ./resources/js/pm/pages/rawMaterialList/requestMaterial/Index.vue?vue&type=template&id=bc70db90&scoped=true& ***!
  \********************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_bc70db90_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_bc70db90_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_bc70db90_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=template&id=bc70db90&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/rawMaterialList/requestMaterial/Index.vue?vue&type=template&id=bc70db90&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/rawMaterialList/requestMaterial/Index.vue?vue&type=template&id=bc70db90&scoped=true&":
/*!***********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/rawMaterialList/requestMaterial/Index.vue?vue&type=template&id=bc70db90&scoped=true& ***!
  \***********************************************************************************************************************************************************************************************************************************************************/
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
    { staticClass: "col-lg-12" },
    [
      _c("div", { staticClass: "ibox" }, [
        _c("div", { staticClass: "ibox-title" }, [
          _c("div", { staticClass: "row align-items-center" }, [
            _c("div", { staticClass: "col-sm-12 col-lg-12 align-middle" }, [
              _c("h4", { staticClass: "tw-text-lg tw-py-1" }, [
                _vm._v(
                  "\n            ร้องขอวัตถุดิบเพิ่ม : " +
                    _vm._s(_vm.item.name) +
                    "\n          "
                )
              ])
            ])
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "ibox-content" }, [
          _c("form", { on: { submit: _vm.handleSave } }, [
            _c("div", { staticClass: "row" }, [
              _c("div", { staticClass: "col-lg-6 col-sm-12" }, [
                _c("div", { staticClass: "form-group row tw-items-center" }, [
                  _c("label", {
                    staticClass: "col-lg-3 col-sm-5 col-form-label"
                  }),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-lg-9" }, [
                    _c("img", {
                      staticClass: "image-box",
                      attrs: {
                        src: _vm.item.img
                          ? _vm.item.img
                          : "/images/no-image.png",
                        alt: ""
                      }
                    })
                  ])
                ])
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "row" }, [
              _c("div", { staticClass: "col-lg-6 col-sm-12" }, [
                _c("div", { staticClass: "form-group row" }, [
                  _vm._m(0),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-lg-9" },
                    [
                      _c(
                        "el-select",
                        {
                          attrs: {
                            filterable: "",
                            clearable: "",
                            remote: "",
                            id: "select-box1",
                            required: "true",
                            "data-toggle": "popover",
                            "data-placement": "bottom",
                            "data-content": _vm.validate.machine,
                            placeholder: "หมายเลขเครื่อง"
                          },
                          on: {
                            change: _vm.changeMachineSet,
                            focus: function($event) {
                              return _vm.popoverHide("select-box1")
                            }
                          },
                          model: {
                            value: _vm.el.machine,
                            callback: function($$v) {
                              _vm.$set(_vm.el, "machine", $$v)
                            },
                            expression: "el.machine"
                          }
                        },
                        _vm._l(_vm.machine_relations, function(item, k) {
                          return _c("el-option", {
                            key: k,
                            attrs: {
                              label: item.machine_set,
                              value: item.machine_set
                            }
                          })
                        }),
                        1
                      )
                    ],
                    1
                  )
                ])
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "row" }, [
              _c("div", { staticClass: "col-lg-6 col-sm-12" }, [
                _c("div", { staticClass: "form-group row" }, [
                  _vm._m(1),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-lg-9" },
                    [
                      _c(
                        "el-select",
                        {
                          attrs: {
                            filterable: "",
                            clearable: "",
                            remote: "",
                            id: "select-box2",
                            placeholder: "ตราบุหรี่",
                            "data-toggle": "popover",
                            "data-placement": "bottom",
                            "data-content": _vm.validate.ingredients
                          },
                          on: {
                            change: _vm.changeIngredients,
                            focus: function($event) {
                              return _vm.popoverHide("select-box2")
                            }
                          },
                          model: {
                            value: _vm.el.ingredients,
                            callback: function($$v) {
                              _vm.$set(_vm.el, "ingredients", $$v)
                            },
                            expression: "el.ingredients"
                          }
                        },
                        _vm._l(_vm.request_ingredients, function(item, k) {
                          return _c("el-option", {
                            key: k,
                            attrs: {
                              label: item.item_desc,
                              value: item.item_no
                            }
                          })
                        }),
                        1
                      )
                    ],
                    1
                  )
                ])
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "row" }, [
              _c("div", { staticClass: "col-lg-6 col-sm-12" }, [
                _c("div", { staticClass: "form-group row" }, [
                  _c("label", {
                    staticClass: "col-lg-3 col-sm-5 col-form-label"
                  }),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-lg-9" }, [
                    _c(
                      "button",
                      {
                        class: _vm.btn_trans.save.class,
                        attrs: { type: "submit" }
                      },
                      [
                        _c("i", { class: _vm.btn_trans.save.icon }),
                        _vm._v(
                          "\n                  " +
                            _vm._s(_vm.btn_trans.save.text) +
                            "\n                "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "button",
                      {
                        class: _vm.btn_trans.cancel.class,
                        attrs: { type: "button" },
                        on: { click: _vm.resetEl }
                      },
                      [
                        _c("i", { class: _vm.btn_trans.cancel.icon }),
                        _vm._v(
                          "\n                  " +
                            _vm._s(_vm.btn_trans.cancel.text) +
                            "\n                "
                        )
                      ]
                    )
                  ])
                ])
              ])
            ])
          ])
        ])
      ]),
      _vm._v(" "),
      _c("loading", {
        attrs: { active: _vm.isLoading, "is-full-page": true },
        on: {
          "update:active": function($event) {
            _vm.isLoading = $event
          }
        }
      })
    ],
    1
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "col-lg-3 col-sm-5 col-form-label" }, [
      _vm._v("หมายเลขเครื่อง "),
      _c("span", { staticStyle: { color: "red" } }, [_vm._v("*")]),
      _vm._v(":")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "col-lg-3 col-sm-5 col-form-label" }, [
      _vm._v("ตราบุหรี่ "),
      _c("span", { staticStyle: { color: "red" } }, [_vm._v("*")]),
      _vm._v(":")
    ])
  }
]
render._withStripped = true



/***/ })

}]);