<template>

    <div>

        <h4> บัญชีที่รับปัน </h4>

        <div class="table-responsive" style="max-height: 600px;">

            <table class="table table-bordered table-sticky mb-0">
                <thead>
                    <tr>
                        <th width="15%" class="text-center tw-text-xs md:tw-table-cell"> รหัสบัญชี </th>
                        <th width="15%" class="text-center tw-text-xs md:tw-table-cell"> รหัสบัญชีย่อย </th>
                        <th width="25%" class="text-center tw-text-xs md:tw-table-cell"> ชื่อบัญชี </th>
                        <th width="15%" class="text-right tw-text-xs md:tw-table-cell"> สัดส่วน </th>
                        <th width="15%" class="text-right tw-text-xs md:tw-table-cell"> % </th>
                        <th width="15%"></th>
                        <th width="5%"></th>
                    </tr>
                </thead>
                <tbody v-if="allocateAccountItems.length > 0">
                    <template v-for="(allocateAccountItem, index) in allocateAccountItems">

                        <tr :key="index" v-if="!allocateAccountItem.marked_as_deleted">

                            <td class="text-center md:tw-table-cell">
                                {{ allocateAccountItem.target_acc_code }}
                            </td>
                            <td class="text-center md:tw-table-cell">
                                {{ allocateAccountItem.target_sub_acc_code }}
                            </td>
                            <td class="text-left md:tw-table-cell">
                                <!-- {{ allocateAccountItem.target_acc_code_desc }} -->
                                {{ allocateAccountItem.target_sub_acc_code_desc }}
                            </td>
                            <td class="text-right md:tw-table-cell">
                                <div v-if="!allocateAccountItem.is_show_targets">
                                    <vue-numeric 
                                        separator=","
                                        v-bind:precision="2" 
                                        v-bind:minus="true"
                                        :name="`quantity_${index}`"
                                        :id="`input_quantity_${index}`"
                                        class="form-control input-sm text-right"
                                        v-model="allocateAccountItem.quantity"
                                        @blur="onAllocateAccountQuantityChanged(allocateAccountItem)"
                                    ></vue-numeric>
                                </div>
                                <div v-else>
                                    <input type="text" name="quantity" id="input_quantity" :value="allocateAccountItem.quantity ? Number.parseFloat(allocateAccountItem.quantity).toFixed(2) : ''" class="input-sm text-right form-control" disabled />
                                </div>
                            </td>
                            <td class="text-right md:tw-table-cell">
                                <div v-if="!allocateAccountItem.is_show_targets">
                                    <vue-numeric 
                                        separator=","
                                        v-bind:precision="2" 
                                        v-bind:minus="true"
                                        :name="`ratio_rate_${index}`"
                                        :id="`input_ratio_rate_${index}`"
                                        class="form-control input-sm text-right"
                                        v-model="allocateAccountItem.ratio_rate"
                                        @blur="onAllocateAccountRatioRateChanged(allocateAccountItem)"
                                    ></vue-numeric>
                                </div>
                                <div v-else>
                                    <input type="text" name="ratio_rate" id="input_ratio_rate" :value="allocateAccountItem.ratio_rate ? Number.parseFloat(allocateAccountItem.ratio_rate).toFixed(2) : ''" class="input-sm text-right form-control" disabled />
                                </div>
                            </td>
                            <td class="text-center text-nowrap">
                               <button class="btn btn-inline-block btn-xs btn-white"
                                    @click="onGetAllocateTargets($event, allocateAccountItem)"
                                > 
                                    <i class="fa fa-list tw-mr-1"></i> เป้าหมายที่รับปัน
                                </button>
                            </td>

                            <td class="text-center text-nowrap">
                               <button class="btn btn-inline-block btn-xs btn-danger"
                                    @click="onDeleteAllocateAccountItem($event, allocateAccountItem)"
                                > 
                                    <i class="fa fa-times"></i>
                                </button>
                            </td>

                        </tr>

                        <tr v-if="!allocateAccountItem.marked_as_deleted && allocateAccountItem.is_show_targets" :key="`targets_${index}`">
                            <td colspan="7">
                                <table-allocate-targets 
                                    :period-year-value="periodYear"
                                    :allocate-group-value="allocateGroup"
                                    :dept-code-value="deptCode"
                                    :cost-code-value="costCode"
                                    :cost-group-code-value="costGroupCode"
                                    :allocate-year="allocateYearData"
                                    :allocate-account-item="allocateAccountItem"
                                    :target-account-code="allocateAccountItem.target_account_code"
                                    :allocate-targets="allocateTargets" 
                                    @onAllocateTargetsChanged="onAllocateTargetsChanged"
                                    @onCloseAllocateTargets="onCloseAllocateTargets"
                                >
                                </table-allocate-targets>
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

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

    </div>
                    
