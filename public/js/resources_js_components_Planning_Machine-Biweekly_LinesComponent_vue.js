(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_Planning_Machine-Biweekly_LinesComponent_vue"],{

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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/LinesComponent.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/LinesComponent.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var _ModalMachineDowntime_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./ModalMachineDowntime.vue */ "./resources/js/components/Planning/Machine-Biweekly/ModalMachineDowntime.vue");
/* harmony import */ var _Commons_Machine_EfficiencyMachineComponent_vue__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../Commons/Machine/EfficiencyMachineComponent.vue */ "./resources/js/components/Planning/Commons/Machine/EfficiencyMachineComponent.vue");
/* harmony import */ var _Commons_Machine_DateRangeDetail_vue__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../Commons/Machine/DateRangeDetail.vue */ "./resources/js/components/Planning/Commons/Machine/DateRangeDetail.vue");
/* harmony import */ var _Commons_Machine_EfficiencyDetail_vue__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../Commons/Machine/EfficiencyDetail.vue */ "./resources/js/components/Planning/Commons/Machine/EfficiencyDetail.vue");
/* harmony import */ var _OMSalesForecast_vue__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./OMSalesForecast.vue */ "./resources/js/components/Planning/Machine-Biweekly/OMSalesForecast.vue");
/* harmony import */ var _ModalHoliday_vue__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./ModalHoliday.vue */ "./resources/js/components/Planning/Machine-Biweekly/ModalHoliday.vue");
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! vue-numeric */ "./node_modules/vue-numeric/dist/vue-numeric.min.js");
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(vue_numeric__WEBPACK_IMPORTED_MODULE_9__);


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









