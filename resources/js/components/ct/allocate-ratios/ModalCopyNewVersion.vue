<template>

    <div style="position: fixed; z-index: 100;">
        
        <modal
            :name="modalName"
            :width="width"
            :scrollable="true"
            :height="modalHeight"
            :shiftX="0.3"
            :shiftY="0.3"
        >

            <div class="p-4">

                <h4> คัดลอกข้อมูล </h4>
                <hr>

                <div class="tw-p-4 tw-bg-yellow-100">

                    <div class="row form-group">

                        <label class="col-md-4 col-form-label tw-font-bold tw-pt-0"> จาก ปีบัญชี </label>

                        <div class="col-md-8">

                            <pm-el-select name="from_period_year" id="input_from_period_year" 
                                :select-options="fromPeriodYearOptions"
                                option-key="period_year_value"
                                option-value="period_year_value" 
                                option-label="period_year_label" 
                                :value="fromPeriodYear"
                                :filterable="true"
                                @onSelected="onFromPeriodYearChanged"
                            />
                            
                        </div>

                    </div>

                    <div class="row form-group">

                        <label class="col-md-4 col-form-label tw-font-bold"> ครั้งที่ </label>

                        <div class="col-md-8">

                            <pm-el-select name="from_allocate_year_version" id="input_from_allocate_year_version" 
                                :select-options="fromAllocateYearVersionOptions"
                                option-key="version_no"
                                option-value="version_no" 
                                option-label="version_no" 
                                :value="fromAllocateYearVersion"
                                :filterable="true"
                                @onSelected="onFromAllocateYearVersionChanged"
                            />

                        </div>

                    </div>

                </div>

                <hr>

                <div class="tw-p-4">

                    <div class="row form-group">

                        <label class="col-md-4 col-form-label tw-font-bold tw-pt-0"> ไปที่ ปีบัญชี </label>

                        <div class="col-md-8">

                            <pm-el-select name="to_period_year" id="input_to_period_year" 
                                :select-options="toPeriodYearOptions"
                                option-key="period_year_value"
                                option-value="period_year_value" 
                                option-label="period_year_label" 
                                :value="toPeriodYear"
                                :filterable="true"
                                @onSelected="onToPeriodYearChanged"
                            />
                            
                        </div>

                    </div>

                    <div class="row form-group">

                        <label class="col-md-4 col-form-label tw-font-bold"> ครั้งที่ </label>

                        <div class="col-md-8">

                            <input type="text" v-model="toAllocateYearVersion" name="to_allocate_year_version" id="input_to_allocate_year_version" class="input-sm form-control" disabled />

                        </div>

                    </div>

                </div>

                <hr>

                <div class="text-right tw-mt-4">

                    <button type="button" 
                        @click="onCopyAllocateYearNewVersion" 
                        class="btn btn-primary tw-w-32"
                        :disabled="!fromPeriodYear || !toPeriodYear || !fromAllocateYearVersion || !toAllocateYearVersion"> 
                        เลือก 
                    </button>

                    <button type="button" 
                        @click="$modal.hide(modalName)" 
                        class="btn btn-link"> 
                        ยกเลิก 
                    </button>
                    
                </div>

            </div>

        </modal>

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

    </div>

</template>

<script>

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";

