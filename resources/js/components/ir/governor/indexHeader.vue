<template>
 <div>
  <el-form  :model="header"
            ref="search_governor"
            >
            <!-- :rules='rules' -->
    <div class="row">
      <div class="col-lg-6">
        <div class="row">
          <label class="col-lg-5 col-md-4 col-sm-12 col-xs-12 col-form-label lable_align">
            <strong>ปี</strong>
          </label>
          <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 align-item-center">
            <el-form-item prop="year">
                          <!-- :rules='rules.year' -->
              <datepicker-th  :value='header.year'
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
            <strong>เลขที่ใบแจ้งหนี้</strong>
          </label>
          <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 align-item-center">
            <el-form-item>
              <lov-invoice  v-model='header.invoice_type'
                            @invoice='receivedInvoiceType'
                            :fetchInvoice='fetchInvoice'/>
            </el-form-item>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="row">
          <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label lable_align">
            <strong>ประเภทกรมธรรม์</strong>
          </label>
          <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 align-item-center">
            <el-form-item>
              <lov-insurance  v-model='header.policy_type_code'
                              @policyType="receivedPolicyType"
                              :fetchPolicy='fetchPolicy'/>
            </el-form-item>
          </div>
        </div>
        <div class="row">
          <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label lable_align">
            <strong>สถานะ</strong>
          </label>
          <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 align-item-center">
            <el-form-item>
              <lov-status v-model='header.status'
                          placeholder='สถานะ'
                          @status='receivedStatus'/>
            </el-form-item>
          </div>
        </div>
      </div>
    </div>
    <div class="text-right el_field">
      <button type="button" class='btn btn-default m-1' @click='Search()'><i class='fa fa-search'></i> ค้นหา</button>
      <button type='button' class='btn btn-warning m-1' @click='Cancel()'><i class="fa fa-repeat"></i> รีเซต</button>
    </div>
   </el-form>
  </div>
</template>


<script>
  import yearInput from '../components/calendar/yearInput'
  import lovInsurance from './lovPolicyType'
  import lovInvoice from './lovInvoiceNumber'
  import lovStatus from './lovStatus'
  import moment from 'moment'

  export default {
    components: { lovInsurance, lovInvoice, lovStatus, yearInput },
    name: 'index-header-governor',
    data() {
      return {
        header: {
          year: '',
          policy_type_code: '',
          invoice_type: '',
          status: ''
        },
        oilTypeList: [],
        groupCodeList: [],
        statusList: [],
        rules: {
          year: [
            {required: true, message: 'กรุณาระบุปี', trigger: 'change'}
          ]
        },
        dateFormat: 'YYYY',
      }
    },
    methods: {
      receivedYear(year) {
        const vm = this 
        if (year) {
          vm.header.year = moment(year).format(vm.dateFormat)
          this.$refs.search_governor.fields.find((f) => f.prop == 'year').clearValidate()
        } else {
          vm.header.year = ''
          this.$refs.search_governor.validateField('year')
        }
      },
      receivedPolicyType(code) {
        const vm = this
        if (code) vm.header.policy_type_code = code
        else vm.header.policy_type_code = ''
      },
      receivedInvoiceType(invoice) {
        const vm = this
        if (invoice) vm.header.invoice_type = invoice
        else vm.header.invoice_type = ''
      },
      receivedStatus(status) {
        const vm = this
        if (status) vm.header.status = status
        else vm.header.status = ''
      },
      Search() {
        const vm = this
        // vm.$refs.search_governor.validate((valid) => {
        //   if (valid) {
            vm.getGovernor()
          // } else {
          //   return false
          // }
        // })
      },
      Cancel(){
        window.location.reload()
      },
      getGovernor() {
        const vm = this;
        vm.$emit('show-loading', true)
        axios.get('/ir/ajax/persons', {params: vm.header})
        .then(async({data: response}) => {
          await vm.$emit('show-loading', false)
          await vm.$emit('dataSearch', response.data)
          await vm.$emit('dataSearch', [])
          await vm.$emit('dataSearch', response.data)
          // await this.$emit('headerSearch', vm.header)
        })
        .catch((error) => {
          vm.$emit('show-loading', false)
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
    props: ['fetchInvoice','fetchPolicy']
    // created() {
    //   const vm = this
    //   vm.getGovernor()
    // }
  }
</script>