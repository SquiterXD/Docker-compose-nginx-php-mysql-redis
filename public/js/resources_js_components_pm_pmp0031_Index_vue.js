(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pm_pmp0031_Index_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/pmp0031/Index.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/pmp0031/Index.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var _Table__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Table */ "./resources/js/components/pm/pmp0031/Table.vue");
/* harmony import */ var _TableMp2__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./TableMp2 */ "./resources/js/components/pm/pmp0031/TableMp2.vue");


function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
    TableRow: _Table__WEBPACK_IMPORTED_MODULE_2__.default,
    TableRowMP2: _TableMp2__WEBPACK_IMPORTED_MODULE_3__.default
  },
  props: ["user-profile", "trans-date", "url", "trans-btn", "sys-date", "program-code", "token"],
  data: function data() {
    return {
      sysDateTh: moment__WEBPACK_IMPORTED_MODULE_1___default()(this.sysDate).add(543, "years").format(this.transDate["js-format"]),
      yearTh: moment__WEBPACK_IMPORTED_MODULE_1___default()(this.sysDate).add(543, "years").format(this.transDate["js-year-format"]),
      year: moment__WEBPACK_IMPORTED_MODULE_1___default()(this.sysDate).format(this.transDate["js-year-format"]),
      month: moment__WEBPACK_IMPORTED_MODULE_1___default()(this.sysDate).format("MM"),
      monthTh: moment__WEBPACK_IMPORTED_MODULE_1___default()(this.sysDate).format("MMMM"),
      monthThDes: moment__WEBPACK_IMPORTED_MODULE_1___default()(this.sysDate).format("MMMM"),
      dateFirsTofMonth: moment__WEBPACK_IMPORTED_MODULE_1___default()(this.sysDate).add(543, "years").format("01/MM/YYYY"),
      create_date: "",
      fortnightly: "",
      time: "",
      version: "",
      start_date: "",
      end_date: "",
      saleForecasts: "",
      saleForecast: "",
      biweekly: "",
      biweeklies: [],
      form_header: {
        program_code: this.programCode,
        version: "",
        period: "",
        source_version: "",
        attribute1: "",
        attribute2: "",
        year: "",
        lines: [],
        pMonth: "",
        pYear: ""
      },
      loading: {
        form: false,
        month: false,
        biweekly: false,
        dateFormTo: false,
        table: false
      },
      disable: {
        form: false,
        month: true,
        biweekly: true,
        dateFormTo: false
      },
      productPlanLines: [],
      urlTest: 'http://web-service-report.test/ir/ajax/ir-report-get-info-attribute?program_code=IRR0001'
    };
  },
  mounted: function mounted() {
    this.getSaleForecast();
  },
  methods: {
    getSaleForecast: function getSaleForecast() {
      var _this = this;

      // this.loading.month = true;
      this.loading.biweekly = true;
      console.log("xxx");
      axios.get(this.url.getSaleForecast + "?year=" + this.year + "&month=" + this.month).then(function (res) {
        var saleForecasts = res.data.salesForecasts;
        _this.saleForecasts = saleForecasts;
        _this.version = _this.saleForecasts[0].version; // this.loading.month = false;

        _this.loading.biweekly = false;
        _this.disable.month = false;
        _this.disable.biweekly = false;
      })["catch"](function (err) {
        // this.loading.month = false;
        _this.loading.biweekly = false;
        _this.disable.month = false;
        _this.disable.biweekly = false;
      });
    },
    // process() {
    // },
    getYear: function getYear(value) {
      this.yearTh = value;
      this.year = moment__WEBPACK_IMPORTED_MODULE_1___default()(this.yearTh).add(-543, "years").format(this.transDate["js-year-format"]);
    },
    getMonth: function getMonth(value) {
      this.productPlanLines = [];
      this.monthTh = value;
      this.month = moment__WEBPACK_IMPORTED_MODULE_1___default()(this.monthTh).add(-543, "years").format("MM");
      this.monthThDes = moment__WEBPACK_IMPORTED_MODULE_1___default()(this.month).add(-543, "years").format("MMMM");
      this.form_header.pMonth = moment__WEBPACK_IMPORTED_MODULE_1___default()(this.monthTh).add(-543, "years").format("MMM");
      this.getSaleForecast();
      this.dateFirsTofMonth = moment__WEBPACK_IMPORTED_MODULE_1___default()(this.monthTh).add(543, "years").format("01/MM/YYYY");
    },
    createDate: function createDate(value) {
      this.create_date = moment__WEBPACK_IMPORTED_MODULE_1___default()(value).add(-543, "years").format(this.transDate["js-datatime-format"]);
    },
    startDate: function startDate(value) {
      this.start_date = moment__WEBPACK_IMPORTED_MODULE_1___default()(value).add(-543, "years").format(this.transDate["js-datatime-format"]);
    },
    endDate: function endDate(value) {
      this.end_date = moment__WEBPACK_IMPORTED_MODULE_1___default()(value).add(-543, "years").format(this.transDate["js-datatime-format"]);
    },
    findBiweekly: function findBiweekly() {
      var _this2 = this;

      var saleForecast = this.saleForecasts[this.fortnightly].find(function (item) {
        return item.biweekly_no == _this2.fortnightly;
      });
      this.saleForecast = saleForecast;
      this.version = saleForecast.version;
      this.getBiweeklies();
    },
    getBiweeklies: function getBiweeklies() {
      var _this3 = this;

      axios.get(this.url.getBiweeklies + "?year=" + this.year + "&month=" + this.month + "&biweekly_no=" + this.version + "&biweekly_id=" + this.saleForecast.biweekly_id).then(function (res) {
        var biweekly = res.data.biweekly;
        _this3.biweekly = biweekly;
        _this3.start_date = moment__WEBPACK_IMPORTED_MODULE_1___default()(biweekly.start_date).add(543, "years").format(_this3.transDate["js-format"]);
        biweekly.start_date;
        _this3.end_date = moment__WEBPACK_IMPORTED_MODULE_1___default()(biweekly.end_date).add(543, "years").format(_this3.transDate["js-format"]);
      });
    },
    updateFormHeader: function updateFormHeader() {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this4.form_header.program_code = _this4.programCode;
                _this4.form_header.version = _this4.version;
                _this4.form_header.biweekly = _this4.fortnightly;
                _this4.form_header.period = _this4.biweekly.period_name;
                _this4.form_header.source_version = _this4.biweekly.biweekly;
                _this4.form_header.attribute1 = _this4.biweekly.start_date;
                _this4.form_header.attribute2 = _this4.biweekly.end_date;
                _this4.form_header.year = _this4.year;
                _this4.form_header.month = _this4.month;

              case 9:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    process: function process() {
      var _this5 = this;

      this.loading.table = true;
      this.productPlanLines = [];
      this.form_header.lines = [];
      this.updateFormHeader();
      axios.post(this.url.process, _objectSpread({}, this.form_header)).then(function (res) {
        _this5.productPlanLines = res.data.productPlanLines;
        _this5.loading.table = false;
        _this5.form_header.lines = _this5.productPlanLines;
      })["catch"](function (err) {
        _this5.loading.table = false;
      });
    },
    openJob: function openJob() {
      var _this6 = this;

      var canOpen = false;
      var unChecks = this.form_header.lines.filter(function (item) {
        return item.attribute15 == null;
      });

      if (unChecks.length == this.form_header.lines.length) {
        return swal({
          title: "Error !",
          text: 'กรุณาเลือกรายการที่ต้องการเปิดคำสั่งการผลิต',
          type: "error",
          showConfirmButton: true
        });
      } // this.form_header.lines.some(item=>{
      //     return item.attribute15 =
      // })


      this.form_header.lines.forEach(function (item) {
        if (item.request_number == null) {
          canOpen = true;
        }
      });

      if (canOpen == false) {
        return swal({
          title: "Error !",
          text: 'ไม่สามารถเปิดคำสั่งผลิตได้',
          type: "error",
          showConfirmButton: true
        });
      }

      this.updateFormHeader();
      this.loading.table = true; // this.form_header.lines = [];

      this.productPlanLines = [];
      axios.post(this.url.openJob, _objectSpread({}, this.form_header)).then(function (res) {
        _this6.productPlanLines = [];
        var result = res.data.result;

        if (result.status === "S") {
          swal({
            title: "Success !",
            text: result.msg,
            type: "success",
            showConfirmButton: true
          });
        } else {
          swal({
            title: "Error !",
            text: result.msg,
            type: "error",
            showConfirmButton: true
          });
          console.log(result.msg);
        }

        _this6.productPlanLines = res.data.productPlanLines;
        _this6.form_header.lines = res.data.productPlanLines;
        _this6.loading.table = false;
      })["catch"](function (err) {
        _this6.loading.table = false;
        console.log(err);
        console.log('log error');
        swal({
          title: "Error !",
          text: 'Error',
          type: "error",
          showConfirmButton: true
        }); // this.productPlanLines = err.data.productPlanLines;
        // this.form_header.lines  = err.data.productPlanLines;
      });
    },
    onClickChild: function onClickChild(value) {
      this.form_header.lines = value;
      console.log(value);
    }
  },
  computed: {
    disableOpenJob: function disableOpenJob() {
      if (this.productPlanLines.length == 0) {
        return true;
      } // this.productPlanLines.forEach(item => {
      //     if(item.request_number != ""){
      //         return true;
      //     }else{
      //         return false;
      //     }
      // });

    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/pmp0031/Table.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/pmp0031/Table.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["product-plan-lines"],
  data: function data() {
    return {
      form_lines: [],
      lines: this.productPlanLines,
      checked: false
    };
  },
  mounted: function mounted() {
    this.setData();
  },
  methods: {
    // updateFormLines(key, value) {
    //     console.log(key, value);
    // },
    setData: function setData() {
      this.lines.forEach(function (line) {
        if (line.uom !== 'PTN' & line.uom2 !== 'PTN') {
          line.period_name_request = line.period_name_request * 120;
        }

        line.uom2 = 'PTN';
        line.input = line.period_name_request;
      });
    },
    onClickButton: function onClickButton(event) {
      this.$emit("input", this.lines);
    }
  },
  computed: {// orderByFormulas() {
    //     return _.orderBy(this.formulas, "leaf_formula");
    // },
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/pmp0031/TableMp2.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/pmp0031/TableMp2.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["product-plan-lines"],
  data: function data() {
    return {
      form_lines: [],
      lines: this.productPlanLines,
      checked: false
    };
  },
  mounted: function mounted() {
    this.setData();
  },
  methods: {
    // updateFormLines(key, value) {
    //     console.log(key, value);
    // },
    setData: function setData() {
      this.lines.forEach(function (line) {
        if (line.uom !== 'PTN') {
          line.period_name_request = line.product_qty * 120;
        }

        if (line.uom2 !== 'KG') {
          line.input = line.period_name_request * 0.02;
        }

        line.uom2 = 'KG';
      });
    },
    onClickButton: function onClickButton(event) {
      this.$emit("input", this.lines);
    }
  },
  computed: {// orderByFormulas() {
    //     return _.orderBy(this.formulas, "leaf_formula");
    // },
  }
});

/***/ }),

