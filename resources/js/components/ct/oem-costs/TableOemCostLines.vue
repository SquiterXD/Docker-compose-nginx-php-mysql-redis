<template>

    <div>

        <div v-if="isAllowAddNewLine()" class="text-right">
            <button type="button" class="btn btn-sm btn-inline-block btn-primary tw-w-72 tw-mb-2"
                :disabled="!oemCostHeader"
                @click="onAddNewOemCostLine">
                <i class="fa fa-plus tw-mr-1"></i> เพิ่มรายการค่าแรงและค่าใช้จ่าย-รับจ้างผลิต 
            </button>
        </div>

        <div class="table-responsive" style="max-height: 600px;">

            <table class="table table-bordered table-sticky mb-0">
                <thead>
                    <tr>

                        <th width="15%" class="text-center tw-text-xs md:tw-table-cell" style="z-index: 2;"> รหัสบัญชี </th>
                        <th width="35%" class="text-center tw-text-xs md:tw-table-cell" style="z-index: 2;"> ชื่อบัญชี </th>
                        <th width="20%" class="text-center tw-text-xs md:tw-table-cell" style="z-index: 2;"> ค่าแรง/ค่าใช้จ่าย  </th>
                        <th width="20%" class="text-right tw-text-xs md:tw-table-cell" style="z-index: 2;"> ค่าใช้จ่าย (บาท)  </th>
                        <th v-if="isAllowUpdate()" width="10%"></th>
                    </tr>
                </thead>
                <tbody v-if="oemCostLineItems.length > 0">

                    <template v-for="(oemCostLineItem, index) in oemCostLineItems">

                        <tr :key="`${index}`">

                            <td class="text-center md:tw-table-cell">

                                <template v-if="isAllowUpdate()">

                                    <pm-el-select name="sub_account_code" id="input_sub_account_code" 
                                        :select-options="subAccountCodes"
                                        option-key="sub_account_disp"
                                        option-value="sub_account_disp" 
                                        option-label="sub_account_disp" 
                                        :value="oemCostLineItem.sub_account_disp"
                                        :filterable="true"
                                        @onSelected="onSubAccountCodeChanged($event, oemCostLineItem)"
                                    />

                                </template>
                                <template v-else>
                                    {{ oemCostLineItem.sub_account_disp }}
                                </template>
                                
                            </td>
                            <td class="text-left md:tw-table-cell">
                                {{ oemCostLineItem.sub_account_desc }}
                            </td>
                            <td class="text-left md:tw-table-cell">
                                {{ oemCostLineItem.account_desc }}
                            </td>
                            <td class="text-right md:tw-table-cell">

                                <template v-if="isAllowUpdate()">

                                    <!-- <vue-numeric 
                                        separator="," 
                                        v-bind:precision="9" 
                                        v-bind:minus="true"
                                        :name="`expense_amount${index}`"
                                        :id="`input_expense_amount${index}`"
                                        class="form-control input-sm text-right"
                                        :disabled="isLoading"
                                        v-model="oemCostLineItem.expense_amount"
                                        @blur="onOemCostLineExpenseAmountChanged(oemCostLineItem)"
                                    ></vue-numeric> -->

                                    <input type="number" 
                                        :name="`expense_amount${index}`"
                                        :id="`input_expense_amount${index}`"
                                        class="form-control input-sm text-right"
                                        :disabled="isLoading"
                                        v-model="oemCostLineItem.expense_amount"
                                        @blur="onOemCostLineExpenseAmountChanged(oemCostLineItem)" />

                                </template>
                                <template v-else>
                                    {{ oemCostLineItem.expense_amount ? Number(oemCostLineItem.expense_amount).toLocaleString(undefined, {minimumFractionDigits: 9,maximumFractionDigits: 9}) : "0.000000000" }} 
                                </template>
                                
                            </td>
                            <td v-if="isAllowUpdate()" class="text-center md:tw-table-cell">

                                <template v-if="isAllowUpdate()">
                                    <button class="btn btn-inline-block btn-danger"
                                        @click="onDeleteLine(oemCostLineItem)">
                                        <i class="fa fa-times"></i> ลบ
                                    </button>
                                </template>

                            </td>

                        </tr>

                    </template>

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

        <div v-if="oemCostLineItems.length > 0">
            <table class="table table-bordered table-sticky mb-0">
                <thead>
                    <tr v-if="oemCostLineItems.length > 0">
                        <td width="70%" class="text-right md:tw-table-cell" style="border-left: 0;">
                            <b> รวม </b>
                        </td>
                        <td width="20%" class="text-right md:tw-table-cell" style="border-left: 0;">
                            <b> {{ Number(totalEstimateExpenseAmount).toLocaleString(undefined, {minimumFractionDigits: 9,maximumFractionDigits: 9}) }}  </b>
                        </td>
                        <td v-if="isAllowUpdate()" width="10%" class="text-left md:tw-table-cell" style="border-right: 0;"></td>
                    </tr>
                </thead>
            </table>
        </div>

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

    </div>
                    
