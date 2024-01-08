<template>

    <div style="position: fixed; z-index: 100;">
        
        <modal
            :name="modalName"
            :width="width"
            :scrollable="true"
            :height="modalHeight"
            :shiftX="0.3"
            :shiftY="0.3"
        >

            <div class="p-4">

                <h4> ค้นหารายการบันทึกส่งสินค้าสำเร็จรูป </h4>
                <hr>

                <div class="row">

                    <div class="col-lg-9">

                        <div class="form-group row">

                            <label class="col-lg-3 font-weight-bold col-form-label text-right" for="lb-2">ใบส่งเลขที่: </label>
                            
                            <div class="col-lg-9">

                                <input id="lb-2" 
                                    type="text" 
                                    class="form-control" 
                                    name="transfer_number"
                                    v-model="searchTransferNumber"
                                />

                            </div>
                            
                        </div>

                        <div class="form-group row">

                            <label class="col-lg-3 font-weight-bold col-form-label text-right">วันที่ส่งผลผลิต: </label>

                            <div class="col-lg-4">

                                <datepicker-th
                                    class="form-control md:tw-mb-0 tw-mb-2"
                                    name="transfer_date_from"
                                    id="input_transfer_date_from"
                                    placeholder="โปรดเลือกวันที่"
                                    format="DD/MM/YYYY"
                                    :value="transferDateFrom"
                                    @dateWasSelected="onTransferDateFromWasSelected"
                                />

                            </div>

                            <label class="col-lg-1 font-weight-bold col-form-label text-right"> ถึง </label>

                            <div class="col-lg-4">

                                <datepicker-th
                                    class="form-control md:tw-mb-0 tw-mb-2"
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

                    <div class="col-lg-3">

                        <button type="button" @click="getHeaders" :class="transBtn.search.class + ' btn-lg tw-w-full'" >
                            <i :class="transBtn.search.icon"></i> 
                            {{ transBtn.search.text }}
                        </button>

                    </div>

                </div>

                <div class="table-responsive mb-3">

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="200px" class="text-center">วันที่ส่งผลผลิต</th>
                                <th>ใบส่งเลขที่</th>
                                <th width="200px" class="text-center">สถานะขอเบิก</th>
                                <th width="150px" class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(transferHeader, index) in transferHeaders" :key="index">
                                <td class="text-center">{{ getDateFormatted(transferHeader.transfer_date) }}</td>
                                <td>{{ transferHeader.transfer_number }}</td>
                                <td class="text-center">
                                    <div v-if="transferHeader.status">
                                        {{ transferHeader.status.description }}
                                    </div>
                                </td>
                                <td class="text-right">
                                    <button type="button" :class="transBtn.detail.class + ' btn-lg tw-w-25'"
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

        </modal>

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

    </div>
    
</template>

<script>

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import moment from 'moment';

import DatepickerTh from "../../DatepickerTh";

export default {

    props: [
        "modalName", 
        "modalWidth", 
        "modalHeight", 
        "transBtn",
        "transferDateFromValue", 
        "transferDateToValue", 
    ],

    components: { Loading, DatepickerTh },
    
    data() {
        return {
            isLoading: false,
            width: this.modalWidth,
            searchTransferNumber: "",
            transferDateFrom: this.transferDateFromValue ? moment(this.transferDateFromValue).toDate() : null,
            transferDateFromFormatted: this.transferDateFromValue ? this.getDateFormatted(moment(this.transferDateFromValue).toDate()) : null,
            transferDateTo: this.transferDateValue ? moment(this.transferDateValue).toDate() : null,
            transferDateToFormatted: this.transferDateValue ? this.getDateFormatted(moment(this.transferDateValue).toDate()) : null,
            transferHeaders: [],
        }
    },

    mounted() {
        
    },

    computed: {

    },

    watch:{

    },

    methods: {


        async onTransferDateFromWasSelected(value) {
            
            this.transferDateFrom = value;
            this.transferDateFromFormatted = this.getDateFormatted(this.transferDateFrom);

        },

        async onTransferDateToWasSelected(value) {
            
            this.transferDateTo = value;
            this.transferDateToFormatted = this.getDateFormatted(this.transferDateTo);

        },

        getDateFormatted(date) {
            return moment(date).format("DD/MM/YYYY");
        },

        async getHeaders() {

            // show loading
            this.isLoading = true;

            var params = { 
                search_transfer_number: this.searchTransferNumber,
                transfer_date_from: this.transferDateFromFormatted,
                transfer_date_to: this.transferDateToFormatted,
                transfer_objective: this.transferObjective,
            };
            await axios.get(`/ajax/pm/products/transfer-split-lots/get-headers`, { params })
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
            this.isLoading = false;

        },

        async selectRequestHeader(transferHeader) {
            this.transferHeaders = [];
            this.$modal.hide(this.modalName);
            this.$emit("onSearchRequestHeader", {
                transferHeader: transferHeader,
            });

        },

    }
}
</script>

<style scoped>
.v--modal-overlay {
  z-index: 2000;
  padding-top: 3rem;
  padding-bottom: 3rem;
}
</style>
