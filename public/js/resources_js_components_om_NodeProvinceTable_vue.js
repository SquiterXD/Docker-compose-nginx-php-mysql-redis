(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_om_NodeProvinceTable_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/NodeProvinceTable.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/NodeProvinceTable.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_0__);
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
//

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['user-profile', 'user-profile', 'trans-date', 'trans-btn', 'provinces', 'sys-date', 'p-node-headers'],
  data: function data() {
    return {
      nodeHeaders: this.pNodeHeaders ? this.pNodeHeaders : [],
      value1: [],
      nodeHeader: {},
      node: "",
      search: {
        node: "",
        province: ""
      } // can:{
      //     edit:false,
      // }

    };
  },
  mounted: function mounted() {},
  methods: {
    fromDateWasSelected: function fromDateWasSelected(date, index) {
      // change disabled_date_to of to_date = from_date
      this.disabledDateTo = moment__WEBPACK_IMPORTED_MODULE_0___default()(date).format("DD/MM/YYYY");
    },
    addRow: function addRow() {
      var total = this.nodeHeaders.length + 1;
      this.nodeHeader = {
        node_name: total,
        start_date: moment__WEBPACK_IMPORTED_MODULE_0___default()(this.sysDate).format("DD/MM/YYYY"),
        end_date: "",
        province_ids: [],
        node_header_id: null,
        can_edit: true,
        status: ""
      };
      this.nodeHeaders.push(this.nodeHeader);
    },
    saveData: function saveData(index) {
      var id = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
      console.log(index, id);

      if (id == null) {
        axios.post("/om/settings/node-province/store", _objectSpread({}, this.nodeHeaders[index])).then(function (res) {
          return swal({
            title: "Success !",
            text: "Success !",
            type: "success",
            showConfirmButton: true
          }); // alert('complete');
        })["catch"](function (error) {
          return swal({
            title: "Error !",
            text: "Error !",
            type: "error",
            showConfirmButton: true
          });
        });
      } else {
        this.update(index, id);
      }
    },
    update: function update(index, id) {
      axios.post('/om/settings/node-province/update/' + id, _objectSpread({}, this.nodeHeaders[index])).then(function (res) {
        console.log(res);
        return swal({
          title: "Success !",
          text: "Success !",
          type: "success",
          showConfirmButton: true
        });
      })["catch"](function (error) {
        alert(error);
      });
    },
    saveForm: function saveForm() {
      var _this = this;

      // this.nodeHeaders.
      var dataForm = this.nodeHeaders.map(function (item) {
        return {
          node_name: item.node_name,
          start_date: moment__WEBPACK_IMPORTED_MODULE_0___default()(item.start_date).format("YYYY-MM-DD"),
          end_date: item.end_date ? moment__WEBPACK_IMPORTED_MODULE_0___default()(item.start_date).format("YYYY-MM-DD") : "",
          province_ids: item.province_ids,
          node_header_id: item.node_header_id,
          status: item.status
        };
      });
      axios.post('/om/settings/node-province/update-form', {
        nodeHeaders: dataForm
      }).then(function (res) {
        _this.nodeHeaders = [];
        _this.nodeHeaders = res.data.ptomNodeHeaders; // this.nodeHeaders = res.date.ptomNodeHeaders;
        // console.log(res.data.ptomNodeHeaders);

        return swal({
          title: "Success !",
          text: "Success !",
          type: "success",
          showConfirmButton: true
        });
      })["catch"](function (error) {
        alert(error);
      });
    },
    delRaw: function delRaw(index, id) {
      console.log(index, id);

      if (id == null) {
        this.nodeHeaders.splice(this.nodeHeaders.indexOf(this.nodeHeaders[index]), 1);
      } else {
        this.deleteRaw(index, id);
      }
    },
    deleteRaw: function deleteRaw(index, id) {
      var _this2 = this;

      axios.post('/om/settings/node-province/delete/' + id, _objectSpread({}, this.nodeHeaders[index])).then(function (res) {
        _this2.nodeHeaders.splice(_this2.nodeHeaders.indexOf(_this2.nodeHeaders[index]), 1);

        return swal({
          title: "Success !",
          text: "Success !",
          type: "success",
          showConfirmButton: true
        });
      })["catch"](function (error) {
        return swal({
          title: "Error !",
          text: 'Error',
          type: "error",
          showConfirmButton: true
        });
      });
    },
    disabledOption: function disabledOption(nodeName, province) {
      var disabled = false;
      this.nodeHeaders.forEach(function (item) {// item.province_ids.forEach(province => {
        //     if(province == province & province){
        //     }
        // })
        // if(this.nodeHeaders.node_name == nodeName & line.raw_material_num != uItemCode){
        //     disabled  = true;
        // }
      });
      return disabled;
    },
    disableProvince: function disableProvince(value, provinceId) {
      var disable = false; // value.array.forEach(element => {

      this.nodeHeaders.forEach(function (item) {
        if (item.province_ids.includes(provinceId) & !value.province_ids.includes(provinceId)) {
          disable = true;
        }
      });
      return disable;
    },
    toggleEdit: function toggleEdit(index) {
      this.nodeHeaders[index].can_edit = !this.nodeHeaders[index].can_edit;
    },
    fitterNodes: function fitterNodes() {
      var _this3 = this;

      // let search = this.search;
      var request = {
        params: this.search
      }; // axios.get(this.urlGerParam, request)
      // .then((res) => {
      //     // this.infos = res.data.ptirReportInfos;
      //     this.programs = res.data.programs;
      //     this.options = res.data.programs;
      // })

      axios.get('/om/settings/node-province/search', request).then(function (res) {
        _this3.nodeHeaders = [];
        _this3.nodeHeaders = res.data.ptomNodeHeaders; // console.log(res.data.ptomNodeHeaders);
        // return swal({
        //     title: "Success !",
        //     text: "Success !",
        //     type: "success",
        //     showConfirmButton: true
        // });
      })["catch"](function (error) {
        alert(error);
      });
    }
  }
});

