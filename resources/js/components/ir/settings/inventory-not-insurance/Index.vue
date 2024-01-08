<template>
    <div>
        <div class="row">
            <div class="col-sm-4" style="text-align:left;">
                <label>
                    รหัสสินค้า
                </label>
                <input type="hidden" name="item_number" :value="search.item_number">
                <el-select class="required" v-model="search.item_number" placeholder="รหัสสินค้า" size="small" style="width: 100%;"  
                        filterable
                        remote
                        reserve-keyword
                        clearable
                        >
                    <!-- <el-option
                        v-for="(company, index) in companies"
                        :key="index"
                        :label="company.label"
                        :value="company.value">
                    </el-option> -->
                </el-select>
            </div>
            <div class="col-sm-4" style="text-align:left;">
                <label>
                    Organization
                </label>
                <input type="hidden" name="organization_code" :value="search.organization_code">
                <el-select class="required" v-model="search.organization_code" placeholder="Organization" size="small" style="width: 100%;"  
                        filterable
                        remote
                        reserve-keyword
                        clearable
                        >
                    <!-- <el-option
                        v-for="(dataList, index) in sortArrays(dataLists)"
                        :key="index"
                        :label="dataList.label"
                        :value="dataList.value">
                    </el-option> -->
                </el-select>
            </div>
            <div class="col-sm-4" style="text-align:left;">
                <label>
                    Status
                </label>
                <input type="hidden" name="status" :value="search.status">
                <el-select class="required" v-model="search.status" placeholder="Status" size="small" style="width: 100%;"  
                        filterable
                        remote
                        reserve-keyword
                        clearable
                        >
                    <!-- <el-option
                        v-for="(dataList, index) in sortArrays(dataLists)"
                        :key="index"
                        :label="dataList.label"
                        :value="dataList.value">
                    </el-option> -->
                </el-select>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 text-right">
                <button type="button" class="btn btn-sm btn-light" @click="clickSearch()">
                    <i class="fa fa-search"></i> ค้นหา
                </button>
                <button type="button" class="btn btn-sm btn-warning" @click="clickCancel()">
                    <i class="fa fa-undo"></i> รีเซต
                </button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['urlReset'],
    data() {
        return {
            perPage: 100,
            current_page: 1,
            totalRows: 0,
            per_page: 500,
            sortBy: '',
            sortDesc: false,
            sortDirection: 'asc',
            showLoading: false,
            isBusy: false,

            fields: [
                { key: 'line_no', sortable: true, class:'text-center text-nowrap options-column align-middle', },
                { key: 'status', sortable: true, class:'text-nowrap options-column align-middle', tdClass:'align-middle'},
                { key: 'organization_code', sortable: true, class:'text-nowrap options-column align-middle', tdClass:'align-middle'},
                { key: 'item_number', sortable: true, class:'text-nowrap options-column align-middle', tdClass:'align-middle'},
                { key: 'description', sortable: true, class:'text-nowrap align-middle', tdClass:'align-middle'},
                { key: 'price', sortable: true, class:'text-center text-nowrap align-middle', tdClass:'align-middle'},
                { key: 'expense_flag', sortable: true, class:'text-nowrap align-middle', tdClass:'align-middle'},
                { key: 'inventory_date', sortable: true, class:'text-center text-nowrap align-middle', tdClass:'align-middle'},
            ],

            dataTable: [],
            search: {
                item_number:       '',
                organization_code: '',
                status:            '',
            }
        }
    },
    methods: {
        rowClass(item, type, test) {
            if (!item || type !== 'row') return
        },
        clickSearch(){
            console.log('clickSearch');
        },
        clickCancel(){
            console.log('clickCancel');
        },
        clickFetch(){
            console.log('clickFetch');
        },
    },
    watch: {
      'dataTable' () {
        this.totalRows = this.dataTable.length;

      }
    },
}
</script>

<style scoped>

  th {
    z-index: 1;
    background: white;
    position: sticky;
    top: 0; /* Don't forget this, required for the stickiness */
  }

  .el-form-item__content{
    line-height: 40px;
    position: relative;
    font-size: 14px;
    margin-left: 0px !important;
  }

  .table.b-table > thead > tr > [aria-sort] > div {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
  }

  .table.b-table > thead > tr > [aria-sort] {
    cursor: pointer;
  }

  table.b-table > thead > tr > th[aria-sort="descending"] > div::before,
  table.b-table > tfoot > tr > th[aria-sort="descending"] > div::before {
    content: "";
    padding-left: 15px;
  }

  table.b-table > thead > tr > th[aria-sort="descending"] > div::after,
  table.b-table > tfoot > tr > th[aria-sort="descending"] > div::after {
    opacity: 1;
    content: "\2193";
    padding-left: 10px;
  }

  table.b-table > thead > tr > th[aria-sort="ascending"] > div::before,
  table.b-table > tfoot > tr > th[aria-sort="ascending"] > div::before {
    content: "";
    padding-left: 15px;
  }

  table.b-table > thead > tr > th[aria-sort="ascending"] > div::after,
  table.b-table > tfoot > tr > th[aria-sort="ascending"] > div::after {
    opacity: 1;
    content: "\2191";
    padding-left: 10px;
  }

  table.b-table > thead > tr > th[aria-sort="none"] > div::before,
  table.b-table > tfoot > tr > th[aria-sort="none"] > div::before {
    content: "";
    padding-left: 15px;
  }

  table.b-table > thead > tr > th[aria-sort="none"] > div::after,
  table.b-table > tfoot > tr > th[aria-sort="none"] > div::after {
    opacity: 1;
    content: "\21C5";
    font-weight: normal;
    padding-left: 10px;
  }

  .table-hover > tbody > tr:hover {
    background-color: #d4edda!important;
  }

  .table-active, .table-active>td, .table-active>th {
    background-color: #d4edda!important;
  }

</style>