(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_pm_pages_MockLookUpExample_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/MockLookUpExample.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/MockLookUpExample.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _helpers__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../helpers */ "./resources/js/pm/helpers.js");
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! lodash/get */ "./node_modules/lodash/get.js");
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(lodash_get__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var lodash_isEqual__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! lodash/isEqual */ "./node_modules/lodash/isEqual.js");
/* harmony import */ var lodash_isEqual__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(lodash_isEqual__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var lodash_cloneDeep__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! lodash/cloneDeep */ "./node_modules/lodash/cloneDeep.js");
/* harmony import */ var lodash_cloneDeep__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(lodash_cloneDeep__WEBPACK_IMPORTED_MODULE_3__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  created: function created() {},
  mounted: function mounted() {},
  data: function data() {
    return {
      lodash: {
        get: (lodash_get__WEBPACK_IMPORTED_MODULE_1___default()),
        isEqual: (lodash_isEqual__WEBPACK_IMPORTED_MODULE_2___default()),
        cloneDeep: (lodash_cloneDeep__WEBPACK_IMPORTED_MODULE_3___default())
      },
      dataModel: null,
      inputModel: null
    };
  },
  props: {},
  methods: {
    mockLookup: function mockLookup() {
      var data = [{
        id: '1',
        name: 'TestName1',
        attr2: "attr1"
      }, {
        id: '2',
        name: 'TestName2',
        attr2: "attr2"
      }, {
        id: '3',
        name: 'TestName3',
        attr2: "attr3"
      }, {
        id: '4',
        name: 'TestName4',
        attr2: "attr4"
      }, {
        id: '5',
        name: 'TestName5',
        attr2: "attr5"
      }, {
        id: '6',
        name: 'TestName6',
        attr2: "attr6"
      }, {
        id: '7',
        name: 'TestName7',
        attr2: "attr7"
      }, {
        id: '8',
        name: 'TestName8',
        attr2: "attr8"
      }, {
        id: '9',
        name: 'TestName9',
        attr2: "attr9"
      }, {
        id: '10',
        name: 'TestName10',
        attr2: "attr10"
      }];
      return data;
    }
  }
});

/***/ }),

/***/ "./resources/js/pm/helpers.js":
/*!************************************!*\
  !*** ./resources/js/pm/helpers.js ***!
  \************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "extractDataFormEvent": () => /* binding */ extractDataFormEvent,
/* harmony export */   "setAllObjectKeys": () => /* binding */ setAllObjectKeys,
/* harmony export */   "copyObject": () => /* binding */ copyObject,
/* harmony export */   "warningBeforeUnload": () => /* binding */ warningBeforeUnload,
/* harmony export */   "DefaultDBRecord": () => /* binding */ DefaultDBRecord
/* harmony export */ });
function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _iterableToArrayLimit(arr, i) { if (typeof Symbol === "undefined" || !(Symbol.iterator in Object(arr))) return; var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

function _createForOfIteratorHelper(o, allowArrayLike) { var it; if (typeof Symbol === "undefined" || o[Symbol.iterator] == null) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e2) { throw _e2; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = o[Symbol.iterator](); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e3) { didErr = true; err = _e3; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && Symbol.iterator in Object(iter)) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function extractDataFormEvent(event) {
  var vv = _toConsumableArray(event.target.elements).filter(function (ele) {
    return typeof ele['name'] !== 'undefined' && ele.name;
  }).map(function (ele) {
    return [ele, ele.value, ele.name];
  });

  var form = {};

  var _iterator = _createForOfIteratorHelper(vv),
      _step;

  try {
    for (_iterator.s(); !(_step = _iterator.n()).done;) {
      var _step$value = _slicedToArray(_step.value, 2),
          ele = _step$value[0],
          value = _step$value[1];

      form[ele.name] = value;
    }
  } catch (err) {
    _iterator.e(err);
  } finally {
    _iterator.f();
  }

  return form;
}
function setAllObjectKeys(obj, val) {
  Object.keys(obj).forEach(function (index) {
    obj[index] = val;
  });
}
function copyObject(object) {
  console.log(object);
  return JSON.parse(JSON.stringify(object));
}
function warningBeforeUnload(_callback) {
  if (typeof _callback !== 'function') {
    _callback = function callback() {
      return _callback ? _callback : null;
    };
  }

  window.onbeforeunload = function () {
    var res = _callback();

    if (!res) return null;
    if (typeof res === 'string') return res;
    return 'มีการเปลี่ยนแปลงข้อมูลโดยที่ยังไม่ได้บันทึก ต้องการออกจากหน้านี้?';
  };
}
var DefaultDBRecord = {
  attribute1: null,
  attribute2: null,
  attribute3: null,
  attribute4: null,
  attribute5: null,
  attribute6: null,
  attribute7: null,
  attribute8: null,
  attribute9: null,
  attribute10: null,
  attribute11: null,
  attribute12: null,
  attribute13: null,
  attribute14: null,
  attribute15: null
};

/***/ }),

