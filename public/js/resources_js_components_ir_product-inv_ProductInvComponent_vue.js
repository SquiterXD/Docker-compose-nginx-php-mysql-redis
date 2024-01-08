(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ir_product-inv_ProductInvComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/ProductInvComponent.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/ProductInvComponent.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ProductInvLineComponent_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ProductInvLineComponent.vue */ "./resources/js/components/ir/product-inv/ProductInvLineComponent.vue");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
    productLine: _ProductInvLineComponent_vue__WEBPACK_IMPORTED_MODULE_0__.default
  },
  props: ['groupProducts', 'policySets', 'subInventories', 'departments', 'url', 'oldGroupCode', 'data', 'oldInput', 'btnTrans'],
  data: function data() {
    return {
      groupCode: this.oldGroupCode ? this.oldGroupCode : '',
      create: false,
      selectGroup: []
    };
  },
  mounted: function mounted() {
    if (this.groupCode) {
      this.createLine();
    }

    if (this.oldInput.length != 0) {
      this.groupCode = this.oldInput.group_code;
      this.createLine();
    }

    if (this.data == "DuplicateHeader") {
      swal({
        title: "warning !",
        text: "มีข้อมูลซ้ำ ระดับ header",
        type: "warning",
        showConfirmButton: true
      });
    } else if (this.data == "DuplicateLine") {
      swal({
        title: "warning !",
        text: "มีข้อมูลซ้ำ ระดับ Line",
        type: "warning",
        showConfirmButton: true
      });
    }
  },
  methods: {
    createLine: function createLine() {
      this.create = true;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/ProductInvLineComponent.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/ProductInvLineComponent.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var uuid_v1__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! uuid/v1 */ "./node_modules/uuid/v1.js");
/* harmony import */ var uuid_v1__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(uuid_v1__WEBPACK_IMPORTED_MODULE_1__);


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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ['groupCode', 'backUrl', 'oldInput', 'btnTrans'],
  data: function data() {
    return {
      product: '',
      department_code: this.oldInput.length != 0 ? this.oldInput.department_code : '',
      subinventory_code: this.oldInput.length != 0 ? this.oldInput.subinventory_code : '',
      subGroup: this.oldInput.length != 0 ? this.oldInput.sub_group_code : '',
      departments: [],
      subInventories: [],
      subGroups: [],
      itemCategories: [],
      policy_set_header: '',
      itemLocatorsLists: [],
      account_combine: '',
      asset_group_code: '',
      accounts_mapping: '',
      account_code: '',
      isDisabled: true,
      isLoading: false,
      isDisabledBtu: false,
      lines: [],
      id: uuid_v1__WEBPACK_IMPORTED_MODULE_1___default()(),
      lineId: '',
      cate_code: '',
      loading: {
        locator: false
      },
      lineList: false,
      activeFlag: true,
      value: ''
    };
  },
  mounted: function mounted() {
    if (this.oldInput.length != 0) {
      this.addLine();
    } else {
      this.addLine();
    }

    if (this.groupCode) {
      this.ProductH();
    }
  },
  watch: {
    groupCode: function groupCode() {
      this.ProductH();
    }
  },
  methods: {
    ProductH: function ProductH() {
      var _this = this;

      this.isLoading = true;
      this.product = '';
      this.departments = [];
      this.subInventories = [];
      this.subGroups = [];
      this.itemCategories = [];
      this.policy_set_header = '';
      this.account_combine = '';
      this.accounts_mapping = '';
      this.asset_group_code = '';
      this.account_code = '';

      if (this.groupCode) {
        axios.get("/ir/ajax/product-group", {
          params: {
            groupCode: this.groupCode
          }
        }).then(function (res) {
          var dt = res.data.data;
          _this.product = dt.groupProduct;
          _this.departments = dt.departments;
          _this.subInventories = dt.subInventories;
          _this.subGroups = dt.subGroups;
          _this.itemCategories = dt.itemCategories;
          _this.policy_set_header = dt.groupProduct ? dt.groupProduct.policy_set_header : '';
          _this.accounts_mapping = dt.groupProduct ? dt.groupProduct.accounts_mapping : '';
          _this.account_combine = dt.groupProduct ? dt.groupProduct.accounts_mapping.account_combine : '';
          _this.asset_group_code = dt.groupProduct ? dt.groupProduct.asset_group.description : '';
          _this.isLoading = false;
        });
      }
    },
    getLocator: function getLocator(value) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                params = {
                  subinventory_code: value
                };
                _this2.loading.locator = true;
                return _context.abrupt("return", axios.get('/ir/ajax/get-locator', {
                  params: params
                }).then(function (res) {
                  if (res.data.status == 'e') {
                    swal({
                      title: "warning !",
                      text: "รหัสคลังสินค้านี้ ไม่มีLocator",
                      type: "warning",
                      showConfirmButton: true
                    });
                    _this2.itemLocatorsLists = [];
                    _this2.loading.locator = false;
                    _this2.locator = '';
                    _this2.isDisabled = true;
                  } else if (res.data.status == 'clearData') {
                    _this2.itemLocatorsLists = [];
                    _this2.loading.locator = false;
                    _this2.locator = '';
                    _this2.isDisabled = true;
                  } else {
                    _this2.itemLocatorsLists = res.data.itemLocators;
                    _this2.loading.locator = false;
                    _this2.locator = '';
                    _this2.isDisabled = false;
                  }
                }));

              case 3:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    addLine: function addLine() {
      var _this3 = this;

      if (this.oldInput.length != 0) {
        this.oldInput.cate_codes.forEach(function (element, index) {
          _this3.getLocator(_this3.oldInput.subinventory_code);

          _this3.lines.push({
            id: uuid_v1__WEBPACK_IMPORTED_MODULE_1___default()(),
            cate_code: element === null ? '' : Number(element),
            locator: element === null ? '' : _this3.oldInput.locators[index]
          });
        });
        return this.oldInput = [];
      } else {
        this.lines.push({
          id: uuid_v1__WEBPACK_IMPORTED_MODULE_1___default()(),
          cate_code: '',
          locator: this.locator ? this.locator : ''
        });
      }

      this.$nextTick(function () {
        var el = _this3.$el.getElementsByClassName('endTable')[0];

        if (el) {
          el.scrollIntoView({
            behavior: "smooth",
            block: "center",
            inline: "nearest"
          });
        }
      });
    },
    removeRow: function removeRow(index) {
      this.lines.splice(index, 1);
    },
    checkDuplicateCategory: function checkDuplicateCategory(index) {
      var _this4 = this;

      this.lines.forEach(function (element, i) {
        if (i != index) {
          if (_this4.lines[index].cate_code == element.cate_code && _this4.lines[index].locator == element.locator) {
            _this4.showAlert();
          }
        }
      });
    },
    checkDuplicateLocators: function checkDuplicateLocators(index) {
      var _this5 = this;

      this.lines.forEach(function (element, i) {
        if (i != index) {
          if (_this5.lines[index].locator == element.locator && _this5.lines[index].cate_code == element.cate_code) {
            _this5.showAlert();
          }
        }
      });

      if (this.lines.locator != '') {
        this.searchFunction();
      }
    },
    showAlert: function showAlert() {
      swal({
        title: "Error !",
        text: "ไม่สามารถเลือกชุดข้อมูลนี้ได้ เนื่องจากมีชุดข้อมูลซ้ำ",
        type: "error",
        showConfirmButton: true
      });
    },
    searchFunction: function searchFunction(query) {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this6.loading.locator = true;
                _context2.next = 3;
                return axios.get('/ir/ajax/get-value-set', {
                  params: {
                    subinventory_code: _this6.subinventory_code,
                    query: query
                  }
                }).then(function (res) {
                  _this6.itemLocatorsLists = res.data.data;
                })["catch"](function (err) {}).then(function () {
                  _this6.loading.locator = false;
                });

              case 3:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/ProductInvLineComponent.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/ProductInvLineComponent.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, ".sticky-col {\n  position: -webkit-sticky;\n  position: sticky;\n  background-color: #f7f7f7;\n  z-index: 9999;\n}\n.first-col {\n  width: 150px;\n  min-width: 100px;\n  max-width: 150px;\n  left: 0px;\n}\n.second-col {\n  width: 150px;\n  min-width: 150px;\n  max-width: 150px;\n  left: 116px;\n}\n.th-row {\n  top: 0;\n}\n.fo-col {\n  width: 200px;\n  min-width: 150px;\n  max-width: 200px;\n  left: 416px;\n}\n.fi-col {\n  width: 200px;\n  min-width: 150px;\n  max-width: 200px;\n  left: 566px;\n}\n.t1-col {\n  width: 200px;\n  min-width: 150px;\n  max-width: 200px;\n  left: 0px;\n}\n.t2-col {\n  width: 200px;\n  min-width: 150px;\n  max-width: 200px;\n  left: 566px;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/ProductInvLineComponent.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/ProductInvLineComponent.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ProductInvLineComponent_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ProductInvLineComponent.vue?vue&type=style&index=0&scope=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/ProductInvLineComponent.vue?vue&type=style&index=0&scope=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ProductInvLineComponent_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ProductInvLineComponent_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/components/ir/product-inv/ProductInvComponent.vue":
/*!************************************************************************!*\
  !*** ./resources/js/components/ir/product-inv/ProductInvComponent.vue ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ProductInvComponent_vue_vue_type_template_id_60327ab8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ProductInvComponent.vue?vue&type=template&id=60327ab8& */ "./resources/js/components/ir/product-inv/ProductInvComponent.vue?vue&type=template&id=60327ab8&");
/* harmony import */ var _ProductInvComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ProductInvComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/product-inv/ProductInvComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _ProductInvComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ProductInvComponent_vue_vue_type_template_id_60327ab8___WEBPACK_IMPORTED_MODULE_0__.render,
  _ProductInvComponent_vue_vue_type_template_id_60327ab8___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/product-inv/ProductInvComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/product-inv/ProductInvLineComponent.vue":
/*!****************************************************************************!*\
  !*** ./resources/js/components/ir/product-inv/ProductInvLineComponent.vue ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ProductInvLineComponent_vue_vue_type_template_id_73266f90___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ProductInvLineComponent.vue?vue&type=template&id=73266f90& */ "./resources/js/components/ir/product-inv/ProductInvLineComponent.vue?vue&type=template&id=73266f90&");
/* harmony import */ var _ProductInvLineComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ProductInvLineComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/product-inv/ProductInvLineComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _ProductInvLineComponent_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ProductInvLineComponent.vue?vue&type=style&index=0&scope=true&lang=css& */ "./resources/js/components/ir/product-inv/ProductInvLineComponent.vue?vue&type=style&index=0&scope=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _ProductInvLineComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ProductInvLineComponent_vue_vue_type_template_id_73266f90___WEBPACK_IMPORTED_MODULE_0__.render,
  _ProductInvLineComponent_vue_vue_type_template_id_73266f90___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/product-inv/ProductInvLineComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/product-inv/ProductInvComponent.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************!*\
  !*** ./resources/js/components/ir/product-inv/ProductInvComponent.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProductInvComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ProductInvComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/ProductInvComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProductInvComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/product-inv/ProductInvLineComponent.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/components/ir/product-inv/ProductInvLineComponent.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProductInvLineComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ProductInvLineComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/ProductInvLineComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ProductInvLineComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/product-inv/ProductInvLineComponent.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!************************************************************************************************************************!*\
  !*** ./resources/js/components/ir/product-inv/ProductInvLineComponent.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ProductInvLineComponent_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ProductInvLineComponent.vue?vue&type=style&index=0&scope=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/ProductInvLineComponent.vue?vue&type=style&index=0&scope=true&lang=css&");


/***/ }),

