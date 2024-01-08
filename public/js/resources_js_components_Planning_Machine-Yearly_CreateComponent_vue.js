(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_Planning_Machine-Yearly_CreateComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/CreateComponent.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/CreateComponent.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-numeric */ "./node_modules/vue-numeric/dist/vue-numeric.min.js");
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vue_numeric__WEBPACK_IMPORTED_MODULE_1__);


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['productTypes', 'budgetYears', 'defaultInput', 'searchInput', 'search', 'workingHour'],
  components: {
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_1___default())
  },
  data: function data() {
    return {
      budget_year: this.defaultInput.current_year,
      month: '',
      efficiency_machine: '',
      efficiency_product: this.defaultInput.efficiency_product,
      product_type: '',
      month_lists: [],
      loading: false,
      m_loading: false,
      errors: {
        budget_year: false,
        // month: false,
        efficiency_product: false
      },
      working_hour: this.defaultInput.working_hour
    };
  },
  mounted: function mounted() {
    if (this.budget_year) {
      this.getMonth();
    }
  },
  computed: {
    monthLists: function monthLists() {
      return this.month_lists;
    },
    efficiencyMachine: function efficiencyMachine() {
      return this.efficiency_machine;
    },
    efficiencyProduct: function efficiencyProduct() {
      return this.efficiency_product;
    }
  },
  watch: {
    errors: {
      handler: function handler(val) {
        val.budget_year ? this.setError('budget_year') : this.resetError('budget_year'); // val.month? this.setError('month') : this.resetError('month');

        val.efficiency_product ? this.setError('efficiency_product') : this.resetError('efficiency_product');
      },
      deep: true
    }
  },
  methods: {
    getMonth: function getMonth() {
      if (!this.search) {
        this.month = '';
      } // this.month_lists = this.searchInput.months.filter(item => {
      //     return item.thai_year.indexOf(this.budget_year) > -1;
      // });
      // this.m_loading = true;
      // axios.post('/planning/ajax/get-month-machine', {
      //     year: this.budget_year
      // })
      // .then((response) => {
      //     this.month_lists = response.data;
      // })
      // .catch( error => {
      //     this.$notify.error({
      //         title: 'มีข้อผิดพลาด',
      //         message: error.message,
      //     });
      // })
      // .then( () => {
      //     this.m_loading = false;
      // })

    },
    checkInputNumber: function checkInputNumber(value) {
      var newValue = parseFloat(value.replace(/[^\d\.]/g, ""));

      if (isNaN(newValue)) {
        newValue = 0;
      }
    },
    setError: function setError(ref_name) {
      var ref = this.$refs[ref_name].$refs.reference ? this.$refs[ref_name].$refs.reference.$refs.input : this.$refs[ref_name].$refs.textarea ? this.$refs[ref_name].$refs.textarea : this.$refs[ref_name].$refs.input.$refs ? this.$refs[ref_name].$refs.input.$refs.input : this.$refs[ref_name].$refs.input;
      ref.style = "border: 1px solid red;";
    },
    resetError: function resetError(ref_name) {
      var ref = this.$refs[ref_name].$refs.reference ? this.$refs[ref_name].$refs.reference.$refs.input : this.$refs[ref_name].$refs.textarea ? this.$refs[ref_name].$refs.textarea : this.$refs[ref_name].$refs.input.$refs ? this.$refs[ref_name].$refs.input.$refs.input : this.$refs[ref_name].$refs.input;
      ref.style = "";
    },
    submit: function submit() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var form, inputs, valid, errorMsg, res;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                form = $('#machine-create-form');
                inputs = form.serialize();
                valid = true;
                errorMsg = '';
                _this.errors.budget_year = false; // this.errors.month = false;
                // this.errors.efficiency_machine = false;

                _this.errors.efficiency_product = false; // this.errors.product_type = false;

                $(form).find("div[id='el_explode_budget_year']").html(""); // $(form).find("div[id='el_explode_month']").html("");
                // $(form).find("div[id='el_explode_efficiency_machine']").html("");

                $(form).find("div[id='el_explode_efficiency_product']").html(""); // $(form).find("div[id='el_explode_product_type']").html("");

                if (_this.budget_year == '') {
                  _this.errors.budget_year = true;
                  valid = false;
                  errorMsg = "กรุณาเลือกปีงบประมาณ";
                  $(form).find("div[id='el_explode_budget_year']").html(errorMsg);
                } // if (this.month == ''){
                //     this.errors.month = true;
                //     valid = false;
                //     errorMsg = "กรุณาเลือกเดือน";
                //     $(form).find("div[id='el_explode_month']").html(errorMsg);
                // }
                // if (this.efficiency_machine == ''){
                //     this.errors.efficiency_machine = true;
                //     valid = false;
                //     errorMsg = "กรุณากรอกเปอร์เซ็นต์ประสิทธิภาพเครื่องจักร";
                //     $(form).find("div[id='el_explode_efficiency_machine']").html(errorMsg);
                // }


                if (_this.efficiency_product == '') {
                  _this.errors.efficiency_product = true;
                  valid = false;
                  errorMsg = "กรุณากรอกเปอร์เซ็นต์สั่งผลิต";
                  $(form).find("div[id='el_explode_efficiency_product']").html(errorMsg);
                }

                if (valid) {
                  _context.next = 12;
                  break;
                }

                return _context.abrupt("return");

              case 12:
                _this.loading = true;
                _context.next = 15;
                return _this.createMachineTransactions(inputs);

              case 15:
                res = _context.sent;

                if (res.status == 'S') {
                  _this.loading = false;
                  swal({
                    title: 'สร้างประมาณการผลิตประจำปี',
                    text: '<span style="font-size: 16px; text-align: left;"> ทำการสร้างข้อมูลประมาณการผลิตประจำปีเรียบร้อยแล้ว </span>',
                    type: "success",
                    html: true
                  }); //redirect

                  window.setTimeout(function () {
                    // window.location.href = `/planning/machine-yearly?search[budget_year]=`+res.param['budget_year']+`&search[product_type]=71`;
                    window.location.href = res.redirect_show_page;
                  }, 2000);
                } else {
                  // swal({
                  //     title: 'มีข้อผิดพลาด',
                  //     text: '<span style="font-size: 16px; text-align: left;">'+res.msg+'</span>',
                  //     type: "warning",
                  //     html: true
                  // });
                  swal({
                    title: 'สร้างประมาณการผลิตประจำปี',
                    text: '<span style="font-size: 16px; text-align: left;"> ทำการสร้างข้อมูลประมาณการผลิตประจำปีเรียบร้อยแล้ว </span>',
                    type: "success",
                    html: true
                  });
                  window.setTimeout(function () {
                    window.location.reload();
                  }, 2000);
                }

              case 17:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    createMachineTransactions: function createMachineTransactions(inputs) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var data;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                data = [];
                _context2.next = 3;
                return axios.post("/planning/machine-yearly", inputs).then(function (res) {
                  data = res.data;
                })["catch"](function (err) {
                  var msg = err.response.data; // swal({
                  //     title: 'มีข้อผิดพลาด',
                  //     text: msg.message,
                  //     type: "error",
                  // });

                  swal({
                    title: 'สร้างประมาณการผลิตประจำปี',
                    text: '<span style="font-size: 16px; text-align: left;"> ทำการสร้างข้อมูลประมาณการผลิตประจำปีเรียบร้อยแล้ว </span>',
                    type: "success",
                    html: true
                  });
                  window.setTimeout(function () {
                    window.location.reload();
                  }, 2000);
                }).then(function () {
                  _this2.loading = false;
                });

              case 3:
                return _context2.abrupt("return", data);

              case 4:
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

/***/ "./resources/js/components/Planning/Machine-Yearly/CreateComponent.vue":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Yearly/CreateComponent.vue ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _CreateComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CreateComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Machine-Yearly/CreateComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");
var render, staticRenderFns
;



/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__.default)(
  _CreateComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default,
  render,
  staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Machine-Yearly/CreateComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Machine-Yearly/CreateComponent.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Yearly/CreateComponent.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./CreateComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/CreateComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ })

}]);