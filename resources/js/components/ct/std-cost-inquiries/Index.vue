<template>

    <div class="ibox">

        <div class="ibox-content tw-pt-10" style="min-height: 600px;">

            <div class="row">

                <div class="col-md-6">

                    <div class="row form-group">

                        <label class="col-md-4 col-form-label tw-font-bold tw-pt-0 required"> ปีบัญชีงบประมาณ </label>

                        <div class="col-md-8">

                            <pm-el-select name="period_year" id="input_period_year" 
                                :select-options="periodYears"
                                option-key="period_year_value"
                                option-value="period_year_value" 
                                option-label="period_year_label" 
                                :value="periodYear"
                                :filterable="true"
                                :clearable="true"
                                @onSelected="onPeriodYearChanged"
                            />

                        </div>

                    </div>

                </div>

                <div class="col-md-6">

                    <div class="row form-group">

                        <label class="col-md-4 col-form-label tw-font-bold tw-pt-0 required"> ครั้งที่ </label>

                        <div class="col-md-8">

                            <pm-el-select name="version_no" id="input_version_no" 
                                :select-options="versionNoOptions"
                                option-key="version_no"
                                option-value="version_no" 
                                option-label="version_no" 
                                :value="versionNo"
                                :filterable="true"
                                :clearable="true"
                                @onSelected="onVersionNoChanged"
                            />

                        </div>

                    </div> 

                </div>

            </div>

            <div class="row">

                <div class="col-md-6">
                    <div class="row form-group">
                        <label class="col-md-4 col-form-label tw-font-bold tw-pt-0 required"> ศูนย์ต้นทุน </label>
                        <div class="col-md-8">
                            <pm-el-select name="cost_code" id="input_cost_code" 
                                :select-options="costCodeOptions"
                                option-key="cost_code_value"
                                option-value="cost_code_value" 
                                option-label="cost_code_label" 
                                :value="costCode"
                                :filterable="true"
                                :clearable="true"
                                @onSelected="onCostCodeChanged"
                            />
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="row form-group">
                        <label class="col-md-4 col-form-label tw-font-bold tw-pt-0"> ผลิตภัณฑ์ </label>
                        <div class="col-md-8">
                            
                            <pm-el-select name="inventory_item_id" id="input_inventory_item_id" 
                                :select-options="inventoryItemOptions"
                                option-key="inventory_item_value"
                                option-value="inventory_item_value" 
                                option-label="inventory_item_label" 
                                :value="inventoryItemId"
                                :filterable="true"
                                :clearable="true"
                                @onSelected="onInventoryItemIdChanged"
                            />

                        </div>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-md-6">
                    <div class="row form-group">
                        <label class="col-md-4 col-form-label tw-font-bold tw-pt-0"> สถานะราคา </label>
                        <div class="col-md-8">
                            <pm-el-select name="status_cost" id="input_status_cost" 
                                :select-options="statusCosts"
                                option-key="value"
                                option-value="value" 
                                option-label="label" 
                                :value="statusCost"
                                :filterable="true"
                                :clearable="true"
                                @onSelected="onStatusCostChanged"
                            />
                        </div>
                    </div>
                </div>

            </div>

            <div class="text-right">

                <button class="btn btn-inline-block btn-white tw-w-52"
                    :disabled="!periodYear || !costCode || !versionNo"
                    @click="onGetStdCostInquiries(periodYear, costCode, versionNo, inventoryItemId, statusCost)">
                    <i class="fa fa-search"></i> ค้นหา
                </button>

                <a :href="'/ct/std-cost-inquiries'" class="btn btn-inline-block btn-danger tw-w-32"> <i class="fa fa-times"></i> ล้าง </a>

            </div> 

            <hr>

            <div v-if="showTableStdCostInquiries" class="row tw-mb-5">

                <div class="col-12">

                    <table-std-cost-inquiries 
                        :period-year-value="periodYear"
                        :std-cost-inquiries="stdCostInquiries" 
                    >
                    </table-std-cost-inquiries>

                </div>

            </div>
            
        </div>

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

    </div>

</template>

<script>

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import moment from 'moment';

import TableStdCostInquiries from "./TableStdCostInquiries";