/***/ "./resources/js/components/ir/product-inv/ProductInvComponent.vue?vue&type=template&id=60327ab8&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/components/ir/product-inv/ProductInvComponent.vue?vue&type=template&id=60327ab8& ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ProductInvComponent_vue_vue_type_template_id_60327ab8___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ProductInvComponent_vue_vue_type_template_id_60327ab8___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ProductInvComponent_vue_vue_type_template_id_60327ab8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ProductInvComponent.vue?vue&type=template&id=60327ab8& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/ProductInvComponent.vue?vue&type=template&id=60327ab8&");


/***/ }),

/***/ "./resources/js/components/ir/product-inv/ProductInvLineComponent.vue?vue&type=template&id=73266f90&":
/*!***********************************************************************************************************!*\
  !*** ./resources/js/components/ir/product-inv/ProductInvLineComponent.vue?vue&type=template&id=73266f90& ***!
  \***********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ProductInvLineComponent_vue_vue_type_template_id_73266f90___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ProductInvLineComponent_vue_vue_type_template_id_73266f90___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ProductInvLineComponent_vue_vue_type_template_id_73266f90___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ProductInvLineComponent.vue?vue&type=template&id=73266f90& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/ProductInvLineComponent.vue?vue&type=template&id=73266f90&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/ProductInvComponent.vue?vue&type=template&id=60327ab8&":
/*!**********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/ProductInvComponent.vue?vue&type=template&id=60327ab8& ***!
  \**********************************************************************************************************************************************************************************************************************************************/
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
      _c(
        "div",
        { staticClass: "col-md", staticStyle: { "margin-left": "5px" } },
        [
          _c("label", { staticClass: "demonstration" }, [
            _vm._v(
              "\n                กลุ่มสินค้า (Product Group)\n            "
            )
          ]),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.groupCode,
                expression: "groupCode"
              }
            ],
            attrs: { type: "hidden", name: "group_code" },
            domProps: { value: _vm.groupCode },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.groupCode = $event.target.value
              }
            }
          }),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "input-group" },
            [
              _c(
                "el-select",
                {
                  staticClass: "w-100",
                  attrs: {
                    filterable: "",
                    remote: "",
                    clearable: "",
                    "reserve-keyword": "",
                    placeholder: "Select"
                  },
                  on: { change: _vm.createLine },
                  model: {
                    value: _vm.groupCode,
                    callback: function($$v) {
                      _vm.groupCode = $$v
                    },
                    expression: "groupCode"
                  }
                },
                _vm._l(_vm.groupProducts, function(groupProduct) {
                  return _c("el-option", {
                    key: groupProduct.group_product_id,
                    attrs: {
                      label:
                        groupProduct.policy_set_number +
                        " : " +
                        groupProduct.asset_group_description +
                        " : " +
                        groupProduct.group_product_description,
                      value: groupProduct.group_product_id
                    }
                  })
                }),
                1
              )
            ],
            1
          )
        ]
      )
    ]),
    _vm._v(" "),
    this.create
      ? _c(
          "div",
          { staticClass: "mt-2" },
          [
            _c("productLine", {
              attrs: {
                "group-code": _vm.groupCode,
                "back-url": _vm.url,
                oldInput: _vm.oldInput,
                btnTrans: _vm.btnTrans
              }
            })
          ],
          1
        )
      : _vm._e()
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/ProductInvLineComponent.vue?vue&type=template&id=73266f90&":
/*!**************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/ProductInvLineComponent.vue?vue&type=template&id=73266f90& ***!
  \**************************************************************************************************************************************************************************************************************************************************/
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
    _c(
      "div",
      {
        directives: [
          {
            name: "loading",
            rawName: "v-loading",
            value: _vm.isLoading,
            expression: "isLoading"
          }
        ]
      },
      [
        _c("div", { staticClass: "row col-lg-10 col-md-4" }, [
          _vm._m(0),
          _vm._v(" "),
          _vm.policy_set_header.policy_set_number !== undefined
            ? _c(
                "div",
                {
                  staticClass: "col-lg-7 col-md-7 w-100",
                  staticStyle: { "padding-top": "20px" }
                },
                [
                  _vm._v(
                    "\n                    " +
                      _vm._s(
                        this.policy_set_header.policy_set_number +
                          " : " +
                          this.policy_set_header.policy_set_description
                      ) +
                      " \n                "
                  )
                ]
              )
            : _vm._e()
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row col-lg-10 col-md-4" }, [
          _vm._m(1),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass: "col-lg-7 col-md-7 w-100",
              staticStyle: { "padding-top": "20px" }
            },
            [
              _vm._v(
                "\n                    " +
                  _vm._s(this.asset_group_code) +
                  " \n                "
              )
            ]
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row col-lg-10 col-md-4" }, [
          _vm._m(2),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass: "col-lg-7 col-md-7 w-100",
              staticStyle: { "padding-top": "20px" }
            },
            [
              _vm._v(
                "\n                    " +
                  _vm._s(this.product.description) +
                  " \n                "
              )
            ]
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row col-lg-10 col-md-4" }, [
          _vm._m(3),
          _vm._v(" "),
          _vm.accounts_mapping.account_code !== undefined
            ? _c(
                "div",
                {
                  staticClass: "col-lg-7 col-md-7 w-100",
                  staticStyle: { "padding-top": "20px" }
                },
                [
                  _vm._v(
                    "\n                    " +
                      _vm._s(
                        this.accounts_mapping.account_code +
                          " : " +
                          this.accounts_mapping.description
                      ) +
                      " \n                "
                  )
                ]
              )
            : _vm._e()
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row col-lg-10 col-md-4" }, [
          _vm._m(4),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass: "col-lg-7 col-md-7 w-100",
              staticStyle: { "padding-top": "20px" }
            },
            [
              _vm._v(
                "\n                    " +
                  _vm._s(this.account_combine) +
                  " \n                "
              )
            ]
          )
        ])
      ]
    ),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass: "row",
        staticStyle: { "padding-left": "15px", "padding-top": "10px" }
      },
      [
        _vm._m(5),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass: "col-sm-4 el_select padding_12",
            staticStyle: { "margin-left": "20px" }
          },
          [
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.department_code,
                  expression: "department_code"
                }
              ],
              attrs: {
                type: "hidden",
                name: "department_code",
                autocomplete: "off"
              },
              domProps: { value: _vm.department_code },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.department_code = $event.target.value
                }
              }
            }),
            _vm._v(" "),
            _c(
              "el-select",
              {
                attrs: {
                  filterable: "",
                  remote: "",
                  clearable: "",
                  "reserve-keyword": ""
                },
                model: {
                  value: _vm.department_code,
                  callback: function($$v) {
                    _vm.department_code = $$v
                  },
                  expression: "department_code"
                }
              },
              _vm._l(_vm.departments, function(department) {
                return _c("el-option", {
                  key: department.department_code,
                  attrs: {
                    label:
                      department.department_code +
                      " : " +
                      department.description,
                    value:
                      department.department_code + "," + department.description
                  }
                })
              }),
              1
            )
          ],
          1
        )
      ]
    ),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass: "row",
        staticStyle: { "padding-left": "15px", "padding-top": "10px" }
      },
      [
        _vm._m(6),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass: "col-sm-4 el_select padding_12",
            staticStyle: { "margin-left": "20px" }
          },
          [
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.subinventory_code,
                  expression: "subinventory_code"
                }
              ],
              attrs: {
                type: "hidden",
                name: "subinventory_code",
                autocomplete: "off"
              },
              domProps: { value: _vm.subinventory_code },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.subinventory_code = $event.target.value
                }
              }
            }),
            _vm._v(" "),
            _c(
              "el-select",
              {
                attrs: {
                  filterable: "",
                  remote: "",
                  clearable: "",
                  "reserve-keyword": ""
                },
                on: {
                  change: function($event) {
                    return _vm.getLocator(_vm.subinventory_code)
                  }
                },
                model: {
                  value: _vm.subinventory_code,
                  callback: function($$v) {
                    _vm.subinventory_code = $$v
                  },
                  expression: "subinventory_code"
                }
              },
              _vm._l(_vm.subInventories, function(subInventory, index) {
                return _c("el-option", {
                  key: index,
                  attrs: {
                    label:
                      subInventory.subinventory_code +
                      " : " +
                      subInventory.subinventory_desc,
                    value:
                      subInventory.subinventory_code +
                      "," +
                      subInventory.subinventory_desc
                  }
                })
              }),
              1
            )
          ],
          1
        )
      ]
    ),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass: "row",
        staticStyle: { "padding-left": "15px", "padding-top": "10px" }
      },
      [
        _vm._m(7),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass: "col-sm-4 el_select padding_12",
            staticStyle: { "margin-left": "15px" }
          },
          [
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.subGroup,
                  expression: "subGroup"
                }
              ],
              attrs: {
                type: "hidden",
                name: "sub_group_code",
                autocomplete: "off"
              },
              domProps: { value: _vm.subGroup },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.subGroup = $event.target.value
                }
              }
            }),
            _vm._v(" "),
            _c(
              "el-select",
              {
                attrs: {
                  filterable: "",
                  remote: "",
                  clearable: "",
                  "reserve-keyword": ""
                },
                model: {
                  value: _vm.subGroup,
                  callback: function($$v) {
                    _vm.subGroup = $$v
                  },
                  expression: "subGroup"
                }
              },
              _vm._l(_vm.subGroups, function(subGroup, index) {
                return _c("el-option", {
                  key: index,
                  attrs: {
                    label:
                      subGroup.sub_group_code +
                      " : " +
                      subGroup.sub_group_description,
                    value:
                      subGroup.sub_group_code +
                      "," +
                      subGroup.sub_group_description
                  }
                })
              }),
              1
            )
          ],
          1
        )
      ]
    ),
    _vm._v(" "),
    _c("div", { staticClass: "mt-2" }, [
      _c("hr"),
      _vm._v(" "),
      _c("div", { staticClass: "text-right" }, [
        _c(
          "button",
          {
            class: _vm.btnTrans.add.class + " btn-sm",
            attrs: { type: "submit" },
            on: {
              click: function($event) {
                $event.preventDefault()
                return _vm.addLine($event)
              }
            }
          },
          [
            _c("i", {
              class: _vm.btnTrans.add.icon,
              attrs: { "aria-hidden": "true" }
            }),
            _vm._v(
              " \n                " +
                _vm._s(_vm.btnTrans.add.text) +
                " \n            "
            )
          ]
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "table-responsive" }, [
        _c(
          "table",
          {
            staticClass: "table-sm",
            staticStyle: {
              display: "block",
              overflow: "auto",
              "max-height": "400px",
              position: "sticky"
            }
          },
          [
            _vm._m(8),
            _vm._v(" "),
            _c(
              "tbody",
              _vm._l(_vm.lines, function(row, index) {
                return _c(
                  "tr",
                  {
                    key: index,
                    class: [index == _vm.lines.length - 1 ? "endTable" : ""],
                    attrs: { row: row }
                  },
                  [
                    _c("td", { staticStyle: { "vertical-align": "middle" } }, [
                      _vm._v(" " + _vm._s(index + 1) + " ")
                    ]),
                    _vm._v(" "),
                    _c(
                      "td",
                      [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: row.cate_code,
                              expression: "row.cate_code"
                            }
                          ],
                          attrs: {
                            type: "hidden",
                            name: "cate_codes[]",
                            autocomplete: "off"
                          },
                          domProps: { value: row.cate_code },
                          on: {
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.$set(row, "cate_code", $event.target.value)
                            }
                          }
                        }),
                        _vm._v(" "),
                        _c(
                          "el-select",
                          {
                            staticClass: "w-100",
                            attrs: {
                              filterable: "",
                              remote: "",
                              clearable: "",
                              "reserve-keyword": ""
                            },
                            on: {
                              change: function($event) {
                                return _vm.checkDuplicateCategory(index)
                              }
                            },
                            model: {
                              value: row.cate_code,
                              callback: function($$v) {
                                _vm.$set(row, "cate_code", $$v)
                              },
                              expression: "row.cate_code"
                            }
                          },
                          _vm._l(_vm.itemCategories, function(
                            itemCategory,
                            index
                          ) {
                            return _c("el-option", {
                              key: index,
                              attrs: {
                                label:
                                  itemCategory.lookup_code +
                                  " : " +
                                  itemCategory.description,
                                value: itemCategory.lookup_code
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
                      "td",
                      [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: row.locator,
                              expression: "row.locator"
                            }
                          ],
                          attrs: {
                            type: "hidden",
                            name: "locators[]",
                            autocomplete: "off"
                          },
                          domProps: { value: row.locator },
                          on: {
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.$set(row, "locator", $event.target.value)
                            }
                          }
                        }),
                        _vm._v(" "),
                        _c(
                          "el-select",
                          {
                            directives: [
                              {
                                name: "loading",
                                rawName: "v-loading",
                                value: _vm.loading.locator,
                                expression: "loading.locator"
                              }
                            ],
                            staticClass: "w-100",
                            attrs: {
                              filterable: "",
                              remote: "",
                              clearable: "",
                              "reserve-keyword": "",
                              "remote-method": _vm.searchFunction,
                              disabled: _vm.isDisabled
                            },
                            on: {
                              change: function($event) {
                                return _vm.checkDuplicateLocators(index)
                              }
                            },
                            model: {
                              value: row.locator,
                              callback: function($$v) {
                                _vm.$set(row, "locator", $$v)
                              },
                              expression: "row.locator"
                            }
                          },
                          _vm._l(_vm.itemLocatorsLists, function(
                            itemLocatorsList,
                            index
                          ) {
                            return _c("el-option", {
                              key: index,
                              attrs: {
                                label:
                                  itemLocatorsList.meaning +
                                  " : " +
                                  itemLocatorsList.description,
                                value: itemLocatorsList.flex_value
                              }
                            })
                          }),
                          1
                        )
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c("td", { staticStyle: { "vertical-align": "middle" } }, [
                      _c(
                        "button",
                        {
                          staticClass: "btn btn-sm btn-danger",
                          on: {
                            click: function($event) {
                              $event.preventDefault()
                              return _vm.removeRow(index)
                            }
                          }
                        },
                        [
                          _c("i", {
                            staticClass: "fa fa-times",
                            attrs: { "aria-hidden": "true" }
                          })
                        ]
                      )
                    ])
                  ]
                )
              }),
              0
            )
          ]
        )
      ])
    ]),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass: "row",
        staticStyle: { "padding-left": "20px", "padding-top": "10px" }
      },
      [
        _c("label", [_vm._v("Active")]),
        _c("span", { staticClass: "text-danger" }, [_vm._v(" *")]),
        _vm._v(" "),
        _c("input", {
          attrs: { type: "hidden", name: "activeFlag" },
          domProps: { value: _vm.activeFlag }
        }),
        _vm._v(" "),
        _c("el-checkbox", {
          staticStyle: { "margin-left": "45px" },
          attrs: { size: "medium" },
          model: {
            value: _vm.activeFlag,
            callback: function($$v) {
              _vm.activeFlag = $$v
            },
            expression: "activeFlag"
          }
        })
      ],
      1
    ),
    _vm._v(" "),
    _c("div", { staticClass: "row clearfix text-right" }, [
      _c("div", { staticClass: "col", staticStyle: { "margin-top": "15px" } }, [
        _c(
          "button",
          {
            class: _vm.btnTrans.save.class + " btn-sm",
            attrs: { type: "submit", disabled: _vm.isDisabledBtu }
          },
          [
            _c("i", {
              class: _vm.btnTrans.save.icon,
              attrs: { "aria-hidden": "true" }
            }),
            _vm._v(
              " \n                " +
                _vm._s(_vm.btnTrans.save.text) +
                " \n            "
            )
          ]
        ),
        _vm._v(" "),
        _c(
          "a",
          {
            class: _vm.btnTrans.cancel.class + " btn-sm",
            attrs: { href: _vm.backUrl, type: "button" }
          },
          [
            _c("i", {
              class: _vm.btnTrans.cancel.icon,
              attrs: { "aria-hidden": "true" }
            }),
            _vm._v(
              " \n                " +
                _vm._s(_vm.btnTrans.cancel.text) +
                "\n            "
            )
          ]
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
    return _c(
      "label",
      {
        staticClass: "col-lg-3 col-md-6 col-form-label text-left",
        staticStyle: {
          "padding-left": "5px",
          "padding-top": "20px",
          "vertical-align": "middle"
        }
      },
      [_c("strong", [_vm._v(" กรมธรรม์ชุดที่ (Policy No.) : ")])]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "label",
      {
        staticClass: "col-lg-3 col-md-6 col-form-label text-left",
        staticStyle: {
          "padding-left": "5px",
          "padding-top": "20px",
          "vertical-align": "middle"
        }
      },
      [_c("strong", [_vm._v(" กลุ่มของทรัพย์สิน : ")])]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "label",
      {
        staticClass: "col-lg-3 col-md-6 col-form-label text-left",
        staticStyle: {
          "padding-left": "5px",
          "padding-top": "20px",
          "vertical-align": "middle"
        }
      },
      [_c("strong", [_vm._v(" รายการ : ")])]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "label",
      {
        staticClass: "col-lg-3 col-md-6 col-form-label text-left",
        staticStyle: {
          "padding-left": "5px",
          "padding-top": "20px",
          "vertical-align": "middle"
        }
      },
      [_c("strong", [_vm._v(" ประเภทค่าใช้จ่าย : ")])]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "label",
      {
        staticClass: "col-lg-3 col-md-6 col-form-label text-left",
        staticStyle: {
          "padding-left": "5px",
          "padding-top": "20px",
          "vertical-align": "middle"
        }
      },
      [_c("strong", [_vm._v(" รหัสบัญชี : ")])]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", [
      _c(
        "label",
        {
          staticClass: "col-lg-12 col-md-6 col-form-label text-feft",
          staticStyle: {
            width: "80px",
            "padding-left": "5px",
            "padding-right": "0px",
            "padding-top": "20px"
          }
        },
        [_vm._v("\n                รหัสหน่วยงาน\n            ")]
      ),
      _c("span", { staticClass: "text-danger" }, [_vm._v(" *")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", [
      _c(
        "label",
        {
          staticClass: "col-lg-12 col-md-6 col-form-label text-feft",
          staticStyle: {
            width: "80px",
            "padding-left": "5px",
            "padding-right": "0px",
            "padding-top": "20px"
          }
        },
        [_vm._v("\n                รหัสคลังสินค้า\n            ")]
      ),
      _c("span", { staticClass: "text-danger" }, [_vm._v(" *")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", [
      _c(
        "label",
        {
          staticClass: "col-lg-12 col-md-6 col-form-label text-feft",
          staticStyle: {
            width: "85px",
            "padding-left": "5px",
            "padding-right": "0px",
            "padding-top": "20px"
          }
        },
        [_vm._v("\n                กลุ่มสินค้าย่อย\n            ")]
      ),
      _c("span", { staticClass: "text-danger" }, [_vm._v(" *")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", { staticClass: "sticky-col th-row", attrs: { width: "1%" } }),
        _vm._v(" "),
        _c(
          "th",
          { staticClass: "sticky-col th-row", attrs: { width: "50%" } },
          [
            _vm._v(" รหัสประเภท (Category Code)"),
            _c("span", { staticClass: "text-danger" }, [_vm._v(" *")])
          ]
        ),
        _vm._v(" "),
        _c(
          "th",
          { staticClass: "sticky-col th-row", attrs: { width: "30%" } },
          [_vm._v(" Locator ")]
        ),
        _vm._v(" "),
        _c("th", { staticClass: "sticky-col th-row", attrs: { width: "1%" } })
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);