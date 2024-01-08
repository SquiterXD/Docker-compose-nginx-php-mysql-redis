(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_Planning_OverTimes-Plan_PlanComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/ModalReportOT.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/ModalReportOT.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var uuid_v1__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! uuid/v1 */ "./node_modules/uuid/v1.js");
/* harmony import */ var uuid_v1__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(uuid_v1__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _Report_InputBudget_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./Report/InputBudget.vue */ "./resources/js/components/Planning/OverTimes-Plan/Report/InputBudget.vue");
/* harmony import */ var _Report_InputBudgetBiWeekly_vue__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./Report/InputBudgetBiWeekly.vue */ "./resources/js/components/Planning/OverTimes-Plan/Report/InputBudgetBiWeekly.vue");


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




/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    inputBudget: _Report_InputBudget_vue__WEBPACK_IMPORTED_MODULE_3__.default,
    inputBudgetBiWeekly: _Report_InputBudgetBiWeekly_vue__WEBPACK_IMPORTED_MODULE_4__.default
  },
  props: ['departments', 'search', 'btnTrans', 'url', 'selDepartment'],
  data: function data() {
    return {
      loading: false,
      budgetBiWeekly: {}
    };
  },
  mounted: function mounted() {//
  },
  methods: {
    openModal: function openModal() {
      $('#modal-ot-report').modal('show');
    },
    submit: function submit() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var vm, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                vm = _this;
                vm.loading = true;
                params = {
                  budgetBiWeekly: vm.budgetBiWeekly
                };
                _context.next = 5;
                return axios.post(vm.url.ajax_submit_budget_ot_plan, params).then(function (res) {
                  if (res.data.status == 'S') {
                    //redirect
                    var url_export = vm.url.ajax_report_ot_plan + '?department=' + vm.selDepartment;
                    window.open(url_export, '_blank');
                  } else {
                    swal({
                      title: 'มีข้อผิดพลาด',
                      text: '<span style="font-size: 16px; text-align: left;">' + res.data.msg + '</span>',
                      type: "error",
                      html: true
                    });
                  }
                })["catch"](function (err) {
                  var msg = err.response.data.data;
                  swal({
                    title: 'มีข้อผิดพลาด',
                    text: '<span style="font-size: 16px; text-align: left;">' + msg + '</span>',
                    type: "error",
                    html: true
                  });
                }).then(function () {
                  vm.loading = false;
                });

              case 5:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/OTPercentComponent.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/OTPercentComponent.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-numeric */ "./node_modules/vue-numeric/dist/vue-numeric.min.js");
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_numeric__WEBPACK_IMPORTED_MODULE_0__);
//
//
//
//
//
//
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
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_0___default())
  },
  props: ['plan', 'time', 'otPercent', 'value', 'pOtPercentEdit', 'canEdit'],
  data: function data() {
    return {
      percent: this.value,
      otPercentEdit: this.pOtPercentEdit,
      oldPercent: this.value
    };
  },
  mounted: function mounted() {},
  methods: {
    changeOTPercent: function changeOTPercent() {
      var vm = this;
      vm.oldPercent = vm.value;
      vm.otPercent[vm.time][vm.plan.ot_plan_id] = vm.percent; // Stamp ที่มีการแก้ไข OT Percent

      Vue.set(vm.otPercentEdit, vm.time + '|' + vm.plan.department_code + '|' + vm.plan.employee_type, vm.percent);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/OTPlanComponent.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/OTPlanComponent.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var uuid_v1__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! uuid/v1 */ "./node_modules/uuid/v1.js");
/* harmony import */ var uuid_v1__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(uuid_v1__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! vue-numeric */ "./node_modules/vue-numeric/dist/vue-numeric.min.js");
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(vue_numeric__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _WorkingHourComponent_vue__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./WorkingHourComponent.vue */ "./resources/js/components/Planning/OverTimes-Plan/WorkingHourComponent.vue");
/* harmony import */ var _OTPercentComponent_vue__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./OTPercentComponent.vue */ "./resources/js/components/Planning/OverTimes-Plan/OTPercentComponent.vue");


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





