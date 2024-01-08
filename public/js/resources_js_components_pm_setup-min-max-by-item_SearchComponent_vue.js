(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pm_setup-min-max-by-item_SearchComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/setup-min-max-by-item/SearchComponent.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/setup-min-max-by-item/SearchComponent.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _TableComponent_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TableComponent.vue */ "./resources/js/components/pm/setup-min-max-by-item/TableComponent.vue");


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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    SetupMinMaxByItemTable: _TableComponent_vue__WEBPACK_IMPORTED_MODULE_1__.default
  },
  props: ["tobaccoItemcatList", "searchOld", "btnTrans"],
  data: function data() {
    return {
      organizationSearch: "",
      organizationShow: "",
      locationSearch: "",
      locationShow: "",
      itemNumber: "",
      itemcat: this.searchOld ? this.searchOld.itemcat : "",
      primaryUomCode: "",
      primaryUnitOfMeasure: "",
      searched: false,
      loading: {
        organizationShow: false,
        locationShow: false,
        itemNumber: false,
        primaryUomCode: false,
        primaryUnitOfMeasure: false,
        itemcat: false,
        tableData: false
      },
      isDisabledItemNumber: true,
      organizationList: [],
      itemLocationsList: [],
      itemNumberList: [],
      listSetupMinMax: [],
      listSearch: [],
      listSearchItemNumber: []
    };
  },
  mounted: function mounted() {
    var _this = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
      var urlParams, organization, location, itemcat, itemNumber;
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              if (!_this.searchOld) {
                _context.next = 7;
                break;
              }

              _context.next = 3;
              return _this.getOrganization(_this.searchOld.itemcat);

            case 3:
              _context.next = 5;
              return _this.search(_this.searchOld.organization, _this.searchOld.location, _this.searchOld.itemcat, _this.searchOld.itemNumber);

            case 5:
              _context.next = 23;
              break;

            case 7:
              urlParams = new URLSearchParams(window.location.search);
              organization = urlParams.get('organization');
              location = urlParams.get('location');
              itemcat = urlParams.get('itemcat');
              itemNumber = urlParams.get('itemNumber');

              if (!(organization != null && location != null && itemcat != null)) {
                _context.next = 21;
                break;
              }

              Vue.set(_this, 'itemcat', itemcat);
              _context.next = 16;
              return _this.getOrganization(itemcat);

            case 16:
              console.log({
                organization: organization,
                location: location
              });
              _context.next = 19;
              return _this.search(organization, location, itemcat, itemNumber);

            case 19:
              _context.next = 23;
              break;

            case 21:
              _context.next = 23;
              return _this.initialTable();

            case 23:
              $(function () {
                $("#setup-min-max-by-item-datatable-bk").dataTable();
              });

            case 24:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  methods: {
    fetchData: function fetchData(params) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _context2.next = 2;
                return axios.get("/pm/ajax/setup-min-max-by-item/get-organization", {
                  params: params
                }).then(function (res) {
                  if (res.data.organizationSearch == "") {
                    _this2.organizationSearch = "";
                    _this2.organizationShow = "";
                    _this2.loading.organizationShow = false;
                    _this2.loading.locationShow = false;
                    _this2.loading.itemNumber = false;
                    _this2.locationSearch = "";
                    _this2.locationShow = "";
                    _this2.itemNumber = "";
                    _this2.isDisabledItemNumber = true;
                  } else {
                    if (res.data.organizationList == "noInput") {
                      _this2.organizationSearch = "";
                      _this2.organizationShow = "";
                      _this2.loading.organizationShow = false;
                      _this2.loading.locationShow = false;
                      _this2.loading.itemNumber = false;
                      _this2.locationSearch = "";
                      _this2.locationShow = "";
                      _this2.itemNumber = "";
                      _this2.isDisabledItemNumber = true;
                    } else {
                      _this2.organizationSearch = res.data.organization.organization_id;
                      _this2.organizationShow = res.data.organization.organization_code + " : " + res.data.organization.organization_name;
                      _this2.loading.organizationShow = false;
                      _this2.loading.locationShow = false;
                      _this2.loading.itemNumber = false;
                      _this2.locationSearch = res.data.itemLocation.locator_id;
                      _this2.locationShow = res.data.itemLocation.locator_code + " : " + res.data.itemLocation.location_desc;
                      _this2.itemNumberList = res.data.itemNumberList;
                      _this2.isDisabledItemNumber = false;
                    }
                  }
                });

              case 2:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    getOrganization: function getOrganization(value) {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                params = {
                  itemcat: value
                };
                _this3.loading.organizationShow = true;
                _this3.loading.locationShow = true;
                _this3.loading.itemNumber = true;
                return _context3.abrupt("return", _this3.fetchData(params));

              case 5:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    search: function search(organization, location, itemcat, itemNumber) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        var params, pageUrl, vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                params = {
                  organization: organization,
                  location: location,
                  itemcat: itemcat,
                  itemNumber: itemNumber
                };
                pageUrl = '?q=q&organization=' + (typeof organization != 'undefined' ? organization : '') + "&location=" + (typeof location != 'undefined' ? location : '') + "&itemcat=" + (typeof itemcat != 'undefined' ? itemcat : '') + "&itemNumber=" + (typeof itemNumber != 'undefined' ? itemNumber : '');
                window.history.pushState('', '', pageUrl);
                _this4.loading.tableData = true;
                vm = _this4;
                _context4.next = 7;
                return axios.get("/pm/ajax/setup-min-max-by-item/search", {
                  params: params
                }).then(function (res) {
                  _this4.listSetupMinMax = res.data.data.listSetupMinMax;
                  _this4.listSearch = res.data.data.listSearch;
                  _this4.listSearchItemNumber = res.data.data.listSearchItemNumber;
                  vm.$children[4].isDisabledBtuAdd = false;
                  _this4.loading.tableData = false;
                });

              case 7:
                console.log($("#setup-min-max-by-item-datatable").dataTable({
                  searching: false,
                  ordering: false
                }));
                _this4.searched = true;
                return _context4.abrupt("return", true);

              case 10:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    initialTable: function initialTable(organization, location, itemcat, itemNumber) {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        var params, vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                params = {
                  status: 'init_table'
                };
                _this5.loading.tableData = true;
                vm = _this5;
                _context5.next = 5;
                return axios.get("/pm/ajax/setup-min-max-by-item/search", {
                  params: params
                }).then(function (res) {
                  _this5.listSetupMinMax = res.data.data.listSetupMinMax;
                  _this5.listSearch = res.data.data.listSearch;
                  _this5.listSearchItemNumber = res.data.data.listSearchItemNumber;
                  vm.$children[4].isDisabledBtuAdd = false;
                  _this5.loading.tableData = false;
                });

              case 5:
                return _context5.abrupt("return", true);

              case 6:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/setup-min-max-by-item/TableComponent.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/setup-min-max-by-item/TableComponent.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var uuid_v1__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! uuid/v1 */ "./node_modules/uuid/v1.js");
/* harmony import */ var uuid_v1__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(uuid_v1__WEBPACK_IMPORTED_MODULE_2__);


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


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['organizationSearch', 'listSetupMinMax', 'listSearchItemNumber', 'itemNumberSearch', 'btnTrans', 'searched'],
  watch: {
    listSetupMinMax: function () {
      var _listSetupMinMax = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee(value) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                this.testList = value;

              case 1:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this);
      }));

      function listSetupMinMax(_x) {
        return _listSetupMinMax.apply(this, arguments);
      }

      return listSetupMinMax;
    }(),
    organizationSearch: function () {
      var _organizationSearch = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2(value1) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                this.organization = value1;

              case 1:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, this);
      }));

      function organizationSearch(_x2) {
        return _organizationSearch.apply(this, arguments);
      }

      return organizationSearch;
    }(),
    itemNumberSearch: function () {
      var _itemNumberSearch = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3(value2) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                this.itemNumber = value2;

              case 1:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3, this);
      }));

      function itemNumberSearch(_x3) {
        return _itemNumberSearch.apply(this, arguments);
      }

      return itemNumberSearch;
    }()
  },
  components: {
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_1___default())
  },
  data: function data() {
    return {
      checkedEdit: '',
      itemNumber: '',
      primaryUnitOfMeasure: '',
      minQty: '',
      maxQty: '',
      note: '',
      checkedEditUpdate: '',
      organization: this.organizationSearch,
      itemNumberDes: '',
      statusDup: '',
      uomList: [],
      lines: [],
      isDisabledBtuAdd: true,
      testList: this.listSetupMinMax,
      loading: {
        location: false,
        itemNumber: false,
        primaryUnitOfMeasure: false,
        itemcat: false
      },
      id: uuid_v1__WEBPACK_IMPORTED_MODULE_2___default()(),
      isTextFlag: true
    };
  },
  mounted: function mounted() {},
  computed: {},
  methods: {
    checkNumberSmallValue: function checkNumberSmallValue(min, max, arrayData) {
      if (max != 0 && min > max) {
        arrayData.remarkImpossibleSmallValue = true;
        this.isDisabledBtuAdd = true;
        swal({
          title: "เกิดข้อผิดพลาด !",
          text: "ค่าเฝ้าระวังต่ำสุดมีค่ามากกว่าค่าเฝ้าระวังสูงสุด จะไม่สามารถบันทึกข้อมูลได้",
          type: "error",
          showConfirmButton: true
        });
      } else {
        arrayData.remarkImpossibleSmallValue = false;
        arrayData.remarkImpossibleHighValue = false;
        this.isDisabledBtuAdd = false;
      }
    },
    checkNumberHighValue: function checkNumberHighValue(min, max, arrayData) {
      if (max != 0 && min > max) {
        arrayData.remarkImpossibleHighValue = true;
        this.isDisabledBtuAdd = true;
        swal({
          title: "เกิดข้อผิดพลาด !",
          text: "ค่าเฝ้าระวังสูงสุดมีค่าน้อยกว่าค่าเฝ้าระวังต่ำ จะไม่สามารถบันทึกข้อมูลได้",
          type: "error",
          showConfirmButton: true
        });
      } else {
        arrayData.remarkImpossibleHighValue = false;
        arrayData.remarkImpossibleSmallValue = false;
        this.isDisabledBtuAdd = false;
      }
    },
    checkInput: function checkInput() {
      var _this = this;

      this.lines.forEach( /*#__PURE__*/function () {
        var _ref = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4(element, i) {
          return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
            while (1) {
              switch (_context4.prev = _context4.next) {
                case 0:
                  if (element.itemNumber && element.maxQty && element.minQty && element.note) {
                    console.log('have data');
                    _this.isDisabledBtuAdd = false;
                  } else {
                    console.log('no data');
                    _this.isDisabledBtuAdd = true;
                  }

                case 1:
                case "end":
                  return _context4.stop();
              }
            }
          }, _callee4);
        }));

        return function (_x4, _x5) {
          return _ref.apply(this, arguments);
        };
      }());
    },
    hasItem: function hasItem(itemNumber) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee7() {
        var vm, checkItem;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                vm = _this2;
                checkItem = false;

                if (vm.listSetupMinMax != 'NoSearchData') {
                  vm.listSetupMinMax.forEach( /*#__PURE__*/function () {
                    var _ref2 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5(element, i) {
                      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
                        while (1) {
                          switch (_context5.prev = _context5.next) {
                            case 0:
                              if (element.item_number == itemNumber) {
                                checkItem = true;
                              }

                            case 1:
                            case "end":
                              return _context5.stop();
                          }
                        }
                      }, _callee5);
                    }));

                    return function (_x6, _x7) {
                      return _ref2.apply(this, arguments);
                    };
                  }());
                }

                vm.lines.forEach( /*#__PURE__*/function () {
                  var _ref3 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6(element, i) {
                    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
                      while (1) {
                        switch (_context6.prev = _context6.next) {
                          case 0:
                            if (element.itemNumber == itemNumber) {
                              checkItem = true;
                            }

                          case 1:
                          case "end":
                            return _context6.stop();
                        }
                      }
                    }, _callee6);
                  }));

                  return function (_x8, _x9) {
                    return _ref3.apply(this, arguments);
                  };
                }());
                return _context7.abrupt("return", checkItem);

              case 5:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7);
      }))();
    },
    addLine: function addLine() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee9() {
        var vm, itemNumbersList;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee9$(_context9) {
          while (1) {
            switch (_context9.prev = _context9.next) {
              case 0:
                vm = _this3;
                itemNumbersList = [];

                if (!(_this3.organizationSearch == '' || !_this3.searched)) {
                  _context9.next = 5;
                  break;
                }

                _this3.$message({
                  type: 'error',
                  message: 'ไม่สามารถทำรายการได้กรุณาเลือกข้อมูล ประเภทวัตถุดิบ'
                });

                return _context9.abrupt("return", false);

              case 5:
                vm.listSearchItemNumber.forEach( /*#__PURE__*/function () {
                  var _ref4 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee8(element, i) {
                    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee8$(_context8) {
                      while (1) {
                        switch (_context8.prev = _context8.next) {
                          case 0:
                            _context8.next = 2;
                            return vm.hasItem(element.item_number);

                          case 2:
                            if (_context8.sent) {
                              _context8.next = 4;
                              break;
                            }

                            itemNumbersList.push(element);

                          case 4:
                          case "end":
                            return _context8.stop();
                        }
                      }
                    }, _callee8);
                  }));

                  return function (_x10, _x11) {
                    return _ref4.apply(this, arguments);
                  };
                }());
                console.log(itemNumbersList);

                _this3.lines.push({
                  id: uuid_v1__WEBPACK_IMPORTED_MODULE_2___default()(),
                  itemNumber: '',
                  itemNumberDes: '',
                  primaryUnitOfMeasure: '',
                  minQty: '',
                  maxQty: '',
                  note: '',
                  itemNumbersList: itemNumbersList,
                  remarkImpossibleSmallValue: false,
                  remarkImpossibleHighValue: false
                });

                _this3.isDisabledBtuAdd = true;
                _this3.isTextFlag = false;

              case 10:
              case "end":
                return _context9.stop();
            }
          }
        }, _callee9);
      }))();
    },
    removeRow: function removeRow(index) {
      this.lines.splice(index, 1);
      this.isDisabledBtuAdd = false;

      if (this.lines.length == 0) {
        this.isTextFlag = true;
      } else {
        this.isTextFlag = false;
      }
    },
    getUom: function getUom(value, row, organization) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee10() {
        var params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee10$(_context10) {
          while (1) {
            switch (_context10.prev = _context10.next) {
              case 0:
                row.itemNumbersList.forEach(function (element) {
                  if (element.inventory_item_id == value) {
                    row.itemNumber = element.item_number;
                    row.itemNumberDes = element.item_desc;
                  }
                });
                params = {
                  inventoryItemId: value,
                  organization: organization
                }; //this.loading.primaryUomCode = true;

                _this4.loading.primaryUnitOfMeasure = true;
                _context10.next = 5;
                return axios.get('/pm/ajax/setup-min-max-by-item/get-uom', {
                  params: params
                }).then(function (res) {
                  if (res.data.data.dataUom == '') {
                    row.primaryUnitOfMeasure = '';
                    _this4.loading.primaryUnitOfMeasure = false;
                  } else {
                    if (row.statusDup == 'Dup') {
                      _this4.loading.primaryUnitOfMeasure = false;
                      row.primaryUnitOfMeasure = '';
                      row.statusDup = '';
                    } else {
                      _this4.uomList = res.data.data.dataUom;
                      row.primaryUnitOfMeasure = _this4.uomList[0].primary_unit_of_measure;
                      _this4.loading.primaryUnitOfMeasure = false;
                    }
                  }
                });

              case 5:
                return _context10.abrupt("return", _context10.sent);

              case 6:
              case "end":
                return _context10.stop();
            }
          }
        }, _callee10);
      }))();
    },
    removeRowTableData: function removeRowTableData(row, setupMinMaxId) {
      var params = {
        row: row,
        setupMinMaxId: setupMinMaxId
      };
      swal({
        title: "คุณแน่ใจ?",
        text: "คุณต้องการลบข้อมูลใช่หรือไม่",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: 'btn btn-warning',
        confirmButtonText: "ยืนยัน",
        cancelButtonText: "ยกเลิก",
        closeOnConfirm: false
      }, function (isConfirm) {
        if (isConfirm) {
          axios.get('/pm/ajax/setup-min-max-by-item/destroy', {
            params: params
          }).then(function (res) {
            swal({
              title: "success !",
              text: "ข้อมูลได้ทำการลบเรียบร้อยแล้ว",
              type: "success",
              showConfirmButton: false
            });
            window.location.reload(false);
          });
        }
      });
    }
  }
});

