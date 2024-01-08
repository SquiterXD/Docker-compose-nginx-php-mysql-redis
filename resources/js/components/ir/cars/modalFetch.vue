<template>
  <div class="modal inmodal fade" :id="`modal_stock_yearly_fetch`" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <!-- data-backdrop="static" -->
    <div class="modal-dialog modal-lg" style="padding-top: 0 !important;">
      <div class="modal-content">
        <div v-loading="showLoading">
         <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" :disabled="showLoading">
            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
          </button>
          <p class="modal-title text-left">การดึงข้อมูล</p>
        </div>
        <el-form  :model="fetch"
                  ref="cars_modal"
                  :rules="rules">
          <div class="modal-body">
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>ปี *</strong>
              </label>
              <div class="col-lg-5 col-md-6 el_field">
                <el-form-item prop="year"
                              :rules='rules.year'>
                  <datepicker-th  :value='fetch.year'
                                  v-model="fetch.year"
                                  style="width: 100%;"
                                  class="el-input__inner md:tw-mb-0 tw-mb-2"
                                  name="input_year"
                                  id="input_date"
                                  placeholder="โปรดเลือกปี"
                                  @dateWasSelected='receivedYear(...arguments)'
                                  pType='year'
                                  :popperBody='false'/>
                </el-form-item>
              </div>
            </div>

            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>ประเภทการต่ออายุ</strong>
              </label>
              <div class="col-lg-5 col-md-6 el_field">
                <el-form-item prop="renew_type"
                              ref='renew_type'>
                  <lov-renew-typedesc v-model='fetch.renew_type'
                                  :value='fetch.renew_type'
                                  name='renew_type'
                                  :sizeSmall='false'
                                  @renewType="receivedRenewType"
                                  :popperBody='false'/>
                </el-form-item>
              </div>
            </div>

            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>กลุ่ม</strong>
              </label>
              <div class="col-lg-5 col-md-6 el_field">
                <el-form-item prop="group"
                              ref='group'>
                  <lov-group  v-model='fetch.group'
                              :value='fetch.group'
                              name='group'
                              @groupType='receivedGroupType'
                              :popperBody='false'/>
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>ทะเบียนรถยนต์</strong>
              </label>
              <div class="col-lg-5 col-md-6 el_field">
                <el-form-item prop='vehicle'
                              ref='vehicle'>
                <lov-vehicle  v-model='fetch.vehicle'
                                :value='fetch.vehicle'
                                name='vehicle'
                                @vehicle='receivedLicensePlate'
                                :popperBody='false'
                                :paramsQuery='paramsQueryLicensePlate'/>
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
                                  :sizeSmall='false'
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
                                  :sizeSmall='false'
                                  name='department_to'
                                  @department='receivedEndDepartment'
                                  :popperBody='false'/>
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>ตั้งแต่วันที่สิ้นอายุประกัน</strong>
              </label>
              <div class="col-lg-5 col-md-6 el_field">
                <el-form-item prop='date_from'
                              ref='date_from'>
                    <datepicker-th  :value='fetch.date_from'
                                  v-model="fetch.date_from"
                                  style="width: 100%;"
                                  class="el-input__inner md:tw-mb-0 tw-mb-2"
                                  format='DD/MM/YYYY'
                                  placeholder="โปรดเลือกวันที่"
                                  pType="date"
                                  @dateWasSelected='receivedDatefrom'
                                  :popperBody='false'/>
                                  <!-- name="input_date_from"
                                  id="input_date_from" -->
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>ถึง</strong>
              </label>
              <div class="col-lg-5 col-md-6 el_field">
                <el-form-item prop='date_to'
                              ref='dete_to'>
                    <datepicker-th  :value='fetch.date_to'
                                  v-model="fetch.date_to"
                                  style="width: 100%;"
                                  class="el-input__inner md:tw-mb-0 tw-mb-2"
                                  format='DD/MM/YYYY'
                                  placeholder="โปรดเลือกวันที่"
                                  pType="date"
                                  @dateWasSelected='receivedDateto'
                                  :popperBody='false'/>
                                  <!-- name="input_date_to"
                                  id="input_date_to" -->
                </el-form-item>
              </div>
            </div>
            <!-- <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>สถานะทรัพย์สิน</strong>
              </label>
              <div class="col-lg-5 col-md-6 el_field">
                <el-form-item prop='status_asset'
                              ref='status_asset'>
                  <el-select  v-model="fetch.status_asset"
                              :value='fetch.status_asset'
                              placeholder="สถานะทรัพย์สิน"
                              name="status_asset"
                              class="w-100"
                              :clearable="true"
                              :popper-append-to-body="false">
                    <el-option label="Active" value="Y"></el-option>
                    <el-option label="Inactive" value="N"></el-option>
                  </el-select>
                </el-form-item>
              </div>
            </div> -->
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
  import lovRenewType from './lovRenewType'
  import lovRenewTypedesc from './lovRenewTypedesc'
  import lovGroup from './lovGroup'
  import lovVehicle from './lovVehicle'
  import lovDepartment from './lovDepartment'
  import moment from 'moment'

  export default {
    data () {
      return {
        fetch: {
          year: '',
          renew_type: '',
          group: '',
          vehicle: '',
          department_from: '',
          department_to: '',
          date_from:'',
          date_to:'',
          status_asset: '',
        },
        rules: {
          year: [{required: true, message: 'กรุณาระบุปี', trigger: 'change'}],
        },
        dateFormat: 'YYYY',
        // paramsQueryLicensePlate: {
        //   renew_type: null,
        //   license_plate: null,
        //   group: null,
        // },
        showLoading: false
      }
    },
    props: ['paramsQueryLicensePlate'],
    methods: {
      clickSearch () {
         
        this.$refs.cars_modal.validate((valid) => {
          if (valid) {
            this.getDataRows()
          } else {
            return false
          }
        })
      },
      clickClear () {
        this.resetFields()
      },
      getDataRows () {
        const vm = this
        vm.showLoading = true
        let params = {
          year: vm.fetch.year,
          renew_type: vm.fetch.renew_type,
          group_code: vm.fetch.group,
          license_plate: vm.fetch.vehicle, // vm.fetch.vehicle,
          department_from: vm.fetch.department_from,
          department_to: vm.fetch.department_to,
          asset_status: vm.fetch.status_asset,
          date_from: vm.fetch.date_from,
          date_to: vm.fetch.date_to,
        }
         
        axios.get(`/ir/ajax/cars/fetch`, {params})
        .then(({data: response}) => {
          vm.showLoading = false
          this.$emit('fetch-table-header', response.data)
          $(`#modal_stock_yearly_fetch`).modal('hide')
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
      resetFields () {
        this.$refs.cars_modal.resetFields()

        axios.get('/ir/ajax/lov/period-year').then(({data:response}) => {
           this.fetch.year = (response.data.period_year).toString();
        })
        .catch((error) => {
          swal("Error", error, "error")
        })
      },
      receivedDatefrom(datex) {
        if (datex) {
          this.fetch.date_from = moment(datex).format('DD/MM/YYYY')
          this.$refs.cars_modal.fields.find((f) => f.prop == 'date_from').clearValidate()
           
        } else {
          this.fetch.date_from = ''
          this.$refs.cars_modal.validateField('date_from')
        }

      },
      receivedDateto(datex) {
         if (datex) {
           this.fetch.date_to = moment(datex).format('DD/MM/YYYY')
           this.$refs.cars_modal.fields.find((f) => f.prop == 'date_to').clearValidate()
          //   
        } else {
          this.fetch.date_to = ''
          this.$refs.cars_modal.validateField('date_to')
        }
      },
      receivedYear(year) {
        const vm = this
        if (year) {
          vm.fetch.year = moment(year).format(vm.dateFormat)
          this.$refs.cars_modal.fields.find((f) => f.prop == 'year').clearValidate()
        } else {
          vm.fetch.year = ''
          this.$refs.cars_modal.validateField('year')
        }
      },
      receivedRenewType(renew) {
        const vm = this
         
        if (renew) {
          vm.fetch.renew_type = renew.meaning
          vm.paramsQueryLicensePlate.renew_type = renew.meaning
        } else {
          vm.fetch.renew_type = ''
          vm.paramsQueryLicensePlate.renew_type = ''
        }
      },
      receivedGroupType(group) {
        const vm = this
        if (group) {
          vm.fetch.group = group
          vm.paramsQueryLicensePlate.group = group
        } else {
          vm.fetch.group = ''
          vm.paramsQueryLicensePlate.group = ''
        }
      },
      receivedLicensePlate(value) {
        const vm = this
         
        if (value) vm.fetch.vehicle = value.license_plate
        else vm.fetch.vehicle = ''
      },
      receivedStartDepartment(department) {
        const vm = this
        if (department) vm.fetch.department_from = department.department_code
        else vm.fetch.department_from = ''
      },
      receivedEndDepartment(department) {
        const vm = this
        if (department) vm.fetch.department_to = department.department_code
        else vm.fetch.department_to = ''
      },
    },
    components: {
      lovRenewTypedesc,
      lovGroup,
      lovVehicle,
      lovDepartment
    }
  }
</script>