/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    workingHour: _WorkingHourComponent_vue__WEBPACK_IMPORTED_MODULE_4__.default,
    otPercent: _OTPercentComponent_vue__WEBPACK_IMPORTED_MODULE_5__.default,
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_3___default())
  },
  props: ['departments', 'url', 'workingHoliday', 'btnTrans', 'dateArr', 'defaultInput', 'search', 'otMain', 'colorCode'],
  data: function data() {
    return {
      otPlans: [],
      otPlanBiWeekly: [],
      otPercent: [],
      hourlyWage: [],
      hourIncrease: [],
      defaultRate: [],
      otAmount: [],
      otTimeDesc: [],
      department: this.defaultInput.department,
      workingHourEdit: {},
      otPercentEdit: {},
      valid_action: false,
      canEdit: false,
      loadingOTPlan: '',
      loadingOTPlanBiWeekly: '',
      checkDate: {
        current_date: '',
        start_date: '',
        end_date: ''
      },
      isNotDisableControl: false,
      summary: [],
      summaryAll: []
    };
  },
  mounted: function mounted() {
    if (Object.values(this.search).length > 0 && this.otMain) {
      this.getOTPlan();
      this.getDateByBiWeekly();
    }
  },
  computed: {//
  },
  watch: {//
  },
  methods: {
    getOTPlan: function getOTPlan() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var vm, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                vm = _this;
                vm.$emit("department", vm.department);

                if (!vm.valid_action) {
                  _context.next = 5;
                  break;
                }

                swal({
                  title: 'เปลี่ยนแปลงข้อมูลชั่วโมงการทำงาน',
                  text: '<span style="font-size: 16px; text-align: left;"> กรุณาทำการบันทึกหรือยกเลิกการเปลี่ยนแปลงให้เรียบร้อย </span>',
                  type: "warning",
                  html: true
                });
                return _context.abrupt("return");

              case 5:
                vm.otPlans = [];
                vm.loadingOTPlan = '\ <div class="m-t-lg m-b-lg">\
                            <div class="text-center sk-spinner sk-spinner-wave">\
                                <div class="sk-rect1"></div>\
                                <div class="sk-rect2"></div>\
                                <div class="sk-rect3"></div>\
                                <div class="sk-rect4"></div>\
                                <div class="sk-rect5"></div>\
                            </div>\
                        </div>';
                params = {
                  department: vm.department
                };
                _context.next = 10;
                return axios.post(vm.url.ajax_get_ot_plan, {
                  params: params
                }).then(function (res) {
                  console.log(res.data);

                  if (res.data.status == 'S') {
                    vm.otPlans = res.data.otPlans;
                    vm.otPlanBiWeekly = res.data.otPlanBiWeekly;
                    vm.otPercent = res.data.otPercent;
                    vm.hourlyWage = res.data.hourlyWage;
                    vm.hourIncrease = res.data.hourIncrease;
                    vm.defaultRate = res.data.defaultRate;
                    vm.otAmount = res.data.otAmount;
                    vm.otTimeDesc = res.data.otTimeDesc;
                    vm.summary = res.data.summary;
                    vm.summaryAll = res.data.summaryAll;
                    vm.otPercentEdit = {};
                    vm.workingHourEdit = {};
                    vm.valid_action = false;
                  }
                })["catch"](function (err) {
                  swal({
                    title: 'มีข้อผิดพลาด',
                    text: '<span style="font-size: 16px; text-align: left;">' + err.message + '</span>',
                    type: "warning",
                    html: true
                  });
                }).then(function () {
                  vm.loadingOTPlan = '';
                });

              case 10:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    updateOTPlan: function updateOTPlan() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var vm, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                vm = _this2;

                if (!(Object.values(vm.workingHourEdit).length <= 0)) {
                  _context2.next = 4;
                  break;
                }

                swal({
                  title: 'เปลี่ยนแปลงข้อมูลชั่วโมงการทำงาน',
                  text: '<span style="font-size: 16px; text-align: left;"> ไม่มีการเปลี่ยนแปลงข้อมูลชั่วโมงการทำงาน </span>',
                  type: "warning",
                  html: true
                });
                return _context2.abrupt("return");

              case 4:
                vm.canEdit = false;
                vm.otPlanBiWeekly = [];
                vm.otPercent = [];
                vm.hourlyWage = [];
                vm.hourIncrease = [];
                vm.defaultRate = [];
                vm.otAmount = [];
                vm.otTimeDesc = []; // = vm.loadingOTPlanBiWeekly

                vm.loadingOTPlan = '\ <div class="m-t-lg m-b-lg">\
                            <div class="text-center sk-spinner sk-spinner-wave">\
                                <div class="sk-rect1"></div>\
                                <div class="sk-rect2"></div>\
                                <div class="sk-rect3"></div>\
                                <div class="sk-rect4"></div>\
                                <div class="sk-rect5"></div>\
                            </div>\
                        </div>';
                params = {
                  department: vm.department,
                  workingHour: vm.workingHourEdit
                };
                _context2.next = 16;
                return axios.post(vm.url.ajax_update_ot_plan, {
                  params: params
                }).then(function (res) {
                  console.log(res.data);

                  if (res.data.status == 'S') {
                    vm.otPlanBiWeekly = res.data.otPlanBiWeekly;
                    vm.otPercent = res.data.otPercent;
                    vm.hourlyWage = res.data.hourlyWage;
                    vm.hourIncrease = res.data.hourIncrease;
                    vm.defaultRate = res.data.defaultRate;
                    vm.otAmount = res.data.otAmount;
                    vm.otTimeDesc = res.data.otTimeDesc;
                    vm.summary = res.data.summary;
                    vm.summaryAll = res.data.summaryAll;
                    vm.workingHourEdit = {};
                    vm.valid_action = false;
                  } else {
                    swal({
                      title: 'มีข้อผิดพลาด',
                      text: '<span style="font-size: 16px; text-align: left;">' + res.data.msg + '</span>',
                      type: "warning",
                      html: true
                    });
                  }
                })["catch"](function (err) {
                  swal({
                    title: 'มีข้อผิดพลาด',
                    text: '<span style="font-size: 16px; text-align: left;">' + err.message + '</span>',
                    type: "warning",
                    html: true
                  });
                }).then(function () {
                  vm.loadingOTPlan = ''; // vm.loadingOTPlanBiWeekly = '';
                });

              case 16:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    updateOTPercent: function updateOTPercent() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var vm, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                vm = _this3;

                if (!(Object.values(vm.otPercentEdit).length <= 0)) {
                  _context3.next = 4;
                  break;
                }

                swal({
                  title: 'เปลี่ยนแปลงข้อมูล OT Percent',
                  text: '<span style="font-size: 16px; text-align: left;"> ไม่มีการเปลี่ยนแปลงข้อมูล OT Percent </span>',
                  type: "warning",
                  html: true
                });
                return _context3.abrupt("return");

              case 4:
                vm.otPlanBiWeekly = [];
                vm.otPercent = [];
                vm.hourlyWage = [];
                vm.hourIncrease = [];
                vm.defaultRate = [];
                vm.otAmount = [];
                vm.otTimeDesc = [];
                vm.loadingOTPlanBiWeekly = '\ <div class="m-t-lg m-b-lg">\
                            <div class="text-center sk-spinner sk-spinner-wave">\
                                <div class="sk-rect1"></div>\
                                <div class="sk-rect2"></div>\
                                <div class="sk-rect3"></div>\
                                <div class="sk-rect4"></div>\
                                <div class="sk-rect5"></div>\
                            </div>\
                        </div>';
                params = {
                  department: vm.department,
                  otPercent: vm.otPercentEdit
                };
                _context3.next = 15;
                return axios.post(vm.url.ajax_update_ot_percent, {
                  params: params
                }).then(function (res) {
                  console.log(res.data);

                  if (res.data.status == 'S') {
                    vm.otPlanBiWeekly = res.data.otPlanBiWeekly;
                    vm.otPercent = res.data.otPercent;
                    vm.hourlyWage = res.data.hourlyWage;
                    vm.hourIncrease = res.data.hourIncrease;
                    vm.defaultRate = res.data.defaultRate;
                    vm.otAmount = res.data.otAmount;
                    vm.otTimeDesc = res.data.otTimeDesc;
                    vm.summary = res.data.summary;
                    vm.summaryAll = res.data.summaryAll;
                    vm.otPercentEdit = {};
                    vm.valid_action = false;
                  } else {
                    swal({
                      title: 'มีข้อผิดพลาด',
                      text: '<span style="font-size: 16px; text-align: left;">' + res.data.msg + '</span>',
                      type: "warning",
                      html: true
                    });
                  }
                })["catch"](function (err) {
                  swal({
                    title: 'มีข้อผิดพลาด',
                    text: '<span style="font-size: 16px; text-align: left;">' + err.message + '</span>',
                    type: "warning",
                    html: true
                  });
                }).then(function () {
                  vm.loadingOTPlanBiWeekly = '';
                });

              case 15:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    editWorkingHour: function editWorkingHour(flag) {
      var vm = this;
      vm.valid_action = flag;
      vm.canEdit = flag;
    },
    getDateByBiWeekly: function getDateByBiWeekly() {
      var vm = this;
      var date_from = vm.otMain.pp_bi_weekly.start_date;
      var date_to = vm.otMain.pp_bi_weekly.end_date;
      var curr_date = moment__WEBPACK_IMPORTED_MODULE_1___default()().format('YYYY-MM-DD'); // วันที่ที่ใช้ในการเช็คเงื่อนไข

      vm.checkDate.current_date = curr_date;
      vm.checkDate.start_date = moment__WEBPACK_IMPORTED_MODULE_1___default()(date_from).format('YYYY-MM-DD');
      vm.checkDate.end_date = moment__WEBPACK_IMPORTED_MODULE_1___default()(date_to).format('YYYY-MM-DD'); // check current biweekly

      if (vm.checkDate.current_date > vm.checkDate.start_date && vm.checkDate.current_date > vm.checkDate.end_date) {
        vm.isNotDisableControl = true;
      }
    },
    getDepartment: function getDepartment(dept) {
      var vm = this;
      var val = '';
      vm.departments.filter(function (value) {
        if (dept == value.department_code) {
          val = value.department_name;
        }
      });
      return val;
    },
    getDepartmentGroup: function getDepartmentGroup(dept) {
      var split_dept = dept.split('  ');
      var result = split_dept[1] == '' ? dept : split_dept[1];
      return result;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/PlanComponent.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/PlanComponent.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _OTPlanComponent_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./OTPlanComponent.vue */ "./resources/js/components/Planning/OverTimes-Plan/OTPlanComponent.vue");
/* harmony import */ var _ModalReportOT_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ModalReportOT.vue */ "./resources/js/components/Planning/OverTimes-Plan/ModalReportOT.vue");


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


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    otPlan: _OTPlanComponent_vue__WEBPACK_IMPORTED_MODULE_1__.default,
    modalReportOt: _ModalReportOT_vue__WEBPACK_IMPORTED_MODULE_2__.default
  },
  props: ['search', 'otMain', 'workingHour', 'workingHoliday', 'productTypes', 'defaultInput', 'searchInput', 'budgetYears', 'biWeeklyDetails', 'dateFormat', 'btnTrans', 'url', 'departments', 'dateArr', 'colorCode', 'deptReports'],
  data: function data() {
    return {
      budget_year: Object.values(this.search).length > 0 ? String(this.search['budget_year']) : this.defaultInput.current_year,
      month: Object.values(this.search).length > 0 ? String(this.search['month']) : '',
      bi_weekly: Object.values(this.search).length > 0 ? String(this.search['bi_weekly']) : '',
      month_lists: [],
      bi_weekly_lists: [],
      bi_weekly_detail: '',
      loading: false,
      valid: false,
      m_loading: false,
      b_loading: false,
      errors: {
        budget_year: false,
        month: false,
        bi_weekly: false
      },
      set_budget_year: Object.values(this.search).length > 0 ? String(this.search['budget_year']) : this.defaultInput.current_year,
      set_month: Object.values(this.search).length > 0 ? String(this.search['month']) : '',
      set_bi_weekly: Object.values(this.search).length > 0 ? String(this.search['bi_weekly']) : '',
      sel_department: ''
    };
  },
  mounted: function mounted() {
    if (this.budget_year) {
      this.getMonth();
    }

    if (this.budget_year && this.month && this.bi_weekly) {
      this.getMonth();
      this.getBiWeeklySeq();
    }

    this.getBiWeeklyDetail();
  },
  computed: {
    monthLists: function monthLists() {
      return this.month_lists;
    },
    biWeeklyLists: function biWeeklyLists() {
      return this.bi_weekly_lists;
    }
  },
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
    getMonth: function getMonth() {
      var vm = this;

      if (vm.search) {
        if (vm.set_budget_year != vm.budget_year) {
          vm.month = '';
          vm.bi_weekly = '';
          vm.bi_weekly_detail = '';
        }
      } else {
        vm.month = '';
        vm.bi_weekly = '';
        vm.bi_weekly_detail = '';
      }

      vm.month_lists = vm.searchInput.months;
    },
    getBiWeeklySeq: function getBiWeeklySeq() {
      var vm = this;

      if (vm.search) {
        if (vm.set_month != vm.month || vm.set_bi_weekly != vm.bi_weekly) {
          vm.bi_weekly = '';
          vm.bi_weekly_detail = '';
        }
      } else {
        vm.bi_weekly = '';
        vm.bi_weekly_detail = '';
      }

      vm.bi_weekly_lists = vm.searchInput.bi_weekly.filter(function (item) {
        return item.period_num == vm.month;
      });
    },
    getBiWeeklyDetail: function getBiWeeklyDetail() {
      var vm = this;

      if (vm.biWeekly == '' || vm.biWeekly == null) {
        vm.biWeeklyDetail = '';
      }

      vm.biWeeklyDetails.filter(function (item) {
        if (item.thai_year == vm.budget_year && item.period_num == vm.month && item.biweekly == vm.bi_weekly) {
          return vm.bi_weekly_detail = item.thai_combine_date;
        }
      });
    },
    submit: function submit() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var form, inputs, valid, errorMsg;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                form = $('#overtimes-form');
                inputs = form.serialize();
                valid = true;
                errorMsg = '';
                _this.errors.budget_year = false;
                _this.errors.month = false;
                _this.errors.bi_weekly = false;
                $(form).find("div[id='el_explode_budget_year']").html("");
                $(form).find("div[id='el_explode_month']").html("");
                $(form).find("div[id='el_explode_bi_weekly']").html("");

                if (_this.budget_year == '') {
                  _this.errors.budget_year = true;
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

                if (_this.bi_weekly == '') {
                  _this.errors.bi_weekly = true;
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
                _this.loading = true;
                form.submit();

              case 17:
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
    selDepartment: function selDepartment(res) {
      this.sel_department = res;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/Report/InputBudget.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/Report/InputBudget.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-numeric */ "./node_modules/vue-numeric/dist/vue-numeric.min.js");
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_numeric__WEBPACK_IMPORTED_MODULE_0__);
//
//
//
//
//
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
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_0___default())
  },
  props: ['department', 'pBudgetBiWeekly'],
  data: function data() {
    return {
      amount: 0,
      budgetBiWeekly: this.pBudgetBiWeekly
    };
  },
  mounted: function mounted() {
    this.changeInputAmount();
  },
  methods: {
    changeInputAmount: function changeInputAmount() {
      var vm = this; // Stamp ที่มีการระบุ amount

      Vue.set(vm.budgetBiWeekly, vm.department.department_code + '|' + vm.department.employee_type + '|budget', vm.amount);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/Report/InputBudgetBiWeekly.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/Report/InputBudgetBiWeekly.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-numeric */ "./node_modules/vue-numeric/dist/vue-numeric.min.js");
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_numeric__WEBPACK_IMPORTED_MODULE_0__);
//
//
//
//
//
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
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_0___default())
  },
  props: ['department', 'pBudgetBiWeekly'],
  data: function data() {
    return {
      amount: 0,
      budgetBiWeekly: this.pBudgetBiWeekly
    };
  },
  mounted: function mounted() {
    this.changeInputAmount();
  },
  methods: {
    changeInputAmount: function changeInputAmount() {
      var vm = this; // Stamp ที่มีการระบุ amount

      Vue.set(vm.budgetBiWeekly, vm.department.department_code + '|' + vm.department.employee_type + '|biweekly', vm.amount);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/WorkingHourComponent.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/WorkingHourComponent.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_0__);
//
//
//
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
  props: ['plan', 'workingHoliday', 'pWorkingHourEdit', 'canEdit'],
  data: function data() {
    return {
      hour: this.plan.working_hour,
      workingHour: [],
      workingHourEdit: this.pWorkingHourEdit,
      oldWkh: this.plan.working_hour
    };
  },
  mounted: function mounted() {},
  methods: {
    changeHour: function changeHour() {
      var vm = this;
      console.log(vm.plan.working_hour);
      vm.oldWkh = vm.plan.working_hour;
      vm.plan.working_hour = vm.hour; // Stamp ที่มีการแก้ไข working hour

      Vue.set(vm.workingHourEdit, vm.plan.biweekly_id + '|' + vm.plan.division_code + '|' + vm.plan.working_date, Number(vm.hour));
    }
  },
  computed: {
    orderedWorkingHour: function orderedWorkingHour() {
      return _.orderBy(this.workingHoliday, ['attribute1']);
    }
  },
  watch: {
    'canEdit': function canEdit(newValue) {
      if (newValue == false) {
        this.plan.working_hour = this.oldWkh;
        this.hour = this.oldWkh;
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/OTPlanComponent.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/OTPlanComponent.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, ".sticky-col {\n  position: -webkit-sticky;\n  position: sticky;\n  background-color: #f7f7f7;\n  z-index: 9999;\n}\n.first-col {\n  width: 150px;\n  min-width: 100px;\n  max-width: 150px;\n  left: 0px;\n}\n.second-col {\n  width: 150px;\n  min-width: 150px;\n  max-width: 150px;\n  left: 116px;\n  /*left: 150px;*/\n}\n.th-col {\n  width: 250px;\n  min-width: 150px;\n  max-width: 250px;\n  left: 266px;\n  /*left: 250px;*/\n}\n.fo-col {\n  width: 200px;\n  min-width: 150px;\n  max-width: 200px;\n  left: 416px;\n  /*left: 400px;*/\n}\n.fi-col {\n  width: 200px;\n  min-width: 150px;\n  max-width: 200px;\n  left: 566px;\n  /*left: 550px;*/\n}\n.t1-col {\n  width: 200px;\n  min-width: 150px;\n  max-width: 200px;\n  left: 0px;\n}\n.t2-col {\n  width: 200px;\n  min-width: 150px;\n  max-width: 200px;\n  left: 566px;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/OTPlanComponent.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/OTPlanComponent.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_OTPlanComponent_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./OTPlanComponent.vue?vue&type=style&index=0&scope=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/OTPlanComponent.vue?vue&type=style&index=0&scope=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_OTPlanComponent_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_OTPlanComponent_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/components/Planning/OverTimes-Plan/ModalReportOT.vue":
/*!***************************************************************************!*\
  !*** ./resources/js/components/Planning/OverTimes-Plan/ModalReportOT.vue ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ModalReportOT_vue_vue_type_template_id_1eaeae12___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ModalReportOT.vue?vue&type=template&id=1eaeae12& */ "./resources/js/components/Planning/OverTimes-Plan/ModalReportOT.vue?vue&type=template&id=1eaeae12&");
/* harmony import */ var _ModalReportOT_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalReportOT.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/OverTimes-Plan/ModalReportOT.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _ModalReportOT_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ModalReportOT_vue_vue_type_template_id_1eaeae12___WEBPACK_IMPORTED_MODULE_0__.render,
  _ModalReportOT_vue_vue_type_template_id_1eaeae12___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/OverTimes-Plan/ModalReportOT.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/OverTimes-Plan/OTPercentComponent.vue":
/*!********************************************************************************!*\
  !*** ./resources/js/components/Planning/OverTimes-Plan/OTPercentComponent.vue ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _OTPercentComponent_vue_vue_type_template_id_594887be___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./OTPercentComponent.vue?vue&type=template&id=594887be& */ "./resources/js/components/Planning/OverTimes-Plan/OTPercentComponent.vue?vue&type=template&id=594887be&");
/* harmony import */ var _OTPercentComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./OTPercentComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/OverTimes-Plan/OTPercentComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _OTPercentComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _OTPercentComponent_vue_vue_type_template_id_594887be___WEBPACK_IMPORTED_MODULE_0__.render,
  _OTPercentComponent_vue_vue_type_template_id_594887be___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/OverTimes-Plan/OTPercentComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/OverTimes-Plan/OTPlanComponent.vue":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/Planning/OverTimes-Plan/OTPlanComponent.vue ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _OTPlanComponent_vue_vue_type_template_id_213e72bb___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./OTPlanComponent.vue?vue&type=template&id=213e72bb& */ "./resources/js/components/Planning/OverTimes-Plan/OTPlanComponent.vue?vue&type=template&id=213e72bb&");
/* harmony import */ var _OTPlanComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./OTPlanComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/OverTimes-Plan/OTPlanComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _OTPlanComponent_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./OTPlanComponent.vue?vue&type=style&index=0&scope=true&lang=css& */ "./resources/js/components/Planning/OverTimes-Plan/OTPlanComponent.vue?vue&type=style&index=0&scope=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _OTPlanComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _OTPlanComponent_vue_vue_type_template_id_213e72bb___WEBPACK_IMPORTED_MODULE_0__.render,
  _OTPlanComponent_vue_vue_type_template_id_213e72bb___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/OverTimes-Plan/OTPlanComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/OverTimes-Plan/PlanComponent.vue":
/*!***************************************************************************!*\
  !*** ./resources/js/components/Planning/OverTimes-Plan/PlanComponent.vue ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _PlanComponent_vue_vue_type_template_id_b0d01a00___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PlanComponent.vue?vue&type=template&id=b0d01a00& */ "./resources/js/components/Planning/OverTimes-Plan/PlanComponent.vue?vue&type=template&id=b0d01a00&");
/* harmony import */ var _PlanComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PlanComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/OverTimes-Plan/PlanComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _PlanComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _PlanComponent_vue_vue_type_template_id_b0d01a00___WEBPACK_IMPORTED_MODULE_0__.render,
  _PlanComponent_vue_vue_type_template_id_b0d01a00___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/OverTimes-Plan/PlanComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/OverTimes-Plan/Report/InputBudget.vue":
/*!********************************************************************************!*\
  !*** ./resources/js/components/Planning/OverTimes-Plan/Report/InputBudget.vue ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _InputBudget_vue_vue_type_template_id_73dc0c90___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./InputBudget.vue?vue&type=template&id=73dc0c90& */ "./resources/js/components/Planning/OverTimes-Plan/Report/InputBudget.vue?vue&type=template&id=73dc0c90&");
