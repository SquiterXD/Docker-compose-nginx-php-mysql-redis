(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ir_settings_policy_create-policy_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/create-policy.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/create-policy.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _formPolicy__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./formPolicy */ "./resources/js/components/ir/settings/policy/formPolicy.vue");
//
//
//
//
//
//

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['btnTrans', 'runningNo'],
  data: function data() {
    return {
      policy: {
        policy_set_number: this.runningNo,
        policy_set_description: '',
        policy_type_code: '',
        policy_age: '',
        type_cost: '',
        account_combine: '',
        account_combine_gl: '',
        include_tax_flag: true,
        active_flag: true,
        policy_set_header_id: '',
        policyTypeCodes: [],
        group_code: '',
        policy_category_code: '',
        id_account: '',
        id_account_gl: '',
        gl_expense_account_id: '',
        mode: 'create'
      }
    };
  },
  components: {
    FormPolicy: _formPolicy__WEBPACK_IMPORTED_MODULE_0__.default
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/formPolicy.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/formPolicy.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _selectOptionPolicyType__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./selectOptionPolicyType */ "./resources/js/components/ir/settings/policy/selectOptionPolicyType.vue");
/* harmony import */ var _selectOptionPolicyTypeGl__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./selectOptionPolicyTypeGl */ "./resources/js/components/ir/settings/policy/selectOptionPolicyTypeGl.vue");
/* harmony import */ var _selectPolicyType__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./selectPolicyType */ "./resources/js/components/ir/settings/policy/selectPolicyType.vue");
/* harmony import */ var _selectGroup__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./selectGroup */ "./resources/js/components/ir/settings/policy/selectGroup.vue");
/* harmony import */ var _selectPolicyCategory__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./selectPolicyCategory */ "./resources/js/components/ir/settings/policy/selectPolicyCategory.vue");
/* harmony import */ var _scripts__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../../scripts */ "./resources/js/components/ir/scripts.js");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  name: 'ir-form-policy',
  data: function data() {
    return {
      policyTypeCodes: [],
      id_account: '',
      id_account_gl: '',
      rules: {
        policy_set_number: [{
          required: true,
          message: 'กรุณาระบุชุดกรมธรรม์',
          trigger: 'change'
        }],
        policy_set_description: [{
          required: true,
          message: 'กรุณาระบุคำอธิบาย',
          trigger: 'change'
        }],
        policy_type_code: [{
          required: true,
          message: 'กรุณาระบุแบบของการประกัน',
          trigger: 'change'
        }],
        policy_age: [{
          required: true,
          message: 'กรุณาระบุอายุกรมธรรม์',
          trigger: 'change'
        }],
        type_cost: [{
          required: true,
          message: 'กรุณาระบุประเภทค่าใช้จ่าย',
          trigger: 'change'
        }],
        account_combine: [{
          required: true,
          message: 'กรุณาระบุชุดรหัสบัญชี',
          trigger: 'change'
        }],
        include_tax_flag: [{
          required: true,
          message: 'กรุณาระบุชุดกรมธรรม์',
          trigger: 'change'
        }],
        group_code: [{
          required: true,
          message: 'กรุณาระบุกลุ่ม',
          trigger: 'change'
        }],
        policy_category_code: [{
          required: true,
          message: 'กรุณาระบุประเภทกรมธรรม์',
          trigger: 'change'
        }],
        account_combine_gl: [{
          required: true,
          message: 'กรุณาระบุชุดรหัสบัญชี',
          trigger: 'change'
        }],
        gl_expense_account_id: [{
          required: true,
          message: 'กรุณาระบุประเภทค่าใช้จ่าย',
          trigger: 'change'
        }]
      },
      funcs: _scripts__WEBPACK_IMPORTED_MODULE_5__.funcs
    };
  },
  props: ['policy', 'updateUrl', 'btnTrans'],
  methods: {
    getPolicyTypeCodes: function getPolicyTypeCodes() {
      var _this2 = this;

      axios.get("/ir/ajax/lov/policy-type").then(function (_ref) {
        var data = _ref.data;
        _this2.policyTypeCodes = data.data;
      })["catch"](function (error) {});
    },
    save: function save() {
      var _this3 = this;

      this.$refs['save_policy'].validate(function (valid) {
        if (valid) {
          if (_this3.policy.mode == 'edit') {
            var checked = $(".form_company_active").is(':checked');
            var active_flag = checked ? 'Y' : 'N';
            axios.put("/ir/ajax/policy/update", {
              policy_set_header_id: _this3.policy.policy_set_header_id,
              policy_set_number: _this3.policy.policy_set_number,
              policy_set_description: _this3.policy.policy_set_description,
              policy_type_code: _this3.policy.policy_type_code,
              policy_age: _this3.policy.policy_age,
              type_cost: _this3.policy.type_cost,
              gl_expense_account_id: _this3.policy.gl_expense_account_id,
              include_tax_flag: _this3.policy.include_tax_flag ? 'Y' : 'N',
              account_combine: _this3.policy.account_combine,
              account_combine_gl: _this3.policy.account_combine_gl,
              policy_category_code: _this3.policy.policy_category_code,
              group_code: _this3.policy.group_code,
              // active_flag: this.policy.active_flag ? 'Y' : 'N',
              active_flag: active_flag,
              account_id: _this3.policy.account_id,
              account_id_gl: _this3.policy.account_id_gl
            }).then(function (response) {
              swal({
                title: "Success",
                text: 'บันทึกสำเร็จ',
                // timer: 3000,
                type: "success" // showCancelButton: false,
                // showConfirmButton: true

              }, function (isConfirm) {
                window.location.href = '/ir/settings/policy';
              }); // setTimeout(() => {
              //   window.location.href = '/ir/settings/policy'
              // }, 3000)
            })["catch"](function (error) {
              if (error.response.data.status === 400) {
                swal({
                  title: "Warning",
                  text: error.response.data.message,
                  // timer: 3000,
                  type: "warning"
                });
              } else {
                swal({
                  title: "Error",
                  text: error.response.data.message,
                  // timer: 3000,
                  type: "error"
                });
              }
            });
          } else {
            axios.post("/ir/ajax/policy/save", {
              policy_set_number: _this3.policy.policy_set_number,
              policy_set_description: _this3.policy.policy_set_description,
              policy_type_code: _this3.policy.policy_type_code,
              policy_age: _this3.policy.policy_age,
              type_cost: _this3.policy.type_cost,
              gl_expense_account_id: _this3.policy.gl_expense_account_id,
              include_tax_flag: _this3.policy.include_tax_flag ? 'Y' : 'N',
              policy_category_code: _this3.policy.policy_category_code,
              group_code: _this3.policy.group_code,
              account_combine: _this3.policy.account_combine,
              account_combine_gl: _this3.policy.account_combine_gl,
              active_flag: _this3.policy.active_flag ? 'Y' : 'N',
              account_id: _this3.policy.account_id,
              account_id_gl: _this3.policy.account_id_gl,
              program_code: 'IRM0002'
            }).then(function (_ref2) {
              var data = _ref2.data;
              swal({
                title: "Success",
                text: data.message,
                // timer: 3000,
                type: "success",
                showCancelButton: false,
                showConfirmButton: true
              }, function (isConfirm) {
                window.location.href = '/ir/settings/policy';
              }); // setTimeout(() => {
              //   window.location.href = '/ir/settings/policy'
              // }, 3000)
            })["catch"](function (error) {
              if (error.response.data.status === 400) {
                swal({
                  title: "Warning",
                  text: error.response.data.message,
                  // timer: 3000,
                  type: "warning"
                });
              } else {
                swal({
                  title: "Error",
                  text: error.response.data.message,
                  // timer: 3000,
                  type: "error"
                });
              }
            });
          }
        } else {
          return false;
        }
      });
    },
    receivedTypeCode: function receivedTypeCode(combine, type_code) {
      this.policy.account_combine = combine;
      this.policy.type_cost = type_code;
      this.policy.account_id = type_code;
    },
    receivedTypeCodeGL: function receivedTypeCodeGL(combine, type_code) {
      this.policy.account_combine_gl = combine;
      this.policy.gl_expense_account_id = type_code;
      this.policy.account_id_gl = type_code;
    },
    receivedGroupCode: function receivedGroupCode(group) {
      this.policy.group_code = group;
    },
    receivedPolicyCategory: function receivedPolicyCategory(category) {
      this.policy.policy_category_code = category;
    },
    clickCancel: function clickCancel() {
      window.location.href = '/ir/settings/policy';
    },
    changeActiveFlag: function changeActiveFlag() {
      var _this = this;

      axios.put("/ir/ajax/policy/check-used-data/".concat(this.policy.policy_set_header_id)).then(function (_ref3) {
        var data = _ref3.data;
      })["catch"](function (error) {
        if (error.response.data.status === 400) {
          swal({
            title: "Warning",
            text: error.response.data.message,
            type: "warning"
          }, function (isConfirm) {
            if (isConfirm) {
              _this.funcs.setDefaultActive("form_company_active");
            }
          });
        } else {
          swal("Error", error, "error");
        }
      });
    },
    onlyNumeric: function onlyNumeric() {// if (this.policy.policy_set_number) {
      //   this.policy.policy_set_number = this.policy.policy_set_number.replace(/[^0-9 .]/g, '');
      // }
      // if (this.policy.policy_age) {
      //   this.policy.policy_age = this.policy.policy_age.replace(/[^0-9 .]/g, '');
      // }
    }
  },
  computed: {
    disabledField: function disabledField() {
      if (this.policy.mode === 'edit') {
        return true;
      }

      return false;
    }
  },
  components: {
    'type-cost': _selectOptionPolicyType__WEBPACK_IMPORTED_MODULE_0__.default,
    'type-cost-gl': _selectOptionPolicyTypeGl__WEBPACK_IMPORTED_MODULE_1__.default,
    'policy': _selectPolicyType__WEBPACK_IMPORTED_MODULE_2__.default,
    'group-code': _selectGroup__WEBPACK_IMPORTED_MODULE_3__.default,
    'policy-category': _selectPolicyCategory__WEBPACK_IMPORTED_MODULE_4__.default
  },
  created: function created() {
    this.getPolicyTypeCodes();
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectGroup.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectGroup.vue?vue&type=script&lang=js& ***!
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'ir-select-group',
  data: function data() {
    return {
      groups: [],
      loading: false,
      group_code: this.valueTypeCost,
      account_id: ''
    };
  },
  props: ['valueTypeCost'],
  mounted: function mounted() {
    this.getGroupCode({
      account_id: '',
      keyword: ''
    });
  },
  methods: {
    remoteMethod: function remoteMethod() {
      this.getGroupCode();
    },
    getGroupCode: function getGroupCode() {
      var _this = this;

      this.loading = true;
      axios.get("/ir/ajax/lov/group-code").then(function (_ref) {
        var response = _ref.data;
        _this.loading = false;
        _this.groups = response.data;
      });
    },
    change: function change(value) {
      if (value) {
        this.callbackGroupCode(value);
      } else {
        this.callbackGroupCode('');
      }
    },
    callbackGroupCode: function callbackGroupCode(value) {
      this.$emit('group', value);
    }
  },
  updated: function updated() {
    this.$nextTick(function () {
      var data = window.localStorage.getItem('data');
      var result = JSON.parse(data);
      this.account_id = location.href.split("/")[7];
    });
  },
  watch: {
    'valueTypeCost': function valueTypeCost(newVal, oldVal) {
      this.group_code = newVal;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectOptionPolicyType.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectOptionPolicyType.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'ir-select-option-policy-type',
  data: function data() {
    return {
      typeCosts: [],
      loading: false,
      type_cost: this.valueTypeCost
    };
  },
  props: ['valueTypeCost', 'id_account'],
  mounted: function mounted() {
    this.getTypeCosts({
      account_id: '',
      keyword: ''
    });
  },
  methods: {
    remoteMethod: function remoteMethod(query) {
      this.getTypeCosts({
        account_id: '',
        keyword: query
      });
    },
    getTypeCosts: function getTypeCosts(params) {
      var _this = this;

      this.loading = true;
      axios.get("/ir/ajax/lov/account-code-combine", {
        params: params
      }).then(function (res) {
        var response = res.data;
        _this.loading = false;
        _this.typeCosts = response.data;

        if (_this.id_account) {
          for (var i in _this.typeCosts) {
            var data = _this.typeCosts[i];

            if (parseInt(_this.id_account) === parseInt(data.account_id)) {
              _this.type_cost = data.account_code;

              _this.callbackTypeCode(data.account_combine, data.account_id);
            }
          }
        }
      });
    },
    change: function change(value) {
      if (value) {
        for (var i in this.typeCosts) {
          var data = this.typeCosts[i];

          if (value === data.account_code) {
            this.callbackTypeCode(data.account_combine, data.account_id);
          }
        }
      } else {
        this.callbackTypeCode('', '');
      }
    },
    callbackTypeCode: function callbackTypeCode(combine, id) {
      this.$emit('typeCode', combine, id);
    }
  },
  updated: function updated() {
    this.$nextTick(function () {
      var data = window.localStorage.getItem('data');
      var result = JSON.parse(data);
      this.account_id = location.href.split("/")[7];
    });
  },
  watch: {
    'account_id': function account_id(newVal, oldVal) {
      this.getTypeCosts({
        account_id: '',
        keyword: ''
      });
    },
    'id_account': function id_account(newVal, oldVal) {
      this.getTypeCosts({
        account_id: '',
        keyword: ''
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectOptionPolicyTypeGl.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectOptionPolicyTypeGl.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'ir-select-option-policy-type',
  data: function data() {
    return {
      typeCosts: [],
      loading: false,
      type_cost: this.valueTypeCost
    };
  },
  props: ['valueTypeCost', 'id_account'],
  mounted: function mounted() {
    this.getTypeCosts({
      account_id: '',
      keyword: ''
    });
  },
  methods: {
    remoteMethod: function remoteMethod(query) {
      this.getTypeCosts({
        account_id: '',
        keyword: query
      });
    },
    getTypeCosts: function getTypeCosts(params) {
      var _this = this;

      this.loading = true;
      axios.get("/ir/ajax/lov/account-code-combine", {
        params: params
      }).then(function (res) {
        var response = res.data;
        _this.loading = false;
        _this.typeCosts = response.data;

        if (_this.id_account) {
          for (var i in _this.typeCosts) {
            var data = _this.typeCosts[i];

            if (parseInt(_this.id_account) === parseInt(data.account_id)) {
              _this.type_cost = data.account_code;

              _this.callbackTypeCode(data.account_combine, data.account_id);
            }
          }
        }
      });
    },
    change: function change(value) {
      if (value) {
        for (var i in this.typeCosts) {
          var data = this.typeCosts[i];

          if (value === data.account_code) {
            this.callbackTypeCode(data.account_combine, data.account_id);
          }
        }
      } else {
        this.callbackTypeCode('', '');
      }
    },
    callbackTypeCode: function callbackTypeCode(combine, id) {
      this.$emit('typeCode', combine, id);
    }
  },
  updated: function updated() {
    this.$nextTick(function () {
      var data = window.localStorage.getItem('data');
      var result = JSON.parse(data);
      this.account_id = location.href.split("/")[7];
    });
  },
  watch: {
    'account_id': function account_id(newVal, oldVal) {
      this.getTypeCosts({
        account_id: '',
        keyword: ''
      });
    },
    'id_account': function id_account(newVal, oldVal) {
      this.getTypeCosts({
        account_id: '',
        keyword: ''
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectPolicyCategory.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectPolicyCategory.vue?vue&type=script&lang=js& ***!
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'ir-select-group',
  data: function data() {
    return {
      categories: [],
      loading: false,
      policy_lookup: this.valueTypeCost,
      account_id: ''
    };
  },
  props: ['url', 'valueTypeCost'],
  mounted: function mounted() {
    this.getPolicyCategory({
      account_id: '',
      keyword: ''
    });
  },
  methods: {
    remoteMethod: function remoteMethod() {
      this.getPolicyCategory({
        account_id: '',
        keyword: query
      });
    },
    getPolicyCategory: function getPolicyCategory() {
      var _this = this;

      this.loading = true;
      axios.get("/ir/ajax/lov/policy-category").then(function (_ref) {
        var response = _ref.data;
        _this.loading = false;
        _this.categories = response.data;
      });
    },
    change: function change(value) {
      if (value) {
        this.callbackCategory(value);
      } else {
        this.callbackCategory('');
      }
    },
    callbackCategory: function callbackCategory(value) {
      this.$emit('category', value);
    }
  },
  updated: function updated() {
    this.$nextTick(function () {
      var data = window.localStorage.getItem('data');
      var result = JSON.parse(data);
      this.account_id = location.href.split("/")[7];
    });
  },
  watch: {
    'valueTypeCost': function valueTypeCost(newVal, oldVal) {
      this.policy_lookup = newVal;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectPolicyType.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectPolicyType.vue?vue&type=script&lang=js& ***!
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'ir-select-policy-type',
  data: function data() {
    return {
      policy: [],
      loading: false,
      policy_type_code: '',
      account_id: ''
    };
  },
  mounted: function mounted() {
    this.getPolicies({
      account_id: '',
      keyword: ''
    });
  },
  methods: {
    remoteMethod: function remoteMethod(query) {
      this.getPolicies({
        department_code: '',
        keyword: query
      });
    },
    getPolicies: function getPolicies(params) {
      var _this = this;

      this.loading = true;
      axios.get("/ir/ajax/lov/department-code", {
        params: params
      }).then(function (res) {
        var response = res.data;
        _this.loading = false;
        _this.policy = response.data;
      });
    },
    change: function change(value) {
      if (value) {
        for (var i in this.policy) {
          var data = this.policy[i];

          if (value === data.account_code) {
            $('input[name="account_combine"]').val(data.account_combine);
            $('input[name="account_id"]').val(data.account_id);
          }
        }
      } else {
        $('input[name="account_combine"]').val('');
        $('input[name="account_id"]').val('');
      }
    },
    updateDropdowns: function updateDropdowns(policy) {
      this.$emit('policy', policy);
    }
  },
  watch: {
    'account_id': function account_id(newVal, oldVal) {
      this.getPolicies({
        department_code: newVal,
        keyword: ''
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/formPolicy.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/formPolicy.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, ".el-form-item-irm0002{\n  margin-bottom: 10px;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectGroup.vue?vue&type=style&index=0&lang=css&":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectGroup.vue?vue&type=style&index=0&lang=css& ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, ".el_select .el-select {\n  width: 100%;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectOptionPolicyType.vue?vue&type=style&index=0&lang=css&":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectOptionPolicyType.vue?vue&type=style&index=0&lang=css& ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, ".el_select .el-select {\n  width: 100%;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectOptionPolicyTypeGl.vue?vue&type=style&index=0&lang=css&":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectOptionPolicyTypeGl.vue?vue&type=style&index=0&lang=css& ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, ".el_select .el-select {\n  width: 100%;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectPolicyCategory.vue?vue&type=style&index=0&lang=css&":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectPolicyCategory.vue?vue&type=style&index=0&lang=css& ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, ".el_select .el-select {\n  width: 100%;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectPolicyType.vue?vue&type=style&index=0&lang=css&":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectPolicyType.vue?vue&type=style&index=0&lang=css& ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, ".el_select .el-select {\n  width: 100%;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/formPolicy.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/formPolicy.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_formPolicy_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./formPolicy.vue?vue&type=style&index=0&scope=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/formPolicy.vue?vue&type=style&index=0&scope=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_formPolicy_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_formPolicy_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectGroup.vue?vue&type=style&index=0&lang=css&":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectGroup.vue?vue&type=style&index=0&lang=css& ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_selectGroup_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./selectGroup.vue?vue&type=style&index=0&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectGroup.vue?vue&type=style&index=0&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_selectGroup_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_selectGroup_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectOptionPolicyType.vue?vue&type=style&index=0&lang=css&":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectOptionPolicyType.vue?vue&type=style&index=0&lang=css& ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_selectOptionPolicyType_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./selectOptionPolicyType.vue?vue&type=style&index=0&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectOptionPolicyType.vue?vue&type=style&index=0&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_selectOptionPolicyType_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_selectOptionPolicyType_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectOptionPolicyTypeGl.vue?vue&type=style&index=0&lang=css&":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectOptionPolicyTypeGl.vue?vue&type=style&index=0&lang=css& ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_selectOptionPolicyTypeGl_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./selectOptionPolicyTypeGl.vue?vue&type=style&index=0&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectOptionPolicyTypeGl.vue?vue&type=style&index=0&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_selectOptionPolicyTypeGl_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_selectOptionPolicyTypeGl_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectPolicyCategory.vue?vue&type=style&index=0&lang=css&":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectPolicyCategory.vue?vue&type=style&index=0&lang=css& ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_selectPolicyCategory_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./selectPolicyCategory.vue?vue&type=style&index=0&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectPolicyCategory.vue?vue&type=style&index=0&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_selectPolicyCategory_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_selectPolicyCategory_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectPolicyType.vue?vue&type=style&index=0&lang=css&":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectPolicyType.vue?vue&type=style&index=0&lang=css& ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_selectPolicyType_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./selectPolicyType.vue?vue&type=style&index=0&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectPolicyType.vue?vue&type=style&index=0&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_selectPolicyType_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_selectPolicyType_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/components/ir/settings/policy/create-policy.vue":
/*!**********************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy/create-policy.vue ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _create_policy_vue_vue_type_template_id_3227b357___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./create-policy.vue?vue&type=template&id=3227b357& */ "./resources/js/components/ir/settings/policy/create-policy.vue?vue&type=template&id=3227b357&");
/* harmony import */ var _create_policy_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./create-policy.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/settings/policy/create-policy.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _create_policy_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _create_policy_vue_vue_type_template_id_3227b357___WEBPACK_IMPORTED_MODULE_0__.render,
  _create_policy_vue_vue_type_template_id_3227b357___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/settings/policy/create-policy.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/settings/policy/formPolicy.vue":
/*!*******************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy/formPolicy.vue ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _formPolicy_vue_vue_type_template_id_16193912___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./formPolicy.vue?vue&type=template&id=16193912& */ "./resources/js/components/ir/settings/policy/formPolicy.vue?vue&type=template&id=16193912&");
/* harmony import */ var _formPolicy_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./formPolicy.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/settings/policy/formPolicy.vue?vue&type=script&lang=js&");
/* harmony import */ var _formPolicy_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./formPolicy.vue?vue&type=style&index=0&scope=true&lang=css& */ "./resources/js/components/ir/settings/policy/formPolicy.vue?vue&type=style&index=0&scope=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _formPolicy_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _formPolicy_vue_vue_type_template_id_16193912___WEBPACK_IMPORTED_MODULE_0__.render,
  _formPolicy_vue_vue_type_template_id_16193912___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/settings/policy/formPolicy.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/settings/policy/selectGroup.vue":
/*!********************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy/selectGroup.vue ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _selectGroup_vue_vue_type_template_id_18d0de17___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./selectGroup.vue?vue&type=template&id=18d0de17& */ "./resources/js/components/ir/settings/policy/selectGroup.vue?vue&type=template&id=18d0de17&");
/* harmony import */ var _selectGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./selectGroup.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/settings/policy/selectGroup.vue?vue&type=script&lang=js&");
/* harmony import */ var _selectGroup_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./selectGroup.vue?vue&type=style&index=0&lang=css& */ "./resources/js/components/ir/settings/policy/selectGroup.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _selectGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _selectGroup_vue_vue_type_template_id_18d0de17___WEBPACK_IMPORTED_MODULE_0__.render,
  _selectGroup_vue_vue_type_template_id_18d0de17___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/settings/policy/selectGroup.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/settings/policy/selectOptionPolicyType.vue":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy/selectOptionPolicyType.vue ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _selectOptionPolicyType_vue_vue_type_template_id_4951590e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./selectOptionPolicyType.vue?vue&type=template&id=4951590e& */ "./resources/js/components/ir/settings/policy/selectOptionPolicyType.vue?vue&type=template&id=4951590e&");
/* harmony import */ var _selectOptionPolicyType_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./selectOptionPolicyType.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/settings/policy/selectOptionPolicyType.vue?vue&type=script&lang=js&");
/* harmony import */ var _selectOptionPolicyType_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./selectOptionPolicyType.vue?vue&type=style&index=0&lang=css& */ "./resources/js/components/ir/settings/policy/selectOptionPolicyType.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _selectOptionPolicyType_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _selectOptionPolicyType_vue_vue_type_template_id_4951590e___WEBPACK_IMPORTED_MODULE_0__.render,
  _selectOptionPolicyType_vue_vue_type_template_id_4951590e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/settings/policy/selectOptionPolicyType.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/settings/policy/selectOptionPolicyTypeGl.vue":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy/selectOptionPolicyTypeGl.vue ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _selectOptionPolicyTypeGl_vue_vue_type_template_id_e666c484___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./selectOptionPolicyTypeGl.vue?vue&type=template&id=e666c484& */ "./resources/js/components/ir/settings/policy/selectOptionPolicyTypeGl.vue?vue&type=template&id=e666c484&");
/* harmony import */ var _selectOptionPolicyTypeGl_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./selectOptionPolicyTypeGl.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/settings/policy/selectOptionPolicyTypeGl.vue?vue&type=script&lang=js&");
/* harmony import */ var _selectOptionPolicyTypeGl_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./selectOptionPolicyTypeGl.vue?vue&type=style&index=0&lang=css& */ "./resources/js/components/ir/settings/policy/selectOptionPolicyTypeGl.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _selectOptionPolicyTypeGl_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _selectOptionPolicyTypeGl_vue_vue_type_template_id_e666c484___WEBPACK_IMPORTED_MODULE_0__.render,
  _selectOptionPolicyTypeGl_vue_vue_type_template_id_e666c484___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/settings/policy/selectOptionPolicyTypeGl.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/settings/policy/selectPolicyCategory.vue":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy/selectPolicyCategory.vue ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _selectPolicyCategory_vue_vue_type_template_id_21e70268___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./selectPolicyCategory.vue?vue&type=template&id=21e70268& */ "./resources/js/components/ir/settings/policy/selectPolicyCategory.vue?vue&type=template&id=21e70268&");
/* harmony import */ var _selectPolicyCategory_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./selectPolicyCategory.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/settings/policy/selectPolicyCategory.vue?vue&type=script&lang=js&");
/* harmony import */ var _selectPolicyCategory_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./selectPolicyCategory.vue?vue&type=style&index=0&lang=css& */ "./resources/js/components/ir/settings/policy/selectPolicyCategory.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _selectPolicyCategory_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _selectPolicyCategory_vue_vue_type_template_id_21e70268___WEBPACK_IMPORTED_MODULE_0__.render,
  _selectPolicyCategory_vue_vue_type_template_id_21e70268___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/settings/policy/selectPolicyCategory.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/settings/policy/selectPolicyType.vue":
/*!*************************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy/selectPolicyType.vue ***!
  \*************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _selectPolicyType_vue_vue_type_template_id_202d0fa4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./selectPolicyType.vue?vue&type=template&id=202d0fa4& */ "./resources/js/components/ir/settings/policy/selectPolicyType.vue?vue&type=template&id=202d0fa4&");
/* harmony import */ var _selectPolicyType_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./selectPolicyType.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/settings/policy/selectPolicyType.vue?vue&type=script&lang=js&");
/* harmony import */ var _selectPolicyType_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./selectPolicyType.vue?vue&type=style&index=0&lang=css& */ "./resources/js/components/ir/settings/policy/selectPolicyType.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _selectPolicyType_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _selectPolicyType_vue_vue_type_template_id_202d0fa4___WEBPACK_IMPORTED_MODULE_0__.render,
  _selectPolicyType_vue_vue_type_template_id_202d0fa4___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/settings/policy/selectPolicyType.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/settings/policy/create-policy.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy/create-policy.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_create_policy_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./create-policy.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/create-policy.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_create_policy_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/settings/policy/formPolicy.vue?vue&type=script&lang=js&":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy/formPolicy.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_formPolicy_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./formPolicy.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/formPolicy.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_formPolicy_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/settings/policy/selectGroup.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy/selectGroup.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_selectGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./selectGroup.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectGroup.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_selectGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/settings/policy/selectOptionPolicyType.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy/selectOptionPolicyType.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_selectOptionPolicyType_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./selectOptionPolicyType.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectOptionPolicyType.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_selectOptionPolicyType_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/settings/policy/selectOptionPolicyTypeGl.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy/selectOptionPolicyTypeGl.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_selectOptionPolicyTypeGl_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./selectOptionPolicyTypeGl.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectOptionPolicyTypeGl.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_selectOptionPolicyTypeGl_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/settings/policy/selectPolicyCategory.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy/selectPolicyCategory.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_selectPolicyCategory_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./selectPolicyCategory.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectPolicyCategory.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_selectPolicyCategory_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/settings/policy/selectPolicyType.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy/selectPolicyType.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_selectPolicyType_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./selectPolicyType.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectPolicyType.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_selectPolicyType_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/settings/policy/formPolicy.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!***************************************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy/formPolicy.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \***************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_formPolicy_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/style-loader/dist/cjs.js!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./formPolicy.vue?vue&type=style&index=0&scope=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/formPolicy.vue?vue&type=style&index=0&scope=true&lang=css&");


/***/ }),

/***/ "./resources/js/components/ir/settings/policy/selectGroup.vue?vue&type=style&index=0&lang=css&":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy/selectGroup.vue?vue&type=style&index=0&lang=css& ***!
  \*****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_selectGroup_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/style-loader/dist/cjs.js!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./selectGroup.vue?vue&type=style&index=0&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectGroup.vue?vue&type=style&index=0&lang=css&");


/***/ }),

/***/ "./resources/js/components/ir/settings/policy/selectOptionPolicyType.vue?vue&type=style&index=0&lang=css&":
/*!****************************************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy/selectOptionPolicyType.vue?vue&type=style&index=0&lang=css& ***!
  \****************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_selectOptionPolicyType_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/style-loader/dist/cjs.js!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./selectOptionPolicyType.vue?vue&type=style&index=0&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectOptionPolicyType.vue?vue&type=style&index=0&lang=css&");


/***/ }),

/***/ "./resources/js/components/ir/settings/policy/selectOptionPolicyTypeGl.vue?vue&type=style&index=0&lang=css&":
/*!******************************************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy/selectOptionPolicyTypeGl.vue?vue&type=style&index=0&lang=css& ***!
  \******************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_selectOptionPolicyTypeGl_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/style-loader/dist/cjs.js!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./selectOptionPolicyTypeGl.vue?vue&type=style&index=0&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectOptionPolicyTypeGl.vue?vue&type=style&index=0&lang=css&");


/***/ }),

/***/ "./resources/js/components/ir/settings/policy/selectPolicyCategory.vue?vue&type=style&index=0&lang=css&":
/*!**************************************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy/selectPolicyCategory.vue?vue&type=style&index=0&lang=css& ***!
  \**************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_selectPolicyCategory_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/style-loader/dist/cjs.js!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./selectPolicyCategory.vue?vue&type=style&index=0&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectPolicyCategory.vue?vue&type=style&index=0&lang=css&");


/***/ }),

/***/ "./resources/js/components/ir/settings/policy/selectPolicyType.vue?vue&type=style&index=0&lang=css&":
/*!**********************************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy/selectPolicyType.vue?vue&type=style&index=0&lang=css& ***!
  \**********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_selectPolicyType_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/style-loader/dist/cjs.js!../../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./selectPolicyType.vue?vue&type=style&index=0&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectPolicyType.vue?vue&type=style&index=0&lang=css&");


/***/ }),

