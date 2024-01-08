<template>
  <div class="modal inmodal fade" :id="`modal_account`" tabindex="-1" role="dialog"  aria-hidden="true" data-backdrop="static">
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
                    label-width="120px" 
                    ref="modal_account_mapping" 
                    class="demo-ruleForm">
            <!-- <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                ประเภทค่าใช้จ่าย
              </label>
              <div class="col-md-6 el_field">
                <el-form-item prop="type_cost">
                  <lov-type-cost  v-model="typeCost"
                                  :account_id="account_id"
                                  placeholder="ประเภทค่าใช้จ่าย"
                                  :popperBody="false"
                                  :name="`type_cost`"
                                  :disabled="false"
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
                  <lov-company  :attrName="`segmentCompany`"
                                v-model="account.company"
                                @change-lov-segment="getDataCompany"
                                :disabled="disabled" />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                EVM *
              </label>
              <div class="col-md-6 el_field">
                <el-form-item prop="evm">
                  <lov-branch :attrName="`segmentBranch`"
                              v-model="account.evm"
                              @change-lov-segment="getDataBranch"
                              vendorId=""
                              :disabled="disabled" />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                Department *
              </label>
              <div class="col-md-6 el_field">
                <el-form-item prop="department">
                  <lov-department :attrName="`segmentDepartment`"
                                  v-model="account.department"
                                  @change-lov-segment="getValueDepartment"
                                  :disabled="disabled" />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                Cost Center *
              </label>
              <div class="col-md-6 el_field">
                <el-form-item prop="cost_center">
                  <lov-product  :attrName="`segmentProduct`"
                                v-model="account.cost_center"
                                @change-lov-segment="getDataProduct"
                                :departmentCode="account.department"
                                :disabled="disabled" />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                Budget Year *
              </label>
              <div class="col-md-6 el_field">
                <el-form-item prop="budget_year">
                  <lov-source :attrName="`segmentSource`"
                              v-model="account.budget_year"
                              @change-lov-segment="getDataSource"
                              :disabled="disabled" />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                Budget Type *
              </label>
              <div class="col-md-6 el_field">
                <el-form-item prop="budget_type">
                  <lov-account :attrName="`segmentAccount`"
                                v-model="account.budget_type"
                                @change-lov-segment="getDataAccount"
                                :disabled="disabled" />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                Budget Detail *
              </label>
              <div class="col-md-6 el_field">
                <el-form-item prop="budget_detail">
                  <lov-sub-account  :attrName="`segmentSubAccount`"
                                    v-model="account.budget_detail"
                                    @change-lov-segment="getDataSubAccount"
                                    :budgetType="account.budget_type" 
                                    :disabled="disabled" />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                Budget Reason *
              </label>
              <div class="col-md-6 el_field">
                <el-form-item prop="budget_reason">
                  <lov-project-activity :attrName="`segmentProjectActivity`"
                                        v-model="account.budget_reason"
                                        @change-lov-segment="getDataProjectActivity"
                                        :disabled="disabled" />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                Main Account *
              </label>
              <div class="col-md-6 el_field">
                <el-form-item prop="main_account">
                  <lov-inter-company  :attrName="`segmentInterCompany`"
                                      v-model="account.main_account"
                                      @change-lov-segment="getDataInterCompany"
                                      :disabled="disabled" />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                Sub Account *
              </label>
              <div class="col-md-6 el_field">
                <el-form-item prop="sub_account">
                  <lov-allocation attrName="`segmentAllocation`"
                                  v-model="account.sub_account"
                                  @change-lov-segment="getDataAllocation"
                                  :mainAccount="account.main_account"
                                  :disabled="disabled" />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                Reserved *
              </label>
              <div class="col-md-6 el_field">
                <el-form-item prop="reserved1">
                  <lov-future-used1 :attrName="`segmentFutureUsed1`"
                                    v-model="account.reserved1"
                                    @change-lov-segment="getDataFutureUsed1"
                                    :disabled="disabled" />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                Reserved *
              </label>
              <div class="col-md-6 el_field">
                <el-form-item prop="reserved2">
                  <lov-future-used2 :attrName="`segmentFutureUsed2`"
                                    v-model="account.reserved2"
                                    @change-lov-segment="getDataFutureUsed2"
                                    :disabled="disabled" />
                </el-form-item>
              </div>
            </div>
          </el-form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" 
            @click="clickAgree()">
            <i class="fa fa-check-circle-o"></i> ตกลง
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import lovCompany from '../../components/lov/segments/lovCompany' 
import lovBranch from '../../components/lov/segments/lovBranch'
import lovDepartment from '../../components/lov/segments/lovDepartment'
import lovProduct from '../../components/lov/segments/lovProduct'
import lovSource from '../../components/lov/segments/lovSource'
import lovAccount from '../../components/lov/segments/lovAccount'
import lovSubAccount from '../../components/lov/segments/lovSubAccount'
import lovProjectActivity from '../../components/lov/segments/lovProjectActivity'
import lovInterCompany from '../../components/lov/segments/lovInterCompany'
import lovAllocation from '../../components/lov/segments/lovAllocation'
import lovFutureUsed1 from '../../components/lov/segments/lovFutureUsed1'
import lovFutureUsed2 from '../../components/lov/segments/lovFutureUsed2'
import lovTypeCost from '../../components/lov/typeCost'
export default {
  name: 'ir-settings-vehicle-modal-account-code',
  data () {
    return {
      argSearchCompany: {
        compnany_code: '',
        description: ''
      },
      account_code: '',
      account_name: '',
      description: {
        company: '',
        evm: '',
        department: '',
        cost_center: '',
        budget_year: '',
        budget_type: '',
        budget_detail: '',
        budget_reason: '',
        main_account: '',
        sub_account: '',
        reserved1: '',
        reserved2: '',
        // type_cost: ''
      },
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
      account: this.accounts,
      account_id: this.accountId,
      typeCost: this.type_cost,
      disabled: false
    }
  },
  props: [
    'index',
    'rows',
    'accounts',
    'accountId',
    'type_cost',
    'descriptions'
  ],
  computed: {
    propProduct () {
      return {
        prop3: 'department_code',
        value: this.account.department
      }
    },
    propSubAccount () {
      return {
        prop3: 'budget_type',
        value: this.account.account
      }
    },
    propAllocation () {
      return {
        prop3: 'main_account',
        value: this.account.interCompany
      }
    },
    checkAccountCode () {
      for (let i in this.account) {
        let data = this.account[i]
        if (data) {
          return true
        }
        return false
      }
      return false
    },
    checkAccountDesc () {
      for (let i in this.description) {
        let data = this.description[i]
        if (data) {
          return true
        }
        return false
      }
      return false
    }
  },
  methods: {
    clickAgree() {
      this.$refs.modal_account_mapping.validate((valid) => {
        if (valid) {
          this.account_code = this.account.company + '.'
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

          this.account_name = this.description.department + '.' + this.description.main_account + '.' + this.description.sub_account;
          this.$emit('account-code', this.account_code);
          this.$emit('account-name', this.account_name);
          $(`#modal_account`).modal('hide');
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
    getValueTypeCode (obj) {
        this.account_id = obj.id;
        this.typeCost = obj.code;
        this.$emit('accountid', obj.id)
      if (obj.code) {
        this.disabled = true;
      } else {
        this.disabled = false;
      }
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
    'accounts' (newVal, oldVal) {
      this.account = newVal;
    },
    'type_cost' (newVal, oldVal) {
      this.typeCost = newVal;
    },
    'descriptions' (newVal, oldVal) {
      this.description = newVal;
    }
  }
}
</script>
