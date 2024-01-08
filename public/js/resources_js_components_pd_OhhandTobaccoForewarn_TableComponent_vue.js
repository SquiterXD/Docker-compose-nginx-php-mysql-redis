(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_pd_OhhandTobaccoForewarn_TableComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pd/OhhandTobaccoForewarn/TableComponent.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pd/OhhandTobaccoForewarn/TableComponent.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var uuid_v1__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! uuid/v1 */ "./node_modules/uuid/v1.js");
/* harmony import */ var uuid_v1__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(uuid_v1__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-numeric */ "./node_modules/vue-numeric/dist/vue-numeric.min.js");
/* harmony import */ var vue_numeric__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vue_numeric__WEBPACK_IMPORTED_MODULE_1__);
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ['tobaccoForewarnList', 'itemNumbersUpdateList', 'itemNumberShowAllList'],
  data: function data() {
    return {
      lines: [],
      itemNumber: '',
      warningNum: '',
      checkText: true,
      loading: {
        page: false,
        itemNumberTable: false
      },
      itemNumbersSearchList: this.itemNumbersUpdateList
    };
  },
  components: {
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_1___default())
  },
  mounted: function mounted() {
    $('.table-data').dataTable({
      "searching": false,
      "bInfo": false
    });
  },
  methods: {
    addLine: function addLine() {
      this.isDisabledBtu = false;
      this.checkText = false;
      this.lines.push({
        id: uuid_v1__WEBPACK_IMPORTED_MODULE_0___default()(),
        itemNumber: '',
        warningNum: '',
        inventoryItemId: ''
      });
    },
    removeRow: function removeRow(index) {
      this.lines.splice(index, 1);

      if (this.lines.length == 0) {
        this.checkText = true;
      }
    },
    getValueDetails: function getValueDetails(value, line) {
      this.itemNumberShowAllList.forEach(function (element) {
        if (element.inventory_item_id == value) {
          line.itemNumber = element.item_number;
          line.inventoryItemId = element.inventory_item_id;
          line.itemDesc = element.item_desc;
        }
      });
    },
    save: function save() {
      var _this = this;

      var checkStatus = false;
      this.lines.forEach(function (element) {
        if (!element.itemNumber && !element.warningNum) {
          swal({
            title: "คำเตือน !",
            text: 'ไม่สามารถบันทึกได้ เนื่องจากกรอกข้อมูลไม่ครบถ้วน',
            type: "warning",
            showConfirmButton: true
          }); // element.validateRemark = true;

          return checkStatus = true;
        } else {// element.validateRemark = false;
        }
      });

      if (!checkStatus) {
        var params = _objectSpread({}, this.lines);

        var params1 = _objectSpread({}, this.tobaccoForewarnList);

        this.loading.page = true;
        return axios.post('/pd/ajax/ohhand-tobacco-forewarn/updateOrCreate', {
          params: params,
          params1: params1
        }).then(function (res) {
          if (res.data.data == "succeed") {
            swal({
              title: "Success !",
              text: "บันทึกสำเร็จ",
              type: "success",
              showConfirmButton: true
            });
          } else {
            swal({
              title: "Error !",
              text: "บันทึกไม่สำเร็จ",
              type: "error",
              showConfirmButton: true
            });
          }

          _this.loading.page = false;
          setTimeout(function () {
            window.location.reload(false);
          }, 3000);
        });
      }
    },
    remoteMethod: function remoteMethod(query) {
      var _this2 = this;

      if (query !== '') {
        var vm = this;
        this.loading.itemNumberTable = true;
        var params = {
          query: query,
          itemCatSeg1: vm.$parent.itemCatSeg1,
          itemCatSeg2: vm.$parent.itemCatSeg2,
          inventoryItemId: vm.$parent.itemNumber,
          UpdateList: 'UpdateList'
        };
        return axios.get('/pd/ajax/ohhand-tobacco-forewarn/get-search-item-number', {
          params: params
        }).then(function (res) {
          _this2.itemNumbersSearchList = res.data.itemNumberList;
          _this2.loading.itemNumberTable = false;
        });
      } else {
        this.itemNumbersSearchList = this.itemNumbersUpdateList;
      }
    }
  }
});

/***/ }),

/***/ "./resources/js/components/pd/OhhandTobaccoForewarn/TableComponent.vue":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/pd/OhhandTobaccoForewarn/TableComponent.vue ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _TableComponent_vue_vue_type_template_id_1edc378f___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TableComponent.vue?vue&type=template&id=1edc378f& */ "./resources/js/components/pd/OhhandTobaccoForewarn/TableComponent.vue?vue&type=template&id=1edc378f&");
/* harmony import */ var _TableComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TableComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/pd/OhhandTobaccoForewarn/TableComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TableComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TableComponent_vue_vue_type_template_id_1edc378f___WEBPACK_IMPORTED_MODULE_0__.render,
  _TableComponent_vue_vue_type_template_id_1edc378f___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/pd/OhhandTobaccoForewarn/TableComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/pd/OhhandTobaccoForewarn/TableComponent.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/components/pd/OhhandTobaccoForewarn/TableComponent.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pd/OhhandTobaccoForewarn/TableComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/pd/OhhandTobaccoForewarn/TableComponent.vue?vue&type=template&id=1edc378f&":
