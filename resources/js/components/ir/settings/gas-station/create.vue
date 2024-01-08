<template>
  <div class="ibox">
    <div class="ibox-title">
      <h5>Detail / Create New</h5><br>
      <h5>ข้อมูลสถานีน้ำมัน</h5>
      <div class="ibox-tools">
        <button type="button" 
                class="btn btn-warning btn-lg"
                data-toggle="modal"
                :data-target="`#modal_expire_date`">
          <i class="fa fa-calendar"></i> วันสิ้นอายุประกัน
        </button>
      </div>
    </div>
    <div class="ibox-content">
      <form-gas :gas_station="gas_station"
                :isNullOrUndefined="funcs.isNullOrUndefined"
                :action="action"
                :expireDate="expireDate"
                :btn-trans="btnTrans" />

      <modal-expire-date  :vars="vars"
                          :expireDate="expireDate"
                          @expire-date="getValueExpireDate"
                          :btn-trans="btnTrans" />
    </div>
  </div>
</template>

<script>
import formGas from './form'
import * as scripts from '../../scripts'
import modalExpireDate from './modalExpireDate'
export default {
  name: 'ir-settings-gas-station-create',
  props: [
    'btnTrans'
  ],
  data () {
    return {
      gas_station: {
        gas_station_id: '',
        type_code: '',
        group_code: '',
        group_name: '',
        return_vat_flag: true,
        vat_percent: '',
        revenue_stamp_percent: '',
        type_cost: '',
        account_combine: '',
        active_flag: true,
        account_id: '',
        policy_set_header_id: '',
        insurance_date: '',
        coverage_amount: '',
      },
      action: 'add',
      funcs: scripts.funcs,
      expireDate: {
        insurance_expire_date: ''
      },
      vars: scripts.vars
    }
  },
  methods: {
    getValueExpireDate (obj) {
      this.expireDate = obj;
    }
  },
  components: {
    formGas,
    modalExpireDate
  }
}
</script>
