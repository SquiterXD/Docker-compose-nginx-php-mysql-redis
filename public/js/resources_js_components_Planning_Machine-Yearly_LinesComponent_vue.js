(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_Planning_Machine-Yearly_LinesComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/DateRangeDetail.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/DateRangeDetail.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['dateRangeDetail'],
  data: function data() {
    return {// oldEamMachine: this.line.machine_eamperformance,
    };
  },
  mounted: function mounted() {}
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/EfficiencyDetail.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/EfficiencyDetail.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['total', 'unit'],
  data: function data() {
    return {};
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/EfficiencyMachineComponent.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/EfficiencyMachineComponent.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************************************************/
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
//
//
//
//
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
  props: ['editFlag', 'line', 'lineMachineEdit'],
  data: function data() {
    var _this$line$machine_ea;

    return {
      oldEamMachine: (_this$line$machine_ea = this.line.machine_eamperformance) !== null && _this$line$machine_ea !== void 0 ? _this$line$machine_ea : 0
    };
  },
  mounted: function mounted() {},
  watch: {
    'editFlag': function editFlag(newValue) {
      if (newValue == false) {
        this.line.machine_eamperformance = Number(this.oldEamMachine); // this.changeEfficiencyMachineByLine()
      }
    }
  },
  // computed: {
  //     machine_eamperformance: function () {
  //         var vue = this;
  //         Object.values(vue.eamperformanceMachines).filter(function(eam, index){
  //             return  eam[vue.line.machine_description];
  //         });
  //     }
  // },
  methods: {
    changeEfficiencyMachineByLine: function changeEfficiencyMachineByLine() {
      var vue = this; //efficiency_machine_per_min

      var d = Number(vue.line.machine_speed) * (Number(vue.line.machine_eamperformance) / 100); //efficiency_product
      // vue.resPlanDate.filter(function(planDate){
      //     let f = (Number(d) * (Number(planDate.working_hour)-1)*60) ;
      //     let r = (Number(f)*(Number(vue.efficiency_product)/100))/1000000;
      //     // this.result = Number(r.toFixed(3));
      //     Object.values(vue.efficiencyProducts[planDate.res_plan_date_display]).filter(function(res, value) {
      //         vue.efficiencyProducts[planDate.res_plan_date_display][vue.line[machineGroup][index].machine_description] = Number(r.toFixed(3));
      //     });
      // });
      //result

      vue.line.efficiency_machine_per_min = d; //Stamp line ที่มีการแก้ไขจำนวน Efficiency

      Vue.set(vue.lineMachineEdit, vue.line.machine_name, Number(vue.line.machine_eamperformance));
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/LinesComponent.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/LinesComponent.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var _Commons_Machine_EfficiencyMachineComponent_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../Commons/Machine/EfficiencyMachineComponent.vue */ "./resources/js/components/Planning/Commons/Machine/EfficiencyMachineComponent.vue");
/* harmony import */ var _OMSalesForecast_vue__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./OMSalesForecast.vue */ "./resources/js/components/Planning/Machine-Yearly/OMSalesForecast.vue");
/* harmony import */ var _ModalMachineDowntime_vue__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./ModalMachineDowntime.vue */ "./resources/js/components/Planning/Machine-Yearly/ModalMachineDowntime.vue");
/* harmony import */ var _Commons_Machine_DateRangeDetail_vue__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../Commons/Machine/DateRangeDetail.vue */ "./resources/js/components/Planning/Commons/Machine/DateRangeDetail.vue");
/* harmony import */ var _Commons_Machine_EfficiencyDetail_vue__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ../Commons/Machine/EfficiencyDetail.vue */ "./resources/js/components/Planning/Commons/Machine/EfficiencyDetail.vue");
/* harmony import */ var _ModalHoliday_vue__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./ModalHoliday.vue */ "./resources/js/components/Planning/Machine-Yearly/ModalHoliday.vue");
/* harmony import */ var _ModalOverview_vue__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./ModalOverview.vue */ "./resources/js/components/Planning/Machine-Yearly/ModalOverview.vue");
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! vue-numeric */ "./node_modules/vue-numeric/dist/vue-numeric.min.js");
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(vue_numeric__WEBPACK_IMPORTED_MODULE_10__);


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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
    EffMachine: _Commons_Machine_EfficiencyMachineComponent_vue__WEBPACK_IMPORTED_MODULE_3__.default,
    OMSalesForecast: _OMSalesForecast_vue__WEBPACK_IMPORTED_MODULE_4__.default,
    MachineDowntime: _ModalMachineDowntime_vue__WEBPACK_IMPORTED_MODULE_5__.default,
    DateRangeDetail: _Commons_Machine_DateRangeDetail_vue__WEBPACK_IMPORTED_MODULE_6__.default,
    EfficiencyDetail: _Commons_Machine_EfficiencyDetail_vue__WEBPACK_IMPORTED_MODULE_7__.default,
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_10___default()),
    ModalHol: _ModalHoliday_vue__WEBPACK_IMPORTED_MODULE_8__.default,
    ModalOverview: _ModalOverview_vue__WEBPACK_IMPORTED_MODULE_9__.default
  },
  props: ['pHeader', 'pDefaultInput', 'pSearchInput', 'monthDetails', 'pEditFlag', 'pShowFlag', 'pUrl', 'budgetYear', 'productType', 'pEfficiencyMachinePercent', 'pEfficiencyProductPercent', 'btnTrans', 'pDateFormat', 'search'],
  data: function data() {
    return {
      header: this.pHeader,
      url: this.pUrl,
      edit_flag: false,
      show_flag: this.pShowFlag,
      loading: false,
      valid_action: false,
      loadingHtml: '',
      monthLists: [],
      // month: this.pDefaultInput.current_month,
      month: this.search && Object.keys(this.search).includes('month') ? String(this.search['month']) : this.pDefaultInput.current_month,
      month_detail: '',
      efficiency_machine: this.pEfficiencyMachinePercent,
      efficiency_product: this.pEfficiencyProductPercent,
      //-----------------------
      lines: [],
      resPlanDate: [],
      efficiencyProducts: [],
      efficiencyFullProducts: [],
      // machineMaintenances: [],
      machineMaintenances: [],
      machineDowntimes: [],
      holidays: [],
      working_hour: [],
      //--------------------
      summary: [],
      summaryProduct: [],
      totalMachineAll: 0,
      totalProductAll: 0,
      totalOmSalesForecast: 0,
      totalProductArr: {},
      //Edit transacyion by line: Efficiency Machines/Res plan date
      lineMachineEdit: {},
      workingHourEdit: {},
      unit: '',
      machineLines: [],
      sel_machine: '',
      sel_month: '',
      html: '',
      machineGroups: [],
      machineDesc: [],
      machineDtLines: [],
      ppMonthly: [],
      adjustHoliday: '',
      saleForecasts: [],
      // Piyawut A. 20211102 
      checkDate: {
        current_date: '',
        start_date: '',
        end_date: ''
      },
      // isDisableBtn: false,
      note_description: '',
      totalFullProductArr: {},
      isControlDisable: false,
      isCurrBiweekly: false,
      efficiencyDayFormula: '',
      efficiencyMachineFormula: '',
      per_unit: '',
      precentHtml: '',
      percentCreate: '',
      holidaysHtml: '',
      lastUpdate: '',
      versions: '',
      totalDayForOmSale: 0,
      omMonth: '',
      // New Requirement : แจ้งเตือน PM Confirm to text
      messageCheckPMHtml: '',
      messageCheckMachineHtml: '',
      // Overview 04/09/2022
      yearlyOverview: '',
      omSaleForcastOverview: '',
      workingH: '',
      onhandYear: '',
      workingDays: ''
    };
  },
  mounted: function mounted() {
    if (this.header) {
      this.getUnitProductType();
      this.getMonth();
      this.selMonth(); // this.getDateByYearly();
    }
  },
  computed: {
    //คำนวณ total EffMachine แต่ละกรุ๊ป
    summaryEfficiencyMachineGroup: function summaryEfficiencyMachineGroup() {
      //BY GROUP
      var result = [];
      Object.values(this.lines).reduce(function (res, value) {
        value.filter(function (val) {
          if (!res[val.machine_group]) {
            res[val.machine_group] = {
              machine_group: val.machine_group,
              efficiency_machine_per_min: 0
            };
            result.push(res[val.machine_group]);
          }

          res[val.machine_group].efficiency_machine_per_min += Number(val.efficiency_machine_per_min);
        });
        return res;
      }, {});
      this.summary = result;
    },
    //เมื่อมีการแก้ไขข้อมูล planDate--คำนวณแต่ละวันของ Machine
    totalEfficiencyProduct: function totalEfficiencyProduct() {
      var vue = this; //efficiency_product

      Object.values(vue.lines).filter(function (lines) {
        Object.values(lines).filter(function (line) {
          vue.resPlanDate.filter(function (planDate) {
            var f = Number(line.efficiency_machine_per_min) * (Number(planDate.working_hour) - 1) * 60;
            var r = Number(f) * (Number(vue.efficiency_product) / 100) / 1000000;
            var t = r <= 0 ? 0 : r;
            var resT = 0;
            var resFT = 0;

            if (vue.machineDowntimes[planDate.res_plan_date_display][line.machine_name] == 'Y' || vue.machineMaintenances[planDate.res_plan_date_display][line.machine_name] == 'Y') {
              t = t * 0;
            } // vue.efficiencyProducts[planDate.res_plan_date_display][line.machine_name] = t;


            resT = Math.floor(Number(t) * 100) / 100;
            vue.efficiencyProducts[planDate.res_plan_date_display][line.machine_name] = resT; // เพิ่ม efficiency full product 100% -- 20112021

            var fr = Number(f) * (100 / 100) / 1000000;
            var ft = fr <= 0 ? 0 : fr;

            if (vue.machineDowntimes[planDate.res_plan_date_display][line.machine_name] == 'Y' || vue.machineMaintenances[planDate.res_plan_date_display][line.machine_name] == 'Y') {
              ft = ft * 0;
            } // vue.efficiencyFullProducts[planDate.res_plan_date_display][line.machine_name] = ft;


            resFT = Math.floor(Number(ft) * 100) / 100;
            vue.efficiencyFullProducts[planDate.res_plan_date_display][line.machine_name] = resFT;
          });
        });
      });
    },
    summaryEfficiencyProduct: function summaryEfficiencyProduct() {
      var vue = this;
      var result = [];
      Object.keys(vue.efficiencyProducts).reduce(function (res, planDate) {
        Object.values(vue.lines).filter(function (lines) {
          Object.values(lines).filter(function (line) {
            if (!res[planDate]) {
              res[planDate] = {
                plan_date: planDate,
                total: 0
              };
              result.push(res[planDate]);
            }

            if (vue.machineMaintenances[planDate][line.machine_name] == 'Y' || vue.machineDowntimes[planDate][line.machine_name] == 'Y') {
              res[planDate].total += 0;
            } else {
              res[planDate].total += Number(vue.efficiencyProducts[planDate][line.machine_name]);
            }
          });
        });
        return res;
      }, {});
      vue.summaryProduct = result;
    },
    summaryTotalEfficiencyProductAll: function summaryTotalEfficiencyProductAll() {
      var vue = this;
      var total = 0;
      vue.summaryProduct.filter(function (line) {
        total += Number(line.total);
      });
      vue.totalProductAll = total;
    },
    summaryTotalEfficiencyMachineAll: function summaryTotalEfficiencyMachineAll() {
      var vue = this;
      var total = 0;
      vue.summary.filter(function (line) {
        total += Number(line.efficiency_machine_per_min);
      });
      vue.totalMachineAll = total;
    },
    summaryOmSaleForcastTotal: function summaryOmSaleForcastTotal() {
      var vue = this;
      var total = 0;
      vue.saleForecasts.filter(function (line) {
        total += Number(line.forecast_million_qty);
      });
      vue.totalOmSalesForecast = total;
    }
  },
  watch: {
    summaryEfficiencyMachineGroup: function summaryEfficiencyMachineGroup(newValue) {
      return newValue;
    },
    totalEfficiencyProduct: function totalEfficiencyProduct(newValue) {
      return newValue;
    },
    summaryEfficiencyProduct: function summaryEfficiencyProduct(newValue) {
      return newValue;
    },
    summaryTotalEfficiencyProductAll: function summaryTotalEfficiencyProductAll(newValue) {
      return newValue;
    },
    summaryTotalEfficiencyMachineAll: function summaryTotalEfficiencyMachineAll(newValue) {
      return newValue;
    },
    summaryOmSaleForcastTotal: function summaryOmSaleForcastTotal(newValue) {
      return newValue;
    },
    pEditFlag: function () {
      var _pEditFlag = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee(newValue) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                this.edit_flag = newValue;

              case 1:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this);
      }));

      function pEditFlag(_x) {
        return _pEditFlag.apply(this, arguments);
      }

      return pEditFlag;
    }(),
    pShowFlag: function () {
      var _pShowFlag = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2(newValue) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                this.show_flag = newValue;

              case 1:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, this);
      }));

      function pShowFlag(_x2) {
        return _pShowFlag.apply(this, arguments);
      }

      return pShowFlag;
    }()
  },
  methods: {
    decimal: function decimal(number) {
      return Number(number).toLocaleString(undefined, {
        minimumFractionDigits: 2
      });
    },
    covertName: function covertName(machineGroup) {
      return this.lines[machineGroup][0].machine_group_description;
    },
    getMonth: function getMonth() {
      if (this.budgetYear == '') {
        this.month = '';
      }

      this.monthLists = this.pSearchInput.months;
    },
    selMonth: function selMonth() {
      var _this = this;

      if (this.month == null) {
        this.month_detail = '';
        return;
      }

      this.monthDetails.filter(function (item) {
        if (item.period_num == _this.month) {
          _this.sel_month = item.thai_month;
          _this.month_detail = item.thai_full_date;
        }
      });
      this.getMachineDetail();
    },
    getMachineDetail: function getMachineDetail() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                vm = _this2;
                vm.valid = true;
                vm.lines = [];
                vm.resPlanDate = [];
                vm.efficiencyProducts = [];
                vm.eamPerformanceMachines = [];
                vm.machineMaintenances = [];
                vm.machineDowntimes = [];
                vm.holidays = [];
                vm.working_hour = [];
                vm.loadingHtml = '\ <div class="m-t-lg m-b-lg">\
                            <div class="text-center sk-spinner sk-spinner-wave">\
                                <div class="sk-rect1"></div>\
                                <div class="sk-rect2"></div>\
                                <div class="sk-rect3"></div>\
                                <div class="sk-rect4"></div>\
                                <div class="sk-rect5"></div>\
                            </div>\
                        </div>';
                _context3.next = 13;
                return axios.post(vm.url.get_machine_detail, {
                  budget_year: vm.budgetYear,
                  month: vm.month,
                  product_type: vm.productType
                }).then(function (res) {
                  console.log(res.data);

                  if (res.data.status == 'S') {
                    vm.header = res.data.header; // vm.note_description = res.data.header.note_description;

                    vm.lines = res.data.lines;
                    vm.month = res.data.month;
                    vm.resPlanDate = res.data.resPlanDate;
                    vm.efficiencyProducts = res.data.efficiencyProducts;
                    vm.eamPerformanceMachines = res.data.eamPerformanceMachines;
                    vm.machineMaintenances = res.data.machineMaintenances;
                    vm.machineDowntimes = res.data.machineDowntimes;
                    vm.holidays = res.data.holidays;
                    vm.html = res.data.html;
                    vm.machineGroups = res.data.machineGroups;
                    vm.machineDesc = res.data.machineName;
                    vm.ppMonthly = res.data.ppMonthly;
                    vm.machineDtLines = res.data.machineDtLines;
                    vm.efficiencyFullProducts = res.data.efficiencyFullProducts;
                    vm.adjustHoliday = res.data.adjustHoliday;
                    vm.saleForecasts = res.data.saleForecasts;
                    vm.getWorkingHour(res.data.workingHour);
                    vm.precentHtml = res.data.precentHtml;
                    vm.percentCreate = res.data.percentCreate;
                    vm.holidaysHtml = res.data.holidaysHtml;
                    vm.lastUpdate = res.data.lastUpdateFormat;
                    vm.versions = res.data.versions;
                    vm.totalDayForOmSale = res.data.totalDayForOmSale;
                    vm.omMonth = res.data.omMonth;
                    vm.url = res.data.url;
                    vm.yearlyOverview = res.data.yearlyOverview;
                    vm.omSaleForcastOverview = res.data.omSaleForcastOverview;
                    vm.workingH = res.data.workingH;
                    vm.onhandYear = res.data.onhandYear;
                    vm.workingDays = res.data.workingDays; // Alert ปรับเปลี่ยนวันหยุดประจำปี 13032022

                    if (vm.adjustHoliday && vm.percentCreate == 100) {
                      swal({
                        title: 'ปรับเปลี่ยนวันหยุดประจำปี',
                        text: '<span style="font-size: 16px; text-align: left;"> มีการปรับเปลี่ยนวันหยุดประจำปี โปรดตรวจสอบ</span>',
                        type: "warning",
                        html: true
                      });
                    }

                    _this2.getDateByYearly(); // get check PM/Machine


                    if (!vm.isControlDisable && vm.isCurrBiweekly && vm.percentCreate == 100) {
                      vm.checkPMConfirm();
                      vm.checkMachineDetail();
                    }
                  }
                })["catch"](function (err) {
                  swal({
                    title: 'มีข้อผิดพลาด',
                    text: '<span style="font-size: 16px; text-align: left;">' + err.message + '</span>',
                    type: "warning",
                    html: true
                  });
                }).then(function () {
                  vm.loadingHtml = '';
                  vm.valid = false;
                });

              case 13:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    changeEfficiencyMachineByLine: function changeEfficiencyMachineByLine(machineGroup, index) {
      var vue = this; //efficiency_machine_per_min

      var d = Number(vue.lines[machineGroup][index].machine_speed) * (Number(vue.lines[machineGroup][index].machine_eamperformance) / 100); //efficiency_product

      vue.resPlanDate.filter(function (planDate) {
        var f = Number(d) * (Number(planDate.working_hour) - 1) * 60;
        var r = Number(f) * (Number(vue.efficiency_product) / 100) / 1000000; // this.result = Number(r.toFixed(3));

        var t = r <= 0 ? 0 : r;
        Object.values(vue.efficiencyProducts[planDate.res_plan_date_display]).filter(function (res, value) {
          // vue.efficiencyProducts[planDate.res_plan_date_display][vue.lines[machineGroup][index].machine_name] = Number(t.toFixed(3));
          vue.efficiencyProducts[planDate.res_plan_date_display][vue.lines[machineGroup][index].machine_name] = Math.floor(Number(t) * 100) / 100;
          ;
        });
      }); //result

      vue.lines[machineGroup][index].efficiency_machine_per_min = d; //Stamp line ที่มีการแก้ไขจำนวน Efficiency

      Vue.set(vue.lineMachineEdit, vue.lines[machineGroup][index].machine_name, Number(vue.lines[machineGroup][index].machine_eamperformance));
    },
    // FOR C/E -- PTPP_MACHINE_BIWEEKLY_LINES อัพเดตทั้งสองค่าของระดับไลน์
    updateDataEfficiencyMachineByLine: function updateDataEfficiencyMachineByLine() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        var res;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                _this3.loading = _this3.valid = true;
                _context4.next = 3;
                return _this3.updateMachineLineTransactions();

              case 3:
                res = _context4.sent;

                if (res.status == 'S') {
                  swal({
                    title: 'เปลี่ยนแปลงข้อมูล',
                    text: '<span style="font-size: 16px; text-align: left;"> ทำการเปลี่ยนแปลงวันที่แพลนและประสิทธิภาพเครื่องจักรเรียบร้อยแล้ว </span>',
                    type: "success",
                    html: true
                  });
                  _this3.loading = _this3.valid = false; //redirect

                  window.setTimeout(function () {
                    // window.location.reload();
                    window.location.href = res.redirect_show_page;
                  }, 2000);
                } else if (res.status == 'W') {
                  _this3.edit_flag = false;
                  swal({
                    title: 'เปลี่ยนแปลงข้อมูล',
                    text: '<span style="font-size: 16px; text-align: left;"> ไม่มีการเปลี่ยนแปลงข้อมูล </span>',
                    type: "info",
                    html: true
                  });
                } else {
                  swal({
                    title: 'มีข้อผิดพลาด',
                    text: '<span style="font-size: 16px; text-align: left;">' + res.msg + '</span>',
                    type: "warning",
                    html: true
                  });
                }

              case 5:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    updateMachineLineTransactions: function updateMachineLineTransactions() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        var data;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                data = [];
                _context5.next = 3;
                return axios.post("/planning/machine-yearly/" + _this4.header.res_plan_h_id + "/update-lines", {
                  lineMachines: _this4.lineMachineEdit,
                  workingHours: _this4.workingHourEdit,
                  note: _this4.note_description
                }).then(function (res) {
                  data = res.data;
                })["catch"](function (err) {
                  var msg = err.response.data;
                  swal({
                    title: 'มีข้อผิดพลาด',
                    text: msg.message,
                    type: "error"
                  });
                }).then(function () {
                  _this4.loading = _this4.valid = false;
                });

              case 3:
                return _context5.abrupt("return", data);

              case 4:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    // FOR G -- PTPP_MACHINE_BIWEEKLY_HEADERS 
    updateDataEfficiencyProduct: function updateDataEfficiencyProduct() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6() {
        var res;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                if (!_this5.valid_action) {
                  _context6.next = 3;
                  break;
                }

                swal({
                  title: 'บันทึกหรือยกเลิกการเปลี่ยนแปลงข้อมูล',
                  text: '<span style="font-size: 16px; text-align: left;"> กรุณาทำการบันทึกหรือยกเลิกการเปลี่ยนแปลงให้เรียบร้อย </span>',
                  type: "warning",
                  html: true
                });
                return _context6.abrupt("return");

              case 3:
                _this5.loading = _this5.valid = true;
                _context6.next = 6;
                return _this5.updateMachineTransactions({
                  efficiency_product: _this5.efficiency_product,
                  machine_eamperformance: null,
                  budget_year: _this5.search.budget_year,
                  product_type: _this5.search.product_type,
                  period_num: _this5.month
                });

              case 6:
                res = _context6.sent;

                if (res.status == 'S') {
                  swal({
                    title: 'เปลี่ยนแปลงสั่งผลิต (%)',
                    text: '<span style="font-size: 16px; text-align: left;"> ทำการเปลี่ยนแปลงสั่งผลิตเรียบร้อยแล้ว </span>',
                    type: "success",
                    html: true
                  });
                  _this5.loading = _this5.valid = false; //redirect

                  window.setTimeout(function () {
                    window.location.reload();
                  }, 2000);
                } else {
                  swal({
                    title: 'มีข้อผิดพลาด',
                    text: '<span style="font-size: 16px; text-align: left;">' + res.msg + '</span>',
                    type: "warning",
                    html: true
                  });
                }

              case 8:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      }))();
    },
    // FOR C -- PTPP_MACHINE_BIWEEKLY_HEADERS 
    updateDataEfficiencyMachine: function updateDataEfficiencyMachine() {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee7() {
        var res;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                if (!_this6.valid_action) {
                  _context7.next = 3;
                  break;
                }

                swal({
                  title: 'บันทึกหรือยกเลิกการเปลี่ยนแปลงข้อมูล',
                  text: '<span style="font-size: 16px; text-align: left;"> กรุณาทำการบันทึกหรือยกเลิกการเปลี่ยนแปลงให้เรียบร้อย </span>',
                  type: "warning",
                  html: true
                });
                return _context7.abrupt("return");

              case 3:
                _this6.loading = _this6.valid = true;
                _context7.next = 6;
                return _this6.updateMachineTransactions({
                  efficiency_product: null,
                  machine_eamperformance: _this6.efficiency_machine,
                  budget_year: _this6.search.budget_year,
                  product_type: _this6.search.product_type,
                  period_num: _this6.month
                });

              case 6:
                res = _context7.sent;

                if (res.status == 'S') {
                  swal({
                    title: 'เปลี่ยนแปลงประสิทธิภาพเครื่องจักร (%)',
                    text: '<span style="font-size: 16px; text-align: left;"> ทำการเปลี่ยนแปลงประสิทธิภาพเครื่องจักรเรียบร้อยแล้ว </span>',
                    type: "success",
                    html: true
                  });
                  _this6.loading = _this6.valid = false; //redirect

                  window.setTimeout(function () {
                    window.location.reload();
                  }, 2000);
                } else {
                  swal({
                    title: 'มีข้อผิดพลาด',
                    text: '<span style="font-size: 16px; text-align: left;">' + res.msg + '</span>',
                    type: "warning",
                    html: true
                  });
                }

              case 8:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7);
      }))();
    },
    updateMachineTransactions: function updateMachineTransactions(value) {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee8() {
        var data;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee8$(_context8) {
          while (1) {
            switch (_context8.prev = _context8.next) {
              case 0:
                data = [];
                _context8.next = 3;
                return axios.post("/planning/machine-yearly/" + _this7.header.res_plan_h_id + "/update", value).then(function (res) {
                  data = res.data;
                })["catch"](function (err) {
                  var msg = err.response.data;
                  swal({
                    title: 'มีข้อผิดพลาด',
                    text: msg.message,
                    type: "error"
                  });
                }).then(function () {
                  _this7.loading = _this7.valid = false;
                });

              case 3:
                return _context8.abrupt("return", data);

              case 4:
              case "end":
                return _context8.stop();
            }
          }
        }, _callee8);
      }))();
    },
    getUnitProductType: function getUnitProductType() {
      if (this.header) {
        if (this.header.product_type == '71' || this.header.product_type == '78') {
          this.unit = 'ล้านมวน';
          this.per_unit = 'มวน';
        } else {
          this.unit = 'ล้านชิ้น';
          this.per_unit = 'ชิ้น';
        }

        this.efficiencyDayFormula = 'กำลังผลิตเครื่องจักรรายวัน = ผลผลิตตามประสิทธิภาพต่อนาที(' + this.per_unit + ')*[(จำนวนชั่วโมงการทำงานแต่ละวัน - 1 ชั่วโมงเซตอัพเครื่องจักร) * 60 นาที]';
        this.efficiencyMachineFormula = 'ความเร็วเครื่องจักรต่อนาที(' + this.per_unit + ') * ประสิทธิภาพเครื่องจักร(%)';
      }
    },
    getWorkingHour: function getWorkingHour(res) {
      var _this8 = this;

      res.filter(function (item) {
        _this8.working_hour.push({
          attribute1: Number(item.attribute1),
          lookup_code: item.lookup_code,
          meaning: item.meaning
        });
      });
    },
    checkUpdatePlanPM: function checkUpdatePlanPM() {
      var _this9 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee9() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee9$(_context9) {
          while (1) {
            switch (_context9.prev = _context9.next) {
              case 0:
                vm = _this9;

                if (!vm.valid_action) {
                  _context9.next = 4;
                  break;
                }

                swal({
                  title: 'บันทึกหรือยกเลิกการเปลี่ยนแปลงข้อมูล',
                  text: '<span style="font-size: 16px; text-align: left;"> กรุณาทำการบันทึกหรือยกเลิกการเปลี่ยนแปลงให้เรียบร้อย </span>',
                  type: "warning",
                  html: true
                });
                return _context9.abrupt("return");

              case 4:
                swal({
                  html: true,
                  title: 'เปลี่ยนแปลงแผนซ่อมบำรุง',
                  text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการอัพเดตการเปลี่ยนแปลงแผนซ่อมบำรุง ? </span></h2>',
                  showCancelButton: true,
                  confirmButtonText: vm.btnTrans.ok.text,
                  cancelButtonText: vm.btnTrans.cancel.text,
                  confirmButtonClass: vm.btnTrans.ok["class"] + ' btn-lg tw-w-25',
                  cancelButtonClass: vm.btnTrans.cancel["class"] + ' btn-lg tw-w-25',
                  closeOnConfirm: false,
                  closeOnCancel: true,
                  showLoaderOnConfirm: true
                }, function (isConfirm) {
                  if (isConfirm) {
                    vm.updatePlanPM();
                  }

                  vm.loading = false;
                });

              case 5:
              case "end":
                return _context9.stop();
            }
          }
        }, _callee9);
      }))();
    },
    updatePlanPM: function updatePlanPM() {
      var _this10 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee10() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee10$(_context10) {
          while (1) {
            switch (_context10.prev = _context10.next) {
              case 0:
                vm = _this10;
                vm.loading = vm.valid = true;
                _context10.next = 4;
                return axios.post(vm.url.update_plan_pm, {
                  budget_year: vm.budgetYear,
                  month: vm.month,
                  product_type: vm.productType
                }).then(function (res) {
                  swal({
                    title: 'เปลี่ยนแปลงแผนซ่อมบำรุง',
                    text: '<span style="font-size: 16px; text-align: left;"> อัพเดตการเปลี่ยนแปลงแผนซ่อมบำรุงภายในเดือน ' + vm.sel_month + ' เรียบร้อยแล้ว </span>',
                    type: "success",
                    html: true
                  }); //redirect

                  window.setTimeout(function () {
                    window.location.href = res.data.redirect_show_page;
                  }, 500);
                })["catch"](function (err) {
                  var data = err.response.data;
                  swal({
                    title: 'มีข้อผิดพลาด',
                    text: '<span style="font-size: 16px; text-align: left;">' + data.message + '</span>',
                    type: "error",
                    html: true
                  });
                }).then(function () {
                  vm.loading = vm.valid = true;
                });

              case 4:
              case "end":
                return _context10.stop();
            }
          }
        }, _callee10);
      }))();
    },
    selMachine: function selMachine(machineName) {// this.sel_machine = machineName;
    },
    getDateByYearly: function getDateByYearly() {
      var _this11 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee11() {
        var vm, date_from, date_to, curr_date, currentDate, startDate, endDate;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee11$(_context11) {
          while (1) {
            switch (_context11.prev = _context11.next) {
              case 0:
                vm = _this11;
                date_from = vm.ppMonthly.start_date;
                date_to = vm.ppMonthly.end_date;
                curr_date = moment__WEBPACK_IMPORTED_MODULE_1___default()().format('YYYY-MM-DD');
                _context11.next = 6;
                return helperDate.parseToDateTh(curr_date, 'YYYY-MM-DD');

              case 6:
                currentDate = _context11.sent;
                _context11.next = 9;
                return helperDate.parseToDateTh(date_from, 'YYYY-MM-DD');

              case 9:
                startDate = _context11.sent;
                _context11.next = 12;
                return helperDate.parseToDateTh(date_to, 'YYYY-MM-DD');

              case 12:
                endDate = _context11.sent;
                // วันที่ที่ใช้ในการเช็คเงื่อนไข
                vm.checkDate.current_date = curr_date;
                vm.checkDate.start_date = moment__WEBPACK_IMPORTED_MODULE_1___default()(date_from).format('YYYY-MM-DD');
                vm.checkDate.end_date = moment__WEBPACK_IMPORTED_MODULE_1___default()(date_to).format('YYYY-MM-DD');
                vm.isControlDisable = false;
                vm.isCurrBiweekly = false; //check การแสดงปุ่ม
                //check disable process

                if (vm.checkDate.current_date > vm.checkDate.start_date && vm.checkDate.current_date > vm.checkDate.end_date) {
                  vm.isControlDisable = true;
                } // check current biweekly


                if (vm.checkDate.current_date >= vm.checkDate.start_date && vm.checkDate.current_date <= vm.checkDate.end_date || vm.checkDate.current_date < vm.checkDate.start_date && vm.checkDate.current_date < vm.checkDate.end_date) {
                  vm.isCurrBiweekly = true;
                }

              case 20:
              case "end":
                return _context11.stop();
            }
          }
        }, _callee11);
      }))();
    },
    editProcess: function editProcess(editFlag) {
      var vm = this;
      vm.valid_action = editFlag;
      vm.note_description = this.header.note_description;
      vm.$emit('updateEditFlag', editFlag);
    },
    checkUpdateMachine: function checkUpdateMachine() {
      var _this12 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee12() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee12$(_context12) {
          while (1) {
            switch (_context12.prev = _context12.next) {
              case 0:
                vm = _this12;

                if (!vm.valid_action) {
                  _context12.next = 4;
                  break;
                }

                swal({
                  title: 'บันทึกหรือยกเลิกการเปลี่ยนแปลงข้อมูล',
                  text: '<span style="font-size: 16px; text-align: left;"> กรุณาทำการบันทึกหรือยกเลิกการเปลี่ยนแปลงให้เรียบร้อย </span>',
                  type: "warning",
                  html: true
                });
                return _context12.abrupt("return");

              case 4:
                vm.loading = true;
                swal({
                  html: true,
                  title: 'อัพเดตรายละเอียดเครื่องจักร',
                  text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการอัพเดตรายละเอียดเครื่องจักร ? </span></h2>',
                  showCancelButton: true,
                  confirmButtonText: vm.btnTrans.ok.text,
                  cancelButtonText: vm.btnTrans.cancel.text,
                  confirmButtonClass: vm.btnTrans.ok["class"] + ' btn-lg tw-w-25',
                  cancelButtonClass: vm.btnTrans.cancel["class"] + ' btn-lg tw-w-25',
                  closeOnConfirm: false,
                  closeOnCancel: true,
                  showLoaderOnConfirm: true
                }, function (isConfirm) {
                  if (isConfirm) {
                    vm.updateMachine();
                  }

                  vm.loading = false;
                });

              case 6:
              case "end":
                return _context12.stop();
            }
          }
        }, _callee12);
      }))();
    },
    updateMachine: function updateMachine() {
      var _this13 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee13() {
        var vm, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee13$(_context13) {
          while (1) {
            switch (_context13.prev = _context13.next) {
              case 0:
                vm = _this13;
                params = {
                  budget_year: vm.header.budget_year,
                  month: vm.header.period_num
                };
                _context13.next = 4;
                return axios.post(vm.url.update_machine_p01, {
                  params: params
                }).then(function (res) {
                  var valid = true;

                  if (res.data.status == 'S') {
                    vm.loading = false;
                    swal({
                      title: 'อัพเดตรายละเอียดเครื่องจักร',
                      text: '<span style="font-size: 16px; text-align: left;"> อัพเดตรายละเอียดเครื่องจักรเรียบร้อย </span>',
                      type: "success",
                      html: true
                    }); //redirect

                    window.setTimeout(function () {
                      window.location.reload();
                    }, 500);
                  } else {
                    valid = false;
                    swal({
                      title: 'มีข้อผิดพลาด',
                      text: '<span style="font-size: 16px; text-align: left;">' + res.data.msg + '</span>',
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
                  vm.loading = false;
                });

              case 4:
              case "end":
                return _context13.stop();
            }
          }
        }, _callee13);
      }))();
    },
    checkPMConfirm: function checkPMConfirm() {
      var _this14 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee14() {
        var vm, valid, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee14$(_context14) {
          while (1) {
            switch (_context14.prev = _context14.next) {
              case 0:
                vm = _this14;
                valid = true;
                params = {
                  month: vm.month
                };
                _context14.next = 5;
                return axios.get(vm.url.check_pm_confirm_p01, {
                  params: params
                }).then(function (res) {
                  vm.loading = false;

                  if (res.data.status == 'S') {
                    vm.messageCheckPMHtml = res.data.msg;
                  } else {
                    valid = false;
                    swal({
                      title: 'มีข้อผิดพลาด',
                      text: '<span style="font-size: 16px; text-align: left;">' + res.data.msg + '</span>',
                      type: "warning",
                      html: true
                    });

                    if (!valid) {
                      return;
                    }
                  }
                })["catch"](function (err) {
                  vm.loading = false;
                  swal({
                    title: 'มีข้อผิดพลาด',
                    text: '<span style="font-size: 16px; text-align: left;">' + err + '</span>',
                    type: "warning",
                    html: true
                  });
                }).then(function () {
                  vm.loading = false;
                });

              case 5:
              case "end":
                return _context14.stop();
            }
          }
        }, _callee14);
      }))();
    },
    checkMachineDetail: function checkMachineDetail() {
      var _this15 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee15() {
        var vm, valid;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee15$(_context15) {
          while (1) {
            switch (_context15.prev = _context15.next) {
              case 0:
                vm = _this15;
                valid = true;
                _context15.next = 4;
                return axios.get(vm.url.check_machine_detail_p01).then(function (res) {
                  vm.loading = false;

                  if (res.data.status == 'S') {
                    vm.messageCheckMachineHtml = res.data.msg;
                  } else {
                    valid = false;
                    swal({
                      title: 'มีข้อผิดพลาด',
                      text: '<span style="font-size: 16px; text-align: left;">' + res.data.msg + '</span>',
                      type: "warning",
                      html: true
                    });

                    if (!valid) {
                      return;
                    }
                  }
                })["catch"](function (err) {
                  vm.loading = false;
                  swal({
                    title: 'มีข้อผิดพลาด',
                    text: '<span style="font-size: 16px; text-align: left;">' + err + '</span>',
                    type: "warning",
                    html: true
                  });
                }).then(function () {
                  vm.loading = false;
                });

              case 4:
              case "end":
                return _context15.stop();
            }
          }
        }, _callee15);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/MachineList.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/MachineList.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_2__);


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


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["index", "attribute", "header", "machineGroups", "machineDesc", "dateFormat", "listMachineLines", "ppMonthly"],
  data: function data() {
    return {
      loading: false,
      valid: true,
      machineLine: this.attribute,
      machineGroup: this.attribute.machine_group,
      machineDescription: this.attribute.machine_desc,
      enable: this.attribute.is_enable,
      inputDateFrom: '',
      inputDateTo: '',
      currentDate: '',
      biweeklyDateFrom: '',
      biweeklyDateTo: '',
      isDisableSelDate: false,
      disable_flag: false,
      errors: {
        machine_group: false,
        machine_desc: false // input_date_from: false,
        // input_date_to: false

      },
      machineDescLists: []
    };
  },
  mounted: function mounted() {
    this.getDateByBiWeekly();
  },
  watch: {
    errors: {
      handler: function handler(val) {
        val.machine_group ? this.setError('machine_group') : this.resetError('machine_group');
        val.machine_desc ? this.setError('machine_desc') : this.resetError('machine_desc'); // val.input_date_from? this.setError('input_date_from') : this.resetError('input_date_from');
        // val.input_date_to? this.setError('input_date_to') : this.resetError('input_date_to');
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
    selMachineGroup: function selMachineGroup() {
      var vm = this;
      vm.machineLine.machine_group = vm.machineGroup;
      vm.machineDescription = '';
      vm.machineDescLists = vm.machineDesc.filter(function (item) {
        return item.machine_group == vm.machineGroup;
      });
    },
    selMachineDesc: function selMachineDesc() {
      var vm = this;
      var form = $('#machine-downtime-form');
      vm.valid = true;
      var errorMsg = '';
      vm.errors.machine_desc = false;

      if (vm.machineDescription && vm.inputDateFrom && vm.index >= 1) {
        vm.listMachineLines.filter(function (item, index) {
          console.log(index, vm.index);

          if (index != vm.index) {
            if (item.machine_desc == vm.machineDescription) {
              var start_date = moment__WEBPACK_IMPORTED_MODULE_2___default()(vm.listMachineLines[vm.index].start_date).format('YYYY-MM-DD');
              start_date = vm.changeThToEn(start_date);
              var end_date = moment__WEBPACK_IMPORTED_MODULE_2___default()(vm.listMachineLines[index].end_date).format('YYYY-MM-DD');
              end_date = vm.changeThToEn(end_date);

              if (start_date <= end_date) {
                vm.inputDateFrom = '';
                vm.inputDateTo = '';
              }
            }
          }
        });
      }

      if (!vm.valid) {
        return;
      }

      vm.machineLine.machine_desc = vm.machineDescription;
      return;
    },
    remove: function remove(machineLine) {
      this.$emit("removeRow", machineLine);
    },
    dateWasSelectedFrom: function dateWasSelectedFrom(dateFrom) {
      var vm = this;
      var form = $('#machine-downtime-form');
      vm.errors.start_date = false;
      $(form).find("div[id='el_explode_start_date" + vm.index + "']").html("");
      vm.inputDateFrom = vm.machineLine.start_date = dateFrom ? moment__WEBPACK_IMPORTED_MODULE_2___default()(dateFrom).format(vm.dateFormat) : '';

      if (vm.machineDescription && vm.inputDateFrom && vm.index >= 1) {
        vm.listMachineLines.filter(function (item, index) {
          if (index != vm.index) {
            if (item.machine_desc == vm.machineDescription) {
              var input_date = moment__WEBPACK_IMPORTED_MODULE_2___default()(vm.listMachineLines[vm.index].start_date).format('YYYY-MM-DD');
              input_date = vm.changeThToEn(input_date);
              var start_date = moment__WEBPACK_IMPORTED_MODULE_2___default()(vm.listMachineLines[index].start_date).format('YYYY-MM-DD');
              start_date = vm.changeThToEn(start_date);
              var end_date = moment__WEBPACK_IMPORTED_MODULE_2___default()(vm.listMachineLines[index].end_date).format('YYYY-MM-DD');
              end_date = vm.changeThToEn(end_date);
              console.log(input_date + '---' + start_date + '---' + end_date);

              if (input_date >= start_date && input_date <= end_date) {
                vm.inputDateFrom = vm.machineLine.start_date = null;
                vm.inputDateTo = vm.machineLine.end_date = null;
                swal({
                  title: 'มีข้อผิดพลาด',
                  text: '<span style="font-size: 16px; text-align: left;"> รายละเอียดขอบเขต: ' + item.machine_desc + ' นี้มีการระบุช่วงวันที่นี้แล้ว กรุณาตรวจสอบ </span>',
                  type: "warning",
                  html: true
                });
              }
            }
          }
        });
      }
    },
    dateWasSelectedTo: function dateWasSelectedTo(dateTo) {
      var vm = this;
      var form = $('#machine-downtime-form');
      vm.errors.end_date = false;
      $(form).find("div[id='el_explode_end_date" + vm.index + "']").html("");
      vm.inputDateTo = vm.machineLine.end_date = dateTo ? moment__WEBPACK_IMPORTED_MODULE_2___default()(dateTo).format(vm.dateFormat) : '';

      if (vm.machineDescription && vm.inputDateFrom && vm.index >= 1) {
        vm.listMachineLines.filter(function (item, index) {
          if (index != vm.index) {
            if (item.machine_desc == vm.machineDescription) {
              var input_date = moment__WEBPACK_IMPORTED_MODULE_2___default()(vm.listMachineLines[vm.index].end_date).format('YYYY-MM-DD');
              input_date = vm.changeThToEn(input_date);
              var start_date = moment__WEBPACK_IMPORTED_MODULE_2___default()(vm.listMachineLines[index].start_date).format('YYYY-MM-DD');
              start_date = vm.changeThToEn(start_date);
              var end_date = moment__WEBPACK_IMPORTED_MODULE_2___default()(vm.listMachineLines[index].end_date).format('YYYY-MM-DD');
              end_date = vm.changeThToEn(end_date);
              console.log(input_date + '---' + start_date + '---' + end_date);

              if (input_date >= start_date && input_date <= end_date) {
                vm.inputDateTo = vm.machineLine.end_date = null;
                swal({
                  title: 'มีข้อผิดพลาด',
                  text: '<span style="font-size: 16px; text-align: left;"> รายละเอียดขอบเขต: ' + item.machine_desc + ' นี้มีการระบุช่วงวันที่นี้แล้ว กรุณาตรวจสอบ </span>',
                  type: "warning",
                  html: true
                });
              }
            }
          }
        });
      }
    },
    // ดึงข้อมูลเมื่อกดปรับ
    getDateByBiWeekly: function getDateByBiWeekly() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var vm, date_from, date_to, dt_date_from, dt_date_to, curr_date, currentDate, startDate, endDate, dtStartDate, dtEndDate;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                vm = _this;
                date_from = vm.ppMonthly.start_date;
                date_to = vm.ppMonthly.end_date;
                dt_date_from = vm.machineLine.start_date != '' ? moment__WEBPACK_IMPORTED_MODULE_2___default()(vm.machineLine.start_date).format('YYYY-MM-DD') : vm.ppMonthly.start_date;
                dt_date_to = vm.machineLine.end_date != '' ? moment__WEBPACK_IMPORTED_MODULE_2___default()(vm.machineLine.end_date).format('YYYY-MM-DD') : vm.ppMonthly.end_date;
                curr_date = moment__WEBPACK_IMPORTED_MODULE_2___default()().format('YYYY-MM-DD');
                _context.next = 8;
                return helperDate.parseToDateTh(curr_date, 'YYYY-MM-DD');

              case 8:
                currentDate = _context.sent;
                _context.next = 11;
                return helperDate.parseToDateTh(date_from, 'YYYY-MM-DD');

              case 11:
                startDate = _context.sent;
                _context.next = 14;
                return helperDate.parseToDateTh(date_to, 'YYYY-MM-DD');

              case 14:
                endDate = _context.sent;
                _context.next = 17;
                return helperDate.parseToDateTh(dt_date_from, 'YYYY-MM-DD');

              case 17:
                dtStartDate = _context.sent;
                _context.next = 20;
                return helperDate.parseToDateTh(dt_date_to, 'YYYY-MM-DD');

              case 20:
                dtEndDate = _context.sent;
                // Biweek date
                vm.currentDate = moment__WEBPACK_IMPORTED_MODULE_2___default()(currentDate).format(vm.dateFormat);
                vm.biweeklyDateFrom = moment__WEBPACK_IMPORTED_MODULE_2___default()(startDate).format(vm.dateFormat);
                vm.biweeklyDateTo = moment__WEBPACK_IMPORTED_MODULE_2___default()(endDate).format(vm.dateFormat);
                dtStartDate = moment__WEBPACK_IMPORTED_MODULE_2___default()(dtStartDate).format(vm.dateFormat);
                dtEndDate = moment__WEBPACK_IMPORTED_MODULE_2___default()(dtEndDate).format(vm.dateFormat);
                startDate = moment__WEBPACK_IMPORTED_MODULE_2___default()(startDate).format(vm.dateFormat);
                endDate = moment__WEBPACK_IMPORTED_MODULE_2___default()(endDate).format(vm.dateFormat); // Input date from-to

                vm.inputDateTo = vm.machineLine.end_date = endDate;

                if (vm.machineLine.start_date != '' && vm.machineLine.end_date != '') {
                  vm.inputDateFrom = vm.machineLine.start_date = dtStartDate;
                  vm.inputDateTo = vm.machineLine.end_date = dtEndDate;
                } else if (moment__WEBPACK_IMPORTED_MODULE_2___default()(vm.currentDate).format('YYYY-MM-DD') >= moment__WEBPACK_IMPORTED_MODULE_2___default()(startDate).format('YYYY-MM-DD') && moment__WEBPACK_IMPORTED_MODULE_2___default()(vm.currentDate).format('YYYY-MM-DD') >= moment__WEBPACK_IMPORTED_MODULE_2___default()(endDate).format('YYYY-MM-DD')) {
                  vm.inputDateFrom = vm.machineLine.start_date = startDate;
                } else if (moment__WEBPACK_IMPORTED_MODULE_2___default()(vm.currentDate).format('YYYY-MM-DD') >= moment__WEBPACK_IMPORTED_MODULE_2___default()(startDate).format('YYYY-MM-DD')) {
                  vm.inputDateFrom = vm.machineLine.start_date = vm.currentDate;
                } else {
                  vm.inputDateFrom = vm.machineLine.start_date = startDate;
                }

              case 30:
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
    changeThToEn: function changeThToEn(dateTh) {
      // เปลี่ยน Format และ เปลี่ยน พศ -> คศ
      var vm = this;
      var date = moment__WEBPACK_IMPORTED_MODULE_2___default()(dateTh, 'YYYY-MM-DD');
      date.subtract(543, 'years');
      return date.format('YYYY-MM-DD');
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/ModalHoliday.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/ModalHoliday.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['holidaysHtml', 'lastUpdate', 'budgetYear', 'url'],
  data: function data() {
    return {
      loading: false,
      holHtml: this.holidaysHtml,
      lastDate: this.lastUpdate
    };
  },
  mounted: function mounted() {//
  },
  methods: {
    openModal: function openModal() {
      $('#modal-holiday').modal('show');
    },
    refreshHoliday: function refreshHoliday() {
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
                  budget_year: vm.budgetYear
                };
                _context.next = 5;
                return axios.post(vm.url.refresh_holiday, {
                  params: params
                }).then(function (res) {
                  vm.loading = false;

                  if (res.data.status == 'S') {
                    vm.holHtml = [];
                    vm.holHtml = res.data.holidaysHtml;
                  } else {
                    swal({
                      title: '<span class="mt-2"> มีข้อผิดพลาด </span>',
                      text: '<span style="font-size: 16px; text-align: left;">' + res.data.msg + '</span>',
                      type: "warning",
                      html: true
                    });
                  }
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/ModalMachineDowntime.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/ModalMachineDowntime.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var _MachineList_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./MachineList.vue */ "./resources/js/components/Planning/Machine-Yearly/MachineList.vue");


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



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    MachineList: _MachineList_vue__WEBPACK_IMPORTED_MODULE_3__.default
  },
  props: ['header', 'machineGroups', 'machineDesc', 'btnTrans', 'dateFormat', 'url', 'machineDtLines', 'ppMonthly', 'validAction'],
  data: function data() {
    return {
      loading: false,
      isDisableReduceBtn: false,
      machineLines: [],
      // แสดงวันที่ msg
      msgDate: {
        current_date: '',
        start_date: '',
        end_date: ''
      },
      // วันที่ condition
      checkDate: {
        current_date: '',
        start_date: '',
        end_date: ''
      },
      removeMachineDt: []
    };
  },
  mounted: function mounted() {
    this.getDateByYearly();

    if (this.machineDtLines) {
      this.filterMachineLine();
    }
  },
  methods: {
    // Machine Downtime 28072021
    openModal: function openModal() {
      if (this.validAction) {
        swal({
          title: 'บันทึกหรือยกเลิกการเปลี่ยนแปลงข้อมูล',
          text: '<span style="font-size: 16px; text-align: left;"> กรุณาทำการบันทึกหรือยกเลิกการเปลี่ยนแปลงให้เรียบร้อย </span>',
          type: "warning",
          html: true
        });
        return;
      }

      $('#modal-downtime-machine').modal('show');
    },
    addMachineLine: function addMachineLine() {
      this.machineLines.push({
        id: uuid_v1__WEBPACK_IMPORTED_MODULE_2___default()(),
        line_no: '',
        machine_group: '',
        machine_desc: '',
        start_date: '',
        end_date: '',
        is_enable: false
      });
    },
    filterMachineLine: function filterMachineLine() {
      var _this = this;

      this.machineDtLines.filter(function (line) {
        _this.machineLines.push({
          id: uuid_v1__WEBPACK_IMPORTED_MODULE_2___default()(),
          line_no: line.line_no,
          machine_group: line.machine_group,
          machine_desc: line.machine_description,
          start_date: line.start_date,
          end_date: line.end_date,
          is_enable: true // start_date: moment(line.start_date).format('DD-MM-YYYY'),
          // end_date: moment(line.end_date).format('DD-MM-YYYY'),

        });
      });
    },
    removeLine: function removeLine(machineLine) {
      this.machineLines = this.machineLines.filter(function (item) {
        return item.id != machineLine.id;
      });
      this.removeMachineDt.push(machineLine);
    },
    cancel: function cancel() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this2.machineLines = [];

                if (_this2.machineDtLines) {
                  _this2.filterMachineLine();
                }

              case 2:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    submit: function submit() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var vm, form, valid, msg, res;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                vm = _this3;
                form = $('#machine-downtime-form');
                valid = true;
                msg = '';
                vm.loading = true; // Validate

                if (vm.machineLines.length > 0) {
                  vm.machineLines.filter(function (item, index) {
                    var line_no = index + 1;
                    var start_date = vm.changeTh(moment__WEBPACK_IMPORTED_MODULE_1___default()(item.start_date).format('YYYY-MM-DD'));
                    var end_date = vm.changeTh(moment__WEBPACK_IMPORTED_MODULE_1___default()(item.end_date).format('YYYY-MM-DD'));

                    if (item.machine_group == '' || item.machine_group == null) {
                      valid = false;
                      vm.loading = false;
                      msg = "กรุณาเลือกขอบเขตเครื่องจักร ของรายการที่ " + line_no;
                      swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">' + msg + '</span>',
                        type: "error",
                        html: true
                      });
                    } else if (item.machine_desc == '' || item.machine_desc == null) {
                      valid = false;
                      vm.loading = false;
                      msg = "กรุณาเลือกรายละเอียดเครื่องจักร ของรายการที่ " + line_no;
                      swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">' + msg + '</span>',
                        type: "error",
                        html: true
                      });
                    } else if (item.start_date == '' || item.start_date == null) {
                      valid = false;
                      vm.loading = false;
                      msg = "กรุณาเลือกวันที่เริ่ม ของรายการที่ " + line_no;
                      swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">' + msg + '</span>',
                        type: "error",
                        html: true
                      });
                    } else if (item.end_date == '' || item.end_date == null) {
                      valid = false;
                      vm.loading = false;
                      msg = "กรุณาเลือกวันที่สิ้นสุด ของรายการที่ " + line_no;
                      swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">' + msg + '</span>',
                        type: "error",
                        html: true
                      });
                    } else if (start_date < vm.checkDate.start_date || start_date > vm.checkDate.end_date || end_date < vm.checkDate.start_date || end_date > vm.checkDate.end_date) {
                      msg = 'รายการที่ ' + line_no + ' ช่วงวันที่ที่เลือกไม่อยู่ในช่วงวันที่ของปักษ์ <br> ควรระบุในช่วงวันที่ ' + vm.msgDate.start_date + ' ถึง ' + vm.msgDate.end_date;
                      valid = false;
                      vm.loading = false;
                      swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">' + msg + '</span>',
                        type: "error",
                        html: true
                      });
                    } else if (start_date < vm.checkDate.current_date || end_date < vm.checkDate.current_date) {
                      msg = 'รายการที่ ' + line_no + ' ไม่สามารถเลือกช่วงวันที่ย้อนหลังได้ <br> ควรระบุในช่วงวันที่ ' + vm.msgDate.current_date + ' ถึง ' + vm.msgDate.end_date;
                      valid = false;
                      vm.loading = false;
                      swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">' + msg + '</span>',
                        type: "error",
                        html: true
                      });
                    }
                  });
                }

                if (valid) {
                  _context2.next = 8;
                  break;
                }

                return _context2.abrupt("return");

              case 8:
                _context2.next = 10;
                return _this3.create();

              case 10:
                res = _context2.sent;

                // console.log(res);
                // vm.loading = false;
                if (res.status == 'S') {
                  swal({
                    title: 'ปรับลดกำลังการผลิต',
                    text: '<span style="font-size: 16px; text-align: left;"> ทำการปรับลดกำลังการผลิตเรียบร้อยแล้ว </span>',
                    type: "success",
                    html: true
                  }); //redirect

                  window.setTimeout(function () {
                    window.location.href = res.redirect_show_page;
                  }, 500);
                } else {
                  swal({
                    title: 'มีข้อผิดพลาด',
                    text: '<span style="font-size: 16px; text-align: left;">' + res.msg + '</span>',
                    type: "error",
                    html: true
                  });
                }

              case 12:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    create: function create() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var vm, data, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                vm = _this4;
                data = {
                  status: '',
                  msg: ''
                };
                params = {
                  header: vm.header,
                  machineLines: vm.machineLines,
                  removeMachineDt: vm.removeMachineDt
                };
                _context3.next = 5;
                return axios.post(vm.url.machine_downtime, params).then(function (res) {
                  data.status = res.data.status;
                  data.msg = res.data.msg;
                  data.redirect_show_page = res.data.redirect_show_page;
                })["catch"](function (err) {
                  var msg = err.response.data.data;
                  data.status = 'E';
                  data.msg = msg;
                }).then(function () {
                  vm.loading = false;
                });

              case 5:
                return _context3.abrupt("return", data);

              case 6:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    getDateByYearly: function getDateByYearly() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        var vm, date_from, date_to, curr_date, currentDate, startDate, endDate;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                vm = _this5;
                date_from = vm.ppMonthly.start_date;
                date_to = vm.ppMonthly.end_date;
                curr_date = moment__WEBPACK_IMPORTED_MODULE_1___default()().format('YYYY-MM-DD');
                _context4.next = 6;
                return helperDate.parseToDateTh(curr_date, 'YYYY-MM-DD');

              case 6:
                currentDate = _context4.sent;
                _context4.next = 9;
                return helperDate.parseToDateTh(date_from, 'YYYY-MM-DD');

              case 9:
                startDate = _context4.sent;
                _context4.next = 12;
                return helperDate.parseToDateTh(date_to, 'YYYY-MM-DD');

              case 12:
                endDate = _context4.sent;
                // วันที่ที่ใช้แสดง MSG
                vm.msgDate.current_date = moment__WEBPACK_IMPORTED_MODULE_1___default()(currentDate).format(vm.dateFormat);
                vm.msgDate.start_date = moment__WEBPACK_IMPORTED_MODULE_1___default()(startDate).format(vm.dateFormat);
                vm.msgDate.end_date = moment__WEBPACK_IMPORTED_MODULE_1___default()(endDate).format(vm.dateFormat); // วันที่ที่ใช้ในการเช็คเงื่อนไข

                vm.checkDate.current_date = curr_date;
                vm.checkDate.start_date = moment__WEBPACK_IMPORTED_MODULE_1___default()(date_from).format('YYYY-MM-DD');
                vm.checkDate.end_date = moment__WEBPACK_IMPORTED_MODULE_1___default()(date_to).format('YYYY-MM-DD'); //check การแสดงปุ่มลดการผลิต

                if ((vm.checkDate.current_date <= vm.checkDate.start_date || vm.checkDate.current_date >= vm.checkDate.start_date) && vm.checkDate.current_date <= vm.checkDate.end_date) {
                  vm.isDisableReduceBtn = true;
                }

              case 20:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    changeTh: function changeTh(dateTh) {
      // เปลี่ยน Format และ เปลี่ยน พศ -> คศ
      var date = moment__WEBPACK_IMPORTED_MODULE_1___default()(dateTh, 'YYYY-MM-DD');

      if (date.isValid()) {
        date.subtract(543, 'years');
        console.log(date.format('YYYY-MM-DD'));
        return date.format('YYYY-MM-DD');
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/ModalOverview.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/ModalOverview.vue?vue&type=script&lang=js& ***!
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
/* harmony import */ var _WorkingDays_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./WorkingDays.vue */ "./resources/js/components/Planning/Machine-Yearly/WorkingDays.vue");
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! vue-numeric */ "./node_modules/vue-numeric/dist/vue-numeric.min.js");
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(vue_numeric__WEBPACK_IMPORTED_MODULE_4__);


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




