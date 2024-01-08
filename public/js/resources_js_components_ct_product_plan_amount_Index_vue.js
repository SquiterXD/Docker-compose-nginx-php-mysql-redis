(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ct_product_plan_amount_Index_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/product_plan_amount/Index.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/product_plan_amount/Index.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  data: function data() {
    return {
      form: {
        period_year: "",
        plan_version_no: "" // period_year: 2022,
        // plan_version_no: 1

      },
      loading: false,
      periodYears: [],
      costCenters: [],
      planVesion: [],
      uom: [],
      selectCostCenter: "",
      items: {
        productGroupItems: {
          name: "",
          children: []
        },
        productGroupPlan: {}
      },
      storage: {
        productGroupPlan: {
          productGroupItems: []
        }
      },
      keyViewProduct: "",
      changeForm: {},
      edit: {
        productGroups: []
      }
    };
  },
  mounted: function mounted() {
    this.getMasterData(); // this.search();
  },
  methods: {
    selectPeriodYear: function selectPeriodYear() {
      var _arguments = arguments,
          _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var clear;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                clear = _arguments.length > 0 && _arguments[0] !== undefined ? _arguments[0] : true;
                axios.get("/ct/ajax/product-group-plan/plan-version?period_year=".concat(_this.form.period_year)).then(function (res) {
                  _this.planVesion = res.data.data;

                  if (clear) {
                    _this.form.plan_version_no = "";
                  }
                });

              case 2:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    viewProduct: function viewProduct(key) {
      if (this.keyViewProduct != key) {
        this.keyViewProduct = key;
      } else {
        this.keyViewProduct = "";
      }
    },
    findByCostCenter: function findByCostCenter() {
      this.items.productGroupItems = this.storage.productGroupItems[this.selectCostCenter];
    },
    getMasterData: function getMasterData() {
      var _this2 = this;

      axios.get("/ct/ajax/year-view").then(function (res) {
        _this2.periodYears = res.data;
      });
      this.getUom();
    },
    getUom: function getUom() {
      var _this3 = this;

      axios.get("/ct/ajax/product-group-plan/uom").then(function (res) {
        _this3.uom = res.data.data;
      });
    },
    create: function create() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                if (_this4.form.plan_version_no) {
                  _context2.next = 5;
                  break;
                }

                _context2.next = 3;
                return _this4.planVesion.length;

              case 3:
                _context2.t0 = _context2.sent;
                _this4.form.plan_version_no = _context2.t0 + 1;

              case 5:
                _context2.next = 7;
                return axios.post("/ct/ajax/product-group-plan", {
                  period_year: _this4.form.period_year,
                  plan_version_no: _this4.form.plan_version_no
                }).then(function (res) {
                  _this4.setData(res.data);

                  _this4.$message({
                    showClose: true,
                    message: "บันทึกสำเร็จ",
                    type: "success"
                  });
                })["catch"](function (err) {
                  _this4.selectPeriodYear(false);

                  _this4.search(); // this.loading = false;
                  // this.resetData();
                  // this.$message({
                  //     showClose: true,
                  //     message: err.response.data.error
                  //         ? err.response.data.error
                  //         : `ไม่สามารถบันทึกได้`,
                  //     type: "error"
                  // });

                });

              case 7:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    prdProductivityQty: function prdProductivityQty(item) {
      var _this5 = this;

      var rs = this.storage.prdGrpPlanGroupV.find(function (element) {
        return element.cost_code == _this5.selectCostCenter && element.product_group == item.pg_code;
      });
      return rs.prd_productivity_qty;
    },
    search: function search() {
      var _arguments2 = arguments,
          _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var defSelCostCenter, vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                defSelCostCenter = _arguments2.length > 0 && _arguments2[0] !== undefined ? _arguments2[0] : false;
                vm = _this6;
                vm.loading = true;
                console.log('search ---------->', defSelCostCenter);
                _context3.next = 6;
                return axios.get("/ct/ajax/product-group-plan", {
                  params: {
                    period_year: vm.form.period_year,
                    plan_version_no: vm.form.plan_version_no
                  }
                }).then(function (res) {
                  vm.setData(res.data, defSelCostCenter);
                  console.log(res.data);
                  vm.loading = false;
                })["catch"](function (err) {
                  console.log(err.response.data);
                  vm.loading = false;
                  vm.resetData();

                  _this6.$message({
                    showClose: true,
                    message: "\u0E44\u0E21\u0E48\u0E1E\u0E1A\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25",
                    type: "error"
                  });
                });

              case 6:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    setData: function setData(data) {
      var _arguments3 = arguments,
          _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        var defCostCode, productGroupItems, productGroupItem, costCode;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                defCostCode = _arguments3.length > 1 && _arguments3[1] !== undefined ? _arguments3[1] : false;
                // let productGroupItems = data.productGroupItems;
                // let productGroupItem = productGroupItems[Object.keys(productGroupItems)[0]];
                // this.costCenters = data.costCenters;
                // this.selectCostCenter = productGroupItem.cost_code;
                // this.items.productGroupPlan = data.productGroupPlan;
                // this.items.productGroupItems = productGroupItem;
                // this.storage = data;
                // defCostCode = 51;
                productGroupItems = data.productGroupItems;
                _this7.storage = data;
                productGroupItem = productGroupItems[Object.keys(productGroupItems)[0]];
                costCode = productGroupItem.cost_code;

                if (defCostCode) {
                  productGroupItem = productGroupItems[defCostCode.toString()];
                  costCode = defCostCode;
                } else {}

                _this7.storage = data;
                _this7.costCenters = data.costCenters; // this.selectCostCenter = productGroupItem.cost_code;

                _this7.selectCostCenter = costCode;
                _this7.items.productGroupPlan = data.productGroupPlan;
                _this7.items.productGroupItems = productGroupItem; // this.storage = data;
                // ----------------------------------------------------------
                // let productGroupItems = data.productGroupItems;
                // if (defCostCode) {
                //     let index = await this.productGroupItems.findIndex(o => o.cost_code == defCostCode);
                //     // let productGroupItem = productGroupItems[Object.keys(productGroupItems)[index]];
                //     let productGroupItem = productGroupItems[Object.keys(productGroupItems)[index]];
                //     console.log('1 setData ->', productGroupItem)
                // } else {
                //     let productGroupItem = productGroupItems[Object.keys(productGroupItems)[0]];
                //     console.log('2 setData ->', productGroupItem)
                // }
                //     console.log('3 setData ->', productGroupItem)
                // this.costCenters = data.costCenters;
                // this.selectCostCenter = productGroupItem.cost_code;
                // this.items.productGroupPlan = data.productGroupPlan;
                // this.items.productGroupItems = productGroupItem;
                // this.storage = data;
                // --------------------------------------------------------
                // console.log('setData  11111 ---------->', defCostCode);
                // let productGroupItems = data.productGroupItems;
                // this.costCenters = data.costCenters;
                // if (defCostCode) {
                //     let index = this.productGroupItems.findIndex(o => o.cost_code == defCostCode);
                //     let productGroupItem = productGroupItems[Object.keys(productGroupItems)[index]];
                //     console.log('-> 1', productGroupItem)
                //     this.selectCostCenter = defCostCode;
                // } else {
                //     let productGroupItem = productGroupItems[Object.keys(productGroupItems)[0]];
                //     console.log('-> 2', productGroupItem)
                //     this.selectCostCenter = productGroupItem.cost_code;
                // }
                // console.log('-> 3', productGroupItem)
                // // let productGroupItem =
                // //         productGroupItems[Object.keys(productGroupItems)[0]];
                // //         console.log('--------------------------------------', productGroupItem);
                // //     this.selectCostCenter = productGroupItem.cost_code;
                // this.items.productGroupPlan = data.productGroupPlan;
                // this.items.productGroupItems = productGroupItem;
                // this.storage = data;

              case 11:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    resetData: function resetData() {
      this.items.productGroupPlan = {};
      this.items.productGroupItems = {
        name: "",
        children: []
      };
      this.selectCostCenter = "";
    },
    editForm: function editForm(productGroup, itemNo, subChildren) {
      var _this8 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        var vm, confirm, data;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                vm = _this8;
                confirm = true;
                data = JSON.parse(JSON.stringify(subChildren));
                data.product_item_number = itemNo;
                data.product_group = productGroup;
                vm.$set(vm.changeForm, "productGroup-" + productGroup + "-item-" + itemNo, data);

              case 6:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    stripNonNumber: function stripNonNumber(text) {
      return parseFloat(text.replace(/,/g, ""));
    },
    numberFormat: function numberFormat(n) {
      return "".concat(n).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
    submitUpdate: function submitUpdate() {
      var _this9 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6() {
        var defSelCostCenter;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                defSelCostCenter = JSON.parse(JSON.stringify(_this9.selectCostCenter));
                _context6.next = 3;
                return _this9.updateProductGroup();

              case 3:
                _context6.next = 5;
                return _this9.updateProduct();

              case 5:
                _context6.next = 7;
                return _this9.search(defSelCostCenter);

              case 7:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      }))();
    },
    updateProductGroup: function updateProductGroup() {
      var _this10 = this;

      axios.post("/ct/ajax/product_group/update", {
        product_groups: this.items.productGroupItems
      }).then(function (res) {
        if (res.data.status == "C") {
          _this10.$message({
            showClose: true,
            message: "บันทึกสำเร็จ",
            type: "success"
          });
        } else {
          _this10.$message({
            showClose: true,
            message: res.data.msg,
            type: "error"
          });
        }
      })["catch"](function (err) {
        console.log(err.response.data);
      });
    },
    updateProduct: function updateProduct() {
      var _this11 = this;

      var vm = this;
      var form = JSON.parse(JSON.stringify(vm.form));
      var selectCostCenter = JSON.parse(JSON.stringify(vm.selectCostCenter));
      axios.post("/ct/ajax/product-group-plan/update-item", {
        period_year: vm.form.period_year,
        plan_version_no: vm.form.plan_version_no,
        cost_code: vm.selectCostCenter,
        data: vm.changeForm
      }).then(function (res) {
        if (res.data.status == "C") {
          _this11.$message({
            showClose: true,
            message: "บันทึกสำเร็จ",
            type: "success"
          });
        } else {
          _this11.$message({
            showClose: true,
            message: res.data.msg,
            type: "error"
          });
        }
      })["catch"](function (err) {
        console.log(err.response.data);
      });
      vm.changeForm = {};
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/product_plan_amount/Index.vue?vue&type=style&index=0&id=20f0026e&lang=scss&scoped=true&":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/product_plan_amount/Index.vue?vue&type=style&index=0&id=20f0026e&lang=scss&scoped=true& ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, ".el-table .warning-row[data-v-20f0026e] {\n  background-color: oldlace !important;\n}\n.el-input-number .el-input__inner[data-v-20f0026e] {\n  text-align: left !important;\n}\n.justify_between[data-v-20f0026e] {\n  display: flex;\n  align-items: center;\n  justify-content: space-between;\n}\n.side_list[data-v-20f0026e] {\n  height: 500px;\n  border-radius: 5px;\n  padding: 20px;\n  border: 2px solid #eee;\n}\n.side_list .title[data-v-20f0026e] {\n  font-size: 14px;\n  font-weight: bold;\n  color: #909399;\n}\n.side_list .show_list[data-v-20f0026e] {\n  max-height: 400px;\n  overflow: scroll;\n}\n.side_list .show_list-item[data-v-20f0026e] {\n  width: 100%;\n  justify-content: space-between;\n}\n.m-px__5[data-v-20f0026e] {\n  margin: 5px;\n}\n.flex[data-v-20f0026e] {\n  display: flex;\n}\n.text-title[data-v-20f0026e] {\n  font-size: 16px;\n  font-weight: 600;\n}\n.btn-info[data-v-20f0026e] {\n  background-color: #02b0ef;\n  border-color: #02b0ef;\n}\n.btn-success[data-v-20f0026e] {\n  background-color: #1ab394;\n  border-color: #1ab394;\n}\n.btn-cancel[data-v-20f0026e] {\n  background-color: #ec4958;\n  border-color: #ec4958;\n  color: white;\n}\n.text-refresh[data-v-20f0026e] {\n  color: #ec4958;\n}\n.show_list[data-v-20f0026e] {\n  display: flex;\n  flex-wrap: wrap;\n}\n.show_list-item[data-v-20f0026e] {\n  cursor: pointer;\n  display: flex;\n  margin: 5px;\n  background-color: #f4f4f5;\n  padding: 3px 10px;\n  color: #909399;\n  border-color: #e9e9eb;\n  border-radius: 3px;\n  text-align: left;\n  align-items: center;\n}\n.show_list-item[data-v-20f0026e]:hover {\n  background-color: #ededf0;\n}\n.show_list-item__close[data-v-20f0026e] {\n  margin-left: 10px;\n}", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/product_plan_amount/Index.vue?vue&type=style&index=0&id=20f0026e&lang=scss&scoped=true&":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/product_plan_amount/Index.vue?vue&type=style&index=0&id=20f0026e&lang=scss&scoped=true& ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_style_index_0_id_20f0026e_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!../../../../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=style&index=0&id=20f0026e&lang=scss&scoped=true& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/product_plan_amount/Index.vue?vue&type=style&index=0&id=20f0026e&lang=scss&scoped=true&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_style_index_0_id_20f0026e_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_style_index_0_id_20f0026e_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/components/ct/product_plan_amount/Index.vue":
/*!******************************************************************!*\
  !*** ./resources/js/components/ct/product_plan_amount/Index.vue ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_20f0026e_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=20f0026e&scoped=true& */ "./resources/js/components/ct/product_plan_amount/Index.vue?vue&type=template&id=20f0026e&scoped=true&");
/* harmony import */ var _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js& */ "./resources/js/components/ct/product_plan_amount/Index.vue?vue&type=script&lang=js&");
/* harmony import */ var _Index_vue_vue_type_style_index_0_id_20f0026e_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Index.vue?vue&type=style&index=0&id=20f0026e&lang=scss&scoped=true& */ "./resources/js/components/ct/product_plan_amount/Index.vue?vue&type=style&index=0&id=20f0026e&lang=scss&scoped=true&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Index_vue_vue_type_template_id_20f0026e_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _Index_vue_vue_type_template_id_20f0026e_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "20f0026e",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ct/product_plan_amount/Index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ct/product_plan_amount/Index.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/components/ct/product_plan_amount/Index.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/product_plan_amount/Index.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ct/product_plan_amount/Index.vue?vue&type=style&index=0&id=20f0026e&lang=scss&scoped=true&":
/*!****************************************************************************************************************************!*\
  !*** ./resources/js/components/ct/product_plan_amount/Index.vue?vue&type=style&index=0&id=20f0026e&lang=scss&scoped=true& ***!
  \****************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_style_index_0_id_20f0026e_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!../../../../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=style&index=0&id=20f0026e&lang=scss&scoped=true& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/product_plan_amount/Index.vue?vue&type=style&index=0&id=20f0026e&lang=scss&scoped=true&");


/***/ }),

/***/ "./resources/js/components/ct/product_plan_amount/Index.vue?vue&type=template&id=20f0026e&scoped=true&":
/*!*************************************************************************************************************!*\
  !*** ./resources/js/components/ct/product_plan_amount/Index.vue?vue&type=template&id=20f0026e&scoped=true& ***!
  \*************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_20f0026e_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_20f0026e_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_20f0026e_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=template&id=20f0026e&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/product_plan_amount/Index.vue?vue&type=template&id=20f0026e&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/product_plan_amount/Index.vue?vue&type=template&id=20f0026e&scoped=true&":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/product_plan_amount/Index.vue?vue&type=template&id=20f0026e&scoped=true& ***!
  \****************************************************************************************************************************************************************************************************************************************************/
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
    { staticClass: "list-product-groups" },
    [
      _c("div", { staticClass: "form-group row" }, [
        _c(
          "div",
          { staticClass: "col-lg-12" },
          [
            _c(
              "el-select",
              {
                attrs: { filterable: "", placeholder: "ปีบัญชีงบประมาณ" },
                on: { change: _vm.selectPeriodYear },
                model: {
                  value: _vm.form.period_year,
                  callback: function($$v) {
                    _vm.$set(_vm.form, "period_year", $$v)
                  },
                  expression: "form.period_year"
                }
              },
              _vm._l(_vm.periodYears, function(item, index) {
                return _c("el-option", {
                  key: index,
                  attrs: {
                    label: item.period_year_thai,
                    value: item.period_year
                  }
                })
              }),
              1
            ),
            _vm._v(" "),
            _c(
              "el-select",
              {
                attrs: { filterable: "", placeholder: "แผนผลิตภัณฑ์" },
                model: {
                  value: _vm.form.plan_version_no,
                  callback: function($$v) {
                    _vm.$set(_vm.form, "plan_version_no", $$v)
                  },
                  expression: "form.plan_version_no"
                }
              },
              _vm._l(_vm.planVesion, function(item, index) {
                return _c("el-option", {
                  key: index,
                  attrs: {
                    label: item.plan_version_no,
                    value: item.plan_version_no
                  }
                })
              }),
              1
            ),
            _vm._v(" "),
            _c(
              "el-button",
              {
                staticClass: "btn-info ml-2",
                attrs: { type: "primary" },
                on: {
                  click: function($event) {
                    return _vm.search()
                  }
                }
              },
              [_vm._v("\n                ค้นหา\n            ")]
            ),
            _vm._v(" "),
            _c(
              "el-button",
              {
                staticClass: "btn-success ml-2",
                attrs: { type: "success" },
                on: {
                  click: function($event) {
                    return _vm.create()
                  }
                }
              },
              [_vm._v("\n                สร้าง\n            ")]
            )
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "my-2" }, [
        _c("div", [
          _c("span", { staticClass: "font-bold" }, [
            _vm._v("ปีบัญชีงบประมาณ :")
          ]),
          _vm._v(
            "\n            " +
              _vm._s(_vm.items.productGroupPlan.period_year_thai) +
              "\n        "
          )
        ]),
        _vm._v(" "),
        _c("div", [
          _c("span", { staticClass: "font-bold" }, [_vm._v("แผนผลิตภัณฑ์ :")]),
          _vm._v(
            "\n            " +
              _vm._s(_vm.items.productGroupPlan.plan_version_no) +
              "\n        "
          )
        ])
      ]),
      _vm._v(" "),
      _c(
        "el-card",
        {
          directives: [
            {
              name: "loading",
              rawName: "v-loading",
              value: _vm.loading,
              expression: "loading"
            }
          ],
          staticClass: "box-card my-2"
        },
        [
          _c(
            "div",
            {
              staticClass: "clearfix",
              attrs: { slot: "header" },
              slot: "header"
            },
            [
              _c(
                "el-select",
                {
                  attrs: { filterable: "", placeholder: "ศูนย์ต้นทุน" },
                  on: { change: _vm.findByCostCenter },
                  model: {
                    value: _vm.selectCostCenter,
                    callback: function($$v) {
                      _vm.selectCostCenter = $$v
                    },
                    expression: "selectCostCenter"
                  }
                },
                _vm._l(_vm.costCenters, function(item, index) {
                  return _c("el-option", {
                    key: index,
                    attrs: { label: item.name, value: item.cost_code }
                  })
                }),
                1
              ),
              _vm._v(" "),
              _c(
                "el-button",
                {
                  staticClass: "btn-info ml-2 pull-right",
                  attrs: { type: "primary" },
                  on: {
                    click: function($event) {
                      return _vm.submitUpdate()
                    }
                  }
                },
                [_vm._v("\n                บันทึกการแก้ไข\n            ")]
              )
            ],
            1
          ),
          _vm._v(" "),
          _c("div", { staticClass: "text item" }, [
            _c("div", { staticClass: "table-responsive px-4 pt-4" }, [
              _c("table", { staticClass: "table table-bordered tw-text-xs" }, [
                _c("thead", [
                  _c("tr", [
                    _c("th", [_vm._v("กลุ่มผลิตภัณฑ์")]),
                    _vm._v(" "),
                    _c(
                      "th",
                      {
                        staticClass: "text-center",
                        staticStyle: { width: "15%" }
                      },
                      [
                        _vm._v(
                          "\n                                อัตราส่วน\n                            "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "th",
                      {
                        staticClass: "text-center",
                        staticStyle: { width: "15%" }
                      },
                      [
                        _vm._v(
                          "\n                                ปริมาณ\n                            "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "th",
                      {
                        staticClass: "text-center",
                        staticStyle: { width: "15%" }
                      },
                      [
                        _vm._v(
                          "\n                                หน่วยนับ\n                            "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "th",
                      {
                        staticClass: "text-center",
                        staticStyle: { width: "10%" }
                      },
                      [
                        _vm._v(
                          "\n                                พื้นที่ทำงาน ตร.ซม.\n                            "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "th",
                      {
                        staticClass: "text-center",
                        staticStyle: { width: "10%" }
                      },
                      [
                        _vm._v(
                          "\n                                จำนวนรอบ\n                            "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "th",
                      {
                        staticClass: "text-center",
                        staticStyle: { width: "10%" }
                      },
                      [
                        _vm._v(
                          "\n                                ความกว้าง ซม.\n                            "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "th",
                      {
                        staticClass: "text-center",
                        staticStyle: { width: "10%" }
                      },
                      [
                        _vm._v(
                          "\n                                ความยาว ซม.\n                            "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "th",
                      {
                        staticClass: "text-center",
                        staticStyle: { width: "15%" }
                      },
                      [
                        _vm._v(
                          "\n                                รวมปริมาณผลผลิต\n                            "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c("th", { staticClass: "text-center" }, [_vm._v("#")])
                  ])
                ]),
                _vm._v(" "),
                _c(
                  "tbody",
                  [
                    _vm._l(_vm.items.productGroupItems.children, function(
                      children,
                      index
                    ) {
                      return [
                        _c(
                          "tr",
                          { key: index + "-1", attrs: { clsss: "tw-text-xs" } },
                          [
                            _c("td", [_vm._v(_vm._s(children.name))]),
                            _vm._v(" "),
                            _c("td", { staticClass: "text-right" }, [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value:
                                      _vm.items.productGroupItems.children[
                                        index
                                      ].ratio,
                                    expression:
                                      "\n                                            items.productGroupItems\n                                                .children[index].ratio\n                                        "
                                  }
                                ],
                                staticClass: "form-control text-right",
                                attrs: { type: "text" },
                                domProps: {
                                  value:
                                    _vm.items.productGroupItems.children[index]
                                      .ratio
                                },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      _vm.items.productGroupItems.children[
                                        index
                                      ],
                                      "ratio",
                                      $event.target.value
                                    )
                                  }
                                }
                              })
                            ]),
                            _vm._v(" "),
                            _c("td", [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value:
                                      _vm.items.productGroupItems.children[
                                        index
                                      ].quantity_prd,
                                    expression:
                                      "\n                                            items.productGroupItems\n                                                .children[index].quantity_prd\n                                        "
                                  }
                                ],
                                staticClass: "form-control text-right",
                                attrs: { type: "text" },
                                domProps: {
                                  value:
                                    _vm.items.productGroupItems.children[index]
                                      .quantity_prd
                                },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      _vm.items.productGroupItems.children[
                                        index
                                      ],
                                      "quantity_prd",
                                      $event.target.value
                                    )
                                  }
                                }
                              })
                            ]),
                            _vm._v(" "),
                            _c(
                              "td",
                              [
                                _c(
                                  "el-select",
                                  {
                                    attrs: {
                                      filterable: "",
                                      placeholder: "หน่วยนับ"
                                    },
                                    model: {
                                      value:
                                        _vm.items.productGroupItems.children[
                                          index
                                        ].uom_code_prd,
                                      callback: function($$v) {
                                        _vm.$set(
                                          _vm.items.productGroupItems.children[
                                            index
                                          ],
                                          "uom_code_prd",
                                          $$v
                                        )
                                      },
                                      expression:
                                        "items.productGroupItems.children[index].uom_code_prd"
                                    }
                                  },
                                  _vm._l(_vm.uom, function(item, index) {
                                    return _c("el-option", {
                                      key: index,
                                      attrs: {
                                        label: item.unit_of_measure,
                                        value: item.uom_code
                                      }
                                    })
                                  }),
                                  1
                                )
                              ],
                              1
                            ),
                            _vm._v(" "),
                            _c("td", { staticClass: "text-right" }, [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value:
                                      _vm.items.productGroupItems.children[
                                        index
                                      ].area,
                                    expression:
                                      "\n                                            items.productGroupItems\n                                                .children[index].area\n                                        "
                                  }
                                ],
                                staticClass: "form-control text-right",
                                attrs: { type: "text" },
                                domProps: {
                                  value:
                                    _vm.items.productGroupItems.children[index]
                                      .area
                                },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      _vm.items.productGroupItems.children[
                                        index
                                      ],
                                      "area",
                                      $event.target.value
                                    )
                                  }
                                }
                              })
                            ]),
                            _vm._v(" "),
                            _c("td", { staticClass: "text-right" }, [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value:
                                      _vm.items.productGroupItems.children[
                                        index
                                      ].around,
                                    expression:
                                      "\n                                            items.productGroupItems\n                                                .children[index].around\n                                        "
                                  }
                                ],
                                staticClass: "form-control text-right",
                                attrs: { type: "text" },
                                domProps: {
                                  value:
                                    _vm.items.productGroupItems.children[index]
                                      .around
                                },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      _vm.items.productGroupItems.children[
                                        index
                                      ],
                                      "around",
                                      $event.target.value
                                    )
                                  }
                                }
                              })
                            ]),
                            _vm._v(" "),
                            _c("td", { staticClass: "text-right" }, [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value:
                                      _vm.items.productGroupItems.children[
                                        index
                                      ].width,
                                    expression:
                                      "\n                                            items.productGroupItems\n                                                .children[index].width\n                                        "
                                  }
                                ],
                                staticClass: "form-control text-right",
                                attrs: { type: "text" },
                                domProps: {
                                  value:
                                    _vm.items.productGroupItems.children[index]
                                      .width
                                },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      _vm.items.productGroupItems.children[
                                        index
                                      ],
                                      "width",
                                      $event.target.value
                                    )
                                  }
                                }
                              })
                            ]),
                            _vm._v(" "),
                            _c("td", { staticClass: "text-right" }, [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value:
                                      _vm.items.productGroupItems.children[
                                        index
                                      ].length,
                                    expression:
                                      "\n                                            items.productGroupItems\n                                                .children[index].length\n                                        "
                                  }
                                ],
                                staticClass: "form-control text-right",
                                attrs: { type: "text" },
                                domProps: {
                                  value:
                                    _vm.items.productGroupItems.children[index]
                                      .length
                                },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      _vm.items.productGroupItems.children[
                                        index
                                      ],
                                      "length",
                                      $event.target.value
                                    )
                                  }
                                }
                              })
                            ]),
                            _vm._v(" "),
                            _c("td", { staticClass: "text-right" }, [
                              _c("div", { staticClass: "form-control" }, [
                                _vm._v(
                                  "\n                                        " +
                                    _vm._s(
                                      _vm.items.productGroupItems.children[
                                        index
                                      ].prd_productivity_qty
                                    ) +
                                    "\n                                        "
                                )
                              ])
                            ]),
                            _vm._v(" "),
                            _c(
                              "td",
                              { staticClass: "text-center" },
                              [
                                _c(
                                  "el-button",
                                  {
                                    staticClass: "btn-info ml-2",
                                    attrs: { size: "small", type: "primary" },
                                    on: {
                                      click: function($event) {
                                        return _vm.viewProduct(children.pg_code)
                                      }
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n                                        ดูผลิตภัณฑ์\n                                    "
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
                          "tr",
                          {
                            key: index + "-2",
                            class:
                              _vm.keyViewProduct == children.pg_code
                                ? ""
                                : "d-none",
                            attrs: { clsss: "tw-text-xs" }
                          },
                          [
                            _c("td", { attrs: { colspan: "7" } }, [
                              _c(
                                "table",
                                {
                                  staticClass: "table table-bordered tw-text-xs"
                                },
                                [
                                  _c("thead", [
                                    _c("tr", [
                                      _c("th", { staticClass: "text-center" }, [
                                        _vm._v(
                                          "\n                                                    ผลิตภัณฑ์\n                                                "
                                        )
                                      ]),
                                      _vm._v(" "),
                                      _c(
                                        "th",
                                        {
                                          staticClass: "text-center",
                                          attrs: { width: "200px;" }
                                        },
                                        [
                                          _vm._v(
                                            "\n                                                    ปริมาณผลผลิตตามแผน\n                                                "
                                          )
                                        ]
                                      )
                                    ])
                                  ]),
                                  _vm._v(" "),
                                  _c(
                                    "tbody",
                                    [
                                      _vm._l(children.children, function(
                                        subChildren,
                                        subChildrenIndex
                                      ) {
                                        return [
                                          _c(
                                            "tr",
                                            {
                                              key: subChildrenIndex,
                                              attrs: { clsss: "tw-text-xs" }
                                            },
                                            [
                                              _c("td", [
                                                _vm._v(
                                                  "\n                                                        " +
                                                    _vm._s(subChildren.name) +
                                                    "\n                                                    "
                                                )
                                              ]),
                                              _vm._v(" "),
                                              _c(
                                                "td",
                                                { staticClass: "text-right" },
                                                [
                                                  _c("input", {
                                                    staticClass:
                                                      "form-control text-right",
                                                    attrs: { type: "text" },
                                                    domProps: {
                                                      value: _vm._f(
                                                        "number2Digit"
                                                      )(subChildren.qty)
                                                    },
                                                    on: {
                                                      change: function(event) {
                                                        subChildren.qty = _vm.stripNonNumber(
                                                          event.target.value
                                                        )
                                                        if (
                                                          subChildren.qty < 0
                                                        ) {
                                                          subChildren.qty = 0
                                                        }
                                                        _vm.editForm(
                                                          children.pg_code,
                                                          subChildrenIndex,
                                                          subChildren
                                                        )
                                                      }
                                                    }
                                                  })
                                                ]
                                              )
                                            ]
                                          )
                                        ]
                                      })
                                    ],
                                    2
                                  )
                                ]
                              )
                            ])
                          ]
                        )
                      ]
                    }),
                    _vm._v(" "),
                    _vm.items.productGroupItems.children.length == 0
                      ? _c("tr", [
                          _c(
                            "td",
                            {
                              staticClass: "text-center",
                              attrs: { colspan: "10" }
                            },
                            [
                              _vm._v(
                                "\n                                ไม่พบข้อมูล\n                            "
                              )
                            ]
                          )
                        ])
                      : _vm._e()
                  ],
                  2
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