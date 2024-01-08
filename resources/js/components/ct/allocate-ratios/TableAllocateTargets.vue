<template>

    <div class="tw-pl-20">

        <div class="table-responsive" style="max-height: 400px;">

            <table class="table table-bordered table-sticky mb-0">
                <thead>
                    <tr>
                        <th width="20%" style="background-color: #fff0e0; border-left: 0px; border-right: 0px;" class="text-center tw-text-xs md:tw-table-cell"> เป้าหมายที่รับปัน </th>
                        <th width="30%" style="background-color: #fff0e0; border-left: 0px; border-right: 0px;" class="text-center tw-text-xs md:tw-table-cell"> คำอธิบาย </th>
                        <th width="20%" style="background-color: #fff0e0; border-left: 0px; border-right: 0px;" class="text-right tw-text-xs md:tw-table-cell">  สัดส่วน </th>
                        <th width="15%" style="background-color: #fff0e0; border-left: 0px; border-right: 0px;" class="text-right tw-text-xs md:tw-table-cell"> % </th>
                    </tr>
                </thead>
                <tbody v-if="allocateTargetItems.length > 0">

                    <template v-for="(allocateTargetItem, index) in allocateTargetItems">

                        <tr :key="index">

                            <td style="border-left: 0; border-right: 0;" class="text-center md:tw-table-cell">
                                {{ allocateTargetItem.target_code }}
                            </td>
                            <td style="border-left: 0; border-right: 0;" class="text-left md:tw-table-cell">
                                {{ allocateTargetItem.target_code_desc }}
                            </td>
                            <td style="border-left: 0; border-right: 0;" class="text-right md:tw-table-cell">
                                <vue-numeric 
                                    separator="," 
                                    v-bind:precision="2"
                                    v-bind:minus="true"
                                    :name="`quantity_${index}`"
                                    :id="`input_quantity_${index}`"
                                    class="form-control input-sm text-right"
                                    v-model="allocateTargetItem.quantity"
                                    @blur="onAllocateTargetQuantityChanged(allocateTargetItem)"
                                ></vue-numeric>
                            </td>
                            <td style="border-left: 0; border-right: 0;" class="text-right md:tw-table-cell">
                                <template v-if="allocateGroup != 'PRODUCT' || costGroupCode != 'P'">
                                    <vue-numeric 
                                        separator="," 
                                        v-bind:precision="2"
                                        v-bind:minus="true"
                                        :name="`ratio_rate_${index}`"
                                        :id="`input_ratio_rate_${index}`"
                                        class="form-control input-sm text-right"
                                        v-model="allocateTargetItem.ratio_rate"
                                        @blur="onAllocateTargetRatioRateChanged(allocateTargetItem)"
                                    ></vue-numeric>
                                </template>
                                <template v-else>
                                    <input type="text" name="ratio_rate" id="input_ratio_rate" :value="allocateTargetItem.ratio_rate ? (costGroupCode == 'P' ? Number.parseFloat(allocateTargetItem.ratio_rate).toFixed(4) : Number.parseFloat(allocateTargetItem.ratio_rate).toFixed(2)) : ''" class="input-sm text-right form-control" disabled />
                                </template>
                            </td>

                        </tr>

                    </template>

                    <tr>
                        <td colspan="4">

                            <div class="text-center tw-my-4">

                                <button type="button" 
                                    @click="onSubmitUpdateAllocateTargets" 
                                    class="btn btn-primary tw-w-32"> 
                                    บันทึก 
                                </button>

                                <button type="button" 
                                    @click="onCloseAllocateTargets" 
                                    class="btn btn-link"> 
                                    ยกเลิก 
                                </button>

                            </div>

                        </td>
                        
                    </tr>

                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="7">
                            <h2 class="p-5 text-center text-muted">ไม่พบข้อมูล</h2>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>

    </div>
                    
</template>

<script>

import VueNumeric from 'vue-numeric'

