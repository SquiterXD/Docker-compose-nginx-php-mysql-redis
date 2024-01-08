<template>
  <div>
    <el-form  :model="header"
              ref="searchGasStations"
              :loading='loading'>


      <div class="row">
        <div class="col-lg-6">
          <div class="row">
            <label class="col-md-4 col-form-label lable_align">
              <strong>ปี</strong>
            </label>
            <div class="col-xl-7 col-lg-8 col-md-8 el_field">
              <el-form-item>
                <datepicker-th  v-model="header.year"
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
            <label class="col-md-4 col-form-label lable_align">
              <strong>กลุ่ม</strong>
            </label>
            <div class="col-xl-7 col-lg-8 col-md-8 el_field">
              <el-form-item >
                <lov-group  v-model='header.group_code'
                            @groupType='receivedGroupType'/>
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-md-4 col-form-label lable_align">
              <strong>ตั้งแต่รหัสหน่วยงาน</strong>
            </label>
            <div class="col-xl-7 col-lg-8 col-md-8 el_field">
              <el-form-item>
                <lov-department v-model='header.start_department'
                                placeholder='ตั้งแต่รหัสหน่วยงาน'
                                @department='receivedStartDepartment'/>
              </el-form-item>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="row">
            <label class="col-md-4 col-form-label lable_align">
              <strong>ประเภทสถานีน้ำมัน</strong>
            </label>
            <div class="col-xl-7 col-lg-8 col-md-8 el_field">
              <el-form-item>
                <lov-oil-type v-model='header.type_code'
                              @oilType="receivedOilType"
                              placeholder='ประเภทสถานีน้ำมัน'/>
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-md-4 col-form-label lable_align">
              <strong>สถานะ</strong>
            </label>
            <div class="col-xl-7 col-lg-8 col-md-8 el_field">
              <el-form-item>
                <lov-status v-model='header.status'
                            placeholder='สถานะ'
                            @status='receivedStatus'/>
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-md-4 col-form-label lable_align">
              <strong>ถึง</strong>
            </label>
            <div class="col-xl-7 col-lg-8 col-md-8 el_field">
              <el-form-item>
              <lov-department v-model='header.end_department'
                              placeholder='ถึง'
                              @department='receivedEndDepartment'/>
              </el-form-item>
            </div>
          </div>
        </div>
      </div>

      <!-- ของเดิม -->
      <!-- <div class='row'>
        <div class="col-xl-7 col-lg-7 col-md-8 col-sm-12 col-xs-12 offset-md-2">
          <div class="form-group row">
            <label class="col-lg-5 col-md-4 col-sm-12 col-xs-12 col-form-label lable_align">
              <strong>ปี</strong>
            </label>
            <div class="col-lg-7 col-md-8 col-sm-12 col-xs-12 align-item-center">
              <el-form-item>
                <datepicker-th  v-model="header.year"
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
        </div>

        <div class="col-xl-7 col-lg-7 col-md-8 col-sm-12 col-xs-12 offset-md-2">
          <div class="form-group row">
            <label class="col-lg-5 col-md-4 col-sm-12 col-xs-12 col-form-label lable_align">
              <strong>ประเภทสถานีน้ำมัน</strong>
            </label>
            <div class="col-lg-7 col-md-8 col-sm-12 col-xs-12 align-item-center">
              <el-form-item>
                <lov-oil-type v-model='header.type_code'
                              @oilType="receivedOilType"
                              placeholder='ประเภทสถานีน้ำมัน'/>
              </el-form-item>
            </div>
          </div>
        </div>


        <div class="col-xl-7 col-lg-7 col-md-8 col-sm-12 col-xs-12 offset-md-2">
          <div class="form-group row">
            <label class="col-lg-5 col-md-4 col-sm-12 col-xs-12 col-form-label lable_align">
              <strong>กลุ่ม</strong>
            </label>
            <div class="col-lg-7 col-md-8 col-sm-12 col-xs-12 align-item-center">
              <el-form-item >
                <lov-group  v-model='header.group_code'
                            @groupType='receivedGroupType'/>
              </el-form-item>
            </div>
          </div>
        </div>

        <div class="col-xl-7 col-lg-7 col-md-8 col-sm-12 col-xs-12 offset-md-2">
          <div class="form-group row">
            <label class="col-lg-5 col-md-4 col-sm-12 col-xs-12 col-form-label lable_align">
              <strong>ตั้งแต่รหัสหน่วยงาน</strong>
            </label>
            <div class="col-lg-7 col-md-8 col-sm-12 col-xs-12 align-item-center">
              <el-form-item>
                <lov-department v-model='header.start_department'
                                placeholder='ตั้งแต่รหัสหน่วยงาน'
                                @department='receivedStartDepartment'/>
              </el-form-item>
            </div>
          </div>
        </div>


        <div class="col-xl-7 col-lg-7 col-md-8 col-sm-12 col-xs-12 offset-md-2">
          <div class="form-group row">
            <label class="col-lg-5 col-md-4 col-sm-12 col-xs-12 col-form-label lable_align">
              <strong>ถึง</strong>
            </label>
            <div class="col-lg-7 col-md-8 col-sm-12 col-xs-12 align-item-center">
              <el-form-item>
              <lov-department v-model='header.end_department'
                              placeholder='ถึง'
                              @department='receivedEndDepartment'/>
              </el-form-item>
            </div>
          </div>
        </div>


        <div class="col-xl-7 col-lg-7 col-md-8 col-sm-12 col-xs-12 offset-md-2">
          <div class="form-group row">
            <label class="col-lg-5 col-md-4 col-sm-12 col-xs-12 col-form-label lable_align">
              <strong>สถานะ</strong>
            </label>
            <div class="col-lg-7 col-md-8 col-sm-12 col-xs-12 align-item-center">
              <el-form-item>
                <lov-status v-model='header.status'
                            placeholder='สถานะ'
                            @status='receivedStatus'/>
              </el-form-item>
            </div>
          </div>
        </div>
      </div> -->


      <div class="row align-items-center justify-content-end d-flex mr-2">
        <button type="button" class='btn btn-default m-1' @click='Search()'><i class='fa fa-search'></i> ค้นหา</button>
        <button type="button"
                class="btn btn-success"
                data-toggle="modal"
                :data-target="`#modal_gas_station_fetch`"
                @click="clickFetch()" >
          <i class="fa fa-database"></i> ดึงข้อมูล
        </button>
        <button type='button' class='btn btn-warning m-1' @click='Cancel()'><i class="fa fa-repeat"></i> รีเซต</button>
      </div>
    </el-form>

    <modal-fetch  ref="modal_fetch"
                  @fetch-table-header="fetchTableHeader" />
  </div>
