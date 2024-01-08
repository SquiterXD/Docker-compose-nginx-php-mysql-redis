(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_qm_settings_Specification_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/settings/Specification.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/settings/Specification.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["url", 'btnTrans', "pTestType", "pTestList", "pRequest", "pSpecifications", 'pResultSeverityCode'],
  data: function data() {
    return {
      specifications: this.pSpecifications != undefined && this.pSpecifications != '' ? this.pSpecifications : [],
      loading: false,
      delTestIdArr: []
    };
  },
  watch: {
    specifications: function () {
      var _specifications = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee(value) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }));

      function specifications(_x) {
        return _specifications.apply(this, arguments);
      }

      return specifications;
    }()
  },
  mounted: function mounted() {
    this.setOptionalInd();
    this.setDuplicateTestId();
  },
  methods: {
    checkMinMaxVal: function checkMinMaxVal(specification, inputName) {// min_value
      // max_value
      // if (inputName == 'min_value') {
      //     if (parseFloat(specification.min_value) > parseFloat(specification.max_value)) {
      //         specification.min_value = parseFloat(specification.max_value)
      //     }
      // }
      // if (inputName == 'max_value') {
      //     if (parseFloat(specification.max_value) < parseFloat(specification.min_value)) {
      //         specification.min_value = parseFloat(specification.max_value)
      //     }
      // }
    },
    setOptionalInd: function setOptionalInd() {
      this.specifications.forEach(function (spec) {
        if (spec.optional_ind == 'Y') {
          spec.optional_ind = true;
        } else {
          spec.optional_ind = false;
        }
      });
    },
    setDuplicateTestId: function setDuplicateTestId() {
      this.specifications.forEach(function (spec) {
        spec.is_duplicate_test_id = false;
      });
    },
    addLine: function addLine() {
      // let row = Object.keys(this.specifications).length + 1;
      var row = Object.keys(this.specifications).length;
      this.$set(this.specifications, row, {
        seq: null,
        test_code: null,
        test_id: null,
        test_unit: null,
        min_value: null,
        max_value: null,
        optional_ind: null,
        is_duplicate_test_id: false,
        test_unit_desc: null
      });
    },
    delLine: function delLine(specification, index) {
      var vm = this;

      if (specification.seq != '') {
        vm.delTestIdArr.push(specification.test_id);
      }

      vm.$delete(vm.specifications, index);
    },
    changeTest: function changeTest(specification, index) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var test, checkDup;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                specification.is_duplicate_test_id = false;
                test = _this.pTestList.filter(function (o) {
                  return o.test_code == specification.test_code;
                });
                specification.test_unit = test[0].test_unit_code;
                specification.test_id = test[0].test_id;
                specification.test_unit_desc = test[0].test_unit;
                specification.test_desc = test[0].test_desc;
                checkDup = _this.specifications.filter(function (o) {
                  return o.test_id == test[0].test_id;
                });

                if (checkDup.length > 1) {
                  specification.is_duplicate_test_id = true;
                } // console.log('checkDup ', checkDup);
                // specifications.forEach(spec => {
                //     spec.is_duplicate_test_id = false;
                // });


              case 8:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    submitSearch: function submitSearch() {
      var vm = this;

      if (vm.pRequest.test_type == 5) {
        $('#fromSearch').append('<input type="hidden" name="search_flag " value="true" />');
      }

      $("#fromSearch").submit();
    },
    save: function save() {
      var vm = this;
      swal({
        html: true,
        title: 'Save Trasaction ?',
        text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> ต้องการบันทึกรายการหรือไม่ </span></h2>',
        showCancelButton: true,
        confirmButtonText: 'บันทึก',
        cancelButtonText: 'ยกเลิก',
        confirmButtonClass: 'btn btn-primary',
        cancelButtonClass: 'btn btn-white',
        closeOnConfirm: false,
        closeOnCancel: true,
        showLoaderOnConfirm: true
      }, /*#__PURE__*/function () {
        var _ref = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3(isConfirm) {
          return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
            while (1) {
              switch (_context3.prev = _context3.next) {
                case 0:
                  if (!isConfirm) {
                    _context3.next = 5;
                    break;
                  }

                  vm.loading = true;
                  axios.post(vm.url.qm_api_settings_specifications_store, {
                    specifications: vm.specifications,
                    test_type: vm.pTestType,
                    search_request: vm.pRequest,
                    del_test_id_arr: vm.delTestIdArr
                  }).then(function (response) {
                    if (response.data.data.status == 'S') {
                      swal({
                        title: 'บันทึกรายการสำเร็จ',
                        text: '<span style="font-size: 16px; text-align: left;"> ทำการบันทึกรายการเรียบร้อย </span>',
                        type: "success",
                        html: true
                      });
                      location.reload();
                    }

                    if (response.data.data.status == 'E') {
                      // console.log('xxxx');
                      swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">' + response.data.data.msg + '</span>',
                        type: "warning",
                        html: true
                      });
                    }
                  }.bind(this))["catch"](function (error) {// console.log(error);
                    // this.showErrorAlerNew(error);
                  }.bind(this)).then(function () {
                    // always executed
                    // console.log('done');
                    vm.loading = false;
                  }.bind(this));
                  _context3.next = 6;
                  break;

                case 5:
                  return _context3.abrupt("return");

                case 6:
                case "end":
                  return _context3.stop();
              }
            }
          }, _callee3, this);
        }));

        return function (_x2) {
          return _ref.apply(this, arguments);
        };
      }());
    }
  },
  computed: {
    canSave: function canSave() {
      var canSubmit = true;
      this.specifications.forEach( /*#__PURE__*/function () {
        var _ref2 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4(o, i) {
          return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
            while (1) {
              switch (_context4.prev = _context4.next) {
                case 0:
                  // console.log('canSave', o, i);
                  if (o.data_type != 'ตัวอักษร') {
                    if (parseFloat(o.min_value) > parseFloat(o.max_value)) {
                      canSubmit = false;
                    }

                    if (parseFloat(o.max_value) < parseFloat(o.min_value)) {
                      canSubmit = false;
                    }
                  }

                case 1:
                case "end":
                  return _context4.stop();
              }
            }
          }, _callee4);
        }));

        return function (_x3, _x4) {
          return _ref2.apply(this, arguments);
        };
      }());
      return canSubmit;
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/settings/Specification.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/settings/Specification.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, "tr.duplicate_test_id > td {\n  border: 4px solid #ED5565 !important;\n}\n\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/settings/Specification.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/settings/Specification.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Specification_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Specification.vue?vue&type=style&index=0&scope=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/settings/Specification.vue?vue&type=style&index=0&scope=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Specification_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Specification_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/components/qm/settings/Specification.vue":
/*!***************************************************************!*\
  !*** ./resources/js/components/qm/settings/Specification.vue ***!
  \***************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Specification_vue_vue_type_template_id_55130ee2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Specification.vue?vue&type=template&id=55130ee2& */ "./resources/js/components/qm/settings/Specification.vue?vue&type=template&id=55130ee2&");