</template>

<script>

import VueNumeric from 'vue-numeric'
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import moment from 'moment';

export default {
    
    props: [
        "periodYearValue", 
        "oemCostHeader", 
        "oemCostLines", 
        "accountCodes", 
        "subAccountCodes", 
        "accountTypes"
    ],

    components: { Loading, VueNumeric },

    watch: {
        periodYearValue : function (value) {
            this.periodYear = value;
        },
        oemCostHeader : function (data) {
            this.oemCostHeaderData = data;
        },
        oemCostLines : function (data) {

            this.oemCostLineItems = data.map(item => {
                return {
                    ...item,
                    sub_account_disp: item.sub_account_code ? `${item.account_code}${item.sub_account_code}` : "",
                    expense_amount: !isNaN(item.expense_amount) ? item.expense_amount : 0,
                }
            });

            this.calTotalSummaryAmount();

        },
    },

    data() {

        return {

            periodYear: this.periodYearValue,
            oemCostHeaderData: this.oemCostHeader,
            oemCostLineItems: this.oemCostLines.map(item => {
                return {
                    ...item,
                    sub_account_disp: item.sub_account_code ? `${item.account_code}${item.sub_account_code}` : "",
                    expense_amount: !isNaN(item.expense_amount) ? item.expense_amount : 0
                }
            }),
            totalEstimateExpenseAmount: 0,
            isLoading: false

        }

    },

    mounted() {

        // this.emitOemCostLinesChanged();

    },

    computed: {

    },

    methods: {

        getAllocateTypeLabel(listAllocateTypes, allocateTypeValue) {
            let result = "";
            if(listAllocateTypes.length > 0 && allocateTypeValue) {
                const foundAllocateType = listAllocateTypes.find(item => item.allocate_type_value == allocateTypeValue);
                result = foundAllocateType ? foundAllocateType.allocate_type_label : "";
            }
            return result
        },

        isAllowAddNewLine() {

            let allowed = false;

            if(this.oemCostHeaderData) {
                
                if(this.oemCostLineItems.length > 0) {

                    const firstLine = this.oemCostLineItems[0];
                    if(!firstLine.transfer_data || firstLine.transfer_data == "N") {
                        allowed = true;
                    }

                } else {
                    allowed = true;
                }

            }

            return allowed;

        },

        isAllowUpdate() {

            let allowed = false;

            if(this.oemCostHeaderData) {
                
                if(this.oemCostLineItems.length > 0) {

                    const firstLine = this.oemCostLineItems[0];
                    if(!firstLine.transfer_data || firstLine.transfer_data == "N") {
                        allowed = true;
                    }

                }

            }

            return allowed;

        },

        validateBeforeSaveLine(oemCostLineItem) {

            const result = {
                valid: true,
                message: "",
            };

            if(oemCostLineItem.expense_amount === undefined || oemCostLineItem.expense_amount == null) {
                result.valid = false;
                result.message = `ข้อมูล "ค่าใช้จ่ายประมาณการ" ไม่ถูกต้อง กรุณาตรวจสอบ`
            }

            return result;

        },

        async calTotalSummaryAmount() {
            this.totalEstimateExpenseAmount = this.oemCostLineItems.reduce((pv, cv) => pv + (cv.expense_amount ? parseFloat(cv.expense_amount) : 0), 0);
        },

        async onAddNewOemCostLine(){
            
            const oemCostLineItem = {
                oem_cost_header_id: this.oemCostHeaderData.oem_cost_header_id,
                oem_cost_line_id: null,
                account_code: null,
                account_desc: null,
                sub_account_code: null,
                sub_account_disp: null,
                sub_account_desc: null,
                account_type: null,
                account_type_desc: null,
                expense_amount: 0,
            };

            this.oemCostLineItems = [
                ...this.oemCostLineItems,
                oemCostLineItem
            ];

            const resResult = await this.saveOemCostLine(oemCostLineItem);
            oemCostLineItem.oem_cost_line_id = resResult ? resResult.oem_cost_line_id : null;

            this.calTotalSummaryAmount();
            this.emitOemCostLinesChanged();
            
        },

        async onSubAccountCodeChanged(value, oemCostLineItem) {

            oemCostLineItem.sub_account_disp = value;
            const foundSubAccountCode = this.subAccountCodes.find(item => item.sub_account_disp == value);

            if(foundSubAccountCode) {
                oemCostLineItem.account_code = foundSubAccountCode.account_code;
                const foundAccountCode = this.accountCodes.find(acItem => acItem.account_code == foundSubAccountCode.account_code);
                oemCostLineItem.account_desc = foundAccountCode ? foundAccountCode.account_desc : "";
                oemCostLineItem.sub_account_code = foundSubAccountCode.sub_account_code;
                oemCostLineItem.sub_account_desc = foundSubAccountCode.sub_account_desc;
                oemCostLineItem.account_type = foundSubAccountCode.account_type;
                const foundAccountType = this.accountTypes.find(atItem => atItem.account_type == foundSubAccountCode.account_type);
                oemCostLineItem.account_type_desc = foundAccountType ? foundAccountType.account_type_desc : "";
            }

            const resResult = await this.saveOemCostLine(oemCostLineItem);
            oemCostLineItem.oem_cost_line_id = resResult ? resResult.oem_cost_line_id : null;

            this.calTotalSummaryAmount();
            this.emitOemCostLinesChanged();

        },

        async onOemCostLineExpenseAmountChanged(oemCostLineItem) {

            if(!isNaN(oemCostLineItem.expense_amount)){

                this.$nextTick(async () => {

                    // oemCostLineItem.expense_amount = oemCostLineItem.expense_amount;

                    const resResult = await this.saveOemCostLine(oemCostLineItem);
                    oemCostLineItem.oem_cost_line_id = resResult ? resResult.oem_cost_line_id : null;

                    this.calTotalSummaryAmount();
                    this.emitOemCostLinesChanged();
                
                });

            } else {
                this.$nextTick(() => {
                    oemCostLineItem.expense_amount = 0;
                    this.calTotalSummaryAmount();
                    this.emitOemCostLinesChanged();
                });
            }

        },

        onDeleteLine(oemCostLineItem) {

            swal({
                title: "",
                text: `ต้องการลบรายการ ${oemCostLineItem.sub_account_disp ? oemCostLineItem.sub_account_disp : ""} ${oemCostLineItem.sub_account_desc ? oemCostLineItem.sub_account_desc : ""}  ?`,
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "ลบ",
                cancelButtonText: "ยกเลิก",
                closeOnConfirm: true
            }, async (isConfirm) => {
                if (isConfirm) {
                    await this.deleteOemCostLine(oemCostLineItem);
                    const foundIndex = this.oemCostLineItems.findIndex(item => item == oemCostLineItem );
                    this.oemCostLineItems.splice(foundIndex, 1);
                }
            });

        },

        async saveOemCostLine(oemCostLineItem) {

            const reqBody = {
                period_year: this.periodYear,
                input_oem_cost_header: JSON.stringify(this.oemCostHeader),
                input_oem_cost_line: JSON.stringify(oemCostLineItem)
            };

            // SHOW LOADING
            this.isLoading = true;

            const result = await axios.post(`/ajax/ct/oem-costs/line`, reqBody)
            .then(res => {

                const resData = res.data.data;
                const resMsg = resData.message;
                let resOemCostLine = null;

                if(resData.status == "success") {
                    resOemCostLine = resData.oem_cost_line ? JSON.parse(resData.oem_cost_line) : null;
                }

                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `บันทึกข้อมูล | ${resMsg}`, "error");
                }
                
                return resOemCostLine;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `บันทึกข้อมูล | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

            return result;

        },

        async deleteOemCostLine(oemCostLineItem) {

            const reqBody = {
                period_year: this.periodYear,
                input_oem_cost_header: JSON.stringify(this.oemCostHeader),
                input_oem_cost_line: JSON.stringify(oemCostLineItem)
            };

            // SHOW LOADING
            this.isLoading = true;

            await axios.post(`/ajax/ct/oem-costs/delete-line`, reqBody)
            .then(res => {

                const resData = res.data.data;
                const resMsg = resData.message;

                if(resData.status == "success") {
                    
                }

                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `บันทึกข้อมูล | ${resMsg}`, "error");
                }
                
                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `บันทึกข้อมูล | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

        },

        emitOemCostLinesChanged() {
            this.$emit("onOemCostLinesChanged", {
                oemCostLines: this.oemCostLineItems
            });
        },

        // formatNumber(value) {
        //     let result = value.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        //     return result;
        // },

        // isNumber: function(evt) {
        //     evt = (evt) ? evt : window.event;
        //     var charCode = (evt.which) ? evt.which : evt.keyCode;
        //     if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
        //         evt.preventDefault();;
        //     } else {
        //         return true;
        //     }
        // }

    }

}

</script>