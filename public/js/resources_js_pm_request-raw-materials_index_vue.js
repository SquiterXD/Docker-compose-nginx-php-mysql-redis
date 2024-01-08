(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_pm_request-raw-materials_index_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/request-raw-materials/index.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/request-raw-materials/index.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _commonDialogs__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../commonDialogs */ "./resources/js/commonDialogs.js");


function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && Symbol.iterator in Object(iter)) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

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



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['lookups', 'items', 'dep_code', 'orgname', 'oprn_rows', 'orgfullname', 'req_by', 'title', 'transdate', 'transbtn', 'def_period_year', 'profile'],
  components: {
    VueNumeric: (vue_numeric__WEBPACK_IMPORTED_MODULE_1___default())
  },
  mounted: function mounted() {
    var _this = this;

    return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              try {
                _this.thai_month = _this.months[new Date().getMonth()];
              } catch (err) {} // To do


            case 1:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }))();
  },
  data: function data() {
    return {
      months: ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"],
      current_date: this.getCurrentDate(),
      header_id: '',
      oprnValue: 'all',
      thai_year: this.def_period_year,
      thai_month: "",
      biweekly: '',
      biweekly_id: '',
      req_date: this.getCurrentDate(),
      item_code: '',
      start_date: '',
      end_date: '',
      min_date: '',
      max_date: '',
      send_date: this.getCurrentDate(),
      lines: [],
      listUom2: [],
      isCheckedAll: false,
      checked: [],
      // listUom2: [],
      valueUom2: ''
    };
  },
  computed: {
    maxSelectedDate: function maxSelectedDate() {
      var today = new Date();
      var max = new Date();
      max.setDate(today.getDate() + 365);
      var thaiYear = max.getFullYear() + 543;
      var month = max.getMonth() + 1;
      var day = max.getDate();
      return thaiYear + '-' + month + '-' + day;
    },
    checkDisableBtn: function checkDisableBtn() {
      if (this.dep_code != "M02" && this.dep_code != "M03") {
        return !(this.thai_year && this.thai_month && this.biweekly);
      } else {
        return !(this.thai_year && this.thai_month && this.biweekly && this.item_code);
      }
    },
    yearLists: function yearLists() {
      return _toConsumableArray(new Set(Array.from(this.lookups, function (lookup) {
        return lookup.thai_year;
      })));
    },
    monthLists: function monthLists() {
      var _this2 = this;

      var lookups = this.lookups.filter(function (lookup) {
        return lookup.thai_year == _this2.thai_year;
      });

      var result = _toConsumableArray(new Set(Array.from(lookups, function (lookup) {
        return lookup.thai_month;
      })));

      return result;
    },
    biweeklyLists: function biweeklyLists() {
      var _this3 = this;

      var lookups = this.lookups.filter(function (lookup) {
        return lookup.thai_year == _this3.thai_year && lookup.thai_month == _this3.thai_month;
      });
      return _toConsumableArray(new Set(Array.from(lookups, function (lookup) {
        return lookup.biweekly;
      })));
    }
  },
  methods: {
    setdate: function setdate(date) {
      var _arguments = arguments,
          _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
        var input, vm, data;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                input = _arguments.length > 1 && _arguments[1] !== undefined ? _arguments[1] : '';
                vm = _this4;

                if (!(input == '')) {
                  _context2.next = 5;
                  break;
                }

                _context2.next = 10;
                break;

              case 5:
                _context2.next = 7;
                return moment__WEBPACK_IMPORTED_MODULE_2___default()(date).format(vm.transdate['js-format']);

              case 7:
                data = _context2.sent;

                if (data == 'Invalid date') {
                  data = '';
                }

                vm[input] = data;

              case 10:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    // getListItemUomv(params){
    //     return axios.post('/pm/ajax/get-list-item-conv-uomv', params).then(response => {
    //         if (response.status == 200) {
    //             return response.data
    //         }else{
    //             return []
    //         }
    //     }).catch(error => {
    //         console.log(error)
    //         return []
    //     })
    // },
    // popupUom2(selectData){
    //     return new Promise((resolve, reject) => {
    //         Vue.swal({
    //             title: 'เลือกหน่วยเบิก (2)',
    //             input: 'select',
    //             inputOptions: selectData,
    //             inputPlaceholder: 'Select',
    //             showCancelButton: true,
    //             inputValidator: (value) => {
    //                 console.log(value)
    //                 Vue.swal.close();
    //                 resolve(value)
    //             }
    //         });
    //     })
    // },
    // async chooseRequestUom2(row, index){
    //     const params = {
    //         "inventory_item_id" : row.inventory_item_id,
    //         "organization_id" : row.organization_id,
    //         "to_uom_code" : row.uom2
    //     }
    //     const res = await this.getListItemUomv(params);
    //     if(res){
    //         const uom2 = res.listUom2
    //         let i = 0;
    //         const selectData = uom2.reduce((a, c) => {
    //             a[i] = c.from_unit_of_measure
    //             i++
    //             return a
    //         }, {})
    //         const valueSelected = await this.popupUom2(selectData)
    //         console.log("valueSelected", valueSelected)
    //         const item = uom2[valueSelected];
    //         console.log("item", item)
    //         this.$set(this.lines, index, { 
    //             ...this.lines[index], 
    //             'qty' : parseFloat((this.lines[index].request_qty ? this.lines[index].request_qty : 0)) * parseFloat((item.conversion_rate ? item.conversion_rate : 1)),
    //             'request_uom' : item.from_unit_of_measure,
    //             'conversion_rate' : item.conversion_rate
    //         })
    //     }
    // },
    isNumber: function isNumber(evt) {
      evt = evt ? evt : window.event;
      var charCode = evt.which ? evt.which : evt.keyCode;
      console.log("charCode", charCode);

      if (charCode == 190 || charCode == 46) {
        //dot
        evt.preventDefault();
        return false;
      }

      if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 9) {
        evt.preventDefault();
        return false;
      } else {
        return true;
      }
    },
    onChangeRequestQty2: function onChangeRequestQty2(index, row) {
      console.log('1111-------------------------->', this.checked, row, row.request_qty);

      if (row.request_qty == '' || row.request_qty == 0) {
        row.request_qty = '';
        row.qty = ''; // let lineIdIdx = this.checked.findIndex(item => item == row.bi_request_line_id);
        // this.$delete(this.checked, lineIdIdx);
        // Vue.delete( this.checked, lineIdIdx )

        Vue.set(this.checked, index, '');
      } else {
        row.qty = parseFloat(row.request_qty ? row.request_qty : 0) * parseFloat(row.conversion_rate ? row.conversion_rate : 1);
        Vue.set(this.checked, index, row.bi_request_line_id);
      }

      console.log('2222-------------------------->', this.checked, row, row.request_qty);
    },
    onClickCreate: function onClickCreate() {
      // To do
      this.thai_year = this.def_period_year, this.thai_month = '';
      this.biweekly = '';
      this.biweekly_id = '';
      this.req_date = this.getCurrentDate();
      this.item_code = '';
      this.start_date = '';
      this.end_date = '';
      this.send_date = this.getCurrentDate(), this.lines = '';
    },
    onClickSave: function onClickSave() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee3() {
        var oprnClassDesc, params;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                oprnClassDesc = _this5.oprnValue;

                if (_this5.oprnValue == 'all') {
                  oprnClassDesc = _this5.oprn_rows.map(function (item) {
                    return item.oprn_class_desc;
                  }).join('-');
                }

                params = {
                  biweekly_id: _this5.biweekly_id,
                  department_code: _this5.dep_code,
                  request_date: _this5.convertFormatDate(_this5.req_date),
                  tobacco_group: _this5.item_code,
                  product_date_from: _this5.convertFormatDate(_this5.start_date),
                  product_date_to: _this5.convertFormatDate(_this5.end_date),
                  request_by: _this5.req_by,
                  send_date: _this5.convertFormatDate(_this5.send_date),
                  wip: oprnClassDesc
                };
                (0,_commonDialogs__WEBPACK_IMPORTED_MODULE_3__.showLoadingDialog)();
                _context3.next = 6;
                return axios.post('/pm/ajax/request-raw-materials', params).then(function (response) {
                  if (response.status == 200) {
                    console.log(response);
                    (0,_commonDialogs__WEBPACK_IMPORTED_MODULE_3__.showSaveSuccessDialog)();
                    _this5.lines = response.data.lines;
                    _this5.header_id = response.data.header.bi_request_header_id;
                    _this5.listUom2 = _toConsumableArray(new Set(Array.from(response.data.listUom2)));

                    if (_this5.profile.organization_code != 'M02') {
                      _this5.lines.forEach(function (row, idx) {
                        if (parseFloat(row.request_qty) > 0) {
                          Vue.set(_this5.checked, idx, row.bi_request_line_id);
                          row.qty = parseFloat(row.request_qty ? row.request_qty : 0) * parseFloat(row.conversion_rate ? row.conversion_rate : 1);
                        }
                      });
                    }
                  }
                })["catch"](function (error) {
                  console.log(error);
                });

              case 6:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    getCurrentDate: function getCurrentDate() {
      var y = new Date().getFullYear() + 543;
      var m = new Date().getMonth() + 1;
      var d = new Date().getDate();
      return d + '-' + m + '-' + y;
    },
    convertToThaiDate: function convertToThaiDate(d) {
      var yearThai = parseInt(d.split('-')[0]) + 543;
      var result = d.split('-')[2] + '-' + d.split('-')[1] + '-' + yearThai;
      return result;
    },
    convertFormatDate: function convertFormatDate(d) {
      console.log("d", d);
      return d; // let yyyy = new Date(d).getFullYear() - 543
      // let mm = new Date(d).getMonth() + 1
      // let dd = new Date(d).getDate()
      // return yyyy + '-' + mm + '-' + dd
    },
    onChangeUom2: function onChangeUom2(item, line, index) {
      var _this6 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee4() {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                if (_this6.profile.organization_code != 'M02') {
                  line.request_qty = '';
                  line.qty = '';
                  Vue.set(_this6.checked, index, '');
                } else {
                  line['qty'] = parseFloat(line.request_qty ? line.request_qty : 0) * parseFloat(item.conversion_rate ? item.conversion_rate : 1);
                }

                line['request_uom'] = item.from_unit_of_measure;
                line['conversion_rate'] = item.conversion_rate;
                console.log('2 => onChangeUom2', item, line, index);

              case 4:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    },
    onChangeYear: function onChangeYear() {// To do
      // this.thai_month = ''
      // this.biweekly = ''
      // this.display_date = ''
    },
    onChangeMonth: function onChangeMonth() {// To do
      // this.biweekly = ''
      // this.display_date = ''
    },
    onChangeBiweekly: function onChangeBiweekly() {
      var _this7 = this;

      // To do
      var lookup = this.lookups.filter(function (lookup) {
        return lookup.thai_year == _this7.thai_year && lookup.thai_month == _this7.thai_month && lookup.biweekly == _this7.biweekly;
      })[0];
      this.biweekly_id = lookup.biweekly_id;
      this.start_date = this.convertToThaiDate(lookup.start_date);
      this.min_date = this.convertToThaiDate(lookup.start_date);
      this.end_date = this.convertToThaiDate(lookup.end_date);
      this.max_date = this.convertToThaiDate(lookup.end_date);
    },
    validate: function validate() {
      var _this8 = this;

      var errors = [];

      if (this.checked.length > 0) {
        this.checked.forEach(function (lineId) {
          var line = _this8.lines.filter(function (line) {
            return line.bi_request_line_id == lineId;
          })[0];

          if (!line.qty) {
            errors.push('ปริมาณเบิกหลัก');
          } // if (!line.request_qty) {
          //     errors.push('ปริมาณเบิก')
          // }

        });
      }

      if (errors.length > 0) {
        (0,_commonDialogs__WEBPACK_IMPORTED_MODULE_3__.showValidationFailedDialog)(_toConsumableArray(new Set(errors)));
        return false;
      }

      return true;
    },
    onClickSaveLines: function onClickSaveLines() {
      if (!this.validate()) {
        return;
      }

      var params = {
        lines: this.lines,
        checked: this.checked
      };
      (0,_commonDialogs__WEBPACK_IMPORTED_MODULE_3__.showLoadingDialog)();
      axios.put("/pm/ajax/request-raw-materials/".concat(this.header_id), params).then(function (response) {
        if (response.status == 200) {
          swal.close();

          if (response.data.reqHeaderIds.length > 0) {
            (0,_commonDialogs__WEBPACK_IMPORTED_MODULE_3__.showLoadingDialog)();
            window.location.href = '/pm/material-requests?request_header_id=' + response.data.reqHeaderIds[0];
          } else {
            (0,_commonDialogs__WEBPACK_IMPORTED_MODULE_3__.showValidationFailedDialog)(response.data.errors);
          }
        }
      })["catch"](function (error) {
        swal.close();
        console.log(error);
      });
    },
    checkedAll: function checkedAll() {
      var _this9 = this;

      this.checked = [];
      this.isCheckedAll = !this.isCheckedAll;

      if (this.isCheckedAll) {
        this.lines.forEach(function (line) {
          if (line.request_qty) {
            _this9.checked.push(line.bi_request_line_id);
          }
        });
      }
    },
    updateChecked: function updateChecked() {
      this.isCheckedAll = this.checked.length === this.lines.length;
    }
  }
});

