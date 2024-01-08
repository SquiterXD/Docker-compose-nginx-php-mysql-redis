(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_om_approval-claim_tableComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/approval-claim/tableComponent.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/approval-claim/tableComponent.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************************************************************/
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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['lineList', 'checkStatus', 'btnTrans'],
  components: {
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_1___default())
  },
  data: function data() {
    return {
      uomNotTobaco: '',
      loadingTable: false,
      disenable: {
        approve: false
      },
      resultClick: [],
      status_color_template: {
        "อยู่ระหว่างการตรวจสอบ": {
          color: "#f90"
        },
        "อยู่ระหว่างการส่งสินค้า": {
          color: "#00f"
        },
        "อยู่ระหว่างการออกใบลดหนี้": {
          color: "#f0f"
        },
        "ปฏิเสธการเคลม": {
          color: "#f00"
        },
        "ลูกค้าได้รับสินค้าแล้ว": {
          color: "#00b050"
        },
        "ออกใบลดหนี้แล้ว": {
          color: "#f1c232"
        },
        "ปิดการเคลม": {
          color: "#676a6c"
        },
        "ยกเลิกการเคลม": {
          color: "#ff0000"
        },
        "อยู่ระหว่างการจ่ายเงินสดคืน": {
          color: "#00c0ff"
        },
        "รับเงินแล้ว": {
          color: "#9900ff"
        }
      }
    };
  },
  mounted: function mounted() {},
  methods: {
    checkSelectReplacement: function checkSelectReplacement(replacement, creditNote, cashBack, arrayData) {
      if (replacement) {
        arrayData.creditNote = '';
        arrayData.cashBack = '';
        arrayData.replacement = replacement;
      }
    },
    checkSelectCreditNote: function checkSelectCreditNote(replacement, creditNote, cashBack, arrayData) {
      if (creditNote) {
        arrayData.replacement = '';
        arrayData.cashBack = '';
        arrayData.creditNote = creditNote;
      }
    },
    checkSelectCashBack: function checkSelectCashBack(replacement, creditNote, cashBack, arrayData) {
      if (cashBack) {
        arrayData.replacement = '';
        arrayData.creditNote = '';
        arrayData.cashBack = cashBack;
      }
    },
    checkDate: function checkDate(value, event, data) {
      this.resultClick.push(value);
      var valObjApprove = this.resultClick.filter(function (value) {
        if (value == "Y") {
          return value;
        }
      });
      var valObjDisApproved = this.resultClick.filter(function (value) {
        if (value == "N") {
          return value;
        }
      });

      if (valObjApprove.length == 2 && valObjApprove[0] == "Y" || valObjDisApproved.length == 2 && valObjDisApproved[0] == "N") {
        data.approve = '';
        this.resultClick = [];
        valObjApprove = '';
        valObjDisApproved = '';
      } else {
        return;
      }
    },
    saveData: function saveData() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var vm, lineList;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                vm = _this;
                lineList = _this.lineList.filter(function (data) {
                  return data.approve == 'Y' && data.status_approve_claim == null || data.approve == 'N' && data.status_approve_claim == null || data.replacement == 'replacement' && data.replacement_flag == null || data.creditNote == 'creditNote' && data.replacement_flag == null || data.cashBack == 'cashBack' && data.replacement_flag == null;
                });

                if (!(lineList.length != 0)) {
                  _context.next = 6;
                  break;
                }

                lineList.forEach(function (element) {
                  if (element.status_claim_code == '2') {
                    if (element.remark_approve) {
                      element.validateRemarkApprove = false;

                      if (element.approve == 'N' && element.status_approve_claim == null) {
                        _this.loadingTable = true;
                        axios.post('ajax/approval-claim/update-approval-claim', {
                          lineList: lineList
                        }).then(function (res) {
                          if (res.data.status == "ERROR") {
                            swal({
                              title: "error !",
                              text: "ไม่สามารถบันทึกข้อมูลได้ เนื่องจาก " + res.data.err_msg,
                              type: "error",
                              showConfirmButton: true
                            });
                          } else if (res.data.result == "success") {
                            swal({
                              title: "success !",
                              text: "บันทึกอนุมัติการเคลม สำเร็จ!",
                              type: "success",
                              showConfirmButton: true
                            });
                            _this.disenable.approve = true;
                            vm.$parent.getSearch(vm.$parent.form_search);
                            _this.loadingTable = false;
                          }
                        });
                      }

                      if (element.approve == 'Y' && element.status_approve_claim == null) {
                        _this.loadingTable = true;
                        axios.post('ajax/approval-claim/update-approval-claim', {
                          lineList: lineList
                        }).then(function (res) {
                          if (res.data.status == "ERROR") {
                            swal({
                              title: "error !",
                              text: "ไม่สามารถบันทึกข้อมูลได้ เนื่องจาก " + res.data.err_msg,
                              type: "error",
                              showConfirmButton: true
                            });
                          } else if (res.data.result == "success") {
                            swal({
                              title: "success !",
                              text: "บันทึกอนุมัติการเคลม สำเร็จ!",
                              type: "success",
                              showConfirmButton: true
                            });
                            _this.disenable.approve = true;
                            vm.$parent.getSearch(vm.$parent.form_search);
                            _this.loadingTable = false;
                          }
                        });
                      }

                      if (element.replacement == 'replacement' && element.replacement_flag == null || element.creditNote == 'creditNote' && element.replacement_flag == null || element.cashBack == 'cashBack' && element.replacement_flag == null) {
                        _this.loadingTable = true;
                        axios.post('ajax/approval-claim/update-replacement', {
                          lineList: lineList
                        }).then(function (res) {
                          if (res.data.result == "success") {
                            swal({
                              title: "success !",
                              text: "บันทึก สำเร็จ!",
                              type: "success",
                              showConfirmButton: true
                            });
                            vm.$parent.getSearch(vm.$parent.form_search);
                            _this.loadingTable = false;
                          } else if (res.data.result == "disapproved") {
                            swal({
                              title: "error !",
                              text: "ไม่สามารถเลือกวิธีการส่งสินค้าทดแทน หรือออกใบลดหนี้ได้ เนื่องจากไม่อนุมัติการเคลม",
                              type: "error",
                              showConfirmButton: true
                            });
                            _this.loadingTable = false;
                          }
                        });
                      }
                    } else {
                      swal({
                        title: "คำเตือน !",
                        text: "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากกรอกข้อมูลไม่ครบถ้วน",
                        type: "warning",
                        showConfirmButton: true
                      });
                      element.validateRemarkApprove = true;
                      return;
                    }
                  }
                });
                _context.next = 8;
                break;

              case 6:
                swal({
                  title: "คำเตือน !",
                  text: "กรุณาเลือกรายการที่จะทำการ",
                  type: "warning",
                  showConfirmButton: true
                });
                return _context.abrupt("return");

              case 8:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    attachmentBind: function attachmentBind(att) {
      switch (att) {
        case "1":
          return "รูปถ่ายหน้าหีบ";
          break;

        case "2":
          return "รูปวันผลิตข้างซอง";
          break;

        case "3":
          return "รูปสินค้าที่เสียหาย";
          break;

        default:
          break;
      }
    },
    closedClaim: function closedClaim(value) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var vm;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                vm = _this2;
                swal({
                  title: "คุณแน่ใจ?",
                  text: "คุณต้องการปิดการเคลมสินค้าใช่ไหม ?",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonClass: 'btn btn-warning',
                  confirmButtonText: "ยืนยัน",
                  cancelButtonText: "ยกเลิก",
                  closeOnConfirm: false
                }, function (isConfirm) {
                  var _this3 = this;

                  if (isConfirm) {
                    axios.post('ajax/approval-claim/closed-claim', {
                      params: {
                        claim_header_id: value
                      }
                    }).then(function (res) {
                      if (res.data.result == "success") {
                        swal({
                          title: "success !",
                          text: "บันทึก สำเร็จ!",
                          type: "success",
                          showConfirmButton: true
                        });
                        vm.$parent.getSearch(vm.$parent.form_search);
                        _this3.loadingTable = false;
                      }
                    });
                  }
                });

              case 2:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    handlePrintBtn: function handlePrintBtn(id) {
      window.open('/om/ajax/approval-claim/report-claim' + "?claim_header_id=" + id);
    }
  }
});