export default {
    
    components: { Loading, TableStdCostInquiries },

    props: [ 
        "defaultData", 
        "periodYearValue", 
        "costCodeValue", 
        "versionNoValue", 
        "inventoryItemIdValue", 
        "statusCostValue", 
        "periodYears", 
        "versionNos", 
        "costCodes", 
        "inventoryItems",
        "statusCosts",
    ],

    mounted() {

        if(this.periodYearValue) {

            this.getListCostCodes(this.periodYearValue).then((value) => {

                if(this.costCodeValue) {
                    this.costCode = this.costCodeValue;
                    this.costCodeLabel = this.getCostCodeLabel(this.costCodeOptions, this.costCode);
                }

            });

            this.getListVersions(this.periodYearValue);
            
            this.getListInventoryItems(this.periodYearValue).then((value) => {

                if(this.inventoryItemIdValue) {
                    this.inventoryItemId = this.inventoryItemIdValue;
                    this.inventoryItemIdLabel = this.getInventoryItemLabel(this.inventoryItemOptions, this.inventoryItemId);
                }

            });

        }

        if(this.statusCostValue) {
            this.statusCost = this.statusCostValue;
            this.statusCostLabel = this.getStatusCostLabel(this.statusCosts, this.statusCost);
        }

    },

    data() {
        return {

            organizationId: this.defaultData ? JSON.parse(this.defaultData).organization_id : null,
            organizationCode: this.defaultData ? JSON.parse(this.defaultData).organization_code : null,
            department: this.defaultData ? JSON.parse(this.defaultData).department : null,
            
            periodYear: this.periodYearValue,
            periodYearLabel: this.getPeriodYearLabel(this.periodYears, this.periodYearValue),

            versionNoOptions: this.versionNos,
            versionNo: this.versionNoValue,

            costCodeOptions: this.costCodes,
            costCode: this.costCodeValue,
            costCodeLabel: this.getCostCodeLabel(this.costCodes, this.costCodeValue),

            inventoryItemOptions: this.inventoryItems,
            inventoryItemId: this.inventoryItemIdValue,
            inventoryItemIdLabel: this.getInventoryItemLabel(this.inventoryItems, this.inventoryItemIdValue),

            statusCost: this.statusCostValue,
            statusCostLabel: this.getStatusCostLabel(this.statusCosts, this.statusCostValue),

            stdCostInquiries: [],
            
            showTableStdCostInquiries: false,
            isLoading: false,
        }
    },

    computed: {

    },

    methods: {

        setUrlParams() {

            var queryParams = new URLSearchParams(window.location.search);
            queryParams.set("period_year", this.periodYear ? this.periodYear : '');
            queryParams.set("cost_code", this.costCode ? this.costCode : '');
            queryParams.set("version_no", this.versionNo ? this.versionNo : '');
            queryParams.set("inventory_item_id", this.inventoryItemId ? this.inventoryItemId : '');
            queryParams.set("status_cost", this.statusCost ? this.statusCost : '');
            window.history.replaceState(null, null, "?"+queryParams.toString());

        },

        async onPeriodYearChanged(value) {
            
            this.periodYear = value;
            this.periodYearLabel = this.getPeriodYearLabel(this.periodYears, this.periodYear);
            this.setUrlParams();

            // REFRESH DATA
            this.stdCostInquiries = [];

            // REFRESH DATA
            this.versionNo = null;
            this.costCode = null;
            this.inventoryItemId = null;
            this.statusCost = null;

            this.getListVersions(this.periodYear); 
            this.getListCostCodes(this.periodYear); 
            this.getListInventoryItems(this.periodYear); 
            await this.getAllocateAccounts(this.periodYear); 
            
            this.showTableStdCostInquiries = false;
            
        },

        async onCostCodeChanged(value) {

            this.costCode = value;

            // // REFRESH DATA
            // this.stdCostInquiries = [];
            // this.showTableStdCostInquiries = false;
            
            this.setUrlParams();

        },

        async onVersionNoChanged(value) {

            this.versionNo = value;
            
            // // REFRESH DATA
            // this.stdCostInquiries = [];
            // this.showTableStdCostInquiries = false;
            
            this.setUrlParams();

        },

        async onInventoryItemIdChanged(value) {
            
            this.inventoryItemId = value;
            this.inventoryItemIdLabel = this.getInventoryItemLabel(this.inventoryItems, this.inventoryItemId);
            
            // // REFRESH DATA
            // this.stdCostInquiries = [];
            // this.showTableStdCostInquiries = false;

            this.setUrlParams();

        },

        async onStatusCostChanged(value) {
            
            this.statusCost = value;
            this.statusCostLabel = this.getStatusCostLabel(this.statusCosts, this.statusCost);

            // // REFRESH DATA
            // this.stdCostInquiries = [];
            // this.showTableStdCostInquiries = false;

            this.setUrlParams();

        },

        getPeriodYearLabel(periodYears, periodYear) {
            let result = null;
            if(periodYear) {
                const foundPeriodYear = periodYears.find(item => item.period_year_value == periodYear);
                result = foundPeriodYear ? foundPeriodYear.period_year_label : "";
            }
            return result;
        },

        getCostCodeLabel(costCodes, costCode) {
            let result = null;
            if(costCode) {
                const foundItem = costCodes.find(item => item.cost_code_value == costCode);
                result = foundItem ? foundItem.cost_code_label : "";
            }
            return result;
        },

        getInventoryItemLabel(inventoryItems, inventoryItemId) {
            let result = null;
            if(inventoryItemId) {
                const foundInvItem = inventoryItems.find(item => item.inventory_item_value == inventoryItemId);
                result = foundInvItem ? foundInvItem.inventory_item_label : "";
            }
            return result;
        },

        getStatusCostLabel(statusCosts, statusCost) {
            let result = null;
            if(statusCost) {
                const foundItem = statusCosts.find(item => item.value == statusCost);
                result = foundItem ? foundItem.label : "";
            }
            return result;
        },

        validateBeforeGetStdCostInquiries(periodYear, costCode, versionNo, inventoryItemId, statusCost) {

            let valid = false;
            if(periodYear && costCode && versionNo) {
                valid = true;
            }
            return valid;
        },

        async getListVersions(periodYear) {

            let resultData = null;

            // SHOW LOADING
            this.isLoading = true;
            
            var params = { 
                period_year: periodYear
            };

            if(periodYear) {

                resultData = await axios.get("/ajax/ct/std-cost-inquiries/list-versions", { params })
                .then(res => {
                    const resData = res.data.data;
                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลเวอร์ชั่น | ${resData.message}`, "error");
                    } else {
                        this.versionNoOptions = resData.version_nos ? JSON.parse(resData.version_nos) : [];
                    }
                    return resData;
                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลเวอร์ชั่น | ${error.message}`, "error");
                    return ;
                });

            }

            // HIDE LOADING
            this.isLoading = false;

            return resultData;

        },

        async getListCostCodes(periodYear) {

            let resultData = null;

            // SHOW LOADING
            this.isLoading = true;
            
            var params = { 
                period_year: periodYear
            };

            if(periodYear) {

                resultData = await axios.get("/ajax/ct/std-cost-inquiries/list-cost-codes", { params })
                .then(res => {
                    const resData = res.data.data;
                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลศูนย์ต้นทุน | ${resData.message}`, "error");
                    } else {
                        this.costCodeOptions = resData.cost_codes ? JSON.parse(resData.cost_codes) : [];
                    }
                    return resData;
                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลศูนย์ต้นทุน | ${error.message}`, "error");
                    return ;
                });

            }

            // HIDE LOADING
            this.isLoading = false;

            return resultData;

        },

        async getListInventoryItems(periodYear) {

            let resultData = null;

            // SHOW LOADING
            this.isLoading = true;
            
            var params = { 
                period_year: periodYear
            };

            if(periodYear) {

                resultData = await axios.get("/ajax/ct/std-cost-inquiries/list-inventory-items", { params })
                .then(res => {
                    const resData = res.data.data;
                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลผลิตภัณฑ์ | ${resData.message}`, "error");
                    } else {
                        this.inventoryItemOptions = resData.inventory_items ? JSON.parse(resData.inventory_items) : [];
                    }
                    return resData;
                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลผลิตภัณฑ์ | ${error.message}`, "error");
                    return ;
                });

            }

            // HIDE LOADING
            this.isLoading = false;

            return resultData;

        },

        async onGetStdCostInquiries(periodYear, costCode, versionNo, inventoryItemId, statusCost) {

            let resultData = null;

            // SHOW LOADING
            this.isLoading = true;

            // REFRESH DATA
            this.stdCostInquiries = [];
            
            var params = { 
                period_year: periodYear,
                version_no: versionNo,
                cost_code: costCode,
                inventory_item_id: inventoryItemId,
                status_cost: statusCost,
            };

            const isValid = this.validateBeforeGetStdCostInquiries(periodYear, costCode, versionNo, inventoryItemId, statusCost);
            if(isValid) {

                resultData = await axios.get("/ajax/ct/std-cost-inquiries/get-inquiries", { params })
                .then(res => {
                    const resData = res.data.data;
                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลสอบถามราคาต้นทุนมาตรฐาน INVENTORY | ${resData.message}`, "error");
                    } else {
                        this.stdCostInquiries = resData.std_cost_inquiries ? JSON.parse(resData.std_cost_inquiries) : [];
                    }
                    return resData;
                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลสอบถามราคาต้นทุนมาตรฐาน INVENTORY | ${error.message}`, "error");
                    return ;
                });

                this.showTableStdCostInquiries = true;

            }

            // HIDE LOADING
            this.isLoading = false;

            return resultData;

        },


        getApproveStatusDesc(status) {
            let statusDesc = "-";
            if(status) {
                const foundStatus = this.approveStatuses.find(item => item.lookup_code == status);
                statusDesc = foundStatus ? foundStatus.description : "-"; 
            }
            return statusDesc;
        },

        formatDateTh(date) {
            return date ? moment(date).add(543, 'years').format('DD/MM/YYYY') : ""
        },

    }

}

</script>