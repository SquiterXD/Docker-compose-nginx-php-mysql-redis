<template>

    <div style="position: fixed; z-index: 100;">
        
        <modal
            :name="modalName"
            :width="width"
            :scrollable="true"
            :height="modalHeight"
            :shiftX="0.5"
            :shiftY="0.3"
        >

            <div class="p-4">

                <h4> สถานะกระดาษทำการ </h4>
                <hr>

                <div class="tw-p-4">

                    <div class="row form-group">

                        <label class="col-md-4 col-form-label tw-font-bold tw-pt-0 required"> ปีบัญชีงบประมาณ </label>

                        <div class="col-md-8">

                            <pm-el-select name="period_year" id="input_period_year" 
                                :select-options="periodYears"
                                option-key="period_year"
                                option-value="period_year" 
                                option-label="period_year_thai" 
                                :value="periodYear"
                                :filterable="true"
                                @onSelected="onPeriodYearChanged"
                            />

                        </div>

                    </div>

                    <div class="row form-group">

                        <label class="col-md-4 col-form-label tw-font-bold tw-pt-0 required"> แผนผลิตครั้งที่ </label>

                        <div class="col-md-8">

                            <pm-el-select name="plan_version_no" id="input_plan_version_no" 
                                :select-options="planVersionNoItems"
                                option-key="plan_version_no"
                                option-value="plan_version_no" 
                                option-label="plan_version_no" 
                                :value="planVersionNo"
                                :filterable="true"
                                @onSelected="onPlanVersionNoChanged"
                            />

                        </div>

                    </div>

                    <div class="row form-group">

                        <label class="col-md-4 col-form-label tw-font-bold tw-pt-0"> ครั้งที่ </label>

                        <div class="col-md-8">

                            <pm-el-select name="version_no" id="input_version_no" 
                                :select-options="versionNoItems"
                                option-key="ct14_version_no"
                                option-value="ct14_version_no" 
                                option-label="ct14_version_no" 
                                :value="versionNo"
                                :filterable="true"
                                :clearable="true"
                                @onSelected="onVersionNoChanged"
                            />

                        </div>

                    </div>

                    <div class="row form-group">

                        <label class="col-md-4 col-form-label tw-font-bold tw-pt-0"> ศูนย์ต้นทุน </label>

                        <div class="col-md-8">

                            <pm-el-select name="cost_code" id="input_cost_code" 
                                :select-options="costCodeItems"
                                option-key="cost_code"
                                option-value="cost_code" 
                                option-label="cost_code_label" 
                                :value="costCode"
                                :filterable="true"
                                :clearable="true"
                                @onSelected="onCostCodeChanged"
                            />

                        </div>

                    </div>

                </div>

                <hr>

                <div class="text-right tw-mt-4">

                    <button type="button" 
                        :disabled="!periodYear || !planVersionNo"
                        @click="onSelectStdcostYear" 
                        class="btn btn-primary tw-w-32"> 
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
        "yearControlItems",
        "readyStdcostYearItems",
        "periodYearValue"
    ],

    components: { Loading },

    watch: {
        
        yearControlItems: function (data) {
            this.yearControls = data;
        },

        readyStdcostYearItems: function (data) {
            this.readyStdcostYears = data;
            this.periodYears = this.getListPeriodYears(data);
        },

        periodYearValue: function (value) {

            this.periodYear = value;
            this.planVersionNo = null;
            this.versionNo = null;
            this.costCode = null;
            
            this.planVersionNoItems = this.getListPlanVersionNoItems(this.readyStdcostYearItems, this.periodYear);
            this.versionNoItems = this.getListVersionNoItems(this.readyStdcostYearItems, this.periodYear, this.planVersionNo);
            this.costCodeItems = this.getListCostCodeItems(this.readyStdcostYearItems, this.periodYear, this.planVersionNo);

        }

    },

    mounted() {
        

    },

    data() {
        return {
            isLoading: false,
            width: this.modalWidth,
            yearControls: this.yearControlItems,
            readyStdcostYears: this.readyStdcostYearItems,
            periodYears: this.getListPeriodYears(this.readyStdcostYearItems),
            planVersionNoItems: [],
            versionNoItems: [],
            costCodeItems: [],
            periodYear: this.periodYearValue,
            planVersionNo: null,
            versionNo: null,
            costCode: null,
            
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

        async onPeriodYearChanged(value) {
            
            this.periodYear = value;
            this.planVersionNo = null;
            this.versionNo = null;
            this.costCode = null;
            
            this.planVersionNoItems = this.getListPlanVersionNoItems(this.readyStdcostYears, this.periodYear);
            this.versionNoItems = this.getListVersionNoItems(this.readyStdcostYears, this.periodYear, this.planVersionNo);
            this.costCodeItems = this.getListCostCodeItems(this.readyStdcostYears, this.periodYear, this.planVersionNo);
            
        },

        async onPlanVersionNoChanged(value) {
            
            this.planVersionNo = value;
            this.versionNo = null;
            this.costCode = null;
            
            this.versionNoItems = this.getListVersionNoItems(this.readyStdcostYears, this.periodYear, this.planVersionNo);
            this.costCodeItems = this.getListCostCodeItems(this.readyStdcostYears, this.periodYear, this.planVersionNo);
            
        },

        async onVersionNoChanged(value) {
            
            this.versionNo = value;
            
        },

        async onCostCodeChanged(value) {
            
            this.costCode = value;
            
        },

        getListPeriodYears(readyStdcostYears) {

            const result = readyStdcostYears.map(item => {
                return {
                    period_year: item.period_year,
                    period_year_thai: item.period_year ? parseInt(item.period_year) + 543 : "",
                };
            }).filter((value, index, self) => {
                return (
                    index === self.findIndex(t => {
                        return t.period_year === value.period_year;
                    })
                );
            }).sort((a, b) => {
                return b.period_year - a.period_year;
            });

            return result;
        },

        getListPlanVersionNoItems(readyStdcostYears, periodYear) {

            let result = []

            if(periodYear) {

                result = readyStdcostYears.filter(item => {
                    return item.period_year == periodYear;
                }).map(item => {
                    return {
                        plan_version_no: item.plan_version_no,
                    };
                }).filter((value, index, self) => {
                    return (
                        index === self.findIndex(t => {
                            return t.plan_version_no === value.plan_version_no;
                        })
                    );
                });

            }

            return result;

        },

        getListVersionNoItems(readyStdcostYears, periodYear, planVersionNo) {

            let result = []

            if(periodYear && planVersionNo) {

                result = readyStdcostYears.filter(item => {
                    return item.period_year == periodYear && item.plan_version_no == planVersionNo && !!item.ct14_version_no;
                }).map(item => {
                    return {
                        ct14_version_no: item.ct14_version_no,
                    };
                }).filter((value, index, self) => {
                    return (
                        index === self.findIndex(t => {
                            return t.ct14_version_no === value.ct14_version_no;
                        })
                    );
                });

            }

            return result;

        },

        getListCostCodeItems(readyStdcostYears, periodYear, planVersionNo) {

            let result = []

            if(periodYear && planVersionNo) {

                result = readyStdcostYears.filter(item => {
                    return item.period_year == periodYear && item.plan_version_no == planVersionNo;
                }).map(item => {
                    return {
                        cost_code: item.cost_code,
                        cost_code_value: item.cost_code_value,
                        cost_code_label: item.cost_code_label,
                    };
                }).filter((value, index, self) => {
                    return (
                        index === self.findIndex(t => {
                            return t.cost_code === value.cost_code;
                        })
                    );
                });

            }

            return result;

        },

        onSelectStdcostYear() {

            const readyStdcostYear = this.readyStdcostYears.find(item => {
                if(this.versionNo) {
                    if(this.costCode) {
                        return item.period_year == this.periodYear  && item.plan_version_no == this.planVersionNo && item.ct14_version_no == this.versionNo && item.cost_code == this.costCode;
                    }
                    return item.period_year == this.periodYear  && item.plan_version_no == this.planVersionNo && item.ct14_version_no == this.versionNo;
                } else {
                    if(this.costCode) {
                        return item.period_year == this.periodYear  && item.plan_version_no == this.planVersionNo && item.cost_code == this.costCode;
                    }
                    return item.period_year == this.periodYear  && item.plan_version_no == this.planVersionNo;
                }
            });

            if(!readyStdcostYear) {
                if(this.versionNo) {
                    swal("เกิดข้อผิดพลาด", `ไม่พบข้อมูล ปีบัญชีงบประมาณ: ${this.periodYear}, แผนผลิตครั้งที่: ${this.planVersionNo}, ครั้งที่: ${this.versionNo}`, "error");
                } else {
                    swal("เกิดข้อผิดพลาด", `ไม่พบข้อมูล ปีบัญชีงบประมาณ: ${this.periodYear}, แผนผลิตครั้งที่: ${this.planVersionNo}`, "error");
                }
            }

            this.$modal.hide(this.modalName);
            this.$emit("onSelectReadyStdcostYear", {
                ready_stdcost_year: readyStdcostYear,
                ct14_version_no: this.versionNo,
                ct14_allocate_year_id: (this.versionNo && this.costCode && readyStdcostYear) ? readyStdcostYear.ct14_allocate_year_id : null,
                cost_code: this.costCode,
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