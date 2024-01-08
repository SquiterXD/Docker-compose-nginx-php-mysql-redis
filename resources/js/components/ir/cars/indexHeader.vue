<template>
  <div>
    <el-form  
      ref="searchCars"
      :model="header"
      :loading='loading'>
      <div class="row">
        <div class="col-lg-6">
          <div class="row">
            <label class="col-lg-5 col-md-4 col-sm-12 col-xs-12 col-form-label lable_align">
              <strong>ปี</strong>
            </label>
            <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 align-item-center">
              <el-form-item prop="year">
                <datepicker-th  
                  :value='header.year'
                  v-model="header.year"
                  style="width: 100%;"
                  class="el-input__inner md:tw-mb-0 tw-mb-2"
                  name="input_date"
                  id="input_date"
                  placeholder="โปรดเลือกปี"
                  @dateWasSelected='receivedYear(...arguments)'
                  pType='year' />
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-lg-5 col-md-4 col-sm-12 col-xs-12 col-form-label lable_align">
              <strong>ทะเบียนรถยนต์</strong>
            </label>
            <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 align-item-center">
              <el-form-item>
                <!-- <lov-vehicle
                  v-model='header.license_plate'
                  @vehicle='receivedLicensePlate'/> -->
                  <lov-vehicle  v-model='header.vehicle'
                                :value='header.vehicle'
                                name='vehicle'
                                @vehicle='receivedLicensePlate'
                                :popperBody='false'
                                :paramsQuery='paramsQueryLicensePlate'/>
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
                  placeholder="ตั้งแต่รหัสหน่วยงาน"
                  attrName="department_from"
                  :set-data="header.start_department"
                  @change-lov="receivedStartDepartment"
                  @department="receivedStartDepartment" />
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-lg-5 col-md-4 col-sm-12 col-xs-12 col-form-label lable_align">
              <strong>สถานะ</strong>
            </label>
            <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 align-item-center">
              <el-form-item>
                <lov-status 
                  v-model='header.status'
                  placeholder='สถานะ'
                  @status='receivedStatus'/>
              </el-form-item>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="row">
            <label class="col-lg-4 col-md-3 col-sm-12 col-xs-12 col-form-label lable_align">
              <strong>ประเภทการต่ออายุ</strong>
            </label>
            <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 align-item-center">
              <el-form-item prop="renew_type">
                <lov-renew-typedesc 
                  v-model='header.renew_type'
                  @renewType="receivedRenewType"/>
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-lg-4 col-md-3 col-sm-12 col-xs-12 col-form-label lable_align">
              <strong>กลุ่ม</strong>
            </label>
            <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 align-item-center">
              <el-form-item>
                <lov-group  
                  v-model='header.group_code'
                  @groupType='receivedGroupType'/>
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
                  placeholder="ถึงรหัสหน่วยงาน"
                  attrName="department_to"
                  :set-data="header.end_department"
                  @change-lov="receivedEndDepartment"
                  @department="receivedEndDepartment" />
              </el-form-item>
            </div>
          </div>
        </div>
      </div>

      <div class="row align-items-center justify-content-end d-flex mr-2">
        <button type="button" class='btn btn-default m-1' @click='Search()'><i class='fa fa-search'></i> ค้นหา</button>
        <button type="button"
                class="btn btn-success"
                data-toggle="modal"
                :data-target="`#modal_stock_yearly_fetch`"
                @click="clickFetch()" >
          <i class="fa fa-database"></i> ดึงข้อมูล
        </button>
        <button type='button' class='btn btn-warning m-1' @click='Cancel()'><i class="fa fa-repeat"></i> รีเซต</button>
      </div>
    </el-form>

    <modal-fetch  ref="modal_fetch"
                  @fetch-table-header="fetchTableHeader"
                  :paramsQueryLicensePlate="paramsQueryLicensePlate"/>

  </div>
</template>


