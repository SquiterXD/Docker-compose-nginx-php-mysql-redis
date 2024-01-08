(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ct_product_group_Show_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/product_group/Show.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/product_group/Show.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['product_group', 'product', 'new_products', 'p_cost_code', 'p_product_group'],
  data: function data() {
    return {
      tableData: [],
      loading: false,
      itemCostingV: [],
      form: {
        loading_data: false,
        show: false,
        loading: false,
        items: [],
        delItems: {}
      }
    };
  },
  mounted: function mounted() {
    this.itemCostingV = this.new_products;
    this.tableData = this.product;
    $('.slimScroll').slimScroll({
      height: '650px' // width: '100%'

    });
  },
  methods: {
    remoteMethod: function remoteMethod(query) {
      var _this = this;

      if (query) {
        console.log("query", query);
        this.loading = true;
        axios.get("/ct/ajax/product_group/item_costing?search=".concat(query)).then(function (res) {
          //  console.log(res.data)
          var data = res.data.data;
          console.log(data);
          _this.itemCostingV = data;
        })["catch"](function (err) {}).then(function () {
          _this.loading = false;
        });
      }
    },
    store: function store() {
      var _this2 = this;

      axios.post("/ct/ajax/product_group/product-item", this.product_group).then(function (res) {
        var data = res.data.data;

        _this2.$message({
          showClose: true,
          message: data,
          type: "success"
        });
      })["catch"](function (err) {
        var data = err.response.data.data;

        _this2.$message({
          showClose: true,
          message: data,
          type: "error"
        });
      });
    },
    delLine: function delLine(item) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var vm, row;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                vm = _this3;
                row = Object.keys(vm.form.delItems).length;

                if (item.is_delete == true) {
                  vm.$set(vm.form.delItems, item.inventory_item_id, item.inventory_item_id);
                } else {
                  // vm.delete( vm.form.delItems, item.inventory_item_id);
                  Vue["delete"](vm.form.delItems, item.inventory_item_id);
                }

              case 3:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    cancel: function cancel() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this4.form.show = false;
                _this4.form.items = [];

              case 2:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    save: function save() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        var vm, alertRes, input;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                vm = _this5;
                input = {
                  cost_code: vm.p_cost_code,
                  product_group: vm.p_product_group,
                  items: vm.form.items
                };
                vm.form.loading = true;
                axios.post("/ct/ajax/product_group/store-product-item", {
                  input: input
                }).then( /*#__PURE__*/function () {
                  var _ref = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3(res) {
                    var data;
                    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
                      while (1) {
                        switch (_context3.prev = _context3.next) {
                          case 0:
                            data = res.data;

                            if (!(data.status == 'S')) {
                              _context3.next = 6;
                              break;
                            }

                            _context3.next = 4;
                            return swal({
                              title: '&nbsp;',
                              text: 'บันทึกข้อมูลสำเร็จ',
                              type: "success",
                              html: true
                            });

                          case 4:
                            vm.form.items = [];
                            location.reload(); // vm.fetchData();

                          case 6:
                            if (data.status != 'S') {
                              alertRes = swal({
                                title: "Error !",
                                text: data.message,
                                type: "error",
                                showConfirmButton: true
                              });
                              location.reload();
                            }

                            vm.form.loading = false;

                          case 8:
                          case "end":
                            return _context3.stop();
                        }
                      }
                    }, _callee3);
                  }));

                  return function (_x) {
                    return _ref.apply(this, arguments);
                  };
                }());

              case 4:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    del: function del() {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6() {
        var vm, alertRes, confirm, input;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                vm = _this6;
                confirm = false;
                input = {
                  cost_code: vm.p_cost_code,
                  product_group: vm.p_product_group,
                  del_items: vm.form.delItems
                };
                _context6.next = 5;
                return helperAlert.showProgressConfirm('กรุณายืนยันลบข้อมูล');

              case 5:
                confirm = _context6.sent;

                if (confirm) {
                  vm.form.loading_data = true;
                  axios.post("/ct/ajax/product_group/del-product-item", {
                    input: input
                  }).then( /*#__PURE__*/function () {
                    var _ref2 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5(res) {
                      var data;
                      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
                        while (1) {
                          switch (_context5.prev = _context5.next) {
                            case 0:
                              data = res.data;

                              if (!(data.status == 'S')) {
                                _context5.next = 6;
                                break;
                              }

                              _context5.next = 4;
                              return swal({
                                title: '&nbsp;',
                                text: 'บันทึกข้อมูลสำเร็จ',
                                type: "success",
                                html: true
                              });

                            case 4:
                              vm.form.delItems = {};
                              location.reload(); // vm.fetchData();

                            case 6:
                              if (data.status != 'S') {
                                alertRes = swal({
                                  title: "Error !",
                                  text: data.message,
                                  type: "error",
                                  showConfirmButton: true
                                });
                                location.reload();
                              }

                              vm.form.loading_data = false;

                            case 8:
                            case "end":
                              return _context5.stop();
                          }
                        }
                      }, _callee5);
                    }));

                    return function (_x2) {
                      return _ref2.apply(this, arguments);
                    };
                  }());
                }

              case 7:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      }))();
    }
  }
});
"";

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/product_group/Show.vue?vue&type=style&index=0&id=67e90da0&lang=scss&scoped=true&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/product_group/Show.vue?vue&type=style&index=0&id=67e90da0&lang=scss&scoped=true& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, ".ct-header[data-v-67e90da0] {\n  font-size: 1.1rem;\n  font-weight: bold;\n}\n.ct-table[data-v-67e90da0] {\n  border: 1px solid #ddd;\n}\n.ct-table div[data-v-67e90da0] {\n  padding: 10px;\n}\n.ct-table div[data-v-67e90da0]:not(:last-child) {\n  border-bottom: 1px solid #ddd;\n}\n.ct-table__header[data-v-67e90da0] {\n  background: #ddd;\n  font-weight: bold;\n}\n.el-table .warning-row[data-v-67e90da0] {\n  background-color: oldlace !important;\n}\n.side_list[data-v-67e90da0] {\n  height: 500px;\n  border-radius: 5px;\n  padding: 20px;\n  border: 2px solid #eee;\n}\n.side_list .title[data-v-67e90da0] {\n  font-size: 14px;\n  font-weight: bold;\n  color: #909399;\n}\n.side_list .show_list[data-v-67e90da0] {\n  max-height: 400px;\n  overflow: scroll;\n}\n.side_list .show_list-item[data-v-67e90da0] {\n  width: 100%;\n  justify-content: space-between;\n}\n.m-px__5[data-v-67e90da0] {\n  margin: 5px;\n}\n.flex[data-v-67e90da0] {\n  display: flex;\n}\n.text-title[data-v-67e90da0] {\n  font-size: 16px;\n  font-weight: 600;\n}\n.btn-info[data-v-67e90da0] {\n  background-color: #02b0ef;\n  border-color: #02b0ef;\n}\n.btn-cancel[data-v-67e90da0] {\n  background-color: #ec4958;\n  border-color: #ec4958;\n  color: white;\n}\n.text-refresh[data-v-67e90da0] {\n  color: #ec4958;\n}\n.show_list[data-v-67e90da0] {\n  display: flex;\n  flex-wrap: wrap;\n}\n.show_list-item[data-v-67e90da0] {\n  cursor: pointer;\n  display: flex;\n  margin: 5px;\n  background-color: #f4f4f5;\n  padding: 3px 10px;\n  color: #909399;\n  border-color: #e9e9eb;\n  border-radius: 3px;\n  text-align: left;\n  align-items: center;\n}\n.show_list-item[data-v-67e90da0]:hover {\n  background-color: #ededf0;\n}\n.show_list-item__close[data-v-67e90da0] {\n  margin-left: 10px;\n}", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/product_group/Show.vue?vue&type=style&index=0&id=67e90da0&lang=scss&scoped=true&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/product_group/Show.vue?vue&type=style&index=0&id=67e90da0&lang=scss&scoped=true& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Show_vue_vue_type_style_index_0_id_67e90da0_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!../../../../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Show.vue?vue&type=style&index=0&id=67e90da0&lang=scss&scoped=true& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/product_group/Show.vue?vue&type=style&index=0&id=67e90da0&lang=scss&scoped=true&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Show_vue_vue_type_style_index_0_id_67e90da0_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Show_vue_vue_type_style_index_0_id_67e90da0_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/components/ct/product_group/Show.vue":
/*!***********************************************************!*\
  !*** ./resources/js/components/ct/product_group/Show.vue ***!
  \***********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Show_vue_vue_type_template_id_67e90da0_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Show.vue?vue&type=template&id=67e90da0&scoped=true& */ "./resources/js/components/ct/product_group/Show.vue?vue&type=template&id=67e90da0&scoped=true&");