/***/ "./resources/js/components/pm/pmp0031/Index.vue":
/*!******************************************************!*\
  !*** ./resources/js/components/pm/pmp0031/Index.vue ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_14f9e2cd___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=14f9e2cd& */ "./resources/js/components/pm/pmp0031/Index.vue?vue&type=template&id=14f9e2cd&");
/* harmony import */ var _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/pmp0031/Index.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Index_vue_vue_type_template_id_14f9e2cd___WEBPACK_IMPORTED_MODULE_0__.render,
  _Index_vue_vue_type_template_id_14f9e2cd___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/pmp0031/Index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/pmp0031/Table.vue":
/*!******************************************************!*\
  !*** ./resources/js/components/pm/pmp0031/Table.vue ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Table_vue_vue_type_template_id_62d5d06e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Table.vue?vue&type=template&id=62d5d06e& */ "./resources/js/components/pm/pmp0031/Table.vue?vue&type=template&id=62d5d06e&");
/* harmony import */ var _Table_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Table.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/pmp0031/Table.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _Table_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Table_vue_vue_type_template_id_62d5d06e___WEBPACK_IMPORTED_MODULE_0__.render,
  _Table_vue_vue_type_template_id_62d5d06e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/pmp0031/Table.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/pmp0031/TableMp2.vue":
