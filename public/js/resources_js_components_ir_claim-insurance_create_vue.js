(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ir_claim-insurance_create_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/create.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/create.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _form_claim__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./form-claim */ "./resources/js/components/ir/claim-insurance/form-claim.vue");
/* harmony import */ var _scripts__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../scripts */ "./resources/js/components/ir/scripts.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_2__);
//
//
//
//
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
  name: 'ir-claim-insurance-create',
  data: function data() {
    return {
      claim: {
        headers: {
          claim_header_id: '',
          status: '',
          document_number: '',
          accident_date: '',
          accident_time: '',
          location_code: '',
          location_name: '',
          department_code: '',
          department_name: '',
          requestor_id: '',
          requestor_name: '',
          requestor_tel: '',
          claim_amount: '',
          // files: [],
          year: moment__WEBPACK_IMPORTED_MODULE_2___default()().format('YYYY')
        },
        group: [],
        ////
        flag: 'add'
      },
      action: 'add',
      funcs: _scripts__WEBPACK_IMPORTED_MODULE_1__.funcs,
      vars: _scripts__WEBPACK_IMPORTED_MODULE_1__.vars
    };
  },
  components: {
    formClaimInsurance: _form_claim__WEBPACK_IMPORTED_MODULE_0__.default
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/form-claim.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/form-claim.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _lovDepartment__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./lovDepartment */ "./resources/js/components/ir/claim-insurance/lovDepartment.vue");
/* harmony import */ var _components_currencyInputGroupAppend__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/currencyInputGroupAppend */ "./resources/js/components/ir/components/currencyInputGroupAppend.vue");
/* harmony import */ var _lovCompany__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./lovCompany */ "./resources/js/components/ir/claim-insurance/lovCompany.vue");
/* harmony import */ var _lovLocation__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./lovLocation */ "./resources/js/components/ir/claim-insurance/lovLocation.vue");
/* harmony import */ var _components_calendar_dateInput__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../components/calendar/dateInput */ "./resources/js/components/ir/components/calendar/dateInput.vue");
/* harmony import */ var _modalDetails__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./modalDetails */ "./resources/js/components/ir/claim-insurance/modalDetails.vue");
/* harmony import */ var _components_currencyInput__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../components/currencyInput */ "./resources/js/components/ir/components/currencyInput.vue");
/* harmony import */ var _headerForm__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./headerForm */ "./resources/js/components/ir/claim-insurance/headerForm.vue");
/* harmony import */ var _policyHeaderForm__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./policyHeaderForm */ "./resources/js/components/ir/claim-insurance/policyHeaderForm.vue");
/* harmony import */ var _lovPolicyGroup__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./lovPolicyGroup */ "./resources/js/components/ir/claim-insurance/lovPolicyGroup.vue");
/* harmony import */ var _lovPolicySetHeaderId__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./lovPolicySetHeaderId */ "./resources/js/components/ir/claim-insurance/lovPolicySetHeaderId.vue");
/* harmony import */ var _lovCompanyPolicyGroup__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ./lovCompanyPolicyGroup */ "./resources/js/components/ir/claim-insurance/lovCompanyPolicyGroup.vue");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_12___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_12__);
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && Symbol.iterator in Object(iter)) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  name: 'ir-claim-insurance-form',
  data: function data() {
    return {
      rules: {
        headers: {
          accident_date: [{
            required: true,
            message: 'กรุณาระบุวันที่เกิดเหตุ',
            trigger: 'blur'
          }],
          accident_time: [{
            required: true,
            message: 'กรุณาระบุเวลาเกิดเหตุ',
            trigger: 'blur'
          }],
          location_name: [{
            required: true,
            message: 'กรุณาระบุสถานที่',
            trigger: 'blur'
          }],
          department_code: [{
            required: true,
            message: 'กรุณาระบุหน่วยงาน',
            trigger: 'change'
          }],
          requestor_name: [{
            required: true,
            message: 'กรุณาระบุผู้แจ้งเหตุ',
            trigger: 'change'
          }],
          requestor_tel: [{
            required: true,
            message: 'กรุณาระบุเบอร์โทรผู้แจ้งเหตุ',
            trigger: 'change'
          }],
          claim_amount: [{
            required: true,
            message: 'กรุณาระบุจำนวนเงินเรียกชดใช้รวม',
            trigger: 'change'
          }]
        },
        group: {
          company: [{
            company_id: [{
              required: true,
              message: 'กรุณาระบุบริษัทประกันภัย',
              trigger: 'change'
            }],
            claim_percent: [{
              required: true,
              message: 'กรุณาระบุสัดส่วน',
              trigger: 'change'
            }, {
              type: 'number',
              message: 'กรุณาระบุเป็นตัวเลขเท่านั้น'
            }],
            claim_amount: [{
              required: true,
              message: 'กรุณาระบุจำนวนเงิน',
              trigger: 'change'
            }]
          }],
          amount: [{
            required: true,
            message: 'กรุณาระบุจำนวนเงินชดใช้',
            trigger: 'change'
          }],
          detail: [{
            line_description: [{
              required: true,
              message: 'กรุณาระบุรายละเอียด',
              trigger: 'change'
            }],
            line_amount: [{
              required: true,
              message: 'กรุณาระบุจำนวน',
              trigger: 'change'
            }]
          }],
          details: [{
            required: true,
            message: 'กรุณาระบุรายละเอียดให้ครบ',
            trigger: 'change'
          }]
        },
        req_modal: [{
          required: true,
          message: 'กรุณาระบุ Invoice / GL Date',
          trigger: 'change'
        }],
        companies: [{
          required: true,
          message: 'กรุณาระบุรายการเคลม',
          trigger: 'change'
        }]
      },
      index_comp: 0,
      index_group: 0,
      details: {},
      accident_time: '',
      confirm: false,
      fileList: [],
      btn: '',
      btnConfirm: false,
      files: [],
      resData: [],
      companies_percent: []
    };
  },
  props: ['claim', 'isNullOrUndefined', 'checkStatusInterface', 'checkStatusConfirmed', 'checkStatusCancelled', 'action', 'setYearCE', 'vars'],
  computed: {
    checkColumnPercent: function checkColumnPercent() {
      // let claim_percent = this.claim.group.reduce((sum, row) => {
      //   if (row.company.claim_percent === '') {
      //     return sum + 0
      //   }
      //   return sum + parseInt(row.company.claim_percent)
      // }, 0)
      // return claim_percent
      var companies = [];
      this.claim.group.forEach(function (element) {
        companies = _toConsumableArray(element.company.map(function (item) {
          return {
            claim_percent: item.claim_percent
          };
        }));
      });
      console.log('companies ', companies);
      var claim_percent = companies.reduce(function (sum, comp) {
        if (comp.claim_percent === '') {
          return sum + 0;
        }

        return sum + parseInt(comp.claim_percent);
      }, 0);
      console.log('claim_percent ', claim_percent);
      return claim_percent;
    },
    statusHeader: function statusHeader() {
      if (this.action === 'add') {
        return 'NEW';
      } else if (this.action === 'edit' && this.checkStatusInterface(this.claim.headers.status)) {
        return 'INTERFACE';
      } else {
        return 'PENDING';
      }
    },
    checkColumnLineAmountDetails: function checkColumnLineAmountDetails() {
      console.log('checkColumnLineAmountDetails ', this.claim.group);
      var line_amount = 0;
      var comds = [];
      var details = [];
      var validDetails = [];
      this.claim.group.forEach(function (element) {
        comds = [].concat(_toConsumableArray(comds), _toConsumableArray(element.company.map(function (item) {
          return item;
        })));
      });
      console.log('comds ', comds);
      comds.forEach(function (element) {
        details = [].concat(_toConsumableArray(details), _toConsumableArray(element.detail.map(function (item) {
          return {
            line_amount: item.line_amount
          };
        })));
      });
      console.log('details ', details);
      line_amount = details.reduce(function (sum, row) {
        if (row.line_amount === '') {
          return sum + 0;
        }

        return sum + parseFloat(row.line_amount);
      }, 0);
      console.log('line_amount ', line_amount);
      return line_amount;
    },
    checkColumnClaimAmountComp: function checkColumnClaimAmountComp() {
      console.log('checkColumnClaimAmountComp ', this.claim.group);
      var claim_amount = 0;
      var comps = [];
      this.claim.group.forEach(function (element) {
        comps = [].concat(_toConsumableArray(comps), _toConsumableArray(element.company.map(function (item) {
          console.log('comps ', element);
          return item;
        })));
      });
      console.log('comps ', comps);
      claim_amount = comps.reduce(function (sum, row) {
        if (row.claim_amount === '') {
          return sum + 0;
        }

        return sum + parseFloat(row.claim_amount);
      }, 0);
      console.log('claim_amount ', claim_amount);
      return claim_amount;
    }
  },
  methods: {
    getDataDepartment: function getDataDepartment(obj) {
      this.claim.headers.department_code = obj.code;
      this.claim.headers.department_name = obj.desc;
    },
    clickSave: function clickSave() {
      var _this2 = this;

      var formData = new FormData();
      formData.append('file', this.fileList);
      console.log('clickSave ', this.claim.group, this.fileList, formData);
      var save = 'save';
      this.btn = save;
      this.checkBtnSaveOrConfirm(save);

      var _this = this;

      this.$refs.claim_insurance.validate(function (validClaim) {
        if (validClaim) {
          _this2.$refs.claim_apply_companies.validate(function (validApply) {
            if (validApply) {
              if (_this2.checkColumnPercent === 100) {
                // console.log('this.checkReqTableDetails ', _this.checkReqTableDetails())
                // // // _this.$refs.claim_apply_details.validate((validDetails) => {
                //   if (_this.checkReqTableDetails()) {
                //   // if (validDetails) {
                _this.setPropertySaveAndConfirm(_this.claim, save);

                console.log('save ', _this.claim); // }
                // // })
              } else {
                swal("Warning", 'คอลัมน์สัดส่วนรวมกันต้องเท่ากับ 100%', "warning");
              }
            } else {
              console.log('error submit!');
              return false;
            }
          });
        } else {
          console.log('error submit!');
          return false;
        }
      });
      var companies = [];
      var validCompanies = [];
      this.claim.group.forEach(function (element) {
        companies = [].concat(_toConsumableArray(companies), _toConsumableArray(element.company.map(function (item) {
          return {
            company_id: item.company_id,
            claim_percent: item.claim_percent
          };
        })));
      });
      console.log('companies ', companies);
      validCompanies = companies.filter(function (f) {
        return f.company_id == "" || f.claim_percent == "";
      });
      console.log('validCompanies ', validCompanies); // let modal = [];
      // let validModal = [];
      // this.claim.group.forEach(element => {
      //   modal = [...modal, ...element.company.map(item => {
      //     return {
      //       invoice_date: item.modal.invoice_date,
      //       gl_date: item.modal.gl_date
      //     };
      //   })]
      // });
      // console.log('modal ', modal)
      // validModal = modal.filter(f => f.invoice_date == "" || f.gl_date == "");
      // console.log('validModal ', validModal)

      var comds = [];
      var details = [];
      var validDetails = [];
      this.claim.group.forEach(function (element) {
        comds = [].concat(_toConsumableArray(comds), _toConsumableArray(element.company.map(function (item) {
          return item;
        })));
      });
      console.log('comds ', comds);
      comds.forEach(function (element) {
        details = [].concat(_toConsumableArray(details), _toConsumableArray(element.detail.map(function (item) {
          return {
            line_description: item.line_description,
            line_amount: item.line_amount
          };
        })));
      });
      console.log('details ', details);
      validDetails = details.filter(function (f) {
        return f.line_description == "" || f.line_amount == "";
      });
      console.log('validDetails ', validDetails); // if (validCompanies.length > 0 && validModal.length === 0) {

      if (validCompanies.length > 0) {
        swal("Warning", 'กรุณากรอกข้อมูลรายการเคลมให้ครบ!', "warning");
        return false;
      } // else if (validModal.length > 0 && validCompanies.length === 0) {
      //   swal("Warning", 'กรุณากรอก Invoice Date และ GL Date!', "warning");
      //   return false;
      // } 
      // else if (validCompanies.length > 0 && validModal.length > 0) {
      else if (validCompanies.length > 0) {
          swal("Warning", 'กรุณากรอกข้อมูลรายการเคลมให้ครบ!', "warning");
        } else if (validDetails.length > 0) {
          swal("Warning", 'กรุณากรอกข้อมูลรายละเอียดให้ครบ!', "warning"); // } else if (!this.checkColumnClaimAmountComp) {
          //   swal("Warning", 'กรุณาระบุจำนวนเงินให้ถูกต้องตามสัดส่วน!', "warning");
        } else {
          return false;
        }

      ;
    },
    clickCancel: function clickCancel() {
      window.location.href = '/ir/claim-insurance';
    },
    clickConfirm: function clickConfirm() {
      var confirm = 'confirm';
      this.btn = confirm;
      this.checkBtnSaveOrConfirm(confirm);

      var _this = this;

      console.log('clickConfirm ', this.btn, this.btnConfirm); // if (this.btnConfirm) {

      _this.$refs.claim_insurance.validate(function (validClaim) {
        if (validClaim) {
          _this.$refs.claim_apply_companies.validate(function (validCompany) {
            if (validCompany) {// if (_this.checkColumnPercent === 100) {
              // // _this.$refs.claim_apply_details.validate((validDetails) => {
              //   if (_this.checkReqTableDetails()) {
              //   // if (validDetails) {
              // _this.setPropertySaveAndConfirm( _this.claim, confirm)
              // console.log('confirmed ', _this.claim)
              //   }
              // // })
              // } else {
              //   swal("Warning", 'คอลัมน์สัดส่วนรวมกันต้องเท่ากับ 100%', "warning");
              // }
            } else {
              console.log('validCompany error submit!');
              return false;
            }
          }); // this.$refs.claim_apply_companies.validate((validCompany) => {
          //   if (validCompany) {
          //     if (this.checkColumnPercent < 100) {
          //       let param = {
          //         status: 'CONFIRMED'
          //       }
          //       console.log('confirmed ', this.claim)
          //     } else {
          //       swal("Warning", 'คอลัมน์สัดส่วนรวมกันต้องเท่ากับ 100%', "warning");
          //     }
          //   } else {
          //     console.log('validCompany error submit!')
          //     return false;
          //   }
          // })

        } else {
          console.log('validClaim error submit!');
          return false;
        }
      }); // }


      var companies = [];
      var validCompanies = [];
      this.claim.group.forEach(function (element) {
        companies = [].concat(_toConsumableArray(companies), _toConsumableArray(element.company.map(function (item) {
          return {
            company_id: item.company_id,
            claim_percent: item.claim_percent
          };
        })));
      });
      console.log('companies ', companies);
      validCompanies = companies.filter(function (f) {
        return f.company_id == "" || f.claim_percent == "";
      });
      console.log('validCompanies ', validCompanies);
      var modal = [];
      var validModal = [];
      this.claim.group.forEach(function (element) {
        modal = [].concat(_toConsumableArray(modal), _toConsumableArray(element.company.map(function (item) {
          return {
            invoice_date: item.modal.invoice_date,
            gl_date: item.modal.gl_date
          };
        })));
      });
      console.log('modal ', modal);
      validModal = modal.filter(function (f) {
        return f.invoice_date == "" || f.gl_date == "";
      });
      console.log('validModal ', validModal);
      var comds = [];
      var details = [];
      var validDetails = [];
      this.claim.group.forEach(function (element) {
        comds = [].concat(_toConsumableArray(comds), _toConsumableArray(element.company.map(function (item) {
          return item;
        })));
      });
      console.log('comds ', comds);
      comds.forEach(function (element) {
        details = [].concat(_toConsumableArray(details), _toConsumableArray(element.detail.map(function (item) {
          return {
            line_description: item.line_description,
            line_amount: item.line_amount
          };
        })));
      });
      console.log('details ', details);
      validDetails = details.filter(function (f) {
        return f.line_description == "" || f.line_amount == "";
      });
      console.log('validDetails ', validDetails);

      if (validCompanies.length > 0 && validModal.length === 0) {
        swal("Warning", 'กรุณากรอกข้อมูลรายการเคลมให้ครบ!', "warning");
      } else if (validModal.length > 0 && validCompanies.length === 0) {
        swal("Warning", 'กรุณากรอก Invoice Date และ GL Date!', "warning");
        return false;
      } else if (validCompanies.length > 0 && validModal.length > 0) {
        swal("Warning", 'กรุณากรอกข้อมูลรายการเคลมให้ครบ!', "warning");
      } else if (validDetails.length > 0) {
        swal("Warning", 'กรุณากรอกข้อมูลรายละเอียดให้ครบ!', "warning");
      } else if (_this.checkColumnPercent !== 100) {
        swal("Warning", 'คอลัมน์สัดส่วนรวมกันต้องเท่ากับ 100%', "warning");
      } else {
        _this.setPropertySaveAndConfirm(_this.claim, confirm);

        console.log('confirmed ', _this.claim);
      }
    },
    clickCreateClaimGroup: function clickCreateClaimGroup() {
      console.log('clickCreateClaimGroup', this.claim.group, this.checkColumnPercent); // this.btn = '';
      // this.$refs.claim_apply_companies.validate((valid) => {
      //   if (valid) {
      //     console.log('claim_apply_companies')
      //     if (this.claim.group.length === 0 || this.checkColumnPercent === 100) {
      //       console.log('trueeeee')

      this.claim.group.push({
        group_code: '',
        group_description: '',
        group_header_id: '',
        amount: '',
        group_set_id: '',
        policy_set_description: '',
        policy_set_header_id: '',
        company: [],
        showLovCompany: true,
        flag: 'add'
      }); // company: {
      //   company_id: '',
      //   company_name:'',
      //   claim_percent: '',
      //   claim_amount: ''
      // },
      // claim_apply_id: '',
      // detail: [{
      //   line_number: '1',
      //   line_description: '',
      //   line_amount: '',
      //   flag: 'add',
      // }],
      // flag: 'add',
      // req_modal: '',
      // modal: {
      //   informant_date: '',
      //   invoice_date: '',
      //   gl_date: '',
      //   ar_invoice_num: '',
      //   policy_number: '',
      //   ar_receipt_date: '',
      //   ar_receipt_number: '',
      //   ar_received_amount: ''
      // },
      // showLovCompany: true
      //       })   
      //     } else {
      //       swal("Warning", 'คอลัมน์สัดส่วนรวมกันต้องเท่ากับ 100%', "warning");
      //     }
      //   } else {
      //     console.log('error submit!')
      //     return false;
      //   }
      // })
      // let companies = [];
      // let validCompanies = [];
      // this.claim.group.forEach(element => {
      //  companies = [...companies, ...element.company.map(item => {
      //     return {
      //       company_id: item.company_id,
      //       claim_percent: item.claim_percent
      //     };
      //   })]
      // });
      // console.log('companies ', companies)
      // validCompanies = companies.filter(f => f.company_id == "" || f.claim_percent == "");
      // console.log('validCompanies ', validCompanies)
      // let modal = [];
      // let validModal = [];
      // this.claim.group.forEach(element => {
      //   modal = [...modal, ...element.company.map(item => {
      //     return {
      //       invoice_date: item.modal.invoice_date,
      //       gl_date: item.modal.gl_date
      //     };
      //   })]
      // });
      // console.log('modal ', modal)
      // validModal = modal.filter(f => f.invoice_date == "" || f.gl_date == "");
      // console.log('validModal ', validModal)
      // let comds = [];
      // let details = [];
      // let validDetails = [];
      // this.claim.group.forEach(element => {
      //   comds = [...comds, ...element.company.map(item => {
      //     return item;
      //   })]
      // });
      // console.log('comds ', comds)
      // comds.forEach(element => {
      //   details = [...details, ...element.detail.map(item => {
      //     return {
      //       line_description: item.line_description,
      //       line_amount: item.line_amount
      //     };
      //   })]
      // });
      // console.log('details ', details)
      // validDetails = details.filter(f => f.line_description == "" || f.line_amount == "");
      // console.log('validDetails ', validDetails)
      // if (validCompanies.length > 0 && validModal.length === 0) {
      //   swal("Warning", 'กรุณากรอกข้อมูลรายการเคลมให้ครบ!', "warning");
      //   // return false;
      // } else if (validModal.length > 0 && validCompanies.length === 0) {
      //   swal("Warning", 'กรุณากรอก Invoice Date และ GL Date!', "warning");
      //   // return false;
      // } else if (validCompanies.length > 0 && validModal.length > 0) {
      //   swal("Warning", 'กรุณากรอกข้อมูลรายการเคลมให้ครบ!', "warning");
      // }else if (validDetails.length > 0 ){
      //   swal("Warning", 'กรุณากรอกข้อมูลรายละเอียดให้ครบ!', "warning");
      // } else {
      //   return false;
      // }
      //   this.claim.group[index].company.push({
      //     company_id: '',
      //     company_name:'',
      //     claim_percent: '',
      //     claim_amount: '',
      //     detail: [{
      //       line_number: '1',
      //       line_description: '',
      //       line_amount: '',
      //       flag: 'add',
      //     }],
      //     req_modal: '',
      //     modal: {
      //       informant_date: '',
      //       invoice_date: '',
      //       gl_date: '',
      //       ar_invoice_num: '',
      //       policy_number: '',
      //       ar_receipt_date: '',
      //       ar_receipt_number: '',
      //       ar_received_amount: ''
      //     },
      //     flag: 'add',
      //     claim_apply_id: ''
      //   })
      //   return true;
      // }
    },
    changePercent: function changePercent(value, index, index_group) {
      console.log('changePercent ', value, index);
      this.claim.group[index_group].company[index].claim_percent = value;
      this.claim.group[index_group].company[index].claim_amount = value ? this.claim.group[index_group].amount * value / 100 : value;
      var claim_amount = this.claim.group[index_group].company[index].claim_amount;
      this.setDefaultLineAmountDetails(claim_amount, index, index_group); // if (value) {
      //   this.$refs.claim_apply_companies.fields.find((f) => f.prop == 'group.' + index + '.company.claim_percent').clearValidate()
      //   this.$refs.claim_apply_companies.fields.find((f) => f.prop == 'group.' + index + '.company.claim_amount').clearValidate()
      // } else {
      //   this.$refs.claim_apply_companies.validateField('group.' + index + '.company.claim_percent')
      //   this.$refs.claim_apply_companies.validateField('group.' + index + '.company.claim_amount')
      // }
    },
    getDataCompany: function getDataCompany(obj, index_comp, index_group) {
      console.log('getDataCompany ', obj);
      this.claim.group[index_group].company[index_comp].company_number = obj.code;
      this.claim.group[index_group].company[index_comp].company_name = obj.desc;
      this.claim.group[index_group].company[index_comp].company_id = obj.id;
    },
    clickAddDetails: function clickAddDetails(dataRow, index) {
      console.log('clickAddDetails ', this.claim, dataRow, index);
      var length = dataRow.detail.length; //  this.$refs.claim_apply_details.validate((validDetails) => {
      // if (validDetails) {

      dataRow.detail.push({
        line_number: length + 1,
        line_description: '',
        line_amount: '',
        flag: 'add'
      }); // } else {
      //   console.log('error submit!')
      //   return false;
      // }
      // })
    },
    getDataAmount: function getDataAmount(value, index) {
      console.log('getDataAmount ', value, this.claim.group);
      this.claim.group[index].amount = value; // this.claim.group[index].company.claim_amount = value * this.claim.group[index].company.claim_percent / 100
      // if (value) {
      //   this.$refs.claim_apply_companies.fields.find((f) => f.prop == 'group.'+ index + '.amount').clearValidate()
      // } else {
      //   this.$refs.claim_apply_companies.validateField('group.'+ index + '.amount')
      // }

      var amount_group = this.claim.group.reduce(function (sum, row) {
        if (row.amount === '') {
          return sum + 0;
        }

        return sum + parseFloat(row.amount);
      }, 0);
      console.log('amount_group ', amount_group);
      this.claim.headers.claim_amount = amount_group;
    },
    clickRemoveGroup: function clickRemoveGroup(dataRow, index) {
      var _this3 = this;

      console.log('clickRemoveG ', dataRow, index);

      if (dataRow.flag === 'add') {
        var _index = this.claim.group.indexOf(dataRow);

        console.log('index ', _index);

        if (_index > -1) {
          this.claim.group.splice(_index, 1);
          console.log('splice', this.claim.group);
        }
      } else {
        // let params = {
        //   claim_policy_group_rows: dataRow.claim_group_id,
        // claim_apply_id: dataRow.company_id
        // }
        // axios.delete(`/ir/ajax/claim/${this.claim.headers.claim_header_id}?claim_group_id=${dataRow.claim_group_id}`)
        axios["delete"]("/ir/ajax/claim/".concat(dataRow.claim_group_id)).then(function (_ref) {
          var data = _ref.data;
          console.log('remove response ', data);
          swal({
            title: "Success",
            text: data.message,
            type: "success",
            timer: 3000,
            showConfirmButton: false,
            closeOnConfirm: false
          });

          var index = _this3.claim.group.indexOf(dataRow);

          console.log('index ', index);

          if (index > -1) {
            _this3.claim.group.splice(index, 1);
          }

          var amount_group = _this3.claim.group.reduce(function (sum, row) {
            if (row.amount === '') {
              return sum + 0;
            }

            return sum + parseFloat(row.amount);
          }, 0);

          console.log('amount_group ', amount_group);
          _this3.claim.headers.claim_amount = amount_group;
        })["catch"](function (error) {
          swal("Error", error, "error");
        });
      }

      var amount_group = this.claim.group.reduce(function (sum, row) {
        if (row.amount === '') {
          return sum + 0;
        }

        return sum + parseFloat(row.amount);
      }, 0);
      console.log('amount_group ', amount_group);
      this.claim.headers.claim_amount = amount_group;
    },
    getAccidentDate: function getAccidentDate(obj) {
      this.claim.headers.accident_date = obj.value;

      if (obj.value) {
        this.$refs.claim_insurance.fields.find(function (f) {
          return f.prop == 'headers.accident_date';
        }).clearValidate();
      } else {
        this.$refs.claim_insurance.validateField('headers.accident_date');
      }
    },
    clickRemove: function clickRemove(dataRow, i, index_group) {
      var _this4 = this;

      console.log('clickRemove ', dataRow, i, this.claim.group, this.claim);

      if (dataRow.flag === 'add') {
        var index = this.claim.group[index_group].company.indexOf(dataRow);
        console.log('index ', index);

        if (index > -1) {
          this.claim.group[index_group].company.splice(i, 1);
          console.log('splice ', this.claim.group);
        } // } else if (dataRow.flag === 'edit' && this.checkColumnPercent === 100) {
        //   swal("Warning", 'คอลัมน์สัดส่วนรวมกันต้องเท่ากับ 100%', "warning");

      } else {
        axios["delete"]("/ir/ajax/claim/company/".concat(this.claim.headers.claim_header_id, "?claim_apply_id=").concat(dataRow.company_id)).then(function (_ref2) {
          var data = _ref2.data;
          console.log('remove response ', data);
          swal({
            title: "Success",
            text: data.message,
            type: "success",
            timer: 3000,
            showConfirmButton: false,
            closeOnConfirm: false
          });

          var index = _this4.claim.group[index_group].company.indexOf(dataRow);

          console.log('index ', index);

          if (index > -1) {
            _this4.claim.group[index_group].company.splice(i, 1);

            console.log('splice ', _this4.claim.group);
          }
        })["catch"](function (error) {
          swal("Error", error, "error");
        }); //  window.location.href = `'/ir/claim-insurance/edit/${this.claim.headers.claim_header_id}'`
      } // window.location.href = `'/ir/claim-insurance/edit/${this.claim.headers.claim_header_id}'`

    },
    clickModalDetails: function clickModalDetails(dataRow, index, index_group) {
      console.log('clickModalDetails ', dataRow, index, index_group);
      this.index_comp = index;
      this.index_group = index_group;
      this.details = dataRow.modal;
    },
    setPropertySaveAndConfirm: function setPropertySaveAndConfirm(data, btn) {
      var _this5 = this;

      console.log('setPropertySaveAndConfirm ', this.fileList); // this.checkBtnSaveOrConfirm(btn)

      var groups = data.group;
      var claim_policy_group_rows = [];
      var checkClaimAmountAndLineAmount = false; // let checkClaimAmountHeaderAndClaimAmountComp = false

      groups.filter(function (row) {
        var data = _objectSpread(_objectSpread({}, row), {}, {
          company_rows: row.company // line_rows: row.detail, 
          // ar_receipt_date: this.setYearCE('date', row.ar_receipt_date),
          // gl_date: this.setYearCE('date', row.gl_date),
          // informant_date: this.setYearCE('date', row.informant_date),
          // invoice_date: this.setYearCE('date', row.invoice_date)

        });

        row.company.filter(function (comp) {
          console.log('=== ', _this5.checkColumnLineAmountDetails, _this5.checkColumnClaimAmountComp, comp.claim_amount ? +comp.claim_amount : comp.claim_amount, comp.claim_amount);

          if (_this5.checkColumnLineAmountDetails === _this5.checkColumnClaimAmountComp) {
            checkClaimAmountAndLineAmount = true;
          } else {
            checkClaimAmountAndLineAmount = false;
          }
        }); // if (this.checkColumnClaimAmountComp === (this.claim.headers.claim_amount ? +this.claim.headers.claim_amount : this.claim.headers.claim_amount)) {
        //   // if(this.checkColumnClaimAmountComp === this.claim.headers.claim.group){
        //   checkClaimAmountHeaderAndClaimAmountComp = true
        // } else {
        //   checkClaimAmountHeaderAndClaimAmountComp = false
        // }

        claim_policy_group_rows.push(data);
      });
      var params = {
        data: {
          // ...data.headers,
          header: _objectSpread(_objectSpread({}, this.claim.headers), {}, {
            file: this.fileList,
            // accident_date: this.setYearCE('date', data.headers.accident_date),
            status: btn === 'save' ? this.statusHeader : btn === 'confirm' ? 'CONFIRMED' : ''
          }),
          claim_policy_group_rows: claim_policy_group_rows,
          program_code: 'IRP0010'
        }
      }; // let setParams = this.setFormData(params)
      // return params

      console.log('params ', params, this.checkColumnLineAmountDetails, checkClaimAmountAndLineAmount);

      if (checkClaimAmountAndLineAmount) {
        axios.post("/ir/ajax/claim", params).then(function (response) {
          var res = response.data.data;
          console.log(btn + ' response ', params, response, response.status);

          if (response.status === 200) {
            var setParams = _this5.setFormData(res);

            _this5.receivedUploadFile(setParams);
          }

          swal({
            title: "Success",
            text: data.message,
            type: "success",
            showConfirmButton: false,
            closeOnConfirm: false
          });
          window.location.href = '/ir/claim-insurance';
        }); // .catch((error) => {
        //   swal("Error", error, "error");
        // })
        // if (checkColumnClaimAmountComp) {
        // axios.post(`/ir/ajax/claim`, params)
        // .then((response) => {
        //   let res = response.data.data;
        //   console.log(btn + ' response ', params, response, response.status)
        //   if (response.status === 200) {
        //     let setParams = this.setFormData(res)
        //     this.receivedUploadFile(setParams)
        //   }
        //   swal({
        //     title: "Success",
        //     text: data.message,
        //     type: "success",
        //     showConfirmButton: false,
        //     closeOnConfirm: false
        //   });
        //   window.location.href = '/ir/claim-insurance'
        // })
        // .catch((error) => {
        //   swal("Error", error, "error");
        // })
        // } else {
        //   swal("Warning", 'คอลัมน์จำนวนเงินต้องมีค่าเท่ากันจำนวนเงินเรียกชดใช้รวม!', "warning");
        // }
      } else {
        swal("Warning", 'กรุณาระบุจำนวนเงินให้ถูกต้องตามสัดส่วน!', "warning");
      }
    },
    getDataModalDetails: function getDataModalDetails(obj) {
      console.log('getDataModalDetails ', obj, this.index_comp, this.claim, this.index_group);
      this.claim.group[this.index_group].company[this.index_comp].modal.informant_date = obj.informant_date;
      this.claim.group[this.index_group].company[this.index_comp].modal.invoice_date = obj.invoice_date;
      this.claim.group[this.index_group].company[this.index_comp].modal.gl_date = obj.gl_date;
      this.claim.group[this.index_group].company[this.index_comp].modal.ar_invoice_num = obj.ar_invoice_num;
      this.claim.group[this.index_group].company[this.index_comp].modal.policy_number = obj.policy_number;
      this.claim.group[this.index_group].company[this.index_comp].modal.ar_receipt_date = obj.ar_receipt_date;
      this.claim.group[this.index_group].company[this.index_comp].modal.ar_receipt_number = obj.ar_receipt_number;
      this.claim.group[this.index_group].company[this.index_comp].modal.ar_received_amount = obj.ar_received_amount;

      if (this.confirm) {
        this.claim.group[this.index_group].company[this.index_comp].req_modal = obj.invoice_date && obj.gl_date ? '1' : '';
      } else {
        this.claim.group[this.index_group].company[this.index_comp].req_modal = '1';
      } // let req_modal = this.claim.group[this.index_group].company[this.index_comp].req_modal
      // if (req_modal) {
      //   this.$refs.claim_apply_companies.fields.find((f) => f.prop == 'group.' + this.index_comp + '.req_modal').clearValidate()
      // } else {
      //   this.$refs.claim_apply_companies.validateField('group.' + this.index_comp + '.req_modal')
      // }

    },
    getClaimAmountCompany: function getClaimAmountCompany(value, index) {
      console.log('getClaimAmountCompany ', value, index);
      this.claim.group[index].detail.filter(function (detail) {
        detail.line_amount = value;
        return detail;
      });

      if (value) {
        this.$refs.claim_apply_companies.fields.find(function (f) {
          return f.prop == 'group.' + index + '.company.claim_amount';
        }).clearValidate();
      } else {
        this.$refs.claim_apply_companies.validateField('group.' + index + '.company.claim_amount');
      }
    },
    checkBtnSaveOrConfirm: function checkBtnSaveOrConfirm(btn) {
      if (btn === 'save') {
        this.confirm = false;
        this.claim.group.filter(function (row) {
          row.company.filter(function (comp) {
            comp.req_modal = '1';
            return comp;
          });
          return row;
        });
      } else if (btn === 'confirm') {
        this.confirm = true;
        this.claim.group.filter(function (row) {
          row.company.filter(function (comp) {
            comp.req_modal = comp.modal.invoice_date && comp.modal.gl_date ? '1' : '';
            return comp;
          });
          return row;
        });
      }
    },
    clickRemoveDetails: function clickRemoveDetails(dataRowComp, dataRow, index_detail) {
      console.log('clickRemoveDetails ', dataRowComp, dataRow, this.claim, index_detail);

      if (dataRow.flag === 'add' || dataRow.flag === 'edit') {
        var index = dataRowComp.detail.indexOf(dataRow);
        console.log('index ', index);

        if (index > -1) {
          dataRowComp.detail.splice(index, 1);
          dataRowComp.detail.filter(function (detail, i) {
            detail.line_number = i + 1;
            return detail;
          });
          console.log('splice ', dataRowComp.detail, dataRowComp.detail[index_detail]);
        }
      }
    },
    checkReqTableDetails: function checkReqTableDetails() {
      var arr = [];
      var validate = [];
      this.claim.group.forEach(function (element) {
        arr = [].concat(_toConsumableArray(arr), _toConsumableArray(element.detail.map(function (item) {
          return {
            line_amount: item.line_amount,
            line_description: item.line_description
          };
        })));
      });
      validate = arr.filter(function (f) {
        return f.line_description == "" || f.line_amount == "";
      });

      if (validate.length > 0) {
        swal("Warning", 'กรุณากรอกข้อมูลรายละเอียดให้ครบ!', "warning");
        return false;
      } else return true;
    },
    showBtnRemoveCompany: function showBtnRemoveCompany(dataRow, index) {
      console.log('showBtnRemoveCompany ', dataRow);

      if (dataRow.flag === 'add') {
        return true;
      } else if (dataRow.flag === 'edit') {
        if (this.checkStatusInterface(this.claim.headers.status) || this.checkStatusConfirmed(this.claim.headers.status) || this.checkColumnPercent <= 100) {
          return false;
        }

        return true;
      }
    },
    setDefaultLineAmountDetails: function setDefaultLineAmountDetails(claim_amount, index, index_group) {
      console.log('setDefaultLineAmountDetails ', claim_amount, index, index_group);
      var details = this.claim.group[index_group].company[index].detail;

      if (details.length > 0) {
        details[0].line_amount = claim_amount;
      } // this.claim.apply.apply_company.filter((company) => {
      //   if (company.apply_details.length > 0) {
      //     company.apply_details[0].line_amount = claim_amount
      //   }
      //   // company.apply_details.filter((detail) => {
      //   //   detail.line_amount = claim_amount
      //   //   return detail
      //   // })
      // })

    },
    watchClaimAmountCompany: function watchClaimAmountCompany(value, index, index_group) {
      console.log('watchClaimAmountCompany ', value, index, index_group);
      this.setDefaultLineAmountDetails(value, index, index_group);
    },
    getValueAccidentDate: function getValueAccidentDate(date) {
      console.log('getValueAccidentDate ', date);
      var formatDate = this.vars.formatDate;

      if (date) {
        this.claim.headers.accident_date = moment__WEBPACK_IMPORTED_MODULE_12___default()(date).format(formatDate);
      } else {
        this.claim.headers.accident_date = '';
      }

      this.validateNotElUi(date, 'headers.accident_date');
    },
    validateNotElUi: function validateNotElUi(value, nameProp) {
      if (value) {
        this.$refs.claim_insurance.fields.find(function (f) {
          return f.prop == nameProp;
        }).clearValidate();
      } else {
        this.$refs.claim_insurance.validateField(nameProp);
      }
    },
    onBeforeUploadImage: function onBeforeUploadImage(file) {
      var isIMAGE = file.type === 'image/jpeg' || 'image/jpg' || 'image/png';
      var isLt1M = file.size / 1024 / 1024 < 1;

      if (!isIMAGE) {
        this.$message.error('Upload file can only be in image format!');
      }

      if (!isLt1M) {
        this.$message.error('Upload file size cannot exceed 1MB!');
      }

      return isIMAGE && isLt1M;
    },
    UploadImage: function UploadImage(param) {
      var formData = new FormData();
      formData.append('file', param.file);
      formData.append('data', param.data);
      console.log('UploadImage ', param, formData); // let config = {
      //   header: {
      //     'Content-Type': 'multipart/form-data'
      //   }
      // }

      axios.post('/ir/claim-insurance/create/upload', formData, config).then(function (res) {})["catch"](function (error) {
        console.log('error ', error);
      }); // UploadImageApi(formData).then(response => {
      // 	console.log('Upload image successfully')
      //   param.onSuccess()  // Upload a successful image will show a green check mark
      //   // But we uploaded the image successfully, but the value in fileList has not changed, but the on-change command can be used.
      // }).catch(response => {
      //   console.log('Image upload failed')
      //   param.onError()
      // })
    },
    onchange: function onchange(file, fileList) {
      console.log('onchange ', file, fileList);
      this.fileList = fileList; // this.$refs.upload.clearFiles() // Clear the file object
      // this.logo = file.raw // Take out the object of the uploaded file, can also be used in other places
      // this.fileList = [{name: file.name, url: file.url}] // Re-assign the filstList manually, so that the custom upload is successful, and the fileList is not dynamically changed, so each time an object is uploaded.
    },
    onRemove: function onRemove(file, fileList) {
      console.log('onRemove ', file, fileList);

      var _this = this;

      if (this.action === 'add') {
        // swal({
        //   title: "Warning",
        //   text: "ต้องการลบหรือไม่?",
        //   type: "warning",
        //   showCancelButton: true,
        //   closeOnConfirm: false
        // },
        // function(isConfirm) {
        //   if (isConfirm) {
        _this.fileList = fileList; //     swal({
        //       title: "Success",
        //       text: '',
        //       timer: 3000,
        //       type: "success",
        //       showCancelButton: false,
        //       showConfirmButton: false
        //     })
        //   }
        // });
      } else {
        var attachment_id = file.attachment_id;
        this.fileList = fileList; // swal({
        //   title: "Warning",
        //   text: "ต้องการลบหรือไม่?",
        //   type: "warning",
        //   showCancelButton: true,
        //   closeOnConfirm: false
        // },
        // function(isConfirm) {
        //   if (isConfirm) {

        console.log('action  ', this.action, fileList, attachment_id);

        _this.receivedDelete(attachment_id); //   }
        // });

      }
    },
    setFormData: function setFormData(params) {
      console.log('setFormData ', this.fileList, params, params.claim_header_id);
      var data = {
        // program_code: 'IRP0010',
        claim_header_id: params.claim_header_id
      };
      var formData = new FormData();
      formData.append('data', JSON.stringify(data)); // formData.append('accident_date', params.data.accident_date);
      // formData.append('accident_time', params.data.accident_time);
      // formData.append('claim_amount', params.data.claim_amount);
      // formData.append('claim_header_id', params.data.claim_header_id);
      // formData.append('department_code', params.data.department_code);
      // formData.append('department_name', params.data.department_name);
      // formData.append('document_number', params.data.document_number);
      // formData.append('location_code', params.data.location_code);
      // formData.append('location_name', params.data.location_name);
      // formData.append('program_code', params.data.program_code);
      // formData.append('requestor_id', params.data.requestor_id);
      // formData.append('requestor_name', params.data.requestor_name);
      // formData.append('requestor_tel', params.data.requestor_tel);
      // formData.append('status', params.data.status);
      // formData.append('company_rows', JSON.stringify(params.data.company_rows));

      var everySuccess = this.fileList.every(this.checkFilesEditSuccessEvery);
      console.log('everySuccess ', everySuccess, this.fileList);

      if (this.fileList.length > 0 && !everySuccess) {
        for (var i in this.fileList) {
          var file = this.fileList[i];
          console.log('file ', file, file.raw);

          if (file.status === 'ready') {
            formData.append('file[]', file.raw);
          }
        }

        console.log('formData ', formData);
      } else {
        formData.append('file[]', []);
      } // formData.append('year', params.data.year);


      return formData;
    },
    receivedUploadFile: function receivedUploadFile(formDataFile) {
      axios.post('/ir/ajax/claim/upload', formDataFile).then(function (_ref3) {
        var data = _ref3.data;
        swal({
          title: "Success",
          text: data.message,
          type: "success",
          showConfirmButton: false,
          closeOnConfirm: false
        }); // window.location.href = '/ir/claim-insurance'
      })["catch"](function (error) {
        swal("Error", error, "error");
      });
    },
    receivedDelete: function receivedDelete(attachment_id) {
      var _this6 = this;

      axios["delete"]("/ir/ajax/claim/file/".concat(attachment_id)).then(function (_ref4) {
        var data = _ref4.data;
        swal({
          title: "Success",
          text: data.message,
          type: "success",
          showConfirmButton: false,
          closeOnConfirm: false,
          timer: 3000
        });
        _this6.files = _this6.fileList;
        console.log('success ', _this6.fileList, _this6.files);
      })["catch"](function (error) {
        if (error.response.data.status === 400) {
          swal("Warning", error.response.data.message, "warning");
        } else {
          swal("Error", error, "error");
        }

        _this6.fileList = _this6.files;
        console.log('error ', _this6.fileList, _this6.files);
      });
    },
    beforeRemove: function beforeRemove(file, fileList) {
      console.log('beforeRemove ', file, fileList);
      return this.$confirm("\u0E15\u0E49\u0E2D\u0E07\u0E01\u0E32\u0E23\u0E25\u0E1A\u0E2B\u0E23\u0E37\u0E2D\u0E44\u0E21\u0E48");
    },
    checkFilesEditSuccessEvery: function checkFilesEditSuccessEvery(file) {
      console.log('checkFilesEditSuccessEvery', file);

      if (file.status && file.status.toLowerCase() === 'success') {
        return true;
      }

      return false;
    },
    getPolicyCode: function getPolicyCode(obj, index) {
      this.claim.group[index].group_code = obj.code;
      this.claim.group[index].group_description = obj.desc;
      this.claim.group[index].group_header_id = obj.id;

      if (obj.id) {
        this.claim.group[index].showLovCompany = false;
        this.getCompaiesPercent(obj.id);
      } else {
        this.claim.group[index].showLovCompany = true;
        this.claim.group[index].company = []; //  this.getCompaiesPercent(obj.id);
        // this.claim.group[index].company.filter((comp) => {
        //   comp.company_id = '';
        //   comp.company_name = '';
        //   comp.claim_percent = '';
        //   comp.claim_amount = '';
        //   return comp;
        // })
      } // if(obj.id !== ''){
      //   this.getCompanyPercent(obj.id, index);
      // }

    },
    getPolicySetHeaderId: function getPolicySetHeaderId(obj, index) {
      this.claim.group[index].policy_set_header_id = obj.id;
      this.claim.group[index].policy_set_description = obj.desc;
    },
    getDataCompanyPolicyGroup: function getDataCompanyPolicyGroup(obj, index_comp, index_group) {
      console.log('company_percent ', obj, index_comp, index_group, this.claim.group);
      this.claim.group[index_group].company[index_comp].company_id = obj.id;
      this.claim.group[index_group].company[index_comp].company_name = obj.desc;
      var percent = obj.percent ? +obj.percent : 0;
      this.claim.group[index_group].company[index_comp].claim_percent = percent;
      this.claim.group[index_group].company[index_comp].claim_amount = percent ? this.claim.group[index_group].amount * percent / 100 : percent;
    },
    clickCreateApplyCompanies: function clickCreateApplyCompanies(index, data) {
      var _this7 = this;

      console.log('clickCreateApplyComssssssssspanies ', index, this.claim.group);
      var companies = [];
      var validCompanies = [];
      this.claim.group.forEach(function (element) {
        console.log('companiesssssss', element);
        companies = [].concat(_toConsumableArray(companies), _toConsumableArray(element.company.map(function (item) {
          return {
            company_id: item.company_id,
            claim_percent: item.claim_percent
          };
        })));
      });
      console.log('companies ', companies);
      validCompanies = companies.filter(function (f) {
        return f.company_id == "" || f.claim_percent == "";
      });
      console.log('validCompanies ', validCompanies); // let modal = [];
      // let validModal = [];
      // this.claim.group.forEach(element => {
      //   modal = [...modal, ...element.company.map(item => {
      //     return {
      //       invoice_date: item.modal.invoice_date,
      //       gl_date: item.modal.gl_date
      //     };
      //   })]
      // });
      // console.log('modal ', modal)
      // validModal = modal.filter(f => f.invoice_date == "" || f.gl_date == "");
      // console.log('validModal ', validModal)

      var comds = [];
      var details = [];
      var validDetails = [];
      this.claim.group.forEach(function (element) {
        comds = [].concat(_toConsumableArray(comds), _toConsumableArray(element.company.map(function (item) {
          return item;
        })));
      });
      console.log('comds ', comds);
      comds.forEach(function (element) {
        details = [].concat(_toConsumableArray(details), _toConsumableArray(element.detail.map(function (item) {
          return {
            line_description: item.line_description,
            line_amount: item.line_amount
          };
        })));
      });
      console.log('details ', details);
      validDetails = details.filter(function (f) {
        return f.line_description == "" || f.line_amount == "";
      });
      console.log('validDetails ', validDetails); // if (validCompanies.length > 0 && validModal.length === 0) {

      if (validCompanies.length > 0) {
        swal("Warning", 'กรุณากรอกข้อมูลรายการเคลมให้ครบ!', "warning");
        return false; // } 
        // else if (validModal.length > 0 && validCompanies.length === 0) {
        //   swal("Warning", 'กรุณากรอก Invoice Date และ GL Date!', "warning");
        //   return false;
        // } 
        // else if (validCompanies.length > 0 && validModal.length > 0) {
        //   swal("Warning", 'กรุณากรอกข้อมูลรายการเคลมให้ครบ!', "warning");
        // } else   {
      } else if (validDetails.length > 0) {
        swal("Warning", 'กรุณากรอกข้อมูลรายละเอียดให้ครบ!', "warning");
        console.log('validDetails', validDetails);
      } else if (this.checkColumnPercent === 100) {
        swal("Warning", 'สัดส่วนได้ครบจำนวน 100 % !', "warning"); // }else if (this.claim.group.length > 1) { 
        //    this.companies_percent.filter((comp_res, index_comp) => {
        //       let data = {
        //         company_id : '',
        //         company_name : '',
        //         claim_percent : '',
        //         claim_amount : '',
        //         detail: [{
        //           line_number: '1',
        //           line_description: '',
        //           line_amount: '',
        //           flag: 'add',
        //         }],
        //         req_modal: '',
        //         modal: {
        //           informant_date: '',
        //           invoice_date: '',
        //           gl_date: '',
        //           ar_invoice_num: '',
        //           policy_number: '',
        //           ar_receipt_date: '',
        //           ar_receipt_number: '',
        //           ar_received_amount: ''
        //         },
        //         flag: 'add',
        //         claim_apply_id: ''
        //       };
        //         let percent = comp_res.company_percent ? +comp_res.company_percent : 0;
        //         data.company_id = comp_res.company_id
        //         data.company_name = comp_res.company_name
        //         data.claim_percent = comp_res.company_percent 
        //         data.claim_amount = percent ? this.claim.group[index].amount * percent / 100 : percent;
        //         data.detail.line_amount = percent ? this.claim.group[index].amount * percent / 100 : percent;
        //         this.claim.group[index].company.push(data)
        //         console.log('dataaa',data, data.detail )
        //         data.detail.filter((detl) => {
        //           let claim_amount = data.claim_amount ? +data.claim_amount : 0;
        //           detl.line_amount = claim_amount
        //           console.log('detl ', detl)
        //           console.log('lineamount0',detl.line_amount)
        //         })
        //         console.log('dataaaaa',data)
        //     })
        // }
      } else if (data.group_code === '') {
        this.claim.group[index].company.push({
          company_id: '',
          company_name: '',
          claim_percent: '',
          claim_amount: '',
          detail: [{
            line_number: '1',
            line_description: '',
            line_amount: '',
            flag: 'add'
          }],
          req_modal: '',
          modal: {
            informant_date: '',
            invoice_date: '',
            gl_date: '',
            ar_invoice_num: '',
            policy_number: '',
            ar_receipt_date: '',
            ar_receipt_number: '',
            ar_received_amount: ''
          },
          flag: 'add',
          claim_apply_id: ''
        });
        console.log('data.group_code.length', data.group_code.length);
        return true; // }else if (this.claim.group.length > 1) { 
        //    this.companies_percent.filter((comp_res, index_comp) => {
        //       let data = {
        //         company_id : '',
        //         company_name : '',
        //         claim_percent : '',
        //         claim_amount : '',
        //         detail: [{
        //           line_number: '1',
        //           line_description: '',
        //           line_amount: '',
        //           flag: 'add',
        //         }],
        //         req_modal: '',
        //         modal: {
        //           informant_date: '',
        //           invoice_date: '',
        //           gl_date: '',
        //           ar_invoice_num: '',
        //           policy_number: '',
        //           ar_receipt_date: '',
        //           ar_receipt_number: '',
        //           ar_received_amount: ''
        //         },
        //         flag: 'add',
        //         claim_apply_id: ''
        //       };
        //         let percent = comp_res.company_percent ? +comp_res.company_percent : 0;
        //         data.company_id = comp_res.company_id
        //         data.company_name = comp_res.company_name
        //         data.claim_percent = comp_res.company_percent 
        //         data.claim_amount = percent ? this.claim.group[index].amount * percent / 100 : percent;
        //         data.detail.line_amount = percent ? this.claim.group[index].amount * percent / 100 : percent;
        //         this.claim.group[index].company.push(data)
        //         console.log('dataaa',data, data.detail )
        //         data.detail.filter((detl) => {
        //           let claim_amount = data.claim_amount ? +data.claim_amount : 0;
        //           detl.line_amount = claim_amount
        //           console.log('detl ', detl)
        //           console.log('lineamount0',detl.line_amount)
        //         })
        //         console.log('dataaaaa',data)
        //     })
      } else {
        console.log('this.companies_percent', this.companies_percent);
        this.companies_percent.filter(function (comp_res, index_comp) {
          var data = {
            company_id: '',
            company_name: '',
            claim_percent: '',
            claim_amount: '',
            detail: [{
              line_number: '1',
              line_description: '',
              line_amount: '',
              flag: 'add'
            }],
            req_modal: '',
            modal: {
              informant_date: '',
              invoice_date: '',
              gl_date: '',
              ar_invoice_num: '',
              policy_number: '',
              ar_receipt_date: '',
              ar_receipt_number: '',
              ar_received_amount: ''
            },
            flag: 'add',
            claim_apply_id: ''
          };
          var percent = comp_res.company_percent ? +comp_res.company_percent : 0;
          data.company_id = comp_res.company_id;
          data.company_name = comp_res.company_name;
          data.claim_percent = comp_res.company_percent;
          data.claim_amount = percent ? _this7.claim.group[index].amount * percent / 100 : percent;
          data.detail.line_amount = percent ? _this7.claim.group[index].amount * percent / 100 : percent;

          _this7.claim.group[index].company.push(data);

          console.log('dataaa', data, data.detail);
          data.detail.filter(function (detl) {
            var claim_amount = data.claim_amount ? +data.claim_amount : 0;
            detl.line_amount = claim_amount;
            console.log('detl ', detl);
            console.log('lineamount0', detl.line_amount);
          });
          console.log('dataaaaa', data);
        }); // this.claim.group[index].company =array;
      }
    },
    getValueCompaniesPercent: function getValueCompaniesPercent(array, index_group, index_comp) {
      var _this8 = this;

      var _this = this;

      console.log('array', array);

      if (array.length > 0) {
        console.log('testIf', index_comp);
        array.filter(function (comp_res, index) {
          if (index == index_comp) {
            console.log('aaaaasdfaaa', comp_res.company_id, index, index_comp);
            var percent = comp_res.company_percent ? +comp_res.company_percent : 0;
            _this8.claim.group[index_group].company[index_comp].company_id = comp_res.company_id;
            _this8.claim.group[index_group].company[index_comp].company_name = comp_res.company_name;
            _this8.claim.group[index_group].company[index_comp].claim_percent = comp_res.company_percent;
            _this8.claim.group[index_group].company[index_comp].claim_amount = percent ? _this.claim.group[index_group].amount * percent / 100 : percent;
          } // this.claim.group[index_group].company[0].company_id ='11';
          //  this.claim.group[index_group].company[1].company_id = '22';

        });
        console.log('testxxx', index_group, index_comp);
      } else {
        this.claim.group[index_group].company[index_comp].company_id = '';
        this.claim.group[index_group].company[index_comp].company_name = '';
        this.claim.group[index_group].company[index_comp].claim_percent = '';
        this.claim.group[index_group].company[index_comp].claim_amount = '';
        this.claim.group[index_group].company[index_comp].detail = [];
      }
    },
    getCompaiesPercent: function getCompaiesPercent(group_header_id) {
      var _this9 = this;

      var params = {
        company_id: '',
        keyword: '',
        group_header_id: group_header_id,
        year: this.claim.headers.year
      };
      axios.get("/ir/ajax/lov/company-percent", {
        params: params
      }).then(function (_ref5) {
        var data = _ref5.data;
        console.log('response getDataRows ', data);
        var response = data.data;
        _this9.companies_percent = response;
      })["catch"](function (error) {
        swal("Error", error, "error");
      });
    } // getCompanyPercent (group_header_id, index) {
    //   axios.get(`/ir/ajax/lov/company-percent?group_header_id=${group_header_id}&year=${this.claim.headers.year}`)
    //   .then((res) => {
    //     console.log('res ', res.data)
    //     this.resData = res.data.data;
    //     // this.claim.group[index].company.company_id = res.data.company_id
    //     // this.claim.group[index].company.company_name = res.data.company_name
    //     // this.claim.group[index].company.claim_percent= res.data.company_percent
    //   })
    //   .catch((error) => {
    //     swal("Error", error, "error");
    //   })
    // }

  },
  components: {
    lovDepartment: _lovDepartment__WEBPACK_IMPORTED_MODULE_0__.default,
    currencyInputGroupAppend: _components_currencyInputGroupAppend__WEBPACK_IMPORTED_MODULE_1__.default,
    currencyInput: _components_currencyInput__WEBPACK_IMPORTED_MODULE_6__.default,
    lovCompany: _lovCompany__WEBPACK_IMPORTED_MODULE_2__.default,
    lovLocation: _lovLocation__WEBPACK_IMPORTED_MODULE_3__.default,
    dateInput: _components_calendar_dateInput__WEBPACK_IMPORTED_MODULE_4__.default,
    modalDetails: _modalDetails__WEBPACK_IMPORTED_MODULE_5__.default,
    headerForm: _headerForm__WEBPACK_IMPORTED_MODULE_7__.default,
    policyHeaderForm: _policyHeaderForm__WEBPACK_IMPORTED_MODULE_8__.default,
    lovPolicyGroup: _lovPolicyGroup__WEBPACK_IMPORTED_MODULE_9__.default,
    lovPolicySetHeaderId: _lovPolicySetHeaderId__WEBPACK_IMPORTED_MODULE_10__.default,
    lovCompanyPolicyGroup: _lovCompanyPolicyGroup__WEBPACK_IMPORTED_MODULE_11__.default
  },
  watch: {
    'btn': function btn(newVal, oldVal) {
      console.log('btn ', newVal, this.btnConfirm);

      if (newVal === 'confirm') {
        this.btnConfirm = true;
      } else {
        this.btnConfirm = false;
      }
    },
    'claim.headers.file': function claimHeadersFile(newVal, oldVal) {
      console.log('claim.headers.file ', newVal);
      this.fileList = newVal;
      this.files = newVal;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/headerForm.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/headerForm.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'ir-claim-insurance-header-form'
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovCompany.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovCompany.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'ir-claim-insurance-lov-company',
  data: function data() {
    return {
      rows: [],
      loading: false,
      result: this.value ? +this.value : this.value
    };
  },
  props: ['placeholder', 'attrName', 'value', 'size', 'index', 'disabled', 'resData'],
  methods: {
    remoteMethod: function remoteMethod(query) {
      this.getDataRows({
        company_id: '',
        keyword: query
      });
    },
    getDataRows: function getDataRows(params) {
      var _this = this;

      this.loading = true;
      axios.get("/ir/ajax/lov/companies", {
        params: params
      }).then(function (_ref) {
        var data = _ref.data;
        console.log('response getDataRows ', data);
        var response = data.data;
        _this.loading = false;
        _this.rows = response;
      })["catch"](function (error) {
        swal("Error", error, "error");
      });
    },
    onfocus: function onfocus() {
      if (this.rows.length === 0 && this.result || this.rows.length > 0 && this.result) {
        this.getDataRows({
          company_id: '',
          keyword: this.result
        });
      } else if (this.rows.length === 0 && !this.result) {
        this.getDataRows({
          company_id: '',
          keyword: ''
        });
      }
    },
    onchange: function onchange(value) {
      var code = '';
      var desc = '';
      var id = '';

      if (value) {
        for (var i in this.rows) {
          var row = this.rows[i];

          if (row.company_id === +value) {
            code = row.company_number;
            desc = row.company_name, id = value;
          }
        }
      } else {
        code = '';
        desc = '';
        id = '';
      }

      var data = {
        code: code,
        desc: desc,
        id: id,
        index: this.index
      };
      console.log('change-lov ', data);
      this.$emit('change-lov', data);
    },
    onclick: function onclick() {
      if (this.rows.length >= 0 && this.result) {
        this.getDataRows({
          company_id: '',
          keyword: this.result
        });
      } else if (this.rows.length >= 0 && !this.result) {
        this.getDataRows({
          company_id: '',
          keyword: ''
        });
      }
    }
  },
  mounted: function mounted() {
    console.log('mounted company ', this.value);
    this.getDataRows({
      company_id: this.value,
      keyword: ''
    });
  },
  watch: {
    'value': function value(newVal, oldVal) {
      console.log('newVal company ', newVal);
      this.result = newVal; // this.getDataRows({ company_id: this.result, keyword: '' })
    },
    'resData': function resData(newVal, oldVal) {
      this.rows = newVal;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovCompanyPolicyGroup.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovCompanyPolicyGroup.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'ir-claim-insurance-lov-company-policy-group',
  data: function data() {
    return {
      rows: [],
      loading: false,
      result: this.value
    };
  },
  props: ['placeholder', 'attrName', 'value', 'size', 'index', 'disabled', 'group_header_id', 'year'],
  methods: {
    remoteMethod: function remoteMethod(query) {
      console.log('remoteMethod getdatarow');
      this.getDataRows({
        company_id: '',
        keyword: query,
        group_header_id: this.group_header_id,
        year: this.year
      });
    },
    getDataRows: function getDataRows(params) {
      var _this = this;

      this.loading = true;
      axios.get("/ir/ajax/lov/company-percent", {
        params: params
      }).then(function (_ref) {
        var data = _ref.data;
        // console.log('response getDataRows ', data);
        var response = data.data;
        _this.loading = false;
        _this.rows = response;

        _this.$nextTick(function () {
          _this.$emit('response-company-percent', response);
        });
      })["catch"](function (error) {
        swal("Error", error, "error");
      });
    },
    onfocus: function onfocus() {
      console.log('onfocus getdatarow');

      if (this.rows.length === 0 && this.result || this.rows.length > 0 && this.result) {
        this.getDataRows({
          company_id: '',
          keyword: this.result,
          group_header_id: this.group_header_id,
          year: this.year
        });
      } else if (this.rows.length === 0 && !this.result) {
        this.getDataRows({
          company_id: '',
          keyword: '',
          group_header_id: this.group_header_id,
          year: this.year
        });
      }
    },
    onchange: function onchange(value) {
      var params = {
        code: '',
        desc: '',
        id: '',
        percent: ''
      };

      if (value) {
        for (var i in this.rows) {
          var row = this.rows[i];

          if (row.company_id == value) {
            params.code = row.company_number;
            params.desc = row.company_name, params.id = value;
            params.percent = row.company_percent ? +row.company_percent : 0;
          }
        }
      } else {
        params.code = '';
        params.desc = '';
        params.id = '';
        params.percent = '';
      } // console.log('change-lov ', params)


      this.$emit('change-lov', params);
    },
    onclick: function onclick() {
      console.log('onclick getdatarow');

      if (this.rows.length > 0 && this.result) {
        this.getDataRows({
          company_id: '',
          keyword: this.result,
          group_header_id: this.group_header_id,
          year: this.year
        });
      } else if (this.rows.length > 0 && !this.result) {
        this.getDataRows({
          company_id: '',
          keyword: '',
          group_header_id: this.group_header_id,
          year: this.year
        });
      }
    }
  },
  mounted: function mounted() {//  console.log('mounted company ', this.value)
    //    console.log('mounted getdatarow')
    //  this.getDataRows({
    //   company_id: this.value,
    //   keyword: '',
    //   group_header_id: this.group_header_id,
    //    year: this.year
    //    })
  },
  watch: {
    'value': function value(newVal, oldVal) {
      //   console.log('newVal company ', newVal)
      //   console.log('oldVal company', oldVal)
      //    console.log('watch getdatarow')
      this.result = newVal; ///    this.getDataRows({
      //     company_id: '',
      //     keyword: newVal,
      //     group_header_id: this.group_header_id,
      //     year: this.year
      //   })
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovDepartment.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovDepartment.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'ir-claim-insurance-lov-department',
  data: function data() {
    return {
      rows: [],
      loading: false,
      result: this.value
    };
  },
  props: ['placeholder', 'attrName', 'value', 'disabled'],
  methods: {
    remoteMethod: function remoteMethod(query) {
      this.getDataRows({
        department_code: '',
        keyword: query
      });
    },
    getDataRows: function getDataRows(params) {
      var _this = this;

      this.loading = true;
      axios.get("/ir/ajax/lov/department-code", {
        params: params
      }).then(function (_ref) {
        var data = _ref.data;
        console.log('response getDataRows ', data);
        var response = data.data;
        _this.loading = false;
        _this.rows = response;
      })["catch"](function (error) {
        swal("Error", error, "error");
      });
    },
    onfocus: function onfocus() {
      if (this.rows.length === 0 && this.result || this.rows.length > 0 && this.result) {
        this.getDataRows({
          department_code: '',
          keyword: this.result
        });
      } else if (this.rows.length === 0 && !this.result) {
        this.getDataRows({
          department_code: '',
          keyword: ''
        });
      }
    },
    onchange: function onchange(value) {
      var params = {
        code: '',
        desc: ''
      };

      if (value) {
        for (var i in this.rows) {
          var row = this.rows[i];

          if (row.department_code === value) {
            params.code = value;
            params.desc = row.description;
          }
        }
      } else {
        params.code = '';
        params.desc = '';
      }

      console.log('change-lov ', params);
      this.$emit('change-lov', params);
    },
    onclick: function onclick() {
      console.log('onclick ', this.rows, this.result);

      if (this.rows.length >= 0 && this.result) {
        this.getDataRows({
          department_code: '',
          keyword: this.result
        });
      } else if (this.rows.length >= 0 && !this.result) {
        this.getDataRows({
          department_code: '',
          keyword: ''
        });
      }
    }
  },
  mounted: function mounted() {
    console.log('mounted department ', this.value);
    this.getDataRows({
      department_code: '',
      keyword: ''
    });
  },
  watch: {
    'value': function value(newVal, oldVal) {
      console.log('newVal deparment ', newVal);
      this.result = newVal;
      this.getDataRows({
        department_code: '',
        keyword: newVal
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovInvoiceNumberAr.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovInvoiceNumberAr.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'ir-claim-insurance-lov-invoice-number-ar',
  data: function data() {
    return {
      dataRows: [],
      loading: false,
      invoice_number: this.value
    };
  },
  props: ['attrName', 'value'],
  methods: {
    remoteMethod: function remoteMethod(query) {
      this.gatDataRows({
        claim_apply_id: '',
        keyword: query
      });
    },
    gatDataRows: function gatDataRows(params) {
      var _this = this;

      this.loading = true;
      axios.get("/ir/ajax/lov/ar-invoice-num", {
        params: params
      }).then(function (_ref) {
        var data = _ref.data;
        var response = data.data;
        _this.loading = false;
        _this.dataRows = response;
      })["catch"](function (error) {
        swal('Error', error, 'error');
      });
    },
    focus: function focus(event) {
      this.gatDataRows({
        claim_apply_id: '',
        keyword: ''
      });
    },
    change: function change(value) {
      this.$emit('change-value', value);
    }
  },
  mounted: function mounted() {// this.gatDataRows({ meaning: '', keyword: '' })
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovLocation.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovLocation.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'ir-claim-insurance-lov-location',
  data: function data() {
    return {
      rows: [],
      loading: false,
      result: this.value
    };
  },
  props: ['placeholder', 'attrName', 'value', 'disabled'],
  methods: {
    remoteMethod: function remoteMethod(query) {
      this.getDataRows({
        department_code: '',
        keyword: query
      });
    },
    getDataRows: function getDataRows(params) {
      var _this = this;

      this.loading = true;
      axios.get("/ir/ajax/lov/location", {
        params: params
      }).then(function (_ref) {
        var data = _ref.data;
        console.log('response getDataRows ', data);
        var response = data.data;
        _this.loading = false;
        _this.rows = response;
      })["catch"](function (error) {
        swal("Error", error, "error");
      });
    },
    focus: function focus(event) {
      console.log('focus ', event);
      this.getDataRows({
        department_code: '',
        keyword: ''
      });
    },
    change: function change(value) {
      var code = '';
      var desc = '';

      for (var i in this.rows) {
        var row = this.rows[i];

        if (row.meaning === value) {
          code = value;
          desc = row.description;
        }
      }

      var data = {
        code: code,
        desc: desc
      };
      console.log('change-lov ', data);
      this.$emit('change-lov', data);
    }
  },
  mounted: function mounted() {
    this.getDataRows({
      department_code: '',
      keyword: ''
    });
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovPolicyGroup.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovPolicyGroup.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'ir-claim-insurance-lov-policy-group',
  data: function data() {
    return {
      rows: [],
      loading: false,
      result: this.value
    };
  },
  props: ['value', 'name', 'size', 'placeholder', 'popperBody', 'disabled'],
  methods: {
    remoteMethod: function remoteMethod(query) {
      this.getDataRows({
        group_header_id: '',
        keyword: query // group_header_id: ''

      });
    },
    getDataRows: function getDataRows(params) {
      var _this = this;

      this.loading = true;
      axios.get("/ir/ajax/lov/policy-group-header", {
        params: params
      }).then(function (_ref) {
        var data = _ref.data;
        _this.loading = false;
        _this.rows = data.data;
      })["catch"](function (error) {
        swal("Error", error, "error");
      });
    },
    onfocus: function onfocus() {
      console.log('onfocus ', this.rows, this.result);

      if (this.rows.length >= 0 && this.result) {
        this.getDataRows({
          group_header_id: '',
          keyword: this.result
        });
      } else if (this.rows.length >= 0 && !this.result) {
        this.getDataRows({
          group_header_id: '',
          keyword: ''
        });
      }
    },
    onchange: function onchange(value) {
      var params = {
        code: '',
        desc: '',
        id: ''
      };

      if (value) {
        for (var i in this.rows) {
          var row = this.rows[i];

          if (row.group_header_id === value) {
            params.code = row.group_code;
            params.desc = row.group_description;
            params.id = value;
          }
        }
      } else {
        params.code = '';
        params.desc = '';
        params.id = '';
      }

      this.$emit('change-lov', params);
    },
    onclick: function onclick() {
      console.log('onclick ', this.rows, this.result);

      if (this.rows.length >= 0 && this.result) {
        this.getDataRows({
          keyword: this.result,
          group_header_id: ''
        });
      } else if (this.rows.length >= 0 && !this.result) {
        this.getDataRows({
          keyword: '',
          group_header_id: ''
        });
      }
    }
  },
  mounted: function mounted() {
    console.log('mounted policy number ', this.value);
    this.result = this.value ? +this.value : this.value;
    this.getDataRows({
      group_header_id: this.value,
      keyword: ''
    });
  } // watch: {
  //   'value' (newVal, oldVal) {
  //     this.result = newVal
  //   }
  // }

});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovPolicySetHeaderId.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovPolicySetHeaderId.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'ir-claim-insurance-lov-policy-set-header-group',
  // name: 'ir-claim-insurance-lov-policy-set-header',
  data: function data() {
    return {
      rows: [],
      loading: false,
      result: this.value,
      isDisabled: this.disabled === undefined ? false : this.disabled
    };
  },
  props: ['value', 'name', 'size', 'placeholder', 'popperBody', 'fixTypeFr', 'fixTypeSc', 'disabled', 'group_header_id'],
  methods: {
    remoteMethod: function remoteMethod(query) {
      this.getDataRows({
        group_header_id: this.group_header_id,
        keyword: query // type: this.fixTypeFr,
        // type2: this.fixTypeSc

      });
    },
    getDataRows: function getDataRows(params) {
      var _this = this;

      this.loading = true;
      axios.get("/ir/ajax/lov/policy-set-header-group", {
        params: params
      }) // axios.get(`/ir/ajax/lov/policy-set-header`, { params })
      .then(function (_ref) {
        var data = _ref.data;
        _this.loading = false;
        _this.rows = data.data;
      })["catch"](function (error) {
        swal("Error", error, "error");
      });
    },
    onfocus: function onfocus() {
      this.getDataRows({
        group_header_id: this.group_header_id,
        keyword: '' // type: this.fixTypeFr,
        // type2: this.fixTypeSc

      });
    },
    onchange: function onchange(value) {
      var params = {
        code: '',
        desc: '',
        id: ''
      };

      if (value) {
        for (var i in this.rows) {
          var row = this.rows[i];

          if (row.policy_set_header_id === value) {
            params.code = row.policy_set_number;
            params.desc = row.policy_set_description;
            params.id = value;
          }
        }
      } else {
        params.code = '';
        params.desc = '';
        params.id = '';
      }

      console.log('onchange ', params);
      this.$emit('change-lov', params);
    }
  },
  created: function created() {
    console.log('mounted group_header_id ', this.value);
    this.result = this.value;
    this.getDataRows({
      group_header_id: this.group_header_id,
      policy_set_header_id: this.value,
      keyword: '' // type: this.fixTypeFr,
      // type2: this.fixTypeSc

    });
  },
  watch: {
    'value': function value(newVal, oldVal) {
      this.result = newVal;
      this.getDataRows({
        group_header_id: this.group_header_id,
        keyword: '' // type: this.fixTypeFr,
        // type2: this.fixTypeSc

      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/modalDetails.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/modalDetails.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _lovInvoiceNumberAr__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./lovInvoiceNumberAr */ "./resources/js/components/ir/claim-insurance/lovInvoiceNumberAr.vue");
/* harmony import */ var _components_calendar_dateInput__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/calendar/dateInput */ "./resources/js/components/ir/components/calendar/dateInput.vue");
/* harmony import */ var _components_currencyInput__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/currencyInput */ "./resources/js/components/ir/components/currencyInput.vue");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_3__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  name: 'ir-claim-insurance-modal-details',
  data: function data() {
    return {
      req_modal: '',
      modal: {
        informant_date: '',
        invoice_date: '',
        gl_date: '',
        ar_invoice_num: '',
        policy_number: '',
        ar_receipt_date: '',
        ar_receipt_number: '',
        ar_received_amount: ''
      },
      rules: {
        invoice_date: [{
          required: true,
          message: 'กรุณาระบุ Invoice Date',
          trigger: "blur"
        }],
        gl_date: [{
          required: true,
          message: 'กรุณาระบุ GL Date',
          trigger: "blur"
        }]
      }
    };
  },
  props: ['details', 'index', 'status', 'checkStatusInterface', 'checkStatusConfirmed', 'vars', 'checkStatusCancelled'],
  methods: {
    clickSave: function clickSave() {
      console.log('clickSave');
      this.$emit('modal-details', this.details);
      $("#modal_details".concat(this.index)).modal('hide');
    },
    // clickCancel () {
    //   console.log('clickCancel')
    // },
    getInformantDate: function getInformantDate(obj) {
      this.details.informant_date = obj.value;
    },
    getInvoiceDate: function getInvoiceDate(obj) {
      this.details.invoice_date = obj.value;
    },
    getGLDate: function getGLDate(obj) {
      this.details.gl_date = obj.value;
    },
    getArReceiptDate: function getArReceiptDate(obj) {
      this.details.ar_receipt_date = obj.value;
    },
    getDataArInvoiceNum: function getDataArInvoiceNum(value) {
      this.details.ar_invoice_num = value;
    },
    getValueInformantDate: function getValueInformantDate(date) {
      console.log('getValueInformantDate ', date);
      var formatDate = this.vars.formatDate;

      if (date) {
        this.details.informant_date = moment__WEBPACK_IMPORTED_MODULE_3___default()(date).format(formatDate);
      } else {
        this.details.informant_date = '';
      }
    },
    getValueInvoiceDate: function getValueInvoiceDate(date) {
      console.log('getValueInvoiceDate ', date);
      var formatDate = this.vars.formatDate;

      if (date) {
        this.details.invoice_date = moment__WEBPACK_IMPORTED_MODULE_3___default()(date).format(formatDate);
      } else {
        this.details.invoice_date = '';
      }
    },
    getValueGlDate: function getValueGlDate(date) {
      console.log('getValueGlDate ', date);
      var formatDate = this.vars.formatDate;

      if (date) {
        this.details.gl_date = moment__WEBPACK_IMPORTED_MODULE_3___default()(date).format(formatDate);
      } else {
        this.details.gl_date = '';
      }
    },
    getValueArReceiptDate: function getValueArReceiptDate(date) {
      console.log('getValueArReceiptDate ', date);
      var formatDate = this.vars.formatDate;

      if (date) {
        this.details.ar_receipt_date = moment__WEBPACK_IMPORTED_MODULE_3___default()(date).format(formatDate);
      } else {
        this.details.ar_receipt_date = '';
      }
    }
  },
  components: {
    lovInvoiceNumberAr: _lovInvoiceNumberAr__WEBPACK_IMPORTED_MODULE_0__.default,
    dateInput: _components_calendar_dateInput__WEBPACK_IMPORTED_MODULE_1__.default,
    currencyInput: _components_currencyInput__WEBPACK_IMPORTED_MODULE_2__.default
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/policyHeaderForm.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/policyHeaderForm.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'ir-claim-insurance-policy-header-form'
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/components/calendar/dateInput.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/components/calendar/dateInput.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'ir-components-calendar-date-input',
  data: function data() {
    return {
      date: this.value
    };
  },
  props: ['attrName', 'value', 'sizeSmall', 'placeholder', 'disabled'],
  computed: {},
  mounted: function mounted() {
    var _this = this;

    $(document).ready(function () {
      $("input.date_input").datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        keyboardNavigation: false // updateViewDate: false,
        // immediateUpdates: true

      });
      $("input[name=\"".concat(_this.attrName, "\"]")).on('change', function (event) {
        console.log('change ', event, event.target.value);
        var params = {
          value: event.target.value,
          getTime: $("input[name=\"".concat(_this.attrName, "\"]")).datepicker('getDate').getTime()
        };

        _this.$emit('change-date', params);

        console.log('params ', params);
      });
    });
  },
  watch: {
    'value': function value(newVal, oldVal) {
      this.date = newVal;
    }
  } // updated () {
  //   /** SET DATE */
  //   console.log('updated date ', this.value)
  //   if (this.value) {
  //     $(`input[name="${this.attrName}"]`).datepicker('update', this.value)
  //   }
  // }

});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/components/currencyInput.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/components/currencyInput.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'ir-components-currency-input',
  data: function data() {
    return {
      isInputActive: false,
      decimalValue: this.decimal === undefined ? 2 : this.decimal
    };
  },
  props: ['value', 'name', 'sizeSmall', 'placeholder', 'disabled', 'decimal'],
  computed: {
    displayValue: {
      get: function get() {
        if (this.isInputActive) {
          var value = this.value === undefined || this.value === null ? '' : this.value;
          return value.toString();
        } else {
          if (this.value || this.value === 0 && this.value !== undefined && this.value !== null) {
            var num = parseFloat(this.value);
            var covertToCurrency = this.value.toString().split('.');
            var currency = null;

            if (covertToCurrency[1] === undefined) {
              var decimal = parseInt(covertToCurrency[0]).toFixed(this.decimalValue).split('.')[1];
              currency = "".concat(parseInt(covertToCurrency[0]).toLocaleString(), ".").concat(decimal);
              return currency;
            } else {
              if (num.toString().split('.')[0] == 0) {
                var _decimal2 = num.toFixed(this.decimalValue).split('.')[1];
                return "".concat(num.toString().split('.')[0], ".").concat(_decimal2);
              }

              var _decimal = num.toFixed(this.decimalValue).split('.')[1];

              var _currency = "".concat(parseInt(covertToCurrency[0]).toLocaleString(), ".").concat(_decimal);

              return _currency;
            }
          }
        }
      },
      set: function set(modifiedValue) {
        console.log('modifiedValue -->', modifiedValue);
        var newValue = +modifiedValue;

        if (isNaN(newValue)) {
          newValue = '';
        }

        this.$emit('input', newValue); // // let newValue = parseFloat(modifiedValue.replace(/[^\d\.]/g, ""))
        // // if (isNaN(newValue)) {
        // //   newValue = ''
        // // }
      }
    }
  },
  methods: {
    blur: function blur(event) {
      this.isInputActive = false;
      this.$emit('blur-currency', event.target.value);
    }
  },
  watch: {
    'value': function value(newVal, oldVal) {
      this.$emit('watch-value', newVal);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/components/currencyInputGroupAppend.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/components/currencyInputGroupAppend.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

//
//
//
//
//
//
//
//
//
//
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
  name: 'ir-components-currency-input-group-append',
  data: function data() {
    return {
      isInputActive: false
    };
  },
  props: ['value', 'name', 'sizeSmall', 'placeholder', 'disabled', 'showAppend', 'wordingAppend'],
  computed: {
    displayValue: {
      get: function get() {
        if (this.isInputActive) {
          console.log('this.value ', this.value, _typeof(this.value));
          var value = this.value === undefined || this.value === null ? '' : this.value; // Cursor is inside the input field. unformat display value for user

          return value.toString();
        } else {
          if (this.value || this.value === 0 && this.value !== undefined && this.value !== null) {
            var num = parseFloat(this.value); // User is not modifying now. Format display value for user interface

            return num.toFixed(2).replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,");
          }
        }
      },
      set: function set(modifiedValue) {
        var newValue = +modifiedValue;

        if (isNaN(newValue)) {
          newValue = '';
        }

        this.$emit('input', newValue); // console.log('set ', modifiedValue)
        // // Recalculate value after ignoring "$" and "," in user input
        // let newValue = parseFloat(modifiedValue.replace(/[^\d\.]/g, ""))
        // // Ensure that it is not NaN
        // if (isNaN(newValue)) {
        //   newValue = ''
        // }
        // // Note: we cannot set this.value as it is a "prop". It needs to be passed to parent component
        // // $emit the event so that parent component gets it
        // this.$emit('input', newValue)
      }
    },
    sizeInput: function sizeInput() {
      if (this.sizeSmall) {
        return 'small';
      }

      return '';
    }
  },
  methods: {
    blur: function blur(event) {
      this.isInputActive = false;
      this.$emit('blur-currency', event.target.value);
    },
    focus: function focus() {
      console.log('focus');
      this.isInputActive = true;
    }
  }
});

/***/ }),

/***/ "./resources/js/components/ir/scripts.js":
/*!***********************************************!*\
  !*** ./resources/js/components/ir/scripts.js ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "vars": () => /* binding */ vars,
/* harmony export */   "mocks": () => /* binding */ mocks,
/* harmony export */   "funcs": () => /* binding */ funcs
/* harmony export */ });
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_0__);

/** VARIABLES */

var vars = {
  formatDate: 'DD/MM/YYYY',
  formatMonth: 'MM/YYYY',
  formatYear: 'YYYY',
  monthNameShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
};
/** VARIABLES */

/** MOCKS */

var mocks = {
  irp0001_table_header: [{
    document_number: '',
    status: 'NEW',
    period_year: '2020',
    period_name: 'Jan-20',
    period_from: '12/01/2020',
    period_to: '12/01/2020',
    policy_set_number: '1',
    policy_set_description: 'POLICY SET DESCRIPTION',
    department_code: 'DEPARTMENT CODE',
    department_desc: 'DEPARTMENT DESC'
  }],
  irp0001_table_line: [{
    line_number: '1',
    status: 'NEW',
    period_from: '01/2020',
    period_to: '01/2020',
    period_name: 'Jan-20',
    organization_code: 'ORGANIZATION CODE',
    sub_inventory_code: 'SUB INVENTORY CODE',
    sub_inventory_desc: 'SUB INVENTORY DESC',
    location_code: 'LOCATION CODE',
    location_desc: 'LOCATION DESC',
    item_code: 'ITEM CODE',
    item_description: 'ITEM DESCRIPTION',
    uom_code: 'UOM CODE',
    uom_description: 'UOM DESCRIPTION',
    original_quantity: '12',
    unit_price: '12',
    line_amount: '1212',
    coverage_amount: '343',
    calculate_start_date: '12/04/2021',
    calculate_end_date: '15/04/2021',
    calculate_days: '4',
    line_type: 'MANUAL'
  }, {
    line_number: '2',
    status: 'INTERFACE',
    period_from: '01/2020',
    period_to: '01/2020',
    period_name: 'Jan-20',
    organization_code: 'ORGANIZATION CODE',
    sub_inventory_code: 'SUB INVENTORY CODE',
    sub_inventory_desc: 'SUB INVENTORY DESC',
    location_code: 'LOCATION CODE',
    location_desc: 'LOCATION DESC',
    item_code: 'ITEM CODE',
    item_description: 'ITEM DESCRIPTION',
    uom_code: 'UOM CODE',
    uom_description: 'UOM DESCRIPTION',
    original_quantity: '12',
    unit_price: '12',
    line_amount: '1212',
    coverage_amount: '343',
    calculate_start_date: '12/04/2021',
    calculate_end_date: '15/04/2021',
    calculate_days: '4',
    line_type: 'MANUAL'
  }, {
    line_number: '3',
    status: 'NEW',
    period_from: '01/2020',
    period_to: '01/2020',
    period_name: 'Jan-20',
    organization_code: 'ORGANIZATION CODE',
    sub_inventory_code: 'SUB INVENTORY CODE',
    sub_inventory_desc: 'SUB INVENTORY DESC',
    location_code: 'LOCATION CODE',
    location_desc: 'LOCATION DESC',
    item_code: 'ITEM CODE',
    item_description: 'ITEM DESCRIPTION',
    uom_code: 'UOM CODE',
    uom_description: 'UOM DESCRIPTION',
    original_quantity: '12',
    unit_price: '12',
    line_amount: '1212',
    coverage_amount: '343',
    calculate_start_date: '12/04/2021',
    calculate_end_date: '15/04/2021',
    calculate_days: '4',
    line_type: 'MANUAL'
  }, {
    line_number: '2',
    status: 'CONFIRMED',
    period_from: '01/2020',
    period_to: '01/2020',
    period_name: 'Jan-20',
    organization_code: 'ORGANIZATION CODE',
    sub_inventory_code: 'SUB INVENTORY CODE',
    sub_inventory_desc: 'SUB INVENTORY DESC',
    location_code: 'LOCATION CODE',
    location_desc: 'LOCATION DESC',
    item_code: 'ITEM CODE',
    item_description: 'ITEM DESCRIPTION',
    uom_code: 'UOM CODE',
    uom_description: 'UOM DESCRIPTION',
    original_quantity: '12',
    unit_price: '12',
    line_amount: '1212',
    coverage_amount: '343',
    calculate_start_date: '12/04/2021',
    calculate_end_date: '15/04/2021',
    calculate_days: '4',
    line_type: 'MANUAL'
  }],
  irp0010_table_header: [{
    claim_header_id: '1',
    status: 'NEW',
    document_number: 'Dept-Year-XXX',
    accident_date: '04/08/2019',
    accident_time: '22:00',
    location_code: '',
    location_name: 'สถานีใบยาดอนนางหงส์',
    department_code: '10000000',
    department_name: 'ผู้ว่าการการยาสูบแห่งประเทศไทย',
    requestor_id: '',
    requestor_name: 'นายคนดี ว่องไว',
    requestor_tel: '02-345-6667',
    claim_amount: '400000',
    year: '2020' // tableLine: [{
    //   line_number: '',
    //   line_description: 'เกิดฝนตกหนัก ทำให้เกิดน้ำท่วมฉับพลันไหลเข้าไปในโรงซื้อใบยาสด - เก็บใบยาแห้ง ทำให้ทรัพย์สินได้รับความเสียหาย',
    //   line_amount: '100000'
    // }, {
    //   line_number: '',
    //   line_description: 'เกิดฝนตกหนัก ทำให้เกิดน้ำท่วมฉับพลันทำให้อาคารเสียหาย',
    //   line_amount: '60000'
    // }],
    // apply: {
    //   apply_companies: [{
    //     company_id: '01',
    //     company_name: 'บริษัทกรุงเทพประกันภัย',
    //     claim_percent: '40',
    //     claim_amount: '160000'
    //   }, {
    //     company_id: '02',
    //     company_name: 'บริษัททิพยประกันภัย',
    //     claim_percent: '40',
    //     claim_amount: '160000'
    //   }]
    // },
    // informant_date: '04/08/2020',
    // invoice_date: '15/03/2020',
    // gl_date: '15/03/2020',
    // ar_invoice_num: '120091228',
    // policy_number: '14016-114-06000',
    // ar_receipt_date: '15/03/2020',
    // ar_receipt_id: '',
    // ar_receipt_number: 'RE12110333',
    // ar_received_amount: '350674.21'

  }, {
    claim_header_id: '2',
    status: 'INTERFACE',
    document_number: 'Dept-Year-XXX',
    accident_date: '04/08/2019',
    accident_time: '22:00',
    location_code: '',
    location_name: 'สถานีใบยาดอนนางหงส์',
    department_code: '10000000',
    department_name: 'ผู้ว่าการการยาสูบแห่งประเทศไทย',
    requestor_id: '',
    requestor_name: 'นายคนดี ว่องไว',
    requestor_tel: '02-345-6667',
    claim_amount: '400000',
    year: '2020' // tableLine: [{
    //   line_number: '',
    //   line_description: 'เกิดฝนตกหนัก ทำให้เกิดน้ำท่วมฉับพลันไหลเข้าไปในโรงซื้อใบยาสด - เก็บใบยาแห้ง ทำให้ทรัพย์สินได้รับความเสียหาย',
    //   line_amount: '100000'
    // }, {
    //   line_number: '',
    //   line_description: 'เกิดฝนตกหนัก ทำให้เกิดน้ำท่วมฉับพลันทำให้อาคารเสียหาย',
    //   line_amount: '60000'
    // }],
    // apply: {
    //   apply_companies: [{
    //     company_id: '01',
    //     company_name: 'บริษัทกรุงเทพประกันภัย',
    //     claim_percent: '40',
    //     claim_amount: '160000'
    //   }, {
    //     company_id: '02',
    //     company_name: 'บริษัททิพยประกันภัย',
    //     claim_percent: '40',
    //     claim_amount: '160000'
    //   }]
    // },
    // informant_date: '04/08/2020',
    // invoice_date: '15/03/2020',
    // gl_date: '15/03/2020',
    // ar_invoice_num: '120091228',
    // policy_number: '14016-114-06000',
    // ar_receipt_date: '15/03/2020',
    // ar_receipt_id: '',
    // ar_receipt_number: 'RE12110333',
    // ar_received_amount: '350674.21'

  }],
  irp0010_form: {
    headers: {
      claim_header_id: '1',
      status: 'NEW',
      document_number: 'Dept-Year-XXX',
      accident_date: '04/08/2019',
      accident_time: '22:00',
      location_code: '',
      location_name: 'สถานีใบยาดอนนางหงส์',
      department_code: '10000000',
      department_name: 'ผู้ว่าการการยาสูบแห่งประเทศไทย',
      requestor_id: '',
      requestor_name: 'นายคนดี ว่องไว',
      requestor_tel: '02-345-6667',
      claim_amount: '400000',
      year: '2020'
    },
    apply: {
      apply_company: [{
        company_id: 55,
        company_name: 'บริษัท เทเวศประกันภัย จำกัด (มหาชน)',
        claim_percent: '40',
        claim_amount: '140000',
        // status: 'INTERFACE',
        apply_details: [{
          line_number: '',
          line_description: 'เกิดฝนตกหนัก ทำให้เกิดน้ำท่วมฉับพลันไหลเข้าไปในโรงซื้อใบยาสด - เก็บใบยาแห้ง ทำให้ทรัพย์สินได้รับความเสียหาย',
          line_amount: '100000',
          claim_detail_id: ''
        }, {
          line_number: '',
          line_description: 'เกิดฝนตกหนัก ทำให้เกิดน้ำท่วมฉับพลันทำให้อาคารเสียหาย',
          line_amount: '60000',
          claim_detail_id: ''
        }],
        informant_date: '04/08/2020',
        invoice_date: '15/03/2020',
        gl_date: '15/03/2020',
        ar_invoice_num: '120091228',
        policy_number: '14016-114-06000',
        ar_receipt_date: '15/03/2020',
        ar_receipt_id: '',
        ar_receipt_number: 'RE12110333',
        ar_received_amount: '350674.21',
        claim_apply_id: '',
        ar_invoice_id: ''
      }, {
        company_id: 54,
        company_name: 'บริษัท ทิพยประกันภัย จำกัด (มหาชน)',
        claim_percent: '60',
        claim_amount: '160000',
        // status: 'NEW',
        apply_details: [{
          line_number: '',
          line_description: 'เกิดฝนตกหนัก ทำให้เกิดน้ำท่วมฉับพลันไหลเข้าไปในโรงซื้อใบยาสด - เก็บใบยาแห้ง ทำให้ทรัพย์สินได้รับความเสียหาย',
          line_amount: '100000',
          claim_detail_id: ''
        }, {
          line_number: '',
          line_description: 'เกิดฝนตกหนัก ทำให้เกิดน้ำท่วมฉับพลันทำให้อาคารเสียหาย',
          line_amount: '60000',
          claim_detail_id: ''
        }],
        informant_date: '04/08/2020',
        invoice_date: '15/03/2020',
        gl_date: '15/03/2020',
        ar_invoice_num: '120091228',
        policy_number: '14016-114-06000',
        ar_receipt_date: '15/03/2020',
        ar_receipt_id: '',
        ar_receipt_number: 'RE12110333',
        ar_received_amount: '350674.21',
        claim_apply_id: '',
        ar_invoice_id: ''
      }]
    }
  },
  irp0002_table_line: [{
    status: 'NEW',
    line_number: '',
    period_name: 'Jan-20',
    organization_code: 'ORGANIZATION CODE',
    sub_inventory_code: 'SUB INVENTORY CODE',
    sub_inventory_desc: 'SUB INVENTORY DESC',
    location_code: 'LOCATION CODE',
    location_desc: 'LOCATION DESC',
    item_code: 'ITEM CODE',
    item_description: 'ITEM DESCRIPTION',
    uom_code: 'UOM CODE',
    uom_description: 'UOM DESCRIPTION',
    original_quantity: '111',
    unit_price: '2',
    line_amount: '222',
    coverage_amount: '230',
    calculate_days: '2',
    calculate_start_date: '12/01/2020',
    calculate_end_date: '15/01/2020'
  }]
};
/** MOCKS */

/** FUNCTIONS */

var funcs = {
  setFirstLetterUpperCase: function setFirstLetterUpperCase(value) {
    if (value && value !== null && value !== undefined) {
      var lowerLetter = value.toLowerCase();
      var nameCapitalized = lowerLetter.charAt(0).toUpperCase() + lowerLetter.slice(1);
      return nameCapitalized;
    }

    return value;
  },
  setYearCE: function setYearCE(type, value) {
    var result = ''; // if (type === 'month' && value && value !== null && value !== undefined) {
    //   let arrYearCE = value.split('/')
    //   let yearCE = +arrYearCE[1] - 543
    //   result = `${arrYearCE[0]}/${yearCE}`
    //   return result
    // } else if (type === 'date' && value && value !== null && value !== undefined) {
    //   let arrYearCE = value.split('/')
    //   let yearCE = +arrYearCE[2] - 543
    //   result = `${arrYearCE[0]}/${arrYearCE[1]}/${yearCE}`
    //   return result
    // } else if (type === 'year' && value && value !== null && value !== undefined) {
    //   return +value - 543
    // }

    var format = type === 'month' ? vars.formatMonth : type === 'date' ? vars.formatDate : type === 'year' ? vars.formatYear : '';

    if (value && format) {
      result = moment__WEBPACK_IMPORTED_MODULE_0___default()(moment__WEBPACK_IMPORTED_MODULE_0___default()(value, format).subtract(543, 'years').toDate()).format(format); // add - 543

      return result;
    }

    return result;
  },
  setYearBE: function setYearBE(type, value) {
    var result = ''; // if (type === 'month' && value && value !== null && value !== undefined) {
    //   let arrYearCE = value.split('/')
    //   let yearCE = +arrYearCE[1] - 543
    //   result = `${arrYearCE[0]}/${yearCE}`
    //   return result
    // } else if (type === 'date' && value && value !== null && value !== undefined) {
    //   let arrYearCE = value.split('/')
    //   let yearCE = +arrYearCE[2] - 543
    //   result = `${arrYearCE[0]}/${arrYearCE[1]}/${yearCE}`
    //   return result
    // } else if (type === 'year' && value && value !== null && value !== undefined) {
    //   return +value - 543
    // }

    var format = type === 'month' ? vars.formatMonth : type === 'date' ? vars.formatDate : type === 'year' ? vars.formatYear : '';

    if (value && format) {
      result = moment__WEBPACK_IMPORTED_MODULE_0___default()(moment__WEBPACK_IMPORTED_MODULE_0___default()(value, format).add(543, 'years').toDate()).format(format); // add + 543

      return result;
    }

    return result;
  },
  showYearBE: function showYearBE(type, value) {
    var result = '';

    if (type === 'month' && value && value !== null && value !== undefined) {
      var arrYearBE = value.split('/');
      var yearBE = +arrYearBE[1] + 543;
      result = "".concat(arrYearBE[0], "/").concat(yearBE);
      return result;
    } else if (type === 'date' && value && value !== null && value !== undefined) {
      var _arrYearBE = value.split('/');

      var _yearBE = +_arrYearBE[2] + 543;

      result = "".concat(_arrYearBE[0], "/").concat(_arrYearBE[1], "/").concat(_yearBE);
      return result;
    } else if (type === 'year' && value && value !== null && value !== undefined) {
      return +value + 543;
    }

    return result;
  },
  getTime: function getTime(value) {
    var type = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'date';
    var result = '';

    if (value && value !== null && value !== undefined) {
      var arrDate = value.split('/');
      result = new Date("".concat(arrDate[1], "/").concat(arrDate[0], "/").concat(arrDate[2])).getTime();
      return result;
    }

    return result;
  },
  calculateDate: function calculateDate(start, end) {
    var days = '';
    var qtyDay = '';

    if (start && end) {
      var oneDay = 24 * 60 * 60 * 1000;
      var getTimeStDate = funcs.getTime(start);
      var getTimeEnDate = funcs.getTime(end);
      qtyDay = Math.round(Math.abs((getTimeEnDate - getTimeStDate) / oneDay));
      days = qtyDay ? qtyDay + 1 : qtyDay;
    }

    return days;
  },
  checkStatusInterface: function checkStatusInterface(status) {
    if (status) {
      if (status.toUpperCase() === 'INTERFACE') {
        return true;
      }
    }

    return false;
  },
  checkStatusCancelled: function checkStatusCancelled(status) {
    if (status) {
      if (status.toUpperCase() === 'CANCELLED') {
        return true;
      }
    }

    return false;
  },
  isNullOrUndefined: function isNullOrUndefined(value) {
    if (value === null || value === undefined) {
      return '';
    }

    return value;
  },
  formatCurrency: function formatCurrency(number) {
    var decimalValue = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 2;
    var num = '';

    if (number || number === 0) {
      num = parseFloat(number);
      var covertToCurrency = number.toString().split('.');
      var currency = null;

      if (covertToCurrency[1] === undefined) {
        var decimal = parseInt(covertToCurrency[0]).toFixed(decimalValue).split('.')[1];
        currency = "".concat(parseInt(covertToCurrency[0]).toLocaleString(), ".").concat(decimal);
        return currency;
      } else {
        if (num.toString().split('.')[0] == 0) {
          var _decimal2 = num.toFixed(decimalValue).split('.')[1];
          return "".concat(num.toString().split('.')[0], ".").concat(_decimal2);
        }

        var _decimal = num.toFixed(decimalValue).split('.')[1];

        var _currency = "".concat(parseInt(covertToCurrency[0]).toLocaleString(), ".").concat(_decimal);

        return _currency;
      } // let setNum = num.toFixed(decimal).replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,")
      // return setNum

    }

    return num;
  },
  formatfloat: function formatfloat(number) {
    var digit = "2";
    return number.slice(0, number.indexOf(".") + 1 + +digit);
  },
  checkStatusConfirmed: function checkStatusConfirmed(status) {
    if (status) {
      if (status.toUpperCase() === 'CONFIRMED') {
        return true;
      }

      return false;
    }
  },
  showPeriodNameFormat: function showPeriodNameFormat(period_name) {
    if (period_name) {
      var period_nameStr = period_name.split('-');
      var getDate = new Date("".concat(period_nameStr[0], " 01, ").concat(period_nameStr[1]));
      var year = getDate.getFullYear();
      var month = (getDate.getMonth() + 1).toString().length === 1 ? "0".concat(getDate.getMonth() + 1) : getDate.getMonth() + 1;
      return "".concat(month, "/").concat(year + 543);
    }

    return period_name;
  },
  setValuePeriodNameFormat: function setValuePeriodNameFormat(date) {
    var period_name = '';

    if (date && date !== null && date !== undefined) {
      var monthName = vars.monthNameShort[date.getMonth()];
      var getFullYearCE = +date.getFullYear() - 543;
      var getFullYearCEStr = getFullYearCE.toString();
      var yearShort = getFullYearCEStr.substr(getFullYearCEStr.length - 2);
      period_name = "".concat(monthName, "-").concat(yearShort);
    }

    return period_name;
  },
  checkStatusNew: function checkStatusNew(status) {
    if (status) {
      if (status.toUpperCase() === 'NEW') {
        return true;
      }
    }
  },
  calculateDateMomentTable: function calculateDateMomentTable(row) {
    var formatDate = vars.formatDate;
    var momentStDate = '';
    var momentEnDate = '';
    var days = '';
    var start = row.start_calculate_date;
    var end = row.end_calculate_date;

    if (start && end) {
      var full_date_st = helperDate.convertDate(start, formatDate);
      var full_date_en = helperDate.convertDate(end, formatDate);
      full_date_st.then(function (st) {
        momentStDate = moment__WEBPACK_IMPORTED_MODULE_0___default()(st, formatDate);
        full_date_en.then(function (en) {
          momentEnDate = moment__WEBPACK_IMPORTED_MODULE_0___default()(en, formatDate);
          days = momentEnDate.diff(momentStDate, 'days');
          row.days = Math.sign(days) === -1 ? '' : days + 1;
        });
      });
    } else {
      row.days = '';
    }
  },
  covertFomatDateMoment: function covertFomatDateMoment(date, type) {
    var format = type === 'date' ? vars.formatDate : type === 'month' ? vars.formatMonth : type === 'year' ? vars.formatYear : '';

    if (date && type) {
      return moment__WEBPACK_IMPORTED_MODULE_0___default()(date).format(format);
    }

    return '';
  },
  setBudgetYearFromFieldStCalendar: function setBudgetYearFromFieldStCalendar(start) {
    var type = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'date';
    var format = type === 'date' ? vars.formatDate : type === 'month' ? vars.formatMonth : type === 'year' ? vars.formatYear : '';
    var budgetYear = '';

    if (start) {
      var currentYear = start.getFullYear();
      var cycle = moment__WEBPACK_IMPORTED_MODULE_0___default()({
        'year': currentYear,
        'month': 8,
        'date': 30
      });
      var stMoMent = moment__WEBPACK_IMPORTED_MODULE_0___default()({
        'year': start.getFullYear(),
        'month': start.getMonth(),
        'date': start.getDate()
      });
      var offset = stMoMent.isAfter(cycle) ? 1 : 0;
      return moment__WEBPACK_IMPORTED_MODULE_0___default()(moment__WEBPACK_IMPORTED_MODULE_0___default()({
        'year': currentYear + offset,
        'month': 8,
        'date': 30
      }), vars.formatDate).toDate();
      var getMonth = start.getMonth();

      if (getMonth > 8 || getMonth === 10) {
        var nextYearFull = moment__WEBPACK_IMPORTED_MODULE_0___default()(start).add(1, 'years').format(vars.formatYear);
        var nextYearNum = nextYearFull ? +nextYearFull : nextYearFull;
        budgetYear = moment__WEBPACK_IMPORTED_MODULE_0___default().utc().set({
          'year': nextYearNum,
          'month': 8,
          'date': 30
        }); // month = 8 is Sept

        return moment__WEBPACK_IMPORTED_MODULE_0___default()(budgetYear, vars.formatDate).toDate(); // return budgetYear.format(vars.formatDate);
      } else {
        var year = moment__WEBPACK_IMPORTED_MODULE_0___default()(start).format(vars.formatYear);
        var yearNum = year ? +year : year;
        budgetYear = moment__WEBPACK_IMPORTED_MODULE_0___default().utc().set({
          'year': yearNum,
          'month': 8,
          'date': 30
        }); // month = 8 is Sept

        return moment__WEBPACK_IMPORTED_MODULE_0___default()(budgetYear, vars.formatDate).toDate(); // return budgetYear.format(vars.formatDate);
      } // // let nextYearFormat = moment(nextYearFull).format(vars.formatYear);
      // let nextYearNum = nextYearFull ? +nextYearFull : nextYearFull;
      // budgetYear = moment.utc().set({'year': nextYearNum, 'month': 8, 'date': 30}); // month = 8 is Sept
      // // var newDate = moment.utc();
      // // newDate.set('year', nextYearNum);
      // // newDate.set('month', 8); // month = 8 is Sept
      // // newDate.set('date', 30);
      // // // newDate.startOf('day');
      // return budgetYear;

    }

    return budgetYear;
  },
  setLabelStatusAsset: function setLabelStatusAsset(status) {
    if (status === 'Y') {
      return 'Active';
    } else if (status === 'N') {
      return 'Inactive';
    } else {
      return '';
    }
  },
  setFotmatPeriodNameIsFullDate: function setFotmatPeriodNameIsFullDate(period_name) {
    if (period_name) {
      var periodNameStr = period_name.split('-');
      var getDate = new Date("".concat(periodNameStr[0], " 01, ").concat(periodNameStr[1]));
      return moment__WEBPACK_IMPORTED_MODULE_0___default()(getDate).format(vars.formatDate);
    }

    return '';
  },
  setFullDateIsDateCE: function setFullDateIsDateCE(fullDate) {
    var dateCE = '';

    if (fullDate) {
      var dateBE = moment__WEBPACK_IMPORTED_MODULE_0___default()(fullDate).format(vars.formatDate);
      dateCE = funcs.setYearCE('date', dateBE);
      return dateCE;
    }

    return dateCE;
  },
  setLabelExpenseFlag: function setLabelExpenseFlag(flag) {
    if (flag == 'Y') {
      return 'Yes';
    }

    return 'No';
  },
  setLabelVatRefund: function setLabelVatRefund(flag) {
    if (flag == 'Y') {
      return 'Yes';
    }

    return 'No';
  },
  // IRM0001, IRM0002
  setDefaultActive: function setDefaultActive(classNameCheckbox) {
    var checked = $(".".concat(classNameCheckbox)).is(':checked');
    $(".".concat(classNameCheckbox)).prop('checked', !checked);
  },
  setDefaultEndDateIsLastDateOfMonth: function setDefaultEndDateIsLastDateOfMonth(startFullDate) {
    var formatDate = vars.formatDate;
    var result = '';

    if (startFullDate) {
      var lastDateOfMonth = moment__WEBPACK_IMPORTED_MODULE_0___default()(startFullDate).endOf('month');
      return moment__WEBPACK_IMPORTED_MODULE_0___default()(lastDateOfMonth).format(formatDate);
    }

    return result;
  }
};
/** FUNCTIONS */

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/form-claim.vue?vue&type=style&index=0&id=2350dfb8&scoped=true&lang=css&":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/form-claim.vue?vue&type=style&index=0&id=2350dfb8&scoped=true&lang=css& ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, "th[data-v-2350dfb8], td[data-v-2350dfb8] {\n  padding: 0.25rem;\n}\nth[data-v-2350dfb8] {\n  position: -webkit-sticky;\n  position: sticky;\n  top: 0; /* Don't forget this, required for the stickiness */\n}\n.custom-file-label[data-v-2350dfb8]::after {\n  background-color: #F5F7FA;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/components/currencyInput.vue?vue&type=style&index=0&id=0d3f0f2b&scoped=true&lang=css&":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/components/currencyInput.vue?vue&type=style&index=0&id=0d3f0f2b&scoped=true&lang=css& ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, ".text-right[data-v-0d3f0f2b] {\n  text-align: right;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/form-claim.vue?vue&type=style&index=0&id=2350dfb8&scoped=true&lang=css&":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/form-claim.vue?vue&type=style&index=0&id=2350dfb8&scoped=true&lang=css& ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_form_claim_vue_vue_type_style_index_0_id_2350dfb8_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./form-claim.vue?vue&type=style&index=0&id=2350dfb8&scoped=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/form-claim.vue?vue&type=style&index=0&id=2350dfb8&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_form_claim_vue_vue_type_style_index_0_id_2350dfb8_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_form_claim_vue_vue_type_style_index_0_id_2350dfb8_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/components/currencyInput.vue?vue&type=style&index=0&id=0d3f0f2b&scoped=true&lang=css&":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/components/currencyInput.vue?vue&type=style&index=0&id=0d3f0f2b&scoped=true&lang=css& ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_currencyInput_vue_vue_type_style_index_0_id_0d3f0f2b_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./currencyInput.vue?vue&type=style&index=0&id=0d3f0f2b&scoped=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/components/currencyInput.vue?vue&type=style&index=0&id=0d3f0f2b&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_currencyInput_vue_vue_type_style_index_0_id_0d3f0f2b_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_currencyInput_vue_vue_type_style_index_0_id_0d3f0f2b_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/create.vue":
/*!***************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/create.vue ***!
  \***************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _create_vue_vue_type_template_id_52e4d32d___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./create.vue?vue&type=template&id=52e4d32d& */ "./resources/js/components/ir/claim-insurance/create.vue?vue&type=template&id=52e4d32d&");
/* harmony import */ var _create_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./create.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/claim-insurance/create.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _create_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _create_vue_vue_type_template_id_52e4d32d___WEBPACK_IMPORTED_MODULE_0__.render,
  _create_vue_vue_type_template_id_52e4d32d___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/claim-insurance/create.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/form-claim.vue":
/*!*******************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/form-claim.vue ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _form_claim_vue_vue_type_template_id_2350dfb8_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./form-claim.vue?vue&type=template&id=2350dfb8&scoped=true& */ "./resources/js/components/ir/claim-insurance/form-claim.vue?vue&type=template&id=2350dfb8&scoped=true&");
/* harmony import */ var _form_claim_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./form-claim.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/claim-insurance/form-claim.vue?vue&type=script&lang=js&");
/* harmony import */ var _form_claim_vue_vue_type_style_index_0_id_2350dfb8_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./form-claim.vue?vue&type=style&index=0&id=2350dfb8&scoped=true&lang=css& */ "./resources/js/components/ir/claim-insurance/form-claim.vue?vue&type=style&index=0&id=2350dfb8&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _form_claim_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _form_claim_vue_vue_type_template_id_2350dfb8_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _form_claim_vue_vue_type_template_id_2350dfb8_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "2350dfb8",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/claim-insurance/form-claim.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/headerForm.vue":
/*!*******************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/headerForm.vue ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _headerForm_vue_vue_type_template_id_4ab81022___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./headerForm.vue?vue&type=template&id=4ab81022& */ "./resources/js/components/ir/claim-insurance/headerForm.vue?vue&type=template&id=4ab81022&");
/* harmony import */ var _headerForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./headerForm.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/claim-insurance/headerForm.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _headerForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _headerForm_vue_vue_type_template_id_4ab81022___WEBPACK_IMPORTED_MODULE_0__.render,
  _headerForm_vue_vue_type_template_id_4ab81022___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/claim-insurance/headerForm.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/lovCompany.vue":
/*!*******************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/lovCompany.vue ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _lovCompany_vue_vue_type_template_id_591d145b___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./lovCompany.vue?vue&type=template&id=591d145b& */ "./resources/js/components/ir/claim-insurance/lovCompany.vue?vue&type=template&id=591d145b&");
/* harmony import */ var _lovCompany_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./lovCompany.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/claim-insurance/lovCompany.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _lovCompany_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _lovCompany_vue_vue_type_template_id_591d145b___WEBPACK_IMPORTED_MODULE_0__.render,
  _lovCompany_vue_vue_type_template_id_591d145b___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/claim-insurance/lovCompany.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/lovCompanyPolicyGroup.vue":
