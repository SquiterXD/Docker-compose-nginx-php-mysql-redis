(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pm_PrintConversion_TableComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/PrintConversion/TableComponent.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/PrintConversion/TableComponent.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-numeric */ "./node_modules/vue-numeric/dist/vue-numeric.min.js");
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vue_numeric__WEBPACK_IMPORTED_MODULE_1__);


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ['listConversion', 'lookupValues', 'btnTrans', 'printItemCatList', 'search', 'printTypeCode'],
  components: {
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_1___default())
  },
  data: function data() {
    return {
      listData: this.listConversion.data,
      lines: []
    };
  },
  mounted: function mounted() {
    $('.tablePrintConversion').dataTable({
      "searching": false,
      "bInfo": false
    }); // if(this.search.printItemCat == this.printTypeCode.gravure){
    //     $('.tablePrintConversion').dataTable( {
    //         "searching": false,
    //         "bInfo": false,
    //         columnDefs: [
    //             { orderable: false, targets: 3 },
    //             { orderable: false, targets: 4 },
    //             { orderable: false, targets: 5 },
    //             { orderable: false, targets: 6 },
    //             { orderable: false, targets: 7 },
    //             { orderable: false, targets: 8 }
    //         ]
    //     });
    // } 
  },
  methods: {
    checkEdit: function checkEdit(checkedEditUpdate, data) {
      if (checkedEditUpdate) {
        data.is_select = false;
      } else {
        data.is_select = true;
      }
    },
    addLine: function addLine() {
      if (this.search.printItemCat == this.printTypeCode.gravure) {
        this.lines.push({
          category_set_name: '',
          tobacco_size: this.search ? this.search.tobaccoSize : '',
          e00_to_bobbin: 0,
          bobbin_to_rol: 0,
          e00_to_rol: 0,
          e00_to_ca1: 0,
          ca1_to_rol: 0,
          meter_to_rol: 0,
          cg_to_e18: 0,
          enableFlag: true,
          category: '',
          printItemCat: this.search ? this.search.printItemCat : '',
          loading: {
            category: false
          },
          disabled: {
            category: true
          },
          categoryList: []
        });
      } else if (this.search.printItemCat == this.printTypeCode.contract_manuf) {
        this.lines.push({
          category_set_name: '',
          tobacco_size: this.search ? this.search.tobaccoSize : '',
          meter_to_rol: 0,
          st_to_pg: 0,
          bobbin_to_rol: 0,
          enableFlag: true,
          category: '',
          printItemCat: this.search ? this.search.printItemCat : '',
          molding_layout: '',
          paper_layout: '',
          loading: {
            category: false
          },
          disabled: {
            category: true
          },
          categoryList: []
        });
      } else {
        this.lines.push({
          category_set_name: '',
          tobacco_size: this.search ? this.search.tobaccoSize : '',
          enableFlag: true,
          category: '',
          printItemCat: this.search ? this.search.printItemCat : '',
          molding_layout: '',
          paper_layout: '',
          loading: {
            category: false
          },
          disabled: {
            category: true
          },
          categoryList: []
        });
      }

      if (this.lines.length != 0) {
        $('.tablePrintConversion').find(".dataTables_empty").parents('tbody').empty();
      }

      if (this.search && this.search.printItemCat) {
        this.getPrintType(this.search.printItemCat, this.lines[this.lines.length - 1]);
      }
    },
    removeRow: function removeRow(row) {
      this.lines.splice(row, 1);
    },
    getPrintType: function getPrintType(printItemCat, line) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var vm, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                vm = _this;

                if (vm.search && vm.search.category) {
                  line.category = vm.search.category;
                } else {
                  line.category = '';
                }

                line.loading.category = true;
                params = {
                  printItemCat: printItemCat
                };
                _context.next = 6;
                return axios.get('/pm/ajax/print-conversion/get-printType', {
                  params: params
                }).then(function (res) {
                  if (res.data.printTypeList.length != 0) {
                    line.categoryList = res.data.printTypeList;
                    line.loading.category = false;
                    line.disabled.category = false;
                  } else {
                    line.categoryList = [];
                    line.loading.category = false;
                    line.disabled.category = true;
                  }
                });

              case 6:
                return _context.abrupt("return", _context.sent);

              case 7:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    } // removeRowTableData: function(segment1, segment2, tobaccoSize){
    //     var params = {
    //         segment1 : segment1,
    //         segment2 : segment2,
    //         tobaccoSize : tobaccoSize
    //     };
    //     swal({
    //             title: "Are you sure?",
    //             text: "You will not be able to recover this data!",
    //             type: "warning",
    //             showCancelButton: true,
    //             confirmButtonClass: 'btn btn-warning',
    //             confirmButtonText: "Confirm",
    //             closeOnConfirm: false
    //         },                    
    //         function (isConfirm) {
    //             if(isConfirm){
    //                 axios   .get('/pm/ajax/print-conversion/destroy',{ params })
    //                         .then( res =>{ 
    //                             swal({  title: "success !", 
    //                                     text: "ข้อมูลได้ทำการลบเรียบร้อยแล้ว", 
    //                                     type: "success",
    //                                     showConfirmButton: false
    //                             });
    //                             window.location.reload(false); 
    //                         });   
    //             }
    //         });  
    // },

  }
});

/***/ }),

/***/ "./resources/js/components/pm/PrintConversion/TableComponent.vue":
/*!***********************************************************************!*\
  !*** ./resources/js/components/pm/PrintConversion/TableComponent.vue ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TableComponent_vue_vue_type_template_id_8c5457dc___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TableComponent.vue?vue&type=template&id=8c5457dc& */ "./resources/js/components/pm/PrintConversion/TableComponent.vue?vue&type=template&id=8c5457dc&");
