<template>
  <form id="submitForm" :action="urlSave" method="post" @submit.prevent="checkForm">
    <input type="hidden" name="_token" :value="csrf">
    <div v-if="this.defaultValue">
      <input type="hidden" name="_method" value="PUT">
    </div>
    <div>
      <div class="row">
        <div class="col-md-4">
          <dl class="dl-horizontal form-inline">
            <dt>
                ชื่อรายการราคาสินค้า <span class="text-danger">*</span>
            </dt>
            <el-input name="nameHeader" v-model="nameHeader" :disabled="nameHeader == 'ราคาขายปลีก'"> </el-input>
            <input type="hidden" name="nameHeader" :value="nameHeader">
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
            <!-- <date-om
                style="width: 100%;"
                class="form-control md:tw-mb-0 tw-mb-2"
                name="effective_dates_from"
                placeholder="โปรดเลือกวันที่"
                v-model="effective_dates_from"
                format="DD-MM-YYYY"
                @dateWasSelected="fromDateWasSelected"
                :disabled-date-from="disabledDateFrom"
                >
            </date-om> -->

            <ct-datepicker
                class="my-1 col-sm-12 form-control"
                name="effective_dates_from"
                onkeydown="return event.key != 'Enter';"
                style="width: 100%;"
                placeholder="โปรดเลือกวันที่เริ่มต้น"
                :enableDate="date => isInRange(date, null, toJSDate(effective_dates_to), true)"
                :value="toJSDate(effective_dates_from, 'yyyy-MM-dd')"
                @change="(date) => {
                    effective_dates_from = jsDateToString(date)
                    validateHeaderDate(); 
                    checkDate();
                }"
            />
            <input type="hidden" name="effective_dates_from" :value="effective_dates_from">

            <!-- <datepicker-th
                style="width: 100%;"
                class="form-control md:tw-mb-0 tw-mb-2"
                name="effective_dates_from"
                placeholder="โปรดเลือกวันที่"
                v-model="effective_dates_from"
                format="DD-MM-YYYY"
                @dateWasSelected="fromDateHeaderSelected(...arguments); validateHeaderDate(); checkDate();"
                >
            </datepicker-th> -->

            <!-- fromDateWasSelected(...arguments, row); checkDateLine(row, index);  checkDateHeader(row, index); -->

            <!-- <el-date-picker 
              v-model="effective_dates_from"
              style="width: 100%;"
              type="date"
              placeholder="วันที่เริ่มต้น"
              name="effective_dates_from"
              format="dd-MM-yyyy"
              @change="validateHeaderDate(); checkDate();"
              >
            </el-date-picker>   -->
          </dl>
        </div>
        <div class="col-md-4">
          <dl class="dl-horizontal form-inline">
              <dt>
                วันที่สิ้นสุด
              </dt>
              <!-- <date-om
                style="width: 100%;"
                class="form-control md:tw-mb-0 tw-mb-2"
                name="effective_dates_to"
                placeholder="โปรดเลือกวันที่"
                v-model="effective_dates_to"
                format="DD-MM-YYYY"
                @dateWasSelected="toDateWasSelected"
                :disabled-date-to="disabledDateTo"
                >
              </date-om> -->

              <ct-datepicker
                  class="my-1 col-sm-12 form-control"
                  onkeydown="return event.key != 'Enter';"
                  style="width: 100%;"
                  placeholder="โปรดเลือกวันที่เริ่มต้น"
                  :enableDate="date => isInRange(date, toJSDate(effective_dates_from), null, true)"
                  :value="toJSDate(effective_dates_to, 'yyyy-MM-dd')"
                  @change="(date) => {
                      effective_dates_to = jsDateToString(date)
                      validateHeaderDate(); 
                      checkDate();
                  }"
              />
              <input type="hidden" name="effective_dates_to" :value="effective_dates_to">

              <!-- <datepicker-th
                  style="width: 100%;"
                  class="form-control md:tw-mb-0 tw-mb-2"
                  name="effective_dates_to"
                  placeholder="โปรดเลือกวันที่"
                  v-model="effective_dates_to"
                  format="DD-MM-YYYY"
                  :disabled-date-to="headerDisabledDateTo"
                  @dateWasSelected='endDateHeaderSelected(...arguments); validateHeaderDate(); checkDate();'
                  >
              </datepicker-th> -->



              <!-- <el-date-picker 
                v-model="effective_dates_to"
                style="width: 100%;"
                type="date"
                placeholder="วันที่เริ่มต้น"
                name="effective_dates_to"
                format="dd-MM-yyyy"
                @change="validateHeaderDate(); checkDate();"
                >
              </el-date-picker>  -->
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

  <!-- ---------------------------------------------------------Line----------------------------------------------------------------------------- -->

        <div class="text-right">
          <button class="btn btn-sm btn-success" type="submit" @click.prevent="addLine"> <i class="fa fa-plus"></i> เพิ่ม </button>
        </div>
        <table class="table table-responsive-sm">
          <thead>
              <tr>
                  <th width="1%"> # </th>
                  <th> ผลิตภัณฑ์ </th>
                  <th width="20%"> หน่วย </th>
                  <th width="15%">ราคาต่อหน่วย<span class="text-danger">*</span></th>
                  <th width="15%">วันที่เริ่มต้นใช้งาน<span class="text-danger">*</span></th>
                  <th width="15%">วันที่สิ้นสุดใช้งาน</th>
                  <th></th>
              </tr>
          </thead>
          <tbody>
            <tr v-for="(row, index) in lines">
              <td> {{ index + 1 }} </td>
              <td>
                <input type="hidden" :name="'listLine['+row.id+'][status]'"  :value="row.status" autocomplete="off">
                <input type="hidden" :name="'listLine['+row.id+'][item_id]'"  :value="row.item_id" autocomplete="off">
                <template v-if="row.disabledRow">
                  <el-input type="text" :value="row.item_desc" autocomplete="off" disabled class="w-100"></el-input>
                </template>
                <template v-else> 
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
                                    :label="item.item_code + ' : ' + item.ecom_item_description"
                                    :value="item.item_id">
                        </el-option>
                  </el-select>
                </template>
              </td>
              <td>
                  <input type="hidden" :name="'listLine['+row.id+'][uom_code]'"  :value="row.uom_code" autocomplete="off">
                  <!-- <input type="hidden" :name="`uom_code[${row.id}]`" :value="row.uom_code" autocomplete="off"> -->
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
                <el-input :name="'listLine['+row.id+'][price]'" v-model="row.price" @input="onlyNumeric(row)"></el-input>
                <!-- <el-input :name="`price[${row.id}]`" v-model="row.price" @input="onlyNumeric(row)"> </el-input> -->
                <!-- <vue-numeric 
                    separator="," 
                    v-bind:precision="5" 
                    v-bind:minus="false"
                    :id="`input_ingredient_folmula_qty_${index}`"
                    class="form-control input-sm text-right"
                    :name="'dataGroupAll['+row.oprn_id+']['+row.id+'][ingredient_folmula_qty]'"
                    v-model="row.ingredient_folmula_qty"
                    @input="setFocus(row, index)"
                    @change="getIngredientQty(row, index)"
                ></vue-numeric> -->
              </td>
              <td>
                <ct-datepicker
                  class="my-1 col-sm-12 form-control"
                  :name="'listLine['+row.id+'][start_date]'"
                  onkeydown="return event.key != 'Enter';"
                  style="width: 100%;"
                  placeholder="โปรดเลือกวันที่เริ่มต้น"
                  :enableDate="date => isInRange(date, null, toJSDate(row.end_date), true)"
                  :value="toJSDate(row.start_date, 'yyyy-MM-dd')"
                  @change="(date) => {
                      row.start_date = jsDateToString(date)
                      checkDateLine(row, index);  
                      checkDateHeader(row, index);
                  }"
              />
              <input type="hidden" :name="'listLine['+row.id+'][start_date]'" :value="row.start_date">
                <!-- <datepicker-th
                      style="width: 100%;"
                      class="form-control md:tw-mb-0 tw-mb-2"
                      :name="'listLine['+row.id+'][start_date]'"
                      placeholder="โปรดเลือกวันที่"
                      v-model="row.start_date"
                      format="DD-MM-YYYY"
                      @dateWasSelected='fromDateWasSelected(...arguments, row); checkDateLine(row, index);  checkDateHeader(row, index);'
                      >
                  </datepicker-th> -->



                <!-- <el-date-picker 
                  v-model="row.start_date"
                  style="width: 100%;"
                  type="date"
                  placeholder="วันที่เริ่มต้น"
                  :name="'listLine['+row.id+'][start_date]'"
                  format="dd-MM-yyyy"
                  @change="checkDateLine(row, index);  checkDateHeader(row, index);"
                  >
                </el-date-picker>  -->
              </td>
              <td>
                <ct-datepicker
                    class="my-1 col-sm-12 form-control"
                    onkeydown="return event.key != 'Enter';"
                    style="width: 100%;"
                    placeholder="โปรดเลือกวันที่เริ่มต้น"
                    :enableDate="date => isInRange(date, toJSDate(row.start_date), null, true)"
                    :value="toJSDate(row.end_date, 'yyyy-MM-dd')"
                    @change="(date) => {
                      row.end_date = jsDateToString(date)
                      checkDateLine(row, index);  
                      checkDateHeader(row, index);
                    }"
                />
                <input type="hidden" :name="'listLine['+row.id+'][end_date]'" :value="row.end_date">
                <!-- <datepicker-th
                    style="width: 100%;"
                    class="form-control md:tw-mb-0 tw-mb-2"
                    :name="'listLine['+row.id+'][end_date]'"
                    placeholder="โปรดเลือกวันที่"
                    v-model="row.end_date"
                    format="DD-MM-YYYY"
                    :disabled-date-to="row.disabledDateTo"
                    @dateWasSelected='endDateWasSelected(...arguments, row); checkDateHeader(row, index);'>
                </datepicker-th> -->




                <!-- <el-date-picker 
                  v-model="row.end_date"
                  style="width: 100%;"
                  type="date"
                  placeholder="วันที่สิ้นสุด"
                  :name="'listLine['+row.id+'][end_date]'"
                  format="dd-MM-yyyy"
                  @change="checkDateLine(row, index);  checkDateHeader(row, index);"
                  >
                </el-date-picker>  -->
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
      <div class="row">
        <div class="col-12 text-right">
            <!-- <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button>
            <a :href="this.urlReset" type="button" class="btn btn-sm btn-warning"> <i class="fa fa-times"></i> ยกเลิก </a> -->

            <button :class="btnTrans.save.class + ' btn-sm'" type="submit"> 
              <i :class="btnTrans.save.icon"></i>
              {{ btnTrans.save.text }} 
            </button>
            <a :href="this.urlReset" type="button" :class="btnTrans.cancel.class + ' btn-sm'"> 
              <i :class="btnTrans.cancel.icon"></i> 
              {{ btnTrans.cancel.text }} 
            </a>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
