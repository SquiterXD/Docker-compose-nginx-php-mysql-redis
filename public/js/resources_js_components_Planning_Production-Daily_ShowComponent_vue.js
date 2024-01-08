(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_Planning_Production-Daily_ShowComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/ModalSearch.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/ModalSearch.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************************************************/
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

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ['budgetYears', 'months', 'biWeekly', 'search', 'productTypes', "btnTrans", "url", 'defaultInput'],
  data: function data() {
    var _ref;

    return _ref = {
      budget_year: this.defaultInput.current_year,
      month: '',
      bi_weekly: '',
      times: ''
    }, _defineProperty(_ref, "month", ''), _defineProperty(_ref, "loading", false), _defineProperty(_ref, "b_loading", false), _defineProperty(_ref, "errors", {
      budget_year: false,
      bi_weekly: false
    }), _defineProperty(_ref, "monthLists", []), _defineProperty(_ref, "biWeeklyLists", []), _defineProperty(_ref, "html", ''), _ref;
  },
  mounted: function mounted() {
    if (this.budget_year) {
      // this.getBiWeekly();
      this.getMonth();
    }
  },
  computed: {},
  watch: {
    errors: {
      handler: function handler(val) {
        val.budget_year ? this.setError('budget_year') : this.resetError('budget_year');
        val.month ? this.setError('month') : this.resetError('month');
        val.bi_weekly ? this.setError('bi_weekly') : this.resetError('bi_weekly');
      },
      deep: true
    }
  },
  methods: {
    openModal: function openModal() {
      $('#modal_search').modal('show');
    },
    searchForm: function searchForm() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var vm, form, valid, errorMsg;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                vm = _this;
                form = $('#search-form');
                valid = true;
                errorMsg = '';
                vm.errors.budget_year = false;
                vm.errors.bi_weekly = false;
                $(form).find("div[id='el_explode_budget_year']").html("");
                $(form).find("div[id='el_explode_month']").html("");
                $(form).find("div[id='el_explode_bi_weekly']").html("");

                if (vm.budget_year == '') {
                  vm.errors.budget_year = true;
                  valid = false;
                  errorMsg = "กรุณาเลือกปีงบประมาณ";
                  $(form).find("div[id='el_explode_budget_year']").html(errorMsg);
                }

                if (_this.month == '') {
                  _this.errors.month = true;
                  valid = false;
                  errorMsg = "กรุณาเลือกเดือน";
                  $(form).find("div[id='el_explode_month']").html(errorMsg);
                }

                if (vm.bi_weekly == '') {
                  vm.errors.bi_weekly = true;
                  valid = false;
                  errorMsg = "กรุณาเลือกปักษ์";
                  $(form).find("div[id='el_explode_bi_weekly']").html(errorMsg);
                }

                if (valid) {
                  _context.next = 14;
                  break;
                }

                return _context.abrupt("return");

              case 14:
                // vm.loading = true;
                vm.html = '\ <div class="m-t-lg m-b-lg">\
                            <div class="text-center sk-spinner sk-spinner-wave">\
                                <div class="sk-rect1"></div>\
                                <div class="sk-rect2"></div>\
                                <div class="sk-rect3"></div>\
                                <div class="sk-rect4"></div>\
                                <div class="sk-rect5"></div>\
                            </div>\
                        </div>';
                _context.next = 17;
                return axios.get(vm.url.ajax_production_daily_search, {
                  params: {
                    search: {
                      budget_year: vm.budget_year,
                      month: vm.month,
                      bi_weekly: vm.bi_weekly
                    }
                  }
                }).then(function (res) {
                  vm.html = '';
                  vm.html = res.data.data.html;
                })["catch"](function (err) {
                  vm.html = '';
                  var data = err.response.data;
                  alert(data.message);
                }).then(function () {// vm.html = '';
                  // vm.loading = false;
                });

              case 17:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getMonth: function getMonth() {
      this.month = '';
      this.bi_weekly = ''; // this.monthLists = this.months.filter(item => {
      //     return item.thai_year.indexOf(this.budget_year) > -1;
      // });

      this.monthLists = this.months;
    },
    getBiWeekly: function getBiWeekly() {
      var _this2 = this;

      if (!this.search) {
        this.bi_weekly = '';
      } // this.biWeeklyLists = this.biWeekly.filter(item => {
      //     return item.period_num == this.month && item.thai_year.indexOf(this.budget_year) > -1;
      // });


      this.biWeeklyLists = this.biWeekly.filter(function (item) {
        return item.period_num == _this2.month;
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
    errorRef: function errorRef(res) {
      var vm = this;
      vm.errors.budget_year = res.err.budget_year;
      vm.errors.month = res.err.month;
      vm.errors.bi_weekly = res.err.bi_weekly;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/ShowComponent.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/ShowComponent.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _ModalSearch_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalSearch.vue */ "./resources/js/components/Planning/Production-Daily/ModalSearch.vue");
/* harmony import */ var _components_HeaderDetail_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./components/HeaderDetail.vue */ "./resources/js/components/Planning/Production-Daily/components/HeaderDetail.vue");
/* harmony import */ var _components_OMSalesForecast_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./components/OMSalesForecast.vue */ "./resources/js/components/Planning/Production-Daily/components/OMSalesForecast.vue");
/* harmony import */ var _components_PlanDaily_vue__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./components/PlanDaily.vue */ "./resources/js/components/Planning/Production-Daily/components/PlanDaily.vue");
/* harmony import */ var _components_ItemPlan_vue__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./components/ItemPlan.vue */ "./resources/js/components/Planning/Production-Daily/components/ItemPlan.vue");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_6__);


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






/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    ModalSearch: _ModalSearch_vue__WEBPACK_IMPORTED_MODULE_1__.default,
    HeaderDetail: _components_HeaderDetail_vue__WEBPACK_IMPORTED_MODULE_2__.default,
    OMSalesForecast: _components_OMSalesForecast_vue__WEBPACK_IMPORTED_MODULE_3__.default,
    PlanDaily: _components_PlanDaily_vue__WEBPACK_IMPORTED_MODULE_4__.default,
    ItemPlan: _components_ItemPlan_vue__WEBPACK_IMPORTED_MODULE_5__.default
  },
  props: ["machineBiweekly", "modalControlInput", "modalSearchInput", "biweeklyColorCode", "productTypes", "pDefaultInput", "machines", "productDailyPlan", "pDateFormat", "url", "btnTrans", "search", "biWeeklyDetails", "searchFlag", "versions"],
  data: function data() {
    return {
      loading: {
        approveProcess: false,
        searchProcess: false
      },
      defaultInput: this.pDefaultInput != undefined && this.pDefaultInput != '' ? this.pDefaultInput : null,
      canApprove: false,
      dailyPlan: this.productDailyPlan,
      omSalesForecasts: '',
      itemProductionMain: [],
      urlArr: this.url,
      // Search
      budgetYears: this.modalSearchInput.budget_years,
      months: this.modalSearchInput.months,
      biWeeklies: this.modalSearchInput.bi_weekly,
      // Search input
      budgetYear: Object.values(this.search).length != 0 ? this.search.budget_year : this.pDefaultInput.current_year,
      month: this.search ? String(this.search.month) : '',
      biWeekly: this.search ? String(this.search.biweekly) : '',
      productType: Object.values(this.search).length != 0 ? this.search.product_type : this.pDefaultInput.product_type,
      errors: {
        budget_year: false,
        month: false,
        bi_weekly: false
      },
      monthLists: [],
      biWeeklyLists: [],
      biWeeklyDetail: '',
      showFlag: true,
      setBudgetYear: Object.values(this.search).length != 0 ? this.search.budget_year : this.pDefaultInput.current_year,
      setMonth: this.search ? String(this.search.month) : '',
      setBiWeekly: this.search ? String(this.search.biweekly) : '',
      setProductType: Object.values(this.search).length != 0 ? this.search.product_type : this.pDefaultInput.product_type,
      creator: this.productDailyPlan && this.productDailyPlan.updated_by ? this.productDailyPlan.updated_by.name : this.productDailyPlan && this.productDailyPlan.created_by ? this.productDailyPlan.created_by.name : null,
      isControlDisable: false,
      isCurrBiweekly: false,
      // New Requirement : แจ้งเตือน to text
      messageCheckWKHHtml: '',
      messageCheckMachineHtml: '',
      refreshOMSalesForecast: false,
      canViewProduction: false
    };
  },
  mounted: function mounted() {
    if (this.dailyPlan != undefined && this.dailyPlan != '') {
      this.canApprove = this.dailyPlan.can.approve;
    }

    if (this.budgetYear) {
      this.getMonth();
    }

    if (this.month) {
      this.getBiWeekly();
    }

    this.getBiWeeklyDetail();
    this.getControlDisable();
  },
  watch: {
    errors: {
      handler: function handler(val) {
        val.budget_year ? this.setError('budget_year') : this.resetError('budget_year');
        val.month ? this.setError('month') : this.resetError('month');
        val.bi_weekly ? this.setError('bi_weekly') : this.resetError('bi_weekly');
      },
      deep: true
    },
    productType: function () {
      var _productType = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee(value, oldValue) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                this.omSalesForecasts = '';

              case 1:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this);
      }));

      function productType(_x, _x2) {
        return _productType.apply(this, arguments);
      }

      return productType;
    }()
  },
  methods: {
    checkApprove: function checkApprove() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                vm = _this;

                if (vm.canApprove) {
                  _context3.next = 3;
                  break;
                }

                return _context3.abrupt("return");

              case 3:
                vm.loading.approveProcess = true;
                _context3.next = 6;
                return axios.get(vm.urlArr.ajax_check_approve).then(function (res) {
                  var valid = true;

                  if (res.data.data.status == 'S') {
                    swal({
                      html: true,
                      title: 'อนุมัติประมาณการผลิตรายวัน',
                      text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการอนุมัติประมาณการผลิตรายวัน ? </span></h2>',
                      showCancelButton: true,
                      confirmButtonText: vm.btnTrans.ok.text,
                      cancelButtonText: vm.btnTrans.cancel.text,
                      confirmButtonClass: vm.btnTrans.ok["class"] + ' btn-lg tw-w-25',
                      cancelButtonClass: vm.btnTrans.cancel["class"] + ' btn-lg tw-w-25',
                      closeOnConfirm: false,
                      closeOnCancel: true,
                      showLoaderOnConfirm: true
                    }, /*#__PURE__*/function () {
                      var _ref = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2(isConfirm) {
                        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
                          while (1) {
                            switch (_context2.prev = _context2.next) {
                              case 0:
                                if (isConfirm) {
                                  vm.approve();
                                }

                              case 1:
                              case "end":
                                return _context2.stop();
                            }
                          }
                        }, _callee2);
                      }));

                      return function (_x3) {
                        return _ref.apply(this, arguments);
                      };
                    }());
                  } else {
                    valid = false;
                    swal({
                      title: 'มีข้อผิดพลาด',
                      text: '<span style="font-size: 16px; text-align: left;">' + res.data.data.msg + '</span>',
                      type: "warning",
                      html: true
                    });

                    if (!valid) {
                      return;
                    }
                  }
                })["catch"](function (err) {
                  var data = err.response.data;
                  alert(data.message);
                }).then(function () {
                  vm.loading.approveProcess = false;
                });

              case 6:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    approve: function approve() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                vm = _this2;
                _context4.next = 3;
                return axios.patch(vm.urlArr.ajax_approve).then(function (res) {
                  var valid = true;

                  if (res.data.data.status == 'S') {
                    vm.dailyPlan = res.data.data.dailyPlan;
                    vm.canApprove = vm.dailyPlan.can.approve;
                    swal({
                      title: 'อนุมัติประมาณการผลิตรายวัน',
                      text: '<span style="font-size: 16px; text-align: left;"> อนุมัติประมาณการผลิตรายวันเรียบร้อย </span>',
                      type: "success",
                      html: true
                    });
                  } else {
                    valid = false;
                    swal({
                      title: 'มีข้อผิดพลาด',
                      text: '<span style="font-size: 16px; text-align: left;">' + res.data.data.msg + '</span>',
                      type: "warning",
                      html: true
                    });

                    if (!valid) {
                      return;
                    }
                  }
                })["catch"](function (err) {
                  // console.log(err);
                  swal({
                    title: 'มีข้อผิดพลาด',
                    text: '<span style="font-size: 16px; text-align: left;">' + err + '</span>',
                    type: "warning",
                    html: true
                  });
                }).then(function () {
                  vm.loading.approveProcess = false;
                });

              case 3:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    // Un-Approve
    checkUnapprove: function checkUnapprove() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                vm = _this3;

                if (!vm.canApprove) {
                  _context6.next = 3;
                  break;
                }

                return _context6.abrupt("return");

              case 3:
                vm.loading.approveProcess = true;
                _context6.next = 6;
                return axios.get(vm.urlArr.ajax_check_unapprove).then(function (res) {
                  var valid = true;

                  if (res.data.data.status == 'S') {
                    swal({
                      html: true,
                      title: 'ยกเลิกอนุมัติประมาณการผลิตรายวัน',
                      text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการยกเลิกอนุมัติประมาณการผลิตรายวัน ? </span></h2>',
                      showCancelButton: true,
                      confirmButtonText: vm.btnTrans.ok.text,
                      cancelButtonText: vm.btnTrans.cancel.text,
                      confirmButtonClass: vm.btnTrans.ok["class"] + ' btn-lg tw-w-25',
                      cancelButtonClass: vm.btnTrans.cancel["class"] + ' btn-lg tw-w-25',
                      closeOnConfirm: false,
                      closeOnCancel: true,
                      showLoaderOnConfirm: true
                    }, /*#__PURE__*/function () {
                      var _ref2 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5(isConfirm) {
                        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
                          while (1) {
                            switch (_context5.prev = _context5.next) {
                              case 0:
                                if (isConfirm) {
                                  vm.unapprove();
                                }

                              case 1:
                              case "end":
                                return _context5.stop();
                            }
                          }
                        }, _callee5);
                      }));

                      return function (_x4) {
                        return _ref2.apply(this, arguments);
                      };
                    }());
                  } else {
                    valid = false;
                    swal({
                      title: 'มีข้อผิดพลาด',
                      text: '<span style="font-size: 16px; text-align: left;">' + res.data.data.msg + '</span>',
                      type: "warning",
                      html: true
                    });

                    if (!valid) {
                      return;
                    }
                  }
                })["catch"](function (err) {
                  var data = err.response.data;
                  alert(data.message);
                }).then(function () {
                  vm.loading.approveProcess = false;
                });

              case 6:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      }))();
    },
    unapprove: function unapprove() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee7() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                vm = _this4;
                _context7.next = 3;
                return axios.patch(vm.urlArr.ajax_unapprove).then(function (res) {
                  var valid = true;

                  if (res.data.data.status == 'S') {
                    swal({
                      title: 'ยกเลิกอนุมัติประมาณการผลิตรายวัน',
                      text: '<span style="font-size: 16px; text-align: left;"> ยกเลิกอนุมัติประมาณการผลิตรายวันเรียบร้อย </span>',
                      type: "success",
                      html: true
                    });
                    vm.dailyPlan = res.data.data.dailyPlan;
                    vm.canApprove = vm.dailyPlan.can.approve;
                  } else {
                    valid = false;
                    swal({
                      title: 'มีข้อผิดพลาด',
                      text: '<span style="font-size: 16px; text-align: left;">' + res.data.data.msg + '</span>',
                      type: "warning",
                      html: true
                    });

                    if (!valid) {
                      return;
                    }
                  }
                })["catch"](function (err) {
                  swal({
                    title: 'มีข้อผิดพลาด',
                    text: '<span style="font-size: 16px; text-align: left;">' + err + '</span>',
                    type: "warning",
                    html: true
                  });
                }).then(function () {
                  vm.loading.approveProcess = false;
                });

              case 3:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7);
      }))();
    },
    // get plan daily
    getProductPlanDaily: function getProductPlanDaily() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee8() {
        var vm, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee8$(_context8) {
          while (1) {
            switch (_context8.prev = _context8.next) {
              case 0:
                vm = _this5;
                params = {
                  product_type: vm.productType
                };
                _context8.next = 4;
                return axios.get(vm.urlArr.production_daily_show, {
                  params: params
                }).then(function (res) {
                  vm.dailyPlan = res.data.productDailyPlan;
                  vm.urlArr = res.data.url;

                  if (_this5.dailyPlan != undefined && _this5.dailyPlan != '') {
                    _this5.canApprove = _this5.dailyPlan.can.approve;
                  } else {
                    _this5.canApprove = false;
                  }
                })["catch"](function (err) {
                  console.log('error');
                  var data = err.response.data;
                  swal({
                    title: 'มีข้อผิดพลาด',
                    text: '<span style="font-size: 16px; text-align: left;">' + data.message + '</span>',
                    type: "error",
                    html: true
                  });
                }).then(function () {
                  vm.loading.approveProcess = false;
                });

              case 4:
              case "end":
                return _context8.stop();
            }
          }
        }, _callee8);
      }))();
    },
    omSalesForecastData: function omSalesForecastData(summary, items, flag) {
      this.omSalesForecasts = summary;
      this.itemProductionMain = items;
      this.refreshOMSalesForecast = flag;
    },
    submit: function submit() {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee9() {
        var vm, form, valid, errorMsg;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee9$(_context9) {
          while (1) {
            switch (_context9.prev = _context9.next) {
              case 0:
                vm = _this6;
                form = $('#search-form');
                valid = true;
                errorMsg = '';
                vm.errors.budget_year = false;
                vm.errors.month = false;
                vm.errors.bi_weekly = false;
                $(form).find("div[id='el_explode_budget_year']").html("");
                $(form).find("div[id='el_explode_month']").html("");
                $(form).find("div[id='el_explode_bi_weekly']").html("");

                if (vm.budgetYear == '') {
                  vm.errors.budget_year = true;
                  valid = false;
                  errorMsg = "กรุณาเลือกปีงบประมาณ";
                  $(form).find("div[id='el_explode_budget_year']").html(errorMsg);
                }

                if (_this6.month == '') {
                  _this6.errors.month = true;
                  valid = false;
                  errorMsg = "กรุณาเลือกเดือน";
                  $(form).find("div[id='el_explode_month']").html(errorMsg);
                }

                if (vm.biWeekly == '') {
                  vm.errors.bi_weekly = true;
                  valid = false;
                  errorMsg = "กรุณาเลือกปักษ์";
                  $(form).find("div[id='el_explode_bi_weekly']").html(errorMsg);
                }

                if (valid) {
                  _context9.next = 15;
                  break;
                }

                return _context9.abrupt("return");

              case 15:
                vm.loading.searchProcess = true;
                form.submit();

              case 17:
              case "end":
                return _context9.stop();
            }
          }
        }, _callee9);
      }))();
    },
    getMonth: function getMonth() {
      if (this.search) {
        if (this.search['budget_year'] != this.budgetYear) {
          this.month = '';
          this.biWeekly = '';
          this.biWeeklyDetail = '';
        }
      } else {
        this.month = '';
        this.biWeekly = '';
        this.biWeeklyDetail = '';
      }

      this.monthLists = this.months;
      this.checkSearchCondition(); // Check show data when change search
      // this.showFlag = true;
      // if (this.setProductType != this.product_type || this.setBudgetYear != this.budgetYear) {
      //     this.showFlag = false;
      // }
    },
    getBiWeekly: function getBiWeekly() {
      var _this7 = this;

      if (this.search) {
        if (this.search['month'] != this.month) {
          this.biWeekly = '';
          this.biWeeklyDetail = '';
        }
      } else {
        this.biWeekly = '';
        this.biWeeklyDetail = '';
      }

      this.biWeeklyLists = this.biWeeklies.filter(function (item) {
        return item.period_num == _this7.month;
      });
      this.checkSearchCondition(); // Check show data when change search
      // if (this.setMonth != this.month) {
      //     this.showFlag = false;
      // }else if(this.setBudgetYear == this.budgetYear && this.setMonth == this.month && this.biWeekly != ''){
      //     this.showFlag = true;
      // }
    },
    getBiWeeklyDetail: function getBiWeeklyDetail() {
      var vm = this;

      if (vm.biWeekly == '' || vm.biWeekly == null) {
        vm.biWeeklyDetail = '';
      }

      vm.biWeeklyDetails.filter(function (item) {
        if (item.thai_year == vm.budgetYear && item.period_num == vm.month && item.biweekly == vm.biWeekly) {
          return vm.biWeeklyDetail = item.thai_combine_date;
        }
      });
      this.checkSearchCondition(); // Check show data when change search
      // vm.showFlag = true;
      // if (vm.setBiWeekly != vm.biWeekly || (vm.setBiWeekly == vm.biWeekly && vm.setProductType != vm.productType)) {
      //     vm.showFlag = false;
      // }
    },
    changeProductType: function changeProductType() {
      this.checkSearchCondition();
    },
    setError: function setError(ref_name) {
      var ref = this.$refs[ref_name].$refs.reference ? this.$refs[ref_name].$refs.reference.$refs.input : this.$refs[ref_name].$refs.textarea ? this.$refs[ref_name].$refs.textarea : this.$refs[ref_name].$refs.input.$refs ? this.$refs[ref_name].$refs.input.$refs.input : this.$refs[ref_name].$refs.input;
      ref.style = "border: 1px solid red;";
    },
    resetError: function resetError(ref_name) {
      var ref = this.$refs[ref_name].$refs.reference ? this.$refs[ref_name].$refs.reference.$refs.input : this.$refs[ref_name].$refs.textarea ? this.$refs[ref_name].$refs.textarea : this.$refs[ref_name].$refs.input.$refs ? this.$refs[ref_name].$refs.input.$refs.input : this.$refs[ref_name].$refs.input;
      ref.style = "";
    },
    checkSearchCondition: function checkSearchCondition() {
      // Check show data when change search
      var vm = this;
      vm.showFlag = true;

      if (vm.dailyPlan) {
        if (vm.setBudgetYear != vm.budgetYear || vm.setMonth != vm.month || vm.setBiWeekly != vm.biWeekly) {
          vm.showFlag = false;
        } else if (vm.setBudgetYear == vm.budgetYear && vm.month == '' && vm.biWeekly == '') {
          vm.showFlag = false;
        } else if (vm.setBudgetYear == vm.budgetYear && vm.setMonth == vm.month && (vm.biWeekly == '' || vm.setBiWeekly != vm.biWeekly)) {
          vm.showFlag = false;
        } else if (vm.setBudgetYear == vm.budgetYear && vm.setMonth == vm.month && vm.setBiWeekly == vm.biWeekly && vm.setProductType != vm.productType) {
          vm.showFlag = false;
        }
      }
    },
    getControlDisable: function getControlDisable() {
      var vm = this;
      var date_from = '';
      var date_to = '';
      var curr_date = moment__WEBPACK_IMPORTED_MODULE_6___default()().format('YYYY-MM-DD');
      vm.modalControlInput.bi_weekly.filter(function (item) {
        if (item.biweekly == vm.biWeekly && item.period_num == vm.month) {
          date_from = moment__WEBPACK_IMPORTED_MODULE_6___default()(item.start_date).format('YYYY-MM-DD');
          date_to = moment__WEBPACK_IMPORTED_MODULE_6___default()(item.end_date).format('YYYY-MM-DD');
        }
      }); //check disable process
      // vm.isControlDisable = false;

      if (curr_date > date_from && curr_date > date_to) {
        vm.isControlDisable = true;
      } // check current biweekly and future biweekly


      if (curr_date >= date_from && curr_date <= date_to || curr_date <= date_from && curr_date <= date_to) {
        vm.isCurrBiweekly = true;
      } // check current biweekly and future biweekly


      if (curr_date >= date_from && curr_date <= date_to || curr_date > date_from && curr_date > date_to) {
        vm.canViewProduction = true;
      } // check data change PM/Machine


      if (!vm.isControlDisable) {
        vm.checkMachineP03P07();
        vm.checkWorkingHourP03P07();
      }
    },
    checkMachineP03P07: function checkMachineP03P07() {
      var vm = this;

      if (vm.machines.length != vm.modalControlInput.machines.length) {
        vm.messageCheckMachineHtml = '<i class="fa fa-exclamation-circle"></i> เนื่องจากเครื่องจักรประมาณกำลังการผลิตประจำปักษ์ และ เครื่องจักรประมาณการผลิตรายวันไม่เท่ากัน กรุณาทำการอัพเดตเครื่องจักรประมาณกำลังการผลิตประจำปักษ์ก่อน';
        vm.isControlDisable = true;
      }
    },
    checkWorkingHourP03P07: function checkWorkingHourP03P07() {
      var _this8 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee10() {
        var vm, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee10$(_context10) {
          while (1) {
            switch (_context10.prev = _context10.next) {
              case 0:
                //checkEfficientcyP03P07
                vm = _this8;
                params = {
                  product_type: vm.productType,
                  budget_year: vm.budgetYear,
                  month: vm.month,
                  bi_weekly: vm.biWeekly
                };
                _context10.next = 4;
                return axios.get(vm.url.ajax_check_working_hour, {
                  params: params
                }).then(function (res) {
                  if (res.data.data.status == 'E') {
                    // swal({
                    //     title: 'มีข้อผิดพลาด',
                    //     text: '<span style="font-size: 15px; text-align: left;">'+res.data.data.msg+'</span>',
                    //     type: "warning",
                    //     html: true
                    // });
                    vm.messageCheckWKHHtml = res.data.data.msg;
                    vm.isControlDisable = true;
                  }
                })["catch"](function (err) {
                  var data = err.response.data;
                  alert(data.message);
                });

              case 4:
              case "end":
                return _context10.stop();
            }
          }
        }, _callee10);
      }))();
    },
    updateControlDisable: function updateControlDisable(res) {
      this.isControlDisable = res;
    },
    fetchDataP07: function fetchDataP07(res) {
      this.refreshOMSalesForecast = true;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/HeaderDetail.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/HeaderDetail.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["machineBiweekly", "productDailyPlan", "productBiweeklyMain"]
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/ItemPlan.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/ItemPlan.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["productDailyPlan", "itemCigars", "productType", "DateFormat", "btnTrans", "url", "itemProductionMain"],
  data: function data() {
    return {
      item_code: '',
      item_name: '',
      loading: false,
      errors: {
        item_code: false
      },
      html: '',
      listItemCigarettes: []
    };
  },
  mounted: function mounted() {
    this.itemCigarette();
  },
  computed: {},
  methods: {
    getData: function getData() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var vm, form, valid, errorMsg, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                vm = _this;
                form = $('#onhand-form');
                valid = true;
                errorMsg = '';
                vm.errors.item_code = false;
                $(form).find("div[id='el_explode_item']").html("");

                if (vm.item_code == '') {
                  vm.errors.item_code = true;
                  valid = false;
                  errorMsg = "กรุณาเลือกรหัสบุหรี่";
                  $(form).find("div[id='el_explode_item']").html(errorMsg);
                }

                if (valid) {
                  _context.next = 9;
                  break;
                }

                return _context.abrupt("return");

              case 9:
                vm.loading = true;
                vm.html = '';
                params = {
                  daily_id: vm.productDailyPlan != null ? vm.productDailyPlan.daily_id : '',
                  item_code: vm.item_code
                };
                vm.html = '\ <div class="m-t-lg m-b-lg">\
                            <div class="text-center sk-spinner sk-spinner-wave">\
                                <div class="sk-rect1"></div>\
                                <div class="sk-rect2"></div>\
                                <div class="sk-rect3"></div>\
                                <div class="sk-rect4"></div>\
                                <div class="sk-rect5"></div>\
                            </div>\
                        </div>';
                _context.next = 15;
                return axios.get(vm.url.ajax_get_production_item, {
                  params: params
                }).then(function (res) {
                  vm.html = res.data.data.html;
                })["catch"](function (err) {
                  vm.html = res.data.data.html;
                }).then(function () {
                  vm.loading = false;
                });

              case 15:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    setError: function setError(ref_name) {
      var ref = this.$refs[ref_name].$refs.reference ? this.$refs[ref_name].$refs.reference.$refs.input : this.$refs[ref_name].$refs.textarea ? this.$refs[ref_name].$refs.textarea : this.$refs[ref_name].$refs.input.$refs ? this.$refs[ref_name].$refs.input.$refs.input : this.$refs[ref_name].$refs.input;
      ref.style = "border: 1px solid red;";
    },
    resetError: function resetError(ref_name) {
      var ref = this.$refs[ref_name].$refs.reference ? this.$refs[ref_name].$refs.reference.$refs.input : this.$refs[ref_name].$refs.textarea ? this.$refs[ref_name].$refs.textarea : this.$refs[ref_name].$refs.input.$refs ? this.$refs[ref_name].$refs.input.$refs.input : this.$refs[ref_name].$refs.input;
      ref.style = "";
    },
    errorRef: function errorRef(res) {
      var vm = this;
      vm.errors.item_code = res.err.item_code;
    },
    itemCigarette: function itemCigarette() {
      var _this2 = this;

      // this.listItemCigarettes = this.items.filter(item => {
      //     return item.product_type == this.productType;
      // });
      Object.values(this.itemProductionMain).filter(function (itemMain) {
        _this2.itemCigars.filter(function (item) {
          if (item.item_code == itemMain && item.product_type == _this2.productType) {
            _this2.listItemCigarettes.push(item);
          }
        });
      });
    },
    selItem: function selItem() {
      var _this3 = this;

      this.listItemCigarettes.filter(function (item) {
        if (item.item_code == _this3.item_code) {
          return _this3.item_name = item.item_description;
        }
      });
    }
  },
  watch: {
    errors: {
      handler: function handler(val) {
        val.item_code ? this.setError('item_code') : this.resetError('item_code');
      },
      deep: true
    },
    productType: function () {
      var _productType = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2(value, oldValue) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                // this.itemCigarette();
                this.html = '';

              case 1:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, this);
      }));

      function productType(_x, _x2) {
        return _productType.apply(this, arguments);
      }

      return productType;
    }()
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/List.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/List.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var uuid_v1__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! uuid/v1 */ "./node_modules/uuid/v1.js");
/* harmony import */ var uuid_v1__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(uuid_v1__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-numeric */ "./node_modules/vue-numeric/dist/vue-numeric.min.js");
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vue_numeric__WEBPACK_IMPORTED_MODULE_1__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["index", "attribute", "listItemCigarettes", "listItemLines", "pValid"],
  components: {
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_1___default())
  },
  data: function data() {
    return {
      loading: false,
      valid: true,
      errors: {
        item_code: false,
        item_efficiency: false
      },
      itemLine: this.attribute,
      items: this.listItemCigarettes,
      selectedItem: this.attribute.item_code,
      description: this.attribute.item_description,
      enable: this.attribute.is_enable
    };
  },
  mounted: function mounted() {// this.addItemEfficiency();
  },
  computed: {
    orderedItem: function orderedItem() {
      return _.orderBy(this.listItemCigarettes, ['item_code']);
    }
  },
  watch: {
    errors: {
      handler: function handler(val) {
        val.item_code ? this.setError('item_code') : this.resetError('item_code'); // val.item_efficiency? this.setError('item_efficiency') : this.resetError('item_efficiency');
      },
      deep: true
    }
  },
  methods: {
    decimal: function decimal(number) {
      return Number(number).toLocaleString(undefined, {
        minimumFractionDigits: 2
      });
    },
    selItem: function selItem() {
      var vm = this;
      var form = $('#plan-daily-form');
      vm.valid = true;
      var errorMsg = '';

      if (!vm.valid) {
        return;
      }

      vm.addItemEfficiency();

      if (vm.selectedItem == '' || vm.selectedItem == null) {
        vm.itemLine.item_efficiency = 0;
        vm.itemLine.item_id = '';
        vm.itemLine.item_code = vm.itemLine.description = vm.description = '';
        return;
      }

      vm.itemLine.item_code = vm.selectedItem;
      vm.items.filter(function (item) {
        if (item.item_code == vm.selectedItem) {
          vm.itemLine.item_id = item.inventory_item_id;
          vm.itemLine.item_description = vm.description = item.item_description;
          return;
        }
      });
    },
    addItemEfficiency: function addItemEfficiency() {
      var vm = this;
      var form = $('#plan-daily-form');
      var errorMsg = '';
      vm.errors.item_efficiency = false;
      $(form).find("span[id='el_explode_item_efficiency" + vm.index + "']").html("");

      if (vm.selectedItem) {
        vm.listItemLines.filter(function (item) {
          if (item.item_efficiency == 0) {
            vm.errors.item_efficiency = true;
            errorMsg = "ระบุปริมาณสั่งผลิตมากกว่า 0";
            $(form).find("span[id='el_explode_item_efficiency" + vm.index + "']").html(errorMsg);
          }
        });
      } // this.itemLine.item_efficiency = Math.floor(Number(this.itemLine.item_efficiency) * 100) / 100; 

    },
    setError: function setError(ref_name) {
      var ref = this.$refs[ref_name].$refs.reference ? this.$refs[ref_name].$refs.reference.$refs.input : this.$refs[ref_name].$refs.textarea ? this.$refs[ref_name].$refs.textarea : this.$refs[ref_name].$refs.input.$refs ? this.$refs[ref_name].$refs.input.$refs.input : this.$refs[ref_name].$refs.input;
      ref.style = "border: 1px solid red;";
    },
    resetError: function resetError(ref_name) {
      var ref = this.$refs[ref_name].$refs.reference ? this.$refs[ref_name].$refs.reference.$refs.input : this.$refs[ref_name].$refs.textarea ? this.$refs[ref_name].$refs.textarea : this.$refs[ref_name].$refs.input.$refs ? this.$refs[ref_name].$refs.input.$refs.input : this.$refs[ref_name].$refs.input;
      ref.style = "";
    },
    remove: function remove(itemLine) {
      this.$emit("removeRow", itemLine);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/ModalControl.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/ModalControl.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _List_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./List.vue */ "./resources/js/components/Planning/Production-Daily/components/List.vue");
/* harmony import */ var uuid_v1__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! uuid/v1 */ "./node_modules/uuid/v1.js");
/* harmony import */ var uuid_v1__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(uuid_v1__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var vuedraggable__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! vuedraggable */ "./node_modules/vuedraggable/dist/vuedraggable.umd.js");
/* harmony import */ var vuedraggable__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(vuedraggable__WEBPACK_IMPORTED_MODULE_4__);


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




/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    ListItem: _List_vue__WEBPACK_IMPORTED_MODULE_1__.default
  },
  props: ["machineBiweekly", "productDailyPlan", 'modalControlInput', "dBudgetYear", "dMonth", "dBiWeekly", "productType", "dateFormat", "btnTrans", "url", "itemProductionMain", "isControlDisable"],
  data: function data() {
    return {
      loading: false,
      eff_loading: false,
      // biWeekly Date
      biweekly_date_from: '',
      biweekly_date_to: '',
      current_date: '',
      next_date: '',
      // Input Date
      input_date_from: '',
      input_date_to: '',
      // Check Date
      checkDate: {
        biweekly_date_from: '',
        biweekly_date_to: '',
        current_date: '',
        next_date: '',
        input_date_from: '',
        input_date_to: ''
      },
      machine_group: '',
      efficiencyProductHeader: 0,
      totalApplyEfficient: 0,
      balanceEfficient: 0,
      errors: {
        budget_year: false,
        month: false,
        bi_weekly: false,
        start_date: false,
        end_date: false,
        machine_group: false
      },
      machineLists: this.modalControlInput.machines,
      machineLines: [],
      listItemCigarettes: [],
      //list item
      itemLines: [],
      //push arr data item
      removeItemLines: [],
      //push arr data remove item
      html: '',
      canEdit: true,
      isDisableSelDate: false,
      machineDescLists: [],
      machine_desc: ''
    };
  },
  mounted: function mounted() {
    this.sortMachine();
    this.selItemCigarette();

    if (this.productDailyPlan != undefined && this.productDailyPlan != '') {
      this.canEdit = this.productDailyPlan.can.edit;
    }
  },
  computed: {
    totalApply: function totalApply() {
      var _this = this;

      return this.itemLines.reduce(function (accumulator, line) {
        var item_efficiency = line.item_efficiency == '' || line.item_efficiency == null ? 0 : line.item_efficiency;
        _this.totalApplyEfficient = accumulator + parseFloat(item_efficiency);
        _this.balanceEfficient = Number(_this.efficiencyProductHeader) - Number(_this.totalApplyEfficient).toFixed(2);

        if (_this.machine_group == '' || _this.machine_group == null) {
          _this.balanceEfficient = 0;
        }

        return accumulator + parseFloat(item_efficiency);
      }, 0);
    },
    dailyPlan: function () {
      var _dailyPlan = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee(value, oldValue) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                if (this.productDailyPlan != undefined && this.productDailyPlan != '') {
                  this.canEdit = this.productDailyPlan.can.edit;
                } else {
                  this.canEdit = true;
                }

              case 1:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this);
      }));

      function dailyPlan(_x, _x2) {
        return _dailyPlan.apply(this, arguments);
      }

      return dailyPlan;
    }()
  },
  watch: {
    totalApply: function totalApply(newVal) {
      this.totalApplyEfficient = Number(newVal).toFixed(2);
      return newVal;
    },
    productType: function () {
      var _productType = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2(value, oldValue) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                this.sortMachine();
                this.selItemCigarette();

                if (this.productDailyPlan != undefined && this.productDailyPlan != '') {
                  this.canEdit = this.productDailyPlan.can.edit;
                } else {
                  this.canEdit = true;
                }

              case 3:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, this);
      }));

      function productType(_x3, _x4) {
        return _productType.apply(this, arguments);
      }

      return productType;
    }(),
    dailyPlan: function dailyPlan(newVal) {
      return newVal;
    },
    errors: {
      handler: function handler(val) {// val.start_date? this.setError('start_date') : this.resetError('start_date');
        // val.end_date? this.setError('end_date') : this.resetError('end_date');
        // val.machine_group? this.setError('machine_group') : this.resetError('machine_group');
      },
      deep: true
    }
  },
  methods: {
    decimal: function decimal(number) {
      return Number(number).toLocaleString(undefined, {
        minimumFractionDigits: 2
      });
    },
    openModal: function openModal() {
      var vm = this;
      var form = $('#plan-daily-form');
      var valid = true;
      var errorMsg = '';
      vm.errors.budget_year = false;
      vm.errors.month = false;
      vm.errors.bi_weekly = false;
      $(form).find("div[id='el_explode_budget_year']").html("");
      $(form).find("div[id='el_explode_month']").html("");
      $(form).find("div[id='el_explode_bi_weekly']").html("");

      if (vm.dBudgetYear == '') {
        vm.errors.budget_year = true;
        valid = false;
        errorMsg = "กรุณาเลือกปีงบประมาณ";
        $(form).find("div[id='el_explode_budget_year']").html(errorMsg);
      }

      if (vm.dMonth == '') {
        vm.errors.month = true;
        valid = false;
        errorMsg = "กรุณาเลือกเดือน";
        $(form).find("div[id='el_explode_month']").html(errorMsg);
      }

      if (vm.dBiWeekly == '') {
        vm.errors.bi_weekly = true;
        valid = false;
        errorMsg = "กรุณาเลือกปักษ์";
        $(form).find("div[id='el_explode_bi_weekly']").html(errorMsg);
      }

      this.$emit("errorRef", {
        err: this.errors
      });

      if (!valid) {
        return;
      }

      this.getDateByBiWeekly();
      $('#modal_control').modal('show');
    },
    addItemLine: function addItemLine() {
      this.itemLines.push({
        id: uuid_v1__WEBPACK_IMPORTED_MODULE_2___default()(),
        line_number: '',
        item_id: '',
        item_code: '',
        item_description: '',
        item_efficiency: '',
        is_enable: false
      });
    },
    sortMachine: function sortMachine() {
      var _this2 = this;

      this.machineLists = this.modalControlInput.machines.filter(function (item) {
        return item.product_type == _this2.productType;
      });
    },
    selMachine: function selMachine() {
      var _this3 = this;

      var form = $('#production-plan-control-form');
      this.itemLines = [];
      this.machineDescLists = [];
      this.efficiencyProductHeader = 0;
      this.totalApplyEfficient = 0;
      this.balanceEfficient = 0;
      this.errors.machine_group = false;
      $(form).find("div[id='el_explode_machine_group']").html("");

      if (this.machine_group == '' || this.machine_group == null) {
        this.machineDescLists = [];
        return this.efficiencyProductHeader = 0;
      } // New Requirement 231102021 filter machine_desc


      this.machineDescLists = this.modalControlInput.machine_desc.filter(function (item) {
        return item.machine_group == _this3.machine_group;
      }); // get grp_efficiency_product when choose machine group

      this.grpEfficiencyProduct();
    },
    selItemCigarette: function selItemCigarette() {
      var _this4 = this;

      Object.values(this.itemProductionMain).filter(function (itemMain) {
        _this4.modalControlInput.itemCigarette.filter(function (item) {
          if (item.item_code == itemMain && item.product_type == _this4.productType) {
            _this4.listItemCigarettes.push(item);
          }
        });
      });
    },
    dateWasSelectedFrom: function dateWasSelectedFrom(dateFrom) {
      var form = $('#production-plan-control-form');
      this.errors.start_date = false;
      $(form).find("div[id='el_explode_start_date']").html("");
      this.machine_group = '';
      this.itemLines = [];
      this.efficiencyProductHeader = 0;
      this.balanceEfficient = 0;
      this.input_date_from = dateFrom ? moment__WEBPACK_IMPORTED_MODULE_3___default()(dateFrom).format(this.dateFormat) : '';
      var input_date_from = moment__WEBPACK_IMPORTED_MODULE_3___default()(dateFrom).format('YYYY-MM-DD');
      input_date_from = this.changeThToEn(input_date_from);
      this.checkDate.input_date_from = input_date_from;
    },
    dateWasSelectedTo: function dateWasSelectedTo(dateTo) {
      var form = $('#production-plan-control-form');
      this.errors.end_date = false;
      $(form).find("div[id='el_explode_end_date']").html("");
      this.machine_group = '';
      this.itemLines = [];
      this.efficiencyProductHeader = 0;
      this.balanceEfficient = 0;
      this.input_date_to = dateTo ? moment__WEBPACK_IMPORTED_MODULE_3___default()(dateTo).format(this.dateFormat) : '';
      var input_date_to = moment__WEBPACK_IMPORTED_MODULE_3___default()(dateTo).format('YYYY-MM-DD');
      input_date_to = this.changeThToEn(input_date_to);
      this.checkDate.input_date_to = input_date_to;
    },
    removeLine: function removeLine(itemLine) {
      console.log(itemLine);
      this.itemLines = this.itemLines.filter(function (item) {
        return item.id != itemLine.id;
      }); // When remove item will minus total

      this.totalApplyEfficient = this.totalApplyEfficient.toFixed(2) - itemLine.item_efficiency;
      this.balanceEfficient = this.balanceEfficient + itemLine.item_efficiency; // แสตมป์ข้อมูล Item ที่ลบไป และต้องมีใน Table : machines
      // this.productDailyPlan.machines.filter( item => {
      //     if (item.item_code == itemLine.item_code) {

      this.removeItemLines.push(itemLine); //     }
      // });
    },
    submit: function submit() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var vm, form, valid, msg, res;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                vm = _this5;
                form = $('#production-plan-control-form');
                valid = true;
                msg = '';
                vm.loading = true;
                vm.errors.start_date = false;
                vm.errors.end_date = false;
                vm.errors.machine_group = false;
                $(form).find("div[id='el_explode_start_date']").html("");
                $(form).find("div[id='el_explode_end_date']").html("");
                $(form).find("div[id='el_explode_machine_group']").html(""); // Validate input

                if (vm.input_date_from == '') {
                  vm.errors.start_date = true;
                  valid = false;
                  vm.loading = false;
                  msg = "กรุณาเลือกวันที่เริ่ม";
                  $(form).find("div[id='el_explode_start_date']").html(msg);
                }

                if (vm.input_date_to == '') {
                  vm.errors.end_date = true;
                  valid = false;
                  vm.loading = false;
                  msg = "กรุณาเลือกวันที่สิ้นสุด";
                  $(form).find("div[id='el_explode_end_date']").html(msg);
                }

                if (vm.machine_group == '') {
                  vm.errors.machine_group = true;
                  valid = false;
                  vm.loading = false;
                  msg = "กรุณาเลือกขอบเขตเครื่องจักร";
                  $(form).find("div[id='el_explode_machine_group']").html(msg);
                }

                if (vm.checkDate.next_date > vm.checkDate.input_date_from || vm.checkDate.next_date > vm.checkDate.input_date_to) {
                  msg = 'ไม่สามารถทำการสร้างและปรับข้อมูลแผนการผลิตรายวันได้ <br> เนื่องจากไม่สามารถปรับวันที่ย้อนหลังได้';
                  valid = false;
                  vm.loading = false;
                  swal({
                    title: 'มีข้อผิดพลาด',
                    text: '<span style="font-size: 16px; text-align: left;">' + msg + '</span>',
                    type: "error",
                    html: true
                  });
                }

                if (valid) {
                  _context3.next = 17;
                  break;
                }

                return _context3.abrupt("return");

              case 17:
                // Validate Data
                if (Number(vm.totalApplyEfficient).toFixed(2) > vm.efficiencyProductHeader) {
                  msg = 'ไม่สามารถทำการสร้างและปรับข้อมูลแผนการผลิตรายวันได้ เนื่องจากปริมาณสั่งผลิตเกินจำนวนที่กำหนดไว้';
                  valid = false;
                  vm.loading = false;
                  swal({
                    title: 'มีข้อผิดพลาด',
                    text: '<span style="font-size: 16px; text-align: left;">' + msg + '</span>',
                    type: "error",
                    html: true
                  });
                } else if (vm.checkDate.input_date_from < vm.checkDate.biweekly_date_from || vm.checkDate.input_date_to > vm.checkDate.biweekly_date_to) {
                  msg = 'ช่วงวันที่ที่เลือกไม่อยู่ในช่วงวันที่ของปักษ์ <br> ควรระบุในช่วงวันที่ ' + vm.biweekly_date_from + ' ถึง ' + vm.biweekly_date_to;
                  valid = false;
                  vm.loading = false;
                  swal({
                    title: 'มีข้อผิดพลาด',
                    text: '<span style="font-size: 16px; text-align: left;">' + msg + '</span>',
                    type: "error",
                    html: true
                  });
                } // Validate value: null in array


                if (vm.itemLines.length) {
                  vm.itemLines.filter(function (item, index) {
                    if (item.item_code == '' || item.item_code == null) {
                      msg = 'กรุณากรอกข้อมูลรหัสบุหรี่ให้ครบ';
                      valid = false;
                      vm.loading = false;
                      swal({
                        title: 'ตรวจสอบข้อมูล',
                        text: '<span style="font-size: 16px; text-align: left;">' + msg + '</span>',
                        type: "warning",
                        html: true
                      });
                    }

                    if (item.item_efficiency == 0) {
                      var i = Number(index) + 1;
                      msg = 'รายการที่ ' + i + ' จำนวนปริมาณที่สั่งผลิตเป็น 0 กรุณาตรวจสอบ';
                      valid = false;
                      vm.loading = false;
                      swal({
                        title: 'ตรวจสอบข้อมูล',
                        text: '<span style="font-size: 16px; text-align: left;">' + msg + '</span>',
                        type: "warning",
                        html: true
                      });
                    }
                  });
                }

                if (valid) {
                  _context3.next = 21;
                  break;
                }

                return _context3.abrupt("return");

              case 21:
                _context3.next = 23;
                return _this5.create();

              case 23:
                res = _context3.sent;
                vm.loading = false;

                if (res.status == 'S') {
                  vm.loading = false;
                  vm.removeItemLines = [];
                  vm.loopDataItemLines();
                  swal({
                    title: 'สร้างและปรับแผนการผลิตรายวัน',
                    text: '<span style="font-size: 16px; text-align: left;"> ทำการสร้างและปรับข้อมูลแผนการผลิตรายวันเรียบร้อยแล้ว </span>',
                    type: "success",
                    html: true
                  });
                  vm.$emit("fetchDataP07", true);
                } else {
                  swal({
                    title: 'มีข้อผิดพลาด',
                    text: '<span style="font-size: 16px; text-align: left;">' + res.msg + '</span>',
                    type: "error",
                    html: true
                  });
                }

              case 26:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    create: function create() {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        var vm2, data, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                vm2 = _this6;
                data = {
                  msg: ''
                };
                params = {
                  budget_year: vm2.dBudgetYear,
                  // month: vm2.dMonth,
                  bi_weekly: vm2.dBiWeekly,
                  product_type: vm2.productType,
                  // product_main: vm2.machineBiweekly,
                  date_from: vm2.input_date_from,
                  date_to: vm2.input_date_to,
                  machine_group: vm2.machine_group,
                  // efficiency_product: Number(vm2.efficiencyProductHeader).toFixed(2),
                  efficiency_product: Number(vm2.efficiencyProductHeader),
                  items: vm2.itemLines,
                  removeItems: vm2.removeItemLines
                };
                _context4.next = 5;
                return axios.post(vm2.url.ajax_submit_production_machine, params).then(function (res) {
                  data = res.data.data;
                  vm2.redirect_show_page = data.redirect_show_page;
                  vm2.machineLines = res.data.data.machines;
                })["catch"](function (err) {
                  var msg = err;
                  swal({
                    title: 'มีข้อผิดพลาด',
                    text: msg.message,
                    type: "error"
                  });
                }).then(function () {
                  vm2.loading = false;
                });

              case 5:
                return _context4.abrupt("return", data);

              case 6:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    // ดึงข้อมูลเมื่อมีการกด แก้ไข
    getDateByBiWeekly: function getDateByBiWeekly() {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        var vm, date_from, date_to, curr_date, currentDate, startDate, endDate;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                vm = _this7;
                date_from = '';
                date_to = '';
                curr_date = moment__WEBPACK_IMPORTED_MODULE_3___default()().format('YYYY-MM-DD');
                vm.modalControlInput.bi_weekly.filter(function (item) {
                  // item.thai_year == vm.dBudgetYear && 
                  if (item.biweekly == vm.dBiWeekly && item.period_num == vm.dMonth) {
                    date_from = item.start_date;
                    date_to = item.end_date;
                  }
                }); // Date for check condition

                vm.checkDate.biweekly_date_from = moment__WEBPACK_IMPORTED_MODULE_3___default()(date_from).format('YYYY-MM-DD');
                vm.checkDate.biweekly_date_to = moment__WEBPACK_IMPORTED_MODULE_3___default()(date_to).format('YYYY-MM-DD');
                vm.checkDate.current_date = curr_date;
                vm.checkDate.next_date = vm.getNextDate(curr_date);
                vm.checkDate.input_date_from = moment__WEBPACK_IMPORTED_MODULE_3___default()(date_from).format('YYYY-MM-DD');
                vm.checkDate.input_date_to = moment__WEBPACK_IMPORTED_MODULE_3___default()(date_to).format('YYYY-MM-DD'); // Convert Date

                _context5.next = 13;
                return helperDate.parseToDateTh(curr_date, 'YYYY-MM-DD');

              case 13:
                currentDate = _context5.sent;
                _context5.next = 16;
                return helperDate.parseToDateTh(date_from, 'YYYY-MM-DD');

              case 16:
                startDate = _context5.sent;
                _context5.next = 19;
                return helperDate.parseToDateTh(date_to, 'YYYY-MM-DD');

              case 19:
                endDate = _context5.sent;
                // Biweek date
                vm.current_date = moment__WEBPACK_IMPORTED_MODULE_3___default()(currentDate).format(vm.dateFormat);
                vm.biweekly_date_from = moment__WEBPACK_IMPORTED_MODULE_3___default()(startDate).format(vm.dateFormat);
                vm.biweekly_date_to = moment__WEBPACK_IMPORTED_MODULE_3___default()(endDate).format(vm.dateFormat); // Input Date

                if (!(curr_date >= moment__WEBPACK_IMPORTED_MODULE_3___default()(date_from).format('YYYY-MM-DD') && curr_date >= moment__WEBPACK_IMPORTED_MODULE_3___default()(date_to).format('YYYY-MM-DD'))) {
                  _context5.next = 28;
                  break;
                }

                vm.input_date_from = moment__WEBPACK_IMPORTED_MODULE_3___default()(startDate).format(vm.dateFormat);
                vm.checkDate.input_date_from = moment__WEBPACK_IMPORTED_MODULE_3___default()(date_from).format('YYYY-MM-DD');
                _context5.next = 37;
                break;

              case 28:
                if (!(curr_date >= moment__WEBPACK_IMPORTED_MODULE_3___default()(date_from).format('YYYY-MM-DD'))) {
                  _context5.next = 35;
                  break;
                }

                _context5.next = 31;
                return helperDate.parseToDateTh(vm.getNextDate(curr_date), 'YYYY-MM-DD');

              case 31:
                vm.input_date_from = _context5.sent;
                vm.checkDate.input_date_from = vm.getNextDate(curr_date);
                _context5.next = 37;
                break;

              case 35:
                vm.input_date_from = moment__WEBPACK_IMPORTED_MODULE_3___default()(startDate).format(vm.dateFormat);
                vm.checkDate.input_date_from = moment__WEBPACK_IMPORTED_MODULE_3___default()(date_from).format('YYYY-MM-DD');

              case 37:
                vm.input_date_to = moment__WEBPACK_IMPORTED_MODULE_3___default()(endDate).format(vm.dateFormat);
                vm.checkDate.input_date_to = moment__WEBPACK_IMPORTED_MODULE_3___default()(date_to).format('YYYY-MM-DD'); // Disable date

                if (curr_date >= moment__WEBPACK_IMPORTED_MODULE_3___default()(date_from).format('YYYY-MM-DD') && curr_date >= moment__WEBPACK_IMPORTED_MODULE_3___default()(date_to).format('YYYY-MM-DD')) {
                  vm.isDisableSelDate = true;
                }

              case 40:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    getNextDate: function getNextDate(currDate) {
      var vm = this;
      var currentDate = moment__WEBPACK_IMPORTED_MODULE_3___default()(currDate).format('YYYY-MM-DD hh:mm:ss');
      var addDay = moment__WEBPACK_IMPORTED_MODULE_3___default()(currentDate, "YYYY-MM-DD hh:mm:ss").add(1, "days");
      vm.next_date = moment__WEBPACK_IMPORTED_MODULE_3___default()(addDay).format(vm.dateFormat);
      return moment__WEBPACK_IMPORTED_MODULE_3___default()(addDay).format("YYYY-MM-DD");
    },
    loopDataItemLines: function loopDataItemLines() {
      // ดึงขัอมูลจาก Machine
      var vm = this;

      if (vm.productDailyPlan) {
        vm.itemLines = []; // แก้ใหม่

        vm.machineLines.filter(function (line) {
          if (line.machine_group == vm.machine_group) {
            vm.itemLines.push({
              id: uuid_v1__WEBPACK_IMPORTED_MODULE_2___default()(),
              line_number: line.line_no,
              item_id: line.item_id,
              item_code: line.item_code,
              item_description: line.item_description,
              // item_efficiency: Number(line.efficiency_product).toFixed(2),
              item_efficiency: Number(line.efficiency_product),
              is_enable: true
            });
          }
        });
      }
    },
    grpEfficiencyProduct: function grpEfficiencyProduct() {
      var _this8 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6() {
        var vm, form, valid, errorMsg, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                vm = _this8;
                form = $('#production-plan-control-form');
                valid = true;
                errorMsg = '';
                vm.errors.start_date = false;
                vm.errors.end_date = false;
                vm.errors.machine_group = false;
                $(form).find("div[id='el_explode_start_date']").html("");
                $(form).find("div[id='el_explode_end_date']").html("");
                $(form).find("div[id='el_explode_machine_group']").html("");
                $(form).find("div[id='el_explode_budget_year']").html("");
                $(form).find("div[id='el_explode_month']").html(""); // Validate input

                if (vm.input_date_from == '') {
                  vm.errors.start_date = true;
                  valid = false;
                  msg = "กรุณาเลือกวันที่เริ่ม";
                  $(form).find("div[id='el_explode_start_date']").html(msg);
                }

                if (vm.input_date_to == '') {
                  vm.errors.end_date = true;
                  valid = false;
                  msg = "กรุณาเลือกวันที่สิ้นสุด";
                  $(form).find("div[id='el_explode_end_date']").html(msg);
                }

                if (vm.machine_group == '') {
                  vm.errors.machine_group = true;
                  valid = false;
                  msg = "กรุณาเลือกขอบเขตเครื่องจักร";
                  $(form).find("div[id='el_explode_machine_group']").html(msg);
                }

                if (valid) {
                  _context6.next = 17;
                  break;
                }

                return _context6.abrupt("return");

              case 17:
                vm.eff_loading = true;
                vm.html = '\ <div class="mt-2">\
                            <div class="text-center sk-spinner sk-spinner-wave">\
                                <div class="sk-rect1"></div>\
                                <div class="sk-rect2"></div>\
                                <div class="sk-rect3"></div>\
                                <div class="sk-rect4"></div>\
                                <div class="sk-rect5"></div>\
                            </div>\
                        </div>';
                params = {
                  start_date: vm.input_date_from,
                  end_date: vm.input_date_to,
                  biweekly_id: vm.machineBiweekly.biweekly_id,
                  machine_group: vm.machine_group,
                  product_type: vm.productType,
                  daily_id: vm.productDailyPlan != null ? vm.productDailyPlan.daily_id : ''
                };
                _context6.next = 22;
                return axios.get(vm.url.ajax_get_grp_efficiency_product, {
                  params: params
                }).then(function (res) {
                  vm.html = ''; // vm.efficiencyProductHeader = Number(res.data.data.grp_efficiency_product).toFixed(2);

                  vm.efficiencyProductHeader = Number(res.data.data.grp_efficiency_product);
                  vm.balanceEfficient = Number(res.data.data.grp_efficiency_product);
                  vm.machineLines = res.data.data.machines; // loop item with machine

                  vm.loopDataItemLines();
                })["catch"](function (err) {
                  vm.html = '';
                  vm.efficiencyProductHeader = 0;
                }).then(function () {
                  vm.html = '';
                  vm.eff_loading = false;
                });

              case 22:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      }))();
    },
    setError: function setError(ref_name) {
      var ref = this.$refs[ref_name].$refs.reference ? this.$refs[ref_name].$refs.reference.$refs.input : this.$refs[ref_name].$refs.textarea ? this.$refs[ref_name].$refs.textarea : this.$refs[ref_name].$refs.input.$refs ? this.$refs[ref_name].$refs.input.$refs.input : this.$refs[ref_name].$refs.input;
      ref.style = "border: 1px solid red;";
    },
    resetError: function resetError(ref_name) {
      var ref = this.$refs[ref_name].$refs.reference ? this.$refs[ref_name].$refs.reference.$refs.input : this.$refs[ref_name].$refs.textarea ? this.$refs[ref_name].$refs.textarea : this.$refs[ref_name].$refs.input.$refs ? this.$refs[ref_name].$refs.input.$refs.input : this.$refs[ref_name].$refs.input;
      ref.style = "";
    },
    errorRef: function errorRef(res) {
      var vm = this;
      vm.errors.start_date = res.err.start_date;
      vm.errors.end_date = res.err.end_date;
      vm.errors.machine_group = res.err.machine_group;
    },
    cancel: function cancel() {
      var _this9 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee7() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                _this9.machine_group = '';
                _this9.itemLines = [];
                _this9.efficiencyProductHeader = 0;
                _this9.balanceEfficient = 0;
                _this9.balanceEfficient = 0;
                _this9.machineDescLists = [];

              case 6:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7);
      }))();
    },
    changeThToEn: function changeThToEn(dateTh) {
      // เปลี่ยน Format และ เปลี่ยน พศ -> คศ
      var vm = this;
      var date = moment__WEBPACK_IMPORTED_MODULE_3___default()(dateTh, 'YYYY-MM-DD');
      date.subtract(543, 'years');
      return date.format('YYYY-MM-DD');
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/OMSalesForecast.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/OMSalesForecast.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["dailyPlan", "machineBiweekly", "biweeklyColorCode", "productTypes", "productType", "versions", "defaultInput", "btnTrans", "url", "refreshOMSalesForecast", "canViewProduction"],
  data: function data() {
    return {
      loading: {
        omSalesForecastProcess: false
      },
      version_no: this.defaultInput.last_om_version,
      omSalesForecasts: [],
      productName: '',
      itemLists: [],
      html: '',
      totalEfficiencyP03: '',
      unit: '',
      totalQuantity: [],
      currOnhand: [],
      omSales: [],
      // total
      forecast_qty: 0,
      forecast_million_qty: 0,
      daily_qty: 0,
      balance_sale_forecast: 0,
      // forecast_million_qty - daily_qty
      curr_onhnad_qty: 0,
      om_sale_qty: 0,
      balance_days: 0,
      // curr_onhnad_qty / om_sale_qty
      alertSaleForcasts: {},
      // ----------------------------------------------------------
      pmProducts: [],
      prevTotalQuantity: [],
      balance_product: 0,
      // pm_product
      balance_daily: 0,
      // prev_daily_qty
      types: [{
        value: 'planning',
        label: 'แผนสั่งผลิตเทียบกับแผนขาย'
      }, {
        value: 'production',
        label: 'แผนสั่งผลิตเทียบกับผลผลิต'
      }],
      type_module: 'planning'
    };
  },
  mounted: function mounted() {
    if (this.machineBiweekly) {
      this.getProductionPlan();
    }

    this.getProductName();
    this.getUnitProductType();
  },
  computed: {
    totalForecastQty: function totalForecastQty() {
      var vm = this;
      var total_forecast_qty = 0;
      var total_forecast_million_qty = 0;

      if (vm.omSalesForecasts) {
        vm.omSalesForecasts.filter(function (line) {
          total_forecast_qty += Number(line.forecast_qty);
          total_forecast_million_qty += Number(line.forecast_million_qty);
        });
      }

      vm.forecast_qty = total_forecast_qty;
      vm.forecast_million_qty = total_forecast_million_qty;
    },
    totalDailyQty: function totalDailyQty() {
      var vm = this;
      var daily_qty = 0;

      if (vm.totalQuantity) {
        Object.values(vm.totalQuantity).filter(function (line) {
          daily_qty += Number(line[0]);
        });
      }

      vm.daily_qty = daily_qty;
      vm.balance_sale_forecast = vm.forecast_million_qty - daily_qty;
    },
    totalCurrOnhandQty: function totalCurrOnhandQty() {
      var vm = this;
      var currOnhand = 0;

      if (vm.currOnhand) {
        Object.values(vm.currOnhand).filter(function (line) {
          currOnhand += Number(line);
        });
      }

      vm.curr_onhnad_qty = currOnhand;
    },
    totalOmSaleQty: function totalOmSaleQty() {
      var vm = this;
      var omSale = 0;

      if (vm.omSales) {
        Object.values(vm.omSales).filter(function (line) {
          omSale += Number(line);
        });
      }

      vm.om_sale_qty = omSale;
      vm.balance_days = vm.curr_onhnad_qty / omSale;
      vm.balance_days = omSale == 0 ? 0 : vm.balance_days;
    },
    totalPrevPMProduct: function totalPrevPMProduct() {
      var vm = this;
      var product_qty = 0;

      if (vm.pmProducts) {
        Object.values(vm.pmProducts).filter(function (line) {
          product_qty += Number(line[0]);
        });
      }

      vm.balance_product = product_qty;
    },
    totalPrevPlanDaily: function totalPrevPlanDaily() {
      var vm = this;
      var daily_qty = 0;

      if (vm.prevTotalQuantity) {
        Object.values(vm.prevTotalQuantity).filter(function (line) {
          daily_qty += Number(line[0]);
        });
      }

      vm.balance_daily = daily_qty;
    }
  },
  watch: {
    productType: function () {
      var _productType = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee(value, oldValue) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                this.getProductionPlan();
                this.$emit("omSalesForecast", this.omSalesForecasts, this.itemLists, false);
                this.html = '';

              case 3:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this);
      }));

      function productType(_x, _x2) {
        return _productType.apply(this, arguments);
      }

      return productType;
    }(),
    totalForecastQty: function totalForecastQty(newValue) {
      return newValue;
    },
    totalDailyQty: function totalDailyQty(newValue) {
      return newValue;
    },
    totalCurrOnhandQty: function totalCurrOnhandQty(newValue) {
      return newValue;
    },
    totalOmSaleQty: function totalOmSaleQty(newValue) {
      return newValue;
    },
    totalPrevPMProduct: function totalPrevPMProduct(newValue) {
      return newValue;
    },
    totalPrevPlanDaily: function totalPrevPlanDaily(newValue) {
      return newValue;
    },
    refreshOMSalesForecast: function () {
      var _refreshOMSalesForecast = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2(newValue) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                if (newValue === true) {
                  this.getProductionPlan();
                }

              case 1:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, this);
      }));

      function refreshOMSalesForecast(_x3) {
        return _refreshOMSalesForecast.apply(this, arguments);
      }

      return refreshOMSalesForecast;
    }()
  },
  methods: {
    getProductName: function getProductName() {
      var vm = this;
      vm.productTypes.filter(function (prod) {
        if (vm.productType == prod.lookup_code) {
          return vm.productName = prod.meaning;
        }
      });
    },
    getProductionPlan: function getProductionPlan() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var vm, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                vm = _this;
                vm.getProductName();

                if (vm.productType) {
                  _context3.next = 4;
                  break;
                }

                return _context3.abrupt("return");

              case 4:
                params = {
                  budget_year: vm.machineBiweekly ? vm.machineBiweekly.budget_year : null,
                  biweekly_id: vm.machineBiweekly ? vm.machineBiweekly.biweekly_id : null,
                  product_type: vm.productType,
                  daily_id: vm.dailyPlan.daily_id,
                  version_no: vm.version_no
                };
                vm.omSalesForecasts = '';
                vm.loading.omSalesForecastProcess = true;
                _context3.next = 9;
                return axios.get(vm.url.ajax_get_om_sales_forecast, {
                  params: params
                }).then(function (res) {
                  var valid = true;
                  vm.html = res.data.data.html;
                  vm.version_no = res.data.data.summary ? res.data.data.summary[0].version : 0;
                  vm.omSalesForecasts = res.data.data.summary;
                  vm.itemLists = res.data.data.itemByOmSales;
                  vm.totalEfficiencyP03 = res.data.data.totalEfficiencyP03;
                  vm.totalQuantity = res.data.data.totalQuantity;
                  vm.omSales = res.data.data.omSales;
                  vm.currOnhand = res.data.data.currOnhand; // ---------------------------------------------------------------------------

                  vm.pmProducts = res.data.data.pmProducts;
                  vm.prevTotalQuantity = res.data.data.prevTotalQuantity;
                  vm.$emit("omSalesForecast", vm.omSalesForecasts, vm.itemLists, false);
                  vm.alertSaleForcast();

                  if (res.data.data.status == 'E') {
                    valid = false;
                    swal({
                      title: 'ตรวจสอบข้อมูล',
                      text: '<span style="font-size: 16px; text-align: left;">' + res.data.data.msg + '</span>',
                      type: "info",
                      html: true
                    });
                  }

                  if (!valid) {
                    return;
                  }
                })["catch"](function (err) {
                  console.log('error');
                  console.log(err);
                }).then(function () {
                  vm.loading.omSalesForecastProcess = false;
                });

              case 9:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    getUnitProductType: function getUnitProductType() {
      if (this.productType == '71' || this.productType == '78') {
        this.unit = 'ล้านมวน';
      } else {
        this.unit = 'ล้านชิ้น';
      }
    },
    changeVersion: function changeVersion() {
      this.getProductionPlan();
    },
    alertSaleForcast: function alertSaleForcast() {
      var vm = this;
      vm.omSalesForecasts.filter(function (saleForecast) {
        var i = 0;
        i = vm.totalQuantity[saleForecast.item_code] ? saleForecast.forecast_million_qty - vm.totalQuantity[saleForecast.item_code][0] : saleForecast.forecast_million_qty - 0;
        Vue.set(vm.alertSaleForcasts, saleForecast.item_code, i);
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/PlanDaily.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/PlanDaily.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _ModalControl_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalControl.vue */ "./resources/js/components/Planning/Production-Daily/components/ModalControl.vue");


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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    ControlPlanDaily: _ModalControl_vue__WEBPACK_IMPORTED_MODULE_1__.default
  },
  props: ["machineBiweekly", "productDailyPlan", "modalControlInput", "budgetYears", "months", "biWeekly", "dateFormat", "productType", "btnTrans", "url", "search", "itemProductionMain", "isControlDisable", "messageCheckWKHHtml", "messageCheckMachineHtml", "isCurrBiweekly"],
  data: function data() {
    return {
      budget_year: this.search ? this.search.budget_year : '',
      month: this.search ? this.search.month : '',
      month_th: '',
      bi_weekly: this.search ? this.search.biweekly : '',
      times: '',
      loading: false,
      m_loading: false,
      b_loading: false,
      errors: {
        budget_year: false,
        month: false,
        bi_weekly: false
      },
      monthLists: [],
      biWeeklyLists: [],
      html: '',
      msg: {
        wkh: this.messageCheckWKHHtml,
        machine: this.messageCheckMachineHtml
      }
    };
  },
  mounted: function mounted() {
    this.getSearch();
    this.getMonth();
    this.getData();
  },
  computed: {},
  methods: {
    getData: function getData() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var vm, form, valid, errorMsg, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                vm = _this;
                form = $('#plan-daily-form');
                valid = true;
                errorMsg = '';
                vm.errors.budget_year = false;
                vm.errors.month = false;
                vm.errors.bi_weekly = false;
                $(form).find("div[id='el_explode_budget_year']").html("");
                $(form).find("div[id='el_explode_month']").html("");
                $(form).find("div[id='el_explode_bi_weekly']").html("");

                if (vm.budget_year == '' || vm.budget_year == null) {
                  vm.errors.budget_year = true;
                  valid = false;
                  errorMsg = "กรุณาเลือกปีงบประมาณ";
                  $(form).find("div[id='el_explode_budget_year']").html(errorMsg);
                }

                if (vm.month == '' || vm.month == null) {
                  vm.errors.month = true;
                  valid = false;
                  errorMsg = "กรุณาเลือกเดือน";
                  $(form).find("div[id='el_explode_month']").html(errorMsg);
                }

                if (vm.bi_weekly == '' || vm.bi_weekly == null) {
                  vm.errors.bi_weekly = true;
                  valid = false;
                  errorMsg = "กรุณาเลือกปักษ์";
                  $(form).find("div[id='el_explode_bi_weekly']").html(errorMsg);
                }

                if (valid) {
                  _context.next = 15;
                  break;
                }

                return _context.abrupt("return");

              case 15:
                vm.refreshData = vm.refreshData + 1;
                vm.loading = true;
                vm.html = '\ <div class="m-t-lg m-b-lg">\
                            <div class="text-center sk-spinner sk-spinner-wave">\
                                <div class="sk-rect1"></div>\
                                <div class="sk-rect2"></div>\
                                <div class="sk-rect3"></div>\
                                <div class="sk-rect4"></div>\
                                <div class="sk-rect5"></div>\
                            </div>\
                        </div>';
                params = {
                  product_type: vm.productType,
                  budget_year: vm.budget_year,
                  month: vm.month,
                  bi_weekly: vm.bi_weekly
                };
                _context.next = 21;
                return axios.get(vm.url.ajax_get_production_machine, {
                  params: params
                }).then(function (res) {
                  vm.html = res.data.data.html;
                })["catch"](function (err) {
                  // vm.html = res.data.data.html
                  var data = err.response.data;
                  alert(data.message);
                }).then(function () {
                  vm.loading = false;
                });

              case 21:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getSearch: function getSearch() {
      var _this2 = this;

      // this.monthLists = this.months.filter(item => {
      //     return item.thai_year.indexOf(this.budget_year) > -1;
      // });
      // this.biWeeklyLists = this.biWeekly.filter(item => {
      //     return item.period_num == this.month && item.thai_year.indexOf(this.budget_year) > -1;
      // });
      this.monthLists = this.months;
      this.biWeeklyLists = this.biWeekly.filter(function (item) {
        return item.period_num == _this2.month;
      });
    },
    getMonth: function getMonth() {
      var vm = this; // this.month = '';
      // this.bi_weekly = '';
      // vm.monthLists = vm.months.filter(item => {
      //     return item.thai_year.indexOf(vm.budget_year) > -1;
      // });

      vm.monthLists = vm.months;

      if (vm.monthLists[0].period_num == vm.month) {
        vm.month_th = vm.monthLists[0].thai_month;
      }
    },
    getBiWeekly: function getBiWeekly() {
      var _this3 = this;

      this.bi_weekly = ''; // this.biWeeklyLists = this.biWeekly.filter(item => {
      //     return item.period_num == this.month && item.thai_year.indexOf(this.budget_year) > -1;
      // });

      this.biWeeklyLists = this.biWeekly.filter(function (item) {
        return item.period_num == _this3.month;
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
    errorRef: function errorRef(res) {
      var vm = this;
      vm.errors.budget_year = res.err.budget_year;
      vm.errors.month = res.err.month;
      vm.errors.bi_weekly = res.err.bi_weekly;
    },
    reFetchDataP03: function reFetchDataP03() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var vm, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                vm = _this4;
                vm.html = '\ <div class="m-t-lg m-b-lg">\
                            <div class="text-center sk-spinner sk-spinner-wave">\
                                <div class="sk-rect1"></div>\
                                <div class="sk-rect2"></div>\
                                <div class="sk-rect3"></div>\
                                <div class="sk-rect4"></div>\
                                <div class="sk-rect5"></div>\
                            </div>\
                        </div>';
                params = {
                  product_type: vm.productType,
                  budget_year: vm.budget_year,
                  month: vm.month,
                  bi_weekly: vm.bi_weekly
                };
                _context2.next = 5;
                return axios.get(vm.url.ajax_update_working_hour, {
                  params: params
                }).then(function (res) {
                  swal({
                    title: '<h2 style="margin-top: 30px;"> เปลี่ยนแปลงชั่วโมงการทำงาน </h2>',
                    text: '<span style="font-size: 16px; text-align: left;"> อัพเดตการเปลี่ยนแปลงชั่วโมงการทำงานเรียบร้อยแล้ว </span>',
                    type: "success",
                    html: true
                  });

                  _this4.getData();

                  _this4.$emit("updateControlDisable", false);

                  _this4.msg.machine = '';
                  _this4.msg.wkh = '';
                })["catch"](function (err) {
                  var data = err.response.data;
                  swal({
                    title: 'มีข้อผิดพลาด',
                    text: '<span style="font-size: 16px; text-align: left;">' + data.message + '</span>',
                    type: "error",
                    html: true
                  });
                }).then(function () {// vm.html = '';
                });

              case 5:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    fetchDataP07: function fetchDataP07(res) {
      this.getData();
      this.$emit("fetchDataP07", res);
    }
  },
  watch: {
    productType: function () {
      var _productType = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3(value, oldValue) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                this.html = '';

              case 1:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3, this);
      }));

      function productType(_x, _x2) {
        return _productType.apply(this, arguments);
      }

      return productType;
    }(),
    errors: {
      handler: function handler(val) {
        val.budget_year ? this.setError('budget_year') : this.resetError('budget_year');
        val.month ? this.setError('month') : this.resetError('month');
        val.bi_weekly ? this.setError('bi_weekly') : this.resetError('bi_weekly');
      },
      deep: true
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/ItemPlan.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/ItemPlan.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, ".el-input--medium .el-input__inner {\n  height: 30px !important;\n  line-height: 36px;\n}\n.el-input--medium .el-input__icon {\n  line-height: 30px;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/List.vue?vue&type=style&index=0&media=screen&lang=css&":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/List.vue?vue&type=style&index=0&media=screen&lang=css& ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, "div.el-dialog__body{\n  padding-left: 50px;\n  padding-right: 50px;\n  padding-top: 5px;\n  padding-bottom: 5px;\n  color: #000;\n  font-size: 15px;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, ".el-input--medium .el-input__inner {\n  height: 30px !important;\n  line-height: 36px;\n}\n.el-input--medium .el-input__icon {\n  line-height: 30px;\n}\n.nav .label, .ibox .label {\n  font-size: 12px;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/PlanDaily.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/PlanDaily.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, ".el-input--medium .el-input__inner {\n  height: 30px !important;\n  line-height: 36px;\n}\n.el-input--medium .el-input__icon {\n  line-height: 30px;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/sortablejs/modular/sortable.esm.js":
/*!*********************************************************!*\
  !*** ./node_modules/sortablejs/modular/sortable.esm.js ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__,
/* harmony export */   "MultiDrag": () => /* binding */ MultiDragPlugin,
/* harmony export */   "Sortable": () => /* binding */ Sortable,
/* harmony export */   "Swap": () => /* binding */ SwapPlugin
/* harmony export */ });
/**!
 * Sortable 1.10.2
 * @author	RubaXa   <trash@rubaxa.org>
 * @author	owenm    <owen23355@gmail.com>
 * @license MIT
 */
function _typeof(obj) {
  if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") {
    _typeof = function (obj) {
      return typeof obj;
    };
  } else {
    _typeof = function (obj) {
      return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
    };
  }

  return _typeof(obj);
}

function _defineProperty(obj, key, value) {
  if (key in obj) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
  } else {
    obj[key] = value;
  }

  return obj;
}

function _extends() {
  _extends = Object.assign || function (target) {
    for (var i = 1; i < arguments.length; i++) {
      var source = arguments[i];

      for (var key in source) {
        if (Object.prototype.hasOwnProperty.call(source, key)) {
          target[key] = source[key];
        }
      }
    }

    return target;
  };

  return _extends.apply(this, arguments);
}

function _objectSpread(target) {
  for (var i = 1; i < arguments.length; i++) {
    var source = arguments[i] != null ? arguments[i] : {};
    var ownKeys = Object.keys(source);

    if (typeof Object.getOwnPropertySymbols === 'function') {
      ownKeys = ownKeys.concat(Object.getOwnPropertySymbols(source).filter(function (sym) {
        return Object.getOwnPropertyDescriptor(source, sym).enumerable;
      }));
    }

    ownKeys.forEach(function (key) {
      _defineProperty(target, key, source[key]);
    });
  }

  return target;
}

function _objectWithoutPropertiesLoose(source, excluded) {
  if (source == null) return {};
  var target = {};
  var sourceKeys = Object.keys(source);
  var key, i;

  for (i = 0; i < sourceKeys.length; i++) {
    key = sourceKeys[i];
    if (excluded.indexOf(key) >= 0) continue;
    target[key] = source[key];
  }

  return target;
}

function _objectWithoutProperties(source, excluded) {
  if (source == null) return {};

  var target = _objectWithoutPropertiesLoose(source, excluded);

  var key, i;

  if (Object.getOwnPropertySymbols) {
    var sourceSymbolKeys = Object.getOwnPropertySymbols(source);

    for (i = 0; i < sourceSymbolKeys.length; i++) {
      key = sourceSymbolKeys[i];
      if (excluded.indexOf(key) >= 0) continue;
      if (!Object.prototype.propertyIsEnumerable.call(source, key)) continue;
      target[key] = source[key];
    }
  }

  return target;
}

function _toConsumableArray(arr) {
  return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread();
}

function _arrayWithoutHoles(arr) {
  if (Array.isArray(arr)) {
    for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) arr2[i] = arr[i];

    return arr2;
  }
}

function _iterableToArray(iter) {
  if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter);
}

function _nonIterableSpread() {
  throw new TypeError("Invalid attempt to spread non-iterable instance");
}

var version = "1.10.2";

function userAgent(pattern) {
  if (typeof window !== 'undefined' && window.navigator) {
    return !!
    /*@__PURE__*/
    navigator.userAgent.match(pattern);
  }
}

var IE11OrLess = userAgent(/(?:Trident.*rv[ :]?11\.|msie|iemobile|Windows Phone)/i);
var Edge = userAgent(/Edge/i);
var FireFox = userAgent(/firefox/i);
var Safari = userAgent(/safari/i) && !userAgent(/chrome/i) && !userAgent(/android/i);
var IOS = userAgent(/iP(ad|od|hone)/i);
var ChromeForAndroid = userAgent(/chrome/i) && userAgent(/android/i);

var captureMode = {
  capture: false,
  passive: false
};

function on(el, event, fn) {
  el.addEventListener(event, fn, !IE11OrLess && captureMode);
}

function off(el, event, fn) {
  el.removeEventListener(event, fn, !IE11OrLess && captureMode);
}

function matches(
/**HTMLElement*/
el,
/**String*/
selector) {
  if (!selector) return;
  selector[0] === '>' && (selector = selector.substring(1));

  if (el) {
    try {
      if (el.matches) {
        return el.matches(selector);
      } else if (el.msMatchesSelector) {
        return el.msMatchesSelector(selector);
      } else if (el.webkitMatchesSelector) {
        return el.webkitMatchesSelector(selector);
      }
    } catch (_) {
      return false;
    }
  }

  return false;
}

function getParentOrHost(el) {
  return el.host && el !== document && el.host.nodeType ? el.host : el.parentNode;
}

function closest(
/**HTMLElement*/
el,
/**String*/
selector,
/**HTMLElement*/
ctx, includeCTX) {
  if (el) {
    ctx = ctx || document;

    do {
      if (selector != null && (selector[0] === '>' ? el.parentNode === ctx && matches(el, selector) : matches(el, selector)) || includeCTX && el === ctx) {
        return el;
      }

      if (el === ctx) break;
      /* jshint boss:true */
    } while (el = getParentOrHost(el));
  }

  return null;
}

var R_SPACE = /\s+/g;

function toggleClass(el, name, state) {
  if (el && name) {
    if (el.classList) {
      el.classList[state ? 'add' : 'remove'](name);
    } else {
      var className = (' ' + el.className + ' ').replace(R_SPACE, ' ').replace(' ' + name + ' ', ' ');
      el.className = (className + (state ? ' ' + name : '')).replace(R_SPACE, ' ');
    }
  }
}

function css(el, prop, val) {
  var style = el && el.style;

  if (style) {
    if (val === void 0) {
      if (document.defaultView && document.defaultView.getComputedStyle) {
        val = document.defaultView.getComputedStyle(el, '');
      } else if (el.currentStyle) {
        val = el.currentStyle;
      }

      return prop === void 0 ? val : val[prop];
    } else {
      if (!(prop in style) && prop.indexOf('webkit') === -1) {
        prop = '-webkit-' + prop;
      }

      style[prop] = val + (typeof val === 'string' ? '' : 'px');
    }
  }
}

function matrix(el, selfOnly) {
  var appliedTransforms = '';

  if (typeof el === 'string') {
    appliedTransforms = el;
  } else {
    do {
      var transform = css(el, 'transform');

      if (transform && transform !== 'none') {
        appliedTransforms = transform + ' ' + appliedTransforms;
      }
      /* jshint boss:true */

    } while (!selfOnly && (el = el.parentNode));
  }

  var matrixFn = window.DOMMatrix || window.WebKitCSSMatrix || window.CSSMatrix || window.MSCSSMatrix;
  /*jshint -W056 */

  return matrixFn && new matrixFn(appliedTransforms);
}

function find(ctx, tagName, iterator) {
  if (ctx) {
    var list = ctx.getElementsByTagName(tagName),
        i = 0,
        n = list.length;

    if (iterator) {
      for (; i < n; i++) {
        iterator(list[i], i);
      }
    }

    return list;
  }

  return [];
}

function getWindowScrollingElement() {
  var scrollingElement = document.scrollingElement;

  if (scrollingElement) {
    return scrollingElement;
  } else {
    return document.documentElement;
  }
}
/**
 * Returns the "bounding client rect" of given element
 * @param  {HTMLElement} el                       The element whose boundingClientRect is wanted
 * @param  {[Boolean]} relativeToContainingBlock  Whether the rect should be relative to the containing block of (including) the container
 * @param  {[Boolean]} relativeToNonStaticParent  Whether the rect should be relative to the relative parent of (including) the contaienr
 * @param  {[Boolean]} undoScale                  Whether the container's scale() should be undone
 * @param  {[HTMLElement]} container              The parent the element will be placed in
 * @return {Object}                               The boundingClientRect of el, with specified adjustments
 */


function getRect(el, relativeToContainingBlock, relativeToNonStaticParent, undoScale, container) {
  if (!el.getBoundingClientRect && el !== window) return;
  var elRect, top, left, bottom, right, height, width;

  if (el !== window && el !== getWindowScrollingElement()) {
    elRect = el.getBoundingClientRect();
    top = elRect.top;
    left = elRect.left;
    bottom = elRect.bottom;
    right = elRect.right;
    height = elRect.height;
    width = elRect.width;
  } else {
    top = 0;
    left = 0;
    bottom = window.innerHeight;
    right = window.innerWidth;
    height = window.innerHeight;
    width = window.innerWidth;
  }

  if ((relativeToContainingBlock || relativeToNonStaticParent) && el !== window) {
    // Adjust for translate()
    container = container || el.parentNode; // solves #1123 (see: https://stackoverflow.com/a/37953806/6088312)
    // Not needed on <= IE11

    if (!IE11OrLess) {
      do {
        if (container && container.getBoundingClientRect && (css(container, 'transform') !== 'none' || relativeToNonStaticParent && css(container, 'position') !== 'static')) {
          var containerRect = container.getBoundingClientRect(); // Set relative to edges of padding box of container

          top -= containerRect.top + parseInt(css(container, 'border-top-width'));
          left -= containerRect.left + parseInt(css(container, 'border-left-width'));
          bottom = top + elRect.height;
          right = left + elRect.width;
          break;
        }
        /* jshint boss:true */

      } while (container = container.parentNode);
    }
  }

  if (undoScale && el !== window) {
    // Adjust for scale()
    var elMatrix = matrix(container || el),
        scaleX = elMatrix && elMatrix.a,
        scaleY = elMatrix && elMatrix.d;

    if (elMatrix) {
      top /= scaleY;
      left /= scaleX;
      width /= scaleX;
      height /= scaleY;
      bottom = top + height;
      right = left + width;
    }
  }

  return {
    top: top,
    left: left,
    bottom: bottom,
    right: right,
    width: width,
    height: height
  };
}
/**
 * Checks if a side of an element is scrolled past a side of its parents
 * @param  {HTMLElement}  el           The element who's side being scrolled out of view is in question
 * @param  {String}       elSide       Side of the element in question ('top', 'left', 'right', 'bottom')
 * @param  {String}       parentSide   Side of the parent in question ('top', 'left', 'right', 'bottom')
 * @return {HTMLElement}               The parent scroll element that the el's side is scrolled past, or null if there is no such element
 */


function isScrolledPast(el, elSide, parentSide) {
  var parent = getParentAutoScrollElement(el, true),
      elSideVal = getRect(el)[elSide];
  /* jshint boss:true */

  while (parent) {
    var parentSideVal = getRect(parent)[parentSide],
        visible = void 0;

    if (parentSide === 'top' || parentSide === 'left') {
      visible = elSideVal >= parentSideVal;
    } else {
      visible = elSideVal <= parentSideVal;
    }

    if (!visible) return parent;
    if (parent === getWindowScrollingElement()) break;
    parent = getParentAutoScrollElement(parent, false);
  }

  return false;
}
/**
 * Gets nth child of el, ignoring hidden children, sortable's elements (does not ignore clone if it's visible)
 * and non-draggable elements
 * @param  {HTMLElement} el       The parent element
 * @param  {Number} childNum      The index of the child
 * @param  {Object} options       Parent Sortable's options
 * @return {HTMLElement}          The child at index childNum, or null if not found
 */


function getChild(el, childNum, options) {
  var currentChild = 0,
      i = 0,
      children = el.children;

  while (i < children.length) {
    if (children[i].style.display !== 'none' && children[i] !== Sortable.ghost && children[i] !== Sortable.dragged && closest(children[i], options.draggable, el, false)) {
      if (currentChild === childNum) {
        return children[i];
      }

      currentChild++;
    }

    i++;
  }

  return null;
}
/**
 * Gets the last child in the el, ignoring ghostEl or invisible elements (clones)
 * @param  {HTMLElement} el       Parent element
 * @param  {selector} selector    Any other elements that should be ignored
 * @return {HTMLElement}          The last child, ignoring ghostEl
 */


function lastChild(el, selector) {
  var last = el.lastElementChild;

  while (last && (last === Sortable.ghost || css(last, 'display') === 'none' || selector && !matches(last, selector))) {
    last = last.previousElementSibling;
  }

  return last || null;
}
/**
 * Returns the index of an element within its parent for a selected set of
 * elements
 * @param  {HTMLElement} el
 * @param  {selector} selector
 * @return {number}
 */


function index(el, selector) {
  var index = 0;

  if (!el || !el.parentNode) {
    return -1;
  }
  /* jshint boss:true */


  while (el = el.previousElementSibling) {
    if (el.nodeName.toUpperCase() !== 'TEMPLATE' && el !== Sortable.clone && (!selector || matches(el, selector))) {
      index++;
    }
  }

  return index;
}
/**
 * Returns the scroll offset of the given element, added with all the scroll offsets of parent elements.
 * The value is returned in real pixels.
 * @param  {HTMLElement} el
 * @return {Array}             Offsets in the format of [left, top]
 */


function getRelativeScrollOffset(el) {
  var offsetLeft = 0,
      offsetTop = 0,
      winScroller = getWindowScrollingElement();

  if (el) {
    do {
      var elMatrix = matrix(el),
          scaleX = elMatrix.a,
          scaleY = elMatrix.d;
      offsetLeft += el.scrollLeft * scaleX;
      offsetTop += el.scrollTop * scaleY;
    } while (el !== winScroller && (el = el.parentNode));
  }

  return [offsetLeft, offsetTop];
}
/**
 * Returns the index of the object within the given array
 * @param  {Array} arr   Array that may or may not hold the object
 * @param  {Object} obj  An object that has a key-value pair unique to and identical to a key-value pair in the object you want to find
 * @return {Number}      The index of the object in the array, or -1
 */


function indexOfObject(arr, obj) {
  for (var i in arr) {
    if (!arr.hasOwnProperty(i)) continue;

    for (var key in obj) {
      if (obj.hasOwnProperty(key) && obj[key] === arr[i][key]) return Number(i);
    }
  }

  return -1;
}

function getParentAutoScrollElement(el, includeSelf) {
  // skip to window
  if (!el || !el.getBoundingClientRect) return getWindowScrollingElement();
  var elem = el;
  var gotSelf = false;

  do {
    // we don't need to get elem css if it isn't even overflowing in the first place (performance)
    if (elem.clientWidth < elem.scrollWidth || elem.clientHeight < elem.scrollHeight) {
      var elemCSS = css(elem);

      if (elem.clientWidth < elem.scrollWidth && (elemCSS.overflowX == 'auto' || elemCSS.overflowX == 'scroll') || elem.clientHeight < elem.scrollHeight && (elemCSS.overflowY == 'auto' || elemCSS.overflowY == 'scroll')) {
        if (!elem.getBoundingClientRect || elem === document.body) return getWindowScrollingElement();
        if (gotSelf || includeSelf) return elem;
        gotSelf = true;
      }
    }
    /* jshint boss:true */

  } while (elem = elem.parentNode);

  return getWindowScrollingElement();
}

function extend(dst, src) {
  if (dst && src) {
    for (var key in src) {
      if (src.hasOwnProperty(key)) {
        dst[key] = src[key];
      }
    }
  }

  return dst;
}

function isRectEqual(rect1, rect2) {
  return Math.round(rect1.top) === Math.round(rect2.top) && Math.round(rect1.left) === Math.round(rect2.left) && Math.round(rect1.height) === Math.round(rect2.height) && Math.round(rect1.width) === Math.round(rect2.width);
}

var _throttleTimeout;

function throttle(callback, ms) {
  return function () {
    if (!_throttleTimeout) {
      var args = arguments,
          _this = this;

      if (args.length === 1) {
        callback.call(_this, args[0]);
      } else {
        callback.apply(_this, args);
      }

      _throttleTimeout = setTimeout(function () {
        _throttleTimeout = void 0;
      }, ms);
    }
  };
}

function cancelThrottle() {
  clearTimeout(_throttleTimeout);
  _throttleTimeout = void 0;
}

function scrollBy(el, x, y) {
  el.scrollLeft += x;
  el.scrollTop += y;
}

function clone(el) {
  var Polymer = window.Polymer;
  var $ = window.jQuery || window.Zepto;

  if (Polymer && Polymer.dom) {
    return Polymer.dom(el).cloneNode(true);
  } else if ($) {
    return $(el).clone(true)[0];
  } else {
    return el.cloneNode(true);
  }
}

function setRect(el, rect) {
  css(el, 'position', 'absolute');
  css(el, 'top', rect.top);
  css(el, 'left', rect.left);
  css(el, 'width', rect.width);
  css(el, 'height', rect.height);
}

function unsetRect(el) {
  css(el, 'position', '');
  css(el, 'top', '');
  css(el, 'left', '');
  css(el, 'width', '');
  css(el, 'height', '');
}

var expando = 'Sortable' + new Date().getTime();

function AnimationStateManager() {
  var animationStates = [],
      animationCallbackId;
  return {
    captureAnimationState: function captureAnimationState() {
      animationStates = [];
      if (!this.options.animation) return;
      var children = [].slice.call(this.el.children);
      children.forEach(function (child) {
        if (css(child, 'display') === 'none' || child === Sortable.ghost) return;
        animationStates.push({
          target: child,
          rect: getRect(child)
        });

        var fromRect = _objectSpread({}, animationStates[animationStates.length - 1].rect); // If animating: compensate for current animation


        if (child.thisAnimationDuration) {
          var childMatrix = matrix(child, true);

          if (childMatrix) {
            fromRect.top -= childMatrix.f;
            fromRect.left -= childMatrix.e;
          }
        }

        child.fromRect = fromRect;
      });
    },
    addAnimationState: function addAnimationState(state) {
      animationStates.push(state);
    },
    removeAnimationState: function removeAnimationState(target) {
      animationStates.splice(indexOfObject(animationStates, {
        target: target
      }), 1);
    },
    animateAll: function animateAll(callback) {
      var _this = this;

      if (!this.options.animation) {
        clearTimeout(animationCallbackId);
        if (typeof callback === 'function') callback();
        return;
      }

      var animating = false,
          animationTime = 0;
      animationStates.forEach(function (state) {
        var time = 0,
            target = state.target,
            fromRect = target.fromRect,
            toRect = getRect(target),
            prevFromRect = target.prevFromRect,
            prevToRect = target.prevToRect,
            animatingRect = state.rect,
            targetMatrix = matrix(target, true);

        if (targetMatrix) {
          // Compensate for current animation
          toRect.top -= targetMatrix.f;
          toRect.left -= targetMatrix.e;
        }

        target.toRect = toRect;

        if (target.thisAnimationDuration) {
          // Could also check if animatingRect is between fromRect and toRect
          if (isRectEqual(prevFromRect, toRect) && !isRectEqual(fromRect, toRect) && // Make sure animatingRect is on line between toRect & fromRect
          (animatingRect.top - toRect.top) / (animatingRect.left - toRect.left) === (fromRect.top - toRect.top) / (fromRect.left - toRect.left)) {
            // If returning to same place as started from animation and on same axis
            time = calculateRealTime(animatingRect, prevFromRect, prevToRect, _this.options);
          }
        } // if fromRect != toRect: animate


        if (!isRectEqual(toRect, fromRect)) {
          target.prevFromRect = fromRect;
          target.prevToRect = toRect;

          if (!time) {
            time = _this.options.animation;
          }

          _this.animate(target, animatingRect, toRect, time);
        }

        if (time) {
          animating = true;
          animationTime = Math.max(animationTime, time);
          clearTimeout(target.animationResetTimer);
          target.animationResetTimer = setTimeout(function () {
            target.animationTime = 0;
            target.prevFromRect = null;
            target.fromRect = null;
            target.prevToRect = null;
            target.thisAnimationDuration = null;
          }, time);
          target.thisAnimationDuration = time;
        }
      });
      clearTimeout(animationCallbackId);

      if (!animating) {
        if (typeof callback === 'function') callback();
      } else {
        animationCallbackId = setTimeout(function () {
          if (typeof callback === 'function') callback();
        }, animationTime);
      }

      animationStates = [];
    },
    animate: function animate(target, currentRect, toRect, duration) {
      if (duration) {
        css(target, 'transition', '');
        css(target, 'transform', '');
        var elMatrix = matrix(this.el),
            scaleX = elMatrix && elMatrix.a,
            scaleY = elMatrix && elMatrix.d,
            translateX = (currentRect.left - toRect.left) / (scaleX || 1),
            translateY = (currentRect.top - toRect.top) / (scaleY || 1);
        target.animatingX = !!translateX;
        target.animatingY = !!translateY;
        css(target, 'transform', 'translate3d(' + translateX + 'px,' + translateY + 'px,0)');
        repaint(target); // repaint

        css(target, 'transition', 'transform ' + duration + 'ms' + (this.options.easing ? ' ' + this.options.easing : ''));
        css(target, 'transform', 'translate3d(0,0,0)');
        typeof target.animated === 'number' && clearTimeout(target.animated);
        target.animated = setTimeout(function () {
          css(target, 'transition', '');
          css(target, 'transform', '');
          target.animated = false;
          target.animatingX = false;
          target.animatingY = false;
        }, duration);
      }
    }
  };
}

function repaint(target) {
  return target.offsetWidth;
}

function calculateRealTime(animatingRect, fromRect, toRect, options) {
  return Math.sqrt(Math.pow(fromRect.top - animatingRect.top, 2) + Math.pow(fromRect.left - animatingRect.left, 2)) / Math.sqrt(Math.pow(fromRect.top - toRect.top, 2) + Math.pow(fromRect.left - toRect.left, 2)) * options.animation;
}

var plugins = [];
var defaults = {
  initializeByDefault: true
};
var PluginManager = {
  mount: function mount(plugin) {
    // Set default static properties
    for (var option in defaults) {
      if (defaults.hasOwnProperty(option) && !(option in plugin)) {
        plugin[option] = defaults[option];
      }
    }

    plugins.push(plugin);
  },
  pluginEvent: function pluginEvent(eventName, sortable, evt) {
    var _this = this;

    this.eventCanceled = false;

    evt.cancel = function () {
      _this.eventCanceled = true;
    };

    var eventNameGlobal = eventName + 'Global';
    plugins.forEach(function (plugin) {
      if (!sortable[plugin.pluginName]) return; // Fire global events if it exists in this sortable

      if (sortable[plugin.pluginName][eventNameGlobal]) {
        sortable[plugin.pluginName][eventNameGlobal](_objectSpread({
          sortable: sortable
        }, evt));
      } // Only fire plugin event if plugin is enabled in this sortable,
      // and plugin has event defined


      if (sortable.options[plugin.pluginName] && sortable[plugin.pluginName][eventName]) {
        sortable[plugin.pluginName][eventName](_objectSpread({
          sortable: sortable
        }, evt));
      }
    });
  },
  initializePlugins: function initializePlugins(sortable, el, defaults, options) {
    plugins.forEach(function (plugin) {
      var pluginName = plugin.pluginName;
      if (!sortable.options[pluginName] && !plugin.initializeByDefault) return;
      var initialized = new plugin(sortable, el, sortable.options);
      initialized.sortable = sortable;
      initialized.options = sortable.options;
      sortable[pluginName] = initialized; // Add default options from plugin

      _extends(defaults, initialized.defaults);
    });

    for (var option in sortable.options) {
      if (!sortable.options.hasOwnProperty(option)) continue;
      var modified = this.modifyOption(sortable, option, sortable.options[option]);

      if (typeof modified !== 'undefined') {
        sortable.options[option] = modified;
      }
    }
  },
  getEventProperties: function getEventProperties(name, sortable) {
    var eventProperties = {};
    plugins.forEach(function (plugin) {
      if (typeof plugin.eventProperties !== 'function') return;

      _extends(eventProperties, plugin.eventProperties.call(sortable[plugin.pluginName], name));
    });
    return eventProperties;
  },
  modifyOption: function modifyOption(sortable, name, value) {
    var modifiedValue;
    plugins.forEach(function (plugin) {
      // Plugin must exist on the Sortable
      if (!sortable[plugin.pluginName]) return; // If static option listener exists for this option, call in the context of the Sortable's instance of this plugin

      if (plugin.optionListeners && typeof plugin.optionListeners[name] === 'function') {
        modifiedValue = plugin.optionListeners[name].call(sortable[plugin.pluginName], value);
      }
    });
    return modifiedValue;
  }
};

function dispatchEvent(_ref) {
  var sortable = _ref.sortable,
      rootEl = _ref.rootEl,
      name = _ref.name,
      targetEl = _ref.targetEl,
      cloneEl = _ref.cloneEl,
      toEl = _ref.toEl,
      fromEl = _ref.fromEl,
      oldIndex = _ref.oldIndex,
      newIndex = _ref.newIndex,
      oldDraggableIndex = _ref.oldDraggableIndex,
      newDraggableIndex = _ref.newDraggableIndex,
      originalEvent = _ref.originalEvent,
      putSortable = _ref.putSortable,
      extraEventProperties = _ref.extraEventProperties;
  sortable = sortable || rootEl && rootEl[expando];
  if (!sortable) return;
  var evt,
      options = sortable.options,
      onName = 'on' + name.charAt(0).toUpperCase() + name.substr(1); // Support for new CustomEvent feature

  if (window.CustomEvent && !IE11OrLess && !Edge) {
    evt = new CustomEvent(name, {
      bubbles: true,
      cancelable: true
    });
  } else {
    evt = document.createEvent('Event');
    evt.initEvent(name, true, true);
  }

  evt.to = toEl || rootEl;
  evt.from = fromEl || rootEl;
  evt.item = targetEl || rootEl;
  evt.clone = cloneEl;
  evt.oldIndex = oldIndex;
  evt.newIndex = newIndex;
  evt.oldDraggableIndex = oldDraggableIndex;
  evt.newDraggableIndex = newDraggableIndex;
  evt.originalEvent = originalEvent;
  evt.pullMode = putSortable ? putSortable.lastPutMode : undefined;

  var allEventProperties = _objectSpread({}, extraEventProperties, PluginManager.getEventProperties(name, sortable));

  for (var option in allEventProperties) {
    evt[option] = allEventProperties[option];
  }

  if (rootEl) {
    rootEl.dispatchEvent(evt);
  }

  if (options[onName]) {
    options[onName].call(sortable, evt);
  }
}

var pluginEvent = function pluginEvent(eventName, sortable) {
  var _ref = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {},
      originalEvent = _ref.evt,
      data = _objectWithoutProperties(_ref, ["evt"]);

  PluginManager.pluginEvent.bind(Sortable)(eventName, sortable, _objectSpread({
    dragEl: dragEl,
    parentEl: parentEl,
    ghostEl: ghostEl,
    rootEl: rootEl,
    nextEl: nextEl,
    lastDownEl: lastDownEl,
    cloneEl: cloneEl,
    cloneHidden: cloneHidden,
    dragStarted: moved,
    putSortable: putSortable,
    activeSortable: Sortable.active,
    originalEvent: originalEvent,
    oldIndex: oldIndex,
    oldDraggableIndex: oldDraggableIndex,
    newIndex: newIndex,
    newDraggableIndex: newDraggableIndex,
    hideGhostForTarget: _hideGhostForTarget,
    unhideGhostForTarget: _unhideGhostForTarget,
    cloneNowHidden: function cloneNowHidden() {
      cloneHidden = true;
    },
    cloneNowShown: function cloneNowShown() {
      cloneHidden = false;
    },
    dispatchSortableEvent: function dispatchSortableEvent(name) {
      _dispatchEvent({
        sortable: sortable,
        name: name,
        originalEvent: originalEvent
      });
    }
  }, data));
};

function _dispatchEvent(info) {
  dispatchEvent(_objectSpread({
    putSortable: putSortable,
    cloneEl: cloneEl,
    targetEl: dragEl,
    rootEl: rootEl,
    oldIndex: oldIndex,
    oldDraggableIndex: oldDraggableIndex,
    newIndex: newIndex,
    newDraggableIndex: newDraggableIndex
  }, info));
}

var dragEl,
    parentEl,
    ghostEl,
    rootEl,
    nextEl,
    lastDownEl,
    cloneEl,
    cloneHidden,
    oldIndex,
    newIndex,
    oldDraggableIndex,
    newDraggableIndex,
    activeGroup,
    putSortable,
    awaitingDragStarted = false,
    ignoreNextClick = false,
    sortables = [],
    tapEvt,
    touchEvt,
    lastDx,
    lastDy,
    tapDistanceLeft,
    tapDistanceTop,
    moved,
    lastTarget,
    lastDirection,
    pastFirstInvertThresh = false,
    isCircumstantialInvert = false,
    targetMoveDistance,
    // For positioning ghost absolutely
ghostRelativeParent,
    ghostRelativeParentInitialScroll = [],
    // (left, top)
_silent = false,
    savedInputChecked = [];
/** @const */

var documentExists = typeof document !== 'undefined',
    PositionGhostAbsolutely = IOS,
    CSSFloatProperty = Edge || IE11OrLess ? 'cssFloat' : 'float',
    // This will not pass for IE9, because IE9 DnD only works on anchors
supportDraggable = documentExists && !ChromeForAndroid && !IOS && 'draggable' in document.createElement('div'),
    supportCssPointerEvents = function () {
  if (!documentExists) return; // false when <= IE11

  if (IE11OrLess) {
    return false;
  }

  var el = document.createElement('x');
  el.style.cssText = 'pointer-events:auto';
  return el.style.pointerEvents === 'auto';
}(),
    _detectDirection = function _detectDirection(el, options) {
  var elCSS = css(el),
      elWidth = parseInt(elCSS.width) - parseInt(elCSS.paddingLeft) - parseInt(elCSS.paddingRight) - parseInt(elCSS.borderLeftWidth) - parseInt(elCSS.borderRightWidth),
      child1 = getChild(el, 0, options),
      child2 = getChild(el, 1, options),
      firstChildCSS = child1 && css(child1),
      secondChildCSS = child2 && css(child2),
      firstChildWidth = firstChildCSS && parseInt(firstChildCSS.marginLeft) + parseInt(firstChildCSS.marginRight) + getRect(child1).width,
      secondChildWidth = secondChildCSS && parseInt(secondChildCSS.marginLeft) + parseInt(secondChildCSS.marginRight) + getRect(child2).width;

  if (elCSS.display === 'flex') {
    return elCSS.flexDirection === 'column' || elCSS.flexDirection === 'column-reverse' ? 'vertical' : 'horizontal';
  }

  if (elCSS.display === 'grid') {
    return elCSS.gridTemplateColumns.split(' ').length <= 1 ? 'vertical' : 'horizontal';
  }

  if (child1 && firstChildCSS["float"] && firstChildCSS["float"] !== 'none') {
    var touchingSideChild2 = firstChildCSS["float"] === 'left' ? 'left' : 'right';
    return child2 && (secondChildCSS.clear === 'both' || secondChildCSS.clear === touchingSideChild2) ? 'vertical' : 'horizontal';
  }

  return child1 && (firstChildCSS.display === 'block' || firstChildCSS.display === 'flex' || firstChildCSS.display === 'table' || firstChildCSS.display === 'grid' || firstChildWidth >= elWidth && elCSS[CSSFloatProperty] === 'none' || child2 && elCSS[CSSFloatProperty] === 'none' && firstChildWidth + secondChildWidth > elWidth) ? 'vertical' : 'horizontal';
},
    _dragElInRowColumn = function _dragElInRowColumn(dragRect, targetRect, vertical) {
  var dragElS1Opp = vertical ? dragRect.left : dragRect.top,
      dragElS2Opp = vertical ? dragRect.right : dragRect.bottom,
      dragElOppLength = vertical ? dragRect.width : dragRect.height,
      targetS1Opp = vertical ? targetRect.left : targetRect.top,
      targetS2Opp = vertical ? targetRect.right : targetRect.bottom,
      targetOppLength = vertical ? targetRect.width : targetRect.height;
  return dragElS1Opp === targetS1Opp || dragElS2Opp === targetS2Opp || dragElS1Opp + dragElOppLength / 2 === targetS1Opp + targetOppLength / 2;
},

/**
 * Detects first nearest empty sortable to X and Y position using emptyInsertThreshold.
 * @param  {Number} x      X position
 * @param  {Number} y      Y position
 * @return {HTMLElement}   Element of the first found nearest Sortable
 */
_detectNearestEmptySortable = function _detectNearestEmptySortable(x, y) {
  var ret;
  sortables.some(function (sortable) {
    if (lastChild(sortable)) return;
    var rect = getRect(sortable),
        threshold = sortable[expando].options.emptyInsertThreshold,
        insideHorizontally = x >= rect.left - threshold && x <= rect.right + threshold,
        insideVertically = y >= rect.top - threshold && y <= rect.bottom + threshold;

    if (threshold && insideHorizontally && insideVertically) {
      return ret = sortable;
    }
  });
  return ret;
},
    _prepareGroup = function _prepareGroup(options) {
  function toFn(value, pull) {
    return function (to, from, dragEl, evt) {
      var sameGroup = to.options.group.name && from.options.group.name && to.options.group.name === from.options.group.name;

      if (value == null && (pull || sameGroup)) {
        // Default pull value
        // Default pull and put value if same group
        return true;
      } else if (value == null || value === false) {
        return false;
      } else if (pull && value === 'clone') {
        return value;
      } else if (typeof value === 'function') {
        return toFn(value(to, from, dragEl, evt), pull)(to, from, dragEl, evt);
      } else {
        var otherGroup = (pull ? to : from).options.group.name;
        return value === true || typeof value === 'string' && value === otherGroup || value.join && value.indexOf(otherGroup) > -1;
      }
    };
  }

  var group = {};
  var originalGroup = options.group;

  if (!originalGroup || _typeof(originalGroup) != 'object') {
    originalGroup = {
      name: originalGroup
    };
  }

  group.name = originalGroup.name;
  group.checkPull = toFn(originalGroup.pull, true);
  group.checkPut = toFn(originalGroup.put);
  group.revertClone = originalGroup.revertClone;
  options.group = group;
},
    _hideGhostForTarget = function _hideGhostForTarget() {
  if (!supportCssPointerEvents && ghostEl) {
    css(ghostEl, 'display', 'none');
  }
},
    _unhideGhostForTarget = function _unhideGhostForTarget() {
  if (!supportCssPointerEvents && ghostEl) {
    css(ghostEl, 'display', '');
  }
}; // #1184 fix - Prevent click event on fallback if dragged but item not changed position


if (documentExists) {
  document.addEventListener('click', function (evt) {
    if (ignoreNextClick) {
      evt.preventDefault();
      evt.stopPropagation && evt.stopPropagation();
      evt.stopImmediatePropagation && evt.stopImmediatePropagation();
      ignoreNextClick = false;
      return false;
    }
  }, true);
}

var nearestEmptyInsertDetectEvent = function nearestEmptyInsertDetectEvent(evt) {
  if (dragEl) {
    evt = evt.touches ? evt.touches[0] : evt;

    var nearest = _detectNearestEmptySortable(evt.clientX, evt.clientY);

    if (nearest) {
      // Create imitation event
      var event = {};

      for (var i in evt) {
        if (evt.hasOwnProperty(i)) {
          event[i] = evt[i];
        }
      }

      event.target = event.rootEl = nearest;
      event.preventDefault = void 0;
      event.stopPropagation = void 0;

      nearest[expando]._onDragOver(event);
    }
  }
};

var _checkOutsideTargetEl = function _checkOutsideTargetEl(evt) {
  if (dragEl) {
    dragEl.parentNode[expando]._isOutsideThisEl(evt.target);
  }
};
/**
 * @class  Sortable
 * @param  {HTMLElement}  el
 * @param  {Object}       [options]
 */


function Sortable(el, options) {
  if (!(el && el.nodeType && el.nodeType === 1)) {
    throw "Sortable: `el` must be an HTMLElement, not ".concat({}.toString.call(el));
  }

  this.el = el; // root element

  this.options = options = _extends({}, options); // Export instance

  el[expando] = this;
  var defaults = {
    group: null,
    sort: true,
    disabled: false,
    store: null,
    handle: null,
    draggable: /^[uo]l$/i.test(el.nodeName) ? '>li' : '>*',
    swapThreshold: 1,
    // percentage; 0 <= x <= 1
    invertSwap: false,
    // invert always
    invertedSwapThreshold: null,
    // will be set to same as swapThreshold if default
    removeCloneOnHide: true,
    direction: function direction() {
      return _detectDirection(el, this.options);
    },
    ghostClass: 'sortable-ghost',
    chosenClass: 'sortable-chosen',
    dragClass: 'sortable-drag',
    ignore: 'a, img',
    filter: null,
    preventOnFilter: true,
    animation: 0,
    easing: null,
    setData: function setData(dataTransfer, dragEl) {
      dataTransfer.setData('Text', dragEl.textContent);
    },
    dropBubble: false,
    dragoverBubble: false,
    dataIdAttr: 'data-id',
    delay: 0,
    delayOnTouchOnly: false,
    touchStartThreshold: (Number.parseInt ? Number : window).parseInt(window.devicePixelRatio, 10) || 1,
    forceFallback: false,
    fallbackClass: 'sortable-fallback',
    fallbackOnBody: false,
    fallbackTolerance: 0,
    fallbackOffset: {
      x: 0,
      y: 0
    },
    supportPointer: Sortable.supportPointer !== false && 'PointerEvent' in window,
    emptyInsertThreshold: 5
  };
  PluginManager.initializePlugins(this, el, defaults); // Set default options

  for (var name in defaults) {
    !(name in options) && (options[name] = defaults[name]);
  }

  _prepareGroup(options); // Bind all private methods


  for (var fn in this) {
    if (fn.charAt(0) === '_' && typeof this[fn] === 'function') {
      this[fn] = this[fn].bind(this);
    }
  } // Setup drag mode


  this.nativeDraggable = options.forceFallback ? false : supportDraggable;

  if (this.nativeDraggable) {
    // Touch start threshold cannot be greater than the native dragstart threshold
    this.options.touchStartThreshold = 1;
  } // Bind events


  if (options.supportPointer) {
    on(el, 'pointerdown', this._onTapStart);
  } else {
    on(el, 'mousedown', this._onTapStart);
    on(el, 'touchstart', this._onTapStart);
  }

  if (this.nativeDraggable) {
    on(el, 'dragover', this);
    on(el, 'dragenter', this);
  }

  sortables.push(this.el); // Restore sorting

  options.store && options.store.get && this.sort(options.store.get(this) || []); // Add animation state manager

  _extends(this, AnimationStateManager());
}

Sortable.prototype =
/** @lends Sortable.prototype */
{
  constructor: Sortable,
  _isOutsideThisEl: function _isOutsideThisEl(target) {
    if (!this.el.contains(target) && target !== this.el) {
      lastTarget = null;
    }
  },
  _getDirection: function _getDirection(evt, target) {
    return typeof this.options.direction === 'function' ? this.options.direction.call(this, evt, target, dragEl) : this.options.direction;
  },
  _onTapStart: function _onTapStart(
  /** Event|TouchEvent */
  evt) {
    if (!evt.cancelable) return;

    var _this = this,
        el = this.el,
        options = this.options,
        preventOnFilter = options.preventOnFilter,
        type = evt.type,
        touch = evt.touches && evt.touches[0] || evt.pointerType && evt.pointerType === 'touch' && evt,
        target = (touch || evt).target,
        originalTarget = evt.target.shadowRoot && (evt.path && evt.path[0] || evt.composedPath && evt.composedPath()[0]) || target,
        filter = options.filter;

    _saveInputCheckedState(el); // Don't trigger start event when an element is been dragged, otherwise the evt.oldindex always wrong when set option.group.


    if (dragEl) {
      return;
    }

    if (/mousedown|pointerdown/.test(type) && evt.button !== 0 || options.disabled) {
      return; // only left button and enabled
    } // cancel dnd if original target is content editable


    if (originalTarget.isContentEditable) {
      return;
    }

    target = closest(target, options.draggable, el, false);

    if (target && target.animated) {
      return;
    }

    if (lastDownEl === target) {
      // Ignoring duplicate `down`
      return;
    } // Get the index of the dragged element within its parent


    oldIndex = index(target);
    oldDraggableIndex = index(target, options.draggable); // Check filter

    if (typeof filter === 'function') {
      if (filter.call(this, evt, target, this)) {
        _dispatchEvent({
          sortable: _this,
          rootEl: originalTarget,
          name: 'filter',
          targetEl: target,
          toEl: el,
          fromEl: el
        });

        pluginEvent('filter', _this, {
          evt: evt
        });
        preventOnFilter && evt.cancelable && evt.preventDefault();
        return; // cancel dnd
      }
    } else if (filter) {
      filter = filter.split(',').some(function (criteria) {
        criteria = closest(originalTarget, criteria.trim(), el, false);

        if (criteria) {
          _dispatchEvent({
            sortable: _this,
            rootEl: criteria,
            name: 'filter',
            targetEl: target,
            fromEl: el,
            toEl: el
          });

          pluginEvent('filter', _this, {
            evt: evt
          });
          return true;
        }
      });

      if (filter) {
        preventOnFilter && evt.cancelable && evt.preventDefault();
        return; // cancel dnd
      }
    }

    if (options.handle && !closest(originalTarget, options.handle, el, false)) {
      return;
    } // Prepare `dragstart`


    this._prepareDragStart(evt, touch, target);
  },
  _prepareDragStart: function _prepareDragStart(
  /** Event */
  evt,
  /** Touch */
  touch,
  /** HTMLElement */
  target) {
    var _this = this,
        el = _this.el,
        options = _this.options,
        ownerDocument = el.ownerDocument,
        dragStartFn;

    if (target && !dragEl && target.parentNode === el) {
      var dragRect = getRect(target);
      rootEl = el;
      dragEl = target;
      parentEl = dragEl.parentNode;
      nextEl = dragEl.nextSibling;
      lastDownEl = target;
      activeGroup = options.group;
      Sortable.dragged = dragEl;
      tapEvt = {
        target: dragEl,
        clientX: (touch || evt).clientX,
        clientY: (touch || evt).clientY
      };
      tapDistanceLeft = tapEvt.clientX - dragRect.left;
      tapDistanceTop = tapEvt.clientY - dragRect.top;
      this._lastX = (touch || evt).clientX;
      this._lastY = (touch || evt).clientY;
      dragEl.style['will-change'] = 'all';

      dragStartFn = function dragStartFn() {
        pluginEvent('delayEnded', _this, {
          evt: evt
        });

        if (Sortable.eventCanceled) {
          _this._onDrop();

          return;
        } // Delayed drag has been triggered
        // we can re-enable the events: touchmove/mousemove


        _this._disableDelayedDragEvents();

        if (!FireFox && _this.nativeDraggable) {
          dragEl.draggable = true;
        } // Bind the events: dragstart/dragend


        _this._triggerDragStart(evt, touch); // Drag start event


        _dispatchEvent({
          sortable: _this,
          name: 'choose',
          originalEvent: evt
        }); // Chosen item


        toggleClass(dragEl, options.chosenClass, true);
      }; // Disable "draggable"


      options.ignore.split(',').forEach(function (criteria) {
        find(dragEl, criteria.trim(), _disableDraggable);
      });
      on(ownerDocument, 'dragover', nearestEmptyInsertDetectEvent);
      on(ownerDocument, 'mousemove', nearestEmptyInsertDetectEvent);
      on(ownerDocument, 'touchmove', nearestEmptyInsertDetectEvent);
      on(ownerDocument, 'mouseup', _this._onDrop);
      on(ownerDocument, 'touchend', _this._onDrop);
      on(ownerDocument, 'touchcancel', _this._onDrop); // Make dragEl draggable (must be before delay for FireFox)

      if (FireFox && this.nativeDraggable) {
        this.options.touchStartThreshold = 4;
        dragEl.draggable = true;
      }

      pluginEvent('delayStart', this, {
        evt: evt
      }); // Delay is impossible for native DnD in Edge or IE

      if (options.delay && (!options.delayOnTouchOnly || touch) && (!this.nativeDraggable || !(Edge || IE11OrLess))) {
        if (Sortable.eventCanceled) {
          this._onDrop();

          return;
        } // If the user moves the pointer or let go the click or touch
        // before the delay has been reached:
        // disable the delayed drag


        on(ownerDocument, 'mouseup', _this._disableDelayedDrag);
        on(ownerDocument, 'touchend', _this._disableDelayedDrag);
        on(ownerDocument, 'touchcancel', _this._disableDelayedDrag);
        on(ownerDocument, 'mousemove', _this._delayedDragTouchMoveHandler);
        on(ownerDocument, 'touchmove', _this._delayedDragTouchMoveHandler);
        options.supportPointer && on(ownerDocument, 'pointermove', _this._delayedDragTouchMoveHandler);
        _this._dragStartTimer = setTimeout(dragStartFn, options.delay);
      } else {
        dragStartFn();
      }
    }
  },
  _delayedDragTouchMoveHandler: function _delayedDragTouchMoveHandler(
  /** TouchEvent|PointerEvent **/
  e) {
    var touch = e.touches ? e.touches[0] : e;

    if (Math.max(Math.abs(touch.clientX - this._lastX), Math.abs(touch.clientY - this._lastY)) >= Math.floor(this.options.touchStartThreshold / (this.nativeDraggable && window.devicePixelRatio || 1))) {
      this._disableDelayedDrag();
    }
  },
  _disableDelayedDrag: function _disableDelayedDrag() {
    dragEl && _disableDraggable(dragEl);
    clearTimeout(this._dragStartTimer);

    this._disableDelayedDragEvents();
  },
  _disableDelayedDragEvents: function _disableDelayedDragEvents() {
    var ownerDocument = this.el.ownerDocument;
    off(ownerDocument, 'mouseup', this._disableDelayedDrag);
    off(ownerDocument, 'touchend', this._disableDelayedDrag);
    off(ownerDocument, 'touchcancel', this._disableDelayedDrag);
    off(ownerDocument, 'mousemove', this._delayedDragTouchMoveHandler);
    off(ownerDocument, 'touchmove', this._delayedDragTouchMoveHandler);
    off(ownerDocument, 'pointermove', this._delayedDragTouchMoveHandler);
  },
  _triggerDragStart: function _triggerDragStart(
  /** Event */
  evt,
  /** Touch */
  touch) {
    touch = touch || evt.pointerType == 'touch' && evt;

    if (!this.nativeDraggable || touch) {
      if (this.options.supportPointer) {
        on(document, 'pointermove', this._onTouchMove);
      } else if (touch) {
        on(document, 'touchmove', this._onTouchMove);
      } else {
        on(document, 'mousemove', this._onTouchMove);
      }
    } else {
      on(dragEl, 'dragend', this);
      on(rootEl, 'dragstart', this._onDragStart);
    }

    try {
      if (document.selection) {
        // Timeout neccessary for IE9
        _nextTick(function () {
          document.selection.empty();
        });
      } else {
        window.getSelection().removeAllRanges();
      }
    } catch (err) {}
  },
  _dragStarted: function _dragStarted(fallback, evt) {

    awaitingDragStarted = false;

    if (rootEl && dragEl) {
      pluginEvent('dragStarted', this, {
        evt: evt
      });

      if (this.nativeDraggable) {
        on(document, 'dragover', _checkOutsideTargetEl);
      }

      var options = this.options; // Apply effect

      !fallback && toggleClass(dragEl, options.dragClass, false);
      toggleClass(dragEl, options.ghostClass, true);
      Sortable.active = this;
      fallback && this._appendGhost(); // Drag start event

      _dispatchEvent({
        sortable: this,
        name: 'start',
        originalEvent: evt
      });
    } else {
      this._nulling();
    }
  },
  _emulateDragOver: function _emulateDragOver() {
    if (touchEvt) {
      this._lastX = touchEvt.clientX;
      this._lastY = touchEvt.clientY;

      _hideGhostForTarget();

      var target = document.elementFromPoint(touchEvt.clientX, touchEvt.clientY);
      var parent = target;

      while (target && target.shadowRoot) {
        target = target.shadowRoot.elementFromPoint(touchEvt.clientX, touchEvt.clientY);
        if (target === parent) break;
        parent = target;
      }

      dragEl.parentNode[expando]._isOutsideThisEl(target);

      if (parent) {
        do {
          if (parent[expando]) {
            var inserted = void 0;
            inserted = parent[expando]._onDragOver({
              clientX: touchEvt.clientX,
              clientY: touchEvt.clientY,
              target: target,
              rootEl: parent
            });

            if (inserted && !this.options.dragoverBubble) {
              break;
            }
          }

          target = parent; // store last element
        }
        /* jshint boss:true */
        while (parent = parent.parentNode);
      }

      _unhideGhostForTarget();
    }
  },
  _onTouchMove: function _onTouchMove(
  /**TouchEvent*/
  evt) {
    if (tapEvt) {
      var options = this.options,
          fallbackTolerance = options.fallbackTolerance,
          fallbackOffset = options.fallbackOffset,
          touch = evt.touches ? evt.touches[0] : evt,
          ghostMatrix = ghostEl && matrix(ghostEl, true),
          scaleX = ghostEl && ghostMatrix && ghostMatrix.a,
          scaleY = ghostEl && ghostMatrix && ghostMatrix.d,
          relativeScrollOffset = PositionGhostAbsolutely && ghostRelativeParent && getRelativeScrollOffset(ghostRelativeParent),
          dx = (touch.clientX - tapEvt.clientX + fallbackOffset.x) / (scaleX || 1) + (relativeScrollOffset ? relativeScrollOffset[0] - ghostRelativeParentInitialScroll[0] : 0) / (scaleX || 1),
          dy = (touch.clientY - tapEvt.clientY + fallbackOffset.y) / (scaleY || 1) + (relativeScrollOffset ? relativeScrollOffset[1] - ghostRelativeParentInitialScroll[1] : 0) / (scaleY || 1); // only set the status to dragging, when we are actually dragging

      if (!Sortable.active && !awaitingDragStarted) {
        if (fallbackTolerance && Math.max(Math.abs(touch.clientX - this._lastX), Math.abs(touch.clientY - this._lastY)) < fallbackTolerance) {
          return;
        }

        this._onDragStart(evt, true);
      }

      if (ghostEl) {
        if (ghostMatrix) {
          ghostMatrix.e += dx - (lastDx || 0);
          ghostMatrix.f += dy - (lastDy || 0);
        } else {
          ghostMatrix = {
            a: 1,
            b: 0,
            c: 0,
            d: 1,
            e: dx,
            f: dy
          };
        }

        var cssMatrix = "matrix(".concat(ghostMatrix.a, ",").concat(ghostMatrix.b, ",").concat(ghostMatrix.c, ",").concat(ghostMatrix.d, ",").concat(ghostMatrix.e, ",").concat(ghostMatrix.f, ")");
        css(ghostEl, 'webkitTransform', cssMatrix);
        css(ghostEl, 'mozTransform', cssMatrix);
        css(ghostEl, 'msTransform', cssMatrix);
        css(ghostEl, 'transform', cssMatrix);
        lastDx = dx;
        lastDy = dy;
        touchEvt = touch;
      }

      evt.cancelable && evt.preventDefault();
    }
  },
  _appendGhost: function _appendGhost() {
    // Bug if using scale(): https://stackoverflow.com/questions/2637058
    // Not being adjusted for
    if (!ghostEl) {
      var container = this.options.fallbackOnBody ? document.body : rootEl,
          rect = getRect(dragEl, true, PositionGhostAbsolutely, true, container),
          options = this.options; // Position absolutely

      if (PositionGhostAbsolutely) {
        // Get relatively positioned parent
        ghostRelativeParent = container;

        while (css(ghostRelativeParent, 'position') === 'static' && css(ghostRelativeParent, 'transform') === 'none' && ghostRelativeParent !== document) {
          ghostRelativeParent = ghostRelativeParent.parentNode;
        }

        if (ghostRelativeParent !== document.body && ghostRelativeParent !== document.documentElement) {
          if (ghostRelativeParent === document) ghostRelativeParent = getWindowScrollingElement();
          rect.top += ghostRelativeParent.scrollTop;
          rect.left += ghostRelativeParent.scrollLeft;
        } else {
          ghostRelativeParent = getWindowScrollingElement();
        }

        ghostRelativeParentInitialScroll = getRelativeScrollOffset(ghostRelativeParent);
      }

      ghostEl = dragEl.cloneNode(true);
      toggleClass(ghostEl, options.ghostClass, false);
      toggleClass(ghostEl, options.fallbackClass, true);
      toggleClass(ghostEl, options.dragClass, true);
      css(ghostEl, 'transition', '');
      css(ghostEl, 'transform', '');
      css(ghostEl, 'box-sizing', 'border-box');
      css(ghostEl, 'margin', 0);
      css(ghostEl, 'top', rect.top);
      css(ghostEl, 'left', rect.left);
      css(ghostEl, 'width', rect.width);
      css(ghostEl, 'height', rect.height);
      css(ghostEl, 'opacity', '0.8');
      css(ghostEl, 'position', PositionGhostAbsolutely ? 'absolute' : 'fixed');
      css(ghostEl, 'zIndex', '100000');
      css(ghostEl, 'pointerEvents', 'none');
      Sortable.ghost = ghostEl;
      container.appendChild(ghostEl); // Set transform-origin

      css(ghostEl, 'transform-origin', tapDistanceLeft / parseInt(ghostEl.style.width) * 100 + '% ' + tapDistanceTop / parseInt(ghostEl.style.height) * 100 + '%');
    }
  },
  _onDragStart: function _onDragStart(
  /**Event*/
  evt,
  /**boolean*/
  fallback) {
    var _this = this;

    var dataTransfer = evt.dataTransfer;
    var options = _this.options;
    pluginEvent('dragStart', this, {
      evt: evt
    });

    if (Sortable.eventCanceled) {
      this._onDrop();

      return;
    }

    pluginEvent('setupClone', this);

    if (!Sortable.eventCanceled) {
      cloneEl = clone(dragEl);
      cloneEl.draggable = false;
      cloneEl.style['will-change'] = '';

      this._hideClone();

      toggleClass(cloneEl, this.options.chosenClass, false);
      Sortable.clone = cloneEl;
    } // #1143: IFrame support workaround


    _this.cloneId = _nextTick(function () {
      pluginEvent('clone', _this);
      if (Sortable.eventCanceled) return;

      if (!_this.options.removeCloneOnHide) {
        rootEl.insertBefore(cloneEl, dragEl);
      }

      _this._hideClone();

      _dispatchEvent({
        sortable: _this,
        name: 'clone'
      });
    });
    !fallback && toggleClass(dragEl, options.dragClass, true); // Set proper drop events

    if (fallback) {
      ignoreNextClick = true;
      _this._loopId = setInterval(_this._emulateDragOver, 50);
    } else {
      // Undo what was set in _prepareDragStart before drag started
      off(document, 'mouseup', _this._onDrop);
      off(document, 'touchend', _this._onDrop);
      off(document, 'touchcancel', _this._onDrop);

      if (dataTransfer) {
        dataTransfer.effectAllowed = 'move';
        options.setData && options.setData.call(_this, dataTransfer, dragEl);
      }

      on(document, 'drop', _this); // #1276 fix:

      css(dragEl, 'transform', 'translateZ(0)');
    }

    awaitingDragStarted = true;
    _this._dragStartId = _nextTick(_this._dragStarted.bind(_this, fallback, evt));
    on(document, 'selectstart', _this);
    moved = true;

    if (Safari) {
      css(document.body, 'user-select', 'none');
    }
  },
  // Returns true - if no further action is needed (either inserted or another condition)
  _onDragOver: function _onDragOver(
  /**Event*/
  evt) {
    var el = this.el,
        target = evt.target,
        dragRect,
        targetRect,
        revert,
        options = this.options,
        group = options.group,
        activeSortable = Sortable.active,
        isOwner = activeGroup === group,
        canSort = options.sort,
        fromSortable = putSortable || activeSortable,
        vertical,
        _this = this,
        completedFired = false;

    if (_silent) return;

    function dragOverEvent(name, extra) {
      pluginEvent(name, _this, _objectSpread({
        evt: evt,
        isOwner: isOwner,
        axis: vertical ? 'vertical' : 'horizontal',
        revert: revert,
        dragRect: dragRect,
        targetRect: targetRect,
        canSort: canSort,
        fromSortable: fromSortable,
        target: target,
        completed: completed,
        onMove: function onMove(target, after) {
          return _onMove(rootEl, el, dragEl, dragRect, target, getRect(target), evt, after);
        },
        changed: changed
      }, extra));
    } // Capture animation state


    function capture() {
      dragOverEvent('dragOverAnimationCapture');

      _this.captureAnimationState();

      if (_this !== fromSortable) {
        fromSortable.captureAnimationState();
      }
    } // Return invocation when dragEl is inserted (or completed)


    function completed(insertion) {
      dragOverEvent('dragOverCompleted', {
        insertion: insertion
      });

      if (insertion) {
        // Clones must be hidden before folding animation to capture dragRectAbsolute properly
        if (isOwner) {
          activeSortable._hideClone();
        } else {
          activeSortable._showClone(_this);
        }

        if (_this !== fromSortable) {
          // Set ghost class to new sortable's ghost class
          toggleClass(dragEl, putSortable ? putSortable.options.ghostClass : activeSortable.options.ghostClass, false);
          toggleClass(dragEl, options.ghostClass, true);
        }

        if (putSortable !== _this && _this !== Sortable.active) {
          putSortable = _this;
        } else if (_this === Sortable.active && putSortable) {
          putSortable = null;
        } // Animation


        if (fromSortable === _this) {
          _this._ignoreWhileAnimating = target;
        }

        _this.animateAll(function () {
          dragOverEvent('dragOverAnimationComplete');
          _this._ignoreWhileAnimating = null;
        });

        if (_this !== fromSortable) {
          fromSortable.animateAll();
          fromSortable._ignoreWhileAnimating = null;
        }
      } // Null lastTarget if it is not inside a previously swapped element


      if (target === dragEl && !dragEl.animated || target === el && !target.animated) {
        lastTarget = null;
      } // no bubbling and not fallback


      if (!options.dragoverBubble && !evt.rootEl && target !== document) {
        dragEl.parentNode[expando]._isOutsideThisEl(evt.target); // Do not detect for empty insert if already inserted


        !insertion && nearestEmptyInsertDetectEvent(evt);
      }

      !options.dragoverBubble && evt.stopPropagation && evt.stopPropagation();
      return completedFired = true;
    } // Call when dragEl has been inserted


    function changed() {
      newIndex = index(dragEl);
      newDraggableIndex = index(dragEl, options.draggable);

      _dispatchEvent({
        sortable: _this,
        name: 'change',
        toEl: el,
        newIndex: newIndex,
        newDraggableIndex: newDraggableIndex,
        originalEvent: evt
      });
    }

    if (evt.preventDefault !== void 0) {
      evt.cancelable && evt.preventDefault();
    }

    target = closest(target, options.draggable, el, true);
    dragOverEvent('dragOver');
    if (Sortable.eventCanceled) return completedFired;

    if (dragEl.contains(evt.target) || target.animated && target.animatingX && target.animatingY || _this._ignoreWhileAnimating === target) {
      return completed(false);
    }

    ignoreNextClick = false;

    if (activeSortable && !options.disabled && (isOwner ? canSort || (revert = !rootEl.contains(dragEl)) // Reverting item into the original list
    : putSortable === this || (this.lastPutMode = activeGroup.checkPull(this, activeSortable, dragEl, evt)) && group.checkPut(this, activeSortable, dragEl, evt))) {
      vertical = this._getDirection(evt, target) === 'vertical';
      dragRect = getRect(dragEl);
      dragOverEvent('dragOverValid');
      if (Sortable.eventCanceled) return completedFired;

      if (revert) {
        parentEl = rootEl; // actualization

        capture();

        this._hideClone();

        dragOverEvent('revert');

        if (!Sortable.eventCanceled) {
          if (nextEl) {
            rootEl.insertBefore(dragEl, nextEl);
          } else {
            rootEl.appendChild(dragEl);
          }
        }

        return completed(true);
      }

      var elLastChild = lastChild(el, options.draggable);

      if (!elLastChild || _ghostIsLast(evt, vertical, this) && !elLastChild.animated) {
        // If already at end of list: Do not insert
        if (elLastChild === dragEl) {
          return completed(false);
        } // assign target only if condition is true


        if (elLastChild && el === evt.target) {
          target = elLastChild;
        }

        if (target) {
          targetRect = getRect(target);
        }

        if (_onMove(rootEl, el, dragEl, dragRect, target, targetRect, evt, !!target) !== false) {
          capture();
          el.appendChild(dragEl);
          parentEl = el; // actualization

          changed();
          return completed(true);
        }
      } else if (target.parentNode === el) {
        targetRect = getRect(target);
        var direction = 0,
            targetBeforeFirstSwap,
            differentLevel = dragEl.parentNode !== el,
            differentRowCol = !_dragElInRowColumn(dragEl.animated && dragEl.toRect || dragRect, target.animated && target.toRect || targetRect, vertical),
            side1 = vertical ? 'top' : 'left',
            scrolledPastTop = isScrolledPast(target, 'top', 'top') || isScrolledPast(dragEl, 'top', 'top'),
            scrollBefore = scrolledPastTop ? scrolledPastTop.scrollTop : void 0;

        if (lastTarget !== target) {
          targetBeforeFirstSwap = targetRect[side1];
          pastFirstInvertThresh = false;
          isCircumstantialInvert = !differentRowCol && options.invertSwap || differentLevel;
        }

        direction = _getSwapDirection(evt, target, targetRect, vertical, differentRowCol ? 1 : options.swapThreshold, options.invertedSwapThreshold == null ? options.swapThreshold : options.invertedSwapThreshold, isCircumstantialInvert, lastTarget === target);
        var sibling;

        if (direction !== 0) {
          // Check if target is beside dragEl in respective direction (ignoring hidden elements)
          var dragIndex = index(dragEl);

          do {
            dragIndex -= direction;
            sibling = parentEl.children[dragIndex];
          } while (sibling && (css(sibling, 'display') === 'none' || sibling === ghostEl));
        } // If dragEl is already beside target: Do not insert


        if (direction === 0 || sibling === target) {
          return completed(false);
        }

        lastTarget = target;
        lastDirection = direction;
        var nextSibling = target.nextElementSibling,
            after = false;
        after = direction === 1;

        var moveVector = _onMove(rootEl, el, dragEl, dragRect, target, targetRect, evt, after);

        if (moveVector !== false) {
          if (moveVector === 1 || moveVector === -1) {
            after = moveVector === 1;
          }

          _silent = true;
          setTimeout(_unsilent, 30);
          capture();

          if (after && !nextSibling) {
            el.appendChild(dragEl);
          } else {
            target.parentNode.insertBefore(dragEl, after ? nextSibling : target);
          } // Undo chrome's scroll adjustment (has no effect on other browsers)


          if (scrolledPastTop) {
            scrollBy(scrolledPastTop, 0, scrollBefore - scrolledPastTop.scrollTop);
          }

          parentEl = dragEl.parentNode; // actualization
          // must be done before animation

          if (targetBeforeFirstSwap !== undefined && !isCircumstantialInvert) {
            targetMoveDistance = Math.abs(targetBeforeFirstSwap - getRect(target)[side1]);
          }

          changed();
          return completed(true);
        }
      }

      if (el.contains(dragEl)) {
        return completed(false);
      }
    }

    return false;
  },
  _ignoreWhileAnimating: null,
  _offMoveEvents: function _offMoveEvents() {
    off(document, 'mousemove', this._onTouchMove);
    off(document, 'touchmove', this._onTouchMove);
    off(document, 'pointermove', this._onTouchMove);
    off(document, 'dragover', nearestEmptyInsertDetectEvent);
    off(document, 'mousemove', nearestEmptyInsertDetectEvent);
    off(document, 'touchmove', nearestEmptyInsertDetectEvent);
  },
  _offUpEvents: function _offUpEvents() {
    var ownerDocument = this.el.ownerDocument;
    off(ownerDocument, 'mouseup', this._onDrop);
    off(ownerDocument, 'touchend', this._onDrop);
    off(ownerDocument, 'pointerup', this._onDrop);
    off(ownerDocument, 'touchcancel', this._onDrop);
    off(document, 'selectstart', this);
  },
  _onDrop: function _onDrop(
  /**Event*/
  evt) {
    var el = this.el,
        options = this.options; // Get the index of the dragged element within its parent

    newIndex = index(dragEl);
    newDraggableIndex = index(dragEl, options.draggable);
    pluginEvent('drop', this, {
      evt: evt
    });
    parentEl = dragEl && dragEl.parentNode; // Get again after plugin event

    newIndex = index(dragEl);
    newDraggableIndex = index(dragEl, options.draggable);

    if (Sortable.eventCanceled) {
      this._nulling();

      return;
    }

    awaitingDragStarted = false;
    isCircumstantialInvert = false;
    pastFirstInvertThresh = false;
    clearInterval(this._loopId);
    clearTimeout(this._dragStartTimer);

    _cancelNextTick(this.cloneId);

    _cancelNextTick(this._dragStartId); // Unbind events


    if (this.nativeDraggable) {
      off(document, 'drop', this);
      off(el, 'dragstart', this._onDragStart);
    }

    this._offMoveEvents();

    this._offUpEvents();

    if (Safari) {
      css(document.body, 'user-select', '');
    }

    css(dragEl, 'transform', '');

    if (evt) {
      if (moved) {
        evt.cancelable && evt.preventDefault();
        !options.dropBubble && evt.stopPropagation();
      }

      ghostEl && ghostEl.parentNode && ghostEl.parentNode.removeChild(ghostEl);

      if (rootEl === parentEl || putSortable && putSortable.lastPutMode !== 'clone') {
        // Remove clone(s)
        cloneEl && cloneEl.parentNode && cloneEl.parentNode.removeChild(cloneEl);
      }

      if (dragEl) {
        if (this.nativeDraggable) {
          off(dragEl, 'dragend', this);
        }

        _disableDraggable(dragEl);

        dragEl.style['will-change'] = ''; // Remove classes
        // ghostClass is added in dragStarted

        if (moved && !awaitingDragStarted) {
          toggleClass(dragEl, putSortable ? putSortable.options.ghostClass : this.options.ghostClass, false);
        }

        toggleClass(dragEl, this.options.chosenClass, false); // Drag stop event

        _dispatchEvent({
          sortable: this,
          name: 'unchoose',
          toEl: parentEl,
          newIndex: null,
          newDraggableIndex: null,
          originalEvent: evt
        });

        if (rootEl !== parentEl) {
          if (newIndex >= 0) {
            // Add event
            _dispatchEvent({
              rootEl: parentEl,
              name: 'add',
              toEl: parentEl,
              fromEl: rootEl,
              originalEvent: evt
            }); // Remove event


            _dispatchEvent({
              sortable: this,
              name: 'remove',
              toEl: parentEl,
              originalEvent: evt
            }); // drag from one list and drop into another


            _dispatchEvent({
              rootEl: parentEl,
              name: 'sort',
              toEl: parentEl,
              fromEl: rootEl,
              originalEvent: evt
            });

            _dispatchEvent({
              sortable: this,
              name: 'sort',
              toEl: parentEl,
              originalEvent: evt
            });
          }

          putSortable && putSortable.save();
        } else {
          if (newIndex !== oldIndex) {
            if (newIndex >= 0) {
              // drag & drop within the same list
              _dispatchEvent({
                sortable: this,
                name: 'update',
                toEl: parentEl,
                originalEvent: evt
              });

              _dispatchEvent({
                sortable: this,
                name: 'sort',
                toEl: parentEl,
                originalEvent: evt
              });
            }
          }
        }

        if (Sortable.active) {
          /* jshint eqnull:true */
          if (newIndex == null || newIndex === -1) {
            newIndex = oldIndex;
            newDraggableIndex = oldDraggableIndex;
          }

          _dispatchEvent({
            sortable: this,
            name: 'end',
            toEl: parentEl,
            originalEvent: evt
          }); // Save sorting


          this.save();
        }
      }
    }

    this._nulling();
  },
  _nulling: function _nulling() {
    pluginEvent('nulling', this);
    rootEl = dragEl = parentEl = ghostEl = nextEl = cloneEl = lastDownEl = cloneHidden = tapEvt = touchEvt = moved = newIndex = newDraggableIndex = oldIndex = oldDraggableIndex = lastTarget = lastDirection = putSortable = activeGroup = Sortable.dragged = Sortable.ghost = Sortable.clone = Sortable.active = null;
    savedInputChecked.forEach(function (el) {
      el.checked = true;
    });
    savedInputChecked.length = lastDx = lastDy = 0;
  },
  handleEvent: function handleEvent(
  /**Event*/
  evt) {
    switch (evt.type) {
      case 'drop':
      case 'dragend':
        this._onDrop(evt);

        break;

      case 'dragenter':
      case 'dragover':
        if (dragEl) {
          this._onDragOver(evt);

          _globalDragOver(evt);
        }

        break;

      case 'selectstart':
        evt.preventDefault();
        break;
    }
  },

  /**
   * Serializes the item into an array of string.
   * @returns {String[]}
   */
  toArray: function toArray() {
    var order = [],
        el,
        children = this.el.children,
        i = 0,
        n = children.length,
        options = this.options;

    for (; i < n; i++) {
      el = children[i];

      if (closest(el, options.draggable, this.el, false)) {
        order.push(el.getAttribute(options.dataIdAttr) || _generateId(el));
      }
    }

    return order;
  },

  /**
   * Sorts the elements according to the array.
   * @param  {String[]}  order  order of the items
   */
  sort: function sort(order) {
    var items = {},
        rootEl = this.el;
    this.toArray().forEach(function (id, i) {
      var el = rootEl.children[i];

      if (closest(el, this.options.draggable, rootEl, false)) {
        items[id] = el;
      }
    }, this);
    order.forEach(function (id) {
      if (items[id]) {
        rootEl.removeChild(items[id]);
        rootEl.appendChild(items[id]);
      }
    });
  },

  /**
   * Save the current sorting
   */
  save: function save() {
    var store = this.options.store;
    store && store.set && store.set(this);
  },

  /**
   * For each element in the set, get the first element that matches the selector by testing the element itself and traversing up through its ancestors in the DOM tree.
   * @param   {HTMLElement}  el
   * @param   {String}       [selector]  default: `options.draggable`
   * @returns {HTMLElement|null}
   */
  closest: function closest$1(el, selector) {
    return closest(el, selector || this.options.draggable, this.el, false);
  },

  /**
   * Set/get option
   * @param   {string} name
   * @param   {*}      [value]
   * @returns {*}
   */
  option: function option(name, value) {
    var options = this.options;

    if (value === void 0) {
      return options[name];
    } else {
      var modifiedValue = PluginManager.modifyOption(this, name, value);

      if (typeof modifiedValue !== 'undefined') {
        options[name] = modifiedValue;
      } else {
        options[name] = value;
      }

      if (name === 'group') {
        _prepareGroup(options);
      }
    }
  },

  /**
   * Destroy
   */
  destroy: function destroy() {
    pluginEvent('destroy', this);
    var el = this.el;
    el[expando] = null;
    off(el, 'mousedown', this._onTapStart);
    off(el, 'touchstart', this._onTapStart);
    off(el, 'pointerdown', this._onTapStart);

    if (this.nativeDraggable) {
      off(el, 'dragover', this);
      off(el, 'dragenter', this);
    } // Remove draggable attributes


    Array.prototype.forEach.call(el.querySelectorAll('[draggable]'), function (el) {
      el.removeAttribute('draggable');
    });

    this._onDrop();

    this._disableDelayedDragEvents();

    sortables.splice(sortables.indexOf(this.el), 1);
    this.el = el = null;
  },
  _hideClone: function _hideClone() {
    if (!cloneHidden) {
      pluginEvent('hideClone', this);
      if (Sortable.eventCanceled) return;
      css(cloneEl, 'display', 'none');

      if (this.options.removeCloneOnHide && cloneEl.parentNode) {
        cloneEl.parentNode.removeChild(cloneEl);
      }

      cloneHidden = true;
    }
  },
  _showClone: function _showClone(putSortable) {
    if (putSortable.lastPutMode !== 'clone') {
      this._hideClone();

      return;
    }

    if (cloneHidden) {
      pluginEvent('showClone', this);
      if (Sortable.eventCanceled) return; // show clone at dragEl or original position

      if (rootEl.contains(dragEl) && !this.options.group.revertClone) {
        rootEl.insertBefore(cloneEl, dragEl);
      } else if (nextEl) {
        rootEl.insertBefore(cloneEl, nextEl);
      } else {
        rootEl.appendChild(cloneEl);
      }

      if (this.options.group.revertClone) {
        this.animate(dragEl, cloneEl);
      }

      css(cloneEl, 'display', '');
      cloneHidden = false;
    }
  }
};

function _globalDragOver(
/**Event*/
evt) {
  if (evt.dataTransfer) {
    evt.dataTransfer.dropEffect = 'move';
  }

  evt.cancelable && evt.preventDefault();
}

function _onMove(fromEl, toEl, dragEl, dragRect, targetEl, targetRect, originalEvent, willInsertAfter) {
  var evt,
      sortable = fromEl[expando],
      onMoveFn = sortable.options.onMove,
      retVal; // Support for new CustomEvent feature

  if (window.CustomEvent && !IE11OrLess && !Edge) {
    evt = new CustomEvent('move', {
      bubbles: true,
      cancelable: true
    });
  } else {
    evt = document.createEvent('Event');
    evt.initEvent('move', true, true);
  }

  evt.to = toEl;
  evt.from = fromEl;
  evt.dragged = dragEl;
  evt.draggedRect = dragRect;
  evt.related = targetEl || toEl;
  evt.relatedRect = targetRect || getRect(toEl);
  evt.willInsertAfter = willInsertAfter;
  evt.originalEvent = originalEvent;
  fromEl.dispatchEvent(evt);

  if (onMoveFn) {
    retVal = onMoveFn.call(sortable, evt, originalEvent);
  }

  return retVal;
}

function _disableDraggable(el) {
  el.draggable = false;
}

function _unsilent() {
  _silent = false;
}

function _ghostIsLast(evt, vertical, sortable) {
  var rect = getRect(lastChild(sortable.el, sortable.options.draggable));
  var spacer = 10;
  return vertical ? evt.clientX > rect.right + spacer || evt.clientX <= rect.right && evt.clientY > rect.bottom && evt.clientX >= rect.left : evt.clientX > rect.right && evt.clientY > rect.top || evt.clientX <= rect.right && evt.clientY > rect.bottom + spacer;
}

function _getSwapDirection(evt, target, targetRect, vertical, swapThreshold, invertedSwapThreshold, invertSwap, isLastTarget) {
  var mouseOnAxis = vertical ? evt.clientY : evt.clientX,
      targetLength = vertical ? targetRect.height : targetRect.width,
      targetS1 = vertical ? targetRect.top : targetRect.left,
      targetS2 = vertical ? targetRect.bottom : targetRect.right,
      invert = false;

  if (!invertSwap) {
    // Never invert or create dragEl shadow when target movemenet causes mouse to move past the end of regular swapThreshold
    if (isLastTarget && targetMoveDistance < targetLength * swapThreshold) {
      // multiplied only by swapThreshold because mouse will already be inside target by (1 - threshold) * targetLength / 2
      // check if past first invert threshold on side opposite of lastDirection
      if (!pastFirstInvertThresh && (lastDirection === 1 ? mouseOnAxis > targetS1 + targetLength * invertedSwapThreshold / 2 : mouseOnAxis < targetS2 - targetLength * invertedSwapThreshold / 2)) {
        // past first invert threshold, do not restrict inverted threshold to dragEl shadow
        pastFirstInvertThresh = true;
      }

      if (!pastFirstInvertThresh) {
        // dragEl shadow (target move distance shadow)
        if (lastDirection === 1 ? mouseOnAxis < targetS1 + targetMoveDistance // over dragEl shadow
        : mouseOnAxis > targetS2 - targetMoveDistance) {
          return -lastDirection;
        }
      } else {
        invert = true;
      }
    } else {
      // Regular
      if (mouseOnAxis > targetS1 + targetLength * (1 - swapThreshold) / 2 && mouseOnAxis < targetS2 - targetLength * (1 - swapThreshold) / 2) {
        return _getInsertDirection(target);
      }
    }
  }

  invert = invert || invertSwap;

  if (invert) {
    // Invert of regular
    if (mouseOnAxis < targetS1 + targetLength * invertedSwapThreshold / 2 || mouseOnAxis > targetS2 - targetLength * invertedSwapThreshold / 2) {
      return mouseOnAxis > targetS1 + targetLength / 2 ? 1 : -1;
    }
  }

  return 0;
}
/**
 * Gets the direction dragEl must be swapped relative to target in order to make it
 * seem that dragEl has been "inserted" into that element's position
 * @param  {HTMLElement} target       The target whose position dragEl is being inserted at
 * @return {Number}                   Direction dragEl must be swapped
 */


function _getInsertDirection(target) {
  if (index(dragEl) < index(target)) {
    return 1;
  } else {
    return -1;
  }
}
/**
 * Generate id
 * @param   {HTMLElement} el
 * @returns {String}
 * @private
 */


function _generateId(el) {
  var str = el.tagName + el.className + el.src + el.href + el.textContent,
      i = str.length,
      sum = 0;

  while (i--) {
    sum += str.charCodeAt(i);
  }

  return sum.toString(36);
}

function _saveInputCheckedState(root) {
  savedInputChecked.length = 0;
  var inputs = root.getElementsByTagName('input');
  var idx = inputs.length;

  while (idx--) {
    var el = inputs[idx];
    el.checked && savedInputChecked.push(el);
  }
}

function _nextTick(fn) {
  return setTimeout(fn, 0);
}

function _cancelNextTick(id) {
  return clearTimeout(id);
} // Fixed #973:


if (documentExists) {
  on(document, 'touchmove', function (evt) {
    if ((Sortable.active || awaitingDragStarted) && evt.cancelable) {
      evt.preventDefault();
    }
  });
} // Export utils


Sortable.utils = {
  on: on,
  off: off,
  css: css,
  find: find,
  is: function is(el, selector) {
    return !!closest(el, selector, el, false);
  },
  extend: extend,
  throttle: throttle,
  closest: closest,
  toggleClass: toggleClass,
  clone: clone,
  index: index,
  nextTick: _nextTick,
  cancelNextTick: _cancelNextTick,
  detectDirection: _detectDirection,
  getChild: getChild
};
/**
 * Get the Sortable instance of an element
 * @param  {HTMLElement} element The element
 * @return {Sortable|undefined}         The instance of Sortable
 */

Sortable.get = function (element) {
  return element[expando];
};
/**
 * Mount a plugin to Sortable
 * @param  {...SortablePlugin|SortablePlugin[]} plugins       Plugins being mounted
 */


Sortable.mount = function () {
  for (var _len = arguments.length, plugins = new Array(_len), _key = 0; _key < _len; _key++) {
    plugins[_key] = arguments[_key];
  }

  if (plugins[0].constructor === Array) plugins = plugins[0];
  plugins.forEach(function (plugin) {
    if (!plugin.prototype || !plugin.prototype.constructor) {
      throw "Sortable: Mounted plugin must be a constructor function, not ".concat({}.toString.call(plugin));
    }

    if (plugin.utils) Sortable.utils = _objectSpread({}, Sortable.utils, plugin.utils);
    PluginManager.mount(plugin);
  });
};
/**
 * Create sortable instance
 * @param {HTMLElement}  el
 * @param {Object}      [options]
 */


Sortable.create = function (el, options) {
  return new Sortable(el, options);
}; // Export


Sortable.version = version;

var autoScrolls = [],
    scrollEl,
    scrollRootEl,
    scrolling = false,
    lastAutoScrollX,
    lastAutoScrollY,
    touchEvt$1,
    pointerElemChangedInterval;

function AutoScrollPlugin() {
  function AutoScroll() {
    this.defaults = {
      scroll: true,
      scrollSensitivity: 30,
      scrollSpeed: 10,
      bubbleScroll: true
    }; // Bind all private methods

    for (var fn in this) {
      if (fn.charAt(0) === '_' && typeof this[fn] === 'function') {
        this[fn] = this[fn].bind(this);
      }
    }
  }

  AutoScroll.prototype = {
    dragStarted: function dragStarted(_ref) {
      var originalEvent = _ref.originalEvent;

      if (this.sortable.nativeDraggable) {
        on(document, 'dragover', this._handleAutoScroll);
      } else {
        if (this.options.supportPointer) {
          on(document, 'pointermove', this._handleFallbackAutoScroll);
        } else if (originalEvent.touches) {
          on(document, 'touchmove', this._handleFallbackAutoScroll);
        } else {
          on(document, 'mousemove', this._handleFallbackAutoScroll);
        }
      }
    },
    dragOverCompleted: function dragOverCompleted(_ref2) {
      var originalEvent = _ref2.originalEvent;

      // For when bubbling is canceled and using fallback (fallback 'touchmove' always reached)
      if (!this.options.dragOverBubble && !originalEvent.rootEl) {
        this._handleAutoScroll(originalEvent);
      }
    },
    drop: function drop() {
      if (this.sortable.nativeDraggable) {
        off(document, 'dragover', this._handleAutoScroll);
      } else {
        off(document, 'pointermove', this._handleFallbackAutoScroll);
        off(document, 'touchmove', this._handleFallbackAutoScroll);
        off(document, 'mousemove', this._handleFallbackAutoScroll);
      }

      clearPointerElemChangedInterval();
      clearAutoScrolls();
      cancelThrottle();
    },
    nulling: function nulling() {
      touchEvt$1 = scrollRootEl = scrollEl = scrolling = pointerElemChangedInterval = lastAutoScrollX = lastAutoScrollY = null;
      autoScrolls.length = 0;
    },
    _handleFallbackAutoScroll: function _handleFallbackAutoScroll(evt) {
      this._handleAutoScroll(evt, true);
    },
    _handleAutoScroll: function _handleAutoScroll(evt, fallback) {
      var _this = this;

      var x = (evt.touches ? evt.touches[0] : evt).clientX,
          y = (evt.touches ? evt.touches[0] : evt).clientY,
          elem = document.elementFromPoint(x, y);
      touchEvt$1 = evt; // IE does not seem to have native autoscroll,
      // Edge's autoscroll seems too conditional,
      // MACOS Safari does not have autoscroll,
      // Firefox and Chrome are good

      if (fallback || Edge || IE11OrLess || Safari) {
        autoScroll(evt, this.options, elem, fallback); // Listener for pointer element change

        var ogElemScroller = getParentAutoScrollElement(elem, true);

        if (scrolling && (!pointerElemChangedInterval || x !== lastAutoScrollX || y !== lastAutoScrollY)) {
          pointerElemChangedInterval && clearPointerElemChangedInterval(); // Detect for pointer elem change, emulating native DnD behaviour

          pointerElemChangedInterval = setInterval(function () {
            var newElem = getParentAutoScrollElement(document.elementFromPoint(x, y), true);

            if (newElem !== ogElemScroller) {
              ogElemScroller = newElem;
              clearAutoScrolls();
            }

            autoScroll(evt, _this.options, newElem, fallback);
          }, 10);
          lastAutoScrollX = x;
          lastAutoScrollY = y;
        }
      } else {
        // if DnD is enabled (and browser has good autoscrolling), first autoscroll will already scroll, so get parent autoscroll of first autoscroll
        if (!this.options.bubbleScroll || getParentAutoScrollElement(elem, true) === getWindowScrollingElement()) {
          clearAutoScrolls();
          return;
        }

        autoScroll(evt, this.options, getParentAutoScrollElement(elem, false), false);
      }
    }
  };
  return _extends(AutoScroll, {
    pluginName: 'scroll',
    initializeByDefault: true
  });
}

function clearAutoScrolls() {
  autoScrolls.forEach(function (autoScroll) {
    clearInterval(autoScroll.pid);
  });
  autoScrolls = [];
}

function clearPointerElemChangedInterval() {
  clearInterval(pointerElemChangedInterval);
}

var autoScroll = throttle(function (evt, options, rootEl, isFallback) {
  // Bug: https://bugzilla.mozilla.org/show_bug.cgi?id=505521
  if (!options.scroll) return;
  var x = (evt.touches ? evt.touches[0] : evt).clientX,
      y = (evt.touches ? evt.touches[0] : evt).clientY,
      sens = options.scrollSensitivity,
      speed = options.scrollSpeed,
      winScroller = getWindowScrollingElement();
  var scrollThisInstance = false,
      scrollCustomFn; // New scroll root, set scrollEl

  if (scrollRootEl !== rootEl) {
    scrollRootEl = rootEl;
    clearAutoScrolls();
    scrollEl = options.scroll;
    scrollCustomFn = options.scrollFn;

    if (scrollEl === true) {
      scrollEl = getParentAutoScrollElement(rootEl, true);
    }
  }

  var layersOut = 0;
  var currentParent = scrollEl;

  do {
    var el = currentParent,
        rect = getRect(el),
        top = rect.top,
        bottom = rect.bottom,
        left = rect.left,
        right = rect.right,
        width = rect.width,
        height = rect.height,
        canScrollX = void 0,
        canScrollY = void 0,
        scrollWidth = el.scrollWidth,
        scrollHeight = el.scrollHeight,
        elCSS = css(el),
        scrollPosX = el.scrollLeft,
        scrollPosY = el.scrollTop;

    if (el === winScroller) {
      canScrollX = width < scrollWidth && (elCSS.overflowX === 'auto' || elCSS.overflowX === 'scroll' || elCSS.overflowX === 'visible');
      canScrollY = height < scrollHeight && (elCSS.overflowY === 'auto' || elCSS.overflowY === 'scroll' || elCSS.overflowY === 'visible');
    } else {
      canScrollX = width < scrollWidth && (elCSS.overflowX === 'auto' || elCSS.overflowX === 'scroll');
      canScrollY = height < scrollHeight && (elCSS.overflowY === 'auto' || elCSS.overflowY === 'scroll');
    }

    var vx = canScrollX && (Math.abs(right - x) <= sens && scrollPosX + width < scrollWidth) - (Math.abs(left - x) <= sens && !!scrollPosX);
    var vy = canScrollY && (Math.abs(bottom - y) <= sens && scrollPosY + height < scrollHeight) - (Math.abs(top - y) <= sens && !!scrollPosY);

    if (!autoScrolls[layersOut]) {
      for (var i = 0; i <= layersOut; i++) {
        if (!autoScrolls[i]) {
          autoScrolls[i] = {};
        }
      }
    }

    if (autoScrolls[layersOut].vx != vx || autoScrolls[layersOut].vy != vy || autoScrolls[layersOut].el !== el) {
      autoScrolls[layersOut].el = el;
      autoScrolls[layersOut].vx = vx;
      autoScrolls[layersOut].vy = vy;
      clearInterval(autoScrolls[layersOut].pid);

      if (vx != 0 || vy != 0) {
        scrollThisInstance = true;
        /* jshint loopfunc:true */

        autoScrolls[layersOut].pid = setInterval(function () {
          // emulate drag over during autoscroll (fallback), emulating native DnD behaviour
          if (isFallback && this.layer === 0) {
            Sortable.active._onTouchMove(touchEvt$1); // To move ghost if it is positioned absolutely

          }

          var scrollOffsetY = autoScrolls[this.layer].vy ? autoScrolls[this.layer].vy * speed : 0;
          var scrollOffsetX = autoScrolls[this.layer].vx ? autoScrolls[this.layer].vx * speed : 0;

          if (typeof scrollCustomFn === 'function') {
            if (scrollCustomFn.call(Sortable.dragged.parentNode[expando], scrollOffsetX, scrollOffsetY, evt, touchEvt$1, autoScrolls[this.layer].el) !== 'continue') {
              return;
            }
          }

          scrollBy(autoScrolls[this.layer].el, scrollOffsetX, scrollOffsetY);
        }.bind({
          layer: layersOut
        }), 24);
      }
    }

    layersOut++;
  } while (options.bubbleScroll && currentParent !== winScroller && (currentParent = getParentAutoScrollElement(currentParent, false)));

  scrolling = scrollThisInstance; // in case another function catches scrolling as false in between when it is not
}, 30);

var drop = function drop(_ref) {
  var originalEvent = _ref.originalEvent,
      putSortable = _ref.putSortable,
      dragEl = _ref.dragEl,
      activeSortable = _ref.activeSortable,
      dispatchSortableEvent = _ref.dispatchSortableEvent,
      hideGhostForTarget = _ref.hideGhostForTarget,
      unhideGhostForTarget = _ref.unhideGhostForTarget;
  if (!originalEvent) return;
  var toSortable = putSortable || activeSortable;
  hideGhostForTarget();
  var touch = originalEvent.changedTouches && originalEvent.changedTouches.length ? originalEvent.changedTouches[0] : originalEvent;
  var target = document.elementFromPoint(touch.clientX, touch.clientY);
  unhideGhostForTarget();

  if (toSortable && !toSortable.el.contains(target)) {
    dispatchSortableEvent('spill');
    this.onSpill({
      dragEl: dragEl,
      putSortable: putSortable
    });
  }
};

function Revert() {}

Revert.prototype = {
  startIndex: null,
  dragStart: function dragStart(_ref2) {
    var oldDraggableIndex = _ref2.oldDraggableIndex;
    this.startIndex = oldDraggableIndex;
  },
  onSpill: function onSpill(_ref3) {
    var dragEl = _ref3.dragEl,
        putSortable = _ref3.putSortable;
    this.sortable.captureAnimationState();

    if (putSortable) {
      putSortable.captureAnimationState();
    }

    var nextSibling = getChild(this.sortable.el, this.startIndex, this.options);

    if (nextSibling) {
      this.sortable.el.insertBefore(dragEl, nextSibling);
    } else {
      this.sortable.el.appendChild(dragEl);
    }

    this.sortable.animateAll();

    if (putSortable) {
      putSortable.animateAll();
    }
  },
  drop: drop
};

_extends(Revert, {
  pluginName: 'revertOnSpill'
});

function Remove() {}

Remove.prototype = {
  onSpill: function onSpill(_ref4) {
    var dragEl = _ref4.dragEl,
        putSortable = _ref4.putSortable;
    var parentSortable = putSortable || this.sortable;
    parentSortable.captureAnimationState();
    dragEl.parentNode && dragEl.parentNode.removeChild(dragEl);
    parentSortable.animateAll();
  },
  drop: drop
};

_extends(Remove, {
  pluginName: 'removeOnSpill'
});

var lastSwapEl;

function SwapPlugin() {
  function Swap() {
    this.defaults = {
      swapClass: 'sortable-swap-highlight'
    };
  }

  Swap.prototype = {
    dragStart: function dragStart(_ref) {
      var dragEl = _ref.dragEl;
      lastSwapEl = dragEl;
    },
    dragOverValid: function dragOverValid(_ref2) {
      var completed = _ref2.completed,
          target = _ref2.target,
          onMove = _ref2.onMove,
          activeSortable = _ref2.activeSortable,
          changed = _ref2.changed,
          cancel = _ref2.cancel;
      if (!activeSortable.options.swap) return;
      var el = this.sortable.el,
          options = this.options;

      if (target && target !== el) {
        var prevSwapEl = lastSwapEl;

        if (onMove(target) !== false) {
          toggleClass(target, options.swapClass, true);
          lastSwapEl = target;
        } else {
          lastSwapEl = null;
        }

        if (prevSwapEl && prevSwapEl !== lastSwapEl) {
          toggleClass(prevSwapEl, options.swapClass, false);
        }
      }

      changed();
      completed(true);
      cancel();
    },
    drop: function drop(_ref3) {
      var activeSortable = _ref3.activeSortable,
          putSortable = _ref3.putSortable,
          dragEl = _ref3.dragEl;
      var toSortable = putSortable || this.sortable;
      var options = this.options;
      lastSwapEl && toggleClass(lastSwapEl, options.swapClass, false);

      if (lastSwapEl && (options.swap || putSortable && putSortable.options.swap)) {
        if (dragEl !== lastSwapEl) {
          toSortable.captureAnimationState();
          if (toSortable !== activeSortable) activeSortable.captureAnimationState();
          swapNodes(dragEl, lastSwapEl);
          toSortable.animateAll();
          if (toSortable !== activeSortable) activeSortable.animateAll();
        }
      }
    },
    nulling: function nulling() {
      lastSwapEl = null;
    }
  };
  return _extends(Swap, {
    pluginName: 'swap',
    eventProperties: function eventProperties() {
      return {
        swapItem: lastSwapEl
      };
    }
  });
}

function swapNodes(n1, n2) {
  var p1 = n1.parentNode,
      p2 = n2.parentNode,
      i1,
      i2;
  if (!p1 || !p2 || p1.isEqualNode(n2) || p2.isEqualNode(n1)) return;
  i1 = index(n1);
  i2 = index(n2);

  if (p1.isEqualNode(p2) && i1 < i2) {
    i2++;
  }

  p1.insertBefore(n2, p1.children[i1]);
  p2.insertBefore(n1, p2.children[i2]);
}

var multiDragElements = [],
    multiDragClones = [],
    lastMultiDragSelect,
    // for selection with modifier key down (SHIFT)
multiDragSortable,
    initialFolding = false,
    // Initial multi-drag fold when drag started
folding = false,
    // Folding any other time
dragStarted = false,
    dragEl$1,
    clonesFromRect,
    clonesHidden;

function MultiDragPlugin() {
  function MultiDrag(sortable) {
    // Bind all private methods
    for (var fn in this) {
      if (fn.charAt(0) === '_' && typeof this[fn] === 'function') {
        this[fn] = this[fn].bind(this);
      }
    }

    if (sortable.options.supportPointer) {
      on(document, 'pointerup', this._deselectMultiDrag);
    } else {
      on(document, 'mouseup', this._deselectMultiDrag);
      on(document, 'touchend', this._deselectMultiDrag);
    }

    on(document, 'keydown', this._checkKeyDown);
    on(document, 'keyup', this._checkKeyUp);
    this.defaults = {
      selectedClass: 'sortable-selected',
      multiDragKey: null,
      setData: function setData(dataTransfer, dragEl) {
        var data = '';

        if (multiDragElements.length && multiDragSortable === sortable) {
          multiDragElements.forEach(function (multiDragElement, i) {
            data += (!i ? '' : ', ') + multiDragElement.textContent;
          });
        } else {
          data = dragEl.textContent;
        }

        dataTransfer.setData('Text', data);
      }
    };
  }

  MultiDrag.prototype = {
    multiDragKeyDown: false,
    isMultiDrag: false,
    delayStartGlobal: function delayStartGlobal(_ref) {
      var dragged = _ref.dragEl;
      dragEl$1 = dragged;
    },
    delayEnded: function delayEnded() {
      this.isMultiDrag = ~multiDragElements.indexOf(dragEl$1);
    },
    setupClone: function setupClone(_ref2) {
      var sortable = _ref2.sortable,
          cancel = _ref2.cancel;
      if (!this.isMultiDrag) return;

      for (var i = 0; i < multiDragElements.length; i++) {
        multiDragClones.push(clone(multiDragElements[i]));
        multiDragClones[i].sortableIndex = multiDragElements[i].sortableIndex;
        multiDragClones[i].draggable = false;
        multiDragClones[i].style['will-change'] = '';
        toggleClass(multiDragClones[i], this.options.selectedClass, false);
        multiDragElements[i] === dragEl$1 && toggleClass(multiDragClones[i], this.options.chosenClass, false);
      }

      sortable._hideClone();

      cancel();
    },
    clone: function clone(_ref3) {
      var sortable = _ref3.sortable,
          rootEl = _ref3.rootEl,
          dispatchSortableEvent = _ref3.dispatchSortableEvent,
          cancel = _ref3.cancel;
      if (!this.isMultiDrag) return;

      if (!this.options.removeCloneOnHide) {
        if (multiDragElements.length && multiDragSortable === sortable) {
          insertMultiDragClones(true, rootEl);
          dispatchSortableEvent('clone');
          cancel();
        }
      }
    },
    showClone: function showClone(_ref4) {
      var cloneNowShown = _ref4.cloneNowShown,
          rootEl = _ref4.rootEl,
          cancel = _ref4.cancel;
      if (!this.isMultiDrag) return;
      insertMultiDragClones(false, rootEl);
      multiDragClones.forEach(function (clone) {
        css(clone, 'display', '');
      });
      cloneNowShown();
      clonesHidden = false;
      cancel();
    },
    hideClone: function hideClone(_ref5) {
      var _this = this;

      var sortable = _ref5.sortable,
          cloneNowHidden = _ref5.cloneNowHidden,
          cancel = _ref5.cancel;
      if (!this.isMultiDrag) return;
      multiDragClones.forEach(function (clone) {
        css(clone, 'display', 'none');

        if (_this.options.removeCloneOnHide && clone.parentNode) {
          clone.parentNode.removeChild(clone);
        }
      });
      cloneNowHidden();
      clonesHidden = true;
      cancel();
    },
    dragStartGlobal: function dragStartGlobal(_ref6) {
      var sortable = _ref6.sortable;

      if (!this.isMultiDrag && multiDragSortable) {
        multiDragSortable.multiDrag._deselectMultiDrag();
      }

      multiDragElements.forEach(function (multiDragElement) {
        multiDragElement.sortableIndex = index(multiDragElement);
      }); // Sort multi-drag elements

      multiDragElements = multiDragElements.sort(function (a, b) {
        return a.sortableIndex - b.sortableIndex;
      });
      dragStarted = true;
    },
    dragStarted: function dragStarted(_ref7) {
      var _this2 = this;

      var sortable = _ref7.sortable;
      if (!this.isMultiDrag) return;

      if (this.options.sort) {
        // Capture rects,
        // hide multi drag elements (by positioning them absolute),
        // set multi drag elements rects to dragRect,
        // show multi drag elements,
        // animate to rects,
        // unset rects & remove from DOM
        sortable.captureAnimationState();

        if (this.options.animation) {
          multiDragElements.forEach(function (multiDragElement) {
            if (multiDragElement === dragEl$1) return;
            css(multiDragElement, 'position', 'absolute');
          });
          var dragRect = getRect(dragEl$1, false, true, true);
          multiDragElements.forEach(function (multiDragElement) {
            if (multiDragElement === dragEl$1) return;
            setRect(multiDragElement, dragRect);
          });
          folding = true;
          initialFolding = true;
        }
      }

      sortable.animateAll(function () {
        folding = false;
        initialFolding = false;

        if (_this2.options.animation) {
          multiDragElements.forEach(function (multiDragElement) {
            unsetRect(multiDragElement);
          });
        } // Remove all auxiliary multidrag items from el, if sorting enabled


        if (_this2.options.sort) {
          removeMultiDragElements();
        }
      });
    },
    dragOver: function dragOver(_ref8) {
      var target = _ref8.target,
          completed = _ref8.completed,
          cancel = _ref8.cancel;

      if (folding && ~multiDragElements.indexOf(target)) {
        completed(false);
        cancel();
      }
    },
    revert: function revert(_ref9) {
      var fromSortable = _ref9.fromSortable,
          rootEl = _ref9.rootEl,
          sortable = _ref9.sortable,
          dragRect = _ref9.dragRect;

      if (multiDragElements.length > 1) {
        // Setup unfold animation
        multiDragElements.forEach(function (multiDragElement) {
          sortable.addAnimationState({
            target: multiDragElement,
            rect: folding ? getRect(multiDragElement) : dragRect
          });
          unsetRect(multiDragElement);
          multiDragElement.fromRect = dragRect;
          fromSortable.removeAnimationState(multiDragElement);
        });
        folding = false;
        insertMultiDragElements(!this.options.removeCloneOnHide, rootEl);
      }
    },
    dragOverCompleted: function dragOverCompleted(_ref10) {
      var sortable = _ref10.sortable,
          isOwner = _ref10.isOwner,
          insertion = _ref10.insertion,
          activeSortable = _ref10.activeSortable,
          parentEl = _ref10.parentEl,
          putSortable = _ref10.putSortable;
      var options = this.options;

      if (insertion) {
        // Clones must be hidden before folding animation to capture dragRectAbsolute properly
        if (isOwner) {
          activeSortable._hideClone();
        }

        initialFolding = false; // If leaving sort:false root, or already folding - Fold to new location

        if (options.animation && multiDragElements.length > 1 && (folding || !isOwner && !activeSortable.options.sort && !putSortable)) {
          // Fold: Set all multi drag elements's rects to dragEl's rect when multi-drag elements are invisible
          var dragRectAbsolute = getRect(dragEl$1, false, true, true);
          multiDragElements.forEach(function (multiDragElement) {
            if (multiDragElement === dragEl$1) return;
            setRect(multiDragElement, dragRectAbsolute); // Move element(s) to end of parentEl so that it does not interfere with multi-drag clones insertion if they are inserted
            // while folding, and so that we can capture them again because old sortable will no longer be fromSortable

            parentEl.appendChild(multiDragElement);
          });
          folding = true;
        } // Clones must be shown (and check to remove multi drags) after folding when interfering multiDragElements are moved out


        if (!isOwner) {
          // Only remove if not folding (folding will remove them anyways)
          if (!folding) {
            removeMultiDragElements();
          }

          if (multiDragElements.length > 1) {
            var clonesHiddenBefore = clonesHidden;

            activeSortable._showClone(sortable); // Unfold animation for clones if showing from hidden


            if (activeSortable.options.animation && !clonesHidden && clonesHiddenBefore) {
              multiDragClones.forEach(function (clone) {
                activeSortable.addAnimationState({
                  target: clone,
                  rect: clonesFromRect
                });
                clone.fromRect = clonesFromRect;
                clone.thisAnimationDuration = null;
              });
            }
          } else {
            activeSortable._showClone(sortable);
          }
        }
      }
    },
    dragOverAnimationCapture: function dragOverAnimationCapture(_ref11) {
      var dragRect = _ref11.dragRect,
          isOwner = _ref11.isOwner,
          activeSortable = _ref11.activeSortable;
      multiDragElements.forEach(function (multiDragElement) {
        multiDragElement.thisAnimationDuration = null;
      });

      if (activeSortable.options.animation && !isOwner && activeSortable.multiDrag.isMultiDrag) {
        clonesFromRect = _extends({}, dragRect);
        var dragMatrix = matrix(dragEl$1, true);
        clonesFromRect.top -= dragMatrix.f;
        clonesFromRect.left -= dragMatrix.e;
      }
    },
    dragOverAnimationComplete: function dragOverAnimationComplete() {
      if (folding) {
        folding = false;
        removeMultiDragElements();
      }
    },
    drop: function drop(_ref12) {
      var evt = _ref12.originalEvent,
          rootEl = _ref12.rootEl,
          parentEl = _ref12.parentEl,
          sortable = _ref12.sortable,
          dispatchSortableEvent = _ref12.dispatchSortableEvent,
          oldIndex = _ref12.oldIndex,
          putSortable = _ref12.putSortable;
      var toSortable = putSortable || this.sortable;
      if (!evt) return;
      var options = this.options,
          children = parentEl.children; // Multi-drag selection

      if (!dragStarted) {
        if (options.multiDragKey && !this.multiDragKeyDown) {
          this._deselectMultiDrag();
        }

        toggleClass(dragEl$1, options.selectedClass, !~multiDragElements.indexOf(dragEl$1));

        if (!~multiDragElements.indexOf(dragEl$1)) {
          multiDragElements.push(dragEl$1);
          dispatchEvent({
            sortable: sortable,
            rootEl: rootEl,
            name: 'select',
            targetEl: dragEl$1,
            originalEvt: evt
          }); // Modifier activated, select from last to dragEl

          if (evt.shiftKey && lastMultiDragSelect && sortable.el.contains(lastMultiDragSelect)) {
            var lastIndex = index(lastMultiDragSelect),
                currentIndex = index(dragEl$1);

            if (~lastIndex && ~currentIndex && lastIndex !== currentIndex) {
              // Must include lastMultiDragSelect (select it), in case modified selection from no selection
              // (but previous selection existed)
              var n, i;

              if (currentIndex > lastIndex) {
                i = lastIndex;
                n = currentIndex;
              } else {
                i = currentIndex;
                n = lastIndex + 1;
              }

              for (; i < n; i++) {
                if (~multiDragElements.indexOf(children[i])) continue;
                toggleClass(children[i], options.selectedClass, true);
                multiDragElements.push(children[i]);
                dispatchEvent({
                  sortable: sortable,
                  rootEl: rootEl,
                  name: 'select',
                  targetEl: children[i],
                  originalEvt: evt
                });
              }
            }
          } else {
            lastMultiDragSelect = dragEl$1;
          }

          multiDragSortable = toSortable;
        } else {
          multiDragElements.splice(multiDragElements.indexOf(dragEl$1), 1);
          lastMultiDragSelect = null;
          dispatchEvent({
            sortable: sortable,
            rootEl: rootEl,
            name: 'deselect',
            targetEl: dragEl$1,
            originalEvt: evt
          });
        }
      } // Multi-drag drop


      if (dragStarted && this.isMultiDrag) {
        // Do not "unfold" after around dragEl if reverted
        if ((parentEl[expando].options.sort || parentEl !== rootEl) && multiDragElements.length > 1) {
          var dragRect = getRect(dragEl$1),
              multiDragIndex = index(dragEl$1, ':not(.' + this.options.selectedClass + ')');
          if (!initialFolding && options.animation) dragEl$1.thisAnimationDuration = null;
          toSortable.captureAnimationState();

          if (!initialFolding) {
            if (options.animation) {
              dragEl$1.fromRect = dragRect;
              multiDragElements.forEach(function (multiDragElement) {
                multiDragElement.thisAnimationDuration = null;

                if (multiDragElement !== dragEl$1) {
                  var rect = folding ? getRect(multiDragElement) : dragRect;
                  multiDragElement.fromRect = rect; // Prepare unfold animation

                  toSortable.addAnimationState({
                    target: multiDragElement,
                    rect: rect
                  });
                }
              });
            } // Multi drag elements are not necessarily removed from the DOM on drop, so to reinsert
            // properly they must all be removed


            removeMultiDragElements();
            multiDragElements.forEach(function (multiDragElement) {
              if (children[multiDragIndex]) {
                parentEl.insertBefore(multiDragElement, children[multiDragIndex]);
              } else {
                parentEl.appendChild(multiDragElement);
              }

              multiDragIndex++;
            }); // If initial folding is done, the elements may have changed position because they are now
            // unfolding around dragEl, even though dragEl may not have his index changed, so update event
            // must be fired here as Sortable will not.

            if (oldIndex === index(dragEl$1)) {
              var update = false;
              multiDragElements.forEach(function (multiDragElement) {
                if (multiDragElement.sortableIndex !== index(multiDragElement)) {
                  update = true;
                  return;
                }
              });

              if (update) {
                dispatchSortableEvent('update');
              }
            }
          } // Must be done after capturing individual rects (scroll bar)


          multiDragElements.forEach(function (multiDragElement) {
            unsetRect(multiDragElement);
          });
          toSortable.animateAll();
        }

        multiDragSortable = toSortable;
      } // Remove clones if necessary


      if (rootEl === parentEl || putSortable && putSortable.lastPutMode !== 'clone') {
        multiDragClones.forEach(function (clone) {
          clone.parentNode && clone.parentNode.removeChild(clone);
        });
      }
    },
    nullingGlobal: function nullingGlobal() {
      this.isMultiDrag = dragStarted = false;
      multiDragClones.length = 0;
    },
    destroyGlobal: function destroyGlobal() {
      this._deselectMultiDrag();

      off(document, 'pointerup', this._deselectMultiDrag);
      off(document, 'mouseup', this._deselectMultiDrag);
      off(document, 'touchend', this._deselectMultiDrag);
      off(document, 'keydown', this._checkKeyDown);
      off(document, 'keyup', this._checkKeyUp);
    },
    _deselectMultiDrag: function _deselectMultiDrag(evt) {
      if (typeof dragStarted !== "undefined" && dragStarted) return; // Only deselect if selection is in this sortable

      if (multiDragSortable !== this.sortable) return; // Only deselect if target is not item in this sortable

      if (evt && closest(evt.target, this.options.draggable, this.sortable.el, false)) return; // Only deselect if left click

      if (evt && evt.button !== 0) return;

      while (multiDragElements.length) {
        var el = multiDragElements[0];
        toggleClass(el, this.options.selectedClass, false);
        multiDragElements.shift();
        dispatchEvent({
          sortable: this.sortable,
          rootEl: this.sortable.el,
          name: 'deselect',
          targetEl: el,
          originalEvt: evt
        });
      }
    },
    _checkKeyDown: function _checkKeyDown(evt) {
      if (evt.key === this.options.multiDragKey) {
        this.multiDragKeyDown = true;
      }
    },
    _checkKeyUp: function _checkKeyUp(evt) {
      if (evt.key === this.options.multiDragKey) {
        this.multiDragKeyDown = false;
      }
    }
  };
  return _extends(MultiDrag, {
    // Static methods & properties
    pluginName: 'multiDrag',
    utils: {
      /**
       * Selects the provided multi-drag item
       * @param  {HTMLElement} el    The element to be selected
       */
      select: function select(el) {
        var sortable = el.parentNode[expando];
        if (!sortable || !sortable.options.multiDrag || ~multiDragElements.indexOf(el)) return;

        if (multiDragSortable && multiDragSortable !== sortable) {
          multiDragSortable.multiDrag._deselectMultiDrag();

          multiDragSortable = sortable;
        }

        toggleClass(el, sortable.options.selectedClass, true);
        multiDragElements.push(el);
      },

      /**
       * Deselects the provided multi-drag item
       * @param  {HTMLElement} el    The element to be deselected
       */
      deselect: function deselect(el) {
        var sortable = el.parentNode[expando],
            index = multiDragElements.indexOf(el);
        if (!sortable || !sortable.options.multiDrag || !~index) return;
        toggleClass(el, sortable.options.selectedClass, false);
        multiDragElements.splice(index, 1);
      }
    },
    eventProperties: function eventProperties() {
      var _this3 = this;

      var oldIndicies = [],
          newIndicies = [];
      multiDragElements.forEach(function (multiDragElement) {
        oldIndicies.push({
          multiDragElement: multiDragElement,
          index: multiDragElement.sortableIndex
        }); // multiDragElements will already be sorted if folding

        var newIndex;

        if (folding && multiDragElement !== dragEl$1) {
          newIndex = -1;
        } else if (folding) {
          newIndex = index(multiDragElement, ':not(.' + _this3.options.selectedClass + ')');
        } else {
          newIndex = index(multiDragElement);
        }

        newIndicies.push({
          multiDragElement: multiDragElement,
          index: newIndex
        });
      });
      return {
        items: _toConsumableArray(multiDragElements),
        clones: [].concat(multiDragClones),
        oldIndicies: oldIndicies,
        newIndicies: newIndicies
      };
    },
    optionListeners: {
      multiDragKey: function multiDragKey(key) {
        key = key.toLowerCase();

        if (key === 'ctrl') {
          key = 'Control';
        } else if (key.length > 1) {
          key = key.charAt(0).toUpperCase() + key.substr(1);
        }

        return key;
      }
    }
  });
}

function insertMultiDragElements(clonesInserted, rootEl) {
  multiDragElements.forEach(function (multiDragElement, i) {
    var target = rootEl.children[multiDragElement.sortableIndex + (clonesInserted ? Number(i) : 0)];

    if (target) {
      rootEl.insertBefore(multiDragElement, target);
    } else {
      rootEl.appendChild(multiDragElement);
    }
  });
}
/**
 * Insert multi-drag clones
 * @param  {[Boolean]} elementsInserted  Whether the multi-drag elements are inserted
 * @param  {HTMLElement} rootEl
 */


function insertMultiDragClones(elementsInserted, rootEl) {
  multiDragClones.forEach(function (clone, i) {
    var target = rootEl.children[clone.sortableIndex + (elementsInserted ? Number(i) : 0)];

    if (target) {
      rootEl.insertBefore(clone, target);
    } else {
      rootEl.appendChild(clone);
    }
  });
}

function removeMultiDragElements() {
  multiDragElements.forEach(function (multiDragElement) {
    if (multiDragElement === dragEl$1) return;
    multiDragElement.parentNode && multiDragElement.parentNode.removeChild(multiDragElement);
  });
}

Sortable.mount(new AutoScrollPlugin());
Sortable.mount(Remove, Revert);

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Sortable);



/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/ItemPlan.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/ItemPlan.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ItemPlan_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ItemPlan.vue?vue&type=style&index=0&scope=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/ItemPlan.vue?vue&type=style&index=0&scope=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ItemPlan_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ItemPlan_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/List.vue?vue&type=style&index=0&media=screen&lang=css&":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/List.vue?vue&type=style&index=0&media=screen&lang=css& ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_List_vue_vue_type_style_index_0_media_screen_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./List.vue?vue&type=style&index=0&media=screen&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/List.vue?vue&type=style&index=0&media=screen&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_List_vue_vue_type_style_index_0_media_screen_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_List_vue_vue_type_style_index_0_media_screen_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_OMSalesForecast_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_OMSalesForecast_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_OMSalesForecast_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/PlanDaily.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/PlanDaily.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PlanDaily_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PlanDaily.vue?vue&type=style&index=0&scope=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/PlanDaily.vue?vue&type=style&index=0&scope=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PlanDaily_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PlanDaily_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/components/Planning/Production-Daily/ModalSearch.vue":
/*!***************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Daily/ModalSearch.vue ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ModalSearch_vue_vue_type_template_id_735e8722___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ModalSearch.vue?vue&type=template&id=735e8722& */ "./resources/js/components/Planning/Production-Daily/ModalSearch.vue?vue&type=template&id=735e8722&");
/* harmony import */ var _ModalSearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalSearch.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Production-Daily/ModalSearch.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _ModalSearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ModalSearch_vue_vue_type_template_id_735e8722___WEBPACK_IMPORTED_MODULE_0__.render,
  _ModalSearch_vue_vue_type_template_id_735e8722___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Production-Daily/ModalSearch.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Production-Daily/ShowComponent.vue":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Daily/ShowComponent.vue ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ShowComponent_vue_vue_type_template_id_3860802d___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ShowComponent.vue?vue&type=template&id=3860802d& */ "./resources/js/components/Planning/Production-Daily/ShowComponent.vue?vue&type=template&id=3860802d&");
/* harmony import */ var _ShowComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ShowComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Production-Daily/ShowComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _ShowComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ShowComponent_vue_vue_type_template_id_3860802d___WEBPACK_IMPORTED_MODULE_0__.render,
  _ShowComponent_vue_vue_type_template_id_3860802d___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Production-Daily/ShowComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Production-Daily/components/HeaderDetail.vue":
/*!***************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Daily/components/HeaderDetail.vue ***!
  \***************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _HeaderDetail_vue_vue_type_template_id_20cddfc4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./HeaderDetail.vue?vue&type=template&id=20cddfc4& */ "./resources/js/components/Planning/Production-Daily/components/HeaderDetail.vue?vue&type=template&id=20cddfc4&");
/* harmony import */ var _HeaderDetail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./HeaderDetail.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Production-Daily/components/HeaderDetail.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _HeaderDetail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _HeaderDetail_vue_vue_type_template_id_20cddfc4___WEBPACK_IMPORTED_MODULE_0__.render,
  _HeaderDetail_vue_vue_type_template_id_20cddfc4___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Production-Daily/components/HeaderDetail.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Production-Daily/components/ItemPlan.vue":
/*!***********************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Daily/components/ItemPlan.vue ***!
  \***********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ItemPlan_vue_vue_type_template_id_26f83762___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ItemPlan.vue?vue&type=template&id=26f83762& */ "./resources/js/components/Planning/Production-Daily/components/ItemPlan.vue?vue&type=template&id=26f83762&");
/* harmony import */ var _ItemPlan_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ItemPlan.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Production-Daily/components/ItemPlan.vue?vue&type=script&lang=js&");
/* harmony import */ var _ItemPlan_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ItemPlan.vue?vue&type=style&index=0&scope=true&lang=css& */ "./resources/js/components/Planning/Production-Daily/components/ItemPlan.vue?vue&type=style&index=0&scope=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _ItemPlan_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ItemPlan_vue_vue_type_template_id_26f83762___WEBPACK_IMPORTED_MODULE_0__.render,
  _ItemPlan_vue_vue_type_template_id_26f83762___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Production-Daily/components/ItemPlan.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Production-Daily/components/List.vue":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Daily/components/List.vue ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _List_vue_vue_type_template_id_2fc4b5b8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./List.vue?vue&type=template&id=2fc4b5b8& */ "./resources/js/components/Planning/Production-Daily/components/List.vue?vue&type=template&id=2fc4b5b8&");
/* harmony import */ var _List_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./List.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Production-Daily/components/List.vue?vue&type=script&lang=js&");
/* harmony import */ var _List_vue_vue_type_style_index_0_media_screen_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./List.vue?vue&type=style&index=0&media=screen&lang=css& */ "./resources/js/components/Planning/Production-Daily/components/List.vue?vue&type=style&index=0&media=screen&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _List_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _List_vue_vue_type_template_id_2fc4b5b8___WEBPACK_IMPORTED_MODULE_0__.render,
  _List_vue_vue_type_template_id_2fc4b5b8___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Production-Daily/components/List.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Production-Daily/components/ModalControl.vue":
/*!***************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Daily/components/ModalControl.vue ***!
  \***************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ModalControl_vue_vue_type_template_id_dd257914___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ModalControl.vue?vue&type=template&id=dd257914& */ "./resources/js/components/Planning/Production-Daily/components/ModalControl.vue?vue&type=template&id=dd257914&");
/* harmony import */ var _ModalControl_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalControl.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Production-Daily/components/ModalControl.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _ModalControl_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ModalControl_vue_vue_type_template_id_dd257914___WEBPACK_IMPORTED_MODULE_0__.render,
  _ModalControl_vue_vue_type_template_id_dd257914___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Production-Daily/components/ModalControl.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Production-Daily/components/OMSalesForecast.vue":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Daily/components/OMSalesForecast.vue ***!
  \******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _OMSalesForecast_vue_vue_type_template_id_4f151673___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./OMSalesForecast.vue?vue&type=template&id=4f151673& */ "./resources/js/components/Planning/Production-Daily/components/OMSalesForecast.vue?vue&type=template&id=4f151673&");
/* harmony import */ var _OMSalesForecast_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./OMSalesForecast.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Production-Daily/components/OMSalesForecast.vue?vue&type=script&lang=js&");
/* harmony import */ var _OMSalesForecast_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css& */ "./resources/js/components/Planning/Production-Daily/components/OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _OMSalesForecast_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _OMSalesForecast_vue_vue_type_template_id_4f151673___WEBPACK_IMPORTED_MODULE_0__.render,
  _OMSalesForecast_vue_vue_type_template_id_4f151673___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Production-Daily/components/OMSalesForecast.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Production-Daily/components/PlanDaily.vue":
/*!************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Daily/components/PlanDaily.vue ***!
  \************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _PlanDaily_vue_vue_type_template_id_4298da4c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PlanDaily.vue?vue&type=template&id=4298da4c& */ "./resources/js/components/Planning/Production-Daily/components/PlanDaily.vue?vue&type=template&id=4298da4c&");
/* harmony import */ var _PlanDaily_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PlanDaily.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Production-Daily/components/PlanDaily.vue?vue&type=script&lang=js&");
/* harmony import */ var _PlanDaily_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./PlanDaily.vue?vue&type=style&index=0&scope=true&lang=css& */ "./resources/js/components/Planning/Production-Daily/components/PlanDaily.vue?vue&type=style&index=0&scope=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _PlanDaily_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _PlanDaily_vue_vue_type_template_id_4298da4c___WEBPACK_IMPORTED_MODULE_0__.render,
  _PlanDaily_vue_vue_type_template_id_4298da4c___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Production-Daily/components/PlanDaily.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Production-Daily/ModalSearch.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Daily/ModalSearch.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearch.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/ModalSearch.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Production-Daily/ShowComponent.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Daily/ShowComponent.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ShowComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/ShowComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Production-Daily/components/HeaderDetail.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Daily/components/HeaderDetail.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_HeaderDetail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./HeaderDetail.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/HeaderDetail.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_HeaderDetail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Production-Daily/components/ItemPlan.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Daily/components/ItemPlan.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ItemPlan_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ItemPlan.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/ItemPlan.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ItemPlan_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Production-Daily/components/List.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Daily/components/List.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_List_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./List.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/List.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_List_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Production-Daily/components/ModalControl.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Daily/components/ModalControl.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalControl_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalControl.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/ModalControl.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalControl_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Production-Daily/components/OMSalesForecast.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Daily/components/OMSalesForecast.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_OMSalesForecast_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./OMSalesForecast.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/OMSalesForecast.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_OMSalesForecast_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Production-Daily/components/PlanDaily.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Daily/components/PlanDaily.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PlanDaily_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PlanDaily.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/PlanDaily.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PlanDaily_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Production-Daily/components/ItemPlan.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!*******************************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Daily/components/ItemPlan.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \*******************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ItemPlan_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/style-loader/dist/cjs.js!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ItemPlan.vue?vue&type=style&index=0&scope=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/ItemPlan.vue?vue&type=style&index=0&scope=true&lang=css&");


/***/ }),

/***/ "./resources/js/components/Planning/Production-Daily/components/List.vue?vue&type=style&index=0&media=screen&lang=css&":
/*!*****************************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Daily/components/List.vue?vue&type=style&index=0&media=screen&lang=css& ***!
  \*****************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_List_vue_vue_type_style_index_0_media_screen_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/style-loader/dist/cjs.js!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./List.vue?vue&type=style&index=0&media=screen&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/List.vue?vue&type=style&index=0&media=screen&lang=css&");


/***/ }),

/***/ "./resources/js/components/Planning/Production-Daily/components/OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!**************************************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Daily/components/OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \**************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_OMSalesForecast_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/style-loader/dist/cjs.js!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css&");


/***/ }),

/***/ "./resources/js/components/Planning/Production-Daily/components/PlanDaily.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!********************************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Daily/components/PlanDaily.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \********************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PlanDaily_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/style-loader/dist/cjs.js!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PlanDaily.vue?vue&type=style&index=0&scope=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/PlanDaily.vue?vue&type=style&index=0&scope=true&lang=css&");


/***/ }),

/***/ "./resources/js/components/Planning/Production-Daily/ModalSearch.vue?vue&type=template&id=735e8722&":
/*!**********************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Daily/ModalSearch.vue?vue&type=template&id=735e8722& ***!
  \**********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_template_id_735e8722___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_template_id_735e8722___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_template_id_735e8722___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearch.vue?vue&type=template&id=735e8722& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/ModalSearch.vue?vue&type=template&id=735e8722&");


/***/ }),

/***/ "./resources/js/components/Planning/Production-Daily/ShowComponent.vue?vue&type=template&id=3860802d&":
/*!************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Daily/ShowComponent.vue?vue&type=template&id=3860802d& ***!
  \************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowComponent_vue_vue_type_template_id_3860802d___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowComponent_vue_vue_type_template_id_3860802d___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowComponent_vue_vue_type_template_id_3860802d___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ShowComponent.vue?vue&type=template&id=3860802d& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/ShowComponent.vue?vue&type=template&id=3860802d&");


/***/ }),

/***/ "./resources/js/components/Planning/Production-Daily/components/HeaderDetail.vue?vue&type=template&id=20cddfc4&":
/*!**********************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Daily/components/HeaderDetail.vue?vue&type=template&id=20cddfc4& ***!
  \**********************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HeaderDetail_vue_vue_type_template_id_20cddfc4___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HeaderDetail_vue_vue_type_template_id_20cddfc4___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HeaderDetail_vue_vue_type_template_id_20cddfc4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./HeaderDetail.vue?vue&type=template&id=20cddfc4& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/HeaderDetail.vue?vue&type=template&id=20cddfc4&");


/***/ }),

/***/ "./resources/js/components/Planning/Production-Daily/components/ItemPlan.vue?vue&type=template&id=26f83762&":
/*!******************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Daily/components/ItemPlan.vue?vue&type=template&id=26f83762& ***!
  \******************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ItemPlan_vue_vue_type_template_id_26f83762___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ItemPlan_vue_vue_type_template_id_26f83762___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ItemPlan_vue_vue_type_template_id_26f83762___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ItemPlan.vue?vue&type=template&id=26f83762& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/ItemPlan.vue?vue&type=template&id=26f83762&");


/***/ }),

/***/ "./resources/js/components/Planning/Production-Daily/components/List.vue?vue&type=template&id=2fc4b5b8&":
/*!**************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Daily/components/List.vue?vue&type=template&id=2fc4b5b8& ***!
  \**************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_List_vue_vue_type_template_id_2fc4b5b8___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_List_vue_vue_type_template_id_2fc4b5b8___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_List_vue_vue_type_template_id_2fc4b5b8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./List.vue?vue&type=template&id=2fc4b5b8& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/List.vue?vue&type=template&id=2fc4b5b8&");


/***/ }),

/***/ "./resources/js/components/Planning/Production-Daily/components/ModalControl.vue?vue&type=template&id=dd257914&":
/*!**********************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Daily/components/ModalControl.vue?vue&type=template&id=dd257914& ***!
  \**********************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalControl_vue_vue_type_template_id_dd257914___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalControl_vue_vue_type_template_id_dd257914___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalControl_vue_vue_type_template_id_dd257914___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalControl.vue?vue&type=template&id=dd257914& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/ModalControl.vue?vue&type=template&id=dd257914&");


/***/ }),

/***/ "./resources/js/components/Planning/Production-Daily/components/OMSalesForecast.vue?vue&type=template&id=4f151673&":
/*!*************************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Daily/components/OMSalesForecast.vue?vue&type=template&id=4f151673& ***!
  \*************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_OMSalesForecast_vue_vue_type_template_id_4f151673___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_OMSalesForecast_vue_vue_type_template_id_4f151673___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_OMSalesForecast_vue_vue_type_template_id_4f151673___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./OMSalesForecast.vue?vue&type=template&id=4f151673& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/OMSalesForecast.vue?vue&type=template&id=4f151673&");


/***/ }),

/***/ "./resources/js/components/Planning/Production-Daily/components/PlanDaily.vue?vue&type=template&id=4298da4c&":
/*!*******************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Daily/components/PlanDaily.vue?vue&type=template&id=4298da4c& ***!
  \*******************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PlanDaily_vue_vue_type_template_id_4298da4c___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PlanDaily_vue_vue_type_template_id_4298da4c___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PlanDaily_vue_vue_type_template_id_4298da4c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PlanDaily.vue?vue&type=template&id=4298da4c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/PlanDaily.vue?vue&type=template&id=4298da4c&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/ModalSearch.vue?vue&type=template&id=735e8722&":
/*!*************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/ModalSearch.vue?vue&type=template&id=735e8722& ***!
  \*************************************************************************************************************************************************************************************************************************************************/
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
  return _c("span", [
    _c(
      "button",
      {
        class: _vm.btnTrans.search.class + " btn-lg tw-w-25",
        attrs: { type: "button" },
        on: { click: _vm.openModal }
      },
      [
        _c("i", { class: _vm.btnTrans.search.icon }),
        _vm._v("\n        " + _vm._s(_vm.btnTrans.search.text) + "\n    ")
      ]
    ),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass: "modal fade",
        attrs: {
          id: "modal_search",
          tabindex: "-1",
          role: "dialog",
          "aria-hidden": "true"
        }
      },
      [
        _c("div", { staticClass: "modal-dialog modal-lg" }, [
          _c(
            "div",
            {
              directives: [
                {
                  name: "loading",
                  rawName: "v-loading",
                  value: _vm.loading,
                  expression: "loading"
                }
              ],
              staticClass: "modal-content"
            },
            [
              _vm._m(0),
              _vm._v(" "),
              _c("div", { staticClass: "modal-body text-left" }, [
                _c("form", { attrs: { id: "search-form" } }, [
                  _c("div", { staticClass: "row col-12" }, [
                    _c(
                      "div",
                      {
                        staticClass:
                          "form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2"
                      },
                      [
                        _c(
                          "label",
                          {
                            staticClass:
                              "text-left tw-font-bold tw-uppercase mb-1"
                          },
                          [_vm._v(" ปีงบประมาณ :")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "input-group " },
                          [
                            _c("input", {
                              attrs: {
                                type: "hidden",
                                name: "search[budget_year]"
                              },
                              domProps: { value: _vm.budget_year }
                            }),
                            _vm._v(" "),
                            _c(
                              "el-select",
                              {
                                ref: "budget_year",
                                attrs: {
                                  size: "large",
                                  placeholder: "ปีงบประมาณ",
                                  clearable: "",
                                  filterable: "",
                                  "popper-append-to-body": false
                                },
                                on: { change: _vm.getMonth },
                                model: {
                                  value: _vm.budget_year,
                                  callback: function($$v) {
                                    _vm.budget_year = $$v
                                  },
                                  expression: "budget_year"
                                }
                              },
                              _vm._l(_vm.budgetYears, function(year, index) {
                                return _c("el-option", {
                                  key: index,
                                  attrs: {
                                    label: year.thai_year,
                                    value: year.thai_year
                                  }
                                })
                              }),
                              1
                            ),
                            _vm._v(" "),
                            _c("div", {
                              staticClass: "error_msg text-left",
                              attrs: { id: "el_explode_budget_year" }
                            })
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
                          "form-group pl-2 pr-2 mb-0 col-lg-3 col-md-4 col-sm-6 col-xs-6 mt-2"
                      },
                      [
                        _c(
                          "label",
                          { staticClass: " tw-font-bold tw-uppercase mb-1" },
                          [_vm._v(" เดือน ")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          {},
                          [
                            !_vm.budget_year
                              ? _c(
                                  "el-select",
                                  {
                                    ref: "month",
                                    attrs: {
                                      clearable: "",
                                      size: "large",
                                      placeholder: "เดือน",
                                      disabled: ""
                                    },
                                    model: {
                                      value: _vm.month,
                                      callback: function($$v) {
                                        _vm.month = $$v
                                      },
                                      expression: "month"
                                    }
                                  },
                                  _vm._l(_vm.monthLists, function(
                                    month,
                                    index
                                  ) {
                                    return _c("el-option", {
                                      key: index,
                                      attrs: {
                                        label: month.thai_month,
                                        value: month.period_num
                                      }
                                    })
                                  }),
                                  1
                                )
                              : _c(
                                  "el-select",
                                  {
                                    ref: "month",
                                    attrs: {
                                      clearable: "",
                                      size: "large",
                                      placeholder: "เดือน",
                                      filterable: "",
                                      "popper-append-to-body": false
                                    },
                                    on: { change: _vm.getBiWeekly },
                                    model: {
                                      value: _vm.month,
                                      callback: function($$v) {
                                        _vm.month = $$v
                                      },
                                      expression: "month"
                                    }
                                  },
                                  _vm._l(_vm.monthLists, function(
                                    month,
                                    index
                                  ) {
                                    return _c("el-option", {
                                      key: index,
                                      attrs: {
                                        label: month.thai_month,
                                        value: month.period_num
                                      }
                                    })
                                  }),
                                  1
                                )
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _c("div", {
                          staticClass: "error_msg text-left",
                          attrs: { id: "el_explode_month" }
                        })
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass:
                          "form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2"
                      },
                      [
                        _c(
                          "label",
                          {
                            staticClass:
                              "text-left tw-font-bold tw-uppercase mb-1"
                          },
                          [_vm._v(" ปักษ์ที่ :")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          {},
                          [
                            _c("input", {
                              attrs: {
                                type: "hidden",
                                name: "search[bi_weekly]"
                              },
                              domProps: { value: _vm.bi_weekly }
                            }),
                            _vm._v(" "),
                            !_vm.month
                              ? _c(
                                  "el-select",
                                  {
                                    ref: "bi_weekly",
                                    attrs: {
                                      clearable: "",
                                      size: "large",
                                      placeholder: "ปักษ์",
                                      disabled: ""
                                    },
                                    model: {
                                      value: _vm.bi_weekly,
                                      callback: function($$v) {
                                        _vm.bi_weekly = $$v
                                      },
                                      expression: "bi_weekly"
                                    }
                                  },
                                  _vm._l(_vm.biWeeklyLists, function(
                                    biweekly,
                                    index
                                  ) {
                                    return _c("el-option", {
                                      key: index,
                                      attrs: {
                                        label: biweekly.biweekly,
                                        value: biweekly.biweekly
                                      }
                                    })
                                  }),
                                  1
                                )
                              : _c(
                                  "el-select",
                                  {
                                    ref: "bi_weekly",
                                    attrs: {
                                      clearable: "",
                                      size: "large",
                                      placeholder: "ปักษ์",
                                      filterable: "",
                                      "v-loading": _vm.b_loading,
                                      "popper-append-to-body": false
                                    },
                                    model: {
                                      value: _vm.bi_weekly,
                                      callback: function($$v) {
                                        _vm.bi_weekly = $$v
                                      },
                                      expression: "bi_weekly"
                                    }
                                  },
                                  _vm._l(_vm.biWeeklyLists, function(
                                    biweekly,
                                    index
                                  ) {
                                    return _c("el-option", {
                                      key: index,
                                      attrs: {
                                        label: biweekly.biweekly,
                                        value: biweekly.biweekly
                                      }
                                    })
                                  }),
                                  1
                                ),
                            _vm._v(" "),
                            _c("div", {
                              staticClass: "error_msg text-left",
                              attrs: { id: "el_explode_bi_weekly" }
                            })
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
                          "form-group text-right  pr-2 mb-0 col-lg-3 col-md-3 col-sm-12 col-xs-12"
                      },
                      [
                        _c(
                          "label",
                          { staticClass: " tw-font-bold tw-uppercase mt-2" },
                          [_vm._v(" ")]
                        ),
                        _vm._v(" "),
                        _c("div", { staticClass: "text-left" }, [
                          _c(
                            "button",
                            {
                              class:
                                _vm.btnTrans.search.class + " btn-lg tw-w-25",
                              attrs: { type: "button" },
                              on: { click: _vm.searchForm }
                            },
                            [
                              _c("i", { class: _vm.btnTrans.search.icon }),
                              _vm._v(
                                "\n                                        " +
                                  _vm._s(_vm.btnTrans.search.text) +
                                  "\n                                    "
                              )
                            ]
                          )
                        ])
                      ]
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { domProps: { innerHTML: _vm._s(_vm.html) } })
                ])
              ]),
              _vm._v(" "),
              _vm._m(1)
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
    return _c("div", { staticClass: "modal-header" }, [
      _c(
        "h3",
        {
          staticClass: "modal-title text-left",
          staticStyle: { "font-size": "22px", "font-weight": "400" }
        },
        [
          _vm._v(
            "\n                        ค้นหาแผนประมาณการผลิต\n                    "
          )
        ]
      ),
      _vm._v(" "),
      _c(
        "button",
        {
          staticClass: "close",
          attrs: { type: "button", "data-dismiss": "modal" }
        },
        [
          _c("span", { attrs: { "aria-hidden": "true" } }, [_vm._v("×")]),
          _c("span", { staticClass: "sr-only" }, [_vm._v("Close")])
        ]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "modal-footer" }, [
      _c(
        "button",
        {
          staticClass: "btn btn-white",
          attrs: { type: "button", "data-dismiss": "modal" }
        },
        [_vm._v("Close")]
      )
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/ShowComponent.vue?vue&type=template&id=3860802d&":
/*!***************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/ShowComponent.vue?vue&type=template&id=3860802d& ***!
  \***************************************************************************************************************************************************************************************************************************************************/
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
    {
      directives: [
        {
          name: "loading",
          rawName: "v-loading",
          value: _vm.loading.approveProcess
            ? _vm.loading.approveProcess
            : _vm.loading.searchProcess,
          expression:
            "loading.approveProcess? loading.approveProcess: loading.searchProcess"
        }
      ]
    },
    [
      _c("div", { staticClass: "ibox float-e-margins mb-2" }, [
        _c(
          "div",
          { staticClass: "col-12 text-right mt-1" },
          [
            _c(
              "button",
              {
                class: _vm.btnTrans.search.class + " btn-lg tw-w-25",
                attrs: { type: "button" },
                on: {
                  click: function($event) {
                    $event.preventDefault()
                    return _vm.submit()
                  }
                }
              },
              [
                _c("i", { class: _vm.btnTrans.search.icon }),
                _vm._v(
                  "\n                " +
                    _vm._s(_vm.btnTrans.search.text) +
                    "\n            "
                )
              ]
            ),
            _vm._v(" "),
            _c(
              "a",
              {
                staticClass: "btn btn-white btn-lg",
                attrs: { href: _vm.url.production_daily_reset }
              },
              [_vm._v("ล้าง")]
            ),
            _vm._v(" "),
            _vm.productDailyPlan != null
              ? [
                  _vm.canApprove && !_vm.isControlDisable
                    ? _c(
                        "button",
                        {
                          class: _vm.btnTrans.approve.class + " btn-lg tw-w-25",
                          attrs: { type: "button" },
                          on: {
                            click: function($event) {
                              $event.preventDefault()
                              return _vm.checkApprove()
                            }
                          }
                        },
                        [
                          _c("i", { class: _vm.btnTrans.approve.icon }),
                          _vm._v(
                            "\n                    " +
                              _vm._s(_vm.btnTrans.approve.text) +
                              "\n                "
                          )
                        ]
                      )
                    : _vm._e(),
                  _vm._v(" "),
                  !_vm.canApprove && !_vm.isControlDisable
                    ? _c(
                        "button",
                        {
                          class:
                            _vm.btnTrans.unapprove.class + " btn-lg tw-w-25",
                          attrs: { type: "button" },
                          on: {
                            click: function($event) {
                              $event.preventDefault()
                              return _vm.checkUnapprove()
                            }
                          }
                        },
                        [
                          _c("i", { class: _vm.btnTrans.unapprove.icon }),
                          _vm._v(
                            "\n                    " +
                              _vm._s(_vm.btnTrans.unapprove.text) +
                              "\n                "
                          )
                        ]
                      )
                    : _vm._e()
                ]
              : _vm._e()
          ],
          2
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "card border-primary mb-3 mt-3" }, [
        _c("div", { staticClass: "card-body" }, [
          _c("div", { staticClass: "row" }, [
            _c("div", { staticClass: "col-8 b-r" }, [
              _c(
                "form",
                {
                  attrs: {
                    id: "search-form",
                    action: _vm.url.ajax_production_daily_search
                  }
                },
                [
                  _c("div", { staticClass: "row" }, [
                    _c(
                      "div",
                      {
                        staticClass:
                          "form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-6 col-xs-6 mt-2"
                      },
                      [
                        _c(
                          "label",
                          {
                            staticClass:
                              "text-left tw-font-bold tw-uppercase mb-1"
                          },
                          [_vm._v(" ปีงบประมาณ ")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "input-group " },
                          [
                            _c("input", {
                              attrs: {
                                type: "hidden",
                                name: "search[budget_year]"
                              },
                              domProps: { value: _vm.budgetYear }
                            }),
                            _vm._v(" "),
                            _c(
                              "el-select",
                              {
                                ref: "budget_year",
                                attrs: {
                                  size: "medium",
                                  placeholder: "ปีงบประมาณ",
                                  clearable: "",
                                  filterable: ""
                                },
                                on: { change: _vm.getMonth },
                                model: {
                                  value: _vm.budgetYear,
                                  callback: function($$v) {
                                    _vm.budgetYear = $$v
                                  },
                                  expression: "budgetYear"
                                }
                              },
                              _vm._l(_vm.budgetYears, function(year, index) {
                                return _c("el-option", {
                                  key: index,
                                  attrs: {
                                    label: year.thai_year,
                                    value: year.thai_year
                                  }
                                })
                              }),
                              1
                            ),
                            _vm._v(" "),
                            _c("div", {
                              staticClass: "error_msg text-left",
                              attrs: { id: "el_explode_budget_year" }
                            })
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
                          "form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-6 col-xs-6 mt-2"
                      },
                      [
                        _c("input", {
                          attrs: { type: "hidden", name: "search[month]" },
                          domProps: { value: _vm.month }
                        }),
                        _vm._v(" "),
                        _c(
                          "label",
                          { staticClass: " tw-font-bold tw-uppercase mb-1" },
                          [_vm._v(" เดือน ")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          {},
                          [
                            !_vm.budgetYear
                              ? _c(
                                  "el-select",
                                  {
                                    ref: "month",
                                    attrs: {
                                      clearable: "",
                                      size: "medium",
                                      placeholder: "เดือน",
                                      disabled: ""
                                    },
                                    model: {
                                      value: _vm.month,
                                      callback: function($$v) {
                                        _vm.month = $$v
                                      },
                                      expression: "month"
                                    }
                                  },
                                  _vm._l(_vm.monthLists, function(
                                    month,
                                    index
                                  ) {
                                    return _c("el-option", {
                                      key: index,
                                      attrs: {
                                        label: month.thai_month,
                                        value: month.period_num
                                      }
                                    })
                                  }),
                                  1
                                )
                              : _c(
                                  "el-select",
                                  {
                                    ref: "month",
                                    attrs: {
                                      clearable: "",
                                      size: "medium",
                                      placeholder: "เดือน",
                                      filterable: ""
                                    },
                                    on: { change: _vm.getBiWeekly },
                                    model: {
                                      value: _vm.month,
                                      callback: function($$v) {
                                        _vm.month = $$v
                                      },
                                      expression: "month"
                                    }
                                  },
                                  _vm._l(_vm.monthLists, function(
                                    month,
                                    index
                                  ) {
                                    return _c("el-option", {
                                      key: index,
                                      attrs: {
                                        label: month.thai_month,
                                        value: month.period_num
                                      }
                                    })
                                  }),
                                  1
                                )
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _c("div", {
                          staticClass: "error_msg text-left",
                          attrs: { id: "el_explode_month" }
                        })
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass:
                          "form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-6 col-xs-6 mt-2"
                      },
                      [
                        _c(
                          "label",
                          {
                            staticClass:
                              "text-left tw-font-bold tw-uppercase mb-1"
                          },
                          [_vm._v(" ปักษ์ที่ ")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          {},
                          [
                            _c("input", {
                              attrs: {
                                type: "hidden",
                                name: "search[bi_weekly]"
                              },
                              domProps: { value: _vm.biWeekly }
                            }),
                            _vm._v(" "),
                            !_vm.month
                              ? _c(
                                  "el-select",
                                  {
                                    ref: "bi_weekly",
                                    attrs: {
                                      clearable: "",
                                      size: "medium",
                                      placeholder: "ปักษ์",
                                      disabled: ""
                                    },
                                    model: {
                                      value: _vm.biWeekly,
                                      callback: function($$v) {
                                        _vm.biWeekly = $$v
                                      },
                                      expression: "biWeekly"
                                    }
                                  },
                                  _vm._l(_vm.biWeeklyLists, function(
                                    biweekly,
                                    index
                                  ) {
                                    return _c("el-option", {
                                      key: index,
                                      attrs: {
                                        label: biweekly.biweekly,
                                        value: biweekly.biweekly
                                      }
                                    })
                                  }),
                                  1
                                )
                              : _c(
                                  "el-select",
                                  {
                                    ref: "bi_weekly",
                                    attrs: {
                                      clearable: "",
                                      size: "medium",
                                      placeholder: "ปักษ์",
                                      filterable: ""
                                    },
                                    on: {
                                      change: function($event) {
                                        return _vm.getBiWeeklyDetail()
                                      }
                                    },
                                    model: {
                                      value: _vm.biWeekly,
                                      callback: function($$v) {
                                        _vm.biWeekly = $$v
                                      },
                                      expression: "biWeekly"
                                    }
                                  },
                                  _vm._l(_vm.biWeeklyLists, function(
                                    biweekly,
                                    index
                                  ) {
                                    return _c("el-option", {
                                      key: index,
                                      attrs: {
                                        label: biweekly.biweekly,
                                        value: biweekly.biweekly
                                      }
                                    })
                                  }),
                                  1
                                ),
                            _vm._v(" "),
                            _c("div", {
                              staticClass: "error_msg text-left",
                              attrs: { id: "el_explode_bi_weekly" }
                            })
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
                          "form-group pl-2 pr-2 mb-0 col-lg-3 col-md-4 col-sm-6 col-xs-6 mt-2"
                      },
                      [
                        _c(
                          "label",
                          { staticClass: " tw-font-bold tw-uppercase mb-1" },
                          [_vm._v(" ประจำวันที่ ")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          {
                            staticClass: "p-1",
                            staticStyle: { "font-size": "14px" }
                          },
                          [
                            _vm._v(
                              "\n                                            " +
                                _vm._s(_vm.biWeeklyDetail) +
                                "\n                                        "
                            )
                          ]
                        )
                      ]
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "row" }, [
                    _c(
                      "div",
                      {
                        staticClass:
                          "form-group pl-2 pr-2 mb-0 col-lg-10 col-md-10 col-sm-6 col-xs-6 mt-2"
                      },
                      [
                        _c(
                          "label",
                          { staticClass: " tw-font-bold tw-uppercase mb-1" },
                          [_vm._v(" ประมาณกำลังการผลิต ")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          [
                            _c("input", {
                              attrs: {
                                type: "hidden",
                                name: "search[product_type]"
                              },
                              domProps: { value: _vm.productType }
                            }),
                            _vm._v(" "),
                            _c(
                              "el-radio-group",
                              {
                                attrs: { size: "small" },
                                on: {
                                  change: function($event) {
                                    return _vm.changeProductType()
                                  }
                                },
                                model: {
                                  value: _vm.productType,
                                  callback: function($$v) {
                                    _vm.productType = $$v
                                  },
                                  expression: "productType"
                                }
                              },
                              [
                                _vm._l(_vm.productTypes, function(
                                  product,
                                  index
                                ) {
                                  return [
                                    _c(
                                      "el-radio",
                                      {
                                        staticClass: "mr-1 mb-1",
                                        attrs: {
                                          label: product.lookup_code,
                                          border: ""
                                        }
                                      },
                                      [
                                        _vm._v(
                                          "\n                                                        " +
                                            _vm._s(product.meaning) +
                                            "\n                                                    "
                                        )
                                      ]
                                    )
                                  ]
                                })
                              ],
                              2
                            )
                          ],
                          1
                        )
                      ]
                    )
                  ])
                ]
              )
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-4" }, [
              _c("div", { staticClass: "row" }, [
                _c("div", { staticClass: "col-lg-12" }, [
                  _c("dl", { staticClass: "row mb-1" }, [
                    _vm._m(0),
                    _vm._v(" "),
                    _c("div", { staticClass: "col-sm-6 text-sm-left" }, [
                      _c("dd", { staticClass: "mb-1" }, [
                        _vm.dailyPlan && _vm.showFlag
                          ? _c("div", [
                              _vm._v(
                                "\n                                            " +
                                  _vm._s(_vm.dailyPlan.creation_date_format) +
                                  "\n                                        "
                              )
                            ])
                          : _vm._e()
                      ])
                    ])
                  ]),
                  _vm._v(" "),
                  _c("dl", { staticClass: "row mb-1" }, [
                    _vm._m(1),
                    _vm._v(" "),
                    _c("div", { staticClass: "col-sm-6 text-sm-left" }, [
                      _c("dd", { staticClass: "mb-1" }, [
                        _vm.dailyPlan && _vm.showFlag
                          ? _c("div", [
                              _vm._v(
                                "\n                                            " +
                                  _vm._s(
                                    _vm.dailyPlan.plan_daily_t_last
                                      ? _vm.dailyPlan.plan_daily_t_last
                                          .updated_at_format
                                      : _vm.dailyPlan.updated_at_format
                                  ) +
                                  "\n                                        "
                              )
                            ])
                          : _vm._e()
                      ])
                    ])
                  ]),
                  _vm._v(" "),
                  _c("dl", { staticClass: "row mb-1" }, [
                    _vm._m(2),
                    _vm._v(" "),
                    _c("div", { staticClass: "col-sm-6 text-sm-left" }, [
                      _c("dd", { staticClass: "mb-1" }, [
                        _vm.dailyPlan && _vm.showFlag
                          ? _c("div", [
                              _c("span", {
                                domProps: {
                                  innerHTML: _vm._s(
                                    _vm.dailyPlan.status_lable_html
                                  )
                                }
                              })
                            ])
                          : _vm._e()
                      ])
                    ])
                  ]),
                  _vm._v(" "),
                  _c("dl", { staticClass: "row mb-1" }, [
                    _vm._m(3),
                    _vm._v(" "),
                    _c("div", { staticClass: "col-sm-6 text-sm-left" }, [
                      _c("dd", { staticClass: "mb-1" }, [
                        _vm.productDailyPlan && _vm.showFlag
                          ? _c("div", [
                              _vm._v(
                                "\n                                            " +
                                  _vm._s(_vm.creator) +
                                  "\n                                        "
                              )
                            ])
                          : _vm._e()
                      ])
                    ])
                  ]),
                  _vm._v(" "),
                  _c("dl", { staticClass: "row mb-1" }, [
                    _vm._m(4),
                    _vm._v(" "),
                    _c("div", { staticClass: "col-sm-6 text-sm-left" }, [
                      _c("dd", { staticClass: "mb-1" }, [
                        _vm.dailyPlan && _vm.showFlag
                          ? _c("div", [
                              _c("span", {
                                domProps: {
                                  innerHTML: _vm._s(
                                    _vm.dailyPlan.approved_no
                                      ? _vm.dailyPlan.approved_no
                                      : "-"
                                  )
                                }
                              })
                            ])
                          : _vm._e()
                      ])
                    ])
                  ]),
                  _vm._v(" "),
                  _c("dl", { staticClass: "row mb-1" }, [
                    _vm._m(5),
                    _vm._v(" "),
                    _c("div", { staticClass: "col-sm-6 text-sm-left" }, [
                      _c("dd", { staticClass: "mb-1" }, [
                        _vm.dailyPlan && _vm.showFlag
                          ? _c("div", [
                              _vm._v(
                                "\n                                            " +
                                  _vm._s(
                                    _vm.dailyPlan.approved_at_format
                                      ? _vm.dailyPlan.approved_at_format
                                      : null
                                  ) +
                                  "\n                                        "
                              )
                            ])
                          : _vm._e()
                      ])
                    ])
                  ])
                ])
              ])
            ])
          ])
        ])
      ]),
      _vm._v(" "),
      !_vm.dailyPlan && _vm.searchFlag ? [_vm._m(6)] : _vm._e(),
      _vm._v(" "),
      _vm.showFlag && _vm.dailyPlan
        ? _c("OMSalesForecast", {
            attrs: {
              "daily-plan": _vm.dailyPlan,
              "machine-biweekly": _vm.machineBiweekly,
              biweeklyColorCode: _vm.biweeklyColorCode,
              "product-types": _vm.productTypes,
              "product-type": _vm.productType,
              versions: _vm.versions,
              defaultInput: _vm.pDefaultInput,
              btnTrans: _vm.btnTrans,
              url: _vm.urlArr,
              refreshOMSalesForecast: _vm.refreshOMSalesForecast,
              canViewProduction: _vm.canViewProduction
            },
            on: { omSalesForecast: _vm.omSalesForecastData }
          })
        : _vm._e(),
      _vm._v(" "),
      _vm.showFlag && _vm.omSalesForecasts.length > 0 && _vm.dailyPlan
        ? [
            _c("hr"),
            _vm._v(" "),
            _c("PlanDaily", {
              attrs: {
                "machine-biweekly": _vm.machineBiweekly,
                "product-daily-plan": _vm.dailyPlan,
                "modal-control-input": _vm.modalControlInput,
                "item-production-main": _vm.itemProductionMain,
                "budget-years": _vm.modalControlInput.budget_years,
                months: _vm.modalControlInput.months,
                "bi-weekly": _vm.modalControlInput.bi_weekly,
                "product-type": _vm.productType,
                "date-format": _vm.pDateFormat,
                "btn-trans": _vm.btnTrans,
                url: _vm.urlArr,
                search: _vm.search,
                "is-control-disable": _vm.isControlDisable,
                messageCheckWKHHtml: _vm.messageCheckWKHHtml,
                messageCheckMachineHtml: _vm.messageCheckMachineHtml,
                isCurrBiweekly: _vm.isCurrBiweekly
              },
              on: {
                updateControlDisable: _vm.updateControlDisable,
                fetchDataP07: _vm.fetchDataP07
              }
            }),
            _vm._v(" "),
            _c("hr"),
            _vm._v(" "),
            _vm.showFlag && _vm.dailyPlan
              ? _c("ItemPlan", {
                  attrs: {
                    "product-daily-plan": _vm.dailyPlan,
                    "item-cigars": _vm.modalControlInput.itemCigarette,
                    "item-production-main": _vm.itemProductionMain,
                    "product-type": _vm.productType,
                    "date-format": _vm.pDateFormat,
                    "btn-trans": _vm.btnTrans,
                    url: _vm.urlArr
                  }
                })
              : _vm._e()
          ]
        : _vm._e()
    ],
    2
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-sm-6 text-sm-right" }, [
      _c("dt", [_vm._v("วันที่สร้าง:")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-sm-6 text-sm-right" }, [
      _c("dt", { attrs: { title: "" } }, [_vm._v("วันที่แก้ไขล่าสุด:")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-sm-6 text-sm-right" }, [
      _c("dt", [_vm._v("สถานะ:")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-sm-6 text-sm-right" }, [
      _c("dt", [_vm._v("ผู้บันทึก:")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-sm-6 text-sm-right" }, [
      _c("dt", [_vm._v("จำนวนครั้งที่อนุมัติ:")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-sm-6 text-sm-right" }, [
      _c("dt", [_vm._v("วันที่อนุมัติล่าสุด:")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-12 text-center" }, [
      _c("h2", [_vm._v(" ไม่พบข้อมูลที่ค้นหาในระบบ ")])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/HeaderDetail.vue?vue&type=template&id=20cddfc4&":
/*!*************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/HeaderDetail.vue?vue&type=template&id=20cddfc4& ***!
  \*************************************************************************************************************************************************************************************************************************************************************/
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
  return _c("div", {}, [
    _c("form", { attrs: { id: "production-plan-form", action: "" } }, [
      _c("div", { staticClass: "row" }, [
        _c("div", { staticClass: "col-8 b-r" }, [
          _c("div", { staticClass: "row" }, [
            _c("div", { staticClass: "col-lg-6" }, [
              _c("dl", { staticClass: "row mb-1" }, [
                _vm._m(0),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-8 text-sm-left" }, [
                  _c("dd", { staticClass: "mb-1" }, [
                    _vm.machineBiweekly
                      ? _c("div", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(
                                _vm.machineBiweekly.pp_bi_weekly.thai_year
                              ) +
                              "\n                                    "
                          )
                        ])
                      : _vm._e()
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("dl", { staticClass: "row mb-1" }, [
                _vm._m(1),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-8 text-sm-left" }, [
                  _c("dd", { staticClass: "mb-1" }, [
                    _vm.machineBiweekly
                      ? _c("div", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(
                                _vm.machineBiweekly.pp_bi_weekly.biweekly
                              ) +
                              "\n                                    "
                          )
                        ])
                      : _vm._e()
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("dl", { staticClass: "row mb-1" }, [
                _vm._m(2),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-8 text-sm-left" }, [
                  _c("dd", { staticClass: "mb-1" }, [
                    _vm.productBiweeklyMain
                      ? _c("div", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(_vm.productBiweeklyMain.biweekly) +
                              "\n                                    "
                          )
                        ])
                      : _vm._e()
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("dl", { staticClass: "row mb-1" }, [
                _vm._m(3),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-8 text-sm-left" }, [
                  _c("dd", { staticClass: "mb-1 " }, [
                    _vm.machineBiweekly
                      ? _c("div", [
                          _vm.machineBiweekly.pt_bi_weekly
                            ? _c("div", [
                                _vm._v(
                                  "\n                                            " +
                                    _vm._s(
                                      _vm.machineBiweekly.pt_bi_weekly.pp_month
                                    ) +
                                    "\n                                        "
                                )
                              ])
                            : _vm._e()
                        ])
                      : _vm._e()
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("dl", { staticClass: "row mb-1" }, [
                _vm._m(4),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-8 text-sm-left" }, [
                  _c("dd", { staticClass: "mb-1" }, [
                    _vm.machineBiweekly
                      ? _c("div", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(
                                _vm.machineBiweekly.pp_bi_weekly
                                  .thai_combine_date
                              ) +
                              "\n                                    "
                          )
                        ])
                      : _vm._e()
                  ])
                ])
              ])
            ])
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col-4" }, [
          _c("div", { staticClass: "row" }, [
            _c("div", { staticClass: "col-lg-12" }, [
              _c("dl", { staticClass: "row mb-1" }, [
                _vm._m(5),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-6 text-sm-left" }, [
                  _c("dd", { staticClass: "mb-1" }, [
                    _vm.productDailyPlan
                      ? _c("div", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(
                                _vm.productDailyPlan.creation_date_format
                              ) +
                              "\n                                    "
                          )
                        ])
                      : _vm._e()
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("dl", { staticClass: "row mb-1" }, [
                _vm._m(6),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-6 text-sm-left" }, [
                  _c("dd", { staticClass: "mb-1" }, [
                    _vm.productDailyPlan
                      ? _c("div", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(
                                _vm.productDailyPlan.plan_daily_t_last
                                  ? _vm.productDailyPlan.plan_daily_t_last
                                      .updated_at_format
                                  : _vm.productDailyPlan.updated_at_format
                              ) +
                              "\n                                    "
                          )
                        ])
                      : _vm._e()
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("dl", { staticClass: "row mb-1" }, [
                _vm._m(7),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-6 text-sm-left" }, [
                  _c("dd", { staticClass: "mb-1" }, [
                    _vm.productDailyPlan
                      ? _c("div", [
                          _c("span", {
                            domProps: {
                              innerHTML: _vm._s(
                                _vm.productDailyPlan.status_lable_html
                              )
                            }
                          })
                        ])
                      : _vm._e()
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("dl", { staticClass: "row mb-1" }, [
                _vm._m(8),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-6 text-sm-left" }, [
                  _c("dd", { staticClass: "mb-1" }, [
                    _vm.productDailyPlan
                      ? _c("div", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(
                                (_vm.productDailyPlan &&
                                _vm.productDailyPlan.updated_by
                                ? _vm.productDailyPlan.updated_by.name
                                : _vm.productDailyPlan.created_by)
                                  ? _vm.productDailyPlan.created_by.name
                                  : null
                              ) +
                              "\n                                    "
                          )
                        ])
                      : _vm._e()
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("dl", { staticClass: "row mb-1" }, [
                _vm._m(9),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-6 text-sm-left" }, [
                  _c("dd", { staticClass: "mb-1" }, [
                    _vm.productDailyPlan
                      ? _c("div", [
                          _c("span", {
                            domProps: {
                              innerHTML: _vm._s(
                                _vm.productDailyPlan.approved_no
                                  ? _vm.productDailyPlan.approved_no
                                  : "-"
                              )
                            }
                          })
                        ])
                      : _vm._e()
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("dl", { staticClass: "row mb-1" }, [
                _vm._m(10),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-6 text-sm-left" }, [
                  _c("dd", { staticClass: "mb-1" }, [
                    _vm.productDailyPlan
                      ? _c("div", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(
                                _vm.productDailyPlan.approved_at_format
                                  ? _vm.productDailyPlan.approved_at_format
                                  : null
                              ) +
                              "\n                                    "
                          )
                        ])
                      : _vm._e()
                  ])
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
    return _c("div", { staticClass: "col-sm-4 pl-0 text-sm-right" }, [
      _c("dt", [_vm._v("ปีงบประมาณ:")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-sm-4 pl-0 text-sm-right" }, [
      _c("dt", [_vm._v("ปักษ์ที่:")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-sm-4 pl-0 text-sm-right" }, [
      _c("dt", [_vm._v("อ้างอิงแผนปักษ์ที่:")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-sm-4 pl-0 text-sm-right" }, [
      _c("dt", [_vm._v("ประจำเดือน:")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-sm-4 pl-0 text-sm-right" }, [
      _c("dt", [_vm._v("ประจำวันที่:")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-sm-6 text-sm-right" }, [
      _c("dt", [_vm._v("วันที่สร้าง:")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-sm-6 text-sm-right" }, [
      _c("dt", { attrs: { title: "" } }, [_vm._v("วันที่แก้ไขล่าสุด:")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-sm-6 text-sm-right" }, [
      _c("dt", [_vm._v("สถานะ:")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-sm-6 text-sm-right" }, [
      _c("dt", [_vm._v("ผู้บันทึก:")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-sm-6 text-sm-right" }, [
      _c("dt", [_vm._v("อนุมัติครั้งที่:")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-sm-6 text-sm-right" }, [
      _c("dt", [_vm._v("วันที่อนุมัติ:")])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/ItemPlan.vue?vue&type=template&id=26f83762&":
/*!*********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/ItemPlan.vue?vue&type=template&id=26f83762& ***!
  \*********************************************************************************************************************************************************************************************************************************************************/
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
  return _c("span", [
    _c("form", { attrs: { id: "onhand-form" } }, [
      _c("div", { staticClass: "row ml-3" }, [
        _c(
          "div",
          { staticStyle: { width: "300px" } },
          [
            _c("label", { staticClass: "tw-font-bold tw-uppercase mb-1" }, [
              _vm._v(" ตรวจสอบคงคลังบุหรี่ ")
            ]),
            _vm._v(" "),
            _c(
              "el-select",
              {
                ref: "item_code",
                staticStyle: { width: "100%" },
                attrs: {
                  name: "item",
                  size: "large",
                  placeholder: "รหัสบุหรี่",
                  clearable: "",
                  filterable: "",
                  "popper-append-to-body": false
                },
                on: { change: _vm.selItem },
                model: {
                  value: _vm.item_code,
                  callback: function($$v) {
                    _vm.item_code = $$v
                  },
                  expression: "item_code"
                }
              },
              _vm._l(_vm.listItemCigarettes, function(item) {
                return _c("el-option", {
                  key: item.item_code,
                  attrs: {
                    label: item.item_code + " : " + item.item_description,
                    value: item.item_code
                  }
                })
              }),
              1
            ),
            _vm._v(" "),
            _c("div", {
              staticClass: "error_msg text-left",
              attrs: { id: "el_explode_item" }
            })
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass:
              "form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-6 col-xs-6 mt-3"
          },
          [
            _vm._m(0),
            _vm._v(" "),
            _c(
              "button",
              {
                class: _vm.btnTrans.search.class + " btn-lg tw-w-25",
                attrs: { type: "button" },
                on: {
                  click: function($event) {
                    $event.preventDefault()
                    return _vm.getData($event)
                  }
                }
              },
              [
                _c("i", { class: _vm.btnTrans.search.icon }),
                _vm._v(
                  "\n                    " +
                    _vm._s(_vm.btnTrans.search.text) +
                    "\n                "
                )
              ]
            )
          ]
        )
      ]),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass:
            "form-group pl-2 pr-2 mb-0 col-lg-12 col-md-12 col-sm-6 col-xs-6 mt-2"
        },
        [
          _c("div", {
            staticClass: "table-responsive",
            domProps: { innerHTML: _vm._s(_vm.html) }
          })
        ]
      )
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [_c("br"), _vm._v("   ")])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/List.vue?vue&type=template&id=2fc4b5b8&":
/*!*****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/List.vue?vue&type=template&id=2fc4b5b8& ***!
  \*****************************************************************************************************************************************************************************************************************************************************/
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
    "tr",
    {
      directives: [
        {
          name: "loading",
          rawName: "v-loading",
          value: _vm.loading,
          expression: "loading"
        }
      ]
    },
    [
      _vm._m(0),
      _vm._v(" "),
      _c("td", { staticClass: "text-center" }, [
        _vm._v(" " + _vm._s(_vm.index + 1) + " ")
      ]),
      _vm._v(" "),
      _c(
        "td",
        { staticStyle: { "padding-bottom": "2px" }, attrs: { width: "100px" } },
        [
          _c(
            "div",
            [
              _c(
                "el-select",
                {
                  ref: "item_code",
                  staticClass: "w-100",
                  attrs: {
                    name: "item[]",
                    size: "medium",
                    placeholder: "รหัสบุหรี่",
                    clearable: "",
                    filterable: "",
                    remote: "",
                    disabled: _vm.enable,
                    "popper-append-to-body": false
                  },
                  on: { change: _vm.selItem },
                  model: {
                    value: _vm.selectedItem,
                    callback: function($$v) {
                      _vm.selectedItem = $$v
                    },
                    expression: "selectedItem"
                  }
                },
                _vm._l(_vm.orderedItem, function(item) {
                  return _c("el-option", {
                    key: item.item_code,
                    attrs: {
                      label: item.item_code + " : " + item.item_description,
                      value: item.item_code
                    }
                  })
                }),
                1
              )
            ],
            1
          ),
          _vm._v(" "),
          _c("div", {
            staticClass: "error_msg text-left",
            attrs: { id: "el_explode_item_code" + _vm.index }
          })
        ]
      ),
      _vm._v(" "),
      _c(
        "td",
        { staticClass: "text-right" },
        [
          _c("vue-numeric", {
            staticClass: "form-control input-sm text-right",
            style:
              "width: 100%; " +
              (_vm.errors.item_efficiency ? "border: 1px solid red;" : ""),
            attrs: {
              name: "item_efficiency[]",
              minus: false,
              precision: 2,
              min: 0,
              max: 999999999,
              disabled: !_vm.valid,
              autocomplete: "off"
            },
            on: {
              change: _vm.addItemEfficiency,
              blur: function($event) {
                return _vm.addItemEfficiency()
              }
            },
            model: {
              value: _vm.itemLine.item_efficiency,
              callback: function($$v) {
                _vm.$set(_vm.itemLine, "item_efficiency", $$v)
              },
              expression: "itemLine.item_efficiency"
            }
          }),
          _vm._v(" "),
          _c("span", {
            staticClass: "error_msg text-center",
            attrs: { id: "el_explode_item_efficiency" + _vm.index }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c("td", { staticStyle: { "text-align": "center" } }, [
        _c(
          "button",
          {
            staticClass: "btn btn-md btn-danger",
            attrs: { onkeydown: "return event.key != 'Enter';" },
            on: {
              click: function($event) {
                return _vm.remove(_vm.itemLine)
              }
            }
          },
          [_c("i", { staticClass: "fa fa-trash-o" })]
        )
      ])
    ]
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("td", { staticClass: "text-center" }, [
      _c(
        "button",
        { staticClass: "btn btn-light btn-sm", attrs: { type: "button" } },
        [_c("i", { staticClass: "fa fa-arrows-v my-handle fa-2x" })]
      )
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/ModalControl.vue?vue&type=template&id=dd257914&":
/*!*************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/ModalControl.vue?vue&type=template&id=dd257914& ***!
  \*************************************************************************************************************************************************************************************************************************************************************/
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
  return _c("span", [
    _vm.canEdit && !_vm.isControlDisable
      ? _c(
          "button",
          {
            class: _vm.btnTrans.edit.class + " btn-lg tw-w-25 mt-3",
            attrs: { type: "button" },
            on: { click: _vm.openModal }
          },
          [
            _c("i", { class: _vm.btnTrans.edit.icon }),
            _vm._v(" "),
            _vm._v(" สร้างและแก้ไขแผน\n    ")
          ]
        )
      : _vm._e(),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass: "modal fade",
        attrs: {
          id: "modal_control",
          tabindex: "-1",
          role: "dialog",
          "aria-hidden": "true",
          "data-backdrop": "static",
          "data-keyboard": "false"
        }
      },
      [
        _c("div", { staticClass: "modal-dialog modal-lg" }, [
          _c(
            "div",
            {
              directives: [
                {
                  name: "loading",
                  rawName: "v-loading",
                  value: _vm.loading,
                  expression: "loading"
                }
              ],
              staticClass: "modal-content"
            },
            [
              _c("div", { staticClass: "modal-header" }, [
                _c(
                  "h3",
                  {
                    staticClass: "modal-title text-left",
                    staticStyle: { "font-size": "22px", "font-weight": "400" }
                  },
                  [
                    _vm._v(
                      "\n                        แผนการผลิตรายวัน\n                    "
                    )
                  ]
                ),
                _vm._v(" "),
                _c(
                  "button",
                  {
                    staticClass: "close",
                    attrs: { type: "button", "data-dismiss": "modal" },
                    on: {
                      click: function($event) {
                        $event.preventDefault()
                        return _vm.cancel()
                      }
                    }
                  },
                  [
                    _c("span", { attrs: { "aria-hidden": "true" } }, [
                      _vm._v("×")
                    ]),
                    _c("span", { staticClass: "sr-only" }, [_vm._v("Close")])
                  ]
                )
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "modal-body text-left" }, [
                _c("form", { attrs: { id: "production-plan-control-form" } }, [
                  _c("div", { staticClass: "row col-12 m-0" }, [
                    _c(
                      "div",
                      {
                        staticClass:
                          "form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-6 col-xs-6 mt-2"
                      },
                      [
                        _c(
                          "label",
                          { staticClass: "tw-font-bold tw-uppercase mb-1" },
                          [_vm._v(" วันที่ :")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "input-group" },
                          [
                            _c("datepicker-th", {
                              staticClass: "form-control md:tw-mb-0 tw-mb-2",
                              staticStyle: { width: "100%" },
                              attrs: {
                                name: "start_date",
                                id: "start_date",
                                placeholder: "โปรดเลือกวันที่",
                                value: _vm.input_date_from,
                                format: "DD-MMM-YYYY",
                                disabled: _vm.isDisableSelDate
                              },
                              on: { dateWasSelected: _vm.dateWasSelectedFrom },
                              model: {
                                value: _vm.input_date_from,
                                callback: function($$v) {
                                  _vm.input_date_from = $$v
                                },
                                expression: "input_date_from"
                              }
                            })
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _c("div", {
                          staticClass: "error_msg text-left",
                          attrs: { id: "el_explode_start_date" }
                        })
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass:
                          "form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-6 col-xs-6 mt-2"
                      },
                      [
                        _c(
                          "label",
                          { staticClass: "tw-font-bold tw-uppercase mb-1" },
                          [_vm._v(" ถึง :")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "input-group" },
                          [
                            _c("datepicker-th", {
                              staticClass: "form-control md:tw-mb-0 tw-mb-2",
                              staticStyle: { width: "100%" },
                              attrs: {
                                name: "end_date",
                                id: "end_date",
                                placeholder: "โปรดเลือกวันที่",
                                value: _vm.input_date_to,
                                format: "DD-MMM-YYYY",
                                disabled: _vm.isDisableSelDate,
                                "disabled-date-to": _vm.input_date_from
                              },
                              on: { dateWasSelected: _vm.dateWasSelectedTo },
                              model: {
                                value: _vm.input_date_to,
                                callback: function($$v) {
                                  _vm.input_date_to = $$v
                                },
                                expression: "input_date_to"
                              }
                            })
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _c("div", {
                          staticClass: "error_msg text-left",
                          attrs: { id: "el_explode_end_date" }
                        })
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass:
                          "form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-6 col-xs-6 mt-2"
                      },
                      [
                        _c(
                          "label",
                          { staticClass: "tw-font-bold tw-uppercase mb-1" },
                          [_vm._v(" ขอบเขตเครื่องจักร :")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "input-group" },
                          [
                            _c(
                              "el-select",
                              {
                                ref: "machine_group",
                                staticStyle: { width: "100%" },
                                attrs: {
                                  size: "large",
                                  placeholder: "ขอบเขตเครื่องจักร",
                                  clearable: "",
                                  filterable: "",
                                  "popper-append-to-body": false
                                },
                                on: { change: _vm.selMachine },
                                model: {
                                  value: _vm.machine_group,
                                  callback: function($$v) {
                                    _vm.machine_group = $$v
                                  },
                                  expression: "machine_group"
                                }
                              },
                              _vm._l(_vm.machineLists, function(
                                machine,
                                index
                              ) {
                                return _c("el-option", {
                                  key: index,
                                  attrs: {
                                    label: machine.machine_group_description,
                                    value: machine.machine_group
                                  }
                                })
                              }),
                              1
                            ),
                            _vm._v(" "),
                            _c("div", {
                              staticClass: "error_msg text-left",
                              attrs: { id: "el_explode_machine_group" }
                            })
                          ],
                          1
                        )
                      ]
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "row col-12 m-0 mt-1 text-left" }, [
                    _c(
                      "div",
                      {
                        staticClass:
                          "form-group pl-2 pr-2 mb-0 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2"
                      },
                      [
                        _c(
                          "label",
                          { staticClass: "tw-font-bold tw-uppercase mb-1" },
                          [_vm._v(" รายละเอียดเครื่องจักร :")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "input-group" },
                          [
                            _vm._l(_vm.machineDescLists, function(machine) {
                              return [
                                _c(
                                  "span",
                                  {
                                    staticClass: "label p-2 mr-2",
                                    staticStyle: {
                                      "background-color": "#f2f3f3"
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n                                            " +
                                        _vm._s(machine.machine_description) +
                                        "\n                                        "
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
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "row m-0 mt-2 text-right" }, [
                    _c(
                      "div",
                      {
                        staticClass:
                          "form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-6 col-xs-6 mt-2"
                      },
                      [
                        _c(
                          "label",
                          { staticClass: "tw-font-bold tw-uppercase mb-2" },
                          [_vm._v(" กำลังผลิตสูงสุด (ล้านมวน) :")]
                        ),
                        _vm._v(" "),
                        _c("div", { staticClass: "text-center" }, [
                          _vm.eff_loading
                            ? _c("span", {
                                domProps: { innerHTML: _vm._s(_vm.html) }
                              })
                            : _c("span", [
                                _c(
                                  "strong",
                                  { staticStyle: { "font-size": "20px" } },
                                  [
                                    _vm._v(
                                      " " +
                                        _vm._s(
                                          _vm._f("number2Digit")(
                                            _vm.efficiencyProductHeader
                                          )
                                        ) +
                                        " "
                                    )
                                  ]
                                )
                              ])
                        ])
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass:
                          "form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-6 col-xs-6 mt-2"
                      },
                      [
                        _c(
                          "label",
                          { staticClass: "tw-font-bold tw-uppercase mb-2" },
                          [_vm._v(" เหลือกำลังผลิต (ล้านมวน) :")]
                        ),
                        _vm._v(" "),
                        _c("div", { staticClass: "text-center" }, [
                          _vm.eff_loading
                            ? _c("span", {
                                domProps: { innerHTML: _vm._s(_vm.html) }
                              })
                            : _c("span", [
                                _c(
                                  "strong",
                                  { staticStyle: { "font-size": "20px" } },
                                  [
                                    _vm._v(
                                      "\n                                            " +
                                        _vm._s(
                                          _vm._f("number2Digit")(
                                            _vm.balanceEfficient
                                          )
                                        ) +
                                        "\n                                        "
                                    )
                                  ]
                                )
                              ])
                        ])
                      ]
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "hr-line-dashed" }),
                  _vm._v(" "),
                  _c(
                    "table",
                    { staticClass: "table table-responsive-sm" },
                    [
                      _vm._m(0),
                      _vm._v(" "),
                      _c(
                        "draggable",
                        {
                          attrs: {
                            list: _vm.itemLines,
                            options: { animation: 200, handle: ".my-handle" },
                            element: "tbody"
                          }
                        },
                        _vm._l(_vm.itemLines, function(row, index) {
                          return _c("ListItem", {
                            key: row.id,
                            attrs: {
                              attribute: row,
                              index: index,
                              "list-item-cigarettes": _vm.listItemCigarettes,
                              listItemLines: _vm.itemLines
                            },
                            on: { removeRow: _vm.removeLine }
                          })
                        }),
                        1
                      ),
                      _vm._v(" "),
                      _vm.itemLines.length > 0
                        ? _c("tr", [
                            _vm._m(1),
                            _vm._v(" "),
                            _c(
                              "th",
                              {
                                staticClass: "text-right",
                                staticStyle: {
                                  "font-size": "15px",
                                  color: "#676a6c"
                                }
                              },
                              [
                                _c("span", [
                                  _vm._v(
                                    " " +
                                      _vm._s(
                                        _vm._f("number2Digit")(
                                          _vm.totalApplyEfficient
                                        )
                                      ) +
                                      " "
                                  )
                                ])
                              ]
                            ),
                            _vm._v(" "),
                            _c("th")
                          ])
                        : _vm._e()
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "button",
                    {
                      staticClass: "btn btn-sm btn-block btn-primary",
                      attrs: { type: "button" },
                      on: { click: _vm.addItemLine }
                    },
                    [
                      _c("i", { staticClass: "fa fa-plus-square" }),
                      _vm._v("  เพิ่มรายการ\n                    ")
                    ]
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "modal-footer" }, [
                _c(
                  "button",
                  {
                    class: _vm.btnTrans.create.class + " btn-lg tw-w-25",
                    attrs: { type: "button" },
                    on: {
                      click: function($event) {
                        $event.preventDefault()
                        return _vm.submit()
                      }
                    }
                  },
                  [
                    _vm._v(
                      "\n                        ตกลง\n                    "
                    )
                  ]
                ),
                _vm._v(" "),
                _c(
                  "button",
                  {
                    staticClass: "btn btn-white btn-lg tw-w-25'",
                    attrs: { type: "button", "data-dismiss": "modal" },
                    on: {
                      click: function($event) {
                        $event.preventDefault()
                        return _vm.cancel()
                      }
                    }
                  },
                  [_vm._v(" ยกเลิก ")]
                )
              ])
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
    return _c("thead", [
      _c("tr", [
        _c("th", { staticClass: "text-center", attrs: { width: "5%" } }),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "5%" } }, [
          _vm._v(" ลำดับ ")
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "30%" } }, [
          _vm._v(" รหัสบุหรี่ ")
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "15%" } }, [
          _vm._v(" ปริมาณที่สั่งผลิต (ล้านมวน) ")
        ]),
        _vm._v(" "),
        _c("th", { attrs: { width: "5%" } })
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "th",
      {
        staticClass: "text-right",
        staticStyle: { "font-size": "15px", color: "#676a6c" },
        attrs: { colspan: "3" }
      },
      [_c("span", [_vm._v(" รวมปริมาณสั่งผลิต ")])]
    )
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/OMSalesForecast.vue?vue&type=template&id=4f151673&":
/*!****************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/OMSalesForecast.vue?vue&type=template&id=4f151673& ***!
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
  return _c("div", [
    _vm.loading.omSalesForecastProcess
      ? _c("div", { staticClass: "m-t-lg m-b-lg" }, [_vm._m(0)])
      : _c("div", [
          _c("h2", [_vm._v(" แผนการผลิต : " + _vm._s(_vm.productName) + " ")]),
          _vm._v(" "),
          _c(
            "form",
            { attrs: { id: "om-sales-form" } },
            [
              _vm.omSalesForecasts.length
                ? [
                    _c(
                      "div",
                      {
                        staticClass: "row col-12",
                        staticStyle: { "font-size": "15px" }
                      },
                      [
                        _c(
                          "div",
                          {
                            staticClass:
                              "form-group pl-2 pr-2 mb-0 col-lg-1 col-md-4 col-sm-6 col-xs-6 mt-2"
                          },
                          [
                            _c(
                              "label",
                              {
                                staticClass: " tw-font-bold tw-uppercase mb-1"
                              },
                              [_vm._v(" ปักษ์ : ")]
                            ),
                            _vm._v(" "),
                            _c("span", [
                              _vm._v(
                                " " +
                                  _vm._s(_vm.omSalesForecasts[0].biweekly_no) +
                                  " "
                              )
                            ])
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          {
                            staticClass:
                              "form-group pl-2 pr-2 mb-0 col-lg-2 col-md-4 col-sm-6 col-xs-6 mt-2"
                          },
                          [
                            _c(
                              "label",
                              {
                                staticClass: " tw-font-bold tw-uppercase mb-1"
                              },
                              [_vm._v(" ครั้งที่ : ")]
                            ),
                            _vm._v(" "),
                            _c(
                              "span",
                              [
                                _c(
                                  "el-select",
                                  {
                                    staticStyle: { width: "70%" },
                                    attrs: {
                                      placeholder: "ครั้งที่",
                                      size: "small"
                                    },
                                    on: { change: _vm.changeVersion },
                                    model: {
                                      value: _vm.version_no,
                                      callback: function($$v) {
                                        _vm.version_no = $$v
                                      },
                                      expression: "version_no"
                                    }
                                  },
                                  _vm._l(_vm.versions, function(value, index) {
                                    return _c("el-option", {
                                      key: index,
                                      attrs: {
                                        label: value.version,
                                        value: value.version
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
                              "form-group pl-2 pr-2 mb-0 col-lg-2 col-md-4 col-sm-6 col-xs-6 mt-2"
                          },
                          [
                            _c(
                              "label",
                              {
                                staticClass: " tw-font-bold tw-uppercase mb-1"
                              },
                              [_vm._v(" จำนวนวันขาย : ")]
                            ),
                            _vm._v(" "),
                            _c("span", [
                              _vm._v(
                                "\n                            " +
                                  _vm._s(
                                    _vm.omSalesForecasts[0].om_bi_weekly
                                      .day_for_sale
                                      ? _vm.omSalesForecasts[0].om_bi_weekly
                                          .day_for_sale
                                      : 0
                                  ) +
                                  " วัน\n                        "
                              )
                            ])
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          {
                            staticClass:
                              "form-group pl-2 pr-2 mb-0 col-lg-2 col-md-4 col-sm-6 col-xs-6 mt-2"
                          },
                          [
                            _c(
                              "label",
                              {
                                staticClass: " tw-font-bold tw-uppercase mb-1"
                              },
                              [_vm._v(" วันที่อนุมัติ : ")]
                            ),
                            _vm._v(" "),
                            _c("span", [
                              _vm._v(
                                "\n                            " +
                                  _vm._s(
                                    _vm.omSalesForecasts[0].om_sales_forecast
                                      .approve_date_format
                                      ? _vm.omSalesForecasts[0]
                                          .om_sales_forecast.approve_date_format
                                      : ""
                                  ) +
                                  "\n                        "
                              )
                            ])
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          {
                            staticClass:
                              "form-group pl-2 pr-2 mb-0 col-lg-4 col-md-4 col-sm-6 col-xs-6 mt-2"
                          },
                          [
                            _c(
                              "label",
                              {
                                staticClass: " tw-font-bold tw-uppercase mb-1"
                              },
                              [_vm._v(" กำลังผลิตรวมทั้งปักษ์ : ")]
                            ),
                            _vm._v(" "),
                            _c("span", [
                              _vm._v(
                                "\n                            " +
                                  _vm._s(
                                    _vm._f("number2Digit")(
                                      _vm.totalEfficiencyP03[0]
                                        .efficiency_product_per_min
                                    )
                                  ) +
                                  " " +
                                  _vm._s(_vm.unit) +
                                  "\n                        "
                              )
                            ])
                          ]
                        )
                      ]
                    )
                  ]
                : _vm._e(),
              _vm._v(" "),
              _c("div", { staticClass: "hr-line-dashed" }),
              _vm._v(" "),
              _c(
                "div",
                {
                  staticClass: "row col-12 mb-2",
                  staticStyle: { "font-size": "12px", color: "#000" }
                },
                [
                  _c("div", { staticClass: "col-md-6 pl-2" }),
                  _vm._v(" "),
                  _vm.type_module == "planning"
                    ? [
                        _vm._m(1),
                        _vm._v(" "),
                        _vm._m(2),
                        _vm._v(" "),
                        _vm._m(3)
                      ]
                    : [
                        _vm._m(4),
                        _vm._v(" "),
                        _vm._m(5),
                        _vm._v(" "),
                        _vm._m(6)
                      ]
                ],
                2
              ),
              _vm._v(" "),
              _c("div", { staticClass: "table-responsive" }, [
                _c("table", { staticClass: "table table-bordered" }, [
                  _c("thead", [
                    _c(
                      "tr",
                      [
                        _vm._m(7),
                        _vm._v(" "),
                        _vm._m(8),
                        _vm._v(" "),
                        _vm._m(9),
                        _vm._v(" "),
                        _vm._m(10),
                        _vm._v(" "),
                        _c(
                          "th",
                          {
                            staticClass: "text-center",
                            staticStyle: {
                              "vertical-align": "middle",
                              width: "8%"
                            }
                          },
                          [
                            _c("div", [
                              _vm._v(" ประมาณการ"),
                              _c("br"),
                              _vm._v("แผนขาย"),
                              _c("br"),
                              _vm._v("(" + _vm._s(_vm.unit) + ") ")
                            ])
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "th",
                          {
                            staticClass: "text-center",
                            staticStyle: {
                              "vertical-align": "middle",
                              width: "8%"
                            }
                          },
                          [
                            _c("div", [
                              _vm._v(" สั่งผลิตในปักษ์"),
                              _c("br"),
                              _vm._v("(" + _vm._s(_vm.unit) + ") ")
                            ])
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "th",
                          {
                            staticClass: "text-center",
                            staticStyle: {
                              "vertical-align": "middle",
                              width: "9%"
                            }
                          },
                          [
                            _c("div", [
                              _vm._v(" เหลือประมาณการ"),
                              _c("br"),
                              _vm._v("แผนขาย"),
                              _c("br"),
                              _vm._v("(" + _vm._s(_vm.unit) + ") ")
                            ])
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "th",
                          {
                            staticClass: "text-center",
                            staticStyle: {
                              "vertical-align": "middle",
                              width: "8%"
                            }
                          },
                          [
                            _c("div", [
                              _vm._v(" คงคลัง"),
                              _c("br"),
                              _vm._v("ณ วันที่สร้าง"),
                              _c("br"),
                              _vm._v("(" + _vm._s(_vm.unit) + ") ")
                            ])
                          ]
                        ),
                        _vm._v(" "),
                        _vm.type_module == "planning"
                          ? [
                              _c(
                                "th",
                                {
                                  staticClass: "text-center",
                                  staticStyle: {
                                    "vertical-align": "middle",
                                    width: "8%"
                                  }
                                },
                                [
                                  _c("div", [
                                    _vm._v(" ค่าเฉลี่ยขาย"),
                                    _c("br"),
                                    _vm._v("10 วัน"),
                                    _c("br"),
                                    _vm._v("(" + _vm._s(_vm.unit) + ") ")
                                  ])
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "th",
                                {
                                  staticClass: "text-center",
                                  staticStyle: {
                                    "vertical-align": "middle",
                                    width: "8%"
                                  }
                                },
                                [
                                  _c("div", [
                                    _vm._v(" จำนวนวันพอใช้"),
                                    _c("br"),
                                    _vm._v("(" + _vm._s(_vm.unit) + ") ")
                                  ])
                                ]
                              )
                            ]
                          : _vm._e(),
                        _vm._v(" "),
                        _vm.canViewProduction && _vm.type_module == "production"
                          ? [
                              _c(
                                "th",
                                {
                                  staticClass: "text-center",
                                  staticStyle: {
                                    "vertical-align": "middle",
                                    width: "7%",
                                    border: "2px solid #000"
                                  }
                                },
                                [
                                  _c("div", [
                                    _vm._v(" สั่งผลิต"),
                                    _c("br"),
                                    _vm._v("ย้อนหลัง 1 ปักษ์"),
                                    _c("br"),
                                    _vm._v("(" + _vm._s(_vm.unit) + ") ")
                                  ])
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "th",
                                {
                                  staticClass: "text-center",
                                  staticStyle: {
                                    "vertical-align": "middle",
                                    width: "7%",
                                    border: "2px solid #000"
                                  }
                                },
                                [
                                  _c("div", [
                                    _vm._v(" ผลผลิต"),
                                    _c("br"),
                                    _vm._v("ย้อนหลัง 1 ปักษ์"),
                                    _c("br"),
                                    _vm._v("(" + _vm._s(_vm.unit) + ") ")
                                  ])
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "th",
                                {
                                  staticClass: "text-center",
                                  staticStyle: {
                                    "vertical-align": "middle",
                                    width: "7%",
                                    border: "2px solid #000"
                                  }
                                },
                                [
                                  _c("div", [
                                    _vm._v(" ผลผลิต"),
                                    _c("br"),
                                    _vm._v("Back Order"),
                                    _c("br"),
                                    _vm._v("(" + _vm._s(_vm.unit) + ") ")
                                  ])
                                ]
                              )
                            ]
                          : _vm._e()
                      ],
                      2
                    )
                  ]),
                  _vm._v(" "),
                  _c(
                    "tbody",
                    [
                      _vm._l(_vm.omSalesForecasts, function(
                        saleForecast,
                        index
                      ) {
                        return [
                          _vm.omSalesForecasts.length &&
                          _vm.type_module == "planning"
                            ? [
                                _c(
                                  "tr",
                                  {
                                    style:
                                      _vm.alertSaleForcasts[
                                        saleForecast.item_code
                                      ] > 0 &&
                                      !_vm.totalQuantity[saleForecast.item_code]
                                        ? "font-weight: bold; background-color: #ff8800; color: #FFF;"
                                        : _vm.alertSaleForcasts[
                                            saleForecast.item_code
                                          ] > 0
                                        ? "font-weight: bold; background-color: #67d0d4; color: #FFF;"
                                        : ""
                                  },
                                  [
                                    _c("td", { staticClass: "text-center" }, [
                                      _c("div", [
                                        _vm._v(" " + _vm._s(index + 1) + " ")
                                      ])
                                    ]),
                                    _vm._v(" "),
                                    _c("td", { staticClass: "text-left" }, [
                                      _c("div", [
                                        _vm._v(
                                          " " +
                                            _vm._s(saleForecast.item_code) +
                                            " "
                                        )
                                      ])
                                    ]),
                                    _vm._v(" "),
                                    _c("td", { staticClass: "text-left" }, [
                                      _c("div", [
                                        _vm._v(
                                          " " +
                                            _vm._s(
                                              saleForecast.item_description
                                            ) +
                                            " "
                                        )
                                      ])
                                    ]),
                                    _vm._v(" "),
                                    _c("td", { staticClass: "text-right" }, [
                                      _c("div", [
                                        _vm._v(
                                          " " +
                                            _vm._s(
                                              _vm._f("number3Digit")(
                                                saleForecast.forecast_qty
                                              )
                                            ) +
                                            " "
                                        )
                                      ])
                                    ]),
                                    _vm._v(" "),
                                    _c("td", { staticClass: "text-right" }, [
                                      _c("div", [
                                        _vm._v(
                                          " " +
                                            _vm._s(
                                              _vm._f("number3Digit")(
                                                saleForecast.forecast_million_qty
                                              )
                                            ) +
                                            " "
                                        )
                                      ])
                                    ]),
                                    _vm._v(" "),
                                    _c("td", { staticClass: "text-right" }, [
                                      _c("div", [
                                        _vm._v(
                                          " " +
                                            _vm._s(
                                              _vm._f("number2Digit")(
                                                _vm.totalQuantity[
                                                  saleForecast.item_code
                                                ]
                                                  ? _vm.totalQuantity[
                                                      saleForecast.item_code
                                                    ][0]
                                                  : 0
                                              )
                                            ) +
                                            " "
                                        )
                                      ])
                                    ]),
                                    _vm._v(" "),
                                    _c("td", { staticClass: "text-right" }, [
                                      _c("div", [
                                        _vm._v(
                                          " " +
                                            _vm._s(
                                              _vm._f("number2Digit")(
                                                _vm.totalQuantity[
                                                  saleForecast.item_code
                                                ]
                                                  ? saleForecast.forecast_million_qty -
                                                      _vm.totalQuantity[
                                                        saleForecast.item_code
                                                      ][0]
                                                  : saleForecast.forecast_million_qty -
                                                      0
                                              )
                                            ) +
                                            " "
                                        )
                                      ])
                                    ]),
                                    _vm._v(" "),
                                    _c("td", { staticClass: "text-right" }, [
                                      _c("div", [
                                        _vm._v(
                                          " " +
                                            _vm._s(
                                              _vm._f("number2Digit")(
                                                _vm.currOnhand[
                                                  saleForecast.item_code
                                                ]
                                                  ? _vm.currOnhand[
                                                      saleForecast.item_code
                                                    ]
                                                  : 0
                                              )
                                            ) +
                                            " "
                                        )
                                      ])
                                    ]),
                                    _vm._v(" "),
                                    _c("td", { staticClass: "text-right" }, [
                                      _c("div", [
                                        _vm._v(
                                          " " +
                                            _vm._s(
                                              _vm._f("number2Digit")(
                                                _vm.omSales[
                                                  saleForecast.item_code
                                                ]
                                                  ? _vm.omSales[
                                                      saleForecast.item_code
                                                    ]
                                                  : 0
                                              )
                                            ) +
                                            " "
                                        )
                                      ])
                                    ]),
                                    _vm._v(" "),
                                    _c("td", { staticClass: "text-right" }, [
                                      _c("div", [
                                        _vm._v(
                                          " " +
                                            _vm._s(
                                              _vm._f("number2Digit")(
                                                _vm.omSales[
                                                  saleForecast.item_code
                                                ] != 0
                                                  ? _vm.currOnhand[
                                                      saleForecast.item_code
                                                    ] /
                                                      _vm.omSales[
                                                        saleForecast.item_code
                                                      ]
                                                  : 0
                                              )
                                            ) +
                                            " "
                                        )
                                      ])
                                    ])
                                  ]
                                )
                              ]
                            : [
                                _c(
                                  "tr",
                                  {
                                    style:
                                      _vm.canViewProduction &&
                                      Number(
                                        _vm.pmProducts[saleForecast.item_code]
                                      ) > 0 &&
                                      _vm.prevTotalQuantity[
                                        saleForecast.item_code
                                      ] &&
                                      _vm.pmProducts[saleForecast.item_code] -
                                        _vm.prevTotalQuantity[
                                          saleForecast.item_code
                                        ] <
                                        0
                                        ? "font-weight: bold; background-color: #ffcf00; color: #FFF;"
                                        : _vm.canViewProduction &&
                                          Number(
                                            _vm.pmProducts[
                                              saleForecast.item_code
                                            ]
                                          ) <= 0 &&
                                          _vm.prevTotalQuantity[
                                            saleForecast.item_code
                                          ]
                                        ? "font-weight: bold; background-color: #e20000; color: #FFF;"
                                        : ""
                                  },
                                  [
                                    _c("td", { staticClass: "text-center" }, [
                                      _c("div", [
                                        _vm._v(" " + _vm._s(index + 1) + " ")
                                      ])
                                    ]),
                                    _vm._v(" "),
                                    _c("td", { staticClass: "text-left" }, [
                                      _c("div", [
                                        _vm._v(
                                          " " +
                                            _vm._s(saleForecast.item_code) +
                                            " "
                                        )
                                      ])
                                    ]),
                                    _vm._v(" "),
                                    _c("td", { staticClass: "text-left" }, [
                                      _c("div", [
                                        _vm._v(
                                          " " +
                                            _vm._s(
                                              saleForecast.item_description
                                            ) +
                                            " "
                                        )
                                      ])
                                    ]),
                                    _vm._v(" "),
                                    _c("td", { staticClass: "text-right" }, [
                                      _c("div", [
                                        _vm._v(
                                          " " +
                                            _vm._s(
                                              _vm._f("number3Digit")(
                                                saleForecast.forecast_qty
                                              )
                                            ) +
                                            " "
                                        )
                                      ])
                                    ]),
                                    _vm._v(" "),
                                    _c("td", { staticClass: "text-right" }, [
                                      _c("div", [
                                        _vm._v(
                                          " " +
                                            _vm._s(
                                              _vm._f("number3Digit")(
                                                saleForecast.forecast_million_qty
                                              )
                                            ) +
                                            " "
                                        )
                                      ])
                                    ]),
                                    _vm._v(" "),
                                    _c("td", { staticClass: "text-right" }, [
                                      _c("div", [
                                        _vm._v(
                                          " " +
                                            _vm._s(
                                              _vm._f("number2Digit")(
                                                _vm.totalQuantity[
                                                  saleForecast.item_code
                                                ]
                                                  ? _vm.totalQuantity[
                                                      saleForecast.item_code
                                                    ][0]
                                                  : 0
                                              )
                                            ) +
                                            " "
                                        )
                                      ])
                                    ]),
                                    _vm._v(" "),
                                    _c("td", { staticClass: "text-right" }, [
                                      _c("div", [
                                        _vm._v(
                                          " " +
                                            _vm._s(
                                              _vm._f("number2Digit")(
                                                _vm.totalQuantity[
                                                  saleForecast.item_code
                                                ]
                                                  ? saleForecast.forecast_million_qty -
                                                      _vm.totalQuantity[
                                                        saleForecast.item_code
                                                      ][0]
                                                  : saleForecast.forecast_million_qty -
                                                      0
                                              )
                                            ) +
                                            " "
                                        )
                                      ])
                                    ]),
                                    _vm._v(" "),
                                    _c("td", { staticClass: "text-right" }, [
                                      _c("div", [
                                        _vm._v(
                                          " " +
                                            _vm._s(
                                              _vm._f("number2Digit")(
                                                _vm.currOnhand[
                                                  saleForecast.item_code
                                                ]
                                                  ? _vm.currOnhand[
                                                      saleForecast.item_code
                                                    ]
                                                  : 0
                                              )
                                            ) +
                                            " "
                                        )
                                      ])
                                    ]),
                                    _vm._v(" "),
                                    _vm.canViewProduction
                                      ? [
                                          _c(
                                            "td",
                                            {
                                              staticClass: "text-right",
                                              staticStyle: {
                                                border: "2px solid #000"
                                              }
                                            },
                                            [
                                              _c("div", [
                                                _vm._v(
                                                  " " +
                                                    _vm._s(
                                                      _vm._f("number2Digit")(
                                                        _vm.prevTotalQuantity[
                                                          saleForecast.item_code
                                                        ]
                                                          ? _vm
                                                              .prevTotalQuantity[
                                                              saleForecast
                                                                .item_code
                                                            ]
                                                          : 0
                                                      )
                                                    ) +
                                                    " "
                                                )
                                              ])
                                            ]
                                          ),
                                          _vm._v(" "),
                                          _c(
                                            "td",
                                            {
                                              staticClass: "text-right",
                                              staticStyle: {
                                                border: "2px solid #000"
                                              }
                                            },
                                            [
                                              _c("div", [
                                                _vm._v(
                                                  " " +
                                                    _vm._s(
                                                      _vm._f("number2Digit")(
                                                        _vm.pmProducts[
                                                          saleForecast.item_code
                                                        ]
                                                          ? _vm.pmProducts[
                                                              saleForecast
                                                                .item_code
                                                            ]
                                                          : 0
                                                      )
                                                    ) +
                                                    " "
                                                )
                                              ])
                                            ]
                                          ),
                                          _vm._v(" "),
                                          _c(
                                            "td",
                                            {
                                              staticClass: "text-right",
                                              staticStyle: {
                                                border: "2px solid #000"
                                              }
                                            },
                                            [
                                              _c("div", [
                                                _vm._v(
                                                  " " +
                                                    _vm._s(
                                                      _vm._f("number2Digit")(
                                                        Number(
                                                          _vm.pmProducts[
                                                            saleForecast
                                                              .item_code
                                                          ]
                                                        ) -
                                                          _vm.prevTotalQuantity[
                                                            saleForecast
                                                              .item_code
                                                          ]
                                                      )
                                                    ) +
                                                    " "
                                                )
                                              ])
                                            ]
                                          )
                                        ]
                                      : _vm._e()
                                  ],
                                  2
                                )
                              ]
                        ]
                      }),
                      _vm._v(" "),
                      _c(
                        "tr",
                        [
                          _c(
                            "th",
                            {
                              staticClass: "text-right",
                              attrs: { colspan: "3" }
                            },
                            [_vm._v("รวมประมาณการจำหน่าย")]
                          ),
                          _vm._v(" "),
                          _c(
                            "th",
                            {
                              staticClass: "text-right text-white",
                              staticStyle: { "background-color": "#34d399" }
                            },
                            [
                              _vm._v(
                                "\n                                " +
                                  _vm._s(
                                    _vm._f("number3Digit")(_vm.forecast_qty)
                                  ) +
                                  "\n                            "
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "th",
                            {
                              staticClass: "text-right text-white",
                              staticStyle: { "background-color": "#34d399" }
                            },
                            [
                              _vm._v(
                                "\n                                " +
                                  _vm._s(
                                    _vm._f("number3Digit")(
                                      _vm.forecast_million_qty
                                    )
                                  ) +
                                  "\n                            "
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "th",
                            {
                              staticClass: "text-right text-white",
                              staticStyle: { "background-color": "#34d399" }
                            },
                            [
                              _vm._v(
                                "\n                                " +
                                  _vm._s(
                                    _vm._f("number2Digit")(_vm.daily_qty)
                                  ) +
                                  "\n                            "
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "th",
                            {
                              staticClass: "text-right text-white",
                              staticStyle: { "background-color": "#34d399" }
                            },
                            [
                              _vm._v(
                                "\n                                " +
                                  _vm._s(
                                    _vm._f("number2Digit")(
                                      _vm.balance_sale_forecast
                                    )
                                  ) +
                                  "\n                            "
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "th",
                            {
                              staticClass: "text-right text-white",
                              staticStyle: { "background-color": "#34d399" }
                            },
                            [
                              _vm._v(
                                "\n                                " +
                                  _vm._s(
                                    _vm._f("number2Digit")(_vm.curr_onhnad_qty)
                                  ) +
                                  "\n                            "
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _vm.type_module == "planning"
                            ? [
                                _c(
                                  "th",
                                  {
                                    staticClass: "text-right text-white",
                                    staticStyle: {
                                      "background-color": "#34d399"
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n                                    " +
                                        _vm._s(
                                          _vm._f("number2Digit")(
                                            _vm.om_sale_qty
                                          )
                                        ) +
                                        "\n                                "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "th",
                                  {
                                    staticClass: "text-right text-white",
                                    staticStyle: {
                                      "background-color": "#34d399"
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n                                    " +
                                        _vm._s(
                                          _vm._f("number2Digit")(
                                            _vm.balance_days
                                          )
                                        ) +
                                        "\n                                "
                                    )
                                  ]
                                )
                              ]
                            : _vm._e(),
                          _vm._v(" "),
                          _vm.canViewProduction &&
                          _vm.type_module == "production"
                            ? [
                                _c(
                                  "th",
                                  {
                                    staticClass: "text-right text-white",
                                    staticStyle: {
                                      "background-color": "#34d399",
                                      border: "2px solid #000"
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n                                    " +
                                        _vm._s(
                                          _vm._f("number2Digit")(
                                            _vm.balance_daily
                                          )
                                        ) +
                                        "\n                                "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "th",
                                  {
                                    staticClass: "text-right text-white",
                                    staticStyle: {
                                      "background-color": "#34d399",
                                      border: "2px solid #000"
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n                                    " +
                                        _vm._s(
                                          _vm._f("number2Digit")(
                                            _vm.balance_product
                                          )
                                        ) +
                                        "\n                                "
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "th",
                                  {
                                    staticClass: "text-right text-white",
                                    staticStyle: {
                                      "background-color": "#34d399",
                                      border: "2px solid #000"
                                    }
                                  },
                                  [
                                    _vm._v(
                                      "\n                                    " +
                                        _vm._s(
                                          _vm._f("number2Digit")(
                                            _vm.balance_product -
                                              _vm.balance_daily
                                          )
                                        ) +
                                        "\n                                "
                                    )
                                  ]
                                )
                              ]
                            : _vm._e()
                        ],
                        2
                      )
                    ],
                    2
                  )
                ])
              ])
            ],
            2
          )
        ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      { staticClass: "text-center sk-spinner sk-spinner-wave" },
      [
        _c("div", { staticClass: "sk-rect1" }),
        _vm._v(" "),
        _c("div", { staticClass: "sk-rect2" }),
        _vm._v(" "),
        _c("div", { staticClass: "sk-rect3" }),
        _vm._v(" "),
        _c("div", { staticClass: "sk-rect4" }),
        _vm._v(" "),
        _c("div", { staticClass: "sk-rect5" })
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-md-2 p-1" }, [
      _c("span", [_vm._v("   "), _c("br")]),
      _vm._v(" "),
      _c("div", [
        _c("i", { staticClass: "fa fa-square-o fa-2x" }),
        _vm._v("   แผนประมาณการขายปกติ ")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-md-2 p-1" }, [
      _c("span", [_vm._v("   "), _c("br")]),
      _vm._v(" "),
      _c("div", [
        _c("i", {
          staticClass: "fa fa-square fa-2x",
          staticStyle: { color: "#67d0d4" }
        }),
        _vm._v("   แผนสั่งผลิตไม่ครบตามฝ่ายขาย ")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-md-2 p-1" }, [
      _c("span", [_vm._v("   "), _c("br")]),
      _vm._v(" "),
      _c("div", [
        _c("i", {
          staticClass: "fa fa-square fa-2x",
          staticStyle: { color: "#ff8800" }
        }),
        _vm._v("   แผนไม่สั่งผลิตตามฝ่ายขาย ")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-md-2 p-1" }, [
      _c("span", [_vm._v("   "), _c("br")]),
      _vm._v(" "),
      _c("div", [
        _c("i", { staticClass: "fa fa-square-o fa-2x" }),
        _vm._v("   แผนการผลิตปกติ ")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-md-2 p-1" }, [
      _c("span", [_vm._v("   "), _c("br")]),
      _vm._v(" "),
      _c("div", [
        _c("i", {
          staticClass: "fa fa-square fa-2x",
          staticStyle: { color: "#ffcf00" }
        }),
        _vm._v("   ผลิตไม่ครบตามฝ่ายวางแผน ")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-md-2 p-1" }, [
      _c("span", [_vm._v("   "), _c("br")]),
      _vm._v(" "),
      _c("div", [
        _c("i", {
          staticClass: "fa fa-square fa-2x",
          staticStyle: { color: "#e20000" }
        }),
        _vm._v("   ผลิตไม่ตรงแผน (Back Order) ")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "th",
      {
        staticClass: "text-center",
        staticStyle: { "vertical-align": "middle", width: "2%" }
      },
      [_c("div", [_vm._v(" ลำดับ ")])]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "th",
      {
        staticClass: "text-center",
        staticStyle: { "vertical-align": "middle", width: "6%" }
      },
      [_c("div", [_vm._v(" รหัสบุหรี่ ")])]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "th",
      {
        staticClass: "text-center",
        staticStyle: { "vertical-align": "middle", width: "14%" }
      },
      [_c("div", [_vm._v(" ตราบุหรี่ ")])]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "th",
      {
        staticClass: "text-center",
        staticStyle: { "vertical-align": "middle", width: "8%" }
      },
      [
        _c("div", [
          _vm._v(" ประมาณการ"),
          _c("br"),
          _vm._v("แผนขาย"),
          _c("br"),
          _vm._v("(พันมวน) ")
        ])
      ]
    )
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/PlanDaily.vue?vue&type=template&id=4298da4c&":
/*!**********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Daily/components/PlanDaily.vue?vue&type=template&id=4298da4c& ***!
  \**********************************************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "row" }, [
    _c("form", { staticClass: "col-12", attrs: { id: "plan-daily-form" } }, [
      _c("div", { staticClass: "row col-12" }, [
        _c(
          "div",
          {
            staticClass:
              "form-group pl-2 pr-2 mb-0 col-lg-2 col-md-4 col-sm-6 col-xs-6 mt-2"
          },
          [
            _c("label", { staticClass: " tw-font-bold tw-uppercase mb-1" }, [
              _vm._v(" ปีงบประมาณ ")
            ]),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "input-group" },
              [
                _c("el-input", {
                  ref: "budget_year",
                  attrs: {
                    placeholder: "ปีงบประมาณ",
                    disabled: true,
                    size: "medium"
                  },
                  model: {
                    value: _vm.budget_year,
                    callback: function($$v) {
                      _vm.budget_year = $$v
                    },
                    expression: "budget_year"
                  }
                })
              ],
              1
            ),
            _vm._v(" "),
            _c("div", {
              staticClass: "error_msg text-left",
              attrs: { id: "el_explode_budget_year" }
            })
          ]
        ),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass:
              "form-group pl-2 pr-2 mb-0 col-lg-2 col-md-4 col-sm-6 col-xs-6 mt-2"
          },
          [
            _c("label", { staticClass: " tw-font-bold tw-uppercase mb-1" }, [
              _vm._v(" เดือน ")
            ]),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "input-group" },
              [
                _c("el-input", {
                  ref: "month",
                  attrs: {
                    placeholder: "เดือน",
                    disabled: true,
                    size: "medium"
                  },
                  model: {
                    value: _vm.month_th,
                    callback: function($$v) {
                      _vm.month_th = $$v
                    },
                    expression: "month_th"
                  }
                })
              ],
              1
            ),
            _vm._v(" "),
            _c("div", {
              staticClass: "error_msg text-left",
              attrs: { id: "el_explode_month" }
            })
          ]
        ),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass:
              "form-group pl-2 pr-2 mb-0 col-lg-2 col-md-4 col-sm-6 col-xs-6 mt-2"
          },
          [
            _c("label", { staticClass: " tw-font-bold tw-uppercase mb-1" }, [
              _vm._v(" ปักษ์ ")
            ]),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "input-group" },
              [
                _c("el-input", {
                  ref: "bi_weekly",
                  attrs: {
                    placeholder: "ปักษ์",
                    disabled: true,
                    size: "medium"
                  },
                  model: {
                    value: _vm.bi_weekly,
                    callback: function($$v) {
                      _vm.bi_weekly = $$v
                    },
                    expression: "bi_weekly"
                  }
                })
              ],
              1
            ),
            _vm._v(" "),
            _c("div", {
              staticClass: "error_msg text-left",
              attrs: { id: "el_explode_bi_weekly" }
            })
          ]
        ),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass:
              "form-group pl-2 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 mt-2"
          },
          [
            _vm._m(0),
            _vm._v(" "),
            _c(
              "button",
              {
                class: _vm.btnTrans.show.class + " btn-lg mt-3",
                on: {
                  click: function($event) {
                    $event.preventDefault()
                    return _vm.getData($event)
                  }
                }
              },
              [
                _c("i", { class: _vm.btnTrans.show.icon }),
                _vm._v(
                  " " +
                    _vm._s(_vm.btnTrans.show.text) +
                    "\n                    "
                )
              ]
            ),
            _vm._v(" "),
            _c("ControlPlanDaily", {
              attrs: {
                "btn-trans": _vm.btnTrans,
                url: _vm.url,
                "modal-control-input": _vm.modalControlInput,
                "item-production-main": _vm.itemProductionMain,
                "machine-biweekly": _vm.machineBiweekly,
                search: [],
                "product-type": _vm.productType,
                "date-format": _vm.dateFormat,
                "d-budget-year": _vm.budget_year,
                "d-month": _vm.month,
                "d-bi-weekly": _vm.bi_weekly,
                "product-daily-plan": _vm.productDailyPlan,
                "is-control-disable": _vm.isControlDisable
              },
              on: { errorRef: _vm.errorRef, fetchDataP07: _vm.fetchDataP07 }
            }),
            _vm._v(" "),
            _vm.productDailyPlan.can.edit && _vm.isCurrBiweekly
              ? _c(
                  "button",
                  {
                    class: _vm.btnTrans.edit.class + " btn-lg mt-3",
                    on: {
                      click: function($event) {
                        $event.preventDefault()
                        return _vm.reFetchDataP03($event)
                      }
                    }
                  },
                  [
                    _c("i", { staticClass: "fa fa-calendar" }),
                    _vm._v(" อัพเดตชั่วโมงการทำงาน\n                    ")
                  ]
                )
              : _vm._e()
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "col-12 text-right" }, [
        _vm.msg.machine && _vm.isCurrBiweekly
          ? _c("div", [
              _c("h4", { staticClass: "text-danger mt-3" }, [
                _c("div", { domProps: { innerHTML: _vm._s(_vm.msg.machine) } })
              ])
            ])
          : _vm._e(),
        _vm._v(" "),
        _vm.msg.wkh && _vm.isCurrBiweekly
          ? _c("div", [
              _c("h4", { staticClass: "text-danger mt-3" }, [
                _c("div", { domProps: { innerHTML: _vm._s(_vm.msg.wkh) } })
              ])
            ])
          : _vm._e()
      ]),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass:
            "form-group pl-2 pr-2 mb-0 col-lg-12 col-md-12 col-sm-6 col-xs-6 mt-2"
        },
        [
          _c("div", {
            staticClass: "table-responsive",
            domProps: { innerHTML: _vm._s(_vm.html) }
          })
        ]
      )
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [_c("br"), _vm._v("   ")])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vuedraggable/dist/vuedraggable.umd.js":
/*!************************************************************!*\
  !*** ./node_modules/vuedraggable/dist/vuedraggable.umd.js ***!
  \************************************************************/
/***/ (function(module, __unused_webpack_exports, __webpack_require__) {

(function webpackUniversalModuleDefinition(root, factory) {
	if(true)
		module.exports = factory(__webpack_require__(/*! sortablejs */ "./node_modules/sortablejs/modular/sortable.esm.js"));
	else {}
})((typeof self !== 'undefined' ? self : this), function(__WEBPACK_EXTERNAL_MODULE_a352__) {
return /******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __nested_webpack_require_688__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __nested_webpack_require_688__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__nested_webpack_require_688__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__nested_webpack_require_688__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__nested_webpack_require_688__.d = function(exports, name, getter) {
/******/ 		if(!__nested_webpack_require_688__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__nested_webpack_require_688__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__nested_webpack_require_688__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __nested_webpack_require_688__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__nested_webpack_require_688__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __nested_webpack_require_688__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__nested_webpack_require_688__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__nested_webpack_require_688__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__nested_webpack_require_688__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__nested_webpack_require_688__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __nested_webpack_require_688__(__nested_webpack_require_688__.s = "fb15");
/******/ })
/************************************************************************/
/******/ ({

/***/ "01f9":
/***/ (function(module, exports, __nested_webpack_require_4164__) {

"use strict";

var LIBRARY = __nested_webpack_require_4164__("2d00");
var $export = __nested_webpack_require_4164__("5ca1");
var redefine = __nested_webpack_require_4164__("2aba");
var hide = __nested_webpack_require_4164__("32e9");
var Iterators = __nested_webpack_require_4164__("84f2");
var $iterCreate = __nested_webpack_require_4164__("41a0");
var setToStringTag = __nested_webpack_require_4164__("7f20");
var getPrototypeOf = __nested_webpack_require_4164__("38fd");
var ITERATOR = __nested_webpack_require_4164__("2b4c")('iterator');
var BUGGY = !([].keys && 'next' in [].keys()); // Safari has buggy iterators w/o `next`
var FF_ITERATOR = '@@iterator';
var KEYS = 'keys';
var VALUES = 'values';

var returnThis = function () { return this; };

module.exports = function (Base, NAME, Constructor, next, DEFAULT, IS_SET, FORCED) {
  $iterCreate(Constructor, NAME, next);
  var getMethod = function (kind) {
    if (!BUGGY && kind in proto) return proto[kind];
    switch (kind) {
      case KEYS: return function keys() { return new Constructor(this, kind); };
      case VALUES: return function values() { return new Constructor(this, kind); };
    } return function entries() { return new Constructor(this, kind); };
  };
  var TAG = NAME + ' Iterator';
  var DEF_VALUES = DEFAULT == VALUES;
  var VALUES_BUG = false;
  var proto = Base.prototype;
  var $native = proto[ITERATOR] || proto[FF_ITERATOR] || DEFAULT && proto[DEFAULT];
  var $default = $native || getMethod(DEFAULT);
  var $entries = DEFAULT ? !DEF_VALUES ? $default : getMethod('entries') : undefined;
  var $anyNative = NAME == 'Array' ? proto.entries || $native : $native;
  var methods, key, IteratorPrototype;
  // Fix native
  if ($anyNative) {
    IteratorPrototype = getPrototypeOf($anyNative.call(new Base()));
    if (IteratorPrototype !== Object.prototype && IteratorPrototype.next) {
      // Set @@toStringTag to native iterators
      setToStringTag(IteratorPrototype, TAG, true);
      // fix for some old engines
      if (!LIBRARY && typeof IteratorPrototype[ITERATOR] != 'function') hide(IteratorPrototype, ITERATOR, returnThis);
    }
  }
  // fix Array#{values, @@iterator}.name in V8 / FF
  if (DEF_VALUES && $native && $native.name !== VALUES) {
    VALUES_BUG = true;
    $default = function values() { return $native.call(this); };
  }
  // Define iterator
  if ((!LIBRARY || FORCED) && (BUGGY || VALUES_BUG || !proto[ITERATOR])) {
    hide(proto, ITERATOR, $default);
  }
  // Plug for library
  Iterators[NAME] = $default;
  Iterators[TAG] = returnThis;
  if (DEFAULT) {
    methods = {
      values: DEF_VALUES ? $default : getMethod(VALUES),
      keys: IS_SET ? $default : getMethod(KEYS),
      entries: $entries
    };
    if (FORCED) for (key in methods) {
      if (!(key in proto)) redefine(proto, key, methods[key]);
    } else $export($export.P + $export.F * (BUGGY || VALUES_BUG), NAME, methods);
  }
  return methods;
};


/***/ }),

/***/ "02f4":
/***/ (function(module, exports, __nested_webpack_require_7070__) {

var toInteger = __nested_webpack_require_7070__("4588");
var defined = __nested_webpack_require_7070__("be13");
// true  -> String#at
// false -> String#codePointAt
module.exports = function (TO_STRING) {
  return function (that, pos) {
    var s = String(defined(that));
    var i = toInteger(pos);
    var l = s.length;
    var a, b;
    if (i < 0 || i >= l) return TO_STRING ? '' : undefined;
    a = s.charCodeAt(i);
    return a < 0xd800 || a > 0xdbff || i + 1 === l || (b = s.charCodeAt(i + 1)) < 0xdc00 || b > 0xdfff
      ? TO_STRING ? s.charAt(i) : a
      : TO_STRING ? s.slice(i, i + 2) : (a - 0xd800 << 10) + (b - 0xdc00) + 0x10000;
  };
};


/***/ }),

/***/ "0390":
/***/ (function(module, exports, __nested_webpack_require_7783__) {

"use strict";

var at = __nested_webpack_require_7783__("02f4")(true);

 // `AdvanceStringIndex` abstract operation
// https://tc39.github.io/ecma262/#sec-advancestringindex
module.exports = function (S, index, unicode) {
  return index + (unicode ? at(S, index).length : 1);
};


/***/ }),

/***/ "0bfb":
/***/ (function(module, exports, __nested_webpack_require_8134__) {

"use strict";

// 21.2.5.3 get RegExp.prototype.flags
var anObject = __nested_webpack_require_8134__("cb7c");
module.exports = function () {
  var that = anObject(this);
  var result = '';
  if (that.global) result += 'g';
  if (that.ignoreCase) result += 'i';
  if (that.multiline) result += 'm';
  if (that.unicode) result += 'u';
  if (that.sticky) result += 'y';
  return result;
};


/***/ }),

/***/ "0d58":
/***/ (function(module, exports, __nested_webpack_require_8593__) {

// 19.1.2.14 / 15.2.3.14 Object.keys(O)
var $keys = __nested_webpack_require_8593__("ce10");
var enumBugKeys = __nested_webpack_require_8593__("e11e");

module.exports = Object.keys || function keys(O) {
  return $keys(O, enumBugKeys);
};


/***/ }),

/***/ "1495":
/***/ (function(module, exports, __nested_webpack_require_8892__) {

var dP = __nested_webpack_require_8892__("86cc");
var anObject = __nested_webpack_require_8892__("cb7c");
var getKeys = __nested_webpack_require_8892__("0d58");

module.exports = __nested_webpack_require_8892__("9e1e") ? Object.defineProperties : function defineProperties(O, Properties) {
  anObject(O);
  var keys = getKeys(Properties);
  var length = keys.length;
  var i = 0;
  var P;
  while (length > i) dP.f(O, P = keys[i++], Properties[P]);
  return O;
};


/***/ }),

/***/ "214f":
/***/ (function(module, exports, __nested_webpack_require_9392__) {

"use strict";

__nested_webpack_require_9392__("b0c5");
var redefine = __nested_webpack_require_9392__("2aba");
var hide = __nested_webpack_require_9392__("32e9");
var fails = __nested_webpack_require_9392__("79e5");
var defined = __nested_webpack_require_9392__("be13");
var wks = __nested_webpack_require_9392__("2b4c");
var regexpExec = __nested_webpack_require_9392__("520a");

var SPECIES = wks('species');

var REPLACE_SUPPORTS_NAMED_GROUPS = !fails(function () {
  // #replace needs built-in support for named groups.
  // #match works fine because it just return the exec results, even if it has
  // a "grops" property.
  var re = /./;
  re.exec = function () {
    var result = [];
    result.groups = { a: '7' };
    return result;
  };
  return ''.replace(re, '$<a>') !== '7';
});

var SPLIT_WORKS_WITH_OVERWRITTEN_EXEC = (function () {
  // Chrome 51 has a buggy "split" implementation when RegExp#exec !== nativeExec
  var re = /(?:)/;
  var originalExec = re.exec;
  re.exec = function () { return originalExec.apply(this, arguments); };
  var result = 'ab'.split(re);
  return result.length === 2 && result[0] === 'a' && result[1] === 'b';
})();

module.exports = function (KEY, length, exec) {
  var SYMBOL = wks(KEY);

  var DELEGATES_TO_SYMBOL = !fails(function () {
    // String methods call symbol-named RegEp methods
    var O = {};
    O[SYMBOL] = function () { return 7; };
    return ''[KEY](O) != 7;
  });

  var DELEGATES_TO_EXEC = DELEGATES_TO_SYMBOL ? !fails(function () {
    // Symbol-named RegExp methods call .exec
    var execCalled = false;
    var re = /a/;
    re.exec = function () { execCalled = true; return null; };
    if (KEY === 'split') {
      // RegExp[@@split] doesn't call the regex's exec method, but first creates
      // a new one. We need to return the patched regex when creating the new one.
      re.constructor = {};
      re.constructor[SPECIES] = function () { return re; };
    }
    re[SYMBOL]('');
    return !execCalled;
  }) : undefined;

  if (
    !DELEGATES_TO_SYMBOL ||
    !DELEGATES_TO_EXEC ||
    (KEY === 'replace' && !REPLACE_SUPPORTS_NAMED_GROUPS) ||
    (KEY === 'split' && !SPLIT_WORKS_WITH_OVERWRITTEN_EXEC)
  ) {
    var nativeRegExpMethod = /./[SYMBOL];
    var fns = exec(
      defined,
      SYMBOL,
      ''[KEY],
      function maybeCallNative(nativeMethod, regexp, str, arg2, forceStringMethod) {
        if (regexp.exec === regexpExec) {
          if (DELEGATES_TO_SYMBOL && !forceStringMethod) {
            // The native String method already delegates to @@method (this
            // polyfilled function), leasing to infinite recursion.
            // We avoid it by directly calling the native @@method method.
            return { done: true, value: nativeRegExpMethod.call(regexp, str, arg2) };
          }
          return { done: true, value: nativeMethod.call(str, regexp, arg2) };
        }
        return { done: false };
      }
    );
    var strfn = fns[0];
    var rxfn = fns[1];

    redefine(String.prototype, KEY, strfn);
    hide(RegExp.prototype, SYMBOL, length == 2
      // 21.2.5.8 RegExp.prototype[@@replace](string, replaceValue)
      // 21.2.5.11 RegExp.prototype[@@split](string, limit)
      ? function (string, arg) { return rxfn.call(string, this, arg); }
      // 21.2.5.6 RegExp.prototype[@@match](string)
      // 21.2.5.9 RegExp.prototype[@@search](string)
      : function (string) { return rxfn.call(string, this); }
    );
  }
};


/***/ }),

/***/ "230e":
/***/ (function(module, exports, __nested_webpack_require_12849__) {

var isObject = __nested_webpack_require_12849__("d3f4");
var document = __nested_webpack_require_12849__("7726").document;
// typeof document.createElement is 'object' in old IE
var is = isObject(document) && isObject(document.createElement);
module.exports = function (it) {
  return is ? document.createElement(it) : {};
};


/***/ }),

/***/ "23c6":
/***/ (function(module, exports, __nested_webpack_require_13233__) {

// getting tag from 19.1.3.6 Object.prototype.toString()
var cof = __nested_webpack_require_13233__("2d95");
var TAG = __nested_webpack_require_13233__("2b4c")('toStringTag');
// ES3 wrong here
var ARG = cof(function () { return arguments; }()) == 'Arguments';

// fallback for IE11 Script Access Denied error
var tryGet = function (it, key) {
  try {
    return it[key];
  } catch (e) { /* empty */ }
};

module.exports = function (it) {
  var O, T, B;
  return it === undefined ? 'Undefined' : it === null ? 'Null'
    // @@toStringTag case
    : typeof (T = tryGet(O = Object(it), TAG)) == 'string' ? T
    // builtinTag case
    : ARG ? cof(O)
    // ES3 arguments fallback
    : (B = cof(O)) == 'Object' && typeof O.callee == 'function' ? 'Arguments' : B;
};


/***/ }),

/***/ "2621":
/***/ (function(module, exports) {

exports.f = Object.getOwnPropertySymbols;


/***/ }),

/***/ "2aba":
/***/ (function(module, exports, __nested_webpack_require_14160__) {

var global = __nested_webpack_require_14160__("7726");
var hide = __nested_webpack_require_14160__("32e9");
var has = __nested_webpack_require_14160__("69a8");
var SRC = __nested_webpack_require_14160__("ca5a")('src');
var $toString = __nested_webpack_require_14160__("fa5b");
var TO_STRING = 'toString';
var TPL = ('' + $toString).split(TO_STRING);

__nested_webpack_require_14160__("8378").inspectSource = function (it) {
  return $toString.call(it);
};

(module.exports = function (O, key, val, safe) {
  var isFunction = typeof val == 'function';
  if (isFunction) has(val, 'name') || hide(val, 'name', key);
  if (O[key] === val) return;
  if (isFunction) has(val, SRC) || hide(val, SRC, O[key] ? '' + O[key] : TPL.join(String(key)));
  if (O === global) {
    O[key] = val;
  } else if (!safe) {
    delete O[key];
    hide(O, key, val);
  } else if (O[key]) {
    O[key] = val;
  } else {
    hide(O, key, val);
  }
// add fake Function#toString for correct work wrapped methods / constructors with methods like LoDash isNative
})(Function.prototype, TO_STRING, function toString() {
  return typeof this == 'function' && this[SRC] || $toString.call(this);
});


/***/ }),

/***/ "2aeb":
/***/ (function(module, exports, __nested_webpack_require_15334__) {

// 19.1.2.2 / 15.2.3.5 Object.create(O [, Properties])
var anObject = __nested_webpack_require_15334__("cb7c");
var dPs = __nested_webpack_require_15334__("1495");
var enumBugKeys = __nested_webpack_require_15334__("e11e");
var IE_PROTO = __nested_webpack_require_15334__("613b")('IE_PROTO');
var Empty = function () { /* empty */ };
var PROTOTYPE = 'prototype';

// Create object with fake `null` prototype: use iframe Object with cleared prototype
var createDict = function () {
  // Thrash, waste and sodomy: IE GC bug
  var iframe = __nested_webpack_require_15334__("230e")('iframe');
  var i = enumBugKeys.length;
  var lt = '<';
  var gt = '>';
  var iframeDocument;
  iframe.style.display = 'none';
  __nested_webpack_require_15334__("fab2").appendChild(iframe);
  iframe.src = 'javascript:'; // eslint-disable-line no-script-url
  // createDict = iframe.contentWindow.Object;
  // html.removeChild(iframe);
  iframeDocument = iframe.contentWindow.document;
  iframeDocument.open();
  iframeDocument.write(lt + 'script' + gt + 'document.F=Object' + lt + '/script' + gt);
  iframeDocument.close();
  createDict = iframeDocument.F;
  while (i--) delete createDict[PROTOTYPE][enumBugKeys[i]];
  return createDict();
};

module.exports = Object.create || function create(O, Properties) {
  var result;
  if (O !== null) {
    Empty[PROTOTYPE] = anObject(O);
    result = new Empty();
    Empty[PROTOTYPE] = null;
    // add "__proto__" for Object.getPrototypeOf polyfill
    result[IE_PROTO] = O;
  } else result = createDict();
  return Properties === undefined ? result : dPs(result, Properties);
};


/***/ }),

/***/ "2b4c":
/***/ (function(module, exports, __nested_webpack_require_16945__) {

var store = __nested_webpack_require_16945__("5537")('wks');
var uid = __nested_webpack_require_16945__("ca5a");
var Symbol = __nested_webpack_require_16945__("7726").Symbol;
var USE_SYMBOL = typeof Symbol == 'function';

var $exports = module.exports = function (name) {
  return store[name] || (store[name] =
    USE_SYMBOL && Symbol[name] || (USE_SYMBOL ? Symbol : uid)('Symbol.' + name));
};

$exports.store = store;


/***/ }),

/***/ "2d00":
/***/ (function(module, exports) {

module.exports = false;


/***/ }),

/***/ "2d95":
/***/ (function(module, exports) {

var toString = {}.toString;

module.exports = function (it) {
  return toString.call(it).slice(8, -1);
};


/***/ }),

/***/ "2fdb":
/***/ (function(module, exports, __nested_webpack_require_17667__) {

"use strict";
// 21.1.3.7 String.prototype.includes(searchString, position = 0)

var $export = __nested_webpack_require_17667__("5ca1");
var context = __nested_webpack_require_17667__("d2c8");
var INCLUDES = 'includes';

$export($export.P + $export.F * __nested_webpack_require_17667__("5147")(INCLUDES), 'String', {
  includes: function includes(searchString /* , position = 0 */) {
    return !!~context(this, searchString, INCLUDES)
      .indexOf(searchString, arguments.length > 1 ? arguments[1] : undefined);
  }
});


/***/ }),

/***/ "32e9":
/***/ (function(module, exports, __nested_webpack_require_18235__) {

var dP = __nested_webpack_require_18235__("86cc");
var createDesc = __nested_webpack_require_18235__("4630");
module.exports = __nested_webpack_require_18235__("9e1e") ? function (object, key, value) {
  return dP.f(object, key, createDesc(1, value));
} : function (object, key, value) {
  object[key] = value;
  return object;
};


/***/ }),

/***/ "38fd":
/***/ (function(module, exports, __nested_webpack_require_18611__) {

// 19.1.2.9 / 15.2.3.2 Object.getPrototypeOf(O)
var has = __nested_webpack_require_18611__("69a8");
var toObject = __nested_webpack_require_18611__("4bf8");
var IE_PROTO = __nested_webpack_require_18611__("613b")('IE_PROTO');
var ObjectProto = Object.prototype;

module.exports = Object.getPrototypeOf || function (O) {
  O = toObject(O);
  if (has(O, IE_PROTO)) return O[IE_PROTO];
  if (typeof O.constructor == 'function' && O instanceof O.constructor) {
    return O.constructor.prototype;
  } return O instanceof Object ? ObjectProto : null;
};


/***/ }),

/***/ "41a0":
/***/ (function(module, exports, __nested_webpack_require_19205__) {

"use strict";

var create = __nested_webpack_require_19205__("2aeb");
var descriptor = __nested_webpack_require_19205__("4630");
var setToStringTag = __nested_webpack_require_19205__("7f20");
var IteratorPrototype = {};

// 25.1.2.1.1 %IteratorPrototype%[@@iterator]()
__nested_webpack_require_19205__("32e9")(IteratorPrototype, __nested_webpack_require_19205__("2b4c")('iterator'), function () { return this; });

module.exports = function (Constructor, NAME, next) {
  Constructor.prototype = create(IteratorPrototype, { next: descriptor(1, next) });
  setToStringTag(Constructor, NAME + ' Iterator');
};


/***/ }),

/***/ "456d":
/***/ (function(module, exports, __nested_webpack_require_19831__) {

// 19.1.2.14 Object.keys(O)
var toObject = __nested_webpack_require_19831__("4bf8");
var $keys = __nested_webpack_require_19831__("0d58");

__nested_webpack_require_19831__("5eda")('keys', function () {
  return function keys(it) {
    return $keys(toObject(it));
  };
});


/***/ }),

/***/ "4588":
/***/ (function(module, exports) {

// 7.1.4 ToInteger
var ceil = Math.ceil;
var floor = Math.floor;
module.exports = function (it) {
  return isNaN(it = +it) ? 0 : (it > 0 ? floor : ceil)(it);
};


/***/ }),

/***/ "4630":
/***/ (function(module, exports) {

module.exports = function (bitmap, value) {
  return {
    enumerable: !(bitmap & 1),
    configurable: !(bitmap & 2),
    writable: !(bitmap & 4),
    value: value
  };
};


/***/ }),

/***/ "4bf8":
/***/ (function(module, exports, __nested_webpack_require_20609__) {

// 7.1.13 ToObject(argument)
var defined = __nested_webpack_require_20609__("be13");
module.exports = function (it) {
  return Object(defined(it));
};


/***/ }),

/***/ "5147":
/***/ (function(module, exports, __nested_webpack_require_20831__) {

var MATCH = __nested_webpack_require_20831__("2b4c")('match');
module.exports = function (KEY) {
  var re = /./;
  try {
    '/./'[KEY](re);
  } catch (e) {
    try {
      re[MATCH] = false;
      return !'/./'[KEY](re);
    } catch (f) { /* empty */ }
  } return true;
};


/***/ }),

/***/ "520a":
/***/ (function(module, exports, __nested_webpack_require_21176__) {

"use strict";


var regexpFlags = __nested_webpack_require_21176__("0bfb");

var nativeExec = RegExp.prototype.exec;
// This always refers to the native implementation, because the
// String#replace polyfill uses ./fix-regexp-well-known-symbol-logic.js,
// which loads this file before patching the method.
var nativeReplace = String.prototype.replace;

var patchedExec = nativeExec;

var LAST_INDEX = 'lastIndex';

var UPDATES_LAST_INDEX_WRONG = (function () {
  var re1 = /a/,
      re2 = /b*/g;
  nativeExec.call(re1, 'a');
  nativeExec.call(re2, 'a');
  return re1[LAST_INDEX] !== 0 || re2[LAST_INDEX] !== 0;
})();

// nonparticipating capturing group, copied from es5-shim's String#split patch.
var NPCG_INCLUDED = /()??/.exec('')[1] !== undefined;

var PATCH = UPDATES_LAST_INDEX_WRONG || NPCG_INCLUDED;

if (PATCH) {
  patchedExec = function exec(str) {
    var re = this;
    var lastIndex, reCopy, match, i;

    if (NPCG_INCLUDED) {
      reCopy = new RegExp('^' + re.source + '$(?!\\s)', regexpFlags.call(re));
    }
    if (UPDATES_LAST_INDEX_WRONG) lastIndex = re[LAST_INDEX];

    match = nativeExec.call(re, str);

    if (UPDATES_LAST_INDEX_WRONG && match) {
      re[LAST_INDEX] = re.global ? match.index + match[0].length : lastIndex;
    }
    if (NPCG_INCLUDED && match && match.length > 1) {
      // Fix browsers whose `exec` methods don't consistently return `undefined`
      // for NPCG, like IE8. NOTE: This doesn' work for /(.?)?/
      // eslint-disable-next-line no-loop-func
      nativeReplace.call(match[0], reCopy, function () {
        for (i = 1; i < arguments.length - 2; i++) {
          if (arguments[i] === undefined) match[i] = undefined;
        }
      });
    }

    return match;
  };
}

module.exports = patchedExec;


/***/ }),

/***/ "52a7":
/***/ (function(module, exports) {

exports.f = {}.propertyIsEnumerable;


/***/ }),

/***/ "5537":
/***/ (function(module, exports, __nested_webpack_require_23109__) {

var core = __nested_webpack_require_23109__("8378");
var global = __nested_webpack_require_23109__("7726");
var SHARED = '__core-js_shared__';
var store = global[SHARED] || (global[SHARED] = {});

(module.exports = function (key, value) {
  return store[key] || (store[key] = value !== undefined ? value : {});
})('versions', []).push({
  version: core.version,
  mode: __nested_webpack_require_23109__("2d00") ? 'pure' : 'global',
  copyright: '© 2019 Denis Pushkarev (zloirock.ru)'
});


/***/ }),

/***/ "5ca1":
/***/ (function(module, exports, __nested_webpack_require_23642__) {

var global = __nested_webpack_require_23642__("7726");
var core = __nested_webpack_require_23642__("8378");
var hide = __nested_webpack_require_23642__("32e9");
var redefine = __nested_webpack_require_23642__("2aba");
var ctx = __nested_webpack_require_23642__("9b43");
var PROTOTYPE = 'prototype';

var $export = function (type, name, source) {
  var IS_FORCED = type & $export.F;
  var IS_GLOBAL = type & $export.G;
  var IS_STATIC = type & $export.S;
  var IS_PROTO = type & $export.P;
  var IS_BIND = type & $export.B;
  var target = IS_GLOBAL ? global : IS_STATIC ? global[name] || (global[name] = {}) : (global[name] || {})[PROTOTYPE];
  var exports = IS_GLOBAL ? core : core[name] || (core[name] = {});
  var expProto = exports[PROTOTYPE] || (exports[PROTOTYPE] = {});
  var key, own, out, exp;
  if (IS_GLOBAL) source = name;
  for (key in source) {
    // contains in native
    own = !IS_FORCED && target && target[key] !== undefined;
    // export native or passed
    out = (own ? target : source)[key];
    // bind timers to global for call from export context
    exp = IS_BIND && own ? ctx(out, global) : IS_PROTO && typeof out == 'function' ? ctx(Function.call, out) : out;
    // extend global
    if (target) redefine(target, key, out, type & $export.U);
    // export
    if (exports[key] != out) hide(exports, key, exp);
    if (IS_PROTO && expProto[key] != out) expProto[key] = out;
  }
};
global.core = core;
// type bitmap
$export.F = 1;   // forced
$export.G = 2;   // global
$export.S = 4;   // static
$export.P = 8;   // proto
$export.B = 16;  // bind
$export.W = 32;  // wrap
$export.U = 64;  // safe
$export.R = 128; // real proto method for `library`
module.exports = $export;


/***/ }),

/***/ "5eda":
/***/ (function(module, exports, __nested_webpack_require_25367__) {

// most Object methods by ES6 should accept primitives
var $export = __nested_webpack_require_25367__("5ca1");
var core = __nested_webpack_require_25367__("8378");
var fails = __nested_webpack_require_25367__("79e5");
module.exports = function (KEY, exec) {
  var fn = (core.Object || {})[KEY] || Object[KEY];
  var exp = {};
  exp[KEY] = exec(fn);
  $export($export.S + $export.F * fails(function () { fn(1); }), 'Object', exp);
};


/***/ }),

/***/ "5f1b":
/***/ (function(module, exports, __nested_webpack_require_25845__) {

"use strict";


var classof = __nested_webpack_require_25845__("23c6");
var builtinExec = RegExp.prototype.exec;

 // `RegExpExec` abstract operation
// https://tc39.github.io/ecma262/#sec-regexpexec
module.exports = function (R, S) {
  var exec = R.exec;
  if (typeof exec === 'function') {
    var result = exec.call(R, S);
    if (typeof result !== 'object') {
      throw new TypeError('RegExp exec method returned something other than an Object or null');
    }
    return result;
  }
  if (classof(R) !== 'RegExp') {
    throw new TypeError('RegExp#exec called on incompatible receiver');
  }
  return builtinExec.call(R, S);
};


/***/ }),

/***/ "613b":
/***/ (function(module, exports, __nested_webpack_require_26551__) {

var shared = __nested_webpack_require_26551__("5537")('keys');
var uid = __nested_webpack_require_26551__("ca5a");
module.exports = function (key) {
  return shared[key] || (shared[key] = uid(key));
};


/***/ }),

/***/ "626a":
/***/ (function(module, exports, __nested_webpack_require_26811__) {

// fallback for non-array-like ES3 and non-enumerable old V8 strings
var cof = __nested_webpack_require_26811__("2d95");
// eslint-disable-next-line no-prototype-builtins
module.exports = Object('z').propertyIsEnumerable(0) ? Object : function (it) {
  return cof(it) == 'String' ? it.split('') : Object(it);
};


/***/ }),

/***/ "6762":
/***/ (function(module, exports, __nested_webpack_require_27194__) {

"use strict";

// https://github.com/tc39/Array.prototype.includes
var $export = __nested_webpack_require_27194__("5ca1");
var $includes = __nested_webpack_require_27194__("c366")(true);

$export($export.P, 'Array', {
  includes: function includes(el /* , fromIndex = 0 */) {
    return $includes(this, el, arguments.length > 1 ? arguments[1] : undefined);
  }
});

__nested_webpack_require_27194__("9c6c")('includes');


/***/ }),

/***/ "6821":
/***/ (function(module, exports, __nested_webpack_require_27659__) {

// to indexed object, toObject with fallback for non-array-like ES3 strings
var IObject = __nested_webpack_require_27659__("626a");
var defined = __nested_webpack_require_27659__("be13");
module.exports = function (it) {
  return IObject(defined(it));
};


/***/ }),

/***/ "69a8":
/***/ (function(module, exports) {

var hasOwnProperty = {}.hasOwnProperty;
module.exports = function (it, key) {
  return hasOwnProperty.call(it, key);
};


/***/ }),

/***/ "6a99":
/***/ (function(module, exports, __nested_webpack_require_28155__) {

// 7.1.1 ToPrimitive(input [, PreferredType])
var isObject = __nested_webpack_require_28155__("d3f4");
// instead of the ES6 spec version, we didn't implement @@toPrimitive case
// and the second argument - flag - preferred type is a string
module.exports = function (it, S) {
  if (!isObject(it)) return it;
  var fn, val;
  if (S && typeof (fn = it.toString) == 'function' && !isObject(val = fn.call(it))) return val;
  if (typeof (fn = it.valueOf) == 'function' && !isObject(val = fn.call(it))) return val;
  if (!S && typeof (fn = it.toString) == 'function' && !isObject(val = fn.call(it))) return val;
  throw TypeError("Can't convert object to primitive value");
};


/***/ }),

/***/ "7333":
/***/ (function(module, exports, __nested_webpack_require_28898__) {

"use strict";

// 19.1.2.1 Object.assign(target, source, ...)
var getKeys = __nested_webpack_require_28898__("0d58");
var gOPS = __nested_webpack_require_28898__("2621");
var pIE = __nested_webpack_require_28898__("52a7");
var toObject = __nested_webpack_require_28898__("4bf8");
var IObject = __nested_webpack_require_28898__("626a");
var $assign = Object.assign;

// should work with symbols and should have deterministic property order (V8 bug)
module.exports = !$assign || __nested_webpack_require_28898__("79e5")(function () {
  var A = {};
  var B = {};
  // eslint-disable-next-line no-undef
  var S = Symbol();
  var K = 'abcdefghijklmnopqrst';
  A[S] = 7;
  K.split('').forEach(function (k) { B[k] = k; });
  return $assign({}, A)[S] != 7 || Object.keys($assign({}, B)).join('') != K;
}) ? function assign(target, source) { // eslint-disable-line no-unused-vars
  var T = toObject(target);
  var aLen = arguments.length;
  var index = 1;
  var getSymbols = gOPS.f;
  var isEnum = pIE.f;
  while (aLen > index) {
    var S = IObject(arguments[index++]);
    var keys = getSymbols ? getKeys(S).concat(getSymbols(S)) : getKeys(S);
    var length = keys.length;
    var j = 0;
    var key;
    while (length > j) if (isEnum.call(S, key = keys[j++])) T[key] = S[key];
  } return T;
} : $assign;


/***/ }),

/***/ "7726":
/***/ (function(module, exports) {

// https://github.com/zloirock/core-js/issues/86#issuecomment-115759028
var global = module.exports = typeof window != 'undefined' && window.Math == Math
  ? window : typeof self != 'undefined' && self.Math == Math ? self
  // eslint-disable-next-line no-new-func
  : Function('return this')();
if (typeof __g == 'number') __g = global; // eslint-disable-line no-undef


/***/ }),

/***/ "77f1":
/***/ (function(module, exports, __nested_webpack_require_30635__) {

var toInteger = __nested_webpack_require_30635__("4588");
var max = Math.max;
var min = Math.min;
module.exports = function (index, length) {
  index = toInteger(index);
  return index < 0 ? max(index + length, 0) : min(index, length);
};


/***/ }),

/***/ "79e5":
/***/ (function(module, exports) {

module.exports = function (exec) {
  try {
    return !!exec();
  } catch (e) {
    return true;
  }
};


/***/ }),

/***/ "7f20":
/***/ (function(module, exports, __nested_webpack_require_31112__) {

var def = __nested_webpack_require_31112__("86cc").f;
var has = __nested_webpack_require_31112__("69a8");
var TAG = __nested_webpack_require_31112__("2b4c")('toStringTag');

module.exports = function (it, tag, stat) {
  if (it && !has(it = stat ? it : it.prototype, TAG)) def(it, TAG, { configurable: true, value: tag });
};


/***/ }),

/***/ "8378":
/***/ (function(module, exports) {

var core = module.exports = { version: '2.6.5' };
if (typeof __e == 'number') __e = core; // eslint-disable-line no-undef


/***/ }),

/***/ "84f2":
/***/ (function(module, exports) {

module.exports = {};


/***/ }),

/***/ "86cc":
/***/ (function(module, exports, __nested_webpack_require_31751__) {

var anObject = __nested_webpack_require_31751__("cb7c");
var IE8_DOM_DEFINE = __nested_webpack_require_31751__("c69a");
var toPrimitive = __nested_webpack_require_31751__("6a99");
var dP = Object.defineProperty;

exports.f = __nested_webpack_require_31751__("9e1e") ? Object.defineProperty : function defineProperty(O, P, Attributes) {
  anObject(O);
  P = toPrimitive(P, true);
  anObject(Attributes);
  if (IE8_DOM_DEFINE) try {
    return dP(O, P, Attributes);
  } catch (e) { /* empty */ }
  if ('get' in Attributes || 'set' in Attributes) throw TypeError('Accessors not supported!');
  if ('value' in Attributes) O[P] = Attributes.value;
  return O;
};


/***/ }),

/***/ "9b43":
/***/ (function(module, exports, __nested_webpack_require_32441__) {

// optional / simple context binding
var aFunction = __nested_webpack_require_32441__("d8e8");
module.exports = function (fn, that, length) {
  aFunction(fn);
  if (that === undefined) return fn;
  switch (length) {
    case 1: return function (a) {
      return fn.call(that, a);
    };
    case 2: return function (a, b) {
      return fn.call(that, a, b);
    };
    case 3: return function (a, b, c) {
      return fn.call(that, a, b, c);
    };
  }
  return function (/* ...args */) {
    return fn.apply(that, arguments);
  };
};


/***/ }),

/***/ "9c6c":
/***/ (function(module, exports, __nested_webpack_require_33048__) {

// 22.1.3.31 Array.prototype[@@unscopables]
var UNSCOPABLES = __nested_webpack_require_33048__("2b4c")('unscopables');
var ArrayProto = Array.prototype;
if (ArrayProto[UNSCOPABLES] == undefined) __nested_webpack_require_33048__("32e9")(ArrayProto, UNSCOPABLES, {});
module.exports = function (key) {
  ArrayProto[UNSCOPABLES][key] = true;
};


/***/ }),

/***/ "9def":
/***/ (function(module, exports, __nested_webpack_require_33448__) {

// 7.1.15 ToLength
var toInteger = __nested_webpack_require_33448__("4588");
var min = Math.min;
module.exports = function (it) {
  return it > 0 ? min(toInteger(it), 0x1fffffffffffff) : 0; // pow(2, 53) - 1 == 9007199254740991
};


/***/ }),

/***/ "9e1e":
/***/ (function(module, exports, __nested_webpack_require_33750__) {

// Thank's IE8 for his funny defineProperty
module.exports = !__nested_webpack_require_33750__("79e5")(function () {
  return Object.defineProperty({}, 'a', { get: function () { return 7; } }).a != 7;
});


/***/ }),

/***/ "a352":
/***/ (function(module, exports) {

module.exports = __WEBPACK_EXTERNAL_MODULE_a352__;

/***/ }),

/***/ "a481":
/***/ (function(module, exports, __nested_webpack_require_34139__) {

"use strict";


var anObject = __nested_webpack_require_34139__("cb7c");
var toObject = __nested_webpack_require_34139__("4bf8");
var toLength = __nested_webpack_require_34139__("9def");
var toInteger = __nested_webpack_require_34139__("4588");
var advanceStringIndex = __nested_webpack_require_34139__("0390");
var regExpExec = __nested_webpack_require_34139__("5f1b");
var max = Math.max;
var min = Math.min;
var floor = Math.floor;
var SUBSTITUTION_SYMBOLS = /\$([$&`']|\d\d?|<[^>]*>)/g;
var SUBSTITUTION_SYMBOLS_NO_NAMED = /\$([$&`']|\d\d?)/g;

var maybeToString = function (it) {
  return it === undefined ? it : String(it);
};

// @@replace logic
__nested_webpack_require_34139__("214f")('replace', 2, function (defined, REPLACE, $replace, maybeCallNative) {
  return [
    // `String.prototype.replace` method
    // https://tc39.github.io/ecma262/#sec-string.prototype.replace
    function replace(searchValue, replaceValue) {
      var O = defined(this);
      var fn = searchValue == undefined ? undefined : searchValue[REPLACE];
      return fn !== undefined
        ? fn.call(searchValue, O, replaceValue)
        : $replace.call(String(O), searchValue, replaceValue);
    },
    // `RegExp.prototype[@@replace]` method
    // https://tc39.github.io/ecma262/#sec-regexp.prototype-@@replace
    function (regexp, replaceValue) {
      var res = maybeCallNative($replace, regexp, this, replaceValue);
      if (res.done) return res.value;

      var rx = anObject(regexp);
      var S = String(this);
      var functionalReplace = typeof replaceValue === 'function';
      if (!functionalReplace) replaceValue = String(replaceValue);
      var global = rx.global;
      if (global) {
        var fullUnicode = rx.unicode;
        rx.lastIndex = 0;
      }
      var results = [];
      while (true) {
        var result = regExpExec(rx, S);
        if (result === null) break;
        results.push(result);
        if (!global) break;
        var matchStr = String(result[0]);
        if (matchStr === '') rx.lastIndex = advanceStringIndex(S, toLength(rx.lastIndex), fullUnicode);
      }
      var accumulatedResult = '';
      var nextSourcePosition = 0;
      for (var i = 0; i < results.length; i++) {
        result = results[i];
        var matched = String(result[0]);
        var position = max(min(toInteger(result.index), S.length), 0);
        var captures = [];
        // NOTE: This is equivalent to
        //   captures = result.slice(1).map(maybeToString)
        // but for some reason `nativeSlice.call(result, 1, result.length)` (called in
        // the slice polyfill when slicing native arrays) "doesn't work" in safari 9 and
        // causes a crash (https://pastebin.com/N21QzeQA) when trying to debug it.
        for (var j = 1; j < result.length; j++) captures.push(maybeToString(result[j]));
        var namedCaptures = result.groups;
        if (functionalReplace) {
          var replacerArgs = [matched].concat(captures, position, S);
          if (namedCaptures !== undefined) replacerArgs.push(namedCaptures);
          var replacement = String(replaceValue.apply(undefined, replacerArgs));
        } else {
          replacement = getSubstitution(matched, S, position, captures, namedCaptures, replaceValue);
        }
        if (position >= nextSourcePosition) {
          accumulatedResult += S.slice(nextSourcePosition, position) + replacement;
          nextSourcePosition = position + matched.length;
        }
      }
      return accumulatedResult + S.slice(nextSourcePosition);
    }
  ];

    // https://tc39.github.io/ecma262/#sec-getsubstitution
  function getSubstitution(matched, str, position, captures, namedCaptures, replacement) {
    var tailPos = position + matched.length;
    var m = captures.length;
    var symbols = SUBSTITUTION_SYMBOLS_NO_NAMED;
    if (namedCaptures !== undefined) {
      namedCaptures = toObject(namedCaptures);
      symbols = SUBSTITUTION_SYMBOLS;
    }
    return $replace.call(replacement, symbols, function (match, ch) {
      var capture;
      switch (ch.charAt(0)) {
        case '$': return '$';
        case '&': return matched;
        case '`': return str.slice(0, position);
        case "'": return str.slice(tailPos);
        case '<':
          capture = namedCaptures[ch.slice(1, -1)];
          break;
        default: // \d\d?
          var n = +ch;
          if (n === 0) return match;
          if (n > m) {
            var f = floor(n / 10);
            if (f === 0) return match;
            if (f <= m) return captures[f - 1] === undefined ? ch.charAt(1) : captures[f - 1] + ch.charAt(1);
            return match;
          }
          capture = captures[n - 1];
      }
      return capture === undefined ? '' : capture;
    });
  }
});


/***/ }),

/***/ "aae3":
/***/ (function(module, exports, __nested_webpack_require_38885__) {

// 7.2.8 IsRegExp(argument)
var isObject = __nested_webpack_require_38885__("d3f4");
var cof = __nested_webpack_require_38885__("2d95");
var MATCH = __nested_webpack_require_38885__("2b4c")('match');
module.exports = function (it) {
  var isRegExp;
  return isObject(it) && ((isRegExp = it[MATCH]) !== undefined ? !!isRegExp : cof(it) == 'RegExp');
};


/***/ }),

/***/ "ac6a":
/***/ (function(module, exports, __nested_webpack_require_39282__) {

var $iterators = __nested_webpack_require_39282__("cadf");
var getKeys = __nested_webpack_require_39282__("0d58");
var redefine = __nested_webpack_require_39282__("2aba");
var global = __nested_webpack_require_39282__("7726");
var hide = __nested_webpack_require_39282__("32e9");
var Iterators = __nested_webpack_require_39282__("84f2");
var wks = __nested_webpack_require_39282__("2b4c");
var ITERATOR = wks('iterator');
var TO_STRING_TAG = wks('toStringTag');
var ArrayValues = Iterators.Array;

var DOMIterables = {
  CSSRuleList: true, // TODO: Not spec compliant, should be false.
  CSSStyleDeclaration: false,
  CSSValueList: false,
  ClientRectList: false,
  DOMRectList: false,
  DOMStringList: false,
  DOMTokenList: true,
  DataTransferItemList: false,
  FileList: false,
  HTMLAllCollection: false,
  HTMLCollection: false,
  HTMLFormElement: false,
  HTMLSelectElement: false,
  MediaList: true, // TODO: Not spec compliant, should be false.
  MimeTypeArray: false,
  NamedNodeMap: false,
  NodeList: true,
  PaintRequestList: false,
  Plugin: false,
  PluginArray: false,
  SVGLengthList: false,
  SVGNumberList: false,
  SVGPathSegList: false,
  SVGPointList: false,
  SVGStringList: false,
  SVGTransformList: false,
  SourceBufferList: false,
  StyleSheetList: true, // TODO: Not spec compliant, should be false.
  TextTrackCueList: false,
  TextTrackList: false,
  TouchList: false
};

for (var collections = getKeys(DOMIterables), i = 0; i < collections.length; i++) {
  var NAME = collections[i];
  var explicit = DOMIterables[NAME];
  var Collection = global[NAME];
  var proto = Collection && Collection.prototype;
  var key;
  if (proto) {
    if (!proto[ITERATOR]) hide(proto, ITERATOR, ArrayValues);
    if (!proto[TO_STRING_TAG]) hide(proto, TO_STRING_TAG, NAME);
    Iterators[NAME] = ArrayValues;
    if (explicit) for (key in $iterators) if (!proto[key]) redefine(proto, key, $iterators[key], true);
  }
}


/***/ }),

/***/ "b0c5":
/***/ (function(module, exports, __nested_webpack_require_41209__) {

"use strict";

var regexpExec = __nested_webpack_require_41209__("520a");
__nested_webpack_require_41209__("5ca1")({
  target: 'RegExp',
  proto: true,
  forced: regexpExec !== /./.exec
}, {
  exec: regexpExec
});


/***/ }),

/***/ "be13":
/***/ (function(module, exports) {

// 7.2.1 RequireObjectCoercible(argument)
module.exports = function (it) {
  if (it == undefined) throw TypeError("Can't call method on  " + it);
  return it;
};


/***/ }),

/***/ "c366":
/***/ (function(module, exports, __nested_webpack_require_41706__) {

// false -> Array#indexOf
// true  -> Array#includes
var toIObject = __nested_webpack_require_41706__("6821");
var toLength = __nested_webpack_require_41706__("9def");
var toAbsoluteIndex = __nested_webpack_require_41706__("77f1");
module.exports = function (IS_INCLUDES) {
  return function ($this, el, fromIndex) {
    var O = toIObject($this);
    var length = toLength(O.length);
    var index = toAbsoluteIndex(fromIndex, length);
    var value;
    // Array#includes uses SameValueZero equality algorithm
    // eslint-disable-next-line no-self-compare
    if (IS_INCLUDES && el != el) while (length > index) {
      value = O[index++];
      // eslint-disable-next-line no-self-compare
      if (value != value) return true;
    // Array#indexOf ignores holes, Array#includes - not
    } else for (;length > index; index++) if (IS_INCLUDES || index in O) {
      if (O[index] === el) return IS_INCLUDES || index || 0;
    } return !IS_INCLUDES && -1;
  };
};


/***/ }),

/***/ "c649":
/***/ (function(module, __webpack_exports__, __nested_webpack_require_42729__) {

"use strict";
/* WEBPACK VAR INJECTION */(function(global) {/* harmony export (binding) */ __nested_webpack_require_42729__.d(__webpack_exports__, "c", function() { return insertNodeAt; });
/* harmony export (binding) */ __nested_webpack_require_42729__.d(__webpack_exports__, "a", function() { return camelize; });
/* harmony export (binding) */ __nested_webpack_require_42729__.d(__webpack_exports__, "b", function() { return console; });
/* harmony export (binding) */ __nested_webpack_require_42729__.d(__webpack_exports__, "d", function() { return removeNode; });
/* harmony import */ var core_js_modules_es6_regexp_replace__WEBPACK_IMPORTED_MODULE_0__ = __nested_webpack_require_42729__("a481");
/* harmony import */ var core_js_modules_es6_regexp_replace__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__nested_webpack_require_42729__.n(core_js_modules_es6_regexp_replace__WEBPACK_IMPORTED_MODULE_0__);


function getConsole() {
  if (typeof window !== "undefined") {
    return window.console;
  }

  return global.console;
}

var console = getConsole();

function cached(fn) {
  var cache = Object.create(null);
  return function cachedFn(str) {
    var hit = cache[str];
    return hit || (cache[str] = fn(str));
  };
}

var regex = /-(\w)/g;
var camelize = cached(function (str) {
  return str.replace(regex, function (_, c) {
    return c ? c.toUpperCase() : "";
  });
});

function removeNode(node) {
  if (node.parentElement !== null) {
    node.parentElement.removeChild(node);
  }
}

function insertNodeAt(fatherNode, node, position) {
  var refNode = position === 0 ? fatherNode.children[0] : fatherNode.children[position - 1].nextSibling;
  fatherNode.insertBefore(node, refNode);
}


/* WEBPACK VAR INJECTION */}.call(this, __nested_webpack_require_42729__("c8ba")))

/***/ }),

/***/ "c69a":
/***/ (function(module, exports, __nested_webpack_require_44512__) {

module.exports = !__nested_webpack_require_44512__("9e1e") && !__nested_webpack_require_44512__("79e5")(function () {
  return Object.defineProperty(__nested_webpack_require_44512__("230e")('div'), 'a', { get: function () { return 7; } }).a != 7;
});


/***/ }),

/***/ "c8ba":
/***/ (function(module, exports) {

var g;

// This works in non-strict mode
g = (function() {
	return this;
})();

try {
	// This works if eval is allowed (see CSP)
	g = g || new Function("return this")();
} catch (e) {
	// This works if the window reference is available
	if (typeof window === "object") g = window;
}

// g can still be undefined, but nothing to do about it...
// We return undefined, instead of nothing here, so it's
// easier to handle this case. if(!global) { ...}

module.exports = g;


/***/ }),

/***/ "ca5a":
/***/ (function(module, exports) {

var id = 0;
var px = Math.random();
module.exports = function (key) {
  return 'Symbol('.concat(key === undefined ? '' : key, ')_', (++id + px).toString(36));
};


/***/ }),

/***/ "cadf":
/***/ (function(module, exports, __nested_webpack_require_45568__) {

"use strict";

var addToUnscopables = __nested_webpack_require_45568__("9c6c");
var step = __nested_webpack_require_45568__("d53b");
var Iterators = __nested_webpack_require_45568__("84f2");
var toIObject = __nested_webpack_require_45568__("6821");

// 22.1.3.4 Array.prototype.entries()
// 22.1.3.13 Array.prototype.keys()
// 22.1.3.29 Array.prototype.values()
// 22.1.3.30 Array.prototype[@@iterator]()
module.exports = __nested_webpack_require_45568__("01f9")(Array, 'Array', function (iterated, kind) {
  this._t = toIObject(iterated); // target
  this._i = 0;                   // next index
  this._k = kind;                // kind
// 22.1.5.2.1 %ArrayIteratorPrototype%.next()
}, function () {
  var O = this._t;
  var kind = this._k;
  var index = this._i++;
  if (!O || index >= O.length) {
    this._t = undefined;
    return step(1);
  }
  if (kind == 'keys') return step(0, index);
  if (kind == 'values') return step(0, O[index]);
  return step(0, [index, O[index]]);
}, 'values');

// argumentsList[@@iterator] is %ArrayProto_values% (9.4.4.6, 9.4.4.7)
Iterators.Arguments = Iterators.Array;

addToUnscopables('keys');
addToUnscopables('values');
addToUnscopables('entries');


/***/ }),

/***/ "cb7c":
/***/ (function(module, exports, __nested_webpack_require_46777__) {

var isObject = __nested_webpack_require_46777__("d3f4");
module.exports = function (it) {
  if (!isObject(it)) throw TypeError(it + ' is not an object!');
  return it;
};


/***/ }),

/***/ "ce10":
/***/ (function(module, exports, __nested_webpack_require_47019__) {

var has = __nested_webpack_require_47019__("69a8");
var toIObject = __nested_webpack_require_47019__("6821");
var arrayIndexOf = __nested_webpack_require_47019__("c366")(false);
var IE_PROTO = __nested_webpack_require_47019__("613b")('IE_PROTO');

module.exports = function (object, names) {
  var O = toIObject(object);
  var i = 0;
  var result = [];
  var key;
  for (key in O) if (key != IE_PROTO) has(O, key) && result.push(key);
  // Don't enum bug & hidden keys
  while (names.length > i) if (has(O, key = names[i++])) {
    ~arrayIndexOf(result, key) || result.push(key);
  }
  return result;
};


/***/ }),

/***/ "d2c8":
/***/ (function(module, exports, __nested_webpack_require_47655__) {

// helper for String#{startsWith, endsWith, includes}
var isRegExp = __nested_webpack_require_47655__("aae3");
var defined = __nested_webpack_require_47655__("be13");

module.exports = function (that, searchString, NAME) {
  if (isRegExp(searchString)) throw TypeError('String#' + NAME + " doesn't accept regex!");
  return String(defined(that));
};


/***/ }),

/***/ "d3f4":
/***/ (function(module, exports) {

module.exports = function (it) {
  return typeof it === 'object' ? it !== null : typeof it === 'function';
};


/***/ }),

/***/ "d53b":
/***/ (function(module, exports) {

module.exports = function (done, value) {
  return { value: value, done: !!done };
};


/***/ }),

/***/ "d8e8":
/***/ (function(module, exports) {

module.exports = function (it) {
  if (typeof it != 'function') throw TypeError(it + ' is not a function!');
  return it;
};


/***/ }),

/***/ "e11e":
/***/ (function(module, exports) {

// IE 8- don't enum bug keys
module.exports = (
  'constructor,hasOwnProperty,isPrototypeOf,propertyIsEnumerable,toLocaleString,toString,valueOf'
).split(',');


/***/ }),

/***/ "f559":
/***/ (function(module, exports, __nested_webpack_require_48796__) {

"use strict";
// 21.1.3.18 String.prototype.startsWith(searchString [, position ])

var $export = __nested_webpack_require_48796__("5ca1");
var toLength = __nested_webpack_require_48796__("9def");
var context = __nested_webpack_require_48796__("d2c8");
var STARTS_WITH = 'startsWith';
var $startsWith = ''[STARTS_WITH];

$export($export.P + $export.F * __nested_webpack_require_48796__("5147")(STARTS_WITH), 'String', {
  startsWith: function startsWith(searchString /* , position = 0 */) {
    var that = context(this, searchString, STARTS_WITH);
    var index = toLength(Math.min(arguments.length > 1 ? arguments[1] : undefined, that.length));
    var search = String(searchString);
    return $startsWith
      ? $startsWith.call(that, search, index)
      : that.slice(index, index + search.length) === search;
  }
});


/***/ }),

/***/ "f6fd":
/***/ (function(module, exports) {

// document.currentScript polyfill by Adam Miller

// MIT license

(function(document){
  var currentScript = "currentScript",
      scripts = document.getElementsByTagName('script'); // Live NodeList collection

  // If browser needs currentScript polyfill, add get currentScript() to the document object
  if (!(currentScript in document)) {
    Object.defineProperty(document, currentScript, {
      get: function(){

        // IE 6-10 supports script readyState
        // IE 10+ support stack trace
        try { throw new Error(); }
        catch (err) {

          // Find the second match for the "at" string to get file src url from stack.
          // Specifically works with the format of stack traces in IE.
          var i, res = ((/.*at [^\(]*\((.*):.+:.+\)$/ig).exec(err.stack) || [false])[1];

          // For all scripts on the page, if src matches or if ready state is interactive, return the script tag
          for(i in scripts){
            if(scripts[i].src == res || scripts[i].readyState == "interactive"){
              return scripts[i];
            }
          }

          // If no match, return null
          return null;
        }
      }
    });
  }
})(document);


/***/ }),

/***/ "f751":
/***/ (function(module, exports, __nested_webpack_require_50913__) {

// 19.1.3.1 Object.assign(target, source)
var $export = __nested_webpack_require_50913__("5ca1");

$export($export.S + $export.F, 'Object', { assign: __nested_webpack_require_50913__("7333") });


/***/ }),

/***/ "fa5b":
/***/ (function(module, exports, __nested_webpack_require_51166__) {

module.exports = __nested_webpack_require_51166__("5537")('native-function-to-string', Function.toString);


/***/ }),

/***/ "fab2":
/***/ (function(module, exports, __nested_webpack_require_51344__) {

var document = __nested_webpack_require_51344__("7726").document;
module.exports = document && document.documentElement;


/***/ }),

/***/ "fb15":
/***/ (function(module, __webpack_exports__, __nested_webpack_require_51548__) {

"use strict";
// ESM COMPAT FLAG
__nested_webpack_require_51548__.r(__webpack_exports__);

// CONCATENATED MODULE: ./node_modules/@vue/cli-service/lib/commands/build/setPublicPath.js
// This file is imported into lib/wc client bundles.

if (typeof window !== 'undefined') {
  if (true) {
    __nested_webpack_require_51548__("f6fd")
  }

  var setPublicPath_i
  if ((setPublicPath_i = window.document.currentScript) && (setPublicPath_i = setPublicPath_i.src.match(/(.+\/)[^/]+\.js(\?.*)?$/))) {
    __nested_webpack_require_51548__.p = setPublicPath_i[1] // eslint-disable-line
  }
}

// Indicate to webpack that this file can be concatenated
/* harmony default export */ var setPublicPath = (null);

// EXTERNAL MODULE: ./node_modules/core-js/modules/es6.object.assign.js
var es6_object_assign = __nested_webpack_require_51548__("f751");

// EXTERNAL MODULE: ./node_modules/core-js/modules/es6.string.starts-with.js
var es6_string_starts_with = __nested_webpack_require_51548__("f559");

// EXTERNAL MODULE: ./node_modules/core-js/modules/web.dom.iterable.js
var web_dom_iterable = __nested_webpack_require_51548__("ac6a");

// EXTERNAL MODULE: ./node_modules/core-js/modules/es6.array.iterator.js
var es6_array_iterator = __nested_webpack_require_51548__("cadf");

// EXTERNAL MODULE: ./node_modules/core-js/modules/es6.object.keys.js
var es6_object_keys = __nested_webpack_require_51548__("456d");

// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/arrayWithHoles.js
function _arrayWithHoles(arr) {
  if (Array.isArray(arr)) return arr;
}
// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/iterableToArrayLimit.js
function _iterableToArrayLimit(arr, i) {
  if (typeof Symbol === "undefined" || !(Symbol.iterator in Object(arr))) return;
  var _arr = [];
  var _n = true;
  var _d = false;
  var _e = undefined;

  try {
    for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) {
      _arr.push(_s.value);

      if (i && _arr.length === i) break;
    }
  } catch (err) {
    _d = true;
    _e = err;
  } finally {
    try {
      if (!_n && _i["return"] != null) _i["return"]();
    } finally {
      if (_d) throw _e;
    }
  }

  return _arr;
}
// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/arrayLikeToArray.js
function _arrayLikeToArray(arr, len) {
  if (len == null || len > arr.length) len = arr.length;

  for (var i = 0, arr2 = new Array(len); i < len; i++) {
    arr2[i] = arr[i];
  }

  return arr2;
}
// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/unsupportedIterableToArray.js

function _unsupportedIterableToArray(o, minLen) {
  if (!o) return;
  if (typeof o === "string") return _arrayLikeToArray(o, minLen);
  var n = Object.prototype.toString.call(o).slice(8, -1);
  if (n === "Object" && o.constructor) n = o.constructor.name;
  if (n === "Map" || n === "Set") return Array.from(o);
  if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen);
}
// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/nonIterableRest.js
function _nonIterableRest() {
  throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
}
// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/slicedToArray.js




function _slicedToArray(arr, i) {
  return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest();
}
// EXTERNAL MODULE: ./node_modules/core-js/modules/es7.array.includes.js
var es7_array_includes = __nested_webpack_require_51548__("6762");

// EXTERNAL MODULE: ./node_modules/core-js/modules/es6.string.includes.js
var es6_string_includes = __nested_webpack_require_51548__("2fdb");

// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/arrayWithoutHoles.js

function _arrayWithoutHoles(arr) {
  if (Array.isArray(arr)) return _arrayLikeToArray(arr);
}
// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/iterableToArray.js
function _iterableToArray(iter) {
  if (typeof Symbol !== "undefined" && Symbol.iterator in Object(iter)) return Array.from(iter);
}
// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/nonIterableSpread.js
function _nonIterableSpread() {
  throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
}
// CONCATENATED MODULE: ./node_modules/@babel/runtime/helpers/esm/toConsumableArray.js




function _toConsumableArray(arr) {
  return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread();
}
// EXTERNAL MODULE: external {"commonjs":"sortablejs","commonjs2":"sortablejs","amd":"sortablejs","root":"Sortable"}
var external_commonjs_sortablejs_commonjs2_sortablejs_amd_sortablejs_root_Sortable_ = __nested_webpack_require_51548__("a352");
var external_commonjs_sortablejs_commonjs2_sortablejs_amd_sortablejs_root_Sortable_default = /*#__PURE__*/__nested_webpack_require_51548__.n(external_commonjs_sortablejs_commonjs2_sortablejs_amd_sortablejs_root_Sortable_);

// EXTERNAL MODULE: ./src/util/helper.js
var helper = __nested_webpack_require_51548__("c649");

// CONCATENATED MODULE: ./src/vuedraggable.js












function buildAttribute(object, propName, value) {
  if (value === undefined) {
    return object;
  }

  object = object || {};
  object[propName] = value;
  return object;
}

function computeVmIndex(vnodes, element) {
  return vnodes.map(function (elt) {
    return elt.elm;
  }).indexOf(element);
}

function _computeIndexes(slots, children, isTransition, footerOffset) {
  if (!slots) {
    return [];
  }

  var elmFromNodes = slots.map(function (elt) {
    return elt.elm;
  });
  var footerIndex = children.length - footerOffset;

  var rawIndexes = _toConsumableArray(children).map(function (elt, idx) {
    return idx >= footerIndex ? elmFromNodes.length : elmFromNodes.indexOf(elt);
  });

  return isTransition ? rawIndexes.filter(function (ind) {
    return ind !== -1;
  }) : rawIndexes;
}

function emit(evtName, evtData) {
  var _this = this;

  this.$nextTick(function () {
    return _this.$emit(evtName.toLowerCase(), evtData);
  });
}

function delegateAndEmit(evtName) {
  var _this2 = this;

  return function (evtData) {
    if (_this2.realList !== null) {
      _this2["onDrag" + evtName](evtData);
    }

    emit.call(_this2, evtName, evtData);
  };
}

function isTransitionName(name) {
  return ["transition-group", "TransitionGroup"].includes(name);
}

function vuedraggable_isTransition(slots) {
  if (!slots || slots.length !== 1) {
    return false;
  }

  var _slots = _slicedToArray(slots, 1),
      componentOptions = _slots[0].componentOptions;

  if (!componentOptions) {
    return false;
  }

  return isTransitionName(componentOptions.tag);
}

function getSlot(slot, scopedSlot, key) {
  return slot[key] || (scopedSlot[key] ? scopedSlot[key]() : undefined);
}

function computeChildrenAndOffsets(children, slot, scopedSlot) {
  var headerOffset = 0;
  var footerOffset = 0;
  var header = getSlot(slot, scopedSlot, "header");

  if (header) {
    headerOffset = header.length;
    children = children ? [].concat(_toConsumableArray(header), _toConsumableArray(children)) : _toConsumableArray(header);
  }

  var footer = getSlot(slot, scopedSlot, "footer");

  if (footer) {
    footerOffset = footer.length;
    children = children ? [].concat(_toConsumableArray(children), _toConsumableArray(footer)) : _toConsumableArray(footer);
  }

  return {
    children: children,
    headerOffset: headerOffset,
    footerOffset: footerOffset
  };
}

function getComponentAttributes($attrs, componentData) {
  var attributes = null;

  var update = function update(name, value) {
    attributes = buildAttribute(attributes, name, value);
  };

  var attrs = Object.keys($attrs).filter(function (key) {
    return key === "id" || key.startsWith("data-");
  }).reduce(function (res, key) {
    res[key] = $attrs[key];
    return res;
  }, {});
  update("attrs", attrs);

  if (!componentData) {
    return attributes;
  }

  var on = componentData.on,
      props = componentData.props,
      componentDataAttrs = componentData.attrs;
  update("on", on);
  update("props", props);
  Object.assign(attributes.attrs, componentDataAttrs);
  return attributes;
}

var eventsListened = ["Start", "Add", "Remove", "Update", "End"];
var eventsToEmit = ["Choose", "Unchoose", "Sort", "Filter", "Clone"];
var readonlyProperties = ["Move"].concat(eventsListened, eventsToEmit).map(function (evt) {
  return "on" + evt;
});
var draggingElement = null;
var props = {
  options: Object,
  list: {
    type: Array,
    required: false,
    default: null
  },
  value: {
    type: Array,
    required: false,
    default: null
  },
  noTransitionOnDrag: {
    type: Boolean,
    default: false
  },
  clone: {
    type: Function,
    default: function _default(original) {
      return original;
    }
  },
  element: {
    type: String,
    default: "div"
  },
  tag: {
    type: String,
    default: null
  },
  move: {
    type: Function,
    default: null
  },
  componentData: {
    type: Object,
    required: false,
    default: null
  }
};
var draggableComponent = {
  name: "draggable",
  inheritAttrs: false,
  props: props,
  data: function data() {
    return {
      transitionMode: false,
      noneFunctionalComponentMode: false
    };
  },
  render: function render(h) {
    var slots = this.$slots.default;
    this.transitionMode = vuedraggable_isTransition(slots);

    var _computeChildrenAndOf = computeChildrenAndOffsets(slots, this.$slots, this.$scopedSlots),
        children = _computeChildrenAndOf.children,
        headerOffset = _computeChildrenAndOf.headerOffset,
        footerOffset = _computeChildrenAndOf.footerOffset;

    this.headerOffset = headerOffset;
    this.footerOffset = footerOffset;
    var attributes = getComponentAttributes(this.$attrs, this.componentData);
    return h(this.getTag(), attributes, children);
  },
  created: function created() {
    if (this.list !== null && this.value !== null) {
      helper["b" /* console */].error("Value and list props are mutually exclusive! Please set one or another.");
    }

    if (this.element !== "div") {
      helper["b" /* console */].warn("Element props is deprecated please use tag props instead. See https://github.com/SortableJS/Vue.Draggable/blob/master/documentation/migrate.md#element-props");
    }

    if (this.options !== undefined) {
      helper["b" /* console */].warn("Options props is deprecated, add sortable options directly as vue.draggable item, or use v-bind. See https://github.com/SortableJS/Vue.Draggable/blob/master/documentation/migrate.md#options-props");
    }
  },
  mounted: function mounted() {
    var _this3 = this;

    this.noneFunctionalComponentMode = this.getTag().toLowerCase() !== this.$el.nodeName.toLowerCase() && !this.getIsFunctional();

    if (this.noneFunctionalComponentMode && this.transitionMode) {
      throw new Error("Transition-group inside component is not supported. Please alter tag value or remove transition-group. Current tag value: ".concat(this.getTag()));
    }

    var optionsAdded = {};
    eventsListened.forEach(function (elt) {
      optionsAdded["on" + elt] = delegateAndEmit.call(_this3, elt);
    });
    eventsToEmit.forEach(function (elt) {
      optionsAdded["on" + elt] = emit.bind(_this3, elt);
    });
    var attributes = Object.keys(this.$attrs).reduce(function (res, key) {
      res[Object(helper["a" /* camelize */])(key)] = _this3.$attrs[key];
      return res;
    }, {});
    var options = Object.assign({}, this.options, attributes, optionsAdded, {
      onMove: function onMove(evt, originalEvent) {
        return _this3.onDragMove(evt, originalEvent);
      }
    });
    !("draggable" in options) && (options.draggable = ">*");
    this._sortable = new external_commonjs_sortablejs_commonjs2_sortablejs_amd_sortablejs_root_Sortable_default.a(this.rootContainer, options);
    this.computeIndexes();
  },
  beforeDestroy: function beforeDestroy() {
    if (this._sortable !== undefined) this._sortable.destroy();
  },
  computed: {
    rootContainer: function rootContainer() {
      return this.transitionMode ? this.$el.children[0] : this.$el;
    },
    realList: function realList() {
      return this.list ? this.list : this.value;
    }
  },
  watch: {
    options: {
      handler: function handler(newOptionValue) {
        this.updateOptions(newOptionValue);
      },
      deep: true
    },
    $attrs: {
      handler: function handler(newOptionValue) {
        this.updateOptions(newOptionValue);
      },
      deep: true
    },
    realList: function realList() {
      this.computeIndexes();
    }
  },
  methods: {
    getIsFunctional: function getIsFunctional() {
      var fnOptions = this._vnode.fnOptions;
      return fnOptions && fnOptions.functional;
    },
    getTag: function getTag() {
      return this.tag || this.element;
    },
    updateOptions: function updateOptions(newOptionValue) {
      for (var property in newOptionValue) {
        var value = Object(helper["a" /* camelize */])(property);

        if (readonlyProperties.indexOf(value) === -1) {
          this._sortable.option(value, newOptionValue[property]);
        }
      }
    },
    getChildrenNodes: function getChildrenNodes() {
      if (this.noneFunctionalComponentMode) {
        return this.$children[0].$slots.default;
      }

      var rawNodes = this.$slots.default;
      return this.transitionMode ? rawNodes[0].child.$slots.default : rawNodes;
    },
    computeIndexes: function computeIndexes() {
      var _this4 = this;

      this.$nextTick(function () {
        _this4.visibleIndexes = _computeIndexes(_this4.getChildrenNodes(), _this4.rootContainer.children, _this4.transitionMode, _this4.footerOffset);
      });
    },
    getUnderlyingVm: function getUnderlyingVm(htmlElt) {
      var index = computeVmIndex(this.getChildrenNodes() || [], htmlElt);

      if (index === -1) {
        //Edge case during move callback: related element might be
        //an element different from collection
        return null;
      }

      var element = this.realList[index];
      return {
        index: index,
        element: element
      };
    },
    getUnderlyingPotencialDraggableComponent: function getUnderlyingPotencialDraggableComponent(_ref) {
      var vue = _ref.__vue__;

      if (!vue || !vue.$options || !isTransitionName(vue.$options._componentTag)) {
        if (!("realList" in vue) && vue.$children.length === 1 && "realList" in vue.$children[0]) return vue.$children[0];
        return vue;
      }

      return vue.$parent;
    },
    emitChanges: function emitChanges(evt) {
      var _this5 = this;

      this.$nextTick(function () {
        _this5.$emit("change", evt);
      });
    },
    alterList: function alterList(onList) {
      if (this.list) {
        onList(this.list);
        return;
      }

      var newList = _toConsumableArray(this.value);

      onList(newList);
      this.$emit("input", newList);
    },
    spliceList: function spliceList() {
      var _arguments = arguments;

      var spliceList = function spliceList(list) {
        return list.splice.apply(list, _toConsumableArray(_arguments));
      };

      this.alterList(spliceList);
    },
    updatePosition: function updatePosition(oldIndex, newIndex) {
      var updatePosition = function updatePosition(list) {
        return list.splice(newIndex, 0, list.splice(oldIndex, 1)[0]);
      };

      this.alterList(updatePosition);
    },
    getRelatedContextFromMoveEvent: function getRelatedContextFromMoveEvent(_ref2) {
      var to = _ref2.to,
          related = _ref2.related;
      var component = this.getUnderlyingPotencialDraggableComponent(to);

      if (!component) {
        return {
          component: component
        };
      }

      var list = component.realList;
      var context = {
        list: list,
        component: component
      };

      if (to !== related && list && component.getUnderlyingVm) {
        var destination = component.getUnderlyingVm(related);

        if (destination) {
          return Object.assign(destination, context);
        }
      }

      return context;
    },
    getVmIndex: function getVmIndex(domIndex) {
      var indexes = this.visibleIndexes;
      var numberIndexes = indexes.length;
      return domIndex > numberIndexes - 1 ? numberIndexes : indexes[domIndex];
    },
    getComponent: function getComponent() {
      return this.$slots.default[0].componentInstance;
    },
    resetTransitionData: function resetTransitionData(index) {
      if (!this.noTransitionOnDrag || !this.transitionMode) {
        return;
      }

      var nodes = this.getChildrenNodes();
      nodes[index].data = null;
      var transitionContainer = this.getComponent();
      transitionContainer.children = [];
      transitionContainer.kept = undefined;
    },
    onDragStart: function onDragStart(evt) {
      this.context = this.getUnderlyingVm(evt.item);
      evt.item._underlying_vm_ = this.clone(this.context.element);
      draggingElement = evt.item;
    },
    onDragAdd: function onDragAdd(evt) {
      var element = evt.item._underlying_vm_;

      if (element === undefined) {
        return;
      }

      Object(helper["d" /* removeNode */])(evt.item);
      var newIndex = this.getVmIndex(evt.newIndex);
      this.spliceList(newIndex, 0, element);
      this.computeIndexes();
      var added = {
        element: element,
        newIndex: newIndex
      };
      this.emitChanges({
        added: added
      });
    },
    onDragRemove: function onDragRemove(evt) {
      Object(helper["c" /* insertNodeAt */])(this.rootContainer, evt.item, evt.oldIndex);

      if (evt.pullMode === "clone") {
        Object(helper["d" /* removeNode */])(evt.clone);
        return;
      }

      var oldIndex = this.context.index;
      this.spliceList(oldIndex, 1);
      var removed = {
        element: this.context.element,
        oldIndex: oldIndex
      };
      this.resetTransitionData(oldIndex);
      this.emitChanges({
        removed: removed
      });
    },
    onDragUpdate: function onDragUpdate(evt) {
      Object(helper["d" /* removeNode */])(evt.item);
      Object(helper["c" /* insertNodeAt */])(evt.from, evt.item, evt.oldIndex);
      var oldIndex = this.context.index;
      var newIndex = this.getVmIndex(evt.newIndex);
      this.updatePosition(oldIndex, newIndex);
      var moved = {
        element: this.context.element,
        oldIndex: oldIndex,
        newIndex: newIndex
      };
      this.emitChanges({
        moved: moved
      });
    },
    updateProperty: function updateProperty(evt, propertyName) {
      evt.hasOwnProperty(propertyName) && (evt[propertyName] += this.headerOffset);
    },
    computeFutureIndex: function computeFutureIndex(relatedContext, evt) {
      if (!relatedContext.element) {
        return 0;
      }

      var domChildren = _toConsumableArray(evt.to.children).filter(function (el) {
        return el.style["display"] !== "none";
      });

      var currentDOMIndex = domChildren.indexOf(evt.related);
      var currentIndex = relatedContext.component.getVmIndex(currentDOMIndex);
      var draggedInList = domChildren.indexOf(draggingElement) !== -1;
      return draggedInList || !evt.willInsertAfter ? currentIndex : currentIndex + 1;
    },
    onDragMove: function onDragMove(evt, originalEvent) {
      var onMove = this.move;

      if (!onMove || !this.realList) {
        return true;
      }

      var relatedContext = this.getRelatedContextFromMoveEvent(evt);
      var draggedContext = this.context;
      var futureIndex = this.computeFutureIndex(relatedContext, evt);
      Object.assign(draggedContext, {
        futureIndex: futureIndex
      });
      var sendEvt = Object.assign({}, evt, {
        relatedContext: relatedContext,
        draggedContext: draggedContext
      });
      return onMove(sendEvt, originalEvent);
    },
    onDragEnd: function onDragEnd() {
      this.computeIndexes();
      draggingElement = null;
    }
  }
};

if (typeof window !== "undefined" && "Vue" in window) {
  window.Vue.component("draggable", draggableComponent);
}

/* harmony default export */ var vuedraggable = (draggableComponent);
// CONCATENATED MODULE: ./node_modules/@vue/cli-service/lib/commands/build/entry-lib.js


/* harmony default export */ var entry_lib = __webpack_exports__["default"] = (vuedraggable);



/***/ })

/******/ })["default"];
});
//# sourceMappingURL=vuedraggable.umd.js.map

/***/ })

}]);