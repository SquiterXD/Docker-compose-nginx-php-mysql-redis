<template>
    <span>
        <div class="modal inmodal fade" id="modal_req_search" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width: 90%; max-width: 1230px;  padding-top: 1%;">
                <div class="modal-content" v-loading="loading">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">ค้นหาการขอเบิกวัตถุดิบนอกแผน</h4>
                        <small class="font-bold">
                            &nbsp;
                        </small>
                    </div>
                    <div class="modal-body text-left">
                        <div class="ibox" v-loading="getParamlLoading">
                            <div class="row">
                                <div class="form-group pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
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

                                <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
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

                                <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                    <label class="text-left tw-font-bold tw-uppercase mb-1"> วัตถุประสงค์ในการเบิก :</label>
                                    <div class="input-group ">
                                        <el-select
                                              style="width: 100%"
                                              v-model="objectiveCode"
                                              filterable
                                              clearable
                                              placeholder="วัตถุประสงค์ในการเบิก"
                                              :loading="getParamlLoading"
                                              :popper-append-to-body="false"
                                            >
                                          <el-option
                                            v-for="data in inputParams.objective_code_list"
                                            :key="data.value"
                                            :label="data.label"
                                            :value="data.value"
                                          ></el-option>
                                        </el-select>
                                    </div>
                                </div>

                                <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                    <label class="text-left tw-font-bold tw-uppercase mb-1"> สินค้าที่จะผลิต :</label>
                                    <div class="input-group ">
                                        <el-select
                                              style="width: 100%"
                                              v-model="inventoryItemId"
                                              filterable
                                              clearable
                                              placeholder="สินค้าที่จะผลิต"
                                              :loading="getParamlLoading"
                                              :popper-append-to-body="false"
                                            >
                                          <el-option
                                            v-for="data in inputParams.inventory_item_id_list"
                                            :key="data.value"
                                            :label="data.label"
                                            :value="data.value"
                                          ></el-option>
                                        </el-select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                    <label class="text-left tw-font-bold tw-uppercase mb-1">ประเภทวัตถุดิบ :</label>
                                    <div class="input-group ">
                                        <el-select
                                              style="width: 100%"
                                              v-model="attribute3OrIngredientGroup"
                                              filterable
                                              clearable
                                              placeholder="ประเภทวัตถุดิบ"
                                              :loading="getParamlLoading"
                                              :popper-append-to-body="false"
                                            >
                                          <el-option
                                            v-for="data in inputParams.attribute3_or_ingredient_group_list"
                                            :key="data.value"
                                            :label="data.label"
                                            :value="data.value"
                                          ></el-option>
                                        </el-select>
                                    </div>
                                </div>


                                <div class="form-group pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                    <label class="text-left tw-font-bold tw-uppercase mb-1">เลขที่ใบเบิก :</label>
                                    <div class="input-group ">
                                        <el-select
                                              style="width: 100%"
                                              v-model="requestHeaderId"
                                              filterable
                                              clearable
                                              placeholder="เลขที่เอกสาร"
                                              :loading="getParamlLoading"
                                              :popper-append-to-body="false"
                                            >
                                          <el-option
                                            v-for="data in inputParams.request_header_id_list"
                                            :key="data.value"
                                            :label="data.label"
                                            :value="data.value"
                                          ></el-option>
                                        </el-select>
                                    </div>
                                </div>

                                <div class="form-group pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                    <label class="text-left tw-font-bold tw-uppercase mb-1"> สถานะขอเบิก :</label>
                                    <div class="input-group ">
                                        <el-select
                                              style="width: 100%"
                                              v-model="requestStatus"
                                              filterable
                                              clearable
                                              placeholder="สถานะขอเบิก"
                                              :loading="getParamlLoading"
                                              :popper-append-to-body="false"
                                            >
                                          <el-option
                                            v-for="data in inputParams.request_status_list"
                                            :key="data.value"
                                            :label="data.label"
                                            :value="data.value"
                                          ></el-option>
                                        </el-select>
                                    </div>
                                </div>

                                <div class="form-group pl-2 pr-2 mb-0 col-lg-6 col-md-2 col-sm-6 col-xs-6 mt-2">
                                    <label class="text-left tw-font-bold tw-uppercase mb-1">&nbsp;</label>
                                    <div class="text-right">
                                        <button type="button" @click="searchForm" :class="transBtn.search.class + ' btn-lg tw-w-25'" >
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
                                        <th width="200px" class="text-center">วันที่ขอเบิก</th>
                                        <th>เลขที่ใบเบิก</th>
                                        <th width="200px" class="text-right">วันที่นำส่ง ยสท.</th>
                                        <th width="200px" class="text-center">สถานะขอเบิก</th>
                                        <th width="150px" class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(reqHeader, index) in requestHeaders">
                                        <td class="text-center">{{ reqHeader.request_date_format }}</td>
                                        <td>{{ reqHeader.request_number }}</td>
                                        <td class="text-right">{{ reqHeader.send_date_format }}</td>
                                        <td class="text-center">
                                            <div v-if="reqHeader.status">
                                                {{ reqHeader.status.description }}
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            <a :href="reqHeader.show_url" :class="transBtn.detail.class + ' btn-lg tw-w-25'">
                                                 <i :class="transBtn.detail.icon"></i>
                                                {{ transBtn.detail.text }}
                                            </a>
                                            <!-- <button type="button" :class="transBtn.detail.class + ' btn-lg tw-w-25'"
                                                @click="selectWipRequestHeader(reqHeader)">
                                                <i :class="transBtn.detail.icon"></i>
                                                {{ transBtn.detail.text }}
                                            </button> -->
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
    props:['header', "transBtn", "transDate", "url", "countOpenSearch", 'requestStatusList'],
    data() {
        return {
            loading: false,
            getParamlLoading: false,
            // reqHeaderHeaderId: '',
            requestDateFmFormat: '',
            requestDateToFormat: '',
            requestNumber: '',
            requestHeaders: [],


            transDateFormat: {
                from_date: '',
                to_date: '',
            },
            inputParams: {
                request_status_list: [],
                objective_code_list: [],
                request_header_id_list: [],
                inventory_item_id_list: [],
            },
            requestHeaderId: '',
            objectiveCode: '',
            requestStatus: '',
            inventoryItemId: '',
            attribute3OrIngredientGroup: '',
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
        countOpenSearch : async function (value, oldValue) {
            this.openModal();
        },
        "transDateFormat.from_date": function (newValue) {
            this.getParam();
        },
        "transDateFormat.to_date": function (newValue) {
            this.getParam();
        },
        objectiveCode : async function (value, oldValue) {
            this.getParam();
        },
        requestStatus : async function (value, oldValue) {
            this.getParam();
        },
        inventoryItemId : async function (value, oldValue) {
            this.getParam();
        },
        attribute3OrIngredientGroup : async function (value, oldValue) {
            this.getParam();
        },
        requestHeaderId : async function (value, oldValue) {
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
        async openModal() {
            $('#modal_req_search').modal('show');
            // auto load อยู่แล้ว
            var sysdate = await moment().format(this.transDate['js-format']);
            var today = new Date();
            var yyyy = today.getFullYear() ;
                sysdate = sysdate.replace(yyyy, yyyy + 543);
            this.transDateFormat.from_date = sysdate;
        },
        remoteMethod(query) {
            if (query !== "") {
                this.getWipRequest({ wip_request_no: query,
                    request_date_fm_format: this.requestDateFmFormat,
                    request_date_to_format: this.requestDateToFormat,
                    action: 'search'
                });
            } else {
                this.requestHeaders = [];
            }
        },
        getReqSearch(params) {
            let vm = this;
            vm.loading = true;
            axios.get(vm.url.index, { params }).then(res => {
                let response = res.data.data
                vm.loading = false;
                vm.requestHeaders = response.data;
            });
        },
        // async selectWipRequestHeader(reqHeader) {
        //     $('#modal_req_search').modal('hide');
        //     this.requestHeaders = [];
        //     this.$emit("selectWipRequestHeader", reqHeader);
        // },
        async searchForm() {
            this.getReqSearch({
                from_transaction_date: this.transDateFormat.from_date,
                to_transaction_date: this.transDateFormat.to_date,
                request_status: this.requestStatus,
                objective_code: this.objectiveCode,
                attribute2: this.header.attribute2,
                request_header_id: this.requestHeaderId,
                attribute3_or_ingredient_group: this.attribute3OrIngredientGroup,
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
                request_status: vm.requestStatus,
                objective_code: vm.objectiveCode,
                attribute2: vm.header.attribute2,
                request_header_id: vm.requestHeaderId,
                attribute3_or_ingredient_group: vm.attribute3OrIngredientGroup,
            }

            axios.get(vm.url.index, { params }).then(res => {
                let response = res.data.data
                vm.getParamlLoading = false;
                vm.inputParams.request_status_list = response.data.request_status_list;
                vm.inputParams.objective_code_list = response.data.objective_code_list;
                vm.inputParams.request_header_id_list = response.data.request_header_id_list;
                vm.inputParams.inventory_item_id_list = response.data.inventory_item_id_list;
                vm.inputParams.attribute3_or_ingredient_group_list = response.data.attribute3_or_ingredient_group_list;
            });
        }
    }
}
</script>