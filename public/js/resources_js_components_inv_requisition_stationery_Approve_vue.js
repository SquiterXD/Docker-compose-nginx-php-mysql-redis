(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_inv_requisition_stationery_Approve_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/Approve.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/Approve.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _ModalSelectLotComponent_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalSelectLotComponent.vue */ "./resources/js/components/inv/requisition_stationery/ModalSelectLotComponent.vue");
function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
    ModalSelectLotComponent: _ModalSelectLotComponent_vue__WEBPACK_IMPORTED_MODULE_1__.default
  },
  props: ["issueHeader", "lookupValues", "user"],
  data: function data() {
    var _this$issueHeader, _this$issueHeader2, _this$issueHeader3, _this$issueHeader4, _this$issueHeader5, _this$issueHeader6, _this$issueHeader7, _this$issueHeader8, _this$issueHeader9, _this$issueHeader10, _this$issueHeader11, _this$issueHeader12, _this$issueHeader13, _this$issueHeader14, _this$issueHeader15, _this$issueHeader16, _this$issueHeader17, _this$issueHeader18, _this$issueHeader19, _this$user, _this$issueHeader20, _this$issueHeader21, _this$issueHeader21$c;

    return {
      selectedLot: [],
      issueApproveDetails: [],
      onhand_quantity: "",
      form: {
        coaDeptCode: ((_this$issueHeader = this.issueHeader) === null || _this$issueHeader === void 0 ? void 0 : _this$issueHeader.coa_dept_code) || "",
        organization_code: ((_this$issueHeader2 = this.issueHeader) === null || _this$issueHeader2 === void 0 ? void 0 : _this$issueHeader2.issue_program_profile_v.organization_code) || "",
        organization_name: ((_this$issueHeader3 = this.issueHeader) === null || _this$issueHeader3 === void 0 ? void 0 : _this$issueHeader3.organization_units.name) || "",
        subinventory_code: ((_this$issueHeader4 = this.issueHeader) === null || _this$issueHeader4 === void 0 ? void 0 : _this$issueHeader4.secondary_inventory.secondary_inventory_name) || "",
        subinventory_name: ((_this$issueHeader5 = this.issueHeader) === null || _this$issueHeader5 === void 0 ? void 0 : _this$issueHeader5.secondary_inventory.description) || "",
        organization_id: ((_this$issueHeader6 = this.issueHeader) === null || _this$issueHeader6 === void 0 ? void 0 : _this$issueHeader6.organization_id) || "",
        issue_header_id: ((_this$issueHeader7 = this.issueHeader) === null || _this$issueHeader7 === void 0 ? void 0 : _this$issueHeader7.issue_header_id) || "",
        issue_number: ((_this$issueHeader8 = this.issueHeader) === null || _this$issueHeader8 === void 0 ? void 0 : _this$issueHeader8.issue_number) || "",
        cost_center: ((_this$issueHeader9 = this.issueHeader) === null || _this$issueHeader9 === void 0 ? void 0 : _this$issueHeader9.acc_segment4) || "",
        transaction_date: this.issueHeader ? moment__WEBPACK_IMPORTED_MODULE_0___default()(this.issueHeader.transaction_date).add(543, "year").format("DD/MM/YYYY") : moment__WEBPACK_IMPORTED_MODULE_0___default()().add(543, "year").format("DD/MM/YYYY"),
        created_at: this.issueHeader ? moment__WEBPACK_IMPORTED_MODULE_0___default()(this.issueHeader.created_at).add(543, "year").format("DD/MM/YYYY") : moment__WEBPACK_IMPORTED_MODULE_0___default()().add(543, "year").format("DD/MM/YYYY"),
        creation_date: this.issueHeader ? moment__WEBPACK_IMPORTED_MODULE_0___default()(this.issueHeader.creation_date).add(543, "year").format("DD/MM/YYYY") : moment__WEBPACK_IMPORTED_MODULE_0___default()().add(543, "year").format("DD/MM/YYYY"),
        inventory_item_id: ((_this$issueHeader10 = this.issueHeader) === null || _this$issueHeader10 === void 0 ? void 0 : _this$issueHeader10.inventory_item_id) || "",
        description: ((_this$issueHeader11 = this.issueHeader) === null || _this$issueHeader11 === void 0 ? void 0 : _this$issueHeader11.description) || "",
        gl_alias_name: ((_this$issueHeader12 = this.issueHeader) === null || _this$issueHeader12 === void 0 ? void 0 : _this$issueHeader12.gl_alias_name) || "",
        issue_status: ((_this$issueHeader13 = this.issueHeader) === null || _this$issueHeader13 === void 0 ? void 0 : _this$issueHeader13.issue_status) == 'WAITING' ? "รอตัดจ่าย" : ((_this$issueHeader14 = this.issueHeader) === null || _this$issueHeader14 === void 0 ? void 0 : _this$issueHeader14.issue_status) == 'APPROVED' ? "ตัดจ่ายสำเร็จ" : ((_this$issueHeader15 = this.issueHeader) === null || _this$issueHeader15 === void 0 ? void 0 : _this$issueHeader15.issue_status) == 'INPROCESS' ? "INPROCESS" : ((_this$issueHeader16 = this.issueHeader) === null || _this$issueHeader16 === void 0 ? void 0 : _this$issueHeader16.issue_status) == 'CANCELLED' ? "ยกเลิก" : ((_this$issueHeader17 = this.issueHeader) === null || _this$issueHeader17 === void 0 ? void 0 : _this$issueHeader17.issue_status) == 'RETURN' ? "ยกเลิก" : ((_this$issueHeader18 = this.issueHeader) === null || _this$issueHeader18 === void 0 ? void 0 : _this$issueHeader18.issue_status) == 'DRAFT' ? "ร่างรายการเบิก" : "รอตัดจ่าย",
        items: ((_this$issueHeader19 = this.issueHeader) === null || _this$issueHeader19 === void 0 ? void 0 : _this$issueHeader19.details.map(function (detail) {
          var data = _objectSpread(_objectSpread(_objectSpread({}, detail), {
            item: detail.inventory_item.segment1
          }), {
            primary_unit_of_measure: detail.inventory_item.primary_unit_of_measure
          });

          return data;
        })) || [],
        lot_number: "",
        locator: "",
        locator_id: ""
      },
      username: ((_this$user = this.user) === null || _this$user === void 0 ? void 0 : _this$user.username) || "",
      allowed_status: 'N',
      cancel_date: (_this$issueHeader20 = this.issueHeader) !== null && _this$issueHeader20 !== void 0 && _this$issueHeader20.cancel_date ? moment__WEBPACK_IMPORTED_MODULE_0___default()(this.issueHeader.cancel_date).format("DD/MM/YYYY") : "",
      cancel_username: ((_this$issueHeader21 = this.issueHeader) === null || _this$issueHeader21 === void 0 ? void 0 : (_this$issueHeader21$c = _this$issueHeader21.cancel_user) === null || _this$issueHeader21$c === void 0 ? void 0 : _this$issueHeader21$c.username) || "",
      cancel_name: "",
      loading: false
    };
  },
  created: function created() {
    this.getMasterData();
  },
  mounted: function mounted() {
    var _this = this;

    var allowedUser = this.lookupValues.find(function (user) {
      return user.meaning == _this.username;
    });

    if (allowedUser) {
      this.allowed_status = 'Y';
    }

    var cancelUser = this.lookupValues.find(function (value) {
      return value.meaning == _this.cancel_username;
    });

    if (cancelUser) {
      this.cancel_name = cancelUser.description;
    }
  },
  watch: {},
  methods: {
    getMasterData: function getMasterData() {
      this.getIssueApproveDetails();
    },
    getIssueApproveDetails: function getIssueApproveDetails() {
      var _this2 = this;

      axios.get("/inv/issue_approve_detail").then(function (response) {
        _this2.issueApproveDetails = response.data;
      })["catch"](function (err) {
        console.log("error get car fuels");
      });
    },
    approve: function approve() {
      var _this3 = this;

      this.loading = true;

      var _loop = function _loop(index) {
        if (parseInt(_this3.form.items[index].transaction_quantity) > parseInt(_this3.form.items[index].onhand_quantity)) {
          alert("จำนวนรายการสินค้า " + _this3.form.items[index].description + " ที่ขอเบิกมีมากกว่าจำนวนคงเหลือ");
          _this3.loading = false;
          return {
            v: void 0
          };
        }

        var issueApproveDetails = _this3.issueApproveDetails.find(function (detail) {
          return detail.issue_detail_id == _this3.form.items[index].issue_detail_id;
        });

        if (!issueApproveDetails) {
          return {
            v: alert("กรุณาเลือก lot number ของ " + _this3.form.items[index].description)
          };
        }
      };

      for (var index = 0; index < this.form.items.length; index++) {
        var _ret = _loop(index);

        if (_typeof(_ret) === "object") return _ret.v;
      }

      if (confirm("อนุมัติการเบิกจ่ายเครื่องเขียน ?")) {
        this.loading = true;
        axios.patch("/inv/requisition_stationery/".concat(this.form.issue_header_id, "/approve")).then(function (res) {
          _this3.loading = true;

          _this3.$notify({
            title: 'Success',
            message: 'Successfully',
            type: 'success'
          });

          window.location.reload();
        })["catch"](function (err) {
          _this3.loading = false;

          if (err.response.status == 403) {
            _this3.$notify.error({
              title: 'Error',
              message: err.response.data.msg,
              duration: 4500
            });
          }

          var errorMessage = _this3.$formatErrorMessage(error);

          alert(errorMessage);
        });
      }
    },
    getCtReport: function getCtReport() {
      window.location.replace("/inv/requisition_stationery/".concat(this.form.issue_header_id, "/ct-web-stationery-pdf"));
    },
    totalLotNumber: function totalLotNumber(lotOnhand) {
      var sum = 0;
      lotOnhand.forEach(function (item) {
        sum += parseInt(item.on_hand);
      });
      return sum;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/ModalSelectLotComponent.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/ModalSelectLotComponent.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: {
    lotOnhands: Array,
    index: Number,
    item: Object,
    subinventoryCode: String
  },
  data: function data() {
    var _this = this;

    return {
      issueApproveDetails: [],
      issue_detail_id: this.item.issue_detail_id,
      formApprovalItems: this.lotOnhands.map(function (lotOnhand) {
        return {
          issue_detail_id: _this.item.issue_detail_id,
          inventory_item_id: lotOnhand.inventory_item_id,
          subinventory_code: lotOnhand.subinventory_code,
          locator: lotOnhand.locator,
          lot_number: lotOnhand.lot_number,
          on_hand: lotOnhand.on_hand,
          quantity: 0
        };
      }),
      loading: false
    };
  },
  mounted: function mounted() {
    var _this2 = this;

    this.formApprovalItems = this.formApprovalItems.filter(function (i) {
      return i.subinventory_code == _this2.subinventoryCode;
    });
  },
  created: function created() {},
  methods: {
    save: function save() {
      var _this3 = this;

      this.loading = true;
      var issueApproveDetails = this.formApprovalItems.map(function (detail) {
        var data = _objectSpread(_objectSpread({}, detail), {
          item_transaction_quantity: _this3.item.transaction_quantity
        });

        return data;
      });
      var sumQuantity = issueApproveDetails.reduce(function (sum, item) {
        return sum + item.quantity;
      }, 0);

      for (var index = 0; index < issueApproveDetails.length; index++) {
        if (issueApproveDetails[index].on_hand < issueApproveDetails[index].quantity) {
          return alert('จำนวนคงเหลือไม่พอต่อการเบิก');
        }

        if (sumQuantity < issueApproveDetails[index].item_transaction_quantity) {
          return alert('ระบุจำนวนน้อยกว่าจำนวนที่ขอเบิก');
        }

        if (sumQuantity > issueApproveDetails[index].item_transaction_quantity) {
          return alert('ระบุจำนวนมากกว่าจำนวนที่ขอเบิก');
        }
      }

      axios.post("/inv/issue_approve_detail", {
        formApprovalItems: this.formApprovalItems,
        issueDetailId: this.issue_detail_id
      }).then(function (res) {
        _this3.loading = true;
        window.location.reload();
      })["catch"](function (err) {
        _this3.loading = false;

        var errorMessage = _this3.$formatErrorMessage(error);

        alert(errorMessage);
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/Approve.vue?vue&type=style&index=0&id=6b363642&scoped=true&lang=css&":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/Approve.vue?vue&type=style&index=0&id=6b363642&scoped=true&lang=css& ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, ".el-select-dropdown__item[data-v-6b363642] {\n  font-size: 12px;\n}\n.table td[data-v-6b363642], .table th[data-v-6b363642] {\n  padding: .75rem;\n  vertical-align: middle;\n  border-top: 1px solid #dee2e6;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/ModalSelectLotComponent.vue?vue&type=style&index=0&lang=css&":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/ModalSelectLotComponent.vue?vue&type=style&index=0&lang=css& ***!
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
___CSS_LOADER_EXPORT___.push([module.id, ".el-input-number--mini {\n  width: 90px;\n  line-height: 26px;\n}\n.table-select-lot-number {\n  margin: 0px;\n}\n.modal-body-select-lot-number {\n  padding: 0;\n}\n.modal-header-select-lot-number {\n  align-items: center;\n}\n.modal-footer-select-lot-number {\n  padding: 10px;\n}\n.modal-dialog-select-lot-number {\n  max-width: 500px;\n  margin: 1.75rem auto;\n}\nbody.modal-open {\n  overflow: scroll !important;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/Approve.vue?vue&type=style&index=0&id=6b363642&scoped=true&lang=css&":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/Approve.vue?vue&type=style&index=0&id=6b363642&scoped=true&lang=css& ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Approve_vue_vue_type_style_index_0_id_6b363642_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Approve.vue?vue&type=style&index=0&id=6b363642&scoped=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/Approve.vue?vue&type=style&index=0&id=6b363642&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Approve_vue_vue_type_style_index_0_id_6b363642_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Approve_vue_vue_type_style_index_0_id_6b363642_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/ModalSelectLotComponent.vue?vue&type=style&index=0&lang=css&":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/ModalSelectLotComponent.vue?vue&type=style&index=0&lang=css& ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSelectLotComponent_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSelectLotComponent.vue?vue&type=style&index=0&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/ModalSelectLotComponent.vue?vue&type=style&index=0&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSelectLotComponent_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSelectLotComponent_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/components/inv/requisition_stationery/Approve.vue":
/*!************************************************************************!*\
  !*** ./resources/js/components/inv/requisition_stationery/Approve.vue ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Approve_vue_vue_type_template_id_6b363642_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Approve.vue?vue&type=template&id=6b363642&scoped=true& */ "./resources/js/components/inv/requisition_stationery/Approve.vue?vue&type=template&id=6b363642&scoped=true&");
/* harmony import */ var _Approve_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Approve.vue?vue&type=script&lang=js& */ "./resources/js/components/inv/requisition_stationery/Approve.vue?vue&type=script&lang=js&");
/* harmony import */ var _Approve_vue_vue_type_style_index_0_id_6b363642_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Approve.vue?vue&type=style&index=0&id=6b363642&scoped=true&lang=css& */ "./resources/js/components/inv/requisition_stationery/Approve.vue?vue&type=style&index=0&id=6b363642&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _Approve_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Approve_vue_vue_type_template_id_6b363642_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _Approve_vue_vue_type_template_id_6b363642_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "6b363642",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/inv/requisition_stationery/Approve.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/inv/requisition_stationery/ModalSelectLotComponent.vue":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/inv/requisition_stationery/ModalSelectLotComponent.vue ***!
  \****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _ModalSelectLotComponent_vue_vue_type_template_id_df54e36c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ModalSelectLotComponent.vue?vue&type=template&id=df54e36c& */ "./resources/js/components/inv/requisition_stationery/ModalSelectLotComponent.vue?vue&type=template&id=df54e36c&");
/* harmony import */ var _ModalSelectLotComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ModalSelectLotComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/inv/requisition_stationery/ModalSelectLotComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _ModalSelectLotComponent_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ModalSelectLotComponent.vue?vue&type=style&index=0&lang=css& */ "./resources/js/components/inv/requisition_stationery/ModalSelectLotComponent.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _ModalSelectLotComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _ModalSelectLotComponent_vue_vue_type_template_id_df54e36c___WEBPACK_IMPORTED_MODULE_0__.render,
  _ModalSelectLotComponent_vue_vue_type_template_id_df54e36c___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/inv/requisition_stationery/ModalSelectLotComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/inv/requisition_stationery/Approve.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************!*\
  !*** ./resources/js/components/inv/requisition_stationery/Approve.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Approve_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Approve.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/Approve.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Approve_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/inv/requisition_stationery/ModalSelectLotComponent.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************!*\
  !*** ./resources/js/components/inv/requisition_stationery/ModalSelectLotComponent.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSelectLotComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSelectLotComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/ModalSelectLotComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSelectLotComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/inv/requisition_stationery/Approve.vue?vue&type=style&index=0&id=6b363642&scoped=true&lang=css&":
/*!*********************************************************************************************************************************!*\
  !*** ./resources/js/components/inv/requisition_stationery/Approve.vue?vue&type=style&index=0&id=6b363642&scoped=true&lang=css& ***!
  \*********************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Approve_vue_vue_type_style_index_0_id_6b363642_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Approve.vue?vue&type=style&index=0&id=6b363642&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/Approve.vue?vue&type=style&index=0&id=6b363642&scoped=true&lang=css&");


/***/ }),

/***/ "./resources/js/components/inv/requisition_stationery/ModalSelectLotComponent.vue?vue&type=style&index=0&lang=css&":
/*!*************************************************************************************************************************!*\
  !*** ./resources/js/components/inv/requisition_stationery/ModalSelectLotComponent.vue?vue&type=style&index=0&lang=css& ***!
  \*************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSelectLotComponent_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSelectLotComponent.vue?vue&type=style&index=0&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/ModalSelectLotComponent.vue?vue&type=style&index=0&lang=css&");


/***/ }),

/***/ "./resources/js/components/inv/requisition_stationery/Approve.vue?vue&type=template&id=6b363642&scoped=true&":
/*!*******************************************************************************************************************!*\
  !*** ./resources/js/components/inv/requisition_stationery/Approve.vue?vue&type=template&id=6b363642&scoped=true& ***!
  \*******************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Approve_vue_vue_type_template_id_6b363642_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Approve_vue_vue_type_template_id_6b363642_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Approve_vue_vue_type_template_id_6b363642_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Approve.vue?vue&type=template&id=6b363642&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/Approve.vue?vue&type=template&id=6b363642&scoped=true&");


/***/ }),

