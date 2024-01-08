(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_Planning_Production-Yearly_ShowComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/ModalCreate.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/ModalCreate.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************************************************************/
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

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["defaultYear", "defaultWorkingHour", "btnTrans", "url"],
  components: {
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_1___default())
  },
  data: function data() {
    return {
      budget_year: this.defaultYear ? this.defaultYear : '',
      times: '',
      loading: false,
      timeLoading: false,
      errors: {
        budget_year: false,
        begin_onhand: false,
        per_loss: false
      },
      biWeeklyLists: [],
      html: '',
      // New Requirement 03082022
      begin_onhand: '',
      per_loss: '',
      working_hour: this.defaultWorkingHour ? this.defaultWorkingHour : '' //defualt จาก Header P01

    };
  },
  mounted: function mounted() {//
  },
  computed: {},
  watch: {
    errors: {
      handler: function handler(val) {
        val.budget_year ? this.setError('budget_year') : this.resetError('budget_year');
      },
      deep: true
    }
  },
  methods: {
    openModal: function openModal() {
      $('#modal_create').modal('show');
      this.getBiWeekly();
    },
    getBiWeekly: function getBiWeekly() {
      this.times = '';
      this.budget_year = this.defaultYear ? this.defaultYear : '', this.getDetail();
    },
    getDetail: function getDetail() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                vm = _this;
                vm.times = 1;
                vm.html = '';
                vm.timeLoading = true;
                axios.get(vm.url.ajax_modal_create_details, {
                  params: {
                    budget_year: vm.budget_year
                  }
                }).then(function (res) {
                  var response = res.data.data;
                  vm.times = response.times;
                  vm.html = response.html;
                  vm.timeLoading = false;
                });

              case 5:
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
    submit: function submit() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var vm, form, inputs, valid, errorMsg, res;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                vm = _this2;
                form = $('#modal_create');
                inputs = form.serialize();
                valid = true;
                errorMsg = '';
                _this2.errors.budget_year = false;
                _this2.errors.begin_onhand = false;
                _this2.errors.per_loss = false;
                $(form).find("div[id='el_explode_budget_year']").html("");
                $(form).find("div[id='el_explode_begin_onhand']").html("");
                $(form).find("div[id='el_explode_per_loss']").html("");

                if (_this2.budget_year == '') {
                  _this2.errors.budget_year = true;
                  valid = false;
                  errorMsg = "กรุณาเลือกปีงบประมาณ";
                  $(form).find("div[id='el_explode_budget_year']").html(errorMsg);
                }

                if (_this2.begin_onhand == '') {
                  _this2.errors.begin_onhand = true;
                  valid = false;
                  errorMsg = "กรุณาระบุคงคลังต้นปีงบประมาณเพียงพอ";
                  $(form).find("div[id='el_explode_begin_onhand']").html(errorMsg);
                }

                if (_this2.per_loss == '') {
                  _this2.errors.per_loss = true;
                  valid = false;
                  errorMsg = "กรุณาระบุเปอร์เซ็นต์สูญเสีย";
                  $(form).find("div[id='el_explode_per_loss']").html(errorMsg);
                }

                if (valid) {
                  _context2.next = 16;
                  break;
                }

                return _context2.abrupt("return");

              case 16:
                _context2.next = 18;
                return _this2.create();

              case 18:
                res = _context2.sent;
                vm.loading = false;

                if (res.status == 'S') {
                  swal({
                    title: 'สร้างแผนประมาณการผลิต',
                    text: '<span style="font-size: 16px; text-align: left;"> ทำการสร้างข้อมูลแผนประมาณการผลิตรายปีเรียบร้อยแล้ว </span>',
                    type: "success",
                    html: true
                  }); //redirect

                  window.setTimeout(function () {
                    window.location.href = res.redirect_show_page;
                  }, 2000);
                } else {
                  swal({
                    title: 'มีข้อผิดพลาด',
                    text: '<span style="font-size: 16px; text-align: left;">' + res.msg + '</span>',
                    type: "error",
                    html: true
                  });
                }

              case 21:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    create: function create() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var vm2, data, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                console.log('--S--');
                vm2 = _this3;
                data = [];
                params = {
                  budget_year: vm2.budget_year,
                  begin_onhand: vm2.begin_onhand,
                  per_loss: vm2.per_loss,
                  working_hour: vm2.working_hour
                };
                vm2.loading = true;
                console.log('--S1--');
                _context3.next = 8;
                return axios.post(vm2.url.ajax_production_yearly_store, params).then(function (res) {
                  console.log(res);
                  data = res.data.data;
                })["catch"](function (err) {
                  var msg = err.response.data.data;
                  swal({
                    title: 'มีข้อผิดพลาด',
                    text: msg,
                    type: "error"
                  });
                }).then(function () {
                  vm2.loading = false;
                });

              case 8:
                console.log('--E--');
                return _context3.abrupt("return", data);

              case 10:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/ModalSearch.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/ModalSearch.vue?vue&type=script&lang=js& ***!
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
//
//
//
//
//
//
//
//
//
//
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
  props: ['budgetYears', 'search', 'defaultYear', 'productTypes', "btnTrans", "url"],
  data: function data() {
    return {
      budget_year: this.search.length ? this.search['budget_year'] : String(this.defaultYear),
      times: '',
      loading: false,
      errors: {
        budget_year: false
      },
      html: ''
    };
  },
  mounted: function mounted() {//
  },
  computed: {},
  watch: {
    errors: {
      handler: function handler(val) {
        val.budget_year ? this.setError('budget_year') : this.resetError('budget_year');
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
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                vm = _this;
                vm.loading = true;
                _context.next = 4;
                return axios.get(vm.url.ajax_production_yearly_search, {
                  params: {
                    search: {
                      budget_year: vm.budget_year
                    }
                  }
                }).then(function (res) {
                  vm.html = res.data.data.html;
                })["catch"](function (err) {
                  vm.html = '';
                  var data = err.response.data;
                  alert(data.message);
                }).then(function () {
                  vm.loading = false;
                });

              case 4:
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/ShowComponent.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/ShowComponent.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _ModalCreate_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalCreate.vue */ "./resources/js/components/Planning/Production-Yearly/ModalCreate.vue");
/* harmony import */ var _ModalSearch_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ModalSearch.vue */ "./resources/js/components/Planning/Production-Yearly/ModalSearch.vue");
/* harmony import */ var _components_HeaderDetail_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./components/HeaderDetail.vue */ "./resources/js/components/Planning/Production-Yearly/components/HeaderDetail.vue");
/* harmony import */ var _components_Tab1_vue__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./components/Tab1.vue */ "./resources/js/components/Planning/Production-Yearly/components/Tab1.vue");
/* harmony import */ var _components_Tab2_vue__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./components/Tab2.vue */ "./resources/js/components/Planning/Production-Yearly/components/Tab2.vue");
/* harmony import */ var _components_Tab3_vue__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./components/Tab3.vue */ "./resources/js/components/Planning/Production-Yearly/components/Tab3.vue");


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






