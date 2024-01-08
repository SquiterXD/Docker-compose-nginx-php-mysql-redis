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

                <h4> สร้างรายการบัญชี </h4>
                <hr>

                <div class="table-responsive" style="max-height: 300px;">

                    <table class="table table-bordered table-sticky mb-0">
                        <thead>
                            <tr>         
                                <th width="10%" class="text-center md:tw-table-cell"> 
                                    <input type="checkbox" class="i-checks" name="selected" v-model="selectAll" @change="onSelectAll($event, availableTargetAccountItems)"> 
                                </th>
                                <th width="15%" class="text-center tw-text-xs md:tw-table-cell"> รหัสบัญชี </th>
                                <th width="10%" class="text-center tw-text-xs md:tw-table-cell tw-hidden"> รหัสบัญชีย่อย </th>
                                <th width="30%" class="text-center tw-text-xs md:tw-table-cell"> ชื่อบัญชี </th>
                                <th width="15%" class="text-right tw-text-xs md:tw-table-cell"> สัดส่วน </th>
                                <th width="15%" class="text-right tw-text-xs md:tw-table-cell"> % </th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-if="allocateAccountItems.length > 0">
                                <template v-for="(allocateAccountItem, aIndex) in allocateAccountItems">
                                    <tr :key="`allocate_${aIndex}`">
                                        <td class="text-center md:tw-table-cell">
                                            <i class="fa fa-check-square" style="font-size: 1rem;"></i>
                                        </td>
                                        <td class="text-center md:tw-table-cell">
                                            {{ allocateAccountItem.target_acc_code }}
                                        </td>
                                        <td class="text-center md:tw-table-cell tw-hidden">
                                            {{ allocateAccountItem.target_sub_acc_code }}
                                        </td>
                                        <td class="text-left md:tw-table-cell">
                                            <!-- {{ allocateAccountItem.target_acc_code_desc }} -->
                                            {{ allocateAccountItem.target_sub_acc_code_desc }}
                                        </td>
                                        <td class="text-right md:tw-table-cell">
                                            <input type="text" name="quantity" id="input_quantity" :value="allocateAccountItem.quantity ? Number.parseFloat(allocateAccountItem.quantity).toFixed(2) : ''" class="input-sm text-right form-control" disabled />
                                        </td>
                                        <td class="text-right md:tw-table-cell">
                                            <input type="text" name="ratio_rate" id="input_ratio_rate" :value="allocateAccountItem.ratio_rate ? Number.parseFloat(allocateAccountItem.ratio_rate).toFixed(2) : ''" class="input-sm text-right form-control" disabled />
                                        </td>
                                    </tr>
                                </template>
                            </template>
                            <template v-if="availableTargetAccountItems.length > 0">
                                <template v-for="(availableTargetAccountItem, index) in availableTargetAccountItems">

                                    <tr :key="index">

                                        <td class="text-center md:tw-table-cell">
                                            <input type="checkbox" class="i-checks" name="selected" v-model="availableTargetAccountItem.selected" @change="onToggleSelection($event, availableTargetAccountItem)">
                                        </td>
                                        <td class="text-center md:tw-table-cell">
                                            {{ availableTargetAccountItem.target_acc_code }}
                                        </td>
                                        <td class="text-center md:tw-table-cell tw-hidden">
                                            {{ availableTargetAccountItem.target_sub_acc_code }}
                                        </td>
                                        <td class="text-left md:tw-table-cell">
                                            <!-- {{ availableTargetAccountItem.target_acc_code_desc }} -->
                                            {{ availableTargetAccountItem.target_sub_acc_code_desc }}
                                        </td>
                                        <td class="text-right md:tw-table-cell">
                                            <div v-if="availableTargetAccountItem.selected">
                                                <vue-numeric 
                                                    separator=","
                                                    v-bind:precision="2" 
                                                    v-bind:minus="true"
                                                    :name="`quantity_${index}`"
                                                    :id="`input_quantity_${index}`"
                                                    class="form-control input-sm text-right"
                                                    v-model="availableTargetAccountItem.quantity"
                                                    @blur="onTargetAccountQtyChanged(availableTargetAccountItem)"
                                                ></vue-numeric>
                                            </div>
                                            <div v-else>
                                                <input type="text" name="quantity" id="input_quantity" :value="availableTargetAccountItem.quantity ? Number.parseFloat(availableTargetAccountItem.quantity).toFixed(2) : ''" class="input-sm text-right form-control" disabled />
                                            </div>
                                        </td>
                                        <td class="text-right md:tw-table-cell">
                                            <div v-if="availableTargetAccountItem.selected">
                                                <vue-numeric 
                                                    separator=","
                                                    v-bind:precision="2" 
                                                    v-bind:minus="true"
                                                    :name="`ratio_rate_${index}`"
                                                    :id="`input_ratio_rate_${index}`"
                                                    class="form-control input-sm text-right"
                                                    v-model="availableTargetAccountItem.ratio_rate"
                                                    @blur="onTargetAccountRatioRateChanged(availableTargetAccountItem)"
                                                ></vue-numeric>
                                            </div>
                                            <div v-else>
                                                <input type="text" name="ratio_rate" id="input_ratio_rate" :value="availableTargetAccountItem.ratio_rate ? Number.parseFloat(availableTargetAccountItem.ratio_rate).toFixed(2) : ''" class="input-sm text-right form-control" disabled />
                                            </div>
                                        </td>

                                    </tr>

                                </template>
                            </template>
                        </tbody>
                    </table>

                </div>

                <div class="text-right tw-mt-8">

                    <button type="button" 
                        @click="onSubmitCreateAllocateAccounts" 
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
        "targetAccounts",
        "allocateAccounts",
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
        targetAccounts : function (data) {
            this.targetAccountItems = data;
            this.availableTargetAccountItems = this.getAvailableTargetAccountItems(data, this.allocateAccountItems);
        },
        allocateAccounts : function (data) {
            this.allocateAccountItems = data;
            this.availableTargetAccountItems = this.getAvailableTargetAccountItems(this.targetAccountItems, data);
        },
    },

    data() {
        return {
            isLoading: false,
            width: this.modalWidth,
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
            targetAccountItems: this.targetAccounts,
            allocateAccountItems: this.allocateAccounts,
            availableTargetAccountItems: this.getAvailableTargetAccountItems(this.targetAccounts, this.allocateAccounts),
        };
    },

    created() {
        this.handleResize();
    },

    mounted() {
        this.selectAll = false;
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

        onSelectAll(e, targetAccountItems) {
            // console.log("e : ", e);
            this.availableTargetAccountItems = targetAccountItems.map(item => {
                return {
                    ...item,
                    selected: this.selectAll,
                }
            });
        },

        onToggleSelection(e, targetAccountItem) {
            // console.log("e : ", e);
            // console.log("targetAccountItem : ", targetAccountItem);
        },

        getAvailableTargetAccountItems(targetAccountItems, allocateAccountItems) {

            const takenTargetAccountCodes = allocateAccountItems.map(item => item.target_account_code);
            const availableTargetAccounts = targetAccountItems.filter(item => {
                return !takenTargetAccountCodes.find(tItem => tItem == `${item.acc_code}${item.sub_acc_code}`);
            });
            const results = availableTargetAccounts.map(item => {
                return {
                    ...item,
                    target_account_code: item.target_account_code ? item.target_account_code : `${item.acc_code}${item.sub_acc_code}`,
                    target_acc_code: item.target_acc_code ? item.target_acc_code : item.acc_code,
                    target_acc_code_desc: item.target_acc_code_desc ? item.target_acc_code_desc : item.acc_code_desc,
                    target_sub_acc_code: item.target_sub_acc_code ? item.target_sub_acc_code : item.sub_acc_code,
                    target_sub_acc_code_desc: item.target_sub_acc_code_desc ? item.target_sub_acc_code_desc : item.sub_acc_code_desc,
                    selected: false,
                    quantity: 100,
                    ratio_rate: 100
                }
            });

            return results;

        },

        getPeriodYearLabel(periodYears, periodYear) {
            const foundPeriodYear = periodYears.find(item => item.period_year_value == periodYear);
            return foundPeriodYear ? foundPeriodYear.period_year_label : "";
        },

        onTargetAccountItemChanged(item){
            // console.log(item);
        },

        onTargetAccountQtyChanged(item){
            item.ratio_rate = item.quantity;
        },

        onTargetAccountRatioRateChanged(item){
            item.quantity = item.ratio_rate;
        },

        onSubmitCreateAllocateAccounts() {

            this.$modal.hide(this.modalName);

            const selectedTargetAccounts = this.availableTargetAccountItems.filter(item => item.selected);
            this.$emit("onSubmitCreateAllocateAccounts", {
                period_year: this.periodYear,
                version: this.allocateRatioVersion,
                targetAccounts: selectedTargetAccounts
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
.vm--overlay[data-modal="modal-create-allocate-accounts"] {
    height: 100% !important;
}
</style>