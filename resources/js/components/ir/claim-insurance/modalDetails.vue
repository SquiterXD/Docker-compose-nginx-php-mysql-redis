<template>
  <div class="modal inmodal fade" :id="`modal_details${index}`" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <p class="modal-title text-left">รายละเอียด (Details)</p>
        </div>
        <div class="modal-body">
          <el-form  :model="details"
                    ref="modal_details" 
                    label-width="120px" 
                    class="demo-ruleForm"
                    :rules="rules">
            <div class="margin_top_20">
            <h5>สถานะได้รับแจ้งเรื่องแล้ว</h5>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>วันที่รับแจ้งเรื่อง</strong>
              </label>
              <div class="col-xl-4 col-lg-5 col-md-6 el_field">
                <el-form-item>
                  <!-- <date-input attrName="informant_date"
                              v-model="details.informant_date"
                              @change-date="getInformantDate"
                              :sizeSmall="false"
                              placeholder="วันที่รับแจ้งเรื่อง"
                              :disabled="checkStatusInterface(status)" /> -->
                  <datepicker-th  style="width: 100%;"
                                  class="el-input__inner"
                                  :name="`informant_date`"
                                  p-type="date"
                                  placeholder="วันที่รับแจ้งเรื่อง"
                                  v-model="details.informant_date"
                                  :format="vars.formatDate"
                                  @dateWasSelected="getValueInformantDate"
                                  :disabled="checkStatusInterface(status) || checkStatusConfirmed(status) || checkStatusCancelled(status)" />
                </el-form-item>
              </div>
            </div>
            <h5 class="margin_top_20">สถานะแจ้งบริษัทประกันแล้ว</h5>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>Invoice Date *</strong>
              </label>
              <div class="col-xl-4 col-lg-5 col-md-6 el_field">
                <el-form-item prop="invoice_date">
                  <!-- <date-input attrName="invoice_date"
                              v-model="details.invoice_date"
                              @change-date="getInvoiceDate"
                              :sizeSmall="false"
                              placeholder="Invoice Date"
                              :disabled="checkStatusInterface(status)" /> -->
                  <datepicker-th  style="width: 100%;"
                                  class="el-input__inner"
                                  :name="`invoice_date`"
                                  p-type="date"
                                  placeholder="Invoice Date"
                                  v-model="details.invoice_date"
                                  :format="vars.formatDate"
                                  @dateWasSelected="getValueInvoiceDate"
                                  :disabled="checkStatusInterface(status) || checkStatusConfirmed(status) || checkStatusCancelled(status)"  />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>GL Date *</strong>
              </label>
              <div class="col-xl-4 col-lg-5 col-md-6 el_field">
                <el-form-item prop="gl_date">
                  <!-- <date-input attrName="gl_date"
                              v-model="details.gl_date"
                              @change-date="getGLDate"
                              :sizeSmall="false"
                              placeholder="GL Date"
                              :disabled="checkStatusInterface(status)" /> -->
                  <datepicker-th  style="width: 100%;"
                                  class="el-input__inner"
                                  :name="`gl_date`"
                                  p-type="date"
                                  placeholder="GL Date"
                                  v-model="details.gl_date"
                                  :format="vars.formatDate"
                                  @dateWasSelected="getValueGlDate"
                                  :disabled="checkStatusInterface(status) || checkStatusConfirmed(status) || checkStatusCancelled(status)"  />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>เลขที่อ้างอิงกับเอกสารในระบบ AR</strong>
              </label>
              <div class="col-xl-4 col-lg-5 col-md-6 el_field">
                <el-form-item>
                  <el-input placeholder="เลขที่อ้างอิงกับเอกสารในระบบ AR" 
                            v-model="details.ar_invoice_num"
                            :disabled="true"
                            name="ar_invoice_num" />
                            <!-- :disabled="checkStatusInterface(status)" -->
                  <!-- <lov-invoice-number-ar  attrName="ar_invoice_num"
                                          v-model="details.ar_invoice_num"
                                          @change-value="getDataArInvoiceNum" /> -->
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>เลขที่กรมธรรม์</strong>
              </label>
              <div class="col-xl-4 col-lg-5 col-md-6 el_field">
                <el-form-item>
                  <el-input v-model="details.policy_number"
                            placeholder="เลขที่กรมธรรม์" />
                </el-form-item>
              </div>
            </div>
            <h5 class="margin_top_20">สถานะได้รับชดใช้แล้ว</h5>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>วันที่ได้รับชดใช้</strong>
              </label>
              <div class="col-xl-4 col-lg-5 col-md-6 el_field">
                <el-form-item>
                  <!-- <date-input attrName="ar_receipt_date"
                              v-model="details.ar_receipt_date"
                              @change-date="getArReceiptDate"
                              :sizeSmall="false"
                              placeholder="วันที่ได้รับชดใช้"
                              :disabled="checkStatusInterface(status)" /> -->
                  <datepicker-th  style="width: 100%;"
                                  class="el-input__inner"
                                  :name="`ar_receipt_date`"
                                  p-type="date"
                                  placeholder="วันที่ได้รับชดใช้"
                                  v-model="details.ar_receipt_date"
                                  :format="vars.formatDate"
                                  @dateWasSelected="getValueArReceiptDate"
                                  :disabled="true"  />
                                   <!-- :disabled="checkStatusInterface(status)" -->
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>เลขที่ใบเสร็จรับเงิน</strong>
              </label>
              <div class="col-xl-4 col-lg-5 col-md-6 el_field">
                <el-form-item>
                  <el-input v-model="details.ar_receipt_number"
                            placeholder="เลขที่ใบเสร็จรับเงิน"
                            :disabled="true" />
                             <!-- :disabled="checkStatusInterface(status)" -->
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                <strong>จำนวนเงินที่ได้รับ</strong>
              </label>
              <div class="col-xl-4 col-lg-5 col-md-6 el_field">
                <el-form-item>
                  <currency-input v-model="details.ar_received_amount"
                                  :name="`ar_received_amount`"
                                  :sizeSmall="false"
                                  placeholder="จำนวนเงินที่ได้รับ"
                                  :disabled="true" />
                                  <!-- :disabled="checkStatusInterface(status)" -->
                </el-form-item>
              </div>
            </div>
          </div>
          </el-form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" @click="clickSave()">
            <i class="fa fa-save"></i> บันทึก
          </button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">
            <i class="fa fa-times"></i> ยกเลิก
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import lovInvoiceNumberAr from './lovInvoiceNumberAr'
import dateInput from '../components/calendar/dateInput'
import currencyInput from '../components/currencyInput'
import moment from 'moment'
export default {
  name: 'ir-claim-insurance-modal-details',
  data () {
    return {
       req_modal: '',
          modal: {
            informant_date: '',
            invoice_date: '',
            gl_date: '',
            ar_invoice_num: '',
            policy_number: '',
            ar_receipt_date: '',
            ar_receipt_number: '',
            ar_received_amount: ''
          },
       rules: {
        invoice_date: [
          {required: true, message: 'กรุณาระบุ Invoice Date', trigger: "blur"}
        ],
        gl_date: [
          {required: true, message: 'กรุณาระบุ GL Date', trigger: "blur"}
        ]
       }
    }
  },
  props: [
    'details',
    'index',
    'status',
    'checkStatusInterface',
    'checkStatusConfirmed',
    'vars',
    'checkStatusCancelled',
  ],
  methods: {
    clickSave () {
       
      this.$emit('modal-details', this.details)
      $(`#modal_details${this.index}`).modal('hide')
    },
    // clickCancel () {
    //    
    // },
    getInformantDate (obj) {
      this.details.informant_date = obj.value
    },
    getInvoiceDate (obj) {
      this.details.invoice_date = obj.value
    },
    getGLDate (obj) {
      this.details.gl_date = obj.value
    },
    getArReceiptDate (obj) {
      this.details.ar_receipt_date = obj.value
    },
    getDataArInvoiceNum (value) {
      this.details.ar_invoice_num = value
    },
    getValueInformantDate (date) {
       
      let formatDate = this.vars.formatDate
      if (date) {
        this.details.informant_date = moment(date).format(formatDate)
      } else {
        this.details.informant_date = '';
      }
    },
    getValueInvoiceDate (date) {
       
      let formatDate = this.vars.formatDate
      if (date) {
        this.details.invoice_date = moment(date).format(formatDate)
      } else {
        this.details.invoice_date = '';
      }
    },
    getValueGlDate (date) {
       
      let formatDate = this.vars.formatDate
      if (date) {
        this.details.gl_date = moment(date).format(formatDate)
      } else {
        this.details.gl_date = '';
      }
    },
    getValueArReceiptDate (date) {
       
      let formatDate = this.vars.formatDate
      if (date) {
        this.details.ar_receipt_date = moment(date).format(formatDate)
      } else {
        this.details.ar_receipt_date = '';
      }
    }
  },
  components: {
    lovInvoiceNumberAr,
    dateInput,
    currencyInput
  }
}
</script>

