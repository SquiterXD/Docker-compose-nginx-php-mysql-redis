<template>
    <span>
        <div class="modal inmodal fade" id="modal_search" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width: 90%; max-width: 1230px;  padding-top: 1%;">
                <div class="modal-content" >
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">ค้นหารายการโอนสินค้าสำเร็จรูป</h4>
                        <small class="font-bold">
                            &nbsp;
                        </small>
                    </div>
                    <div class="modal-body text-left" v-loading="loading">
                        <div class="row mb-2">
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="text-right tw-font-bold tw-uppercase mt-2"> วันที่ได้ผลผลิต :</div>
                                    </div>
                                    <div class="col-7">
                                        <datepicker-th
                                            class="form-control md:tw-mb-0 tw-mb-2"
                                            style="width: 100%; "
                                            placeholder="โปรดเลือกวันที่"
                                            format="DD/MM/YYYY"
                                            :value="productDateFrom"
                                            @dateWasSelected="onProductDateFromWasSelected"
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
                                            placeholder="โปรดเลือกวันที่"
                                            format="DD/MM/YYYY"
                                            :value="productDateTo"
                                            :disabled-date-to="productDateToFormatted"
                                            @dateWasSelected="onProductDateToWasSelected"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                            </div>
                        </div>

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
                                                    transferObjective = ''
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
                                                    transferObjective = ''
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
                                        <div class="text-right tw-font-bold tw-uppercase mt-2"> วัตถุประสงค์ :</div>
                                    </div>
                                    <div class="col-8">
                                        <el-select
                                            v-model="transferObjective"
                                            filterable
                                            placeholder="วัตถุประสงค์"
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
                                                v-for="(item, index) in transferObjectiveList"
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
                                        <div class="text-left tw-font-bold tw-uppercase mt-2"> สถานะส่งสินค้า :</div>
                                    </div>
                                    <div class="col-7">
                                        <el-select
                                            v-model="transferStatus"
                                            filterable
                                            placeholder="สถานะส่งสินค้า"
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
                        </div>
                        <div class="row mb-2">
                            <div class="col-8">
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

                        <div class="ibox-content">
                            <div class="table-responsive mb-5">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="200px" class="text-center" >ใบส่งเลขที่</th>
                                            <th width="100px" class="text-center">วันที่ได้ผลผลิต</th>
                                            <th class="text-left">วันที่ส่งผลผลิต</th>
                                            <th width="120px" class="text-left">วัตถุประสงค์</th>
                                            <th width="120px" class="text-left">สถานะส่งสินค้า</th>
                                            <th width="150px" class="text-center"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(transferHeader, index) in transferHeaders" :key="index">
                                            <td class="text-center">{{ transferHeader.transfer_number }}</td>
                                            <td class="text-center">{{ getDateFormatted(transferHeader.product_date) }}</td>
                                            <td class="text-left">{{ getDateFormatted(transferHeader.transfer_date) }}</td>
                                            <td class="text-left">{{ transferHeader.objective.description }}</td>
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
import DatepickerTh from "../../components/DatepickerTh";

export default {
    props:['countOpen', 'transBtn', 'url'],
    data() {
        return {
            newHeader: {},
            loading: false,
            getParamlLoading: false,
            productDateFrom:  moment().add(543, 'years').toDate(),
            productDateFromFormatted:  this.getDateFormatted(moment().add(543, 'years').toDate()),
            productDateTo:  '',
            productDateToFormatted:  '',

            transferDateFrom:  '',
            transferDateFromFormatted:  '',
            transferDateTo:  '',
            transferDateToFormatted:  '',
            inventoryItemId: '',
            inventoryItemList: [],
            transferNumber: '',
            transferNumberList: [],
            transferObjective: '',
            transferObjectiveList: [],
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

        async onProductDateFromWasSelected(value) {
            this.productDateFrom = value;
            this.productDateFromFormatted = this.getDateFormatted(this.productDateFrom);
            this.getParam();

        },
        async onProductDateToWasSelected(value) {
            if (!value) {
                this.inventoryItemId = '';
                this.transferNumber = ''
                this.transferObjective = ''
                this.transferStatus = ''
                this.transferDateFrom = '';
                this.transferDateFromFormatted = '';
                this.transferDateTo = '';
                this.transferDateToFormatted = '';
            }
            this.productDateTo = value;
            this.productDateToFormatted = this.getDateFormatted(this.productDateTo);
            this.getParam();

        },
        async onTransferDateFromWasSelected(value) {
            if (!value) {
                this.inventoryItemId = '';
                this.transferNumber = ''
                this.transferObjective = ''
                this.transferStatus = ''
            }
            this.transferDateFrom = value;
            this.transferDateFromFormatted = this.getDateFormatted(this.transferDateFrom);
            this.getParam();

        },
        async onTransferDateToWasSelected(value) {
            if (!value) {
                this.inventoryItemId = '';
                this.transferNumber = ''
                this.transferObjective = ''
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
            vm.transferObjectiveList = [];
            vm.transferStatusList = [];
            vm.transferHeaders = [];
            var params = {
                action: 'get-param',
                product_date_from: vm.productDateFromFormatted,
                product_date_to: vm.productDateToFormatted,
                transfer_date_from: vm.transferDateFromFormatted,
                transfer_date_to: vm.transferDateToFormatted,
                inventory_item_id: vm.inventoryItemId,
                transfer_number: vm.transferNumber,
                transfer_objective: vm.transferObjective,
                transfer_status: vm.transferStatus,
            }

            await axios.get(vm.url.index, { params })
            .then(res => {

                const resData = res.data.data;
                vm.inventoryItemList = resData.inventory_item_list
                vm.transferNumberList = resData.transfer_number_list
                vm.transferObjectiveList = resData.transfer_objective_list
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
                action: 'search',
                product_date_from: this.productDateFromFormatted,
                product_date_to: this.productDateToFormatted,
                transfer_date_from: this.transferDateFromFormatted,
                transfer_date_to: this.transferDateToFormatted,
                inventory_item_id: this.inventoryItemId,
                transfer_number: this.transferNumber,
                transfer_objective: this.transferObjective,
                transfer_status: this.transferStatus,
            };
            await axios.get(this.url.index, { params })
            .then(res => {

                const resData = res.data.data;

                this.transferHeaders = resData.transfer_headers ? JSON.parse(resData.transfer_headers) : [];
                // if(resData.status == "success") {


                // } else {
                //     swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูล | ${resData.message}`, "error");
                // }

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
            this.$emit("selectTransferHeader", transferHeader);
        },
    }
}
</script>