/* harmony import */ var _InputBudget_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./InputBudget.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/OverTimes-Plan/Report/InputBudget.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _InputBudget_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _InputBudget_vue_vue_type_template_id_73dc0c90___WEBPACK_IMPORTED_MODULE_0__.render,
  _InputBudget_vue_vue_type_template_id_73dc0c90___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/OverTimes-Plan/Report/InputBudget.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/OverTimes-Plan/Report/InputBudgetBiWeekly.vue":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/Planning/OverTimes-Plan/Report/InputBudgetBiWeekly.vue ***!
  \****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _InputBudgetBiWeekly_vue_vue_type_template_id_f203fd00___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./InputBudgetBiWeekly.vue?vue&type=template&id=f203fd00& */ "./resources/js/components/Planning/OverTimes-Plan/Report/InputBudgetBiWeekly.vue?vue&type=template&id=f203fd00&");
/* harmony import */ var _InputBudgetBiWeekly_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./InputBudgetBiWeekly.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/OverTimes-Plan/Report/InputBudgetBiWeekly.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _InputBudgetBiWeekly_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _InputBudgetBiWeekly_vue_vue_type_template_id_f203fd00___WEBPACK_IMPORTED_MODULE_0__.render,
  _InputBudgetBiWeekly_vue_vue_type_template_id_f203fd00___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/OverTimes-Plan/Report/InputBudgetBiWeekly.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/OverTimes-Plan/WorkingHourComponent.vue":
