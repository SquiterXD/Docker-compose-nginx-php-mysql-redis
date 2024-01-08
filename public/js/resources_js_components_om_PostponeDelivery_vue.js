(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_om_PostponeDelivery_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/PostponeDelivery.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/PostponeDelivery.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************************************************/
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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['deliveryDates', 'budgetYear'],
  data: function data() {
    return {
      customers: [],
      customer_select: [],
      years: [],
      installments: [],
      removed: [],
      options: [],
      data_list: [{
        postpone_order_id: 0,
        customer_number: "",
        customer_name: "",
        year: "",
        installment: "",
        from_date: "",
        to_date: "",
        budgetYear: [],
        period: [],
        fix: true,
        old: false,
        selected: 0
      }],
      loading: false,
      data_postpone: {
        year: '',
        period: '',
        from_date: '',
        to_date: '',
        disabled: {
          year: true,
          period: true,
          from_date: true,
          to_date: true
        },
        periodList: [],
        customers: [],
        loading: {
          postpone: false,
          table: false
        }
      }
    };
  },
  mounted: function mounted() {
    this.customerList();
    this.getParams();
    this.yearsList();
  },
  methods: {
    remoteMethod: function remoteMethod(query) {
      var _this = this;

      if (query !== "") {
        this.loading = true;
        setTimeout(function () {
          _this.loading = false;
          _this.options = _this.customers.filter(function (item) {
            return item.customer_name.indexOf(query) > -1 || item.customer_number.indexOf(query) > -1;
          });
        }, 200);
      } else {
        this.options = [];
      }
    },
    getParams: function getParams() {
      var vm = this;
      var urlParams = new URLSearchParams(window.location.search);

      if (urlParams.has("customer_number")) {
        var dataPost = {
          customer_number: urlParams.get("customer_number"),
          year: urlParams.get("year"),
          installment: urlParams.get("installment"),
          date: urlParams.get("date")
        };
        axios.post("/om/ajax/postpone-delivery/search", dataPost).then(function (res) {
          vm.data_list = res.data.data;
        })["catch"](function (error) {// error.response.status Check status code
        })["finally"](function () {//Perform action in always
        });
      }
    },
    customerList: function customerList() {
      var vm = this;
      axios.get("/api/v1/customer").then(function (res) {
        vm.customers = res.data.data;
        vm.options = res.data.data;
      });
    },
    yearsList: function yearsList() {
      var vm = this;
      axios.get("/om/ajax/postpone-delivery/years").then(function (res) {
        vm.years = res.data.data;
      });
    },
    changeYear: function changeYear(e, i) {
      var value = e;
      this.data_list[i].year = value;
      this.data_list[i].installment = "";
      this.installmentList(value, i);
    },
    changeChecked: function changeChecked(i, type) {
      var vm = this; // console.log(vm.data_list[i].selected, 'ก่อน')

      if (vm.data_list[i].selected == 1) {
        vm.data_list[i].selected = 0;
      } else {
        if (vm.data_list[i].selected == 0) {
          vm.data_list[i].selected = 1;
        }
      } // console.log(vm.data_list[i].selected, 'หลัง')


      if ($("td input:checkbox:checked").length != $("td input:checkbox").length) {
        $("#checkboxAll").prop('checked', false);
      } else {
        $("#checkboxAll").prop('checked', true);
      }
    },
    installmentList: function installmentList(year, i) {
      var vm = this;
      axios.get("/om/ajax/postpone-delivery/installments/" + year).then(function (res) {
        vm.data_list[i].period = res.data.data;
      });
    },
    changeInstallment: function changeInstallment(e, i) {
      var vm = this;
      axios.get("/om/ajax/postpone-delivery/date-by-no/" + vm.data_list[i].customer_number + "/" + e).then(function (res) {
        vm.data_list[i].from_date = res.data.data;
      });
      this.data_list[i].installment = e;
    },
    createNewRow: function createNewRow() {
      var vm = this;
      vm.data_list.push({
        postpone_order_id: 0,
        customer_number: "",
        customer_name: "",
        year: "",
        installment: "",
        from_date: "",
        to_date: "",
        budgetYear: [],
        period: [],
        fix: true,
        old: false,
        selected: 0
      });
    },
    getCustomerName: function getCustomerName(number, i) {
      var vm = this;
      vm.data_list[i].customer_number = number;
      vm.customers.filter(function (v) {
        if (v.customer_number == number) {
          vm.data_list[i].customer_name = v.customer_name;
        }
      });
    },
    sourceChanged: function sourceChanged(e, i) {
      this.getCustomerName(e, i);
      this.getNextDate(e, i);
      this.data_list[i].year = moment__WEBPACK_IMPORTED_MODULE_1___default()().year() + 543;
      this.installmentList(moment__WEBPACK_IMPORTED_MODULE_1___default()().year(), i);
    },
    getNextDate: function getNextDate(number, i) {
      var vm = this;
      axios.get("/om/ajax/postpone-delivery/next-date/" + number).then(function (res) {
        vm.data_list[i].from_date = res.data.data;
      });
    },
    changeFromDate: function changeFromDate(e, i) {
      this.data_list[i].from_date = e;
    },
    changeToDate: function changeToDate(e, i) {
      this.data_list[i].to_date = moment__WEBPACK_IMPORTED_MODULE_1___default()(e).format("DD/MM/Y");
    },
    removeData: function removeData() {
      var vm = this;
      var dataPost = [];
      dataPost = vm.data_list.filter(function (item) {
        return item.selected == 1;
      });
      swal({
        title: "แจ้งเตือน",
        text: "ต้องการลบข้อมูลเลื่อนส่งประจำสัปดาห์",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-primary",
        confirmButtonText: "ยืนยัน",
        cancelButtonText: "ยกเลิก",
        closeOnConfirm: false,
        closeOnCancel: false
      }, function (isConfirm) {
        if (isConfirm) {
          axios.post("/om/ajax/postpone-delivery/remove", dataPost).then(function (res) {
            if (res.data.status) {
              vm.getParams();
            }
          })["catch"](function (error) {// error.response.status Check status code
          })["finally"]( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
            return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
              while (1) {
                switch (_context.prev = _context.next) {
                  case 0:
                    $("input[type=checkbox]").prop("checked", false);
                    console.log(vm.data_list, 'www removeData');
                    vm.data_list = vm.data_list.filter(function (item) {
                      return item.selected == 0;
                    });
                    swal.close();

                  case 4:
                  case "end":
                    return _context.stop();
                }
              }
            }, _callee);
          })));
        } else {
          swal.close();
        }
      });
    },
    savePostpone: function savePostpone() {
      var vm = this;
      var dataPost = [{
        postpone: vm.data_list
      }];
      swal({
        title: "แจ้งเตือน",
        text: "ต้องการบันทึกข้อมูลเลื่อนส่งประจำสัปดาห์",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-primary",
        confirmButtonText: "ยืนยัน",
        cancelButtonText: "ยกเลิก",
        closeOnConfirm: false,
        closeOnCancel: false
      }, function (isConfirm) {
        if (isConfirm) {
          axios.post("/om/ajax/postpone-delivery/create", dataPost).then(function (res) {
            if (res.data.status) {
              if (res.data.error) {
                swal("Warning!", "เกิดข้อผิดพลาดบางรายการ", "error");
                vm.getParams();
              } else {
                swal("Success", "บันทึกข้อมูลสำเร็จ", "success");
                vm.getParams();
              }
            }
          })["catch"](function (error) {// error.response.status Check status code
          })["finally"](function () {//Perform action in always
          });
        } else {
          swal.close();
        }
      });
    },
    radioClick: function radioClick() {
      var _this2 = this;

      var vm = this;
      var radioData = $('input[name="delivery_date"]:checked').val();
      vm.data_postpone.customers = [];
      vm.data_postpone.loading.postpone = true;
      vm.data_postpone.loading.table = true;
      axios.get("/om/ajax/postpone-delivery/get-customers/" + radioData).then(function (res) {
        if (res.data.data.length != 0) {
          vm.data_postpone.customers = res.data.data;
          vm.data_postpone.disabled.year = false;
          vm.data_postpone.disabled.period = false;
          vm.data_postpone.disabled.from_date = false;
          vm.data_postpone.disabled.to_date = false;
          vm.data_postpone.year = new Date().getFullYear().toString();

          _this2.getPeriodPostPone(new Date().getFullYear().toString());

          vm.data_postpone.loading.postpone = false;
          vm.data_postpone.loading.table = false;
        } else {
          vm.data_postpone.disabled.year = true;
          vm.data_postpone.disabled.period = true;
          vm.data_postpone.disabled.from_date = true;
          vm.data_postpone.disabled.to_date = true;
          vm.data_postpone.year = '';
          vm.data_postpone.loading.postpone = false;
          vm.data_postpone.loading.table = false;
        }
      });
    },
    getPeriodPostPone: function getPeriodPostPone(value) {
      var _this3 = this;

      var vm = this;
      var radioData = $('input[name="delivery_date"]:checked').val();
      vm.data_postpone.loading.postpone = true;
      vm.data_postpone.loading.table = true;

      if (value) {
        axios.get("/om/ajax/postpone-delivery/get-period-post-pone/" + value, {
          params: {
            days: radioData
          }
        }).then(function (res) {
          if (res.data.data.length != 0) {
            vm.data_postpone.periodList = res.data.data;
            vm.data_postpone.period = res.data.data2[0].period_line_id;
            vm.data_postpone.from_date = res.data.data3;
          } else {
            vm.data_postpone.periodList = [];
            vm.data_postpone.period = '';
            vm.data_postpone.from_date = '';
            vm.data_postpone.loading.postpone = false;
            vm.data_postpone.loading.table = false;
          }

          if (res.data.data4.length != 0) {
            vm.data_list = [];
            res.data.data4.forEach(function (element) {
              vm.data_list.push({
                postpone_order_id: element.postpone_order_id ? element.postpone_order_id : 0,
                customer_number: element.customer_number ? element.customer_number : '',
                customer_name: element.customer_name ? element.customer_name : '',
                year: vm.data_postpone.year ? vm.data_postpone.year : '',
                installment: vm.data_postpone.period ? vm.data_postpone.period : '',
                from_date: vm.data_postpone.from_date ? vm.data_postpone.from_date : '',
                to_date: element.to_period_date ? element.to_period_date : '',
                budgetYear: _this3.budgetYear,
                period: vm.data_postpone.periodList ? vm.data_postpone.periodList : '',
                fix: true,
                old: false,
                selected: 0
              });
            });
            vm.data_postpone.loading.table = false;
          } else {
            vm.data_list = [];
          }

          vm.data_postpone.loading.postpone = false;
        });
      } else {
        vm.data_postpone.period = '';
        vm.data_postpone.periodList = [];
        vm.data_postpone.from_date = '';
      }
    },
    applyData: function applyData() {
      var _this4 = this;

      var vm = this;
      vm.data_list = [];
      vm.data_postpone.loading.table = true;

      if (vm.data_postpone.customers.length != 0) {
        vm.data_postpone.customers.forEach(function (element) {
          vm.data_list.push({
            postpone_order_id: element.postpone_order_id ? element.postpone_order_id : 0,
            customer_number: element.customer_number ? element.customer_number : '',
            customer_name: element.customer_name ? element.customer_name : '',
            year: vm.data_postpone.year ? vm.data_postpone.year : '',
            installment: vm.data_postpone.period ? vm.data_postpone.period : '',
            from_date: vm.data_postpone.from_date ? vm.data_postpone.from_date : '',
            to_date: vm.data_postpone.to_date ? vm.data_postpone.to_date : '',
            budgetYear: _this4.budgetYear,
            period: vm.data_postpone.periodList ? vm.data_postpone.periodList : '',
            fix: true,
            old: false,
            selected: 0
          });
        });
      }

      vm.data_postpone.loading.table = false;
    },
    getValueFromDate: function getValueFromDate(date) {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var vm, dateFormat;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                vm = _this5;
                vm.data_postpone.from_date = date;
                dateFormat = date ? moment__WEBPACK_IMPORTED_MODULE_1___default()(date).format("DD/MM/YYYY") : '';
                vm.data_postpone.customers = [];
                vm.data_postpone.loading.postpone = true;
                vm.data_postpone.loading.table = true;
                axios.get("/om/ajax/postpone-delivery/get-date-by-period-post-pone", {
                  params: {
                    days: dateFormat
                  }
                }).then(function (res) {
                  if (res.data.data.length != 0) {
                    vm.data_postpone.period = res.data.data[0].period_line_id;
                    vm.data_postpone.customers = res.data.data3;

                    if (res.data.data2) {
                      $("#" + res.data.data2).prop("checked", true);
                    }
                  }

                  if (res.data.data4.length != 0) {
                    vm.data_list = [];
                    res.data.data4.forEach(function (element) {
                      vm.data_list.push({
                        postpone_order_id: element.postpone_order_id ? element.postpone_order_id : 0,
                        customer_number: element.customer_number ? element.customer_number : '',
                        customer_name: element.customer_name ? element.customer_name : '',
                        year: vm.data_postpone.year ? vm.data_postpone.year : '',
                        installment: vm.data_postpone.period ? vm.data_postpone.period : '',
                        from_date: vm.data_postpone.from_date ? vm.data_postpone.from_date : '',
                        to_date: element.to_period_date ? element.to_period_date : '',
                        budgetYear: _this5.budgetYear,
                        period: vm.data_postpone.periodList ? vm.data_postpone.periodList : '',
                        fix: true,
                        old: false,
                        selected: 0
                      });
                    });
                    vm.data_postpone.loading.table = false;
                  } else {
                    vm.data_list = [];
                  }

                  vm.data_postpone.loading.postpone = false;
                  vm.data_postpone.loading.table = false;
                });

              case 7:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    getValueToDate: function getValueToDate(date) {
      var vm = this;
      vm.data_postpone.to_date = moment__WEBPACK_IMPORTED_MODULE_1___default()(date).format("DD/MM/YYYY");
    },
    clearDataPostPone: function clearDataPostPone() {
      var vm = this;
      vm.data_postpone.year = '';
      vm.data_postpone.period = '';
      vm.data_postpone.from_date = '';
      vm.data_postpone.to_date = '';
      vm.data_postpone.periodList = [];
      vm.data_postpone.customers = [];
      vm.data_postpone.disabled.year = true;
      vm.data_postpone.disabled.period = true;
      vm.data_postpone.disabled.from_date = true;
      vm.data_postpone.disabled.to_date = true;
      vm.data_list = [];
    },
    checkboxAll: function checkboxAll() {
      var vm = this;
      var valueCheckbox = $("#checkboxAll").prop('checked');

      if (valueCheckbox) {
        $('td input:checkbox').prop('checked', $("#checkboxAll").prop('checked'));
        vm.data_list.forEach(function (element) {
          element.selected = 1;
        });
      } else {
        $('td input:checkbox').prop('checked', false);
        vm.data_list.forEach(function (element) {
          element.selected = 0;
        });
      }
    },
    getPeriodPostPoneByDate: function getPeriodPostPoneByDate() {
      var _this6 = this;

      var vm = this;
      var radioData = $('input[name="delivery_date"]:checked').val();
      vm.data_postpone.from_date = '';
      vm.data_postpone.to_date = '';
      vm.data_postpone.loading.postpone = true;
      vm.data_postpone.loading.table = true;

      if (vm.data_postpone.period) {
        axios.get("/om/ajax/postpone-delivery/get-period-post-pone-by-date", {
          params: {
            period: vm.data_postpone.period,
            days: radioData
          }
        }).then(function (res) {
          if (res.data.data.length != 0) {
            vm.data_postpone.from_date = res.data.data;
          }

          if (res.data.data2.length != 0) {
            vm.data_list = [];
            res.data.data2.forEach(function (element) {
              vm.data_list.push({
                postpone_order_id: element.postpone_order_id ? element.postpone_order_id : 0,
                customer_number: element.customer_number ? element.customer_number : '',
                customer_name: element.customer_name ? element.customer_name : '',
                year: vm.data_postpone.year ? vm.data_postpone.year : '',
                installment: vm.data_postpone.period ? vm.data_postpone.period : '',
                from_date: vm.data_postpone.from_date ? vm.data_postpone.from_date : '',
                to_date: element.to_period_date ? element.to_period_date : '',
                budgetYear: _this6.budgetYear,
                period: vm.data_postpone.periodList ? vm.data_postpone.periodList : '',
                fix: true,
                old: false,
                selected: 0
              });
            });
            vm.data_postpone.loading.table = false;
          } else {
            vm.data_list = [];
          }

          vm.data_postpone.loading.postpone = false;
          vm.data_postpone.loading.table = false;
        });
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/PostponeDelivery.vue?vue&type=style&index=0&id=6f0a8940&scoped=true&lang=css&":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/PostponeDelivery.vue?vue&type=style&index=0&id=6f0a8940&scoped=true&lang=css& ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, ".btn-success[data-v-6f0a8940] {\n  color: #fff !important;\n  background-color: #1c84c6 !important;\n  border-color: #1c84c6 !important;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/PostponeDelivery.vue?vue&type=style&index=0&id=6f0a8940&scoped=true&lang=css&":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/PostponeDelivery.vue?vue&type=style&index=0&id=6f0a8940&scoped=true&lang=css& ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PostponeDelivery_vue_vue_type_style_index_0_id_6f0a8940_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PostponeDelivery.vue?vue&type=style&index=0&id=6f0a8940&scoped=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/PostponeDelivery.vue?vue&type=style&index=0&id=6f0a8940&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PostponeDelivery_vue_vue_type_style_index_0_id_6f0a8940_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PostponeDelivery_vue_vue_type_style_index_0_id_6f0a8940_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/components/om/PostponeDelivery.vue":
/*!*********************************************************!*\
  !*** ./resources/js/components/om/PostponeDelivery.vue ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _PostponeDelivery_vue_vue_type_template_id_6f0a8940_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PostponeDelivery.vue?vue&type=template&id=6f0a8940&scoped=true& */ "./resources/js/components/om/PostponeDelivery.vue?vue&type=template&id=6f0a8940&scoped=true&");
/* harmony import */ var _PostponeDelivery_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PostponeDelivery.vue?vue&type=script&lang=js& */ "./resources/js/components/om/PostponeDelivery.vue?vue&type=script&lang=js&");
/* harmony import */ var _PostponeDelivery_vue_vue_type_style_index_0_id_6f0a8940_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./PostponeDelivery.vue?vue&type=style&index=0&id=6f0a8940&scoped=true&lang=css& */ "./resources/js/components/om/PostponeDelivery.vue?vue&type=style&index=0&id=6f0a8940&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _PostponeDelivery_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _PostponeDelivery_vue_vue_type_template_id_6f0a8940_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _PostponeDelivery_vue_vue_type_template_id_6f0a8940_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "6f0a8940",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/om/PostponeDelivery.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/om/PostponeDelivery.vue?vue&type=script&lang=js&":
/*!**********************************************************************************!*\
  !*** ./resources/js/components/om/PostponeDelivery.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PostponeDelivery_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PostponeDelivery.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/PostponeDelivery.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PostponeDelivery_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/om/PostponeDelivery.vue?vue&type=style&index=0&id=6f0a8940&scoped=true&lang=css&":
/*!******************************************************************************************************************!*\
  !*** ./resources/js/components/om/PostponeDelivery.vue?vue&type=style&index=0&id=6f0a8940&scoped=true&lang=css& ***!
  \******************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_PostponeDelivery_vue_vue_type_style_index_0_id_6f0a8940_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader/dist/cjs.js!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PostponeDelivery.vue?vue&type=style&index=0&id=6f0a8940&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/PostponeDelivery.vue?vue&type=style&index=0&id=6f0a8940&scoped=true&lang=css&");


/***/ }),

