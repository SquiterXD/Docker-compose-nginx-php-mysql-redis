(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pm_settings_production-formula_table_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/settings/production-formula/table.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/settings/production-formula/table.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['dataList'],
  data: function data() {
    return {
      rowselect: -1,
      columnSelected: [],
      columnSelectedId: [],
      lastRowId: -1,
      indexTable: -1,
      fields: [{
        key: 'selected',
        label: '',
        sortable: false,
        "class": 'text-center text-nowrap'
      }, {
        key: 'item_number',
        label: 'รหัสสินค้า',
        sortable: true,
        "class": 'text-center text-nowrap',
        tdClass: 'align-middle'
      }, {
        key: 'item_desc',
        label: 'ชื่อสินค้า',
        sortable: true,
        thClass: 'text-center text-nowrap',
        tdClass: 'align-middle'
      }, {
        key: 'formula_type_description',
        label: 'ประเภทสูตร',
        sortable: true,
        thClass: 'text-center text-nowrap',
        thStyle: 'min-width: 105px;',
        tdClass: ''
      }, {
        key: 'routing_desc',
        label: 'ประเภทสิ่งผลิต',
        sortable: true,
        thClass: 'text-center text-nowrap',
        thStyle: 'min-width: 150px;',
        tdClass: ''
      }, {
        key: 'version',
        label: 'Version',
        sortable: true,
        "class": 'text-center text-nowrap',
        thStyle: 'min-width: 110px;',
        tdClass: ''
      }, {
        key: 'status',
        label: 'สถานะ',
        sortable: true,
        thClass: 'text-center text-nowrap',
        thStyle: 'min-width: 165px;',
        tdClass: ''
      }, {
        key: 'oprn_desc',
        label: 'ขั้นตอนการทำงาน',
        sortable: true,
        "class": 'text-center text-nowrap',
        thStyle: 'min-width: 165px;',
        tdClass: ''
      }, {
        key: 'machine_type_description',
        label: 'ประเภทเครื่องจักร',
        sortable: true,
        "class": 'text-center text-nowrap',
        thStyle: 'min-width: 165px;',
        tdClass: ''
      }, {
        key: 'period_year',
        label: 'ปีงบประมาณ',
        sortable: true,
        "class": 'text-center text-nowrap',
        tdClass: 'align-middle'
      }, {
        key: 'start_date',
        label: 'วันที่เริ่มใช้งาน',
        sortable: true,
        "class": 'text-center text-nowrap',
        thStyle: 'min-width: 125px;',
        tdClass: ''
      }, {
        key: 'end_date',
        label: 'วันที่สิ้นสุดใช้งาน',
        sortable: true,
        "class": 'text-center text-nowrap',
        thStyle: 'min-width: 125px;',
        tdClass: ''
      }, {
        key: 'action',
        label: '',
        sortable: false,
        "class": 'text-center text-nowrap',
        thStyle: 'min-width: 65px;'
      }],
      totalRows: 0,
      currentPage: 1,
      perPage: 10,
      sortBy: '',
      sortDesc: false,
      sortDirection: 'asc',
      showLoading: false,
      isBusy: false // groupTypeList: [],

    };
  },
  methods: {
    onRowSelected: function onRowSelected(items) {
      this.selected = items;
    },
    // rowClass(item, type, test) {
    //     if (!item || type !== 'row') return
    //     if (item.row_id === this.lastRowId) return 'newLine'
    // },
    clickSelectRow: function clickSelectRow(row_id, obj) {
      var vm = this;
      var checked = $("input[name=\"formula_select".concat(row_id, "\"]")).is(':checked');

      if (checked) {
        vm.setSelectedColumn(obj);
        var setDataRowsNotInterface = vm.dataList.data.filter(function (row, i) {
          return !vm.isDisabled(row);
        });

        if (setDataRowsNotInterface.length === vm.columnSelected.length) {
          $("input[name=\"formula_select_all\"]").prop('checked', true);
        }
      } else {
        var index = vm.columnSelected.indexOf(obj);

        if (index > -1) {
          vm.columnSelected.splice(index, 1);
          vm.columnSelectedId.splice(index, 1);
        }

        $("input[name=\"formula_select_all\"]").prop('checked', false);
      }
    }
  }
});

/***/ }),

/***/ "./resources/js/components/pm/settings/production-formula/table.vue":
/*!**************************************************************************!*\
  !*** ./resources/js/components/pm/settings/production-formula/table.vue ***!
  \**************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _table_vue_vue_type_template_id_cf39b414___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./table.vue?vue&type=template&id=cf39b414& */ "./resources/js/components/pm/settings/production-formula/table.vue?vue&type=template&id=cf39b414&");
/* harmony import */ var _table_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./table.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/settings/production-formula/table.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _table_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _table_vue_vue_type_template_id_cf39b414___WEBPACK_IMPORTED_MODULE_0__.render,
  _table_vue_vue_type_template_id_cf39b414___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/settings/production-formula/table.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/settings/production-formula/table.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/components/pm/settings/production-formula/table.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_table_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./table.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/settings/production-formula/table.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_table_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/settings/production-formula/table.vue?vue&type=template&id=cf39b414&":
/*!*********************************************************************************************************!*\
  !*** ./resources/js/components/pm/settings/production-formula/table.vue?vue&type=template&id=cf39b414& ***!
  \*********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_table_vue_vue_type_template_id_cf39b414___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_table_vue_vue_type_template_id_cf39b414___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_table_vue_vue_type_template_id_cf39b414___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./table.vue?vue&type=template&id=cf39b414& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/settings/production-formula/table.vue?vue&type=template&id=cf39b414&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/settings/production-formula/table.vue?vue&type=template&id=cf39b414&":
/*!************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/settings/production-formula/table.vue?vue&type=template&id=cf39b414& ***!
  \************************************************************************************************************************************************************************************************************************************************/
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
    { staticClass: "table-responsive" },
    [
      _c("b-table", {
        staticStyle: {
          display: "block",
          overflow: "auto",
          "max-height": "500px"
        },
        attrs: {
          "table-class": "table table-bordered",
          busy: _vm.isBusy,
          items: _vm.dataList.data,
          fields: _vm.fields,
          "current-page": _vm.currentPage,
          "per-page": _vm.perPage,
          "sort-by": _vm.sortBy,
          "sort-desc": _vm.sortDesc,
          "sort-direction": _vm.sortDirection,
          "primary-key": "row_id",
          "show-empty": "",
          small: "",
          hover: "",
          "select-mode": "single",
          selectable: ""
        },
        on: {
          "update:busy": function($event) {
            _vm.isBusy = $event
          },
          "update:sortBy": function($event) {
            _vm.sortBy = $event
          },
          "update:sort-by": function($event) {
            _vm.sortBy = $event
          },
          "update:sortDesc": function($event) {
            _vm.sortDesc = $event
          },
          "update:sort-desc": function($event) {
            _vm.sortDesc = $event
          },
          "row-selected": _vm.onRowSelected
        }
      })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);