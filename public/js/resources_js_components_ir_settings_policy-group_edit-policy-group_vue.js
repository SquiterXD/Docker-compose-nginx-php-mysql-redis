(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ir_settings_policy-group_edit-policy-group_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy-group/edit-policy-group.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy-group/edit-policy-group.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _formPolicyGroup__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./formPolicyGroup */ "./resources/js/components/ir/settings/policy-group/formPolicyGroup.vue");
/* harmony import */ var _scripts__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../scripts */ "./resources/js/components/ir/scripts.js");
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
  props: ['btnTrans'],
  data: function data() {
    return {
      policy: {
        mode: 'edit'
      },
      vars: _scripts__WEBPACK_IMPORTED_MODULE_1__.vars,
      funcs: _scripts__WEBPACK_IMPORTED_MODULE_1__.funcs
    };
  },
  components: {
    FormPolicyGroup: _formPolicyGroup__WEBPACK_IMPORTED_MODULE_0__.default
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy-group/formPolicyGroup.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy-group/formPolicyGroup.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _components_currencyInput__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../components/currencyInput */ "./resources/js/components/ir/components/currencyInput.vue");
/* harmony import */ var _components_calendar_dateInput__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../components/calendar/dateInput */ "./resources/js/components/ir/components/calendar/dateInput.vue");
/* harmony import */ var _lovPolicy__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./lovPolicy */ "./resources/js/components/ir/settings/policy-group/lovPolicy.vue");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_3__);
function _createForOfIteratorHelper(o, allowArrayLike) { var it; if (typeof Symbol === "undefined" || o[Symbol.iterator] == null) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = o[Symbol.iterator](); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

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




/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'ir-form-policy-group',
  data: function data() {
    return {
      data: {
        policy_set: []
      },
      policyGroup: [],
      group_code: '',
      group_description: '',
      value: '',
      loading: false,
      policyGroup_id: '',
      dataTable: {
        policy_list: []
      },
      group_header_id: null,
      pickerOptions: {
        disabledDate: function disabledDate(time) {
          return time.getTime() > Date.now();
        },
        shortcuts: [{
          text: 'Today',
          onClick: function onClick(picker) {
            picker.$emit('pick', new Date());
          }
        }, {
          text: 'Yesterday',
          onClick: function onClick(picker) {
            var date = new Date();
            date.setTime(date.getTime() - 3600 * 1000 * 24);
            picker.$emit('pick', date);
          }
        }, {
          text: 'A week ago',
          onClick: function onClick(picker) {
            var date = new Date();
            date.setTime(date.getTime() - 3600 * 1000 * 24 * 7);
            picker.$emit('pick', date);
          }
        }]
      },
      dialogVisible: false,
      detail: {
        detailPolicyList: []
      },
      policies: [],
      companies: [],
      showTable: false,
      modalId: 0,
      rules: {
        policy_set_header_id: [{
          required: true,
          message: 'กรุณาระบุกรมธรรม์',
          trigger: 'change'
        }],
        company_code: [{
          required: true,
          message: 'กรุณาระบุบริษัทประกัน',
          trigger: 'change'
        }],
        company_percent: [{
          required: true,
          message: 'กรุณาระบุสัดส่วน',
          trigger: 'change'
        }],
        premium_rate: [{
          required: true,
          message: 'กรุณาระบุอัตราเบี้ย',
          trigger: 'change'
        }],
        prepaid_insurance: [{
          required: true,
          message: 'กรุณาระบุเบี้ยประกันจ่ายล่วงหน้า',
          trigger: 'change'
        }],
        year: [{
          required: true,
          message: 'กรุณาระบุปี',
          trigger: 'change'
        }]
      },
      modalIndexActive: 0,
      dateFormat: 'DD/MM/YYYY',
      valid: true,
      errors: [],
      modal_open: false
    };
  },
  props: ['policy', 'policyGroupHeader', 'headerLovUrl', 'groupLineUrl', 'vars', 'setYearCE', 'btnTrans'],
  methods: {
    getPolicyGroupDetail: function getPolicyGroupDetail() {
      var _this2 = this;

      var id = window.location.href.split("/").pop();
      axios.get("/ir/ajax/policy-group/".concat(id)).then(function (_ref) {
        var response = _ref.data;
        _this2.data.policy_set = [].concat(_toConsumableArray(_this2.data.policy_set), _toConsumableArray(response.data));
        _this2.group_code = response.data.length > 0 ? response.data[0].group_code : '';
        _this2.group_description = response.data.length > 0 ? response.data[0].group_description : '';
        _this2.group_header_id = id;
        _this2.dataTable.policy_list = _toConsumableArray(response.rows); // check has lists policy 04012022

        if (_this2.data.policy_set[0].policy_set_header_id == null || _this2.data.policy_set[0].policy_set_header_id == '') {
          _this2.valid = false;
        }
      })["catch"](function (error) {
        swal('Error', error, 'error');
      });
    },
    addRow: function addRow() {
      var _this3 = this;

      this.data.policy_set.push({
        policy_set_header_id: '',
        policy_set_description: '',
        group_header_id: '',
        flg: 'add'
      });
      this.$nextTick(function () {
        var el = _this3.$el.getElementsByClassName('endTable')[0];

        if (el) {
          el.scrollIntoView();
        }
      });
    },
    clickRemove: function clickRemove(index, policy) {
      var _this4 = this;

      if (policy.group_header_id) {
        var params = {
          group_set_id: policy.group_set_id,
          group_header_id: policy.group_header_id
        };
        this.loading = true;
        axios["delete"]("/ir/ajax/policy-group/group-sets", {
          params: params
        }).then(function (_ref2) {
          var response = _ref2.data;
          _this4.loading = false;

          _this4.data.policy_set.splice(index, 1);

          swal({
            title: "Success",
            text: 'บันทึกสำเร็จ',
            // timer: 3000,
            type: "success" // showCancelButton: false,
            // showConfirmButton: false

          });
        })["catch"](function (error) {
          if (error.response.data.status === 400) {
            swal({
              title: "Warning",
              text: error.response.data.message,
              timer: 3000,
              type: "warning"
            });
          } else {
            swal({
              title: "Error",
              text: error.response.data.message,
              timer: 3000,
              type: "error"
            });
          }
        });
      } else {
        this.data.policy_set.splice(index, 1);
      }
    },
    getPolicyGroupLov: function getPolicyGroupLov(params) {
      var _this5 = this;

      this.loading = true;
      axios.get("".concat(this.headerLovUrl), {
        params: params
      }).then(function (_ref3) {
        var response = _ref3.data;
        _this5.loading = false;
        _this5.policyGroup = response.data;
      });
    },
    remoteMethod: function remoteMethod(query) {
      if (query !== "") {
        if (parseInt(query)) {
          this.getPolicyGroupLov({
            group_header_id: query
          });
        } else {
          this.getPolicyGroupLov({
            group_header_id: query
          });
        }
      } else {
        this.policyGroup = [];
      }
    },
    handleAssign: function handleAssign() {
      var _this6 = this;

      this.$refs.assign.validate(function (valid) {
        if (valid) {
          _this6.showTable = true;
        } else {
          return false;
        }
      });
    },
    handleCancel: function handleCancel() {
      window.location.replace("/ir/settings/policy-group");
    },
    addDetailPolicyList: function addDetailPolicyList() {
      this.detail.detailPolicyList.push({
        company_code: '',
        company_percent: '',
        user_policy_number: '',
        comments: '',
        flg: 'add',
        default_diff_amount: false
      });
    },
    clickRemoveDetailFlgAdd: function clickRemoveDetailFlgAdd(index) {
      this.detail.detailPolicyList.splice(index, 1);
    },
    getPolicyLov: function getPolicyLov(params) {
      var _this7 = this;

      this.loading = true;
      axios.get("/ir/ajax/lov/policy-set-header", {
        params: params
      }).then(function (_ref4) {
        var response = _ref4.data;
        _this7.loading = false;
        _this7.policies = response.data;
      });
    },
    getCompanies: function getCompanies(params) {
      var _this8 = this;

      axios.get("/ir/ajax/lov/companies", {
        params: params
      }).then(function (_ref5) {
        var response = _ref5.data;
        _this8.loading = false;
        _this8.companies = response.data;
      });
    },
    focusPolicies: function focusPolicies(value) {
      this.getPolicyLov({
        policy_set_header_id: ''
      });
    },
    savePolicyGroup: function savePolicyGroup() {
      var _this9 = this;

      this.$refs.save_line.validate(function (valid) {
        var checkOverlap = function checkOverlap(overlap) {
          return overlap.isOverlap === true;
        };

        var checkNotfound = function checkNotfound(data) {
          return Object.keys(data).length === 0;
        };

        if (_this9.dataTable.policy_list.find(function (policy) {
          return policy.group_dists_rows.some(checkNotfound);
        })) {
          swal({
            title: "Warning",
            text: 'กรุณาเพิ่มรายละเอียดบริษัทประกัน!',
            // timer: 3000,
            type: "warning"
          });
        } else {
          var rows = [];

          _this9.dataTable.policy_list.map(function (policy) {
            var data = _objectSpread(_objectSpread({}, policy), {}, {
              group_line_id: policy.group_line_id === undefined ? '' : policy.group_line_id,
              start_date: policy.start_date,
              end_date: policy.end_date
            });

            rows.push(data);
          });

          var params = {
            data: {
              group_code: _this9.group_code,
              group_description: _this9.group_description,
              active_flag: _this9.policy.active_flag || _this9.policy.active_flag === 'Y' ? _this9.policy.active_flag = 'Y' : _this9.policy.active_flag = 'N',
              program_code: 'IRM0003',
              policy_sets_rows: _this9.data.policy_set.map(function (policy) {
                return {
                  policy_set_header_id: policy.policy_set_header_id,
                  group_set_id: policy.group_set_id
                };
              }),
              policy_lines_rows: rows,
              group_header_id: _this9.group_header_id
            }
          };

          if (_this9.dataTable.policy_list.length > 0) {
            _this9.$refs.save_line.validate(function (valid) {
              if (valid) {
                if (_this9.reqDate()) {
                  axios.post("/ir/ajax/policy-group/save", params).then(function (_ref6) {
                    var response = _ref6.data;
                    _this9.loading = false; // swal({
                    //   title: "Success",
                    //   text: 'บันทึกสำเร็จ',
                    //   timer: 3000,
                    //   type: "success",
                    //   showCancelButton: false,
                    //   showConfirmButton: false
                    // })
                    // setTimeout(() => {
                    //   window.location.href = '/ir/settings/policy-group'
                    // }, 3000);

                    swal({
                      title: "Success",
                      text: 'บันทึกสำเร็จ',
                      type: "success",
                      showCancelButton: false,
                      showConfirmButton: true
                    }, function (isConfirm) {
                      window.location.href = '/ir/settings/policy-group';
                    });
                  })["catch"](function (error) {
                    if (error.response.data.status === 400) {
                      swal({
                        title: "Warning",
                        text: error.response.data.message,
                        timer: 3000,
                        type: "warning"
                      });
                    } else {
                      swal({
                        title: "Error",
                        text: error.response.data.message,
                        timer: 3000,
                        type: "error"
                      });
                    }
                  });
                }
              }
            });
          } else {
            axios.post("/ir/ajax/policy-group/save", params).then(function (_ref7) {
              var response = _ref7.data;
              _this9.loading = false; // swal({
              //   title: "Success",
              //   text: 'บันทึกสำเร็จ',
              //   timer: 3000,
              //   type: "success",
              //   showCancelButton: false,
              //   showConfirmButton: false
              // })
              // setTimeout(() => {
              //   window.location.href = '/ir/settings/policy-group'
              // }, 3000);

              swal({
                title: "Success",
                text: 'บันทึกสำเร็จ',
                type: "success",
                showCancelButton: false,
                showConfirmButton: true
              }, function (isConfirm) {
                window.location.href = '/ir/settings/policy-group';
              });
            })["catch"](function (error) {
              if (error.response.data.status === 400) {
                swal({
                  title: "Warning",
                  text: error.response.data.message,
                  timer: 3000,
                  type: "warning"
                });
              } else {
                swal({
                  title: "Error",
                  text: error.response.data.message,
                  timer: 3000,
                  type: "error"
                });
              }
            });
          }
        }
      });
    },
    clickModal: function clickModal(index, detail) {
      if (detail.year == '') {
        this.modal_open = false; // detail.year = '';

        this.$refs.save_line.validateField('policy_list.' + index + '.year'); // swal({
        //   title: "Warning",
        //   text: 'กรุณาใส่ข้อมูลปีงบประมาณ',
        //   type: "warning",
        //   showCancelButton: false,
        //   showConfirmButton: true
        // }, (isConfirm) => {
        // });

        swal({
          title: "Warning",
          text: 'กรุณาใส่ข้อมูลปีงบประมาณ!',
          // timer: 3000,
          type: "warning"
        });
      } else {
        this.modal_open = true;
        this.dialogVisible = true;
        this.modalId = index;
        this.modalIndexActive = index;

        if (Object.keys(detail.group_dists_rows[0]).length > 0) {
          this.detail.detailPolicyList = JSON.parse(JSON.stringify(_toConsumableArray(detail.group_dists_rows[0])));
        } else {
          // this.detail.detailPolicyList = JSON.parse(JSON.stringify(detail.group_dists_rows[0]))
          this.detail.detailPolicyList = [];
        }
      }
    },
    submitModal: function submitModal() {
      var _this10 = this;

      var found = this.detail.detailPolicyList.find(function (el) {
        return el.default_diff_amount;
      });

      if (found) {
        this.$refs.modal.validate(function (valid) {
          var checkDuplicate = function checkDuplicate() {
            var company_code = _this10.detail.detailPolicyList.map(function (detail) {
              return detail.company_code;
            });

            var isDuplicate = company_code.some(function (item, idx) {
              return company_code.indexOf(item) != idx;
            });
            if (isDuplicate) swal({
              title: "Warning",
              text: 'บริษัทประกันห้ามซ้ำกัน!',
              type: "warning"
            });
            return isDuplicate;
          };

          if (valid) {
            if (!_this10.checkSumOverdue() && !checkDuplicate()) {
              _this10.dataTable.policy_list[_this10.modalIndexActive].group_dists_rows = JSON.parse(JSON.stringify([_toConsumableArray(_this10.detail.detailPolicyList)]));
              _this10.dialogVisible = false; // document.getElementsByClassName('close')[0].click()
              // this.closeModal()

              _this10.savePolicyGroup();
            }
          }
        });
      } else {
        swal({
          title: "Warning",
          text: 'กรุณาระบุข้อมูลให้ครบ',
          type: "warning"
        });
      }
    },
    getDateStart: function getDateStart(date, index) {
      var vm = this;

      if (date === null) {
        vm.dataTable.policy_list[index].start_date = '';
        vm.dataTable.policy_list[index].start_timer = '';
        this.$refs.save_line.validateField("policy_list.".concat(index, ".start_date"));
      } else {
        vm.dataTable.policy_list[index].start_date = moment__WEBPACK_IMPORTED_MODULE_3___default()(date).format(vm.dateFormat);
        vm.dataTable.policy_list[index].start_timer = moment__WEBPACK_IMPORTED_MODULE_3___default()(date).unix();
        vm.checkDateOverlap(moment__WEBPACK_IMPORTED_MODULE_3___default()(date).format(vm.dateFormat), index);
        this.$refs.save_line.fields.find(function (f) {
          return f.prop == "policy_list.".concat(index, ".start_date");
        }).clearValidate();
      }
    },
    getDateEnd: function getDateEnd(date, index) {
      var vm = this;

      if (date === null) {
        vm.dataTable.policy_list[index].end_date = '';
        vm.dataTable.policy_list[index].end_timer = '';
        this.$refs.save_line.validateField("policy_list.".concat(index, ".end_date"));
      } else {
        vm.dataTable.policy_list[index].end_date = moment__WEBPACK_IMPORTED_MODULE_3___default()(date).format(vm.dateFormat);
        vm.dataTable.policy_list[index].end_timer = moment__WEBPACK_IMPORTED_MODULE_3___default()(date).unix();
        vm.checkDateOverlap(moment__WEBPACK_IMPORTED_MODULE_3___default()(date).format(vm.dateFormat), index);
        this.$refs.save_line.fields.find(function (f) {
          return f.prop == "policy_list.".concat(index, ".end_date");
        }).clearValidate();
      }
    },
    reqDate: function reqDate() {
      if (!this.checkCalculateDate()) {
        swal({
          title: "Warning",
          text: 'ฟิลด์วันที่เริ่มต้นต้องน้อยกว่าหรือเท่ากับฟิลด์วันที่สิ้นสุด!',
          // timer: 3000,
          type: "warning"
        });
        return false;
      }

      return true;
    },
    checkCalculateDate: function checkCalculateDate() {
      var vm = this;
      var checkDate = null;

      var _iterator = _createForOfIteratorHelper(vm.dataTable.policy_list),
          _step;

      try {
        for (_iterator.s(); !(_step = _iterator.n()).done;) {
          var policy = _step.value;

          if (policy.start_timer <= policy.end_timer) {
            checkDate = true;
          } else if (policy.start_timer > policy.end_timer) {
            checkDate = false;
            return;
          } else {
            checkDate = true;
          }
        }
      } catch (err) {
        _iterator.e(err);
      } finally {
        _iterator.f();
      }

      return checkDate;
    },
    checkDateOverlap: function checkDateOverlap(date, index) {
      var vm = this;
      var params = {
        data: {
          policy_lines_rows: vm.dataTable.policy_list.map(function (_ref8) {
            var start_date = _ref8.start_date,
                end_date = _ref8.end_date;
            return {
              start_date: start_date,
              end_date: end_date
            };
          }),
          date: date,
          index_number: index
        }
      };
      axios.post("/ir/ajax/policy-group/overlap-check", params).then(function (response) {
        vm.dataTable.policy_list[index].isOverlap = false;
      })["catch"](function (error) {
        vm.dataTable.policy_list[index].isOverlap = true;

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
    },
    checkSumOverdue: function checkSumOverdue() {
      var sum = 0;
      this.detail.detailPolicyList.map(function (policy) {
        sum += +policy.company_percent;
      });

      if (sum > 100) {
        swal({
          title: "Warning",
          text: 'สัดส่วนรวมกันต้องไม่เกิน 100%',
          // timer: 3000,
          type: "warning"
        });
        return true;
      } else if (sum < 100) {
        swal({
          title: "Warning",
          text: 'สัดส่วนรวมกันต้องได้ 100%',
          // timer: 3000,
          type: "warning"
        });
        return true;
      } else if (sum === 100) {
        return false;
      }
    },
    handleCompanies: function handleCompanies(value, index) {
      if (value) {
        for (var i in this.companies) {
          var data = this.companies[i];

          if (value === data.company_number) {
            this.detail.detailPolicyList[index].company_id = data.company_id; // this.callbackTypeCode(data.account_combine, data.account_id)
          }
        }
      }
    },
    handleAddRow: function handleAddRow() {
      var vm = this;
      vm.dataTable.policy_list.push({
        start_date: '',
        start_timer: '',
        end_date: '',
        end_timer: '',
        revenue_stamp: '',
        tax: '',
        premium_rate: 0,
        prepaid_insurance: 0,
        flg: 'add',
        group_dists_rows: [{}],
        year: ''
      });
      vm.$nextTick(function () {
        var el = vm.$el.getElementsByClassName('endTableLines')[0];

        if (el) {
          el.scrollIntoView();
        }
      });
    },
    clickRemoveFlgAdd: function clickRemoveFlgAdd(index) {
      this.dataTable.policy_list.splice(index, 1);
    },
    setDate: function setDate(value) {
      var date = '';

      if (value && value !== null && value !== undefined) {
        var arrYearCE = value ? value.split('/') : value;
        var yearCE = +arrYearCE[2] - 543;
        date = "".concat(arrYearCE[0], "/").concat(arrYearCE[1], "/").concat(yearCE);
      }

      return date;
    },
    receivedFullDate: function receivedFullDate(date) {},
    selectPolicy: function selectPolicy(value, index) {
      this.valid = true;
      this.data.policy_set[index].policy_set_header_id = value;
      this.checkDuplicatePolicyGroup(value, index);
    },
    remoteMethodPolicy: function remoteMethodPolicy(query) {
      this.getPolicyLov({
        policy_set_header_id: '',
        keyword: query
      });
    },
    checkDuplicatePolicyGroup: function checkDuplicatePolicyGroup(id, index) {
      var _this11 = this;

      var params = {
        group_header_id: this.group_header_id
      };
      axios.get("/ir/ajax/policy-group/duplicate-check/".concat(id), {
        params: params
      }).then(function (response) {
        for (var i = 0; i < _this11.data.policy_set.length; i++) {
          var arrayHeaderId = JSON.parse(JSON.stringify(_this11.data.policy_set.map(function (_ref9) {
            var id = _ref9.policy_set_header_id;
            return id;
          })));

          var headerId = _this11.data.policy_set[i].policy_set_header_id.toString();

          arrayHeaderId.splice(i, 1);

          if (arrayHeaderId.includes(headerId)) {
            swal({
              title: "Warning",
              text: 'กรมธรรม์ห้ามซ้ำกันภายในกลุ่ม',
              // timer: 3000,
              type: "warning"
            });
            _this11.data.policy_set[index].policy_set_header_id = '';
            return;
          }
        }
      })["catch"](function (error) {
        _this11.data.policy_set[index].policy_set_header_id = '';

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

        if (_this11.data.policy_set[0].policy_set_header_id == null || _this11.data.policy_set[0].policy_set_header_id == '') {
          _this11.valid = false;
        }
      });
    },
    closeModal: function closeModal() {
      var vm = this;
      vm.detail.detailPolicyList = [];
    },
    getValueYear: function getValueYear(date, index) {
      var formatYear = this.vars.formatYear;

      if (date) {
        this.dataTable.policy_list[index].year = moment__WEBPACK_IMPORTED_MODULE_3___default()(date).format(formatYear);
        this.$refs.save_line.fields.find(function (f) {
          return f.prop == 'policy_list.' + index + '.year';
        }).clearValidate();
      } else {
        this.dataTable.policy_list[index].year = '';
        this.dataTable.policy_list[index].start_date = '';
        this.dataTable.policy_list[index].end_date = '';
        this.$refs.save_line.validateField('policy_list.' + index + '.year');
      }

      this.checkYearDuplicate(this.dataTable.policy_list[index].year, index);
    },
    getDataInsuranceDate: function getDataInsuranceDate(year, index) {
      var _this12 = this;

      var params = {
        year: this.setYearCE('year', year),
        keyword: ''
      };
      axios.get("/ir/ajax/lov/effective-date", {
        params: params
      }).then(function (_ref10) {
        var data = _ref10.data;
        var response = data.data;

        if (response === null) {
          _this12.dataTable.policy_list[index].start_date = '';
          _this12.dataTable.policy_list[index].end_date = '';

          _this12.$refs.save_line.validateField('policy_list.' + index + '.start_date');

          _this12.$refs.save_line.validateField('policy_list.' + index + '.end_date');
        } else {
          _this12.dataTable.policy_list[index].start_date = response.start_date_active;
          _this12.dataTable.policy_list[index].end_date = response.end_date_active;

          _this12.$refs.save_line.fields.find(function (f) {
            return f.prop == 'policy_list.' + index + '.start_date';
          }).clearValidate();

          _this12.$refs.save_line.fields.find(function (f) {
            return f.prop == 'policy_list.' + index + '.end_date';
          }).clearValidate();
        }
      })["catch"](function (error) {
        swal('Error', error, 'error');
      });
    },
    checkYearDuplicate: function checkYearDuplicate(year, index) {
      var table = this.dataTable.policy_list;

      var _this = this;

      var yearVal = table.map(function (row) {
        return row.year;
      });
      var isDuplicate = yearVal.some(function (item, idx) {
        if (item) {
          return yearVal.indexOf(item) != idx;
        }
      });

      if (isDuplicate) {
        swal({
          title: "Warning",
          text: "ปีห้ามซ้ำ!",
          type: "warning"
        }, function (isConfirm) {
          if (isConfirm) {
            table[index].year = '';

            _this.$refs.save_line.validateField('policy_list.' + index + '.year'); // _this.getDataInsuranceDate(table[index].year, index);

          }
        }); // } else {
        //   this.getDataInsuranceDate(year, index);
      }
    },
    checkDefaultDiff: function checkDefaultDiff(policy, index) {
      // console.log('func checkDefaultDiff default_diff_amount <--> ', policy.default_diff_amount);
      // console.log('func checkDefaultDiff index <--> ', index);
      if (policy.default_diff_amount) {
        this.detail.detailPolicyList.forEach(function (element, i) {
          if (element.default_diff_amount == true || element.default_diff_amount == "Y") {
            if (i != index) {
              policy.default_diff_amount = false;
              swal({
                title: "Warning",
                text: 'มีการระบุบริษัทประกันอื่นเรียบร้อยแล้ว กรุณาตรวจสอบ',
                type: "warning"
              });
            }
          }
        });
      }
    }
  },
  computed: {
    disabledField: function disabledField() {
      if (this.action === 'edit') {
        return true;
      }

      return false;
    }
  },
  mounted: function mounted() {
    this.getPolicyGroupDetail();
    this.getPolicyLov({
      policy_set_header_id: ''
    });
    this.getCompanies({
      company_id: '',
      company_name: ''
    });
  },
  components: {
    dateInput: _components_calendar_dateInput__WEBPACK_IMPORTED_MODULE_1__.default,
    currencyInput: _components_currencyInput__WEBPACK_IMPORTED_MODULE_0__.default,
    lovPolicyHeaderId: _lovPolicy__WEBPACK_IMPORTED_MODULE_2__.default
  } // created() {
  //   const vm = this
  //   vm.getPolicyGroupDetail()
  // }

});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy-group/lovPolicy.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy-group/lovPolicy.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************************************************************************/
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
  name: 'ir-components-lov-policy-set-header-id',
  data: function data() {
    return {
      rows: [],
      loading: false,
      result: parseInt(this.value) ? parseInt(this.value) : ''
    };
  },
  props: ['value', 'name', 'size'],
  methods: {
    getDataRows: function getDataRows(params) {
      var _this = this;

      this.loading = true;
      axios.get("/ir/ajax/lov/policy-set-header", {
        params: params
      }).then(function (_ref) {
        var data = _ref.data;
        _this.loading = false;
        _this.rows = data.data;
      })["catch"](function (error) {
        swal("Error", error, "error");
      });
    },
    change: function change(value) {
      this.$emit('changePolicyHeader', value);
    }
  },
  mounted: function mounted() {
    this.getDataRows({
      policy_set_header_id: '',
      keyword: ''
    });
  },
  watch: {
    value: function value(newVal) {
      this.result = parseInt(newVal) ? parseInt(newVal) : '';
    }
  }
});

