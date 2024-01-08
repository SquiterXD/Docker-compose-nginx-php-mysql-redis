<template>
    <div class="row">
        <label class="col-sm-2 col-form-label required"> สถานะการยืนยันข้อมูล </label>
        <div class="col-md-7 md:tw-pr-20 tw-pr-4">
            <div class="row">
                <div class="col-md-3 md:tw-pr-0 tw-pr-4">
                    <qm-el-checkbox name="pending_confirm_status" id="input_pending_confirm_status" label="ยังไม่ยืนยัน" input-class="tw-w-full tw-bg-yellow-200" @change="onPendingConfirmStatusChanged" :value="pendingConfirmStatusChecked" />
                </div>
                <div class="col-md-3 md:tw-pr-0 tw-pr-4">
                    <qm-el-checkbox name="done_confirm_status" id="input_done_confirm_status" label="ยืนยันข้อมูลแล้ว" input-class="tw-w-full tw-bg-green-300" @change="onDoneConfirmStatusChanged" :value="doneConfirmStatusChecked" />
                </div>
                <div class="col-md-3 md:tw-pr-0 tw-pr-4">
                    <qm-el-checkbox name="rejected_confirm_status" id="input_rejected_confirm_status" label="ยกเลิกข้อมูลแล้ว" input-class="tw-w-full tw-bg-red-300" @change="onRejectedConfirmStatusChanged" :value="rejectedConfirmStatusChecked" />
                </div>
            </div>
        </div>
        <div class="col-md-2 md:tw-pr-0 tw-pr-4">
            <qm-el-checkbox name="select_all_confirm_status" id="input_select_all_confirm_status" label="เลือกสถานะทั้งหมด" input-class="tw-w-full tw-bg-blue-200" @change="onSelectAllChanged" :value="selectAllChecked" />
        </div>
    </div>
</template>

<script>
export default {
    props: [
        "pendingConfirmStatusValue",
        "doneConfirmStatusValue",
        "rejectedConfirmStatusValue",
        "selectAllValue"
    ],

    data() {
        return {
            pendingConfirmStatusChecked: this.pendingConfirmStatusValue,
            doneConfirmStatusChecked: this.doneConfirmStatusValue,
            rejectedConfirmStatusChecked: this.rejectedConfirmStatusValue,
            selectAllChecked:this.selectAllValue 
        };
    },

    methods: {
        onPendingConfirmStatusChanged(value) {
            this.pendingConfirmStatusChecked = value;
            this.refreshSelectAllValue();
        },
        onDoneConfirmStatusChanged(value) {
            this.doneConfirmStatusChecked = value;
            this.refreshSelectAllValue();
        },
        onRejectedConfirmStatusChanged(value) {
            this.rejectedConfirmStatusChecked = value;
            this.refreshSelectAllValue();
        },
        refreshSelectAllValue() {
            if(this.pendingConfirmStatusChecked == true && this.doneConfirmStatusChecked == true && this.rejectedConfirmStatusChecked == true) {
                this.selectAllChecked = true;
            }else{
                this.selectAllChecked = false;
            }
        },
        onSelectAllChanged(value) {
            this.pendingConfirmStatusChecked = value;
            this.doneConfirmStatusChecked = value;
            this.rejectedConfirmStatusChecked = value;
        }
    }
};
</script>
