(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_Planning_Stamp-follow_ShowComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/ModalCreate.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/ModalCreate.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["btnTrans", "url", "createInput"],
  data: function data() {
    return {
      loading: false,
      loadingVerNo: false,
      yearList: this.createInput.year_list,
      monthList: this.createInput.month_list,
      budgetYear: this.createInput.def_period_year,
      periodNo: this.createInput.def_period_no,
      thaiMonth: ''
    };
  },
  mounted: function mounted() {//
  },
  computed: {//
  },
  watch: {//
  },
  methods: {
    openModal: function openModal() {
      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                $('#modal_create').modal('show');

              case 1:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    submit: function submit() {
      var vm = this;
      vm.loading = true;
      axios.post(vm.url.ajax_validate, {
        budget_year: vm.budgetYear,
        period_no: vm.periodNo
      }).then(function (res) {
        if (res.data.data.status == 'W') {
          swal({
            html: true,
            title: 'สร้างข้อมูลการติดตามการใช้แสตมป์รายวัน',
            text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> มีข้อมูลการติดตามการใช้แสตมป์รายวันอยู่แล้ว ต้องการอัพเดตข้อมูลหรือไม่ ? </span></h2>',
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
              vm.create();
            }

            vm.loading = false;
          });
        } else if (res.data.data.status == 'E') {
          swal({
            title: 'มีข้อผิดพลาด',
            text: '<span style="font-size: 15px; text-align: left;">' + res.data.data.msg + '</span>',
            type: "warning",
            html: true
          });
        } else {
          vm.create();
        }
      })["catch"](function (err) {}).then(function () {
        vm.loading = false;
      });
    },
    create: function create() {
      var vm = this;
      vm.loading = true;
      axios.post(vm.url.ajax_store, {
        budget_year: vm.budgetYear,
        period_no: vm.periodNo
      }).then(function (res) {
        if (res.data.data.status == 'S') {
          swal({
            title: 'สร้างข้อมูลการติดตามการใช้แสตมป์รายวัน',
            text: '<span style="font-size: 15px; text-align: left;">' + res.data.data.msg + '</span>',
            type: "success",
            html: true
          });
          window.setTimeout(function () {
            window.location.href = res.data.data.redirect_page;
          }, 500);
        } else {
          swal({
            title: 'มีข้อผิดพลาด',
            text: '<span style="font-size: 15px; text-align: left;">' + res.data.data.msg + '</span>',
            type: "warning",
            html: true
          });
        }
      })["catch"](function (err) {}).then(function () {
        vm.loading = false;
      });
    },
    getDetail: function getDetail() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                vm = _this;

                if (!(!vm.budgetYear && !vm.periodNo)) {
                  _context2.next = 3;
                  break;
                }

                return _context2.abrupt("return");

              case 3:
                vm.loadingVerNo = true;
                axios.get(vm.url.ajax_modal_create_details, {
                  params: {
                    period_no: vm.periodNo
                  }
                }).then(function (res) {
                  var response = res.data.data;
                  vm.versionNo = response.version_no;
                  vm.loadingVerNo = false;
                });

              case 5:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    getMonth: function getMonth() {
      this.periodNo = '';
      this.thaiMonth = '';
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/ModalInterfacePR.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/ModalInterfacePR.vue?vue&type=script&lang=js& ***!
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


function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["btnTrans", "url", "header", "stampMain", "users"],
  data: function data() {
    return {
      head: this.header,
      loading: false,
      needByDate: '',
      interfaceFlag: false,
      approver1: '',
      approver2: '',
      html: '',
      checkDate: {
        curr_date: '',
        date_from: '',
        date_to: '',
        need_by_date: ''
      },
      errors: {
        need_by_date: '',
        approver1: '',
        approver2: ''
      }
    };
  },
  watch: {
    errors: {
      handler: function handler(val) {
        val.approver1 ? this.setError('approver1') : this.resetError('approver1');
        val.approver2 ? this.setError('approver2') : this.resetError('approver2');
      },
      deep: true
    }
  },
  methods: _defineProperty({
    openModal: function openModal() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this.getDetail();

                _this.approver1 = '';
                _this.approver2 = '';
                _this.html = '';
                $('#modal_interface').modal('show');

              case 5:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getDetail: function getDetail() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                vm = _this2;
                vm.loading = true;
                vm.html;
                _context2.next = 5;
                return axios.get(vm.url.ajax_get_period).then(function (res) {
                  var currDate = moment__WEBPACK_IMPORTED_MODULE_1___default()().format('YYYY-MM-DD');
                  var dateFrom = moment__WEBPACK_IMPORTED_MODULE_1___default()(res.data.period.start_date).format('YYYY-MM-DD');
                  var dateTo = moment__WEBPACK_IMPORTED_MODULE_1___default()(res.data.period.end_date).format('YYYY-MM-DD'); // values

                  vm.checkDate.date_from = dateFrom;
                  vm.checkDate.date_to = dateTo;

                  _this2.convertDate();
                })["catch"](function (err) {
                  var msg = err;
                  swal({
                    title: 'มีข้อผิดพลาด',
                    text: msg.message,
                    type: "error"
                  });
                }).then(function () {
                  vm.loading = false;
                });

              case 5:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    convertDate: function convertDate() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var currDate, currentDate, need_by_date;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                currDate = moment__WEBPACK_IMPORTED_MODULE_1___default()().format('YYYY-MM-DD');
                _context3.next = 3;
                return helperDate.parseToDateTh(currDate, 'YYYY-MM-DD');

              case 3:
                currentDate = _context3.sent;
                _this3.needByDate = moment__WEBPACK_IMPORTED_MODULE_1___default()(currentDate).format('DD-MMM-YYYY');
                _this3.checkDate.curr_date = moment__WEBPACK_IMPORTED_MODULE_1___default()(currentDate).format('DD-MMM-YYYY');
                need_by_date = moment__WEBPACK_IMPORTED_MODULE_1___default()(currentDate).format('YYYY-MM-DD');
                need_by_date = _this3.changeThToEn(need_by_date);
                _this3.checkDate.need_by_date = need_by_date;

              case 9:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    dateWasSelected: function dateWasSelected(date) {
      var form = $('#form-interface');
      this.errors.need_by_date = false;
      $(form).find("div[id='el_explode_need_by_date']").html("");
      this.needByDate = date ? moment__WEBPACK_IMPORTED_MODULE_1___default()(date).format('DD-MMM-YYYY') : '';
      var need_by_date = moment__WEBPACK_IMPORTED_MODULE_1___default()(date).format('YYYY-MM-DD');
      need_by_date = this.changeThToEn(need_by_date);
      this.checkDate.need_by_date = need_by_date;
      this.getSummaryPR();
    },
    changeThToEn: function changeThToEn(dateTh) {
      // เปลี่ยน Format และ เปลี่ยน พศ -> คศ
      var vm = this;
      var date = moment__WEBPACK_IMPORTED_MODULE_1___default()(dateTh, 'YYYY-MM-DD');
      date.subtract(543, 'years');
      return date.format('YYYY-MM-DD');
    },
    errorRef: function errorRef(res) {
      var vm = this;
      vm.errors.need_by_date = res.err.need_by_date;
    },
    getSummaryPR: function getSummaryPR() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                vm = _this4;
                vm.loading = true;
                _context4.next = 4;
                return axios.post(vm.url.ajax_get_summary_interface_pr, {
                  needByDate: vm.checkDate.need_by_date
                }).then(function (res) {
                  vm.html = res.data.html;
                  vm.interfaceFlag = res.data.interfaceFlag;
                })["catch"](function (err) {
                  var msg = err;
                  swal({
                    title: 'มีข้อผิดพลาด',
                    text: msg.message,
                    type: "error"
                  });
                }).then(function () {
                  vm.loading = false;
                });

              case 4:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    submitPR: function submitPR() {
      var vm = this;
      var form = $('#interface-form');
      var valid = true;
      var msg = '';
      vm.errors.approver1 = false;
      vm.errors.approver2 = false;
      $(form).find("div[id='el_explode_approver1']").html("");
      $(form).find("div[id='el_explode_approver2']").html(""); // Validate input

      if (vm.approver1 == '') {
        vm.errors.approver1 = true;
        valid = false;
        msg = "กรุณาระบุผู้ตรวจสอบ";
        $(form).find("div[id='el_explode_approver1']").html(msg);
      }

      if (vm.approver2 == '') {
        vm.errors.approver2 = true;
        valid = false;
        msg = "กรุณาระบุผู้อนุมัติ";
        $(form).find("div[id='el_explode_approver2']").html(msg);
      }

      if (!valid) {
        return;
      }

      swal({
        html: true,
        title: '<div class="mt-4">  ส่งข้อมูลแสตมป์เข้าระบบ PR </div>',
        text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> ต้องการส่งข้อมูลแสตมป์เข้าระบบ PR ใช่หรือไม่ ? </span></h2>',
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
          vm["interface"]();
        }

        vm.loading = false;
      });
    },
    "interface": function _interface() {
      var vm = this;
      vm.loading = true;
      axios.post(vm.url.ajax_interface_pr, {
        needByDate: vm.checkDate.need_by_date,
        approver1: vm.approver1,
        approver2: vm.approver2
      }).then(function (res) {
        if (res.data.status == 'S') {
          vm.$emit("updateStampHeader", {
            header: res.data.header,
            interfaceTemps: res.data.interfaceTemps,
            poLists: res.data.poLists
          });
          swal({
            title: '<div class="mt-4">  ส่งข้อมูลแสตมป์เข้าระบบ PR </div>',
            text: '<span style="font-size: 15px; text-align: left;">' + res.data.msg + '</span>',
            type: "success",
            html: true
          });
        } else {
          swal({
            title: 'มีข้อผิดพลาด',
            text: '<span style="font-size: 15px; text-align: left;">' + res.data.msg + '</span>',
            type: "warning",
            html: true
          });
        }
      })["catch"](function (err) {
        swal({
          title: 'มีข้อผิดพลาด',
          text: '<span style="font-size: 15px; text-align: left;">' + res.data.msg + '</span>',
          type: "warning",
          html: true
        });
      }).then(function () {
        $('#modal_interface').modal('hide');
        vm.loading = false;
      });
    },
    setError: function setError(ref_name) {
      var ref = this.$refs[ref_name].$refs.reference ? this.$refs[ref_name].$refs.reference.$refs.input : this.$refs[ref_name].$refs.textarea ? this.$refs[ref_name].$refs.textarea : this.$refs[ref_name].$refs.input.$refs ? this.$refs[ref_name].$refs.input.$refs.input : this.$refs[ref_name].$refs.input;
      ref.style = "border: 1px solid red;";
    },
    resetError: function resetError(ref_name) {
      var ref = this.$refs[ref_name].$refs.reference ? this.$refs[ref_name].$refs.reference.$refs.input : this.$refs[ref_name].$refs.textarea ? this.$refs[ref_name].$refs.textarea : this.$refs[ref_name].$refs.input.$refs ? this.$refs[ref_name].$refs.input.$refs.input : this.$refs[ref_name].$refs.input;
      ref.style = "";
    }
  }, "errorRef", function errorRef(res) {
    var vm = this;
    vm.errors.approver1 = res.err.approver1;
    vm.errors.approver2 = res.err.approver2;
  })
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/ModalSearch.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/ModalSearch.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['budgetYears', 'monthList', 'defBudgetYear', "btnTrans", "url"],
  data: function data() {
    return {
      budget_year: this.defBudgetYear,
      month: '',
      loading: false,
      errors: {
        budget_year: false,
        month: false
      }
    };
  },
  mounted: function mounted() {//
  },
  computed: {//
  },
  watch: {
    errors: {
      handler: function handler(val) {
        val.budget_year ? this.setError('budget_year') : this.resetError('budget_year');
        val.month ? this.setError('month') : this.resetError('month');
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
                vm.errors.month = false;
                $(form).find("div[id='el_explode_budget_year']").html("");
                $(form).find("div[id='el_explode_month']").html("");

                if (vm.budgetYear == '') {
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

                if (valid) {
                  _context.next = 12;
                  break;
                }

                return _context.abrupt("return");

              case 12:
                vm.loading = true;
                form.submit();

              case 14:
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
      vm.errors.budget_year = res.err.budget_year;
      vm.errors.month = res.err.month;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/ShowComponent.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/ShowComponent.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ModalCreate_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ModalCreate.vue */ "./resources/js/components/Planning/Stamp-follow/ModalCreate.vue");
/* harmony import */ var _ModalSearch_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalSearch.vue */ "./resources/js/components/Planning/Stamp-follow/ModalSearch.vue");
/* harmony import */ var _ModalInterfacePR_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ModalInterfacePR.vue */ "./resources/js/components/Planning/Stamp-follow/ModalInterfacePR.vue");
/* harmony import */ var _components_HeaderDetail_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./components/HeaderDetail.vue */ "./resources/js/components/Planning/Stamp-follow/components/HeaderDetail.vue");
/* harmony import */ var _components_StampDaily_vue__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./components/StampDaily.vue */ "./resources/js/components/Planning/Stamp-follow/components/StampDaily.vue");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_5__);
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






