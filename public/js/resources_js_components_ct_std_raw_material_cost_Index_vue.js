(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ct_std_raw_material_cost_Index_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std_raw_material_cost/Index.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std_raw_material_cost/Index.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var numeral__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! numeral */ "./node_modules/numeral/numeral.js");
/* harmony import */ var numeral__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(numeral__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var xlsx__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! xlsx */ "./node_modules/xlsx/xlsx.js");
/* harmony import */ var xlsx__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(xlsx__WEBPACK_IMPORTED_MODULE_3__);


function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && Symbol.iterator in Object(iter)) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["is_create"],
  data: function data() {
    return {
      loadingInput: {},
      loading: false,
      form_error: {},
      form: {
        period_year: "",
        cost_code: "",
        uom_code: "",
        description: "",
        quantity: "",
        version: "",
        plan_version: "",
        start_date_thai: "",
        end_date_thai: "",
        shot_year_thai: "",
        approved_status: ""
      },
      date_form: {
        start_date: "",
        end_date: ""
      },
      old_data: {
        start_date_thai: "",
        end_date_thai: ""
      },
      status: {
        tableData: false,
        tableDataLine: false
      },
      option: {
        fiscal_year: [],
        cost_center: [],
        plan_version_no: [],
        version: []
      },
      enable_flag_select: [],
      enable_flag_selectY: [],
      enable_flag_selectN: [],
      multipleSelection: [],
      multipleSelectionY: [],
      multipleSelectionN: [],
      tableDataHeader: [],
      tableDataLine: [],
      headLine: {}
    };
  },
  computed: {
    unitPerCostCenter: function unitPerCostCenter() {
      var rs = "";

      if (this.form.cost_code && this.form.quantity && this.form.uom_code) {
        rs = "".concat(this.form.quantity, " ").concat(this.form.uom_code);
      }

      return rs;
    },
    disableStore: function disableStore() {
      if (this.form.cost_code && this.form.period_year && this.form.version) {
        return false;
      } else {
        return true;
      }
    }
  },
  created: function created() {
    this.getMasterData();
  },
  methods: {
    startDateSelected: function startDateSelected(date) {
      this.form.start_date_thai = moment__WEBPACK_IMPORTED_MODULE_1___default()(date).format("DD/MM/YYYY");
    },
    endDateSelected: function endDateSelected(date) {
      this.form.end_date_thai = moment__WEBPACK_IMPORTED_MODULE_1___default()(date).format("DD/MM/YYYY");
    },
    updateDateThai: function updateDateThai() {
      var _this = this;

      var form = {
        start_date_thai: this.form.start_date_thai,
        end_date_thai: this.form.end_date_thai,
        cost_code: this.form.cost_code,
        period_year: this.form.period_year,
        version_no: this.form.version,
        plan_version: this.form.plan_version
      };
      axios.post("/ct/ajax/std_raw_material_cost/date", form).then(function (res) {
        if (res.data.status == 'E') {
          _this.$message({
            showClose: true,
            message: res.data.msg,
            type: "error"
          });
        } else {
          _this.$message({
            showClose: true,
            message: "อัพเดทวันที่สำเร็จ",
            type: "success"
          });

          _this.old_data.start_date_thai = _this.form.start_date_thai;
          _this.old_data.end_date_thai = _this.form.end_date_thai;
        }
      })["catch"](function (err) {});
    },
    toggleSelection: function toggleSelection(rows) {
      var _this2 = this;

      if (rows) {
        rows.forEach(function (row) {
          _this2.$refs.multipleTable.toggleRowSelection(row);
        });
      } else {
        this.$refs.multipleTable.clearSelection();
      }
    },
    toggleSelectionY: function toggleSelectionY(rows) {
      var _this3 = this;

      if (rows) {
        rows.forEach(function (row) {
          _this3.$refs.multipleTableY.toggleRowSelection(row);
        });
      } else {
        this.$refs.multipleTableY.clearSelection();
      }
    },
    toggleSelectionN: function toggleSelectionN(rows) {
      var _this4 = this;

      if (rows) {
        rows.forEach(function (row) {
          _this4.$refs.multipleTableN.toggleRowSelection(row);
        });
      } else {
        this.$refs.multipleTableN.clearSelection();
      }
    },
    handleSelectionChange: function handleSelectionChange(val) {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var selection;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this5.multipleSelection = val;
                selection = [];
                val.forEach(function (item) {
                  selection.push(item.product_item_number);
                });
                _context.next = 5;
                return selection;

              case 5:
                _this5.enable_flag_select = _context.sent;
                _context.next = 8;
                return _this5.enableFlagUpdate();

              case 8:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    handleSelectionChangeY: function handleSelectionChangeY(val) {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var select_flag;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                select_flag = [];

                _this6.tableDataHeaderN.forEach(function (item) {
                  if (item.enable_flag == "Y") {
                    select_flag.push(item.product_item_number);
                  }
                });

                val.forEach(function (item) {
                  select_flag.push(item.product_item_number);
                });
                _context2.next = 5;
                return select_flag;

              case 5:
                _this6.enable_flag_select = _context2.sent;
                _context2.next = 8;
                return _this6.enableFlagUpdate();

              case 8:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    handleSelectionChangeN: function handleSelectionChangeN(val) {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var select_flag;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                select_flag = [];

                _this7.tableDataHeaderY.forEach(function (item) {
                  if (item.enable_flag == "Y") {
                    select_flag.push(item.product_item_number);
                  }
                });

                val.forEach(function (item) {
                  select_flag.push(item.product_item_number);
                });
                _context3.next = 5;
                return select_flag;

              case 5:
                _this7.enable_flag_select = _context3.sent;
                _context3.next = 8;
                return _this7.enableFlagUpdate();

              case 8:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    enableFlagUpdate: _.debounce( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
      var _this8 = this;

      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
        while (1) {
          switch (_context4.prev = _context4.next) {
            case 0:
              _context4.next = 2;
              return true;

            case 2:
              this.loading = _context4.sent;
              _context4.next = 5;
              return _toConsumableArray(new Set(this.enable_flag_select));

            case 5:
              this.form.enable_flag = _context4.sent;
              ;
              axios.post("/ct/ajax/std_raw_material_cost/enable_flag", this.form).then(function (res) {
                console.log(res.data);
                var _this8$form = _this8.form,
                    cost_code = _this8$form.cost_code,
                    period_year = _this8$form.period_year,
                    version = _this8$form.version,
                    plan_version = _this8$form.plan_version;
                axios.get("/ct/ajax/std_raw_material_cost?cost_code=".concat(cost_code, "&period_year=").concat(period_year, "&version_no=").concat(version, "&plan_version_no=").concat(plan_version)).then(function (res) {
                  _this8.tableDataHeader = res.data.data;

                  _this8.tableDataHeader.sort(function (a, b) {
                    return a.product_item_number - b.product_item_number;
                  });
                });
              })["catch"](function (err) {}).then(function () {
                _this8.loading = false;
              });

            case 8:
            case "end":
              return _context4.stop();
          }
        }
      }, _callee4, this);
    })), 1000),
    numberWithCommas: function numberWithCommas(x) {
      return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    },
    numberFormat: function numberFormat(v) {
      var format = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "0.0[000000000]";
      var res = numeral__WEBPACK_IMPORTED_MODULE_2___default()(v).format(format);

      if (res == "NaN") {
        res = v;
      }

      return res;
    },
    getMasterData: function getMasterData() {
      var _this9 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee5() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                _this9.loading = true;

                _this9.getPeriodYears();

                _this9.getCostCenters();

                _this9.loading = false;

              case 4:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5);
      }))();
    },
    getCostCenters: function getCostCenters() {
      var _this10 = this;

      this.loading = true; // if (this.is_create) {

      axios.get("/ct/ajax/cost_center/cost-center-view").then(function (res) {
        _this10.option.cost_center = res.data;
      }).then(function () {
        _this10.loading = false;
      }); // } else {
      // axios.get("/ct/ajax/std_raw_material_cost/get_cost_center", {
      //     params: {
      //         version_no: this.form.version,
      //     }
      // })
      // .then(res => {
      //     this.option.cost_center = res.data;
      // })
      // .then(() => {
      //     this.loading = false;
      // });
      // }
    },
    getPeriodYears: function getPeriodYears() {
      var _this11 = this;

      this.loadingInput.fiscal_year = true;
      axios.get("/ct/ajax/product_plan_amount/years").then(function (res) {
        _this11.option.fiscal_year = res.data;
      });
      this.loadingInput.fiscal_year = false;
    },
    errorMessage: function errorMessage(err) {
      var _this12 = this;

      var errors = err.errors;

      if (errors) {
        Object.keys(errors).forEach(function (item) {
          _this12.form_error[item] = {};
          _this12.form_error[item]["title"] = item;
          _this12.form_error[item]["message"] = errors[item][0];
        });
        this.resetError();
      }
    },
    selectFiscalYear: function selectFiscalYear() {
      var _this13 = this;

      var years = this.option.fiscal_year.find(function (item) {
        return item.period_year == _this13.form.period_year;
      }); // this.form.start_date_thai = years.start_date_thai;
      // this.form.end_date_thai = years.end_date_thai;

      this.form.shot_year_thai = years.shot_year_thai;
      this.getDropDownVersion();
      this.getDropDownPlanVersion();
      this.getPlanVersion();
      this.getVersion();
    },
    selectCostCenter: function selectCostCenter() {
      var _this14 = this;

      var cost_center = this.option.cost_center.find(function (item) {
        return item.cost_code == _this14.form.cost_code;
      });
      this.form.description = cost_center.description;
      this.form.uom_code = cost_center.uom_code;
      this.form.quantity = cost_center.quantity;
    },
    resetError: function resetError() {
      var _this15 = this;

      setTimeout(function () {
        _this15.form_error = {};
      }, 5000);
    },
    getSummaries: function getSummaries(param) {
      var _this16 = this;

      var columns = param.columns,
          data = param.data;
      var sums = [];
      columns.forEach(function (column, index) {
        if (index === 0) {
          sums[index] = "รวม";
          return;
        }

        var values = data.map(function (item) {
          return Number(item[column.property]);
        });

        if (column.property == "cost_raw_mate" && !values.every(function (value) {
          return isNaN(value);
        })) {
          sums[index] = _this16.headLine.summary_cost != 0 ? _this16.numberWithCommas(parseFloat(_this16.headLine.summary_cost).toFixed(9)) : _this16.headLine.summary_cost;
        } else if (column.property == "quantity_used" && !values.every(function (value) {
          return isNaN(value);
        })) {
          var sum = _.sumBy(_this16.tableDataLine, function (item) {
            return parseFloat(item.quantity_used);
          });

          sums[index] = _this16.numberWithCommas(parseFloat(sum).toFixed(9));
        } else {
          sums[index] = "";
        }
      });
      return sums;
    },
    getTableDataLine: function getTableDataLine(row) {
      var _this17 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee6() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee6$(_context6) {
          while (1) {
            switch (_context6.prev = _context6.next) {
              case 0:
                _this17.loading = true;
                _this17.headLine.productGroup = "".concat(row.product_group, " ").concat(row.product_group_name);
                _this17.headLine.productGroupDetail = "".concat(row.product_item_number, "-").concat(row.product_item_desc);
                _this17.headLine.summary_cost = "".concat(row.summary_cost);
                _context6.next = 6;
                return axios.get("/ct/ajax/std_raw_material_cost/find?allocate_year_id=".concat(row.allocate_year_id, "&product_group=").concat(row.product_group, "&product_item_number=").concat(row.product_item_number)).then(function (res) {
                  _this17.tableDataLine = res.data;

                  _this17.tableDataLine.sort(function (a, b) {
                    return a.item_number - b.item_number;
                  });

                  _this17.status.tableDataLine = true;

                  _this17.$message({
                    showClose: true,
                    message: "ประมวลผลสำเร็จ",
                    type: "success"
                  });
                })["catch"](function (err) {
                  _this17.errorMessage(err.response);

                  _this17.$message({
                    showClose: true,
                    message: "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E1B\u0E23\u0E30\u0E21\u0E27\u0E25\u0E1C\u0E25\u0E44\u0E14\u0E49",
                    type: "error"
                  });
                }).then(function () {
                  _this17.loading = false;
                });

              case 6:
              case "end":
                return _context6.stop();
            }
          }
        }, _callee6);
      }))();
    },
    getDropDownPlanVersion: function getDropDownPlanVersion() {
      var _this18 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee7() {
        var _this18$form, period_year, cost_code;

        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee7$(_context7) {
          while (1) {
            switch (_context7.prev = _context7.next) {
              case 0:
                if (_this18.is_create) {
                  _context7.next = 4;
                  break;
                }

                _this18$form = _this18.form, period_year = _this18$form.period_year, cost_code = _this18$form.cost_code; // if (period_year && cost_code) {

                _context7.next = 4;
                return axios.get("/ct/ajax/std_raw_material_cost/plan_version_cost_head?period_year=".concat(period_year, "&cost_code=").concat(cost_code)).then(function (res) {
                  _this18.option.plan_version_no = res.data.plan_version_no;
                })["catch"](function (err) {}).then(function () {});

              case 4:
              case "end":
                return _context7.stop();
            }
          }
        }, _callee7);
      }))();
    },
    getDropDownVersion: function getDropDownVersion() {
      var _this19 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee8() {
        var _this19$form, period_year, cost_code;

        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee8$(_context8) {
          while (1) {
            switch (_context8.prev = _context8.next) {
              case 0:
                if (_this19.is_create) {
                  _context8.next = 4;
                  break;
                }

                _this19$form = _this19.form, period_year = _this19$form.period_year, cost_code = _this19$form.cost_code; // if (period_year && cost_code) {

                _context8.next = 4;
                return axios.get("/ct/ajax/std_raw_material_cost/version?period_year=".concat(period_year, "&cost_code=").concat(cost_code)).then(function (res) {
                  _this19.option.version = res.data.version;
                })["catch"](function (err) {}).then(function () {});

              case 4:
              case "end":
                return _context8.stop();
            }
          }
        }, _callee8);
      }))();
    },
    search: function search() {
      var _this20 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee9() {
        var _this20$form, cost_code, period_year, version, plan_version;

        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee9$(_context9) {
          while (1) {
            switch (_context9.prev = _context9.next) {
              case 0:
                _this20.loading = true;
                _this20$form = _this20.form, cost_code = _this20$form.cost_code, period_year = _this20$form.period_year, version = _this20$form.version, plan_version = _this20$form.plan_version;
                _context9.next = 4;
                return axios.get("/ct/ajax/std_raw_material_cost?cost_code=".concat(cost_code, "&period_year=").concat(period_year, "&version_no=").concat(version, "&plan_version_no=").concat(plan_version)).then(function (res) {
                  if (res.data.data.length > 0 && res.data.std_cost_head) {
                    var std_cost_head = res.data.std_cost_head;
                    _this20.tableDataHeader = res.data.data;

                    _this20.tableDataHeader.sort(function (a, b) {
                      return a.product_item_number - b.product_item_number;
                    });

                    _this20.tableDataHeaderY = _this20.tableDataHeader.filter(function (item) {
                      return item.approved_flag == 'Y';
                    });
                    _this20.tableDataHeaderN = _this20.tableDataHeader.filter(function (item) {
                      return item.approved_flag == 'N';
                    });
                    setTimeout(function () {
                      // const select_flag = _.filter(
                      //     this.tableDataHeader,
                      //     item => {
                      //         return item.enable_flag == "Y";
                      //     }
                      // );
                      var select_flagY = _.filter(_this20.tableDataHeaderY, function (item) {
                        return item.enable_flag == "Y";
                      });

                      var select_flagN = _.filter(_this20.tableDataHeaderN, function (item) {
                        return item.enable_flag == "Y";
                      }); // this.toggleSelection(select_flag);


                      _this20.toggleSelectionY(select_flagY);

                      _this20.toggleSelectionN(select_flagN);
                    }, 1000);
                    _this20.old_data.start_date_thai = std_cost_head.start_date_thai;
                    _this20.form.start_date_thai = std_cost_head.start_date_thai;
                    _this20.old_data.end_date_thai = std_cost_head.end_date_thai;
                    _this20.form.end_date_thai = std_cost_head.end_date_thai;
                    _this20.form.approved_status = _this20.convertStatus(std_cost_head.approved_status);
                    _this20.status.tableData = true;

                    _this20.$message({
                      showClose: true,
                      message: "ประมวลผลสำเร็จ",
                      type: "success"
                    });
                  } else {
                    _this20.tableDataHeader = [];
                    _this20.form.approved_status = "";
                    _this20.status.tableData = false;

                    if (!res.data.std_cost_head) {
                      _this20.$message({
                        showClose: true,
                        message: "\u0E44\u0E21\u0E48\u0E1E\u0E1A\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25 std_cost_heads",
                        type: "error"
                      });
                    } else if (res.data.data.length <= 0) {
                      _this20.$message({
                        showClose: true,
                        message: "\u0E44\u0E21\u0E48\u0E1E\u0E1A\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E15\u0E49\u0E19\u0E17\u0E38\u0E19\u0E27\u0E31\u0E15\u0E16\u0E38\u0E14\u0E34\u0E1A\u0E21\u0E32\u0E15\u0E23\u0E10\u0E32\u0E19",
                        type: "error"
                      });
                    } else {}
                  }
                })["catch"](function (err) {
                  _this20.tableDataHeader = [];
                  _this20.form.approved_status = "";
                  _this20.status.tableData = false;

                  _this20.errorMessage(err.response);

                  _this20.$message({
                    showClose: true,
                    message: "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E1B\u0E23\u0E30\u0E21\u0E27\u0E25\u0E1C\u0E25\u0E44\u0E14\u0E49",
                    type: "error"
                  });
                }).then(function () {
                  _this20.loading = false;
                });

              case 4:
              case "end":
                return _context9.stop();
            }
          }
        }, _callee9);
      }))();
    },
    store: function store() {
      var _this21 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee10() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee10$(_context10) {
          while (1) {
            switch (_context10.prev = _context10.next) {
              case 0:
                _context10.next = 2;
                return true;

              case 2:
                _this21.loading = _context10.sent;
                _context10.next = 5;
                return axios.post("/ct/ajax/std_raw_material_cost", _this21.form).then(function (res) {})["catch"](function (err) {
                  console.log(err.response.data);
                });

              case 5:
                _context10.next = 7;
                return _this21.search();

              case 7:
              case "end":
                return _context10.stop();
            }
          }
        }, _callee10);
      }))();
    },
    approveHeaderData: function approveHeaderData() {
      var _this22 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee11() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee11$(_context11) {
          while (1) {
            switch (_context11.prev = _context11.next) {
              case 0:
                _context11.next = 2;
                return true;

              case 2:
                _this22.loading = _context11.sent;
                _context11.next = 5;
                return _this22.enable_flag_select;

              case 5:
                _this22.form.enable_flag = _context11.sent;
                _context11.next = 8;
                return axios.post("/ct/ajax/std_raw_material_cost/approve", _this22.form).then(function (res) {
                  console.log(res.data);
                  _this22.form.status = "ยืนยันแล้ว";
                  _this22.form.approved_status = _this22.convertStatus(res.data.data);

                  if (res.data.status == 'E') {
                    _this22.$message({
                      showClose: true,
                      message: res.data.msg,
                      type: "error"
                    });
                  } else {
                    _this22.$message({
                      showClose: true,
                      message: "ประมวลผลสำเร็จ",
                      type: "success"
                    });
                  }
                })["catch"](function (err) {
                  var error = err.response.data.error ? err.response.data.error : "ไม่สามารถประมวลผลได้";

                  _this22.errorMessage(err.response);

                  _this22.$message({
                    showClose: true,
                    message: error,
                    type: "error"
                  });
                }).then(function () {
                  _this22.loading = false;
                });

              case 8:
              case "end":
                return _context11.stop();
            }
          }
        }, _callee11);
      }))();
    },
    approveLineData: function approveLineData(row) {
      var _this23 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee12() {
        var body;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee12$(_context12) {
          while (1) {
            switch (_context12.prev = _context12.next) {
              case 0:
                _context12.next = 2;
                return true;

              case 2:
                _this23.loading = _context12.sent;
                // this.form.enable_flag = await this.enable_flag_select;
                body = {
                  product_item_number: row.product_item_number,
                  cost_code: row.cost_code,
                  allocate_year_id: row.allocate_year_id
                };
                _context12.next = 6;
                return axios.post("/ct/ajax/std_raw_material_cost/approveLineData", body).then(function (res) {
                  _this23.form.status = "ยืนยันแล้ว";
                  _this23.form.approved_status = _this23.convertStatus(res.data.data);

                  _this23.$message({
                    showClose: true,
                    message: "ประมวลผลสำเร็จ",
                    type: "success"
                  });
                })["catch"](function (err) {
                  var error = err.response.data.error ? err.response.data.error : "ไม่สามารถประมวลผลได้";

                  _this23.errorMessage(err.response);

                  _this23.$message({
                    showClose: true,
                    message: error,
                    type: "error"
                  });
                }).then(function () {
                  _this23.loading = false;
                });

              case 6:
                _context12.next = 8;
                return _this23.search();

              case 8:
              case "end":
                return _context12.stop();
            }
          }
        }, _callee12);
      }))();
    },
    saveTableLine: function saveTableLine() {
      // update table line then refresh tableHeader
      this.store();
      this.closeTableLine();
    },
    closeTableLine: function closeTableLine() {
      this.status.tableDataLine = false;
    },
    refresh: function refresh() {
      this.form = {};
    },
    queryDataTableLine: function queryDataTableLine() {
      var _this24 = this;

      var json = [];
      this.tableDataLine.forEach(function (item) {
        var data = {
          รหัสวัตถุดิบ: item.item_number || "",
          ชื่อวัตถุดิบ: item.item_desc || "",
          ขั้นตอน: item.wip_step || "",
          จำนวนที่ใช้: item.quantity_used || "",
          หน่วย: item.uom_code || "",
          ราคาซื้อครั้งสุดท้าย: _this24.numberWithCommas(parseFloat(item.last_cost).toFixed(9)) || "",
          ราคามาตรฐานต่อหน่วย: _this24.numberWithCommas(parseFloat(item.unit_std_cost).toFixed(9)) || "",
          ต้นทุนวัตถุดิบรวม: _this24.numberWithCommas(parseFloat(item.cost_raw_mate).toFixed(9)) || ""
        };
        json.push(data);
      });
      this.exportJson(json);
    },
    queryTableDataHeader: function queryTableDataHeader() {
      var _this25 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee13() {
        var json;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee13$(_context13) {
          while (1) {
            switch (_context13.prev = _context13.next) {
              case 0:
                json = [];

                _this25.tableDataHeader.forEach(function (item) {
                  var data = {
                    ศูนย์ต้นทุน: _this25.form.cost_code || "",
                    ปีงบประมาณ: _this25.form.period_year || "",
                    กลุ่มผลิตภัณฑ์: item.product_group + item.product_group_name || "",
                    ผลิตภัณฑ์: item.product_item_number || "",
                    ชื่อผลิตภัณฑ์: item.product_item_desc || "",
                    "ต้นทุนวัตถุดิบรวม(บาท)": _this25.numberWithCommas(parseFloat(item.cost_raw_mate).toFixed(9)) || "",
                    "ต้นทุนวัตถุดิบมาตรฐานต่อ 1 หน่วย": _this25.numberWithCommas(parseFloat(item.unit_cost_raw_mate).toFixed(9)) || "",
                    วันที่เริ่มใช้: item.start_date || "",
                    วันที่สิ้นสุด: item.end_date || ""
                  };
                  json.push(data);
                });

                _this25.exportJson(json);

              case 3:
              case "end":
                return _context13.stop();
            }
          }
        }, _callee13);
      }))();
    },
    exportJson: function exportJson(json) {
      var data = json;
      /* this line is only needed if you are not adding a script tag reference */
      // if (typeof XLSX == "undefined") XLSX = require("xlsx");

      /* make the worksheet */

      var ws = xlsx__WEBPACK_IMPORTED_MODULE_3___default().utils.json_to_sheet(data);
      /* add to workbook */

      var wb = xlsx__WEBPACK_IMPORTED_MODULE_3___default().utils.book_new();
      xlsx__WEBPACK_IMPORTED_MODULE_3___default().utils.book_append_sheet(wb, ws, "ต้นทุนวัตถุดิบมาตรฐาน");
      /* generate an XLSX file */

      xlsx__WEBPACK_IMPORTED_MODULE_3___default().writeFile(wb, "ต้นทุนวัตถุดิบมาตรฐาน.xlsx");
    },
    convertStatus: function convertStatus(value) {
      switch (value) {
        case "Active":
          return "อนุมัติ";
          break;

        case "Inactive":
          return "ไม่อนุมัติ";
          break;
      }
    },
    getVersion: function getVersion() {
      var _this26 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee14() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee14$(_context14) {
          while (1) {
            switch (_context14.prev = _context14.next) {
              case 0:
                if (_this26.is_create) {
                  axios.get("/ct/ajax/std_raw_material_cost/get_version", {
                    params: {
                      period_year: _this26.form.period_year
                    }
                  }).then(function (res) {
                    _this26.form.version = res.data;
                  })["catch"](function (err) {}).then(function () {}); //     }
                }

              case 1:
              case "end":
                return _context14.stop();
            }
          }
        }, _callee14);
      }))();
    },
    getPlanVersion: function getPlanVersion() {
      var _this27 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee15() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee15$(_context15) {
          while (1) {
            switch (_context15.prev = _context15.next) {
              case 0:
                if (_this27.is_create) {
                  //     const { period_year, cost_code } = this.form;
                  //     if (period_year && cost_code) {
                  // await axios
                  //     .get(
                  //         `/ct/ajax/std_raw_material_cost/version?period_year=${period_year}&cost_code=${cost_code}`
                  //     )
                  axios.get("/ct/ajax/std_raw_material_cost/get_plan_version", {
                    params: {
                      period_year: _this27.form.period_year
                    }
                  }).then(function (res) {
                    _this27.form.plan_version = res.data;
                  })["catch"](function (err) {}).then(function () {}); //     }
                }

              case 1:
              case "end":
                return _context15.stop();
            }
          }
        }, _callee15);
      }))();
    },
    selectVersion: function selectVersion() {
      this.getCostCenters();
    },
    DateFormat: function DateFormat(row, column) {
      var date = row[column.property];

      if (date == undefined) {
        return "";
      }

      return moment__WEBPACK_IMPORTED_MODULE_1___default()(date).format("DD-MM-YYYY");
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std_raw_material_cost/Index.vue?vue&type=style&index=0&lang=scss&":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std_raw_material_cost/Index.vue?vue&type=style&index=0&lang=scss& ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, "/* el-card__body css cannot scoped !!!!!*/\n.box-card .el-card__body {\n  padding: 0 !important;\n}", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std_raw_material_cost/Index.vue?vue&type=style&index=1&id=ff17737c&lang=scss&scoped=true&":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std_raw_material_cost/Index.vue?vue&type=style&index=1&id=ff17737c&lang=scss&scoped=true& ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, ".el-card__body[data-v-ff17737c] {\n  padding: 0 !important;\n}\n.card_header[data-v-ff17737c] {\n  font-weight: bold;\n  font-size: 18px;\n}\n.card_body[data-v-ff17737c] {\n  padding: 20px;\n}\n.card_body[data-v-ff17737c]:not(:last-child) {\n  border-bottom: 1px solid #ebeef4;\n}\n.font-bold[data-v-ff17737c] {\n  font-weight: bold;\n}\n.text[data-v-ff17737c] {\n  font-size: 12px;\n}\n.item[data-v-ff17737c] {\n  margin-bottom: 18px;\n}\n.clearfix[data-v-ff17737c]:before,\n.clearfix[data-v-ff17737c]:after {\n  display: table;\n  content: \"\";\n}\n.clearfix[data-v-ff17737c]:after {\n  clear: both;\n}\n.box-card[data-v-ff17737c] {\n  width: 100%;\n  margin: 20px 0;\n}\n.w-100[data-v-ff17737c] {\n  width: 100%;\n}\n.error-message[data-v-ff17737c] {\n  display: flex;\n  color: #ec4958;\n  margin-top: 5px;\n}\n.error-message strong[data-v-ff17737c] {\n  margin-right: 5px;\n}\n.mt-custom__10[data-v-ff17737c] {\n  margin-top: 10px;\n}\n.text-title[data-v-ff17737c] {\n  font-size: 16px;\n  font-weight: 600;\n}\n.btn-info[data-v-ff17737c] {\n  background-color: #02b0ef;\n  border-color: #02b0ef;\n}\n.btn-success[data-v-ff17737c] {\n  background-color: #1ab394;\n  border-color: #1ab394;\n}\n.btn-cancel[data-v-ff17737c] {\n  background-color: #ec4958;\n  border-color: #ec4958;\n  color: white;\n}\n.text-refresh[data-v-ff17737c] {\n  color: #ec4958;\n}\n.td-select[data-v-ff17737c] {\n  cursor: pointer;\n  border: 2px solid #eee;\n  border-radius: 5px;\n  padding: 10px 0;\n}\n.background-dialog__custom[data-v-ff17737c] {\n  width: 100%;\n  height: 100%;\n  position: absolute;\n  top: 0;\n  left: 0;\n  z-index: 100;\n  background: #f3f3f4;\n  opacity: 0.7;\n}\n.flex_end[data-v-ff17737c] {\n  display: flex;\n  justify-content: flex-end;\n}\n.mx-datepicker[data-v-ff17737c] {\n  width: 100%;\n}\n.input-disable[data-v-ff17737c] {\n  background-color: #f5f7fa !important;\n  border-color: #e4e7ed !important;\n  color: #c0c4cc !important;\n  cursor: not-allowed !important;\n}\n.input-disable > .mx-input-wrapper > input[data-v-ff17737c] {\n  background-color: #f5f7fa !important;\n  border-color: #e4e7ed !important;\n  color: #c0c4cc !important;\n  cursor: not-allowed !important;\n}", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std_raw_material_cost/Index.vue?vue&type=style&index=0&lang=scss&":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std_raw_material_cost/Index.vue?vue&type=style&index=0&lang=scss& ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!../../../../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=style&index=0&lang=scss& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std_raw_material_cost/Index.vue?vue&type=style&index=0&lang=scss&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std_raw_material_cost/Index.vue?vue&type=style&index=1&id=ff17737c&lang=scss&scoped=true&":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std_raw_material_cost/Index.vue?vue&type=style&index=1&id=ff17737c&lang=scss&scoped=true& ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_style_index_1_id_ff17737c_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!../../../../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=style&index=1&id=ff17737c&lang=scss&scoped=true& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std_raw_material_cost/Index.vue?vue&type=style&index=1&id=ff17737c&lang=scss&scoped=true&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_style_index_1_id_ff17737c_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_style_index_1_id_ff17737c_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/components/ct/std_raw_material_cost/Index.vue":
/*!********************************************************************!*\
  !*** ./resources/js/components/ct/std_raw_material_cost/Index.vue ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_ff17737c_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=ff17737c&scoped=true& */ "./resources/js/components/ct/std_raw_material_cost/Index.vue?vue&type=template&id=ff17737c&scoped=true&");
