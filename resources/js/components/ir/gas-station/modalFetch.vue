<template>
  <div class="modal inmodal fade" :id="`modal_gas_station_fetch`" tabindex="-1" role="dialog"  aria-hidden="true" >
    <!-- data-backdrop="static" -->
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div v-loading="showLoading">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
          </button>
          <p class="modal-title text-left">การดึงข้อมูล</p>
        </div>
        <el-form  :model="fetch"
                  ref="gas_station_modal"
                  :rules="rules">
          <div class="modal-body">
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>ปี *</strong>
              </label>
              <div class="col-lg-5 col-md-6 el_field">
                <el-form-item prop="year"
                              :rules='rules.year'
                              ref='input_year'>
                  <datepicker-th  :value='fetch.year'
                                  v-model="fetch.year"
                                  style="width: 100%;"
                                  class="el-input__inner md:tw-mb-0 tw-mb-2"
                                  name="input_year"
                                  id="input_date"
                                  placeholder="โปรดเลือกปี"
                                  @dateWasSelected='receivedYear'
                                  pType='year'
                                  :popperBody='false'/>
                </el-form-item>
              </div>
            </div>

            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>ประเภทสถานีน้ำมัน</strong>
              </label>
              <div class="col-lg-5 col-md-6 el_field">
                <el-form-item prop="type_code"
                              ref='type_code'>
                  <lov-oil-type v-model='fetch.type_code'
                                :value='fetch.type_code'
                                name='type_code'
                                @oilType="receivedOilType"
                                :popperBody='false'/>
                </el-form-item>
              </div>
            </div>
            
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>กลุ่ม</strong>
              </label>
              <div class="col-lg-5 col-md-6 el_field">
                <el-form-item prop="group_code"
                              ref='group_code'>
                  <lov-group  v-model='fetch.group_code'
                              :value='fetch.group_code'
                              name='group'
                              @groupType='receivedGroupType'
                              :popperBody='false'/>
                </el-form-item>
              </div>
            </div>

            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>ตั้งแต่รหัสหน่วยงาน</strong>
              </label>
              <div class="col-lg-5 col-md-6 el_field">
                <el-form-item prop='department_from'
                              ref='department_from'>
                  <lov-department v-model='fetch.department_from'
                                  :value='fetch.department_from'
                                  placeholder='ตั้งแต่รหัสหน่วยงาน'
                                  name='department_from'
                                  @department='receivedStartDepartment'
                                  :popperBody='false'/>
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>ถึง</strong>
              </label>
              <div class="col-lg-5 col-md-6 el_field">
                <el-form-item prop='department_to'
                              ref='department_to'>
                  <lov-department v-model='fetch.department_to'
                                  :value='fetch.department_to'
                                  placeholder='ถึง'
                                  name='department_to'
                                  @department='receivedEndDepartment'
                                  :popperBody='false'/>
                </el-form-item>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-success" @click="clickSearch()" >
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
import moment from 'moment'
import lovOilType from './lovOilType'
import lovGroup from './lovGroup'
import lovDepartment from './lovDepartment'

export default {
  name: 'modal-fetch-gas-stations',
  data() {
    return {
      fetch: {
        year: '',
        type_code: '',
        group_code: '',
        department_from: '',
        department_to: '',
        status: ''
      },
      rules: {
        year: [{required: true, message: 'กรุณาระบุปี', trigger: 'change'}]
      },
      dateFormat: 'YYYY',
      showLoading: false
    }
  },
  methods: {
    resetFields () {
      this.$refs.gas_station_modal.resetFields();

        axios.get('/ir/ajax/lov/period-year').then(({data:response}) => {
           this.fetch.year = (response.data.period_year).toString();
        })
        .catch((error) => {
          swal("Error", error, "error")
        })
    },
    receivedYear(year) {
      const vm = this
      if (year) {
        vm.fetch.year = moment(year).format(vm.dateFormat)
        this.$refs.gas_station_modal.fields.find((f) => f.prop == 'year').clearValidate()
      } else {
        vm.fetch.year = ''
        this.$refs.gas_station_modal.validateField('year')
      }
    },
    receivedOilType(oil) {
      const vm = this
      vm.fetch.type_code = oil.type_code
    }, 
    receivedGroupType(group) {
      const vm = this
      vm.fetch.group_code = group
    },
    receivedStartDepartment(department) {
      const vm = this
      vm.fetch.department_from = department.department_code
    },
    receivedEndDepartment(department) {
      const vm = this
      vm.fetch.department_to = department.department_code
    },
    clickSearch () {
      this.$refs.gas_station_modal.validate((valid) => {
        if (valid) {
          this.checkFetch()
        } else {
          return false
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
        year: vm.fetch.year,
        type_code: vm.fetch.type_code,
        group_code: vm.fetch.group_code,
        department_from: vm.fetch.department_from,
        department_to: vm.fetch.department_to,
      }
      axios.get(`/ir/ajax/extend-gas-stations/check-fetch`, { params })
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
              vm.getDataRows();
              // axios.get(`/ir/ajax/asset/fetch`, { params })
              // .then(({data}) => {
              //   if (data.status == 'E') {
              //     swal("Warning", data.msg, "warning");
              //     vm.showLoading = false
              //   }else if (data.status == 'W') {
              //     swal({
              //       title: "Warning",
              //       text: data.msg,
              //       type: "warning",
              //       showCancelButton: false,
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
            }else{
              vm.showLoading = false;
            }
          });
        } else {
          vm.getDataRows();
        }
        // if(data.valid){
        //   vm.getDataRows();
        // }else {
        //   vm.showLoading = false
        //   swal("Error", data.msg, "error");
        // }
      })
      .catch((error) => {
        vm.showLoading = false
        swal("Error", error, "error");
      });
    },
    getDataRows () {
      const vm = this
      this.showLoading = true
      let params = {
        year: vm.fetch.year,
        type_code: vm.fetch.type_code,
        group_code: vm.fetch.group_code,
        department_from: vm.fetch.department_from,
        department_to: vm.fetch.department_to,
      }
      axios.get(`/ir/ajax/extend-gas-stations/fetch`, {params})
      .then(({data: response}) => {
        if (response.status == 'E') {
          swal("Warning", response.msg, "warning");
          vm.showLoading = false
        }else {
          // swal({
          //   title: "Success",
          //   text: "บันทึกสำเร็จ",
          //   type: "success",
          //   showCancelButton: false,
          //   closeOnConfirm: true
          // },
          // function (isConfirm) {
          //   if (isConfirm) {
              vm.showLoading = false
              vm.$emit('fetch-table-header', response.data)
              $(`#modal_gas_station_fetch`).modal('hide')
          //   }
          // });

          // vm.showLoading = false
          // this.$emit('fetch-table-header', response.data)
          // $(`#modal_gas_station_fetch`).modal('hide')
        }
      })
      .catch((error) => {
        swal({
          title: "Error",
          text: error,
          timer: 3000,
          type: "error",
          showCancelButton: false,
          showConfirmButton: false
        })
      })
    },
  },
  components: {
    lovOilType,
    lovGroup,
    lovDepartment
  }
}
</script>