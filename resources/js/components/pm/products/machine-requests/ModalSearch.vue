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

                <h4> ค้นหาประมาณการวัตถุดิบประจำปี </h4>
                <hr>

                <div class="row form-group">

                    <label class="col-md-4 col-form-label tw-font-bold"> วันที่ </label>

                    <div class="col-md-4">

                        <datepicker-th
                            class="form-control md:tw-mb-0 tw-mb-2"
                            name="request_date"
                            id="input_request_date"
                            placeholder="โปรดเลือกวันที่"
                            format="DD/MM/YYYY"
                            :value="requestDate"
                            @dateWasSelected="requestDateWasSelected"
                        />

                    </div>

                    <div class="col-md-4">

                        <button type="button" 
                            @click="onSearchMachineRequests" 
                            class="btn btn-white tw-w-32"> 
                            <i class="fa fa-search"></i> ค้นหา 
                        </button>

                        <button type="button" 
                            @click="$modal.hide(modalName)" 
                            class="btn btn-link"> 
                            ยกเลิก 
                        </button>
                        
                    </div>

                </div>

                <hr>

                <div class="table-responsive" style="max-height: 300px;">

                    <table class="table table-bordered mb-0">
                        <thead>                                 
                            <tr>
                                <th width="20%" class="text-center"> ลำดับที่ </th>
                                <th width="30%" class="text-center"> วันที่เบิก </th>
                                <th width="30%" class="text-center"> เลขที่ใบเบิก </th>
                                <th width="20%" class="text-center"> </th>
                            </tr>
                        </thead>
                        <tbody v-if="headerRequests.length > 0">
                            <template v-for="(headerRequest, index) in headerRequests">
                                <tr :key="`${index}`"> 
                                    <td class="text-center"> {{ index+1 }} </td>
                                    <td class="text-center"> {{ headerRequest.request_date_formatted }} </td>
                                    <td class="text-center"> {{ headerRequest.request_number }} </td>
                                    <td class="text-center"> 
                                        <button type="button" 
                                            class="btn btn-xs btn-primary" 
                                            @click="onSelectedSearchMachineRequest(headerRequest.request_date_formatted, headerRequest.request_number)"> 
                                            เลือก 
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td colspan="4">
                                    <h2 class="p-5 text-center text-muted"> ไม่พบข้อมูล </h2>
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
import moment from 'moment';
import DatepickerTh from "../../DatepickerTh";

import "vue-loading-overlay/dist/vue-loading.css";

export default {

    props: [
        "modalName", 
        "modalWidth", 
        "modalHeight"
    ],

    components: { Loading, DatepickerTh },

    watch: {
        
    },

    data() {
        return {
            isLoading: false,
            width: this.modalWidth,
            requestDate: null,
            headerRequests: [],
        };
    },

    created() {
        this.handleResize();
    },

    methods: {

        handleResize() {
            if (window.innerWidth < 768) {
                // set modal width = 90% when screen width < 769px
                this.width = "90%";
            } else if (window.innerWidth < 992) {
                // set modal width = 80% when screen width < 992px
                this.width = "80%";
            } else {
                this.width = this.modalWidth;
            }
        },

        async requestDateWasSelected(value) {
            this.requestDate = value;
        },

        async onSearchMachineRequests() {

            // REFRESH DATA
            this.headerRequests = [];

            // show loading
            this.isLoading = true;

            const requestDateFormatted = this.requestDate ? moment(this.requestDate).format("DD/MM/YYYY") : "";
        
            var params = { 
                request_date: requestDateFormatted,
            };

            await axios.get("/ajax/pm/products/machine-requests/search-request-headers", { params })
            .then(res => {
                const resData = res.data.data;
                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `ข้อมูลเบิกวัตถุดิบหข้าหน้าเครื่องจักร ${requestDateFormatted} ไม่ถูกต้อง | ${resData.message}`, "error");
                } else {
                    this.headerRequests = resData.header_requests ? JSON.parse(resData.header_requests).map(item => {
                        return {
                            ...item,
                            request_date_formatted: item.request_date ? moment(item.request_date).add(543, 'years').format("DD/MM/YYYY") : ""
                        }
                    }) : [];
                }
                return resData;
            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ข้อมูลเบิกวัตถุดิบหข้าหน้าเครื่องจักร ${requestDateFormatted} ไม่ถูกต้อง | ${error.message}`, "error");
                return ;
            });
            
            // hide loading
            this.isLoading = false;
            
        },

        onSelectedSearchMachineRequest(requestDate, requestNumber) {
            this.$modal.hide(this.modalName);
            this.$emit("onSelectedSearchMachineRequest", {
                request_date: requestDate,
                request_number: requestNumber,
            });
        },

    }
};
</script>

<style scoped>
.v--modal-overlay {
  z-index: 2000;
  padding-top: 3rem;
  padding-bottom: 3rem;
}
</style>
