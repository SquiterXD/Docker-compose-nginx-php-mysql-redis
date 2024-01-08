<template>

    <div class="row">

        <div class="offset-md-2 col-md-8">

            <div class="row form-group">

                <label class="col-md-4 col-form-label required">  กลุ่มงาน </label>
                <div class="col-md-8">
                    <qm-el-select name="qm_group" id="input_qm_group" placeholder="เลือก กลุ่มงาน" 
                        option-key="qm_group_value" option-value="qm_group_value" option-label="qm_group_label"
                        :select-options="qmGroupOptions" :value="qmGroup" @onSelected="onQmGroupWasSelected" 
                        :filterable="true" />
                </div>

            </div>

            <div class="row form-group">
            
                <label class="col-md-4 col-form-label required"> จุดตรวจสอบ</label>
                <div class="col-md-8">
                    <qm-el-select name="locator_id" id="input_locator_id" placeholder="เลือก จุดตรวจสอบ" option-key="inventory_location_id"
                        option-value="inventory_location_id" option-label="location_full_desc"
                        :select-options="locatorOptions" :value="locator" @onSelected="onLocatorWasSelected" 
                        :filterable="true" />
                </div>

            </div>

            <div class="row form-group">

                <label class="col-md-4 col-form-label required">วัน/เวลา ที่เก็บตัวอย่าง</label>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-8">
                            <qm-datepicker-th @dateWasSelected="onSampleDateChanged" class="form-control md:tw-mb-0 tw-mb-2" name="sample_date" id="input_sample_date" placeholder="โปรดเลือกวันที่เก็บตัวอย่าง" :value="sampleDate"  />
                        </div>
                        <div class="col-md-4">
                            <qm-timepicker @change="onSampleTimeChanged" name="sample_time" id="input_sample_time" :value="sampleTime" />
                            <input type="hidden" name="sample_time_meridiem" v-model="sampleTimeMeridiem">
                        </div>
                    </div>
                </div>
                
            </div>

            <div class="row">

                <div class="offset-md-4 col-md-4">

                    <qm-input-group-repeat 
                        :repeat-flag-value="repeatFlag"
                        :repeat-time-hour-value="repeatTimeHour"
                        :repeat-time-min-value="repeatTimeMin"
                        :repeat-qty-value="repeatQty" >
                    </qm-input-group-repeat>

                </div>

            </div>

            <div class="row">

                <div class="col-12">

                    <div class="ibox">
                        <div class="ibox-content tw-pl-4 tw-p-2">
                            <div class="form-check tw-my-2" style="font-size: 1rem;">
                                <input class="form-check-input" type="radio" name="opt_selection_type" value="CHECKLIST" v-model="optSelectionType" @change="onOptSelectionTypeChanged($event)" id="opt_selection_checklist">
                                <label class="form-check-label" for="opt_selection_type1">
                                    ค้นหาและเลือกรายการตราชุด
                                </label>
                            </div>
                            <div class="form-check tw-my-2" style="font-size: 1rem;">
                                <input class="form-check-input" type="radio" name="opt_selection_type" value="AUTO" v-model="optSelectionType" @change="onOptSelectionTypeChanged($event)" id="opt_selection_auto">
                                <label class="form-check-label" for="opt_selection_type2">
                                    ระบบระบุตราชุดให้
                                </label>
                            </div>
                            <div class="form-check tw-my-2" style="font-size: 1rem;">
                                <input class="form-check-input" type="radio" name="opt_selection_type" value="SELECT" v-model="optSelectionType" @change="onOptSelectionTypeChanged($event)" id="opt_selection_select">
                                <label class="form-check-label" for="opt_selection_type3">
                                    กำหนดตราชุด
                                </label>
                            </div>
                            <div>
                                <input type="hidden" name="qm_group_type" v-model="qmGroupType">
                            </div>
                            <!-- <div class="form-group">
                                <div v-if="optSelectionType == 'SELECT'">
                                    <qm-el-select name="selected_opt" id="input_selected_opt" placeholder="เลือก ตรา/ชุด" option-key="opt_desc"
                                        option-value="opt_desc" option-label="opt_desc"
                                        :select-options="selectingBatchItems" :value="selectedOpt" @onSelected="onSelectedOptWasSelected" 
                                        :filterable="true" />
                                </div>
                                <div v-else>
                                    <input type="text" class="form-control" placeholder="เลือก ตรา/ชุด" disabled>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">

            <div class="tw-w-full"> 
                <div class="row tw-mb-1">
                    <div v-bind:class="[ (optSelectionType == 'SELECT' && locator && moisturePoints.length <= 0) ? 'col-md-8 tw-pr-1' : 'col-md-12']">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-sm btn-outline btn-white tw-w-full"
                                    :disabled="!qmGroup || !sampleDate || !sampleTime || (optSelectionType != 'CHECKLIST' && optSelectionType != 'SELECT')"
                                    @click="onGetBatchItems()">
                                    <i class="fa fa-search"></i> ค้นหา
                                </button>
                            </div>
                            <input type="text" class="form-control input-sm" name="search_batch_keyword"
                                v-model="searchBatchKeyword" 
                                v-on:keydown.enter.prevent='onGetBatchItems'
                                :disabled="!qmGroup || !sampleDate || !sampleTime || (optSelectionType != 'CHECKLIST' && optSelectionType != 'SELECT')" 
                                placeholder="ค้นหาจาก ตราชุด, หัววัดความชื้น ">
                        </div>
                    </div>
                    <div v-bind:class="[ (optSelectionType == 'SELECT' && locator && moisturePoints.length <= 0) ? 'col-md-4 tw-pl-1' : 'tw-hidden']">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="tw-my-1 tw-px-2"> ย้อนหลัง </span>
                            </div>
                            <input type="number" class="form-control input-sm" name="search_batch_back_in_days" min="0" oninput="this.value = Math.abs(this.value)"
                                v-model="searchBatchBackInDays" 
                                v-on:keydown.enter.prevent='onGetBatchItems'
                                :disabled="!qmGroup || !sampleDate || !sampleTime || (optSelectionType != 'CHECKLIST' && optSelectionType != 'SELECT')" 
                                placeholder="ค้นหาจาก ตราชุด, หัววัดความชื้น ">
                            <input type="hidden" name="blend_date_from" v-model="searchBlendDateFrom" moment >
                            <div class="input-group-append">
                                <span class="input-group-addon tw-px-2"> วัน </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="optSelectionType == 'CHECKLIST'" class="row">
                    <div class="col-md-6">
                        <label class="col-form-label tw-w-full"> เลือกรายการตราชุดยาเส้น </label>
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label tw-w-full text-right"> จำนวน {{ selectedOpts ? selectedOpts.length : "-" }} รายการ </label>
                    </div>
                </div>
                
            </div>

            <div class="table-responsive" style="max-height: 480px;">

                <table class="table table-bordered" style="min-width: 650px;">

                    <thead>
                        <tr>
                            <th width="5%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 text-center">
                                
                            </th>
                            <th v-if="!(optSelectionType == 'SELECT' && locator && moisturePoints.length <= 0)" width="20%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 text-center">
                                จุดตรวจสอบ
                            </th>
                            <th width="10%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 text-center">
                                ตราชุด
                            </th>
                            <th width="10%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 text-center md:tw-table-cell tw-hidden">
                                วันที่
                            </th>
                            <th width="5%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 text-center md:tw-table-cell tw-hidden">
                                รอบ
                            </th>
                            <th width="8%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 text-center md:tw-table-cell tw-hidden">
                                เริ่มเวลา
                            </th>
                            <th width="12%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 text-center md:tw-table-cell tw-hidden">
                                กลุ่มงาน
                            </th>
                            <th v-if="!(optSelectionType == 'SELECT' && locator && moisturePoints.length <= 0)" width="12%" style="z-index: auto;" class="tw-text-gray-600 tw-bg-opacity-40 text-center md:tw-table-cell tw-hidden">
                                หัววัดความชื้น
                            </th>
                        </tr>
                    </thead>
                    <tbody v-if="batchItems.length > 0">
                        <template v-for="(batchItem, index) in batchItems">
                            <tr :key="index">

                                <td class="tw-text-gray-600 tw-bg-opacity-40 text-center">

                                    <div v-if="optSelectionType == 'CHECKLIST'" class="form-check tw-pl-0">
                                        <input class="tw-mt-1" type="checkbox" :name="`opts[]`" :value="batchItem.opt_id" v-model="batchItem.selected" @change="onOptChecked">
                                    </div>
                                    <div v-if="optSelectionType == 'SELECT'" class="form-check tw-pl-0">
                                        <input class="tw-mt-1" type="radio" name="selected_opt" id="input_selected_opt" :value="batchItem.opt_id" v-model="selectedOpt" @change="onSelectedOptWasSelected()">
                                    </div>
                                        
                                </td>
                                <td v-if="!(optSelectionType == 'SELECT' && locator && moisturePoints.length <= 0)" class="tw-text-gray-600 tw-bg-opacity-40">
                                    {{ batchItem.locator_desc }}
                                </td>
                                <td class="tw-text-gray-600 tw-bg-opacity-40 text-center">
                                    {{ batchItem.opt_desc }}
                                </td>
                                <td class="tw-text-gray-600 tw-bg-opacity-40 text-center md:tw-table-cell tw-hidden">
                                    {{ batchItem.blend_date_formatted }}
                                </td>
                                <td class="tw-text-gray-600 tw-bg-opacity-40 text-center md:tw-table-cell tw-hidden">
                                    {{ batchItem.blend_meridiem }}
                                </td>
                                <td class="tw-text-gray-600 tw-bg-opacity-40 text-center md:tw-table-cell tw-hidden">
                                    {{ batchItem.blend_time }}
                                </td>
                                <td class="tw-text-gray-600 tw-bg-opacity-40 text-center md:tw-table-cell tw-hidden">
                                    {{ qmGroup }}
                                </td>
                                <td v-if="!(optSelectionType == 'SELECT' && locator && moisturePoints.length <= 0)" class="tw-text-gray-600 tw-bg-opacity-40 text-center md:tw-table-cell tw-hidden">
                                    {{ batchItem.moisture_point }}
                                </td>
                            </tr>
                        </template>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="8">
                                <h2 class="p-5 text-center text-muted"> ไม่พบข้อมูล </h2>
                            </td>
                        </tr>
                    </tbody>

                </table>

            </div>

        </div>

        <hr>

        <div class="offset-md-1 col-md-10 text-right">

            <div class="justify-content-center clearfix tw-py-4">

                <button v-show="!formDisabled" class="btn btn-md btn-success" @click="onSubmit" type="submit"> <i class="fa fa-plus"></i> สร้างเลขที่การตรวจสอบ </button>
                <button v-show="formDisabled" class="btn btn-md btn-success" type="button" disabled> <i class="fa fa-plus"></i> สร้างเลขที่การตรวจสอบ </button>
                
                <button class="btn btn-md btn-danger tw-ml-4" @click="onCancel" type="button">
                    <i class="fa fa-times"></i> ยกเลิก
                </button>
                
            </div>

        </div>

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

    </div>