/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    ModalCreate: _ModalCreate_vue__WEBPACK_IMPORTED_MODULE_0__.default,
    ModalSearch: _ModalSearch_vue__WEBPACK_IMPORTED_MODULE_1__.default,
    ModalInterface: _ModalInterfacePR_vue__WEBPACK_IMPORTED_MODULE_2__.default,
    HeaderDetail: _components_HeaderDetail_vue__WEBPACK_IMPORTED_MODULE_3__.default,
    StampDaily: _components_StampDaily_vue__WEBPACK_IMPORTED_MODULE_4__.default
  },
  props: ["btnTrans", "dateFormat", "createInput", "searchInput", "url", "header", "defaultSearch", 'users', 'interfaceTemps', 'poLists', 'lastDate'],
  data: function data() {
    return _defineProperty({
      stamp_main: this.header,
      loading: false,
      valid: false,
      temps: this.interfaceTemps,
      poMaps: this.poLists
    }, "poMaps", this.poLists);
  },
  mounted: function mounted() {
    this.checkCanEdit();
  },
  methods: {
    updateStamp: function updateStamp(res) {
      this.stamp_main = res;
    },
    updateStampHeader: function updateStampHeader(res) {
      // update when interface PR
      this.stamp_main = res.header;
      this.temps = res.interfaceTemps;
      this.poMaps = res.poLists;
    },
    checkCanEdit: function checkCanEdit() {
      var last_date = moment__WEBPACK_IMPORTED_MODULE_5___default()(this.lastDate).format('YYYY-MM-DD');
      var curr_date = moment__WEBPACK_IMPORTED_MODULE_5___default()().format('YYYY-MM-DD');

      if (last_date > curr_date) {
        this.valid = true;
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/HeaderDetail.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/HeaderDetail.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["header"],
  data: function data() {
    return {//
    };
  },
  methods: {//
  },
  watch: {},
  computed: {}
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/ReceiveRoll.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/ReceiveRoll.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************************************************************************/
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
//
//
//


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_1___default())
  },
  props: ['stamp', 'line', 'editFlag', 'lineRollDailyEdit'],
  data: function data() {
    return {
      oldWeeklyReceiveQty: this.line.weekly_receive_qty,
      oldRollReceiveQty: this.line.receive_roll_qty,
      oldReceiptAmount: this.line.receipt_amount,
      canEdit: false
    };
  },
  mounted: function mounted() {
    this.checkCanEdit();
  },
  watch: {
    'editFlag': function editFlag(newValue) {
      if (newValue == false) {
        this.line.weekly_receive_qty = Number(this.oldWeeklyReceiveQty);
        this.line.receive_roll_qty = Number(this.oldRollReceiveQty);
        this.line.receipt_amount = Number(this.oldReceiptAmount);
      }
    }
  },
  methods: {
    decimal: function decimal(number) {
      return Number(number).toLocaleString(undefined, {
        minimumFractionDigits: 2
      });
    },
    formatNumber: function formatNumber(number) {
      return Number(number).toLocaleString(undefined);
    },
    changeReceiveQty: function changeReceiveQty() {
      var vm = this; // Convert quantity daily

      var result = Number(vm.line.receive_roll_qty) * Number(vm.stamp.stamp_per_roll);
      vm.line.weekly_receive_qty = result.toFixed(2);
      var receipt_amount = vm.line.weekly_receive_qty * Number(vm.stamp.unit_price);
      vm.line.receipt_amount = receipt_amount.toFixed(2);
      Vue.set(vm.lineRollDailyEdit, vm.line.follow_date, Number(vm.line.receive_roll_qty));
    },
    checkCanEdit: function checkCanEdit() {
      var follow_date = moment__WEBPACK_IMPORTED_MODULE_0___default()(this.line.follow_date).format('YYYY-MM-DD');
      var curr_date = moment__WEBPACK_IMPORTED_MODULE_0___default()().format('YYYY-MM-DD');

      if (follow_date > curr_date) {
        this.canEdit = true;
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/ReceiveWeekly.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/ReceiveWeekly.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************************************************************************************/
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
//
//
//


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_1___default())
  },
  props: ['stamp', 'line', 'editFlag', 'lineWeeklyDailyEdit'],
  data: function data() {
    return {
      oldWeeklyReceiveQty: this.line.weekly_receive_qty,
      oldRollReceiveQty: this.line.receive_roll_qty,
      oldReceiptAmount: this.line.receipt_amount,
      canEdit: false
    };
  },
  mounted: function mounted() {
    this.checkCanEdit();
  },
  watch: {
    'editFlag': function editFlag(newValue) {
      if (newValue == false) {
        this.line.weekly_receive_qty = Number(this.oldWeeklyReceiveQty);
        this.line.receive_roll_qty = Number(this.oldRollReceiveQty);
        this.line.receipt_amount = Number(this.oldReceiptAmount); // Vue.set(this.lineWeeklyDailyEdit, {});
      }
    }
  },
  methods: {
    decimal: function decimal(number) {
      return Number(number).toLocaleString(undefined, {
        minimumFractionDigits: 2
      });
    },
    formatNumber: function formatNumber(number) {
      return Number(number).toLocaleString(undefined);
    },
    changeReceiveQty: function changeReceiveQty() {
      var vm = this; // Convert quantity daily

      var result = Number(vm.line.weekly_receive_qty) / Number(vm.stamp.stamp_per_roll);
      vm.line.receive_roll_qty = result.toFixed(2);
      var receipt_amount = vm.line.weekly_receive_qty * Number(vm.stamp.unit_price);
      vm.line.receipt_amount = receipt_amount.toFixed(2);
      Vue.set(vm.lineWeeklyDailyEdit, vm.line.follow_date, Number(vm.line.weekly_receive_qty));
    },
    checkCanEdit: function checkCanEdit() {
      var follow_date = moment__WEBPACK_IMPORTED_MODULE_0___default()(this.line.follow_date).format('YYYY-MM-DD');
      var curr_date = moment__WEBPACK_IMPORTED_MODULE_0___default()().format('YYYY-MM-DD');

      if (follow_date > curr_date) {
        this.canEdit = true;
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/StampDaily.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/StampDaily.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _StampDailyTableTab1_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./StampDailyTableTab1.vue */ "./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab1.vue");
/* harmony import */ var _StampDailyTableTab2_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./StampDailyTableTab2.vue */ "./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab2.vue");
/* harmony import */ var _StampDailyTableTab3_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./StampDailyTableTab3.vue */ "./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab3.vue");


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



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    StampDailyTableTab1: _StampDailyTableTab1_vue__WEBPACK_IMPORTED_MODULE_1__.default,
    StampDailyTableTab2: _StampDailyTableTab2_vue__WEBPACK_IMPORTED_MODULE_2__.default,
    StampDailyTableTab3: _StampDailyTableTab3_vue__WEBPACK_IMPORTED_MODULE_3__.default
  },
  props: ['header', 'btnTrans', 'url', 'interfaceTemps', 'poLists'],
  data: function data() {
    return {
      head: this.header,
      loading: {
        stampDailyTab1Process: false,
        stampDailyTab2Process: false,
        stampDailyTab3Process: false
      },
      valid_action: false,
      stamp_code: '',
      set_stamp_code: '',
      summaryDataTab1: [],
      summaryDataTab2: [],
      summaryDataTab3: [],
      errors: {
        stamp_code_tab1: false,
        stamp_code_tab2: false,
        cigarettes_code: false
      },
      tab1Input: {
        stamp_code: '',
        cigarettes_code: ''
      },
      tab2Input: {
        stamp_code: '',
        set_stamp_code: ''
      }
    };
  },
  mounted: function mounted() {//
  },
  computed: {},
  watch: {
    errors: {
      handler: function handler(val) {
        val.stamp_code_tab1 ? this.setError('stamp_code_tab1') : this.resetError('stamp_code_tab1');
        val.stamp_code_tab2 ? this.setError('stamp_code_tab2') : this.resetError('stamp_code_tab2');
        val.cigarettes_code ? this.setError('cigarettes_code') : this.resetError('cigarettes_code');
      },
      deep: true
    }
  },
  methods: {
    selStamp: function selStamp() {
      if (this.valid_action) {
        swal({
          title: 'บันทึกหรือยกเลิกการเปลี่ยนแปลงข้อมูล',
          text: '<span style="font-size: 16px; text-align: left;"> กรุณาทำการบันทึกหรือยกเลิกการเปลี่ยนแปลงให้เรียบร้อย </span>',
          type: "warning",
          html: true
        });
        this.stamp_code = this.set_stamp_code;
        return;
      }

      this.summaryData = [];
      this.tab1Input.cigarettes_code = '';
      this.summaryDataTab1 = [];
    },
    updateStamp: function updateStamp(res) {
      this.valid_action = res.valid_action;

      if (res.status === 'S') {
        this.getStampDailyTab1();
        this.$emit("updateStamp", res.stamp_main);
      }
    },
    validAction: function validAction(res) {
      this.valid_action = res;
    },
    getStampDailyTab1: function getStampDailyTab1() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var vm, form, valid, errorMsg, stampId;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                vm = _this;

                if (!vm.valid_action) {
                  _context.next = 4;
                  break;
                }

                swal({
                  title: 'บันทึกหรือยกเลิกการเปลี่ยนแปลงข้อมูล',
                  text: '<span style="font-size: 16px; text-align: left;"> กรุณาทำการบันทึกหรือยกเลิกการเปลี่ยนแปลงให้เรียบร้อย </span>',
                  type: "warning",
                  html: true
                });
                return _context.abrupt("return");

              case 4:
                form = $('#stamp-form-tab1');
                valid = true;
                errorMsg = '';
                vm.errors.stamp_code_tab1 = false;
                vm.errors.cigarettes_code = false;
                $(form).find("div[id='el_explode_stamp_code_tab1']").html("");
                $(form).find("div[id='el_explode_cigarettes_code_tab1']").html("");

                if (vm.tab1Input.stamp_code == '' || vm.tab1Input.stamp_code == null) {
                  vm.errors.stamp_code_tab1 = true;
                  valid = false;
                  errorMsg = "กรุณาเลือกรหัสแสตมป์";
                  $(form).find("div[id='el_explode_stamp_code_tab1']").html(errorMsg);
                }

                if (vm.tab1Input.cigarettes_code == '' || vm.tab1Input.cigarettes_code == null) {
                  vm.errors.cigarettes_code = true;
                  valid = false;
                  errorMsg = "กรุณาเลือกรหัสบุหรี่";
                  $(form).find("div[id='el_explode_cigarettes_code_tab1']").html(errorMsg);
                }

                if (valid) {
                  _context.next = 15;
                  break;
                }

                return _context.abrupt("return");

              case 15:
                stampId = vm.header.stamp_summary[vm.tab1Input.stamp_code][0].follow_stamp_id;
                vm.set_stamp_code = _this.tab1Input.stamp_code;
                vm.summaryData = '';
                vm.loading.stampDailyTab1Process = true;
                _context.next = 21;
                return axios.get(vm.url.ajax_get_stamp_daily_tab1, {
                  params: {
                    follow_stamp_main_id: vm.header.follow_stamp_main_id,
                    stamp_code: vm.tab1Input.stamp_code,
                    cigarettes_code: vm.tab1Input.cigarettes_code
                  }
                }).then(function (res) {
                  vm.summaryDataTab1 = res.data.data.stampDaily;
                })["catch"](function (err) {
                  var data = err.response.data;
                  swal({
                    title: 'มีข้อผิดพลาด',
                    text: '<span style="font-size: 15px; text-align: left;">' + data.message + '</span>',
                    type: "warning",
                    html: true
                  });
                }).then(function () {
                  vm.loading.stampDailyTab1Process = false;
                });

              case 21:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getStampDailyTab2: function getStampDailyTab2() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var vm, form, valid, errorMsg, stampId;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                console.log('tab2');
                vm = _this2;

                if (!vm.valid_action) {
                  _context2.next = 5;
                  break;
                }

                swal({
                  title: 'บันทึกหรือยกเลิกการเปลี่ยนแปลงข้อมูล',
                  text: '<span style="font-size: 16px; text-align: left;"> กรุณาทำการบันทึกหรือยกเลิกการเปลี่ยนแปลงให้เรียบร้อย </span>',
                  type: "warning",
                  html: true
                });
                return _context2.abrupt("return");

              case 5:
                form = $('#stamp-form-tab2');
                valid = true;
                errorMsg = '';
                vm.errors.stamp_code_tab2 = false;
                $(form).find("div[id='el_explode_stamp_code_tab2']").html("");

                if (vm.tab2Input.stamp_code == '' || vm.tab2Input.stamp_code == null) {
                  vm.errors.stamp_code_tab2 = true;
                  valid = false;
                  errorMsg = "กรุณาเลือกรหัสแสตมป์";
                  $(form).find("div[id='el_explode_stamp_code_tab2']").html(errorMsg);
                }

                if (valid) {
                  _context2.next = 13;
                  break;
                }

                return _context2.abrupt("return");

              case 13:
                stampId = vm.header.stamp_summary[vm.tab2Input.stamp_code][0].follow_stamp_id;
                vm.set_stamp_code = vm.tab2Input.stamp_code;
                vm.summaryData = '';
                vm.loading.stampDailyTab2Process = true;
                _context2.next = 19;
                return axios.get(vm.url.ajax_get_stamp_daily_tab2, {
                  params: {
                    follow_stamp_main_id: vm.header.follow_stamp_main_id,
                    stamp_code: vm.tab2Input.stamp_code
                  }
                }).then(function (res) {
                  vm.summaryDataTab2 = res.data.data.stampDaily;
                })["catch"](function (err) {
                  var data = err.response.data;
                  swal({
                    title: 'มีข้อผิดพลาด',
                    text: '<span style="font-size: 15px; text-align: left;">' + data.message + '</span>',
                    type: "warning",
                    html: true
                  });
                }).then(function () {
                  vm.loading.stampDailyTab2Process = false;
                });

              case 19:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    updateIssueStamp: function updateIssueStamp() {
      var vm = this;

      if (vm.valid_action) {
        swal({
          title: 'บันทึกหรือยกเลิกการเปลี่ยนแปลงข้อมูล',
          text: '<span style="font-size: 16px; text-align: left;"> กรุณาทำการบันทึกหรือยกเลิกการเปลี่ยนแปลงให้เรียบร้อย </span>',
          type: "warning",
          html: true
        });
        return;
      }

      var urlUpdate = '/planning/ajax/stamp-follow/update_issue/' + vm.header.follow_stamp_main_id;
      var swalConfirm = swal({
        html: true,
        title: 'อัพเดทการตัดใช้แสตมป์รายวัน ?',
        text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการอัพเดทการตัดใช้แสตมป์รายวัน ? </span></h2>',
        showCancelButton: true,
        confirmButtonText: vm.btnTrans.ok.text,
        cancelButtonText: vm.btnTrans.cancel.text,
        confirmButtonClass: vm.btnTrans.ok["class"] + ' btn-lg tw-w-25',
        cancelButtonClass: vm.btnTrans.cancel["class"] + ' btn-lg tw-w-25',
        closeOnConfirm: false,
        closeOnCancel: true,
        showLoaderOnConfirm: true
      }, /*#__PURE__*/function () {
        var _ref = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3(isConfirm) {
          return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
            while (1) {
              switch (_context3.prev = _context3.next) {
                case 0:
                  if (!isConfirm) {
                    _context3.next = 3;
                    break;
                  }

                  _context3.next = 3;
                  return axios.get(urlUpdate).then(function (res) {
                    if (res.data.data.status == 'S') {
                      swal({
                        title: 'อัพเดทการตัดใช้แสตมป์รายวัน',
                        text: '<span style="font-size: 16px; text-align: left;">' + res.data.data.msg + '</span>',
                        type: "success",
                        html: true
                      });

                      if (vm.tab1Input.stamp_code) {
                        vm.valid_action = false;
                        vm.getStampDailyTab1();
                      }
                    } else {
                      swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 15px; text-align: left;">' + res.data.data.msg + '</span>',
                        type: "warning",
                        html: true
                      });
                    }
                  })["catch"](function (err) {
                    swal({
                      title: 'มีข้อผิดพลาด',
                      text: '<span style="font-size: 15px; text-align: left;">' + err.response + '</span>',
                      type: "warning",
                      html: true
                    });
                  });

                case 3:
                case "end":
                  return _context3.stop();
              }
            }
          }, _callee3);
        }));

        return function (_x) {
          return _ref.apply(this, arguments);
        };
      }());
    },
    refreshStampTap1: function refreshStampTap1() {
      var vm = this;

      if (vm.valid_action) {
        swal({
          title: 'บันทึกหรือยกเลิกการเปลี่ยนแปลงข้อมูล',
          text: '<span style="font-size: 16px; text-align: left;"> กรุณาทำการบันทึกหรือยกเลิกการเปลี่ยนแปลงให้เรียบร้อย </span>',
          type: "warning",
          html: true
        });
        return;
      }

      var urlRefresh = vm.url.ajax_refresh_stamp_tab1;
      var swalConfirm = swal({
        html: true,
        title: 'อัพเดทประมาณการใช้แสตมป์รายวัน ?',
        text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการอัพเดทประมาณการใช้แสตมป์รายวัน ? </span></h2>',
        showCancelButton: true,
        confirmButtonText: vm.btnTrans.ok.text,
        cancelButtonText: vm.btnTrans.cancel.text,
        confirmButtonClass: vm.btnTrans.ok["class"] + ' btn-lg tw-w-25',
        cancelButtonClass: vm.btnTrans.cancel["class"] + ' btn-lg tw-w-25',
        closeOnConfirm: false,
        closeOnCancel: true,
        showLoaderOnConfirm: true
      }, /*#__PURE__*/function () {
        var _ref2 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4(isConfirm) {
          return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
            while (1) {
              switch (_context4.prev = _context4.next) {
                case 0:
                  if (!isConfirm) {
                    _context4.next = 3;
                    break;
                  }

                  _context4.next = 3;
                  return axios.get(urlRefresh).then(function (res) {
                    if (res.data.data.status == 'S') {
                      swal({
                        title: 'อัพเดทประมาณการใช้แสตมป์รายวัน',
                        text: '<span style="font-size: 16px; text-align: left;">' + res.data.data.msg + '</span>',
                        type: "success",
                        html: true
                      });

                      if (vm.tab1Input.stamp_code) {
                        vm.valid_action = false;
                        vm.getStampDailyTab1();
                      }
                    } else {
                      swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 15px; text-align: left;">' + res.data.data.msg + '</span>',
                        type: "warning",
                        html: true
                      });
                    }
                  })["catch"](function (err) {
                    swal({
                      title: 'มีข้อผิดพลาด',
                      text: '<span style="font-size: 15px; text-align: left;">' + err.response + '</span>',
                      type: "warning",
                      html: true
                    });
                  });

                case 3:
                case "end":
                  return _context4.stop();
              }
            }
          }, _callee4);
        }));

        return function (_x2) {
          return _ref2.apply(this, arguments);
        };
      }());
    },
    refreshStampTap2: function refreshStampTap2() {
      var vm = this;

      if (vm.valid_action) {
        swal({
          title: 'บันทึกหรือยกเลิกการเปลี่ยนแปลงข้อมูล',
          text: '<span style="font-size: 16px; text-align: left;"> กรุณาทำการบันทึกหรือยกเลิกการเปลี่ยนแปลงให้เรียบร้อย </span>',
          type: "warning",
          html: true
        });
        return;
      }

      var urlRefresh = vm.url.ajax_refresh_stamp_onhand_tab2;
      var swalConfirm = swal({
        html: true,
        title: 'อัพเดทคงคลังแสตมป์รายวัน ?',
        text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการอัพเดทคงคลังแสตมป์รายวัน ? </span></h2>',
        showCancelButton: true,
        confirmButtonText: vm.btnTrans.ok.text,
        cancelButtonText: vm.btnTrans.cancel.text,
        confirmButtonClass: vm.btnTrans.ok["class"] + ' btn-lg tw-w-25',
        cancelButtonClass: vm.btnTrans.cancel["class"] + ' btn-lg tw-w-25',
        closeOnConfirm: false,
        closeOnCancel: true,
        showLoaderOnConfirm: true
      }, /*#__PURE__*/function () {
        var _ref3 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5(isConfirm) {
          return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
            while (1) {
              switch (_context5.prev = _context5.next) {
                case 0:
                  if (!isConfirm) {
                    _context5.next = 3;
                    break;
                  }

                  _context5.next = 3;
                  return axios.get(urlRefresh).then(function (res) {
                    if (res.data.data.status == 'S') {
                      swal({
                        title: 'อัพเดทคงคลังแสตมป์รายวัน',
                        text: '<span style="font-size: 16px; text-align: left;" class="mt-2">' + res.data.data.msg + '</span>',
                        type: "success",
                        html: true
                      });

                      if (vm.tab2Input.stamp_code) {
                        vm.valid_action = false;
                        vm.getStampDailyTab2();
                      }
                    } else {
                      swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 15px; text-align: left;">' + res.data.data.msg + '</span>',
                        type: "warning",
                        html: true
                      });
                    }
                  })["catch"](function (err) {
                    swal({
                      title: 'มีข้อผิดพลาด',
                      text: '<span style="font-size: 15px; text-align: left;">' + err.response + '</span>',
                      type: "warning",
                      html: true
                    });
                  });

                case 3:
                case "end":
                  return _context5.stop();
              }
            }
          }, _callee5);
        }));

        return function (_x3) {
          return _ref3.apply(this, arguments);
        };
      }());
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
      vm.errors.stamp_code_tab1 = res.err.stamp_code;
      vm.errors.stamp_code_tab2 = res.err.stamp_code_tab2;
      vm.errors.cigarettes_code = res.err.cigarettes_code;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab1.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab1.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _ReceiveWeekly_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ReceiveWeekly.vue */ "./resources/js/components/Planning/Stamp-follow/components/ReceiveWeekly.vue");