/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    WorkingDays: _WorkingDays_vue__WEBPACK_IMPORTED_MODULE_3__.default,
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_4___default())
  },
  props: ['header', 'yearlyOverview', 'omSaleForcastOverview', 'btnTrans', 'workingHour', 'url', 'onhandYear', 'pWorkingDays'],
  data: function data() {
    return {
      loading: false,
      effMachine: {},
      workingDays: this.pWorkingDays,
      totalEffMachine: {},
      totalEffByMonth: {},
      value: this.onhandYear ? this.onhandYear : 100 // default 100

    };
  },
  mounted: function mounted() {},
  watch: {
    calWorkingDays: function calWorkingDays(newValue) {
      return newValue;
    },
    calTotalEffMonth: function calTotalEffMonth(newValue) {
      return newValue;
    }
  },
  computed: {
    calWorkingDays: function calWorkingDays() {
      var vm = this; // I = [(4*7) + (5*8) + (6*9)] - (J+ H)

      Object.keys(vm.yearlyOverview).filter(function (period) {
        var i = 0;
        vm.workingHour.filter(function (hour, index) {
          var _vm$workingDays;

          var r = (_vm$workingDays = vm.workingDays[period + '|' + hour.lookup_code]) !== null && _vm$workingDays !== void 0 ? _vm$workingDays : 0;
          console.log(r);
          console.log(vm.effMachine[period + '|' + hour.lookup_code]);
          i += Number(r) * Number(vm.effMachine[period + '|' + hour.lookup_code]);

          if (vm.workingHour.length == index + 1) {
            i = i - (Number(vm.omSaleForcastOverview[period][0]) + Number(vm.yearlyOverview[period][0].eam_dt_eff_product));
            Vue.set(vm.totalEffMachine, period, Number(i).toFixed(2));
          }
        });
      });
    },
    calTotalEffMonth: function calTotalEffMonth() {
      var vm = this; //K สิ้นตุลา = B + I ตุลา - J, K สิ้นพย = K สิ้นตุลา + I พย - J

      Object.keys(vm.yearlyOverview).filter(function (period, index) {
        var k = 0;

        if (period == 1) {
          k = vm.value + Number(vm.totalEffMachine[period]) - Number(vm.omSaleForcastOverview[period][0]);
        } else {
          k = Number(vm.totalEffByMonth[index]) + Number(vm.totalEffMachine[period]) - Number(vm.omSaleForcastOverview[period][0]);
        }

        Vue.set(vm.totalEffByMonth, period, Number(k).toFixed(2));
      });
    }
  },
  methods: {
    openModal: function openModal() {
      $('#modal-machine-overview').modal('show');
    },
    calEffMachine: function calEffMachine(period, hour, eff_per_min, percent) {
      var vm = this;
      var result = 0;
      var v_cal = Number(eff_per_min) * (Number(hour) - 1) * 60 / 1000000;
      result = v_cal * (Number(percent) / 100);

      if (period != 0) {
        Vue.set(vm.effMachine, period + '|' + hour, Number(result).toFixed(2));
      }

      return result;
    },
    submit: function submit() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var vm, form, msg, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                vm = _this;
                form = $('#machine-overview-form');
                msg = '';
                vm.loading = true;
                params = {
                  header: vm.header,
                  onhandYear: vm.value,
                  workingDays: vm.workingDays,
                  totalEffMachine: vm.totalEffMachine,
                  totalEffByMonth: vm.totalEffByMonth
                };
                _context.next = 7;
                return axios.post(vm.url.machine_overview_p01, params).then(function (res) {
                  if (res.data.status == 'S') {
                    swal({
                      title: 'ปรับลดกำลังการผลิต',
                      text: '<span style="font-size: 16px; text-align: left;"> ทำการบันทึกการคำนวณภาพรวมการผลิตทั้งปีงบประมาณเรียบร้อยแล้ว </span>',
                      type: "success",
                      html: true
                    });
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

              case 7:
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/OMSalesForecast.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/OMSalesForecast.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["omSalesForecast", "pSaleForecasts", 'versionLists', 'totalDayForOmSale', 'omMonth', 'url'],
  data: function data() {
    return {
      forecast_qty: 0,
      forecast_million_qty: 0,
      loading: false,
      saleForecasts: this.pSaleForecasts ? this.pSaleForecasts : [],
      version_no: this.pSaleForecasts[0] ? this.pSaleForecasts[0].version : 0
    };
  },
  mounted: function mounted() {//
  },
  computed: {
    totalForecast: function totalForecast() {
      var vm = this;
      var total_forecast_qty = 0;
      var total_forecast_million_qty = 0;

      if (vm.pSaleForecasts.length) {
        vm.saleForecasts.filter(function (line) {
          total_forecast_qty += Number(line.forecast_qty);
          total_forecast_million_qty += Number(line.forecast_million_qty);
        });
      }

      vm.forecast_qty = total_forecast_qty;
      vm.forecast_million_qty = total_forecast_million_qty;
    }
  },
  watch: {
    totalForecast: function totalForecast(newValue) {
      return newValue;
    }
  },
  methods: {
    openModal: function openModal() {
      $('#modal-om-sales').modal('show');
    },
    changeVersion: function changeVersion() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var vm, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                //  get data from version
                vm = _this;
                vm.loading = true;
                params = {
                  version: vm.version_no,
                  budget_year: vm.saleForecasts[0].budget_year,
                  month_no: vm.saleForecasts[0].month_no
                };
                _context.next = 5;
                return axios.post(vm.url.get_sales_forecast_version, {
                  params: params
                }).then(function (res) {
                  vm.loading = false;
                  console.log(res.data);

                  if (res.data.status == 'S') {
                    vm.saleForecasts = [];
                    vm.saleForecasts = res.data.saleForecasts;
                  } else {
                    swal({
                      title: '<span class="mt-2"> มีข้อผิดพลาด </span>',
                      text: '<span style="font-size: 16px; text-align: left;">' + res.data.msg + '</span>',
                      type: "warning",
                      html: true
                    });
                  }
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/WorkingDays.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/WorkingDays.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_0__);
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


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_1___default())
  },
  props: ['period', 'workingHour', 'pWorkingDays'],
  data: function data() {
    return {
      oldWorkingDays: '',
      workingDays: this.pWorkingDays,
      value: this.pWorkingDays[this.period + '|' + this.workingHour]
    };
  },
  mounted: function mounted() {
    this.value = this.workingDays[this.period + '|' + this.workingHour];
  },
  methods: {
    changeDays: function changeDays() {
      console.log('qqqq');
      var vm = this;
      console.log(Number(vm.value));
      Vue.set(vm.workingDays, vm.period + '|' + vm.workingHour, vm.value);
      console.log(vm.workingDays);
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/LinesComponent.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/LinesComponent.vue?vue&type=style&index=0&scope=true&lang=css& ***!
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
___CSS_LOADER_EXPORT___.push([module.id, ".sticky-col {\n  position: -webkit-sticky;\n  position: sticky;\n  background-color: #e7eaec;\n  z-index: 9999;\n}\n.first-col {\n  width: 150px;\n  min-width: 100px;\n  max-width: 150px;\n  left: 0px;\n}\n.second-col {\n  width: 150px;\n  min-width: 150px;\n  max-width: 150px;\n  left: 116px;\n  /*left: 150px;*/\n}\n.th-col {\n  width: 250px;\n  min-width: 150px;\n  max-width: 250px;\n  left: 266px;\n  /*left: 250px;*/\n}\n.fo-col {\n  width: 200px;\n  min-width: 150px;\n  max-width: 200px;\n  left: 416px;\n  /*left: 400px;*/\n}\n.fi-col {\n  width: 200px;\n  min-width: 150px;\n  max-width: 200px;\n  left: 566px;\n  /*left: 550px;*/\n}\n.t1-col {\n  width: 200px;\n  min-width: 150px;\n  max-width: 200px;\n  left: 0px;\n}\n.t2-col {\n  width: 200px;\n  min-width: 150px;\n  max-width: 200px;\n  left: 566px;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/MachineList.vue?vue&type=style&index=0&media=screen&lang=css&":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/MachineList.vue?vue&type=style&index=0&media=screen&lang=css& ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, "div.el-dialog__body{\n  padding-left: 50px;\n  padding-right: 50px;\n  padding-top: 5px;\n  padding-bottom: 5px;\n  color: #000;\n  font-size: 15px;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css& ***!
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
___CSS_LOADER_EXPORT___.push([module.id, ".el-input--medium .el-input__inner {\n  height: 30px !important;\n  line-height: 36px;\n}\n.el-input--medium .el-input__icon {\n  line-height: 30px;\n}\n.nav .label, .ibox .label {\n  font-size: 12px;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/LinesComponent.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/LinesComponent.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_LinesComponent_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./LinesComponent.vue?vue&type=style&index=0&scope=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/LinesComponent.vue?vue&type=style&index=0&scope=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_LinesComponent_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_LinesComponent_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/MachineList.vue?vue&type=style&index=0&media=screen&lang=css&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/MachineList.vue?vue&type=style&index=0&media=screen&lang=css& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_MachineList_vue_vue_type_style_index_0_media_screen_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./MachineList.vue?vue&type=style&index=0&media=screen&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/MachineList.vue?vue&type=style&index=0&media=screen&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_MachineList_vue_vue_type_style_index_0_media_screen_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_MachineList_vue_vue_type_style_index_0_media_screen_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_OMSalesForecast_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_OMSalesForecast_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_OMSalesForecast_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/components/Planning/Commons/Machine/DateRangeDetail.vue":
/*!******************************************************************************!*\
  !*** ./resources/js/components/Planning/Commons/Machine/DateRangeDetail.vue ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _DateRangeDetail_vue_vue_type_template_id_6daf3b4a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./DateRangeDetail.vue?vue&type=template&id=6daf3b4a& */ "./resources/js/components/Planning/Commons/Machine/DateRangeDetail.vue?vue&type=template&id=6daf3b4a&");
/* harmony import */ var _DateRangeDetail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./DateRangeDetail.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Commons/Machine/DateRangeDetail.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _DateRangeDetail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _DateRangeDetail_vue_vue_type_template_id_6daf3b4a___WEBPACK_IMPORTED_MODULE_0__.render,
  _DateRangeDetail_vue_vue_type_template_id_6daf3b4a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Commons/Machine/DateRangeDetail.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Commons/Machine/EfficiencyDetail.vue":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/Planning/Commons/Machine/EfficiencyDetail.vue ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _EfficiencyDetail_vue_vue_type_template_id_8f4c8ac0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./EfficiencyDetail.vue?vue&type=template&id=8f4c8ac0& */ "./resources/js/components/Planning/Commons/Machine/EfficiencyDetail.vue?vue&type=template&id=8f4c8ac0&");
/* harmony import */ var _EfficiencyDetail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./EfficiencyDetail.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Commons/Machine/EfficiencyDetail.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _EfficiencyDetail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _EfficiencyDetail_vue_vue_type_template_id_8f4c8ac0___WEBPACK_IMPORTED_MODULE_0__.render,
  _EfficiencyDetail_vue_vue_type_template_id_8f4c8ac0___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Commons/Machine/EfficiencyDetail.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Commons/Machine/EfficiencyMachineComponent.vue":
/*!*****************************************************************************************!*\
  !*** ./resources/js/components/Planning/Commons/Machine/EfficiencyMachineComponent.vue ***!
  \*****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _EfficiencyMachineComponent_vue_vue_type_template_id_709370f6___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./EfficiencyMachineComponent.vue?vue&type=template&id=709370f6& */ "./resources/js/components/Planning/Commons/Machine/EfficiencyMachineComponent.vue?vue&type=template&id=709370f6&");
/* harmony import */ var _EfficiencyMachineComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./EfficiencyMachineComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Commons/Machine/EfficiencyMachineComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _EfficiencyMachineComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _EfficiencyMachineComponent_vue_vue_type_template_id_709370f6___WEBPACK_IMPORTED_MODULE_0__.render,
  _EfficiencyMachineComponent_vue_vue_type_template_id_709370f6___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Commons/Machine/EfficiencyMachineComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Machine-Yearly/LinesComponent.vue":
/*!****************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Yearly/LinesComponent.vue ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _LinesComponent_vue_vue_type_template_id_5f34ab36___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./LinesComponent.vue?vue&type=template&id=5f34ab36& */ "./resources/js/components/Planning/Machine-Yearly/LinesComponent.vue?vue&type=template&id=5f34ab36&");
/* harmony import */ var _LinesComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./LinesComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Machine-Yearly/LinesComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _LinesComponent_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./LinesComponent.vue?vue&type=style&index=0&scope=true&lang=css& */ "./resources/js/components/Planning/Machine-Yearly/LinesComponent.vue?vue&type=style&index=0&scope=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _LinesComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _LinesComponent_vue_vue_type_template_id_5f34ab36___WEBPACK_IMPORTED_MODULE_0__.render,
  _LinesComponent_vue_vue_type_template_id_5f34ab36___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Machine-Yearly/LinesComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Machine-Yearly/MachineList.vue":
/*!*************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Yearly/MachineList.vue ***!
  \*************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _MachineList_vue_vue_type_template_id_0af816bd___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./MachineList.vue?vue&type=template&id=0af816bd& */ "./resources/js/components/Planning/Machine-Yearly/MachineList.vue?vue&type=template&id=0af816bd&");
/* harmony import */ var _MachineList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./MachineList.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Machine-Yearly/MachineList.vue?vue&type=script&lang=js&");
/* harmony import */ var _MachineList_vue_vue_type_style_index_0_media_screen_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./MachineList.vue?vue&type=style&index=0&media=screen&lang=css& */ "./resources/js/components/Planning/Machine-Yearly/MachineList.vue?vue&type=style&index=0&media=screen&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _MachineList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _MachineList_vue_vue_type_template_id_0af816bd___WEBPACK_IMPORTED_MODULE_0__.render,
  _MachineList_vue_vue_type_template_id_0af816bd___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Machine-Yearly/MachineList.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Machine-Yearly/ModalHoliday.vue":
/*!**************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Yearly/ModalHoliday.vue ***!
  \**************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ModalHoliday_vue_vue_type_template_id_74f880e3___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ModalHoliday.vue?vue&type=template&id=74f880e3& */ "./resources/js/components/Planning/Machine-Yearly/ModalHoliday.vue?vue&type=template&id=74f880e3&");
/* harmony import */ var _ModalHoliday_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalHoliday.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Machine-Yearly/ModalHoliday.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _ModalHoliday_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ModalHoliday_vue_vue_type_template_id_74f880e3___WEBPACK_IMPORTED_MODULE_0__.render,
  _ModalHoliday_vue_vue_type_template_id_74f880e3___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Machine-Yearly/ModalHoliday.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Machine-Yearly/ModalMachineDowntime.vue":
/*!**********************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Yearly/ModalMachineDowntime.vue ***!
  \**********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ModalMachineDowntime_vue_vue_type_template_id_0b608e61___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ModalMachineDowntime.vue?vue&type=template&id=0b608e61& */ "./resources/js/components/Planning/Machine-Yearly/ModalMachineDowntime.vue?vue&type=template&id=0b608e61&");
/* harmony import */ var _ModalMachineDowntime_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalMachineDowntime.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Machine-Yearly/ModalMachineDowntime.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _ModalMachineDowntime_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ModalMachineDowntime_vue_vue_type_template_id_0b608e61___WEBPACK_IMPORTED_MODULE_0__.render,
  _ModalMachineDowntime_vue_vue_type_template_id_0b608e61___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Machine-Yearly/ModalMachineDowntime.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Machine-Yearly/ModalOverview.vue":
/*!***************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Yearly/ModalOverview.vue ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ModalOverview_vue_vue_type_template_id_5d383004___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ModalOverview.vue?vue&type=template&id=5d383004& */ "./resources/js/components/Planning/Machine-Yearly/ModalOverview.vue?vue&type=template&id=5d383004&");
/* harmony import */ var _ModalOverview_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalOverview.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Machine-Yearly/ModalOverview.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _ModalOverview_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ModalOverview_vue_vue_type_template_id_5d383004___WEBPACK_IMPORTED_MODULE_0__.render,
  _ModalOverview_vue_vue_type_template_id_5d383004___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Machine-Yearly/ModalOverview.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Machine-Yearly/OMSalesForecast.vue":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Yearly/OMSalesForecast.vue ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _OMSalesForecast_vue_vue_type_template_id_14cb4941___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./OMSalesForecast.vue?vue&type=template&id=14cb4941& */ "./resources/js/components/Planning/Machine-Yearly/OMSalesForecast.vue?vue&type=template&id=14cb4941&");
/* harmony import */ var _OMSalesForecast_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./OMSalesForecast.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Machine-Yearly/OMSalesForecast.vue?vue&type=script&lang=js&");
/* harmony import */ var _OMSalesForecast_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css& */ "./resources/js/components/Planning/Machine-Yearly/OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _OMSalesForecast_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _OMSalesForecast_vue_vue_type_template_id_14cb4941___WEBPACK_IMPORTED_MODULE_0__.render,
  _OMSalesForecast_vue_vue_type_template_id_14cb4941___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Machine-Yearly/OMSalesForecast.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Machine-Yearly/WorkingDays.vue":
/*!*************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Yearly/WorkingDays.vue ***!
  \*************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _WorkingDays_vue_vue_type_template_id_44ea2ee0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./WorkingDays.vue?vue&type=template&id=44ea2ee0& */ "./resources/js/components/Planning/Machine-Yearly/WorkingDays.vue?vue&type=template&id=44ea2ee0&");
/* harmony import */ var _WorkingDays_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./WorkingDays.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Machine-Yearly/WorkingDays.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _WorkingDays_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _WorkingDays_vue_vue_type_template_id_44ea2ee0___WEBPACK_IMPORTED_MODULE_0__.render,
  _WorkingDays_vue_vue_type_template_id_44ea2ee0___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Machine-Yearly/WorkingDays.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Commons/Machine/DateRangeDetail.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Commons/Machine/DateRangeDetail.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_DateRangeDetail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./DateRangeDetail.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/DateRangeDetail.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_DateRangeDetail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Commons/Machine/EfficiencyDetail.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Commons/Machine/EfficiencyDetail.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EfficiencyDetail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./EfficiencyDetail.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/EfficiencyDetail.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EfficiencyDetail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Commons/Machine/EfficiencyMachineComponent.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Commons/Machine/EfficiencyMachineComponent.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EfficiencyMachineComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./EfficiencyMachineComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/EfficiencyMachineComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EfficiencyMachineComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Machine-Yearly/LinesComponent.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Yearly/LinesComponent.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_LinesComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./LinesComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/LinesComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_LinesComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Machine-Yearly/MachineList.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Yearly/MachineList.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MachineList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./MachineList.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/MachineList.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MachineList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Machine-Yearly/ModalHoliday.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Yearly/ModalHoliday.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalHoliday_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalHoliday.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/ModalHoliday.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalHoliday_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Machine-Yearly/ModalMachineDowntime.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Yearly/ModalMachineDowntime.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalMachineDowntime_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalMachineDowntime.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/ModalMachineDowntime.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalMachineDowntime_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Machine-Yearly/ModalOverview.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Yearly/ModalOverview.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalOverview_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalOverview.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/ModalOverview.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalOverview_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Machine-Yearly/OMSalesForecast.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Yearly/OMSalesForecast.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_OMSalesForecast_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./OMSalesForecast.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/OMSalesForecast.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_OMSalesForecast_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Machine-Yearly/WorkingDays.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Yearly/WorkingDays.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_WorkingDays_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./WorkingDays.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/WorkingDays.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_WorkingDays_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Machine-Yearly/LinesComponent.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!************************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Yearly/LinesComponent.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_LinesComponent_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./LinesComponent.vue?vue&type=style&index=0&scope=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/LinesComponent.vue?vue&type=style&index=0&scope=true&lang=css&");


/***/ }),

