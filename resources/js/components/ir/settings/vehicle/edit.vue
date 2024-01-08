<template>
  <div class="ibox">
    <div class="ibox-title" style="padding-bottom: 20px;">
      <h5>ข้อมูลยานพาหนะ (Vehicles)</h5>
      <div class="ibox-tools">
        <button type="button" 
                class="btn btn-warning"
                data-toggle="modal"
                :data-target="`#modal_expire_date`">
          <i class="fa fa-calendar"></i> วันสิ้นอายุประกัน
        </button>
      </div>
    </div>
    <div class="ibox-content">
      <form-vehicle :vehicle="vehicle"
                  :flag="flag"
                  :sold="sold"
                  :isNullOrUndefined="funcs.isNullOrUndefined"
                  :expireDate="expireDate"
                  :defaultValueSetName="defaultValueSetName"
                  @accountSplit="getValueAccount"
                  @descSplit="getValueAccountDesc"
                  :btn-trans="btnTrans"
                  :asset-number="vehicle.asset_number"/>

      <modal-expire-date :vars="vars"
                        :expireDate="expireDate"
                        @expire-date="getValueExpireDate" />

      <modal-account-code :accounts="account"
                        ref="editTableLineModalAccountCode"
                        @account-code="clearReqAccountCode"
                        @account-name="clearReqAccountName"
                        :accountId="accountId"
                        @accountid="getAccount"
                        :type_cost="type_cost" /> 

      <modal-sold :vehicle="vehicle"
                :vars="vars" 
                :sold="sold"
                @sold="getValueSoldCar" />
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
  name: 'ir-settings-vehicle-edit',
  data () {
    return {
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
        return_vat_flag: false,
        vat_percent: '',
        revenue_stamp_percent: '',
        insurance_type_code: '',
        asset_number: '',
        account_number: '',
        account_description: '',
        active_flag: false,
        policy_set_header_id: '',
        flag: 'edit',
        sold_flag: false
      },
      flag: 'edit',
      funcs: scripts.funcs,
      tableVehicle: [],
      tax: '',
      revenue_stamp: '',
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
    'assetId',
    'vehicleId',
    'btnTrans', 'defaultValueSetName'
  ],
  methods: {
    getDataEdit (asset_id, vehicleId)  {
      axios.get(`/ir/ajax/vehicles/edit?asset_id=${asset_id}&vehicle_id=${vehicleId}`)
      .then(({data}) => {
        let res = data.data
        this.vehicle = this.setPropertyForm(res, asset_id)
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    getValueSoldCar (obj) {
      this.sold = obj;
     },
    getTableVehicle() {
      this.getDataEdit(this.assetId, this.vehicleId)
    },
    setPropertyForm (obj, asset_id) {
      obj.return_vat_flag = obj.return_vat_flag === 'Y' ? true : false
      obj.active_flag = obj.active_flag === 'Y' ? true : false
      obj.sold_flag= obj.sold_flag === 'Y' ? true : false
      obj.vehicle_id = obj.vehicle_id
      if (asset_id) {
        this.tableVehicle.filter((vehicle) => {
          if (vehicle.asset_id == asset_id) {
            obj.vehicle_brand_name = vehicle.vehicle_brand_name
            obj.vehicle_type_name = vehicle.vehicle_type_name
          }
        })
        this.expireDate = this.setValueExpireDate(obj);
        return obj
      } else {
        this.expireDate = this.setValueExpireDate(obj);
        return obj
      }
    },
    getValueExpireDate (obj) {
      this.expireDate = obj;
    },
    getValueAccount (obj) {
       
      this.account = obj;
    },
    getValueAccountDesc (obj) {
       
      this.description = obj;
    },
    setValueExpireDate (obj) {
      return {
        insurance_expire_date: obj.insurance_expire_date,
        license_plate_expire_date: obj.license_plate_expire_date,
        acts_expire_date: obj.acts_expire_date,
        car_inspection_expire_date: obj.car_inspection_expire_date
      };
    },
     clearReqAccountCode (value) {
        // if (value) {
        //   this.$refs.save_vehicle_edit.$refs.save_vehicle.fields.find((f) => f.prop == 'account_number').clearValidate();
        // } else {
        //   this.$refs.save_vehicle_edit.$refs.save_vehicle.validateField('account_number');
        // }
        this.vehicle.account_number = value;
      },
      clearReqAccountName (value) {
        // if (value) {
        //   this.$refs.save_vehicle_edit.$refs.save_vehicle.fields.find((f) => f.prop == 'account_description').clearValidate();
        // } else {
        //   this.$refs.save_vehicle_edit.$refs.save_vehicle.validateField('account_description');
        // }
        this.vehicle.account_description = value;
      },
      getAccount (value) {
        this.vehicle.account_id = value ? +value : value;
      },
       clickModalAccount (obj) {
        this.indexTable = index;
        this.account = obj.account;
        this.$refs.editTableLineModalAccountCode.$refs.modal_account_mapping.clearValidate();
        this.accountId = obj.account_id;
        this.type_cost = obj.type_cost;
      },
  },
  mounted () {
    // this.getDataEdit(this.assetId)
  },
  components: {
    formVehicle,
    modalExpireDate,
    modalAccountCode,
    modalSold
  },
  created () {
    this.getTableVehicle()
  }
}
</script>
