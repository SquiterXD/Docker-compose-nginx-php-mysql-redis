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

                <div class="row form-group">

                    <label class="col-md-4 col-form-label tw-font-bold tw-pt-0"> ปีบัญชี </label>

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

                    <label class="col-md-4 col-form-label tw-font-bold"> ครั้งที่ </label>

                    <div class="col-md-8">

                        <pm-el-select name="yearly_plan_version" id="input_yearly_plan_version" 
                            :select-options="allocateYearVersionOptions"
                            option-key="version_no"
                            option-value="version_no" 
                            option-label="version_no" 
                            :value="allocateYearVersion"
                            :filterable="true"
                            @onSelected="onAllocateYearVersionChanged"
                        />

                    </div>

                </div>

                <div class="row form-group">

                    <label class="col-md-4 col-form-label tw-font-bold tw-pt-0"> ประเภทการปัน </label>

                    <div class="col-md-8">
                        <pm-el-select name="allocate_group" id="input_allocate_group" 
                            :select-options="listAllocateGroups"
                            option-key="allocate_group_value"
                            option-value="allocate_group_value" 
                            option-label="allocate_group_full_label" 
                            :value="allocateGroup"
                            :filterable="true"
                            @onSelected="onListAllocateGroupChanged"
                        />
                    </div>

                </div>

                <div class="row form-group">

                    <template v-if="allocateGroup == 'DEPT' || allocateGroup == 'COST'">
                        <label class="col-md-4 col-form-label tw-font-bold tw-pt-0"> หน่วยงานที่ปัน </label>
                        <div class="col-md-8">
                            <pm-el-select name="dept_code" id="input_dept_code" 
                                :select-options="deptCodeOptions"
                                option-key="dept_code_value"
                                option-value="dept_code_value" 
                                option-label="dept_code_label" 
                                :value="deptCode"
                                :filterable="true"
                                @onSelected="onDeptCodeChanged"
                            />
                        </div>
                    </template>
                    <template v-else-if="allocateGroup == 'PRODUCT'">
                        <label class="col-md-4 col-form-label tw-font-bold tw-pt-0"> ศูนย์ต้นทุน </label>
                        <div class="col-md-8">
                            <pm-el-select name="cost_code" id="input_cost_code" 
                                :select-options="costCodeOptions"
                                option-key="cost_code_value"
                                option-value="cost_code_value" 
                                option-label="cost_code_label" 
                                :value="costCode"
                                :filterable="true"
                                @onSelected="onCostCodeChanged"
                            />
                        </div>
                    </template>
                    <template v-else>
                        <label class="col-md-4 col-form-label tw-font-bold tw-pt-0"> หน่วยงานที่ปัน </label>
                        <div class="col-md-8">
                            <input type="text" name="cost_code" id="input_cost_code" class="input-sm form-control" disabled />
                        </div>
                    </template>

                </div>

                <div class="row form-group">

                    <label class="col-md-4 col-form-label tw-font-bold tw-pt-0"> บัญชีที่รับโอน </label>

                    <div class="col-md-8">
                        
                        <pm-el-select name="transfer_account_code" id="input_transfer_account_code" 
                            :select-options="accountCodeOptions"
                            option-key="account_code_value"
                            option-value="account_code_value" 
                            option-label="account_code_label" 
                            :value="transferAccountCode"
                            :filterable="true"
                            @onSelected="onTransferAccountCodeChanged"
                        />

                    </div>

                </div>

                <div class="text-right tw-mt-8">

                    <button type="button" 
                        @click="onSearchAllocateYearVersion" 
                        class="btn btn-primary tw-w-32"
                        :disabled="!periodYear || !allocateYearVersion"> 
                        เลือก 
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

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";

