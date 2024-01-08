<template>
    <span>
        <div class="modal inmodal fade" id="modal_search" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width: 90%; max-width:950px;">
                <div class="modal-content" v-loading="loading">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">ค้นหาบันทึกใช้ยาเส้น ZoneC48</h4>
                        <small class="font-bold">
                            &nbsp;
                        </small>
                    </div>
                    <div class="modal-body text-left">
                        <div class="ibox" v-loading="getParamlLoading">
                            <div class="row" style="padding-right: 10px; padding-left: 120px;">
                                <div class="col-3">
                                    <label class="text-left tw-font-bold tw-uppercase mb-1">วันที่ :</label>
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

                                <div class="col-3">
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

                                <div class="col-3">
                                    <label class="text-left tw-font-bold tw-uppercase mb-1"> เลขที่เอกสาร :</label>
                                    <div class="input-group ">
                                        <el-select
                                              style="width: 100%"
                                              v-model="sprinkleHeaderId"
                                              filterable
                                              clearable
                                              placeholder="เลขที่เอกสาร"
                                              :loading="getParamlLoading"
                                              :popper-append-to-body="false"
                                            >
                                          <el-option
                                            v-for="data in inputParams.sprinkle_header_id_list"
                                            :key="data.value"
                                            :label="data.label"
                                            :value="data.value"
                                          ></el-option>
                                        </el-select>
                                    </div>
                                </div>

                                <div class="col-3">
                                    <label class="text-left tw-font-bold tw-uppercase mb-1">&nbsp;</label>
                                    <div class="text-left">
                                        <button type="button" @click="submitForm" :class="transBtn.search.class + ' btn-lg tw-w-25'" >
                                            <i :class="transBtn.search.icon"></i>
                                            {{ transBtn.search.text }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="ibox-content table-responsive m-t mb-3">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="200px" class="text-center">วันที่</th>
                                        <th>เลขที่เอกสาร</th>
                                        <th width="150px" class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(reqHeader, index) in requestHeaders">
                                        <td class="text-center">{{ reqHeader.transaction_date_format }}</td>
                                        <td>{{ reqHeader.sprinkle_no }}</td>
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
            sprinkleNo: '',
            sprinkleHeaderId: '',
            requestHeaders: [],

            transDateFormat: {
                from_date: '',
                to_date: '',
            },
            inputParams: {
                sprinkle_header_id_list: [],
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
        },
        "transDateFormat.from_date": function (newValue) {
            this.getParam();
        },
        "transDateFormat.to_date": function (newValue) {
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
                this.search({ wip_request_no: query, transaction_date: this.transactionDateFormat, action: 'search' });
            } else {
                this.requestHeaders = [];
            }
        },
        search(params) {
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
        async submitForm() {
            this.search({
                sprinkle_header_id: this.sprinkleHeaderId,
                // transaction_date: this.transactionDateFormat,
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
            }

            axios.get(vm.url.index, { params }).then(res => {
                let response = res.data.data
                vm.getParamlLoading = false;
                vm.inputParams.sprinkle_header_id_list = response.data.sprinkle_header_id_list;
            });
        }
    }
}
</script>