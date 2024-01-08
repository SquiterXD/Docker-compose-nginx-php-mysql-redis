<template>
  <div>
    <search-vehicle :search="search"
                    @click-search="getDataSearch"
                    :btn-trans="btnTrans" />
    <table-vehicle  :isNullOrUndefined="funcs.isNullOrUndefined"
                    :tableVehicle="tableVehicle"
                    :formatCurrency="funcs.formatCurrency"
                    :btn-trans="btnTrans" />
  </div>
</template>

<script>
import search from './search'
import table from './table'
import * as scripts from '../../scripts'
export default {
  name: 'ir-settings-vehicle-index',
  props: [
    'btnTrans'
  ], 
  data () {
    return {
      search: {
        license_plate: '',
        vehicle_type_code: '',
        return_vat_flag: '',
        active_flag: '',
        sold_flag: ''
      },
      tableVehicle: [],
      funcs: scripts.funcs
    }
  },
  methods: {
    getDataSearch (search) {
      this.search = search
      this.getTableVehicle()
    },
    getTableVehicle () {
      let params = {
        ...this.search
      }
      axios.get(`/ir/ajax/vehicles`, { params })
      .then(({data}) => {
        let res = data.data
        for (let i in res) {
          let row = res[i]
          row.return_vat_flag = row.return_vat_flag === 'Y' ? true : false
          row.active_flag = row.active_flag === 'Y' ? true : false
          row.sold_flag = row.sold_flag === 'Y' ? true : false
          row.sold_date = ''
          row.reason = ''
        }
        this.tableVehicle = res;
        $(document).ready(function() {
          $('.data_tbx').dataTable({
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            bFilter: false,
            aaSorting: [],
            bPaginate:true,
            bInfo: false,
            columnDefs: [
              { orderable: false, targets: 12 }
            ],
            language: {
              loadingRecords: '<div class="sk-spinner sk-spinner-wave"> <div class="sk-rect1"></div> <div class="sk-rect2"></div> <div class="sk-rect3"></div> <div class="sk-rect4"></div> <div class="sk-rect5"></div> </div>',
            },
            buttons: [],
            // "bDestroy": true
          });
        });
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    }
  },
  components: {
    'search-vehicle': search,
    'table-vehicle': table
  },
  created () {
    this.getTableVehicle()
  }
}
</script>

