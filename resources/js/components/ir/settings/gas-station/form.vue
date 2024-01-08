<template>
  <div>
    <el-form  :model="gas_station"
              :rules="rules" 
              ref="save_gas_station" 
              label-width="120px" 
              class="demo-ruleForm">
      <div class="col-lg-11">
        <div class="row">
          <div class="col-md-1"></div>
          <label class="col-md-2 col-form-label lable_align">
            <strong>ประเภทสถานีน้ำมัน <span class="text-danger"> * </span></strong>
          </label>
          <div class="col-xl-3 col-lg-3 col-md-3 el_field">
            <el-form-item prop="type_code">
              <el-input placeholder="ประเภทสถานีน้ำมัน" 
                        v-model="gas_station.type_code"
                        :disabled="action === 'edit' ? true : false" />
            </el-form-item>
          </div>
          
          <label class="col-md-2 col-form-label lable_align">
            <strong>กรมธรรม์ชุดที่ <span class="text-danger"> * </span></strong>
          </label>
          <div class="col-xl-3 col-lg-3 col-md-3 el_field">
            <el-form-item prop="policy_set_header_id">
              <lov-policy-group v-model="gas_station.policy_set_header_id"
                                name="policy_set_header_id"
                                :disabled="false"
                                placeholder="กรมธรรม์ชุดที่"
                                @change-lov-policy-group="getDataPocilySetHeader"
                                :policy_set_header_id="gas_station.policy_set_header_id" />
            </el-form-item>
          </div>
        </div>
        <div class="row">
          <div class="col-md-1"></div>
          <label class="col-md-2 col-form-label lable_align">
            <strong>วันที่คิดค่าเบี้ยประกัน</strong>
          </label>
          <div class="col-xl-3 col-lg-3 col-md-3 el_field">
            <el-form-item prop="insurance_date">
                  <datepicker-th  style="width: 100%;"
                                  class="el-input__inner"
                                  :name="`insurance_date`"
                                  p-type="date"
                                  placeholder="วันที่คิดค่าเบี้ยประกัน"
                                  v-model="gas_station.insurance_date"
                                  :format="vars.formatDate"
                                  @dateWasSelected="getValueInsuranceDate" />
                </el-form-item>
          </div>
          <label class="col-md-2 col-form-label lable_align">
            <strong>กลุ่ม</strong>
          </label>
          <div class="col-xl-3 col-lg-3 col-md-3 el_field">
            <el-form-item>
              <el-input placeholder="กลุ่ม" 
                        v-model="group_desc"
                        :disabled="true" />
            </el-form-item>
            <!-- <el-form-item prop="group_code">
              <el-select  v-model="gas_station.group_code" 
                          placeholder="กลุ่ม"
                          @change="changeGroup" >
                <el-option  v-for="(data, index) in group"
                            :key="index"
                            :label="data.meaning"
                            :value="data.group_code">
                </el-option>
              </el-select>
            </el-form-item> -->
          </div>
        </div>
        <div class="row">
          <div class="col-md-1"></div>
          <label class="col-md-2 col-form-label lable_align">
            <strong>ทุนประกัน</strong>
          </label>
          <div class="col-xl-3 col-lg-3 col-md-3 el_field">
            <currency-input v-model="gas_station.coverage_amount"
                              name="coverage_amount"
                              :sizeSmall="false"
                              placeholder="ทุนประกัน"/>
          </div>
          
          <label class="col-md-2 col-form-label lable_align">
            <strong>ภาษี (%)</strong>
          </label>
          <div class="col-xl-3 col-lg-3 col-md-3 el_field">
            <el-form-item>
              <!-- <currency-input v-model="gas_station.vat_percent"
                              placeholder="ภาษี (%)"
                              :disabled="false"
                              attrName="vat_percent" /> -->
              <currency-input v-model="gas_station.vat_percent"
                              name="vat_percent"
                              :sizeSmall="false"
                              placeholder="ภาษี (%)"
                              :disabled="true" />
            </el-form-item>
          </div>
        </div>
        <div class="row">
          <div class="col-md-1"></div>
          <label class="col-md-2 col-form-label lable_align">
            <strong>อากร (บาท)</strong>
          </label>
          <div class="col-xl-3 col-lg-3 col-md-3 el_field">
            <el-form-item>
              <!-- <currency-input v-model="gas_station.revenue_stamp_percent"
                              placeholder="อากร (%)"
                              :disabled="false"
                              attrName="revenue_stamp_percent" /> -->
              
              <currency-input v-model="gas_station.revenue_stamp_percent"
                              name="revenue_stamp_percent"
                              :sizeSmall="false"
                              placeholder="อากร (บาท)"/>
            </el-form-item>
          </div>
          <label class="col-md-2 col-form-label lable_align">
            <strong>ประเภทค่าใช้จ่าย <span class="text-danger"> * </span></strong>
          </label>
          <div class="col-xl-3 col-lg-3 col-md-3 el_field">
            <el-form-item prop="type_cost">
              <lov-type-cost  v-model="gas_station.type_cost"
                              :account_id="gas_station.account_id"
                              @change-lov="getDataTypeCostAccountCombine" />
            </el-form-item>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-1"></div>
          <label class="col-md-2 col-form-label lable_align">
            <strong>ภาษีขอคืนได้</strong>
          </label>
          <div class="col-xl-3 col-lg-3 col-md-3 el_field">
            <el-form-item style="margin-bottom: 15px;">
              <input  type="checkbox"
                      v-model="gas_station.return_vat_flag">
              <!-- <el-checkbox  v-model="gas_station.return_vat_flag" /> -->
            </el-form-item>
          </div>
          
          <label class="col-md-2 col-form-label lable_align">
            <strong>รหัสบัญชี</strong>
          </label>
          <div class="col-xl-3 col-lg-3 col-md-3 el_field">
            <el-form-item>
              <el-input placeholder="รหัสบัญชี" 
                        v-model="gas_station.account_combine"
                        disabled />
            </el-form-item>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-1"></div>
          <label class="col-md-2 col-form-label lable_align">
            <strong>Active</strong>
          </label>
          <div class="col-xl-4 col-lg-5 col-md-6 el_field">
            <el-form-item style="margin-bottom: 0px;">
              <input  type="checkbox"
                      v-model="gas_station.active_flag">
            </el-form-item>
          </div>
        </div>
      </div>
      <div class="text-right el_field">
        <el-form-item>
          <button type="button" :class="btnTrans.save.class" @click.prevent="clickSave()" :disabled="valid">
            <i :class="btnTrans.save.icon"></i>
            {{ btnTrans.save.text }}
          </button>
          <button type="button" :class="btnTrans.cancel.class" @click.prevent="clickCancel()">
            <i :class="btnTrans.cancel.icon"></i>
            {{ btnTrans.cancel.text }}
          </button>
        </el-form-item>
      </div>
    </el-form>
  </div>
