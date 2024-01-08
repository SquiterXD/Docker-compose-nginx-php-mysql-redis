(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_om_pages_Claim_Request_index_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/om/pages/Claim/Request/index.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/om/pages/Claim/Request/index.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_1__);


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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: {
    btn_trans: {
      type: Object
    },
    url_ajax: {
      type: Object
    },
    customer_list: {
      type: Object
    },
    authority_list: {
      type: Object
    },
    acting_pos: {
      type: Object
    }
  },
  mounted: function mounted() {},
  data: function data() {
    return {
      filter: {
        customer_number: "",
        // รหัสร้านค้า
        claim_number: "",
        //เลขที่ใบเคลม *
        fl: "",
        // ฝข. 
        date: "",
        // ลงวันที่ *
        signIt: "",
        // ลงชื่อรับเรื่อง *
        signDep: ""
      },
      validate: {
        customer_number: false,
        claim_number: false,
        //เลขที่ใบเคลม *
        fl: false,
        // ฝข. 
        date: false,
        // ลงวันที่ *
        signIt: false,
        // ลงชื่อรับเรื่อง *
        signDep: false
      },
      claim_no: []
    };
  },
  methods: {
    loading: function loading() {
      var loading = this.$loading({
        lock: true,
        text: "Loading",
        spinner: "el-icon-loading",
        background: "rgba(0, 0, 0, 0.7)"
      });
      return loading;
    },
    handdlePrint: function handdlePrint() {
      var el = this.filter;
      var invalid = false;

      if (el.claim_number == '') {
        this.validate.claim_number = true;
        invalid = true;
      } else {
        this.validate.claim_number = false;
      }

      if (el.date == '') {
        this.validate.date = true;
        invalid = true;
      } else {
        this.validate.date = false;
      }

      if (el.signIt == '') {
        this.validate.signIt = true;
        invalid = true;
      } else {
        this.validate.signIt = false;
      }

      if (invalid == true) return false;
      window.open(this.url_ajax.link_pdf + "?" + $.param(this.filter));
    },
    handleChangeDate: function handleChangeDate(el, i) {
      var date = new Date(el);
      this.filter.date = date.getFullYear() - 543 + "-" + (date.getMonth() + 1) + "-" + date.getDate();
    },
    takeDataClaimNo: function takeDataClaimNo() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return axios__WEBPACK_IMPORTED_MODULE_1___default().post(_this.url_ajax.take_claim_number, {
                  customer_number: _this.filter.customer_number
                }).then(function (result) {
                  // has error
                  if (result.status !== 200) return _this.$notify({
                    text: "ไม่สามารถทำรายการได้ในขณะนี้",
                    type: "warning"
                  }); // bind claim_number

                  _this.claim_no = result.data;
                })["catch"](function (ex) {
                  _this.$notify({
                    text: "ไม่สามารถทำรายการได้ในขณะนี้",
                    type: "warning"
                  });
                });

              case 2:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    handleChangCusNumber: function handleChangCusNumber(el) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var loading;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                console.log(el); // set loading

                loading = _this2.loading(); // take data claim_no

                _context2.next = 4;
                return _this2.takeDataClaimNo();

              case 4:
                // set close loading
                loading.close();

              case 5:
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

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/om/pages/Claim/Request/index.vue?vue&type=style&index=0&id=6e050ec1&scoped=true&lang=css&":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/om/pages/Claim/Request/index.vue?vue&type=style&index=0&id=6e050ec1&scoped=true&lang=css& ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, ".form-group[data-v-6e050ec1] {\n  margin-bottom: 1rem;\n}\n.is-valide[data-v-6e050ec1] {\n  color: red;\n  border:1px solid red;\n}\n\n\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/om/pages/Claim/Request/index.vue?vue&type=style&index=0&id=6e050ec1&scoped=true&lang=css&":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/om/pages/Claim/Request/index.vue?vue&type=style&index=0&id=6e050ec1&scoped=true&lang=css& ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_style_index_0_id_6e050ec1_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./index.vue?vue&type=style&index=0&id=6e050ec1&scoped=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/om/pages/Claim/Request/index.vue?vue&type=style&index=0&id=6e050ec1&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_style_index_0_id_6e050ec1_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_style_index_0_id_6e050ec1_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/om/pages/Claim/Request/index.vue":
/*!*******************************************************!*\
  !*** ./resources/js/om/pages/Claim/Request/index.vue ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _index_vue_vue_type_template_id_6e050ec1_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./index.vue?vue&type=template&id=6e050ec1&scoped=true& */ "./resources/js/om/pages/Claim/Request/index.vue?vue&type=template&id=6e050ec1&scoped=true&");