/***/ }),

/***/ "./resources/js/components/ir/settings/policy-group/edit-policy-group.vue":
/*!********************************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy-group/edit-policy-group.vue ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _edit_policy_group_vue_vue_type_template_id_4e1edded___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./edit-policy-group.vue?vue&type=template&id=4e1edded& */ "./resources/js/components/ir/settings/policy-group/edit-policy-group.vue?vue&type=template&id=4e1edded&");
/* harmony import */ var _edit_policy_group_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./edit-policy-group.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/settings/policy-group/edit-policy-group.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _edit_policy_group_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _edit_policy_group_vue_vue_type_template_id_4e1edded___WEBPACK_IMPORTED_MODULE_0__.render,
  _edit_policy_group_vue_vue_type_template_id_4e1edded___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/settings/policy-group/edit-policy-group.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/settings/policy-group/formPolicyGroup.vue":
/*!******************************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy-group/formPolicyGroup.vue ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _formPolicyGroup_vue_vue_type_template_id_7648d86f___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./formPolicyGroup.vue?vue&type=template&id=7648d86f& */ "./resources/js/components/ir/settings/policy-group/formPolicyGroup.vue?vue&type=template&id=7648d86f&");
/* harmony import */ var _formPolicyGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./formPolicyGroup.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/settings/policy-group/formPolicyGroup.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _formPolicyGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _formPolicyGroup_vue_vue_type_template_id_7648d86f___WEBPACK_IMPORTED_MODULE_0__.render,
  _formPolicyGroup_vue_vue_type_template_id_7648d86f___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/settings/policy-group/formPolicyGroup.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/settings/policy-group/lovPolicy.vue":