/***/ }),

/***/ "./resources/js/components/pm/setup-min-max-by-item/SearchComponent.vue":
/*!******************************************************************************!*\
  !*** ./resources/js/components/pm/setup-min-max-by-item/SearchComponent.vue ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _SearchComponent_vue_vue_type_template_id_38789154___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SearchComponent.vue?vue&type=template&id=38789154& */ "./resources/js/components/pm/setup-min-max-by-item/SearchComponent.vue?vue&type=template&id=38789154&");
/* harmony import */ var _SearchComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SearchComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/setup-min-max-by-item/SearchComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _SearchComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _SearchComponent_vue_vue_type_template_id_38789154___WEBPACK_IMPORTED_MODULE_0__.render,
  _SearchComponent_vue_vue_type_template_id_38789154___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/setup-min-max-by-item/SearchComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/setup-min-max-by-item/TableComponent.vue":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/pm/setup-min-max-by-item/TableComponent.vue ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TableComponent_vue_vue_type_template_id_9e46dc00___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TableComponent.vue?vue&type=template&id=9e46dc00& */ "./resources/js/components/pm/setup-min-max-by-item/TableComponent.vue?vue&type=template&id=9e46dc00&");
/* harmony import */ var _TableComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TableComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/setup-min-max-by-item/TableComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TableComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TableComponent_vue_vue_type_template_id_9e46dc00___WEBPACK_IMPORTED_MODULE_0__.render,
  _TableComponent_vue_vue_type_template_id_9e46dc00___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/setup-min-max-by-item/TableComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/setup-min-max-by-item/SearchComponent.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/components/pm/setup-min-max-by-item/SearchComponent.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SearchComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/setup-min-max-by-item/SearchComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/setup-min-max-by-item/TableComponent.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/components/pm/setup-min-max-by-item/TableComponent.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/setup-min-max-by-item/TableComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/setup-min-max-by-item/SearchComponent.vue?vue&type=template&id=38789154&":
