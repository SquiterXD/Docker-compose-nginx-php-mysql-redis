(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_ir_product-inv_EditComponies_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/EditComponies.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/EditComponies.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var uuid_v1__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! uuid/v1 */ "./node_modules/uuid/v1.js");
/* harmony import */ var uuid_v1__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(uuid_v1__WEBPACK_IMPORTED_MODULE_1__);


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["header", "itemLocators", "itemCategories", 'backUrl', 'data', 'btnTrans'],
  data: function data() {
    return {
      flag: '',
      activeFlag: this.header.active_flag == 'Y' ? true : false,
      confirmActiveFlag: '',
      openProgamFlag: '',
      isDisabled: false,
      cate_code: '',
      lines: [],
      linesOld: [],
      id: uuid_v1__WEBPACK_IMPORTED_MODULE_1___default()(),
      productInvHeader: this.header.header_id,
      subinventoryCode: this.header.subinventory_code,
      subinventoryDesc: this.header.subinventory_desc,
      groupProductId: this.header.group_product_id,
      loading: {
        locator: '',
        page: false
      },
      itemLocatorsLists: this.itemLocators
    };
  },
  // watch: {
  //     confirmActiveFlag: function (newQuestion, oldQuestion) {
  //          
  //          
  //     }
  // },
  mounted: function mounted() {
    var _this = this;

    this.header.product_inv_lines.forEach(function (element) {
      _this.lines.push({
        id: uuid_v1__WEBPACK_IMPORTED_MODULE_1___default()(),
        lineId: element.line_id,
        cate_code: Number(element.category_code),
        locator: element.zone_code,
        delRow: true
      });
    });

    if (this.itemLocatorsLists.length == 0) {
      this.isDisabled = true;
    }

    this.header.product_inv_lines.forEach(function (element) {
      _this.linesOld.push({
        id: uuid_v1__WEBPACK_IMPORTED_MODULE_1___default()(),
        lineId: element.line_id,
        cate_code_old: Number(element.category_code),
        locator_old: element.zone_code,
        delRow: true
      });
    });

    if (this.data == "DuplicateLine") {
      swal({
        title: "warning !",
        text: "มีข้อมูลซ้ำ ระดับ Line",
        type: "warning",
        showConfirmButton: true
      });
    }
  },
  methods: {
    checkDuplicateCategory: function checkDuplicateCategory(row, index) {
      var _this2 = this;

      // this.lines.find(line => {
      //     if (line.id != row.id) {
      //         if (row.cate_code == line.cate_code) {
      //             row.cate_code = '';
      //             swal({
      //                 title: "Warning",
      //                 text: 'ไม่สามารถเลือก รหัสประเภท (Category Code) ซ้ำกันได้',
      //                 type: "warning",
      //                 showConfirmButton: true
      //             });
      //         }
      //     }
      // });
      this.lines.forEach(function (element, i) {
        if (i != index) {
          if (_this2.lines[index].cate_code == element.cate_code && _this2.lines[index].locator == element.locator) {
            _this2.showAlert();

            _this2.lines[index].locator = '';
            _this2.lines[index].cate_code = '';
            return;
          }
        }
      });
    },
    checkDuplicateLocators: function checkDuplicateLocators(index) {
      var _this3 = this;

      this.lines.forEach(function (element, i) {
        if (i != index) {
          if (_this3.lines[index].locator == element.locator && _this3.lines[index].cate_code == element.cate_code) {
            _this3.showAlert();

            _this3.lines[index].cate_code = '';
            _this3.lines[index].locator = '';
            return;
          }
        }
      });

      if (this.lines.locator != '') {
        this.searchFunction();
      }
    },
    showAlert: function showAlert() {
      swal({
        title: "Error !",
        text: "ไม่สามารถเลือกชุดข้อมูลนี้ได้ เนื่องจากมีชุดข้อมูลซ้ำ",
        type: "error",
        showConfirmButton: true
      });
    },
    addLine: function addLine() {
      var _this4 = this;

      this.lines.push({
        id: uuid_v1__WEBPACK_IMPORTED_MODULE_1___default()(),
        lineId: '',
        cate_code: '',
        locator: '',
        delRow: false
      });
      this.$nextTick(function () {
        var el = _this4.$el.getElementsByClassName('endTable')[0];

        if (el) {
          el.scrollIntoView({
            behavior: "smooth",
            block: "center",
            inline: "nearest"
          });
        }
      });
    },
    removeRow: function removeRow(index, delRow, row) {
      var _swal;

      var vm = this;
      var params = {
        sub_group_id: row.lineId
      }; // if(delRow){

      swal((_swal = {
        title: "Warning",
        text: "ต้องการลบหรือไม่!",
        type: "warning",
        showCancelButton: true
      }, _defineProperty(_swal, "showCancelButton", true), _defineProperty(_swal, "closeOnConfirm", true), _swal), function (isConfirm) {
        if (isConfirm) {
          if (delRow) {
            axios.get('/ir/ajax/destroy', {
              params: params
            }).then(function (res) {
              if (res.data.status === 's') {
                swal({
                  title: "Success",
                  text: "ได้ทำการลบข้อมูลเรียบร้อยแล้ว",
                  type: "success",
                  showConfirmButton: true
                });
                vm.lines.splice(index, 1); // window.location.reload(false);
              }
            });
          } else {
            vm.lines.splice(index, 1);
            swal({
              title: "Success",
              text: "ได้ทำการลบข้อมูลเรียบร้อยแล้ว",
              type: "success",
              showConfirmButton: true
            });
          }
        }
      }); // }else{
      // this.lines.splice(index, 1);
      // swal({  
      //     title: "Success", 
      //     text: "ได้ทำการลบข้อมูลเรียบร้อยแล้ว", 
      //     type: "success",
      //     showConfirmButton: true
      // });
      //     swal({
      //         title: "Warning",
      //         text: "ต้องการลบหรือไม่!",
      //         type: "warning",
      //         showCancelButton: true,
      //         showCancelButton: true,
      //         closeOnConfirm: true
      //     },                    
      //     function (isConfirm) {
      //         if(isConfirm){
      //             vm.lines.splice(index, 1);
      //             swal({  
      //                 title: "Success", 
      //                 text: "ได้ทำการลบข้อมูลเรียบร้อยแล้ว", 
      //                 type: "success",
      //                 showConfirmButton: true
      //             });
      //         }
      //     });
      // }
    },
    searchFunction: function searchFunction(query) {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _this5.loading.locator = true;
                _context.next = 3;
                return axios.get('/ir/ajax/get-value-set', {
                  params: {
                    subinventory_code: _this5.subinventoryCode,
                    status: 'Edit',
                    query: query
                  }
                }).then(function (res) {
                  _this5.itemLocatorsLists = res.data.data;
                })["catch"](function (err) {}).then(function () {
                  _this5.loading.locator = false;
                });

              case 3:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    checkActive: function checkActive(data) {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var flag, params, vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                flag = $("#checkbox".concat(data)).is(':checked');
                params = {
                  header_id: data,
                  active_flag: flag ? 'Y' :  true ? 'N' : 0
                };
                _this6.loading.page = true;
                vm = _this6;
                _context2.next = 6;
                return axios.get('/ir/ajax/product-header/getDataActiveFlag', {
                  params: params
                }).then(function (res) {
                  if (res.data.status == 'IRM0004Close') {
                    swal({
                      title: "คุณต้องการเปิดใช้งานใช่ไหม?",
                      text: "ข้อมูลหน้า IRM0004:ข้อมูลกลุ่มสินค้า มีการปิดการใช้งานอยู่ คุณต้องการเปิดการใช้งานทั้ง หน้า IRM0004 และ IRM0005 ใช่ไหม?",
                      type: "warning",
                      showCancelButton: true,
                      confirmButtonClass: 'btn btn-warning',
                      confirmButtonText: "เปิดการใช้งาน",
                      closeOnConfirm: false
                    }, function (isConfirm) {
                      if (isConfirm) {
                        vm.confirmActiveFlag = true;
                        vm.openProgamFlag = res.data.status;
                        swal.close();
                      } else {
                        $("#checkbox".concat(data)).prop('checked', false);
                      }
                    });
                    _this6.loading.page = false;
                  }

                  if (res.data.status == 'twoClose') {
                    swal({
                      title: "คุณต้องการเปิดใช้งานใช่ไหม?",
                      text: "ข้อมูลหน้า IRM0004:ข้อมูลกลุ่มสินค้า และ IRM0009: ข้อมูลกลุ่มย่อย มีการปิดการใช้งานอยู่ คุณต้องการเปิดการใช้งานทั้ง หน้า IRM0004 IRM0009 และ IRM0005 ใช่ไหม?",
                      type: "warning",
                      showCancelButton: true,
                      confirmButtonClass: 'btn btn-warning',
                      confirmButtonText: "เปิดการใช้งาน",
                      closeOnConfirm: false
                    }, function (isConfirm) {
                      if (isConfirm) {
                        vm.confirmActiveFlag = true;
                        vm.openProgamFlag = res.data.status;
                        swal.close();
                      } else {
                        $("#checkbox".concat(data)).prop('checked', false);
                      }
                    });
                    _this6.loading.page = false;
                  }

                  if (res.data.status == 'IRM0009Close') {
                    swal({
                      title: "คุณต้องการเปิดใช้งานใช่ไหม?",
                      text: "ข้อมูลหน้า IRM0009: ข้อมูลกลุ่มย่อย มีการปิดการใช้งานอยู่ คุณต้องการเปิดการใช้งานทั้ง หน้า IRM0009 และ IRM0005 ใช่ไหม?",
                      type: "warning",
                      showCancelButton: true,
                      confirmButtonClass: 'btn btn-warning',
                      confirmButtonText: "เปิดการใช้งาน",
                      closeOnConfirm: false
                    }, function (isConfirm) {
                      if (isConfirm) {
                        vm.confirmActiveFlag = true;
                        vm.openProgamFlag = res.data.status;
                        swal.close();
                      } else {
                        $("#checkbox".concat(data)).prop('checked', false);
                      }
                    });
                    _this6.loading.page = false;
                  }

                  if (res.data.status == 'success') {
                    _this6.loading.page = false;
                  }
                });

              case 6:
                return _context2.abrupt("return", _context2.sent);

              case 7:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/EditComponies.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/EditComponies.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, ".sticky-col {\n  position: -webkit-sticky;\n  position: sticky;\n  background-color: #f7f7f7;\n  z-index: 9999;\n}\n.first-col {\n  width: 150px;\n  min-width: 100px;\n  max-width: 150px;\n  left: 0px;\n}\n.second-col {\n  width: 150px;\n  min-width: 150px;\n  max-width: 150px;\n  left: 116px;\n  /*left: 150px;*/\n}\n.th-row {\n  /* width: 250px;\n    min-width: 150px;\n    max-width: 250px; */\n  top: 0;\n  /* left: 0px; */\n  /*left: 250px;*/\n}\n.fo-col {\n  width: 200px;\n  min-width: 150px;\n  max-width: 200px;\n  left: 416px;\n  /*left: 400px;*/\n}\n.fi-col {\n  width: 200px;\n  min-width: 150px;\n  max-width: 200px;\n  left: 566px;\n  /*left: 550px;*/\n}\n.t1-col {\n  width: 200px;\n  min-width: 150px;\n  max-width: 200px;\n  left: 0px;\n}\n.t2-col {\n  width: 200px;\n  min-width: 150px;\n  max-width: 200px;\n  left: 566px;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/EditComponies.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/EditComponies.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponies_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./EditComponies.vue?vue&type=style&index=0&scope=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/EditComponies.vue?vue&type=style&index=0&scope=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponies_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponies_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/components/ir/product-inv/EditComponies.vue":
/*!******************************************************************!*\
  !*** ./resources/js/components/ir/product-inv/EditComponies.vue ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _EditComponies_vue_vue_type_template_id_82f2ea70___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./EditComponies.vue?vue&type=template&id=82f2ea70& */ "./resources/js/components/ir/product-inv/EditComponies.vue?vue&type=template&id=82f2ea70&");
/* harmony import */ var _EditComponies_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./EditComponies.vue?vue&type=script&lang=js& */ "./resources/js/components/ir/product-inv/EditComponies.vue?vue&type=script&lang=js&");
/* harmony import */ var _EditComponies_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./EditComponies.vue?vue&type=style&index=0&scope=true&lang=css& */ "./resources/js/components/ir/product-inv/EditComponies.vue?vue&type=style&index=0&scope=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _EditComponies_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _EditComponies_vue_vue_type_template_id_82f2ea70___WEBPACK_IMPORTED_MODULE_0__.render,
  _EditComponies_vue_vue_type_template_id_82f2ea70___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ir/product-inv/EditComponies.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ir/product-inv/EditComponies.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************!*\
  !*** ./resources/js/components/ir/product-inv/EditComponies.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponies_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./EditComponies.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/EditComponies.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponies_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/ir/product-inv/EditComponies.vue?vue&type=style&index=0&scope=true&lang=css&":
/*!**************************************************************************************************************!*\
  !*** ./resources/js/components/ir/product-inv/EditComponies.vue?vue&type=style&index=0&scope=true&lang=css& ***!
  \**************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponies_vue_vue_type_style_index_0_scope_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./EditComponies.vue?vue&type=style&index=0&scope=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/EditComponies.vue?vue&type=style&index=0&scope=true&lang=css&");


/***/ }),