/*!*********************************************************!*\
  !*** ./resources/js/components/pm/pmp0031/TableMp2.vue ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TableMp2_vue_vue_type_template_id_dc10b9d4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TableMp2.vue?vue&type=template&id=dc10b9d4& */ "./resources/js/components/pm/pmp0031/TableMp2.vue?vue&type=template&id=dc10b9d4&");
/* harmony import */ var _TableMp2_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TableMp2.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/pmp0031/TableMp2.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TableMp2_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TableMp2_vue_vue_type_template_id_dc10b9d4___WEBPACK_IMPORTED_MODULE_0__.render,
  _TableMp2_vue_vue_type_template_id_dc10b9d4___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/pmp0031/TableMp2.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/pmp0031/Index.vue?vue&type=script&lang=js&":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/pm/pmp0031/Index.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/pmp0031/Index.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/pmp0031/Table.vue?vue&type=script&lang=js&":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/pm/pmp0031/Table.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Table_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Table.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/pmp0031/Table.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Table_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/pmp0031/TableMp2.vue?vue&type=script&lang=js&":
/*!**********************************************************************************!*\
  !*** ./resources/js/components/pm/pmp0031/TableMp2.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableMp2_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableMp2.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/pmp0031/TableMp2.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableMp2_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/pmp0031/Index.vue?vue&type=template&id=14f9e2cd&":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/pm/pmp0031/Index.vue?vue&type=template&id=14f9e2cd& ***!
  \*************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_14f9e2cd___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_14f9e2cd___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Index_vue_vue_type_template_id_14f9e2cd___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Index.vue?vue&type=template&id=14f9e2cd& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/pmp0031/Index.vue?vue&type=template&id=14f9e2cd&");


/***/ }),

