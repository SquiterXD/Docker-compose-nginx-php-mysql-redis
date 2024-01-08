<template>
  <div>
      <div class="row">
      <div class="col-md-4">
        <dl class="dl-horizontal form-inline">
          <dt>
              ชื่อรายการราคาสินค้า
          </dt>
          <el-input name="nameHeader" v-model="nameHeader"> </el-input>
        </dl>
      </div>
      <div class="col-md-4">
        <dl class="dl-horizontal form-inline">
          <dt>
              รายละเอียด
          </dt>
          <el-input name="description" v-model="description"> </el-input>
        </dl>
      </div>
      <div class="col-md-4">
        <dl class="dl-horizontal form-inline">
          <dt>
            สกุลเงิน 
          </dt>
          <!-- <el-input name="currency" v-model="currency" size="medium"> </el-input> -->
          <input type="hidden" name="currency_code"  :value="currency_code" autocomplete="off">
          <el-select  v-model="currency_code"
                        filterable
                        remote
                        reserve-keyword class="w-100">              
              <el-option  v-for="currency in currencies"
                          :key="currency.currency_code"
                          :label="currency.currency_code + ' : ' + currency.name"
                          :value="currency.currency_code">
              </el-option>
          </el-select>
        </dl>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <dl class="dl-horizontal form-inline">
          <dt>
            วันที่ใช้งาน
          </dt>
          <el-date-picker 
            v-model="effective_dates_from"
            style="width: 100%;"
            type="date"
            placeholder="วันที่เริ่มต้น"
            name="effective_dates_from"
            format="dd-MM-yyyy"
            @change="validateHeaderDate()"
            >
          </el-date-picker>  
        </dl>
      </div>
      <div class="col-md-4">
        <dl class="dl-horizontal form-inline">
            <dt>
                วันที่สิ้นสุด
            </dt>
              <el-date-picker 
              v-model="effective_dates_to"
              style="width: 100%;"
              type="date"
              placeholder="วันที่เริ่มต้น"
              name="effective_dates_to"
              format="dd-MM-yyyy"
              @change="validateHeaderDate()"
              >
            </el-date-picker> 
        </dl>
      </div>
      <div class="col-md-4">
        <dl class="dl-horizontal form-inline">
            <dt>
                หมายเหตุรายการ
            </dt>
            <el-input name="comments" v-model="comments"> </el-input>
        </dl>
      </div>
    </div>
    <div class="row"> 
      <div class="col-md-4">
          <dl class="dl-horizontal">
              <dt>
                Active
              </dt>
              <input type="checkbox" name="active_flag" v-model="active_flag" >
          </dl>
      </div>
    </div>