/***/ }),

/***/ "./resources/js/commonDialogs.js":
/*!***************************************!*\
  !*** ./resources/js/commonDialogs.js ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "showSimpleConfirmationDialog": () => /* binding */ showSimpleConfirmationDialog,
/* harmony export */   "showProgressWithUnsavedChangesWarningDialog": () => /* binding */ showProgressWithUnsavedChangesWarningDialog,
/* harmony export */   "showValidationFailedDialog": () => /* binding */ showValidationFailedDialog,
/* harmony export */   "showLoadingDialog": () => /* binding */ showLoadingDialog,
/* harmony export */   "showSaveSuccessDialog": () => /* binding */ showSaveSuccessDialog,
/* harmony export */   "showSaveFailureDialog": () => /* binding */ showSaveFailureDialog,
/* harmony export */   "showGenericFailureDialog": () => /* binding */ showGenericFailureDialog,
/* harmony export */   "showRemoveLineConfirmationDialog": () => /* binding */ showRemoveLineConfirmationDialog
/* harmony export */ });
function showSimpleConfirmationDialog(title) {
  return new Promise(function (resolve) {
    swal({
      title: title,
      type: 'warning',
      dangerMode: true,
      showCancelButton: true,
      closeOnCancel: true,
      cancelButtonText: 'ยกเลิก',
      showConfirmButton: true,
      closeOnConfirm: true,
      confirmButtonText: 'ยืนยัน'
    }, function (value) {
      resolve(value);
    });
  });
}
function showProgressWithUnsavedChangesWarningDialog() {
  return new Promise(function (resolve) {
    swal({
      title: "\n\u0E04\u0E38\u0E13\u0E41\u0E19\u0E48\u0E43\u0E08\u0E44\u0E2B\u0E21?",
      // new line is a workaround for icon cover text
      text: 'มีการเปลี่ยนแปลงข้อมูลโดยที่ยังไม่ได้บันทึก คุณต้องการดำเนินการต่อหรือไม่',
      type: 'warning',
      dangerMode: true,
      showCancelButton: true,
      closeOnCancel: true,
      cancelButtonText: 'ยกเลิก',
      showConfirmButton: true,
      closeOnConfirm: true,
      confirmButtonText: 'ดำเนินการต่อ',
      allowClickOutside: true,
      closeOnClickOutside: true
    }, function (value) {
      resolve(value);
    });
  });
}
function showValidationFailedDialog(errorMessages) {
  var errorText = '<div style="text-align:left;">' + 'ข้อมูลที่คุณใส่ไม่ถูกต้องหรือไม่ครบถ้วน กรุณาตรวจสอบข้อมูลและลองใหม่อีกครั้ง<br/><br/>' + '</div>';
  errorText += '<div style="text-align:left;color:red">';
  errorText += '<ul>';
  errorMessages.forEach(function (message) {
    errorText += "<li>".concat(message, "<br/></li>");
  });
  errorText += '</ul>';
  errorText += '</div>';
  return new Promise(function (resolve) {
    swal({
      title: "\n\u0E40\u0E01\u0E34\u0E14\u0E02\u0E49\u0E2D\u0E1C\u0E34\u0E14\u0E1E\u0E25\u0E32\u0E14",
      // new line is a workaround for icon cover text
      text: errorText,
      type: 'error',
      html: true,
      showConfirmButton: true,
      closeOnConfirm: true,
      confirmButtonText: 'ตกลง'
    }, function (value) {
      resolve(value);
    });
  });
}
function showLoadingDialog() {
  console.debug('showLoadingDialog');
  return new Promise(function (resolve) {
    swal({
      // new line is a workaround for icon cover text
      title: "\n                    <div class=\"sk-spinner sk-spinner-wave mb-4\">\n                        <div class=\"sk-rect1\"></div>\n                        <div class=\"sk-rect2\"></div>\n                        <div class=\"sk-rect3\"></div>\n                        <div class=\"sk-rect4\"></div>\n                        <div class=\"sk-rect5\"></div>\n                    </div>\n                    \u0E01\u0E33\u0E25\u0E31\u0E07\u0E14\u0E33\u0E40\u0E19\u0E34\u0E19\u0E01\u0E32\u0E23\n                    ",
      html: true,
      showConfirmButton: false,
      closeOnConfirm: false
    }, function (value) {
      resolve(value);
    });
  });
}
function showSaveSuccessDialog() {
  return new Promise(function (resolve) {
    swal({
      title: "\n\u0E2A\u0E33\u0E40\u0E23\u0E47\u0E08",
      // new line is a workaround for icon cover text
      text: 'บันทึกข้อมูลเรียบร้อย',
      type: 'success',
      dangerMode: false,
      showConfirmButton: true,
      closeOnConfirm: true,
      confirmButtonText: 'ปิด'
    }, function (value) {
      resolve(value);
    });
  });
}
function showSaveFailureDialog() {
  var errorText = "\u0E21\u0E35\u0E02\u0E49\u0E2D\u0E1C\u0E34\u0E14\u0E1E\u0E25\u0E32\u0E14\u0E40\u0E01\u0E34\u0E14\u0E02\u0E36\u0E49\u0E19 \u0E44\u0E21\u0E48\u0E2A\u0E32\u0E21\u0E32\u0E23\u0E16\u0E1A\u0E31\u0E19\u0E17\u0E36\u0E01\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E44\u0E14\u0E49 \u0E01\u0E23\u0E38\u0E13\u0E32\u0E25\u0E2D\u0E07\u0E43\u0E2B\u0E21\u0E48\u0E2D\u0E35\u0E01\u0E04\u0E23\u0E31\u0E49\u0E07\n";
  return new Promise(function (resolve) {
    swal({
      title: "\n\u0E21\u0E35\u0E02\u0E49\u0E2D\u0E1C\u0E34\u0E14\u0E1E\u0E25\u0E32\u0E14",
      // new line is a workaround for icon cover text
      text: errorText,
      type: 'error',
      showConfirmButton: true,
      closeOnConfirm: true,
      confirmButtonText: 'ปิด'
    }, function (value) {
      resolve(value);
    });
  });
}
function showGenericFailureDialog() {
  var errorText = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : "\u0E21\u0E35\u0E02\u0E49\u0E2D\u0E1C\u0E34\u0E14\u0E1E\u0E25\u0E32\u0E14\u0E40\u0E01\u0E34\u0E14\u0E02\u0E36\u0E49\u0E19 \u0E01\u0E23\u0E38\u0E13\u0E32\u0E25\u0E2D\u0E07\u0E43\u0E2B\u0E21\u0E48\u0E2D\u0E35\u0E01\u0E04\u0E23\u0E31\u0E49\u0E07\n";
  return new Promise(function (resolve) {
    swal({
      title: "\n\u0E40\u0E01\u0E34\u0E14\u0E02\u0E49\u0E2D\u0E1C\u0E34\u0E14\u0E1E\u0E25\u0E32\u0E14",
      // new line is a workaround for icon cover text
      text: errorText,
      type: 'error',
      showConfirmButton: true,
      closeOnConfirm: true,
      confirmButtonText: 'ปิด'
    }, function (value) {
      resolve(value);
    });
  });
}
function showRemoveLineConfirmationDialog(rowCount) {
  return new Promise(function (resolve) {
    swal({
      title: "\n\u0E04\u0E38\u0E13\u0E15\u0E49\u0E2D\u0E07\u0E01\u0E32\u0E23\u0E25\u0E1A\u0E02\u0E49\u0E2D\u0E21\u0E39\u0E25\u0E17\u0E35\u0E48\u0E16\u0E39\u0E01\u0E40\u0E25\u0E37\u0E2D\u0E01\u0E17\u0E31\u0E49\u0E07\u0E2B\u0E21\u0E14 ".concat(rowCount, " \u0E41\u0E16\u0E27\u0E43\u0E0A\u0E48\u0E2B\u0E23\u0E37\u0E2D\u0E44\u0E21\u0E48?"),
      // new line is a workaround for icon cover text
      type: 'warning',
      dangerMode: true,
      showCancelButton: true,
      closeOnCancel: true,
      cancelButtonText: 'ยกเลิก',
      showConfirmButton: true,
      closeOnConfirm: true,
      confirmButtonText: 'ยืนยัน'
    }, function (value) {
      resolve(value);
    });
  });
}

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/request-raw-materials/index.vue?vue&type=style&index=0&id=1b307d90&scoped=true&lang=css&":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/request-raw-materials/index.vue?vue&type=style&index=0&id=1b307d90&scoped=true&lang=css& ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "th[data-v-1b307d90], td[data-v-1b307d90] {\n  vertical-align: middle !important;\n  text-align: center;\n}\n.cursor-pointer[data-v-1b307d90]{ cursor:pointer;\n}\ninput.form-control.input-field[data-v-1b307d90] { border: 0px;\n}\n.mx-datepicker[data-v-1b307d90] { width: inherit !important;\n}\n.col-readonly[data-v-1b307d90] { background: #e9ecef42 !important;\n}\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/request-raw-materials/index.vue?vue&type=style&index=0&id=1b307d90&scoped=true&lang=css&":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/request-raw-materials/index.vue?vue&type=style&index=0&id=1b307d90&scoped=true&lang=css& ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_style_index_0_id_1b307d90_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./index.vue?vue&type=style&index=0&id=1b307d90&scoped=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/request-raw-materials/index.vue?vue&type=style&index=0&id=1b307d90&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_style_index_0_id_1b307d90_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default, options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_style_index_0_id_1b307d90_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__.default.locals || {});

/***/ }),

