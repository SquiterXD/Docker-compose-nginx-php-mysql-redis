(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ir_settings_rounding-asset_FormComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/rounding-asset/FormComponent.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/rounding-asset/FormComponent.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);


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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['policyLists', 'defaultValue', 'urlSave', 'urlReset'],
  data: function data() {
    return {
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      isEdit: this.defaultValue ? true : false,
      form: {
        policy_set_header_id: '',
        policy_set_description: '',
        asset_id: '',
        asset_name: ''
      },
      rules: {
        policy_set_header_id: [{
          required: true,
          message: 'กรุณาระบุ กรมธรรม์',
          trigger: "blur"
        }],
        asset_id: [{
          required: true,
          message: 'กรุณาระบุ รหัสทรัพย์สิน',
          trigger: "blur"
        }]
      },
      assetList: [],
      assetDisable: true
    };
  },
  mounted: function mounted() {
    if (this.defaultValue) {
      this.form.policy_set_header_id = this.defaultValue.policy_set_header_id;
      this.form.asset_id = Number(this.defaultValue.asset_id);
      this.getPolicyDetail();
      this.getAssetList(this.form.asset_id);
    }
  },
  methods: {
    getAssetList: function getAssetList(query) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                if (!_this.form.policy_set_header_id) {
                  _context.next = 6;
                  break;
                }

                _this.assetList = [];
                _context.next = 4;
                return axios.get("/ir/ajax/rounding-asset/get-asset", {
                  params: {
                    query: query,
                    policy_set_header_id: _this.form.policy_set_header_id,
                    asset_id: _this.form.asset_id
                  }
                }).then(function (res) {
                  _this.assetDisable = false;
                  _this.assetList = res.data;
                });

              case 4:
                _context.next = 9;
                break;

              case 6:
                _this.assetList = [];
                _this.form.asset_id = '';
                _this.assetDisable = true;

              case 9:
                if (_this.form.asset_id) {
                  _this.getAssetDetail();
                }

              case 10:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getPolicyDetail: function getPolicyDetail() {
      var _this2 = this;

      this.form.policy_set_description = '';

      if (this.form.policy_set_header_id) {
        var check = this.policyLists.find(function (list) {
          return list.policy_set_header_id == _this2.form.policy_set_header_id;
        });
        this.form.policy_set_description = check.policy_set_description;
      }
    },
    getAssetDetail: function getAssetDetail() {
      var _this3 = this;

      this.form.asset_name = '';
      console.log('getAssetDetail <-->  ', this.form.asset_id);

      if (this.form.asset_id) {
        console.log('getAssetDetail <-->  ', this.assetList);
        var check = this.assetList.find(function (list) {
          return list.asset_id == _this3.form.asset_id;
        });
        this.form.asset_name = check ? check.description : '';
      }
    },
    clickSave: function clickSave() {
      if (this.isEdit) {
        this.clickUpdate();
      } else {
        this.clickCreate();
      }
    },
    clickCreate: function clickCreate() {
      var vm = this;
      this.$refs.save_data.validate(function (valid) {
        if (valid) {
          var params = {
            form: vm.form
          };
          axios.post("/ir/settings/rounding-asset", params).then(function (res) {
            swal({
              title: "Success",
              text: "บันทึกข้อมูลเรียบร้อยแล้ว",
              type: "success",
              showConfirmButton: true
            }, function (isConfirm) {
              window.location.href = '/ir/settings/rounding-asset';
            });
          })["catch"](function (err) {
            swal({
              title: "Warning",
              text: "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากมีข้อผิดพลาด",
              type: "warning",
              showCancelButton: false
            });
          }).then(function () {
            vm.loading = false;
          });
        }
      });
    },
    clickUpdate: function clickUpdate() {
      var vm = this;
      this.$refs.save_data.validate(function (valid) {
        if (valid) {
          var params = {
            form: vm.form
          };
          axios.put(vm.urlSave, params).then(function (res) {
            swal({
              title: "Success",
              text: "บันทึกข้อมูลเรียบร้อยแล้ว",
              type: "success",
              showConfirmButton: true
            }, function (isConfirm) {
              window.location.href = '/ir/settings/rounding-asset';
            });
          })["catch"](function (err) {
            swal({
              title: "Warning",
              text: "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากมีข้อผิดพลาด",
              type: "warning",
              showCancelButton: false
            });
          }).then(function () {
            vm.loading = false;
          });
        }
      });
    },
    clickCancel: function clickCancel() {
      window.location.href = '/ir/settings/rounding-asset';
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/rounding-asset/FormComponent.vue?vue&type=style&index=0&id=0dad909c&lang=scss&scoped=true&":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/rounding-asset/FormComponent.vue?vue&type=style&index=0&id=0dad909c&lang=scss&scoped=true& ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, ".error-message[data-v-0dad909c] {\n  display: flex;\n  color: #ec4958;\n  margin-top: 5px;\n}\n.error-message strong[data-v-0dad909c] {\n  margin-right: 5px;\n}", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/rounding-asset/FormComponent.vue?vue&type=style&index=0&id=0dad909c&lang=scss&scoped=true&":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/rounding-asset/FormComponent.vue?vue&type=style&index=0&id=0dad909c&lang=scss&scoped=true& ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_FormComponent_vue_vue_type_style_index_0_id_0dad909c_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!../../../../../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./FormComponent.vue?vue&type=style&index=0&id=0dad909c&lang=scss&scoped=true& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/rounding-asset/FormComponent.vue?vue&type=style&index=0&id=0dad909c&lang=scss&scoped=true&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_FormComponent_vue_vue_type_style_index_0_id_0dad909c_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_FormComponent_vue_vue_type_style_index_0_id_0dad909c_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/components/ir/settings/rounding-asset/FormComponent.vue":
/*!******************************************************************************!*\
  !*** ./resources/js/components/ir/settings/rounding-asset/FormComponent.vue ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _FormComponent_vue_vue_type_template_id_0dad909c_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./FormComponent.vue?vue&type=template&id=0dad909c&scoped=true& */ "./resources/js/components/ir/settings/rounding-asset/FormComponent.vue?vue&type=template&id=0dad909c&scoped=true&");
/* harmony import */ var _FormComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./FormComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/settings/rounding-asset/FormComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _FormComponent_vue_vue_type_style_index_0_id_0dad909c_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./FormComponent.vue?vue&type=style&index=0&id=0dad909c&lang=scss&scoped=true& */ "./resources/js/components/ir/settings/rounding-asset/FormComponent.vue?vue&type=style&index=0&id=0dad909c&lang=scss&scoped=true&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _FormComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _FormComponent_vue_vue_type_template_id_0dad909c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _FormComponent_vue_vue_type_template_id_0dad909c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "0dad909c",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/settings/rounding-asset/FormComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/settings/rounding-asset/FormComponent.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/rounding-asset/FormComponent.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_FormComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./FormComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/rounding-asset/FormComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_FormComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/settings/rounding-asset/FormComponent.vue?vue&type=style&index=0&id=0dad909c&lang=scss&scoped=true&":
/*!****************************************************************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/rounding-asset/FormComponent.vue?vue&type=style&index=0&id=0dad909c&lang=scss&scoped=true& ***!
  \****************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_FormComponent_vue_vue_type_style_index_0_id_0dad909c_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/style-loader/dist/cjs.js!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!../../../../../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./FormComponent.vue?vue&type=style&index=0&id=0dad909c&lang=scss&scoped=true& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/rounding-asset/FormComponent.vue?vue&type=style&index=0&id=0dad909c&lang=scss&scoped=true&");


/***/ }),

