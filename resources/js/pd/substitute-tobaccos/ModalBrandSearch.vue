<template>
    <span>
        <div class="modal inmodal fade" id="modal_search2" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width: 90%; max-width:950px;">
                <div class="modal-content" v-loading="loading">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">ค้นหาตราบุหรี</h4>
                        <small class="font-bold">
                            &nbsp;
                        </small>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row col-12">
                            <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> ตราบุหรี </label>
                                <div class="input-group ">
                                    <el-select
                                          style="width: 100%"
                                          v-model="brandNo"
                                          placeholder="โปรดเลือก ตราบุหรี"
                                          :loading="getParamlLoading"
                                          :popper-append-to-body="false"
                                          filterable remote reserve-keyword
                                          :remote-method="getParam"
                                        >
                                      <el-option
                                        v-for="item in inputParams.brand_no_list"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value"
                                      ></el-option>
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
                                        <th width="90px" class="text-center">Blend No</th>
                                        <th width="" class="text-left">รายละเอียด</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(header, index) in requestHeaders">
                                        <!-- <td class="text-center">{{ parseInt(header.budget_year) + 543 }}</td> -->
                                        <td class="text-center">{{ header.blend_no }}</td>
                                        <td class="text-left">{{ header.blend_desc }}</td>
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
            yearList: this.searchInput.budget_year_list,
            budgetYear: '',
            budgetYeaVersion: '',
            adjVersionNo: '',
            adjVersionNoList: [],
            requestHeaders: [],

            getParamlLoading: false,
            brandNo: '',
            inputParams: {
                brand_no_list: [],
            },
        }
    },
    mounted() {
            // $('#modal_search2').modal('show');
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
        budgetYear : async function (value, oldValue) {
            this.budgetYeaVersion = '';
        },
        budgetYeaVersion : async function (value, oldValue) {
            this.versionNo = '';
            this.adjVersionNo = '';
            this.adjVersionNoList = [];
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
            $('#modal_search2').modal('show');
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
                vm.requestHeaders = response.data.brand_no_list;
            });
        },
        async selectRow(reqHeader) {
            $('#modal_search2').modal('hide');
            this.requestHeaders = [];
            this.$emit("selectRow", reqHeader);
        },
        async searchForm() {
            let vm = this;
            this.search({
                action: 'search_brand',
                brand_no: vm.brandNo,
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
        async getParam(query) {
            let vm = this;
            vm.getParamlLoading = true;

            let params = {
                action: 'search_brand_get_param',
                brand_no: query,
            }

            axios.get(vm.url.index, { params }).then(res => {
                let response = res.data.data.data
                vm.getParamlLoading = false;
                vm.inputParams.brand_no_list = response.brand_no_list;
            });
        }
    }
}
</script>