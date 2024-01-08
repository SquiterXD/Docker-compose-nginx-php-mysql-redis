<template>
  <div class="modal inmodal fade" :id="`modal_account${index}`" tabindex="-1" role="dialog"  aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" @click="clickAgree()">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
          </button>
          <p class="modal-title text-left">ข้อมูลรหัสบัญชี (Account Mapping)</p>
        </div>
        <div class="modal-body">
          <el-form  :model="account"
                    :rules="rules" 
                    ref="modal_account_mapping" 
                    label-width="120px" 
                    class="demo-ruleForm">
            <!-- <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                ประเภทค่าใช้จ่าย
              </label>
              <div class="col-md-6 el_field">
                <el-form-item prop="type_cost">
                  <lov-type-cost  v-model="typeCost"
                                  :account_id="accountId"
                                  placeholder="ประเภทค่าใช้จ่าย"
                                  :popperBody="false"
                                  :name="`type_cost${index}`"
                                  :disabled="disabled"
                                  @split-account="getValueAccount"
                                  @change-lov="getValueTypeCode" /> 
                </el-form-item>
              </div>
            </div> -->
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                Company Code *
              </label>
              <div class="col-md-6 el_field">
                <el-form-item prop="company">
                  <lov-company  :attrName="`segmentCompany${index}`"
                                v-model="account.company"
                                @change-lov-segment="getDataCompany"
                                :disabled='disabled || selectedTypeCostdisabled'/>
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                EVM *
              </label>
              <div class="col-md-6 el_field">
                <el-form-item prop="evm">
                  <lov-branch :attrName="`segmentBranch${index}`"
                              v-model="account.evm"
                              @change-lov-segment="getDataBranch"
                              vendorId="" 
                              :disabled='disabled || selectedTypeCostdisabled'/>
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                Department *
              </label>
              <div class="col-md-6 el_field">
                <el-form-item prop="department">
                  <lov-department :attrName="`segmentDepartment${index}`"
                                  v-model="account.department"
                                  @change-lov-segment="getValueDepartment"
                                  :disabled='disabled || selectedTypeCostdisabled' />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                Cost Center *
              </label>
              <div class="col-md-6 el_field">
                <el-form-item prop="cost_center">
                  <lov-product  :attrName="`segmentProduct${index}`"
                                v-model="account.cost_center"
                                @change-lov-segment="getDataProduct"
                                :departmentCode="account.department" 
                                :disabled='disabled || selectedTypeCostdisabled'/>
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                Budget Year *
              </label>
              <div class="col-md-6 el_field">
                <el-form-item prop="budget_year">
                  <lov-source :attrName="`segmentSource${index}`"
                              v-model="account.budget_year"
                              @change-lov-segment="getDataSource" 
                              :disabled='disabled || selectedTypeCostdisabled'/>
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                Budget Type *
              </label>
              <div class="col-md-6 el_field">
                <el-form-item prop="budget_type">
                  <lov-account :attrName="`segmentAccount${index}`"
                                v-model="account.budget_type"
                                @change-lov-segment="getDataAccount"
                                :disabled='disabled || selectedTypeCostdisabled' />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                Budget Detail *
              </label>
              <div class="col-md-6 el_field">
                <el-form-item prop="budget_detail">
                  <lov-sub-account  :attrName="`segmentSubAccount${index}`"
                                    v-model="account.budget_detail"
                                    @change-lov-segment="getDataSubAccount"
                                    :budgetType="account.budget_type" 
                                    :disabled='disabled || selectedTypeCostdisabled'/>
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                Budget Reason *
              </label>
              <div class="col-md-6 el_field">
                <el-form-item prop="budget_reason">
                  <lov-project-activity :attrName="`segmentProjectActivity${index}`"
                                        v-model="account.budget_reason"
                                        @change-lov-segment="getDataProjectActivity"
                                        :disabled='disabled || selectedTypeCostdisabled' />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                Main Account *
              </label>
              <div class="col-md-6 el_field">
                <el-form-item prop="main_account">
                  <lov-inter-company  :attrName="`segmentInterCompany${index}`"
                                      v-model="account.main_account"
                                      @change-lov-segment="getDataInterCompany"
                                      :disabled='disabled || selectedTypeCostdisabled'/>
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                Sub Account *
              </label>
              <div class="col-md-6 el_field">
                <el-form-item prop="sub_account">
                  <lov-allocation :attrName="`segmentAllocation${index}`"
                                  v-model="account.sub_account"
                                  @change-lov-segment="getDataAllocation"
                                  :mainAccount="account.main_account"
                                  :disabled='disabled || selectedTypeCostdisabled'/>
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                Reserved *
              </label>
              <div class="col-md-6 el_field">
                <el-form-item prop="reserved1">
                  <lov-future-used1 :attrName="`segmentFutureUsed1${index}`"
                                    v-model="account.reserved1"
                                    @change-lov-segment="getDataFutureUsed1"
                                    :disabled='disabled || selectedTypeCostdisabled' />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                Reserved *
              </label>
              <div class="col-md-6 el_field">
                <el-form-item prop="reserved2">
                  <lov-future-used2 :attrName="`segmentFutureUsed2${index}`"
                                    v-model="account.reserved2"
                                    @change-lov-segment="getDataFutureUsed2"
                                    :disabled='disabled || selectedTypeCostdisabled' />
                </el-form-item>
              </div>
            </div>
          </el-form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" 
            @click="clickAgree()">
             <!-- data-dismiss="modal" -->
            <i class="fa fa-check-circle-o"></i> ตกลง
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import lovCompany from '../components/lov/segments/lovCompany'
import lovBranch from '../components/lov/segments/lovBranch'
import lovDepartment from '../components/lov/segments/lovDepartment'
import lovProduct from '../components/lov/segments/lovProduct'
import lovSource from '../components/lov/segments/lovSource'
import lovAccount from '../components/lov/segments/lovAccount'
import lovSubAccount from '../components/lov/segments/lovSubAccount'
import lovProjectActivity from '../components/lov/segments/lovProjectActivity'
import lovInterCompany from '../components/lov/segments/lovInterCompany'
import lovAllocation from '../components/lov/segments/lovAllocation'
import lovFutureUsed1 from '../components/lov/segments/lovFutureUsed1'
import lovFutureUsed2 from '../components/lov/segments/lovFutureUsed2'
import lovTypeCost from '../components/lov/typeCost'
export default {
  name: 'ir-gas-station-modal-account-code',
  data () {
    return {
      argSearchCompany: {
        compnany_code: '',
        description: ''
      },
      expense_account: '',
      expense_account_desc: '',
      account: this.accounts,
      description: this.descriptions,
      rules: {
        company: [
          {required: true, message: 'กรุณาระบุ Company Code', trigger: 'change'}
        ],
        evm: [
          {required: true, message: 'กรุณาระบุ EVM', trigger: 'change'}
        ],
        department: [
          {required: true, message: 'กรุณาระบุ Department', trigger: 'change'}
        ],
        cost_center: [
          {required: true, message: 'กรุณาระบุ Cost Center', trigger: 'change'}
        ],
        budget_year: [
          {required: true, message: 'กรุณาระบุ Budget Year', trigger: 'change'}
        ],
        budget_type: [
          {required: true, message: 'กรุณาระบุ Budget Type', trigger: 'change'}
        ],
        budget_detail: [
          {required: true, message: 'กรุณาระบุ Budget Detail', trigger: 'change'}
        ],
        budget_reason: [
          {required: true, message: 'กรุณาระบุ Budget Reason', trigger: 'change'}
        ],
        main_account: [
          {required: true, message: 'กรุณาระบุ Main Account', trigger: 'change'}
        ],
        sub_account: [
          {required: true, message: 'กรุณาระบุ Sub Account', trigger: 'change'}
        ],
        reserved1: [
          {required: true, message: 'กรุณาระบุ Reserved1', trigger: 'change'}
        ],
        reserved2: [
          {required: true, message: 'กรุณาระบุ Reserved2', trigger: 'change'}
        ]
      },
      account_id: this.accountId,
      typeCost: this.type_cost,
      selectedTypeCostdisabled: false
    }
  },
  props: [
    'index',
    'rows',
    'accounts',
    'descriptions',
    'disabled',
    'accountId',
    'type_cost'
  ],
  methods: {
    async clickAgree () {
      this.$refs.modal_account_mapping.validate( async (valid) => {
        if (valid) {
          this.expense_account = this.account.company + '.'
            + this.account.evm + '.'
            + this.account.department + '.'
            + this.account.cost_center + '.'
            + this.account.budget_year + '.'
            + this.account.budget_type + '.'
            + this.account.budget_detail + '.'
            + this.account.budget_reason + '.'
            + this.account.main_account + '.'
            + this.account.sub_account + '.'
            + this.account.reserved1 + '.'
            + this.account.reserved2;

          this.expense_account_desc = this.description.department + '.' + this.description.main_account + '.' + this.description.sub_account;
          this.rows[this.index].expense_account = this.expense_account;

          // Add 15042022 Piyawut A.
          await axios.get("/ir/ajax/vehicles/get-coa-desc", {
                    params: {coa: this.expense_account}
                  })
          .then(res => {
            this.expense_account_desc = res.data.desc_disply;
          }).then(()=>{
            this.rows[this.index].expense_account_desc = this.expense_account_desc;
            this.$emit('select-accounts', this.rows)
          });
          $(`#modal_account${this.index}`).modal('hide')
        } else {
           
        }
      });
    },
    getDataCompany (obj) {
      this.account.company = obj.value
      this.description.company = obj.desc
    },
    getDataBranch (obj) {
      this.account.evm = obj.value
      this.description.evm = obj.desc
    },
    getValueDepartment (obj) {
      this.account.department = obj.value
      this.description.department = obj.desc
    },
    getDataProduct (obj) {
      this.account.cost_center = obj.value
      this.description.cost_center = obj.desc
    },
    getDataSource (obj) {
      this.account.budget_year = obj.value
      this.description.budget_year = obj.desc
    },
    getDataAccount (obj) {
      this.account.budget_type = obj.value
      this.description.budget_type = obj.desc
    },
    getDataSubAccount (obj) {
      this.account.budget_detail = obj.value
      this.description.budget_detail = obj.desc
    },
    getDataProjectActivity (obj) {
      this.account.budget_reason = obj.value
      this.description.budget_reason = obj.desc
    },
    getDataInterCompany (obj) {
      this.account.main_account = obj.value
      this.description.main_account = obj.desc
    },
    getDataAllocation (obj) {
      this.account.sub_account = obj.value
      this.description.sub_account = obj.desc
    },
    getDataFutureUsed1 (obj) {
      this.account.reserved1 = obj.value
      this.description.reserved1 = obj.desc
    },
    getDataFutureUsed2 (obj) {
      this.account.reserved2 = obj.value
      this.description.reserved2 = obj.desc
    },
    getValueAccount (obj) {
      this.account = obj.account;
      this.description = obj.description;
    },
    getValueTypeCode (obj, index) {
      if (this.rows.length > 0) {
        this.rows[this.index].expense_account_id = obj.id;
        // this.rows[this.index].type_cost = obj.code;
      }
      // if (obj.code) {
      //   this.selectedTypeCostdisabled = true;
      // } else {
      //   this.selectedTypeCostdisabled = false;
      // }
    }
  },
  components: {
    lovCompany,
    lovBranch,
    lovDepartment,
    lovProduct,
    lovSource,
    lovAccount,
    lovSubAccount,
    lovProjectActivity,
    lovInterCompany,
    lovAllocation,
    lovFutureUsed1,
    lovFutureUsed2,
    lovTypeCost
  },
  watch: {
    'accountId' (newVal, oldVal) {
      this.account_id = newVal;
    }
  }
}
</script>