/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    MachineDowntime: _ModalMachineDowntime_vue__WEBPACK_IMPORTED_MODULE_3__.default,
    EffMachine: _Commons_Machine_EfficiencyMachineComponent_vue__WEBPACK_IMPORTED_MODULE_4__.default,
    DateRangeDetail: _Commons_Machine_DateRangeDetail_vue__WEBPACK_IMPORTED_MODULE_5__.default,
    EfficiencyDetail: _Commons_Machine_EfficiencyDetail_vue__WEBPACK_IMPORTED_MODULE_6__.default,
    OMSalesForecast: _OMSalesForecast_vue__WEBPACK_IMPORTED_MODULE_7__.default,
    ModalHol: _ModalHoliday_vue__WEBPACK_IMPORTED_MODULE_8__.default,
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_9___default())
  },
  props: ['pLines', 'pResPlanDate', 'pEfficiencyMachinePercent', 'pEfficiencyProductPercent', 'pWorkingHour', 'pWorkingHoliday', 'pEamperformanceMachines', 'pEfficiencyMachines', 'pEfficiencyProducts', 'pHeader', 'pMachineMaintenances', 'pMachineDowntimes', 'pHolidays', 'updateEditFlag', 'pShowFlag', 'pMachineGroups', 'pMachineDesc', 'btnTrans', 'pDateFormat', 'url', 'search', 'pMachineDtLines', 'pSaleForecastsHtml', 'pEfficiencyFullProducts', 'pSaleForecasts', 'versionLists', 'holidaysHtml', 'lastUpdate'],
  data: function data() {
    return {
      header: this.pHeader,
      lines: this.pLines,
      resPlanDate: this.pResPlanDate,
      efficiency_machine: this.pEfficiencyMachinePercent,
      efficiency_product: this.pEfficiencyProductPercent,
      working_hour: this.pWorkingHour,
      working_holiday: [],
      efficiencyProducts: this.pEfficiencyProducts,
      machineMaintenances: this.pMachineMaintenances,
      machineDowntimes: this.pMachineDowntimes,
      holidays: this.pHolidays,
      edit_flag: false,
      show_flag: this.pShowFlag,
      loading: false,
      valid_action: false,
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
      // Piyawut A. 20211102--Issue
      checkDate: {
        current_date: '',
        start_date: '',
        end_date: ''
      },
      isControlDisable: false,
      isCurrBiweekly: false,
      efficiencyDayFormula: '',
      efficiencyMachineFormula: '',
      note_description: this.pHeader.note_description,
      per_unit: '',
      // Full efficiency: 100%
      efficiencyFullProducts: this.pEfficiencyFullProducts,
      totalFullProductArr: {},
      // New Requirement : แจ้งเตือน PM Confirm to text
      messageCheckPMHtml: '',
      messageCheckMachineHtml: ''
    };
  },
  mounted: function mounted() {
    this.loading = true;
    this.getUnitProductType();
    this.getWorkingHour();
    this.getDateByBiWeekly(); // this.checkPMConfirm();
    // this.checkMachineDetail();
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
            } // resT = Number(parseFloat(t)).toFixed(2);
            // resT = parseFloat(Number(t).toFixed(2));


            resT = Math.floor(Number(t) * 100) / 100;
            vue.efficiencyProducts[planDate.res_plan_date_display][line.machine_name] = resT; // เพิ่ม efficiency full product 100% -- 20112021

            var fr = Number(f) * (100 / 100) / 1000000;
            var ft = fr <= 0 ? 0 : fr;

            if (vue.machineDowntimes[planDate.res_plan_date_display][line.machine_name] == 'Y' || vue.machineMaintenances[planDate.res_plan_date_display][line.machine_name] == 'Y') {
              ft = ft * 0;
            } // resFT = Number(parseFloat(ft)).toFixed(2);
            // resFT = parseFloat(Number(ft).toFixed(2));


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
              // || vue.holidays[planDate][line.machine_name] == 'Y'
              // || vue.holidays[planDate][line.machine_name] == 'P'
              res[planDate].total += 0;
            } else {
              res[planDate].total += Number(vue.efficiencyProducts[planDate][line.machine_name]);
            } // res[planDate].total += Number(vue.efficiencyProducts[planDate][line.machine_name]);

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
      vue.pSaleForecasts.filter(function (line) {
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
    pShowFlag: function () {
      var _pShowFlag = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee(newValue) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                this.show_flag = newValue;

              case 1:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this);
      }));

      function pShowFlag(_x) {
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
    changeEfficiencyMachineByLine: function changeEfficiencyMachineByLine(machineGroup, index) {
      console.log(machineGroup);
      var vue = this; //efficiency_machine_per_min

      var d = Number(vue.lines[machineGroup][index].machine_speed) * (Number(vue.lines[machineGroup][index].machine_eamperformance) / 100); //efficiency_product

      vue.resPlanDate.filter(function (planDate) {
        var f = Number(d) * (Number(planDate.working_hour) - 1) * 60;
        var r = Number(f) * (Number(vue.efficiency_product) / 100) / 1000000;
        var t = r <= 0 ? 0 : r;
        Object.values(vue.efficiencyProducts[planDate.res_plan_date_display]).filter(function (res, value) {
          // vue.efficiencyProducts[planDate.res_plan_date_display][vue.lines[machineGroup][index].machine_name] = Number(t.toFixed(3));
          vue.efficiencyProducts[planDate.res_plan_date_display][vue.lines[machineGroup][index].machine_name] = Math.floor(Number(t) * 100) / 100;
        });
      }); //result

      vue.lines[machineGroup][index].efficiency_machine_per_min = d; //Stamp line ที่มีการแก้ไขจำนวน Efficiency

      Vue.set(vue.lineMachineEdit, vue.lines[machineGroup][index].machine_name, Number(vue.lines[machineGroup][index].machine_eamperformance));
    },
    // FOR G -- PTPP_MACHINE_BIWEEKLY_HEADERS
    updateDataEfficiencyProduct: function updateDataEfficiencyProduct() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var res;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                if (!_this.valid_action) {
                  _context2.next = 3;
                  break;
                }

                swal({
                  title: 'บันทึกหรือยกเลิกการเปลี่ยนแปลงข้อมูล',
                  text: '<span style="font-size: 16px; text-align: left;"> กรุณาทำการบันทึกหรือยกเลิกการเปลี่ยนแปลงให้เรียบร้อย </span>',
                  type: "warning",
                  html: true
                });
                return _context2.abrupt("return");

              case 3:
                _this.loading = true;
                _context2.next = 6;
                return _this.updateMachineHeaderTransactions({
                  //update All
                  efficiency_product: _this.efficiency_product,
                  machine_eamperformance: null,
                  //update By Line
                  res_plan_date: null,
                  working_hour: null,
                  machine_name: null
                });

              case 6:
                res = _context2.sent;

                if (res.status == 'S') {
                  swal({
                    title: 'เปลี่ยนแปลงสั่งผลิต (%)',
                    text: '<span style="font-size: 16px; text-align: left;"> ทำการเปลี่ยนแปลงสั่งผลิตเรียบร้อยแล้ว </span>',
                    type: "success",
                    html: true
                  });
                  _this.loading = false; //redirect

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
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    // FOR C -- PTPP_MACHINE_BIWEEKLY_HEADERS
    updateDataEfficiencyMachine: function updateDataEfficiencyMachine() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var res;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                if (!_this2.valid_action) {
                  _context3.next = 3;
                  break;
                }

                swal({
                  title: 'บันทึกหรือยกเลิกการเปลี่ยนแปลงข้อมูล',
                  text: '<span style="font-size: 16px; text-align: left;"> กรุณาทำการบันทึกหรือยกเลิกการเปลี่ยนแปลงให้เรียบร้อย </span>',
                  type: "warning",
                  html: true
                });
                return _context3.abrupt("return");

              case 3:
                _this2.loading = true;
                _context3.next = 6;
                return _this2.updateMachineHeaderTransactions({
                  //update All
                  efficiency_product: null,
                  machine_eamperformance: _this2.efficiency_machine,
                  //update By Line
                  res_plan_date: null,
                  working_hour: null,
                  machine_name: null
                });

              case 6:
                res = _context3.sent;

                if (res.status == 'S') {
                  swal({
                    title: 'เปลี่ยนแปลงประสิทธิภาพเครื่องจักร (%)',
                    text: '<span style="font-size: 16px; text-align: left;"> ทำการเปลี่ยนแปลงประสิทธิภาพเครื่องจักรเรียบร้อยแล้ว </span>',
                    type: "success",
                    html: true
                  });
                  _this2.loading = false; //redirect

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
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    updateMachineHeaderTransactions: function updateMachineHeaderTransactions(value) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        var data;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                data = [];
                _context4.next = 3;
                return axios.post("/planning/machine-biweekly/" + _this3.header.res_plan_h_id + "/update", value).then(function (res) {
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
                return _context4.abrupt("return", data);

              case 4:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    // FOR C/E -- PTPP_MACHINE_BIWEEKLY_LINES อัพเดตทั้งสองค่าของระดับไลน์
    updateDataEfficiencyMachineByLine: function updateDataEfficiencyMachineByLine() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        var res;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                _this4.loading = true;
                _context5.next = 3;
                return _this4.updateMachineTransactions();

              case 3:
                res = _context5.sent;

                if (res.status == 'S') {
                  swal({
                    title: 'เปลี่ยนแปลงข้อมูล',
                    text: '<span style="font-size: 16px; text-align: left;"> ทำการเปลี่ยนแปลงวันที่แพลนและประสิทธิภาพเครื่องจักรเรียบร้อยแล้ว </span>',
                    type: "success",
                    html: true
                  });
                  _this4.loading = false; //redirect

                  window.setTimeout(function () {
                    window.location.reload();
                  }, 2000);
                } else if (res.status == 'W') {
                  _this4.edit_flag = false;
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
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    updateMachineTransactions: function updateMachineTransactions() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6() {
        var data;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                data = [];
                _context6.next = 3;
                return axios.post("/planning/machine-biweekly/" + _this5.header.res_plan_h_id + "/update-lines", {
                  lineMachines: _this5.lineMachineEdit,
                  workingHours: _this5.workingHourEdit,
                  note: _this5.note_description
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
                  _this5.loading = false;
                });

              case 3:
                return _context6.abrupt("return", data);

              case 4:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
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
    getWorkingHour: function getWorkingHour() {
      var _this6 = this;

      this.pWorkingHoliday.filter(function (item) {
        _this6.working_holiday.push({
          attribute1: Number(item.attribute1),
          lookup_code: item.lookup_code,
          meaning: item.meaning
        });
      });
      this.loading = false;
    },
    checkUpdatePlanPM: function checkUpdatePlanPM() {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee7() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                vm = _this7;

                if (!vm.valid_action) {
                  _context7.next = 4;
                  break;
                }

                swal({
                  title: 'บันทึกหรือยกเลิกการเปลี่ยนแปลงข้อมูล',
                  text: '<span style="font-size: 16px; text-align: left;"> กรุณาทำการบันทึกหรือยกเลิกการเปลี่ยนแปลงให้เรียบร้อย </span>',
                  type: "warning",
                  html: true
                });
                return _context7.abrupt("return");

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
                return _context7.stop();
            }
          }
        }, _callee7);
      }))();
    },
    updatePlanPM: function updatePlanPM() {
      var _this8 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee8() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee8$(_context8) {
          while (1) {
            switch (_context8.prev = _context8.next) {
              case 0:
                vm = _this8;
                vm.loading = false;
                _context8.next = 4;
                return axios.post(vm.url.update_plan_pm, {
                  product_type: vm.header.product_type,
                  biweekly_id: vm.header.biweekly_id
                }).then(function (res) {
                  swal({
                    title: 'เปลี่ยนแปลงแผนซ่อมบำรุง',
                    text: '<span style="font-size: 16px; text-align: left;"> อัพเดตการเปลี่ยนแปลงแผนซ่อมบำรุงภายในปักษ์ที่ ' + vm.search.bi_weekly + ' เรียบร้อยแล้ว </span>',
                    type: "success",
                    html: true
                  }); //redirect

                  window.setTimeout(function () {
                    window.location.reload();
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
                  vm.loading = true;
                });

              case 4:
              case "end":
                return _context8.stop();
            }
          }
        }, _callee8);
      }))();
    },
    checkUpdateMachine: function checkUpdateMachine() {
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
                return _context9.stop();
            }
          }
        }, _callee9);
      }))();
    },
    updateMachine: function updateMachine() {
      var _this10 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee10() {
        var vm, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee10$(_context10) {
          while (1) {
            switch (_context10.prev = _context10.next) {
              case 0:
                vm = _this10;
                params = {
                  budget_year: vm.header.budget_year,
                  month: vm.header.period_num,
                  bi_weekly: vm.header.biweekly
                };
                _context10.next = 4;
                return axios.post(vm.url.update_machine_p03, {
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
                return _context10.stop();
            }
          }
        }, _callee10);
      }))();
    },
    getDateByBiWeekly: function getDateByBiWeekly() {
      var vm = this;
      var date_from = vm.header.pp_bi_weekly.start_date;
      var date_to = vm.header.pp_bi_weekly.end_date;
      var curr_date = moment__WEBPACK_IMPORTED_MODULE_1___default()().format('YYYY-MM-DD'); // วันที่ที่ใช้ในการเช็คเงื่อนไข

      vm.checkDate.current_date = curr_date;
      vm.checkDate.start_date = moment__WEBPACK_IMPORTED_MODULE_1___default()(date_from).format('YYYY-MM-DD');
      vm.checkDate.end_date = moment__WEBPACK_IMPORTED_MODULE_1___default()(date_to).format('YYYY-MM-DD'); //check disable process

      if (vm.checkDate.current_date > vm.checkDate.start_date && vm.checkDate.current_date > vm.checkDate.end_date) {
        vm.isControlDisable = true;
      } // check current biweekly
      // if(vm.checkDate.current_date >= vm.checkDate.start_date && vm.checkDate.current_date <= vm.checkDate.end_date){
      // 05102022 เปลี่ยนการทำงานให้สามารถสร้างและแก้ไขได้ล่วงหน้า และภายในปักษ์


      if (vm.checkDate.current_date >= vm.checkDate.start_date && vm.checkDate.current_date <= vm.checkDate.end_date || vm.checkDate.current_date < vm.checkDate.start_date && vm.checkDate.current_date < vm.checkDate.end_date) {
        vm.isCurrBiweekly = true;
      } // get check PM/Machine


      if (!vm.isControlDisable && vm.isCurrBiweekly) {
        this.checkPMConfirm();
        this.checkMachineDetail();
      }
    },
    selMachine: function selMachine(machineName) {// this.sel_machine = machineName;
    },
    editProcess: function editProcess(editFlag) {
      var vm = this;
      vm.valid_action = editFlag;
      vm.note_description = this.header.note_description;
      vm.$emit('updateEditFlag', editFlag);
    },
    checkPMConfirm: function checkPMConfirm() {
      var _this11 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee11() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee11$(_context11) {
          while (1) {
            switch (_context11.prev = _context11.next) {
              case 0:
                vm = _this11;
                _context11.next = 3;
                return axios.get(vm.url.check_pm_confirm_p03).then(function (res) {
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

              case 3:
              case "end":
                return _context11.stop();
            }
          }
        }, _callee11);
      }))();
    },
    checkMachineDetail: function checkMachineDetail() {
      var _this12 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee12() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee12$(_context12) {
          while (1) {
            switch (_context12.prev = _context12.next) {
              case 0:
                vm = _this12;
                _context12.next = 3;
                return axios.get(vm.url.check_machine_detail_p03).then(function (res) {
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

              case 3:
              case "end":
                return _context12.stop();
            }
          }
        }, _callee12);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/MachineList.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/MachineList.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************************************************/
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
  props: ["index", "attribute", "header", "machineGroups", "machineDesc", "dateFormat", "listMachineLines"],
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
    dateWasSelectedFrom: function dateWasSelectedFrom(dateFrom) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var vm, form;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                vm = _this;
                form = $('#machine-downtime-form');
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

              case 6:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
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
    remove: function remove(machineLine) {
      this.$emit("removeRow", machineLine);
    },
    // ดึงข้อมูลเมื่อกดปรับ
    getDateByBiWeekly: function getDateByBiWeekly() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var vm, date_from, date_to, dt_date_from, dt_date_to, curr_date, currentDate, startDate, endDate, dtStartDate, dtEndDate;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                vm = _this2;
                date_from = vm.header.pp_bi_weekly.start_date;
                date_to = vm.header.pp_bi_weekly.end_date;
                dt_date_from = vm.machineLine.start_date != '' ? moment__WEBPACK_IMPORTED_MODULE_2___default()(vm.machineLine.start_date).format('YYYY-MM-DD') : vm.header.pp_bi_weekly.start_date;
                dt_date_to = vm.machineLine.end_date != '' ? moment__WEBPACK_IMPORTED_MODULE_2___default()(vm.machineLine.end_date).format('YYYY-MM-DD') : vm.header.pp_bi_weekly.end_date;
                curr_date = moment__WEBPACK_IMPORTED_MODULE_2___default()().format('YYYY-MM-DD');
                _context2.next = 8;
                return helperDate.parseToDateTh(curr_date, 'YYYY-MM-DD');

              case 8:
                currentDate = _context2.sent;
                _context2.next = 11;
                return helperDate.parseToDateTh(date_from, 'YYYY-MM-DD');

              case 11:
                startDate = _context2.sent;
                _context2.next = 14;
                return helperDate.parseToDateTh(date_to, 'YYYY-MM-DD');

              case 14:
                endDate = _context2.sent;
                _context2.next = 17;
                return helperDate.parseToDateTh(dt_date_from, 'YYYY-MM-DD');

              case 17:
                dtStartDate = _context2.sent;
                _context2.next = 20;
                return helperDate.parseToDateTh(dt_date_to, 'YYYY-MM-DD');

              case 20:
                dtEndDate = _context2.sent;
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
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    changeThToEn: function changeThToEn(dateTh) {
      // เปลี่ยน Format และ เปลี่ยน พศ -> คศ
      var vm = this;
      var date = moment__WEBPACK_IMPORTED_MODULE_2___default()(dateTh, 'YYYY-MM-DD');
      date.subtract(543, 'years');
      return date.format('YYYY-MM-DD');
    },
    setError: function setError(ref_name) {
      var ref = this.$refs[ref_name].$refs.reference ? this.$refs[ref_name].$refs.reference.$refs.input : this.$refs[ref_name].$refs.textarea ? this.$refs[ref_name].$refs.textarea : this.$refs[ref_name].$refs.input.$refs ? this.$refs[ref_name].$refs.input.$refs.input : this.$refs[ref_name].$refs.input;
      ref.style = "border: 1px solid red;";
    },
    resetError: function resetError(ref_name) {
      var ref = this.$refs[ref_name].$refs.reference ? this.$refs[ref_name].$refs.reference.$refs.input : this.$refs[ref_name].$refs.textarea ? this.$refs[ref_name].$refs.textarea : this.$refs[ref_name].$refs.input.$refs ? this.$refs[ref_name].$refs.input.$refs.input : this.$refs[ref_name].$refs.input;
      ref.style = "";
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/ModalHoliday.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/ModalHoliday.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************************************************************/
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
                return axios.post(vm.url.ajax_refresh_holiday, {
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/ModalMachineDowntime.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/ModalMachineDowntime.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var _MachineList_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./MachineList.vue */ "./resources/js/components/Planning/Machine-Biweekly/MachineList.vue");


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



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    MachineList: _MachineList_vue__WEBPACK_IMPORTED_MODULE_3__.default
  },
  props: ['header', 'machineGroups', 'machineDesc', 'btnTrans', 'dateFormat', 'url', 'machineDtLines', 'validAction'],
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
      removeMachineDt: [] //push arr data remove item

    };
  },
  mounted: function mounted() {
    this.getDateByBiWeekly();

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
                    window.location.reload();
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
    getDateByBiWeekly: function getDateByBiWeekly() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        var vm, date_from, date_to, curr_date, currentDate, startDate, endDate;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                vm = _this5;
                date_from = vm.header.pp_bi_weekly.start_date;
                date_to = vm.header.pp_bi_weekly.end_date;
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
                // if((vm.checkDate.current_date <= vm.checkDate.start_date || vm.checkDate.current_date >= vm.checkDate.start_date)
                // && vm.checkDate.current_date <= vm.checkDate.end_date){

                if (vm.checkDate.current_date >= vm.checkDate.start_date && vm.checkDate.current_date <= vm.checkDate.end_date || vm.checkDate.current_date < vm.checkDate.start_date && vm.checkDate.current_date < vm.checkDate.end_date) {
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/OMSalesForecast.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/OMSalesForecast.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************************************/
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
  props: ["omSalesForecast", "pSaleForecasts", 'versionLists', 'url'],
  data: function data() {
    return {
      forecast_qty: 0,
      forecast_million_qty: 0,
      loading: false,
      saleForecasts: this.pSaleForecasts ? this.pSaleForecasts : [],
      version_no: this.pSaleForecasts ? this.pSaleForecasts[0].version : 0
    };
  },
  mounted: function mounted() {//
  },
  computed: {
    totalForecast: function totalForecast() {
      var vm = this;
      var total_forecast_qty = 0;
      var total_forecast_million_qty = 0;
      vm.saleForecasts.filter(function (line) {
        total_forecast_qty += Number(line.forecast_qty);
        total_forecast_million_qty += Number(line.forecast_million_qty);
      });
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
                  budget_year: vm.saleForecasts[0].om_bi_weekly.budget_year,
                  biweekly_id: vm.saleForecasts[0].biweekly_id
                };
                _context.next = 5;
                return axios.post(vm.url.ajax_get_sales_forecast_version, {
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

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/LinesComponent.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/LinesComponent.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/MachineList.vue?vue&type=style&index=0&media=screen&lang=css&":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/MachineList.vue?vue&type=style&index=0&media=screen&lang=css& ***!
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
___CSS_LOADER_EXPORT___.push([module.id, "div.el-dialog__body{\n  padding-left: 50px;\n  padding-right: 50px;\n  padding-top: 5px;\n  padding-bottom: 5px;\n  color: #000;\n  font-size: 15px;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/LinesComponent.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/LinesComponent.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_LinesComponent_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./LinesComponent.vue?vue&type=style&index=0&scope=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/LinesComponent.vue?vue&type=style&index=0&scope=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_LinesComponent_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_LinesComponent_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/MachineList.vue?vue&type=style&index=0&media=screen&lang=css&":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/MachineList.vue?vue&type=style&index=0&media=screen&lang=css& ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_MachineList_vue_vue_type_style_index_0_media_screen_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./MachineList.vue?vue&type=style&index=0&media=screen&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/MachineList.vue?vue&type=style&index=0&media=screen&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_MachineList_vue_vue_type_style_index_0_media_screen_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_MachineList_vue_vue_type_style_index_0_media_screen_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_OMSalesForecast_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css&");

            

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

/***/ "./resources/js/components/Planning/Machine-Biweekly/LinesComponent.vue":
/*!******************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Biweekly/LinesComponent.vue ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _LinesComponent_vue_vue_type_template_id_7c5082b8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./LinesComponent.vue?vue&type=template&id=7c5082b8& */ "./resources/js/components/Planning/Machine-Biweekly/LinesComponent.vue?vue&type=template&id=7c5082b8&");
/* harmony import */ var _LinesComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./LinesComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Machine-Biweekly/LinesComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _LinesComponent_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./LinesComponent.vue?vue&type=style&index=0&scope=true&lang=css& */ "./resources/js/components/Planning/Machine-Biweekly/LinesComponent.vue?vue&type=style&index=0&scope=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _LinesComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _LinesComponent_vue_vue_type_template_id_7c5082b8___WEBPACK_IMPORTED_MODULE_0__.render,
  _LinesComponent_vue_vue_type_template_id_7c5082b8___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Machine-Biweekly/LinesComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Machine-Biweekly/MachineList.vue":
/*!***************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Biweekly/MachineList.vue ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _MachineList_vue_vue_type_template_id_5865830a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./MachineList.vue?vue&type=template&id=5865830a& */ "./resources/js/components/Planning/Machine-Biweekly/MachineList.vue?vue&type=template&id=5865830a&");
/* harmony import */ var _MachineList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./MachineList.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Machine-Biweekly/MachineList.vue?vue&type=script&lang=js&");
/* harmony import */ var _MachineList_vue_vue_type_style_index_0_media_screen_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./MachineList.vue?vue&type=style&index=0&media=screen&lang=css& */ "./resources/js/components/Planning/Machine-Biweekly/MachineList.vue?vue&type=style&index=0&media=screen&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _MachineList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _MachineList_vue_vue_type_template_id_5865830a___WEBPACK_IMPORTED_MODULE_0__.render,
  _MachineList_vue_vue_type_template_id_5865830a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Machine-Biweekly/MachineList.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Machine-Biweekly/ModalHoliday.vue":
/*!****************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Biweekly/ModalHoliday.vue ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ModalHoliday_vue_vue_type_template_id_726f5e36___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ModalHoliday.vue?vue&type=template&id=726f5e36& */ "./resources/js/components/Planning/Machine-Biweekly/ModalHoliday.vue?vue&type=template&id=726f5e36&");
/* harmony import */ var _ModalHoliday_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalHoliday.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Machine-Biweekly/ModalHoliday.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _ModalHoliday_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ModalHoliday_vue_vue_type_template_id_726f5e36___WEBPACK_IMPORTED_MODULE_0__.render,
  _ModalHoliday_vue_vue_type_template_id_726f5e36___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Machine-Biweekly/ModalHoliday.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Machine-Biweekly/ModalMachineDowntime.vue":
/*!************************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Biweekly/ModalMachineDowntime.vue ***!
  \************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ModalMachineDowntime_vue_vue_type_template_id_3e2d873a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ModalMachineDowntime.vue?vue&type=template&id=3e2d873a& */ "./resources/js/components/Planning/Machine-Biweekly/ModalMachineDowntime.vue?vue&type=template&id=3e2d873a&");
/* harmony import */ var _ModalMachineDowntime_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalMachineDowntime.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Machine-Biweekly/ModalMachineDowntime.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _ModalMachineDowntime_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ModalMachineDowntime_vue_vue_type_template_id_3e2d873a___WEBPACK_IMPORTED_MODULE_0__.render,
  _ModalMachineDowntime_vue_vue_type_template_id_3e2d873a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Machine-Biweekly/ModalMachineDowntime.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Machine-Biweekly/OMSalesForecast.vue":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Biweekly/OMSalesForecast.vue ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _OMSalesForecast_vue_vue_type_template_id_c9ab3c02___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./OMSalesForecast.vue?vue&type=template&id=c9ab3c02& */ "./resources/js/components/Planning/Machine-Biweekly/OMSalesForecast.vue?vue&type=template&id=c9ab3c02&");
/* harmony import */ var _OMSalesForecast_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./OMSalesForecast.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Machine-Biweekly/OMSalesForecast.vue?vue&type=script&lang=js&");
/* harmony import */ var _OMSalesForecast_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css& */ "./resources/js/components/Planning/Machine-Biweekly/OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _OMSalesForecast_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _OMSalesForecast_vue_vue_type_template_id_c9ab3c02___WEBPACK_IMPORTED_MODULE_0__.render,
  _OMSalesForecast_vue_vue_type_template_id_c9ab3c02___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Machine-Biweekly/OMSalesForecast.vue"
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

/***/ "./resources/js/components/Planning/Machine-Biweekly/LinesComponent.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Biweekly/LinesComponent.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_LinesComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./LinesComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/LinesComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_LinesComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Machine-Biweekly/MachineList.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Biweekly/MachineList.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MachineList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./MachineList.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/MachineList.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MachineList_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Machine-Biweekly/ModalHoliday.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Biweekly/ModalHoliday.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalHoliday_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalHoliday.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/ModalHoliday.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalHoliday_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Machine-Biweekly/ModalMachineDowntime.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Biweekly/ModalMachineDowntime.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalMachineDowntime_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalMachineDowntime.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/ModalMachineDowntime.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalMachineDowntime_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Machine-Biweekly/OMSalesForecast.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Biweekly/OMSalesForecast.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_OMSalesForecast_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./OMSalesForecast.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/OMSalesForecast.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_OMSalesForecast_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Machine-Biweekly/LinesComponent.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!**************************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Biweekly/LinesComponent.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \**************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_LinesComponent_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./LinesComponent.vue?vue&type=style&index=0&scope=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/LinesComponent.vue?vue&type=style&index=0&scope=true&lang=css&");


/***/ }),

/***/ "./resources/js/components/Planning/Machine-Biweekly/MachineList.vue?vue&type=style&index=0&media=screen&lang=css&":
/*!*************************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Biweekly/MachineList.vue?vue&type=style&index=0&media=screen&lang=css& ***!
  \*************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_MachineList_vue_vue_type_style_index_0_media_screen_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./MachineList.vue?vue&type=style&index=0&media=screen&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/MachineList.vue?vue&type=style&index=0&media=screen&lang=css&");


/***/ }),