export default {

    props: [
        "modalName", 
        "modalWidth", 
        "modalHeight",
        "organizationCode", 
        "listAllocateGroups",
        "allocateGroupValue",
        "periodYears", 
        "periodYearValue", 
        "allocateYearVersionValue",
        "accountCodes",
    ],

    components: { Loading },

    watch: {
        periodYears : function (value) {
            this.periodYearOptions = value;
        },
        periodYearValue : function (value) {
            this.periodYearLabel = this.getPeriodYearLabel(this.periodYearOptions, value);
            if(this.periodYearLabel) {
                this.periodYear = value;
                this.getAllocateYearData(this.periodYear);
                this.getDeptCodes(this.periodYear, this.allocateGroup);
                this.getCostCodes(this.periodYear);
            }
        },
        allocateGroupValue : function (value) {
            this.allocateGroup = value;
            this.allocateGroupLevel = this.getAllocateGroupLevel(this.listAllocateGroups, value);
            this.allocateGroupLabel = this.getAllocateGroupLabel(this.listAllocateGroups, value);
            this.getDeptCodes(this.periodYear, this.allocateGroup);
        },
        allocateYearVersionValue : function (value) {
            this.allocateYearVersion = value;
        },
        accountCodes : function (value) {
            this.accountCodeOptions = value;
        },
    },

    data() {
        return {
            isLoading: false,
            width: this.modalWidth,
            periodYear: this.periodYearValue,
            periodYearLabel: this.getPeriodYearLabel(this.periodYears, this.periodYearValue),
            periodYearOptions: this.periodYears,
            allocateYearVersion: this.allocateYearVersionValue,
            allocateYearVersionOptions: [],
            allocateGroup: this.allocateGroupValue,
            allocateGroupLevel: this.getAllocateGroupLevel(this.listAllocateGroups, this.allocateGroupValue),
            allocateGroupLabel: this.getAllocateGroupLabel(this.listAllocateGroups, this.allocateGroupValue),
            deptCodeOptions: [],
            deptCode: null,
            costCodeOptions: [],
            costCode: null,
            costGroupCode: null,
            accountCodeOptions: this.accountCodes,
            transferAccountCode: null,
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
            this.getAllocateYearData(this.periodYear);
            this.getDeptCodes(this.periodYear, this.allocateGroup);
            this.getCostCodes(this.periodYear);
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
            this.periodYearLabel = this.getPeriodYearLabel(this.periodYearOptions, this.periodYear);

            this.getAllocateYearData(this.periodYear);
            this.getDeptCodes(this.periodYear, this.allocateGroup);
            this.getCostCodes(this.periodYear);

        },

        async onListAllocateGroupChanged(value) {
            
            this.allocateGroup = value;
            this.allocateGroupLevel = this.getAllocateGroupLevel(this.listAllocateGroups, value);
            this.allocateGroupLabel = this.getAllocateGroupLabel(this.listAllocateGroups, value);
            this.getDeptCodes(this.periodYear, this.allocateGroup);

            if(this.allocateGroup == 'DEPT' || this.allocateGroup == 'COST') {
                this.costCode = null;
                this.costGroupCode = null;
            }
            if(this.allocateGroup == 'PRODUCT') {
                this.deptCode = null;
            }
            
        },

        async onDeptCodeChanged(value) {
            this.deptCode = value;
        },

        async onCostCodeChanged(value) {
            this.costCode = value;
            const foundCostCode = this.costCodeOptions.find(item => item.cost_code_value == value);
            this.costGroupCode = foundCostCode ? foundCostCode.cost_group_code : null;
        },

        async onTransferAccountCodeChanged(value) {
            this.transferAccountCode = value;
        },

        getAllocateGroupLevel(listAllocateGroups, allocateGroupValue) {
            const foundAllocateGroup = listAllocateGroups.find(item => item.allocate_group == allocateGroupValue);
            return foundAllocateGroup ? foundAllocateGroup.level_no : "";
        },

        getAllocateGroupLabel(listAllocateGroups, allocateGroupValue) {
            const foundAllocateGroup = listAllocateGroups.find(item => item.allocate_group == allocateGroupValue);
            return foundAllocateGroup ? foundAllocateGroup.allocate_group_label : "";
        },

        onAllocateYearVersionChanged(value) {
            this.allocateYearVersion = value;
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

        async getAllocateYearData(periodYear) {

            // show loading
            this.isLoading = true;

            // REFRESH DATA
            this.allocateYearVersionOptions = [];
            
            var params = { 
                period_year: periodYear,
                version: null
            };

            let foundPeriodYear = null;
            if(this.periodYearOptions && periodYear) {
                if(this.periodYearOptions.length > 0) {
                    foundPeriodYear = this.periodYearOptions.find(item => item.period_year_value == periodYear);
                }
            }

            // VALIDATE REQUIRED PARAMS BY ORGANIZATION_CODE
            if(foundPeriodYear) {

                await axios.get("/ajax/ct/allocate-ratios/year", { params })
                .then(res => {
                    const resData = res.data.data;
                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลปันส่วนของปีปัญชี ไม่ถูกต้อง | ${resData.message}`, "error");
                    } else {
                        this.allocateYearVersionOptions = resData.versions ? JSON.parse(resData.versions) : [];
                    }
                    return resData;
                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลปันส่วนของปีปัญชี ไม่ถูกต้อง | ${error.message}`, "error");
                    return ;
                });

            }

            // hide loading
            this.isLoading = false;

        },
        async getDeptCodes(periodYear, allocateGroup) {

            // show loading
            this.isLoading = true;

            // REFRESH DATA
            this.deptCodeOptions = [];
            
            var params = { 
                period_year: periodYear,
                allocate_group: allocateGroup,
                only_exist: true,
            };

            let foundPeriodYear = null;
            if(this.periodYearOptions && periodYear) {
                if(this.periodYearOptions.length > 0) {
                    foundPeriodYear = this.periodYearOptions.find(item => item.period_year_value == periodYear);
                }
            }

            if(foundPeriodYear) {

                await axios.get("/ajax/ct/allocate-ratios/dept-codes", { params })
                .then(res => {
                    const resData = res.data.data;
                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลหน่วยงานที่ปัน | ${resData.message}`, "error");
                    } else {

                        this.deptCodeOptions = resData.dept_codes ? JSON.parse(resData.dept_codes) : [];
                    }
                    return resData;
                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลหน่วยงานที่ปัน | ${error.message}`, "error");
                    return ;
                });

            }

            // hide loading
            this.isLoading = false;

        },

        async getCostCodes(periodYear) {

            // show loading
            this.isLoading = true;

            // REFRESH DATA
            this.costCodeOptions = [];
            
            var params = { 
                period_year: periodYear,
                only_exist: true,
            };

            let foundPeriodYear = null;
            if(this.periodYearOptions && periodYear) {
                if(this.periodYearOptions.length > 0) {
                    foundPeriodYear = this.periodYearOptions.find(item => item.period_year_value == periodYear);
                }
            }

            if(foundPeriodYear) {

                await axios.get("/ajax/ct/allocate-ratios/cost-codes", { params })
                .then(res => {
                    const resData = res.data.data;
                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลหน่วยงานที่ปัน | ${resData.message}`, "error");
                    } else {
                        this.costCodeOptions = resData.cost_codes ? JSON.parse(resData.cost_codes) : [];
                    }
                    return resData;
                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลหน่วยงานที่ปัน | ${error.message}`, "error");
                    return ;
                });

            }

            // hide loading
            this.isLoading = false;

        },

        onSearchAllocateYearVersion() {
            this.$modal.hide(this.modalName);
            this.$emit("onSearchAllocateYearVersion", {
                period_year: this.periodYear,
                version_no: this.allocateYearVersion,
                allocate_group: this.allocateGroup,
                allocate_group: this.allocateGroup,
                dept_code: this.deptCode,
                cost_code: this.costCode,
                cost_group_code: this.costGroupCode,
                transfer_account_code: this.transferAccountCode,
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