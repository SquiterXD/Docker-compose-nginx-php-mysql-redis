<template>
  <div>
    <el-form :model="vehicle"
              :rules="rules"
              ref="save_vehicle"
              class="demo-ruleForm">
      <div class="col-lg-12">
        <div class="row">
          <label class="col-md-2 text-right pt-2">
            <strong> ทะเบียนรถ <span class="text-danger"> * </span></strong>
          </label>
          <div class="col-xl-3 col-lg-3 col-md-3">
            <el-form-item prop="license_plate">
              <el-input placeholder="ทะเบียนรถ" 
                        v-model="vehicle.license_plate"
                        name="license_plate"
                        :disabled="this.disable_fix" />
            </el-form-item>
          </div>
          <label class="col-md-2 text-right pt-2">
            <strong> กรมธรรม์ชุดที่ <span class="text-danger"> * </span></strong>
          </label>
          <div class="col-xl-5 col-lg-5 col-md-5">
            <el-form-item prop="policy_set_header_id">
              <lov-policy-group v-model="vehicle.policy_set_header_id"
                                name="policy_set_description"
                                :disabled="this.disable_fix"
                                placeholder="กรมธรรม์ชุดที่"
                                @change-lov-policy-group="getDataPocilySetHeader" />
            </el-form-item>
          </div>
        </div>

        <div class="row">
          <label class="col-md-2 text-right pt-2">
            <strong> รหัสทรัพย์สิน </strong>
          </label>
          <div class="col-xl-3 col-lg-3 col-md-3">
            <el-form-item>
              <el-input placeholder="รหัสทรัพย์สิน" 
                        v-model="vehicle.asset_number"
                        :disabled="this.disable_fix || this.disable_manual" />
            </el-form-item>
          </div>
          <label class="col-md-2 text-right pt-2">
            <strong> กลุ่ม </strong>
          </label>
          <div class="col-xl-5 col-lg-5 col-md-5">
            <el-form-item>
                <el-input placeholder="กลุ่ม" 
                        v-model="group_desc"
                        :disabled="this.disable_fix || this.disable_manual" />
              </el-form-item>
          </div>
        </div>
        <div class="row">
          <label class="col-md-2 text-right pt-2">
            <strong> หมวด <span class="text-danger"> * </span></strong>
          </label>
          <div class="col-xl-3 col-lg-3 col-md-3">
            <el-form-item prop="category_segment4">
              <lov-parent-flex v-model="vehicle.category_segment4"
                              name="category_segment4"
                              placeholder="หมวด"
                              size=""
                              :popperBody="true"
                              @change-lov="getValueParentFlex"
                              :disabled="this.disable_fix"
                              :data="vehicle" />
            </el-form-item>
          </div>
          <label class="col-md-2 text-right pt-2">
            <strong> ภาษี (%) <span class="text-danger"> * </span></strong>
          </label>
          <div class="col-xl-5 col-lg-5 col-md-5">
            <el-form-item prop="vat_percent">
              <currency-input v-model="vehicle.vat_percent"
                              name="vat_percent"
                              :sizeSmall="false"
                              placeholder="ภาษี (%)"
                              :disabled="this.disable_fix || this.disable_manual" />
            </el-form-item>
          </div>
        </div>
        <div class="row">
          <label class="col-md-2 text-right pt-2">
            <strong> ประเภทรถ <span class="text-danger"> * </span></strong>
          </label>
          <div class="col-xl-3 col-lg-3 col-md-3">
            <el-form-item prop="vehicle_type_code">
              <lov-vehicle-type v-model="vehicle.vehicle_type_code"
                              name="vehicle_type_code"
                              placeholder="ประเภทยานพาหนะ"
                              size=""
                              :popperBody="true"
                              @change-lov="getValueVehicleType"
                              :disabled="this.disable_fix"
                              :data="vehicle" 
                              :cat_seg4="vehicle.category_segment4"/>
            </el-form-item>
          </div>
          <label class="col-md-2 text-right pt-2">
            <strong> รหัสบัญชี <span class="text-danger"> * </span></strong>
          </label>
          <div class="col-xl-5 col-lg-5 col-md-5">
            <!-- <modalAccountCode :coa="vehicle? vehicle.account_number: ''"
                      :typeCost="type_cost"
                      :account="account"
                      :defaultValueSetName="defaultValueSetName"
                      @resCoa="getCoa"
                    /> -->

            <el-form-item prop="account_number">
              <div style="padding-top: 3px;">
                <el-input placeholder="รหัสบัญชี" 
                          v-model="vehicle.account_number"
                          @focus="focusNotKey()"
                          @change="accountEnter(vehicle)"
                          size="small"
                          name="account_number" 
                          style="font-size: 12px;">
                  <el-button  slot="append"
                              data-toggle="modal"
                              @click="clickModalAccount"
                              :data-target="`#modal_account`">
                    <i class="fa fa-search"></i>
                  </el-button>
                </el-input>
               </div> 
            </el-form-item>
          </div>
        </div>

        <div class="row">
          <label class="col-md-2 text-right pt-2">
            <strong> ยี่ห้อรถ <span class="text-danger"> * </span></strong>
          </label>
          <div class="col-xl-3 col-lg-3 col-md-3">
            <el-form-item prop="vehicle_brand_code">
              <lov-vehicle-brand v-model="vehicle.vehicle_brand_code"
                                  name="vehicle_brand_code"
                                  placeholder="ยีห้อยานพาหนะ"
                                  size=""
                                  :popperBody="true"
                                  @change-lov="getValueVehicleBrand"
                                  :disabled="this.disable_fix"
                                  :data="vehicle" />
            </el-form-item>
          </div>
          <label class="col-md-2 text-right pt-2">
            <strong> คำอธิบายรหัสบัญชี </strong>
          </label>
          <div class="col-xl-5 col-lg-5 col-md-5">
            <el-form-item>
              <el-input placeholder="คำอธิบาย" 
                        v-model="desc_coa"
                        :disabled="true" />
            </el-form-item>
          </div>
        </div>

        <div class="row">
          <label class="col-md-2 text-right pt-2">
            <strong> ซีซี. รถยนต์ </strong>
          </label>
          <div class="col-xl-3 col-lg-3 col-md-3">
            <el-form-item>
              <el-input placeholder="ซีซี. รถยนต์" 
                        v-model="vehicle.vehicle_cc"
                        :disabled="this.disable_fix" />
            </el-form-item>
          </div>
          <label class="col-md-2 text-right pt-2">
            <strong> รหัสสถานที่ <span class="text-danger"> * </span></strong>
          </label>
          <div class="col-xl-5 col-lg-5 col-md-5">
            <el-form-item prop="location_code">
              <location-input-value
                set-name="FA_LOCATION"
                :set-data="vehicle.location_code"
                placeholder="รหัสสถานที่"
                @getLocation="getLocation"
              />
            </el-form-item>
          </div>
        </div>

        <div class="row">
          <label class="col-md-2 text-right pt-2">
            <strong> หมายเลขเครื่องยนต์ </strong>
          </label>
          <div class="col-xl-3 col-lg-3 col-md-3">
            <el-form-item>
              <el-input placeholder="หมายเลขเครื่องยนต์" 
                        v-model="vehicle.engine_number"
                        :disabled="this.disable_fix" />
            </el-form-item>
          </div>
          <label class="col-md-2 text-right pt-2">
            <strong> คำอธิบายสถานที่ </strong>
          </label>
          <div class="col-xl-5 col-lg-5 col-md-5">
            <el-form-item>
              <el-input placeholder="คำอธิบายสถานที่" 
                        v-model="vehicle.location_description"
                        :disabled="true" />
            </el-form-item>
          </div>
        </div>

        <div class="row">
          <label class="col-md-2 text-right pt-2">
            <strong> หมายเลขตัวถัง </strong>
          </label>
          <div class="col-xl-3 col-lg-3 col-md-3">
            <el-form-item>
              <el-input placeholder="หมายเลขตัวถัง" 
                        v-model="vehicle.tank_number"
                        :disabled="this.disable_fix" />
            </el-form-item>
          </div>
          <label class="col-md-2 text-right pt-2">
            <strong> ประเภทประกันรถยนต์ </strong>
          </label>
          <div class="col-xl-5 col-lg-5 col-md-5">
            <el-form-item prop="insurance_type_code">
              <lov-insurance-type v-model="vehicle.insurance_type_code"
                                  name="insurance_type_code"
                                  placeholder="ประเภทประกันรถยนต์"
                                  :popperBody="true"
                                  @change-lov="getValueInsuranceType"
                                  :disabled="false"
                                  :data="vehicle" />
            </el-form-item>
          </div>
        </div>

        <div class="row">
          <label class="col-md-2 text-right pt-2">
            <strong> ขายรถ </strong>
          </label>
          <div class="col-xl-3 col-lg-3 col-md-3">
            <div class="row">
              <div class="col-2">
                <el-form-item style="margin-bottom: 15px;">
                  <input type="checkbox"
                          name="sold_checkbox"
                          v-model="vehicle.sold_flag"
                          :checked="vehicle.sold_flag"
                          @change="clickModalSold"
                          :disabled="sold.reason != '' || vehicle.sold_flag != '' || this.disable_fix" >
                </el-form-item>
                <!-- <input-sold :vehicle="vehicle"
                    :sold="sold"
                    :vars="vars"
                    :disable-fix="this.disable_fix"/> -->
              </div>
              <div class="col-10 mt-2">
                {{ formatDate(vehicle.sold_date) }}
              </div>
            </div>
            <!-- <el-form-item style="margin-bottom: 15px;">
              <input type="checkbox"
                      v-model="vehicle.sold_flag"
                      @change="clickModalSold"
                      v-show="true"
                      :disabled="sold.reason != '' || vehicle.sold_flag != '' || this.disable_fix" >
            </el-form-item> -->
            
            <!-- <label>
              xxx{{ vehicle.sold_date }}
            </label> -->
          </div>
          <label class="col-md-2 text-right pt-2">
            <strong> ประเภทประกัน พ.ร.บ. </strong>
          </label>
          <div class="col-xl-5 col-lg-5 col-md-5">
            <el-form-item>
              <input-lookup-component
                set-name="PTIR_RENEW_CAR_ACT"
                :set-data="vehicle.renew_car_act"
                placeholder="ประเภทประกัน พ.ร.บ."
                @selLookup="selLookup"
              />
            </el-form-item>
          </div>
        </div>

        <div class="row">
          <label class="col-md-2 text-right pt-2">
            <strong> ขอคืนภาษี </strong>
          </label>
          <div class="col-xl-3 col-lg-3 col-md-3">
            <el-form-item style="margin-bottom: 15px;">
              <input  type="checkbox"
                      v-model="vehicle.return_vat_flag"
                      :disabled="this.disable_fix">
            </el-form-item>
          </div>
          <label class="col-md-2 text-right pt-2">
            <strong> ประเภทประกันป้ายทะเบียน </strong>
          </label>
          <div class="col-xl-5 col-lg-5 col-md-5">
            <el-form-item>
              <input-lookup-component
                set-name="PTIR_RENEW_CAR_LICENSE_PLATE"
                :set-data="vehicle.renew_car_license_plate"
                placeholder="ประเภทประกันป้ายทะเบียน"
                @selLookup="selLookup"
              />
            </el-form-item>
          </div>
        </div>

        <div class="row">
          <label class="col-md-2 text-right pt-2"> <strong>Active</strong> </label>
          <div class="col-xl-3 col-lg-3 col-md-3">
            <el-form-item style="margin-bottom: 0px;">
              <input  type="checkbox"
                      v-model="vehicle.active_flag"
                      :disabled="sold.reason != '' || vehicle.sold_flag != '' " /> 
                      <!-- &nbsp; <strong style="font-size: 12px;"> Active </strong> -->
            </el-form-item>
          </div>
          <label class="col-md-2 text-right pt-2">
            <strong> ประเภทประกันตรวจสภาพ </strong>
          </label>
          <div class="col-xl-5 col-lg-5 col-md-5">
            <el-form-item>
              <input-lookup-component
                set-name="PTIR_RENEW_CAR_INSPECTION"
                :set-data="vehicle.renew_car_inspection"
                placeholder="ประเภทประกันตรวจสภาพ"
                @selLookup="selLookup"
              />
            </el-form-item>
          </div>
        </div>

        <!-- <div class="row">
          
          
        </div> -->

        <!-- <div class="row">
          <label class="col-md-2 text-right pt-2">
            <strong> อากร (%) <span class="text-danger"> * </span></strong>
          </label>
          <div class="col-xl-3 col-lg-3 col-md-3">
            <el-form-item prop="revenue_stamp_percent">
              <currency-input v-model="vehicle.revenue_stamp_percent"
                              name="revenue_stamp_percent"
                              :sizeSmall="false"
                              placeholder="อากร (%)"
                              :disabled="this.disable_fix || this.disable_manual" />
            </el-form-item>
          </div>
        </div> -->

        <button type="button" 
                class="btn btn-warning"
                data-toggle="modal"
                :data-target="`#modal_sold_car`"
                v-show="false"
                ref="soldd">
        </button>
      </div>
      <div class="text-right el_field">
        <el-form-item>
          <button type="button" :class="btnTrans.save.class+' btn-lg tw-w-25'" @click.prevent="clickSave()">
            <i :class="btnTrans.save.icon"></i>
            {{ btnTrans.save.text }}
          </button>
          <button type="button" :class="btnTrans.cancel.class+' btn-lg tw-w-25'" @click.prevent="clickCancel()">
            <i :class="btnTrans.cancel.icon"></i>
            {{ btnTrans.cancel.text }}
          </button>
        </el-form-item>
      </div>
    </el-form>
  </div>
