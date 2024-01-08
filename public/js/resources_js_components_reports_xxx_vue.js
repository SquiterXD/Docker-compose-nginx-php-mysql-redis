(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_reports_xxx_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/xxx.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/xxx.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_1__);


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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: [// 'url',
  'trans-date', // 'trans-btn',
  // 'module',
  // 'url-ger-param',
  'default-program-code' // 'info-attributes'
  ],
  data: function data() {
    return {
      options: [],
      value: this.defaultProgramCode ? this.defaultProgramCode : [],
      list: [],
      loading: false,
      states: [],
      infos: [],
      programs: [],
      infoAttributes: [],
      date: {},
      functionName: "",
      functionReport: "",
      reportType: 'pdf',
      errorLists: [],
      seq_1: true,
      seq_2: true,
      seq_3: true
    };
  },
  // mounted() {
  //     if(this.defaultProgramCode){
  //         this.getInfos();
  //     }
  //     // this.getData();
  //     // this.getInfos();
  // },
  methods: {
    // async remoteMethod(query) {
    //     var request = {
    //         params: {
    //             module: [this.module],
    //             uQuery: query
    //         }
    //     }
    //     axios.get(this.urlGerParam, request)
    //     .then((res) => {
    //         this.programs = res.data.programs;
    //         this.options = res.data.programs;
    //     })
    //     .catch((error) => {
    //     })
    // },
    // async remote(query){
    //     if (query !== "") {
    //         this.loading = true;
    //         setTimeout(() => {
    //             this.loading = false;
    //             this.options = this.programs.filter(item => {
    //                 if(item.program_code){
    //                     return (
    //                         item.program_code
    //                             .toLowerCase()
    //                             .indexOf(query.toLowerCase()) > -1
    //                     );
    //                 }
    //             });
    //         }, 200);
    //     } else {
    //         this.options = [];
    //     }
    // },
    getData: function getData(query) {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                axios.get(_this.url.getInfor).then(function (res) {
                  _this.programs = res.data.programs;
                }).then(function () {
                  _this.list = _this.infos.map(function (item) {
                    return {
                      value: "value:".concat(item.program_code),
                      label: "label:".concat(item.program_code)
                    };
                  });
                })["catch"](function (error) {});

              case 1:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getInfos: function getInfos() {
      var _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this2.infoAttributes = [];
                _this2.functionName = "";
                _this2.errorLists = []; // this.value = [];

                axios.get(_this2.url.getInfoAttribute + '?program_code=' + _this2.value // this.urlTest
                ).then(function (res) {
                  // console.log(res);
                  _this2.infoAttributes = res.data.reportInfor;
                  _this2.functionName = res.data.functionName;
                  _this2.functionReport = res.data.functionReport;
                  _this2.programs = res.data.programs;
                  _this2.options = res.data.programs;
                }).then(function () {// this.list = this.infos.map(item => {
                  //     return { value: `value:${item.program_code}`, label: `label:${item.program_code}` };
                  // });
                })["catch"](function (error) {// swal("Error", error, "error");
                });

              case 4:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    getYear: function getYear(value, infoAttribute) {
      if (infoAttribute.date_type == 'month') {
        infoAttribute.form_value = moment__WEBPACK_IMPORTED_MODULE_1___default()(value).add(-543, "years").format(this.transDate["js-datatime-format"]);
      }

      if (infoAttribute.date_type == 'year') {
        infoAttribute.form_value = moment__WEBPACK_IMPORTED_MODULE_1___default()(value).add(-543, "years").format(this.transDate['js-year-format']);
      }

      if (infoAttribute.date_type == 'date') {
        infoAttribute.form_value = moment__WEBPACK_IMPORTED_MODULE_1___default()(value).add(-543, "years").format(this.transDate['js-format']);
      }
    },
    exportReport: function exportReport() {},
    // checkForm: function (e) {
    //         this.errorLists = [];
    //         this.infoAttributes.forEach(info => {
    //             if(info.required ==1 & info.form_value == null){
    //                 let msg = 'โปรดระบุ. '+ ' '+ info.display_value;
    //                 this.errorLists.push(msg);
    //             }
    //         });
    //         if(this.errorLists.length == 0){
    //              return true;
    //         }
    //          e.preventDefault();
    // },
    // selectedList(selected){
    //     return selected.value;
    // },
    selectCheck: function selectCheck(depandent, infoAttribute) {
      if (depandent == null) {
        return;
      } // let parent =  this.infoAttributes.find(item => {
      //     return item.report_info_id  ==  depandent;
      // })
      // console.log(parent);
      // var request = {
      //     params: {
      //         id: depandent,
      //         value: parent.form_value
      //     }
      // }
      // axios.get('/ir/ajax/get-dependent', request)
      // .then((res) => {
      //     console.log(res);
      // }).catch((error) => {
      //     // swal("Error", error, "error");
      // })            

    }
  }
});

/***/ }),

/***/ "./resources/js/components/reports/xxx.vue":
/*!*************************************************!*\
  !*** ./resources/js/components/reports/xxx.vue ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _xxx_vue_vue_type_template_id_413ff82d___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./xxx.vue?vue&type=template&id=413ff82d& */ "./resources/js/components/reports/xxx.vue?vue&type=template&id=413ff82d&");
/* harmony import */ var _xxx_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./xxx.vue?vue&type=script&lang=js& */ "./resources/js/components/reports/xxx.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _xxx_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _xxx_vue_vue_type_template_id_413ff82d___WEBPACK_IMPORTED_MODULE_0__.render,
  _xxx_vue_vue_type_template_id_413ff82d___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/reports/xxx.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/reports/xxx.vue?vue&type=script&lang=js&":
/*!**************************************************************************!*\
  !*** ./resources/js/components/reports/xxx.vue?vue&type=script&lang=js& ***!
  \**************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_xxx_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./xxx.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/xxx.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_xxx_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/reports/xxx.vue?vue&type=template&id=413ff82d&":
/*!********************************************************************************!*\
  !*** ./resources/js/components/reports/xxx.vue?vue&type=template&id=413ff82d& ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_xxx_vue_vue_type_template_id_413ff82d___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_xxx_vue_vue_type_template_id_413ff82d___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_xxx_vue_vue_type_template_id_413ff82d___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./xxx.vue?vue&type=template&id=413ff82d& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/xxx.vue?vue&type=template&id=413ff82d&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/xxx.vue?vue&type=template&id=413ff82d&":
/*!***********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/reports/xxx.vue?vue&type=template&id=413ff82d& ***!
  \***********************************************************************************************************************************************************************************************************************/
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
  return _c("div")
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);