/***/ "./resources/js/pm/request-raw-materials/index.vue":
/*!*********************************************************!*\
  !*** ./resources/js/pm/request-raw-materials/index.vue ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _index_vue_vue_type_template_id_1b307d90_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./index.vue?vue&type=template&id=1b307d90&scoped=true& */ "./resources/js/pm/request-raw-materials/index.vue?vue&type=template&id=1b307d90&scoped=true&");
/* harmony import */ var _index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./index.vue?vue&type=script&lang=js& */ "./resources/js/pm/request-raw-materials/index.vue?vue&type=script&lang=js&");
/* harmony import */ var _index_vue_vue_type_style_index_0_id_1b307d90_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./index.vue?vue&type=style&index=0&id=1b307d90&scoped=true&lang=css& */ "./resources/js/pm/request-raw-materials/index.vue?vue&type=style&index=0&id=1b307d90&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__.default)(
  _index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _index_vue_vue_type_template_id_1b307d90_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _index_vue_vue_type_template_id_1b307d90_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "1b307d90",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pm/request-raw-materials/index.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pm/request-raw-materials/index.vue?vue&type=script&lang=js&":
/*!**********************************************************************************!*\
  !*** ./resources/js/pm/request-raw-materials/index.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./index.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/request-raw-materials/index.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/pm/request-raw-materials/index.vue?vue&type=style&index=0&id=1b307d90&scoped=true&lang=css&":
/*!******************************************************************************************************************!*\
  !*** ./resources/js/pm/request-raw-materials/index.vue?vue&type=style&index=0&id=1b307d90&scoped=true&lang=css& ***!
  \******************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_0_rules_0_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_style_index_0_id_1b307d90_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader/dist/cjs.js!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./index.vue?vue&type=style&index=0&id=1b307d90&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9[0].rules[0].use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/request-raw-materials/index.vue?vue&type=style&index=0&id=1b307d90&scoped=true&lang=css&");


/***/ }),

