<template>
    <span>
        <div class="modal inmodal fade" id="modal_search" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width: 90%; max-width:950px;">
                <div class="modal-content" v-loading="loading">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">ค้นหารายการโอนสินค้าสำเร็จรูป</h4>
                        <small class="font-bold">
                            &nbsp;
                        </small>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row col-12" style="padding-right: 10px; padding-left: 120px;">
                            <div class="col-3">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> ใบส่งเลขที่ :</label>
                                <div class="input-group ">
                                    <input id="lb-2" type="text" class="form-control" name="transfer_number"
                                       v-model="transferNumber"/>
                                </div>
                            </div>

                            <div class="col-3">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> วันที่ได้ผลผลิต :</label>
                                <div class="input-group ">
                                    <datepicker-th
                                        style="width: 100%"
                                        class="form-control md:tw-mb-0 tw-mb-2"
                                        placeholder="โปรดเลือกวันที่"
                                        :value="productDateFormat"
                                        :format="transDate['js-format']"
                                        @dateWasSelected="setdate(...arguments, 'product_date_format')"
                                        />
                                </div>
                            </div>

                            <div class="col-3">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> วันที่ส่งผลผลิต :</label>
                                <div class="input-group ">
                                    <datepicker-th
                                        style="width: 100%"
                                        class="form-control md:tw-mb-0 tw-mb-2"
                                        placeholder="โปรดเลือกวันที่"
                                        :value="transferDateFormat"
                                        :format="transDate['js-format']"
                                        @dateWasSelected="setdate(...arguments, 'transfer_date_format')"
                                        />
                                </div>
                            </div>

                            <div class="col-3">
                                <label class="text-left tw-font-bold tw-uppercase mb-1">&nbsp;</label>
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
                                        <th width="200px" class="text-center" >ใบส่งเลขที่</th>
                                        <th width="100px" class="text-center">วันที่ได้ผลผลิต</th>
                                        <th width="100px" class="text-center">วันที่ส่งผลผลิต</th>
                                        <th class="text-center">วัตถุประสงค์</th>
                                        <th width="100px" class="text-center">สถานะขอเบิก</th>
                                        <th width="150px" class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(transfer, index) in transferList">
                                        <td>{{ transfer.transfer_number }}</td>
                                        <td class="text-center">{{ transfer.product_date_format }}</td>
                                        <td class="text-center">{{ transfer.transfer_date_format }}</td>
                                        <td>{{ transfer.objective.description }}</td>
                                        <td>{{ transfer.status.description }}</td>
                                        <td>
                                            <button type="button" :class="transBtn.detail.class + ' btn-lg tw-w-25'"
                                                @click="selectTransferHeader(transfer)">
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
        props:['header', "transBtn", "url", "countOpen", "transDate"],
        data() {
            return {
                loading: false,
                transferHeaderId: '',
                transferNumber: '',
                productDateFormat: '',
                transferDateFormat: '',
                transferList: [],
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
            async setdate(date, inputName) {
                let vm = this;

                if (inputName == 'product_date_format') {
                    if (date) {
                        vm.productDateFormat = await moment(date).format(vm.transDate['js-format']);
                    } else {
                        vm.productDateFormat = '';
                    }
                }

                if (inputName == 'transfer_date_format') {
                    if (date) {
                        vm.transferDateFormat = await moment(date).format(vm.transDate['js-format']);
                    } else {
                        vm.transferDateFormat = '';
                    }
                }
            },
            openModal() {
                $('#modal_search').modal('show');
            },
            // remoteMethod(query) {
            //     if (query !== "") {
            //         this.getTransferList({ transfer_number: query, action: 'search' });
            //     } else {
            //         this.transferList = [];
            //     }
            // },
            getTransferList(params) {
                let vm = this;
                vm.loading = true;
                axios.get(vm.url.index, { params }).then(res => {
                    let response = res.data.data
                    vm.loading = false;
                    vm.transferList = response.data;
                });
            },
            async selectTransferHeader(transfer) {
                $('#modal_search').modal('hide');
                this.$emit("selectTransferHeader", transfer);
            },
            async searchForm() {
                this.getTransferList({
                    transfer_number: this.transferNumber,
                    product_date_format: this.productDateFormat,
                    transfer_date_format: this.transferDateFormat,
                    action: 'search'
                });
            },
        }
    }
</script>