<script>
  import lovRenewTypedesc from './lovRenewTypedesc'
  import lovDepartment from './lovDepartment'
  import lovGroup from './lovGroup'
  import lovAssetStatus from './lovAssetStatus'
  import lovStatus from './lovStatus'
  import lovVehicle from './lovVehicle'
  import yearInput from '../components/calendar/yearInput'
  import modalFetch from './modalFetch'
  import moment from 'moment'

  export default {
    components: { lovRenewTypedesc, lovDepartment, lovGroup, lovAssetStatus, lovStatus, lovVehicle, yearInput, modalFetch},
    name: 'index-header-car',
    data() {
      return {
        header: {
          year: '',
          renew_type: '',
          group_code: '',
          license_plate: '',
          department_from: '',
          department_to: '',
          status: '',
        },
        oilTypeList: [],
        groupCodeList: [],
        statusList: [],
        loading: false,
        dateFormat: 'YYYY',
        showLoading: false
      }
    },
    props: ['paramsQueryLicensePlate'],
    methods: {
      receivedRenewType(renew) {
        const vm = this
        if (renew) vm.header.renew_type = renew.meaning
        else vm.header.renew_type = ''
      },
      receivedGroupType(group) {
        const vm = this
        if (group) vm.header.group_code = group
        else vm.header.group_code = ''
      },
      receivedLicensePlate(license) {
        const vm = this
        if (license) vm.header.license_plate = license.license_plate
        else vm.header.license_plate = ''
      },
      receivedStartDepartment(department) {
        const vm = this;
        vm.header.department_from = department.department_code;
      },
      receivedEndDepartment(department) {
        const vm = this;
        vm.header.department_to = department.department_code;
      },
      receivedStatus(status) {
        const vm = this
        if (status) vm.header.status = status
        else vm.header.status = ''
      },
      Search() {
        const vm = this
        vm.loading = true
        vm.$refs.searchCars.validate((valid) => {
          if (valid) {
            vm.getCars()
          } else {
            return false
          }
        })
      },
      Cancel() {
        window.location.reload()
      },
      getStYear(obj) {
        const vm = this
        vm.header.year = obj.value
      },
      checkValid(){
        const vm = this
        this.$emit('loading', true)
        axios.get('/ir/ajax/cars', {params: vm.header})
        .then(async ({data: response}) => {
           
          this.$emit('loading', false)
          vm.loading = false
          await this.$emit('dataSearch', [])
          await this.$emit('dataSearch', response.data)
        })
        .catch((error) => {
          vm.loading = false
          swal({
            title: "Error",
            text: error,
            type: "error",
            showCancelButton: false,
            showConfirmButton: true
          })
        });
      },
      getCars() {
        const vm = this
        this.$emit('loading', true)
        axios.get('/ir/ajax/cars', {params: vm.header})
        .then(async ({data: response}) => {
           
          this.$emit('loading', false)
          vm.loading = false
          await this.$emit('dataSearch', [])
          await this.$emit('dataSearch', response.data)
        })
        .catch((error) => {
          vm.loading = false
          swal({
            title: "Error",
            text: error,
            type: "error",
            showCancelButton: false,
            showConfirmButton: true
          })
        })
      },
      receivedYear(year) {
        const vm = this
        if (year) vm.header.year = moment(year).format(vm.dateFormat) != 'Invalid date' ? moment(year).format(vm.dateFormat) : ''
        else vm.header.year = ''
      },
      receivedAssetStatus(status) {
        const vm = this
        if (status) vm.header.status_asset = status
        else vm.header.status_asset = ''
      },
      clickFetch() {
        this.$refs.modal_fetch.resetFields()
        this.$emit('set-params-license-plate', {
          renew_type: null,
          license_plate: null,
          group: null,
        })
      },
      fetchTableHeader (dataRows) {
        this.$emit('fetch-show-table-header', dataRows.data)
      }
    },
    mounted(){
      //
    },
  }
</script>