import uuidv1 from 'uuid/v1';
import moment from 'moment';
import {isInRange, jsDateToString, toJSDate, toThDateString} from '../../dateUtils'
import VueNumeric from 'vue-numeric';

export default {
  props: ['currencies', 'items', 'uoms', 'defaultValue', 'old', 'urlSave', 'urlReset', 'btnTrans', 'itemAlls'],
  data() {
    return {
      toJSDate,
      jsDateToString,
      isInRange,
      toThDateString,

      nameHeader             : this.old.nameHeader           ? this.old.nameHeader           : this.defaultValue ? this.defaultValue.name                 : '',
      description            : this.old.description          ? this.old.description          : this.defaultValue ? this.defaultValue.description          : '',
      currency_code          : this.old.currency_code        ? this.old.currency_code        : this.defaultValue ? this.defaultValue.currency             : '',
      effective_dates_from   : this.old.effective_dates_from ? this.old.effective_dates_from : this.defaultValue ? this.defaultValue.effective_dates_from : '',
      effective_dates_to     : this.old.effective_dates_to   ? this.old.effective_dates_to   : this.defaultValue ? this.defaultValue.effective_dates_to   : '',
      comments               : this.old.comments             ? this.old.comments             : this.defaultValue ? this.defaultValue.comments             : '',
      active_flag            : this.old.active_flag          ? true : this.defaultValue      ? this.defaultValue.active_flag == 'Y' ? true : '' : true,
      lines                  : [],
      disabledData           : this.defaultValue ?  this.defaultValue.name ? true : false : false,
      
      
      // สำหรับ เช็ค วันที่ Header
      headerDisabledDateTo   : this.effective_dates_from ? this.effective_dates_from : null,

      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    };
  }, 
  mounted() {
    if (this.defaultValue) {
      this.effective_dates_from = this.defaultValue.effective_dates_from ? moment(this.defaultValue.effective_dates_from).format("yyyy-MM-DD") : '';
      this.effective_dates_to   = this.defaultValue.effective_dates_to   ? moment(this.defaultValue.effective_dates_to).format("yyyy-MM-DD") : '';
    }

    // console.log('effective_dates_to <--->' + this.effective_dates_to);
    // this.showDate();

    // if (this.old) {
    //   if (this.old.listLine) {
    //     this.old.listLine.forEach(async (list_line) => {
    //       var parse_start_date = await helperDate.parseToDateTh(list_line.start_date, 'yyyy-MM-DD');
    //       var parse_end_date   = await helperDate.parseToDateTh(list_line.end_date, 'yyyy-MM-DD');

    //       this.lines.push({
    //         id             : list_line.list_line_id,
    //         lineId         : '',
    //         item_id        : list_line.product_value,
    //         uom_code       : list_line.uom,
    //         // price          : list_line.value,
    //         price          : list_line.value.replace(/\B(?=(\d{3})+(?!\d))/g, ","),
    //         // price          : parseFloat(list_line.value).toFixed(2),
    //         start_date     : list_line.start_date ? parse_start_date : '',
    //         end_date       : list_line.end_date ? parse_end_date : '',
    //         status         : 'new',
    //         disabledRow    : false,

    //         disabledDateTo : parse_start_date,
    //       });
    //     });
    //   }
    // }

    if (this.defaultValue) {
      if (this.defaultValue.list_lines) {
          this.addDefaultLines();
        // this.defaultValue.list_lines.forEach(list_line => {

        //   var parse_start_date = await helperDate.parseToDateTh(list_line.start_date, 'yyyy-MM-DD');
        //   var parse_end_date = await helperDate.parseToDateTh(list_line.end_date, 'yyyy-MM-DD');

        //   this.lines.push({
        //     id             : list_line.list_line_id,
        //     lineId         : '',
        //     item_id        : list_line.product_value,
        //     uom_code       : list_line.uom,
        //     price          : list_line.value,
        //     start_date     : parse_start_date,
        //     end_date       : parse_end_date,
        //     status         : 'update',
        //     disabledRow    : true,

        //     disabledDateTo : parse_start_date,
        //   });
        // });
          
      }else {
        this.addLine();
      }
    } else {
        this.addLine();
      }
  },

  methods:{
    async addDefaultLines() {
      this.defaultValue.list_lines.forEach(async (list_line) => {
          // var parse_start_date = await helperDate.parseToDateTh(list_line.start_date, 'yyyy-MM-dd');
          // var parse_end_date   = await helperDate.parseToDateTh(list_line.end_date, 'yyyy-MM-dd');

          var parse_start_date = moment(list_line.start_date).format("yyyy-MM-DD");
          var parse_end_date   = moment(String(list_line.end_date)).format('yyyy-MM-DD');

          var item_find = this.itemAlls.find( i => {
                      return i.item_id == list_line.product_value;
                    });
          var item_desc = item_find ? item_find.item_code + ' : ' + item_find.ecom_item_description : '';

          this.lines.push({
            id             : list_line.list_line_id,
            lineId         : '',
            item_id        : list_line.product_value,
            uom_code       : list_line.uom,
            // price          : list_line.value,
            price          : list_line.value.replace(/\B(?=(\d{3})+(?!\d))/g, ","),
            // price          : parseFloat(list_line.value).toFixed(2),
            start_date     : list_line.start_date ? parse_start_date : '',
            end_date       : list_line.end_date ? parse_end_date : '',
            // start_date     : list_line.start_date,
            // end_date       : list_line.end_date,
            status         : 'update',
            disabledRow    : true,

            // disabledDateTo : parse_start_date,
            disabledDateTo : list_line.start_date,
            item_desc      : item_desc,
          });
        });
    },
    async showDate() {
        if (this.effective_dates_from) {
            var date1 = await helperDate.parseToDateTh(this.effective_dates_from, 'yyyy-MM-dd');
            this.effective_dates_from = date1;
        }
        if (this.effective_dates_to) {
          
            console.log('showDate effective_dates_to <--->' + this.effective_dates_to);
            var date_to = await helperDate.parseToDateTh(this.effective_dates_to, 'yyyy-MM-dd');
            this.effective_dates_to = date_to;
            console.log('showDate date_to <--->' + date_to);
        }
    },

    fromDateWasSelected(date, row) {
      // change disabled_date_to of to_date = from_date

      // console.log('fromDateWasSelected date <-->' + date);
      // console.log('fromDateWasSelected row <-->' + row.start_date);
      if (date) {
        row.disabledDateTo = moment(date).format("DD/MM/YYYY");

        row.start_date = date;
      }
      
    },
    endDateWasSelected(date, row) {
      // change disabled_date_to of to_date = from_date
      row.end_date = date;
    },

    fromDateHeaderSelected(date, row) {
      // change disabled_date_to of to_date = from_date
      this.effective_dates_from = moment(date).format("DD/MM/YYYY");
      this.headerDisabledDateTo = moment(date).format("DD/MM/YYYY");

    },
    endDateHeaderSelected(date, row) {
      // change disabled_date_to of to_date = from_date
      this.effective_dates_to = moment(date).format("DD/MM/YYYY");
    },

    addLine() {
        this.lines.push({
          id             : uuidv1(),
          lineId         : '',
          item_id        : '',
          uom_code       : '',
          price          : '',
          start_date     : '',
          end_date       : '',
          status         : 'new',
          disabledRow    : false,
          disabledDateTo : '',
          item_desc      : '',
        });
    },
    removeRow: function (index) {
          this.lines.splice(index, 1);
    },
    async checkDateHeader(row, index){
      
      // console.log('checkDateHeader');
      if (this.effective_dates_from) {
        if (row.start_date) {

          axios.get("/om/ajax/get-check-header", {
                params: {
                    effective_dates_from: this.effective_dates_from,
                    row_start_date:       row.start_date,
                }
          })
          .then(res => {
            console.log('data -----> ' + res.data);
            if (res.data) {
              this.$notify.error({
                  title: 'มีข้อผิดพลาด',
                  message: 'วันที่เริ่มต้นใช้งานและวันที่สิ้นสุดใช้งาน ระดับ Line ต้องอยู่ในช่วงของวันที่ใช้งานและวันที่สิ้นสุด ระดับ Header',
              });

              row.start_date = '';
            } 
              
          })
          .catch(err => {
              console.log(err)
          });
          // var date1 = parseFromDateTh(this.effective_dates_from);

          // console.log('checkDateHeader --->' + date1);
          // console.log('checkDateHeader xxxx --->' + String(date1));

          // console.log('checkDateHeader === effective_dates_fromxx --->'+ moment(String(this.effective_dates_from)).format('yyyy-MM-DD'));
          // console.log('checkDateHeader === effective_dates_from --->'+ this.effective_dates_from);
          // console.log('checkDateHeader === start_date -->'+ moment(String(row.start_date)).format('yyyy-MM-DD'));
          // console.log('effective_dates_from --->>>' + this.effective_dates_from);
          // console.log('start_date --->>>' + moment(String(row.start_date)).format('DD/MM/YYYY'));

            // if (moment(String(row.start_date)).format('yyyy-MM-DD') < moment(String(this.effective_dates_from)).format('yyyy-MM-DD')) {

            //     this.$notify.error({
            //         title: 'มีข้อผิดพลาด',
            //         message: 'วันที่เริ่มต้นใช้งานและวันที่สิ้นสุดใช้งาน ระดับ Line ต้องอยู่ในช่วงของวันที่ใช้งานและวันที่สิ้นสุด ระดับ Header',
            //     });

            // // row.start_date = '';

            // } 
        }
        
      }
      if (this.effective_dates_to) {
        
         axios.get("/om/ajax/get-check-header-date-to", {
                params: {
                    effective_dates_to:   this.effective_dates_to,
                    row_start_date:       row.start_date,
                    row_end_date:         row.end_date,
                }
          })
          .then(res => {
            console.log('data -----> ' + res.data);
            if (res.data) {
              this.$notify.error({
                  title: 'มีข้อผิดพลาด',
                  message: 'วันที่เริ่มต้นใช้งานและวันที่สิ้นสุดใช้งาน ระดับ Line ต้องอยู่ในช่วงของวันที่ใช้งานและวันที่สิ้นสุด ระดับ Header',
              });

              row.start_date = '';
              row.end_date   = '';
            } 
              
          })
          .catch(err => {
              console.log(err)
          });

        // if (row.start_date) {
        //   if (moment(String(row.start_date)).format('yyyy-MM-DD') > moment(String(this.effective_dates_to)).format('yyyy-MM-DD')) {
        //     this.$notify.error({
        //         title: 'มีข้อผิดพลาด',
        //         message: 'วันที่เริ่มต้นใช้งานและวันที่สิ้นสุดใช้งาน ระดับ Line ต้องอยู่ในช่วงของวันที่ใช้งานและวันที่สิ้นสุด ระดับ Header',
        //     });
        //     row.start_date = '';
        //   }
        // }
        // if (row.end_date) {
        //   if (moment(String(row.end_date)).format('yyyy-MM-DD') > moment(String(this.effective_dates_to)).format('yyyy-MM-DD')) {
        //     this.$notify.error({
        //         title: 'มีข้อผิดพลาด',
        //         message: 'วันที่เริ่มต้นใช้งานและวันที่สิ้นสุดใช้งาน ระดับ Line ต้องอยู่ในช่วงของวันที่ใช้งานและวันที่สิ้นสุด ระดับ Header',
        //     });
        //     row.end_date = '';
        //   }  
        // }
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
                if (row.start_date) {
                    console.log('has start date');
                    if (moment(String(row.start_date)).format('yyyy-MM-DD') <= moment(String(item.end_date)).format('yyyy-MM-DD')) {
                        // console.log(moment(String(row.start_date)).format('Y-M-d'));
                        // console.log(moment(String(item.end_date)).format('Y-M-d'));
                        
                        
                        row.start_date = '';
                        row.end_date = '';
                        // row.disabledDateTo = '';

                        // row.item_id  = '';
                        // row.uom_code = '';
                        // row.price    = '';
                        
                        // row.disabledDateTo = '';
                        // this.fromDateWasSelected(null, row);

                        this.$notify.error({
                            title: 'มีข้อผิดพลาด',
                            message: 'ไม่สามารถเลือกช่วงเวลาซ้ำกันภายใต้ Item เดียวกันได้',
                        });

                        // this.removeRow(index);
                    }
                    // row.start_date = '';
                    // row.end_date = '';
                    // row.disabledDateTo = '';
                    // this.fromDateWasSelected(null, row);
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
                        // row.disabledDateTo = '';
                        // this.fromDateWasSelected(null, row);
                    }
                }

                if (row.start_date && row.end_date) {
                    console.log('has both');
                    if (row.end_date < row.start_date) {
                        // console.log(moment(String(row.start_date)).format('Y-M-d'));
                        // console.log(moment(String(item.end_date)).format('Y-M-d'));
                        this.$notify.error({
                            title: 'มีข้อผิดพลาด',
                            message: 'วันที่สิ้นสุด ต้องไม่น้อยกว่าวันที่เริ่มต้น',
                        });
                        
                        row.start_date = '';
                        row.end_date = '';
                        // row.disabledDateTo = '';
                        // this.fromDateWasSelected(null, row);
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

                // row.disabledDateTo = '';
                // this.fromDateWasSelected(null, row);
              }
            }
          }
        });
      } else {
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

    },
    getUom (row, index) {
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
      if (row.price) {
        row.price = row.price.replace(/[^0-9 .]/g, '');
        row.price = row.price.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        // row.price = parseFloat(row.price).toFixed(2);
        // row.price = parseFloat(row.price).toLocaleString(undefined, { minimumFractionDigits: 2 });
        // row.price = parseFloat(row.price).toLocaleString(undefined, { minimumFractionDigits: 2 });
        // console.log('xxxx <--->' + row.price.toLocaleString());
        // console.log('cccc ---> ' + row.price.toLocaleString());
        // console.log('zzzz ---> ' + row.price.toLocaleString(undefined, { minimumFractionDigits: 2 }));
        // console.log('rrr ---> ' + parseFloat(row.price).toLocaleString(undefined, { minimumFractionDigits: 2 }));
        // console.log('max ---> ' + parseFloat(row.price).toLocaleString(undefined, { maxmumFractionDigits: 2 }));
       
        // console.log('xxxx <--->' + row.price.toLocaleString(row.price, { maxmumFractionDigits: 2 })); 
      }
        
    },
    validateHeaderDate() {
      if (this.effective_dates_from) {
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
    checkDate(){
      if (this.effective_dates_from) {
        if (moment(String(this.effective_dates_from)).format('yyyy-MM-DD') > moment(String(this.effective_dates_to)).format('yyyy-MM-DD')) {
          this.$notify.error({
              title: 'มีข้อผิดพลาด',
              message: 'วันที่เริ่มต้นใช้งานและวันที่สิ้นสุดไม่ถูกต้อง',
          });
          this.effective_dates_to = '';
        } 
      }
      if (this.effective_dates_to) {
        if (moment(String(this.effective_dates_from)).format('yyyy-MM-DD') > moment(String(this.effective_dates_to)).format('yyyy-MM-DD')) {
          this.$notify.error({
              title: 'มีข้อผิดพลาด',
              message: 'วันที่เริ่มต้นใช้งานและวันที่สิ้นสุดไม่ถูกต้อง',
          });
          this.effective_dates_from = '';
        }
      }
    },
    async checkForm (e) {
      console.log('checkForm');
      var form  = $('#submitForm');
      let inputs = form.serialize();
      this.errors = [];

      if (!this.nameHeader) {
        this.errors.push('ชื่อรายการราคาสินค้า');
        swal({
            title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
            text: this.errors,
            timer: 3000,
            type: "error",
            showCancelButton: false,
            showConfirmButton: false
        });
      }

      if (!this.lines.length) {
          this.errors.push('ผลิตภัณฑ์, ราคาต่อหน่วย, วันที่เริ่มต้นใช้งาน');
          console.log('check validate line <---> ' + this.lines.length);
          swal({
              title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
              text: this.errors,
              timer: 3000,
              type: "error",
              showCancelButton: false,
              showConfirmButton: false
          });
      }

      if (this.lines.length > 0) {
        this.lines.forEach(line => { 

          if (!line.item_id) {
            this.errors.push('ผลิตภัณฑ์');
              swal({
                title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                text: this.errors,
                timer: 3000,
                type: "error",
                showCancelButton: false,
                showConfirmButton: false
            });
          }

          if (!line.price) {
            this.errors.push('ราคาต่อหน่วย');
              swal({
                title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                text: this.errors,
                timer: 3000,
                type: "error",
                showCancelButton: false,
                showConfirmButton: false
            });
          }

          if (!line.start_date) {
            this.errors.push('วันที่เริ่มต้นใช้งาน');
              swal({
                title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                text: this.errors,
                timer: 3000,
                type: "error",
                showCancelButton: false,
                showConfirmButton: false
            });
          }
        });
      }

      if (!this.errors.length) {
        console.log('form submit');
        form.submit();
      }

      e.preventDefault();
    },
  },
  components: {
    VueNumeric
  },
};
</script>