/***/ "./resources/js/components/Planning/Machine-Yearly/MachineList.vue?vue&type=style&index=0&media=screen&lang=css&":
/*!***********************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Yearly/MachineList.vue?vue&type=style&index=0&media=screen&lang=css& ***!
  \***********************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_MachineList_vue_vue_type_style_index_0_media_screen_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./MachineList.vue?vue&type=style&index=0&media=screen&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/MachineList.vue?vue&type=style&index=0&media=screen&lang=css&");


/***/ }),

/***/ "./resources/js/components/Planning/Machine-Yearly/OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!*************************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Yearly/OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \*************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_OMSalesForecast_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css&");


/***/ }),

/***/ "./resources/js/components/Planning/Commons/Machine/DateRangeDetail.vue?vue&type=template&id=6daf3b4a&":
/*!*************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Commons/Machine/DateRangeDetail.vue?vue&type=template&id=6daf3b4a& ***!
  \*************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_DateRangeDetail_vue_vue_type_template_id_6daf3b4a___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_DateRangeDetail_vue_vue_type_template_id_6daf3b4a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_DateRangeDetail_vue_vue_type_template_id_6daf3b4a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./DateRangeDetail.vue?vue&type=template&id=6daf3b4a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/DateRangeDetail.vue?vue&type=template&id=6daf3b4a&");


/***/ }),