/* harmony import */ var _ReceiveRoll_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ReceiveRoll.vue */ "./resources/js/components/Planning/Stamp-follow/components/ReceiveRoll.vue");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_3__);


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



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    ReceiveWeekly: _ReceiveWeekly_vue__WEBPACK_IMPORTED_MODULE_1__.default,
    ReceiveRoll: _ReceiveRoll_vue__WEBPACK_IMPORTED_MODULE_2__.default
  },
  props: ['header', 'stamp', 'btnTrans', 'url', 'summaryData'],
  data: function data() {
    return {
      loading: false,
      lines: this.summaryData,
      edit_flag: false,
      valid: false,
      sel_daily: '',
      lineWeeklyDailyEdit: {},
      lineRollDailyEdit: {},
      onhandQuantity: {},
      balanceQuantity: {},
      // พอใช้
      // คงคลังเย็น (ดวง-ม้วน)
      balanceOnhandWeekly: {},
      balanceOnhandRoll: {},
      balanceDays: {},
      quantity: {
        weekly_receive: 0,
        roll_receive: 0,
        total_receive: 0,
        claim_receive: 0,
        issue_receive: 0,
        lost_receive: 0,
        damaged_receive: 0,
        incompleted_receive: 0,
        total_issue_receive: 0,
        total_daily_receive: 0,
        factory_bal_onhand_qty: 0
      },
      canEdit: false
    };
  },
  mounted: function mounted() {
    this.checkCanEdit();
  },
  computed: {
    weeklyReceive: function weeklyReceive() {
      var _this = this;

      return this.lines.reduce(function (accumulator, line) {
        _this.quantity.weekly_receive = accumulator + Number(line.weekly_receive_qty);
        return accumulator + Number(line.weekly_receive_qty);
      }, 0);
    },
    rollReceive: function rollReceive() {
      var _this2 = this;

      return this.lines.reduce(function (accumulator, line) {
        _this2.quantity.roll_receive = accumulator + Number(line.receive_roll_qty);
        return accumulator + Number(line.receive_roll_qty);
      }, 0);
    },
    totalReceive: function totalReceive() {
      var _this3 = this;

      return this.lines.reduce(function (accumulator, line) {
        _this3.quantity.total_receive = accumulator + Number(line.receipt_amount);
        return accumulator + Number(line.receipt_amount);
      }, 0);
    },
    claimReceive: function claimReceive() {
      var _this4 = this;

      return this.lines.reduce(function (accumulator, line) {
        _this4.quantity.claim_receive = accumulator + Number(line.claim_receive_qty);
        return accumulator + Number(line.claim_receive_qty);
      }, 0);
    },
    issueReceive: function issueReceive() {
      var _this5 = this;

      return this.lines.reduce(function (accumulator, line) {
        _this5.quantity.issue_receive = accumulator + Number(line.issue_qty);
        return accumulator + Number(line.issue_qty);
      }, 0);
    },
    lostReceive: function lostReceive() {
      var _this6 = this;

      return this.lines.reduce(function (accumulator, line) {
        _this6.quantity.lost_receive = accumulator + Number(line.lost_qty);
        return accumulator + Number(line.lost_qty);
      }, 0);
    },
    damagedReceive: function damagedReceive() {
      var _this7 = this;

      return this.lines.reduce(function (accumulator, line) {
        _this7.quantity.damaged_receive = accumulator + Number(line.damaged_qty);
        return accumulator + Number(line.damaged_qty);
      }, 0);
    },
    incompletedReceive: function incompletedReceive() {
      var _this8 = this;

      return this.lines.reduce(function (accumulator, line) {
        _this8.quantity.incompleted_receive = accumulator + Number(line.incompleted_qty);
        return accumulator + Number(line.incompleted_qty);
      }, 0);
    },
    totalIssueReceive: function totalIssueReceive() {
      var _this9 = this;

      return this.lines.reduce(function (accumulator, line) {
        _this9.quantity.total_issue_receive = accumulator + Number(line.total_issue_qty);
        return accumulator + Number(line.total_issue_qty);
      }, 0);
    },
    totalDailyReceive: function totalDailyReceive() {
      var _this10 = this;

      return this.lines.reduce(function (accumulator, line) {
        _this10.quantity.total_daily_receive = accumulator + Number(line.total_daily_qty);
        return accumulator + Number(line.total_daily_qty);
      }, 0);
    },
    totalOnhandFactoryA13: function totalOnhandFactoryA13() {
      var _this11 = this;

      return this.lines.reduce(function (accumulator, line) {
        _this11.quantity.factory_bal_onhand_qty = accumulator + Number(line.factory_bal_onhand_qty);
        return accumulator + Number(line.factory_bal_onhand_qty);
      }, 0);
    },
    // -- Calculate when edit roll/weekly quantity
    calBalanceStampDaily: function calBalanceStampDaily() {
      var vm = this; //efficiency_product

      vm.lines.filter(function (line, index) {
        var b = 0;
        var c = 0;
        var i = 0; // mean onhand qty (value: คงคลังเช้า)
        // let bal_days = 0;

        var first_date = moment__WEBPACK_IMPORTED_MODULE_3___default()(line.follow_date).format('YYYY-MM-DD'); // calculate

        b = Number(line.onhand_qty) + Number(line.weekly_receive_qty) - Number(line.issue_qty); // b = Number(line.onhand_qty);
        // index.set(vm.balanceQuantity, line.follow_date, Number(bal_days));

        if (index == vm.lines.length - 1) {
          i = Number(line.onhand_qty) + Number(vm.lines[index].weekly_receive_qty) - Number(vm.lines[index].issue_qty) - Number(vm.lines[index].damaged_qty) - Number(vm.lines[index].lost_qty); // อัพเดตคงคลังเช้าใหม่ (คงคลังเช้า) โดยคำนวณค่าของวันปัจจุบันวันสุดท้ายของเดือน

          Vue.set(vm.onhandQuantity, line.follow_date, Number(i));
        } else if (index > 0) {
          // Check Onhand Quantity
          var onhand = vm.onhandQuantity[vm.lines[index - 1].follow_date] ? vm.onhandQuantity[vm.lines[index - 1].follow_date] : line.onhand_qty;
          i = Number(onhand) + Number(vm.lines[index - 1].weekly_receive_qty) - Number(vm.lines[index - 1].issue_qty) - Number(vm.lines[index - 1].damaged_qty) - Number(vm.lines[index - 1].lost_qty); // i = (Number(vm.lines[index-1].onhand_qty) + Number(vm.lines[index-1].weekly_receive_qty)) - Number(vm.lines[index-1].total_daily_qty);
          // อัพเดตคงคลังเช้าใหม่ (คงคลังเช้า) โดยคำนวณค่าย้อนหลังวันปัจจุบันไปหนึ่งวัน

          Vue.set(vm.onhandQuantity, line.follow_date, Number(i));
        } else {
          Vue.set(vm.onhandQuantity, line.follow_date, Number(line.onhand_qty));
        }
      });
    },
    // คงคลังเย็น
    calBalanceOnhand: function calBalanceOnhand() {
      var vm = this; //current date

      var curr_date = moment__WEBPACK_IMPORTED_MODULE_3___default()().format('YYYY-MM-DD');
      vm.lines.filter(function (line, index) {
        var follow_date = moment__WEBPACK_IMPORTED_MODULE_3___default()(line.follow_date).format('YYYY-MM-DD'); // calculate balance onhand weekly-roll

        var onhandQuantity = 0;
        var WeeklyQuantity = 0;
        var balOnhWeekly = 0;
        var balOnhroll = 0;

        if (follow_date >= curr_date) {
          // Weekly
          onhandQuantity = vm.onhandQuantity[line.follow_date] ? vm.onhandQuantity[line.follow_date] : line.onhand_qty;
          WeeklyQuantity = vm.lineWeeklyDailyEdit[line.follow_date] ? vm.lineWeeklyDailyEdit[line.follow_date] : line.weekly_receive_qty; // balOnhWeekly = (onhandQuantity + WeeklyQuantity) - line.total_daily_qty;
          // Roll

          balOnhroll = onhandQuantity / vm.stamp.stamp_per_roll;
          balOnhroll = balOnhroll ? balOnhroll : 0; // Result

          Vue.set(vm.balanceOnhandWeekly, line.follow_date, Number(onhandQuantity));
          Vue.set(vm.balanceOnhandRoll, line.follow_date, Number(balOnhroll).toFixed(2));
        } else {
          // Weekly
          balOnhWeekly = vm.quantity.factory_bal_onhand_qty + line.inventory_bal_onhand_qty; // Roll

          balOnhroll = balOnhWeekly / vm.stamp.unit_price;
          balOnhroll = balOnhroll ? balOnhroll : 0; // Result

          Vue.set(vm.balanceOnhandWeekly, line.follow_date, Number(balOnhWeekly));
          Vue.set(vm.balanceOnhandRoll, line.follow_date, Number(balOnhroll).toFixed(2));
        }
      });
    },
    calBalanceDays: function calBalanceDays() {
      var vm = this;
      var bal = 0;
      vm.lines.filter(function (line, index) {
        // calculate
        var c = 0;
        var totalDailyReceive = 1;
        Vue.set(vm.balanceDays, line.follow_date, Number(totalDailyReceive));
        var first_date = moment__WEBPACK_IMPORTED_MODULE_3___default()(line.follow_date).format('YYYY-MM-DD');

        if (index == 0) {
          bal = Number(line.onhand_qty) - Number(line.total_daily_qty);

          if (bal > 0) {
            vm.lines.filter(function (line2, index2) {
              var last_date = moment__WEBPACK_IMPORTED_MODULE_3___default()(line2.follow_date).format('YYYY-MM-DD');

              if (last_date >= first_date) {
                if (index2 + 1 < vm.lines.length) {
                  if (c == 0) {
                    c = Number(bal) - Number(vm.lines[index2 + 1].total_daily_qty);
                    totalDailyReceive = totalDailyReceive + 1;
                    Vue.set(vm.balanceDays, line.follow_date, Number(totalDailyReceive));
                  } else {
                    c = Number(c) - Number(vm.lines[index2 + 1].total_daily_qty);
                    totalDailyReceive = totalDailyReceive + 1;
                    Vue.set(vm.balanceDays, line.follow_date, Number(totalDailyReceive));
                  }
                }
              }
            });
          }
        } else {
          bal = Number(vm.onhandQuantity[line.follow_date]) - Number(line.total_daily_qty);
          vm.lines.filter(function (line2, index2) {
            var last_date = moment__WEBPACK_IMPORTED_MODULE_3___default()(line2.follow_date).format('YYYY-MM-DD');

            if (last_date >= first_date) {
              if (index2 + 1 < vm.lines.length) {
                if (c == 0) {
                  c = Number(bal) - Number(vm.lines[index2 + 1].total_daily_qty);
                  totalDailyReceive = totalDailyReceive + 1;
                  Vue.set(vm.balanceDays, line.follow_date, Number(totalDailyReceive));
                } else {
                  c = Number(c) - Number(vm.lines[index2 + 1].total_daily_qty);
                  totalDailyReceive = totalDailyReceive + 1;
                  Vue.set(vm.balanceDays, line.follow_date, Number(totalDailyReceive));
                }
              }
            }
          });
        }
      });
    }
  },
  watch: {
    'edit_flag': function edit_flag(newValue) {
      if (newValue == false) {
        this.lineWeeklyDailyEdit = {};
        this.lineRollDailyEdit = {};
      }
    },
    weeklyReceive: function weeklyReceive(newValue) {
      return newValue;
    },
    rollReceive: function rollReceive(newValue) {
      return newValue;
    },
    totalReceive: function totalReceive(newValue) {
      return newValue;
    },
    claimReceive: function claimReceive(newValue) {
      return newValue;
    },
    issueReceive: function issueReceive(newValue) {
      return newValue;
    },
    lostReceive: function lostReceive(newValue) {
      return newValue;
    },
    damagedReceive: function damagedReceive(newValue) {
      return newValue;
    },
    incompletedReceive: function incompletedReceive(newValue) {
      return newValue;
    },
    totalIssueReceive: function totalIssueReceive(newValue) {
      return newValue;
    },
    totalDailyReceive: function totalDailyReceive(newValue) {
      return newValue;
    },
    totalOnhandFactoryA13: function totalOnhandFactoryA13(newValue) {
      return newValue;
    },
    calBalanceStampDaily: function calBalanceStampDaily(newValue) {
      return newValue;
    },
    // คงคลังเย็น
    calBalanceOnhand: function calBalanceOnhand(newValue) {
      return newValue;
    },
    calBalanceDays: function calBalanceDays(newValue) {
      return newValue;
    }
  },
  methods: {
    decimal: function decimal(number) {
      return Number(number).toLocaleString(undefined, {
        minimumFractionDigits: 2
      });
    },
    formatNumber: function formatNumber(number) {
      return Number(number).toLocaleString(undefined);
    },
    selDailyDate: function selDailyDate(dailyDate) {
      this.sel_daily = dailyDate;
    },
    changeStampData: function changeStampData() {
      this.valid = this.edit_flag = !this.edit_flag;
      this.$emit("validAction", this.valid);
    },
    saveChangeInput: function saveChangeInput() {
      var _this12 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var vm, urlUpdate, swalConfirm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                vm = _this12;
                urlUpdate = vm.url.ajax_store + '/' + vm.header.follow_stamp_main_id;

                if (!(Object.keys(vm.lineWeeklyDailyEdit).length == 0 && Object.keys(vm.lineRollDailyEdit).length == 0)) {
                  _context2.next = 5;
                  break;
                }

                swal({
                  title: 'อัพเดทการติดตามการใช้แสตมป์รายวัน',
                  text: '<span style="font-size: 16px; text-align: left;"> ไม่พบข้อมูลการอัพเดทการติดตามการใช้แสตมป์รายวัน </span>',
                  type: "warning",
                  html: true
                });
                return _context2.abrupt("return");

              case 5:
                swalConfirm = swal({
                  html: true,
                  title: 'อัพเดทการติดตามการใช้แสตมป์รายวัน ?',
                  text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการอัพเดทการติดตามการใช้แสตมป์รายวัน ? </span></h2>',
                  showCancelButton: true,
                  confirmButtonText: vm.btnTrans.ok.text,
                  cancelButtonText: vm.btnTrans.cancel.text,
                  confirmButtonClass: vm.btnTrans.ok["class"] + ' btn-lg tw-w-25',
                  cancelButtonClass: vm.btnTrans.cancel["class"] + ' btn-lg tw-w-25',
                  closeOnConfirm: false,
                  closeOnCancel: true,
                  showLoaderOnConfirm: true
                }, /*#__PURE__*/function () {
                  var _ref = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee(isConfirm) {
                    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
                      while (1) {
                        switch (_context.prev = _context.next) {
                          case 0:
                            if (!isConfirm) {
                              _context.next = 5;
                              break;
                            }

                            vm.loading = true;
                            vm.valid = false;
                            _context.next = 5;
                            return axios.patch(urlUpdate, {
                              lines: vm.lines,
                              lineWeeklyDaily: vm.lineWeeklyDailyEdit,
                              lineRollDaily: vm.lineRollDailyEdit
                            }).then(function (res) {
                              if (res.data.data.status == 'S') {
                                vm.lineWeeklyDailyEdit = {};
                                vm.lineRollDailyEdit = {}; // vm.$emit("updateLines", 'S');

                                vm.$emit("updateStamp", {
                                  status: 'S',
                                  stamp_main: res.data.data.header,
                                  valid_action: vm.valid
                                });
                                swal({
                                  title: 'อัพเดทการติดตามการใช้แสตมป์รายวัน',
                                  text: '<span style="font-size: 16px; text-align: left;">' + res.data.data.msg + '</span>',
                                  type: "success",
                                  html: true
                                });
                              } else {
                                swal({
                                  title: 'มีข้อผิดพลาด',
                                  text: '<span style="font-size: 15px; text-align: left;">' + res.data.data.msg + '</span>',
                                  type: "warning",
                                  html: true
                                });
                              } // window.setTimeout(function() {
                              //     window.location.href = res.data.data.redirect_page;
                              // }, 500);


                              vm.edit_flag = false;
                            })["catch"](function (err) {
                              swal({
                                title: 'มีข้อผิดพลาด',
                                text: '<span style="font-size: 15px; text-align: left;">' + err.response + '</span>',
                                type: "warning",
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
                  }));

                  return function (_x) {
                    return _ref.apply(this, arguments);
                  };
                }());

              case 6:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    checkCanEdit: function checkCanEdit() {
      var follow_date = moment__WEBPACK_IMPORTED_MODULE_3___default()(this.lines[this.lines.length - 1].follow_date).format('YYYY-MM-DD');
      var curr_date = moment__WEBPACK_IMPORTED_MODULE_3___default()().format('YYYY-MM-DD');

      if (follow_date > curr_date) {
        this.canEdit = true;
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab2.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab2.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _ReceiveWeekly_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ReceiveWeekly.vue */ "./resources/js/components/Planning/Stamp-follow/components/ReceiveWeekly.vue");
/* harmony import */ var _ReceiveRoll_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ReceiveRoll.vue */ "./resources/js/components/Planning/Stamp-follow/components/ReceiveRoll.vue");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_3__);


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



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    ReceiveWeekly: _ReceiveWeekly_vue__WEBPACK_IMPORTED_MODULE_1__.default,
    ReceiveRoll: _ReceiveRoll_vue__WEBPACK_IMPORTED_MODULE_2__.default
  },
  props: ['header', 'stamp', 'btnTrans', 'url', 'summaryData'],
  data: function data() {
    return {
      loading: false,
      lines: this.summaryData,
      edit_flag: false,
      valid: false,
      sel_daily: '',
      lineWeeklyDailyEdit: {},
      lineRollDailyEdit: {},
      onhandQuantity: {},
      balanceQuantity: {},
      // พอใช้
      // คงคลังเย็น (ดวง-ม้วน)
      // balanceOnhandWeekly: {},
      // balanceOnhandRoll: {},
      quantity: {
        weekly_receive: 0,
        roll_receive: 0,
        total_receive: 0,
        claim_receive: 0,
        issue_receive: 0,
        lost_receive: 0,
        damaged_receive: 0,
        incompleted_receive: 0,
        total_issue_receive: 0,
        total_daily_receive: 0,
        factory_bal_onhand_qty: 0
      },
      canEdit: false
    };
  },
  mounted: function mounted() {// this.checkCanEdit();
  },
  computed: {
    weeklyReceive: function weeklyReceive() {
      var _this = this;

      return this.lines.reduce(function (accumulator, line) {
        _this.quantity.weekly_receive = accumulator + parseFloat(line.weekly_receive_qty);
        return accumulator + Number(line.weekly_receive_qty);
      }, 0);
    },
    rollReceive: function rollReceive() {
      var _this2 = this;

      return this.lines.reduce(function (accumulator, line) {
        _this2.quantity.roll_receive = accumulator + Number(line.receive_roll_qty);
        return accumulator + Number(line.receive_roll_qty);
      }, 0);
    },
    totalReceive: function totalReceive() {
      var _this3 = this;

      return this.lines.reduce(function (accumulator, line) {
        _this3.quantity.total_receive = accumulator + Number(line.receipt_amount);
        return accumulator + Number(line.receipt_amount);
      }, 0);
    },
    claimReceive: function claimReceive() {
      var _this4 = this;

      return this.lines.reduce(function (accumulator, line) {
        _this4.quantity.claim_receive = accumulator + Number(line.claim_receive_qty);
        return accumulator + Number(line.claim_receive_qty);
      }, 0);
    },
    issueReceive: function issueReceive() {
      var _this5 = this;

      return this.lines.reduce(function (accumulator, line) {
        _this5.quantity.issue_receive = accumulator + Number(line.issue_qty);
        return accumulator + Number(line.issue_qty);
      }, 0);
    },
    lostReceive: function lostReceive() {
      var _this6 = this;

      return this.lines.reduce(function (accumulator, line) {
        _this6.quantity.lost_receive = accumulator + Number(line.lost_qty);
        return accumulator + Number(line.lost_qty);
      }, 0);
    },
    damagedReceive: function damagedReceive() {
      var _this7 = this;

      return this.lines.reduce(function (accumulator, line) {
        _this7.quantity.damaged_receive = accumulator + Number(line.damaged_qty);
        return accumulator + Number(line.damaged_qty);
      }, 0);
    },
    incompletedReceive: function incompletedReceive() {
      var _this8 = this;

      return this.lines.reduce(function (accumulator, line) {
        _this8.quantity.incompleted_receive = accumulator + Number(line.incompleted_qty);
        return accumulator + Number(line.incompleted_qty);
      }, 0);
    },
    totalIssueReceive: function totalIssueReceive() {
      var _this9 = this;

      return this.lines.reduce(function (accumulator, line) {
        _this9.quantity.total_issue_receive = accumulator + Number(line.total_issue_qty);
        return accumulator + Number(line.total_issue_qty);
      }, 0);
    },
    totalDailyReceive: function totalDailyReceive() {
      var _this10 = this;

      return this.lines.reduce(function (accumulator, line) {
        _this10.quantity.total_daily_receive = accumulator + Number(line.total_daily_qty);
        return accumulator + Number(line.total_daily_qty);
      }, 0);
    },
    totalOnhandFactoryA13: function totalOnhandFactoryA13() {
      var _this11 = this;

      return this.lines.reduce(function (accumulator, line) {
        _this11.quantity.factory_bal_onhand_qty = accumulator + Number(line.factory_bal_onhand_qty);
        return accumulator + Number(line.factory_bal_onhand_qty);
      }, 0);
    } // -- Calculate when edit roll/weekly quantity
    // calBalanceStampDaily() {
    //     var vm = this;
    //     //efficiency_product
    //     vm.lines.filter(function(line, index) {
    //         let b = 0;
    //         let c = 0;
    //         let i = 0; // mean onhand qty (value: คงคลังเช้า)
    //         let bal_days = 0;
    //         let first_date = moment(line.follow_date).format('YYYY-MM-DD');
    //         // calculate
    //         b = (Number(line.onhand_qty) + Number(line.weekly_receive_qty)) - Number(line.total_daily_qty);
    //         Vue.set(vm.balanceQuantity, line.follow_date, Number(bal_days));
    //         if (index > 0) {
    //             // Check Onhand Quantity
    //             var onhand = vm.onhandQuantity[vm.lines[index-1].follow_date]? vm.onhandQuantity[vm.lines[index-1].follow_date]: line.onhand_qty;
    //             i = (Number(onhand) + Number(vm.lines[index-1].weekly_receive_qty)) - Number(vm.lines[index-1].total_daily_qty);
    //             // i = (Number(vm.lines[index-1].onhand_qty) + Number(vm.lines[index-1].weekly_receive_qty)) - Number(vm.lines[index-1].total_daily_qty);
    //             // อัพเดตคงคลังเช้าใหม่ (คงคลังเช้า) โดยคำนวณค่าย้อนหลังวันปัจจุบันไปหนึ่งวัน
    //             Vue.set(vm.onhandQuantity, line.follow_date, Number(i));
    //         }
    //         if (b >= 0) {
    //             bal_days = 1;
    //             Vue.set(vm.balanceQuantity, line.follow_date, Number(bal_days));
    //             vm.lines.filter(function(line2, index2) {
    //                 let last_date = moment(line2.follow_date).format('YYYY-MM-DD');
    //                 if (last_date >= first_date) {
    //                     if (index2+1 < vm.lines.length) {
    //                         if (c == 0) {
    //                             c = Number(b) - Number(vm.lines[index2+1].total_daily_qty);
    //                         }else{
    //                             c = Number(c) - Number(vm.lines[index2+1].total_daily_qty);
    //                         }
    //                         // check count for balance day
    //                         if (Number(c) >= 0) {
    //                             bal_days = bal_days+1;
    //                             Vue.set(vm.balanceQuantity, line.follow_date, Number(bal_days));
    //                         }
    //                     }
    //                 }
    //             });
    //         }
    //     });
    // },
    // คงคลังเย็น
    // calBalanceOnhand() {
    //     var vm = this;
    //     //current date
    //     var curr_date = moment().format('YYYY-MM-DD');
    //     vm.lines.filter(function(line, index) {
    //         let follow_date =  moment(line.follow_date).format('YYYY-MM-DD');
    //         // calculate balance onhand weekly-roll
    //         var onhandQuantity = 0;
    //         var WeeklyQuantity = 0;
    //         var balOnhWeekly = 0;
    //         var balOnhroll = 0;
    //         if (follow_date >= curr_date) {
    //             // Weekly
    //             onhandQuantity = vm.onhandQuantity[line.follow_date]? vm.onhandQuantity[line.follow_date]: line.onhand_qty;
    //             WeeklyQuantity = vm.lineWeeklyDailyEdit[line.follow_date]? vm.lineWeeklyDailyEdit[line.follow_date]: line.weekly_receive_qty;
    //             // balOnhWeekly = (onhandQuantity + WeeklyQuantity) - line.total_daily_qty;
    //             // Roll
    //             balOnhroll = onhandQuantity / vm.stamp.stamp_per_roll;
    //             balOnhroll = balOnhroll? balOnhroll: 0;
    //             // Result
    //             Vue.set(vm.balanceOnhandWeekly, line.follow_date, Number(onhandQuantity));
    //             Vue.set(vm.balanceOnhandRoll, line.follow_date, Number(balOnhroll).toFixed(2));
    //         }else{
    //             // Weekly
    //             balOnhWeekly = vm.quantity.factory_bal_onhand_qty + line.inventory_bal_onhand_qty;
    //             // Roll
    //             balOnhroll = balOnhWeekly / vm.stamp.unit_price;
    //             balOnhroll = balOnhroll? balOnhroll: 0;
    //             // Result
    //             Vue.set(vm.balanceOnhandWeekly, line.follow_date, Number(balOnhWeekly));
    //             Vue.set(vm.balanceOnhandRoll, line.follow_date, Number(balOnhroll).toFixed(2));
    //         }
    //     });
    // },

  },
  watch: {
    'edit_flag': function edit_flag(newValue) {
      if (newValue == false) {
        this.lineWeeklyDailyEdit = {};
        this.lineRollDailyEdit = {};
      }
    },
    weeklyReceive: function weeklyReceive(newValue) {
      return newValue;
    },
    rollReceive: function rollReceive(newValue) {
      return newValue;
    },
    totalReceive: function totalReceive(newValue) {
      return newValue;
    },
    claimReceive: function claimReceive(newValue) {
      return newValue;
    },
    issueReceive: function issueReceive(newValue) {
      return newValue;
    },
    lostReceive: function lostReceive(newValue) {
      return newValue;
    },
    damagedReceive: function damagedReceive(newValue) {
      return newValue;
    },
    incompletedReceive: function incompletedReceive(newValue) {
      return newValue;
    },
    totalIssueReceive: function totalIssueReceive(newValue) {
      return newValue;
    },
    totalDailyReceive: function totalDailyReceive(newValue) {
      return newValue;
    },
    totalOnhandFactoryA13: function totalOnhandFactoryA13(newValue) {
      return newValue;
    },
    calBalanceStampDaily: function calBalanceStampDaily(newValue) {
      return newValue;
    },
    // คงคลังเย็น
    calBalanceOnhand: function calBalanceOnhand(newValue) {
      return newValue;
    }
  },
  methods: {
    decimal: function decimal(number) {
      return Number(number).toLocaleString(undefined, {
        minimumFractionDigits: 2
      });
    },
    formatNumber: function formatNumber(number) {
      return Number(number).toLocaleString(undefined);
    },
    selDailyDate: function selDailyDate(dailyDate) {
      this.sel_daily = dailyDate;
    },
    changeStampData: function changeStampData() {
      this.valid = this.edit_flag = !this.edit_flag;
      this.$emit("validAction", this.valid);
    },
    saveChangeInput: function saveChangeInput() {
      var _this12 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var vm, urlUpdate, swalConfirm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                vm = _this12;
                urlUpdate = vm.url.ajax_store + '/' + vm.header.follow_stamp_main_id;

                if (!(Object.keys(vm.lineWeeklyDailyEdit).length == 0 && Object.keys(vm.lineRollDailyEdit).length == 0)) {
                  _context2.next = 5;
                  break;
                }

                swal({
                  title: 'อัพเดทการติดตามการใช้แสตมป์รายวัน',
                  text: '<span style="font-size: 16px; text-align: left;"> ไม่พบข้อมูลการอัพเดทการติดตามการใช้แสตมป์รายวัน </span>',
                  type: "warning",
                  html: true
                });
                return _context2.abrupt("return");

              case 5:
                swalConfirm = swal({
                  html: true,
                  title: 'อัพเดทการติดตามการใช้แสตมป์รายวัน ?',
                  text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการอัพเดทการติดตามการใช้แสตมป์รายวัน ? </span></h2>',
                  showCancelButton: true,
                  confirmButtonText: vm.btnTrans.ok.text,
                  cancelButtonText: vm.btnTrans.cancel.text,
                  confirmButtonClass: vm.btnTrans.ok["class"] + ' btn-lg tw-w-25',
                  cancelButtonClass: vm.btnTrans.cancel["class"] + ' btn-lg tw-w-25',
                  closeOnConfirm: false,
                  closeOnCancel: true,
                  showLoaderOnConfirm: true
                }, /*#__PURE__*/function () {
                  var _ref = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee(isConfirm) {
                    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
                      while (1) {
                        switch (_context.prev = _context.next) {
                          case 0:
                            if (!isConfirm) {
                              _context.next = 5;
                              break;
                            }

                            vm.loading = true;
                            vm.valid = false;
                            _context.next = 5;
                            return axios.patch(urlUpdate, {
                              lines: vm.lines,
                              lineWeeklyDaily: vm.lineWeeklyDailyEdit,
                              lineRollDaily: vm.lineRollDailyEdit
                            }).then(function (res) {
                              if (res.data.data.status == 'S') {
                                vm.lineWeeklyDailyEdit = {};
                                vm.lineRollDailyEdit = {}; // vm.$emit("updateLines", 'S');

                                vm.$emit("updateStamp", {
                                  status: 'S',
                                  stamp_main: res.data.data.header,
                                  valid_action: vm.valid
                                });
                                swal({
                                  title: 'อัพเดทการติดตามการใช้แสตมป์รายวัน',
                                  text: '<span style="font-size: 16px; text-align: left;">' + res.data.data.msg + '</span>',
                                  type: "success",
                                  html: true
                                });
                              } else {
                                swal({
                                  title: 'มีข้อผิดพลาด',
                                  text: '<span style="font-size: 15px; text-align: left;">' + res.data.data.msg + '</span>',
                                  type: "warning",
                                  html: true
                                });
                              } // window.setTimeout(function() {
                              //     window.location.href = res.data.data.redirect_page;
                              // }, 500);


                              vm.edit_flag = false;
                            })["catch"](function (err) {
                              swal({
                                title: 'มีข้อผิดพลาด',
                                text: '<span style="font-size: 15px; text-align: left;">' + err.response + '</span>',
                                type: "warning",
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
                  }));

                  return function (_x) {
                    return _ref.apply(this, arguments);
                  };
                }());

              case 6:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    checkCanEdit: function checkCanEdit() {
      var follow_date = moment__WEBPACK_IMPORTED_MODULE_3___default()(this.lines[this.lines.length - 1].follow_date).format('YYYY-MM-DD');
      var curr_date = moment__WEBPACK_IMPORTED_MODULE_3___default()().format('YYYY-MM-DD');

      if (follow_date > curr_date) {
        this.canEdit = true;
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab3.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab3.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var _SubmitPRTransaction_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./SubmitPRTransaction.vue */ "./resources/js/components/Planning/Stamp-follow/components/SubmitPRTransaction.vue");


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


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    SubmitPrTransaction: _SubmitPRTransaction_vue__WEBPACK_IMPORTED_MODULE_2__.default
  },
  props: ['header', 'interfaceTemps', 'poLists', 'btnTrans', 'url'],
  data: function data() {
    return {
      loading: false,
      valid: false,
      lines: this.interfaceTemps,
      poMaps: this.poLists
    };
  },
  mounted: function mounted() {//
  },
  watch: {
    'interfaceTemps': function interfaceTemps(newValue) {
      this.lines = newValue;
    },
    'poLists': function poLists(newValue) {
      this.poMaps = newValue;
    }
  },
  methods: {
    // Get PR INTERFACE
    getStampDailyTab3: function getStampDailyTab3() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                vm = _this;
                vm.summaryDataTab3 = [];
                vm.loading = true;
                _context.next = 5;
                return axios.get(vm.url.ajax_get_stamp_daily_tab3, {
                  params: {
                    follow_stamp_main_id: vm.header.follow_stamp_main_id
                  }
                }).then(function (res) {
                  vm.lines = res.data.interfaceTemps;
                  vm.poMaps = res.data.poLists;
                })["catch"](function (err) {
                  var data = err.response.data;
                  swal({
                    title: 'มีข้อผิดพลาด',
                    text: '<span style="font-size: 15px; text-align: left;">' + data.message + '</span>',
                    type: "warning",
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
    },
    updateInterfacePR: function updateInterfacePR(res) {
      this.lines = res.interfaceTemps;
      this.poMaps = res.poLists;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/SubmitPRTransaction.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/SubmitPRTransaction.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************************************/
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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['index', 'header', 'line', 'poLists', 'btnTrans', 'url'],
  data: function data() {
    return {
      loading: false,
      valid: false,
      validReport: false,
      cancelled_reason: '',
      errors: {
        cancelled_reason: false
      }
    };
  },
  mounted: function mounted() {
    this.checkPRPOTransaction();
  },
  watch: {
    errors: {
      handler: function handler(val) {
        val.cancelled_reason ? this.setError('cancelled_reason') : this.resetError('cancelled_reason');
      },
      deep: true
    },
    'line': function line(newValue) {
      this.checkPRPOTransaction();
    }
  },
  methods: {
    cancelPRModal: function cancelPRModal() {
      this.cancelled_reason = '';
      $('#modal_cancel_pr' + this.index).modal('show');
    },
    checkPRPOTransaction: function checkPRPOTransaction() {
      var vm = this;
      vm.valid = false;
      vm.validReport = false;

      if (vm.line.pr_number == '' || vm.line.pr_number == null) {
        vm.valid = true;
        vm.validReport = true;
        console.log('2222-----' + vm.validReport);
      } else if (vm.line.authorization_status == 'Cancelled') {
        vm.valid = true;
        vm.validReport = true;
        console.log(vm.validReport);
      }

      vm.poLists.filter(function (po, index) {
        if (po.po_number != null) {
          if (po.pr_number == vm.line.pr_number) {
            if (po.po_number != '' || po.po_number != null || vm.line.pr_number == null) {
              vm.valid = true;
              console.log(vm.validReport);
            }
          }
        }
      });
    },
    cancelInterfacePR: function cancelInterfacePR() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var vm, form, valid, msg, swalConfirm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                vm = _this;
                form = $("#cancel-pr-form" + vm.index);
                valid = true;
                msg = '';
                vm.errors.cancelled_reason = false;
                $("div[id=el_explode_cancelled_reason" + vm.index + "]").html(""); // Validate input

                if (vm.cancelled_reason == '') {
                  vm.errors.cancelled_reason = true;
                  valid = false;
                  msg = "กรุณาระบุเหตุผลขอการยกเลิก";
                  $("div[id=el_explode_cancelled_reason" + vm.index + "]").html(msg);
                }

                if (valid) {
                  _context2.next = 9;
                  break;
                }

                return _context2.abrupt("return");

              case 9:
                // isPass -----------------------------------------------------------
                swalConfirm = swal({
                  html: true,
                  title: '<span style="font-size: 22px"><strong> ยกเลิกรายการ PR </strong></span>',
                  text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 17px"> คุณต้องการยกเลิกรายการ PR นี้หรือไม่ ? </span></h2>',
                  showCancelButton: true,
                  confirmButtonText: vm.btnTrans.ok.text,
                  cancelButtonText: vm.btnTrans.cancel.text,
                  confirmButtonClass: vm.btnTrans.ok["class"] + ' btn-lg tw-w-25',
                  cancelButtonClass: vm.btnTrans.cancel["class"] + ' btn-lg tw-w-25',
                  closeOnConfirm: false,
                  closeOnCancel: true,
                  showLoaderOnConfirm: true
                }, /*#__PURE__*/function () {
                  var _ref = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee(isConfirm) {
                    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
                      while (1) {
                        switch (_context.prev = _context.next) {
                          case 0:
                            if (!isConfirm) {
                              _context.next = 4;
                              break;
                            }

                            vm.loading = true;
                            _context.next = 4;
                            return axios.post(vm.url.ajax_cancel_interface_pr, {
                              pr_number: vm.line.pr_number,
                              cancelled_reason: vm.cancelled_reason
                            }).then(function (res) {
                              if (res.data.status == 'S') {
                                vm.$emit("updateInterfacePR", {
                                  interfaceTemps: res.data.interfaceTemps,
                                  poLists: res.data.poLists
                                }); // vm.valid = true;
                                // vm.validReport = true;

                                swal({
                                  title: 'ยกเลิกรายการ PR',
                                  text: '<span style="font-size: 16px; text-align: left;">' + res.data.msg + '</span>',
                                  type: "success",
                                  html: true
                                });
                              } else {
                                swal({
                                  title: 'มีข้อผิดพลาด',
                                  text: '<span style="font-size: 15px; text-align: left;">' + res.data.msg + '</span>',
                                  type: "warning",
                                  html: true
                                });
                              }
                            })["catch"](function (err) {
                              swal({
                                title: 'มีข้อผิดพลาด',
                                text: '<span style="font-size: 15px; text-align: left;">' + err.response + '</span>',
                                type: "warning",
                                html: true
                              });
                            }).then(function () {
                              $('#modal_cancel_pr' + vm.index).modal('hide');
                              vm.loading = false;
                            });

                          case 4:
                          case "end":
                            return _context.stop();
                        }
                      }
                    }, _callee);
                  }));

                  return function (_x) {
                    return _ref.apply(this, arguments);
                  };
                }());

              case 10:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
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
    }
  }
});

/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/ModalCreate.vue":
/*!***********************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/ModalCreate.vue ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ModalCreate_vue_vue_type_template_id_196bbde8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ModalCreate.vue?vue&type=template&id=196bbde8& */ "./resources/js/components/Planning/Stamp-follow/ModalCreate.vue?vue&type=template&id=196bbde8&");
/* harmony import */ var _ModalCreate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalCreate.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Stamp-follow/ModalCreate.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _ModalCreate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ModalCreate_vue_vue_type_template_id_196bbde8___WEBPACK_IMPORTED_MODULE_0__.render,
  _ModalCreate_vue_vue_type_template_id_196bbde8___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Stamp-follow/ModalCreate.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/ModalInterfacePR.vue":
/*!****************************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/ModalInterfacePR.vue ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ModalInterfacePR_vue_vue_type_template_id_676aecca___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ModalInterfacePR.vue?vue&type=template&id=676aecca& */ "./resources/js/components/Planning/Stamp-follow/ModalInterfacePR.vue?vue&type=template&id=676aecca&");
/* harmony import */ var _ModalInterfacePR_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalInterfacePR.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Stamp-follow/ModalInterfacePR.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _ModalInterfacePR_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ModalInterfacePR_vue_vue_type_template_id_676aecca___WEBPACK_IMPORTED_MODULE_0__.render,
  _ModalInterfacePR_vue_vue_type_template_id_676aecca___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Stamp-follow/ModalInterfacePR.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/ModalSearch.vue":
/*!***********************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/ModalSearch.vue ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ModalSearch_vue_vue_type_template_id_7754afb8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ModalSearch.vue?vue&type=template&id=7754afb8& */ "./resources/js/components/Planning/Stamp-follow/ModalSearch.vue?vue&type=template&id=7754afb8&");
/* harmony import */ var _ModalSearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalSearch.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Stamp-follow/ModalSearch.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _ModalSearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ModalSearch_vue_vue_type_template_id_7754afb8___WEBPACK_IMPORTED_MODULE_0__.render,
  _ModalSearch_vue_vue_type_template_id_7754afb8___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Stamp-follow/ModalSearch.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/ShowComponent.vue":
/*!*************************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/ShowComponent.vue ***!
  \*************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ShowComponent_vue_vue_type_template_id_176edb43___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ShowComponent.vue?vue&type=template&id=176edb43& */ "./resources/js/components/Planning/Stamp-follow/ShowComponent.vue?vue&type=template&id=176edb43&");
/* harmony import */ var _ShowComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ShowComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Stamp-follow/ShowComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _ShowComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ShowComponent_vue_vue_type_template_id_176edb43___WEBPACK_IMPORTED_MODULE_0__.render,
  _ShowComponent_vue_vue_type_template_id_176edb43___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Stamp-follow/ShowComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/components/HeaderDetail.vue":
/*!***********************************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/components/HeaderDetail.vue ***!
  \***********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _HeaderDetail_vue_vue_type_template_id_1d8dd75a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./HeaderDetail.vue?vue&type=template&id=1d8dd75a& */ "./resources/js/components/Planning/Stamp-follow/components/HeaderDetail.vue?vue&type=template&id=1d8dd75a&");
/* harmony import */ var _HeaderDetail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./HeaderDetail.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Stamp-follow/components/HeaderDetail.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _HeaderDetail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _HeaderDetail_vue_vue_type_template_id_1d8dd75a___WEBPACK_IMPORTED_MODULE_0__.render,
  _HeaderDetail_vue_vue_type_template_id_1d8dd75a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Stamp-follow/components/HeaderDetail.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/components/ReceiveRoll.vue":
/*!**********************************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/components/ReceiveRoll.vue ***!
  \**********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ReceiveRoll_vue_vue_type_template_id_7204a594___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ReceiveRoll.vue?vue&type=template&id=7204a594& */ "./resources/js/components/Planning/Stamp-follow/components/ReceiveRoll.vue?vue&type=template&id=7204a594&");
/* harmony import */ var _ReceiveRoll_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ReceiveRoll.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Stamp-follow/components/ReceiveRoll.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _ReceiveRoll_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ReceiveRoll_vue_vue_type_template_id_7204a594___WEBPACK_IMPORTED_MODULE_0__.render,
  _ReceiveRoll_vue_vue_type_template_id_7204a594___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Stamp-follow/components/ReceiveRoll.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/components/ReceiveWeekly.vue":
/*!************************************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/components/ReceiveWeekly.vue ***!
  \************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ReceiveWeekly_vue_vue_type_template_id_5bfcbfd8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ReceiveWeekly.vue?vue&type=template&id=5bfcbfd8& */ "./resources/js/components/Planning/Stamp-follow/components/ReceiveWeekly.vue?vue&type=template&id=5bfcbfd8&");
/* harmony import */ var _ReceiveWeekly_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ReceiveWeekly.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Stamp-follow/components/ReceiveWeekly.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _ReceiveWeekly_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ReceiveWeekly_vue_vue_type_template_id_5bfcbfd8___WEBPACK_IMPORTED_MODULE_0__.render,
  _ReceiveWeekly_vue_vue_type_template_id_5bfcbfd8___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Stamp-follow/components/ReceiveWeekly.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/components/StampDaily.vue":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/components/StampDaily.vue ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _StampDaily_vue_vue_type_template_id_8037019c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./StampDaily.vue?vue&type=template&id=8037019c& */ "./resources/js/components/Planning/Stamp-follow/components/StampDaily.vue?vue&type=template&id=8037019c&");
/* harmony import */ var _StampDaily_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./StampDaily.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Stamp-follow/components/StampDaily.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _StampDaily_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _StampDaily_vue_vue_type_template_id_8037019c___WEBPACK_IMPORTED_MODULE_0__.render,
  _StampDaily_vue_vue_type_template_id_8037019c___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Stamp-follow/components/StampDaily.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab1.vue":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab1.vue ***!
  \******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _StampDailyTableTab1_vue_vue_type_template_id_91c26b70___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./StampDailyTableTab1.vue?vue&type=template&id=91c26b70& */ "./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab1.vue?vue&type=template&id=91c26b70&");
