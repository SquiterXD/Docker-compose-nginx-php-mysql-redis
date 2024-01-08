(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_Planning_Adjusts_ShowComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Adjusts/ModalCreate.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Adjusts/ModalCreate.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["btnTrans", "url", "modalCreateInput"],
  data: function data() {
    return {
      loading: false,
      html: ''
    };
  },
  mounted: function mounted() {// if (this.period_year_thai) {
    //     this.getBiweekly();
    // }
  },
  computed: {},
  watch: {// errors: {
    //     handler(val){
    //         val.period_year_thai? this.setError('period_year_thai') : this.resetError('period_year_thai');
    //         val.biweekly? this.setError('biweekly') : this.resetError('biweekly');
    //     },
    //     deep: true,
    // },
  },
  methods: {
    openModal: function openModal() {
      $('#modal_create').modal('show');
    },
    submit: function submit() {
      var vm = this;
      vm.loading = true;
      axios.post(vm.url.adjusts_store, {
        product_main_id: vm.modalCreateInput.pp04.product_main_id
      }).then(function (res) {
        swal({
          title: 'สร้างข้อมูลปรับแผน',
          text: '<span style="font-size: 16px; text-align: left;"> สร้างข้อมูลปรับแผนรายปักษ์สำเร็จแล้ว </span>',
          type: "success",
          html: true
        });
        window.location.href = res.data.data.redirect_show_page;
      })["catch"](function (err) {}).then(function () {
        vm.loading = false;
      });
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
                return axios.get(vm.url.ajax_adjusts_search_create, {
                  params: {
                    period_year_thai: vm.period_year_thai,
                    biweekly: vm.biweekly,
                    approved_status: vm.status
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
    },
    getBiweekly: function getBiweekly() {
      var _this2 = this;

      if (!this.search) {
        this.biweekly = '';
        this.month = '';
        this.times = '';
      }

      this.biWeeklyLists = this.pBiweekly.filter(function (item) {
        return item.thai_year.indexOf(_this2.period_year_thai) > -1;
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Adjusts/ModalSearch.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Adjusts/ModalSearch.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['budgetYears', 'monthList', 'pBiweekly', 'search', 'productTypes', "btnTrans", "url", 'defaultCurrentYear'],
  data: function data() {
    return {
      budget_year: this.defaultCurrentYear,
      biweekly: this.search.length ? String(this.search['biweekly']) : '',
      month: '',
      status: 'Active',
      statusLists: [{
        value: 'Active',
        label: 'Active'
      }, {
        value: 'Inactive',
        label: 'Inactive'
      }],
      biWeeklyLists: [],
      loading: false,
      b_loading: false,
      html: ''
    };
  },
  mounted: function mounted() {// if (this.budget_year) {
    //     this.getBiWeekly();
    // }
  },
  computed: {},
  watch: {
    errors: {
      handler: function handler(val) {
        val.budget_year ? this.setError('budget_year') : this.resetError('budget_year');
        val.biweekly ? this.setError('biweekly') : this.resetError('biweekly');
      },
      deep: true
    },
    budget_year: function () {
      var _budget_year = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee(value, oldValue) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                this.month = '';

              case 1:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this);
      }));

      function budget_year(_x, _x2) {
        return _budget_year.apply(this, arguments);
      }

      return budget_year;
    }(),
    month: function () {
      var _month = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2(value, oldValue) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                this.biweekly = '';

              case 1:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, this);
      }));

      function month(_x3, _x4) {
        return _month.apply(this, arguments);
      }

      return month;
    }()
  },
  methods: {
    openModal: function openModal() {
      $('#modal_search').modal('show');
    },
    searchForm: function searchForm() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                vm = _this;
                vm.loading = true;
                _context3.next = 4;
                return axios.get(vm.url.ajax_adjusts_search, {
                  params: {
                    budget_year: vm.budget_year,
                    biweekly: vm.biweekly,
                    thai_month: vm.month // approved_status: vm.status

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
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    getBiWeekly: function getBiWeekly() {
      var _this2 = this;

      if (!this.search) {
        this.biweekly = '';
        this.month = '';
        this.times = '';
      }

      this.biWeeklyLists = this.pBiweekly.filter(function (item) {
        return item.thai_year.indexOf(_this2.budget_year) > -1;
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Adjusts/SearchItem.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Adjusts/SearchItem.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["pHeader", "inventoryItemId", 'url'],
  computed: {},
  watch: {},
  data: function data() {
    return {
      itemId: this.inventoryItemId != undefined && this.inventoryItemId != '' ? parseInt(this.inventoryItemId) : '',
      loading: false,
      items: []
    };
  },
  mounted: function mounted() {
    console.log('Component mounted.');

    if (this.itemId !== "") {
      this.getItems({
        inventory_item_id: this.itemId,
        header: this.pHeader
      });
    } else {
      this.items = [];
    }
  },
  methods: {
    itemWasSelected: function itemWasSelected(selectItemId) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var vm, item;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                vm = _this;
                item = vm.items.filter(function (o) {
                  return o.inventory_item_id == selectItemId;
                });

                if (item.length) {
                  item = item[0];
                }

                vm.$emit("itemWasSelected", item);

              case 4:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    remoteMethod: function remoteMethod(query) {
      if (query !== "") {
        this.getItems({
          number: query,
          header: this.pHeader
        });
      } else {
        this.items = [];
      }
    },
    getItems: function getItems(params) {
      var vm = this;
      vm.loading = true;
      axios.get(vm.url.ajax_get_item, {
        params: params
      }).then(function (res) {
        var response = res.data.data;
        vm.loading = false;
        vm.items = response.items;
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Adjusts/ShowComponent.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Adjusts/ShowComponent.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _ModalCreate_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalCreate.vue */ "./resources/js/components/Planning/Adjusts/ModalCreate.vue");
/* harmony import */ var _ModalSearch_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ModalSearch.vue */ "./resources/js/components/Planning/Adjusts/ModalSearch.vue");
/* harmony import */ var _components_HeaderDetail_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./components/HeaderDetail.vue */ "./resources/js/components/Planning/Adjusts/components/HeaderDetail.vue");
/* harmony import */ var _SearchItem__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./SearchItem */ "./resources/js/components/Planning/Adjusts/SearchItem.vue");


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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
    // ModalCreate, ModalSearch, HeaderDetail, Tab1, Tab2, Tab3
    ModalCreate: _ModalCreate_vue__WEBPACK_IMPORTED_MODULE_1__.default,
    ModalSearch: _ModalSearch_vue__WEBPACK_IMPORTED_MODULE_2__.default,
    HeaderDetail: _components_HeaderDetail_vue__WEBPACK_IMPORTED_MODULE_3__.default,
    SearchItem: _SearchItem__WEBPACK_IMPORTED_MODULE_4__.default
  },
  props: ["adjustData", "modalCreateInput", "modalSearchInput", "colorCode", 'tabs', "pDateFormat", "productTypes", "ppBiWeekly", "workingHour", "omBiweeklyList", "calTypes", "calTypeDefault", "btnTrans", "url", "defProductType"],
  data: function data() {
    return {
      loading2: false,
      loading: {},
      defaultInput: this.pDefaultInput != undefined && this.pDefaultInput != '' ? this.pDefaultInput : null,
      selTabName: String(Object.keys(this.tabs)[0]),
      clickSelTabName: 'tab1',
      productType: this.defProductType,
      canEdit: false,
      canApprove: false,
      adjBiweeklyData: {},
      adjSummaryData: {},
      adjKkTableHtml: {},
      tab1Html: '',
      modalTotalWorking: {
        title: 'รายละเอียดชั่วโมงการทำงาน',
        btn_name: 'รายละเอียดการทำงาน'
      },
      showData: false,
      changeData: {},
      addLineData: {}
    };
  },
  mounted: function mounted() {
    var _this = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
      var vm;
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
        while (1) {
          switch (_context2.prev = _context2.next) {
            case 0:
              if (_this.adjustData != undefined && _this.adjustData != '') {
                // this.canEdit = this.adjustData.approved_status.toUpperCase() == 'INACTIVE' && this.adjustData.approved_date == null;
                _this.canEdit = _this.adjustData.approved_status.toUpperCase() == 'INACTIVE'; // this.canApprove = this.adjustData.approved_status.toUpperCase() == 'INACTIVE' && this.adjustData.approved_date == null;

                _this.canApprove = _this.adjustData.approved_status.toUpperCase() == 'INACTIVE';
              }

              vm = _this;
              Object.keys(vm.tabs).forEach( /*#__PURE__*/function () {
                var _ref = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee(tab) {
                  return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
                    while (1) {
                      switch (_context.prev = _context.next) {
                        case 0:
                          vm.$set(vm.loading, tab, false);
                          vm.$set(vm.adjBiweeklyData, tab, false);
                          vm.$set(vm.adjSummaryData, tab, []);
                          vm.$set(vm.adjKkTableHtml, tab, '');

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
              vm.getAdjData();

            case 4:
            case "end":
              return _context2.stop();
          }
        }
      }, _callee2);
    }))();
  },
  computed: {},
  watch: {
    selTabName: function () {
      var _selTabName = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3(value, oldValue) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                this.showData = false;
                this.getAdjData();

              case 2:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3, this);
      }));

      function selTabName(_x2, _x3) {
        return _selTabName.apply(this, arguments);
      }

      return selTabName;
    }(),
    clickSelTabName: function () {
      var _clickSelTabName = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4(value, oldValue) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                this.showData = false;
                this.getAdjData();

              case 2:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4, this);
      }));

      function clickSelTabName(_x4, _x5) {
        return _clickSelTabName.apply(this, arguments);
      }

      return clickSelTabName;
    }(),
    productType: function () {
      var _productType = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5(value, oldValue) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                this.showData = false;
                this.getAdjData();

              case 2:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5, this);
      }));

      function productType(_x6, _x7) {
        return _productType.apply(this, arguments);
      }

      return productType;
    }()
  },
  methods: {
    addLine: function addLine() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6() {
        var vm, cloneLine, rowLength;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                vm = _this2;
                cloneLine = JSON.parse(JSON.stringify(vm.adjBiweeklyData[vm.productType][vm.adjustData.current_biweekly]));
                rowLength = Object.keys(cloneLine).length;
                cloneLine = cloneLine[Object.keys(cloneLine)[0]];
                cloneLine.is_new_line = true;
                cloneLine.stamp_desc = '';
                cloneLine.item_id = '';
                cloneLine.item_code = '';
                cloneLine.item_description = '';
                cloneLine.curr_onhnad_qty = '';
                cloneLine.def_planning_qty = '';
                cloneLine.def_bal_sale_day = '';
                cloneLine.def_forcast_qty = '';
                cloneLine.def_bal_onhand_qty = '';
                cloneLine.def_ending_sale_day = '';
                cloneLine.bal_sale_day = '';
                cloneLine.forcast_qty = '';
                cloneLine.bal_onhand_qty = '';
                cloneLine.ending_sale_day = '';

                _this2.$set(vm.adjBiweeklyData[vm.productType][vm.adjustData.current_biweekly], 'new-' + rowLength, cloneLine);

                _this2.remoteMethod(' ', vm.adjBiweeklyData[vm.productType][vm.adjustData.current_biweekly]['new-' + rowLength]);

              case 21:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      }))();
    },
    changeInput: function changeInput(line) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee7() {
        var row, data;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                row = Object.keys(_this3.changeData).length;
                data = JSON.parse(JSON.stringify(line));
                data['value'] = data.planning_qty; // this.$set(data, 'value', value);

                _this3.$set(_this3.changeData, 'case3-' + data.item_id, data);

                console.log('changeInput', data.planning_qty, line.planning_qty);
                console.log('changeInput', _this3.changeData['case3-' + data.item_id].value);

              case 6:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7);
      }))();
    },
    getAdjData: function getAdjData() {
      var _arguments = arguments,
          _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee8() {
        var reload, vm, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee8$(_context8) {
          while (1) {
            switch (_context8.prev = _context8.next) {
              case 0:
                reload = _arguments.length > 0 && _arguments[0] !== undefined ? _arguments[0] : false;
                vm = _this4;

                if (reload) {
                  _context8.next = 7;
                  break;
                }

                if (!(vm.productType == undefined || vm.productType == '' || Object.keys(vm.tabs).length == 0)) {
                  _context8.next = 5;
                  break;
                }

                return _context8.abrupt("return");

              case 5:
                if (!(!vm.adjustData || !vm.productType || vm.loading[vm.productType])) {
                  _context8.next = 7;
                  break;
                }

                return _context8.abrupt("return");

              case 7:
                vm.changeData = {};
                vm.addLineData = {};
                vm.loading2 = true;
                vm.loading[vm.productType] = true;
                vm.adjBiweeklyData[vm.productType] = false;
                vm.adjKkTableHtml[vm.productType] = '';
                vm.adjSummaryData[vm.productType] = [];
                params = {
                  product_main_id: vm.adjustData.product_main_id,
                  product_type: vm.productType
                };
                _context8.next = 17;
                return axios.get(vm.url.ajax_get_adj_data, {
                  params: params
                }).then(function (res) {
                  var data = res.data.data;
                  vm.adjBiweeklyData[vm.productType] = data.adj_biweekly;
                  vm.adjKkTableHtml[vm.productType] = data.adj_kk_table_html;
                  vm.adjSummaryData[vm.productType] = data.adj_summary;
                  vm.tab1Html = data.tab1_html;
                  vm.showData = true;
                })["catch"](function (err) {
                  console.log('error');
                  var data = err.response.data;
                  alert(data.message);
                }).then(function () {
                  vm.loading[vm.productType] = false;
                  vm.loading2 = false;
                });

              case 17:
              case "end":
                return _context8.stop();
            }
          }
        }, _callee8);
      }))();
    },
    saveChangeInput: function saveChangeInput() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee10() {
        var vm, swalConfirm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee10$(_context10) {
          while (1) {
            switch (_context10.prev = _context10.next) {
              case 0:
                vm = _this5;

                if (vm.canEdit) {
                  _context10.next = 3;
                  break;
                }

                return _context10.abrupt("return");

              case 3:
                if (!(Object.keys(vm.changeData).length == 0 && Object.keys(vm.addLineData).length == 0)) {
                  _context10.next = 6;
                  break;
                }

                swal({
                  title: 'อัพเดทแผนการผลิต',
                  text: '<span style="font-size: 16px; text-align: left;"> ไม่พบข้อูลการอัพเดท </span>',
                  type: "warning",
                  html: true
                });
                return _context10.abrupt("return");

              case 6:
                swalConfirm = swal({
                  html: true,
                  title: 'อัพเดทแผนการผลิต ?',
                  text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการอัพเดทแผนการผลิต ? </span></h2>',
                  showCancelButton: true,
                  confirmButtonText: vm.btnTrans.ok.text,
                  cancelButtonText: vm.btnTrans.cancel.text,
                  // confirmButtonClass: 'btn btn-danger',
                  // cancelButtonClass: 'btn btn-white',
                  confirmButtonClass: vm.btnTrans.ok["class"] + ' btn-lg tw-w-25',
                  cancelButtonClass: vm.btnTrans.cancel["class"] + ' btn-lg tw-w-25',
                  closeOnConfirm: false,
                  closeOnCancel: true,
                  showLoaderOnConfirm: true
                }, /*#__PURE__*/function () {
                  var _ref2 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee9(isConfirm) {
                    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee9$(_context9) {
                      while (1) {
                        switch (_context9.prev = _context9.next) {
                          case 0:
                            if (!isConfirm) {
                              _context9.next = 3;
                              break;
                            }

                            _context9.next = 3;
                            return axios.patch(vm.url.ajax_adjusts_update, {
                              lines: vm.changeData,
                              new_lines: vm.addLineData
                            }).then(function (res) {
                              if (res.data.data.status == 'S') {
                                swal({
                                  title: 'อัพเดทแผนการผลิต',
                                  text: '<span style="font-size: 16px; text-align: left;"> อัพเดทแผนการผลิตสำเร็จ </span>',
                                  type: "success",
                                  html: true
                                });
                                vm.getAdjData(true); // vm.setLastUpdateDateFormat(res.data.data.last_update_date)
                                // vm.changeData = {};
                                // if (vm.selTabName == 'tab2') {
                                //     vm.refreshTab2 = vm.refreshTab2 + 1;
                                // }
                              }

                              if (res.data.data.status != 'S' && false) {
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
                            return _context9.stop();
                        }
                      }
                    }, _callee9);
                  }));

                  return function (_x8) {
                    return _ref2.apply(this, arguments);
                  };
                }());

              case 7:
              case "end":
                return _context10.stop();
            }
          }
        }, _callee10);
      }))();
    },
    selectItem: function selectItem(line) {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee11() {
        var item, row, data;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee11$(_context11) {
          while (1) {
            switch (_context11.prev = _context11.next) {
              case 0:
                item = line.item_list.findIndex(function (o) {
                  return o.inventory_item_id == line.item_id;
                });
                item = line.item_list[item];
                line.stamp = item.stamp;
                line.stamp_desc = item.stamp_desc;
                line.item_code = item.item_code;
                line.item_description = item.item_description;
                line.organization_id = item.organization_id;
                line.inventory_item_id = item.inventory_item_id; // category_concat_segs: "15.01"
                // category_id: "5747"
                // category_segment2: "01"
                // category_set_id: "1100000041"
                // category_set_name: "TOAT_INV_ITEM_CATEGORY_SET"
                // category_setment1: "15"
                // category_type: "IMPORT"
                // inventory_item_id: "147004"
                // item_code: "15012343"
                // item_description: "KRONG THIP 7.1 สีแดง"
                // organization_code: "A01"
                // organization_id: "164"
                // product_type: "71"
                // rn: "2"
                // stamp: null
                // stamp_desc: null

                console.log('selectItem', line.item_list, 'xx1', item, 'xx', line.item_id, line.item_code, line);
                row = Object.keys(_this6.addLineData).length;
                data = JSON.parse(JSON.stringify(line));

                _this6.$set(_this6.addLineData, 'add-' + data.item_id, data);

              case 12:
              case "end":
                return _context11.stop();
            }
          }
        }, _callee11);
      }))();
    },
    remoteMethod: function remoteMethod(query, line) {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee12() {
        var vm, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee12$(_context12) {
          while (1) {
            switch (_context12.prev = _context12.next) {
              case 0:
                console.log('remoteMethod');
                vm = _this7;
                params = {
                  number: query,
                  product_main_id: vm.adjustData.product_main_id,
                  product_type: vm.productType
                };
                axios.get(vm.url.ajax_search_item, {
                  params: params
                }).then(function (res) {
                  var response = res.data.data;
                  line['item_list'] = response['item_list'];
                }); // row[inputName] = [];
                // let line = _.clone(row);
                //     line.casing_leaf_formula_list = [];
                //     line.casing_list = [];
                // if (query !== "") {
                //     // this.getData({
                //     //     number: query,
                //     //     header: this.header,
                //     //     line: line,
                //     //     type: inputName
                //     // }, row, inputName);
                // }

              case 4:
              case "end":
                return _context12.stop();
            }
          }
        }, _callee12);
      }))();
    },
    delLine: function delLine(line, index) {
      var vm = this;
      vm.$delete(vm.adjBiweeklyData[vm.productType][vm.adjustData.current_biweekly], index);
      vm.$delete(vm.changeData, 'case3-' + line.item_id);
      vm.$delete(vm.addLineData, 'add-' + line.item_id);
    },
    checkApprove: function checkApprove() {
      var _this8 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee15() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee15$(_context15) {
          while (1) {
            switch (_context15.prev = _context15.next) {
              case 0:
                vm = _this8;

                if (vm.canApprove) {
                  _context15.next = 3;
                  break;
                }

                return _context15.abrupt("return");

              case 3:
                vm.loading.approveProcess = true;
                _context15.next = 6;
                return axios.get(vm.url.ajax_check_approve).then(function (res) {
                  if (res.data.data.status == 'S') {
                    swal({
                      html: true,
                      title: 'อนุมัตปรับประมาณการผลิตประจำปักษ์',
                      text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการอนุมัตปรับประมาณการผลิตประจำปักษ์ ? </span></h2>',
                      showCancelButton: true,
                      confirmButtonText: vm.btnTrans.ok.text,
                      cancelButtonText: vm.btnTrans.cancel.text,
                      // confirmButtonClass: 'btn btn-danger',
                      // cancelButtonClass: 'btn btn-white',
                      confirmButtonClass: vm.btnTrans.ok["class"] + ' btn-lg tw-w-25',
                      cancelButtonClass: vm.btnTrans.cancel["class"] + ' btn-lg tw-w-25',
                      closeOnConfirm: false,
                      closeOnCancel: true,
                      showLoaderOnConfirm: true
                    }, /*#__PURE__*/function () {
                      var _ref3 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee13(isConfirm) {
                        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee13$(_context13) {
                          while (1) {
                            switch (_context13.prev = _context13.next) {
                              case 0:
                                if (isConfirm) {
                                  vm.approve();
                                }

                              case 1:
                              case "end":
                                return _context13.stop();
                            }
                          }
                        }, _callee13);
                      }));

                      return function (_x9) {
                        return _ref3.apply(this, arguments);
                      };
                    }());
                  } else {
                    swal({
                      title: 'อนุมัตปรับประมาณการผลิตประจำปักษ์',
                      text: res.data.data.msg,
                      // type: "warning",
                      html: true,
                      showCancelButton: true,
                      confirmButtonText: vm.btnTrans.ok.text,
                      cancelButtonText: vm.btnTrans.cancel.text,
                      // confirmButtonClass: 'btn btn-danger',
                      // cancelButtonClass: 'btn btn-white',
                      confirmButtonClass: vm.btnTrans.ok["class"] + ' btn-lg tw-w-25',
                      cancelButtonClass: vm.btnTrans.cancel["class"] + ' btn-lg tw-w-25',
                      closeOnConfirm: false,
                      closeOnCancel: true,
                      showLoaderOnConfirm: true
                    }, /*#__PURE__*/function () {
                      var _ref4 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee14(isConfirm) {
                        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee14$(_context14) {
                          while (1) {
                            switch (_context14.prev = _context14.next) {
                              case 0:
                                if (isConfirm) {
                                  console.log('Approve');
                                  vm.approve();
                                }

                              case 1:
                              case "end":
                                return _context14.stop();
                            }
                          }
                        }, _callee14);
                      }));

                      return function (_x10) {
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
                return _context15.stop();
            }
          }
        }, _callee15);
      }))();
    },
    approve: function approve() {
      var _this9 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee16() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee16$(_context16) {
          while (1) {
            switch (_context16.prev = _context16.next) {
              case 0:
                vm = _this9;
                _context16.next = 3;
                return axios.patch(vm.url.ajax_approve).then(function (res) {
                  if (res.data.data.status == 'S') {
                    swal({
                      title: 'อนุมัตปรับประมาณการผลิตประจำปักษ์',
                      text: '<span style="font-size: 16px; text-align: left;"> อนุมัตปรับประมาณการผลิตประจำปักษ์เรียบร้อย </span>',
                      type: "success",
                      html: true
                    });
                    vm.tab2AvgChangeData = {};

                    if (vm.productType == 'tab2') {
                      vm.refreshTab2 = vm.refreshTab2 + 1;
                    }

                    vm.canEdit = false;
                    vm.canApprove = false;
                    vm.adjustData = res.data.data.prod_biweekly_main;
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
                return _context16.stop();
            }
          }
        }, _callee16);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Adjusts/components/HeaderDetail.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Adjusts/components/HeaderDetail.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["adjustData", "btnTrans", "canEdit", "url"],
  data: function data() {
    return {
      statusLists: [{
        value: 'Active',
        label: 'Active'
      }, {
        value: 'Inactive',
        label: 'Inactive'
      }],
      oldNote: this.adjustData ? this.adjustData['note'] : '',
      note: this.adjustData ? this.adjustData['note'] : '',
      loading: false
    };
  },
  methods: {
    updateNoteForm: function updateNoteForm() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                vm = _this;
                swal({
                  title: 'อัพเดทหมายเหตุ',
                  text: 'ยืนยันอัพเดทหมายเหตุ ?',
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
                  var _ref = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee(isConfirm) {
                    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
                      while (1) {
                        switch (_context.prev = _context.next) {
                          case 0:
                            if (isConfirm) {
                              vm.update();
                            }

                          case 1:
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

              case 2:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    update: function update() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var vm, isSuccess;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                vm = _this2;
                isSuccess = false;
                vm.loading = true;
                _context3.next = 5;
                return axios.patch(vm.url.ajax_update_note).then(function (res) {
                  if (res.data.data.status == 'S') {
                    isSuccess = true;
                    swal({
                      title: 'อัพเดทหมายเหตุ',
                      text: '<span style="font-size: 16px; text-align: left;"> อัพเดทหมายเหตุเรียบร้อย </span>',
                      type: "success",
                      html: true
                    });
                    vm.oldNote = vm.note;
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
                }).then(function () {
                  vm.loading = false; // swal.close();
                });

              case 5:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    }
  },
  watch: {// canEdit(newValue) {
    //     this.canEdit = newValue;
    // }
  },
  computed: {
    showSaveNote: function showSaveNote() {
      if (this.note != this.oldNote) {
        return true;
      } else {
        return false;
      }
    }
  }
});

/***/ }),

/***/ "./resources/js/components/Planning/Adjusts/ModalCreate.vue":
/*!******************************************************************!*\
  !*** ./resources/js/components/Planning/Adjusts/ModalCreate.vue ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ModalCreate_vue_vue_type_template_id_45e6ed37___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ModalCreate.vue?vue&type=template&id=45e6ed37& */ "./resources/js/components/Planning/Adjusts/ModalCreate.vue?vue&type=template&id=45e6ed37&");
/* harmony import */ var _ModalCreate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalCreate.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Adjusts/ModalCreate.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _ModalCreate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ModalCreate_vue_vue_type_template_id_45e6ed37___WEBPACK_IMPORTED_MODULE_0__.render,
  _ModalCreate_vue_vue_type_template_id_45e6ed37___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Adjusts/ModalCreate.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Adjusts/ModalSearch.vue":
/*!******************************************************************!*\
  !*** ./resources/js/components/Planning/Adjusts/ModalSearch.vue ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ModalSearch_vue_vue_type_template_id_6c1d083a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ModalSearch.vue?vue&type=template&id=6c1d083a& */ "./resources/js/components/Planning/Adjusts/ModalSearch.vue?vue&type=template&id=6c1d083a&");
/* harmony import */ var _ModalSearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalSearch.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Adjusts/ModalSearch.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _ModalSearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ModalSearch_vue_vue_type_template_id_6c1d083a___WEBPACK_IMPORTED_MODULE_0__.render,
  _ModalSearch_vue_vue_type_template_id_6c1d083a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Adjusts/ModalSearch.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Adjusts/SearchItem.vue":
/*!*****************************************************************!*\
  !*** ./resources/js/components/Planning/Adjusts/SearchItem.vue ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _SearchItem_vue_vue_type_template_id_1443be1d___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SearchItem.vue?vue&type=template&id=1443be1d& */ "./resources/js/components/Planning/Adjusts/SearchItem.vue?vue&type=template&id=1443be1d&");
/* harmony import */ var _SearchItem_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SearchItem.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Adjusts/SearchItem.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _SearchItem_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _SearchItem_vue_vue_type_template_id_1443be1d___WEBPACK_IMPORTED_MODULE_0__.render,
  _SearchItem_vue_vue_type_template_id_1443be1d___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Adjusts/SearchItem.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Adjusts/ShowComponent.vue":
/*!********************************************************************!*\
  !*** ./resources/js/components/Planning/Adjusts/ShowComponent.vue ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ShowComponent_vue_vue_type_template_id_360948ae___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ShowComponent.vue?vue&type=template&id=360948ae& */ "./resources/js/components/Planning/Adjusts/ShowComponent.vue?vue&type=template&id=360948ae&");
