<template>
  <div class="modal inmodal fade" :id="`modal_asset_increase_fetch`" tabindex="-1" role="dialog"  aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div v-loading="showLoading">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
          </button>
          <p class="modal-title text-left">การดึงข้อมูล</p>
        </div>
        <el-form  :model="fetch"
                  ref="form_asset_increase_fetch" 
                  label-width="120px" 
                  class="demo-dynamic form_table_line"
                  :rules="rules">
          <div class="modal-body">
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>ปี *</strong>
              </label>
              <div class="col-lg-5 col-md-6 el_field">
                <el-form-item prop="year"
                              ref="fetch_year">
                  <datepicker-th  style="width: 100%;"
                                  class="el-input__inner"
                                  :name="`fetch_year`"
                                  p-type="year"
                                  placeholder="ปี"
                                  :value="fetch.year"
                                  :format="vars.formatYear"
                                  @dateWasSelected="getValueYearModal" />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>กรมธรรม์ชุดที่</strong>
              </label>
              <div class="col-lg-5 col-md-6 el_field">
                <el-form-item prop="policy_set_header_id_start"
                              ref="fetch_policy_set_header_id_start">
                  <lov-policy-set-header-id v-model="fetch.policy_set_header_id_start" 
                                            name="fetch_policy_set_header_id_start"
                                            size=""
                                            placeholder="กรมธรรม์ชุดที่"
                                            @change-lov="getValuePolicyStModal"
                                            :popperBody="false"
                                            fixTypeFr="20"
                                            fixTypeSc="" />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>ถึง</strong>
              </label>
              <div class="col-lg-5 col-md-6 el_field">
                <el-form-item prop="policy_set_header_id_end"
                              ref="fetch_policy_set_header_id_end">
                  <lov-policy-set-header-id v-model="fetch.policy_set_header_id_end" 
                                            name="fetch_policy_set_header_id_end"
                                            size=""
                                            placeholder="ถึงกรมธรรม์ชุดที่"
                                            @change-lov="getValuePolicyEnModal"
                                            :popperBody="false"
                                            fixTypeFr="20"
                                            fixTypeSc="" />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>วันที่คิดค่าเบี้ย *</strong>
              </label>
              <div class="col-lg-5 col-md-6 el_field">
                <el-form-item prop="start_calculate_date"
                              ref="fetch_start_calculate_date">
                  <datepicker-th  style="width: 100%;"
                                  class="el-input__inner"
                                  :name="`fetch_start_calculate_date`"
                                  p-type="date"
                                  placeholder="วันที่คิดค่าเบี้ย"
                                  :value="fetch.start_calculate_date"
                                  :format="vars.formatDate"
                                  :disabled="!(fetch.year)"
                                  @dateWasSelected="getValueCalStDateModal"
                                  :notBeforeDate="fetch.start_budget_year_date"
                                  :notAfterDate="fetch.end_budget_year_date" />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>ถึง *</strong>
              </label>
              <div class="col-lg-5 col-md-6 el_field">
                <el-form-item prop="end_calculate_date"
                              ref="fetch_end_calculate_date">
                  <datepicker-th  style="width: 100%;"
                                  class="el-input__inner"
                                  :name="`fetch_end_calculate_date`"
                                  p-type="date"
                                  placeholder="ถึงวันที่คิดค่าเบี้ย"
                                  :value="fetch.end_calculate_date"
                                  :format="vars.formatDate"
                                  :disabled="!(fetch.year)"
                                  @dateWasSelected="getValueCalEnDateModal"
                                  :notBeforeDate="fetch.start_budget_year_date"
                                  :notAfterDate="fetch.end_budget_year_date"
                                  :disabledDateTo="fetch.start_calculate_date" />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>วันที่ขึ้นทะเบียน/ตัดจำหน่าย *</strong>
              </label>
              <div class="col-lg-5 col-md-6 el_field">
                <el-form-item prop="start_addition_date"
                              ref="fetch_start_addition_date">
                  <datepicker-th  style="width: 100%;"
                                  class="el-input__inner style_icon_calendar"
                                  :name="`fetch_start_addition_date`"
                                  p-type="date"
                                  placeholder="วันที่ขึ้นทะเบียน/ตัดจำหน่าย"
                                  :value="fetch.start_addition_date"
                                  :format="vars.formatDate"
                                  :disabled="!(fetch.year)"
                                  @dateWasSelected="getValueAddiStDateModal" />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>ถึง *</strong>
              </label>
              <div class="col-lg-5 col-md-6 el_field">
                <el-form-item prop="end_addition_date"
                              ref="fetch_end_addition_date">
                  <datepicker-th  style="width: 100%;"
                                  class="el-input__inner style_icon_calendar"
                                  :name="`fetch_end_addition_date`"
                                  p-type="date"
                                  placeholder="ถึงวันที่ขึ้นทะเบียน/ตัดจำหน่าย"
                                  :value="fetch.end_addition_date"
                                  :format="vars.formatDate"
                                  :disabled="!(fetch.year)"
                                  @dateWasSelected="getValueAddiEnDateModal"
                                  :notBeforeDate="fetch.start_addition_date"
                                  :notAfterDate="fetch.disabled_addition_date_selected"  />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>กลุ่มของทรัพย์สิน</strong>
              </label>
              <div class="col-lg-5 col-md-6 el_field">
                <el-form-item prop="location_code"
                              ref="fetch_location_code">
                  <lov-asset-group  v-model="fetch.location_code"
                                    placeholder="กลุ่มของทรัพย์สิน"
                                    name="fetch_location_code"
                                    size=""
                                    :popperBody="false"
                                    @change-lov="getValueAssetGroupModal" />
                </el-form-item>
              </div>
            </div>
            <!-- <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>สถานะทรัพย์สิน</strong>
              </label>
              <div class="col-lg-5 col-md-6 el_field">
                <el-form-item prop="asset_status"
                              ref="fetch_asset_status">
                  <dropdown-status-asset  v-model="fetch.asset_status" 
                                          placeholder="สถานะทรัพย์สิน"
                                          size="" 
                                          name="fetch_asset_status"
                                          :popperBody="false"
                                          :disabled="false"
                                          @change-dropdown="getValueAssetStatusModal" />
                </el-form-item>
              </div>
            </div> -->
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
import lovAssetGroup from '../components/lov/assetGroup'
import moment from 'moment'
import dropdownStatusAsset from '../components/dropdown/statusAsset'
export default {
  name: 'ir-asset-increase-modal-fetch',
  data () {
    return {
      fetch: {
        year: '',
        start_budget_year_date: '',
        end_budget_year_date: '',
        policy_set_header_id_start: '',
        policy_set_header_id_end: '',
        start_calculate_date: '',
        end_calculate_date: '',
        disabled_addition_date_selected: '',
        start_addition_date: '',
        end_addition_date: '',
        location_code: '',
        asset_status: ''
      },
      rules: {
        year: [
          {required: true, message: 'กรุณาระบุปี', trigger: 'change'}
        ],
        start_calculate_date: [
          {required: true, message: 'กรุณาระบุวันที่คิดค่าเบี้ย', trigger: 'change'}
        ],
        end_calculate_date: [
          {required: true, message: 'กรุณาระบุถึงวันที่คิดค่าเบี้ย', trigger: 'change'}
        ],
        start_addition_date: [
          {required: true, message: 'กรุณาระบุวันที่ขึ้นทะเบียน/ตัดจำหน่าย', trigger: 'change'}
        ],
        end_addition_date: [
          {required: true, message: 'กรุณาระบุถึงวันที่ขึ้นทะเบียน/ตัดจำหน่าย', trigger: 'change'}
        ]
      },
      getTimeCalStDate: '',
      getTimeCalEnDate: '',
      getTimeAddiStDate: '',
      getTimeAddiEnDate: '',
      showLoading: false
    }
  },
  props: [
    'setYearCE',
    'vars',
    'covertFomatDateMoment',
    'setBudgetYearFromFieldStCalendar',
    'getDateByBudgetYear',
  ],
  computed: {
    checkCalculateDate () {
      let start = this.fetch.start_calculate_date
      let end = this.fetch.end_calculate_date
      if (start && end) {
        if (this.getTimeCalStDate <= this.getTimeCalEnDate) {
          return true
        }
        return false
      }
      return true
    },
    checkAdditionDate () {
      let start = this.fetch.start_addition_date
      let end = this.fetch.end_addition_date
      if (start && end) {
        if (this.getTimeAddiStDate <= this.getTimeAddiEnDate) {
          return true
        }
        return false
      }
      return true
    }
  },
  methods: {
    clickSearch () {
      this.$refs.form_asset_increase_fetch.validate((valid) => {
        if (valid) {
          if (this.reqDate()) {
            this.getDataRows()
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
        this.$refs.form_asset_increase_fetch.fields.find((f) => f.prop == nameProp).clearValidate()
      } else {
        this.$refs.form_asset_increase_fetch.validateField(nameProp)
      }
    },
    getDataRows () {
      this.showLoading = true
      let year = this.covertFomatDateMoment(this.fetch.year, 'year');
      let start_cal = this.covertFomatDateMoment(this.fetch.start_calculate_date, 'date');
      let end_cal = this.covertFomatDateMoment(this.fetch.end_calculate_date, 'date');
      let start_addi = this.covertFomatDateMoment(this.fetch.start_addition_date, 'date');
      let end_addi = this.covertFomatDateMoment(this.fetch.end_addition_date, 'date');
      let params = {
        year: this.setYearCE('year', year),
        program_code: 'IRP0004',
        policy_id_from: this.fetch.policy_set_header_id_start,
        policy_id_to: this.fetch.policy_set_header_id_end,
        str_cal: this.setYearCE('date', start_cal),
        end_cal: this.setYearCE('date', end_cal),
        str_ad: this.setYearCE('date', start_addi),
        end_ad: this.setYearCE('date', end_addi),
        location_code: this.fetch.location_code,
        asset_status: this.fetch.asset_status
      }
      axios.get(`/ir/ajax/asset/asset-adjust/fetch`, { params })
      .then(({data}) => {
        if (data.status == 'E') {
          swal("Warning", data.msg, "warning");
          // swal({
          //   title: "Warning",
          //   text: data.msg,
          //   type: "warning",
          //   showCancelButton: false,
          // });
          this.showLoading = false
        } else {
          this.showLoading = false
          this.$emit('fetch-table-header', data.data)
          $(`#modal_asset_increase_fetch`).modal('hide')
        }
        
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    resetFields () {
      this.$refs.form_asset_increase_fetch.resetFields()
      
      axios.get('/ir/ajax/lov/period-year').then(({data:response}) => {
        let period_year = (response.data.period_year).toString();
        if (period_year) {
          this.getValueYearModal(moment({'year': period_year}).toDate());
        }
      })
      .catch((error) => {
        swal("Error", error, "error")
      })
    },
    getValuePolicyStModal (value) {
      this.fetch.policy_set_header_id_start = value;
      this.fetch.policy_set_header_id_end = value;
    },
    getValuePolicyEnModal (value) {
      this.fetch.policy_set_header_id_end = value
    },
    getValueAssetGroupModal (obj) {
      this.fetch.location_code = obj.code
    },
    reqDate () {
      let _this = this;
      if (!this.checkCalculateDate && this.checkAdditionDate) {
        swal({
          title: "Warning",
          text: "ฟิลด์วันที่คิดค่าเบี้ยต้องน้อยกว่าหรือเท่ากับฟิลด์ถึงวันที่คิดค่าเบี้ย!",
          type: "warning",
        },
        function(isConfirm) {
          if (isConfirm) {
            _this.$refs.fetch_start_calculate_date.resetField()
            _this.$refs.fetch_end_calculate_date.resetField()
          }
        });
      } else if (!this.checkAdditionDate && this.checkCalculateDate) {
        swal({
          title: "Warning",
          text: "ฟิลด์วันที่ขึ้นทะเบียน/ตัดจำหน่ายต้องน้อยกว่าหรือเท่ากับฟิลด์ถึงวันที่ขึ้นทะเบียน/ตัดจำหน่าย!",
          type: "warning",
        },
        function(isConfirm) {
          if (isConfirm) {
            _this.$refs.fetch_start_addition_date.resetField()
            _this.$refs.fetch_end_addition_date.resetField()
          }
        });
      } else if (!this.checkCalculateDate && !this.checkAdditionDate) {
        swal({
          title: "Warning",
          text: "ฟิลด์วันที่คิดค่าเบี้ยต้องน้อยกว่าหรือเท่ากับฟิลด์ถึงวันที่คิดค่าเบี้ย!",
          type: "warning",
        },
        function(isConfirm) {
          if (isConfirm) {
            _this.$refs.fetch_start_calculate_date.resetField()
            _this.$refs.fetch_end_calculate_date.resetField()
          }
        });
      } else {
        return true
      }
    },
    getValueYearModal (date) {
      this.fetch.year = date;
      let dates = this.getDateByBudgetYear(date);
      this.fetch.start_budget_year_date = dates.start;
      this.fetch.end_budget_year_date = dates.end;
      this.validateNotElUi(date, 'year')
    },
    getValueCalStDateModal (date) {
      this.fetch.start_calculate_date = date;
      if (date && this.fetch.end_calculate_date) {
        if (date > this.fetch.end_calculate_date) {
        }
      }
      this.fetch.disabled_addition_date_selected = moment(moment({'year': date.getFullYear(), 'month': date.getMonth(), 'date': date.getDate()}).subtract(1, "days"), this.vars.formatDate).toDate();
      this.validateNotElUi(date, 'start_calculate_date');
      this.fetch.end_calculate_date = this.setBudgetYearFromFieldStCalendar(date);
      this.validateNotElUi(this.fetch.end_calculate_date, 'end_calculate_date');
    },
    getValueCalEnDateModal (date) {
      this.fetch.end_calculate_date = date;
      this.validateNotElUi(date, 'end_calculate_date')
    },
    getValueAddiStDateModal (date) {
      this.fetch.start_addition_date = date;
      if (date && this.fetch.end_addition_date) {
        if (date > this.fetch.end_addition_date) {
          this.fetch.end_addition_date = '';
          this.validateNotElUi(this.fetch.end_addition_date, 'end_addition_date')
        }
      }
      this.validateNotElUi(date, 'start_addition_date')
    },
    getValueAddiEnDateModal (date) {
      this.fetch.end_addition_date = date;
      this.validateNotElUi(date, 'end_addition_date')
    },
    getValueAssetStatusModal (value) {
      this.fetch.asset_status = value;
    }
  },
  components: {
    lovPolicySetHeaderId,
    lovAssetGroup,
    dropdownStatusAsset
  }
}
</script>
