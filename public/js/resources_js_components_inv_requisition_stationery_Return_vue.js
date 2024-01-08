(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_inv_requisition_stationery_Return_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/Return.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/Return.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  props: ["defaultIssueHeader", "lookupValues", "user"],
  data: function data() {
    var _this$user, _this$defaultIssueHea;

    return {
      reason: "",
      allowed_status: 'N',
      username: ((_this$user = this.user) === null || _this$user === void 0 ? void 0 : _this$user.username) || "",
      return_date: ((_this$defaultIssueHea = this.defaultIssueHeader) === null || _this$defaultIssueHea === void 0 ? void 0 : _this$defaultIssueHea.gl_date) || "",
      loading: false
    };
  },
  created: function created() {},
  mounted: function mounted() {
    var _this = this;

    var allowedUser = this.lookupValues.find(function (user) {
      return user.meaning == _this.username;
    });

    if (allowedUser) {
      this.allowed_status = 'Y';
    }
  },
  methods: {
    returnIssue: function returnIssue() {
      var _this2 = this;

      this.loading = true;
      axios.post("/inv/issue_return", {
        reason: this.reason,
        issue_header_id: this.defaultIssueHeader.issue_header_id,
        gl_date: this.return_date
      }).then(function (res) {
        _this2.loading = false;

        _this2.$notify({
          title: 'Success',
          message: 'Return Successfully',
          type: 'success'
        });

        window.location.replace("/inv/requisition_stationery/");
      })["catch"](function (err) {
        _this2.loading = false;

        if (err.response.status == 403) {
          _this2.$notify.error({
            title: 'Error',
            message: err.response.data.msg,
            duration: 4500
          });
        }

        var errorMessage = _this2.$formatErrorMessage(err);

        var items = errorMessage.getElementsByTagName("li");

        for (var i = 0, size = items.length; i < size; i++) {
          _this2.$notify.error({
            title: 'Error',
            message: items[i].innerHTML,
            duration: 4500
          });
        }
      });
    }
  }
});

/***/ }),

/***/ "./resources/js/components/inv/requisition_stationery/Return.vue":
/*!***********************************************************************!*\
  !*** ./resources/js/components/inv/requisition_stationery/Return.vue ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _Return_vue_vue_type_template_id_01abcd6a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Return.vue?vue&type=template&id=01abcd6a& */ "./resources/js/components/inv/requisition_stationery/Return.vue?vue&type=template&id=01abcd6a&");
/* harmony import */ var _Return_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Return.vue?vue&type=script&lang=js& */ "./resources/js/components/inv/requisition_stationery/Return.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _Return_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _Return_vue_vue_type_template_id_01abcd6a___WEBPACK_IMPORTED_MODULE_0__.render,
  _Return_vue_vue_type_template_id_01abcd6a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/inv/requisition_stationery/Return.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/inv/requisition_stationery/Return.vue?vue&type=script&lang=js&":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/inv/requisition_stationery/Return.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Return_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Return.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/Return.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Return_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/inv/requisition_stationery/Return.vue?vue&type=template&id=01abcd6a&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/components/inv/requisition_stationery/Return.vue?vue&type=template&id=01abcd6a& ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Return_vue_vue_type_template_id_01abcd6a___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Return_vue_vue_type_template_id_01abcd6a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Return_vue_vue_type_template_id_01abcd6a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Return.vue?vue&type=template&id=01abcd6a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/Return.vue?vue&type=template&id=01abcd6a&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/Return.vue?vue&type=template&id=01abcd6a&":
/*!*********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/inv/requisition_stationery/Return.vue?vue&type=template&id=01abcd6a& ***!
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
  return _vm.defaultIssueHeader.issue_status == "APPROVED" &&
    _vm.allowed_status == "Y"
    ? _c("div", [
        _c(
          "div",
          {
            directives: [
              {
                name: "loading",
                rawName: "v-loading",
                value: _vm.loading,
                expression: "loading"
              }
            ],
            staticClass: "col-md-12 text-right mt-2 p-0"
          },
          [
            _c(
              "button",
              {
                staticClass: "btn btn-danger",
                attrs: {
                  "data-toggle": "modal",
                  "data-target": "#returnRequest"
                }
              },
              [_vm._v("\n            Return\n        ")]
            )
          ]
        ),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass: "modal fade",
            attrs: {
              id: "returnRequest",
              tabindex: "-1",
              role: "dialog",
              "aria-labelledby": "returnRequestLabel",
              "aria-hidden": "true"
            }
          },
          [
            _c(
              "div",
              { staticClass: "modal-dialog", attrs: { role: "document" } },
              [
                _c("div", { staticClass: "modal-content" }, [
                  _vm._m(0),
                  _vm._v(" "),
                  _c("div", { staticClass: "modal-body text-left" }, [
                    _c("form", [
                      _c("div", { staticClass: "form-group row" }, [
                        _c(
                          "label",
                          { staticClass: "col-md-3 col-form-label required" },
                          [_vm._v("วันที่ยกเลิก")]
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          { staticClass: "col-md-4" },
                          [
                            _c("el-date-picker", {
                              attrs: {
                                type: "date",
                                format: "dd/MM/yyyy",
                                size: "small",
                                placeholder: "Pick a day"
                              },
                              model: {
                                value: _vm.return_date,
                                callback: function($$v) {
                                  _vm.return_date = $$v
                                },
                                expression: "return_date"
                              }
                            })
                          ],
                          1
                        )
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "form-group mb-0" }, [
                        _c("h4", [
                          _vm._v(
                            "กรุณาระบุสาเหตุการยกเลิกรายการเบิกจ่ายเครื่องเขียน"
                          )
                        ]),
                        _vm._v(" "),
                        _c("div", { staticClass: "form-group row mt-3 mb-0" }, [
                          _c(
                            "label",
                            {
                              staticClass:
                                "col-md-4 col-form-label tw-text-xs required"
                            },
                            [_vm._v("รายละเอียดการยกเลิก")]
                          ),
                          _vm._v(" "),
                          _c(
                            "div",
                            { staticClass: "col-md-8" },
                            [
                              _c("el-input", {
                                attrs: {
                                  autosize: { minRows: 3, maxRows: 3 },
                                  type: "textarea"
                                },
                                model: {
                                  value: _vm.reason,
                                  callback: function($$v) {
                                    _vm.reason = $$v
                                  },
                                  expression: "reason"
                                }
                              })
                            ],
                            1
                          )
                        ])
                      ])
                    ])
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "modal-footer" }, [
                    _c(
                      "button",
                      {
                        staticClass: "btn btn-secondary",
                        attrs: { type: "button", "data-dismiss": "modal" }
                      },
                      [_vm._v("ยกเลิก")]
                    ),
                    _vm._v(" "),
                    _c(
                      "button",
                      {
                        staticClass: "btn btn-primary",
                        attrs: { type: "button", "data-dismiss": "modal" },
                        on: {
                          click: function($event) {
                            return _vm.returnIssue()
                          }
                        }
                      },
                      [_vm._v("ตกลง")]
                    )
                  ])
                ])
              ]
            )
          ]
        )
      ])
    : _vm._e()
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "modal-header" }, [
      _c(
        "div",
        { staticClass: "modal-title", attrs: { id: "returnRequestLabel" } },
        [_c("h3", [_vm._v("Return Request")])]
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
  }
]
render._withStripped = true



/***/ })

}]);