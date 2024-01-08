<template>
    <div class="row">
        <label class="col-md-2 col-form-label required"> สถานะการลงผล </label>
        <div class="col-md-7 md:tw-pr-20 tw-pr-4">
            <div class="row">
                <div class="col-md-3 md:tw-pr-0 tw-pr-4">
                    <qm-el-checkbox name="pending_sample_operation_status" id="input_pending_sample_operation_status" label="ยังไม่ลงผล" input-class="tw-w-full tw-bg-yellow-200" @change="onPendingSampleOperationStatusChanged" :value="pendingSampleOperationStatusChecked" />
                </div>
                <div class="col-md-3 md:tw-pr-0 tw-pr-4">
                    <qm-el-checkbox name="inprogress_sample_operation_status" id="input_inprogress_sample_operation_status" label="อยู่ระหว่างลงผล" input-class="tw-w-full tw-bg-yellow-400" @change="onCorrectSampleOperationStatusChanged" :value="inprogressSampleOperationStatusChecked" />
                </div>
                <div class="col-md-3 md:tw-pr-0 tw-pr-4">
                    <qm-el-checkbox name="completed_sample_operation_status" id="input_completed_sample_operation_status" label="ลงผลเสร็จแล้ว" input-class="tw-w-full tw-bg-green-300" @change="onCompletedSampleOperationStatusChanged" :value="completedSampleOperationStatusChecked" />
                </div>
                <div class="col-md-3 md:tw-pr-0 tw-pr-4">
                    <qm-el-checkbox name="rejected_sample_operation_status" id="input_rejected_sample_operation_status" label="ปฏิเสธผล" input-class="tw-w-full tw-bg-yellow-600" @change="onRejectedSampleOperationStatusChanged" :value="rejectedSampleOperationStatusChecked" />
                </div>
            </div>
        </div>
        <div class="col-md-2 md:tw-pr-0 tw-pr-4">
            <qm-el-checkbox name="select_all_sample_operation_status" id="input_select_all_sample_operation_status" label="เลือกสถานะทั้งหมด" input-class="tw-w-full tw-bg-blue-200" @change="onSelectAllChanged" :value="selectAllChecked" />
        </div>
    </div>
</template>

<script>
export default {
    props: [
        "pendingSampleOperationStatusValue",
        "inprogressSampleOperationStatusValue",
        "completedSampleOperationStatusValue",
        "rejectedSampleOperationStatusValue",
        "selectAllValue"
    ],

    data() {
        return {
            pendingSampleOperationStatusChecked: this.pendingSampleOperationStatusValue,
            inprogressSampleOperationStatusChecked: this.inprogressSampleOperationStatusValue,
            completedSampleOperationStatusChecked: this.completedSampleOperationStatusValue,
            rejectedSampleOperationStatusChecked: this.rejectedSampleOperationStatusValue,
            selectAllChecked:this.selectAllValue 
        };
    },

    methods: {
        onPendingSampleOperationStatusChanged(value) {
            this.pendingSampleOperationStatusChecked = value;
            this.refreshSelectAllValue();
        },
        onCorrectSampleOperationStatusChanged(value) {
            this.inprogressSampleOperationStatusChecked = value;
            this.refreshSelectAllValue();
        },
        onCompletedSampleOperationStatusChanged(value) {
            this.completedSampleOperationStatusChecked = value;
            this.refreshSelectAllValue();
        },
        onRejectedSampleOperationStatusChanged(value) {
            this.rejectedSampleOperationStatusChecked = value;
            this.refreshSelectAllValue();
        },
        refreshSelectAllValue() {
            if(this.pendingSampleOperationStatusChecked == true && this.inprogressSampleOperationStatusChecked == true && this.completedSampleOperationStatusChecked == true && this.rejectedSampleOperationStatusChecked == true) {
                this.selectAllChecked = true;
            }else{
                this.selectAllChecked = false;
            }
        },
        onSelectAllChanged(value) {
            this.pendingSampleOperationStatusChecked = value;
            this.inprogressSampleOperationStatusChecked = value;
            this.completedSampleOperationStatusChecked = value;
            this.rejectedSampleOperationStatusChecked = value;
        }
    }
};
</script>