/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    ModalCreate: _ModalCreate_vue__WEBPACK_IMPORTED_MODULE_1__.default,
    ModalSearch: _ModalSearch_vue__WEBPACK_IMPORTED_MODULE_2__.default,
    HeaderDetail: _components_HeaderDetail_vue__WEBPACK_IMPORTED_MODULE_3__.default,
    Tab1: _components_Tab1_vue__WEBPACK_IMPORTED_MODULE_4__.default,
    Tab2: _components_Tab2_vue__WEBPACK_IMPORTED_MODULE_5__.default,
    Tab3: _components_Tab3_vue__WEBPACK_IMPORTED_MODULE_6__.default
  },
  props: ["prodYearly", "modalCreateInput", "modalSearchInput", "yearlyColorCode", "machineEfficiencyProd", "pDateFormat", "productTypes", "workingHour", "pDefaultInput", "btnTrans", "url"],
  data: function data() {
    return {
      loading: {
        approveProcess: false,
        copyProcess: false
      },
      prodYearlyMain: this.prodYearly,
      defaultInput: this.pDefaultInput != undefined && this.pDefaultInput != '' ? this.pDefaultInput : null,
      lastUpdateDateFormat: '',
      selTabName: 'tab1',
      refreshTab1: 0,
      refreshTab2: 0,
      refreshTab3: 0,
      canEdit: false,
      canApprove: false,
      beginOnhandQtyChangeData: {},
      totalQtyChangeData: {},
      totalPlanChangeData: {},
      summaryPlanning: []
    };
  },
  mounted: function mounted() {
    if (this.prodYearlyMain != undefined && this.prodYearlyMain != '') {
      this.canEdit = this.prodYearlyMain.can.edit;
      this.canApprove = this.prodYearlyMain.can.approve;
    }

    if (this.prodYearlyMain != undefined && this.prodYearlyMain != '') {
      this.setLastUpdateDateFormat(this.prodYearlyMain.last_update_date_format);
    }
  },
  computed: {},
  watch: {
    selTabName: function () {
      var _selTabName = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee(value, oldValue) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                if (value == 'tab1') {
                  this.refreshTab1 = this.refreshTab1 + 1;
                  this.beginOnhandQtyChangeData = {};
                  this.totalQtyChangeData = {};
                  this.totalPlanChangeData = {};
                }

                if (value == 'tab2') {
                  this.refreshTab2 = this.refreshTab2 + 1;
                  this.beginOnhandQtyChangeData = {};
                  this.totalQtyChangeData = {};
                  this.totalPlanChangeData = {};
                }

                if (value == 'tab3') {
                  this.refreshTab3 = this.refreshTab3 + 1;
                  this.beginOnhandQtyChangeData = {};
                  this.totalQtyChangeData = {};
                  this.totalPlanChangeData = {};
                }

              case 3:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this);
      }));

      function selTabName(_x, _x2) {
        return _selTabName.apply(this, arguments);
      }

      return selTabName;
    }()
  },
  methods: {
    setLastUpdateDateFormat: function setLastUpdateDateFormat(value) {
      this.lastUpdateDateFormat = value;
    },
    saveTab2EstChange: function saveTab2EstChange() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var vm, swalConfirm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                vm = _this;

                if (vm.canEdit) {
                  _context3.next = 3;
                  break;
                }

                return _context3.abrupt("return");

              case 3:
                if (!(Object.keys(vm.beginOnhandQtyChangeData).length == 0 && Object.keys(vm.totalPlanChangeData).length == 0)) {
                  _context3.next = 6;
                  break;
                }

                swal({
                  title: 'อัพเดทแผนการผลิตประจำปี',
                  text: '<span style="font-size: 16px; text-align: left;"> ไม่พบข้อมูลการอัพเดท </span>',
                  type: "warning",
                  html: true
                });
                return _context3.abrupt("return");

              case 6:
                swalConfirm = swal({
                  html: true,
                  title: 'อัพเดทแผนการผลิตประจำปี ?',
                  text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการอัพเดทแผนการผลิตประจำปี ? </span></h2>',
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
                    var params;
                    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
                      while (1) {
                        switch (_context2.prev = _context2.next) {
                          case 0:
                            if (!isConfirm) {
                              _context2.next = 4;
                              break;
                            }

                            params = {
                              product_type: vm.defaultInput.product_type,
                              begin_onhand_qty_data: vm.beginOnhandQtyChangeData,
                              total_qty_data: vm.totalQtyChangeData,
                              total_plan_data: vm.totalPlanChangeData,
                              summaryPlanning: vm.summaryPlanning
                            };
                            _context2.next = 4;
                            return axios.patch(vm.url.ajax_production_yearly_update, {
                              params: params
                            }).then(function (res) {
                              if (res.data.data.status == 'S') {
                                swal({
                                  title: 'อัพเดทแผนการผลิตประจำปี',
                                  text: '<span style="font-size: 16px; text-align: left;"> อัพเดทแผนการผลิตประจำปีสำเร็จ </span>',
                                  type: "success",
                                  html: true
                                });
                                vm.setLastUpdateDateFormat(res.data.data.last_update_date);
                                vm.beginOnhandQtyChangeData = {};
                                vm.totalQtyChangeData = {};
                                vm.totalPlanChangeData = {};

                                if (vm.selTabName == 'tab2') {
                                  vm.refreshTab2 = vm.refreshTab2 + 1;
                                }
                              }

                              if (res.data.data.status != 'S') {
                                swal({
                                  title: "มีข้อผิดพลาด",
                                  text: '<span style="font-size: 16px; text-align: left;">' + res.data.data.msg + '</span>',
                                  type: "warning",
                                  showConfirmButton: true,
                                  html: true
                                });
                              }
                            })["catch"](function (err) {
                              var data = err.response.data;
                              alert(data.message);
                            }).then(function () {// swal.close();
                            });

                          case 4:
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

              case 7:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    // Approve
    checkApprove: function checkApprove() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        var vm, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                vm = _this2; // if (Object.keys(vm.beginOnhandQtyChangeData).length > 0 || Object.keys(vm.totalQtyChangeData).length > 0) {
                //     swal({
                //         title: 'อนุมัติประมาณการผลิตประจำปี',
                //         text: '<span style="font-size: 16px; text-align: left;"> ไม่สามารถทำการอนุมัติประมาณการผลิตประจำปี เนื่องจากมีรายการที่แก้ไขอยู่ กรุณาตรวจสอบ </span>',
                //         type: "warning",
                //         html: true
                //     });
                //     return;
                // }

                if (vm.canApprove) {
                  _context5.next = 3;
                  break;
                }

                return _context5.abrupt("return");

              case 3:
                vm.loading.approveProcess = true;
                params = {
                  summaryPlanning: vm.summaryPlanning
                };
                _context5.next = 7;
                return axios.get(vm.url.ajax_check_approve, {
                  params: params
                }).then(function (res) {
                  if (res.data.data.status == 'S') {
                    swal({
                      html: true,
                      title: 'อนุมัติประมาณการผลิตประจำปี',
                      text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการอนุมัติประมาณการผลิตประจำปี? </span></h2>',
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
                                if (isConfirm) {
                                  vm.approve();
                                }

                              case 1:
                              case "end":
                                return _context4.stop();
                            }
                          }
                        }, _callee4);
                      }));

                      return function (_x4) {
                        return _ref2.apply(this, arguments);
                      };
                    }());
                  } else {
                    swal({
                      title: 'ข้อผิดพลาด',
                      text: '<span style="font-size: 16px; text-align: left;">' + res.data.data.msg + '</span>',
                      type: "warning",
                      html: true
                    });
                  }
                })["catch"](function (err) {
                  var data = err.response.data;
                  alert(data.message);
                }).then(function () {
                  vm.loading.approveProcess = false; // swal.close();
                });

              case 7:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    approve: function approve() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                vm = _this3;
                _context6.next = 3;
                return axios.patch(vm.url.ajax_approve).then(function (res) {
                  if (res.data.data.status == 'S') {
                    swal({
                      title: 'อนุมัติประมาณการผลิตประจำปักษ์',
                      text: '<span style="font-size: 16px; text-align: left;"> อนุมัติประมาณการผลิตประจำปีเรียบร้อย </span>',
                      type: "success",
                      html: true
                    });
                    vm.tab2AvgChangeData = {};

                    if (vm.selTabName == 'tab2') {
                      vm.refreshTab2 = vm.refreshTab2 + 1;
                    }

                    vm.canEdit = false;
                    vm.canApprove = false;
                    vm.prodYearlyMain = res.data.data.prod_yearly_main;
                  }

                  if (res.data.data.status != 'S') {
                    swal({
                      title: "Error !",
                      text: res.data.data.msg,
                      type: "error",
                      showConfirmButton: true
                    });
                  }
                })["catch"](function (err) {
                  var data = err.response.data;
                  alert(data.message);
                }).then(function () {// swal.close();
                });

              case 3:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      }))();
    },
    // UnApprove
    checkUnapprove: function checkUnapprove() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee9() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee9$(_context9) {
          while (1) {
            switch (_context9.prev = _context9.next) {
              case 0:
                vm = _this4;

                if (!vm.canApprove) {
                  _context9.next = 3;
                  break;
                }

                return _context9.abrupt("return");

              case 3:
                vm.loading.approveProcess = true;
                _context9.next = 6;
                return axios.get(vm.url.ajax_check_unapprove).then(function (res) {
                  if (res.data.data.status == 'S') {
                    swal({
                      html: true,
                      title: 'ยกเลิกอนุมัติประมาณการผลิตประจำปี',
                      text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการยกเลิกอนุมัติประมาณการผลิตประจำปี? </span></h2>',
                      showCancelButton: true,
                      confirmButtonText: vm.btnTrans.ok.text,
                      cancelButtonText: vm.btnTrans.cancel.text,
                      confirmButtonClass: vm.btnTrans.ok["class"] + ' btn-lg tw-w-25',
                      cancelButtonClass: vm.btnTrans.cancel["class"] + ' btn-lg tw-w-25',
                      closeOnConfirm: false,
                      closeOnCancel: true,
                      showLoaderOnConfirm: true
                    }, /*#__PURE__*/function () {
                      var _ref3 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee7(isConfirm) {
                        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee7$(_context7) {
                          while (1) {
                            switch (_context7.prev = _context7.next) {
                              case 0:
                                if (isConfirm) {
                                  vm.unapprove();
                                }

                              case 1:
                              case "end":
                                return _context7.stop();
                            }
                          }
                        }, _callee7);
                      }));

                      return function (_x5) {
                        return _ref3.apply(this, arguments);
                      };
                    }());
                  } else {
                    swal({
                      title: 'ยกเลิกอนุมัติประมาณการผลิตประจำปักษ์',
                      text: res.data.data.msg,
                      html: true,
                      showCancelButton: true,
                      confirmButtonText: vm.btnTrans.ok.text,
                      cancelButtonText: vm.btnTrans.cancel.text,
                      confirmButtonClass: vm.btnTrans.ok["class"] + ' btn-lg tw-w-25',
                      cancelButtonClass: vm.btnTrans.cancel["class"] + ' btn-lg tw-w-25',
                      closeOnConfirm: false,
                      closeOnCancel: true,
                      showLoaderOnConfirm: true
                    }, /*#__PURE__*/function () {
                      var _ref4 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee8(isConfirm) {
                        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee8$(_context8) {
                          while (1) {
                            switch (_context8.prev = _context8.next) {
                              case 0:
                                if (isConfirm) {
                                  console.log('Approve');
                                  vm.approve();
                                }

                              case 1:
                              case "end":
                                return _context8.stop();
                            }
                          }
                        }, _callee8);
                      }));

                      return function (_x6) {
                        return _ref4.apply(this, arguments);
                      };
                    }());
                  }
                })["catch"](function (err) {
                  var data = err.response.data;
                  alert(data.message);
                }).then(function () {
                  vm.loading.approveProcess = false; // swal.close();
                });

              case 6:
              case "end":
                return _context9.stop();
            }
          }
        }, _callee9);
      }))();
    },
    unapprove: function unapprove() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee10() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee10$(_context10) {
          while (1) {
            switch (_context10.prev = _context10.next) {
              case 0:
                vm = _this5;
                _context10.next = 3;
                return axios.patch(vm.url.ajax_unapprove).then(function (res) {
                  if (res.data.data.status == 'S') {
                    swal({
                      title: 'ยกเลิกอนุมัติประมาณการผลิตประจำปักษ์',
                      text: '<span style="font-size: 16px; text-align: left;"> ยกเลิกอนุมัติประมาณการผลิตประจำปีเรียบร้อย </span>',
                      type: "success",
                      html: true
                    });
                    vm.tab2AvgChangeData = {};

                    if (vm.selTabName == 'tab2') {
                      vm.refreshTab2 = vm.refreshTab2 + 1;
                    }

                    vm.canEdit = true;
                    vm.canApprove = true;
                    vm.prodYearlyMain = res.data.data.prod_yearly_main;
                  }

                  if (res.data.data.status != 'S') {
                    swal({
                      title: "Error !",
                      text: res.data.data.msg,
                      type: "error",
                      showConfirmButton: true
                    });
                  }
                })["catch"](function (err) {
                  var data = err.response.data;
                  alert(data.message);
                }).then(function () {// swal.close();
                });

              case 3:
              case "end":
                return _context10.stop();
            }
          }
        }, _callee10);
      }))();
    },
    // Copy
    copyPlan: function copyPlan() {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee11() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee11$(_context11) {
          while (1) {
            switch (_context11.prev = _context11.next) {
              case 0:
                vm = _this6;

                if (!(Object.keys(vm.beginOnhandQtyChangeData).length > 0 || Object.keys(vm.totalPlanChangeData).length > 0)) {
                  _context11.next = 4;
                  break;
                }

                swal({
                  title: 'อนุมัติประมาณการผลิตประจำปี',
                  text: '<span style="font-size: 16px; text-align: left;"> ไม่สามารถทำการอนุมัติประมาณการผลิตประจำปี เนื่องจากมีรายการที่แก้ไขอยู่ กรุณาตรวจสอบ </span>',
                  type: "warning",
                  html: true
                });
                return _context11.abrupt("return");

              case 4:
                vm.loading.copyProcess = true;
                _context11.next = 7;
                return axios.patch(vm.url.ajax_copy_plan).then(function (res) {
                  if (res.data.data.status == 'S') {
                    swal({
                      title: 'คัดลอกแผนประมาณการผลิตประจำปักษ์',
                      text: '<span style="font-size: 16px; text-align: left;"> คัดลอกแผนประมาณการผลิตประจำปีเรียบร้อย </span>',
                      type: "success",
                      html: true
                    }); // window.open(res.data.data.redirect_show_page, '_blank');

                    window.location.href = res.data.data.redirect_show_page;
                  } else {
                    swal({
                      title: "Error !",
                      text: res.data.data.msg,
                      type: "error",
                      showConfirmButton: true
                    });
                  }
                })["catch"](function (err) {
                  var data = err.response.data;
                  alert(data.message);
                }).then(function () {
                  vm.loading.copyProcess = false;
                });

              case 7:
              case "end":
                return _context11.stop();
            }
          }
        }, _callee11);
      }))();
    },
    summaryTotalPlaning: function summaryTotalPlaning(res) {
      this.summaryPlanning = res;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/HeaderDetail.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/HeaderDetail.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************************************************************************/
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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["prodYearlyMain", 'lastUpdateDateFormat', 'productTypes', 'defaultInput', 'url'],
  data: function data() {
    return {
      statusLists: [{
        value: 'Active',
        label: 'Active'
      }, {
        value: 'Inactive',
        label: 'Inactive'
      }],
      headerP02: this.prodYearlyMain,
      canApprove: this.prodYearlyMain.can.approve,
      statusFlag: false
    };
  },
  watch: {
    'prodYearlyMain': function prodYearlyMain(newValue) {
      this.canApprove = newValue.can.approve;
      this.headerP02 = newValue;
    }
  },
  methods: {
    dateOrderFrom: function dateOrderFrom(date) {
      this.headerP02.approved_date = date ? moment__WEBPACK_IMPORTED_MODULE_1___default()(date).format('DD-MM-YYYY') : '';
    },
    editStatus: function editStatus() {
      this.statusFlag = true;
    },
    cancleStatus: function cancleStatus() {
      this.statusFlag = false;
    },
    saveStatus: function saveStatus() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                vm = _this;
                vm.loading = true;
                _context.next = 4;
                return axios.post(vm.url.ajax_update_status, {
                  header: vm.headerP02
                }).then(function (res) {
                  if (res.data.data.status == 'S') {
                    swal({
                      title: 'อัพเดทประมาณการผลิตบุหรี่และก้นกรองประจำปี',
                      text: '<span style="font-size: 16px; text-align: left;"> อัพเดทประมาณการผลิตบุหรี่และก้นกรองประจำปีเรียบร้อย </span>',
                      type: "success",
                      html: true
                    });
                    vm.headerP02 = res.data.data.header;
                    vm.statusFlag = false;
                    vm.canApprove = vm.headerP02.can.approve;
                  } else {
                    swal({
                      title: "มีข้อผิดพลาด",
                      text: res.data.data.msg,
                      type: "error",
                      showConfirmButton: true
                    });
                  }
                })["catch"](function (err) {
                  var data = err.response.data;
                  swal({
                    title: "มีข้อผิดพลาด",
                    text: data.message,
                    type: "error",
                    showConfirmButton: true
                  });
                }).then(function () {
                  vm.loading = false;
                });

              case 4:
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/InputOnhandQuantity.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/InputOnhandQuantity.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************************************************************************************/
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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_0___default())
  },
  props: ['line', 'estByBrandData', 'beginOnhandQtyChangeData', 'periods', 'periodCal', 'canEdit'],
  data: function data() {
    return {
      oldBeginOnhandQty: this.line.begin_onhand_qty
    };
  },
  mounted: function mounted() {// this.changeOnhandQuantity();
  },
  watch: {
    'editFlag': function editFlag(newValue) {
      if (newValue == false) {
        this.line.begin_onhand_qty = Number(this.oldBeginOnhandQty);
        this.changeOnhandQuantity();
      }
    }
  },
  methods: {
    changeOnhandQuantity: function changeOnhandQuantity() {
      var vm = this; // Current Input change

      var current_onhand = Number(vm.line.begin_onhand_qty);
      var begin_onhand_first = 0;
      var prev_period = '';
      var i = 0; //next period

      Object.keys(vm.periods).filter(function (period, index) {
        i = index - 1;
        prev_period = vm.periodCal[i]; // calculate

        var begin_onhand_next = 0;
        vm.estByBrandData[period][vm.line.item_code].begin_onhand_qty = Number(current_onhand);

        if (index == 0) {
          begin_onhand_first = current_onhand + Number(vm.estByBrandData[period][vm.line.item_code].planning_qty) - Number(vm.line.forcast_qty);
          vm.estByBrandData[period][vm.line.item_code].bal_onhand_qty = Number(begin_onhand_first);
        } else {
          var bal_onhand_qty = vm.estByBrandData[prev_period][vm.line.item_code].bal_onhand_qty ? Number(vm.estByBrandData[prev_period][vm.line.item_code].bal_onhand_qty) : 0;
          var planning_qty = vm.estByBrandData[period][vm.line.item_code].planning_qty ? Number(vm.estByBrandData[period][vm.line.item_code].planning_qty) : 0;
          var forcast_qty = vm.estByBrandData[period][vm.line.item_code].forcast_qty ? Number(vm.estByBrandData[period][vm.line.item_code].forcast_qty) : 0;
          console.log(bal_onhand_qty);
          console.log(planning_qty);
          console.log(forcast_qty);
          begin_onhand_next = bal_onhand_qty + planning_qty - forcast_qty;
          vm.estByBrandData[period][vm.line.item_code].bal_onhand_qty = Number(begin_onhand_next);
        }
      }); //Stamp line ที่มีการแก้ไขจำนวน Onhand

      Vue.set(vm.beginOnhandQtyChangeData, vm.line.item_code, Number(vm.line.begin_onhand_qty));
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/InputPlanQuantity.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/InputPlanQuantity.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************************************************************************************/
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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_0___default())
  },
  props: ['line', 'totalPlanChangeData', 'canEdit', 'estByBrandData', 'periods', 'periodCal'],
  data: function data() {
    return {
      oldTotalQty: this.line.planning_qty
    };
  },
  mounted: function mounted() {},
  watch: {
    'editFlag': function editFlag(newValue) {
      if (newValue == false) {
        this.line.planning_qty = Number(this.oldTotalQty);
        this.changeTotalQuantity();
      }
    }
  },
  methods: {
    changeTotalQuantity: function changeTotalQuantity() {
      var vm = this; //calculate update total_qty

      var result = Number(vm.line.planning_qty) / Number(vm.line.define_product_cigaret); //result

      vm.line.total_qty = result; //Stamp line ที่มีการแก้ไขจำนวน total_qty

      Vue.set(vm.totalPlanChangeData, vm.line.period_no + '|' + vm.line.item_code, Number(vm.line.planning_qty)); // ----------------------- CAL BAL_ONHAND_QTY -------------------------------
      // Current Input change

      var current_onhand = Number(vm.line.begin_onhand_qty);
      var begin_onhand_first = 0;
      var prev_period = '';
      var i = 0; //next period

      Object.keys(vm.periods).filter(function (period, index) {
        i = index - 1;
        prev_period = vm.periodCal[i]; // calculate

        var begin_onhand_next = 0;

        if (index == 0) {
          begin_onhand_first = Number(vm.estByBrandData[period][vm.line.item_code].begin_onhand_qty) + Number(vm.estByBrandData[period][vm.line.item_code].planning_qty) - Number(vm.line.forcast_qty);
          vm.estByBrandData[period][vm.line.item_code].bal_onhand_qty = Number(begin_onhand_first);
        } else {
          var bal_onhand_qty = vm.estByBrandData[prev_period][vm.line.item_code].bal_onhand_qty ? Number(vm.estByBrandData[prev_period][vm.line.item_code].bal_onhand_qty) : 0;
          var planning_qty = vm.estByBrandData[period][vm.line.item_code].planning_qty ? Number(vm.estByBrandData[period][vm.line.item_code].planning_qty) : 0;
          var forcast_qty = vm.estByBrandData[period][vm.line.item_code].forcast_qty ? Number(vm.estByBrandData[period][vm.line.item_code].forcast_qty) : 0;
          console.log(prev_period);
          console.log(vm.line.item_code);
          console.log(bal_onhand_qty);
          begin_onhand_next = bal_onhand_qty + planning_qty - forcast_qty;
          vm.estByBrandData[period][vm.line.item_code].bal_onhand_qty = Number(begin_onhand_next);
        }
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/InputTotalQuantity.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/InputTotalQuantity.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************************************************************************************/
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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_0___default())
  },
  props: ['line', 'totalQtyChangeData', 'canEdit'],
  data: function data() {
    return {
      oldTotalQty: this.line.total_qty
    };
  },
  mounted: function mounted() {},
  watch: {
    'editFlag': function editFlag(newValue) {
      if (newValue == false) {
        this.line.total_qty = Number(this.oldTotalQty);
        this.changeTotalQuantity();
      }
    }
  },
  methods: {
    changeTotalQuantity: function changeTotalQuantity() {
      var vm = this; //calculate

      var result = Number(vm.line.total_qty) * Number(vm.line.define_product_cigaret); //result

      vm.line.planning_qty = result; //Stamp line ที่มีการแก้ไขจำนวน total_qty

      Vue.set(vm.totalQtyChangeData, vm.line.period_no + '|' + vm.line.item_code, Number(vm.line.total_qty));
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab1.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab1.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["pDateFormat", "machineEfficiencyProd", "prodYearlyMain", "productType", "url", "workingHour", "selTabName", "pRefresh"],
  data: function data() {
    return {
      loading: false,
      html: ''
    };
  },
  mounted: function mounted() {
    this.getProductPlanMachine();
  },
  methods: {
    getProductPlanMachine: function getProductPlanMachine() {
      var vm = this;

      if (!vm.productType || vm.selTabName != 'tab1') {
        return;
      }

      vm.loading = true;
      var params = {
        yearly_main_id: vm.prodYearlyMain.yearly_main_id,
        product_type: vm.productType
      };
      axios.get(vm.url.ajax_get_plan_machine, {
        params: params
      }).then(function (res) {
        var data = res.data.data;
        vm.html = data.html;
      })["catch"](function (err) {
        var msg = err.response.data;
        swal({
          title: 'มีข้อผิดพลาด',
          text: msg.message,
          type: "error"
        });
      }).then(function () {
        vm.loading = false;
      });
    }
  },
  watch: {
    productType: function productType() {
      this.getProductPlanMachine();
    },
    pRefresh: function () {
      var _pRefresh = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee(value, oldValue) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                this.getProductPlanMachine();

              case 1:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this);
      }));

      function pRefresh(_x, _x2) {
        return _pRefresh.apply(this, arguments);
      }

      return pRefresh;
    }()
  },
  computed: {
    p01EfficiencyProduct: function p01EfficiencyProduct() {
      var vm = this;
      var p01EffiProd = '-';

      if (vm.prodYearlyMain) {
        var efficiencyProduct = vm.machineEfficiencyProd.filter(function (o) {
          return o.product_type == vm.productType;
        });

        if (efficiencyProduct) {
          p01EffiProd = efficiencyProduct[0]['efficiency_product'];
        }
      }

      return p01EffiProd;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab2.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab2.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _Tab2EstimateBrandTable__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Tab2EstimateBrandTable */ "./resources/js/components/Planning/Production-Yearly/components/Tab2EstimateBrandTable.vue");


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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    Tab2EstimateBrandTable: _Tab2EstimateBrandTable__WEBPACK_IMPORTED_MODULE_1__.default
  },
  props: ["prodYearlyMain", 'url', 'pDateFormat', "pRefresh", "btnTrans", "yearlyColorCode", "selTabName", "productType", "pDefaultInput", "beginOnhandQtyChangeData", "totalQtyChangeData", "totalPlanChangeData", "canEdit", 'pWorkingHour'],
  data: function data() {
    return {
      dateFormat: this.pDateFormat != undefined && this.pDateFormat != '' ? this.pDateFormat : 'DD/MM/YYYY',
      loading: 0,
      refreshData: 0,
      html: ''
    };
  },
  mounted: function mounted() {
    this.getData();
  },
  computed: {},
  methods: {
    getData: function getData() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var vm, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                vm = _this;

                if (vm.prodYearlyMain) {
                  _context.next = 3;
                  break;
                }

                return _context.abrupt("return");

              case 3:
                vm.refreshData = vm.refreshData + 1;
                vm.loading = true;
                vm.html = '';
                params = {
                  yearly_main_id: vm.prodYearlyMain.yearly_main_id,
                  product_type: vm.productType
                };
                _context.next = 9;
                return axios.get(vm.url.ajax_get_summary_working_hour, {
                  params: params
                }).then(function (res) {
                  vm.html = res.data.data.html;
                })["catch"](function (err) {
                  var data = err.response.data;
                  alert(data.message);
                }).then(function () {
                  vm.loading = false;
                });

              case 9:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    summaryTotalPlaning: function summaryTotalPlaning(res) {
      this.$emit("summaryTotalPlaningTab2", res);
    }
  },
  watch: {
    productType: function () {
      var _productType = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2(value, oldValue) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                if (!(this.selTabName != 'tab2')) {
                  _context2.next = 2;
                  break;
                }

                return _context2.abrupt("return");

              case 2:
                this.getData();

              case 3:
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
    }(),
    pRefresh: function () {
      var _pRefresh = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3(value, oldValue) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                if (!(this.selTabName != 'tab2')) {
                  _context3.next = 2;
                  break;
                }

                return _context3.abrupt("return");

              case 2:
                this.getData();

              case 3:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3, this);
      }));

      function pRefresh(_x3, _x4) {
        return _pRefresh.apply(this, arguments);
      }

      return pRefresh;
    }()
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab2EffProductPeriod.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab2EffProductPeriod.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************************************************************************************************/
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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_0___default())
  },
  props: ['placeholder', 'totalEffProduct', 'summaryTotal'],
  data: function data() {
    return {
      value: Number(this.totalEffProduct) - Number(this.summaryTotal)
    };
  },
  mounted: function mounted() {},
  methods: {//
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab2EstimateBrandTable.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab2EstimateBrandTable.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _InputOnhandQuantity_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./InputOnhandQuantity.vue */ "./resources/js/components/Planning/Production-Yearly/components/InputOnhandQuantity.vue");
/* harmony import */ var _InputTotalQuantity_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./InputTotalQuantity.vue */ "./resources/js/components/Planning/Production-Yearly/components/InputTotalQuantity.vue");
/* harmony import */ var _InputPlanQuantity_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./InputPlanQuantity.vue */ "./resources/js/components/Planning/Production-Yearly/components/InputPlanQuantity.vue");
/* harmony import */ var _Tab2EffProductPeriod_vue__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./Tab2EffProductPeriod.vue */ "./resources/js/components/Planning/Production-Yearly/components/Tab2EffProductPeriod.vue");
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! vue-numeric */ "./node_modules/vue-numeric/dist/vue-numeric.min.js");
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(vue_numeric__WEBPACK_IMPORTED_MODULE_5__);


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





