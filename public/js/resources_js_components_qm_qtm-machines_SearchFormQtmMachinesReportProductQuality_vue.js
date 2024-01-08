(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_qm_qtm-machines_SearchFormQtmMachinesReportProductQuality_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/qtm-machines/SearchFormQtmMachinesReportProductQuality.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/qtm-machines/SearchFormQtmMachinesReportProductQuality.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var vue_loading_overlay__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-loading-overlay */ "./node_modules/vue-loading-overlay/dist/vue-loading.min.js");
/* harmony import */ var vue_loading_overlay__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_loading_overlay__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_loading_overlay_dist_vue_loading_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-loading-overlay/dist/vue-loading.css */ "./node_modules/vue-loading-overlay/dist/vue-loading.css");
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["sampleNoValue", "taskTypes", "taskTypeValue", "equipmentTypes", "equipmentTypeValue", "equipments", "machineNameValue", "listMakers", "makerValue", "listBrands", "brandValue", "listBrandCategories", "brandCategoryValue", "showSampleResultTypes", "showTestIdValue", "qualityStatuses", "qualityStatusValue", "resultStatuses", "resultStatusValue"],
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_0___default())
  },
  data: function data() {
    return {
      sampleNo: this.sampleNoValue,
      taskType: this.taskTypeValue,
      equipmentType: this.equipmentTypeValue,
      machineName: this.machineNameValue,
      maker: this.makerValue,
      brand: this.brandValue,
      brandCategory: this.brandCategoryValue,
      showTestId: this.showTestIdValue,
      qualityStatus: this.qualityStatusValue,
      resultStatus: this.resultStatusValue,
      equipmentOptions: this.equipments,
      listMakerOptions: this.listMakers,
      listBrandOptions: this.listBrands,
      listBrandCategoryOptions: this.listBrandCategories,
      showSampleResultTypeOptions: this.showSampleResultTypes,
      qualityStatusOptions: this.qualityStatuses,
      resultStatusOptions: this.resultStatuses
    };
  },
  mounted: function mounted() {
    if (this.taskTypeValue || this.equipmentTypeValue || this.brandCategoryValue) {
      this.filterMakerOptions(this.taskTypeValue);
      this.filterBrandCategoryOptions(this.taskTypeValue);
      this.filterEquipmentOptions(this.taskTypeValue, this.equipmentTypeValue);
      this.filterBrandOptions(this.taskTypeValue, this.brandCategoryValue);
    }
  },
  methods: {
    onTaskTypeChanged: function onTaskTypeChanged(taskType) {
      this.taskType = taskType;
      this.filterMakerOptions(this.taskType);
      this.filterBrandCategoryOptions(taskType);
      this.filterEquipmentOptions(this.taskType, this.equipmentType);
      this.filterBrandOptions(this.taskType, this.brandCategory);
    },
    onMachineNameChanged: function onMachineNameChanged(machineName) {
      this.machineName = machineName;
    },
    onEquipmentTypeChanged: function onEquipmentTypeChanged(equipmentType) {
      this.equipmentType = equipmentType;
      this.filterEquipmentOptions(this.taskType, this.equipmentType);
    },
    onMakerChanged: function onMakerChanged(maker) {
      this.maker = maker;
    },
    onBrandChanged: function onBrandChanged(brand) {
      this.brand = brand;
    },
    onBrandCategoryChanged: function onBrandCategoryChanged(brandCategory) {
      this.brandCategory = brandCategory;
      this.filterBrandOptions(this.taskType, this.brandCategory);
    },
    onShowTestIdChanged: function onShowTestIdChanged(showTestId) {
      this.showTestId = showTestId;
    },
    filterEquipmentOptions: function filterEquipmentOptions(taskType, equipmentType) {
      var _this = this;

      this.equipmentOptions = this.equipments;

      if (taskType == "200" || taskType == "300") {
        this.equipmentOptions = this.equipments.filter(function (item) {
          return item.task_type_code == taskType;
        });

        if (equipmentType) {
          this.equipmentOptions = this.equipments.filter(function (item) {
            return item.task_type_code == taskType && item.equipment_type == equipmentType;
          });
        }
      } else {
        if (equipmentType) {
          this.equipmentOptions = this.equipments.filter(function (item) {
            return item.equipment_type == equipmentType;
          });
        }
      }

      var foundSelectedEqItem = this.equipmentOptions.find(function (item) {
        return item.equipment_value == _this.equipment;
      });
      this.$nextTick(function () {
        if (!foundSelectedEqItem) {
          _this.equipment = "";
        }
      });
    },
    filterMakerOptions: function filterMakerOptions(taskType) {
      var _this2 = this;

      this.listMakerOptions = this.listMakers;

      if (taskType == "200" || taskType == "300") {
        this.listMakerOptions = this.listMakers.filter(function (item) {
          return item.task_type_code == taskType;
        });
      }

      var foundSelectedMakerItem = this.listMakerOptions.find(function (item) {
        return item.maker_value == _this2.maker;
      });
      this.$nextTick(function () {
        if (!foundSelectedMakerItem) {
          _this2.maker = "";
        }
      });
    },
    filterBrandCategoryOptions: function filterBrandCategoryOptions(taskType) {
      var _this3 = this;

      this.listBrandCategoryOptions = this.listBrandCategories;

      if (taskType == "200") {
        this.listBrandCategoryOptions = this.listBrandCategories.filter(function (item) {
          return item.category_code.startsWith('C');
        });
      }

      if (taskType == "300") {
        this.listBrandCategoryOptions = this.listBrandCategories.filter(function (item) {
          return item.category_code.startsWith('F');
        });
      }

      var foundSelectedBrandCategoryItem = this.listBrandCategoryOptions.find(function (item) {
        return item.category_value == _this3.brandCategory;
      });
      this.$nextTick(function () {
        if (!foundSelectedBrandCategoryItem) {
          _this3.brandCategory = "";
        }
      });
    },
    filterBrandOptions: function filterBrandOptions(taskType, brandCategory) {
      var _this4 = this;

      this.listBrandOptions = this.listBrands;

      if (brandCategory) {
        this.listBrandOptions = this.listBrands.filter(function (item) {
          return item.category_code == brandCategory;
        });
      } else {
        if (taskType == "200") {
          this.listBrandOptions = this.listBrands.filter(function (item) {
            return item.category_code.startsWith('C');
          });
        }

        if (taskType == "300") {
          this.listBrandOptions = this.listBrands.filter(function (item) {
            return item.category_code.startsWith('F');
          });
        }
      }

      var foundSelectedBrandItem = this.listBrandOptions.find(function (item) {
        return item.brand_value == _this4.brand;
      });
      this.$nextTick(function () {
        if (!foundSelectedBrandItem) {
          _this4.brand = "";
        }
      });
    }
  }
});