/*!******************************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/lovCompanyPolicyGroup.vue ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _lovCompanyPolicyGroup_vue_vue_type_template_id_083732c2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./lovCompanyPolicyGroup.vue?vue&type=template&id=083732c2& */ "./resources/js/components/ir/claim-insurance/lovCompanyPolicyGroup.vue?vue&type=template&id=083732c2&");
/* harmony import */ var _lovCompanyPolicyGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./lovCompanyPolicyGroup.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/claim-insurance/lovCompanyPolicyGroup.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _lovCompanyPolicyGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _lovCompanyPolicyGroup_vue_vue_type_template_id_083732c2___WEBPACK_IMPORTED_MODULE_0__.render,
  _lovCompanyPolicyGroup_vue_vue_type_template_id_083732c2___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/claim-insurance/lovCompanyPolicyGroup.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/lovDepartment.vue":
/*!**********************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/lovDepartment.vue ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _lovDepartment_vue_vue_type_template_id_51097364___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./lovDepartment.vue?vue&type=template&id=51097364& */ "./resources/js/components/ir/claim-insurance/lovDepartment.vue?vue&type=template&id=51097364&");
/* harmony import */ var _lovDepartment_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./lovDepartment.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/claim-insurance/lovDepartment.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _lovDepartment_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _lovDepartment_vue_vue_type_template_id_51097364___WEBPACK_IMPORTED_MODULE_0__.render,
  _lovDepartment_vue_vue_type_template_id_51097364___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/claim-insurance/lovDepartment.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/lovInvoiceNumberAr.vue":
