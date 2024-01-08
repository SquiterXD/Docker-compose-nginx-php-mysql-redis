<template>
    <span>
        <div class="modal inmodal fade" id="modal_search" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width: 90%; max-width:950px;">
                <div class="modal-content" v-loading="loading">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">ค้นหารายการบันทึกส่งสินค้าสำเร็จรูป</h4>
                        <small class="font-bold">
                            &nbsp;
                        </small>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row col-12 " v-loading="getParamlLoading">
                            <div class="form-group col-6">
                                <div class="row">
                                    <div class="form-group pl-2 pr-2 mb-0 col-lg-6 col-md-2 col-sm-6 col-xs-6 mt-2 ">
                                        <label class="text-left tw-font-bold tw-uppercase mb-1"> วันที่ส่งผลผลิต :</label>
                                        <div class="input-group ">
                                            <datepicker-th
                                                style="width: 100%"
                                                class="form-control md:tw-mb-0 tw-mb-2"
                                                placeholder="โปรดเลือกวันที่"
                                                :value="transDateFormat.from_date"
                                                :format="transDate['js-format']"
                                                @dateWasSelected="setdate(...arguments, 'from_date')"
                                                />
                                        </div>
                                    </div>

                                    <div class="form-group pl-2 pr-2 mb-0 col-lg-6 col-md-2 col-sm-6 col-xs-6 mt-2">
                                        <label class="text-left tw-font-bold tw-uppercase mb-1">&nbsp;</label>
                                        <div class="input-group ">
                                            <datepicker-th
                                                style="width: 100%"
                                                class="form-control md:tw-mb-0 tw-mb-2"
                                                placeholder="โปรดเลือกวันที่"
                                                :value="transDateFormat.to_date"
                                                :format="transDate['js-format']"
                                                @dateWasSelected="setdate(...arguments, 'to_date')"
                                                />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> สถานะบันทึกผลผลิตเข้าคลัง :</label>
                                <div class="input-group ">
                                          <!-- change="getParam()" -->
                                    <el-select
                                          style="width: 100%"
                                          v-model="wipRequestStatus"
                                          placeholder="สถานะบันทึกผลผลิตเข้าคลัง"
                                          :loading="getParamlLoading"
                                          :popper-append-to-body="false"
                                        >
                                      <el-option
                                        v-for="data in inputParams.wip_request_status"
                                        :key="data.value"
                                        :label="data.label"
                                        :value="data.value"
                                      ></el-option>
                                    </el-select>
                                </div>
                            </div>

                            <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> เลขที่เอกสาร :</label>
                                <div class="input-group ">
                                    <el-select
                                          style="width: 100%"
                                          v-model="wipReqHeaderId"
                                          filterable
                                          clearable
                                          placeholder="เลขที่เอกสาร"
                                          :loading="getParamlLoading"
                                          :popper-append-to-body="false"
                                        >
                                      <el-option
                                        v-for="data in inputParams.wip_req_header_id_list"
                                        :key="data.value"
                                        :label="data.label"
                                        :value="data.value"
                                      ></el-option>
                                    </el-select>
                                </div>
                            </div>

                            <div class="form-group pl-2 pr-2 mb-0 col-12 mt-2">
                                <div class="text-right">
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
                                        <th width="200px" class="text-center">วันที่ส่งผลผลิต</th>
                                        <th>เลขที่เอกสาร</th>
                                        <th width="200px" class="text-center">สถานะขอเบิก</th>
                                        <th width="150px" class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(reqHeader, index) in requestHeaders">
                                        <td class="text-center">{{ reqHeader.transaction_date_format }}</td>
                                        <td>{{ reqHeader.wip_request_no }}</td>
                                        <td class="text-center">
                                            <div v-if="reqHeader.status">
                                                {{ reqHeader.status.description }}
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            <button type="button" :class="transBtn.detail.class + ' btn-lg tw-w-25'"
                                                @click="selectWipRequestHeader(reqHeader)">
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
    props:['header', "transBtn", "transDate", "url", "countOpen"],
    data() {
        return {
            loading: false,
            getParamlLoading: false,
            // reqHeaderHeaderId: '',
            transactionDateFormat: '',
            transDateFormat: {
                from_date: '',
                to_date: '',
            },

            inputParams: {
                wip_request_status: [],
                wip_req_header_id_list: [],
            },
            wipRequestNo: '',
            wipReqHeaderId: '',
            wipRequestStatus: '',
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
        "transDateFormat.from_date": function (newValue) {
            this.getParam();
        },
        "transDateFormat.to_date": function (newValue) {
            this.getParam();
        },
        // wipRequestNo : async function (value, oldValue) {
        //     this.getParam();
        // },
        wipRequestStatus : async function (value, oldValue) {
            this.getParam();
        },
    },
    methods: {
        async setdate(date, input = '') {
            let vm = this;
            if (input == '') {
                vm.transactionDateFormat = await moment(date).format(vm.transDate['js-format']);
            } else {
                let data = await moment(date).format(vm.transDate['js-format']);
                if (data == 'Invalid date') {
                    data = '';
                }
                vm.transDateFormat[input] = data;
            }
        },
        openModal() {
            $('#modal_search').modal('show');
            this.getParam();
        },
        remoteMethod(query) {
            if (query !== "") {
                this.getWipRequest({ wip_request_no: query, transaction_date: this.transactionDateFormat, action: 'search' });
            } else {
                this.requestHeaders = [];
            }
        },
        getWipRequest(params) {
            let vm = this;
            vm.loading = true;
            axios.get(vm.url.index, { params }).then(res => {
                let response = res.data.data
                vm.loading = false;
                vm.requestHeaders = response.data;
            });
        },
        async selectWipRequestHeader(reqHeader) {
            $('#modal_search').modal('hide');
            this.requestHeaders = [];
            this.$emit("selectWipRequestHeader", reqHeader);
        },
        async searchForm() {
            this.getWipRequest({
                wip_request_no: this.wipRequestNo,
                wip_req_header_id: this.wipReqHeaderId,
                // transaction_date: this.transactionDateFormat,
                wip_request_status: this.wipRequestStatus,
                from_transaction_date: this.transDateFormat.from_date,
                to_transaction_date: this.transDateFormat.to_date,
                action: 'search'
            });
        },
        async getParam() {
            let vm = this;
            vm.getParamlLoading = true;

            let params = {
                action: 'search_get_param',
                from_transaction_date: vm.transDateFormat.from_date,
                to_transaction_date: vm.transDateFormat.to_date,
                wip_request_status: vm.wipRequestStatus
            }

            axios.get(vm.url.index, { params }).then(res => {
                let response = res.data.data
                vm.getParamlLoading = false;
                vm.inputParams.wip_request_status = response.data.wip_request_status_list;
                vm.inputParams.wip_req_header_id_list = response.data.wip_req_header_id_list;
            });
        }
    }
}
</script>