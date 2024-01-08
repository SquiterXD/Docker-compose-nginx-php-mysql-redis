<template>

    <!-- <div style="position: fixed; z-index: 100;"> -->

    <div style="z-index: 100;">
        
        <modal
            :name="modalName"
            :width="width"
            :scrollable="true"
            :height="height"
            :shiftX="0.5"
            :shiftY="0.5"
        >

            <div class="p-2 text-left">
                <div class="btn-group tw-pb-3" role="group">
                    <button type="button" class="btn" v-bind:class="isTabMesActive ? 'btn-primary' : 'btn-white'"
                        @click="toggleTab('MES')"> 
                        รายการความชื้นจาก MES
                    </button>
                    <button type="button" class="btn" v-bind:class="isTabMesActive ? 'btn-white' : 'btn-primary'"
                        @click="toggleTab('INPUT')"> 
                        กรอกค่าความชื้นเอง
                    </button>
                </div>
                <div v-if="isTabMesActive" class="table-responsive" style="max-height: 480px;">

                    <table class="table table-bordered table-sticky mb-0" style="min-width: 600px;">

                        <thead>
                            <tr>
                                <th width="15%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 text-center md:tw-table-cell tw-hidden">
                                    BATCH ID
                                </th>
                                <th width="15%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 text-center md:tw-table-cell tw-hidden">
                                    หัววัดความชื้น
                                </th>
                                <th width="15%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 text-center md:tw-table-cell tw-hidden">
                                    เวลา
                                </th>
                                <th width="30%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 text-right md:tw-table-cell tw-hidden">
                                    ค่าความชื้น
                                </th>
                                <th width="10%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 text-center">
                                    
                                </th>
                                
                            </tr>
                        </thead>
                        <tbody v-if="inputBatchItems.length > 0">
                            <template v-for="(batchItem, index) in inputBatchItems">
                                <tr :key="index">

                                    <td  class="tw-text-gray-600 tw-bg-opacity-40 text-center md:tw-table-cell tw-hidden">
                                        {{ batchItem.batch_id }}
                                    </td>
                                    <td  class="tw-text-gray-600 tw-bg-opacity-40 text-center md:tw-table-cell tw-hidden">
                                        {{ batchItem.moisture_point }}
                                    </td>
                                    <td class="tw-text-gray-600 tw-bg-opacity-40 text-center md:tw-table-cell tw-hidden">
                                        <strong> {{ batchItem.blend_time }} </strong>
                                    </td>
                                    <td class="tw-text-gray-600 tw-bg-opacity-40 text-right md:tw-table-cell tw-hidden">
                                        <strong> {{ batchItem.moisture_value }} </strong>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" @click="onSelectMesBatchItem($event, batchItem)" class="btn btn-xs btn-primary"> 
                                            เลือก
                                        </button>
                                    </td>
                                    
                                </tr>
                            </template>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td colspan="6">
                                    <h2 class="px-5 tw-py-32 text-center text-muted"> ไม่พบข้อมูล </h2>
                                </td>
                            </tr>
                        </tbody>

                    </table>

                </div>
                <div v-else class="tw-p-2">
                    <div class="form-group tw-mb-2">
                        <input
                            :id="`input_moisture_value`"
                            type="number"
                            class="form-control input-sm text-right"
                            :name="`moisture_value`"
                            v-model="inputMoistureValue"
                            placeholder="กรอกค่าความชื้น"
                        />
                    </div>
                    <div class="text-right">
                        <button type="button" @click="onSubmitInputMoistureValue($event)" class="btn btn-primary"> 
                            บันทึก
                        </button>
                    </div>
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

export default {

    props: [
        "modalName", 
        "modalWidth", 
        "modalHeight", 
        "sample",
        "sampleResult",
        "batchItems",
    ],

    components: { Loading },

    watch: {

        sample : function (data) {
            this.sampleItem = data ? data : [];
        },
        sampleResult : function (data) {
            this.sampleResultItem = data ? data : [];
        },
        batchItems : function (data) {
            this.inputBatchItems = data ? data : [];
        },
        
    },

    data() {
        return {
            isLoading: false,
            width: this.modalWidth,
            height: this.modalHeight,
            isTabMesActive: true,
            sampleItem: this.sample ? this.sample : null,
            sampleResultItem: this.sampleResult ? this.sampleResult : null,
            inputBatchItems: this.batchItems ? this.batchItems : [],
            inputMoistureValue: null,
        };
    },

    created() {

        this.handleResize();

    },

    mounted() {

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

        toggleTab(tab) {
            this.isTabMesActive = tab == "MES" ? true : false;
            this.height = tab == "MES" ? 440 : 240
        },

        onSelectMesBatchItem(e, batchItem) {

            this.$modal.hide(this.modalName);

            this.$emit("onSelectMesBatchItem", {
                sample: this.sampleItem,
                sample_result: this.sampleResultItem,
                batch_item: batchItem,
            });

        },

        onSubmitInputMoistureValue(e) {

            this.$modal.hide(this.modalName);

            this.$emit("onSubmitInputMoistureValue", {
                sample: this.sampleItem,
                sample_result: this.sampleResultItem,
                moisture_value: this.inputMoistureValue
            });

        },

        formatDateTh(date) {
            return date ? moment(date).add(543, 'years').format('DD/MM/YYYY') : ""
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