/***/ "./resources/js/components/Planning/Machine-Biweekly/OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!***************************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Biweekly/OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \***************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_OMSalesForecast_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/OMSalesForecast.vue?vue&type=style&index=0&scope=true&lang=css&");


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

/***/ "./resources/js/components/Planning/Machine-Biweekly/LinesComponent.vue?vue&type=template&id=7c5082b8&":
/*!*************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Biweekly/LinesComponent.vue?vue&type=template&id=7c5082b8& ***!
  \*************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_LinesComponent_vue_vue_type_template_id_7c5082b8___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_LinesComponent_vue_vue_type_template_id_7c5082b8___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_LinesComponent_vue_vue_type_template_id_7c5082b8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./LinesComponent.vue?vue&type=template&id=7c5082b8& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/LinesComponent.vue?vue&type=template&id=7c5082b8&");


/***/ }),

/***/ "./resources/js/components/Planning/Machine-Biweekly/MachineList.vue?vue&type=template&id=5865830a&":
/*!**********************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Biweekly/MachineList.vue?vue&type=template&id=5865830a& ***!
  \**********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MachineList_vue_vue_type_template_id_5865830a___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MachineList_vue_vue_type_template_id_5865830a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MachineList_vue_vue_type_template_id_5865830a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./MachineList.vue?vue&type=template&id=5865830a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/MachineList.vue?vue&type=template&id=5865830a&");


/***/ }),