/*!**********************************************************************************!*\
  !*** ./resources/js/components/Planning/OverTimes-Plan/WorkingHourComponent.vue ***!
  \**********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _WorkingHourComponent_vue_vue_type_template_id_07e8494c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./WorkingHourComponent.vue?vue&type=template&id=07e8494c& */ "./resources/js/components/Planning/OverTimes-Plan/WorkingHourComponent.vue?vue&type=template&id=07e8494c&");
/* harmony import */ var _WorkingHourComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./WorkingHourComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/OverTimes-Plan/WorkingHourComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _WorkingHourComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _WorkingHourComponent_vue_vue_type_template_id_07e8494c___WEBPACK_IMPORTED_MODULE_0__.render,
  _WorkingHourComponent_vue_vue_type_template_id_07e8494c___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/OverTimes-Plan/WorkingHourComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/OverTimes-Plan/ModalReportOT.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/components/Planning/OverTimes-Plan/ModalReportOT.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalReportOT_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalReportOT.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/ModalReportOT.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalReportOT_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/OverTimes-Plan/OTPercentComponent.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************!*\
  !*** ./resources/js/components/Planning/OverTimes-Plan/OTPercentComponent.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_OTPercentComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./OTPercentComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/OTPercentComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_OTPercentComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/OverTimes-Plan/OTPlanComponent.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/components/Planning/OverTimes-Plan/OTPlanComponent.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_OTPlanComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./OTPlanComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/OTPlanComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_OTPlanComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/OverTimes-Plan/PlanComponent.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/components/Planning/OverTimes-Plan/PlanComponent.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PlanComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PlanComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/PlanComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PlanComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/OverTimes-Plan/Report/InputBudget.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************!*\
  !*** ./resources/js/components/Planning/OverTimes-Plan/Report/InputBudget.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_InputBudget_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./InputBudget.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/Report/InputBudget.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_InputBudget_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/OverTimes-Plan/Report/InputBudgetBiWeekly.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/OverTimes-Plan/Report/InputBudgetBiWeekly.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_InputBudgetBiWeekly_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./InputBudgetBiWeekly.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/Report/InputBudgetBiWeekly.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_InputBudgetBiWeekly_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/OverTimes-Plan/WorkingHourComponent.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************!*\
  !*** ./resources/js/components/Planning/OverTimes-Plan/WorkingHourComponent.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_WorkingHourComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./WorkingHourComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/WorkingHourComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_WorkingHourComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/OverTimes-Plan/OTPlanComponent.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!*************************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/OverTimes-Plan/OTPlanComponent.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \*************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_OTPlanComponent_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./OTPlanComponent.vue?vue&type=style&index=0&scope=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/OTPlanComponent.vue?vue&type=style&index=0&scope=true&lang=css&");


/***/ }),

/***/ "./resources/js/components/Planning/OverTimes-Plan/ModalReportOT.vue?vue&type=template&id=1eaeae12&":
/*!**********************************************************************************************************!*\
  !*** ./resources/js/components/Planning/OverTimes-Plan/ModalReportOT.vue?vue&type=template&id=1eaeae12& ***!
  \**********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalReportOT_vue_vue_type_template_id_1eaeae12___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalReportOT_vue_vue_type_template_id_1eaeae12___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalReportOT_vue_vue_type_template_id_1eaeae12___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalReportOT.vue?vue&type=template&id=1eaeae12& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/ModalReportOT.vue?vue&type=template&id=1eaeae12&");


/***/ }),

/***/ "./resources/js/components/Planning/OverTimes-Plan/OTPercentComponent.vue?vue&type=template&id=594887be&":
/*!***************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/OverTimes-Plan/OTPercentComponent.vue?vue&type=template&id=594887be& ***!
  \***************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_OTPercentComponent_vue_vue_type_template_id_594887be___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_OTPercentComponent_vue_vue_type_template_id_594887be___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_OTPercentComponent_vue_vue_type_template_id_594887be___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./OTPercentComponent.vue?vue&type=template&id=594887be& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/OTPercentComponent.vue?vue&type=template&id=594887be&");


/***/ }),

/***/ "./resources/js/components/Planning/OverTimes-Plan/OTPlanComponent.vue?vue&type=template&id=213e72bb&":
/*!************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/OverTimes-Plan/OTPlanComponent.vue?vue&type=template&id=213e72bb& ***!
  \************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_OTPlanComponent_vue_vue_type_template_id_213e72bb___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_OTPlanComponent_vue_vue_type_template_id_213e72bb___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_OTPlanComponent_vue_vue_type_template_id_213e72bb___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./OTPlanComponent.vue?vue&type=template&id=213e72bb& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/OTPlanComponent.vue?vue&type=template&id=213e72bb&");


/***/ }),

/***/ "./resources/js/components/Planning/OverTimes-Plan/PlanComponent.vue?vue&type=template&id=b0d01a00&":
/*!**********************************************************************************************************!*\
  !*** ./resources/js/components/Planning/OverTimes-Plan/PlanComponent.vue?vue&type=template&id=b0d01a00& ***!
  \**********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PlanComponent_vue_vue_type_template_id_b0d01a00___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PlanComponent_vue_vue_type_template_id_b0d01a00___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PlanComponent_vue_vue_type_template_id_b0d01a00___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PlanComponent.vue?vue&type=template&id=b0d01a00& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/PlanComponent.vue?vue&type=template&id=b0d01a00&");


/***/ }),

/***/ "./resources/js/components/Planning/OverTimes-Plan/Report/InputBudget.vue?vue&type=template&id=73dc0c90&":
/*!***************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/OverTimes-Plan/Report/InputBudget.vue?vue&type=template&id=73dc0c90& ***!
  \***************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputBudget_vue_vue_type_template_id_73dc0c90___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputBudget_vue_vue_type_template_id_73dc0c90___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputBudget_vue_vue_type_template_id_73dc0c90___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./InputBudget.vue?vue&type=template&id=73dc0c90& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/Report/InputBudget.vue?vue&type=template&id=73dc0c90&");


/***/ }),

/***/ "./resources/js/components/Planning/OverTimes-Plan/Report/InputBudgetBiWeekly.vue?vue&type=template&id=f203fd00&":
/*!***********************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/OverTimes-Plan/Report/InputBudgetBiWeekly.vue?vue&type=template&id=f203fd00& ***!
  \***********************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputBudgetBiWeekly_vue_vue_type_template_id_f203fd00___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputBudgetBiWeekly_vue_vue_type_template_id_f203fd00___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputBudgetBiWeekly_vue_vue_type_template_id_f203fd00___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./InputBudgetBiWeekly.vue?vue&type=template&id=f203fd00& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/Report/InputBudgetBiWeekly.vue?vue&type=template&id=f203fd00&");


/***/ }),

