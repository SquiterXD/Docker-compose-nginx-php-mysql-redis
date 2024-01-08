<template>
  <div v-loading="showLoading">
    <form id="comfirm-gl">
      <el-form  :model="index"
                :rules="rules" 
                ref="index_gl_invoice_interface" 
                label-width="120px" 
                class="demo-ruleForm">
        <div class="col-lg-11">
          <div class="row">
            <label class="col-md-5 col-form-label lable_align">
              <strong>เดือน *</strong>
            </label>
            <div class="col-xl-4 col-lg-5 col-md-6 el_field">
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
            </div>
          </div>
          <div class="row">
            <label class="col-md-5 col-form-label lable_align">
              <strong>ประเภทประกันภัย *</strong>
            </label>
            <div class="col-xl-4 col-lg-5 col-md-6 el_field">
              <el-form-item prop="interface_type">
                <lov-interface-type placeholder="ประเภทประกันภัย"
                                    name="interface_type"
                                    v-model="index.interface_type"
                                    size=""
                                    :popperBody="true"
                                    @change-lov="getValueInterfaceType" />
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-md-5 col-form-label lable_align">
              <strong>กลุ่ม *</strong>
            </label>
            <div class="col-xl-4 col-lg-5 col-md-6 el_field">
              <el-form-item prop="group_code">
                <lov-group-code placeholder="กลุ่ม"
                                          name="group_code"
                                          v-model="index.group_code"
                                          size=""
                                          @change-lov="getValueGroup" />
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
                    :disabled="disabledInterface">
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
  import lovPolicySetHeaderId from '../components/lov/policySetHeaderId'
  import lovGroupCode from '../components/lov/groupCode'
  import lovInterfaceType from './lovInterfaceType'
  import * as scripts from '../scripts'
  // import loading from '../components/loading.vue'
  import moment from 'moment'
  export default {
    name: 'ir-confirm-to-gl-index',
    data() {
      return {
        index: {
          period_name: moment(moment().add(543, 'years')).format('MM/YYYY'),
          interface_type: '',
          group_code: ''
        },
        rules: {
          period_name: [
            {required: true, message: 'กรุณาระบุเดือน', trigger: 'change'}
          ],
          interface_type: [
            {required: true, message: 'กรุณาระบุประเภทประกันภัย', trigger: 'change'}
          ],
          group_code: [
            {required: true, message: 'กรุณาระบุกลุ่ม', trigger: 'change'}
          ]
        },
        disabledInterface: true,
        funcs: scripts.funcs,
        vars: scripts.vars,
        showLoading: false
      };
    },
    methods: {
      clickPrintReport() {
        this.$refs.index_gl_invoice_interface.validate((valid) => {
          if (valid) {
            this.getReport()
            this.disabledInterface = false
          } else {
            return false;
          }
        })
      },
      clickInterface() {
        this.$refs.index_gl_invoice_interface.validate((valid) => {
          if (valid) {
            this.getInterface()
          } else {
            return false;
          }
        })
      },
      clickCancel() {
        this.$refs.index_gl_invoice_interface.validate((valid) => {
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
          this.$refs.index_gl_invoice_interface.fields.find((f) => f.prop == 'period_name').clearValidate()
        } else {
          this.index.period_name = ''
          this.$refs.index_gl_invoice_interface.validateField('period_name')
        }
      },
      getValueInterfaceType (obj) {
         
        this.index.interface_type = obj.code
      },
      getValueGroup (value) {
         
        this.index.group_code = value
      },
      getInterface () {
         
        this.showLoading = true
        let params = {
          period_name: this.funcs.setYearCE('month', this.index.period_name),
          type: this.index.interface_type,
          group_code: this.index.group_code,
          // program_code: 'IRP0014'
        }
        axios.get(`/ir/ajax/confirm-gl`, { params })
        .then(res => {
          this.showLoading = false;
          window.open(res.data.data.redirect_to_export, '_blank');
          swal({
            title: '<div class="mt-4"> Success </div>',
            text: '<span style="font-size: 16px; text-align: left;"> ทำการ Interface ข้อมูลเข้า GL เรียบร้อยแล้ว </span>',
            type: "success",
            html: true
          },
          function(isConfirm){
            if (isConfirm) {
              window.location.href = '/ir/confirm-to-gl'
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
          period_name: this.funcs.setYearCE('month', this.index.period_name),
          type: this.index.interface_type,
          group_code: this.index.group_code,
          // program_code: 'IRP0014'
        }
        axios.get(`/ir/ajax/confirm-gl/report`, { params })
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
      },
      getCancel () {
        var vm = this;
        swal({
          html: true,
          title: 'ยกเลิกรายการ Interface GL',
          text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการยกเลิกรายการ Interface GL ใช่หรือไม่? </span></h2>',
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
        this.showLoading = true;
        let params = {
          period_name: this.funcs.setYearCE('month', this.index.period_name),
          type: this.index.interface_type,
          group_code: this.index.group_code,
        }
        axios.get(`/ir/ajax/confirm-gl/cancel`, { params })
        .then(res => {
          this.showLoading = false;
          window.open(res.data.data.redirect_to_export, '_blank');
          swal({
            title: '<div class="mt-4"> Success </div>',
            text: '<span style="font-size: 16px; text-align: left;"> ยกเลิกรายการสำเร็จ </span>',
            type: "success",
            html: true
          },
          function(isConfirm){
            if (isConfirm) {
              window.location.href = '/ir/confirm-to-gl'
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
       window.location.href = '/ir/confirm-to-gl'
      },
    },
    components: {
      lovPolicySetHeaderId,
      lovInterfaceType,
      lovGroupCode,
    }
  }
</script>