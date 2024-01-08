<template>
  <div v-loading="showLoading">
    <index-search :search="search"
                  @click-search="getDataSearch"
                  :setYearCE="funcs.setYearCE"
                  @fetch-show-table-header="fetchShowTableHeader"
                  :vars="vars"
                  :covertFomatDateMoment="funcs.covertFomatDateMoment" />
      <index-table-header :isNullOrUndefined="funcs.isNullOrUndefined"
                          :tableHeader="tableHeader"
                          @click-row="getDataRowShowTableTotal"
                          :setFirstLetterUpperCase="funcs.setFirstLetterUpperCase"
                          :showYearBE="funcs.showYearBE"
                          :checkStatusNew="funcs.checkStatusNew"
                          :formatCurrency="funcs.formatCurrency" />
      <index-table-total  :formatCurrency="funcs.formatCurrency"
                          :rowTotal="rowTotal" />
  </div>
</template>

<script>
import indexSearch from './indexSearch'
import indexTableHeader from './indexTableHeader'
import indexTableTotal from './indexTableTotal'
import * as scripts from '../scripts'
export default {
  name: 'ir-stock-yearly-index',
  data () {
    return {
      tableHeader: [],
      rowTotal: {
        department_code: '',
        department_desc: '',
        document_number: '',
        period_from: '',
        period_to: '',
        policy_set_description: '',
        policy_set_header_id: '',
        status: '',
        period_year: '',
        inventory_desc: 'Inventory',
        inventory_amount: '',
        inventory_cover_amount: '',
        inventory_insu_amount: '',
        manual_desc: 'Manual',
        manual_amount: '',
        manual_cover_amount: '',
        manual_insu_amount: '',
        total_desc: 'Total',
        total_amount: '',
        total_cover_amount: '',
        total_insu_amount: '',
        inventory_duty_amount: '',
        inventory_vat_amount: '',
        inventory_net_amount: '',
        manual_duty_amount: '',
        manual_vat_amount: '',
        manual_net_amount: '',
        total_duty_amount: '',
        total_vat_amount: '',
        total_net_amount: ''
      },
      rowTotalDefault: {
        department_code: '',
        department_desc: '',
        document_number: '',
        period_from: '',
        period_to: '',
        policy_set_description: '',
        policy_set_header_id: '',
        status: '',
        period_year: '',
        inventory_desc: 'Inventory',
        inventory_amount: '',
        inventory_cover_amount: '',
        inventory_insu_amount: '',
        manual_desc: 'Manual',
        manual_amount: '',
        manual_cover_amount: '',
        manual_insu_amount: '',
        total_desc: 'Total',
        total_amount: '',
        total_cover_amount: '',
        total_insu_amount: '',
        inventory_duty_amount: '',
        inventory_vat_amount: '',
        inventory_net_amount: '',
        manual_duty_amount: '',
        manual_vat_amount: '',
        manual_net_amount: '',
        total_duty_amount: '',
        total_vat_amount: '',
        total_net_amount: '',
      },
      search: {
        period_year: '',
        insurance_start_date: '',
        insurance_end_date: '',
        policy_set_header_id: '',
        status: '',
        period_from: '',
        period_to: '',
        department_from: '',
        department_to: ''
      },
      headerRow: {},
      period_year: '',
      insuranceDate: [],
      changeFieldManualInsuAmount: false,
      manual_insu_amount: '',
      old_manual_insu_amount: '',
      funcs: scripts.funcs,
      mocks: scripts.mocks,
      vars: scripts.vars,
      showLoading: false
    }
  },
  methods: {
    getTableHeader () {
       
      this.showLoading = true
      let year = this.funcs.setYearCE('year', this.search.period_year);
      let params = {
        period_year: year,
        insurance_start_date: this.funcs.setYearCE('date', this.search.insurance_start_date),
        insurance_end_date: this.funcs.setYearCE('date', this.search.insurance_end_date),
        policy_set_header_id: this.search.policy_set_header_id,
        status: this.search.status,
        period_from: this.funcs.setYearCE('month', this.search.period_from),
        period_to: this.funcs.setYearCE('month', this.search.period_to),
        department_from: this.search.department_from,
        department_to: this.search.department_to,
        program_code: 'IRP0001'
      }
       
      axios.get(`/ir/ajax/stocks`, { params })
      .then(({data}) => {
        this.showLoading = false
        this.tableHeader = data.data
        this.rowTotal = this.rowTotalDefault
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    getDataSearch (obj) {
      this.search = obj
      this.getTableHeader()
    },
    getDataRowShowTableTotal (dataRow) {
      if (dataRow.old_manual_insu_amount) {
        this.old_manual_insu_amount = +dataRow.old_manual_insu_amount
      }
      this.rowTotal = dataRow
    },
    fetchShowTableHeader (dataRows) {
       
      this.tableHeader = dataRows
      this.rowTotal = this.rowTotalDefault
    }
  },
  components: {
    indexSearch,
    indexTableHeader,
    indexTableTotal
  }
}
</script>