/***/ }),

/***/ "./resources/js/components/om/NodeProvinceTable.vue":
/*!**********************************************************!*\
  !*** ./resources/js/components/om/NodeProvinceTable.vue ***!
  \**********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _NodeProvinceTable_vue_vue_type_template_id_f82d4e54___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./NodeProvinceTable.vue?vue&type=template&id=f82d4e54& */ "./resources/js/components/om/NodeProvinceTable.vue?vue&type=template&id=f82d4e54&");
/* harmony import */ var _NodeProvinceTable_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./NodeProvinceTable.vue?vue&type=script&lang=js& */ "./resources/js/components/om/NodeProvinceTable.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _NodeProvinceTable_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _NodeProvinceTable_vue_vue_type_template_id_f82d4e54___WEBPACK_IMPORTED_MODULE_0__.render,
  _NodeProvinceTable_vue_vue_type_template_id_f82d4e54___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/om/NodeProvinceTable.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/om/NodeProvinceTable.vue?vue&type=script&lang=js&":
/*!***********************************************************************************!*\
  !*** ./resources/js/components/om/NodeProvinceTable.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_NodeProvinceTable_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./NodeProvinceTable.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/NodeProvinceTable.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_NodeProvinceTable_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/om/NodeProvinceTable.vue?vue&type=template&id=f82d4e54&":
/*!*****************************************************************************************!*\
  !*** ./resources/js/components/om/NodeProvinceTable.vue?vue&type=template&id=f82d4e54& ***!
  \*****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_NodeProvinceTable_vue_vue_type_template_id_f82d4e54___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_NodeProvinceTable_vue_vue_type_template_id_f82d4e54___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_NodeProvinceTable_vue_vue_type_template_id_f82d4e54___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./NodeProvinceTable.vue?vue&type=template&id=f82d4e54& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/NodeProvinceTable.vue?vue&type=template&id=f82d4e54&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/NodeProvinceTable.vue?vue&type=template&id=f82d4e54&":
/*!********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/NodeProvinceTable.vue?vue&type=template&id=f82d4e54& ***!
  \********************************************************************************************************************************************************************************************************************************/
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
    _c("div", { staticClass: "text-right mb-2" }, [
      _c(
        "button",
        {
          class: _vm.transBtn.add.class + " btn-lg  btn-sm",
          on: {
            click: function($event) {
              $event.preventDefault()
              return _vm.addRow()
            }
          }
        },
        [
          _c("i", { class: _vm.transBtn.add.icon }),
          _vm._v(
            "\n            " + _vm._s(_vm.transBtn.add.text) + "\n        "
          )
        ]
      ),
      _vm._v(" "),
      _c(
        "button",
        {
          class: _vm.transBtn.save.class + " btn-lg  btn-sm",
          on: {
            click: function($event) {
              $event.preventDefault()
              return _vm.saveForm()
            }
          }
        },
        [
          _c("i", { class: _vm.transBtn.save.icon }),
          _vm._v(
            "\n            " + _vm._s(_vm.transBtn.save.text) + "\n        "
          )
        ]
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "ibox" }, [
      _vm._m(0),
      _vm._v(" "),
      _c("div", { staticClass: "ibox-content" }, [
        _c(
          "div",
          { staticClass: "text-right" },
          [
            _c("span", [_vm._v(" Node : ")]),
            _vm._v(" "),
            _c(
              "el-select",
              {
                attrs: { filterable: "", placeholder: "Select", clearable: "" },
                model: {
                  value: _vm.search.node,
                  callback: function($$v) {
                    _vm.$set(_vm.search, "node", $$v)
                  },
                  expression: "search.node"
                }
              },
              _vm._l(_vm.nodeHeaders, function(node) {
                return _c("el-option", {
                  key: node.node_name,
                  attrs: { label: node.node_name, value: node.node_name }
                })
              }),
              1
            ),
            _vm._v(" "),
            _c("span", [_vm._v(" จังหวัด : ")]),
            _vm._v(" "),
            _c(
              "el-select",
              {
                attrs: { filterable: "", placeholder: "Select", clearable: "" },
                model: {
                  value: _vm.search.province,
                  callback: function($$v) {
                    _vm.$set(_vm.search, "province", $$v)
                  },
                  expression: "search.province"
                }
              },
              _vm._l(_vm.provinces, function(province) {
                return _c("el-option", {
                  key: province.province_id,
                  attrs: {
                    label: province.province_thai,
                    value: province.province_id
                  }
                })
              }),
              1
            ),
            _vm._v(" "),
            _c(
              "button",
              {
                class: _vm.transBtn.search.class + " btn-sm mb-1",
                on: { click: _vm.fitterNodes }
              },
              [
                _c("i", {
                  class: _vm.transBtn.search.icon + " btn-lg tw-w-25 "
                }),
                _vm._v(
                  "\n                        " +
                    _vm._s(_vm.transBtn.search.text) +
                    "\n                "
                )
              ]
            )
          ],
          1
        ),
        _vm._v(" "),
        _c("div", { staticClass: "table-responsive mt-2" }, [
          _c(
            "table",
            { staticClass: "table table-bordered" },
            [
              _vm._m(1),
              _vm._v(" "),
              _vm._l(_vm.nodeHeaders, function(header, index) {
                return _c("tbody", { key: index }, [
                  _c("tr", [
                    _c(
                      "td",
                      { staticClass: "text-right" },
                      [
                        _c("el-input", {
                          staticClass: "text-right",
                          attrs: { disabled: !header.can_edit },
                          model: {
                            value: _vm.nodeHeaders[index].node_name,
                            callback: function($$v) {
                              _vm.$set(_vm.nodeHeaders[index], "node_name", $$v)
                            },
                            expression: "nodeHeaders[index].node_name"
                          }
                        })
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "td",
                      [
                        _c(
                          "el-select",
                          {
                            staticClass: "form-control-file",
                            attrs: {
                              multiple: "",
                              placeholder: "Select",
                              filterable: "",
                              disabled: !header.can_edit
                            },
                            model: {
                              value: _vm.nodeHeaders[index].province_ids,
                              callback: function($$v) {
                                _vm.$set(
                                  _vm.nodeHeaders[index],
                                  "province_ids",
                                  $$v
                                )
                              },
                              expression: "nodeHeaders[index].province_ids"
                            }
                          },
                          _vm._l(_vm.provinces, function(province) {
                            return _c("el-option", {
                              key: province.province_id,
                              attrs: {
                                label: province.province_thai,
                                value: province.province_id,
                                disabled: _vm.disableProvince(
                                  header,
                                  province.province_id
                                )
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
                        _c("el-date-picker", {
                          attrs: { type: "date", disabled: !header.can_edit },
                          model: {
                            value: _vm.nodeHeaders[index].start_date,
                            callback: function($$v) {
                              _vm.$set(
                                _vm.nodeHeaders[index],
                                "start_date",
                                $$v
                              )
                            },
                            expression: "nodeHeaders[index].start_date"
                          }
                        })
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "td",
                      [
                        _c("el-date-picker", {
                          attrs: { type: "date", disabled: !header.can_edit },
                          model: {
                            value: _vm.nodeHeaders[index].end_date,
                            callback: function($$v) {
                              _vm.$set(_vm.nodeHeaders[index], "end_date", $$v)
                            },
                            expression: "nodeHeaders[index].end_date"
                          }
                        })
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c("td", [
                      _c(
                        "select",
                        {
                          staticClass: "form-control",
                          attrs: {
                            name: "",
                            id: "",
                            disabled: !header.can_edit
                          }
                        },
                        [
                          _c("option", { attrs: { value: "active" } }, [
                            _vm._v("Active")
                          ]),
                          _vm._v(" "),
                          _c("option", { attrs: { value: "inactive" } }, [
                            _vm._v("Inactive")
                          ])
                        ]
                      )
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "text-center" }, [
                      _c(
                        "button",
                        {
                          class: _vm.transBtn.edit.class + " btn-lg  btn-sm",
                          on: {
                            click: function($event) {
                              $event.preventDefault()
                              return _vm.toggleEdit(index)
                            }
                          }
                        },
                        [
                          _c("i", { class: _vm.transBtn.save.icon }),
                          _vm._v(
                            "\n                                    " +
                              _vm._s(_vm.transBtn.edit.text) +
                              "\n                                "
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "button",
                        {
                          class: _vm.transBtn.delete.class + " btn-lg  btn-sm",
                          on: {
                            click: function($event) {
                              $event.preventDefault()
                              return _vm.delRaw(index, header.node_header_id)
                            }
                          }
                        },
                        [
                          _c("i", { class: _vm.transBtn.delete.icon }),
                          _vm._v(
                            "\n                                    " +
                              _vm._s(_vm.transBtn.delete.text) +
                              "\n                                "
                          )
                        ]
                      )
                    ])
                  ])
                ])
              })
            ],
            2
          )
        ])
      ])
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "ibox-title" }, [
      _c("div", { staticClass: "ibox-tools" }),
      _vm._v(" "),
      _c("h5", [_vm._v("กำหนด Node")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", { staticClass: "text-center", attrs: { width: "6%" } }, [
          _vm._v("Node")
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "45%" } }, [
          _vm._v("จังหวัด")
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "10%" } }, [
          _vm._v("วันที่เริ่มต้น")
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "10%" } }, [
          _vm._v("วันที่สิ้นสุด")
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "10%" } }, [
          _vm._v("สถานะ")
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "text-center", attrs: { width: "15%" } })
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);