/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    InputOnhandQuantity: _InputOnhandQuantity_vue__WEBPACK_IMPORTED_MODULE_1__.default,
    InputTotalQuantity: _InputTotalQuantity_vue__WEBPACK_IMPORTED_MODULE_2__.default,
    InputPlanQuantity: _InputPlanQuantity_vue__WEBPACK_IMPORTED_MODULE_3__.default,
    Tab2EffProductPeriod: _Tab2EffProductPeriod_vue__WEBPACK_IMPORTED_MODULE_4__.default,
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_5___default())
  },
  props: ['url', "prodYearlyMain", "productType", "btnTrans", "yearlyColorCode", "canEdit", 'pRefresh', 'pWorkingHour', 'pLoading', "beginOnhandQtyChangeData", "totalQtyChangeData", "totalPlanChangeData"],
  data: function data() {
    return {
      loading: false,
      refresh: this.pRefresh != undefined && this.pRefresh != '' ? this.pRefresh : false,
      items: [],
      periods: [],
      periodCal: [],
      summaryByPeriodData: [],
      summaryTotalData: [],
      estByBrandData: [],
      totalEffProductData: [],
      omDayForSaleData: [],
      estKkTableHtml: '',
      // By Period
      summaryTotalQty: [],
      summaryTotalPlaningQty: [],
      summaryTotalOnhandQty: [],
      summaryTotalForcastQty: [],
      sel_item: '',
      // สมการ tab1:table2
      formula1: 'ผลิต / Batch * จำนวน(ชุด)',
      formula2: 'ปริมานใช้ใบยาต่อ 1 ล้านมวน * ประมาณการผลิต (ล้านมวน)',
      formula3: 'คงคลัง (ล้านมวน) + ประมาณการผลิต (ล้านมวน) - ประมาณการขาย (ล้านมวน)'
    };
  },
  mounted: function mounted() {
    this.getData(); // this.totalPeriod();
  },
  methods: {
    getData: function getData() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var vm, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                vm = _this;

                if (vm.refresh) {
                  _context.next = 3;
                  break;
                }

                return _context.abrupt("return");

              case 3:
                vm.loading = true;
                vm.estByBrandData = false;
                vm.estKkTableHtml = false;
                vm.summaryData = [];
                params = {
                  yearly_main_id: vm.prodYearlyMain.yearly_main_id,
                  product_type: vm.productType
                };
                _context.next = 10;
                return axios.get(vm.url.ajax_get_est_by_brand, {
                  params: params
                }).then(function (res) {
                  vm.items = res.data.data.items;
                  vm.periods = res.data.data.periods;
                  vm.periodCal = res.data.data.period_cal;
                  vm.estKkTableHtml = res.data.data.est_kk_table_html;
                  vm.estByBrandData = res.data.data.est_by_brand;
                  vm.totalEffProductData = res.data.data.total_eff_product;
                  vm.omDayForSaleData = res.data.data.om_day_for_sale;
                  vm.summaryByPeriodData = res.data.data.summary_by_period;
                  vm.summaryTotalData = res.data.data.summary_total;
                })["catch"](function (err) {
                  console.log('error');
                  var data = err.response.data;
                  alert(data.message);
                }).then(function () {
                  vm.loading = false;
                });

              case 10:
                vm.refresh = false;

              case 11:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    selItem: function selItem(item) {
      this.sel_item = item;
    }
  },
  computed: {
    totalBeginOnhand: function totalBeginOnhand() {
      return Object.values(this.items).reduce(function (accumulator, line) {
        return accumulator + parseFloat(line.begin_onhand_qty);
      }, 0);
    },
    totalQuantity: function totalQuantity() {
      var result = [];
      var res = [];
      var vm = this;

      if (vm.estByBrandData) {
        Object.keys(vm.periods).filter(function (period) {
          return Object.values(vm.estByBrandData[period]).filter(function (val2) {
            if (!res[val2['period_no']]) {
              res[val2['period_no']] = {
                period: val2['period_no'],
                total_qty: 0
              };
              result.push(res[val2['period_no']]);
            }

            res[val2['period_no']].total_qty += parseFloat(val2['total_qty']);
          });
        }, 0);
        vm.summaryTotalQty = result;
      }
    },
    totalPlanningQuantity: function totalPlanningQuantity() {
      var result = [];
      var res = [];
      var vm = this;

      if (vm.estByBrandData) {
        Object.keys(vm.periods).filter(function (period) {
          return Object.values(vm.estByBrandData[period]).filter(function (val2) {
            if (!res[val2['period_no']]) {
              res[val2['period_no']] = {
                period: val2['period_no'],
                planning_qty: 0
              };
              result.push(res[val2['period_no']]);
            }

            res[val2['period_no']].planning_qty += parseFloat(val2['planning_qty']);
          });
        }, 0);
        vm.summaryTotalPlaningQty = result;
        this.$emit("summaryTotalPlaningTab2", this.summaryTotalPlaningQty);
      }
    },
    totalOnhandQuantity: function totalOnhandQuantity() {
      var result = [];
      var res = [];
      var vm = this;

      if (vm.estByBrandData) {
        Object.keys(vm.periods).filter(function (period) {
          return Object.values(vm.estByBrandData[period]).filter(function (val2) {
            if (!res[val2['period_no']]) {
              res[val2['period_no']] = {
                period: val2['period_no'],
                bal_onhand_qty: 0
              };
              result.push(res[val2['period_no']]);
            }

            res[val2['period_no']].bal_onhand_qty += parseFloat(val2['bal_onhand_qty']);
          });
        }, 0);
        this.summaryTotalOnhandQty = result;
      }
    },
    totalForcastQuantity: function totalForcastQuantity() {
      var result = [];
      var res = [];
      var vm = this;

      if (vm.estByBrandData) {
        Object.keys(vm.periods).filter(function (period) {
          return Object.values(vm.estByBrandData[period]).filter(function (val2) {
            if (!res[val2['period_no']]) {
              res[val2['period_no']] = {
                period: val2['period_no'],
                forcast_qty: 0
              };
              result.push(res[val2['period_no']]);
            }

            res[val2['period_no']].forcast_qty += parseFloat(val2['forcast_qty']);
          });
        }, 0);
        this.summaryTotalForcastQty = result;
      }
    }
  },
  watch: {
    pRefresh: function () {
      var _pRefresh = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2(value, oldValue) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                this.refresh = true;
                this.getData();

              case 2:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, this);
      }));

      function pRefresh(_x, _x2) {
        return _pRefresh.apply(this, arguments);
      }

      return pRefresh;
    }(),
    totalQuantity: function totalQuantity(newValue) {
      return newValue;
    },
    totalPlanningQuantity: function totalPlanningQuantity(newValue) {
      return newValue;
    },
    totalOnhandQuantity: function totalOnhandQuantity(newValue) {
      return newValue;
    },
    totalForcastQuantity: function totalForcastQuantity(newValue) {
      return newValue;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab3.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab3.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['url', "pRefresh", "productType", "prodYearlyMain", "selTabName"],
  data: function data() {
    return {
      loading: false,
      refreshData: 0,
      html: ''
    };
  },
  mounted: function mounted() {
    this.getEstByYearly();
  },
  computed: {},
  methods: {
    getEstByYearly: function getEstByYearly() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var vm, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                vm = _this;

                if (vm.prodYearlyMain) {
                  _context.next = 3;
                  break;
                }

                return _context.abrupt("return");

              case 3:
                vm.refreshData = vm.refreshData + 1;
                vm.loading = true;
                vm.html = '';
                params = {
                  yearly_main_id: vm.prodYearlyMain.yearly_main_id,
                  product_type: vm.productType
                };
                _context.next = 9;
                return axios.get(vm.url.ajax_get_est_by_yearly, {
                  params: params
                }).then(function (res) {
                  vm.html = res.data.data.html;
                })["catch"](function (err) {
                  var data = err.response.data;
                  alert(data.message);
                }).then(function () {
                  vm.loading = false;
                });

              case 9:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    }
  },
  watch: {
    productType: function productType() {
      this.getEstByYearly();
    },
    pRefresh: function () {
      var _pRefresh = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2(value, oldValue) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                if (!(this.selTabName != 'tab3')) {
                  _context2.next = 2;
                  break;
                }

                return _context2.abrupt("return");

              case 2:
                this.getEstByYearly();

              case 3:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, this);
      }));

      function pRefresh(_x, _x2) {
        return _pRefresh.apply(this, arguments);
      }

      return pRefresh;
    }()
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab2.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab2.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab2EstimateBrandTable.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab2EstimateBrandTable.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, ".el-input--medium .el-input__inner {\n  height: 30px !important;\n  line-height: 36px;\n}\n.el-input--medium .el-input__icon {\n  line-height: 30px;\n}\n.nav .label, .ibox .label {\n  font-size: 12px;\n}\n.sticky-col {\n  position: -webkit-sticky;\n  position: sticky;\n  background-color: #f7f7f7 !important;\n  z-index: 9999;\n}\n.first-col {\n  width: 150px;\n  min-width: 70px;\n  max-width: 150px;\n  left: 0px;\n}\n.second-col {\n  width: 150px;\n  min-width: 135px;\n  max-width: 150px;\n  left: 68px;\n}\n.th-col {\n  width: 250px;\n  min-width: 165px;\n  max-width: 250px;\n  left: 202px;\n}\n.fo-col {\n  width: 200px;\n  min-width: 100px;\n  max-width: 200px;\n  left: 365px;\n}\n.fi-col {\n  width: 200px;\n  min-width: 125px;\n  max-width: 200px;\n  left: 463px;\n}\n.t1-col {\n  width: 200px;\n  min-width: 150px;\n  max-width: 200px;\n  left: -5px;\n}\n.h1-col {\n  width: 200px;\n  min-width: 150px;\n  max-width: 200px;\n  left: -5px;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab3.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab3.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab2.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab2.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab2_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Tab2.vue?vue&type=style&index=0&scope=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab2.vue?vue&type=style&index=0&scope=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab2_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab2_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab2EstimateBrandTable.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab2EstimateBrandTable.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab2EstimateBrandTable_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Tab2EstimateBrandTable.vue?vue&type=style&index=0&scope=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab2EstimateBrandTable.vue?vue&type=style&index=0&scope=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab2EstimateBrandTable_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab2EstimateBrandTable_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab3.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab3.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab3_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Tab3.vue?vue&type=style&index=0&scope=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab3.vue?vue&type=style&index=0&scope=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab3_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab3_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/ModalCreate.vue":
/*!****************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/ModalCreate.vue ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ModalCreate_vue_vue_type_template_id_43e6df71___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ModalCreate.vue?vue&type=template&id=43e6df71& */ "./resources/js/components/Planning/Production-Yearly/ModalCreate.vue?vue&type=template&id=43e6df71&");
/* harmony import */ var _ModalCreate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalCreate.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Production-Yearly/ModalCreate.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _ModalCreate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ModalCreate_vue_vue_type_template_id_43e6df71___WEBPACK_IMPORTED_MODULE_0__.render,
  _ModalCreate_vue_vue_type_template_id_43e6df71___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Production-Yearly/ModalCreate.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/ModalSearch.vue":
