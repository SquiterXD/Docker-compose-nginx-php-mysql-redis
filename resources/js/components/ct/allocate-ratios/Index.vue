<template>

    <div class="ibox">

        <div class="ibox-content" style="min-height: 600px;">

            <div class="row">

                <div class="col-md-6">

                    <div class="row form-group">

                        <label class="col-md-4 col-form-label tw-font-bold tw-pt-0"> ปีบัญชี </label>

                        <div class="col-md-3">

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

                    <div class="row form-group">

                        <label class="col-md-4 col-form-label tw-font-bold"> วันที่เริ่ม </label>

                        <div class="col-md-8">
                            <p v-if="periodYearStartDate" class="col-form-label"> {{ periodYearStartDate }} </p>
                            <p v-if="!periodYearStartDate" class="col-form-label"> - </p>
                        </div>

                    </div>   

                    <div class="row form-group">

                        <label class="col-md-4 col-form-label tw-font-bold"> สถานะ </label>

                        <div class="col-md-8">
                            <p v-if="allocateYear" class="col-form-label"> {{ getApproveStatusDesc(allocateYear.approved_status) }} </p>
                            <p v-if="!allocateYear" class="col-form-label"> - </p>
                        </div>

                    </div>                     

                </div>

                <div class="col-md-6">

                    <div class="row form-group">

                        <label class="col-md-4 col-form-label tw-font-bold"> ครั้งที่ </label>

                        <div class="col-md-8">
                            <p v-if="allocateYear" class="col-form-label"> {{ allocateYear.version_no ? allocateYear.version_no : "-" }} </p>
                            <p v-if="!allocateYear" class="col-form-label"> - </p>
                        </div>

                    </div>

                    <div class="row form-group">

                        <label class="col-md-4 col-form-label tw-font-bold"> วันที่สิ้นสุด </label>

                        <div class="col-md-8">
                            <p v-if="periodYearEndDate" class="col-form-label"> {{ periodYearEndDate }} </p>
                            <p v-if="!periodYearEndDate" class="col-form-label"> - </p>
                        </div>

                    </div>

                </div>

            </div>

            <div class="tw-mb-4">

                <div class="text-right tw-mr-6 tw-mb-2">

                    <button class="btn btn-inline-block btn-sm btn-white tw-w-32"
                        @click="$modal.show('modal-search-allocate-year')">
                        <i class="fa fa-search tw-mr-1"></i> ค้นหา 
                    </button>

                    <button class="btn btn-inline-block btn-sm btn-primary tw-w-32"
                        @click="onCreateNewAllocateYearVersion"
                        :disabled="!isAllowCreateNewVersion(allocateYearVersions)"
                    > 
                        <i class="fa fa-plus tw-mr-1"></i> สร้าง 
                    </button>

                    <button class="btn btn-inline-block btn-sm btn-warning tw-w-32"
                        @click="$modal.show('modal-copy-new-version')">
                        <i class="fa fa-copy tw-mr-1"></i> คัดลอกข้อมูล 
                    </button>

                    <a :href="'/ct/allocate-ratios'" class="btn btn-inline-block btn-sm btn-danger tw-w-32"> ล้าง </a>

                </div>

            </div>

            <hr>

            <div class="row tw-mt-6">

                <div class="offset-md-2 col-md-4">

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

                        <label class="col-md-4 col-form-label tw-font-bold tw-pt-0"> เกณฑ์การปัน </label>

                        <div class="col-md-8">

                            <!-- <template v-if="allocateAccounts.length <= 0"> -->
                            <pm-el-select name="allocate_type" id="input_allocate_type" 
                                :select-options="allocateTypes"
                                option-key="allocate_type_value"
                                option-value="allocate_type_value" 
                                option-label="allocate_type_full_label" 
                                :value="allocateType"
                                :filterable="true"
                                @onSelected="onAllocateTypeChanged"
                            />
                            <!-- </template>
                            <template v-else>
                                <p class="col-form-label"> {{ allocateTypeLabel ? allocateTypeLabel : "-" }} </p>
                            </template> -->

                        </div>

                    </div>

                    <div class="row form-group">

                        <label class="col-md-4 col-form-label tw-font-bold tw-pt-0"> บัญชีที่รับโอน </label>

                        <div class="col-md-8">

                            <!-- <template v-if="allocateAccounts.length <= 0"> -->
                            <pm-el-select name="transfer_account_code" id="input_transfer_account_code" 
                                :select-options="accountCodes"
                                option-key="account_code_value"
                                option-value="account_code_value" 
                                option-label="account_code_label" 
                                :value="transferAccountCode"
                                :filterable="true"
                                @onSelected="onTransferAccountCodeChanged"
                            />
                            <!-- </template>
                            <template v-else>
                                <p class="col-form-label"> {{ transferAccountCode ? transferAccountCode : "-" }} </p>
                            </template> -->

                        </div>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="row form-group">

                        <template v-if="allocateGroupLevel == '1' || allocateGroupLevel == '2'">
                            <label class="col-md-4 col-form-label tw-font-bold tw-pt-0"> หน่วยงานที่ปัน </label>
                            <div class="col-md-8">
                                <pm-el-select name="dept_code" id="input_dept_code" 
                                    :select-options="deptCodes"
                                    option-key="dept_code_value"
                                    option-value="dept_code_value" 
                                    option-label="dept_code_full_label" 
                                    :value="deptCode"
                                    :filterable="true"
                                    @onSelected="onDeptCodeChanged"
                                />
                            </div>
                        </template>
                        <template v-else-if="allocateGroupLevel == '3'">
                            <label class="col-md-4 col-form-label tw-font-bold tw-pt-0"> ศูนย์ต้นทุน </label>
                            <div class="col-md-8">
                                <pm-el-select name="cost_code" id="input_cost_code" 
                                    :select-options="costCodes"
                                    option-key="cost_code_value"
                                    option-value="cost_code_value" 
                                    option-label="cost_code_full_label" 
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

                    <div class="row form-group"> &nbsp; </div>

                    <div class="row form-group">

                        <div class="offset-md-4 col-md-8">

                            <div class="text-right tw-mb-2">
                                <button class="btn btn-sm btn-primary tw-w-full"
                                    @click="onShowModalCreateAllocateAccounts"
                                    :disabled="!isAllowCreateAllocateAccounts()" 
                                >
                                    <i class="fa fa-plus tw-mr-1"></i> สร้างรายการบัญชี 
                                </button>
                            </div>

                        </div>

                    </div>

                </div>

                <!-- <div class="col-md-2">

                </div> -->

            </div>

            <div class="row">

                <div class="col-md-12">

                    <hr>

                    <div class="row tw-mb-5">

                        <div class="col-12">

                            <div class="text-right tw-mb-2">

                                <button class="btn btn-inline-block btn-sm btn-warning tw-w-52"
                                    @click="onShowModalCreateAllocateTargets"
                                    :disabled="!isAllowCreateAllocateTargets()"
                                >
                                    <i class="fa fa-plus tw-mr-1"></i> สร้างรายการปันส่วน
                                </button>

                                <button class="btn btn-inline-block btn-sm btn-danger tw-ml-2"
                                    @click="onDeleteAllAllocateAccountItem($event)"
                                    :disabled="allocateAccounts.length <= 0"
                                > 
                                    <i class="fa fa-times"></i> ลบบัญชีทั้งหมด
                                </button>

                            </div>

                        </div>

                        <div class="col-12">

                            <table-allocate-accounts 
                                :period-year-value="periodYear"
                                :allocate-year="allocateYear"
                                :allocate-accounts="allocateAccounts" 
                                :allocate-group-value="allocateGroup"
                                :dept-code-value="deptCode"
                                :cost-code-value="costCode"
                                :cost-group-code-value="costGroupCode"
                                @onAllocateAccountsChanged="onAllocateAccountsChanged"
                            >
                            </table-allocate-accounts>

                        </div>

                    </div>

                </div>

            </div>
            
        </div>

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

        <!-- MODAL SEARCH ALLOCATE YEAR -->
        <modal-search-allocate-year 
            modal-name="modal-search-allocate-year" 
            modal-width="640" 
            modal-height="auto"
            :organization-code="organizationCode"
            :allocate-group-value="allocateGroup"
            :list-allocate-groups="listAllocateGroups"
            :period-years="existPeriodYearOptions"
            :period-year-value="periodYear"
            :allocate-year-version-value="allocateYearVersion"
            :allocate-year-versions="allocateYearVersions"
            :account-codes="existAccountCodeOptions"
            @onSearchAllocateYearVersion="onSearchAllocateYearVersion"
        >
        </modal-search-allocate-year>

        <!-- MODAL COPY NEW VERSION -->
        <modal-copy-new-version 
            modal-name="modal-copy-new-version" 
            modal-width="640" 
            modal-height="auto"
            :organization-code="organizationCode"
            :period-year-value="periodYear"
            :period-years="periodYears"
            :to-allocate-year-version-value="nextAllocateYearVersion"
            @onCopyAllocateYearNewVersion="onCopyAllocateYearNewVersion"
        >
        </modal-copy-new-version>

        <!-- MODAL CREATE ALLOCATE ACCOUNTS -->
        <modal-create-allocate-accounts 
            modal-name="modal-create-allocate-accounts" 
            modal-width="960" 
            modal-height="auto"
            :organization-code="organizationCode"
            :period-years="periodYears"
            :period-year-value="periodYear"
            :allocate-group-value="allocateGroup"
            :allocate-group-level-value="allocateGroupLevel"
            :dept-code-value="deptCode"
            :cost-code-value="costCode"
            :cost-group-code-value="costGroupCode"
            :target-accounts="targetAccounts"
            :allocate-accounts="allocateAccounts"
            @onSubmitCreateAllocateAccounts="onSubmitCreateAllocateAccounts"
        >
        </modal-create-allocate-accounts>

        <!-- MODAL CREATE ALLOCATE TARGETS -->
        <modal-create-allocate-targets 
            modal-name="modal-create-allocate-targets" 
            modal-width="960" 
            modal-height="auto"
            :organization-code="organizationCode"
            :period-years="periodYears"
            :period-year-value="periodYear"
            :allocate-group-value="allocateGroup"
            :allocate-group-level-value="allocateGroupLevel"
            :dept-code-value="deptCode"
            :cost-code-value="costCode"
            :cost-group-code-value="costGroupCode"
            :target-dept-codes="targetDeptCodes"
            :target-cost-codes="targetCostCodes"
            :target-product-groups="targetProductGroups"
            :previous-allocate-targets="previousAllocateTargets"
            @onSubmitCreateAllocateTargets="onSubmitCreateAllocateTargets"
        >
        </modal-create-allocate-targets>

    </div>