</template>

<script>
import lovSearch from './lovSearch'
import currencyInput from '../../components/currencyInput'
import lovPolicyGroup from './lovPolicyGroup'
import lovVehicleType from './lovTypeVehicle'
import lovVehicleBrand from './lovBrandVehicle'
import lovParentFlex from './lovParentFlex'
import lovInsuranceType from './lovInsuranceType'
import modalAccountCode from './modalAccountCode'
import modalSold from './modalSold'
import * as scripts from '../../scripts'
// Piyawut A. 07012022
import InputLookupComponent from './InputLookupComponent'
import LocationInputValue from './LocationInputValueComponent'
import moment from 'moment'

import inputSold from './SoldComponent'
export default {
  name: 'ir-settings-vehicle-form',
  data () {
    return {
      rules: {
        license_plate: [
          {required: this.flag != 'edit' , message: 'กรุณาระบุทะเบียนรถ', trigger: 'change'}
        ],
        policy_set_header_id: [
          {required: true, message: 'กรุณาระบุกรมธรรม์ชุดที่', trigger: 'blur'}
        ],
        vehicle_type_code: [
          {required: true, message: 'กรุณาระบุประเภทรถ', trigger: 'blur'}
        ],
        vehicle_brand_code: [
          {required: true, message: 'กรุณาระบุยี่ห้อรถ', trigger: 'change'}
        ],
        // vat_percent: [
        //   {required: true, message: 'กรุณาระบุภาษี', trigger: 'change'}
        // ],
        // revenue_stamp_percent: [
        //   {required: true, message: 'กรุณาระบุอากร', trigger: 'change'}
        // ],
        account_number: [
          {required: true, message: 'กรุณาระบุรหัสบัญชี', trigger: 'change'}
        ],
        category_segment4: [
          {required: true, message: 'กรุณาระบุหมวด', trigger: 'blur'}
        ],
        location_code: [
          {required: true, message: 'กรุณารหัสสถานที่', trigger: 'blur'}
        ]
      },
      group: [],
      insuranceType: [],
      group_desc: '',
      tax: '',
      revenue_stamp: '',
      account_name: '',
      accountId: '',
      account: {
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
      },
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
      },
      desc_coa: '',
      type_cost: '',
      vars: scripts.vars,
      disable_manual: false,
      disable_fix: false,
      sold_date: '',
    }
  },
  props: [
    'vehicle',
    'action',
    'expireDate',
    'isNullOrUndefined',
    'flag',
    'sold',
    'btnTrans',
    'defaultValueSetName'
  ],
  computed: {
    vehicleType () {
      if (this.isNullOrUndefined(this.vehicle.vehicle_type_name)) {
        return this.vehicle.vehicle_type_code + ': ' + this.vehicle.vehicle_type_name
      }
      return ''
    },
    vehicleBrand () {
      if (this.isNullOrUndefined(this.vehicle.vehicle_brand_name)) {
        return this.vehicle.vehicle_brand_name
      }
      return this.vehicle.vehicle_brand_code
    },
  },
  methods: {
    getDataGroup (params) {
      axios.get(`/ir/ajax/lov/group-code-policy`, { params })
      .then(({data}) => {
        if (data.data === null) {
          this.vehicle.group_code = ''
          this.group_desc = ''
        } else {
          this.vehicle.group_code = data.data.group_code
          this.group_desc = data.data.group_desc
        }
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    focusNotKey () {
      $(".readonly").on("keydown paste focus mousedown", function(e) {
        if(e.keyCode != 9) {
          e.preventDefault();
        }
      })
    },
    clickModalAccount () {
      let accountSplit = this.vehicle.account_number.split('.')
      let accountDescSplit = this.vehicle.account_description.split('.')
      let indexAccount = 0
      let indexDesc = 0
      this.account.company = '';
      this.account.evm = '';
      this.account.department = '';
      this.account.cost_center = '';
      this.account.budget_year = '';
      this.account.budget_type = '';
      this.account.budget_detail = '';
      this.account.budget_reason = '';
      this.account.main_account = '';
      this.account.sub_account = '';
      this.account.reserved1 = '';
      this.account.reserved2 = '';

      this.description.company = '';
      this.description.evm = '';
      this.description.department = '';
      this.description.cost_center = '';
      this.description.budget_year = '';
      this.description.budget_type = '';
      this.description.budget_detail = '';
      this.description.budget_reason = '';
      this.description.main_account = '';
      this.description.sub_account = '';
      this.description.reserved1 = '';
      this.description.reserved2 = '';

      if (this.vehicle.account_number) {
        for (let code in this.account) {
          this.account[code] = accountSplit[indexAccount]
          indexAccount++
        }
      }
      if (this.vehicle.account_description) {
        for (let code in this.description) {
          this.description[code] = accountDescSplit[indexDesc]
          indexDesc++
        }
      }
      this.type_cost = this.type_cost;
      this.$emit('accountSplit',this.account);
      this.$emit('descSplit',this.description);
      this.$emit('type_cost', this.type_cost);
    },
    clickModalSold () {
       
      // if (this.vehicle.sold_flag) {
         
      this.$refs.soldd.click()
      
      //   this.vehicle.active_flag = false;
      // }

      // this.vehicle.sold_flag = false;
    },
    getDataInsuranceType (value) {
      this.vehicle.insurance_type_code = value
    },
    getDataCustomer (value) {
      this.company.customer_id = value
    },
    clickSave() {
      this.$refs.save_vehicle.validate((valid) => {
        if (valid) { 
          let params = { license_plate: this.vehicle.license_plate}
          let _this = this;
          if (this.vehicle.license_plate) { 
            if (this.flag!= 'edit') { 
              axios.get(`/ir/ajax/vehicles/duplicate-check?license_plate=`, {params})
              .then( res => {
                let data = {
                  ...this.vehicle,
                  return_vat_flag: this.vehicle.return_vat_flag ? 'Y' : 'N',
                  active_flag: this.vehicle.active_flag ? 'Y' : 'N',
                  sold_flag: this.vehicle.sold_flag ? 'Y' : 'N',
                  program_code: 'IRM0007',
                  ...this.expireDate,
                  ...this.sold
                }
                axios.post(`/ir/ajax/vehicles`,{ data } )
                .then(res => { 
                  if (res.data.status == 'S') {
                    swal({
                      title: 'สร้างข้อมูลยานพาหนะ',
                      text: '<span style="font-size: 16px; text-align: left;"> ทำการสร้างข้อมูลยานพาหนะเรียบร้อย </span>',
                      type: "success",
                      html: true
                    })
                    setTimeout(() => {
                      window.location.href = '/ir/settings/vehicle'
                    }, 5000)
                  }else{
                    swal({
                      title: 'สร้างข้อมูลยานพาหนะ',
                      text: '<span style="font-size: 16px; text-align: left;">'+res.data.msg+'</span>',
                      type: "warning",
                      html: true
                    })
                  }
                })
                .catch((error) => {
                  swal("Error", error, "error");
                })
              })
              .catch((error) => {
                if (error.response.data.status === 400) {
                  swal({
                    title: "Warning",
                    text:  'ไม่สามารถบันทึกได้ เนื่องจากทะเบียนรถซ้ำกัน',
                    type: "warning",
                  })
                } else {
                  swal({
                    title: "Error",
                    text:  error.response.data.message,
                    type: "error",
                  })
                }
              })
            } else {
              let data = {
                ...this.vehicle,
                return_vat_flag: this.vehicle.return_vat_flag ? 'Y' : 'N',
                active_flag: this.vehicle.active_flag ? 'Y' : 'N',
                sold_flag: this.vehicle.sold_flag ? 'Y' : 'N',
                program_code: 'IRM0007',
                ...this.expireDate,
                ...this.sold
              }
              axios.post(`/ir/ajax/vehicles`,{ data } )
              .then(res => {
                if (res.data.status == 'S') {
                  swal({
                    title: 'อัพเดตข้อมูลยานพาหนะ',
                    text: '<span style="font-size: 16px; text-align: left;"> ทำการอัพเดตข้อมูลยานพาหนะเรียบร้อย </span>',
                    type: "success",
                    html: true
                  })
                  setTimeout(() => {
                    window.location.href = '/ir/settings/vehicle'
                  }, 5000)
                }else{
                  swal({
                    title: 'อัพเดตข้อมูลยานพาหนะ',
                    text: '<span style="font-size: 16px; text-align: left;">'+res.data.msg+'</span>',
                    type: "warning",
                    html: true
                  })
                }
              })
              .catch((error) => {
                swal("Error", error, "error");
              })
            }
          } else {
            return false;
          }
        }
      })
    },
    clickCancel () {
      window.location.href = '/ir/settings/vehicle'
    },
    changeGroup (value) {
      this.vehicle.group_code = value
    },
    getValueRevenueStampPercent (value) {
      this.vehicle.revenue_stamp_percent = value
    },
    getDataPocilySetHeader (obj) {
      this.vehicle.policy_set_header_id = obj.id
      this.getTaxStamp({policy_set_header_id : obj.id})
    },
    getTaxStamp (params) {
      axios.get(`/ir/ajax/lov/vehicle-rate`, { params })
      .then(({data}) => {
        this.vehicle.vat_percent = this.vehicle.vat_percent? this.vehicle.vat_percent: data.data.tax;
        this.vehicle.revenue_stamp_percent = this.vehicle.revenue_stamp_percent? this.vehicle.revenue_stamp_percent: data.data.revenue_stamp;
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    getValueInsuranceType (obj) {
      this.vehicle.insurance_type_code = obj.code
      this.vehicle.insurance_type_desc = obj.desc
    },
    getValueVehicleType (obj) {
      this.vehicle.vehicle_type_code = obj.code
      this.vehicle.vehicle_type_name = obj.desc
    },
    getValueVehicleBrand (obj) {
      this.vehicle.vehicle_brand_code = obj.code
      this.vehicle.vehicle_brand_name = obj.desc
    },
    getValueParentFlex (obj) {
      this.vehicle.category_segment4 = obj.code
    },
    getLocation(res){
      this.vehicle.location_code = res.value_code;
      this.vehicle.location_description = res.value_name;
    },
    selLookup(res){
      if (res.name == 'PTIR_RENEW_CAR_ACT') {
        this.vehicle.renew_car_act = res.value;
      }
      if (res.name == 'PTIR_RENEW_CAR_LICENSE_PLATE') {
        
        this.vehicle.renew_car_license_plate = res.value;
      }
      if (res.name == 'PTIR_RENEW_CAR_INSPECTION') {
        this.vehicle.renew_car_inspection = res.value;
      }
    },
    splitDescriptionCoa(){
      axios.get("/ir/ajax/vehicles/get-coa-desc", {
                params: {coa: this.vehicle.account_number}
              })
      .then(res => {
          this.vehicle.account_description = res.data.desc_full;
          this.desc_coa = res.data.desc_disply;
      });
    },
    accountEnter(obj) {
      var coaEnter = obj.account_number;
      var coa = coaEnter.split('.');
        if (coa.length != 12) {
          swal({
              title: "Warning",
              text: "กรอกชุดบัญชีไม่ครบ กรุณาตรวจสอบใหม่",
              type: "warning",
              closeOnConfirm: true
          },
          function (isConfirm) {
              if (isConfirm) {
              }
          });
        }

        if (coa[0] == '' || coa[1] == '' || coa[2] == '' || coa[3] == '' || coa[4] == '' || coa[5] == '' || coa[6] == '' || coa[7] == '' || coa[8] == '' || coa[9] == '' || coa[10] == '' || coa[11] == '') {
          swal({
            title: "Warning",
            text: "กรอกชุดบัญชีไม่ครบ กรุณาตรวจสอบใหม่",
            type: "warning",
            closeOnConfirm: true
          });
        } else {
          axios.get("/ir/ajax/vehicles/get-coa-desc", {
                    params: {coa: coaEnter}
                  })
          .then(res => {
              if (res.data.status == 'E') {
                let msg = 'ไม่มีข้อมูลรหัสบัญชี : ' + res.data.return_account_code;
                swal({
                  title: "Warning",
                  text: msg,
                  type: "warning",
                  closeOnConfirm: true
                });
                this.vehicle.account_number = '';
              } else {
                this.vehicle.account_number = coaEnter;
                this.vehicle.account_description = res.data.desc_full;
                this.desc_coa = res.data.desc_disply;
              }
          });
        }
    },
    getDataType() {
       
       
      if (this.flag == 'edit') {
        if (this.vehicle.asset_number) {
          this.disable_fix = true;
          if (this.vehicle.sold_flag == 'Y') {
            let formatDate = this.vars.formatDate;
            this.sold_date = moment(this.vehicle.sold_date).format(formatDate);
          }
           
        }else{
          this.disable_manual = true;
          if (this.vehicle.sold_flag == 'Y') {
            let formatDate = this.vars.formatDate;
            this.sold_date = moment(this.vehicle.creation_date).format(formatDate);
          }
        }
      }
      
      if (this.flag == 'add') {
        this.disable_manual = true;
      }
    },
    formatDate(date){
      if (date) {
        return moment(date).format(this.vars.formatDate);
      }
    }
  },
  components: {
    lovSearch,
    currencyInput,
    lovPolicyGroup,
    lovInsuranceType,
    lovVehicleType,
    lovVehicleBrand,
    lovParentFlex,
    modalAccountCode,
    modalSold,
    InputLookupComponent,
    LocationInputValue,
    inputSold
  },
  watch: {
    'vehicle.policy_set_header_id'(newVal, oldVal) {
      this.getDataGroup({
        policy_set_header_id : newVal
      })
    },
    'vehicle.account_description'(newVal, oldVal) {
      this.splitDescriptionCoa();
    },
    'vehicle'() {
      this.getDataType();
      this.accountEnter(this.vehicle);
    },
    'vehicle.sold_flag'() {
      // if (this.sold.sold_flag == 'Y') {
      //   this.vehicle.sold_flag   = true;
      //   this.vehicle.active_flag = false;

      //   $('input[name="sold_checkbox"]').prop('checked', true);
      // } else {
      //   this.vehicle.sold_flag   = false;
      //   this.vehicle.active_flag = true;

      //   $('input[name="sold_checkbox"]').prop('checked', false);
      // }

      if (this.sold.sold_flag == 'Y') {
        this.vehicle.sold_flag   = true;
        this.vehicle.active_flag = false;

        $('input[name="sold_checkbox"]').prop('checked', true);
      } else {
        this.vehicle.sold_flag   = false;
        this.vehicle.active_flag = true;

        $('input[name="sold_checkbox"]').prop('checked', false);
      }
    },
    'sold.sold_flag'() {
      // if (this.sold.sold_flag == 'Y') {
      //   this.vehicle.sold_flag   = true;
      //   this.vehicle.active_flag = false;
      // } else {
      //   this.vehicle.sold_flag   = false;
      //   this.vehicle.active_flag = true;
      // }
      if (this.sold.sold_flag == 'Y') {
        this.vehicle.sold_flag   = true;
        this.vehicle.active_flag = false;

        $('input[name="sold_checkbox"]').prop('checked', true);
      } else {
        this.vehicle.sold_flag   = false;
        this.vehicle.active_flag = true;

        $('input[name="sold_checkbox"]').prop('checked', false);
      }
    },
  },
  mounted (){
    // this.getDataType();
    if (this.flag == 'add') {
      this.disable_manual = true;
    }
  },
}

</script>