/***/ "./resources/js/components/Planning/OverTimes-Plan/WorkingHourComponent.vue?vue&type=template&id=07e8494c&":
/*!*****************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/OverTimes-Plan/WorkingHourComponent.vue?vue&type=template&id=07e8494c& ***!
  \*****************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_WorkingHourComponent_vue_vue_type_template_id_07e8494c___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_WorkingHourComponent_vue_vue_type_template_id_07e8494c___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_WorkingHourComponent_vue_vue_type_template_id_07e8494c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./WorkingHourComponent.vue?vue&type=template&id=07e8494c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/WorkingHourComponent.vue?vue&type=template&id=07e8494c&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/ModalReportOT.vue?vue&type=template&id=1eaeae12&":
/*!*************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/ModalReportOT.vue?vue&type=template&id=1eaeae12& ***!
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
        class: _vm.btnTrans.print.class + " btn-lg tw-w-25",
        staticStyle: { "padding-left": "7px" },
        on: { click: _vm.openModal }
      },
      [_c("i", { class: _vm.btnTrans.print.icon }), _vm._v(" พิมพ์\n    ")]
    ),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass: "modal fade",
        attrs: { id: "modal-ot-report", role: "dialog" }
      },
      [
        _c(
          "div",
          {
            staticClass: "modal-dialog modal-lg",
            staticStyle: { width: "90%", "max-width": "980px" }
          },
          [
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
                  _c("form", { attrs: { id: "machine-downtime-form" } }, [
                    _c("div", { staticClass: "table-responsive" }, [
                      _c("table", { staticClass: "table table-bordered" }, [
                        _c("thead", [
                          _c("tr", [
                            _c(
                              "th",
                              {
                                staticClass: "text-center",
                                attrs: { width: "12%" }
                              },
                              [_vm._v(" หน่วยงาน ")]
                            ),
                            _vm._v(" "),
                            _c(
                              "th",
                              {
                                staticClass: "text-center",
                                attrs: { width: "12%" }
                              },
                              [_vm._v(" ประเภทพนักงาน ")]
                            ),
                            _vm._v(" "),
                            _c(
                              "th",
                              {
                                staticClass: "text-center",
                                attrs: { width: "13%" }
                              },
                              [
                                _vm._v(
                                  " \n                                            กรอบงบประมาณค่าล่วงเวลา "
                                ),
                                _c("br"),
                                _vm._v(
                                  " ที่ผ่านการกลั่นกรองปีงบประมาณ " +
                                    _vm._s(_vm.search.budget_year) +
                                    " "
                                ),
                                _c("br"),
                                _vm._v(
                                  " (บาท)\n                                        "
                                )
                              ]
                            ),
                            _vm._v(" "),
                            _c(
                              "th",
                              {
                                staticClass: "text-center",
                                attrs: { width: "13%" }
                              },
                              [
                                _vm.search.bi_weekly == 1
                                  ? [
                                      _vm._v(
                                        "\n                                                ประมาณการใช้งบประมาณ "
                                      ),
                                      _c("br"),
                                      _vm._v(" ปักษ์ที่ 1 "),
                                      _c("br"),
                                      _vm._v(
                                        " (บาท)\n                                            "
                                      )
                                    ]
                                  : [
                                      _vm._v(
                                        "\n                                                ประมาณการใช้งบประมาณ "
                                      ),
                                      _c("br"),
                                      _vm._v(
                                        " ปักษ์ที่ 1 - " +
                                          _vm._s(_vm.search.bi_weekly - 1) +
                                          " "
                                      ),
                                      _c("br"),
                                      _vm._v(
                                        " (บาท)\n                                            "
                                      )
                                    ]
                              ],
                              2
                            )
                          ])
                        ]),
                        _vm._v(" "),
                        _c(
                          "tbody",
                          [
                            _vm._l(_vm.departments, function(department, name) {
                              return [
                                _c("tr", [
                                  _c(
                                    "td",
                                    {
                                      staticClass: "text-center",
                                      attrs: { rowspan: department.length + 1 }
                                    },
                                    [
                                      _vm._v(
                                        "\n                                                " +
                                          _vm._s(name) +
                                          "\n                                            "
                                      )
                                    ]
                                  )
                                ]),
                                _vm._l(department, function(dept) {
                                  return _c("tr", [
                                    _c("td", { staticClass: "text-center" }, [
                                      _vm._v(
                                        "\n                                                    " +
                                          _vm._s(dept.employee_type_name) +
                                          "\n                                                "
                                      )
                                    ]),
                                    _vm._v(" "),
                                    _c(
                                      "td",
                                      { staticClass: "text-center" },
                                      [
                                        _c("inputBudget", {
                                          attrs: {
                                            department: dept,
                                            pBudgetBiWeekly: _vm.budgetBiWeekly
                                          }
                                        })
                                      ],
                                      1
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "td",
                                      { staticClass: "text-center" },
                                      [
                                        _c("inputBudgetBiWeekly", {
                                          attrs: {
                                            department: dept,
                                            pBudgetBiWeekly: _vm.budgetBiWeekly
                                          }
                                        })
                                      ],
                                      1
                                    )
                                  ])
                                })
                              ]
                            })
                          ],
                          2
                        )
                      ])
                    ])
                  ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "modal-footer" }, [
                  _c(
                    "button",
                    {
                      class: _vm.btnTrans.print.class + " btn-lg tw-w-25",
                      attrs: { type: "button" },
                      on: {
                        click: function($event) {
                          $event.preventDefault()
                          return _vm.submit()
                        }
                      }
                    },
                    [
                      _c("i", { class: _vm.btnTrans.print.icon }),
                      _vm._v(
                        " " +
                          _vm._s(_vm.btnTrans.print.text) +
                          "\n                    "
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "button",
                    {
                      staticClass: "btn btn-white btn-lg tw-w-25'",
                      attrs: { type: "button", "data-dismiss": "modal" }
                    },
                    [_vm._v(" ยกเลิก ")]
                  )
                ])
              ]
            )
          ]
        )
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
          staticStyle: { "font-size": "24px", "font-weight": "400" }
        },
        [
          _vm._v(
            "\n                        รายงานประมาณการค่าใช้จ่ายล่วงเวลาประจำปักษ์\n                    "
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
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/OTPercentComponent.vue?vue&type=template&id=594887be&":
/*!******************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/OTPercentComponent.vue?vue&type=template&id=594887be& ***!
  \******************************************************************************************************************************************************************************************************************************************************/
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
    [
      _c("vue-numeric", {
        staticClass: "form-control input-sm text-right",
        attrs: {
          precision: 2,
          minus: false,
          min: 0,
          max: 100,
          disabled: _vm.canEdit
        },
        on: {
          change: function($event) {
            return _vm.changeOTPercent()
          },
          blur: function($event) {
            return _vm.changeOTPercent()
          }
        },
        model: {
          value: _vm.percent,
          callback: function($$v) {
            _vm.percent = $$v
          },
          expression: "percent"
        }
      })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/OTPlanComponent.vue?vue&type=template&id=213e72bb&":
/*!***************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/OTPlanComponent.vue?vue&type=template&id=213e72bb& ***!
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
    [
      Object.values(_vm.search).length > 0 && _vm.otMain
        ? [
            _vm.loadingOTPlan != ""
              ? [
                  _c("div", {
                    domProps: { innerHTML: _vm._s(_vm.loadingOTPlan) }
                  })
                ]
              : _vm.otPlans.length <= 0
              ? [_vm._m(0)]
              : [
                  _c("div", { staticClass: "row col-12 mb-3" }, [
                    _c("div", { staticClass: "col-md-6 p-0" }, [
                      _c(
                        "label",
                        { staticClass: "tw-font-bold tw-uppercase mb-1 ml-1" },
                        [_vm._v(" หน่วยงาน ")]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        [
                          _c(
                            "el-select",
                            {
                              staticStyle: { width: "50%" },
                              attrs: {
                                placeholder: "Department",
                                size: "medium"
                              },
                              on: { change: _vm.getOTPlan },
                              model: {
                                value: _vm.department,
                                callback: function($$v) {
                                  _vm.department = $$v
                                },
                                expression: "department"
                              }
                            },
                            _vm._l(_vm.departments, function(dept) {
                              return _c("el-option", {
                                key: dept.department_code,
                                attrs: {
                                  label:
                                    dept.department_code +
                                    ": " +
                                    dept.department_name,
                                  value: dept.department_code
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
                    _c("div", { staticClass: "col-md-6  p-0 text-right" }, [
                      !_vm.canEdit && !_vm.isNotDisableControl
                        ? _c(
                            "button",
                            {
                              class:
                                _vm.btnTrans.edit.class + " btn-lg tw-w-25",
                              staticStyle: { "padding-left": "7px" },
                              on: {
                                click: function($event) {
                                  $event.preventDefault()
                                  return _vm.editWorkingHour(
                                    (_vm.canEdit = !_vm.canEdit)
                                  )
                                }
                              }
                            },
                            [
                              _c("i", { class: _vm.btnTrans.edit.icon }),
                              _vm._v(
                                " แก้ไขชั่วโมงการทำงาน\n                    "
                              )
                            ]
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _vm.canEdit
                        ? _c(
                            "button",
                            {
                              class:
                                _vm.btnTrans.confirm.class + " btn-lg tw-w-25",
                              staticStyle: { "padding-left": "7px" },
                              on: {
                                click: function($event) {
                                  $event.preventDefault()
                                  return _vm.updateOTPlan($event)
                                }
                              }
                            },
                            [
                              _c("i", { class: _vm.btnTrans.confirm.icon }),
                              _vm._v(
                                " ยืนยันชั่วโมงการทำงาน\n                    "
                              )
                            ]
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _vm.canEdit
                        ? _c(
                            "button",
                            {
                              class:
                                _vm.btnTrans.cancel.class + " btn-lg tw-w-25",
                              staticStyle: { "padding-left": "7px" },
                              on: {
                                click: function($event) {
                                  $event.preventDefault()
                                  return _vm.editWorkingHour(
                                    (_vm.canEdit = !_vm.canEdit)
                                  )
                                }
                              }
                            },
                            [
                              _c("i", { class: _vm.btnTrans.cancel.icon }),
                              _vm._v(" ยกเลิก\n                    ")
                            ]
                          )
                        : _vm._e()
                    ])
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "table-responsive" }, [
                    _c(
                      "table",
                      {
                        staticClass: "table table-bordered table-hover",
                        staticStyle: {
                          width: "50%",
                          "max-height": "370px",
                          display: "block",
                          overflow: "auto",
                          position: "sticky"
                        }
                      },
                      [
                        _vm._m(1),
                        _vm._v(" "),
                        _c(
                          "tbody",
                          _vm._l(_vm.otPlans, function(plan, index) {
                            return _c("tr", [
                              _c(
                                "td",
                                {
                                  staticClass: "text-center",
                                  style:
                                    plan.holiday_flag == "Y"
                                      ? "background-color: #ddd;"
                                      : plan.holiday_flag == "P"
                                      ? "background-color: #cccccc;"
                                      : ""
                                },
                                [
                                  _vm._v(
                                    "\n                                " +
                                      _vm._s(_vm.dateArr[plan.workdy]) +
                                      "\n                            "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "td",
                                {
                                  staticClass: "text-center",
                                  style:
                                    plan.holiday_flag == "Y"
                                      ? "background-color: #ddd;"
                                      : plan.holiday_flag == "P"
                                      ? "background-color: #cccccc;"
                                      : ""
                                },
                                [
                                  _vm._v(
                                    "\n                                " +
                                      _vm._s(plan.working_date_at_format) +
                                      "\n                            "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "td",
                                {
                                  staticClass: "text-center",
                                  style:
                                    plan.holiday_flag == "Y"
                                      ? "background-color: #ddd;"
                                      : plan.holiday_flag == "P"
                                      ? "background-color: #cccccc;"
                                      : ""
                                },
                                [
                                  _c("workingHour", {
                                    attrs: {
                                      plan: plan,
                                      workingHoliday: _vm.workingHoliday,
                                      pWorkingHourEdit: _vm.workingHourEdit,
                                      canEdit: _vm.canEdit
                                    }
                                  })
                                ],
                                1
                              )
                            ])
                          }),
                          0
                        )
                      ]
                    )
                  ])
                ],
            _vm._v(" "),
            _c("div", { staticClass: "hr-line-dashed" }),
            _vm._v(" "),
            _vm.loadingOTPlan != ""
              ? [_c("div")]
              : _vm.loadingOTPlanBiWeekly != ""
              ? [
                  _c("div", {
                    domProps: { innerHTML: _vm._s(_vm.loadingOTPlanBiWeekly) }
                  })
                ]
              : [
                  Object.values(_vm.otPlanBiWeekly).length > 0
                    ? _c("div", { staticClass: "row mr-2 mb-2 pull-right" }, [
                        !_vm.canEdit && !_vm.isNotDisableControl
                          ? _c(
                              "button",
                              {
                                class:
                                  _vm.btnTrans.confirm.class +
                                  " btn-lg tw-w-25",
                                staticStyle: { "padding-left": "7px" },
                                on: {
                                  click: function($event) {
                                    $event.preventDefault()
                                    return _vm.updateOTPercent($event)
                                  }
                                }
                              },
                              [
                                _c("i", { class: _vm.btnTrans.confirm.icon }),
                                _vm._v(
                                  " คำนวณค่าใช้จ่ายล่วงเวลา\n                "
                                )
                              ]
                            )
                          : _vm._e()
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  _c("div", { staticClass: "table-responsive m-t" }, [
                    _c(
                      "table",
                      {
                        staticClass:
                          "table table-bordered table-hover text-nowrap"
                      },
                      [
                        _c("thead", [
                          _c(
                            "tr",
                            [
                              _c(
                                "th",
                                {
                                  staticClass: "text-center",
                                  attrs: { rowspan: "2", width: "15%" }
                                },
                                [
                                  _vm._v(
                                    "\n                                    กลุ่ม / กองพนักงาน\n                                "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "th",
                                {
                                  staticClass: "text-center",
                                  attrs: { rowspan: "2", width: "12%" }
                                },
                                [
                                  _vm._v(
                                    "\n                                    ประเภท\n                                "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "th",
                                {
                                  staticClass: "text-center",
                                  attrs: { rowspan: "2", width: "8%" }
                                },
                                [
                                  _vm._v(
                                    "\n                                    จำนวน\n                                "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "th",
                                {
                                  staticClass: "text-center",
                                  attrs: { rowspan: "2", width: "8%" }
                                },
                                [
                                  _vm._v(
                                    "\n                                    ค่าแรง\n                                "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "th",
                                {
                                  staticClass: "text-center",
                                  attrs: { colspan: "2", width: "12%" }
                                },
                                [
                                  _vm._v(
                                    "\n                                    เสาร์ / อาทิตย์ / นักขัตฤกษ์\n                                "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _vm._l(_vm.otTimeDesc, function(time, index) {
                                return [
                                  _c(
                                    "th",
                                    {
                                      staticClass: "text-center",
                                      style:
                                        "background-color: " +
                                        _vm.colorCode[index] +
                                        "; border-right: 2px solid #646464;",
                                      attrs: { colspan: "5", width: "15%" }
                                    },
                                    [
                                      _vm._v(
                                        "\n                                        " +
                                          _vm._s(time) +
                                          " น.\n                                    "
                                      )
                                    ]
                                  )
                                ]
                              })
                            ],
                            2
                          ),
                          _vm._v(" "),
                          _c(
                            "tr",
                            [
                              _c(
                                "th",
                                {
                                  staticClass: "text-center",
                                  attrs: { width: "8%" }
                                },
                                [
                                  _vm._v(
                                    "\n                                    ชม. ผลิตเพิ่ม\n                                "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "th",
                                {
                                  staticClass: "text-center",
                                  attrs: { width: "8%" }
                                },
                                [
                                  _vm._v(
                                    "\n                                    ค่าล่วงเวลา\n                                "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _vm._l(_vm.otTimeDesc, function(time) {
                                return [
                                  _c(
                                    "th",
                                    {
                                      staticClass: "text-center",
                                      attrs: { width: "10%" }
                                    },
                                    [
                                      _vm._v(
                                        "\n                                        % ทำงานล่วงเวลา\n                                    "
                                      )
                                    ]
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "th",
                                    {
                                      staticClass: "text-center",
                                      attrs: { width: "8%" }
                                    },
                                    [
                                      _vm._v(
                                        "\n                                        ค่าแรง OT/ชม.\n                                    "
                                      )
                                    ]
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "th",
                                    {
                                      staticClass: "text-center",
                                      attrs: { width: "8%" }
                                    },
                                    [
                                      _vm._v(
                                        "\n                                        ชม. ผลิตเพิ่ม\n                                    "
                                      )
                                    ]
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "th",
                                    {
                                      staticClass: "text-center",
                                      attrs: { width: "8%" }
                                    },
                                    [
                                      _vm._v(
                                        "\n                                        คิด 1.5 เท่า\n                                    "
                                      )
                                    ]
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "th",
                                    {
                                      staticClass: "text-center",
                                      staticStyle: {
                                        "border-right": "2px solid #646464"
                                      },
                                      attrs: { width: "8%" }
                                    },
                                    [
                                      _vm._v(
                                        "\n                                        ค่าล่วงเวลา\n                                    "
                                      )
                                    ]
                                  )
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
                            _vm.otPlanBiWeekly.length <= 0
                              ? [_vm._m(2)]
                              : [
                                  _vm._l(_vm.otPlanBiWeekly, function(
                                    plans,
                                    dept
                                  ) {
                                    return [
                                      _c("tr", [
                                        _c(
                                          "td",
                                          {
                                            staticClass: "text-left",
                                            attrs: { rowspan: plans.length + 1 }
                                          },
                                          [
                                            _c("div", [
                                              _vm._v(
                                                " " +
                                                  _vm._s(
                                                    _vm.getDepartmentGroup(dept)
                                                  ) +
                                                  " "
                                              )
                                            ])
                                          ]
                                        )
                                      ]),
                                      _vm._l(plans, function(plan) {
                                        return _c(
                                          "tr",
                                          [
                                            _c(
                                              "td",
                                              { staticClass: "text-center" },
                                              [
                                                _vm._v(
                                                  "\n                                                " +
                                                    _vm._s(
                                                      plan.employee_type_name
                                                    ) +
                                                    "\n                                            "
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              { staticClass: "text-center" },
                                              [
                                                _vm._v(
                                                  "\n                                                " +
                                                    _vm._s(plan.employee_qty) +
                                                    "\n                                            "
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              { staticClass: "text-right" },
                                              [
                                                _vm._v(
                                                  "\n                                                " +
                                                    _vm._s(plan.ot_perhour) +
                                                    "\n                                            "
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              { staticClass: "text-center" },
                                              [
                                                _vm._v(
                                                  "\n                                                " +
                                                    _vm._s(plan.ot_hour) +
                                                    "\n                                            "
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              { staticClass: "text-right" },
                                              [
                                                _vm._v(
                                                  "\n                                                " +
                                                    _vm._s(
                                                      _vm._f("number2Digit")(
                                                        plan.ot_holiday
                                                      )
                                                    ) +
                                                    "\n                                            "
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _vm._l(_vm.otTimeDesc, function(
                                              time
                                            ) {
                                              return [
                                                _c(
                                                  "td",
                                                  {
                                                    staticClass: "text-center"
                                                  },
                                                  [
                                                    _c("otPercent", {
                                                      attrs: {
                                                        plan: plan,
                                                        time: time,
                                                        otPercent:
                                                          _vm.otPercent,
                                                        value:
                                                          _vm.otPercent[time][
                                                            plan.department_code +
                                                              "|" +
                                                              plan.employee_type
                                                          ],
                                                        pOtPercentEdit:
                                                          _vm.otPercentEdit,
                                                        canEdit:
                                                          _vm.canEdit ||
                                                          _vm.isNotDisableControl
                                                      }
                                                    })
                                                  ],
                                                  1
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "td",
                                                  { staticClass: "text-right" },
                                                  [
                                                    _vm._v(
                                                      "\n                                                    " +
                                                        _vm._s(
                                                          _vm._f(
                                                            "number2Digit"
                                                          )(
                                                            _vm.hourlyWage[
                                                              time
                                                            ][
                                                              plan.department_code +
                                                                "|" +
                                                                plan.employee_type
                                                            ]
                                                          )
                                                        ) +
                                                        "\n                                                "
                                                    )
                                                  ]
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "td",
                                                  {
                                                    staticClass: "text-center"
                                                  },
                                                  [
                                                    _vm._v(
                                                      "\n                                                    " +
                                                        _vm._s(
                                                          _vm.hourIncrease[
                                                            time
                                                          ][
                                                            plan.department_code +
                                                              "|" +
                                                              plan.employee_type
                                                          ]
                                                        ) +
                                                        "\n                                                "
                                                    )
                                                  ]
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "td",
                                                  {
                                                    staticClass: "text-center"
                                                  },
                                                  [
                                                    _vm._v(
                                                      "\n                                                    " +
                                                        _vm._s(
                                                          _vm.defaultRate[time][
                                                            plan.department_code +
                                                              "|" +
                                                              plan.employee_type
                                                          ]
                                                        ) +
                                                        "\n                                                "
                                                    )
                                                  ]
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "td",
                                                  {
                                                    staticClass: "text-right",
                                                    staticStyle: {
                                                      "border-right":
                                                        "2px solid #646464"
                                                    }
                                                  },
                                                  [
                                                    _vm._v(
                                                      "\n                                                    " +
                                                        _vm._s(
                                                          _vm._f(
                                                            "number2Digit"
                                                          )(
                                                            _vm.otAmount[time][
                                                              plan.department_code +
                                                                "|" +
                                                                plan.employee_type
                                                            ]
                                                          )
                                                        ) +
                                                        "\n                                                "
                                                    )
                                                  ]
                                                )
                                              ]
                                            })
                                          ],
                                          2
                                        )
                                      })
                                    ]
                                  }),
                                  _vm._v(" "),
                                  _c(
                                    "tr",
                                    {
                                      staticStyle: {
                                        "background-color": "#34d399"
                                      }
                                    },
                                    [
                                      _c(
                                        "th",
                                        {
                                          staticClass: "text-right",
                                          attrs: { colspan: "6" }
                                        },
                                        [
                                          _vm._v(
                                            "\n                                        รวมหน่วยงาน : " +
                                              _vm._s(
                                                _vm.getDepartment(
                                                  _vm.department
                                                )
                                              ) +
                                              "\n                                    "
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _vm._l(_vm.otTimeDesc, function(time) {
                                        return [
                                          _c(
                                            "th",
                                            { staticClass: "text-center" },
                                            [
                                              _vm._v(
                                                "\n                                            -\n                                        "
                                              )
                                            ]
                                          ),
                                          _vm._v(" "),
                                          _c(
                                            "th",
                                            { staticClass: "text-right" },
                                            [
                                              _vm._v(
                                                "\n                                            " +
                                                  _vm._s(
                                                    _vm._f("number2Digit")(
                                                      _vm.summary[time]
                                                        .hourly_wage
                                                    )
                                                  ) +
                                                  "\n                                        "
                                              )
                                            ]
                                          ),
                                          _vm._v(" "),
                                          _c(
                                            "th",
                                            { staticClass: "text-center" },
                                            [
                                              _vm._v(
                                                "\n                                            " +
                                                  _vm._s(
                                                    _vm._f("number0Digit")(
                                                      _vm.summary[time]
                                                        .hour_increase
                                                    )
                                                  ) +
                                                  "\n                                        "
                                              )
                                            ]
                                          ),
                                          _vm._v(" "),
                                          _c(
                                            "th",
                                            { staticClass: "text-center" },
                                            [
                                              _vm._v(
                                                "\n                                            -\n                                        "
                                              )
                                            ]
                                          ),
                                          _vm._v(" "),
                                          _c(
                                            "th",
                                            {
                                              staticClass: "text-right",
                                              staticStyle: {
                                                "border-right":
                                                  "2px solid #646464"
                                              }
                                            },
                                            [
                                              _vm._v(
                                                "\n                                            " +
                                                  _vm._s(
                                                    _vm._f("number2Digit")(
                                                      _vm.summary[time]
                                                        .ot_amount
                                                    )
                                                  ) +
                                                  "\n                                        "
                                              )
                                            ]
                                          )
                                        ]
                                      })
                                    ],
                                    2
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "tr",
                                    {
                                      staticStyle: {
                                        "background-color": "#34d399"
                                      }
                                    },
                                    [
                                      _c(
                                        "th",
                                        {
                                          staticClass: "text-right",
                                          attrs: { colspan: "6" }
                                        },
                                        [
                                          _vm._v(
                                            "\n                                        รวมทุกหน่วยงาน\n                                    "
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _vm._l(_vm.otTimeDesc, function(time) {
                                        return [
                                          _c(
                                            "th",
                                            { staticClass: "text-center" },
                                            [
                                              _vm._v(
                                                "\n                                            -\n                                        "
                                              )
                                            ]
                                          ),
                                          _vm._v(" "),
                                          _c(
                                            "th",
                                            { staticClass: "text-right" },
                                            [
                                              _vm._v(
                                                "\n                                            " +
                                                  _vm._s(
                                                    _vm._f("number2Digit")(
                                                      _vm.summaryAll[time]
                                                        .hourly_wage
                                                    )
                                                  ) +
                                                  "\n                                        "
                                              )
                                            ]
                                          ),
                                          _vm._v(" "),
                                          _c(
                                            "th",
                                            { staticClass: "text-center" },
                                            [
                                              _vm._v(
                                                "\n                                            " +
                                                  _vm._s(
                                                    _vm._f("number0Digit")(
                                                      _vm.summaryAll[time]
                                                        .hour_increase
                                                    )
                                                  ) +
                                                  "\n                                        "
                                              )
                                            ]
                                          ),
                                          _vm._v(" "),
                                          _c(
                                            "th",
                                            { staticClass: "text-center" },
                                            [
                                              _vm._v(
                                                "\n                                            -\n                                        "
                                              )
                                            ]
                                          ),
                                          _vm._v(" "),
                                          _c(
                                            "th",
                                            {
                                              staticClass: "text-right",
                                              staticStyle: {
                                                "border-right":
                                                  "2px solid #646464"
                                              }
                                            },
                                            [
                                              _vm._v(
                                                "\n                                            " +
                                                  _vm._s(
                                                    _vm._f("number2Digit")(
                                                      _vm.summaryAll[time]
                                                        .ot_amount
                                                    )
                                                  ) +
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
                          ],
                          2
                        )
                      ]
                    )
                  ])
                ]
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
    return _c("div", { staticClass: "col-12 text-center" }, [
      _c("h2", [_vm._v(" ไม่พบข้อมูลที่ค้นหาในระบบ ")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", { staticStyle: { height: "50px" } }, [
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: {
              "vertical-align": "middle",
              "min-width": "50px",
              position: "sticky",
              top: "0",
              "z-index": "9999"
            },
            attrs: { width: "12%" }
          },
          [
            _vm._v(
              "\n                                วัน\n                            "
            )
          ]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: {
              "vertical-align": "middle",
              "min-width": "50px",
              position: "sticky",
              top: "0",
              "z-index": "9999"
            },
            attrs: { width: "12%" }
          },
          [
            _vm._v(
              "\n                                วันที่\n                            "
            )
          ]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: {
              "vertical-align": "middle",
              "min-width": "50px",
              position: "sticky",
              top: "0",
              "z-index": "9999"
            },
            attrs: { width: "10%" }
          },
          [
            _vm._v(
              "\n                                ชั่วโมงการทำงาน\n                            "
            )
          ]
        )
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c(
        "td",
        {
          staticClass: "text-center",
          staticStyle: { "vertical-align": "middle" },
          attrs: { colspan: "21" }
        },
        [_c("h2", [_vm._v(" ไม่มีข้อมูลประมาณการคำนวณค่าใช้จ่ายล่วงเวลา ")])]
      )
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/PlanComponent.vue?vue&type=template&id=b0d01a00&":
/*!*************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/PlanComponent.vue?vue&type=template&id=b0d01a00& ***!
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
  return _c("div", [
    _c(
      "div",
      { staticClass: "ibox float-e-margins mb-2" },
      [
        _c("div", { staticClass: "row col-12 m-0 mb-2" }, [
          _vm._m(0),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass:
                "form-group pl-2 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 mt-2 text-right"
            },
            [
              _c(
                "button",
                {
                  staticClass: "btn btn-white btn-lg",
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      return _vm.submit($event)
                    }
                  }
                },
                [
                  _c("i", { staticClass: "fa fa-search" }),
                  _vm._v(" ค้นหา\n                ")
                ]
              ),
              _vm._v(" "),
              _c(
                "a",
                {
                  staticClass: "btn btn-white btn-lg",
                  attrs: { href: _vm.url.submit_p10 }
                },
                [_vm._v("ล้าง")]
              ),
              _vm._v(" "),
              _c("modalReportOt", {
                attrs: {
                  departments: _vm.deptReports,
                  search: _vm.search,
                  btnTrans: _vm.btnTrans,
                  url: _vm.url,
                  selDepartment: _vm.sel_department
                }
              })
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "card border-primary mb-3 mt-3" }, [
          _c("div", { staticClass: "card-body" }, [
            _c("div", { staticClass: "row" }, [
              _c("div", { staticClass: "col-12" }, [
                _c(
                  "form",
                  {
                    attrs: { id: "overtimes-form", action: _vm.url.submit_p10 }
                  },
                  [
                    _c("div", { staticClass: "row" }, [
                      _c(
                        "div",
                        {
                          staticClass:
                            "form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2"
                        },
                        [
                          _c(
                            "label",
                            { staticClass: " tw-font-bold tw-uppercase mb-1" },
                            [_vm._v(" ปีงบประมาณ ")]
                          ),
                          _vm._v(" "),
                          _c(
                            "div",
                            { staticClass: "input-group " },
                            [
                              _c("input", {
                                attrs: { type: "hidden", name: "budget_year" },
                                domProps: { value: _vm.budget_year }
                              }),
                              _vm._v(" "),
                              _c(
                                "el-select",
                                {
                                  ref: "budget_year",
                                  attrs: {
                                    size: "medium",
                                    placeholder: "ปีงบประมาณ",
                                    filterable: ""
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
                              )
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
                            "form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2"
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
                              _c("input", {
                                attrs: { type: "hidden", name: "month" },
                                domProps: { value: _vm.month }
                              }),
                              _vm._v(" "),
                              !_vm.budget_year
                                ? _c(
                                    "el-select",
                                    {
                                      ref: "month",
                                      attrs: {
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
                                      directives: [
                                        {
                                          name: "loading",
                                          rawName: "v-loading",
                                          value: _vm.m_loading,
                                          expression: "m_loading"
                                        }
                                      ],
                                      ref: "month",
                                      attrs: {
                                        size: "medium",
                                        placeholder: "เดือน",
                                        filterable: ""
                                      },
                                      on: { change: _vm.getBiWeeklySeq },
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
                            "form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2"
                        },
                        [
                          _c(
                            "label",
                            { staticClass: " tw-font-bold tw-uppercase mb-1" },
                            [_vm._v(" ปักษ์ ")]
                          ),
                          _vm._v(" "),
                          _c(
                            "div",
                            {},
                            [
                              _c("input", {
                                attrs: { type: "hidden", name: "bi_weekly" },
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
                                        size: "medium",
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
                                      directives: [
                                        {
                                          name: "loading",
                                          rawName: "v-loading",
                                          value: _vm.b_loading,
                                          expression: "b_loading"
                                        }
                                      ],
                                      ref: "bi_weekly",
                                      attrs: {
                                        clearable: "",
                                        size: "medium",
                                        placeholder: "ปักษ์",
                                        filterable: ""
                                      },
                                      on: { change: _vm.getBiWeeklyDetail },
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
                            "form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2"
                        },
                        [
                          _c(
                            "label",
                            { staticClass: " tw-font-bold tw-uppercase mb-1" },
                            [_vm._v(" ประจำวันที่ ")]
                          ),
                          _vm._v(" "),
                          _vm.bi_weekly_detail
                            ? _c(
                                "div",
                                {
                                  staticClass: "p-1",
                                  staticStyle: { "font-size": "14px" }
                                },
                                [
                                  _vm._v(
                                    "\n                                        " +
                                      _vm._s(_vm.bi_weekly_detail) +
                                      "\n                                    "
                                  )
                                ]
                              )
                            : _vm._e()
                        ]
                      )
                    ])
                  ]
                )
              ])
            ])
          ])
        ]),
        _vm._v(" "),
        [
          _c("div", { staticClass: "row" }, [
            _c(
              "div",
              { staticClass: "col-lg-12 mt-3" },
              [
                _c("otPlan", {
                  attrs: {
                    departments: _vm.departments,
                    defaultInput: _vm.defaultInput,
                    workingHoliday: _vm.workingHoliday,
                    search: _vm.search,
                    otMain: _vm.otMain,
                    dateArr: _vm.dateArr,
                    url: _vm.url,
                    btnTrans: _vm.btnTrans,
                    colorCode: _vm.colorCode
                  },
                  on: { department: _vm.selDepartment }
                })
              ],
              1
            )
          ])
        ]
      ],
      2
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      {
        staticClass:
          "form-group pl-2 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 mt-3"
      },
      [_c("h3", [_vm._v(" ประมาณการค่าใช้จ่ายล่วงเวลาประจำปักษ์ ")])]
    )
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/Report/InputBudget.vue?vue&type=template&id=73dc0c90&":
/*!******************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/Report/InputBudget.vue?vue&type=template&id=73dc0c90& ***!
  \******************************************************************************************************************************************************************************************************************************************************/
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
    [
      _c("vue-numeric", {
        staticClass: "form-control input-sm text-right",
        attrs: { precision: 2, minus: false, min: 0, max: 9999999999 },
        on: {
          change: function($event) {
            return _vm.changeInputAmount()
          },
          blur: function($event) {
            return _vm.changeInputAmount()
          }
        },
        model: {
          value: _vm.amount,
          callback: function($$v) {
            _vm.amount = $$v
          },
          expression: "amount"
        }
      })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/Report/InputBudgetBiWeekly.vue?vue&type=template&id=f203fd00&":
/*!**************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/Report/InputBudgetBiWeekly.vue?vue&type=template&id=f203fd00& ***!
  \**************************************************************************************************************************************************************************************************************************************************************/
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
    [
      _c("vue-numeric", {
        staticClass: "form-control input-sm text-right",
        attrs: { precision: 2, minus: false, min: 0, max: 9999999999 },
        on: {
          change: function($event) {
            return _vm.changeInputAmount()
          },
          blur: function($event) {
            return _vm.changeInputAmount()
          }
        },
        model: {
          value: _vm.amount,
          callback: function($$v) {
            _vm.amount = $$v
          },
          expression: "amount"
        }
      })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/WorkingHourComponent.vue?vue&type=template&id=07e8494c&":
/*!********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/OverTimes-Plan/WorkingHourComponent.vue?vue&type=template&id=07e8494c& ***!
  \********************************************************************************************************************************************************************************************************************************************************/
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
    [
      _c(
        "el-select",
        {
          attrs: { placeholder: "Hour", size: "small", disabled: !_vm.canEdit },
          on: { change: _vm.changeHour },
          model: {
            value: _vm.hour,
            callback: function($$v) {
              _vm.hour = $$v
            },
            expression: "hour"
          }
        },
        _vm._l(_vm.workingHoliday, function(hour) {
          return _c("el-option", {
            key: hour.attribute1,
            attrs: { label: hour.attribute1, value: hour.attribute1 }
          })
        }),
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);