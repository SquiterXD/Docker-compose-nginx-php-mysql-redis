<template>

    <div>

        <div class="table-responsive" style="max-height: 600px;">
            <table class="table table-bordered table-sticky mb-0">
                <thead>
                    <tr>
                        <th width="10%" class="text-center tw-text-xs md:tw-table-cell"> ปีบัญชีงบประมาณ </th>
                        <th width="7%" class="text-center tw-text-xs md:tw-table-cell"> แผนผลิตครั้งที่ </th>
                        <th width="8%" class="text-center tw-text-xs md:tw-table-cell"> ครั้งที่ </th>
                        <th width="20%" class="text-center tw-text-xs md:tw-table-cell"> ศูนย์ต้นทุน </th>
                        <th width="12%" class="text-center tw-text-xs md:tw-table-cell"> วันที่เริ่มใช้อัตรามาตรฐาน </th>
                        <th width="12%" class="text-center tw-text-xs md:tw-table-cell"> วันที่สิ้นสุดอัตรามาตรฐาน </th>
                        <th width="10%" class="text-center tw-text-xs md:tw-table-cell"> สถานะ </th>
                        <th width="35%"></th>
                    </tr>
                </thead>
                <tbody v-if="yearControlItems.length > 0">
                    <template v-for="(yearControlItem, index) in yearControlItems">

                        <tr :key="index" v-if="yearControlItem.is_showed">

                            <td class="text-center md:tw-table-cell">
                                {{ yearControlItem.period_year_thai }}
                            </td>
                            <td class="text-center md:tw-table-cell">
                                {{ yearControlItem.plan_version_no }}
                            </td>
                            <td class="text-center md:tw-table-cell">
                                <!-- {{ yearControlItem.version_no }} -->
                                {{ yearControlItem.ct14_last_version_no }}
                            </td>
                            <td class="text-left md:tw-table-cell">
                                {{ yearControlItem.cost_code }} : {{ yearControlItem.cost_description }}
                            </td>
                            <td class="text-center md:tw-table-cell">
                                {{ yearControlItem.start_date_thai }}
                            </td>
                            <td class="text-center md:tw-table-cell">
                                {{ yearControlItem.end_date_thai }}
                            </td>
                            <td class="text-center md:tw-table-cell">
                                {{ yearControlItem.approved_status ? getApprovedStatusLabel(yearControlItem.approved_status) : "" }}
                            </td>
                            <td class="text-center text-nowrap">
                               <a :href="`/ct/std-cost-papers/materials?period_year=${yearControlItem.period_year}&prdgrp_year_id=${yearControlItem.prdgrp_year_id}&cost_code=${yearControlItem.cost_code}&plan_version_no=${yearControlItem.plan_version_no}&version_no=${yearControlItem.version_no ? yearControlItem.version_no : ''}&ct14_last_version_no=${yearControlItem.ct14_last_version_no ? yearControlItem.ct14_last_version_no : ''}`" target="_blank" class="btn btn-inline-block btn-xs btn-white"> วัตถุดิบ </a>
                               <a :href="`/ct/std-cost-papers/account-targets?period_year=${yearControlItem.period_year}&prdgrp_year_id=${yearControlItem.prdgrp_year_id}&cost_code=${yearControlItem.cost_code}&plan_version_no=${yearControlItem.plan_version_no}&version_no=${yearControlItem.version_no ? yearControlItem.version_no : ''}&ct14_last_version_no=${yearControlItem.ct14_last_version_no ? yearControlItem.ct14_last_version_no : ''}`" target="_blank" class="btn btn-inline-block btn-xs btn-white tw-ml-2"> ค่าแรง/ใช้จ่าย </a>
                               <a :href="`/ct/std-cost-papers/summarizes?period_year=${yearControlItem.period_year}&prdgrp_year_id=${yearControlItem.prdgrp_year_id}&cost_code=${yearControlItem.cost_code}&plan_version_no=${yearControlItem.plan_version_no}&version_no=${yearControlItem.version_no ? yearControlItem.version_no : ''}&ct14_last_version_no=${yearControlItem.ct14_last_version_no ? yearControlItem.ct14_last_version_no : ''}`" target="_blank" class="btn btn-inline-block btn-xs btn-white tw-ml-2"> สรุปต้นทุน </a>
                               <button class="btn btn-inline-block btn-xs btn-primary btn-outline tw-w-20"
                                    @click="onShowModalApprovalYearControl(yearControlItem)">
                                    สถานะ 
                                </button>
                            </td>

                        </tr>

                    </template>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="8">
                            <h2 class="p-5 text-center text-muted">ไม่พบข้อมูล</h2>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

        <!-- MODAL APPROVAL YEAR CONTROL -->
        <modal-approval-year-control 
            modal-name="modal-approval-year-control" 
            modal-width="640" 
            modal-height="auto"
            :year-control-item="selectedYearControl"
            :approved-statuses="approvedStatuses"
            @onSaveApprovedStatus="onSaveApprovedStatus"
        >
        </modal-approval-year-control>

    </div>
                    
