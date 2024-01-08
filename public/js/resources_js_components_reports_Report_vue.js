(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_reports_Report_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0005_3.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0005_3.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************/
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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['url', 'trans-date', 'trans-btn', // 'module',
  // 'url-ger-param',
  'default-program-code', 'infoAttributes', 'functionName'],
  data: function data() {
    return {
      options: [],
      value: this.defaultProgramCode ? this.defaultProgramCode : [],
      list: [],
      loading: false,
      states: [],
      infos: [],
      programs: [],
      // infoAttributes:[],
      date: {},
      // functionName : "",
      // functionReport: "",
      reportType: 'pdf',
      errorLists: [],
      groupCodeList: [],
      carInsuranceeList: [],
      departmentList: [],
      departmentListTo: [],
      month: '',
      group_code: '',
      car_insurance: '',
      department_code_from: '',
      department_code_to: '',
      seq_1: true,
      seq_2: true,
      seq_3: true,
      month_value: ''
    };
  },
  methods: {
    getData: function getData(query) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                axios.get(_this.url.getInfor).then(function (res) {
                  _this.programs = res.data.programs;
                }).then(function () {
                  _this.list = _this.infos.map(function (item) {
                    return {
                      value: "value:".concat(item.program_code),
                      label: "label:".concat(item.program_code)
                    };
                  });
                })["catch"](function (error) {});

              case 1:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getInfos: function getInfos() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this2.infoAttributes = [];
                _this2.functionName = "";
                _this2.errorLists = []; // this.value = [];

                axios.get(_this2.url.getInfoAttribute + '?program_code=' + _this2.value // this.urlTest
                ).then(function (res) {
                  // console.log(res);
                  _this2.infoAttributes = res.data.reportInfor;
                  _this2.functionName = res.data.functionName;
                  _this2.functionReport = res.data.functionReport;
                  _this2.programs = res.data.programs;
                  _this2.options = res.data.programs;
                }).then(function () {// this.list = this.infos.map(item => {
                  //     return { value: `value:${item.program_code}`, label: `label:${item.program_code}` };
                  // });
                })["catch"](function (error) {// swal("Error", error, "error");
                });

              case 4:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    getYear: function getYear(value, month) {
      this.group_code_value = 'x111'; // this.infoAttributes.find(data => {
      //     if (data.attribute_name == month) {
      //         data.form_value = value;
      //     }
      // });

      this.month = value;
      console.log('value', value);
      console.log('month', month); // this.month = moment(value)
      //                 .add(+543, "years")
      //                 .format(this.transDate["js-datatime-format"]);
      // this.month = moment(value).format(this.transDate["js-datatime-format"]);

      if (value) {
        this.getGroupCode();
      }

      this.month_value = moment__WEBPACK_IMPORTED_MODULE_1___default()(value).add(-543, "years").format("MM/DD/YYYY");
    },
    exportReport: function exportReport() {},
    checkForm: function checkForm(e) {
      if (!this.month) {
        swal({
          title: "Warning",
          text: 'กรุณาระบุเดือน',
          type: "warning"
        });
      } else {
        return true;
      }

      e.preventDefault();
    },
    getGroupCode: function getGroupCode() {
      var _this3 = this;

      console.log('func getGroupCode');
      axios.get("/ir/reports/get-group-code", {
        params: {
          month: this.month
        }
      }).then(function (res) {
        _this3.groupCodeList = res.data.data;
      })["catch"](function (error) {});
    },
    getCarInsurance: function getCarInsurance() {
      var _this4 = this;

      // console.log('func getCarInsurance', this.group_code);
      axios.get("/ir/reports/get-car-insurance", {
        params: {
          month: this.month,
          group_code: this.group_code
        }
      }).then(function (res) {
        _this4.carInsuranceeList = res.data.data;
      })["catch"](function (error) {});
    },
    getDepartment: function getDepartment() {
      var _this5 = this;

      if (this.car_insurance) {
        axios.get("/ir/reports/get-department", {
          params: {
            month: this.month,
            group_code: this.group_code,
            car_insurance: this.car_insurance
          }
        }).then(function (res) {
          _this5.departmentList = res.data.data;
        })["catch"](function (error) {});
      }
    },
    getDepartmentTo: function getDepartmentTo() {
      var _this6 = this;

      if (this.car_insurance) {
        axios.get("/ir/reports/get-department-to", {
          params: {
            month: this.month,
            group_code: this.group_code,
            car_insurance: this.car_insurance,
            department_code_from: this.department_code_from
          }
        }).then(function (res) {
          _this6.departmentListTo = res.data.data;
        })["catch"](function (error) {});
      }
    }
  } // watch: {
  //     componentDetail : async function () {
  //         this.$emit('componentDetail', this.componentDetail)           
  //     },
  // }

});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0009_1.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0009_1.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************/
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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['url', 'trans-date', 'trans-btn', 'default-program-code', 'infoAttributes', 'functionName'],
  data: function data() {
    return {
      options: [],
      value: this.defaultProgramCode ? this.defaultProgramCode : [],
      list: [],
      loading: false,
      states: [],
      infos: [],
      programs: [],
      date: {},
      reportType: 'pdf',
      errorLists: [],
      groupCodeList: [],
      renewTypeList: [],
      month: '',
      group_code: '',
      renew_type: '',
      month_value: ''
    };
  },
  methods: {
    getData: function getData(query) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                axios.get(_this.url.getInfor).then(function (res) {
                  _this.programs = res.data.programs;
                }).then(function () {
                  _this.list = _this.infos.map(function (item) {
                    return {
                      value: "value:".concat(item.program_code),
                      label: "label:".concat(item.program_code)
                    };
                  });
                })["catch"](function (error) {});

              case 1:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getInfos: function getInfos() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this2.infoAttributes = [];
                _this2.functionName = "";
                _this2.errorLists = []; // this.value = [];

                axios.get(_this2.url.getInfoAttribute + '?program_code=' + _this2.value // this.urlTest
                ).then(function (res) {
                  // console.log(res);
                  _this2.infoAttributes = res.data.reportInfor;
                  _this2.functionName = res.data.functionName;
                  _this2.functionReport = res.data.functionReport;
                  _this2.programs = res.data.programs;
                  _this2.options = res.data.programs;
                }).then(function () {// this.list = this.infos.map(item => {
                  //     return { value: `value:${item.program_code}`, label: `label:${item.program_code}` };
                  // });
                })["catch"](function (error) {// swal("Error", error, "error");
                });

              case 4:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    getYear: function getYear(value, month) {
      this.group_code_value = 'x111'; // this.infoAttributes.find(data => {
      //     if (data.attribute_name == month) {
      //         data.form_value = value;
      //     }
      // });

      this.month = value;
      console.log('value', value);
      console.log('month', month); // this.month = moment(value)
      //                 .add(+543, "years")
      //                 .format(this.transDate["js-datatime-format"]);
      // this.month = moment(value).format(this.transDate["js-datatime-format"]);

      if (value) {
        this.getGroupCode();
      }

      this.month_value = moment__WEBPACK_IMPORTED_MODULE_1___default()(value).add(-543, "years").format("MM/DD/YYYY");
    },
    checkForm: function checkForm(e) {
      if (!this.month || !this.group_code || !this.renew_type) {
        swal({
          title: "Warning",
          text: 'กรุณาระบุข้อมูลให้ครบถ้วน',
          type: "warning"
        });
      } else {
        return true;
      }

      e.preventDefault();
    },
    getGroupCode: function getGroupCode() {
      var _this3 = this;

      console.log('func getGroupCode');
      axios.get("/ir/reports/irr0009-1-get-group-code", {
        params: {
          month: this.month
        }
      }).then(function (res) {
        _this3.groupCodeList = res.data.data;
      })["catch"](function (error) {});
    },
    getRenewType: function getRenewType() {
      var _this4 = this;

      axios.get("/ir/reports/irr0009-1-get-renew-type", {
        params: {
          month: this.month,
          group_code: this.group_code
        }
      }).then(function (res) {
        _this4.renewTypeList = res.data.data;
      })["catch"](function (error) {});
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0009_2.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0009_2.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ['url', 'trans-date', 'trans-btn', 'default-program-code', 'infoAttributes', 'functionName'],
  data: function data() {
    return {
      options: [],
      value: this.defaultProgramCode ? this.defaultProgramCode : [],
      list: [],
      loading: false,
      states: [],
      infos: [],
      programs: [],
      date: {},
      reportType: 'pdf',
      errorLists: [],
      groupCodeList: [],
      renewTypeList: [],
      month: '',
      group_code: '',
      renew_type: '',
      month_value: ''
    };
  },
  methods: {
    getYear: function getYear(value, month) {
      this.group_code_value = 'x111';
      this.month = value;

      if (value) {
        this.getGroupCode();
      }

      this.month_value = moment__WEBPACK_IMPORTED_MODULE_0___default()(value).add(-543, "years").format("MM/DD/YYYY");
    },
    checkForm: function checkForm(e) {
      if (!this.month || !this.group_code || !this.renew_type) {
        swal({
          title: "Warning",
          text: 'กรุณาระบุข้อมูลให้ครบถ้วน',
          type: "warning"
        });
      } else {
        return true;
      }

      e.preventDefault();
    },
    getGroupCode: function getGroupCode() {
      var _this = this;

      console.log('func getGroupCode');
      axios.get("/ir/reports/irr0009-2-get-group-code", {
        params: {
          month: this.month
        }
      }).then(function (res) {
        _this.groupCodeList = res.data.data;
      })["catch"](function (error) {});
    },
    getRenewType: function getRenewType() {
      var _this2 = this;

      axios.get("/ir/reports/irr0009-2-get-renew-type", {
        params: {
          month: this.month,
          group_code: this.group_code
        }
      }).then(function (res) {
        _this2.renewTypeList = res.data.data;
      })["catch"](function (error) {});
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0009_3.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0009_3.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ['url', 'trans-date', 'trans-btn', 'default-program-code', 'infoAttributes', 'functionName'],
  data: function data() {
    return {
      options: [],
      value: this.defaultProgramCode ? this.defaultProgramCode : [],
      list: [],
      loading: false,
      states: [],
      infos: [],
      programs: [],
      date: {},
      reportType: 'pdf',
      errorLists: [],
      groupCodeList: [],
      gasStationTypeList: [],
      month: '',
      group_code: '',
      gas_station_type: '',
      month_value: ''
    };
  },
  methods: {
    getYear: function getYear(value, month) {
      this.month = value;

      if (value) {
        this.getGroupCode();
      }

      this.month_value = moment__WEBPACK_IMPORTED_MODULE_0___default()(value).add(-543, "years").format("MM/DD/YYYY");
    },
    checkForm: function checkForm(e) {
      if (!this.month || !this.group_code) {
        swal({
          title: "Warning",
          text: 'กรุณาระบุข้อมูลให้ครบถ้วน',
          type: "warning"
        });
      } else {
        return true;
      }

      e.preventDefault();
    },
    getGroupCode: function getGroupCode() {
      var _this = this;

      console.log('func getGroupCode');
      axios.get("/ir/reports/irr0009-3-get-group-code", {
        params: {
          month: this.month
        }
      }).then(function (res) {
        _this.groupCodeList = res.data.data;
      })["catch"](function (error) {});
    },
    getGasStationType: function getGasStationType() {
      var _this2 = this;

      axios.get("/ir/reports/irr0009-3-get-gas-station-type", {
        params: {
          month: this.month,
          group_code: this.group_code
        }
      }).then(function (res) {
        _this2.gasStationTypeList = res.data.data;
      })["catch"](function (error) {});
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0081_1.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0081_1.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************/
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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['url', 'trans-date', 'trans-btn', 'default-program-code', 'infoAttributes', 'functionName'],
  data: function data() {
    return {
      options: [],
      value: this.defaultProgramCode ? this.defaultProgramCode : [],
      list: [],
      loading: false,
      states: [],
      infos: [],
      programs: [],
      date: {},
      reportType: 'pdf',
      errorLists: [],
      policySetList: [],
      month: '',
      policy_set_from: '',
      policy_set_to: '',
      month_value: ''
    };
  },
  methods: {
    getData: function getData(query) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                axios.get(_this.url.getInfor).then(function (res) {
                  _this.programs = res.data.programs;
                }).then(function () {
                  _this.list = _this.infos.map(function (item) {
                    return {
                      value: "value:".concat(item.program_code),
                      label: "label:".concat(item.program_code)
                    };
                  });
                })["catch"](function (error) {});

              case 1:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getInfos: function getInfos() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this2.infoAttributes = [];
                _this2.functionName = "";
                _this2.errorLists = []; // this.value = [];

                axios.get(_this2.url.getInfoAttribute + '?program_code=' + _this2.value // this.urlTest
                ).then(function (res) {
                  // console.log(res);
                  _this2.infoAttributes = res.data.reportInfor;
                  _this2.functionName = res.data.functionName;
                  _this2.functionReport = res.data.functionReport;
                  _this2.programs = res.data.programs;
                  _this2.options = res.data.programs;
                }).then(function () {// this.list = this.infos.map(item => {
                  //     return { value: `value:${item.program_code}`, label: `label:${item.program_code}` };
                  // });
                })["catch"](function (error) {// swal("Error", error, "error");
                });

              case 4:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    getYear: function getYear(value, month) {
      this.month = value;

      if (value) {
        this.getPocicy();
      }

      this.month_value = moment__WEBPACK_IMPORTED_MODULE_1___default()(value).add(-543, "years").format("MM/DD/YYYY");
    },
    checkForm: function checkForm(e) {
      if (!this.month || !this.policy_set_from || !this.policy_set_to) {
        swal({
          title: "Warning",
          text: 'กรุณาระบุข้อมูลให้ครบถ้วน',
          type: "warning"
        });
      } else {
        return true;
      }

      e.preventDefault();
    },
    getPocicy: function getPocicy() {
      var _this3 = this;

      console.log('func getPocicy');
      axios.get("/ir/reports/irr0081-1-get-policy-set", {
        params: {
          month: this.month
        }
      }).then(function (res) {
        _this3.policySetList = res.data.data;
      })["catch"](function (error) {});
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0081_3.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0081_3.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ['url', 'trans-date', 'trans-btn', 'default-program-code', 'infoAttributes', 'functionName'],
  data: function data() {
    return {
      options: [],
      value: this.defaultProgramCode ? this.defaultProgramCode : [],
      list: [],
      loading: false,
      states: [],
      infos: [],
      programs: [],
      date: {},
      reportType: 'pdf',
      errorLists: [],
      policyList: [],
      month: '',
      policy_set_header_id_from: '',
      policy_set_header_id_to: '',
      month_value: ''
    };
  },
  methods: {
    getYear: function getYear(value, month) {
      this.month = value;

      if (value) {
        this.getPolicySet();
      }

      this.month_value = moment__WEBPACK_IMPORTED_MODULE_0___default()(value).add(-543, "years").format("MM/DD/YYYY");
    },
    checkForm: function checkForm(e) {
      if (!this.month) {
        swal({
          title: "Warning",
          text: 'กรุณาระบุข้อมูลให้ครบถ้วน',
          type: "warning"
        });
      } else {
        return true;
      }

      e.preventDefault();
    },
    getPolicySet: function getPolicySet() {
      var _this = this;

      console.log('func getPolicySet');
      axios.get("/ir/reports/irr0081-3-get-policy-set", {
        params: {
          month: this.month
        }
      }).then(function (res) {
        _this.policyList = res.data.data;
      })["catch"](function (error) {});
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/Report.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/Report.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var _IRR0005_3_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./IRR0005_3.vue */ "./resources/js/components/reports/IRR0005_3.vue");
/* harmony import */ var _IRR0009_1_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./IRR0009_1.vue */ "./resources/js/components/reports/IRR0009_1.vue");
/* harmony import */ var _IRR0009_2_vue__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./IRR0009_2.vue */ "./resources/js/components/reports/IRR0009_2.vue");
/* harmony import */ var _IRR0081_1_vue__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./IRR0081_1.vue */ "./resources/js/components/reports/IRR0081_1.vue");
/* harmony import */ var _IRR0009_3_vue__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./IRR0009_3.vue */ "./resources/js/components/reports/IRR0009_3.vue");
/* harmony import */ var _IRR0081_3_vue__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./IRR0081_3.vue */ "./resources/js/components/reports/IRR0081_3.vue");


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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ['url', 'trans-date', 'trans-btn', 'module', 'url-ger-param', 'default-program-code', 'url-sub-query'],
  components: {
    IRR0005_3: _IRR0005_3_vue__WEBPACK_IMPORTED_MODULE_2__.default,
    IRR0009_1: _IRR0009_1_vue__WEBPACK_IMPORTED_MODULE_3__.default,
    IRR0009_2: _IRR0009_2_vue__WEBPACK_IMPORTED_MODULE_4__.default,
    IRR0081_1: _IRR0081_1_vue__WEBPACK_IMPORTED_MODULE_5__.default,
    IRR0009_3: _IRR0009_3_vue__WEBPACK_IMPORTED_MODULE_6__.default,
    IRR0081_3: _IRR0081_3_vue__WEBPACK_IMPORTED_MODULE_7__.default
  },
  data: function data() {
    var _ref;

    return _ref = {
      options: [],
      value: this.defaultProgramCode ? this.defaultProgramCode : [],
      list: [],
      loading: false,
      states: [],
      infos: [],
      programs: [],
      infoAttributes: [],
      date: {},
      functionName: "",
      functionReport: "",
      reportType: 'pdf',
      errorLists: []
    }, _defineProperty(_ref, "loading", {}), _defineProperty(_ref, "irReport", false), _defineProperty(_ref, "month_value", ''), _ref;
  },
  mounted: function mounted() {
    var _this = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              if (_this.defaultProgramCode) {
                _this.getInfos();
              } // ตัวอย่าง การใช้ async , await


              _context.next = 3;
              return _this.test().then(function (res) {
                console.log(res);
              })["catch"](function (err) {
                console.log(err);
              });

            case 3:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  methods: {
    remoteMethod: function remoteMethod(query) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var request;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                request = {
                  params: {
                    module: [_this2.module],
                    uQuery: query
                  }
                };
                axios.get(_this2.urlGerParam, request).then(function (res) {
                  // this.infos = res.data.ptirReportInfos;
                  _this2.programs = res.data.programs;
                  _this2.options = res.data.programs;
                })["catch"](function (error) {// swal("Error", error, "error");
                });

              case 2:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    remote: function remote(query) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                if (query !== "") {
                  _this3.loading = true;
                  setTimeout(function () {
                    _this3.loading = false;
                    _this3.options = _this3.programs.filter(function (item) {
                      if (item.program_code) {
                        return item.program_code.toLowerCase().indexOf(query.toLowerCase()) > -1;
                      }
                    });
                  }, 200);
                } else {
                  _this3.options = [];
                }

              case 1:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    getData: function getData(query) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                axios.get(_this4.url.getInfor).then(function (res) {
                  _this4.programs = res.data.programs;
                }).then(function () {
                  _this4.list = _this4.infos.map(function (item) {
                    return {
                      value: "value:".concat(item.program_code),
                      label: "label:".concat(item.program_code)
                    };
                  });
                })["catch"](function (error) {// swal("Error", error, "error");
                });

              case 1:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    getInfos: function getInfos() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                _this5.infoAttributes = [];
                _this5.functionName = "";
                _this5.errorLists = [];
                axios.get(_this5.url.getInfoAttribute + '?program_code=' + _this5.value // this.urlTest
                ).then(function (res) {
                  // console.log(res);
                  _this5.infoAttributes = res.data.reportInfor;
                  _this5.functionName = res.data.functionName;
                  _this5.functionReport = res.data.functionReport;
                  _this5.programs = res.data.programs;
                  _this5.options = res.data.programs;
                }).then(function () {// this.list = this.infos.map(item => {
                  //     return { value: `value:${item.program_code}`, label: `label:${item.program_code}` };
                  // });
                })["catch"](function (error) {// swal("Error", error, "error");
                });

              case 4:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    getYear: function getYear(value, infoAttribute) {
      if (infoAttribute.date_type == 'month') {
        infoAttribute.form_value = moment__WEBPACK_IMPORTED_MODULE_1___default()(value).add(-543, "years").format(this.transDate["js-datatime-format"]);
      }

      if (infoAttribute.date_type == 'year') {
        infoAttribute.form_value = moment__WEBPACK_IMPORTED_MODULE_1___default()(value).add(-543, "years").format(this.transDate['js-year-format']);
      }

      if (infoAttribute.date_type == 'date') {
        infoAttribute.form_value = moment__WEBPACK_IMPORTED_MODULE_1___default()(value).add(-543, "years").format(this.transDate['js-format']);
      }

      this.month_value = moment__WEBPACK_IMPORTED_MODULE_1___default()(value).add(-543, "years").format("Y-M-d");
      this.action(infoAttribute);
    },
    exportReport: function exportReport() {},
    checkForm: function checkForm(e) {
      var _this6 = this;

      this.errorLists = [];
      this.infoAttributes.forEach(function (info) {
        if (info.required == 1 & info.form_value == null) {
          var msg = 'โปรดระบุ. ' + ' ' + info.display_value;

          _this6.errorLists.push(msg);
        }
      });

      if (this.errorLists.length == 0) {
        return true;
      }

      e.preventDefault();
    },
    selectedList: function selectedList(selected) {
      return selected.value;
    },
    action: function action(infoAttribute) {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6() {
        var checkValue, arr, arrCheckEnable, start, end, value_start, value_end, ids;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                checkValue = false;
                arr = _this7.infoAttributes.filter(function (item) {
                  return item.attribute_8 == infoAttribute.attribute_name || item.attribute_5 == infoAttribute.attribute_name || item.attribute_6 == infoAttribute.attribute_name;
                });
                arrCheckEnable = _this7.infoAttributes.filter(function (item) {
                  return item.attribute_4 == infoAttribute.attribute_name;
                });

                if (arrCheckEnable.length > 0) {
                  arrCheckEnable.forEach(function (item) {
                    _this7.checkDisable(item, false);
                  });
                }

                if (!(arr.length == 0)) {
                  _context6.next = 6;
                  break;
                }

                return _context6.abrupt("return");

              case 6:
                _context6.next = 8;
                return _this7.loadingQuery(arr, true);

              case 8:
                // let vBetween = [];
                start = "";
                end = "";
                value_start = "";
                value_end = "";
                arr.forEach(function (item) {
                  if (item.attribute_7 == 'whereBetween') {
                    start = _this7.infoAttributes.find(function (value) {
                      return value.attribute_name == item.attribute_5;
                    });
                    end = _this7.infoAttributes.find(function (value) {
                      return value.attribute_name == item.attribute_6;
                    });
                  }
                });

                if (start != '') {
                  value_start = start.form_value;
                }

                if (end != '') {
                  value_end = end.form_value;
                } // console.log(start, end)


                ids = arr.map(function (item) {
                  return item.report_info_id;
                });
                _context6.next = 18;
                return _this7.subQuery(ids, infoAttribute.form_value, arr, infoAttribute.seq, value_start, value_end);

              case 18:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      }))();
    },
    subQuery: function subQuery(ids, form_value, arr, seq, start, end) {
      var _this8 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee7() {
        var request;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                request = {
                  params: {
                    ids: ids,
                    value: form_value,
                    value_start: start,
                    value_end: end
                  }
                };
                axios.get(_this8.urlSubQuery, request).then(function (res) {
                  console.log('then res');
                  var infos = res.data.reportInfos;
                  infos.forEach(function (item) {
                    console.log(item, 'then');

                    var infoA = _this8.infoAttributes.find(function (value) {
                      return value.report_info_id == item.report_info_id;
                    });

                    _this8.afterCall(infoA, form_value, seq, item);
                  });
                }).then(function () {
                  // console.log('loading')
                  _this8.loadingQuery(arr, false);
                })["catch"](function (error) {
                  _this8.loadingQuery(arr, false);

                  swal("Error", error, "error !");
                });
                console.log('end');

              case 3:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7);
      }))();
    },
    loadingQuery: function loadingQuery(arr, load) {// await arr.forEach(element => {
      //     element.loading = load;
      // });

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee8() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee8$(_context8) {
          while (1) {
            switch (_context8.prev = _context8.next) {
              case 0:
              case "end":
                return _context8.stop();
            }
          }
        }, _callee8);
      }))();
    },
    resetValueFormSeq: function resetValueFormSeq(seq) {
      var _this9 = this;

      // console.log('resetValueFormSeq')
      this.infoAttributes.forEach(function (element) {
        if (element.seq > seq & (element.attribute_8 != null || element.attribute_7 != null)) {
          element.form_value = '';

          _this9.checkDisable(element, true);
        }
      });
    },
    checkDisable: function checkDisable(info, disable) {
      // console.log('checkDisable')
      info.disable = disable;
    },
    afterCall: function afterCall(infoA, form_value, seq, item) {
      // console.log('afterCall', infoA, form_value, seq, item)
      if (infoA) {
        infoA.form_value = '';
        infoA.lists = item.new_lists;

        if (form_value == '' || form_value == null || form_value == 'Invalid date') {
          infoA.form_value = '';
          this.resetValueFormSeq(seq);
        } else {
          this.checkDisable(infoA, false);
        }
      }
    },
    test: function test() {
      var _this10 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee9() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee9$(_context9) {
          while (1) {
            switch (_context9.prev = _context9.next) {
              case 0:
                _context9.next = 2;
                return _this10.test1();

              case 2:
                _context9.next = 4;
                return _this10.test2();

              case 4:
                _context9.next = 6;
                return _this10.test3();

              case 6:
                _context9.next = 8;
                return _this10.test4();

              case 8:
                return _context9.abrupt("return", 'Success');

              case 9:
              case "end":
                return _context9.stop();
            }
          }
        }, _callee9);
      }))();
    },
    test1: function test1() {
      return new Promise(function (resolve, reject) {
        setTimeout(function () {
          console.log(1);
          return resolve('c');
        }, 100);
      });
    },
    test2: function test2() {
      return new Promise(function (resolve, reject) {
        setTimeout(function () {
          console.log(2);
          return resolve('reject');
        }, 100);
      });
    },
    test3: function test3() {
      return new Promise(function (resolve, reject) {
        setTimeout(function () {
          console.log(3);
          return resolve('c');
        }, 100);
      });
    },
    test4: function test4() {
      return new Promise(function (resolve, reject) {
        setTimeout(function () {
          console.log(4);
          return resolve('c');
        }, 20);
      });
    }
  },
  watch: {
    functionName: function () {
      var _functionName = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee10() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee10$(_context10) {
          while (1) {
            switch (_context10.prev = _context10.next) {
              case 0:
                if (this.functionName == 'IRR0005_3' || this.functionName == 'IRR0009_1' || this.functionName == 'IRR0009_2' || this.functionName == 'IRR0081_1' || this.functionName == 'IRR0009_3' || this.functionName == 'IRR0081_3') {
                  this.irReport = true;
                }

              case 1:
              case "end":
                return _context10.stop();
            }
          }
        }, _callee10, this);
      }));

      function functionName() {
        return _functionName.apply(this, arguments);
      }

      return functionName;
    }()
  }
});