/*!***************************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/lovInvoiceNumberAr.vue ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _lovInvoiceNumberAr_vue_vue_type_template_id_74e36c85___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./lovInvoiceNumberAr.vue?vue&type=template&id=74e36c85& */ "./resources/js/components/ir/claim-insurance/lovInvoiceNumberAr.vue?vue&type=template&id=74e36c85&");
/* harmony import */ var _lovInvoiceNumberAr_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./lovInvoiceNumberAr.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/claim-insurance/lovInvoiceNumberAr.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _lovInvoiceNumberAr_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _lovInvoiceNumberAr_vue_vue_type_template_id_74e36c85___WEBPACK_IMPORTED_MODULE_0__.render,
  _lovInvoiceNumberAr_vue_vue_type_template_id_74e36c85___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/claim-insurance/lovInvoiceNumberAr.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/lovLocation.vue":
/*!********************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/lovLocation.vue ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _lovLocation_vue_vue_type_template_id_746f3cc7___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./lovLocation.vue?vue&type=template&id=746f3cc7& */ "./resources/js/components/ir/claim-insurance/lovLocation.vue?vue&type=template&id=746f3cc7&");
/* harmony import */ var _lovLocation_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./lovLocation.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/claim-insurance/lovLocation.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _lovLocation_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _lovLocation_vue_vue_type_template_id_746f3cc7___WEBPACK_IMPORTED_MODULE_0__.render,
  _lovLocation_vue_vue_type_template_id_746f3cc7___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/claim-insurance/lovLocation.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/lovPolicyGroup.vue":
