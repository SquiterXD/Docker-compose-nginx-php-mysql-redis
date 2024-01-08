(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_qm_DefineTests_CreateComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/DefineTests/CreateComponent.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/DefineTests/CreateComponent.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-numeric */ "./node_modules/vue-numeric/dist/vue-numeric.min.js");
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_numeric__WEBPACK_IMPORTED_MODULE_0__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["units", "dataTypes", "resultSeverites", "processTestList", "entityTestList", "processDistinctTestList", "testTypeCode", "oldInput"],
  components: {
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_0___default())
  },
  data: function data() {
    return {
      test_desc: '',
      qcunit_code: '',
      data_type_code: '',
      negative_flag: false,
      decimals: '',
      enable_flag: true,
      qcunit_desc: '',
      lines: [],
      fileList: [],
      isNegativeFlag: false,
      isDecimals: false
    };
  },
  mounted: function mounted() {
    var _this = this;

    if (typeof this.oldInput !== 'undefined') {
      if (this.oldInput.length != 0) {
        this.oldInput.dataGroup.forEach(function (element, index) {
          _this.lines.push({
            test_desc: element.test_desc,
            qcunit_code: element.qcunit_code,
            data_type_code: element.data_type_code,
            negative_flag: element.negative_flag == "false" ? false : true,
            decimals: element.data_type_code == 'U' ? '' : Number(element.decimals),
            enable_flag: true,
            qcunit_desc: element.qcunit_code,
            fileList: [],
            resultSeverity: element.resultSeverity,
            testTypeCode: _this.testTypeCode,
            isNegativeFlag: element.data_type_code == 'U' ? true : false,
            isDecimals: element.data_type_code == 'U' ? true : false,
            decimals_valid: false
          });
        });
      }
    } else {
      this.addLine();
    }
  },
  methods: {
    addLine: function addLine() {
      this.lines.push({
        test_desc: '',
        qcunit_code: '',
        data_type_code: '',
        negative_flag: false,
        decimals: Number(0),
        enable_flag: true,
        qcunit_desc: '',
        fileList: [],
        resultSeverity: '',
        // entity          : '',
        // process         : '',
        // entityTestSearchList : this.entityTestList != [] ? this.entityTestList : [],
        // processTestSearchList : this.processDistinctTestList != [] ? this.processDistinctTestList : [],
        testTypeCode: this.testTypeCode,
        decimals_valid: false
      }); // this.showData();
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
        document.getElementById("btnSaveCreate").disabled = true;
        arr.decimals_valid = true;
      } else {
        arr.decimals_valid = false;
      }

      var flagValid = vm.lines.filter(function (row) {
        return row.decimals_valid == true;
      });

      if (flagValid.length == 0) {
        document.getElementById("btnSaveCreate").disabled = false;
      } else {
        document.getElementById("btnSaveCreate").disabled = true;
      }
    },
    getQcunitDesc: function getQcunitDesc(row, qcunit_code) {
      var qcunitDesc = this.units.find(function (item) {
        return qcunit_code == item.qcunit_code;
      });
      row.qcunit_desc = qcunitDesc.qcunit_desc;
    },
    getCheckDataType: function getCheckDataType(index, row, data_type_code) {
      if (index == index) {
        if (data_type_code == "U") {
          row.isNegativeFlag = true;
          row.isDecimals = true;
          row.decimals = '';
        } else {
          row.isNegativeFlag = false;
          row.isDecimals = false;
        }
      }
    },
    removeRow: function removeRow(index) {
      this.lines.splice(index, 1);
    },
    handleRemove: function handleRemove(file, fileList) {// console.log(file, fileList);
    },
    handlePreview: function handlePreview(file) {// console.log(file);
    },
    handleExceed: function handleExceed(files, fileList) {
      // this.$message.warning(`The limit is 5, you selected ${files.length} files this time, add up to ${files.length + fileList.length} totally`);
      swal({
        title: "คำเตือน !",
        text: "สามารถเลือกไฟล์รูปภาพได้สูงสุด 5 ไฟล์",
        type: "warning",
        showConfirmButton: true
      });
    },
    beforeRemove: function beforeRemove(file, fileList) {
      return this.$confirm("Cancel the transfert of ".concat(file.name, " ?"));
    },
    handleChange: function handleChange(file, fileList) {// this.fileList = fileList;
    } // async showData(index) {
    //     let vm = this;
    //     if(typeof index != 'undefined'){
    //         if (vm.lines[index].entity == '' || vm.lines[index].entity == undefined) {
    //             vm.lines[index].entityTestSearchList = (vm.entityTestList != undefined && vm.entityTestList) ? vm.entityTestList : [];
    //         }
    //         if (vm.lines[index].process == '' || vm.lines[index].process == undefined) {
    //             vm.lines[index].processTestSearchList = (vm.processTestList != undefined && vm.processTestList) ? vm.processDistinctTestList : [];
    //         }
    //         if (vm.lines[index].entity) {
    //             let selEntity = vm.entityTestList.filter(o => {
    //                 return o.entity_code == vm.lines[index].entity;
    //             });
    //             if (selEntity.length > 0) {
    //                 selEntity = selEntity[0];
    //                 vm.lines[index].processTestSearchList = vm.processTestList.filter(o => {
    //                     return o.entity_code == selEntity.entity_code;
    //                 })
    //             }
    //         }
    //         if (vm.lines[index].process) {
    //             let selProcess = vm.processTestList.filter(o => {
    //                 return o.process_code == vm.lines[index].process;
    //             });
    //             if (selProcess.length > 0) {
    //                 selProcess = selProcess[0];
    //                 vm.lines[index].entityTestSearchList = vm.entityTestList.filter(o => {
    //                     return o.process_code == selProcess.process_code;
    //                 })
    //             }
    //         }
    //     }             
    // },

  }
});