/*!*************************************************************************************************************!*\
  !*** ./resources/js/components/pm/setup-min-max-by-item/SearchComponent.vue?vue&type=template&id=38789154& ***!
  \*************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchComponent_vue_vue_type_template_id_38789154___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchComponent_vue_vue_type_template_id_38789154___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchComponent_vue_vue_type_template_id_38789154___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SearchComponent.vue?vue&type=template&id=38789154& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/setup-min-max-by-item/SearchComponent.vue?vue&type=template&id=38789154&");


/***/ }),

/***/ "./resources/js/components/pm/setup-min-max-by-item/TableComponent.vue?vue&type=template&id=9e46dc00&":
/*!************************************************************************************************************!*\
  !*** ./resources/js/components/pm/setup-min-max-by-item/TableComponent.vue?vue&type=template&id=9e46dc00& ***!
  \************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponent_vue_vue_type_template_id_9e46dc00___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponent_vue_vue_type_template_id_9e46dc00___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponent_vue_vue_type_template_id_9e46dc00___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableComponent.vue?vue&type=template&id=9e46dc00& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/setup-min-max-by-item/TableComponent.vue?vue&type=template&id=9e46dc00&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/setup-min-max-by-item/SearchComponent.vue?vue&type=template&id=38789154&":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/setup-min-max-by-item/SearchComponent.vue?vue&type=template&id=38789154& ***!
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
    _c("div", { staticClass: "ibox" }, [
      _c("div", { staticClass: "ibox-content" }, [
        _c("div", { staticClass: "row" }, [
          _c(
            "div",
            { staticClass: "col-3" },
            [
              _vm._m(0),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.itemcat,
                    expression: "itemcat"
                  }
                ],
                attrs: {
                  type: "hidden",
                  name: "search[itemcat]",
                  autocomplete: "off"
                },
                domProps: { value: _vm.itemcat },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.itemcat = $event.target.value
                  }
                }
              }),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.itemcat,
                    expression: "itemcat"
                  }
                ],
                attrs: { type: "hidden", name: "itemcat", autocomplete: "off" },
                domProps: { value: _vm.itemcat },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.itemcat = $event.target.value
                  }
                }
              }),
              _vm._v(" "),
              _c(
                "el-select",
                {
                  staticClass: "w-100",
                  attrs: {
                    placeholder: "โปรดเลือกประเภทวัตถุดิบ",
                    clearable: "",
                    filterable: "",
                    remote: "",
                    "reserve-keyword": ""
                  },
                  on: {
                    change: function($event) {
                      return _vm.getOrganization(_vm.itemcat)
                    }
                  },
                  model: {
                    value: _vm.itemcat,
                    callback: function($$v) {
                      _vm.itemcat = $$v
                    },
                    expression: "itemcat"
                  }
                },
                _vm._l(_vm.tobaccoItemcatList, function(itemcat, index) {
                  return _c("el-option", {
                    key: index,
                    attrs: {
                      label:
                        itemcat.tobacco_group_code +
                        " : " +
                        itemcat.tobacco_group,
                      value: itemcat.tobacco_group_code
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
            { staticClass: "col-3" },
            [
              _vm._m(1),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.organizationSearch,
                    expression: "organizationSearch"
                  }
                ],
                attrs: {
                  type: "hidden",
                  name: "search[organization]",
                  autocomplete: "off"
                },
                domProps: { value: _vm.organizationSearch },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.organizationSearch = $event.target.value
                  }
                }
              }),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.organizationSearch,
                    expression: "organizationSearch"
                  }
                ],
                attrs: {
                  type: "hidden",
                  name: "organization",
                  autocomplete: "off"
                },
                domProps: { value: _vm.organizationSearch },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.organizationSearch = $event.target.value
                  }
                }
              }),
              _vm._v(" "),
              _c("el-input", {
                directives: [
                  {
                    name: "loading",
                    rawName: "v-loading",
                    value: _vm.loading.organizationShow,
                    expression: "loading.organizationShow"
                  }
                ],
                attrs: { placeholder: "organization", disabled: true },
                model: {
                  value: _vm.organizationShow,
                  callback: function($$v) {
                    _vm.organizationShow = $$v
                  },
                  expression: "organizationShow"
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-3" },
            [
              _vm._m(2),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.locationSearch,
                    expression: "locationSearch"
                  }
                ],
                attrs: {
                  type: "hidden",
                  name: "search[location]",
                  autocomplete: "off"
                },
                domProps: { value: _vm.locationSearch },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.locationSearch = $event.target.value
                  }
                }
              }),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.locationSearch,
                    expression: "locationSearch"
                  }
                ],
                attrs: {
                  type: "hidden",
                  name: "location",
                  autocomplete: "off"
                },
                domProps: { value: _vm.locationSearch },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.locationSearch = $event.target.value
                  }
                }
              }),
              _vm._v(" "),
              _c("el-input", {
                directives: [
                  {
                    name: "loading",
                    rawName: "v-loading",
                    value: _vm.loading.locationShow,
                    expression: "loading.locationShow"
                  }
                ],
                attrs: {
                  placeholder: "คลังจัดเก็บ/สถานที่จัดเก็บ",
                  disabled: true
                },
                model: {
                  value: _vm.locationShow,
                  callback: function($$v) {
                    _vm.locationShow = $$v
                  },
                  expression: "locationShow"
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-3" },
            [
              _vm._m(3),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.itemNumber,
                    expression: "itemNumber"
                  }
                ],
                attrs: {
                  type: "hidden",
                  name: "search[itemNumber]",
                  autocomplete: "off"
                },
                domProps: { value: _vm.itemNumber },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.itemNumber = $event.target.value
                  }
                }
              }),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.itemNumber,
                    expression: "itemNumber"
                  }
                ],
                attrs: {
                  type: "hidden",
                  name: "itemNumber",
                  autocomplete: "off"
                },
                domProps: { value: _vm.itemNumber },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.itemNumber = $event.target.value
                  }
                }
              }),
              _vm._v(" "),
              _c(
                "el-select",
                {
                  directives: [
                    {
                      name: "loading",
                      rawName: "v-loading",
                      value: _vm.loading.itemNumber,
                      expression: "loading.itemNumber"
                    }
                  ],
                  staticClass: "w-100",
                  attrs: {
                    filterable: "",
                    remote: "",
                    "reserve-keyword": "",
                    clearable: "",
                    placeholder: "โปรดเลือกรหัสวัตถุดิบ",
                    disabled: _vm.isDisabledItemNumber
                  },
                  model: {
                    value: _vm.itemNumber,
                    callback: function($$v) {
                      _vm.itemNumber = $$v
                    },
                    expression: "itemNumber"
                  }
                },
                _vm._l(_vm.itemNumberList, function(itemNumber, index) {
                  return _c("el-option", {
                    key: index,
                    attrs: {
                      label:
                        itemNumber.item_number + " : " + itemNumber.item_desc,
                      value: itemNumber.inventory_item_id
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
        _c(
          "div",
          { staticClass: "text-right", staticStyle: { "padding-top": "15px" } },
          [
            _c(
              "button",
              {
                staticClass: "btn btn-light",
                attrs: {
                  disabled: !_vm.organizationSearch || !_vm.locationSearch
                },
                on: {
                  click: function($event) {
                    $event.preventDefault()
                    return _vm.search(
                      _vm.organizationSearch,
                      _vm.locationSearch,
                      _vm.itemcat,
                      _vm.itemNumber
                    )
                  }
                }
              },
              [
                _c("i", {
                  staticClass: "fa fa-search",
                  attrs: { "aria-hidden": "true" }
                }),
                _vm._v(" แสดงข้อมูล\n        ")
              ]
            ),
            _vm._v(" "),
            _c(
              "a",
              {
                staticClass: "btn btn-danger",
                attrs: {
                  type: "button",
                  href: "/pm/settings/setup-min-max-by-item"
                }
              },
              [_vm._v("\n          ล้างค่า\n        ")]
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
            value: _vm.loading.tableData,
            expression: "loading.tableData"
          }
        ]
      },
      [
        _c("setup-min-max-by-item-table", {
          attrs: {
            organizationSearch: _vm.organizationSearch,
            itemNumberSearch: _vm.itemNumber,
            listSetupMinMax: _vm.listSetupMinMax,
            listSearchItemNumber: _vm.listSearchItemNumber,
            btnTrans: _vm.btnTrans,
            searched: _vm.searched
          }
        })
      ],
      1
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "w-100 text-left" }, [
      _c("strong", [_vm._v(" ประเภทวัตถุดิบ")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "w-100 text-left" }, [
      _c("strong", [_vm._v(" Organization")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "w-100 text-left" }, [
      _c("strong", [_vm._v(" คลังจัดเก็บ/สถานที่จัดเก็บ")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "w-100 text-left" }, [
      _c("strong", [_vm._v(" รหัสวัตถุดิบ ")])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/setup-min-max-by-item/TableComponent.vue?vue&type=template&id=9e46dc00&":
/*!***************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/setup-min-max-by-item/TableComponent.vue?vue&type=template&id=9e46dc00& ***!
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
  return _c("div", [
    _c("div", { staticClass: "ibox" }, [
      _vm._m(0),
      _vm._v(" "),
      _c("div", { staticClass: "ibox-content" }, [
        _c(
          "div",
          {
            staticClass: "text-right",
            staticStyle: { "padding-bottom": "15px" }
          },
          [
            _c(
              "button",
              {
                staticClass: "btn btn-sm btn-primary",
                attrs: { disabled: _vm.isDisabledBtuAdd },
                on: {
                  click: function($event) {
                    $event.preventDefault()
                    return _vm.addLine($event)
                  }
                }
              },
              [
                _c("i", {
                  staticClass: "fa fa-plus",
                  attrs: { "aria-hidden": "true" }
                }),
                _vm._v(" เพิ่มรายการ \n                ")
              ]
            )
          ]
        ),
        _vm._v(" "),
        _c(
          "table",
          {
            staticClass: "table",
            attrs: { id: "setup-min-max-by-item-datatable-bk" }
          },
          [
            _vm._m(1),
            _vm._v(" "),
            _vm.testList == "NoSearchData"
              ? _c(
                  "tbody",
                  [
                    _c("tr", [
                      _vm.isTextFlag
                        ? _c(
                            "td",
                            {
                              staticClass: "text-center",
                              attrs: { colspan: "8" }
                            },
                            [
                              _c("h2", [
                                _vm._v(_vm._s("ไม่มีข้อมูล กำหนดค่าเฝ้าระวัง"))
                              ])
                            ]
                          )
                        : _vm._e()
                    ]),
                    _vm._v(" "),
                    _vm._l(_vm.lines, function(row, index) {
                      return _c("tr", { key: index, attrs: { row: row } }, [
                        _c(
                          "td",
                          [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: row.itemNumber,
                                  expression: "row.itemNumber"
                                }
                              ],
                              attrs: {
                                type: "hidden",
                                name:
                                  "newDataGroup[" + row.id + "][item_number]",
                                autocomplete: "off"
                              },
                              domProps: { value: row.itemNumber },
                              on: {
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(
                                    row,
                                    "itemNumber",
                                    $event.target.value
                                  )
                                }
                              }
                            }),
                            _vm._v(" "),
                            _c(
                              "el-select",
                              {
                                directives: [
                                  {
                                    name: "loading",
                                    rawName: "v-loading",
                                    value: _vm.loading.itemNumber,
                                    expression: "loading.itemNumber"
                                  }
                                ],
                                staticClass: "w-100",
                                attrs: {
                                  filterable: "",
                                  remote: "",
                                  "reserve-keyword": "",
                                  placeholder: "Select"
                                },
                                on: {
                                  change: function($event) {
                                    return _vm.getUom(
                                      row.itemNumber,
                                      row,
                                      _vm.organization
                                    )
                                  }
                                },
                                model: {
                                  value: row.itemNumber,
                                  callback: function($$v) {
                                    _vm.$set(row, "itemNumber", $$v)
                                  },
                                  expression: "row.itemNumber"
                                }
                              },
                              _vm._l(row.itemNumbersList, function(
                                itemNumber,
                                index
                              ) {
                                return _c("el-option", {
                                  key: index,
                                  attrs: {
                                    label:
                                      itemNumber.item_number +
                                      " : " +
                                      itemNumber.item_desc,
                                    value: itemNumber.inventory_item_id
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
                          {
                            staticStyle: {
                              "vertical-align": "middle",
                              "padding-left": "10px"
                            }
                          },
                          [
                            _vm._v(
                              "\n                            " +
                                _vm._s(row.itemNumberDes) +
                                " \n                        "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          [
                            _c("el-input", {
                              directives: [
                                {
                                  name: "loading",
                                  rawName: "v-loading",
                                  value: _vm.loading.primaryUnitOfMeasure,
                                  expression: "loading.primaryUnitOfMeasure"
                                }
                              ],
                              attrs: { disabled: true },
                              model: {
                                value: row.primaryUnitOfMeasure,
                                callback: function($$v) {
                                  _vm.$set(row, "primaryUnitOfMeasure", $$v)
                                },
                                expression: "row.primaryUnitOfMeasure"
                              }
                            })
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: row.minQty,
                                  expression: "row.minQty"
                                }
                              ],
                              attrs: {
                                type: "hidden",
                                name: "newDataGroup[" + row.id + "][min_qty]",
                                autocomplete: "off"
                              },
                              domProps: { value: row.minQty },
                              on: {
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(row, "minQty", $event.target.value)
                                }
                              }
                            }),
                            _vm._v(" "),
                            _c("vue-numeric", {
                              class:
                                "form-control text-right " +
                                (row.remarkImpossibleSmallValue
                                  ? "is-invalid"
                                  : ""),
                              attrs: {
                                separator: ",",
                                precision: 2,
                                minus: false
                              },
                              on: {
                                change: function($event) {
                                  return _vm.checkNumberSmallValue(
                                    row.minQty,
                                    row.maxQty,
                                    row
                                  )
                                }
                              },
                              model: {
                                value: row.minQty,
                                callback: function($$v) {
                                  _vm.$set(row, "minQty", $$v)
                                },
                                expression: "row.minQty"
                              }
                            })
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: row.maxQty,
                                  expression: "row.maxQty"
                                }
                              ],
                              attrs: {
                                type: "hidden",
                                name: "newDataGroup[" + row.id + "][max_qty]",
                                autocomplete: "off"
                              },
                              domProps: { value: row.maxQty },
                              on: {
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(row, "maxQty", $event.target.value)
                                }
                              }
                            }),
                            _vm._v(" "),
                            _c("vue-numeric", {
                              class:
                                "form-control text-right " +
                                (row.remarkImpossibleHighValue
                                  ? "is-invalid"
                                  : ""),
                              attrs: {
                                separator: ",",
                                precision: 2,
                                minus: false
                              },
                              on: {
                                change: function($event) {
                                  return _vm.checkNumberHighValue(
                                    row.minQty,
                                    row.maxQty,
                                    row
                                  )
                                }
                              },
                              model: {
                                value: row.maxQty,
                                callback: function($$v) {
                                  _vm.$set(row, "maxQty", $$v)
                                },
                                expression: "row.maxQty"
                              }
                            })
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: row.note,
                                  expression: "row.note"
                                }
                              ],
                              attrs: {
                                type: "hidden",
                                name:
                                  "newDataGroup[" + row.id + "][remark_msg]",
                                autocomplete: "off"
                              },
                              domProps: { value: row.note },
                              on: {
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(row, "note", $event.target.value)
                                }
                              }
                            }),
                            _vm._v(" "),
                            _c("el-input", {
                              attrs: {
                                type: "textarea",
                                rows: 1,
                                placeholder: "Please input"
                              },
                              model: {
                                value: row.note,
                                callback: function($$v) {
                                  _vm.$set(row, "note", $$v)
                                },
                                expression: "row.note"
                              }
                            })
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _c("td", [
                          _c(
                            "button",
                            {
                              staticClass:
                                "btn btn-sm btn-danger col text-center",
                              on: {
                                click: function($event) {
                                  $event.preventDefault()
                                  return _vm.removeRow(index)
                                }
                              }
                            },
                            [
                              _c("i", {
                                staticClass: "fa fa-times",
                                attrs: { "aria-hidden": "true" }
                              })
                            ]
                          )
                        ])
                      ])
                    })
                  ],
                  2
                )
              : _vm.testList.length != 0
              ? _c(
                  "tbody",
                  [
                    _vm._l(_vm.testList, function(test, row) {
                      return _c(
                        "tr",
                        { key: "showData" + row, attrs: { row: row } },
                        [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: test.setup_min_max_id,
                                expression: "test.setup_min_max_id"
                              }
                            ],
                            attrs: {
                              type: "hidden",
                              name:
                                "updateDataGroup[" +
                                row +
                                "][setup_min_max_id]",
                              autocomplete: "off"
                            },
                            domProps: { value: test.setup_min_max_id },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.$set(
                                  test,
                                  "setup_min_max_id",
                                  $event.target.value
                                )
                              }
                            }
                          }),
                          _vm._v(" "),
                          _c(
                            "td",
                            {
                              staticStyle: {
                                "vertical-align": "middle",
                                "padding-left": "10px"
                              }
                            },
                            [
                              _vm._v(
                                " \n                            " +
                                  _vm._s(test.item_number) +
                                  "\n                        "
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "td",
                            {
                              staticStyle: {
                                "vertical-align": "middle",
                                "padding-left": "10px"
                              }
                            },
                            [
                              _vm._v(
                                "\n                            " +
                                  _vm._s(test.item_desc) +
                                  "\n                        "
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "td",
                            {
                              staticStyle: {
                                "vertical-align": "middle",
                                "padding-left": "10px"
                              }
                            },
                            [
                              _vm._v(
                                "\n                            " +
                                  _vm._s(test.primary_unit_of_measure) +
                                  "\n                        "
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "td",
                            [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: test.min_qty,
                                    expression: "test.min_qty"
                                  }
                                ],
                                attrs: {
                                  type: "hidden",
                                  name: "updateDataGroup[" + row + "][min_qty]",
                                  autocomplete: "off"
                                },
                                domProps: { value: test.min_qty },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      test,
                                      "min_qty",
                                      $event.target.value
                                    )
                                  }
                                }
                              }),
                              _vm._v(" "),
                              _c("vue-numeric", {
                                class:
                                  "form-control text-right " +
                                  (test.remarkImpossibleSmallValue
                                    ? "is-invalid"
                                    : ""),
                                attrs: {
                                  separator: ",",
                                  precision: 2,
                                  minus: false
                                },
                                on: {
                                  change: function($event) {
                                    return _vm.checkNumberSmallValue(
                                      test.min_qty,
                                      test.max_qty,
                                      test
                                    )
                                  }
                                },
                                model: {
                                  value: test.min_qty,
                                  callback: function($$v) {
                                    _vm.$set(test, "min_qty", $$v)
                                  },
                                  expression: "test.min_qty"
                                }
                              })
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c(
                            "td",
                            [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: test.max_qty,
                                    expression: "test.max_qty"
                                  }
                                ],
                                attrs: {
                                  type: "hidden",
                                  name: "updateDataGroup[" + row + "][max_qty]",
                                  autocomplete: "off"
                                },
                                domProps: { value: test.max_qty },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      test,
                                      "max_qty",
                                      $event.target.value
                                    )
                                  }
                                }
                              }),
                              _vm._v(" "),
                              _c("vue-numeric", {
                                class:
                                  "form-control text-right " +
                                  (test.remarkImpossibleHighValue
                                    ? "is-invalid"
                                    : ""),
                                attrs: {
                                  separator: ",",
                                  precision: 2,
                                  minus: false
                                },
                                on: {
                                  change: function($event) {
                                    return _vm.checkNumberHighValue(
                                      test.min_qty,
                                      test.max_qty,
                                      test
                                    )
                                  }
                                },
                                model: {
                                  value: test.max_qty,
                                  callback: function($$v) {
                                    _vm.$set(test, "max_qty", $$v)
                                  },
                                  expression: "test.max_qty"
                                }
                              })
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c(
                            "td",
                            [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: test.remark_msg,
                                    expression: "test.remark_msg"
                                  }
                                ],
                                attrs: {
                                  type: "hidden",
                                  name:
                                    "updateDataGroup[" + row + "][remark_msg]",
                                  autocomplete: "off"
                                },
                                domProps: { value: test.remark_msg },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      test,
                                      "remark_msg",
                                      $event.target.value
                                    )
                                  }
                                }
                              }),
                              _vm._v(" "),
                              _c("el-input", {
                                attrs: {
                                  type: "textarea",
                                  rows: 1,
                                  placeholder: ""
                                },
                                model: {
                                  value: test.remark_msg,
                                  callback: function($$v) {
                                    _vm.$set(test, "remark_msg", $$v)
                                  },
                                  expression: "test.remark_msg"
                                }
                              })
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c("td", [
                            _c(
                              "button",
                              {
                                staticClass: "btn btn-sm btn-danger",
                                attrs: { "v-model": test.setup_min_max_id },
                                on: {
                                  click: function($event) {
                                    $event.preventDefault()
                                    return _vm.removeRowTableData(
                                      row,
                                      test.setup_min_max_id
                                    )
                                  }
                                }
                              },
                              [
                                _c("i", {
                                  staticClass: "fa fa-times",
                                  attrs: { "aria-hidden": "true" }
                                })
                              ]
                            )
                          ])
                        ]
                      )
                    }),
                    _vm._v(" "),
                    _vm._l(_vm.lines, function(row, index) {
                      return _c("tr", { key: index, attrs: { row: row } }, [
                        _c(
                          "td",
                          [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: row.itemNumber,
                                  expression: "row.itemNumber"
                                }
                              ],
                              attrs: {
                                type: "hidden",
                                name:
                                  "newDataGroup[" + row.id + "][item_number]",
                                autocomplete: "off"
                              },
                              domProps: { value: row.itemNumber },
                              on: {
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(
                                    row,
                                    "itemNumber",
                                    $event.target.value
                                  )
                                }
                              }
                            }),
                            _vm._v(" "),
                            _c(
                              "el-select",
                              {
                                directives: [
                                  {
                                    name: "loading",
                                    rawName: "v-loading",
                                    value: _vm.loading.itemNumber,
                                    expression: "loading.itemNumber"
                                  }
                                ],
                                staticClass: "w-100",
                                attrs: {
                                  filterable: "",
                                  remote: "",
                                  "reserve-keyword": "",
                                  placeholder: "Select"
                                },
                                on: {
                                  input: _vm.checkInput,
                                  change: function($event) {
                                    return _vm.getUom(
                                      row.itemNumber,
                                      row,
                                      _vm.organization
                                    )
                                  }
                                },
                                model: {
                                  value: row.itemNumber,
                                  callback: function($$v) {
                                    _vm.$set(row, "itemNumber", $$v)
                                  },
                                  expression: "row.itemNumber"
                                }
                              },
                              _vm._l(row.itemNumbersList, function(
                                itemNumber,
                                index
                              ) {
                                return _c("el-option", {
                                  key: index,
                                  attrs: {
                                    label:
                                      itemNumber.item_number +
                                      " : " +
                                      itemNumber.item_desc,
                                    value: itemNumber.inventory_item_id
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
                          {
                            staticStyle: {
                              "vertical-align": "middle",
                              "padding-left": "10px"
                            }
                          },
                          [
                            _vm._v(
                              " \n                            " +
                                _vm._s(row.itemNumberDes) +
                                " \n                        "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          [
                            _c("el-input", {
                              directives: [
                                {
                                  name: "loading",
                                  rawName: "v-loading",
                                  value: _vm.loading.primaryUnitOfMeasure,
                                  expression: "loading.primaryUnitOfMeasure"
                                }
                              ],
                              attrs: { disabled: true },
                              model: {
                                value: row.primaryUnitOfMeasure,
                                callback: function($$v) {
                                  _vm.$set(row, "primaryUnitOfMeasure", $$v)
                                },
                                expression: "row.primaryUnitOfMeasure"
                              }
                            })
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: row.minQty,
                                  expression: "row.minQty"
                                }
                              ],
                              attrs: {
                                type: "hidden",
                                name: "newDataGroup[" + row.id + "][min_qty]",
                                autocomplete: "off"
                              },
                              domProps: { value: row.minQty },
                              on: {
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(row, "minQty", $event.target.value)
                                }
                              }
                            }),
                            _vm._v(" "),
                            _c("vue-numeric", {
                              class:
                                "form-control text-right " +
                                (row.remarkImpossibleSmallValue
                                  ? "is-invalid"
                                  : ""),
                              attrs: {
                                separator: ",",
                                precision: 2,
                                minus: false
                              },
                              on: {
                                change: function($event) {
                                  return _vm.checkNumberSmallValue(
                                    row.minQty,
                                    row.maxQty,
                                    row
                                  )
                                }
                              },
                              model: {
                                value: row.minQty,
                                callback: function($$v) {
                                  _vm.$set(row, "minQty", $$v)
                                },
                                expression: "row.minQty"
                              }
                            })
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: row.maxQty,
                                  expression: "row.maxQty"
                                }
                              ],
                              attrs: {
                                type: "hidden",
                                name: "newDataGroup[" + row.id + "][max_qty]",
                                autocomplete: "off"
                              },
                              domProps: { value: row.maxQty },
                              on: {
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(row, "maxQty", $event.target.value)
                                }
                              }
                            }),
                            _vm._v(" "),
                            _c("vue-numeric", {
                              class:
                                "form-control text-right " +
                                (row.remarkImpossibleHighValue
                                  ? "is-invalid"
                                  : ""),
                              attrs: {
                                separator: ",",
                                precision: 2,
                                minus: false
                              },
                              on: {
                                change: function($event) {
                                  return _vm.checkNumberHighValue(
                                    row.minQty,
                                    row.maxQty,
                                    row
                                  )
                                }
                              },
                              model: {
                                value: row.maxQty,
                                callback: function($$v) {
                                  _vm.$set(row, "maxQty", $$v)
                                },
                                expression: "row.maxQty"
                              }
                            })
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _c(
                          "td",
                          [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: row.note,
                                  expression: "row.note"
                                }
                              ],
                              attrs: {
                                type: "hidden",
                                name:
                                  "newDataGroup[" + row.id + "][remark_msg]",
                                autocomplete: "off"
                              },
                              domProps: { value: row.note },
                              on: {
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(row, "note", $event.target.value)
                                }
                              }
                            }),
                            _vm._v(" "),
                            _c("el-input", {
                              attrs: {
                                type: "textarea",
                                rows: 1,
                                placeholder: ""
                              },
                              on: { input: _vm.checkInput },
                              model: {
                                value: row.note,
                                callback: function($$v) {
                                  _vm.$set(row, "note", $$v)
                                },
                                expression: "row.note"
                              }
                            })
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _c("td", [
                          _c(
                            "button",
                            {
                              staticClass:
                                "btn btn-sm btn-danger col text-center",
                              on: {
                                click: function($event) {
                                  $event.preventDefault()
                                  return _vm.removeRow(index)
                                }
                              }
                            },
                            [
                              _c("i", {
                                staticClass: "fa fa-times",
                                attrs: { "aria-hidden": "true" }
                              })
                            ]
                          )
                        ])
                      ])
                    })
                  ],
                  2
                )
              : _c("tbody", [
                  _c("tr", [
                    _c(
                      "td",
                      { staticClass: "text-center", attrs: { colspan: "8" } },
                      [
                        _c("h2", [
                          _vm._v(
                            _vm._s(
                              "โปรดทำการเลือก Organization คลังจัดเก็บ/สถานที่จัดเก็บ และรหัสวัตถุดิบ ก่อน"
                            )
                          )
                        ])
                      ]
                    )
                  ])
                ])
          ]
        ),
        _vm._v(" "),
        _c("div", { staticClass: "col-12 mt-3" }, [
          _c("div", { staticClass: "row clearfix text-right" }, [
            _c(
              "div",
              { staticClass: "col", staticStyle: { "margin-top": "15px" } },
              [
                _c(
                  "button",
                  {
                    class: _vm.btnTrans.save.class,
                    attrs: { disabled: _vm.isDisabledBtuAdd }
                  },
                  [
                    _c("i", {
                      class: _vm.btnTrans.save.icon,
                      attrs: { "aria-hidden": "true" }
                    }),
                    _vm._v(
                      " " +
                        _vm._s(_vm.btnTrans.save.text) +
                        " \n                        "
                    )
                  ]
                )
              ]
            )
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
    return _c("div", { staticClass: "ibox-title" }, [
      _c("h5", [_vm._v(" กำหนดค่าเฝ้าระวัง ")])
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
            staticStyle: { "font-size": "small" },
            attrs: { width: "15%" }
          },
          [
            _c("div", [
              _vm._v("รหัสวัตถุดิบ "),
              _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
            ])
          ]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "font-size": "small" },
            attrs: { width: "40%" }
          },
          [_c("div", [_vm._v("รายละเอียด")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "font-size": "small" },
            attrs: { width: "10%" }
          },
          [_c("div", [_vm._v("หน่วย")])]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "font-size": "small" },
            attrs: { width: "10%" }
          },
          [
            _c("div", [
              _vm._v("ค่าเฝ้าระวังต่ำสุด "),
              _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
            ])
          ]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "font-size": "small" },
            attrs: { width: "10%" }
          },
          [
            _c("div", [
              _vm._v("ค่าเฝ้าระวังสูงสุด "),
              _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
            ])
          ]
        ),
        _vm._v(" "),
        _c(
          "th",
          {
            staticClass: "text-center",
            staticStyle: { "font-size": "small" },
            attrs: { width: "20%" }
          },
          [_c("div", [_vm._v("หมายเหตุ")])]
        ),
        _vm._v(" "),
        _c("th", {
          staticClass: "text-center",
          staticStyle: { "font-size": "small" }
        })
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);