/* harmony import */ var _StampDailyTableTab1_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./StampDailyTableTab1.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab1.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _StampDailyTableTab1_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _StampDailyTableTab1_vue_vue_type_template_id_91c26b70___WEBPACK_IMPORTED_MODULE_0__.render,
  _StampDailyTableTab1_vue_vue_type_template_id_91c26b70___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab1.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab2.vue":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab2.vue ***!
  \******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _StampDailyTableTab2_vue_vue_type_template_id_91a63c6e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./StampDailyTableTab2.vue?vue&type=template&id=91a63c6e& */ "./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab2.vue?vue&type=template&id=91a63c6e&");
/* harmony import */ var _StampDailyTableTab2_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./StampDailyTableTab2.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab2.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _StampDailyTableTab2_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _StampDailyTableTab2_vue_vue_type_template_id_91a63c6e___WEBPACK_IMPORTED_MODULE_0__.render,
  _StampDailyTableTab2_vue_vue_type_template_id_91a63c6e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab2.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab3.vue":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab3.vue ***!
  \******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _StampDailyTableTab3_vue_vue_type_template_id_918a0d6c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./StampDailyTableTab3.vue?vue&type=template&id=918a0d6c& */ "./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab3.vue?vue&type=template&id=918a0d6c&");
/* harmony import */ var _StampDailyTableTab3_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./StampDailyTableTab3.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab3.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _StampDailyTableTab3_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _StampDailyTableTab3_vue_vue_type_template_id_918a0d6c___WEBPACK_IMPORTED_MODULE_0__.render,
  _StampDailyTableTab3_vue_vue_type_template_id_918a0d6c___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab3.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/components/SubmitPRTransaction.vue":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/components/SubmitPRTransaction.vue ***!
  \******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _SubmitPRTransaction_vue_vue_type_template_id_74100810___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SubmitPRTransaction.vue?vue&type=template&id=74100810& */ "./resources/js/components/Planning/Stamp-follow/components/SubmitPRTransaction.vue?vue&type=template&id=74100810&");
/* harmony import */ var _SubmitPRTransaction_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SubmitPRTransaction.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Stamp-follow/components/SubmitPRTransaction.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _SubmitPRTransaction_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _SubmitPRTransaction_vue_vue_type_template_id_74100810___WEBPACK_IMPORTED_MODULE_0__.render,
  _SubmitPRTransaction_vue_vue_type_template_id_74100810___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Stamp-follow/components/SubmitPRTransaction.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/ModalCreate.vue?vue&type=script&lang=js&":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/ModalCreate.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalCreate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalCreate.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/ModalCreate.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalCreate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/ModalInterfacePR.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/ModalInterfacePR.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalInterfacePR_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalInterfacePR.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/ModalInterfacePR.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalInterfacePR_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/ModalSearch.vue?vue&type=script&lang=js&":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/ModalSearch.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearch.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/ModalSearch.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/ShowComponent.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/ShowComponent.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ShowComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/ShowComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/components/HeaderDetail.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/components/HeaderDetail.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_HeaderDetail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./HeaderDetail.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/HeaderDetail.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_HeaderDetail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/components/ReceiveRoll.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/components/ReceiveRoll.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ReceiveRoll_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ReceiveRoll.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/ReceiveRoll.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ReceiveRoll_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/components/ReceiveWeekly.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/components/ReceiveWeekly.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ReceiveWeekly_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ReceiveWeekly.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/ReceiveWeekly.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ReceiveWeekly_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/components/StampDaily.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/components/StampDaily.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_StampDaily_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./StampDaily.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/StampDaily.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_StampDaily_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab1.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab1.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_StampDailyTableTab1_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./StampDailyTableTab1.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab1.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_StampDailyTableTab1_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab2.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab2.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_StampDailyTableTab2_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./StampDailyTableTab2.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab2.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_StampDailyTableTab2_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab3.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab3.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_StampDailyTableTab3_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./StampDailyTableTab3.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab3.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_StampDailyTableTab3_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/components/SubmitPRTransaction.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/components/SubmitPRTransaction.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SubmitPRTransaction_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SubmitPRTransaction.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/SubmitPRTransaction.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SubmitPRTransaction_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/ModalCreate.vue?vue&type=template&id=196bbde8&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/ModalCreate.vue?vue&type=template&id=196bbde8& ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalCreate_vue_vue_type_template_id_196bbde8___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalCreate_vue_vue_type_template_id_196bbde8___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalCreate_vue_vue_type_template_id_196bbde8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalCreate.vue?vue&type=template&id=196bbde8& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/ModalCreate.vue?vue&type=template&id=196bbde8&");


