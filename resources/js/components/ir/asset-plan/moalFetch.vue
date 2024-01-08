<template>
  <div class="modal inmodal fade" :id="`modal_asset_plan_fetch`" tabindex="-1" role="dialog"  aria-hidden="true" >
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
                  ref="form_asset_plan_fetch" 
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
                <strong>วันที่คุ้มครอง</strong>
              </label>
              <div class="col-lg-5 col-md-6 el_field">
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
              <div class="col-lg-5 col-md-6 el_field">
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
                <strong>ณ วันที่ *</strong>
              </label>
              <div class="col-lg-5 col-md-6 el_field">
                <el-form-item prop="as_of_date"
                              ref="fetch_as_of_date">
                  <datepicker-th  style="width: 100%;"
                                  class="el-input__inner"
                                  :name="`fetch_as_of_date`"
                                  p-type="date"
                                  placeholder="ณ วันที่"
                                  :value="fetch.as_of_date"
                                  :format="vars.formatDate"
                                  @dateWasSelected="getValueAsOfDateModal" />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>กลุ่มของทรัพย์สิน</strong>
              </label>
              <div class="col-lg-5 col-md-6 el_field">
                <el-form-item prop="asset_group"
                              ref="fetch_asset_group">
                  <lov-asset-group  v-model="fetch.asset_group"
                                    placeholder="กลุ่มของทรัพย์สิน"
                                    name="fetch_asset_group"
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
import dateInput from '../components/calendar/dateInput'
import lovAssetGroup from '../components/lov/assetGroup'
import moment from 'moment'
import dropdownStatusAsset from '../components/dropdown/statusAsset'
export default {
  name: 'ir-asset-plan-modal-fetch',
  data () {
    return {
      fetch: {
        year: '',
        insurance_start_date: '',
        insurance_end_date: '',
        policy_set_header_id_start: '',
        policy_set_header_id_end: '',
        as_of_date: '',
        asset_group: '',
        asset_status: ''
      },
      rules: {
        year: [
          {required: true, message: 'กรุณาระบุปี', trigger: 'change'}
        ],
        as_of_date: [
          {required: true, message: 'กรุณาระบุ ณ วันที่', trigger: 'change'}
        ]
      },
      showLoading: false
    }
  },
  props: [
    'setYearCE',
    'vars'
  ],
  methods: {
    clickSearch () {
      this.$refs.form_asset_plan_fetch.validate((valid) => {
        if (valid) {
          this.getDataRows()
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
        this.$refs.form_asset_plan_fetch.fields.find((f) => f.prop == nameProp).clearValidate()
      } else {
        this.$refs.form_asset_plan_fetch.validateField(nameProp)
      }
    },
    getDataRows () {
      var vm = this;
      vm.showLoading = true
      let params = {
        year: this.setYearCE('year', vm.fetch.year),
        insurance_start_date: vm.setYearCE('date', vm.fetch.insurance_start_date),
        insurance_end_date: vm.setYearCE('date', vm.fetch.insurance_end_date),
        program_code: 'IRP0003',
        policy_set_header_start: vm.fetch.policy_set_header_id_start,
        policy_set_header_end: vm.fetch.policy_set_header_id_end,
        as_of_date: vm.setYearCE('date', vm.fetch.as_of_date),
        asset_group: vm.fetch.asset_group,
        asset_status: vm.fetch.asset_status
      }
      // W. 29/06/22 เพิ่ม call check duplicate
      
      axios.get(`/ir/ajax/asset/check-duplicate`, { params })
      .then(({data}) => {
        if (data.status == 'E') {
          swal("Warning", data.msg, "warning");

          vm.showLoading = false
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
              axios.get(`/ir/ajax/asset/fetch`, { params })
              .then(({data}) => {
                if (data.status == 'E') {
                  swal("Warning", data.msg, "warning");
                  vm.showLoading = false
                }else if (data.status == 'W') {
                  swal({
                    title: "Warning",
                    text: data.msg,
                    type: "warning",
                    showCancelButton: false,
                  },
                  function (isConfirm) {
                    if (isConfirm) {
                      vm.showLoading = false
                      vm.$emit('fetch-table-header', data.data)
                      $(`#modal_asset_plan_fetch`).modal('hide')
                    }
                  });
                } else {
                  vm.showLoading = false
                  vm.$emit('fetch-table-header', data.data)
                  $(`#modal_asset_plan_fetch`).modal('hide')
                }
                
              })
              .catch((error) => {
                swal({
                      title: "Warning",
                      text: "รายการนี้ถูกดึงข้อมูลเรียบร้อยแล้ว",
                      type: "warning",
                      showCancelButton: true,
                });
                  vm.showLoading = false
              })
            }else{
              vm.showLoading = false;
            }
          });
        } else {
          axios.get(`/ir/ajax/asset/fetch`, { params })
          .then(({data}) => {
            if (data.status == 'E') {
              swal("Warning", data.msg, "warning");
              vm.showLoading = false
            }else if (data.status == 'W') {
              swal({
                title: "Warning",
                text: data.msg,
                type: "warning",
                showCancelButton: false,
              },
              function (isConfirm) {
                if (isConfirm) {
                  vm.showLoading = false
                  vm.$emit('fetch-table-header', data.data)
                  $(`#modal_asset_plan_fetch`).modal('hide')
                }
              });
            } else {
              vm.showLoading = false
              vm.$emit('fetch-table-header', data.data)
              $(`#modal_asset_plan_fetch`).modal('hide')
            }
            
          })
          .catch((error) => {
            swal({
                  title: "Warning",
                  text: "รายการนี้ถูกดึงข้อมูลเรียบร้อยแล้ว",
                  type: "warning",
                  showCancelButton: true,
            });
              vm.showLoading = false
          })
        }
        
      })
      .catch((error) => {
        swal({
              title: "Warning",
              text: "รายการนี้ถูกดึงข้อมูลเรียบร้อยแล้ว",
              type: "warning",
              showCancelButton: true,
        });
          vm.showLoading = false
      })



      // --- end ---

      // axios.get(`/ir/ajax/asset/fetch`, { params })
      // .then(({data}) => {
      //   if (data.status == 'E') {
      //     swal("Warning", data.msg, "warning");
      //     // swal({
      //     //   title: "Warning",
      //     //   text: data.msg,
      //     //   type: "warning",
      //     //   showCancelButton: false,
      //     // });
      //     vm.showLoading = false
      //   }else if (data.status == 'W') {
      //     swal({
      //       title: "Warning",
      //       text: data.msg,
      //       type: "warning",
      //       showCancelButton: false,
      //       // closeOnConfirm: false
      //     },
      //     function (isConfirm) {
      //       if (isConfirm) {
      //         vm.showLoading = false
      //         vm.$emit('fetch-table-header', data.data)
      //         $(`#modal_asset_plan_fetch`).modal('hide')
      //       }
      //     });
      //   } else {
      //     vm.showLoading = false
      //     vm.$emit('fetch-table-header', data.data)
      //     $(`#modal_asset_plan_fetch`).modal('hide')
      //   }
        
      // })
      // .catch((error) => {
      //   swal({
      //         title: "Warning",
      //         text: "รายการนี้ถูกดึงข้อมูลเรียบร้อยแล้ว",
      //         type: "warning",
      //         showCancelButton: true,
      //   });
      //     vm.showLoading = false
      // })
    },
    getDataInsuranceDate () {
      let params = {
        year: this.setYearCE('year', this.fetch.year),
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
      this.$refs.form_asset_plan_fetch.resetFields()

      axios.get('/ir/ajax/lov/period-year').then(({data:response}) => {
        this.fetch.year = (response.data.period_year).toString();

        if (this.fetch.year) {
          this.getValueYearModal(this.fetch.year);
        }
      })
      .catch((error) => {
        swal("Error", error, "error")
      })
    },
    getValuePolicyStModal (value) {
      this.fetch.policy_set_header_id_start = value
      this.fetch.policy_set_header_id_end = value;
    },
    getValuePolicyEnModal (value) {
      this.fetch.policy_set_header_id_end = value
    },
    getValueAssetGroupModal (obj) {
      this.fetch.asset_group = obj.code
    },
    getValueYearModal (date) {
      let formatYear = this.vars.formatYear
      if (date) {
        this.fetch.year = moment(date).format(formatYear)
      } else {
        this.fetch.year = '';
        this.$refs.fetch_insurance_start_date.resetField()
        this.$refs.fetch_insurance_end_date.resetField()
      }
      this.validateNotElUi(date, 'year')
      this.getDataInsuranceDate();
    },
    getValueAsOfDateModal (date) {
      let formatDate = this.vars.formatDate
      if (date) {
        this.fetch.as_of_date = moment(date).format(formatDate)
      } else {
        this.$refs.fetch_as_of_date.resetField()
      }
      this.validateNotElUi(date, 'as_of_date')
    },
    getValueAssetStatusModal (value) {
      this.fetch.asset_status = value;
    }
  },
  components: {
    lovPolicySetHeaderId,
    dateInput,
    lovAssetGroup,
    dropdownStatusAsset
  }
}
</script>
