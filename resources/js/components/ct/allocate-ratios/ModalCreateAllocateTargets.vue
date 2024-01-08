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

                <h4> สร้างรายการปันส่วน </h4>
                <hr>

                <div class="row tw-my-2">
                    <label class="col-2 col-form-label tw-font-bold text-right"> ค้นหา : </label>
                    <div class="col-10"> 
                        <input type="text" name="keyword" id="input_keyword" v-model="keyword" class="input-sm form-control" />
                    </div>
                </div>

                <div v-if="allocateGroup == 'DEPT'" class="table-responsive" style="min-height: 200px; max-height: 360px;">

                    <table class="table table-bordered table-sticky mb-0">

                        <thead>
                            <tr>
                                <th width="10%" class="text-center md:tw-table-cell"> 
                                    <input type="checkbox" class="i-checks" name="selected" v-model="selectAll" @change="onSelectAll($event, targetDeptCodeItems)"> 
                                </th>
                                <th width="20%" class="text-center tw-text-xs md:tw-table-cell"> เป้าหมายที่รับปัน </th>
                                <th width="30%" class="text-center tw-text-xs md:tw-table-cell"> คำอธิบาย </th>
                                <th width="15%" class="text-right tw-text-xs md:tw-table-cell">  สัดส่วน </th>
                                <th width="15%" class="text-right tw-text-xs md:tw-table-cell tw-hidden"> % </th>
                            </tr>
                        </thead>

                        <tbody v-if="targetDeptCodeItems.length > 0">

                            <template v-for="(targetDeptCode, index) in targetDeptCodeItems">

                                <tr v-show="filterShowingByKeyword(targetDeptCode)" :key="index">
                                    
                                    <td class="text-center md:tw-table-cell">
                                        <input type="checkbox" class="i-checks" name="selected" v-model="targetDeptCode.selected" @change="onToggleSelection($event, targetDeptCode)">
                                    </td>
                                    <td class="text-center md:tw-table-cell">
                                        {{ targetDeptCode.dept_code }}
                                    </td>
                                    <td class="text-left md:tw-table-cell">
                                        {{ targetDeptCode.dept_code_desc }}
                                    </td>
                                    <td class="text-right md:tw-table-cell tw-hidden">
                                        <div v-if="targetDeptCode.selected">
                                            <vue-numeric 
                                                separator="," 
                                                v-bind:precision="2"
                                                v-bind:minus="true"
                                                :name="`quantity_${index}`"
                                                :id="`input_quantity_${index}`"
                                                class="form-control input-sm text-right"
                                                v-model="targetDeptCode.quantity"
                                                @blur="onAllocateTargetQuantityChanged(targetDeptCode, true)"
                                            ></vue-numeric>
                                        </div>
                                        <div v-else>
                                            <input type="text" name="quantity" id="input_quantity" :value="targetDeptCode.quantity ? Number.parseFloat(targetDeptCode.quantity).toFixed(2) : ''" class="input-sm text-right form-control" disabled />
                                        </div>
                                    </td>
                                    <td class="text-right md:tw-table-cell tw-hidden">
                                        <div v-if="targetDeptCode.selected">
                                            <vue-numeric 
                                                separator="," 
                                                v-bind:precision="2"
                                                v-bind:minus="true"
                                                :name="`ratio_rate_${index}`"
                                                :id="`input_ratio_rate_${index}`"
                                                class="form-control input-sm text-right"
                                                v-model="targetDeptCode.ratio_rate"
                                                @blur="onAllocateTargetRatioRateChanged(targetDeptCode, true)"
                                            ></vue-numeric>
                                        </div>
                                        <div v-else>
                                            <input type="text" name="ratio_rate" id="input_ratio_rate" :value="targetDeptCode.ratio_rate ? Number.parseFloat(targetDeptCode.ratio_rate).toFixed(2) : ''" class="input-sm text-right form-control" disabled />
                                        </div>
                                    </td>

                                </tr>

                            </template>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td colspan="5">
                                    <h2 class="p-5 text-center text-muted">ไม่พบข้อมูล</h2>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>

                <div v-if="allocateGroup == 'COST'" class="table-responsive" style="min-height: 200px; max-height: 360px;">

                    <table class="table table-bordered table-sticky mb-0">

                        <thead>
                            <tr>
                                <th width="10%" class="text-center md:tw-table-cell"> 
                                    <input type="checkbox" class="i-checks" name="selected" v-model="selectAll" @change="onSelectAll($event, targetCostCodeItems)"> 
                                </th>
                                <th width="30%" class="text-center tw-text-xs md:tw-table-cell"> เป้าหมายที่รับปัน </th>
                                <th width="30%" class="text-right tw-text-xs md:tw-table-cell">  สัดส่วน </th>
                                <th width="30%" class="text-right tw-text-xs md:tw-table-cell tw-hidden"> % </th>
                            </tr>
                        </thead>

                        <tbody v-if="targetCostCodeItems.length > 0">

                            <template v-for="(targetCostCode, index) in targetCostCodeItems">

                                <tr v-show="filterShowingByKeyword(targetCostCode)" :key="index">
                                    
                                    <td width="10%" class="text-center md:tw-table-cell">
                                        <input type="checkbox" class="i-checks" name="selected" v-model="targetCostCode.selected" @change="onToggleSelection($event, targetCostCode)">
                                    </td>
                                    <td width="30%" class="text-left md:tw-table-cell">
                                        {{ targetCostCode.cost_code }} : {{ targetCostCode.cost_code_desc }}
                                    </td>
                                    <td width="30%" class="text-right md:tw-table-cell tw-hidden">
                                        <div v-if="targetCostCode.selected">
                                            <vue-numeric 
                                                separator="," 
                                                v-bind:precision="2"
                                                v-bind:minus="true"
                                                :name="`quantity_${index}`"
                                                :id="`input_quantity_${index}`"
                                                class="form-control input-sm text-right"
                                                v-model="targetCostCode.quantity"
                                                @blur="onAllocateTargetQuantityChanged(targetCostCode, true)"
                                            ></vue-numeric>
                                        </div>
                                        <div v-else>
                                            <input type="text" name="quantity" id="input_quantity" :value="targetCostCode.quantity ? Number.parseFloat(targetCostCode.quantity).toFixed(2) : ''" class="input-sm text-right form-control" disabled />
                                        </div>
                                    </td>
                                    <td width="30%" class="text-right md:tw-table-cell tw-hidden">
                                        <div v-if="targetCostCode.selected">
                                            <vue-numeric 
                                                separator="," 
                                                v-bind:precision="2"
                                                v-bind:minus="true"
                                                :name="`ratio_rate_${index}`"
                                                :id="`input_ratio_rate_${index}`"
                                                class="form-control input-sm text-right"
                                                v-model="targetCostCode.ratio_rate"
                                                @blur="onAllocateTargetRatioRateChanged(targetCostCode, true)"
                                            ></vue-numeric>
                                        </div>
                                        <div v-else>
                                            <input type="text" name="ratio_rate" id="input_ratio_rate" :value="targetCostCode.ratio_rate ? Number.parseFloat(targetCostCode.ratio_rate).toFixed(2) : ''" class="input-sm text-right form-control" disabled />
                                        </div>
                                    </td>

                                </tr>

                            </template>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td colspan="5">
                                    <h2 class="p-5 text-center text-muted">ไม่พบข้อมูล</h2>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>

                <div v-if="allocateGroup == 'PRODUCT'" class="table-responsive" style="min-height: 200px; max-height: 360px;">

                    <table class="table table-bordered table-sticky mb-0">

                        <thead>
                            <tr>
                                <th width="10%" class="text-center md:tw-table-cell"> 
                                    <input type="checkbox" class="i-checks" name="selected" v-model="selectAll" @change="onSelectAll($event, targetProductGroupItems)"> 
                                </th>
                                <th width="40%" class="text-center tw-text-xs md:tw-table-cell"> เป้าหมายที่รับปัน </th>
                                <th width="20%" class="text-right tw-text-xs md:tw-table-cell">  สัดส่วน </th>
                                <th width="30%" class="text-right tw-text-xs md:tw-table-cell tw-hidden"> % </th>
                            </tr>
                        </thead>

                        <tbody v-if="targetProductGroupItems.length > 0">

                            <template v-for="(targetProductGroup, index) in targetProductGroupItems">

                                <tr v-show="filterShowingByKeyword(targetProductGroup)" :key="index">
                                    
                                    <td width="10%" class="text-center md:tw-table-cell">
                                        <input type="checkbox" class="i-checks" name="selected" v-model="targetProductGroup.selected" @change="onToggleSelection($event, targetProductGroup)">
                                    </td>
                                    <td width="30%" class="text-left md:tw-table-cell">
                                        {{ targetProductGroup.product_group }} : {{ targetProductGroup.description }}
                                    </td>
                                    <td width="30%" class="text-right md:tw-table-cell tw-hidden">
                                        <div v-if="targetProductGroup.selected">
                                            <vue-numeric 
                                                separator="," 
                                                v-bind:precision="2"
                                                v-bind:minus="true"
                                                :name="`quantity_${index}`"
                                                :id="`input_quantity_${index}`"
                                                class="form-control input-sm text-right"
                                                v-model="targetProductGroup.quantity"
                                                @blur="onAllocateTargetQuantityChanged(targetProductGroup, true)"
                                            ></vue-numeric>
                                        </div>
                                        <div v-else>
                                            <input type="text" name="quantity" id="input_quantity" :value="targetProductGroup.quantity ? Number.parseFloat(targetProductGroup.quantity).toFixed(2) : ''" class="input-sm text-right form-control" disabled />
                                        </div>
                                    </td>
                                    <td width="30%" class="text-right md:tw-table-cell tw-hidden">
                                        <div v-if="targetProductGroup.selected">
                                            <vue-numeric 
                                                separator="," 
                                                v-bind:minus="true"
                                                v-bind:precision="costGroupCode == 'P' ? 4 : 2" 
                                                :name="`ratio_rate_${index}`"
                                                :id="`input_ratio_rate_${index}`"
                                                :disabled="costGroupCode == 'P'"
                                                class="form-control input-sm text-right"
                                                v-model="targetProductGroup.ratio_rate"
                                                @blur="onAllocateTargetRatioRateChanged(targetProductGroup, true)"
                                            ></vue-numeric>
                                        </div>
                                        <div v-else>
                                            <input type="text" name="ratio_rate" id="input_ratio_rate" :value="targetProductGroup.ratio_rate ? (costGroupCode == 'P' ? Number.parseFloat(targetProductGroup.ratio_rate).toFixed(4) : Number.parseFloat(targetProductGroup.ratio_rate).toFixed(2)) : ''" class="input-sm text-right form-control" disabled />
                                        </div>
                                    </td>

                                </tr>

                            </template>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td colspan="5">
                                    <h2 class="p-5 text-center text-muted">ไม่พบข้อมูล</h2>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>

                <div class="text-right tw-mt-8">

                    <button type="button" 
                        @click="onSubmitCreateAllocateTargets" 
                        class="btn btn-primary tw-w-32"> 
                        บันทึก 
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