/***/ "./resources/js/components/pm/pmp0031/Table.vue?vue&type=template&id=62d5d06e&":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/pm/pmp0031/Table.vue?vue&type=template&id=62d5d06e& ***!
  \*************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Table_vue_vue_type_template_id_62d5d06e___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Table_vue_vue_type_template_id_62d5d06e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Table_vue_vue_type_template_id_62d5d06e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Table.vue?vue&type=template&id=62d5d06e& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/pmp0031/Table.vue?vue&type=template&id=62d5d06e&");


/***/ }),

/***/ "./resources/js/components/pm/pmp0031/TableMp2.vue?vue&type=template&id=dc10b9d4&":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/pm/pmp0031/TableMp2.vue?vue&type=template&id=dc10b9d4& ***!
  \****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableMp2_vue_vue_type_template_id_dc10b9d4___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableMp2_vue_vue_type_template_id_dc10b9d4___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableMp2_vue_vue_type_template_id_dc10b9d4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableMp2.vue?vue&type=template&id=dc10b9d4& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/pmp0031/TableMp2.vue?vue&type=template&id=dc10b9d4&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/pmp0031/Index.vue?vue&type=template&id=14f9e2cd&":
/*!****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/pmp0031/Index.vue?vue&type=template&id=14f9e2cd& ***!
  \****************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "row" }, [
    _c(
      "div",
      {
        directives: [
          {
            name: "loading",
            rawName: "v-loading",
            value: _vm.loading.form,
            expression: "loading.form"
          }
        ],
        staticClass: "col-lg-12"
      },
      [
        _c("div", { staticClass: "ibox float-e-margins" }, [
          _c(
            "div",
            { staticClass: "ibox-content" },
            [
              _c("div", { staticClass: "text-right" }, [
                _c(
                  "button",
                  {
                    class: _vm.transBtn.createJob.class,
                    on: {
                      click: function($event) {
                        $event.preventDefault()
                        return _vm.process($event)
                      }
                    }
                  },
                  [_c("strong", [_vm._v(" คำนวณปริมาณการผลิต ")])]
                ),
                _vm._v(" "),
                _c(
                  "button",
                  {
                    class: _vm.transBtn.createJob.class,
                    attrs: { disabled: _vm.disableOpenJob },
                    on: {
                      click: function($event) {
                        $event.preventDefault()
                        return _vm.openJob($event)
                      }
                    }
                  },
                  [
                    _c("i", { class: _vm.transBtn.createJob.icon }),
                    _vm._v(
                      "\n                        " +
                        _vm._s(_vm.transBtn.createJob.text) +
                        "\n                    "
                    )
                  ]
                )
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "form-group" }, [
                _c("div", { staticClass: "row m-2" }, [
                  _c("div", { staticClass: "col-lg-2" }, [
                    _vm._v("ปีงบประมาณ")
                  ]),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-lg-2" },
                    [
                      _c("datepicker-th", {
                        staticClass: "form-control md:tw-mb-0 tw-mb-2",
                        staticStyle: { width: "100%", "border-radius": "3px" },
                        attrs: {
                          placeholder: "เลือกวันที่ขอเบิก",
                          name: "input_date",
                          id: "input_date",
                          pType: "year",
                          format: _vm.transDate["js-year-format"]
                        },
                        on: { dateWasSelected: _vm.getYear },
                        model: {
                          value: _vm.yearTh,
                          callback: function($$v) {
                            _vm.yearTh = $$v
                          },
                          expression: "yearTh"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-lg-2" }, [_vm._v("หน่วยงาน")]),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-lg-2" },
                    [
                      _c("el-input", {
                        staticClass: "w-100",
                        attrs: {
                          placeholder: "0000000",
                          size: "small",
                          value: _vm.userProfile.department.description,
                          readonly: ""
                        }
                      })
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "row m-2" }, [
                  _c("div", { staticClass: "col-lg-2" }, [
                    _vm._v(
                      "\n                            ประมาณการขายยาเส้นประจำเดือน\n                        "
                    )
                  ]),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-lg-2" },
                    [
                      _c("datepicker-th", {
                        directives: [
                          {
                            name: "loading",
                            rawName: "v-loading",
                            value: _vm.loading.month,
                            expression: "loading.month"
                          }
                        ],
                        staticClass: "form-control md:tw-mb-0 tw-mb-2",
                        staticStyle: { width: "100%", "border-radius": "3px" },
                        attrs: {
                          placeholder: "เลือกวันที่",
                          name: "input_date",
                          id: "input_date",
                          pType: "month",
                          disabled: _vm.year == "" ? true : false,
                          format: "MMMM"
                        },
                        on: { dateWasSelected: _vm.getMonth },
                        model: {
                          value: _vm.monthTh,
                          callback: function($$v) {
                            _vm.monthTh = $$v
                          },
                          expression: "monthTh"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-lg-2" }, [
                    _vm._v("วันที่ผลิต")
                  ]),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-lg-2" },
                    [
                      _c("el-input", {
                        staticClass: "w-100",
                        attrs: { disabled: true, size: "small" },
                        model: {
                          value: _vm.dateFirsTofMonth,
                          callback: function($$v) {
                            _vm.dateFirsTofMonth = $$v
                          },
                          expression: "dateFirsTofMonth"
                        }
                      })
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "row m-2" }, [
                  _c("div", { staticClass: "col-lg-2" }, [_vm._v("ครั้งที่")]),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-lg-2" },
                    [
                      _c("el-input", {
                        staticClass: "w-100",
                        attrs: {
                          disabled: true,
                          placeholder: "0",
                          size: "small"
                        },
                        model: {
                          value: _vm.version,
                          callback: function($$v) {
                            _vm.version = $$v
                          },
                          expression: "version"
                        }
                      })
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _vm._m(0)
              ]),
              _vm._v(" "),
              _vm.loading.table ? _c("div", [_vm._m(1)]) : _vm._e(),
              _vm._v(" "),
              (_vm.productPlanLines.length > 0) &
              (_vm.userProfile.organization_code == "MPG")
                ? _c("TableRow", {
                    directives: [
                      {
                        name: "loading",
                        rawName: "v-loading",
                        value: _vm.loading.table,
                        expression: "loading.table"
                      }
                    ],
                    attrs: { "product-plan-lines": _vm.productPlanLines },
                    on: { input: _vm.onClickChild }
                  })
                : _vm._e(),
              _vm._v(" "),
              (_vm.productPlanLines.length > 0) &
              (_vm.userProfile.organization_code == "MP2")
                ? _c("TableRowMP2", {
                    directives: [
                      {
                        name: "loading",
                        rawName: "v-loading",
                        value: _vm.loading.table,
                        expression: "loading.table"
                      }
                    ],
                    attrs: { "product-plan-lines": _vm.productPlanLines },
                    on: { input: _vm.onClickChild }
                  })
                : _vm._e()
            ],
            1
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
    return _c("div", { staticClass: "row m-2" }, [
      _c("div", { staticClass: "col-lg-12 text-right" })
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "sk-spinner sk-spinner-wave mb-4" }, [
      _c("div", { staticClass: "sk-rect1" }),
      _vm._v(" "),
      _c("div", { staticClass: "sk-rect2" }),
      _vm._v(" "),
      _c("div", { staticClass: "sk-rect3" }),
      _vm._v(" "),
      _c("div", { staticClass: "sk-rect4" }),
      _vm._v(" "),
      _c("div", { staticClass: "sk-rect5" })
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/pmp0031/Table.vue?vue&type=template&id=62d5d06e&":
/*!****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/pmp0031/Table.vue?vue&type=template&id=62d5d06e& ***!
  \****************************************************************************************************************************************************************************************************************************/
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
    _c("table", { staticClass: "table table-bordered" }, [
      _vm._m(0),
      _vm._v(" "),
      _c(
        "tbody",
        _vm._l(_vm.lines, function(productPlanLine, index) {
          return _c("tr", { key: index }, [
            _c(
              "td",
              { staticClass: "text-center" },
              [
                _c("el-checkbox", {
                  attrs: {
                    disabled:
                      productPlanLine.request_number != null ? true : false,
                    checked:
                      productPlanLine.attribute15 == true ||
                      productPlanLine.request_number !== null
                        ? true
                        : false,
                    size: "small"
                  },
                  on: { input: _vm.onClickButton },
                  model: {
                    value: productPlanLine.attribute15,
                    callback: function($$v) {
                      _vm.$set(productPlanLine, "attribute15", $$v)
                    },
                    expression: "productPlanLine.attribute15"
                  }
                })
              ],
              1
            ),
            _vm._v(" "),
            _c("td", { staticClass: "text-center" }, [
              _c("small", [
                _vm._v(_vm._s(productPlanLine.item_number_v.item_number))
              ])
            ]),
            _vm._v(" "),
            _c("td", { staticClass: "text-center" }, [
              _c("small", [
                _vm._v(_vm._s(productPlanLine.item_number_v.item_desc))
              ])
            ]),
            _vm._v(" "),
            _c("td", { staticClass: "text-center" }, [
              _c("small", [_vm._v(_vm._s(productPlanLine.product_qty))])
            ]),
            _vm._v(" "),
            _c("td", { staticClass: "text-center" }, [
              _c("small", [
                _vm._v(_vm._s(productPlanLine.mtl_uom.unit_of_measure))
              ])
            ]),
            _vm._v(" "),
            _c("td", { staticClass: "text-center" }, [
              _c("small", [_vm._v(_vm._s(productPlanLine.period_name_request))])
            ]),
            _vm._v(" "),
            _c("td", { staticClass: "text-center" }, [
              _c("small", [
                _vm._v(_vm._s(productPlanLine.uom_ptn.unit_of_measure))
              ])
            ]),
            _vm._v(" "),
            _c(
              "td",
              { staticClass: "text-center" },
              [
                _c("el-input", {
                  staticClass: "w-auto",
                  attrs: {
                    size: "mini",
                    disabled:
                      productPlanLine.request_number !== null ? true : false
                  },
                  on: { input: _vm.onClickButton },
                  model: {
                    value: productPlanLine.input,
                    callback: function($$v) {
                      _vm.$set(productPlanLine, "input", $$v)
                    },
                    expression: "productPlanLine.input"
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
                _c("el-input", {
                  staticClass: "w-auto",
                  attrs: { size: "mini", readonly: "" },
                  model: {
                    value: productPlanLine.uom_ptn.unit_of_measure,
                    callback: function($$v) {
                      _vm.$set(productPlanLine.uom_ptn, "unit_of_measure", $$v)
                    },
                    expression: "productPlanLine.uom_ptn.unit_of_measure"
                  }
                })
              ],
              1
            ),
            _vm._v(" "),
            _c("td", { staticClass: "text-center" }, [
              _c("small", [_vm._v(_vm._s(productPlanLine.request_number))])
            ])
          ])
        }),
        0
      )
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
        _c("th", { attrs: { width: "3%" } }),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [
          _c("small", [_vm._v("รหัสสินค้า")])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [
          _c("small", [_vm._v("รายละเอียด")])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [
          _c("small", [_vm._v("ประมาณการจำหน่าย")])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [
          _c("small", [_vm._v("หน่วยนับ(1)")])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [
          _c("small", [_vm._v("จำนวนซอง")])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [
          _c("small", [_vm._v("หน่วยนับ(2)")])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [
          _c("small", [_vm._v("จำนวนที่ต้องผลิต")])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [
          _c("small", [_vm._v("หน่วยนับ(3)")])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [
          _c("small", [_vm._v("เลขที่คำสั่งการผลิต")])
        ])
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/pmp0031/TableMp2.vue?vue&type=template&id=dc10b9d4&":
/*!*******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/pmp0031/TableMp2.vue?vue&type=template&id=dc10b9d4& ***!
  \*******************************************************************************************************************************************************************************************************************************/
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
    _c("table", { staticClass: "table table-bordered" }, [
      _vm._m(0),
      _vm._v(" "),
      _c(
        "tbody",
        _vm._l(_vm.lines, function(productPlanLine, index) {
          return _c("tr", { key: index }, [
            _c(
              "td",
              { staticClass: "text-center" },
              [
                _c("el-checkbox", {
                  attrs: {
                    disabled:
                      productPlanLine.request_number != null ? true : false,
                    checked:
                      productPlanLine.attribute15 == true ||
                      productPlanLine.request_number !== null
                        ? true
                        : false,
                    size: "small"
                  },
                  on: { input: _vm.onClickButton },
                  model: {
                    value: productPlanLine.attribute15,
                    callback: function($$v) {
                      _vm.$set(productPlanLine, "attribute15", $$v)
                    },
                    expression: "productPlanLine.attribute15"
                  }
                })
              ],
              1
            ),
            _vm._v(" "),
            _c("td", { staticClass: "text-center" }, [
              _c("small", [
                _vm._v(_vm._s(productPlanLine.item_number_v.item_number))
              ])
            ]),
            _vm._v(" "),
            _c("td", { staticClass: "text-center" }, [
              _c("small", [
                _vm._v(_vm._s(productPlanLine.item_number_v.item_desc))
              ])
            ]),
            _vm._v(" "),
            _c("td", { staticClass: "text-center" }, [
              _c("small", [_vm._v(_vm._s(productPlanLine.product_qty))])
            ]),
            _vm._v(" "),
            _c("td", { staticClass: "text-center" }, [
              _c("small", [
                _vm._v(_vm._s(productPlanLine.mtl_uom.unit_of_measure))
              ])
            ]),
            _vm._v(" "),
            _c("td", { staticClass: "text-center" }, [
              _c("small", [_vm._v(_vm._s(productPlanLine.period_name_request))])
            ]),
            _vm._v(" "),
            _c("td", { staticClass: "text-center" }, [
              _c("small", [
                _vm._v(_vm._s(productPlanLine.uom_ptn.unit_of_measure))
              ])
            ]),
            _vm._v(" "),
            _c(
              "td",
              { staticClass: "text-right" },
              [
                _c("el-input", {
                  staticClass: "w-auto text-right",
                  attrs: { size: "mini" },
                  on: { input: _vm.onClickButton },
                  model: {
                    value: productPlanLine.input,
                    callback: function($$v) {
                      _vm.$set(productPlanLine, "input", $$v)
                    },
                    expression: "productPlanLine.input"
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
                _c("el-input", {
                  staticClass: "w-auto text-right",
                  attrs: { size: "mini", readonly: "" },
                  model: {
                    value: productPlanLine.uom_kg.unit_of_measure,
                    callback: function($$v) {
                      _vm.$set(productPlanLine.uom_kg, "unit_of_measure", $$v)
                    },
                    expression: "productPlanLine.uom_kg.unit_of_measure"
                  }
                })
              ],
              1
            ),
            _vm._v(" "),
            _c("td", { staticClass: "text-center" }, [
              _c("small", [_vm._v(_vm._s(productPlanLine.request_number))])
            ])
          ])
        }),
        0
      )
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
        _c("th", { attrs: { width: "3%" } }),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [
          _c("small", [_vm._v("รหัสสินค้า")])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [
          _c("small", [_vm._v("รายละเอียด")])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [
          _c("small", [_vm._v("ประมาณการจำหน่าย")])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [
          _c("small", [_vm._v("หน่วยนับ")])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [
          _c("small", [_vm._v("จำนวนซอง")])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [
          _c("small", [_vm._v("หน่วยนับ")])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [
          _c("small", [_vm._v("จำนวนที่ต้องผลิต")])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [
          _c("small", [_vm._v("หน่วยนับ")])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [
          _c("small", [_vm._v("เลขที่คำสั่งการผลิต")])
        ])
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);