/***/ "./resources/js/pm/pages/MockLookUpExample.vue":
/*!*****************************************************!*\
  !*** ./resources/js/pm/pages/MockLookUpExample.vue ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _MockLookUpExample_vue_vue_type_template_id_ca165472_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./MockLookUpExample.vue?vue&type=template&id=ca165472&scoped=true& */ "./resources/js/pm/pages/MockLookUpExample.vue?vue&type=template&id=ca165472&scoped=true&");
/* harmony import */ var _MockLookUpExample_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./MockLookUpExample.vue?vue&type=script&lang=js& */ "./resources/js/pm/pages/MockLookUpExample.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _MockLookUpExample_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _MockLookUpExample_vue_vue_type_template_id_ca165472_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _MockLookUpExample_vue_vue_type_template_id_ca165472_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "ca165472",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pm/pages/MockLookUpExample.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pm/pages/MockLookUpExample.vue?vue&type=script&lang=js&":
/*!******************************************************************************!*\
  !*** ./resources/js/pm/pages/MockLookUpExample.vue?vue&type=script&lang=js& ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MockLookUpExample_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./MockLookUpExample.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/MockLookUpExample.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MockLookUpExample_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/pm/pages/MockLookUpExample.vue?vue&type=template&id=ca165472&scoped=true&":
/*!************************************************************************************************!*\
  !*** ./resources/js/pm/pages/MockLookUpExample.vue?vue&type=template&id=ca165472&scoped=true& ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MockLookUpExample_vue_vue_type_template_id_ca165472_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MockLookUpExample_vue_vue_type_template_id_ca165472_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MockLookUpExample_vue_vue_type_template_id_ca165472_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./MockLookUpExample.vue?vue&type=template&id=ca165472&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/MockLookUpExample.vue?vue&type=template&id=ca165472&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/MockLookUpExample.vue?vue&type=template&id=ca165472&scoped=true&":
/*!***************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/pages/MockLookUpExample.vue?vue&type=template&id=ca165472&scoped=true& ***!
  \***************************************************************************************************************************************************************************************************************************************/
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
    "form",
    {
      ref: "mainForm",
      on: {
        submit: function($event) {
          $event.preventDefault()
        }
      }
    },
    [
      _c("div", [
        _c("div", { staticClass: "form-group row" }, [
          _c(
            "pre",
            { staticClass: "col-lg-6", staticStyle: { display: "block" } },
            [
              _vm._v(
                _vm._s(
                  JSON.stringify(
                    {
                      dataModel: _vm.dataModel
                    },
                    null,
                    2
                  )
                )
              )
            ]
          ),
          _vm._v(" "),
          _c(
            "pre",
            { staticClass: "col-lg-6", staticStyle: { display: "block" } },
            [
              _vm._v(
                _vm._s(
                  JSON.stringify(
                    {
                      inputModel: _vm.inputModel
                    },
                    null,
                    2
                  )
                )
              )
            ]
          )
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "ibox " },
          [
            _c("db-lookup", {
              attrs: {
                "remote-data-source": _vm.mockLookup,
                "key-field": "id",
                "label-pattern": "id: {$}, name: {$}",
                "label-fields": ["id", "name"],
                "search-keys": ["id", "name"],
                "max-results": 20
              },
              on: {
                change: function(item) {
                  _vm.inputModel = item.attr2
                }
              },
              model: {
                value: _vm.dataModel,
                callback: function($$v) {
                  _vm.dataModel = $$v
                },
                expression: "dataModel"
              }
            }),
            _vm._v(" "),
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.inputModel,
                  expression: "inputModel"
                }
              ],
              attrs: { type: "text" },
              domProps: { value: _vm.inputModel },
              on: {
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.inputModel = $event.target.value
                }
              }
            })
          ],
          1
        )
      ])
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);