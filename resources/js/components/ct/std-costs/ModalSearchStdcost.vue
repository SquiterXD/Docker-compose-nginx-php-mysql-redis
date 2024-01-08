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

                <h4> ค้นหากำหนดเกณฑ์การปันส่วน </h4>
                <hr>

                <div class="row">

                    <div class="col-md-5">

                        <div class="row form-group">

                            <label class="col-md-4 col-form-label tw-font-bold tw-pt-0 required"> ปีบัญชีงบประมาณ </label>
                            <div class="col-md-8">
                                <pm-el-select name="period_year" id="input_period_year" 
                                    :select-options="periodYearOptions"
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

                            <label class="col-md-4 col-form-label tw-font-bold tw-pt-0"> แผนการผลิตครั้งที่ </label>
                            <div class="col-md-8">
                                <pm-el-select name="prdgrp_year_id" id="input_prdgrp_year_id" 
                                    :select-options="prdgrpVersions"
                                    option-key="prdgrp_year_id"
                                    option-value="prdgrp_year_id" 
                                    option-label="plan_version_no" 
                                    :value="prdgrpYearId"
                                    :filterable="true"
                                    :clearable="true"
                                    @onSelected="onPrdgrpVersionChanged"
                                />
                            </div>
                        </div>

                    </div>

                    <div class="col-md-5">

                        <div class="row form-group">

                            <label class="col-md-4 col-form-label tw-font-bold tw-pt-0"> เกณฑ์การปันส่วนครั้งที่ </label>
                            <div class="col-md-8">
                                <pm-el-select name="allocate_account_version" id="input_allocate_account_version" 
                                    :select-options="allocateAccountVersions"
                                    option-key="version_no"
                                    option-value="version_no" 
                                    option-label="version_no" 
                                    :value="allocateAccountVersion"
                                    :filterable="true"
                                    :clearable="true"
                                    @onSelected="onAllocateAccountVersionChanged"
                                />
                            </div>

                        </div>   

                    </div>

                    <div class="col-md-2">

                        <div class="text-right">

                            <button type="button" 
                                @click="getListStdcostYears" 
                                class="btn btn-primary tw-w-32"
                                :disabled="!periodYear"> 
                                ค้นหา 
                            </button>

                            <button type="button" 
                                @click="$modal.hide(modalName)" 
                                class="btn btn-link tw-w-32 tw-mt-2"> 
                                ยกเลิก 
                            </button>
                            
                        </div>

                    </div>

                </div>
                
                <hr>

                <div class="table-responsive" style="max-height: 360px;">

                    <table class="table table-bordered table-sticky mb-0">
                        <thead>
                            <tr>
                                <th width="10%" class="text-center tw-text-xs md:tw-table-cell"> ปีบัญชีงบประมาณ </th>
                                <th width="10%" class="text-center tw-text-xs md:tw-table-cell"> แผนการผลิตครั้งที่ </th>
                                <th width="20%" class="text-center tw-text-xs md:tw-table-cell"> เปรียบเทียบค่าใช้จ่ายจริงจาก-ถึง </th>
                                <!-- <th width="25%" class="text-center tw-text-xs md:tw-table-cell"> หน่วยงานที่ปัน </th> -->
                                <th width="10%" class="text-center tw-text-xs md:tw-table-cell"> เกณฑ์การปันส่วนครั้งที่ </th>
                                <th width="10%" class="text-center tw-text-xs md:tw-table-cell"> วันที่สร้าง </th>
                                <th width="10%"></th>
                            </tr>
                        </thead>
                        <tbody v-if="stdcostYears.length > 0">
                            <template v-for="(stdcostYear, index) in stdcostYears">
                                <tr :key="index">
                                    <td class="text-center md:tw-table-cell"> {{ stdcostYear.period_year ? getPeriodYearLabel(periodYears, stdcostYear.period_year) : "-" }} </td>
                                    <td class="text-center md:tw-table-cell"> {{ stdcostYear.prdgrp_year_id ? getPrdgrpPlanVersionNo(prdgrpVersions, stdcostYear.prdgrp_year_id) : "-" }} </td>
                                    <td class="text-center md:tw-table-cell"> {{ stdcostYear.period_name_from ? getPeriodNameLabel(periodNames, stdcostYear.period_name_from) : "" }} - {{ stdcostYear.period_name_to ? getPeriodNameLabel(periodNames, stdcostYear.period_name_to) : "" }} </td>
                                    <!-- <td class="text-center md:tw-table-cell"> {{ stdcostYear.dept_code ? getDeptCodeLabel(allocateGroupCodes, stdcostYear.dept_code) : "" }} </td> -->
                                    <td class="text-center md:tw-table-cell"> {{ stdcostYear.version_no }} </td>
                                    <td class="text-center md:tw-table-cell"> {{ stdcostYear.creation_date }} </td>
                                    <td class="text-center md:tw-table-cell">  
                                        <button class="btn btn-inline-block btn-primary"
                                            @click="onSelectStdcostYearVersion(stdcostYear)">
                                            เลือก
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td colspan="7">
                                    <h2 class="p-5 text-center text-muted">ไม่พบข้อมูล</h2>
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