/*!************************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy-group/lovPolicy.vue ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _lovPolicy_vue_vue_type_template_id_ccbc036a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./lovPolicy.vue?vue&type=template&id=ccbc036a& */ "./resources/js/components/ir/settings/policy-group/lovPolicy.vue?vue&type=template&id=ccbc036a&");
/* harmony import */ var _lovPolicy_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./lovPolicy.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/settings/policy-group/lovPolicy.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _lovPolicy_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _lovPolicy_vue_vue_type_template_id_ccbc036a___WEBPACK_IMPORTED_MODULE_0__.render,
  _lovPolicy_vue_vue_type_template_id_ccbc036a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/settings/policy-group/lovPolicy.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/settings/policy-group/edit-policy-group.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy-group/edit-policy-group.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_edit_policy_group_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./edit-policy-group.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy-group/edit-policy-group.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_edit_policy_group_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/settings/policy-group/formPolicyGroup.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy-group/formPolicyGroup.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_formPolicyGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./formPolicyGroup.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy-group/formPolicyGroup.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_formPolicyGroup_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/settings/policy-group/lovPolicy.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy-group/lovPolicy.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_lovPolicy_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./lovPolicy.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy-group/lovPolicy.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_lovPolicy_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/settings/policy-group/edit-policy-group.vue?vue&type=template&id=4e1edded&":