/*!************************************************************************************************************!*\
  !*** ./resources/js/components/pd/OhhandTobaccoForewarn/TableComponent.vue?vue&type=template&id=1edc378f& ***!
  \************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponent_vue_vue_type_template_id_1edc378f___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponent_vue_vue_type_template_id_1edc378f___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TableComponent_vue_vue_type_template_id_1edc378f___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TableComponent.vue?vue&type=template&id=1edc378f& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pd/OhhandTobaccoForewarn/TableComponent.vue?vue&type=template&id=1edc378f&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pd/OhhandTobaccoForewarn/TableComponent.vue?vue&type=template&id=1edc378f&":
/*!***************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/pd/OhhandTobaccoForewarn/TableComponent.vue?vue&type=template&id=1edc378f& ***!
  \***************************************************************************************************************************************************************************************************************************************************/
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
      {
        directives: [
          {
            name: "loading",
            rawName: "v-loading",
            value: _vm.loading.page,
            expression: "loading.page"
          }
        ],
        staticClass: "ibox",
        staticStyle: { "padding-top": "50px" }
      },
      [
        _vm._m(0),
        _vm._v(" "),
        _c("div", { staticClass: "ibox-content" }, [
          _c(
            "div",
            {
              staticClass: "text-right",
              staticStyle: { "padding-bottom": "15px" }
            },
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
                  _vm._v(" เพิ่มรายการ \n                    ")
                ]
              )
            ]
          ),
          _vm._v(" "),
          _c(
            "table",
            { staticClass: "table table table-bordered table-data" },
            [
              _vm._m(1),
              _vm._v(" "),
              this.tobaccoForewarnList.data.length != 0
                ? _c(
                    "tbody",
                    [
                      _vm._l(_vm.tobaccoForewarnList.data, function(
                        tobacco,
                        index
                      ) {
                        return _c(
                          "tr",
                          { key: "showData" + index, attrs: { row: index } },
                          [
                            _c(
                              "td",
                              {
                                staticClass: "text-center",
                                staticStyle: { "vertical-align": "middle" }
                              },
                              [
                                _vm._v(
                                  " \n                            " +
                                    _vm._s(tobacco.item_number) +
                                    "\n                        "
                                )
                              ]
                            ),
                            _vm._v(" "),
                            _c(
                              "td",
                              {
                                staticClass: "text-center",
                                staticStyle: { "vertical-align": "middle" }
                              },
                              [
                                _vm._v(
                                  "\n                            " +
                                    _vm._s(tobacco.item_desc) +
                                    "\n                        "
                                )
                              ]
                            ),
                            _vm._v(" "),
                            _c(
                              "td",
                              { staticStyle: { "vertical-align": "middle" } },
                              [
                                _c("vue-numeric", {
                                  staticClass: "form-control w-100 text-right",
                                  attrs: {
                                    placeholder: "ระบุจำนวนการแจ้งเตือน",
                                    separator: ",",
                                    precision: 0,
                                    minus: false
                                  },
                                  model: {
                                    value: tobacco.warning_num,
                                    callback: function($$v) {
                                      _vm.$set(tobacco, "warning_num", $$v)
                                    },
                                    expression: "tobacco.warning_num"
                                  }
                                })
                              ],
                              1
                            ),
                            _vm._v(" "),
                            _c("td", {
                              staticClass: "text-center",
                              staticStyle: { "vertical-align": "middle" }
                            })
                          ]
                        )
                      }),
                      _vm._v(" "),
                      _vm._l(_vm.lines, function(line, index) {
                        return _c("tr", { key: index, attrs: { row: index } }, [
                          _c(
                            "td",
                            {
                              staticClass: "text-center",
                              staticStyle: { "vertical-align": "middle" }
                            },
                            [
                              _c(
                                "el-select",
                                {
                                  staticClass: "w-100",
                                  attrs: {
                                    filterable: "",
                                    remote: "",
                                    "reserve-keyword": "",
                                    placeholder: "เลือก รหัสวัตถุดิบ",
                                    "remote-method": _vm.remoteMethod,
                                    loading: _vm.loading.itemNumberTable
                                  },
                                  on: {
                                    input: function($event) {
                                      return _vm.getValueDetails(
                                        line.itemNumber,
                                        line
                                      )
                                    }
                                  },
                                  model: {
                                    value: line.itemNumber,
                                    callback: function($$v) {
                                      _vm.$set(line, "itemNumber", $$v)
                                    },
                                    expression: "line.itemNumber"
                                  }
                                },
                                _vm._l(_vm.itemNumbersSearchList, function(
                                  itemNumber,
                                  index
                                ) {
                                  return _c("el-option", {
                                    key: index,
                                    attrs: {
                                      label:
                                        itemNumber.item_number +
                                        " : " +
                                        itemNumber.item_desc,
                                      value: itemNumber.inventory_item_id
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
                              _vm._v(
                                "\n                            " +
                                  _vm._s(line.itemDesc) +
                                  "\n                        "
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "td",
                            {
                              staticClass: "text-center",
                              staticStyle: { "vertical-align": "middle" }
                            },
                            [
                              _c("vue-numeric", {
                                staticClass: "form-control w-100 text-right",
                                attrs: {
                                  placeholder: "ระบุจำนวนการแจ้งเตือน",
                                  separator: ",",
                                  precision: 0,
                                  minus: false
                                },
                                model: {
                                  value: line.warningNum,
                                  callback: function($$v) {
                                    _vm.$set(line, "warningNum", $$v)
                                  },
                                  expression: "line.warningNum"
                                }
                              })
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
                            ]
                          )
                        ])
                      })
                    ],
                    2
                  )
                : _c(
                    "tbody",
                    [
                      this.checkText
                        ? _c("tr", [
                            _c(
                              "td",
                              {
                                staticClass: "text-center",
                                staticStyle: {
                                  "vertical-align": "middle",
                                  "font-size": "18px"
                                },
                                attrs: { colspan: "4" }
                              },
                              [
                                _vm._v(
                                  " \n                            " +
                                    _vm._s("ไม่มีข้อมูลในระบบ") +
                                    "\n                        "
                                )
                              ]
                            )
                          ])
                        : _vm._e(),
                      _vm._v(" "),
                      _vm._l(_vm.lines, function(line, index) {
                        return _c("tr", { key: index, attrs: { row: index } }, [
                          _c(
                            "td",
                            {
                              staticClass: "text-center",
                              staticStyle: { "vertical-align": "middle" }
                            },
                            [
                              _c(
                                "el-select",
                                {
                                  staticClass: "w-100",
                                  attrs: {
                                    filterable: "",
                                    remote: "",
                                    "reserve-keyword": "",
                                    placeholder: "เลือก รหัสวัตถุดิบ",
                                    "remote-method": _vm.remoteMethod,
                                    loading: _vm.loading.itemNumberTable
                                  },
                                  on: {
                                    input: function($event) {
                                      return _vm.getValueDetails(
                                        line.itemNumber,
                                        line
                                      )
                                    }
                                  },
                                  model: {
                                    value: line.itemNumber,
                                    callback: function($$v) {
                                      _vm.$set(line, "itemNumber", $$v)
                                    },
                                    expression: "line.itemNumber"
                                  }
                                },
                                _vm._l(_vm.itemNumbersSearchList, function(
                                  itemNumber,
                                  index
                                ) {
                                  return _c("el-option", {
                                    key: index,
                                    attrs: {
                                      label:
                                        itemNumber.item_number +
                                        " : " +
                                        itemNumber.item_desc,
                                      value: itemNumber.inventory_item_id
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
                              _vm._v(
                                "\n                            " +
                                  _vm._s(line.itemDesc) +
                                  "\n                        "
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "td",
                            {
                              staticClass: "text-center",
                              staticStyle: { "vertical-align": "middle" }
                            },
                            [
                              _c("vue-numeric", {
                                staticClass: "form-control w-100 text-right",
                                attrs: {
                                  placeholder: "ระบุจำนวนการแจ้งเตือน",
                                  separator: ",",
                                  precision: 0,
                                  minus: false
                                },
                                model: {
                                  value: line.warningNum,
                                  callback: function($$v) {
                                    _vm.$set(line, "warningNum", $$v)
                                  },
                                  expression: "line.warningNum"
                                }
                              })
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
                            ]
                          )
                        ])
                      })
                    ],
                    2
                  )
            ]
          ),
          _vm._v(" "),
          _c("div", { staticClass: "col-12 mt-3" }, [
            _c("div", { staticClass: "row clearfix text-right" }, [
              _c(
                "div",
                { staticClass: "col", staticStyle: { "margin-top": "15px" } },
                [
                  _c(
                    "button",
                    {
                      staticClass: "btn btn-success",
                      attrs: { type: "submit" },
                      on: {
                        click: function($event) {
                          $event.preventDefault()
                          return _vm.save()
                        }
                      }
                    },
                    [
                      _c("i", {
                        staticClass: "fa fa-floppy-o",
                        attrs: { "aria-hidden": "true" }
                      }),
                      _vm._v(" บันทึก \n                        ")
                    ]
                  )
                ]
              )
            ])
          ])
        ])
      ]
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "ibox-title" }, [
      _c("h5", [_vm._v(" กำหนดแจ้งเตือนปริมาณใบยา ")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", { staticClass: "text-center", attrs: { width: "30%" } }, [
          _c("div", [
            _vm._v("รหัสวัตถุดิบ"),
            _c("span", { staticClass: "text-danger" }, [_vm._v(" *")])
          ])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "30%" } }, [
          _c("div", [_vm._v("รายละเอียด")])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "30%" } }, [
          _c("div", [
            _vm._v("จำนวนเดือนที่แจ้งเตือน"),
            _c("span", { staticClass: "text-danger" }, [_vm._v(" *")])
          ])
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "10%" } })
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);