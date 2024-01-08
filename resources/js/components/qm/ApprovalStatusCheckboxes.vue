<template>
    <div class="row">
        <label class="col-sm-2 col-form-label required"> สถานะการอนุมัติ </label>
        <div class="col-md-7 md:tw-pr-20 tw-pr-4">
            <div class="row">
                <div class="col-md-3 md:tw-pr-0 tw-pr-4">
                    <qm-el-checkbox name="pending_approval_status" id="input_pending_approval_status" label="รอการอนุมัติ" input-class="tw-w-full tw-bg-yellow-200" @change="onPendingApprovalStatusChanged" :value="pendingApprovalStatusChecked" />
                </div>
                <div class="col-md-3 md:tw-pr-0 tw-pr-4">
                    <qm-el-checkbox name="approved_approval_status" id="input_approved_approval_status" label="อนุมัติแล้ว" input-class="tw-w-full tw-bg-green-300" @change="onApprovedApprovalStatusChanged" :value="approvedApprovalStatusChecked" />
                </div>
                <div class="col-md-3 md:tw-pr-0 tw-pr-4">
                    <qm-el-checkbox name="rejected_approval_status" id="input_rejected_approval_status" label="ปฏิเสธผล" input-class="tw-w-full tw-bg-red-300" @change="onRejectedApprovalStatusChanged" :value="rejectedApprovalStatusChecked" />
                </div>
            </div>
        </div>
        <div class="col-md-2 md:tw-pr-0 tw-pr-4">
            <qm-el-checkbox name="select_all_approval_status" id="input_select_all_approval_status" label="เลือกสถานะทั้งหมด" input-class="tw-w-full tw-bg-blue-200" @change="onSelectAllChanged" :value="selectAllChecked" />
        </div>
    </div>
</template>

<script>
export default {
    props: [
        "pendingApprovalStatusValue",
        "approvedApprovalStatusValue",
        "rejectedApprovalStatusValue",
        "selectAllValue"
    ],

    data() {
        return {
            pendingApprovalStatusChecked: this.pendingApprovalStatusValue,
            approvedApprovalStatusChecked: this.approvedApprovalStatusValue,
            rejectedApprovalStatusChecked: this.rejectedApprovalStatusValue,
            selectAllChecked:this.selectAllValue 
        };
    },

    methods: {
        onPendingApprovalStatusChanged(value) {
            this.pendingApprovalStatusChecked = value;
            this.refreshSelectAllValue();
        },
        onApprovedApprovalStatusChanged(value) {
            this.approvedApprovalStatusChecked = value;
            this.refreshSelectAllValue();
        },
        onRejectedApprovalStatusChanged(value) {
            this.rejectedApprovalStatusChecked = value;
            this.refreshSelectAllValue();
        },
        refreshSelectAllValue() {
            if(this.pendingApprovalStatusChecked == true && this.approvedApprovalStatusChecked == true && this.rejectedApprovalStatusChecked == true) {
                this.selectAllChecked = true;
            }else{
                this.selectAllChecked = false;
            }
        },
        onSelectAllChanged(value) {
            this.pendingApprovalStatusChecked = value;
            this.approvedApprovalStatusChecked = value;
            this.rejectedApprovalStatusChecked = value;
        }
    }
};
</script>