/***/ }),

/***/ "./resources/js/components/om/approval-claim/tableComponent.vue":
/*!**********************************************************************!*\
  !*** ./resources/js/components/om/approval-claim/tableComponent.vue ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _tableComponent_vue_vue_type_template_id_0f9772b4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./tableComponent.vue?vue&type=template&id=0f9772b4& */ "./resources/js/components/om/approval-claim/tableComponent.vue?vue&type=template&id=0f9772b4&");
/* harmony import */ var _tableComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./tableComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/om/approval-claim/tableComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _tableComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _tableComponent_vue_vue_type_template_id_0f9772b4___WEBPACK_IMPORTED_MODULE_0__.render,
  _tableComponent_vue_vue_type_template_id_0f9772b4___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/om/approval-claim/tableComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/om/approval-claim/tableComponent.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/components/om/approval-claim/tableComponent.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_tableComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./tableComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/approval-claim/tableComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_tableComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/om/approval-claim/tableComponent.vue?vue&type=template&id=0f9772b4&":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/components/om/approval-claim/tableComponent.vue?vue&type=template&id=0f9772b4& ***!
  \*****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_tableComponent_vue_vue_type_template_id_0f9772b4___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_tableComponent_vue_vue_type_template_id_0f9772b4___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_tableComponent_vue_vue_type_template_id_0f9772b4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./tableComponent.vue?vue&type=template&id=0f9772b4& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/approval-claim/tableComponent.vue?vue&type=template&id=0f9772b4&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/approval-claim/tableComponent.vue?vue&type=template&id=0f9772b4&":