/* harmony import */ var _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js& */ "./resources/js/components/ct/std_raw_material_cost/Index.vue?vue&type=script&lang=js&");
/* harmony import */ var _Index_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Index.vue?vue&type=style&index=0&lang=scss& */ "./resources/js/components/ct/std_raw_material_cost/Index.vue?vue&type=style&index=0&lang=scss&");
/* harmony import */ var _Index_vue_vue_type_style_index_1_id_ff17737c_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./Index.vue?vue&type=style&index=1&id=ff17737c&lang=scss&scoped=true& */ "./resources/js/components/ct/std_raw_material_cost/Index.vue?vue&type=style&index=1&id=ff17737c&lang=scss&scoped=true&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;



/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_4__.default)(
  _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Index_vue_vue_type_template_id_ff17737c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _Index_vue_vue_type_template_id_ff17737c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "ff17737c",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ct/std_raw_material_cost/Index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ct/std_raw_material_cost/Index.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************!*\
  !*** ./resources/js/components/ct/std_raw_material_cost/Index.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std_raw_material_cost/Index.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ct/std_raw_material_cost/Index.vue?vue&type=style&index=0&lang=scss&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/components/ct/std_raw_material_cost/Index.vue?vue&type=style&index=0&lang=scss& ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_style_index_0_lang_scss___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!../../../../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=style&index=0&lang=scss& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std_raw_material_cost/Index.vue?vue&type=style&index=0&lang=scss&");


/***/ }),

