(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_inv_disbursement_fuel_AddNonFA_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/disbursement_fuel/AddNonFA.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/disbursement_fuel/AddNonFA.vue?vue&type=script&lang=js& ***!
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["carInfo"],
  data: function data() {
    var _this$carInfo, _this$carInfo2, _this$carInfo3, _this$carInfo4, _this$carInfo5, _this$carInfo6;

    return {
      carInfos: [],
      carTypes: [],
      carFuels: [],
      aLiasNames: [],
      form: [],
      coaDeptCodes: [],
      selectedCar: {},
      car_license_plate: ((_this$carInfo = this.carInfo) === null || _this$carInfo === void 0 ? void 0 : _this$carInfo.car_license_plate) || "",
      account_code: ((_this$carInfo2 = this.carInfo) === null || _this$carInfo2 === void 0 ? void 0 : _this$carInfo2.account_code) || "",
      car_group: ((_this$carInfo3 = this.carInfo) === null || _this$carInfo3 === void 0 ? void 0 : _this$carInfo3.car_group) || "",
      car_fuel: ((_this$carInfo4 = this.carInfo) === null || _this$carInfo4 === void 0 ? void 0 : _this$carInfo4.car_fuel) || "",
      asset_number: "",
      asset_id: ((_this$carInfo5 = this.carInfo) === null || _this$carInfo5 === void 0 ? void 0 : _this$carInfo5.asset_id) || "",
      quota_per_month: "",
      default_dept_code: ((_this$carInfo6 = this.carInfo) === null || _this$carInfo6 === void 0 ? void 0 : _this$carInfo6.default_dept_code) || "",
      loadingInput: {
        carInfos: false,
        carTypes: false,
        carFuels: false,
        aliasName: false,
        coaDeptCodes: false
      },
      loading: false
    };
  },
  created: function created() {
    this.getMasterData();
  },
  mounted: function mounted() {
    if (this.carInfo) {
      var _this$selectedCar, _this$selectedCar2;

      this.selectedCar = this.carInfo;
      this.account_code = (_this$selectedCar = this.selectedCar) === null || _this$selectedCar === void 0 ? void 0 : _this$selectedCar.account_code;
      this.quota_per_month = (_this$selectedCar2 = this.selectedCar) === null || _this$selectedCar2 === void 0 ? void 0 : _this$selectedCar2.quota_per_month;
    }

    if (this.carInfo.default_dept_code) {
      this.getCOAsWithDefault(this.carInfo.default_dept_code);
      this.default_dept_code = this.carInfo.default_dept_code;
    }
  },
  watch: {
    car_license_plate: function car_license_plate(val) {
      var _this = this,
          _this$selectedCar3,
          _this$selectedCar4,
          _this$selectedCar5,
          _this$selectedCar6,
          _this$selectedCar7,
          _this$selectedCar8;

      this.selectedCar = this.carInfos.find(function (c) {
        return c.car_license_plate == _this.car_license_plate;
      });
      this.car_group = (_this$selectedCar3 = this.selectedCar) === null || _this$selectedCar3 === void 0 ? void 0 : _this$selectedCar3.car_group;
      this.car_fuel = (_this$selectedCar4 = this.selectedCar) === null || _this$selectedCar4 === void 0 ? void 0 : _this$selectedCar4.car_fuel;
      this.car_user = (_this$selectedCar5 = this.selectedCar) === null || _this$selectedCar5 === void 0 ? void 0 : _this$selectedCar5.car_user;
      this.account_code = (_this$selectedCar6 = this.selectedCar) === null || _this$selectedCar6 === void 0 ? void 0 : _this$selectedCar6.account_code;
      this.quota_per_month = (_this$selectedCar7 = this.selectedCar) === null || _this$selectedCar7 === void 0 ? void 0 : _this$selectedCar7.quota_per_month;
      this.getCOAsWithDefault(this.selectedCar.default_dept_code);
      this.default_dept_code = (_this$selectedCar8 = this.selectedCar) === null || _this$selectedCar8 === void 0 ? void 0 : _this$selectedCar8.default_dept_code;
    }
  },
  methods: {
    getMasterData: function getMasterData() {
      this.getCarInfos();
      this.getCarType();
      this.getCarFuel();
      this.getAliasName();
      this.getCOAsWithDefault('');
    },
    getCarInfos: function getCarInfos(query) {
      var _this2 = this;

      this.loadingInput.carInfos = true;
      axios.get("/inv/ajax/car_info", {
        params: {
          text: query,
          source_data: 'NON_FA'
        }
      }).then(function (response) {
        _this2.carInfos = response.data;
      })["catch"](function (err) {
        console.log("error get car info");
      }).then(function () {
        _this2.loadingInput.carInfos = false;
      });
    },
    getCarType: function getCarType(query) {
      var _this3 = this;

      this.loadingInput.carTypes = true;
      axios.get("/inv/ajax/car_types", {
        params: {
          text: query
        }
      }).then(function (response) {
        _this3.carTypes = response.data;
      })["catch"](function (err) {
        console.log("error get car types");
      }).then(function () {
        _this3.loadingInput.carTypes = false;
      });
    },
    getCarFuel: function getCarFuel(query) {
      var _this4 = this;

      this.loadingInput.carFuels = true;
      axios.get("/inv/ajax/car_fuels", {
        params: {
          text: query
        }
      }).then(function (response) {
        _this4.carFuels = response.data;
      })["catch"](function (err) {
        console.log("error get car fuels");
      }).then(function () {
        _this4.loadingInput.carFuels = false;
      });
    },
    getAliasName: function getAliasName(query) {
      var _this5 = this;

      this.loadingInput.aliasName = true;
      axios.get("/inv/ajax/alias_name", {
        params: {
          text: query,
          prefix: "T21"
        }
      }).then(function (response) {
        _this5.aLiasNames = response.data;
      })["catch"](function (err) {
        console.log("error get alias name");
      }).then(function () {
        _this5.loadingInput.aliasName = false;
      });
    },
    getCOAsWithDefault: function getCOAsWithDefault(query) {
      var _this6 = this;

      this.loadingInput.coaDeptCodes = true;
      var getByQuery = axios.get("/inv/ajax/coa_dept_code", {
        params: {
          text: query
        }
      });
      var getAll = axios.get("/inv/ajax/coa_dept_code", {});
      axios.all([getByQuery, getAll]).then(function (responses) {
        responses[0].data.map(function (i) {
          _this6.coaDeptCodes.push(i);
        });
        responses[1].data.map(function (i) {
          _this6.coaDeptCodes.push(i);
        });
      }).then(function () {
        _this6.loadingInput.coaDeptCodes = false;
      });
    },
    getCOAs: function getCOAs(query) {
      var _this7 = this;

      axios.get("/inv/ajax/coa_dept_code", {
        params: {
          text: query,
          value_set_name: 'TOAT_GL_ACCT_CODE-DEPT_CODE'
        }
      }).then(function (response) {
        _this7.coaDeptCodes = response.data;
      }).then(function () {
        _this7.loadingInput.coaDeptCodes = false;
      });
    },
    refresh: function refresh() {
      window.location.reload();
    },
    confirm: function (_confirm) {
      function confirm() {
        return _confirm.apply(this, arguments);
      }

      confirm.toString = function () {
        return _confirm.toString();
      };

      return confirm;
    }(function () {
      var _this8 = this;

      if (confirm("ยืนยันการขอสิทธิ์เติมน้ำมัน ?")) {
        this.loading = true;
        axios.get("/inv/disbursement_fuel/update-non-fa-interface", {
          params: {
            car_license_plate: this.car_license_plate,
            car_group: this.car_group,
            car_fuel: this.car_fuel,
            account_code: this.account_code,
            quota_per_month: this.quota_per_month,
            default_dept_code: this.default_dept_code
          }
        }).then(function (res) {
          _this8.$notify({
            title: 'Success',
            message: 'Update Successfully',
            type: 'success'
          });

          window.location.replace("/inv/disbursement_fuel/show");
        })["catch"](function (err) {
          _this8.loading = false;

          if (err.response.status == 403) {
            _this8.$notify.error({
              title: 'Error',
              message: err.response.data.msg,
              duration: 4500
            });
          }

          var errorMessage = _this8.$formatErrorMessage(error);

          _this8.$notify.error({
            title: 'Error',
            dangerouslyUseHTMLString: true,
            message: errorMessage.outerHTML,
            duration: 0
          });
        });
      }
    })
  },
  computed: {
    acc_segment: function acc_segment() {
      var _this$aLiasNames$find,
          _this9 = this;

      var selectedAliasName = ((_this$aLiasNames$find = this.aLiasNames.find(function (a) {
        return a.alias_name == _this9.account_code;
      })) === null || _this$aLiasNames$find === void 0 ? void 0 : _this$aLiasNames$find.template) || '';
      return selectedAliasName;
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/disbursement_fuel/AddNonFA.vue?vue&type=style&index=0&id=c7d4486a&scoped=true&lang=css&":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/disbursement_fuel/AddNonFA.vue?vue&type=style&index=0&id=c7d4486a&scoped=true&lang=css& ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, ".btn-success[data-v-c7d4486a] {\n  background-color: #1ab394;\n  border-color: #1ab394;\n}\n.btn-cancle[data-v-c7d4486a] {\n  background-color: #EC4958;\n  border-color: #EC4958;\n  color: white;\n}\n.text-refresh[data-v-c7d4486a] {\n  color: #ec4958;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/disbursement_fuel/AddNonFA.vue?vue&type=style&index=0&id=c7d4486a&scoped=true&lang=css&":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/disbursement_fuel/AddNonFA.vue?vue&type=style&index=0&id=c7d4486a&scoped=true&lang=css& ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_AddNonFA_vue_vue_type_style_index_0_id_c7d4486a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./AddNonFA.vue?vue&type=style&index=0&id=c7d4486a&scoped=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/disbursement_fuel/AddNonFA.vue?vue&type=style&index=0&id=c7d4486a&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_AddNonFA_vue_vue_type_style_index_0_id_c7d4486a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_AddNonFA_vue_vue_type_style_index_0_id_c7d4486a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/components/inv/disbursement_fuel/AddNonFA.vue":
/*!********************************************************************!*\
  !*** ./resources/js/components/inv/disbursement_fuel/AddNonFA.vue ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _AddNonFA_vue_vue_type_template_id_c7d4486a_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./AddNonFA.vue?vue&type=template&id=c7d4486a&scoped=true& */ "./resources/js/components/inv/disbursement_fuel/AddNonFA.vue?vue&type=template&id=c7d4486a&scoped=true&");
/* harmony import */ var _AddNonFA_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./AddNonFA.vue?vue&type=script&lang=js& */ "./resources/js/components/inv/disbursement_fuel/AddNonFA.vue?vue&type=script&lang=js&");
/* harmony import */ var _AddNonFA_vue_vue_type_style_index_0_id_c7d4486a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./AddNonFA.vue?vue&type=style&index=0&id=c7d4486a&scoped=true&lang=css& */ "./resources/js/components/inv/disbursement_fuel/AddNonFA.vue?vue&type=style&index=0&id=c7d4486a&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _AddNonFA_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _AddNonFA_vue_vue_type_template_id_c7d4486a_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _AddNonFA_vue_vue_type_template_id_c7d4486a_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "c7d4486a",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/inv/disbursement_fuel/AddNonFA.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/inv/disbursement_fuel/AddNonFA.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************!*\
  !*** ./resources/js/components/inv/disbursement_fuel/AddNonFA.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AddNonFA_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./AddNonFA.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/disbursement_fuel/AddNonFA.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AddNonFA_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/inv/disbursement_fuel/AddNonFA.vue?vue&type=style&index=0&id=c7d4486a&scoped=true&lang=css&":
/*!*****************************************************************************************************************************!*\
  !*** ./resources/js/components/inv/disbursement_fuel/AddNonFA.vue?vue&type=style&index=0&id=c7d4486a&scoped=true&lang=css& ***!
  \*****************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_AddNonFA_vue_vue_type_style_index_0_id_c7d4486a_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./AddNonFA.vue?vue&type=style&index=0&id=c7d4486a&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/disbursement_fuel/AddNonFA.vue?vue&type=style&index=0&id=c7d4486a&scoped=true&lang=css&");


/***/ }),

