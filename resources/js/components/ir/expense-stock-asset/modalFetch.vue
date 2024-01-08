<template>
  <div class="modal inmodal fade" :id="`modal_expense_stock_asset`" tabindex="-1" role="dialog"  aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <!-- data-backdrop="static" -->
    <div class="modal-dialog modal-md">
      <div v-loading ="showLoading" >
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" :disabled="showLoading">
              <!-- @click="clickSearch()" -->
              <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
            </button>
            <p class="modal-title text-left">การดึงข้อมูล</p>
          </div>
          <el-form
            :model="fetch"
            ref="form_expense_stock_asset" 
            label-width="120px" 
            class="demo-dynamic form_table_line"
            :rules="rules">
            <div class="modal-body">
              <div class="row">
                <label class="col-md-5 col-form-label lable_align">
                  <strong>เดือนปิดบัญชี *</strong>
                </label>
                <div class="col-xl-6 col-lg-6 col-md-6 el_field">
                  <el-form-item prop="period_name">
                    <datepicker-th
                      style="width: 100%;"
                      class="el-input__inner"
                      :name="`period_name`"
                      p-type="month"
                      placeholder="เดือนปิดบัญชี"
                      :value="fetch.period_name"
                      :format="vars.formatMonth"
                      @dateWasSelected="getValuePeriodName" />
                  </el-form-item>
                </div>
              </div>
              <div class="row">
                <label class="col-md-5 col-form-label lable_align">
                  <strong>ประเภทของประกันภัย *</strong>
                </label>
                <div class="col-xl-6 col-lg-6 col-md-6 el_field">
                  <el-form-item prop="expense_type_code">
                    <lov-expense-type-code  
                      v-model="fetch.expense_type_code"
                      name="expense_type_code"
                      size=""
                      :popperBody="false"
                      @change-lov="getValueExpenseTypeCode" />
                  </el-form-item>
                </div>
              </div>
              <div class="row">
                <label class="col-md-5 col-form-label lable_align">
                  <strong>กรมธรรม์ชุดที่ *</strong>
                </label>
                <div class="col-xl-6 col-lg-6 col-md-6 el_field">
                  <el-form-item prop="policy_set_header_id">
                    <lov-policy-set-header-id 
                      v-model="fetch.policy_set_header_id"
                      name="policy_set_header_id"
                      size=""
                      @change-lov="getPolicySetHeaderId"
                      placeholder="กรมธรรม์ชุดที่"
                      :check="this.fetch.expense_type_meaning"
                      :popperBody="false"
                      fixTypeFr="10"
                      fixTypeSc="20" />
                  </el-form-item>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success" @click="clickSearch()">
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
import lovStatusIr from '../components/lov/statusIr'
import lovExpenseTypeCode from './lovExpenseTypeCode'
import lovPolicySetHeaderId from '../components/lov/policySetHeaderId'
export default {
  name: 'ir-stock-monthly-modal-fetch',
  data () {
    return {
      fetch: {
        period_name: '',
        policy_set_header_id: '',
        expense_type_code: '',
        expense_type_meaning: '',
        status: '',
      },
      rules: {
        period_name: [
          {required: true, message: 'กรุณาระบุเดือนปิดบัญชี', trigger: ['select', 'change']}
        ],
        policy_set_header_id: [
          {required: true, message: 'กรุณาระบุชุดกรมธรรม์', trigger: ['select', 'change']}
        ],
        expense_type_code: [
          {required: true, message: 'กรุณาระบุประเภทของประกันภัย', trigger: 'change'}
        ],
      },
      years: [],
      budget_period_year: [],
      months: [],
      showLoading: false
    }
  },
  props: [
    'vars',
    'setYearCE',
  ],
  methods: {
    clickSearch () {
      this.$refs.form_expense_stock_asset.validate((valid) => {
        if (valid) {
          this.checkFetch();
        } else {
          return false;
        }
      })
    },
    clickClear () {
      this.resetFields()
    },
    checkFetch() {
      this.showLoading = true
      let params = {
        program_code: 'IRP0008',
        period_name: this.setYearCE('month', this.fetch.period_name),
        policy_set_header_id: this.fetch.policy_set_header_id,
        expense_type_code: this.fetch.expense_type_code,
        expense_type_meaning: this.fetch.expense_type_meaning,
        status: this.fetch.status,
      }
      axios.get(`/ir/ajax/expense-asset-stock/check-fetch`, { params })
      .then(({data}) => {
        if(data.valid){
          this.getDataRows();
        }else {
          this.showLoading = false
          swal("Error", data.msg, "error");
        }
      })
      .catch((error) => {
        this.showLoading = false
        swal("Error", error, "error");
      });
    },
    getDataRows () {
      this.showLoading = true
      let params = {
        program_code: 'IRP0008',
        period_name: this.setYearCE('month', this.fetch.period_name),
        policy_set_header_id: this.fetch.policy_set_header_id,
        expense_type_code: this.fetch.expense_type_code,
        expense_type_meaning: this.fetch.expense_type_meaning,
        status: this.fetch.status,
      }
      axios.get(`/ir/ajax/expense-asset-stock/fetch`, { params })
      .then(({data}) => {
        this.showLoading = false
        this.$emit('fetch-table-header', data.data)
        this.resetFields();
        $(`#modal_expense_stock_asset`).modal('hide')
      })
      .catch((error) => {
        this.showLoading = false
        swal("Error", error, "error");
      })
    },
    resetFields () {
      this.$refs.form_expense_stock_asset.resetFields()
    },
    getValuePeriodName(value) {
      this.fetch.period_name = value;
    },
    getValueExpenseTypeCode(obj) {
      this.fetch.expense_type_code = obj.lookup_code;
      this.fetch.expense_type_meaning = obj.meaning;
    },
    getPolicySetHeaderId(value) {
      this.fetch.policy_set_header_id = value;
    },
    getValueStatus(value) {
      this.fetch.status = value;
    },
  },
  components: {
    lovStatusIr,
    lovExpenseTypeCode,
    lovPolicySetHeaderId
  },
  created () {

  }
}
</script>