/***/ }),

/***/ "./resources/js/components/reports/IRR0005_3.vue":
/*!*******************************************************!*\
  !*** ./resources/js/components/reports/IRR0005_3.vue ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _IRR0005_3_vue_vue_type_template_id_7b8133f7___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./IRR0005_3.vue?vue&type=template&id=7b8133f7& */ "./resources/js/components/reports/IRR0005_3.vue?vue&type=template&id=7b8133f7&");
/* harmony import */ var _IRR0005_3_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./IRR0005_3.vue?vue&type=script&lang=js& */ "./resources/js/components/reports/IRR0005_3.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _IRR0005_3_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _IRR0005_3_vue_vue_type_template_id_7b8133f7___WEBPACK_IMPORTED_MODULE_0__.render,
  _IRR0005_3_vue_vue_type_template_id_7b8133f7___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/reports/IRR0005_3.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/reports/IRR0009_1.vue":
/*!*******************************************************!*\
  !*** ./resources/js/components/reports/IRR0009_1.vue ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _IRR0009_1_vue_vue_type_template_id_4efdf1f9___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./IRR0009_1.vue?vue&type=template&id=4efdf1f9& */ "./resources/js/components/reports/IRR0009_1.vue?vue&type=template&id=4efdf1f9&");
/* harmony import */ var _IRR0009_1_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./IRR0009_1.vue?vue&type=script&lang=js& */ "./resources/js/components/reports/IRR0009_1.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _IRR0009_1_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _IRR0009_1_vue_vue_type_template_id_4efdf1f9___WEBPACK_IMPORTED_MODULE_0__.render,
  _IRR0009_1_vue_vue_type_template_id_4efdf1f9___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/reports/IRR0009_1.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/reports/IRR0009_2.vue":
