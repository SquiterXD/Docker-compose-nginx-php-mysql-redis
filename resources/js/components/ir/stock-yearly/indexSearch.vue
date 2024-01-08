<template>
  <div>
    <el-form  
      :model="search"
      ref="search_stock_yearly" 
      label-width="120px" 
      class="demo-ruleForm">
      <!-- :rules="rules"  -->
      <div class="row">
        <div class="col-lg-6">
          <div class="row">
            <label class="col-lg-5 col-md-4 col-sm-12 col-xs-12 col-form-label lable_align">
              <strong>ปี</strong>
            </label>
            <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 align-item-center">
              <el-form-item prop="period_year">
                <datepicker-th  
                  style="width: 100%;"
                  class="el-input__inner md:tw-mb-0 tw-mb-2"
                  :name="`period_year`"
                  p-type="year"
                  placeholder="ปี"
                  :value="search.period_year"
                  :format="vars.formatYear"
                  @dateWasSelected="getValuePeriodYear" />
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-lg-5 col-md-4 col-sm-12 col-xs-12 col-form-label lable_align">
              <strong>วันที่คุ้มครอง</strong>
            </label>
            <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 align-item-center">
              <el-form-item>
                <el-input 
                  v-model="search.insurance_start_date"
                  placeholder="วันที่คุ้มครอง"
                  disabled />
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-lg-5 col-md-4 col-sm-12 col-xs-12 col-form-label lable_align">
              <strong>ข้อมูลย้อนหลังตั้งแต่เดือน</strong>
            </label>
            <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 align-item-center">
              <el-form-item prop="period_from">
                <datepicker-th  
                  style="width: 100%;"
                  class="el-input__inner md:tw-mb-0 tw-mb-2"
                  :name="`period_from`"
                  p-type="month"
                  placeholder="ข้อมูลย้อนหลังตั้งแต่เดือน"
                  :value="search.period_from"
                  :format="vars.formatMonth"
                  @dateWasSelected="getValuePeriodFrom" />
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-lg-5 col-md-4 col-sm-12 col-xs-12 col-form-label lable_align">
              <strong>ตั้งแต่รหัสหน่วยงาน</strong>
            </label>
            <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 align-item-center">
              <el-form-item>
                <lov-department 
                  v-model="search.department_from"
                  placeholder="ตั้งแต่รหัสหน่วยงาน"
                  attrName="department_from"
                  @change-lov="changeDepartmentFrom" />
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-lg-5 col-md-4 col-sm-12 col-xs-12 col-form-label lable_align">
              <strong>สถานะ</strong>
            </label>
            <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 align-item-center">
              <el-form-item prop="type_cost">
                <dropdown-status-ir 
                  v-model="search.status"
                  name="status"
                  size=""
                  :popperBody="true"
                  :disabled="false"
                  placeholder="สถานะ"
                  @change-lov="getValueStatus" />
              </el-form-item>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="row">
            <label class="col-lg-4 col-md-3 col-sm-12 col-xs-12 col-form-label lable_align">
              <strong>กรมธรรม์ชุดที่</strong>
            </label>
            <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 align-item-center">
              <el-form-item>
                <el-select  
                  v-model="search.policy_set_header_id"
                  placeholder="กรมธรรม์ชุดที่"
                  name="policy_set_header_id"
                  :remote-method="remoteMethodPolicySt"
                  :loading="loading"
                  remote
                  :clearable="true"
                  style="width: 100%"
                  @focus="focusPolicySt"
                  filterable
                  @change="changePolicySt">
                  <el-option  
                    v-for="(data, index) in policies"
                    :key="index"
                    :label="data.policy_set_number + ': ' + data.policy_set_description"
                    :value="data.policy_set_header_id">
                  </el-option>
                </el-select>
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-lg-4 col-md-3 col-sm-12 col-xs-12 col-form-label lable_align">
              <strong>ถึง</strong>
            </label>
            <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 align-item-center">
              <el-form-item>
                <el-input 
                  v-model="search.insurance_end_date"
                  placeholder="ถึงวันที่คุ้มครอง"
                  disabled />
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-lg-4 col-md-3 col-sm-12 col-xs-12 col-form-label lable_align">
              <strong>ถึง</strong>
            </label>
            <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 align-item-center">
              <el-form-item prop="period_to">
                <datepicker-th  
                  style="width: 100%;"
                  class="el-input__inner md:tw-mb-0 tw-mb-2"
                  :name="`period_to`"
                  p-type="month"
                  placeholder="ถึงเดือน"
                  :value="search.period_to"
                  :format="vars.formatMonth"
                  @dateWasSelected="getValuePeriodTo"
                  :disabledDateTo="search.period_from" />
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-lg-4 col-md-3 col-sm-12 col-xs-12 col-form-label lable_align">
              <strong>ถึง</strong>
            </label>
            <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 align-item-center">
              <el-form-item>
                <lov-department 
                  v-model="search.department_to"
                  placeholder="ถึงรหัสหน่วยงาน"
                  attrName="department_to"
                  @change-lov="changeDepartmentTo"  />
              </el-form-item>
            </div>
          </div>
        </div>
      </div>
      <div class="text-right el_field">
        <el-form-item>
          <button type="button" class="btn btn-default" @click="clickSearch()">
            <i class="fa fa-search"></i> ค้นหา
          </button>
          <button type="button" class="btn btn-success" data-toggle="modal" 
            :data-target="`#modal_stock_yearly_fetch`" @click="clickFetch()">
            <i class="fa fa-database"></i> ดึงข้อมูล
          </button>
          <button type="button" class="btn btn-warning" @click="clickCancel()">
            <i class="fa fa-repeat"></i> รีเซต
          </button>
        </el-form-item>
      </div>
    </el-form>
    <modal-fetch 
      :setYearCE="setYearCE"
      ref="modal_fetch"
      @fetch-table-header="fetchTableHeader"
      :vars="vars"
      :covertFomatDateMoment="covertFomatDateMoment" />
  </div>
