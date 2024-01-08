<template>
    <span>
        <div class="modal inmodal fade" id="modal_search" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width: 90%; max-width: 1230px;  padding-top: 1%;">
                <div class="modal-content" v-loading="loading">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">ค้นหา{{ menu.menu_title }}</h4>
                        <small class="font-bold">
                            &nbsp;
                        </small>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row col-12" v-if="false">
                            <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> ปีงบประมาณ:</label>
                                <div class="input-group ">
                                    <el-select :popper-append-to-body="false" size="large" v-model="budgetYear" placeholder="ปีงบประมาณ"  clearable filterable>
                                        <el-option v-for="(year, key, index) in yearList"
                                            :key="key"
                                            :label="key"
                                            :value="key"
                                        >
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>

                            <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> ครั้งที่ :</label>
                                <div class="input-group ">
                                    <el-select v-model="budgetYeaVersion" :popper-append-to-body="false" size="large" placeholder=""  clearable filterable>
                                        <el-option
                                           v-for="(item, index) in yearList[budgetYear]"
                                            :key="item.budget_year_version"
                                            :label="item.budget_year_version"
                                            :value="item.budget_year_version"
                                        >
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>

                            <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2" v-loading="loadingVerNo">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> ปรับครั้งที่ :</label>
                                <div class="">
                                    <el-select v-model="adjVersionNo" :popper-append-to-body="false" size="large" placeholder=""  clearable filterable>
                                        <el-option
                                            v-for="(item) in adjVersionNoList"
                                            :key="item" :label="item" :value="item"
                                        >
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>

                            <div class="form-group text-right  pr-2 mb-0 col-lg-2 col-md-10 col-sm-12 col-xs-12">
                                <label class=" tw-font-bold tw-uppercase mt-2 mb-1">&nbsp;</label>
                                <div class="text-left">
                                    <button type="button" @click="searchForm" :class="transBtn.search.class + ' btn-lg tw-w-25'" >
                                        <i :class="transBtn.search.icon"></i>
                                        {{ transBtn.search.text }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row col-12">
                            <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> ปีงบประมาณอนุมัติ :</label>
                                <div class="input-group ">
                                    <el-select :popper-append-to-body="false" size="large" v-model="budgetYeaVersion" placeholder=""  clearable filterable style="width:100%">
                                        <el-option v-for="(year, key, index) in budgetYearList"
                                            :key="key"
                                            :label="key"
                                            :value="key"
                                        >
                                        </el-option>
                                    </el-select>

                                </div>
                            </div>

                            <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> ปีงบประมาณการจำหน่าย(ฝ่ายขาย):</label>
                                <div class="input-group ">

                                    <el-select v-model="budgetYear" :popper-append-to-body="false" size="large" placeholder=""  clearable filterable style="width:100%">
                                        <el-option
                                           v-for="(item, index) in budgetYearList[budgetYeaVersion]"
                                            :key="item"
                                            :label="item"
                                            :value="item"
                                        >
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>

                            <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2" v-loading="loadingVerNo">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> ปรับครั้งที่ :</label>
                                <div class="">
                                    <el-select v-model="adjVersionNo" :popper-append-to-body="false" size="large" placeholder=""  clearable filterable style="width:100%">
                                        <el-option
                                            v-for="(item) in adjVersionNoList"
                                            :key="item" :label="item" :value="item"
                                        >
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>

                            <div class="form-group text-right  pr-2 mb-0 col-lg-2 col-md-10 col-sm-12 col-xs-12">
                                <label class=" tw-font-bold tw-uppercase mt-2 mb-1">&nbsp;</label>
                                <div class="text-left">
                                    <button type="button" @click="searchForm" :class="transBtn.search.class + ' btn-lg tw-w-25'" >
                                        <i :class="transBtn.search.icon"></i>
                                        {{ transBtn.search.text }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-content table-responsive m-t mb-3">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="130px" class="text-center">ปีงบประมาณอนุมัติ</th>
                                        <th width="" class="text-left">ปีงบประมาณการจำหน่าย(ฝ่ายขาย):</th>
                                        <th width="90px" class="text-center">ปรับครั้งที่</th>
                                        <th width="120px" class="text-left">ผู้สร้าง</th>
                                        <th width="150px" class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(header, index) in requestHeaders">
                                        <td class="text-center">{{ header.budget_year_version }}</td>
                                        <td class="text-left">{{ parseInt(header.budget_year) + 543 }}</td>
                                        <td class="text-center">{{ header.version_no }}</td>
                                        <td class="text-left" >{{ header.created_by.name }}</td>
                                        <td class="text-right">
                                            <button type="button" :class="transBtn.detail.class + ' btn-lg tw-w-25'"
                                                @click="selectRow(header)">
                                                <i :class="transBtn.detail.icon"></i>
                                                {{ transBtn.detail.text }}
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </span>
</template>

<script>
import moment from "moment";

export default {
    props:['header', "transBtn", "transDate", "url", "countOpen", "searchInput", "menu"],
    data() {
        return {
            loading: false,
            loadingVerNo: false,
            yearList: [],
            budgetYearList: this.searchInput.budget_year_version_list,
            budgetYear: '',
            budgetYeaVersion: '',
            adjVersionNo: '',
            adjVersionNoList: [],
            requestHeaders: [],
        }
    },
    mounted() {
        // if (this.budget_year) {
        //     this.getBiWeekly();
        // }
    },
    computed: {
    },
    watch:{
        countOpen : async function (value, oldValue) {
            this.openModal();
        },
        // budgetYear : async function (value, oldValue) {
        //     this.budgetYeaVersion = '';
        // },
        // budgetYeaVersion : async function (value, oldValue) {
        //     this.versionNo = '';
        //     this.adjVersionNo = '';
        //     this.adjVersionNoList = [];
        //     if (value) {
        //         this.getDetail();
        //     }
        // },

        budgetYeaVersion : async function (value, oldValue) {
            this.budgetYear = '';
        },
        budgetYear : async function (value, oldValue) {
            this.versionNo = '';
            this.adjVersionNo = '';
            if (value) {
                this.getDetail();
            }
        },
    },
    methods: {
        async setdate(date) {
            let vm = this;
            vm.transactionDateFormat = await moment(date).format(vm.transDate['js-format']);
        },
        openModal() {
            $('#modal_search').modal('show');
        },
        // remoteMethod(query) {
        //     if (query !== "") {
        //         this.search({ wip_request_no: query, transaction_date: this.transactionDateFormat, action: 'search' });
        //     } else {
        //         this.requestHeaders = [];
        //     }
        // },
        search(params) {
            let vm = this;
            vm.loading = true;
            axios.get(vm.url.index, { params }).then(res => {
                let response = res.data.data
                vm.loading = false;
                vm.requestHeaders = response.data;
            });
        },
        async selectRow(reqHeader) {
            $('#modal_search').modal('hide');
            this.requestHeaders = [];
            this.$emit("selectRow", reqHeader);
        },
        async searchForm() {
            let vm = this;
            this.search({
                action: 'search',
                budget_year: vm.budgetYear,
                budget_year_version: vm.budgetYeaVersion,
                version_no: vm.adjVersionNo
            });
        },
        async getDetail() {
            let vm = this;
            if (!vm.budgetYear && !vm.budgetYeaVersion) { return; }
            vm.loadingVerNo = true;
            axios.get(vm.url.ajax_modal_search_details, { params : {
                budget_year: vm.budgetYear,
                budget_year_version: vm.budgetYeaVersion,
            }}).then(res => {
                let response = res.data.data;
                vm.adjVersionNoList = response.adj_version_no_list;
                vm.loadingVerNo = false;
            });
        },
    }
}
</script>