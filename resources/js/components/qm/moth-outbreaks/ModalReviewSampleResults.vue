<template>

    <!-- <div style="position: fixed; z-index: 100;"> -->

    <div style="z-index: 100;">
        
        <modal
            :name="modalName"
            :width="width"
            :scrollable="true"
            :height="modalHeight"
            :shiftX="0.2"
            :shiftY="0.4"
        >

            <div class="p-4 text-left">
                
                <h3 class="text-left"> Upload ผลการทดสอบ </h3>
                <hr class="tw-mt-1">
                <div class="btn-group tw-pb-3" role="group">
                    <template v-for="(sheetItem, sIndex) in sheetItems">
                        <button :key="`${sIndex}`" type="button" 
                            class="btn"
                            v-bind:class="[sheetActiveStatuses[sIndex].active ? 'btn-primary' : 'btn-white']"
                            @click="toggleSheet(sIndex)"
                        > 
                            {{ sheetItem }} 
                        </button>
                    </template>
                </div>

                <div class="table-responsive" style="max-height: 400px;">

                    <table class="table table-bordered table-sticky mb-0" style="min-width: 800px;">

                        <thead>
                            <tr>
                                <th rowspan="2" class="text-center">
                                    โซนที่ตั้ง  
                                </th>
                                <th rowspan="2" class="text-center">
                                    บริเวณที่ติดตั้ง
                                </th>
                                <template v-for="(sampleDate, sdIndex) in sampleDateItems">
                                    <th colspan="3" :key="`${sdIndex}`" class="text-center">
                                        {{ sampleDate.sample_date_formatted }}
                                    </th>
                                </template>
                            </tr>
                            <tr>
                                <template v-for="(sampleDate, sdIndex) in sampleDateItems">
                                    <th :key="`${sdIndex}_1`" class="text-center" style="top: 34px; padding: 0px;">
                                        <div class="tw-p-2" style="border-top: 1px solid #e7eaec;"> เลือก </div>
                                        <div class="tw-p-2" style="border-top: 1px solid #e7eaec;"> 
                                            <span> 
                                                <input type="checkbox" @change="onToggleSelectAll($event, sampleDate)" v-model="sampleDate.all_selected">
                                            </span>
                                        </div>
                                    </th>
                                    <th :key="`${sdIndex}_2`" class="text-center" style="top: 34px; padding: 0px;">
                                        <div class="tw-py-6 tw-px-2" style="min-height: 70px; border-top: 1px solid #e7eaec;"> มอดยาสูบ </div>
                                    </th>
                                    <th :key="`${sdIndex}_3`" class="text-center" style="top: 34px; padding: 0px;">
                                        <div class="tw-py-6 tw-px-2" style="min-height: 70px; border-top: 1px solid #e7eaec;"> สถานะการลงผล </div>
                                    </th>
                                </template>
                            </tr>
                        </thead>
                        <tbody v-if="activatedLocatorLength > 0">
                            <template v-for="(pl, plIndex) in preparedLocatorItems">
                                <tr v-show="isLocatorShow(pl.locator_id)" :key="`${plIndex}`">
                                    <td class="text-center">
                                        {{ pl.location_desc }}
                                    </td>
                                    <td class="text-left">
                                        {{ pl.location_full_desc }}
                                    </td>
                                    <template v-for="(sd, sdIndex) in sampleDateItems">
                                        <td :key="`${sdIndex}_1`" class="text-center">
                                            <template v-if="cisItems.find(item => (item.locator_id == pl.locator_id && item.sample_date_formatted == sd.sample_date_formatted))">
                                                <span v-if="(cisItems.find(item => (item.locator_id == pl.locator_id && item.sample_date_formatted == sd.sample_date_formatted))).is_new_sample"> 
                                                    <input type="checkbox" @change="onSampleItemHasChanged($event)" v-model="(cisItems.find(item => (item.locator_id == pl.locator_id && item.sample_date_formatted == sd.sample_date_formatted))).selected">
                                                </span>
                                                <span v-else-if="(cisItems.find(item => (item.locator_id == pl.locator_id && item.sample_date_formatted == sd.sample_date_formatted))).result_value_has_changed">
                                                    <input type="checkbox" @change="onSampleItemHasChanged($event)" v-model="(cisItems.find(item => (item.locator_id == pl.locator_id && item.sample_date_formatted == sd.sample_date_formatted))).selected">
                                                </span>
                                                <span v-else> 
                                                    <input type="checkbox" @change="onSampleItemHasChanged($event)" disabled>
                                                </span>
                                            </template>
                                        </td>
                                        <td :key="`${sdIndex}_2`" class="text-center">
                                            <template v-if="cisItems.find(item => (item.locator_id == pl.locator_id && item.sample_date_formatted == sd.sample_date_formatted))">
                                                <span class="tw-text-green-600 tw-font-bold" v-if="(cisItems.find(item => (item.locator_id == pl.locator_id && item.sample_date_formatted == sd.sample_date_formatted))).is_new_sample"> 
                                                    <!-- NEW SAMPLE -->
                                                    {{ (cisItems.find(item => (item.locator_id == pl.locator_id && item.sample_date_formatted == sd.sample_date_formatted))).result_value }}
                                                </span>
                                                <span class="tw-text-red-600 tw-font-bold" v-else-if="(cisItems.find(item => (item.locator_id == pl.locator_id && item.sample_date_formatted == sd.sample_date_formatted))).result_value_has_changed">
                                                    <!-- EXISTS BUT HAS CHANGED -->
                                                    {{ (cisItems.find(item => (item.locator_id == pl.locator_id && item.sample_date_formatted == sd.sample_date_formatted))).result_value }}
                                                </span>
                                                <span class="tw-text-gray-400 tw-font-bold" v-else> 
                                                    <!-- NO CHANGED -->
                                                    {{ (cisItems.find(item => (item.locator_id == pl.locator_id && item.sample_date_formatted == sd.sample_date_formatted))).result_value }}
                                                </span>
                                            </template>
                                        </td>
                                        <td :key="`${sdIndex}_3`" class="text-center">
                                            <template v-if="cisItems.find(item => (item.locator_id == pl.locator_id && item.sample_date_formatted == sd.sample_date_formatted))">
                                                <span class="tw-text-green-600 tw-font-bold" v-if="(cisItems.find(item => (item.locator_id == pl.locator_id && item.sample_date_formatted == sd.sample_date_formatted))).is_new_sample"> 
                                                    <!-- NEW SAMPLE -->
                                                    ยังไม่อัพโหลด
                                                </span>
                                                <span class="tw-text-blue-600 tw-font-bold" v-else-if="(cisItems.find(item => (item.locator_id == pl.locator_id && item.sample_date_formatted == sd.sample_date_formatted))).result_value_has_changed">
                                                    <!-- EXISTS BUT HAS CHANGED -->
                                                    อัพโหลดแล้ว
                                                </span>
                                                <span class="tw-text-gray-600 tw-font-bold" v-else> 
                                                    <!-- NO CHANGED -->
                                                    อัพโหลดแล้ว
                                                </span>
                                            </template>
                                        </td>
                                    </template>
                                </tr>
                            </template>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td colspan="10">
                                    <h2 class="p-5 text-center text-muted"> ไม่พบข้อมูล </h2>
                                </td>
                            </tr>
                        </tbody>

                    </table>

                </div>

                <hr>

                <div class="text-right tw-mt-2">

                    <button type="button" 
                        @click="onConfirmUpload" 
                        :disabled="!isAllowConfirmUpload"
                        class="btn btn-primary tw-w-32"> 
                        ยืนยัน
                    </button>

                    <button type="button" 
                        @click="$modal.hide(modalName)" 
                        class="btn btn-link"> 
                        ยกเลิก 
                    </button>

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
        "sheets",
        "sampleDates",
        "locators",
        "preparedLocators",
        "samples",
        "inputSamples",
        "comparedInputSamples",
    ],

    components: { Loading },

    watch: {

        sheets : function (data) {
            this.sheetItems = data ? data : [];
            this.sheetActiveStatuses = data ? data.map((item, index) => {
                return {
                    sheet_index: index,
                    sheet_name: item,
                    active: index === 0 ? true : false,
                }
            }) : [];
            this.activatedLocatorLength = (this.getActivatedLocators(this.sheetActiveStatuses, this.preparedLocatorItems)).length;
        },
        sampleDates : function (data) {
            this.sampleDateItems = data ? data.map(item => {
                return {
                    ...item,
                    all_selected: true,
                }
            }) : [];
        },
        locators : function (data) {
            this.locatorItems = data ? data : [];
        },
        preparedLocators : function (data) {
            this.preparedLocatorItems = data ? data : [];
            this.activatedLocatorLength = (this.getActivatedLocators(this.sheetActiveStatuses, this.preparedLocatorItems)).length;
        },
        samples : function (data) {
            this.sampleItems = data ? data : [];
        },
        inputSamples : function (data) {
            this.inputSampleItems = data ? data : [];
        },
        comparedInputSamples : function (data) {
            this.cisItems = data ? data : [];
            this.isAllowConfirmUpload = data ? (data.filter(item => item.selected)).length > 0 : false;
        },
        
    },

    data() {
        return {
            isLoading: false,
            width: this.modalWidth,
            sheetItems: this.sheets ? this.sheets : [],
            activatedLocatorLength: (this.getActivatedLocators([], [])).length,
            sheetActiveStatuses: this.sheets ? this.sheets.map((item, index) => {
                return {
                    sheet_index: index,
                    sheet_name: item,
                    active: index === 0 ? true : false,
                }
            }) : [],
            sampleDateItems: this.sampleDates ? this.sampleDates.map(item => {
                return {
                    ...item,
                    all_selected: true,
                }
            }) : [],
            locatorItems: this.locators ? this.locators : [],
            preparedLocatorItems: this.preparedLocators ? this.preparedLocators : [],
            sampleItems: this.samples ? this.samples : [],
            inputSampleItems: this.inputSamples ? this.inputSamples : [],
            cisItems: this.comparedInputSamples ? this.comparedInputSamples : [],
            isAllowConfirmUpload: this.comparedInputSamples ? (this.comparedInputSamples.filter(item => item.selected)).length > 0 : false,
        };
    },

    created() {

        this.handleResize();

    },

    mounted() {

        this.activatedLocatorLength = (this.getActivatedLocators(this.sheetActiveStatuses, this.preparedLocatorItems)).length;

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

        toggleSheet(sheetIndex) {

            this.sheetActiveStatuses = this.sheetItems.map((item, index) => {
                return {
                    sheet_index: index,
                    sheet_name: item,
                    active: index === sheetIndex ? true : false,
                }
            });

            this.activatedLocatorLength = (this.getActivatedLocators(this.sheetActiveStatuses, this.preparedLocatorItems)).length;

            this.sampleDateItems = this.sampleDateItems.map(item => {
                return {
                    ...item,
                    all_selected: true,
                }
            });

        },

        isLocatorShow(locatorId) {

            let result = false;

            const foundLocator = this.preparedLocatorItems.find(locItem => locItem.locator_id === locatorId);
            if(foundLocator) {
                const foundActiveStatus = this.sheetActiveStatuses.find(item => item.sheet_index === foundLocator.sheet_index);
                result = foundActiveStatus ? foundActiveStatus.active : false;
            }

            return result;

        },

        getActivatedLocators(sheetActiveStatuses, preparedLocatorItems) {

            let activatedLocators = [];
            const activatedSheet = sheetActiveStatuses.find(item => item.active === true);
            if(activatedSheet) {
                activatedLocators = preparedLocatorItems.filter(locItem => locItem.sheet_index == activatedSheet.sheet_index);
            }
            return activatedLocators;

        },

        onToggleSelectAll($event, sampleDate){

            const checkedValue = sampleDate.all_selected;
            const foundActiveSheet = this.sheetActiveStatuses.find(item => item.active === true);
            const activeSheetIndex = foundActiveSheet.sheet_index;

            this.cisItems = this.cisItems.map(item => {
                let selected = item.selected;
                if(item.sample_date_formatted == sampleDate.sample_date_formatted && item.sheet_index == activeSheetIndex && (item.is_new_sample || item.result_value_has_changed)) {
                    console.log("found item : ", item);
                    selected = checkedValue;
                }
                return {
                    ...item,
                    selected: selected,
                }
            });
        },

        onSampleItemHasChanged(e) {

            this.isAllowConfirmUpload = this.comparedInputSamples ? (this.comparedInputSamples.filter(item => item.selected)).length > 0 : false;

        },

        onConfirmUpload(e) {

            const selectedSamples = this.cisItems.filter(item => item.selected);

            this.$emit("onSampleResultSubmitted", {
                input_samples: selectedSamples,
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