/*!*******************************************************!*\
  !*** ./resources/js/components/reports/IRR0009_2.vue ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _IRR0009_2_vue_vue_type_template_id_4f0c097a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./IRR0009_2.vue?vue&type=template&id=4f0c097a& */ "./resources/js/components/reports/IRR0009_2.vue?vue&type=template&id=4f0c097a&");
/* harmony import */ var _IRR0009_2_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./IRR0009_2.vue?vue&type=script&lang=js& */ "./resources/js/components/reports/IRR0009_2.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _IRR0009_2_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _IRR0009_2_vue_vue_type_template_id_4f0c097a___WEBPACK_IMPORTED_MODULE_0__.render,
  _IRR0009_2_vue_vue_type_template_id_4f0c097a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/reports/IRR0009_2.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/reports/IRR0009_3.vue":
/*!*******************************************************!*\
  !*** ./resources/js/components/reports/IRR0009_3.vue ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _IRR0009_3_vue_vue_type_template_id_4f1a20fb___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./IRR0009_3.vue?vue&type=template&id=4f1a20fb& */ "./resources/js/components/reports/IRR0009_3.vue?vue&type=template&id=4f1a20fb&");
/* harmony import */ var _IRR0009_3_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./IRR0009_3.vue?vue&type=script&lang=js& */ "./resources/js/components/reports/IRR0009_3.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _IRR0009_3_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _IRR0009_3_vue_vue_type_template_id_4f1a20fb___WEBPACK_IMPORTED_MODULE_0__.render,
  _IRR0009_3_vue_vue_type_template_id_4f1a20fb___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/reports/IRR0009_3.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/reports/IRR0081_1.vue":
/*!*******************************************************!*\
  !*** ./resources/js/components/reports/IRR0081_1.vue ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _IRR0081_1_vue_vue_type_template_id_3255022e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./IRR0081_1.vue?vue&type=template&id=3255022e& */ "./resources/js/components/reports/IRR0081_1.vue?vue&type=template&id=3255022e&");
