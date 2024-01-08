<template>
  <div v-loading="loading">
    <index-header @dataSearch='receivedDataSearch'
                  @headerSearch='receivedHeaderSearch'
                  @show-loading="showLoading"
                  :fetchInvoice='fetchInvoice'/>

    <index-table  :dataTable='data'
                  :yearHeader="yearHeader"
                  @fetchPerson='fetchPerson'
                  :setLabelExpenseFlag="funcs.setLabelExpenseFlag"
                  :isNullOrUndefined="funcs.isNullOrUndefined"
                  :formatCurrency="funcs.formatCurrency"
                  :setYearCE="funcs.setYearCE"
                  ref="tableline" />
  </div>
</template>

<script>
  import uuid from 'uuid/v1';
  import IndexHeader from './indexHeader'
  import IndexTable from './indexTable.vue'
  import * as scripts from '../scripts'

  export default {
    name: 'index-governor',
    data() {
      return {
        data: {
          rows: []
        },
        yearHeader: '',
        fetchInvoice: false,
        loading: false,
        funcs: scripts.funcs
      }
    },
    components: {
      IndexHeader,
      IndexTable
    },
    methods: {
      showLoading(value){
        const vm = this;
        vm.loading = value;
      },
      fetchPerson(val) {
        const vm = this
        vm.fetchInvoice = val
      },
      financial(x) {
        return Number(parseFloat(x).toFixed(2))
      },
      receivedDataSearch(data) {
        let checkComplete = false;
        this.data.rows = data.map(data => {
          if(data.document_number) {checkComplete = true;}
          data.return_vat_flag === 'Y' ? data.return_vat_flag = 'Yes' : data.return_vat_flag = 'No'
          data.insurance_amount === null ? data.insurance_amount = '' : +data.insurance_amount
          data.discount === null ? data.discount = '' : +data.discount
          data.duty_amount ? data.duty_amount = this.financial(data.duty_amount) : ''
          data.vat_amount ? data.vat_amount = this.financial(data.vat_amount) : ''
          data.net_amount ? data.net_amount = this.financial(data.net_amount) : ''
          data.vat_refeaund === 'Y' ? data.vat_refund = 'Yes' : data.vat_refund = 'No'
          data.policy_set_header_id = data.policy_set_header_id ? data.policy_set_header_id : ''
          data.revenue_stamp = data.revenue_stamp && data.revenue_stamp !== null && data.revenue_stamp !== undefined ? +data.revenue_stamp : 0
          data.tag = data.tag ? data.tag : '';
          data.row_id = uuid();
          return data
        })
        this.$refs.tableline.complete = checkComplete;
      },
      receivedHeaderSearch(header) {
        this.yearHeader = header.year
      }
    }
  }
</script>