/***/ "./resources/js/components/om/PostponeDelivery.vue?vue&type=template&id=6f0a8940&scoped=true&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/components/om/PostponeDelivery.vue?vue&type=template&id=6f0a8940&scoped=true& ***!
  \****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PostponeDelivery_vue_vue_type_template_id_6f0a8940_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PostponeDelivery_vue_vue_type_template_id_6f0a8940_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PostponeDelivery_vue_vue_type_template_id_6f0a8940_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PostponeDelivery.vue?vue&type=template&id=6f0a8940&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/PostponeDelivery.vue?vue&type=template&id=6f0a8940&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/PostponeDelivery.vue?vue&type=template&id=6f0a8940&scoped=true&":
/*!*******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/PostponeDelivery.vue?vue&type=template&id=6f0a8940&scoped=true& ***!
  \*******************************************************************************************************************************************************************************************************************************************/
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
        directives: [
          {
            name: "loading",
            rawName: "v-loading",
            value: this.data_postpone.loading.postpone,
            expression: "this.data_postpone.loading.postpone"
          }
        ],
        staticClass: "col-xl-12 m-auto"
      },
      [
        _c("hr", { staticClass: "lg" }),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "row mb-3" },
          [
            _c("label", { staticClass: "d-block mr-3" }, [
              _vm._v("วันส่งร้านค้า")
            ]),
            _vm._v(" "),
            _vm._l(_vm.deliveryDates, function(item, index) {
              return _c("div", { key: index }, [
                _c("label", { staticClass: "pr-3" }, [
                  _c("input", {
                    staticStyle: {
                      height: "20px",
                      width: "20px",
                      "vertical-align": "middle"
                    },
                    attrs: {
                      type: "radio",
                      name: "delivery_date",
                      id: item.meaning
                    },
                    domProps: { value: item.meaning },
                    on: {
                      click: function($event) {
                        return _vm.radioClick()
                      }
                    }
                  }),
                  _vm._v(" "),
                  _c("span", [_vm._v(" " + _vm._s(item.meaning) + " ")])
                ])
              ])
            })
          ],
          2
        ),
        _vm._v(" "),
        _c("div", { staticClass: "row m-t-sm" }, [
          _c(
            "div",
            { staticClass: "form-group col-sm-3" },
            [
              _c("label", { staticClass: "d-block" }, [_vm._v("ปีงบประมาณ")]),
              _vm._v(" "),
              _c(
                "el-select",
                {
                  staticStyle: { width: "100%" },
                  attrs: {
                    placeholder: "ปีงบประมาณ",
                    disabled: _vm.data_postpone.disabled.year,
                    clearable: ""
                  },
                  on: {
                    change: function($event) {
                      return _vm.getPeriodPostPone(_vm.data_postpone.year)
                    }
                  },
                  model: {
                    value: _vm.data_postpone.year,
                    callback: function($$v) {
                      _vm.$set(_vm.data_postpone, "year", $$v)
                    },
                    expression: "data_postpone.year"
                  }
                },
                _vm._l(_vm.budgetYear, function(item, index) {
                  return _c("el-option", {
                    key: index,
                    attrs: {
                      label: parseInt(item.budget_year) + parseInt(543),
                      value: item.budget_year
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
            { staticClass: "form-group col-sm-3" },
            [
              _c("label", { staticClass: "d-block" }, [_vm._v("งวด")]),
              _vm._v(" "),
              _c(
                "el-select",
                {
                  staticStyle: { width: "100%" },
                  attrs: {
                    placeholder: "งวด",
                    disabled: _vm.data_postpone.disabled.period,
                    clearable: ""
                  },
                  on: {
                    change: function($event) {
                      return _vm.getPeriodPostPoneByDate()
                    }
                  },
                  model: {
                    value: _vm.data_postpone.period,
                    callback: function($$v) {
                      _vm.$set(_vm.data_postpone, "period", $$v)
                    },
                    expression: "data_postpone.period"
                  }
                },
                _vm._l(_vm.data_postpone.periodList, function(item, index) {
                  return _c("el-option", {
                    key: index,
                    attrs: { label: item.period_no, value: item.period_line_id }
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
            { staticClass: "form-group col-sm-3" },
            [
              _c("label", { staticClass: "d-block" }, [
                _vm._v("วันส่งประจำงวด")
              ]),
              _vm._v(" "),
              _c("datepicker-th", {
                staticClass: "form-control md:tw-mb-0 tw-mb-2",
                staticStyle: { width: "100%" },
                attrs: {
                  name: "start_date",
                  placeholder: "โปรดเลือกวันที่",
                  format: "DD/MM/YYYY",
                  disabled: _vm.data_postpone.disabled.from_date
                },
                on: { dateWasSelected: _vm.getValueFromDate },
                model: {
                  value: _vm.data_postpone.from_date,
                  callback: function($$v) {
                    _vm.$set(_vm.data_postpone, "from_date", $$v)
                  },
                  expression: "data_postpone.from_date"
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "form-group col-sm-3" },
            [
              _c("label", { staticClass: "d-block" }, [
                _vm._v("เลื่อนเป็นวันที่")
              ]),
              _vm._v(" "),
              _c("datepicker-th", {
                staticClass: "form-control md:tw-mb-0 tw-mb-2",
                staticStyle: { width: "100%" },
                attrs: {
                  name: "start_date",
                  placeholder: "โปรดเลือกวันที่",
                  format: "DD/MM/YYYY",
                  disabled: _vm.data_postpone.disabled.to_date
                },
                on: { dateWasSelected: _vm.getValueToDate },
                model: {
                  value: _vm.data_postpone.to_date,
                  callback: function($$v) {
                    _vm.$set(_vm.data_postpone, "to_date", $$v)
                  },
                  expression: "data_postpone.to_date"
                }
              })
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row m-t-sm" }, [
          _c("div", { staticClass: "col-sm-12 text-right" }, [
            _c(
              "button",
              {
                staticClass: "btn btn-md btn-success",
                attrs: {
                  type: "button",
                  disabled:
                    this.data_postpone.customers.length != 0 ? false : true
                },
                on: {
                  click: function($event) {
                    return _vm.applyData()
                  }
                }
              },
              [
                _c("i", { staticClass: "fa fa-plus" }),
                _vm._v(" Apply\n            ")
              ]
            ),
            _vm._v(" "),
            _c(
              "button",
              {
                staticClass: "btn btn-md btn-danger",
                attrs: {
                  type: "button",
                  disabled:
                    this.data_postpone.customers.length != 0 ? false : true
                },
                on: {
                  click: function($event) {
                    return _vm.clearDataPostPone()
                  }
                }
              },
              [
                _c("i", { staticClass: "fa fa-refresh" }),
                _vm._v(" ล้างค่า\n            ")
              ]
            )
          ])
        ])
      ]
    ),
    _vm._v(" "),
    _c("div", { staticClass: "col-xl-12 m-auto" }, [
      _c("hr", { staticClass: "lg" }),
      _vm._v(" "),
      _c("div", { staticClass: "form-header-buttons" }, [
        _c("div", { staticClass: "buttons d-flex" }, [
          _c(
            "button",
            {
              staticClass: "btn btn-md btn-success",
              attrs: { type: "button" },
              on: {
                click: function($event) {
                  return _vm.createNewRow()
                }
              }
            },
            [_c("i", { staticClass: "fa fa-plus" }), _vm._v(" สร้าง\n        ")]
          ),
          _vm._v(" "),
          _c(
            "button",
            {
              staticClass: "btn btn-md btn-danger",
              attrs: { type: "button" },
              on: {
                click: function($event) {
                  return _vm.removeData()
                }
              }
            },
            [_c("i", { staticClass: "fa fa-times" }), _vm._v(" ลบ\n        ")]
          ),
          _vm._v(" "),
          _c(
            "button",
            {
              staticClass: "btn btn-md btn-primary",
              attrs: { type: "button" },
              on: {
                click: function($event) {
                  return _vm.savePostpone()
                }
              }
            },
            [
              _c("i", { staticClass: "fa fa-save" }),
              _vm._v(" บันทึก\n        ")
            ]
          )
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "hr-line-dashed" }),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass: "text-right",
          staticStyle: { "padding-bottom": "10px" }
        },
        [
          _vm._v(
            "\n      จำนวนบรรทัดของข้อมูล: " +
              _vm._s(this.data_list.length) +
              "\n    "
          )
        ]
      ),
      _vm._v(" "),
      _c("div", { staticClass: "table-responsive-xl" }, [
        _c(
          "table",
          {
            directives: [
              {
                name: "loading",
                rawName: "v-loading",
                value: this.data_postpone.loading.table,
                expression: "this.data_postpone.loading.table"
              }
            ],
            staticClass: "table table-bordered text-center"
          },
          [
            _c("thead", [
              _c("tr", { staticClass: "text-center" }, [
                _c("th", { staticClass: "w-40" }, [
                  _vm._v("\n              เลือกทั้งหมด \n              "),
                  _c("input", {
                    staticClass: "form-control",
                    staticStyle: { "margin-top": "10px" },
                    attrs: { type: "checkbox", id: "checkboxAll" },
                    on: {
                      click: function($event) {
                        return _vm.checkboxAll()
                      }
                    }
                  })
                ]),
                _vm._v(" "),
                _c("th", { staticClass: "w-150" }, [_vm._v("รหัสร้านค้า")]),
                _vm._v(" "),
                _c("th", { staticClass: "min-150" }, [_vm._v("ชื่อร้านค้า")]),
                _vm._v(" "),
                _c("th", { staticClass: "w-130" }, [_vm._v("ปีงบประมาณ")]),
                _vm._v(" "),
                _c("th", { staticClass: "w-90" }, [_vm._v("งวดที่")]),
                _vm._v(" "),
                _c("th", { staticClass: "w-150" }, [_vm._v("วันส่งประจำงวด")]),
                _vm._v(" "),
                _c("th", { staticClass: "w-150" }, [_vm._v("เลื่อนเป็นวันที่")])
              ])
            ]),
            _vm._v(" "),
            _c(
              "tbody",
              _vm._l(_vm.data_list, function(v, i) {
                return _c("tr", { key: i }, [
                  _c("td", [
                    _c("input", {
                      staticClass: "form-control",
                      staticStyle: { "margin-top": "10px" },
                      attrs: {
                        type: "checkbox",
                        disabled: !v.fix,
                        id: "checkbox" + i
                      },
                      domProps: { value: v.selected },
                      on: {
                        change: function($event) {
                          return _vm.changeChecked(i, "checkbox" + i)
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
                            remote: "",
                            "reserve-keyword": "",
                            "remote-method": _vm.remoteMethod,
                            loading: _vm.loading
                          },
                          on: {
                            change: function($event) {
                              return _vm.sourceChanged($event, i)
                            }
                          },
                          model: {
                            value: v.customer_number,
                            callback: function($$v) {
                              _vm.$set(v, "customer_number", $$v)
                            },
                            expression: "v.customer_number"
                          }
                        },
                        _vm._l(_vm.options, function(item) {
                          return _c(
                            "el-option",
                            {
                              key: item.customer_id,
                              attrs: { value: item.customer_number }
                            },
                            [
                              _vm._v(
                                _vm._s(
                                  item.customer_number +
                                    " : " +
                                    item.customer_name
                                ) + "\n                "
                              )
                            ]
                          )
                        }),
                        1
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "td",
                    [
                      _c("el-input", {
                        attrs: {
                          placeholder: "ชื่อร้าน",
                          value: v.customer_name,
                          disabled: ""
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "td",
                    [
                      _c(
                        "el-select",
                        {
                          attrs: {
                            filterable: "",
                            placeholder: "Select",
                            disabled: !v.fix
                          },
                          on: {
                            change: function($event) {
                              return _vm.changeYear($event, i)
                            }
                          },
                          model: {
                            value: v.year,
                            callback: function($$v) {
                              _vm.$set(v, "year", $$v)
                            },
                            expression: "v.year"
                          }
                        },
                        _vm._l(_vm.years, function(item) {
                          return _c("el-option", {
                            key: item.budget_year,
                            attrs: {
                              label: parseInt(item.budget_year) + parseInt(543),
                              value: item.budget_year
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
                    "td",
                    [
                      _c(
                        "el-select",
                        {
                          attrs: {
                            filterable: "",
                            placeholder: "Select",
                            disabled: !v.fix
                          },
                          on: {
                            change: function($event) {
                              return _vm.changeInstallment($event, i)
                            }
                          },
                          model: {
                            value: v.installment,
                            callback: function($$v) {
                              _vm.$set(v, "installment", $$v)
                            },
                            expression: "v.installment"
                          }
                        },
                        _vm._l(v.period, function(item) {
                          return _c("el-option", {
                            key: item.period_line_id,
                            attrs: {
                              label: item.period_no,
                              value: item.period_line_id
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
                    "td",
                    [
                      _c("datepicker-th", {
                        staticClass: "form-control",
                        staticStyle: { width: "100%" },
                        attrs: {
                          placeholder: "วันส่งประจำงวด",
                          value: v.from_date,
                          format: "DD/MM/Y"
                        },
                        model: {
                          value: v.from_date,
                          callback: function($$v) {
                            _vm.$set(v, "from_date", $$v)
                          },
                          expression: "v.from_date"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "td",
                    [
                      _c("datepicker-th", {
                        staticClass: "form-control",
                        staticStyle: { width: "100%" },
                        attrs: {
                          placeholder: "เลื่อนเป็นวันที่",
                          value: v.to_date,
                          disabled: !v.fix,
                          disabledDateTo: "[0]",
                          format: "DD/MM/Y"
                        },
                        on: {
                          dateWasSelected: function($event) {
                            return _vm.changeToDate($event, i)
                          }
                        },
                        model: {
                          value: v.to_date,
                          callback: function($$v) {
                            _vm.$set(v, "to_date", $$v)
                          },
                          expression: "v.to_date"
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
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);