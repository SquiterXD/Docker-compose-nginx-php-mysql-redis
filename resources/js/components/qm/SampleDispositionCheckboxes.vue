<template>
    <div class="row">
        <label class="col-md-2 col-form-label required"> สถานะการตรวจสอบ </label>
        <div class="col-md-7 md:tw-pr-20 tw-pr-4">
            <div class="row">
                <div class="col-md-3 md:tw-pr-0 tw-pr-4">
                    <qm-el-checkbox name="pending_sample_disposition" id="input_pending_sample_disposition" label="ยังไม่ลงผลการตรวจสอบ" input-class="tw-w-full tw-bg-yellow-200" @change="onPendingSampleDispositionChanged" :value="pendingSampleDispositionChecked" />
                </div>
                <div class="col-md-3 md:tw-pr-0 tw-pr-4">
                    <qm-el-checkbox name="correct_sample_disposition" id="input_correct_sample_disposition" label="ลงผลแล้ว ผลทดสอบปกติ" input-class="tw-w-full tw-bg-green-300" @change="onCorrectSampleDispositionChanged" :value="correctSampleDispositionChecked" />
                </div>
                <div class="col-md-3 md:tw-pr-0 tw-pr-4">
                    <qm-el-checkbox name="incorrect_sample_disposition" id="input_incorrect_sample_disposition" label="ลงผลแล้ว พบค่าความผิดปกติ" input-class="tw-w-full tw-bg-red-300" @change="onIncorrectSampleDispositionChanged" :value="incorrectSampleDispositionChecked" />
                </div>
            </div>
        </div>
        <div class="col-md-2 md:tw-pr-0 tw-pr-4">
            <qm-el-checkbox name="select_all_sample_disposition" id="input_select_all_sample_disposition" label="เลือกสถานะทั้งหมด" input-class="tw-w-full tw-bg-blue-200" @change="onSelectAllChanged" :value="selectAllChecked" />
        </div>
    </div>
</template>

<script>
export default {
    props: [
        "pendingSampleDispositionValue",
        "correctSampleDispositionValue",
        "incorrectSampleDispositionValue",
        "selectAllValue"
    ],

    data() {
        return {
            pendingSampleDispositionChecked: this.pendingSampleDispositionValue,
            correctSampleDispositionChecked: this.correctSampleDispositionValue,
            incorrectSampleDispositionChecked: this.incorrectSampleDispositionValue,
            selectAllChecked:this.selectAllValue 
        };
    },

    methods: {
        onPendingSampleDispositionChanged(value) {
            this.pendingSampleDispositionChecked = value;
            this.refreshSelectAllValue();
        },
        onCorrectSampleDispositionChanged(value) {
            this.correctSampleDispositionChecked = value;
            this.refreshSelectAllValue();
        },
        onIncorrectSampleDispositionChanged(value) {
            this.incorrectSampleDispositionChecked = value;
            this.refreshSelectAllValue();
        },
        refreshSelectAllValue() {
            if(this.pendingSampleDispositionChecked == true && this.correctSampleDispositionChecked == true && this.incorrectSampleDispositionChecked == true) {
                this.selectAllChecked = true;
            }else{
                this.selectAllChecked = false;
            }
        },
        onSelectAllChanged(value) {
            this.pendingSampleDispositionChecked = value;
            this.correctSampleDispositionChecked = value;
            this.incorrectSampleDispositionChecked = value;
        }
    }
};
</script>