/***/ "./resources/js/components/ct/std_raw_material_cost/Index.vue?vue&type=style&index=1&id=ff17737c&lang=scss&scoped=true&":
/*!******************************************************************************************************************************!*\
  !*** ./resources/js/components/ct/std_raw_material_cost/Index.vue?vue&type=style&index=1&id=ff17737c&lang=scss&scoped=true& ***!
  \******************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_style_index_1_id_ff17737c_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!../../../../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=style&index=1&id=ff17737c&lang=scss&scoped=true& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std_raw_material_cost/Index.vue?vue&type=style&index=1&id=ff17737c&lang=scss&scoped=true&");


/***/ }),

/***/ "./resources/js/components/ct/std_raw_material_cost/Index.vue?vue&type=template&id=ff17737c&scoped=true&":
/*!***************************************************************************************************************!*\
  !*** ./resources/js/components/ct/std_raw_material_cost/Index.vue?vue&type=template&id=ff17737c&scoped=true& ***!
  \***************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_ff17737c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_ff17737c_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_ff17737c_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=template&id=ff17737c&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std_raw_material_cost/Index.vue?vue&type=template&id=ff17737c&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std_raw_material_cost/Index.vue?vue&type=template&id=ff17737c&scoped=true&":
/*!******************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/std_raw_material_cost/Index.vue?vue&type=template&id=ff17737c&scoped=true& ***!
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
      _c("div", { staticClass: "m-2 " }, [
        _c("div", { staticClass: "form-group row" }, [
          _c("h2", { staticClass: "text-bold ml-1" }, [
            _vm._v(
              "\n                " +
                _vm._s(
                  _vm.is_create
                    ? "สร้างรายการต้นทุนวัตถุดิบมาตรฐาน"
                    : "ค้นหาข้อมูลต้นทุนวัตถุดิบมาตรฐาน"
                ) +
                "\n            "
            )
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "form-group row" }, [
          _c("label", { staticClass: "col-md-2 col-form-label" }, [
            _vm._v("ปีบัญชี")
          ]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-4 flex-wrap" },
            [
              _c(
                "el-select",
                {
                  staticStyle: { width: "100%" },
                  attrs: { placeholder: "ปีบัญชีงบ" },
                  on: {
                    change: function($event) {
                      return _vm.selectFiscalYear()
                    }
                  },
                  model: {
                    value: _vm.form.period_year,
                    callback: function($$v) {
                      _vm.$set(_vm.form, "period_year", $$v)
                    },
                    expression: "form.period_year"
                  }
                },
                _vm._l(_vm.option.fiscal_year, function(item, index) {
                  return _c("el-option", {
                    key: index,
                    attrs: { label: item.label_year, value: item.period_year }
                  })
                }),
                1
              ),
              _vm._v(" "),
              _vm.form_error.fiscal_year
                ? _c("div", { staticClass: "error-message" }, [
                    _c("strong", { staticClass: "font-bold" }, [
                      _vm._v(_vm._s(_vm.form_error.fiscal_year.title))
                    ]),
                    _vm._v(" "),
                    _c("span", { staticClass: "block sm:inline" }, [
                      _vm._v(
                        "\n                        " +
                          _vm._s(_vm.form_error.fiscal_year.message) +
                          "\n                    "
                      )
                    ])
                  ])
                : _vm._e()
            ],
            1
          ),
          _vm._v(" "),
          _c("label", { staticClass: "col-md-2 col-form-label" }, [
            _vm._v("วันที่เริ่มใช้")
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-4 flex-wrap" }, [
            _c(
              "div",
              [
                _c("ct-std-datepicker-th", {
                  class:
                    "form-control " +
                    (_vm.form.approved_status == "อนุมัติ" ||
                    _vm.tableDataHeader.length <= 0
                      ? "input-disable"
                      : ""),
                  attrs: {
                    inputClass:
                      _vm.form.approved_status == "อนุมัติ" ||
                      _vm.tableDataHeader.length <= 0
                        ? "input-disable"
                        : "",
                    disableDate:
                      _vm.form.approved_status == "อนุมัติ" ||
                      _vm.tableDataHeader.length <= 0,
                    placeholder: "วันที่เริ่มใช้",
                    value: _vm.form.start_date_thai
                  },
                  on: { dateWasSelected: _vm.startDateSelected }
                })
              ],
              1
            ),
            _vm._v(" "),
            _vm.form_error.date_from
              ? _c("div", { staticClass: "error-message" }, [
                  _c("strong", { staticClass: "font-bold" }, [
                    _vm._v(_vm._s(_vm.form_error.date_from.title))
                  ]),
                  _vm._v(" "),
                  _c("span", { staticClass: "block sm:inline" }, [
                    _vm._v(
                      "\n                        " +
                        _vm._s(_vm.form_error.date_from.message) +
                        "\n                    "
                    )
                  ])
                ])
              : _vm._e()
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "form-group row" }, [
          _c("label", { staticClass: "col-md-2 col-form-label" }, [
            _vm._v("แผนการผลิตครั้งที่")
          ]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-4 flex-wrap" },
            [
              _vm.is_create
                ? _c("el-input", {
                    attrs: { placeholder: "แผนการผลิตครั้งที่", type: "text" },
                    model: {
                      value: _vm.form.plan_version,
                      callback: function($$v) {
                        _vm.$set(_vm.form, "plan_version", $$v)
                      },
                      expression: "form.plan_version"
                    }
                  })
                : _vm._e(),
              _vm._v(" "),
              !_vm.is_create
                ? _c(
                    "el-select",
                    {
                      staticStyle: { width: "100%" },
                      attrs: { placeholder: "แผนการผลิตครั้งที่" },
                      model: {
                        value: _vm.form.plan_version,
                        callback: function($$v) {
                          _vm.$set(_vm.form, "plan_version", $$v)
                        },
                        expression: "form.plan_version"
                      }
                    },
                    _vm._l(_vm.option.plan_version_no, function(item, index) {
                      return _c("el-option", {
                        key: index,
                        attrs: {
                          label: item.plan_version_no,
                          value: item.plan_version_no
                        }
                      })
                    }),
                    1
                  )
                : _vm._e(),
              _vm._v(" "),
              _vm.form_error.plan_version_no
                ? _c("div", { staticClass: "error-message" }, [
                    _c("strong", { staticClass: "font-bold" }, [
                      _vm._v(_vm._s(_vm.form_error.plan_version_no.title))
                    ]),
                    _vm._v(" "),
                    _c("span", { staticClass: "block sm:inline" }, [
                      _vm._v(
                        "\n                        " +
                          _vm._s(_vm.form_error.plan_version_no.message) +
                          "\n                    "
                      )
                    ])
                  ])
                : _vm._e()
            ],
            1
          ),
          _vm._v(" "),
          _c("label", { staticClass: "col-md-2 col-form-label" }, [
            _vm._v("วันที่สิ้นสุด")
          ]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-4 flex-wrap" },
            [
              _c("ct-std-datepicker-th", {
                class:
                  "form-control " +
                  (_vm.form.approved_status == "อนุมัติ" ||
                  _vm.tableDataHeader.length <= 0
                    ? "input-disable"
                    : ""),
                attrs: {
                  inputClass:
                    _vm.form.approved_status == "อนุมัติ" ||
                    _vm.tableDataHeader.length <= 0
                      ? "input-disable"
                      : "",
                  disableDate:
                    _vm.form.approved_status == "อนุมัติ" ||
                    _vm.tableDataHeader.length <= 0,
                  placeholder: "วันที่สิ้นสุด",
                  value: _vm.form.end_date_thai
                },
                on: { dateWasSelected: _vm.endDateSelected }
              }),
              _vm._v(" "),
              _vm.form_error.date_to
                ? _c("div", { staticClass: "error-message" }, [
                    _c("strong", { staticClass: "font-bold" }, [
                      _vm._v(_vm._s(_vm.form_error.date_to.title))
                    ]),
                    _vm._v(" "),
                    _c("span", { staticClass: "block sm:inline" }, [
                      _vm._v(
                        "\n                        " +
                          _vm._s(_vm.form_error.date_to.message) +
                          "\n                    "
                      )
                    ])
                  ])
                : _vm._e()
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "form-group row" }, [
          _c("label", { staticClass: "col-md-2 col-form-label" }, [
            _vm._v("ครั้งที่")
          ]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-4 flex-wrap" },
            [
              _vm.is_create
                ? _c("el-input", {
                    attrs: { placeholder: "ครั้งที่", type: "text" },
                    model: {
                      value: _vm.form.version,
                      callback: function($$v) {
                        _vm.$set(_vm.form, "version", $$v)
                      },
                      expression: "form.version"
                    }
                  })
                : _vm._e(),
              _vm._v(" "),
              !_vm.is_create
                ? _c(
                    "el-select",
                    {
                      staticStyle: { width: "100%" },
                      attrs: { placeholder: "ครั้งที่" },
                      model: {
                        value: _vm.form.version,
                        callback: function($$v) {
                          _vm.$set(_vm.form, "version", $$v)
                        },
                        expression: "form.version"
                      }
                    },
                    _vm._l(_vm.option.version, function(item, index) {
                      return _c("el-option", {
                        key: index,
                        attrs: {
                          label: item.version_no,
                          value: item.version_no
                        }
                      })
                    }),
                    1
                  )
                : _vm._e(),
              _vm._v(" "),
              _vm.form_error.version
                ? _c("div", { staticClass: "error-message" }, [
                    _c("strong", { staticClass: "font-bold" }, [
                      _vm._v(_vm._s(_vm.form_error.version.title))
                    ]),
                    _vm._v(" "),
                    _c("span", { staticClass: "block sm:inline" }, [
                      _vm._v(
                        "\n                        " +
                          _vm._s(_vm.form_error.version.message) +
                          "\n                    "
                      )
                    ])
                  ])
                : _vm._e()
            ],
            1
          ),
          _vm._v(" "),
          _c("label", { staticClass: "col-md-2 col-form-label" }, [
            _vm._v("สถานะ")
          ]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-4 flex-wrap" },
            [
              _c("el-input", {
                staticClass: "w-100",
                attrs: { placeholder: "สถานะ", disabled: "" },
                model: {
                  value: _vm.form.approved_status,
                  callback: function($$v) {
                    _vm.$set(_vm.form, "approved_status", $$v)
                  },
                  expression: "form.approved_status"
                }
              }),
              _vm._v(" "),
              _vm.form_error.status
                ? _c("div", { staticClass: "error-message" }, [
                    _c("strong", { staticClass: "font-bold" }, [
                      _vm._v(_vm._s(_vm.form_error.status.title))
                    ]),
                    _vm._v(" "),
                    _c("span", { staticClass: "block sm:inline" }, [
                      _vm._v(
                        "\n                        " +
                          _vm._s(_vm.form_error.status.message) +
                          "\n                    "
                      )
                    ])
                  ])
                : _vm._e()
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "form-group row" }, [
          _c("label", { staticClass: "col-md-2 col-form-label" }, [
            _vm._v("ศูนย์ต้นทุน")
          ]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-4 flex-wrap" },
            [
              _c(
                "el-select",
                {
                  staticStyle: { width: "100%" },
                  attrs: { placeholder: "ศูนย์ต้นทุน" },
                  on: {
                    change: function($event) {
                      return _vm.selectCostCenter()
                    }
                  },
                  model: {
                    value: _vm.form.cost_code,
                    callback: function($$v) {
                      _vm.$set(_vm.form, "cost_code", $$v)
                    },
                    expression: "form.cost_code"
                  }
                },
                _vm._l(_vm.option.cost_center, function(item, index) {
                  return _c("el-option", {
                    key: index,
                    attrs: {
                      label: item.cost_code + " - " + item.description,
                      value: item.cost_code
                    }
                  })
                }),
                1
              ),
              _vm._v(" "),
              _vm.form_error.code
                ? _c("div", { staticClass: "error-message" }, [
                    _c("strong", { staticClass: "font-bold" }, [
                      _vm._v(_vm._s(_vm.form_error.code.title))
                    ]),
                    _vm._v(" "),
                    _c("span", { staticClass: "block sm:inline" }, [
                      _vm._v(
                        "\n                        " +
                          _vm._s(_vm.form_error.code.message) +
                          "\n                    "
                      )
                    ])
                  ])
                : _vm._e()
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "form-group row" }, [
          _c("label", { staticClass: "col-md-2 col-form-label" }, [
            _vm._v("หน่วยนับต่อศูนย์ต้นทุน")
          ]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-4 flex-wrap" },
            [
              _c("el-input", {
                attrs: { placeholder: "หน่วยนับต่อศูนย์ต้นทุน", disabled: "" },
                model: {
                  value: _vm.unitPerCostCenter,
                  callback: function($$v) {
                    _vm.unitPerCostCenter = $$v
                  },
                  expression: "unitPerCostCenter"
                }
              }),
              _vm._v(" "),
              _vm.form_error.qty_per_cost_center
                ? _c("div", { staticClass: "error-message" }, [
                    _c("strong", { staticClass: "font-bold" }, [
                      _vm._v(_vm._s(_vm.form_error.qty_per_cost_center.title))
                    ]),
                    _vm._v(" "),
                    _c("span", { staticClass: "block sm:inline" }, [
                      _vm._v(
                        "\n                        " +
                          _vm._s(_vm.form_error.qty_per_cost_center.message) +
                          "\n                    "
                      )
                    ])
                  ])
                : _vm._e()
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row" }, [
          _c(
            "div",
            { staticClass: "col-md-12 text-right mt-2" },
            [
              !_vm.is_create
                ? _c(
                    "el-button",
                    {
                      staticClass: "btn-info mr-2 ",
                      attrs: { type: "primary", size: "small" },
                      on: {
                        click: function($event) {
                          return _vm.search()
                        }
                      }
                    },
                    [_vm._v("\n                    ค้นหา\n                ")]
                  )
                : _vm._e(),
              _vm._v(" "),
              _vm.status.tableDataLine
                ? _c(
                    "el-button",
                    {
                      staticClass: "btn-info mr-2",
                      attrs: { type: "primary", size: "small" },
                      on: { click: _vm.queryDataTableLine }
                    },
                    [_vm._v("\n                    EXPORT\n                ")]
                  )
                : _vm._e(),
              _vm._v(" "),
              _vm.status.tableData && !_vm.status.tableDataLine
                ? _c(
                    "el-button",
                    {
                      staticClass: "btn-info mr-2",
                      attrs: { type: "primary", size: "small" },
                      on: { click: _vm.queryTableDataHeader }
                    },
                    [_vm._v("\n                    EXPORT\n                ")]
                  )
                : _vm._e(),
              _vm._v(" "),
              _vm.is_create
                ? _c(
                    "el-button",
                    {
                      staticClass: "btn-primary mr-2",
                      attrs: {
                        disabled: _vm.disableStore,
                        type: "primary",
                        size: "small"
                      },
                      on: {
                        click: function($event) {
                          return _vm.store()
                        }
                      }
                    },
                    [
                      _vm._v(
                        "\n                    ดึงต้นทุนวัตถุดิบ\n                "
                      )
                    ]
                  )
                : _vm._e(),
              _vm._v(" "),
              _vm.status.tableData &&
              (_vm.old_data.start_date_thai != _vm.form.start_date_thai ||
                _vm.old_data.end_date_thai != _vm.form.end_date_thai)
                ? _c(
                    "el-button",
                    {
                      staticClass: "btn-info mr-2",
                      attrs: { type: "primary", size: "small" },
                      on: { click: _vm.updateDateThai }
                    },
                    [
                      _vm._v(
                        "\n                    อัพเดทวันที่เริ่มใช้ - วันที่สิ้นสุด\n                "
                      )
                    ]
                  )
                : _vm._e(),
              _vm._v(" "),
              _vm.status.tableData
                ? _c(
                    "el-button",
                    {
                      staticClass: "btn-success",
                      attrs: { type: "success", size: "small" },
                      on: { click: _vm.approveHeaderData }
                    },
                    [
                      _vm._v(
                        "\n                    ยืนยันต้นทุนวัตถุดิบ\n                "
                      )
                    ]
                  )
                : _vm._e()
            ],
            1
          )
        ])
      ]),
      _vm._v(" "),
      _vm.status.tableData
        ? _c("div", { staticClass: "form-group row" }, [
            _c("div", { staticClass: "col-md-12 mt-2 flex-wrap" }, [
              _c(
                "div",
                {
                  directives: [
                    {
                      name: "show",
                      rawName: "v-show",
                      value: !_vm.status.tableDataLine,
                      expression: "!status.tableDataLine"
                    }
                  ]
                },
                [
                  _c(
                    "div",
                    { staticClass: "col-lg-12 mt-2" },
                    [
                      _vm._m(0),
                      _vm._v(" "),
                      _c(
                        "el-table",
                        {
                          ref: "multipleTableN",
                          staticStyle: { width: "100%", "font-size": "13px" },
                          attrs: { border: "", data: _vm.tableDataHeaderN },
                          on: { "selection-change": _vm.handleSelectionChangeN }
                        },
                        [
                          _c(
                            "el-table-column",
                            {
                              attrs: {
                                label: "ตรวจสอบทั้งหมด",
                                "header-align": "center"
                              }
                            },
                            [
                              _c("el-table-column", {
                                attrs: {
                                  type: "selection",
                                  width: "160",
                                  align: "center"
                                }
                              })
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c("el-table-column", {
                            attrs: {
                              label: "กลุ่มผลิตภัณฑ์",
                              "header-align": "center",
                              width: "180"
                            },
                            scopedSlots: _vm._u(
                              [
                                {
                                  key: "default",
                                  fn: function(scope) {
                                    return [
                                      _vm._v(
                                        "\n                                " +
                                          _vm._s(scope.row.product_group) +
                                          "\n                                " +
                                          _vm._s(scope.row.product_group_name) +
                                          "\n                            "
                                      )
                                    ]
                                  }
                                }
                              ],
                              null,
                              false,
                              1256899546
                            )
                          }),
                          _vm._v(" "),
                          _c("el-table-column", {
                            attrs: {
                              prop: "product_item_number",
                              label: "ผลิตภัณฑ์",
                              "header-align": "center",
                              width: "130"
                            }
                          }),
                          _vm._v(" "),
                          _c("el-table-column", {
                            attrs: {
                              prop: "product_item_desc",
                              label: "ชื่อผลิตภัณฑ์",
                              "header-align": "center"
                            }
                          }),
                          _vm._v(" "),
                          _c("el-table-column", {
                            attrs: {
                              prop: "cost_raw_mate",
                              label: "ต้นทุนวัตถุดิบรวม (บาท)",
                              align: "right",
                              width: "160"
                            },
                            scopedSlots: _vm._u(
                              [
                                {
                                  key: "default",
                                  fn: function(scope) {
                                    return [
                                      _vm._v(
                                        "\n                                " +
                                          _vm._s(
                                            scope.row.cost_raw_mate != 0
                                              ? _vm.numberWithCommas(
                                                  parseFloat(
                                                    scope.row.cost_raw_mate
                                                  ).toFixed(9)
                                                )
                                              : scope.row.cost_raw_mate
                                          ) +
                                          "\n                            "
                                      )
                                    ]
                                  }
                                }
                              ],
                              null,
                              false,
                              1485172487
                            )
                          }),
                          _vm._v(" "),
                          _c("el-table-column", {
                            attrs: {
                              prop: "unit_cost_raw_mate",
                              label: "ต้นทุนวัตถุดิบต่อ 1 หน่วย",
                              align: "right",
                              width: "180"
                            },
                            scopedSlots: _vm._u(
                              [
                                {
                                  key: "default",
                                  fn: function(scope) {
                                    return [
                                      _vm._v(
                                        "\n                                " +
                                          _vm._s(
                                            scope.row.unit_cost_raw_mate != 0
                                              ? _vm.numberWithCommas(
                                                  parseFloat(
                                                    scope.row.unit_cost_raw_mate
                                                  ).toFixed(9)
                                                )
                                              : scope.row.unit_cost_raw_mate
                                          ) +
                                          "\n                            "
                                      )
                                    ]
                                  }
                                }
                              ],
                              null,
                              false,
                              1522186356
                            )
                          }),
                          _vm._v(" "),
                          _c("el-table-column", {
                            attrs: {
                              prop: "recipe_status",
                              label: "สถานะสูตรมาตราฐาน",
                              align: "center",
                              "header-align": "center"
                            }
                          }),
                          _vm._v(" "),
                          _c("el-table-column", {
                            attrs: {
                              label: "รายละเอียดวัตถุดิบ",
                              align: "center",
                              width: "140"
                            },
                            scopedSlots: _vm._u(
                              [
                                {
                                  key: "default",
                                  fn: function(scope) {
                                    return [
                                      _c(
                                        "el-button",
                                        {
                                          staticClass: "btn btn-info",
                                          attrs: {
                                            type: "success",
                                            size: "small"
                                          },
                                          on: {
                                            click: function($event) {
                                              return _vm.getTableDataLine(
                                                scope.row
                                              )
                                            }
                                          }
                                        },
                                        [
                                          _vm._v(
                                            "\n                                    รายละเอียด\n                                "
                                          )
                                        ]
                                      )
                                    ]
                                  }
                                }
                              ],
                              null,
                              false,
                              3333377470
                            )
                          }),
                          _vm._v(" "),
                          _c("el-table-column", {
                            attrs: {
                              label: "อนุมัติต้นทุนวัตถุดิบ",
                              align: "center",
                              width: "140"
                            },
                            scopedSlots: _vm._u(
                              [
                                {
                                  key: "default",
                                  fn: function(scope) {
                                    return [
                                      _c(
                                        "el-button",
                                        {
                                          staticClass: "btn btn-success",
                                          attrs: {
                                            type: "success",
                                            size: "small"
                                          },
                                          on: {
                                            click: function($event) {
                                              return _vm.approveLineData(
                                                scope.row
                                              )
                                            }
                                          }
                                        },
                                        [
                                          _vm._v(
                                            "\n                                อนุมัติต้นทุนวัตถุดิบ\n                                "
                                          )
                                        ]
                                      )
                                    ]
                                  }
                                }
                              ],
                              null,
                              false,
                              2818673381
                            )
                          })
                        ],
                        1
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-lg-12 mt-2" },
                    [
                      _vm._m(1),
                      _vm._v(" "),
                      _c(
                        "el-table",
                        {
                          ref: "multipleTableY",
                          staticStyle: { width: "100%", "font-size": "13px" },
                          attrs: { border: "", data: _vm.tableDataHeaderY },
                          on: { "selection-change": _vm.handleSelectionChangeY }
                        },
                        [
                          _c(
                            "el-table-column",
                            {
                              attrs: {
                                label: "ตรวจสอบทั้งหมด",
                                "header-align": "center"
                              }
                            },
                            [
                              _c("el-table-column", {
                                attrs: {
                                  type: "selection",
                                  width: "160",
                                  align: "center"
                                }
                              })
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c("el-table-column", {
                            attrs: {
                              label: "กลุ่มผลิตภัณฑ์",
                              "header-align": "center",
                              width: "180"
                            },
                            scopedSlots: _vm._u(
                              [
                                {
                                  key: "default",
                                  fn: function(scope) {
                                    return [
                                      _vm._v(
                                        "\n                                " +
                                          _vm._s(scope.row.product_group) +
                                          "\n                                " +
                                          _vm._s(scope.row.product_group_name) +
                                          "\n                            "
                                      )
                                    ]
                                  }
                                }
                              ],
                              null,
                              false,
                              1256899546
                            )
                          }),
                          _vm._v(" "),
                          _c("el-table-column", {
                            attrs: {
                              prop: "product_item_number",
                              label: "ผลิตภัณฑ์",
                              "header-align": "center",
                              width: "130"
                            }
                          }),
                          _vm._v(" "),
                          _c("el-table-column", {
                            attrs: {
                              prop: "product_item_desc",
                              label: "ชื่อผลิตภัณฑ์",
                              "header-align": "center"
                            }
                          }),
                          _vm._v(" "),
                          _c("el-table-column", {
                            attrs: {
                              prop: "cost_raw_mate",
                              label: "ต้นทุนวัตถุดิบรวม (บาท)",
                              align: "right",
                              width: "160"
                            },
                            scopedSlots: _vm._u(
                              [
                                {
                                  key: "default",
                                  fn: function(scope) {
                                    return [
                                      _vm._v(
                                        "\n                                " +
                                          _vm._s(
                                            scope.row.cost_raw_mate != 0
                                              ? _vm.numberWithCommas(
                                                  parseFloat(
                                                    scope.row.cost_raw_mate
                                                  ).toFixed(9)
                                                )
                                              : scope.row.cost_raw_mate
                                          ) +
                                          "\n                            "
                                      )
                                    ]
                                  }
                                }
                              ],
                              null,
                              false,
                              1485172487
                            )
                          }),
                          _vm._v(" "),
                          _c("el-table-column", {
                            attrs: {
                              prop: "unit_cost_raw_mate",
                              label: "ต้นทุนวัตถุดิบต่อ 1 หน่วย",
                              align: "right",
                              width: "180"
                            },
                            scopedSlots: _vm._u(
                              [
                                {
                                  key: "default",
                                  fn: function(scope) {
                                    return [
                                      _vm._v(
                                        "\n                                " +
                                          _vm._s(
                                            scope.row.unit_cost_raw_mate != 0
                                              ? _vm.numberWithCommas(
                                                  parseFloat(
                                                    scope.row.unit_cost_raw_mate
                                                  ).toFixed(9)
                                                )
                                              : scope.row.unit_cost_raw_mate
                                          ) +
                                          "\n                            "
                                      )
                                    ]
                                  }
                                }
                              ],
                              null,
                              false,
                              1522186356
                            )
                          }),
                          _vm._v(" "),
                          _c("el-table-column", {
                            attrs: {
                              prop: "recipe_status",
                              label: "สถานะสูตรมาตราฐาน",
                              align: "center",
                              "header-align": "center",
                              width: "160"
                            }
                          }),
                          _vm._v(" "),
                          _c("el-table-column", {
                            attrs: {
                              label: "รายละเอียดวัตถุดิบ",
                              align: "center",
                              width: "140"
                            },
                            scopedSlots: _vm._u(
                              [
                                {
                                  key: "default",
                                  fn: function(scope) {
                                    return [
                                      _c(
                                        "el-button",
                                        {
                                          staticClass: "btn btn-info",
                                          attrs: {
                                            type: "success",
                                            size: "small"
                                          },
                                          on: {
                                            click: function($event) {
                                              return _vm.getTableDataLine(
                                                scope.row
                                              )
                                            }
                                          }
                                        },
                                        [
                                          _vm._v(
                                            "\n                                    รายละเอียด\n                                "
                                          )
                                        ]
                                      )
                                    ]
                                  }
                                }
                              ],
                              null,
                              false,
                              3333377470
                            )
                          }),
                          _vm._v(" "),
                          _c("el-table-column", {
                            attrs: {
                              label: "อนุมัติต้นทุนวัตถุดิบ",
                              align: "center",
                              width: "140"
                            },
                            scopedSlots: _vm._u(
                              [
                                {
                                  key: "default",
                                  fn: function(scope) {
                                    return [
                                      _vm._v(
                                        "\n                                อนุมัติต้นทุนวัตถุดิบ\n                            "
                                      )
                                    ]
                                  }
                                }
                              ],
                              null,
                              false,
                              2521593065
                            )
                          })
                        ],
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
                  directives: [
                    {
                      name: "show",
                      rawName: "v-show",
                      value: _vm.status.tableDataLine,
                      expression: "status.tableDataLine"
                    }
                  ]
                },
                [
                  _c("div", { staticClass: "my-2" }, [
                    _c("div", [
                      _c("span", { staticClass: "font-bold" }, [
                        _vm._v("กลุ่มผลิตภัณฑ์ :")
                      ]),
                      _vm._v(
                        "\n                        " +
                          _vm._s(_vm.headLine.productGroup) +
                          "\n                    "
                      )
                    ]),
                    _vm._v(" "),
                    _c("div", [
                      _c("span", { staticClass: "font-bold" }, [
                        _vm._v("ผลิตภัณฑ์ :")
                      ]),
                      _vm._v(
                        "\n                        " +
                          _vm._s(_vm.headLine.productGroupDetail) +
                          "\n                    "
                      )
                    ])
                  ]),
                  _vm._v(" "),
                  _c(
                    "el-table",
                    {
                      staticStyle: { width: "100%" },
                      attrs: {
                        border: "",
                        data: _vm.tableDataLine,
                        "summary-method": _vm.getSummaries,
                        "show-summary": ""
                      }
                    },
                    [
                      _c("el-table-column", {
                        attrs: {
                          prop: "item_number",
                          label: "รหัสวัตถุดิบ",
                          align: "center"
                        }
                      }),
                      _vm._v(" "),
                      _c("el-table-column", {
                        attrs: {
                          prop: "item_desc",
                          label: "ชื่อวัตถุดิบ",
                          align: "left",
                          "header-align": "center"
                        }
                      }),
                      _vm._v(" "),
                      _c("el-table-column", {
                        attrs: {
                          prop: "wip_step",
                          label: "ขั้นตอน",
                          align: "center"
                        }
                      }),
                      _vm._v(" "),
                      _c("el-table-column", {
                        attrs: {
                          prop: "quantity_used",
                          label: "จำนวนที่ใช้",
                          align: "center"
                        },
                        scopedSlots: _vm._u(
                          [
                            {
                              key: "default",
                              fn: function(scope) {
                                return [
                                  _vm._v(
                                    "\n                            " +
                                      _vm._s(
                                        scope.row.quantity_used != 0
                                          ? _vm.numberWithCommas(
                                              parseFloat(
                                                scope.row.quantity_used
                                              ).toFixed(9)
                                            )
                                          : scope.row.quantity_used
                                      ) +
                                      "\n                        "
                                  )
                                ]
                              }
                            }
                          ],
                          null,
                          false,
                          3637904950
                        )
                      }),
                      _vm._v(" "),
                      _c("el-table-column", {
                        attrs: {
                          prop: "uom_code",
                          label: "หน่วย",
                          align: "center"
                        }
                      }),
                      _vm._v(" "),
                      _c("el-table-column", {
                        attrs: {
                          prop: "last_cost",
                          label: "ราคาซื้อครั้งสุดท้าย",
                          align: "center"
                        },
                        scopedSlots: _vm._u(
                          [
                            {
                              key: "default",
                              fn: function(scope) {
                                return [
                                  _vm._v(
                                    "\n                            " +
                                      _vm._s(
                                        scope.row.last_cost != 0
                                          ? _vm.numberWithCommas(
                                              parseFloat(
                                                scope.row.last_cost
                                              ).toFixed(9)
                                            )
                                          : scope.row.last_cost
                                      ) +
                                      "\n                        "
                                  )
                                ]
                              }
                            }
                          ],
                          null,
                          false,
                          2920870955
                        )
                      }),
                      _vm._v(" "),
                      _c("el-table-column", {
                        attrs: {
                          prop: "unit_std_cost",
                          label: "ราคามาตรฐานต่อหน่วย",
                          align: "center"
                        },
                        scopedSlots: _vm._u(
                          [
                            {
                              key: "default",
                              fn: function(scope) {
                                return [
                                  _vm._v(
                                    "\n                            " +
                                      _vm._s(
                                        scope.row.unit_std_cost != 0
                                          ? _vm.numberWithCommas(
                                              parseFloat(
                                                scope.row.unit_std_cost
                                              ).toFixed(9)
                                            )
                                          : scope.row.unit_std_cost
                                      ) +
                                      "\n                        "
                                  )
                                ]
                              }
                            }
                          ],
                          null,
                          false,
                          3710508251
                        )
                      }),
                      _vm._v(" "),
                      _c("el-table-column", {
                        attrs: {
                          prop: "cost_raw_mate",
                          label: "ต้นทุนวัตถุดิบรวม",
                          align: "center"
                        },
                        scopedSlots: _vm._u(
                          [
                            {
                              key: "default",
                              fn: function(scope) {
                                return [
                                  _vm._v(
                                    "\n                            " +
                                      _vm._s(
                                        scope.row.cost_raw_mate != 0
                                          ? _vm.numberWithCommas(
                                              parseFloat(
                                                scope.row.cost_raw_mate
                                              ).toFixed(9)
                                            )
                                          : scope.row.cost_raw_mate
                                      ) +
                                      "\n                        "
                                  )
                                ]
                              }
                            }
                          ],
                          null,
                          false,
                          1892111367
                        )
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-12 text-right mt-4 px-0" },
                    [
                      _c(
                        "el-button",
                        {
                          staticClass: "btn-danger",
                          attrs: { type: "danger" },
                          nativeOn: {
                            click: function($event) {
                              $event.preventDefault()
                              return _vm.closeTableLine()
                            }
                          }
                        },
                        [
                          _vm._v(
                            "\n                        ปิด\n                    "
                          )
                        ]
                      )
                    ],
                    1
                  )
                ],
                1
              )
            ])
          ])
        : _vm._e()
    ]
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      {
        staticStyle: {
          "background-color": "#d9d9d9",
          color: "black",
          "font-weight": "bold",
          padding: "10px",
          margin: "auto"
        }
      },
      [
        _c("h4", [
          _vm._v(
            "\n                            ผลิตภัณฑ์ที่ยังไม่อนุมัติต้นทุนวัตถุดิบ\n                        "
          )
        ])
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      {
        staticClass: "mt-5",
        staticStyle: {
          "background-color": "#d9d9d9",
          color: "black",
          "font-weight": "bold",
          padding: "10px",
          margin: "auto"
        }
      },
      [
        _c("h4", [
          _vm._v(
            "\n                            ผลิตภัณฑ์ที่อนุมัติต้นทุนวัตถุดิบแล้ว\n                        "
          )
        ])
      ]
    )
  }
]
render._withStripped = true



/***/ })

}]);