</template>

<script>

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import moment from 'moment';

import TableAllocateAccounts from "./TableAllocateAccounts";
import ModalSearchAllocateYear from "./ModalSearchAllocateYear";
import ModalCopyNewVersion from "./ModalCopyNewVersion";
import ModalCreateAllocateAccounts from "./ModalCreateAllocateAccounts";
import ModalCreateAllocateTargets from "./ModalCreateAllocateTargets";

export default {
    
    components: { Loading, TableAllocateAccounts, ModalSearchAllocateYear, ModalCopyNewVersion, ModalCreateAllocateAccounts, ModalCreateAllocateTargets },

    props: [ "defaultData", "periodYearValue", "allocateGroupValue", "allocateTypeValue", "transferAccountCodeValue", "deptCodeValue", "costCodeValue", "versionValue", "periodYears", "existPeriodYears", "approveStatuses", "listAllocateGroups", "allocateTypes", "accountCodes", "existAccountCodes" ],

    async mounted() {
        
        await this.getDeptCodes(this.periodYearValue);
        await this.getCostCodes(this.periodYearValue);
        await this.getAllocateYearData(this.periodYearValue, this.versionValue);
        await this.getTargetAccounts(this.periodYearValue, this.allocateGroupValue, this.deptCodeValue, this.costCodeValue);

        // await this.getTargetDeptCodes(this.periodYearValue, this.allocateGroupValue, this.deptCodeValue, this.costCodeValue);
        // await this.getTargetCostCodes(this.periodYearValue, this.allocateGroupValue, this.deptCodeValue, this.costCodeValue);

    },

    data() {
        return {
            organizationId: this.defaultData ? JSON.parse(this.defaultData).organization_id : null,
            organizationCode: this.defaultData ? JSON.parse(this.defaultData).organization_code : null,
            department: this.defaultData ? JSON.parse(this.defaultData).department : null,
            periodYear: this.periodYearValue,
            periodYearLabel: this.getPeriodYearLabel(this.periodYears, this.periodYearValue),
            periodYearStartDate: null,
            periodYearEndDate: null,
            existPeriodYearOptions: this.existPeriodYears,
            allocateYear: null,
            allocateYearVersion: this.versionValue,
            allocateYearVersions: [],
            allocateGroup: this.allocateGroupValue,
            allocateGroupLevel: this.getAllocateGroupLevel(this.listAllocateGroups, this.allocateGroupValue),
            allocateGroupLabel: this.getAllocateGroupLabel(this.listAllocateGroups, this.allocateGroupValue),
            allocateType: this.allocateTypeValue,
            allocateTypeLabel: this.getAllocateTypeLabel(this.allocateTypes, this.allocateTypeValue),
            transferAccountCode: this.transferAccountCodeValue,
            transferAccCode: this.getTransferAccCode(this.accountCodes, this.transferAccountCodeValue),
            transferSubAccCode: this.getTransferSubAccCode(this.accountCodes, this.transferAccountCodeValue),
            deptCodes: [],
            deptCode: this.deptCodeValue,
            costCodes: [],
            costCode: this.costCodeValue,
            costGroupCode: null,
            existAccountCodeOptions: this.existAccountCodes,
            targetAccounts: [],
            targetDeptCodes: [],
            targetCostCodes: [],
            targetProductGroups: [],
            allocateAccounts: [],
            previousAllocateTargets: [],
            nextAllocateYearVersion: 1,
            isLoading: false
        }
    },

    computed: {

    },

    methods: {

        setUrlParams() {

            var queryParams = new URLSearchParams(window.location.search);
            queryParams.set("period_year", this.periodYear ? this.periodYear : '');
            queryParams.set("allocate_group", this.allocateGroup ? this.allocateGroup : '');
            queryParams.set("allocate_type", this.allocateType ? this.allocateType : '');
            queryParams.set("transfer_account_code", this.transferAccountCode ? this.transferAccountCode : '');
            queryParams.set("dept_code", this.deptCode ? this.deptCode : '');
            queryParams.set("cost_code", this.costCode ? this.costCode : '');
            queryParams.set("version", this.allocateYearVersion ? this.allocateYearVersion : '');
            window.history.replaceState(null, null, "?"+queryParams.toString());

        },

        async onPeriodYearChanged(value) {
            
            this.periodYear = value;
            this.periodYearLabel = this.getPeriodYearLabel(this.periodYears, this.periodYear);
            this.setUrlParams();

            this.deptCode = null;
            this.costCode = null;
            this.costGroupCode = null;
            this.transferAccountCode = "";
            this.allocateAccounts = [];

            await this.getAllocateYearData(this.periodYear, null);
            await this.getDeptCodes(this.periodYear);
            await this.getCostCodes(this.periodYear);
            await this.getTargetAccounts(this.periodYear, this.allocateGroup, this.deptCode, this.costCode);
            await this.getAllocateAccounts();
            
            if(this.allocateAccounts.length > 0) {
                this.getTargetDeptCodes(this.periodYear, this.allocateGroup, this.deptCode, this.costCode);
                this.getTargetCostCodes(this.periodYear, this.allocateGroup, this.deptCode, this.costCode);
                this.getTargetProductGroups(this.periodYear, this.allocateGroup, this.deptCode, this.costCode);
            }
            
        },

        async onListAllocateGroupChanged(value) {
            
            this.allocateGroup = value;
            this.allocateGroupLevel = this.getAllocateGroupLevel(this.listAllocateGroups, value);
            this.allocateGroupLabel = this.getAllocateGroupLabel(this.listAllocateGroups, value);
            this.allocateAccounts = [];

            if(this.allocateGroupLevel == '1' || this.allocateGroupLevel == '2') {
                this.costCode = null;
                this.costGroupCode = null;
            }
            if(this.allocateGroupLevel == '3') {
                this.deptCode = null;
            }

            await this.getTargetAccounts(this.periodYear, this.allocateGroup, this.deptCode, this.costCode);
            this.getAllocateAccounts();
            
            this.setUrlParams();
            
        },

        async onAllocateTypeChanged(value) {
            
            this.allocateType = value;
            this.allocateTypeLabel = this.getAllocateTypeLabel(this.allocateTypes, this.allocateType);
            
            if(this.allocateAccounts.length > 0) {
                await this.onSaveAllocateAccounts(this.allocateAccounts, false);
                this.getAllocateAccounts();
            }

            this.setUrlParams();
            
        },

        async onTransferAccountCodeChanged(value) {
            
            this.transferAccountCode = value;
            this.transferAccCode = this.getTransferAccCode(this.accountCodes, this.transferAccountCode);
            this.transferSubAccCode = this.getTransferSubAccCode(this.accountCodes, this.transferAccountCode);

            if(this.allocateAccounts.length > 0) {
                await this.onSaveAllocateAccounts(this.allocateAccounts, false);
                this.getAllocateAccounts();
            }
            
            this.setUrlParams();
            
        },

        async onDeptCodeChanged(value) {
            
            this.deptCode = value;
            this.allocateAccounts = [];

            // SHOW LOADING
            this.isLoading = true;

            await this.getTargetAccounts(this.periodYear, this.allocateGroup, this.deptCode, this.costCode);
            this.getAllocateAccounts();

            // HIDE LOADING
            this.isLoading = false;
            
            this.setUrlParams();
            
        },

        async onCostCodeChanged(value) {
            
            this.costCode = value;

            const foundCostCode = this.costCodes.find(item => item.cost_code_value == value);
            this.costGroupCode = foundCostCode ? foundCostCode.cost_group_code : null;

            this.allocateAccounts = [];

            // SHOW LOADING
            this.isLoading = true;

            await this.getTargetProductGroups(this.periodYear, this.allocateGroup, this.deptCode, this.costCode);
            await this.getTargetAccounts(this.periodYear, this.allocateGroup, this.deptCode, this.costCode);
            this.getAllocateAccounts();

            // HIDE LOADING
            this.isLoading = false;
            
            this.setUrlParams();
            
        },

        async onSearchAllocateYearVersion(data) {
            
            this.periodYear = data.period_year;
            this.periodYearLabel = this.getPeriodYearLabel(this.periodYears, this.periodYear);

            if(data.transfer_account_code) {
                this.transferAccountCode = data.transfer_account_code;
                this.transferAccCode = this.getTransferAccCode(this.accountCodes, this.transferAccountCode);
                this.transferSubAccCode = this.getTransferSubAccCode(this.accountCodes, this.transferAccountCode);
            }

            await this.getAllocateYearData(this.periodYear, data.version_no);
            await this.getDeptCodes(this.periodYear);
            await this.getCostCodes(this.periodYear);

            if(data.allocate_group) {

                this.allocateGroup = data.allocate_group;
                this.allocateGroupLevel = this.getAllocateGroupLevel(this.listAllocateGroups, this.allocateGroup);
                this.allocateGroupLabel = this.getAllocateGroupLabel(this.listAllocateGroups, this.allocateGroup);

                if(data.dept_code || data.cost_code) {

                    this.deptCode = data.dept_code;
                    this.costCode = data.cost_code;
                    this.costGroupCode = data.cost_group_code;
                    this.allocateAccounts = [];

                    this.getTargetAccounts(this.periodYear, this.allocateGroup, this.deptCode, this.costCode);
                    this.getAllocateAccounts();

                }
                    
            }

            this.setUrlParams();

        },

        async onCopyAllocateYearNewVersion(data) {
            
            this.periodYear = data.to_period_year;
            this.periodYearLabel = this.getPeriodYearLabel(this.periodYears, this.periodYear);

            this.deptCode = null;
            this.costCode = null;
            this.costGroupCode = null;
            this.transferAccountCode = "";
            this.allocateAccounts = [];

            await this.onCopyNewVersion(data.from_period_year, data.from_version_no, data.to_period_year, data.to_version_no);

            await this.getAllocateYearData(this.periodYear, null);
            await this.getDeptCodes(this.periodYear);
            await this.getCostCodes(this.periodYear);
            
            this.getTargetAccounts(this.periodYear, this.allocateGroup, this.deptCode, this.costCode);
            this.getAllocateAccounts();
            
            if(this.allocateAccounts.length > 0) {
                this.getTargetDeptCodes(this.periodYear, this.allocateGroup, this.deptCode, this.costCode);
                this.getTargetCostCodes(this.periodYear, this.allocateGroup, this.deptCode, this.costCode);
                this.getTargetProductGroups(this.periodYear, this.allocateGroup, this.deptCode, this.costCode);
            }

            this.setUrlParams();

        },

        onShowModalCreateAllocateAccounts() {
            window.scrollTo(0, 120); 
            this.$modal.show('modal-create-allocate-accounts');
        },

        onShowModalCreateAllocateTargets() {
            window.scrollTo(0, 120); 
            this.$modal.show('modal-create-allocate-targets');
        },

        onSubmitCreateAllocateAccounts(data) {
            
            const allocateAccountItems = data.targetAccounts;
            this.onSaveAllocateAccounts(allocateAccountItems, true);

        },

        onSubmitCreateAllocateTargets(data) {

            let allocateTargetItems = [];
            if(this.allocateGroupLevel == "1") {
                allocateTargetItems = data.targetDeptCodes;
            } else if(this.allocateGroupLevel == "2") {
                allocateTargetItems = data.targetCostCodes;
            } else if(this.allocateGroupLevel == "3") {
                allocateTargetItems = data.targetProductGroups;
            }
            this.onSaveAllocateTargets(this.allocateAccounts, allocateTargetItems);

        },

        getPeriodYearLabel(periodYears, periodYear) {
            const foundPeriodYear = periodYears.find(item => item.period_year_value == periodYear);
            return foundPeriodYear ? foundPeriodYear.period_year_label : "";
        },

        getAllocateGroupLevel(listAllocateGroups, allocateGroupValue) {
            const foundAllocateGroup = listAllocateGroups.find(item => item.allocate_group == allocateGroupValue);
            return foundAllocateGroup ? foundAllocateGroup.level_no : "";
        },

        getAllocateGroupLabel(listAllocateGroups, allocateGroupValue) {
            const foundAllocateGroup = listAllocateGroups.find(item => item.allocate_group == allocateGroupValue);
            return foundAllocateGroup ? foundAllocateGroup.allocate_group_label : "";
        },

        getAllocateTypeLabel(listAllocateTypes, allocateTypeValue) {
            let result = "";
            if(listAllocateTypes.length > 0 && allocateTypeValue) {
                const foundAllocateType = listAllocateTypes.find(item => item.allocate_type_value == allocateTypeValue);
                result = foundAllocateType ? foundAllocateType.allocate_type_label : "";
            }
            return result
        },

        getTransferAccCode(accountCodes, accountCode) {
            let result = "";
            if(accountCode) {
                const foundAccountCode = accountCodes.find(item => item.account_code_value == accountCode);
                result = foundAccountCode ? foundAccountCode.acc_code : "";
            }
            return result
        },

        getTransferSubAccCode(accountCodes, accountCode) {
            let result = "";
            if(accountCode) {
                const foundAccountCode = accountCodes.find(item => item.account_code_value == accountCode);
                result = foundAccountCode ? foundAccountCode.sub_acc_code : "";
            }
            return result
        },

        validateBeforeGetAllocateYear(periodYear) {

            let valid = false;

            if(periodYear) {
                valid = true;
            }

            return valid;
        },

        validateBeforeGetDeptCodes(periodYear) {

            let valid = false;

            if(periodYear) {
                valid = true;
            }

            return valid;
        },

        validateBeforeGetCostCodes(periodYear) {

            let valid = false;

            if(periodYear) {
                valid = true;
            }

            return valid;
        },

        validateBeforeGetTargetAccounts(periodYear, allocateGroup, deptCode, costCode) {

            let valid = false;
            const allocateGroupLevel = this.getAllocateGroupLevel(this.listAllocateGroups, allocateGroup);

            if(periodYear && allocateGroup) {
                if(allocateGroupLevel == "1" || allocateGroupLevel == "2") {
                    if(deptCode) {
                        valid = true;
                    }
                } else if(allocateGroupLevel == "3") {
                    if(costCode) {
                        valid = true;
                    }
                }
            }

            return valid;
        },

        validateBeforeGetAllocateAccounts(periodYear, allocateGroup, allocateType, deptCode, costCode) {

            let valid = false;
            
            if(periodYear && allocateGroup) {
                
                const allocateGroupLevel = this.getAllocateGroupLevel(this.listAllocateGroups, allocateGroup);

                if(allocateGroupLevel == "1" || allocateGroupLevel == "2") {
                    if(deptCode) {
                        valid = true;
                    }
                }
                if(allocateGroupLevel == "3") {
                    if(costCode) {
                        valid = true;
                    }
                }

            }

            return valid;
        },

        validateBeforeGetTargetDeptCodes(periodYear, allocateGroup, deptCode, costCode) {

            let valid = false;

            if(periodYear && allocateGroup) {

                const allocateGroupLevel = this.getAllocateGroupLevel(this.listAllocateGroups, allocateGroup);

                if(allocateGroupLevel == "1" || allocateGroupLevel == "2") {
                    if(deptCode) {
                        valid = true;
                    }
                }
                if(allocateGroupLevel == "3") {
                    if(costCode) {
                        valid = true;
                    }
                }

            }

            return valid;
        },

        validateBeforeGetTargetCostCodes(periodYear, allocateGroup, deptCode, costCode) {

            const allocateGroupLevel = this.getAllocateGroupLevel(this.listAllocateGroups, allocateGroup);

            let valid = false;

            if(periodYear) {
                if(allocateGroupLevel == "1" || allocateGroupLevel == "2") {
                    if(deptCode) {
                        valid = true;
                    }
                }
                if(allocateGroupLevel == "3") {
                    if(costCode) {
                        valid = true;
                    }
                }
            }

            return valid;
        },

        validateBeforeGetTargetProductGroups(periodYear, allocateGroup, deptCode, costCode) {

            const allocateGroupLevel = this.getAllocateGroupLevel(this.listAllocateGroups, allocateGroup);

            let valid = false;

            if(periodYear) {
                if(allocateGroupLevel == "3") {
                    if(costCode) {
                        valid = true;
                    }
                }
            }

            return valid;
        },

        async getAllocateYearData(periodYear, versionNo) {

            // SHOW LOADING
            this.isLoading = true;

            // REFRESH DATA
            this.allocateYear = null;
            this.allocateYearVersion = versionNo;
            this.allocateYearVersions = [];
            
            var params = { 
                period_year: periodYear,
                version: versionNo
            };

            // VALIDATE REQUIRED PARAMS BY ORGANIZATION_CODE
            const isValid = this.validateBeforeGetAllocateYear(periodYear);
            if(isValid) {

                await axios.get("/ajax/ct/allocate-ratios/year", { params })
                .then(res => {
                    const resData = res.data.data;
                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลปันส่วนของปีปัญชี ไม่ถูกต้อง | ${resData.message}`, "error");
                    } else {

                        this.allocateYear = resData.allocate_year ? JSON.parse(resData.allocate_year) : null;
                        this.periodYearStartDate = resData.start_date ? this.formatDateTh(resData.start_date) : null;
                        this.periodYearEndDate = resData.end_date ? this.formatDateTh(resData.end_date) : null;
                        this.allocateYearVersions = resData.versions ? JSON.parse(resData.versions) : [];
                        if(this.allocateYearVersions.length > 0) {
                            this.nextAllocateYearVersion = (parseInt(this.allocateYearVersions[0].version_no) + 1).toString();
                        } else {
                            this.nextAllocateYearVersion = 1;
                        }
                    }
                    return resData;
                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลปันส่วนของปีปัญชี ไม่ถูกต้อง | ${error.message}`, "error");
                    return ;
                });
                
                if(this.allocateYear) {

                    this.allocateYearVersion = this.allocateYear.version_no;
                    await this.getAllocateAccounts();
                    this.setUrlParams();
                    
                } else {
                    
                    this.allocateYearVersion = null;
                    this.onSaveAllocateYear();

                }

            }

            // HIDE LOADING
            this.isLoading = false;

        },

        async getDeptCodes(periodYear) {

            // SHOW LOADING
            this.isLoading = true;

            // REFRESH DATA
            this.deptCodes = [];
            
            var params = { 
                period_year: periodYear
            };

            if(periodYear) {

                await axios.get("/ajax/ct/allocate-ratios/dept-codes", { params })
                .then(res => {
                    const resData = res.data.data;
                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลหน่วยงานที่ปัน | ${resData.message}`, "error");
                    } else {

                        this.deptCodes = resData.dept_codes ? JSON.parse(resData.dept_codes) : [];
                    }
                    return resData;
                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลหน่วยงานที่ปัน | ${error.message}`, "error");
                    return ;
                });

            }

            // HIDE LOADING
            this.isLoading = false;

        },

        async getCostCodes(periodYear) {

            // SHOW LOADING
            this.isLoading = true;

            // REFRESH DATA
            this.costCodes = [];
            
            var params = { 
                period_year: periodYear
            };

            if(periodYear) {

                await axios.get("/ajax/ct/allocate-ratios/cost-codes", { params })
                .then(res => {
                    const resData = res.data.data;
                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลหน่วยงานที่ปัน | ${resData.message}`, "error");
                    } else {

                        this.costCodes = resData.cost_codes ? JSON.parse(resData.cost_codes) : [];
                        if(this.costCode){
                            const foundCostCode = this.costCodes.find(item => item.cost_code_value == this.costCode);
                            this.costGroupCode = foundCostCode ? foundCostCode.cost_group_code : null;
                        }
                    }
                    return resData;
                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลหน่วยงานที่ปัน | ${error.message}`, "error");
                    return ;
                });

            }

            // HIDE LOADING
            this.isLoading = false;

        },

        async getTargetAccounts(periodYear, allocateGroup, deptCode, costCode) {

            // SHOW LOADING
            this.isLoading = true;

            // REFRESH DATA
            this.targetAccounts = [];
            
            var params = { 
                period_year: periodYear,
                allocate_group: allocateGroup,
                dept_code: deptCode,
                cost_code: costCode,
            };

            const isValid = this.validateBeforeGetTargetAccounts(periodYear, allocateGroup, deptCode, costCode);
            if(isValid) {

                await axios.get("/ajax/ct/allocate-ratios/target-accounts", { params })
                .then(res => {
                    const resData = res.data.data;
                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลบัญชีรับปัน ${this.allocateGroupLabel} | ${resData.message}`, "error");
                    } else {
                        this.targetAccounts = resData.target_accounts ? JSON.parse(resData.target_accounts) : [];
                    }
                    return resData;
                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลบัญชีรับปัน ${this.allocateGroupLabel} | ${error.message}`, "error");
                    return ;
                });

            }

            // HIDE LOADING
            this.isLoading = false;

        },

        
        async getTargetDeptCodes(periodYear, allocateGroup, deptCode, costCode) {

            // SHOW LOADING
            this.isLoading = true;

            // REFRESH DATA
            this.targetDeptCodes = [];
            
            var params = { 
                period_year: periodYear,
                allocate_group: allocateGroup,
                dept_code: deptCode,
                cost_code: costCode,
            };

            const isValid = this.validateBeforeGetTargetDeptCodes(periodYear, allocateGroup, deptCode, costCode);
            if(isValid) {

                await axios.get("/ajax/ct/allocate-ratios/target-dept-codes", { params })
                .then(res => {
                    const resData = res.data.data;
                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลเป้าหมายที่รับปัน ${this.allocateGroupLabel} | ${resData.message}`, "error");
                    } else {
                        this.targetDeptCodes = resData.target_dept_codes ? JSON.parse(resData.target_dept_codes) : [];
                    }
                    return resData;
                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลเป้าหมายที่รับปัน ${this.allocateGroupLabel} | ${error.message}`, "error");
                    return ;
                });

            }

            // HIDE LOADING
            this.isLoading = false;

        },

        async getTargetCostCodes(periodYear, allocateGroup, deptCode, costCode) {

            // SHOW LOADING
            this.isLoading = true;

            // REFRESH DATA
            this.targetCostCodes = [];
            
            var params = { 
                period_year: periodYear,
                allocate_group: allocateGroup,
                dept_code: deptCode,
                cost_code: costCode,
            };

            const isValid = this.validateBeforeGetTargetCostCodes(periodYear, allocateGroup, deptCode, costCode);
            if(isValid) {

                await axios.get("/ajax/ct/allocate-ratios/target-cost-codes", { params })
                .then(res => {
                    const resData = res.data.data;
                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลเป้าหมายที่รับปัน ${this.allocateGroupLabel} | ${resData.message}`, "error");
                    } else {

                        this.targetCostCodes = resData.target_cost_codes ? JSON.parse(resData.target_cost_codes) : [];
                    }
                    return resData;
                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลเป้าหมายที่รับปัน ${this.allocateGroupLabel} | ${error.message}`, "error");
                    return ;
                });

            }

            // HIDE LOADING
            this.isLoading = false;

        },

        async getTargetProductGroups(periodYear, allocateGroup, deptCode, costCode) {

            // SHOW LOADING
            this.isLoading = true;

            // REFRESH DATA
            this.targetProductGroups = [];
            
            var params = { 
                period_year: periodYear,
                allocate_group: allocateGroup,
                dept_code: deptCode,
                cost_code: costCode
            };

            const isValid = this.validateBeforeGetTargetProductGroups(periodYear, allocateGroup, deptCode, costCode);
            if(isValid) {

                await axios.get("/ajax/ct/allocate-ratios/target-product-groups", { params })
                .then(res => {
                    const resData = res.data.data;
                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลเป้าหมายที่รับปัน ${this.allocateGroupLabel} | ${resData.message}`, "error");
                    } else {
                        this.targetProductGroups = resData.target_product_groups ? JSON.parse(resData.target_product_groups) : [];
                    }
                    return resData;
                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลเป้าหมายที่รับปัน ${this.allocateGroupLabel} | ${error.message}`, "error");
                    return ;
                });

            }

            // HIDE LOADING
            this.isLoading = false;

        },

        getApproveStatusDesc(status) {
            let statusDesc = "-";
            if(status) {
                const foundStatus = this.approveStatuses.find(item => item.lookup_code == status.toUpperCase());
                statusDesc = foundStatus ? foundStatus.description : "-"; 
            }
            return statusDesc;
        },

        async getAllocateAccounts() {

            // SHOW LOADING
            this.isLoading = true;

            var params = { 
                period_year: this.periodYear,
                version: this.allocateYearVersion,
                allocate_group: this.allocateGroup,
                allocate_type: this.allocateType,
                dept_code: this.deptCode,
                cost_code: this.costCode,
                transfer_account_code: this.transferAccountCode,
                input_allocate_year: JSON.stringify(this.allocateYear),
            };

            const isValid = this.validateBeforeGetAllocateAccounts(this.periodYear, this.allocateGroup, this.allocateType , this.deptCode, this.costCode);
            if(isValid) {
                await axios.get(`/ajax/ct/allocate-ratios/accounts`, { params })
                .then(res => {

                    const resData = res.data.data;
                    if(resData.status == "success") {
                        this.allocateAccounts = resData.allocate_accounts ? JSON.parse(resData.allocate_accounts) : [];
                    } else {
                        swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลบัญชีที่รับปัน | ${resData.message}`, "error");                    
                    }

                    return resData;

                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูลบัญชีที่รับปัน  | ${error.message}`, "error");
                });

                if(this.allocateAccounts.length > 0) {
                    this.allocateType = this.allocateAccounts[0].allocate_type;
                    this.allocateTypeLabel = this.getAllocateTypeLabel(this.allocateTypes, this.allocateType);
                    this.transferAccountCode = this.allocateAccounts[0].transfer_account_code ? this.allocateAccounts[0].transfer_account_code : "";
                    this.transferAccCode = this.getTransferAccCode(this.accountCodes, this.transferAccountCode);
                    this.transferSubAccCode = this.getTransferSubAccCode(this.accountCodes, this.transferAccountCode);
                    if(this.allocateGroup == 'DEPT') {
                        await this.getTargetDeptCodes(this.periodYear, this.allocateGroup, this.deptCode, this.costCode);
                    } else if(this.allocateGroup == 'COST') {
                        await this.getTargetCostCodes(this.periodYear, this.allocateGroup, this.deptCode, this.costCode);
                    } else if(this.allocateGroup == 'PRODUCT') {
                        await this.getTargetProductGroups(this.periodYear, this.allocateGroup, this.deptCode, this.costCode);
                    }
                    await this.getPreviousAllocateTargets(this.allocateYear, this.allocateAccounts[0]);
                    this.setUrlParams();
                }

            }

            // HIDE LOADING
            this.isLoading = false;

        },

        async getPreviousAllocateTargets(allocateYearData, allocateAccountItem) {

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
                    this.previousAllocateTargets = resData.allocate_targets ? JSON.parse(resData.allocate_targets) : [];
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

        onAllocateAccountsChanged(data) {
            this.allocateAccounts = data.allocateAccounts;
        },

        validateBeforeSaveAccounts(allocateYear, allocateGroup, allocateGroupLevel, allocateType, deptCode, costCode, transferAccountCode, allocateAccounts) {

            const result = {
                valid: true,
                message: "",
            };

            // if( !allocateYear || !allocateGroup || !allocateType || !transferAccountCode ){
            if( !allocateYear || !allocateGroup || !allocateType ){
                result.valid = false;
                result.message = `กรอกข้อมูลรายการกำหนดเกณฑ์การปันส่วนไม่ครบถ้วน กรุณาตรวจสอบ`;
            }

            if(allocateGroup == 'DEPT' || allocateGroup == 'COST') {
                if(!deptCode) { 
                    result.valid = false; 
                    result.message = `กรอกข้อมูลรายการกำหนดเกณฑ์การปันส่วนไม่ถูกต้อง กรุณาตรวจสอบ`;
                }
            }
            if(allocateGroup == 'PRODUCT') {
                if(!costCode) { 
                    result.valid = false; 
                    result.message = `กรอกข้อมูลรายการกำหนดเกณฑ์การปันส่วนไม่ถูกต้อง กรุณาตรวจสอบ`;
                }
            }

            // IF NEW LINE ISN'T COMPLETED
            const incompletedAllocateAccounts = allocateAccounts.filter(item => {
                return item.is_new_line && (
                    item.quantity === "" ||
                    item.quantity === null ||
                    item.ratio_rate === "" ||
                    item.ratio_rate === null
                );
            });

            if(incompletedAllocateAccounts.length > 0) {
                result.valid = false;
                result.message = `กรอกข้อมูลรายการกำหนดเกณฑ์การปันส่วนไม่ครบถ้วน กรุณาตรวจสอบ`
            }

            return result;

        },

        validateBeforeSaveTargets(allocateYear, allocateGroup, allocateGroupLevel, allocateType, deptCode, costCode, allocateAccounts, allocateTargets) {

            const result = {
                valid: true,
                message: "",
            };

            if( !allocateYear || !allocateGroup || !allocateType ){
                result.valid = false;
            }

            if(allocateGroup == 'DEPT' || allocateGroup == 'COST') {
                if(!deptCode) { result.valid = false; }
            }
            if(allocateGroup == 'PRODUCT') {
                if(!costCode) { result.valid = false; }
            }

            // IF NEW LINE ISN'T COMPLETED
            const incompletedTargets = allocateTargets.filter(item => {
                return item.is_new_line && (
                    item.quantity === "" ||
                    item.quantity === null ||
                    item.ratio_rate === "" ||
                    item.ratio_rate === null
                );
            });

            if(incompletedTargets.length > 0) {
                result.valid = false;
                result.message = `กรอกข้อมูลรายการกำหนดเกณฑ์การปันส่วนไม่ครบถ้วน กรุณาตรวจสอบ`
            }

            return result;

        },

        async onCopyNewVersion(fromPeriodYear, fromVersionNo, toPeriodYear, toVersionNo) {

            const reqBody = {
                from_period_year: fromPeriodYear,
                from_version_no: fromVersionNo,
                to_period_year: toPeriodYear,
                to_version_no: toVersionNo
            };

            // SHOW LOADING
            this.isLoading = true;

            // call store sample result
            await axios.post(`/ajax/ct/allocate-ratios/copy-new-version`, reqBody)
            .then(res => {

                const resData = res.data.data;
                const resMsg = resData.message;

                if(resData.status == "success") {

                    this.allocateYear = resData.allocate_year ? JSON.parse(resData.allocate_year) : null;
                    this.allocateYearVersion = resData.version_no;
                    this.allocateYearVersions = resData.versions ? JSON.parse(resData.versions) : [];
                    this.periodYearStartDate = resData.start_date ? this.formatDateTh(resData.start_date) : null;
                    this.periodYearEndDate = resData.end_date ? this.formatDateTh(resData.end_date) : null;

                }

                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `คัดลอกข้อมูลกำหนดเกณฑ์การปันส่วน | ${resMsg}`, "error");
                }
                
                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `คัดลอกข้อมูลกำหนดเกณฑ์การปันส่วน | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

        },

        async onSaveAllocateYear() {

            const reqBody = {
                period_year: this.periodYear
            };

            // SHOW LOADING
            this.isLoading = true;

            // call store sample result
            await axios.post(`/ajax/ct/allocate-ratios/year`, reqBody)
            .then(res => {

                const resData = res.data.data;
                const resMsg = resData.message;

                if(resData.status == "success") {

                    this.allocateYear = resData.allocate_year ? JSON.parse(resData.allocate_year) : null;
                    this.allocateYearVersion = resData.version_no;
                    this.allocateYearVersions = resData.versions ? JSON.parse(resData.versions) : [];
                    this.periodYearStartDate = resData.start_date ? this.formatDateTh(resData.start_date) : null;
                    this.periodYearEndDate = resData.end_date ? this.formatDateTh(resData.end_date) : null;
                    this.existPeriodYearOptions = resData.exist_period_years ? JSON.parse(resData.exist_period_years) : [];

                    // swal("Success", `บันทึกกำหนดเกณฑ์การปันส่วน`, "success");

                }

                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `บันทึกกำหนดเกณฑ์การปันส่วน | ${resMsg}`, "error");
                }
                
                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `บันทึกกำหนดเกณฑ์การปันส่วน | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

        },

        async onSaveAllocateAccounts(allocateAccountItems, showAlert) {

            const reqBody = {
                period_year: this.periodYear,
                allocate_group: this.allocateGroup,
                allocate_type: this.allocateType,
                dept_code: this.deptCode,
                cost_code: this.costCode,
                transfer_account_code: this.transferAccountCode,
                transfer_acc_code: this.transferAccCode,
                transfer_sub_acc_code: this.transferSubAccCode,
                input_allocate_year: JSON.stringify(this.allocateYear),
                input_allocate_accounts: JSON.stringify(allocateAccountItems)
            };

            // SHOW LOADING
            this.isLoading = true;

            const resValidate = this.validateBeforeSaveAccounts(this.allocateYear, this.allocateGroup, this.allocateGroupLevel, this.allocateType, this.deptCode, this.costCode, this.transferAccountCode, allocateAccountItems);
            if(resValidate.valid) {

                // call store sample result
                await axios.post(`/ajax/ct/allocate-ratios/accounts`, reqBody)
                .then(res => {

                    const resData = res.data.data;
                    const resMsg = resData.message;

                    if(resData.status == "success") {
                        this.allocateAccounts = resData.allocate_accounts ? JSON.parse(resData.allocate_accounts) : null;
                        this.existAccountCodeOptions = resData.exist_account_codes ? JSON.parse(resData.exist_account_codes) : [];
                        if(showAlert) {
                            swal("Success", `สร้างรายการข้อมูลบัญชีที่รับปันสำเร็จ`, "success");
                        }
                    }

                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ไม่สามารถสร้างรายการข้อมูลบัญชีที่รับปัน | ${resMsg}`, "error");
                    }
                    
                    return resData;

                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถสร้างรายการข้อมูลบัญชีที่รับปัน | ${error.message}`, "error");
                });
                
                // REFRESH ALLOCATE ACCOUNTS
                await this.getAllocateAccounts();

            } else {
                swal("เกิดข้อผิดพลาด", `ไม่สามารถสร้างรายการข้อมูลบัญชีที่รับปัน | ${resValidate.message}`, "error");
            }

            // HIDE LOADING
            this.isLoading = false;

        },

        async onSaveAllocateTargets(allocateAccountItems, allocateTargetItems) {

            const reqBody = {
                period_year: this.periodYear,
                allocate_group: this.allocateGroup,
                allocate_type: this.allocateType,
                dept_code: this.deptCode,
                cost_code: this.costCode,
                input_allocate_year: JSON.stringify(this.allocateYear),
                input_allocate_accounts: JSON.stringify(allocateAccountItems),
                input_allocate_targets: JSON.stringify(allocateTargetItems)
            };

            // SHOW LOADING
            this.isLoading = true;

            const resValidate = this.validateBeforeSaveTargets(this.allocateYear, this.allocateGroup, this.allocateGroupLevel, this.allocateType, this.deptCode, this.costCode, allocateAccountItems, allocateTargetItems);
            if(resValidate.valid) {

                // call store sample result
                await axios.post(`/ajax/ct/allocate-ratios/targets`, reqBody)
                .then(res => {

                    const resData = res.data.data;
                    const resMsg = resData.message;

                    if(resData.status == "success") {
                        // this.allocateAccounts = resData.allocate_accounts ? JSON.parse(resData.allocate_accounts) : null;
                        swal("Success", `สร้างรายการปันส่วนสำเร็จ`, "success");
                    }

                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `ไม่สามารถสร้างรายการปันส่วน | ${resMsg}`, "error");
                    }
                    
                    return resData;

                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถสร้างรายการปันส่วน | ${error.message}`, "error");
                });

                // REFRESH ALLOCATE ACCOUNTS
                await this.getAllocateAccounts();

            } else {
                swal("เกิดข้อผิดพลาด", `บันทึกข้อมูลบัญชีที่รับปัน | ${resValidate.message}`, "error");
            }

            // HIDE LOADING
            this.isLoading = false;

        },

        async onCreateNewAllocateYearVersion() {

            swal({
                title: "",
                text: `ต้องการสร้าง กำหนดเกณฑ์การปันส่วน เวอร์ชั่นใหม่ ?`,
                showCancelButton: true,
                confirmButtonClass: "btn-primary",
                confirmButtonText: "ยืนยัน",
                cancelButtonText: "ยกเลิก",
                closeOnConfirm: true
            }, (isConfirm) => {
                if (isConfirm) {
                    this.allocateAccounts = [];
                    this.createNewPlanVersion();
                }
            });

        },

        isAllowCreateAllocateAccounts() {

            let allowed = true;

            // if(!this.periodYear || !this.allocateGroup || !this.allocateType || !this.transferAccountCode) {
            if(!this.periodYear || !this.allocateGroup || !this.allocateType) {
                allowed = false;
            }

            if(this.allocateGroup == 'DEPT') {
                if(!this.deptCode) { allowed = false; }
            } else if(this.allocateGroup == 'COST') {
                if(!this.deptCode) { allowed = false; }
            } else if(this.allocateGroup == 'PRODUCT') {
                if(!this.costCode) { allowed = false; }
            }

            return allowed;

        },

        isAllowCreateAllocateTargets() {

            let allowed = true;

            // if(!this.periodYear || !this.allocateGroup || !this.allocateType || !this.transferAccountCode) {
            if(!this.periodYear || !this.allocateGroup || !this.allocateType) {
                allowed = false;
            }

            if(this.allocateGroup == 'DEPT') {
                if(!this.deptCode) { allowed = false; }
            } else if(this.allocateGroup == 'COST') {
                if(!this.deptCode) { allowed = false; }
            } else if(this.allocateGroup == 'PRODUCT') {
                if(!this.costCode) { allowed = false; }
            }

            if(this.allocateAccounts.length <= 0) {
                allowed = false;
            }

            return allowed;

        },

        isAllowCreateNewVersion(versions) {

            let allowed = true;

            // IF THERE IS NO ALLOCATE VERSION
            if(versions.length == 0) {
                allowed = false;
            }

            // // IF ALL VERSIONS ARE NOT COMPLETED ( 1 : NEW )
            // // => NOT ALLOW TO CREATE NEW VERSION
            // const inprogressVersions = versions.filter(item => {
            //     return item.status == 1
            // });

            // if(inprogressVersions.length > 0){
            //     allowed = false;
            // }

            return allowed;

        },

        async createNewPlanVersion() {

            const reqBody = {
                period_year: this.periodYear,
            };

            // SHOW LOADING
            this.isLoading = true;

            // call store sample result
            await axios.post(`/ajax/ct/allocate-ratios/create-new-version`, reqBody)
            .then(res => {

                const resData = res.data.data;
                const resMsg = resData.message;

                if(resData.status == "success") {
                    
                    this.allocateYear = resData.allocate_year ? JSON.parse(resData.allocate_year) : null;
                    this.allocateYearVersion = resData.version_no;
                    this.allocateYearVersions = resData.versions ? JSON.parse(resData.versions) : [];

                    swal("Success", `สร้าง กำหนดเกณฑ์การปันส่วน`, "success");

                }

                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `สร้าง กำหนดเกณฑ์การปันส่วน | ${resMsg}`, "error");
                }
                
                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `สร้าง กำหนดเกณฑ์การปันส่วน | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

        },

        onDeleteAllAllocateAccountItem(e) {

            swal({
                title: "",
                text: `ต้องการลบรายการบัญชีทั้งหมด ?`,
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "ลบ",
                cancelButtonText: "ยกเลิก",
                closeOnConfirm: true
            }, (isConfirm) => {
                if (isConfirm) {
                    this.deleteAllAllocateAccount();
                }
            });

        },

        async deleteAllAllocateAccount() {

            let allocateGroupCode = this.deptCode;
            if(this.allocateGroupLevel == '3') {
                allocateGroupCode = this.costCode;
            }

            const reqBody = {
                period_year: this.periodYear,
                input_allocate_year: JSON.stringify(this.allocateYear),
                allocate_group: this.allocateGroup,
                allocate_group_code: allocateGroupCode
            };

            // SHOW LOADING
            this.isLoading = true;

            // call store sample result
            await axios.post(`/ajax/ct/allocate-ratios/delete-all-accounts`, reqBody)
            .then(res => {

                const resData = res.data.data;
                const resMsg = resData.message;

                if(resData.status == "success") {
                    swal("Success", `ลบข้อมูลบัญชีทั้งหมด`, "success");
                }

                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `ลบข้อมูลบัญชีทั้งหมด | ${resMsg}`, "error");
                }
                
                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ลบข้อมูลบัญชีทั้งหมด | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

            // REFRESH ALLOCATE ACCOUNTS
            await this.getAllocateAccounts();

        },

        formatDateTh(date) {
            return date ? moment(date).add(543, 'years').format('DD/MM/YYYY') : ""
        },

    }

}

</script>