/***/ }),

/***/ "./resources/js/components/qm/DefineTests/CreateComponent.vue":
/*!********************************************************************!*\
  !*** ./resources/js/components/qm/DefineTests/CreateComponent.vue ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _CreateComponent_vue_vue_type_template_id_01668d50___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CreateComponent.vue?vue&type=template&id=01668d50& */ "./resources/js/components/qm/DefineTests/CreateComponent.vue?vue&type=template&id=01668d50&");
/* harmony import */ var _CreateComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CreateComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/qm/DefineTests/CreateComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _CreateComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _CreateComponent_vue_vue_type_template_id_01668d50___WEBPACK_IMPORTED_MODULE_0__.render,
  _CreateComponent_vue_vue_type_template_id_01668d50___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/qm/DefineTests/CreateComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/qm/DefineTests/CreateComponent.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************!*\
  !*** ./resources/js/components/qm/DefineTests/CreateComponent.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./CreateComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/DefineTests/CreateComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/qm/DefineTests/CreateComponent.vue?vue&type=template&id=01668d50&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/components/qm/DefineTests/CreateComponent.vue?vue&type=template&id=01668d50& ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateComponent_vue_vue_type_template_id_01668d50___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateComponent_vue_vue_type_template_id_01668d50___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateComponent_vue_vue_type_template_id_01668d50___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./CreateComponent.vue?vue&type=template&id=01668d50& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/DefineTests/CreateComponent.vue?vue&type=template&id=01668d50&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/DefineTests/CreateComponent.vue?vue&type=template&id=01668d50&":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/qm/DefineTests/CreateComponent.vue?vue&type=template&id=01668d50& ***!
  \******************************************************************************************************************************************************************************************************************************************/
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
      { staticClass: "text-right", staticStyle: { "padding-bottom": "20px" } },
      [
        _c(
          "button",
          {
            staticClass: "btn btn-sm btn-primary",
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
              staticClass: "fa fa-plus",
              attrs: { "aria-hidden": "true" }
            }),
            _vm._v(" เพิ่มรายการ \n        ")
          ]
        )
      ]
    ),
    _vm._v(" "),
    _c("div", { staticClass: "table-responsive" }, [
      _c("table", { staticClass: "table program_info_tb text-nowrap" }, [
        _vm._m(0),
        _vm._v(" "),
        _vm.lines.length
          ? _c(
              "tbody",
              _vm._l(_vm.lines, function(row, index) {
                return _c("tr", { key: index, attrs: { row: row } }, [
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
                          name: "dataGroup[" + index + "][data_type_code]"
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
                          attrs: { placeholder: "เลือก" },
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
                      staticStyle: { "vertical-align": "middle" }
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
                        attrs: { disabled: row.isNegativeFlag },
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
                          disabled: row.isDecimals
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
                            clearable: "",
                            "reserve-keyword": ""
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
                  _c(
                    "td",
                    {
                      staticClass: "text-center",
                      staticStyle: { "vertical-align": "middle" }
                    },
                    [
                      _c(
                        "el-upload",
                        {
                          staticClass: "upload-demo",
                          attrs: {
                            action:
                              "http://web-service.test/qm/settings/define-tests-tobacco-leaf/store",
                            "on-preview": _vm.handlePreview,
                            "on-remove": _vm.handleRemove,
                            "before-remove": _vm.beforeRemove,
                            "auto-upload": false,
                            name: "dataGroup[" + index + "][files][]",
                            multiple: "",
                            limit: 5,
                            "on-exceed": _vm.handleExceed,
                            "file-list": _vm.fileList
                          }
                        },
                        [
                          _c(
                            "el-button",
                            { attrs: { size: "small", type: "primary" } },
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
                            [_vm._v("สามารถอัปโหลดรูปภาพสูงสุด 5 รูปภาพ")]
                          )
                        ],
                        1
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c("td", { staticStyle: { "vertical-align": "middle" } }, [
                    _c(
                      "button",
                      {
                        staticClass: "btn btn-sm btn-danger",
                        on: {
                          click: function($event) {
                            $event.preventDefault()
                            return _vm.removeRow(index)
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
                  ])
                ])
              }),
              0
            )
          : _c("tbody", [_vm._m(1)])
      ])
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", { staticClass: "text-center" }, [
          _c("label", [_vm._v("ลำดับที่")])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [
          _c("label", [_vm._v("สถานะ"), _c("br"), _vm._v("การใช้งาน")])
        ]),
        _vm._v(" "),
        _c(
          "th",
          { staticClass: "text-center", staticStyle: { "min-width": "300px" } },
          [
            _c("label", [
              _vm._v("รายละเอียด การทดสอบ "),
              _c("span", { staticClass: "text-danger" }, [_vm._v(" *")])
            ])
          ]
        ),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [
          _c("label", [
            _vm._v("หน่วยการทดสอบ "),
            _c("span", { staticClass: "text-danger" }, [_vm._v(" *")])
          ])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [
          _c("label", [_vm._v("รายละเอียด หน่วยการทดสอบ")])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [
          _c("label", [
            _vm._v("ประเภทข้อมูล "),
            _c("span", { staticClass: "text-danger" }, [_vm._v(" *")])
          ])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [
          _c("label", [_vm._v("สามารถติดลบได้")])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [
          _c("label", [
            _vm._v("ทศนิยม "),
            _c("span", { staticClass: "text-danger" }, [_vm._v(" *")])
          ])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [
          _c("label", [
            _vm._v("ระดับความรุนแรงของข้อบกพร่อง "),
            _c("span", { staticClass: "text-danger" }, [_vm._v(" *")])
          ])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center" }, [
          _c("label", [_vm._v("รูปภาพประกอบ")])
        ]),
        _vm._v(" "),
        _c("th")
      ])
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
        [
          _c("h2", [
            _vm._v(
              ' ยังไม่มีข้อมูลที่จะสร้างใหม่ในตอนนี้ กรุณา "กด เพิ่มรายการ" '
            )
          ])
        ]
      )
    ])
  }
]
render._withStripped = true



/***/ })

}]);