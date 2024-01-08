<template>
    <div class="margin_top_20" v-loading="showLoading">
        <div class="">
            <div style="height: 600px;" class="table-responsive">
                <b-table
                    table-class="table table-bordered"
                    style="display: block;"
                    :busy.sync="isBusy"
                    :items="claims"
                    :fields="fields"
                    :current-page="currentPage"
                    :per-page="perPage"
                    :sort-by.sync="sortBy"
                    :sort-desc.sync="sortDesc"
                    :sort-direction="sortDirection"
                    :tbody-tr-class="rowClass"
                    primary-key="row_id"
                    show-empty
                    small
                    select-mode="single"
                >
                <template #table-busy>
                  <div class="text-center text-danger my-2">
                    <strong>Loading...</strong>
                  </div>
                </template>

                <template #head(status)="header">
                    <div>
                        Status<br>สถานะรายการ
                    </div>
                </template>
                <template #head(document_number)="header">
                    <div>
                        Document number<br>เลขที่เอกสาร
                    </div>
                </template>
                <template #head(reference_number)="header">
                    <div>
                        Reference number<br>เลขที่เอกสาร
                    </div>
                </template>
                <template #head(year)="header">
                    <div>
                        Year<br>ปี
                    </div>
                </template>
                <template #head(accident_date_format)="header">
                    <div>
                        Date-Time<br>วันที่-เวลาเกิดเหตุ
                    </div>
                </template>
                <template #head(title)="header">
                    <div>
                        Title<br>หัวข้อการเกิดเหตุ
                    </div>
                </template>
                <template #head(insurance_status)="header">
                    <div>
                        Insurance Status<br>สถานะปัจจุบัน
                    </div>
                </template>
                <template #head(department)="header">
                    <div>
                        Department<br>หน่วยงาน
                    </div>
                </template>
                <template #head(requestor_name)="header">
                    <div>
                        Requestor<br>ผู้แจ้งเหตุ
                    </div>
                </template>
                <template #head(claim_amount)="header">
                    <div>
                        Estimate Amount<br>จำนวนเงินเรียกชดใช้
                    </div>
                </template>
                <template #head(action)="header">
                    <div>
                        Action
                    </div>
                </template>
                <!-- body -->
                <template #cell(status)="row">
                    <div class="text-center" style="vertical-align: middle;">
                        {{ row.item.irp0011_status ? row.item.irp0011_status : '' }}
                    </div>
                </template>
                <template #cell(document_number)="row">
                    <div class="text-center" style="vertical-align: middle;">
                        {{ row.item.document_number ? row.item.document_number : '' }}
                    </div>
                </template>
                <template #cell(reference_number)="row">
                    <div class="text-center" style="vertical-align: middle;">
                        {{ row.item.reference_document_number ? row.item.reference_document_number : '' }}
                    </div>
                </template>
                <template #cell(year)="row">
                    <div class="text-center" style="vertical-align: middle;">
                        {{ row.item.year ? row.item.year : '' }}
                    </div>
                </template>
                <template #cell(accident_date_format)="row">
                    <div class="text-center" style="vertical-align: middle;">
                        {{ row.item.accident_date_format ? row.item.accident_date_format: '' }} {{ row.item.accident_time_format ? row.item.accident_time_format : '' }}
                    </div>
                </template>
                <!-- <template #cell(accident_time_format)="row">
                    <div class="text-center" style="vertical-align: middle;">
                        {{ row.item.accident_time_format ? row.item.accident_time_format : '' }} 
                    </div>
                </template> -->
                <template #cell(title)="row">
                    <div class="text-left" style="vertical-align: middle;">
                        {{ row.item.claim_title ? row.item.claim_title : '' }}
                    </div>
                </template>
                <template #cell(title)="row">
                    <div class="text-left" style="vertical-align: middle;">
                        {{ row.item.irp0011_insurance_status ? row.item.irp0011_insurance_status : '' }}
                    </div>
                </template>
                <template #cell(department)="row">
                    <div class="text-center" style="vertical-align: middle;">
                        {{ row.item.department_name ? row.item.department_name : '' }}
                    </div>
                </template>
                <template #cell(requestor_name)="row">
                    <div class="text-left" style="vertical-align: middle;">
                        {{ row.item.requestor_name ? row.item.requestor_name : '' }}
                        <div><small> <strong>Tel.: </strong> {{ row.item.requestor_tel }} </small></div>
                    </div>
                </template>
                <template #cell(claim_amount)="row">
                    <div class="text-right" style="vertical-align: middle;">
                        {{ row.item.claim_amount | numberFormat}}
                    </div>
                </template>
                <template #cell(action)="row">
                    <a :href="'/ir/claim-accounting/'+row.item.claim_header_id" :class="btnTrans.edit.class + ' btn-sm tw-w-25'">
                        <i :class="btnTrans.edit.icon"></i> {{ btnTrans.edit.text }}
                    </a>
                </template>
              </b-table>
            </div>
            <div class="row" v-show="totalRows > perPage">
              <div class="col-md-12">
                <b-pagination
                  v-model="currentPage"
                  :total-rows="totalRows"
                  :per-page="perPage"
                  align="right"
                ></b-pagination>
              </div>
            </div>
        </div>
    </div>