/*!***********************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/lovPolicyGroup.vue ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _lovPolicyGroup_vue_vue_type_template_id_31f6456a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./lovPolicyGroup.vue?vue&type=template&id=31f6456a& */ "./resources/js/components/ir/claim-insurance/lovPolicyGroup.vue?vue&type=template&id=31f6456a&");
/* harmony import */ var _lovPolicyGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./lovPolicyGroup.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/claim-insurance/lovPolicyGroup.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _lovPolicyGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _lovPolicyGroup_vue_vue_type_template_id_31f6456a___WEBPACK_IMPORTED_MODULE_0__.render,
  _lovPolicyGroup_vue_vue_type_template_id_31f6456a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/claim-insurance/lovPolicyGroup.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/lovPolicySetHeaderId.vue":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/lovPolicySetHeaderId.vue ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _lovPolicySetHeaderId_vue_vue_type_template_id_6cbf2d56___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./lovPolicySetHeaderId.vue?vue&type=template&id=6cbf2d56& */ "./resources/js/components/ir/claim-insurance/lovPolicySetHeaderId.vue?vue&type=template&id=6cbf2d56&");
/* harmony import */ var _lovPolicySetHeaderId_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./lovPolicySetHeaderId.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/claim-insurance/lovPolicySetHeaderId.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _lovPolicySetHeaderId_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _lovPolicySetHeaderId_vue_vue_type_template_id_6cbf2d56___WEBPACK_IMPORTED_MODULE_0__.render,
  _lovPolicySetHeaderId_vue_vue_type_template_id_6cbf2d56___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/claim-insurance/lovPolicySetHeaderId.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/modalDetails.vue":
