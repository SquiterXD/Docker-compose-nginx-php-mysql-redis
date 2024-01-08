<template>
  <div class="ibox">
    <div class="ibox-title">
      <h5>Detail / Create New</h5><br>
      <h5>ข้อมูลทะเบียนยานพาหนะ</h5>
      <div class="ibox-tools">
        <button type="button" 
                :class="btnTrans.ins_expire.class+' btn-lg tw-w-25'"
                data-toggle="modal"
                :data-target="`#modal_expire_date`">
          <i :class="btnTrans.ins_expire.icon"></i> วันสิ้นอายุประกัน
        </button>
      </div>
    </div>
    <div class="ibox-content">
      <form-vehicle :vehicle="vehicle"
                    :flag="flag"
                    :isNullOrUndefined="funcs.isNullOrUndefined"
                    :expireDate="expireDate"
                    :sold="sold"
                    :account_id="accountId"
                    :typeCost="type_cost"
                    :account="account"
                    :btn-trans="btnTrans"
                    :defaultValueSetName="defaultValueSetName"
                    ref="save_vehicle"
                    @accountSplit="getValueAccount"
                    @descSplit="getValueAccountDesc"
                    :asset-number="vehicle.asset_number"/>

      <modal-expire-date :vars="vars"
                        :expireDate="expireDate"
                        @expire-date="getValueExpireDate" />

      <modal-sold :vars="vars"
                :sold="sold"
                :vehicle="vehicle"
                @sold="getValueSoldCar" />

      <modal-account-code :accounts="account"
                          ref="editTableLineModalAccountCode"
                          @account-code="clearReqAccountCode"
                          @account-name="clearReqAccountName"
                          :accountId="accountId"
                          @accountid="getAccount"
                          :type_cost="type_cost" />
    </div>
  </div>
</template>

<script>
import formVehicle from './form'
import * as scripts from '../../scripts'
import modalExpireDate from './modalExpireDate'
import modalAccountCode from './modalAccountCode'
import modalSold from './modalSold'
export default {
  name: 'ir-settings-vehicle-create',
  data () {
    return{
      vehicle: {
        license_plate: '',
        group_code: '',
        category_segment4: '',
        vehicle_type_code: '',
        vehicle_type_name: '',
        vehicle_brand_code: '',
        vehicle_brand_name: '',
        vehicle_cc: '',
        engine_number: '',
        tank_number: '',
        return_vat_flag: true,
        vat_percent: '',
        revenue_stamp_percent: '',
        insurance_type_code: '',
        asset_number: '',
        account_number: '',
        account_description: '',
        active_flag: true,
        policy_set_header_id: '',
        sold_flag: false,
        location_code: '',
        location_description: '',
        renew_car_act: this.defaultInput.car_act,
        renew_car_license_plate: this.defaultInput.car_license,
        renew_car_inspection: this.defaultInput.car_inspection
      },
      flag: 'add',
      funcs: scripts.funcs,
      tableVehicle: [],
      expireDate: {
        insurance_expire_date: '',
        license_plate_expire_date: '',
        acts_expire_date: '',
        car_inspection_expire_date: ''
      },
      sold: {
        sold_date: '',
        reason: '',
        sold_flag: '',
      },
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
      type_cost: '',
      vars: scripts.vars
    }
  },
  props: [
    'isNullOrUndefined', 'defaultInput', 'btnTrans', 'defaultValueSetName'
  ], 
  methods: {
    getValueExpireDate (obj) {
      this.expireDate = obj;
    },
    getValueSoldCar (obj) {
      this.sold = obj;
    },
    setValueExpireDate (obj) {
      return {
        insurance_expire_date: obj.insurance_expire_date,
        license_plate_expire_date: obj.license_plate_expire_date,
        acts_expire_date: obj.acts_expire_date,
        car_inspection_expire_date: obj.car_inspection_expire_date
      };
    } ,
    clickModalAccount (obj, index) {
      this.indexTable = index;
      this.account = obj.account;
      this.$refs.editTableLineModalAccountCode.$refs.modal_account_mapping.clearValidate();
      this.accountId = obj.account_id;
      this.type_cost = obj.type_cost;
    },
    clearReqAccountCode (value) {
      // if (value) {
      //   this.$refs.save_vehicle.$refs.save_vehicle.fields.find((f) => f.prop == 'account_number').clearValidate()
      // } else {
      //   this.$refs.save_vehicle.$refs.save_vehicle.validateField('account_number')
      // }
      this.vehicle.account_number = value;
    },
    clearReqAccountName (value) {
      this.vehicle.account_description = value;
    },
    getAccount (value) {
      this.vehicle.account_id = value ? +value : value;
    },
    getValueAccount (obj) {
       
      this.account = obj;
    },
    getValueAccountDesc (obj) {
       
      this.description = obj;
    },
  },
  components: {
    formVehicle,
    modalExpireDate,
    modalAccountCode,
    modalSold
  }
}
</script>