/***/ "./resources/js/components/ir/settings/policy/create-policy.vue?vue&type=template&id=3227b357&":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy/create-policy.vue?vue&type=template&id=3227b357& ***!
  \*****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_create_policy_vue_vue_type_template_id_3227b357___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_create_policy_vue_vue_type_template_id_3227b357___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_create_policy_vue_vue_type_template_id_3227b357___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./create-policy.vue?vue&type=template&id=3227b357& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/create-policy.vue?vue&type=template&id=3227b357&");


/***/ }),

/***/ "./resources/js/components/ir/settings/policy/formPolicy.vue?vue&type=template&id=16193912&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy/formPolicy.vue?vue&type=template&id=16193912& ***!
  \**************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_formPolicy_vue_vue_type_template_id_16193912___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_formPolicy_vue_vue_type_template_id_16193912___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_formPolicy_vue_vue_type_template_id_16193912___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./formPolicy.vue?vue&type=template&id=16193912& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/formPolicy.vue?vue&type=template&id=16193912&");


/***/ }),

/***/ "./resources/js/components/ir/settings/policy/selectGroup.vue?vue&type=template&id=18d0de17&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy/selectGroup.vue?vue&type=template&id=18d0de17& ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_selectGroup_vue_vue_type_template_id_18d0de17___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_selectGroup_vue_vue_type_template_id_18d0de17___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_selectGroup_vue_vue_type_template_id_18d0de17___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./selectGroup.vue?vue&type=template&id=18d0de17& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectGroup.vue?vue&type=template&id=18d0de17&");


