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
                            <input type="text" class="form-control input-sm" :value="stdcostHead ? stdcostHead.cost_group_desc : '-'" readonly>
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

            <!-- <div>
                <div class="btn-group" role="group">
                    <button type="button" @click="toggleShowTable('prd')" class="btn" v-bind:class="[isTablePrdActive ? 'btn-primary' : 'btn-white']"> ผลิตภัณฑ์ </button>
                    <button type="button" @click="toggleShowTable('item')" class="btn" v-bind:class="[isTableItemActive ? 'btn-primary' : 'btn-white']"> รายละเอียดวัตถุดิบ </button>
                </div>
            </div> -->

            <!-- <div v-if="isTablePrdActive"> -->
             <br>
            <div style="background-color: #d9d9d9; color: black;font-size: 16px; font-weight: bold;padding: 3px 5px 3px 5px ">
                ผลิตภัณฑ์ที่ยังไม่อนุมัติต้นทุนวัตถุดิบ
            </div>
            <div class="row tw-mb-5">
            </div>
            <table-std-cost-prds
                    :period-year-value="periodYear"
                    :allocate-types="allocateTypes"
                    :stdcost-head="stdcostHead"
                    :stdcost-prds="stdcostPrdsNot"
                    :stdcost-materials="stdcostMaterials"
                >
                </table-std-cost-prds>

            <hr>
            <br>
             <div style="background-color: #d9d9d9; color: black;font-size: 16px; font-weight: bold;padding: 3px 5px 3px 5px ">
                ผลิตภัณฑ์ที่อนุมัติต้นทุนวัตถุดิบแล้ว
             </div>
             <div class="row tw-mb-5">
             </div>
            <div>

                <table-std-cost-prds
                    :period-year-value="periodYear"
                    :allocate-types="allocateTypes"
                    :stdcost-head="stdcostHead"
                    :stdcost-prds="stdcostPrds"
                    :stdcost-materials="stdcostMaterials"
                >
                </table-std-cost-prds>

            </div>

            <!-- <div v-if="isTableItemActive">

                <table-std-cost-items
                    :period-year-value="periodYear"
                    :allocate-types="allocateTypes"
                    :stdcost-head="stdcostHead"
                    :stdcost-materials="stdcostMaterials"
                >
                </table-std-cost-items>

            </div> -->

        </div>

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

    </div>

</template>

<script>

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import moment from 'moment';

import TableStdCostPrds from "./TableStdCostPrds";
// import TableStdCostItems from "./TableStdCostItems";

export default {

    components: { Loading, TableStdCostPrds },

    props: [ "defaultData", "periodYearData", "periodFrom", "periodTo", "allocateTypes", "yearControl", "stdcostHead", "stdcostPrds", "stdcostPrdsNot", "stdcostMaterials" ],

    mounted() {

        if(!this.yearControl) {
            swal("เกิดข้อผิดพลาด", `ไม่พบข้อมูลต้นทุนมาตรฐาน วัตถุดิบ , กรุณาตรวจสอบอีกครั้ง`, "error");
        } else {
            if(!this.stdcostHead) {
                swal("เกิดข้อผิดพลาด", `ไม่พบข้อมูลต้นทุนมาตรฐาน วัตถุดิบ ปีบัญชีงบประมาณ: ${this.periodYearLabel}, แผนการผลิตครั้งที่: ${this.yearControl.plan_version_no}, ศูนย์ต้นทุน: ${this.yearControl.cost_code} ${this.yearControl.cost_description}, กรุณาตรวจสอบอีกครั้ง`, "error");
            }
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

            periodYear: this.periodYearData.period_year,
            periodYearLabel: this.periodYearData.period_year_thai,

            // isTablePrdActive: true,
            // isTableItemActive: false,

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

        // toggleShowTable(showTable) {

        //     this.isTablePrdActive = false;
        //     this.isTableItemActive = false;

        //     this.$nextTick(() => {
        //         if(showTable == 'prd'){ this.isTablePrdActive = true; }
        //         if(showTable == 'item'){ this.isTableItemActive = true; }
        //     });

        // },

        formatDateTh(date) {
            return date ? moment(date).add(543, 'years').format('DD/MM/YYYY') : ""
        },

    }

}

</script>
