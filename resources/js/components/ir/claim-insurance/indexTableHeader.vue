<template>
  <div class="table-responsive">
    <table  class="table table-bordered"
            style="display: block; overflow: auto; max-height: 500px;">
      <thead>
        <tr>
          <th style="min-width: 110px;">Status <br>สถานะ</th>
          <th style="min-width: 150px;">Document Number <br>เลขที่เอกสาร</th>
          <th style="min-width: 150px;">Referance <br>Document</th>
          <th style="min-width: 100px;" class="text-center">ปี</th>
          <th style="min-width: 150px;">วันที่เกิดเหตุ</th>
          <th style="min-width: 100px;">เวลาเกิดเหตุ</th>
          <th style="min-width: 170px;">สถานที่</th>
          <th style="min-width: 200px;">หน่วยงาน</th>
          <th style="min-width: 200px; width: 1%;">ผู้แจ้งเหตุ</th>
          <th style="min-width: 130px;">เบอร์โทรผู้แจ้งเหตุ</th>
          <th style="min-width: 170px;" class="text-right">จำนวนเงินเรียกชดใช้รวม</th>
          <th style="min-width: 80px; z-index: 1;" class="text-center">แก้ไข</th>
          <th style="min-width: 80px; z-index: 1;" class="text-center">ยกเลิก</th>
        </tr>
      </thead>
      <tbody  id="table_search">
        <tr v-show="tableHeader.length > 0"
            v-for="(data, index) in tableHeader"
            :key="index"
            @click="clickRow(data, index)"
            :class="`style_row_show ${index === activeIndex ? 'highlight' : ''}`">
          <td>{{setFirstLetterUpperCase(data.status)}}</td>
          <td>{{isNullOrUndefined(data.document_number)}}</td>
          <td>{{isNullOrUndefined(data.reference_document_number)}}</td>
          <!-- <td>{{showYearBE('year', data.year)}}</td> -->
          <td class="text-center">{{isNullOrUndefined(data.year)}}</td>
          <!-- <td>{{showYearBE('date', data.accident_date)}}</td> -->
          <td>{{isNullOrUndefined(data.accident_date)}}</td>
          <td class="text-center">{{isNullOrUndefined(data.accident_time)}}</td>
          <td>{{isNullOrUndefined(data.location_name)}}</td>
          <td>{{isNullOrUndefined(data.department_name)}}</td>
          <td>{{isNullOrUndefined(data.requestor_name)}}</td>
          <td>{{isNullOrUndefined(data.requestor_tel)}}</td>
          <td class="text-right">
            {{isNullOrUndefined(data.claim_amount) || isNullOrUndefined(data.claim_amount) === 0 ? 
            formatCurrency(data.claim_amount) :
            isNullOrUndefined(data.claim_amount)}}
          </td>
          <td class="text-center">
            <!-- <button class="btn btn-warning btn-xs" 
                    @click="clickEdit(data)"
                    type="button">
              <i class="fa fa-edit m-r-xs"></i>แก้ไข
            </button> -->
            <a  type="button" 
                :href="`/ir/claim-insurance/edit/${data.claim_header_id}`"
                class="btn btn-warning btn-xs">
              <i class="fa fa-pencil-square-o" aria-hidden="true"></i> แก้ไข
            </a>
          </td>
          <td class="text-center">
            <button class="btn btn-danger btn-xs" 
                    @click="clickCancel(data)"
                    :disabled="checkStatusInterface(data.status) ? true : false"
                    type="button">
              <i class="fa fa-times m-r-xs"></i>ยกเลิก
            </button>
          </td>
        </tr>
        <tr class="text-center" v-if="tableHeader.length === 0"><td colspan="13">ไม่มีข้อมูล</td></tr>
      </tbody>
      <tfoot></tfoot>
    </table>
  </div>
</template>