/***/ }),

/***/ "./resources/js/components/ir/settings/policy/selectOptionPolicyType.vue?vue&type=template&id=4951590e&":
/*!**************************************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy/selectOptionPolicyType.vue?vue&type=template&id=4951590e& ***!
  \**************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_selectOptionPolicyType_vue_vue_type_template_id_4951590e___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_selectOptionPolicyType_vue_vue_type_template_id_4951590e___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_selectOptionPolicyType_vue_vue_type_template_id_4951590e___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./selectOptionPolicyType.vue?vue&type=template&id=4951590e& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectOptionPolicyType.vue?vue&type=template&id=4951590e&");


/***/ }),

/***/ "./resources/js/components/ir/settings/policy/selectOptionPolicyTypeGl.vue?vue&type=template&id=e666c484&":
/*!****************************************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy/selectOptionPolicyTypeGl.vue?vue&type=template&id=e666c484& ***!
  \****************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_selectOptionPolicyTypeGl_vue_vue_type_template_id_e666c484___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_selectOptionPolicyTypeGl_vue_vue_type_template_id_e666c484___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_selectOptionPolicyTypeGl_vue_vue_type_template_id_e666c484___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./selectOptionPolicyTypeGl.vue?vue&type=template&id=e666c484& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectOptionPolicyTypeGl.vue?vue&type=template&id=e666c484&");


/***/ }),

