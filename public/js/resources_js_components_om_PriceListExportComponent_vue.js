(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_om_PriceListExportComponent_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/PriceListExportComponent.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/PriceListExportComponent.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************************/
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
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_2__);


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


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['currencies', 'items', 'uoms', 'defaultValue', 'old', 'urlSave', 'urlReset', 'btnTrans', 'itemAlls'],
  data: function data() {
    return {
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      nameHeader: this.old.name ? this.old.name : this.defaultValue ? this.defaultValue.name : '',
      description: this.old.description ? this.old.description : this.defaultValue ? this.defaultValue.description : '',
      currency_code: this.old.currency ? this.old.currency : this.defaultValue ? this.defaultValue.currency : '',
      effective_dates_from: this.old.effective_dates_from ? this.old.effective_dates_from : this.defaultValue ? this.defaultValue.effective_dates_from : '',
      effective_dates_to: this.old.effective_dates_to ? this.old.effective_dates_to : this.defaultValue ? this.defaultValue.effective_dates_to : '',
      comments: this.old.comments ? this.old.comments : this.defaultValue ? this.defaultValue.comments : '',
      // active_flag            : true,
      active_flag: this.old.active_flag ? true : this.defaultValue ? this.defaultValue.active_flag == 'Y' ? true : '' : true,
      lines: [],
      disabledData: this.defaultValue ? this.defaultValue.name ? true : false : false
    };
  },
  mounted: function mounted() {
    var _this = this;

    if (this.defaultValue) {
      if (this.defaultValue.list_lines) {
        this.defaultValue.list_lines.forEach(function (list_line) {
          var item_find = _this.itemAlls.find(function (i) {
            return i.item_id == list_line.product_value;
          });

          var item_desc = item_find ? item_find.item_code + ' : ' + item_find.ecom_item_description : '';

          _this.lines.push({
            id: list_line.list_line_id,
            lineId: '',
            item_id: list_line.product_value,
            uom_code: list_line.uom,
            price: list_line.value.replace(/\B(?=(\d{3})+(?!\d))/g, ","),
            // price       : list_line.value,
            // price       : parseFloat(list_line.value).toFixed(2),
            start_date: list_line.start_date,
            end_date: list_line.end_date,
            status: 'update',
            disabledRow: true,
            item_desc: item_desc
          });
        });
      } else {
        this.addLine();
      }
    } else {
      this.addLine();
    }
  },
  methods: {
    // checkDateLineTest(row, index){
    //   if (!row.item_id) {
    //     row.price       = '';
    //     row.start_date  = '';
    //     row.end_date    = '';
    //   }
    //   this.selectedTest = this.lines.find(item => {
    //     if (item.id != row.id) {
    //       console.log('item.id != row.id');
    //       if (row.item_id == item.item_id) {
    //         console.log('row.item_id ------> ' + row.item_id);
    //         console.log('item.item_id ------> ' + item.item_id);
    //         if (row.start_date) {
    //           console.log('has start date');
    //           if (moment(String(row.start_date)).format('yyyy-MM-DD') < moment(String(item.start_date)).format('yyyy-MM-DD')) {
    //             console.log('Result  ---> ' + moment(String(row.start_date)).format('yyyy-MM-DD') < moment(String(item.start_date)).format('yyyy-MM-DD'));
    //             this.$notify.error({
    //                   title: 'มีข้อผิดพลาด',
    //                   message: 'ไม่สามารถเลือกช่วงเวลาซ้ำกันภายใต้ Item เดียวกันได้',
    //             });
    //             row.start_date = '';
    //           }
    //         } else {
    //           console.log('nooooo start date');
    //           this.$notify.error({
    //                   title: 'มีข้อผิดพลาด',
    //                   message: 'ไม่สามารถเลือกช่วงเวลาซ้ำกันภายใต้ Item เดียวกันได้',
    //             });
    //           row.item_id     = '';
    //           row.uom_code    = '';
    //           row.price       = '';
    //           row.start_date  = '';
    //           row.end_date    = '';
    //         }
    //       }
    //     } else {
    //       console.log('item.id == row.id');
    //     }
    //   });
    //   // if (index > 0) {
    //   //   var idx = this.lines.find(item => {
    //   //     if (item.id != row.id) {
    //   //       if (row.item_id == item.item_id) {
    //   //         if (item.end_date) {
    //   //             // console.log(moment(String(row.start_date)).format('Y-M-d'));
    //   //             // console.log(moment(String(item.end_date)).format('DD-MM-yyyy'));
    //   //           // if (row.start_date == '') {
    //   //           //     row.start_date = '02-02-2000';
    //   //           // } 
    //   //           if (row.start_date) {
    //   //             console.log('has start date');
    //   //             if (moment(String(row.start_date)).format('yyyy-MM-DD') <= moment(String(item.end_date)).format('yyyy-MM-DD')) {
    //   //               // console.log(moment(String(row.start_date)).format('Y-M-d'));
    //   //               // console.log(moment(String(item.end_date)).format('Y-M-d'));
    //   //               this.$notify.error({
    //   //                     title: 'มีข้อผิดพลาด',
    //   //                     message: 'ไม่สามารถเลือกช่วงเวลาซ้ำกันภายใต้ Item เดียวกันได้',
    //   //               });
    //   //               row.start_date = '';
    //   //               row.end_date = '';
    //   //             }
    //   //           }
    //   //           if (row.end_date) {
    //   //             console.log('has end date');
    //   //             if (row.end_date <= item.end_date) {
    //   //               this.$notify.error({
    //   //                     title: 'มีข้อผิดพลาด',
    //   //                     message: 'ไม่สามารถเลือกช่วงเวลาซ้ำกันภายใต้ Item เดียวกันได้',
    //   //               });
    //   //               row.start_date = '';
    //   //               row.end_date = '';
    //   //             }
    //   //           }
    //   //           if (row.start_date && row.end_date) {
    //   //             console.log('has both');
    //   //           // console.log(row.start_date);
    //   //             if (row.end_date < row.start_date) {
    //   //               // console.log(moment(String(row.start_date)).format('Y-M-d'));
    //   //               // console.log(moment(String(item.end_date)).format('Y-M-d'));
    //   //               this.$notify.error({
    //   //                     title: 'มีข้อผิดพลาด',
    //   //                     message: 'วันที่สิ้นสุด ต้องไม่น้อยกว่าวันที่เริ่มต้น',
    //   //               });
    //   //               row.start_date = '';
    //   //               row.end_date = '';
    //   //             }
    //   //           }
    //   //         } 
    //   //         else {
    //   //           this.$notify.error({
    //   //                   title: 'มีข้อผิดพลาด',
    //   //                   message: 'ไม่สามารถเลือกช่วงเวลาซ้ำกันภายใต้ Item เดียวกันได้',
    //   //             });
    //   //             row.item_id = '';
    //   //             row.uom_code = '';
    //   //             row.price   = '';
    //   //             row.start_date = '';
    //   //             row.end_date = '';
    //   //         }
    //   //       }
    //   //     }
    //   //   });
    //   // } else {
    //   //   if (row.end_date) {
    //   //     if (row.end_date < row.start_date) {
    //   //               this.$notify.error({
    //   //                     title: 'มีข้อผิดพลาด',
    //   //                     message: 'วันที่สิ้นสุด ต้องไม่น้อยกว่าวันที่เริ่มต้น',
    //   //               });
    //   //               row.end_date = '';
    //   //     }
    //   //   }
    //   // }
    // },
    // ------------------------------------------------------------------------------------------------
    addLine: function addLine() {
      var today = new Date();
      console.log('xxxxx ---> ' + today);
      var time = moment__WEBPACK_IMPORTED_MODULE_2___default()(today).format('DDMMyyyy') + String(today.getHours()) + String(today.getMinutes()) + String(today.getSeconds());
      this.lines.push({
        //   id          : time,
        id: uuid_v1__WEBPACK_IMPORTED_MODULE_1___default()(),
        lineId: '',
        item_id: '',
        uom_code: '',
        price: '',
        start_date: '',
        end_date: '',
        status: 'new',
        disabledRow: false,
        item_desc: ''
      });
    },
    removeRow: function removeRow(index) {
      this.lines.splice(index, 1);
    },
    checkDateHeader: function checkDateHeader(row, index) {
      // console.log('checkDateHeader');
      if (this.effective_dates_from) {
        if (row.start_date) {
          if (moment__WEBPACK_IMPORTED_MODULE_2___default()(String(row.start_date)).format('yyyy-MM-DD') < moment__WEBPACK_IMPORTED_MODULE_2___default()(String(this.effective_dates_from)).format('yyyy-MM-DD')) {
            // console.log('if');
            this.$notify.error({
              title: 'มีข้อผิดพลาด',
              message: 'วันที่เริ่มต้นใช้งานและวันที่สิ้นสุดใช้งาน ระดับ Line ต้องอยู่ในช่วงของวันที่ใช้งานและวันที่สิ้นสุด ระดับ Header'
            });
            row.start_date = '';
          }
        }
      }

      if (this.effective_dates_to) {
        if (row.start_date) {
          if (moment__WEBPACK_IMPORTED_MODULE_2___default()(String(row.start_date)).format('yyyy-MM-DD') > moment__WEBPACK_IMPORTED_MODULE_2___default()(String(this.effective_dates_to)).format('yyyy-MM-DD')) {
            this.$notify.error({
              title: 'มีข้อผิดพลาด',
              message: 'วันที่เริ่มต้นใช้งานและวันที่สิ้นสุดใช้งาน ระดับ Line ต้องอยู่ในช่วงของวันที่ใช้งานและวันที่สิ้นสุด ระดับ Header'
            });
            row.start_date = '';
          }
        }

        if (row.end_date) {
          if (moment__WEBPACK_IMPORTED_MODULE_2___default()(String(row.end_date)).format('yyyy-MM-DD') > moment__WEBPACK_IMPORTED_MODULE_2___default()(String(this.effective_dates_to)).format('yyyy-MM-DD')) {
            this.$notify.error({
              title: 'มีข้อผิดพลาด',
              message: 'วันที่เริ่มต้นใช้งานและวันที่สิ้นสุดใช้งาน ระดับ Line ต้องอยู่ในช่วงของวันที่ใช้งานและวันที่สิ้นสุด ระดับ Header'
            });
            row.end_date = '';
          }
        }
      }
    },
    checkDateLine: function checkDateLine(row, index) {
      var _this2 = this;

      if (!row.item_id) {
        row.price = '';
        row.start_date = '';
        row.end_date = '';
      }

      if (index > 0) {
        var idx = this.lines.find(function (item) {
          if (item.id != row.id) {
            if (row.item_id == item.item_id) {
              if (item.end_date) {
                if (row.start_date) {
                  console.log('has start date');

                  if (moment__WEBPACK_IMPORTED_MODULE_2___default()(String(row.start_date)).format('yyyy-MM-DD') <= moment__WEBPACK_IMPORTED_MODULE_2___default()(String(item.end_date)).format('yyyy-MM-DD')) {
                    _this2.$notify.error({
                      title: 'มีข้อผิดพลาด',
                      message: 'ไม่สามารถเลือกช่วงเวลาซ้ำกันภายใต้ Item เดียวกันได้'
                    });

                    row.start_date = '';
                    row.end_date = '';
                  }
                }

                if (row.end_date) {
                  console.log('has end date');

                  if (row.end_date <= item.end_date) {
                    _this2.$notify.error({
                      title: 'มีข้อผิดพลาด',
                      message: 'ไม่สามารถเลือกช่วงเวลาซ้ำกันภายใต้ Item เดียวกันได้'
                    });

                    row.start_date = '';
                    row.end_date = '';
                  }
                }

                if (row.start_date && row.end_date) {
                  if (row.end_date < row.start_date) {
                    _this2.$notify.error({
                      title: 'มีข้อผิดพลาด',
                      message: 'วันที่สิ้นสุด ต้องไม่น้อยกว่าวันที่เริ่มต้น'
                    });

                    row.start_date = '';
                    row.end_date = '';
                  }
                }
              } else {
                _this2.$notify.error({
                  title: 'มีข้อผิดพลาด',
                  message: 'ไม่สามารถเลือกช่วงเวลาซ้ำกันภายใต้ Item เดียวกันได้'
                });

                row.item_id = '';
                row.uom_code = '';
                row.price = '';
                row.start_date = '';
                row.end_date = '';
              }
            }
          }
        });
      } else {
        if (row.end_date) {
          if (row.end_date < row.start_date) {
            this.$notify.error({
              title: 'มีข้อผิดพลาด',
              message: 'วันที่สิ้นสุด ต้องไม่น้อยกว่าวันที่เริ่มต้น'
            });
            row.end_date = '';
          }
        }
      }
    },
    getUom: function getUom(row, index) {
      if (row.item_id) {
        this.selectedData = this.items.find(function (i) {
          if (i.item_id == row.item_id) {
            row.uom_code = i.uom;
          }
        });
      } else {
        row.uom_code = '';
      }
    },
    checkStartDate: function checkStartDate(row) {
      if (row.start_date == '') {
        this.$notify.error({
          title: 'มีข้อผิดพลาด',
          message: 'โปรดเลือกวันที่เริ่มต้นใช้งาน'
        });
        row.end_date = '';
      }
    },
    onlyNumeric: function onlyNumeric(row) {
      if (row.price) {
        // console.log('price ---> ' + parseFloat(row.price).toFixed(2));
        row.price = row.price.replace(/[^0-9 .]/g, ''); // row.price = parseFloat(row.price).toFixed(2);

        row.price = row.price.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      }
    },
    validateHeaderDate: function validateHeaderDate() {
      var _this3 = this;

      if (this.effective_dates_from) {
        this.selectedData = this.lines.find(function (line) {
          if (line.start_date) {
            return moment__WEBPACK_IMPORTED_MODULE_2___default()(String(line.start_date)).format('yyyy-MM-DD') < moment__WEBPACK_IMPORTED_MODULE_2___default()(String(_this3.effective_dates_from)).format('yyyy-MM-DD');
          }

          if (line.end_date) {
            return moment__WEBPACK_IMPORTED_MODULE_2___default()(String(line.end_date)).format('yyyy-MM-DD') < moment__WEBPACK_IMPORTED_MODULE_2___default()(String(_this3.effective_dates_from)).format('yyyy-MM-DD');
          }
        });

        if (this.selectedData) {
          this.effective_dates_from = '';
          this.$notify.error({
            title: 'มีข้อผิดพลาด',
            message: 'วันที่ใช้งานและวันที่สิ้นสุด ระดับ Header ต้องอยู่ในช่วงของวันที่เริ่มต้นใช้งานและวันที่สิ้นสุดใช้งาน ระดับ Line'
          });
        }
      }

      if (this.effective_dates_to) {
        this.selectedData = this.lines.find(function (line) {
          if (line.start_date) {
            return moment__WEBPACK_IMPORTED_MODULE_2___default()(String(line.start_date)).format('yyyy-MM-DD') > moment__WEBPACK_IMPORTED_MODULE_2___default()(String(_this3.effective_dates_to)).format('yyyy-MM-DD');
          }

          if (line.end_date) {
            return moment__WEBPACK_IMPORTED_MODULE_2___default()(String(line.end_date)).format('yyyy-MM-DD') > moment__WEBPACK_IMPORTED_MODULE_2___default()(String(_this3.effective_dates_to)).format('yyyy-MM-DD');
          }
        });

        if (this.selectedData) {
          this.effective_dates_to = '';
          this.$notify.error({
            title: 'มีข้อผิดพลาด',
            message: 'วันที่ใช้งานและวันที่สิ้นสุด ระดับ Header ต้องอยู่ในช่วงของวันที่เริ่มต้นใช้งานและวันที่สิ้นสุดใช้งาน ระดับ Line'
          });
        }
      }
    },
    checkForm: function checkForm(e) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee() {
        var form, inputs;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                console.log('checkForm');
                form = $('#submitForm');
                inputs = form.serialize();
                _this4.errors = [];

                if (!_this4.nameHeader) {
                  _this4.errors.push('ชื่อรายการราคาสินค้า');

                  swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: _this4.errors,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                  });
                }

                if (!_this4.lines.length) {
                  _this4.errors.push('ผลิตภัณฑ์, ราคาต่อหน่วย, วันที่เริ่มต้นใช้งาน');

                  console.log('check validate line <---> ' + _this4.lines.length);
                  swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: _this4.errors,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                  });
                }

                if (_this4.lines.length > 0) {
                  _this4.lines.forEach(function (line) {
                    if (!line.item_id) {
                      _this4.errors.push('ผลิตภัณฑ์');

                      swal({
                        title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                        text: _this4.errors,
                        timer: 3000,
                        type: "error",
                        showCancelButton: false,
                        showConfirmButton: false
                      });
                    }

                    if (!line.price) {
                      _this4.errors.push('ราคาต่อหน่วย');

                      swal({
                        title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                        text: _this4.errors,
                        timer: 3000,
                        type: "error",
                        showCancelButton: false,
                        showConfirmButton: false
                      });
                    }

                    if (!line.start_date) {
                      _this4.errors.push('วันที่เริ่มต้นใช้งาน');

                      swal({
                        title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                        text: _this4.errors,
                        timer: 3000,
                        type: "error",
                        showCancelButton: false,
                        showConfirmButton: false
                      });
                    }
                  });
                }

                if (!_this4.errors.length) {
                  console.log('form submit');
                  form.submit();
                }

                e.preventDefault();

              case 9:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    }
  }
});