/*!****************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/ModalSearch.vue ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ModalSearch_vue_vue_type_template_id_701d23c6___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ModalSearch.vue?vue&type=template&id=701d23c6& */ "./resources/js/components/Planning/Production-Yearly/ModalSearch.vue?vue&type=template&id=701d23c6&");
/* harmony import */ var _ModalSearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalSearch.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Production-Yearly/ModalSearch.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _ModalSearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ModalSearch_vue_vue_type_template_id_701d23c6___WEBPACK_IMPORTED_MODULE_0__.render,
  _ModalSearch_vue_vue_type_template_id_701d23c6___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Production-Yearly/ModalSearch.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/ShowComponent.vue":
/*!******************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/ShowComponent.vue ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ShowComponent_vue_vue_type_template_id_9854d730___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ShowComponent.vue?vue&type=template&id=9854d730& */ "./resources/js/components/Planning/Production-Yearly/ShowComponent.vue?vue&type=template&id=9854d730&");
/* harmony import */ var _ShowComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ShowComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Production-Yearly/ShowComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _ShowComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ShowComponent_vue_vue_type_template_id_9854d730___WEBPACK_IMPORTED_MODULE_0__.render,
  _ShowComponent_vue_vue_type_template_id_9854d730___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Production-Yearly/ShowComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/components/HeaderDetail.vue":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/components/HeaderDetail.vue ***!
  \****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _HeaderDetail_vue_vue_type_template_id_86a1b382___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./HeaderDetail.vue?vue&type=template&id=86a1b382& */ "./resources/js/components/Planning/Production-Yearly/components/HeaderDetail.vue?vue&type=template&id=86a1b382&");
/* harmony import */ var _HeaderDetail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./HeaderDetail.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Production-Yearly/components/HeaderDetail.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _HeaderDetail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _HeaderDetail_vue_vue_type_template_id_86a1b382___WEBPACK_IMPORTED_MODULE_0__.render,
  _HeaderDetail_vue_vue_type_template_id_86a1b382___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Production-Yearly/components/HeaderDetail.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/components/InputOnhandQuantity.vue":
/*!***********************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/components/InputOnhandQuantity.vue ***!
  \***********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _InputOnhandQuantity_vue_vue_type_template_id_8774991c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./InputOnhandQuantity.vue?vue&type=template&id=8774991c& */ "./resources/js/components/Planning/Production-Yearly/components/InputOnhandQuantity.vue?vue&type=template&id=8774991c&");
/* harmony import */ var _InputOnhandQuantity_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./InputOnhandQuantity.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Production-Yearly/components/InputOnhandQuantity.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _InputOnhandQuantity_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _InputOnhandQuantity_vue_vue_type_template_id_8774991c___WEBPACK_IMPORTED_MODULE_0__.render,
  _InputOnhandQuantity_vue_vue_type_template_id_8774991c___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Production-Yearly/components/InputOnhandQuantity.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/components/InputPlanQuantity.vue":
/*!*********************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/components/InputPlanQuantity.vue ***!
  \*********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _InputPlanQuantity_vue_vue_type_template_id_00004b8d___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./InputPlanQuantity.vue?vue&type=template&id=00004b8d& */ "./resources/js/components/Planning/Production-Yearly/components/InputPlanQuantity.vue?vue&type=template&id=00004b8d&");
/* harmony import */ var _InputPlanQuantity_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./InputPlanQuantity.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Production-Yearly/components/InputPlanQuantity.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _InputPlanQuantity_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _InputPlanQuantity_vue_vue_type_template_id_00004b8d___WEBPACK_IMPORTED_MODULE_0__.render,
  _InputPlanQuantity_vue_vue_type_template_id_00004b8d___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Production-Yearly/components/InputPlanQuantity.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/components/InputTotalQuantity.vue":
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/components/InputTotalQuantity.vue ***!
  \**********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _InputTotalQuantity_vue_vue_type_template_id_1a0b3f06___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./InputTotalQuantity.vue?vue&type=template&id=1a0b3f06& */ "./resources/js/components/Planning/Production-Yearly/components/InputTotalQuantity.vue?vue&type=template&id=1a0b3f06&");
/* harmony import */ var _InputTotalQuantity_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./InputTotalQuantity.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Production-Yearly/components/InputTotalQuantity.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _InputTotalQuantity_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _InputTotalQuantity_vue_vue_type_template_id_1a0b3f06___WEBPACK_IMPORTED_MODULE_0__.render,
  _InputTotalQuantity_vue_vue_type_template_id_1a0b3f06___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Production-Yearly/components/InputTotalQuantity.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/components/Tab1.vue":
/*!********************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/components/Tab1.vue ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Tab1_vue_vue_type_template_id_5c78cb86___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Tab1.vue?vue&type=template&id=5c78cb86& */ "./resources/js/components/Planning/Production-Yearly/components/Tab1.vue?vue&type=template&id=5c78cb86&");
/* harmony import */ var _Tab1_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Tab1.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Production-Yearly/components/Tab1.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _Tab1_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Tab1_vue_vue_type_template_id_5c78cb86___WEBPACK_IMPORTED_MODULE_0__.render,
  _Tab1_vue_vue_type_template_id_5c78cb86___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Production-Yearly/components/Tab1.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/components/Tab2.vue":
/*!********************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/components/Tab2.vue ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Tab2_vue_vue_type_template_id_5c5c9c84___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Tab2.vue?vue&type=template&id=5c5c9c84& */ "./resources/js/components/Planning/Production-Yearly/components/Tab2.vue?vue&type=template&id=5c5c9c84&");
/* harmony import */ var _Tab2_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Tab2.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Production-Yearly/components/Tab2.vue?vue&type=script&lang=js&");
/* harmony import */ var _Tab2_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Tab2.vue?vue&type=style&index=0&scope=true&lang=css& */ "./resources/js/components/Planning/Production-Yearly/components/Tab2.vue?vue&type=style&index=0&scope=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _Tab2_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Tab2_vue_vue_type_template_id_5c5c9c84___WEBPACK_IMPORTED_MODULE_0__.render,
  _Tab2_vue_vue_type_template_id_5c5c9c84___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Production-Yearly/components/Tab2.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/components/Tab2EffProductPeriod.vue":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/components/Tab2EffProductPeriod.vue ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Tab2EffProductPeriod_vue_vue_type_template_id_51361fee___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Tab2EffProductPeriod.vue?vue&type=template&id=51361fee& */ "./resources/js/components/Planning/Production-Yearly/components/Tab2EffProductPeriod.vue?vue&type=template&id=51361fee&");
/* harmony import */ var _Tab2EffProductPeriod_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Tab2EffProductPeriod.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Production-Yearly/components/Tab2EffProductPeriod.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _Tab2EffProductPeriod_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Tab2EffProductPeriod_vue_vue_type_template_id_51361fee___WEBPACK_IMPORTED_MODULE_0__.render,
  _Tab2EffProductPeriod_vue_vue_type_template_id_51361fee___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Production-Yearly/components/Tab2EffProductPeriod.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/components/Tab2EstimateBrandTable.vue":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/components/Tab2EstimateBrandTable.vue ***!
  \**************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Tab2EstimateBrandTable_vue_vue_type_template_id_7eb326a6___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Tab2EstimateBrandTable.vue?vue&type=template&id=7eb326a6& */ "./resources/js/components/Planning/Production-Yearly/components/Tab2EstimateBrandTable.vue?vue&type=template&id=7eb326a6&");
/* harmony import */ var _Tab2EstimateBrandTable_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Tab2EstimateBrandTable.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Production-Yearly/components/Tab2EstimateBrandTable.vue?vue&type=script&lang=js&");
/* harmony import */ var _Tab2EstimateBrandTable_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Tab2EstimateBrandTable.vue?vue&type=style&index=0&scope=true&lang=css& */ "./resources/js/components/Planning/Production-Yearly/components/Tab2EstimateBrandTable.vue?vue&type=style&index=0&scope=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _Tab2EstimateBrandTable_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Tab2EstimateBrandTable_vue_vue_type_template_id_7eb326a6___WEBPACK_IMPORTED_MODULE_0__.render,
  _Tab2EstimateBrandTable_vue_vue_type_template_id_7eb326a6___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Production-Yearly/components/Tab2EstimateBrandTable.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/components/Tab3.vue":
/*!********************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/components/Tab3.vue ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Tab3_vue_vue_type_template_id_5c406d82___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Tab3.vue?vue&type=template&id=5c406d82& */ "./resources/js/components/Planning/Production-Yearly/components/Tab3.vue?vue&type=template&id=5c406d82&");
/* harmony import */ var _Tab3_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Tab3.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Production-Yearly/components/Tab3.vue?vue&type=script&lang=js&");
/* harmony import */ var _Tab3_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Tab3.vue?vue&type=style&index=0&scope=true&lang=css& */ "./resources/js/components/Planning/Production-Yearly/components/Tab3.vue?vue&type=style&index=0&scope=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _Tab3_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Tab3_vue_vue_type_template_id_5c406d82___WEBPACK_IMPORTED_MODULE_0__.render,
  _Tab3_vue_vue_type_template_id_5c406d82___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Production-Yearly/components/Tab3.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/ModalCreate.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/ModalCreate.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalCreate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalCreate.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/ModalCreate.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalCreate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/ModalSearch.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/ModalSearch.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearch.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/ModalSearch.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/ShowComponent.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/ShowComponent.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ShowComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/ShowComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/components/HeaderDetail.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/components/HeaderDetail.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_HeaderDetail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./HeaderDetail.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/HeaderDetail.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_HeaderDetail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/components/InputOnhandQuantity.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/components/InputOnhandQuantity.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_InputOnhandQuantity_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./InputOnhandQuantity.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/InputOnhandQuantity.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_InputOnhandQuantity_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/components/InputPlanQuantity.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/components/InputPlanQuantity.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_InputPlanQuantity_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./InputPlanQuantity.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/InputPlanQuantity.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_InputPlanQuantity_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/components/InputTotalQuantity.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/components/InputTotalQuantity.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_InputTotalQuantity_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./InputTotalQuantity.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/InputTotalQuantity.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_InputTotalQuantity_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/components/Tab1.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/components/Tab1.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab1_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Tab1.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab1.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab1_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/components/Tab2.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/components/Tab2.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab2_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Tab2.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab2.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab2_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/components/Tab2EffProductPeriod.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/components/Tab2EffProductPeriod.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab2EffProductPeriod_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Tab2EffProductPeriod.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab2EffProductPeriod.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab2EffProductPeriod_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/components/Tab2EstimateBrandTable.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/components/Tab2EstimateBrandTable.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab2EstimateBrandTable_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Tab2EstimateBrandTable.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab2EstimateBrandTable.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab2EstimateBrandTable_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/components/Tab3.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/components/Tab3.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab3_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Tab3.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab3.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab3_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/components/Tab2.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!****************************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/components/Tab2.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \****************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab2_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/style-loader/dist/cjs.js!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Tab2.vue?vue&type=style&index=0&scope=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab2.vue?vue&type=style&index=0&scope=true&lang=css&");