/***/ }),

/***/ "./resources/js/components/qm/qtm-machines/SearchFormQtmMachinesReportProductQuality.vue":
/*!***********************************************************************************************!*\
  !*** ./resources/js/components/qm/qtm-machines/SearchFormQtmMachinesReportProductQuality.vue ***!
  \***********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _SearchFormQtmMachinesReportProductQuality_vue_vue_type_template_id_27eb19e6___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SearchFormQtmMachinesReportProductQuality.vue?vue&type=template&id=27eb19e6& */ "./resources/js/components/qm/qtm-machines/SearchFormQtmMachinesReportProductQuality.vue?vue&type=template&id=27eb19e6&");
/* harmony import */ var _SearchFormQtmMachinesReportProductQuality_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SearchFormQtmMachinesReportProductQuality.vue?vue&type=script&lang=js& */ "./resources/js/components/qm/qtm-machines/SearchFormQtmMachinesReportProductQuality.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _SearchFormQtmMachinesReportProductQuality_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _SearchFormQtmMachinesReportProductQuality_vue_vue_type_template_id_27eb19e6___WEBPACK_IMPORTED_MODULE_0__.render,
  _SearchFormQtmMachinesReportProductQuality_vue_vue_type_template_id_27eb19e6___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/qm/qtm-machines/SearchFormQtmMachinesReportProductQuality.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/qm/qtm-machines/SearchFormQtmMachinesReportProductQuality.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************!*\
  !*** ./resources/js/components/qm/qtm-machines/SearchFormQtmMachinesReportProductQuality.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchFormQtmMachinesReportProductQuality_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SearchFormQtmMachinesReportProductQuality.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/qtm-machines/SearchFormQtmMachinesReportProductQuality.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchFormQtmMachinesReportProductQuality_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/qm/qtm-machines/SearchFormQtmMachinesReportProductQuality.vue?vue&type=template&id=27eb19e6&":