</template>


<script>

  import lovOilType from './lovOilType.vue'
  import lovDepartment from './lovDepartment'
  import lovGroup from './lovGroup'
  import lovStatus from './lovStatus'
  import yearInput from '../components/calendar/yearInput'
  import moment from 'moment'
  import modalFetch from './modalFetch'

  export default {
    components: {
      lovOilType,
      lovDepartment,
      lovGroup,
      lovStatus,
      yearInput,
      modalFetch
    },
    name: 'index-header-gas-station',
    data() {
      return {
        header: {
          year: '',
          type_code: '',
          group_code: '',
          department_from: '',
          department_to: '',
          status: ''
        },
        oilTypeList: [],
        groupCodeList: [],
        statusList: [],
        loading: false,
        dateFormat: 'YYYY',
        showLoading: false
      }
    },
    methods: {
      receivedOilType(oilType) {
        const vm = this
        if (oilType) vm.header.type_code = oilType.type_code
        else vm.header.type_code = ''
      },
      receivedGroupType(group) {
        const vm = this
        if (group) vm.header.group_code = group
        else vm.header.group_code = ''
      },
      receivedStartDepartment(department) {
        const vm = this
        if (department) vm.header.department_from = department.department_code
        else vm.header.department_from = ''
      },
      receivedEndDepartment(department) {
        const vm = this
        if (department) vm.header.department_to = department.department_code
        else vm.header.department_to = ''
      },
      receivedStatus(status) {
        const vm = this
        if (status) vm.header.status = status
        else vm.header.status = ''
      },
      Search() {
        const vm = this
        // vm.$refs.searchGasStations.validate((valid) => {
        //   if (valid) {
        vm.getGasStations()
        //   } else {
        //     return false;
        //   }
        // })
      },
      Cancel(){
        window.location.reload()
      },
      getStYear(obj) {
        const vm = this
        vm.header.year = obj.value
      },
      getGasStations() {
        const vm = this
        vm.$emit('show-loading', true)
        axios.get('/ir/ajax/extend-gas-stations', {params: vm.header})
        .then(async({data: response}) => {
          await vm.$emit('show-loading', false)
          await this.$emit('dataSearch', [])
          await this.$emit('dataSearch', response.data)
        })
        .catch((error) => {
          vm.$emit('show-loading', false)
          swal({
            title: "Error",
            text: error,
            type: "error",
            showCancelButton: false,
            showConfirmButton: false
          })
        })
      },
      receivedYear(year) {
        const vm = this
        vm.header.year = moment(year).format(vm.dateFormat) != 'Invalid date' ? moment(year).format(vm.dateFormat) : ''
      },
      fetchTableHeader (dataRows) {
        this.$emit('fetch-show-table-header', dataRows)
      },
      clickFetch() {
        this.$refs.modal_fetch.resetFields()
      },
    },
  }
</script>