/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/components/Tab2EstimateBrandTable.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!**********************************************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/components/Tab2EstimateBrandTable.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \**********************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab2EstimateBrandTable_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/style-loader/dist/cjs.js!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Tab2EstimateBrandTable.vue?vue&type=style&index=0&scope=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab2EstimateBrandTable.vue?vue&type=style&index=0&scope=true&lang=css&");


/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/components/Tab3.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!****************************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/components/Tab3.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \****************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab3_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/style-loader/dist/cjs.js!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Tab3.vue?vue&type=style&index=0&scope=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab3.vue?vue&type=style&index=0&scope=true&lang=css&");


/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/ModalCreate.vue?vue&type=template&id=43e6df71&":
/*!***********************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/ModalCreate.vue?vue&type=template&id=43e6df71& ***!
  \***********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalCreate_vue_vue_type_template_id_43e6df71___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalCreate_vue_vue_type_template_id_43e6df71___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalCreate_vue_vue_type_template_id_43e6df71___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalCreate.vue?vue&type=template&id=43e6df71& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/ModalCreate.vue?vue&type=template&id=43e6df71&");


/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/ModalSearch.vue?vue&type=template&id=701d23c6&":
/*!***********************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/ModalSearch.vue?vue&type=template&id=701d23c6& ***!
  \***********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_template_id_701d23c6___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_template_id_701d23c6___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_template_id_701d23c6___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearch.vue?vue&type=template&id=701d23c6& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/ModalSearch.vue?vue&type=template&id=701d23c6&");


/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/ShowComponent.vue?vue&type=template&id=9854d730&":
/*!*************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/ShowComponent.vue?vue&type=template&id=9854d730& ***!
  \*************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowComponent_vue_vue_type_template_id_9854d730___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowComponent_vue_vue_type_template_id_9854d730___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowComponent_vue_vue_type_template_id_9854d730___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ShowComponent.vue?vue&type=template&id=9854d730& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/ShowComponent.vue?vue&type=template&id=9854d730&");


/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/components/HeaderDetail.vue?vue&type=template&id=86a1b382&":
/*!***********************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/components/HeaderDetail.vue?vue&type=template&id=86a1b382& ***!
  \***********************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HeaderDetail_vue_vue_type_template_id_86a1b382___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HeaderDetail_vue_vue_type_template_id_86a1b382___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HeaderDetail_vue_vue_type_template_id_86a1b382___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./HeaderDetail.vue?vue&type=template&id=86a1b382& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/HeaderDetail.vue?vue&type=template&id=86a1b382&");


/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/components/InputOnhandQuantity.vue?vue&type=template&id=8774991c&":
/*!******************************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/components/InputOnhandQuantity.vue?vue&type=template&id=8774991c& ***!
  \******************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputOnhandQuantity_vue_vue_type_template_id_8774991c___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputOnhandQuantity_vue_vue_type_template_id_8774991c___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputOnhandQuantity_vue_vue_type_template_id_8774991c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./InputOnhandQuantity.vue?vue&type=template&id=8774991c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/InputOnhandQuantity.vue?vue&type=template&id=8774991c&");


/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/components/InputPlanQuantity.vue?vue&type=template&id=00004b8d&":
/*!****************************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/components/InputPlanQuantity.vue?vue&type=template&id=00004b8d& ***!
  \****************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputPlanQuantity_vue_vue_type_template_id_00004b8d___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputPlanQuantity_vue_vue_type_template_id_00004b8d___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputPlanQuantity_vue_vue_type_template_id_00004b8d___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./InputPlanQuantity.vue?vue&type=template&id=00004b8d& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/InputPlanQuantity.vue?vue&type=template&id=00004b8d&");


/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/components/InputTotalQuantity.vue?vue&type=template&id=1a0b3f06&":
/*!*****************************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/components/InputTotalQuantity.vue?vue&type=template&id=1a0b3f06& ***!
  \*****************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputTotalQuantity_vue_vue_type_template_id_1a0b3f06___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputTotalQuantity_vue_vue_type_template_id_1a0b3f06___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputTotalQuantity_vue_vue_type_template_id_1a0b3f06___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./InputTotalQuantity.vue?vue&type=template&id=1a0b3f06& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/InputTotalQuantity.vue?vue&type=template&id=1a0b3f06&");


/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/components/Tab1.vue?vue&type=template&id=5c78cb86&":
/*!***************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/components/Tab1.vue?vue&type=template&id=5c78cb86& ***!
  \***************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab1_vue_vue_type_template_id_5c78cb86___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab1_vue_vue_type_template_id_5c78cb86___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab1_vue_vue_type_template_id_5c78cb86___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Tab1.vue?vue&type=template&id=5c78cb86& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab1.vue?vue&type=template&id=5c78cb86&");


/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/components/Tab2.vue?vue&type=template&id=5c5c9c84&":
/*!***************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/components/Tab2.vue?vue&type=template&id=5c5c9c84& ***!
  \***************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab2_vue_vue_type_template_id_5c5c9c84___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab2_vue_vue_type_template_id_5c5c9c84___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab2_vue_vue_type_template_id_5c5c9c84___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Tab2.vue?vue&type=template&id=5c5c9c84& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab2.vue?vue&type=template&id=5c5c9c84&");


/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/components/Tab2EffProductPeriod.vue?vue&type=template&id=51361fee&":
/*!*******************************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/components/Tab2EffProductPeriod.vue?vue&type=template&id=51361fee& ***!
  \*******************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab2EffProductPeriod_vue_vue_type_template_id_51361fee___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab2EffProductPeriod_vue_vue_type_template_id_51361fee___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab2EffProductPeriod_vue_vue_type_template_id_51361fee___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Tab2EffProductPeriod.vue?vue&type=template&id=51361fee& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab2EffProductPeriod.vue?vue&type=template&id=51361fee&");


/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/components/Tab2EstimateBrandTable.vue?vue&type=template&id=7eb326a6&":
/*!*********************************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/components/Tab2EstimateBrandTable.vue?vue&type=template&id=7eb326a6& ***!
  \*********************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab2EstimateBrandTable_vue_vue_type_template_id_7eb326a6___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab2EstimateBrandTable_vue_vue_type_template_id_7eb326a6___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab2EstimateBrandTable_vue_vue_type_template_id_7eb326a6___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Tab2EstimateBrandTable.vue?vue&type=template&id=7eb326a6& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab2EstimateBrandTable.vue?vue&type=template&id=7eb326a6&");


/***/ }),

