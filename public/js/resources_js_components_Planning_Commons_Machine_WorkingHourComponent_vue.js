(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_Planning_Commons_Machine_WorkingHourComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/WorkingHourComponent.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/WorkingHourComponent.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_0__);
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ['pPlanDate', 'pWorkingHour', 'pWorkingHourEdit', 'pEditFlag', 'pCheckDate'],
  data: function data() {
    return {
      planDate: this.pPlanDate,
      hour: Number(this.pPlanDate.working_hour),
      workingHour: [],
      workingHourEdit: this.pWorkingHourEdit,
      oldWkh: this.pPlanDate.working_hour,
      planDateFormat: moment__WEBPACK_IMPORTED_MODULE_0___default()(this.pPlanDate.res_plan_date, 'DD-MM-YYYY').format('YYYY-MM-DD')
    };
  },
  mounted: function mounted() {},
  watch: {
    'planDate.working_hour': function planDateWorking_hour(newValue) {
      return this.planDate.working_hour = this.planDate['holiday_flag'] == null || this.planDate['eam_pm_flag'] == null || this.planDate['eam_dt_flag'] == null ? newValue : 0;
    },
    'pEditFlag': function pEditFlag(newValue) {
      if (newValue == false) {
        this.hour = this.oldWkh;
        this.planDate.working_hour = this.oldWkh; // Vue.set(this.workingHourEdit, this.planDate.res_plan_date, Number(this.oldWkh));
      }
    }
  },
  methods: {
    changeHour: function changeHour() {
      var vue = this;
      console.log(vue.planDate.working_hour);
      vue.oldWkh = vue.planDate.working_hour;
      vue.planDate.working_hour = vue.hour; //Stamp ที่มีการแก้ไข resPlanDate

      Vue.set(vue.workingHourEdit, vue.planDate.res_plan_date, Number(vue.hour));
    }
  },
  computed: {
    orderedWorkingHour: function orderedWorkingHour() {
      return _.orderBy(this.pWorkingHour, ['attribute1']);
    }
  }
});

/***/ }),

/***/ "./resources/js/components/Planning/Commons/Machine/WorkingHourComponent.vue":
/*!***********************************************************************************!*\
  !*** ./resources/js/components/Planning/Commons/Machine/WorkingHourComponent.vue ***!
  \***********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _WorkingHourComponent_vue_vue_type_template_id_b8054f64___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./WorkingHourComponent.vue?vue&type=template&id=b8054f64& */ "./resources/js/components/Planning/Commons/Machine/WorkingHourComponent.vue?vue&type=template&id=b8054f64&");
/* harmony import */ var _WorkingHourComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./WorkingHourComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/Planning/Commons/Machine/WorkingHourComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _WorkingHourComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _WorkingHourComponent_vue_vue_type_template_id_b8054f64___WEBPACK_IMPORTED_MODULE_0__.render,
  _WorkingHourComponent_vue_vue_type_template_id_b8054f64___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Planning/Commons/Machine/WorkingHourComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Planning/Commons/Machine/WorkingHourComponent.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Commons/Machine/WorkingHourComponent.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_WorkingHourComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./WorkingHourComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/WorkingHourComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_WorkingHourComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Planning/Commons/Machine/WorkingHourComponent.vue?vue&type=template&id=b8054f64&":
/*!******************************************************************************************************************!*\
  !*** ./resources/js/components/Planning/Commons/Machine/WorkingHourComponent.vue?vue&type=template&id=b8054f64& ***!
  \******************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_WorkingHourComponent_vue_vue_type_template_id_b8054f64___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_WorkingHourComponent_vue_vue_type_template_id_b8054f64___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_WorkingHourComponent_vue_vue_type_template_id_b8054f64___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./WorkingHourComponent.vue?vue&type=template&id=b8054f64& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/WorkingHourComponent.vue?vue&type=template&id=b8054f64&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/WorkingHourComponent.vue?vue&type=template&id=b8054f64&":
/*!*********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Planning/Commons/Machine/WorkingHourComponent.vue?vue&type=template&id=b8054f64& ***!
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
    [
      !_vm.pEditFlag
        ? _c(
            "el-select",
            {
              attrs: { placeholder: "Hour", size: "small", disabled: "" },
              on: { change: _vm.changeHour },
              model: {
                value: _vm.hour,
                callback: function($$v) {
                  _vm.hour = $$v
                },
                expression: "hour"
              }
            },
            _vm._l(_vm.orderedWorkingHour, function(hour) {
              return _c("el-option", {
                key: hour.attribute1,
                attrs: { label: hour.attribute1, value: hour.attribute1 }
              })
            }),
            1
          )
        : _vm._e(),
      _vm._v(" "),
      _vm.pEditFlag
        ? [
            _c(
              "el-select",
              {
                attrs: {
                  placeholder: "Hour",
                  size: "small",
                  disabled: _vm.pCheckDate.current_date >= _vm.planDateFormat
                },
                on: { change: _vm.changeHour },
                model: {
                  value: _vm.hour,
                  callback: function($$v) {
                    _vm.hour = $$v
                  },
                  expression: "hour"
                }
              },
              _vm._l(_vm.orderedWorkingHour, function(hour) {
                return _c("el-option", {
                  key: hour.attribute1,
                  attrs: { label: hour.attribute1, value: hour.attribute1 }
                })
              }),
              1
            )
          ]
        : _vm._e()
    ],
    2
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);