/*!*********************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/modalDetails.vue ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _modalDetails_vue_vue_type_template_id_3f382c74___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./modalDetails.vue?vue&type=template&id=3f382c74& */ "./resources/js/components/ir/claim-insurance/modalDetails.vue?vue&type=template&id=3f382c74&");
/* harmony import */ var _modalDetails_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./modalDetails.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/claim-insurance/modalDetails.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _modalDetails_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _modalDetails_vue_vue_type_template_id_3f382c74___WEBPACK_IMPORTED_MODULE_0__.render,
  _modalDetails_vue_vue_type_template_id_3f382c74___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/claim-insurance/modalDetails.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/policyHeaderForm.vue":
/*!*************************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/policyHeaderForm.vue ***!
  \*************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _policyHeaderForm_vue_vue_type_template_id_6deb8b34___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./policyHeaderForm.vue?vue&type=template&id=6deb8b34& */ "./resources/js/components/ir/claim-insurance/policyHeaderForm.vue?vue&type=template&id=6deb8b34&");
/* harmony import */ var _policyHeaderForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./policyHeaderForm.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/claim-insurance/policyHeaderForm.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _policyHeaderForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _policyHeaderForm_vue_vue_type_template_id_6deb8b34___WEBPACK_IMPORTED_MODULE_0__.render,
  _policyHeaderForm_vue_vue_type_template_id_6deb8b34___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/claim-insurance/policyHeaderForm.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/components/calendar/dateInput.vue":
/*!**********************************************************************!*\
  !*** ./resources/js/components/ir/components/calendar/dateInput.vue ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _dateInput_vue_vue_type_template_id_534314ae___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./dateInput.vue?vue&type=template&id=534314ae& */ "./resources/js/components/ir/components/calendar/dateInput.vue?vue&type=template&id=534314ae&");
/* harmony import */ var _dateInput_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./dateInput.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/components/calendar/dateInput.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _dateInput_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _dateInput_vue_vue_type_template_id_534314ae___WEBPACK_IMPORTED_MODULE_0__.render,
  _dateInput_vue_vue_type_template_id_534314ae___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/components/calendar/dateInput.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/components/currencyInput.vue":
/*!*****************************************************************!*\
  !*** ./resources/js/components/ir/components/currencyInput.vue ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _currencyInput_vue_vue_type_template_id_0d3f0f2b_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./currencyInput.vue?vue&type=template&id=0d3f0f2b&scoped=true& */ "./resources/js/components/ir/components/currencyInput.vue?vue&type=template&id=0d3f0f2b&scoped=true&");
/* harmony import */ var _currencyInput_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./currencyInput.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/components/currencyInput.vue?vue&type=script&lang=js&");
/* harmony import */ var _currencyInput_vue_vue_type_style_index_0_id_0d3f0f2b_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./currencyInput.vue?vue&type=style&index=0&id=0d3f0f2b&scoped=true&lang=css& */ "./resources/js/components/ir/components/currencyInput.vue?vue&type=style&index=0&id=0d3f0f2b&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _currencyInput_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _currencyInput_vue_vue_type_template_id_0d3f0f2b_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _currencyInput_vue_vue_type_template_id_0d3f0f2b_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "0d3f0f2b",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/components/currencyInput.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/components/currencyInputGroupAppend.vue":
/*!****************************************************************************!*\
  !*** ./resources/js/components/ir/components/currencyInputGroupAppend.vue ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _currencyInputGroupAppend_vue_vue_type_template_id_773135fe___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./currencyInputGroupAppend.vue?vue&type=template&id=773135fe& */ "./resources/js/components/ir/components/currencyInputGroupAppend.vue?vue&type=template&id=773135fe&");
/* harmony import */ var _currencyInputGroupAppend_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./currencyInputGroupAppend.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/components/currencyInputGroupAppend.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _currencyInputGroupAppend_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _currencyInputGroupAppend_vue_vue_type_template_id_773135fe___WEBPACK_IMPORTED_MODULE_0__.render,
  _currencyInputGroupAppend_vue_vue_type_template_id_773135fe___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/components/currencyInputGroupAppend.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/create.vue?vue&type=script&lang=js&":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/create.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_create_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./create.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/create.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_create_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/form-claim.vue?vue&type=script&lang=js&":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/form-claim.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_form_claim_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./form-claim.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/form-claim.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_form_claim_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/headerForm.vue?vue&type=script&lang=js&":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/headerForm.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_headerForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./headerForm.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/headerForm.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_headerForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/lovCompany.vue?vue&type=script&lang=js&":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/lovCompany.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_lovCompany_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./lovCompany.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovCompany.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_lovCompany_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/lovCompanyPolicyGroup.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/lovCompanyPolicyGroup.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_lovCompanyPolicyGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./lovCompanyPolicyGroup.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovCompanyPolicyGroup.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_lovCompanyPolicyGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/lovDepartment.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/lovDepartment.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_lovDepartment_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./lovDepartment.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovDepartment.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_lovDepartment_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/lovInvoiceNumberAr.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/lovInvoiceNumberAr.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_lovInvoiceNumberAr_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./lovInvoiceNumberAr.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovInvoiceNumberAr.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_lovInvoiceNumberAr_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/lovLocation.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/lovLocation.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_lovLocation_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./lovLocation.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovLocation.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_lovLocation_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/lovPolicyGroup.vue?vue&type=script&lang=js&":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/lovPolicyGroup.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_lovPolicyGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./lovPolicyGroup.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovPolicyGroup.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_lovPolicyGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/lovPolicySetHeaderId.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/lovPolicySetHeaderId.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_lovPolicySetHeaderId_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./lovPolicySetHeaderId.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovPolicySetHeaderId.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_lovPolicySetHeaderId_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/modalDetails.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/modalDetails.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_modalDetails_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./modalDetails.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/modalDetails.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_modalDetails_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/policyHeaderForm.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/policyHeaderForm.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_policyHeaderForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./policyHeaderForm.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/policyHeaderForm.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_policyHeaderForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/components/calendar/dateInput.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/components/ir/components/calendar/dateInput.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_dateInput_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./dateInput.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/components/calendar/dateInput.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_dateInput_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/components/currencyInput.vue?vue&type=script&lang=js&":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/ir/components/currencyInput.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_currencyInput_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./currencyInput.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/components/currencyInput.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_currencyInput_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/components/currencyInputGroupAppend.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/components/ir/components/currencyInputGroupAppend.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_currencyInputGroupAppend_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./currencyInputGroupAppend.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/components/currencyInputGroupAppend.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_currencyInputGroupAppend_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/form-claim.vue?vue&type=style&index=0&id=2350dfb8&scoped=true&lang=css&":
/*!****************************************************************************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/form-claim.vue?vue&type=style&index=0&id=2350dfb8&scoped=true&lang=css& ***!
  \****************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_form_claim_vue_vue_type_style_index_0_id_2350dfb8_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./form-claim.vue?vue&type=style&index=0&id=2350dfb8&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/form-claim.vue?vue&type=style&index=0&id=2350dfb8&scoped=true&lang=css&");


/***/ }),