<script>
export default {
  name: 'ir-claim-insurance-index-table-header',
  data () {
    return {
      activeIndex: ''
    }
  },
  props: [
    'tableHeader',
    'isNullOrUndefined',
    'formatCurrency',
    'checkStatusInterface',
    'setFirstLetterUpperCase',
    'showYearBE'
  ],
  methods: {
    clickEdit (dataRow) {
       
      let setRows = {
        claim_header_id: dataRow.claim_header_id,
        status: this.isNullOrUndefined(dataRow.status),
        document_number: this.isNullOrUndefined(dataRow.document_number),
        accident_date: this.isNullOrUndefined(dataRow.accident_date),
        accident_time: this.isNullOrUndefined(dataRow.accident_time),
        location_code: this.isNullOrUndefined(dataRow.test),
        location_name: this.isNullOrUndefined(dataRow.location_name),
        department_code: this.isNullOrUndefined(dataRow.test),
        department_name: this.isNullOrUndefined(dataRow.test),
        requestor_name: this.isNullOrUndefined(dataRow.requestor_name),
        requestor_tel: this.isNullOrUndefined(dataRow.requestor_tel),
        claim_amount: this.isNullOrUndefined(dataRow.claim_amount),
        // tableLine: dataRow.tableLine,
        // apply: {
        //   apply_companies: dataRow.apply.apply_companies
        // },
        // informant_date: this.isNullOrUndefined(dataRow.informant_date),
        // invoice_date: this.isNullOrUndefined(dataRow.invoice_date),
        // gl_date: this.isNullOrUndefined(dataRow.gl_date),
        // ar_invoice_num: this.isNullOrUndefined(dataRow.ar_invoice_num),
        // policy_number: this.isNullOrUndefined(dataRow.policy_number),
        // ar_receipt_date: this.isNullOrUndefined(dataRow.ar_receipt_date),
        // ar_receipt_id: this.isNullOrUndefined(dataRow.ar_receipt_id),
        // ar_receipt_number: this.isNullOrUndefined(dataRow.ar_receipt_number),
        // ar_received_amount: this.isNullOrUndefined(dataRow.ar_received_amount)
      }
      let data = {
        showIndex: false,
        row: setRows,
        action: 'edit'
      }
       
      this.$emit('click-edit', data)
    },
    clickCancel (dataRow) {
       
      let params = {
        data: {
           header: {
              claim_header_id: dataRow.claim_header_id,
              status: 'CANCELLED',
              document_number: this.isNullOrUndefined(dataRow.document_number),
              accident_date: this.isNullOrUndefined(dataRow.accident_date),
              accident_time: this.isNullOrUndefined(dataRow.accident_time),
              location_code: this.isNullOrUndefined(dataRow.location_code),
              location_name: this.isNullOrUndefined(dataRow.location_name),
              department_code: this.isNullOrUndefined(dataRow.department_code),
              department_name: this.isNullOrUndefined(dataRow.department_name),
              requestor_name: this.isNullOrUndefined(dataRow.requestor_name),
              requestor_tel: this.isNullOrUndefined(dataRow.requestor_tel),
              claim_amount: this.isNullOrUndefined(dataRow.claim_amount),
            },
          // status: 'CANCELLED',
          // header: {
          //     claim_header_id: dataRow.claim_header_id,
          //     status: this.isNullOrUndefined(dataRow.status),
          //     document_number: this.isNullOrUndefined(dataRow.document_number),
          //     accident_date: this.isNullOrUndefined(dataRow.accident_date),
          //     accident_time: this.isNullOrUndefined(dataRow.accident_time),
          //     location_code: this.isNullOrUndefined(dataRow.test),
          //     location_name: this.isNullOrUndefined(dataRow.location_name),
          //     department_code: this.isNullOrUndefined(dataRow.test),
          //     department_name: this.isNullOrUndefined(dataRow.test),
          //     requestor_name: this.isNullOrUndefined(dataRow.requestor_name),
          //     requestor_tel: this.isNullOrUndefined(dataRow.requestor_tel),
          //     claim_amount: this.isNullOrUndefined(dataRow.claim_amount),
          //   },
          program_code: 'IRP0010'
        }
      }
       
      axios.post(`/ir/ajax/claim`, params)
      .then(({data}) => {
        swal({
          title: "Success",
          timer: 3000,
          text: data.message,
          type: "success",
          showConfirmButton: false,
          closeOnConfirm: false
        });
        this.$emit('cancel-success', true)
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
      // let setRows = {
      //   claim_header_id: dataRow.claim_header_id,
      //   status: this.isNullOrUndefined(dataRow.status),
      //   document_number: this.isNullOrUndefined(dataRow.document_number),
      //   accident_date: this.isNullOrUndefined(dataRow.accident_date),
      //   accident_time: this.isNullOrUndefined(dataRow.accident_time),
      //   location_code: this.isNullOrUndefined(dataRow.test),
      //   location_name: this.isNullOrUndefined(dataRow.location_name),
      //   department_code: this.isNullOrUndefined(dataRow.test),
      //   department_name: this.isNullOrUndefined(dataRow.test),
      //   requestor_name: this.isNullOrUndefined(dataRow.requestor_name),
      //   requestor_tel: this.isNullOrUndefined(dataRow.requestor_tel),
      //   claim_amount: this.isNullOrUndefined(dataRow.claim_amount),
      //   }
       
      // let data = {
      //   showIndex: false,
      //   row: setRows,
      //   action: 'cancel'
      // }
       
      // this.$emit('click-cancel', data)
    },
     clickRow (row, index) {
        let obj = {
          claim_header_id: row.claim_header_id,
          status: this.isNullOrUndefined(row.status),
          document_number: this.isNullOrUndefined(row.document_number),
          accident_date: this.isNullOrUndefined(row.accident_date),
          accident_time: this.isNullOrUndefined(row.accident_time),
          location_name: this.isNullOrUndefined(row.location_name),
          requestor_name: this.isNullOrUndefined(row.requestor_name),
          requestor_tel: this.isNullOrUndefined(row.requestor_tel),
          claim_amount: this.isNullOrUndefined(row.claim_amount)
          // insurance_end_date: '',
          // year: this.isNullOrUndefined(row.year),
          // total_adjustment_cost: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.total_adjustment_cost),
          // total_cover_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.total_cover_amount),
          // total_insu_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.total_insu_amount),
          // total_vat_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.total_vat_amount),
          // total_net_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.total_net_amount),
          // total_rec_insu_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.total_rec_insu_amount),
          // revision: this.isNullOrUndefined(row.revision),
          // start_calculate_date: this.isNullOrUndefined(row.start_calculate_date),
          // end_calculate_date: this.isNullOrUndefined(row.end_calculate_date),
          // start_addition_date: this.isNullOrUndefined(row.start_addition_date),
          // end_addition_date: this.isNullOrUndefined(row.end_addition_date),
          // receivables: row.type,
          // total_duty_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.total_duty_amount)
        }
        this.$emit('click-row', obj);
        this.activeIndex = index;
      }
  },
    watch: {
      'tableHeader' (newVal, oldVal) {
        this.rows = newVal
        this.activeIndex = '';
      }
    },
    updated () {
      this.rows = this.tableHeader
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
    top: 0; 
  }
</style>