/***/ "./resources/js/components/ir/product-inv/EditComponies.vue?vue&type=template&id=82f2ea70&":
/*!*************************************************************************************************!*\
  !*** ./resources/js/components/ir/product-inv/EditComponies.vue?vue&type=template&id=82f2ea70& ***!
  \*************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponies_vue_vue_type_template_id_82f2ea70___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponies_vue_vue_type_template_id_82f2ea70___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponies_vue_vue_type_template_id_82f2ea70___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./EditComponies.vue?vue&type=template&id=82f2ea70& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/EditComponies.vue?vue&type=template&id=82f2ea70&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/EditComponies.vue?vue&type=template&id=82f2ea70&":
/*!****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ir/product-inv/EditComponies.vue?vue&type=template&id=82f2ea70& ***!
  \****************************************************************************************************************************************************************************************************************************************/
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
          value: _vm.loading.page,
          expression: "loading.page"
        }
      ]
    },
    [
      _c("input", {
        directives: [
          {
            name: "model",
            rawName: "v-model",
            value: _vm.subinventoryDesc,
            expression: "subinventoryDesc"
          }
        ],
        attrs: {
          type: "hidden",
          name: "subinventory_desc",
          autocomplete: "off"
        },
        domProps: { value: _vm.subinventoryDesc },
        on: {
          input: function($event) {
            if ($event.target.composing) {
              return
            }
            _vm.subinventoryDesc = $event.target.value
          }
        }
      }),
      _vm._v(" "),
      _c("input", {
        directives: [
          {
            name: "model",
            rawName: "v-model",
            value: _vm.subinventoryCode,
            expression: "subinventoryCode"
          }
        ],
        attrs: {
          type: "hidden",
          name: "subinventory_code",
          autocomplete: "off"
        },
        domProps: { value: _vm.subinventoryCode },
        on: {
          input: function($event) {
            if ($event.target.composing) {
              return
            }
            _vm.subinventoryCode = $event.target.value
          }
        }
      }),
      _vm._v(" "),
      _c("input", {
        directives: [
          {
            name: "model",
            rawName: "v-model",
            value: _vm.productInvHeader,
            expression: "productInvHeader"
          }
        ],
        attrs: {
          type: "hidden",
          name: "productInvHeader",
          autocomplete: "off"
        },
        domProps: { value: _vm.productInvHeader },
        on: {
          input: function($event) {
            if ($event.target.composing) {
              return
            }
            _vm.productInvHeader = $event.target.value
          }
        }
      }),
      _vm._v(" "),
      _c("input", {
        directives: [
          {
            name: "model",
            rawName: "v-model",
            value: _vm.groupProductId,
            expression: "groupProductId"
          }
        ],
        attrs: { type: "hidden", name: "groupProductId", autocomplete: "off" },
        domProps: { value: _vm.groupProductId },
        on: {
          input: function($event) {
            if ($event.target.composing) {
              return
            }
            _vm.groupProductId = $event.target.value
          }
        }
      }),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "mt-2" },
        [
          _c("div", { staticClass: "text-right" }, [
            _c(
              "button",
              {
                class: _vm.btnTrans.add.class + " btn-sm",
                attrs: { type: "submit" },
                on: {
                  click: function($event) {
                    $event.preventDefault()
                    return _vm.addLine($event)
                  }
                }
              },
              [
                _c("i", {
                  class: _vm.btnTrans.add.icon,
                  attrs: { "aria-hidden": "true" }
                }),
                _vm._v(" " + _vm._s(_vm.btnTrans.add.text) + " \n            ")
              ]
            )
          ]),
          _c("br"),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass: "table-responsive",
              staticStyle: { "max-height": "400px" }
            },
            [
              _c(
                "table",
                {
                  staticClass: "table-sm",
                  staticStyle: { position: "sticky" }
                },
                [
                  _vm._m(0),
                  _vm._v(" "),
                  _c(
                    "tbody",
                    _vm._l(_vm.lines, function(row, index) {
                      return _c(
                        "tr",
                        {
                          key: index,
                          class: [
                            index == _vm.lines.length - 1 ? "endTable" : ""
                          ],
                          attrs: { row: row }
                        },
                        [
                          _c(
                            "td",
                            { staticStyle: { "vertical-align": "middle" } },
                            [_vm._v(" " + _vm._s(index + 1) + " ")]
                          ),
                          _vm._v(" "),
                          _c(
                            "td",
                            { attrs: { id: "message" } },
                            [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: row.lineId,
                                    expression: "row.lineId"
                                  }
                                ],
                                attrs: {
                                  type: "hidden",
                                  name: "dataGroup[" + row.id + "][line_id]",
                                  autocomplete: "off"
                                },
                                domProps: { value: row.lineId },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(row, "lineId", $event.target.value)
                                  }
                                }
                              }),
                              _vm._v(" "),
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: row.cate_code,
                                    expression: "row.cate_code"
                                  }
                                ],
                                attrs: {
                                  type: "hidden",
                                  name: "dataGroup[" + row.id + "][cate_codes]",
                                  autocomplete: "off"
                                },
                                domProps: { value: row.cate_code },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      row,
                                      "cate_code",
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
                                    filterable: "",
                                    remote: "",
                                    clearable: "",
                                    "reserve-keyword": ""
                                  },
                                  on: {
                                    change: function($event) {
                                      return _vm.checkDuplicateCategory(
                                        row,
                                        index
                                      )
                                    }
                                  },
                                  model: {
                                    value: row.cate_code,
                                    callback: function($$v) {
                                      _vm.$set(row, "cate_code", $$v)
                                    },
                                    expression: "row.cate_code"
                                  }
                                },
                                _vm._l(_vm.itemCategories, function(
                                  itemCategory,
                                  index
                                ) {
                                  return _c("el-option", {
                                    key: index,
                                    attrs: {
                                      label:
                                        itemCategory.lookup_code +
                                        " : " +
                                        itemCategory.description,
                                      value: itemCategory.lookup_code
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
                                    value: row.locator,
                                    expression: "row.locator"
                                  }
                                ],
                                attrs: {
                                  type: "hidden",
                                  name: "dataGroup[" + row.id + "][locators]",
                                  autocomplete: "off"
                                },
                                domProps: { value: row.locator },
                                on: {
                                  input: function($event) {
                                    if ($event.target.composing) {
                                      return
                                    }
                                    _vm.$set(
                                      row,
                                      "locator",
                                      $event.target.value
                                    )
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
                                      value: _vm.loading.locator,
                                      expression: "loading.locator"
                                    }
                                  ],
                                  staticClass: "w-100",
                                  attrs: {
                                    filterable: "",
                                    remote: "",
                                    clearable: "",
                                    "reserve-keyword": "",
                                    disabled: _vm.isDisabled,
                                    "remote-method": _vm.searchFunction
                                  },
                                  on: {
                                    change: function($event) {
                                      return _vm.checkDuplicateLocators(index)
                                    }
                                  },
                                  model: {
                                    value: row.locator,
                                    callback: function($$v) {
                                      _vm.$set(row, "locator", $$v)
                                    },
                                    expression: "row.locator"
                                  }
                                },
                                _vm._l(_vm.itemLocatorsLists, function(
                                  Locator,
                                  index
                                ) {
                                  return _c("el-option", {
                                    key: index,
                                    attrs: {
                                      label:
                                        Locator.meaning +
                                        " : " +
                                        Locator.description,
                                      value: Locator.flex_value
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
                            {
                              staticClass: "text-center",
                              staticStyle: { "vertical-align": "middle" }
                            },
                            [
                              _c(
                                "button",
                                {
                                  staticClass: "btn btn-sm btn-danger",
                                  on: {
                                    click: function($event) {
                                      $event.preventDefault()
                                      return _vm.removeRow(
                                        index,
                                        row.delRow,
                                        row
                                      )
                                    }
                                  }
                                },
                                [
                                  _c("i", {
                                    staticClass: "fa fa-times",
                                    attrs: { "aria-hidden": "true" }
                                  })
                                ]
                              )
                            ]
                          )
                        ]
                      )
                    }),
                    0
                  )
                ]
              )
            ]
          ),
          _vm._v(" "),
          _vm._l(_vm.linesOld, function(row, index) {
            return _c("div", { key: index, attrs: { row: row } }, [
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: row.lineId,
                    expression: "row.lineId"
                  }
                ],
                attrs: {
                  type: "hidden",
                  name: "dataGroupOld[" + row.id + "][line_id]",
                  autocomplete: "off"
                },
                domProps: { value: row.lineId },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.$set(row, "lineId", $event.target.value)
                  }
                }
              }),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: row.cate_code_old,
                    expression: "row.cate_code_old"
                  }
                ],
                attrs: {
                  type: "hidden",
                  name: "dataGroupOld[" + row.id + "][cate_code_old]",
                  autocomplete: "off"
                },
                domProps: { value: row.cate_code_old },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.$set(row, "cate_code_old", $event.target.value)
                  }
                }
              }),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: row.locator_old,
                    expression: "row.locator_old"
                  }
                ],
                attrs: {
                  type: "hidden",
                  name: "dataGroupOld[" + row.id + "][locators_old]",
                  autocomplete: "off"
                },
                domProps: { value: row.locator_old },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.$set(row, "locator_old", $event.target.value)
                  }
                }
              })
            ])
          })
        ],
        2
      ),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass: "row",
          staticStyle: { "padding-left": "15px", "padding-top": "10px" }
        },
        [
          _c("label", [_vm._v("Active")]),
          _c("span", { staticClass: "text-danger" }, [_vm._v(" *")]),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.activeFlag,
                expression: "activeFlag"
              }
            ],
            attrs: { type: "hidden", name: "activeFlag" },
            domProps: { value: _vm.activeFlag },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.activeFlag = $event.target.value
              }
            }
          }),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.confirmActiveFlag,
                expression: "confirmActiveFlag"
              }
            ],
            attrs: { type: "hidden", name: "confirmActiveFlag" },
            domProps: { value: _vm.confirmActiveFlag },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.confirmActiveFlag = $event.target.value
              }
            }
          }),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.openProgamFlag,
                expression: "openProgamFlag"
              }
            ],
            attrs: { type: "hidden", name: "openProgamFlag" },
            domProps: { value: _vm.openProgamFlag },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.openProgamFlag = $event.target.value
              }
            }
          }),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.activeFlag,
                expression: "activeFlag"
              }
            ],
            staticStyle: { "margin-left": "10px" },
            attrs: { type: "checkbox", id: "checkbox" + _vm.header.header_id },
            domProps: {
              checked: _vm.header.showFlag,
              checked: Array.isArray(_vm.activeFlag)
                ? _vm._i(_vm.activeFlag, null) > -1
                : _vm.activeFlag
            },
            on: {
              change: [
                function($event) {
                  var $$a = _vm.activeFlag,
                    $$el = $event.target,
                    $$c = $$el.checked ? true : false
                  if (Array.isArray($$a)) {
                    var $$v = null,
                      $$i = _vm._i($$a, $$v)
                    if ($$el.checked) {
                      $$i < 0 && (_vm.activeFlag = $$a.concat([$$v]))
                    } else {
                      $$i > -1 &&
                        (_vm.activeFlag = $$a
                          .slice(0, $$i)
                          .concat($$a.slice($$i + 1)))
                    }
                  } else {
                    _vm.activeFlag = $$c
                  }
                },
                function($event) {
                  return _vm.checkActive(_vm.header.header_id)
                }
              ]
            }
          })
        ]
      ),
      _vm._v(" "),
      _c("div", { staticClass: "row clearfix text-right" }, [
        _c(
          "div",
          { staticClass: "col", staticStyle: { "margin-top": "15px" } },
          [
            _c(
              "button",
              {
                class: _vm.btnTrans.save.class + " btn-sm",
                attrs: { type: "submit" }
              },
              [
                _c("i", {
                  class: _vm.btnTrans.save.icon,
                  attrs: { "aria-hidden": "true" }
                }),
                _vm._v(
                  " \n                " +
                    _vm._s(_vm.btnTrans.save.text) +
                    " \n            "
                )
              ]
            ),
            _vm._v(" "),
            _c(
              "a",
              {
                class: _vm.btnTrans.cancel.class + " btn-sm",
                attrs: { href: _vm.backUrl, type: "button" }
              },
              [
                _c("i", {
                  class: _vm.btnTrans.cancel.icon,
                  attrs: { "aria-hidden": "true" }
                }),
                _vm._v(
                  " \n                " +
                    _vm._s(_vm.btnTrans.cancel.text) +
                    "\n            "
                )
              ]
            )
          ]
        )
      ])
    ]
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", { staticClass: "sticky-col th-row", attrs: { width: "1%" } }),
        _vm._v(" "),
        _c(
          "th",
          { staticClass: "sticky-col th-row", attrs: { width: "70%" } },
          [_vm._v(" รหัสประเภท (Category Code) ")]
        ),
        _vm._v(" "),
        _c(
          "th",
          { staticClass: "sticky-col th-row", attrs: { width: "30%" } },
          [_vm._v(" Locator ")]
        ),
        _vm._v(" "),
        _c("th", { staticClass: "sticky-col th-row", attrs: { width: "1%" } })
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);