</template>

<script>

import VueNumeric from 'vue-numeric'
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import moment from 'moment';

import TableAllocateTargets from "./TableAllocateTargets";

export default {
    
    props: [
        "periodYearValue",
        "allocateGroupValue",
        "deptCodeValue",
        "costCodeValue",
        "costGroupCodeValue", 
        "allocateYear", 
        "allocateAccounts"
    ],

    components: { Loading, VueNumeric, TableAllocateTargets },

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
        allocateAccounts : function (value) {
            this.allocateAccountItems = value.map(item => {
                return {
                    ...item,
                    is_show_targets: false,
                    marked_as_deleted: false,
                }
            });
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
            allocateAccountItems: this.allocateAccounts.map(item => {
                return {
                    ...item,
                    is_show_targets: false,
                    marked_as_deleted: false,
                }
            }),
            allocateTargets: [],
            isLoading: false

        }

    },

    mounted() {

        // this.emitAllocateAccountsChanged();

    },

    computed: {

    },
    methods: {

        async onGetAllocateTargets(e, allocateAccountItem) {

            const resValidate = this.validateBeforeGetTargets(allocateAccountItem);
            if(resValidate.valid) {

                this.allocateTargets = [];

                const toggleShowTargets = !allocateAccountItem.is_show_targets;
                allocateAccountItem.is_show_targets = toggleShowTargets;

                this.allocateAccountItems = this.allocateAccountItems.map(item => {
                    return {
                        ...item,
                        is_show_targets: item.target_account_code == allocateAccountItem.target_account_code ? item.is_show_targets : false,
                    }
                });

                if(toggleShowTargets) {
                    await this.getAllocateTargets(this.allocateYearData, allocateAccountItem);
                }

            } else {
                swal("เกิดข้อผิดพลาด", `${resValidate.message}`, "error");
            }

        },

        async getAllocateTargets(allocateYearData, allocateAccountItem) {

            // SHOW LOADING
            this.isLoading = true;

            var params = { 
                period_year: allocateYearData.period_year,
                version: allocateYearData.version_no,
                allocate_group: allocateAccountItem.allocate_group,
                allocate_type: allocateAccountItem.allocate_type,
                dept_code: allocateAccountItem.dept_code,
                cost_code: allocateAccountItem.cost_code,
                target_account_code: allocateAccountItem.target_account_code,
                input_allocate_year: JSON.stringify(allocateYearData),
            };

            await axios.get(`/ajax/ct/allocate-ratios/targets`, { params })
            .then(res => {

                const resData = res.data.data;
                if(resData.status == "success") {
                    this.allocateTargets = resData.allocate_targets ? JSON.parse(resData.allocate_targets) : [];
                } else {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลเป้าหมายที่รับปัน | ${resData.message}`, "error");                    
                }

                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลเป้าหมายที่รับปัน | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

        },

        isAllowAddAllocateAccount(allocateAccounts) {

            let valid = true;

            // IF NEW LINE ISN'T COMPLETED
            const incompletedLines = allocateAccounts.filter(item => {
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

        onAddAllocateAccountItem() {

            const cloneLastAllocateAccountItem = {
                ...(this.allocateAccountItems.find((item, index) => {
                    return index == (this.allocateAccountItems.length - 1);
                }))
            }
            Object.keys(cloneLastAllocateAccountItem).forEach(k => cloneLastAllocateAccountItem[k] = null)

            this.allocateAccountItems = [
                ...this.allocateAccountItems,
                {
                    ...cloneLastAllocateAccountItem,
                    quantity: 100,
                    ratio_rate: 100,
                    is_new_line: true,
                    marked_as_deleted: false,
                }
            ];

            this.emitAllocateAccountsChanged();

        },

        async saveAllocateAccount(allocateAccountItem) {

            const reqBody = {
                period_year: this.periodYear,
                input_allocate_year: JSON.stringify(this.allocateYear),
                input_allocate_account: JSON.stringify(allocateAccountItem)
            };

            // SHOW LOADING
            this.isLoading = true;

            const resValidate = this.validateBeforeSaveGroup(allocateAccountItem);
            if(resValidate.valid) {

                // call store sample result
                await axios.post(`/ajax/ct/allocate-ratios/account`, reqBody)
                .then(res => {

                    const resData = res.data.data;
                    const resMsg = resData.message;

                    if(resData.status == "success") {
                        // swal("Success", `บันทึกข้อมูลบัญชีที่รับปัน : ${allocateAccountItem.target_account_code}`, "success");
                    }

                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `บันทึกข้อมูลบัญชีที่รับปัน : ${allocateAccountItem.target_account_code} | ${resMsg}`, "error");
                    }
                    
                    return resData;

                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `บันทึกข้อมูลบัญชีที่รับปัน : ${allocateAccountItem.target_account_code} | ${error.message}`, "error");
                });

            } else {
                swal("เกิดข้อผิดพลาด", `บันทึกข้อมูลบัญชีที่รับปัน : ${allocateAccountItem.target_account_code} | ${resValidate.message}`, "error");
            }

            // HIDE LOADING
            this.isLoading = false;

        },

        onDeleteAllocateAccountItem(e, allocateAccountItem) {

            swal({
                title: "",
                text: `ต้องการลบรายการบัญชี ${allocateAccountItem.target_acc_code}${allocateAccountItem.target_sub_acc_code} : ${allocateAccountItem.target_sub_acc_code_desc} ?`,
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "ลบ",
                cancelButtonText: "ยกเลิก",
                closeOnConfirm: true
            }, (isConfirm) => {
                if (isConfirm) {
                    allocateAccountItem.marked_as_deleted = true;
                    this.deleteAllocateAccount(allocateAccountItem);
                }
            });

        },

        async deleteAllocateAccount(allocateAccountItem) {

            const reqBody = {
                period_year: this.periodYear,
                input_allocate_year: JSON.stringify(this.allocateYear),
                input_allocate_account: JSON.stringify(allocateAccountItem)
            };

            // SHOW LOADING
            this.isLoading = true;

            // call store sample result
            await axios.post(`/ajax/ct/allocate-ratios/delete-account`, reqBody)
            .then(res => {

                const resData = res.data.data;
                const resMsg = resData.message;

                if(resData.status == "success") {
                    swal("Success", `ลบข้อมูลบัญชีที่รับปัน : ${allocateAccountItem.target_account_code} )`, "success");
                }

                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `ลบข้อมูลบัญชีที่รับปัน : ${allocateAccountItem.target_account_code} | ${resMsg}`, "error");
                }
                
                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ลบข้อมูลบัญชีที่รับปัน : ${allocateAccountItem.target_account_code} | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

        },

        validateBeforeGetTargets(allocateAccountItem) {

            const result = {
                valid: true,
                message: "",
            };

            // IF NEW LINE ISN'T COMPLETED
            if(!allocateAccountItem.quantity || !allocateAccountItem.ratio_rate) {
                result.valid = false;
                result.message = `กรอกข้อมูลรายการบัญชีที่รับปันไม่ครบถ้วน กรุณาตรวจสอบ`
            }

            return result;

        },

        validateBeforeSaveGroup(allocateAccountItem) {

            const result = {
                valid: true,
                message: "",
            };

            // IF NEW LINE ISN'T COMPLETED
            if(!allocateAccountItem.quantity || !allocateAccountItem.ratio_rate) {
                result.valid = false;
                result.message = `กรอกข้อมูลรายการกำหนดเกณฑ์การปันส่วนไม่ครบถ้วน กรุณาตรวจสอบ`
            }

            return result;

        },

        async onAllocateAccountQuantityChanged(allocateAccountItem){
            
            // ALWAYS AUTO-SET "quantity" == "ratio_rate"
            allocateAccountItem.ratio_rate = allocateAccountItem.quantity;
            
            await this.saveAllocateAccount(allocateAccountItem);
            this.emitAllocateAccountsChanged();

        },

        async onAllocateAccountRatioRateChanged(allocateAccountItem){
            
            // ALWAYS AUTO-SET "quantity" == "ratio_rate"
            allocateAccountItem.quantity = allocateAccountItem.ratio_rate;
            
            await this.saveAllocateAccount(allocateAccountItem);
            this.emitAllocateAccountsChanged();

        },

        onAllocateTargetsChanged(data) {
            this.allocateTargets = data.allocateTargets;
        },

        onCloseAllocateTargets() {
            this.allocateAccountItems = this.allocateAccountItems.map(item => {
                return { ...item, is_show_targets: false }
            });

        },

        emitAllocateAccountsChanged() {
            this.$emit("onAllocateAccountsChanged", {
                allocateAccounts: this.allocateAccountItems
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