<template>
  <div v-loading="loading">
    <index-header @dataSearch='receivedDataSearchy'
                  @show-loading="showLoading"
                  @fetch-show-table-header='receivedDataSearchx'/>
    <index-table  :dataTable='data'
                  :setLabelExpenseFlag="funcs.setLabelExpenseFlag"
                  :setLabelVatRefund="funcs.setLabelVatRefund"
                  :formatCurrency="funcs.formatCurrency"
                  :url-export="urlExport"
                  ref="indextable"
                  :fetchData="fetchData"
                  />
  </div>
</template>

<script>
  import uuid from 'uuid/v1';
  import IndexHeader from './indexHeader'
  import IndexTable from './indexTable.vue'
  import * as scripts from '../scripts'

  export default {
    name: 'gas-stations',
    props: ['urlExport'],
    data() {
      return {
        data: {
          rows: []
        },
        loading: false,
        funcs: scripts.funcs,
        fetchData: false,
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
      test(tf){
        this.$refs.indextable.updateselectindex(tf);
      },
      financial(x) {
        return Number(parseFloat(x).toFixed(2))
      },
      receivedDataSearchx(data) {  // ดึงข้อมูล
        this.receivedDataSearch(data)
        this.test(true)
      },
      receivedDataSearchy(data) { // ค้นหา
        this.receivedDataSearch(data)
        this.test(false)
      },
      receivedDataSearch(data) {
        const vm = this;
         
        this.data.rows = data.map(data => {
          // data.return_vat_flag === 'Y' ? data.return_vat_flag = 'Yes' : data.return_vat_flag = 'No'
          // data.vat_refund === 'Y' ? data.vat_refund = 'Yes' : data.vat_refund = 'No'
          data.insurance_amount === null ? data.insurance_amount = '' : +data.insurance_amount
          data.discount === null ? data.discount = '' : +data.discount
          data.duty_amount ? data.duty_amount = this.financial(data.duty_amount) : ''
          data.vat_amount ? data.vat_amount = this.financial(data.vat_amount) : ''
          data.net_amount ? data.net_amount = this.financial(data.net_amount) : ''
          data.vat_refund = data.return_vat_flag
          data.row_id = uuid();
          return data
        })

        if (this.data.rows.length > 0) {
          this.fetchData = true;
        }
      }
    },
    mounted(){
       
    },
    created(){
       
    },
  }
</script>