</template>

<script>
import yearInput from '../components/calendar/yearInput'
import lovDepartment from './lovDepartment'
import lovInsuranceDate from './lovInsuranceDate'
import monthYearInput from '../components/calendar/monthYearInput'
import modalFetch from './moalFetch'
import moment from 'moment'
import dropdownStatusIr from '../components/dropdown/statusIr'
export default {
  name: 'ir-stock-yearly-index-search',
  data () {
    return {
      rules: {
        period_year: [
          {required: true, message: 'กรุณาระบุปี', trigger: 'change'}
        ]
      },
      getTimePeriodSt: '',
      getTimePeriodEn: '',
      year: '',
      policies: [],
      loading: false
    }
  },
  props: [
    'search',
    'setYearCE',
    'vars',
    'covertFomatDateMoment'
  ],
  computed: {
    checkPeriodMonth () {
      let start = this.search.period_from
      let end = this.search.period_to
       
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
      this.$refs.search_stock_yearly.validate((valid) => {
        if (valid) {
          if (this.reqCalendar()) {
            if (this.search.period_from === '' && this.search.period_to === '') {
               
              this.$emit('click-search', this.search)
            } else if (this.search.period_from && this.search.period_to) {
               
              this.$emit('click-search', this.search)
            } else {
               
              swal('Warning', 'กรุณาระบุช่วงเดือนให้ครบ!', 'warning')
            }
          }
        } else {
          return false;
        }
      })
    },
    clickCancel () {
      window.location.href = '/ir/stocks/yearly'
    },
    changeDepartmentFrom (value) {
      this.search.department_from = value
    },
    changeDepartmentTo (value) {
      this.search.department_to = value
    },
    reqCalendar () {
      let _this = this
       
      if (!this.checkPeriodMonth) {
        swal({
          title: "Warning",
          text: "ฟิลด์ข้อมูลย้อนหลังตั้งแต่เดือนต้องน้อยกว่าหรือเท่ากับฟิลด์ข้อมูลย้อนหลังตั้งแต่เดือนถึง!",
          type: "warning",
        },
        function(isConfirm) {
          if (isConfirm) {
            _this.search.period_from = ''
            _this.search.period_to = ''
          }
        });
      } else {
        return true
      }
    },
    getDataPolicySetHeaderId (params) {
      this.loading = true;
      axios.get(`/ir/ajax/lov/policy-set-header`, { params })
      .then(({data}) => {
         
        this.loading = false;
        this.policies = data.data
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    remoteMethodPolicySt (query) {
      this.getDataPolicySetHeaderId({
        policy_set_header_id: '',
        keyword: query,
        type: '10',
        type2: ''
      })
    },
    focusPolicySt (event) {
      this.getDataPolicySetHeaderId({
        policy_set_header_id: '',
        keyword: '',
        type: '10',
        type2: ''
      })
    },
    changePolicySt (value) {
       
      this.search.policy_set_header_id = value
    },
    getDataInsuranceDate (params) {
      axios.get(`/ir/ajax/lov/effective-date`, { params })
      .then(({data}) => {
        let response = data.data
        if (response === null) {
          this.search.insurance_start_date = ''
          this.search.insurance_end_date = ''
        } else {
          this.search.insurance_start_date = response.start_date_active
          this.search.insurance_end_date = response.end_date_active
        }
      })
      .catch((error) => {
        swal('Error', error, 'error')
      })
    },
    clickFetch () {
      this.$refs.modal_fetch.resetFields()
    },
    fetchTableHeader (dataRows) {
      this.$emit('fetch-show-table-header', dataRows)
    },
    getValuePeriodYear (date) {
      let formatYear = this.vars.formatYear
      if (date) {
        this.search.period_year = moment(date).format(formatYear);
        this.getDataInsuranceDate({
          year: this.setYearCE('year', this.search.period_year),
          keyword: ''
        });
      } else {
        this.search.period_year = ''
        this.search.insurance_start_date = ''
        this.search.insurance_end_date = ''
        this.getDataInsuranceDate({
          year: this.search.period_year,
          keyword: ''
        });
      }
    },
    getValuePeriodFrom (date) {
      let formatMonth = this.vars.formatMonth
      if (date) {
        this.search.period_from = moment(date).format(formatMonth);
        let twelveMonths = moment(date).add(11, 'months'); // 12 month != 1 year
        this.search.period_to = moment(twelveMonths).format(formatMonth);
      } else {
        this.search.period_from = '';
        this.search.period_to = '';
      }
    },
    getValuePeriodTo (date) {
      let formatMonth = this.vars.formatMonth
      if (date) {
        this.search.period_to = moment(date).format(formatMonth);
        let minusTwelveMonths = moment(date).add(-11, 'months'); 
        this.search.period_from = moment(minusTwelveMonths).format(formatMonth);
      } else {
        this.search.period_to = '';
        this.search.period_from = '';
      }
    },
    getValueStatus (value) {
      this.search.status = value;
    }
  },
  components: {
    yearInput,
    lovDepartment,
    lovInsuranceDate,
    monthYearInput,
    modalFetch,
    dropdownStatusIr
  },
  mounted () {
     
    this.getDataPolicySetHeaderId({
      policy_set_header_id: '',
      keyword: '',
      type: '10',
      type2: ''
    })
    this.getDataInsuranceDate({
      year: this.search.period_year ? +this.search.period_year - 543 : this.search.period_year,
      keyword: ''
    });
  }
}
</script>

<style>
  .el-form-item__content{
    line-height: 40px;
    position: relative;
    font-size: 14px;
    margin-left: 0px !important;
  }
</style>