/* harmony import */ var _TableComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TableComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/pm/PrintConversion/TableComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TableComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TableComponent_vue_vue_type_template_id_8c5457dc___WEBPACK_IMPORTED_MODULE_0__.render,
  _TableComponent_vue_vue_type_template_id_8c5457dc___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pm/PrintConversion/TableComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pm/PrintConversion/TableComponent.vue?vue&type=script&lang=js&":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/pm/PrintConversion/TableComponent.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/PrintConversion/TableComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pm/PrintConversion/TableComponent.vue?vue&type=template&id=8c5457dc&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/components/pm/PrintConversion/TableComponent.vue?vue&type=template&id=8c5457dc& ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponent_vue_vue_type_template_id_8c5457dc___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponent_vue_vue_type_template_id_8c5457dc___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponent_vue_vue_type_template_id_8c5457dc___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableComponent.vue?vue&type=template&id=8c5457dc& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/PrintConversion/TableComponent.vue?vue&type=template&id=8c5457dc&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/PrintConversion/TableComponent.vue?vue&type=template&id=8c5457dc&":
/*!*********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pm/PrintConversion/TableComponent.vue?vue&type=template&id=8c5457dc& ***!
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
  return _c("div", [
    _c(
      "div",
      { staticClass: "row", staticStyle: { "padding-bottom": "15px" } },
      [
        _c("div", { staticClass: "col-12 text-right" }, [
          _c(
            "button",
            {
              staticClass: "btn btn-primary",
              staticStyle: { "margin-right": "10px" },
              on: {
                click: function($event) {
                  $event.preventDefault()
                  return _vm.addLine($event)
                }
              }
            },
            [
              _c("i", {
                staticClass: "fa fa-plus",
                attrs: { "aria-hidden": "true" }
              }),
              _vm._v(" เพิ่มรายการ \n            ")
            ]
          ),
          _vm._v(" "),
          _c("button", { class: _vm.btnTrans.save.class }, [
            _c("i", {
              class: _vm.btnTrans.save.icon,
              attrs: { "aria-hidden": "true" }
            }),
            _vm._v(
              " \n                " +
                _vm._s(_vm.btnTrans.save.text) +
                " \n            "
            )
          ])
        ])
      ]
    ),
    _vm._v(" "),
    _c(
      "div",
      { staticStyle: { "overflow-x": "scroll", "white-space": "nowrap" } },
      [
        _c(
          "table",
          { staticClass: "table program_info_tb tablePrintConversion" },
          [
            _c("thead", [
              _c("tr", [
                _vm._m(0),
                _vm._v(" "),
                _vm._m(1),
                _vm._v(" "),
                _vm._m(2),
                _vm._v(" "),
                _vm._m(3),
                _vm._v(" "),
                _vm.search.printItemCat == _vm.printTypeCode.offset
                  ? _c(
                      "th",
                      {
                        staticClass: "text-center",
                        staticStyle: { "font-size": "small" }
                      },
                      [_c("div", [_vm._v("Layout แม่พิมพ์")])]
                    )
                  : _vm._e(),
                _vm._v(" "),
                _vm.search.printItemCat == _vm.printTypeCode.offset
                  ? _c(
                      "th",
                      {
                        staticClass: "text-center",
                        staticStyle: { "font-size": "small" }
                      },
                      [_c("div", [_vm._v("Layout กระดาษใหญ่")])]
                    )
                  : _vm._e(),
                _vm._v(" "),
                _vm.search.printItemCat == _vm.printTypeCode.gravure
                  ? _c(
                      "th",
                      {
                        staticClass: "text-right",
                        staticStyle: { "font-size": "small" }
                      },
                      [_c("div", [_vm._v("จำนวนชิ้น/Bobbin")])]
                    )
                  : _vm._e(),
                _vm._v(" "),
                _vm.search.printItemCat == _vm.printTypeCode.gravure
                  ? _c(
                      "th",
                      {
                        staticClass: "text-right",
                        staticStyle: { "font-size": "small" }
                      },
                      [_c("div", [_vm._v("Bobbin/ROL")])]
                    )
                  : _vm._e(),
                _vm._v(" "),
                _vm.search.printItemCat == _vm.printTypeCode.gravure
                  ? _c(
                      "th",
                      {
                        staticClass: "text-right",
                        staticStyle: { "font-size": "small" }
                      },
                      [_c("div", [_vm._v("จำนวนชิ้น/ROL")])]
                    )
                  : _vm._e(),
                _vm._v(" "),
                _vm.search.printItemCat == _vm.printTypeCode.gravure
                  ? _c(
                      "th",
                      {
                        staticClass: "text-right",
                        staticStyle: { "font-size": "small" }
                      },
                      [_c("div", [_vm._v("จำนวนชิ้น/หีบ")])]
                    )
                  : _vm._e(),
                _vm._v(" "),
                _vm.search.printItemCat == _vm.printTypeCode.gravure
                  ? _c(
                      "th",
                      {
                        staticClass: "text-right",
                        staticStyle: { "font-size": "small" }
                      },
                      [_c("div", [_vm._v("จำนวนหีบ/ROL")])]
                    )
                  : _vm._e(),
                _vm._v(" "),
                _vm.search.printItemCat == _vm.printTypeCode.gravure
                  ? _c(
                      "th",
                      {
                        staticClass: "text-right",
                        staticStyle: { "font-size": "small" }
                      },
                      [_c("div", [_vm._v("มวน/ซอง")])]
                    )
                  : _vm._e(),
                _vm._v(" "),
                _vm.search.printItemCat == _vm.printTypeCode.contract_manuf
                  ? _c(
                      "th",
                      {
                        staticClass: "text-right",
                        staticStyle: { "font-size": "small" }
                      },
                      [_c("div", [_vm._v("จำนวนเมตร/ROL")])]
                    )
                  : _vm._e(),
                _vm._v(" "),
                _vm.search.printItemCat == _vm.printTypeCode.contract_manuf
                  ? _c(
                      "th",
                      {
                        staticClass: "text-right",
                        staticStyle: { "font-size": "small" }
                      },
                      [_c("div", [_vm._v("จำนวนเดวง/แผ่น")])]
                    )
                  : _vm._e(),
                _vm._v(" "),
                _vm.search.printItemCat == _vm.printTypeCode.contract_manuf
                  ? _c(
                      "th",
                      {
                        staticClass: "text-right",
                        staticStyle: { "font-size": "small" }
                      },
                      [_c("div", [_vm._v("Bobbin/ROL")])]
                    )
                  : _vm._e(),
                _vm._v(" "),
                _c("th")
              ])
            ]),
            _vm._v(" "),
            _c(
              "tbody",
              [
                _vm._l(_vm.listData, function(data, index) {
                  return _c("tr", { key: index, attrs: { row: index } }, [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: data.id,
                          expression: "data.id"
                        }
                      ],
                      attrs: {
                        type: "hidden",
                        name: "updateDataGroup[" + index + "][id]",
                        autocomplete: "off"
                      },
                      domProps: { value: data.id },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(data, "id", $event.target.value)
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticStyle: {
                          "text-align": "center",
                          "vertical-align": "middle"
                        },
                        attrs: { "data-sort": data.enableFlag }
                      },
                      [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: data.enableFlag,
                              expression: "data.enableFlag"
                            }
                          ],
                          attrs: {
                            type: "hidden",
                            name: "updateDataGroup[" + index + "][enable_flag]",
                            autocomplete: "off"
                          },
                          domProps: { value: data.enableFlag },
                          on: {
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.$set(data, "enableFlag", $event.target.value)
                            }
                          }
                        }),
                        _vm._v(" "),
                        _c("el-checkbox", {
                          attrs: { disabled: data.is_select },
                          model: {
                            value: data.enableFlag,
                            callback: function($$v) {
                              _vm.$set(data, "enableFlag", $$v)
                            },
                            expression: "data.enableFlag"
                          }
                        })
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "td",
                      [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: data.cost_category_segment1,
                              expression: "data.cost_category_segment1"
                            }
                          ],
                          attrs: {
                            type: "hidden",
                            name:
                              "updateDataGroup[" +
                              index +
                              "][cost_category_segment1]",
                            autocomplete: "off"
                          },
                          domProps: { value: data.cost_category_segment1 },
                          on: {
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.$set(
                                data,
                                "cost_category_segment1",
                                $event.target.value
                              )
                            }
                          }
                        }),
                        _vm._v(" "),
                        _c("el-input", {
                          attrs: { disabled: true },
                          model: {
                            value: data.cost_category_set_name,
                            callback: function($$v) {
                              _vm.$set(data, "cost_category_set_name", $$v)
                            },
                            expression: "data.cost_category_set_name"
                          }
                        })
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "td",
                      { attrs: { "data-sort": data.category_set_name } },
                      [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: data.category_segment1,
                              expression: "data.category_segment1"
                            }
                          ],
                          attrs: {
                            type: "hidden",
                            name:
                              "updateDataGroup[" +
                              index +
                              "][category_segment1]",
                            autocomplete: "off"
                          },
                          domProps: { value: data.category_segment1 },
                          on: {
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.$set(
                                data,
                                "category_segment1",
                                $event.target.value
                              )
                            }
                          }
                        }),
                        _vm._v(" "),
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: data.category_segment2,
                              expression: "data.category_segment2"
                            }
                          ],
                          attrs: {
                            type: "hidden",
                            name:
                              "updateDataGroup[" +
                              index +
                              "][category_segment2]",
                            autocomplete: "off"
                          },
                          domProps: { value: data.category_segment2 },
                          on: {
                            input: function($event) {
                              if ($event.target.composing) {
                                return
                              }
                              _vm.$set(
                                data,
                                "category_segment2",
                                $event.target.value
                              )
                            }
                          }
                        }),
                        _vm._v(" "),
                        _c("el-input", {
                          attrs: { disabled: true },
                          model: {
                            value: data.category_set_name,
                            callback: function($$v) {
                              _vm.$set(data, "category_set_name", $$v)
                            },
                            expression: "data.category_set_name"
                          }
                        })
                      ],
                      1
                    ),
                    _vm._v(" "),
                    data.lookup_values.length != 0
                      ? _c(
                          "td",
                          [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: data.tobacco_size,
                                  expression: "data.tobacco_size"
                                }
                              ],
                              attrs: {
                                type: "hidden",
                                name:
                                  "updateDataGroup[" +
                                  index +
                                  "][tobacco_size]",
                                autocomplete: "off"
                              },
                              domProps: { value: data.tobacco_size },
                              on: {
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(
                                    data,
                                    "tobacco_size",
                                    $event.target.value
                                  )
                                }
                              }
                            }),
                            _vm._v(" "),
                            _c("el-input", {
                              attrs: { disabled: true },
                              model: {
                                value: data.tobacco_size,
                                callback: function($$v) {
                                  _vm.$set(data, "tobacco_size", $$v)
                                },
                                expression: "data.tobacco_size"
                              }
                            })
                          ],
                          1
                        )
                      : _c(
                          "td",
                          [
                            _c("el-input", {
                              attrs: { disabled: true },
                              model: {
                                value: data.tobacco_size,
                                callback: function($$v) {
                                  _vm.$set(data, "tobacco_size", $$v)
                                },
                                expression: "data.tobacco_size"
                              }
                            })
                          ],
                          1
                        ),
                    _vm._v(" "),
                    _vm.search.printItemCat == _vm.printTypeCode.gravure
                      ? _c(
                          "td",
                          [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: data.e00_to_bobbin,
                                  expression: "data.e00_to_bobbin"
                                }
                              ],
                              attrs: {
                                type: "hidden",
                                name:
                                  "updateDataGroup[" +
                                  index +
                                  "][e00_to_bobbin]",
                                autocomplete: "off"
                              },
                              domProps: { value: data.e00_to_bobbin },
                              on: {
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(
                                    data,
                                    "e00_to_bobbin",
                                    $event.target.value
                                  )
                                }
                              }
                            }),
                            _vm._v(" "),
                            _c("vue-numeric", {
                              staticClass: "form-control text-right",
                              attrs: {
                                separator: ",",
                                precision: 2,
                                minus: false,
                                disabled: data.is_select
                              },
                              model: {
                                value: data.e00_to_bobbin,
                                callback: function($$v) {
                                  _vm.$set(data, "e00_to_bobbin", $$v)
                                },
                                expression: "data.e00_to_bobbin"
                              }
                            })
                          ],
                          1
                        )
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.search.printItemCat == _vm.printTypeCode.gravure
                      ? _c(
                          "td",
                          [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: data.bobbin_to_rol,
                                  expression: "data.bobbin_to_rol"
                                }
                              ],
                              attrs: {
                                type: "hidden",
                                name:
                                  "updateDataGroup[" +
                                  index +
                                  "][bobbin_to_rol]",
                                autocomplete: "off"
                              },
                              domProps: { value: data.bobbin_to_rol },
                              on: {
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(
                                    data,
                                    "bobbin_to_rol",
                                    $event.target.value
                                  )
                                }
                              }
                            }),
                            _vm._v(" "),
                            _c("vue-numeric", {
                              staticClass: "form-control text-right",
                              attrs: {
                                separator: ",",
                                precision: 2,
                                minus: false,
                                disabled: data.is_select
                              },
                              model: {
                                value: data.bobbin_to_rol,
                                callback: function($$v) {
                                  _vm.$set(data, "bobbin_to_rol", $$v)
                                },
                                expression: "data.bobbin_to_rol"
                              }
                            })
                          ],
                          1
                        )
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.search.printItemCat == _vm.printTypeCode.gravure
                      ? _c(
                          "td",
                          [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: data.e00_to_rol,
                                  expression: "data.e00_to_rol"
                                }
                              ],
                              attrs: {
                                type: "hidden",
                                name:
                                  "updateDataGroup[" + index + "][e00_to_rol]",
                                autocomplete: "off"
                              },
                              domProps: { value: data.e00_to_rol },
                              on: {
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(
                                    data,
                                    "e00_to_rol",
                                    $event.target.value
                                  )
                                }
                              }
                            }),
                            _vm._v(" "),
                            _c("vue-numeric", {
                              staticClass: "form-control text-right",
                              attrs: {
                                separator: ",",
                                precision: 2,
                                minus: false,
                                disabled: data.is_select
                              },
                              model: {
                                value: data.e00_to_rol,
                                callback: function($$v) {
                                  _vm.$set(data, "e00_to_rol", $$v)
                                },
                                expression: "data.e00_to_rol"
                              }
                            })
                          ],
                          1
                        )
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.search.printItemCat == _vm.printTypeCode.gravure
                      ? _c(
                          "td",
                          [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: data.e00_to_ca1,
                                  expression: "data.e00_to_ca1"
                                }
                              ],
                              attrs: {
                                type: "hidden",
                                name:
                                  "updateDataGroup[" + index + "][e00_to_ca1]",
                                autocomplete: "off"
                              },
                              domProps: { value: data.e00_to_ca1 },
                              on: {
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(
                                    data,
                                    "e00_to_ca1",
                                    $event.target.value
                                  )
                                }
                              }
                            }),
                            _vm._v(" "),
                            _c("vue-numeric", {
                              staticClass: "form-control text-right",
                              attrs: {
                                separator: ",",
                                precision: 2,
                                minus: false,
                                disabled: data.is_select
                              },
                              model: {
                                value: data.e00_to_ca1,
                                callback: function($$v) {
                                  _vm.$set(data, "e00_to_ca1", $$v)
                                },
                                expression: "data.e00_to_ca1"
                              }
                            })
                          ],
                          1
                        )
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.search.printItemCat == _vm.printTypeCode.gravure
                      ? _c(
                          "td",
                          [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: data.ca1_to_rol,
                                  expression: "data.ca1_to_rol"
                                }
                              ],
                              attrs: {
                                type: "hidden",
                                name:
                                  "updateDataGroup[" + index + "][ca1_to_rol]",
                                autocomplete: "off"
                              },
                              domProps: { value: data.ca1_to_rol },
                              on: {
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(
                                    data,
                                    "ca1_to_rol",
                                    $event.target.value
                                  )
                                }
                              }
                            }),
                            _vm._v(" "),
                            _c("vue-numeric", {
                              staticClass: "form-control text-right",
                              attrs: {
                                separator: ",",
                                precision: 2,
                                minus: false,
                                disabled: data.is_select
                              },
                              model: {
                                value: data.ca1_to_rol,
                                callback: function($$v) {
                                  _vm.$set(data, "ca1_to_rol", $$v)
                                },
                                expression: "data.ca1_to_rol"
                              }
                            })
                          ],
                          1
                        )
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.search.printItemCat == _vm.printTypeCode.gravure
                      ? _c(
                          "td",
                          [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: data.cg_to_e18,
                                  expression: "data.cg_to_e18"
                                }
                              ],
                              attrs: {
                                type: "hidden",
                                name:
                                  "updateDataGroup[" + index + "][cg_to_e18]",
                                autocomplete: "off"
                              },
                              domProps: { value: data.cg_to_e18 },
                              on: {
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(
                                    data,
                                    "cg_to_e18",
                                    $event.target.value
                                  )
                                }
                              }
                            }),
                            _vm._v(" "),
                            _c("vue-numeric", {
                              staticClass: "form-control text-right",
                              attrs: {
                                separator: ",",
                                precision: 2,
                                minus: false,
                                disabled: data.is_select
                              },
                              model: {
                                value: data.cg_to_e18,
                                callback: function($$v) {
                                  _vm.$set(data, "cg_to_e18", $$v)
                                },
                                expression: "data.cg_to_e18"
                              }
                            })
                          ],
                          1
                        )
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.search.printItemCat == _vm.printTypeCode.offset
                      ? _c(
                          "td",
                          [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: data.molding_layout,
                                  expression: "data.molding_layout"
                                }
                              ],
                              attrs: {
                                type: "hidden",
                                name:
                                  "updateDataGroup[" +
                                  index +
                                  "][molding_layout]",
                                autocomplete: "off"
                              },
                              domProps: { value: data.molding_layout },
                              on: {
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(
                                    data,
                                    "molding_layout",
                                    $event.target.value
                                  )
                                }
                              }
                            }),
                            _vm._v(" "),
                            _c("vue-numeric", {
                              staticClass: "form-control text-right",
                              attrs: {
                                separator: ",",
                                precision: 0,
                                minus: false,
                                disabled: data.is_select
                              },
                              model: {
                                value: data.molding_layout,
                                callback: function($$v) {
                                  _vm.$set(data, "molding_layout", $$v)
                                },
                                expression: "data.molding_layout"
                              }
                            })
                          ],
                          1
                        )
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.search.printItemCat == _vm.printTypeCode.offset
                      ? _c(
                          "td",
                          [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: data.paper_layout,
                                  expression: "data.paper_layout"
                                }
                              ],
                              attrs: {
                                type: "hidden",
                                name:
                                  "updateDataGroup[" +
                                  index +
                                  "][paper_layout]",
                                autocomplete: "off"
                              },
                              domProps: { value: data.paper_layout },
                              on: {
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(
                                    data,
                                    "paper_layout",
                                    $event.target.value
                                  )
                                }
                              }
                            }),
                            _vm._v(" "),
                            _c("vue-numeric", {
                              staticClass: "form-control text-right",
                              attrs: {
                                separator: ",",
                                precision: 0,
                                minus: false,
                                disabled: data.is_select
                              },
                              model: {
                                value: data.paper_layout,
                                callback: function($$v) {
                                  _vm.$set(data, "paper_layout", $$v)
                                },
                                expression: "data.paper_layout"
                              }
                            })
                          ],
                          1
                        )
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.search.printItemCat == _vm.printTypeCode.contract_manuf
                      ? _c(
                          "td",
                          [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: data.meter_to_rol,
                                  expression: "data.meter_to_rol"
                                }
                              ],
                              attrs: {
                                type: "hidden",
                                name:
                                  "updateDataGroup[" +
                                  index +
                                  "][meter_to_rol]",
                                autocomplete: "off"
                              },
                              domProps: { value: data.meter_to_rol },
                              on: {
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(
                                    data,
                                    "meter_to_rol",
                                    $event.target.value
                                  )
                                }
                              }
                            }),
                            _vm._v(" "),
                            _c("vue-numeric", {
                              staticClass: "form-control text-right",
                              attrs: {
                                separator: ",",
                                precision: 2,
                                minus: false,
                                disabled: data.is_select
                              },
                              model: {
                                value: data.meter_to_rol,
                                callback: function($$v) {
                                  _vm.$set(data, "meter_to_rol", $$v)
                                },
                                expression: "data.meter_to_rol"
                              }
                            })
                          ],
                          1
                        )
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.search.printItemCat == _vm.printTypeCode.contract_manuf
                      ? _c(
                          "td",
                          [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: data.st_to_pg,
                                  expression: "data.st_to_pg"
                                }
                              ],
                              attrs: {
                                type: "hidden",
                                name:
                                  "updateDataGroup[" + index + "][st_to_pg]",
                                autocomplete: "off"
                              },
                              domProps: { value: data.st_to_pg },
                              on: {
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(
                                    data,
                                    "st_to_pg",
                                    $event.target.value
                                  )
                                }
                              }
                            }),
                            _vm._v(" "),
                            _c("vue-numeric", {
                              staticClass: "form-control text-right",
                              attrs: {
                                separator: ",",
                                precision: 2,
                                minus: false,
                                disabled: data.is_select
                              },
                              model: {
                                value: data.st_to_pg,
                                callback: function($$v) {
                                  _vm.$set(data, "st_to_pg", $$v)
                                },
                                expression: "data.st_to_pg"
                              }
                            })
                          ],
                          1
                        )
                      : _vm._e(),
                    _vm._v(" "),
                    _vm.search.printItemCat == _vm.printTypeCode.contract_manuf
                      ? _c(
                          "td",
                          [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: data.bobbin_to_rol,
                                  expression: "data.bobbin_to_rol"
                                }
                              ],
                              attrs: {
                                type: "hidden",
                                name:
                                  "updateDataGroup[" +
                                  index +
                                  "][bobbin_to_rol]",
                                autocomplete: "off"
                              },
                              domProps: { value: data.bobbin_to_rol },
                              on: {
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.$set(
                                    data,
                                    "bobbin_to_rol",
                                    $event.target.value
                                  )
                                }
                              }
                            }),
                            _vm._v(" "),
                            _c("vue-numeric", {
                              staticClass: "form-control text-right",
                              attrs: {
                                separator: ",",
                                precision: 2,
                                minus: false,
                                disabled: data.is_select
                              },
                              model: {
                                value: data.bobbin_to_rol,
                                callback: function($$v) {
                                  _vm.$set(data, "bobbin_to_rol", $$v)
                                },
                                expression: "data.bobbin_to_rol"
                              }
                            })
                          ],
                          1
                        )
                      : _vm._e(),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticStyle: {
                          "text-align": "center",
                          "vertical-align": "middle"
                        }
                      },
                      [
                        _c("el-checkbox", {
                          on: {
                            change: function($event) {
                              return _vm.checkEdit(data.checkedEditUpdate, data)
                            }
                          },
                          model: {
                            value: data.checkedEditUpdate,
                            callback: function($$v) {
                              _vm.$set(data, "checkedEditUpdate", $$v)
                            },
                            expression: "data.checkedEditUpdate"
                          }
                        })
                      ],
                      1
                    )
                  ])
                }),
                _vm._v(" "),
                _vm._l(_vm.lines, function(line, index) {
                  return _c(
                    "tr",
                    { key: "inputData" + index, attrs: { row: index } },
                    [
                      _c(
                        "td",
                        {
                          staticStyle: {
                            "text-align": "center",
                            "vertical-align": "middle"
                          }
                        },
                        [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: line.enableFlag,
                                expression: "line.enableFlag"
                              }
                            ],
                            attrs: {
                              type: "hidden",
                              name: "newDataGroup[" + index + "][enable_flag]",
                              autocomplete: "off"
                            },
                            domProps: { value: line.enableFlag },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.$set(
                                  line,
                                  "enableFlag",
                                  $event.target.value
                                )
                              }
                            }
                          }),
                          _vm._v(" "),
                          _c("el-checkbox", {
                            model: {
                              value: line.enableFlag,
                              callback: function($$v) {
                                _vm.$set(line, "enableFlag", $$v)
                              },
                              expression: "line.enableFlag"
                            }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "td",
                        [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: line.printItemCat,
                                expression: "line.printItemCat"
                              }
                            ],
                            attrs: {
                              type: "hidden",
                              name: "newDataGroup[" + index + "][printItemCat]",
                              autocomplete: "off"
                            },
                            domProps: { value: line.printItemCat },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.$set(
                                  line,
                                  "printItemCat",
                                  $event.target.value
                                )
                              }
                            }
                          }),
                          _vm._v(" "),
                          _c(
                            "el-select",
                            {
                              staticClass: "w-100",
                              attrs: {
                                placeholder: "โปรดเลือกระบบการพิมพ์",
                                clearable: "",
                                filterable: "",
                                remote: "",
                                "reserve-keyword": ""
                              },
                              on: {
                                change: function($event) {
                                  return _vm.getPrintType(
                                    line.printItemCat,
                                    line
                                  )
                                }
                              },
                              model: {
                                value: line.printItemCat,
                                callback: function($$v) {
                                  _vm.$set(line, "printItemCat", $$v)
                                },
                                expression: "line.printItemCat"
                              }
                            },
                            _vm._l(_vm.printItemCatList, function(
                              itemcat,
                              index
                            ) {
                              return _c("el-option", {
                                key: index,
                                attrs: {
                                  label: itemcat.cost_description,
                                  value: itemcat.cost_segment1
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
                        "td",
                        [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: line.category,
                                expression: "line.category"
                              }
                            ],
                            attrs: {
                              type: "hidden",
                              name: "newDataGroup[" + index + "][category]",
                              autocomplete: "off"
                            },
                            domProps: { value: line.category },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.$set(line, "category", $event.target.value)
                              }
                            }
                          }),
                          _vm._v(" "),
                          _c(
                            "el-select",
                            {
                              directives: [
                                {
                                  name: "loading",
                                  rawName: "v-loading",
                                  value: line.loading.category,
                                  expression: "line.loading.category"
                                }
                              ],
                              staticClass: "w-100",
                              attrs: {
                                placeholder: "เลือกประเภทสิ่งพิมพ์",
                                clearable: "",
                                disabled: line.disabled.category
                              },
                              model: {
                                value: line.category,
                                callback: function($$v) {
                                  _vm.$set(line, "category", $$v)
                                },
                                expression: "line.category"
                              }
                            },
                            _vm._l(line.categoryList, function(
                              category,
                              index
                            ) {
                              return _c("el-option", {
                                key: index,
                                attrs: {
                                  label: category.toat_description,
                                  value:
                                    category.toat_segment1 +
                                    "." +
                                    category.toat_segment2
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
                        "td",
                        [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: line.lookupValues,
                                expression: "line.lookupValues"
                              }
                            ],
                            attrs: {
                              type: "hidden",
                              name: "newDataGroup[" + index + "][lookupValues]",
                              autocomplete: "off"
                            },
                            domProps: { value: line.lookupValues },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.$set(
                                  line,
                                  "lookupValues",
                                  $event.target.value
                                )
                              }
                            }
                          }),
                          _vm._v(" "),
                          _c(
                            "el-select",
                            {
                              staticClass: "w-100",
                              attrs: {
                                placeholder: "เลือกขนาดบุหรี่",
                                clearable: "",
                                disabled: !line.category
                              },
                              model: {
                                value: line.lookupValues,
                                callback: function($$v) {
                                  _vm.$set(line, "lookupValues", $$v)
                                },
                                expression: "line.lookupValues"
                              }
                            },
                            _vm._l(_vm.lookupValues, function(
                              lookupValue,
                              index
                            ) {
                              return _c("el-option", {
                                key: index,
                                attrs: {
                                  label: lookupValue.meaning,
                                  value: lookupValue.lookup_code
                                }
                              })
                            }),
                            1
                          )
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _vm.search.printItemCat == _vm.printTypeCode.gravure
                        ? _c(
                            "td",
                            [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: line.e00_to_bobbin,
                                    expression: "line.e00_to_bobbin"
                                  }
                                ],
                                attrs: {
                                  type: "hidden",
                                  name:
                                    "newDataGroup[" +
                                    index +
                                    "][e00_to_bobbin]",
                                  autocomplete: "off"
                                },
                                domProps: { value: line.e00_to_bobbin },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      line,
                                      "e00_to_bobbin",
                                      $event.target.value
                                    )
                                  }
                                }
                              }),
                              _vm._v(" "),
                              _c("vue-numeric", {
                                staticClass: "form-control text-right",
                                attrs: {
                                  separator: ",",
                                  precision: 2,
                                  minus: false,
                                  disabled: !line.category
                                },
                                model: {
                                  value: line.e00_to_bobbin,
                                  callback: function($$v) {
                                    _vm.$set(line, "e00_to_bobbin", $$v)
                                  },
                                  expression: "line.e00_to_bobbin"
                                }
                              })
                            ],
                            1
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _vm.search.printItemCat == _vm.printTypeCode.gravure
                        ? _c(
                            "td",
                            [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: line.bobbin_to_rol,
                                    expression: "line.bobbin_to_rol"
                                  }
                                ],
                                attrs: {
                                  type: "hidden",
                                  name:
                                    "newDataGroup[" +
                                    index +
                                    "][bobbin_to_rol]",
                                  autocomplete: "off"
                                },
                                domProps: { value: line.bobbin_to_rol },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      line,
                                      "bobbin_to_rol",
                                      $event.target.value
                                    )
                                  }
                                }
                              }),
                              _vm._v(" "),
                              _c("vue-numeric", {
                                staticClass: "form-control text-right",
                                attrs: {
                                  separator: ",",
                                  precision: 2,
                                  minus: false,
                                  disabled: !line.category
                                },
                                model: {
                                  value: line.bobbin_to_rol,
                                  callback: function($$v) {
                                    _vm.$set(line, "bobbin_to_rol", $$v)
                                  },
                                  expression: "line.bobbin_to_rol"
                                }
                              })
                            ],
                            1
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _vm.search.printItemCat == _vm.printTypeCode.gravure
                        ? _c(
                            "td",
                            [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: line.e00_to_rol,
                                    expression: "line.e00_to_rol"
                                  }
                                ],
                                attrs: {
                                  type: "hidden",
                                  name:
                                    "newDataGroup[" + index + "][e00_to_rol]",
                                  autocomplete: "off"
                                },
                                domProps: { value: line.e00_to_rol },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      line,
                                      "e00_to_rol",
                                      $event.target.value
                                    )
                                  }
                                }
                              }),
                              _vm._v(" "),
                              _c("vue-numeric", {
                                staticClass: "form-control text-right",
                                attrs: {
                                  separator: ",",
                                  precision: 2,
                                  minus: false,
                                  disabled: !line.category
                                },
                                model: {
                                  value: line.e00_to_rol,
                                  callback: function($$v) {
                                    _vm.$set(line, "e00_to_rol", $$v)
                                  },
                                  expression: "line.e00_to_rol"
                                }
                              })
                            ],
                            1
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _vm.search.printItemCat == _vm.printTypeCode.gravure
                        ? _c(
                            "td",
                            [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: line.e00_to_ca1,
                                    expression: "line.e00_to_ca1"
                                  }
                                ],
                                attrs: {
                                  type: "hidden",
                                  name:
                                    "newDataGroup[" + index + "][e00_to_ca1]",
                                  autocomplete: "off"
                                },
                                domProps: { value: line.e00_to_ca1 },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      line,
                                      "e00_to_ca1",
                                      $event.target.value
                                    )
                                  }
                                }
                              }),
                              _vm._v(" "),
                              _c("vue-numeric", {
                                staticClass: "form-control text-right",
                                attrs: {
                                  separator: ",",
                                  precision: 2,
                                  minus: false,
                                  disabled: !line.category
                                },
                                model: {
                                  value: line.e00_to_ca1,
                                  callback: function($$v) {
                                    _vm.$set(line, "e00_to_ca1", $$v)
                                  },
                                  expression: "line.e00_to_ca1"
                                }
                              })
                            ],
                            1
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _vm.search.printItemCat == _vm.printTypeCode.gravure
                        ? _c(
                            "td",
                            [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: line.ca1_to_rol,
                                    expression: "line.ca1_to_rol"
                                  }
                                ],
                                attrs: {
                                  type: "hidden",
                                  name:
                                    "newDataGroup[" + index + "][ca1_to_rol]",
                                  autocomplete: "off"
                                },
                                domProps: { value: line.ca1_to_rol },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      line,
                                      "ca1_to_rol",
                                      $event.target.value
                                    )
                                  }
                                }
                              }),
                              _vm._v(" "),
                              _c("vue-numeric", {
                                staticClass: "form-control text-right",
                                attrs: {
                                  separator: ",",
                                  precision: 2,
                                  minus: false,
                                  disabled: !line.category
                                },
                                model: {
                                  value: line.ca1_to_rol,
                                  callback: function($$v) {
                                    _vm.$set(line, "ca1_to_rol", $$v)
                                  },
                                  expression: "line.ca1_to_rol"
                                }
                              })
                            ],
                            1
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _vm.search.printItemCat == _vm.printTypeCode.gravure
                        ? _c(
                            "td",
                            [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: line.cg_to_e18,
                                    expression: "line.cg_to_e18"
                                  }
                                ],
                                attrs: {
                                  type: "hidden",
                                  name:
                                    "newDataGroup[" + index + "][cg_to_e18]",
                                  autocomplete: "off"
                                },
                                domProps: { value: line.cg_to_e18 },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      line,
                                      "cg_to_e18",
                                      $event.target.value
                                    )
                                  }
                                }
                              }),
                              _vm._v(" "),
                              _c("vue-numeric", {
                                staticClass: "form-control text-right",
                                attrs: {
                                  separator: ",",
                                  precision: 2,
                                  minus: false,
                                  disabled: !line.category
                                },
                                model: {
                                  value: line.cg_to_e18,
                                  callback: function($$v) {
                                    _vm.$set(line, "cg_to_e18", $$v)
                                  },
                                  expression: "line.cg_to_e18"
                                }
                              })
                            ],
                            1
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _vm.search.printItemCat == _vm.printTypeCode.offset
                        ? _c(
                            "td",
                            [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: line.molding_layout,
                                    expression: "line.molding_layout"
                                  }
                                ],
                                attrs: {
                                  type: "hidden",
                                  name:
                                    "newDataGroup[" +
                                    index +
                                    "][molding_layout]",
                                  autocomplete: "off"
                                },
                                domProps: { value: line.molding_layout },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      line,
                                      "molding_layout",
                                      $event.target.value
                                    )
                                  }
                                }
                              }),
                              _vm._v(" "),
                              _c("vue-numeric", {
                                staticClass: "form-control text-right",
                                attrs: {
                                  separator: ",",
                                  precision: 0,
                                  minus: false
                                },
                                model: {
                                  value: line.molding_layout,
                                  callback: function($$v) {
                                    _vm.$set(line, "molding_layout", $$v)
                                  },
                                  expression: "line.molding_layout"
                                }
                              })
                            ],
                            1
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _vm.search.printItemCat == _vm.printTypeCode.offset
                        ? _c(
                            "td",
                            [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: line.paper_layout,
                                    expression: "line.paper_layout"
                                  }
                                ],
                                attrs: {
                                  type: "hidden",
                                  name:
                                    "newDataGroup[" + index + "][paper_layout]",
                                  autocomplete: "off"
                                },
                                domProps: { value: line.paper_layout },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      line,
                                      "paper_layout",
                                      $event.target.value
                                    )
                                  }
                                }
                              }),
                              _vm._v(" "),
                              _c("vue-numeric", {
                                staticClass: "form-control text-right",
                                attrs: {
                                  separator: ",",
                                  precision: 0,
                                  minus: false
                                },
                                model: {
                                  value: line.paper_layout,
                                  callback: function($$v) {
                                    _vm.$set(line, "paper_layout", $$v)
                                  },
                                  expression: "line.paper_layout"
                                }
                              })
                            ],
                            1
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _vm.search.printItemCat ==
                      _vm.printTypeCode.contract_manuf
                        ? _c(
                            "td",
                            [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: line.meter_to_rol,
                                    expression: "line.meter_to_rol"
                                  }
                                ],
                                attrs: {
                                  type: "hidden",
                                  name:
                                    "newDataGroup[" + index + "][meter_to_rol]",
                                  autocomplete: "off"
                                },
                                domProps: { value: line.meter_to_rol },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      line,
                                      "meter_to_rol",
                                      $event.target.value
                                    )
                                  }
                                }
                              }),
                              _vm._v(" "),
                              _c("vue-numeric", {
                                staticClass: "form-control text-right",
                                attrs: {
                                  separator: ",",
                                  precision: 2,
                                  minus: false,
                                  disabled: !line.category
                                },
                                model: {
                                  value: line.meter_to_rol,
                                  callback: function($$v) {
                                    _vm.$set(line, "meter_to_rol", $$v)
                                  },
                                  expression: "line.meter_to_rol"
                                }
                              })
                            ],
                            1
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _vm.search.printItemCat ==
                      _vm.printTypeCode.contract_manuf
                        ? _c(
                            "td",
                            [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: line.st_to_pg,
                                    expression: "line.st_to_pg"
                                  }
                                ],
                                attrs: {
                                  type: "hidden",
                                  name: "newDataGroup[" + index + "][st_to_pg]",
                                  autocomplete: "off"
                                },
                                domProps: { value: line.st_to_pg },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      line,
                                      "st_to_pg",
                                      $event.target.value
                                    )
                                  }
                                }
                              }),
                              _vm._v(" "),
                              _c("vue-numeric", {
                                staticClass: "form-control text-right",
                                attrs: {
                                  separator: ",",
                                  precision: 2,
                                  minus: false,
                                  disabled: !line.category
                                },
                                model: {
                                  value: line.st_to_pg,
                                  callback: function($$v) {
                                    _vm.$set(line, "st_to_pg", $$v)
                                  },
                                  expression: "line.st_to_pg"
                                }
                              })
                            ],
                            1
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _vm.search.printItemCat ==
                      _vm.printTypeCode.contract_manuf
                        ? _c(
                            "td",
                            [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: line.bobbin_to_rol,
                                    expression: "line.bobbin_to_rol"
                                  }
                                ],
                                attrs: {
                                  type: "hidden",
                                  name:
                                    "newDataGroup[" +
                                    index +
                                    "][bobbin_to_rol]",
                                  autocomplete: "off"
                                },
                                domProps: { value: line.bobbin_to_rol },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      line,
                                      "bobbin_to_rol",
                                      $event.target.value
                                    )
                                  }
                                }
                              }),
                              _vm._v(" "),
                              _c("vue-numeric", {
                                staticClass: "form-control text-right",
                                attrs: {
                                  separator: ",",
                                  precision: 2,
                                  minus: false,
                                  disabled: !line.category
                                },
                                model: {
                                  value: line.bobbin_to_rol,
                                  callback: function($$v) {
                                    _vm.$set(line, "bobbin_to_rol", $$v)
                                  },
                                  expression: "line.bobbin_to_rol"
                                }
                              })
                            ],
                            1
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _c("td", [
                        _c(
                          "button",
                          {
                            class: _vm.btnTrans.delete.class,
                            on: {
                              click: function($event) {
                                $event.preventDefault()
                                return _vm.removeRow(index)
                              }
                            }
                          },
                          [
                            _c("i", {
                              class: _vm.btnTrans.delete.icon,
                              attrs: { "aria-hidden": "true" }
                            })
                          ]
                        )
                      ])
                    ]
                  )
                })
              ],
              2
            )
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
      "th",
      { staticClass: "text-center", staticStyle: { "font-size": "small" } },
      [_c("div", [_vm._v("สถานะการใช้งาน")])]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "th",
      { staticClass: "text-center", staticStyle: { "font-size": "small" } },
      [_c("div", [_vm._v("ระบบการพิมพ์")])]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "th",
      { staticClass: "text-center", staticStyle: { "font-size": "small" } },
      [_c("div", [_vm._v("ประเภทสิ่งพิมพ์")])]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "th",
      { staticClass: "text-center", staticStyle: { "font-size": "small" } },
      [_c("div", [_vm._v("ขนาดบุหรี่")])]
    )
  }
]
render._withStripped = true



/***/ })

}]);