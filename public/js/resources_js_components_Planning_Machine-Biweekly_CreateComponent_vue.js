(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_Planning_Machine-Biweekly_CreateComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/CreateComponent.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/CreateComponent.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue-numeric */ "./node_modules/vue-numeric/dist/vue-numeric.min.js");
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(vue_numeric__WEBPACK_IMPORTED_MODULE_2__);


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['productTypes', 'budgetYears', 'defaultInput', 'searchInput', 'search', 'lines', 'workingHour'],
  components: {
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_2___default())
  },
  data: function data() {
    return {
      budget_year: this.defaultInput.current_year,
      month: '',
      bi_weekly: '',
      efficiency_machine: '',
      efficiency_product: this.defaultInput.efficiency_product,
      working_hour: this.defaultInput.working_hour,
      product_type: this.defaultInput.product_type,
      month_lists: [],
      bi_weekly_lists: [],
      loading: false,
      m_loading: false,
      b_loading: false,
      errors: {
        budget_year: false,
        month: false,
        bi_weekly: false,
        efficiency_product: false
      }
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
    biWeeklyLists: function biWeeklyLists() {
      return this.bi_weekly_lists;
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
        val.budget_year ? this.setError('budget_year') : this.resetError('budget_year');
        val.month ? this.setError('month') : this.resetError('month');
        val.bi_weekly ? this.setError('bi_weekly') : this.resetError('bi_weekly');
        val.efficiency_product ? this.setError('efficiency_product') : this.resetError('efficiency_product');
      },
      deep: true
    }
  },
  methods: {
    getMonth: function getMonth() {
      if (!this.search) {
        this.month = '';
        this.bi_weekly = '';
      }

      var curr_val = '';
      var curr_period = moment__WEBPACK_IMPORTED_MODULE_1___default()().format('MMM-YY'); // get current period num
      // this.searchInput.months.filter(item => {
      //     if (item.period_name == curr_period) {
      //         return curr_val = item.period_num;
      //     }
      // });

      this.month_lists = this.searchInput.months; // this.month_lists = this.searchInput.months.filter(item => {
      //     return item.thai_year == this.budget_year && Number(item.period_num) >= Number(curr_val);
      // });
      // this.month_lists = this.searchInput.months.filter(item => {
      //     return item.thai_year.indexOf(this.budget_year) > -1;
      // });
    },
    getBiWeeklySeq: function getBiWeeklySeq() {
      var _this = this;

      this.bi_weekly = ''; // this.bi_weekly_lists = this.searchInput.bi_weekly.filter(item => {
      //     return item.period_num == this.month && item.thai_year.indexOf(this.budget_year) > -1;
      // });

      this.bi_weekly_lists = this.searchInput.bi_weekly.filter(function (item) {
        return item.period_num == _this.month;
      });
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
      var _this2 = this;

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
                _this2.errors.budget_year = false;
                _this2.errors.month = false;
                _this2.errors.bi_weekly = false;
                _this2.errors.efficiency_machine = false;
                _this2.errors.efficiency_product = false; // this.errors.product_type = false;

                $(form).find("div[id='budget_year']").html("");
                $(form).find("div[id='el_explode_month']").html("");
                $(form).find("div[id='el_explode_bi_weekly']").html("");
                $(form).find("div[id='el_explode_efficiency_machine']").html("");
                $(form).find("div[id='el_explode_efficiency_product']").html(""); // $(form).find("div[id='el_explode_product_type']").html("");

                if (_this2.budget_year == '') {
                  _this2.errors.budget_year = true;
                  valid = false;
                  errorMsg = "กรุณาเลือกปีงบประมาณ";
                  $(form).find("div[id='el_explode_budget_year']").html(errorMsg);
                }

                if (_this2.month == '') {
                  _this2.errors.month = true;
                  valid = false;
                  errorMsg = "กรุณาเลือกเดือน";
                  $(form).find("div[id='el_explode_month']").html(errorMsg);
                }

                if (_this2.bi_weekly == '') {
                  _this2.errors.bi_weekly = true;
                  valid = false;
                  errorMsg = "กรุณาเลือกปักษ์";
                  $(form).find("div[id='el_explode_bi_weekly']").html(errorMsg);
                } // if (this.efficiency_machine == ''){
                //     this.errors.efficiency_machine = true;
                //     valid = false;
                //     errorMsg = "กรุณากรอกเปอร์เซ็นต์ประสิทธิภาพเครื่องจักร";
                //     $(form).find("div[id='el_explode_efficiency_machine']").html(errorMsg);
                // }


                if (_this2.efficiency_product == '') {
                  _this2.errors.efficiency_product = true;
                  valid = false;
                  errorMsg = "กรุณากรอกเปอร์เซ็นต์สั่งผลิต";
                  $(form).find("div[id='el_explode_efficiency_product']").html(errorMsg);
                }

                if (valid) {
                  _context.next = 20;
                  break;
                }

                return _context.abrupt("return");

              case 20:
                _this2.loading = true;
                _context.next = 23;
                return _this2.createMachineTransactions(inputs);

              case 23:
                res = _context.sent;

                if (res.status == 'S') {
                  swal({
                    title: 'สร้างประมาณการผลิตประจำปักษ์',
                    text: '<span style="font-size: 16px; text-align: left;"> ทำการสร้างข้อมูลประมาณการผลิตประจำปักษ์เรียบร้อยแล้ว </span>',
                    type: "success",
                    html: true
                  }); //redirect

                  window.setTimeout(function () {
                    window.location.href = "/planning/machine-biweekly?search[budget_year]=" + res.param['budget_year'] + "&search[month]=" + res.param['month'] + "&search[bi_weekly]=" + res.param['bi_weekly'] + "&search[product_type]=" + res.product_type;
                  }, 2000);
                } else {
                  swal({
                    title: 'มีข้อผิดพลาด',
                    text: '<span style="font-size: 16px; text-align: left;">' + res.msg + '</span>',
                    type: "warning",
                    html: true
                  });
                }

              case 25:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    createMachineTransactions: function createMachineTransactions(inputs) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var data;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                data = [];
                _context2.next = 3;
                return axios.post("/planning/machine-biweekly", inputs).then(function (res) {
                  data = res.data;
                })["catch"](function (err) {
                  var msg = err.response.data;
                  swal({
                    title: 'มีข้อผิดพลาด',
                    text: msg.message,
                    type: "error"
                  });
                }).then(function () {
                  _this3.loading = false;
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

/***/ "./resources/js/components/Planning/Machine-Biweekly/CreateComponent.vue":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Biweekly/CreateComponent.vue ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _CreateComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CreateComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Machine-Biweekly/CreateComponent.vue?vue&type=script&lang=js&");
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
component.options.__file = "resources/js/components/Planning/Machine-Biweekly/CreateComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Machine-Biweekly/CreateComponent.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Biweekly/CreateComponent.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./CreateComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/CreateComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ })

}]);