import VueNumeric from 'vue-numeric'
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";

export default {

    props: [
        "modalName", 
        "modalWidth", 
        "modalHeight",
        "organizationCode", 
        "planHeader",
        "periodYears", 
        "periodYearValue",
        "allocateGroupValue",
        "allocateGroupLevelValue",
        "deptCodeValue",
        "costCodeValue",
        "costGroupCodeValue",
        "targetDeptCodes",
        "targetCostCodes",
        "targetProductGroups",
        "previousAllocateTargets"
    ],

    components: { VueNumeric, Loading },

    watch: {
        planHeader : function (value) {
            this.planHeaderData = value;
        },
        periodYears : function (value) {
            this.periodYearOptions = value;
        },
        periodYearValue : function (value) {
            this.periodYear = value;
            this.periodYearLabel = this.getPeriodYearLabel(this.periodYearOptions, value);
        },
        allocateGroupValue : function (value) {
            this.allocateGroup = value;
            this.selectAll = false;
        },
        allocateGroupLevelValue : function (value) {
            this.allocateGroupLevel = value;
        },
        deptCodeValue : function (value) {
            this.deptCode = value;
            this.selectAll = false;
        },
        costCodeValue : function (value) {
            this.costCode = value;
            this.selectAll = false;
        },
        costGroupCodeValue : function (value) {
            this.costGroupCode = value;
        },
        targetDeptCodes: function (data) {
            this.refreshTargetDeptCodeItems(data);
        },
        targetCostCodes: function (data) {
            this.refreshTargetCostCodeItems(data);
        },
        targetProductGroups: function (data) {
            this.refreshTargetProductGroupItems(data);
        },
        previousAllocateTargets: function (data) {

            this.previousAllocateTargetItems = data;

            if(this.allocateGroup == 'DEPT') {
                this.refreshTargetDeptCodeItems(this.targetDeptCodeItems);
            } else if(this.allocateGroup == "COST") {
                this.refreshTargetCostCodeItems(this.targetCostCodeItems);
            } else if(this.allocateGroup == "PRODUCT") {
                this.refreshTargetProductGroupItems(this.targetProductGroupItems);
            }

        },
    },

    data() {
        return {
            isLoading: false,
            width: this.modalWidth,
            keyword: "",
            selectAll: false,
            planHeaderData: this.planHeader,
            periodYear: this.periodYearValue,
            periodYearLabel: this.getPeriodYearLabel(this.periodYears, this.periodYearValue),
            periodYearOptions: this.periodYears,
            allocateGroup: this.allocateGroupValue,
            allocateGroupLevel: this.allocateGroupLevelValue,
            deptCode: this.deptCodeValue,
            costCode: this.costCodeValue,
            costGroupCode: this.costGroupCodeValue,
            previousAllocateTargetItems: this.previousAllocateTargets,
            targetDeptCodeItems: [],
            targetCostCodeItems: [],
            targetProductGroupItems: [],
        };
    },

    created() {
        this.handleResize();
    },

    mounted() {
        
        this.selectAll = false;

        this.previousAllocateTargetItems = this.previousAllocateTargets;
        if(this.allocateGroup == 'DEPT') {
            this.refreshTargetDeptCodeItems(this.targetDeptCodes);
        } else if(this.allocateGroup == "COST") {
            this.refreshTargetCostCodeItems(this.targetCostCodes);
        } else if(this.allocateGroup == "PRODUCT") {
            this.refreshTargetProductGroupItems(this.targetProductGroups);
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

        refreshTargetDeptCodeItems(items) {

            this.targetDeptCodeItems = items ? items.map(item => {
                const foundPvAlcTarget = this.previousAllocateTargetItems.find(pvItem => pvItem.target_dept_code == item.dept_code)
                return  {
                    ...item,
                    target_dept_code: item.target_dept_code ? item.target_dept_code : item.dept_code,
                    selected: foundPvAlcTarget ? true : false,
                    quantity: foundPvAlcTarget ? foundPvAlcTarget.quantity : 0,
                    ratio_rate: foundPvAlcTarget ? foundPvAlcTarget.ratio_rate : 0,
                }
            }) : [];

        },

        refreshTargetCostCodeItems(items) {

            this.targetCostCodeItems = items ? items.map(item => {
                const foundPvAlcTarget = this.previousAllocateTargetItems.find(pvItem => pvItem.target_cost_code == item.cost_code)
                return  {
                    ...item,
                    target_cost_code: item.target_cost_code ? item.target_cost_code : item.cost_code,
                    selected: foundPvAlcTarget ? true : false,
                    quantity: foundPvAlcTarget ? foundPvAlcTarget.quantity : 0,
                    ratio_rate: foundPvAlcTarget ? foundPvAlcTarget.ratio_rate : 0,
                }
            }) : [];

        },

        refreshTargetProductGroupItems(items) {

            this.targetProductGroupItems = items ? items.map(item => {
                const foundPvAlcTarget = this.previousAllocateTargetItems.find(pvItem => pvItem.target_product_group == item.product_group)
                return  {
                    ...item,
                    target_product_group: item.target_product_group ? item.target_product_group : item.product_group,
                    selected: foundPvAlcTarget ? true : false,
                    quantity: foundPvAlcTarget ? foundPvAlcTarget.quantity : 0,
                    ratio_rate: foundPvAlcTarget ? foundPvAlcTarget.ratio_rate : 0
                }
            }) : [];

            // LEVEL == "3" && COST_GROUP_CODE == ‘P’
            if(this.allocateGroup == "PRODUCT" && this.costGroupCode == "P") {

                // AUTO-CALCULATE TARGET PRODUCTGROUP RATIO_RATE
                this.autoCalTargetProductGroupRatioRate();

            }

        },

        filterShowingByKeyword(targetItem) {

            if(this.keyword) {
                if(this.allocateGroup == 'DEPT') {
                    const deptCode = targetItem.dept_code ? targetItem.dept_code : "";
                    const deptCodeDesc = targetItem.dept_code_desc ? targetItem.dept_code_desc : "";
                    if(deptCode.includes(this.keyword) || deptCodeDesc.includes(this.keyword)) {
                        return true;
                    } else {
                        return false;
                    }
                } else if(this.allocateGroup == "COST") {
                    const costCode = targetItem.cost_code ? targetItem.cost_code : "";
                    const costCodeDesc = targetItem.cost_code_desc ? targetItem.cost_code_desc : "";
                    if(costCode.includes(this.keyword) || costCodeDesc.includes(this.keyword)) {
                        return true;
                    } else {
                        return false;
                    }
                } else if(this.allocateGroup == "PRODUCT") {
                    const productGroup = targetItem.product_group ? targetItem.product_group : "";
                    const productGroupDesc = targetItem.description ? targetItem.description : "";
                    if(productGroup.includes(this.keyword) || productGroupDesc.includes(this.keyword)) {
                        return true;
                    } else {
                        return false;
                    }
                }
            } else {
                return true;
            }

        },

        onSelectAll(e, targetItems) {

            const checked = e.target.checked;
            
            if(this.allocateGroup == 'DEPT') {
                this.targetDeptCodeItems = targetItems.map(item => {
                    return {
                        ...item,
                        quantity: checked ? item.quantity : 0,
                        ratio_rate: checked ? item.ratio_rate : 0,
                        selected: this.selectAll,
                    }
                });
            } else if(this.allocateGroup == "COST") {
                this.targetCostCodeItems = targetItems.map(item => {
                    return {
                        ...item,
                        quantity: checked ? item.quantity : 0,
                        ratio_rate: checked ? item.ratio_rate : 0,
                        selected: this.selectAll,
                    }
                });
            } else if(this.allocateGroup == "PRODUCT") {

                if(this.costGroupCode == "P") {

                    this.targetProductGroupItems = targetItems.map(item => {
                        return {
                            ...item,
                            quantity: checked ? (item.quantity ? item.quantity : (item.sum_productivity_area_qty ? item.sum_productivity_area_qty : 0)) : 0,
                            ratio_rate: checked ? item.ratio_rate : 0,
                            selected: this.selectAll,
                        }
                    });

                    // AUTO-CALCULATE TARGET PRODUCTGROUP RATIO_RATE
                    this.autoCalTargetProductGroupRatioRate();

                } else {
                    this.targetProductGroupItems = targetItems.map(item => {
                        return {
                            ...item,
                            quantity: checked ? item.quantity : 0,
                            ratio_rate: checked ? item.ratio_rate : 0,
                            selected: this.selectAll,
                        }
                    });
                }
            }
        },

        onToggleSelection(e, targetItem) {
            
            const checked = e.target.checked;

            if(!checked) {
                targetItem.quantity = 0;
                targetItem.ratio_rate = 0;
            } else {
                if(this.allocateGroup == "PRODUCT" && this.costGroupCode == "P") {
                    targetItem.quantity = targetItem.quantity ? targetItem.quantity : (targetItem.sum_productivity_area_qty ? targetItem.sum_productivity_area_qty : 0);
                }
            }

            this.onAllocateTargetQuantityChanged(targetItem, false);
            this.onAllocateTargetRatioRateChanged(targetItem, false);

        },

        getPeriodYearLabel(periodYears, periodYear) {
            const foundPeriodYear = periodYears.find(item => item.period_year_value == periodYear);
            return foundPeriodYear ? foundPeriodYear.period_year_label : "";
        },

        autoCalTargetProductGroupRatioRate() {

            const selectedItems = this.targetProductGroupItems.filter(item => item.selected);

            const totalQty = selectedItems.reduce((previousValue, item) => {
                return previousValue + parseFloat(item.quantity)
            }, 0);

            this.targetProductGroupItems = this.targetProductGroupItems.map(item => {
                const targetItemQty = item.quantity ? item.quantity : 0;
                const ratioRate = (item.selected && totalQty > 0) ? ((targetItemQty * 100) / totalQty) : 0;
                return {
                    ...item,
                    ratio_rate: ratioRate
                }
            });

        },

        onAllocateTargetQuantityChanged(targetItem, showAlert) {

            let selectedItems = [];
            if(this.allocateGroup == "DEPT") {
                selectedItems = this.targetDeptCodeItems.filter(item => item.selected);
            } else if(this.allocateGroup == "COST") {
                selectedItems = this.targetCostCodeItems.filter(item => item.selected);
            } else if(this.allocateGroup == "PRODUCT") {
                selectedItems = this.targetProductGroupItems.filter(item => item.selected);
            }

            // GENERAL CASE
            if(this.allocateGroup != "PRODUCT" || this.costGroupCode != "P") {

                targetItem.ratio_rate = targetItem.quantity;
                const resValidate = this.validateTargetQuantity(100, selectedItems, targetItem);
                if(resValidate.valid) {

                } else {
                    if(showAlert) { swal("เกิดข้อผิดพลาด", `${resValidate.message}`, "error"); }
                    this.$nextTick(() => {
                        targetItem.quantity = 0;
                        targetItem.ratio_rate = 0;
                    });
                }

            }

            // LEVEL == "3" && COST_GROUP_CODE == ‘P’
            if(this.allocateGroup == "PRODUCT" && this.costGroupCode == "P") {

                // AUTO-CALCULATE TARGET PRODUCTGROUP RATIO_RATE
                this.autoCalTargetProductGroupRatioRate();

            }
            
        },

        onAllocateTargetRatioRateChanged(targetItem, showAlert){

            let selectedItems = [];
            if(this.allocateGroup == "DEPT") {
                selectedItems = this.targetDeptCodeItems.filter(item => item.selected);
            } else if(this.allocateGroup == "COST") {
                selectedItems = this.targetCostCodeItems.filter(item => item.selected);
            } else if(this.allocateGroup == "PRODUCT") {
                selectedItems = this.targetProductGroupItems.filter(item => item.selected);
            }

            // GENERAL CASE
            if(this.allocateGroup != "PRODUCT" || this.costGroupCode != "P") {

                targetItem.quantity = targetItem.ratio_rate;
                const resValidate = this.validateTargetRatioRate(100, selectedItems, targetItem);
                if(resValidate.valid) {

                } else {
                    if(showAlert) { swal("เกิดข้อผิดพลาด", `${resValidate.message}`, "error"); }
                    this.$nextTick(() => {
                        targetItem.quantity = 0;
                        targetItem.ratio_rate = 0;
                    });
                }

            }

            // LEVEL == "3" && COST_GROUP_CODE == ‘P’
            if(this.allocateGroup == "PRODUCT" && this.costGroupCode == "P") {
                // NOT ALLOW UPDATE RATIO_RATE FOR AUTO-CALCULATE QUANTITY YET
            }

        },

        validateTargetQuantity(maxQty, allocateTargets, allocateTargetItem) {

            const result = {
                valid: true,
                message: "",
            };

            // VALIDATE TOTAL "quantity"
            const totalQty = allocateTargets.reduce((previousValue, item) => {
                return previousValue + parseFloat(item.quantity)
            }, 0);

            if(totalQty > parseFloat(maxQty)) {
                result.valid = false;
                result.message = `กรอกข้อมูลสัดส่วนเป้าหมายการปันส่วนไม่ถูกต้อง กรุณาตรวจสอบ`
            }
            
            return result;

        },

        validateTargetRatioRate(maxRatioRate, allocateTargets, allocateTargetItem) {

            const result = {
                valid: true,
                message: "",
            };

            // VALIDATE TOTAL "ratio_rate"
            const totalRatioRate = allocateTargets.reduce((previousValue, item) => {
                return previousValue + parseFloat(item.ratio_rate)
            }, 0);

            if(totalRatioRate > parseFloat(maxRatioRate)) {
                result.valid = false;
                result.message = `กรอกข้อมูล % เป้าหมายการปันส่วนไม่ถูกต้อง กรุณาตรวจสอบ`
            }

            return result;

        },

        validateTargetSummarizedRatioRate(expectedSummarizedRatioRate, allocateTargets) {

            const result = {
                valid: true,
                message: "",
            };

            // VALIDATE TOTAL "ratio_rate"
            const totalRatioRate = allocateTargets.reduce((previousValue, item) => {
                return previousValue + parseFloat(item.ratio_rate)
            }, 0);

            // GENERAL CASE
            if(this.allocateGroup != "PRODUCT" || this.costGroupCode != "P") {

                if(totalRatioRate != expectedSummarizedRatioRate) {
                    result.valid = false;
                    result.message = `ผลรวม สัดส่วน % ไม่ครบ ${expectedSummarizedRatioRate}% กรุณาตรวจสอบ`
                }

            }

            return result;

        },

        onSubmitCreateAllocateTargets() {

            let selectedItems = [];
            if(this.allocateGroup == "DEPT") {
                selectedItems = this.targetDeptCodeItems.filter(item => item.selected);
            } else if(this.allocateGroup == "COST") {
                selectedItems = this.targetCostCodeItems.filter(item => item.selected);
            } else if(this.allocateGroup == "PRODUCT") {
                selectedItems = this.targetProductGroupItems.filter(item => item.selected);
            }
            const resValidate = this.validateTargetSummarizedRatioRate(100, selectedItems);
            if(resValidate.valid) {

                this.$modal.hide(this.modalName);

                const selectedTargetDeptCodes = this.targetDeptCodeItems.filter(item => item.selected);
                const selectedTargetCostCodes = this.targetCostCodeItems.filter(item => item.selected);
                const selectedTargetProductGroups = this.targetProductGroupItems.filter(item => item.selected);

                this.$emit("onSubmitCreateAllocateTargets", {
                    period_year: this.periodYear,
                    targetDeptCodes: selectedTargetDeptCodes,
                    targetCostCodes: selectedTargetCostCodes,
                    targetProductGroups: selectedTargetProductGroups,
                });

            } else {
                swal("เกิดข้อผิดพลาด", `${resValidate.message}`, "error");
            }

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
.vm--overlay[data-modal="modal-create-allocate-targets"] {
    height: 100% !important;
}
</style>