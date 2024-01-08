<template>

    <div class="tw-pl-10">

        <div class="table-responsive" style="max-height: 600px;">

            <table class="table table-bordered table-sticky mb-0">
                <thead>
                    <tr>
                        <th width="20%" style="background-color: #fff0e0; border-left: 0px; border-right: 0px;" class="text-center tw-text-xs md:tw-table-cell"> 
                            <span v-if="allocateGroup == 'DEPT'"> หน่วยงาน </span>
                            <span v-if="allocateGroup == 'COST'"> ศูนย์ต้นทุน </span>
                            <span v-if="allocateGroup == 'PRODUCT'"> กลุ่มสินค้า </span>
                        </th>
                        <th width="20%" style="background-color: #fff0e0; border-left: 0px; border-right: 0px;" class="text-center tw-text-xs md:tw-table-cell"> รายละเอียด </th>
                        <th width="15%" style="background-color: #fff0e0; border-left: 0px; border-right: 0px;" class="text-right tw-text-xs md:tw-table-cell tw-hidden">  สัดส่วน % </th>
                        <th width="25%" style="background-color: #fff0e0; border-left: 0px; border-right: 0px;" class="text-right tw-text-xs md:tw-table-cell"> ค่าใช้จ่ายประมาณการ </th>
                    </tr>
                </thead>
                <tbody v-if="stdcostTargetItems.length > 0">
                    <template v-for="(stdcostTargetItem, index) in stdcostTargetItems">

                        <template v-for="(targetItem, indexT) in stdcostTargetItem.target_items">

                            <tr :key="`${index}_${indexT}`">

                                <td style="border-left: 0; border-right: 0;" class="text-center md:tw-table-cell">
                                    {{ targetItem.target_code }}
                                </td>
                                <td style="border-left: 0; border-right: 0;" class="text-left md:tw-table-cell">
                                    {{ targetItem.target_code_desc }}
                                </td>
                                <td style="border-left: 0; border-right: 0;" class="text-right md:tw-table-cell tw-hidden">
                                    {{ targetItem.ratio_rate }}
                                </td>
                                <td style="border-left: 0; border-right: 0;" class="text-right md:tw-table-cell">
                                    {{ targetItem.estimate_expense_amount ? Number(targetItem.estimate_expense_amount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "0.00" }} 
                                </td>

                            </tr>

                        </template>

                    </template>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="5">
                            <h2 class="p-3 text-center text-muted">ไม่พบข้อมูล</h2>
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
    
    props: ["periodYearValue", "allocateGroupValue", "stdcostYear", "stdcostAccount", "stdcostTargets"],

    components: { VueNumeric },

    watch: {
        periodYearValue : function (value) {
            this.periodYear = value;
        },
        allocateGroupValue : function (value) {
            this.allocateGroup = value;
        },
        stdcostYear : function (value) {
            this.stdcostYearData = value;
        },
        stdcostAccount : function (value) {
            this.stdcostAccountData = value;
        },
        stdcostTargets : function (value) {
            this.stdcostTargetItems = value;
        },
    },

    data() {

        return {

            periodYear: this.periodYearValue,
            allocateGroup: this.allocateGroupValue,
            stdcostYearData: this.stdcostYear,
            stdcostAccountData: this.stdcostAccount,
            stdcostTargetItems: this.stdcostTargets,

        }

    },

    mounted() {

        // this.emitStdcostTargetsChanged();

    },

    computed: {

    },
    methods: {

        async saveStdcostTarget(stdcostAccountItem, stdcostTargets, stdcostTargetItem) {

            const reqBody = {
                period_year: this.periodYearData,
                input_stdcost_year: JSON.stringify(this.stdcostYearData),
                input_stdcost_account: JSON.stringify(stdcostAccountItem),
                input_stdcost_target: JSON.stringify(stdcostTargetItem),
            };

            // show loading
            this.isLoading = true;

            const resValidate = this.validateBeforeSaveTarget(stdcostAccountItem, stdcostTargets, stdcostTargetItem);
            if(resValidate.valid) {

                // call store sample result
                await axios.post(`/ajax/ct/std-costs/target`, reqBody)
                .then(res => {

                    const resData = res.data.data;
                    const resMsg = resData.message;

                    if(resData.status == "success") {
                        // swal("Success", `บันทึกข้อมูล )`, "success");
                    }

                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ไม่สามารถบันทึกข้อมูล | ${resMsg}`, "error");
                    }
                    
                    return resData;

                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถบันทึกข้อมูล | ${error.message}`, "error");
                });

            } else {
                swal("เกิดข้อผิดพลาด", `ไม่สามารถบันทึกข้อมูล | ${resValidate.message}`, "error");
            }

            // hide loading
            this.isLoading = false;

        },

        validateBeforeSaveTarget(stdcostAccountItem, stdcostTargets, stdcostTargetItem) {

            const result = {
                valid: true,
                message: "",
            };

            // IF NEW LINE ISN'T COMPLETED
            if(!stdcostAccountItem.quantity || !stdcostAccountItem.ratio_rate) {
                result.valid = false;
                result.message = `กรอกข้อมูลรายการเป้าหมายการปันส่วนไม่ครบถ้วน กรุณาตรวจสอบ`
            }

            // IF NEW LINE ISN'T COMPLETED
            if(!stdcostTargetItem.quantity || !stdcostTargetItem.ratio_rate) {
                result.valid = false;
                result.message = `กรอกข้อมูลรายการเป้าหมายการปันส่วนไม่ครบถ้วน กรุณาตรวจสอบ`
            }

            // VALIDATE TOTAL "quantity"
            const totalQty = stdcostTargets.reduce((previousValue, item) => {
                return previousValue + parseFloat(item.quantity)
            }, 0);
            if(totalQty > parseFloat(stdcostAccountItem.quantity)) {
                result.valid = false;
                result.message = `กรอกข้อมูลสัดส่วนเป้าหมายการปันส่วนไม่ถูกต้อง กรุณาตรวจสอบ`
            }

            // VALIDATE TOTAL "ratio_rate"
            const totalRatioRate = stdcostTargets.reduce((previousValue, item) => {
                return previousValue + parseFloat(item.ratio_rate)
            }, 0);
            if(totalRatioRate > parseFloat(stdcostAccountItem.ratio_rate)) {
                result.valid = false;
                result.message = `กรอกข้อมูล % เป้าหมายการปันส่วนไม่ถูกต้อง กรุณาตรวจสอบ`
            }

            return result;

        },

        async onStdcostTargetQuantityChanged(stdcostTargetItem){
            
            // // ALWAYS AUTO-SET "quantity" == "ratio_rate"
            // stdcostTargetItem.ratio_rate = stdcostTargetItem.quantity;
            
            await this.saveStdcostTarget(this.stdcostAccountData, this.stdcostTargetItems, stdcostTargetItem);
            this.emitStdcostTargetsChanged();
        },

        async onStdcostTargetRatioRateChanged(stdcostTargetItem){

            // // ALWAYS AUTO-SET "quantity" == "ratio_rate"
            // stdcostTargetItem.quantity = stdcostTargetItem.ratio_rate;
            
            await this.saveStdcostTarget(this.stdcostAccountData, this.stdcostTargetItems, stdcostTargetItem);
            this.emitStdcostTargetsChanged();
        },

        emitStdcostTargetsChanged() {
            this.$emit("onStdcostTargetsChanged", {
                stdcostTargets: this.stdcostTargetItems
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