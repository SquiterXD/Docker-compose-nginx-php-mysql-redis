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

                <h4> ค้นหากำหนดเกณฑ์การปันส่วน </h4>
                <hr>

                <div class="row">

                    <div class="col-md-8">

                        <div class="row form-group">

                            <label class="col-md-4 col-form-label tw-font-bold tw-pt-0 required"> ปีบัญชีงบประมาณ </label>
                            <div class="col-md-8">
                                <pm-el-select name="period_year" id="input_period_year" 
                                    :select-options="periodYearOptions"
                                    option-key="period_year_value"
                                    option-value="period_year_value" 
                                    option-label="period_year_label" 
                                    :value="periodYear"
                                    :filterable="true"
                                    @onSelected="onPeriodYearChanged"
                                />
                            </div>

                        </div>

                        <div class="row form-group">

                            <label class="col-md-4 col-form-label tw-font-bold tw-pt-0"> แผนการผลิตครั้งที่ </label>
                            <div class="col-md-8">
                                <pm-el-select name="prdgrp_year_id" id="input_prdgrp_year_id" 
                                    :select-options="filteredPrdgrpPlans"
                                    option-key="prdgrp_year_id"
                                    option-value="prdgrp_year_id" 
                                    option-label="plan_version_no" 
                                    :value="prdgrpYearId"
                                    :filterable="true"
                                    :clearable="true"
                                    @onSelected="onPrdgrpVersionChanged"
                                />
                            </div>
                        </div>

                        <div class="row form-group">
                            <label class="col-md-4 col-form-label tw-font-bold tw-pt-0"> ศูนย์ต้นทุน  </label>
                            <div class="col-md-8">
                                
                                <pm-el-select name="cost_code" id="input_cost_code" 
                                    :select-options="filteredCostCenters"
                                    option-key="cost_code_value"
                                    option-value="cost_code_value" 
                                    option-label="cost_code_label" 
                                    :value="costCode"
                                    :filterable="true"
                                    :clearable="true"
                                    @onSelected="onCostCodeChanged"
                                />

                            </div>
                        </div>

                        <div class="row form-group">

                            <label class="col-md-4 col-form-label tw-font-bold tw-pt-0"> ครั้งที่ </label>
                            <div class="col-md-8">
                                <pm-el-select name="ct14_version_no" id="input_ct14_version_no" 
                                    :select-options="filteredCt14VersionNos"
                                    option-key="ct14_version_no"
                                    option-value="ct14_version_no" 
                                    option-label="ct14_version_no" 
                                    :value="ct14VersionNo"
                                    :filterable="true"
                                    :clearable="true"
                                    @onSelected="onCt14VersionNoChanged"
                                />
                            </div>
                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="text-right">

                            <button type="button" 
                                @click="getListOemCostHeaders" 
                                class="btn btn-primary tw-w-32"
                                :disabled="!periodYear"> 
                                ค้นหา 
                            </button>

                            <button type="button" 
                                @click="$modal.hide(modalName)" 
                                class="btn btn-link tw-w-32 tw-mt-2"> 
                                ยกเลิก 
                            </button>
                            
                        </div>

                    </div>

                </div>
                
                <hr>

                <div class="table-responsive" style="max-height: 360px;">

                    <table class="table table-bordered table-sticky mb-0">
                        <thead>
                            <tr>
                                <th width="10%" class="text-center tw-text-xs md:tw-table-cell"> ปีบัญชีงบประมาณ </th>
                                <th width="10%" class="text-center tw-text-xs md:tw-table-cell"> แผนการผลิตครั้งที่ </th>
                                <th width="10%" class="text-center tw-text-xs md:tw-table-cell"> ศูนย์ต้นทุน </th>
                                <th width="7%" class="text-center tw-text-xs md:tw-table-cell"> ครั้งที่ </th>
                                <th width="10%" class="text-center tw-text-xs md:tw-table-cell"> กลุ่มผลิตภัณฑ์ </th>
                                <th width="20%" class="text-center tw-text-xs md:tw-table-cell"> ผลิตภัณฑ์ </th>
                                <th width="10%" class="text-center tw-text-xs md:tw-table-cell"> จำนวนผลิต </th>
                                <th width="10%"></th>
                            </tr>
                        </thead>
                        <tbody v-if="oemCostHeaders.length > 0">
                            <template v-for="(oemCostHeader, index) in oemCostHeaders">
                                <tr :key="index">
                                    <td class="text-center md:tw-table-cell"> {{ oemCostHeader.period_year_thai }} </td>
                                    <td class="text-center md:tw-table-cell"> {{ oemCostHeader.plan_version_no }} </td>
                                    <td class="text-center md:tw-table-cell"> {{ oemCostHeader.cost_code ? getCostCodeLabel(costCenters, oemCostHeader.cost_code) : "-" }} </td>
                                    <td class="text-center md:tw-table-cell"> {{ oemCostHeader.ct14_version_no }} </td>
                                    <td class="text-left md:tw-table-cell"> {{ oemCostHeader.product_group }} : {{ oemCostHeader.product_group_desc }} </td>
                                    <td class="text-left md:tw-table-cell"> {{ oemCostHeader.product_item_number }} : {{ oemCostHeader.product_item_desc }}</td>
                                    <td class="text-right md:tw-table-cell"> {{ oemCostHeader.product_quantity ? Number(oemCostHeader.product_quantity).toLocaleString(undefined, {minimumFractionDigits: 9,maximumFractionDigits: 9}) : "0.000000000" }} </td>
                                    <td class="text-center md:tw-table-cell">  
                                        <button class="btn btn-inline-block btn-primary"
                                            @click="onSelectOemCostHeaderVersion(oemCostHeader)">
                                            เลือก
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td colspan="8">
                                    <h2 class="p-2 text-center text-muted">ไม่พบข้อมูล</h2>
                                </td>
                            </tr>
                        </tbody>

                    </table>
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
        "periodYearValue",
        "periodYears",
        "prdgrpPlans",
        "ct14VersionNos",
        "costCenters",
        "productGroups", 
        "productItems" 
    ],

    components: { Loading },

    watch: {
        periodYears : function (value) {
            this.periodYearOptions = value;
        },
        periodYearValue : function (value) {
            this.periodYearLabel = this.getPeriodYearLabel(this.periodYears, value);
            if(this.periodYearLabel) {
                this.periodYear = value;
                this.getListPrdgrps(this.periodYear); 
                this.getListCostCenters(this.periodYear, this.prdgrpYearId);
                this.getListCt14VersionNos(this.periodYear, this.prdgrpYearId, this.costCode); 
            }
        },
    },

    data() {
        return {

            isLoading: false,
            width: this.modalWidth,
            
            periodYear: this.periodYearValue,
            periodYearLabel: this.getPeriodYearLabel(this.periodYears, this.periodYearValue),

            periodYearOptions: this.periodYears,
            filteredPrdgrpPlans: [],
            prdgrpYearId: this.prdgrpYearIdValue,
            planVersionNo: null,
            filteredCostCenters: [],
            costCode: null,
            filteredCt14VersionNos: [],
            ct14VersionNo: null,
            
            oemCostHeaders: [],
            selectedOemCostHeader: null,
            
        };
    },

    created() {
        this.handleResize();
    },

    mounted() {
        
        this.periodYearOptions = this.periodYears;
        this.periodYearLabel = this.getPeriodYearLabel(this.periodYears, this.periodYearValue);
        if(this.periodYearLabel) {
            this.periodYear = this.periodYearValue;
            this.getListPrdgrps(this.periodYear); 
            this.getListCostCenters(this.periodYear, this.prdgrpYearId);
            this.getListCt14VersionNos(this.periodYear, this.prdgrpYearId, this.costCode); 
        }

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
            this.periodYearLabel = this.getPeriodYearLabel(this.periodYears, this.periodYear);

            // REFRESH DATA
            this.periodNameFrom = null;
            this.periodNameTo = null
            this.prdgrpYearId = null;
            this.costCode = null;
            this.ct14VersionNo = null;

            this.getListPrdgrps(this.periodYear); 
            this.getListCostCenters(this.periodYear, this.prdgrpYearId);
            this.getListCt14VersionNos(this.periodYear, this.prdgrpYearId, this.costCode); 
            
        },

        async onPrdgrpVersionChanged(value) {

            this.prdgrpYearId = value;
            this.planVersionNo = this.getPrdgrpPlanVersionNo(this.prdgrpPlans, this.prdgrpYearId);

            this.costCode = null;
            this.ct14VersionNo = null;

            this.getListCostCenters(this.periodYear, this.prdgrpYearId);
            this.getListCt14VersionNos(this.periodYear, this.prdgrpYearId, this.costCode);

        },

        async onCostCodeChanged(value) {

            this.costCode = value;

            this.ct14VersionNo = null;

            this.getListCt14VersionNos(this.periodYear, this.prdgrpYearId, this.costCode);

        },

        async onCt14VersionNoChanged(value) {

            this.ct14VersionNo = value;

        },

        getPeriodYearLabel(periodYears, periodYear) {
            let foundPeriodYear = null;
            if(periodYears && periodYear) {
                if(periodYears.length > 0) {
                    foundPeriodYear = periodYears.find(item => item.period_year_value == periodYear);
                }
            }
            return foundPeriodYear ? foundPeriodYear.period_year_label : "";
        },

        getCostCodeLabel(costCenters, costCode) {
            let result = null;
            if(costCode) {
                const foundCostCenter = costCenters.find(item => item.cost_code == costCode);
                result = foundCostCenter ? foundCostCenter.cost_code_label : "";
            }
            return result;
        },

        getProductGroupLabel(productGroups, productGroup) {
            let result = null;
            if(productGroup) {
                const foundProductGroup = productGroups.find(item => item.product_group == productGroup);
                result = foundProductGroup ? foundProductGroup.product_group_label : "";
            }
            return result;
        },

        getProductItemLabel(productItems, productItem) {
            let result = null;
            if(productItem) {
                const foundProductItem = productItems.find(item => item.inventory_item_id == productItem);
                result = foundProductItem ? foundProductItem.item_desc : "";
            }
            return result;
        },

        getPrdgrpPlanVersionNo(prdgrpPlans, prdgrpYearId) {
            let result = null;
            if(prdgrpYearId){
                const foundPrdgrp = prdgrpPlans.find(item => item.prdgrp_year_id == prdgrpYearId);
                result = foundPrdgrp ? foundPrdgrp.plan_version_no : "";
            }
            return result;
        },

        async getListOemCostHeaders() {

            // show loading
            this.isLoading = true;

            // REFRESH DATA
            this.oemCostHeaders = [];
            this.selectedOemCostHeader = null;
            
            var params = { 
                period_year: this.periodYear,
                plan_version_no: this.planVersionNo,
                prdgrp_year_id: this.prdgrpYearId,
                cost_code: this.costCode,
                ct14_version_no: this.ct14VersionNo,
            };

            let foundPeriodYear = null;
            if(this.periodYearOptions && this.periodYear) {
                if(this.periodYearOptions.length > 0) {
                    foundPeriodYear = this.periodYearOptions.find(item => item.period_year_value == this.periodYear);
                }
            }

            // VALIDATE REQUIRED PARAMS BY ORGANIZATION_CODE
            if(foundPeriodYear) {

                await axios.get("/ajax/ct/oem-costs/list-headers", { params })
                .then(res => {
                    const resData = res.data.data;
                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลปันส่วนของปีปัญชี ไม่ถูกต้อง | ${resData.message}`, "error");
                    } else {
                        this.oemCostHeaders = resData.oem_cost_headers ? JSON.parse(resData.oem_cost_headers) : null;
                    }
                    return resData;
                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลปันส่วนของปีปัญชี ไม่ถูกต้อง | ${error.message}`, "error");
                    return ;
                });

            } else {
                swal("เกิดข้อผิดพลาด", `กรุณากรอกข้อมูลให้ครบถ้วน`, "error");
            }

            // hide loading
            this.isLoading = false;

        },

        async getListPrdgrps(periodYear) {
            if(periodYear) {
                this.filteredPrdgrpPlans = this.prdgrpPlans.filter(item => item.period_year == periodYear);
            } else {
                this.filteredPrdgrpPlans = [];
            }
        },

        getListCostCenters(periodYear, prdgrpYearId) {
            if(periodYear && prdgrpYearId) {
                this.filteredCostCenters = this.costCenters.filter(item => item.period_year == periodYear && item.prdgrp_year_id == prdgrpYearId);
            } else {
                this.filteredCostCenters = [];
            }
        },

        async getListCt14VersionNos(periodYear, prdgrpYearId, costCode) {
            
            if(periodYear && prdgrpYearId) {

                if(costCode) {

                    this.filteredCt14VersionNos = this.ct14VersionNos.filter(item => {
                        return item.period_year == periodYear && item.prdgrp_year_id == prdgrpYearId && item.cost_code == costCode && !!item.ct14_version_no;
                    }).filter((value, index, self) => {
                        return (
                            index === self.findIndex(t => {
                                return t.ct14_version_no === value.ct14_version_no;
                            })
                        );
                    });

                } else {

                    this.filteredCt14VersionNos = this.ct14VersionNos.filter(item => {
                        return item.period_year == periodYear && item.prdgrp_year_id == prdgrpYearId && !!item.ct14_version_no;
                    }).filter((value, index, self) => {
                        return (
                            index === self.findIndex(t => {
                                return t.ct14_version_no === value.ct14_version_no;
                            })
                        );
                    });

                }

            } else {
                this.filteredCt14VersionNos = [];
            }
        },

        onSelectOemCostHeaderVersion(oemCostHeader) {
            this.selectedOemCostHeader = oemCostHeader;
            this.onSearchOemCostHeader();
        },

        onSearchOemCostHeader() {
            this.$modal.hide(this.modalName);
            this.$emit("onSearchOemCostHeader", {
                oem_cost_header: this.selectedOemCostHeader,
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