/***/ "./resources/js/components/Planning/Commons/Machine/EfficiencyDetail.vue?vue&type=template&id=8f4c8ac0&":
/*!**************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Commons/Machine/EfficiencyDetail.vue?vue&type=template&id=8f4c8ac0& ***!
  \**************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EfficiencyDetail_vue_vue_type_template_id_8f4c8ac0___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EfficiencyDetail_vue_vue_type_template_id_8f4c8ac0___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EfficiencyDetail_vue_vue_type_template_id_8f4c8ac0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./EfficiencyDetail.vue?vue&type=template&id=8f4c8ac0& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/EfficiencyDetail.vue?vue&type=template&id=8f4c8ac0&");


/***/ }),

/***/ "./resources/js/components/Planning/Commons/Machine/EfficiencyMachineComponent.vue?vue&type=template&id=709370f6&":
/*!************************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Commons/Machine/EfficiencyMachineComponent.vue?vue&type=template&id=709370f6& ***!
  \************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EfficiencyMachineComponent_vue_vue_type_template_id_709370f6___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EfficiencyMachineComponent_vue_vue_type_template_id_709370f6___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EfficiencyMachineComponent_vue_vue_type_template_id_709370f6___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./EfficiencyMachineComponent.vue?vue&type=template&id=709370f6& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/EfficiencyMachineComponent.vue?vue&type=template&id=709370f6&");


/***/ }),

/***/ "./resources/js/components/Planning/Machine-Yearly/LinesComponent.vue?vue&type=template&id=5f34ab36&":
/*!***********************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Yearly/LinesComponent.vue?vue&type=template&id=5f34ab36& ***!
  \***********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_LinesComponent_vue_vue_type_template_id_5f34ab36___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_LinesComponent_vue_vue_type_template_id_5f34ab36___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_LinesComponent_vue_vue_type_template_id_5f34ab36___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./LinesComponent.vue?vue&type=template&id=5f34ab36& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/LinesComponent.vue?vue&type=template&id=5f34ab36&");


/***/ }),

/***/ "./resources/js/components/Planning/Machine-Yearly/MachineList.vue?vue&type=template&id=0af816bd&":
/*!********************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Yearly/MachineList.vue?vue&type=template&id=0af816bd& ***!
  \********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MachineList_vue_vue_type_template_id_0af816bd___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MachineList_vue_vue_type_template_id_0af816bd___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MachineList_vue_vue_type_template_id_0af816bd___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./MachineList.vue?vue&type=template&id=0af816bd& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/MachineList.vue?vue&type=template&id=0af816bd&");


/***/ }),

/***/ "./resources/js/components/Planning/Machine-Yearly/ModalHoliday.vue?vue&type=template&id=74f880e3&":
/*!*********************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Yearly/ModalHoliday.vue?vue&type=template&id=74f880e3& ***!
  \*********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalHoliday_vue_vue_type_template_id_74f880e3___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalHoliday_vue_vue_type_template_id_74f880e3___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalHoliday_vue_vue_type_template_id_74f880e3___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalHoliday.vue?vue&type=template&id=74f880e3& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/ModalHoliday.vue?vue&type=template&id=74f880e3&");


/***/ }),

