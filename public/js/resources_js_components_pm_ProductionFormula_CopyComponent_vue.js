(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pm_ProductionFormula_CopyComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/ProductionFormula/CopyComponent.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/ProductionFormula/CopyComponent.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['items', 'oprns', 'machineTypes', 'defaultValue', 'users', 'routings', 'wipSteps', 'user', 'ingredientSteps', 'formulaTypes', 'wipStepHeaders', 'periodYears'],
  data: function data() {
    return {
      //ต้นฉบับ
      default_inventory_item_id: this.defaultValue.inventory_item_id ? this.defaultValue.inventory_item_id : '',
      default_item_desc: '',
      default_folmula_type: this.defaultValue.folmula_type ? Number(this.defaultValue.folmula_type) : '',
      // default_folmula_type:      this.defaultValue.folmula_type  ? this.defaultValue.folmula_type      : '',
      default_qty: this.defaultValue.qty ? this.numberWithCommas(this.defaultValue.qty) : '',
      default_uom: this.defaultValue.uom ? this.defaultValue.uom : '',
      default_version: this.defaultValue.version ? this.defaultValue.version : '',
      default_wip_step: this.defaultValue.wip ? Number(this.defaultValue.wip) : '',
      default_machine: this.defaultValue.machine ? Number(this.defaultValue.machine) : '',
      default_period_year: this.defaultValue.period_year ? this.defaultValue.period_year : '',
      //คัดลอก
      inventory_item_id: this.defaultValue.inventory_item_id ? this.defaultValue.inventory_item_id : '',
      item_desc: '',
      folmula_type: this.defaultValue.folmula_type ? Number(this.defaultValue.folmula_type) : '',
      // folmula_type:      this.defaultValue.folmula_type      ? this.defaultValue.folmula_type      : '',
      qty: this.defaultValue.qty ? this.numberWithCommas(this.defaultValue.qty) : '',
      uom: this.defaultValue.uom ? this.defaultValue.uom : '',
      version: this.defaultValue.version ? this.defaultValue.version : '',
      wip_step: this.defaultValue.wip ? Number(this.defaultValue.wip) : '',
      machine: this.defaultValue.machine ? Number(this.defaultValue.machine) : '',
      period_year: '',
      organization_code: this.defaultValue.organization ? this.defaultValue.organization.organization_code : '',
      machineDisabled: true,
      // machineDisabled:   this.defaultValue.folmula_type == 'สูตรใช้จริง' ? false : true,
      loadingWipStep: this.defaultValue ? this.defaultValue.wip ? false : true : true,
      loadingMachine: this.defaultValue ? this.defaultValue.machine ? false : true : true,
      machineLists: [],
      loadingBudgetYear: true,
      wip_step_desc: this.defaultValue.wip_step_desc ? this.defaultValue.wip_step_desc : '',
      uom_desc: this.defaultValue.uom_desc ? this.defaultValue.uom_desc : '',
      // ----------------------------------------------------------------------------------------
      folmulaTypeOptions: [{
        value: 'สูตรใช้จริง',
        label: 'สูตรใช้จริง'
      }, {
        value: 'สูตรมาตรฐาน',
        label: 'สูตรมาตรฐาน'
      }, {
        value: 'สูตรทดลอง',
        label: 'สูตรทดลอง'
      }],
      disableInput: {
        wip_step: false,
        machine: false
      }
    };
  },
  watch: {
    folmula_type: function folmula_type(newValue) {
      this.disableInputFunc();
    }
  },
  mounted: function mounted() {
    var _this = this;

    if (this.default_inventory_item_id) {
      this.selectedData = this.items.find(function (i) {
        if (i.inventory_item_id == _this.default_inventory_item_id) {
          _this.default_item_desc = i.item_desc;
          _this.item_desc = i.item_desc;
        }
      });
    }

    setTimeout(function () {
      $(_this.$refs.inventory_item_id.$el).find('input').val($(_this.$refs.inventory_item_id.$el).find('input').val().split(' : ')[0]);
    }, 100); // if (this.defaultValue.wip) {
    //     this.selectedData = this.wipSteps.find( i => {
    //         if (i.oprn_id == this.defaultValue.wip) {
    //             this.default_wip_step  = i.oprn_class_desc;
    //             this.wip_step          = i.oprn_class_desc;
    //             // this.getUom();
    //         }
    //     });
    // }

    if (this.defaultValue.folmula_type) {
      this.selectedData = this.formulaTypes.find(function (data) {
        return data.lookup_code == _this.folmula_type;
      });

      if (this.selectedData.description == 'สูตรใช้จริง') {
        this.machineDisabled = false;
      }

      if (this.selectedData.description == 'สูตรมาตรฐาน') {
        this.loadingBudgetYear = false;
        this.period_year = this.defaultValue.creation_year;
      }
    }

    if (this.folmula_type == 1) {
      if (this.org_code == 'MG6' || this.org_code == 'MPG' || this.org_code == 'M05') {
        this.loadingWipStep = false;
      }
    }

    if (this.wip_step) {
      this.getMachineType();
    }

    this.getVersion();
  },
  methods: {
    numberWithCommas: function numberWithCommas(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
    handleItemChange: function handleItemChange() {
      var _this2 = this;

      setTimeout(function () {
        $(_this2.$refs.inventory_item_id.$el).find('input').val($(_this2.$refs.inventory_item_id.$el).find('input').val().split(' : ')[0]);
      }, 100);
    },
    getItemDesc: function getItemDesc() {
      var _this3 = this;

      if (this.inventory_item_id) {
        this.selectedData = this.items.find(function (i) {
          if (i.inventory_item_id == _this3.inventory_item_id) {
            _this3.item_desc = i.item_desc;
          }
        });
      } else {
        this.item_desc = '';
      }
    },
    getVersion: function getVersion() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this4.version = '', // console.log('xxxx');
                axios.get("/pm/ajax/get-version", {
                  params: {
                    inventory_item_id: _this4.inventory_item_id,
                    folmula_type: _this4.folmula_type,
                    wip_step: _this4.wip_step,
                    machine: _this4.machine,
                    // W. 11/07/22 -เพิ่มปีงบประมาณมาเช็ค version
                    period_year: _this4.period_year
                  }
                }).then(function (res) {
                  if (_this4.inventory_item_id || _this4.folmula_type || _this4.defaultValue.wip || _this4.machine) {
                    _this4.version = res.data;
                  } else {
                    _this4.version = '';
                  }
                })["catch"](function (err) {
                  console.log(err);
                });

              case 1:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getMachineType: function getMachineType(query) {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                if (!_this5.wip_step) {
                  _this5.machine = '';
                }

                _this5.selectedData = _this5.formulaTypes.find(function (data) {
                  return data.lookup_code == _this5.folmula_type;
                });

                if (_this5.selectedData.description == 'สูตรใช้จริง') {
                  axios.get("/pm/ajax/get-machine-type", {
                    params: {
                      wip_step: _this5.wip_step,
                      org_code: _this5.organization_code,
                      query: query
                    }
                  }).then(function (res) {
                    _this5.machineLists = res.data;
                    _this5.loadingMachine = false;
                  })["catch"](function (err) {
                    console.log(err);
                  });
                } else {
                  _this5.loadingMachine = true;
                  _this5.machine = '';
                }

              case 3:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    disableInputFunc: function disableInputFunc() {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                vm = _this6;

                if (vm.folmula_type == 1) {
                  // ใช้จริง
                  // vm.loadingWipStep = false;
                  vm.disableInput.wip_step = false;
                  vm.disableInput.machine = false;
                  vm.getWipStep();
                } else {
                  vm.disableInput.wip_step = true;
                  vm.disableInput.machine = true;
                  vm.wip_step = '';
                  vm.machine = '';
                }

              case 2:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    getWipStep: function getWipStep() {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                _this7.loadingWipStep = true; // if (this.folmula_type == 'สูตรใช้จริง') {

                if (_this7.folmula_type == 1) {
                  if (_this7.organization_code == 'MG6' || _this7.organization_code == 'MPG' || _this7.organization_code == 'M05') {
                    _this7.loadingWipStep = false;
                  }
                } else {
                  _this7.wip_step = '';
                }

                if (_this7.folmula_type) {
                  _this7.selectedData = _this7.formulaTypes.find(function (data) {
                    return data.lookup_code == _this7.folmula_type;
                  });

                  if (_this7.selectedData.description == 'สูตรมาตรฐาน') {
                    _this7.loadingBudgetYear = false;
                    _this7.period_year = _this7.defaultValue.creation_year;
                  } else {
                    _this7.loadingBudgetYear = true;
                    _this7.period_year = '';
                    _this7.budget_start_date = '';
                    _this7.budget_end_date = '';
                  }
                }

                _this7.getMachineType();

              case 4:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    checkInvoiceFlag: function checkInvoiceFlag() {
      var _this8 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                // axios.get("/pm/ajax/get-invoice-flag", {
                //     params: {
                //         inventory_item_id: this.inventory_item_id,
                //         folmula_type:      this.folmula_type,
                //         period_year:       this.period_year,
                //     }
                // })
                // .then(res => {
                //     if (res.data == 'Y') {
                //         this.period_year = '';
                //         swal('Warning', 'กรุณาเลือกปีงบประมาณใหม่ เนื่องจากปีงบประมาณนี้ กองบริหารต้นทุนนำไปใช้แล้ว', 'warning');
                //     }
                _this8.getVersion(); // })
                // .catch(err => {
                //     console.log(err)
                // });


              case 1:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/ProductionFormula/CopyComponent.vue?vue&type=style&index=0&lang=css&":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/ProductionFormula/CopyComponent.vue?vue&type=style&index=0&lang=css& ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, ".el-select-dropdown{\n  z-index: 9999 !important;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/ProductionFormula/CopyComponent.vue?vue&type=style&index=0&lang=css&":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/ProductionFormula/CopyComponent.vue?vue&type=style&index=0&lang=css& ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_CopyComponent_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./CopyComponent.vue?vue&type=style&index=0&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/ProductionFormula/CopyComponent.vue?vue&type=style&index=0&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_CopyComponent_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_CopyComponent_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/components/pm/ProductionFormula/CopyComponent.vue":
/*!************************************************************************!*\
  !*** ./resources/js/components/pm/ProductionFormula/CopyComponent.vue ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _CopyComponent_vue_vue_type_template_id_6423921f___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CopyComponent.vue?vue&type=template&id=6423921f& */ "./resources/js/components/pm/ProductionFormula/CopyComponent.vue?vue&type=template&id=6423921f&");
/* harmony import */ var _CopyComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CopyComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/ProductionFormula/CopyComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _CopyComponent_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./CopyComponent.vue?vue&type=style&index=0&lang=css& */ "./resources/js/components/pm/ProductionFormula/CopyComponent.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _CopyComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _CopyComponent_vue_vue_type_template_id_6423921f___WEBPACK_IMPORTED_MODULE_0__.render,
  _CopyComponent_vue_vue_type_template_id_6423921f___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/ProductionFormula/CopyComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/ProductionFormula/CopyComponent.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************!*\
  !*** ./resources/js/components/pm/ProductionFormula/CopyComponent.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CopyComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./CopyComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/ProductionFormula/CopyComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CopyComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/ProductionFormula/CopyComponent.vue?vue&type=style&index=0&lang=css&":
/*!*********************************************************************************************************!*\
  !*** ./resources/js/components/pm/ProductionFormula/CopyComponent.vue?vue&type=style&index=0&lang=css& ***!
  \*********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_CopyComponent_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./CopyComponent.vue?vue&type=style&index=0&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/ProductionFormula/CopyComponent.vue?vue&type=style&index=0&lang=css&");


/***/ }),

/***/ "./resources/js/components/pm/ProductionFormula/CopyComponent.vue?vue&type=template&id=6423921f&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/components/pm/ProductionFormula/CopyComponent.vue?vue&type=template&id=6423921f& ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CopyComponent_vue_vue_type_template_id_6423921f___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CopyComponent_vue_vue_type_template_id_6423921f___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CopyComponent_vue_vue_type_template_id_6423921f___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./CopyComponent.vue?vue&type=template&id=6423921f& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/ProductionFormula/CopyComponent.vue?vue&type=template&id=6423921f&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/ProductionFormula/CopyComponent.vue?vue&type=template&id=6423921f&":
/*!**********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/ProductionFormula/CopyComponent.vue?vue&type=template&id=6423921f& ***!
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
    _c("div", [
      _c("h5", [_vm._v("ต้นแบบ")]),
      _vm._v(" "),
      _c("div", { staticClass: "row" }, [
        _c("div", { staticClass: "col-md-1" }),
        _vm._v(" "),
        _c("div", { staticClass: "col-md-7" }, [
          _c("label", [_vm._v(" รหัสสินค้า ")]),
          _vm._v(" "),
          _c("div", { staticClass: "row" }, [
            _c(
              "div",
              { staticClass: "col-md-5" },
              [
                _c(
                  "el-select",
                  {
                    staticClass: "w-100",
                    attrs: {
                      filterable: "",
                      remote: "",
                      "reserve-keyword": "",
                      clearable: "",
                      disabled: "",
                      placeholder: ""
                    },
                    model: {
                      value: _vm.default_inventory_item_id,
                      callback: function($$v) {
                        _vm.default_inventory_item_id = $$v
                      },
                      expression: "default_inventory_item_id"
                    }
                  },
                  _vm._l(_vm.items, function(item) {
                    return _c("el-option", {
                      key: item.inventory_item_id,
                      attrs: {
                        label: item.item_number,
                        value: item.inventory_item_id
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
              "div",
              { staticClass: "col-md-7" },
              [
                _c("el-input", {
                  attrs: { disabled: "" },
                  model: {
                    value: _vm.default_item_desc,
                    callback: function($$v) {
                      _vm.default_item_desc = $$v
                    },
                    expression: "default_item_desc"
                  }
                })
              ],
              1
            )
          ])
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-3" },
          [
            _c("label", [_vm._v(" ประเภทสูตร ")]),
            _vm._v(" "),
            _c(
              "el-select",
              {
                staticClass: "w-100",
                attrs: {
                  filterable: "",
                  remote: "",
                  "reserve-keyword": "",
                  clearable: "",
                  disabled: "",
                  placeholder: ""
                },
                model: {
                  value: _vm.default_folmula_type,
                  callback: function($$v) {
                    _vm.default_folmula_type = $$v
                  },
                  expression: "default_folmula_type"
                }
              },
              _vm._l(_vm.formulaTypes, function(folmulaType) {
                return _c("el-option", {
                  key: folmulaType.lookup_code,
                  attrs: {
                    label: folmulaType.description,
                    value: folmulaType.lookup_code
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
      _c("div", { staticClass: "row mt-2" }, [
        _c("div", { staticClass: "col-md-1" }),
        _vm._v(" "),
        _c("div", { staticClass: "col-md-7" }, [
          _c("label", [_vm._v(" จำนวนผลผลิต ")]),
          _vm._v(" "),
          _c("div", { staticClass: "row" }, [
            _c(
              "div",
              { staticClass: "col-md-5" },
              [
                _c("el-input", {
                  attrs: { disabled: "" },
                  model: {
                    value: _vm.default_qty,
                    callback: function($$v) {
                      _vm.default_qty = $$v
                    },
                    expression: "default_qty"
                  }
                })
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "col-md-4" },
              [
                _c("el-input", {
                  attrs: { disabled: "" },
                  model: {
                    value: _vm.uom_desc,
                    callback: function($$v) {
                      _vm.uom_desc = $$v
                    },
                    expression: "uom_desc"
                  }
                })
              ],
              1
            )
          ])
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-3" },
          [
            _c("label", [_vm._v(" Version ")]),
            _vm._v(" "),
            _c("el-input", {
              attrs: { disabled: "" },
              model: {
                value: _vm.default_version,
                callback: function($$v) {
                  _vm.default_version = $$v
                },
                expression: "default_version"
              }
            })
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row mt-2" }, [
        _c("div", { staticClass: "col-md-1" }),
        _vm._v(" "),
        _c("div", { staticClass: "col-md-7" }, [
          _c("div", { staticClass: "row" }, [
            _c(
              "div",
              { staticClass: "col-md-5" },
              [
                _c("label", [_vm._v(" ขั้นตอนการทำงาน ")]),
                _vm._v(" "),
                _c("el-input", {
                  attrs: { disabled: "" },
                  model: {
                    value: _vm.wip_step_desc,
                    callback: function($$v) {
                      _vm.wip_step_desc = $$v
                    },
                    expression: "wip_step_desc"
                  }
                })
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "col-md-4" },
              [
                _c("label", [_vm._v(" ปีงบประมาณ ")]),
                _vm._v(" "),
                _c("input", {
                  attrs: {
                    type: "hidden",
                    name: "default_period_year",
                    autocomplete: "off"
                  },
                  domProps: { value: _vm.default_period_year }
                }),
                _vm._v(" "),
                _c(
                  "el-select",
                  {
                    staticClass: "w-100",
                    attrs: {
                      filterable: "",
                      remote: "",
                      "reserve-keyword": "",
                      clearable: "",
                      disabled: "",
                      placeholder: ""
                    },
                    model: {
                      value: _vm.default_period_year,
                      callback: function($$v) {
                        _vm.default_period_year = $$v
                      },
                      expression: "default_period_year"
                    }
                  },
                  _vm._l(_vm.periodYears, function(periodYear, key) {
                    return _c("el-option", {
                      key: key,
                      attrs: {
                        label: periodYear.year_thai,
                        value: periodYear.year_thai
                      }
                    })
                  }),
                  1
                )
              ],
              1
            )
          ])
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-3" },
          [
            _c("label", [_vm._v(" ประเภทเครื่องจักร ")]),
            _vm._v(" "),
            _c(
              "el-select",
              {
                staticClass: "w-100",
                attrs: {
                  disabled: _vm.disableInput.default_machine,
                  filterable: "",
                  remote: "",
                  "reserve-keyword": "",
                  clearable: "",
                  disabled: "",
                  placeholder: ""
                },
                model: {
                  value: _vm.default_machine,
                  callback: function($$v) {
                    _vm.default_machine = $$v
                  },
                  expression: "default_machine"
                }
              },
              _vm._l(_vm.machineTypes, function(machineType) {
                return _c("el-option", {
                  key: machineType.lookup_code,
                  attrs: {
                    label: machineType.description,
                    value: machineType.lookup_code
                  }
                })
              }),
              1
            )
          ],
          1
        )
      ])
    ]),
    _vm._v(" "),
    _c("hr"),
    _vm._v(" "),
    _c("div", [
      _c("h5", [_vm._v("คัดลอก")]),
      _vm._v(" "),
      _c("div", { staticClass: "row" }, [
        _c("div", { staticClass: "col-md-1" }),
        _vm._v(" "),
        _c("div", { staticClass: "col-md-7" }, [
          _c("label", [_vm._v(" รหัสสินค้า ")]),
          _vm._v(" "),
          _c("div", { staticClass: "row" }, [
            _c(
              "div",
              { staticClass: "col-md-5" },
              [
                _c("input", {
                  attrs: {
                    type: "hidden",
                    name: "inventory_item_id",
                    autocomplete: "off"
                  },
                  domProps: { value: _vm.inventory_item_id }
                }),
                _vm._v(" "),
                _c(
                  "el-select",
                  {
                    ref: "inventory_item_id",
                    staticClass: "w-100",
                    attrs: {
                      filterable: "",
                      remote: "",
                      "reserve-keyword": "",
                      clearable: "",
                      placeholder: ""
                    },
                    on: {
                      change: function($event) {
                        _vm.getItemDesc()
                        _vm.getVersion()
                        _vm.handleItemChange()
                      }
                    },
                    model: {
                      value: _vm.inventory_item_id,
                      callback: function($$v) {
                        _vm.inventory_item_id = $$v
                      },
                      expression: "inventory_item_id"
                    }
                  },
                  _vm._l(_vm.items, function(item) {
                    return _c("el-option", {
                      key: item.inventory_item_id,
                      attrs: {
                        label: item.item_number + " : " + item.item_desc,
                        value: item.inventory_item_id
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
              "div",
              { staticClass: "col-md-7" },
              [
                _c("el-input", {
                  attrs: { disabled: "" },
                  model: {
                    value: _vm.item_desc,
                    callback: function($$v) {
                      _vm.item_desc = $$v
                    },
                    expression: "item_desc"
                  }
                })
              ],
              1
            )
          ])
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-3" },
          [
            _c("label", [_vm._v(" ประเภทสูตร ")]),
            _vm._v(" "),
            _c("input", {
              attrs: {
                type: "hidden",
                name: "folmula_type",
                autocomplete: "off"
              },
              domProps: { value: _vm.folmula_type }
            }),
            _vm._v(" "),
            _c(
              "el-select",
              {
                staticClass: "w-100",
                attrs: {
                  filterable: "",
                  remote: "",
                  disabled:
                    _vm.defaultValue.folmula_type == 1 ||
                    this.organization_code == "MG6" ||
                    this.organization_code == "M05",
                  "reserve-keyword": "",
                  clearable: "",
                  placeholder: ""
                },
                on: {
                  change: function($event) {
                    _vm.getVersion()
                    _vm.getWipStep()
                  }
                },
                model: {
                  value: _vm.folmula_type,
                  callback: function($$v) {
                    _vm.folmula_type = $$v
                  },
                  expression: "folmula_type"
                }
              },
              _vm._l(_vm.formulaTypes, function(folmulaType) {
                return _c("el-option", {
                  key: folmulaType.lookup_code,
                  attrs: {
                    label: folmulaType.description,
                    value: folmulaType.lookup_code
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
      _c("div", { staticClass: "row mt-2" }, [
        _c("div", { staticClass: "col-md-1" }),
        _vm._v(" "),
        _c("div", { staticClass: "col-md-7" }, [
          _c("label", [_vm._v(" จำนวนผลผลิต ")]),
          _vm._v(" "),
          _c("div", { staticClass: "row" }, [
            _c(
              "div",
              { staticClass: "col-md-5" },
              [
                _c("el-input", {
                  attrs: { disabled: "" },
                  model: {
                    value: _vm.qty,
                    callback: function($$v) {
                      _vm.qty = $$v
                    },
                    expression: "qty"
                  }
                })
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "col-md-4" },
              [
                _c("el-input", {
                  attrs: { disabled: "" },
                  model: {
                    value: _vm.uom_desc,
                    callback: function($$v) {
                      _vm.uom_desc = $$v
                    },
                    expression: "uom_desc"
                  }
                })
              ],
              1
            )
          ])
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-3" },
          [
            _c("label", [_vm._v(" Version ")]),
            _vm._v(" "),
            _c("input", {
              attrs: { type: "hidden", name: "version", autocomplete: "off" },
              domProps: { value: _vm.version }
            }),
            _vm._v(" "),
            _c("el-input", {
              attrs: { disabled: "" },
              model: {
                value: _vm.version,
                callback: function($$v) {
                  _vm.version = $$v
                },
                expression: "version"
              }
            })
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row mt-2" }, [
        _c("div", { staticClass: "col-md-1" }),
        _vm._v(" "),
        _c("div", { staticClass: "col-md-7" }, [
          _c("div", { staticClass: "row" }, [
            _c(
              "div",
              { staticClass: "col-md-5" },
              [
                _c("label", [_vm._v(" ขั้นตอนการทำงาน ")]),
                _vm._v(" "),
                _c("input", {
                  attrs: {
                    type: "hidden",
                    name: "wip_step",
                    autocomplete: "off"
                  },
                  domProps: { value: _vm.wip_step }
                }),
                _vm._v(" "),
                _c("el-input", {
                  attrs: { disabled: "" },
                  model: {
                    value: _vm.wip_step_desc,
                    callback: function($$v) {
                      _vm.wip_step_desc = $$v
                    },
                    expression: "wip_step_desc"
                  }
                })
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "col-md-4" },
              [
                _c("label", [_vm._v(" ปีงบประมาณ ")]),
                _vm._v(" "),
                _c("input", {
                  attrs: {
                    type: "hidden",
                    name: "period_year",
                    autocomplete: "off"
                  },
                  domProps: { value: _vm.period_year }
                }),
                _vm._v(" "),
                _c(
                  "el-select",
                  {
                    staticClass: "w-100",
                    attrs: {
                      filterable: "",
                      remote: "",
                      "reserve-keyword": "",
                      clearable: "",
                      disabled: _vm.loadingBudgetYear,
                      placeholder: ""
                    },
                    on: {
                      change: function($event) {
                        return _vm.checkInvoiceFlag()
                      }
                    },
                    model: {
                      value: _vm.period_year,
                      callback: function($$v) {
                        _vm.period_year = $$v
                      },
                      expression: "period_year"
                    }
                  },
                  _vm._l(_vm.periodYears, function(periodYear, key) {
                    return _c("el-option", {
                      key: key,
                      attrs: {
                        label: periodYear.year_thai,
                        value: periodYear.year_thai
                      }
                    })
                  }),
                  1
                )
              ],
              1
            )
          ])
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-3" },
          [
            _c("input", {
              attrs: { type: "hidden", name: "machine", autocomplete: "off" },
              domProps: { value: _vm.machine }
            }),
            _vm._v(" "),
            _c("label", [_vm._v(" ประเภทเครื่องจักร ")]),
            _vm._v(" "),
            _c("input", {
              attrs: { type: "hidden", name: "machine", autocomplete: "off" },
              domProps: { value: _vm.machine }
            }),
            _vm._v(" "),
            _c(
              "el-select",
              {
                staticClass: "w-100",
                attrs: {
                  filterable: "",
                  remote: "",
                  "reserve-keyword": "",
                  clearable: "",
                  disabled:
                    _vm.loadingMachine ||
                    _vm.disableInput.machine ||
                    _vm.organization_code == "M06",
                  placeholder: ""
                },
                on: {
                  change: function($event) {
                    return _vm.getVersion()
                  }
                },
                model: {
                  value: _vm.machine,
                  callback: function($$v) {
                    _vm.machine = $$v
                  },
                  expression: "machine"
                }
              },
              _vm._l(_vm.machineLists, function(machineList) {
                return _c("el-option", {
                  key: machineList.lookup_code,
                  attrs: {
                    label: machineList.description,
                    value: machineList.lookup_code
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
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);