<!-- -------------------------------------------------------------------------------------------------------------------------------------- -->

      <div class="text-right">
        <button class="btn btn-sm btn-success" type="submit" @click.prevent="addLine"> <i class="fa fa-plus"></i> เพิ่ม </button>
      </div>
      <table class="table table-responsive-sm">
        <thead>
            <tr>
                <th width="1%"> # </th>
                <th> ผลิตภัณฑ์ </th>
                <th width="20%"> หน่วย </th>
                <th width="15%">ราคาต่อหน่วย</th>
                <th width="15%">วันที่เริ่มต้นใช้งาน</th>
                <th width="15%">วันที่สิ้นสุดใช้งาน</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
          <tr v-for="(row, index) in lines">
            <td> {{ index + 1 }} </td>
            <td>
              <input type="hidden" :name="`item_id[${row.id}]`"  :value="row.item_id" autocomplete="off">
              <el-select  v-model="row.item_id"
                            filterable
                            remote
                            reserve-keyword
                            clearable
                            :disabled="row.disabledRow"
                            @change="getUom(row, index); checkDateLine(row, index);"
                            class="w-100"
                           >    
                           <!-- @change="getUom(row, index); checkDateLine(row, index);"           -->
                    <el-option  v-for="item in items"
                                :key="item.item_id"
                                :label="item.item_code + ' : ' + item.item_description"
                                :value="item.item_id">
                    </el-option>
              </el-select>
            </td>
            <td>
                <input type="hidden" :name="`uom_code[${row.id}]`" :value="row.uom_code" autocomplete="off">
                <el-select  v-model="row.uom_code"
                              filterable
                              remote
                              reserve-keyword
                              clearable
                              :disabled="row.disabledRow"
                              >              
                      <el-option  v-for="uom in uoms"
                                  :key="uom.uom_code"
                                  :label="uom.uom_code + ' : ' + uom.description"
                                  :value="uom.uom_code">
                      </el-option>
                </el-select>
            </td>
            <td>
              <el-input :name="`price[${row.id}]`" v-model="row.price" @input="onlyNumeric(row)"> </el-input>
            </td>
            <td>
               <el-date-picker 
                v-model="row.start_date"
                style="width: 100%;"
                type="date"
                placeholder="วันที่เริ่มต้น"
                :name="`start_date[${row.id}]`"
                format="dd-MM-yyyy"
                @change="checkDateLine(row, index);  checkDateHeader(row, index);"
                >
              </el-date-picker> 
            </td>
            <td>
               <el-date-picker 
                v-model="row.end_date"
                style="width: 100%;"
                type="date"
                placeholder="วันที่สิ้นสุด"
                :name="`end_date[${row.id}]`"
                format="dd-MM-yyyy"
                @change="checkDateLine(row, index);  checkDateHeader(row, index);"
                >
              </el-date-picker> 
            </td>
            <td>
              <div v-if="!row.disabledRow">
                <button @click.prevent="removeRow(index)" class="btn btn-sm btn-danger">
                  X
                </button>
              </div>
            </td>
          </tr>
        </tbody>
    </table>
  </div>
</template>

<script>
import uuidv1 from 'uuid/v1';
import moment from 'moment';

