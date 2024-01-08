<template>
    <span>
        <div class="modal inmodal fade" id="modal_search" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width: 90%; max-width:950px; padding-top: 1%;">
                <div class="modal-content" v-loading="loading">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">ค้นหา</h4>
                        <small class="font-bold">
                            &nbsp;
                        </small>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row col-12">
                            <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> ปีงบประมาณ :</label>
                                <div class="input-group ">

                                    <el-select
                                          style="width: 100%"
                                          v-model="yaer"
                                          placeholder="โปรดเลือก ปีงบประมาณ"
                                          :loading="getParamlLoading"
                                          :popper-append-to-body="false"
                                          filterable remote
                                          :remote-method="getParam"
                                        >
                                      <el-option
                                        v-for="item in inputParams.year_list"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value"
                                      ></el-option>
                                    </el-select>
                                </div>
                            </div>

                            <!-- :popper-append-to-body="false" -->

                            <!-- <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> วันที่ส่งผลผลิต :</label>
                                <div class="input-group ">
                                    <datepicker-th
                                        style="width: 100%"
                                        class="form-control md:tw-mb-0 tw-mb-2"
                                        placeholder="โปรดเลือกวันที่"
                                        :value="transactionDateFormat"
                                        :format="transDate['js-format']"
                                        @dateWasSelected="setdate(...arguments)"
                                        />
                                </div>
                            </div> -->

                            <div class="form-group text-right  pr-2 mb-0 col-lg-5 col-md-10 col-sm-12 col-xs-12">
                                <label class=" tw-font-bold tw-uppercase mt-2 mb-1">&nbsp;</label>
                                <div class="text-left">
                                    <button type="button" @click="searchForm" :class="transBtn.search.class + ' btn-lg tw-w-25'" >
                                        <i :class="transBtn.search.icon"></i>
                                        {{ transBtn.search.text }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-content table-responsivex m-t mb-3 ">
                            <div class="row">
                                <div class="col-12">
                                    <div class="slimScroll">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th width="90px" class="text-center"></th>
                                                    <th width="" class="text-left">ปีงบประมาณ</th>
                                                    <th width="150px" class="text-center"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(header, index) in headers">
                                                    <td class="text-center"></td>
                                                    <td >{{ header.lld_year }}</td>
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
                            </div>
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
    props:['header', "transBtn", "transDate", "url", "countOpen", "menu"],
    data() {
        return {
            loading: false,
            getParamlLoading: false,
            // reqHeaderHeaderId: '',
            transactionDateFormat: '',
            yaer: '',
            headers: [],
            inputParams: {
                year_list: [],
            },
        }
    },
    mounted() {
        // if (this.budget_year) {
        //     this.getBiWeekly();
        // }
        // this.openModal();
    },
    computed: {
    },
    watch:{
        countOpen : async function (value, oldValue) {
            this.openModal();
            this.getParam(' ')
        },
    },
    methods: {
        async setdate(date) {
            let vm = this;
            vm.transactionDateFormat = await moment(date).format(vm.transDate['js-format']);
        },
        openModal() {
            $('#modal_search').modal('show');
            $('.slimScroll').slimScroll({
                height: '250px',
                width: '100%'
            });
        },
        // remoteMethod(query) {
        //     if (query !== "") {
        //         this.search({ wip_request_no: query, transaction_date: this.transactionDateFormat, action: 'search' });
        //     } else {
        //         this.headers = [];
        //     }
        // },
        search(params) {
            let vm = this;
            vm.loading = true;
            axios.get(vm.url.index, { params }).then(res => {
                let response = res.data.data
                vm.loading = false;
                vm.headers = response.data;
            });
        },
        async selectRow(reqHeader) {
            $('#modal_search').modal('hide');
            this.headers = [];
            this.$emit("selectRow", reqHeader);
        },
        async searchForm() {
            this.search({ yaer: this.yaer, action: 'search'});
        },
        async getParam(query) {
            let vm = this;
            vm.getParamlLoading = true;

            let params = {
                action: 'search-get-param',
                // blend_no: vm.yaer,
                year: query,
            }

            axios.get(vm.url.index, { params }).then(res => {
                let response = res.data.data
                vm.getParamlLoading = false;
                vm.inputParams.year_list = response.year_list;
            });
        }
    }
}
</script>