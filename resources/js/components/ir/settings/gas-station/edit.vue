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
import moment from 'moment'
export default {
  name: 'ir-settings-gas-station-edit',
  data () {
    return {
      gas_station: {
        gas_station_id: '',
        type_code: '',
        group_code: '',
        group_name: '',
        return_vat_flag: false,
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
      action: 'edit',
      funcs: scripts.funcs,
      expireDate: {
        insurance_expire_date: ''
      },
      vars: scripts.vars
    }
  },
  props: [
    'gasStationId', 'btnTrans'
  ],
  methods: {
    getDataEdit (gas_station_id) {
      axios.get(`/ir/ajax/gas-stations/${gas_station_id}`)
      .then(({data}) => {
        let res = data.data
        let object = {
          ...res,
          return_vat_flag: res.return_vat_flag === 'Y' ? true : false,
          active_flag: res.active_flag === 'Y' ? true : false,
          type_cost: '',
          account_combine: ''
        }
        this.gas_station = object;
        this.expireDate = this.setValueExpireDate(object);
        this.getInsuranceDate(object);
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    getAccountCombine (params) {
      axios.get(`/ir/ajax/lov/account-code-combine`, { params })
      .then(({data}) => {
        let res = data.data
         
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    getValueExpireDate (obj) {
      this.expireDate = obj;
    },
    setValueExpireDate (obj) {
      return {
        insurance_expire_date: obj.insurance_expire_date
      };
    },
    async getInsuranceDate (obj) {
      let formatDate = this.vars.formatDate;
      // return {
        // insurance_expire_date: obj.insurance_expire_date
        // obj.insurance_date = this.funcs.showYearBE("month", obj.insurance_date);
        // obj.insurance_date = moment(obj.insurance_date).format(formatDate);
        // var date1 = await helperDate.parseToDateTh(obj.insurance_date, formatDate);

        //  obj.insurance_date = date1;
        obj.insurance_date = moment(obj.insurance_date )
                                .add(+543, "years")
                                .format(this.vars.formatDate);
      // };
    },
  },
  mounted () {
    this.getDataEdit(this.gasStationId)
    // this.getAccountCombine({
    //   account_id: '',
    //   keyword: ''
    // })
  },
  components: {
    formGas,
    modalExpireDate
  }
}
</script>
