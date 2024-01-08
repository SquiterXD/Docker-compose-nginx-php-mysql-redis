<template>

    <div class="ibox">

        <div class="ibox-content" style="min-height: 600px;">

            <div class="tw-mb-4">

                <div class="text-right tw-mb-2">
                    <button class="btn btn-inline-block btn-sm btn-success tw-w-32"
                        @click="onCreateNewYearlyPlanVersion"
                        :disabled="!isAllowCreateNewPlanVersion(yearlyPlanVersions)"
                    > 
                        <i class="fa fa-plus tw-mr-1"></i> สร้าง 
                    </button>
                    <button class="btn btn-inline-block btn-sm btn-primary tw-w-32"
                        @click="onSaveYearlyPlan"
                        :disabled="!periodYear || yearlyPlanLines.length == 0 || (yearlyPlanHeader ? yearlyPlanHeader.status != '1' : true)"
                    > 
                        <i class="fa fa-save tw-mr-1"></i> บันทึก 
                    </button>
                    <button class="btn btn-inline-block btn-sm hover:tw-text-white tw-text-white tw-bg-purple-500 tw-border-purple-500 tw-w-70"
                        @click="onGetSalePlans"
                        :disabled="!periodYear || !sourceVersion || salePlans.length > 0 || yearlyPlanLines.length > 0"
                    > 
                        <i class="fa fa-list tw-mr-1"></i> {{ getSalePlanLabel(organizationCode) }} 
                    </button>
                    <button class="btn btn-inline-block btn-sm btn-info tw-w-40"
                        @click="onGenerateYearlyPlanLines"
                        :disabled="!periodYear || !salePlanSummary || (yearlyPlanHeader ? yearlyPlanHeader.status != '1' : false)"
                    > 
                        <i class="fa fa-calculator tw-mr-1"></i> ประมาณการใช้ 
                    </button>
                </div>
                
                <div class="text-right">

                    <button class="btn btn-inline-block btn-sm btn-white tw-w-32"
                        @click="$modal.show('modal-search-plan')">
                        <i class="fa fa-search tw-mr-1"></i> ค้นหา 
                    </button>
                    <button class="btn btn-inline-block btn-sm btn-primary tw-w-40"
                        :disabled="yearlyPlanHeader ? yearlyPlanHeader.status == '1' : true"
                    > 
                        <i class="fa fa-print tw-mr-1"></i> พิมพ์รายงาน 
                    </button>

                    <div v-if="isShowSubmitApprovalButton(organizationCode)" class="tw-inline-block"> 
                        <button class="btn btn-inline-block btn-sm btn-warning tw-w-40"
                            @click="onSubmitApproval"
                            :disabled="(yearlyPlanHeader ? yearlyPlanHeader.status != '1' : true) || yearlyPlanLines.length == 0 || isNewlyCreate || foundInvalidPlanLine"
                        > 
                            <i class="fa fa-check-square tw-mr-1"></i> ส่งอนุมัติ 
                        </button>
                    </div>

                    <div v-if="isShowSubmitYearlyPlanButton(organizationCode)" class="tw-inline-block"> 
                        <button class="btn btn-inline-block btn-sm btn-warning tw-w-40"
                            @click="onSubmitYearlyPlan"
                            :disabled="(yearlyPlanHeader ? yearlyPlanHeader.status != '1' : true) || yearlyPlanLines.length == 0 || isNewlyCreate || foundInvalidPlanLine"
                        > 
                            <i class="fa fa-check-square tw-mr-1"></i> ส่งข้อมูลประมาณการ 
                        </button>
                    </div>

                </div>

            </div>

            <hr>

            <div>

                <div class="row">

                    <div class="col-md-6">

                        <div v-if="isAllowSelectPrintType(organizationCode)" class="row form-group">

                            <label class="col-md-4 col-form-label tw-font-bold"> ระบบการพิมพ์ </label>

                            <div class="col-md-8">

                                <pm-el-select name="print_type" id="input_print_type" 
                                    :select-options="printTypes"
                                    option-key="print_type_value"
                                    option-value="print_type_value" 
                                    option-label="print_type_label"
                                    :value="printType"
                                    :filterable="true"
                                    @onSelected="onPrintTypeChanged"
                                />

                            </div>

                        </div>

                        <div v-if="isAllowSelectSaleType(organizationCode)" class="row form-group">

                            <label class="col-md-4 col-form-label tw-font-bold"> ประเภทแผน </label>

                            <div class="col-md-8">

                                <pm-el-select name="sale_type" id="sale_type" 
                                    :select-options="saleTypes"
                                    option-key="value"
                                    option-value="value" 
                                    option-label="description"
                                    :value="saleType"
                                    :filterable="true"
                                    @onSelected="onSaleTypeChanged"
                                />

                            </div>

                        </div>

                        <div v-if="isAllowSelectIngredientGroup(organizationCode)" class="row form-group">

                            <label class="col-md-4 col-form-label tw-font-bold"> ประเภทวัตถุดิบ </label>

                            <div class="col-md-8">

                                <pm-el-select name="ingredient_group" id="ingredient_group" 
                                    :select-options="ingredientGroups"
                                    option-key="value"
                                    option-value="value" 
                                    option-label="description"
                                    :value="ingredientGroup"
                                    :filterable="true"
                                    @onSelected="onIngredientGroupChanged"
                                />
                                
                            </div>

                        </div>

                        <div class="row form-group">

                            <label v-if="organizationCode == 'M06'" class="col-md-4 col-form-label tw-font-bold tw-pt-0"> แผนประมาณการ <br> จำหน่ายประจำปี </label>
                            <label v-else class="col-md-4 col-form-label tw-font-bold tw-pt-0"> แผนประมาณการ <br> ผลิตประจำปี </label>

                            <div class="col-md-3">

                                <pm-el-select name="period_year" id="input_period_year" 
                                    :select-options="periodYears"
                                    option-key="period_year_value"
                                    option-value="period_year_value" 
                                    option-label="period_year_label" 
                                    :value="periodYear"
                                    :filterable="true"
                                    @onSelected="onYearlyPlanChanged"
                                />

                            </div>

                            <label class="col-md-2 col-form-label tw-font-bold"> ครั้งที่ </label>

                            <div class="col-md-3">

                                <pm-el-select v-if="isAllowSelectSourceVersion(yearlyPlanHeader, yearlyPlanLines)"
                                    name="source_version" 
                                    id="source_version" 
                                    :select-options="sourceVersions"
                                    option-key="version"
                                    option-value="version" 
                                    option-label="version" 
                                    :value="sourceVersion"
                                    :filterable="true"
                                    @onSelected="onSourceVersionChanged"
                                />
                                <p v-if="!isAllowSelectSourceVersion(yearlyPlanHeader, yearlyPlanLines)" class="col-form-label"> {{ sourceVersion ? sourceVersion : "-" }} </p>

                            </div>

                        </div>

                        <div class="row form-group">

                            <label class="col-md-4 col-form-label tw-font-bold"> เวอร์ชั่น </label>

                            <div class="col-md-8">
                                <p v-if="yearlyPlanHeader" class="col-form-label"> {{ yearlyPlanHeader.version ? yearlyPlanHeader.version : "-" }} </p>
                                <p v-if="!yearlyPlanHeader" class="col-form-label"> - </p>
                            </div>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="row form-group">

                            <label class="col-md-4 col-form-label tw-font-bold"> หน่วยงาน </label>

                            <div class="col-md-8">
                                <p class="col-form-label"> {{ department ? department.description : '-' }} </p>
                            </div>

                        </div>

                        <div class="row form-group">

                            <label class="col-md-4 col-form-label tw-font-bold"> สถานะ </label>

                            <div class="col-md-8">
                                <p v-if="yearlyPlanHeader" class="col-form-label"> {{ getPlanStatusDesc(yearlyPlanHeader.status) }} </p>
                                <p v-if="!yearlyPlanHeader" class="col-form-label"> - </p>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <hr v-if="salePlans.length > 0">
            
            <div v-if="salePlans.length > 0" class="tw-m-8">

                <h3> {{ getSalePlanLabel(organizationCode) }}  </h3>
                <div class="row">

                    <div class="col-12">

                        <table-sale-plans 
                            :organization-code="organizationCode"
                            :sale-plans="salePlans"
                            :sale-plan-summary="salePlanSummary" 
                        />

                    </div>

                </div>

            </div>

            <hr v-if="yearlyPlanLines.length > 0">

            <div v-if="yearlyPlanLines.length > 0" class="tw-m-8">

                <h3> รายการวัตถุดิบ </h3>
                <div class="row">

                    <div class="col-12">

                        <table-plan-lines 
                            :plan-header="yearlyPlanHeader"
                            :plan-lines="yearlyPlanLines" 
                            :plan-months="periodYearMonths" 
                            :uom-codes="uomCodes"
                            :sale-plan-summary="salePlanSummary" 
                            :item-options="itemOptions"
                            @onPlanLineChanged="onPlanLineChanged"
                        />

                    </div>

                </div>

            </div>
            
        </div>

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

        <!-- MODAL SEARCH PLAN -->
        <modal-search-plan 
            modal-name="modal-search-plan" 
            modal-width="640" 
            modal-height="auto"
            :organization-code="organizationCode"
            :period-years="periodYears"
            :period-year-value="periodYear"
            :print-types="printTypes"
            :print-type-value="printType"
            :sale-types="saleTypes"
            :sale-type-value="saleType"
            :ingredient-groups="ingredientGroups"
            :ingredient-group-value="ingredientGroup"
            :source-versions="sourceVersions"
            :source-version-value="sourceVersion"
            :yearly-plan-version-value="yearlyPlanVersion"
            :yearly-plan-versions="yearlyPlanVersions"
            @onSearchPlanVersion="onSearchPlanVersion"
        />

    </div>