/* harmony import */ var _ShowComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ShowComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Adjusts/ShowComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _ShowComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ShowComponent_vue_vue_type_template_id_360948ae___WEBPACK_IMPORTED_MODULE_0__.render,
  _ShowComponent_vue_vue_type_template_id_360948ae___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Adjusts/ShowComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Adjusts/components/HeaderDetail.vue":
/*!******************************************************************************!*\
  !*** ./resources/js/components/Planning/Adjusts/components/HeaderDetail.vue ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _HeaderDetail_vue_vue_type_template_id_414a89f6___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./HeaderDetail.vue?vue&type=template&id=414a89f6& */ "./resources/js/components/Planning/Adjusts/components/HeaderDetail.vue?vue&type=template&id=414a89f6&");
/* harmony import */ var _HeaderDetail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./HeaderDetail.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Adjusts/components/HeaderDetail.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _HeaderDetail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _HeaderDetail_vue_vue_type_template_id_414a89f6___WEBPACK_IMPORTED_MODULE_0__.render,
  _HeaderDetail_vue_vue_type_template_id_414a89f6___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Adjusts/components/HeaderDetail.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Adjusts/ModalCreate.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/components/Planning/Adjusts/ModalCreate.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalCreate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalCreate.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Adjusts/ModalCreate.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalCreate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Adjusts/ModalSearch.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/components/Planning/Adjusts/ModalSearch.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearch.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Adjusts/ModalSearch.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Adjusts/SearchItem.vue?vue&type=script&lang=js&":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/Planning/Adjusts/SearchItem.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchItem_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SearchItem.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Adjusts/SearchItem.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchItem_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Adjusts/ShowComponent.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************!*\
  !*** ./resources/js/components/Planning/Adjusts/ShowComponent.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ShowComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Adjusts/ShowComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Adjusts/components/HeaderDetail.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Adjusts/components/HeaderDetail.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_HeaderDetail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./HeaderDetail.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Adjusts/components/HeaderDetail.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_HeaderDetail_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Adjusts/ModalCreate.vue?vue&type=template&id=45e6ed37&":