</template>

<script>

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import moment from 'moment';

import ModalApprovalYearControl from "./ModalApprovalYearControl";

export default {
    
    props: ["yearControls"],

    components: { Loading, ModalApprovalYearControl },

    watch: {

        yearControls: function (data) {
            
            this.yearControlItems = data.map(item => {
                return {
                    ...item,
                    period_year_thai: item.period_year ? parseInt(item.period_year) + 543 : ""
                }
            });
            
        },

    },

    data() {

        return {

            yearControlItems: this.yearControls.map(item => {
                return {
                    ...item,
                    period_year_thai: item.period_year ? parseInt(item.period_year) + 543 : ""
                }
            }),
            selectedYearControl: null,
            approvedStatuses: [
                { value: "Active", label: "อนุมัติ"},
                { value: "Inactive", label: "ไม่อนุมัติ"}
            ],
            isLoading: false

        }

    },

    mounted() {

        // this.emitStdcostAccountsChanged();

    },

    computed: {

    },
    methods: {

        getApprovedStatusLabel(approvedStatus) {
            const foundApprovedStatus = this.approvedStatuses.find(item => item.value == approvedStatus);
            return foundApprovedStatus ? foundApprovedStatus.label : "";
        },

        onShowModalApprovalYearControl(yearControlItem) {
            // console.log(yearControlItem);
            this.selectedYearControl = yearControlItem;
            this.$modal.show("modal-approval-year-control");
        },

        async onSaveApprovedStatus(data) {
            
            // SAVE TO DB
            const reqBody = {
                period_year: this.selectedYearControl.period_year,
                prdgrp_year_id: this.selectedYearControl.prdgrp_year_id,
                allocate_year_id: this.selectedYearControl.allocate_year_id,
                cost_code: this.selectedYearControl.cost_code,
                plan_version_no: this.selectedYearControl.plan_version_no,
                version_no: this.selectedYearControl.version_no,
                ct14_version_no: this.selectedYearControl.ct14_last_version_no,
                ct14_allocate_year_id: this.selectedYearControl.ct14_allocate_year_id,
                approved_status: data.approved_status,
            };

            // SHOW LOADING
            this.isLoading = true;

            // call store sample result
            await axios.post(`/ajax/ct/std-cost-papers/approved-status`, reqBody)
            .then(res => {

                const resData = res.data.data;
                const resMsg = resData.message;
                const resYearControl = resData.year_control ? JSON.parse(resData.year_control) : null;

                if(resData.status == "success") {
                    if(resYearControl) {
                        this.selectedYearControl.approved_status = resYearControl.approved_status;
                    }
                }

                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `บันทึกข้อมูลสถานะไม่สำเร็จ | ${resMsg}`, "error");
                }
                
                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `บันทึกข้อมูลสถานะไม่สำเร็จ | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

        }

    }

}

</script>