/* harmony import */ var _IRR0081_1_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./IRR0081_1.vue?vue&type=script&lang=js& */ "./resources/js/components/reports/IRR0081_1.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _IRR0081_1_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _IRR0081_1_vue_vue_type_template_id_3255022e___WEBPACK_IMPORTED_MODULE_0__.render,
  _IRR0081_1_vue_vue_type_template_id_3255022e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/reports/IRR0081_1.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/reports/IRR0081_3.vue":
/*!*******************************************************!*\
  !*** ./resources/js/components/reports/IRR0081_3.vue ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _IRR0081_3_vue_vue_type_template_id_321ca42a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./IRR0081_3.vue?vue&type=template&id=321ca42a& */ "./resources/js/components/reports/IRR0081_3.vue?vue&type=template&id=321ca42a&");
/* harmony import */ var _IRR0081_3_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./IRR0081_3.vue?vue&type=script&lang=js& */ "./resources/js/components/reports/IRR0081_3.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _IRR0081_3_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _IRR0081_3_vue_vue_type_template_id_321ca42a___WEBPACK_IMPORTED_MODULE_0__.render,
  _IRR0081_3_vue_vue_type_template_id_321ca42a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/reports/IRR0081_3.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/reports/Report.vue":
/*!****************************************************!*\
  !*** ./resources/js/components/reports/Report.vue ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Report_vue_vue_type_template_id_17a968af___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Report.vue?vue&type=template&id=17a968af& */ "./resources/js/components/reports/Report.vue?vue&type=template&id=17a968af&");
/* harmony import */ var _Report_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Report.vue?vue&type=script&lang=js& */ "./resources/js/components/reports/Report.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _Report_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Report_vue_vue_type_template_id_17a968af___WEBPACK_IMPORTED_MODULE_0__.render,
  _Report_vue_vue_type_template_id_17a968af___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/reports/Report.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/reports/IRR0005_3.vue?vue&type=script&lang=js&":
/*!********************************************************************************!*\
  !*** ./resources/js/components/reports/IRR0005_3.vue?vue&type=script&lang=js& ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0005_3_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./IRR0005_3.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0005_3.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0005_3_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/reports/IRR0009_1.vue?vue&type=script&lang=js&":
/*!********************************************************************************!*\
  !*** ./resources/js/components/reports/IRR0009_1.vue?vue&type=script&lang=js& ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0009_1_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./IRR0009_1.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0009_1.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0009_1_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/reports/IRR0009_2.vue?vue&type=script&lang=js&":
/*!********************************************************************************!*\
  !*** ./resources/js/components/reports/IRR0009_2.vue?vue&type=script&lang=js& ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0009_2_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./IRR0009_2.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0009_2.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0009_2_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/reports/IRR0009_3.vue?vue&type=script&lang=js&":
/*!********************************************************************************!*\
  !*** ./resources/js/components/reports/IRR0009_3.vue?vue&type=script&lang=js& ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0009_3_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./IRR0009_3.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0009_3.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0009_3_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/reports/IRR0081_1.vue?vue&type=script&lang=js&":
/*!********************************************************************************!*\
  !*** ./resources/js/components/reports/IRR0081_1.vue?vue&type=script&lang=js& ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0081_1_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./IRR0081_1.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0081_1.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0081_1_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/reports/IRR0081_3.vue?vue&type=script&lang=js&":
/*!********************************************************************************!*\
  !*** ./resources/js/components/reports/IRR0081_3.vue?vue&type=script&lang=js& ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0081_3_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./IRR0081_3.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0081_3.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0081_3_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/reports/Report.vue?vue&type=script&lang=js&":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/reports/Report.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Report_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Report.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/Report.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Report_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/reports/IRR0005_3.vue?vue&type=template&id=7b8133f7&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/reports/IRR0005_3.vue?vue&type=template&id=7b8133f7& ***!
  \**************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0005_3_vue_vue_type_template_id_7b8133f7___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0005_3_vue_vue_type_template_id_7b8133f7___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0005_3_vue_vue_type_template_id_7b8133f7___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./IRR0005_3.vue?vue&type=template&id=7b8133f7& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0005_3.vue?vue&type=template&id=7b8133f7&");


/***/ }),

/***/ "./resources/js/components/reports/IRR0009_1.vue?vue&type=template&id=4efdf1f9&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/reports/IRR0009_1.vue?vue&type=template&id=4efdf1f9& ***!
  \**************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0009_1_vue_vue_type_template_id_4efdf1f9___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0009_1_vue_vue_type_template_id_4efdf1f9___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0009_1_vue_vue_type_template_id_4efdf1f9___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./IRR0009_1.vue?vue&type=template&id=4efdf1f9& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0009_1.vue?vue&type=template&id=4efdf1f9&");


/***/ }),

/***/ "./resources/js/components/reports/IRR0009_2.vue?vue&type=template&id=4f0c097a&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/reports/IRR0009_2.vue?vue&type=template&id=4f0c097a& ***!
  \**************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0009_2_vue_vue_type_template_id_4f0c097a___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0009_2_vue_vue_type_template_id_4f0c097a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0009_2_vue_vue_type_template_id_4f0c097a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./IRR0009_2.vue?vue&type=template&id=4f0c097a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0009_2.vue?vue&type=template&id=4f0c097a&");


/***/ }),

/***/ "./resources/js/components/reports/IRR0009_3.vue?vue&type=template&id=4f1a20fb&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/reports/IRR0009_3.vue?vue&type=template&id=4f1a20fb& ***!
  \**************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0009_3_vue_vue_type_template_id_4f1a20fb___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0009_3_vue_vue_type_template_id_4f1a20fb___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0009_3_vue_vue_type_template_id_4f1a20fb___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./IRR0009_3.vue?vue&type=template&id=4f1a20fb& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0009_3.vue?vue&type=template&id=4f1a20fb&");


/***/ }),

/***/ "./resources/js/components/reports/IRR0081_1.vue?vue&type=template&id=3255022e&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/reports/IRR0081_1.vue?vue&type=template&id=3255022e& ***!
  \**************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0081_1_vue_vue_type_template_id_3255022e___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0081_1_vue_vue_type_template_id_3255022e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0081_1_vue_vue_type_template_id_3255022e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./IRR0081_1.vue?vue&type=template&id=3255022e& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0081_1.vue?vue&type=template&id=3255022e&");


/***/ }),

/***/ "./resources/js/components/reports/IRR0081_3.vue?vue&type=template&id=321ca42a&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/reports/IRR0081_3.vue?vue&type=template&id=321ca42a& ***!
  \**************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0081_3_vue_vue_type_template_id_321ca42a___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0081_3_vue_vue_type_template_id_321ca42a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_IRR0081_3_vue_vue_type_template_id_321ca42a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./IRR0081_3.vue?vue&type=template&id=321ca42a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0081_3.vue?vue&type=template&id=321ca42a&");


/***/ }),