/* harmony import */ var _index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./index.vue?vue&type=script&lang=js& */ "./resources/js/om/pages/Claim/Request/index.vue?vue&type=script&lang=js&");
/* harmony import */ var _index_vue_vue_type_style_index_0_id_6e050ec1_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./index.vue?vue&type=style&index=0&id=6e050ec1&scoped=true&lang=css& */ "./resources/js/om/pages/Claim/Request/index.vue?vue&type=style&index=0&id=6e050ec1&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _index_vue_vue_type_template_id_6e050ec1_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _index_vue_vue_type_template_id_6e050ec1_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "6e050ec1",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/om/pages/Claim/Request/index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/om/pages/Claim/Request/index.vue?vue&type=script&lang=js&":
/*!********************************************************************************!*\
  !*** ./resources/js/om/pages/Claim/Request/index.vue?vue&type=script&lang=js& ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/om/pages/Claim/Request/index.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/om/pages/Claim/Request/index.vue?vue&type=style&index=0&id=6e050ec1&scoped=true&lang=css&":
/*!****************************************************************************************************************!*\
  !*** ./resources/js/om/pages/Claim/Request/index.vue?vue&type=style&index=0&id=6e050ec1&scoped=true&lang=css& ***!
  \****************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_style_index_0_id_6e050ec1_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/style-loader/dist/cjs.js!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./index.vue?vue&type=style&index=0&id=6e050ec1&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/om/pages/Claim/Request/index.vue?vue&type=style&index=0&id=6e050ec1&scoped=true&lang=css&");


/***/ }),

/***/ "./resources/js/om/pages/Claim/Request/index.vue?vue&type=template&id=6e050ec1&scoped=true&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/om/pages/Claim/Request/index.vue?vue&type=template&id=6e050ec1&scoped=true& ***!
  \**************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_template_id_6e050ec1_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_template_id_6e050ec1_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_template_id_6e050ec1_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./index.vue?vue&type=template&id=6e050ec1&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/om/pages/Claim/Request/index.vue?vue&type=template&id=6e050ec1&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/om/pages/Claim/Request/index.vue?vue&type=template&id=6e050ec1&scoped=true&":