/***/ "./resources/js/components/inv/disbursement_fuel/AddNonFA.vue?vue&type=template&id=c7d4486a&scoped=true&":
/*!***************************************************************************************************************!*\
  !*** ./resources/js/components/inv/disbursement_fuel/AddNonFA.vue?vue&type=template&id=c7d4486a&scoped=true& ***!
  \***************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AddNonFA_vue_vue_type_template_id_c7d4486a_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AddNonFA_vue_vue_type_template_id_c7d4486a_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AddNonFA_vue_vue_type_template_id_c7d4486a_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./AddNonFA.vue?vue&type=template&id=c7d4486a&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/disbursement_fuel/AddNonFA.vue?vue&type=template&id=c7d4486a&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/disbursement_fuel/AddNonFA.vue?vue&type=template&id=c7d4486a&scoped=true&":
/*!******************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/disbursement_fuel/AddNonFA.vue?vue&type=template&id=c7d4486a&scoped=true& ***!
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
      ],
      staticClass: "container"
    },
    [
      _c("div", { staticClass: "form-group row" }, [
        _c("label", { staticClass: "col-md-2 col-form-label required" }, [
          _vm._v("เลขที่เครื่องจักร")
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-6" },
          [
            _c(
              "el-select",
              {
                staticStyle: { width: "100%" },
                attrs: {
                  filterable: "",
                  remote: "",
                  "allow-create": "",
                  "default-first-option": "",
                  debounce: 2000,
                  "remote-method": _vm.getCarInfos,
                  placeholder: "เลขที่เครื่องจักร",
                  loading: _vm.loadingInput.carInfos
                },
                model: {
                  value: _vm.car_license_plate,
                  callback: function($$v) {
                    _vm.car_license_plate = $$v
                  },
                  expression: "car_license_plate"
                }
              },
              _vm._l(_vm.carInfos, function(item, index) {
                return _c("el-option", {
                  key: index,
                  attrs: {
                    label: item.car_license_plate,
                    value: item.car_license_plate
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
        _c("label", { staticClass: "col-md-2 col-form-label required" }, [
          _vm._v("กลุ่มเครื่องจักร")
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-6" },
          [
            _c(
              "el-select",
              {
                staticStyle: { width: "100%" },
                attrs: {
                  filterable: "",
                  remote: "",
                  debounce: 2000,
                  "remote-method": _vm.getCarType,
                  placeholder: "กลุ่มเครื่องจักร",
                  loading: _vm.loadingInput.carTypes
                },
                model: {
                  value: _vm.car_group,
                  callback: function($$v) {
                    _vm.car_group = $$v
                  },
                  expression: "car_group"
                }
              },
              _vm._l(_vm.carTypes, function(item, index) {
                return _c("el-option", {
                  key: index,
                  attrs: { label: item.description, value: item.flex_value }
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
        _c("label", { staticClass: "col-md-2 col-form-label required" }, [
          _vm._v("ชนิดน้ำมันที่เติม")
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-6" },
          [
            _c(
              "el-select",
              {
                staticStyle: { width: "100%" },
                attrs: {
                  filterable: "",
                  remote: "",
                  debounce: 2000,
                  "remote-method": _vm.getCarFuel,
                  placeholder: "ชนิดน้ำมันที่เติม",
                  loading: _vm.loadingInput.carFuels
                },
                model: {
                  value: _vm.car_fuel,
                  callback: function($$v) {
                    _vm.car_fuel = $$v
                  },
                  expression: "car_fuel"
                }
              },
              _vm._l(_vm.carFuels, function(item, index) {
                return _c("el-option", {
                  key: index,
                  attrs: { label: item.description, value: item.segment1 }
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
        _c("label", { staticClass: "col-md-2 col-form-label required" }, [
          _vm._v("หน่วยงานเจ้าของเครื่องจักร")
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
            staticClass: "col-md-6"
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
                  placeholder: "หน่วยงานเจ้าของเครื่องจักร",
                  loading: _vm.loadingInput.coaDeptCodes
                },
                model: {
                  value: _vm.default_dept_code,
                  callback: function($$v) {
                    _vm.default_dept_code = $$v
                  },
                  expression: "default_dept_code"
                }
              },
              _vm._l(_vm.coaDeptCodes, function(item, index) {
                return _c("el-option", {
                  key: index,
                  attrs: {
                    label: item.department_code + " - " + item.description,
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
        _c("label", { staticClass: "col-md-2 col-form-label required" }, [
          _vm._v("รหัสบัญชี")
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-6" },
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
                  loading: _vm.loadingInput.aliasName
                },
                model: {
                  value: _vm.account_code,
                  callback: function($$v) {
                    _vm.account_code = $$v
                  },
                  expression: "account_code"
                }
              },
              _vm._l(_vm.aLiasNames, function(item, index) {
                return _c("el-option", {
                  key: index,
                  attrs: {
                    label: item.alias_name + " - " + item.description,
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
        _c("div", { staticClass: "offset-md-2 col-md-6" }, [
          _vm._v("\n            " + _vm._s(this.acc_segment) + "\n        ")
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "card" }, [
        _c("div", { staticClass: "card-body" }, [
          _c("div", { staticClass: "form-group row" }, [
            _c("label", { staticClass: "col-md-2 col-form-label required" }, [
              _vm._v("ขอสิทธิ์จำนวน")
            ]),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "col-md-2 p-0" },
              [
                _c("el-input", {
                  attrs: { type: "number" },
                  model: {
                    value: _vm.quota_per_month,
                    callback: function($$v) {
                      _vm.quota_per_month = $$v
                    },
                    expression: "quota_per_month"
                  }
                })
              ],
              1
            ),
            _vm._v(" "),
            _c("label", { staticClass: "col-md-2 col-form-label" }, [
              _vm._v("ลิตร / เดือน")
            ])
          ])
        ])
      ]),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "col-md-12 text-right mt-4 p-0" },
        [
          _c(
            "el-button",
            {
              staticClass: "btn-success",
              attrs: { type: "primary" },
              on: {
                click: function($event) {
                  return _vm.confirm()
                }
              }
            },
            [_vm._v("ยืนยัน")]
          ),
          _vm._v(" "),
          _c(
            "el-button",
            {
              staticClass: "text-refresh",
              attrs: { type: "text" },
              nativeOn: {
                click: function($event) {
                  $event.preventDefault()
                  return _vm.refresh()
                }
              }
            },
            [_vm._v("ล้างข้อมูล")]
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