export default {

    props: [
        "modalName", 
        "modalWidth", 
        "modalHeight",
        "organizationCode", 
        "planHeader",
        "listAllocateGroups",
        "allocateGroupValue",
        "periodYears",
        "periodYearValue", 
        "toAllocateYearVersionValue",
    ],

    components: { Loading },

    watch: {
        
        periodYears : function (value) {
            this.fromPeriodYearOptions = value;
            this.toPeriodYearOptions = value;
        },
        periodYearValue : function (value) {

            this.fromPeriodYear = (parseInt(value) - 1).toString();
            this.fromPeriodYearLabel = this.getPeriodYearLabel(this.periodYears, this.fromPeriodYear);

            this.toPeriodYear = value;
            this.toPeriodYearLabel = this.getPeriodYearLabel(this.periodYears, this.toPeriodYear);

            this.getAllocateYearData(this.fromPeriodYear, "from");
            this.getAllocateYearData(this.toPeriodYear, "to");
        },
        toAllocateYearVersionValue : function (value) {
            this.toAllocateYearVersion = value;
        },

    },

    mounted() {
        
        if(this.periodYearValue) {

            this.fromPeriodYear = (parseInt(this.periodYearValue) - 1).toString();
            this.fromPeriodYearLabel = this.getPeriodYearLabel(this.periodYears, this.fromPeriodYear);

            this.toPeriodYear = this.periodYearValue;
            this.toPeriodYearLabel = this.getPeriodYearLabel(this.periodYears, this.toPeriodYear);

            this.getAllocateYearData(this.fromPeriodYear, "from");
            this.getAllocateYearData(this.toPeriodYear, "to");
        }

    },

    data() {
        return {
            isLoading: false,
            width: this.modalWidth,
            fromPeriodYearOptions: this.periodYears,
            toPeriodYearOptions: this.periodYears,
            fromPeriodYear: this.periodYearValue ? (parseInt(this.periodYearValue) - 1).toString() : null,
            fromPeriodYearLabel: this.periodYearValue ? this.getPeriodYearLabel(this.periodYears, (parseInt(this.periodYearValue) - 1).toString()) : "",
            fromAllocateYearVersionOptions: [],
            fromAllocateYearVersion: null,
            toPeriodYear: this.periodYearValue,
            toPeriodYearLabel: this.getPeriodYearLabel(this.periodYears, this.periodYearValue),
            toAllocateYearVersion: null,
            toAllocateYearVersionOptions: [],
            
        };
    },

    created() {
        this.handleResize();
    },

    methods: {

        handleResize() {
            if (window.innerWidth < 768) {
                // set modal width = 90% when screen width < 769px
                this.width = "90%";
            } else if (window.innerWidth < 992) {
                // set modal width = 80% when screen width < 992px
                this.width = "80%";
            } else {
                this.width = this.modalWidth;
            }
        },

        async onFromPeriodYearChanged(value) {

            this.fromPeriodYear = value;
            this.fromPeriodYearLabel = this.getPeriodYearLabel(this.fromPeriodYearOptions, this.fromPeriodYear);

            await this.getAllocateYearData(this.fromPeriodYear, "from");

        },

        async onToPeriodYearChanged(value) {

            this.toPeriodYear = value;
            this.toPeriodYearLabel = this.getPeriodYearLabel(this.toPeriodYearOptions, this.toPeriodYear);

            await this.getAllocateYearData(this.toPeriodYear, "to");

        },

        onFromAllocateYearVersionChanged(value) {
            this.fromAllocateYearVersion = value;
        },

        // onToAllocateYearVersionChanged(value) {
        //     this.toAllocateYearVersion = value;
        // },

        getPeriodYearLabel(periodYears, periodYear) {
            const foundPeriodYear = periodYears.find(item => item.period_year_value == periodYear);
            return foundPeriodYear ? foundPeriodYear.period_year_label : "";
        },

        async getAllocateYearData(periodYear, inputType) {

            // show loading
            this.isLoading = true;

            // REFRESH DATA
            if(inputType == "from") {
                this.fromAllocateYearVersionOptions = [];
            } else {
                this.toAllocateYearVersionOptions = [];
            }
            
            var params = { 
                period_year: periodYear,
                version: null
            };

            // VALIDATE REQUIRED PARAMS BY ORGANIZATION_CODE
            if(periodYear) {

                await axios.get("/ajax/ct/allocate-ratios/year", { params })
                .then(res => {
                    const resData = res.data.data;
                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลปันส่วนของปีปัญชี ไม่ถูกต้อง | ${resData.message}`, "error");
                    } else {

                        if(inputType == "from") {
                            this.fromAllocateYearVersionOptions = resData.versions ? JSON.parse(resData.versions) : [];
                            if(this.fromAllocateYearVersionOptions.length > 0) {
                                this.fromAllocateYearVersion = this.fromAllocateYearVersionOptions[0].version_no;
                            }
                        } else {
                            this.toAllocateYearVersionOptions = resData.versions ? JSON.parse(resData.versions) : [];
                            if(this.toAllocateYearVersionOptions.length > 0) {
                                this.toAllocateYearVersion = (parseInt(this.toAllocateYearVersionOptions[0].version_no) + 1).toString();
                            } else {
                                this.toAllocateYearVersion = 1;
                            }
                        }

                    }
                    return resData;
                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลปันส่วนของปีปัญชี ไม่ถูกต้อง | ${error.message}`, "error");
                    return ;
                });

            }

            // hide loading
            this.isLoading = false;

        },

        onCopyAllocateYearNewVersion() {
            this.$modal.hide(this.modalName);
            this.$emit("onCopyAllocateYearNewVersion", {
                from_period_year: this.fromPeriodYear,
                from_version_no: this.fromAllocateYearVersion,
                to_period_year: this.toPeriodYear,
                to_version_no: this.toAllocateYearVersion,
            });
        },

    }
};
</script>
<style scoped>
.v--modal-overlay {
  z-index: 2000;
  padding-top: 3rem;
  padding-bottom: 3rem;
}
.vm--overlay[data-modal="modal-search-allocate-year"] {
    height: 100% !important;
}
</style>