<template>
  <div>
    <form id="comfirm-ar">
      <el-form v-loading="showLoading" :model="index"
                :rules="rules" 
                ref="index_ar_invoice_interface" 
                label-width="120px" 
                class="demo-ruleForm">
        <div class="col-lg-11">
          <div class="row">
            <label class="col-md-5 col-form-label lable_align">
              <strong>ปี *</strong>
            </label>
            <div class="col-xl-4 col-lg-5 col-md-6 el_field">
              <el-form-item prop="interface_year"
                            ref="interface_year"
                            style="margin-bottom: 0px;">
                <datepicker-th  style="width: 100%;"
                                class="el-input__inner"
                                name="interface_year"
                                id="interface_year"
                                p-type="year"
                                placeholder="ปี"
                                v-model="index.interface_year"
                                :format="vars.formatYear"
                                @dateWasSelected="getValueInterfaceYear" />
              </el-form-item>
              <span class="text-danger" style="font-size: 12px;"> ** กรณีเคลมประกัน ให้ระบุปีที่เกิดเหตุ </span> <br>
              <span class="text-danger" style="font-size: 12px;"> ** กรณีเรียกเก็บ ให้ระบุปีงบประมาณ </span>
            </div>
          </div>
          <br>
          <div class="row">
            <label class="col-md-5 col-form-label lable_align">
              <strong>ประเภท *</strong>
            </label>
            <!-- <div class="col-xl-4 col-lg-5 col-md-6 el_field">
              <el-form-item prop="period_name"
                            ref="period_name">
                <datepicker-th  style="width: 100%;"
                                class="el-input__inner"
                                name="period_name"
                                id="period_name"
                                p-type="month"
                                placeholder="เดือน"
                                v-model="index.period_name"
                                :format="vars.formatMonth"
                                @dateWasSelected="getValuePeriodName" />
              </el-form-item>
            </div> -->
             <div class="col-xl-4 col-lg-5 col-md-6 el_field">
              <el-form-item prop="ar_interface"
                            ref="ar_interface">
                <lov-ap-interface  placeholder="ประเภท"
                                  name="ar_interface"
                                  v-model="index.ar_interface"
                                  :popperBody="true"
                                  @change-lov="getValueArInterface" />
              </el-form-item>
            </div>
          </div>
          <div class="row" v-show="ApClaim">
            <label class="col-md-5 col-form-label lable_align">
              <strong>เลขที่เอกสาร</strong>
            </label>
            <div class="col-xl-4 col-lg-5 col-md-6 el_field">
              <el-form-item prop="document_number">
                <lov-document-number placeholder="เลขที่เอกสาร"
                                    name="document_number"
                                    v-model="index.document_number"
                                    :popperBody="true"
                                    @change-lov="getValueDocumentNumber" />
              </el-form-item>
            </div>
          </div>
        </div>
        <div class="text-right el_field">
          <el-form-item>
            <button type="button" class="btn btn-info" @click="clickPrintReport()">
              <i class="fa fa-print"></i> พิมพ์รายงาน
            </button>
            <button type="button" 
                    class="btn btn-primary"
                    @click="clickInterface()"
                    :disabled="disabledInterface || index.document_status == 'INTERFACE'">
                    <!-- v-loading.fullscreen.lock="showLoading" -->
              <i class="fa fa-exchange"></i> ส่ง Interface
            </button>
            <button type="button" 
                    class="btn btn-danger" 
                    @click="clickCancel()">
              <i class="fa fa-times"></i> ยกเลิก
            </button>
            <button type="button" class="btn btn-warning"  @click="clickClear()">
                  <i class="fa fa-repeat"></i>
                  รีเซต
            </button>
          </el-form-item>
        </div>
      </el-form>
    </form>
  </div>
</template>

