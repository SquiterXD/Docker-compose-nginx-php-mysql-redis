<template>

    <div class="ibox">

        <div class="ibox-content tw-pt-10" style="min-height: 600px;">

            <div class="row">

                <div class="col-md-4">

                    <div class="row form-group">

                        <label class="col-md-6 col-form-label tw-font-bold tw-pt-0"> ปีบัญชีงบประมาณ </label>
                        <div class="col-md-6">
                            <input type="text" class="form-control input-sm" v-model="periodYearLabel" readonly>
                        </div>

                    </div>

                </div>

                <div class="col-md-2">

                    <div class="row form-group">

                        <label class="col-md-7 col-form-label tw-font-bold tw-pt-0"> แผนการผลิตครั้งที่ </label>
                        <div class="col-md-5">
                            <input type="text" class="form-control input-sm" v-model="yearControl.plan_version_no" readonly>
                        </div>

                    </div>

                </div>

                <div class="col-md-2">

                    <div class="row form-group">

                        <label class="col-md-5 col-form-label tw-font-bold tw-pt-0"> ครั้งที่ </label>
                        <div class="col-md-7">
                            <input type="text" class="form-control input-sm" v-model="yearControl.ct14_last_version_no" readonly>
                        </div>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="row form-group">

                        <label class="col-md-6 col-form-label tw-font-bold tw-pt-0"> วันที่เริ่มใช้ </label>
                        <div class="col-md-6">
                            <input type="text" class="form-control input-sm" v-model="yearControl.start_date_thai" readonly>
                        </div>

                    </div>


                </div>

            </div>

            <div class="row">

                <div class="col-md-8">

                    <div class="row form-group">

                        <label class="col-md-3 col-form-label tw-font-bold tw-pt-0"> ศูนย์ต้นทุน </label>
                        <div class="col-md-3">
                            <input type="text" class="form-control input-sm" v-model="yearControl.cost_code" readonly>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control input-sm" v-model="yearControl.cost_description" readonly>
                        </div>

                    </div>    

                </div>  

                <div class="col-md-4">

                    <div class="row form-group">

                        <label class="col-md-6 col-form-label tw-font-bold tw-pt-0"> วันที่สิ้นสุด </label>
                        <div class="col-md-6">
                            <input type="text" class="form-control input-sm" v-model="yearControl.end_date_thai" readonly>
                        </div>

                    </div>  

                </div>

            </div>

            <div class="row"> 

                <div class="col-md-8">

                    <div class="row form-group">

                        <label class="col-md-3 col-form-label tw-font-bold tw-pt-0"> ประเภทศูนย์ต้นทุน </label>
                        <div class="col-md-9">
                            <input type="text" class="form-control input-sm" :value="yearControl ? yearControl.cost_center.cost_group_desc : '-'" readonly>
                        </div>

                    </div>

                </div>   

                <div class="col-md-4">

                    <div class="row form-group">

                        <label class="col-md-6 col-form-label tw-font-bold tw-pt-0"> สถานะ </label>
                        <div class="col-md-6">
                            <input type="text" class="form-control input-sm" :value="yearControl.approved_status ? getApprovedStatusLabel(yearControl.approved_status) : ''" readonly>
                        </div>

                    </div>

                </div>         

            </div>

            <hr>

            <div class="row">

                <div class="col-md-4">

                    <div class="row form-group">

                        <label class="col-md-6 col-form-label tw-font-bold tw-pt-0"> เกณฑ์การปันส่วนครั้งที่ </label>
                        <div class="col-md-6">
                            <input type="text" class="form-control input-sm" :value="allocateYear ? allocateYear.version_no : '-'" readonly>
                        </div>

                    </div>    

                </div>    

                <div class="col-md-5">

                    <div class="row form-group">

                        <label class="col-md-4 col-form-label tw-font-bold tw-pt-0"> เปรียบเทียบค่าใช้จ่ายจากเดือน </label>
                        <div class="col-md-8">
                            <div class="input-group input-group-sm mb-3">
                                <input type="text" class="form-control text-center input-sm" :value="periodFromData ? periodFromData.thai_month : '-'" readonly>
                                <div class="input-group-prepend input-group-append"> <span class="input-group-text" id="inputGroup-sizing-sm"> ถึง </span> </div>
                                <input type="text" class="form-control text-center input-sm" :value="periodToData ? periodToData.thai_month : '-'" readonly>
                            </div>
                        </div>

                    </div>

                </div>    
                
                <div class="col-md-3">

                    <button class="btn btn-inline-block btn-primary tw-w-full"
                        :disabled="!yearControl || !latestStdcostYear"
                        @click="getStdcostPrdGroups(yearControl.period_year, yearControl.prdgrp_year_id, yearControl.cost_code, latestStdcostYear)">
                        <i class="fa fa-arrow-down"></i> คำนวณสรุปต้นทุน
                    </button>

                </div>

            </div>

            <hr>

            <div class="row tw-mb-5">

                <div class="col-12">

                    <table-summary-prd-groups 
                        :uom-codes="uomCodes"
                        :period-year-value="periodYear"
                        :stdcost-year="stdcostYear"
                        :stdcost-prd-groups="stdcostPrdGroupItems" 
                        :allocate-types="allocateTypes" 
                    >
                    </table-summary-prd-groups>

                </div>

            </div>

            <hr>
            
            <div
                style="background-color: #d9d9d9; color: black; font-weight: bold;">
                ผลิตภัณฑ์ที่ยังไม่อนุมัติราคาต้นทุนมาตรฐาน
            </div>
            
            <div class="row tw-mb-5">
            </div>

            <div class="row tw-mb-5">
            
                <div class="col-12">
            
                    <table-summary-prd-group-totals-no-approve 
                        :period-year-value="periodYear" 
                        :stdcost-year="stdcostYearData"
                        :stdcost-prd-group-totals-no-approve="stdcostPrdGroupTotalsNoApproveItems" 
                        :allocate-types="allocateTypes"
                        >

                    </table-summary-prd-group-totals-no-approve>
            
                </div>
            
            </div>

            <div
                style="background-color: #d9d9d9; color: black; font-weight: bold;">
                ผลิตภัณฑ์ที่อนุมัติราคาต้นทุนมาตรฐานแล้ว
            </div>
            
            <div class="row tw-mb-5">
            </div>

            <div class="row tw-mb-5">

                <div class="col-12">

                    <table-summary-prd-group-totals 
                        :period-year-value="periodYear"
                        :stdcost-year="stdcostYearData"
                        :stdcost-prd-group-totals="stdcostPrdGroupTotalItems" 
                        :allocate-types="allocateTypes"
                    >
                    </table-summary-prd-group-totals>

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

