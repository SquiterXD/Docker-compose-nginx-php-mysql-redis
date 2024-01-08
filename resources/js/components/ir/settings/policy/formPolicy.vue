<template>
  <div class="mt-3">
    <el-form  :model="policy"
              :rules="rules" 
              ref="save_policy">
      <div class="row">
        <div class="col-xl-7 col-md-7 col-sm-12 col-xs-12 offset-md-2">
          <div class="form-group row">
            <label class="col-lg-5 col-md-6 col-sm-12 col-xs-12 col-form-label lable_align">
              <strong>กรมธรรม์ชุดที่ (Policy No) <span class="text-danger"> * </span></strong>
            </label>
            <div class="col-lg-7 col-md-6 col-sm-12 col-xs-12 align-item-center">
              <el-form-item prop='policy_set_number' class="el-form-item-irm0002">
                <el-input v-model="policy.policy_set_number"
                          :disabled="true"/>
              </el-form-item>
            </div>
          </div>
        </div>
        <div class="col-xl-7 col-md-7 offset-md-2">
          <div class="form-group row">
            <label class="col-lg-5 col-md-6 col-form-label lable_align">
              <strong>คำอธิบาย (Description) <span class="text-danger"> * </span></strong>
            </label>

            <div class="col-lg-7 col-md-6">
              <el-form-item prop="policy_set_description" class="el-form-item-irm0002">
                <el-input v-model="policy.policy_set_description"/>
              </el-form-item>
            </div>
          </div>
        </div>

        <div class="col-xl-7 col-md-7 offset-md-2">
            <div class="form-group row">
                <label class="col-lg-5 col-md-6 col-form-label lable_align">
                    <strong>แบบของการประกัน (Policy Type) <span class="text-danger"> * </span></strong>
                </label>

                <div class="col-lg-7 col-md-6">
                  <el-form-item prop="policy_type_code" class="el-form-item-irm0002">
                    <el-select  v-model="policy.policy_type_code" 
                                placeholder="เลือก"
                                class='w-100'
                                :clearable="true">
                      <el-option  v-for="(data, index) in policyTypeCodes"
                                  :key="index"
                                  :label="data.meaning"
                                  :value="data.policy_type_code">
                      </el-option>
                    </el-select>

                  </el-form-item>
                </div>
            </div>
        </div>

        <div class="col-xl-7 col-md-7 offset-md-2">
          <div class="form-group row">
            <label class="col-lg-5 col-md-6 col-form-label lable_align">
              <strong>อายุกรมธรรม์ <span class="text-danger"> * </span></strong>
            </label>
            <div class="col-lg-4 col-md-5 col-sm-11 col-xs-11">
              <div class="input-group">
                <el-form-item prop='policy_age' class='w-100 el-form-item-irm0002'>
                  <el-input-number v-model="policy.policy_age" :controls="false" class='w-100' @input="onlyNumeric"/>
                </el-form-item>
              </div>
            </div>
            <label class="col-lg-1 col-md-1 col-sm-1 col-xs-1 col-form-label">
              <strong>ปี</strong>
            </label>
          </div>
        </div>

        <div class="col-xl-7 col-md-7 offset-md-2">
            <div class="form-group row">
                <label class="col-lg-5 col-md-6 col-form-label lable_align">
                    <strong>ประเภทค่าใช้จ่าย (AP) <span class="text-danger"> * </span></strong>
                </label>
                <div class="col-lg-7 col-md-6">
                  <el-form-item prop="type_cost" class="el-form-item-irm0002">
                    <type-cost  v-model='policy.type_cost'
                                :valueTypeCost="policy.id_account"
                                @typeCode='receivedTypeCode'
                                :id_account="policy.id_account"/>
                  </el-form-item>
                </div>
            </div>
        </div>

        <div class="col-xl-7 col-md-7 offset-md-2">
            <div class="form-group row">
                <label class="col-lg-5 col-md-6 col-form-label lable_align">
                    <strong>รหัสบัญชีจ่ายล่วงหน้า <span class="text-danger"> * </span></strong>
                </label>

                <div class="col-lg-7 col-md-6">
                  <el-form-item prop="account_combine" class="el-form-item-irm0002">
                    <el-input v-model="policy.account_combine"
                              :disabled='true'/>
                  </el-form-item>
                </div>
            </div>
        </div>

          <div class="col-xl-7 col-md-7 offset-md-2">
            <div class="form-group row">
                <label class="col-lg-5 col-md-6 col-form-label lable_align">
                    <strong>ประเภทค่าใช้จ่าย (GL) <span class="text-danger"> * </span></strong>
                </label>
                <div class="col-lg-7 col-md-6">
                  <el-form-item prop="gl_expense_account_id" class="el-form-item-irm0002">
                    <type-cost-gl  v-model='policy.gl_expense_account_id'
                                   :valueTypeCost="policy.id_account_gl"
                                   @typeCode='receivedTypeCodeGL'
                                   :id_account="policy.id_account_gl"/>
                  </el-form-item>
                </div>
            </div>
        </div>

        <div class="col-xl-7 col-md-7 offset-md-2">
            <div class="form-group row">
                <label class="col-lg-5 col-md-6 col-form-label lable_align">
                    <strong>รหัสบัญชีตัดค่าใช้จ่ายล่วงหน้า <span class="text-danger"> * </span></strong>
                </label>

                <div class="col-lg-7 col-md-6">
                  <el-form-item prop="account_combine_gl" class="el-form-item-irm0002">
                    <el-input v-model="policy.account_combine_gl"
                              :disabled='true'/>
                  </el-form-item>
                </div>
            </div>
        </div>


        <div class="col-xl-7 col-md-7 offset-md-2">
          <div class="form-group row">
              <label class="col-lg-5 col-md-6 col-form-label lable_align"></label>
              <div class="col-lg-7 col-md-6">
                  <div class="form-check mt-0 d-flex align-items-center">
                    <input  class="form-check-input mt-0"
                            type="checkbox"
                            id="include_tax_flag"
                            name="include_tax_flag"
                            v-model="policy.include_tax_flag">
                    <label class="form-check-label" name='active_flag' for='include_tax_flag'>
                        รวมภาษีมูลค่าเพิ่ม
                    </label>
                  </div>
              </div>
          </div>
        </div>

        <div class="col-xl-7 col-md-7 offset-md-2">
          <div class="form-group row" id="policy-type-code">
            <label class="col-lg-5 col-md-6 col-form-label lable_align">
              <strong>กลุ่ม <span class="text-danger"> * </span></strong>
            </label>
            <div class="col-lg-7 col-md-6">
              <div class='mb-3'>
                <el-form-item prop='group_code' class="el-form-item-irm0002">
                  <group-code @group='receivedGroupCode'
                              v-model='policy.group_code'
                              required
                              :valueTypeCost="policy.group_code" />
                </el-form-item>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-7 col-md-7 offset-md-2">
          <div class="form-group row" id="policy-type-code">
            <label class="col-lg-5 col-md-6 col-form-label lable_align">
              <strong>ประเภทกรมธรรม์ <span class="text-danger"> * </span></strong>
            </label>
            <div class="col-lg-7 col-md-6">
              <div class='mb-3' >
                <el-form-item prop='policy_category_code' class="el-form-item-irm0002">
                  <policy-category  @category='receivedPolicyCategory' required
                                    v-model='policy.policy_category_code'
                                    :valueTypeCost="policy.policy_category_code"/>
                </el-form-item>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-7 col-md-7 offset-md-2">
            <div class="form-group row">
                <label class="col-lg-5 col-md-6 col-form-label lable_align"></label>
                <div class="col-lg-7 col-md-6">
                  <div class="form-check align-items-center d-flex">
                    <input  class="form-check-input mt-0"
                            type="checkbox"
                            id="active_flag"
                            name="active_flag"
                            v-model="policy.active_flag"
                            v-if="policy.mode == 'create'">
                    <input  class="form-check-input mt-0 form_company_active"
                            type="checkbox"
                            id="active_flag"
                            name="active_flag"
                            v-model="policy.active_flag"
                            v-else
                            @change="changeActiveFlag()">
                    <label class="form-check-label" for='active_flag' >
                      Active
                    </label>
                  </div>
                </div>
            </div>
        </div>

        <div class="col-12 mt-3">
          <div class="row clearfix m-t-lg text-right">
            <div class="col-sm-12">
              <button type="button" :class="btnTrans.save.class+' btn-lg tw-w-25'" @click.prevent="save()">
                <i :class="btnTrans.save.icon"></i>
                {{ btnTrans.save.text }}
              </button>
              <button type="button" :class="btnTrans.cancel.class+' btn-lg tw-w-25'" @click.prevent="clickCancel()">
                <i :class="btnTrans.cancel.icon"></i>
                {{ btnTrans.cancel.text }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </el-form>
  </div>
</template>

<script>
import selectTypeCost from './selectOptionPolicyType'
import selectTypeCostGl from './selectOptionPolicyTypeGl'
import selectPolicyType from './selectPolicyType'
import selectGroupCode from './selectGroup'
import selectPolicyCategory from './selectPolicyCategory'
import * as scripts from '../../scripts'

export default {
  name: 'ir-form-policy',
  data () {
    return {
      policyTypeCodes: [],
      id_account: '',
      id_account_gl: '',
      rules: {
        policy_set_number: [{
          required: true, message: 'กรุณาระบุชุดกรมธรรม์', trigger: 'change'
        }],
        policy_set_description: [{
          required: true, message: 'กรุณาระบุคำอธิบาย', trigger: 'change'
        }],
        policy_type_code: [{
          required: true, message: 'กรุณาระบุแบบของการประกัน', trigger: 'change'
        }],
        policy_age: [{
          required: true, message: 'กรุณาระบุอายุกรมธรรม์', trigger: 'change'
        }],
        type_cost: [{
          required: true, message: 'กรุณาระบุประเภทค่าใช้จ่าย', trigger: 'change'
        }],
        account_combine: [{
          required: true, message: 'กรุณาระบุชุดรหัสบัญชี', trigger: 'change'
        }],
        include_tax_flag: [{
          required: true, message: 'กรุณาระบุชุดกรมธรรม์', trigger: 'change'
        }],
        group_code: [{
          required: true, message: 'กรุณาระบุกลุ่ม', trigger: 'change'
        }],
        policy_category_code: [{
          required: true, message: 'กรุณาระบุประเภทกรมธรรม์', trigger: 'change'
        }],
        account_combine_gl: [{
          required: true, message: 'กรุณาระบุชุดรหัสบัญชี', trigger: 'change'
        }],
        gl_expense_account_id: [{
          required: true, message: 'กรุณาระบุประเภทค่าใช้จ่าย', trigger: 'change'
        }],
      },
      funcs: scripts.funcs
    }
  },
  props: [
    'policy',
    'updateUrl',
    'btnTrans'
  ],
  methods: {
    getPolicyTypeCodes () {
      axios.get(`/ir/ajax/lov/policy-type`)
      .then(({data}) => {
        this.policyTypeCodes = data.data
      })
      .catch((error) => {
         
      })
    },
    save () {
      this.$refs['save_policy'].validate((valid) => {
        if (valid) {
          if (this.policy.mode == 'edit') {
            let checked = $(`.form_company_active`).is(':checked');
            let active_flag = checked ? 'Y' : 'N';
            axios.put(`/ir/ajax/policy/update`, {
              policy_set_header_id: this.policy.policy_set_header_id,
              policy_set_number: this.policy.policy_set_number,
              policy_set_description: this.policy.policy_set_description,
              policy_type_code: this.policy.policy_type_code,
              policy_age: this.policy.policy_age,
              type_cost: this.policy.type_cost,
              gl_expense_account_id: this.policy.gl_expense_account_id,
              include_tax_flag: this.policy.include_tax_flag ? 'Y' : 'N',
              account_combine: this.policy.account_combine,
              account_combine_gl: this.policy.account_combine_gl,
              policy_category_code: this.policy.policy_category_code,
              group_code: this.policy.group_code,

              // active_flag: this.policy.active_flag ? 'Y' : 'N',
              active_flag: active_flag,
              account_id: this.policy.account_id,
              account_id_gl: this.policy.account_id_gl,
            })
            .then((response) => {
              swal({
                title: "Success",
                text: 'บันทึกสำเร็จ',
                // timer: 3000,
                type: "success",
                // showCancelButton: false,
                // showConfirmButton: true
              }, (isConfirm) => {
                  window.location.href = '/ir/settings/policy';
              });
              // setTimeout(() => {
              //   window.location.href = '/ir/settings/policy'
              // }, 3000)
            })
            .catch(error => {
              if (error.response.data.status === 400) {
                swal({
                  title: "Warning",
                  text:  error.response.data.message,
                  // timer: 3000,
                  type: "warning",
                })
              } else {
                swal({
                  title: "Error",
                  text:  error.response.data.message,
                  // timer: 3000,
                  type: "error",
                })
              }
            })
          } else {
            axios.post(`/ir/ajax/policy/save`, {
              policy_set_number: this.policy.policy_set_number,
              policy_set_description: this.policy.policy_set_description,
              policy_type_code: this.policy.policy_type_code,
              policy_age: this.policy.policy_age,
              type_cost: this.policy.type_cost,
              gl_expense_account_id: this.policy.gl_expense_account_id,
              include_tax_flag: this.policy.include_tax_flag ? 'Y' : 'N',
              policy_category_code: this.policy.policy_category_code,
              group_code: this.policy.group_code,
              account_combine: this.policy.account_combine,
              account_combine_gl: this.policy.account_combine_gl,
              active_flag: this.policy.active_flag ? 'Y' : 'N',
              account_id: this.policy.account_id,
              account_id_gl: this.policy.account_id_gl,
              program_code: 'IRM0002'
            })
            .then(({data}) => {
              swal({
                title: "Success",
                text: data.message,
                // timer: 3000,
                type: "success",
                showCancelButton: false,
                showConfirmButton: true
              }, (isConfirm) => {
                  window.location.href = '/ir/settings/policy';
              });
              // setTimeout(() => {
              //   window.location.href = '/ir/settings/policy'
              // }, 3000)
            })
            .catch((error) => {
              if (error.response.data.status === 400) {
                swal({
                  title: "Warning",
                  text:  error.response.data.message,
                  // timer: 3000,
                  type: "warning",
                })
              } else {
                swal({
                  title: "Error",
                  text:  error.response.data.message,
                  // timer: 3000,
                  type: "error",
                })
              }
            })
          }
        } else {
          return false;
        }
      })
    },
   
    receivedTypeCode(combine, type_code) {
      this.policy.account_combine = combine
      this.policy.type_cost = type_code
      this.policy.account_id = type_code
    },

    receivedTypeCodeGL(combine, type_code) {
      this.policy.account_combine_gl = combine
      this.policy.gl_expense_account_id = type_code
      this.policy.account_id_gl = type_code
    },
    receivedGroupCode(group) {
      this.policy.group_code = group
    },
    receivedPolicyCategory(category) {
      this.policy.policy_category_code = category
    },
    clickCancel () {
      window.location.href = '/ir/settings/policy'
    },
    changeActiveFlag () {
       
      let _this = this;
      axios.put(`/ir/ajax/policy/check-used-data/${ this.policy.policy_set_header_id}`)
      .then(({data}) => {
         
      })
      .catch((error) => {
        if (error.response.data.status === 400) {
          swal({
            title: "Warning",
            text: error.response.data.message,
            type: "warning",
          },
          function(isConfirm) {
            if (isConfirm) {
             _this.funcs.setDefaultActive(`form_company_active`);
            }
          });
        } else {
          swal("Error", error, "error");
        }
      })
    },
    onlyNumeric() {
      // if (this.policy.policy_set_number) {
      //   this.policy.policy_set_number = this.policy.policy_set_number.replace(/[^0-9 .]/g, '');
      // }
      // if (this.policy.policy_age) {
      //   this.policy.policy_age = this.policy.policy_age.replace(/[^0-9 .]/g, '');
      // }
    },
  },
  computed: {
    disabledField () {
      if (this.policy.mode === 'edit') {
        return true
      }
      return false
    }
  },
  components: {
    'type-cost': selectTypeCost,
    'type-cost-gl': selectTypeCostGl,
    'policy': selectPolicyType,
    'group-code': selectGroupCode,
    'policy-category': selectPolicyCategory
  },
  created () {
    this.getPolicyTypeCodes()
  }
}
</script>
<style scope>
  .el-form-item-irm0002{
    margin-bottom: 10px;
  }
</style>
