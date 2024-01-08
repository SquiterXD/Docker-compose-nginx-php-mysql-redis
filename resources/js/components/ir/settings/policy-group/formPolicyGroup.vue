<template>
  <div>
      <div class="col-12">
        <div class="row mt-2 mb-1">
          <div class="col-xl-7 col-md-7 offset-md-3">
            <div class="form-group row">
              <div class="col-lg-3 col-md-3 alig-item-center">
                <el-input  v-model="group_code"
                          type="text"
                          name="policy_set_number"
                          :disabled='true'
                          :maxlength="100"/>
              </div>
              <div class="col-lg-5 col-md-5 alig-item-center">
                <el-input v-model="group_description"
                          type="text"
                          name="policy_set_number"
                          :maxlength='150'/>
              </div>
              <div class="col-lg-4 col-md-4 alig-item-center">
                <button type="button" :class="btnTrans.addList.class+' btn-lg tw-w-25'" @click.prevent="addRow()">
                  <i :class="btnTrans.addList.icon"></i>
                  {{ btnTrans.addList.text }}ชุดกรมธรรม์
                </button>
              </div>
            </div>
          </div>
        </div>
        
        <el-form  :model="data"
                    ref="assign"
                    class="form_table_line">
          <div class="col-8 offset-md-2">
            <div class="table-responsive">
              <table class="table table-bordered center">
                <thead>
                  <tr>
                    <th class="text-center" style="width: 70px;">กรมธรรม์ชุดที่ (Policy No) <span class="text-danger"> * </span></th>
                    <th class="text-center" style="width: 25px;">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for='(policy, index) in data.policy_set'
                    :key="index"
                    :class="[index == data.policy_set.length - 1 ? 'endTable' : '']">
                    <th class="el_field">
                      <el-form-item :prop="'policy_set.' + index + '.policy_set_header_id'"
                                    :rules='rules.policy_set_header_id'
                                    class="el-form-item-irm0003 pb-2">
                        <lov-policy-header-id v-model="policy.policy_set_header_id"
                                              :value='policy.policy_set_header_id'
                                              @changePolicyHeader='selectPolicy(...arguments, index)'/>
                      </el-form-item>
                    </th>
                    <th class='el_field text-center'>
                      </button>
                      <button type="button" :class="btnTrans.delete.class+' btn-sm tw-w-25'" style="margin-top: 6px" @click.prevent="clickRemove(index, policy)">
                        <i :class="btnTrans.delete.icon"></i>
                        {{ btnTrans.delete.text }}
                      </button>
                    </th>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </el-form>
          <template v-if="data.policy_set != ''">
            <div class="hr-line-dashed"></div>
            <div class="col-12 pr-0 mb-2 text-right">
              <button v-if="valid" type="button" :class="btnTrans.assign.class+' btn-lg tw-w-25'" @click.prevent="handleAssign()">
                <i :class="btnTrans.assign.icon"></i>
                {{ btnTrans.assign.text }}
              </button>
              <button v-show='showTable' type="button" :class="btnTrans.addList.class+' btn-lg tw-w-25'" @click.prevent="handleAddRow()">
                <i :class="btnTrans.addList.icon"></i>
                {{ btnTrans.addList.text }}รายการ
              </button>
            </div>
          </template>
        </div>
        <!-- Line -->
        <el-form  :model="dataTable"
                  ref="save_line"
                  class="form_table_line"
                  :rules='rules'>
          <div class='col-12'>
            <div class="table-responsive" v-show='showTable'>
              <table class="table table-bordered table_style">
                <thead>
                  <tr >
                    <th class="text-center" style="width: 250px;">ปีงบประมาณ <span class="text-danger"> * </span></th>
                    <th class="text-center" style="width: 150px;">อากรแสตมป์ (%)</th>
                    <th class="text-center" style="width: 150px;">ภาษี (%)</th>
                    <th class="text-center" style="width: 150px;">อัตราเบี้ย (%) <span class="text-danger"> * </span></th>
                    <th class="text-center" style="width: 300px;">เบี้ยประกันจ่ายล่วงหน้า (%) <span class="text-danger"> * </span></th>
                    <th class="text-center" style="width: 250px;">Management</th>
                    <th class="text-center" style="width: 100px;">Action</th>
                  </tr>
                </thead>
                <tbody >
                  <tr v-show="dataTable.policy_list.length" 
                      v-for='(policy_detail, index) in dataTable.policy_list' 
                      :key="index"
                      :class="[index == dataTable.policy_list.length - 1 ? 'endTableLines' : '']">
                    <th style="width: 150px;" class="el_field">
                      <el-form-item :prop="'policy_list.' + index + '.year'"
                                    :rules="rules.year"
                                    class="el-input--small el-form-item-irm0003 pb-2">
                        <datepicker-th  style="width: 100%;
                                        line-height: 30px;"
                                        class="el-input__inner style_icon_calendar"
                                        :name="`year${index}`"
                                        p-type="year"
                                        placeholder="ปีงบประมาณ"
                                        v-model="policy_detail.year"
                                        :format="vars.formatYear"
                                        @dateWasSelected="getValueYear(...arguments, index)"
                                        inputClass="input_date_small" />
                      </el-form-item>
                    </th>

                    <th class='text-right el_field currency_right'>
                      <el-form-item  class="currency_right el-form-item-irm0003 pb-2" >
                        <currency-input v-model="policy_detail.revenue_stamp"
                                        placeholder="อากรแสตมป์"
                                        :disabled="false"
                                        :decimal='5'
                                        :sizeSmall='true'
                                        class="currency_right"/>
                      </el-form-item>
                    </th>

                    <th class='el_field'>
                      <el-form-item class="currency_right el-form-item-irm0003 pb-2" >
                        <currency-input v-model="policy_detail.tax"
                                        placeholder="ภาษี"
                                        :sizeSmall='true'
                                        :disabled="false"/>
                      </el-form-item>
                    </th>

                    <th class='el_field'>
                      <el-form-item :prop="'policy_list.' + index + '.premium_rate'"
                                    :rules='rules.premium_rate'
                                    class="currency_right el-form-item-irm0003 pb-2">
                        <currency-input v-model="policy_detail.premium_rate"
                                        placeholder="อัตราเบี้ย"
                                        :disabled="false"
                                        :sizeSmall='true'
                                        :decimal='5'/>
                      </el-form-item>
                    </th>

                    <th class='el_field'>
                      <el-form-item :prop="'policy_list.' + index + '.prepaid_insurance'"
                                    :rules='rules.prepaid_insurance'
                                    class="currency_right el-form-item-irm0003 pb-2">
                        <currency-input v-model="policy_detail.prepaid_insurance"
                                        placeholder="เบี้ยประกันจ่ายล่วงหน้า"
                                        :sizeSmall='true'
                                        :disabled="false" />
                      </el-form-item>
                    </th>

                    <th style="width: 120px;" class="text-center pb-2">
                        <button type="button" :class="btnTrans.addList.class+' btn-sm tw-w-25'" @click="clickModal(index, policy_detail)"
                                  data-toggle="modal" :data-target="`#modal_detail${index}`">
                          <i :class="btnTrans.addList.icon"></i>
                          {{ btnTrans.addList.text }}รายละเอียด
                        </button>
                    </th>

                    <th style="width: 120px;" class="text-center" >
                      <el-form-item v-if='policy_detail.flg !== undefined' class="el-form-item-irm0003 pb-2">
                        <button type="button" :class="btnTrans.delete.class+' btn-sm tw-w-25'" @click.prevent="clickRemoveFlgAdd(index)">
                          <i :class="btnTrans.delete.icon"></i>
                          {{ btnTrans.delete.text }}
                        </button>
                      </el-form-item>
                    </th>
                  </tr>
                  <tr class="text-center" v-show="dataTable.policy_list.length === 0"><td colspan="9">ไม่มีข้อมูล</td></tr>
                </tbody>
                <tfoot></tfoot>
              </table>
            </div>
            <div class="col-12 p-0 text-right" v-if='showTable'>
                <button type="button" :class="btnTrans.save.class+' btn-lg tw-w-25'" @click.prevent="savePolicyGroup()">
                  <i :class="btnTrans.save.icon"></i>
                  {{ btnTrans.save.text }}
                </button>
                <button type="button" :class="btnTrans.cancel.class+' btn-lg tw-w-25'" @click.prevent="handleCancel()">
                  <i :class="btnTrans.cancel.icon"></i>
                  {{ btnTrans.cancel.text }}
                </button>
            </div>
          </div>
        </el-form>
        <div v-if="this.modal_open">
        <div class="modal inmodal fade" data-backdrop="static" data-keyboard="false" :id="`modal_detail${modalId}`" tabindex="-1" role="dialog"  aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" @click="closeModal()"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <p class="modal-title text-left"></p>
              </div>
              <div class="modal-body">
                <div class='col-12 mb-3 text-right'>
                  <button type="button" :class="btnTrans.addList.class+' btn-lg tw-w-25'" style="height: 35px;" @click="addDetailPolicyList()">
                    <i :class="btnTrans.addList.icon"></i>
                    {{ btnTrans.addList.text }}รายละเอียด
                  </button>
                </div>
                <el-form  :model="detail"
                          ref="modal"
                          class="form_table_line">
                  <div class='col-12'>
                    <div class="table-responsive">
                      <table class="table table-bordered table_style">
                        <thead>
                          <tr >
                            <th class="text-center" style="width: 300px;">บริษัทประกัน <span class="text-danger"> * </span></th>
                            <th class="text-center" style="width: 150px;">สัดส่วน(%) <span class="text-danger"> * </span></th>
                            <th class="text-center" style="width: 150px;">เลขที่กรมธรรม์</th>
                            <th class="text-center" style="width: 150px;">เลขที่สลักหลัง</th>
                            <th class="text-center" style="width: 150px;">ปัดเศษทศนิยมส่ง AP <span class="text-danger"> * </span></th>
                            <th class="text-center" style="width: 100px;">Action</th>
                          </tr>
                        </thead>
                        <tbody >
                          <tr v-for="(policy, index) in detail.detailPolicyList" 
                              :key="index" >
                              <td class='el_field'>
                                <el-form-item :prop="'detailPolicyList.' + index + '.company_code'"
                                          :rules='rules.company_code'
                                          class="el-form-item-irm0003 pb-2 mt-4">
                                  <el-select  v-model="policy.company_code"
                                              class='w-100'
                                              filterable
                                              name="policy_id"
                                              :loading="loading"
                                              :clearable="true"
                                              remote
                                              :popper-append-to-body="false"
                                              @change="handleCompanies(...arguments,index)">
                                    <el-option  v-for="company in companies"
                                                :key="company.company_id"
                                                :label="`${company.company_number} : ${company.company_name}`"
                                                :value="company.company_number">
                                    </el-option>
                                  </el-select>
                                </el-form-item>
                              </td>
                              <td class='el_field'>
                                <el-form-item :prop="'detailPolicyList.' + index + '.company_percent'"
                                                  :rules='rules.company_percent'
                                                  class="el-form-item-irm0003 pb-2 mt-4">
                                        <currency-input v-model="policy.company_percent"
                                                        placeholder="สัดส่วน"
                                                        :disabled="false" />
                                </el-form-item>
                                <!-- <vue-numeric style="width: 100%"
                                    name="company_percent"
                                    separator="," 
                                    v-bind:precision="2" 
                                    v-bind:minus="false"
                                    class="form-control text-right"
                                    v-model="policy.company_percent"
                                ></vue-numeric> -->

                              </td>
                              <td class='el_field'>
                                <el-input v-model="policy.user_policy_number" :maxlength="150" class="el-form-item-irm0003 pb-2"></el-input>
                              </td>
                              <td class='el_field'>
                                <el-input v-model="policy.comments" :maxlength="1000" class="el-form-item-irm0003 pb-2"></el-input>
                              </td>
                              <td class='el_field text-center'>
                                <el-checkbox  v-model="policy.default_diff_amount" 
                                              :checked="policy.default_diff_amount == 'Y' ? true : false" @change="checkDefaultDiff(policy, index)"
                                              class="el-form-item-irm0003 pb-2 mt-3">
                                </el-checkbox>
                              </td>
                              <td class='el_field text-center'>
                                <el-form-item v-if='policy.flg !== undefined' class="el-form-item-irm0003 pb-2 mt-3">
                                  <button type="button" :class="btnTrans.delete.class+' btn-sm tw-w-25'" @click.prevent="clickRemoveDetailFlgAdd(index)">
                                    <i :class="btnTrans.delete.icon"></i>
                                    {{ btnTrans.delete.text }}
                                  </button>
                                </el-form-item>
                              </td>

                            <!-- <th class="el_field">
                             <el-form-item :prop="'detailPolicyList.' + index + '.company_code'"
                                              :rules='rules.company_code'
                                              class="el-form-item-irm0003 pb-2 mt-3">
                                      <el-select  v-model="policy.company_code"
                                                  class='w-100'
                                                  filterable
                                                  name="policy_id"
                                                  :loading="loading"
                                                  :clearable="true"
                                                  remote
                                                  :popper-append-to-body="false"
                                                  @change="handleCompanies(...arguments,index)">
                                        <el-option  v-for="company in companies"
                                                    :key="company.company_id"
                                                    :label="`${company.company_number} : ${company.company_name}`"
                                                    :value="company.company_number">
                                        </el-option>
                                      </el-select>
                                    </el-form-item>
                            </th>
                            <th class='text-right el_field currency_right'>
                              <el-form-item :prop="'detailPolicyList.' + index + '.company_percent'"
                                                  :rules='rules.company_percent'
                                                  class="currency_right el-form-item-irm0003 pb-2 mt-3">
                                      <currency-input v-model="policy.company_percent"
                                                      placeholder="สัดส่วน"
                                                      :disabled="false" />
                              </el-form-item>
                            </th>
                            <th class='el_field'>
                              <el-input v-model="policy.user_policy_number" :maxlength="150"></el-input>
                            </th>
                            <th class='el_field'>
                              <el-input v-model="policy.comments" :maxlength="1000" ></el-input>
                            </th>
                            <th class='el_field text-center'>
                              <el-checkbox  v-model="policy.default_diff_amount" 
                                            :checked="policy.default_diff_amount == 'Y' ? true : false" @change="checkDefaultDiff(policy, index)">
                              </el-checkbox>
                            </th>
                            <th class='el_field text-center'>
                             <el-form-item v-if='policy.flg !== undefined' class="el-form-item-irm0003 pb-2">
                              <button type="button" :class="btnTrans.delete.class+' btn-sm tw-w-25'" @click.prevent="clickRemoveDetailFlgAdd(index)">
                                <i :class="btnTrans.delete.icon"></i>
                                {{ btnTrans.delete.text }}
                              </button>
                              </el-form-item>
                            </th> -->
                          </tr>
                          <tr class="text-center" v-show="dataTable.policy_list.length === 0"><td colspan="9">ไม่มีข้อมูล</td></tr>
                        </tbody>
                        <tfoot></tfoot>
                      </table>
                    </div>
                  </div>
                </el-form>
              </div>
              <div class="modal-footer">
                <button type="button" :class="btnTrans.save.class+' btn-lg tw-w-25'" @click.prevent="submitModal()">
                  <i :class="btnTrans.save.icon"></i>
                  {{ btnTrans.save.text }}
                </button>
              </div>
            </div>
          </div>
        </div>
        </div>
      </div>
  </div>
