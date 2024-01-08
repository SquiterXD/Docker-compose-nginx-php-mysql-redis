<template>
    <span>
        <div class="modal inmodal fade" id="modal_search" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width: 90%; max-width:950px;">
                <div class="modal-content" v-loading="loading">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">ค้นหารายการแจ้งยอดประมาณการจัดเก็บบุหรี่</h4>
                        <small class="font-bold">
                            &nbsp;
                        </small>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row col-12">
                            <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> ใบส่งเลขที่ :</label>
                                <div class="input-group ">
                                    <input id="lb-2" type="text" class="form-control" name="wip_request_no"
                                       v-model="wipRequestNo"/>
                                   <!--  <el-select
                                          style="width: 100%"
                                          v-model="transferHeaderId"
                                          filterable
                                          clearable
                                          remote
                                          @change="selectWipRequestHeader"
                                          placeholder="ใบส่งเลขที่"
                                          :remote-method="remoteMethod"
                                          :loading="loading"
                                        >
                                      <el-option
                                        v-for="transfer in requestHeaders"
                                        :key="transfer.transfer_header_id"
                                        :label="transfer.wip_request_no"
                                        :value="transfer.transfer_header_id"
                                      ></el-option>
                                    </el-select> -->
                                </div>
                            </div>

                            <div class="form-group text-right  pr-2 mb-0 col-lg-6 col-md-10 col-sm-12 col-xs-12">
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
                                        <th>ใบส่งเลขที่</th>
                                        <th width="200px" class="text-center">สถานะขอเบิก</th>
                                        <th width="150px" class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(reqHeader, index) in requestHeaders">
                                        <td>{{ reqHeader.mfg_order_number }}</td>
                                        <td class="text-center">{{ reqHeader.status.description }}</td>
                                        <td>
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
    export default {
        props:['header', "transBtn", "url", "countOpen"],
        data() {
            return {
                loading: false,
                // reqHeaderHeaderId: '',
                wipRequestNo: '',
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
        },
        methods: {
            openModal() {
                $('#modal_search').modal('show');
            },
            remoteMethod(query) {
                if (query !== "") {
                    this.getWipRequest({ mfg_order_number: query, action: 'search' });
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
                this.getWipRequest({ mfg_order_number: this.wipRequestNo, action: 'search' });
            },
        }
    }
</script>