import TableSummaryPrdGroups from "./TableSummaryPrdGroups";
import TableSummaryPrdGroupTotals from "./TableSummaryPrdGroupTotals";
import TableSummaryPrdGroupTotalsNoApprove from "./TableSummaryPrdGroupTotalsNoApprove";

export default {
    
    components: { Loading, TableSummaryPrdGroups, TableSummaryPrdGroupTotals, TableSummaryPrdGroupTotalsNoApprove},

    props: [ "defaultData", "uomCodes", "costCode", "planVersionNo", "versionNo", "ct14VersionNo", "periodYearData", "periodFrom", "periodTo" , "allocateTypes", "allocateYear", "yearControl", "latestStdcostYear", "stdcostYear", "stdcostPrdGroups", "stdcostPrdGroupTotals", "stdcostPrdGroupTotalsNoApprove" ],

    mounted() {

        if(this.yearControl) {

            if(!this.latestStdcostYear) {
                swal("เกิดข้อผิดพลาด", `ไม่พบข้อมูลต้นทุนมาตรฐาน "สรุปต้นทุน" ปีบัญชีงบประมาณ: ${this.periodYearData.period_year_thai}, ศูนย์ต้นทุน: ${this.yearControl.cost_code} ${this.yearControl.cost_description}, แผนการผลิตครั้งที่: ${this.yearControl.plan_version_no}, ครั้งที่: ${this.ct14VersionNo}, กรุณาตรวจสอบอีกครั้ง`, "error");
            } else {
                if(this.stdcostPrdGroups.length <= 0) {
                    this.getStdcostPrdGroups(this.yearControl.period_year, this.yearControl.prdgrp_year_id, this.yearControl.cost_code, this.latestStdcostYear);
                }
            }

        } else {
            swal("เกิดข้อผิดพลาด", `ไม่พบข้อมูลต้นทุนมาตรฐาน "สรุปต้นทุน" ปีบัญชีงบประมาณ: ${this.periodYearData.period_year_thai}, ศูนย์ต้นทุน: ${this.costCode}, แผนการผลิตครั้งที่: ${this.planVersionNo}, ครั้งที่: ${this.ct14VersionNo} , กรุณาตรวจสอบอีกครั้ง`, "error");
        }

    },

    data() {
        return {

            organizationId: this.defaultData ? this.defaultData.organization_id : null,
            organizationCode: this.defaultData ? this.defaultData.organization_code : null,
            department: this.defaultData ? this.defaultData.department : null,
            approvedStatuses: [
                { value: "Active", label: "อนุมัติ"},
                { value: "Inactive", label: "ไม่อนุมัติ"}
            ],
            
            periodYear: this.periodYearData ? this.periodYearData.period_year : null,
            periodYearLabel: this.periodYearData ? this.periodYearData.period_year_thai : null,
            
            stdcostYearData: this.stdcostYear ? this.stdcostYear : null,
            stdcostPrdGroupItems: this.stdcostPrdGroups ? this.stdcostPrdGroups : [],
            stdcostPrdGroupTotalItems: this.stdcostPrdGroupTotals ? this.stdcostPrdGroupTotals : [],
            stdcostPrdGroupTotalsNoApproveItems: this.stdcostPrdGroupTotalsNoApprove ? this.stdcostPrdGroupTotalsNoApprove : [],
            

            periodFromData: this.periodFrom ? this.periodFrom : null,
            periodToData: this.periodTo ? this.periodTo : null,

            isLoading: false,

        }
    },

    computed: {

    },

    methods: {

        getApprovedStatusLabel(approvedStatus) {
            const foundApprovedStatus = this.approvedStatuses.find(item => item.value == approvedStatus);
            return foundApprovedStatus ? foundApprovedStatus.label : "";
        },

        async getStdcostPrdGroups(periodYear, prdgrpYearId, costCode, stdcostYearData) {

            // show loading
            this.isLoading = true;

            var params = { 
                period_year: periodYear, 
                prdgrp_year_id: prdgrpYearId,
                cost_code: costCode,
                year_control: JSON.stringify(this.yearControl),
                stdcost_year: JSON.stringify(stdcostYearData),
            };

            await axios.get(`/ajax/ct/std-cost-papers/summary-prd-groups`, { params })
            .then(res => {

                const resData = res.data.data;
                if(resData.status == "success") {
                    this.periodToData = resData.period_to ? JSON.parse(resData.period_to) : [];
                    this.stdcostYearData = resData.stdcost_year ? JSON.parse(resData.stdcost_year) : [];
                    this.stdcostPrdGroupItems = resData.stdcost_prd_groups ? JSON.parse(resData.stdcost_prd_groups) : [];
                    this.stdcostPrdGroupTotalItems = resData.stdcost_prd_group_totals ? JSON.parse(resData.stdcost_prd_group_totals) : [];
                } else {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูล | ${resData.message}`, "error");                    
                }
                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูล | ${error.message}`, "error");
            });

            // hide loading
            this.isLoading = false;

        },

        getPeriodNameLabel(periodNames, periodName) {
            let result = null;
            if(periodName) {
                const foundPeriodName = periodNames.find(item => item.period_name == periodName);
                result = foundPeriodName ? foundPeriodName.thai_month : "";
            }
            return result;
        },

        formatDateTh(date) {
            return date ? moment(date).add(543, 'years').format('DD/MM/YYYY') : ""
        },

    }

}

</script>