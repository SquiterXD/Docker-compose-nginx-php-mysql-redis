<template>

    <div>

        <div class="table-responsive" style="max-height: 300px;">
            <table class="table table-bordered table-sticky mb-0">
                <thead>
                    <tr>
                        <!-- <th width="10%" class="text-center tw-text-xs md:tw-table-cell"> ศูนย์ต้นทุน </th> -->
                        <th width="15%" class="text-center tw-text-xs md:tw-table-cell"> ค่าแรง/ค่าใช้จ่าย </th>
                        <th width="15%" class="text-right tw-text-xs md:tw-table-cell"> ค่าแรง/ใช้จ่ายจริง (บาท) </th>
                        <th width="15%" class="text-right tw-text-xs md:tw-table-cell"> ค่าใช้จ่ายจริงเฉลี่ย </th>
                        <th width="15%" class="text-right tw-text-xs md:tw-table-cell"> ค่าแรง/ใช้จ่ายตามงบประมาณ (บาท) </th>
                        <th width="15%" class="text-right tw-text-xs md:tw-table-cell"> ค่าแรง/ใช้จ่ายประมาณการ (บาท) </th>
                        <th width="10%"></th>
                    </tr>
                </thead>
                <tbody v-if="stdcostAccountItems.length > 0">
                    <template v-for="(stdcostAccountItem, index) in stdcostAccountItems">

                        <tr :key="index" v-if="!stdcostAccountItem.marked_as_deleted">

                            <!-- <td class="text-center md:tw-table-cell">
                                {{ stdcostAccountItem.cost_code }}
                            </td> -->
                            <td class="text-left md:tw-table-cell">
                                {{ stdcostAccountItem.account_type_desc }}
                            </td>
                            <td class="text-right md:tw-table-cell">
                                {{ stdcostAccountItem.acc_actual_amount ? Number(stdcostAccountItem.acc_actual_amount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "0.00" }} 
                            </td>
                            <td class="text-right md:tw-table-cell">
                                {{ stdcostAccountItem.acc_avg_actual_amount ? Number(stdcostAccountItem.acc_avg_actual_amount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "0.00" }} 
                            </td>
                            <td class="text-right md:tw-table-cell">
                                {{ stdcostAccountItem.acc_budget_amount ? Number(stdcostAccountItem.acc_budget_amount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "0.00" }} 
                            </td>
                            <td class="text-right md:tw-table-cell">
                                {{ stdcostAccountItem.acc_estimate_expense_amount ? Number(stdcostAccountItem.acc_estimate_expense_amount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "0.00" }} 
                            </td>
                            <td class="text-center text-nowrap">
                               <button class="btn btn-inline-block btn-xs btn-white"
                                    @click="onGetStdcostTargets(stdcostAccountItem)"
                                > 
                                    <i class="fa fa-list tw-mr-1"></i> รายการบัญชีที่ปัน
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

        <hr>

        <div>
        
            <!-- <div v-if="stdcostTargets.length > 0"> -->
            <div>
                <table-std-cost-targets 
                    :period-year-value="periodYear"
                    :year-control="yearControlData"
                    :stdcost-year="stdcostYearData"
                    :stdcost-account="selectedStdcostAccountItem"
                    :stdcost-targets="stdcostTargets"
                >
                </table-std-cost-targets>
            </div>

        </div>

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

    </div>
                    
</template>

<script>

import VueNumeric from 'vue-numeric'
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import moment from 'moment';

import TableStdCostTargets from "./TableStdCostTargets";

export default {
    
    props: ["periodYearValue", "yearControl", "stdcostYear", "stdcostAccounts", "allocateTypes"],

    components: { Loading, VueNumeric, TableStdCostTargets },

    watch: {
        periodYearValue : function (value) {
            this.periodYear = value;
        },
        yearControl : function (value) {
            this.yearControlData = value;
        },
        stdcostYear : function (value) {
            this.stdcostYearData = value;
        },
        stdcostAccounts : function (value) {
            this.stdcostAccountItems = value.map(item => {
                return {
                    ...item,
                    marked_as_deleted: false,
                }
            });
        },
    },

    data() {

        return {

            periodYear: this.periodYearValue,
            yearControlData: this.yearControl,
            stdcostYearData: this.stdcostYear,
            selectedStdcostAccountItem: null,
            stdcostAccountItems: this.stdcostAccounts.map(item => {
                return {
                    ...item,
                    allocate_type_label: this.getAllocateTypeLabel(this.allocateTypes, item.allocate_type),
                    marked_as_deleted: false,
                }
            }),
            stdcostTargets: [],
            // stdcostTgPrdGroups: [],
            // stdcostTgItems: [],
            totalEstimateExpenseAmount: this.stdcostAccounts.reduce((pv, cv) => pv + (cv.estimate_expense_amount ? parseFloat(cv.estimate_expense_amount) : 0), 0),
            isLoading: false

        }

    },

    mounted() {

    },

    computed: {

    },
    methods: {

        async onGetStdcostTargets(stdcostAccountItem) {

            const resValidate = this.validateBeforeGetTargets(stdcostAccountItem);
            if(resValidate.valid) {

                this.stdcostTargets = [];
                // this.stdcostTgPrdGroups = [];
                // this.stdcostTgItems = [];

                this.selectedStdcostAccountItem = stdcostAccountItem;

                this.stdcostAccountItems = this.stdcostAccountItems.map(item => {
                    return {
                        ...item,
                    }
                });

                await this.getStdcostTargets(this.stdcostYearData, stdcostAccountItem);
                

            } else {
                swal("เกิดข้อผิดพลาด", `${resValidate.message}`, "error");
            }

        },

        getAllocateTypeLabel(listAllocateTypes, allocateTypeValue) {
            let result = "";
            if(listAllocateTypes.length > 0 && allocateTypeValue) {
                const foundAllocateType = listAllocateTypes.find(item => item.allocate_type_value == allocateTypeValue);
                result = foundAllocateType ? foundAllocateType.allocate_type_label : "";
            }
            return result
        },

        async getStdcostTargets(stdcostYearData, stdcostAccountItem) {

            // show loading
            this.isLoading = true;

            var params = { 
                period_year: this.periodYear,
                year_control: JSON.stringify(this.yearControlData),
                stdcost_year: JSON.stringify(stdcostYearData),
                stdcost_account: JSON.stringify(stdcostAccountItem),
            };

            await axios.get(`/ajax/ct/std-cost-papers/account-targets`, { params })
            .then(res => {

                const resData = res.data.data;
                if(resData.status == "success") {
                    this.stdcostTargets = resData.stdcost_targets ? JSON.parse(resData.stdcost_targets) : [];
                    if(this.stdcostTargets.length < 0) {
                        swal("เกิดข้อผิดพลาด", `ไม่พบข้อมูล รายการบัญชีที่ปัน ของ ค่าแรง/ค่าใช้จ่าย : ${stdcostAccountItem.account_type_desc} | ${resData.message}`, "error");
                    }
                    // this.stdcostTgPrdGroups = resData.stdcost_tg_prd_groups ? JSON.parse(resData.stdcost_tg_prd_groups) : [];
                    // this.stdcostTgItems = resData.stdcost_tg_items ? JSON.parse(resData.stdcost_tg_items) : [];
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

        validateBeforeGetTargets(stdcostAccountItem) {

            const result = {
                valid: true,
                message: "",
            };

            // if(!stdcostAccountItem.estimate_expense_amount) {
            //     result.valid = false;
            //     result.message = `กรอกข้อมูลรายการบัญชีที่รับปันไม่ครบถ้วน กรุณาตรวจสอบ`
            // }

            return result;

        },

        formatNumber(value) {
            let result = value.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return result;
        },

        isNumber: function(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                evt.preventDefault();;
            } else {
                return true;
            }
        }

    }

}

</script>