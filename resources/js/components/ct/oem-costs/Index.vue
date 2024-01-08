<template>

    <div class="ibox">

        <div class="ibox-content tw-pt-10" style="min-height: 600px;">

            <div class="row">

                <div class="col-md-5">

                    <div class="row form-group">

                        <label class="col-md-4 col-form-label tw-font-bold tw-pt-0 required"> ปีบัญชีงบประมาณ </label>

                        <div class="col-md-8">

                            <pm-el-select name="period_year" id="input_period_year" 
                                :select-options="periodYears"
                                option-key="period_year_value"
                                option-value="period_year_value" 
                                option-label="period_year_label" 
                                :value="periodYear"
                                :filterable="true"
                                @onSelected="onPeriodYearChanged"
                            />

                        </div>

                    </div>
                

                </div>

                <div class="col-md-7">

                    <div class="row form-group">
                        <label class="col-md-4 col-form-label tw-font-bold tw-pt-0 required"> แผนการผลิตครั้งที่ </label>
                        <div class="col-md-8">
                            <pm-el-select name="prdgrp_year_id" id="input_prdgrp_year_id" 
                                :select-options="filteredPrdgrpPlans"
                                option-key="prdgrp_year_id"
                                option-value="prdgrp_year_id" 
                                option-label="plan_version_no" 
                                :value="prdgrpYearId"
                                :filterable="true"
                                @onSelected="onPrdgrpVersionChanged"
                            />
                        </div>

                    </div>

                </div>

            </div>

            <div class="row">
                <div class="col-md-5">
                    <div class="row form-group">
                        <label class="col-md-4 col-form-label tw-font-bold tw-pt-0 required"> ศูนย์ต้นทุน  </label>
                        <div class="col-md-8">
                            <pm-el-select name="cost_code" id="input_cost_code" 
                                :select-options="filteredCostCenters"
                                option-key="cost_code_value"
                                option-value="cost_code_value" 
                                option-label="cost_code_label" 
                                :value="costCode"
                                :filterable="true"
                                @onSelected="onCostCodeChanged"
                            />
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="row form-group">
                        <label class="col-md-4 col-form-label tw-font-bold tw-pt-0 required"> ครั้งที่ </label>
                        <div class="col-md-8">
                            <pm-el-select name="ct14_version_no" id="input_ct14_version_no" 
                                :select-options="filteredCt14VersionNos"
                                option-key="ct14_version_no"
                                option-value="ct14_version_no" 
                                option-label="ct14_version_no" 
                                :value="ct14VersionNo"
                                :filterable="true"
                                @onSelected="onCt14VersionNoChanged"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-md-5">

                    <div class="row form-group">
                        <label class="col-md-4 col-form-label tw-font-bold tw-pt-0 required"> กลุ่มผลิตภัณฑ์  </label>
                        <div class="col-md-8">
                            
                            <pm-el-select name="product_group" id="input_product_group" 
                                :select-options="filteredProductGroups"
                                option-key="product_group_value"
                                option-value="product_group_value" 
                                option-label="product_group_full_label" 
                                :value="productGroup"
                                :filterable="true"
                                @onSelected="onProductGroupChanged"
                            />

                        </div>
                    </div>

                </div>

                <div class="col-md-7">
                    <div class="row form-group">
                        <label class="col-md-4 col-form-label tw-font-bold tw-pt-0 required"> ผลิตภัณฑ์ </label>
                        <div class="col-md-8">
                            
                            <pm-el-select name="product_inventory_item_id" id="input_product_inventory_item_id" 
                                :select-options="filteredProductItems"
                                option-key="inventory_item_id"
                                option-value="inventory_item_id" 
                                option-label="item_full_desc" 
                                :value="productItem"
                                :filterable="true"
                                @onSelected="onProductItemChanged"
                            />

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-md-5">

                    <div class="row form-group">
                        <label class="col-md-4 col-form-label tw-font-bold tw-pt-0 required"> ปริมาณผลิต </label>
                        <div class="col-md-8">
                            
                            <!-- <input type="number" name="product_quantity" id="input_product_quantity" 
                                class="input-sm text-right form-control" 
                                min="0"
                                oninput="this.value = Math.abs(this.value)"
                                v-model="productQuantity"
                                :disabled="!isAllowUpdate()"
                                @blur="onProductQuantityChanged($event)" /> -->



                            <vue-numeric style="width: 100%;"
                                name="product_quantity"
                                id="input_product_quantity" 
                                v-bind:minus="false"
                                v-bind:precision="2"
                                :min="0"
                                :max="999999999"
                                class="form-control input-sm text-right"
                                v-model="productQuantity"
                                :disabled="!isAllowUpdate()"
                                autocomplete="off"
                                @blur="onProductQuantityChanged($event)"
                            ></vue-numeric>

                        </div>
                    </div>

                </div>

            </div>

            <div class="row tw-mt-5">

                <div class="col-md-12">

                    <div class="text-right">

                        <button class="btn btn-inline-block btn-white tw-w-32"
                            @click="$modal.show('modal-search-oem-cost')">
                            <i class="fa fa-search tw-mr-1"></i> ค้นหา 
                        </button>

                        <button class="btn btn-inline-block btn-primary tw-w-52"
                            :disabled="!isAllowTransfer()"
                            @click="onTransferOemCostData(oemCostHeader, oemCostLines)">
                            <i class="fa fa-arrow-down"></i> โอนข้อมูล
                        </button>

                        <button class="btn btn-inline-block btn-danger tw-w-52"
                            :disabled="!isAllowCancelTransfer()"
                            @click="onCancelTransferOemCostData(oemCostHeader, oemCostLines)">
                            <i class="fa fa-times"></i> ยกเลิกโอนข้อมูล 
                        </button>

                    </div>

                </div>

            </div> 

            <hr>

            <div class="row tw-mb-5">

                <div class="col-12">

                    <table-oem-cost-lines 
                        :period-year-value="periodYear"
                        :oem-cost-header="oemCostHeader"
                        :oem-cost-lines="oemCostLines"
                        :account-codes="accountCodes"
                        :sub-account-codes="subAccountCodes"
                        :account-types="accountTypes"
                        @onOemCostLinesChanged="onOemCostLinesChanged"
                    >
                    </table-oem-cost-lines>

                </div>

            </div>
            
        </div>

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

        <!-- MODAL SEARCH OEM COST -->
        <modal-search-oem-cost 
            modal-name="modal-search-oem-cost" 
            modal-width="1024" 
            modal-height="auto"
            :organization-code="organizationCode"
            :period-year-value="periodYear"
            :period-years="periodYears"
            :prdgrp-plans="prdgrpPlans"
            :ct14-version-nos="ct14VersionNos"
            :cost-centers="costCenters"
            :product-groups="productGroups"
            :product-items="productItems"
            @onSearchOemCostHeader="onSearchOemCostHeader"
        >
        </modal-search-oem-cost>

    </div>