</template>

<script>
import currencyInput from '../../components/currencyInput'
import dateInput from '../../components/calendar/dateInput'
import lovPolicyHeaderId from './lovPolicy'
import moment from 'moment'

export default {
  name: 'ir-form-policy-group',
  data: () => {
    return {
      data: {
        policy_set: [],
      },
      policyGroup: [],
      group_code: '',
      group_description: '',
      value: '',
      loading: false,
      policyGroup_id: '',
      dataTable: {
        policy_list: [],
      },
      group_header_id: null,
      pickerOptions: {
        disabledDate(time) {
          return time.getTime() > Date.now();
        },
        shortcuts: [{
          text: 'Today',
          onClick(picker) {
            picker.$emit('pick', new Date());
          }
        }, {
          text: 'Yesterday',
          onClick(picker) {
            const date = new Date();
            date.setTime(date.getTime() - 3600 * 1000 * 24);
            picker.$emit('pick', date);
          }
        }, {
          text: 'A week ago',
          onClick(picker) {
            const date = new Date();
            date.setTime(date.getTime() - 3600 * 1000 * 24 * 7);
            picker.$emit('pick', date);
          }
        }]
      },
      dialogVisible: false,
      detail: {
        detailPolicyList: [],
      },
      policies: [],
      companies: [],
      showTable: false,
      modalId: 0,
      rules: {
        policy_set_header_id: [{
          required: true, message: 'กรุณาระบุกรมธรรม์', trigger: 'change'
        }],
        company_code: [{
          required: true, message: 'กรุณาระบุบริษัทประกัน', trigger: 'change'
        }],
        company_percent: [{
          required: true, message: 'กรุณาระบุสัดส่วน', trigger: 'change'
        }],
        premium_rate: [{
          required: true, message: 'กรุณาระบุอัตราเบี้ย', trigger: 'change'
        }],
        prepaid_insurance: [{
          required: true, message: 'กรุณาระบุเบี้ยประกันจ่ายล่วงหน้า', trigger: 'change'
        }],
        year: [{
          required: true, message: 'กรุณาระบุปี', trigger: 'change'
        }],
      },
      modalIndexActive: 0,
      dateFormat: 'DD/MM/YYYY',
      valid: true,
      errors: [],
      modal_open: false
    }
  },
  props: [
    'policy',
    'policyGroupHeader',
    'headerLovUrl',
    'groupLineUrl',
    'vars',
    'setYearCE',
    'btnTrans'
  ],
  methods: {
    getPolicyGroupDetail() {
      let id = window.location.href.split("/").pop()
      axios.get(`/ir/ajax/policy-group/${id}`)
      .then(({data: response}) => {
        this.data.policy_set = [...this.data.policy_set, ...response.data];
        this.group_code = response.data.length > 0 ? response.data[0].group_code : '';
        this.group_description = response.data.length > 0 ? response.data[0].group_description  : '';
        this.group_header_id = id;
        this.dataTable.policy_list = [...response.rows];
        // check has lists policy 04012022
        if (this.data.policy_set[0].policy_set_header_id == null || this.data.policy_set[0].policy_set_header_id == '') {
          this.valid = false;
        }
      })
      .catch((error) => {
        swal('Error', error, 'error');
      })
    },
    addRow() {
      this.data.policy_set.push({policy_set_header_id: '', policy_set_description: '', group_header_id: '', flg: 'add'});
      this.$nextTick(() => {
        const el = this.$el.getElementsByClassName('endTable')[0];
        if (el) {
          el.scrollIntoView();
        }
      });
    },
    clickRemove(index, policy) {
      if (policy.group_header_id) {
        let params = {
          group_set_id: policy.group_set_id,
          group_header_id: policy.group_header_id
        }
        this.loading = true
        axios.delete(`/ir/ajax/policy-group/group-sets`, {params})
        .then(({data: response}) => {
          this.loading = false
          this.data.policy_set.splice(index, 1)
          swal({
            title: "Success",
            text: 'บันทึกสำเร็จ',
            // timer: 3000,
            type: "success",
            // showCancelButton: false,
            // showConfirmButton: false
          })
        })
        .catch((error) => {
          if (error.response.data.status === 400) {
            swal({
              title: "Warning",
              text:  error.response.data.message,
              timer: 3000,
              type: "warning",
            })
          } else {
            swal({
              title: "Error",
              text:  error.response.data.message,
              timer: 3000,
              type: "error",
            })
          }
        })
      } else {
        this.data.policy_set.splice(index, 1)
      }
    },
    getPolicyGroupLov(params) {
      this.loading = true
      axios.get(`${this.headerLovUrl}`, { params })
      .then(({data: response}) => {
        this.loading = false
        this.policyGroup = response.data
      })
    },
    remoteMethod(query) {
      if (query !== "") {
          if (parseInt(query)) {
              this.getPolicyGroupLov({ group_header_id: query })
          } else {
              this.getPolicyGroupLov({ group_header_id: query })
          }
      } else {
          this.policyGroup = []
      }
    },
    handleAssign() {
      this.$refs.assign.validate((valid) => {
        if (valid) {
          this.showTable = true
        }
        else {
          return false
        }
      })
    },
    handleCancel() {
      window.location.replace(`/ir/settings/policy-group`)
    },
    addDetailPolicyList() {
      this.detail.detailPolicyList.push({
        company_code: '',
        company_percent: '',
        user_policy_number: '',
        comments: '',
        flg: 'add',
        default_diff_amount: false,
      })
    },
    clickRemoveDetailFlgAdd(index) {
      this.detail.detailPolicyList.splice(index, 1)
    },
    getPolicyLov(params) {
      this.loading = true
      axios.get(`/ir/ajax/lov/policy-set-header`, { params })
      .then(({data: response}) => {
        this.loading = false
        this.policies = response.data
      })
    },
    getCompanies(params) {
      axios.get(`/ir/ajax/lov/companies`, { params })
      .then(({data: response}) => {
        this.loading = false
        this.companies = response.data
      })
    },
    focusPolicies (value) {
      this.getPolicyLov({policy_set_header_id: ''})
    },
    savePolicyGroup() {
      this.$refs.save_line.validate((valid) => {
        const checkOverlap = (overlap) => overlap.isOverlap === true
        const checkNotfound = (data) => {
          return Object.keys(data).length === 0
        }
        if (this.dataTable.policy_list.find(policy => policy.group_dists_rows.some(checkNotfound))) {
          swal({
            title: "Warning",
            text: 'กรุณาเพิ่มรายละเอียดบริษัทประกัน!',
            // timer: 3000,
            type: "warning",
          })
        } else {
          let rows = []
          this.dataTable.policy_list.map((policy) => {
            let data = {
              ...policy,
              group_line_id: policy.group_line_id === undefined ? '' : policy.group_line_id,
              start_date: policy.start_date,
              end_date: policy.end_date
            }
            rows.push(data)
          })
          let params = {
            data: {
              group_code: this.group_code,
              group_description: this.group_description,
              active_flag: this.policy.active_flag || this.policy.active_flag === 'Y' ? this.policy.active_flag = 'Y' : this.policy.active_flag = 'N',    
              program_code: 'IRM0003',
              policy_sets_rows: this.data.policy_set.map(policy => ({policy_set_header_id: policy.policy_set_header_id, group_set_id: policy.group_set_id})),
              policy_lines_rows: rows,
              group_header_id: this.group_header_id
            }
          }
          if (this.dataTable.policy_list.length > 0) {
            this.$refs.save_line.validate((valid) => {
              if (valid) {
                if (this.reqDate()) {
                  axios.post(`/ir/ajax/policy-group/save`, params )
                  .then(({data: response}) => {
                    this.loading = false
                    // swal({
                    //   title: "Success",
                    //   text: 'บันทึกสำเร็จ',
                    //   timer: 3000,
                    //   type: "success",
                    //   showCancelButton: false,
                    //   showConfirmButton: false
                    // })
                    // setTimeout(() => {
                    //   window.location.href = '/ir/settings/policy-group'
                    // }, 3000);
                    swal({
                      title: "Success",
                      text: 'บันทึกสำเร็จ',
                      type: "success",
                      showCancelButton: false,
                      showConfirmButton: true
                    }, (isConfirm) => {
                        window.location.href = '/ir/settings/policy-group';
                    });
                  })
                  .catch(error => {
                    if (error.response.data.status === 400) {
                      swal({
                        title: "Warning",
                        text:  error.response.data.message,
                        timer: 3000,
                        type: "warning",
                      })
                    } else {
                      swal({
                        title: "Error",
                        text:  error.response.data.message,
                        timer: 3000,
                        type: "error",
                      })
                    }
                  })
                } 
              }
            })
          } else {
            axios.post(`/ir/ajax/policy-group/save`, params )
            .then(({data: response}) => {
              this.loading = false
              // swal({
              //   title: "Success",
              //   text: 'บันทึกสำเร็จ',
              //   timer: 3000,
              //   type: "success",
              //   showCancelButton: false,
              //   showConfirmButton: false
              // })
              // setTimeout(() => {
              //   window.location.href = '/ir/settings/policy-group'
              // }, 3000);
              swal({
                title: "Success",
                text: 'บันทึกสำเร็จ',
                type: "success",
                showCancelButton: false,
                showConfirmButton: true
              }, (isConfirm) => {
                  window.location.href = '/ir/settings/policy-group';
              });
            })
            .catch(error => {
              if (error.response.data.status === 400) {
                swal({
                  title: "Warning",
                  text:  error.response.data.message,
                  timer: 3000,
                  type: "warning",
                })
              } else {
                swal({
                  title: "Error",
                  text:  error.response.data.message,
                  timer: 3000,
                  type: "error",
                })
              }
            })
          }
        }
      });
    },
    clickModal (index, detail) {
      if (detail.year == '') {
        this.modal_open = false
          // detail.year = '';
          this.$refs.save_line.validateField('policy_list.' + index + '.year');
          // swal({
          //   title: "Warning",
          //   text: 'กรุณาใส่ข้อมูลปีงบประมาณ',
          //   type: "warning",
          //   showCancelButton: false,
          //   showConfirmButton: true
          // }, (isConfirm) => {
          // });
          swal({
              title: "Warning",
              text: 'กรุณาใส่ข้อมูลปีงบประมาณ!',
              // timer: 3000,
              type: "warning",
            })
      } else {
        this.modal_open = true
        this.dialogVisible = true
        this.modalId = index
        this.modalIndexActive = index
        if (Object.keys(detail.group_dists_rows[0]).length > 0) {
          this.detail.detailPolicyList = JSON.parse(JSON.stringify([...detail.group_dists_rows[0]]))
        } else {
          // this.detail.detailPolicyList = JSON.parse(JSON.stringify(detail.group_dists_rows[0]))
          this.detail.detailPolicyList = []
        }
      }
      
    },
    submitModal() {
      let found = this.detail.detailPolicyList.find((el) => {
          return el.default_diff_amount;
      });

      if (found) {
        this.$refs.modal.validate((valid) => {
          const checkDuplicate = () => {
            let company_code = this.detail.detailPolicyList.map(detail => detail.company_code)
            let isDuplicate = company_code.some((item, idx) => {
              return company_code.indexOf(item) != idx 
            })
            if (isDuplicate)
              swal({
                title: "Warning",
                text: 'บริษัทประกันห้ามซ้ำกัน!',
                type: "warning",
              })
            return isDuplicate
          }

          if (valid) {
            if (!this.checkSumOverdue() && !checkDuplicate()) {
              this.dataTable.policy_list[this.modalIndexActive].group_dists_rows = JSON.parse(JSON.stringify([[...this.detail.detailPolicyList]]))
              this.dialogVisible = false
              // document.getElementsByClassName('close')[0].click()
              // this.closeModal()

              this.savePolicyGroup();
            }
          }
        })
      }
      else {
        swal({
              title: "Warning",
              text: 'กรุณาระบุข้อมูลให้ครบ',
              type: "warning",
            })
      }
    },
    getDateStart(date, index) {
      const vm = this
      if (date === null) {
        vm.dataTable.policy_list[index].start_date = ''
        vm.dataTable.policy_list[index].start_timer = ''
        this.$refs.save_line.validateField(`policy_list.${index}.start_date`)
      } else {
        vm.dataTable.policy_list[index].start_date = moment(date).format(vm.dateFormat)
        vm.dataTable.policy_list[index].start_timer = moment(date).unix()
        vm.checkDateOverlap(moment(date).format(vm.dateFormat), index)
        this.$refs.save_line.fields.find((f) => f.prop == `policy_list.${index}.start_date`).clearValidate()
      }
    },
    getDateEnd(date, index) {
      const vm = this
      if (date === null) {
        vm.dataTable.policy_list[index].end_date = ''
        vm.dataTable.policy_list[index].end_timer = ''
        this.$refs.save_line.validateField(`policy_list.${index}.end_date`)
      } else {
        vm.dataTable.policy_list[index].end_date = moment(date).format(vm.dateFormat)
        vm.dataTable.policy_list[index].end_timer = moment(date).unix()
        vm.checkDateOverlap(moment(date).format(vm.dateFormat), index)
        this.$refs.save_line.fields.find((f) => f.prop == `policy_list.${index}.end_date`).clearValidate()
      }
    },
    reqDate () {
      if (!this.checkCalculateDate()) {
        swal({
          title: "Warning",
          text: 'ฟิลด์วันที่เริ่มต้นต้องน้อยกว่าหรือเท่ากับฟิลด์วันที่สิ้นสุด!',
          // timer: 3000,
          type: "warning",
        })
        return false
      }
      return true
    },
    checkCalculateDate () {
      const vm = this
      let checkDate = null
      for (let policy of vm.dataTable.policy_list) {
        if (policy.start_timer <= policy.end_timer) {
          checkDate = true
        } else if (policy.start_timer > policy.end_timer) {
          checkDate = false 
          return 
        } else {
          checkDate = true
        }
      }
      return checkDate
    },
    checkDateOverlap (date, index) {
      const vm = this
      let params = {
        data: {
          policy_lines_rows: vm.dataTable.policy_list.map(({start_date, end_date}) => {
            return {start_date, end_date}
          }),
          date,
          index_number: index
        }
      }
      axios.post(`/ir/ajax/policy-group/overlap-check`, params)
      .then((response) => {
        vm.dataTable.policy_list[index].isOverlap = false
      })
      .catch((error) => {
        vm.dataTable.policy_list[index].isOverlap = true
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
    },
    checkSumOverdue() {
      let sum = 0
      this.detail.detailPolicyList.map(policy => {
        sum += +policy.company_percent
      })
      if (sum > 100) {
        swal({
          title: "Warning",
          text: 'สัดส่วนรวมกันต้องไม่เกิน 100%',
          // timer: 3000,
          type: "warning",
        })
        return true
      } else if (sum < 100) {
        swal({
          title: "Warning",
          text: 'สัดส่วนรวมกันต้องได้ 100%',
          // timer: 3000,
          type: "warning",
        })
        return true
      } else if (sum === 100) {
        return false
      }
    },
    handleCompanies(value, index) {
      if (value) {
        for (let i in this.companies) {
          let data = this.companies[i]
          if (value === data.company_number) {
            this.detail.detailPolicyList[index].company_id  = data.company_id
            // this.callbackTypeCode(data.account_combine, data.account_id)
          }
        }
      }
    },
    handleAddRow() {
      const vm = this
      vm.dataTable.policy_list.push(
        {
          start_date: '',
          start_timer: '',
          end_date: '',
          end_timer: '',
          revenue_stamp: '',
          tax: '',
          premium_rate: 0,
          prepaid_insurance: 0,
          flg: 'add',
          group_dists_rows: [{}],
          year: ''
        }
      )
      vm.$nextTick(() => {
        const el = vm.$el.getElementsByClassName('endTableLines')[0];
        if (el) {
          el.scrollIntoView();
        }
      });
    },
    clickRemoveFlgAdd(index) {
      this.dataTable.policy_list.splice(index, 1)
    },
    setDate (value) {
      let date = ''
      if (value && value !== null && value !== undefined) {
        let arrYearCE = value ? value.split('/') : value
        let yearCE = +arrYearCE[2] - 543
        date = `${arrYearCE[0]}/${arrYearCE[1]}/${yearCE}`
      }
      return date
    },
    receivedFullDate(date) {
    },
    selectPolicy (value, index) {
      this.valid = true;
      this.data.policy_set[index].policy_set_header_id = value
      this.checkDuplicatePolicyGroup(value, index);
    },
    remoteMethodPolicy (query) {
      this.getPolicyLov({ policy_set_header_id: '', keyword: query });
    },
    checkDuplicatePolicyGroup (id, index) {
      let params = {
        group_header_id: this.group_header_id
      }
      axios.get(`/ir/ajax/policy-group/duplicate-check/${id}`, {params})
      .then((response) => {
        for (let i = 0; i < this.data.policy_set.length; i++) {
          let arrayHeaderId = JSON.parse(JSON.stringify(this.data.policy_set.map(({policy_set_header_id: id}) => id)))
          let headerId = this.data.policy_set[i].policy_set_header_id.toString()
          arrayHeaderId.splice(i, 1)
          if (arrayHeaderId.includes(headerId)) {
            swal({
              title: "Warning",
              text:  'กรมธรรม์ห้ามซ้ำกันภายในกลุ่ม',
              // timer: 3000,
              type: "warning",
            })
            this.data.policy_set[index].policy_set_header_id = '';
            return
          }
        }
      })
      .catch((error) => {
        this.data.policy_set[index].policy_set_header_id = ''
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
        if (this.data.policy_set[0].policy_set_header_id == null || this.data.policy_set[0].policy_set_header_id == '') {
          this.valid = false;
        }
      })
    },
    closeModal() {
      const vm = this
      vm.detail.detailPolicyList = []
    },
    getValueYear (date, index) {
      let formatYear = this.vars.formatYear;
      if (date) {
        this.dataTable.policy_list[index].year = moment(date).format(formatYear);
        this.$refs.save_line.fields.find((f) => f.prop == 'policy_list.' + index + '.year').clearValidate();
       } else {
        this.dataTable.policy_list[index].year = '';
        this.dataTable.policy_list[index].start_date = '';
        this.dataTable.policy_list[index].end_date = '';
        this.$refs.save_line.validateField('policy_list.' + index + '.year');
      }
      this.checkYearDuplicate(this.dataTable.policy_list[index].year, index);
    },
    getDataInsuranceDate (year, index) {
      let params = {
        year: this.setYearCE('year', year),
        keyword: ''
      }
      axios.get(`/ir/ajax/lov/effective-date`, { params })
      .then(({data}) => {
        let response = data.data;
        if (response === null) {
          this.dataTable.policy_list[index].start_date = '';
          this.dataTable.policy_list[index].end_date = '';
          this.$refs.save_line.validateField('policy_list.' + index + '.start_date');
          this.$refs.save_line.validateField('policy_list.' + index + '.end_date');
        } else {
          this.dataTable.policy_list[index].start_date = response.start_date_active;
          this.dataTable.policy_list[index].end_date = response.end_date_active;
          this.$refs.save_line.fields.find((f) => f.prop == 'policy_list.' + index + '.start_date').clearValidate();
          this.$refs.save_line.fields.find((f) => f.prop == 'policy_list.' + index + '.end_date').clearValidate();
        }
      })
      .catch((error) => {
        swal('Error', error, 'error')
      })
    },
    checkYearDuplicate (year, index) {
      let table = this.dataTable.policy_list;
      let _this = this;
      let yearVal = table.map(row => row.year)
      let isDuplicate = yearVal.some((item, idx) => {
        if (item) {
          return yearVal.indexOf(item) != idx 
        }
      })
      if (isDuplicate) {
        swal({
          title: "Warning",
          text: "ปีห้ามซ้ำ!",
          type: "warning",
        },
        function(isConfirm) {
          if (isConfirm) {
            table[index].year = '';
            _this.$refs.save_line.validateField('policy_list.' + index + '.year');
            // _this.getDataInsuranceDate(table[index].year, index);
          }
        });
      // } else {
      //   this.getDataInsuranceDate(year, index);
      }
    },

    checkDefaultDiff(policy, index) {
      // console.log('func checkDefaultDiff default_diff_amount <--> ', policy.default_diff_amount);
      // console.log('func checkDefaultDiff index <--> ', index);
      if (policy.default_diff_amount) {
        this.detail.detailPolicyList.forEach((element, i) => {
          if (element.default_diff_amount == true || element.default_diff_amount == "Y") {
            if (i != index) {

              policy.default_diff_amount  = false;

              swal({
                title: "Warning",
                text: 'มีการระบุบริษัทประกันอื่นเรียบร้อยแล้ว กรุณาตรวจสอบ',
                type: "warning",
              });
            }
          }
        });
      }
    }
  },
  computed: {
    disabledField () {
      if (this.action === 'edit') {
        return true
      }
      return false
    }
  },
  mounted() {
    this.getPolicyGroupDetail()
    this.getPolicyLov({policy_set_header_id: ''})
    this.getCompanies({company_id: '', company_name: '' })
  },
  components: {
    dateInput,
    currencyInput,
    lovPolicyHeaderId
  },
  // created() {
  //   const vm = this
  //   vm.getPolicyGroupDetail()
  // }
}
</script>