/***/ "./resources/js/components/ir/components/currencyInput.vue?vue&type=style&index=0&id=0d3f0f2b&scoped=true&lang=css&":
/*!**************************************************************************************************************************!*\
  !*** ./resources/js/components/ir/components/currencyInput.vue?vue&type=style&index=0&id=0d3f0f2b&scoped=true&lang=css& ***!
  \**************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_currencyInput_vue_vue_type_style_index_0_id_0d3f0f2b_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./currencyInput.vue?vue&type=style&index=0&id=0d3f0f2b&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/components/currencyInput.vue?vue&type=style&index=0&id=0d3f0f2b&scoped=true&lang=css&");


/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/create.vue?vue&type=template&id=52e4d32d&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/create.vue?vue&type=template&id=52e4d32d& ***!
  \**********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_create_vue_vue_type_template_id_52e4d32d___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_create_vue_vue_type_template_id_52e4d32d___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_create_vue_vue_type_template_id_52e4d32d___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./create.vue?vue&type=template&id=52e4d32d& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/create.vue?vue&type=template&id=52e4d32d&");


/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/form-claim.vue?vue&type=template&id=2350dfb8&scoped=true&":
/*!**************************************************************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/form-claim.vue?vue&type=template&id=2350dfb8&scoped=true& ***!
  \**************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_form_claim_vue_vue_type_template_id_2350dfb8_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_form_claim_vue_vue_type_template_id_2350dfb8_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_form_claim_vue_vue_type_template_id_2350dfb8_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./form-claim.vue?vue&type=template&id=2350dfb8&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/form-claim.vue?vue&type=template&id=2350dfb8&scoped=true&");


/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/headerForm.vue?vue&type=template&id=4ab81022&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/headerForm.vue?vue&type=template&id=4ab81022& ***!
  \**************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_headerForm_vue_vue_type_template_id_4ab81022___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_headerForm_vue_vue_type_template_id_4ab81022___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_headerForm_vue_vue_type_template_id_4ab81022___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./headerForm.vue?vue&type=template&id=4ab81022& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/headerForm.vue?vue&type=template&id=4ab81022&");


/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/lovCompany.vue?vue&type=template&id=591d145b&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/lovCompany.vue?vue&type=template&id=591d145b& ***!
  \**************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_lovCompany_vue_vue_type_template_id_591d145b___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_lovCompany_vue_vue_type_template_id_591d145b___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_lovCompany_vue_vue_type_template_id_591d145b___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./lovCompany.vue?vue&type=template&id=591d145b& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovCompany.vue?vue&type=template&id=591d145b&");


/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/lovCompanyPolicyGroup.vue?vue&type=template&id=083732c2&":
/*!*************************************************************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/lovCompanyPolicyGroup.vue?vue&type=template&id=083732c2& ***!
  \*************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_lovCompanyPolicyGroup_vue_vue_type_template_id_083732c2___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_lovCompanyPolicyGroup_vue_vue_type_template_id_083732c2___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_lovCompanyPolicyGroup_vue_vue_type_template_id_083732c2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./lovCompanyPolicyGroup.vue?vue&type=template&id=083732c2& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovCompanyPolicyGroup.vue?vue&type=template&id=083732c2&");


/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/lovDepartment.vue?vue&type=template&id=51097364&":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/lovDepartment.vue?vue&type=template&id=51097364& ***!
  \*****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_lovDepartment_vue_vue_type_template_id_51097364___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_lovDepartment_vue_vue_type_template_id_51097364___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_lovDepartment_vue_vue_type_template_id_51097364___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./lovDepartment.vue?vue&type=template&id=51097364& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovDepartment.vue?vue&type=template&id=51097364&");


/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/lovInvoiceNumberAr.vue?vue&type=template&id=74e36c85&":
/*!**********************************************************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/lovInvoiceNumberAr.vue?vue&type=template&id=74e36c85& ***!
  \**********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_lovInvoiceNumberAr_vue_vue_type_template_id_74e36c85___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_lovInvoiceNumberAr_vue_vue_type_template_id_74e36c85___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_lovInvoiceNumberAr_vue_vue_type_template_id_74e36c85___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./lovInvoiceNumberAr.vue?vue&type=template&id=74e36c85& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovInvoiceNumberAr.vue?vue&type=template&id=74e36c85&");


/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/lovLocation.vue?vue&type=template&id=746f3cc7&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/lovLocation.vue?vue&type=template&id=746f3cc7& ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_lovLocation_vue_vue_type_template_id_746f3cc7___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_lovLocation_vue_vue_type_template_id_746f3cc7___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_lovLocation_vue_vue_type_template_id_746f3cc7___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./lovLocation.vue?vue&type=template&id=746f3cc7& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovLocation.vue?vue&type=template&id=746f3cc7&");


/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/lovPolicyGroup.vue?vue&type=template&id=31f6456a&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/lovPolicyGroup.vue?vue&type=template&id=31f6456a& ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_lovPolicyGroup_vue_vue_type_template_id_31f6456a___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_lovPolicyGroup_vue_vue_type_template_id_31f6456a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_lovPolicyGroup_vue_vue_type_template_id_31f6456a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./lovPolicyGroup.vue?vue&type=template&id=31f6456a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovPolicyGroup.vue?vue&type=template&id=31f6456a&");


/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/lovPolicySetHeaderId.vue?vue&type=template&id=6cbf2d56&":
/*!************************************************************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/lovPolicySetHeaderId.vue?vue&type=template&id=6cbf2d56& ***!
  \************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_lovPolicySetHeaderId_vue_vue_type_template_id_6cbf2d56___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_lovPolicySetHeaderId_vue_vue_type_template_id_6cbf2d56___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_lovPolicySetHeaderId_vue_vue_type_template_id_6cbf2d56___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./lovPolicySetHeaderId.vue?vue&type=template&id=6cbf2d56& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovPolicySetHeaderId.vue?vue&type=template&id=6cbf2d56&");


/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/modalDetails.vue?vue&type=template&id=3f382c74&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/modalDetails.vue?vue&type=template&id=3f382c74& ***!
  \****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_modalDetails_vue_vue_type_template_id_3f382c74___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_modalDetails_vue_vue_type_template_id_3f382c74___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_modalDetails_vue_vue_type_template_id_3f382c74___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./modalDetails.vue?vue&type=template&id=3f382c74& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/modalDetails.vue?vue&type=template&id=3f382c74&");


/***/ }),

/***/ "./resources/js/components/ir/claim-insurance/policyHeaderForm.vue?vue&type=template&id=6deb8b34&":
/*!********************************************************************************************************!*\
  !*** ./resources/js/components/ir/claim-insurance/policyHeaderForm.vue?vue&type=template&id=6deb8b34& ***!
  \********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_policyHeaderForm_vue_vue_type_template_id_6deb8b34___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_policyHeaderForm_vue_vue_type_template_id_6deb8b34___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_policyHeaderForm_vue_vue_type_template_id_6deb8b34___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./policyHeaderForm.vue?vue&type=template&id=6deb8b34& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/policyHeaderForm.vue?vue&type=template&id=6deb8b34&");


/***/ }),

/***/ "./resources/js/components/ir/components/calendar/dateInput.vue?vue&type=template&id=534314ae&":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/components/ir/components/calendar/dateInput.vue?vue&type=template&id=534314ae& ***!
  \*****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_dateInput_vue_vue_type_template_id_534314ae___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_dateInput_vue_vue_type_template_id_534314ae___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_dateInput_vue_vue_type_template_id_534314ae___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./dateInput.vue?vue&type=template&id=534314ae& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/components/calendar/dateInput.vue?vue&type=template&id=534314ae&");


/***/ }),

/***/ "./resources/js/components/ir/components/currencyInput.vue?vue&type=template&id=0d3f0f2b&scoped=true&":
/*!************************************************************************************************************!*\
  !*** ./resources/js/components/ir/components/currencyInput.vue?vue&type=template&id=0d3f0f2b&scoped=true& ***!
  \************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_currencyInput_vue_vue_type_template_id_0d3f0f2b_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_currencyInput_vue_vue_type_template_id_0d3f0f2b_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_currencyInput_vue_vue_type_template_id_0d3f0f2b_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./currencyInput.vue?vue&type=template&id=0d3f0f2b&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/components/currencyInput.vue?vue&type=template&id=0d3f0f2b&scoped=true&");


/***/ }),

/***/ "./resources/js/components/ir/components/currencyInputGroupAppend.vue?vue&type=template&id=773135fe&":
/*!***********************************************************************************************************!*\
  !*** ./resources/js/components/ir/components/currencyInputGroupAppend.vue?vue&type=template&id=773135fe& ***!
  \***********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_currencyInputGroupAppend_vue_vue_type_template_id_773135fe___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_currencyInputGroupAppend_vue_vue_type_template_id_773135fe___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_currencyInputGroupAppend_vue_vue_type_template_id_773135fe___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./currencyInputGroupAppend.vue?vue&type=template&id=773135fe& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/components/currencyInputGroupAppend.vue?vue&type=template&id=773135fe&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/create.vue?vue&type=template&id=52e4d32d&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/create.vue?vue&type=template&id=52e4d32d& ***!
  \*************************************************************************************************************************************************************************************************************************************/
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
      _c("form-claim-insurance", {
        attrs: {
          claim: _vm.claim,
          isNullOrUndefined: _vm.funcs.isNullOrUndefined,
          checkStatusInterface: _vm.funcs.checkStatusInterface,
          checkStatusConfirmed: _vm.funcs.checkStatusConfirmed,
          checkStatusCancelled: _vm.funcs.checkStatusCancelled,
          action: _vm.action,
          setYearCE: _vm.funcs.setYearCE,
          vars: _vm.vars
        }
      })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/form-claim.vue?vue&type=template&id=2350dfb8&scoped=true&":
