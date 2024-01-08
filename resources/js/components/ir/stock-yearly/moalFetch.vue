<template>
  <div class="modal inmodal fade" :id="`modal_stock_yearly_fetch`" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md">
      <div v-loading="showLoading">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" :disabled="showLoading">
            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
          </button>
          <p class="modal-title text-left">การดึงข้อมูล</p>
        </div>
        <el-form  :model="fetch"
                  ref="form_stock_yearly_fetch" 
                  label-width="120px" 
                  class="demo-dynamic form_table_line"
                  :rules="rules">
          <div class="modal-body">
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>ปี *</strong>
              </label>
              <div class="col-lg-6 col-md-6 el_field">
                <el-form-item prop="period_year"
                              ref="fetch_period_year">
                  <datepicker-th  style="width: 100%;"
                                  class="el-input__inner"
                                  :name="`fetch_period_year`"
                                  p-type="year"
                                  placeholder="ปี"
                                  :value="fetch.period_year"
                                  :format="vars.formatYear"
                                  @dateWasSelected="getValuePeriodYearModal" />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>วันที่คุ้มครอง</strong>
              </label>
              <div class="col-lg-6 col-md-6 el_field">
                <el-form-item prop="insurance_start_date"
                              ref="fetch_insurance_start_date">
                  <el-input v-model="fetch.insurance_start_date"
                            placeholder="วันที่คุ้มครอง"
                            disabled />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>ถึง</strong>
              </label>
              <div class="col-lg-6 col-md-6 el_field">
                <el-form-item prop="insurance_end_date"
                              ref="fetch_insurance_end_date">
                  <el-input v-model="fetch.insurance_end_date"
                            placeholder="ถึงวันที่คุ้มครอง"
                            disabled />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>กรมธรรม์ชุดที่ *</strong>
              </label>
              <div class="col-lg-6 col-md-6 el_field">
                <el-form-item prop="policy_set_header_id"
                              ref="fetch_policy_set_header_id">
                  <lov-policy-set-header-id v-model="fetch.policy_set_header_id" 
                                            name="fetch_policy_set_header_id"
                                            size=""
                                            placeholder="กรมธรรม์ชุดที่"
                                            @change-lov="getValuePolicyModal"
                                            :popperBody="false"
                                            fixTypeFr="10"
                                            fixTypeSc="" />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>ข้อมูลย้อนหลังตั้งแต่เดือน *</strong>
              </label>
              <div class="col-lg-6 col-md-6 el_field">
                <el-form-item prop="period_from"
                              ref="fetch_period_from">
                  <datepicker-th  style="width: 100%;"
                                  class="el-input__inner"
                                  :name="`fetch_period_from`"
                                  p-type="month"
                                  placeholder="ข้อมูลย้อนหลังตั้งแต่เดือน"
                                  :value="fetch.period_from"
                                  :format="vars.formatMonth"
                                  @dateWasSelected="getValuePeriodFromModal"
                                  :disabled="disable_period" />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>ถึง *</strong>
              </label>
              <div class="col-lg-6 col-md-6 el_field">
                <el-form-item prop="period_to"
                              ref="fetch_period_to">
                  <datepicker-th  style="width: 100%;"
                                  class="el-input__inner"
                                  :name="`fetch_period_to`"
                                  p-type="month"
                                  placeholder="ถึงเดือน"
                                  :value="fetch.period_to"
                                  :format="vars.formatMonth"
                                  @dateWasSelected="getValuePeriodToModal"
                                  :disabledDateTo="fetch.period_from"
                                  :disabled="disable_period" />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>ตั้งแต่รหัสหน่วยงาน</strong>
              </label>
              <div class="col-lg-6 col-md-6 el_field">
                <el-form-item prop="department_from"
                              ref="fetch_department_from">
                  <lov-department v-model="fetch.department_from" 
                                  name="fetch_department_from"
                                  placeholder="ตั้งแต่รหัสหน่วยงาน"
                                  @change-lov="getValueDepartmentFromModal"
                                  :popperBody="false"
                                  size="" />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>ถึง</strong>
              </label>
              <div class="col-lg-6 col-md-6 el_field">
                <el-form-item prop="department_to"
                              ref="fetch_department_to">
                  <lov-department v-model="fetch.department_to" 
                                  name="fetch_department_to"
                                  placeholder="ถึงรหัสหน่วยงาน"
                                  @change-lov="getValueDepartmentToModal"
                                  :popperBody="false"
                                  size="" />
                </el-form-item>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" 
                    class="btn btn-success" 
                    @click="clickSearch()">
              <i class="fa fa-database"></i> ดึงข้อมูล
            </button>
            <button type="button" class="btn btn-warning" @click="clickClear()">
              <i class="fa fa-repeat"></i> รีเซต
            </button>
            </div>
          </el-form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import lovPolicySetHeaderId from '../components/lov/policySetHeaderId'
