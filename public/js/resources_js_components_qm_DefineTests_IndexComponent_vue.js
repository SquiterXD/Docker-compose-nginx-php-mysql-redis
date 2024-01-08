(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_qm_DefineTests_IndexComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/DefineTests/IndexComponent.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/DefineTests/IndexComponent.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************************/
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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ["tests", "resultSeverites", "units", "dataTypes", 'processTestList', 'entityTestList', 'processDistinctTestList'],
  data: function data() {
    return {
      lines: [],
      fileList: [],
      test_type_code: '',
      hrefTarget: '_blank',
      entityTestSearchList: [],
      processTestSearchList: []
    };
  },
  components: {
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_1___default())
  },
  mounted: function mounted() {
    var _this = this;

    this.tests.data.forEach(function (element, index) {
      _this.getCheckDataType(index, element, element.data_type_code);

      _this.lines.push({
        test_id: element.test_id,
        test_code: element.test_code,
        test_desc: element.test_desc,
        qcunit_code: element.test_unit_code,
        data_type: element.data_type,
        data_type_code: element.data_type_code,
        negative_flag: element.negative_flag === "Y" ? true : false,
        decimals: element.data_type_code == 'U' ? 0 : Number(element.decimals),
        enable_flag: element.enable_flag === "Y" ? true : false,
        qcunit_desc: element.test_unit,
        attachment_id: element.attachment_id,
        resultSeverity: element.serverity_code ? element.serverity_code : '',
        disabledEdit: element.editable ? true : false,
        isNegativeFlag: element.isNegativeFlag,
        isDecimals: element.isDecimals,
        attachments: element.attachments,
        isAttachments: element.isAttachments,
        limitImage: element.limitImage,
        isUploadFlag: element.isUploadFlag,
        entity: element.check_list_code,
        process: element.qm_process_code,
        entityTestSearchList: _this.entityTestList,
        processTestSearchList: _this.processDistinctTestList,
        test_type_code: element.test_type_code,
        decimals_valid: false
      });

      _this.test_type_code = element.test_type_code;

      _this.showData(index);
    });
  },
  methods: {
    getCheckDataType: function getCheckDataType(index, row, data_type_code) {
      if (index == index) {
        if (data_type_code == "U" || data_type_code == "T") {
          row.isNegativeFlag = true;
          row.isDecimals = true;
        } else {
          row.isNegativeFlag = false;
          row.isDecimals = false;
        }
      }
    },
    getQcunitDesc: function getQcunitDesc(row, qcunit_code) {
      var qcunitDesc = this.units.find(function (item) {
        return qcunit_code == item.qcunit_code;
      });
      row.qcunit_desc = qcunitDesc.qcunit_desc;
    },
    handleRemove: function handleRemove(file, fileList) {// console.log(file, fileList);
    },
    handlePreview: function handlePreview(file) {
      console.log(file);
    },
    handleExceed: function handleExceed(files, fileList) {
      swal({
        title: "คำเตือน !",
        text: 'ไม่สามารถอัปโหลดรูปภาพเนื่องจากเกินจำนวนของรูปภาพ',
        type: "warning",
        showConfirmButton: true
      });
    },
    beforeRemove: function beforeRemove(file, fileList) {
      return this.$confirm("Cancel the transfert of ".concat(file.name, " ?"));
    },
    handleChange: function handleChange(file, fileList) {// this.fileList = fileList;
    },
    removeFile: function removeFile(id) {
      var testTypeCode = '';
      var vm = this;
      testTypeCode = vm.test_type_code;
      swal({
        title: "คุณแน่ใจ?",
        text: "คุณที่จะต้องการลบรูปภาพนี้ใช่ไหม ?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: 'btn btn-warning',
        confirmButtonText: "ยืนยัน",
        cancelButtonText: "ยกเลิก",
        closeOnConfirm: false
      }, function (isConfirm) {
        if (isConfirm) {
          return axios.get('/qm/ajax/attachments/' + id + '/' + testTypeCode + '/deleteByPKGDefineTests').then(function (res) {
            console.log(res.data.message);

            if (res.data.message == "Success") {
              swal({
                title: "success !",
                text: "ลบรูปภาพสำเร็จ !",
                type: "success",
                showConfirmButton: true
              });
              setTimeout(function () {
                window.location.reload(false);
              }, 3000);
            }
          });
        }
      });
    },
    showData: function showData(index) {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var vm, selEntity, selProcess;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                vm = _this2;

                if (typeof index != 'undefined') {
                  if (vm.lines[index].entity == '' || vm.lines[index].entity == undefined) {
                    vm.lines[index].entityTestSearchList = vm.entityTestList != undefined && vm.entityTestList ? vm.entityTestList : [];
                  }

                  if (vm.lines[index].process == '' || vm.lines[index].process == undefined) {
                    vm.lines[index].processTestSearchList = vm.processTestList != undefined && vm.processTestList ? vm.processDistinctTestList : [];
                  }

                  if (vm.lines[index].entity) {
                    selEntity = vm.entityTestList.filter(function (o) {
                      return o.entity_code == vm.lines[index].entity;
                    });

                    if (selEntity.length > 0) {
                      selEntity = selEntity[0];
                      vm.lines[index].processTestSearchList = vm.processTestList.filter(function (o) {
                        return o.entity_code == selEntity.entity_code;
                      });
                    }
                  }

                  if (vm.lines[index].process) {
                    selProcess = vm.processTestList.filter(function (o) {
                      return o.process_code == vm.lines[index].process;
                    });

                    if (selProcess.length > 0) {
                      selProcess = selProcess[0];
                      vm.lines[index].entityTestSearchList = vm.entityTestList.filter(function (o) {
                        return o.process_code == selProcess.process_code;
                      });
                    }
                  }
                }

              case 2:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getCheckNum: function getCheckNum(arr, num) {
      var vm = this;

      if (num > 9) {
        swal({
          title: "Warning",
          text: "ไม่สามารถกรอกตัวเลขจำนวนเต็ม " + num + " ได้ ต้องเป็นตัวเลขจำนวนเต็ม ระหว่าง 0 ถึง 9 เท่านั้น!",
          type: "warning",
          showCancelButton: true,
          closeOnConfirm: false
        });
        document.getElementById("btnSaveIndex").disabled = true;
        arr.decimals_valid = true;
      } else {
        arr.decimals_valid = false;
      }

      var flagValid = vm.lines.filter(function (row) {
        return row.decimals_valid == true;
      });

      if (flagValid.length == 0) {
        document.getElementById("btnSaveIndex").disabled = false;
      } else {
        document.getElementById("btnSaveIndex").disabled = true;
      }
    }
  }
});

