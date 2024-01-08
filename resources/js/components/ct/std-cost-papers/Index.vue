<template>

    <div class="ibox">

        <div class="ibox-content tw-pt-10" style="min-height: 600px;">

            <div class="row tw-mb-5">

                <div class="col-12">

                    <div class="row tw-mb-2">

                        <div class="col-md-4">

                            <div class="row">

                                <div class="col-md-6">
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

                                <label class="col-md-6 col-form-label tw-font-bold"> ปีบัญชีงบประมาณ </label>

                            </div>

                        </div>

                        <div class="col-md-8 text-right">
                            <button class="btn btn-inline-block btn-sm btn-primary tw-w-32"
                                @click="$modal.show('modal-get-std-cost-data')">
                                <i class="fa fa-arrow-down tw-mr-1"></i> ดึงข้อมูล 
                            </button>
                        </div>

                    </div>

                    <table-year-controls 
                        :year-controls="yearControlItems" 
                    >
                    </table-year-controls>

                </div>

            </div>
            
        </div>

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

        <!-- MODAL GET STDCOST DATA -->
        <modal-get-std-cost-data 
            modal-name="modal-get-std-cost-data" 
            modal-width="640" 
            modal-height="auto"
            :year-control-items="yearControlItems"
            :ready-stdcost-year-items="readyStdcostYears"
            :period-year-value="periodYear"
            @onSelectReadyStdcostYear="onGetStdCostData"
        >
        </modal-get-std-cost-data>

    </div>

</template>

<script>

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import moment from 'moment';

import TableYearControls from "./TableYearControls";
import ModalGetStdCostData from "./ModalGetStdCostData";

export default {
    
    components: { Loading, TableYearControls, ModalGetStdCostData },

    props: [ "defaultData", "yearControls", "readyStdcostYears" ],

    mounted() {

    },

    data() {

        return {

            organizationId: this.defaultData ? this.defaultData.organization_id : null,
            organizationCode: this.defaultData ? this.defaultData.organization_code : null,
            department: this.defaultData ? this.defaultData.department : null,
            yearControlItems: this.yearControls.map(item => {
                return {
                    ...item,
                    is_showed: true
                }
            }),
            periodYears: this.getListPeriodYears(this.yearControls),
            periodYear: "",
            isLoading: false,
        }

    },

    computed: {

    },

    methods: {

        getListPeriodYears(yearControlItems) {

            const listPeriodYears = yearControlItems.map(item => {
                return {
                    period_year: item.period_year,
                    period_year_thai: item.period_year_thai,
                    budget_year: item.budget_year,
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

            const result = [
                {
                    period_year: "",
                    period_year_thai: "แสดงทั้งหมด",
                    budget_year: "",
                },
                ...listPeriodYears,
            ];

            return result;
        },

        async onPeriodYearChanged(value) {
            
            this.periodYear = value;

            if(this.periodYear) {
                this.yearControlItems = this.yearControlItems.map(item => {
                    return {
                        ...item,
                        is_showed: this.periodYear == item.period_year ? true : false
                    }
                });
            } else {
                this.yearControlItems = this.yearControlItems.map(item => {
                    return {
                        ...item,
                        is_showed: true
                    }
                });
            }
            
        },

        async onGetStdCostData(data) {

            const stdcostYear = data.ready_stdcost_year;
            const stdcostYearCt14VersionNo = data.ct14_version_no;
            const stdcostYearCt14AllocateYearId = data.ct14_allocate_year_id
            const stdcostYearCostCode = data.cost_code;
            
            // SAVE TO DB
            const reqBody = {
                period_year: stdcostYear.period_year,
                plan_version_no: stdcostYear.plan_version_no,
                prdgrp_year_id: stdcostYear.prdgrp_year_id, 
                allocate_year_id: stdcostYear.allocate_year_id,
                version_no: stdcostYear.version_no,
                ct14_version_no: stdcostYearCt14VersionNo,
                ct14_allocate_year_id: stdcostYearCt14AllocateYearId,
                cost_code: stdcostYearCostCode,
            };

            // SHOW LOADING
            this.isLoading = true;

            // call store sample result
            await axios.post(`/ajax/ct/std-cost-papers/get-std-cost-data`, reqBody)
            .then(res => {

                const resData = res.data.data;
                const resMsg = resData.message;

                if(resData.status == "success") {
                    swal("สำเร็จ", `ดึงข้อมูลสำเร็จ`, "success");
                    window.setTimeout(function() {
                        window.location.reload();
                    }, 2000);
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

        },

        formatDateTh(date) {
            return date ? moment(date).add(543, 'years').format('DD/MM/YYYY') : ""
        },

    }

}

</script>