</template>

<script>

import moment from "moment";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";

export default {

    props: [
        "sampleDateValue",
        "sampleTimeValue",
        "repeatFlag",
        "repeatTimeHour",
        "repeatTimeMin",
        "repeatQty",
        "qmGroups",
        "processQmGroups",
        "siloQmGroups",
        "locators",
        "qmGroupValue",
        "qmGroupTypeValue",
        "locatorValue",
        "optSelectionTypeValue",
        "selectedOptValue"
    ],

    components: { Loading },

    data() {
        return {
            sampleDate: this.sampleDateValue ? moment(this.sampleDateValue, "DD/MM/YYYY").toDate() : "",
            sampleTime: this.sampleTimeValue,
            sampleTimeMeridiem: this.getSampleTimeMeridiem(this.sampleTimeValue),
            qmGroup: this.qmGroupValue,
            qmGroupType: this.qmGroupTypeValue,
            locator: this.locatorValue,
            optSelectionType: this.optSelectionTypeValue ? this.optSelectionTypeValue : "CHECKLIST",
            searchBatchKeyword: "",
            searchBatchBackInDays: 7,
            searchBlendDateFrom: this.sampleDateValue ? moment(this.sampleDateValue, "DD/MM/YYYY").subtract(7, 'days').format('DD/MM/YYYY') : "",
            opts: [],
            selectedOpts: [],
            selectedOpt: this.selectedOptValue,
            qmGroupOptions: this.qmGroups,
            locatorOptions: this.getLocatorOptionsInQmGroup(this.optSelectionTypeValue, this.qmGroupValue),
            moisturePoints: this.getMoisturePoints(this.locators, this.qmGroupValue, this.locatorValue),
            batchItems: [],
            isLoading: false,
            formDisabled: false,
        };
    },

    mounted() {

        this.isLoading = false;

    },

    watch:{
        searchBatchBackInDays : async function (value, oldValue) {
            if(value > 0 && this.sampleDate) {
                this.searchBlendDateFrom = moment(this.sampleDate).subtract(value, 'days').format('DD/MM/YYYY');
            } else {
                this.searchBlendDateFrom = this.sampleDate;
            }
        },
    },

    methods: {

        getLocatorOptionsInQmGroup(optSelectionTypeValue, qmGroupValue) {

            let options = [];

            if(qmGroupValue == "ALL") {
                options = [{
                    "inventory_location_id": "ALL", 
                    "location_full_desc": "เลือกทั้งหมด"
                }];
            } else {
                if(optSelectionTypeValue == "CHECKLIST") {
                    options = [
                        { 
                            "inventory_location_id": "ALL", 
                            "location_full_desc": "เลือกทั้งหมด"
                        },
                        ...this.locators.filter(item => item.qm_group == qmGroupValue)
                    ];
                } else {
                    options = [
                        ...this.locators.filter(item => item.qm_group == qmGroupValue)
                    ];
                }
            }

            return options;

        },

        getLocatorDescByMoisturePoint(locators, moisturePoint) {
            let result = "";
            if(moisturePoint){
                const foundLocator = locators.find(item => item.moisture_point == moisturePoint);
                result = foundLocator ? foundLocator.locator_desc : "";
            }
            return result;
        },

        getOptDesc(batchId) {
            let result = batchId;
            const arrBatchId = batchId.split("_");
            if(arrBatchId.length > 1){
                result = arrBatchId[1];
            }
            return result;
        },

        onSampleDateChanged(value) {

            this.sampleDate = value;

            if(this.searchBatchBackInDays > 0 && this.sampleDate) {
                this.searchBlendDateFrom = moment(this.sampleDate).subtract(this.searchBatchBackInDays, 'days').format('DD/MM/YYYY');
            } else {
                this.searchBlendDateFrom = this.sampleDate;
            }

            this.batchItems = [];
            this.selectedOpts = this.batchItems.filter(item => item.selected);
            this.selectedOpt = null;
            this.selectedOpts = this.batchItems.filter(item => item.selected);

        },

        onSampleTimeChanged(value) {

            this.sampleTime = value;
            this.sampleTimeMeridiem = this.getSampleTimeMeridiem(this.sampleTime);

            this.batchItems = [];
            this.selectedOpts = this.batchItems.filter(item => item.selected);
            this.selectedOpt = null;
            this.selectedOpts = this.batchItems.filter(item => item.selected);

        },

        onQmGroupWasSelected(value) {

            this.qmGroup = value;
            this.qmGroupType = this.getQmGroupType(value);
            this.locatorOptions = this.getLocatorOptionsInQmGroup(this.optSelectionType, value);
            this.locator = this.locatorOptions.length > 0 ? this.locatorOptions[0].inventory_location_id : ""; // default value

            this.batchItems = [];
            this.selectedOpts = this.batchItems.filter(item => item.selected);
            this.moisturePoints = this.getMoisturePoints(this.locators, this.qmGroup, this.locator);
            this.selectedOpt = null;
            this.selectedOpts = this.batchItems.filter(item => item.selected);

        },

        async onLocatorWasSelected(value) {

            this.locator = value;
            this.moisturePoints = this.getMoisturePoints(this.locators, this.qmGroup, this.locator);
            this.batchItems = await this.getBatchItems(this.qmGroup, this.qmGroupType, this.sampleDate, this.sampleTime, this.locator, this.searchBatchKeyword);
            this.selectedOpt = null;
            this.selectedOpts = this.batchItems.filter(item => item.selected);

        },

        getQmGroupType(qmGroup) {

            let result = "";
            const foundProcessQmGroup = this.processQmGroups.find(item => item.qm_group_value == qmGroup);
            const foundSiloQmGroup = this.siloQmGroups.find(item => item.qm_group_value == qmGroup);
            if(foundProcessQmGroup){ result = "PROCESS" };
            if(foundSiloQmGroup){ result = "SILO" };

            return result;

        },

        getMoisturePoints(locators, qmGroup, locator) {
            
            let result = locators.filter(item => !!item.moisture_point).map(item => item.moisture_point);

            if(qmGroup) {

                if(qmGroup != "ALL") {

                    result = locators.filter(item => !!item.moisture_point).filter(item => {
                        return item.qm_group == qmGroup;
                    }).map(item => item.moisture_point);

                    if(qmGroup && locator) {
                        if(locator != "ALL") {
                            result = locators.filter(item => !!item.moisture_point).filter(item => {
                                return item.qm_group == qmGroup && item.inventory_location_id == locator;
                            }).map(item => item.moisture_point);
                        }
                    }

                }

            }

            return result;

        },

        async onGetBatchItems() { 
            
            this.moisturePoints = this.getMoisturePoints(this.locators, this.qmGroup, this.locator);

            this.batchItems = [];
            this.batchItems = await this.getBatchItems(this.qmGroup, this.qmGroupType, this.sampleDate, this.sampleTime, this.locator, this.searchBatchKeyword);
            
            this.selectedOpt = null;
            this.selectedOpts = this.batchItems.filter(item => item.selected);

        },

        async getBatchItems(qmGroup, qmGroupType, sampleDate, sampleTime, locatorId, searchBatchKeyword) {

            let result = [];

            if(qmGroup, qmGroupType, sampleDate, sampleTime) {
            
                const formattedSampleDate = moment(sampleDate).format('DD/MM/YYYY');
                const sampleTimeMeridiem = this.getSampleTimeMeridiem(sampleTime);

                if((this.optSelectionType == "CHECKLIST" || this.optSelectionType == "SELECT")) {

                    var params = {
                        opt_selection_type: this.optSelectionType,
                        sample_date: formattedSampleDate,
                        sample_time: sampleTime,
                        sample_time_meridiem: sampleTimeMeridiem,
                        qm_group: qmGroup,
                        qm_group_type: qmGroupType,
                        locator_id: locatorId != "ALL" ? locatorId : null,
                        search_batch_keyword: searchBatchKeyword,
                        blend_date_from: this.searchBlendDateFrom,
                    };

                    // SHOW LOADING
                    this.isLoading = true;
                    
                    const resBatchItems = await axios.get("/qm/ajax/tobaccos/get-batch-items", { params }).then(res => {
                        const resData = res.data.data;
                        const resMsg = resData.message;
                        if(resData.status == "success") {
                            return resData.batch_items ? JSON.parse(resData.batch_items) : [];
                        } else {
                            // HIDE LOADING
                            this.isLoading = false;
                            swal("Error", `${resMsg}`, "error");
                            return [];
                        }
                    });

                    let preparedBatchItems = resBatchItems.map(item => {
                        return {
                            ...item,
                            locator_desc: this.getLocatorDescByMoisturePoint(this.locators, item.moisture_point),
                            opt_desc: this.getOptDesc(item.batch_id),
                            blend_date_formatted: moment(item.blend_date).add(543, 'years').format('DD/MM/YYYY'),
                            blend_time: moment(item.blend_date).format('HH:mm'),
                            blend_meridiem: moment(item.blend_date).format('A'),
                            selected: false,
                        }
                    });

                    if(searchBatchKeyword) {
                        // FILTER BY SEARCH KEYWORD
                        preparedBatchItems = preparedBatchItems.filter(item => {
                            return item.batch_id.includes(searchBatchKeyword) || item.moisture_point.includes(searchBatchKeyword)
                        });
                    }
                    
                    // result = preparedBatchItems.sort((a, b) => {
                    //     return a.blend_date_formatted == b.blend_date_formatted ? ((a.blend_time > b.blend_time) ? 1 : -1) : ((a.blend_date_formatted > b.blend_date_formatted) ? -1 : 1);
                    // });
                    result = preparedBatchItems;

                    // HIDE LOADING
                    this.isLoading = false;

                }

            }

            return result;

        },

        onOptSelectionTypeChanged(e) {
            this.locatorOptions = this.getLocatorOptionsInQmGroup(this.optSelectionType, this.qmGroup);
            if(this.locatorOptions.length > 0) {
                const foundLocatorInList = this.locatorOptions.find(item => item.inventory_location_id == this.locator);
                if(!foundLocatorInList) {
                    this.locator = this.locatorOptions[0].inventory_location_id;
                }
            } else { this.locator = ""; }
            this.batchItems = [];
            this.searchBatchKeyword = "";
            this.selectedOpt = null;
            this.selectedOpts = this.batchItems.filter(item => item.selected);
        },

        onOptChecked(e) {
            this.selectedOpt = null;
            this.selectedOpts = this.batchItems.filter(item => item.selected);
        },

        onSelectedOptWasSelected(value) {
            console.log("this.selectedOpt : ", this.selectedOpt)
        },

        getSampleTimeMeridiem(sampleTime) {
            let result = "";
            if(sampleTime) {
                result = moment(`2022-01-01 ${sampleTime}:01`).format('A')
            }
            return result;
        },

        onSubmit(){
            this.isLoading = true;
            this.formDisabled = true;
        },

        onCancel(){
            location.reload();
        }

    }
};
</script>
