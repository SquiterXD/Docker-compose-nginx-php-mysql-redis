<template>
  <div class="table-responsive margin_top_20">
    <!-- <table class="table data_tbx table-bordered"> -->
    <table  class="table table-bordered data_tb"
            :style="`${tableVehicle.length === 0 ? '' : 'display: block; overflow: auto; max-height: 550px;'}`">
      <thead>
        <tr>
          <th style="min-width: 70px;" class="text-center">ลำดับ</th>
          <th style="min-width: 160px;" class="text-center">ทะเบียนรถ</th>
          <th style="min-width: 160px;" class="text-center">ชุดกรมธรรม์</th>
          <th style="min-width: 140px;" class="text-center">กลุ่ม</th>
          <th style="min-width: 400px; width: 1%;" class="text-center">ประเภทรถ</th>
          <th style="min-width: 135px;" class="text-center">ยี่ห้อรถ</th>
          <th style="min-width: 120px;" class="text-center">ขอคืนภาษีได้</th>
          <th style="min-width: 120px;" class="text-center">ภาษี (%)</th>
          <th style="min-width: 120px;" class="text-center">อากร (%)</th>
          <th style="min-width: 150px;" class="text-center">รหัสทรัพย์สิน</th>
          <th style="min-width: 200px;" class="text-center">รหัสบัญชี</th>
          <th style="min-width: 140px;" class="text-center">วันที่ดึงข้อมูล</th>
          <th style="min-width: 120px;" class="text-center">Active</th>
          <th style="min-width: 120px;" class="text-center">สถานะการขาย</th>
          <th style="min-width: 120px;" class="text-center">Action</th>
        </tr>
      </thead>
      <tbody v-if="this.tableVehicle.length != 0">
        <tr v-for="(data, index) in tableVehicle" :key="index">
          <td class="text-center"> {{ index + 1 }}</td>
          <td class="text-left"> {{isNullOrUndefined(data.license_plate)}}</td>
          <td class="text-left"> 
            {{isNullOrUndefined(data.policy_set_number)}} {{data.policy_set_number ? ':' : ''}} {{isNullOrUndefined(data.policy_set_description)}}
          </td>
          <td class="text-left"> {{isNullOrUndefined(data.group_desc)}}</td>
          <td class="text-left"> {{isNullOrUndefined(data.vehicle_type_name)}}</td>
          <td class="text-center"> {{isNullOrUndefined(data.vehicle_brand_name)}}</td>
          <td class="text-center">
            <div  class="form-check"
                  style="position: inherit;">
              <input  class="form-check-input" 
                      type="checkbox"
                      v-model="data.return_vat_flag"
                      @change="changeCheckedReturnVatFlg(data)"
                      style="position: inherit;"
                      :disabled="true">
            </div>
          </td>
          <td class="text-center">
            {{ isNullOrUndefined(data.vat_percent) ? formatCurrency(data.vat_percent) : isNullOrUndefined(data.vat_percent) }}
          </td>
          <td class="text-center">
            {{ isNullOrUndefined(data.revenue_stamp_percent) ? formatCurrency(data.revenue_stamp_percent) : isNullOrUndefined(data.revenue_stamp_percent) }}
          </td>
          <td class="text-center">
            {{ isNullOrUndefined(data.asset_number) }}
          </td>
          <td class="text-left">
            {{ isNullOrUndefined(data.account_number) }}
          </td>
          <td class="text-center">
            {{ getFormatDate(data.creation_date) }}
          </td>
          <td class="text-center">
            <div  class="form-check"
                  style="position: inherit;">
              <input  class="form-check-input" 
                      type="checkbox"
                      v-model="data.active_flag"
                      @change="changeCheckedActive(data)"
                      style="position: inherit;"
                      :disabled="data.reason != '' || data.sold_flag != '' ">
            </div>
          </td>
          <td class="text-center">
            <div class="form-check" style="position: inherit;">
              <input  class="form-check-input" 
                      type="checkbox"
                      v-model="data.sold_flag"
                      @change="clickModalSold(index)"
                      style="position: inherit;"
                      v-show="true" 
                      disabled>
                      <!-- :disabled="data.reason != '' || data.sold_flag != '' " -->
            </div>
          </td>
          <button type="button" 
                class="btn btn-warning"
                data-toggle="modal"
                :data-target="`#modal_soldd_car`"
                v-show="false"
                ref="solddd" >
          </button>
          <td class="text-center">
            <a  type="button" 
                :href="`/ir/settings/vehicle/edit/${data.asset_id}/${data.vehicle_id}`"
                :class="btnTrans.edit.class+' btn-sm tw-w-25'">
              <i :class="btnTrans.edit.icon" aria-hidden="true"></i> แก้ไข
            </a>
          </td>
        </tr>
        <!-- <tr class="text-center" v-if="tableVehicle.length === 0"><td colspan="12">ไม่มีข้อมูล</td></tr> -->
      </tbody>
      <tbody v-else>
          <tr>
              <td class="text-center" style="font-size:18px; vertical-align:middle;" colspan="15">ไม่พบข้อมูล</td>
          </tr>
      </tbody>
      <!-- <tfoot></tfoot> -->
    </table>
     <modal-noti :vars="vars" 
                :tableVehicleindex="tableVehicleindex"
                :tableVehicle="tableVehicle"
                @sold="getValueSoldCar" 
                v-if="tableVehicle.length > 0"/>
  </div>
