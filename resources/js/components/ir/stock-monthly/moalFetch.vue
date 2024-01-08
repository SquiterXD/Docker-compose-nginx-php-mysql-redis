<template>
  <div class="modal inmodal fade" :id="`modal_stock_monthly_fetch`" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <!-- data-backdrop="static" -->
    <div class="modal-dialog modal-md">
     <div v-loading ="showLoading" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" :disabled="showLoading">
            <!-- @click="clickSearch()" -->
            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
          </button>
          <p class="modal-title text-left">การดึงข้อมูล</p>
        </div>
        <el-form  :model="fetch"
                  ref="form_stock_monthly_fetch" 
                  label-width="120px" 
                  class="demo-dynamic form_table_line"
                  :rules="rules">
          <div class="modal-body">
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>ปี *</strong>
              </label>
              <div class="col-lg-5 col-md-6 el_field">
                <el-form-item prop="period_year">
                  <el-select  v-model="fetch.period_year"
                              placeholder="ปี"
                              name="fetch_period_year"
                              :clearable="true"
                              @change="changeYear"
                              :popper-append-to-body="false">
                    <el-option  v-for="(data, index) in years"
                                :key="index"
                                :label="showYearBE('year', data)"
                                :value="data">
                    </el-option>
                  </el-select>
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>เดือนปิดบัญชี *</strong>
              </label>
              <div class="col-lg-5 col-md-6 el_field">
                <el-form-item prop="period_name"
                              ref="fetch_period_name">
                  <el-select  v-model="fetch.period_name"
                              placeholder="เดือนปิดบัญชี"
                              name="fetch_period_name"
                              :clearable="true"
                              @change="changeMonth"
                              :popper-append-to-body="false">
                    <el-option  v-for="(data, index) in months"
                                :key="index"
                                :label="data.month_th_format"
                                :value="data.month_th_format">
                    </el-option>
                  </el-select>
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>ข้อมูลคงคลังประจำเดือน</strong>
              </label>
              <div class="col-lg-5 col-md-6 el_field">
                <el-form-item prop="data_month"
                              ref="fetch_data_month">
                  <el-input v-model="fetch.data_month"
                            placeholder="ข้อมูลคงคลังประจำเดือน"
                            disabled />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>กรมธรรม์ชุดที่</strong>
              </label>
              <div class="col-lg-5 col-md-6 el_field">
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
                <strong>ตั้งแต่รหัสหน่วยงาน</strong>
              </label>
              <div class="col-lg-5 col-md-6 el_field">
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
              <div class="col-lg-5 col-md-6 el_field">
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
            <button type="button" class="btn btn-success" @click="clickSearch()">
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
export default {
  name: 'ir-stock-monthly-modal-fetch',
  data () {
    return {
      fetch: {
        period_year: '',
        period_name: '',
        data_month: '',
        policy_set_header_id: '',
        department_from: '',
        department_to: ''
      },
      rules: {
        period_year: [
          {required: true, message: 'กรุณาระบุปี', trigger: 'change'}
        ],
        period_name: [
          {required: true, message: 'กรุณาระบุเดือนปิดบัญชี', trigger: 'change'}
        ]
      },
      years: [],
      budget_period_year: [],
      months: [],
      showLoading: false
    }
  },
  props: [
    'setYearCE',
    'showYearBE'
  ],
  methods: {
    clickSearch () {
      this.$refs.form_stock_monthly_fetch.validate((valid) => {
        if (valid) {
          this.checkFetch()
        } else {
          return false;
        }
      })
    },
    clickClear () {
      this.resetFields()
    },
    changeYear (value) {
      // console.log('period_year', this.fetch.period_year);
      // console.log('value', value);
      // console.log('budget_period_year', this.budget_period_year);

      this.fetch.period_year = value;
      this.showYearBE('year', value);

      if (value) {
        this.months = this.budget_period_year.filter((row) => {
          if (value === row.period_year) {
            return row
          }
        })
      } else {
        this.months = []
      }
      this.$refs.fetch_period_name.resetField()
      this.$refs.fetch_data_month.resetField()
    },
    getDataBudgetPeriodYear () {
      axios.get(`/ir/ajax/lov/budget-period-year`)
      .then(({data}) => {
        this.budget_period_year = data.data
        if (this.budget_period_year.length > 0) {
          this.years = this.unique()
        }
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    unique () {
      var result = [];
      $.each(this.budget_period_year, function(i, e) {
        if ($.inArray(e.period_year, result) == -1) result.push(e.period_year);
      });
      return result;
    },
    checkFetch(){
      let vm = this;
      vm.showLoading = true
      let params = {
        period_year: vm.fetch.period_year,
        period_name: vm.setYearCE('month', vm.fetch.period_name),
        data_month: vm.setYearCE('month', vm.fetch.data_month),
        program_code: 'IRP0002',
        policy_set_header_id: vm.fetch.policy_set_header_id,
        department_from: vm.fetch.department_from,
        department_to: vm.fetch.department_to,
        // status: ''
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
        period_year: this.fetch.period_year,
        period_name: this.setYearCE('month', this.fetch.period_name),
        data_month: this.setYearCE('month', this.fetch.data_month),
        program_code: 'IRP0002',
        policy_set_header_id: this.fetch.policy_set_header_id,
        department_from: this.fetch.department_from,
        department_to: this.fetch.department_to,
        // status: ''
      }
      axios.get(`/ir/ajax/stocks/fetch`, { params })
      .then(({data}) => {
        this.showLoading = false
        this.$emit('fetch-table-header', data.data.data)
        $(`#modal_stock_monthly_fetch`).modal('hide')
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    resetFields () {
      this.$refs.form_stock_monthly_fetch.resetFields()

      axios.get('/ir/ajax/lov/period-year').then(({data:response}) => {
        let period_year = (response.data.period_year-543).toString();
        if (period_year) {
          this.changeYear(period_year);
        }
      })
      .catch((error) => {
        swal("Error", error, "error")
      })
    },
    changeMonth (value) {
      this.fetch.period_name = value
      if (value) {
        this.months.filter((row) => {
          if (value === row.month_th_format) {
            this.fetch.data_month = row.bef_month_th_format
          }
        })
      } else {
        this.$refs.fetch_data_month.resetField()
      }
    },
    getValuePolicyModal (value) {
      this.fetch.policy_set_header_id = value
    },
    getValueDepartmentFromModal (value) {
      this.fetch.department_from = value
    },
    getValueDepartmentToModal (value) {
      this.fetch.department_to = value
    }
  },
  components: {
    lovPolicySetHeaderId,
    lovDepartment
  },
  created () {
    this.getDataBudgetPeriodYear()
  }
}
</script>