/***/ "./resources/js/components/Planning/Production-Yearly/components/Tab3.vue?vue&type=template&id=5c406d82&":
/*!***************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Production-Yearly/components/Tab3.vue?vue&type=template&id=5c406d82& ***!
  \***************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab3_vue_vue_type_template_id_5c406d82___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab3_vue_vue_type_template_id_5c406d82___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Tab3_vue_vue_type_template_id_5c406d82___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Tab3.vue?vue&type=template&id=5c406d82& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab3.vue?vue&type=template&id=5c406d82&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/ModalCreate.vue?vue&type=template&id=43e6df71&":
/*!**************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/ModalCreate.vue?vue&type=template&id=43e6df71& ***!
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
                { staticClass: "modal-body text-left" },
                [
                  _c("form", { attrs: { id: "production-plan-create-form" } }, [
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
                            [_vm._v(" ปีงบประมาณ :")]
                          ),
                          _vm._v(" "),
                          _c(
                            "div",
                            { staticClass: "input-group " },
                            [
                              _c("el-input", {
                                attrs: {
                                  readonly: true,
                                  placeholder: "Please input",
                                  size: "large"
                                },
                                model: {
                                  value: _vm.budget_year,
                                  callback: function($$v) {
                                    _vm.budget_year = $$v
                                  },
                                  expression: "budget_year"
                                }
                              }),
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
                            "form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2"
                        },
                        [
                          _c(
                            "label",
                            { staticClass: "tw-font-bold tw-uppercase mb-1" },
                            [_vm._v(" ครั้งที่ :")]
                          ),
                          _vm._v(" "),
                          _c("el-input", {
                            directives: [
                              {
                                name: "loading",
                                rawName: "v-loading",
                                value: _vm.timeLoading,
                                expression: "timeLoading"
                              }
                            ],
                            attrs: {
                              placeholder: "ครั้งที่",
                              size: "large",
                              readonly: true
                            },
                            model: {
                              value: _vm.times,
                              callback: function($$v) {
                                _vm.times = $$v
                              },
                              expression: "times"
                            }
                          })
                        ],
                        1
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
                            { staticClass: "tw-font-bold tw-uppercase mb-1" },
                            [_vm._v(" คงคลังต้นปีงบประมาณเพียงพอ(วัน) :")]
                          ),
                          _vm._v(" "),
                          _c("vue-numeric", {
                            staticClass: "form-control input-md text-right",
                            style:
                              "width: 100%; height: 40px; " +
                              (_vm.errors.begin_onhand
                                ? "border: 1px solid red;"
                                : ""),
                            attrs: {
                              name: "begin_onhand",
                              minus: false,
                              min: 0,
                              max: 100,
                              autocomplete: "off"
                            },
                            model: {
                              value: _vm.begin_onhand,
                              callback: function($$v) {
                                _vm.begin_onhand = $$v
                              },
                              expression: "begin_onhand"
                            }
                          }),
                          _vm._v(" "),
                          _c("div", {
                            staticClass: "error_msg text-left",
                            attrs: { id: "el_explode_begin_onhand" }
                          })
                        ],
                        1
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
                            [_vm._v(" เปอร์เซ็นต์สูญเสีย(%) :")]
                          ),
                          _vm._v(" "),
                          _c("vue-numeric", {
                            staticClass: "form-control input-md text-right",
                            style:
                              "width: 100%; height: 40px; " +
                              (_vm.errors.per_loss
                                ? "border: 1px solid red;"
                                : ""),
                            attrs: {
                              name: "per_loss",
                              minus: false,
                              precision: 2,
                              min: 0,
                              max: 100,
                              autocomplete: "off"
                            },
                            model: {
                              value: _vm.per_loss,
                              callback: function($$v) {
                                _vm.per_loss = $$v
                              },
                              expression: "per_loss"
                            }
                          }),
                          _vm._v(" "),
                          _c("div", {
                            staticClass: "error_msg text-left",
                            attrs: { id: "el_explode_per_loss" }
                          })
                        ],
                        1
                      )
                    ])
                  ]),
                  _vm._v(" "),
                  _c(
                    "transition",
                    {
                      attrs: {
                        "enter-active-class": "animated fadeInUp",
                        "leave-active-class": "animated fadeOutDown"
                      }
                    },
                    [
                      _vm.budget_year
                        ? _c("div", {
                            staticClass: "mt-4",
                            domProps: { innerHTML: _vm._s(_vm.html) }
                          })
                        : _vm._e()
                    ]
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c("div", { staticClass: "modal-footer" }, [
                _c(
                  "button",
                  {
                    staticClass: "btn btn-white btn-lg tw-w-25'",
                    attrs: { type: "button", "data-dismiss": "modal" }
                  },
                  [_vm._v("Close")]
                ),
                _vm._v(" "),
                _c(
                  "button",
                  {
                    directives: [
                      {
                        name: "loading",
                        rawName: "v-loading",
                        value: _vm.loading,
                        expression: "loading"
                      }
                    ],
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
                    _c("i", { class: _vm.btnTrans.create.icon }),
                    _vm._v(
                      "\n                        " +
                        _vm._s(_vm.btnTrans.create.text) +
                        "\n                    "
                    )
                  ]
                )
              ])
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
      _c("h4", { staticClass: "modal-title" }, [
        _vm._v("สร้างแผนประมาณการผลิตประจำปี")
      ]),
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/ModalSearch.vue?vue&type=template&id=701d23c6&":
/*!**************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/ModalSearch.vue?vue&type=template&id=701d23c6& ***!
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
                              attrs: {
                                size: "large",
                                placeholder: "ปีงบประมาณ",
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
                            _vm._l(_vm.budgetYears, function(year, index) {
                              return _c("el-option", {
                                key: year,
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
                        "form-group text-right  pr-2 mb-0 col-lg-6 col-md-10 col-sm-12 col-xs-12"
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
                              "\n                                    " +
                                _vm._s(_vm.btnTrans.search.text) +
                                "\n                                "
                            )
                          ]
                        )
                      ])
                    ]
                  )
                ]),
                _vm._v(" "),
                _c("div", { domProps: { innerHTML: _vm._s(_vm.html) } })
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
            "\n                        ค้นหาแผนประมาณการผลิตประจำปี\n                    "
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/ShowComponent.vue?vue&type=template&id=9854d730&":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/ShowComponent.vue?vue&type=template&id=9854d730& ***!
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
          value: _vm.loading.approveProcess || _vm.loading.copyProcess,
          expression: "loading.approveProcess || loading.copyProcess"
        }
      ]
    },
    [
      _c("div", { staticClass: "ibox float-e-margins mb-2" }, [
        _c(
          "div",
          { staticClass: "col-12 text-right mt-1" },
          [
            _c("modal-search", {
              attrs: {
                "btn-trans": _vm.btnTrans,
                url: _vm.url,
                defaultYear: _vm.pDefaultInput.budget_year,
                budgetYears: _vm.modalSearchInput.budget_years,
                search: []
              }
            }),
            _vm._v(" "),
            _c("modal-create", {
              staticClass: "pr-2",
              attrs: {
                "btn-trans": _vm.btnTrans,
                url: _vm.url,
                defaultYear: _vm.modalCreateInput.default_year,
                defaultWorkingHour: _vm.modalCreateInput.default_workingHour
              }
            }),
            _vm._v(" "),
            _vm.canEdit
              ? _c(
                  "button",
                  {
                    class: _vm.btnTrans.save.class + " btn-lg tw-w-25",
                    attrs: { type: "button" },
                    on: {
                      click: function($event) {
                        $event.preventDefault()
                        return _vm.saveTab2EstChange()
                      }
                    }
                  },
                  [
                    _c("i", { class: _vm.btnTrans.save.icon }),
                    _vm._v(
                      "\n                " +
                        _vm._s(_vm.btnTrans.save.text) +
                        "\n            "
                    )
                  ]
                )
              : _vm._e(),
            _vm._v(" "),
            _vm.prodYearlyMain
              ? [
                  _vm.canApprove
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
                    : _c(
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
                      ),
                  _vm._v(" "),
                  _c(
                    "button",
                    {
                      class: _vm.btnTrans.copy.class + " btn-lg tw-w-25",
                      attrs: { type: "button" },
                      on: {
                        click: function($event) {
                          $event.preventDefault()
                          return _vm.copyPlan()
                        }
                      }
                    },
                    [
                      _c("i", { class: _vm.btnTrans.copy.icon }),
                      _vm._v(
                        "\n                    " +
                          _vm._s(_vm.btnTrans.copy.text) +
                          "แผน\n                "
                      )
                    ]
                  )
                ]
              : _vm._e()
          ],
          2
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "card border-primary mb-3 mt-3" }, [
        _c(
          "div",
          { staticClass: "card-body" },
          [
            _c("header-detail", {
              attrs: {
                lastUpdateDateFormat: _vm.lastUpdateDateFormat,
                "prod-yearly-main": _vm.prodYearlyMain,
                "product-types": _vm.productTypes,
                "default-input": _vm.pDefaultInput,
                url: _vm.url
              }
            })
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "tabs-container" }, [
        _c("ul", { staticClass: "nav nav-tabs", attrs: { role: "tablist" } }, [
          _c("li", [
            _c(
              "a",
              {
                staticClass: "nav-link active",
                attrs: { "data-toggle": "tab", href: "#tab1" },
                on: {
                  click: function($event) {
                    _vm.selTabName = "tab1"
                  }
                }
              },
              [
                _vm._v(
                  "\n                    ประมาณกำลังการผลิต\n                "
                )
              ]
            )
          ]),
          _vm._v(" "),
          _c("li", [
            _c(
              "a",
              {
                staticClass: "nav-link",
                attrs: { "data-toggle": "tab", href: "#tab2" },
                on: {
                  click: function($event) {
                    _vm.selTabName = "tab2"
                  }
                }
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
                staticClass: "nav-link",
                attrs: { "data-toggle": "tab", href: "#tab3" },
                on: {
                  click: function($event) {
                    _vm.selTabName = "tab3"
                  }
                }
              },
              [
                _vm._v(
                  "\n                    ประมาณการผลิตทั้งปีงบประมาณ\n                "
                )
              ]
            )
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "tab-content" }, [
          _c(
            "div",
            {
              staticClass: "tab-pane active",
              attrs: { role: "tabpanel", id: "tab1" }
            },
            [
              _c(
                "div",
                { staticClass: "panel-body " },
                [
                  _vm.prodYearlyMain
                    ? _c("tab1", {
                        attrs: {
                          machineEfficiencyProd: _vm.machineEfficiencyProd,
                          "product-type": _vm.defaultInput.product_type,
                          "working-hour": _vm.workingHour,
                          "sel-tab-name": _vm.selTabName,
                          url: _vm.url,
                          pRefresh: _vm.refreshTab1,
                          "prod-yearly-main": _vm.prodYearlyMain,
                          "p-date-format": _vm.pDateFormat
                        }
                      })
                    : _vm._e()
                ],
                1
              )
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
              _c(
                "div",
                { staticClass: "panel-body" },
                [
                  _vm.prodYearlyMain
                    ? _c("tab2", {
                        attrs: {
                          "prod-yearly-main": _vm.prodYearlyMain,
                          "product-type": _vm.defaultInput.product_type,
                          pRefresh: _vm.refreshTab2,
                          "p-date-format": _vm.pDateFormat,
                          "p-working-hour": _vm.workingHour,
                          "sel-tab-name": _vm.selTabName,
                          pDefaultInput: _vm.pDefaultInput,
                          canEdit: _vm.canEdit,
                          btnTrans: _vm.btnTrans,
                          yearlyColorCode: _vm.yearlyColorCode,
                          url: _vm.url,
                          "begin-onhand-qty-change-data":
                            _vm.beginOnhandQtyChangeData,
                          "total-qty-change-data": _vm.totalQtyChangeData,
                          "total-plan-change-data": _vm.totalPlanChangeData
                        },
                        on: { summaryTotalPlaningTab2: _vm.summaryTotalPlaning }
                      })
                    : _vm._e()
                ],
                1
              )
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
                  _vm.prodYearlyMain
                    ? _c("tab3", {
                        attrs: {
                          "prod-yearly-main": _vm.prodYearlyMain,
                          "product-type": _vm.defaultInput.product_type,
                          pRefresh: _vm.refreshTab3,
                          "sel-tab-name": _vm.selTabName,
                          url: _vm.url
                        }
                      })
                    : _vm._e()
                ],
                1
              )
            ]
          )
        ])
      ])
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/HeaderDetail.vue?vue&type=template&id=86a1b382&":
/*!**************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/HeaderDetail.vue?vue&type=template&id=86a1b382& ***!
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
  return _c("div", {}, [
    _c("form", { attrs: { id: "production-yearly-form", action: "" } }, [
      _c("div", { staticClass: "row" }, [
        _c("div", { staticClass: "col-8 b-r" }, [
          _c("div", { staticClass: "row" }, [
            _c("div", { staticClass: "col-lg-6" }, [
              _c("dl", { staticClass: "row mb-0" }, [
                _vm._m(0),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-8 text-sm-left" }, [
                  _c("dd", { staticClass: "mb-1" }, [
                    _vm.prodYearlyMain
                      ? _c("div", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(_vm.prodYearlyMain.budget_year) +
                              "\n                                    "
                          )
                        ])
                      : _vm._e()
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("dl", { staticClass: "row mb-0" }, [
                _vm._m(1),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-8 text-sm-left" }, [
                  _c("dd", { staticClass: "mb-1" }, [
                    _vm.prodYearlyMain
                      ? _c("div", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(_vm.prodYearlyMain.version_no) +
                              "\n                                    "
                          )
                        ])
                      : _vm._e()
                  ])
                ])
              ])
            ]),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "col-lg-6", attrs: { id: "cluster_info" } },
              [
                _c("dl", { staticClass: "row mb-0" }, [
                  _vm._m(2),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-sm-4 text-sm-left" }, [
                    _c("dd", { staticClass: "mb-1" }, [
                      _vm.prodYearlyMain
                        ? _c("div", [
                            _vm._v(
                              "\n                                        " +
                                _vm._s(
                                  _vm.prodYearlyMain
                                    ? _vm.prodYearlyMain.budget_year
                                    : "-"
                                ) +
                                "\n                                    "
                            )
                          ])
                        : _vm._e()
                    ])
                  ])
                ]),
                _vm._v(" "),
                _c("dl", { staticClass: "row mb-0" }, [
                  _vm._m(3),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-sm-4 text-sm-left" }, [
                    _c("dd", { staticClass: "mb-1" }, [
                      _vm.prodYearlyMain
                        ? _c("div", [
                            _vm._v(
                              "\n                                        " +
                                _vm._s(
                                  _vm.prodYearlyMain.first_sales_forecast
                                    .version
                                ) +
                                "\n                                    "
                            )
                          ])
                        : _vm._e()
                    ])
                  ])
                ]),
                _vm._v(" "),
                _c("dl", { staticClass: "row mb-0" }, [
                  _vm._m(4),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-sm-4 text-sm-left" }, [
                    _c("dd", { staticClass: "mb-1" }, [
                      _vm.prodYearlyMain
                        ? _c("div", [
                            _vm._v(
                              "\n                                        " +
                                _vm._s(
                                  _vm.prodYearlyMain.first_sales_forecast
                                    .approve_date_format
                                ) +
                                "\n                                    "
                            )
                          ])
                        : _vm._e()
                    ])
                  ])
                ])
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
                    _c(
                      "el-radio-group",
                      {
                        attrs: { size: "small" },
                        model: {
                          value: _vm.defaultInput.product_type,
                          callback: function($$v) {
                            _vm.$set(_vm.defaultInput, "product_type", $$v)
                          },
                          expression: "defaultInput.product_type"
                        }
                      },
                      [
                        _vm._l(_vm.productTypes, function(product, index) {
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
                                  "\n                                    " +
                                    _vm._s(product.meaning) +
                                    "\n                                "
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
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col-4" }, [
          _c("div", { staticClass: "row" }, [
            _c("div", { staticClass: "col-lg-12" }, [
              _c("dl", { staticClass: "row mb-0" }, [
                _vm._m(5),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-6 text-sm-left" }, [
                  _c("dd", { staticClass: "mb-1" }, [
                    _vm.prodYearlyMain
                      ? _c("div", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(_vm.prodYearlyMain.creation_date_format) +
                              "\n                                    "
                          )
                        ])
                      : _vm._e()
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("dl", { staticClass: "row mb-0" }, [
                _vm._m(6),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-6 text-sm-left" }, [
                  _c("dd", { staticClass: "mb-1" }, [
                    _vm.prodYearlyMain
                      ? _c("div", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(_vm.lastUpdateDateFormat) +
                              "\n                                    "
                          )
                        ])
                      : _vm._e()
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("dl", { staticClass: "row mb-0" }, [
                _vm._m(7),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-6 text-sm-left" }, [
                  _c("dd", { staticClass: "mb-1" }, [
                    _vm.headerP02
                      ? _c(
                          "div",
                          [
                            !_vm.statusFlag
                              ? _c("span", {
                                  domProps: {
                                    innerHTML: _vm._s(
                                      _vm.headerP02.status_lable_html
                                    )
                                  }
                                })
                              : _vm._e(),
                            _vm._v(" "),
                            _vm.canApprove
                              ? [
                                  !_vm.statusFlag
                                    ? _c(
                                        "button",
                                        {
                                          staticClass: "btn btn-xs btn-primary",
                                          attrs: { type: "button" },
                                          on: {
                                            click: function($event) {
                                              return _vm.editStatus()
                                            }
                                          }
                                        },
                                        [
                                          _c("i", {
                                            staticClass: "fa fa-pencil-square"
                                          })
                                        ]
                                      )
                                    : _vm._e(),
                                  _vm._v(" "),
                                  _vm.statusFlag
                                    ? _c(
                                        "el-select",
                                        {
                                          attrs: {
                                            size: "small",
                                            placeholder: "สถานะ",
                                            filterable: ""
                                          },
                                          model: {
                                            value:
                                              _vm.headerP02.approved_status,
                                            callback: function($$v) {
                                              _vm.$set(
                                                _vm.headerP02,
                                                "approved_status",
                                                $$v
                                              )
                                            },
                                            expression:
                                              "headerP02.approved_status"
                                          }
                                        },
                                        _vm._l(_vm.statusLists, function(
                                          status
                                        ) {
                                          return _c("el-option", {
                                            key: status.label,
                                            attrs: {
                                              label: status.label,
                                              value: status.value
                                            }
                                          })
                                        }),
                                        1
                                      )
                                    : _vm._e(),
                                  _vm._v(" "),
                                  _c(
                                    "div",
                                    { staticClass: "text-right mt-2" },
                                    [
                                      _vm.statusFlag
                                        ? _c(
                                            "button",
                                            {
                                              staticClass:
                                                "btn btn-xs btn-success",
                                              attrs: { type: "button" },
                                              on: {
                                                click: function($event) {
                                                  return _vm.saveStatus()
                                                }
                                              }
                                            },
                                            [
                                              _c("i", {
                                                staticClass:
                                                  "fa fa-check-square"
                                              })
                                            ]
                                          )
                                        : _vm._e(),
                                      _vm._v(" "),
                                      _vm.statusFlag
                                        ? _c(
                                            "button",
                                            {
                                              staticClass:
                                                "btn btn-xs btn-danger",
                                              attrs: { type: "button" },
                                              on: {
                                                click: function($event) {
                                                  return _vm.cancleStatus()
                                                }
                                              }
                                            },
                                            [
                                              _c("i", {
                                                staticClass: "fa fa-times"
                                              })
                                            ]
                                          )
                                        : _vm._e()
                                    ]
                                  )
                                ]
                              : _vm._e()
                          ],
                          2
                        )
                      : _vm._e()
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("dl", { staticClass: "row mb-0" }, [
                _vm._m(8),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-6 text-sm-left" }, [
                  _c("dd", { staticClass: "mb-1" }, [
                    _vm.prodYearlyMain
                      ? _c("div", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(
                                _vm.prodYearlyMain.updated_by
                                  ? _vm.prodYearlyMain.updated_by.name
                                  : "-"
                              ) +
                              "\n                                    "
                          )
                        ])
                      : _vm._e()
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("dl", { staticClass: "row mb-0" }, [
                _vm._m(9),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-6 text-sm-left" }, [
                  _c("dd", { staticClass: "mb-1" }, [
                    _vm.headerP02
                      ? _c(
                          "div",
                          [
                            !_vm.statusFlag
                              ? _c("span", [
                                  _vm._v(
                                    " " +
                                      _vm._s(_vm.headerP02.approved_at_format) +
                                      " "
                                  )
                                ])
                              : _vm._e(),
                            _vm._v(" "),
                            _vm.statusFlag
                              ? _c("datepicker-th", {
                                  staticClass:
                                    "form-control md:tw-mb-0 tw-mb-2 approve_date",
                                  staticStyle: { width: "100%" },
                                  attrs: {
                                    id: "approved_at",
                                    placeholder: "โปรดเลือกวันที่",
                                    value: _vm.headerP02.approved_at_format,
                                    format: "DD/MM/YYYY"
                                  },
                                  on: { dateWasSelected: _vm.dateOrderFrom },
                                  model: {
                                    value: _vm.headerP02.approved_at_format,
                                    callback: function($$v) {
                                      _vm.$set(
                                        _vm.headerP02,
                                        "approved_at_format",
                                        $$v
                                      )
                                    },
                                    expression: " headerP02.approved_at_format"
                                  }
                                })
                              : _vm._e()
                          ],
                          1
                        )
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
      _c("dt", [_vm._v("ครั้งที่:")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-sm-8  pl-0 text-sm-right" }, [
      _c("dt", [
        _vm._v(
          "\n                                    อ้างอิงประมาณการจำหน่ายปีงบประมาณ:\n                                "
        )
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-sm-8 pl-0  text-sm-right" }, [
      _c("dt", [_vm._v("ครั้งที่:")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-sm-8 pl-0  text-sm-right" }, [
      _c("dt", [_vm._v("วันที่อนุมัติแผนขาย:")])
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
      _c("dt", [_vm._v("วันที่อนุมัติ:")])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/InputOnhandQuantity.vue?vue&type=template&id=8774991c&":
/*!*********************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/InputOnhandQuantity.vue?vue&type=template&id=8774991c& ***!
  \*********************************************************************************************************************************************************************************************************************************************************************/
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
      !_vm.canEdit
        ? [
            _c("span", [
              _vm._v(
                " " +
                  _vm._s(_vm._f("number3Digit")(_vm.line.begin_onhand_qty)) +
                  " "
              )
            ])
          ]
        : [
            _c("vue-numeric", {
              staticClass: "form-control input-sm text-right",
              attrs: {
                separator: ",",
                precision: 2,
                min: 0,
                max: 9999999999,
                minus: false
              },
              on: {
                change: function($event) {
                  return _vm.changeOnhandQuantity()
                },
                blur: function($event) {
                  return _vm.changeOnhandQuantity()
                }
              },
              model: {
                value: _vm.line.begin_onhand_qty,
                callback: function($$v) {
                  _vm.$set(_vm.line, "begin_onhand_qty", $$v)
                },
                expression: "line.begin_onhand_qty"
              }
            })
          ]
    ],
    2
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/InputPlanQuantity.vue?vue&type=template&id=00004b8d&":
/*!*******************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/InputPlanQuantity.vue?vue&type=template&id=00004b8d& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************/
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
      !_vm.canEdit
        ? [
            _c("span", [
              _vm._v(
                " " +
                  _vm._s(_vm._f("number3Digit")(_vm.line.planning_qty)) +
                  " "
              )
            ])
          ]
        : [
            _c("vue-numeric", {
              staticClass: "form-control input-sm text-right",
              attrs: {
                separator: ",",
                precision: 2,
                min: 0,
                max: 9999999999,
                minus: false
              },
              on: {
                change: function($event) {
                  return _vm.changeTotalQuantity()
                },
                blur: function($event) {
                  return _vm.changeTotalQuantity()
                }
              },
              model: {
                value: _vm.line.planning_qty,
                callback: function($$v) {
                  _vm.$set(_vm.line, "planning_qty", $$v)
                },
                expression: "line.planning_qty"
              }
            })
          ]
    ],
    2
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/InputTotalQuantity.vue?vue&type=template&id=1a0b3f06&":
/*!********************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/InputTotalQuantity.vue?vue&type=template&id=1a0b3f06& ***!
  \********************************************************************************************************************************************************************************************************************************************************************/
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
      !_vm.canEdit
        ? [
            _c("span", [
              _vm._v(
                " " + _vm._s(_vm._f("number3Digit")(_vm.line.total_qty)) + " "
              )
            ])
          ]
        : [
            _c("vue-numeric", {
              staticClass: "form-control input-sm text-right",
              attrs: {
                separator: ",",
                min: 0,
                precision: 2,
                max: 9999999999,
                minus: false
              },
              on: {
                change: function($event) {
                  return _vm.changeTotalQuantity()
                },
                blur: function($event) {
                  return _vm.changeTotalQuantity()
                }
              },
              model: {
                value: _vm.line.total_qty,
                callback: function($$v) {
                  _vm.$set(_vm.line, "total_qty", $$v)
                },
                expression: "line.total_qty"
              }
            })
          ]
    ],
    2
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab1.vue?vue&type=template&id=5c78cb86&":
/*!******************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab1.vue?vue&type=template&id=5c78cb86& ***!
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
      _c("div", { staticClass: "form-group row" }, [
        _c("label", { staticClass: "col-lg-2 col-form-label text-left" }, [
          _c("strong", [_vm._v(" สั่งผลิต(%) ")]),
          _vm._v(
            "   \n            " +
              _vm._s(_vm.p01EfficiencyProduct) +
              "\n        "
          )
        ])
      ]),
      _vm._v(" "),
      _c("div", { domProps: { innerHTML: _vm._s(_vm.html) } })
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab2.vue?vue&type=template&id=5c5c9c84&":
/*!******************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab2.vue?vue&type=template&id=5c5c9c84& ***!
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
      _c("div", {
        directives: [
          {
            name: "loading",
            rawName: "v-loading",
            value: _vm.loading,
            expression: "loading"
          }
        ],
        domProps: { innerHTML: _vm._s(_vm.html) }
      }),
      _vm._v(" "),
      _c("Tab2EstimateBrandTable", {
        attrs: {
          url: _vm.url,
          btnTrans: _vm.btnTrans,
          prodYearlyMain: _vm.prodYearlyMain,
          "product-type": _vm.productType,
          pRefresh: _vm.refreshData,
          "p-working-hour": _vm.pWorkingHour,
          canEdit: _vm.canEdit,
          yearlyColorCode: _vm.yearlyColorCode,
          "p-loading": _vm.loading,
          "begin-onhand-qty-change-data": _vm.beginOnhandQtyChangeData,
          "total-qty-change-data": _vm.totalQtyChangeData,
          "total-plan-change-data": _vm.totalPlanChangeData
        },
        on: { summaryTotalPlaningTab2: _vm.summaryTotalPlaning }
      })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab2EffProductPeriod.vue?vue&type=template&id=51361fee&":
/*!**********************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab2EffProductPeriod.vue?vue&type=template&id=51361fee& ***!
  \**********************************************************************************************************************************************************************************************************************************************************************/
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
          separator: ",",
          precision: 2,
          minus: false,
          placeholder: _vm.placeholder,
          disabled: ""
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



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab2EstimateBrandTable.vue?vue&type=template&id=7eb326a6&":
/*!************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab2EstimateBrandTable.vue?vue&type=template&id=7eb326a6& ***!
  \************************************************************************************************************************************************************************************************************************************************************************/
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
  return !_vm.pLoading
    ? _c("div", [
        _c("div", { staticClass: "hr-line-dashed" }),
        _vm._v(" "),
        _c("div", { staticClass: "table-responsive m-t" }, [
          _vm.productType == "KK"
            ? _c("div", { domProps: { innerHTML: _vm._s(_vm.estKkTableHtml) } })
            : _vm._e(),
          _vm._v(" "),
          _vm.productType != "KK"
            ? _c(
                "table",
                {
                  staticClass: "table text-nowrap table-bordered table-hover",
                  staticStyle: { position: "sticky" }
                },
                [
                  _c("thead", [
                    _c(
                      "tr",
                      [
                        _c("th", {
                          staticClass: "align-bottom sticky-col h1-col",
                          staticStyle: {
                            "background-color": "#ffffff !important",
                            border: "0px"
                          },
                          attrs: { colspan: "4" }
                        }),
                        _vm._v(" "),
                        _c("th", {
                          staticClass: "align-bottom",
                          staticStyle: {
                            "background-color": "#ffffff !important",
                            border: "0px"
                          }
                        }),
                        _vm._v(" "),
                        _c("th", {
                          staticClass: "align-bottom",
                          staticStyle: {
                            "background-color": "#ffffff !important",
                            border: "0px"
                          }
                        }),
                        _vm._v(" "),
                        _vm._l(_vm.periods, function(thai_month, key, index) {
                          return [
                            _c(
                              "td",
                              {
                                staticClass: "text-right",
                                staticStyle: {
                                  "background-color": "#ffffff",
                                  border: "0px"
                                },
                                attrs: { colspan: "5" }
                              },
                              [
                                _c("div", { staticClass: "row" }, [
                                  _c("div", { staticClass: "col-md-3" }, [
                                    _c("strong", [
                                      _vm._v(" " + _vm._s(thai_month) + " ")
                                    ])
                                  ]),
                                  _vm._v(" "),
                                  _c("div", { staticClass: "col-md-5" }, [
                                    _vm._v(" ประมาณการผลิตสูงสุด ")
                                  ]),
                                  _vm._v(" "),
                                  _c(
                                    "div",
                                    { staticClass: "col-md-4" },
                                    [
                                      _c("vue-numeric", {
                                        staticClass:
                                          "form-control input-sm text-right",
                                        attrs: {
                                          separator: ",",
                                          precision: 2,
                                          min: 0,
                                          max: 9999999999,
                                          minus: false,
                                          placeholder: "ประมาณการผลิตสูงสุด",
                                          disabled: ""
                                        },
                                        model: {
                                          value: _vm.totalEffProductData[key],
                                          callback: function($$v) {
                                            _vm.$set(
                                              _vm.totalEffProductData,
                                              key,
                                              $$v
                                            )
                                          },
                                          expression: "totalEffProductData[key]"
                                        }
                                      })
                                    ],
                                    1
                                  )
                                ]),
                                _vm._v(" "),
                                _c("div", { staticClass: "row mt-2" }, [
                                  _c("div", { staticClass: "col-md-3" }),
                                  _vm._v(" "),
                                  _c("div", { staticClass: "col-md-5" }, [
                                    _vm._v(" จำนวนวันขาย (วัน) ")
                                  ]),
                                  _vm._v(" "),
                                  _c(
                                    "div",
                                    {
                                      staticClass: "col-md-4",
                                      staticStyle: { "text-align": "right" }
                                    },
                                    [
                                      _c("vue-numeric", {
                                        staticClass:
                                          "form-control input-sm text-right",
                                        attrs: {
                                          separator: ",",
                                          precision: 2,
                                          min: 0,
                                          max: 9999999999,
                                          minus: false,
                                          placeholder: "จำนวนวันขาย",
                                          disabled: ""
                                        },
                                        model: {
                                          value: _vm.omDayForSaleData[key],
                                          callback: function($$v) {
                                            _vm.$set(
                                              _vm.omDayForSaleData,
                                              key,
                                              $$v
                                            )
                                          },
                                          expression: "omDayForSaleData[key]"
                                        }
                                      })
                                    ],
                                    1
                                  )
                                ]),
                                _vm._v(" "),
                                _c("div", { staticClass: "row mt-2" }, [
                                  _c("div", { staticClass: "col-md-3" }),
                                  _vm._v(" "),
                                  _c("div", { staticClass: "col-md-5" }, [
                                    _vm._v(" ประมาณการผลิตสูงสุดหักขาย ")
                                  ]),
                                  _vm._v(" "),
                                  _c(
                                    "div",
                                    {
                                      staticClass: "col-md-4",
                                      staticStyle: { "text-align": "right" }
                                    },
                                    [
                                      _c("Tab2EffProductPeriod", {
                                        attrs: {
                                          placeholder:
                                            "ประมาณการผลิตสูงสุดหักขาย",
                                          totalEffProduct:
                                            _vm.totalEffProductData[key],
                                          summaryTotal:
                                            _vm.summaryTotalForcastQty[index]
                                              .forcast_qty
                                        }
                                      })
                                    ],
                                    1
                                  )
                                ]),
                                _vm._v(" "),
                                _c("div", { staticClass: "row mt-2" }, [
                                  _c("div", { staticClass: "col-md-3" }),
                                  _vm._v(" "),
                                  _c(
                                    "div",
                                    {
                                      staticClass: "col-md-5",
                                      staticStyle: { "font-size": "12px" }
                                    },
                                    [
                                      _vm._v(
                                        " ประมาณการผลิตสูงสุดหักผลิตที่กำหนด "
                                      )
                                    ]
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "div",
                                    {
                                      staticClass: "col-md-4",
                                      staticStyle: { "text-align": "right" }
                                    },
                                    [
                                      _c("Tab2EffProductPeriod", {
                                        attrs: {
                                          placeholder:
                                            "ประมาณการผลิตสูงสุดหักผลิตที่กำหนด",
                                          totalEffProduct:
                                            _vm.totalEffProductData[key],
                                          summaryTotal:
                                            _vm.summaryTotalPlaningQty[index]
                                              .planning_qty
                                        }
                                      })
                                    ],
                                    1
                                  )
                                ])
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
                            staticClass:
                              "align-middle text-center sticky-col first-col",
                            attrs: { rowspan: "2" }
                          },
                          [_vm._v(" ลำดับ ")]
                        ),
                        _vm._v(" "),
                        _c(
                          "th",
                          {
                            staticClass:
                              "align-middle text-center sticky-col second-col",
                            attrs: { rowspan: "2" }
                          },
                          [_vm._v(" รหัสบุหรี่ ")]
                        ),
                        _vm._v(" "),
                        _c(
                          "th",
                          {
                            staticClass:
                              "align-middle text-center sticky-col th-col",
                            attrs: { rowspan: "2" }
                          },
                          [_vm._v(" ตราบุหรี่ ")]
                        ),
                        _vm._v(" "),
                        _vm._m(0),
                        _vm._v(" "),
                        _vm._m(1),
                        _vm._v(" "),
                        _vm._m(2),
                        _vm._v(" "),
                        _vm._l(_vm.periods, function(thai_month, key, index) {
                          return [
                            _c(
                              "th",
                              {
                                staticClass: "text-center text-white",
                                style:
                                  "background-color: " +
                                  _vm.yearlyColorCode[index] +
                                  "; border-right: 3px solid #646464;",
                                attrs: { colspan: "5" }
                              },
                              [_vm._v(" " + _vm._s(thai_month) + " ")]
                            )
                          ]
                        }),
                        _vm._v(" "),
                        _c(
                          "th",
                          {
                            staticClass: "align-middle text-center text-white",
                            staticStyle: { "background-color": "#35d399" },
                            attrs: { colspan: "3" }
                          },
                          [_vm._v(" รวมทั้งปีงบประมาณ ")]
                        )
                      ],
                      2
                    ),
                    _vm._v(" "),
                    _c(
                      "tr",
                      [
                        _vm._l(_vm.periods, function(thai_month, key, index) {
                          return [
                            _c("th", { staticClass: "text-center" }, [
                              _vm._v(" จำนวน (ชุด) ")
                            ]),
                            _vm._v(" "),
                            _c(
                              "th",
                              {
                                staticClass: "text-center",
                                attrs: { title: _vm.formula1 }
                              },
                              [
                                _vm._v(" ประมาณการผลิต "),
                                _c("br"),
                                _vm._v(" (ล้านมวน) ")
                              ]
                            ),
                            _vm._v(" "),
                            _c(
                              "th",
                              {
                                staticClass: "text-center",
                                attrs: { title: _vm.formula2 }
                              },
                              [
                                _vm._v(" ประมาณใช้ใบยา "),
                                _c("br"),
                                _vm._v(" (กก.) ")
                              ]
                            ),
                            _vm._v(" "),
                            _c("th", { staticClass: "text-center" }, [
                              _vm._v(" ประมาณการขาย "),
                              _c("br"),
                              _vm._v(" (ล้านมวน) ")
                            ]),
                            _vm._v(" "),
                            _c(
                              "th",
                              {
                                staticClass: "text-center",
                                staticStyle: {
                                  "border-right": "3px solid #646464"
                                },
                                attrs: { title: _vm.formula3 }
                              },
                              [
                                _vm._v(" คงคลังสิ้นเดือน "),
                                _c("br"),
                                _vm._v(" (ล้านมวน) ")
                              ]
                            )
                          ]
                        }),
                        _vm._v(" "),
                        _vm._m(3),
                        _vm._v(" "),
                        _vm._m(4),
                        _vm._v(" "),
                        _vm._m(5)
                      ],
                      2
                    )
                  ]),
                  _vm._v(" "),
                  _c(
                    "tbody",
                    [
                      _vm._l(_vm.items, function(item, key, index) {
                        return [
                          _c(
                            "tr",
                            [
                              _c(
                                "td",
                                {
                                  staticClass:
                                    "text-center sticky-col first-col",
                                  staticStyle: { "vertical-align": "middle" },
                                  on: {
                                    click: function($event) {
                                      return _vm.selItem(item.item_code)
                                    }
                                  }
                                },
                                [
                                  _vm._v(
                                    "\n                            " +
                                      _vm._s(
                                        index >= 0 ? Number(index) + 1 : key + 1
                                      ) +
                                      "\n                        "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "td",
                                {
                                  staticClass:
                                    "text-center sticky-col second-col",
                                  staticStyle: { "vertical-align": "middle" },
                                  on: {
                                    click: function($event) {
                                      return _vm.selItem(item.item_code)
                                    }
                                  }
                                },
                                [
                                  _vm._v(
                                    "\n                            " +
                                      _vm._s(item.item_code) +
                                      "\n                        "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "td",
                                {
                                  staticClass: "sticky-col th-col",
                                  staticStyle: { "vertical-align": "middle" },
                                  on: {
                                    click: function($event) {
                                      return _vm.selItem(item.item_code)
                                    }
                                  }
                                },
                                [
                                  _vm._v(
                                    "\n                            " +
                                      _vm._s(item.item_description) +
                                      "\n                        "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "td",
                                {
                                  staticClass: "text-center sticky-col fo-col",
                                  staticStyle: { "vertical-align": "middle" },
                                  on: {
                                    click: function($event) {
                                      return _vm.selItem(item.item_code)
                                    }
                                  }
                                },
                                [
                                  _vm._v(
                                    "\n                            " +
                                      _vm._s(item.define_product_cigaret) +
                                      "\n                        "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "td",
                                {
                                  staticClass: "text-right",
                                  staticStyle: { "vertical-align": "middle" },
                                  on: {
                                    click: function($event) {
                                      return _vm.selItem(item.item_code)
                                    }
                                  }
                                },
                                [
                                  _vm._v(
                                    "\n                            " +
                                      _vm._s(
                                        _vm._f("number2Digit")(
                                          Number(item.formula_qty)
                                        )
                                      ) +
                                      "\n                        "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "td",
                                {
                                  staticClass: "text-right",
                                  staticStyle: { "vertical-align": "middle" },
                                  on: {
                                    click: function($event) {
                                      return _vm.selItem(item.item_code)
                                    }
                                  }
                                },
                                [
                                  _c("input-onhand-quantity", {
                                    attrs: {
                                      line: item,
                                      "est-by-brand-data": _vm.estByBrandData,
                                      "begin-onhand-qty-change-data":
                                        _vm.beginOnhandQtyChangeData,
                                      periods: _vm.periods,
                                      "period-cal": _vm.periodCal,
                                      "can-edit": _vm.canEdit
                                    }
                                  })
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _vm._l(_vm.estByBrandData, function(
                                estByBrand,
                                period
                              ) {
                                return [
                                  _vm._l(estByBrand, function(value, itemCode) {
                                    return [
                                      item.item_code == itemCode
                                        ? [
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-right",
                                                staticStyle: {
                                                  "vertical-align": "middle"
                                                },
                                                on: {
                                                  click: function($event) {
                                                    return _vm.selItem(
                                                      item.item_code
                                                    )
                                                  }
                                                }
                                              },
                                              [
                                                _vm._v(
                                                  "\n                                        " +
                                                    _vm._s(
                                                      _vm._f("number2Digit")(
                                                        value.total_qty
                                                      )
                                                    ) +
                                                    "\n                                    "
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-right",
                                                staticStyle: {
                                                  "vertical-align": "middle"
                                                },
                                                on: {
                                                  click: function($event) {
                                                    return _vm.selItem(
                                                      item.item_code
                                                    )
                                                  }
                                                }
                                              },
                                              [
                                                _c("input-plan-quantity", {
                                                  attrs: {
                                                    line: value,
                                                    "total-plan-change-data":
                                                      _vm.totalPlanChangeData,
                                                    "est-by-brand-data":
                                                      _vm.estByBrandData,
                                                    periods: _vm.periods,
                                                    "period-cal": _vm.periodCal,
                                                    "can-edit": _vm.canEdit
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
                                                staticStyle: {
                                                  "vertical-align": "middle"
                                                },
                                                on: {
                                                  click: function($event) {
                                                    return _vm.selItem(
                                                      item.item_code
                                                    )
                                                  }
                                                }
                                              },
                                              [
                                                _vm._v(
                                                  "\n                                        " +
                                                    _vm._s(
                                                      _vm._f("number2Digit")(
                                                        value.used_qty
                                                      )
                                                    ) +
                                                    "\n                                    "
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-right",
                                                staticStyle: {
                                                  "vertical-align": "middle"
                                                },
                                                on: {
                                                  click: function($event) {
                                                    return _vm.selItem(
                                                      item.item_code
                                                    )
                                                  }
                                                }
                                              },
                                              [
                                                _vm._v(
                                                  "\n                                        " +
                                                    _vm._s(
                                                      _vm._f("number2Digit")(
                                                        value.forcast_qty
                                                      )
                                                    ) +
                                                    "\n                                    "
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "td",
                                              {
                                                staticClass: "text-right",
                                                style:
                                                  _vm.sel_item == item.item_code
                                                    ? "background-color: #9AD9DB; vertical-align: middle; border-right: 3px solid #646464;"
                                                    : "vertical-align: middle; border-right: 3px solid #646464;",
                                                on: {
                                                  click: function($event) {
                                                    return _vm.selItem(
                                                      item.item_code
                                                    )
                                                  }
                                                }
                                              },
                                              [
                                                _vm._v(
                                                  "\n                                        " +
                                                    _vm._s(
                                                      _vm._f("number2Digit")(
                                                        value.bal_onhand_qty
                                                      )
                                                    ) +
                                                    "\n                                    "
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
                                  staticStyle: { "vertical-align": "middle" },
                                  on: {
                                    click: function($event) {
                                      return _vm.selItem(item.item_code)
                                    }
                                  }
                                },
                                [
                                  _vm._v(
                                    "\n                            " +
                                      _vm._s(
                                        _vm._f("number2Digit")(
                                          Number(item.total_planning_qty)
                                        )
                                      ) +
                                      "\n                        "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "td",
                                {
                                  staticClass: "text-right",
                                  staticStyle: { "vertical-align": "middle" },
                                  on: {
                                    click: function($event) {
                                      return _vm.selItem(item.item_code)
                                    }
                                  }
                                },
                                [
                                  _vm._v(
                                    "\n                            " +
                                      _vm._s(
                                        _vm._f("number2Digit")(
                                          Number(item.total_forcast_qty)
                                        )
                                      ) +
                                      "\n                        "
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "td",
                                {
                                  staticClass: "text-right",
                                  staticStyle: { "vertical-align": "middle" },
                                  on: {
                                    click: function($event) {
                                      return _vm.selItem(item.item_code)
                                    }
                                  }
                                },
                                [
                                  _vm._v(
                                    "\n                            " +
                                      _vm._s(
                                        _vm._f("number2Digit")(
                                          Number(item.total_final_qty)
                                        )
                                      ) +
                                      "\n                        "
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
                          _c(
                            "th",
                            {
                              staticClass: "text-right sticky-col t1-col",
                              attrs: { colspan: "4" }
                            },
                            [_vm._v(" รวม ")]
                          ),
                          _vm._v(" "),
                          _c("th", {
                            staticClass: "text-right",
                            staticStyle: { "background-color": "#34d399" }
                          }),
                          _vm._v(" "),
                          _c(
                            "th",
                            {
                              staticClass: "text-right text-white",
                              staticStyle: { "background-color": "#34d399" }
                            },
                            [
                              _vm._v(
                                "\n                        " +
                                  _vm._s(
                                    _vm._f("number2Digit")(
                                      Number(_vm.totalBeginOnhand)
                                    )
                                  ) +
                                  "\n                    "
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _vm._l(_vm.periodCal, function(period, index) {
                            return [
                              _c(
                                "th",
                                {
                                  staticClass: "text-right text-white",
                                  staticStyle: { "background-color": "#34d399" }
                                },
                                [
                                  _vm._v(
                                    "\n                            " +
                                      _vm._s(
                                        _vm._f("number2Digit")(
                                          Number(
                                            _vm.summaryTotalQty[index].total_qty
                                          )
                                        )
                                      ) +
                                      "\n                        "
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
                                    "\n                            " +
                                      _vm._s(
                                        _vm._f("number2Digit")(
                                          Number(
                                            _vm.summaryTotalPlaningQty[index]
                                              .planning_qty
                                          )
                                        )
                                      ) +
                                      "\n                        "
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
                                    "\n                            " +
                                      _vm._s(
                                        _vm._f("number2Digit")(
                                          _vm.summaryByPeriodData[period]
                                            .used_qty
                                        )
                                      ) +
                                      "\n                        "
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
                                    "\n                            " +
                                      _vm._s(
                                        _vm._f("number2Digit")(
                                          _vm.summaryByPeriodData[period]
                                            .forcast_qty
                                        )
                                      ) +
                                      "\n                        "
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
                                    "border-right": "3px solid #646464"
                                  }
                                },
                                [
                                  _vm._v(
                                    "\n                            " +
                                      _vm._s(
                                        _vm._f("number2Digit")(
                                          Number(
                                            _vm.summaryTotalOnhandQty[index]
                                              .bal_onhand_qty
                                          )
                                        )
                                      ) +
                                      "\n                        "
                                  )
                                ]
                              )
                            ]
                          }),
                          _vm._v(" "),
                          _c(
                            "th",
                            {
                              staticClass: "text-right text-white",
                              staticStyle: { "background-color": "#34d399" }
                            },
                            [
                              _vm._v(
                                "\n                        " +
                                  _vm._s(
                                    _vm._f("number2Digit")(
                                      Number(
                                        _vm.summaryTotalData[
                                          "total_planning_qty"
                                        ]
                                      )
                                    )
                                  ) +
                                  "\n                    "
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
                                "\n                        " +
                                  _vm._s(
                                    _vm._f("number2Digit")(
                                      Number(
                                        _vm.summaryTotalData[
                                          "total_forcast_qty"
                                        ]
                                      )
                                    )
                                  ) +
                                  "\n                    "
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
                                "\n                        " +
                                  _vm._s(
                                    _vm._f("number2Digit")(
                                      Number(
                                        _vm.summaryTotalData["total_final_qty"]
                                      )
                                    )
                                  ) +
                                  "\n                    "
                              )
                            ]
                          )
                        ],
                        2
                      )
                    ],
                    2
                  )
                ]
              )
            : _vm._e()
        ])
      ])
    : _vm._e()
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "th",
      {
        staticClass: "align-middle text-center sticky-col fo-col",
        attrs: { rowspan: "2" }
      },
      [_vm._v(" ผลิต/BATCH "), _c("br"), _vm._v(" (ล้านมวน) ")]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "th",
      { staticClass: "align-middle text-center", attrs: { rowspan: "2" } },
      [_vm._v(" ปริมาณใช้ใบยาต่อ "), _c("br"), _vm._v(" 1 ล้านมวน (กก.) ")]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "th",
      { staticClass: "align-middle text-center", attrs: { rowspan: "2" } },
      [_vm._v(" คาดการณ์คงคลัง  "), _c("br"), _vm._v(" (ล้านมวน) ")]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("th", { staticClass: "align-middle text-center" }, [
      _vm._v(" รวมประมาณการผลิต "),
      _c("br"),
      _vm._v(" (ล้านมวน) ")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("th", { staticClass: "align-middle text-center" }, [
      _vm._v(" รวมประมาณการขาย "),
      _c("br"),
      _vm._v(" (ล้านมวน) ")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("th", { staticClass: "align-middle text-center" }, [
      _vm._v(" ผลต่างผลิตหักขาย "),
      _c("br"),
      _vm._v(" (ล้านมวน) ")
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab3.vue?vue&type=template&id=5c406d82&":
/*!******************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Production-Yearly/components/Tab3.vue?vue&type=template&id=5c406d82& ***!
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
  return _c("div", [
    _c("div", {
      directives: [
        {
          name: "loading",
          rawName: "v-loading",
          value: _vm.loading,
          expression: "loading"
        }
      ],
      domProps: { innerHTML: _vm._s(_vm.html) }
    })
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);