</template>

<script>

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import moment from 'moment';

import TableSalePlans from "./TableSalePlans";
import TablePlanLines from "./TablePlanLines";
import ModalSearchPlan from "./ModalSearchPlan";

export default {
    
    components: { Loading, TableSalePlans, TablePlanLines, ModalSearchPlan },

    props: [ "defaultData", "periodYears", "periodYearValue", "itemOptions", "planStatuses", "printTypes", "printTypeValue", "saleTypes", "saleTypeValue", "ingredientGroups", "ingredientGroupValue", "sourceVersionValue", "uomCodes" ],

    mounted() {
        
        this.getSourceVersions(this.periodYearValue, this.printTypeValue, this.saleTypeValue, this.ingredientGroupValue).then((value) => {
            this.getYearlyPlanData(this.periodYearValue, this.printTypeValue, this.saleTypeValue, this.ingredientGroupValue, this.sourceVersionValue, null);
        });

    },

    data() {
        return {
            organizationId: this.defaultData ? JSON.parse(this.defaultData).organization_id : null,
            organizationCode: this.defaultData ? JSON.parse(this.defaultData).organization_code : null,
            department: this.defaultData ? JSON.parse(this.defaultData).department : null,
            periodYear: this.periodYearValue,
            periodYearLabel: this.getPeriodYearLabel(this.periodYears, this.periodYearValue),
            printType: this.printTypeValue ? this.printTypeValue : (this.printTypes.length > 0 ? this.printTypes[0].print_type_value : null),
            printTypeLabel: this.printTypeValue ? this.getPrintTypeLabel(this.printTypes, this.printTypeValue) : (this.printTypes.length > 0 ? this.printTypes[0].print_type_label : null),
            saleType: this.saleTypeValue ? this.saleTypeValue : (this.saleTypes.length > 0 ? this.saleTypes[0].value : null),
            saleTypeLabel: this.saleTypeValue ? this.getSaleTypeLabel(this.saleTypes, this.saleTypeValue) : (this.saleTypes.length > 0 ? this.saleTypes[0].description : null),
            ingredientGroup: this.ingredientGroupValue ? this.ingredientGroupValue : (this.ingredientGroups.length > 0 ? this.ingredientGroups[0].value : null),
            ingredientGroupLabel: this.ingredientGroupValue ? this.getIngredientGroupLabel(this.ingredientGroups, this.ingredientGroupValue) : (this.ingredientGroups.length > 0 ? this.ingredientGroups[0].description : null),
            sourceVersion: this.sourceVersionValue ? this.sourceVersionValue : null,
            sourceVersions: [],
            yearlyPlanHeader: null,
            yearlyPlanVersion: null,
            salePlans: [],
            salePlanSummary: null,
            yearlyPlanLines: [],
            periodYearMonths: [],
            yearlyPlanVersions: [],
            isNewlyCreate: false,
            foundInvalidPlanLine: false,
            isLoading: false
        }
    },

    computed: {

    },

    methods: {

        setUrlParams() {

            var queryParams = new URLSearchParams(window.location.search);
            queryParams.set("period_year", this.periodYear ? this.periodYear : '');
            queryParams.set("print_type", this.printType ? this.printType : '');
            queryParams.set("sale_type", this.saleType ? this.saleType : '');
            queryParams.set("ingredient_group", this.ingredientGroup ? this.ingredientGroup : '');
            queryParams.set("source_version", this.sourceVersion ? this.sourceVersion : '');
            window.history.replaceState(null, null, "?"+queryParams.toString());

        },

        async onYearlyPlanChanged(value) {
            
            this.periodYear = value;
            this.periodYearLabel = this.getPeriodYearLabel(this.periodYears, this.periodYear);
            this.setUrlParams();

            await this.getSourceVersions(this.periodYear, this.printType, this.saleType, this.ingredientGroup);
            if(this.sourceVersion) {
                this.getYearlyPlanData(this.periodYear, this.printType, this.saleType, this.ingredientGroup, this.sourceVersion, null);
            }
            
        },

        async onSourceVersionChanged(value) {
            
            this.sourceVersion = value;
            this.setUrlParams();

            // CLEAR DATA
            if(this.yearlyPlanLines.length == 0) {
                this.salePlans = [];
                this.salePlanSummary = null;
            }

            if(this.yearlyPlanHeader) {
                await this.updateYearlyPlanSourceVersion(this.periodYear, this.printType, this.saleType, this.ingredientGroup, this.sourceVersion, this.yearlyPlanHeader.version);
            }
            
            this.getYearlyPlanData(this.periodYear, this.printType, this.saleType, this.ingredientGroup, this.sourceVersion, null);

        },

        async onPrintTypeChanged(value) {

            this.printType = value;
            this.printTypeLabel = this.getPrintTypeLabel(this.printTypes, this.printType);
            this.setUrlParams();

            await this.getSourceVersions(this.periodYear, this.printType, this.saleType, this.ingredientGroup);
            if(this.sourceVersion) {
                this.getYearlyPlanData(this.periodYear, this.printType, this.saleType, this.ingredientGroup, this.sourceVersion, null);
            }

        },

        async onSaleTypeChanged(value) {
            
            this.saleType = value;
            this.saleTypeLabel = this.getSaleTypeLabel(this.saleTypes, this.saleType);
            this.setUrlParams();

            await this.getSourceVersions(this.periodYear, this.printType, this.saleType, this.ingredientGroup);
            if(this.sourceVersion) {
                this.getYearlyPlanData(this.periodYear, this.printType, this.saleType, this.ingredientGroup, this.sourceVersion, null);
            }

        },

        async onIngredientGroupChanged(value) {
            
            this.ingredientGroup = value;
            this.ingredientGroupLabel = this.getIngredientGroupLabel(this.ingredientGroups, this.ingredientGroup);
            this.setUrlParams();

            await this.getSourceVersions(this.periodYear, this.printType, this.saleType, this.ingredientGroup);
            if(this.sourceVersion) {
                this.getYearlyPlanData(this.periodYear, this.printType, this.saleType, this.ingredientGroup, this.sourceVersion, null);
            }

        },

        onSearchPlanVersion(data) {
            
            this.periodYear = data.period_year;
            this.periodYearLabel = this.getPeriodYearLabel(this.periodYears, this.periodYear);

            this.printType = data.print_type;
            this.printTypeLabel = this.getPrintTypeLabel(this.printTypes, this.printType);

            this.saleType = data.sale_type;
            this.saleTypeLabel = this.getSaleTypeLabel(this.saleTypes, this.saleType);

            this.ingredientGroup = data.ingredient_group;
            this.ingredientGroupLabel = this.getIngredientGroupLabel(this.ingredientGroups, this.ingredientGroup);

            this.sourceVersion = data.source_version;
            this.sourceVersions = data.source_versions;

            this.getYearlyPlanData(this.periodYear, this.printType, this.saleType, this.ingredientGroup, this.sourceVersion, data.version);

        },

        getPeriodYearLabel(periodYears, periodYear) {
            const foundPeriodYear = periodYears.find(item => item.period_year_value == periodYear);
            return foundPeriodYear ? foundPeriodYear.period_year_label : "";
        },

        getPeriodNameLabel(periodNames, periodName) {
            const foundPeriodName = periodNames.find(item => item.period_name_value == periodName);
            return foundPeriodName ? foundPeriodName.period_name_label : "";
        },

        getPrintTypeLabel(printTypes, printType) {
            const foundPrintType = printTypes.find(item => item.print_type_value == printType);
            return foundPrintType ? foundPrintType.print_type_label : "";
        },

        getSaleTypeLabel(saleTypes, saleType) {
            const foundSaleType = saleTypes.find(item => item.value == saleType);
            return foundSaleType ? foundSaleType.description : "";
        },

        getIngredientGroupLabel(ingredientGroups, ingredientGroup) {
            const foundIngredientGroup = ingredientGroups.find(item => item.value == ingredientGroup);
            return foundIngredientGroup ? foundIngredientGroup.description : "";
        },

        validateBeforeGetHeader(organizationCode, periodYear, printType, saleType, ingredientGroup, sourceVersion) {

            let valid = false;

            if(organizationCode == "M06") {

                if(periodYear && printType && saleType && sourceVersion) {
                    valid = true;
                }

            } else if(organizationCode == "M02") {

                if(periodYear && ingredientGroup && sourceVersion) {
                    valid = true;
                }

            } else {

                if(periodYear && sourceVersion) {
                    valid = true;
                }

            }

            return valid;
        },

        async getYearlyPlanData(periodYear, printType, saleType, ingredientGroup, sourceVersion, version) {

            // SHOW LOADING
            this.isLoading = true;

            // REFRESH DATA
            this.yearlyPlanHeader = null;
            this.yearlyPlanLines = [];
            this.yearlyPlanVersion = version;
            this.yearlyPlanVersions = [];
            this.salePlans = [];
            this.salePlanSummary = null;
            
            var params = { 
                period_year: periodYear,
                print_type: printType,
                sale_type: saleType,
                ingredient_group: ingredientGroup,
                source_version: sourceVersion,
                version: version
            };

            // VALIDATE REQUIRED PARAMS BY ORGANIZATION_CODE
            const isValid = this.validateBeforeGetHeader(this.organizationCode, periodYear, printType, saleType, ingredientGroup, sourceVersion);
            if(isValid) {

                await axios.get("/ajax/pm/plans/yearly/get-info", { params })
                .then(res => {
                    const resData = res.data.data;
                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ข้อมูลแผนประมาณการจำหน่ายประจำปี ${this.periodYearLabel} ไม่ถูกต้อง | ${resData.message}`, "error");
                    } else {
                        this.yearlyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;
                        this.yearlyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                    }
                    return resData;
                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ข้อมูลแผนประมาณการจำหน่ายประจำปี ${this.periodYearLabel} ไม่ถูกต้อง | ${error.message}`, "error");
                    return ;
                });
                
                if(this.yearlyPlanHeader) {

                    // FOUND PLAN
                    this.yearlyPlanVersion = this.yearlyPlanHeader.version;
                    if(this.sourceVersions.length > 0) {
                        
                        const foundSourceVersion = this.sourceVersions.find(item => item.version == this.yearlyPlanHeader.source_version);
                        this.sourceVersion = foundSourceVersion ? foundSourceVersion.version : this.yearlyPlanHeader.source_version;

                        await this.onGetSalePlans();
                        await this.onGetYearlyPlanLines();
                        this.setUrlParams();

                    }

                } else {
                    this.yearlyPlanVersion = null;
                }

            }

            // HIDE LOADING
            this.isLoading = false;

        },


        validateBeforeGetSourceVersions(organizationCode, periodYear, printType, saleType, ingredientGroup) {

            let valid = false;

            if(organizationCode == "M06") {

                if(periodYear && printType && saleType) {
                    valid = true;
                }

            } else if(organizationCode == "M02") {

                if(periodYear && ingredientGroup) {
                    valid = true;
                }

            } else {

                if(periodYear) {
                    valid = true;
                }

            }

            return valid;

        },

        async getSourceVersions(periodYear, printType, saleType, ingredientGroup) {

            // SHOW LOADING
            this.isLoading = true;

            // REFRESH DATA
            this.sourceVersion = null;
            this.sourceVersions = [];
            
            var params = { 
                period_year: periodYear,
                print_type: printType,
                sale_type: saleType,
                ingredient_group: ingredientGroup,
            };

            // VALIDATE REQUIRED PARAMS BY ORGANIZATION_CODE
            const isValid = this.validateBeforeGetSourceVersions(this.organizationCode, periodYear, printType, saleType, ingredientGroup);
            if(isValid) {

                await axios.get("/ajax/pm/plans/yearly/get-source-versions", { params })
                .then(res => {
                    const resData = res.data.data;
                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ข้อมูลไม่ถูกต้อง | ${resData.message}`, "error");
                    } else {
                        this.sourceVersion = resData.source_version ? resData.source_version : null;
                        this.sourceVersions = resData.source_versions ? JSON.parse(resData.source_versions) : [];
                        if(this.sourceVersions.length <= 0) {
                            swal("ไม่พบข้อมูล", `ไม่พบข้อมูลแผนประมาณการจำหน่ายประจำปี (ฝ่ายขาย)`, "error");
                            // REFRESH DATA
                            this.yearlyPlanHeader = null;
                            this.yearlyPlanLines = [];
                            this.yearlyPlanVersion = null;
                            this.yearlyPlanVersions = [];
                            this.salePlans = [];
                            this.salePlanSummary = null;
                        }
                    }
                    return resData;
                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ข้อมูลไม่ถูกต้อง | ${error.message}`, "error");
                    return ;
                });

            }
            
            // HIDE LOADING
            this.isLoading = false;

        },

        getPlanStatusDesc(status) {
            let statusDesc = "-";
            if(status) {
                const foundStatus = this.planStatuses.find(item => item.lookup_code == status);
                statusDesc = foundStatus ? foundStatus.description : "-"; 
            }
            return statusDesc;
        },

        async onGetSalePlans() {

            // SHOW LOADING
            this.isLoading = true;

            const salePlanLabel = this.getSalePlanLabel(this.organizationCode);

            var params = { 
                period_year: this.periodYear,
                print_type: this.printType,
                sale_type: this.saleType,
                ingredient_group: this.ingredientGroup,
                source_version: this.sourceVersion,
            };
            await axios.get("/ajax/pm/plans/yearly/get-sale-plans", { params })
            .then(res => {
                const resData = res.data.data;
                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูล ${salePlanLabel} ${this.periodYearLabel} | ${resData.message}`, "error");
                } else {
                    if(resData.sale_plans) {
                        const resSalePlans = JSON.parse(resData.sale_plans);
                        if(resSalePlans.length <= 0 ){
                            swal("ไม่พบข้อมูล", `ไม่พบข้อมูล ${salePlanLabel} ${this.periodYearLabel}`, "info");
                        } else {
                            this.salePlans = resSalePlans.map(item => {
                                return { ...item, total: this.getTotalSalePlanPerItem(item) }
                            });
                            this.salePlanSummary = this.getSumAllSalePlanItem(resSalePlans);
                        }
                    }
                }
                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูล ${salePlanLabel} ${this.periodYearLabel} | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

        },

        getTotalSalePlanPerItem(item) {

            let total = 0;

            const octValue = !isNaN(parseFloat(item.oct)) ? parseFloat(item.oct) : 0;
            const novValue = !isNaN(parseFloat(item.nov)) ? parseFloat(item.nov) : 0;
            const decValue = !isNaN(parseFloat(item.dec)) ? parseFloat(item.dec) : 0;
            const janValue = !isNaN(parseFloat(item.jan)) ? parseFloat(item.jan) : 0;
            const febValue = !isNaN(parseFloat(item.feb)) ? parseFloat(item.feb) : 0;
            const marValue = !isNaN(parseFloat(item.mar)) ? parseFloat(item.mar) : 0;
            const aprValue = !isNaN(parseFloat(item.apr)) ? parseFloat(item.apr) : 0;
            const mayValue = !isNaN(parseFloat(item.may)) ? parseFloat(item.may) : 0;
            const junValue = !isNaN(parseFloat(item.jun)) ? parseFloat(item.jun) : 0;
            const julValue = !isNaN(parseFloat(item.jul)) ? parseFloat(item.jul) : 0;
            const augValue = !isNaN(parseFloat(item.aug)) ? parseFloat(item.aug) : 0;
            const sepValue = !isNaN(parseFloat(item.sep)) ? parseFloat(item.sep) : 0;

            total = octValue + novValue + decValue + janValue + febValue + marValue + aprValue + mayValue + junValue + julValue + augValue + sepValue;

            return total;

        },

        getSumAllSalePlanItem(salePlans) {

            let sumAllItem = { oct: 0, nov: 0, dec: 0, jan: 0, feb: 0, mar: 0, apr: 0, may: 0, jun: 0, jul: 0, aug: 0, sep: 0, total: 0 };

            const octValues = salePlans.map(item => !isNaN(parseFloat(item.oct)) ? parseFloat(item.oct) : 0 );
            sumAllItem.oct = octValues.reduce((acc, currValue) => acc + currValue, 0);

            const novValues = salePlans.map(item => !isNaN(parseFloat(item.nov)) ? parseFloat(item.nov) : 0 );
            sumAllItem.nov = novValues.reduce((acc, currValue) => acc + currValue, 0);

            const decValues = salePlans.map(item => !isNaN(parseFloat(item.dec)) ? parseFloat(item.dec) : 0 );
            sumAllItem.dec = decValues.reduce((acc, currValue) => acc + currValue, 0);

            const janValues = salePlans.map(item => !isNaN(parseFloat(item.jan)) ? parseFloat(item.jan) : 0 );
            sumAllItem.jan = janValues.reduce((acc, currValue) => acc + currValue, 0);

            const febValues = salePlans.map(item => !isNaN(parseFloat(item.feb)) ? parseFloat(item.feb) : 0 );
            sumAllItem.feb = febValues.reduce((acc, currValue) => acc + currValue, 0);

            const marValues = salePlans.map(item => !isNaN(parseFloat(item.mar)) ? parseFloat(item.mar) : 0 );
            sumAllItem.mar = marValues.reduce((acc, currValue) => acc + currValue, 0);

            const aprValues = salePlans.map(item => !isNaN(parseFloat(item.apr)) ? parseFloat(item.apr) : 0 );
            sumAllItem.apr = aprValues.reduce((acc, currValue) => acc + currValue, 0);
            
            const mayValues = salePlans.map(item => !isNaN(parseFloat(item.may)) ? parseFloat(item.may) : 0 );
            sumAllItem.may = mayValues.reduce((acc, currValue) => acc + currValue, 0);

            const junValues = salePlans.map(item => !isNaN(parseFloat(item.jun)) ? parseFloat(item.jun) : 0 );
            sumAllItem.jun = junValues.reduce((acc, currValue) => acc + currValue, 0);

            const julValues = salePlans.map(item => !isNaN(parseFloat(item.jul)) ? parseFloat(item.jul) : 0 );
            sumAllItem.jul = julValues.reduce((acc, currValue) => acc + currValue, 0);

            const augValues = salePlans.map(item => !isNaN(parseFloat(item.aug)) ? parseFloat(item.aug) : 0 );
            sumAllItem.aug = augValues.reduce((acc, currValue) => acc + currValue, 0);

            const sepValues = salePlans.map(item => !isNaN(parseFloat(item.sep)) ? parseFloat(item.sep) : 0 );
            sumAllItem.sep = sepValues.reduce((acc, currValue) => acc + currValue, 0);

            sumAllItem.total = sumAllItem.oct + sumAllItem.nov +sumAllItem.dec +sumAllItem.jan +sumAllItem.feb +sumAllItem.mar +sumAllItem.apr +sumAllItem.may +sumAllItem.jun +sumAllItem.jul +sumAllItem.aug + sumAllItem.sep;

            return sumAllItem;

        },

        async onGetYearlyPlanLines() {

            // SHOW LOADING
            this.isLoading = true;

            var params = { 
                period_year: this.periodYear,
                print_type: this.printType,
                sale_type: this.saleType,
                ingredient_group: this.ingredientGroup,
                source_version: this.sourceVersion,
                version: this.yearlyPlanVersion
            };
            await axios.get(`/ajax/pm/plans/yearly/get-lines`, { params })
            .then(res => {

                const resData = res.data.data;

                if(resData.status == "success") {

                    this.yearlyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : [];
                    this.yearlyPlanLines = resData.plan_lines ? JSON.parse(resData.plan_lines) : [];
                    this.yearlyPlanVersion = this.yearlyPlanHeader.version;
                    this.yearlyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];

                    if(this.yearlyPlanLines.length > 0) {
                        this.foundInvalidPlanLine = !!this.yearlyPlanLines.find(item => !item.uom);
                        const invalidPlanLines = this.yearlyPlanLines.filter(item => !item.uom);
                        const invalidPlanLineItemCodes = invalidPlanLines.map(item => item.item_code);
                        if(this.foundInvalidPlanLine) {
                            swal("เกิดข้อผิดพลาด", `ตรวจพบรายการที่มีข้อมูลไม่สมบูรณ์ [ รหัสวัตถุดิบ : ${invalidPlanLineItemCodes.join()} ]`, "error");
                        }
                    }

                } else {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลประมาณการผลิตของ แผนประมาณการจำหน่ายประจำปี ${this.periodYearLabel} | ${resData.message}`, "error");                    
                }

                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลประมาณการผลิตของ แผนประมาณการจำหน่ายประจำปี ${this.periodYearLabel}  | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

        },

        async onGenerateYearlyPlanLines() {

            if(this.yearlyPlanLines.length > 0) {

                swal({
                    title: "",
                    text: `ต้องการดึงข้อมูลประมาณการใช้ ใหม่อีกครั้ง ?`,
                    showCancelButton: true,
                    confirmButtonClass: "btn-primary",
                    confirmButtonText: "ยืนยัน",
                    cancelButtonText: "ยกเลิก",
                    closeOnConfirm: true
                }, (isConfirm) => {
                    if (isConfirm) {
                        this.yearlyPlanLines = [];
                        this.generateYearlyPlanLines();
                    }
                });

            } else {
                this.generateYearlyPlanLines();
            }

        },

        async generateYearlyPlanLines() {

            // SHOW LOADING
            this.isLoading = true;

            var reqBody = { 
                period_year: this.periodYear,
                print_type: this.printType,
                sale_type: this.saleType,
                ingredient_group: this.ingredientGroup,
                source_version: this.sourceVersion,
                version: this.yearlyPlanVersion
            };
            await axios.post(`/ajax/pm/plans/yearly/generate-lines`, reqBody)
            .then(res => {

                const resData = res.data.data;

                if(resData.status == "success") {

                    this.yearlyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : [];
                    this.yearlyPlanLines = resData.plan_lines ? JSON.parse(resData.plan_lines) : [];
                    this.yearlyPlanVersion = this.yearlyPlanHeader.version;
                    this.yearlyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                    this.isNewlyCreate = resData.is_newly_create;
                    
                    if(this.yearlyPlanLines.length > 0) {
                        this.foundInvalidPlanLine = !!this.yearlyPlanLines.find(item => !item.uom);
                        const invalidPlanLines = this.yearlyPlanLines.filter(item => !item.uom);
                        const invalidPlanLineItemCodes = invalidPlanLines.map(item => item.item_code);
                        if(this.foundInvalidPlanLine) {
                            swal("เกิดข้อผิดพลาด", `ตรวจพบรายการที่มีข้อมูลไม่สมบูรณ์ [ รหัสวัตถุดิบ : ${invalidPlanLineItemCodes.join()} ]`, "error");
                        }
                    }

                } else {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลประมาณการผลิตของ แผนประมาณการจำหน่ายประจำปี ${this.periodYearLabel} | ${resData.message}`, "error");                    
                }

                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลประมาณการผลิตของ แผนประมาณการจำหน่ายประจำปี ${this.periodYearLabel}  | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

        },

        onPlanLineChanged(data) {
            this.yearlyPlanLines = data.planLineItems;
        },

        validateBeforeSave(planHeader, planLines) {

            const result = {
                valid: true,
                message: "",
            };

            // IF NEW LINE ISN'T COMPLETED
            const incompletedLines = planLines.filter(item => {
                return item.is_new_line && (
                    !item.item_code ||
                    !item.user_gain_loss_qty ||
                    !item.oct_buy_qty ||
                    !item.nov_buy_qty ||
                    !item.dec_buy_qty ||
                    !item.jan_buy_qty ||
                    !item.feb_buy_qty ||
                    !item.mar_buy_qty ||
                    !item.apr_buy_qty ||
                    !item.may_buy_qty ||
                    !item.jun_buy_qty ||
                    !item.jul_buy_qty ||
                    !item.aug_buy_qty ||
                    !item.sep_buy_qty ||
                    !item.percent
                ) && item.marked_as_deleted == false;
            });

            if(incompletedLines.length > 0) {
                result.valid = false;
                result.message = `กรอกข้อมูลรายการประมาณการวัตถุดิบประจำปีไม่ครบถ้วน กรุณาตรวจสอบ`
            }

            return result;

        },

        async onSaveYearlyPlan() {

            const reqBody = {
                period_year: this.periodYear,
                print_type: this.printType,
                sale_type: this.saleType,
                ingredient_group: this.ingredientGroup,
                source_version: this.sourceVersion,
                version: this.yearlyPlanVersion,
                plan_header: JSON.stringify(this.yearlyPlanHeader),
                plan_lines: JSON.stringify(this.yearlyPlanLines)
            };

            // SHOW LOADING
            this.isLoading = true;

            const resValidate = this.validateBeforeSave(this.yearlyPlanHeader, this.yearlyPlanLines);

            if(resValidate.valid) {

                await axios.post(`/ajax/pm/plans/yearly/store-lines`, reqBody)
                .then(res => {

                    const resData = res.data.data;
                    const resMsg = resData.message;
                    const resPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;

                    if(resData.status == "success") {
                        this.yearlyPlanHeader = resPlanHeader;
                        this.yearlyPlanVersion = resPlanHeader.version;
                        this.yearlyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                        this.isNewlyCreate = false;
                        swal("Success", `บันทึกประมาณการใช้ แผนประมาณการจำหน่ายประจำปี : ${this.periodYearLabel} version : ${this.yearlyPlanVersion} )`, "success");
                    }

                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `บันทึกประมาณการใช้ แผนประมาณการจำหน่ายประจำปี : ${this.periodYearLabel} | ${resMsg}`, "error");
                    }
                    
                    return resData;

                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `บันทึกประมาณการใช้ แผนประมาณการจำหน่ายประจำปี : ${this.periodYearLabel} | ${error.message}`, "error");
                });

            } else {
                swal("เกิดข้อผิดพลาด", `บันทึกประมาณการใช้ แผนประมาณการจำหน่ายประจำปี : ${this.periodYearLabel} | ${resValidate.message}`, "error");
            }

            // HIDE LOADING
            this.isLoading = false;

        },

        getSalePlanLabel(organizationCode) {
            let label = "แผนประมาณการจำหน่ายประจำปี (ฝ่ายขาย)";
            if(organizationCode != "M06") {
                label = "แผนการผลิตบุหรี่ประจำปี";
            };
            return label;
        },

        isShowSubmitApprovalButton(organizationCode) {
            return organizationCode == "M06";
        },
        
        isShowSubmitYearlyPlanButton(organizationCode){
            return (organizationCode == "M02" || organizationCode == "M05" || organizationCode == "MG6");
        },

        async onSubmitApproval() {

            const reqBody = {
                period_year: this.periodYear,
                print_type: this.printType,
                sale_type: this.saleType,
                ingredient_group: this.ingredientGroup,
                source_version: this.sourceVersion,
                version: this.yearlyPlanVersion,
                plan_header: JSON.stringify(this.yearlyPlanHeader),
                plan_lines: JSON.stringify(this.yearlyPlanLines)
            };

            // SHOW LOADING
            this.isLoading = true;

            // CALL SAVE BEFORE SUBMIT APPROVAL
            await axios.post(`/ajax/pm/plans/yearly/store-lines`, reqBody)
            .then(res => {
                const resData = res.data.data;
                if(resData.status == "error") {
                    console.log(resData.message);
                }
                return resData;
            }).catch((error) => {
                console.log(error);
            });

            // CALL SUBMIT APPROVAL
            await axios.post(`/ajax/pm/plans/yearly/submit-approval`, reqBody)
            .then(res => {

                const resData = res.data.data;
                const resMsg = resData.message;

                if(resData.status == "success") {
                    this.yearlyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;
                    this.yearlyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                    swal("Success", `ส่งอนุมัติ แผนประมาณการจำหน่ายประจำปี : ${this.periodYearLabel} version : ${this.yearlyPlanVersion} )`, "success");
                }

                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `ส่งอนุมัติ แผนประมาณการจำหน่ายประจำปี : ${this.periodYearLabel} | ${resMsg}`, "error");
                }
                
                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ส่งอนุมัติ แผนประมาณการจำหน่ายประจำปี : ${this.periodYearLabel} | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

        },

        async onSubmitYearlyPlan() {

            const reqBody = {
                period_year: this.periodYear,
                print_type: this.printType,
                sale_type: this.saleType,
                ingredient_group: this.ingredientGroup,
                source_version: this.sourceVersion,
                version: this.yearlyPlanVersion,
                plan_header: JSON.stringify(this.yearlyPlanHeader),
                plan_lines: JSON.stringify(this.yearlyPlanLines)
            };

            // SHOW LOADING
            this.isLoading = true;

            // CALL SAVE BEFORE SUBMIT APPROVAL
            await axios.post(`/ajax/pm/plans/yearly/store-lines`, reqBody)
            .then(res => {
                const resData = res.data.data;
                if(resData.status == "error") {
                    console.log(resData.message);
                }
                return resData;
            }).catch((error) => {
                console.log(error);
            });

            // CALL SUBMIT APPROVAL
            await axios.post(`/ajax/pm/plans/yearly/submit-plan`, reqBody)
            .then(res => {

                const resData = res.data.data;
                const resMsg = resData.message;

                if(resData.status == "success") {
                    this.yearlyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;
                    this.yearlyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                    swal("Success", `ส่งข้อมูลประมาณการ แผนประมาณการจำหน่ายประจำปี : ${this.periodYearLabel} version : ${this.yearlyPlanVersion} )`, "success");
                }

                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `ส่งข้อมูลประมาณการ แผนประมาณการจำหน่ายประจำปี : ${this.periodYearLabel} | ${resMsg}`, "error");
                }
                
                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ส่งข้อมูลประมาณการ แผนประมาณการจำหน่ายประจำปี : ${this.periodYearLabel} | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

        },

        async onCreateNewYearlyPlanVersion() {

            swal({
                title: "",
                text: `ต้องการสร้าง ประมาณการวัตถุดิบประจำปี แผนประมาณการจำหน่ายประจำปี : ${this.periodYearLabel} เวอร์ชั่นใหม่ ?`,
                showCancelButton: true,
                confirmButtonClass: "btn-primary",
                confirmButtonText: "ยืนยัน",
                cancelButtonText: "ยกเลิก",
                closeOnConfirm: true
            }, (isConfirm) => {
                if (isConfirm) {
                    this.salePlans = [];
                    this.salePlanSummary = null;
                    this.yearlyPlanLines = [];
                    this.createNewPlanVersion();
                }
            });

        },

        isAllowSelectPrintType(organizationCode) {

            let allowed = false;
            if(organizationCode == "M06") {
                allowed = true;
            }

            return allowed;
        
        },

        isAllowSelectSaleType(organizationCode) {

            let allowed = false;
            if(organizationCode == "M06") {
                allowed = true;
            }

            return allowed;
        
        },

        isAllowSelectIngredientGroup(organizationCode) {

            let allowed = false;
            if(organizationCode == "M02") {
                allowed = true;
            }

            return allowed;
        
        },

        isAllowSelectSourceVersion(planHeader, planLines) {

            let allowed = false;
            
            if(planHeader){
                // ALLOW WHEN PLAN LINES WERE NOT GENERATED 
                if(planLines.length == 0) {
                    allowed = true;
                }
            } else {
                // ALLOW WHEN PLAN'S NEVER BEEN CREATED
                allowed = true;
            }

            return allowed;

        },

        isAllowCreateNewPlanVersion(versions) {

            let allowed = true;

            // IF THERE IS NO PLAN VERSION
            if(versions.length == 0) {
                allowed = false;
            }

            // // IF ALL VERSIONS ARE NOT COMPLETED ( 1 : NEW || 2 : WAITING_FOR_APPROVAL )
            // // => NOT ALLOW TO CREATE NEW VERSION
            // const inprogressVersions = versions.filter(item => {
            //     return (item.status == 1 || item.status == 2)
            // });

            // if(inprogressVersions.length > 0){
            //     allowed = false;
            // }

            return allowed;

        },

        async createNewPlanVersion() {

            // ALWAYS SET NEW VERSION WITH LATEST SOURCE_VERSION FORM THE LIST
            if(this.sourceVersions.length > 0) {
                this.sourceVersion = this.sourceVersions[0].version;
            }

            const reqBody = {
                period_year: this.periodYear,
                print_type: this.printType,
                sale_type: this.saleType,
                ingredient_group: this.ingredientGroup,
                source_version: this.sourceVersion
            };

            // SHOW LOADING
            this.isLoading = true;

            await axios.post(`/ajax/pm/plans/yearly/add-new-header`, reqBody)
            .then(res => {

                const resData = res.data.data;
                const resMsg = resData.message;

                if(resData.status == "success") {
                    
                    this.yearlyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;
                    this.yearlyPlanVersion = resData.version;
                    this.yearlyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                    if(this.sourceVersions.length > 0) {
                        const foundSourceVersion = this.sourceVersions.find(item => item.version == this.yearlyPlanHeader.source_version);
                        this.sourceVersion = foundSourceVersion ? foundSourceVersion.version : this.yearlyPlanHeader.source_version;
                    }

                    swal("Success", `สร้าง แผนประมาณการจำหน่ายประจำปี : ${this.periodYearLabel} version : ${this.yearlyPlanVersion} )`, "success");

                }

                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `สร้าง แผนประมาณการจำหน่ายประจำปี : ${this.periodYearLabel} | ${resMsg}`, "error");
                }
                
                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `สร้าง แผนประมาณการจำหน่ายประจำปี : ${this.periodYearLabel} | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

            this.setUrlParams();

        },

         async updateYearlyPlanSourceVersion(periodYear, printType, saleType, ingredientGroup, sourceVersion, version) {

            const reqBody = {
                period_year: periodYear,
                print_type: printType,
                sale_type: saleType,
                ingredient_group: ingredientGroup,
                source_version: sourceVersion,
                version: version,
            };

            // SHOW LOADING
            this.isLoading = true;

            await axios.post(`/ajax/pm/plans/yearly/update-source-version`, reqBody)
            .then(res => {

                const resData = res.data.data;
                const resMsg = resData.message;
                if(resData.status == "success") {
                    // this.yearlyPlanHeader = resData.plan_header ? JSON.parse(resData.plan_header) : null;
                    // this.yearlyPlanVersion = resData.version;
                    // this.yearlyPlanVersions = resData.versions ? JSON.parse(resData.versions) : [];
                }

                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถแก้ไขข้อมูลครั้งที่ ของประมานการประจำปี ${this.periodYearLabel} | ${resMsg}`, "error");
                }
                
                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถแก้ไขข้อมูลครั้งที่ ของประมานการประจำปี ${this.periodYearLabel} | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

        },


    }

}

</script>