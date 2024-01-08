(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_inv_requisition_stationery_Create_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/Create.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/Create.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["defaultIssueHeader", "copy", "department", "edit", "create"],
  data: function data() {
    var _this$defaultIssueHea, _this$defaultIssueHea2, _this$defaultIssueHea3, _this$defaultIssueHea4, _this$defaultIssueHea5, _this$defaultIssueHea6, _this$defaultIssueHea7, _this$defaultIssueHea8, _this$defaultIssueHea9, _this$defaultIssueHea10, _this$defaultIssueHea11, _this$defaultIssueHea12, _this$defaultIssueHea13, _this$defaultIssueHea14, _this$defaultIssueHea15, _this$defaultIssueHea16, _this$defaultIssueHea17, _this$defaultIssueHea18;

    return {
      coaDeptCodes: [],
      secondaryInventory: [],
      aLiasNames: [],
      systemItems: [],
      organizations: [],
      glCodeCombinations: [],
      costCenters: [],
      gl_alias_name: ((_this$defaultIssueHea = this.defaultIssueHeader) === null || _this$defaultIssueHea === void 0 ? void 0 : _this$defaultIssueHea.gl_alias_name) || "",
      account_combine: ((_this$defaultIssueHea2 = this.defaultIssueHeader) === null || _this$defaultIssueHea2 === void 0 ? void 0 : _this$defaultIssueHea2.account_code) || "",
      department_code: ((_this$defaultIssueHea3 = this.defaultIssueHeader) === null || _this$defaultIssueHea3 === void 0 ? void 0 : _this$defaultIssueHea3.department_code) || "",
      selectItem: "",
      form: {
        issue_header_id: ((_this$defaultIssueHea4 = this.defaultIssueHeader) === null || _this$defaultIssueHea4 === void 0 ? void 0 : _this$defaultIssueHea4.issue_header_id) || "",
        issue_number: ((_this$defaultIssueHea5 = this.defaultIssueHeader) === null || _this$defaultIssueHea5 === void 0 ? void 0 : _this$defaultIssueHea5.issue_number) || "",
        transaction_date: this.defaultIssueHeader ? moment__WEBPACK_IMPORTED_MODULE_1___default()(this.defaultIssueHeader.transaction_date).add(543, "year").format("DD/MM/YYYY") : moment__WEBPACK_IMPORTED_MODULE_1___default()().add(543, "year").format("DD/MM/YYYY"),
        creation_date: this.defaultIssueHeader ? moment__WEBPACK_IMPORTED_MODULE_1___default()(this.defaultIssueHeader.creation_date).add(543, "year").format("DD/MM/YYYY") : moment__WEBPACK_IMPORTED_MODULE_1___default()().add(543, "year").format("DD/MM/YYYY"),
        inventory_item_id: ((_this$defaultIssueHea6 = this.defaultIssueHeader) === null || _this$defaultIssueHea6 === void 0 ? void 0 : _this$defaultIssueHea6.inventory_item_id) || "",
        description: ((_this$defaultIssueHea7 = this.defaultIssueHeader) === null || _this$defaultIssueHea7 === void 0 ? void 0 : _this$defaultIssueHea7.description) || "",
        department_code: ((_this$defaultIssueHea8 = this.defaultIssueHeader) === null || _this$defaultIssueHea8 === void 0 ? void 0 : _this$defaultIssueHea8.department_code) || "",
        subinventory_code: ((_this$defaultIssueHea9 = this.defaultIssueHeader) === null || _this$defaultIssueHea9 === void 0 ? void 0 : _this$defaultIssueHea9.subinventory_code) || "",
        gl_alias_name: ((_this$defaultIssueHea10 = this.defaultIssueHeader) === null || _this$defaultIssueHea10 === void 0 ? void 0 : _this$defaultIssueHea10.gl_alias_name) || "",
        issue_status: ((_this$defaultIssueHea11 = this.defaultIssueHeader) === null || _this$defaultIssueHea11 === void 0 ? void 0 : _this$defaultIssueHea11.issue_status) == 'WAITING' ? "รอตัดจ่าย" : ((_this$defaultIssueHea12 = this.defaultIssueHeader) === null || _this$defaultIssueHea12 === void 0 ? void 0 : _this$defaultIssueHea12.issue_status) == 'APPROVED' ? "ตัดจ่ายสำเร็จ" : ((_this$defaultIssueHea13 = this.defaultIssueHeader) === null || _this$defaultIssueHea13 === void 0 ? void 0 : _this$defaultIssueHea13.issue_status) == 'CANCELLED' ? "ยกเลิก" : ((_this$defaultIssueHea14 = this.defaultIssueHeader) === null || _this$defaultIssueHea14 === void 0 ? void 0 : _this$defaultIssueHea14.issue_status) == 'RETURN' ? "ยกเลิก" : ((_this$defaultIssueHea15 = this.defaultIssueHeader) === null || _this$defaultIssueHea15 === void 0 ? void 0 : _this$defaultIssueHea15.issue_status) == 'DRAFT' ? "ร่างรายการเบิก" : "รอตัดจ่าย",
        account_code: "",
        organization_id: ((_this$defaultIssueHea16 = this.defaultIssueHeader) === null || _this$defaultIssueHea16 === void 0 ? void 0 : _this$defaultIssueHea16.organization_id) || "",
        items: ((_this$defaultIssueHea17 = this.defaultIssueHeader) === null || _this$defaultIssueHea17 === void 0 ? void 0 : _this$defaultIssueHea17.details.map(function (detail) {
          var data = _objectSpread(_objectSpread(_objectSpread(_objectSpread({}, detail), {
            item: detail.inventory_item.segment1
          }), {
            primary_unit_of_measure: detail.inventory_item.primary_unit_of_measure
          }), {
            item_cost: detail.transaction_cost
          });

          return data;
        })) || [],
        cost_center: ((_this$defaultIssueHea18 = this.defaultIssueHeader) === null || _this$defaultIssueHea18 === void 0 ? void 0 : _this$defaultIssueHea18.acc_segment4) || ""
      },
      loadingInput: {
        coaDeptCodes: false,
        secondaryInventory: false,
        aliasName: false,
        systemItem: false,
        organization: false,
        costCenters: false
      },
      loading: false
    };
  },
  created: function created() {
    this.getMasterData();
  },
  watch: {
    department_code: function department_code(val) {
      var _this$defaultIssueHea19, _this$defaultIssueHea20;

      this.gl_alias_name = ((_this$defaultIssueHea19 = this.defaultIssueHeader) === null || _this$defaultIssueHea19 === void 0 ? void 0 : _this$defaultIssueHea19.gl_alias_name) || "";
      this.form.gl_alias_name = this.gl_alias_name;
      this.account_combine = ((_this$defaultIssueHea20 = this.defaultIssueHeader) === null || _this$defaultIssueHea20 === void 0 ? void 0 : _this$defaultIssueHea20.account_code) || "";
      this.form.department_code = val;
      this.getCostCenters();
    },
    gl_alias_name: function gl_alias_name(val) {
      this.form.gl_alias_name = val;
      this.aliasNameOnchange();

      if (val == "") {
        return;
      }

      if (this.department === this.form.department_code) {
        this.form.department_code = this.department.department_code;
      }

      var accountArray = this.form.account_code.split('.');
      accountArray[2] = this.form.department_code;
      accountArray[3] = this.form.cost_center;
      var account_combine = accountArray.join('.');
      var selectedGlCodeCombination = this.glCodeCombinations.find(function (g) {
        return g.concatenated_segments === account_combine;
      });

      if (!selectedGlCodeCombination) {
        this.form.gl_alias_name = "";
        this.gl_alias_name = "";
        return alert("ไม่สามารถเพิ่มสินค้าได้เนื่องจากไม่มีเลขทางบัญชีนี้ในระบบ กรุณาติดต่อฝ่ายบัญชี");
      }

      this.account_combine = account_combine;

      for (var index = 0; index < this.form.items.length; index++) {
        this.form.items[index]['transaction_account'] = account_combine;
      }
    }
  },
  mounted: function mounted() {
    var _this = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
      var originalCOA;
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              if (!_this.create) {
                _context.next = 4;
                break;
              }

              _context.next = 3;
              return _this.getCOAsWithDefault(_this.department.department_code);

            case 3:
              _this.department_code = _this.department.department_code;

            case 4:
              if (!_this.edit) {
                _context.next = 9;
                break;
              }

              originalCOA = _this.defaultIssueHeader.department_code;
              _context.next = 8;
              return _this.getCOAsWithDefault(originalCOA);

            case 8:
              _this.department_code = Number(_this.defaultIssueHeader.department_code);

            case 9:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  methods: {
    indexMethod: function indexMethod(index) {
      return index + 1;
    },
    getMasterData: function getMasterData() {
      this.getAliasName();
      this.getSecondaryInventory(this.form.subinventory_code);
      this.getOrganization();
      this.getGlCodeCombination();
    },
    getItemMaster: function getItemMaster(query) {
      var _this2 = this;

      this.loadingInput.systemItem = true;
      axios.get("/inv/ajax/system_item", {
        params: {
          text: query,
          organization_id: this.form.organization_id,
          subinventory_code: this.form.subinventory_code
        }
      }).then(function (response) {
        _this2.systemItems = response.data;
      }).then(function () {
        _this2.loadingInput.systemItem = false;
      });
    },
    getAliasName: function getAliasName(query) {
      var _this3 = this;

      this.loadingInput.aliasName = true;
      axios.get("/inv/ajax/alias_name", {
        params: {
          text: query,
          prefix: "A91:จ่ายค่าเครื่องเขียน%"
        }
      }).then(function (response) {
        _this3.aLiasNames = response.data;
      })["catch"](function (err) {
        console.log("error get alias name");
      }).then(function () {
        _this3.loadingInput.aliasName = false;
      });
    },
    getCOAsWithDefault: function getCOAsWithDefault(query) {
      var _this4 = this;

      this.loadingInput.coaDeptCodes = true;
      var getByQuery = axios.get("/inv/ajax/coa_dept_code_all", {
        params: {
          text: query
        }
      });
      var getAll = axios.get("/inv/ajax/coa_dept_code_all", {});
      axios.all([getByQuery, getAll]).then(function (responses) {
        responses[0].data.map(function (i) {
          _this4.coaDeptCodes.push(i);
        });
        responses[1].data.map(function (i) {
          _this4.coaDeptCodes.push(i);
        });
      }).then(function () {
        _this4.loadingInput.coaDeptCodes = false;
      });
    },
    getCOAs: function getCOAs(query) {
      var _this5 = this;

      axios.get("/inv/ajax/coa_dept_code_all", {
        params: {
          text: query
        }
      }).then(function (response) {
        _this5.coaDeptCodes = response.data;
      }).then(function () {
        _this5.loadingInput.coaDeptCodes = false;
      });
    },
    getSecondaryInventory: function getSecondaryInventory(query) {
      var _this6 = this;

      this.loadingInput.secondaryInventory = true;
      axios.get("/inv/ajax/secondary_inventories", {
        params: {
          text: query,
          attribute3: 'Yes',
          organization_code: 'A91'
        }
      }).then(function (response) {
        _this6.secondaryInventory = response.data;
        _this6.form.subinventory_code = _this6.secondaryInventory[0].secondary_inventory_name;
      }).then(function () {
        _this6.loadingInput.secondaryInventory = false;
      });
    },
    getOrganization: function getOrganization(query) {
      var _this7 = this;

      this.loadingInput.organization = true;
      axios.get("/inv/ajax/organization_units", {
        params: {
          text: query,
          organization_code: 'A91'
        }
      }).then(function (response) {
        _this7.organizations = response.data;
        _this7.form.organization_id = _this7.organizations[0].organization_id;

        _this7.getItemMaster();
      }).then(function () {
        _this7.loadingInput.organization = false;
      });
    },
    getGlCodeCombination: function getGlCodeCombination() {
      var _this8 = this;

      axios.get("/inv/ajax/gl_code_combinations").then(function (response) {
        _this8.glCodeCombinations = response.data;
      });
    },
    getCostCenters: function getCostCenters(query) {
      var _this9 = this;

      axios.get("/inv/ajax/cost_centers", {
        params: {
          text: query,
          department_code: this.form.department_code
        }
      }).then(function (response) {
        _this9.costCenters = response.data;

        if (_this9.costCenters.length == 1) {
          _this9.form.cost_center = _this9.costCenters[0]['flex_value'];
        }
      }).then(function () {
        _this9.loadingInput.costCenters = false;
      });
      ;
    },
    deleteRow: function deleteRow(index, data) {
      data.splice(index, 1);
    },
    addRow: function addRow() {
      var _this10 = this;

      if (!this.selectItem) {
        return alert("กรุณาเลือกรายการก่อน");
      }

      var existingItem = this.form.items.find(function (i) {
        return i.item == _this10.selectItem;
      });

      if (existingItem) {
        return alert("สินค้านี้ถูกเลือกไปแล้ว");
      }

      var selectItem = this.systemItems.find(function (systemItem) {
        return systemItem.segment1 == _this10.selectItem;
      });
      this.selectItem = undefined;

      if (selectItem.onhand_quantity <= "0") {
        return alert("จำนวนคงเหลือของสินค้าเท่ากับ 0");
      }

      if (selectItem != "") {
        this.form.items.push({
          item: selectItem.segment1,
          description: selectItem.description,
          onhand_quantity: selectItem.onhand_quantity,
          transaction_quantity: "",
          primary_unit_of_measure: selectItem.primary_unit_of_measure,
          transaction_uom: selectItem.primary_uom_code,
          transaction_account: this.account_combine,
          inventory_item_id: selectItem.inventory_item_id,
          item_cost: selectItem.item_cost_type.item_cost
        });
      }
    },
    submitForm: function submitForm(status) {
      var _this11 = this;

      this.form.issue_status = status;
      this.loading = true;
      var invalidateItems = this.form.items.filter(function (item) {
        return item.transaction_quantity <= 0 || item.transaction_quantity == "";
      });

      if (invalidateItems.length > 0) {
        var _this$defaultIssueHea21, _this$defaultIssueHea22, _this$defaultIssueHea23, _this$defaultIssueHea24, _this$defaultIssueHea25;

        this.loading = false;
        this.form.issue_status = ((_this$defaultIssueHea21 = this.defaultIssueHeader) === null || _this$defaultIssueHea21 === void 0 ? void 0 : _this$defaultIssueHea21.issue_status) == 'WAITING' ? "รอตัดจ่าย" : ((_this$defaultIssueHea22 = this.defaultIssueHeader) === null || _this$defaultIssueHea22 === void 0 ? void 0 : _this$defaultIssueHea22.issue_status) == 'APPROVED' ? "ตัดจ่ายสำเร็จ" : ((_this$defaultIssueHea23 = this.defaultIssueHeader) === null || _this$defaultIssueHea23 === void 0 ? void 0 : _this$defaultIssueHea23.issue_status) == 'CANCELLED' ? "ยกเลิก" : ((_this$defaultIssueHea24 = this.defaultIssueHeader) === null || _this$defaultIssueHea24 === void 0 ? void 0 : _this$defaultIssueHea24.issue_status) == 'RETURN' ? "ยกเลิก" : ((_this$defaultIssueHea25 = this.defaultIssueHeader) === null || _this$defaultIssueHea25 === void 0 ? void 0 : _this$defaultIssueHea25.issue_status) == 'DRAFT' ? "ร่างรายการเบิก" : "รอตัดจ่าย";
        alert("ไม่สามารถระบุจำนวนติดลบ (-) หรือระบุจำนวนเท่ากับ 0 ได้");
        return;
      }

      this.form.department_code = this.form.department_code + "";

      if (status == "UPDATE") {
        for (var index = 0; index < this.form.items.length; index++) {
          if (parseInt(this.form.items[index].onhand_quantity) < parseInt(this.form.items[index].transaction_quantity)) {
            alert("จำนวนรายการสินค้า " + this.form.items[index].description + " ที่ขอเบิกมีมากกว่าจำนวนคงเหลือ");
            this.loading = false;
            return;
          }
        }

        if (confirm("บันทึกการแก้ไขรายการเบิกจ่ายเครื่องเขียน ?")) {
          axios.patch("/inv/requisition_stationery/" + this.form.issue_header_id, this.form).then(function (res) {
            _this11.loading = true;

            _this11.$notify({
              title: 'Success',
              message: 'Successfully',
              type: 'success'
            });

            window.location.replace("/inv/requisition_stationery/");
          })["catch"](function (err) {
            var errorMessage = _this11.$formatErrorMessage(error);

            alert(errorMessage);
          });
        } else {
          var _this$defaultIssueHea26, _this$defaultIssueHea27, _this$defaultIssueHea28, _this$defaultIssueHea29, _this$defaultIssueHea30;

          this.form.issue_status = ((_this$defaultIssueHea26 = this.defaultIssueHeader) === null || _this$defaultIssueHea26 === void 0 ? void 0 : _this$defaultIssueHea26.issue_status) == 'WAITING' ? "รอตัดจ่าย" : ((_this$defaultIssueHea27 = this.defaultIssueHeader) === null || _this$defaultIssueHea27 === void 0 ? void 0 : _this$defaultIssueHea27.issue_status) == 'APPROVED' ? "ตัดจ่ายสำเร็จ" : ((_this$defaultIssueHea28 = this.defaultIssueHeader) === null || _this$defaultIssueHea28 === void 0 ? void 0 : _this$defaultIssueHea28.issue_status) == 'CANCELLED' ? "ยกเลิก" : ((_this$defaultIssueHea29 = this.defaultIssueHeader) === null || _this$defaultIssueHea29 === void 0 ? void 0 : _this$defaultIssueHea29.issue_status) == 'RETURN' ? "ยกเลิก" : ((_this$defaultIssueHea30 = this.defaultIssueHeader) === null || _this$defaultIssueHea30 === void 0 ? void 0 : _this$defaultIssueHea30.issue_status) == 'DRAFT' ? "ร่างรายการเบิก" : "รอตัดจ่าย", this.loading = false;
        }
      } else if (status == "DRAFT") {
        for (var _index = 0; _index < this.form.items.length; _index++) {
          if (parseInt(this.form.items[_index].onhand_quantity) < parseInt(this.form.items[_index].transaction_quantity)) {
            alert("จำนวนรายการสินค้า " + this.form.items[_index].description + " ที่ขอเบิกมีมากกว่าจำนวนคงเหลือ");
            this.loading = false;
            return;
          }
        }

        if (confirm("บันทึกร่างรายการเบิกจ่ายเครื่องเขียน ?")) {
          axios.post("/inv/requisition_stationery", this.form).then(function (res) {
            _this11.$notify({
              title: 'Success',
              message: 'Successfully',
              type: 'success'
            });

            window.location.replace("/inv/requisition_stationery/");
          })["catch"](function (err) {
            _this11.loading = false;

            var errorMessage = _this11.$formatErrorMessage(error);

            alert(errorMessage);
          });
        } else {
          var _this$defaultIssueHea31, _this$defaultIssueHea32, _this$defaultIssueHea33, _this$defaultIssueHea34, _this$defaultIssueHea35;

          this.form.issue_status = ((_this$defaultIssueHea31 = this.defaultIssueHeader) === null || _this$defaultIssueHea31 === void 0 ? void 0 : _this$defaultIssueHea31.issue_status) == 'WAITING' ? "รอตัดจ่าย" : ((_this$defaultIssueHea32 = this.defaultIssueHeader) === null || _this$defaultIssueHea32 === void 0 ? void 0 : _this$defaultIssueHea32.issue_status) == 'APPROVED' ? "ตัดจ่ายสำเร็จ" : ((_this$defaultIssueHea33 = this.defaultIssueHeader) === null || _this$defaultIssueHea33 === void 0 ? void 0 : _this$defaultIssueHea33.issue_status) == 'CANCELLED' ? "ยกเลิก" : ((_this$defaultIssueHea34 = this.defaultIssueHeader) === null || _this$defaultIssueHea34 === void 0 ? void 0 : _this$defaultIssueHea34.issue_status) == 'RETURN' ? "ยกเลิก" : ((_this$defaultIssueHea35 = this.defaultIssueHeader) === null || _this$defaultIssueHea35 === void 0 ? void 0 : _this$defaultIssueHea35.issue_status) == 'DRAFT' ? "ร่างรายการเบิก" : "รอตัดจ่าย", this.loading = false;
        }
      } else if (status == "WAITING") {
        for (var _index2 = 0; _index2 < this.form.items.length; _index2++) {
          if (parseInt(this.form.items[_index2].onhand_quantity) < parseInt(this.form.items[_index2].transaction_quantity)) {
            alert("จำนวนรายการสินค้า " + this.form.items[_index2].description + " ที่ขอเบิกมีมากกว่าจำนวนคงเหลือ");
            this.loading = false;
            return;
          }
        }

        if (confirm("ขออนุมัติการเบิกจ่ายเครื่องเขียน ?")) {
          axios.post("/inv/requisition_stationery", this.form).then(function (res) {
            _this11.$notify({
              title: 'Success',
              message: 'Successfully',
              type: 'success'
            });

            window.location.replace("/inv/requisition_stationery/");
          })["catch"](function (err) {
            _this11.loading = false;

            var errorMessage = _this11.$formatErrorMessage(error);

            alert(errorMessage);
          });
        } else {
          var _this$defaultIssueHea36, _this$defaultIssueHea37, _this$defaultIssueHea38, _this$defaultIssueHea39, _this$defaultIssueHea40;

          this.form.issue_status = ((_this$defaultIssueHea36 = this.defaultIssueHeader) === null || _this$defaultIssueHea36 === void 0 ? void 0 : _this$defaultIssueHea36.issue_status) == 'WAITING' ? "รอตัดจ่าย" : ((_this$defaultIssueHea37 = this.defaultIssueHeader) === null || _this$defaultIssueHea37 === void 0 ? void 0 : _this$defaultIssueHea37.issue_status) == 'APPROVED' ? "ตัดจ่ายสำเร็จ" : ((_this$defaultIssueHea38 = this.defaultIssueHeader) === null || _this$defaultIssueHea38 === void 0 ? void 0 : _this$defaultIssueHea38.issue_status) == 'CANCELLED' ? "ยกเลิก" : ((_this$defaultIssueHea39 = this.defaultIssueHeader) === null || _this$defaultIssueHea39 === void 0 ? void 0 : _this$defaultIssueHea39.issue_status) == 'RETURN' ? "ยกเลิก" : ((_this$defaultIssueHea40 = this.defaultIssueHeader) === null || _this$defaultIssueHea40 === void 0 ? void 0 : _this$defaultIssueHea40.issue_status) == 'DRAFT' ? "ร่างรายการเบิก" : "รอตัดจ่าย", this.loading = false;
        }
      } else if (status == "APPROVE") {
        if (confirm("อนุมัติการเบิกจ่ายเครื่องเขียน ?")) {
          axios.patch("/inv/requisition_stationery/".concat(this.form.issue_header_id, "/approve")).then(function (res) {
            window.location.replace("/inv/requisition_stationery/");
          })["catch"](function (err) {
            _this11.loading = false;

            var errorMessage = _this11.$formatErrorMessage(error);

            alert(errorMessage);
          }).then(function () {});
        } else {
          this.loading = false;
        }
      }
    },
    aliasNameOnchange: function aliasNameOnchange() {
      var _this12 = this;

      if (this.aLiasNames.length > 0 && this.form.gl_alias_name != "") {
        var transaction_account = this.aLiasNames.find(function (aLiasName) {
          return aLiasName.alias_name == _this12.form.gl_alias_name;
        });
        this.form.account_code = transaction_account.template;
      }
    }
  },
  computed: {
    valid: function valid() {
      var isBlank = this.form.description === '' || this.form.department_code === '' || this.form.organization_id === '' || this.form.subinventory_code === '' || this.form.gl_alias_name === '' || this.form.items.length === 0;
      return !isBlank;
    },
    validDraft: function validDraft() {
      var isBlank = this.form.description === '' || this.form.department_code === '' || this.form.organization_id === '' || this.form.subinventory_code === '' || this.form.gl_alias_name === '';
      return !isBlank;
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/Create.vue?vue&type=style&index=0&id=0112b717&lang=scss&scoped=true&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/Create.vue?vue&type=style&index=0&id=0112b717&lang=scss&scoped=true& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, ".input-label[data-v-0112b717] {\n  display: inline-block;\n  width: 130px;\n}\n.btn-success[data-v-0112b717] {\n  background-color: #1ab394;\n  border-color: #1ab394;\n}", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/Create.vue?vue&type=style&index=0&id=0112b717&lang=scss&scoped=true&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/Create.vue?vue&type=style&index=0&id=0112b717&lang=scss&scoped=true& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Create_vue_vue_type_style_index_0_id_0112b717_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!../../../../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Create.vue?vue&type=style&index=0&id=0112b717&lang=scss&scoped=true& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/Create.vue?vue&type=style&index=0&id=0112b717&lang=scss&scoped=true&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Create_vue_vue_type_style_index_0_id_0112b717_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Create_vue_vue_type_style_index_0_id_0112b717_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/components/inv/requisition_stationery/Create.vue":
/*!***********************************************************************!*\
  !*** ./resources/js/components/inv/requisition_stationery/Create.vue ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Create_vue_vue_type_template_id_0112b717_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Create.vue?vue&type=template&id=0112b717&scoped=true& */ "./resources/js/components/inv/requisition_stationery/Create.vue?vue&type=template&id=0112b717&scoped=true&");
/* harmony import */ var _Create_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Create.vue?vue&type=script&lang=js& */ "./resources/js/components/inv/requisition_stationery/Create.vue?vue&type=script&lang=js&");
/* harmony import */ var _Create_vue_vue_type_style_index_0_id_0112b717_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Create.vue?vue&type=style&index=0&id=0112b717&lang=scss&scoped=true& */ "./resources/js/components/inv/requisition_stationery/Create.vue?vue&type=style&index=0&id=0112b717&lang=scss&scoped=true&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _Create_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Create_vue_vue_type_template_id_0112b717_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _Create_vue_vue_type_template_id_0112b717_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "0112b717",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/inv/requisition_stationery/Create.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/inv/requisition_stationery/Create.vue?vue&type=script&lang=js&":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/inv/requisition_stationery/Create.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Create_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Create.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/Create.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Create_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/inv/requisition_stationery/Create.vue?vue&type=style&index=0&id=0112b717&lang=scss&scoped=true&":
/*!*********************************************************************************************************************************!*\
  !*** ./resources/js/components/inv/requisition_stationery/Create.vue?vue&type=style&index=0&id=0112b717&lang=scss&scoped=true& ***!
  \*********************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_0_rules_0_use_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Create_vue_vue_type_style_index_0_id_0112b717_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!../../../../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Create.vue?vue&type=style&index=0&id=0112b717&lang=scss&scoped=true& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12[0].rules[0].use[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/Create.vue?vue&type=style&index=0&id=0112b717&lang=scss&scoped=true&");


/***/ }),

