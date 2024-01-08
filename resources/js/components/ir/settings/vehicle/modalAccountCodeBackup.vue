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
            <div class="row">
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
            </div>
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
                <el-form-item prop="branch">
                  <lov-branch :attrName="`segmentBranch`"
                              v-model="account.branch"
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
                <el-form-item prop="product">
                  <lov-product  :attrName="`segmentProduct`"
                                v-model="account.product"
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
                <el-form-item prop="source">
                  <lov-source :attrName="`segmentSource`"
                              v-model="account.source"
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
                <el-form-item prop="account">
                  <lov-account :attrName="`segmentAccount`"
                                v-model="account.account"
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
                <el-form-item prop="subAccount">
                  <lov-sub-account  :attrName="`segmentSubAccount`"
                                    v-model="account.subAccount"
                                    @change-lov-segment="getDataSubAccount"
                                    :budgetType="account.account" 
                                    :disabled="disabled" />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                Budget Reason *
              </label>
              <div class="col-md-6 el_field">
                <el-form-item prop="projectActivity">
                  <lov-project-activity :attrName="`segmentProjectActivity`"
                                        v-model="account.projectActivity"
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
                <el-form-item prop="interCompany">
                  <lov-inter-company  :attrName="`segmentInterCompany`"
                                      v-model="account.interCompany"
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
                <el-form-item prop="allocation">
                  <lov-allocation attrName="`segmentAllocation`"
                                  v-model="account.allocation"
                                  @change-lov-segment="getDataAllocation"
                                  :mainAccount="account.interCompany"
                                  :disabled="disabled" />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <label class="col-md-5 col-form-label lable_align">
                Reserved *
              </label>
              <div class="col-md-6 el_field">
                <el-form-item prop="futureUsed1">
                  <lov-future-used1 :attrName="`segmentFutureUsed1`"
                                    v-model="account.futureUsed1"
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
                <el-form-item prop="futureUsed2">
                  <lov-future-used2 :attrName="`segmentFutureUsed2`"
                                    v-model="account.futureUsed2"
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
        branch: '',
        department: '',
        product: '',
        source: '',
        account: '',
        subAccount: '',
        projectActivity: '',
        interCompany: '',
        allocation: '',
        futureUsed1: '',
        futureUsed2: '',
        // type_cost: ''
      },
      rules: {
        company: [
          {required: true, message: 'กรุณาระบุ Company Code', trigger: 'change'}
        ],
        branch: [
          {required: true, message: 'กรุณาระบุ EVM', trigger: 'change'}
        ],
        department: [
          {required: true, message: 'กรุณาระบุ Department', trigger: 'change'}
        ],
        product: [
          {required: true, message: 'กรุณาระบุ Cost Center', trigger: 'change'}
        ],
        source: [
          {required: true, message: 'กรุณาระบุ Budget Year', trigger: 'change'}
        ],
        account: [
          {required: true, message: 'กรุณาระบุ Budget Type', trigger: 'change'}
        ],
        subAccount: [
          {required: true, message: 'กรุณาระบุ Budget Detail', trigger: 'change'}
        ],
        projectActivity: [
          {required: true, message: 'กรุณาระบุ Budget Reason', trigger: 'change'}
        ],
        interCompany: [
          {required: true, message: 'กรุณาระบุ Main Account', trigger: 'change'}
        ],
        allocation: [
          {required: true, message: 'กรุณาระบุ Sub Account', trigger: 'change'}
        ],
        futureUsed1: [
          {required: true, message: 'กรุณาระบุ Reserved', trigger: 'change'}
        ],
        futureUsed2: [
          {required: true, message: 'กรุณาระบุ Reserved', trigger: 'change'}
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
            + this.account.branch + '.'
            + this.account.department + '.'
            + this.account.product + '.'
            + this.account.source + '.'
            + this.account.account + '.'
            + this.account.subAccount + '.'
            + this.account.projectActivity + '.'
            + this.account.interCompany + '.'
            + this.account.allocation + '.'
            + this.account.futureUsed1 + '.'
            + this.account.futureUsed2;

          this.account_name = this.description.department + '.' + this.description.interCompany + '.' + this.description.allocation;
          this.$emit('account-code', this.account_code)
          this.$emit('account-name', this.account_name)
          $(`#modal_account`).modal('hide')
        }
      });
    },
    getDataCompany (obj) {
      this.account.company = obj.value
      this.description.company = obj.desc
    },
    getDataBranch (obj) {
      this.account.branch = obj.value
      this.description.branch = obj.desc
    },
    getValueDepartment (obj) {
      this.account.department = obj.value
      this.description.department = obj.desc
    },
    getDataProduct (obj) {
      this.account.product = obj.value
      this.description.product = obj.desc
    },
    getDataSource (obj) {
      this.account.source = obj.value
      this.description.source = obj.desc
    },
    getDataAccount (obj) {
      this.account.account = obj.value
      this.description.account = obj.desc
    },
    getDataSubAccount (obj) {
      this.account.subAccount = obj.value
      this.description.subAccount = obj.desc
    },
    getDataProjectActivity (obj) {
      this.account.projectActivity = obj.value
      this.description.projectActivity = obj.desc
    },
    getDataInterCompany (obj) {
      this.account.interCompany = obj.value
      this.description.interCompany = obj.desc
    },
    getDataAllocation (obj) {
      this.account.allocation = obj.value
      this.description.allocation = obj.desc
    },
    getDataFutureUsed1 (obj) {
      this.account.futureUsed1 = obj.value
      this.description.futureUsed1 = obj.desc
    },
    getDataFutureUsed2 (obj) {
      this.account.futureUsed2 = obj.value
      this.description.futureUsed2 = obj.desc
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