</template>

<script>
import lovPolicyGroup from './lovPolicyGroup'
import * as scripts from '../../scripts'
import ModalNoti from './modalNoti'
import moment from 'moment'
export default {
  name: 'ir-settings-vehicle-table',
  data () {
    return {  
      tableVehicleindex : 0, 
      vars: scripts.vars
      }
  },
  props: [
    'isNullOrUndefined',
    'tableVehicle',
    'formatCurrency',
    'btnTrans'
  ],
  // mounted(){
  //   $('.dt-table').dataTable({
  //     "searching": false,
  //     "bInfo": false,
  //     columnDefs: [
  //         { orderable: false, targets: 5 }
  //     ]
  //   });
  // },
  // mounted() {
  //   // $('.table-test').dataTable({
  //   //     "searching": false,
  //   //     "bInfo": false,
  //   //     columnDefs: [
  //   //         { orderable: false, targets: 5 }
  //   //     ]
  //   // });
  //   // $('.table-test').DataTable({
  //   //   pageLength: 25,
  //   //   responsive: true,
  //   //   dom: '<"html5buttons"B>lTfgitp',
  //   //   bFilter: false,
  //   //   aaSorting: [],
  //   //   bPaginate:true,
  //   //   bInfo: false,
  //   //   columnDefs: [
  //   //       // { className: "text-center", "targets": [ 0 ] , type: "string", orderable : false },
  //   //   ],
  //   //   buttons: [
  //   //   ],
  //   // });
  // },
  methods: {
    isCheckedReturnVatFlg (value) {
      if (value === 'Y') {
        return true
      }
      return false
    },
    changeCheckedReturnVatFlg (dataRow) {
      let data = {
        ...dataRow,
        return_vat_flag: dataRow.return_vat_flag ? 'Y' : 'N',
        active_flag: dataRow.active_flag ? 'Y' : 'N',
        sold_flag: dataRow.sold_flag ? 'Y' : 'N',
        program_code: 'IRM0007'
      }
      axios.put(`/ir/ajax/vehicles/return-vat-flag`, { data })
      .then(({data}) => {
        swal({
          title: "Success",
          text: data.message,
          type: "success",
          timer: 3000,
          showConfirmButton: false,
          closeOnConfirm: false
        });
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    clickModalSold (data) {
      this.tableVehicleindex = data
      this.$refs.solddd[data].click()
      this.tableVehicle.active_flag = false
    },
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
    changeCheckedActive (dataRow) {
      let data = {
        ...dataRow,
        return_vat_flag: dataRow.return_vat_flag ? 'Y' : 'N',
        active_flag: dataRow.active_flag ? 'Y' : 'N',
        program_code: 'IRM0007'
      }
      axios.put(`/ir/ajax/vehicles/active-flag`, { data })
      .then(({data}) => {
        swal({
          title: "Success",
          text: data.message,
          type: "success",
          timer: 3000,
          showConfirmButton: false,
          closeOnConfirm: false
        });
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    getValueSoldCar (obj) {
      this.sold = obj;
    },
    getFormatDate (date) {
        let formatDate = this.vars.formatDate;
        if (date) {
          return moment(date).format(formatDate);
        }
      },
  },
  components: {
    lovPolicyGroup,
    ModalNoti
  },
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
