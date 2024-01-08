<template>
  <div  v-loading="showLoading">
    <index-search :search="search"
                  ref="indexIndexSearch"
                  @click-search="getDataSearch"
                  @change-period-year="getDataPeriodYear"
                  :showYearBE="funcs.showYearBE"
                  :setYearCE="funcs.setYearCE"
                  @fetch-show-table-header="fetchShowTableHeader" />
                  <!-- :yearTh="yearTh"
                  :status="status" -->
    <index-table-header :isNullOrUndefined="funcs.isNullOrUndefined"
                        :tableHeader="tableHeader"
                        @click-row="getDataRowShowTableTotal"
                        ref="indexIndexTableHeader"
                        :showPeriodNameFormat="funcs.showPeriodNameFormat"
                        :setFirstLetterUpperCase="funcs.setFirstLetterUpperCase"
                        :showYearBE="funcs.showYearBE"
                        :checkStatusNew="funcs.checkStatusNew"
                        :formatCurrency="funcs.formatCurrency" />
    <index-table-total  ref="indexIndexTableTotal"
                        :rowTotal="rowTotal"
                        :formatCurrency="funcs.formatCurrency"
                        @change-manual-insu-amount="getDataManualInsuAmount" />
  </div>
</template>
<script>
  import indexTableTotal from './indexTableTotal'
  import indexSearch from './indexSearch'
  import indexTableHeader from './indexTableHeader'
  import * as scripts from '../scripts'
  export default {
    name: 'ir-stock-monthly-index',
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
          year: '',
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
        search: {
          period_year: '',
          period_name: '',
          policy_set_header_id: '',
          status: '',
          data_month: '',
          department_from: '',
          department_to: '',
          period_from: '',
          period_to: '',
          insurance_start_date: '',
          insurance_end_date: ''
        },
        showIndex: true,
        headerRow: {
          header_id: '',
          document_number: '',
          status: '',
          period_year: '',
          period_from: '',
          period_to: '',
          policy_set_header_id: '',
          policy_set_description: '',
          department_code: '',
          department_desc: '',
          inventory_amount: '',
          inventory_cover_amount: '',
          inventory_insu_amount: '',
          manual_amount: '',
          manual_cover_amount: '',
          manual_insu_amount: '',
          total_amount: '',
          total_cover_amount: '',
          total_insu_amount: ''
        },
        period_year: '',
        status: [],
        changeFieldManualInsuAmount: false,
        manual_insu_amount: '',
        old_manual_insu_amount: '',
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
          total_net_amount: ''
        },
        funcs: scripts.funcs,
        showLoading: false
      }
    },
    computed: {
      sys_date () {
        let date = new Date()
        let day = date.getDate()
        let month = (date.getMonth() + 1).toString().length === 1 ? `0${date.getMonth() + 1}` : date.getMonth() + 1
        let year = date.getFullYear()
        let sys = `${month}/${+year + 543}`
        return sys
      }
    },
    methods: {
      getTableHeader () {
        this.showLoading = true
        let params = {
          period_year: this.search.period_year,
          policy_set_header_id: this.search.policy_set_header_id,
          status: this.search.status,
          period_from: '',
          period_to: '',
          department_from: this.search.department_from,
          department_to: this.search.department_to,
          insurance_start_date: '',
          insurance_end_date: '',
          period_name: this.funcs.setYearCE('month', this.search.period_name),
          data_month: this.funcs.setYearCE('month', this.search.data_month),
          program_code: 'IRP0002'
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
        this.search = obj.search
        this.rowTotal = obj.rowTotal
        this.getTableHeader()
      },
      getDataRowShowTableTotal (dataRow) {
        if (dataRow.old_manual_insu_amount) {
          this.old_manual_insu_amount = +dataRow.old_manual_insu_amount
        }
        this.rowTotal = dataRow
      },
      getDataManualInsuAmount (value) {
        if (this.old_manual_insu_amount != value) {
          this.changeFieldManualInsuAmount = true
          this.manual_insu_amount = value
        }
        this.rowTotal.manual_insu_amount = value
      },
      getDataPeriodYear (value) {
        this.period_year = +value - 543
      },
      getStatus () {
        axios.get('/ir/ajax/lov/status')
        .then(({data}) => {
          this.status = data
        })
        .catch((error) => {
          swal("Error", error, "error");
        })
      },
      setPropertyTableHeader (array) {
        return array.filter((row) => {
          row.status = 'INTERFACE'
          return row
        })
      },
      fetchShowTableHeader (dataRows) {
         
        this.tableHeader = dataRows
        this.rowTotal = this.rowTotalDefault
      }
    },
    components: {
      indexTableTotal,
      indexSearch,
      indexTableHeader
    }
  }
</script>
