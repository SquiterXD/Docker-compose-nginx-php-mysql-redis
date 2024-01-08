<template>
  <div >
    <search-comp  :search="search"
                  @click-search="getDataSearch"
                  :btn-trans="btnTrans" />
    <table-comp :isNullOrUndefined="funcs.isNullOrUndefined"
                :tableCompany="tableCompany"
                :setDefaultActive="funcs.setDefaultActive"
                :btn-trans="btnTrans" />
  </div>
</template>

<script>
import search from './search'
import table from './table'
import * as scripts from '../../scripts'
export default {
  name: 'ir-settings-company-index',
  props:[
    'btnTrans'
  ],
  data () {
    return {
      search: {
        company_id: '',
        active_flag: ''
      },
      tableCompany: [],
      funcs: scripts.funcs
    }
  },
  methods: {
    getTableCompany () {
      let params = {
        ...this.search
      }
      axios.get(`/ir/ajax/company`, { params })
      .then(({data}) => {
        let res = data.data
        for (let i in res) {
          let row = res[i]
          if (row.active_flag === 'Y') {
            row.active_flag = true
          } else {
            row.active_flag = false
          }
        }
        this.tableCompany = res
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    getDataSearch (search) {
      this.search = search
      this.getTableCompany()
    }
  },
  components: {
    'search-comp': search,
    'table-comp': table
  },
  created () {
    this.getTableCompany()
  }
}
</script>
