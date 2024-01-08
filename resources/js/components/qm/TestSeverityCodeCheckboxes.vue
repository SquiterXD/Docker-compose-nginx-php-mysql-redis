<template>
    <div class="row">
        <label class="col-sm-2 col-form-label"> ระดับความรุนแรงของความผิดปกติ (อาการ) </label>
        <div class="col-md-2 md:tw-pr-0 tw-pr-4">
            <qm-el-checkbox name="test_serverity_code_minor" id="input_test_serverity_code_minor" label="Minor" input-class="tw-w-full tw-bg-opacity-30 tw-bg-blue-100 tw-border-blue-400" @change="onMinorChanged" :value="minorChecked" />
        </div>
        <div class="col-md-2 md:tw-pr-0 tw-pr-4">
            <qm-el-checkbox name="test_serverity_code_major" id="input_test_serverity_code_major" label="Major" input-class="tw-w-full tw-bg-opacity-20 tw-bg-yellow-200 tw-border-yellow-400" @change="onMajorChanged" :value="majorChecked" />
        </div>
        <div class="col-md-3 md:tw-pr-0 tw-pr-4">
            <qm-el-checkbox name="test_serverity_code_critical" id="input_test_serverity_code_critical" label="Critical" input-class="tw-w-4/5 tw-bg-opacity-30 tw-bg-red-100 tw-border-red-400" @change="onCriticalChanged" :value="criticalChecked" />
        </div>
        <div class="col-md-2 md:tw-pr-0 tw-pr-4">
            <qm-el-checkbox name="select_all_test_serverity_code" id="input_select_all_test_serverity_code" label="เลือกทั้งหมด" input-class="tw-w-full tw-bg-opacity-20 tw-bg-purple-200 tw-border-purple-400" @change="onSelectAllLevelChanged" :value="selectAllLevelChecked" />
        </div>
    </div>
</template>

<script>
export default {
    props: [
        "minorValue",
        "majorValue",
        "criticalValue",
        "selectAllLevelValue"
    ],

    data() {
        return {
            minorChecked: this.minorValue,
            majorChecked: this.majorValue,
            criticalChecked: this.criticalValue,
            selectAllLevelChecked: this.selectAllLevelValue 
        };
    },

    methods: {
        onMinorChanged(value) {
            this.minorChecked = value;
            this.refreshSelectAllLevelValue();
        },
        onMajorChanged(value) {
            this.majorChecked = value;
            this.refreshSelectAllLevelValue();
        },
        onCriticalChanged(value) {
            this.criticalChecked = value;
            this.refreshSelectAllLevelValue();
        },
        refreshSelectAllLevelValue() {
            if(this.minorChecked == true && this.majorChecked == true && this.criticalChecked == true) {
                this.selectAllLevelChecked = true;
            }else{
                this.selectAllLevelChecked = false;
            }
        },
        onSelectAllLevelChanged(value) {
            this.minorChecked = value;
            this.majorChecked = value;
            this.criticalChecked = value;
        }
    }

};
</script>