export default {
    
    props: [
        "periodYearValue", 
        "allocateGroupValue",
        "deptCodeValue",
        "costCodeValue",
        "costGroupCodeValue", 
        "allocateYear", 
        "allocateAccountItem",
        "targetAccountCode", 
        "allocateTargets"
    ],

    components: { VueNumeric },

    watch: {
        periodYearValue : function (value) {
            this.periodYear = value;
        },
        allocateGroupValue : function (value) {
            this.allocateGroup = value;
        },
        deptCodeValue : function (value) {
            this.deptCode = value;
        },
        costCodeValue : function (value) {
            this.costCode = value;
        },
        costGroupCodeValue : function (value) {
            this.costGroupCode = value;
        },
        allocateYear : function (value) {
            this.allocateYearData = value;
        },
        allocateAccountItem : function (value) {
            this.allocateAccountItemData = value;
        },
        targetAccountCode : function (value) {
            this.targetAccountCodeData = value;
        },
        allocateTargets : function (value) {
            this.allocateTargetItems = value;
        },
    },

    data() {

        return {

            periodYear: this.periodYearValue,
            allocateGroup: this.allocateGroupValue,
            deptCode: this.deptCodeValue,
            costCode: this.costCodeValue,
            costGroupCode: this.costGroupCodeValue,
            allocateYearData: this.allocateYear,
            allocateAccountItemData: this.allocateAccountItem,
            targetAccountCodeData: this.targetAccountCode,
            allocateTargetItems: this.allocateTargets,

        }

    },

    mounted() {

        

    },

    computed: {

    },
    methods: {

        isAllowAddAllocateTarget(allocateTargets) {

            let valid = true;

            // IF NEW LINE ISN'T COMPLETED
            const incompletedLines = allocateTargets.filter(item => {
                return item.is_new_line && (
                    item.quantity === "" ||
                    item.quantity === null ||
                    item.ratio_rate === "" ||
                    item.ratio_rate === null
                );
            });

            if(incompletedLines.length > 0) {
                valid = false;
            }

            return valid;

        },

        async updateAllocateTargets(allocateAccountItem, allocateTargets) {

            const reqBody = {
                period_year: this.periodYear,
                input_allocate_year: JSON.stringify(this.allocateYear),
                input_allocate_account: JSON.stringify(allocateAccountItem),
                input_allocate_targets: JSON.stringify(allocateTargets),
            };

            // show loading
            this.isLoading = true;

            // call store sample result
            const responseResult = await axios.post(`/ajax/ct/allocate-ratios/update-targets`, reqBody)
            .then(res => {

                const resData = res.data.data;
                const resMsg = resData.message;

                if(resData.status == "success") {
                    swal("Success", `บันทึกข้อมูลเป้าหมายที่รับปัน`, "success");
                }

                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถบันทึกข้อมูลเป้าหมายที่รับปัน | ${resMsg}`, "error");
                }
                
                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถบันทึกข้อมูลเป้าหมายที่รับปัน | ${error.message}`, "error");
            });

            // hide loading
            this.isLoading = false;

            return responseResult;

        },

        onDeleteAllocateTargetItem(allocateTargetItem) {

            swal({
                title: "",
                text: `ต้องการลบรายการ ${allocateTargetItem.target_code ? allocateTargetItem.target_code : ""} ?`,
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "ลบ",
                cancelButtonText: "ยกเลิก",
                closeOnConfirm: true
            }, (isConfirm) => {
                if (isConfirm) {
                    // allocateTargetItem.marked_as_deleted = true;
                }
            });

        },

        validateBeforeUpdateTargets(allocateAccountItem, allocateTargets) {

            const result = {
                valid: true,
                message: "",
            };

            // IF LINE DATA ISN'T COMPLETED
            const incompletedQtyItem = allocateTargets.find(item => {
                return (item.quantity === "" ||
                    item.quantity === null ||
                    item.ratio_rate === "" ||
                    item.ratio_rate === null)
            });
            if(incompletedQtyItem) {
                result.valid = false;
                result.message = `กรอกข้อมูลรายการเป้าหมายการปันส่วนไม่ครบถ้วน กรุณาตรวจสอบ`
            }

            // VALIDATE TOTAL "quantity"
            const totalQty = allocateTargets.reduce((previousValue, item) => {
                return previousValue + parseFloat(item.quantity)
            }, 0);
            if(totalQty > parseFloat(allocateAccountItem.quantity)) {
                result.valid = false;
                result.message = `กรอกข้อมูลสัดส่วนเป้าหมายการปันส่วนไม่ถูกต้อง กรุณาตรวจสอบ`
            }

            // VALIDATE TOTAL "ratio_rate"
            const totalRatioRate = allocateTargets.reduce((previousValue, item) => {
                return previousValue + parseFloat(item.ratio_rate)
            }, 0);
            if(totalRatioRate > parseFloat(allocateAccountItem.ratio_rate)) {
                result.valid = false;
                result.message = `กรอกข้อมูล % เป้าหมายการปันส่วนไม่ถูกต้อง กรุณาตรวจสอบ`
            }

            // GENERAL CASE
            if(this.allocateGroup != "PRODUCT" || this.costGroupCode != "P") {

                if(totalRatioRate != 100) {
                    result.valid = false;
                    result.message = `ผลรวม สัดส่วน % ไม่ครบ 100% กรุณาตรวจสอบ`
                }

            }

            return result;

        },

        async onAllocateTargetQuantityChanged(targetItem) {

            const selectedItems = this.allocateTargetItems;

            // GENERAL CASE
            if(this.allocateGroup != "PRODUCT" || this.costGroupCode != "P") {

                targetItem.ratio_rate = targetItem.quantity;
                const resValidate = this.validateTargetQuantity(100, selectedItems, targetItem);
                if(resValidate.valid) {
                    
                } else {
                    swal("เกิดข้อผิดพลาด", `${resValidate.message}`, "error");
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

        async onAllocateTargetRatioRateChanged(targetItem){
            
            const selectedItems = this.allocateTargetItems;

            // GENERAL CASE
            if(this.allocateGroup != "PRODUCT" || this.costGroupCode != "P") {

                targetItem.quantity = targetItem.ratio_rate;
                const resValidate = this.validateTargetRatioRate(100, selectedItems, targetItem);
                if(resValidate.valid) {
                    
                } else {
                    swal("เกิดข้อผิดพลาด", `${resValidate.message}`, "error");
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

        autoCalTargetProductGroupRatioRate() {

            const selectedItems = this.allocateTargetItems;
            const totalQty = selectedItems.reduce((previousValue, item) => {
                return previousValue + parseFloat(item.quantity)
            }, 0);

            this.allocateTargetItems = this.allocateTargetItems.map(item => {
                const targetItemQty = item.quantity ? item.quantity : 0;
                const ratioRate = (totalQty > 0) ? ((targetItemQty * 100) / totalQty) : 0;
                return {
                    ...item,
                    ratio_rate: ratioRate
                }
            });

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

            if(totalRatioRate != expectedSummarizedRatioRate) {
                result.valid = false;
                result.message = `ผลรวม สัดส่วน % ไม่ครบ ${expectedSummarizedRatioRate}% กรุณาตรวจสอบ`
            }

            return result;

        },

        async onSubmitUpdateAllocateTargets() {

            const resValidate = this.validateBeforeUpdateTargets(this.allocateAccountItemData, this.allocateTargetItems);
            if(resValidate.valid) {

                // SAVE ALLOCATE TARGET ITEMS
                const responseResult = await this.updateAllocateTargets(this.allocateAccountItemData, this.allocateTargetItems)
                
                if(responseResult.status == "success") {
                    this.emitAllocateTargetsChanged();
                    this.onCloseAllocateTargets();
                }

            } else {
                swal("เกิดข้อผิดพลาด", `${resValidate.message}`, "error");
            }

        },

        onCloseAllocateTargets() {
            this.$emit("onCloseAllocateTargets");
        },

        emitAllocateTargetsChanged() {
            this.$emit("onAllocateTargetsChanged", {
                allocateTargets: this.allocateTargetItems
            });
        },

        formatNumber(value) {
            let result = value.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return result;
        },

        isNumber: function(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                evt.preventDefault();;
            } else {
                return true;
            }
        }

    }

}

</script>