export default {
  props: ['currencies', 'items', 'uoms', 'defaultValue', 'old'],
  data() {
    return {
      nameHeader             : this.old.name                 ? this.old.name                 : this.defaultValue ? this.defaultValue.name                 : '',
      description            : this.old.description          ? this.old.description          : this.defaultValue ? this.defaultValue.description          : '',
      currency_code          : this.old.currency             ? this.old.currency             : this.defaultValue ? this.defaultValue.currency             : '',
      effective_dates_from   : this.old.effective_dates_from ? this.old.effective_dates_from : this.defaultValue ? this.defaultValue.effective_dates_from : '',
      effective_dates_to     : this.old.effective_dates_to   ? this.old.effective_dates_to   : this.defaultValue ? this.defaultValue.effective_dates_to   : '',
      comments               : this.old.comments             ? this.old.comments             : this.defaultValue ? this.defaultValue.comments             : '',
      active_flag            : true,
      lines                  : [],
      disabledData           : this.defaultValue ?  this.defaultValue.name ? true : false : false,
    };
  }, 
  mounted() {
    if (this.defaultValue) {
      if (this.defaultValue.list_lines) {
        this.defaultValue.list_lines.forEach(list_line => {
          this.lines.push({
            id         : list_line.list_line_id,
            lineId     : '',
            item_id    : list_line.product_value,
            uom_code   : list_line.uom,
            price      : list_line.value,
            start_date : list_line.start_date,
            end_date   : list_line.end_date,
            disabledRow : true,
          });
        });
          
      }else {
        this.addLine();
      }
    } else {
        this.addLine();
      }
  },

  methods:{
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

    addLine() {
      console.log('xxxxx');
        var today = new Date();
        var time = moment(today).format('DDMMyyyy') + String(today.getHours()) + String(today.getMinutes()) +  String(today.getSeconds());

        this.lines.push({
          id         : time,
          lineId     : '',
          item_id    : '',
          uom_code   : '',
          price      : '',
          start_date : '',
          end_date   : '',
          disabledRow : false,
        });
    },
    removeRow: function (index) {
          this.lines.splice(index, 1);
    },
    checkDateHeader(row, index){
      // console.log('checkDateHeader');
      if (this.effective_dates_from) {
        if (row.start_date) {
          // console.log('moment start date ---->  ' + moment(String(row.start_date)).format('Y-M-D'));
          // // console.log('start date ---->  ' + row.start_date);
          // console.log('moment header date ---->  ' + moment(String(this.effective_dates_from)).format('Y-M-D'));
          // // console.log('header date ---->  ' + this.effective_dates_from);
          // console.log('test ---> ' + moment(String(row.start_date)).format('Y-M-D') < moment(String(this.effective_dates_from)).format('Y-M-D'));
          // // console.log('test 2 ---> ' + row.start_date < this.effective_dates_from);
          // console.log('moment start date ---->  ' + moment(String(row.start_date)).format('yyyy-MM-DD'));
          // console.log('moment header date ---->  ' + moment(String(this.effective_dates_from)).format('yyyy-MM-DD'));
          // console.log(moment(String(row.start_date)).format('yyyy-MM-DD') < moment(String(this.effective_dates_from)).format('yyyy-MM-DD'));
          if (moment(String(row.start_date)).format('yyyy-MM-DD') < moment(String(this.effective_dates_from)).format('yyyy-MM-DD')) {
            // console.log('if');
            this.$notify.error({
                title: 'มีข้อผิดพลาด',
                message: 'วันที่เริ่มต้นใช้งานและวันที่สิ้นสุดใช้งาน ระดับ Line ต้องอยู่ในช่วงของวันที่ใช้งานและวันที่สิ้นสุด ระดับ Header',
          });
            row.start_date = '';
          } 
          // else {
          //   console.log('else');
          // }
        }
        
      }
      if (this.effective_dates_to) {
        if (row.start_date) {
          if (moment(String(row.start_date)).format('yyyy-MM-DD') > moment(String(this.effective_dates_to)).format('yyyy-MM-DD')) {
            this.$notify.error({
                title: 'มีข้อผิดพลาด',
                message: 'วันที่เริ่มต้นใช้งานและวันที่สิ้นสุดใช้งาน ระดับ Line ต้องอยู่ในช่วงของวันที่ใช้งานและวันที่สิ้นสุด ระดับ Header',
            });
            row.start_date = '';
          }
        }
        if (row.end_date) {
          if (moment(String(row.end_date)).format('yyyy-MM-DD') > moment(String(this.effective_dates_to)).format('yyyy-MM-DD')) {
            this.$notify.error({
                title: 'มีข้อผิดพลาด',
                message: 'วันที่เริ่มต้นใช้งานและวันที่สิ้นสุดใช้งาน ระดับ Line ต้องอยู่ในช่วงของวันที่ใช้งานและวันที่สิ้นสุด ระดับ Header',
            });
            row.end_date = '';
          }  
        }
      }
    },
    checkDateLine(row, index){

      if (!row.item_id) {
        row.price       = '';
        row.start_date  = '';
        row.end_date    = '';
      }

      if (index > 0) {
        var idx = this.lines.find(item => {
          if (item.id != row.id) {
            
          
            if (row.item_id == item.item_id) {
              if (item.end_date) {
                  // console.log(moment(String(row.start_date)).format('Y-M-d'));
                  // console.log(moment(String(item.end_date)).format('DD-MM-yyyy'));
                // if (row.start_date == '') {
                //     row.start_date = '02-02-2000';
                // } 
                if (row.start_date) {
                  console.log('has start date');
                  if (moment(String(row.start_date)).format('yyyy-MM-DD') <= moment(String(item.end_date)).format('yyyy-MM-DD')) {
                    // console.log(moment(String(row.start_date)).format('Y-M-d'));
                    // console.log(moment(String(item.end_date)).format('Y-M-d'));
                    
                    this.$notify.error({
                          title: 'มีข้อผิดพลาด',
                          message: 'ไม่สามารถเลือกช่วงเวลาซ้ำกันภายใต้ Item เดียวกันได้',
                    });

                    row.start_date = '';
                    row.end_date = '';
                  }
                }
                if (row.end_date) {
                  console.log('has end date');
                  if (row.end_date <= item.end_date) {
                    this.$notify.error({
                          title: 'มีข้อผิดพลาด',
                          message: 'ไม่สามารถเลือกช่วงเวลาซ้ำกันภายใต้ Item เดียวกันได้',
                    });
                    
                    row.start_date = '';
                    row.end_date = '';
                  }
                }

                if (row.start_date && row.end_date) {
                  console.log('has both');
                
                // console.log(row.start_date);
                  if (row.end_date < row.start_date) {
                    // console.log(moment(String(row.start_date)).format('Y-M-d'));
                    // console.log(moment(String(item.end_date)).format('Y-M-d'));
                    this.$notify.error({
                          title: 'มีข้อผิดพลาด',
                          message: 'วันที่สิ้นสุด ต้องไม่น้อยกว่าวันที่เริ่มต้น',
                    });
                    
                    row.start_date = '';
                    row.end_date = '';
                  }
                }
                
              } 
              else {
                this.$notify.error({
                        title: 'มีข้อผิดพลาด',
                        message: 'ไม่สามารถเลือกช่วงเวลาซ้ำกันภายใต้ Item เดียวกันได้',
                  });

                  row.item_id = '';
                  row.uom_code = '';
                  row.price   = '';
                  row.start_date = '';
                  row.end_date = '';
              }
            }
          }
        });
      } else {
        // console.log('ทำไมมมมมมมมมมมมมม');
        if (row.end_date) {
          if (row.end_date < row.start_date) {
                    this.$notify.error({
                          title: 'มีข้อผิดพลาด',
                          message: 'วันที่สิ้นสุด ต้องไม่น้อยกว่าวันที่เริ่มต้น',
                    });
                    row.end_date = '';
          }
        }
      }

      // if (this.effective_dates_from) {
      //   if (row.start_date) {
      //     if (row.start_date < this.effective_dates_from) {
      //       this.$notify.error({
      //           title: 'มีข้อผิดพลาด',
      //           message: 'วันที่เริ่มต้นใช้งาน ต้องอยู่ในช่วงของ วันที่ใช้งานและวันที่สิ้นสุด',
      //     });
      //       row.start_date = '';
      //     }
      //   }
        
      // }
      // if (this.effective_dates_to) {
      //   if (row.start_date) {
      //     if (row.start_date > this.effective_dates_to) {
      //       this.$notify.error({
      //           title: 'มีข้อผิดพลาด',
      //           message: 'วันที่เริ่มต้นใช้งาน ต้องอยู่ในช่วงของ วันที่ใช้งานและวันที่สิ้นสุด',
      //       });
      //       row.start_date = '';
      //     }
      //   }
      // }

    // if (!row.uom_code) {
      // this.getUom(row, index);
    // }

    },
    getUom (row, index) {
      // console.log('get uom --> ' . row.item_id);
      if (row.item_id) {
        
      
        this.selectedData = this.items.find( i => {
          if (i.item_id == row.item_id) {
            row.uom_code = i.uom;
          }
        });
      } else {
        row.uom_code = '';
      }

    },
    checkStartDate (row) {
      if (row.start_date == '') {
        this.$notify.error({
            title: 'มีข้อผิดพลาด',
            message: 'โปรดเลือกวันที่เริ่มต้นใช้งาน',
        });
        row.end_date = '';
      }
    },
    onlyNumeric(row) {
        row.price = row.price.replace(/[^0-9 .]/g, '');
    },
    validateHeaderDate() {
      if (this.effective_dates_from) {
        // console.log('Header -----> ' + moment(String(this.effective_dates_from)).format('yyyy-MM-DD'));
        // this.selectedData = this.lines.forEach((line) => {
        //   // console.log('Line -----> ' + moment(String(line.start_date)).format('yyyy-MM-DD'));
        //   // console.log('Result  ----> ' + moment(String(line.start_date)).format('yyyy-MM-DD') < moment(String(this.effective_dates_from)).format('yyyy-MM-DD'));
        //   if (line.start_date) {
        //     if (moment(String(line.start_date)).format('yyyy-MM-DD') < moment(String(this.effective_dates_from)).format('yyyy-MM-DD')) {
        //       line.start_date = '';
        //       this.$notify.error({
        //           title: 'มีข้อผิดพลาด',
        //           message: 'วันที่เริ่มต้นใช้งาน ต้องอยู่ในช่วงของ วันที่ใช้งานและวันที่สิ้นสุด',
        //       });
        //     }
        //   }
        // });
        this.selectedData = this.lines.find( line => {
          if (line.start_date) {
            return moment(String(line.start_date)).format('yyyy-MM-DD') < moment(String(this.effective_dates_from)).format('yyyy-MM-DD') ;
          }
          if (line.end_date) {
            return moment(String(line.end_date)).format('yyyy-MM-DD') < moment(String(this.effective_dates_from)).format('yyyy-MM-DD');
          }
          
        });

        if (this.selectedData) {
          this.effective_dates_from = '';

          this.$notify.error({
              title: 'มีข้อผิดพลาด',
              message: 'วันที่ใช้งานและวันที่สิ้นสุด ระดับ Header ต้องอยู่ในช่วงของวันที่เริ่มต้นใช้งานและวันที่สิ้นสุดใช้งาน ระดับ Line',
          });
        }

      }
      if (this.effective_dates_to) {
        // this.selectedData = this.lines.forEach((line) => {
        //   // console.log('Line -----> ' + moment(String(line.start_date)).format('yyyy-MM-DD'));
        //   // console.log('Result  ----> ' + moment(String(line.start_date)).format('yyyy-MM-DD') < moment(String(this.effective_dates_from)).format('yyyy-MM-DD'));
        //   if (line.start_date) {  
        //     if (moment(String(line.start_date)).format('yyyy-MM-DD') > moment(String(this.effective_dates_to)).format('yyyy-MM-DD')) {
        //       line.start_date = '';
        //       // console.log(line.item_id + ' : ' + line.start_date);
        //       this.$notify.error({
        //           title: 'มีข้อผิดพลาด',
        //           message: 'วันที่เริ่มต้นใช้งาน ต้องอยู่ในช่วงของ วันที่ใช้งานและวันที่สิ้นสุด',
        //       });
        //     }
        //   }
        //   if (line.end_date) {
        //     if (moment(String(line.end_date)).format('yyyy-MM-DD') > moment(String(this.effective_dates_to)).format('yyyy-MM-DD')) {
        //       line.end_date = '';
        //       // console.log(line.item_id + ' : ' + line.start_date);
        //       this.$notify.error({
        //           title: 'มีข้อผิดพลาด',
        //           message: 'วันที่เริ่มต้นใช้งาน ต้องอยู่ในช่วงของ วันที่ใช้งานและวันที่สิ้นสุด',
        //       });
        //     }
        //   }
        // });
        console.log('hhhh');
        this.selectedData = this.lines.find( line => {
          if (line.start_date) {
            return moment(String(line.start_date)).format('yyyy-MM-DD') > moment(String(this.effective_dates_to)).format('yyyy-MM-DD');
          }
          if (line.end_date) {
            return moment(String(line.end_date)).format('yyyy-MM-DD') > moment(String(this.effective_dates_to)).format('yyyy-MM-DD');
          }
        });

        if (this.selectedData) {
          this.effective_dates_to = '';

          this.$notify.error({
              title: 'มีข้อผิดพลาด',
              message: 'วันที่ใช้งานและวันที่สิ้นสุด ระดับ Header ต้องอยู่ในช่วงของวันที่เริ่มต้นใช้งานและวันที่สิ้นสุดใช้งาน ระดับ Line',
          });
        }
      }
    },
  }
};
</script>