/*!******************************************************************************************************************************!*\
  !*** ./resources/js/components/qm/qtm-machines/SearchFormQtmMachinesReportProductQuality.vue?vue&type=template&id=27eb19e6& ***!
  \******************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchFormQtmMachinesReportProductQuality_vue_vue_type_template_id_27eb19e6___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchFormQtmMachinesReportProductQuality_vue_vue_type_template_id_27eb19e6___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SearchFormQtmMachinesReportProductQuality_vue_vue_type_template_id_27eb19e6___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SearchFormQtmMachinesReportProductQuality.vue?vue&type=template&id=27eb19e6& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/qtm-machines/SearchFormQtmMachinesReportProductQuality.vue?vue&type=template&id=27eb19e6&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/qtm-machines/SearchFormQtmMachinesReportProductQuality.vue?vue&type=template&id=27eb19e6&":
/*!*********************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/qtm-machines/SearchFormQtmMachinesReportProductQuality.vue?vue&type=template&id=27eb19e6& ***!
  \*********************************************************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "col-md-8" }, [
    _c("div", { staticClass: "row" }, [
      _c("div", { staticClass: "col-md-6" }, [
        _c("div", { staticClass: "row form-group" }, [
          _c("label", { staticClass: "col-md-4 col-form-label" }, [
            _vm._v(" เลขที่การตรวจสอบ ")
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-8" }, [
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.sampleNo,
                  expression: "sampleNo"
                }
              ],
              staticClass: "form-control",
              attrs: { type: "text", id: "input_sample_no", name: "sample_no" },
              domProps: { value: _vm.sampleNo },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.sampleNo = $event.target.value
                }
              }
            })
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row form-group" }, [
          _c("label", { staticClass: "col-md-4 col-form-label" }, [
            _vm._v(" ประเภทเครื่อง ")
          ]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-8" },
            [
              _c("qm-el-select", {
                attrs: {
                  name: "qtm_equipment_type",
                  id: "input_qtm_equipment_type",
                  placeholder: "เลือกประเภทเครื่อง ",
                  "option-key": "equipment_type_value",
                  "option-value": "equipment_type_value",
                  "option-label": "equipment_type_label",
                  "select-options": _vm.equipmentTypes,
                  clearable: true,
                  filterable: true,
                  value: _vm.equipmentType
                },
                on: {
                  onSelected: function($event) {
                    return _vm.onEquipmentTypeChanged($event)
                  }
                }
              })
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row form-group" }, [
          _c("label", { staticClass: "col-md-4 col-form-label" }, [
            _vm._v(" หมายเลขเครื่อง QTM ")
          ]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-8" },
            [
              _c("qm-el-select", {
                attrs: {
                  name: "machine_name",
                  id: "input_machine_name",
                  placeholder: "เลือกหมายเลขเครื่อง QTM ",
                  "option-key": "equipment_value",
                  "option-value": "equipment_value",
                  "option-label": "equipment_label",
                  "select-options": _vm.equipmentOptions,
                  clearable: true,
                  filterable: true,
                  value: _vm.machineName
                },
                on: {
                  onSelected: function($event) {
                    return _vm.onEquipmentChanged($event)
                  }
                }
              })
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row form-group" }, [
          _c("label", { staticClass: "col-md-4 col-form-label" }, [
            _vm._v(" หมายเลขเครื่อง Maker ")
          ]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-8" },
            [
              _c("qm-el-select", {
                attrs: {
                  name: "qtm_maker",
                  id: "input_qtm_maker",
                  placeholder: "เลือกหมายเลขเครื่อง Maker ",
                  "option-key": "maker_value",
                  "option-value": "maker_value",
                  "option-label": "maker_label",
                  "select-options": _vm.listMakerOptions,
                  clearable: true,
                  filterable: true,
                  value: _vm.maker
                },
                on: {
                  onSelected: function($event) {
                    return _vm.onMakerChanged($event)
                  }
                }
              })
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row form-group" }, [
          _c("label", { staticClass: "col-md-4 col-form-label" }, [
            _vm._v(" แสดงค่าความผิดปกติ ")
          ]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-8" },
            [
              _c("qm-el-select", {
                attrs: {
                  name: "show_test_id",
                  id: "input_show_test_id",
                  placeholder: "เลือกแสดงค่าความผิดปกติ",
                  "option-key": "value",
                  "option-value": "test_id",
                  "option-label": "test_full_desc",
                  "select-options": _vm.showSampleResultTypeOptions,
                  clearable: true,
                  filterable: true,
                  value: _vm.showTestId
                },
                on: {
                  onSelected: function($event) {
                    return _vm.onShowTestIdChanged($event)
                  }
                }
              })
            ],
            1
          )
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "col-md-6" }, [
        _c("div", { staticClass: "row form-group" }, [
          _c("label", { staticClass: "col-md-4 col-form-label" }, [
            _vm._v(" ตามข้อกำหนด ")
          ]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-8" },
            [
              _c("qm-el-select", {
                attrs: {
                  name: "quality_status",
                  id: "input_quality_status",
                  placeholder: "เลือกตามข้อกำหนด ",
                  "option-key": "value",
                  "option-value": "value",
                  "option-label": "label",
                  "select-options": _vm.qualityStatusOptions,
                  clearable: true,
                  filterable: true,
                  value: _vm.qualityStatus
                }
              })
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row form-group" }, [
          _c("label", { staticClass: "col-md-4 col-form-label" }, [
            _vm._v(" ผลการตรวจ ")
          ]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-8" },
            [
              _c("qm-el-select", {
                attrs: {
                  name: "result_status",
                  id: "input_result_status",
                  placeholder: "เลือกผลการตรวจ ",
                  "option-key": "value",
                  "option-value": "value",
                  "option-label": "label",
                  "select-options": _vm.resultStatusOptions,
                  clearable: true,
                  filterable: true,
                  value: _vm.resultStatus
                }
              })
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row form-group" }, [
          _c("label", { staticClass: "col-md-4 col-form-label" }, [
            _vm._v(" ประเภทงาน ")
          ]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-8" },
            [
              _c("qm-el-select", {
                attrs: {
                  name: "task_type_code",
                  id: "input_task_type_code",
                  placeholder: "เลือกประเภทงาน ",
                  "option-key": "task_type_value",
                  "option-value": "task_type_value",
                  "option-label": "task_type_label",
                  "select-options": _vm.taskTypes,
                  clearable: true,
                  filterable: true,
                  value: _vm.taskType
                },
                on: {
                  onSelected: function($event) {
                    return _vm.onTaskTypeChanged($event)
                  }
                }
              })
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row form-group" }, [
          _c("label", { staticClass: "col-md-4 col-form-label" }, [
            _vm._v(" หมวดงาน ")
          ]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-8" },
            [
              _c("qm-el-select", {
                attrs: {
                  name: "qtm_brand_category_code",
                  id: "input_qtm_brand_category_code",
                  placeholder: "เลือกหมวดงาน ",
                  "option-key": "category_value",
                  "option-value": "category_value",
                  "option-label": "category_label",
                  "select-options": _vm.listBrandCategoryOptions,
                  clearable: true,
                  filterable: true,
                  value: _vm.brandCategory
                },
                on: {
                  onSelected: function($event) {
                    return _vm.onBrandCategoryChanged($event)
                  }
                }
              })
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row form-group" }, [
          _c("label", { staticClass: "col-md-4 col-form-label" }, [
            _vm._v(" บุหรี่ / ก้นกรอง ")
          ]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "col-md-8" },
            [
              _c("qm-el-select", {
                attrs: {
                  name: "qtm_brand",
                  id: "input_qtm_brand",
                  placeholder: "เลือกบุหรี่ / ก้นกรอง ",
                  "option-key": "brand_value",
                  "option-value": "brand_value",
                  "option-label": "brand_label",
                  "select-options": _vm.listBrandOptions,
                  clearable: true,
                  filterable: true,
                  value: _vm.brand
                },
                on: {
                  onSelected: function($event) {
                    return _vm.onBrandChanged($event)
                  }
                }
              })
            ],
            1
          )
        ])
      ])
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);