</template>

<script>
import currencyInput from '../../components/currencyInput'
import lovTypeCost from './lovTypeCost'
import lovPolicyGroup from './lovPolicyGroup'

import * as scripts from '../../scripts'
import moment from 'moment'

export default {
  name: 'ir-settings-gas-station-form',
  data () {
    return {
      rules: {
        type_code: [
          {required: true, message: 'กรุณาระบุประเภทสถานีน้ำมัน', trigger: 'blur'}
        ],
        policy_set_header_id: [
          {required: true, message: 'กรุณาระบุกรมธรรม์ชุดที่', trigger: 'change'}
        ],
        type_cost: [
          {required: true, message: 'กรุณาระบุประเภทค่าใช้จ่าย', trigger: 'change'}
        ]
      },
      group: [],
      group_desc: '',
      tax: '',
      revenue_stamp: '',
      valid: false,
      
      vars: scripts.vars,
    }
  },
  props: [
    'gas_station',
    'tableGasStation',
    'isNullOrUndefined',
    'action',
    'expireDate',
    'btnTrans'
  ],
  methods: {
    getDataGroup (params) {
       
      axios.get(`/ir/ajax/lov/group-code-policy`, { params })
      .then(({data}) => {
        if (data.data === null) {
          this.gas_station.group_code = ''
          this.group_desc = ''
        } else {
          this.gas_station.group_code = data.data.group_code
          this.group_desc = data.data.group_desc
        }
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    clickSave() {
       
      this.$refs.save_gas_station.validate((valid) => {
        if (valid) {
          let data = {
            ...this.gas_station,
            return_vat_flag: this.gas_station.return_vat_flag ? 'Y' : 'N',
            active_flag: this.gas_station.active_flag ? 'Y' : 'N',
            program_code: 'IRM0008',
            ...this.expireDate
          }
          this.actionSave(data)
        } else {
          return false;
        }
      })
    },
    clickCancel () {
      window.location.href = '/ir/settings/gas-station'
    },
    changeGroup (value) {
      this.gas_station.group_code = value
    },
    actionSave (data) {
       
      if (this.action === 'add') {
        axios.post(`/ir/ajax/gas-stations`, { data })
        .then(({data}) => {
          // swal({
          //   title: "Success",
          //   text: data.message,
          //   type: "success",
          //   showConfirmButton: false,
          //   closeOnConfirm: false,
          //   timer: 5000
          // })
          // setTimeout(() => {
          //    window.location.href = '/ir/settings/gas-station'
          // }, 5000)
          // // window.location.href = '/ir/settings/gas-station'
          swal({
              title: "Success",
              text: data.message,
              type: "success",
              showConfirmButton: true,
          }, (isConfirm) => {
              window.location.href = '/ir/settings/gas-station';
          });
        })
        .catch((error) => {
          if (error.response.data.status === 400) {
            swal("Warning", error.response.data.message, "warning");
          } else {
            swal("Error", error, "error");
          }
        })
      } else {
        axios.put(`/ir/ajax/gas-stations`, { data })
        .then(({data}) => {
          // swal({
          //   title: "Success",
          //   text: data.message,
          //   type: "success",
          //   showConfirmButton: false,
          //   closeOnConfirm: false,
          //   timer: 5000
          // });
          // setTimeout(() => {
          //   window.location.href = '/ir/settings/gas-station'
          // }, 5000)
          // // window.location.href = '/ir/settings/gas-station'

          swal({
              title: "Success",
              text: data.message,
              type: "success",
              showConfirmButton: true,
          }, (isConfirm) => {
              window.location.href = '/ir/settings/gas-station';
          });
        })
        .catch((error) => {
          swal("Error", error, "error");
        })
      }
    },
    getDataTypeCostAccountCombine (obj) {
       
      this.gas_station.type_cost = obj.code
      this.gas_station.account_id = obj.id
      this.gas_station.account_combine = obj.account_combine
    },
    getDataPocilySetHeader (obj) {
       
      this.gas_station.policy_set_header_id = obj.id
      // this.getDataGroup({
      //   policy_set_header_id : obj.id
      // })
           this.getTaxStamp({policy_set_header_id : obj.id,}) 
    },
     getTaxStamp (params) {
      this.valid = false;
      axios.get(`/ir/ajax/lov/premium-rate`, { params })
      .then(({data}) => {
        this.gas_station.vat_percent = data.data.tax
        // this.gas_station.revenue_stamp_percent = data.data.revenue_stamp
      })
      .catch((error) => {
        this.valid = true;
        swal("Error", 'ไม่มีข้อมูลปีงบประมาณที่หน้าจอ IRM0003', "error");
      })
    },
    getValueInsuranceDate (date) {
      let formatDate = this.vars.formatDate;
      if (date) {
        this.gas_station.insurance_date = moment(date).format(formatDate);
      } else {
        this.gas_station.insurance_date = '';
      }
    },
  },
  components: {
    currencyInput,
    lovTypeCost,
    lovPolicyGroup
  },
  watch: {
    'gas_station.policy_set_header_id' (newVal, oldVal) {
       
      this.getDataGroup({
        policy_set_header_id : newVal
      })
    }
  },
  created() {
    this.getValueInsuranceDate(this.gas_station.insurance_date);
  },
}
</script>

