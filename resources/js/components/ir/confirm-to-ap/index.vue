<template>
  <div v-loading="showLoading">
    <form id="comfirm-ap">
      <el-form  :model="index"
                :rules="rules" 
                ref="index_ap_invoice_interface" 
                label-width="120px" 
                class="demo-ruleForm">
        <div class="col-lg-11">
          <div class="row">
            <label class="col-md-5 col-form-label lable_align">
              <strong>ปี *</strong>
            </label>
            <div class="col-xl-4 col-lg-5 col-md-6 el_field">
              <el-form-item prop="interface_year"
                            ref="interface_year">
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
            </div>
          </div>
          <div class="row">
            <label class="col-md-5 col-form-label lable_align">
              <strong>ประเภท *</strong>
            </label>
            <div class="col-xl-4 col-lg-5 col-md-6 el_field">
              <el-form-item prop="interface_type">
                <lov-interface-type placeholder="ประเภท"
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
              <strong>วันที่ใบแจ้งหนี้ *</strong>
            </label>
            <div class="col-xl-4 col-lg-5 col-md-6 el_field">
              <el-form-item prop="invoice_date"
                            ref="invoice_date">
                <datepicker-th  style="width: 100%;"
                                class="el-input__inner"
                                name="invoice_date"
                                id="input_date"
                                p-type="date"
                                placeholder="วันที่ใบแจ้งหนี้"
                                v-model="index.invoice_date"
                                :format="vars.formatDate"
                                @dateWasSelected="changeInvoiceDate" />
              </el-form-item>
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-md-5 col-form-label lable_align">
              <strong>Invoice Batch </strong>
            </label>
            <div class="col-xl-4 col-lg-5 col-md-6">
                <el-input placeholder="Invoice Batch" 
                          v-model="index.invoice_batch"
                          clearable
                          ref="invoice_batch"/>
              <div class="tw-font-bold" style="font-size: 12px; color: #8d8d8d;">
                Invoice Batch : ระบุเฉพาะกรณีส่ง Interface AP
              </div>
              <div id="el_explode_invoice_batch" class="error_msg text-left" style="font-size: 12px;"></div>
            </div>
          </div>

          <!-- Piyawut A. fix issue UAT Case Cancel 20211112 -->
          <div class="row mb-4">
            <label class="col-md-5 col-form-label lable_align">
              <strong> Group ID </strong>
            </label>
            <div class="col-xl-4 col-lg-5 col-md-6 el_field">
              <el-select v-model="index.group_id" filterable clearable placeholder="Group ID" ref="group_id">
                <el-option
                  v-for="(group, index) in groupId"
                  :key="index"
                  :label="group.group_id"
                  :value="group.group_id">
                </el-option>
              </el-select>
              <div class="tw-font-bold" style="font-size: 12px; color: #8d8d8d;">
                Group ID : ระบุเฉพาะกรณียกเลิก Interface AP
              </div>
              <div id="el_explode_group_id" class="error_msg text-left" style="font-size: 12px;"></div>
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
                    :disabled="disabledInterface"
                    >
              <i class="fa fa-exchange"></i> ส่ง Interface
            </button>
            <button type="button" 
                    class="btn btn-danger"  
                    @click="clickCancel()"
                    >
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
  import yearInput from '../components/calendar/yearInput'
  import lovInterfaceType from './lovInterfaceType'
  import moment from 'moment'
  // import loading from '../components/loading.vue'
  import * as scripts from '../scripts'
  export default {
    name: 'ir-confirm-to-ap-index',
    data() {
      return {
        index: {
          interface_year: '',
          interface_type: '',
          invoice_date: '',
          invoice_batch: '',
          group_id: '',
        },
        vars: scripts.vars,
        rules: {
          interface_year: [
            {required: true, message: 'กรุณาระบุปี', trigger: 'change'}
          ],
          interface_type: [
            {required: true, message: 'กรุณาระบุประเภท', trigger: 'change'}
          ],
          invoice_date: [
            {required: true, message: 'กรุณาระบุวันที่ใบแจ้งหนี้', trigger: 'change'}
          ],
          // invoice_batch: [
          //   {required: true, message: 'กรุณาระบุ Invoice Batch', trigger: 'change'}
          // ],
          // group_id: [
          //   {required: true, message: 'กรุณาระบุ Group ID', trigger: 'change'}
          // ]
        },
        funcs: scripts.funcs,
        disabledInterface: true,
        showLoading: false,
        groupId: [],
        errors: {
          invoice_batch: false,
          group_id: false,
        },
      };
    },
    mounted() {
      this.convertDateThai();
    },
    watch: {
      errors: {
        handler(val){
          val.invoice_batch? this.setError('invoice_batch') : this.resetError('invoice_batch');
          val.group_id? this.setError('group_id') : this.resetError('group_id');
        },
        deep: true,
      },
    },
    methods: {
      clickPrintReport() {
        let form = $('#comfirm-ap');
        let valid_input = true;
        let errorMsg = '';
        let vm = this;
        vm.errors.invoice_batch = false;
        vm.errors.group_id = false;
        $(form).find("div[id='el_explode_invoice_batch']").html("");
        $(form).find("div[id='el_explode_group_id']").html("");
        vm.$refs.index_ap_invoice_interface.validate((valid) => {
          if (valid) {
            vm.getReport()
            vm.disabledInterface = false
          } else {
            return false;
          }
        })
        if (vm.index.invoice_batch == ''){
          vm.errors.invoice_batch = true;
          valid_input = false;
          errorMsg = "กรุณาระบุ Invoice Batch";
          $(form).find("div[id='el_explode_invoice_batch']").html(errorMsg);
        }
        if (!valid_input) { return; }
      },
      clickInterface () {
        let form = $('#comfirm-ap');
        let valid_input = true;
        let errorMsg = '';
        let vm = this;
        vm.errors.invoice_batch = false;
        vm.errors.group_id = false;
        $(form).find("div[id='el_explode_invoice_batch']").html("");
        $(form).find("div[id='el_explode_group_id']").html("");
        if (vm.index.invoice_batch == ''){
          vm.errors.invoice_batch = true;
          valid_input = false;
          errorMsg = "กรุณาระบุ Invoice Batch";
          $(form).find("div[id='el_explode_invoice_batch']").html(errorMsg);
        }
        vm.$refs.index_ap_invoice_interface.validate((valid) => {
          if (valid) {
            if (!valid_input) { return; }
            vm.getInterface()
          } else {
            return false;
          }
        })
      },
      clickCancel() {
        let form = $('#comfirm-ap');
        let valid_input = true;
        let errorMsg = '';
        let vm = this;
        vm.errors.invoice_batch = false;
        vm.errors.group_id = false;
        $(form).find("div[id='el_explode_invoice_batch']").html("");
        $(form).find("div[id='el_explode_group_id']").html("");
        if (vm.index.group_id == ''){
          vm.errors.group_id = true;
          valid_input = false;
          errorMsg = "กรุณาระบุ Group ID";
          $(form).find("div[id='el_explode_group_id']").html(errorMsg);
        }
        vm.$refs.index_ap_invoice_interface.validate((valid) => {
          if (valid) {
          if (!valid_input) { return; }
            vm.getCancel()
          } else {
            return false;
          }
        })
      },
      changeInvoiceDate (date) {
        let formatDate = this.vars.formatDate
        if (date) {
          this.index.invoice_date = moment(date).format(formatDate)
          this.$refs.index_ap_invoice_interface.fields.find((f) => f.prop == 'invoice_date').clearValidate()
        } else {
          this.$refs.invoice_date.resetField()
          this.$refs.index_ap_invoice_interface.validateField('invoice_date')
        }

        if (this.index.interface_year != '' && this.index.interface_type != '' && this.index.invoice_date != '') {
          this.getGroupIdVal();
        }

        if (this.index.interface_type != '' && this.index.invoice_date != '') {
          this.getDefaultAPBatch();
        }
      },
      getValueInterfaceType (obj) {
         
        this.index.interface_type = obj.code
        if (this.index.interface_year != '' && this.index.interface_type != '' && this.index.invoice_date != '') {
          this.getGroupIdVal();
        }

        if (this.index.interface_type != '' && this.index.invoice_date != '') {
          this.getDefaultAPBatch();
        }
      },
      getValueInterfaceYear (date) {
         
        let formatYear = this.vars.formatYear
        if (date) {
          this.index.interface_year = moment(date).format(formatYear)
          this.$refs.index_ap_invoice_interface.fields.find((f) => f.prop == 'interface_year').clearValidate()
        } else {
          this.$refs.interface_year.resetField()
          this.$refs.index_ap_invoice_interface.validateField('interface_year')
        }

        if (this.index.interface_year != '' &&  this.index.interface_type != '' && this.index.invoice_date != '') {
          this.getGroupIdVal();
        }
      },
      getInterface () {
        this.showLoading = true
        let params = {
          year: this.funcs.setYearCE('year', this.index.interface_year),
          type: this.index.interface_type,
          date: this.funcs.setYearCE('date', this.index.invoice_date),
          invoice_batch: this.index.invoice_batch
        }
        axios.get(`/ir/ajax/confirm-ap`, { params })
        .then(res => {
          this.showLoading = false;
          window.open(res.data.data.redirect_to_export, '_blank');
          swal({
            title: '<div class="mt-4"> Success </div>',
            text: '<span style="font-size: 16px; text-align: left;"> ทำการ Interface ข้อมูลเข้า AP เรียบร้อยแล้ว </span>',
            type: "success",
            html: true
          },
          function(isConfirm){
            if (isConfirm) {
              window.location.href = '/ir/confirm-to-ap'
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
          year: this.funcs.setYearCE('year', this.index.interface_year),
          type: this.index.interface_type,
          date: this.funcs.setYearCE('date', this.index.invoice_date),
          invoice_batch: this.index.invoice_batch
        }
        axios.get(`/ir/ajax/confirm-ap/report`, { params })
        .then(res => {
          this.showLoading = false;
          window.open(res.data.data.redirect_to_export, '_blank');
        })
        .catch((error) => {
          swal({
            title: '<div class="mt-4"> Warning </div>',
            text: '<span style="font-size: 16px; text-align: left;">'+error.response.data.message+'</span>',
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
          title: 'ยกเลิกรายการ Interface AP',
          text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการยกเลิกรายการ Interface AP ใช่หรือไม่? </span></h2>',
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
          year: this.funcs.setYearCE('year', this.index.interface_year),
          type: this.index.interface_type,
          date: this.funcs.setYearCE('date', this.index.invoice_date),
          group_id: this.index.group_id
        }
        axios.get(`/ir/ajax/confirm-ap/cancel`, { params })
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
              window.location.href = '/ir/confirm-to-ap'
            }
          });
        })
        .catch((error) => {
          console.log(error.response);
          this.showLoading = false
          swal({
            title: '<div class="mt-4"> Warning </div>',
            text: '<span style="font-size: 16px; text-align: left;">'+error.response.data.message+'</span>',
            type: "warning",
            html: true
          });
          this.disabledInterface = true;
        })
      },
      clickClear () {
        window.location.href = '/ir/confirm-to-ap'
      },
      // Piyawut A. Add func get value: group id 20211112
      async getGroupIdVal() {
        var vm = this;
        var params =  {
          interface_year: vm.index.interface_year,
          from_program_code: vm.index.interface_type,
          invoice_date: vm.index.invoice_date
        }
        await axios.post(`/ir/ajax/confirm-ap/get-group-id`, {params})
          .then(res => {
            vm.groupId = res.data.data.group_id;
          })
          .catch(err => {
            vm.groupId = '';
          });
      },
      // Piyawut A. Add func get default ap batch 20220129
      async getDefaultAPBatch() {
        var vm = this;
        var params =  {
          from_program_code: vm.index.interface_type,
          invoice_date: vm.index.invoice_date
        }
        await axios.post(`/ir/ajax/confirm-ap/get-ap-batch`, {params})
          .then(res => {
            if (res.data.data.status == 'E') {
              vm.index.invoice_batch = '';
              swal({
                title: '<div class="mt-4"> มีข้อผิดพลาด </div>',
                text: '<span style="font-size: 16px; text-align: left;">'+res.data.data.msg+'</span>',
                type: "warning",
                html: true
              });
            }else{
              vm.index.invoice_batch = res.data.data.invoice_batch;
            }
          })
          .catch(err => {
            vm.index.invoice_batch = '';
          });
      },
      async convertDateThai(){
        let curr_date = moment().format('DD-MM-YYYY');
        var currentDate = await helperDate.parseToDateTh(curr_date, 'DD-MM-YYYY');
        this.index.invoice_date = moment(currentDate).format('DD-MM-YYYY');;
      },
      setError(ref_name){
        let ref = this.$refs[ref_name].$refs.reference 
                ? this.$refs[ref_name].$refs.reference.$refs.input 
                : (this.$refs[ref_name].$refs.textarea 
                  ? this.$refs[ref_name].$refs.textarea 
                  : (this.$refs[ref_name].$refs.input.$refs 
                    ? this.$refs[ref_name].$refs.input.$refs.input 
                    : this.$refs[ref_name].$refs.input ));
        ref.style = "border: 1px solid red;";
      },
      resetError(ref_name){
          let ref = this.$refs[ref_name].$refs.reference 
                ? this.$refs[ref_name].$refs.reference.$refs.input 
                : (this.$refs[ref_name].$refs.textarea 
                  ? this.$refs[ref_name].$refs.textarea
                  : (this.$refs[ref_name].$refs.input.$refs 
                    ? this.$refs[ref_name].$refs.input.$refs.input 
                    : this.$refs[ref_name].$refs.input ));
          ref.style = "";
      },
    },
    components: {
      yearInput,
      lovInterfaceType,
    }
  }
</script>