/***/ }),

/***/ "./resources/js/components/qm/DefineTests/IndexComponent.vue":
/*!*******************************************************************!*\
  !*** ./resources/js/components/qm/DefineTests/IndexComponent.vue ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _IndexComponent_vue_vue_type_template_id_fbe4baa8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./IndexComponent.vue?vue&type=template&id=fbe4baa8& */ "./resources/js/components/qm/DefineTests/IndexComponent.vue?vue&type=template&id=fbe4baa8&");
/* harmony import */ var _IndexComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./IndexComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/qm/DefineTests/IndexComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _IndexComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _IndexComponent_vue_vue_type_template_id_fbe4baa8___WEBPACK_IMPORTED_MODULE_0__.render,
  _IndexComponent_vue_vue_type_template_id_fbe4baa8___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/qm/DefineTests/IndexComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/qm/DefineTests/IndexComponent.vue?vue&type=script&lang=js&":
/*!********************************************************************************************!*\
  !*** ./resources/js/components/qm/DefineTests/IndexComponent.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_IndexComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./IndexComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/DefineTests/IndexComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_IndexComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/qm/DefineTests/IndexComponent.vue?vue&type=template&id=fbe4baa8&":
/*!**************************************************************************************************!*\
  !*** ./resources/js/components/qm/DefineTests/IndexComponent.vue?vue&type=template&id=fbe4baa8& ***!
  \**************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_IndexComponent_vue_vue_type_template_id_fbe4baa8___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_IndexComponent_vue_vue_type_template_id_fbe4baa8___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_IndexComponent_vue_vue_type_template_id_fbe4baa8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./IndexComponent.vue?vue&type=template&id=fbe4baa8& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/DefineTests/IndexComponent.vue?vue&type=template&id=fbe4baa8&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/DefineTests/IndexComponent.vue?vue&type=template&id=fbe4baa8&":
/*!*****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/DefineTests/IndexComponent.vue?vue&type=template&id=fbe4baa8& ***!
  \*****************************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "table-responsive" }, [
    _c("table", { staticClass: "table program_info_tb text-nowrap" }, [
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
          _vm._m(4),
          _vm._v(" "),
          _vm._m(5),
          _vm._v(" "),
          _vm._m(6),
          _vm._v(" "),
          _vm._m(7),
          _vm._v(" "),
          this.test_type_code == "2"
            ? _c("th", { staticClass: "text-center" }, [_vm._m(8)])
            : _c("th", { staticClass: "text-center" }, [_vm._m(9)]),
          _vm._v(" "),
          this.test_type_code == "2"
            ? _c("th", { staticClass: "text-center" }, [
                _c("label", [_vm._v("รายการตรวจสอบคุณภาพบุหรี่")])
              ])
            : _vm._e(),
          _vm._v(" "),
          this.test_type_code == "2"
            ? _c(
                "th",
                {
                  staticClass: "text-center",
                  staticStyle: { "min-width": "220px" }
                },
                [_c("label", [_vm._v("กระบวนการตรวจคุณภาพบุหรี่ ")])]
              )
            : _vm._e(),
          _vm._v(" "),
          _vm._m(10),
          _vm._v(" "),
          _vm._m(11),
          _vm._v(" "),
          _c("th")
        ])
      ]),
      _vm._v(" "),
      _vm.lines.length
        ? _c(
            "tbody",
            _vm._l(_vm.lines, function(row, index) {
              return _c("tr", { key: index, attrs: { row: row } }, [
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: row.test_code,
                      expression: "row.test_code"
                    }
                  ],
                  attrs: {
                    type: "hidden",
                    name: "dataGroup[" + index + "][test_code]"
                  },
                  domProps: { value: row.test_code },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.$set(row, "test_code", $event.target.value)
                    }
                  }
                }),
                _vm._v(" "),
                _c(
                  "td",
                  {
                    staticClass: "text-center",
                    staticStyle: { "vertical-align": "middle" }
                  },
                  [_vm._v(_vm._s(index + 1))]
                ),
                _vm._v(" "),
                _c(
                  "td",
                  {
                    staticClass: "text-center",
                    staticStyle: { "vertical-align": "middle" }
                  },
                  [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: row.enable_flag,
                          expression: "row.enable_flag"
                        }
                      ],
                      attrs: {
                        type: "hidden",
                        name: "dataGroup[" + index + "][enable_flag]"
                      },
                      domProps: { value: row.enable_flag },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(row, "enable_flag", $event.target.value)
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c("el-checkbox", {
                      model: {
                        value: row.enable_flag,
                        callback: function($$v) {
                          _vm.$set(row, "enable_flag", $$v)
                        },
                        expression: "row.enable_flag"
                      }
                    })
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "td",
                  { staticStyle: { "vertical-align": "middle" } },
                  [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: row.test_desc,
                          expression: "row.test_desc"
                        }
                      ],
                      attrs: {
                        type: "hidden",
                        name: "dataGroup[" + index + "][test_desc]"
                      },
                      domProps: { value: row.test_desc },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(row, "test_desc", $event.target.value)
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c("el-input", {
                      attrs: {
                        placeholder: "กรอกลายละเอียด",
                        type: "textarea"
                      },
                      model: {
                        value: row.test_desc,
                        callback: function($$v) {
                          _vm.$set(row, "test_desc", $$v)
                        },
                        expression: "row.test_desc"
                      }
                    })
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "td",
                  { staticStyle: { "vertical-align": "middle" } },
                  [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: row.qcunit_code,
                          expression: "row.qcunit_code"
                        }
                      ],
                      attrs: {
                        type: "hidden",
                        name: "dataGroup[" + index + "][qcunit_code]"
                      },
                      domProps: { value: row.qcunit_code },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(row, "qcunit_code", $event.target.value)
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c(
                      "el-select",
                      {
                        attrs: {
                          placeholder: "เลือก",
                          "reserve-keyword": "",
                          filterable: ""
                        },
                        on: {
                          change: function($event) {
                            return _vm.getQcunitDesc(row, row.qcunit_code)
                          }
                        },
                        model: {
                          value: row.qcunit_code,
                          callback: function($$v) {
                            _vm.$set(row, "qcunit_code", $$v)
                          },
                          expression: "row.qcunit_code"
                        }
                      },
                      _vm._l(_vm.units, function(unit, index) {
                        return _c("el-option", {
                          key: index,
                          attrs: {
                            label: unit.qcunit_code,
                            value: unit.qcunit_code
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
                  { staticStyle: { "vertical-align": "middle" } },
                  [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: row.qcunit_desc,
                          expression: "row.qcunit_desc"
                        }
                      ],
                      attrs: {
                        type: "hidden",
                        name: "dataGroup[" + index + "][qcunit_desc]"
                      },
                      domProps: { value: row.qcunit_desc },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(row, "qcunit_desc", $event.target.value)
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c("el-input", {
                      attrs: { disabled: true },
                      model: {
                        value: row.qcunit_desc,
                        callback: function($$v) {
                          _vm.$set(row, "qcunit_desc", $$v)
                        },
                        expression: "row.qcunit_desc"
                      }
                    })
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "td",
                  { staticStyle: { "vertical-align": "middle" } },
                  [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: row.data_type_code,
                          expression: "row.data_type_code"
                        }
                      ],
                      attrs: {
                        type: "hidden",
                        name: "dataGroup[" + index + "][data_type]"
                      },
                      domProps: { value: row.data_type_code },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(row, "data_type_code", $event.target.value)
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c(
                      "el-select",
                      {
                        staticStyle: { width: "100px" },
                        attrs: { placeholder: "เลือก", disabled: true },
                        on: {
                          change: function($event) {
                            return _vm.getCheckDataType(
                              index,
                              row,
                              row.data_type_code
                            )
                          }
                        },
                        model: {
                          value: row.data_type_code,
                          callback: function($$v) {
                            _vm.$set(row, "data_type_code", $$v)
                          },
                          expression: "row.data_type_code"
                        }
                      },
                      _vm._l(_vm.dataTypes, function(dataType, index) {
                        return _c("el-option", {
                          key: index,
                          attrs: {
                            label: dataType.data_type,
                            value: dataType.data_type_code
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
                    staticStyle: { "padding-top": "30px" }
                  },
                  [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: row.negative_flag,
                          expression: "row.negative_flag"
                        }
                      ],
                      attrs: {
                        type: "hidden",
                        name: "dataGroup[" + index + "][negative_flag]"
                      },
                      domProps: { value: row.negative_flag },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(row, "negative_flag", $event.target.value)
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c("el-checkbox", {
                      attrs: {
                        disabled: row.disabledEdit || row.isNegativeFlag
                      },
                      model: {
                        value: row.negative_flag,
                        callback: function($$v) {
                          _vm.$set(row, "negative_flag", $$v)
                        },
                        expression: "row.negative_flag"
                      }
                    })
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "td",
                  { staticStyle: { "vertical-align": "middle" } },
                  [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: row.decimals,
                          expression: "row.decimals"
                        }
                      ],
                      attrs: {
                        type: "hidden",
                        name: "dataGroup[" + index + "][decimals]"
                      },
                      domProps: { value: row.decimals },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(row, "decimals", $event.target.value)
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c("vue-numeric", {
                      class:
                        "form-control text-right" +
                        (row.decimals_valid ? " is-invalid" : ""),
                      staticStyle: { width: "80px" },
                      attrs: {
                        separator: ",",
                        precision: 0,
                        minus: false,
                        disabled: row.disabledEdit || row.isDecimals
                      },
                      on: {
                        input: function($event) {
                          return _vm.getCheckNum(row, row.decimals)
                        }
                      },
                      model: {
                        value: row.decimals,
                        callback: function($$v) {
                          _vm.$set(row, "decimals", $$v)
                        },
                        expression: "row.decimals"
                      }
                    })
                  ],
                  1
                ),
                _vm._v(" "),
                _c(
                  "td",
                  { staticStyle: { "vertical-align": "middle" } },
                  [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: row.resultSeverity,
                          expression: "row.resultSeverity"
                        }
                      ],
                      attrs: {
                        type: "hidden",
                        name: "dataGroup[" + index + "][resultSeverity]"
                      },
                      domProps: { value: row.resultSeverity },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(row, "resultSeverity", $event.target.value)
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c(
                      "el-select",
                      {
                        attrs: {
                          placeholder: "เลือก",
                          disabled: row.disabledEdit,
                          "reserve-keyword": "",
                          clearable: ""
                        },
                        model: {
                          value: row.resultSeverity,
                          callback: function($$v) {
                            _vm.$set(row, "resultSeverity", $$v)
                          },
                          expression: "row.resultSeverity"
                        }
                      },
                      _vm._l(_vm.resultSeverites, function(data, index) {
                        return _c("el-option", {
                          key: index,
                          attrs: { label: data.meaning, value: data.meaning }
                        })
                      }),
                      1
                    )
                  ],
                  1
                ),
                _vm._v(" "),
                row.test_type_code == "2"
                  ? _c(
                      "td",
                      { staticStyle: { "vertical-align": "middle" } },
                      [
                        _c(
                          "el-select",
                          {
                            staticClass: "w-100",
                            attrs: {
                              placeholder: "ไม่มีข้อมูล",
                              clearable: "",
                              filterable: "",
                              remote: "",
                              "reserve-keyword": "",
                              disabled: ""
                            },
                            on: {
                              change: function($event) {
                                return _vm.showData(index)
                              }
                            },
                            model: {
                              value: row.entity,
                              callback: function($$v) {
                                _vm.$set(row, "entity", $$v)
                              },
                              expression: "row.entity"
                            }
                          },
                          _vm._l(row.entityTestSearchList, function(
                            data,
                            index
                          ) {
                            return _c("el-option", {
                              key: index,
                              attrs: {
                                label: data.entity_meaning,
                                value: data.entity_code
                              }
                            })
                          }),
                          1
                        )
                      ],
                      1
                    )
                  : _vm._e(),
                _vm._v(" "),
                row.test_type_code == "2"
                  ? _c(
                      "td",
                      { staticStyle: { "vertical-align": "middle" } },
                      [
                        _c(
                          "el-select",
                          {
                            staticClass: "w-100",
                            attrs: {
                              placeholder: "ไม่มีข้อมูล",
                              clearable: "",
                              filterable: "",
                              remote: "",
                              "reserve-keyword": "",
                              disabled: ""
                            },
                            on: {
                              change: function($event) {
                                return _vm.showData(index)
                              }
                            },
                            model: {
                              value: row.process,
                              callback: function($$v) {
                                _vm.$set(row, "process", $$v)
                              },
                              expression: "row.process"
                            }
                          },
                          _vm._l(row.processTestSearchList, function(
                            data,
                            index
                          ) {
                            return _c("el-option", {
                              key: index,
                              attrs: {
                                label: data.process_meaning,
                                value: data.process_code
                              }
                            })
                          }),
                          1
                        )
                      ],
                      1
                    )
                  : _vm._e(),
                _vm._v(" "),
                _c(
                  "td",
                  { staticStyle: { "vertical-align": "middle" } },
                  [
                    _c(
                      "el-upload",
                      {
                        staticClass: "upload-demo",
                        attrs: {
                          action:
                            "http://web-service.test/qm/settings/define-tests-tobacco-leaf/update",
                          "on-preview": _vm.handlePreview,
                          "on-remove": _vm.handleRemove,
                          "before-remove": _vm.beforeRemove,
                          "auto-upload": false,
                          name: "dataGroup[" + index + "][files][]",
                          multiple: "",
                          limit: row.limitImage,
                          "on-exceed": _vm.handleExceed,
                          disabled: row.isUploadFlag,
                          "file-list": _vm.fileList
                        }
                      },
                      [
                        _c(
                          "el-button",
                          {
                            attrs: {
                              size: "small",
                              type: "primary",
                              disabled: row.isUploadFlag
                            }
                          },
                          [_vm._v("เพิ่มรูปภาพ")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          {
                            staticClass: "el-upload__tip",
                            attrs: { slot: "tip" },
                            slot: "tip"
                          },
                          [
                            _vm._v(
                              "สามารถเพิ่มได้อีก " +
                                _vm._s(row.limitImage) +
                                " รูป สูงสุดไม่เกิน 5 รูป"
                            )
                          ]
                        )
                      ],
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
                        staticClass: "btn btn-primary",
                        attrs: {
                          type: "button",
                          "data-toggle": "modal",
                          "data-target":
                            "#exampleModalScrollable" + row.test_id,
                          disabled: row.isAttachments
                        }
                      },
                      [
                        _c("i", {
                          staticClass: "fa fa-file-image-o",
                          attrs: { "aria-hidden": "true" }
                        }),
                        _vm._v(" ดูรูปภาพ\n                    ")
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass: "modal fade",
                        attrs: {
                          id: "exampleModalScrollable" + row.test_id,
                          tabindex: "-1",
                          role: "dialog",
                          "aria-labelledby":
                            "exampleModalScrollableTitle" + row.test_id,
                          "aria-hidden": "true"
                        }
                      },
                      [
                        _c(
                          "div",
                          {
                            staticClass: "modal-dialog modal-dialog-scrollable",
                            attrs: { role: "document" }
                          },
                          [
                            _c("div", { staticClass: "modal-content" }, [
                              _vm._m(12, true),
                              _vm._v(" "),
                              _c("div", { staticClass: "modal-body" }, [
                                _c(
                                  "ul",
                                  _vm._l(row.attachments, function(attach) {
                                    return _c(
                                      "li",
                                      {
                                        key: attach.attachment_id,
                                        staticStyle: { "text-align": "left" }
                                      },
                                      [
                                        _c(
                                          "a",
                                          {
                                            attrs: {
                                              target: _vm.hrefTarget,
                                              href:
                                                "attachments/" +
                                                attach.attachment_id +
                                                "/" +
                                                _vm.test_type_code +
                                                "/imageDefineTests"
                                            }
                                          },
                                          [
                                            _vm._v(
                                              "\n                                            " +
                                                _vm._s(attach.file_name) +
                                                "\n                                        "
                                            )
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "a",
                                          {
                                            on: {
                                              click: function($event) {
                                                return _vm.removeFile(
                                                  attach.attachment_id
                                                )
                                              }
                                            }
                                          },
                                          [
                                            _c("i", {
                                              staticClass: "fa fa-close",
                                              staticStyle: {
                                                color: "red",
                                                "text-align": "right"
                                              }
                                            })
                                          ]
                                        )
                                      ]
                                    )
                                  }),
                                  0
                                )
                              ]),
                              _vm._v(" "),
                              _vm._m(13, true)
                            ])
                          ]
                        )
                      ]
                    )
                  ]
                )
              ])
            }),
            0
          )
        : _c("tbody", [_vm._m(14)])
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("th", { staticClass: "text-center" }, [
      _c("label", [_vm._v("ลำดับที่")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("th", { staticClass: "text-center" }, [
      _c("label", [_vm._v("สถานะ"), _c("br"), _vm._v("การใช้งาน")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "th",
      { staticClass: "text-center", staticStyle: { "min-width": "300px" } },
      [
        _c("label", [
          _vm._v("รายละเอียด การทดสอบ "),
          _c("span", { staticClass: "text-danger" }, [_vm._v(" *")])
        ])
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("th", { staticClass: "text-center" }, [
      _c("label", [
        _vm._v("หน่วยการทดสอบ "),
        _c("span", { staticClass: "text-danger" }, [_vm._v(" *")])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("th", { staticClass: "text-center" }, [
      _c("label", [_vm._v("รายละเอียด"), _c("br"), _vm._v("หน่วยการทดสอบ")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("th", { staticClass: "text-center" }, [
      _c("label", [
        _vm._v("ประเภทข้อมูล "),
        _c("span", { staticClass: "text-danger" }, [_vm._v(" *")])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("th", { staticClass: "text-center" }, [
      _c("label", [_vm._v("สามารถติดลบได้")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("th", { staticClass: "text-center" }, [
      _c("label", [
        _vm._v("ทศนิยม "),
        _c("span", { staticClass: "text-danger" }, [_vm._v(" *")])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v("ระดับความรุนแรง"),
      _c("br"),
      _vm._v("ของข้อบกพร่อง")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", [
      _vm._v("ระดับความรุนแรง"),
      _c("br"),
      _vm._v("ของความผิดปกติ (อาการ)")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("th", { staticClass: "text-center" }, [
      _c("label", [_vm._v("อัปโหลดรูปภาพประกอบ")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("th", { staticClass: "text-center" }, [
      _c("label", [_vm._v("รูปภาพประกอบ")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "modal-header" }, [
      _c(
        "h5",
        {
          staticClass: "modal-title",
          attrs: { id: "exampleModalScrollableTitle" }
        },
        [_vm._v("ดูแนบรูปภาพ")]
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
    return _c("tr", [
      _c(
        "td",
        {
          staticClass: "text-center",
          staticStyle: { "vertical-align": "middle", width: "100%" },
          attrs: { colspan: "11" }
        },
        [_c("h2", [_vm._v(" ไม่มีข้อมูลในระบบ ")])]
      )
    ])
  }
]
render._withStripped = true



/***/ })

}]);