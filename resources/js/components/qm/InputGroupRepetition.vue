<template>
    <div>
        <div class="row form-group">
            <div class="col-md-12">
                <qm-el-checkbox
                    :value="repeatFlag"
                    label="สร้างซ้ำ"
                    name="repeat_flag"
                    size="small"
                    @change="onFlagChanged"
                ></qm-el-checkbox>
            </div>
        </div>

        <div v-if="repeatFlag" class="row form-group">
            <div class="col-12">
                <label class="required"> รอบเวลาที่สร้าง </label>
            </div>
            <div class="col-md-4">
                <input
                    type="number"
                    name="repeat_time_hour"
                    v-model="repeatTimeHour"
                    :min="0"
                    :max="12"
                    @blur="onRepeatTimeHourChanged"
                    class="form-control text-center"
                />
            </div>
            <div class="col-md-2">
                <p class="form-control-static md:tw-mt-4 tw-mt-2 tw-mb-0">
                    ชั่วโมง
                </p>
            </div>
            <div class="col-md-4">
                <input
                    type="number"
                    name="repeat_time_min"
                    v-model="repeatTimeMin"
                    :min="0"
                    :max="59"
                    @blur="onRepeatTimeMinChanged"
                    class="form-control text-center"
                />
            </div>
            <div class="col-md-2">
                <p class="form-control-static md:tw-mt-4 tw-mt-2 tw-mb-0">
                    นาที
                </p>
            </div>
        </div>

        <div v-if="repeatFlag" class="row form-group">
            <div class="col-md-6">
                <label class="required"> จำนวนเลขที่ตัวอย่าง </label>
                <input
                    type="hidden"
                    name="repeat_qty"
                    v-model="repeatQty"
                />
                <el-input-number
                    v-model="repeatQty"
                    :min="1"
                    :max="10"
                    class="w-100"
                ></el-input-number>
            </div>
            <div class="col-md-4">
                <label class="md:tw-block tw-hidden">&nbsp;</label>
                <p class="form-control-static md:tw-mt-4 tw-mt-2 tw-mb-0">
                    ชุด
                </p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        "repeatFlagValue",
        "repeatTimeHourValue",
        "repeatTimeMinValue",
        "repeatQtyValue"
    ],
    data() {
        return {
            repeatFlag: this.repeatFlagValue == 'true',
            repeatTimeHour: this.repeatTimeHourValue,
            repeatTimeMin: this.repeatTimeMinValue,
            repeatQty: this.repeatQtyValue
        };
    },
    mounted() {},
    methods: {
        onRepeatTimeHourChanged(e) {
            const value = e.target.value;
            if(value >= 10){
                this.repeatTimeHour = 10;
                this.repeatTimeMin = 0;
            }
        },
        onRepeatTimeMinChanged(e) {
            const value = e.target.value;
            if(value > 59){
                this.repeatTimeMin = 59;
            }
            if(this.repeatTimeHour >= 10){
                this.repeatTimeMin = 0;
            }
            
        },
        onFlagChanged(value) {
            this.repeatFlag = value;
        }
    }
};
</script>