import lovDepartment from '../components/lov/department'
import moment from 'moment'
export default {
  name: 'ir-stock-yearly-modal-fetch',
  data () {
    return {
      fetch: {
        period_year: '',
        insurance_start_date: '',
        insurance_end_date: '',
        period_from: '',
        period_to: '',
        policy_set_header_id: '',
        department_from: '',
        department_to: ''
      },
      rules: {
        period_year: [
          {required: true, message: 'กรุณาระบุปี', trigger: 'change'}
        ],
        period_from: [
          {required: true, message: 'กรุณาระบุตั้งแต่เดือน', trigger: 'change'}
        ],
        period_to: [
          {required: true, message: 'กรุณาระบุถึงเดือน', trigger: 'change'}
        ],
        policy_set_header_id: [
          {required: true, message: 'กรุณาระบุ กรมธรรม์ชุดที่', trigger: 'change'}
        ]
      },
      getTimePeriodSt: '',
      getTimePeriodEn: '',
      showLoading: false,
      disable_period: true,

      old_policy_set_header_id: '',
    }
  },
  props: [
    'setYearCE',
    'vars',
    'covertFomatDateMoment'
  ],
  computed: {
    checkPeriodMonth () {
      let start = this.fetch.period_from
      let end = this.fetch.period_to
      if (start && end) {
        if (this.getTimePeriodSt <= this.getTimePeriodEn) {
          return true
        }
        return false
      }
      return true
    }
  },
  methods: {
    clickSearch () {
      //  this.showLoading = true
      this.$refs.form_stock_yearly_fetch.validate((valid) => {
        if (valid) {
          if (this.warningPeriod()) {
            this.checkFetch()
          }
        } else {
          return false;
        }
      })
    },
    clickClear () {
      this.resetFields()
    },
    validateNotElUi (value, nameProp) {
      if (value) {
        this.$refs.form_stock_yearly_fetch.fields.find((f) => f.prop == nameProp).clearValidate()
      } else {
        this.$refs.form_stock_yearly_fetch.validateField(nameProp)
      }
    },
    checkFetch(){
      let vm = this;
      vm.showLoading = true
      let params = {
        period_year: vm.setYearCE('year', vm.fetch.period_year),
        insurance_start_date: vm.setYearCE('date', vm.fetch.insurance_start_date),
        insurance_end_date: vm.setYearCE('date', vm.fetch.insurance_end_date),
        period_from: vm.setYearCE('month', vm.fetch.period_from),
        period_to: vm.setYearCE('month', vm.fetch.period_to),
        program_code: 'IRP0001',
        policy_set_header_id: vm.fetch.policy_set_header_id,
        department_from: vm.fetch.department_from,
        department_to: vm.fetch.department_to
      }
      axios.get(`/ir/ajax/stocks/check-fetch`, { params })
      .then(({data}) => {
        if(data.status === 'S'){
          vm.getDataRows();
        }else {
          if(data.status === 'W'){
            swal({
              title: "Warning",
              text: data.msg,
              type: "warning",
              showCancelButton: true,
              showConfirmButton: true
            }, function(confirm){
              if(confirm){
                vm.getDataRows();
              }else{
                vm.showLoading = false
              }
            })
          }else {
            swal("Error", data.msg, "error");
            vm.showLoading = false
          }
        }
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    getDataRows () {
      this.showLoading = true
      let params = {
        period_year: this.setYearCE('year', this.fetch.period_year),
        insurance_start_date: this.setYearCE('date', this.fetch.insurance_start_date),
        insurance_end_date: this.setYearCE('date', this.fetch.insurance_end_date),
        period_from: this.setYearCE('month', this.fetch.period_from),
        period_to: this.setYearCE('month', this.fetch.period_to),
        program_code: 'IRP0001',
        policy_set_header_id: this.fetch.policy_set_header_id,
        department_from: this.fetch.department_from,
        department_to: this.fetch.department_to
      }
      axios.get(`/ir/ajax/stocks/fetch`, { params })
      .then(({data}) => {
        this.showLoading = false
        this.$emit('fetch-table-header', data.data.data)
        $(`#modal_stock_yearly_fetch`).modal('hide')
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    warningPeriod () {
      let _this = this
      if (!this.checkPeriodMonth) {
        swal({
          title: "Warning",
          text: "ฟิลด์ตั้งแต่เดือนต้องน้อยกว่าหรือเท่ากับฟิลด์ตั้งแต่เดือนถึง!",
          type: "warning",
        },
        function(isConfirm) {
          if (isConfirm) {
            _this.$refs.fetch_period_from.resetField()
            _this.$refs.fetch_period_to.resetField()
          }
        });
      } else {
        return true
      }
    },
    getDataInsuranceDate () {
      let params = {
        year: this.setYearCE('year', this.fetch.period_year),
        keyword: ''
      }
      axios.get(`/ir/ajax/lov/effective-date`, { params })
      .then(({data}) => {
        let response = data.data
        if (response === null) {
          this.$refs.fetch_insurance_start_date.resetField()
          this.$refs.fetch_insurance_end_date.resetField()
        } else {
          this.fetch.insurance_start_date = response.start_date_active
          this.fetch.insurance_end_date = response.end_date_active
        }
      })
      .catch((error) => {
        swal('Error', error, 'error')
      })
    },
    resetFields () {
      this.$refs.form_stock_yearly_fetch.resetFields()

      axios.get('/ir/ajax/lov/period-year').then(({data:response}) => {
        this.fetch.period_year = (response.data.period_year).toString();

        if (this.fetch.period_year) {
          this.getValuePeriodYearModal(this.fetch.period_year);
        }
      })
      .catch((error) => {
        swal("Error", error, "error")
      })
    },
    getValuePolicyModal (value) {
      this.fetch.policy_set_header_id = value

      if (this.fetch.policy_set_header_id) {
        this.disable_period = false;
        if (this.old_policy_set_header_id != this.fetch.policy_set_header_id) {
          this.fetch.period_from = '';
          this.fetch.period_to   = '';
        }
      }else{
        this.disable_period    = true;
        this.fetch.period_from = '';
        this.fetch.period_to   = '';
      }

      this.old_policy_set_header_id = this.fetch.policy_set_header_id;

    },
    getValueDepartmentFromModal (value) {
      this.fetch.department_from = value
    },
    getValueDepartmentToModal (value) {
      this.fetch.department_to = value
    },
    getValuePeriodYearModal (date) {
      let formatYear = this.vars.formatYear
      if (date) {
        this.fetch.period_year = moment(date).format(formatYear)
        this.getDataInsuranceDate()
      } else {
        this.fetch.period_year = '';
        this.$refs.fetch_insurance_start_date.resetField()
        this.$refs.fetch_insurance_end_date.resetField()
        this.getDataInsuranceDate()
      }
      this.validateNotElUi(date, 'period_year');
    },
    getValuePeriodFromModal (date) {
      let formatMonth = this.vars.formatMonth
      if (date) {
        this.fetch.period_from = moment(date).format(formatMonth);
        // let twelveMonths = moment(date).add(11, 'months'); // 12 month != 1 year
        // this.fetch.period_to = moment(twelveMonths).format(formatMonth);

        if (this.fetch.policy_set_header_id == 1) {
          // let twelveMonths = moment(date).add(12, 'months'); // 12 month != 1 year
          this.fetch.period_to = moment(date).format(formatMonth);
        } else {
          let twelveMonths = moment(date).add(11, 'months'); // 12 month != 1 year
          this.fetch.period_to = moment(twelveMonths).format(formatMonth);
        }
      } else {
        this.fetch.period_from = '';
        this.fetch.period_to = '';
      }
      this.validateNotElUi(date, 'period_from');
      this.validateNotElUi(date, 'period_to');
    },
    getValuePeriodToModal (date) {
      let formatMonth = this.vars.formatMonth
      if (date) {
        if (this.fetch.policy_set_header_id == 1) {
          this.fetch.period_to = moment(date).format(formatMonth);
          let minusTwelveMonths = moment(date);
          this.fetch.period_from = moment(minusTwelveMonths).format(formatMonth);

        } else {
          this.fetch.period_to = moment(date).format(formatMonth);
          let minusTwelveMonths = moment(date).add(-11, 'months');
          this.fetch.period_from = moment(minusTwelveMonths).format(formatMonth);
        }
      } else {
        this.fetch.period_to = '';
        this.fetch.period_from = '';
      }
      this.validateNotElUi(date, 'period_to');
      this.validateNotElUi(date, 'period_from');
    },
  },
  components: {
    lovPolicySetHeaderId,
    lovDepartment
  }
}
</script>