/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/ModalInterfacePR.vue?vue&type=template&id=676aecca&":
/*!***********************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/ModalInterfacePR.vue?vue&type=template&id=676aecca& ***!
  \***********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalInterfacePR_vue_vue_type_template_id_676aecca___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalInterfacePR_vue_vue_type_template_id_676aecca___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalInterfacePR_vue_vue_type_template_id_676aecca___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalInterfacePR.vue?vue&type=template&id=676aecca& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/ModalInterfacePR.vue?vue&type=template&id=676aecca&");


/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/ModalSearch.vue?vue&type=template&id=7754afb8&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/ModalSearch.vue?vue&type=template&id=7754afb8& ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_template_id_7754afb8___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_template_id_7754afb8___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_template_id_7754afb8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearch.vue?vue&type=template&id=7754afb8& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/ModalSearch.vue?vue&type=template&id=7754afb8&");


/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/ShowComponent.vue?vue&type=template&id=176edb43&":
/*!********************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/ShowComponent.vue?vue&type=template&id=176edb43& ***!
  \********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowComponent_vue_vue_type_template_id_176edb43___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowComponent_vue_vue_type_template_id_176edb43___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowComponent_vue_vue_type_template_id_176edb43___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ShowComponent.vue?vue&type=template&id=176edb43& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/ShowComponent.vue?vue&type=template&id=176edb43&");


/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/components/HeaderDetail.vue?vue&type=template&id=1d8dd75a&":
/*!******************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/components/HeaderDetail.vue?vue&type=template&id=1d8dd75a& ***!
  \******************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HeaderDetail_vue_vue_type_template_id_1d8dd75a___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HeaderDetail_vue_vue_type_template_id_1d8dd75a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HeaderDetail_vue_vue_type_template_id_1d8dd75a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./HeaderDetail.vue?vue&type=template&id=1d8dd75a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/HeaderDetail.vue?vue&type=template&id=1d8dd75a&");


/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/components/ReceiveRoll.vue?vue&type=template&id=7204a594&":
/*!*****************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/components/ReceiveRoll.vue?vue&type=template&id=7204a594& ***!
  \*****************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ReceiveRoll_vue_vue_type_template_id_7204a594___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ReceiveRoll_vue_vue_type_template_id_7204a594___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ReceiveRoll_vue_vue_type_template_id_7204a594___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ReceiveRoll.vue?vue&type=template&id=7204a594& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/ReceiveRoll.vue?vue&type=template&id=7204a594&");


/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/components/ReceiveWeekly.vue?vue&type=template&id=5bfcbfd8&":
/*!*******************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/components/ReceiveWeekly.vue?vue&type=template&id=5bfcbfd8& ***!
  \*******************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ReceiveWeekly_vue_vue_type_template_id_5bfcbfd8___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ReceiveWeekly_vue_vue_type_template_id_5bfcbfd8___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ReceiveWeekly_vue_vue_type_template_id_5bfcbfd8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ReceiveWeekly.vue?vue&type=template&id=5bfcbfd8& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/ReceiveWeekly.vue?vue&type=template&id=5bfcbfd8&");


/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/components/StampDaily.vue?vue&type=template&id=8037019c&":
/*!****************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/components/StampDaily.vue?vue&type=template&id=8037019c& ***!
  \****************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_StampDaily_vue_vue_type_template_id_8037019c___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_StampDaily_vue_vue_type_template_id_8037019c___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_StampDaily_vue_vue_type_template_id_8037019c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./StampDaily.vue?vue&type=template&id=8037019c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/StampDaily.vue?vue&type=template&id=8037019c&");


/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab1.vue?vue&type=template&id=91c26b70&":
/*!*************************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab1.vue?vue&type=template&id=91c26b70& ***!
  \*************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_StampDailyTableTab1_vue_vue_type_template_id_91c26b70___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_StampDailyTableTab1_vue_vue_type_template_id_91c26b70___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_StampDailyTableTab1_vue_vue_type_template_id_91c26b70___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./StampDailyTableTab1.vue?vue&type=template&id=91c26b70& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab1.vue?vue&type=template&id=91c26b70&");


/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab2.vue?vue&type=template&id=91a63c6e&":
/*!*************************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab2.vue?vue&type=template&id=91a63c6e& ***!
  \*************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_StampDailyTableTab2_vue_vue_type_template_id_91a63c6e___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_StampDailyTableTab2_vue_vue_type_template_id_91a63c6e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_StampDailyTableTab2_vue_vue_type_template_id_91a63c6e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./StampDailyTableTab2.vue?vue&type=template&id=91a63c6e& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab2.vue?vue&type=template&id=91a63c6e&");


/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab3.vue?vue&type=template&id=918a0d6c&":
/*!*************************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab3.vue?vue&type=template&id=918a0d6c& ***!
  \*************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_StampDailyTableTab3_vue_vue_type_template_id_918a0d6c___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_StampDailyTableTab3_vue_vue_type_template_id_918a0d6c___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_StampDailyTableTab3_vue_vue_type_template_id_918a0d6c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./StampDailyTableTab3.vue?vue&type=template&id=918a0d6c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab3.vue?vue&type=template&id=918a0d6c&");


/***/ }),

