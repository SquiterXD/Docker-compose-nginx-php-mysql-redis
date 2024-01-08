<template>

    <div class="ibox">

        <div class="ibox-content tw-pt-10" style="min-height: 600px;">

            <div class="row">

                <div class="col-md-4">

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
                                @onSelected="onPeriodYearChanged"
                            />

                        </div>

                    </div>

                    <div class="row form-group">

                        <label class="col-md-4 col-form-label tw-font-bold tw-pt-0 required"> เกณฑ์การปันส่วนครั้งที่ </label>

                        <div class="col-md-8">

                            <pm-el-select name="allocate_account_version" id="input_allocate_account_version" 
                                :select-options="allocateAccountVersions"
                                option-key="version_no"
                                option-value="version_no" 
                                option-label="version_no" 
                                :value="allocateAccountVersion"
                                :filterable="true"
                                @onSelected="onAllocateAccountVersionChanged"
                            />

                        </div>

                    </div> 

                </div>

                <div class="col-md-8">

                    <div class="row">

                        <div class="col-md-6">
                            <div class="row form-group">
                                <label class="col-md-4 col-form-label tw-font-bold tw-pt-0 required"> แผนการผลิตครั้งที่ </label>
                                <div class="col-md-8">
                                    <pm-el-select name="prdgrp_year_id" id="input_prdgrp_year_id" 
                                        :select-options="prdgrpVersions"
                                        option-key="prdgrp_year_id"
                                        option-value="prdgrp_year_id" 
                                        option-label="plan_version_no" 
                                        :value="prdgrpYearId"
                                        :filterable="true"
                                        @onSelected="onPrdgrpVersionChanged"
                                    />
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="row form-group">
                                <label class="col-md-4 col-form-label tw-font-bold tw-pt-0 required"> เปรียบเทียบค่าใช้จ่ายจริงจาก </label>
                                <div class="col-md-8">
                                    
                                    <pm-el-select name="period_name_from" id="input_period_name_from" 
                                        :select-options="periodNameFroms"
                                        option-key="period_name_value"
                                        option-value="period_name_value" 
                                        option-label="period_name_label" 
                                        :value="periodNameFrom"
                                        :filterable="true"
                                        @onSelected="onPeriodNameFromChanged"
                                    />

                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row form-group">
                                <label class="col-md-4 col-form-label tw-font-bold tw-pt-0 required"> ถึง </label>
                                <div class="col-md-8">
                                    
                                    <pm-el-select name="period_name_to" id="input_period_name_to" 
                                        :select-options="periodNameTos"
                                        option-key="period_name_value"
                                        option-value="period_name_value" 
                                        option-label="period_name_label" 
                                        :value="periodNameTo"
                                        :filterable="true"
                                        @onSelected="onPeriodNameToChanged"
                                    />

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-right">

                <button class="btn btn-inline-block btn-white tw-w-32"
                    @click="$modal.show('modal-search-stdcost')">
                    <i class="fa fa-search tw-mr-1"></i> ค้นหา 
                </button>

                <button class="btn btn-inline-block btn-primary tw-w-52"
                    :disabled="!periodYear || !prdgrpYearId || !allocateAccountVersion || !periodNameFrom || !periodNameTo"
                    @click="onGenerateStdcostYearData(periodYear, prdgrpYearId, allocateAccountVersion, allocateYearId, periodNameFrom, periodNameTo)">
                    <i class="fa fa-arrow-down"></i> ดึงข้อมูลงบทดลอง
                </button>

                <a :href="'/ct/std-costs'" class="btn btn-inline-block btn-danger tw-w-32"> ล้าง </a>

            </div> 

            <hr>

            <div v-if="showTableStdcostAccounts" class="row tw-mb-5">

                <div class="col-12">

                    <table-std-cost-accounts 
                        :period-year-value="periodYear"
                        :plan-version-no-value="planVersionNo"
                        :stdcost-year="stdcostYear"
                        :stdcost-accounts="stdcostAccounts" 
                        :allocate-types="allocateTypes" 
                        :list-allocate-groups="listAllocateGroups"
                        :list-all-allocate-group-codes="listAllAllocateGroupCodes"
                        :list-dept-allocate-group-codes="listDeptAllocateGroupCodes"
                        :list-cost-allocate-group-codes="listCostAllocateGroupCodes"
                        :list-product-allocate-group-codes="listProductAllocateGroupCodes"
                        @onStdcostAccountsChanged="onStdcostAccountsChanged"
                    >
                    </table-std-cost-accounts>

                </div>

            </div>
            
        </div>

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

        <!-- MODAL SEARCH STD COST -->
        <modal-search-stdcost 
            modal-name="modal-search-stdcost" 
            modal-width="1024" 
            modal-height="auto"
            :organization-code="organizationCode"
            :period-years="existPeriodYearOptions"
            :period-year-value="periodYear"
            :list-allocate-groups="listAllocateGroups"
            @onSearchStdcostVersion="onSearchStdcostVersion"
        >
        </modal-search-stdcost>

    </div>