/***/ "./resources/js/components/Planning/Machine-Yearly/ModalMachineDowntime.vue?vue&type=template&id=0b608e61&":
/*!*****************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Yearly/ModalMachineDowntime.vue?vue&type=template&id=0b608e61& ***!
  \*****************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalMachineDowntime_vue_vue_type_template_id_0b608e61___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalMachineDowntime_vue_vue_type_template_id_0b608e61___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalMachineDowntime_vue_vue_type_template_id_0b608e61___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalMachineDowntime.vue?vue&type=template&id=0b608e61& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/ModalMachineDowntime.vue?vue&type=template&id=0b608e61&");


/***/ }),

/***/ "./resources/js/components/Planning/Machine-Yearly/ModalOverview.vue?vue&type=template&id=5d383004&":
/*!**********************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Yearly/ModalOverview.vue?vue&type=template&id=5d383004& ***!
  \**********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalOverview_vue_vue_type_template_id_5d383004___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalOverview_vue_vue_type_template_id_5d383004___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalOverview_vue_vue_type_template_id_5d383004___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalOverview.vue?vue&type=template&id=5d383004& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/ModalOverview.vue?vue&type=template&id=5d383004&");


/***/ }),

/***/ "./resources/js/components/Planning/Machine-Yearly/OMSalesForecast.vue?vue&type=template&id=14cb4941&":
/*!************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Yearly/OMSalesForecast.vue?vue&type=template&id=14cb4941& ***!
  \************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_OMSalesForecast_vue_vue_type_template_id_14cb4941___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_OMSalesForecast_vue_vue_type_template_id_14cb4941___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_OMSalesForecast_vue_vue_type_template_id_14cb4941___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./OMSalesForecast.vue?vue&type=template&id=14cb4941& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/OMSalesForecast.vue?vue&type=template&id=14cb4941&");


/***/ }),

/***/ "./resources/js/components/Planning/Machine-Yearly/WorkingDays.vue?vue&type=template&id=44ea2ee0&":
/*!********************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Yearly/WorkingDays.vue?vue&type=template&id=44ea2ee0& ***!
  \********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_WorkingDays_vue_vue_type_template_id_44ea2ee0___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_WorkingDays_vue_vue_type_template_id_44ea2ee0___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_WorkingDays_vue_vue_type_template_id_44ea2ee0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./WorkingDays.vue?vue&type=template&id=44ea2ee0& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/WorkingDays.vue?vue&type=template&id=44ea2ee0&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/DateRangeDetail.vue?vue&type=template&id=6daf3b4a&":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/DateRangeDetail.vue?vue&type=template&id=6daf3b4a& ***!
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
  return _c("div", [
    _c("span", [_vm._v(" " + _vm._s(_vm.dateRangeDetail) + " ")])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/EfficiencyDetail.vue?vue&type=template&id=8f4c8ac0&":
/*!*****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/EfficiencyDetail.vue?vue&type=template&id=8f4c8ac0& ***!
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
  return _c("div", [
    _c("h2", { staticClass: "tw-font-bold" }, [
      _vm._v(
        " \n        กำลังการผลิตรวมทั้งปักษ์ : " +
          _vm._s(_vm._f("number2Digit")(_vm.total)) +
          " " +
          _vm._s(_vm.unit) +
          "\n    "
      )
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/EfficiencyMachineComponent.vue?vue&type=template&id=709370f6&":
/*!***************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/EfficiencyMachineComponent.vue?vue&type=template&id=709370f6& ***!
  \***************************************************************************************************************************************************************************************************************************************************************/
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
      !_vm.editFlag
        ? _c("vue-numeric", {
            staticClass: "form-control input-sm text-right",
            attrs: { separator: ",", precision: 2, minus: false, disabled: "" },
            model: {
              value: _vm.line.machine_eamperformance,
              callback: function($$v) {
                _vm.$set(_vm.line, "machine_eamperformance", $$v)
              },
              expression: "line.machine_eamperformance"
            }
          })
        : _c("vue-numeric", {
            staticClass: "form-control input-sm text-right",
            attrs: {
              separator: ",",
              precision: 2,
              minus: false,
              min: 0,
              max: 100
            },
            on: {
              change: function($event) {
                return _vm.changeEfficiencyMachineByLine()
              },
              blur: function($event) {
                return _vm.changeEfficiencyMachineByLine()
              }
            },
            model: {
              value: _vm.line.machine_eamperformance,
              callback: function($$v) {
                _vm.$set(_vm.line, "machine_eamperformance", $$v)
              },
              expression: "line.machine_eamperformance"
            }
          })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/LinesComponent.vue?vue&type=template&id=5f34ab36&":
