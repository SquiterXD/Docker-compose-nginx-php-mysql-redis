(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ct_account_code_ledger_Form_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/account_code_ledger/Form.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/account_code_ledger/Form.vue?vue&type=script&lang=js& ***!
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["segment", "detail", "header", "organizations"],
  data: function data() {
    return {
      loading: false,
      form_error: {},
      form: {
        account_seq: this.header ? this.header.account_id : '',
        code_segment1: this.detail ? this.detail.code_segment1 : '',
        code_segment2: this.detail ? this.detail.code_segment2 : '',
        code_segment3: this.detail ? this.detail.code_segment3 : '',
        code_segment4: this.detail ? this.detail.code_segment4 : '',
        code_segment5: this.detail ? this.detail.code_segment5 : '',
        code_segment6: this.detail ? this.detail.code_segment6 : '',
        code_segment7: this.detail ? this.detail.code_segment7 : '',
        code_segment8: this.detail ? this.detail.code_segment8 : '',
        code_segment9: this.detail ? this.detail.code_segment9 : '',
        code_segment10: this.detail ? this.detail.code_segment10 : '',
        code_segment11: this.detail ? this.detail.code_segment11 : '',
        code_segment12: this.detail ? this.detail.code_segment12 : '',
        enable_flag: this.detail ? this.detail.enable_flag == 'Y' ? true : false : true,
        organization_id: this.detail ? this.detail.organization_id : '',
        tobacco_group_code: this.detail ? this.detail.tobacco_group_code : '',
        product_group: this.detail ? this.detail.product_group : '',
        start_date: '',
        end_date: '',
        ac_ledger_detail_id: this.detail ? this.detail.ac_ledger_detail_id : ''
      },
      selectInput: {},
      option: {
        product_group: [],
        account: [],
        category: [],
        organization: [],
        // organization: this.organizations,
        cost_center: [],
        SEGMENT1: [],
        SEGMENT2: [],
        SEGMENT3: [],
        SEGMENT4: [],
        SEGMENT5: [],
        SEGMENT6: [],
        SEGMENT7: [],
        SEGMENT8: [],
        SEGMENT9: [],
        SEGMENT10: [],
        SEGMENT11: [],
        SEGMENT12: []
      },
      segment4Lists: [],
      segment7Lists: [],
      segment10Lists: [],
      loadingProductGoup: true,
      loadingSegment4: true,
      loadingSegment7: true,
      loadingSegment10: true,
      isEdit: this.detail ? true : false,
      errors: {
        account_seq: false,
        organization_id: false
      },
      account_code: ''
    };
  },
  created: function created() {
    this.getMasterData();
    this.form.start_date = new Date();

    if (this.form.code_segment3) {
      this.getSegment4();
    }

    if (this.form.code_segment6) {
      this.getSegment7();
    }

    if (this.form.code_segment9) {
      this.getSegment10();
    }

    if (this.form.organization_id) {
      this.getProductGroup();
    }
  },
  methods: {
    checkOption: function checkOption(data) {
      if (data.length > 0) {
        return false;
      }

      return true;
    },
    getMasterData: function getMasterData() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var segment_arr, _i, _segment_arr, index, segment;

        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this.loading = true;

                _this.getAccount();

                _this.getCategory();

                _this.getOrganization();

                _this.getCostCenter(); // this.getProductGroup();


                segment_arr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

                for (_i = 0, _segment_arr = segment_arr; _i < _segment_arr.length; _i++) {
                  index = _segment_arr[_i];
                  segment = "SEGMENT".concat(index);

                  _this.setSegmentData(segment);
                }

                _this.loading = false;

              case 8:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getProductGroup: function getProductGroup() {
      var _this2 = this;

      this.loadingProductGoup = true;

      if (this.form.organization_id) {
        axios.get("/ct/ajax/account_code_ledger/get-product-group", {
          params: {
            organization_id: this.form.organization_id
          }
        }).then(function (res) {
          _this2.option.product_group = res.data;

          if (_this2.option.product_group.length > 0) {
            _this2.loadingProductGoup = false;
          }
        });
      } else {
        tthis.form.product_group = '';
      }
    },
    getAccount: function getAccount() {
      var _this3 = this;

      axios.get("/ct/ajax/account").then(function (res) {
        // this.option.account = res.data;
        _this3.option.account = _.sortBy(res.data, function (o) {
          return Number(o.seq);
        });
      });
    },
    getCategory: function getCategory() {
      var _this4 = this;

      axios.get("/ct/ajax/account_code_ledger/get-category").then(function (res) {
        _this4.option.category = res.data;
      });
    },
    getOrganization: function getOrganization() {
      var _this5 = this;

      axios.get("/ct/ajax/account_code_ledger/get-organizations").then(function (res) {
        _this5.option.organization = res.data;
      });
    },
    getCostCenter: function getCostCenter() {
      var _this6 = this;

      axios.get("/ct/ajax/cost_center").then(function (res) {
        _this6.option.cost_center = res.data;
      });
    },
    searchSegment: function searchSegment(query, segment) {
      var _this7 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var arr;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                console.log('searchSegment');
                _context2.next = 3;
                return true;

              case 3:
                _this7.selectInput[segment] = _context2.sent;
                _context2.next = 6;
                return _this7.segment[segment].filter(function (item) {
                  return item.description.includes(query) || item.flex_value.includes(query);
                });

              case 6:
                arr = _context2.sent;

                _this7.setSegmentData(segment, arr);

              case 8:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    setSegmentData: function setSegmentData(segment) {
      var data = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
      data = data ? data : this.segment[segment];
      this.selectInput[segment] = true;

      if (data) {
        // if (data.length > 100) {
        //     let reduction = data;
        //     reduction.length = 100;
        //     this.option[segment] = reduction;
        // } else {
        this.option[segment] = data; // }

        this.selectInput[segment] = false;
      }
    },
    getSegment: function getSegment(segment) {
      var _this8 = this;

      axios.get("/ct/ajax/account_code_ledger/get-lov-list/".concat(segment)).then(function (res) {
        _this8.option[segment] = res.data;
      });
    },
    addRow: function addRow(data) {
      var item = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
      data.push(item);
    },
    deleteRow: function deleteRow(index, data) {
      data.splice(index, 1);
    },
    handleSubmit: function handleSubmit() {
      this.loading = true;

      if (this.isEdit) {
        this.update();
      } else {
        this.store();
      }
    },
    getDataListSegments: function getDataListSegments(query, segment) {
      var _this9 = this;

      axios.get("/ct/ajax/account_code_ledger/get-data-list-segments", {
        params: {
          query: query,
          segment: segment,
          detail: this.detail
        }
      }).then(function (res) {
        _this9.option[segment] = res.data;
      });
    },
    errorMessage: function errorMessage(err) {
      var _this10 = this;

      var errors = err.errors;

      if (errors) {
        Object.keys(errors).forEach(function (item) {
          _this10.form_error[item] = {};
          _this10.form_error[item]["title"] = item;
          _this10.form_error[item]["message"] = errors[item][0];
        });
        this.resetError();
      }
    },
    // resetError() {
    //     setTimeout(() => {
    //         this.form_error = {};
    //     }, 5000);
    // },
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
      vm.errors.account_seq = res.err.account_seq;
      vm.errors.organization_id = res.err.organization_id;
    },
    store: function store() {
      var _this11 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var errorMsg;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                errorMsg = '';
                _this11.errors.account_seq = false;
                _this11.errors.organization_id = false;
                $(submitForm).find("div[id='el_explode_organization_id']").html("");
                $(submitForm).find("div[id='el_explode_account_seq']").html("");

                if (!_this11.form.account_seq) {
                  _this11.errors.account_seq = true;
                  errorMsg = "กรุณาเลือก รายการบัญชี";
                  $(submitForm).find("div[id='el_explode_account_seq']").html(errorMsg);
                }

                if (!_this11.form.organization_id) {
                  _this11.errors.organization_id = true;
                  errorMsg = "กรุณาเลือก ORG";
                  $(submitForm).find("div[id='el_explode_organization_id']").html(errorMsg);
                }

                if (!(_this11.form.account_seq && _this11.form.organization_id)) {
                  _context3.next = 10;
                  break;
                }

                _context3.next = 10;
                return axios.post("/ct/ajax/account_code_ledger", _this11.form).then(function (res) {
                  _this11.$message({
                    showClose: true,
                    message: "บันทึกสำเร็จ",
                    type: "success",
                    onClose: function onClose() {
                      window.location.href = "/ct/account_code_ledger";
                    }
                  });
                })["catch"](function (err) {
                  _this11.errorMessage(err.response.data);

                  _this11.$message({
                    showClose: true,
                    message: "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E44\u0E14\u0E49",
                    type: "error"
                  });
                }).then(function () {
                  _this11.loading = false;
                });

              case 10:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    update: function update() {
      var _this12 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        var errorMsg;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                errorMsg = '';
                _this12.errors.account_seq = false;
                _this12.errors.organization_id = false;
                $(submitForm).find("div[id='el_explode_organization_id']").html("");
                $(submitForm).find("div[id='el_explode_account_seq']").html("");

                if (!_this12.form.account_seq) {
                  _this12.errors.account_seq = true;
                  errorMsg = "กรุณาเลือก รายการบัญชี";
                  $(submitForm).find("div[id='el_explode_account_seq']").html(errorMsg);
                }

                if (!_this12.form.organization_id) {
                  _this12.errors.organization_id = true;
                  errorMsg = "กรุณาเลือก ORG";
                  $(submitForm).find("div[id='el_explode_organization_id']").html(errorMsg);
                }

                if (!(_this12.form.account_seq && _this12.form.organization_id)) {
                  _context4.next = 10;
                  break;
                }

                _context4.next = 10;
                return axios.post("/ct/ajax/account_code_ledger/update", _this12.form).then(function (res) {
                  _this12.$message({
                    showClose: true,
                    message: "บันทึกสำเร็จ",
                    type: "success",
                    onClose: function onClose() {
                      window.location.href = "/ct/account_code_ledger";
                    }
                  });
                })["catch"](function (err) {
                  _this12.errorMessage(err.response.data);

                  _this12.$message({
                    showClose: true,
                    message: "\u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E44\u0E14\u0E49",
                    type: "error"
                  });
                }).then(function () {
                  _this12.loading = false;
                });

              case 10:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    refresh: function refresh() {
      this.form = {};
    },
    getSegment4: function getSegment4() {
      var _this13 = this;

      this.loadingSegment4 = true;

      if (this.form.code_segment3) {
        axios.get("/ct/ajax/account_code_ledger/get-data-list", {
          params: {
            parent: this.form.code_segment3,
            segment: 'SEGMENT4',
            segment_parent: 'SEGMENT3'
          }
        }).then(function (res) {
          _this13.segment4Lists = res.data;

          if (_this13.segment4Lists.length > 0) {
            _this13.loadingSegment4 = false;
          }
        });
      } else {
        this.form.code_segment4 = '';
      }
    },
    getSegment7: function getSegment7() {
      var _this14 = this;

      this.loadingSegment7 = true;

      if (this.form.code_segment6) {
        axios.get("/ct/ajax/account_code_ledger/get-data-list", {
          params: {
            parent: this.form.code_segment6,
            segment: 'SEGMENT7',
            segment_parent: 'SEGMENT6'
          }
        }).then(function (res) {
          _this14.segment7Lists = res.data;

          if (_this14.segment7Lists.length > 0) {
            _this14.loadingSegment7 = false;
          }
        });
      } else {
        this.form.code_segment7 = '';
      }
    },
    getSegment10: function getSegment10() {
      var _this15 = this;

      this.loadingSegment10 = true;

      if (this.form.code_segment9) {
        axios.get("/ct/ajax/account_code_ledger/get-data-list", {
          params: {
            parent: this.form.code_segment9,
            segment: 'SEGMENT10',
            segment_parent: 'SEGMENT9'
          }
        }).then(function (res) {
          _this15.segment10Lists = res.data;

          if (_this15.segment10Lists.length > 0) {
            _this15.loadingSegment10 = false;
          }
        });
      } else {
        this.form.code_segment10 = '';
      }
    }
  },
  watch: {
    errors: {
      handler: function handler(val) {
        val.organization_id ? this.setError('organization_id') : this.resetError('organization_id');
      },
      deep: true
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/account_code_ledger/Form.vue?vue&type=style&index=0&id=0dfd432d&lang=scss&scoped=true&":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/account_code_ledger/Form.vue?vue&type=style&index=0&id=0dfd432d&lang=scss&scoped=true& ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, ".box-card[data-v-0dfd432d] {\n  padding: 20px;\n}\n.error-message[data-v-0dfd432d] {\n  display: flex;\n  color: #ec4958;\n  margin-top: 5px;\n}\n.error-message strong[data-v-0dfd432d] {\n  margin-right: 5px;\n}\n.mt-custom__10[data-v-0dfd432d] {\n  margin-top: 10px;\n}\n.text-title[data-v-0dfd432d] {\n  font-size: 16px;\n  font-weight: 600;\n}\n.btn-info[data-v-0dfd432d] {\n  background-color: #02b0ef;\n  border-color: #02b0ef;\n}\n.btn-success[data-v-0dfd432d] {\n  background-color: #1ab394;\n  border-color: #1ab394;\n}\n.btn-cancel[data-v-0dfd432d] {\n  background-color: #ec4958;\n  border-color: #ec4958;\n  color: white;\n}\n.text-refresh[data-v-0dfd432d] {\n  color: #ec4958;\n}", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/account_code_ledger/Form.vue?vue&type=style&index=0&id=0dfd432d&lang=scss&scoped=true&":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/account_code_ledger/Form.vue?vue&type=style&index=0&id=0dfd432d&lang=scss&scoped=true& ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Form_vue_vue_type_style_index_0_id_0dfd432d_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!../../../../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Form.vue?vue&type=style&index=0&id=0dfd432d&lang=scss&scoped=true& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/account_code_ledger/Form.vue?vue&type=style&index=0&id=0dfd432d&lang=scss&scoped=true&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Form_vue_vue_type_style_index_0_id_0dfd432d_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Form_vue_vue_type_style_index_0_id_0dfd432d_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/components/ct/account_code_ledger/Form.vue":
/*!*****************************************************************!*\
  !*** ./resources/js/components/ct/account_code_ledger/Form.vue ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Form_vue_vue_type_template_id_0dfd432d_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Form.vue?vue&type=template&id=0dfd432d&scoped=true& */ "./resources/js/components/ct/account_code_ledger/Form.vue?vue&type=template&id=0dfd432d&scoped=true&");
/* harmony import */ var _Form_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Form.vue?vue&type=script&lang=js& */ "./resources/js/components/ct/account_code_ledger/Form.vue?vue&type=script&lang=js&");
/* harmony import */ var _Form_vue_vue_type_style_index_0_id_0dfd432d_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Form.vue?vue&type=style&index=0&id=0dfd432d&lang=scss&scoped=true& */ "./resources/js/components/ct/account_code_ledger/Form.vue?vue&type=style&index=0&id=0dfd432d&lang=scss&scoped=true&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _Form_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Form_vue_vue_type_template_id_0dfd432d_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _Form_vue_vue_type_template_id_0dfd432d_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "0dfd432d",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ct/account_code_ledger/Form.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ct/account_code_ledger/Form.vue?vue&type=script&lang=js&":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/ct/account_code_ledger/Form.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Form_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Form.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/account_code_ledger/Form.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Form_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ct/account_code_ledger/Form.vue?vue&type=style&index=0&id=0dfd432d&lang=scss&scoped=true&":
/*!***************************************************************************************************************************!*\
  !*** ./resources/js/components/ct/account_code_ledger/Form.vue?vue&type=style&index=0&id=0dfd432d&lang=scss&scoped=true& ***!
  \***************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Form_vue_vue_type_style_index_0_id_0dfd432d_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!../../../../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Form.vue?vue&type=style&index=0&id=0dfd432d&lang=scss&scoped=true& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/account_code_ledger/Form.vue?vue&type=style&index=0&id=0dfd432d&lang=scss&scoped=true&");


/***/ }),

/***/ "./resources/js/components/ct/account_code_ledger/Form.vue?vue&type=template&id=0dfd432d&scoped=true&":
/*!************************************************************************************************************!*\
  !*** ./resources/js/components/ct/account_code_ledger/Form.vue?vue&type=template&id=0dfd432d&scoped=true& ***!
  \************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Form_vue_vue_type_template_id_0dfd432d_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Form_vue_vue_type_template_id_0dfd432d_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Form_vue_vue_type_template_id_0dfd432d_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Form.vue?vue&type=template&id=0dfd432d&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/account_code_ledger/Form.vue?vue&type=template&id=0dfd432d&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/account_code_ledger/Form.vue?vue&type=template&id=0dfd432d&scoped=true&":
/*!***************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ct/account_code_ledger/Form.vue?vue&type=template&id=0dfd432d&scoped=true& ***!
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
  return _c("div", { attrs: { id: "submitForm" } }, [
    _c("div", { staticClass: "row mt-2" }, [
      _vm._m(0),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "form-group col-md-4" },
        [
          _c(
            "el-select",
            {
              ref: "account_seq",
              staticStyle: { width: "100%" },
              attrs: {
                placeholder: "รายการบัญชี",
                disabled: this.isEdit,
                filterable: "",
                clearable: ""
              },
              model: {
                value: _vm.form.account_seq,
                callback: function($$v) {
                  _vm.$set(_vm.form, "account_seq", $$v)
                },
                expression: "form.account_seq"
              }
            },
            _vm._l(_vm.option.account, function(item, index) {
              return _c("el-option", {
                key: index,
                attrs: {
                  label: item.seq + " : " + item.name,
                  value: item.account_id
                }
              })
            }),
            1
          ),
          _vm._v(" "),
          _c("div", {
            staticClass: "error_msg text-left",
            attrs: { id: "el_explode_account_seq" }
          })
        ],
        1
      )
    ]),
    _vm._v(" "),
    _c("hr"),
    _vm._v(" "),
    _c("div", { staticClass: "row mt-2" }, [
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _c("label", [_vm._v(" รหัสบริษัท ")]),
          _vm._v(" "),
          _c(
            "el-select",
            {
              staticStyle: { width: "100%" },
              attrs: {
                size: "small",
                placeholder: "รหัสบริษัท",
                filterable: "",
                clearable: "",
                remote: "",
                "remote-method": function(query) {
                  return _vm.getDataListSegments(query, "SEGMENT1")
                },
                loading: _vm.selectInput.SEGMENT1
              },
              model: {
                value: _vm.form.code_segment1,
                callback: function($$v) {
                  _vm.$set(_vm.form, "code_segment1", $$v)
                },
                expression: "form.code_segment1"
              }
            },
            _vm._l(_vm.option.SEGMENT1, function(item, index) {
              return _c("el-option", {
                key: index,
                attrs: {
                  label: item.flex_value + " : " + item.description,
                  value: item.flex_value
                }
              })
            }),
            1
          ),
          _vm._v(" "),
          _c("div", {
            staticClass: "error_msg text-left",
            attrs: { id: "el_explode_segment1" }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _c("label", [_vm._v(" EVM ")]),
          _vm._v(" "),
          _c(
            "el-select",
            {
              staticStyle: { width: "100%" },
              attrs: {
                size: "small",
                placeholder: "EVM",
                filterable: "",
                clearable: "",
                remote: "",
                "remote-method": function(query) {
                  return _vm.getDataListSegments(query, "SEGMENT2")
                },
                loading: _vm.selectInput.SEGMENT2
              },
              model: {
                value: _vm.form.code_segment2,
                callback: function($$v) {
                  _vm.$set(_vm.form, "code_segment2", $$v)
                },
                expression: "form.code_segment2"
              }
            },
            _vm._l(_vm.option.SEGMENT2, function(item, index) {
              return _c(
                "el-option",
                {
                  key: index,
                  attrs: {
                    label: item.flex_value + " : " + item.description,
                    value: item.flex_value
                  }
                },
                [
                  _c("span", [
                    _vm._v(
                      "\n                        " +
                        _vm._s(item.flex_value + " - " + item.description) +
                        "\n                    "
                    )
                  ])
                ]
              )
            }),
            1
          ),
          _vm._v(" "),
          _c("div", {
            staticClass: "error_msg text-left",
            attrs: { id: "el_explode_segment2" }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _c("label", [_vm._v(" หน่วยงาน ")]),
          _vm._v(" "),
          _c(
            "el-select",
            {
              staticStyle: { width: "100%" },
              attrs: {
                size: "small",
                placeholder: "หน่วยงาน",
                filterable: "",
                clearable: "",
                loading: _vm.selectInput.SEGMENT3,
                remote: "",
                "remote-method": function(query) {
                  return _vm.getDataListSegments(query, "SEGMENT3")
                }
              },
              on: {
                change: function($event) {
                  return _vm.getSegment4()
                }
              },
              model: {
                value: _vm.form.code_segment3,
                callback: function($$v) {
                  _vm.$set(_vm.form, "code_segment3", $$v)
                },
                expression: "form.code_segment3"
              }
            },
            _vm._l(_vm.option.SEGMENT3, function(item, index) {
              return _c(
                "el-option",
                {
                  key: index,
                  attrs: {
                    label: item.flex_value + " : " + item.description,
                    value: item.flex_value
                  }
                },
                [
                  _c("span", [
                    _vm._v(
                      "\n                        " +
                        _vm._s(item.flex_value + " - " + item.description) +
                        "\n                    "
                    )
                  ])
                ]
              )
            }),
            1
          ),
          _vm._v(" "),
          _c("div", {
            staticClass: "error_msg text-left",
            attrs: { id: "el_explode_segment3" }
          })
        ],
        1
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "row mt-2" }, [
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _c("label", [_vm._v(" ศูนย์ต้นทุน ")]),
          _vm._v(" "),
          _c(
            "el-select",
            {
              staticStyle: { width: "100%" },
              attrs: {
                size: "small",
                placeholder: "ศูนย์ต้นทุน",
                filterable: "",
                clearable: "",
                remote: "",
                loading: _vm.selectInput.SEGMENT4,
                disabled: this.loadingSegment4
              },
              model: {
                value: _vm.form.code_segment4,
                callback: function($$v) {
                  _vm.$set(_vm.form, "code_segment4", $$v)
                },
                expression: "form.code_segment4"
              }
            },
            _vm._l(_vm.segment4Lists, function(item, index) {
              return _c(
                "el-option",
                {
                  key: index,
                  attrs: {
                    label: item.flex_value + " : " + item.description,
                    value: item.flex_value
                  }
                },
                [
                  _c("span", [
                    _vm._v(
                      "\n                        " +
                        _vm._s(item.flex_value + " - " + item.description) +
                        "\n                    "
                    )
                  ])
                ]
              )
            }),
            1
          ),
          _vm._v(" "),
          _c("div", {
            staticClass: "error_msg text-left",
            attrs: { id: "el_explode_segment4" }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _c("label", [_vm._v(" BUDGET YEAR ")]),
          _vm._v(" "),
          _c(
            "el-select",
            {
              staticStyle: { width: "100%" },
              attrs: {
                size: "small",
                placeholder: "BUDGET YEAR",
                filterable: "",
                clearable: "",
                remote: "",
                "remote-method": function(query) {
                  return _vm.getDataListSegments(query, "SEGMENT5")
                },
                loading: _vm.selectInput.SEGMENT1
              },
              model: {
                value: _vm.form.code_segment5,
                callback: function($$v) {
                  _vm.$set(_vm.form, "code_segment5", $$v)
                },
                expression: "form.code_segment5"
              }
            },
            _vm._l(_vm.option.SEGMENT5, function(item, index) {
              return _c(
                "el-option",
                {
                  key: index,
                  attrs: {
                    label: item.flex_value + " : " + item.description,
                    value: item.flex_value
                  }
                },
                [
                  _c("span", [
                    _vm._v(
                      "\n                        " +
                        _vm._s(item.flex_value + " - " + item.description) +
                        "\n                    "
                    )
                  ])
                ]
              )
            }),
            1
          ),
          _vm._v(" "),
          _c("div", {
            staticClass: "error_msg text-left",
            attrs: { id: "el_explode_segment5" }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _c("label", [_vm._v(" รหัสงบ ")]),
          _vm._v(" "),
          _c(
            "el-select",
            {
              staticStyle: { width: "100%" },
              attrs: {
                size: "small",
                placeholder: "รหัสงบ",
                filterable: "",
                clearable: "",
                remote: "",
                "remote-method": function(query) {
                  return _vm.getDataListSegments(query, "SEGMENT6")
                },
                loading: _vm.selectInput.SEGMENT6
              },
              on: {
                change: function($event) {
                  return _vm.getSegment7()
                }
              },
              model: {
                value: _vm.form.code_segment6,
                callback: function($$v) {
                  _vm.$set(_vm.form, "code_segment6", $$v)
                },
                expression: "form.code_segment6"
              }
            },
            _vm._l(_vm.option.SEGMENT6, function(item, index) {
              return _c(
                "el-option",
                {
                  key: index,
                  attrs: {
                    label: item.flex_value + " : " + item.description,
                    value: item.flex_value
                  }
                },
                [
                  _c("span", [
                    _vm._v(
                      "\n                        " +
                        _vm._s(item.flex_value + " - " + item.description) +
                        "\n                    "
                    )
                  ])
                ]
              )
            }),
            1
          ),
          _vm._v(" "),
          _c("div", {
            staticClass: "error_msg text-left",
            attrs: { id: "el_explode_segment6" }
          })
        ],
        1
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "row mt-2" }, [
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _c("label", [_vm._v(" รายละเอียดงบ ")]),
          _vm._v(" "),
          _c(
            "el-select",
            {
              staticStyle: { width: "100%" },
              attrs: {
                size: "small",
                placeholder: "รายละเอียดงบ",
                filterable: "",
                clearable: "",
                remote: "",
                loading: _vm.selectInput.SEGMENT7,
                disabled: this.loadingSegment7
              },
              model: {
                value: _vm.form.code_segment7,
                callback: function($$v) {
                  _vm.$set(_vm.form, "code_segment7", $$v)
                },
                expression: "form.code_segment7"
              }
            },
            _vm._l(_vm.segment7Lists, function(item, index) {
              return _c(
                "el-option",
                {
                  key: index,
                  attrs: {
                    label: item.flex_value + " : " + item.description,
                    value: item.flex_value
                  }
                },
                [
                  _c("span", [
                    _vm._v(
                      "\n                        " +
                        _vm._s(item.flex_value + " - " + item.description) +
                        "\n                    "
                    )
                  ])
                ]
              )
            }),
            1
          ),
          _vm._v(" "),
          _c("div", {
            staticClass: "error_msg text-left",
            attrs: { id: "el_explode_segment7" }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _c("label", [_vm._v(" เหตุผลงบ ")]),
          _vm._v(" "),
          _c(
            "el-select",
            {
              staticStyle: { width: "100%" },
              attrs: {
                size: "small",
                placeholder: "เหตุผลงบ",
                filterable: "",
                clearable: "",
                loading: _vm.selectInput.SEGMENT8,
                remote: "",
                "remote-method": function(query) {
                  return _vm.getDataListSegments(query, "SEGMENT8")
                }
              },
              model: {
                value: _vm.form.code_segment8,
                callback: function($$v) {
                  _vm.$set(_vm.form, "code_segment8", $$v)
                },
                expression: "form.code_segment8"
              }
            },
            _vm._l(_vm.option.SEGMENT8, function(item, index) {
              return _c("el-option", {
                key: index,
                attrs: {
                  label: item.flex_value + " : " + item.description,
                  value: item.flex_value
                }
              })
            }),
            1
          ),
          _vm._v(" "),
          _c("div", {
            staticClass: "error_msg text-left",
            attrs: { id: "el_explode_segment8" }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _c("label", [_vm._v(" รหัสบัญชี (9) ")]),
          _vm._v(" "),
          _c(
            "el-select",
            {
              staticStyle: { width: "100%" },
              attrs: {
                size: "small",
                placeholder: "รหัสบัญชี (9)",
                filterable: "",
                clearable: "",
                remote: "",
                "remote-method": function(query) {
                  return _vm.getDataListSegments(query, "SEGMENT9")
                },
                loading: _vm.selectInput.SEGMENT9
              },
              on: {
                change: function($event) {
                  return _vm.getSegment10()
                }
              },
              model: {
                value: _vm.form.code_segment9,
                callback: function($$v) {
                  _vm.$set(_vm.form, "code_segment9", $$v)
                },
                expression: "form.code_segment9"
              }
            },
            _vm._l(_vm.option.SEGMENT9, function(item, index) {
              return _c(
                "el-option",
                {
                  key: index,
                  attrs: {
                    label: item.flex_value + " : " + item.description,
                    value: item.flex_value
                  }
                },
                [
                  _c("span", [
                    _vm._v(
                      "\n                        " +
                        _vm._s(item.flex_value + " - " + item.description) +
                        "\n                    "
                    )
                  ])
                ]
              )
            }),
            1
          ),
          _vm._v(" "),
          _c("div", {
            staticClass: "error_msg text-left",
            attrs: { id: "el_explode_segment9" }
          })
        ],
        1
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "row mt-2" }, [
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _c("label", [_vm._v(" รหัสบัญชี (10) ")]),
          _vm._v(" "),
          _c(
            "el-select",
            {
              staticStyle: { width: "100%" },
              attrs: {
                size: "small",
                filterable: "",
                clearable: "",
                remote: "",
                loading: _vm.selectInput.SEGMENT10,
                placeholder: "รหัสบัญชี (10)",
                disabled: this.loadingSegment10
              },
              model: {
                value: _vm.form.code_segment10,
                callback: function($$v) {
                  _vm.$set(_vm.form, "code_segment10", $$v)
                },
                expression: "form.code_segment10"
              }
            },
            _vm._l(_vm.segment10Lists, function(item, index) {
              return _c("el-option", {
                key: index,
                attrs: {
                  label: item.flex_value + " : " + item.description,
                  value: item.flex_value
                }
              })
            }),
            1
          ),
          _vm._v(" "),
          _c("div", {
            staticClass: "error_msg text-left",
            attrs: { id: "el_explode_segment10" }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _c("label", [_vm._v(" RESERVED1 ")]),
          _vm._v(" "),
          _c(
            "el-select",
            {
              staticStyle: { width: "100%" },
              attrs: {
                size: "small",
                placeholder: "RES1",
                loading: _vm.selectInput.SEGMENT11,
                filterable: "",
                clearable: "",
                remote: ""
              },
              model: {
                value: _vm.form.code_segment11,
                callback: function($$v) {
                  _vm.$set(_vm.form, "code_segment11", $$v)
                },
                expression: "form.code_segment11"
              }
            },
            _vm._l(_vm.option.SEGMENT11, function(item, index) {
              return _c("el-option", {
                key: index,
                attrs: {
                  label: item.description
                    ? item.flex_value + " : " + item.description
                    : item.flex_value,
                  value: item.flex_value
                }
              })
            }),
            1
          ),
          _vm._v(" "),
          _c("div", {
            staticClass: "error_msg text-left",
            attrs: { id: "el_explode_segment11" }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _c("label", [_vm._v(" RESERVED2 ")]),
          _vm._v(" "),
          _c(
            "el-select",
            {
              staticStyle: { width: "100%" },
              attrs: {
                size: "small",
                placeholder: "RES2",
                loading: _vm.selectInput.SEGMENT12,
                filterable: "",
                clearable: "",
                remote: ""
              },
              model: {
                value: _vm.form.code_segment12,
                callback: function($$v) {
                  _vm.$set(_vm.form, "code_segment12", $$v)
                },
                expression: "form.code_segment12"
              }
            },
            _vm._l(_vm.option.SEGMENT12, function(item, index) {
              return _c("el-option", {
                key: index,
                attrs: {
                  label: item.description
                    ? item.flex_value + " : " + item.description
                    : item.flex_value,
                  value: item.flex_value
                }
              })
            }),
            1
          ),
          _vm._v(" "),
          _c("div", {
            staticClass: "error_msg text-left",
            attrs: { id: "el_explode_segment12" }
          })
        ],
        1
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "row mt-2" }, [
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _vm._m(1),
          _vm._v(" "),
          _c(
            "el-select",
            {
              ref: "organization_id",
              staticStyle: { width: "100%" },
              attrs: {
                size: "small",
                placeholder: "ORG.",
                filterable: "",
                clearable: "",
                remote: ""
              },
              on: {
                change: function($event) {
                  return _vm.getProductGroup()
                }
              },
              model: {
                value: _vm.form.organization_id,
                callback: function($$v) {
                  _vm.$set(_vm.form, "organization_id", $$v)
                },
                expression: "form.organization_id"
              }
            },
            _vm._l(_vm.option.organization, function(item, index) {
              return _c("el-option", {
                key: index,
                attrs: {
                  label:
                    item.organization_code + " - " + item.organization_name,
                  value: item.organization_id
                }
              })
            }),
            1
          ),
          _vm._v(" "),
          _c("div", {
            staticClass: "error_msg text-left",
            attrs: { id: "el_explode_organization_id" }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _c("label", [_vm._v(" CAT. ")]),
          _vm._v(" "),
          _c(
            "el-select",
            {
              staticStyle: { width: "100%" },
              attrs: {
                size: "small",
                placeholder: "CAT.",
                filterable: "",
                clearable: ""
              },
              model: {
                value: _vm.form.tobacco_group_code,
                callback: function($$v) {
                  _vm.$set(_vm.form, "tobacco_group_code", $$v)
                },
                expression: "form.tobacco_group_code"
              }
            },
            _vm._l(_vm.option.category, function(item, index) {
              return _c("el-option", {
                key: index,
                attrs: {
                  label: item.group_code + " : " + item.group_desc,
                  value: item.group_code
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
        { staticClass: "col-md-4" },
        [
          _c("label", [_vm._v(" กลุ่มผลิตภัณฑ์ ")]),
          _vm._v(" "),
          _c(
            "el-select",
            {
              staticStyle: { width: "100%" },
              attrs: {
                size: "small",
                placeholder: "กลุ่มผลิตภัณฑ์",
                loading: _vm.selectInput.product_group,
                disabled: this.loadingProductGoup,
                filterable: "",
                clearable: ""
              },
              model: {
                value: _vm.form.product_group,
                callback: function($$v) {
                  _vm.$set(_vm.form, "product_group", $$v)
                },
                expression: "form.product_group"
              }
            },
            _vm._l(_vm.option.product_group, function(item, index) {
              return _c("el-option", {
                key: index,
                attrs: {
                  label: item.product_group + " : " + item.description,
                  value: item.product_group
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
    _c("div", { staticClass: "row mt-2" }, [
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _c("label", [_vm._v(" วันที่เริ่มต้น ")]),
          _vm._v(" "),
          _c("el-date-picker", {
            staticStyle: { width: "100%" },
            attrs: {
              size: "small",
              type: "date",
              placeholder: "วันที่เริ่มต้น",
              name: "start_date",
              format: "dd-MM-yyyy"
            },
            model: {
              value: _vm.form.start_date,
              callback: function($$v) {
                _vm.$set(_vm.form, "start_date", $$v)
              },
              expression: "form.start_date"
            }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-4" },
        [
          _c("label", [_vm._v(" วันที่สิ้นสุด ")]),
          _vm._v(" "),
          _c("el-date-picker", {
            staticStyle: { width: "100%" },
            attrs: {
              size: "small",
              type: "date",
              placeholder: "วันที่เริ่มต้น",
              name: "end_date",
              format: "dd-MM-yyyy"
            },
            model: {
              value: _vm.form.end_date,
              callback: function($$v) {
                _vm.$set(_vm.form, "end_date", $$v)
              },
              expression: "form.end_date"
            }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c("div", { staticClass: "col-md-4" }, [
        _c("label", [_vm._v(" Active ")]),
        _vm._v(" "),
        _c("div", [
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.form.enable_flag,
                expression: "form.enable_flag"
              }
            ],
            attrs: { type: "checkbox", name: "enable_flag" },
            domProps: {
              checked: Array.isArray(_vm.form.enable_flag)
                ? _vm._i(_vm.form.enable_flag, null) > -1
                : _vm.form.enable_flag
            },
            on: {
              change: function($event) {
                var $$a = _vm.form.enable_flag,
                  $$el = $event.target,
                  $$c = $$el.checked ? true : false
                if (Array.isArray($$a)) {
                  var $$v = null,
                    $$i = _vm._i($$a, $$v)
                  if ($$el.checked) {
                    $$i < 0 &&
                      _vm.$set(_vm.form, "enable_flag", $$a.concat([$$v]))
                  } else {
                    $$i > -1 &&
                      _vm.$set(
                        _vm.form,
                        "enable_flag",
                        $$a.slice(0, $$i).concat($$a.slice($$i + 1))
                      )
                  }
                } else {
                  _vm.$set(_vm.form, "enable_flag", $$c)
                }
              }
            }
          })
        ])
      ])
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "row mt-2" }, [
      _c("div", { staticClass: "col-12 text-right" }, [
        _c(
          "button",
          {
            staticClass: "btn btn-sm btn-primary",
            attrs: { type: "button" },
            on: {
              click: function($event) {
                return _vm.handleSubmit()
              }
            }
          },
          [_c("i", { staticClass: "fa fa-save" }), _vm._v(" ยืนยัน ")]
        ),
        _vm._v(" "),
        _c(
          "button",
          {
            staticClass: "btn btn-sm btn-warning",
            attrs: { type: "button" },
            on: {
              click: function($event) {
                return _vm.refresh()
              }
            }
          },
          [_c("i", { staticClass: "fa fa-times" }), _vm._v(" ล้างข้อมูล ")]
        )
      ])
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "row mt-2" }, [
      _c("h3", { staticClass: "ml-3" }, [
        _vm._v(
          _vm._s(
            _vm.form.code_segment1 +
              "." +
              _vm.form.code_segment2 +
              "." +
              _vm.form.code_segment3 +
              "." +
              _vm.form.code_segment4 +
              "." +
              _vm.form.code_segment5 +
              "." +
              _vm.form.code_segment6 +
              "." +
              _vm.form.code_segment7 +
              "." +
              _vm.form.code_segment8 +
              "." +
              _vm.form.code_segment9 +
              "." +
              _vm.form.code_segment10 +
              "." +
              _vm.form.code_segment11 +
              "." +
              _vm.form.code_segment12
          )
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
    return _c("div", { staticClass: "col-md-2 text-right" }, [
      _c("label", { staticClass: "mt-2 " }, [
        _vm._v("รายการบัญชี "),
        _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v(" ORG. "),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  }
]
render._withStripped = true



/***/ })

}]);