</template>

<script>
    import uuid from 'uuid/v1';
    export default {
        props: ['claims', 'url', 'profile', 'btnTrans'],
        data() {
            return {
                fields: [
                    { key: 'status', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 60px;', tdClass:'align-middle' },
                    { key: 'document_number', sortable: true, thClass:'text-center text-nowrap', thStyle: 'min-width: 70px;', tdClass:'align-middle' },
                    { key: 'reference_number', sortable: true, thClass:'text-center text-nowrap', thStyle: 'min-width: 70px;', tdClass:'align-middle' },
                    { key: 'year', sortable: true, thClass:'text-center text-nowrap', thStyle: 'min-width: 50px;', tdClass: 'el_field' },
                    { key: 'accident_date_format', sortable: true, thClass:'text-center text-nowrap', thStyle: 'min-width: 100px;', tdClass: 'el_field' },
                    { key: 'title', sortable: true, class:'text-center text-nowrap', thStyle: 'min-width: 250px;', tdClass: 'el_field' },
                    { key: 'insurance_status', sortable: true, thClass:'text-center text-nowrap', thStyle: 'min-width: 100px;', tdClass: 'el_field' },
                    { key: 'department', sortable: true, thClass:'text-center text-nowrap', thStyle: 'min-width: 165px;', tdClass: 'el_field' },
                    { key: 'requestor_name', sortable: true, thClass:'text-center text-nowrap', thStyle: 'min-width: 165px;', tdClass: 'el_field' },
                    { key: 'claim_amount', sortable: true, thClass:'text-center text-nowrap', thStyle: 'min-width: 165px;', tdClass: 'el_field' },
                    { key: 'action', sortable: false, class:'text-center text-nowrap', thStyle: 'min-width: 80px;' }
                ],
                currentPage: 1,
                perPage: 10,
                sortBy: '',
                sortDesc: false,
                sortDirection: 'asc',
                showLoading: false,
                isBusy: false,
                totalRows: 0,
            }
        },
        mounted(){
            window.vm = this;
            vm.totalRows = vm.claims.length;
            vm.$nextTick(() => {
                vm.currentPage = 1;
                vm.$nextTick(() => {
                    const el = this.$el.getElementsByClassName('newLine')[0];
                    if (el) {
                        el.scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
                    }
                    vm.showLoading = false;
                });
            });
        },
        methods: {
            rowClass(item, type, test) {
                if (!item || type !== 'row') return
                if (item.row_id === this.lastRowId) return 'newLine'
            },
        },
        computed: {
            
        },
        watch: {
            
        },
    }
</script>

<!-- <style scoped>
    .el-form-item{
        margin-bottom: 0px !important;
    }
    .mx-datepicker {
        height: 33px !important;
    }
</style> -->

<style scoped>
    .el-form-item{
        margin-bottom: 0px !important;
    }
    .mx-datepicker {
        height: 33px !important;
    }

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