/***/ "./resources/js/components/inv/requisition_stationery/Create.vue?vue&type=template&id=0112b717&scoped=true&":
/*!******************************************************************************************************************!*\
  !*** ./resources/js/components/inv/requisition_stationery/Create.vue?vue&type=template&id=0112b717&scoped=true& ***!
  \******************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Create_vue_vue_type_template_id_0112b717_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Create_vue_vue_type_template_id_0112b717_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Create_vue_vue_type_template_id_0112b717_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Create.vue?vue&type=template&id=0112b717&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/Create.vue?vue&type=template&id=0112b717&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/Create.vue?vue&type=template&id=0112b717&scoped=true&":
/*!*********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/Create.vue?vue&type=template&id=0112b717&scoped=true& ***!
  \*********************************************************************************************************************************************************************************************************************************************************/
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
      staticClass: "container"
    },
    [
      _c(
        "div",
        { staticClass: "row justify-content-center" },
        [
          _c("div", { staticClass: "col-md-6" }, [
            _c("div", { staticClass: "form-group row" }, [
              _c("label", { staticClass: "col-md-3 col-form-label" }, [
                _vm._v("เลขที่ใบเบิก")
              ]),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-md-9" },
                [
                  _c("el-input", {
                    attrs: {
                      disabled: true,
                      placeholder: "เลขที่ใบเบิกจะถูกสร้างหลังการบันทึก",
                      disable: ""
                    },
                    model: {
                      value: _vm.form.issue_number,
                      callback: function($$v) {
                        _vm.$set(_vm.form, "issue_number", $$v)
                      },
                      expression: "form.issue_number"
                    }
                  })
                ],
                1
              )
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "form-group row" }, [
              _c("label", { staticClass: "col-md-3 col-form-label required" }, [
                _vm._v("รายละเอียดขอเบิก")
              ]),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-md-9" },
                [
                  _c("el-input", {
                    attrs: {
                      autosize: { minRows: 3, maxRows: 3 },
                      type: "textarea",
                      placeholder: "รายละเอียดขอเบิก"
                    },
                    model: {
                      value: _vm.form.description,
                      callback: function($$v) {
                        _vm.$set(_vm.form, "description", $$v)
                      },
                      expression: "form.description"
                    }
                  })
                ],
                1
              )
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "form-group row" }, [
              _c("label", { staticClass: "col-md-3 col-form-label" }, [
                _vm._v("สถานะ")
              ]),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-md-9" },
                [
                  _c("el-input", {
                    attrs: { disabled: true, placeholder: "สถานะ" },
                    model: {
                      value: _vm.form.issue_status,
                      callback: function($$v) {
                        _vm.$set(_vm.form, "issue_status", $$v)
                      },
                      expression: "form.issue_status"
                    }
                  })
                ],
                1
              )
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-6" }, [
            _c("div", { staticClass: "form-group row" }, [
              _c("label", { staticClass: "col-md-3 col-form-label" }, [
                _vm._v("วันที่สร้างรายการ")
              ]),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-md-9" },
                [
                  _c("el-input", {
                    attrs: { disabled: true, placeholder: "วันที่สร้างรายการ" },
                    model: {
                      value: _vm.form.creation_date,
                      callback: function($$v) {
                        _vm.$set(_vm.form, "creation_date", $$v)
                      },
                      expression: "form.creation_date"
                    }
                  })
                ],
                1
              )
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "form-group row" }, [
              _c("label", { staticClass: "col-md-3 col-form-label required" }, [
                _vm._v("หน่วยงานผู้ขอเบิก")
              ]),
              _vm._v(" "),
              _c(
                "div",
                {
                  directives: [
                    {
                      name: "loading",
                      rawName: "v-loading",
                      value: _vm.loadingInput.coaDeptCode,
                      expression: "loadingInput.coaDeptCode"
                    }
                  ],
                  staticClass: "col-md-9",
                  on: {
                    change: function($event) {
                      _vm.form.cost_center = ""
                    }
                  }
                },
                [
                  _c(
                    "el-select",
                    {
                      staticStyle: { width: "100%" },
                      attrs: {
                        filterable: "",
                        remote: "",
                        debounce: 2000,
                        "remote-method": _vm.getCOAs,
                        placeholder: "หน่วยงานผู้ขอเบิก",
                        loading: _vm.loadingInput.coaDeptCodes
                      },
                      model: {
                        value: _vm.department_code,
                        callback: function($$v) {
                          _vm.department_code = $$v
                        },
                        expression: "department_code"
                      }
                    },
                    _vm._l(_vm.coaDeptCodes, function(item) {
                      return _c("el-option", {
                        key: item.department_code,
                        attrs: {
                          label:
                            item.department_code + " - " + item.description,
                          value: item.department_code
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
            _c("div", { staticClass: "form-group row" }, [
              _c("label", { staticClass: "col-md-3 col-form-label required" }, [
                _vm._v("Cost Center")
              ]),
              _vm._v(" "),
              _c(
                "div",
                {
                  directives: [
                    {
                      name: "loading",
                      rawName: "v-loading",
                      value: _vm.loadingInput.costCenters,
                      expression: "loadingInput.costCenters"
                    }
                  ],
                  staticClass: "col-md-9"
                },
                [
                  _c(
                    "el-select",
                    {
                      staticStyle: { width: "100%" },
                      attrs: {
                        filterable: "",
                        remote: "",
                        debounce: 2000,
                        "remote-method": _vm.getCostCenters,
                        placeholder: "Cost Center",
                        loading: _vm.loadingInput.costCenters
                      },
                      model: {
                        value: _vm.form.cost_center,
                        callback: function($$v) {
                          _vm.$set(_vm.form, "cost_center", $$v)
                        },
                        expression: "form.cost_center"
                      }
                    },
                    _vm._l(_vm.costCenters, function(item) {
                      return _c("el-option", {
                        key: item.flex_value_id,
                        attrs: {
                          label: item.flex_value + " - " + item.description,
                          value: item.flex_value
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
            _c("div", { staticClass: "form-group row" }, [
              _c("label", { staticClass: "col-md-3 col-form-label required" }, [
                _vm._v("Org")
              ]),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-md-9" },
                [
                  _c(
                    "el-select",
                    {
                      staticStyle: { width: "100%" },
                      attrs: {
                        filterable: "",
                        remote: "",
                        debounce: 2000,
                        placeholder: "คลังสินค้า"
                      },
                      model: {
                        value: _vm.form.organization_id,
                        callback: function($$v) {
                          _vm.$set(_vm.form, "organization_id", $$v)
                        },
                        expression: "form.organization_id"
                      }
                    },
                    _vm._l(_vm.organizations, function(item, index) {
                      return _c("el-option", {
                        key: index,
                        attrs: {
                          label:
                            item.parameter.organization_code +
                            " - " +
                            item.name,
                          value: item.organization_id
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
            _c("div", { staticClass: "form-group row" }, [
              _c("label", { staticClass: "col-md-3 col-form-label required" }, [
                _vm._v("Subinventory")
              ]),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-md-9" },
                [
                  _c(
                    "el-select",
                    {
                      staticStyle: { width: "100%" },
                      attrs: {
                        filterable: "",
                        remote: "",
                        debounce: 2000,
                        "remote-method": _vm.getSecondaryInventory,
                        placeholder: "คลังสินค้าย่อย",
                        loading: _vm.loadingInput.secondaryInventory
                      },
                      model: {
                        value: _vm.form.subinventory_code,
                        callback: function($$v) {
                          _vm.$set(_vm.form, "subinventory_code", $$v)
                        },
                        expression: "form.subinventory_code"
                      }
                    },
                    _vm._l(_vm.secondaryInventory, function(item, index) {
                      return _c("el-option", {
                        key: index,
                        attrs: {
                          label:
                            item.secondary_inventory_name +
                            " - " +
                            item.description,
                          value: item.secondary_inventory_name
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
            _c("div", { staticClass: "form-group row" }, [
              _c("label", { staticClass: "col-md-3 col-form-label required" }, [
                _vm._v("รหัสบัญชี")
              ]),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "col-md-9" },
                [
                  _c(
                    "el-select",
                    {
                      staticStyle: { width: "100%" },
                      attrs: {
                        filterable: "",
                        remote: "",
                        debounce: 2000,
                        "remote-method": _vm.getAliasName,
                        placeholder: "รหัสบัญชี",
                        loading: _vm.loadingInput.aliasName,
                        change: _vm.aliasNameOnchange()
                      },
                      model: {
                        value: _vm.gl_alias_name,
                        callback: function($$v) {
                          _vm.gl_alias_name = $$v
                        },
                        expression: "gl_alias_name"
                      }
                    },
                    _vm._l(_vm.aLiasNames, function(item, index) {
                      return _c("el-option", {
                        key: index,
                        attrs: {
                          label: item.description,
                          value: item.alias_name
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
            _c("div", { staticClass: "form-group row" }, [
              _c("div", { staticClass: "col-md-9 offset-md-3" }, [
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.account_combine,
                      expression: "account_combine"
                    }
                  ],
                  staticClass: "form-control-plaintext",
                  attrs: { type: "plaintext", readonly: "" },
                  domProps: { value: _vm.account_combine },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.account_combine = $event.target.value
                    }
                  }
                })
              ])
            ])
          ]),
          _vm._v(" "),
          _c("el-divider"),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-9 mb-2" },
            [
              _c(
                "el-select",
                {
                  staticClass: "mb-2",
                  staticStyle: { width: "100%" },
                  attrs: {
                    filterable: "",
                    placeholder: "เลือกสินค้า",
                    remote: "",
                    "remote-method": _vm.getItemMaster,
                    loading: _vm.loadingInput.systemItem
                  },
                  model: {
                    value: _vm.selectItem,
                    callback: function($$v) {
                      _vm.selectItem = $$v
                    },
                    expression: "selectItem"
                  }
                },
                _vm._l(_vm.systemItems, function(item, index) {
                  return _c("el-option", {
                    key: index,
                    attrs: {
                      label: item.segment1 + " - " + item.description,
                      value: item.segment1
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
            { staticClass: "col-md-3 mb-2" },
            [
              _c(
                "el-button",
                {
                  staticClass: "btn-success",
                  staticStyle: { width: "100%" },
                  attrs: { type: "success" },
                  nativeOn: {
                    click: function($event) {
                      $event.preventDefault()
                      return _vm.addRow()
                    }
                  }
                },
                [_vm._v("Add")]
              )
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-12" },
            [
              _c(
                "el-table",
                {
                  staticStyle: { width: "100%" },
                  attrs: { border: "", data: _vm.form.items }
                },
                [
                  _c("el-table-column", {
                    attrs: {
                      "class-name": "text-center",
                      label: "Line",
                      type: "index",
                      width: "60",
                      index: _vm.indexMethod
                    }
                  }),
                  _vm._v(" "),
                  _c("el-table-column", {
                    attrs: { prop: "item", label: "Item", width: "120" }
                  }),
                  _vm._v(" "),
                  _c("el-table-column", {
                    attrs: { prop: "description", label: "รายละเอียดสินค้า" }
                  }),
                  _vm._v(" "),
                  _c("el-table-column", {
                    attrs: {
                      "class-name": "text-center",
                      prop: "onhand_quantity",
                      label: "จำนวนคงเหลือ",
                      width: "150"
                    }
                  }),
                  _vm._v(" "),
                  _c("el-table-column", {
                    attrs: {
                      prop: "transaction_quantity",
                      label: "จำนวนที่ขอเบิก",
                      width: "120"
                    },
                    scopedSlots: _vm._u([
                      {
                        key: "default",
                        fn: function(scope) {
                          return [
                            _c("el-input", {
                              attrs: {
                                type: "number",
                                placeholder: "จำนวนที่ขอเบิก",
                                min: "1",
                                required: ""
                              },
                              model: {
                                value: scope.row.transaction_quantity,
                                callback: function($$v) {
                                  _vm.$set(
                                    scope.row,
                                    "transaction_quantity",
                                    $$v
                                  )
                                },
                                expression: "scope.row.transaction_quantity"
                              }
                            })
                          ]
                        }
                      }
                    ])
                  }),
                  _vm._v(" "),
                  _c("el-table-column", {
                    attrs: {
                      "class-name": "text-center",
                      prop: "primary_unit_of_measure",
                      label: "หน่วยนับ",
                      width: "80"
                    }
                  }),
                  _vm._v(" "),
                  _c("el-table-column", {
                    attrs: { prop: "transaction_account", label: "เลขทางบัญชี" }
                  }),
                  _vm._v(" "),
                  _c("el-table-column", {
                    attrs: { "class-name": "text-center", width: "100" },
                    scopedSlots: _vm._u([
                      {
                        key: "default",
                        fn: function(scope) {
                          return [
                            _c(
                              "el-button",
                              {
                                attrs: { size: "mini", type: "danger" },
                                nativeOn: {
                                  click: function($event) {
                                    $event.preventDefault()
                                    return _vm.deleteRow(
                                      scope.$index,
                                      _vm.form.items
                                    )
                                  }
                                }
                              },
                              [
                                _c("i", { staticClass: "el-icon-delete" }),
                                _vm._v("Delete")
                              ]
                            )
                          ]
                        }
                      }
                    ])
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
            { staticClass: "col-md-12 text-right mt-2" },
            [
              !_vm.form.issue_header_id
                ? _c(
                    "el-button",
                    {
                      staticClass: "btn-success",
                      attrs: {
                        size: "mini",
                        type: "success",
                        disabled: !_vm.validDraft
                      },
                      on: {
                        click: function($event) {
                          return _vm.submitForm("DRAFT")
                        }
                      }
                    },
                    [_vm._v("บันทึก")]
                  )
                : _vm._e(),
              _vm._v(" "),
              !_vm.form.issue_header_id
                ? _c(
                    "el-button",
                    {
                      staticClass: "btn-success",
                      attrs: {
                        size: "mini",
                        type: "success",
                        disabled: !_vm.valid
                      },
                      on: {
                        click: function($event) {
                          return _vm.submitForm("WAITING")
                        }
                      }
                    },
                    [_vm._v("ส่งรายการเบิก")]
                  )
                : _vm._e(),
              _vm._v(" "),
              _vm.copy
                ? _c(
                    "el-button",
                    {
                      staticClass: "btn-success",
                      attrs: { size: "mini", type: "success" },
                      on: {
                        click: function($event) {
                          return _vm.submitForm("WAITING")
                        }
                      }
                    },
                    [_vm._v("บันทึก")]
                  )
                : _vm._e(),
              _vm._v(" "),
              _vm.form.issue_header_id && !_vm.copy
                ? _c(
                    "el-button",
                    {
                      staticClass: "btn-success",
                      attrs: { size: "mini", type: "success" },
                      on: {
                        click: function($event) {
                          return _vm.submitForm("UPDATE")
                        }
                      }
                    },
                    [_vm._v("บันทึกและส่งรายการเบิก")]
                  )
                : _vm._e()
            ],
            1
          )
        ],
        1
      )
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);