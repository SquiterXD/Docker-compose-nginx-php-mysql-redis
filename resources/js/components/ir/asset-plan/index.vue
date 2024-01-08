<template>
  <div v-loading="showLoading" >
      <index-search :search="search"
                    @click-search="getDataSearch"
                    @fetch-show-table-header="fetchShowTableHeader"
                    :setYearCE="funcs.setYearCE"
                    :vars="vars" />
      <index-table-header :isNullOrUndefined="funcs.isNullOrUndefined"
                          :tableHeader="tableHeader"
                          :formatCurrency="funcs.formatCurrency"
                          @click-row="getDataRowShowTableTotal"
                          :search="search"
                          :setFirstLetterUpperCase="funcs.setFirstLetterUpperCase"
                          :showYearBE="funcs.showYearBE"
                          :checkStatusNew="funcs.checkStatusNew" />
      <index-table-total  :tableTotal="tableTotal"
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
  name: 'ir-asset-plan-index',
  data () {
    return {
      search: {
        year: '',
        insurance_start_date: '',
        insurance_end_date: '',
        policy_set_header_id_start: '',
        policy_set_header_id_end: '',
        as_of_date: '',
        asset_group: '',
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
        policy_set_header_id: '',
        policy_set_description: '',
        count_asset: '',
        as_of_date: '',
        insurance_start_date: '',
        insurance_end_date: '',
        total_cost: '',
        total_cover_amount: '',
        total_insu_amount: '',
        total_vat_amount: '',
        total_net_amount: '',
        total_rec_insu_amount: '',
        total_duty_amount: ''
      },
      year: '',
      funcs: scripts.funcs,
      vars: scripts.vars,
      statusRowTableHeader: '',
      receivables: [],
      showLoading: false
    }
  },
  methods: {
    getDataSearch (obj) {
      this.search = obj
      this.getDataRowsTableHeader()
    },
    getDataRowShowTableTotal (dataRow) {
      this.tableTotal = [dataRow];
      this.statusRowTableHeader = dataRow.status;
      this.receivables = dataRow.receivables;
    },
    getDataRowsTableHeader () {
      this.showLoading = true
      let params = {
        year: this.funcs.setYearCE('year', this.search.year),
        insurance_start_date: this.funcs.setYearCE('date', this.search.insurance_start_date),
        insurance_end_date: this.funcs.setYearCE('date', this.search.insurance_end_date),
        policy_set_header_start: this.search.policy_set_header_id_start,
        policy_set_header_end: this.search.policy_set_header_id_end,
        as_of_date: this.funcs.setYearCE('date', this.search.as_of_date),
        location_code: this.search.asset_group,
        asset_status: this.search.asset_status,
        status: this.search.status
      }
      axios.get(`/ir/ajax/asset`, { params })
      .then(({data}) => {
        this.showLoading = false
        this.tableHeader = data.data
        this.tableTotal = []
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    fetchShowTableHeader (dataRows) {
      this.tableHeader = dataRows
      this.tableTotal = []
    }
  },
  components: {
    indexSearch,
    indexTableHeader,
    indexTableTotal
  }
}
</script>