/***/ "./resources/js/components/reports/Report.vue?vue&type=template&id=17a968af&":
/*!***********************************************************************************!*\
  !*** ./resources/js/components/reports/Report.vue?vue&type=template&id=17a968af& ***!
  \***********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Report_vue_vue_type_template_id_17a968af___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Report_vue_vue_type_template_id_17a968af___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Report_vue_vue_type_template_id_17a968af___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Report.vue?vue&type=template&id=17a968af& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/Report.vue?vue&type=template&id=17a968af&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0005_3.vue?vue&type=template&id=7b8133f7&":
/*!*****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0005_3.vue?vue&type=template&id=7b8133f7& ***!
  \*****************************************************************************************************************************************************************************************************************************/
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
      "form",
      {
        attrs: { action: _vm.url.getParam, method: "get", target: "_blank" },
        on: { submit: _vm.checkForm }
      },
      [
        _c("hr", { staticClass: "m-3" }),
        _vm._v(" "),
        _c("div", { staticClass: "row mb-2" }, [
          _vm._m(0),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-6" },
            [
              _c("datepicker-th", {
                staticClass: "form-control col-lg-12",
                staticStyle: { width: "100%", "border-radius": "3px" },
                attrs: { id: "input_date", pType: "month", format: "MM/YYYY" },
                on: {
                  dateWasSelected: function($event) {
                    var i = arguments.length,
                      argsArray = Array(i)
                    while (i--) argsArray[i] = arguments[i]
                    return _vm.getYear.apply(
                      void 0,
                      argsArray.concat(["month"])
                    )
                  }
                },
                model: {
                  value: _vm.month,
                  callback: function($$v) {
                    _vm.month = $$v
                  },
                  expression: "month"
                }
              }),
              _vm._v(" "),
              _c("input", {
                attrs: { type: "hidden", name: "month" },
                domProps: { value: _vm.month }
              }),
              _vm._v(" "),
              _c("input", {
                attrs: { type: "hidden", name: "month_value" },
                domProps: { value: _vm.month_value }
              })
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row" }, [
          _vm._m(1),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-6" },
            [
              _c(
                "el-select",
                {
                  staticClass: "w-100 text-left",
                  attrs: {
                    filterable: "",
                    clearable: "",
                    "popper-append-to-body": false,
                    disabled: !this.month
                  },
                  on: {
                    change: function($event) {
                      return _vm.getCarInsurance()
                    }
                  },
                  model: {
                    value: _vm.group_code,
                    callback: function($$v) {
                      _vm.group_code = $$v
                    },
                    expression: "group_code"
                  }
                },
                [
                  _vm._l(_vm.groupCodeList, function(list) {
                    return _c("el-option", {
                      key: list.value,
                      attrs: { label: list.label, value: list.value }
                    })
                  }),
                  _vm._v(" "),
                  _c("input", {
                    attrs: { type: "hidden", name: "group_code" },
                    domProps: { value: _vm.group_code }
                  })
                ],
                2
              )
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row mt-2" }, [
          _vm._m(2),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-6" },
            [
              _c(
                "el-select",
                {
                  staticClass: "w-100 text-left",
                  attrs: {
                    filterable: "",
                    clearable: "",
                    "popper-append-to-body": false,
                    disabled: !this.group_code
                  },
                  on: {
                    change: function($event) {
                      return _vm.getDepartment()
                    }
                  },
                  model: {
                    value: _vm.car_insurance,
                    callback: function($$v) {
                      _vm.car_insurance = $$v
                    },
                    expression: "car_insurance"
                  }
                },
                [
                  _vm._l(_vm.carInsuranceeList, function(list, index) {
                    return _c("el-option", {
                      key: index,
                      attrs: { label: list.label, value: list.value }
                    })
                  }),
                  _vm._v(" "),
                  _c("input", {
                    attrs: { type: "hidden", name: "car_insurance" },
                    domProps: { value: _vm.car_insurance }
                  })
                ],
                2
              )
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row mt-2" }, [
          _vm._m(3),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-6" },
            [
              _c(
                "el-select",
                {
                  staticClass: "w-100 text-left",
                  attrs: {
                    filterable: "",
                    clearable: "",
                    "popper-append-to-body": false,
                    disabled: !this.car_insurance
                  },
                  model: {
                    value: _vm.department_code_from,
                    callback: function($$v) {
                      _vm.department_code_from = $$v
                    },
                    expression: "department_code_from"
                  }
                },
                [
                  _vm._l(_vm.departmentList, function(list, index) {
                    return _c("el-option", {
                      key: index,
                      attrs: { label: list.label, value: list.value }
                    })
                  }),
                  _vm._v(" "),
                  _c("input", {
                    attrs: { type: "hidden", name: "department_code_from" },
                    domProps: { value: _vm.department_code_from }
                  })
                ],
                2
              )
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row mt-2 mb-2" }, [
          _vm._m(4),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-6" },
            [
              _c(
                "el-select",
                {
                  staticClass: "w-100 text-left",
                  attrs: {
                    filterable: "",
                    clearable: "",
                    "popper-append-to-body": false,
                    disabled: !this.car_insurance
                  },
                  model: {
                    value: _vm.department_code_to,
                    callback: function($$v) {
                      _vm.department_code_to = $$v
                    },
                    expression: "department_code_to"
                  }
                },
                [
                  _vm._l(_vm.departmentList, function(list) {
                    return _c("el-option", {
                      key: list.value,
                      attrs: { label: list.label, value: list.value }
                    })
                  }),
                  _vm._v(" "),
                  _c("input", {
                    attrs: { type: "hidden", name: "department_code_to" },
                    domProps: { value: _vm.department_code_to }
                  })
                ],
                2
              )
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("input", {
          attrs: { type: "hidden", name: "program_code" },
          domProps: { value: _vm.value }
        }),
        _vm._v(" "),
        _c("input", {
          attrs: { type: "hidden", name: "function_name" },
          domProps: { value: _vm.functionName }
        }),
        _vm._v(" "),
        _c("input", {
          attrs: { type: "hidden", name: "output" },
          domProps: { value: _vm.reportType }
        }),
        _vm._v(" "),
        _c("div", { staticClass: "text-center" }, [
          _c(
            "button",
            {
              class: _vm.transBtn.printReport.class,
              attrs: { type: "submit" }
            },
            [
              _c("i", { class: _vm.transBtn.printReport.icon }),
              _vm._v(" " + _vm._s(_vm.transBtn.printReport.text))
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
    return _c("div", { staticClass: "m-1 col-3 text-right" }, [
      _c("div", [
        _vm._v("\n                    เดือน "),
        _c("span", { staticClass: "tw-text-red-400" }, [_vm._v("* ")])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "m-1 col-3 text-right" }, [
      _c("div", [_vm._v("\n                    กลุ่ม\n                ")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "m-1 col-3 text-right" }, [
      _c("div", [
        _vm._v("\n                    ประเภทประกันภัย\n                ")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "m-1 col-3 text-right" }, [
      _c("div", [
        _vm._v("\n                    หน่วยงานตั้งแต่\n                ")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "m-1 col-3 text-right" }, [
      _c("div", [_vm._v("\n                    หน่วยงานถึง\n                ")])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0009_1.vue?vue&type=template&id=4efdf1f9&":
/*!*****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0009_1.vue?vue&type=template&id=4efdf1f9& ***!
  \*****************************************************************************************************************************************************************************************************************************/
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
      "form",
      {
        attrs: { action: _vm.url.getParam, method: "get", target: "_blank" },
        on: { submit: _vm.checkForm }
      },
      [
        _c("hr", { staticClass: "m-3" }),
        _vm._v(" "),
        _c("div", { staticClass: "row mb-2" }, [
          _vm._m(0),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-6" },
            [
              _c("datepicker-th", {
                staticClass: "form-control col-lg-12",
                staticStyle: { width: "100%", "border-radius": "3px" },
                attrs: { id: "input_date", pType: "month", format: "MM/YYYY" },
                on: {
                  dateWasSelected: function($event) {
                    var i = arguments.length,
                      argsArray = Array(i)
                    while (i--) argsArray[i] = arguments[i]
                    return _vm.getYear.apply(
                      void 0,
                      argsArray.concat(["month"])
                    )
                  }
                },
                model: {
                  value: _vm.month,
                  callback: function($$v) {
                    _vm.month = $$v
                  },
                  expression: "month"
                }
              }),
              _vm._v(" "),
              _c("input", {
                attrs: { type: "hidden", name: "month" },
                domProps: { value: _vm.month }
              }),
              _vm._v(" "),
              _c("input", {
                attrs: { type: "hidden", name: "month_value" },
                domProps: { value: _vm.month_value }
              })
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row" }, [
          _vm._m(1),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-6" },
            [
              _c(
                "el-select",
                {
                  staticClass: "w-100 text-left",
                  attrs: {
                    filterable: "",
                    clearable: "",
                    "popper-append-to-body": false,
                    disabled: !this.month
                  },
                  on: {
                    change: function($event) {
                      return _vm.getRenewType()
                    }
                  },
                  model: {
                    value: _vm.group_code,
                    callback: function($$v) {
                      _vm.group_code = $$v
                    },
                    expression: "group_code"
                  }
                },
                [
                  _vm._l(_vm.groupCodeList, function(list) {
                    return _c("el-option", {
                      key: list.value,
                      attrs: { label: list.label, value: list.value }
                    })
                  }),
                  _vm._v(" "),
                  _c("input", {
                    attrs: { type: "hidden", name: "group_code" },
                    domProps: { value: _vm.group_code }
                  })
                ],
                2
              )
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row mt-2" }, [
          _vm._m(2),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-6" },
            [
              _c(
                "el-select",
                {
                  staticClass: "w-100 text-left",
                  attrs: {
                    filterable: "",
                    clearable: "",
                    "popper-append-to-body": false,
                    disabled: !this.group_code
                  },
                  model: {
                    value: _vm.renew_type,
                    callback: function($$v) {
                      _vm.renew_type = $$v
                    },
                    expression: "renew_type"
                  }
                },
                [
                  _vm._l(_vm.renewTypeList, function(list, index) {
                    return _c("el-option", {
                      key: index,
                      attrs: { label: list.label, value: list.value }
                    })
                  }),
                  _vm._v(" "),
                  _c("input", {
                    attrs: { type: "hidden", name: "renew_type" },
                    domProps: { value: _vm.renew_type }
                  })
                ],
                2
              )
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("input", {
          attrs: { type: "hidden", name: "program_code" },
          domProps: { value: _vm.value }
        }),
        _vm._v(" "),
        _c("input", {
          attrs: { type: "hidden", name: "function_name" },
          domProps: { value: _vm.functionName }
        }),
        _vm._v(" "),
        _c("input", {
          attrs: { type: "hidden", name: "output" },
          domProps: { value: _vm.reportType }
        }),
        _vm._v(" "),
        _c("div", { staticClass: "text-center mt-2" }, [
          _c(
            "button",
            {
              class: _vm.transBtn.printReport.class,
              attrs: { type: "submit" }
            },
            [
              _c("i", { class: _vm.transBtn.printReport.icon }),
              _vm._v(" " + _vm._s(_vm.transBtn.printReport.text))
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
    return _c("div", { staticClass: "m-1 col-3 text-right" }, [
      _c("div", [
        _vm._v("\n                    เดือน "),
        _c("span", { staticClass: "tw-text-red-400" }, [_vm._v("* ")])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "m-1 col-3 text-right" }, [
      _c("div", [
        _vm._v("\n                    กลุ่ม "),
        _c("span", { staticClass: "tw-text-red-400" }, [_vm._v("* ")])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "m-1 col-3 text-right" }, [
      _c("div", [
        _vm._v("\n                    ประเภทประกันภัย "),
        _c("span", { staticClass: "tw-text-red-400" }, [_vm._v("* ")])
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0009_2.vue?vue&type=template&id=4f0c097a&":
/*!*****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0009_2.vue?vue&type=template&id=4f0c097a& ***!
  \*****************************************************************************************************************************************************************************************************************************/
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
      "form",
      {
        attrs: { action: _vm.url.getParam, method: "get", target: "_blank" },
        on: { submit: _vm.checkForm }
      },
      [
        _c("hr", { staticClass: "m-3" }),
        _vm._v(" "),
        _c("div", { staticClass: "row mb-2" }, [
          _vm._m(0),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-6" },
            [
              _c("datepicker-th", {
                staticClass: "form-control col-lg-12",
                staticStyle: { width: "100%", "border-radius": "3px" },
                attrs: { id: "input_date", pType: "month", format: "MM/YYYY" },
                on: {
                  dateWasSelected: function($event) {
                    var i = arguments.length,
                      argsArray = Array(i)
                    while (i--) argsArray[i] = arguments[i]
                    return _vm.getYear.apply(
                      void 0,
                      argsArray.concat(["month"])
                    )
                  }
                },
                model: {
                  value: _vm.month,
                  callback: function($$v) {
                    _vm.month = $$v
                  },
                  expression: "month"
                }
              }),
              _vm._v(" "),
              _c("input", {
                attrs: { type: "hidden", name: "month" },
                domProps: { value: _vm.month }
              }),
              _vm._v(" "),
              _c("input", {
                attrs: { type: "hidden", name: "month_value" },
                domProps: { value: _vm.month_value }
              })
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row" }, [
          _vm._m(1),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-6" },
            [
              _c(
                "el-select",
                {
                  staticClass: "w-100 text-left",
                  attrs: {
                    filterable: "",
                    clearable: "",
                    "popper-append-to-body": false,
                    disabled: !this.month
                  },
                  on: {
                    change: function($event) {
                      return _vm.getRenewType()
                    }
                  },
                  model: {
                    value: _vm.group_code,
                    callback: function($$v) {
                      _vm.group_code = $$v
                    },
                    expression: "group_code"
                  }
                },
                [
                  _vm._l(_vm.groupCodeList, function(list) {
                    return _c("el-option", {
                      key: list.value,
                      attrs: { label: list.label, value: list.value }
                    })
                  }),
                  _vm._v(" "),
                  _c("input", {
                    attrs: { type: "hidden", name: "group_code" },
                    domProps: { value: _vm.group_code }
                  })
                ],
                2
              )
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row mt-2" }, [
          _vm._m(2),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-6" },
            [
              _c(
                "el-select",
                {
                  staticClass: "w-100 text-left",
                  attrs: {
                    filterable: "",
                    clearable: "",
                    "popper-append-to-body": false,
                    disabled: !this.group_code
                  },
                  model: {
                    value: _vm.renew_type,
                    callback: function($$v) {
                      _vm.renew_type = $$v
                    },
                    expression: "renew_type"
                  }
                },
                [
                  _vm._l(_vm.renewTypeList, function(list, index) {
                    return _c("el-option", {
                      key: index,
                      attrs: { label: list.label, value: list.value }
                    })
                  }),
                  _vm._v(" "),
                  _c("input", {
                    attrs: { type: "hidden", name: "renew_type" },
                    domProps: { value: _vm.renew_type }
                  })
                ],
                2
              )
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("input", {
          attrs: { type: "hidden", name: "program_code" },
          domProps: { value: _vm.value }
        }),
        _vm._v(" "),
        _c("input", {
          attrs: { type: "hidden", name: "function_name" },
          domProps: { value: _vm.functionName }
        }),
        _vm._v(" "),
        _c("input", {
          attrs: { type: "hidden", name: "output" },
          domProps: { value: _vm.reportType }
        }),
        _vm._v(" "),
        _c("div", { staticClass: "text-center mt-2" }, [
          _c(
            "button",
            {
              class: _vm.transBtn.printReport.class,
              attrs: { type: "submit" }
            },
            [
              _c("i", { class: _vm.transBtn.printReport.icon }),
              _vm._v(" " + _vm._s(_vm.transBtn.printReport.text))
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
    return _c("div", { staticClass: "m-1 col-3 text-right" }, [
      _c("div", [
        _vm._v("\n                    เดือน "),
        _c("span", { staticClass: "tw-text-red-400" }, [_vm._v("* ")])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "m-1 col-3 text-right" }, [
      _c("div", [
        _vm._v("\n                    กลุ่ม "),
        _c("span", { staticClass: "tw-text-red-400" }, [_vm._v("* ")])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "m-1 col-3 text-right" }, [
      _c("div", [
        _vm._v("\n                    ประเภทประกันภัย "),
        _c("span", { staticClass: "tw-text-red-400" }, [_vm._v("* ")])
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0009_3.vue?vue&type=template&id=4f1a20fb&":
/*!*****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0009_3.vue?vue&type=template&id=4f1a20fb& ***!
  \*****************************************************************************************************************************************************************************************************************************/
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
      "form",
      {
        attrs: { action: _vm.url.getParam, method: "get", target: "_blank" },
        on: { submit: _vm.checkForm }
      },
      [
        _c("hr", { staticClass: "m-3" }),
        _vm._v(" "),
        _c("div", { staticClass: "row mb-2" }, [
          _vm._m(0),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-6" },
            [
              _c("datepicker-th", {
                staticClass: "form-control col-lg-12",
                staticStyle: { width: "100%", "border-radius": "3px" },
                attrs: { id: "input_date", pType: "month", format: "MM/YYYY" },
                on: {
                  dateWasSelected: function($event) {
                    var i = arguments.length,
                      argsArray = Array(i)
                    while (i--) argsArray[i] = arguments[i]
                    return _vm.getYear.apply(
                      void 0,
                      argsArray.concat(["month"])
                    )
                  }
                },
                model: {
                  value: _vm.month,
                  callback: function($$v) {
                    _vm.month = $$v
                  },
                  expression: "month"
                }
              }),
              _vm._v(" "),
              _c("input", {
                attrs: { type: "hidden", name: "month" },
                domProps: { value: _vm.month }
              }),
              _vm._v(" "),
              _c("input", {
                attrs: { type: "hidden", name: "month_value" },
                domProps: { value: _vm.month_value }
              })
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row" }, [
          _vm._m(1),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-6" },
            [
              _c(
                "el-select",
                {
                  staticClass: "w-100 text-left",
                  attrs: {
                    filterable: "",
                    clearable: "",
                    "popper-append-to-body": false,
                    disabled: !this.month
                  },
                  on: {
                    change: function($event) {
                      return _vm.getGasStationType()
                    }
                  },
                  model: {
                    value: _vm.group_code,
                    callback: function($$v) {
                      _vm.group_code = $$v
                    },
                    expression: "group_code"
                  }
                },
                [
                  _vm._l(_vm.groupCodeList, function(list) {
                    return _c("el-option", {
                      key: list.value,
                      attrs: { label: list.label, value: list.value }
                    })
                  }),
                  _vm._v(" "),
                  _c("input", {
                    attrs: { type: "hidden", name: "group_code" },
                    domProps: { value: _vm.group_code }
                  })
                ],
                2
              )
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row mt-2" }, [
          _vm._m(2),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-6" },
            [
              _c(
                "el-select",
                {
                  staticClass: "w-100 text-left",
                  attrs: {
                    filterable: "",
                    clearable: "",
                    "popper-append-to-body": false,
                    disabled: !this.group_code
                  },
                  model: {
                    value: _vm.gas_station_type,
                    callback: function($$v) {
                      _vm.gas_station_type = $$v
                    },
                    expression: "gas_station_type"
                  }
                },
                [
                  _vm._l(_vm.gasStationTypeList, function(list, index) {
                    return _c("el-option", {
                      key: index,
                      attrs: { label: list.label, value: list.value }
                    })
                  }),
                  _vm._v(" "),
                  _c("input", {
                    attrs: { type: "hidden", name: "gas_station_type" },
                    domProps: { value: _vm.gas_station_type }
                  })
                ],
                2
              )
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("input", {
          attrs: { type: "hidden", name: "program_code" },
          domProps: { value: _vm.value }
        }),
        _vm._v(" "),
        _c("input", {
          attrs: { type: "hidden", name: "function_name" },
          domProps: { value: _vm.functionName }
        }),
        _vm._v(" "),
        _c("input", {
          attrs: { type: "hidden", name: "output" },
          domProps: { value: _vm.reportType }
        }),
        _vm._v(" "),
        _c("div", { staticClass: "text-center mt-2" }, [
          _c(
            "button",
            {
              class: _vm.transBtn.printReport.class,
              attrs: { type: "submit" }
            },
            [
              _c("i", { class: _vm.transBtn.printReport.icon }),
              _vm._v(" " + _vm._s(_vm.transBtn.printReport.text))
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
    return _c("div", { staticClass: "m-1 col-3 text-right" }, [
      _c("div", [
        _vm._v("\n                    เดือน "),
        _c("span", { staticClass: "tw-text-red-400" }, [_vm._v("* ")])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "m-1 col-3 text-right" }, [
      _c("div", [
        _vm._v("\n                    กลุ่ม "),
        _c("span", { staticClass: "tw-text-red-400" }, [_vm._v("* ")])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "m-1 col-3 text-right" }, [
      _c("div", [
        _vm._v("\n                    ประเภทสถานีน้ำมัน\n                ")
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0081_1.vue?vue&type=template&id=3255022e&":
/*!*****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0081_1.vue?vue&type=template&id=3255022e& ***!
  \*****************************************************************************************************************************************************************************************************************************/
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
      "form",
      {
        attrs: { action: _vm.url.getParam, method: "get", target: "_blank" },
        on: { submit: _vm.checkForm }
      },
      [
        _c("hr", { staticClass: "m-3" }),
        _vm._v(" "),
        _c("div", { staticClass: "row mb-2" }, [
          _vm._m(0),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-6" },
            [
              _c("datepicker-th", {
                staticClass: "form-control col-lg-12",
                staticStyle: { width: "100%", "border-radius": "3px" },
                attrs: { id: "input_date", pType: "month", format: "MM/YYYY" },
                on: {
                  dateWasSelected: function($event) {
                    var i = arguments.length,
                      argsArray = Array(i)
                    while (i--) argsArray[i] = arguments[i]
                    return _vm.getYear.apply(
                      void 0,
                      argsArray.concat(["month"])
                    )
                  }
                },
                model: {
                  value: _vm.month,
                  callback: function($$v) {
                    _vm.month = $$v
                  },
                  expression: "month"
                }
              }),
              _vm._v(" "),
              _c("input", {
                attrs: { type: "hidden", name: "month" },
                domProps: { value: _vm.month }
              }),
              _vm._v(" "),
              _c("input", {
                attrs: { type: "hidden", name: "month_value" },
                domProps: { value: _vm.month_value }
              })
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row mt-2" }, [
          _vm._m(1),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-6" },
            [
              _c(
                "el-select",
                {
                  staticClass: "w-100 text-left",
                  attrs: {
                    filterable: "",
                    clearable: "",
                    "popper-append-to-body": false,
                    disabled: !this.month
                  },
                  model: {
                    value: _vm.policy_set_from,
                    callback: function($$v) {
                      _vm.policy_set_from = $$v
                    },
                    expression: "policy_set_from"
                  }
                },
                [
                  _vm._l(_vm.policySetList, function(list, index) {
                    return _c("el-option", {
                      key: index,
                      attrs: { label: list.label, value: list.value }
                    })
                  }),
                  _vm._v(" "),
                  _c("input", {
                    attrs: { type: "hidden", name: "policy_set_from" },
                    domProps: { value: _vm.policy_set_from }
                  })
                ],
                2
              )
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row mt-2 mb-2" }, [
          _vm._m(2),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-6" },
            [
              _c(
                "el-select",
                {
                  staticClass: "w-100 text-left",
                  attrs: {
                    filterable: "",
                    clearable: "",
                    "popper-append-to-body": false,
                    disabled: !this.month
                  },
                  model: {
                    value: _vm.policy_set_to,
                    callback: function($$v) {
                      _vm.policy_set_to = $$v
                    },
                    expression: "policy_set_to"
                  }
                },
                [
                  _vm._l(_vm.policySetList, function(list) {
                    return _c("el-option", {
                      key: list.value,
                      attrs: { label: list.label, value: list.value }
                    })
                  }),
                  _vm._v(" "),
                  _c("input", {
                    attrs: { type: "hidden", name: "policy_set_to" },
                    domProps: { value: _vm.policy_set_to }
                  })
                ],
                2
              )
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("input", {
          attrs: { type: "hidden", name: "program_code" },
          domProps: { value: _vm.value }
        }),
        _vm._v(" "),
        _c("input", {
          attrs: { type: "hidden", name: "function_name" },
          domProps: { value: _vm.functionName }
        }),
        _vm._v(" "),
        _c("input", {
          attrs: { type: "hidden", name: "output" },
          domProps: { value: _vm.reportType }
        }),
        _vm._v(" "),
        _c("div", { staticClass: "text-center mt-2" }, [
          _c(
            "button",
            {
              class: _vm.transBtn.printReport.class,
              attrs: { type: "submit" }
            },
            [
              _c("i", { class: _vm.transBtn.printReport.icon }),
              _vm._v(" " + _vm._s(_vm.transBtn.printReport.text))
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
    return _c("div", { staticClass: "m-1 col-3 text-right" }, [
      _c("div", [
        _vm._v("\n                    เดือน "),
        _c("span", { staticClass: "tw-text-red-400" }, [_vm._v("* ")])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "m-1 col-3 text-right" }, [
      _c("div", [
        _vm._v("\n                    กรมธรรม์ชุดที่ ตั้งแต่ "),
        _c("span", { staticClass: "tw-text-red-400" }, [_vm._v("* ")])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "m-1 col-3 text-right" }, [
      _c("div", [
        _vm._v("\n                    กรมธรรม์ชุดที่ ถึง "),
        _c("span", { staticClass: "tw-text-red-400" }, [_vm._v("* ")])
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0081_3.vue?vue&type=template&id=321ca42a&":
/*!*****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/IRR0081_3.vue?vue&type=template&id=321ca42a& ***!
  \*****************************************************************************************************************************************************************************************************************************/
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
      "form",
      {
        attrs: { action: _vm.url.getParam, method: "get", target: "_blank" },
        on: { submit: _vm.checkForm }
      },
      [
        _c("hr", { staticClass: "m-3" }),
        _vm._v(" "),
        _c("div", { staticClass: "row mb-2" }, [
          _vm._m(0),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-6" },
            [
              _c("datepicker-th", {
                staticClass: "form-control col-lg-12",
                staticStyle: { width: "100%", "border-radius": "3px" },
                attrs: { id: "input_date", pType: "month", format: "MM/YYYY" },
                on: {
                  dateWasSelected: function($event) {
                    var i = arguments.length,
                      argsArray = Array(i)
                    while (i--) argsArray[i] = arguments[i]
                    return _vm.getYear.apply(
                      void 0,
                      argsArray.concat(["month"])
                    )
                  }
                },
                model: {
                  value: _vm.month,
                  callback: function($$v) {
                    _vm.month = $$v
                  },
                  expression: "month"
                }
              }),
              _vm._v(" "),
              _c("input", {
                attrs: { type: "hidden", name: "month" },
                domProps: { value: _vm.month }
              }),
              _vm._v(" "),
              _c("input", {
                attrs: { type: "hidden", name: "month_value" },
                domProps: { value: _vm.month_value }
              })
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row" }, [
          _vm._m(1),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-6" },
            [
              _c(
                "el-select",
                {
                  staticClass: "w-100 text-left",
                  attrs: {
                    filterable: "",
                    clearable: "",
                    "popper-append-to-body": false,
                    disabled: !this.month
                  },
                  model: {
                    value: _vm.policy_set_header_id_from,
                    callback: function($$v) {
                      _vm.policy_set_header_id_from = $$v
                    },
                    expression: "policy_set_header_id_from"
                  }
                },
                [
                  _vm._l(_vm.policyList, function(list, index) {
                    return _c("el-option", {
                      key: index,
                      attrs: { label: list.label, value: list.value }
                    })
                  }),
                  _vm._v(" "),
                  _c("input", {
                    attrs: {
                      type: "hidden",
                      name: "policy_set_header_id_from"
                    },
                    domProps: { value: _vm.policy_set_header_id_from }
                  })
                ],
                2
              )
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row mt-2" }, [
          _vm._m(2),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-6" },
            [
              _c(
                "el-select",
                {
                  staticClass: "w-100 text-left",
                  attrs: {
                    filterable: "",
                    clearable: "",
                    "popper-append-to-body": false,
                    disabled: !this.month
                  },
                  model: {
                    value: _vm.policy_set_header_id_to,
                    callback: function($$v) {
                      _vm.policy_set_header_id_to = $$v
                    },
                    expression: "policy_set_header_id_to"
                  }
                },
                [
                  _vm._l(_vm.policyList, function(list, index) {
                    return _c("el-option", {
                      key: index,
                      attrs: { label: list.label, value: list.value }
                    })
                  }),
                  _vm._v(" "),
                  _c("input", {
                    attrs: { type: "hidden", name: "policy_set_header_id_to" },
                    domProps: { value: _vm.policy_set_header_id_to }
                  })
                ],
                2
              )
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("input", {
          attrs: { type: "hidden", name: "program_code" },
          domProps: { value: _vm.value }
        }),
        _vm._v(" "),
        _c("input", {
          attrs: { type: "hidden", name: "function_name" },
          domProps: { value: _vm.functionName }
        }),
        _vm._v(" "),
        _c("input", {
          attrs: { type: "hidden", name: "output" },
          domProps: { value: _vm.reportType }
        }),
        _vm._v(" "),
        _c("div", { staticClass: "text-center mt-2" }, [
          _c(
            "button",
            {
              class: _vm.transBtn.printReport.class,
              attrs: { type: "submit" }
            },
            [
              _c("i", { class: _vm.transBtn.printReport.icon }),
              _vm._v(" " + _vm._s(_vm.transBtn.printReport.text))
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
    return _c("div", { staticClass: "m-1 col-3 text-right" }, [
      _c("div", [
        _vm._v("\n                    เดือน "),
        _c("span", { staticClass: "tw-text-red-400" }, [_vm._v("* ")])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "m-1 col-3 text-right" }, [
      _c("div", [
        _vm._v("\n                    ชุดกรมธรรม์ ตั้งแต่\n                ")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "m-1 col-3 text-right" }, [
      _c("div", [
        _vm._v("\n                    ชุดกรมธรรม์ ถึง\n                ")
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/Report.vue?vue&type=template&id=17a968af&":
/*!**************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/Report.vue?vue&type=template&id=17a968af& ***!
  \**************************************************************************************************************************************************************************************************************************/
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
          staticClass: "col-11",
          attrs: {
            filterable: "",
            remote: "",
            "reserve-keyword": "",
            placeholder: "Please enter a report ",
            "remote-method": _vm.remoteMethod,
            clearable: ""
          },
          on: {
            change: _vm.getInfos,
            input: function($event) {
              return _vm.remoteMethod(" ")
            }
          },
          model: {
            value: _vm.value,
            callback: function($$v) {
              _vm.value = $$v
            },
            expression: "value"
          }
        },
        _vm._l(_vm.options, function(item) {
          return _c("el-option", {
            key: item.program_code,
            attrs: {
              label: item.program_code + " " + item.description,
              value: item.program_code
            }
          })
        }),
        1
      ),
      _vm._v(" "),
      _vm.irReport && _vm.functionName == "IRR0005_3"
        ? _c(
            "div",
            [
              _c("IRR0005_3", {
                attrs: {
                  url: this.url,
                  "trans-btn": this.transBtn,
                  "trans-date": this.transDate,
                  "default-program-code": this.value,
                  "info-attributes": this.infoAttributes,
                  "function-name": this.functionName
                }
              })
            ],
            1
          )
        : _vm._e(),
      _vm._v(" "),
      _vm.irReport && _vm.functionName == "IRR0009_1"
        ? _c(
            "div",
            [
              _c("IRR0009_1", {
                attrs: {
                  url: this.url,
                  "trans-btn": this.transBtn,
                  "trans-date": this.transDate,
                  "default-program-code": this.value,
                  "info-attributes": this.infoAttributes,
                  "function-name": this.functionName
                }
              })
            ],
            1
          )
        : _vm._e(),
      _vm._v(" "),
      _vm.irReport && _vm.functionName == "IRR0009_2"
        ? _c(
            "div",
            [
              _c("IRR0009_2", {
                attrs: {
                  url: this.url,
                  "trans-btn": this.transBtn,
                  "trans-date": this.transDate,
                  "default-program-code": this.value,
                  "info-attributes": this.infoAttributes,
                  "function-name": this.functionName
                }
              })
            ],
            1
          )
        : _vm._e(),
      _vm._v(" "),
      _vm.irReport && _vm.functionName == "IRR0081_1"
        ? _c(
            "div",
            [
              _c("IRR0081_1", {
                attrs: {
                  url: this.url,
                  "trans-btn": this.transBtn,
                  "trans-date": this.transDate,
                  "default-program-code": this.value,
                  "info-attributes": this.infoAttributes,
                  "function-name": this.functionName
                }
              })
            ],
            1
          )
        : _vm._e(),
      _vm._v(" "),
      _vm.irReport && _vm.functionName == "IRR0009_3"
        ? _c(
            "div",
            [
              _c("IRR0009_3", {
                attrs: {
                  url: this.url,
                  "trans-btn": this.transBtn,
                  "trans-date": this.transDate,
                  "default-program-code": this.value,
                  "info-attributes": this.infoAttributes,
                  "function-name": this.functionName
                }
              })
            ],
            1
          )
        : _vm._e(),
      _vm._v(" "),
      _vm.irReport && _vm.functionName == "IRR0081_3"
        ? _c(
            "div",
            [
              _c("IRR0081_3", {
                attrs: {
                  url: this.url,
                  "trans-btn": this.transBtn,
                  "trans-date": this.transDate,
                  "default-program-code": this.value,
                  "info-attributes": this.infoAttributes,
                  "function-name": this.functionName
                }
              })
            ],
            1
          )
        : _vm._e(),
      _vm._v(" "),
      !_vm.irReport
        ? _c(
            "form",
            {
              attrs: {
                action: _vm.url.getParam,
                method: "get",
                target: "_blank"
              },
              on: { submit: _vm.checkForm }
            },
            [
              _c("hr", { staticClass: "m-3" }),
              _vm._v(" "),
              _vm.infoAttributes.length > 0
                ? _c(
                    "div",
                    { staticClass: "form-group" },
                    [
                      _vm._l(_vm.infoAttributes, function(
                        infoAttribute,
                        index
                      ) {
                        return _c("div", { key: index }, [
                          infoAttribute.form_type == "text"
                            ? _c("div", { staticClass: "row m-2" }, [
                                _c(
                                  "div",
                                  { staticClass: "m-1 col-3 text-right" },
                                  [
                                    _c("div", [
                                      _vm._v(
                                        "  " +
                                          _vm._s(infoAttribute.display_value) +
                                          " "
                                      ),
                                      infoAttribute.required == "1"
                                        ? _c(
                                            "span",
                                            { staticClass: "tw-text-red-400" },
                                            [_vm._v("* ")]
                                          )
                                        : _vm._e()
                                    ])
                                  ]
                                ),
                                _vm._v(" "),
                                _c("div", { staticClass: "col-6" }, [
                                  _c("input", {
                                    staticClass: "form-control w-100 ",
                                    attrs: {
                                      type: "text",
                                      name: infoAttribute.attribute_name
                                    }
                                  })
                                ])
                              ])
                            : _vm._e(),
                          _vm._v(" "),
                          infoAttribute.form_type == "date"
                            ? _c("div", { staticClass: "row m-2" }, [
                                _c(
                                  "div",
                                  { staticClass: "m-1 col-3 text-right" },
                                  [
                                    _c("div", [
                                      _vm._v(
                                        "\n                            " +
                                          _vm._s(infoAttribute.display_value) +
                                          "  "
                                      ),
                                      infoAttribute.required == "1"
                                        ? _c(
                                            "span",
                                            { staticClass: "tw-text-red-400" },
                                            [_vm._v("* ")]
                                          )
                                        : _vm._e()
                                    ])
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "div",
                                  { staticClass: "col-6" },
                                  [
                                    _c("datepicker-th", {
                                      staticClass: "form-control col-lg-12",
                                      staticStyle: {
                                        width: "100%",
                                        "border-radius": "3px"
                                      },
                                      attrs: {
                                        id: "input_date",
                                        pType: infoAttribute.date_type,
                                        format: infoAttribute.format_date
                                      },
                                      on: {
                                        dateWasSelected: function($event) {
                                          var i = arguments.length,
                                            argsArray = Array(i)
                                          while (i--)
                                            argsArray[i] = arguments[i]
                                          return _vm.getYear.apply(
                                            void 0,
                                            argsArray.concat([infoAttribute])
                                          )
                                        }
                                      },
                                      model: {
                                        value:
                                          infoAttribute.attribute_name[
                                            infoAttribute.id
                                          ],
                                        callback: function($$v) {
                                          _vm.$set(
                                            infoAttribute.attribute_name,
                                            infoAttribute.id,
                                            $$v
                                          )
                                        },
                                        expression:
                                          "infoAttribute.attribute_name[infoAttribute.id]"
                                      }
                                    }),
                                    _vm._v(" "),
                                    _c("input", {
                                      directives: [
                                        {
                                          name: "model",
                                          rawName: "v-model",
                                          value: infoAttribute.form_value,
                                          expression: "infoAttribute.form_value"
                                        }
                                      ],
                                      attrs: {
                                        type: "hidden",
                                        name: infoAttribute.attribute_name
                                      },
                                      domProps: {
                                        value: infoAttribute.form_value
                                      },
                                      on: {
                                        input: function($event) {
                                          if ($event.target.composing) {
                                            return
                                          }
                                          _vm.$set(
                                            infoAttribute,
                                            "form_value",
                                            $event.target.value
                                          )
                                        }
                                      }
                                    })
                                  ],
                                  1
                                )
                              ])
                            : _vm._e(),
                          _vm._v(" "),
                          infoAttribute.form_type == "select"
                            ? _c("div", { staticClass: "row m-2" }, [
                                _c(
                                  "div",
                                  { staticClass: "m-1 col-3 text-right" },
                                  [
                                    _c("div", [
                                      _vm._v(
                                        _vm._s(infoAttribute.display_value) +
                                          " "
                                      ),
                                      infoAttribute.required == "1"
                                        ? _c(
                                            "span",
                                            { staticClass: "tw-text-red-400" },
                                            [_vm._v("* ")]
                                          )
                                        : _vm._e()
                                    ])
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
                                        value: infoAttribute.loading,
                                        expression: "infoAttribute.loading"
                                      }
                                    ],
                                    staticClass: "col-6"
                                  },
                                  [
                                    _c(
                                      "el-select",
                                      {
                                        staticClass: "w-100 text-left",
                                        attrs: {
                                          filterable: "",
                                          clearable: "",
                                          "popper-append-to-body": false,
                                          disabled: infoAttribute.disable
                                        },
                                        on: {
                                          change: function($event) {
                                            return _vm.action(infoAttribute)
                                          }
                                        },
                                        model: {
                                          value: infoAttribute.form_value,
                                          callback: function($$v) {
                                            _vm.$set(
                                              infoAttribute,
                                              "form_value",
                                              $$v
                                            )
                                          },
                                          expression: "infoAttribute.form_value"
                                        }
                                      },
                                      [
                                        _vm._l(infoAttribute.lists, function(
                                          list,
                                          listIndex
                                        ) {
                                          return _c("el-option", {
                                            key: listIndex,
                                            attrs: {
                                              label: list.label,
                                              value: list.value
                                            }
                                          })
                                        }),
                                        _vm._v(" "),
                                        _c("input", {
                                          attrs: {
                                            type: "hidden",
                                            name: infoAttribute.attribute_name
                                          },
                                          domProps: {
                                            value: infoAttribute.form_value
                                          }
                                        })
                                      ],
                                      2
                                    )
                                  ],
                                  1
                                )
                              ])
                            : _vm._e(),
                          _vm._v(" "),
                          infoAttribute.form_type == "options"
                            ? _c("div", { staticClass: "row m-2" }, [
                                _c(
                                  "div",
                                  { staticClass: "m-1 col-3 text-right" },
                                  [
                                    _c("div", [
                                      _vm._v(
                                        _vm._s(infoAttribute.display_value) +
                                          " "
                                      ),
                                      infoAttribute.required == "1"
                                        ? _c(
                                            "span",
                                            { staticClass: "tw-text-red-400" },
                                            [_vm._v("* ")]
                                          )
                                        : _vm._e()
                                    ])
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "div",
                                  { staticClass: "col-6" },
                                  [
                                    _c(
                                      "el-select",
                                      {
                                        staticClass: "w-100 text-left",
                                        attrs: {
                                          filterable: "",
                                          clearable: "",
                                          "popper-append-to-body": false
                                        },
                                        model: {
                                          value: infoAttribute.form_value,
                                          callback: function($$v) {
                                            _vm.$set(
                                              infoAttribute,
                                              "form_value",
                                              $$v
                                            )
                                          },
                                          expression: "infoAttribute.form_value"
                                        }
                                      },
                                      [
                                        _vm._l(infoAttribute.lists, function(
                                          list
                                        ) {
                                          return _c("el-option", {
                                            key: list.value,
                                            attrs: {
                                              label: list.label,
                                              value: list.value
                                            }
                                          })
                                        }),
                                        _vm._v(" "),
                                        _c("input", {
                                          attrs: {
                                            type: "hidden",
                                            name: infoAttribute.attribute_name
                                          },
                                          domProps: {
                                            value: infoAttribute.form_value
                                          }
                                        })
                                      ],
                                      2
                                    )
                                  ],
                                  1
                                )
                              ])
                            : _vm._e()
                        ])
                      }),
                      _vm._v(" "),
                      _vm.functionReport.attribute_9 == "Y"
                        ? _c("div", { staticClass: "row m-2" }, [
                            _vm._m(0),
                            _vm._v(" "),
                            _c(
                              "div",
                              { staticClass: "col-6" },
                              [
                                _c(
                                  "el-radio",
                                  {
                                    attrs: { label: "pdf" },
                                    model: {
                                      value: _vm.reportType,
                                      callback: function($$v) {
                                        _vm.reportType = $$v
                                      },
                                      expression: "reportType"
                                    }
                                  },
                                  [_vm._v(" PDF ")]
                                ),
                                _vm._v(" "),
                                _c(
                                  "el-radio",
                                  {
                                    attrs: { label: "excel" },
                                    model: {
                                      value: _vm.reportType,
                                      callback: function($$v) {
                                        _vm.reportType = $$v
                                      },
                                      expression: "reportType"
                                    }
                                  },
                                  [_vm._v(" Excel ")]
                                )
                              ],
                              1
                            )
                          ])
                        : _vm._e(),
                      _vm._v(" "),
                      _c("div", { staticClass: "row m-2" }, [
                        _c(
                          "div",
                          { staticClass: "col-12 text-center" },
                          [
                            _vm.errorLists.length > 0 ? _c("p") : _vm._e(),
                            _vm._l(_vm.errorLists, function(errorList, index) {
                              return _c(
                                "div",
                                {
                                  key: index,
                                  staticClass: "font-weight-bold text-danger"
                                },
                                [
                                  _vm._v(
                                    "\n                            " +
                                      _vm._s(errorList) +
                                      "\n                        "
                                  )
                                ]
                              )
                            }),
                            _vm._v(" "),
                            _c("p")
                          ],
                          2
                        )
                      ]),
                      _vm._v(" "),
                      _c("input", {
                        attrs: { type: "hidden", name: "program_code" },
                        domProps: { value: _vm.value }
                      }),
                      _vm._v(" "),
                      _c("input", {
                        attrs: { type: "hidden", name: "function_name" },
                        domProps: { value: _vm.functionName }
                      }),
                      _vm._v(" "),
                      _c("input", {
                        attrs: { type: "hidden", name: "output" },
                        domProps: { value: _vm.reportType }
                      }),
                      _vm._v(" "),
                      _c("input", {
                        attrs: { type: "hidden", name: "month_value" },
                        domProps: { value: _vm.month_value }
                      }),
                      _vm._v(" "),
                      _c("div", { staticClass: "text-center" }, [
                        _c(
                          "button",
                          {
                            class: _vm.transBtn.printReport.class,
                            attrs: { type: "submit" }
                          },
                          [
                            _c("i", { class: _vm.transBtn.printReport.icon }),
                            _vm._v(" " + _vm._s(_vm.transBtn.printReport.text))
                          ]
                        )
                      ])
                    ],
                    2
                  )
                : _vm._e()
            ]
          )
        : _vm._e()
    ],
    1
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "m-1 col-3 text-right" }, [
      _c("div", [
        _vm._v(" ประเภทรายงาน "),
        _c("span", { staticClass: "tw-text-red-400" }, [_vm._v("* ")])
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);