/*!**************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/LinesComponent.vue?vue&type=template&id=5f34ab36& ***!
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
    _vm.show_flag && _vm.header
      ? _c("div", { staticClass: "row col-lg-12 m-2 pl-1" }, [
          _c(
            "div",
            {
              staticClass:
                "form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2"
            },
            [
              _c("label", { staticClass: "tw-font-bold tw-uppercase mb-1" }, [
                _vm._v(" เดือน ")
              ]),
              _vm._v(" "),
              _c(
                "div",
                [
                  _c(
                    "el-select",
                    {
                      ref: "month",
                      attrs: {
                        size: "medium",
                        placeholder: "เดือน",
                        filterable: "",
                        disabled: _vm.valid_action
                      },
                      on: { change: _vm.selMonth },
                      model: {
                        value: _vm.month,
                        callback: function($$v) {
                          _vm.month = $$v
                        },
                        expression: "month"
                      }
                    },
                    _vm._l(_vm.monthLists, function(month, index) {
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
              )
            ]
          ),
          _vm._v(" "),
          _vm.month_detail && _vm.header
            ? _c(
                "div",
                {
                  staticClass:
                    "form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-6 col-xs-6 mt-2"
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
                      _c("date-range-detail", {
                        attrs: { "date-range-detail": _vm.month_detail }
                      })
                    ],
                    1
                  )
                ]
              )
            : _vm._e()
        ])
      : _vm._e(),
    _vm._v(" "),
    _vm.show_flag
      ? _c(
          "div",
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
            _c("div", { staticClass: "hr-line-dashed" }),
            _vm._v(" "),
            _vm.loadingHtml != ""
              ? [
                  _c("div", {
                    domProps: { innerHTML: _vm._s(_vm.loadingHtml) }
                  })
                ]
              : _vm.precentHtml != "" && _vm.percentCreate < 100
              ? [
                  _c("span", {
                    domProps: { innerHTML: _vm._s(_vm.precentHtml) }
                  })
                ]
              : _vm._e(),
            _vm._v(" "),
            Object.values(_vm.lines).length > 0 && _vm.percentCreate == 100
              ? [
                  _c("div", { staticClass: "row m-2" }, [
                    _c(
                      "div",
                      {
                        staticClass:
                          "col-lg-5 col-md-5 col-sm-4 col-xs-4 mt-2 pl-2"
                      },
                      [
                        _c(
                          "div",
                          { staticClass: "tw-font-bold tw-uppercase mb-1" },
                          [
                            _c("h2", { staticClass: "tw-font-bold" }, [
                              _vm._v(
                                " \n                            กำลังผลิตรวมทั้งเดือน : " +
                                  _vm._s(
                                    _vm._f("number2Digit")(_vm.totalProductAll)
                                  ) +
                                  " " +
                                  _vm._s(_vm.unit) +
                                  "\n                        "
                              )
                            ])
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "tw-font-bold tw-uppercase mt-3" },
                          [
                            _c("h3", { staticStyle: { color: "#898686" } }, [
                              _vm._v(
                                "\n                            ประมาณกำลังผลิตหักประมาณการจำหน่าย : " +
                                  _vm._s(
                                    _vm._f("number2Digit")(
                                      _vm.totalProductAll -
                                        _vm.totalOmSalesForecast
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
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass:
                          "col-lg-7 col-md-7 col-sm-4 col-xs-4 mt-2 text-right"
                      },
                      [
                        _c(
                          "div",
                          { staticClass: "col-12" },
                          [
                            _vm.header
                              ? [
                                  _c(
                                    "div",
                                    { staticClass: "text-right" },
                                    [
                                      Object.values(_vm.lines).length > 0 &&
                                      _vm.percentCreate == 100 &&
                                      _vm.header.product_type != "KK"
                                        ? _c("ModalOverview", {
                                            attrs: {
                                              header: _vm.header,
                                              yearlyOverview:
                                                _vm.yearlyOverview,
                                              omSaleForcastOverview:
                                                _vm.omSaleForcastOverview,
                                              workingHour: _vm.workingH,
                                              onhandYear: _vm.onhandYear,
                                              pWorkingDays: _vm.workingDays,
                                              url: _vm.url,
                                              btnTrans: _vm.btnTrans
                                            }
                                          })
                                        : _vm._e(),
                                      _vm._v(" "),
                                      Object.values(_vm.lines).length > 0 &&
                                      _vm.percentCreate == 100
                                        ? _c("ModalHol", {
                                            attrs: {
                                              holidaysHtml: _vm.holidaysHtml,
                                              lastUpdate: _vm.lastUpdate,
                                              budgetYear:
                                                _vm.header.budget_year,
                                              url: _vm.url
                                            }
                                          })
                                        : _vm._e(),
                                      _vm._v(" "),
                                      _vm.header.product_type != "KK"
                                        ? _c("OMSalesForecast", {
                                            attrs: {
                                              omSalesForecast: _vm.html,
                                              pSaleForecasts: _vm.saleForecasts,
                                              versionLists: _vm.versions,
                                              totalDayForOmSale:
                                                _vm.totalDayForOmSale,
                                              omMonth: _vm.omMonth,
                                              url: _vm.url
                                            }
                                          })
                                        : _vm._e()
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "div",
                                    { staticClass: "text-right" },
                                    [
                                      !_vm.isControlDisable &&
                                      _vm.isCurrBiweekly
                                        ? _c(
                                            "button",
                                            {
                                              staticClass:
                                                "btn btn-warning btn-md",
                                              staticStyle: {
                                                "padding-left": "7px"
                                              },
                                              on: {
                                                click: function($event) {
                                                  $event.preventDefault()
                                                  return _vm.checkUpdateMachine(
                                                    $event
                                                  )
                                                }
                                              }
                                            },
                                            [
                                              _c("i", {
                                                staticClass: "fa fa-calendar"
                                              }),
                                              _vm._v(
                                                " อัปเดตรายละเอียดเครื่องจักร\n                                "
                                              )
                                            ]
                                          )
                                        : _vm._e(),
                                      _vm._v(" "),
                                      !_vm.isControlDisable &&
                                      _vm.isCurrBiweekly
                                        ? _c(
                                            "button",
                                            {
                                              staticClass:
                                                "btn btn-warning btn-md",
                                              staticStyle: {
                                                "padding-left": "7px"
                                              },
                                              on: {
                                                click: function($event) {
                                                  $event.preventDefault()
                                                  return _vm.checkUpdatePlanPM(
                                                    $event
                                                  )
                                                }
                                              }
                                            },
                                            [
                                              _c("i", {
                                                staticClass: "fa fa-calendar"
                                              }),
                                              _vm._v(
                                                " อัปเดตแผนซ่อมบำรุง\n                                "
                                              )
                                            ]
                                          )
                                        : _vm._e(),
                                      _vm._v(" "),
                                      !_vm.isControlDisable &&
                                      _vm.isCurrBiweekly
                                        ? _c("machine-downtime", {
                                            attrs: {
                                              header: _vm.header,
                                              "machine-groups":
                                                _vm.machineGroups,
                                              "machine-desc": _vm.machineDesc,
                                              "btn-trans": _vm.btnTrans,
                                              "date-format": _vm.pDateFormat,
                                              "machine-dt-lines":
                                                _vm.machineDtLines,
                                              "pp-monthly": _vm.ppMonthly,
                                              url: _vm.url,
                                              "valid-action": _vm.valid_action
                                            }
                                          })
                                        : _vm._e()
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _vm.messageCheckMachineHtml &&
                                  !_vm.isControlDisable &&
                                  _vm.isCurrBiweekly
                                    ? _c("div", [
                                        _c(
                                          "h4",
                                          { staticClass: "text-danger mt-3" },
                                          [
                                            _c("div", {
                                              domProps: {
                                                innerHTML: _vm._s(
                                                  _vm.messageCheckMachineHtml
                                                )
                                              }
                                            })
                                          ]
                                        )
                                      ])
                                    : _vm._e(),
                                  _vm._v(" "),
                                  _vm.messageCheckPMHtml &&
                                  !_vm.isControlDisable &&
                                  _vm.isCurrBiweekly
                                    ? _c("div", [
                                        _c(
                                          "h4",
                                          { staticClass: "text-danger mt-3" },
                                          [
                                            _c("div", {
                                              domProps: {
                                                innerHTML: _vm._s(
                                                  _vm.messageCheckPMHtml
                                                )
                                              }
                                            })
                                          ]
                                        )
                                      ])
                                    : _vm._e()
                                ]
                              : _vm._e()
                          ],
                          2
                        )
                      ]
                    )
                  ]),
                  _vm._v(" "),
                  !_vm.messageCheckMachineHtml
                    ? [
                        _c("div", { staticClass: "row m-2" }, [
                          _c(
                            "div",
                            {
                              staticClass:
                                "form-group pl-2 pr-2 mb-0 col-lg-2 col-md-3 col-sm-4 col-xs-4 mt-2"
                            },
                            [
                              _c(
                                "label",
                                {
                                  staticClass: " tw-font-bold tw-uppercase mb-1"
                                },
                                [_vm._v(" ประสิทธิภาพเครื่องจักร(%) ")]
                              ),
                              _vm._v(" "),
                              _c(
                                "div",
                                {},
                                [
                                  _c("vue-numeric", {
                                    staticClass:
                                      "form-control input-sm text-right",
                                    staticStyle: { width: "100%" },
                                    attrs: {
                                      name: "search[efficiency_machine]",
                                      separator: ",",
                                      precision: 2,
                                      minus: false,
                                      min: 0,
                                      max: 100,
                                      disabled:
                                        _vm.isControlDisable ||
                                        !_vm.isCurrBiweekly
                                    },
                                    model: {
                                      value: _vm.efficiency_machine,
                                      callback: function($$v) {
                                        _vm.efficiency_machine = $$v
                                      },
                                      expression: "efficiency_machine"
                                    }
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
                                "form-group pl-2 pr-2 mb-0 col-lg-4 col-md-4 col-sm-4 col-xs-4",
                              staticStyle: { "margin-top": "32px" }
                            },
                            [
                              !_vm.isControlDisable && _vm.isCurrBiweekly
                                ? _c(
                                    "button",
                                    {
                                      staticClass:
                                        "btn btn-success btn-sm text-left",
                                      on: {
                                        click: function($event) {
                                          $event.preventDefault()
                                          return _vm.updateDataEfficiencyMachine(
                                            $event
                                          )
                                        }
                                      }
                                    },
                                    [
                                      _vm._v(
                                        "\n                            ยืนยันเปลี่ยนแปลงประสิทธิภาพเครื่องจักร (%)\n                        "
                                      )
                                    ]
                                  )
                                : _vm._e()
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "div",
                            {
                              staticClass:
                                "form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-4 col-xs-4 mt-2"
                            },
                            [
                              _c(
                                "label",
                                {
                                  staticClass: " tw-font-bold tw-uppercase mb-1"
                                },
                                [_vm._v(" สั่งผลิต(%) ")]
                              ),
                              _vm._v(" "),
                              _c(
                                "div",
                                {},
                                [
                                  _c("vue-numeric", {
                                    staticClass:
                                      "form-control input-sm text-right",
                                    staticStyle: { width: "100%" },
                                    attrs: {
                                      name: "search[efficiency_product]",
                                      separator: ",",
                                      precision: 2,
                                      minus: false,
                                      min: 0,
                                      max: 100,
                                      disabled:
                                        _vm.isControlDisable ||
                                        !_vm.isCurrBiweekly
                                    },
                                    model: {
                                      value: _vm.efficiency_product,
                                      callback: function($$v) {
                                        _vm.efficiency_product = $$v
                                      },
                                      expression: "efficiency_product"
                                    }
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
                                "form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-4 col-xs-4",
                              staticStyle: { "margin-top": "32px" }
                            },
                            [
                              !_vm.isControlDisable && _vm.isCurrBiweekly
                                ? _c(
                                    "button",
                                    {
                                      staticClass: "btn btn-success btn-sm",
                                      on: {
                                        click: function($event) {
                                          $event.preventDefault()
                                          return _vm.updateDataEfficiencyProduct(
                                            $event
                                          )
                                        }
                                      }
                                    },
                                    [
                                      _vm._v(
                                        " \n                            ยืนยันเปลี่ยนแปลงสั่งผลิต (%)\n                        "
                                      )
                                    ]
                                  )
                                : _vm._e()
                            ]
                          )
                        ]),
                        _vm._v(" "),
                        _c("hr"),
                        _vm._v(" "),
                        _c("div", { staticClass: "row" }, [
                          _vm._m(0),
                          _vm._v(" "),
                          _vm.header
                            ? _c(
                                "div",
                                { staticClass: "col-md-4 text-right" },
                                [
                                  !_vm.edit_flag &&
                                  !_vm.isControlDisable &&
                                  _vm.isCurrBiweekly
                                    ? _c(
                                        "button",
                                        {
                                          class:
                                            _vm.btnTrans.edit.class +
                                            " btn-lg tw-w-25",
                                          on: {
                                            click: function($event) {
                                              return _vm.editProcess(
                                                (_vm.edit_flag = !_vm.edit_flag)
                                              )
                                            }
                                          }
                                        },
                                        [
                                          _c("i", {
                                            class: _vm.btnTrans.edit.icon
                                          }),
                                          _vm._v(
                                            " " +
                                              _vm._s(_vm.btnTrans.edit.text) +
                                              "\n                        "
                                          )
                                        ]
                                      )
                                    : _vm._e(),
                                  _vm._v(" "),
                                  _vm.edit_flag
                                    ? _c(
                                        "button",
                                        {
                                          class:
                                            _vm.btnTrans.save.class +
                                            " btn-lg tw-w-25",
                                          on: {
                                            click: function($event) {
                                              $event.preventDefault()
                                              return _vm.updateDataEfficiencyMachineByLine()
                                            }
                                          }
                                        },
                                        [
                                          _c("i", {
                                            class: _vm.btnTrans.save.icon
                                          }),
                                          _vm._v(
                                            " " +
                                              _vm._s(_vm.btnTrans.save.text) +
                                              "\n                        "
                                          )
                                        ]
                                      )
                                    : _vm._e(),
                                  _vm._v(" "),
                                  _vm.edit_flag
                                    ? _c(
                                        "button",
                                        {
                                          class:
                                            _vm.btnTrans.cancel.class +
                                            " btn-lg tw-w-25",
                                          on: {
                                            click: function($event) {
                                              return _vm.editProcess(
                                                (_vm.edit_flag = !_vm.edit_flag)
                                              )
                                            }
                                          }
                                        },
                                        [
                                          _c("i", {
                                            class: _vm.btnTrans.cancel.icon
                                          }),
                                          _vm._v(
                                            " " +
                                              _vm._s(_vm.btnTrans.cancel.text) +
                                              "\n                        "
                                          )
                                        ]
                                      )
                                    : _vm._e()
                                ]
                              )
                            : _vm._e()
                        ]),
                        _vm._v(" "),
                        _c("div", { staticClass: "hr-line-dashed m-1" }),
                        _vm._v(" "),
                        _c("div", { staticClass: "row col-12" }, [
                          _c("div", { staticClass: "col-md-7" }, [
                            _c(
                              "div",
                              {
                                staticClass:
                                  "form-group pl-2 pr-2 mb-0 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-2"
                              },
                              [
                                _c(
                                  "label",
                                  {
                                    staticClass:
                                      " tw-font-bold tw-uppercase mb-1"
                                  },
                                  [_vm._v(" หมายเหตุ ")]
                                ),
                                _vm._v(" "),
                                _c(
                                  "div",
                                  { staticClass: "input-group" },
                                  [
                                    _c("el-input", {
                                      attrs: {
                                        type: "textarea",
                                        rows: 2,
                                        placeholder: "หมายเหตุ",
                                        maxlength: "250",
                                        "show-word-limit": "",
                                        disabled: !_vm.edit_flag
                                      },
                                      model: {
                                        value: _vm.note_description,
                                        callback: function($$v) {
                                          _vm.note_description = $$v
                                        },
                                        expression: "note_description"
                                      }
                                    })
                                  ],
                                  1
                                )
                              ]
                            )
                          ]),
                          _vm._v(" "),
                          _vm._m(1),
                          _vm._v(" "),
                          _vm._m(2),
                          _vm._v(" "),
                          _vm._m(3)
                        ]),
                        _vm._v(" "),
                        _c("div", { staticClass: "hr-line-dashed m-1" }),
                        _vm._v(" "),
                        _c("div", { staticClass: "table-responsive" }, [
                          _c(
                            "table",
                            {
                              staticClass: "table table-hover",
                              staticStyle: { position: "sticky" }
                            },
                            [
                              _c("thead", [
                                _c(
                                  "tr",
                                  [
                                    _vm._m(4),
                                    _vm._v(" "),
                                    _vm._m(5),
                                    _vm._v(" "),
                                    _c(
                                      "th",
                                      {
                                        staticClass:
                                          "text-center sticky-col th-col",
                                        staticStyle: {
                                          "vertical-align": "middle"
                                        }
                                      },
                                      [
                                        _c("div", [
                                          _vm._v(
                                            " ความเร็วเครื่องจักรต่อนาที(" +
                                              _vm._s(_vm.per_unit) +
                                              ") "
                                          )
                                        ])
                                      ]
                                    ),
                                    _vm._v(" "),
                                    _vm._m(6),
                                    _vm._v(" "),
                                    _c(
                                      "th",
                                      {
                                        staticClass:
                                          "text-center sticky-col fi-col",
                                        staticStyle: {
                                          "vertical-align": "middle"
                                        },
                                        attrs: {
                                          title: _vm.efficiencyMachineFormula
                                        }
                                      },
                                      [
                                        _c("div", [
                                          _vm._v(
                                            " ผลผลิตตามประสิทธิภาพต่อนาที "
                                          ),
                                          _c("br"),
                                          _vm._v(
                                            " (" + _vm._s(_vm.per_unit) + ") "
                                          )
                                        ])
                                      ]
                                    ),
                                    _vm._v(" "),
                                    _vm._l(_vm.resPlanDate, function(
                                      planDate,
                                      index
                                    ) {
                                      return [
                                        _c(
                                          "th",
                                          {
                                            staticClass: "text-center",
                                            staticStyle: {
                                              "vertical-align": "middle"
                                            }
                                          },
                                          [
                                            _c("div", { staticClass: "mb-2" }, [
                                              _c(
                                                "small",
                                                {
                                                  staticClass:
                                                    "mb-2 tw-font-bold",
                                                  staticStyle: { color: "#000" }
                                                },
                                                [
                                                  _c(
                                                    "span",
                                                    {
                                                      staticClass: "label",
                                                      staticStyle: {
                                                        "padding-bottom": "1px",
                                                        "padding-top": "1px",
                                                        "font-size": "10px"
                                                      }
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                                                    " +
                                                          _vm._s(index + 1) +
                                                          " " +
                                                          _vm._s(
                                                            planDate.day_of_week
                                                          ) +
                                                          "\n                                                "
                                                      )
                                                    ]
                                                  ),
                                                  _vm._v(" "),
                                                  _c("br"),
                                                  _vm._v(
                                                    "\n                                                " +
                                                      _vm._s(
                                                        planDate.res_plan_date_display
                                                      ) +
                                                      " "
                                                  ),
                                                  _c("br")
                                                ]
                                              )
                                            ]),
                                            _vm._v(" "),
                                            _c("working-hour-component", {
                                              attrs: {
                                                "p-plan-date": planDate,
                                                "p-working-hour":
                                                  _vm.working_hour,
                                                "p-working-hour-edit":
                                                  _vm.workingHourEdit,
                                                "p-edit-flag": _vm.edit_flag,
                                                "p-check-date": _vm.checkDate
                                              }
                                            })
                                          ],
                                          1
                                        )
                                      ]
                                    }),
                                    _vm._v(" "),
                                    _vm._m(7)
                                  ],
                                  2
                                )
                              ]),
                              _vm._v(" "),
                              _c(
                                "tbody",
                                [
                                  _vm.lines.length <= 0
                                    ? [_vm._m(8)]
                                    : [
                                        _vm._l(_vm.lines, function(
                                          lineLists,
                                          machineGroup
                                        ) {
                                          return [
                                            _c("tr", [
                                              _c(
                                                "td",
                                                {
                                                  staticClass:
                                                    "text-left sticky-col first-col",
                                                  attrs: {
                                                    rowspan:
                                                      lineLists.length + 1
                                                  }
                                                },
                                                [
                                                  _c(
                                                    "div",
                                                    {
                                                      staticStyle: {
                                                        width: "100px"
                                                      }
                                                    },
                                                    [
                                                      _vm._v(
                                                        " " +
                                                          _vm._s(
                                                            _vm.covertName(
                                                              machineGroup
                                                            )
                                                          ) +
                                                          " "
                                                      )
                                                    ]
                                                  )
                                                ]
                                              )
                                            ]),
                                            _vm._l(lineLists, function(
                                              line,
                                              indexLine
                                            ) {
                                              return _c(
                                                "tr",
                                                [
                                                  _c(
                                                    "td",
                                                    {
                                                      staticClass:
                                                        "text-left sticky-col second-col",
                                                      style:
                                                        _vm.sel_machine ==
                                                        line.machine_name
                                                          ? "background-color: #9AD9DB; vertical-align: middle;"
                                                          : "vertical-align: middle;",
                                                      on: {
                                                        click: function(
                                                          $event
                                                        ) {
                                                          return _vm.selMachine(
                                                            line.machine_name
                                                          )
                                                        }
                                                      }
                                                    },
                                                    [
                                                      _c(
                                                        "div",
                                                        {
                                                          staticStyle: {
                                                            width: "150px"
                                                          }
                                                        },
                                                        [
                                                          _vm._v(
                                                            " " +
                                                              _vm._s(
                                                                line.machine_description
                                                              ) +
                                                              " "
                                                          )
                                                        ]
                                                      )
                                                    ]
                                                  ),
                                                  _vm._v(" "),
                                                  _c(
                                                    "td",
                                                    {
                                                      staticClass:
                                                        "text-right sticky-col th-col",
                                                      style:
                                                        _vm.sel_machine ==
                                                        line.machine_name
                                                          ? "background-color: #9AD9DB; vertical-align: middle;"
                                                          : "vertical-align: middle;",
                                                      on: {
                                                        click: function(
                                                          $event
                                                        ) {
                                                          return _vm.selMachine(
                                                            line.machine_name
                                                          )
                                                        }
                                                      }
                                                    },
                                                    [
                                                      _c(
                                                        "div",
                                                        {
                                                          staticStyle: {
                                                            width: "100%"
                                                          }
                                                        },
                                                        [
                                                          _vm._v(
                                                            " " +
                                                              _vm._s(
                                                                _vm.decimal(
                                                                  line.machine_speed
                                                                )
                                                              ) +
                                                              " "
                                                          )
                                                        ]
                                                      )
                                                    ]
                                                  ),
                                                  _vm._v(" "),
                                                  _c(
                                                    "td",
                                                    {
                                                      staticClass:
                                                        "text-center sticky-col fo-col",
                                                      style:
                                                        _vm.sel_machine ==
                                                        line.machine_name
                                                          ? "background-color: #9AD9DB;"
                                                          : "",
                                                      on: {
                                                        click: function(
                                                          $event
                                                        ) {
                                                          return _vm.selMachine(
                                                            line.machine_name
                                                          )
                                                        }
                                                      }
                                                    },
                                                    [
                                                      _c("eff-machine", {
                                                        attrs: {
                                                          "edit-flag":
                                                            _vm.edit_flag,
                                                          line: line,
                                                          "line-machine-edit":
                                                            _vm.lineMachineEdit
                                                        }
                                                      })
                                                    ],
                                                    1
                                                  ),
                                                  _vm._v(" "),
                                                  _c(
                                                    "td",
                                                    {
                                                      staticClass:
                                                        "text-right sticky-col fi-col",
                                                      style:
                                                        _vm.sel_machine ==
                                                        line.machine_name
                                                          ? "background-color: #9AD9DB; vertical-align: middle;"
                                                          : "vertical-align: middle;",
                                                      on: {
                                                        click: function(
                                                          $event
                                                        ) {
                                                          return _vm.selMachine(
                                                            line.machine_name
                                                          )
                                                        }
                                                      }
                                                    },
                                                    [
                                                      _c(
                                                        "div",
                                                        {
                                                          staticStyle: {
                                                            width: "100%"
                                                          }
                                                        },
                                                        [
                                                          _vm._v(
                                                            " " +
                                                              _vm._s(
                                                                _vm.decimal(
                                                                  line.efficiency_machine_per_min
                                                                )
                                                              ) +
                                                              " "
                                                          )
                                                        ]
                                                      )
                                                    ]
                                                  ),
                                                  _vm._v(" "),
                                                  _vm._l(
                                                    _vm.resPlanDate,
                                                    function(plan, index) {
                                                      return [
                                                        _vm._l(
                                                          _vm.efficiencyFullProducts,
                                                          function(
                                                            efficiencyProduct,
                                                            index
                                                          ) {
                                                            return [
                                                              _vm
                                                                .machineDowntimes[
                                                                plan
                                                                  .res_plan_date_display
                                                              ][
                                                                line
                                                                  .machine_name
                                                              ] == "Y" &&
                                                              plan.res_plan_date_display ==
                                                                index
                                                                ? [
                                                                    _c(
                                                                      "td",
                                                                      {
                                                                        staticClass:
                                                                          "text-right",
                                                                        staticStyle: {
                                                                          "background-color":
                                                                            "#e02b1e"
                                                                        },
                                                                        attrs: {
                                                                          title:
                                                                            _vm.efficiencyDayFormula
                                                                        },
                                                                        on: {
                                                                          click: function(
                                                                            $event
                                                                          ) {
                                                                            return _vm.selMachine(
                                                                              line.machine_name
                                                                            )
                                                                          }
                                                                        }
                                                                      },
                                                                      [
                                                                        _c(
                                                                          "div",
                                                                          {
                                                                            staticStyle: {
                                                                              width:
                                                                                "70px"
                                                                            }
                                                                          },
                                                                          [
                                                                            _vm._v(
                                                                              " 0.00 "
                                                                            )
                                                                          ]
                                                                        )
                                                                      ]
                                                                    )
                                                                  ]
                                                                : _vm
                                                                    .machineMaintenances[
                                                                    plan
                                                                      .res_plan_date_display
                                                                  ][
                                                                    line
                                                                      .machine_name
                                                                  ] == "Y" &&
                                                                  plan.res_plan_date_display ==
                                                                    index
                                                                ? [
                                                                    _c(
                                                                      "td",
                                                                      {
                                                                        staticClass:
                                                                          "text-right",
                                                                        staticStyle: {
                                                                          "background-color":
                                                                            "#ffc107"
                                                                        },
                                                                        attrs: {
                                                                          title:
                                                                            _vm.efficiencyDayFormula
                                                                        },
                                                                        on: {
                                                                          click: function(
                                                                            $event
                                                                          ) {
                                                                            return _vm.selMachine(
                                                                              line.machine_name
                                                                            )
                                                                          }
                                                                        }
                                                                      },
                                                                      [
                                                                        _c(
                                                                          "div",
                                                                          {
                                                                            staticStyle: {
                                                                              width:
                                                                                "70px"
                                                                            }
                                                                          },
                                                                          [
                                                                            _vm._v(
                                                                              " 0.00 "
                                                                            )
                                                                          ]
                                                                        )
                                                                      ]
                                                                    )
                                                                  ]
                                                                : plan.holiday_flag ==
                                                                    "Y" &&
                                                                  plan.res_plan_date_display ==
                                                                    index
                                                                ? [
                                                                    _c(
                                                                      "td",
                                                                      {
                                                                        staticClass:
                                                                          "text-right",
                                                                        staticStyle: {
                                                                          "background-color":
                                                                            "#cccccc"
                                                                        },
                                                                        attrs: {
                                                                          title:
                                                                            _vm.efficiencyDayFormula
                                                                        },
                                                                        on: {
                                                                          click: function(
                                                                            $event
                                                                          ) {
                                                                            return _vm.selMachine(
                                                                              line.machine_name
                                                                            )
                                                                          }
                                                                        }
                                                                      },
                                                                      [
                                                                        _c(
                                                                          "div",
                                                                          {
                                                                            staticStyle: {
                                                                              width:
                                                                                "70px"
                                                                            }
                                                                          },
                                                                          [
                                                                            _vm._v(
                                                                              " \n                                                                " +
                                                                                _vm._s(
                                                                                  _vm._f(
                                                                                    "number2Digit"
                                                                                  )(
                                                                                    efficiencyProduct[
                                                                                      line
                                                                                        .machine_name
                                                                                    ]
                                                                                  )
                                                                                ) +
                                                                                "\n                                                            "
                                                                            )
                                                                          ]
                                                                        )
                                                                      ]
                                                                    )
                                                                  ]
                                                                : plan.holiday_flag ==
                                                                    "P" &&
                                                                  plan.res_plan_date_display ==
                                                                    index
                                                                ? [
                                                                    _c(
                                                                      "td",
                                                                      {
                                                                        staticClass:
                                                                          "text-right",
                                                                        staticStyle: {
                                                                          "background-color":
                                                                            "#878788"
                                                                        },
                                                                        attrs: {
                                                                          title:
                                                                            _vm.efficiencyDayFormula
                                                                        },
                                                                        on: {
                                                                          click: function(
                                                                            $event
                                                                          ) {
                                                                            return _vm.selMachine(
                                                                              line.machine_name
                                                                            )
                                                                          }
                                                                        }
                                                                      },
                                                                      [
                                                                        _c(
                                                                          "div",
                                                                          {
                                                                            staticStyle: {
                                                                              width:
                                                                                "70px"
                                                                            }
                                                                          },
                                                                          [
                                                                            _vm._v(
                                                                              " \n                                                                " +
                                                                                _vm._s(
                                                                                  _vm._f(
                                                                                    "number2Digit"
                                                                                  )(
                                                                                    efficiencyProduct[
                                                                                      line
                                                                                        .machine_name
                                                                                    ]
                                                                                  )
                                                                                ) +
                                                                                "\n                                                            "
                                                                            )
                                                                          ]
                                                                        )
                                                                      ]
                                                                    )
                                                                  ]
                                                                : plan.holiday_flag !=
                                                                    "Y" &&
                                                                  plan.res_plan_date_display ==
                                                                    index &&
                                                                  _vm
                                                                    .machineDowntimes[
                                                                    plan
                                                                      .res_plan_date_display
                                                                  ][
                                                                    line
                                                                      .machine_name
                                                                  ] != "Y" &&
                                                                  _vm
                                                                    .machineMaintenances[
                                                                    plan
                                                                      .res_plan_date_display
                                                                  ][
                                                                    line
                                                                      .machine_name
                                                                  ] != "Y"
                                                                ? [
                                                                    _c(
                                                                      "td",
                                                                      {
                                                                        staticClass:
                                                                          "text-right",
                                                                        style:
                                                                          _vm.sel_machine ==
                                                                          line.machine_name
                                                                            ? "background-color: #9AD9DB;"
                                                                            : "",
                                                                        attrs: {
                                                                          title:
                                                                            _vm.efficiencyDayFormula
                                                                        },
                                                                        on: {
                                                                          click: function(
                                                                            $event
                                                                          ) {
                                                                            return _vm.selMachine(
                                                                              line.machine_name
                                                                            )
                                                                          }
                                                                        }
                                                                      },
                                                                      [
                                                                        _c(
                                                                          "div",
                                                                          {
                                                                            staticStyle: {
                                                                              width:
                                                                                "70px"
                                                                            }
                                                                          },
                                                                          [
                                                                            _vm._v(
                                                                              " \n                                                                " +
                                                                                _vm._s(
                                                                                  _vm._f(
                                                                                    "number2Digit"
                                                                                  )(
                                                                                    efficiencyProduct[
                                                                                      line
                                                                                        .machine_name
                                                                                    ]
                                                                                  )
                                                                                ) +
                                                                                "\n                                                            "
                                                                            )
                                                                          ]
                                                                        )
                                                                      ]
                                                                    )
                                                                  ]
                                                                : _vm._e()
                                                            ]
                                                          }
                                                        )
                                                      ]
                                                    }
                                                  ),
                                                  _vm._v(" "),
                                                  _c("td", {
                                                    style:
                                                      _vm.sel_machine ==
                                                      line.machine_name
                                                        ? "background-color: #9AD9DB;"
                                                        : "",
                                                    on: {
                                                      click: function($event) {
                                                        return _vm.selMachine(
                                                          line.machine_name
                                                        )
                                                      }
                                                    }
                                                  })
                                                ],
                                                2
                                              )
                                            }),
                                            _vm._v(" "),
                                            _c(
                                              "tr",
                                              [
                                                _vm._m(9, true),
                                                _vm._v(" "),
                                                _c(
                                                  "td",
                                                  {
                                                    staticClass:
                                                      "text-right sticky-col t2-col",
                                                    staticStyle: {
                                                      "vertical-align":
                                                        "middle",
                                                      "background-color":
                                                        "#70d200"
                                                    }
                                                  },
                                                  [
                                                    _vm._l(
                                                      _vm.summary,
                                                      function(res) {
                                                        return [
                                                          machineGroup ==
                                                          res.machine_group
                                                            ? [
                                                                _c(
                                                                  "span",
                                                                  {
                                                                    staticClass:
                                                                      "tw-font-bold"
                                                                  },
                                                                  [
                                                                    _vm._v(
                                                                      " " +
                                                                        _vm._s(
                                                                          _vm._f(
                                                                            "number2Digit"
                                                                          )(
                                                                            res.efficiency_machine_per_min
                                                                          )
                                                                        ) +
                                                                        " "
                                                                    )
                                                                  ]
                                                                )
                                                              ]
                                                            : _vm._e()
                                                        ]
                                                      }
                                                    )
                                                  ],
                                                  2
                                                ),
                                                _vm._v(" "),
                                                _vm._l(
                                                  _vm.resPlanDate,
                                                  function(plan, index) {
                                                    return [
                                                      plan.holiday_flag ==
                                                        "Y" ||
                                                      plan.holiday_flag == "P"
                                                        ? _c(
                                                            "td",
                                                            {
                                                              staticClass:
                                                                "text-right",
                                                              staticStyle: {
                                                                "vertical-align":
                                                                  "middle",
                                                                "background-color":
                                                                  "#70d200"
                                                              }
                                                            },
                                                            [
                                                              _c(
                                                                "div",
                                                                {
                                                                  staticClass:
                                                                    "tw-font-bold",
                                                                  staticStyle: {
                                                                    width:
                                                                      "70px"
                                                                  }
                                                                },
                                                                [
                                                                  _c(
                                                                    "efficiency-product-component",
                                                                    {
                                                                      attrs: {
                                                                        "p-efficiency-products":
                                                                          _vm.efficiencyFullProducts,
                                                                        "p-lines":
                                                                          _vm.lines,
                                                                        "p-plan-date": plan,
                                                                        "p-machine-group": machineGroup,
                                                                        "p-total-product-arr":
                                                                          _vm.totalFullProductArr,
                                                                        "p-machine-maintenances":
                                                                          _vm.machineMaintenances,
                                                                        "p-machine-downtimes":
                                                                          _vm.machineDowntimes
                                                                      }
                                                                    }
                                                                  )
                                                                ],
                                                                1
                                                              )
                                                            ]
                                                          )
                                                        : _c(
                                                            "td",
                                                            {
                                                              staticClass:
                                                                "text-right",
                                                              staticStyle: {
                                                                "vertical-align":
                                                                  "middle",
                                                                "background-color":
                                                                  "#70d200"
                                                              }
                                                            },
                                                            [
                                                              _c(
                                                                "div",
                                                                {
                                                                  staticClass:
                                                                    "tw-font-bold",
                                                                  staticStyle: {
                                                                    width:
                                                                      "70px"
                                                                  }
                                                                },
                                                                [
                                                                  _c(
                                                                    "efficiency-product-component",
                                                                    {
                                                                      attrs: {
                                                                        "p-efficiency-products":
                                                                          _vm.efficiencyFullProducts,
                                                                        "p-lines":
                                                                          _vm.lines,
                                                                        "p-plan-date": plan,
                                                                        "p-machine-group": machineGroup,
                                                                        "p-total-product-arr":
                                                                          _vm.totalFullProductArr,
                                                                        "p-machine-maintenances":
                                                                          _vm.machineMaintenances,
                                                                        "p-machine-downtimes":
                                                                          _vm.machineDowntimes
                                                                      }
                                                                    }
                                                                  )
                                                                ],
                                                                1
                                                              )
                                                            ]
                                                          )
                                                    ]
                                                  }
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "td",
                                                  {
                                                    staticClass: "text-right",
                                                    staticStyle: {
                                                      "vertical-align":
                                                        "middle",
                                                      "background-color":
                                                        "#70d200"
                                                    }
                                                  },
                                                  [
                                                    _c(
                                                      "div",
                                                      {
                                                        staticClass:
                                                          "tw-font-bold text-right",
                                                        staticStyle: {
                                                          width: "70px"
                                                        }
                                                      },
                                                      [
                                                        _c(
                                                          "summary-efficiency-product-by-group",
                                                          {
                                                            attrs: {
                                                              "p-machine-group": machineGroup,
                                                              "p-total-product-arr":
                                                                _vm.totalFullProductArr,
                                                              "p-res-plan-date":
                                                                _vm.resPlanDate
                                                            }
                                                          }
                                                        )
                                                      ],
                                                      1
                                                    )
                                                  ]
                                                )
                                              ],
                                              2
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "tr",
                                              [
                                                _vm._m(10, true),
                                                _vm._v(" "),
                                                _c(
                                                  "td",
                                                  {
                                                    staticClass:
                                                      "text-right sticky-col t2-col",
                                                    staticStyle: {
                                                      "vertical-align":
                                                        "middle",
                                                      "background-color":
                                                        "#70d200"
                                                    }
                                                  },
                                                  [
                                                    _vm._l(
                                                      _vm.summary,
                                                      function(res) {
                                                        return [
                                                          machineGroup ==
                                                          res.machine_group
                                                            ? [
                                                                _c(
                                                                  "span",
                                                                  {
                                                                    staticClass:
                                                                      "tw-font-bold"
                                                                  },
                                                                  [
                                                                    _vm._v(
                                                                      " " +
                                                                        _vm._s(
                                                                          _vm._f(
                                                                            "number2Digit"
                                                                          )(
                                                                            res.efficiency_machine_per_min
                                                                          )
                                                                        ) +
                                                                        " "
                                                                    )
                                                                  ]
                                                                )
                                                              ]
                                                            : _vm._e()
                                                        ]
                                                      }
                                                    )
                                                  ],
                                                  2
                                                ),
                                                _vm._v(" "),
                                                _vm._l(
                                                  _vm.resPlanDate,
                                                  function(plan, index) {
                                                    return [
                                                      plan.holiday_flag == "Y"
                                                        ? _c(
                                                            "td",
                                                            {
                                                              staticClass:
                                                                "text-right",
                                                              staticStyle: {
                                                                "vertical-align":
                                                                  "middle",
                                                                "background-color":
                                                                  "#70d200"
                                                              }
                                                            },
                                                            [
                                                              _c(
                                                                "div",
                                                                {
                                                                  staticClass:
                                                                    "tw-font-bold",
                                                                  staticStyle: {
                                                                    width:
                                                                      "70px"
                                                                  }
                                                                },
                                                                [
                                                                  _c(
                                                                    "efficiency-product-component",
                                                                    {
                                                                      attrs: {
                                                                        "p-efficiency-products":
                                                                          _vm.efficiencyProducts,
                                                                        "p-lines":
                                                                          _vm.lines,
                                                                        "p-plan-date": plan,
                                                                        "p-machine-group": machineGroup,
                                                                        "p-total-product-arr":
                                                                          _vm.totalProductArr,
                                                                        "p-machine-maintenances":
                                                                          _vm.machineMaintenances,
                                                                        "p-machine-downtimes":
                                                                          _vm.machineDowntimes
                                                                      }
                                                                    }
                                                                  )
                                                                ],
                                                                1
                                                              )
                                                            ]
                                                          )
                                                        : _c(
                                                            "td",
                                                            {
                                                              staticClass:
                                                                "text-right",
                                                              staticStyle: {
                                                                "vertical-align":
                                                                  "middle",
                                                                "background-color":
                                                                  "#70d200"
                                                              }
                                                            },
                                                            [
                                                              _c(
                                                                "div",
                                                                {
                                                                  staticClass:
                                                                    "tw-font-bold",
                                                                  staticStyle: {
                                                                    width:
                                                                      "70px"
                                                                  }
                                                                },
                                                                [
                                                                  _c(
                                                                    "efficiency-product-component",
                                                                    {
                                                                      attrs: {
                                                                        "p-efficiency-products":
                                                                          _vm.efficiencyProducts,
                                                                        "p-lines":
                                                                          _vm.lines,
                                                                        "p-plan-date": plan,
                                                                        "p-machine-group": machineGroup,
                                                                        "p-total-product-arr":
                                                                          _vm.totalProductArr,
                                                                        "p-machine-maintenances":
                                                                          _vm.machineMaintenances,
                                                                        "p-machine-downtimes":
                                                                          _vm.machineDowntimes
                                                                      }
                                                                    }
                                                                  )
                                                                ],
                                                                1
                                                              )
                                                            ]
                                                          )
                                                    ]
                                                  }
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "td",
                                                  {
                                                    staticClass: "text-right",
                                                    staticStyle: {
                                                      "vertical-align":
                                                        "middle",
                                                      "background-color":
                                                        "#70d200"
                                                    }
                                                  },
                                                  [
                                                    _c(
                                                      "div",
                                                      {
                                                        staticClass:
                                                          "tw-font-bold text-right",
                                                        staticStyle: {
                                                          width: "70px"
                                                        }
                                                      },
                                                      [
                                                        _c(
                                                          "summary-efficiency-product-by-group",
                                                          {
                                                            attrs: {
                                                              "p-machine-group": machineGroup,
                                                              "p-total-product-arr":
                                                                _vm.totalProductArr,
                                                              "p-res-plan-date":
                                                                _vm.resPlanDate
                                                            }
                                                          }
                                                        )
                                                      ],
                                                      1
                                                    )
                                                  ]
                                                )
                                              ],
                                              2
                                            )
                                          ]
                                        }),
                                        _vm._v(" "),
                                        _c(
                                          "tr",
                                          [
                                            _vm._m(11),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass:
                                                  "text-right sticky-col t2-col",
                                                staticStyle: {
                                                  "vertical-align": "middle",
                                                  "background-color": "#70d200"
                                                }
                                              },
                                              [
                                                _c(
                                                  "div",
                                                  {
                                                    staticClass:
                                                      "tw-font-bold text-right"
                                                  },
                                                  [
                                                    _vm._v(
                                                      " " +
                                                        _vm._s(
                                                          _vm._f(
                                                            "number2Digit"
                                                          )(_vm.totalMachineAll)
                                                        ) +
                                                        " "
                                                    )
                                                  ]
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _vm._l(_vm.resPlanDate, function(
                                              plan,
                                              index
                                            ) {
                                              return [
                                                _vm._l(
                                                  _vm.summaryProduct,
                                                  function(res) {
                                                    return [
                                                      plan.working_hour == 0 &&
                                                      res.plan_date ==
                                                        plan.res_plan_date_display
                                                        ? [
                                                            _c(
                                                              "td",
                                                              {
                                                                staticClass:
                                                                  "tw-font-bold text-right",
                                                                staticStyle: {
                                                                  "vertical-align":
                                                                    "middle",
                                                                  "background-color":
                                                                    "#70d200"
                                                                }
                                                              },
                                                              [
                                                                _c(
                                                                  "div",
                                                                  {
                                                                    staticStyle: {
                                                                      width:
                                                                        "70px"
                                                                    }
                                                                  },
                                                                  [
                                                                    _vm._v(
                                                                      " 0.00 "
                                                                    )
                                                                  ]
                                                                )
                                                              ]
                                                            )
                                                          ]
                                                        : _vm._e(),
                                                      _vm._v(" "),
                                                      plan.working_hour != 0 &&
                                                      res.plan_date ==
                                                        plan.res_plan_date_display
                                                        ? [
                                                            _c(
                                                              "td",
                                                              {
                                                                staticClass:
                                                                  "tw-font-bold text-right",
                                                                staticStyle: {
                                                                  "vertical-align":
                                                                    "middle",
                                                                  "background-color":
                                                                    "#70d200"
                                                                }
                                                              },
                                                              [
                                                                _c(
                                                                  "div",
                                                                  {
                                                                    staticStyle: {
                                                                      width:
                                                                        "70px"
                                                                    }
                                                                  },
                                                                  [
                                                                    _vm._v(
                                                                      " \n                                                        " +
                                                                        _vm._s(
                                                                          _vm._f(
                                                                            "number2Digit"
                                                                          )(
                                                                            res.total
                                                                          )
                                                                        ) +
                                                                        "\n                                                    "
                                                                    )
                                                                  ]
                                                                )
                                                              ]
                                                            )
                                                          ]
                                                        : _vm._e()
                                                    ]
                                                  }
                                                )
                                              ]
                                            }),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-right",
                                                staticStyle: {
                                                  "vertical-align": "middle",
                                                  "background-color": "#70d200"
                                                }
                                              },
                                              [
                                                _c(
                                                  "div",
                                                  {
                                                    staticClass:
                                                      "tw-font-bold text-right",
                                                    staticStyle: {
                                                      width: "70px"
                                                    }
                                                  },
                                                  [
                                                    _vm._v(
                                                      " " +
                                                        _vm._s(
                                                          _vm._f(
                                                            "number2Digit"
                                                          )(_vm.totalProductAll)
                                                        ) +
                                                        " "
                                                    )
                                                  ]
                                                )
                                              ]
                                            )
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
                    : _vm._e()
                ]
              : Object.values(_vm.lines).length < 0 && _vm.loadingHtml == ""
              ? [_vm._m(12)]
              : _vm._e()
          ],
          2
        )
      : _vm._e()
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-md-8" }, [
      _c("h2", { staticClass: "tw-font-bold" }, [_vm._v(" Machine Detail ")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-md-2 p-1" }, [
      _c("div", [
        _c("i", {
          staticClass: "fa fa-square fa-2x",
          staticStyle: { color: "#ffc107" }
        }),
        _vm._v("   แผนซ่อมบำรุงเครื่องจักร ")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-md-2 p-1" }, [
      _c("div", [
        _c("i", {
          staticClass: "fa fa-square fa-2x",
          staticStyle: { color: "#e02b1e" }
        }),
        _vm._v("   ปรับลดกำลังการผลิต ")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-md-1 p-1" }, [
      _c("div", [
        _c("i", {
          staticClass: "fa fa-square fa-2x",
          staticStyle: { color: "#cccccc" }
        }),
        _vm._v("   วันหยุด ")
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
        staticClass: "text-center sticky-col first-col",
        staticStyle: { "vertical-align": "middle", "border-bottom": "0px" }
      },
      [_c("div", [_vm._v(" ขอบเขตเครื่องจักร ")])]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "th",
      {
        staticClass: "text-center sticky-col second-col",
        staticStyle: { "vertical-align": "middle" }
      },
      [_c("div", [_vm._v(" รายละเอียดเครื่องจักร ")])]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "th",
      {
        staticClass: "text-center sticky-col fo-col",
        staticStyle: { "vertical-align": "middle" }
      },
      [_c("div", [_vm._v(" ประสิทธิภาพเครื่องจักร(%) ")])]
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
        staticStyle: { "vertical-align": "middle" }
      },
      [_c("div", [_vm._v(" รวมกำลังผลิต ")])]
    )
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
          attrs: { colspan: "6" }
        },
        [_c("h2", [_vm._v(" ไม่พบข้อมูลที่ค้นหาในระบบ ")])]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "td",
      {
        staticClass: "text-right sticky-col t1-col",
        staticStyle: { "vertical-align": "middle" },
        attrs: { colspan: "4" }
      },
      [_c("strong", [_vm._v(" รวม ")])]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "td",
      {
        staticClass: "text-right sticky-col t1-col",
        staticStyle: { "vertical-align": "middle" },
        attrs: { colspan: "4" }
      },
      [_c("strong", [_vm._v(" รวมผลผลิตที่คาดว่าจะได้ ")])]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "td",
      {
        staticClass: "text-right sticky-col t1-col",
        staticStyle: { "vertical-align": "middle" },
        attrs: { colspan: "4" }
      },
      [_c("strong", [_vm._v(" รวมกำลังผลิตแต่ละวัน ")])]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "text-center" }, [
      _c("h2", [_vm._v(" ไม่พบข้อมูลที่ค้นหาในระบบ ")])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/MachineList.vue?vue&type=template&id=0af816bd&":
/*!***********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/MachineList.vue?vue&type=template&id=0af816bd& ***!
  \***********************************************************************************************************************************************************************************************************************************************/
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
  return _c("tr", [
    _c("td", { staticClass: "text-center" }, [
      _vm._v(" " + _vm._s(_vm.index + 1) + " ")
    ]),
    _vm._v(" "),
    _c(
      "td",
      {
        staticStyle: { "padding-bottom": "2px", "padding-top": "2px" },
        attrs: { width: "100px" }
      },
      [
        _c(
          "div",
          [
            _c(
              "el-select",
              {
                ref: "machine_group",
                staticClass: "w-100",
                attrs: {
                  name: "machine_group[]",
                  size: "large",
                  placeholder: "ขอบเขตเครื่องจักร",
                  clearable: "",
                  filterable: "",
                  remote: "",
                  disabled: _vm.enable,
                  "popper-append-to-body": false
                },
                on: { change: _vm.selMachineGroup },
                model: {
                  value: _vm.machineGroup,
                  callback: function($$v) {
                    _vm.machineGroup = $$v
                  },
                  expression: "machineGroup"
                }
              },
              _vm._l(_vm.machineGroups, function(group) {
                return _c("el-option", {
                  key: group.machine_group,
                  attrs: {
                    label: group.machine_group_description,
                    value: group.machine_group
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
          attrs: { id: "el_explode_machine_group" + _vm.index }
        })
      ]
    ),
    _vm._v(" "),
    _c(
      "td",
      {
        staticStyle: { "padding-bottom": "2px", "padding-top": "2px" },
        attrs: { width: "100px" }
      },
      [
        _c(
          "div",
          [
            !_vm.attribute.machine_group
              ? _c(
                  "el-select",
                  {
                    ref: "machine_desc",
                    staticClass: "w-100",
                    attrs: {
                      name: "machine_desc[]",
                      size: "large",
                      placeholder: "รายละเอียดเครื่องจักร",
                      disabled: ""
                    },
                    model: {
                      value: _vm.machineDescription,
                      callback: function($$v) {
                        _vm.machineDescription = $$v
                      },
                      expression: "machineDescription"
                    }
                  },
                  _vm._l(_vm.machineDescLists, function(desc, index) {
                    return _c("el-option", {
                      key: index,
                      attrs: {
                        label: desc.machine_description,
                        value: desc.machine_description
                      }
                    })
                  }),
                  1
                )
              : _c(
                  "el-select",
                  {
                    ref: "machine_desc",
                    staticClass: "w-100",
                    attrs: {
                      name: "machine_desc[]",
                      size: "large",
                      placeholder: "รายละเอียดเครื่องจักร",
                      clearable: "",
                      filterable: "",
                      remote: "",
                      disabled: _vm.enable,
                      "popper-append-to-body": false
                    },
                    on: { change: _vm.selMachineDesc },
                    model: {
                      value: _vm.machineDescription,
                      callback: function($$v) {
                        _vm.machineDescription = $$v
                      },
                      expression: "machineDescription"
                    }
                  },
                  _vm._l(_vm.machineDescLists, function(desc, index) {
                    return _c("el-option", {
                      key: index,
                      attrs: {
                        label: desc.machine_description,
                        value: desc.machine_description
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
          attrs: { id: "el_explode_machine_desc" + _vm.index }
        })
      ]
    ),
    _vm._v(" "),
    _c("td", [
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
              value: _vm.inputDateFrom,
              format: "DD-MMM-YYYY",
              disabled: _vm.isDisableSelDate
            },
            on: { dateWasSelected: _vm.dateWasSelectedFrom },
            model: {
              value: _vm.inputDateFrom,
              callback: function($$v) {
                _vm.inputDateFrom = $$v
              },
              expression: "inputDateFrom"
            }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c("div", {
        staticClass: "error_msg text-left",
        attrs: { id: "el_explode_start_date" + _vm.index }
      })
    ]),
    _vm._v(" "),
    _c("td", { staticClass: "text-right" }, [
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
              value: _vm.inputDateTo,
              format: "DD-MMM-YYYY",
              disabled: _vm.isDisableSelDate,
              "disabled-date-to": _vm.inputDateFrom
            },
            on: { dateWasSelected: _vm.dateWasSelectedTo },
            model: {
              value: _vm.inputDateTo,
              callback: function($$v) {
                _vm.inputDateTo = $$v
              },
              expression: "inputDateTo"
            }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c("div", {
        staticClass: "error_msg text-left",
        attrs: { id: "el_explode_end_date" + _vm.index }
      })
    ]),
    _vm._v(" "),
    _c("td", { staticStyle: { "text-align": "center" } }, [
      _c(
        "button",
        {
          staticClass: "btn btn-md btn-danger",
          on: {
            click: function($event) {
              $event.preventDefault()
              return _vm.remove(_vm.machineLine)
            }
          }
        },
        [_c("i", { staticClass: "fa fa-trash-o" })]
      )
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/ModalHoliday.vue?vue&type=template&id=74f880e3&":
/*!************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/ModalHoliday.vue?vue&type=template&id=74f880e3& ***!
  \************************************************************************************************************************************************************************************************************************************************/
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
        staticClass: "btn btn-info btn-md",
        staticStyle: { "padding-left": "7px" },
        on: { click: _vm.openModal }
      },
      [
        _c("i", { staticClass: "fa fa-eye" }),
        _vm._v(" วันหยุดประจำปีงบประมาณ\n    ")
      ]
    ),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass: "modal fade",
        attrs: { id: "modal-holiday", role: "dialog" }
      },
      [
        _c(
          "div",
          {
            staticClass: "modal-dialog modal-lg",
            staticStyle: { width: "90%", "max-width": "980px" }
          },
          [
            _c("div", { staticClass: "modal-content" }, [
              _vm._m(0),
              _vm._v(" "),
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
                  staticClass: "modal-body text-left"
                },
                [
                  _vm.holHtml
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
                                  "form-group pl-2 pr-2 mb-0 col-lg-4 col-md-4 col-sm-6 col-xs-6 mt-3 text-center"
                              },
                              [
                                _c(
                                  "label",
                                  {
                                    staticClass:
                                      " tw-font-bold tw-uppercase mb-1"
                                  },
                                  [_vm._v(" อัพเดตข้อมูลล่าสุดวันที่ : ")]
                                ),
                                _vm._v(" "),
                                _c("span", [
                                  _vm._v(" " + _vm._s(_vm.lastDate) + " ")
                                ])
                              ]
                            ),
                            _vm._v(" "),
                            _c(
                              "div",
                              {
                                staticClass:
                                  "form-group pr-2 mb-0 col-lg-3 col-md-4 col-sm-6 col-xs-6 mt-2"
                              },
                              [
                                _c(
                                  "button",
                                  {
                                    staticClass: "btn btn-white btn-md",
                                    attrs: { type: "button" },
                                    on: {
                                      click: function($event) {
                                        $event.preventDefault()
                                        return _vm.refreshHoliday($event)
                                      }
                                    }
                                  },
                                  [
                                    _c("i", { staticClass: "fa fa-undo" }),
                                    _vm._v(" รีเฟรชข้อมูล ")
                                  ]
                                )
                              ]
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c("div", { staticClass: "hr-line-dashed" })
                      ]
                    : _vm._e(),
                  _vm._v(" "),
                  _c("span", { domProps: { innerHTML: _vm._s(_vm.holHtml) } })
                ],
                2
              )
            ])
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
            "\n                        วันหยุดประจำปีงบประมาณ\n                    "
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/ModalMachineDowntime.vue?vue&type=template&id=0b608e61&":
/*!********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/ModalMachineDowntime.vue?vue&type=template&id=0b608e61& ***!
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
  return _c("span", [
    _vm.isDisableReduceBtn
      ? _c(
          "button",
          {
            staticClass: "btn btn-warning btn-md",
            staticStyle: { "padding-left": "7px" },
            on: { click: _vm.openModal }
          },
          [
            _c("i", { staticClass: "fa fa-minus-circle" }),
            _vm._v(" ปรับลดกำลังการผลิต\n    ")
          ]
        )
      : _vm._e(),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass: "modal fade",
        attrs: { id: "modal-downtime-machine", role: "dialog" }
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
                _c("div", { staticClass: "modal-header" }, [
                  _c(
                    "h3",
                    {
                      staticClass: "modal-title text-left",
                      staticStyle: { "font-size": "24px", "font-weight": "400" }
                    },
                    [
                      _vm._v(
                        "\n                        แผนการลดกำลังการผลิต\n                    "
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
                  _c("form", { attrs: { id: "machine-downtime-form" } }, [
                    _c("div", { staticClass: "table-responsive" }, [
                      _c("table", { staticClass: "table" }, [
                        _vm._m(0),
                        _vm._v(" "),
                        _c(
                          "tbody",
                          _vm._l(_vm.machineLines, function(row, index) {
                            return _c("MachineList", {
                              key: row.id,
                              attrs: {
                                attribute: row,
                                index: index,
                                header: _vm.header,
                                "pp-monthly": _vm.ppMonthly,
                                "machine-groups": _vm.machineGroups,
                                "machine-desc": _vm.machineDesc,
                                "date-format": _vm.dateFormat,
                                "list-machine-lines": _vm.machineLines
                              },
                              on: { removeRow: _vm.removeLine }
                            })
                          }),
                          1
                        )
                      ]),
                      _vm._v(" "),
                      _c(
                        "button",
                        {
                          staticClass: "btn btn-sm btn-block btn-primary",
                          attrs: { type: "button" },
                          on: { click: _vm.addMachineLine }
                        },
                        [
                          _c("i", { staticClass: "fa fa-plus-square" }),
                          _vm._v("  เพิ่มรายการ\n                            ")
                        ]
                      )
                    ])
                  ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "modal-footer" }, [
                  !_vm.machineLines
                    ? _c(
                        "button",
                        {
                          class: _vm.btnTrans.create.class + " btn-lg tw-w-25",
                          attrs: { type: "button" }
                        },
                        [
                          _vm._v(
                            "\n                        ตกลง\n                    "
                          )
                        ]
                      )
                    : _c(
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
    return _c("thead", [
      _c("tr", [
        _c("th", { staticClass: "text-center", attrs: { width: "2%" } }, [
          _vm._v(" ลำดับ ")
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "20%" } }, [
          _vm._v(" ขอบเขตเครื่องจักร ")
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "30%" } }, [
          _vm._v(" รายละเอียดเครื่องจักร ")
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "20%" } }, [
          _vm._v(" วันที่เริ่มต้น ")
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "20%" } }, [
          _vm._v(" วันที่สิ้นสุด ")
        ]),
        _vm._v(" "),
        _c("th", { attrs: { width: "2%" } })
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/ModalOverview.vue?vue&type=template&id=5d383004&":
/*!*************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/ModalOverview.vue?vue&type=template&id=5d383004& ***!
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
        staticClass: "btn btn-info btn-md",
        staticStyle: { "padding-left": "7px" },
        on: { click: _vm.openModal }
      },
      [
        _c("i", { staticClass: "fa fa-bar-chart-o" }),
        _vm._v(" ภาพรวมการผลิตทั้งปีงบประมาณ\n    ")
      ]
    ),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass: "modal fade",
        attrs: { id: "modal-machine-overview", role: "dialog" }
      },
      [
        _c("div", { staticClass: "modal-dialog modal-xl" }, [
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
                _c("form", { attrs: { id: "machine-overview-form" } }, [
                  _c("div", { staticClass: "row col-12" }, [
                    _c(
                      "div",
                      {
                        staticClass:
                          "form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-4 col-xs-4 mt-2"
                      },
                      [
                        _c(
                          "label",
                          { staticClass: " tw-font-bold tw-uppercase mt-2" },
                          [_vm._v(" สั่งผลิต  : ")]
                        ),
                        _vm._v(
                          " " +
                            _vm._s(_vm.header.efficiency_product) +
                            "% \n                            "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _vm._m(1),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass:
                          "form-group pl-2 pr-2 mb-0 col-lg-1 col-md-1 col-sm-1 col-xs-1 mt-2"
                      },
                      [
                        _c("vue-numeric", {
                          staticClass: "form-control input-sm text-right",
                          staticStyle: { width: "100%" },
                          attrs: {
                            name: "onhand_year",
                            minus: false,
                            min: 0,
                            max: 100,
                            autocomplete: "off"
                          },
                          model: {
                            value: _vm.value,
                            callback: function($$v) {
                              _vm.value = $$v
                            },
                            expression: "value"
                          }
                        })
                      ],
                      1
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "table-responsive mt-3" }, [
                    _c(
                      "table",
                      {
                        staticClass: "table table-bordered",
                        staticStyle: { "font-size": "11px" }
                      },
                      [
                        _c("thead", [
                          _c("tr", { staticStyle: { "font-size": "11px" } }, [
                            _c(
                              "th",
                              {
                                staticClass: "text-center",
                                attrs: { rowspan: "2", width: "12%" }
                              },
                              [_vm._v(" เดือน ")]
                            ),
                            _vm._v(" "),
                            _c(
                              "th",
                              {
                                staticClass: "text-center",
                                staticStyle: {
                                  "border-right": "3px solid #ddd"
                                },
                                attrs: {
                                  colspan: _vm.workingHour.length,
                                  width: "10%"
                                }
                              },
                              [
                                _vm._v(
                                  "\n                                            กำลังผลิต (ล้านมวน)\n                                        "
                                )
                              ]
                            ),
                            _vm._v(" "),
                            _c(
                              "th",
                              {
                                staticClass: "text-center",
                                staticStyle: {
                                  "border-right": "3px solid #ddd"
                                },
                                attrs: {
                                  colspan: _vm.workingHour.length,
                                  width: "10%"
                                }
                              },
                              [
                                _vm._v(
                                  "\n                                            สั่งผลิต (ล้านมวน)\n                                        "
                                )
                              ]
                            ),
                            _vm._v(" "),
                            _c(
                              "th",
                              {
                                staticClass: "text-center",
                                staticStyle: {
                                  "border-right": "3px solid #ddd"
                                },
                                attrs: {
                                  colspan: _vm.workingHour.length,
                                  width: "18%"
                                }
                              },
                              [
                                _vm._v(
                                  "\n                                            จำนวนวันทำงาน (วัน)\n                                        "
                                )
                              ]
                            ),
                            _vm._v(" "),
                            _vm._m(2),
                            _vm._v(" "),
                            _vm._m(3),
                            _vm._v(" "),
                            _vm._m(4),
                            _vm._v(" "),
                            _vm._m(5),
                            _vm._v(" "),
                            _vm._m(6)
                          ]),
                          _vm._v(" "),
                          _c(
                            "tr",
                            { staticStyle: { "font-size": "11px" } },
                            [
                              _vm._l(_vm.workingHour, function(working, index) {
                                return [
                                  _c(
                                    "th",
                                    {
                                      staticClass: "text-center",
                                      style:
                                        _vm.workingHour.length == index + 1
                                          ? "border-right: 3px solid #ddd"
                                          : ""
                                    },
                                    [
                                      _vm._v(
                                        "\n                                                " +
                                          _vm._s(working.meaning) +
                                          "\n                                            "
                                      )
                                    ]
                                  )
                                ]
                              }),
                              _vm._v(" "),
                              _vm._l(_vm.workingHour, function(working, index) {
                                return [
                                  _c(
                                    "th",
                                    {
                                      staticClass: "text-center",
                                      style:
                                        _vm.workingHour.length == index + 1
                                          ? "border-right: 3px solid #ddd"
                                          : ""
                                    },
                                    [
                                      _vm._v(
                                        "\n                                                " +
                                          _vm._s(working.meaning) +
                                          "\n                                            "
                                      )
                                    ]
                                  )
                                ]
                              }),
                              _vm._v(" "),
                              _vm._l(_vm.workingHour, function(working, index) {
                                return [
                                  _c(
                                    "th",
                                    {
                                      staticClass: "text-center",
                                      style:
                                        _vm.workingHour.length == index + 1
                                          ? "border-right: 3px solid #ddd"
                                          : ""
                                    },
                                    [
                                      _vm._v(
                                        "\n                                                " +
                                          _vm._s(working.meaning) +
                                          "\n                                            "
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
                            _vm._l(_vm.yearlyOverview, function(
                              overviews,
                              period
                            ) {
                              return _vm._l(overviews, function(overview) {
                                return _c(
                                  "tr",
                                  { staticStyle: { "font-size": "11px" } },
                                  [
                                    _c("td", { staticClass: "text-center" }, [
                                      _vm._v(" " + _vm._s(overview.month) + " ")
                                    ]),
                                    _vm._v(" "),
                                    _vm._l(_vm.workingHour, function(
                                      working,
                                      index
                                    ) {
                                      return [
                                        _c(
                                          "td",
                                          {
                                            staticClass: "text-right",
                                            style:
                                              _vm.workingHour.length ==
                                              index + 1
                                                ? "border-right: 3px solid #ddd"
                                                : ""
                                          },
                                          [
                                            _vm._v(
                                              "\n                                                    " +
                                                _vm._s(
                                                  _vm._f("number2Digit")(
                                                    _vm.calEffMachine(
                                                      0,
                                                      working.attribute1,
                                                      overview.efficiency_machine_per_min,
                                                      100
                                                    )
                                                  )
                                                ) +
                                                "\n                                                "
                                            )
                                          ]
                                        )
                                      ]
                                    }),
                                    _vm._v(" "),
                                    _vm._l(_vm.workingHour, function(
                                      working,
                                      index
                                    ) {
                                      return [
                                        _c(
                                          "td",
                                          {
                                            staticClass: "text-right",
                                            style:
                                              _vm.workingHour.length ==
                                              index + 1
                                                ? "border-right: 3px solid #ddd"
                                                : ""
                                          },
                                          [
                                            _vm._v(
                                              "\n                                                    " +
                                                _vm._s(
                                                  _vm._f("number2Digit")(
                                                    _vm.calEffMachine(
                                                      period,
                                                      working.attribute1,
                                                      overview.efficiency_machine_per_min,
                                                      _vm.header
                                                        .efficiency_product
                                                    )
                                                  )
                                                ) +
                                                "\n                                                "
                                            )
                                          ]
                                        )
                                      ]
                                    }),
                                    _vm._v(" "),
                                    _vm._l(_vm.workingHour, function(
                                      working,
                                      index
                                    ) {
                                      return [
                                        _c(
                                          "td",
                                          {
                                            staticClass: "text-right",
                                            style:
                                              _vm.workingHour.length ==
                                              index + 1
                                                ? "border-right: 3px solid #ddd"
                                                : ""
                                          },
                                          [
                                            _c("WorkingDays", {
                                              attrs: {
                                                period: period,
                                                workingHour: working.attribute1,
                                                pWorkingDays: _vm.workingDays
                                              }
                                            })
                                          ],
                                          1
                                        )
                                      ]
                                    }),
                                    _vm._v(" "),
                                    _c("td", { staticClass: "text-right" }, [
                                      _vm._v(
                                        " " +
                                          _vm._s(
                                            _vm._f("number2Digit")(
                                              overview.eam_pm_eff_product
                                            )
                                          ) +
                                          " "
                                      )
                                    ]),
                                    _vm._v(" "),
                                    _c("td", { staticClass: "text-right" }, [
                                      _vm._v(
                                        " " +
                                          _vm._s(
                                            _vm._f("number2Digit")(
                                              overview.eam_dt_eff_product
                                            )
                                          ) +
                                          " "
                                      )
                                    ]),
                                    _vm._v(" "),
                                    _c("td", { staticClass: "text-right" }, [
                                      _vm._v(
                                        " " +
                                          _vm._s(
                                            _vm._f("number2Digit")(
                                              _vm.totalEffMachine[period]
                                            )
                                          ) +
                                          " "
                                      )
                                    ]),
                                    _vm._v(" "),
                                    _c("td", { staticClass: "text-right" }, [
                                      _vm._v(
                                        " " +
                                          _vm._s(
                                            _vm._f("number2Digit")(
                                              _vm.omSaleForcastOverview[
                                                period
                                              ][0]
                                            )
                                          ) +
                                          " "
                                      )
                                    ]),
                                    _vm._v(" "),
                                    _c("td", { staticClass: "text-right" }, [
                                      _vm._v(
                                        " " +
                                          _vm._s(
                                            _vm._f("number2Digit")(
                                              _vm.totalEffByMonth[period]
                                            )
                                          ) +
                                          " "
                                      )
                                    ])
                                  ],
                                  2
                                )
                              })
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
              _c("div", { staticClass: "modal-footer" }, [
                _c(
                  "button",
                  {
                    class: _vm.btnTrans.create.class + " btn-lg tw-w-25",
                    attrs: { type: "button" },
                    on: {
                      click: function($event) {
                        $event.preventDefault()
                        return _vm.submit($event)
                      }
                    }
                  },
                  [
                    _vm._v(
                      "\n                        บันทึก\n                    "
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
          staticStyle: { "font-size": "24px", "font-weight": "400" }
        },
        [
          _vm._v(
            "\n                        คำนวณภาพรวมการผลิตทั้งปีงบประมาณ\n                    "
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
    return _c(
      "div",
      {
        staticClass:
          "form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-4 col-xs-4 mt-2 text-right"
      },
      [
        _c("label", { staticClass: " tw-font-bold tw-uppercase mt-2" }, [
          _vm._v(" คงคลังต้นปีงบประมาณ ")
        ])
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "th",
      { staticClass: "text-center", attrs: { rowspan: "2", width: "10%" } },
      [_vm._v(" ผลผลิตช่วง PM "), _c("br"), _vm._v("(ล้านมวน) ")]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "th",
      { staticClass: "text-center", attrs: { rowspan: "2", width: "10%" } },
      [_vm._v(" ผลผลิตช่วง DT "), _c("br"), _vm._v("(ล้านมวน) ")]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "th",
      { staticClass: "text-center", attrs: { rowspan: "2", width: "10%" } },
      [_vm._v(" รวมสั่งผลิต "), _c("br"), _vm._v("(ล้านมวน) ")]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "th",
      { staticClass: "text-center", attrs: { rowspan: "2", width: "10%" } },
      [_vm._v(" ประมาณการจำหน่าย "), _c("br"), _vm._v("(ล้านมวน) ")]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "th",
      { staticClass: "text-center", attrs: { rowspan: "2", width: "12%" } },
      [_vm._v(" คงคลังสิ้นเดือน "), _c("br"), _vm._v("(ล้านมวน) ")]
    )
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/OMSalesForecast.vue?vue&type=template&id=14cb4941&":
/*!***************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/OMSalesForecast.vue?vue&type=template&id=14cb4941& ***!
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
  return _c("span", [
    _c(
      "button",
      {
        staticClass: "btn btn-info btn-md",
        staticStyle: { "padding-left": "7px" },
        on: { click: _vm.openModal }
      },
      [
        _c("i", { staticClass: "fa fa-eye" }),
        _vm._v(" รายละเอียดประมาณการจำหน่าย\n    ")
      ]
    ),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass: "modal fade",
        attrs: { id: "modal-om-sales", role: "dialog" }
      },
      [
        _c(
          "div",
          {
            staticClass: "modal-dialog modal-lg",
            staticStyle: { width: "90%", "max-width": "980px" }
          },
          [
            _c("div", { staticClass: "modal-content" }, [
              _vm._m(0),
              _vm._v(" "),
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
                  staticClass: "modal-body text-left"
                },
                [
                  _vm.pSaleForecasts.length <= 0
                    ? [_vm._m(1)]
                    : [
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
                                  "form-group pl-2 pr-2 mb-0 col-lg-2 col-md-4 col-sm-6 col-xs-6 mt-2"
                              },
                              [
                                _c(
                                  "label",
                                  {
                                    staticClass:
                                      " tw-font-bold tw-uppercase mb-1"
                                  },
                                  [_vm._v(" เดือน : ")]
                                ),
                                _vm._v(" "),
                                _c("span", [
                                  _vm._v(" " + _vm._s(_vm.omMonth) + " ")
                                ])
                              ]
                            ),
                            _vm._v(" "),
                            _c(
                              "div",
                              {
                                staticClass:
                                  "form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-6 col-xs-6 mt-2 text-left"
                              },
                              [
                                _c(
                                  "label",
                                  {
                                    staticClass:
                                      " tw-font-bold tw-uppercase mb-1"
                                  },
                                  [_vm._v(" ครั้งที่ : ")]
                                ),
                                _vm._v(" "),
                                _c(
                                  "el-select",
                                  {
                                    staticStyle: { width: "70%" },
                                    attrs: {
                                      placeholder: "ครั้งที่",
                                      size: "small",
                                      "popper-append-to-body": false
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
                                  _vm._l(_vm.versionLists, function(
                                    value,
                                    index
                                  ) {
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
                            ),
                            _vm._v(" "),
                            _c(
                              "div",
                              {
                                staticClass:
                                  "form-group pl-2 pr-2 mb-0 col-lg-3 col-md-4 col-sm-6 col-xs-6 mt-2 text-left"
                              },
                              [
                                _c(
                                  "label",
                                  {
                                    staticClass:
                                      " tw-font-bold tw-uppercase mb-1"
                                  },
                                  [_vm._v(" จำนวนวันขาย : ")]
                                ),
                                _vm._v(" "),
                                _c("span", [
                                  _vm._v(
                                    "\n                                    " +
                                      _vm._s(_vm.totalDayForOmSale) +
                                      " วัน\n                                "
                                  )
                                ])
                              ]
                            ),
                            _vm._v(" "),
                            _c(
                              "div",
                              {
                                staticClass:
                                  "form-group pl-2 pr-2 mb-0 col-lg-3 col-md-4 col-sm-6 col-xs-6 mt-2 text-left"
                              },
                              [
                                _c(
                                  "label",
                                  {
                                    staticClass:
                                      " tw-font-bold tw-uppercase mb-1"
                                  },
                                  [_vm._v(" วันที่อนุมัติ : ")]
                                ),
                                _vm._v(" "),
                                _c("span", [
                                  _vm._v(
                                    "\n                                    " +
                                      _vm._s(
                                        _vm.saleForecasts
                                          ? _vm.saleForecasts[0]
                                              .approve_date_format
                                          : ""
                                      ) +
                                      "\n                                "
                                  )
                                ])
                              ]
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c("div", { staticClass: "hr-line-dashed" }),
                        _vm._v(" "),
                        _c("table", { staticClass: "table table-bordered" }, [
                          _vm._m(2),
                          _vm._v(" "),
                          _c(
                            "tbody",
                            [
                              _vm.saleForecasts.length <= 0
                                ? [_vm._m(3)]
                                : [
                                    _vm._l(_vm.saleForecasts, function(
                                      saleForecast,
                                      index
                                    ) {
                                      return _c("tr", [
                                        _c(
                                          "td",
                                          { staticClass: "text-center" },
                                          [
                                            _c("div", [
                                              _vm._v(
                                                " " + _vm._s(index + 1) + " "
                                              )
                                            ])
                                          ]
                                        ),
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
                                        _c(
                                          "td",
                                          { staticClass: "text-right" },
                                          [
                                            _c("div", [
                                              _vm._v(
                                                "\n                                                " +
                                                  _vm._s(
                                                    _vm._f("number3Digit")(
                                                      saleForecast.forecast_qty
                                                    )
                                                  ) +
                                                  "\n                                            "
                                              )
                                            ])
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "td",
                                          { staticClass: "text-right" },
                                          [
                                            _c("div", [
                                              _vm._v(
                                                "\n                                                " +
                                                  _vm._s(
                                                    _vm._f("number3Digit")(
                                                      saleForecast.forecast_million_qty
                                                    )
                                                  ) +
                                                  "\n                                            "
                                              )
                                            ])
                                          ]
                                        )
                                      ])
                                    }),
                                    _vm._v(" "),
                                    _c("tr", [
                                      _c(
                                        "th",
                                        {
                                          staticClass: "text-right",
                                          attrs: { colspan: "3" }
                                        },
                                        [_vm._v("รวมประมาณจำหน่าย")]
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
                                            "\n                                            " +
                                              _vm._s(
                                                _vm._f("number3Digit")(
                                                  _vm.forecast_qty
                                                )
                                              ) +
                                              "\n                                        "
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
                                            "\n                                            " +
                                              _vm._s(
                                                _vm._f("number3Digit")(
                                                  _vm.forecast_million_qty
                                                )
                                              ) +
                                              "\n                                        "
                                          )
                                        ]
                                      )
                                    ])
                                  ]
                            ],
                            2
                          )
                        ])
                      ]
                ],
                2
              )
            ])
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
            "\n                        รายละเอียดประมาณการจำหน่าย\n                    "
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
    return _c("div", { staticClass: "col-12 text-center" }, [
      _c("h2", [_vm._v(" ไม่พบข้อมูลประมาณการจำหน่าย ")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle", width: "3%" }
          },
          [_c("div", [_vm._v(" ลำดับ ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle", width: "8%" }
          },
          [_c("div", [_vm._v(" รหัสบุหรี่ ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle", width: "20%" }
          },
          [_c("div", [_vm._v(" ตราบุหรี่ ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle", width: "10%" }
          },
          [
            _c("div", [
              _vm._v(" ประมาณการจำหน่าย"),
              _c("br"),
              _vm._v("(พันมวน) ")
            ])
          ]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle", width: "10%" }
          },
          [
            _c("div", [
              _vm._v(" ประมาณการจำหน่าย"),
              _c("br"),
              _vm._v("(ล้านมวน) ")
            ])
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
          attrs: { colspan: "5" }
        },
        [_c("h2", [_vm._v(" ไม่พบข้อมูลที่ค้นหาในระบบ ")])]
      )
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/WorkingDays.vue?vue&type=template&id=44ea2ee0&":
/*!***********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Yearly/WorkingDays.vue?vue&type=template&id=44ea2ee0& ***!
  \***********************************************************************************************************************************************************************************************************************************************/
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
    { staticClass: "text-right", staticStyle: { width: "45px" } },
    [
      _c("vue-numeric", {
        staticClass: "form-control input-sm text-right",
        staticStyle: { width: "100%", "font-size": "11px" },
        attrs: {
          name: "working_days",
          minus: false,
          min: 0,
          max: 99,
          autocomplete: "off"
        },
        on: {
          change: function($event) {
            return _vm.changeDays()
          },
          blur: function($event) {
            return _vm.changeDays()
          }
        },
        model: {
          value: _vm.value,
          callback: function($$v) {
            _vm.value = $$v
          },
          expression: "value"
        }
      })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);