<template>
    <div class="row">
        <label class="col-md-2 col-form-label required"> สถานะผลการทดสอบ </label>
        <div class="col-md-7 md:tw-pr-20 tw-pr-4">
            <div class="row">
                <div class="col-md-3 md:tw-pr-0 tw-pr-4">
                    <qm-el-checkbox name="pending_sample_result_status" id="input_pending_sample_result_status" label="ผลยังไม่ออก" input-class="tw-w-full tw-bg-yellow-200" @change="onPendingSampleResultStatusChanged" :value="pendingSampleResultStatusChecked" />
                </div>
                <div class="col-md-3 md:tw-pr-0 tw-pr-4">
                    <qm-el-checkbox name="conform_sample_result_status" id="input_conform_sample_result_status" label="ผลทดสอบปกติ" input-class="tw-w-full tw-bg-green-300" @change="onConformSampleResultStatusChanged" :value="conformSampleResultStatusChecked" />
                </div>
                <div class="col-md-3 md:tw-pr-0 tw-pr-4">
                    <qm-el-checkbox name="nonconform_sample_result_status" id="input_nonconform_sample_result_status" label="พบค่าความผิดปกติ" input-class="tw-w-full tw-bg-blue-400" @change="onNonconformSampleResultStatusChanged" :value="nonconformSampleResultStatusChecked" />
                </div>
                <div class="col-md-3 md:tw-pr-0 tw-pr-4">
                    <qm-el-checkbox name="rejected_sample_result_status" id="input_rejected_sample_result_status" label="ปฏิเสธผล" input-class="tw-w-full tw-bg-yellow-600" @change="onRejectedSampleResultStatusChanged" :value="rejectedSampleResultStatusChecked" />
                </div>
            </div>
        </div>
        <div class="col-md-2 md:tw-pr-0 tw-pr-4">
            <qm-el-checkbox name="select_all_sample_result_status" id="input_select_all_sample_result_status" label="เลือกสถานะทั้งหมด" input-class="tw-w-full tw-bg-blue-200" @change="onSelectAllChanged" :value="selectAllChecked" />
        </div>
    </div>
</template>

<script>
export default {
    props: [
        "pendingSampleResultStatusValue",
        "conformSampleResultStatusValue",
        "nonconformSampleResultStatusValue",
        "rejectedSampleResultStatusValue",
        "selectAllValue"
    ],

    data() {
        return {
            pendingSampleResultStatusChecked: this.pendingSampleResultStatusValue,
            conformSampleResultStatusChecked: this.conformSampleResultStatusValue,
            nonconformSampleResultStatusChecked: this.nonconformSampleResultStatusValue,
            rejectedSampleResultStatusChecked: this.rejectedSampleResultStatusValue,
            selectAllChecked:this.selectAllValue 
        };
    },

    methods: {
        onPendingSampleResultStatusChanged(value) {
            this.pendingSampleResultStatusChecked = value;
            this.refreshSelectAllValue();
        },
        onConformSampleResultStatusChanged(value) {
            this.conformSampleResultStatusChecked = value;
            this.refreshSelectAllValue();
        },
        onNonconformSampleResultStatusChanged(value) {
            this.nonconformSampleResultStatusChecked = value;
            this.refreshSelectAllValue();
        },
        onRejectedSampleResultStatusChanged(value) {
            this.rejectedSampleResultStatusChecked = value;
            this.refreshSelectAllValue();
        },
        refreshSelectAllValue() {
            if(this.pendingSampleResultStatusChecked == true && this.conformSampleResultStatusChecked == true && this.nonconformSampleResultStatusChecked == true && this.rejectedSampleResultStatusChecked == true) {
                this.selectAllChecked = true;
            }else{
                this.selectAllChecked = false;
            }
        },
        onSelectAllChanged(value) {
            this.pendingSampleResultStatusChecked = value;
            this.conformSampleResultStatusChecked = value;
            this.nonconformSampleResultStatusChecked = value;
            this.rejectedSampleResultStatusChecked = value;
        }
    }
};
</script>