/*!*****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/om/pages/Claim/Request/index.vue?vue&type=template&id=6e050ec1&scoped=true& ***!
  \*****************************************************************************************************************************************************************************************************************************************/
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
      _c("div", { staticClass: "col-lg-12" }, [
        _c("div", { staticClass: "ibox" }, [
          _vm._m(0),
          _vm._v(" "),
          _c("div", { staticClass: "ibox-content" }, [
            _c("div", { staticClass: "col-xl-7" }, [
              _c("form", [
                _vm._m(1),
                _vm._v(" "),
                _c("div", { staticClass: "form-group row" }, [
                  _c("label", { staticClass: "col-sm-3 col-form-label" }, [
                    _vm._v("รหัสร้านค้า")
                  ]),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-sm-9" },
                    [
                      _c(
                        "el-select",
                        {
                          attrs: {
                            filterable: "",
                            placeholder: "เลือกรหัสร้านค้า"
                          },
                          on: { change: _vm.handleChangCusNumber },
                          model: {
                            value: _vm.filter.customer_number,
                            callback: function($$v) {
                              _vm.$set(_vm.filter, "customer_number", $$v)
                            },
                            expression: "filter.customer_number"
                          }
                        },
                        _vm._l(_vm.customer_list, function(cus) {
                          return _c("el-option", {
                            key: cus.customer_id,
                            attrs: {
                              label: cus.customer_number,
                              value: cus.customer_id
                            }
                          })
                        }),
                        1
                      )
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "form-group row" }, [
                  _vm._m(2),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-sm-9" },
                    [
                      _c(
                        "el-select",
                        {
                          class: _vm.validate.claim_number ? "is-valide" : "",
                          attrs: {
                            filterable: "",
                            placeholder: "เลือกเลขที่ใบเคลม"
                          },
                          model: {
                            value: _vm.filter.claim_number,
                            callback: function($$v) {
                              _vm.$set(_vm.filter, "claim_number", $$v)
                            },
                            expression: "filter.claim_number"
                          }
                        },
                        _vm._l(_vm.claim_no, function(item, index) {
                          return _c("el-option", {
                            key: index,
                            attrs: {
                              label: item.claim_number,
                              value: item.claim_header_id
                            }
                          })
                        }),
                        1
                      )
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _vm._m(3),
                _vm._v(" "),
                _vm._m(4),
                _vm._v(" "),
                _c("div", { staticClass: "form-group row" }, [
                  _c("label", { staticClass: "col-sm-3 col-form-label" }, [
                    _vm._v("ฝข.\n                ")
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-sm-9" }, [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.filter.fl,
                          expression: "filter.fl"
                        }
                      ],
                      staticClass: "form-control",
                      attrs: { type: "text" },
                      domProps: { value: _vm.filter.fl },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(_vm.filter, "fl", $event.target.value)
                        }
                      }
                    })
                  ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "form-group row" }, [
                  _vm._m(5),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-sm-9" },
                    [
                      _c("datepicker-th", {
                        class:
                          "form-control " +
                          (_vm.validate.signIt ? "is-valide" : ""),
                        staticStyle: { width: "100%" },
                        attrs: {
                          placeholder: "วันส่งประจำงวด",
                          format: "DD/MM/Y"
                        },
                        on: { dateWasSelected: _vm.handleChangeDate },
                        model: {
                          value: _vm.date,
                          callback: function($$v) {
                            _vm.date = $$v
                          },
                          expression: "date"
                        }
                      })
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _vm._m(6),
                _vm._v(" "),
                _c("div", { staticClass: "form-group row" }, [
                  _vm._m(7),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-sm-9" },
                    [
                      _c(
                        "el-select",
                        {
                          class: _vm.validate.signIt ? "is-valide" : "",
                          attrs: {
                            filterable: "",
                            placeholder: "เลือกลงชื่อรับเรื่อง"
                          },
                          model: {
                            value: _vm.filter.signIt,
                            callback: function($$v) {
                              _vm.$set(_vm.filter, "signIt", $$v)
                            },
                            expression: "filter.signIt"
                          }
                        },
                        _vm._l(_vm.authority_list, function(item, index) {
                          return _c("el-option", {
                            key: index,
                            attrs: {
                              label: item.employee_name,
                              value: item.authority_id
                            }
                          })
                        }),
                        1
                      )
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "form-group row" }, [
                  _c("label", { staticClass: "col-sm-3 col-form-label" }, [
                    _vm._v(" ")
                  ]),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-sm-9" },
                    [
                      _c(
                        "el-select",
                        {
                          attrs: { filterable: "" },
                          model: {
                            value: _vm.filter.signDep,
                            callback: function($$v) {
                              _vm.$set(_vm.filter, "signDep", $$v)
                            },
                            expression: "filter.signDep"
                          }
                        },
                        _vm._l(_vm.acting_pos, function(item, index) {
                          return _c("el-option", {
                            key: index,
                            attrs: {
                              label: item.meaning,
                              value: item.lookup_code
                            }
                          })
                        }),
                        1
                      )
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "form-group" }, [
                  _c(
                    "button",
                    {
                      class: _vm.btn_trans.print.class,
                      attrs: { type: "button" },
                      on: { click: _vm.handdlePrint }
                    },
                    [
                      _c("i", { class: _vm.btn_trans.print.icon }, [
                        _vm._v(" ")
                      ]),
                      _vm._v(
                        "\n                  " +
                          _vm._s(_vm.btn_trans.print.text) +
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
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "ibox-title" }, [
      _c("div", { staticClass: "row align-items-center" }, [
        _c("div", { staticClass: "col-sm-12 col-lg-4 align-middle" }, [
          _c("h4", [_vm._v("ใบขอเปลี่ยนบุหรี่ชำรุด/เสียหาย หรือ ขาดบรรจุ")])
        ])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "form-group" }, [
      _c("h4", { staticClass: "black mb-3" }, [_vm._v("Parameter")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "label",
      {
        staticClass: "col-sm-3 col-form-label",
        attrs: { for: "inputPassword" }
      },
      [
        _vm._v("เลขที่ใบเคลม"),
        _c("span", { staticClass: "is-invalide" }, [_vm._v("*")])
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "form-group" }, [
      _c("h4", { staticClass: "black mb-3" }, [_vm._v("โปรดระบุ")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "form-group row" }, [
      _c("label", { staticClass: "col-sm-3 col-form-label" }, [_vm._v("กอง")]),
      _vm._v(" "),
      _c("div", { staticClass: "col-sm-9" }, [_vm._v("กองลูกค้าสัมพันธ์")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "col-sm-3 col-form-label" }, [
      _vm._v("ลงวันที่ "),
      _c("span", { staticClass: "is-invalide" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "form-group" }, [
      _c("h4", { staticClass: "black mb-3" }, [_vm._v("โปรดเลือกผู้ทำการ")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "col-sm-3 col-form-label" }, [
      _vm._v("ลงชื่อรับเรื่อง "),
      _c("span", { staticClass: "is-invalide" }, [_vm._v("*")])
    ])
  }
]
render._withStripped = true



/***/ })

}]);