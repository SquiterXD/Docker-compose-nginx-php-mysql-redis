(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ir_account-mapping_AccountCodeComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/account-mapping/AccountCodeComponent.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/account-mapping/AccountCodeComponent.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************************************/
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


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['search', 'defaultValueSetName', 'defaultValue', 'urlSave', 'urlReset'],
  data: function data() {
    return {
      loading: false,
      value: '',
      detail: '',
      account_code: this.defaultValue ? this.defaultValue.account_code : '',
      description: this.defaultValue ? this.defaultValue.description : '',
      segment1: this.defaultValue ? this.defaultValue.segment_1 : '',
      segment2: this.defaultValue ? this.defaultValue.segment_2 : '',
      segment3: this.defaultValue ? this.defaultValue.segment_3 : '',
      segment4: this.defaultValue ? this.defaultValue.segment_4 : '',
      segment5: this.defaultValue ? this.defaultValue.segment_5 : '',
      segment6: this.defaultValue ? this.defaultValue.segment_6 : '',
      segment7: this.defaultValue ? this.defaultValue.segment_7 : '',
      segment8: this.defaultValue ? this.defaultValue.segment_8 : '',
      segment9: this.defaultValue ? this.defaultValue.segment_9 : '',
      segment10: this.defaultValue ? this.defaultValue.segment_10 : '',
      segment11: this.defaultValue ? this.defaultValue.segment_11 : '',
      segment12: this.defaultValue ? this.defaultValue.segment_12 : '',
      active_flag: this.defaultValue ? this.defaultValue.active_flag == 'Y' ? true : false : true,
      start_date: this.defaultValue ? this.defaultValue.start_date : '',
      end_date: this.defaultValue ? this.defaultValue.end_date : '',
      disableEdit: this.defaultValue ? this.defaultValue.account_code ? true : false : false,
      // Option[]
      option1: [],
      option2: [],
      option3: [],
      option4: [],
      option5: [],
      option6: [],
      option7: [],
      option8: [],
      option9: [],
      option10: [],
      option11: [],
      option12: [],
      coaEnter: this.search ? this.search.account_from : '',
      //user กรอก segment acc เอง
      encumbrances: [],
      errors: {
        period: false,
        segmentOverride: false,
        account_code: false,
        description: false,
        segment1: false,
        segment2: false,
        segment3: false,
        segment4: false,
        segment5: false,
        segment6: false,
        segment7: false,
        segment8: false,
        segment9: false,
        segment10: false,
        segment11: false,
        segment12: false
      },
      get_data_flag: false,
      sel_concate_segment: '',
      check_duplicate_code: '',
      check_duplicate_description: '',
      //check validate form
      errorForms: [],
      successForm: false,
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      account_id: this.defaultValue ? this.defaultValue.account_id : ''
    };
  },
  watch: {
    errors: {
      handler: function handler(val) {
        val.segmentOverride ? this.setError('segmentOverride') : this.resetError('segmentOverride');
        val.account_code ? this.setError('account_code') : this.resetError('account_code');
        val.description ? this.setError('description') : this.resetError('description'); // val.segment1  ? this.setError('segment1')  : this.resetError('segment1');
        // val.segment2  ? this.setError('segment2')  : this.resetError('segment2');
        // val.segment3  ? this.setError('segment3')  : this.resetError('segment3');
        // val.segment4  ? this.setError('segment4')  : this.resetError('segment4');
        // val.segment5  ? this.setError('segment5')  : this.resetError('segment5');
        // val.segment6  ? this.setError('segment6')  : this.resetError('segment6');
        // val.segment7  ? this.setError('segment7')  : this.resetError('segment7');
        // val.segment8  ? this.setError('segment8')  : this.resetError('segment8');
        // val.segment9  ? this.setError('segment9')  : this.resetError('segment9');
        // val.segment10 ? this.setError('segment10') : this.resetError('segment10');
        // val.segment11 ? this.setError('segment11') : this.resetError('segment11');
        // val.segment12 ? this.setError('segment12') : this.resetError('segment12');
      },
      deep: true
    },
    successForm: function () {
      var _successForm = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                if (this.successForm) {
                  if (!this.errorForms.length) {
                    submitForm.submit();
                  }
                }

              case 1:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this);
      }));

      function successForm() {
        return _successForm.apply(this, arguments);
      }

      return successForm;
    }()
  },
  methods: {
    checkDuplicateCode: function checkDuplicateCode() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this.check_duplicate_code = '';
                axios.get("/ir/ajax/validate-account-mapping", {
                  params: {
                    type: 'code',
                    account_code: _this.account_code
                  }
                }).then(function (res) {
                  _this.check_duplicate_code = res.data;

                  if (_this.check_duplicate_code) {
                    swal({
                      title: "มีข้อผิดพลาด",
                      text: 'Code ซ้ำกับในระบบ',
                      timer: 5000,
                      type: "error",
                      showCancelButton: false,
                      showConfirmButton: false
                    });
                    _this.account_code = '';
                  }
                })["catch"](function (err) {});

              case 2:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    checkDuplicateDscription: function checkDuplicateDscription() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _this2.check_duplicate_description = '';
                axios.get("/ir/ajax/validate-account-mapping", {
                  params: {
                    type: 'description',
                    description: _this2.description
                  }
                }).then(function (res) {
                  _this2.check_duplicate_description = res.data;

                  if (_this2.check_duplicate_description) {
                    swal({
                      title: "มีข้อผิดพลาด",
                      text: 'description ซ้ำกับในระบบ',
                      timer: 5000,
                      type: "error",
                      showCancelButton: false,
                      showConfirmButton: false
                    });
                    _this2.description = '';
                  } // else {
                  // }

                })["catch"](function (err) {});

              case 2:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    updateCoa: function updateCoa(res) {
      if (res.name == this.defaultValueSetName.segment1) {
        this.segment1 = res.segment1;
      }

      if (res.name == this.defaultValueSetName.segment2) {
        this.segment2 = res.segment2;
      }

      if (res.name == this.defaultValueSetName.segment3) {
        this.segment3 = res.segment3;
        this.segment4 = '';
        this.option3 = res.options;
      }

      if (res.name == this.defaultValueSetName.segment4) {
        this.segment4 = res.segment4;
        this.option4 = res.options;
      }

      if (res.name == this.defaultValueSetName.segment5) {
        this.segment5 = res.segment5;
        this.option5 = res.options;
      }

      if (res.name == this.defaultValueSetName.segment6) {
        this.segment6 = res.segment6;
        this.segment7 = '';
        this.option6 = res.options;
      }

      if (res.name == this.defaultValueSetName.segment7) {
        this.segment7 = res.segment7;
        this.option7 = res.options;
      }

      if (res.name == this.defaultValueSetName.segment8) {
        this.segment8 = res.segment8;
        this.option8 = res.options;
      }

      if (res.name == this.defaultValueSetName.segment9) {
        this.segment9 = res.segment9;
        this.segment10 = '';
        this.option9 = res.options;
      }

      if (res.name == this.defaultValueSetName.segment10) {
        this.segment10 = res.segment10;
        this.option10 = res.options;
      }

      if (res.name == this.defaultValueSetName.segment11) {
        this.segment11 = res.segment11;
        this.option11 = res.options;
      }

      if (res.name == this.defaultValueSetName.segment12) {
        this.segment12 = res.segment12;
        this.option12 = res.options;
      }
    },
    enterAccSegment: function enterAccSegment() {
      var _this3 = this;

      var form = $('#modal-flexfield');
      var valid = true;
      var errorMsg;
      this.errors.segmentOverride = false;
      $(form).find("div[id='el_explode_segment']").html("");
      var coa = this.coaEnter.split('.');

      if (coa.length != 12) {
        swal({
          title: "Warning",
          text: 'กรอกชุดบัญชีไม่ครบ กรุณาตรวจสอบ',
          timer: 3000,
          type: "error",
          showCancelButton: false,
          showConfirmButton: false
        });
        this.errors.segmentOverride = true;
        valid = false;
        errorMsg = "กรอกชุดบัญชีไม่ครบ กรุณาตรวจสอบ";
        $(form).find("div[id='el_explode_segment']").html(errorMsg);
        this.segment1 = '';
        this.segment2 = '';
        this.segment3 = '';
        this.segment4 = '';
        this.segment5 = '';
        this.segment6 = '';
        this.segment7 = '';
        this.segment8 = '';
        this.segment9 = '';
        this.segment10 = '';
        this.segment11 = '';
        this.segment12 = '';
        return;
      }

      if (coa[0] == '' || coa[1] == '' || coa[2] == '' || coa[3] == '' || coa[4] == '' || coa[5] == '' || coa[6] == '' || coa[7] == '' || coa[8] == '' || coa[9] == '' || coa[10] == '' || coa[11] == '') {
        swal({
          title: "Warning",
          text: 'กรอกชุดบัญชีไม่ครบ กรุณาตรวจสอบ',
          timer: 3000,
          type: "error",
          showCancelButton: false,
          showConfirmButton: false
        });
        this.errors.segmentOverride = true;
        valid = false;
        errorMsg = "กรอกชุดบัญชีไม่ครบ กรุณาตรวจสอบ";
        $(form).find("div[id='el_explode_segment']").html(errorMsg);
        this.segment1 = '';
        this.segment2 = '';
        this.segment3 = '';
        this.segment4 = '';
        this.segment5 = '';
        this.segment6 = '';
        this.segment7 = '';
        this.segment8 = '';
        this.segment9 = '';
        this.segment10 = '';
        this.segment11 = '';
        this.segment12 = '';
        return;
      } else {
        axios.get("/ir/ajax/validate-combination", {
          params: {
            segmentAlls: coa,
            account_code: this.coaEnter
          }
        }).then(function (res) {
          if (res.data['status'] == 'E') {
            swal({
              title: "Warning",
              text: res.data['error_msg'],
              type: "warning"
            });
            _this3.errors.segmentOverride = true;
            valid = false;
            errorMsg = "กรอกชุดบัญชีไม่ครบ กรุณาตรวจสอบ";
            $(form).find("div[id='el_explode_segment']").html(errorMsg);
            _this3.segment1 = '';
            _this3.segment2 = '';
            _this3.segment3 = '';
            _this3.segment4 = '';
            _this3.segment5 = '';
            _this3.segment6 = '';
            _this3.segment7 = '';
            _this3.segment8 = '';
            _this3.segment9 = '';
            _this3.segment10 = '';
            _this3.segment11 = '';
            _this3.segment12 = '';
            return;
          } else if (res.data['status'] == 'S') {
            _this3.segment1 = coa[0];
            _this3.segment2 = coa[1];
            _this3.segment3 = coa[2];
            _this3.segment4 = coa[3];
            _this3.segment5 = coa[4];
            _this3.segment6 = coa[5];
            _this3.segment7 = coa[6];
            _this3.segment8 = coa[7];
            _this3.segment9 = coa[8];
            _this3.segment10 = coa[9];
            _this3.segment11 = coa[10];
            _this3.segment12 = coa[11];
            return;
          }
        });
      }
    },
    clearAccSegment: function clearAccSegment() {
      var form = $('#modal-flexfield');
      var valid = true;
      var errorMsg;
      this.errors.segmentOverride = false;
      $(form).find("div[id='el_explode_segment']").html("");
      this.coaEnter = '';
      this.segment1 = '';
      this.segment2 = '';
      this.segment3 = '';
      this.segment4 = '';
      this.segment5 = '';
      this.segment6 = '';
      this.segment7 = '';
      this.segment8 = '';
      this.segment9 = '';
      this.segment10 = '';
      this.segment11 = '';
      this.segment12 = '';
      return;
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
      vm.errors.account_code = res.err.account_code;
      vm.errors.description = res.err.description;
      vm.errors.segment1 = res.err.segment1;
      vm.errors.segment2 = res.err.segment2;
      vm.errors.segment3 = res.err.segment3;
      vm.errors.segment4 = res.err.segment4;
      vm.errors.segment5 = res.err.segment5;
      vm.errors.segment6 = res.err.segment6;
      vm.errors.segment7 = res.err.segment7;
      vm.errors.segment8 = res.err.segment8;
      vm.errors.segment9 = res.err.segment9;
      vm.errors.segment10 = res.err.segment10;
      vm.errors.segment11 = res.err.segment11;
      vm.errors.segment12 = res.err.segment12;
    },
    submit: function submit() {
      var _this4 = this;

      console.log('submit func');
      var account_code = this.segment1 + '.' + this.segment2 + '.' + this.segment3 + '.' + this.segment4 + '.' + this.segment5 + '.' + this.segment6 + '.' + this.segment7 + '.' + this.segment8 + '.' + this.segment9 + '.' + this.segment10 + '.' + this.segment11 + '.' + this.segment12;
      var coa = account_code.split('.');
      axios.get("/ir/ajax/validate-combination", {
        params: {
          segmentAlls: coa,
          account_code: account_code
        }
      }).then(function (res) {
        if (res.data['status'] == 'E') {
          swal({
            title: "Warning",
            text: res.data['error_msg'],
            type: "warning"
          });
          _this4.segment1 = '';
          _this4.segment2 = '';
          _this4.segment3 = '';
          _this4.segment4 = '';
          _this4.segment5 = '';
          _this4.segment6 = '';
          _this4.segment7 = '';
          _this4.segment8 = '';
          _this4.segment9 = '';
          _this4.segment10 = '';
          _this4.segment11 = '';
          _this4.segment12 = '';
          return;
        } else if (res.data['status'] == 'S') {
          _this4.checkForm();
        }
      });
    },
    checkForm: function checkForm(e) {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        var vm, submitForm, inputs, valid, errorMsg;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                vm = _this5;
                submitForm = $('#submitForm');
                inputs = submitForm.serialize();
                vm.errorForms = [];
                valid = true;
                errorMsg = '';
                vm.errors.account_code = false;
                vm.errors.description = false;
                vm.errors.segment1 = false;
                vm.errors.segment2 = false;
                vm.errors.segment3 = false;
                vm.errors.segment4 = false;
                vm.errors.segment5 = false;
                vm.errors.segment6 = false;
                vm.errors.segment7 = false;
                vm.errors.segment8 = false;
                vm.errors.segment9 = false;
                vm.errors.segment10 = false;
                vm.errors.segment11 = false;
                vm.errors.segment12 = false;
                $(submitForm).find("div[id='el_explode_account_code']").html("");
                $(submitForm).find("div[id='el_explode_description']").html("");
                $(submitForm).find("div[id='el_explode_segment1']").html("");
                $(submitForm).find("div[id='el_explode_segment2']").html("");
                $(submitForm).find("div[id='el_explode_segment3']").html("");
                $(submitForm).find("div[id='el_explode_segment4']").html("");
                $(submitForm).find("div[id='el_explode_segment5']").html("");
                $(submitForm).find("div[id='el_explode_segment6']").html("");
                $(submitForm).find("div[id='el_explode_segment7']").html("");
                $(submitForm).find("div[id='el_explode_segment8']").html("");
                $(submitForm).find("div[id='el_explode_segment9']").html("");
                $(submitForm).find("div[id='el_explode_segment10']").html("");
                $(submitForm).find("div[id='el_explode_segment11']").html("");
                $(submitForm).find("div[id='el_explode_segment12']").html("");

                if (!vm.account_code) {
                  vm.errorForms.push('Code');
                  swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: vm.errorForms,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                  });
                  vm.errors.account_code = true;
                  valid = false;
                  errorMsg = "กรุณาระบุ Code";
                  $(submitForm).find("div[id='el_explode_account_code']").html(errorMsg);
                } else {
                  if (!vm.disableEdit) {
                    vm.check_duplicate_code = '';
                    axios.get("/ir/ajax/validate-account-mapping", {
                      params: {
                        type: 'code',
                        account_code: vm.account_code
                      }
                    }).then(function (res) {
                      vm.check_duplicate_code = res.data;

                      if (vm.check_duplicate_code) {
                        swal({
                          title: "มีข้อผิดพลาด",
                          text: 'Code ซ้ำกับในระบบ',
                          timer: 5000,
                          type: "error",
                          showCancelButton: false,
                          showConfirmButton: false
                        });
                      } else {
                        vm.successForm = true;
                      }
                    })["catch"](function (err) {});
                  }
                }

                if (!vm.description) {
                  vm.errorForms.push('Description');
                  swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: vm.errorForms,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                  });
                  vm.errors.description = true;
                  valid = false;
                  errorMsg = "กรุณาระบุ Description";
                  $(submitForm).find("div[id='el_explode_description']").html(errorMsg);
                } else {
                  vm.check_duplicate_description = '';
                  axios.get("/ir/ajax/validate-account-mapping", {
                    params: {
                      type: 'description',
                      description: vm.description,
                      account_id: vm.account_id
                    }
                  }).then(function (res) {
                    vm.check_duplicate_description = res.data;

                    if (vm.check_duplicate_description) {
                      vm.errorForms.push('description ซ้ำกับในระบบ');
                      swal({
                        title: "มีข้อผิดพลาด",
                        text: vm.errorForms,
                        timer: 5000,
                        type: "error",
                        showCancelButton: false,
                        showConfirmButton: false
                      });
                    } else {
                      vm.successForm = true;
                    }
                  })["catch"](function (err) {});
                }

                if (!vm.segment1) {
                  vm.errorForms.push('COMPANY');
                  swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: vm.errorForms,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                  });
                  vm.errors.segment1 = true;
                  valid = false;
                  errorMsg = "กรุณาเลือก COMPANY";
                  $(submitForm).find("div[id='el_explode_segment1']").html(errorMsg);
                }

                if (!vm.segment2) {
                  vm.errorForms.push('EVM');
                  swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: vm.errorForms,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                  });
                  vm.errors.segment2 = true;
                  valid = false;
                  errorMsg = "กรุณาเลือก EVM";
                  $(submitForm).find("div[id='el_explode_segment2']").html(errorMsg);
                }

                if (!vm.segment3) {
                  vm.errorForms.push('DEPARTMENT');
                  swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: vm.errorForms,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                  });
                  vm.errors.segment3 = true;
                  valid = false;
                  errorMsg = "กรุณาเลือก DEPARTMENT";
                  $(submitForm).find("div[id='el_explode_segment3']").html(errorMsg);
                }

                if (!vm.segment4) {
                  vm.errorForms.push('COST CENTER');
                  swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: vm.errorForms,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                  });
                  vm.errors.segment4 = true;
                  valid = false;
                  errorMsg = "กรุณาเลือก COST CENTER";
                  $(submitForm).find("div[id='el_explode_segment4']").html(errorMsg);
                }

                if (!vm.segment5) {
                  vm.errorForms.push('BUDGET YEAR');
                  swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: vm.errorForms,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                  });
                  vm.errors.segment5 = true;
                  valid = false;
                  errorMsg = "กรุณาเลือก BUDGET YEAR";
                  $(submitForm).find("div[id='el_explode_segment5']").html(errorMsg);
                }

                if (!vm.segment6) {
                  vm.errorForms.push('BUDGET TYPE');
                  swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: vm.errorForms,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                  });
                  vm.errors.segment6 = true;
                  valid = false;
                  errorMsg = "กรุณาเลือก BUDGET TYPE";
                  $(submitForm).find("div[id='el_explode_segment6']").html(errorMsg);
                }

                if (!vm.segment7) {
                  vm.errorForms.push('BUDGET DETAIL');
                  swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: vm.errorForms,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                  });
                  vm.errors.segment7 = true;
                  valid = false;
                  errorMsg = "กรุณาเลือก BUDGET DETAIL";
                  $(submitForm).find("div[id='el_explode_segment7']").html(errorMsg);
                }

                if (!vm.segment8) {
                  vm.errorForms.push('BUDGET REASON');
                  swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: vm.errorForms,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                  });
                  vm.errors.segment8 = true;
                  valid = false;
                  errorMsg = "กรุณาเลือก BUDGET REASON";
                  $(submitForm).find("div[id='el_explode_segment8']").html(errorMsg);
                }

                if (!vm.segment9) {
                  vm.errorForms.push('MAIN ACCOUNT');
                  swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: vm.errorForms,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                  });
                  vm.errors.segment9 = true;
                  valid = false;
                  errorMsg = "กรุณาเลือก MAIN ACCOUNT";
                  $(submitForm).find("div[id='el_explode_segment9']").html(errorMsg);
                }

                if (!vm.segment10) {
                  vm.errorForms.push('SUB ACCOUNT');
                  swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: vm.errorForms,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                  });
                  vm.errors.segment10 = true;
                  valid = false;
                  errorMsg = "กรุณาเลือก SUB ACCOUNT";
                  $(submitForm).find("div[id='el_explode_segment10']").html(errorMsg);
                }

                if (!vm.segment11) {
                  vm.errorForms.push('RESERVED1');
                  swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: vm.errorForms,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                  });
                  vm.errors.segment11 = true;
                  valid = false;
                  errorMsg = "กรุณาเลือก RESERVED1";
                  $(submitForm).find("div[id='el_explode_segment11']").html(errorMsg);
                }

                if (!vm.segment12) {
                  vm.errorForms.push('RESERVED2');
                  swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: vm.errorForms,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                  });
                  vm.errors.segment12 = true;
                  valid = false;
                  errorMsg = "กรุณาเลือก RESERVED2";
                  $(submitForm).find("div[id='el_explode_segment12']").html(errorMsg);
                }

                if (vm.successForm) {
                  if (!vm.errorForms.length) {
                    submitForm.submit();
                  }
                }

                if (!vm.errorForms.length) {
                  if (vm.successForm) {
                    submitForm.submit();
                  }
                }

                e.preventDefault();

              case 51:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/account-mapping/AccountCodeComponent.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/account-mapping/AccountCodeComponent.vue?vue&type=style&index=0&scope=true&lang=css& ***!
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
___CSS_LOADER_EXPORT___.push([module.id, ".mx-datepicker {\n  height: 32px;\n  /*padding-top: 1px;*/\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/account-mapping/AccountCodeComponent.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/account-mapping/AccountCodeComponent.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_AccountCodeComponent_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./AccountCodeComponent.vue?vue&type=style&index=0&scope=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/account-mapping/AccountCodeComponent.vue?vue&type=style&index=0&scope=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_AccountCodeComponent_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_AccountCodeComponent_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/components/ir/account-mapping/AccountCodeComponent.vue":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/ir/account-mapping/AccountCodeComponent.vue ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _AccountCodeComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./AccountCodeComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/account-mapping/AccountCodeComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _AccountCodeComponent_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./AccountCodeComponent.vue?vue&type=style&index=0&scope=true&lang=css& */ "./resources/js/components/ir/account-mapping/AccountCodeComponent.vue?vue&type=style&index=0&scope=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");
var render, staticRenderFns
;

;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _AccountCodeComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default,
  render,
  staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/account-mapping/AccountCodeComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/account-mapping/AccountCodeComponent.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/components/ir/account-mapping/AccountCodeComponent.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AccountCodeComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./AccountCodeComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/account-mapping/AccountCodeComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AccountCodeComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/account-mapping/AccountCodeComponent.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!*************************************************************************************************************************!*\
  !*** ./resources/js/components/ir/account-mapping/AccountCodeComponent.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \*************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_AccountCodeComponent_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./AccountCodeComponent.vue?vue&type=style&index=0&scope=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/account-mapping/AccountCodeComponent.vue?vue&type=style&index=0&scope=true&lang=css&");


/***/ })

}]);