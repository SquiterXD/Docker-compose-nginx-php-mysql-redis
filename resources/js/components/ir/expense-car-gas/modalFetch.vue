<template>
  <div class="modal inmodal fade" :id="`modal_expense_car_gas`" tabindex="-1" role="dialog"  aria-hidden="true"  data-backdrop="static" data-keyboard="false">
    <!-- data-backdrop="static" -->
    <div class="modal-dialog modal-md" style="padding-top: 0px !important;">
      <div v-loading ="showLoading" >
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" :disabled="showLoading">
              <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
            </button>
            <p class="modal-title text-left">การดึงข้อมูล</p>
          </div>
          <el-form
            :model="fetch"
            ref="form_stock_monthly_fetch" 
            label-width="120px" 
            class="demo-dynamic form_table_line"
            :rules="rules">
            <div class="modal-body">
              <div class="row">
                <label class="col-md-5 col-form-label lable_align">
                  <strong>เดือนปิดบัญชี *</strong>
                </label>
                <div class="col-xl-6 col-lg-6 col-md-6 el_field">
                  <el-form-item prop="period_name">
                    <datepicker-th  
                      style="width: 100%;"
                      class="el-input__inner"
                      :name="`period_name`"
                      p-type="month"
                      placeholder="เดือนปิดบัญชี"
                      :value="fetch.period_name"
                      :format="vars.formatMonth"
                      @dateWasSelected="getValuePeriodFrom" />
                  </el-form-item>
                </div>
              </div>
              <div class="row">
                <label class="col-md-5 col-form-label lable_align">
                  <strong>ประเภทของประกันภัย *</strong>
                </label>
                <div class="col-xl-6 col-lg-6 col-md-6 el_field">
                  <el-form-item prop="expense_type_code">
                    <lov-expense-type-code  
                      v-model="fetch.expense_type_code"
                      name="expense_type_code"
                      size=""
                      :popperBody="false"
                      @change-lov="getValueExpenseTypeCode" />
                  </el-form-item>
                </div>
              </div>
              <div class="row">
                <label class="col-md-5 col-form-label lable_align">
                  <strong>กลุ่ม</strong>
                </label>
                <div class="col-xl-6 col-lg-6 col-md-6 el_field">
                  <el-form-item prop="group_code">
                    <lov-group-code 
                      v-model="fetch.group_code"
                      name="group_code"
                      size=""
                      :popperBody="false"
                      @change-lov="getValueGroupCode"
                      placeholder="กลุ่ม" />
                  </el-form-item>
                </div>
              </div>
              <div class="row">
                <label class="col-md-5 col-form-label lable_align">
                  <strong>ประเภทสถานีน้ำมัน</strong>
                </label>
                <div class="col-xl-6 col-lg-6 col-md-6 el_field">
                  <el-form-item>
                    <lov-gas-station-type 
                      v-model="fetch.gas_station_type"
                      name="gas_station_type"
                      size=""
                      :popperBody="false"
                      @change-lov="getValueGasStation"
                      placeholder="ประเภทสถานีน้ำมัน" />
                  </el-form-item>
                </div>
              </div>
              <div class="row">
                <label class="col-md-5 col-form-label lable_align">
                  <strong>ทะเบียนรถยนต์</strong>
                </label>
                <div class="col-xl-6 col-lg-6 col-md-6 el_field">
                  <el-form-item>
                    <lov-license-plate 
                      v-model="fetch.license_plate"
                      name="license_plate"
                      size=""
                      :popperBody="false"
                      @change-lov="getValueLicensePlate"
                      placeholder="ทะเบียนรถยนต์" />
                  </el-form-item>
                </div>
              </div>
              <div class="row">
                <label class="col-md-5 col-form-label lable_align">
                  <strong>ประเภทการต่ออายุ</strong>
                </label>
                <div class="col-xl-6 col-lg-6 col-md-6 el_field">
                  <el-form-item>
                    <lov-renew-type 
                      v-model="fetch.renew_type"
                      name="renew_type"
                      size=""
                      :popper-body="false"
                      @change-lov="getValueRenewType(...arguments)"
                      placeholder="ประเภทการต่ออายุ" />
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
import lovStatusIr from '../components/lov/statusIr';
import lovExpenseTypeCode from './lovExpenseTypeCode';
import lovGroupCode from '../components/lov/groupCode';
import lovGasStationType from '../components/lov/gasStationType';
import lovLicensePlate from '../components/lov/licensePlate';
import lovRenewType from './lovRenewTypedesc';
import moment from 'moment'
export default {
  name: 'ir-stock-monthly-modal-fetch',
  data () {
    return {
      fetch: {
        period_name: '',
        expense_type_code: '',
        group_code: '',
        gas_station_type: '',
        license_plate: '',
        renew_type: '',
        policy_set_header_id: '',
      },
      rules: {
        period_name: [
          {required: true, message: 'กรุณาระบุเดือนปิดบัญชี', trigger: 'change'}
        ],
        expense_type_code : [
          {required: true, message: 'กรุณาระบุประเภทของประกันภัย', trigger: 'change'}
        ],
      },
      years: [],
      budget_period_year: [],
      months: [],
      showLoading: false
    }
  },
  props: [
    'setYearCE',
    'showYearBE',
    'vars',
  ],
  methods: {
    clickSearch () {
      this.$refs.form_stock_monthly_fetch.validate((valid) => {
        if (valid) {
          this.checkFetch();
        } else {
          return false;
        }
      })
    },
    clickClear () {
      this.resetFields()
    },
    checkFetch() {
      const vm = this;
      vm.showLoading = true
      let params = {
        period_name: vm.setYearCE('month', vm.fetch.period_name),
        type: vm.fetch.expense_type_code,
        group_code: vm.fetch.group_code,
        type_code: vm.fetch.gas_station_type,
        license_plate: vm.fetch.license_plate,
        renew_type: vm.fetch.renew_type,
        program_code: 'IRP0009',
        policy_set_header_id: vm.fetch.policy_set_header_id,
      }
      axios.get(`/ir/ajax/expense-car-gas/check-fetch`, { params })
      .then(({data}) => {
        // if(data.valid){
        //   this.getDataRows();
        // }else {
        //   this.showLoading = false
        //   swal("Error", data.msg, "error");
        // }

        if (data.status == 'E') {
          vm.showLoading = false;
          swal("Warning", data.msg, "warning");
        }else if (data.status == 'W') {
          swal({
            title: "Warning",
            text: data.msg,
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true
          },
          function (isConfirm) {
            if (isConfirm) {
              vm.getDataRows();
            }else{
              vm.showLoading = false;
            }
          });
        } else {
          vm.getDataRows();
        }
      })
      .catch((error) => {
        this.showLoading = false
        swal("Error", error, "error");
      });
    },
    getDataRows () {
      this.showLoading = true
      let params = {
        period_name: this.setYearCE('month', this.fetch.period_name),
        type: this.fetch.expense_type_code,
        group_code: this.fetch.group_code,
        type_code: this.fetch.gas_station_type,
        license_plate: this.fetch.license_plate,
        renew_type: this.fetch.renew_type,
        program_code: 'IRP0009',
        policy_set_header_id: this.fetch.policy_set_header_id,
      }
      axios.get(`/ir/ajax/expense-car-gas/fetch`, { params })
      .then(({data}) => {
        this.showLoading = false
        this.$emit('fetch-table-header', data.data)
        $(`#modal_expense_car_gas`).modal('hide')
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    resetFields () {
      this.$refs.form_stock_monthly_fetch.resetFields()
    },
    getValuePeriodFrom (value) {
      let formatMonth = this.vars.formatMonth
      if (value) {
        this.fetch.period_name = moment(value).format(formatMonth); 
      } else {
        this.fetch.period_name = '';
      }
    },
    getValueExpenseTypeCode (value) {
      this.fetch.expense_type_code = value;
    },
    getValueGroupCode (value) {
      this.fetch.group_code = value;
    },
    getValueGasStation (value) {
      this.fetch.gas_station_type = value;
    },
    getValueLicensePlate (value) {
      this.fetch.license_plate = value;
    },
    getValueRenewType (obj) {
      this.fetch.renew_type = obj ? obj.meaning : '';
    },
  },
  components: {
    lovStatusIr,
    lovExpenseTypeCode,
    lovGroupCode,
    lovGasStationType,
    lovLicensePlate,
    lovRenewType
  },
  created () {

  }
}
</script>
