<template>
  <div>
    <el-form  :model="search"
              :rules="rules"
              ref="search_expense_car_gas"
              label-width="120px"
              class="demo-ruleForm">
      <div class="row">
        <div class="col-lg-6">
          <div class="row">
            <label class="col-md-5 col-form-label lable_align">
              <strong>เดือนปิดบัญชี *</strong>
            </label>
            <div class="col-xl-6 col-lg-5 col-md-6 el_field">
              <!-- <el-form-item prop="month">
                <el-select  v-model="search.month"
                            placeholder="เดือน"
                            name="month"
                            :clearable="true">
                  <el-option  v-for="(data, index) in months"
                              :key="index"
                              :label="data.month_th_format"
                              :value="data.month_th_format">
                  </el-option>
                </el-select>
              </el-form-item> -->
              <el-form-item prop="period_name">
                <datepicker-th  style="width: 100%;"
                                class="el-input__inner"
                                :name="`period_name`"
                                p-type="month"
                                placeholder="เดือนปิดบัญชี"
                                :value="search.period_name"
                                :format="vars.formatMonth"
                                @dateWasSelected="getValuePeriodFrom" />
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-md-5 col-form-label lable_align">
              <strong>ทะเบียนรถยนต์</strong>
            </label>
            <div class="col-xl-6 col-lg-5 col-md-6 el_field">
              <el-form-item>
                <lov-license-plate v-model="search.license_plate"
                                  name="license_plate"
                                  size=""
                                  @change-lov="getValueLicensePlate"
                                  placeholder="ทะเบียนรถยนต์" />
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-md-5 col-form-label lable_align">
              <strong>ประเภทการต่ออายุ</strong>
            </label>
            <div class="col-xl-6 col-lg-5 col-md-6 el_field">
              <el-form-item>
                <lov-renew-type v-model="search.renew_type"
                                  name="renew_type"
                                  size=""
                                  @change-lov="getValueRenewType(...arguments)"
                                  placeholder="ประเภทการต่ออายุ" />
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-md-5 col-form-label lable_align">
              <strong>สถานะ</strong>
            </label>
            <div class="col-xl-6 col-lg-5 col-md-6 el_field">
              <el-form-item>
                <lov-status-ir  v-model="search.status"
                                name="status"
                                size=""
                                @change-lov="getValueStatus" />
              </el-form-item>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="row">
            <label class="col-md-4 col-form-label lable_align">
              <strong>ประเภทของประกันภัย *</strong>
            </label>
            <div class="col-xl-6 col-lg-5 col-md-6 el_field">
              <el-form-item prop="expense_type_code">
                <lov-expense-type-code  v-model="search.expense_type_code"
                                        name="expense_type_code"
                                        size=""
                                        @change-lov="getValueExpenseTypeCode" />
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-md-4 col-form-label lable_align">
              <strong>ประเภทสถานีน้ำมัน</strong>
            </label>
            <div class="col-xl-6 col-lg-5 col-md-6 el_field">
              <el-form-item>
                <lov-gas-station-type v-model="search.gas_station_type"
                                      name="gas_station_type"
                                      size=""
                                      @change-lov="getValueGasStation"
                                      placeholder="ประเภทสถานีน้ำมัน" />
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-md-4 col-form-label lable_align">
              <strong>กลุ่ม</strong>
            </label>
            <div class="col-xl-6 col-lg-5 col-md-6 el_field">
              <el-form-item prop="group_code">
              <lov-group-code v-model="search.group_code"
                                name="group_code"
                                size=""
                                @change-lov="getValueGroupCode"
                                placeholder="กลุ่ม" />
              </el-form-item>
            </div>
          </div>
        </div>
      </div>
      <!-- <div class="col-lg-11">
        <div class="row">
          <label class="col-md-5 col-form-label lable_align">
            <strong>ปี *</strong>
          </label>
          <div class="col-xl-6 col-lg-5 col-md-6 el_field">
            <el-form-item prop="year">
              <el-select  v-model="search.year"
                          placeholder="ปี"
                          name="year"
                          :clearable="true"
                          @change="changeYear">
                <el-option  v-for="(data, index) in years"
                            :key="index"
                            :label="showYearBE('year', data)"
                            :value="data">
                </el-option>
              </el-select>
            </el-form-item>
          </div>
        </div>
      </div> -->
      <div class="text-right el_field">
        <el-form-item>
          <button type="button" class="btn btn-default" @click="clickSearch()">
            <i class="fa fa-search"></i> ค้นหา
          </button>
          <button type="button" 
            class="btn btn-success"
            data-toggle="modal"
            :data-target="`#modal_expense_car_gas`"
            @click="clickFetch()">
            <i class="fa fa-database"></i> ดึงข้อมูล
          </button>
          <button type="button" class="btn btn-warning" @click="clickClear()">
            <i class="fa fa-repeat"></i> รีเซต
          </button>
        </el-form-item>
      </div>
    </el-form>
    <modal-fetch 
      :setYearCE="setYearCE"
      ref="modal_fetch"
      @fetch-table-header="fetchTableHeader"
      :vars="vars" />
  </div>