/* harmony import */ var _Show_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Show.vue?vue&type=script&lang=js& */ "./resources/js/components/ct/product_group/Show.vue?vue&type=script&lang=js&");
/* harmony import */ var _Show_vue_vue_type_style_index_0_id_67e90da0_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Show.vue?vue&type=style&index=0&id=67e90da0&lang=scss&scoped=true& */ "./resources/js/components/ct/product_group/Show.vue?vue&type=style&index=0&id=67e90da0&lang=scss&scoped=true&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _Show_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Show_vue_vue_type_template_id_67e90da0_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _Show_vue_vue_type_template_id_67e90da0_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "67e90da0",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ct/product_group/Show.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ct/product_group/Show.vue?vue&type=script&lang=js&":
/*!************************************************************************************!*\
  !*** ./resources/js/components/ct/product_group/Show.vue?vue&type=script&lang=js& ***!
  \************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Show_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Show.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/product_group/Show.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Show_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ct/product_group/Show.vue?vue&type=style&index=0&id=67e90da0&lang=scss&scoped=true&":
/*!*********************************************************************************************************************!*\
  !*** ./resources/js/components/ct/product_group/Show.vue?vue&type=style&index=0&id=67e90da0&lang=scss&scoped=true& ***!
  \*********************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Show_vue_vue_type_style_index_0_id_67e90da0_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!../../../../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Show.vue?vue&type=style&index=0&id=67e90da0&lang=scss&scoped=true& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/product_group/Show.vue?vue&type=style&index=0&id=67e90da0&lang=scss&scoped=true&");


/***/ }),