/*!********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/approval-claim/tableComponent.vue?vue&type=template&id=0f9772b4& ***!
  \********************************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "col-md-12" }, [
    _c("hr", { staticClass: "lg" }),
    _vm._v(" "),
    _c("div", { staticClass: "col-xl-12 tw-mb-3 tw-text-right" }, [
      _c(
        "button",
        {
          class: _vm.btnTrans.save.class,
          attrs: { type: "button" },
          on: {
            click: function($event) {
              return _vm.saveData()
            }
          }
        },
        [
          _c("i", { class: _vm.btnTrans.save.icon }),
          _vm._v(
            " \n                " +
              _vm._s(_vm.btnTrans.save.text) +
              "\n            "
          )
        ]
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "hr-line-dashed" }),
    _vm._v(" "),
    _c(
      "div",
      {
        directives: [
          {
            name: "loading",
            rawName: "v-loading",
            value: _vm.loadingTable,
            expression: "loadingTable"
          }
        ],
        staticClass: "table-responsive"
      },
      [
        _c(
          "table",
          {
            staticClass: "table table-bordered text-center",
            attrs: { id: "datatable" }
          },
          [
            _vm._m(0),
            _vm._v(" "),
            _c(
              "tbody",
              _vm._l(_vm.lineList, function(data, index) {
                return _c("tr", { key: index, staticClass: "align-middle" }, [
                  _c(
                    "td",
                    {
                      staticClass: "text-center text-danger",
                      staticStyle: { "vertical-align": "middle", width: "10%" }
                    },
                    [
                      _c(
                        "div",
                        {
                          staticClass:
                            "tw-m-auto tw-text-center tw-my-4 tw-px-3 tw-py-4",
                          style:
                            "color:#fff; font-weight:bold; background-color: " +
                            _vm.status_color_template[data.status_claim].color
                        },
                        [
                          _vm._v(
                            "\n                            " +
                              _vm._s(data.status_claim) +
                              " "
                          ),
                          _c("br"),
                          _vm._v(" "),
                          _c("div", [
                            _c(
                              "span",
                              {
                                staticStyle: {
                                  "font-size": "18px padding-top: 10px"
                                }
                              },
                              [_vm._v(_vm._s(data.status_claim_code))]
                            )
                          ])
                        ]
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "td",
                    {
                      staticClass: "text-left",
                      staticStyle: { "vertical-align": "middle", width: "30%" }
                    },
                    [
                      _c("div", { staticClass: "row" }, [
                        _c(
                          "div",
                          {
                            staticClass: "col-5",
                            staticStyle: {
                              "font-weight": "bold",
                              "vertical-align": "middle"
                            }
                          },
                          [
                            _vm._v(
                              "\n                                เลขที่ใบแจ้งเคลมสินค้า: \n                            "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c("div", { staticClass: "col-7" }, [
                          _vm._v(
                            "\n                                " +
                              _vm._s(data.claim_number)
                          ),
                          _c("br")
                        ])
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "row" }, [
                        _c(
                          "div",
                          {
                            staticClass: "col-5",
                            staticStyle: {
                              "font-weight": "bold",
                              "vertical-align": "middle"
                            }
                          },
                          [
                            _vm._v(
                              "\n                                วันที่แจ้งเคลมสินค้า: \n                            "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c("div", { staticClass: "col-7" }, [
                          _vm._v(
                            "\n                                " +
                              _vm._s(data.claim_date_converThDate)
                          ),
                          _c("br")
                        ])
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "row" }, [
                        _c(
                          "div",
                          {
                            staticClass: "col-5",
                            staticStyle: {
                              "font-weight": "bold",
                              "vertical-align": "middle"
                            }
                          },
                          [
                            _vm._v(
                              "\n                                อ้างอิง Invoice เลขที่: \n                            "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c("div", { staticClass: "col-7" }, [
                          _vm._v(
                            "\n                                " +
                              _vm._s(
                                data.ref_invoice_number
                                  ? data.ref_invoice_number
                                  : ""
                              )
                          ),
                          _c("br")
                        ])
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "row" }, [
                        _c(
                          "div",
                          {
                            staticClass: "col-5",
                            staticStyle: {
                              "font-weight": "bold",
                              "vertical-align": "middle"
                            }
                          },
                          [
                            _vm._v(
                              "\n                                วันที่ Invoice: \n                            "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c("div", { staticClass: "col-7" }, [
                          _vm._v(
                            "\n                                " +
                              _vm._s(data.invoice_date_converThDate)
                          ),
                          _c("br")
                        ])
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "row" }, [
                        _c(
                          "div",
                          {
                            staticClass: "col-5",
                            staticStyle: {
                              "font-weight": "bold",
                              "vertical-align": "middle"
                            }
                          },
                          [
                            _vm._v(
                              "\n                                อาการเสีย: \n                            "
                            )
                          ]
                        ),
                        _vm._v(" "),
                        _c("div", { staticClass: "col-7" }, [
                          _vm._v(
                            "\n                                " +
                              _vm._s(data.symptom_description)
                          ),
                          _c("br")
                        ])
                      ]),
                      _vm._v(" "),
                      data.credit_note_number
                        ? _c("div", { staticClass: "row" }, [
                            _c(
                              "div",
                              {
                                staticClass: "col-5",
                                staticStyle: {
                                  "font-weight": "bold",
                                  "vertical-align": "middle"
                                }
                              },
                              [
                                _vm._v(
                                  "\n                                ใบลดหนี้เลขที่: \n                            "
                                )
                              ]
                            ),
                            _vm._v(" "),
                            _c("div", { staticClass: "col-7" }, [
                              _vm._v(
                                "\n                                " +
                                  _vm._s(data.credit_note_number)
                              ),
                              _c("br")
                            ])
                          ])
                        : _vm._e(),
                      _vm._v(" "),
                      data.rma_number
                        ? _c("div", { staticClass: "row" }, [
                            _c(
                              "div",
                              {
                                staticClass: "col-5",
                                staticStyle: {
                                  "font-weight": "bold",
                                  "vertical-align": "middle"
                                }
                              },
                              [
                                _vm._v(
                                  "\n                                ใบคืนสินค้าเลขที่: \n                            "
                                )
                              ]
                            ),
                            _vm._v(" "),
                            _c("div", { staticClass: "col-7" }, [
                              _vm._v(
                                "\n                                " +
                                  _vm._s(data.rma_number)
                              ),
                              _c("br")
                            ])
                          ])
                        : _vm._e(),
                      _vm._v(" "),
                      _c(
                        "div",
                        {
                          staticStyle: {
                            "font-weight": "bold",
                            "vertical-align": "middle"
                          }
                        },
                        [
                          _vm._v(
                            "\n                            จำนวนสินค้าส่งเคลม:\n                        "
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "ul",
                        _vm._l(data.claim_lines, function(line, index) {
                          return _c("li", { key: index }, [
                            line.claim_quantity_cbb ||
                            line.claim_quantity_carton ||
                            line.claim_quantity_pack
                              ? _c("div", [
                                  _vm._v(
                                    "\n                                    " +
                                      _vm._s(line.item_description) +
                                      "\n                                    "
                                  ),
                                  line.claim_quantity_cbb
                                    ? _c("div", [
                                        _vm._v(
                                          "\n                                        " +
                                            _vm._s(line.claim_quantity_cbb) +
                                            "\n                                        " +
                                            _vm._s(
                                              data.uom_claim_quantity_cbb
                                                ? data.uom_claim_quantity_cbb
                                                    .unit_of_measure
                                                : ""
                                            ) +
                                            "\n                                    "
                                        )
                                      ])
                                    : _vm._e(),
                                  _vm._v(" "),
                                  line.claim_quantity_carton
                                    ? _c("div", [
                                        _vm._v(
                                          "\n                                        " +
                                            _vm._s(line.claim_quantity_carton) +
                                            "\n                                        " +
                                            _vm._s(
                                              data.uom_claim_quantity_carton
                                                ? data.uom_claim_quantity_carton
                                                    .unit_of_measure
                                                : ""
                                            ) +
                                            "\n                                    "
                                        )
                                      ])
                                    : _vm._e(),
                                  _vm._v(" "),
                                  line.claim_quantity_pack
                                    ? _c("div", [
                                        _vm._v(
                                          "\n                                        " +
                                            _vm._s(line.claim_quantity_pack) +
                                            "\n                                        " +
                                            _vm._s(
                                              data.uom_claim_quantity_pack
                                                ? data.uom_claim_quantity_pack
                                                    .unit_of_measure
                                                : ""
                                            ) +
                                            "\n                                    "
                                        )
                                      ])
                                    : _vm._e()
                                ])
                              : _vm._e(),
                            _vm._v(" "),
                            line.enter_claim_quantity
                              ? _c("div", [
                                  _vm._v(
                                    "\n                                    " +
                                      _vm._s(line.enter_claim_quantity) +
                                      "\n                                    " +
                                      _vm._s(
                                        data.uomEnterClaim[index]
                                          .unit_of_measure
                                      ) +
                                      "\n                                "
                                  )
                                ])
                              : _vm._e()
                          ])
                        }),
                        0
                      ),
                      _c("br"),
                      _vm._v(" "),
                      _c(
                        "button",
                        {
                          staticClass: "btn btn-primary",
                          attrs: {
                            type: "button",
                            "data-toggle": "modal",
                            "data-target":
                              "#exampleModalCenter" + data.claim_header_id
                          }
                        },
                        [
                          _vm._v(
                            "\n                            ดูไฟล์ที่แนบ\n                        "
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        {
                          staticClass: "modal fade",
                          attrs: {
                            id: "exampleModalCenter" + data.claim_header_id,
                            tabindex: "-1",
                            role: "dialog",
                            "aria-labelledby": "exampleModalCenterTitle",
                            "aria-hidden": "true"
                          }
                        },
                        [
                          _c(
                            "div",
                            {
                              staticClass: "modal-dialog modal-dialog-centered",
                              attrs: { role: "document" }
                            },
                            [
                              _c("div", { staticClass: "modal-content" }, [
                                _vm._m(1, true),
                                _vm._v(" "),
                                _c("div", { staticClass: "modal-body" }, [
                                  _c(
                                    "ul",
                                    _vm._l(data.claim_lines, function(
                                      line,
                                      index
                                    ) {
                                      return _c("li", { key: index }, [
                                        line.claim_quantity_cbb ||
                                        line.claim_quantity_carton ||
                                        line.claim_quantity_pack
                                          ? _c("div", [
                                              _vm._v(
                                                "\n                                                " +
                                                  _vm._s(
                                                    line.item_description
                                                  ) +
                                                  "\n                                            "
                                              )
                                            ])
                                          : _vm._e(),
                                        _vm._v(" "),
                                        _c(
                                          "div",
                                          {
                                            staticStyle: {
                                              "padding-left": "15px"
                                            }
                                          },
                                          _vm._l(data.attachment, function(
                                            attach,
                                            indexAttachment
                                          ) {
                                            return _c(
                                              "div",
                                              { key: attach.attachment_id },
                                              [
                                                index + 1 == attach.line_id
                                                  ? _c("div", [
                                                      _c("li", [
                                                        _c("div", [
                                                          _vm._v(
                                                            "\n                                                                " +
                                                              _vm._s(
                                                                "รายการที่ " +
                                                                  (indexAttachment +
                                                                    1)
                                                              ) +
                                                              "\n                                                                "
                                                          ),
                                                          _c(
                                                            "a",
                                                            {
                                                              attrs: {
                                                                target:
                                                                  "_blank",
                                                                href:
                                                                  "attachments/" +
                                                                  attach.attachment_id +
                                                                  "/image"
                                                              }
                                                            },
                                                            [
                                                              _vm._v(
                                                                "\n                                                                    " +
                                                                  _vm._s(
                                                                    _vm.attachmentBind(
                                                                      attach.attribute1
                                                                    )
                                                                  ) +
                                                                  "\n                                                                "
                                                              )
                                                            ]
                                                          )
                                                        ])
                                                      ])
                                                    ])
                                                  : _vm._e()
                                              ]
                                            )
                                          }),
                                          0
                                        )
                                      ])
                                    }),
                                    0
                                  )
                                ]),
                                _vm._v(" "),
                                _vm._m(2, true)
                              ])
                            ]
                          )
                        ]
                      )
                    ]
                  ),
                  _vm._v(" "),
                  _c("td", { staticClass: "text-left" }, [
                    _c("div", { staticClass: "form-group mt-2" }, [
                      _c("div", { staticClass: "row" }, [
                        _c("div", { staticClass: "col-4" }, [
                          _c("label", [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: data.approve,
                                  expression: "data.approve"
                                }
                              ],
                              attrs: {
                                type: "radio",
                                value: "Y",
                                name: "approve" + data.claim_header_id,
                                disabled:
                                  _vm.disenable.approve ||
                                  (data.status_approve_claim ? true : false) ||
                                  (data.status_claim_code == "7" ||
                                  data.status_claim_code == "8" ||
                                  data.status_claim_code == "9" ||
                                  data.status_claim_code == "6" ||
                                  data.status_claim_code == "5" ||
                                  data.status_claim_code == "3" ||
                                  data.status_claim_code == "4" ||
                                  data.status_claim_code == "10" ||
                                  data.status_claim_code == "11"
                                    ? true
                                    : false)
                              },
                              domProps: {
                                checked: data.approve == "Y" ? true : false,
                                checked: _vm._q(data.approve, "Y")
                              },
                              on: {
                                click: function($event) {
                                  return _vm.checkDate("Y", $event, data)
                                },
                                change: function($event) {
                                  return _vm.$set(data, "approve", "Y")
                                }
                              }
                            }),
                            _c(
                              "span",
                              { staticStyle: { "padding-left": "10px" } },
                              [_vm._v("อนุมัติ")]
                            )
                          ])
                        ]),
                        _vm._v(" "),
                        _c("div", { staticClass: "col-4" }, [
                          _c("label", [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: data.approve,
                                  expression: "data.approve"
                                }
                              ],
                              attrs: {
                                type: "radio",
                                value: "N",
                                name: "approve" + data.claim_header_id,
                                disabled:
                                  _vm.disenable.approve ||
                                  (data.status_approve_claim ? true : false) ||
                                  (data.status_claim_code == "7" ||
                                  data.status_claim_code == "8" ||
                                  data.status_claim_code == "9" ||
                                  data.status_claim_code == "6" ||
                                  data.status_claim_code == "5" ||
                                  data.status_claim_code == "3" ||
                                  data.status_claim_code == "4" ||
                                  data.status_claim_code == "10" ||
                                  data.status_claim_code == "11"
                                    ? true
                                    : false)
                              },
                              domProps: {
                                checked: data.approve == "N" ? true : false,
                                checked: _vm._q(data.approve, "N")
                              },
                              on: {
                                click: function($event) {
                                  return _vm.checkDate("N", $event, data)
                                },
                                change: function($event) {
                                  return _vm.$set(data, "approve", "N")
                                }
                              }
                            }),
                            _c(
                              "span",
                              { staticStyle: { "padding-left": "10px" } },
                              [_vm._v("ไม่อนุมัติ")]
                            )
                          ])
                        ])
                      ])
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "form-group" }, [
                      _c("label", { staticClass: "d-block" }, [
                        _vm._v("เนื่องจาก")
                      ]),
                      _vm._v(" "),
                      _c("textarea", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: data.remark_approve,
                            expression: "data.remark_approve"
                          }
                        ],
                        class:
                          "form-control " +
                          (data.validateRemarkApprove ? "is-invalid" : ""),
                        attrs: {
                          type: "textarea",
                          rows: 3,
                          placeholder: "เนื่องจาก",
                          disabled:
                            _vm.disenable.approve ||
                            (data.status_approve_claim ? true : false) ||
                            (data.status_claim_code == "7" ||
                            data.status_claim_code == "8" ||
                            data.status_claim_code == "9" ||
                            data.status_claim_code == "6" ||
                            data.status_claim_code == "5" ||
                            data.status_claim_code == "3" ||
                            data.status_claim_code == "4" ||
                            data.status_claim_code == "10" ||
                            data.status_claim_code == "11"
                              ? true
                              : false)
                        },
                        domProps: { value: data.remark_approve },
                        on: {
                          input: function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.$set(
                              data,
                              "remark_approve",
                              $event.target.value
                            )
                          }
                        }
                      })
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "form-group" }, [
                      _c(
                        "div",
                        { staticClass: "row space-5 align-items-center" },
                        [
                          _vm._m(3, true),
                          _vm._v(" "),
                          _c("div", { staticClass: "col-6" }, [
                            _c("div", { staticClass: "d-flex text-center" }, [
                              _c(
                                "div",
                                { staticClass: "form-group m-1" },
                                [
                                  _c("label", { staticClass: "d-block" }, [
                                    _vm._v("หีบ")
                                  ]),
                                  _vm._v(" "),
                                  _c("vue-numeric", {
                                    staticClass: "form-control text-right",
                                    attrs: {
                                      separator: ",",
                                      minus: false,
                                      placeholder: "จำนวนหีบ",
                                      disabled:
                                        _vm.disenable.approve ||
                                        (data.status_approve_claim
                                          ? true
                                          : false) ||
                                        (data.status_claim_code == "7" ||
                                        data.status_claim_code == "8" ||
                                        data.status_claim_code == "9" ||
                                        data.status_claim_code == "6" ||
                                        data.status_claim_code == "5" ||
                                        data.status_claim_code == "3" ||
                                        data.status_claim_code == "4" ||
                                        data.status_claim_code == "10" ||
                                        data.status_claim_code == "11"
                                          ? true
                                          : false)
                                    },
                                    model: {
                                      value: data.cardboard_box_quantity,
                                      callback: function($$v) {
                                        _vm.$set(
                                          data,
                                          "cardboard_box_quantity",
                                          $$v
                                        )
                                      },
                                      expression: "data.cardboard_box_quantity"
                                    }
                                  })
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c(
                                "div",
                                { staticClass: "form-group m-1" },
                                [
                                  _c("label", { staticClass: "d-block" }, [
                                    _vm._v("ห่อ")
                                  ]),
                                  _vm._v(" "),
                                  _c("vue-numeric", {
                                    staticClass: "form-control text-right",
                                    attrs: {
                                      separator: ",",
                                      minus: false,
                                      placeholder: "จำนวนห่อ",
                                      disabled:
                                        _vm.disenable.approve ||
                                        (data.status_approve_claim
                                          ? true
                                          : false) ||
                                        (data.status_claim_code == "7" ||
                                        data.status_claim_code == "8" ||
                                        data.status_claim_code == "9" ||
                                        data.status_claim_code == "6" ||
                                        data.status_claim_code == "5" ||
                                        data.status_claim_code == "3" ||
                                        data.status_claim_code == "4" ||
                                        data.status_claim_code == "10" ||
                                        data.status_claim_code == "11"
                                          ? true
                                          : false)
                                    },
                                    model: {
                                      value: data.cartons_quantity,
                                      callback: function($$v) {
                                        _vm.$set(data, "cartons_quantity", $$v)
                                      },
                                      expression: "data.cartons_quantity"
                                    }
                                  })
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c(
                                "div",
                                { staticClass: "form-group m-1" },
                                [
                                  _c("label", { staticClass: "d-block" }, [
                                    _vm._v("ซอง")
                                  ]),
                                  _vm._v(" "),
                                  _c("vue-numeric", {
                                    staticClass: "form-control text-right",
                                    attrs: {
                                      separator: ",",
                                      minus: false,
                                      placeholder: "จำนวนซอง",
                                      disabled:
                                        _vm.disenable.approve ||
                                        (data.status_approve_claim
                                          ? true
                                          : false) ||
                                        (data.status_claim_code == "7" ||
                                        data.status_claim_code == "8" ||
                                        data.status_claim_code == "9" ||
                                        data.status_claim_code == "6" ||
                                        data.status_claim_code == "5" ||
                                        data.status_claim_code == "3" ||
                                        data.status_claim_code == "4" ||
                                        data.status_claim_code == "10" ||
                                        data.status_claim_code == "11"
                                          ? true
                                          : false)
                                    },
                                    model: {
                                      value: data.pack_quantity,
                                      callback: function($$v) {
                                        _vm.$set(data, "pack_quantity", $$v)
                                      },
                                      expression: "data.pack_quantity"
                                    }
                                  })
                                ],
                                1
                              )
                            ])
                          ])
                        ]
                      )
                    ])
                  ]),
                  _vm._v(" "),
                  _c(
                    "td",
                    {
                      staticStyle: { "vertical-align": "middle", width: "10%" }
                    },
                    [
                      _c("div", [
                        _c(
                          "button",
                          {
                            class: _vm.btnTrans.print.class,
                            attrs: { type: "button" },
                            on: {
                              click: function($event) {
                                return _vm.handlePrintBtn(data.claim_header_id)
                              }
                            }
                          },
                          [
                            _c("i", { class: _vm.btnTrans.print.icon }, [
                              _vm._v(" ")
                            ])
                          ]
                        )
                      ]),
                      _vm._v(" "),
                      _c("div", { staticStyle: { "padding-top": "30px" } }, [
                        _c(
                          "button",
                          {
                            class: _vm.btnTrans.closedClaimTH.class,
                            attrs: {
                              type: "button",
                              disabled:
                                data.status_claim_code == "8" ? true : false
                            },
                            on: {
                              click: function($event) {
                                return _vm.closedClaim(data.claim_header_id)
                              }
                            }
                          },
                          [
                            _c("i", { class: _vm.btnTrans.closedClaimTH.icon }),
                            _vm._v(
                              " \n                            " +
                                _vm._s(_vm.btnTrans.closedClaimTH.text) +
                                "\n                            "
                            )
                          ]
                        )
                      ])
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "td",
                    {
                      staticClass: "text-left",
                      staticStyle: { "vertical-align": "middle", width: "20%" }
                    },
                    [
                      _c("div", { staticClass: "text-left" }, [
                        _c("label", [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: data.replacement,
                                expression: "data.replacement"
                              }
                            ],
                            attrs: {
                              type: "radio",
                              value: "replacement",
                              name: "claimMethod" + data.claim_header_id,
                              disabled:
                                data.status_approve_claim == null
                                  ? true
                                  :  false ||
                                    (data.status_claim_code == "7" ||
                                    data.status_claim_code == "8" ||
                                    data.status_claim_code == "9" ||
                                    data.status_claim_code == "6" ||
                                    data.status_claim_code == "5" ||
                                    data.status_claim_code == "3" ||
                                    data.status_claim_code == "4" ||
                                    data.status_claim_code == "10" ||
                                    data.status_claim_code == "11"
                                      ? true
                                      : false)
                            },
                            domProps: {
                              checked:
                                data.replacement == "Y"
                                  ? (data.replacement = "replacement")
                                  : false,
                              checked: _vm._q(data.replacement, "replacement")
                            },
                            on: {
                              change: [
                                function($event) {
                                  return _vm.$set(
                                    data,
                                    "replacement",
                                    "replacement"
                                  )
                                },
                                function($event) {
                                  return _vm.checkSelectReplacement(
                                    data.replacement,
                                    data.creditNote,
                                    data.cashBack,
                                    data
                                  )
                                }
                              ]
                            }
                          }),
                          _c(
                            "span",
                            { staticStyle: { "padding-left": "10px" } },
                            [_vm._v("ส่งสินค้าทดแทน")]
                          )
                        ])
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "text-left" }, [
                        _c("label", [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: data.creditNote,
                                expression: "data.creditNote"
                              }
                            ],
                            attrs: {
                              type: "radio",
                              value: "creditNote",
                              name: "claimMethod" + data.claim_header_id,
                              disabled:
                                data.status_approve_claim == null
                                  ? true
                                  :  false ||
                                    (data.status_claim_code == "7" ||
                                    data.status_claim_code == "8" ||
                                    data.status_claim_code == "9" ||
                                    data.status_claim_code == "6" ||
                                    data.status_claim_code == "5" ||
                                    data.status_claim_code == "3" ||
                                    data.status_claim_code == "4" ||
                                    data.status_claim_code == "10" ||
                                    data.status_claim_code == "11"
                                      ? true
                                      : false)
                            },
                            domProps: {
                              checked:
                                data.creditNote == "N"
                                  ? (data.creditNote = "creditNote")
                                  : false,
                              checked: _vm._q(data.creditNote, "creditNote")
                            },
                            on: {
                              change: [
                                function($event) {
                                  return _vm.$set(
                                    data,
                                    "creditNote",
                                    "creditNote"
                                  )
                                },
                                function($event) {
                                  return _vm.checkSelectCreditNote(
                                    data.replacement,
                                    data.creditNote,
                                    data.cashBack,
                                    data
                                  )
                                }
                              ]
                            }
                          }),
                          _c(
                            "span",
                            { staticStyle: { "padding-left": "10px" } },
                            [_vm._v("ออกใบลดหนี้")]
                          )
                        ])
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "text-left" }, [
                        _c("label", [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: data.cashBack,
                                expression: "data.cashBack"
                              }
                            ],
                            attrs: {
                              type: "radio",
                              value: "cashBack",
                              name: "claimMethod" + data.claim_header_id,
                              disabled:
                                data.status_approve_claim == null
                                  ? true
                                  :  false ||
                                    (data.status_claim_code == "7" ||
                                    data.status_claim_code == "8" ||
                                    data.status_claim_code == "9" ||
                                    data.status_claim_code == "6" ||
                                    data.status_claim_code == "5" ||
                                    data.status_claim_code == "3" ||
                                    data.status_claim_code == "4" ||
                                    data.status_claim_code == "10" ||
                                    data.status_claim_code == "11"
                                      ? true
                                      : false)
                            },
                            domProps: {
                              checked:
                                data.replacement == "C" ? data.cashBack : false,
                              checked: _vm._q(data.cashBack, "cashBack")
                            },
                            on: {
                              change: [
                                function($event) {
                                  return _vm.$set(data, "cashBack", "cashBack")
                                },
                                function($event) {
                                  return _vm.checkSelectCashBack(
                                    data.replacement,
                                    data.creditNote,
                                    data.cashBack,
                                    data
                                  )
                                }
                              ]
                            }
                          }),
                          _c(
                            "span",
                            { staticStyle: { "padding-left": "10px" } },
                            [_vm._v("จ่ายเงินสดคืน")]
                          )
                        ])
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "text-left" }, [
                        _c("label", [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: data.notSendBack,
                                expression: "data.notSendBack"
                              }
                            ],
                            attrs: {
                              type: "checkbox",
                              value: "notSendBack",
                              name: "notSendBack" + data.claim_header_id,
                              disabled:
                                data.status_approve_claim == null
                                  ? true
                                  :  false ||
                                    (data.status_claim_code == "7" ||
                                    data.status_claim_code == "8" ||
                                    data.status_claim_code == "9" ||
                                    data.status_claim_code == "6" ||
                                    data.status_claim_code == "5" ||
                                    data.status_claim_code == "3" ||
                                    data.status_claim_code == "4" ||
                                    data.status_claim_code == "10" ||
                                    data.status_claim_code == "11"
                                      ? true
                                      : false)
                            },
                            domProps: {
                              checked: Array.isArray(data.notSendBack)
                                ? _vm._i(data.notSendBack, "notSendBack") > -1
                                : data.notSendBack
                            },
                            on: {
                              change: function($event) {
                                var $$a = data.notSendBack,
                                  $$el = $event.target,
                                  $$c = $$el.checked ? true : false
                                if (Array.isArray($$a)) {
                                  var $$v = "notSendBack",
                                    $$i = _vm._i($$a, $$v)
                                  if ($$el.checked) {
                                    $$i < 0 &&
                                      _vm.$set(
                                        data,
                                        "notSendBack",
                                        $$a.concat([$$v])
                                      )
                                  } else {
                                    $$i > -1 &&
                                      _vm.$set(
                                        data,
                                        "notSendBack",
                                        $$a
                                          .slice(0, $$i)
                                          .concat($$a.slice($$i + 1))
                                      )
                                  }
                                } else {
                                  _vm.$set(data, "notSendBack", $$c)
                                }
                              }
                            }
                          }),
                          _c(
                            "span",
                            { staticStyle: { "padding-left": "10px" } },
                            [_vm._v("รับสินค้าคืนจากลูกค้า")]
                          )
                        ])
                      ]),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "form-group text-left mt-4" },
                        [
                          _c("label", { staticClass: "d-block" }, [
                            _vm._v("หมายเหตุ")
                          ]),
                          _vm._v(" "),
                          _c("el-input", {
                            attrs: {
                              type: "textarea",
                              rows: 3,
                              placeholder: "หมายเหตุ",
                              disabled:
                                data.status_approve_claim == null
                                  ? true
                                  :  false ||
                                    (data.status_claim_code == "7" ||
                                    data.status_claim_code == "8" ||
                                    data.status_claim_code == "9" ||
                                    data.status_claim_code == "6" ||
                                    data.status_claim_code == "5" ||
                                    data.status_claim_code == "3" ||
                                    data.status_claim_code == "4" ||
                                    data.status_claim_code == "10" ||
                                    data.status_claim_code == "11"
                                      ? true
                                      : false)
                            },
                            model: {
                              value: data.note,
                              callback: function($$v) {
                                _vm.$set(data, "note", $$v)
                              },
                              expression: "data.note"
                            }
                          })
                        ],
                        1
                      )
                    ]
                  )
                ])
              }),
              0
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
    return _c("thead", [
      _c("tr", { staticClass: "align-middle" }, [
        _c("th", { staticStyle: { "min-width": "200px" } }, [_vm._v("สถานะ")]),
        _vm._v(" "),
        _c("th", { staticStyle: { "min-width": "270px" } }, [
          _vm._v("รายละเอียด")
        ]),
        _vm._v(" "),
        _c("th", { staticStyle: { "min-width": "500px" } }, [
          _vm._v("อนุมัติการเคลม")
        ]),
        _vm._v(" "),
        _c("th", { staticStyle: { "min-width": "120px" } }, [
          _vm._v("ใบแจ้งเคลม")
        ]),
        _vm._v(" "),
        _c("th", { staticStyle: { "min-width": "200px" } }, [
          _vm._v("วิธีการเคลม")
        ])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "modal-header" }, [
      _c(
        "h5",
        { staticClass: "modal-title", attrs: { id: "exampleModalLongTitle" } },
        [_vm._v("ไฟล์แนบ")]
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
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "modal-footer" }, [
      _c(
        "button",
        {
          staticClass: "btn btn-secondary",
          attrs: { type: "button", "data-dismiss": "modal" }
        },
        [_vm._v("ปิด")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-6" }, [
      _c("label", { staticClass: "d-block m-0" }, [
        _vm._v("จำนวนที่สามารถ Rework ได้ :")
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);