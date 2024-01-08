(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_qm_qtm-machines_InputFormQtmMachinesCreate_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/qtm-machines/InputFormQtmMachinesCreate.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/qtm-machines/InputFormQtmMachinesCreate.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************************************/
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



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["taskTypes", "taskTypeValue", "equipments", "cigEquipments", "filterEquipments", "equipmentValue", "machines", "cigMachines", "filterMachines", "machineNameValue", "listBrands", "listCigBrands", "listFilterBrands", "brandValue"],
  components: {
    Loading: (vue_loading_overlay__WEBPACK_IMPORTED_MODULE_0___default())
  },
  data: function data() {
    return {
      taskType: this.taskTypeValue,
      equipment: this.equipmentValue,
      machineName: this.machineNameValue,
      brand: this.brandValue,
      equipmentOptions: this.taskTypeValue == "200" || this.taskTypeValue == "300" ? this.taskTypeValue == "200" ? this.cigEquipments : this.filterEquipments : this.equipments,
      machineOptions: this.taskTypeValue == "200" || this.taskTypeValue == "300" ? this.taskTypeValue == "200" ? this.cigMachines : this.filterMachines : this.machines,
      listBrandOptions: this.taskTypeValue == "200" || this.taskTypeValue == "300" ? this.taskTypeValue == "200" ? this.listCigBrands : this.listFilterBrands : this.listBrands
    };
  },
  mounted: function mounted() {
    if (this.taskTypeValue) {
      this.filterMachineOptions(this.taskTypeValue);
      this.filterEquipmentOptions(this.taskTypeValue);
      this.filterBrandOptions(this.taskTypeValue);
    }
  },
  methods: {
    onTaskTypeChanged: function onTaskTypeChanged(taskType) {
      this.taskType = taskType;
      this.filterMachineOptions(this.taskType);
      this.filterEquipmentOptions(this.taskType);
      this.filterBrandOptions(this.taskType);
    },
    onEquipmentChanged: function onEquipmentChanged(equipment) {
      this.equipment = equipment;

      if (equipment != "ALL") {
        var foundEquipment = this.equipmentOptions.find(function (item) {
          return item.equipment_value == equipment;
        });

        if (foundEquipment) {
          this.taskType = foundEquipment.task_type_code;
          this.onTaskTypeChanged(this.taskType);
        }
      }
    },
    onMachineNameChanged: function onMachineNameChanged(machineName) {
      this.machineName = machineName;
    },
    onBrandChanged: function onBrandChanged(brand) {
      this.brand = brand;
    },
    filterMachineOptions: function filterMachineOptions(taskType) {
      var _this = this;

      this.machineOptions = this.machines;

      if (taskType == "200" || taskType == "300") {
        this.machineOptions = taskType == "200" ? this.cigMachines : this.filterMachines;
        var foundSelectedMachineItem = this.machineOptions.find(function (item) {
          return item.machine_name_value == _this.machineName;
        });
        this.$nextTick(function () {
          if (!foundSelectedMachineItem) {
            _this.machineName = "ALL";
          }
        });
      }
    },
    filterEquipmentOptions: function filterEquipmentOptions(taskType) {
      var _this2 = this;

      this.equipmentOptions = this.equipments;

      if (taskType == "200" || taskType == "300") {
        this.equipmentOptions = taskType == "200" ? this.cigEquipments : this.filterEquipments;
        var foundSelectedEqItem = this.equipmentOptions.find(function (item) {
          return item.equipment_value == _this2.equipment;
        });
        this.$nextTick(function () {
          if (!foundSelectedEqItem) {
            _this2.equipment = "ALL";
          }
        });
      }
    },
    filterBrandOptions: function filterBrandOptions(taskType) {
      var _this3 = this;

      this.listBrandOptions = this.listBrands;

      if (taskType == "200" || taskType == "300") {
        this.listBrandOptions = taskType == "200" ? this.listCigBrands : this.listFilterBrands;
        var foundSelectedBrandItem = this.listBrandOptions.find(function (item) {
          return item.brand_value == _this3.brand;
        });
        this.$nextTick(function () {
          if (!foundSelectedBrandItem) {
            _this3.brand = "ALL";
          }
        });
      }
    }
  }
});

/***/ }),

/***/ "./resources/js/components/qm/qtm-machines/InputFormQtmMachinesCreate.vue":
/*!********************************************************************************!*\
  !*** ./resources/js/components/qm/qtm-machines/InputFormQtmMachinesCreate.vue ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _InputFormQtmMachinesCreate_vue_vue_type_template_id_2729e648___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./InputFormQtmMachinesCreate.vue?vue&type=template&id=2729e648& */ "./resources/js/components/qm/qtm-machines/InputFormQtmMachinesCreate.vue?vue&type=template&id=2729e648&");