/***/ "./resources/js/components/ct/product_group/Show.vue?vue&type=template&id=67e90da0&scoped=true&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/components/ct/product_group/Show.vue?vue&type=template&id=67e90da0&scoped=true& ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Show_vue_vue_type_template_id_67e90da0_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Show_vue_vue_type_template_id_67e90da0_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Show_vue_vue_type_template_id_67e90da0_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Show.vue?vue&type=template&id=67e90da0&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/product_group/Show.vue?vue&type=template&id=67e90da0&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/product_group/Show.vue?vue&type=template&id=67e90da0&scoped=true&":
/*!*********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/product_group/Show.vue?vue&type=template&id=67e90da0&scoped=true& ***!
  \*********************************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "list-product-groups" }, [
    _c(
      "div",
      { staticClass: "col-lg-12 mt-2" },
      [
        _c("el-card", { staticClass: "box-card my-2" }, [
          _c(
            "div",
            {
              staticClass: "ct-header clearfix",
              attrs: { slot: "header" },
              slot: "header"
            },
            [
              _vm._v(
                "\n      ศูนย์ต้นทุน " +
                  _vm._s(_vm.product_group.cost_code) +
                  " " +
                  _vm._s(_vm.product_group.cost_description) +
                  " \n    "
              )
            ]
          ),
          _vm._v(" "),
          _c(
            "div",
            {
              directives: [
                {
                  name: "loading",
                  rawName: "v-loading",
                  value: _vm.form.loading_data,
                  expression: "form.loading_data"
                }
              ],
              staticClass: "px-4 py-2"
            },
            [
              _c("div", { staticClass: "row" }, [
                _c("div", { staticClass: "col-6" }, [
                  _c("div", [
                    _vm._v(
                      "\n            กลุ่มผลิตภัณฑ์: " +
                        _vm._s(_vm.product_group.product_group) +
                        " - " +
                        _vm._s(_vm.product_group.description) +
                        "\n          "
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "mt-5" }, [
                    _c("div", { staticClass: "slimScroll" }, [
                      _c(
                        "table",
                        { staticClass: "table table table-bordered" },
                        [
                          _c("thead", [
                            _c("tr", [
                              _c("th", { attrs: { width: "10px;" } }),
                              _vm._v(" "),
                              _c("th", { attrs: { width: "" } }, [
                                _vm._v(
                                  "\n                            ผลิตภัณฑ์\n                        "
                                )
                              ])
                            ])
                          ]),
                          _vm._v(" "),
                          _c(
                            "tbody",
                            [
                              _vm.tableData.length == 0
                                ? _c("tr", [
                                    _c(
                                      "td",
                                      {
                                        staticClass: "text-center",
                                        attrs: { colspan: "2" }
                                      },
                                      [_vm._v("ไม่พบข้อมูล")]
                                    )
                                  ])
                                : _vm._l(_vm.tableData, function(item, index) {
                                    return _c("tr", { key: index }, [
                                      _c(
                                        "td",
                                        {
                                          staticClass:
                                            "align-middle text-center"
                                        },
                                        [
                                          _c("input", {
                                            directives: [
                                              {
                                                name: "model",
                                                rawName: "v-model",
                                                value: item.is_delete,
                                                expression: "item.is_delete"
                                              }
                                            ],
                                            attrs: { type: "checkbox" },
                                            domProps: {
                                              checked: Array.isArray(
                                                item.is_delete
                                              )
                                                ? _vm._i(item.is_delete, null) >
                                                  -1
                                                : item.is_delete
                                            },
                                            on: {
                                              change: [
                                                function($event) {
                                                  var $$a = item.is_delete,
                                                    $$el = $event.target,
                                                    $$c = $$el.checked
                                                      ? true
                                                      : false
                                                  if (Array.isArray($$a)) {
                                                    var $$v = null,
                                                      $$i = _vm._i($$a, $$v)
                                                    if ($$el.checked) {
                                                      $$i < 0 &&
                                                        _vm.$set(
                                                          item,
                                                          "is_delete",
                                                          $$a.concat([$$v])
                                                        )
                                                    } else {
                                                      $$i > -1 &&
                                                        _vm.$set(
                                                          item,
                                                          "is_delete",
                                                          $$a
                                                            .slice(0, $$i)
                                                            .concat(
                                                              $$a.slice($$i + 1)
                                                            )
                                                        )
                                                    }
                                                  } else {
                                                    _vm.$set(
                                                      item,
                                                      "is_delete",
                                                      $$c
                                                    )
                                                  }
                                                },
                                                function($event) {
                                                  return _vm.delLine(item)
                                                }
                                              ]
                                            }
                                          })
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c("td", [
                                        _vm._v(
                                          _vm._s(item.product_item_number) +
                                            " - " +
                                            _vm._s(item.product_item_desc)
                                        )
                                      ])
                                    ])
                                  })
                            ],
                            2
                          )
                        ]
                      )
                    ])
                  ])
                ]),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    directives: [
                      {
                        name: "loading",
                        rawName: "v-loading",
                        value: _vm.form.loading,
                        expression: "form.loading"
                      }
                    ],
                    staticClass: "col-6 text text-right"
                  },
                  [
                    _c("div", { staticClass: "text-right" }, [
                      Object.keys(_vm.form.delItems).length > 0
                        ? _c(
                            "button",
                            {
                              staticClass: "btn btn-danger btn-lg ml-2 tw-w-34",
                              attrs: { type: "button" },
                              on: {
                                click: function($event) {
                                  return _vm.del()
                                }
                              }
                            },
                            [
                              _vm._v(
                                "\n                  ลบผลิตภัณฑ์\n                "
                              )
                            ]
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _c(
                        "button",
                        {
                          staticClass: "btn btn-primary btn-lg ml-2 tw-w-34",
                          attrs: { type: "button" },
                          on: {
                            click: function($event) {
                              _vm.form.show = true
                            }
                          }
                        },
                        [
                          _vm._v(
                            "\n                    เพิ่มผลิตภัณฑ์ใหม่\n                "
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "button",
                        {
                          staticClass: "btn btn-success btn-lg ml-2 tw-w-24",
                          attrs: {
                            disabled: _vm.form.items.length == 0,
                            type: "button"
                          },
                          on: {
                            click: function($event) {
                              return _vm.save()
                            }
                          }
                        },
                        [_vm._v("\n                  บันทึก\n                ")]
                      ),
                      _vm._v(" "),
                      _c(
                        "a",
                        {
                          staticClass: "btn btn-danger ml-2 btn-lg tw-w-24",
                          attrs: { href: "/ct/product_group" }
                        },
                        [
                          _vm._v(
                            "\n                  ย้อนกลับ\n                "
                          )
                        ]
                      )
                    ]),
                    _vm._v(" "),
                    _c(
                      "transition",
                      {
                        attrs: {
                          "enter-active-class": "animated fadeIn",
                          "leave-active-class": "animated fadeOut"
                        }
                      },
                      [
                        _vm.form.show
                          ? _c("div", { staticClass: "row text-left" }, [
                              _c(
                                "div",
                                {
                                  staticClass:
                                    "form-group pl-2 pr-2 mb-0 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2"
                                },
                                [
                                  _c(
                                    "label",
                                    {
                                      staticClass:
                                        "text-left text-muted tw-font-bold tw-uppercase mb-0"
                                    },
                                    [_vm._v("ผลิตภัณฑ์ :")]
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "div",
                                    { staticClass: "input-group " },
                                    [
                                      _c(
                                        "el-select",
                                        {
                                          staticStyle: { width: "100%" },
                                          attrs: {
                                            filterable: "",
                                            clearable: "",
                                            multiple: "",
                                            placeholder: "",
                                            remote: "",
                                            "remote-method": _vm.remoteMethod,
                                            loading: _vm.loading
                                          },
                                          model: {
                                            value: _vm.form.items,
                                            callback: function($$v) {
                                              _vm.$set(_vm.form, "items", $$v)
                                            },
                                            expression: "form.items"
                                          }
                                        },
                                        _vm._l(_vm.itemCostingV, function(
                                          item
                                        ) {
                                          return _c("el-option", {
                                            key: item.value,
                                            attrs: {
                                              label: item.label,
                                              value: item.value,
                                              debounce: 3000
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
                                  staticClass:
                                    "text-center form-group pl-2 pr-2 mb-0 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3"
                                },
                                [
                                  _c(
                                    "button",
                                    {
                                      staticClass:
                                        "btn btn-white btn-lg  tw-w-24",
                                      attrs: { type: "button" },
                                      on: {
                                        click: function($event) {
                                          return _vm.cancel()
                                        }
                                      }
                                    },
                                    [
                                      _vm._v(
                                        "\n                          ยกเลิก\n                      "
                                      )
                                    ]
                                  )
                                ]
                              )
                            ])
                          : _vm._e()
                      ]
                    )
                  ],
                  1
                )
              ])
            ]
          )
        ])
      ],
      1
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);