/*!*************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Adjusts/ModalCreate.vue?vue&type=template&id=45e6ed37& ***!
  \*************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalCreate_vue_vue_type_template_id_45e6ed37___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalCreate_vue_vue_type_template_id_45e6ed37___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalCreate_vue_vue_type_template_id_45e6ed37___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalCreate.vue?vue&type=template&id=45e6ed37& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Adjusts/ModalCreate.vue?vue&type=template&id=45e6ed37&");


/***/ }),

/***/ "./resources/js/components/Planning/Adjusts/ModalSearch.vue?vue&type=template&id=6c1d083a&":
/*!*************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Adjusts/ModalSearch.vue?vue&type=template&id=6c1d083a& ***!
  \*************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_template_id_6c1d083a___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_template_id_6c1d083a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSearch_vue_vue_type_template_id_6c1d083a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSearch.vue?vue&type=template&id=6c1d083a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Adjusts/ModalSearch.vue?vue&type=template&id=6c1d083a&");


/***/ }),

/***/ "./resources/js/components/Planning/Adjusts/SearchItem.vue?vue&type=template&id=1443be1d&":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Adjusts/SearchItem.vue?vue&type=template&id=1443be1d& ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchItem_vue_vue_type_template_id_1443be1d___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchItem_vue_vue_type_template_id_1443be1d___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchItem_vue_vue_type_template_id_1443be1d___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SearchItem.vue?vue&type=template&id=1443be1d& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Adjusts/SearchItem.vue?vue&type=template&id=1443be1d&");


