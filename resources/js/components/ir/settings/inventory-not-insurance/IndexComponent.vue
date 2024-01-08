<template>
    <div>
        <el-form :model="form"
                 ref="save_table_line"
                 label-width="120px"
                 class="demo-dynamic form_table_line">
            <div class="row">
                <div class="col-12">
                    <div class="ibox-title">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>ข้อมูลสินค้าคงคลังไม่ทำประกัน</h5>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="button" class="btn btn-md btn-success" @click="clickFetch()">
                                <i class="fa fa-database"></i> ดึงข้อมูล
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
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
                                <!-- <a :href="urlReset" class="btn btn-warning btn-sm"><i class="fa fa-undo"></i> รีเซต</a> -->
                                <button type="button" class="btn btn-sm btn-warning" @click="clickCancel()">
                                    <i class="fa fa-undo"></i> รีเซต
                                </button>
                            </div>
                        </div>


                        <!-- ----- Table ----- -->
                        <div class="table-responsive mt-5">
                            <b-table
                                    table-class="table table-bordered"
                                    style="display: block; overflow: auto; max-height: 400px;"
                                    :busy.sync="isBusy"
                                    :items="dataTable"
                                    :fields="fields"
                                    :current-page="current_page"
                                    :per-page="perPage"
                                    :sort-by.sync="sortBy"
                                    :sort-desc.sync="sortDesc"
                                    :sort-direction="sortDirection"
                                    :tbody-tr-class="rowClass"
                                    primary-key="rowId"
                                    show-empty
                                    hover
                                    small
                                    select-mode="single"
                                    selectable
                                >
                                <template #head(line_no)="header">
                                    <div>
                                        Line No
                                    </div>
                                </template>
                                <template #head(status)="header">
                                    <div>
                                        สถานะ<br>(Status) 
                                    </div>
                                </template>
                                <template #head(organization_code)="header">
                                    <div>
                                        Organization
                                    </div>
                                </template>
                                <template #head(item_number)="header">
                                    <div>
                                        รหัสสินค้า (Item Code)
                                    </div>
                                </template>
                                <template #head(description)="header">
                                    <div>
                                        คำอธิบาย (Description)
                                    </div>
                                </template>
                                <template #head(price)="header">
                                    <div>
                                        ราคาต่อหน่วย
                                    </div>
                                </template>
                                <template #head(expense_flag)="header">
                                    <div>
                                        ทำประกัน
                                    </div>
                                </template>
                                <template #head(inventory_date)="header">
                                    <div>
                                        วันที่ดึงข้อมูลจากระบบ INV
                                    </div>
                                </template>

                                <!-- ------------------------------------------------------ -->

                                <template #cell(line_no)="row">
                                    <div>
                                        {{ row.item.line_no }}
                                    </div>
                                </template>
                                <template #cell(status)="row">
                                    <div>
                                        {{ row.item.status }}
                                    </div>
                                </template>
                                <template #cell(organization_code)="row">
                                    <div>
                                        {{ row.item.organization_code }}
                                    </div>
                                </template>
                                <template #cell(item_number)="row">
                                    <div>
                                        {{ row.item.item_number }}
                                    </div>
                                </template>
                                <template #cell(description)="row">
                                    <div>
                                        {{ row.item.description }}
                                    </div>
                                </template>
                                <template #cell(price)="row">
                                    <div>
                                        {{ row.item.price }}
                                    </div>
                                </template>
                                <template #cell(expense_flag)="row">
                                    <div>
                                        {{row.item.expense_flag }}
                                    </div>
                                </template>
                                <template #cell(inventory_date)="row">
                                    <div>
                                        {{ row.item.inventory_date }}
                                    </div>
                                </template>
                            </b-table>
                        </div>
                        <div class="row" v-show="totalRows > perPage">
                            <div class="col-md-12">
                                <b-pagination
                                v-model="current_page"
                                :total-rows="totalRows"
                                :per-page="perPage"
                                align="right"
                                ></b-pagination>
                            </div>
                        </div>
                        <!-- <div class="row margin_top_20">
                            <div class="form-group el_field">
                                <el-form-item>
                                    <button type="button"
                                            v-show="complete"
                                            class="btn btn-primary"
                                            @click="clickComplete()"
                                            :disabled="checkStatusInterface(headerRow.status) || checkExpenseFlag">
                                        <i class="fa fa-check-square-o"></i> บันทึก (ล็อค)
                                    </button>
                                    <button type="button"
                                            v-show="!complete"
                                            class="btn btn-danger btn_incomplete"
                                            @click="clickIncomplete()"
                                            :disabled="checkStatusInterface(headerRow.status) || checkExpenseFlag">
                                        <i class="fa fa-minus-square-o"></i> แก้ไข (ปลดล็อค)
                                    </button>
                                </el-form-item>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </el-form>
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
            form: {
                tableLine: []
            },

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
      'dataTable' (newVal, oldVal) {
        // $(`input[name="cars_select_all"]`).prop('checked', false)
        // this.columnSelected = []
        // this.columnSelectedId = []
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