</template>

<script>

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import moment from 'moment';
import VueNumeric from 'vue-numeric';
import TableOemCostLines from "./TableOemCostLines";
import ModalSearchOemCost from "./ModalSearchOemCost";

export default {
    
    components: { Loading, TableOemCostLines, ModalSearchOemCost },

    props: [ 
        "defaultData", 
        "periodYearValue", 
        "prdgrpYearIdValue", 
        "ct14VersionNoValue",
        "costCodeValue", 
        "productGroupValue", 
        "productItemValue", 
        "prdgrpPlans", 
        "ct14VersionNos",
        "periodYears", 
        "existPeriodYears", 
        "costCenters",
        "productGroups", 
        "productItems",
        "accountCodes", 
        "subAccountCodes", 
        "accountTypes"
    ],

    mounted() {

        if(this.periodYearValue) {

            this.getListPrdgrps(this.periodYearValue);

            if(this.prdgrpYearIdValue) {

                this.planVersionNo = this.getPrdgrpPlanVersionNo(this.prdgrpPlans, this.prdgrpYearIdValue);

                this.getListCostCenters(this.periodYearValue, this.prdgrpYearIdValue);

                if(this.costCodeValue) {

                    this.costCode = this.costCodeValue;
                    this.costCodeLabel = this.getCostCodeLabel(this.costCenters, this.costCode);

                    this.getListVersionNos(this.periodYearValue, this.costCodeValue);
                    if(this.ct14VersionNoValue) {
                        this.ct14AllocateYearId = this.getAllocateYearId(this.ct14VersionNos, this.periodYearValue, this.ct14VersionNoValue, this.costCodeValue);
                    }

                    this.filteredProductGroups = this.productGroups.filter(item => {
                        return item.period_year == this.periodYearValue && item.cost_code == this.costCodeValue && item.prdgrp_year_id == this.prdgrpYearIdValue;
                    });

                    if(this.productGroupValue) {

                        this.productGroup = this.productGroupValue;
                        this.productGroupLabel = this.getProductGroupLabel(this.productGroups, this.productGroup);

                        this.filteredProductItems = this.productItems.filter(item => {
                            return item.period_year == this.periodYearValue && item.cost_code == this.costCodeValue && item.prdgrp_year_id == this.prdgrpYearIdValue && item.product_group == this.productGroupValue;
                        });

                        if(this.productItemValue) {
                            this.productItem = this.productItemValue;
                            this.productItemLabel = this.getProductItemLabel(this.productItems, this.productItem);
                        }

                    }

                }

            }
            
        }
        
        if(this.periodYearValue && this.prdgrpYearIdValue && this.ct14VersionNoValue && this.costCodeValue && this.productGroupValue && this.productItemValue) {
            this.getOemCostHeaderData(this.periodYearValue, this.prdgrpYearIdValue, this.planVersionNo, this.ct14VersionNoValue, this.costCodeValue, this.productGroupValue, this.productItemValue, false);
        }   

    },

    data() {
        return {

            organizationId: this.defaultData ? JSON.parse(this.defaultData).organization_id : null,
            organizationCode: this.defaultData ? JSON.parse(this.defaultData).organization_code : null,
            department: this.defaultData ? JSON.parse(this.defaultData).department : null,
            periodYear: this.periodYearValue,
            periodYearLabel: this.getPeriodYearLabel(this.periodYears, this.periodYearValue),
            filteredCt14VersionNos: [],
            ct14VersionNo: this.ct14VersionNoValue,
            ct14AllocateYearId: null,
            filteredCostCenters: [],
            costCode: this.costCodeValue,
            costCodeLabel: null,
            filteredProductGroups: [],
            productGroup: this.productGroupValue,
            productGroupLabel: null,
            filteredProductItems: [],
            productItem: this.productItemValue,
            productItemLabel: null,
            productQuantity: 0,
            filteredPrdgrpPlans: [],
            prdgrpYearId: this.prdgrpYearIdValue,
            planVersionNo: null,
            oemCostHeader: null,
            oemCostLines: [],
            selectedOemCostYearData: {},
            isLoading: false,
        }
    },

    computed: {

    },

    methods: {

        setUrlParams() {

            var queryParams = new URLSearchParams(window.location.search);
            queryParams.set("period_year", this.periodYear ? this.periodYear : '');
            queryParams.set("plan_version_no", this.planVersionNo ? this.planVersionNo : '');
            queryParams.set("prdgrp_year_id", this.prdgrpYearId ? this.prdgrpYearId : '');
            queryParams.set("ct14_version_no", this.ct14VersionNo ? this.ct14VersionNo : '');
            queryParams.set("cost_code", this.costCode ? this.costCode : '');
            queryParams.set("product_group", this.productGroup ? this.productGroup : '');
            queryParams.set("product_inventory_item_id", this.productItem ? this.productItem : '');
            // queryParams.set("product_quantity", this.productQuantity ? this.productQuantity : '');
            window.history.replaceState(null, null, "?"+queryParams.toString());

        },

        async onPeriodYearChanged(value) {
            
            this.periodYear = value;
            this.periodYearLabel = this.getPeriodYearLabel(this.periodYears, this.periodYear);
            this.setUrlParams();

            // REFRESH DATA
            this.oemCostHeader = null;
            this.oemCostLines = [];

            // REFRESH DATA
            this.productGroup = null;
            this.productItem = null;
            this.productQuantity = null;
            this.ct14VersionNo = null;
            this.ct14AllocateYearId = null;
            this.prdgrpYearId = null;

            this.getListPrdgrps(this.periodYear); 
            this.getListCostCenters(this.periodYear, this.prdgrpYearId)
            this.getListVersionNos(this.periodYear, this.prdgrpYearId, this.costCode);
            
            // this.showTableOemCostLines = false;
            
        },

        async onPrdgrpVersionChanged(value) {

            this.prdgrpYearId = value;
            this.planVersionNo = this.getPrdgrpPlanVersionNo(this.prdgrpPlans, this.prdgrpYearId);
            
            
            this.oemCostHeader = null;
            this.oemCostLines = [];


            this.productQuantity = null;

            this.getListCostCenters(this.periodYear, this.prdgrpYearId);

            if(this.periodYear && this.costCode && this.prdgrpYearId) {
                this.filteredProductGroups = this.productGroups.filter(item => {
                    return item.period_year == this.periodYear && item.cost_code == this.costCode && item.prdgrp_year_id == this.prdgrpYearId;
                });
            } else {
                this.filteredProductGroups = [];
                this.filteredProductItems = [];
            }

            if(this.periodYear && this.prdgrpYearId && this.ct14VersionNo && this.costCode && this.productGroup && this.productItem) {
                this.getOemCostHeaderData(this.periodYear, this.prdgrpYearId, this.planVersionNo, this.ct14VersionNo, this.costCode, this.productGroup, this.productItem, false);
            }
            
            this.setUrlParams();

        },

        async onCt14VersionNoChanged(value) {

            this.ct14VersionNo = value;
            this.ct14AllocateYearId = this.getAllocateYearId(this.ct14VersionNos, this.periodYear, this.ct14VersionNo, this.costCode);
            
            this.oemCostHeader = null;
            this.oemCostLines = [];
            
            this.productQuantity = null;

            if(this.periodYear && this.prdgrpYearId && this.ct14VersionNo && this.costCode && this.productGroup && this.productItem) {
                this.getOemCostHeaderData(this.periodYear, this.prdgrpYearId, this.planVersionNo, this.ct14VersionNo, this.costCode, this.productGroup, this.productItem, false);
            }
            
            this.setUrlParams();

        },

        async onCostCodeChanged(value) {
            
            this.costCode = value;
            this.costCodeLabel = this.getCostCodeLabel(this.costCenters, this.costCode);

            this.oemCostHeader = null;
            this.oemCostLines = [];

            this.getListVersionNos(this.periodYear, this.prdgrpYearId, this.costCode);
            
            if(this.periodYear && this.costCode && this.prdgrpYearId) {
                this.filteredProductGroups = this.productGroups.filter(item => {
                    return item.period_year == this.periodYear && item.cost_code == this.costCode && item.prdgrp_year_id == this.prdgrpYearId;
                });
            } else {
                this.filteredProductGroups = [];
                this.filteredProductItems = [];
            }

            this.productGroup = null;
            this.productGroupLabel = null;
            this.productItem = null;
            this.productItemLabel = null;

            this.setUrlParams();

        },

        async onProductGroupChanged(value) {
            
            this.productGroup = value;
            this.productGroupLabel = this.getProductGroupLabel(this.productGroups, this.productGroup);

            this.oemCostHeader = null;
            this.oemCostLines = [];
            
            if(this.periodYear && this.costCode && this.prdgrpYearId && this.productGroup) {
                this.filteredProductItems = this.productItems.filter(item => {
                    return item.period_year == this.periodYear && item.cost_code == this.costCode && item.prdgrp_year_id == this.prdgrpYearId && item.product_group == this.productGroup;
                });
            } else {
                this.filteredProductItems = [];
            }
            
            this.productItem = null;
            this.productItemLabel = null;

            this.productQuantity = null;

            this.setUrlParams();

        },

        async onProductItemChanged(value) {
            
            this.productItem = value;
            this.productItemLabel = this.getProductItemLabel(this.productItems, this.productItem);

            this.oemCostHeader = null;
            this.oemCostLines = [];
            
            this.productQuantity = null;

            // GET OEMCOST-HEADER DATA
            await this.getOemCostHeaderData(this.periodYear, this.prdgrpYearId, this.planVersionNo, this.ct14VersionNo, this.costCode, this.productGroup, this.productItem, false);

            // // SAVE OEM COST HEADER
            // await this.onSaveOemCostHeader();

            this.setUrlParams();

        },

        async onProductQuantityChanged(e) {

            // SAVE OEM COST HEADER
            await this.onSaveOemCostHeader();

        },

        isAllowUpdate() {

            let allowed = true;

            if(this.oemCostHeader && this.oemCostLines.length > 0) {

                const firstLine = this.oemCostLines[0];
                if(firstLine.transfer_data == "Y") {
                    allowed = false;
                }

            }

            return allowed;

        },

        isAllowTransfer() {

            let allowed = false;

            if(this.oemCostHeader && this.oemCostLines.length > 0) {

                const firstLine = this.oemCostLines[0];
                const incompletedLine = this.oemCostLines.find(item => !item.expense_amount);

                if(!incompletedLine && (!firstLine.transfer_data || firstLine.transfer_data == "N") ) {
                    allowed = true;
                }

            }

            return allowed;

        },

        isAllowCancelTransfer() {

            let allowed = false;

            if(this.oemCostHeader && this.oemCostLines.length > 0) {

                const firstLine = this.oemCostLines[0];
                if(firstLine.transfer_data == "Y") {
                    allowed = true;
                }

            }

            return allowed;

        },

        getPeriodYearLabel(periodYears, periodYear) {
            let result = null;
            if(periodYear) {
                const foundPeriodYear = periodYears.find(item => item.period_year_value == periodYear);
                result = foundPeriodYear ? foundPeriodYear.period_year_label : "";
            }
            return result;
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

        getPrdgrpPlanVersionNo(prdgrpPlans, prdgrpYearIdValue) {
            let result = null;
            if(prdgrpYearIdValue){
                const foundPrdgrp = prdgrpPlans.find(item => item.prdgrp_year_id == prdgrpYearIdValue);
                result = foundPrdgrp ? foundPrdgrp.plan_version_no : "";
            }
            return result;
        },

        getAllocateYearId(ct14VersionNos, periodYearValue, ct14VersionNoValue, costCode) {

            let result = null;
            if(ct14VersionNoValue){
                const foundVersion = ct14VersionNos.find(item => {
                    return item.period_year == periodYearValue && item.ct14_version_no == ct14VersionNoValue && item.cost_code == costCode
                });
                result = foundVersion ? foundVersion.ct14_allocate_year_id : "";
            }
            return result;

        },

        getAllocateVersionNo(ct14VersionNos, periodYearValue, ct14AllocateYearId, costCode) {

            let result = null;
            if(ct14AllocateYearId){
                const foundVersion = ct14VersionNos.find(item => {
                    return item.period_year == periodYearValue && item.ct14_allocate_year_id == ct14AllocateYearId && item.cost_code == costCode
                });
                result = foundVersion ? foundVersion.ct14_version_no : "";
            }
            return result;

        },

        validateBeforeGetOemCostHeader(periodYear, prdgrpYearId, ct14VersionNo, costCode, productGroup, productItem) {

            let valid = false;
            if(periodYear && prdgrpYearId && ct14VersionNo && costCode && productGroup && productItem) {
                valid = true;
            }
            return valid;

        },

        validateBeforeSaveOemCostHeader(periodYear, prdgrpYearId, ct14VersionNo, costCode, productGroup, productItem, productQuantity) {

            let valid = false;
            if(periodYear && prdgrpYearId && ct14VersionNo && costCode && productGroup && productItem && productQuantity) {
                valid = true;
            }
            return valid;

        },

        validateBeforeGetOemCostLines(periodYear, oemCostHeader) {

            let valid = false;
            if(periodYear && oemCostHeader) {
                valid = true;
            }
            return valid;
        },

        validateBeforeGenerateAccountTargets(periodYear, oemCostHeader) {

            let valid = false;
            if(periodYear && oemCostHeader) {
                valid = true;
            }
            return valid;

        },

        async getOemCostHeaderData(periodYear, prdgrpYearId, planVersionNo, ct14VersionNo, costCode, productGroup, productItem, isCreateNew) {

            // SHOW LOADING
            this.isLoading = true;

            // REFRESH DATA
            this.oemCostHeader = null;
            
            var params = { 
                period_year: periodYear,
                prdgrp_year_id: prdgrpYearId,
                plan_version_no: planVersionNo,
                ct14_version_no: ct14VersionNo,
                cost_code: costCode,
                product_group: productGroup,
                product_inventory_item_id: productItem
            };

            this.selectedOemCostYearData = {
                period_year: periodYear,
                prdgrp_year_id: prdgrpYearId,
                plan_version_no: planVersionNo,
                ct14_version_no: ct14VersionNo,
                cost_code: costCode,
                product_group: productGroup,
                product_inventory_item_id: productItem,
                product_quantity: this.productQuantity
            }

            // VALIDATE REQUIRED PARAMS BY ORGANIZATION_CODE
            const isValid = this.validateBeforeGetOemCostHeader(periodYear, prdgrpYearId, ct14VersionNo, costCode, productGroup, productItem);
            if(isValid) {

                const resGetOemCostYear = await axios.get("/ajax/ct/oem-costs/header", { params })
                .then(res => {
                    const resData = res.data.data;
                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลต้นทุนมาตรฐานค่าแรงและค่าใช้จ่าย-รับจ้างผลิต | ${resData.message}`, "error");
                    } else {
                        this.oemCostHeader = resData.oem_cost_header ? JSON.parse(resData.oem_cost_header) : null;
                        if(this.oemCostHeader && !isCreateNew) {

                            this.prdgrpYearId = this.oemCostHeader.prdgrp_year_id;
                            this.ct14AllocateYearId = this.oemCostHeader.ct14_allocate_year_id;

                            this.costCode = this.oemCostHeader.cost_code;
                            this.costCodeLabel = this.getCostCodeLabel(this.costCenters, this.costCode);

                            this.productGroup = this.oemCostHeader.product_group;
                            this.productGroupLabel = this.getProductGroupLabel(this.productGroups, this.productGroup);

                            this.productItem = this.oemCostHeader.product_inventory_item_id;
                            this.productQuantity = this.oemCostHeader.product_quantity;

                            this.planVersionNo = this.getPrdgrpPlanVersionNo(this.prdgrpPlans, this.prdgrpYearId);
                            this.ct14VersionNo = this.getAllocateVersionNo(this.ct14VersionNos, this.periodYear, this.ct14AllocateYearId, this.costCode);
                            this.productGroupLabel = this.getProductGroupLabel(this.productGroups, this.productGroup);
                            this.productItemLabel = this.getProductItemLabel(this.productItems, this.productItem);
                        }
                    }
                    return resData;
                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลต้นทุนมาตรฐานค่าแรงและค่าใช้จ่าย-รับจ้างผลิต | ${error.message}`, "error");
                    return ;
                });

                if(resGetOemCostYear.status != "error") {
                    // if(!isCreateNew) {
                    // GET OEMCOST_LINES
                    await this.getOemCostLines(this.periodYear, this.oemCostHeader);
                    // }
                }
                
                this.setUrlParams();

            } else {
                swal("เกิดข้อผิดพลาด", `กรุณากรอกข้อมูลให้ครบถ้วน`, "error");
            }

            // HIDE LOADING
            this.isLoading = false;

        },

        async onTransferOemCostData(oemCostHeader, oemCostLines) {

            // SHOW LOADING
            this.isLoading = true;

            const reqBody = {
                period_year: this.periodYear,
                input_oem_cost_header: JSON.stringify(oemCostHeader),
                input_oem_cost_lines: JSON.stringify(oemCostLines)
            };

            await axios.post(`/ajax/ct/oem-costs/transfer`, reqBody)
            .then(res => {
                const resData = res.data.data;
                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถโอนข้อมูล | ${resData.message}`, "error");
                } else {
                    this.oemCostLines = resData.oem_cost_lines ? JSON.parse(resData.oem_cost_lines) : [];
                }
                return resData;
            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถโอนข้อมูล | ${error.message}`, "error");
                return ;
            });

            // HIDE LOADING
            this.isLoading = false;

        },

        async onCancelTransferOemCostData(oemCostHeader, oemCostLines) {

            // SHOW LOADING
            this.isLoading = true;

            const reqBody = {
                period_year: this.periodYear,
                input_oem_cost_header: JSON.stringify(oemCostHeader),
                input_oem_cost_lines: JSON.stringify(oemCostLines)
            };

            await axios.post(`/ajax/ct/oem-costs/cancel-transfer`, reqBody)
            .then(res => {
                const resData = res.data.data;
                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถยกเลิกโอนข้อมูล | ${resData.message}`, "error");
                } else {
                    this.oemCostLines = resData.oem_cost_lines ? JSON.parse(resData.oem_cost_lines) : [];
                }
                return resData;
            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถยกเลิกโอนข้อมูล | ${error.message}`, "error");
                return ;
            });

            // HIDE LOADING
            this.isLoading = false;

        },

        getListPrdgrps(periodYear) {

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

        getListVersionNos(periodYear, prdgrpYearId, costCode) {

            if(periodYear && costCode) {
                this.filteredCt14VersionNos = this.ct14VersionNos.filter(item => item.period_year == periodYear && item.prdgrp_year_id == prdgrpYearId && item.cost_code == costCode);
            } else {
                this.filteredCt14VersionNos = [];
            }

        },

        async getOemCostLines(periodYear, oemCostHeader) {

            let resultData = null;

            // SHOW LOADING
            this.isLoading = true;

            // REFRESH DATA
            this.oemCostLines = [];
            
            var params = { 
                period_year: periodYear,
                input_oem_cost_header: JSON.stringify(oemCostHeader),
            };

            const isValid = this.validateBeforeGetOemCostLines(periodYear, oemCostHeader);
            if(isValid) {

                resultData = await axios.get("/ajax/ct/oem-costs/lines", { params })
                .then(res => {
                    const resData = res.data.data;
                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลรายการต้นทุนมาตรฐานค่าแรงและค่าใช้จ่าย-รับจ้างผลิต | ${resData.message}`, "error");
                    } else {
                        this.oemCostLines = resData.oem_cost_lines ? JSON.parse(resData.oem_cost_lines) : [];
                    }
                    return resData;
                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลรายการต้นทุนมาตรฐานค่าแรงและค่าใช้จ่าย-รับจ้างผลิต | ${error.message}`, "error");
                    return ;
                });

                // this.showTableOemCostLines = true;

            }

            // HIDE LOADING
            this.isLoading = false;

            return resultData;

        },

        getApproveStatusDesc(status) {
            let statusDesc = "-";
            if(status) {
                const foundStatus = this.approveStatuses.find(item => item.lookup_code == status);
                statusDesc = foundStatus ? foundStatus.description : "-"; 
            }
            return statusDesc;
        },

        onOemCostLinesChanged(data) {
            this.oemCostLines = data.oemCostLines;
        },

        async onSearchOemCostHeader(data) {

            this.oemCostHeader = data.oem_cost_header;
            
            this.periodYear = this.oemCostHeader.period_year;
            this.periodYearLabel = this.getPeriodYearLabel(this.periodYears, this.periodYear);

            this.prdgrpYearId = this.oemCostHeader.prdgrp_year_id;

            this.costCode = this.oemCostHeader.cost_code;
            this.costCodeLabel = this.getCostCodeLabel(this.costCenters, this.costCode);
            // this.onCostCodeChanged(this.oemCostHeader.cost_code);

            this.ct14AllocateYearId = this.oemCostHeader.ct14_allocate_year_id;
            this.ct14VersionNo = this.getAllocateVersionNo(this.ct14VersionNos, this.periodYear, this.ct14AllocateYearId, this.costCode);

            this.productGroup = this.oemCostHeader.product_group;
            this.productGroupLabel = this.getProductGroupLabel(this.productGroups, this.productGroup);
            // this.onProductGroupChanged(this.oemCostHeader.product_group);

            this.productItem = this.oemCostHeader.product_inventory_item_id;
            this.productQuantity = this.oemCostHeader.product_quantity;

            this.planVersionNo = this.getPrdgrpPlanVersionNo(this.prdgrpPlans, this.prdgrpYearId);
            this.productGroupLabel = this.getProductGroupLabel(this.productGroups, this.productGroup);
            this.productItemLabel = this.getProductItemLabel(this.productItems, this.productItem);

            if(this.periodYear) {
                this.getListPrdgrps(this.periodYear);
                this.getListCostCenters(this.periodYear, this.prdgrpYearId);
                this.getListVersionNos(this.periodYear, this.prdgrpYearId, this.costCode);
                this.filteredProductGroups = this.productGroups.filter(item => {
                    return item.period_year == this.periodYearValue && item.cost_code == this.costCode && item.prdgrp_year_id == this.prdgrpYearId;
                });
                this.filteredProductItems = this.productItems.filter(item => {
                    return item.period_year == this.periodYearValue && item.cost_code == this.costCode && item.prdgrp_year_id == this.prdgrpYearId && item.product_group == this.productGroup;
                });
            }

            await this.getOemCostHeaderData(this.periodYear, this.prdgrpYearId, this.planVersionNo, this.ct14VersionNo, this.costCode, this.productGroup, this.productItem, false);

        },

        async onSaveOemCostHeader() {

            const reqBody = {
                period_year: this.periodYear,
                prdgrp_year_id: this.prdgrpYearId,
                plan_version_no: this.planVersionNo,
                ct14_version_no: this.ct14VersionNo,
                cost_code: this.costCode,
                product_group: this.productGroup,
                product_inventory_item_id: this.productItem,
                product_quantity: this.productQuantity,
            };

            const isValid = this.validateBeforeSaveOemCostHeader(this.periodYear, this.prdgrpYearId, this.ct14VersionNo, this.costCode, this.productGroup, this.productItem, this.productQuantity);
            if(isValid) {

                // SHOW LOADING
                this.isLoading = true;

                // call store oem-cost header
                await axios.post(`/ajax/ct/oem-costs/header`, reqBody)
                .then(res => {

                    const resData = res.data.data;
                    const resMsg = resData.message;

                    if(resData.status == "success") {

                        this.oemCostHeader = resData.oem_cost_header ? JSON.parse(resData.oem_cost_header) : null;
                        // this.existPeriodYearOptions = resData.exist_period_years ? JSON.parse(resData.exist_period_years) : [];

                    }

                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `บันทึกต้นทุนมาตรฐานค่าแรงและค่าใช้จ่าย-รับจ้างผลิต | ${resMsg}`, "error");
                    }
                    
                    return resData;

                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `บันทึกต้นทุนมาตรฐานค่าแรงและค่าใช้จ่าย-รับจ้างผลิต | ${error.message}`, "error");
                });

            } else {
                // swal("เกิดข้อผิดพลาด", `ไม่สามารถบันทึกต้นทุนมาตรฐานค่าแรงและค่าใช้จ่าย-รับจ้างผลิต | ${resValidate.message}`, "error");
            }

            // HIDE LOADING
            this.isLoading = false;

        },

        formatDateTh(date) {
            return date ? moment(date).add(543, 'years').format('DD/MM/YYYY') : ""
        },

    }

}

</script>