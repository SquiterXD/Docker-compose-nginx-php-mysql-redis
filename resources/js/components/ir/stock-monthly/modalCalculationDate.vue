<template>
  <div 
    class="modal inmodal fade" 
    :id="`modal_cal_date${modalId}`"
    tabindex="-1" 
    role="dialog" 
    aria-hidden="true" 
    data-backdrop="static"
  >
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" @click="clickAgree()">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
          </button>
          <p class="modal-title text-left">Calculation Date</p>
        </div>
        <el-form 
          :model="modal"
          ref="form_calculate_date" 
          label-width="120px" 
          class="demo-dynamic form_table_line"
          :rules="rules"
        >
          <div class="modal-body">
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                Start Date <br>
                วันที่เริ่มต้นการคิดเบี้ยประกัน
              </label>
              <div class="col-md-7 el_field">
                <el-form-item prop="start_date">
                  <!-- <datepicker-th  style="width: 100%;"
                                  class="el-input__inner"
                                  :name="`start_date${modalId}`"
                                  p-type="date"
                                  placeholder="วันที่เริ่มต้นการคิดเบี้ยประกัน"
                                  :value="modal.start_date"
                                  :format="vars.formatDate"
                                  @dateWasSelected="getValueStartDate" /> -->
                  <ct-datepicker 
                    style="width: 100%;"
                    class="el-input__inner"
                    :name="`start_date${modalId}`"
                    placeholder="วันที่เริ่มต้นการคิดเบี้ยประกัน"
                    :value="toJSDate(this.modal.start_date, 'dd/MM/yyyy')"
                    @change="getValueStartDate"
                    />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                End Date <br>
                วันที่สิ้นสุดการคิดเบี้ยประกัน
              </label>
              <div class="col-md-7 el_field">
                <el-form-item prop="end_date">
                  <!-- <datepicker-th  style="width: 100%;"
                                  class="el-input__inner"
                                  :name="`end_date${modalId}`"
                                  p-type="date"
                                  placeholder="วันที่สิ้นสุดการคิดเบี้ยประกัน"
                                  :value="modal.end_date"
                                  :format="vars.formatDate"
                                  @dateWasSelected="getValueEndDate"
                                  :disabledDateTo="modal.start_date" /> -->
                  <ct-datepicker 
                    style="width: 100%;"
                    class="el-input__inner"
                    :name="`end_date${modalId}`"
                    :enableDate="d => isInRange(d, toJSDate(this.modal.start_date, 'dd/MM/yyyy'), null, true)"
                    placeholder="วันที่สิ้นสุดการคิดเบี้ยประกัน"
                    :value="toJSDate(this.modal.end_date, 'dd/MM/yyyy')"
                    @change="getValueEndDate"
                    />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                Days <br>
                จำนวนวัน
              </label>
              <div class="col-md-7 el_field">
                <el-input placeholder="จำนวนวัน" 
                          v-model="modal.days"
                          disabled />
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" 
                    class="btn btn-primary" 
                    @click="clickAgree()">
              <i class="fa fa-check-circle-o"></i> ตกลง
            </button>
          </div>
        </el-form>
      </div>
    </div>
  </div>
</template>

<script>
  import moment from 'moment'
  import {isInRange, toJSDate} from '../../../dateUtils'
  export default {
    name: 'ir-stock-monthly-modal-calculation-date',
    data () {
      return {
        toJSDate,
        isInRange,
        modal: {
          start_date: this.modalVal.start_date,
          end_date: this.modalVal.end_date,
          days: this.modalVal.days
        },
        dtst: '',
        dten: '',
        qtyDay: 0,
        date: 0,
        getTimeStDate: '',
        getTimeEnDate: '',
        rules: {
          start_date: [
            {required: true, message: 'กรุณาระบุวันที่เริ่มต้นการคิดเบี้ยประกัน', trigger: 'change'}
          ],
          end_date: [
            {required: true, message: 'กรุณาระบุวันที่สิ้นสุดการคิดเบี้ยประกัน', trigger: 'change'}
          ]
        },
        momentStDate: '',
        momentEnDate: ''
      }
    },
    props: [
      'modalId',
      'modalVal',
      'modalDataRow',
      'vars',
      'setYearCE',
      'setBudgetYearFromFieldStCalendar',
      'covertFomatDateMoment',
      'setDefaultEndDateIsLastDateOfMonth'
    ],
    computed: {
      calculateDate () {
        this.modal.days = ''
        let _this = this;
         
         
        if (this.momentStDate && this.momentEnDate) {
          this.qtyDay = this.momentEnDate.diff(this.momentStDate, 'days')
           
           
          this.date = this.qtyDay + 1
          this.modal.days = this.date 
        }
      }
    },
    methods: {
      clickAgree () {
        this.$refs.form_calculate_date.validate((valid) => {
          if (valid) {
            this.$emit('calculation-date', this.modal)
            $(`#modal_cal_date${this.modalId}`).modal('hide')
          } else {
            return false;
          }
        })
      },
      getValueStartDate (date) {
        let formatDate = this.vars.formatDate
        if (date) {
          this.modal.start_date = moment(date).format(formatDate);
          // let dateCE = this.setYearCE('date', this.modal.start_date);
           
          this.momentStDate = moment(this.modal.start_date, formatDate);
        } else {
          this.modal.start_date = ''
          this.momentStDate = ''
          this.modal.days = ''
        }
        this.validateNotElUi(date, 'start_date');
        // this.modal.end_date = this.covertFomatDateMoment(this.setBudgetYearFromFieldStCalendar(date), 'date');
        this.modal.end_date = this.setDefaultEndDateIsLastDateOfMonth(date);
        this.validateNotElUi(this.modal.end_date, 'end_date');
        if (date && this.modal.end_date) {
           
          // let dateEnCE = this.setYearCE('date', this.modal.end_date);
          this.momentEnDate = moment(this.modal.end_date, formatDate);
          this.calculateDate;
        }
      },
      getValueEndDate (date) {
        let formatDate = this.vars.formatDate
        if (date) {
          this.modal.end_date = moment(date).format(formatDate);
          // let dateEnCE = this.setYearCE('date', this.modal.end_date);
          this.momentEnDate = moment(this.modal.end_date, formatDate)
          
          if (this.modal.start_date) {
               
              // let dateStCE = this.setYearCE('date', this.modal.start_date);
              this.momentStDate = moment(this.modal.start_date, formatDate)
              this.calculateDate
          }
        } else {
          this.modal.end_date = ''
          this.momentEnDate = ''
          this.modal.days = ''
        }
        this.validateNotElUi(date, 'end_date');
      },
      validateNotElUi (value, nameProp) {
        if (value) {
          this.$refs.form_calculate_date.fields.find((f) => f.prop == nameProp).clearValidate()
        } else {
          this.$refs.form_calculate_date.validateField(nameProp)
        }
      }
    },
    watch: {
      'modalVal.days' (newVal, oldVal) {
        this.modal.days = newVal 
      },
      'modalVal.start_date' (newVal, oldVal) {
        this.modal.start_date = newVal
      },
      'modalVal.end_date' (newVal, oldVal) {
        this.modal.end_date = newVal
      }
    }
  }
</script>