</template>

<script>
import modalFetch from './modalFetch'
import lovStatusIr from '../components/lov/statusIr'
import lovExpenseTypeCode from './lovExpenseTypeCode'
import lovGroupCode from '../components/lov/groupCode'
import lovGasStationType from '../components/lov/gasStationType'
import lovLicensePlate from '../components/lov/licensePlate'
import lovRenewType from './lovRenewTypedesc'
import moment from 'moment'
export default {
  name: 'ir-expense-car-gas-search',
  data () {
    return {
      rules: {
        year: [
          {required: true, message: 'กรุณาระบุปี', trigger: 'change'}
        ],
        period_name: [
          {required: true, message: 'กรุณาระบุเดือน', trigger: 'change'}
        ],
        expense_type_code: [
          {required: true, message: 'กรุณาระบุประเภทของประกันภัย', trigger: 'change'}
        ]

      },
      period_name: [],
      budget_period_year: [],
      months: [],
      years: []
    }
  },
  props: [
    'search',
    'showYearBE',
    'vars',
    'setYearCE',
  ],
  methods: {
    changeYear (value) {
      this.search.year = value
      if (value) {
        this.months = this.budget_period_year.filter((row) => {
          if (value === row.period_year) {
            return row
          }
        })
      } else {
        this.months = []
      }
      this.search.month = ''
    },
    clickSearch () {
      this.$refs.search_expense_car_gas.validate((valid) => {
        if (valid) {
          this.$emit('click-search', this.search)
        } else {
          return false;
        }
      })
    },
    clickFetch () {

    },
    clickClear () {
      window.location.href = '/ir/expense-car-gas'
    },
    getValueStatus (value) {
      this.search.status = value
    },
    getDataBudgetPeriodYear () {
      axios.get(`/ir/ajax/lov/budget-period-year`)
      .then(({data}) => {
        this.budget_period_year = this.setPropertyPeriodYear(data.data)
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    setPropertyPeriodYear (array) {
      return array.filter((row) => {
        return row
      })
    },
    onlyUnique(value, index, self) {
      return self.indexOf(value) === index;
    },
    unique () {
      var result = [];
      $.each(this.budget_period_year, function(i, e) {
        if ($.inArray(e.period_year, result) == -1) result.push(e.period_year);
      });
      return result;
    },
    getValueExpenseTypeCode (value) {
      this.search.expense_type_code = value
    },
    getValueGroupCode (value) {
      this.search.group_code = value
    },
    getValueGasStation (value) {
      this.search.gas_station_type = value
    },
    getValueLicensePlate (value) {
      this.search.license_plate = value
    },
    getValueRenewType (obj) {
      this.search.renew_type = obj ? obj.meaning : '';
    },
    getValuePeriodFrom (date) {
      let formatMonth = this.vars.formatMonth
      if (date) {
        this.search.period_name = moment(date).format(formatMonth);
      } else {
        this.search.period_name = '';
      }
    },
    fetchTableHeader (data) {
      this.$emit('fetch-show-table-header', data);
    },
  },
  components: {
    modalFetch,
    lovStatusIr,
    lovExpenseTypeCode,
    lovGroupCode,
    lovGasStationType,
    lovLicensePlate,
    lovRenewType,
  },
  watch: {
    'budget_period_year' (newVal, oldVal) {
      if (newVal.length > 0) {
        this.years = this.unique()
      }
    }
  },
  created () {
    this.getDataBudgetPeriodYear()
  }
}
</script>