/***/ }),

/***/ "./resources/js/components/Planning/Adjusts/ShowComponent.vue?vue&type=template&id=360948ae&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Adjusts/ShowComponent.vue?vue&type=template&id=360948ae& ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowComponent_vue_vue_type_template_id_360948ae___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowComponent_vue_vue_type_template_id_360948ae___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ShowComponent_vue_vue_type_template_id_360948ae___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ShowComponent.vue?vue&type=template&id=360948ae& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Adjusts/ShowComponent.vue?vue&type=template&id=360948ae&");


/***/ }),

/***/ "./resources/js/components/Planning/Adjusts/components/HeaderDetail.vue?vue&type=template&id=414a89f6&":
/*!*************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Adjusts/components/HeaderDetail.vue?vue&type=template&id=414a89f6& ***!
  \*************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HeaderDetail_vue_vue_type_template_id_414a89f6___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HeaderDetail_vue_vue_type_template_id_414a89f6___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_HeaderDetail_vue_vue_type_template_id_414a89f6___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./HeaderDetail.vue?vue&type=template&id=414a89f6& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Adjusts/components/HeaderDetail.vue?vue&type=template&id=414a89f6&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Adjusts/ModalCreate.vue?vue&type=template&id=45e6ed37&":
/*!****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Adjusts/ModalCreate.vue?vue&type=template&id=45e6ed37& ***!
  \****************************************************************************************************************************************************************************************************************************************/
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
        _vm._v(
          "\n        " + _vm._s(_vm.btnTrans.create.text) + "ปรับแผน\n    "
        )
      ]
    ),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass: "modal inmodal fade",
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
                            _c("el-input", {
                              attrs: {
                                value:
                                  _vm.modalCreateInput.pp04.period_year_thai,
                                size: "large",
                                readonly: true
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
                          "form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2"
                      },
                      [
                        _c(
                          "label",
                          {
                            staticClass:
                              "text-left tw-font-bold tw-uppercase mb-1"
                          },
                          [_vm._v(" ปักษ์ปัจจุบันที่ :")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          {},
                          [
                            _c("el-input", {
                              attrs: {
                                value: _vm.modalCreateInput.pp04.biweekly,
                                size: "large",
                                readonly: true
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
                          "form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2"
                      },
                      [
                        _c(
                          "label",
                          {
                            staticClass:
                              "text-left tw-font-bold tw-uppercase mb-1"
                          },
                          [_vm._v(" ปรับครั้งที่ :")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          {},
                          [
                            _c("el-input", {
                              attrs: {
                                value: _vm.modalCreateInput.pp04.adjust_no,
                                size: "large",
                                readonly: true
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
                          "form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2"
                      },
                      [
                        _c(
                          "label",
                          {
                            staticClass:
                              "text-left tw-font-bold tw-uppercase mb-1"
                          },
                          [_vm._v(" ประจำเดือน :")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          {},
                          [
                            _c("el-input", {
                              attrs: {
                                value: _vm.modalCreateInput.pp04.thai_month,
                                size: "large",
                                readonly: true
                              }
                            })
                          ],
                          1
                        )
                      ]
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { domProps: { innerHTML: _vm._s(_vm.html) } })
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "modal-footer" }, [
                  _c(
                    "button",
                    {
                      staticClass: "btn btn-white",
                      attrs: { type: "button", "data-dismiss": "modal" }
                    },
                    [_vm._v("Close")]
                  ),
                  _vm._v(" "),
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
                      _c("i", { class: _vm.btnTrans.create.icon }),
                      _vm._v(
                        "\n                        " +
                          _vm._s(_vm.btnTrans.create.text) +
                          "\n                    "
                      )
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
        "button",
        {
          staticClass: "close",
          attrs: { type: "button", "data-dismiss": "modal" }
        },
        [
          _c("span", { attrs: { "aria-hidden": "true" } }, [_vm._v("×")]),
          _c("span", { staticClass: "sr-only" }, [_vm._v("Close")])
        ]
      ),
      _vm._v(" "),
      _c("h4", { staticClass: "modal-title" }, [
        _vm._v("ปรับแผนประมาณการผลิต")
      ]),
      _vm._v(" "),
      _c("small", { staticClass: "font-bold" }, [
        _vm._v("\n                         \n                    ")
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Adjusts/ModalSearch.vue?vue&type=template&id=6c1d083a&":
/*!****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Adjusts/ModalSearch.vue?vue&type=template&id=6c1d083a& ***!
  \****************************************************************************************************************************************************************************************************************************************/
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
        staticClass: "modal inmodal fade",
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
                              _vm._l(_vm.budgetYears, function(year, index) {
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
                              attrs: { type: "hidden" },
                              domProps: { value: _vm.month }
                            }),
                            _vm._v(" "),
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
                                  value: _vm.month,
                                  callback: function($$v) {
                                    _vm.month = $$v
                                  },
                                  expression: "month"
                                }
                              },
                              _vm._l(_vm.monthList[_vm.budget_year], function(
                                month,
                                index
                              ) {
                                return _c("el-option", {
                                  key: index,
                                  attrs: { label: index, value: index }
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
                              domProps: { value: _vm.biweekly }
                            }),
                            _vm._v(" "),
                            _vm.budget_year != "" && _vm.month != ""
                              ? _c(
                                  "el-select",
                                  {
                                    attrs: {
                                      clearable: "",
                                      size: "large",
                                      placeholder: "ปักษ์",
                                      "popper-append-to-body": false
                                    },
                                    model: {
                                      value: _vm.biweekly,
                                      callback: function($$v) {
                                        _vm.biweekly = $$v
                                      },
                                      expression: "biweekly"
                                    }
                                  },
                                  _vm._l(
                                    _vm.monthList[_vm.budget_year][_vm.month],
                                    function(biweekly, index) {
                                      return _c("el-option", {
                                        key: index,
                                        attrs: {
                                          label: biweekly.biweekly,
                                          value: biweekly.biweekly
                                        }
                                      })
                                    }
                                  ),
                                  1
                                )
                              : _c(
                                  "el-select",
                                  {
                                    attrs: {
                                      disabled: "",
                                      clearable: "",
                                      size: "large",
                                      placeholder: "ปักษ์",
                                      filterable: ""
                                    },
                                    model: {
                                      value: _vm.biweekly,
                                      callback: function($$v) {
                                        _vm.biweekly = $$v
                                      },
                                      expression: "biweekly"
                                    }
                                  },
                                  [
                                    _c("el-option", {
                                      key: "",
                                      attrs: { label: "", value: "" }
                                    })
                                  ],
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
                          "form-group text-right  pr-2 mb-0 col-lg-2 col-md-10 col-sm-12 col-xs-12"
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
        "button",
        {
          staticClass: "close",
          attrs: { type: "button", "data-dismiss": "modal" }
        },
        [
          _c("span", { attrs: { "aria-hidden": "true" } }, [_vm._v("×")]),
          _c("span", { staticClass: "sr-only" }, [_vm._v("Close")])
        ]
      ),
      _vm._v(" "),
      _c("h4", { staticClass: "modal-title" }, [
        _vm._v("ค้นหาแผนประมาณการผลิต")
      ]),
      _vm._v(" "),
      _c("small", { staticClass: "font-bold" }, [
        _vm._v("\n                         \n                    ")
      ])
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Adjusts/SearchItem.vue?vue&type=template&id=1443be1d&":
/*!***************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Adjusts/SearchItem.vue?vue&type=template&id=1443be1d& ***!
  \***************************************************************************************************************************************************************************************************************************************/
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
          attrs: {
            filterable: "",
            remote: "",
            placeholder: "รหัสวัตถุดิบ",
            "remote-method": _vm.remoteMethod,
            loading: _vm.loading,
            "popper-append-to-body": false
          },
          on: { change: _vm.itemWasSelected },
          model: {
            value: _vm.itemId,
            callback: function($$v) {
              _vm.itemId = $$v
            },
            expression: "itemId"
          }
        },
        _vm._l(_vm.items, function(item, index) {
          return _c("el-option", {
            key: parseInt(item.inventory_item_id),
            attrs: {
              label: item.display,
              value: parseInt(item.inventory_item_id)
            }
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



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Adjusts/ShowComponent.vue?vue&type=template&id=360948ae&":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Adjusts/ShowComponent.vue?vue&type=template&id=360948ae& ***!
  \******************************************************************************************************************************************************************************************************************************************/
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
          value: _vm.loading.approveProcess,
          expression: "loading.approveProcess"
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
                btnTrans: _vm.btnTrans,
                url: _vm.url,
                budgetYears: _vm.modalSearchInput.budget_years,
                monthList: _vm.modalSearchInput.month_list,
                defaultCurrentYear: _vm.modalSearchInput.def_period_year,
                canEdit: _vm.canEdit,
                search: []
              }
            }),
            _vm._v(" "),
            _c("modal-create", {
              staticClass: "pr-2",
              attrs: {
                btnTrans: _vm.btnTrans,
                url: _vm.url,
                modalCreateInput: _vm.modalCreateInput
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
                        return _vm.saveChangeInput()
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
                      "\n                " +
                        _vm._s(_vm.btnTrans.approve.text) +
                        "\n            "
                    )
                  ]
                )
              : _vm._e(),
            _vm._v(" "),
            _vm.adjustData
              ? _c(
                  "a",
                  {
                    class: _vm.btnTrans.print.class + " btn-lg tw-w-25",
                    attrs: {
                      target: "_blank",
                      href:
                        "/ir/reports/get-param?period_year=" +
                        _vm.adjustData.period_year +
                        "&month=" +
                        _vm.adjustData.period_num +
                        "&biweekly=" +
                        _vm.adjustData.biweekly +
                        "&version_no=" +
                        _vm.adjustData.adjust_no +
                        "&program_code=PPR0011&function_name=PPR0011&output=pdf",
                      type: "button"
                    }
                  },
                  [
                    _c("i", { class: _vm.btnTrans.print.icon }),
                    _vm._v(
                      "\n                " +
                        _vm._s(_vm.btnTrans.print.text) +
                        "\n            "
                    )
                  ]
                )
              : _vm._e()
          ],
          1
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
                url: _vm.url,
                canEdit: _vm.canEdit,
                btnTrans: _vm.btnTrans,
                adjustData: _vm.adjustData
              }
            }),
            _vm._v(" "),
            _c("div", { staticClass: "row" }, [
              _c("div", { staticClass: "col-8 b-r" }, [
                _c("div", { staticClass: "row" }, [
                  _c("div", { staticClass: "col-lg-12" }, [
                    _c("dl", { staticClass: "row mb-0 mt-3" }, [
                      _vm._m(0),
                      _vm._v(" "),
                      _c("div", { staticClass: "col-sm-8 text-sm-left" }, [
                        _c(
                          "div",
                          [
                            _c(
                              "el-radio-group",
                              {
                                attrs: { size: "small" },
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
                                          "\n                                                " +
                                            _vm._s(product.meaning) +
                                            "\n                                            "
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
                      ])
                    ])
                  ])
                ])
              ])
            ])
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "tabs-container mb-3" }, [
        _c("ul", { staticClass: "nav nav-tabs", attrs: { role: "tablist" } }, [
          _c("li", [
            _c(
              "a",
              {
                staticClass: "nav-link active",
                attrs: { "data-toggle": "tab", href: "#tab1" },
                on: {
                  click: function($event) {
                    _vm.clickSelTabName = "tab1"
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
                staticClass: "nav-link ",
                attrs: { "data-toggle": "tab", href: "#tab2" },
                on: {
                  click: function($event) {
                    _vm.clickSelTabName = "tab2"
                  }
                }
              },
              [
                _vm._v(
                  "\n                    ประมาณการผลิตแยกรายตรา\n                "
                )
              ]
            )
          ])
        ]),
        _vm._v(" "),
        _c(
          "div",
          {
            directives: [
              {
                name: "loading",
                rawName: "v-loading",
                value: _vm.loading2,
                expression: "loading2"
              }
            ],
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
                  _c("div", { domProps: { innerHTML: _vm._s(_vm.tab1Html) } })
                ])
              ]
            ),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass: "tab-pane ",
                attrs: { role: "tabpanel", id: "tab2" }
              },
              [
                _c("div", { staticClass: "panel-body " }, [
                  _vm.productType == "KK"
                    ? _c("div", {
                        domProps: {
                          innerHTML: _vm._s(_vm.adjKkTableHtml[_vm.productType])
                        }
                      })
                    : _c("div", {}, [
                        _vm.showData && false
                          ? _c(
                              "div",
                              { staticClass: "col-lg-12 text-right " },
                              [
                                _vm._l(
                                  _vm.adjSummaryData[_vm.productType],
                                  function(summary, sumKey, sumIndex) {
                                    return [
                                      _c("modal-html", {
                                        staticClass: "text-right",
                                        attrs: {
                                          modalId: sumKey,
                                          html: summary["total_working_html"],
                                          modalTitle:
                                            _vm.modalTotalWorking.title +
                                            " ปักษ์ที่ " +
                                            sumKey,
                                          btnTrans: _vm.btnTrans,
                                          btnText:
                                            _vm.modalTotalWorking.btn_name
                                        }
                                      })
                                    ]
                                  }
                                ),
                                _vm._v(" "),
                                _c(
                                  "button",
                                  {
                                    class:
                                      _vm.btnTrans.create.class +
                                      " btn-lg tw-w-25",
                                    attrs: {
                                      type: "button",
                                      disabled: !_vm.canEdit
                                    },
                                    on: {
                                      click: function($event) {
                                        return _vm.addLine()
                                      }
                                    }
                                  },
                                  [
                                    _c("i", {
                                      class: _vm.btnTrans.create.icon
                                    }),
                                    _vm._v(
                                      "\n                                เพิ่มตราบุหรี่\n                            "
                                    )
                                  ]
                                )
                              ],
                              2
                            )
                          : _vm._e(),
                        _vm._v(" "),
                        _c("div", { staticClass: "hr-line-dashed" }),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "table-responsive m-t mb-3" },
                          [
                            _vm.adjBiweeklyData[_vm.productType]
                              ? _c(
                                  "table",
                                  {
                                    staticClass:
                                      "table-freeze table text-nowrap table-bordered"
                                  },
                                  [
                                    _c("thead", [
                                      _c(
                                        "tr",
                                        [
                                          _c(
                                            "th",
                                            {
                                              staticClass:
                                                "align-middle text-center",
                                              attrs: { rowspan: "2" }
                                            },
                                            [_vm._v("ลำดับ")]
                                          ),
                                          _vm._v(" "),
                                          _vm._m(1),
                                          _vm._v(" "),
                                          _c(
                                            "th",
                                            {
                                              staticClass:
                                                "align-middle text-center",
                                              attrs: { rowspan: "2" }
                                            },
                                            [_vm._v("ตราบุหรี่")]
                                          ),
                                          _vm._v(" "),
                                          _vm._l(
                                            _vm.adjBiweeklyData[
                                              _vm.productType
                                            ],
                                            function(
                                              biweekly,
                                              keyBiweekly,
                                              index
                                            ) {
                                              return [
                                                _c(
                                                  "th",
                                                  {
                                                    staticClass:
                                                      "text-center text-white",
                                                    style:
                                                      "background-color: " +
                                                      _vm.colorCode.biweekly[
                                                        index
                                                      ],
                                                    attrs: { colspan: "7" }
                                                  },
                                                  [
                                                    _vm._v(
                                                      "\n                                            ปักษ์ที่ " +
                                                        _vm._s(keyBiweekly) +
                                                        "\n                                        "
                                                    )
                                                  ]
                                                )
                                              ]
                                            }
                                          ),
                                          _vm._v(" "),
                                          _vm._l(
                                            _vm.adjBiweeklyData[
                                              _vm.productType
                                            ],
                                            function(
                                              biweekly,
                                              keyBiweekly,
                                              index
                                            ) {
                                              return [
                                                _c(
                                                  "th",
                                                  {
                                                    staticClass:
                                                      "text-center text-white",
                                                    style:
                                                      "background-color: " +
                                                      _vm.colorCode
                                                        .adj_biweekly[index],
                                                    attrs: { colspan: "6" }
                                                  },
                                                  [
                                                    _vm._v(
                                                      "\n                                            ปักษ์ที่ " +
                                                        _vm._s(keyBiweekly) +
                                                        " (ปรับ)\n                                        "
                                                    )
                                                  ]
                                                )
                                              ]
                                            }
                                          )
                                        ],
                                        2
                                      ),
                                      _vm._v(" "),
                                      _c("tr", [
                                        _c(
                                          "th",
                                          {
                                            staticClass:
                                              "align-middle text-center"
                                          },
                                          [
                                            _c(
                                              "el-tooltip",
                                              {
                                                staticClass: "item",
                                                attrs: {
                                                  effect: "dark",
                                                  content:
                                                    _vm.adjustData
                                                      .as_of_date_format,
                                                  placement: "top"
                                                }
                                              },
                                              [
                                                _c("div", [
                                                  _vm._v("คงคลังปัจจุบัน"),
                                                  _c("br"),
                                                  _vm._v("(ล้านมวน)")
                                                ])
                                              ]
                                            )
                                          ],
                                          1
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
                                        _vm._m(6),
                                        _vm._v(" "),
                                        _vm._m(7),
                                        _vm._v(" "),
                                        _vm._m(8),
                                        _vm._v(" "),
                                        _vm._m(9),
                                        _vm._v(" "),
                                        _vm._m(10),
                                        _vm._v(" "),
                                        _vm._m(11),
                                        _vm._v(" "),
                                        _vm._m(12),
                                        _vm._v(" "),
                                        _vm._m(13)
                                      ])
                                    ]),
                                    _vm._v(" "),
                                    _c(
                                      "tbody",
                                      [
                                        _vm._l(
                                          _vm.adjBiweeklyData[_vm.productType][
                                            Object.keys(
                                              _vm.adjBiweeklyData[
                                                _vm.productType
                                              ]
                                            )[0]
                                          ],
                                          function(item, itemKey, itemIndex) {
                                            return [
                                              _c(
                                                "tr",
                                                [
                                                  _c(
                                                    "td",
                                                    {
                                                      staticClass: "text-center"
                                                    },
                                                    [
                                                      _vm._v(
                                                        _vm._s((itemIndex += 1))
                                                      )
                                                    ]
                                                  ),
                                                  _vm._v(" "),
                                                  _c(
                                                    "td",
                                                    [
                                                      item.is_new_line
                                                        ? [
                                                            _c(
                                                              "div",
                                                              {
                                                                staticStyle: {
                                                                  display:
                                                                    "flex"
                                                                }
                                                              },
                                                              [
                                                                _c(
                                                                  "el-select",
                                                                  {
                                                                    attrs: {
                                                                      filterable:
                                                                        "",
                                                                      remote:
                                                                        "",
                                                                      placeholder:
                                                                        "",
                                                                      "remote-method": function(
                                                                        data
                                                                      ) {
                                                                        return _vm.remoteMethod(
                                                                          data,
                                                                          item
                                                                        )
                                                                      },
                                                                      disabled: false
                                                                    },
                                                                    on: {
                                                                      change: function(
                                                                        $event
                                                                      ) {
                                                                        return _vm.selectItem(
                                                                          item
                                                                        )
                                                                      }
                                                                    },
                                                                    model: {
                                                                      value:
                                                                        item.item_id,
                                                                      callback: function(
                                                                        $$v
                                                                      ) {
                                                                        _vm.$set(
                                                                          item,
                                                                          "item_id",
                                                                          $$v
                                                                        )
                                                                      },
                                                                      expression:
                                                                        "item.item_id"
                                                                    }
                                                                  },
                                                                  _vm._l(
                                                                    item.item_list,
                                                                    function(
                                                                      item,
                                                                      index
                                                                    ) {
                                                                      return _c(
                                                                        "el-option",
                                                                        {
                                                                          key:
                                                                            item.inventory_item_id,
                                                                          attrs: {
                                                                            label:
                                                                              item.item_code +
                                                                              ": " +
                                                                              item.item_description,
                                                                            value: String(
                                                                              item.inventory_item_id
                                                                            )
                                                                          }
                                                                        }
                                                                      )
                                                                    }
                                                                  ),
                                                                  1
                                                                ),
                                                                _vm._v(" "),
                                                                _c(
                                                                  "button",
                                                                  {
                                                                    staticClass:
                                                                      "btn btn-outline btn-danger ml-2",
                                                                    attrs: {
                                                                      type:
                                                                        "button",
                                                                      title:
                                                                        "ลบรายการ"
                                                                    },
                                                                    on: {
                                                                      click: function(
                                                                        $event
                                                                      ) {
                                                                        $event.preventDefault()
                                                                        return _vm.delLine(
                                                                          item,
                                                                          itemKey
                                                                        )
                                                                      }
                                                                    }
                                                                  },
                                                                  [
                                                                    _c("i", {
                                                                      class:
                                                                        _vm
                                                                          .btnTrans
                                                                          .delete
                                                                          .icon
                                                                    })
                                                                  ]
                                                                )
                                                              ],
                                                              1
                                                            )
                                                          ]
                                                        : [
                                                            _vm._v(
                                                              "\n                                                " +
                                                                _vm._s(
                                                                  item.item_code
                                                                ) +
                                                                "\n                                            "
                                                            )
                                                          ]
                                                    ],
                                                    2
                                                  ),
                                                  _vm._v(" "),
                                                  _c("td", [
                                                    _vm._v(
                                                      _vm._s(
                                                        item.item_description
                                                      )
                                                    )
                                                  ]),
                                                  _vm._v(" "),
                                                  _c(
                                                    "td",
                                                    {
                                                      staticClass: "text-right"
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                                            " +
                                                          _vm._s(
                                                            _vm._f(
                                                              "number3Digit"
                                                            )(
                                                              item.curr_onhnad_qty
                                                            )
                                                          ) +
                                                          "\n                                        "
                                                      )
                                                    ]
                                                  ),
                                                  _vm._v(" "),
                                                  _c(
                                                    "td",
                                                    {
                                                      staticClass: "text-right "
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                                            " +
                                                          _vm._s(
                                                            _vm._f(
                                                              "number3Digit"
                                                            )(
                                                              item.dff_actual_forecast_qty
                                                            )
                                                          ) +
                                                          "\n                                        "
                                                      )
                                                    ]
                                                  ),
                                                  _vm._v(" "),
                                                  _c(
                                                    "td",
                                                    {
                                                      staticClass: "text-right"
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                                            " +
                                                          _vm._s(
                                                            _vm._f(
                                                              "number3Digit"
                                                            )(
                                                              item.def_planning_qty
                                                            )
                                                          ) +
                                                          "\n                                        "
                                                      )
                                                    ]
                                                  ),
                                                  _vm._v(" "),
                                                  _c(
                                                    "td",
                                                    {
                                                      staticClass: "text-right"
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                                            " +
                                                          _vm._s(
                                                            _vm._f(
                                                              "number2Digit"
                                                            )(
                                                              item.def_bal_sale_day
                                                            )
                                                          ) +
                                                          "\n                                        "
                                                      )
                                                    ]
                                                  ),
                                                  _vm._v(" "),
                                                  _c(
                                                    "td",
                                                    {
                                                      staticClass: "text-right"
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                                            " +
                                                          _vm._s(
                                                            _vm._f(
                                                              "number3Digit"
                                                            )(
                                                              item.def_forcast_qty
                                                            )
                                                          ) +
                                                          "\n                                        "
                                                      )
                                                    ]
                                                  ),
                                                  _vm._v(" "),
                                                  _c(
                                                    "td",
                                                    {
                                                      staticClass: "text-right"
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                                            " +
                                                          _vm._s(
                                                            _vm._f(
                                                              "number3Digit"
                                                            )(
                                                              item.def_bal_onhand_qty
                                                            )
                                                          ) +
                                                          "\n                                        "
                                                      )
                                                    ]
                                                  ),
                                                  _vm._v(" "),
                                                  _c(
                                                    "td",
                                                    {
                                                      staticClass: "text-right"
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                                            " +
                                                          _vm._s(
                                                            _vm._f(
                                                              "number2Digit"
                                                            )(
                                                              item.def_ending_sale_day
                                                            )
                                                          ) +
                                                          "\n                                        "
                                                      )
                                                    ]
                                                  ),
                                                  _vm._v(" "),
                                                  _c(
                                                    "td",
                                                    {
                                                      staticClass: "text-right"
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                                            " +
                                                          _vm._s(
                                                            _vm._f(
                                                              "number3Digit"
                                                            )(
                                                              item.actual_forecase_qty
                                                            )
                                                          ) +
                                                          "\n                                        "
                                                      )
                                                    ]
                                                  ),
                                                  _vm._v(" "),
                                                  _c(
                                                    "td",
                                                    {
                                                      staticClass: "text-right"
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                                            " +
                                                          _vm._s(
                                                            _vm._f(
                                                              "number3Digit"
                                                            )(item.planning_qty)
                                                          ) +
                                                          "\n                                            "
                                                      )
                                                    ]
                                                  ),
                                                  _vm._v(" "),
                                                  _c(
                                                    "td",
                                                    {
                                                      staticClass: "text-right"
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                                            " +
                                                          _vm._s(
                                                            _vm._f(
                                                              "number2Digit"
                                                            )(item.bal_sale_day)
                                                          ) +
                                                          "\n                                        "
                                                      )
                                                    ]
                                                  ),
                                                  _vm._v(" "),
                                                  _c(
                                                    "td",
                                                    {
                                                      staticClass: "text-right"
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                                            " +
                                                          _vm._s(
                                                            _vm._f(
                                                              "number3Digit"
                                                            )(item.forcast_qty)
                                                          ) +
                                                          "\n                                        "
                                                      )
                                                    ]
                                                  ),
                                                  _vm._v(" "),
                                                  _c(
                                                    "td",
                                                    {
                                                      staticClass: "text-right"
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                                            " +
                                                          _vm._s(
                                                            _vm._f(
                                                              "number3Digit"
                                                            )(
                                                              item.bal_onhand_qty
                                                            )
                                                          ) +
                                                          "\n                                        "
                                                      )
                                                    ]
                                                  ),
                                                  _vm._v(" "),
                                                  _c(
                                                    "td",
                                                    {
                                                      staticClass: "text-right"
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                                            " +
                                                          _vm._s(
                                                            _vm._f(
                                                              "number2Digit"
                                                            )(
                                                              item.ending_sale_day
                                                            )
                                                          ) +
                                                          "\n                                        "
                                                      )
                                                    ]
                                                  ),
                                                  _vm._v(" "),
                                                  _vm._l(
                                                    _vm.adjBiweeklyData[
                                                      _vm.productType
                                                    ],
                                                    function(biweekly) {
                                                      return  false
                                                        ? 0
                                                        : _vm._e()
                                                    }
                                                  ),
                                                  _vm._v(" "),
                                                  _vm._l(
                                                    _vm.adjBiweeklyData[
                                                      _vm.productType
                                                    ],
                                                    function(biweekly) {
                                                      return  false
                                                        ? 0
                                                        : _vm._e()
                                                    }
                                                  )
                                                ],
                                                2
                                              )
                                            ]
                                          }
                                        ),
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
                                              [_vm._v("รวม")]
                                            ),
                                            _vm._v(" "),
                                            _vm._l(
                                              _vm.adjBiweeklyData[
                                                _vm.productType
                                              ],
                                              function(biweekly, index) {
                                                return [
                                                  _c(
                                                    "th",
                                                    {
                                                      staticClass:
                                                        "text-right text-white",
                                                      staticStyle: {
                                                        "background-color":
                                                          "#34d399"
                                                      }
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                                            " +
                                                          _vm._s(
                                                            _vm.adjSummaryData[
                                                              _vm.productType
                                                            ][index][
                                                              "curr_onhnad_qty"
                                                            ]
                                                          ) +
                                                          "\n                                        "
                                                      )
                                                    ]
                                                  ),
                                                  _vm._v(" "),
                                                  _c(
                                                    "th",
                                                    {
                                                      staticClass:
                                                        "text-right text-white",
                                                      staticStyle: {
                                                        "background-color":
                                                          "#34d399"
                                                      }
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                                            " +
                                                          _vm._s(
                                                            _vm.adjSummaryData[
                                                              _vm.productType
                                                            ][index][
                                                              "dff_actual_forecast_qty"
                                                            ]
                                                          ) +
                                                          "\n                                        "
                                                      )
                                                    ]
                                                  ),
                                                  _vm._v(" "),
                                                  _c(
                                                    "th",
                                                    {
                                                      staticClass:
                                                        "text-right text-white",
                                                      staticStyle: {
                                                        "background-color":
                                                          "#34d399"
                                                      }
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                                            " +
                                                          _vm._s(
                                                            _vm.adjSummaryData[
                                                              _vm.productType
                                                            ][index][
                                                              "def_planning_qty"
                                                            ]
                                                          ) +
                                                          "\n                                        "
                                                      )
                                                    ]
                                                  ),
                                                  _vm._v(" "),
                                                  _c(
                                                    "th",
                                                    {
                                                      staticClass:
                                                        "text-right text-white",
                                                      staticStyle: {
                                                        "background-color":
                                                          "#34d399"
                                                      }
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                                            " +
                                                          _vm._s(
                                                            _vm.adjSummaryData[
                                                              _vm.productType
                                                            ][index][
                                                              "def_bal_sale_days"
                                                            ]
                                                          ) +
                                                          "\n                                        "
                                                      )
                                                    ]
                                                  ),
                                                  _vm._v(" "),
                                                  _c(
                                                    "th",
                                                    {
                                                      staticClass:
                                                        "text-right text-white",
                                                      staticStyle: {
                                                        "background-color":
                                                          "#34d399"
                                                      }
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                                            " +
                                                          _vm._s(
                                                            _vm.adjSummaryData[
                                                              _vm.productType
                                                            ][index][
                                                              "def_forcast_qty"
                                                            ]
                                                          ) +
                                                          "\n                                        "
                                                      )
                                                    ]
                                                  ),
                                                  _vm._v(" "),
                                                  _c(
                                                    "th",
                                                    {
                                                      staticClass:
                                                        "text-right text-white",
                                                      staticStyle: {
                                                        "background-color":
                                                          "#34d399"
                                                      }
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                                            " +
                                                          _vm._s(
                                                            _vm.adjSummaryData[
                                                              _vm.productType
                                                            ][index][
                                                              "def_bal_onhand_qty"
                                                            ]
                                                          ) +
                                                          "\n                                        "
                                                      )
                                                    ]
                                                  ),
                                                  _vm._v(" "),
                                                  _c(
                                                    "th",
                                                    {
                                                      staticClass:
                                                        "text-right text-white",
                                                      staticStyle: {
                                                        "background-color":
                                                          "#34d399"
                                                      }
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                                            " +
                                                          _vm._s(
                                                            _vm.adjSummaryData[
                                                              _vm.productType
                                                            ][index][
                                                              "def_ending_sale_day"
                                                            ]
                                                          ) +
                                                          "\n                                        "
                                                      )
                                                    ]
                                                  )
                                                ]
                                              }
                                            ),
                                            _vm._v(" "),
                                            _vm._l(
                                              _vm.adjBiweeklyData[
                                                _vm.productType
                                              ],
                                              function(biweekly, index) {
                                                return [
                                                  _c(
                                                    "th",
                                                    {
                                                      staticClass:
                                                        "text-right text-white",
                                                      staticStyle: {
                                                        "background-color":
                                                          "#34d399"
                                                      }
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                                            " +
                                                          _vm._s(
                                                            _vm.adjSummaryData[
                                                              _vm.productType
                                                            ][index][
                                                              "actual_forecase_qty"
                                                            ]
                                                          ) +
                                                          "\n                                        "
                                                      )
                                                    ]
                                                  ),
                                                  _vm._v(" "),
                                                  _c(
                                                    "th",
                                                    {
                                                      staticClass:
                                                        "text-right text-white",
                                                      staticStyle: {
                                                        "background-color":
                                                          "#34d399"
                                                      }
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                                            " +
                                                          _vm._s(
                                                            _vm.adjSummaryData[
                                                              _vm.productType
                                                            ][index][
                                                              "planning_qty"
                                                            ]
                                                          ) +
                                                          "\n                                        "
                                                      )
                                                    ]
                                                  ),
                                                  _vm._v(" "),
                                                  _c(
                                                    "th",
                                                    {
                                                      staticClass:
                                                        "text-right text-white",
                                                      staticStyle: {
                                                        "background-color":
                                                          "#34d399"
                                                      }
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                                            " +
                                                          _vm._s(
                                                            _vm.adjSummaryData[
                                                              _vm.productType
                                                            ][index][
                                                              "bal_sale_days"
                                                            ]
                                                          ) +
                                                          "\n                                        "
                                                      )
                                                    ]
                                                  ),
                                                  _vm._v(" "),
                                                  _c(
                                                    "th",
                                                    {
                                                      staticClass:
                                                        "text-right text-white",
                                                      staticStyle: {
                                                        "background-color":
                                                          "#34d399"
                                                      }
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                                            " +
                                                          _vm._s(
                                                            _vm.adjSummaryData[
                                                              _vm.productType
                                                            ][index][
                                                              "forcast_qty"
                                                            ]
                                                          ) +
                                                          "\n                                        "
                                                      )
                                                    ]
                                                  ),
                                                  _vm._v(" "),
                                                  _c(
                                                    "th",
                                                    {
                                                      staticClass:
                                                        "text-right text-white",
                                                      staticStyle: {
                                                        "background-color":
                                                          "#34d399"
                                                      }
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                                            " +
                                                          _vm._s(
                                                            _vm.adjSummaryData[
                                                              _vm.productType
                                                            ][index][
                                                              "bal_onhand_qty"
                                                            ]
                                                          ) +
                                                          "\n                                        "
                                                      )
                                                    ]
                                                  ),
                                                  _vm._v(" "),
                                                  _c(
                                                    "th",
                                                    {
                                                      staticClass:
                                                        "text-right text-white",
                                                      staticStyle: {
                                                        "background-color":
                                                          "#34d399"
                                                      }
                                                    },
                                                    [
                                                      _vm._v(
                                                        "\n                                            " +
                                                          _vm._s(
                                                            _vm.adjSummaryData[
                                                              _vm.productType
                                                            ][index][
                                                              "ending_sale_day"
                                                            ]
                                                          ) +
                                                          "\n                                        "
                                                      )
                                                    ]
                                                  )
                                                ]
                                              }
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
                          ]
                        )
                      ])
                ])
              ]
            )
          ]
        )
      ]),
      _vm._v(" "),
       false
        ? 0
        : _vm._e()
    ]
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-sm-2 pl-0 text-sm-right" }, [
      _c("dt", [_vm._v("ประมาณการผลิต:")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "th",
      { staticClass: "align-middle text-center", attrs: { rowspan: "2" } },
      [
        _vm._v(
          "\n                                                      \n                                                      \n                                                      \n                                                      \n                                        "
        ),
        _c("br"),
        _vm._v("รหัสบุหรี่"),
        _c("br"),
        _vm._v(
          "\n                                                      \n                                                      \n                                                      \n                                                      \n                                    "
        )
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("th", { staticClass: "align-middle text-center" }, [
      _vm._v("เฉลี่ยขายย้อนหลัง"),
      _c("br"),
      _vm._v("(ล้านมวน)")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("th", { staticClass: "align-middle text-center" }, [
      _vm._v("ประมาณการผลิต"),
      _c("br"),
      _vm._v("(ล้านมวน)")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("th", { staticClass: "align-middle text-center" }, [
      _vm._v("เหลือวันขาย"),
      _c("br"),
      _vm._v("(วัน)")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("th", { staticClass: "align-middle text-center" }, [
      _vm._v("ประมาณการขาย"),
      _c("br"),
      _vm._v("(ล้านมวน)")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("th", { staticClass: "align-middle text-center" }, [
      _vm._v("คงคลังสิ้นปักษ์"),
      _c("br"),
      _vm._v("(ล้านมวน)")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("th", { staticClass: "align-middle text-center" }, [
      _vm._v("จำนวนวันพอจำหน่าย"),
      _c("br"),
      _vm._v("(วัน)")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("th", { staticClass: "align-middle text-center" }, [
      _vm._v("เฉลี่ยขายย้อนหลัง"),
      _c("br"),
      _vm._v("(ล้านมวน)")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("th", { staticClass: "align-middle text-center" }, [
      _vm._v("ประมาณการผลิต"),
      _c("br"),
      _vm._v("(ล้านมวน)")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("th", { staticClass: "align-middle text-center" }, [
      _vm._v("เหลือวันขาย"),
      _c("br"),
      _vm._v("(วัน)")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("th", { staticClass: "align-middle text-center" }, [
      _vm._v("ประมาณการขาย"),
      _c("br"),
      _vm._v("(ล้านมวน)")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("th", { staticClass: "align-middle text-center" }, [
      _vm._v("คงคลังสิ้นปักษ์"),
      _c("br"),
      _vm._v("(ล้านมวน)")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("th", { staticClass: "align-middle text-center" }, [
      _vm._v("จำนวนวันพอจำหน่าย"),
      _c("br"),
      _vm._v("(วัน)")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "th",
      { staticClass: "align-middle text-center", attrs: { rowspan: "2" } },
      [
        _vm._v(
          "\n                                                      \n                                                      \n                                                      \n                                                      \n                                        "
        ),
        _c("br"),
        _vm._v("รหัสบุหรี่"),
        _c("br"),
        _vm._v(
          "\n                                                      \n                                                      \n                                                      \n                                                      \n                                    "
        )
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c("th", { staticClass: "align-middle text-center" }, [
        _vm._v("คงคลังปัจจุบัน"),
        _c("br"),
        _vm._v("(ล้านมวน)")
      ]),
      _vm._v(" "),
      _c("th", { staticClass: "align-middle text-center" }, [
        _vm._v("เฉลี่ยขายย้อนหลัง"),
        _c("br"),
        _vm._v("(ล้านมวน)")
      ]),
      _vm._v(" "),
      _c("th", { staticClass: "align-middle text-center" }, [
        _vm._v("ประมาณการผลิต"),
        _c("br"),
        _vm._v("(ล้านมวน)")
      ]),
      _vm._v(" "),
      _c("th", { staticClass: "align-middle text-center" }, [
        _vm._v("เหลือวันขาย"),
        _c("br"),
        _vm._v("(วัน)")
      ]),
      _vm._v(" "),
      _c("th", { staticClass: "align-middle text-center" }, [
        _vm._v("ประมาณการขาย"),
        _c("br"),
        _vm._v("(ล้านมวน)")
      ]),
      _vm._v(" "),
      _c("th", { staticClass: "align-middle text-center" }, [
        _vm._v("คงคลังสิ้นปักษ์"),
        _c("br"),
        _vm._v("(ล้านมวน)")
      ]),
      _vm._v(" "),
      _c("th", { staticClass: "align-middle text-center" }, [
        _vm._v("จำนวนวันพอจำหน่าย"),
        _c("br"),
        _vm._v("(วัน)")
      ]),
      _vm._v(" "),
      _c("th", { staticClass: "align-middle text-center" }, [
        _vm._v("ประมาณการผลิต"),
        _c("br"),
        _vm._v("(ล้านมวน)")
      ]),
      _vm._v(" "),
      _c("th", { staticClass: "align-middle text-center" }, [
        _vm._v("เหลือวันขาย"),
        _c("br"),
        _vm._v("(วัน)")
      ]),
      _vm._v(" "),
      _c("th", { staticClass: "align-middle text-center" }, [
        _vm._v("ประมาณการขาย"),
        _c("br"),
        _vm._v("(ล้านมวน)")
      ]),
      _vm._v(" "),
      _c("th", { staticClass: "align-middle text-center" }, [
        _vm._v("คงคลังสิ้นปักษ์"),
        _c("br"),
        _vm._v("(ล้านมวน)")
      ]),
      _vm._v(" "),
      _c("th", { staticClass: "align-middle text-center" }, [
        _vm._v("จำนวนวันพอจำหน่าย"),
        _c("br"),
        _vm._v("(วัน)")
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Adjusts/components/HeaderDetail.vue?vue&type=template&id=414a89f6&":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Adjusts/components/HeaderDetail.vue?vue&type=template&id=414a89f6& ***!
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
  return _c("div", {}, [
    _c("form", { attrs: { id: "production-plan-form", action: "" } }, [
      _c("div", { staticClass: "row" }, [
        _c("div", { staticClass: "col-8 b-r" }, [
          _c("div", { staticClass: "row" }, [
            _c("div", { staticClass: "col-lg-6" }, [
              _c("dl", { staticClass: "row mb-0" }, [
                _vm._m(0),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-8 text-sm-left" }, [
                  _c("dd", { staticClass: "mb-1" }, [
                    _vm.adjustData
                      ? _c("div", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(
                                _vm.adjustData.pp_bi_weekly.period_year_thai
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
                _vm._m(1),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-8 text-sm-left" }, [
                  _c("dd", { staticClass: "mb-1" }, [
                    _vm.adjustData
                      ? _c("div", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(_vm.adjustData.biweekly) +
                              "\n                                    "
                          )
                        ])
                      : _vm._e()
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("dl", { staticClass: "row mb-0" }, [
                _vm._m(2),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-8 text-sm-left" }, [
                  _c("dd", { staticClass: "mb-1" }, [
                    _vm.adjustData
                      ? _c("div", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(_vm.adjustData.version_no) +
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
                _c("div", { staticClass: "col-sm-8 text-sm-left" }, [
                  _c("dd", { staticClass: "mb-1" }, [
                    _vm.adjustData
                      ? _c("div", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(_vm.adjustData.pt_biweekly.pp_month) +
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
                _c("div", { staticClass: "col-sm-8 text-sm-left" }, [
                  _c("dd", { staticClass: "mb-1" }, [
                    _vm.adjustData
                      ? _c("div", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(
                                _vm.adjustData.pp_bi_weekly.thai_combine_date
                              ) +
                              "\n                                    "
                          )
                        ])
                      : _vm._e()
                  ])
                ])
              ]),
              _vm._v(" "),
              _vm._m(5)
            ]),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "col-lg-6", attrs: { id: "cluster_info" } },
              [
                _c("dl", { staticClass: "row mb-0" }, [
                  _vm._m(6),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-sm-9 text-sm-left" }, [
                    _c("dd", { staticClass: "mb-1" }, [
                      _vm.adjustData
                        ? _c("div", [
                            _vm._v(
                              "\n                                        " +
                                _vm._s(_vm.adjustData.adjust_no) +
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
                  _c("div", { staticClass: "col-sm-9 text-sm-left" }, [
                    _c("dd", { staticClass: "mb-1" }, [
                      _vm.adjustData
                        ? _c(
                            "div",
                            [
                              _c("el-input", {
                                staticClass: "required",
                                attrs: {
                                  disabled: !_vm.canEdit,
                                  type: "textarea",
                                  name: "note",
                                  rows: "4",
                                  maxlength: "240",
                                  "show-word-limit": ""
                                },
                                model: {
                                  value: _vm.note,
                                  callback: function($$v) {
                                    _vm.note = $$v
                                  },
                                  expression: "note"
                                }
                              }),
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
                                  _vm.showSaveNote
                                    ? _c(
                                        "div",
                                        { staticClass: "text-right mt-2" },
                                        [
                                          _c(
                                            "button",
                                            {
                                              class:
                                                _vm.btnTrans.save.class +
                                                " btn-sm tw-w-25",
                                              attrs: { type: "button" },
                                              on: { click: _vm.updateNoteForm }
                                            },
                                            [
                                              _c("i", {
                                                class: _vm.btnTrans.save.icon
                                              }),
                                              _vm._v(
                                                "\n                                                    " +
                                                  _vm._s(
                                                    _vm.btnTrans.save.text
                                                  ) +
                                                  "\n                                                "
                                              )
                                            ]
                                          ),
                                          _vm._v(" "),
                                          _c(
                                            "button",
                                            {
                                              class:
                                                _vm.btnTrans.cancel.class +
                                                " btn-sm tw-w-25",
                                              attrs: { type: "button" },
                                              on: {
                                                click: function($event) {
                                                  _vm.note = _vm.oldNote
                                                }
                                              }
                                            },
                                            [
                                              _c("i", {
                                                class: _vm.btnTrans.cancel.icon
                                              }),
                                              _vm._v(
                                                "\n                                                    " +
                                                  _vm._s(
                                                    _vm.btnTrans.cancel.text
                                                  ) +
                                                  "\n                                                "
                                              )
                                            ]
                                          )
                                        ]
                                      )
                                    : _vm._e()
                                ]
                              )
                            ],
                            1
                          )
                        : _vm._e()
                    ])
                  ])
                ])
              ]
            )
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col-4" }, [
          _c("div", { staticClass: "row" }, [
            _c("div", { staticClass: "col-lg-12" }, [
              _c("dl", { staticClass: "row mb-0" }, [
                _vm._m(8),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-6 text-sm-left" }, [
                  _c("dd", { staticClass: "mb-1" }, [
                    _vm.adjustData
                      ? _c("div", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(_vm.adjustData.creation_date_format) +
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
                    _vm.adjustData
                      ? _c("div", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(_vm.adjustData.last_update_date_format) +
                              "\n                                    "
                          )
                        ])
                      : _vm._e()
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("dl", { staticClass: "row mb-0" }, [
                _vm._m(10),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-6 text-sm-left" }, [
                  _c("dd", { staticClass: "mb-1" }, [
                    _vm.adjustData
                      ? _c("div", [
                          _c("span", {
                            domProps: {
                              innerHTML: _vm._s(
                                _vm.adjustData.status_lable_html
                              )
                            }
                          })
                        ])
                      : _vm._e()
                  ])
                ])
              ]),
              _vm._v(" "),
              _c("dl", { staticClass: "row mb-0" }, [
                _vm._m(11),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-6 text-sm-left" }, [
                  _c("dd", { staticClass: "mb-1" }, [
                    _vm.adjustData
                      ? _c("div", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(
                                _vm.adjustData.updated_by
                                  ? _vm.adjustData.updated_by.name
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
                _vm._m(12),
                _vm._v(" "),
                _c("div", { staticClass: "col-sm-6 text-sm-left" }, [
                  _c("dd", { staticClass: "mb-1" }, [
                    _vm.adjustData
                      ? _c("div", [
                          _vm._v(
                            "\n                                        " +
                              _vm._s(_vm.adjustData.approved_at_format) +
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
      _c("dt", [_vm._v("ครั้งที่:")])
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
    return _c("dl", { staticClass: "row mb-0" }, [
      _c("div", { staticClass: "col-sm-4 pl-0 text-sm-right" }, [
        _c("dt", [_vm._v("ส่งข้อมูลครั้งที่:")])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "col-sm-8 text-sm-left" }, [
        _c("dd", { staticClass: "mb-1 text-danger" })
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-sm-3  pl-0 text-sm-right" }, [
      _c("dt", [
        _vm._v(
          "\n                                    ปรับครั้งที่:\n                                "
        )
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-sm-3  pl-0 text-sm-right" }, [
      _c("dt", [
        _vm._v(
          "\n                                    หมายเหตุ:\n                                "
        )
      ])
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



/***/ })

}]);