/***/ "./resources/js/components/Planning/Machine-Biweekly/ModalHoliday.vue?vue&type=template&id=726f5e36&":
/*!***********************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Biweekly/ModalHoliday.vue?vue&type=template&id=726f5e36& ***!
  \***********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalHoliday_vue_vue_type_template_id_726f5e36___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalHoliday_vue_vue_type_template_id_726f5e36___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalHoliday_vue_vue_type_template_id_726f5e36___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalHoliday.vue?vue&type=template&id=726f5e36& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/ModalHoliday.vue?vue&type=template&id=726f5e36&");


/***/ }),

/***/ "./resources/js/components/Planning/Machine-Biweekly/ModalMachineDowntime.vue?vue&type=template&id=3e2d873a&":
/*!*******************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Biweekly/ModalMachineDowntime.vue?vue&type=template&id=3e2d873a& ***!
  \*******************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalMachineDowntime_vue_vue_type_template_id_3e2d873a___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalMachineDowntime_vue_vue_type_template_id_3e2d873a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalMachineDowntime_vue_vue_type_template_id_3e2d873a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalMachineDowntime.vue?vue&type=template&id=3e2d873a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/ModalMachineDowntime.vue?vue&type=template&id=3e2d873a&");


/***/ }),

/***/ "./resources/js/components/Planning/Machine-Biweekly/OMSalesForecast.vue?vue&type=template&id=c9ab3c02&":
/*!**************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Machine-Biweekly/OMSalesForecast.vue?vue&type=template&id=c9ab3c02& ***!
  \**************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_OMSalesForecast_vue_vue_type_template_id_c9ab3c02___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_OMSalesForecast_vue_vue_type_template_id_c9ab3c02___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_OMSalesForecast_vue_vue_type_template_id_c9ab3c02___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./OMSalesForecast.vue?vue&type=template&id=c9ab3c02& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/OMSalesForecast.vue?vue&type=template&id=c9ab3c02&");


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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/LinesComponent.vue?vue&type=template&id=7c5082b8&":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/LinesComponent.vue?vue&type=template&id=7c5082b8& ***!
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
      !_vm.header ? [_vm._m(0)] : _vm._e(),
      _vm._v(" "),
      _vm.show_flag && _vm.header
        ? _c(
            "div",
            [
              _c("div", { staticClass: "row m-2" }, [
                _c(
                  "div",
                  { staticClass: "col-lg-6 col-md-6 col-sm-4 col-xs-4 mt-2" },
                  [
                    _c(
                      "div",
                      { staticClass: "tw-font-bold tw-uppercase mb-1" },
                      [
                        _c(
                          "h2",
                          { staticClass: "tw-font-bold" },
                          [
                            _c("efficiency-detail", {
                              attrs: {
                                total: _vm.totalProductAll,
                                unit: _vm.unit
                              }
                            })
                          ],
                          1
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
                    )
                  ]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    staticClass:
                      "col-lg-6 col-md-6 col-sm-4 col-xs-4 mt-2 text-right"
                  },
                  [
                    _c(
                      "div",
                      { staticClass: "col-12 p-0" },
                      [
                        _vm.header
                          ? [
                              _c(
                                "div",
                                { staticClass: "text-right" },
                                [
                                  _c("ModalHol", {
                                    attrs: {
                                      holidaysHtml: _vm.holidaysHtml,
                                      lastUpdate: _vm.lastUpdate,
                                      budgetYear: _vm.header.budget_year,
                                      url: _vm.url
                                    }
                                  }),
                                  _vm._v(" "),
                                  _vm.header.product_type != "KK"
                                    ? _c("OMSalesForecast", {
                                        attrs: {
                                          omSalesForecast:
                                            _vm.pSaleForecastsHtml,
                                          pSaleForecasts: _vm.pSaleForecasts,
                                          versionLists: _vm.versionLists,
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
                                  !_vm.isControlDisable && _vm.isCurrBiweekly
                                    ? _c(
                                        "button",
                                        {
                                          staticClass: "btn btn-warning btn-md",
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
                                            " อัพเดตรายละเอียดเครื่องจักร\n                            "
                                          )
                                        ]
                                      )
                                    : _vm._e(),
                                  _vm._v(" "),
                                  !_vm.isControlDisable && _vm.isCurrBiweekly
                                    ? _c(
                                        "button",
                                        {
                                          staticClass: "btn btn-warning btn-md",
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
                                            " อัพเดตแผนซ่อมบำรุง\n                            "
                                          )
                                        ]
                                      )
                                    : _vm._e(),
                                  _vm._v(" "),
                                  !_vm.isControlDisable && _vm.isCurrBiweekly
                                    ? _c("machine-downtime", {
                                        attrs: {
                                          header: _vm.header,
                                          "machine-groups": _vm.pMachineGroups,
                                          "machine-desc": _vm.pMachineDesc,
                                          "btn-trans": _vm.btnTrans,
                                          "date-format": _vm.pDateFormat,
                                          "machine-dt-lines":
                                            _vm.pMachineDtLines,
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
                    _vm.header
                      ? _c("div", { staticClass: "row m-2" }, [
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
                                "form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-4 col-xs-4",
                              staticStyle: { "margin-top": "30px" }
                            },
                            [
                              !_vm.isControlDisable && _vm.isCurrBiweekly
                                ? _c(
                                    "button",
                                    {
                                      staticClass:
                                        "btn btn-success btn-md text-left",
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
                                        "\n                        ยืนยันเปลี่ยนแปลงประสิทธิภาพเครื่องจักร (%)\n                    "
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
                                "form-group pl-2 pr-2 mb-0 col-lg-2 col-md-3 col-sm-4 col-xs-4",
                              staticStyle: { "margin-top": "30px" }
                            },
                            [
                              !_vm.isControlDisable && _vm.isCurrBiweekly
                                ? _c(
                                    "button",
                                    {
                                      staticClass: "btn btn-success btn-md",
                                      staticStyle: { "padding-left": "7px" },
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
                                        "\n                        ยืนยันเปลี่ยนแปลงสั่งผลิต (%)\n                    "
                                      )
                                    ]
                                  )
                                : _vm._e()
                            ]
                          )
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    _c("hr"),
                    _vm._v(" "),
                    _vm.header
                      ? _c("div", { staticClass: "row" }, [
                          _vm._m(1),
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
                                              "\n                    "
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
                                              "\n                    "
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
                                              "\n                    "
                                          )
                                        ]
                                      )
                                    : _vm._e()
                                ]
                              )
                            : _vm._e()
                        ])
                      : _vm._e(),
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
                                staticClass: " tw-font-bold tw-uppercase mb-1"
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
                      _vm._m(2),
                      _vm._v(" "),
                      _vm._m(3),
                      _vm._v(" "),
                      _vm._m(4)
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
                                _vm._m(5),
                                _vm._v(" "),
                                _vm._m(6),
                                _vm._v(" "),
                                _c(
                                  "th",
                                  {
                                    staticClass:
                                      "text-center sticky-col th-col",
                                    staticStyle: { "vertical-align": "middle" }
                                  },
                                  [
                                    _c("div", [
                                      _vm._v(
                                        " ความเร็วเครื่องจักรต่อนาที (" +
                                          _vm._s(_vm.per_unit) +
                                          ") "
                                      )
                                    ])
                                  ]
                                ),
                                _vm._v(" "),
                                _vm._m(7),
                                _vm._v(" "),
                                _c(
                                  "th",
                                  {
                                    staticClass:
                                      "text-center sticky-col fi-col",
                                    staticStyle: { "vertical-align": "middle" },
                                    attrs: {
                                      title: _vm.efficiencyMachineFormula
                                    }
                                  },
                                  [
                                    _c("div", [
                                      _vm._v(" ผลผลิตตามประสิทธิภาพต่อนาที "),
                                      _c("br"),
                                      _vm._v(" (" + _vm._s(_vm.per_unit) + ") ")
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
                                              staticClass: "mb-2 tw-font-bold",
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
                                                    "\n                                                " +
                                                      _vm._s(index + 1) +
                                                      " " +
                                                      _vm._s(
                                                        planDate.day_of_week
                                                      ) +
                                                      "\n                                            "
                                                  )
                                                ]
                                              ),
                                              _vm._v(" "),
                                              _c("br"),
                                              _vm._v(
                                                "\n                                            " +
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
                                              _vm.working_holiday,
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
                                _vm._m(8)
                              ],
                              2
                            )
                          ]),
                          _vm._v(" "),
                          _c(
                            "tbody",
                            [
                              _vm.lines.length <= 0
                                ? [_vm._m(9)]
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
                                                rowspan: lineLists.length + 1
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
                                                    click: function($event) {
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
                                                    click: function($event) {
                                                      return _vm.selMachine(
                                                        line.machine_name
                                                      )
                                                    }
                                                  }
                                                },
                                                [
                                                  _c(
                                                    "span",
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
                                                    click: function($event) {
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
                                                    click: function($event) {
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
                                              _vm._l(_vm.resPlanDate, function(
                                                plan,
                                                index
                                              ) {
                                                return [
                                                  _vm._l(
                                                    _vm.efficiencyFullProducts,
                                                    function(
                                                      efficiencyProduct,
                                                      index
                                                    ) {
                                                      return [
                                                        _vm.machineDowntimes[
                                                          plan
                                                            .res_plan_date_display
                                                        ][line.machine_name] ==
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
                                                              line.machine_name
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
                                                                  _vm._v(
                                                                    "\n                                                        " +
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
                                                                      "\n                                                    "
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
                                                                  _vm._v(
                                                                    "\n                                                        " +
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
                                                                      "\n                                                    "
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
                                                              line.machine_name
                                                            ] != "Y" &&
                                                            _vm
                                                              .machineMaintenances[
                                                              plan
                                                                .res_plan_date_display
                                                            ][
                                                              line.machine_name
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
                                                                        " \n                                                            " +
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
                                                                          "\n                                                        "
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
                                            _vm._m(10, true),
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
                                                _vm._l(_vm.summary, function(
                                                  res
                                                ) {
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
                                                                    _vm.decimal(
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
                                                })
                                              ],
                                              2
                                            ),
                                            _vm._v(" "),
                                            _vm._l(_vm.resPlanDate, function(
                                              plan,
                                              index
                                            ) {
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
                                                              width: "70px"
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
                                                              width: "70px"
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
                                            _vm._m(11, true),
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
                                                _vm._l(_vm.summary, function(
                                                  res
                                                ) {
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
                                                                    _vm.decimal(
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
                                                })
                                              ],
                                              2
                                            ),
                                            _vm._v(" "),
                                            _vm._l(_vm.resPlanDate, function(
                                              plan,
                                              index
                                            ) {
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
                                                              width: "70px"
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
                                                              width: "70px"
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
                                        _vm._m(12),
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
                                                      _vm.decimal(
                                                        _vm.totalMachineAll
                                                      )
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
                                            _vm._l(_vm.summaryProduct, function(
                                              res
                                            ) {
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
                                                                width: "70px"
                                                              }
                                                            },
                                                            [_vm._v(" 0.00 ")]
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
                                                                width: "70px"
                                                              }
                                                            },
                                                            [
                                                              _vm._v(
                                                                " \n                                                    " +
                                                                  _vm._s(
                                                                    _vm._f(
                                                                      "number2Digit"
                                                                    )(res.total)
                                                                  ) +
                                                                  "\n                                                "
                                                              )
                                                            ]
                                                          )
                                                        ]
                                                      )
                                                    ]
                                                  : _vm._e()
                                              ]
                                            })
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
                                                staticStyle: { width: "70px" }
                                              },
                                              [
                                                _vm._v(
                                                  " " +
                                                    _vm._s(
                                                      _vm._f("number2Digit")(
                                                        _vm.totalProductAll
                                                      )
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
            ],
            2
          )
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
    return _c("div", { staticClass: "col-md-8" }, [
      _c("h2", { staticClass: "tw-font-bold" }, [_vm._v(" Machine Detail ")])
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
      _c("span", [_vm._v("   "), _c("br")]),
      _vm._v(" "),
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
      _c("span", [_vm._v("   "), _c("br")]),
      _vm._v(" "),
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
        staticStyle: {
          "vertical-align": "middle",
          width: "100px",
          "border-bottom": "0px"
        }
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
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/MachineList.vue?vue&type=template&id=5865830a&":
/*!*************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/MachineList.vue?vue&type=template&id=5865830a& ***!
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/ModalHoliday.vue?vue&type=template&id=726f5e36&":
/*!**************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/ModalHoliday.vue?vue&type=template&id=726f5e36& ***!
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/ModalMachineDowntime.vue?vue&type=template&id=3e2d873a&":
/*!**********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/ModalMachineDowntime.vue?vue&type=template&id=3e2d873a& ***!
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/OMSalesForecast.vue?vue&type=template&id=c9ab3c02&":
/*!*****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Machine-Biweekly/OMSalesForecast.vue?vue&type=template&id=c9ab3c02& ***!
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
                                  [_vm._v(" ปักษ์ : ")]
                                ),
                                _vm._v(" "),
                                _c("span", [
                                  _vm._v(
                                    " " +
                                      _vm._s(
                                        _vm.saleForecasts
                                          ? _vm.saleForecasts[0].biweekly_no
                                          : ""
                                      ) +
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
                                      _vm._s(
                                        _vm.saleForecasts
                                          ? _vm.saleForecasts[0].om_bi_weekly
                                              .day_for_sale
                                          : 0
                                      ) +
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
                                              .om_sales_forecast
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



/***/ })

}]);