<template>
  <div class="table-responsive margin_top_20">
    <table  class="table table-bordered"
            style="display: block; overflow: auto; max-height: 500px;">
      <thead>
        <tr>
          <th style="min-width: 200px;" class="text-center">ประเภทสถานีน้ำมัน</th>
          <th style="min-width: 110px;" class="text-center">กลุ่ม</th>
          <th style="min-width: 200px;" class="text-center">วันที่คิดค่าเบี้ยประกัน</th>
          <th style="min-width: 110px;" class="text-center">ทุนประกัน</th>
          <th style="min-width: 110px;" class="text-center">ขอคืนภาษีได้</th>
          <th style="min-width: 110px;" class="text-center">ภาษี (%)</th>
          <th style="min-width: 110px;" class="text-center">อากร (บาท)</th>
          <th style="min-width: 200px; width: 1%;" class="text-center">รหัสบัญชี</th>
          <th style="min-width: 110px;" class="text-center">Active</th>
          <th style="min-width: 110px;" class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-show="tableGasStation.length > 0" 
            v-for="(data, index) in tableGasStation" 
            :key="index">
          <td class="text-left">{{isNullOrUndefined(data.type_code)}}</td>
          <td class="text-center">{{isNullOrUndefined(data.group_name)}}</td>
          <td class="text-center">{{ data.insurance_date ? getFormatDate(data.insurance_date) : '' }}</td>
          <td class="text-right">
            {{ isNullOrUndefined(data.coverage_amount) ? formatCurrency(data.coverage_amount) : isNullOrUndefined(data.coverage_amount) }}
          </td>
          <td  class="text-center">
            <div  class="form-check"
                  style="position: inherit;">
              <input  class="form-check-input" 
                      type="checkbox"
                      v-model="data.return_vat_flag"
                      @change="changeCheckedReturnVatFlg(data)"
                      style="position: inherit;">
            </div>
          </td>
          <td  class="text-center">
            {{isNullOrUndefined(data.vat_percent) ?
            formatCurrency(data.vat_percent) :
            isNullOrUndefined(data.vat_percent)}}
          </td>
          <td  class="text-right">
            {{isNullOrUndefined(data.revenue_stamp_percent) ?
            formatCurrency(data.revenue_stamp_percent) :
            isNullOrUndefined(data.revenue_stamp_percent)}}
          </td>
          <td  class="text-left">{{isNullOrUndefined(data.account_combine)}}</td>
          <td  class="text-center">
            <div  class="form-check"
                  style="position: inherit;">
              <input  class="form-check-input" 
                      type="checkbox"
                      v-model="data.active_flag"
                      @change="changeCheckedActive(data)"
                      style="position: inherit;">
            </div>
          </td>
          <td  class="text-center">
            <a  type="button" 
                :href="`/ir/settings/gas-station/edit/${data.gas_station_id}`"
                :class="btnTrans.edit.class+' btn-sm tw-w-25'">
              <i :class="btnTrans.edit.icon"></i> {{ btnTrans.edit.text }}
            </a>
          </td>
        </tr>
        <tr class="text-center" v-if="tableGasStation.length === 0"><td colspan="10">ไม่มีข้อมูล</td></tr>
      </tbody>
      <tfoot></tfoot>
    </table>
  </div>
</template>

<script>
import * as scripts from '../../scripts'
import moment from 'moment'
export default {
  name: 'ir-settings-gas-station-table',
  data () {
    return {
      vars: scripts.vars,
    }
  },
  props: [
    'isNullOrUndefined',
    'tableGasStation',
    'formatCurrency',
    'btnTrans'
  ],
  methods: {
    clickEdit (dataRow) {
      let data = {
        showIndex: false,
        row: dataRow
      }
      this.$emit('click-edit', data)
    },
    changeCheckedReturnVatFlg (dataRow) {
      let data = {
        ...dataRow,
        return_vat_flag: dataRow.return_vat_flag ? 'Y' : 'N',
        active_flag: dataRow.active_flag ? 'Y' : 'N'
      }
      axios.put(`/ir/ajax/gas-stations/return-vat-flag`, { data })
      .then(({data}) => {
        swal({
          title: "Success",
          text: data.message,
          type: "success",
          // timer: 3000,
          // showConfirmButton: false,
          // closeOnConfirm: false
        });
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    changeCheckedActive (dataRow) {
      let data = {
        ...dataRow,
        return_vat_flag: dataRow.return_vat_flag ? 'Y' : 'N',
        active_flag: dataRow.active_flag ? 'Y' : 'N'
      }
      axios.put(`/ir/ajax/gas-stations/active-flag`, { data })
      .then(({data}) => {
        swal({
          title: "Success",
          text: data.message,
          type: "success",
          // timer: 3000,
          // showConfirmButton: true,
          // closeOnConfirm: false
        });
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    getFormatDate (date) {
      if (date) {
        return moment(date).add(+543, "years").format(this.vars.formatDate);
      }
    },
  }
}
</script>
<style scoped>
  th, td {
    padding: 0.25rem;
  }
  th {
    background: white;
    position: sticky;
    top: 0; /* Don't forget this, required for the stickiness */
  }
</style>
