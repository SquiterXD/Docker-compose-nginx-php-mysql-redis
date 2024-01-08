<template>

    <div>

        <div>
            <div class="btn-group" role="group">
                <button type="button" @click="toggleShowTable('target')" class="btn" v-bind:class="[isTableTargetActive ? 'btn-primary' : 'btn-white']"> รายการบัญชีที่ปัน </button>
                <button type="button" @click="toggleShowTable('tgPrdGroup')" class="btn" v-bind:class="[isTableTgPrdGroupActive ? 'btn-primary' : 'btn-white']"> กลุ่มผลิตภัณฑ์ </button>
                <button type="button" @click="toggleShowTable('tgItem')" class="btn" v-bind:class="[isTableTgItemActive ? 'btn-primary' : 'btn-white']"> ผลิตภัณฑ์ </button>
            </div>
        </div>

        <div v-if="isTableTargetActive" class="table-responsive" style="max-height: 300px;">

            <table class="table table-bordered table-sticky mb-0">
                <thead>
                    <tr>
                        <!-- <th width="10%" style="background-color: #fff0e0; border-left: 0px; border-right: 0px;" class="text-center tw-text-xs md:tw-table-cell"> ศูนย์ต้นทุน </th> -->
                        <th width="10%" style="background-color: #fff0e0; border-left: 0px; border-right: 0px;" class="text-center tw-text-xs md:tw-table-cell"> ค่าแรง/ค่าใช้จ่าย </th>
                        <th width="8%" style="background-color: #fff0e0; border-left: 0px; border-right: 0px;" class="text-center tw-text-xs md:tw-table-cell"> รหัสบัญชี </th>
                        <th width="12%" style="background-color: #fff0e0; border-left: 0px; border-right: 0px;" class="text-center tw-text-xs md:tw-table-cell tw-hidden"> ชื่อบัญชี </th>
                        <th width="10%" style="background-color: #fff0e0; border-left: 0px; border-right: 0px;" class="text-center tw-text-xs md:tw-table-cell tw-hidden"> เกณฑ์การปันส่วน </th>
                        <th width="13%" style="background-color: #fff0e0; border-left: 0px; border-right: 0px;" class="text-right tw-text-xs md:tw-table-cell"> ค่าแรง/ใช้จ่ายจริง (บาท) </th>
                        <th width="10%" style="background-color: #fff0e0; border-left: 0px; border-right: 0px;" class="text-right tw-text-xs md:tw-table-cell"> ค่าใช้จ่ายจริงเฉลี่ย </th>
                        <th width="13%" style="background-color: #fff0e0; border-left: 0px; border-right: 0px;" class="text-right tw-text-xs md:tw-table-cell"> ค่าแรง/ใช้จ่ายตามงบประมาณ (บาท) </th>
                        <th width="13%" style="background-color: #fff0e0; border-left: 0px; border-right: 0px;" class="text-right tw-text-xs md:tw-table-cell"> ค่าแรง/ใช้จ่ายประมาณการ (บาท) </th>
                        <th width="10%" style="background-color: #fff0e0; border-left: 0px; border-right: 0px;" class="text-right tw-text-xs md:tw-table-cell"></th>
                    </tr>
                </thead>
                <tbody v-if="stdcostTargetItems.length > 0">
                    <template v-for="(stdcostTargetItem, index) in stdcostTargetItems">

                        <tr :key="index">

                            <!-- <td style="border-left: 0; border-right: 0;" class="text-center md:tw-table-cell">
                                {{ stdcostTargetItem.cost_code }}
                            </td> -->
                            <td style="border-left: 0; border-right: 0;" class="text-left md:tw-table-cell">
                                {{ stdcostTargetItem.account_type_desc }}
                            </td>
                            <td style="border-left: 0; border-right: 0;" class="text-center md:tw-table-cell">
                                {{ stdcostTargetItem.account_code }}
                            </td>
                            <td style="border-left: 0; border-right: 0;" class="text-left md:tw-table-cell tw-hidden">
                                {{ stdcostTargetItem.account_desc }}
                            </td>
                            <td style="border-left: 0; border-right: 0;" class="text-left md:tw-table-cell tw-hidden">
                                {{ stdcostTargetItem.allocate_type_desc }}
                            </td>
                            <td style="border-left: 0; border-right: 0;" class="text-right md:tw-table-cell">
                                {{ stdcostTargetItem.acc_actual_amount ? Number(stdcostTargetItem.acc_actual_amount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "0.00" }} 
                            </td>
                            <td style="border-left: 0; border-right: 0;" class="text-right md:tw-table-cell">
                                {{ stdcostTargetItem.acc_avg_actual_amount ? Number(stdcostTargetItem.acc_avg_actual_amount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "0.00" }} 
                            </td>
                            <td style="border-left: 0; border-right: 0;" class="text-right md:tw-table-cell">
                                {{ stdcostTargetItem.acc_budget_amount ? Number(stdcostTargetItem.acc_budget_amount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "0.00" }} 
                            </td>
                            <td style="border-left: 0; border-right: 0;" class="text-right md:tw-table-cell">
                                {{ stdcostTargetItem.acc_estimate_expense_amount ? Number(stdcostTargetItem.acc_estimate_expense_amount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "0.00" }} 
                            </td>
                            <td class="text-center text-nowrap">
                               <button class="btn btn-inline-block btn-xs btn-white"
                                    @click="onGetStdcostTgPrdGroups(stdcostTargetItem)"
                                > 
                                    <i class="fa fa-list tw-mr-1"></i> กลุ่มผลิตภัณฑ์
                                </button>
                            </td>

                        </tr>

                    </template>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="9">
                            <h2 class="p-5 text-center text-muted"> กรุณาเลือก ค่าแรง/ค่าใช้จ่าย </h2>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>

        <div v-if="isTableTgPrdGroupActive" class="table-responsive" style="max-height: 300px;">

            <table class="table table-bordered table-sticky mb-0">
                <thead>
                    <tr>
                        <th width="15%" colspan="2" style="background-color: #fff0e0; border-left: 0px; border-right: 0px;" class="text-center tw-text-xs md:tw-table-cell"> กลุ่มผลิตภัณฑ์ </th>
                        <th width="10%" style="background-color: #fff0e0; border-left: 0px; border-right: 0px;" class="text-right tw-text-xs md:tw-table-cell tw-hidden">  สัดส่วน % </th>
                        <th width="15%" style="background-color: #fff0e0; border-left: 0px; border-right: 0px;" class="text-right tw-text-xs md:tw-table-cell"> ค่าแรง/ใช้จ่าย ประมาณการ (บาท) </th>
                        <th width="15%" style="background-color: #fff0e0; border-left: 0px; border-right: 0px;" class="text-right tw-text-xs md:tw-table-cell"> ปริมาณผลผลิตมาตรฐาน (ชิ้น/กิโลกรัม/ตร.ซม.) </th>
                        <th width="30%" style="background-color: #fff0e0; border-left: 0px; border-right: 0px;" class="text-right tw-text-xs md:tw-table-cell"> ค่าประมาณการ(บาท) ต่อหนึ่งหน่วย </th>
                        <th width="10%" style="background-color: #fff0e0; border-left: 0px; border-right: 0px;" class="text-right tw-text-xs md:tw-table-cell"></th>
                    </tr>
                </thead>
                <tbody v-if="stdcostTgPrdGroups.length > 0">
                    <template v-for="(stdcostTgPrdGroupItem, index) in stdcostTgPrdGroups">

                        <tr :key="index">

                            <td style="border-left: 0; border-right: 0;" class="text-center md:tw-table-cell">
                                {{ stdcostTgPrdGroupItem.product_group }}
                            </td>
                            <td style="border-left: 0; border-right: 0;" class="text-left md:tw-table-cell">
                                {{ stdcostTgPrdGroupItem.product_group_desc }}
                            </td>
                            <td style="border-left: 0; border-right: 0;" class="text-right md:tw-table-cell tw-hidden">
                                {{ stdcostTgPrdGroupItem.ratio_rate }}
                            </td>
                            <td style="border-left: 0; border-right: 0;" class="text-right md:tw-table-cell">
                                {{ stdcostTgPrdGroupItem.prd_estimate_expense_amount ? Number(stdcostTgPrdGroupItem.prd_estimate_expense_amount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "0.00" }} 
                            </td>
                            <td style="border-left: 0; border-right: 0;" class="text-right md:tw-table-cell">
                                {{ stdcostTgPrdGroupItem.prd_productivity_qty ? Number(stdcostTgPrdGroupItem.prd_productivity_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "0.00" }} 
                            </td>
                            <td style="border-left: 0; border-right: 0;" class="text-right md:tw-table-cell">
                                {{ stdcostTgPrdGroupItem.prd_estimate_per_unit ? Number(stdcostTgPrdGroupItem.prd_estimate_per_unit).toLocaleString(undefined, {minimumFractionDigits: 9,maximumFractsionDigits: 9}) : "0.000000000" }} 
                            </td>
                            <td class="text-center text-nowrap">
                               <button class="btn btn-inline-block btn-xs btn-white"
                                    @click="onGetStdcostTgItems(stdcostTgPrdGroupItem)"
                                > 
                                    <i class="fa fa-list tw-mr-1"></i> ผลิตภัณฑ์
                                </button>
                            </td>

                        </tr>

                    </template>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="8">
                            <h2 class="p-5 text-center text-muted"> กรุณาเลือก รายการบัญชีที่ปัน </h2>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>

        <div v-if="isTableTgItemActive" class="table-responsive" style="max-height: 300px;">

            <table class="table table-bordered table-sticky mb-0">
                <thead>
                    <tr>
                        <th width="10%" style="background-color: #fff0e0; border-left: 0px; border-right: 0px;" class="text-center tw-text-xs md:tw-table-cell"> ผลิตภัณฑ์ </th>
                        <th width="20%" style="background-color: #fff0e0; border-left: 0px; border-right: 0px;" class="text-center tw-text-xs md:tw-table-cell"> รายละเอียด </th>
                        <!-- <th width="10%" style="background-color: #fff0e0; border-left: 0px; border-right: 0px;" class="text-center tw-text-xs md:tw-table-cell"> Product Lot Number </th> -->
                        <th width="10%" style="background-color: #fff0e0; border-left: 0px; border-right: 0px;" class="text-right tw-text-xs md:tw-table-cell tw-hidden">  สัดส่วน % </th>
                        <th width="15%" style="background-color: #fff0e0; border-left: 0px; border-right: 0px;" class="text-right tw-text-xs md:tw-table-cell"> ค่าแรง/ใช้จ่าย ประมาณการ (บาท) </th>
                        <th width="15%" style="background-color: #fff0e0; border-left: 0px; border-right: 0px;" class="text-right tw-text-xs md:tw-table-cell"> ปริมาณผลผลิตมาตรฐาน (ชิ้น/กิโลกรัม/ตร.ซม.) </th>
                        <th width="30%" style="background-color: #fff0e0; border-left: 0px; border-right: 0px;" class="text-right tw-text-xs md:tw-table-cell"> ค่าประมาณการ(บาท) ต่อหนึ่งหน่วย </th>
                    </tr>
                </thead>
                <tbody v-if="stdcostTgItems.length > 0">
                    <template v-for="(stdcostTgItem, index) in stdcostTgItems">

                        <tr :key="index">

                            <td style="border-left: 0; border-right: 0;" class="text-center md:tw-table-cell">
                                {{ stdcostTgItem.product_item_number }}
                            </td>
                            <td style="border-left: 0; border-right: 0;" class="text-left md:tw-table-cell">
                                {{ stdcostTgItem.product_item_desc }}
                            </td>
                            <!-- <td style="border-left: 0; border-right: 0;" class="text-center md:tw-table-cell">
                                {{ stdcostTgItem.product_lot_number }}
                            </td> -->
                            <td style="border-left: 0; border-right: 0;" class="text-right md:tw-table-cell tw-hidden">
                                {{ stdcostTgItem.ratio_rate }}
                            </td>
                            <td style="border-left: 0; border-right: 0;" class="text-right md:tw-table-cell">
                                {{ stdcostTgItem.item_estimate_expense_amount ? Number(stdcostTgItem.item_estimate_expense_amount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "0.00" }} 
                            </td>
                            <td style="border-left: 0; border-right: 0;" class="text-right md:tw-table-cell">
                                {{ stdcostTgItem.item_productivity_qty ? Number(stdcostTgItem.item_productivity_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "0.00" }} 
                            </td>
                            <td style="border-left: 0; border-right: 0;" class="text-right md:tw-table-cell">
                                {{ stdcostTgItem.item_estimate_per_unit ? Number(stdcostTgItem.item_estimate_per_unit).toLocaleString(undefined, {minimumFractionDigits: 9,maximumFractionDigits: 9}) : "0.000000000" }} 
                            </td>

                        </tr>

                    </template>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="8">
                            <h2 class="p-5 text-center text-muted"> กรุณาเลือก กลุ่มผลิตภัณฑ์ </h2>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

    </div>
                    
</template>

<script>

import VueNumeric from 'vue-numeric'
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import moment from 'moment';

export default {
    
    props: ["periodYearValue", "yearControl", "stdcostYear", "stdcostAccount", "stdcostTargets"],

    components: { Loading, VueNumeric },

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
        stdcostAccount : function (value) {
            this.stdcostAccountData = value;
        },
        stdcostTargets : function (value) {
            this.stdcostTargetItems = value;
            this.stdcostTgPrdGroups = [];
            this.stdcostTgItems = [];
            if(this.stdcostTargetItems.length == 1) {
                this.getStdcostTgPrdGroups(this.stdcostTargetItems[0]);
            }
        },
    },

    data() {

        return {

            periodYear: this.periodYearValue,
            yearControlData: this.yearControl,
            stdcostYearData: this.stdcostYear,
            stdcostAccountData: this.stdcostAccount,
            stdcostTargetItems: this.stdcostTargets,
            stdcostTgPrdGroups: [],
            stdcostTgItems: [],
            isTableTargetActive: true,
            isTableTgItemActive: false,
            isTableTgPrdGroupActive: false,
            isLoading: false

        }

    },

    mounted() {

        // this.emitStdcostTargetsChanged();

    },

    computed: {

    },
    methods: {

        toggleShowTable(showTable) {

            this.isTableTargetActive = false;
            this.isTableTgItemActive = false;
            this.isTableTgPrdGroupActive = false;

            this.$nextTick(() => {
                if(showTable == 'target'){ this.isTableTargetActive = true; }
                if(showTable == 'tgItem'){ this.isTableTgItemActive = true; }
                if(showTable == 'tgPrdGroup'){ this.isTableTgPrdGroupActive = true; }
            });

        },

        async onGetStdcostTgPrdGroups(stdcostTarget) {
            await this.getStdcostTgPrdGroups(stdcostTarget);
            if(this.stdcostTgPrdGroups.length > 0) {
                this.toggleShowTable('tgPrdGroup');
            }
        },

        async getStdcostTgPrdGroups(stdcostTarget) {

            const stdcostYear = this.stdcostYearData;
            const stdcostAccount = this.stdcostAccountData;

            // show loading
            this.isLoading = true;

            var params = { 
                period_year: this.periodYear,
                year_control: JSON.stringify(this.yearControlData),
                stdcost_year: JSON.stringify(stdcostYear),
                stdcost_account: JSON.stringify(stdcostAccount),
                stdcost_target: JSON.stringify(stdcostTarget),
            };

            await axios.get(`/ajax/ct/std-cost-papers/account-targets/tg-prd-groups`, { params })
            .then(res => {

                const resData = res.data.data;
                if(resData.status == "success") {
                    this.stdcostTgPrdGroups = resData.stdcost_tg_prd_groups ? JSON.parse(resData.stdcost_tg_prd_groups) : [];
                    this.stdcostTgItems = [];
                    if(this.stdcostTgPrdGroups.length <= 0) {
                        swal("เกิดข้อผิดพลาด", `ไม่พบข้อมูล กลุ่มผลิตภัณฑ์ ของ รหัสบัญชี : ${stdcostTarget.account_code} ${stdcostTarget.account_desc} | ${resData.message}`, "error");
                    } else {
                        if(this.stdcostTgPrdGroups.length == 1) {
                            this.getStdcostTgItems(this.stdcostTgPrdGroups[0]);
                        }
                    }
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

        async onGetStdcostTgItems(stdcostTgPrdGroup) {
            await this.getStdcostTgItems(stdcostTgPrdGroup);
            if(this.stdcostTgItems.length > 0) {
                this.toggleShowTable('tgItem');
            }
        },

        async getStdcostTgItems(stdcostTgPrdGroup) {

            const stdcostYear = this.stdcostYearData;
            const stdcostAccount = this.stdcostAccountData;

            // show loading
            this.isLoading = true;

            var params = { 
                period_year: this.periodYear,
                year_control: JSON.stringify(this.yearControlData),
                stdcost_year: JSON.stringify(stdcostYear),
                stdcost_account: JSON.stringify(stdcostAccount),
                stdcost_tg_prd_group: JSON.stringify(stdcostTgPrdGroup),
            };

            await axios.get(`/ajax/ct/std-cost-papers/account-targets/tg-items`, { params })
            .then(res => {

                const resData = res.data.data;
                if(resData.status == "success") {
                    this.stdcostTgItems = resData.stdcost_tg_items ? JSON.parse(resData.stdcost_tg_items) : [];
                    if(this.stdcostTgItems.length <= 0) {
                        swal("เกิดข้อผิดพลาด", `ไม่พบข้อมูล ผลิตภัณฑ์ ของ กลุ่มผลิตภัณฑ์ : ${stdcostTgPrdGroup.product_group} ${stdcostTgPrdGroup.product_group_desc} | ${resData.message}`, "error");
                    }
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