/* harmony import */ var _Specification_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Specification.vue?vue&type=script&lang=js& */ "./resources/js/components/qm/settings/Specification.vue?vue&type=script&lang=js&");
/* harmony import */ var _Specification_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Specification.vue?vue&type=style&index=0&scope=true&lang=css& */ "./resources/js/components/qm/settings/Specification.vue?vue&type=style&index=0&scope=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _Specification_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Specification_vue_vue_type_template_id_55130ee2___WEBPACK_IMPORTED_MODULE_0__.render,
  _Specification_vue_vue_type_template_id_55130ee2___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/qm/settings/Specification.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/qm/settings/Specification.vue?vue&type=script&lang=js&":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/qm/settings/Specification.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Specification_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Specification.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/settings/Specification.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Specification_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/qm/settings/Specification.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!***********************************************************************************************************!*\
  !*** ./resources/js/components/qm/settings/Specification.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \***********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Specification_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Specification.vue?vue&type=style&index=0&scope=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/settings/Specification.vue?vue&type=style&index=0&scope=true&lang=css&");


/***/ }),

/***/ "./resources/js/components/qm/settings/Specification.vue?vue&type=template&id=55130ee2&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/qm/settings/Specification.vue?vue&type=template&id=55130ee2& ***!
  \**********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Specification_vue_vue_type_template_id_55130ee2___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Specification_vue_vue_type_template_id_55130ee2___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Specification_vue_vue_type_template_id_55130ee2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Specification.vue?vue&type=template&id=55130ee2& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/settings/Specification.vue?vue&type=template&id=55130ee2&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/settings/Specification.vue?vue&type=template&id=55130ee2&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/settings/Specification.vue?vue&type=template&id=55130ee2& ***!
  \*************************************************************************************************************************************************************************************************************************************/
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
        staticClass:
          "row form-group justify-content-center clearfix tw-my-6 text-center"
      },
      [
        _c("div", { staticClass: "col-lg-6 col-md-6" }, [
          _c(
            "button",
            {
              staticClass: "btn btn-lg btn-white tw-w-32 tw-ml-4",
              attrs: { type: "button" },
              on: { click: _vm.submitSearch }
            },
            [
              _c("i", { staticClass: "fa fa-search" }),
              _vm._v(" ค้นหา\n            ")
            ]
          ),
          _vm._v(" "),
          _c(
            "a",
            {
              staticClass:
                "btn btn-lg tw-bg-gray-100 tw-bg-opacity-60 btn-white tw-w-32 tw-ml-4",
              attrs: {
                type: "button",
                href: _vm.url.qm_settings_specifications_index
              }
            },
            [
              _c("i", { staticClass: "fa fa-times" }),
              _vm._v(" ล้าง\n            ")
            ]
          )
        ])
      ]
    ),
    _vm._v(" "),
    _c("hr", { staticClass: "tw-my-10" }),
    _vm._v(" "),
    _c("div", { staticClass: "table-responsive" }, [
      _c(
        "table",
        {
          directives: [
            {
              name: "loading",
              rawName: "v-loading",
              value: _vm.loading,
              expression: "loading"
            }
          ],
          staticClass: "table text-nowrap table-hover table-bordered"
        },
        [
          _c("thead", [
            _c("tr", [
              _c(
                "th",
                {
                  staticClass: "text-center align-middle",
                  attrs: { rowspan: "2" }
                },
                [
                  _vm._v(
                    "\n                                    \n                                    \n                        ชื่อการทดสอบ/ความผิดปกติ*\n                                    \n                                    \n                    "
                  )
                ]
              ),
              _vm._v(" "),
              this.pRequest.test_type != 1 && this.pRequest.test_type != 5
                ? _c(
                    "th",
                    {
                      staticClass: "text-center align-middle",
                      attrs: { rowspan: "2" }
                    },
                    [
                      _vm._v(
                        "\n                        Optimal\n                    "
                      )
                    ]
                  )
                : _vm._e(),
              _vm._v(" "),
              this.pRequest.test_type == 1 || this.pRequest.test_type == 5
                ? _c(
                    "th",
                    {
                      staticClass: "text-center align-middle",
                      attrs: { rowspan: "2" }
                    },
                    [
                      _vm._v(
                        "\n                        เกณฑ์พิจารณาผล\n                    "
                      )
                    ]
                  )
                : _vm._e(),
              _vm._v(" "),
              _c(
                "th",
                {
                  staticClass: "text-center align-middle",
                  attrs: { colspan: "2" }
                },
                [_vm._v("ค่าควบคุม")]
              ),
              _vm._v(" "),
              _vm._m(0),
              _vm._v(" "),
              _vm._m(1),
              _vm._v(" "),
              this.pRequest.test_type == 2
                ? _c(
                    "th",
                    {
                      staticClass: "text-center align-middle",
                      attrs: { rowspan: "2" }
                    },
                    [_vm._v("รายการตรวจสอบคุณภาพบุหรี่ *")]
                  )
                : _vm._e(),
              _vm._v(" "),
              this.pRequest.test_type != 2 && this.pRequest.test_type != 4
                ? _c(
                    "th",
                    {
                      staticClass: "text-center align-middle",
                      attrs: { colspan: _vm.pResultSeverityCode.length }
                    },
                    [_vm._v("ระดับความรุนแรง (Lower Level) *")]
                  )
                : _vm._e(),
              _vm._v(" "),
              _c(
                "th",
                {
                  staticClass: "text-center align-middle",
                  attrs: { colspan: _vm.pResultSeverityCode.length }
                },
                [_vm._v("ระดับความรุนแรง (Upper Level) *")]
              ),
              _vm._v(" "),
              _c(
                "th",
                {
                  staticClass: "text-center align-middle",
                  attrs: { rowspan: "2" }
                },
                [_vm._v("Optional")]
              )
            ]),
            _vm._v(" "),
            _c(
              "tr",
              [
                _c(
                  "th",
                  {
                    staticClass: "text-center",
                    staticStyle: { "min-width": "120px", "max-width": "120px" }
                  },
                  [
                    _vm._v(
                      "\n                        Min*\n                    "
                    )
                  ]
                ),
                _vm._v(" "),
                _c(
                  "th",
                  {
                    staticClass: "text-center",
                    staticStyle: { "min-width": "120px", "max-width": "120px" }
                  },
                  [
                    _vm._v(
                      "\n                        Max*\n                    "
                    )
                  ]
                ),
                _vm._v(" "),
                _vm._l(_vm.pResultSeverityCode, function(resSevCode, index) {
                  return _vm.pRequest.test_type != 2 &&
                    _vm.pRequest.test_type != 4
                    ? [
                        _c("th", { staticClass: "text-center" }, [
                          _vm._v(
                            "\n                                  " +
                              _vm._s(resSevCode.meaning) +
                              "      \n                        "
                          )
                        ])
                      ]
                    : _vm._e()
                }),
                _vm._v(" "),
                _vm._l(_vm.pResultSeverityCode, function(resSevCode, index) {
                  return [
                    _c("th", { staticClass: "text-center" }, [
                      _vm._v(
                        "\n                                  " +
                          _vm._s(resSevCode.meaning) +
                          "      \n                        "
                      )
                    ])
                  ]
                })
              ],
              2
            )
          ]),
          _vm._v(" "),
          _c(
            "tbody",
            [
              _vm._l(_vm.specifications, function(specification, index) {
                return _vm.specifications.length > 0
                  ? _c(
                      "tr",
                      { attrs: { data: index } },
                      [
                        _c("td", { staticClass: "align-middle" }, [
                          _c("div", { staticStyle: { display: "flex" } }, [
                            _c(
                              "div",
                              { staticStyle: { width: "100%" } },
                              [
                                _c(
                                  "el-tooltip",
                                  {
                                    staticClass: "item",
                                    attrs: {
                                      effect: "dark",
                                      content: specification.test_desc,
                                      placement: "top-start"
                                    }
                                  },
                                  [
                                    _c(
                                      "el-select",
                                      {
                                        staticStyle: { width: "100%" },
                                        attrs: {
                                          filterable: "",
                                          clearable: "",
                                          disabled: specification.seq != null,
                                          placeholder: ""
                                        },
                                        on: {
                                          change: function($event) {
                                            return _vm.changeTest(
                                              specification,
                                              index
                                            )
                                          }
                                        },
                                        model: {
                                          value: specification.test_code,
                                          callback: function($$v) {
                                            _vm.$set(
                                              specification,
                                              "test_code",
                                              $$v
                                            )
                                          },
                                          expression: "specification.test_code"
                                        }
                                      },
                                      [
                                        specification.spec_id
                                          ? _c("el-option", {
                                              attrs: {
                                                label: specification.test_desc,
                                                value: specification.test_code
                                              }
                                            })
                                          : _vm._e(),
                                        _vm._v(" "),
                                        _vm._l(_vm.pTestList, function(
                                          testData,
                                          index
                                        ) {
                                          return _c("el-option", {
                                            key: index,
                                            attrs: {
                                              label: testData.test_desc,
                                              value: testData.test_code
                                            }
                                          })
                                        })
                                      ],
                                      2
                                    )
                                  ],
                                  1
                                )
                              ],
                              1
                            ),
                            _vm._v(" "),
                            _c(
                              "button",
                              {
                                staticClass: "btn btn-outline btn-danger ml-2",
                                attrs: { type: "button", title: "ลบรายการ" },
                                on: {
                                  click: function($event) {
                                    $event.preventDefault()
                                    return _vm.delLine(specification, index)
                                  }
                                }
                              },
                              [_c("i", { class: _vm.btnTrans.delete.icon })]
                            )
                          ]),
                          _vm._v(" "),
                          specification.is_duplicate_test_id
                            ? _c("div", [
                                _c(
                                  "span",
                                  {
                                    staticClass:
                                      "form-text m-b-none text-danger"
                                  },
                                  [
                                    _vm._v(
                                      "\n                                ชื่อการทดสอบ/ความผิดปกติซ้ำ\n                            "
                                    )
                                  ]
                                )
                              ])
                            : _vm._e()
                        ]),
                        _vm._v(" "),
                        _vm.pRequest.test_type != 1 &&
                        _vm.pRequest.test_type != 5
                          ? _c(
                              "td",
                              { staticStyle: { "min-width": "100px" } },
                              [
                                _c("input", {
                                  directives: [
                                    {
                                      name: "model",
                                      rawName: "v-model",
                                      value: specification.optimal_value,
                                      expression: "specification.optimal_value"
                                    }
                                  ],
                                  staticClass: "form-control text-right",
                                  attrs: { type: "number" },
                                  domProps: {
                                    value: specification.optimal_value
                                  },
                                  on: {
                                    input: function($event) {
                                      if ($event.target.composing) {
                                        return
                                      }
                                      _vm.$set(
                                        specification,
                                        "optimal_value",
                                        $event.target.value
                                      )
                                    }
                                  }
                                })
                              ]
                            )
                          : _vm._e(),
                        _vm._v(" "),
                        _vm.pRequest.test_type == 1 ||
                        _vm.pRequest.test_type == 5
                          ? _c(
                              "td",
                              {
                                staticClass: "text-center align-middle",
                                staticStyle: { "min-width": "100px" }
                              },
                              [
                                _c("el-checkbox", {
                                  attrs: {
                                    checked:
                                      specification.evaluation_flag == "Y"
                                        ? true
                                        : false,
                                    size: "large"
                                  },
                                  model: {
                                    value: specification.evaluation_flag,
                                    callback: function($$v) {
                                      _vm.$set(
                                        specification,
                                        "evaluation_flag",
                                        $$v
                                      )
                                    },
                                    expression: "specification.evaluation_flag"
                                  }
                                })
                              ],
                              1
                            )
                          : _vm._e(),
                        _vm._v(" "),
                        _c(
                          "td",
                          [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: specification.min_value,
                                  expression: "specification.min_value"
                                }
                              ],
                              staticClass: "form-control text-right",
                              attrs: {
                                disabled: specification.data_type == "ตัวอักษร",
                                type: "number"
                              },
                              domProps: { value: specification.min_value },
                              on: {
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(
                                    specification,
                                    "min_value",
                                    $event.target.value
                                  )
                                }
                              }
                            }),
                            _vm._v(" "),
                            specification.data_type != "ตัวอักษร"
                              ? [
                                  parseFloat(specification.min_value) >
                                  parseFloat(specification.max_value)
                                    ? _c(
                                        "span",
                                        {
                                          staticClass:
                                            " m-b-none text-danger small"
                                        },
                                        [
                                          _vm._v(
                                            "\n                                ค่า Min มากกว่า ค่า Max\n                            "
                                          )
                                        ]
                                      )
                                    : _vm._e()
                                ]
                              : _vm._e()
                          ],
                          2
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
                                  value: specification.max_value,
                                  expression: "specification.max_value"
                                }
                              ],
                              staticClass: "form-control text-right",
                              attrs: {
                                disabled: specification.data_type == "ตัวอักษร",
                                type: "number"
                              },
                              domProps: { value: specification.max_value },
                              on: {
                                change: function($event) {
                                  return _vm.checkMinMaxVal(
                                    specification,
                                    "max_value"
                                  )
                                },
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(
                                    specification,
                                    "max_value",
                                    $event.target.value
                                  )
                                }
                              }
                            }),
                            _vm._v(" "),
                            !(specification.data_type == "ตัวอักษร")
                              ? [
                                  parseFloat(specification.max_value) <
                                  parseFloat(specification.min_value)
                                    ? _c(
                                        "span",
                                        {
                                          staticClass:
                                            " m-b-none text-danger small"
                                        },
                                        [
                                          _vm._v(
                                            "\n                                ค่า Max น้อยกว่า ค่า Min\n                            "
                                          )
                                        ]
                                      )
                                    : _vm._e()
                                ]
                              : _vm._e()
                          ],
                          2
                        ),
                        _vm._v(" "),
                        _c("td", { staticClass: "text-center align-middle" }, [
                          _vm._v(_vm._s(specification.test_unit))
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "text-center align-middle" }, [
                          _vm._v(_vm._s(specification.test_unit_desc))
                        ]),
                        _vm._v(" "),
                        _vm.pRequest.test_type == 2
                          ? _c(
                              "td",
                              { staticClass: "text-center align-middle" },
                              [
                                _c("el-input", {
                                  attrs: {
                                    disabled: "",
                                    placeholder: "ไม่มีข้อมูล"
                                  },
                                  model: {
                                    value: specification.check_list,
                                    callback: function($$v) {
                                      _vm.$set(specification, "check_list", $$v)
                                    },
                                    expression: "specification.check_list"
                                  }
                                })
                              ],
                              1
                            )
                          : _vm._e(),
                        _vm._v(" "),
                        _vm._l(_vm.pResultSeverityCode, function(
                          resSevCode,
                          index
                        ) {
                          return _vm.pRequest.test_type != 2 &&
                            _vm.pRequest.test_type != 4
                            ? [
                                _c("td", [
                                  _c("input", {
                                    directives: [
                                      {
                                        name: "model",
                                        rawName: "v-model",
                                        value:
                                          specification[
                                            "low_level_" +
                                              resSevCode.meaning.toLowerCase()
                                          ],
                                        expression:
                                          "specification['low_level_' + resSevCode.meaning.toLowerCase()]"
                                      }
                                    ],
                                    staticClass: "form-control text-right",
                                    style: "border-color: " + resSevCode.tag,
                                    attrs: { type: "number" },
                                    domProps: {
                                      value:
                                        specification[
                                          "low_level_" +
                                            resSevCode.meaning.toLowerCase()
                                        ]
                                    },
                                    on: {
                                      input: function($event) {
                                        if ($event.target.composing) {
                                          return
                                        }
                                        _vm.$set(
                                          specification,
                                          "low_level_" +
                                            resSevCode.meaning.toLowerCase(),
                                          $event.target.value
                                        )
                                      }
                                    }
                                  })
                                ])
                              ]
                            : _vm._e()
                        }),
                        _vm._v(" "),
                        _vm._l(_vm.pResultSeverityCode, function(
                          resSevCode,
                          index
                        ) {
                          return [
                            _c("td", [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value:
                                      specification[
                                        "high_level_" +
                                          resSevCode.meaning.toLowerCase()
                                      ],
                                    expression:
                                      "specification['high_level_' + resSevCode.meaning.toLowerCase()]"
                                  }
                                ],
                                staticClass: "form-control text-right",
                                style: "border-color: " + resSevCode.tag,
                                attrs: { type: "number" },
                                domProps: {
                                  value:
                                    specification[
                                      "high_level_" +
                                        resSevCode.meaning.toLowerCase()
                                    ]
                                },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      specification,
                                      "high_level_" +
                                        resSevCode.meaning.toLowerCase(),
                                      $event.target.value
                                    )
                                  }
                                }
                              })
                            ])
                          ]
                        }),
                        _vm._v(" "),
                        _c("td", { staticClass: "text-center align-middle" }, [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: specification.optional_ind,
                                expression: "specification.optional_ind"
                              }
                            ],
                            attrs: { type: "checkbox", value: "Y" },
                            domProps: {
                              checked: Array.isArray(specification.optional_ind)
                                ? _vm._i(specification.optional_ind, "Y") > -1
                                : specification.optional_ind
                            },
                            on: {
                              change: function($event) {
                                var $$a = specification.optional_ind,
                                  $$el = $event.target,
                                  $$c = $$el.checked ? true : false
                                if (Array.isArray($$a)) {
                                  var $$v = "Y",
                                    $$i = _vm._i($$a, $$v)
                                  if ($$el.checked) {
                                    $$i < 0 &&
                                      _vm.$set(
                                        specification,
                                        "optional_ind",
                                        $$a.concat([$$v])
                                      )
                                  } else {
                                    $$i > -1 &&
                                      _vm.$set(
                                        specification,
                                        "optional_ind",
                                        $$a
                                          .slice(0, $$i)
                                          .concat($$a.slice($$i + 1))
                                      )
                                  }
                                } else {
                                  _vm.$set(specification, "optional_ind", $$c)
                                }
                              }
                            }
                          })
                        ])
                      ],
                      2
                    )
                  : _vm._e()
              }),
              _vm._v(" "),
              _vm.specifications.length == 0
                ? _c("tr", { staticClass: "text-center w-100" }, [
                    _c("td", { attrs: { colspan: "13" } }, [
                      _vm._v("ไม่มีข้อมูล")
                    ])
                  ])
                : _vm._e()
            ],
            2
          )
        ]
      )
    ]),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass:
          "row form-group justify-content-center clearfix tw-my-6 text-center"
      },
      [
        _c("div", { staticClass: "col-lg-6 col-md-6" }, [
          _c(
            "button",
            {
              staticClass: "btn btn-lg btn-primary tw-w-32",
              attrs: { type: "button" },
              on: { click: _vm.addLine }
            },
            [
              _c("i", { staticClass: "fa fa-plus" }),
              _vm._v(" เพิ่มรายการ\n            ")
            ]
          ),
          _vm._v(" "),
          _c(
            "button",
            {
              staticClass: "btn btn-lg btn-primary tw-w-32",
              attrs: { disabled: !_vm.canSave, type: "button" },
              on: { click: _vm.save }
            },
            [
              _c("i", { staticClass: "fa fa-plus" }),
              _vm._v(" บันทึก\n            ")
            ]
          ),
          _vm._v(" "),
          _c(
            "a",
            {
              staticClass:
                "btn btn-lg tw-bg-gray-100 tw-bg-opacity-60 btn-white tw-w-32",
              attrs: {
                type: "button",
                href: _vm.url.qm_settings_specifications_index
              }
            },
            [
              _c("i", { staticClass: "fa fa-times" }),
              _vm._v(" ยกเลิก\n            ")
            ]
          )
        ])
      ]
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "th",
      { staticClass: "text-center align-middle", attrs: { rowspan: "2" } },
      [_vm._v("หน่วย"), _c("br"), _vm._v("การทดสอบ*")]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "th",
      { staticClass: "text-center align-middle", attrs: { rowspan: "2" } },
      [_vm._v("รายละเอียดหน่วย"), _c("br"), _vm._v("การทดสอบ*")]
    )
  }
]
render._withStripped = true



/***/ })

}]);