export default {

    props: [
        "modalName", 
        "modalWidth", 
        "modalHeight",
        "organizationCode",
        "periodYears",
        "periodYearValue",
        "listAllocateGroups"
    ],

    components: { Loading },

    watch: {
        periodYears : function (value) {
            this.periodYearOptions = value;
        },
        periodYearValue : function (value) {
            this.periodYearLabel = this.getPeriodYearLabel(this.periodYearOptions, value);
            if(this.periodYearLabel) {
                this.periodYear = value;
                this.getListPeriods(this.periodYear); 
                this.getListPrdgrps(this.periodYear); 
                this.getAllocateGroupCodes(this.periodYear, this.allocateAccountVersion); 
                this.getAllocateAccounts(this.periodYear); 
            }
        },
    },

    data() {
        return {

            isLoading: false,
            width: this.modalWidth,
            
            periodYear: this.periodYearValue,
            periodYearLabel: this.getPeriodYearLabel(this.periodYears, this.periodYearValue),

            periodNames: [],

            periodYearOptions: this.periodYears,
            prdgrpVersions: [],
            prdgrpYearId: this.prdgrpYearIdValue,
            planVersionNo: null,

            allocateAccountVersions: [],
            allocateAccountVersion: this.allocateAccountVersionValue,
            allocateYearId: this.allocateAccountVersionValue,

            allocateGroupCodes: [],
            
            stdcostYears: [],
            selectedStdcostYear: null,
            
        };
    },

    created() {
        this.handleResize();
    },

    mounted() {
        
        this.periodYearOptions = this.periodYears;
        this.periodYearLabel = this.getPeriodYearLabel(this.periodYears, this.periodYearValue);
        if(this.periodYearLabel) {
            this.periodYear = this.periodYearValue;
            this.getListPeriods(this.periodYear); 
            this.getListPrdgrps(this.periodYear); 
            this.getAllocateGroupCodes(this.periodYear, this.allocateAccountVersionValue); 
            this.getAllocateAccounts(this.periodYear); 
        }

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

        async onPeriodYearChanged(value) {
            
            this.periodYear = value;
            this.periodYearLabel = this.getPeriodYearLabel(this.periodYears, this.periodYear);

            // REFRESH DATA
            this.periodNameFrom = null;
            this.periodNameTo = null;
            this.allocateAccountVersion = null;
            this.allocateYearId = null;
            this.prdgrpYearId = null;

            this.getListPeriods(this.periodYear); 
            this.getListPrdgrps(this.periodYear); 
            this.getAllocateGroupCodes(this.periodYear, this.allocateAccountVersion); 
            this.getAllocateAccounts(this.periodYear); 
            
        },

        async onPrdgrpVersionChanged(value) {

            this.prdgrpYearId = value;
            this.planVersionNo = this.getPrdgrpPlanVersionNo(this.prdgrpVersions, this.prdgrpYearId);

        },

        async onAllocateAccountVersionChanged(value) {

            this.allocateAccountVersion = value;
            this.getAllocateGroupCodes(this.periodYear, this.allocateAccountVersion); 

            const foundAlcAccVersion = this.allocateAccountVersions.find(item => item.version_no == value);
            this.allocateYearId = foundAlcAccVersion ? foundAlcAccVersion.allocate_year_id : null;

        },

        getPeriodYearLabel(periodYears, periodYear) {
            let foundPeriodYear = null;
            if(periodYears && periodYear) {
                if(periodYears.length > 0) {
                    foundPeriodYear = periodYears.find(item => item.period_year_value == periodYear);
                }
            }
            return foundPeriodYear ? foundPeriodYear.period_year_label : "";
        },

        getPrdgrpPlanVersionNo(prdgrpVersions, prdgrpYearIdValue) {
            let result = null;
            if(prdgrpYearIdValue){
                const foundPrdgrp = prdgrpVersions.find(item => item.prdgrp_year_id == prdgrpYearIdValue);
                result = foundPrdgrp ? foundPrdgrp.plan_version_no : "";
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

        getAllocateGroupLevel(listAllocateGroups, allocateGroupValue) {
            const foundAllocateGroup = listAllocateGroups.find(item => item.allocate_group == allocateGroupValue);
            return foundAllocateGroup ? foundAllocateGroup.level_no : "";
        },

        getAllocateGroupLabel(listAllocateGroups, allocateGroupValue) {
            const foundAllocateGroup = listAllocateGroups.find(item => item.allocate_group == allocateGroupValue);
            return foundAllocateGroup ? foundAllocateGroup.allocate_group_label : "";
        },

        async getListStdcostYears() {

            // show loading
            this.isLoading = true;

            // REFRESH DATA
            this.stdcostYears = [];
            this.selectedStdcostYear = null;
            
            var params = { 
                period_year: this.periodYear,
                allocate_account_version: this.allocateAccountVersion,
                allocate_group: this.allocateGroup,
                prdgrp_year_id: this.prdgrpYearId,
            };

            let foundPeriodYear = null;
            if(this.periodYearOptions && this.periodYear) {
                if(this.periodYearOptions.length > 0) {
                    foundPeriodYear = this.periodYearOptions.find(item => item.period_year_value == this.periodYear);
                }
            }

            // VALIDATE REQUIRED PARAMS BY ORGANIZATION_CODE
            if(foundPeriodYear) {

                await axios.get("/ajax/ct/std-costs/list-years", { params })
                .then(res => {
                    const resData = res.data.data;
                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลปันส่วนของปีปัญชี ไม่ถูกต้อง | ${resData.message}`, "error");
                    } else {
                        this.stdcostYears = resData.stdcost_years ? JSON.parse(resData.stdcost_years) : null;
                    }
                    return resData;
                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลปันส่วนของปีปัญชี ไม่ถูกต้อง | ${error.message}`, "error");
                    return ;
                });

            } else {
                swal("เกิดข้อผิดพลาด", `กรุณากรอกข้อมูลให้ครบถ้วน`, "error");
            }

            // hide loading
            this.isLoading = false;

        },

        async getListPeriods(periodYear) {

            let resultData = null;

            // show loading
            this.isLoading = true;
            
            var params = { 
                period_year: periodYear
            };

            let foundPeriodYear = null;
            if(this.periodYearOptions && periodYear) {
                if(this.periodYearOptions.length > 0) {
                    foundPeriodYear = this.periodYearOptions.find(item => item.period_year_value == periodYear);
                }
            }

            if(foundPeriodYear) {

                resultData = await axios.get("/ajax/ct/std-costs/list-periods", { params })
                .then(res => {
                    const resData = res.data.data;
                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลเดือนงบประมาณของปี ${periodYear} | ${resData.message}`, "error");
                    } else {
                        this.periodNames = resData.periods ? JSON.parse(resData.periods) : [];
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
                period_year: periodYear,
                only_exist: true,
            };

            let foundPeriodYear = null;
            if(this.periodYearOptions && periodYear) {
                if(this.periodYearOptions.length > 0) {
                    foundPeriodYear = this.periodYearOptions.find(item => item.period_year_value == periodYear);
                }
            }

            if(foundPeriodYear) {

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
                only_exist: true,
            };

            let foundPeriodYear = null;
            if(this.periodYearOptions && periodYear) {
                if(this.periodYearOptions.length > 0) {
                    foundPeriodYear = this.periodYearOptions.find(item => item.period_year_value == periodYear);
                }
            }

            if(foundPeriodYear) {

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
                period_year: periodYear,
                only_exist: true,
            };

            let foundPeriodYear = null;
            if(this.periodYearOptions && periodYear) {
                if(this.periodYearOptions.length > 0) {
                    foundPeriodYear = this.periodYearOptions.find(item => item.period_year_value == periodYear);
                }
            }

            if(foundPeriodYear) {

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
        onSelectStdcostYearVersion(stdcostYear) {
            this.selectedStdcostYear = stdcostYear;
            this.onSearchStdcostVersion();
        },

        onSearchStdcostVersion() {
            this.$modal.hide(this.modalName);
            this.$emit("onSearchStdcostVersion", {
                stdcost_year: this.selectedStdcostYear,
                allocate_group: this.allocateGroup
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
.vm--overlay[data-modal="modal-search-allocate-year"] {
    height: 100% !important;
}
</style>