/***/ "./resources/js/pm/request-raw-materials/index.vue?vue&type=template&id=1b307d90&scoped=true&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/pm/request-raw-materials/index.vue?vue&type=template&id=1b307d90&scoped=true& ***!
  \****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_template_id_1b307d90_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_template_id_1b307d90_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_template_id_1b307d90_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./index.vue?vue&type=template&id=1b307d90&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/request-raw-materials/index.vue?vue&type=template&id=1b307d90&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/request-raw-materials/index.vue?vue&type=template&id=1b307d90&scoped=true&":
/*!*******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pm/request-raw-materials/index.vue?vue&type=template&id=1b307d90&scoped=true& ***!
  \*******************************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "row" }, [
    _c("div", { staticClass: "col-lg-12" }, [
      _c("div", { staticClass: "ibox" }, [
        _c("div", { staticClass: "ibox-title" }, [
          _c("h5", { staticClass: "pb-3" }, [
            _vm._v(
              "\n                       " +
                _vm._s(_vm.title) +
                "\n                       "
            ),
            _c("div", { staticClass: "pull-right" }, [
              _c(
                "button",
                {
                  class: _vm.transbtn.create.class,
                  on: { click: _vm.onClickCreate }
                },
                [_c("i", { staticClass: "fa fa-plus" }), _vm._v(" สร้าง")]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  class: _vm.transbtn.save.class,
                  attrs: { disabled: _vm.checkDisableBtn },
                  on: {
                    click: function($event) {
                      $event.preventDefault()
                      return _vm.onClickSave($event)
                    }
                  }
                },
                [
                  _c("i", { staticClass: "fa fa-save" }),
                  _vm._v(" ประมาณการเบิก")
                ]
              )
            ])
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "ibox-content" }, [
          _c("div", { staticClass: "row" }, [
            _c("div", { staticClass: "col-lg-6 b-r" }, [
              _c("div", { staticClass: "form-group row" }, [
                _vm._m(0),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-lg-8" },
                  [
                    _c(
                      "el-select",
                      {
                        attrs: {
                          filterable: "",
                          remote: "",
                          placeholder: "เลือกปี"
                        },
                        on: { change: _vm.onChangeYear },
                        model: {
                          value: _vm.thai_year,
                          callback: function($$v) {
                            _vm.thai_year = $$v
                          },
                          expression: "thai_year"
                        }
                      },
                      _vm._l(_vm.yearLists, function(year) {
                        return _c("el-option", {
                          key: year,
                          attrs: { label: year, value: year }
                        })
                      }),
                      1
                    )
                  ],
                  1
                )
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "form-group row" }, [
                _vm._m(1),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-lg-8" },
                  [
                    _c(
                      "el-select",
                      {
                        attrs: {
                          filterable: "",
                          remote: "",
                          placeholder: "เลือกเดือน"
                        },
                        on: { change: _vm.onChangeMonth },
                        model: {
                          value: _vm.thai_month,
                          callback: function($$v) {
                            _vm.thai_month = $$v
                          },
                          expression: "thai_month"
                        }
                      },
                      _vm._l(_vm.monthLists, function(month) {
                        return _c("el-option", {
                          key: month,
                          attrs: { label: month, value: month }
                        })
                      }),
                      1
                    )
                  ],
                  1
                )
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "form-group row" }, [
                _vm._m(2),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-lg-8" },
                  [
                    _c(
                      "el-select",
                      {
                        attrs: {
                          filterable: "",
                          remote: "",
                          placeholder: "เลือกปักษ์"
                        },
                        on: { change: _vm.onChangeBiweekly },
                        model: {
                          value: _vm.biweekly,
                          callback: function($$v) {
                            _vm.biweekly = $$v
                          },
                          expression: "biweekly"
                        }
                      },
                      _vm._l(_vm.biweeklyLists, function(biweekly) {
                        return _c("el-option", {
                          key: biweekly,
                          attrs: { label: biweekly, value: biweekly }
                        })
                      }),
                      1
                    )
                  ],
                  1
                )
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "form-group row" }, [
                _vm._m(3),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-lg-8" },
                  [
                    _c("datepicker-th", {
                      staticClass: "form-control",
                      attrs: {
                        placeholder: "เลือกวันที่ขอเบิก",
                        "not-before-date": _vm.current_date,
                        "not-after-date": _vm.maxSelectedDate,
                        value: _vm.req_date,
                        format: _vm.transdate["js-format"]
                      },
                      on: {
                        dateWasSelected: function(dateObject) {
                          return (_vm.req_date = dateObject)
                        }
                      }
                    })
                  ],
                  1
                )
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "form-group row" }, [
                _vm._m(4),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-lg-8" },
                  [
                    _c(
                      "el-select",
                      {
                        attrs: {
                          filterable: "",
                          remote: "",
                          placeholder: "เลือกประเภทวัตถุดิบ",
                          disabled:
                            _vm.dep_code != "M02" && _vm.dep_code != "M03"
                        },
                        model: {
                          value: _vm.item_code,
                          callback: function($$v) {
                            _vm.item_code = $$v
                          },
                          expression: "item_code"
                        }
                      },
                      _vm._l(_vm.items, function(item) {
                        return _c("el-option", {
                          key: item.item_classification_code,
                          attrs: {
                            label: item.item_classification,
                            value: item.item_classification_code
                          }
                        })
                      }),
                      1
                    )
                  ],
                  1
                )
              ]),
              _vm._v(" "),
              _vm.dep_code != "M02" && _vm.dep_code != "M03"
                ? _c("div", { staticClass: "form-group row" }, [
                    _vm._m(5),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-lg-4" },
                      [
                        _c("datepicker-th", {
                          staticClass: "form-control",
                          attrs: {
                            placeholder: "เลือกวันที่",
                            "disabled-date-to": _vm.min_date,
                            value: _vm.start_date,
                            format: _vm.transdate["js-format"]
                          },
                          on: {
                            dateWasSelected: function($event) {
                              var i = arguments.length,
                                argsArray = Array(i)
                              while (i--) argsArray[i] = arguments[i]
                              return _vm.setdate.apply(
                                void 0,
                                argsArray.concat(["start_date"])
                              )
                            }
                          }
                        })
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "label",
                      {
                        staticClass: "col-lg-1 col-form-label text-center pt-2"
                      },
                      [_vm._v("ถึง")]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "col-lg-3" },
                      [
                        _c("datepicker-th", {
                          staticClass: "form-control",
                          attrs: {
                            placeholder: "เลือกวันที่",
                            "not-before-date": _vm.min_date,
                            "not-after-date": _vm.max_date,
                            value: _vm.end_date,
                            format: _vm.transdate["js-format"]
                          },
                          on: {
                            dateWasSelected: function($event) {
                              var i = arguments.length,
                                argsArray = Array(i)
                              while (i--) argsArray[i] = arguments[i]
                              return _vm.setdate.apply(
                                void 0,
                                argsArray.concat(["end_date"])
                              )
                            }
                          }
                        })
                      ],
                      1
                    )
                  ])
                : _vm._e(),
              _vm._v(" "),
              _c("div", { staticClass: "form-group row" }, [
                _vm._m(6),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-lg-8" },
                  [
                    _c("div", { staticClass: "form-check form-check-inline" }, [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.oprnValue,
                            expression: "oprnValue"
                          }
                        ],
                        staticClass: "form-check-input",
                        attrs: {
                          name: "oprn_name",
                          type: "radio",
                          value: "all",
                          id: "checkAllOprn"
                        },
                        domProps: { checked: _vm._q(_vm.oprnValue, "all") },
                        on: {
                          change: function($event) {
                            _vm.oprnValue = "all"
                          }
                        }
                      }),
                      _vm._v(" "),
                      _c(
                        "label",
                        {
                          staticClass: "form-check-label",
                          attrs: { for: "checkAllOprn" }
                        },
                        [
                          _vm._v(
                            "\n                                           All\n                                       "
                          )
                        ]
                      )
                    ]),
                    _vm._v(" "),
                    _vm._l(_vm.oprn_rows, function(oprn, index) {
                      return _c(
                        "div",
                        {
                          key: index,
                          staticClass: "form-check form-check-inline"
                        },
                        [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.oprnValue,
                                expression: "oprnValue"
                              }
                            ],
                            staticClass: "form-check-input",
                            attrs: {
                              name: "oprn_name",
                              type: "radio",
                              id: index
                            },
                            domProps: {
                              value: oprn.oprn_class_desc,
                              checked: _vm._q(
                                _vm.oprnValue,
                                oprn.oprn_class_desc
                              )
                            },
                            on: {
                              change: function($event) {
                                _vm.oprnValue = oprn.oprn_class_desc
                              }
                            }
                          }),
                          _vm._v(" "),
                          _c(
                            "label",
                            {
                              staticClass: "form-check-label",
                              attrs: { for: index }
                            },
                            [
                              _vm._v(
                                "\n                                            " +
                                  _vm._s(oprn.oprn_desc) +
                                  "\n                                       "
                              )
                            ]
                          )
                        ]
                      )
                    })
                  ],
                  2
                )
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-lg-6" }, [
              _c("div", { staticClass: "form-group row" }, [
                _c("label", { staticClass: "col-lg-4 col-form-label" }, [
                  _vm._v("หน่วยงานที่ขอเบิก:")
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-lg-8" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.orgfullname,
                        expression: "orgfullname"
                      }
                    ],
                    staticClass: "form-control",
                    attrs: { type: "text", disabled: "" },
                    domProps: { value: _vm.orgfullname },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.orgfullname = $event.target.value
                      }
                    }
                  })
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "form-group row" }, [
                _c("label", { staticClass: "col-lg-4 col-form-label" }, [
                  _vm._v("ผู้ขอเบิก:")
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-lg-8" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.req_by,
                        expression: "req_by"
                      }
                    ],
                    staticClass: "form-control",
                    attrs: { type: "text", disabled: "" },
                    domProps: { value: _vm.req_by },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.req_by = $event.target.value
                      }
                    }
                  })
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "form-group row" }, [
                _vm._m(7),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "col-lg-8" },
                  [
                    _c("datepicker-th", {
                      staticClass: "form-control",
                      attrs: {
                        placeholder: "เลือกวันที่นำส่ง ยสท.",
                        "not-before-date": _vm.req_date,
                        "not-after-date": _vm.maxSelectedDate,
                        value: _vm.send_date,
                        format: _vm.transdate["js-format"]
                      },
                      on: {
                        dateWasSelected: function($event) {
                          var i = arguments.length,
                            argsArray = Array(i)
                          while (i--) argsArray[i] = arguments[i]
                          return _vm.setdate.apply(
                            void 0,
                            argsArray.concat(["send_date"])
                          )
                        }
                      }
                    })
                  ],
                  1
                )
              ])
            ])
          ])
        ])
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "ibox" }, [
        _c("div", { staticClass: "ibox-title" }, [
          _c("h5", { staticClass: "pb-3" }, [
            _vm._v(
              "\n                       รายการวัตถุดิบ\n                       "
            ),
            _c(
              "button",
              {
                class: _vm.transbtn.create.class + " pull-right",
                attrs: { type: "button", disabled: _vm.checked.length == 0 },
                on: {
                  click: function($event) {
                    $event.preventDefault()
                    return _vm.onClickSaveLines($event)
                  }
                }
              },
              [
                _c("i", { staticClass: "fa fa-plus" }),
                _vm._v(" สร้างรายการขอเบิก")
              ]
            )
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "ibox-content" }, [
          _c("div", { staticClass: "table-responsive" }, [
            _c("table", { staticClass: "table table-bordered" }, [
              _c("thead", [
                _c("tr", [
                  _c("th", [
                    _c("label", [
                      _c("input", {
                        directives: [
                          {
                            name: "model",
                            rawName: "v-model",
                            value: _vm.isCheckedAll,
                            expression: "isCheckedAll"
                          }
                        ],
                        staticClass: "align-middle",
                        staticStyle: { transform: "scale(1.5)" },
                        attrs: { type: "checkbox" },
                        domProps: {
                          checked: Array.isArray(_vm.isCheckedAll)
                            ? _vm._i(_vm.isCheckedAll, null) > -1
                            : _vm.isCheckedAll
                        },
                        on: {
                          click: _vm.checkedAll,
                          change: function($event) {
                            var $$a = _vm.isCheckedAll,
                              $$el = $event.target,
                              $$c = $$el.checked ? true : false
                            if (Array.isArray($$a)) {
                              var $$v = null,
                                $$i = _vm._i($$a, $$v)
                              if ($$el.checked) {
                                $$i < 0 &&
                                  (_vm.isCheckedAll = $$a.concat([$$v]))
                              } else {
                                $$i > -1 &&
                                  (_vm.isCheckedAll = $$a
                                    .slice(0, $$i)
                                    .concat($$a.slice($$i + 1)))
                              }
                            } else {
                              _vm.isCheckedAll = $$c
                            }
                          }
                        }
                      })
                    ])
                  ]),
                  _vm._v(" "),
                  _c("th", [_vm._v("รหัสวัตถุดิบ")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("รายละเอียด")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("ปริมาณที่ต้องใช้+สูญเสีย")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("หน่วยนับ")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("ปริมาณเบิกหลัก")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("หน่วยเบิกหลัก")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("ปริมาณเบิก")]),
                  _vm._v(" "),
                  _c("th", [_vm._v("หน่วยเบิก")])
                ])
              ]),
              _vm._v(" "),
              _c(
                "tbody",
                _vm._l(_vm.lines, function(line, index) {
                  return _c("tr", { key: index }, [
                    _c("td", [
                      _c("label", [
                        _c("input", {
                          directives: [
                            {
                              name: "model",
                              rawName: "v-model",
                              value: _vm.checked,
                              expression: "checked"
                            }
                          ],
                          staticClass: "align-middle",
                          staticStyle: { transform: "scale(1.5)" },
                          attrs: { type: "checkbox", disabled: !line.qty },
                          domProps: {
                            value: line.bi_request_line_id,
                            checked: Array.isArray(_vm.checked)
                              ? _vm._i(_vm.checked, line.bi_request_line_id) >
                                -1
                              : _vm.checked
                          },
                          on: {
                            change: [
                              function($event) {
                                var $$a = _vm.checked,
                                  $$el = $event.target,
                                  $$c = $$el.checked ? true : false
                                if (Array.isArray($$a)) {
                                  var $$v = line.bi_request_line_id,
                                    $$i = _vm._i($$a, $$v)
                                  if ($$el.checked) {
                                    $$i < 0 && (_vm.checked = $$a.concat([$$v]))
                                  } else {
                                    $$i > -1 &&
                                      (_vm.checked = $$a
                                        .slice(0, $$i)
                                        .concat($$a.slice($$i + 1)))
                                  }
                                } else {
                                  _vm.checked = $$c
                                }
                              },
                              _vm.updateChecked
                            ]
                          }
                        })
                      ])
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-readonly" }, [
                      _vm._v(_vm._s(line.item_code))
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-readonly text-left" }, [
                      _vm._v(_vm._s(line.description))
                    ]),
                    _vm._v(" "),
                    _c(
                      "td",
                      { staticClass: "col-readonly text-right" },
                      [
                        _vm.dep_code == "M02" || _vm.dep_code == "M03"
                          ? [
                              _vm._v(
                                "\n                                           " +
                                  _vm._s(
                                    Number(
                                      line.total_qty
                                        ? parseFloat(line.total_qty)
                                        : 0
                                    ).toLocaleString(undefined, {
                                      minimumFractionDigits: 2,
                                      maximumFractionDigits: 2
                                    })
                                  ) +
                                  "\n                                       "
                              )
                            ]
                          : [
                              _vm._v(
                                "\n                                           " +
                                  _vm._s(
                                    Number(
                                      line.total_qty
                                        ? parseFloat(line.total_qty)
                                        : 0
                                    ).toLocaleString(undefined, {
                                      minimumFractionDigits: 5,
                                      maximumFractionDigits: 5
                                    })
                                  ) +
                                  "\n                                       "
                              )
                            ]
                      ],
                      2
                    ),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-readonly" }, [
                      _vm._v(_vm._s(line.uom_thai))
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-readonly text-right" }, [
                      _c("div", { attrs: { title: line.conversion_rate } }, [
                        _c(
                          "strong",
                          [
                            _vm.dep_code == "M02" || _vm.dep_code == "M03"
                              ? [
                                  _vm._v(
                                    "\n                                                   " +
                                      _vm._s(
                                        Number(
                                          line.qty ? parseFloat(line.qty) : 0
                                        ).toLocaleString(undefined, {
                                          minimumFractionDigits: 2,
                                          maximumFractionDigits: 2
                                        })
                                      ) +
                                      "\n                                               "
                                  )
                                ]
                              : [
                                  _vm._v(
                                    "\n                                                   " +
                                      _vm._s(
                                        Number(
                                          line.qty ? parseFloat(line.qty) : 0
                                        ).toLocaleString(undefined, {
                                          minimumFractionDigits: 2,
                                          maximumFractionDigits: 2
                                        })
                                      ) +
                                      "\n                                               "
                                  )
                                ]
                          ],
                          2
                        )
                      ])
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-readonly" }, [
                      _vm._v(_vm._s(line.uom_thai))
                    ]),
                    _vm._v(" "),
                    _c(
                      "td",
                      [
                        _c("vue-numeric", {
                          class: "form-control text-right ",
                          attrs: {
                            placeholder: "",
                            separator: ",",
                            precision: 2,
                            minus: false
                          },
                          on: {
                            change: function($event) {
                              return _vm.onChangeRequestQty2(index, line)
                            }
                          },
                          model: {
                            value: line.request_qty,
                            callback: function($$v) {
                              _vm.$set(line, "request_qty", $$v)
                            },
                            expression: "line.request_qty"
                          }
                        })
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "td",
                      { staticClass: "col-readonly" },
                      [
                        _c(
                          "el-select",
                          {
                            attrs: {
                              "value-key": "from_unit_of_measure",
                              filterable: "",
                              remote: "",
                              placeholder: "เลือกหน่วยนับ"
                            },
                            on: {
                              change: function($event) {
                                return _vm.onChangeUom2($event, line, index)
                              }
                            },
                            model: {
                              value: line.uom2,
                              callback: function($$v) {
                                _vm.$set(line, "uom2", $$v)
                              },
                              expression: "line.uom2"
                            }
                          },
                          _vm._l(line.list_uom2, function(item) {
                            return _c("el-option", {
                              key: item.from_unit_of_measure,
                              attrs: {
                                label: item.from_unit_of_measure,
                                value: item
                              }
                            })
                          }),
                          1
                        )
                      ],
                      1
                    )
                  ])
                }),
                0
              )
            ])
          ])
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
    return _c("label", { staticClass: "col-lg-4 col-form-label" }, [
      _vm._v("ปีงบประมาณ: "),
      _c("span", { staticStyle: { color: "red" } }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "col-lg-4 col-form-label" }, [
      _vm._v("แผนการผลิตประจำเดือน: "),
      _c("span", { staticStyle: { color: "red" } }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "col-lg-4 col-form-label" }, [
      _vm._v("ปักษ์ที่: "),
      _c("span", { staticStyle: { color: "red" } }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "col-lg-4 col-form-label" }, [
      _vm._v("วันที่ขอเบิก: "),
      _c("span", { staticStyle: { color: "red" } }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "col-lg-4 col-form-label" }, [
      _vm._v("ประเภทวัตถุดิบ: "),
      _c("span", { staticStyle: { color: "red" } }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "col-lg-4 col-form-label" }, [
      _vm._v("วันที่ผลิต"),
      _c("span", { staticStyle: { color: "red" } }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "col-lg-4 col-form-label" }, [
      _vm._v("ขั่นตอนการทำงาน"),
      _c("span", { staticStyle: { color: "red" } }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("label", { staticClass: "col-lg-4 col-form-label" }, [
      _vm._v("วันที่นำส่ง ยสท."),
      _c("span", { staticStyle: { color: "red" } }, [_vm._v("*")]),
      _vm._v(":")
    ])
  }
]
render._withStripped = true



/***/ })

}]);