/*!*****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/form-claim.vue?vue&type=template&id=2350dfb8&scoped=true& ***!
  \*****************************************************************************************************************************************************************************************************************************************************/
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
      _c("h5", [_vm._v("รายละเอียดการเกิดเหตุ")]),
      _vm._v(" "),
      _c(
        "el-form",
        {
          ref: "claim_insurance",
          staticClass: "demo-ruleForm margin_top_20",
          attrs: { model: _vm.claim, "label-width": "120px", rules: _vm.rules }
        },
        [
          _c(
            "div",
            { staticClass: "col-lg-12" },
            [
              _c("div", { staticClass: "headers" }, [
                _c("div", { staticClass: "row" }, [
                  _c(
                    "label",
                    { staticClass: "col-md-5 col-form-label lable_align" },
                    [_c("strong", [_vm._v("วันที่เกิดเหตุ *")])]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-xl-4 col-lg-5 col-md-6 el_field" },
                    [
                      _c(
                        "el-form-item",
                        { attrs: { prop: "headers.accident_date" } },
                        [
                          _c("datepicker-th", {
                            staticClass: "el-input__inner",
                            staticStyle: { width: "100%" },
                            attrs: {
                              name: "accident_date",
                              "p-type": "date",
                              placeholder: "วันที่เกิดเหตุ",
                              format: _vm.vars.formatDate,
                              disabled:
                                _vm.checkStatusInterface(
                                  _vm.claim.headers.status
                                ) ||
                                _vm.checkStatusConfirmed(
                                  _vm.claim.headers.status
                                ) ||
                                _vm.checkStatusCancelled(
                                  _vm.claim.headers.status
                                )
                            },
                            on: { dateWasSelected: _vm.getValueAccidentDate },
                            model: {
                              value: _vm.claim.headers.accident_date,
                              callback: function($$v) {
                                _vm.$set(
                                  _vm.claim.headers,
                                  "accident_date",
                                  $$v
                                )
                              },
                              expression: "claim.headers.accident_date"
                            }
                          })
                        ],
                        1
                      )
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "row" }, [
                  _c(
                    "label",
                    { staticClass: "col-md-5 col-form-label lable_align" },
                    [_c("strong", [_vm._v("เวลาเกิดเหตุ *")])]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-xl-4 col-lg-5 col-md-6 el_field" },
                    [
                      _c(
                        "el-form-item",
                        { attrs: { prop: "headers.accident_time" } },
                        [
                          _c("el-time-picker", {
                            staticStyle: { width: "100%" },
                            attrs: {
                              placeholder: "เวลาเกิดเหตุ",
                              disabled:
                                _vm.checkStatusInterface(
                                  _vm.claim.headers.status
                                ) ||
                                _vm.checkStatusConfirmed(
                                  _vm.claim.headers.status
                                ) ||
                                _vm.checkStatusCancelled(
                                  _vm.claim.headers.status
                                ),
                              "value-format": "HH:mm"
                            },
                            model: {
                              value: _vm.claim.headers.accident_time,
                              callback: function($$v) {
                                _vm.$set(
                                  _vm.claim.headers,
                                  "accident_time",
                                  $$v
                                )
                              },
                              expression: "claim.headers.accident_time"
                            }
                          })
                        ],
                        1
                      )
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "row" }, [
                  _c(
                    "label",
                    { staticClass: "col-md-5 col-form-label lable_align" },
                    [_c("strong", [_vm._v("สถานที่ *")])]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-xl-4 col-lg-5 col-md-6 el_field" },
                    [
                      _c(
                        "el-form-item",
                        { attrs: { prop: "headers.location_name" } },
                        [
                          _c("el-input", {
                            attrs: {
                              placeholder: "สถานที่",
                              name: "location_name",
                              disabled:
                                _vm.checkStatusInterface(
                                  _vm.claim.headers.status
                                ) ||
                                _vm.checkStatusConfirmed(
                                  _vm.claim.headers.status
                                ) ||
                                _vm.checkStatusCancelled(
                                  _vm.claim.headers.status
                                )
                            },
                            model: {
                              value: _vm.claim.headers.location_name,
                              callback: function($$v) {
                                _vm.$set(
                                  _vm.claim.headers,
                                  "location_name",
                                  $$v
                                )
                              },
                              expression: "claim.headers.location_name"
                            }
                          })
                        ],
                        1
                      )
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "row" }, [
                  _c(
                    "label",
                    { staticClass: "col-md-5 col-form-label lable_align" },
                    [_c("strong", [_vm._v("หน่วยงาน *")])]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-xl-4 col-lg-5 col-md-6 el_field" },
                    [
                      _c(
                        "el-form-item",
                        { attrs: { prop: "headers.department_code" } },
                        [
                          _c("lov-department", {
                            attrs: {
                              placeholder: "หน่วยงาน",
                              attrName: "department_code",
                              disabled:
                                _vm.checkStatusInterface(
                                  _vm.claim.headers.status
                                ) ||
                                _vm.checkStatusConfirmed(
                                  _vm.claim.headers.status
                                ) ||
                                _vm.checkStatusCancelled(
                                  _vm.claim.headers.status
                                )
                            },
                            on: { "change-lov": _vm.getDataDepartment },
                            model: {
                              value: _vm.claim.headers.department_code,
                              callback: function($$v) {
                                _vm.$set(
                                  _vm.claim.headers,
                                  "department_code",
                                  $$v
                                )
                              },
                              expression: "claim.headers.department_code"
                            }
                          })
                        ],
                        1
                      )
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "row" }, [
                  _c(
                    "label",
                    { staticClass: "col-md-5 col-form-label lable_align" },
                    [_c("strong", [_vm._v("ผู้แจ้งเหตุ *")])]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-xl-4 col-lg-5 col-md-6 el_field" },
                    [
                      _c(
                        "el-form-item",
                        { attrs: { prop: "headers.requestor_name" } },
                        [
                          _c("el-input", {
                            attrs: {
                              placeholder: "ผู้แจ้งเหตุ",
                              disabled:
                                _vm.checkStatusInterface(
                                  _vm.claim.headers.status
                                ) ||
                                _vm.checkStatusConfirmed(
                                  _vm.claim.headers.status
                                ) ||
                                _vm.checkStatusCancelled(
                                  _vm.claim.headers.status
                                )
                            },
                            model: {
                              value: _vm.claim.headers.requestor_name,
                              callback: function($$v) {
                                _vm.$set(
                                  _vm.claim.headers,
                                  "requestor_name",
                                  $$v
                                )
                              },
                              expression: "claim.headers.requestor_name"
                            }
                          })
                        ],
                        1
                      )
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "row" }, [
                  _c(
                    "label",
                    { staticClass: "col-md-5 col-form-label lable_align" },
                    [_c("strong", [_vm._v("เบอร์โทรผู้แจ้งเหตุ *")])]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-xl-4 col-lg-5 col-md-6 el_field" },
                    [
                      _c(
                        "el-form-item",
                        { attrs: { prop: "headers.requestor_tel" } },
                        [
                          _c("el-input", {
                            attrs: {
                              placeholder: "เบอร์โทรผู้แจ้งเหตุ",
                              disabled:
                                _vm.checkStatusInterface(
                                  _vm.claim.headers.status
                                ) ||
                                _vm.checkStatusConfirmed(
                                  _vm.claim.headers.status
                                ) ||
                                _vm.checkStatusCancelled(
                                  _vm.claim.headers.status
                                )
                            },
                            model: {
                              value: _vm.claim.headers.requestor_tel,
                              callback: function($$v) {
                                _vm.$set(
                                  _vm.claim.headers,
                                  "requestor_tel",
                                  $$v
                                )
                              },
                              expression: "claim.headers.requestor_tel"
                            }
                          })
                        ],
                        1
                      )
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "row" }, [
                  _c(
                    "label",
                    { staticClass: "col-md-5 col-form-label lable_align" },
                    [_c("strong", [_vm._v("จำนวนเงินเรียกชดใช้รวม")])]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-xl-4 col-lg-5 col-md-6 el_field" },
                    [
                      _c(
                        "el-form-item",
                        [
                          _c("currency-input-group-append", {
                            attrs: {
                              placeholder: "จำนวนเงินเรียกชดใช้รวม",
                              name: "claim_amount",
                              disabled: true,
                              sizeSmall: false,
                              showAppend: true,
                              wordingAppend: "THB",
                              inputClass: "text-right"
                            },
                            model: {
                              value: _vm.claim.headers.claim_amount,
                              callback: function($$v) {
                                _vm.$set(_vm.claim.headers, "claim_amount", $$v)
                              },
                              expression: "claim.headers.claim_amount"
                            }
                          })
                        ],
                        1
                      )
                    ],
                    1
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "row" }, [
                  _c(
                    "label",
                    { staticClass: "col-md-5 col-form-label lable_align" },
                    [_c("strong", [_vm._v("Attachments (ไฟล์แนบ)")])]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-xl-4 col-lg-5 col-md-6 el_field" },
                    [
                      _c(
                        "el-form-item",
                        { staticClass: "display_none_el_icon_close_tip" },
                        [
                          _c(
                            "el-upload",
                            {
                              ref: "upload_claim",
                              staticClass: "upload-demo",
                              attrs: {
                                name: "file[]",
                                action: "",
                                "on-change": _vm.onchange,
                                "file-list": _vm.fileList,
                                multiple: "",
                                "on-remove": _vm.onRemove,
                                data: _vm.claim,
                                "auto-upload": false,
                                "before-remove": _vm.beforeRemove,
                                disabled:
                                  _vm.checkStatusInterface(
                                    _vm.claim.headers.status
                                  ) ||
                                  _vm.checkStatusConfirmed(
                                    _vm.claim.headers.status
                                  ) ||
                                  _vm.checkStatusCancelled(
                                    _vm.claim.headers.status
                                  )
                              }
                            },
                            [
                              _c(
                                "el-button",
                                {
                                  attrs: {
                                    size: "small",
                                    type: "primary",
                                    disabled:
                                      _vm.checkStatusInterface(
                                        _vm.claim.headers.status
                                      ) ||
                                      _vm.checkStatusConfirmed(
                                        _vm.claim.headers.status
                                      ) ||
                                      _vm.checkStatusCancelled(
                                        _vm.claim.headers.status
                                      )
                                  }
                                },
                                [
                                  _vm._v(
                                    "\n                  Click to upload\n                "
                                  )
                                ]
                              )
                            ],
                            1
                          )
                        ],
                        1
                      )
                    ],
                    1
                  )
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "row margin_top_20 text-right" }, [
                _c("div", { staticClass: "col-md-12" }, [
                  _c(
                    "button",
                    {
                      staticClass: "btn btn-success",
                      attrs: {
                        type: "button",
                        disabled:
                          _vm.checkStatusInterface(_vm.claim.headers.status) ||
                          _vm.checkStatusConfirmed(_vm.claim.headers.status) ||
                          _vm.checkStatusCancelled(_vm.claim.headers.status)
                      },
                      on: {
                        click: function($event) {
                          return _vm.clickCreateClaimGroup()
                        }
                      }
                    },
                    [
                      _c("i", { staticClass: "fa fa-plus" }),
                      _vm._v(" เพิ่ม\n          ")
                    ]
                  )
                ])
              ]),
              _vm._v(" "),
              _c(
                "el-form",
                {
                  ref: "claim_apply_companies",
                  staticClass: "demo-ruleForm",
                  staticStyle: { "padding-top": "30px" },
                  attrs: { model: _vm.claim, "label-width": "120px" }
                },
                [
                  _vm._l(_vm.claim.group, function(data, index) {
                    return _c(
                      "div",
                      {
                        directives: [
                          {
                            name: "show",
                            rawName: "v-show",
                            value: _vm.claim.group.length > 0,
                            expression: "claim.group.length > 0"
                          }
                        ],
                        key: index,
                        staticClass: "el_field_table",
                        staticStyle: { "margin-bottom": "20px" }
                      },
                      [
                        _c(
                          "div",
                          {
                            staticStyle: {
                              display: "block",
                              width: "100%",
                              "overflow-x": "auto",
                              height: "135px"
                            }
                          },
                          [
                            _c("policy-header-form"),
                            _vm._v(" "),
                            _c(
                              "div",
                              {
                                staticClass: "el_field_table",
                                staticStyle: { display: "flex" }
                              },
                              [
                                _c(
                                  "el-form-item",
                                  {
                                    staticClass: "media_claim_col",
                                    staticStyle: {
                                      "margin-bottom": "0px",
                                      width: "25%",
                                      padding: "12px"
                                    },
                                    attrs: {
                                      prop:
                                        "group." + index + ".group_description",
                                      rules: _vm.rules.group
                                    }
                                  },
                                  [
                                    _c("lov-policy-group", {
                                      attrs: {
                                        name: "group_description" + index,
                                        size: "",
                                        placeholder: "กลุ่มกรมธรรม์",
                                        popperBody: true,
                                        disabled:
                                          _vm.checkStatusInterface(
                                            _vm.claim.headers.status
                                          ) ||
                                          _vm.checkStatusConfirmed(
                                            _vm.claim.headers.status
                                          ) ||
                                          _vm.checkStatusCancelled(
                                            _vm.claim.headers.status
                                          )
                                      },
                                      on: {
                                        "change-lov": function($event) {
                                          var i = arguments.length,
                                            argsArray = Array(i)
                                          while (i--)
                                            argsArray[i] = arguments[i]
                                          return _vm.getPolicyCode.apply(
                                            void 0,
                                            argsArray.concat([index])
                                          )
                                        }
                                      },
                                      model: {
                                        value: data.group_header_id,
                                        callback: function($$v) {
                                          _vm.$set(data, "group_header_id", $$v)
                                        },
                                        expression: "data.group_header_id"
                                      }
                                    })
                                  ],
                                  1
                                ),
                                _vm._v(" "),
                                _c(
                                  "el-form-item",
                                  {
                                    staticClass: "media_claim_col",
                                    staticStyle: {
                                      "margin-bottom": "0px",
                                      width: "25%",
                                      padding: "12px"
                                    },
                                    attrs: {
                                      prop:
                                        "group." + index + ".group_description",
                                      rules: _vm.rules.group.group_description
                                    }
                                  },
                                  [
                                    _c("lov-policy-set-header-id", {
                                      attrs: {
                                        name: "group_description" + index,
                                        size: "",
                                        placeholder: "ชุดกรมธรรม์",
                                        popperBody: true,
                                        disabled:
                                          _vm.checkStatusInterface(
                                            _vm.claim.headers.status
                                          ) ||
                                          _vm.checkStatusConfirmed(
                                            _vm.claim.headers.status
                                          ) ||
                                          _vm.checkStatusCancelled(
                                            _vm.claim.headers.status
                                          ),
                                        group_header_id: data.group_header_id
                                      },
                                      on: {
                                        "change-lov": function($event) {
                                          var i = arguments.length,
                                            argsArray = Array(i)
                                          while (i--)
                                            argsArray[i] = arguments[i]
                                          return _vm.getPolicySetHeaderId.apply(
                                            void 0,
                                            argsArray.concat([index])
                                          )
                                        }
                                      },
                                      model: {
                                        value: data.policy_set_header_id,
                                        callback: function($$v) {
                                          _vm.$set(
                                            data,
                                            "policy_set_header_id",
                                            $$v
                                          )
                                        },
                                        expression: "data.policy_set_header_id"
                                      }
                                    })
                                  ],
                                  1
                                ),
                                _vm._v(" "),
                                _c(
                                  "el-form-item",
                                  {
                                    staticClass: "media_claim_col",
                                    staticStyle: {
                                      "margin-bottom": "0px",
                                      width: "25%",
                                      padding: "12px"
                                    },
                                    attrs: {
                                      prop: "group." + index + ".amount",
                                      rules: _vm.rules.group.amount
                                    }
                                  },
                                  [
                                    _c("currency-input", {
                                      attrs: {
                                        name: "amount" + index,
                                        sizeSmall: false,
                                        placeholder: "จำนวนเงินเรียกชดใช้",
                                        disabled:
                                          _vm.checkStatusInterface(
                                            _vm.claim.headers.status
                                          ) ||
                                          _vm.checkStatusConfirmed(
                                            _vm.claim.headers.status
                                          ) ||
                                          _vm.checkStatusCancelled(
                                            _vm.claim.headers.status
                                          )
                                      },
                                      on: {
                                        input: function($event) {
                                          var i = arguments.length,
                                            argsArray = Array(i)
                                          while (i--)
                                            argsArray[i] = arguments[i]
                                          return _vm.getDataAmount.apply(
                                            void 0,
                                            argsArray.concat([index])
                                          )
                                        }
                                      },
                                      model: {
                                        value: data.amount,
                                        callback: function($$v) {
                                          _vm.$set(data, "amount", $$v)
                                        },
                                        expression: "data.amount"
                                      }
                                    })
                                  ],
                                  1
                                ),
                                _vm._v(" "),
                                data.flag === "add" || data.flag === "edit"
                                  ? _c(
                                      "el-form-item",
                                      {
                                        staticClass: "media_claim_col",
                                        staticStyle: {
                                          "margin-bottom": "0px",
                                          width: "25%",
                                          padding: "12px",
                                          "text-align": "center"
                                        }
                                      },
                                      [
                                        _c(
                                          "button",
                                          {
                                            staticClass: "btn btn-danger",
                                            attrs: {
                                              type: "button",
                                              disabled:
                                                _vm.checkStatusInterface(
                                                  _vm.claim.headers.status
                                                ) ||
                                                _vm.checkStatusInterface(
                                                  _vm.claim.headers.status
                                                ) ||
                                                _vm.checkStatusConfirmed(
                                                  _vm.claim.headers.status
                                                ) ||
                                                _vm.checkStatusCancelled(
                                                  _vm.claim.headers.status
                                                )
                                            },
                                            on: {
                                              click: function($event) {
                                                return _vm.clickRemoveGroup(
                                                  data,
                                                  index
                                                )
                                              }
                                            }
                                          },
                                          [
                                            _c("i", {
                                              staticClass: "fa fa-times"
                                            }),
                                            _vm._v(" ลบ\n                    ")
                                          ]
                                        )
                                      ]
                                    )
                                  : _vm._e()
                              ],
                              1
                            )
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _vm.claim.group.length > 0
                          ? _c(
                              "div",
                              { staticClass: "row margin_top_20 text-right" },
                              [
                                _c(
                                  "div",
                                  { staticClass: "col-md-12" },
                                  [
                                    _c(
                                      "el-form-item",
                                      {
                                        staticStyle: { float: "right" },
                                        attrs: {
                                          prop: "group." + index + ".company",
                                          rules: _vm.rules.companies
                                        }
                                      },
                                      [
                                        _c(
                                          "button",
                                          {
                                            staticClass: "btn btn-success",
                                            attrs: {
                                              type: "button",
                                              disabled:
                                                _vm.checkStatusInterface(
                                                  _vm.claim.headers.status
                                                ) ||
                                                _vm.checkStatusConfirmed(
                                                  _vm.claim.headers.status
                                                ) ||
                                                _vm.checkStatusCancelled(
                                                  _vm.claim.headers.status
                                                )
                                            },
                                            on: {
                                              click: function($event) {
                                                return _vm.clickCreateApplyCompanies(
                                                  index,
                                                  data
                                                )
                                              }
                                            }
                                          },
                                          [
                                            _c("i", {
                                              staticClass: "fa fa-plus"
                                            }),
                                            _vm._v(
                                              " เพิ่มรายการเคลม\n                "
                                            )
                                          ]
                                        )
                                      ]
                                    )
                                  ],
                                  1
                                )
                              ]
                            )
                          : _vm._e(),
                        _vm._v(" "),
                        _c(
                          "el-form",
                          {
                            ref: "companies",
                            refInFor: true,
                            staticClass: "demo-ruleForm",
                            attrs: { model: data, "label-width": "120px" }
                          },
                          _vm._l(data.company, function(comp, index_comp) {
                            return _c(
                              "div",
                              { key: index_comp },
                              [
                                _c(
                                  "div",
                                  {
                                    staticStyle: {
                                      display: "block",
                                      width: "100%",
                                      "overflow-x": "auto",
                                      height: "135px"
                                    }
                                  },
                                  [
                                    _c("header-form"),
                                    _vm._v(" "),
                                    _c(
                                      "div",
                                      {
                                        staticClass: "el_field_table",
                                        staticStyle: { display: "flex" }
                                      },
                                      [
                                        _c(
                                          "el-form-item",
                                          {
                                            staticClass: "media_claim_col",
                                            staticStyle: {
                                              "margin-bottom": "0px",
                                              width: "25%",
                                              padding: "12px"
                                            },
                                            attrs: {
                                              prop:
                                                "company." +
                                                index_comp +
                                                ".company_id",
                                              rules:
                                                _vm.rules.group.company
                                                  .company_id
                                            }
                                          },
                                          [
                                            data.showLovCompany
                                              ? _c("lov-company", {
                                                  attrs: {
                                                    placeholder:
                                                      "บริษัทประกันภัย",
                                                    attrName:
                                                      "company_id" + index_comp,
                                                    index: index_comp,
                                                    disabled:
                                                      _vm.checkStatusInterface(
                                                        _vm.claim.headers.status
                                                      ) ||
                                                      _vm.checkStatusConfirmed(
                                                        _vm.claim.headers.status
                                                      ) ||
                                                      _vm.checkStatusCancelled(
                                                        _vm.claim.headers.status
                                                      ),
                                                    resData: _vm.resData
                                                  },
                                                  on: {
                                                    "change-lov": function(
                                                      $event
                                                    ) {
                                                      var i = arguments.length,
                                                        argsArray = Array(i)
                                                      while (i--)
                                                        argsArray[i] =
                                                          arguments[i]
                                                      return _vm.getDataCompany.apply(
                                                        void 0,
                                                        argsArray.concat(
                                                          [index_comp],
                                                          [index]
                                                        )
                                                      )
                                                    }
                                                  },
                                                  model: {
                                                    value: comp.company_id,
                                                    callback: function($$v) {
                                                      _vm.$set(
                                                        comp,
                                                        "company_id",
                                                        $$v
                                                      )
                                                    },
                                                    expression:
                                                      "comp.company_id"
                                                  }
                                                })
                                              : _vm._e(),
                                            _vm._v(" "),
                                            !data.showLovCompany
                                              ? _c("lov-company-policy-group", {
                                                  attrs: {
                                                    placeholder:
                                                      "บริษัทประกันภัย",
                                                    attrName:
                                                      "company_id_policy_group" +
                                                      index_comp,
                                                    index: index_comp,
                                                    disabled:
                                                      _vm.checkStatusInterface(
                                                        _vm.claim.headers.status
                                                      ) ||
                                                      !data.showLovCompany ||
                                                      _vm.checkStatusConfirmed(
                                                        _vm.claim.headers.status
                                                      ) ||
                                                      _vm.checkStatusCancelled(
                                                        _vm.claim.headers.status
                                                      ),
                                                    group_header_id:
                                                      data.group_header_id,
                                                    year: _vm.claim.headers.year
                                                  },
                                                  on: {
                                                    "change-lov": function(
                                                      $event
                                                    ) {
                                                      var i = arguments.length,
                                                        argsArray = Array(i)
                                                      while (i--)
                                                        argsArray[i] =
                                                          arguments[i]
                                                      return _vm.getDataCompanyPolicyGroup.apply(
                                                        void 0,
                                                        argsArray.concat(
                                                          [index_comp],
                                                          [index]
                                                        )
                                                      )
                                                    },
                                                    "response-company-percent": function(
                                                      $event
                                                    ) {
                                                      var i = arguments.length,
                                                        argsArray = Array(i)
                                                      while (i--)
                                                        argsArray[i] =
                                                          arguments[i]
                                                      return _vm.getValueCompaniesPercent.apply(
                                                        void 0,
                                                        argsArray.concat(
                                                          [index],
                                                          [index_comp]
                                                        )
                                                      )
                                                    }
                                                  },
                                                  model: {
                                                    value: comp.company_name,
                                                    callback: function($$v) {
                                                      _vm.$set(
                                                        comp,
                                                        "company_name",
                                                        $$v
                                                      )
                                                    },
                                                    expression:
                                                      "comp.company_name"
                                                  }
                                                })
                                              : _vm._e()
                                          ],
                                          1
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "el-form-item",
                                          {
                                            staticClass: "media_claim_col",
                                            staticStyle: {
                                              "margin-bottom": "0px",
                                              width: "25%",
                                              padding: "12px"
                                            },
                                            attrs: {
                                              prop:
                                                "company." +
                                                index_comp +
                                                ".claim_percent",
                                              rules:
                                                _vm.rules.group.company
                                                  .claim_percent
                                            }
                                          },
                                          [
                                            _c("el-input", {
                                              staticClass: "currency_right",
                                              attrs: {
                                                placeholder: "สัดส่วน (%)",
                                                name:
                                                  "claim_percent" + index_comp,
                                                disabled:
                                                  _vm.checkStatusInterface(
                                                    _vm.claim.headers.status
                                                  ) ||
                                                  _vm.checkStatusConfirmed(
                                                    _vm.claim.headers.status
                                                  ) ||
                                                  _vm.checkStatusCancelled(
                                                    _vm.claim.headers.status
                                                  ),
                                                type: "age",
                                                autocomplete: "off"
                                              },
                                              on: {
                                                change: function($event) {
                                                  var i = arguments.length,
                                                    argsArray = Array(i)
                                                  while (i--)
                                                    argsArray[i] = arguments[i]
                                                  return _vm.changePercent.apply(
                                                    void 0,
                                                    argsArray.concat(
                                                      [index_comp],
                                                      [index]
                                                    )
                                                  )
                                                }
                                              },
                                              model: {
                                                value: comp.claim_percent,
                                                callback: function($$v) {
                                                  _vm.$set(
                                                    comp,
                                                    "claim_percent",
                                                    _vm._n($$v)
                                                  )
                                                },
                                                expression: "comp.claim_percent"
                                              }
                                            })
                                          ],
                                          1
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "el-form-item",
                                          {
                                            staticClass:
                                              "currency_right media_claim_col",
                                            staticStyle: {
                                              "margin-bottom": "0px",
                                              width: "25%",
                                              padding: "12px"
                                            },
                                            attrs: {
                                              prop:
                                                "company." +
                                                index_comp +
                                                ".claim_amount",
                                              rules:
                                                _vm.rules.group.company
                                                  .claim_amount
                                            }
                                          },
                                          [
                                            _c("currency-input", {
                                              attrs: {
                                                name:
                                                  "claim_amount" + index_comp,
                                                sizeSmall: false,
                                                placeholder: "จำนวนเงิน",
                                                disabled: true
                                              },
                                              on: {
                                                "watch-value": function(
                                                  $event
                                                ) {
                                                  var i = arguments.length,
                                                    argsArray = Array(i)
                                                  while (i--)
                                                    argsArray[i] = arguments[i]
                                                  return _vm.watchClaimAmountCompany.apply(
                                                    void 0,
                                                    argsArray.concat(
                                                      [index_comp],
                                                      [index]
                                                    )
                                                  )
                                                }
                                              },
                                              model: {
                                                value: comp.claim_amount,
                                                callback: function($$v) {
                                                  _vm.$set(
                                                    comp,
                                                    "claim_amount",
                                                    $$v
                                                  )
                                                },
                                                expression: "comp.claim_amount"
                                              }
                                            })
                                          ],
                                          1
                                        ),
                                        _vm._v(" "),
                                        data.flag === "add" ||
                                        data.flag === "edit"
                                          ? _c(
                                              "el-form-item",
                                              {
                                                staticClass: "media_claim_col",
                                                staticStyle: {
                                                  "margin-bottom": "0px",
                                                  width: "25%",
                                                  padding: "12px",
                                                  "text-align": "center"
                                                }
                                              },
                                              [
                                                _c(
                                                  "button",
                                                  {
                                                    staticClass:
                                                      "btn btn-danger",
                                                    attrs: {
                                                      type: "button",
                                                      disabled:
                                                        _vm.checkStatusInterface(
                                                          _vm.claim.headers
                                                            .status
                                                        ) ||
                                                        _vm.checkStatusConfirmed(
                                                          _vm.claim.headers
                                                            .status
                                                        ) ||
                                                        _vm.checkStatusCancelled(
                                                          _vm.claim.headers
                                                            .status
                                                        )
                                                    },
                                                    on: {
                                                      click: function($event) {
                                                        return _vm.clickRemove(
                                                          comp,
                                                          index_comp,
                                                          index
                                                        )
                                                      }
                                                    }
                                                  },
                                                  [
                                                    _c("i", {
                                                      staticClass: "fa fa-times"
                                                    }),
                                                    _vm._v(
                                                      " ลบ\n                    "
                                                    )
                                                  ]
                                                )
                                              ]
                                            )
                                          : _vm._e()
                                      ],
                                      1
                                    )
                                  ],
                                  1
                                ),
                                _vm._v(" "),
                                _c(
                                  "div",
                                  {
                                    staticClass: "row margin_top_20 text-right"
                                  },
                                  [
                                    _c("div", { staticClass: "col-md-12" }, [
                                      _c(
                                        "button",
                                        {
                                          staticClass: "btn btn-success",
                                          attrs: {
                                            type: "button",
                                            disabled:
                                              _vm.checkStatusInterface(
                                                _vm.claim.headers.status
                                              ) ||
                                              _vm.checkStatusConfirmed(
                                                _vm.claim.headers.status
                                              ) ||
                                              _vm.checkStatusCancelled(
                                                _vm.claim.headers.status
                                              )
                                          },
                                          on: {
                                            click: function($event) {
                                              return _vm.clickAddDetails(
                                                comp,
                                                index_comp
                                              )
                                            }
                                          }
                                        },
                                        [
                                          _c("i", {
                                            staticClass: "fa fa-plus"
                                          }),
                                          _vm._v(
                                            " เพิ่มรายการ\n                  "
                                          )
                                        ]
                                      )
                                    ])
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "el-form-item",
                                  [
                                    _c(
                                      "el-form",
                                      {
                                        ref: "claim_apply_details",
                                        refInFor: true,
                                        staticClass: "demo-dynamic",
                                        attrs: {
                                          model: comp,
                                          "label-width": "120px"
                                        },
                                        model: {
                                          value: comp.detail,
                                          callback: function($$v) {
                                            _vm.$set(comp, "detail", $$v)
                                          },
                                          expression: "comp.detail"
                                        }
                                      },
                                      [
                                        _c(
                                          "div",
                                          {
                                            staticClass:
                                              "table-responsive margin_top_20"
                                          },
                                          [
                                            _c(
                                              "table",
                                              {
                                                staticClass:
                                                  "table table-bordered",
                                                staticStyle: {
                                                  display: "block",
                                                  overflow: "auto",
                                                  "max-height": "240px"
                                                }
                                              },
                                              [
                                                _c("thead", [
                                                  _c(
                                                    "tr",
                                                    {
                                                      staticClass: "text-center"
                                                    },
                                                    [
                                                      _c(
                                                        "th",
                                                        {
                                                          staticStyle: {
                                                            "min-width": "80px",
                                                            width: "1%"
                                                          }
                                                        },
                                                        [_vm._v("ลำดับ")]
                                                      ),
                                                      _vm._v(" "),
                                                      _c(
                                                        "th",
                                                        {
                                                          staticStyle: {
                                                            "min-width":
                                                              "250px",
                                                            width: "65%",
                                                            "z-index": "1"
                                                          }
                                                        },
                                                        [_vm._v("รายละเอียด *")]
                                                      ),
                                                      _vm._v(" "),
                                                      _c(
                                                        "th",
                                                        {
                                                          staticStyle: {
                                                            "min-width":
                                                              "150px",
                                                            width: "25%",
                                                            "z-index": "1"
                                                          }
                                                        },
                                                        [_vm._v("จำนวนเงิน *")]
                                                      ),
                                                      _vm._v(" "),
                                                      _c(
                                                        "th",
                                                        {
                                                          staticStyle: {
                                                            "min-width":
                                                              "130px",
                                                            width: "10%",
                                                            "z-index": "1"
                                                          }
                                                        },
                                                        [_vm._v("ลบ")]
                                                      )
                                                    ]
                                                  )
                                                ]),
                                                _vm._v(" "),
                                                _c(
                                                  "tbody",
                                                  {
                                                    attrs: {
                                                      id: "table_details"
                                                    }
                                                  },
                                                  [
                                                    _vm._l(
                                                      comp.detail,
                                                      function(
                                                        detail,
                                                        index_detail
                                                      ) {
                                                        return _c(
                                                          "tr",
                                                          {
                                                            directives: [
                                                              {
                                                                name: "show",
                                                                rawName:
                                                                  "v-show",
                                                                value:
                                                                  comp.detail
                                                                    .length > 0,
                                                                expression:
                                                                  "comp.detail.length > 0"
                                                              }
                                                            ],
                                                            key: index_detail
                                                          },
                                                          [
                                                            _c(
                                                              "td",
                                                              {
                                                                staticStyle: {
                                                                  "text-align":
                                                                    "center",
                                                                  "vertical-align":
                                                                    "middle"
                                                                }
                                                              },
                                                              [
                                                                _vm._v(
                                                                  "\n                            " +
                                                                    _vm._s(
                                                                      _vm.isNullOrUndefined(
                                                                        detail.line_number
                                                                      )
                                                                    ) +
                                                                    "\n                          "
                                                                )
                                                              ]
                                                            ),
                                                            _vm._v(" "),
                                                            _c(
                                                              "td",
                                                              {
                                                                staticClass:
                                                                  "el_field_table",
                                                                style:
                                                                  "" +
                                                                  (detail.flag ===
                                                                  "edit"
                                                                    ? "vertical-align: middle;"
                                                                    : "")
                                                              },
                                                              [
                                                                detail.flag !==
                                                                "add"
                                                                  ? _c("span", [
                                                                      _vm._v(
                                                                        "\n                              " +
                                                                          _vm._s(
                                                                            _vm.isNullOrUndefined(
                                                                              detail.line_description
                                                                            )
                                                                          ) +
                                                                          "\n                            "
                                                                      )
                                                                    ])
                                                                  : _c(
                                                                      "el-form-item",
                                                                      [
                                                                        _c(
                                                                          "el-input",
                                                                          {
                                                                            attrs: {
                                                                              placeholder:
                                                                                "รายละเอียด",
                                                                              size:
                                                                                "small",
                                                                              disabled:
                                                                                _vm.checkStatusInterface(
                                                                                  _vm
                                                                                    .claim
                                                                                    .headers
                                                                                    .status
                                                                                ) ||
                                                                                _vm.checkStatusConfirmed(
                                                                                  _vm
                                                                                    .claim
                                                                                    .headers
                                                                                    .status
                                                                                ) ||
                                                                                _vm.checkStatusCancelled(
                                                                                  _vm
                                                                                    .claim
                                                                                    .headers
                                                                                    .status
                                                                                )
                                                                            },
                                                                            model: {
                                                                              value:
                                                                                detail.line_description,
                                                                              callback: function(
                                                                                $$v
                                                                              ) {
                                                                                _vm.$set(
                                                                                  detail,
                                                                                  "line_description",
                                                                                  $$v
                                                                                )
                                                                              },
                                                                              expression:
                                                                                "detail.line_description"
                                                                            }
                                                                          }
                                                                        )
                                                                      ],
                                                                      1
                                                                    )
                                                              ],
                                                              1
                                                            ),
                                                            _vm._v(" "),
                                                            _c(
                                                              "td",
                                                              {
                                                                staticClass:
                                                                  "el_field_table"
                                                              },
                                                              [
                                                                _c(
                                                                  "el-form-item",
                                                                  {
                                                                    staticStyle: {
                                                                      "margin-bottom":
                                                                        "10px"
                                                                    }
                                                                  },
                                                                  [
                                                                    _c(
                                                                      "currency-input",
                                                                      {
                                                                        attrs: {
                                                                          name:
                                                                            "line_amount" +
                                                                            index_detail,
                                                                          sizeSmall: true,
                                                                          placeholder:
                                                                            "จำนวนเงิน",
                                                                          disabled:
                                                                            _vm.checkStatusInterface(
                                                                              _vm
                                                                                .claim
                                                                                .headers
                                                                                .status
                                                                            ) ||
                                                                            _vm.checkStatusConfirmed(
                                                                              _vm
                                                                                .claim
                                                                                .headers
                                                                                .status
                                                                            ) ||
                                                                            _vm.checkStatusCancelled(
                                                                              _vm
                                                                                .claim
                                                                                .headers
                                                                                .status
                                                                            )
                                                                        },
                                                                        model: {
                                                                          value:
                                                                            detail.line_amount,
                                                                          callback: function(
                                                                            $$v
                                                                          ) {
                                                                            _vm.$set(
                                                                              detail,
                                                                              "line_amount",
                                                                              $$v
                                                                            )
                                                                          },
                                                                          expression:
                                                                            "detail.line_amount"
                                                                        }
                                                                      }
                                                                    )
                                                                  ],
                                                                  1
                                                                )
                                                              ],
                                                              1
                                                            ),
                                                            _vm._v(" "),
                                                            _c(
                                                              "td",
                                                              [
                                                                detail.flag ===
                                                                  "add" ||
                                                                data.flag ===
                                                                  "edit"
                                                                  ? _c(
                                                                      "el-form-item",
                                                                      {
                                                                        staticClass:
                                                                          "text-center"
                                                                      },
                                                                      [
                                                                        _c(
                                                                          "button",
                                                                          {
                                                                            staticClass:
                                                                              "btn btn-danger btn-sm",
                                                                            attrs: {
                                                                              type:
                                                                                "button",
                                                                              disabled:
                                                                                _vm.checkStatusInterface(
                                                                                  _vm
                                                                                    .claim
                                                                                    .headers
                                                                                    .status
                                                                                ) ||
                                                                                _vm.checkStatusConfirmed(
                                                                                  _vm
                                                                                    .claim
                                                                                    .headers
                                                                                    .status
                                                                                ) ||
                                                                                _vm.checkStatusCancelled(
                                                                                  _vm
                                                                                    .claim
                                                                                    .headers
                                                                                    .status
                                                                                )
                                                                            },
                                                                            on: {
                                                                              click: function(
                                                                                $event
                                                                              ) {
                                                                                return _vm.clickRemoveDetails(
                                                                                  comp,
                                                                                  detail,
                                                                                  index_detail
                                                                                )
                                                                              }
                                                                            }
                                                                          },
                                                                          [
                                                                            _c(
                                                                              "i",
                                                                              {
                                                                                staticClass:
                                                                                  "fa fa-times"
                                                                              }
                                                                            ),
                                                                            _vm._v(
                                                                              " ลบ\n                              "
                                                                            )
                                                                          ]
                                                                        )
                                                                      ]
                                                                    )
                                                                  : _vm._e()
                                                              ],
                                                              1
                                                            )
                                                          ]
                                                        )
                                                      }
                                                    ),
                                                    _vm._v(" "),
                                                    comp.detail.length === 0
                                                      ? _c(
                                                          "tr",
                                                          {
                                                            staticClass:
                                                              "text-center"
                                                          },
                                                          [
                                                            _c(
                                                              "td",
                                                              {
                                                                attrs: {
                                                                  colspan: "4"
                                                                }
                                                              },
                                                              [
                                                                _vm._v(
                                                                  "ไม่มีข้อมูล"
                                                                )
                                                              ]
                                                            )
                                                          ]
                                                        )
                                                      : _vm._e()
                                                  ],
                                                  2
                                                ),
                                                _vm._v(" "),
                                                _c("tfoot")
                                              ]
                                            )
                                          ]
                                        )
                                      ]
                                    )
                                  ],
                                  1
                                ),
                                _vm._v(" "),
                                _c("div", { staticClass: "row text-right" }, [
                                  _c(
                                    "div",
                                    { staticClass: "col-md-12" },
                                    [
                                      _c(
                                        "el-form-item",
                                        {
                                          staticStyle: {
                                            float: "right",
                                            width: "145px"
                                          }
                                        },
                                        [
                                          _c(
                                            "button",
                                            {
                                              staticClass: "btn btn-default",
                                              attrs: {
                                                type: "button",
                                                "data-toggle": "modal",
                                                "data-target":
                                                  "#modal_details" + index_comp,
                                                value: comp.req_modal,
                                                name:
                                                  "modal_details" + index_comp
                                              },
                                              on: {
                                                click: function($event) {
                                                  return _vm.clickModalDetails(
                                                    comp,
                                                    index_comp,
                                                    0
                                                  )
                                                }
                                              }
                                            },
                                            [
                                              _c("i", {
                                                staticClass: "fa fa-file-text-o"
                                              }),
                                              _vm._v(
                                                " รายละเอียด\n                    "
                                              )
                                            ]
                                          )
                                        ]
                                      )
                                    ],
                                    1
                                  )
                                ])
                              ],
                              1
                            )
                          }),
                          0
                        )
                      ],
                      1
                    )
                  }),
                  _vm._v(" "),
                  _vm.claim.group.length === 0
                    ? _c(
                        "div",
                        {
                          staticStyle: {
                            "text-align": "center",
                            display: "block",
                            width: "100%",
                            "overflow-x": "auto",
                            height: "135px"
                          }
                        },
                        [
                          _c("policy-header-form"),
                          _vm._v(" "),
                          _c(
                            "div",
                            {
                              staticClass: "media_claim_no_data_align_end",
                              staticStyle: { padding: "20px" }
                            },
                            [_vm._v("\n            ไม่มีข้อมูล\n          ")]
                          )
                        ],
                        1
                      )
                    : _vm._e()
                ],
                2
              ),
              _vm._v(" "),
              _c("div", { staticClass: "row margin_top_20" }, [
                _c(
                  "div",
                  { staticClass: "col-md-12 lable_align el_field" },
                  [
                    _c("el-form-item", [
                      _c(
                        "button",
                        {
                          staticClass: "btn btn-primary",
                          attrs: { type: "button" },
                          on: {
                            click: function($event) {
                              return _vm.clickSave()
                            }
                          }
                        },
                        [
                          _c("i", { staticClass: "fa fa-save" }),
                          _vm._v(" บันทึก\n            ")
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "button",
                        {
                          staticClass: "btn btn-danger",
                          attrs: { type: "button" },
                          on: {
                            click: function($event) {
                              return _vm.clickCancel()
                            }
                          }
                        },
                        [
                          _c("i", { staticClass: "fa fa-times" }),
                          _vm._v(" ยกเลิก\n            ")
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "button",
                        {
                          staticClass: "btn btn-primary",
                          attrs: {
                            type: "button",
                            disabled:
                              _vm.checkStatusInterface(
                                _vm.claim.headers.status
                              ) ||
                              _vm.checkStatusConfirmed(
                                _vm.claim.headers.status
                              ) ||
                              _vm.checkStatusCancelled(_vm.claim.headers.status)
                          },
                          on: {
                            click: function($event) {
                              return _vm.clickConfirm()
                            }
                          }
                        },
                        [
                          _c("i", { staticClass: "fa fa-check" }),
                          _vm._v(" ยืนยัน\n            ")
                        ]
                      )
                    ])
                  ],
                  1
                )
              ])
            ],
            1
          )
        ]
      ),
      _vm._v(" "),
      _c("modal-details", {
        attrs: {
          details: _vm.details,
          index: _vm.index_comp,
          status: _vm.claim.headers.status,
          checkStatusInterface: _vm.checkStatusInterface,
          checkStatusConfirmed: _vm.checkStatusConfirmed,
          checkStatusCancelled: _vm.checkStatusCancelled,
          vars: _vm.vars
        },
        on: { "modal-details": _vm.getDataModalDetails }
      })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/headerForm.vue?vue&type=template&id=4ab81022&":
/*!*****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/headerForm.vue?vue&type=template&id=4ab81022& ***!
  \*****************************************************************************************************************************************************************************************************************************************/
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
  return _vm._m(0)
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticStyle: { display: "flex", width: "100%" } }, [
      _c(
        "div",
        {
          staticClass: "media_claim_col",
          staticStyle: {
            padding: "12px",
            width: "25%",
            "text-align": "center",
            color: "#212529",
            "font-weight": "bold",
            "border-bottom": "1px solid"
          }
        },
        [_vm._v("\n    บริษัทประกันภัย *\n  ")]
      ),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass: "media_claim_col",
          staticStyle: {
            padding: "12px",
            width: "25%",
            "text-align": "center",
            color: "#212529",
            "font-weight": "bold",
            "border-bottom": "1px solid"
          }
        },
        [_vm._v("\n    สัดส่วน (%) *\n  ")]
      ),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass: "media_claim_col",
          staticStyle: {
            padding: "12px",
            width: "25%",
            "text-align": "center",
            color: "#212529",
            "font-weight": "bold",
            "border-bottom": "1px solid"
          }
        },
        [_vm._v("\n    จำนวนเงิน *\n  ")]
      ),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass: "media_claim_col",
          staticStyle: {
            padding: "12px",
            width: "25%",
            "text-align": "center",
            color: "#212529",
            "font-weight": "bold",
            "border-bottom": "1px solid"
          }
        },
        [_vm._v("\n    ลบ\n  ")]
      )
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovCompany.vue?vue&type=template&id=591d145b&":
/*!*****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovCompany.vue?vue&type=template&id=591d145b& ***!
  \*****************************************************************************************************************************************************************************************************************************************/
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
    { staticClass: "el_select" },
    [
      _c(
        "el-select",
        {
          attrs: {
            placeholder: _vm.placeholder,
            name: _vm.attrName,
            "remote-method": _vm.remoteMethod,
            loading: _vm.loading,
            remote: "",
            clearable: true,
            filterable: "",
            size: _vm.size,
            disabled: _vm.disabled
          },
          on: { change: _vm.onchange },
          nativeOn: {
            click: function($event) {
              return _vm.onclick($event)
            }
          },
          model: {
            value: _vm.result,
            callback: function($$v) {
              _vm.result = $$v
            },
            expression: "result"
          }
        },
        _vm._l(_vm.rows, function(data, index) {
          return _c("el-option", {
            key: index,
            attrs: {
              label: data.company_number + ": " + data.company_name,
              value: data.company_id
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovCompanyPolicyGroup.vue?vue&type=template&id=083732c2&":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovCompanyPolicyGroup.vue?vue&type=template&id=083732c2& ***!
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
    { staticClass: "el_select" },
    [
      _c(
        "el-select",
        {
          attrs: {
            placeholder: _vm.placeholder,
            name: _vm.attrName,
            "remote-method": _vm.remoteMethod,
            loading: _vm.loading,
            remote: "",
            clearable: true,
            filterable: "",
            size: _vm.size,
            disabled: _vm.disabled
          },
          on: { change: _vm.onchange },
          nativeOn: {
            click: function($event) {
              return _vm.onclick($event)
            }
          },
          model: {
            value: _vm.result,
            callback: function($$v) {
              _vm.result = $$v
            },
            expression: "result"
          }
        },
        [
          _vm._v("ß\n             "),
          _vm._v(" "),
          _vm._l(_vm.rows, function(data, index) {
            return _c("el-option", {
              key: index,
              attrs: {
                label: data.company_number + ": " + data.company_name,
                value: data.company_id
              }
            })
          })
        ],
        2
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovDepartment.vue?vue&type=template&id=51097364&":
/*!********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovDepartment.vue?vue&type=template&id=51097364& ***!
  \********************************************************************************************************************************************************************************************************************************************/
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
    { staticClass: "el_select" },
    [
      _c(
        "el-select",
        {
          attrs: {
            placeholder: _vm.placeholder,
            name: _vm.attrName,
            "remote-method": _vm.remoteMethod,
            loading: _vm.loading,
            remote: "",
            clearable: true,
            filterable: "",
            disabled: _vm.disabled
          },
          on: { change: _vm.onchange },
          nativeOn: {
            click: function($event) {
              return _vm.onclick($event)
            }
          },
          model: {
            value: _vm.result,
            callback: function($$v) {
              _vm.result = $$v
            },
            expression: "result"
          }
        },
        _vm._l(_vm.rows, function(data, index) {
          return _c("el-option", {
            key: index,
            attrs: {
              label: data.department_code + ": " + data.description,
              value: data.department_code
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovInvoiceNumberAr.vue?vue&type=template&id=74e36c85&":
/*!*************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovInvoiceNumberAr.vue?vue&type=template&id=74e36c85& ***!
  \*************************************************************************************************************************************************************************************************************************************************/
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
    { staticClass: "el_select" },
    [
      _c(
        "el-select",
        {
          attrs: {
            placeholder: "เลขที่อ้างอิงเอกสารในระบบ AR",
            name: _vm.attrName,
            "remote-method": _vm.remoteMethod,
            loading: _vm.loading,
            remote: "",
            clearable: true,
            filterable: ""
          },
          on: { focus: _vm.focus, change: _vm.change },
          model: {
            value: _vm.invoice_number,
            callback: function($$v) {
              _vm.invoice_number = $$v
            },
            expression: "invoice_number"
          }
        },
        _vm._l(_vm.dataRows, function(data, index) {
          return _c("el-option", {
            key: index,
            attrs: { label: data.ar_invoice_num, value: data.ar_invoice_num }
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovLocation.vue?vue&type=template&id=746f3cc7&":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovLocation.vue?vue&type=template&id=746f3cc7& ***!
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
    { staticClass: "el_select" },
    [
      _c(
        "el-select",
        {
          attrs: {
            placeholder: _vm.placeholder,
            name: _vm.attrName,
            "remote-method": _vm.remoteMethod,
            loading: _vm.loading,
            remote: "",
            clearable: true,
            filterable: "",
            disabled: _vm.disabled
          },
          on: { focus: _vm.focus, change: _vm.change },
          model: {
            value: _vm.result,
            callback: function($$v) {
              _vm.result = $$v
            },
            expression: "result"
          }
        },
        _vm._l(_vm.rows, function(data, index) {
          return _c("el-option", {
            key: index,
            attrs: {
              label: data.meaning + ": " + data.description,
              value: data.meaning
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovPolicyGroup.vue?vue&type=template&id=31f6456a&":
/*!*********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovPolicyGroup.vue?vue&type=template&id=31f6456a& ***!
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
  return _c(
    "div",
    { staticClass: "el_field" },
    [
      _c(
        "el-select",
        {
          attrs: {
            placeholder: _vm.placeholder,
            name: _vm.name,
            "remote-method": _vm.remoteMethod,
            loading: _vm.loading,
            remote: "",
            clearable: true,
            filterable: "",
            size: _vm.size,
            "popper-append-to-body": _vm.popperBody,
            disabled: _vm.disabled
          },
          on: { change: _vm.onchange, focus: _vm.onfocus },
          nativeOn: {
            click: function($event) {
              return _vm.onclick($event)
            }
          },
          model: {
            value: _vm.result,
            callback: function($$v) {
              _vm.result = $$v
            },
            expression: "result"
          }
        },
        _vm._l(_vm.rows, function(data, index) {
          return _c("el-option", {
            key: index,
            attrs: {
              label: data.group_code + ": " + data.group_description,
              value: data.group_header_id
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovPolicySetHeaderId.vue?vue&type=template&id=6cbf2d56&":
/*!***************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/lovPolicySetHeaderId.vue?vue&type=template&id=6cbf2d56& ***!
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
  return _c(
    "div",
    { staticClass: "el_field" },
    [
      _c(
        "el-select",
        {
          attrs: {
            placeholder: _vm.placeholder,
            name: _vm.name,
            "remote-method": _vm.remoteMethod,
            loading: _vm.loading,
            remote: "",
            clearable: true,
            filterable: "",
            size: _vm.size,
            "popper-append-to-body": _vm.popperBody,
            disabled: _vm.isDisabled
          },
          on: { focus: _vm.onfocus, change: _vm.onchange },
          model: {
            value: _vm.result,
            callback: function($$v) {
              _vm.result = $$v
            },
            expression: "result"
          }
        },
        _vm._l(_vm.rows, function(data, index) {
          return _c("el-option", {
            key: index,
            attrs: {
              label:
                data.policy_set_number + ": " + data.policy_set_description,
              value: data.policy_set_header_id
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/modalDetails.vue?vue&type=template&id=3f382c74&":
/*!*******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/modalDetails.vue?vue&type=template&id=3f382c74& ***!
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
  return _c(
    "div",
    {
      staticClass: "modal inmodal fade",
      attrs: {
        id: "modal_details" + _vm.index,
        tabindex: "-1",
        role: "dialog",
        "aria-hidden": "true"
      }
    },
    [
      _c("div", { staticClass: "modal-dialog modal-lg" }, [
        _c("div", { staticClass: "modal-content" }, [
          _vm._m(0),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "modal-body" },
            [
              _c(
                "el-form",
                {
                  ref: "modal_details",
                  staticClass: "demo-ruleForm",
                  attrs: {
                    model: _vm.details,
                    "label-width": "120px",
                    rules: _vm.rules
                  }
                },
                [
                  _c("div", { staticClass: "margin_top_20" }, [
                    _c("h5", [_vm._v("สถานะได้รับแจ้งเรื่องแล้ว")]),
                    _vm._v(" "),
                    _c("div", { staticClass: "row" }, [
                      _c(
                        "label",
                        { staticClass: "col-md-5 col-form-label lable_align" },
                        [_c("strong", [_vm._v("วันที่รับแจ้งเรื่อง")])]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "col-xl-4 col-lg-5 col-md-6 el_field" },
                        [
                          _c(
                            "el-form-item",
                            [
                              _c("datepicker-th", {
                                staticClass: "el-input__inner",
                                staticStyle: { width: "100%" },
                                attrs: {
                                  name: "informant_date",
                                  "p-type": "date",
                                  placeholder: "วันที่รับแจ้งเรื่อง",
                                  format: _vm.vars.formatDate,
                                  disabled:
                                    _vm.checkStatusInterface(_vm.status) ||
                                    _vm.checkStatusConfirmed(_vm.status) ||
                                    _vm.checkStatusCancelled(_vm.status)
                                },
                                on: {
                                  dateWasSelected: _vm.getValueInformantDate
                                },
                                model: {
                                  value: _vm.details.informant_date,
                                  callback: function($$v) {
                                    _vm.$set(_vm.details, "informant_date", $$v)
                                  },
                                  expression: "details.informant_date"
                                }
                              })
                            ],
                            1
                          )
                        ],
                        1
                      )
                    ]),
                    _vm._v(" "),
                    _c("h5", { staticClass: "margin_top_20" }, [
                      _vm._v("สถานะแจ้งบริษัทประกันแล้ว")
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "row" }, [
                      _c(
                        "label",
                        { staticClass: "col-md-5 col-form-label lable_align" },
                        [_c("strong", [_vm._v("Invoice Date *")])]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "col-xl-4 col-lg-5 col-md-6 el_field" },
                        [
                          _c(
                            "el-form-item",
                            { attrs: { prop: "invoice_date" } },
                            [
                              _c("datepicker-th", {
                                staticClass: "el-input__inner",
                                staticStyle: { width: "100%" },
                                attrs: {
                                  name: "invoice_date",
                                  "p-type": "date",
                                  placeholder: "Invoice Date",
                                  format: _vm.vars.formatDate,
                                  disabled:
                                    _vm.checkStatusInterface(_vm.status) ||
                                    _vm.checkStatusConfirmed(_vm.status) ||
                                    _vm.checkStatusCancelled(_vm.status)
                                },
                                on: {
                                  dateWasSelected: _vm.getValueInvoiceDate
                                },
                                model: {
                                  value: _vm.details.invoice_date,
                                  callback: function($$v) {
                                    _vm.$set(_vm.details, "invoice_date", $$v)
                                  },
                                  expression: "details.invoice_date"
                                }
                              })
                            ],
                            1
                          )
                        ],
                        1
                      )
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "row" }, [
                      _c(
                        "label",
                        { staticClass: "col-md-5 col-form-label lable_align" },
                        [_c("strong", [_vm._v("GL Date *")])]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "col-xl-4 col-lg-5 col-md-6 el_field" },
                        [
                          _c(
                            "el-form-item",
                            { attrs: { prop: "gl_date" } },
                            [
                              _c("datepicker-th", {
                                staticClass: "el-input__inner",
                                staticStyle: { width: "100%" },
                                attrs: {
                                  name: "gl_date",
                                  "p-type": "date",
                                  placeholder: "GL Date",
                                  format: _vm.vars.formatDate,
                                  disabled:
                                    _vm.checkStatusInterface(_vm.status) ||
                                    _vm.checkStatusConfirmed(_vm.status) ||
                                    _vm.checkStatusCancelled(_vm.status)
                                },
                                on: { dateWasSelected: _vm.getValueGlDate },
                                model: {
                                  value: _vm.details.gl_date,
                                  callback: function($$v) {
                                    _vm.$set(_vm.details, "gl_date", $$v)
                                  },
                                  expression: "details.gl_date"
                                }
                              })
                            ],
                            1
                          )
                        ],
                        1
                      )
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "row" }, [
                      _c(
                        "label",
                        { staticClass: "col-md-5 col-form-label lable_align" },
                        [
                          _c("strong", [
                            _vm._v("เลขที่อ้างอิงกับเอกสารในระบบ AR")
                          ])
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "col-xl-4 col-lg-5 col-md-6 el_field" },
                        [
                          _c(
                            "el-form-item",
                            [
                              _c("el-input", {
                                attrs: {
                                  placeholder:
                                    "เลขที่อ้างอิงกับเอกสารในระบบ AR",
                                  disabled: true,
                                  name: "ar_invoice_num"
                                },
                                model: {
                                  value: _vm.details.ar_invoice_num,
                                  callback: function($$v) {
                                    _vm.$set(_vm.details, "ar_invoice_num", $$v)
                                  },
                                  expression: "details.ar_invoice_num"
                                }
                              })
                            ],
                            1
                          )
                        ],
                        1
                      )
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "row" }, [
                      _c(
                        "label",
                        { staticClass: "col-md-5 col-form-label lable_align" },
                        [_c("strong", [_vm._v("เลขที่กรมธรรม์")])]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "col-xl-4 col-lg-5 col-md-6 el_field" },
                        [
                          _c(
                            "el-form-item",
                            [
                              _c("el-input", {
                                attrs: { placeholder: "เลขที่กรมธรรม์" },
                                model: {
                                  value: _vm.details.policy_number,
                                  callback: function($$v) {
                                    _vm.$set(_vm.details, "policy_number", $$v)
                                  },
                                  expression: "details.policy_number"
                                }
                              })
                            ],
                            1
                          )
                        ],
                        1
                      )
                    ]),
                    _vm._v(" "),
                    _c("h5", { staticClass: "margin_top_20" }, [
                      _vm._v("สถานะได้รับชดใช้แล้ว")
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "row" }, [
                      _c(
                        "label",
                        { staticClass: "col-md-5 col-form-label lable_align" },
                        [_c("strong", [_vm._v("วันที่ได้รับชดใช้")])]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "col-xl-4 col-lg-5 col-md-6 el_field" },
                        [
                          _c(
                            "el-form-item",
                            [
                              _c("datepicker-th", {
                                staticClass: "el-input__inner",
                                staticStyle: { width: "100%" },
                                attrs: {
                                  name: "ar_receipt_date",
                                  "p-type": "date",
                                  placeholder: "วันที่ได้รับชดใช้",
                                  format: _vm.vars.formatDate,
                                  disabled: true
                                },
                                on: {
                                  dateWasSelected: _vm.getValueArReceiptDate
                                },
                                model: {
                                  value: _vm.details.ar_receipt_date,
                                  callback: function($$v) {
                                    _vm.$set(
                                      _vm.details,
                                      "ar_receipt_date",
                                      $$v
                                    )
                                  },
                                  expression: "details.ar_receipt_date"
                                }
                              })
                            ],
                            1
                          )
                        ],
                        1
                      )
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "row" }, [
                      _c(
                        "label",
                        { staticClass: "col-md-5 col-form-label lable_align" },
                        [_c("strong", [_vm._v("เลขที่ใบเสร็จรับเงิน")])]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "col-xl-4 col-lg-5 col-md-6 el_field" },
                        [
                          _c(
                            "el-form-item",
                            [
                              _c("el-input", {
                                attrs: {
                                  placeholder: "เลขที่ใบเสร็จรับเงิน",
                                  disabled: true
                                },
                                model: {
                                  value: _vm.details.ar_receipt_number,
                                  callback: function($$v) {
                                    _vm.$set(
                                      _vm.details,
                                      "ar_receipt_number",
                                      $$v
                                    )
                                  },
                                  expression: "details.ar_receipt_number"
                                }
                              })
                            ],
                            1
                          )
                        ],
                        1
                      )
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "row" }, [
                      _c(
                        "label",
                        { staticClass: "col-md-5 col-form-label lable_align" },
                        [_c("strong", [_vm._v("จำนวนเงินที่ได้รับ")])]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "col-xl-4 col-lg-5 col-md-6 el_field" },
                        [
                          _c(
                            "el-form-item",
                            [
                              _c("currency-input", {
                                attrs: {
                                  name: "ar_received_amount",
                                  sizeSmall: false,
                                  placeholder: "จำนวนเงินที่ได้รับ",
                                  disabled: true
                                },
                                model: {
                                  value: _vm.details.ar_received_amount,
                                  callback: function($$v) {
                                    _vm.$set(
                                      _vm.details,
                                      "ar_received_amount",
                                      $$v
                                    )
                                  },
                                  expression: "details.ar_received_amount"
                                }
                              })
                            ],
                            1
                          )
                        ],
                        1
                      )
                    ])
                  ])
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
                staticClass: "btn btn-primary",
                attrs: { type: "button" },
                on: {
                  click: function($event) {
                    return _vm.clickSave()
                  }
                }
              },
              [
                _c("i", { staticClass: "fa fa-save" }),
                _vm._v(" บันทึก\n        ")
              ]
            ),
            _vm._v(" "),
            _vm._m(1)
          ])
        ])
      ])
    ]
  )
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
      _c("p", { staticClass: "modal-title text-left" }, [
        _vm._v("รายละเอียด (Details)")
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "button",
      {
        staticClass: "btn btn-danger",
        attrs: { type: "button", "data-dismiss": "modal" }
      },
      [_c("i", { staticClass: "fa fa-times" }), _vm._v(" ยกเลิก\n        ")]
    )
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/policyHeaderForm.vue?vue&type=template&id=6deb8b34&":
/*!***********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/claim-insurance/policyHeaderForm.vue?vue&type=template&id=6deb8b34& ***!
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
  return _vm._m(0)
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticStyle: { display: "flex", width: "100%" } }, [
      _c(
        "div",
        {
          staticClass: "media_claim_col",
          staticStyle: {
            padding: "12px",
            width: "25%",
            "text-align": "center",
            color: "#212529",
            "font-weight": "bold",
            "border-bottom": "1px solid"
          }
        },
        [_vm._v("\n    กลุ่มกรมธรรม์\n  ")]
      ),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass: "media_claim_col",
          staticStyle: {
            padding: "12px",
            width: "25%",
            "text-align": "center",
            color: "#212529",
            "font-weight": "bold",
            "border-bottom": "1px solid"
          }
        },
        [_vm._v("\n    ชุดกรมธรรม์\n  ")]
      ),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass: "media_claim_col",
          staticStyle: {
            padding: "12px",
            width: "25%",
            "text-align": "center",
            color: "#212529",
            "font-weight": "bold",
            "border-bottom": "1px solid"
          }
        },
        [_vm._v("\n    จำนวนเงินเรียกชดใช้ *\n  ")]
      ),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass: "media_claim_col",
          staticStyle: {
            padding: "12px",
            width: "25%",
            "text-align": "center",
            color: "#212529",
            "font-weight": "bold",
            "border-bottom": "1px solid"
          }
        },
        [_vm._v("\n   ลบ\n  ")]
      )
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/components/calendar/dateInput.vue?vue&type=template&id=534314ae&":
/*!********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/components/calendar/dateInput.vue?vue&type=template&id=534314ae& ***!
  \********************************************************************************************************************************************************************************************************************************************/
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
    { class: "el-input date " + (_vm.sizeSmall ? "el-input--small" : "") },
    [
      _c("input", {
        directives: [
          {
            name: "model",
            rawName: "v-model",
            value: _vm.date,
            expression: "date"
          }
        ],
        staticClass: "input-medium form-control date_input el-input__inner",
        attrs: {
          type: "text",
          name: _vm.attrName,
          "data-provide": "datepicker",
          "data-date-language": "th-th",
          placeholder: _vm.placeholder,
          autocomplete: "off",
          disabled: _vm.disabled
        },
        domProps: { value: _vm.date },
        on: {
          input: function($event) {
            if ($event.target.composing) {
              return
            }
            _vm.date = $event.target.value
          }
        }
      })
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/components/currencyInput.vue?vue&type=template&id=0d3f0f2b&scoped=true&":
/*!***************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/components/currencyInput.vue?vue&type=template&id=0d3f0f2b&scoped=true& ***!
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
  return _c(
    "div",
    { class: "el-input " + (_vm.sizeSmall ? "el-input--small" : "") },
    [
      _c("input", {
        directives: [
          {
            name: "model",
            rawName: "v-model",
            value: _vm.displayValue,
            expression: "displayValue"
          }
        ],
        staticClass: "form-control el-input__inner input-currency  text-right",
        attrs: {
          type: "text",
          name: _vm.name,
          placeholder: _vm.placeholder,
          autocomplete: "off",
          disabled: _vm.disabled,
          maxlength: "15"
        },
        domProps: { value: _vm.displayValue },
        on: {
          blur: _vm.blur,
          focus: function($event) {
            _vm.isInputActive = true
          },
          input: function($event) {
            if ($event.target.composing) {
              return
            }
            _vm.displayValue = $event.target.value
          }
        }
      })
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/components/currencyInputGroupAppend.vue?vue&type=template&id=773135fe&":
/*!**************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/components/currencyInputGroupAppend.vue?vue&type=template&id=773135fe& ***!
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
  return _c(
    "div",
    {
      class:
        "el-input el-input-group el-input-group--append " +
        (_vm.sizeSmall ? "el-input--small" : "") +
        " " +
        (_vm.disabled ? "is-disabled" : "")
    },
    [
      _c("input", {
        directives: [
          {
            name: "model",
            rawName: "v-model",
            value: _vm.displayValue,
            expression: "displayValue"
          }
        ],
        staticClass: "el-input__inner",
        attrs: {
          type: "text",
          name: _vm.name,
          placeholder: _vm.placeholder,
          autocomplete: "off",
          disabled: _vm.disabled,
          maxlength: "15"
        },
        domProps: { value: _vm.displayValue },
        on: {
          blur: _vm.blur,
          focus: function($event) {
            return _vm.focus()
          },
          input: function($event) {
            if ($event.target.composing) {
              return
            }
            _vm.displayValue = $event.target.value
          }
        }
      }),
      _vm._v(" "),
      _vm.showAppend
        ? _c("div", { staticClass: "el-input-group__append" }, [
            _vm._v("\n    " + _vm._s(_vm.wordingAppend) + "\n  ")
          ])
        : _vm._e()
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js":
/*!********************************************************************!*\
  !*** ./node_modules/vue-loader/lib/runtime/componentNormalizer.js ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => /* binding */ normalizeComponent
/* harmony export */ });
/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file (except for modules).
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

function normalizeComponent (
  scriptExports,
  render,
  staticRenderFns,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier, /* server only */
  shadowMode /* vue-cli only */
) {
  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (render) {
    options.render = render
    options.staticRenderFns = staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = 'data-v-' + scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = shadowMode
      ? function () {
        injectStyles.call(
          this,
          (options.functional ? this.parent : this).$root.$options.shadowRoot
        )
      }
      : injectStyles
  }

  if (hook) {
    if (options.functional) {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functional component in vue file
      var originalRender = options.render
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return originalRender(h, context)
      }
    } else {
      // inject component registration as beforeCreate hook
      var existing = options.beforeCreate
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    }
  }

  return {
    exports: scriptExports,
    options: options
  }
}


/***/ })

}]);