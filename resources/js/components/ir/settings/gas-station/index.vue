<template>
  <div>
    <search-gas :search="search"
                @click-search="getDataSearch"
                :btn-trans="btnTrans" />
    <table-gas  :isNullOrUndefined="funcs.isNullOrUndefined"
                :tableGasStation="tableGasStation"
                :formatCurrency="funcs.formatCurrency"
                :btn-trans="btnTrans" />
  </div>
</template>

<script>
import search from './search'
import table from './table'
// import form from './form'
import * as scripts from '../../scripts'
export default {
  name: 'ir-settings-gas-station-index',
  props: [
    'btnTrans'
  ],
  data () {
    return {
      // showIndex: true,
      search: {
        type_code: '',
        return_vat_flag: '',
        active_flag: ''
      },
      tableGasStation: [],
      // gas_station: {},
      // action: '',
      funcs: scripts.funcs
    }
  },
  methods: {
    getDataSearch (value) {
      this.search = value
      this.getTableGasStaion()
    },
    // isNullOrUndefined (value) {
    //   if (value === null || value === undefined) {
    //     return ''
    //   }
    //   return value
    // },
    // formatCurrency (number, decimal = 2) {
    //   let num = ''
    //   if (number) {
    //     num = +number
    //     let setNum = num.toFixed(decimal).replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,")
    //     return setNum
    //   }
    //   return num
    // },
    // getDataRowForEdit (obj) {
    //   this.showIndex = obj.showIndex
    //   this.action = 'edit'
    //   axios.get(`/ir/ajax/gas-stations/${obj.row.gas_station_id}`)
    //   .then(({data}) => {
    //     let res = data.data
    //     let object = {
    //       ...res,
    //       return_vat_flag: res.return_vat_flag === 'Y' ? true : false,
    //       active_flag: res.active_flag === 'Y' ? true : false,
    //       ...obj.row
    //     }
    //     this.gas_station = object
    //   })
    //   .catch((error) => {
    //     swal("Error", error, "error");
    //   })
    // },
    // getCreateDefault (obj) {
    //   this.showIndex = obj.showIndex
    //   this.gas_station = obj.create
    //   this.action = 'add'
    // },
    getTableGasStaion () {
      let params = {
        ...this.search
      }
      axios.get(`/ir/ajax/gas-stations`, { params })
      .then(({data}) => {
        let res = data.data
        for (let i in res) {
          let row = res[i]
          row.return_vat_flag = row.return_vat_flag === 'Y' ? true : false
          row.active_flag = row.active_flag === 'Y' ? true : false
        }
        this.tableGasStation = res
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    }
  },
  components: {
    'search-gas': search,
    'table-gas': table,
    // 'form-gas': form
  },
  created () {
    this.getTableGasStaion()
  }
}
</script>