</template>

<script>

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import moment from 'moment';

import TableStdCostAccounts from "./TableStdCostAccounts";
import ModalSearchStdcost from "./ModalSearchStdcost";

export default {
    
    components: { Loading, TableStdCostAccounts, ModalSearchStdcost },

    props: [ "defaultData", "periodYearValue", "prdgrpYearIdValue", "allocateAccountVersionValue", "allocateYearIdValue", "allocateGroupValue", "periodNameFromValue", "periodNameToValue", "periodYears", "existPeriodYears", "listAllocateGroups", "allocateTypes" ],

    mounted() {

        if(this.periodYearValue) {
            
            this.getListPeriods(this.periodYearValue).then((value) => {

                if(this.periodNameFromValue) {
                    this.periodNameFrom = this.periodNameFromValue;
                    this.periodNameFromLabel = this.getPeriodNameLabel(this.periodNameFroms, this.periodNameFrom);
                }

                if(this.periodNameToValue) {
                    this.periodNameTo = this.periodNameToValue;
                    this.periodNameToLabel = this.getPeriodNameLabel(this.periodNameTos, this.periodNameTo);
                }

            });

            this.getListPrdgrps(this.periodYearValue).then((value) => {
                this.planVersionNo = this.getPrdgrpPlanVersionNo(this.prdgrpVersions, this.prdgrpYearIdValue);
            });
            
            this.getAllocateAccounts(this.periodYearValue).then((value) => {
                if(this.allocateAccountVersionValue) {
                    const foundAlcAccVersion = this.allocateAccountVersions.find(item => item.version_no == this.allocateAccountVersionValue);
                    this.allocateYearId = foundAlcAccVersion ? foundAlcAccVersion.allocate_year_id : null;
                }
            });
            this.getAllocateGroupCodes(this.periodYearValue, this.allocateAccountVersionValue);

        }

    },

    data() {
        return {

            organizationId: this.defaultData ? JSON.parse(this.defaultData).organization_id : null,
            organizationCode: this.defaultData ? JSON.parse(this.defaultData).organization_code : null,
            department: this.defaultData ? JSON.parse(this.defaultData).department : null,
            
            periodYear: this.periodYearValue,
            periodYearLabel: this.getPeriodYearLabel(this.periodYears, this.periodYearValue),

            existPeriodYearOptions: this.existPeriodYears,
            
            periodNameFroms: [],
            periodNameFrom: this.periodNameFromValue,
            periodNameFromLabel: null,
            periodNameTos: [],
            periodNameTo: this.periodNameToValue,
            periodNameToLabel: null,

            prdgrpVersions: [],
            prdgrpYearId: this.prdgrpYearIdValue,
            planVersionNo: null,

            allocateAccountVersions: [],
            allocateAccountVersion: this.allocateAccountVersionValue,
            allocateYearId: this.allocateAccountVersionValue,

            // allocateGroup: this.allocateGroupValue ? this.allocateGroupValue : "DEPT",
            // allocateGroupLevel: this.getAllocateGroupLevel(this.listAllocateGroups, this.allocateGroupValue ? this.allocateGroupValue : "DEPT"),
            // allocateGroupLabel: this.getAllocateGroupLabel(this.listAllocateGroups, this.allocateGroupValue ? this.allocateGroupValue : "DEPT"),

            allocateGroupCodes: [],
            
            stdcostYear: null,
            stdcostYearVersion: this.versionValue,
            stdcostYearVersions: [],

            selectedStdcostYearData: {},

            stdcostAccounts: [],

            listAllAllocateGroupCodes: [], 
            listDeptAllocateGroupCodes: [], 
            listCostAllocateGroupCodes: [], 
            listProductAllocateGroupCodes: [],
            
            showTableStdcostAccounts: false,
            isLoading: false,
        }
    },

    computed: {

    },

    methods: {

        setUrlParams() {

            var queryParams = new URLSearchParams(window.location.search);
            queryParams.set("period_year", this.periodYear ? this.periodYear : '');
            queryParams.set("prdgrp_year_id", this.prdgrpYearId ? this.prdgrpYearId : '');
            queryParams.set("allocate_account_version", this.allocateAccountVersion ? this.allocateAccountVersion : '');
            queryParams.set("allocate_year_id", this.allocateYearId ? this.allocateYearId : '');
            queryParams.set("allocate_group", this.allocateGroup ? this.allocateGroup : 'DEPT');
            queryParams.set("period_name_from", this.periodNameFrom ? this.periodNameFrom : '');
            queryParams.set("period_name_to", this.periodNameTo ? this.periodNameTo : '');
            window.history.replaceState(null, null, "?"+queryParams.toString());

        },

        async onPeriodYearChanged(value) {
            
            this.periodYear = value;
            this.periodYearLabel = this.getPeriodYearLabel(this.periodYears, this.periodYear);
            this.setUrlParams();

            // REFRESH DATA
            this.stdcostYear = null;
            this.stdcostAccounts = [];
            this.listAllAllocateGroupCodes = [];
            this.listDeptAllocateGroupCodes = [];
            this.listCostAllocateGroupCodes = [];
            this.listProductAllocateGroupCodes = [];

            // REFRESH DATA
            this.periodNameFrom = null;
            this.periodNameTo = null;
            this.allocateAccountVersion = null;
            this.allocateYearId = null;
            this.prdgrpYearId = null;

            this.getListPeriods(this.periodYear); 
            this.getListPrdgrps(this.periodYear); 
            await this.getAllocateGroupCodes(this.periodYear, this.allocateGroup, this.allocateAccountVersion);
            await this.getAllocateAccounts(this.periodYear); 
            
            this.showTableStdcostAccounts = false;
            
        },

        async onPrdgrpVersionChanged(value) {

            this.prdgrpYearId = value;
            this.planVersionNo = this.getPrdgrpPlanVersionNo(this.prdgrpVersions, this.prdgrpYearId);
            const foundAlcAccVersion = this.allocateAccountVersions.find(item => item.version_no == this.planVersionNo);
            if(foundAlcAccVersion) {
                this.allocateAccountVersion = this.planVersionNo;
            }
            this.stdcostAccounts = [];
            this.listAllAllocateGroupCodes = [];
            this.listDeptAllocateGroupCodes = [];
            this.listCostAllocateGroupCodes = [];
            this.listProductAllocateGroupCodes = [];
            
            this.setUrlParams();

        },

        async onAllocateAccountVersionChanged(value) {

            this.allocateAccountVersion = value;

            this.getAllocateGroupCodes(this.periodYear, this.allocateGroup, this.allocateAccountVersion);

            const foundAlcAccVersion = this.allocateAccountVersions.find(item => item.version_no == value);
            this.allocateYearId = foundAlcAccVersion ? foundAlcAccVersion.allocate_year_id : null;
            
            // REFRESH DATA
            this.stdcostYear = null;
            this.stdcostAccounts = [];
            this.listAllAllocateGroupCodes = [];
            this.listDeptAllocateGroupCodes = [];
            this.listCostAllocateGroupCodes = [];
            this.listProductAllocateGroupCodes = [];

            this.showTableStdcostAccounts = false;
            
            this.setUrlParams();

        },

        async onPeriodNameFromChanged(value) {
            
            this.periodNameFrom = value;
            this.periodNameFromLabel = this.getPeriodNameLabel(this.periodNameFroms, this.periodNameFrom);
            
            const foundPeriodNameFrom = this.periodNameFroms.find(item => item.period_name == this.periodNameFrom);
            this.periodNameTos = this.periodNameFroms.filter(item => {
                return item.period_num >= foundPeriodNameFrom.period_num && item.period_num < 12;
            });
            this.periodNameTo = null;
            this.periodNameToLabel = null;

            this.setUrlParams();

        },

        async onPeriodNameToChanged(value) {
            
            this.periodNameTo = value;
            this.periodNameToLabel = this.getPeriodNameLabel(this.periodNameTos, this.periodNameTo);
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

        getPeriodNameLabel(periodNames, periodName) {
            let result = null;
            if(periodName) {
                const foundPeriodName = periodNames.find(item => item.period_name == periodName);
                result = foundPeriodName ? foundPeriodName.thai_month : "";
            }
            return result;
        },

        getPrdgrpPlanVersionNo(prdgrpVersions, prdgrpYearIdValue) {
            let result = null;
            if(prdgrpYearIdValue){
                const foundPrdgrp = prdgrpVersions.find(item => item.prdgrp_year_id == prdgrpYearIdValue);
                result = foundPrdgrp ? foundPrdgrp.plan_version_no : "";
            }
            return result;
        },

        getAllocateGroupLevel(listAllocateGroups, allocateGroupValue) {
            const foundAllocateGroup = listAllocateGroups.find(item => item.allocate_group == allocateGroupValue);
            return foundAllocateGroup ? foundAllocateGroup.level_no : "";
        },

        getAllocateGroupLabel(listAllocateGroups, allocateGroupValue) {
            const foundAllocateGroup = listAllocateGroups.find(item => item.allocate_group == allocateGroupValue);
            return foundAllocateGroup ? foundAllocateGroup.allocate_group_label : "";
        },

        validateBeforeGetStdcostYear(periodYear, allocateAccountVersion) {

            let valid = false;
            if(periodYear && allocateAccountVersion) {
                valid = true;
            }
            return valid;

        },

        validateBeforeSaveStdcostYear(periodYear, prdgrpYearId, allocateAccountVersion, allocateYearId, periodNameFrom, periodNameTo) {

            let valid = false;
            if(periodYear && prdgrpYearId && allocateAccountVersion && allocateYearId && periodNameFrom && periodNameTo) {
                valid = true;
            }
            return valid;

        },

        validateBeforeGetDeptCodes(periodYear) {

            let valid = false;
            if(periodYear) {
                valid = true;
            }
            return valid;
        },

        validateBeforeGetStdcostAccounts(periodYear, stdcostYear) {

            let valid = false;
            if(periodYear && stdcostYear) {
                valid = true;
            }
            return valid;
        },

        validateBeforeGenerateAccountTargets(periodYear, stdcostYear) {

            let valid = false;
            if(periodYear && stdcostYear) {
                valid = true;
            }
            return valid;

        },

        async getStdcostYearData(periodYear, prdgrpYearId, allocateAccountVersion, allocateYearId, periodNameFrom, periodNameTo, isCreateNew) {

            // show loading
            this.isLoading = true;

            // REFRESH DATA
            this.stdcostYear = null;
            
            var params = { 
                period_year: periodYear,
                allocate_account_version: allocateAccountVersion,
                prdgrp_year_id: prdgrpYearId,
                period_name_from: periodNameFrom,
                period_name_to: periodNameTo
            };

            this.selectedStdcostYearData = {
                period_year: periodYear,
                allocate_account_version: allocateAccountVersion,
                prdgrp_year_id: prdgrpYearId,
                allocate_year_id: allocateYearId,
                period_name_from: periodNameFrom,
                period_name_to: periodNameTo
            }

            // VALIDATE REQUIRED PARAMS BY ORGANIZATION_CODE
            const isValid = this.validateBeforeGetStdcostYear(periodYear, allocateAccountVersion);
            if(isValid) {

                const resGetStdcostYear = await axios.get("/ajax/ct/std-costs/year", { params })
                .then(res => {
                    const resData = res.data.data;
                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูล | ${resData.message}`, "error");
                    } else {
                        this.stdcostYear = resData.stdcost_year ? JSON.parse(resData.stdcost_year) : null;
                        if(this.stdcostYear && !isCreateNew) {
                            this.prdgrpYearId = this.stdcostYear.prdgrp_year_id;
                            this.allocateYearId = this.stdcostYear.allocate_year_id;
                            this.periodNameFrom = this.stdcostYear.period_name_from;
                            this.periodNameTo = this.stdcostYear.period_name_to;
                            this.planVersionNo = this.getPrdgrpPlanVersionNo(this.prdgrpVersions, this.prdgrpYearId);
                            this.periodNameFromLabel = this.getPeriodNameLabel(this.periodNameFroms, this.periodNameFrom);
                            this.periodNameToLabel = this.getPeriodNameLabel(this.periodNameTos, this.periodNameTo);
                        }
                    }
                    return resData;
                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูล | ${error.message}`, "error");
                    return ;
                });

                if(resGetStdcostYear.status != "error") {
                    if(!isCreateNew) {
                        // GET STDCOST_ACCOUNTS
                        await this.getStdcostAccounts(this.periodYear, this.stdcostYear);
                    }
                }
                
                this.setUrlParams();

            } else {
                swal("เกิดข้อผิดพลาด", `กรุณากรอกข้อมูลให้ครบถ้วน`, "error");
            }

            // hide loading
            this.isLoading = false;

        },

        async onGenerateStdcostYearData(periodYear, prdgrpYearId, allocateAccountVersion, allocateYearId, periodNameFrom, periodNameTo) {

            // GET STDCOST-YEAR DATA
            await this.getStdcostYearData(periodYear, prdgrpYearId, allocateAccountVersion, allocateYearId, periodNameFrom, periodNameTo, true);

            // GENERATE STDCOST-YEAR DATA
            if(this.stdcostYear) {
                swal({
                    title: "",
                    text: `พบข้อมูลซ้ำ (ปีบัญชีงบประมาณ: ${this.periodYearLabel}, เกณฑ์การปันส่วนครั้งที่: ${this.allocateAccountVersion}, เปรียบเทียบค่าใช้จ่ายจริงจาก: ${this.periodNameFromLabel} ถึง ${this.periodNameToLabel}) ต้องการสร้างข้อมูลใหม่ ?`,
                    showCancelButton: true,
                    confirmButtonClass: "btn-primary",
                    confirmButtonText: "ยืนยัน",
                    cancelButtonText: "ยกเลิก",
                    closeOnConfirm: true
                }, async (isConfirm) => {
                    if (isConfirm) {
                        this.prdgrpYearId = this.selectedStdcostYearData.prdgrp_year_id;
                        this.allocateYearId = this.selectedStdcostYearData.allocate_year_id;
                        this.periodNameFrom = this.selectedStdcostYearData.period_name_from;
                        this.periodNameTo = this.selectedStdcostYearData.period_name_to;
                        this.planVersionNo = this.getPrdgrpPlanVersionNo(this.prdgrpVersions, this.prdgrpYearId);
                        this.periodNameFromLabel = this.getPeriodNameLabel(this.periodNameFroms, this.periodNameFrom);
                        this.periodNameToLabel = this.getPeriodNameLabel(this.periodNameTos, this.periodNameTo);
                        
                        await this.onSaveStdcostYear();

                        // if(this.stdcostAccounts.length <= 0) {
                        //     // GENERATE STDCOST_ACCOUNTS + STDCOST_TARGETS
                        //     await this.generateStdcostAccountTargets(this.periodYear, this.stdcostYear);
                        // }

                        // REFRESH STD_COST_ACCOUNTS
                        await this.getStdcostAccounts(this.periodYear, this.stdcostYear);
                        
                    }
                });

            } else {
                
                await this.onSaveStdcostYear();

                // if(this.stdcostAccounts.length <= 0) {
                //     // GENERATE STDCOST_ACCOUNTS + STDCOST_TARGETS
                //     await this.generateStdcostAccountTargets(this.periodYear, this.stdcostYear);
                // }

                // REFRESH STD_COST_ACCOUNTS
                await this.getStdcostAccounts(this.periodYear, this.stdcostYear);

            }

        },

        async getListPeriods(periodYear) {

            let resultData = null;

            // show loading
            this.isLoading = true;
            
            var params = { 
                period_year: periodYear
            };

            if(periodYear) {

                resultData = await axios.get("/ajax/ct/std-costs/list-periods", { params })
                .then(res => {
                    const resData = res.data.data;
                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลเดือนงบประมาณของปี ${periodYear} | ${resData.message}`, "error");
                    } else {

                        this.periodNameFroms = resData.periods ? JSON.parse(resData.periods) : [];
                        this.periodNameFroms = this.periodNameFroms.filter(item => {
                            return item.period_num < 12;
                        });

                        this.periodNameTos = resData.periods ? JSON.parse(resData.periods) : [];
                        this.periodNameTos = this.periodNameTos.filter(item => {
                            return item.period_num < 12;
                        });
                        
                    }
                    return resData;
                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลเดือนงบประมาณของปี ${periodYear} | ${error.message}`, "error");
                    return ;
                });

            }

            // hide loading
            this.isLoading = false;

            return resultData;

        },

        async getListPrdgrps(periodYear) {

            let resultData = null;

            // show loading
            this.isLoading = true;
            
            var params = { 
                period_year: periodYear
            };

            if(periodYear) {

                resultData = await axios.get("/ajax/ct/std-costs/list-prdgrps", { params })
                .then(res => {
                    const resData = res.data.data;
                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลแผนการผลิต ปี ${periodYear} | ${resData.message}`, "error");
                    } else {
                        this.prdgrpVersions = resData.prdgrps ? JSON.parse(resData.prdgrps) : [];
                    }
                    return resData;
                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลแผนการผลิต ปี ${periodYear} | ${error.message}`, "error");
                    return ;
                });

            }

            // hide loading
            this.isLoading = false;

            return resultData;

        },

        async getAllocateGroupCodes(periodYear, versionNo) {

            let resultData = null;

            // show loading
            this.isLoading = true;
            
            var params = { 
                period_year: periodYear,
                version_no: versionNo,
            };

            if(periodYear) {

                resultData = await axios.get("/ajax/ct/std-costs/allocate-group-codes", { params })
                .then(res => {
                    const resData = res.data.data;
                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลหน่วยงานที่ปัน ปี ${periodYear} | ${resData.message}`, "error");
                    } else {
                        this.allocateGroupCodes = resData.allocate_group_codes ? JSON.parse(resData.allocate_group_codes) : [];
                    }
                    return resData;
                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลหน่วยงานที่ปัน ปี ${periodYear} | ${error.message}`, "error");
                    return ;
                });

            }

            // hide loading
            this.isLoading = false;

            return resultData;

        },

        async getAllocateAccounts(periodYear) {

            let resultData = null;

            // show loading
            this.isLoading = true;
            
            var params = { 
                period_year: periodYear
            };

            if(periodYear) {

                resultData = await axios.get("/ajax/ct/std-costs/allocate-accounts", { params })
                .then(res => {
                    const resData = res.data.data;
                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลเกณฑ์การปันส่วนครั้งที่ ปี ${periodYear} | ${resData.message}`, "error");
                    } else {
                        this.allocateAccountVersions = resData.allocate_account_versions ? JSON.parse(resData.allocate_account_versions) : [];
                    }
                    return resData;
                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลเกณฑ์การปันส่วนครั้งที่ ปี ${periodYear} | ${error.message}`, "error");
                    return ;
                });

            }

            // hide loading
            this.isLoading = false;

            return resultData;

        },

        async getStdcostAccounts(periodYear, stdcostYear) {

            let resultData = null;

            // show loading
            this.isLoading = true;

            // REFRESH DATA
            this.stdcostAccounts = [];
            this.listAllAllocateGroupCodes = [];
            this.listDeptAllocateGroupCodes = [];
            this.listCostAllocateGroupCodes = [];
            this.listProductAllocateGroupCodes = [];
            
            var params = { 
                period_year: periodYear,
                input_stdcost_year: JSON.stringify(stdcostYear),
            };

            const isValid = this.validateBeforeGetStdcostAccounts(periodYear, stdcostYear);
            if(isValid) {

                resultData = await axios.get("/ajax/ct/std-costs/accounts", { params })
                .then(res => {
                    const resData = res.data.data;
                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลบัญชีรับปัน | ${resData.message}`, "error");
                    } else {
                        this.stdcostAccounts = resData.stdcost_accounts ? JSON.parse(resData.stdcost_accounts) : [];
                        this.listAllAllocateGroupCodes = resData.list_all_allocate_group_codes ? JSON.parse(resData.list_all_allocate_group_codes) : [];
                        this.listDeptAllocateGroupCodes = resData.list_dept_allocate_group_codes ? JSON.parse(resData.list_dept_allocate_group_codes) : [];
                        this.listCostAllocateGroupCodes = resData.list_cost_allocate_group_codes ? JSON.parse(resData.list_cost_allocate_group_codes) : [];
                        this.listProductAllocateGroupCodes = resData.list_product_allocate_group_codes ? JSON.parse(resData.list_product_allocate_group_codes) : [];
                    }
                    return resData;
                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลบัญชีรับปัน | ${error.message}`, "error");
                    return ;
                });

                this.showTableStdcostAccounts = true;

            }

            // hide loading
            this.isLoading = false;

            return resultData;

        },

        // async generateStdcostAccountTargets(periodYear, stdcostYear) {

        //     let resultData = null;

        //     // show loading
        //     this.isLoading = true;

        //     // REFRESH DATA
        //     this.stdcostAccounts = [];
            
        //     const reqBody = {
        //         period_year: periodYear,
        //         input_stdcost_year: JSON.stringify(stdcostYear),
        //     };

        //     const isValid = this.validateBeforeGenerateAccountTargets(periodYear, stdcostYear);
        //     if(isValid) {

        //         await axios.post(`/ajax/ct/std-costs/generate-account-targets`, reqBody)
        //         .then(res => {
        //             const resData = res.data.data;
        //             if(resData.status == "error") {
        //                 swal("เกิดข้อผิดพลาด", `ไม่สามารถสร้างรายการต้นทุนมาตรฐานค่าแรงและค่าใช้จ่ายการผลิต | ${resData.message}`, "error");
        //             } else {
                        
        //             }
        //             return resData;
        //         }).catch((error) => {
        //             console.log(error);
        //             swal("เกิดข้อผิดพลาด", `ไม่สามารถสร้างรายการต้นทุนมาตรฐานค่าแรงและค่าใช้จ่ายการผลิต | ${error.message}`, "error");
        //             return ;
        //         });

        //         // REFRESH STD_COST_ACCOUNTS
        //         await this.getStdcostAccounts(this.periodYear, this.stdcostYear);
        //     }

        //     // hide loading
        //     this.isLoading = false;

        //     return resultData;

        // },

        getApproveStatusDesc(status) {
            let statusDesc = "-";
            if(status) {
                const foundStatus = this.approveStatuses.find(item => item.lookup_code == status);
                statusDesc = foundStatus ? foundStatus.description : "-"; 
            }
            return statusDesc;
        },

        onStdcostAccountsChanged(data) {
            this.stdcostAccounts = data.stdcostAccounts;
        },

        async onSearchStdcostVersion(data) {

            this.stdcostYear = data.stdcost_year;
            this.allocateGroup = data.allocate_group;
            
            this.periodYear = this.stdcostYear.period_year;
            this.periodYearLabel = this.getPeriodYearLabel(this.periodYears, this.periodYear);
            this.prdgrpYearId = this.stdcostYear.prdgrp_year_id;
            this.allocateAccountVersion = this.stdcostYear.version_no;

            this.allocateYearId = this.stdcostYear.allocate_year_id;
            this.periodNameFrom = this.stdcostYear.period_name_from;
            this.periodNameTo = this.stdcostYear.period_name_to;

            this.planVersionNo = this.getPrdgrpPlanVersionNo(this.prdgrpVersions, this.prdgrpYearId);
            this.periodNameFromLabel = this.getPeriodNameLabel(this.periodNameFroms, this.periodNameFrom);
            this.periodNameToLabel = this.getPeriodNameLabel(this.periodNameTos, this.periodNameTo);

            if(this.periodYear) {
                await this.getListPeriods(this.periodYear);
                await this.getListPrdgrps(this.periodYear);
                await this.getAllocateGroupCodes(this.periodYear, this.allocateGroup, this.allocateAccountVersion);
                await this.getAllocateAccounts(this.periodYear); 
            }

            await this.getStdcostYearData(this.periodYear, this.prdgrpYearId, this.allocateAccountVersion, this.allocateYearId, this.periodNameFrom, this.periodNameTo, false);

        },

        async onSaveStdcostYear() {

            const reqBody = {
                period_year: this.periodYear,
                prdgrp_year_id: this.prdgrpYearId,
                allocate_account_version: this.allocateAccountVersion,
                allocate_year_id: this.allocateYearId,
                period_name_from: this.periodNameFrom,
                period_name_to: this.periodNameTo
            };

            // show loading
            this.isLoading = true;

            const isValid = this.validateBeforeSaveStdcostYear(this.periodYear, this.prdgrpYearId, this.allocateAccountVersion, this.allocateYearId, this.periodNameFrom, this.periodNameTo);
            if(isValid) {

                // call store sample result
                await axios.post(`/ajax/ct/std-costs/year`, reqBody)
                .then(res => {

                    const resData = res.data.data;
                    const resMsg = resData.message;

                    if(resData.status == "success") {

                        this.stdcostYear = resData.stdcost_year ? JSON.parse(resData.stdcost_year) : null;
                        this.existPeriodYearOptions = resData.exist_period_years ? JSON.parse(resData.exist_period_years) : [];

                    }

                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `บันทึกต้นทุนมาตรฐานค่าแรงและค่าใช้จ่ายการผลิต | ${resMsg}`, "error");
                    }
                    
                    return resData;

                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `บันทึกต้นทุนมาตรฐานค่าแรงและค่าใช้จ่ายการผลิต | ${error.message}`, "error");
                });

            } else {
                swal("เกิดข้อผิดพลาด", `ไม่สามารถบันทึกต้นทุนมาตรฐานค่าแรงและค่าใช้จ่ายการผลิต | ${resValidate.message}`, "error");
            }

            // hide loading
            this.isLoading = false;

        },

        formatDateTh(date) {
            return date ? moment(date).add(543, 'years').format('DD/MM/YYYY') : ""
        },

    }

}

</script>