/* harmony import */ var _InputFormQtmMachinesCreate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./InputFormQtmMachinesCreate.vue?vue&type=script&lang=js& */ "./resources/js/components/qm/qtm-machines/InputFormQtmMachinesCreate.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _InputFormQtmMachinesCreate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _InputFormQtmMachinesCreate_vue_vue_type_template_id_2729e648___WEBPACK_IMPORTED_MODULE_0__.render,
  _InputFormQtmMachinesCreate_vue_vue_type_template_id_2729e648___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/qm/qtm-machines/InputFormQtmMachinesCreate.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/qm/qtm-machines/InputFormQtmMachinesCreate.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************!*\
  !*** ./resources/js/components/qm/qtm-machines/InputFormQtmMachinesCreate.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_InputFormQtmMachinesCreate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./InputFormQtmMachinesCreate.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/qtm-machines/InputFormQtmMachinesCreate.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_InputFormQtmMachinesCreate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/qm/qtm-machines/InputFormQtmMachinesCreate.vue?vue&type=template&id=2729e648&":
/*!***************************************************************************************************************!*\
  !*** ./resources/js/components/qm/qtm-machines/InputFormQtmMachinesCreate.vue?vue&type=template&id=2729e648& ***!
  \***************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputFormQtmMachinesCreate_vue_vue_type_template_id_2729e648___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputFormQtmMachinesCreate_vue_vue_type_template_id_2729e648___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_InputFormQtmMachinesCreate_vue_vue_type_template_id_2729e648___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./InputFormQtmMachinesCreate.vue?vue&type=template&id=2729e648& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/qtm-machines/InputFormQtmMachinesCreate.vue?vue&type=template&id=2729e648&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/qtm-machines/InputFormQtmMachinesCreate.vue?vue&type=template&id=2729e648&":
/*!******************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/qtm-machines/InputFormQtmMachinesCreate.vue?vue&type=template&id=2729e648& ***!
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
  return _c("div", { staticClass: "row" }, [
    _c("div", { staticClass: "col-md-12" }, [
      _c("div", { staticClass: "row form-group" }, [
        _c(
          "div",
          { staticClass: "col-md-6" },
          [
            _c("label", { staticClass: "required" }, [_vm._v(" ประเภทงาน ")]),
            _vm._v(" "),
            _c("qm-el-select", {
              attrs: {
                name: "task_type",
                id: "input_task_type",
                placeholder: "ประเภทงาน ",
                "option-key": "task_type_value",
                "option-value": "task_type_value",
                "option-label": "task_type_label",
                "select-options": _vm.taskTypes,
                clearable: false,
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
        ),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-6" },
          [
            _c("label", { staticClass: "required" }, [
              _vm._v(" หมายเลขเครื่อง QTM ")
            ]),
            _vm._v(" "),
            _c("qm-el-select", {
              attrs: {
                name: "equipment",
                id: "input_equipment",
                placeholder: "หมายเลขเครื่อง QTM ",
                "option-key": "equipment_value",
                "option-value": "equipment_value",
                "option-label": "equipment_label",
                "select-options": _vm.equipmentOptions,
                clearable: false,
                filterable: true,
                value: _vm.equipment
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
        _c(
          "div",
          { staticClass: "col-md-12" },
          [
            _c("label", { staticClass: "required" }, [
              _vm._v(" หมายเลขเครื่อง ")
            ]),
            _vm._v(" "),
            _c("qm-el-select", {
              attrs: {
                name: "machine_name",
                id: "input_machine_name",
                placeholder: "หมายเลขเครื่อง ",
                "option-key": "machine_name_value",
                "option-value": "machine_name_value",
                "option-label": "machine_name_label",
                "select-options": _vm.machineOptions,
                clearable: false,
                filterable: true,
                value: _vm.machineName
              },
              on: {
                onSelected: function($event) {
                  return _vm.onMachineNameChanged($event)
                }
              }
            })
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row form-group" }, [
        _c(
          "div",
          { staticClass: "col-md-12" },
          [
            _c("label", { staticClass: "required" }, [
              _vm._v(" บุหรี่ / ก้นกรอง ")
            ]),
            _vm._v(" "),
            _c("qm-el-select", {
              attrs: {
                name: "brand",
                id: "input_brand",
                placeholder: "เลือกบุหรี่ / ก้นกรอง ",
                "option-key": "brand_value",
                "option-value": "brand_value",
                "option-label": "brand_label",
                "select-options": _vm.listBrandOptions,
                clearable: false,
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
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);