/*!***************************************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy-group/edit-policy-group.vue?vue&type=template&id=4e1edded& ***!
  \***************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_edit_policy_group_vue_vue_type_template_id_4e1edded___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_edit_policy_group_vue_vue_type_template_id_4e1edded___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_edit_policy_group_vue_vue_type_template_id_4e1edded___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./edit-policy-group.vue?vue&type=template&id=4e1edded& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy-group/edit-policy-group.vue?vue&type=template&id=4e1edded&");


/***/ }),

/***/ "./resources/js/components/ir/settings/policy-group/formPolicyGroup.vue?vue&type=template&id=7648d86f&":
/*!*************************************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy-group/formPolicyGroup.vue?vue&type=template&id=7648d86f& ***!
  \*************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_formPolicyGroup_vue_vue_type_template_id_7648d86f___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_formPolicyGroup_vue_vue_type_template_id_7648d86f___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_formPolicyGroup_vue_vue_type_template_id_7648d86f___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./formPolicyGroup.vue?vue&type=template&id=7648d86f& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy-group/formPolicyGroup.vue?vue&type=template&id=7648d86f&");


/***/ }),

/***/ "./resources/js/components/ir/settings/policy-group/lovPolicy.vue?vue&type=template&id=ccbc036a&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/components/ir/settings/policy-group/lovPolicy.vue?vue&type=template&id=ccbc036a& ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_lovPolicy_vue_vue_type_template_id_ccbc036a___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_lovPolicy_vue_vue_type_template_id_ccbc036a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_lovPolicy_vue_vue_type_template_id_ccbc036a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./lovPolicy.vue?vue&type=template&id=ccbc036a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy-group/lovPolicy.vue?vue&type=template&id=ccbc036a&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy-group/edit-policy-group.vue?vue&type=template&id=4e1edded&":
/*!******************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy-group/edit-policy-group.vue?vue&type=template&id=4e1edded& ***!
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
      _c("form-policy-group", {
        attrs: {
          policy: _vm.policy,
          vars: _vm.vars,
          setYearCE: _vm.funcs.setYearCE,
          "btn-trans": _vm.btnTrans
        }
      })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy-group/formPolicyGroup.vue?vue&type=template&id=7648d86f&":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy-group/formPolicyGroup.vue?vue&type=template&id=7648d86f& ***!
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
    [
      _c(
        "div",
        { staticClass: "col-12" },
        [
          _c("div", { staticClass: "row mt-2 mb-1" }, [
            _c("div", { staticClass: "col-xl-7 col-md-7 offset-md-3" }, [
              _c("div", { staticClass: "form-group row" }, [
                _c(
                  "div",
                  { staticClass: "col-lg-3 col-md-3 alig-item-center" },
                  [
                    _c("el-input", {
                      attrs: {
                        type: "text",
                        name: "policy_set_number",
                        disabled: true,
                        maxlength: 100
                      },
                      model: {
                        value: _vm.group_code,
                        callback: function($$v) {
                          _vm.group_code = $$v
                        },
                        expression: "group_code"
                      }
                    })
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-lg-5 col-md-5 alig-item-center" },
                  [
                    _c("el-input", {
                      attrs: {
                        type: "text",
                        name: "policy_set_number",
                        maxlength: 150
                      },
                      model: {
                        value: _vm.group_description,
                        callback: function($$v) {
                          _vm.group_description = $$v
                        },
                        expression: "group_description"
                      }
                    })
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-lg-4 col-md-4 alig-item-center" },
                  [
                    _c(
                      "button",
                      {
                        class: _vm.btnTrans.addList.class + " btn-lg tw-w-25",
                        attrs: { type: "button" },
                        on: {
                          click: function($event) {
                            $event.preventDefault()
                            return _vm.addRow()
                          }
                        }
                      },
                      [
                        _c("i", { class: _vm.btnTrans.addList.icon }),
                        _vm._v(
                          "\n                " +
                            _vm._s(_vm.btnTrans.addList.text) +
                            "ชุดกรมธรรม์\n              "
                        )
                      ]
                    )
                  ]
                )
              ])
            ])
          ]),
          _vm._v(" "),
          _c(
            "el-form",
            {
              ref: "assign",
              staticClass: "form_table_line",
              attrs: { model: _vm.data }
            },
            [
              _c("div", { staticClass: "col-8 offset-md-2" }, [
                _c("div", { staticClass: "table-responsive" }, [
                  _c("table", { staticClass: "table table-bordered center" }, [
                    _c("thead", [
                      _c("tr", [
                        _c(
                          "th",
                          {
                            staticClass: "text-center",
                            staticStyle: { width: "70px" }
                          },
                          [
                            _vm._v("กรมธรรม์ชุดที่ (Policy No) "),
                            _c("span", { staticClass: "text-danger" }, [
                              _vm._v(" * ")
                            ])
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "th",
                          {
                            staticClass: "text-center",
                            staticStyle: { width: "25px" }
                          },
                          [_vm._v("Action")]
                        )
                      ])
                    ]),
                    _vm._v(" "),
                    _c(
                      "tbody",
                      _vm._l(_vm.data.policy_set, function(policy, index) {
                        return _c(
                          "tr",
                          {
                            key: index,
                            class: [
                              index == _vm.data.policy_set.length - 1
                                ? "endTable"
                                : ""
                            ]
                          },
                          [
                            _c(
                              "th",
                              { staticClass: "el_field" },
                              [
                                _c(
                                  "el-form-item",
                                  {
                                    staticClass: "el-form-item-irm0003 pb-2",
                                    attrs: {
                                      prop:
                                        "policy_set." +
                                        index +
                                        ".policy_set_header_id",
                                      rules: _vm.rules.policy_set_header_id
                                    }
                                  },
                                  [
                                    _c("lov-policy-header-id", {
                                      attrs: {
                                        value: policy.policy_set_header_id
                                      },
                                      on: {
                                        changePolicyHeader: function($event) {
                                          var i = arguments.length,
                                            argsArray = Array(i)
                                          while (i--)
                                            argsArray[i] = arguments[i]
                                          return _vm.selectPolicy.apply(
                                            void 0,
                                            argsArray.concat([index])
                                          )
                                        }
                                      },
                                      model: {
                                        value: policy.policy_set_header_id,
                                        callback: function($$v) {
                                          _vm.$set(
                                            policy,
                                            "policy_set_header_id",
                                            $$v
                                          )
                                        },
                                        expression:
                                          "policy.policy_set_header_id"
                                      }
                                    })
                                  ],
                                  1
                                )
                              ],
                              1
                            ),
                            _vm._v(" "),
                            _c("th", { staticClass: "el_field text-center" }, [
                              _c(
                                "button",
                                {
                                  class:
                                    _vm.btnTrans.delete.class +
                                    " btn-sm tw-w-25",
                                  staticStyle: { "margin-top": "6px" },
                                  attrs: { type: "button" },
                                  on: {
                                    click: function($event) {
                                      $event.preventDefault()
                                      return _vm.clickRemove(index, policy)
                                    }
                                  }
                                },
                                [
                                  _c("i", { class: _vm.btnTrans.delete.icon }),
                                  _vm._v(
                                    "\n                      " +
                                      _vm._s(_vm.btnTrans.delete.text) +
                                      "\n                    "
                                  )
                                ]
                              )
                            ])
                          ]
                        )
                      }),
                      0
                    )
                  ])
                ])
              ])
            ]
          ),
          _vm._v(" "),
          _vm.data.policy_set != ""
            ? [
                _c("div", { staticClass: "hr-line-dashed" }),
                _vm._v(" "),
                _c("div", { staticClass: "col-12 pr-0 mb-2 text-right" }, [
                  _vm.valid
                    ? _c(
                        "button",
                        {
                          class: _vm.btnTrans.assign.class + " btn-lg tw-w-25",
                          attrs: { type: "button" },
                          on: {
                            click: function($event) {
                              $event.preventDefault()
                              return _vm.handleAssign()
                            }
                          }
                        },
                        [
                          _c("i", { class: _vm.btnTrans.assign.icon }),
                          _vm._v(
                            "\n              " +
                              _vm._s(_vm.btnTrans.assign.text) +
                              "\n            "
                          )
                        ]
                      )
                    : _vm._e(),
                  _vm._v(" "),
                  _c(
                    "button",
                    {
                      directives: [
                        {
                          name: "show",
                          rawName: "v-show",
                          value: _vm.showTable,
                          expression: "showTable"
                        }
                      ],
                      class: _vm.btnTrans.addList.class + " btn-lg tw-w-25",
                      attrs: { type: "button" },
                      on: {
                        click: function($event) {
                          $event.preventDefault()
                          return _vm.handleAddRow()
                        }
                      }
                    },
                    [
                      _c("i", { class: _vm.btnTrans.addList.icon }),
                      _vm._v(
                        "\n              " +
                          _vm._s(_vm.btnTrans.addList.text) +
                          "รายการ\n            "
                      )
                    ]
                  )
                ])
              ]
            : _vm._e()
        ],
        2
      ),
      _vm._v(" "),
      _c(
        "el-form",
        {
          ref: "save_line",
          staticClass: "form_table_line",
          attrs: { model: _vm.dataTable, rules: _vm.rules }
        },
        [
          _c("div", { staticClass: "col-12" }, [
            _c(
              "div",
              {
                directives: [
                  {
                    name: "show",
                    rawName: "v-show",
                    value: _vm.showTable,
                    expression: "showTable"
                  }
                ],
                staticClass: "table-responsive"
              },
              [
                _c(
                  "table",
                  { staticClass: "table table-bordered table_style" },
                  [
                    _c("thead", [
                      _c("tr", [
                        _c(
                          "th",
                          {
                            staticClass: "text-center",
                            staticStyle: { width: "250px" }
                          },
                          [
                            _vm._v("ปีงบประมาณ "),
                            _c("span", { staticClass: "text-danger" }, [
                              _vm._v(" * ")
                            ])
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "th",
                          {
                            staticClass: "text-center",
                            staticStyle: { width: "150px" }
                          },
                          [_vm._v("อากรแสตมป์ (%)")]
                        ),
                        _vm._v(" "),
                        _c(
                          "th",
                          {
                            staticClass: "text-center",
                            staticStyle: { width: "150px" }
                          },
                          [_vm._v("ภาษี (%)")]
                        ),
                        _vm._v(" "),
                        _c(
                          "th",
                          {
                            staticClass: "text-center",
                            staticStyle: { width: "150px" }
                          },
                          [
                            _vm._v("อัตราเบี้ย (%) "),
                            _c("span", { staticClass: "text-danger" }, [
                              _vm._v(" * ")
                            ])
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "th",
                          {
                            staticClass: "text-center",
                            staticStyle: { width: "300px" }
                          },
                          [
                            _vm._v("เบี้ยประกันจ่ายล่วงหน้า (%) "),
                            _c("span", { staticClass: "text-danger" }, [
                              _vm._v(" * ")
                            ])
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "th",
                          {
                            staticClass: "text-center",
                            staticStyle: { width: "250px" }
                          },
                          [_vm._v("Management")]
                        ),
                        _vm._v(" "),
                        _c(
                          "th",
                          {
                            staticClass: "text-center",
                            staticStyle: { width: "100px" }
                          },
                          [_vm._v("Action")]
                        )
                      ])
                    ]),
                    _vm._v(" "),
                    _c(
                      "tbody",
                      [
                        _vm._l(_vm.dataTable.policy_list, function(
                          policy_detail,
                          index
                        ) {
                          return _c(
                            "tr",
                            {
                              directives: [
                                {
                                  name: "show",
                                  rawName: "v-show",
                                  value: _vm.dataTable.policy_list.length,
                                  expression: "dataTable.policy_list.length"
                                }
                              ],
                              key: index,
                              class: [
                                index == _vm.dataTable.policy_list.length - 1
                                  ? "endTableLines"
                                  : ""
                              ]
                            },
                            [
                              _c(
                                "th",
                                {
                                  staticClass: "el_field",
                                  staticStyle: { width: "150px" }
                                },
                                [
                                  _c(
                                    "el-form-item",
                                    {
                                      staticClass:
                                        "el-input--small el-form-item-irm0003 pb-2",
                                      attrs: {
                                        prop: "policy_list." + index + ".year",
                                        rules: _vm.rules.year
                                      }
                                    },
                                    [
                                      _c("datepicker-th", {
                                        staticClass:
                                          "el-input__inner style_icon_calendar",
                                        staticStyle: {
                                          width: "100%",
                                          "line-height": "30px"
                                        },
                                        attrs: {
                                          name: "year" + index,
                                          "p-type": "year",
                                          placeholder: "ปีงบประมาณ",
                                          format: _vm.vars.formatYear,
                                          inputClass: "input_date_small"
                                        },
                                        on: {
                                          dateWasSelected: function($event) {
                                            var i = arguments.length,
                                              argsArray = Array(i)
                                            while (i--)
                                              argsArray[i] = arguments[i]
                                            return _vm.getValueYear.apply(
                                              void 0,
                                              argsArray.concat([index])
                                            )
                                          }
                                        },
                                        model: {
                                          value: policy_detail.year,
                                          callback: function($$v) {
                                            _vm.$set(policy_detail, "year", $$v)
                                          },
                                          expression: "policy_detail.year"
                                        }
                                      })
                                    ],
                                    1
                                  )
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c(
                                "th",
                                {
                                  staticClass:
                                    "text-right el_field currency_right"
                                },
                                [
                                  _c(
                                    "el-form-item",
                                    {
                                      staticClass:
                                        "currency_right el-form-item-irm0003 pb-2"
                                    },
                                    [
                                      _c("currency-input", {
                                        staticClass: "currency_right",
                                        attrs: {
                                          placeholder: "อากรแสตมป์",
                                          disabled: false,
                                          decimal: 5,
                                          sizeSmall: true
                                        },
                                        model: {
                                          value: policy_detail.revenue_stamp,
                                          callback: function($$v) {
                                            _vm.$set(
                                              policy_detail,
                                              "revenue_stamp",
                                              $$v
                                            )
                                          },
                                          expression:
                                            "policy_detail.revenue_stamp"
                                        }
                                      })
                                    ],
                                    1
                                  )
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c(
                                "th",
                                { staticClass: "el_field" },
                                [
                                  _c(
                                    "el-form-item",
                                    {
                                      staticClass:
                                        "currency_right el-form-item-irm0003 pb-2"
                                    },
                                    [
                                      _c("currency-input", {
                                        attrs: {
                                          placeholder: "ภาษี",
                                          sizeSmall: true,
                                          disabled: false
                                        },
                                        model: {
                                          value: policy_detail.tax,
                                          callback: function($$v) {
                                            _vm.$set(policy_detail, "tax", $$v)
                                          },
                                          expression: "policy_detail.tax"
                                        }
                                      })
                                    ],
                                    1
                                  )
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c(
                                "th",
                                { staticClass: "el_field" },
                                [
                                  _c(
                                    "el-form-item",
                                    {
                                      staticClass:
                                        "currency_right el-form-item-irm0003 pb-2",
                                      attrs: {
                                        prop:
                                          "policy_list." +
                                          index +
                                          ".premium_rate",
                                        rules: _vm.rules.premium_rate
                                      }
                                    },
                                    [
                                      _c("currency-input", {
                                        attrs: {
                                          placeholder: "อัตราเบี้ย",
                                          disabled: false,
                                          sizeSmall: true,
                                          decimal: 5
                                        },
                                        model: {
                                          value: policy_detail.premium_rate,
                                          callback: function($$v) {
                                            _vm.$set(
                                              policy_detail,
                                              "premium_rate",
                                              $$v
                                            )
                                          },
                                          expression:
                                            "policy_detail.premium_rate"
                                        }
                                      })
                                    ],
                                    1
                                  )
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c(
                                "th",
                                { staticClass: "el_field" },
                                [
                                  _c(
                                    "el-form-item",
                                    {
                                      staticClass:
                                        "currency_right el-form-item-irm0003 pb-2",
                                      attrs: {
                                        prop:
                                          "policy_list." +
                                          index +
                                          ".prepaid_insurance",
                                        rules: _vm.rules.prepaid_insurance
                                      }
                                    },
                                    [
                                      _c("currency-input", {
                                        attrs: {
                                          placeholder:
                                            "เบี้ยประกันจ่ายล่วงหน้า",
                                          sizeSmall: true,
                                          disabled: false
                                        },
                                        model: {
                                          value:
                                            policy_detail.prepaid_insurance,
                                          callback: function($$v) {
                                            _vm.$set(
                                              policy_detail,
                                              "prepaid_insurance",
                                              $$v
                                            )
                                          },
                                          expression:
                                            "policy_detail.prepaid_insurance"
                                        }
                                      })
                                    ],
                                    1
                                  )
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c(
                                "th",
                                {
                                  staticClass: "text-center pb-2",
                                  staticStyle: { width: "120px" }
                                },
                                [
                                  _c(
                                    "button",
                                    {
                                      class:
                                        _vm.btnTrans.addList.class +
                                        " btn-sm tw-w-25",
                                      attrs: {
                                        type: "button",
                                        "data-toggle": "modal",
                                        "data-target": "#modal_detail" + index
                                      },
                                      on: {
                                        click: function($event) {
                                          return _vm.clickModal(
                                            index,
                                            policy_detail
                                          )
                                        }
                                      }
                                    },
                                    [
                                      _c("i", {
                                        class: _vm.btnTrans.addList.icon
                                      }),
                                      _vm._v(
                                        "\n                        " +
                                          _vm._s(_vm.btnTrans.addList.text) +
                                          "รายละเอียด\n                      "
                                      )
                                    ]
                                  )
                                ]
                              ),
                              _vm._v(" "),
                              _c(
                                "th",
                                {
                                  staticClass: "text-center",
                                  staticStyle: { width: "120px" }
                                },
                                [
                                  policy_detail.flg !== undefined
                                    ? _c(
                                        "el-form-item",
                                        {
                                          staticClass:
                                            "el-form-item-irm0003 pb-2"
                                        },
                                        [
                                          _c(
                                            "button",
                                            {
                                              class:
                                                _vm.btnTrans.delete.class +
                                                " btn-sm tw-w-25",
                                              attrs: { type: "button" },
                                              on: {
                                                click: function($event) {
                                                  $event.preventDefault()
                                                  return _vm.clickRemoveFlgAdd(
                                                    index
                                                  )
                                                }
                                              }
                                            },
                                            [
                                              _c("i", {
                                                class: _vm.btnTrans.delete.icon
                                              }),
                                              _vm._v(
                                                "\n                        " +
                                                  _vm._s(
                                                    _vm.btnTrans.delete.text
                                                  ) +
                                                  "\n                      "
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
                        }),
                        _vm._v(" "),
                        _c(
                          "tr",
                          {
                            directives: [
                              {
                                name: "show",
                                rawName: "v-show",
                                value: _vm.dataTable.policy_list.length === 0,
                                expression: "dataTable.policy_list.length === 0"
                              }
                            ],
                            staticClass: "text-center"
                          },
                          [
                            _c("td", { attrs: { colspan: "9" } }, [
                              _vm._v("ไม่มีข้อมูล")
                            ])
                          ]
                        )
                      ],
                      2
                    ),
                    _vm._v(" "),
                    _c("tfoot")
                  ]
                )
              ]
            ),
            _vm._v(" "),
            _vm.showTable
              ? _c("div", { staticClass: "col-12 p-0 text-right" }, [
                  _c(
                    "button",
                    {
                      class: _vm.btnTrans.save.class + " btn-lg tw-w-25",
                      attrs: { type: "button" },
                      on: {
                        click: function($event) {
                          $event.preventDefault()
                          return _vm.savePolicyGroup()
                        }
                      }
                    },
                    [
                      _c("i", { class: _vm.btnTrans.save.icon }),
                      _vm._v(
                        "\n                " +
                          _vm._s(_vm.btnTrans.save.text) +
                          "\n              "
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
                          return _vm.handleCancel()
                        }
                      }
                    },
                    [
                      _c("i", { class: _vm.btnTrans.cancel.icon }),
                      _vm._v(
                        "\n                " +
                          _vm._s(_vm.btnTrans.cancel.text) +
                          "\n              "
                      )
                    ]
                  )
                ])
              : _vm._e()
          ])
        ]
      ),
      _vm._v(" "),
      this.modal_open
        ? _c("div", [
            _c(
              "div",
              {
                staticClass: "modal inmodal fade",
                attrs: {
                  "data-backdrop": "static",
                  "data-keyboard": "false",
                  id: "modal_detail" + _vm.modalId,
                  tabindex: "-1",
                  role: "dialog",
                  "aria-hidden": "true"
                }
              },
              [
                _c("div", { staticClass: "modal-dialog modal-xl" }, [
                  _c("div", { staticClass: "modal-content" }, [
                    _c("div", { staticClass: "modal-header" }, [
                      _c(
                        "button",
                        {
                          staticClass: "close",
                          attrs: { type: "button", "data-dismiss": "modal" },
                          on: {
                            click: function($event) {
                              return _vm.closeModal()
                            }
                          }
                        },
                        [
                          _c("span", { attrs: { "aria-hidden": "true" } }, [
                            _vm._v("×")
                          ]),
                          _c("span", { staticClass: "sr-only" }, [
                            _vm._v("Close")
                          ])
                        ]
                      ),
                      _vm._v(" "),
                      _c("p", { staticClass: "modal-title text-left" })
                    ]),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "modal-body" },
                      [
                        _c("div", { staticClass: "col-12 mb-3 text-right" }, [
                          _c(
                            "button",
                            {
                              class:
                                _vm.btnTrans.addList.class + " btn-lg tw-w-25",
                              staticStyle: { height: "35px" },
                              attrs: { type: "button" },
                              on: {
                                click: function($event) {
                                  return _vm.addDetailPolicyList()
                                }
                              }
                            },
                            [
                              _c("i", { class: _vm.btnTrans.addList.icon }),
                              _vm._v(
                                "\n                  " +
                                  _vm._s(_vm.btnTrans.addList.text) +
                                  "รายละเอียด\n                "
                              )
                            ]
                          )
                        ]),
                        _vm._v(" "),
                        _c(
                          "el-form",
                          {
                            ref: "modal",
                            staticClass: "form_table_line",
                            attrs: { model: _vm.detail }
                          },
                          [
                            _c("div", { staticClass: "col-12" }, [
                              _c("div", { staticClass: "table-responsive" }, [
                                _c(
                                  "table",
                                  {
                                    staticClass:
                                      "table table-bordered table_style"
                                  },
                                  [
                                    _c("thead", [
                                      _c("tr", [
                                        _c(
                                          "th",
                                          {
                                            staticClass: "text-center",
                                            staticStyle: { width: "300px" }
                                          },
                                          [
                                            _vm._v("บริษัทประกัน "),
                                            _c(
                                              "span",
                                              { staticClass: "text-danger" },
                                              [_vm._v(" * ")]
                                            )
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "th",
                                          {
                                            staticClass: "text-center",
                                            staticStyle: { width: "150px" }
                                          },
                                          [
                                            _vm._v("สัดส่วน(%) "),
                                            _c(
                                              "span",
                                              { staticClass: "text-danger" },
                                              [_vm._v(" * ")]
                                            )
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "th",
                                          {
                                            staticClass: "text-center",
                                            staticStyle: { width: "150px" }
                                          },
                                          [_vm._v("เลขที่กรมธรรม์")]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "th",
                                          {
                                            staticClass: "text-center",
                                            staticStyle: { width: "150px" }
                                          },
                                          [_vm._v("เลขที่สลักหลัง")]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "th",
                                          {
                                            staticClass: "text-center",
                                            staticStyle: { width: "150px" }
                                          },
                                          [
                                            _vm._v("ปัดเศษทศนิยมส่ง AP "),
                                            _c(
                                              "span",
                                              { staticClass: "text-danger" },
                                              [_vm._v(" * ")]
                                            )
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "th",
                                          {
                                            staticClass: "text-center",
                                            staticStyle: { width: "100px" }
                                          },
                                          [_vm._v("Action")]
                                        )
                                      ])
                                    ]),
                                    _vm._v(" "),
                                    _c(
                                      "tbody",
                                      [
                                        _vm._l(
                                          _vm.detail.detailPolicyList,
                                          function(policy, index) {
                                            return _c("tr", { key: index }, [
                                              _c(
                                                "td",
                                                { staticClass: "el_field" },
                                                [
                                                  _c(
                                                    "el-form-item",
                                                    {
                                                      staticClass:
                                                        "el-form-item-irm0003 pb-2 mt-4",
                                                      attrs: {
                                                        prop:
                                                          "detailPolicyList." +
                                                          index +
                                                          ".company_code",
                                                        rules:
                                                          _vm.rules.company_code
                                                      }
                                                    },
                                                    [
                                                      _c(
                                                        "el-select",
                                                        {
                                                          staticClass: "w-100",
                                                          attrs: {
                                                            filterable: "",
                                                            name: "policy_id",
                                                            loading:
                                                              _vm.loading,
                                                            clearable: true,
                                                            remote: "",
                                                            "popper-append-to-body": false
                                                          },
                                                          on: {
                                                            change: function(
                                                              $event
                                                            ) {
                                                              var i =
                                                                  arguments.length,
                                                                argsArray = Array(
                                                                  i
                                                                )
                                                              while (i--)
                                                                argsArray[i] =
                                                                  arguments[i]
                                                              return _vm.handleCompanies.apply(
                                                                void 0,
                                                                argsArray.concat(
                                                                  [index]
                                                                )
                                                              )
                                                            }
                                                          },
                                                          model: {
                                                            value:
                                                              policy.company_code,
                                                            callback: function(
                                                              $$v
                                                            ) {
                                                              _vm.$set(
                                                                policy,
                                                                "company_code",
                                                                $$v
                                                              )
                                                            },
                                                            expression:
                                                              "policy.company_code"
                                                          }
                                                        },
                                                        _vm._l(
                                                          _vm.companies,
                                                          function(company) {
                                                            return _c(
                                                              "el-option",
                                                              {
                                                                key:
                                                                  company.company_id,
                                                                attrs: {
                                                                  label:
                                                                    company.company_number +
                                                                    " : " +
                                                                    company.company_name,
                                                                  value:
                                                                    company.company_number
                                                                }
                                                              }
                                                            )
                                                          }
                                                        ),
                                                        1
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
                                                { staticClass: "el_field" },
                                                [
                                                  _c(
                                                    "el-form-item",
                                                    {
                                                      staticClass:
                                                        "el-form-item-irm0003 pb-2 mt-4",
                                                      attrs: {
                                                        prop:
                                                          "detailPolicyList." +
                                                          index +
                                                          ".company_percent",
                                                        rules:
                                                          _vm.rules
                                                            .company_percent
                                                      }
                                                    },
                                                    [
                                                      _c("currency-input", {
                                                        attrs: {
                                                          placeholder:
                                                            "สัดส่วน",
                                                          disabled: false
                                                        },
                                                        model: {
                                                          value:
                                                            policy.company_percent,
                                                          callback: function(
                                                            $$v
                                                          ) {
                                                            _vm.$set(
                                                              policy,
                                                              "company_percent",
                                                              $$v
                                                            )
                                                          },
                                                          expression:
                                                            "policy.company_percent"
                                                        }
                                                      })
                                                    ],
                                                    1
                                                  )
                                                ],
                                                1
                                              ),
                                              _vm._v(" "),
                                              _c(
                                                "td",
                                                { staticClass: "el_field" },
                                                [
                                                  _c("el-input", {
                                                    staticClass:
                                                      "el-form-item-irm0003 pb-2",
                                                    attrs: { maxlength: 150 },
                                                    model: {
                                                      value:
                                                        policy.user_policy_number,
                                                      callback: function($$v) {
                                                        _vm.$set(
                                                          policy,
                                                          "user_policy_number",
                                                          $$v
                                                        )
                                                      },
                                                      expression:
                                                        "policy.user_policy_number"
                                                    }
                                                  })
                                                ],
                                                1
                                              ),
                                              _vm._v(" "),
                                              _c(
                                                "td",
                                                { staticClass: "el_field" },
                                                [
                                                  _c("el-input", {
                                                    staticClass:
                                                      "el-form-item-irm0003 pb-2",
                                                    attrs: { maxlength: 1000 },
                                                    model: {
                                                      value: policy.comments,
                                                      callback: function($$v) {
                                                        _vm.$set(
                                                          policy,
                                                          "comments",
                                                          $$v
                                                        )
                                                      },
                                                      expression:
                                                        "policy.comments"
                                                    }
                                                  })
                                                ],
                                                1
                                              ),
                                              _vm._v(" "),
                                              _c(
                                                "td",
                                                {
                                                  staticClass:
                                                    "el_field text-center"
                                                },
                                                [
                                                  _c("el-checkbox", {
                                                    staticClass:
                                                      "el-form-item-irm0003 pb-2 mt-3",
                                                    attrs: {
                                                      checked:
                                                        policy.default_diff_amount ==
                                                        "Y"
                                                          ? true
                                                          : false
                                                    },
                                                    on: {
                                                      change: function($event) {
                                                        return _vm.checkDefaultDiff(
                                                          policy,
                                                          index
                                                        )
                                                      }
                                                    },
                                                    model: {
                                                      value:
                                                        policy.default_diff_amount,
                                                      callback: function($$v) {
                                                        _vm.$set(
                                                          policy,
                                                          "default_diff_amount",
                                                          $$v
                                                        )
                                                      },
                                                      expression:
                                                        "policy.default_diff_amount"
                                                    }
                                                  })
                                                ],
                                                1
                                              ),
                                              _vm._v(" "),
                                              _c(
                                                "td",
                                                {
                                                  staticClass:
                                                    "el_field text-center"
                                                },
                                                [
                                                  policy.flg !== undefined
                                                    ? _c(
                                                        "el-form-item",
                                                        {
                                                          staticClass:
                                                            "el-form-item-irm0003 pb-2 mt-3"
                                                        },
                                                        [
                                                          _c(
                                                            "button",
                                                            {
                                                              class:
                                                                _vm.btnTrans
                                                                  .delete
                                                                  .class +
                                                                " btn-sm tw-w-25",
                                                              attrs: {
                                                                type: "button"
                                                              },
                                                              on: {
                                                                click: function(
                                                                  $event
                                                                ) {
                                                                  $event.preventDefault()
                                                                  return _vm.clickRemoveDetailFlgAdd(
                                                                    index
                                                                  )
                                                                }
                                                              }
                                                            },
                                                            [
                                                              _c("i", {
                                                                class:
                                                                  _vm.btnTrans
                                                                    .delete.icon
                                                              }),
                                                              _vm._v(
                                                                "\n                                  " +
                                                                  _vm._s(
                                                                    _vm.btnTrans
                                                                      .delete
                                                                      .text
                                                                  ) +
                                                                  "\n                                "
                                                              )
                                                            ]
                                                          )
                                                        ]
                                                      )
                                                    : _vm._e()
                                                ],
                                                1
                                              )
                                            ])
                                          }
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "tr",
                                          {
                                            directives: [
                                              {
                                                name: "show",
                                                rawName: "v-show",
                                                value:
                                                  _vm.dataTable.policy_list
                                                    .length === 0,
                                                expression:
                                                  "dataTable.policy_list.length === 0"
                                              }
                                            ],
                                            staticClass: "text-center"
                                          },
                                          [
                                            _c(
                                              "td",
                                              { attrs: { colspan: "9" } },
                                              [_vm._v("ไม่มีข้อมูล")]
                                            )
                                          ]
                                        )
                                      ],
                                      2
                                    ),
                                    _vm._v(" "),
                                    _c("tfoot")
                                  ]
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
                          class: _vm.btnTrans.save.class + " btn-lg tw-w-25",
                          attrs: { type: "button" },
                          on: {
                            click: function($event) {
                              $event.preventDefault()
                              return _vm.submitModal()
                            }
                          }
                        },
                        [
                          _c("i", { class: _vm.btnTrans.save.icon }),
                          _vm._v(
                            "\n                " +
                              _vm._s(_vm.btnTrans.save.text) +
                              "\n              "
                          )
                        ]
                      )
                    ])
                  ])
                ])
              ]
            )
          ])
        : _vm._e()
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy-group/lovPolicy.vue?vue&type=template&id=ccbc036a&":
/*!**********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/settings/policy-group/lovPolicy.vue?vue&type=template&id=ccbc036a& ***!
  \**********************************************************************************************************************************************************************************************************************************************/
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
            placeholder: "กรมธรรม์ชุดที่",
            name: _vm.name,
            loading: _vm.loading,
            remote: "",
            clearable: true,
            filterable: "",
            size: _vm.size
          },
          on: { change: _vm.change },
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
                data.policy_set_number + " : " + data.policy_set_description,
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



/***/ })

}]);