/***/ }),

/***/ "./resources/js/components/om/PriceListExportComponent.vue":
/*!*****************************************************************!*\
  !*** ./resources/js/components/om/PriceListExportComponent.vue ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _PriceListExportComponent_vue_vue_type_template_id_2d3bf9d8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PriceListExportComponent.vue?vue&type=template&id=2d3bf9d8& */ "./resources/js/components/om/PriceListExportComponent.vue?vue&type=template&id=2d3bf9d8&");
/* harmony import */ var _PriceListExportComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PriceListExportComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/om/PriceListExportComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _PriceListExportComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _PriceListExportComponent_vue_vue_type_template_id_2d3bf9d8___WEBPACK_IMPORTED_MODULE_0__.render,
  _PriceListExportComponent_vue_vue_type_template_id_2d3bf9d8___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/om/PriceListExportComponent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/om/PriceListExportComponent.vue?vue&type=script&lang=js&":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/om/PriceListExportComponent.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => __WEBPACK_DEFAULT_EXPORT__
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PriceListExportComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PriceListExportComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/PriceListExportComponent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PriceListExportComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/om/PriceListExportComponent.vue?vue&type=template&id=2d3bf9d8&":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/om/PriceListExportComponent.vue?vue&type=template&id=2d3bf9d8& ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PriceListExportComponent_vue_vue_type_template_id_2d3bf9d8___WEBPACK_IMPORTED_MODULE_0__.render,
/* harmony export */   "staticRenderFns": () => /* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PriceListExportComponent_vue_vue_type_template_id_2d3bf9d8___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_PriceListExportComponent_vue_vue_type_template_id_2d3bf9d8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PriceListExportComponent.vue?vue&type=template&id=2d3bf9d8& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/PriceListExportComponent.vue?vue&type=template&id=2d3bf9d8&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/PriceListExportComponent.vue?vue&type=template&id=2d3bf9d8&":
/*!***************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/om/PriceListExportComponent.vue?vue&type=template&id=2d3bf9d8& ***!
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
      attrs: { id: "submitForm", action: _vm.urlSave, method: "post" },
      on: {
        submit: function($event) {
          $event.preventDefault()
          return _vm.checkForm($event)
        }
      }
    },
    [
      _c("input", {
        attrs: { type: "hidden", name: "_token" },
        domProps: { value: _vm.csrf }
      }),
      _vm._v(" "),
      this.defaultValue
        ? _c("div", [
            _c("input", {
              attrs: { type: "hidden", name: "_method", value: "PUT" }
            })
          ])
        : _vm._e(),
      _vm._v(" "),
      _c("div", [
        _c("div", { staticClass: "row" }, [
          _c("div", { staticClass: "col-md-4" }, [
            _c(
              "dl",
              { staticClass: "dl-horizontal form-inline" },
              [
                _vm._m(0),
                _vm._v(" "),
                _c("el-input", {
                  attrs: { name: "nameHeader" },
                  model: {
                    value: _vm.nameHeader,
                    callback: function($$v) {
                      _vm.nameHeader = $$v
                    },
                    expression: "nameHeader"
                  }
                })
              ],
              1
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-4" }, [
            _c(
              "dl",
              { staticClass: "dl-horizontal form-inline" },
              [
                _c("dt", [_vm._v("\n              รายละเอียด\n          ")]),
                _vm._v(" "),
                _c("el-input", {
                  attrs: { name: "description" },
                  model: {
                    value: _vm.description,
                    callback: function($$v) {
                      _vm.description = $$v
                    },
                    expression: "description"
                  }
                })
              ],
              1
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-4" }, [
            _c(
              "dl",
              { staticClass: "dl-horizontal form-inline" },
              [
                _c("dt", [_vm._v("\n            สกุลเงิน \n          ")]),
                _vm._v(" "),
                _c("input", {
                  attrs: {
                    type: "hidden",
                    name: "currency_code",
                    autocomplete: "off"
                  },
                  domProps: { value: _vm.currency_code }
                }),
                _vm._v(" "),
                _c(
                  "el-select",
                  {
                    staticClass: "w-100",
                    attrs: {
                      filterable: "",
                      remote: "",
                      "reserve-keyword": ""
                    },
                    model: {
                      value: _vm.currency_code,
                      callback: function($$v) {
                        _vm.currency_code = $$v
                      },
                      expression: "currency_code"
                    }
                  },
                  _vm._l(_vm.currencies, function(currency) {
                    return _c("el-option", {
                      key: currency.currency_code,
                      attrs: {
                        label: currency.currency_code + " : " + currency.name,
                        value: currency.currency_code
                      }
                    })
                  }),
                  1
                )
              ],
              1
            )
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row" }, [
          _c("div", { staticClass: "col-md-4" }, [
            _c(
              "dl",
              { staticClass: "dl-horizontal form-inline" },
              [
                _c("dt", [_vm._v("\n            วันที่ใช้งาน\n          ")]),
                _vm._v(" "),
                _c("el-date-picker", {
                  staticStyle: { width: "100%" },
                  attrs: {
                    type: "date",
                    placeholder: "วันที่เริ่มต้น",
                    name: "effective_dates_from",
                    format: "dd-MM-yyyy"
                  },
                  on: {
                    change: function($event) {
                      return _vm.validateHeaderDate()
                    }
                  },
                  model: {
                    value: _vm.effective_dates_from,
                    callback: function($$v) {
                      _vm.effective_dates_from = $$v
                    },
                    expression: "effective_dates_from"
                  }
                })
              ],
              1
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-4" }, [
            _c(
              "dl",
              { staticClass: "dl-horizontal form-inline" },
              [
                _c("dt", [
                  _vm._v("\n                วันที่สิ้นสุด\n            ")
                ]),
                _vm._v(" "),
                _c("el-date-picker", {
                  staticStyle: { width: "100%" },
                  attrs: {
                    type: "date",
                    placeholder: "วันที่สิ้นสุด",
                    name: "effective_dates_to",
                    format: "dd-MM-yyyy"
                  },
                  on: {
                    change: function($event) {
                      return _vm.validateHeaderDate()
                    }
                  },
                  model: {
                    value: _vm.effective_dates_to,
                    callback: function($$v) {
                      _vm.effective_dates_to = $$v
                    },
                    expression: "effective_dates_to"
                  }
                })
              ],
              1
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-4" }, [
            _c(
              "dl",
              { staticClass: "dl-horizontal form-inline" },
              [
                _c("dt", [
                  _vm._v("\n                หมายเหตุรายการ\n            ")
                ]),
                _vm._v(" "),
                _c("el-input", {
                  attrs: { name: "comments" },
                  model: {
                    value: _vm.comments,
                    callback: function($$v) {
                      _vm.comments = $$v
                    },
                    expression: "comments"
                  }
                })
              ],
              1
            )
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row" }, [
          _c("div", { staticClass: "col-md-4" }, [
            _c("dl", { staticClass: "dl-horizontal" }, [
              _c("dt", [_vm._v("\n                Active\n              ")]),
              _vm._v(" "),
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.active_flag,
                    expression: "active_flag"
                  }
                ],
                attrs: { type: "checkbox", name: "active_flag" },
                domProps: {
                  checked: Array.isArray(_vm.active_flag)
                    ? _vm._i(_vm.active_flag, null) > -1
                    : _vm.active_flag
                },
                on: {
                  change: function($event) {
                    var $$a = _vm.active_flag,
                      $$el = $event.target,
                      $$c = $$el.checked ? true : false
                    if (Array.isArray($$a)) {
                      var $$v = null,
                        $$i = _vm._i($$a, $$v)
                      if ($$el.checked) {
                        $$i < 0 && (_vm.active_flag = $$a.concat([$$v]))
                      } else {
                        $$i > -1 &&
                          (_vm.active_flag = $$a
                            .slice(0, $$i)
                            .concat($$a.slice($$i + 1)))
                      }
                    } else {
                      _vm.active_flag = $$c
                    }
                  }
                }
              })
            ])
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "text-right" }, [
          _c(
            "button",
            {
              staticClass: "btn btn-sm btn-success",
              attrs: { type: "submit" },
              on: {
                click: function($event) {
                  $event.preventDefault()
                  return _vm.addLine($event)
                }
              }
            },
            [_c("i", { staticClass: "fa fa-plus" }), _vm._v(" เพิ่ม ")]
          )
        ]),
        _vm._v(" "),
        _c("table", { staticClass: "table table-responsive-sm" }, [
          _vm._m(1),
          _vm._v(" "),
          _c(
            "tbody",
            _vm._l(_vm.lines, function(row, index) {
              return _c("tr", [
                _c("td", [_vm._v(" " + _vm._s(index + 1) + " ")]),
                _vm._v(" "),
                _c(
                  "td",
                  [
                    _c("input", {
                      attrs: {
                        type: "hidden",
                        name: "listLine[" + row.id + "][status]",
                        autocomplete: "off"
                      },
                      domProps: { value: row.status }
                    }),
                    _vm._v(" "),
                    _c("input", {
                      attrs: {
                        type: "hidden",
                        name: "listLine[" + row.id + "][item_id]",
                        autocomplete: "off"
                      },
                      domProps: { value: row.item_id }
                    }),
                    _vm._v(" "),
                    row.disabledRow
                      ? [
                          _c("el-input", {
                            staticClass: "w-100",
                            attrs: {
                              type: "text",
                              value: row.item_desc,
                              autocomplete: "off",
                              disabled: ""
                            }
                          })
                        ]
                      : [
                          _c(
                            "el-select",
                            {
                              staticClass: "w-100",
                              attrs: {
                                filterable: "",
                                remote: "",
                                "reserve-keyword": "",
                                clearable: "",
                                disabled: row.disabledRow
                              },
                              on: {
                                change: function($event) {
                                  _vm.getUom(row, index)
                                  _vm.checkDateLine(row, index)
                                }
                              },
                              model: {
                                value: row.item_id,
                                callback: function($$v) {
                                  _vm.$set(row, "item_id", $$v)
                                },
                                expression: "row.item_id"
                              }
                            },
                            _vm._l(_vm.items, function(item) {
                              return _c("el-option", {
                                key: item.item_id,
                                attrs: {
                                  label:
                                    item.item_code +
                                    " : " +
                                    item.ecom_item_description,
                                  value: item.item_id
                                }
                              })
                            }),
                            1
                          )
                        ]
                  ],
                  2
                ),
                _vm._v(" "),
                _c(
                  "td",
                  [
                    _c("input", {
                      attrs: {
                        type: "hidden",
                        name: "listLine[" + row.id + "][uom_code]",
                        autocomplete: "off"
                      },
                      domProps: { value: row.uom_code }
                    }),
                    _vm._v(" "),
                    _c(
                      "el-select",
                      {
                        attrs: {
                          filterable: "",
                          remote: "",
                          "reserve-keyword": "",
                          clearable: "",
                          disabled: row.disabledRow
                        },
                        model: {
                          value: row.uom_code,
                          callback: function($$v) {
                            _vm.$set(row, "uom_code", $$v)
                          },
                          expression: "row.uom_code"
                        }
                      },
                      _vm._l(_vm.uoms, function(uom) {
                        return _c("el-option", {
                          key: uom.uom_code,
                          attrs: {
                            label: uom.uom_code + " : " + uom.description,
                            value: uom.uom_code
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
                    _c("el-input", {
                      attrs: { name: "listLine[" + row.id + "][price]" },
                      on: {
                        input: function($event) {
                          return _vm.onlyNumeric(row)
                        }
                      },
                      model: {
                        value: row.price,
                        callback: function($$v) {
                          _vm.$set(row, "price", $$v)
                        },
                        expression: "row.price"
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
                      staticStyle: { width: "100%" },
                      attrs: {
                        type: "date",
                        placeholder: "วันที่เริ่มต้น",
                        name: "listLine[" + row.id + "][start_date]",
                        format: "dd-MM-yyyy"
                      },
                      on: {
                        change: function($event) {
                          _vm.checkDateLine(row, index)
                          _vm.checkDateHeader(row, index)
                        }
                      },
                      model: {
                        value: row.start_date,
                        callback: function($$v) {
                          _vm.$set(row, "start_date", $$v)
                        },
                        expression: "row.start_date"
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
                      staticStyle: { width: "100%" },
                      attrs: {
                        type: "date",
                        placeholder: "วันที่สิ้นสุด",
                        name: "listLine[" + row.id + "][end_date]",
                        format: "dd-MM-yyyy"
                      },
                      on: {
                        change: function($event) {
                          _vm.checkDateLine(row, index)
                          _vm.checkDateHeader(row, index)
                        }
                      },
                      model: {
                        value: row.end_date,
                        callback: function($$v) {
                          _vm.$set(row, "end_date", $$v)
                        },
                        expression: "row.end_date"
                      }
                    })
                  ],
                  1
                ),
                _vm._v(" "),
                _c("td", [
                  !row.disabledRow
                    ? _c("div", [
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
                          [_vm._v("\n                X\n              ")]
                        )
                      ])
                    : _vm._e()
                ])
              ])
            }),
            0
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "row" }, [
          _c("div", { staticClass: "col-12 text-right" }, [
            _c(
              "button",
              {
                class: _vm.btnTrans.save.class + " btn-sm",
                attrs: { type: "submit" }
              },
              [
                _c("i", { class: _vm.btnTrans.save.icon }),
                _vm._v(
                  "\n            " +
                    _vm._s(_vm.btnTrans.save.text) +
                    " \n          "
                )
              ]
            ),
            _vm._v(" "),
            _c(
              "a",
              {
                class: _vm.btnTrans.cancel.class + " btn-sm",
                attrs: { href: this.urlReset, type: "button" }
              },
              [
                _c("i", { class: _vm.btnTrans.cancel.icon }),
                _vm._v(
                  " \n            " +
                    _vm._s(_vm.btnTrans.cancel.text) +
                    " \n          "
                )
              ]
            )
          ])
        ])
      ])
    ]
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("dt", [
      _vm._v("\n              ชื่อรายการราคาสินค้า"),
      _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", [
        _c("th", { attrs: { width: "1%" } }, [_vm._v(" # ")]),
        _vm._v(" "),
        _c("th", [_vm._v(" ผลิตภัณฑ์ ")]),
        _vm._v(" "),
        _c("th", { attrs: { width: "20%" } }, [_vm._v(" หน่วย ")]),
        _vm._v(" "),
        _c("th", { attrs: { width: "15%" } }, [
          _vm._v("ราคาต่อหน่วย"),
          _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
        ]),
        _vm._v(" "),
        _c("th", { attrs: { width: "15%" } }, [
          _vm._v("วันที่เริ่มต้นใช้งาน"),
          _c("span", { staticClass: "text-danger" }, [_vm._v("*")])
        ]),
        _vm._v(" "),
        _c("th", { attrs: { width: "15%" } }, [_vm._v("วันที่สิ้นสุดใช้งาน")]),
        _vm._v(" "),
        _c("th")
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);