<template>
    <span>
        <div class="modal inmodal fade" id="modal_search" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width: 90%; max-width: 1230px;  padding-top: 1%;">
                <div class="modal-content" >
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">ค้นหารายการบันทึกส่งสินค้า</h4>
                        <small class="font-bold">
                            &nbsp;
                        </small>
                    </div>
                    <div class="modal-body text-left" v-loading="loading">
                        <div class="row mb-2">
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="text-right tw-font-bold tw-uppercase mt-2"> วันที่ส่งผลผลิต :</div>
                                    </div>
                                    <div class="col-7">
                                        <datepicker-th
                                            class="form-control md:tw-mb-0 tw-mb-2"
                                            style="width: 100%; "
                                            name="transfer_date_from"
                                            id="input_transfer_date_from"
                                            placeholder="โปรดเลือกวันที่"
                                            format="DD/MM/YYYY"
                                            :value="transferDateFrom"
                                            @dateWasSelected="onTransferDateFromWasSelected"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="text-right tw-font-bold tw-uppercase mt-2"> ถึง :</div>
                                    </div>
                                    <div class="col-8">
                                        <datepicker-th
                                            class="form-control md:tw-mb-0 tw-mb-2"
                                            style="width: 100%; "
                                            name="transfer_to"
                                            id="input_transfer_to"
                                            placeholder="โปรดเลือกวันที่"
                                            format="DD/MM/YYYY"
                                            :value="transferDateTo"
                                            :disabled-date-to="transferDateFromFormatted"
                                            @dateWasSelected="onTransferDateToWasSelected"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="text-left tw-font-bold tw-uppercase mt-2"> สินค้าที่จะผลิต :</div>
                                    </div>
                                    <div class="col-7">
                                        <el-select
                                            v-model="inventoryItemId"
                                            filterable
                                            placeholder="สินค้าที่จะผลิต"
                                            class="w-100"
                                            v-loading="false"
                                            clearable
                                            :popper-append-to-body="false"
                                            @change="(value)=>{
                                                if (!value) {
                                                    transferNumber = ''
                                                    transferStatus = ''
                                                }
                                                getParam()
                                            }"
                                        >
                                            <el-option v-if="inventoryItemList.length"
                                                v-for="(item, index) in inventoryItemList"
                                                :key="index"
                                                :label="item.label"
                                                :value="item.value"
                                            >
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="text-right tw-font-bold tw-uppercase mt-2"> ใบส่งเลขที่ :</div>
                                    </div>
                                    <div class="col-7">
                                        <el-select
                                            v-model="transferNumber"
                                            filterable
                                            placeholder="ใบส่งเลขที่"
                                            class="w-100"
                                            v-loading="false"
                                            clearable
                                            :popper-append-to-body="false"
                                            @change="(value)=>{
                                                if (!value) {
                                                    transferStatus = ''
                                                }
                                                getParam()
                                            }"
                                        >
                                            <el-option
                                                v-for="(item, index) in transferNumberList"
                                                :key="index"
                                                :label="item.label"
                                                :value="item.value"
                                            >
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="text-right tw-font-bold tw-uppercase mt-2"> สถานะ :</div>
                                    </div>
                                    <div class="col-8">
                                        <el-select
                                            v-model="transferStatus"
                                            filterable
                                            placeholder="สถานะ"
                                            class="w-100"
                                            v-loading="false"
                                            clearable
                                            :popper-append-to-body="false"
                                            @change="(value)=>{
                                                getParam()
                                            }"
                                        >
                                            <el-option
                                                v-for="(item, index) in transferStatusList"
                                                :key="index"
                                                :label="item.label"
                                                :value="item.value"
                                            >
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-4">
                                        <!-- <div class="text-left tw-font-bold tw-uppercase mt-2"> สถานะ :</div> -->
                                    </div>
                                    <div class="col-7">
                                        <button type="button" @click="getHeaders" :class="transBtn.search.class + ' btn-lg tw-w-fullx'" >
                                            <i :class="transBtn.search.icon"></i>
                                            {{ transBtn.search.text }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class=" ">
                            <div class="table-responsive mb-5">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="200px" class="text-center">วันที่ส่งผลผลิต</th>
                                            <th>ใบส่งเลขที่</th>
                                            <th width="200px" class="text-left">สถานะส่งสินค้า</th>
                                            <th width="150px" class="text-center"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(transferHeader, index) in transferHeaders" :key="index">
                                            <td class="text-center">{{ getDateFormatted(transferHeader.transfer_date) }}</td>
                                            <td>{{ transferHeader.transfer_number }}</td>
                                            <td class="text-left">
                                                <div v-if="transferHeader.status">
                                                    {{ transferHeader.status.description }}
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <button type="button" :class="transBtn.detail.class + ' tw-w-25 btn-sm'"
                                                    @click="selectRequestHeader(transferHeader)">
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
import DatepickerTh from "../../DatepickerTh";

export default {
    props:['countOpen', 'transBtn'],
    data() {
        return {
            newHeader: {},
            loading: false,
            getParamlLoading: false,
            transferDateFrom:  moment().add(543, 'years').toDate(),
            transferDateFromFormatted:  this.getDateFormatted(moment().add(543, 'years').toDate()),
            transferDateTo:  '',
            transferDateToFormatted:  '',
            inventoryItemId: '',
            inventoryItemList: [],
            transferNumber: '',
            transferNumberList: [],
            transferStatus: '',
            transferStatusList: [],
            transferHeaders: [],

        }
    },
    beforeMount() {

    },
    mounted() {
        // this.openModal();
        // this.getParam()
    },
    computed: {
        // blendLists(){
        //     return this.inputParams.blend_no_list;
        // }
    },
    watch:{
        countOpen : async function (value, oldValue) {
            this.openModal();
            this.getParam()
        },
    },
    methods: {

        async onTransferDateFromWasSelected(value) {
            this.transferDateFrom = value;
            this.transferDateFromFormatted = this.getDateFormatted(this.transferDateFrom);
            this.getParam();

        },
        async onTransferDateToWasSelected(value) {
            if (!value) {
                this.inventoryItemId = '';
                this.transferNumber = ''
                this.transferStatus = ''
            }
            this.transferDateTo = value;
            this.transferDateToFormatted = this.getDateFormatted(this.transferDateTo);
            this.getParam();

        },
        getDateFormatted(date) {
            return moment(date).format("DD/MM/YYYY");
        },

        openModal() {
            $('#modal_search').modal('show');
            $('.slimScroll').slimScroll({
                height: '250px',
                width: '100%'
            });
        },
        // async selectRow(reqHeader) {
        //     $('#modal_search').modal('hide');
        //     this.requestHeaders = [];
        //     this.$emit("selectRow", reqHeader);
        // },
        async searchForm() {
            this.search({
                action: 'search',
                // blend_no: this.blendNo,
                // formula_type_code: this.header.formula_type_code
                // blend_no: this.newHeader.blend_no,
                // tobacco_type_code: this.newHeader.tobacco_type_code,
                // formula_type_code: this.newHeader.formula_type_code,
                // recipe_fiscal_year: this.newHeader.recipe_fiscal_year,
                // formula_status: this.newHeader.formula_status,
            });
        },
        async getParam() {
            let vm = this;
            vm.loading = true;
            vm.inventoryItemList = [];
            vm.transferNumberList = [];
            vm.transferStatusList = [];
            vm.transferHeaders = [];
            var params = {
                action: 'get-param',
                transfer_date_from: vm.transferDateFromFormatted,
                transfer_date_to: vm.transferDateToFormatted,
                inventory_item_id: vm.inventoryItemId,
                transfer_number: vm.transferNumber,
                transfer_status: vm.transferStatus,
            }

            await axios.get(`/ajax/pm/products/trans/get-headers`, { params })
            .then(res => {

                const resData = res.data.data;
                vm.inventoryItemList = resData.inventory_item_list
                vm.transferNumberList = resData.transfer_number_list
                vm.transferStatusList = resData.transfer_status_list
            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูล  | ${error.message}`, "error");
            });
            vm.loading = false;
        },
        async getHeaders() {

            // show loading
            this.loading = true;

            var params = {
                transfer_date_from: this.transferDateFromFormatted,
                transfer_date_to: this.transferDateToFormatted,
                inventory_item_id: this.inventoryItemId,
                transfer_number: this.transferNumber,
                transfer_status: this.transferStatus,
            };
            await axios.get(`/ajax/pm/products/trans/get-headers`, { params })
            .then(res => {

                const resData = res.data.data;

                if(resData.status == "success") {

                    this.transferHeaders = resData.transfer_headers ? JSON.parse(resData.transfer_headers) : [];

                } else {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูล | ${resData.message}`, "error");
                }

                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูล  | ${error.message}`, "error");
            });

            // hide loading
            this.loading = false;

        },
        async selectRequestHeader(transferHeader) {
            this.transferHeaders = [];
            $('#modal_search').modal('hide');
            this.$emit("onSearchRequestHeader", {
                transferHeader: transferHeader,
            });

        },
    }
}
</script>