/***/ "./resources/js/components/ir/settings/rounding-asset/FormComponent.vue?vue&type=template&id=0dad909c&scoped=true&":
/*!*************************************************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/rounding-asset/FormComponent.vue?vue&type=template&id=0dad909c&scoped=true& ***!
  \*************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_FormComponent_vue_vue_type_template_id_0dad909c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_FormComponent_vue_vue_type_template_id_0dad909c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_FormComponent_vue_vue_type_template_id_0dad909c_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./FormComponent.vue?vue&type=template&id=0dad909c&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/rounding-asset/FormComponent.vue?vue&type=template&id=0dad909c&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/rounding-asset/FormComponent.vue?vue&type=template&id=0dad909c&scoped=true&":
/*!****************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/rounding-asset/FormComponent.vue?vue&type=template&id=0dad909c&scoped=true& ***!
  \****************************************************************************************************************************************************************************************************************************************************************/
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
    { attrs: { id: "submitForm" } },
    [
      _c(
        "el-form",
        {
          ref: "save_data",
          staticClass: "demo-dynamic form_table_line",
          attrs: { model: _vm.form, "label-width": "120px" }
        },
        [
          _c("div", [
            _c("div", { staticClass: "row" }, [
              _c(
                "label",
                { staticClass: "col-md-4 col-form-label lable_align" },
                [
                  _c("strong", [
                    _vm._v("กรมธรรม์ชุดที่ (Policy No)"),
                    _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
                  ])
                ]
              ),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-xl-4 col-lg-5 col-md-6 el_field" },
                [
                  _c(
                    "el-form-item",
                    {
                      attrs: {
                        prop: "policy_set_header_id",
                        rules: _vm.rules.policy_set_header_id
                      }
                    },
                    [
                      _c("input", {
                        attrs: { type: "hidden", name: "policy_set_header_id" },
                        domProps: { value: _vm.form.policy_set_header_id }
                      }),
                      _vm._v(" "),
                      _c(
                        "el-select",
                        {
                          attrs: {
                            placeholder: "กรมธรรม์",
                            remote: "",
                            clearable: "",
                            filterable: "",
                            disabled: _vm.isEdit
                          },
                          on: {
                            change: function($event) {
                              _vm.getPolicyDetail()
                              _vm.getAssetList()
                            }
                          },
                          model: {
                            value: _vm.form.policy_set_header_id,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "policy_set_header_id", $$v)
                            },
                            expression: "form.policy_set_header_id"
                          }
                        },
                        _vm._l(_vm.policyLists, function(data, index) {
                          return _c(
                            "el-option",
                            {
                              key: index,
                              attrs: {
                                label: data.policy_set_number,
                                value: data.policy_set_header_id
                              }
                            },
                            [
                              _c("span", { staticStyle: { float: "left" } }, [
                                _vm._v(_vm._s(data.policy_set_number))
                              ]),
                              _vm._v(" "),
                              _c("span", { staticStyle: { float: "left" } }, [
                                _vm._v(
                                  " : " + _vm._s(data.policy_set_description)
                                )
                              ])
                            ]
                          )
                        }),
                        1
                      )
                    ],
                    1
                  )
                ],
                1
              )
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "row" }, [
              _c(
                "label",
                { staticClass: "col-md-4 col-form-label lable_align" },
                [
                  _c("strong", [
                    _vm._v("คำอธิบายกรมธรรม์ชุดที่ (Policy Description)")
                  ])
                ]
              ),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-xl-4 col-lg-5 col-md-6 el_field" },
                [
                  _c(
                    "el-form-item",
                    [
                      _c("el-input", {
                        ref: "policy_set_description",
                        attrs: {
                          type: "text",
                          name: "policy_set_description",
                          placeholder: "คำอธิบายกรมธรรม์",
                          autocomplete: "off",
                          disabled: ""
                        },
                        model: {
                          value: _vm.form.policy_set_description,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "policy_set_description", $$v)
                          },
                          expression: "form.policy_set_description"
                        }
                      })
                    ],
                    1
                  )
                ],
                1
              )
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "row" }, [
              _c(
                "label",
                { staticClass: "col-md-4 col-form-label lable_align" },
                [
                  _c("strong", [
                    _vm._v("รหัสทรัพย์สิน (Asset Number)"),
                    _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
                  ])
                ]
              ),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-xl-4 col-lg-5 col-md-6 el_field" },
                [
                  _c(
                    "el-form-item",
                    { attrs: { prop: "asset_id", rules: _vm.rules.asset_id } },
                    [
                      _c("input", {
                        attrs: { type: "hidden", name: "asset_id" },
                        domProps: { value: _vm.form.asset_id }
                      }),
                      _vm._v(" "),
                      _c(
                        "el-select",
                        {
                          attrs: {
                            placeholder: "รหัสทรัพย์สิน",
                            remote: "",
                            clearable: "",
                            filterable: "",
                            disabled: _vm.assetDisable,
                            "remote-method": _vm.getAssetList
                          },
                          on: {
                            change: function($event) {
                              _vm.getAssetList(_vm.form.asset_id)
                              _vm.getAssetDetail()
                            }
                          },
                          model: {
                            value: _vm.form.asset_id,
                            callback: function($$v) {
                              _vm.$set(_vm.form, "asset_id", $$v)
                            },
                            expression: "form.asset_id"
                          }
                        },
                        _vm._l(_vm.assetList, function(data, index) {
                          return _c(
                            "el-option",
                            {
                              key: index,
                              attrs: {
                                label: data.asset_number,
                                value: data.asset_id
                              }
                            },
                            [
                              _c("span", { staticStyle: { float: "left" } }, [
                                _vm._v(_vm._s(data.asset_number))
                              ]),
                              _vm._v(" "),
                              _c("span", { staticStyle: { float: "left" } }, [
                                _vm._v(" : " + _vm._s(data.description))
                              ])
                            ]
                          )
                        }),
                        1
                      )
                    ],
                    1
                  )
                ],
                1
              )
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "row" }, [
              _c(
                "label",
                { staticClass: "col-md-4 col-form-label lable_align" },
                [
                  _c("strong", [
                    _vm._v("คำอธิบายรหัสทรัพย์สิน (Asset Description)")
                  ])
                ]
              ),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-xl-4 col-lg-5 col-md-6 el_field" },
                [
                  _c(
                    "el-form-item",
                    [
                      _c("el-input", {
                        ref: "asset_name",
                        attrs: {
                          type: "text",
                          name: "asset_name",
                          placeholder: "คำอธิบายรหัสทรัพย์สิน",
                          autocomplete: "off",
                          disabled: ""
                        },
                        model: {
                          value: _vm.form.asset_name,
                          callback: function($$v) {
                            _vm.$set(_vm.form, "asset_name", $$v)
                          },
                          expression: "form.asset_name"
                        }
                      })
                    ],
                    1
                  )
                ],
                1
              )
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "row mt-2" }, [
              _c("div", { staticClass: "col-12 text-right" }, [
                _c(
                  "button",
                  {
                    staticClass: "btn btn-sm btn-primary",
                    attrs: { type: "button" },
                    on: { click: _vm.clickSave }
                  },
                  [
                    _c("i", { staticClass: "fa fa-save" }),
                    _vm._v(" บันทึก\n                    ")
                  ]
                ),
                _vm._v(" "),
                _c(
                  "button",
                  {
                    staticClass: "btn btn-sm btn-warning",
                    attrs: { type: "button" },
                    on: { click: _vm.clickCancel }
                  },
                  [
                    _vm._v(
                      "\n                        ยกเลิก\n                    "
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