/***/ "./resources/js/components/inv/requisition_stationery/ModalSelectLotComponent.vue?vue&type=template&id=df54e36c&":
/*!***********************************************************************************************************************!*\
  !*** ./resources/js/components/inv/requisition_stationery/ModalSelectLotComponent.vue?vue&type=template&id=df54e36c& ***!
  \***********************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSelectLotComponent_vue_vue_type_template_id_df54e36c___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSelectLotComponent_vue_vue_type_template_id_df54e36c___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ModalSelectLotComponent_vue_vue_type_template_id_df54e36c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ModalSelectLotComponent.vue?vue&type=template&id=df54e36c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/ModalSelectLotComponent.vue?vue&type=template&id=df54e36c&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/Approve.vue?vue&type=template&id=6b363642&scoped=true&":
/*!**********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/Approve.vue?vue&type=template&id=6b363642&scoped=true& ***!
  \**********************************************************************************************************************************************************************************************************************************************************/
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
      ],
      staticClass: "container row"
    },
    [
      _c("div", { staticClass: "col-lg-12" }, [
        _c("div", { staticClass: "ibox" }, [
          _c("div", { staticClass: "ibox-content" }, [
            _c("div", { staticClass: "container" }, [
              _c("div", { staticClass: "row justify-content-center" }, [
                _c("div", { staticClass: "col-md-6" }, [
                  _c("div", { staticClass: "form-group row mb-0" }, [
                    _c("label", { staticClass: "col-md-4 col-form-label" }, [
                      _vm._v("เลขที่ใบเบิก")
                    ]),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-md-8 d-flex align-items-center" },
                      [
                        _vm._v(
                          "\n                                    " +
                            _vm._s(this.form.issue_number) +
                            "\n                                "
                        )
                      ]
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "form-group row mb-0" }, [
                    _c("label", { staticClass: "col-md-4 col-form-label" }, [
                      _vm._v("รายละเอียดขอเบิก")
                    ]),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-md-8 d-flex align-items-center" },
                      [
                        _vm._v(
                          "\n                                    " +
                            _vm._s(this.form.description) +
                            "\n                                "
                        )
                      ]
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "form-group row mb-0" }, [
                    _c("label", { staticClass: "col-md-4 col-form-label" }, [
                      _vm._v("สถานะ")
                    ]),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-md-3 d-flex align-items-center" },
                      [
                        _vm._v(
                          "\n                                    " +
                            _vm._s(this.form.issue_status) +
                            "\n                                "
                        )
                      ]
                    ),
                    _vm._v(" "),
                    this.issueHeader.cancel_date
                      ? _c(
                          "label",
                          { staticClass: "col-md-1 col-form-label" },
                          [_vm._v("โดย")]
                        )
                      : _vm._e(),
                    _vm._v(" "),
                    this.issueHeader.cancel_date
                      ? _c(
                          "div",
                          { staticClass: "col-md-4 d-flex align-items-center" },
                          [
                            _vm._v(
                              "\n                                    " +
                                _vm._s(this.cancel_username) +
                                " - " +
                                _vm._s(this.cancel_name) +
                                "\n                                "
                            )
                          ]
                        )
                      : _vm._e()
                  ]),
                  _vm._v(" "),
                  this.issueHeader.cancel_date
                    ? _c("div", { staticClass: "form-group row mb-0" }, [
                        _c(
                          "label",
                          { staticClass: "col-md-4 col-form-label" },
                          [_vm._v("รายละเอียดการยกเลิก")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "col-md-8 d-flex align-items-center" },
                          [
                            _vm._v(
                              "\n                                    " +
                                _vm._s(this.issueHeader.reason_name) +
                                "\n                                "
                            )
                          ]
                        )
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  this.issueHeader.cancel_date
                    ? _c("div", { staticClass: "form-group row mb-0" }, [
                        _c(
                          "label",
                          { staticClass: "col-md-4 col-form-label" },
                          [_vm._v("วันที่ยกเลิกรายการ")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "col-md-8 d-flex align-items-center" },
                          [
                            _vm._v(
                              "\n                                    " +
                                _vm._s(this.cancel_date) +
                                "\n                                "
                            )
                          ]
                        )
                      ])
                    : _vm._e()
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-6" }, [
                  _c("div", { staticClass: "form-group row mb-0" }, [
                    _c("label", { staticClass: "col-md-3 col-form-label" }, [
                      _vm._v("วันที่สร้างรายการ")
                    ]),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-md-9 d-flex align-items-center" },
                      [
                        _vm._v(
                          "\n                                    " +
                            _vm._s(this.form.creation_date) +
                            "\n                                "
                        )
                      ]
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "form-group row mb-0" }, [
                    _c("label", { staticClass: "col-md-3 col-form-label" }, [
                      _vm._v("หน่วยงานผู้ขอเบิก")
                    ]),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-md-9 d-flex align-items-center" },
                      [
                        _vm._v(
                          "\n                                    " +
                            _vm._s(this.form.coaDeptCode.department_code) +
                            " - " +
                            _vm._s(this.form.coaDeptCode.description) +
                            "\n                                "
                        )
                      ]
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "form-group row mb-0" }, [
                    _c("label", { staticClass: "col-md-3 col-form-label" }, [
                      _vm._v("Cost Center")
                    ]),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-md-9 d-flex align-items-center" },
                      [
                        _vm._v(
                          "\n                                    " +
                            _vm._s(this.form.cost_center) +
                            "\n                                "
                        )
                      ]
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "form-group row mb-0" }, [
                    _c("label", { staticClass: "col-md-3 col-form-label" }, [
                      _vm._v("Org")
                    ]),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-md-9 d-flex align-items-center" },
                      [
                        _vm._v(
                          "\n                                    " +
                            _vm._s(this.form.organization_code) +
                            " - " +
                            _vm._s(this.form.organization_name) +
                            "\n                                "
                        )
                      ]
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "form-group row mb-0" }, [
                    _c("label", { staticClass: "col-md-3 col-form-label" }, [
                      _vm._v("Subinventory")
                    ]),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-md-9 d-flex align-items-center" },
                      [
                        _vm._v(
                          "\n                                    " +
                            _vm._s(this.form.subinventory_code) +
                            " - " +
                            _vm._s(this.form.subinventory_name) +
                            "\n                                "
                        )
                      ]
                    )
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "form-group row" }, [
                    _c("label", { staticClass: "col-md-3 col-form-label" }, [
                      _vm._v("รหัสบัญชี")
                    ]),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-md-9 d-flex align-items-center" },
                      [
                        _vm._v(
                          "\n                                    " +
                            _vm._s(this.form.gl_alias_name) +
                            "\n                                "
                        )
                      ]
                    )
                  ])
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-md-12 p-0 mt-3" }, [
                  _c("table", { staticClass: "table bordered" }, [
                    _c("thead", [
                      _c("tr", [
                        _c("th", [_vm._v("#")]),
                        _vm._v(" "),
                        _c("th", [_vm._v("Item")]),
                        _vm._v(" "),
                        _c("th", [_vm._v("รายละเอียดสินค้า")]),
                        _vm._v(" "),
                        _vm.issueHeader.issue_status == "WAITING" &&
                        _vm.allowed_status == "Y"
                          ? _c("th")
                          : _vm._e(),
                        _vm._v(" "),
                        _vm.issueHeader.issue_status == "UPDATE" &&
                        _vm.allowed_status == "Y"
                          ? _c("th")
                          : _vm._e(),
                        _vm._v(" "),
                        _c(
                          "th",
                          { staticClass: "text-center tw-whitespace-nowrap" },
                          [_vm._v("จำนวนคงเหลือ")]
                        ),
                        _vm._v(" "),
                        _c(
                          "th",
                          { staticClass: "text-center tw-whitespace-nowrap" },
                          [_vm._v("จำนวนที่ขอเบิก")]
                        ),
                        _vm._v(" "),
                        _c(
                          "th",
                          { staticClass: "text-center tw-whitespace-nowrap" },
                          [_vm._v("หน่วยนับ")]
                        ),
                        _vm._v(" "),
                        _c("th")
                      ])
                    ]),
                    _vm._v(" "),
                    _c(
                      "tbody",
                      _vm._l(_vm.form.items, function(item, index) {
                        return _c("tr", { key: index }, [
                          _c("td", { staticClass: "tw-text-xs" }, [
                            _vm._v(_vm._s(item.line_no))
                          ]),
                          _vm._v(" "),
                          _c("td", { staticClass: "tw-text-xs" }, [
                            _vm._v(_vm._s(item.item))
                          ]),
                          _vm._v(" "),
                          _c("td", { staticClass: "tw-text-xs" }, [
                            _vm._v(_vm._s(item.description))
                          ]),
                          _vm._v(" "),
                          _vm.issueHeader.issue_status == "WAITING" &&
                          _vm.allowed_status == "Y"
                            ? _c(
                                "td",
                                { staticClass: "tw-whitespace-nowrap" },
                                [
                                  _c("ModalSelectLotComponent", {
                                    attrs: {
                                      "subinventory-code":
                                        _vm.form.subinventory_code,
                                      item: item,
                                      "lot-onhands": item.lot_onhand,
                                      index: index
                                    }
                                  }),
                                  _vm._v(" "),
                                  _vm._l(_vm.issueApproveDetails, function(
                                    issueApproveDetail
                                  ) {
                                    return _c(
                                      "div",
                                      { key: issueApproveDetail.id },
                                      [
                                        issueApproveDetail["issue_detail_id"] ==
                                        item.issue_detail_id
                                          ? _c("div", [
                                              _c(
                                                "span",
                                                { staticClass: "tw-text-xs" },
                                                [
                                                  _c("b", [
                                                    _vm._v("ตำแหน่ง: ")
                                                  ]),
                                                  _vm._v(
                                                    " " +
                                                      _vm._s(
                                                        issueApproveDetail[
                                                          "locator"
                                                        ]
                                                      ) +
                                                      " "
                                                  ),
                                                  _c("br"),
                                                  _vm._v(" "),
                                                  _c("b", [_vm._v("ล็อต: ")]),
                                                  _vm._v(
                                                    " " +
                                                      _vm._s(
                                                        issueApproveDetail[
                                                          "lot_number"
                                                        ]
                                                      ) +
                                                      " "
                                                  ),
                                                  _c("br"),
                                                  _vm._v(" "),
                                                  _c("b", [_vm._v("จำนวน: ")]),
                                                  _vm._v(
                                                    " " +
                                                      _vm._s(
                                                        parseFloat(
                                                          issueApproveDetail[
                                                            "quantity"
                                                          ]
                                                        )
                                                      ) +
                                                      " "
                                                  ),
                                                  _c("br"),
                                                  _vm._v(" "),
                                                  _c("br")
                                                ]
                                              )
                                            ])
                                          : _vm._e()
                                      ]
                                    )
                                  })
                                ],
                                2
                              )
                            : _vm._e(),
                          _vm._v(" "),
                          _vm.issueHeader.issue_status == "UPDATE" &&
                          _vm.allowed_status == "Y"
                            ? _c(
                                "td",
                                [
                                  _c("ModalSelectLotComponent", {
                                    attrs: {
                                      "subinventory-code":
                                        _vm.form.subinventory_code,
                                      item: item,
                                      "lot-onhands": item.lot_onhand,
                                      index: index
                                    }
                                  }),
                                  _vm._v(" "),
                                  _vm._l(_vm.issueApproveDetails, function(
                                    issueApproveDetail
                                  ) {
                                    return _c(
                                      "div",
                                      { key: issueApproveDetail.id },
                                      [
                                        issueApproveDetail["issue_detail_id"] ==
                                        item.issue_detail_id
                                          ? _c("div", [
                                              _c(
                                                "span",
                                                { staticClass: "tw-text-xs" },
                                                [
                                                  _c("b", [
                                                    _vm._v("ตำแหน่ง: ")
                                                  ]),
                                                  _vm._v(
                                                    " " +
                                                      _vm._s(
                                                        issueApproveDetail[
                                                          "locator"
                                                        ]
                                                      ) +
                                                      " "
                                                  ),
                                                  _c("br"),
                                                  _vm._v(" "),
                                                  _c("b", [_vm._v("ล็อต: ")]),
                                                  _vm._v(
                                                    " " +
                                                      _vm._s(
                                                        issueApproveDetail[
                                                          "lot_number"
                                                        ]
                                                      ) +
                                                      " "
                                                  ),
                                                  _c("br"),
                                                  _vm._v(" "),
                                                  _c("b", [_vm._v("จำนวน: ")]),
                                                  _vm._v(
                                                    " " +
                                                      _vm._s(
                                                        parseFloat(
                                                          issueApproveDetail[
                                                            "quantity"
                                                          ]
                                                        )
                                                      ) +
                                                      " "
                                                  ),
                                                  _c("br"),
                                                  _vm._v(" "),
                                                  _c("br")
                                                ]
                                              )
                                            ])
                                          : _vm._e()
                                      ]
                                    )
                                  })
                                ],
                                2
                              )
                            : _vm._e(),
                          _vm._v(" "),
                          _c("td", { staticClass: "tw-text-xs text-center" }, [
                            _vm._v(_vm._s(_vm.totalLotNumber(item.lot_onhand)))
                          ]),
                          _vm._v(" "),
                          _c("td", { staticClass: "tw-text-xs text-center" }, [
                            _vm._v(_vm._s(item.transaction_quantity))
                          ]),
                          _vm._v(" "),
                          _c("td", { staticClass: "tw-text-xs" }, [
                            _vm._v(_vm._s(item.primary_unit_of_measure))
                          ]),
                          _vm._v(" "),
                          _c("td", { staticClass: "tw-text-xs" }, [
                            _vm._v(_vm._s(item.transaction_account))
                          ])
                        ])
                      }),
                      0
                    )
                  ]),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "col-md-12 text-right mt-2 p-0" },
                    [
                      _vm.issueHeader.issue_status == "WAITING"
                        ? _c(
                            "el-button",
                            {
                              staticClass: "btn-success",
                              attrs: { size: "mini", type: "success" },
                              on: { click: _vm.getCtReport }
                            },
                            [
                              _vm._v(
                                "ใบเบิกวัสดุเครื่องเขียน\n                                "
                              )
                            ]
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _vm.issueHeader.issue_status == "APPROVED"
                        ? _c(
                            "el-button",
                            {
                              staticClass: "btn-success",
                              attrs: { size: "mini", type: "success" },
                              on: { click: _vm.getCtReport }
                            },
                            [
                              _vm._v(
                                "ใบเบิกวัสดุเครื่องเขียน\n                                "
                              )
                            ]
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _vm.issueHeader.issue_status == "UPDATE"
                        ? _c(
                            "el-button",
                            {
                              staticClass: "btn-success",
                              attrs: { size: "mini", type: "success" },
                              on: { click: _vm.getCtReport }
                            },
                            [
                              _vm._v(
                                "ใบเบิกวัสดุเครื่องเขียน\n                                "
                              )
                            ]
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _vm.issueHeader.issue_status == "WAITING" &&
                      _vm.allowed_status == "Y"
                        ? _c(
                            "el-button",
                            {
                              staticClass: "btn-success",
                              attrs: { size: "mini", type: "success" },
                              on: { click: _vm.approve }
                            },
                            [
                              _vm._v(
                                "ตัดจ่าย\n                                "
                              )
                            ]
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _vm.issueHeader.issue_status == "UPDATE" &&
                      _vm.allowed_status == "Y"
                        ? _c(
                            "el-button",
                            {
                              staticClass: "btn-success",
                              attrs: { size: "mini", type: "success" },
                              on: { click: _vm.approve }
                            },
                            [
                              _vm._v(
                                "ตัดจ่าย\n                                "
                              )
                            ]
                          )
                        : _vm._e()
                    ],
                    1
                  )
                ])
              ])
            ])
          ])
        ])
      ])
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/ModalSelectLotComponent.vue?vue&type=template&id=df54e36c&":
/*!**************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/ModalSelectLotComponent.vue?vue&type=template&id=df54e36c& ***!
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
  return _c("div", [
    _c("div", { staticClass: "form-group" }, [
      _c("div", [
        _c(
          "button",
          {
            staticClass: "btn btn-sm btn-primary",
            attrs: {
              "data-toggle": "modal",
              "data-target": "#selectLotNumber" + _vm.index
            }
          },
          [_vm._v("\n                Select Lot Number\n            ")]
        )
      ])
    ]),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass: "modal fade",
        attrs: {
          id: "selectLotNumber" + _vm.index,
          tabindex: "-1",
          role: "dialog",
          "aria-labelledby": "selectLotNumberLabel",
          "aria-hidden": "true"
        }
      },
      [
        _c(
          "div",
          {
            staticClass: "modal-dialog modal-dialog-select-lot-number",
            attrs: { role: "document" }
          },
          [
            _c("div", { staticClass: "modal-content" }, [
              _vm._m(0),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "modal-body modal-body-select-lot-number" },
                [
                  _c("div", { staticClass: "card" }, [
                    _c("div", { staticClass: "card-body text-center row" }, [
                      _c(
                        "div",
                        { staticClass: "col-md-7 tw-whitespace-pre-wrap" },
                        [
                          _c("span", { staticClass: "tw-font-bold mr-3" }, [
                            _vm._v("ชื่อสินค้า")
                          ]),
                          _vm._v(
                            _vm._s(_vm.item.description) +
                              "\n                            "
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c("div", { staticClass: "col-md-5" }, [
                        _c("span", { staticClass: "tw-font-bold mr-3" }, [
                          _vm._v("จำนวน")
                        ]),
                        _vm._v(" "),
                        _c("span", { staticClass: "mr-3" }, [
                          _vm._v(_vm._s(_vm.item.transaction_quantity))
                        ]),
                        _vm._v(
                          _vm._s(_vm.item.primary_unit_of_measure) +
                            "\n                            "
                        )
                      ])
                    ])
                  ]),
                  _vm._v(" "),
                  _vm.lotOnhands.length == 0
                    ? _c("div", { staticClass: "text-center" }, [
                        _c("span", [_vm._v("จำนวนคงเหลือในคลัง : 0")])
                      ])
                    : _vm._e(),
                  _vm._v(" "),
                  _vm.lotOnhands.length != 0
                    ? _c(
                        "table",
                        { staticClass: "table table-select-lot-number" },
                        [
                          _vm._m(1),
                          _vm._v(" "),
                          _c(
                            "tbody",
                            _vm._l(_vm.formApprovalItems, function(
                              approvalItem,
                              index
                            ) {
                              return _c("tr", { key: index }, [
                                _c("td", { staticClass: "tw-text-xs" }, [
                                  _vm._v(_vm._s(approvalItem.locator))
                                ]),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  { staticClass: "tw-text-xs text-center" },
                                  [
                                    _vm._v(
                                      _vm._s(approvalItem.lot_number) +
                                        "\n                                    "
                                    ),
                                    _c("br"),
                                    _vm._v(" "),
                                    _c(
                                      "span",
                                      {
                                        staticClass: "bg-secondary text-white"
                                      },
                                      [_vm._v(_vm._s(approvalItem.on_hand))]
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "td",
                                  { staticClass: "text-right" },
                                  [
                                    _c("el-input-number", {
                                      attrs: {
                                        min: 0,
                                        "controls-position": "right",
                                        size: "mini"
                                      },
                                      model: {
                                        value: approvalItem.quantity,
                                        callback: function($$v) {
                                          _vm.$set(
                                            approvalItem,
                                            "quantity",
                                            $$v
                                          )
                                        },
                                        expression: "approvalItem.quantity"
                                      }
                                    })
                                  ],
                                  1
                                )
                              ])
                            }),
                            0
                          )
                        ]
                      )
                    : _vm._e()
                ]
              ),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "modal-footer modal-footer-select-lot-number" },
                [
                  _c(
                    "button",
                    {
                      staticClass: "btn btn-sm btn-secondary",
                      attrs: { type: "button", "data-dismiss": "modal" }
                    },
                    [_vm._v("ยกเลิก")]
                  ),
                  _vm._v(" "),
                  _c(
                    "button",
                    {
                      staticClass: "btn btn-sm btn-primary",
                      attrs: { type: "button", "data-dismiss": "modal" },
                      on: {
                        click: function($event) {
                          $event.preventDefault()
                          return _vm.save()
                        }
                      }
                    },
                    [_vm._v("ตกลง")]
                  )
                ]
              )
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
    return _c(
      "div",
      { staticClass: "modal-header modal-header-select-lot-number" },
      [
        _c(
          "div",
          { staticClass: "modal-title", attrs: { id: "selectLotNumberLabel" } },
          [_c("h3", { staticClass: "m-0" }, [_vm._v("Select Lot Number")])]
        ),
        _vm._v(" "),
        _c(
          "button",
          {
            staticClass: "close",
            attrs: {
              type: "button",
              "data-dismiss": "modal",
              "aria-label": "Close"
            }
          },
          [_c("span", { attrs: { "aria-hidden": "true" } }, [_vm._v("×")])]
        )
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", { staticClass: "text-center" }, [_vm._v("ตำแหน่ง")]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [_vm._v("Lot Number")]),
        _vm._v(" "),
        _c("th")
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);