<script>
  import lovDocumentNumber from './lovDocumentNumber'
  import lovApInterface from './lovApInterface'
  import moment from 'moment'
  import * as scripts from '../scripts'
  export default {
    name: 'ir-confirm-to-ar-index',
    data() {
      return {
        ApClaim: false,
        rules: {
          interface_year: [
            {required: true, message: 'กรุณาระบุปี', trigger: 'change'}
          ],
          period_name: [
            {required: true, message: 'กรุณาระบุประเภท', trigger: 'change'}
          ]
        },
        index: {
          period_name: moment(moment().add(543, 'years')).format('MM/YYYY'),
          document_number: '',
          document_status: '',
          interface_year: ''
        },
        disabledInterface: true,
        funcs: scripts.funcs,
        vars: scripts.vars,
        showLoading: false
      }
    },
    methods: {
      clickPrintReport() {
        this.$refs.index_ar_invoice_interface.validate((valid) => {
          if (valid) {
            this.getReport();
            // this.disabledInterface = false
          } else {
            return false;
          }
        })
      },
      clickInterface() {
        this.$refs.index_ar_invoice_interface.validate((valid) => {
          if (valid) {
            this.getInterface()
          } else {
            return false;
          }
        })
      },
      clickCancel() {
        this.$refs.index_ar_invoice_interface.validate((valid) => {
          if (valid) {
            this.getCancel()
          } else {
            return false;
          }
        })
      },
      getValuePeriodName (date) {
        let formatMonth = this.vars.formatMonth
        if (date) {
          this.index.period_name = moment(date).format(formatMonth)
          this.$refs.index_ar_invoice_interface.fields.find((f) => f.prop == 'ar_interface').clearValidate()
        } else {
          this.index.period_name = ''
          this.$refs.index_ar_invoice_interface.validateField('period_name')
        }
      },
      getValueDocumentNumber (res) {
        this.index.document_number = res.value;
        // Piyawut A. 22012022
        this.index.document_status = res.status;
      },
      getValueArInterface (value) {
        this.ApClaim = value === 'IRP0010' 
        this.index.ar_interface = value
        // if (value) {
        //   this.index.ar_interface = value
        //   this.$refs.index_ar_invoice_interface.fields.find((f) => f.prop == 'ar_interface').clearValidate()
        // } else {
        //   this.index.ar_interface = ''
        //   this.$refs.index_ar_invoice_interface.validateField('ar_interface')
        // }
      },
      getInterface () {
        this.showLoading = true
        let params = {
          month: this.funcs.setYearCE('month', this.index.period_name),
          claim_header_id: this.index.document_number,
          interface_type_code: this.index.ar_interface,
          interface_year: this.index.interface_year
          // document_number: this.index.document_number
          // program_code: 'IRP0015'
        }
        axios.get(`/ir/ajax/confirm-ar`, { params })
        .then(res => {
          this.showLoading = false;
          window.open(res.data.data.redirect_to_export, '_blank');
          swal({
            title: '<div class="mt-4"> Success </div>',
            text: '<span style="font-size: 16px; text-align: left;"> ทำการ Interface ข้อมูลเข้า AR เรียบร้อยแล้ว </span>',
            type: "success",
            html: true
          },
          function(isConfirm){
            if (isConfirm) {
              window.location.href = '/ir/confirm-to-ar'
            }
          });
        })
        .catch((error) => {
          this.showLoading = false
          swal({
            title: '<div class="mt-4"> Warning </div>',
            text: '<span style="font-size: 16px; text-align: left;">'+error.response.data.message.msg+'</span>',
            type: "warning",
            html: true
          });
          this.disabledInterface = true;
        })
      },
      getReport () {
        this.showLoading = true;
        let params = {
          month: this.funcs.setYearCE('month', this.index.period_name),
          claim_header_id: this.index.document_number,
          interface_type_code: this.index.ar_interface,
          interface_year: this.index.interface_year
        }
        axios.get(`/ir/ajax/confirm-ar/report`, { params })
        .then(res => {
          this.showLoading = false;
          window.open(res.data.data.redirect_to_export, '_blank');
        })
        .catch((error) => {
          swal({
            title: '<div class="mt-4"> Warning </div>',
            text: '<span style="font-size: 16px; text-align: left;">'+error.response.data.message.msg+'</span>',
            type: "warning",
            html: true
          });
          this.disabledInterface = true;
          this.showLoading = false;
        })
        .then(() => {
          this.disabledInterface = false;
          this.showLoading = false;
        });
      },
      getCancel () {
        var vm = this;
        swal({
          html: true,
          title: 'ยกเลิกรายการ Interface AR',
          text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการยกเลิกรายการ Interface AR ใช่หรือไม่? </span></h2>',
          showCancelButton: true,
          confirmButtonText: 'ตกลง',
          cancelButtonText: 'ยกเลิก',
          confirmButtonClass: '#1ab394',
          cancelButtonClass: '#e7eaec',
          confirmButtonClass: 'btn btn-primary btn-lg tw-w-25',
          cancelButtonClass: 'btn btn-danger btn-lg tw-w-25',
          closeOnConfirm: false,
          closeOnCancel: true,
          showLoaderOnConfirm: true
        },
        async function(isConfirm){
          if (isConfirm) {
            vm.cancel();
          }
        });
      },
      cancel(){
        this.showLoading = true
        let params = {
          month: this.funcs.setYearCE('month', this.index.period_name),
          claim_header_id: this.index.document_number,
          interface_type_code: this.index.ar_interface,
          interface_year: this.index.interface_year
        }
        axios.get(`/ir/ajax/confirm-ar/cancel`, { params })
        .then(res => {
          this.showLoading = false;
          // window.open(res.data.data.redirect_to_export, '_blank');
          swal({
            title: '<div class="mt-4"> Success </div>',
            text: '<span style="font-size: 16px; text-align: left;"> ยกเลิกรายการสำเร็จ </span>',
            type: "success",
            html: true
          },
          function(isConfirm){
            if (isConfirm) {
              window.location.href = '/ir/confirm-to-ar'
            }
          });
        })
        .catch((error) => {
          this.showLoading = false
          swal({
            title: '<div class="mt-4"> Warning </div>',
            text: '<span style="font-size: 16px; text-align: left;">'+error.response.data.message.msg+'</span>',
            type: "warning",
            html: true
          });
          this.disabledInterface = true;
        })
      },
      clickClear () {
        window.location.href = '/ir/confirm-to-ar'
      },
      getValueInterfaceYear (date) {
        console.log('getValueInterfaceYear ', date, this.index.interface_year)
        let formatYear = this.vars.formatYear
        if (date) {
          this.index.interface_year = moment(date).format(formatYear)
          this.$refs.index_ar_invoice_interface.fields.find((f) => f.prop == 'interface_year').clearValidate()
        } else {
          this.$refs.interface_year.resetField()
          this.$refs.index_ar_invoice_interface.validateField('interface_year')
        }
      },
    },
    components: {
      lovDocumentNumber,
      lovApInterface,
      // loading
    }
  }
</script>