/***/ "./resources/js/components/Planning/Stamp-follow/components/SubmitPRTransaction.vue?vue&type=template&id=74100810&":
/*!*************************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Stamp-follow/components/SubmitPRTransaction.vue?vue&type=template&id=74100810& ***!
  \*************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SubmitPRTransaction_vue_vue_type_template_id_74100810___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SubmitPRTransaction_vue_vue_type_template_id_74100810___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SubmitPRTransaction_vue_vue_type_template_id_74100810___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SubmitPRTransaction.vue?vue&type=template&id=74100810& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/SubmitPRTransaction.vue?vue&type=template&id=74100810&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/ModalCreate.vue?vue&type=template&id=196bbde8&":
/*!*********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/ModalCreate.vue?vue&type=template&id=196bbde8& ***!
  \*********************************************************************************************************************************************************************************************************************************************/
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
        class: _vm.btnTrans.create.class + " btn-lg tw-w-25",
        attrs: { type: "button" },
        on: { click: _vm.openModal }
      },
      [
        _c("i", { class: _vm.btnTrans.create.icon }),
        _vm._v("\n        " + _vm._s(_vm.btnTrans.create.text) + "\n    ")
      ]
    ),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass: "modal fade",
        attrs: {
          id: "modal_create",
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
                _c("div", { staticClass: "row col-12 m-0" }, [
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
                          _c(
                            "el-select",
                            {
                              attrs: {
                                size: "large",
                                placeholder: "ปีงบประมาณ",
                                clearable: "",
                                filterable: "",
                                "popper-append-to-body": false
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
                            _vm._l(_vm.yearList, function(year, index) {
                              return _c("el-option", {
                                key: index,
                                attrs: { label: index, value: index }
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
                        "form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2"
                    },
                    [
                      _c(
                        "label",
                        {
                          staticClass:
                            "text-left tw-font-bold tw-uppercase mb-1"
                        },
                        [_vm._v(" ประมาณการใช้แสตมป์เดือน :")]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "input-group " },
                        [
                          _c(
                            "el-select",
                            {
                              attrs: {
                                size: "large",
                                placeholder: "เดือน",
                                clearable: "",
                                filterable: "",
                                "popper-append-to-body": false
                              },
                              model: {
                                value: _vm.periodNo,
                                callback: function($$v) {
                                  _vm.periodNo = $$v
                                },
                                expression: "periodNo"
                              }
                            },
                            _vm._l(_vm.monthList, function(item, index) {
                              return _c("el-option", {
                                key: item.period_num,
                                attrs: {
                                  label: item.thai_month,
                                  value: item.period_num
                                }
                              })
                            }),
                            1
                          )
                        ],
                        1
                      )
                    ]
                  )
                ]),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    staticClass:
                      "form-group pl-2 pr-2 mb-0 col-lg-12 col-md-12 col-sm-12 col-xs-12"
                  },
                  [
                    _vm._m(1),
                    _vm._v(" "),
                    _c("div", { staticClass: "text-right" }, [
                      _c(
                        "button",
                        {
                          class: _vm.btnTrans.create.class + " btn-md tw-w-25",
                          attrs: { type: "button", disabled: !_vm.periodNo },
                          on: {
                            click: function($event) {
                              $event.preventDefault()
                              return _vm.submit()
                            }
                          }
                        },
                        [
                          _c("i", { class: _vm.btnTrans.create.icon }),
                          _vm._v(
                            "\n                                " +
                              _vm._s(_vm.btnTrans.create.text) +
                              "\n                            "
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "button",
                        {
                          staticClass: "btn btn-white btn-md tw-w-25",
                          attrs: { type: "button", "data-dismiss": "modal" }
                        },
                        [_vm._v("Close")]
                      )
                    ])
                  ]
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
          staticStyle: { "font-size": "22px", "font-weight": "400" }
        },
        [
          _vm._v(
            "\n                        สร้างการติดตามการใช้งานแสตมป์รายวัน\n                    "
          )
        ]
      ),
      _vm._v(" "),
      _c(
        "button",
        {
          staticClass: "close",
          attrs: {
            type: "button",
            "data-dismiss": "modal",
            "aria-label": "Close"
          }
        },
        [_c("span", { attrs: { "aria-hidden": "true" } }, [_vm._v("×")])]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: " tw-font-bold tw-uppercase mt-1" }, [
      _vm._v(" "),
      _c("br")
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/ModalInterfacePR.vue?vue&type=template&id=676aecca&":
/*!**************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/ModalInterfacePR.vue?vue&type=template&id=676aecca& ***!
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
        class: _vm.btnTrans.interface_pr.class + " btn-lg tw-w-25",
        attrs: { type: "button" },
        on: { click: _vm.openModal }
      },
      [
        _c("i", { class: _vm.btnTrans.interface_pr.icon }),
        _vm._v("\n        " + _vm._s(_vm.btnTrans.interface_pr.text) + "\n    ")
      ]
    ),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass: "modal fade",
        attrs: {
          id: "modal_interface",
          tabindex: "-1",
          role: "dialog",
          "aria-hidden": "true"
        }
      },
      [
        _c(
          "div",
          {
            staticClass: "modal-dialog modal-lg",
            staticStyle: { width: "90%", "max-width": "950px" }
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
                  _c("form", { attrs: { id: "interface-form" } }, [
                    _c("div", { staticClass: "row col-12 m-0" }, [
                      _c(
                        "div",
                        {
                          staticClass:
                            "form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2"
                        },
                        [
                          _c(
                            "label",
                            {
                              staticClass:
                                "text-left tw-font-bold tw-uppercase mb-1"
                            },
                            [_vm._v(" วันที่ส่งข้อมูล :")]
                          ),
                          _vm._v(" "),
                          _c(
                            "div",
                            { staticClass: "input-group " },
                            [
                              _c("el-input", {
                                attrs: {
                                  type: "text",
                                  placeholder: "วันที่ส่งข้อมูล",
                                  readonly: ""
                                },
                                model: {
                                  value: _vm.head.current_date_format,
                                  callback: function($$v) {
                                    _vm.$set(
                                      _vm.head,
                                      "current_date_format",
                                      $$v
                                    )
                                  },
                                  expression: "head.current_date_format"
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
                            "form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2"
                        },
                        [
                          _c(
                            "label",
                            {
                              staticClass:
                                "text-left tw-font-bold tw-uppercase mb-1"
                            },
                            [_vm._v(" วันที่ที่ต้องการจัดซื้อ :")]
                          ),
                          _vm._v(" "),
                          _c(
                            "div",
                            { staticClass: "input-group" },
                            [
                              _c("datepicker-th", {
                                staticClass: "form-control md:tw-mb-0 tw-mb-2",
                                style:
                                  "width: 100%; " +
                                  (_vm.errors.need_by_date
                                    ? "border: 1px solid red;"
                                    : ""),
                                attrs: {
                                  name: "need_by_date",
                                  id: "need_by_date",
                                  placeholder: "โปรดเลือกวันที่",
                                  value: _vm.needByDate,
                                  format: "DD-MMM-YYYY"
                                },
                                on: { dateWasSelected: _vm.dateWasSelected },
                                model: {
                                  value: _vm.needByDate,
                                  callback: function($$v) {
                                    _vm.needByDate = $$v
                                  },
                                  expression: "needByDate"
                                }
                              })
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c("div", {
                            staticClass: "error_msg text-left",
                            attrs: { id: "el_explode_need_by_date" }
                          })
                        ]
                      )
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "row col-12 m-0" }, [
                      _c(
                        "div",
                        {
                          staticClass:
                            "form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2"
                        },
                        [
                          _c(
                            "label",
                            {
                              staticClass:
                                "text-left tw-font-bold tw-uppercase mb-1"
                            },
                            [_vm._v(" ผู้ตรวจสอบ :")]
                          ),
                          _vm._v(" "),
                          _c(
                            "div",
                            { staticClass: "input-group" },
                            [
                              _c(
                                "el-select",
                                {
                                  ref: "approver1",
                                  staticStyle: { "'width": "100%" },
                                  attrs: {
                                    size: "large",
                                    placeholder: "ผู้ตรวจสอบ",
                                    clearable: "",
                                    filterable: "",
                                    "popper-append-to-body": false
                                  },
                                  model: {
                                    value: _vm.approver1,
                                    callback: function($$v) {
                                      _vm.approver1 = $$v
                                    },
                                    expression: "approver1"
                                  }
                                },
                                _vm._l(_vm.users, function(user, index) {
                                  return _c("el-option", {
                                    key: user.username,
                                    attrs: {
                                      label: user.name,
                                      value: user.username
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
                            attrs: { id: "el_explode_approver1" }
                          })
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        {
                          staticClass:
                            "form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2"
                        },
                        [
                          _c(
                            "label",
                            {
                              staticClass:
                                "text-left tw-font-bold tw-uppercase mb-1"
                            },
                            [_vm._v(" ผู้อนุมัติ :")]
                          ),
                          _vm._v(" "),
                          _c(
                            "div",
                            { staticClass: "input-group" },
                            [
                              _c(
                                "el-select",
                                {
                                  ref: "approver2",
                                  staticStyle: { "'width": "100%" },
                                  attrs: {
                                    size: "large",
                                    placeholder: "ผู้อนุมัติ",
                                    clearable: "",
                                    filterable: "",
                                    "popper-append-to-body": false
                                  },
                                  model: {
                                    value: _vm.approver2,
                                    callback: function($$v) {
                                      _vm.approver2 = $$v
                                    },
                                    expression: "approver2"
                                  }
                                },
                                _vm._l(_vm.users, function(user, index) {
                                  return _c("el-option", {
                                    key: user.username,
                                    attrs: {
                                      label: user.name,
                                      value: user.username
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
                            attrs: { id: "el_explode_approver2" }
                          })
                        ]
                      )
                    ]),
                    _vm._v(" "),
                    _vm.html
                      ? _c(
                          "div",
                          {
                            staticClass:
                              "form-group pl-2 pr-2 mb-0 col-lg-12 col-md-12 col-sm-6 col-xs-6 mt-2"
                          },
                          [
                            _c("hr"),
                            _vm._v(" "),
                            _c("div", {
                              staticClass: "table-responsive",
                              domProps: { innerHTML: _vm._s(_vm.html) }
                            })
                          ]
                        )
                      : _vm._e(),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass:
                          "form-group pl-2 pr-2 mb-0 col-lg-12 col-md-12 col-sm-12 col-xs-12"
                      },
                      [
                        _vm._m(1),
                        _vm._v(" "),
                        _c("div", { staticClass: "text-right" }, [
                          _c(
                            "button",
                            {
                              class:
                                _vm.btnTrans.create.class + " btn-md tw-w-25",
                              attrs: {
                                type: "button",
                                disabled: !_vm.interfaceFlag
                              },
                              on: {
                                click: function($event) {
                                  $event.preventDefault()
                                  return _vm.submitPR()
                                }
                              }
                            },
                            [
                              _c("i", {
                                class: _vm.btnTrans.interface_pr.icon
                              }),
                              _vm._v(
                                " ส่งข้อมูล\n                                "
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "button",
                            {
                              staticClass: "btn btn-white btn-md tw-w-25",
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
          staticStyle: { "font-size": "22px", "font-weight": "400" }
        },
        [
          _vm._v(
            "\n                        ส่งข้อมูลเข้า PR\n                    "
          )
        ]
      ),
      _vm._v(" "),
      _c(
        "button",
        {
          staticClass: "close",
          attrs: {
            type: "button",
            "data-dismiss": "modal",
            "aria-label": "Close"
          }
        },
        [_c("span", { attrs: { "aria-hidden": "true" } }, [_vm._v("×")])]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: " tw-font-bold tw-uppercase mt-1" }, [
      _vm._v(" "),
      _c("br")
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/ModalSearch.vue?vue&type=template&id=7754afb8&":
/*!*********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/ModalSearch.vue?vue&type=template&id=7754afb8& ***!
  \*********************************************************************************************************************************************************************************************************************************************/
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
        _c(
          "div",
          {
            staticClass: "modal-dialog modal-lg",
            staticStyle: { width: "90%", "max-width": "950px" }
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
                  _c(
                    "form",
                    { attrs: { id: "search-form", action: _vm.url.search } },
                    [
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
                                    model: {
                                      value: _vm.budget_year,
                                      callback: function($$v) {
                                        _vm.budget_year = $$v
                                      },
                                      expression: "budget_year"
                                    }
                                  },
                                  _vm._l(_vm.budgetYears, function(
                                    year,
                                    index
                                  ) {
                                    return _c("el-option", {
                                      key: index,
                                      attrs: { label: year, value: year }
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
                              "form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2"
                          },
                          [
                            _c(
                              "label",
                              {
                                staticClass:
                                  "text-left tw-font-bold tw-uppercase mb-1"
                              },
                              [_vm._v(" เดือน :")]
                            ),
                            _vm._v(" "),
                            _c(
                              "div",
                              { staticClass: "input-group " },
                              [
                                _c("input", {
                                  attrs: {
                                    type: "hidden",
                                    name: "search[thai_month]"
                                  },
                                  domProps: { value: _vm.month }
                                }),
                                _vm._v(" "),
                                _c(
                                  "el-select",
                                  {
                                    ref: "month",
                                    attrs: {
                                      size: "large",
                                      placeholder: "เดือน",
                                      clearable: "",
                                      filterable: "",
                                      "popper-append-to-body": false
                                    },
                                    model: {
                                      value: _vm.month,
                                      callback: function($$v) {
                                        _vm.month = $$v
                                      },
                                      expression: "month"
                                    }
                                  },
                                  _vm._l(_vm.monthList, function(month, index) {
                                    return _c("el-option", {
                                      key: index,
                                      attrs: {
                                        label: month.thai_month,
                                        value: month.thai_month
                                      }
                                    })
                                  }),
                                  1
                                ),
                                _vm._v(" "),
                                _c("div", {
                                  staticClass: "error_msg text-left",
                                  attrs: { id: "el_explode_month" }
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
                              "form-group text-right pr-2 mb-0 col-lg-2 col-md-10 col-sm-12 col-xs-12"
                          },
                          [
                            _c(
                              "label",
                              {
                                staticClass: " tw-font-bold tw-uppercase mt-2"
                              },
                              [_vm._v(" ")]
                            ),
                            _vm._v(" "),
                            _c("div", { staticClass: "text-left" }, [
                              _c(
                                "button",
                                {
                                  class:
                                    _vm.btnTrans.search.class +
                                    " btn-lg tw-w-25",
                                  attrs: { type: "button" },
                                  on: {
                                    click: function($event) {
                                      $event.preventDefault()
                                      return _vm.searchForm($event)
                                    }
                                  }
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
                            ]),
                            _vm._v(" "),
                            _c("small", { staticClass: "font-bold" }, [
                              _vm._v(
                                "\n                                     \n                                "
                              )
                            ])
                          ]
                        )
                      ])
                    ]
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
          staticStyle: { "font-size": "22px", "font-weight": "400" }
        },
        [
          _vm._v(
            "\n                        ค้นหาการติดตามการใช้งานแสตมป์รายวัน\n                    "
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/ShowComponent.vue?vue&type=template&id=176edb43&":
/*!***********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/ShowComponent.vue?vue&type=template&id=176edb43& ***!
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
      _c("div", { staticClass: "ibox float-e-margins mb-2" }, [
        _c(
          "div",
          { staticClass: "col-12 text-right mt-2" },
          [
            _c("modal-search", {
              attrs: {
                btnTrans: _vm.btnTrans,
                url: _vm.url,
                budgetYears: _vm.searchInput.budget_years,
                defBudgetYear: _vm.searchInput.def_period_year,
                monthList: _vm.searchInput.month_list,
                search: _vm.defaultSearch
              }
            }),
            _vm._v(" "),
            !_vm.stamp_main
              ? [
                  _c("modal-create", {
                    attrs: {
                      btnTrans: _vm.btnTrans,
                      url: _vm.url,
                      createInput: _vm.createInput
                    }
                  })
                ]
              : [
                  _vm.stamp_main
                    ? _c(
                        "a",
                        {
                          class: _vm.btnTrans.search.class + " btn-lg tw-w-25",
                          attrs: {
                            href: "/planning/stamp-follow",
                            type: "button"
                          }
                        },
                        [
                          _c("i", { class: _vm.btnTrans.reset.icon }),
                          _vm._v(
                            "\n                    ล้างการค้นหา\n                "
                          )
                        ]
                      )
                    : _vm._e()
                ],
            _vm._v(" "),
            _vm.stamp_main && _vm.valid
              ? _c("modal-interface", {
                  attrs: {
                    btnTrans: _vm.btnTrans,
                    url: _vm.url,
                    header: _vm.header,
                    stampMain: _vm.stamp_main,
                    users: _vm.users
                  },
                  on: { updateStampHeader: _vm.updateStampHeader }
                })
              : _vm._e()
          ],
          2
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "card border-primary mb-3 mt-2" }, [
        _c(
          "div",
          { staticClass: "card-body" },
          [_c("header-detail", { attrs: { header: _vm.stamp_main } })],
          1
        )
      ]),
      _vm._v(" "),
      _vm.stamp_main
        ? _c("stamp-daily", {
            attrs: {
              header: _vm.stamp_main,
              btnTrans: _vm.btnTrans,
              url: _vm.url,
              interfaceTemps: _vm.temps,
              poLists: _vm.poMaps
            },
            on: { updateStamp: _vm.updateStamp }
          })
        : Object.values(_vm.defaultSearch).length
        ? [
            _c("div", { staticClass: "col-12 text-center mt-4" }, [
              _c("h2", [_vm._v(" ไม่พบข้อมูลที่ค้นหาในระบบ ")]),
              _vm._v(" "),
              _c("div", { staticClass: "hr-line-dashed" })
            ])
          ]
        : _vm._e()
    ],
    2
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/HeaderDetail.vue?vue&type=template&id=1d8dd75a&":
/*!*********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/HeaderDetail.vue?vue&type=template&id=1d8dd75a& ***!
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
  return _c("div", {}, [
    _c("form", { attrs: { id: "stamp-follow-form" } }, [
      _c("div", { staticClass: "row" }, [
        _c("div", { staticClass: "col-8 b-r" }, [
          _c("div", { staticClass: "row" }, [
            _c("div", { staticClass: "col-lg-3" }, [
              _c("dl", { staticClass: "row mb-0" }, [
                _vm._m(0),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-5 text-sm-left" }, [
                  _c("dd", { staticClass: "mb-1" }, [
                    _vm.header && _vm.header.pp_period
                      ? _c("div", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(_vm.header.pp_period.thai_year) +
                              "\n                                    "
                          )
                        ])
                      : _vm._e()
                  ])
                ])
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-lg-3" }, [
              _c("dl", { staticClass: "row mb-0" }, [
                _vm._m(1),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-7 text-sm-left" }, [
                  _c("dd", { staticClass: "mb-1" }, [
                    _vm.header && _vm.header.pp_period
                      ? _c("div", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(_vm.header.pp_period.thai_month) +
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
                _vm._m(2),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-6 text-sm-left" }, [
                  _c("dd", { staticClass: "mb-1" }, [
                    _vm.header
                      ? _c("div", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(_vm.header.current_date_format) +
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
                _c("div", { staticClass: "col-sm-6 text-sm-left" }, [
                  _c("dd", { staticClass: "mb-1" }, [
                    _vm.header
                      ? _c("div", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(_vm.header.last_update_date_format) +
                              "\n                                    "
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
                    _vm.header
                      ? _c("div", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(
                                _vm.header.updated_by
                                  ? _vm.header.updated_by.name
                                  : ""
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
                _vm._m(5),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-6 text-sm-left" }, [
                  _c("dd", { staticClass: "mb-1" }, [
                    _vm.header
                      ? _c("div", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(
                                _vm.header.interface_pr_date_format
                                  ? _vm.header.interface_pr_date_format
                                  : ""
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
    return _c("div", { staticClass: "col-sm-7 pl-0 text-sm-right pl-0 pr-0" }, [
      _c("dt", [_vm._v("ปีงบประมาณ:")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-sm-5 pl-0 text-sm-right pl-0 pr-0" }, [
      _c("dt", [_vm._v("ประจำเดือน:")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-sm-6 text-sm-right" }, [
      _c("dt", [_vm._v("วันที่ปัจจุบัน:")])
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
      _c("dt", [_vm._v("ผู้บันทึก:")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-sm-6 text-sm-right" }, [
      _c("dt", [_vm._v("นำข้อมูลเข้าล่าสุด:")])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/ReceiveRoll.vue?vue&type=template&id=7204a594&":
/*!********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/ReceiveRoll.vue?vue&type=template&id=7204a594& ***!
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
    { staticClass: "text-right" },
    [
      _vm.editFlag
        ? _c("vue-numeric", {
            staticClass: "form-control input-sm text-right",
            staticStyle: { width: "100%" },
            attrs: {
              name: "receive_roll_qty",
              separator: ",",
              precision: 2,
              minus: false,
              min: 0,
              max: 99999999999
            },
            on: {
              change: function($event) {
                return _vm.changeReceiveQty()
              },
              blur: function($event) {
                return _vm.changeReceiveQty()
              }
            },
            model: {
              value: _vm.line.receive_roll_qty,
              callback: function($$v) {
                _vm.$set(_vm.line, "receive_roll_qty", $$v)
              },
              expression: "line.receive_roll_qty"
            }
          })
        : _c("div", { staticStyle: { width: "100%" } }, [
            _vm._v(
              " " + _vm._s(Number(_vm.line.receive_roll_qty).toFixed(2)) + " "
            )
          ])
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/ReceiveWeekly.vue?vue&type=template&id=5bfcbfd8&":
/*!**********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/ReceiveWeekly.vue?vue&type=template&id=5bfcbfd8& ***!
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
  return _c(
    "div",
    { staticClass: "text-right" },
    [
      _vm.editFlag
        ? _c("vue-numeric", {
            staticClass: "form-control input-sm text-right",
            staticStyle: { width: "100%" },
            attrs: {
              name: "receive_roll_qty",
              separator: ",",
              precision: 2,
              minus: false,
              min: 0,
              max: 99999999999
            },
            on: {
              change: function($event) {
                return _vm.changeReceiveQty()
              },
              blur: function($event) {
                return _vm.changeReceiveQty()
              }
            },
            model: {
              value: _vm.line.weekly_receive_qty,
              callback: function($$v) {
                _vm.$set(_vm.line, "weekly_receive_qty", $$v)
              },
              expression: "line.weekly_receive_qty"
            }
          })
        : _c("div", { staticStyle: { width: "100%" } }, [
            _vm._v(
              " " +
                _vm._s(_vm.formatNumber(Number(_vm.line.weekly_receive_qty))) +
                " "
            )
          ])
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/StampDaily.vue?vue&type=template&id=8037019c&":
/*!*******************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/StampDaily.vue?vue&type=template&id=8037019c& ***!
  \*******************************************************************************************************************************************************************************************************************************************************/
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
    _c("div", { staticClass: "tabs-container mb-3" }, [
      _vm._m(0),
      _vm._v(" "),
      _c(
        "div",
        {
          directives: [{ name: "loading", rawName: "v-loading" }],
          staticClass: "tab-content"
        },
        [
          _c(
            "div",
            {
              staticClass: "tab-pane active",
              attrs: { role: "tabpanel", id: "tab1" }
            },
            [
              _c("div", { staticClass: "panel-body " }, [
                _c("form", { attrs: { id: "stamp-form-tab1" } }, [
                  _c("div", { staticClass: "row col-12" }, [
                    _c(
                      "div",
                      {
                        staticClass:
                          "form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2"
                      },
                      [
                        _c(
                          "label",
                          {
                            staticClass:
                              "text-left tw-font-bold tw-uppercase mb-1"
                          },
                          [_vm._v(" รหัสแสตมป์ :")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "input-group " },
                          [
                            _c(
                              "el-select",
                              {
                                ref: "stamp_code_tab1",
                                staticStyle: { width: "100%" },
                                attrs: {
                                  size: "large",
                                  placeholder: "รหัสแสตมป์",
                                  clearable: "",
                                  filterable: ""
                                },
                                on: { change: _vm.selStamp },
                                model: {
                                  value: _vm.tab1Input.stamp_code,
                                  callback: function($$v) {
                                    _vm.$set(_vm.tab1Input, "stamp_code", $$v)
                                  },
                                  expression: "tab1Input.stamp_code"
                                }
                              },
                              _vm._l(_vm.header.stamp_summary, function(
                                item,
                                index
                              ) {
                                return _c(
                                  "el-option",
                                  {
                                    key: index,
                                    attrs: { label: index, value: index }
                                  },
                                  [
                                    _c(
                                      "span",
                                      { staticStyle: { float: "left" } },
                                      [_vm._v(_vm._s(index))]
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "span",
                                      {
                                        staticStyle: {
                                          float: "left",
                                          color: "#8492a6"
                                        }
                                      },
                                      [
                                        _vm._v(
                                          " : " +
                                            _vm._s(item[0].stamp_description)
                                        )
                                      ]
                                    )
                                  ]
                                )
                              }),
                              1
                            ),
                            _vm._v(" "),
                            _c("div", {
                              staticClass: "error_msg text-left",
                              attrs: { id: "el_explode_stamp_code_tab1" }
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
                          "form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2"
                      },
                      [
                        _c(
                          "label",
                          {
                            staticClass:
                              "text-left tw-font-bold tw-uppercase mb-1"
                          },
                          [_vm._v("  ")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "input-group " },
                          [
                            _c("el-input", {
                              attrs: {
                                size: "llarge",
                                readonly: true,
                                disabled: "",
                                value: (function() {
                                  if (!_vm.tab1Input.stamp_code) {
                                    return ""
                                  }
                                  var result = _vm.header.stamp_summary[
                                    _vm.tab1Input.stamp_code
                                  ].find(function(item) {
                                    return (
                                      item.stamp_code ===
                                      _vm.tab1Input.stamp_code
                                    )
                                  })
                                  if (result) {
                                    return result.stamp_description
                                  }
                                })()
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
                          "form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2"
                      },
                      [
                        _c(
                          "label",
                          {
                            staticClass:
                              "text-left tw-font-bold tw-uppercase mb-1"
                          },
                          [_vm._v(" ม้วนละ :")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "input-group " },
                          [
                            _c("el-input", {
                              staticClass: "text-right",
                              attrs: {
                                size: "llarge",
                                readonly: true,
                                disabled: "",
                                value: (function() {
                                  if (!_vm.tab1Input.stamp_code) {
                                    return ""
                                  }
                                  var result = _vm.header.stamp_summary[
                                    _vm.tab1Input.stamp_code
                                  ].find(function(item) {
                                    return (
                                      item.stamp_code ===
                                      _vm.tab1Input.stamp_code
                                    )
                                  })
                                  if (result) {
                                    return result.stamp_per_roll
                                  }
                                })()
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
                          "form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2"
                      },
                      [
                        _c(
                          "label",
                          {
                            staticClass:
                              "text-left tw-font-bold tw-uppercase mb-1"
                          },
                          [_vm._v(" ราคาต่อดวง :")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "input-group" },
                          [
                            _c("el-input", {
                              staticClass: "text-right",
                              attrs: {
                                size: "llarge",
                                readonly: true,
                                disabled: "",
                                value: (function() {
                                  if (!_vm.tab1Input.stamp_code) {
                                    return ""
                                  }
                                  var result = _vm.header.stamp_summary[
                                    _vm.tab1Input.stamp_code
                                  ].find(function(item) {
                                    return (
                                      item.stamp_code ===
                                      _vm.tab1Input.stamp_code
                                    )
                                  })
                                  if (result) {
                                    return result.unit_price
                                  }
                                })()
                              }
                            })
                          ],
                          1
                        )
                      ]
                    )
                  ]),
                  _vm._v(" "),
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
                          [_vm._v(" รหัสบุหรี่ :")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "input-group " },
                          [
                            _c(
                              "el-select",
                              {
                                ref: "cigarettes_code",
                                staticStyle: { width: "100%" },
                                attrs: {
                                  size: "large",
                                  placeholder: "รหัสบุหรี่",
                                  clearable: "",
                                  filterable: ""
                                },
                                on: { change: _vm.getStampDailyTab1 },
                                model: {
                                  value: _vm.tab1Input.cigarettes_code,
                                  callback: function($$v) {
                                    _vm.$set(
                                      _vm.tab1Input,
                                      "cigarettes_code",
                                      $$v
                                    )
                                  },
                                  expression: "tab1Input.cigarettes_code"
                                }
                              },
                              _vm._l(
                                _vm.head.stamp_items_group[
                                  _vm.tab1Input.stamp_code
                                ],
                                function(item, index) {
                                  return _c("el-option", {
                                    key: item.cigarettes_code,
                                    attrs: {
                                      label:
                                        item.cigarettes_code +
                                        ": " +
                                        item.cigarettes_description,
                                      value: item.cigarettes_code
                                    }
                                  })
                                }
                              ),
                              1
                            ),
                            _vm._v(" "),
                            _c("div", {
                              staticClass: "error_msg text-left",
                              attrs: { id: "el_explode_cigarettes_code_tab1" }
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
                          "form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2"
                      },
                      [
                        _c(
                          "label",
                          {
                            staticClass:
                              "text-left tw-font-bold tw-uppercase mb-1"
                          },
                          [_vm._v(" ตราบุหรี่")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "input-group " },
                          [
                            _c("el-input", {
                              attrs: {
                                size: "large",
                                disabled: "",
                                readonly: true,
                                value: (function() {
                                  if (!_vm.tab1Input.stamp_code) {
                                    return ""
                                  }
                                  if (!_vm.tab1Input.cigarettes_code) {
                                    return ""
                                  }

                                  var result = _vm.head.stamp_items_group[
                                    _vm.tab1Input.stamp_code
                                  ].find(function(item) {
                                    return (
                                      item.cigarettes_code ===
                                      _vm.tab1Input.cigarettes_code
                                    )
                                  })
                                  if (result) {
                                    return result.cigarettes_description
                                  }
                                })()
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
                          "form-group pl-2 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 mt-2 pt-1"
                      },
                      [
                        _vm._m(1),
                        _vm._v(" "),
                        _c(
                          "button",
                          {
                            class:
                              _vm.btnTrans.upload.class + " btn-lg tw-w-25",
                            attrs: { type: "button" },
                            on: {
                              click: function($event) {
                                $event.preventDefault()
                                return _vm.refreshStampTap1($event)
                              }
                            }
                          },
                          [
                            _vm._v(
                              "\n                                    อัพเดตประมาณการตัดใช้แสตมป์\n                                "
                            )
                          ]
                        )
                      ]
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "hr-line-dashed mt-3" }),
                  _vm._v(" "),
                  _vm.loading.stampDailyTab1Process
                    ? _c("div", { staticClass: "m-t-lg m-b-lg" }, [_vm._m(2)])
                    : _vm.summaryDataTab1.length > 0 &&
                      !_vm.loading.stampDailyTab1Process
                    ? _c(
                        "div",
                        [
                          _c("stamp-daily-table-tab1", {
                            attrs: {
                              header: _vm.header,
                              stamp:
                                _vm.header.stamp_summary[
                                  _vm.tab1Input.stamp_code
                                ][0],
                              btnTrans: _vm.btnTrans,
                              url: _vm.url,
                              summaryData: _vm.summaryDataTab1
                            },
                            on: {
                              updateStamp: _vm.updateStamp,
                              validAction: _vm.validAction
                            }
                          })
                        ],
                        1
                      )
                    : _vm._e()
                ])
              ])
            ]
          ),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass: "tab-pane",
              attrs: { role: "tabpanel", id: "tab2" }
            },
            [
              _c("div", { staticClass: "panel-body " }, [
                _c("form", { attrs: { id: "stamp-form-tab2" } }, [
                  _c("div", { staticClass: "row col-12" }, [
                    _c(
                      "div",
                      {
                        staticClass:
                          "form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2"
                      },
                      [
                        _c(
                          "label",
                          {
                            staticClass:
                              "text-left tw-font-bold tw-uppercase mb-1"
                          },
                          [_vm._v(" รหัสแสตมป์ :")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "input-group " },
                          [
                            _c(
                              "el-select",
                              {
                                ref: "stamp_code_tab2",
                                staticStyle: { width: "100%" },
                                attrs: {
                                  size: "large",
                                  placeholder: "รหัสแสตมป์",
                                  clearable: "",
                                  filterable: ""
                                },
                                on: { change: _vm.getStampDailyTab2 },
                                model: {
                                  value: _vm.tab2Input.stamp_code,
                                  callback: function($$v) {
                                    _vm.$set(_vm.tab2Input, "stamp_code", $$v)
                                  },
                                  expression: "tab2Input.stamp_code"
                                }
                              },
                              _vm._l(_vm.header.stamp_summary, function(
                                item,
                                index
                              ) {
                                return _c(
                                  "el-option",
                                  {
                                    key: index,
                                    attrs: { label: index, value: index }
                                  },
                                  [
                                    _c(
                                      "span",
                                      { staticStyle: { float: "left" } },
                                      [_vm._v(_vm._s(index))]
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "span",
                                      {
                                        staticStyle: {
                                          float: "left",
                                          color: "#8492a6"
                                        }
                                      },
                                      [
                                        _vm._v(
                                          " : " +
                                            _vm._s(item[0].stamp_description)
                                        )
                                      ]
                                    )
                                  ]
                                )
                              }),
                              1
                            ),
                            _vm._v(" "),
                            _c("div", {
                              staticClass: "error_msg text-left",
                              attrs: { id: "el_explode_stamp_code_tab2" }
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
                          "form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2"
                      },
                      [
                        _c(
                          "label",
                          {
                            staticClass:
                              "text-left tw-font-bold tw-uppercase mb-1"
                          },
                          [_vm._v("  ")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "input-group " },
                          [
                            _c("el-input", {
                              attrs: {
                                size: "llarge",
                                readonly: true,
                                disabled: "",
                                value: (function() {
                                  if (!_vm.tab2Input.stamp_code) {
                                    return ""
                                  }
                                  var result = _vm.header.stamp_summary[
                                    _vm.tab2Input.stamp_code
                                  ].find(function(item) {
                                    return (
                                      item.stamp_code ===
                                      _vm.tab2Input.stamp_code
                                    )
                                  })
                                  if (result) {
                                    return result.stamp_description
                                  }
                                })()
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
                          "form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2"
                      },
                      [
                        _c(
                          "label",
                          {
                            staticClass:
                              "text-left tw-font-bold tw-uppercase mb-1"
                          },
                          [_vm._v(" ม้วนละ :")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "input-group " },
                          [
                            _c("el-input", {
                              staticClass: "text-right",
                              attrs: {
                                size: "llarge",
                                readonly: true,
                                disabled: "",
                                value: (function() {
                                  if (!_vm.tab2Input.stamp_code) {
                                    return ""
                                  }
                                  var result = _vm.header.stamp_summary[
                                    _vm.tab2Input.stamp_code
                                  ].find(function(item) {
                                    return (
                                      item.stamp_code ===
                                      _vm.tab2Input.stamp_code
                                    )
                                  })
                                  if (result) {
                                    return result.stamp_per_roll
                                  }
                                })()
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
                          "form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2"
                      },
                      [
                        _c(
                          "label",
                          {
                            staticClass:
                              "text-left tw-font-bold tw-uppercase mb-1"
                          },
                          [_vm._v(" ราคาต่อดวง :")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "input-group" },
                          [
                            _c("el-input", {
                              staticClass: "text-right",
                              attrs: {
                                size: "llarge",
                                readonly: true,
                                disabled: "",
                                value: (function() {
                                  if (!_vm.tab2Input.stamp_code) {
                                    return ""
                                  }
                                  var result = _vm.header.stamp_summary[
                                    _vm.tab2Input.stamp_code
                                  ].find(function(item) {
                                    return (
                                      item.stamp_code ===
                                      _vm.tab2Input.stamp_code
                                    )
                                  })
                                  if (result) {
                                    return result.unit_price
                                  }
                                })()
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
                          "form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-6 col-xs-6 mt-2 pt-1"
                      },
                      [
                        _vm._m(3),
                        _vm._v(" "),
                        _c(
                          "button",
                          {
                            class:
                              _vm.btnTrans.upload.class + " btn-lg tw-w-25",
                            attrs: { type: "button" },
                            on: {
                              click: function($event) {
                                $event.preventDefault()
                                return _vm.refreshStampTap2($event)
                              }
                            }
                          },
                          [
                            _vm._v(
                              "\n                                    อัพเดตคงคลังแสตมป์\n                                "
                            )
                          ]
                        )
                      ]
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "hr-line-dashed mt-3" }),
                  _vm._v(" "),
                  _vm.loading.stampDailyTab2Process
                    ? _c("div", { staticClass: "m-t-lg m-b-lg" }, [_vm._m(4)])
                    : _vm.summaryDataTab2.length > 0 &&
                      !_vm.loading.stampDailyTab2Process
                    ? _c(
                        "div",
                        [
                          _c("stamp-daily-table-tab2", {
                            attrs: {
                              header: _vm.header,
                              stamp: _vm.tab2Input.stamp_code
                                ? _vm.header.stamp_summary[
                                    _vm.tab2Input.stamp_code
                                  ][0]
                                : "",
                              btnTrans: _vm.btnTrans,
                              url: _vm.url,
                              summaryData: _vm.summaryDataTab2
                            }
                          })
                        ],
                        1
                      )
                    : _vm._e()
                ])
              ])
            ]
          ),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass: "tab-pane",
              attrs: { role: "tabpanel", id: "tab3" }
            },
            [
              _c(
                "div",
                { staticClass: "panel-body" },
                [
                  _c("stamp-daily-table-tab3", {
                    attrs: {
                      header: _vm.header,
                      interfaceTemps: _vm.interfaceTemps,
                      poLists: _vm.poLists,
                      btnTrans: _vm.btnTrans,
                      url: _vm.url
                    }
                  })
                ],
                1
              )
            ]
          )
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
    return _c(
      "ul",
      { staticClass: "nav nav-tabs", attrs: { role: "tablist" } },
      [
        _c("li", [
          _c(
            "a",
            {
              staticClass: "nav-link active",
              attrs: { "data-toggle": "tab", href: "#tab1" }
            },
            [
              _vm._v(
                "\n                    ประมาณการผลิตแยกรายตรา\n                "
              )
            ]
          )
        ]),
        _vm._v(" "),
        _c("li", [
          _c(
            "a",
            {
              staticClass: "nav-link ",
              attrs: { "data-toggle": "tab", href: "#tab2" }
            },
            [
              _vm._v(
                "\n                    ประมาณการผลิตแยกตามกลุ่มราคา\n                "
              )
            ]
          )
        ]),
        _vm._v(" "),
        _c("li", [
          _c(
            "a",
            {
              staticClass: "nav-link ",
              attrs: { "data-toggle": "tab", href: "#tab3" }
            },
            [_vm._v("\n                    ตรวจสอบรายการ PR\n                ")]
          )
        ])
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("span", [_c("br"), _vm._v("  ")])
  },
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
    return _c("span", [_c("br"), _vm._v("  ")])
  },
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
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab1.vue?vue&type=template&id=91c26b70&":
/*!****************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab1.vue?vue&type=template&id=91c26b70& ***!
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
    _c("div", { staticClass: "row" }, [
      _vm._m(0),
      _vm._v(" "),
      _vm.header
        ? _c("div", { staticClass: "col-md-4 text-right" }, [
            !_vm.edit_flag
              ? _c(
                  "button",
                  {
                    class: _vm.btnTrans.edit.class + " btn-lg tw-w-25",
                    attrs: { type: "button" },
                    on: {
                      click: function($event) {
                        return _vm.changeStampData()
                      }
                    }
                  },
                  [
                    _c("i", { class: _vm.btnTrans.edit.icon }),
                    _vm._v(
                      " " + _vm._s(_vm.btnTrans.edit.text) + "\n            "
                    )
                  ]
                )
              : _vm._e(),
            _vm._v(" "),
            _vm.edit_flag
              ? _c(
                  "button",
                  {
                    class: _vm.btnTrans.save.class + " btn-lg tw-w-25",
                    attrs: { type: "button" },
                    on: {
                      click: function($event) {
                        $event.preventDefault()
                        return _vm.saveChangeInput($event)
                      }
                    }
                  },
                  [
                    _c("i", { class: _vm.btnTrans.save.icon }),
                    _vm._v(
                      " " + _vm._s(_vm.btnTrans.save.text) + "\n            "
                    )
                  ]
                )
              : _vm._e(),
            _vm._v(" "),
            _vm.edit_flag
              ? _c(
                  "button",
                  {
                    class: _vm.btnTrans.cancel.class + " btn-lg tw-w-25",
                    attrs: { type: "button" },
                    on: {
                      click: function($event) {
                        return _vm.changeStampData()
                      }
                    }
                  },
                  [
                    _c("i", { class: _vm.btnTrans.cancel.icon }),
                    _vm._v(
                      " " + _vm._s(_vm.btnTrans.cancel.text) + "\n            "
                    )
                  ]
                )
              : _vm._e()
          ])
        : _vm._e()
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "table-responsive" }, [
      _c("table", { staticClass: "table table-bordered" }, [
        _vm._m(1),
        _vm._v(" "),
        _c(
          "tbody",
          [
            _vm.lines.length <= 0
              ? [_vm._m(2)]
              : [
                  _vm._l(_vm.lines, function(line, index) {
                    return [
                      _c(
                        "tr",
                        {
                          style:
                            line.holiday_flag == "Y"
                              ? "background-color: #cccccc;"
                              : line.holiday_flag == "P"
                              ? "background-color: #878788;"
                              : ""
                        },
                        [
                          _c(
                            "td",
                            {
                              staticClass: "text-center",
                              style:
                                _vm.sel_daily == line.follow_date_format
                                  ? "background-color: #9AD9DB; vertical-align: middle;"
                                  : "vertical-align: middle;",
                              on: {
                                click: function($event) {
                                  return _vm.selDailyDate(
                                    line.follow_date_format
                                  )
                                }
                              }
                            },
                            [
                              _c("div", { staticStyle: { width: "80px" } }, [
                                _vm._v(
                                  " " + _vm._s(line.follow_date_format) + " "
                                )
                              ])
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "td",
                            {
                              staticClass: "text-right",
                              style:
                                _vm.sel_daily == line.follow_date_format
                                  ? "background-color: #9AD9DB; vertical-align: middle;"
                                  : "vertical-align: middle;",
                              on: {
                                click: function($event) {
                                  return _vm.selDailyDate(
                                    line.follow_date_format
                                  )
                                }
                              }
                            },
                            [
                              _c("div", { staticStyle: { width: "100px" } }, [
                                _vm._v(
                                  "\n                                    " +
                                    _vm._s(
                                      _vm._f("number2Digit")(
                                        _vm.onhandQuantity[line.follow_date]
                                      )
                                    ) +
                                    "\n                                "
                                )
                              ])
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "td",
                            {
                              staticClass: "text-right",
                              style:
                                _vm.sel_daily == line.follow_date_format
                                  ? "background-color: #9AD9DB;"
                                  : "",
                              on: {
                                click: function($event) {
                                  return _vm.selDailyDate(
                                    line.follow_date_format
                                  )
                                }
                              }
                            },
                            [
                              _c("receive-weekly", {
                                staticStyle: { width: "130px" },
                                attrs: {
                                  stamp: _vm.stamp,
                                  line: line,
                                  "edit-flag": _vm.edit_flag,
                                  "line-weekly-daily-edit":
                                    _vm.lineWeeklyDailyEdit
                                }
                              })
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c(
                            "td",
                            {
                              staticClass: "text-right",
                              style:
                                _vm.sel_daily == line.follow_date_format
                                  ? "background-color: #9AD9DB;"
                                  : "",
                              on: {
                                click: function($event) {
                                  return _vm.selDailyDate(
                                    line.follow_date_format
                                  )
                                }
                              }
                            },
                            [
                              _c("receive-roll", {
                                staticStyle: { width: "130px" },
                                attrs: {
                                  stamp: _vm.stamp,
                                  line: line,
                                  "edit-flag": _vm.edit_flag,
                                  "line-roll-daily-edit": _vm.lineRollDailyEdit
                                }
                              })
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c(
                            "td",
                            {
                              staticClass: "text-right",
                              style:
                                _vm.sel_daily == line.follow_date_format
                                  ? "background-color: #9AD9DB; vertical-align: middle;"
                                  : "vertical-align: middle;",
                              on: {
                                click: function($event) {
                                  return _vm.selDailyDate(
                                    line.follow_date_format
                                  )
                                }
                              }
                            },
                            [
                              _c("div", { staticStyle: { width: "130px" } }, [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      _vm._f("number2Digit")(
                                        line.receipt_amount
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
                              style:
                                _vm.sel_daily == line.follow_date_format
                                  ? "background-color: #9AD9DB; vertical-align: middle;"
                                  : "vertical-align: middle;",
                              on: {
                                click: function($event) {
                                  return _vm.selDailyDate(
                                    line.follow_date_format
                                  )
                                }
                              }
                            },
                            [
                              _c("div", { staticStyle: { width: "100px" } }, [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      _vm._f("number0Digit")(
                                        line.claim_receive_qty
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
                              style:
                                _vm.sel_daily == line.follow_date_format
                                  ? "background-color: #9AD9DB; vertical-align: middle;"
                                  : "vertical-align: middle;",
                              on: {
                                click: function($event) {
                                  return _vm.selDailyDate(
                                    line.follow_date_format
                                  )
                                }
                              }
                            },
                            [
                              _c("div", { staticStyle: { width: "100px" } }, [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      _vm._f("number0Digit")(line.issue_qty)
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
                              style:
                                _vm.sel_daily == line.follow_date_format
                                  ? "background-color: #9AD9DB; vertical-align: middle;"
                                  : "vertical-align: middle;",
                              on: {
                                click: function($event) {
                                  return _vm.selDailyDate(
                                    line.follow_date_format
                                  )
                                }
                              }
                            },
                            [
                              _c("div", { staticStyle: { width: "100px" } }, [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      _vm._f("number0Digit")(line.lost_qty)
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
                              style:
                                _vm.sel_daily == line.follow_date_format
                                  ? "background-color: #9AD9DB; vertical-align: middle;"
                                  : "vertical-align: middle;",
                              on: {
                                click: function($event) {
                                  return _vm.selDailyDate(
                                    line.follow_date_format
                                  )
                                }
                              }
                            },
                            [
                              _c("div", { staticStyle: { width: "100px" } }, [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      _vm._f("number0Digit")(line.damaged_qty)
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
                              style:
                                _vm.sel_daily == line.follow_date_format
                                  ? "background-color: #9AD9DB; vertical-align: middle;"
                                  : "vertical-align: middle;",
                              on: {
                                click: function($event) {
                                  return _vm.selDailyDate(
                                    line.follow_date_format
                                  )
                                }
                              }
                            },
                            [
                              _c("div", { staticStyle: { width: "100px" } }, [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      _vm._f("number0Digit")(
                                        line.incompleted_qty
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
                              style:
                                _vm.sel_daily == line.follow_date_format
                                  ? "background-color: #9AD9DB; vertical-align: middle;"
                                  : "vertical-align: middle;",
                              on: {
                                click: function($event) {
                                  return _vm.selDailyDate(
                                    line.follow_date_format
                                  )
                                }
                              }
                            },
                            [
                              _c("div", { staticStyle: { width: "100px" } }, [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      _vm._f("number0Digit")(
                                        line.total_issue_qty
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
                              style:
                                _vm.sel_daily == line.follow_date_format
                                  ? "background-color: #9AD9DB; vertical-align: middle;"
                                  : "vertical-align: middle;",
                              on: {
                                click: function($event) {
                                  return _vm.selDailyDate(
                                    line.follow_date_format
                                  )
                                }
                              }
                            },
                            [
                              _c("div", { staticStyle: { width: "100px" } }, [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      _vm._f("number0Digit")(
                                        line.total_daily_qty
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
                              style:
                                _vm.sel_daily == line.follow_date_format
                                  ? "background-color: #9AD9DB; vertical-align: middle;"
                                  : "vertical-align: middle;",
                              on: {
                                click: function($event) {
                                  return _vm.selDailyDate(
                                    line.follow_date_format
                                  )
                                }
                              }
                            },
                            [
                              _c("div", { staticStyle: { width: "100px" } }, [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      _vm._f("number0Digit")(
                                        line.factory_bal_onhand_qty
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
                              style:
                                _vm.sel_daily == line.follow_date_format
                                  ? "background-color: #9AD9DB; vertical-align: middle;"
                                  : "vertical-align: middle;",
                              on: {
                                click: function($event) {
                                  return _vm.selDailyDate(
                                    line.follow_date_format
                                  )
                                }
                              }
                            },
                            [
                              _c("div", { staticStyle: { width: "100px" } }, [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      _vm._f("number0Digit")(
                                        line.inventory_bal_onhand_qty
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
                              style:
                                _vm.sel_daily == line.follow_date_format
                                  ? "background-color: #9AD9DB; vertical-align: middle;"
                                  : "vertical-align: middle;",
                              on: {
                                click: function($event) {
                                  return _vm.selDailyDate(
                                    line.follow_date_format
                                  )
                                }
                              }
                            },
                            [
                              _c("div", { staticStyle: { width: "100px" } }, [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      _vm._f("number0Digit")(
                                        _vm.balanceOnhandWeekly[
                                          line.follow_date
                                        ]
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
                              style:
                                _vm.sel_daily == line.follow_date_format
                                  ? "background-color: #9AD9DB; vertical-align: middle;"
                                  : "vertical-align: middle;",
                              on: {
                                click: function($event) {
                                  return _vm.selDailyDate(
                                    line.follow_date_format
                                  )
                                }
                              }
                            },
                            [
                              _c("div", { staticStyle: { width: "100px" } }, [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      _vm._f("number2Digit")(
                                        _vm.balanceOnhandRoll[line.follow_date]
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
                              style:
                                _vm.sel_daily == line.follow_date_format
                                  ? "background-color: #9AD9DB; vertical-align: middle;"
                                  : "vertical-align: middle;",
                              on: {
                                click: function($event) {
                                  return _vm.selDailyDate(
                                    line.follow_date_format
                                  )
                                }
                              }
                            },
                            [
                              _c("div", { staticStyle: { width: "100px" } }, [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      _vm._f("number2Digit")(
                                        _vm.balanceDays[line.follow_date]
                                      )
                                    ) +
                                    " "
                                )
                              ])
                            ]
                          )
                        ]
                      )
                    ]
                  }),
                  _vm._v(" "),
                  _c("tr", [
                    _vm._m(3),
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
                            staticClass: "tw-font-bold text-right",
                            staticStyle: { width: "100%" }
                          },
                          [
                            _vm._v(
                              "\n                                " +
                                _vm._s(
                                  _vm._f("number0Digit")(
                                    _vm.quantity.weekly_receive
                                  )
                                ) +
                                "\n                            "
                            )
                          ]
                        )
                      ]
                    ),
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
                            staticClass: "tw-font-bold text-right",
                            staticStyle: { width: "100%" }
                          },
                          [
                            _vm._v(
                              "\n                                " +
                                _vm._s(
                                  _vm._f("number2Digit")(
                                    _vm.quantity.roll_receive
                                  )
                                ) +
                                "\n                            "
                            )
                          ]
                        )
                      ]
                    ),
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
                            staticClass: "tw-font-bold text-right",
                            staticStyle: { width: "100%" }
                          },
                          [
                            _vm._v(
                              "\n                                " +
                                _vm._s(
                                  _vm._f("number2Digit")(
                                    _vm.quantity.total_receive
                                  )
                                ) +
                                "\n                            "
                            )
                          ]
                        )
                      ]
                    ),
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
                            staticClass: "tw-font-bold text-right",
                            staticStyle: { width: "100%" }
                          },
                          [
                            _vm._v(
                              "\n                                " +
                                _vm._s(
                                  _vm._f("number0Digit")(
                                    _vm.quantity.claim_receive
                                  )
                                ) +
                                "\n                            "
                            )
                          ]
                        )
                      ]
                    ),
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
                            staticClass: "tw-font-bold text-right",
                            staticStyle: { width: "100%" }
                          },
                          [
                            _vm._v(
                              "\n                                " +
                                _vm._s(
                                  _vm._f("number0Digit")(
                                    _vm.quantity.issue_receive
                                  )
                                ) +
                                "\n                            "
                            )
                          ]
                        )
                      ]
                    ),
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
                            staticClass: "tw-font-bold text-right",
                            staticStyle: { width: "100%" }
                          },
                          [
                            _vm._v(
                              "\n                                " +
                                _vm._s(
                                  _vm._f("number0Digit")(
                                    _vm.quantity.lost_receive
                                  )
                                ) +
                                "\n                            "
                            )
                          ]
                        )
                      ]
                    ),
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
                            staticClass: "tw-font-bold text-right",
                            staticStyle: { width: "100%" }
                          },
                          [
                            _vm._v(
                              "\n                                " +
                                _vm._s(
                                  _vm._f("number0Digit")(
                                    _vm.quantity.damaged_receive
                                  )
                                ) +
                                "\n                            "
                            )
                          ]
                        )
                      ]
                    ),
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
                            staticClass: "tw-font-bold text-right",
                            staticStyle: { width: "100%" }
                          },
                          [
                            _vm._v(
                              "\n                                " +
                                _vm._s(
                                  _vm._f("number0Digit")(
                                    _vm.quantity.incompleted_receive
                                  )
                                ) +
                                "\n                            "
                            )
                          ]
                        )
                      ]
                    ),
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
                            staticClass: "tw-font-bold text-right",
                            staticStyle: { width: "100%" }
                          },
                          [
                            _vm._v(
                              "\n                                " +
                                _vm._s(
                                  _vm._f("number0Digit")(
                                    _vm.quantity.total_issue_receive
                                  )
                                ) +
                                "\n                            "
                            )
                          ]
                        )
                      ]
                    ),
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
                            staticClass: "tw-font-bold text-right",
                            staticStyle: { width: "100%" }
                          },
                          [
                            _vm._v(
                              "\n                                " +
                                _vm._s(
                                  _vm._f("number0Digit")(
                                    _vm.quantity.total_daily_receive
                                  )
                                ) +
                                "\n                            "
                            )
                          ]
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c("td", {
                      staticClass: "text-right",
                      staticStyle: {
                        "vertical-align": "middle",
                        "background-color": "#b3b5b4"
                      },
                      attrs: { colspan: "6" }
                    })
                  ])
                ]
          ],
          2
        )
      ])
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-md-8" }, [
      _c("h2", { staticClass: "tw-font-bold" }, [
        _vm._v(" Stamp Daily Detail ")
      ])
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
            staticStyle: { "vertical-align": "middle" },
            attrs: { rowspan: "2" }
          },
          [_c("div", [_vm._v(" วันที่ ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" },
            attrs: { rowspan: "2" }
          },
          [_c("div", [_vm._v(" คงคลังเช้า "), _c("br"), _vm._v(" (ดวง) ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" },
            attrs: { colspan: "3" }
          },
          [_c("div", [_vm._v(" รับเข้า ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" },
            attrs: { rowspan: "2" }
          },
          [_c("div", [_vm._v(" รับแสตมป์เคลม ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" },
            attrs: { rowspan: "2" }
          },
          [_c("div", [_vm._v(" ใช้จริง "), _c("br"), _vm._v(" (ดวง) ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" },
            attrs: { rowspan: "2" }
          },
          [_c("div", [_vm._v(" สูญหาย "), _c("br"), _vm._v(" (ดวง) ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" },
            attrs: { rowspan: "2" }
          },
          [_c("div", [_vm._v(" เสียหาย "), _c("br"), _vm._v(" (ดวง) ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" },
            attrs: { rowspan: "2" }
          },
          [_c("div", [_vm._v(" ไม่สมบูรณ์ "), _c("br"), _vm._v(" (ดวง) ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" },
            attrs: { rowspan: "2" }
          },
          [_c("div", [_vm._v(" รวมใช้จริง "), _c("br"), _vm._v(" (ดวง) ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" },
            attrs: { rowspan: "2" }
          },
          [_c("div", [_vm._v(" ประมาณการใช้ "), _c("br"), _vm._v(" (ดวง) ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" },
            attrs: { colspan: "2" }
          },
          [_c("div", [_vm._v(" คงคลัง (ดวง) ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" },
            attrs: { colspan: "2" }
          },
          [_c("div", [_vm._v(" รวมคงคลังเย็น ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" },
            attrs: { rowspan: "2" }
          },
          [_c("div", [_vm._v(" พอใช้ "), _c("br"), _vm._v(" (วัน) ")])]
        )
      ]),
      _vm._v(" "),
      _c("tr", [
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" }
          },
          [_c("div", [_vm._v(" ดวง ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" }
          },
          [_c("div", [_vm._v(" ม้วน ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" }
          },
          [_c("div", [_vm._v(" จำนวนเงิน ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" }
          },
          [_c("div", [_vm._v(" ฝ่ายโรงงาน ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" }
          },
          [_c("div", [_vm._v(" กองคลัง ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" }
          },
          [_c("div", [_vm._v(" ดวง ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" }
          },
          [_c("div", [_vm._v(" ม้วน ")])]
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
          attrs: { colspan: "17" }
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
        staticClass: "text-right",
        staticStyle: { "vertical-align": "middle" },
        attrs: { colspan: "2" }
      },
      [_c("strong", [_vm._v(" รวม ")])]
    )
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab2.vue?vue&type=template&id=91a63c6e&":
/*!****************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab2.vue?vue&type=template&id=91a63c6e& ***!
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
    _c("div", { staticClass: "table-responsive" }, [
      _c("table", { staticClass: "table table-bordered" }, [
        _vm._m(0),
        _vm._v(" "),
        _c(
          "tbody",
          [
            _vm.lines.length <= 0
              ? [_vm._m(1)]
              : [
                  _vm._l(_vm.lines, function(line, index) {
                    return [
                      _c(
                        "tr",
                        {
                          style:
                            line.holiday_flag == "Y"
                              ? "background-color: #cccccc;"
                              : line.holiday_flag == "P"
                              ? "background-color: #878788;"
                              : ""
                        },
                        [
                          _c(
                            "td",
                            {
                              staticClass: "text-center",
                              style:
                                _vm.sel_daily == line.follow_date_format
                                  ? "background-color: #9AD9DB; vertical-align: middle;"
                                  : "vertical-align: middle;",
                              on: {
                                click: function($event) {
                                  return _vm.selDailyDate(
                                    line.follow_date_format
                                  )
                                }
                              }
                            },
                            [
                              _c("div", { staticStyle: { width: "80px" } }, [
                                _vm._v(
                                  " " + _vm._s(line.follow_date_format) + " "
                                )
                              ])
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "td",
                            {
                              staticClass: "text-right",
                              style:
                                _vm.sel_daily == line.follow_date_format
                                  ? "background-color: #9AD9DB; vertical-align: middle;"
                                  : "vertical-align: middle;",
                              on: {
                                click: function($event) {
                                  return _vm.selDailyDate(
                                    line.follow_date_format
                                  )
                                }
                              }
                            },
                            [
                              _c("div", { staticStyle: { width: "100px" } }, [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      _vm._f("number2Digit")(line.onhand_qty)
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
                              style:
                                _vm.sel_daily == line.follow_date_format
                                  ? "background-color: #9AD9DB;"
                                  : "",
                              on: {
                                click: function($event) {
                                  return _vm.selDailyDate(
                                    line.follow_date_format
                                  )
                                }
                              }
                            },
                            [
                              _c("div", { staticStyle: { width: "100px" } }, [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      _vm._f("number2Digit")(
                                        line.weekly_receive_qty
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
                              style:
                                _vm.sel_daily == line.follow_date_format
                                  ? "background-color: #9AD9DB;"
                                  : "",
                              on: {
                                click: function($event) {
                                  return _vm.selDailyDate(
                                    line.follow_date_format
                                  )
                                }
                              }
                            },
                            [
                              _c("div", { staticStyle: { width: "100px" } }, [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      _vm._f("number2Digit")(
                                        line.receive_roll_qty
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
                              style:
                                _vm.sel_daily == line.follow_date_format
                                  ? "background-color: #9AD9DB; vertical-align: middle;"
                                  : "vertical-align: middle;",
                              on: {
                                click: function($event) {
                                  return _vm.selDailyDate(
                                    line.follow_date_format
                                  )
                                }
                              }
                            },
                            [
                              _c("div", { staticStyle: { width: "130px" } }, [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      _vm._f("number2Digit")(
                                        line.receipt_amount
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
                              style:
                                _vm.sel_daily == line.follow_date_format
                                  ? "background-color: #9AD9DB; vertical-align: middle;"
                                  : "vertical-align: middle;",
                              on: {
                                click: function($event) {
                                  return _vm.selDailyDate(
                                    line.follow_date_format
                                  )
                                }
                              }
                            },
                            [
                              _c("div", { staticStyle: { width: "100px" } }, [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      _vm._f("number0Digit")(
                                        line.claim_receive_qty
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
                              style:
                                _vm.sel_daily == line.follow_date_format
                                  ? "background-color: #9AD9DB; vertical-align: middle;"
                                  : "vertical-align: middle;",
                              on: {
                                click: function($event) {
                                  return _vm.selDailyDate(
                                    line.follow_date_format
                                  )
                                }
                              }
                            },
                            [
                              _c("div", { staticStyle: { width: "100px" } }, [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      _vm._f("number0Digit")(line.issue_qty)
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
                              style:
                                _vm.sel_daily == line.follow_date_format
                                  ? "background-color: #9AD9DB; vertical-align: middle;"
                                  : "vertical-align: middle;",
                              on: {
                                click: function($event) {
                                  return _vm.selDailyDate(
                                    line.follow_date_format
                                  )
                                }
                              }
                            },
                            [
                              _c("div", { staticStyle: { width: "100px" } }, [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      _vm._f("number0Digit")(line.lost_qty)
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
                              style:
                                _vm.sel_daily == line.follow_date_format
                                  ? "background-color: #9AD9DB; vertical-align: middle;"
                                  : "vertical-align: middle;",
                              on: {
                                click: function($event) {
                                  return _vm.selDailyDate(
                                    line.follow_date_format
                                  )
                                }
                              }
                            },
                            [
                              _c("div", { staticStyle: { width: "100px" } }, [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      _vm._f("number0Digit")(line.damaged_qty)
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
                              style:
                                _vm.sel_daily == line.follow_date_format
                                  ? "background-color: #9AD9DB; vertical-align: middle;"
                                  : "vertical-align: middle;",
                              on: {
                                click: function($event) {
                                  return _vm.selDailyDate(
                                    line.follow_date_format
                                  )
                                }
                              }
                            },
                            [
                              _c("div", { staticStyle: { width: "100px" } }, [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      _vm._f("number0Digit")(
                                        line.incompleted_qty
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
                              style:
                                _vm.sel_daily == line.follow_date_format
                                  ? "background-color: #9AD9DB; vertical-align: middle;"
                                  : "vertical-align: middle;",
                              on: {
                                click: function($event) {
                                  return _vm.selDailyDate(
                                    line.follow_date_format
                                  )
                                }
                              }
                            },
                            [
                              _c("div", { staticStyle: { width: "100px" } }, [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      _vm._f("number0Digit")(
                                        line.total_issue_qty
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
                              style:
                                _vm.sel_daily == line.follow_date_format
                                  ? "background-color: #9AD9DB; vertical-align: middle;"
                                  : "vertical-align: middle;",
                              on: {
                                click: function($event) {
                                  return _vm.selDailyDate(
                                    line.follow_date_format
                                  )
                                }
                              }
                            },
                            [
                              _c("div", { staticStyle: { width: "100px" } }, [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      _vm._f("number0Digit")(
                                        line.total_daily_qty
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
                              style:
                                _vm.sel_daily == line.follow_date_format
                                  ? "background-color: #9AD9DB; vertical-align: middle;"
                                  : "vertical-align: middle;",
                              on: {
                                click: function($event) {
                                  return _vm.selDailyDate(
                                    line.follow_date_format
                                  )
                                }
                              }
                            },
                            [
                              _c("div", { staticStyle: { width: "100px" } }, [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      _vm._f("number0Digit")(
                                        line.factory_bal_onhand_qty
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
                              style:
                                _vm.sel_daily == line.follow_date_format
                                  ? "background-color: #9AD9DB; vertical-align: middle;"
                                  : "vertical-align: middle;",
                              on: {
                                click: function($event) {
                                  return _vm.selDailyDate(
                                    line.follow_date_format
                                  )
                                }
                              }
                            },
                            [
                              _c("div", { staticStyle: { width: "100px" } }, [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      _vm._f("number0Digit")(
                                        line.inventory_bal_onhand_qty
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
                              style:
                                _vm.sel_daily == line.follow_date_format
                                  ? "background-color: #9AD9DB; vertical-align: middle;"
                                  : "vertical-align: middle;",
                              on: {
                                click: function($event) {
                                  return _vm.selDailyDate(
                                    line.follow_date_format
                                  )
                                }
                              }
                            },
                            [
                              _c("div", { staticStyle: { width: "100px" } }, [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      _vm._f("number0Digit")(
                                        line.total_bal_onhand_qty
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
                              style:
                                _vm.sel_daily == line.follow_date_format
                                  ? "background-color: #9AD9DB; vertical-align: middle;"
                                  : "vertical-align: middle;",
                              on: {
                                click: function($event) {
                                  return _vm.selDailyDate(
                                    line.follow_date_format
                                  )
                                }
                              }
                            },
                            [
                              _c("div", { staticStyle: { width: "100px" } }, [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      _vm._f("number2Digit")(
                                        line.bal_onhand_qty
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
                              style:
                                _vm.sel_daily == line.follow_date_format
                                  ? "background-color: #9AD9DB; vertical-align: middle;"
                                  : "vertical-align: middle;",
                              on: {
                                click: function($event) {
                                  return _vm.selDailyDate(
                                    line.follow_date_format
                                  )
                                }
                              }
                            },
                            [
                              _c("div", { staticStyle: { width: "100px" } }, [
                                _vm._v(
                                  " " +
                                    _vm._s(
                                      _vm._f("number2Digit")(line.bal_days)
                                    ) +
                                    " "
                                )
                              ])
                            ]
                          )
                        ]
                      )
                    ]
                  }),
                  _vm._v(" "),
                  _c("tr", [
                    _vm._m(2),
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
                            staticClass: "tw-font-bold text-right",
                            staticStyle: { width: "100%" }
                          },
                          [
                            _vm._v(
                              "\n                                " +
                                _vm._s(
                                  _vm._f("number2Digit")(
                                    _vm.quantity.weekly_receive
                                  )
                                ) +
                                "\n                            "
                            )
                          ]
                        )
                      ]
                    ),
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
                            staticClass: "tw-font-bold text-right",
                            staticStyle: { width: "100%" }
                          },
                          [
                            _vm._v(
                              "\n                                " +
                                _vm._s(
                                  _vm._f("number2Digit")(
                                    _vm.quantity.roll_receive
                                  )
                                ) +
                                "\n                            "
                            )
                          ]
                        )
                      ]
                    ),
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
                            staticClass: "tw-font-bold text-right",
                            staticStyle: { width: "100%" }
                          },
                          [
                            _vm._v(
                              "\n                                " +
                                _vm._s(
                                  _vm._f("number2Digit")(
                                    _vm.quantity.total_receive
                                  )
                                ) +
                                "\n                            "
                            )
                          ]
                        )
                      ]
                    ),
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
                            staticClass: "tw-font-bold text-right",
                            staticStyle: { width: "100%" }
                          },
                          [
                            _vm._v(
                              "\n                                " +
                                _vm._s(
                                  _vm._f("number0Digit")(
                                    _vm.quantity.claim_receive
                                  )
                                ) +
                                "\n                            "
                            )
                          ]
                        )
                      ]
                    ),
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
                            staticClass: "tw-font-bold text-right",
                            staticStyle: { width: "100%" }
                          },
                          [
                            _vm._v(
                              "\n                                " +
                                _vm._s(
                                  _vm._f("number0Digit")(
                                    _vm.quantity.issue_receive
                                  )
                                ) +
                                "\n                            "
                            )
                          ]
                        )
                      ]
                    ),
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
                            staticClass: "tw-font-bold text-right",
                            staticStyle: { width: "100%" }
                          },
                          [
                            _vm._v(
                              "\n                                " +
                                _vm._s(
                                  _vm._f("number0Digit")(
                                    _vm.quantity.lost_receive
                                  )
                                ) +
                                "\n                            "
                            )
                          ]
                        )
                      ]
                    ),
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
                            staticClass: "tw-font-bold text-right",
                            staticStyle: { width: "100%" }
                          },
                          [
                            _vm._v(
                              "\n                                " +
                                _vm._s(
                                  _vm._f("number0Digit")(
                                    _vm.quantity.damaged_receive
                                  )
                                ) +
                                "\n                            "
                            )
                          ]
                        )
                      ]
                    ),
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
                            staticClass: "tw-font-bold text-right",
                            staticStyle: { width: "100%" }
                          },
                          [
                            _vm._v(
                              "\n                                " +
                                _vm._s(
                                  _vm._f("number0Digit")(
                                    _vm.quantity.incompleted_receive
                                  )
                                ) +
                                "\n                            "
                            )
                          ]
                        )
                      ]
                    ),
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
                            staticClass: "tw-font-bold text-right",
                            staticStyle: { width: "100%" }
                          },
                          [
                            _vm._v(
                              "\n                                " +
                                _vm._s(
                                  _vm._f("number0Digit")(
                                    _vm.quantity.total_issue_receive
                                  )
                                ) +
                                "\n                            "
                            )
                          ]
                        )
                      ]
                    ),
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
                            staticClass: "tw-font-bold text-right",
                            staticStyle: { width: "100%" }
                          },
                          [
                            _vm._v(
                              "\n                                " +
                                _vm._s(
                                  _vm._f("number0Digit")(
                                    _vm.quantity.total_daily_receive
                                  )
                                ) +
                                "\n                            "
                            )
                          ]
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c("td", {
                      staticClass: "text-right",
                      staticStyle: {
                        "vertical-align": "middle",
                        "background-color": "#b3b5b4"
                      },
                      attrs: { colspan: "6" }
                    })
                  ])
                ]
          ],
          2
        )
      ])
    ])
  ])
}
var staticRenderFns = [
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
            staticStyle: { "vertical-align": "middle" },
            attrs: { rowspan: "2" }
          },
          [_c("div", [_vm._v(" วันที่ ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" },
            attrs: { rowspan: "2" }
          },
          [_c("div", [_vm._v(" คงคลังเช้า "), _c("br"), _vm._v(" (ดวง) ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" },
            attrs: { colspan: "3" }
          },
          [_c("div", [_vm._v(" รับเข้า ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" },
            attrs: { rowspan: "2" }
          },
          [_c("div", [_vm._v(" รับแสตมป์เคลม ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" },
            attrs: { rowspan: "2" }
          },
          [_c("div", [_vm._v(" ใช้จริง "), _c("br"), _vm._v(" (ดวง) ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" },
            attrs: { rowspan: "2" }
          },
          [_c("div", [_vm._v(" สูญหาย "), _c("br"), _vm._v(" (ดวง) ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" },
            attrs: { rowspan: "2" }
          },
          [_c("div", [_vm._v(" เสียหาย "), _c("br"), _vm._v(" (ดวง) ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" },
            attrs: { rowspan: "2" }
          },
          [_c("div", [_vm._v(" ไม่สมบูรณ์ "), _c("br"), _vm._v(" (ดวง) ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" },
            attrs: { rowspan: "2" }
          },
          [_c("div", [_vm._v(" รวมใช้จริง "), _c("br"), _vm._v(" (ดวง) ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" },
            attrs: { rowspan: "2" }
          },
          [_c("div", [_vm._v(" ประมาณการใช้ "), _c("br"), _vm._v(" (ดวง) ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" },
            attrs: { colspan: "2" }
          },
          [_c("div", [_vm._v(" คงคลัง (ดวง) ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" },
            attrs: { colspan: "2" }
          },
          [_c("div", [_vm._v(" รวมคงคลังเย็น ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" },
            attrs: { rowspan: "2" }
          },
          [_c("div", [_vm._v(" พอใช้ "), _c("br"), _vm._v(" (วัน) ")])]
        )
      ]),
      _vm._v(" "),
      _c("tr", [
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" }
          },
          [_c("div", [_vm._v(" ดวง ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" }
          },
          [_c("div", [_vm._v(" ม้วน ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" }
          },
          [_c("div", [_vm._v(" จำนวนเงิน ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" }
          },
          [_c("div", [_vm._v(" ฝ่ายโรงงาน ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" }
          },
          [_c("div", [_vm._v(" กองคลัง ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" }
          },
          [_c("div", [_vm._v(" ดวง ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle" }
          },
          [_c("div", [_vm._v(" ม้วน ")])]
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
          attrs: { colspan: "17" }
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
        staticClass: "text-right",
        staticStyle: { "vertical-align": "middle" },
        attrs: { colspan: "2" }
      },
      [_c("strong", [_vm._v(" รวม ")])]
    )
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab3.vue?vue&type=template&id=918a0d6c&":
/*!****************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/StampDailyTableTab3.vue?vue&type=template&id=918a0d6c& ***!
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
  return _c(
    "div",
    [
      _c(
        "div",
        {
          staticClass:
            "form-group pl-2 pr-2 m-0 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right"
        },
        [
          _c(
            "button",
            {
              class: _vm.btnTrans.upload.class + " btn-lg tw-w-25",
              attrs: { type: "button" },
              on: {
                click: function($event) {
                  $event.preventDefault()
                  return _vm.getStampDailyTab3($event)
                }
              }
            },
            [_vm._v("\n            อัพเดตข้อมูลรายการ PR\n        ")]
          )
        ]
      ),
      _vm._v(" "),
      _c("div", { staticClass: "hr-line-dashed mt-3" }),
      _vm._v(" "),
      _vm.loading
        ? _c("div", { staticClass: "m-t-lg m-b-lg" }, [_vm._m(0)])
        : [
            _c("div", { staticClass: "table-responsive" }, [
              _c("table", { staticClass: "table table-bordered" }, [
                _vm._m(1),
                _vm._v(" "),
                _c(
                  "tbody",
                  [
                    _vm.lines.length <= 0
                      ? [_vm._m(2)]
                      : [
                          _vm._l(_vm.lines, function(line, index) {
                            return [
                              _c("tr", { key: index + "_" + line.pr_number }, [
                                _c("td", { staticClass: "text-center" }, [
                                  _vm._v(
                                    "\n                                    " +
                                      _vm._s(line.pr_create_date_format) +
                                      "\n                                "
                                  )
                                ]),
                                _vm._v(" "),
                                _c("td", { staticClass: "text-center" }, [
                                  _vm._v(
                                    "\n                                    " +
                                      _vm._s(line.need_by_date_format) +
                                      "\n                                "
                                  )
                                ]),
                                _vm._v(" "),
                                _c("td", { staticClass: "text-center" }, [
                                  _vm._v(
                                    "\n                                    " +
                                      _vm._s(line.pr_number) +
                                      "\n                                "
                                  )
                                ]),
                                _vm._v(" "),
                                _c("td", { staticClass: "text-center" }, [
                                  _c("span", {
                                    domProps: {
                                      innerHTML: _vm._s(line.status_lable_html)
                                    }
                                  })
                                ]),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  { staticClass: "text-center" },
                                  [
                                    _vm._l(_vm.poMaps, function(po, index) {
                                      return [
                                        line.pr_number == po.pr_number
                                          ? [
                                              _vm._v(
                                                "\n                                                " +
                                                  _vm._s(po.po_number) +
                                                  "\n                                            "
                                              )
                                            ]
                                          : _vm._e()
                                      ]
                                    })
                                  ],
                                  2
                                ),
                                _vm._v(" "),
                                _c("td", { staticClass: "text-left" }, [
                                  _vm._v(
                                    "\n                                    " +
                                      _vm._s(line.cancelled_reason_pr) +
                                      "\n                                "
                                  )
                                ]),
                                _vm._v(" "),
                                _c("td", { staticClass: "text-left" }, [
                                  _vm._v(
                                    "\n                                    " +
                                      _vm._s(
                                        line.interface_msg
                                          ? line.interface_msg +
                                              " กรุณาติดต่อทาง IT เพื่อทำการตรวจสอบเพิ่มเติม"
                                          : ""
                                      ) +
                                      "\n                                "
                                  )
                                ]),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  { staticClass: "text-center" },
                                  [
                                    _c("submit-pr-transaction", {
                                      key: index + line.pr_number,
                                      attrs: {
                                        index: index,
                                        header: _vm.header,
                                        line: line,
                                        poLists: _vm.poLists,
                                        btnTrans: _vm.btnTrans,
                                        url: _vm.url
                                      },
                                      on: {
                                        updateInterfacePR: _vm.updateInterfacePR
                                      }
                                    })
                                  ],
                                  1
                                )
                              ])
                            ]
                          })
                        ]
                  ],
                  2
                )
              ])
            ])
          ]
    ],
    2
  )
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
    return _c("thead", [
      _c("tr", [
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle", width: "8%" }
          },
          [_c("div", [_vm._v(" วันที่ส่งข้อมูล ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle", width: "8%" }
          },
          [_c("div", [_vm._v(" วันที่จัดซื้อ ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle", width: "10%" }
          },
          [_c("div", [_vm._v(" เลขที่รายการ PR ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle", width: "10%" }
          },
          [_c("div", [_vm._v(" สถานะรายการ PR ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle", width: "10%" }
          },
          [_c("div", [_vm._v(" เลขที่รายการ PO ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle", width: "15%" }
          },
          [_c("div", [_vm._v(" เหตุผลการยกเลิก PR ")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "vertical-align": "middle", width: "15%" }
          },
          [_c("div", [_vm._v(" ข้อผิดพลาดการส่งข้อมูล ")])]
        ),
        _vm._v(" "),
        _c("th", {
          staticClass: "text-center",
          staticStyle: { "vertical-align": "middle", width: "15%" }
        })
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
          attrs: { colspan: "8" }
        },
        [_c("h2", [_vm._v(" ไม่พบข้อมูลที่ค้นหาในระบบ ")])]
      )
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/SubmitPRTransaction.vue?vue&type=template&id=74100810&":
/*!****************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Stamp-follow/components/SubmitPRTransaction.vue?vue&type=template&id=74100810& ***!
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
  return _c(
    "span",
    [
      !_vm.validReport
        ? [
            _c(
              "a",
              {
                class: _vm.btnTrans.print.class + " btn-sm",
                attrs: {
                  href:
                    _vm.url.ajax_print_report_pr +
                    "?pr_number=" +
                    _vm.line.pr_number,
                  target: "_blank",
                  type: "button"
                }
              },
              [
                _c("i", { class: _vm.btnTrans.print.icon }),
                _vm._v(" พิมพ์รายงาน\n        ")
              ]
            )
          ]
        : [
            _c(
              "a",
              {
                class: _vm.btnTrans.print.class + " btn-sm",
                staticStyle: { color: "white" },
                attrs: { type: "button", disabled: "" }
              },
              [
                _c("i", { class: _vm.btnTrans.print.icon }),
                _vm._v(" พิมพ์รายงาน\n        ")
              ]
            )
          ],
      _vm._v(" "),
      _c(
        "button",
        {
          class: _vm.btnTrans.cancel.class + " btn-sm",
          attrs: { type: "button", disabled: _vm.valid },
          on: {
            click: function($event) {
              return _vm.cancelPRModal()
            }
          }
        },
        [
          _c("i", { class: _vm.btnTrans.cancel.icon }),
          _vm._v(" " + _vm._s(_vm.btnTrans.cancel.text) + "\n    ")
        ]
      ),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass: "modal fade",
          attrs: {
            id: "modal_cancel_pr" + _vm.index,
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
                _vm._m(0),
                _vm._v(" "),
                _c("div", { staticClass: "modal-body text-left" }, [
                  _c("form", { attrs: { id: "cancel-pr-form" + _vm.index } }, [
                    _c("div", { staticClass: "row col-12 m-0" }, [
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
                            [_vm._v(" เหตุผลการยกเลิก :")]
                          ),
                          _vm._v(" "),
                          _c(
                            "div",
                            { staticClass: "input-group mb-2" },
                            [
                              _c("el-input", {
                                ref: "cancelled_reason",
                                attrs: {
                                  type: "textarea",
                                  rows: 3,
                                  placeholder: "เหตุผลการยกเลิก"
                                },
                                model: {
                                  value: _vm.cancelled_reason,
                                  callback: function($$v) {
                                    _vm.cancelled_reason = $$v
                                  },
                                  expression: "cancelled_reason"
                                }
                              })
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c("div", {
                            staticClass: "error_msg text-left",
                            attrs: {
                              id: "el_explode_cancelled_reason" + _vm.index
                            }
                          })
                        ]
                      )
                    ])
                  ])
                ]),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    staticClass: "modal-footer p-2",
                    staticStyle: { "justify-content": "right !important" }
                  },
                  [
                    _c(
                      "button",
                      {
                        class: _vm.btnTrans.create.class + " btn-lg tw-w-25",
                        attrs: { type: "button" },
                        on: {
                          click: function($event) {
                            $event.preventDefault()
                            return _vm.cancelInterfacePR()
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
                        attrs: { type: "button", "data-dismiss": "modal" }
                      },
                      [_vm._v(" ยกเลิก ")]
                    )
                  ]
                )
              ]
            )
          ])
        ]
      )
    ],
    2
  )
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
            "\n                        เหตุผลการยกเลิก\n                    "
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



/***/ })

}]);