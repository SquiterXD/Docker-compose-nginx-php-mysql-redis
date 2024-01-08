<template>
  <div v-loading="showLoading">
    <index-search :search="search"
                  @click-search="getDataSearch"
                  @fetch-show-table-header="fetchShowTableHeader"
                  :setYearCE="funcs.setYearCE"
                  :vars="vars"
                  :covertFomatDateMoment="funcs.covertFomatDateMoment"
                  :setBudgetYearFromFieldStCalendar="funcs.setBudgetYearFromFieldStCalendar"
                  :getDateByBudgetYear="funcs.getDateByBudgetYear" />
      <index-table-header :isNullOrUndefined="funcs.isNullOrUndefined"
                          :tableHeader="tableHeader"
                          :formatCurrency="funcs.formatCurrency"
                          :search="search"
                          @click-row="getDataRowShowTableTotal"
                          :setFirstLetterUpperCase="funcs.setFirstLetterUpperCase"
                          :showYearBE="funcs.showYearBE"
                          :checkStatusNew="funcs.checkStatusNew" />
      <index-table-total  :dataRowsTableTotal="tableTotal"
                          :formatCurrency="funcs.formatCurrency"
                          :isNullOrUndefined="funcs.isNullOrUndefined"
                          :statusRowTableHeader="statusRowTableHeader"
                          :checkStatusNew="funcs.checkStatusNew"
                          :receivables="receivables" />
  </div>
</template>

<script>
import indexSearch from './indexSearch'
import indexTableHeader from './indexTableHeader'
import indexTableTotal from './indexTableTotal'
import * as scripts from '../scripts'
export default {
  name: 'ir-asset-increase-index',
  data () {
    return {
      search: {
        year: '',
        revision: '',
        policy_set_header_id: '',
        policy_set_header_id_end: '',
        start_calculate_date: '',
        end_calculate_date: '',
        start_addition_date: '',
        end_addition_date: '',
        location_code: '',
        asset_status: '',
        status: ''
      },
      tableHeader: [],
      tableTotal: [],
      headerRow: {
        header_id: '',
        document_number: '',
        status: '',
        year: '',
        // period_from: '',
        // period_to: '',
        policy_set_header_id: '',
        policy_set_description: '',
        // department_code: '',
        // department_desc: '',
        count_asset: '',
        as_of_date: '',
        insurance_start_date: '',
        insurance_end_date: '',
        total_adjustment_cost: '',
        total_cover_amount: '',
        total_insu_amount: '',
        total_vat_amount: '',
        total_net_amount: '',
        total_rec_insu_amount: '',
        days: '',
        total_duty_amount: ''
      },
      revision: 1,
      funcs: scripts.funcs,
      vars: scripts.vars,
      statusRowTableHeader: '',
      receivables: [],
      showLoading: false
    }
  },
  methods: {
    getDataSearch (value) {
      this.search = value
      this.getTableHeader()
    },
    getTableHeader () {
      let st_cal = this.funcs.covertFomatDateMoment(this.search.start_calculate_date, 'date');
      let en_cal = this.funcs.covertFomatDateMoment(this.search.end_calculate_date, 'date');
      let st_addi = this.funcs.covertFomatDateMoment(this.search.start_addition_date, 'date');
      let en_addi = this.funcs.covertFomatDateMoment(this.search.end_addition_date, 'date');
     this.showLoading= true
     let params = {
        year: this.funcs.setYearCE('year', this.search.year),
        revision: this.search.revision,
        policy_id_from: this.search.policy_set_header_id,
        policy_id_to: this.search.policy_set_header_id_end,
        str_cal: this.funcs.setYearCE('date', st_cal),
        end_cal: this.funcs.setYearCE('date', en_cal),
        str_ad: this.funcs.setYearCE('date', st_addi),
        end_ad: this.funcs.setYearCE('date', en_addi),
        location_code: this.search.location_code,
        asset_status: this.search.asset_status,
        status: this.search.status
      }
      axios.get(`/ir/ajax/asset/asset-adjust`, { params })
      .then(({data}) => {
       this.showLoading= false
        this.tableHeader = this.setPropertyTableHeader(data.data)
        this.tableTotal = []
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    getDataRowShowTableTotal (dataRow) {
      this.tableTotal = [dataRow]
      this.statusRowTableHeader = dataRow.status;
      this.receivables = dataRow.receivables;
    },
    fetchShowTableHeader (dataRows) {
      this.tableHeader = this.setPropertyTableHeader(dataRows)
      this.tableTotal = []
    },
    setPropertyTableHeader (array) {
      array.filter((row) => {
        row.revision = row.revision ? row.revision : row.revision === null ? 1 : this.search.revision
        row.days = ''
        this.funcs.calculateDateMomentTable(row)
        return row
      })
      return array
    }
  },
  components: {
    indexSearch,
    indexTableHeader,
    indexTableTotal
  }
}
</script>


