<template>
  <div class="modal inmodal fade" :id="`modal_expire_date`" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
          </button>
          <p class="modal-title text-left">วันสิ้นอายุประกัน</p>
        </div>
        <el-form  :model="expireDate"
                  ref="form_expire_date" 
                  label-width="120px" 
                  class="demo-dynamic form_table_line">
                  <!-- :rules="rules" -->
          <div class="modal-body">
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                วันสิ้นอายุ ประกัน
              </label>
              <div class="col-md-6 el_field">
                <el-form-item prop="insurance_expire_date">
                  <datepicker-th  style="width: 100%;"
                                  class="el-input__inner"
                                  :name="`insurance_expire_date`"
                                  p-type="date"
                                  placeholder="วันสิ้นอายุ ประกัน"
                                  :value="expireDate.insurance_expire_date"
                                  :format="vars.formatDate"
                                  @dateWasSelected="getValueInsuranceExpireDate" />
                </el-form-item>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" 
                    class="btn btn-primary" 
                    @click="clickAgree()">
              <i class="fa fa-check-circle-o"></i> ตกลง
            </button>
          </div>
        </el-form>
      </div>
    </div>
  </div>
</template>

<script>
  import moment from 'moment'
  export default {
    name: 'ir-settings-gas-station-modal-expire-date',
    data () {
      return {
        rules: {
          insurance_expire_date: [
            {required: true, message: 'กรุณาระบุวันสิ้นอายุ ประกัน', trigger: 'change'}
          ]
        },
        modal: this.expireDate
      }
    },
    props: [
      'vars',
      'expireDate'
    ],
    methods: {
      clickAgree () {
         
        this.$refs.form_expire_date.validate((valid) => {
           
          if (valid) {
            this.$emit('expire-date', this.expireDate)
            $(`#modal_expire_date`).modal('hide')
          } else {
            return false;
          }
        })
      },
      getValueInsuranceExpireDate (date) {
        let formatDate = this.vars.formatDate;
        if (date) {
          this.expireDate.insurance_expire_date = moment(date).format(formatDate);
        } else {
          this.expireDate.insurance_expire_date = '';
        }
        this.validateNotElUi(date, 'insurance_expire_date');
      },
      validateNotElUi (value, nameProp) {
        if (value) {
          this.$refs.form_expire_date.fields.find((f) => f.prop == nameProp).clearValidate()
        } else {
          this.$refs.form_expire_date.validateField(nameProp)
        }
      }
    }
  }
</script>