/***/ "./resources/js/components/ir/settings/policy/selectPolicyCategory.vue?vue&type=template&id=21e70268&":
/*!************************************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy/selectPolicyCategory.vue?vue&type=template&id=21e70268& ***!
  \************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_selectPolicyCategory_vue_vue_type_template_id_21e70268___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_selectPolicyCategory_vue_vue_type_template_id_21e70268___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_selectPolicyCategory_vue_vue_type_template_id_21e70268___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./selectPolicyCategory.vue?vue&type=template&id=21e70268& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectPolicyCategory.vue?vue&type=template&id=21e70268&");


/***/ }),

/***/ "./resources/js/components/ir/settings/policy/selectPolicyType.vue?vue&type=template&id=202d0fa4&":
/*!********************************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy/selectPolicyType.vue?vue&type=template&id=202d0fa4& ***!
  \********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_selectPolicyType_vue_vue_type_template_id_202d0fa4___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_selectPolicyType_vue_vue_type_template_id_202d0fa4___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_selectPolicyType_vue_vue_type_template_id_202d0fa4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./selectPolicyType.vue?vue&type=template&id=202d0fa4& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectPolicyType.vue?vue&type=template&id=202d0fa4&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/create-policy.vue?vue&type=template&id=3227b357&":
/*!********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/create-policy.vue?vue&type=template&id=3227b357& ***!
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
    [
      _c("form-policy", {
        attrs: { policy: _vm.policy, "btn-trans": _vm.btnTrans }
      })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/formPolicy.vue?vue&type=template&id=16193912&":
/*!*****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/formPolicy.vue?vue&type=template&id=16193912& ***!
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
    { staticClass: "mt-3" },
    [
      _c(
        "el-form",
        { ref: "save_policy", attrs: { model: _vm.policy, rules: _vm.rules } },
        [
          _c("div", { staticClass: "row" }, [
            _c(
              "div",
              {
                staticClass: "col-xl-7 col-md-7 col-sm-12 col-xs-12 offset-md-2"
              },
              [
                _c("div", { staticClass: "form-group row" }, [
                  _c(
                    "label",
                    {
                      staticClass:
                        "col-lg-5 col-md-6 col-sm-12 col-xs-12 col-form-label lable_align"
                    },
                    [
                      _c("strong", [
                        _vm._v("กรมธรรม์ชุดที่ (Policy No) "),
                        _c("span", { staticClass: "text-danger" }, [
                          _vm._v(" * ")
                        ])
                      ])
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass:
                        "col-lg-7 col-md-6 col-sm-12 col-xs-12 align-item-center"
                    },
                    [
                      _c(
                        "el-form-item",
                        {
                          staticClass: "el-form-item-irm0002",
                          attrs: { prop: "policy_set_number" }
                        },
                        [
                          _c("el-input", {
                            attrs: { disabled: true },
                            model: {
                              value: _vm.policy.policy_set_number,
                              callback: function($$v) {
                                _vm.$set(_vm.policy, "policy_set_number", $$v)
                              },
                              expression: "policy.policy_set_number"
                            }
                          })
                        ],
                        1
                      )
                    ],
                    1
                  )
                ])
              ]
            ),
            _vm._v(" "),
            _c("div", { staticClass: "col-xl-7 col-md-7 offset-md-2" }, [
              _c("div", { staticClass: "form-group row" }, [
                _c(
                  "label",
                  {
                    staticClass: "col-lg-5 col-md-6 col-form-label lable_align"
                  },
                  [
                    _c("strong", [
                      _vm._v("คำอธิบาย (Description) "),
                      _c("span", { staticClass: "text-danger" }, [
                        _vm._v(" * ")
                      ])
                    ])
                  ]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-lg-7 col-md-6" },
                  [
                    _c(
                      "el-form-item",
                      {
                        staticClass: "el-form-item-irm0002",
                        attrs: { prop: "policy_set_description" }
                      },
                      [
                        _c("el-input", {
                          model: {
                            value: _vm.policy.policy_set_description,
                            callback: function($$v) {
                              _vm.$set(
                                _vm.policy,
                                "policy_set_description",
                                $$v
                              )
                            },
                            expression: "policy.policy_set_description"
                          }
                        })
                      ],
                      1
                    )
                  ],
                  1
                )
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-xl-7 col-md-7 offset-md-2" }, [
              _c("div", { staticClass: "form-group row" }, [
                _c(
                  "label",
                  {
                    staticClass: "col-lg-5 col-md-6 col-form-label lable_align"
                  },
                  [
                    _c("strong", [
                      _vm._v("แบบของการประกัน (Policy Type) "),
                      _c("span", { staticClass: "text-danger" }, [
                        _vm._v(" * ")
                      ])
                    ])
                  ]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-lg-7 col-md-6" },
                  [
                    _c(
                      "el-form-item",
                      {
                        staticClass: "el-form-item-irm0002",
                        attrs: { prop: "policy_type_code" }
                      },
                      [
                        _c(
                          "el-select",
                          {
                            staticClass: "w-100",
                            attrs: { placeholder: "เลือก", clearable: true },
                            model: {
                              value: _vm.policy.policy_type_code,
                              callback: function($$v) {
                                _vm.$set(_vm.policy, "policy_type_code", $$v)
                              },
                              expression: "policy.policy_type_code"
                            }
                          },
                          _vm._l(_vm.policyTypeCodes, function(data, index) {
                            return _c("el-option", {
                              key: index,
                              attrs: {
                                label: data.meaning,
                                value: data.policy_type_code
                              }
                            })
                          }),
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
            _c("div", { staticClass: "col-xl-7 col-md-7 offset-md-2" }, [
              _c("div", { staticClass: "form-group row" }, [
                _c(
                  "label",
                  {
                    staticClass: "col-lg-5 col-md-6 col-form-label lable_align"
                  },
                  [
                    _c("strong", [
                      _vm._v("อายุกรมธรรม์ "),
                      _c("span", { staticClass: "text-danger" }, [
                        _vm._v(" * ")
                      ])
                    ])
                  ]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-lg-4 col-md-5 col-sm-11 col-xs-11" },
                  [
                    _c(
                      "div",
                      { staticClass: "input-group" },
                      [
                        _c(
                          "el-form-item",
                          {
                            staticClass: "w-100 el-form-item-irm0002",
                            attrs: { prop: "policy_age" }
                          },
                          [
                            _c("el-input-number", {
                              staticClass: "w-100",
                              attrs: { controls: false },
                              on: { input: _vm.onlyNumeric },
                              model: {
                                value: _vm.policy.policy_age,
                                callback: function($$v) {
                                  _vm.$set(_vm.policy, "policy_age", $$v)
                                },
                                expression: "policy.policy_age"
                              }
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
                  "label",
                  {
                    staticClass:
                      "col-lg-1 col-md-1 col-sm-1 col-xs-1 col-form-label"
                  },
                  [_c("strong", [_vm._v("ปี")])]
                )
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-xl-7 col-md-7 offset-md-2" }, [
              _c("div", { staticClass: "form-group row" }, [
                _c(
                  "label",
                  {
                    staticClass: "col-lg-5 col-md-6 col-form-label lable_align"
                  },
                  [
                    _c("strong", [
                      _vm._v("ประเภทค่าใช้จ่าย (AP) "),
                      _c("span", { staticClass: "text-danger" }, [
                        _vm._v(" * ")
                      ])
                    ])
                  ]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-lg-7 col-md-6" },
                  [
                    _c(
                      "el-form-item",
                      {
                        staticClass: "el-form-item-irm0002",
                        attrs: { prop: "type_cost" }
                      },
                      [
                        _c("type-cost", {
                          attrs: {
                            valueTypeCost: _vm.policy.id_account,
                            id_account: _vm.policy.id_account
                          },
                          on: { typeCode: _vm.receivedTypeCode },
                          model: {
                            value: _vm.policy.type_cost,
                            callback: function($$v) {
                              _vm.$set(_vm.policy, "type_cost", $$v)
                            },
                            expression: "policy.type_cost"
                          }
                        })
                      ],
                      1
                    )
                  ],
                  1
                )
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-xl-7 col-md-7 offset-md-2" }, [
              _c("div", { staticClass: "form-group row" }, [
                _c(
                  "label",
                  {
                    staticClass: "col-lg-5 col-md-6 col-form-label lable_align"
                  },
                  [
                    _c("strong", [
                      _vm._v("รหัสบัญชีจ่ายล่วงหน้า "),
                      _c("span", { staticClass: "text-danger" }, [
                        _vm._v(" * ")
                      ])
                    ])
                  ]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-lg-7 col-md-6" },
                  [
                    _c(
                      "el-form-item",
                      {
                        staticClass: "el-form-item-irm0002",
                        attrs: { prop: "account_combine" }
                      },
                      [
                        _c("el-input", {
                          attrs: { disabled: true },
                          model: {
                            value: _vm.policy.account_combine,
                            callback: function($$v) {
                              _vm.$set(_vm.policy, "account_combine", $$v)
                            },
                            expression: "policy.account_combine"
                          }
                        })
                      ],
                      1
                    )
                  ],
                  1
                )
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-xl-7 col-md-7 offset-md-2" }, [
              _c("div", { staticClass: "form-group row" }, [
                _c(
                  "label",
                  {
                    staticClass: "col-lg-5 col-md-6 col-form-label lable_align"
                  },
                  [
                    _c("strong", [
                      _vm._v("ประเภทค่าใช้จ่าย (GL) "),
                      _c("span", { staticClass: "text-danger" }, [
                        _vm._v(" * ")
                      ])
                    ])
                  ]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-lg-7 col-md-6" },
                  [
                    _c(
                      "el-form-item",
                      {
                        staticClass: "el-form-item-irm0002",
                        attrs: { prop: "gl_expense_account_id" }
                      },
                      [
                        _c("type-cost-gl", {
                          attrs: {
                            valueTypeCost: _vm.policy.id_account_gl,
                            id_account: _vm.policy.id_account_gl
                          },
                          on: { typeCode: _vm.receivedTypeCodeGL },
                          model: {
                            value: _vm.policy.gl_expense_account_id,
                            callback: function($$v) {
                              _vm.$set(_vm.policy, "gl_expense_account_id", $$v)
                            },
                            expression: "policy.gl_expense_account_id"
                          }
                        })
                      ],
                      1
                    )
                  ],
                  1
                )
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-xl-7 col-md-7 offset-md-2" }, [
              _c("div", { staticClass: "form-group row" }, [
                _c(
                  "label",
                  {
                    staticClass: "col-lg-5 col-md-6 col-form-label lable_align"
                  },
                  [
                    _c("strong", [
                      _vm._v("รหัสบัญชีตัดค่าใช้จ่ายล่วงหน้า "),
                      _c("span", { staticClass: "text-danger" }, [
                        _vm._v(" * ")
                      ])
                    ])
                  ]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-lg-7 col-md-6" },
                  [
                    _c(
                      "el-form-item",
                      {
                        staticClass: "el-form-item-irm0002",
                        attrs: { prop: "account_combine_gl" }
                      },
                      [
                        _c("el-input", {
                          attrs: { disabled: true },
                          model: {
                            value: _vm.policy.account_combine_gl,
                            callback: function($$v) {
                              _vm.$set(_vm.policy, "account_combine_gl", $$v)
                            },
                            expression: "policy.account_combine_gl"
                          }
                        })
                      ],
                      1
                    )
                  ],
                  1
                )
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-xl-7 col-md-7 offset-md-2" }, [
              _c("div", { staticClass: "form-group row" }, [
                _c("label", {
                  staticClass: "col-lg-5 col-md-6 col-form-label lable_align"
                }),
                _vm._v(" "),
                _c("div", { staticClass: "col-lg-7 col-md-6" }, [
                  _c(
                    "div",
                    {
                      staticClass: "form-check mt-0 d-flex align-items-center"
                    },
                    [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.policy.include_tax_flag,
                            expression: "policy.include_tax_flag"
                          }
                        ],
                        staticClass: "form-check-input mt-0",
                        attrs: {
                          type: "checkbox",
                          id: "include_tax_flag",
                          name: "include_tax_flag"
                        },
                        domProps: {
                          checked: Array.isArray(_vm.policy.include_tax_flag)
                            ? _vm._i(_vm.policy.include_tax_flag, null) > -1
                            : _vm.policy.include_tax_flag
                        },
                        on: {
                          change: function($event) {
                            var $$a = _vm.policy.include_tax_flag,
                              $$el = $event.target,
                              $$c = $$el.checked ? true : false
                            if (Array.isArray($$a)) {
                              var $$v = null,
                                $$i = _vm._i($$a, $$v)
                              if ($$el.checked) {
                                $$i < 0 &&
                                  _vm.$set(
                                    _vm.policy,
                                    "include_tax_flag",
                                    $$a.concat([$$v])
                                  )
                              } else {
                                $$i > -1 &&
                                  _vm.$set(
                                    _vm.policy,
                                    "include_tax_flag",
                                    $$a.slice(0, $$i).concat($$a.slice($$i + 1))
                                  )
                              }
                            } else {
                              _vm.$set(_vm.policy, "include_tax_flag", $$c)
                            }
                          }
                        }
                      }),
                      _vm._v(" "),
                      _c(
                        "label",
                        {
                          staticClass: "form-check-label",
                          attrs: {
                            name: "active_flag",
                            for: "include_tax_flag"
                          }
                        },
                        [
                          _vm._v(
                            "\n                      รวมภาษีมูลค่าเพิ่ม\n                  "
                          )
                        ]
                      )
                    ]
                  )
                ])
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-xl-7 col-md-7 offset-md-2" }, [
              _c(
                "div",
                {
                  staticClass: "form-group row",
                  attrs: { id: "policy-type-code" }
                },
                [
                  _c(
                    "label",
                    {
                      staticClass:
                        "col-lg-5 col-md-6 col-form-label lable_align"
                    },
                    [
                      _c("strong", [
                        _vm._v("กลุ่ม "),
                        _c("span", { staticClass: "text-danger" }, [
                          _vm._v(" * ")
                        ])
                      ])
                    ]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-lg-7 col-md-6" }, [
                    _c(
                      "div",
                      { staticClass: "mb-3" },
                      [
                        _c(
                          "el-form-item",
                          {
                            staticClass: "el-form-item-irm0002",
                            attrs: { prop: "group_code" }
                          },
                          [
                            _c("group-code", {
                              attrs: {
                                required: "",
                                valueTypeCost: _vm.policy.group_code
                              },
                              on: { group: _vm.receivedGroupCode },
                              model: {
                                value: _vm.policy.group_code,
                                callback: function($$v) {
                                  _vm.$set(_vm.policy, "group_code", $$v)
                                },
                                expression: "policy.group_code"
                              }
                            })
                          ],
                          1
                        )
                      ],
                      1
                    )
                  ])
                ]
              )
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-xl-7 col-md-7 offset-md-2" }, [
              _c(
                "div",
                {
                  staticClass: "form-group row",
                  attrs: { id: "policy-type-code" }
                },
                [
                  _c(
                    "label",
                    {
                      staticClass:
                        "col-lg-5 col-md-6 col-form-label lable_align"
                    },
                    [
                      _c("strong", [
                        _vm._v("ประเภทกรมธรรม์ "),
                        _c("span", { staticClass: "text-danger" }, [
                          _vm._v(" * ")
                        ])
                      ])
                    ]
                  ),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-lg-7 col-md-6" }, [
                    _c(
                      "div",
                      { staticClass: "mb-3" },
                      [
                        _c(
                          "el-form-item",
                          {
                            staticClass: "el-form-item-irm0002",
                            attrs: { prop: "policy_category_code" }
                          },
                          [
                            _c("policy-category", {
                              attrs: {
                                required: "",
                                valueTypeCost: _vm.policy.policy_category_code
                              },
                              on: { category: _vm.receivedPolicyCategory },
                              model: {
                                value: _vm.policy.policy_category_code,
                                callback: function($$v) {
                                  _vm.$set(
                                    _vm.policy,
                                    "policy_category_code",
                                    $$v
                                  )
                                },
                                expression: "policy.policy_category_code"
                              }
                            })
                          ],
                          1
                        )
                      ],
                      1
                    )
                  ])
                ]
              )
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-xl-7 col-md-7 offset-md-2" }, [
              _c("div", { staticClass: "form-group row" }, [
                _c("label", {
                  staticClass: "col-lg-5 col-md-6 col-form-label lable_align"
                }),
                _vm._v(" "),
                _c("div", { staticClass: "col-lg-7 col-md-6" }, [
                  _c(
                    "div",
                    { staticClass: "form-check align-items-center d-flex" },
                    [
                      _vm.policy.mode == "create"
                        ? _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.policy.active_flag,
                                expression: "policy.active_flag"
                              }
                            ],
                            staticClass: "form-check-input mt-0",
                            attrs: {
                              type: "checkbox",
                              id: "active_flag",
                              name: "active_flag"
                            },
                            domProps: {
                              checked: Array.isArray(_vm.policy.active_flag)
                                ? _vm._i(_vm.policy.active_flag, null) > -1
                                : _vm.policy.active_flag
                            },
                            on: {
                              change: function($event) {
                                var $$a = _vm.policy.active_flag,
                                  $$el = $event.target,
                                  $$c = $$el.checked ? true : false
                                if (Array.isArray($$a)) {
                                  var $$v = null,
                                    $$i = _vm._i($$a, $$v)
                                  if ($$el.checked) {
                                    $$i < 0 &&
                                      _vm.$set(
                                        _vm.policy,
                                        "active_flag",
                                        $$a.concat([$$v])
                                      )
                                  } else {
                                    $$i > -1 &&
                                      _vm.$set(
                                        _vm.policy,
                                        "active_flag",
                                        $$a
                                          .slice(0, $$i)
                                          .concat($$a.slice($$i + 1))
                                      )
                                  }
                                } else {
                                  _vm.$set(_vm.policy, "active_flag", $$c)
                                }
                              }
                            }
                          })
                        : _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.policy.active_flag,
                                expression: "policy.active_flag"
                              }
                            ],
                            staticClass:
                              "form-check-input mt-0 form_company_active",
                            attrs: {
                              type: "checkbox",
                              id: "active_flag",
                              name: "active_flag"
                            },
                            domProps: {
                              checked: Array.isArray(_vm.policy.active_flag)
                                ? _vm._i(_vm.policy.active_flag, null) > -1
                                : _vm.policy.active_flag
                            },
                            on: {
                              change: [
                                function($event) {
                                  var $$a = _vm.policy.active_flag,
                                    $$el = $event.target,
                                    $$c = $$el.checked ? true : false
                                  if (Array.isArray($$a)) {
                                    var $$v = null,
                                      $$i = _vm._i($$a, $$v)
                                    if ($$el.checked) {
                                      $$i < 0 &&
                                        _vm.$set(
                                          _vm.policy,
                                          "active_flag",
                                          $$a.concat([$$v])
                                        )
                                    } else {
                                      $$i > -1 &&
                                        _vm.$set(
                                          _vm.policy,
                                          "active_flag",
                                          $$a
                                            .slice(0, $$i)
                                            .concat($$a.slice($$i + 1))
                                        )
                                    }
                                  } else {
                                    _vm.$set(_vm.policy, "active_flag", $$c)
                                  }
                                },
                                function($event) {
                                  return _vm.changeActiveFlag()
                                }
                              ]
                            }
                          }),
                      _vm._v(" "),
                      _c(
                        "label",
                        {
                          staticClass: "form-check-label",
                          attrs: { for: "active_flag" }
                        },
                        [
                          _vm._v(
                            "\n                    Active\n                  "
                          )
                        ]
                      )
                    ]
                  )
                ])
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-12 mt-3" }, [
              _c("div", { staticClass: "row clearfix m-t-lg text-right" }, [
                _c("div", { staticClass: "col-sm-12" }, [
                  _c(
                    "button",
                    {
                      class: _vm.btnTrans.save.class + " btn-lg tw-w-25",
                      attrs: { type: "button" },
                      on: {
                        click: function($event) {
                          $event.preventDefault()
                          return _vm.save()
                        }
                      }
                    },
                    [
                      _c("i", { class: _vm.btnTrans.save.icon }),
                      _vm._v(
                        "\n              " +
                          _vm._s(_vm.btnTrans.save.text) +
                          "\n            "
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "button",
                    {
                      class: _vm.btnTrans.cancel.class + " btn-lg tw-w-25",
                      attrs: { type: "button" },
                      on: {
                        click: function($event) {
                          $event.preventDefault()
                          return _vm.clickCancel()
                        }
                      }
                    },
                    [
                      _c("i", { class: _vm.btnTrans.cancel.icon }),
                      _vm._v(
                        "\n              " +
                          _vm._s(_vm.btnTrans.cancel.text) +
                          "\n            "
                      )
                    ]
                  )
                ])
              ])
            ])
          ])
        ]
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectGroup.vue?vue&type=template&id=18d0de17&":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectGroup.vue?vue&type=template&id=18d0de17& ***!
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
      _c("input", {
        attrs: { type: "hidden", name: "group_code", autocomplete: "off" },
        domProps: { value: _vm.group_code }
      }),
      _vm._v(" "),
      _c(
        "el-select",
        {
          attrs: {
            filterable: "",
            remote: "",
            "remote-method": _vm.remoteMethod,
            loading: _vm.loading,
            clearable: true,
            placeholder: "กลุ่ม"
          },
          on: { change: _vm.change },
          model: {
            value: _vm.group_code,
            callback: function($$v) {
              _vm.group_code = $$v
            },
            expression: "group_code"
          }
        },
        _vm._l(_vm.groups, function(data, index) {
          return _c("el-option", {
            key: index,
            attrs: { label: "" + data.meaning, value: data.group_code }
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectOptionPolicyType.vue?vue&type=template&id=4951590e&":
/*!*****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectOptionPolicyType.vue?vue&type=template&id=4951590e& ***!
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
    { staticClass: "el_select" },
    [
      _c("input", {
        attrs: { type: "hidden", name: "type_cost", autocomplete: "off" },
        domProps: { value: _vm.type_cost }
      }),
      _vm._v(" "),
      _c(
        "el-select",
        {
          attrs: {
            filterable: "",
            remote: "",
            "remote-method": _vm.remoteMethod,
            loading: _vm.loading,
            clearable: true,
            placeholder: "ประเภทค่าใช้จ่าย"
          },
          on: { change: _vm.change },
          model: {
            value: _vm.type_cost,
            callback: function($$v) {
              _vm.type_cost = $$v
            },
            expression: "type_cost"
          }
        },
        _vm._l(_vm.typeCosts, function(data, index) {
          return _c("el-option", {
            key: index,
            attrs: {
              label: data.account_code + ": " + data.description,
              value: data.account_code
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectOptionPolicyTypeGl.vue?vue&type=template&id=e666c484&":
/*!*******************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectOptionPolicyTypeGl.vue?vue&type=template&id=e666c484& ***!
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
  return _c(
    "div",
    { staticClass: "el_select" },
    [
      _c("input", {
        attrs: { type: "hidden", name: "type_cost", autocomplete: "off" },
        domProps: { value: _vm.type_cost }
      }),
      _vm._v(" "),
      _c(
        "el-select",
        {
          attrs: {
            filterable: "",
            remote: "",
            "remote-method": _vm.remoteMethod,
            loading: _vm.loading,
            clearable: true,
            placeholder: "ประเภทค่าใช้จ่าย"
          },
          on: { change: _vm.change },
          model: {
            value: _vm.type_cost,
            callback: function($$v) {
              _vm.type_cost = $$v
            },
            expression: "type_cost"
          }
        },
        _vm._l(_vm.typeCosts, function(data, index) {
          return _c("el-option", {
            key: index,
            attrs: {
              label: data.account_code + ": " + data.description,
              value: data.account_code
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectPolicyCategory.vue?vue&type=template&id=21e70268&":
/*!***************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectPolicyCategory.vue?vue&type=template&id=21e70268& ***!
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
    { staticClass: "el_select" },
    [
      _c("input", {
        attrs: { type: "hidden", name: "policy_lookup", autocomplete: "off" },
        domProps: { value: _vm.policy_lookup }
      }),
      _vm._v(" "),
      _c(
        "el-select",
        {
          attrs: {
            filterable: "",
            remote: "",
            "remote-method": _vm.remoteMethod,
            loading: _vm.loading,
            clearable: true,
            placeholder: "ประเภทกรมธรรม์"
          },
          on: { change: _vm.change },
          model: {
            value: _vm.policy_lookup,
            callback: function($$v) {
              _vm.policy_lookup = $$v
            },
            expression: "policy_lookup"
          }
        },
        _vm._l(_vm.categories, function(data, index) {
          return _c("el-option", {
            key: index,
            attrs: { label: "" + data.description, value: data.lookup_code }
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectPolicyType.vue?vue&type=template&id=202d0fa4&":
/*!***********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy/selectPolicyType.vue?vue&type=template&id=202d0fa4& ***!
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
    { staticClass: "el_select" },
    [
      _c("input", {
        attrs: {
          type: "hidden",
          name: "policy_type_code",
          autocomplete: "off"
        },
        domProps: { value: _vm.policy_type_code }
      }),
      _vm._v(" "),
      _c(
        "el-select",
        {
          attrs: {
            filterable: "",
            remote: "",
            "remote-method": _vm.remoteMethod,
            loading: _vm.loading,
            clearable: true,
            placeholder: "แบบของการประกัน",
            "validate-event": true,
            required: ""
          },
          on: { change: _vm.updateDropdowns },
          model: {
            value: _vm.policy_type_code,
            callback: function($$v) {
              _vm.policy_type_code = $$v
            },
            expression: "policy_type_code"
          }
        },
        _vm._l(_vm.policy, function(data, index) {
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



/***/ })

}]);