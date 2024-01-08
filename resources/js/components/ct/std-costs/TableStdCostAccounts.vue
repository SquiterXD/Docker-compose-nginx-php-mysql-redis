<template>

    <div>

        <div class="text-right tw-mb-4">
            <button type="button" 
                class="btn btn-success tw-w-40" 
                style="background-color: #1c84c6; border-color: #1c84c6;" 
                @click="onExportExcel">
                <i class="fa fa fa-file-excel-o tw-mr-1"></i> Export
            </button>
        </div>

        <!-- ### DEPT & COST & PRODUCT-->

        <div v-if="listAllAllocateGroupCodes.length > 0" class="row tw-my-2">
            <label class="col-md-2 col-form-label tw-font-bold text-center tw-pl-4"> หน่วยงานที่ปัน : </label>
            <div class="col-md-4"> 
                <pm-el-select name="allocate_group_code" id="input_allocate_group_code" 
                    :select-options="listAllAllocateGroupCodes"
                    option-key="allocate_group_code_value"
                    option-value="allocate_group_code_value" 
                    option-label="allocate_group_code_label" 
                    :value="filterAllAllocateGroupCode"
                    :filterable="true"
                    @onSelected="onFilterAllAllocateGroupCodeChanged"
                />
            </div>
        </div>

        <div>
            <button type="button" @click="toggleShowTable('DEPT')" class="tw-w-52 btn btn-lg" v-bind:class="[isTableDeptActive ? 'btn-primary' : 'btn-white tw-hidden']"> {{ getAllocateGroupLevel(listAllocateGroups, 'DEPT') }} : {{ getAllocateGroupLabel(listAllocateGroups, 'DEPT') }} </button>
            <button type="button" @click="toggleShowTable('COST')" class="tw-w-52 btn btn-lg" v-bind:class="[isTableCostActive ? 'btn-primary' : 'btn-white tw-hidden']"> {{ getAllocateGroupLevel(listAllocateGroups, 'COST') }} : {{ getAllocateGroupLabel(listAllocateGroups, 'COST') }} </button>
            <!-- <button type="button" @click="toggleShowTable('PRODUCT')" class="tw-w-52 btn btn-lg" v-bind:class="[isTableProductActive ? 'btn-primary' : 'btn-white tw-hidden']"> {{ getAllocateGroupLevel(listAllocateGroups, 'PRODUCT') }} : {{ getAllocateGroupLabel(listAllocateGroups, 'PRODUCT') }} </button> -->
        </div>

        <!-- <div>
            <div class="btn-group" role="group">
                <button type="button" @click="toggleShowTable('DEPT')" class="tw-w-52 btn btn-lg" v-bind:class="[isTableDeptActive ? 'btn-primary' : 'btn-white']"> {{ getAllocateGroupLevel(listAllocateGroups, 'DEPT') }} : {{ getAllocateGroupLabel(listAllocateGroups, 'DEPT') }} </button>
                <button type="button" @click="toggleShowTable('COST')" class="tw-w-52 btn btn-lg" v-bind:class="[isTableCostActive ? 'btn-primary' : 'btn-white']"> {{ getAllocateGroupLevel(listAllocateGroups, 'COST') }} : {{ getAllocateGroupLabel(listAllocateGroups, 'COST') }} </button>
                <button type="button" @click="toggleShowTable('PRODUCT')" class="tw-w-52 btn btn-lg" v-bind:class="[isTableProductActive ? 'btn-primary' : 'btn-white']"> {{ getAllocateGroupLevel(listAllocateGroups, 'PRODUCT') }} : {{ getAllocateGroupLabel(listAllocateGroups, 'PRODUCT') }} </button>
            </div>
        </div> -->

        <!-- ### DEPT -->

        <!-- <div v-if="isTableDeptActive && listDeptAllocateGroupCodes.length > 0" class="row tw-my-2">
            <label class="col-md-2 col-form-label tw-font-bold text-center tw-pl-4"> หน่วยงานที่ปัน : </label>
            <div class="col-md-4"> 
                <pm-el-select name="allocate_group_code" id="input_allocate_group_code" 
                    :select-options="listDeptAllocateGroupCodes"
                    option-key="allocate_group_code_value"
                    option-value="allocate_group_code_value" 
                    option-label="allocate_group_code_label" 
                    :value="filterDeptAllocateGroupCode"
                    :filterable="true"
                    @onSelected="onFilterDeptAllocateGroupCodeChanged"
                />
            </div>
        </div> -->

        <div v-if="isTableDeptActive" class="table-responsive" style="max-height: 600px;">

            <table class="table table-bordered table-sticky mb-0">
                <thead>
                    <tr>
                        <th width="7%" class="text-center tw-text-xs md:tw-table-cell" style="z-index: 2;"> หน่วยงานที่ปัน </th>
                        <th width="7%" class="text-center tw-text-xs md:tw-table-cell" style="z-index: 2;"> รหัสบัญชี </th>
                        <th width="12%" class="text-center tw-text-xs md:tw-table-cell" style="z-index: 2;"> ชื่อบัญชี </th>
                        <th width="10%" class="text-center tw-text-xs md:tw-table-cell" style="z-index: 2;"> เกณฑ์การปันส่วน </th>
                        <th width="10%" class="text-right tw-text-xs md:tw-table-cell" style="z-index: 2;"> ค่าใช้จ่ายจริง </th>
                        <th width="10%" class="text-right tw-text-xs md:tw-table-cell" style="z-index: 2;"> ค่าใช้จ่ายจริงเฉลี่ย </th>
                        <th width="10%" class="text-right tw-text-xs md:tw-table-cell" style="z-index: 2;"> ค่าใช้จ่ายตามงบประมาณ </th>
                        <th width="13%" class="text-right tw-text-xs md:tw-table-cell" style="z-index: 2;"> ค่าใช้จ่ายประมาณการ </th>
                        <th width="10%" class="text-center tw-text-xs md:tw-table-cell" style="z-index: 2;"> หมายเหตุ </th>
                        <th width="10%"></th>
                    </tr>
                </thead>
                <tbody v-if="deptStdcostAccountItems.length > 0">

                    <template v-for="(deptStdcostAccountItem, index) in deptStdcostAccountItems">

                        <template v-for="(deptAccountItem, indexT) in deptStdcostAccountItem.account_items">

                            <tr :key="`${index}_${indexT}`" 
                                :style="`${(indexT+1 == deptStdcostAccountItem.count_account) ? 'border-bottom : 1px solid rgb(231 231 231);' : ''}`"
                                v-if="deptAccountItem.is_show"
                            >

                                <td v-if="(indexT == 0)" :rowspan="deptStdcostAccountItem.count_account + 1" style="border-bottom : 1px solid rgb(231 231 231); border-bottom : 1px solid rgb(231 231 231); border-left: 0; border-right: 0; vertical-align: top !important;" class="text-center md:tw-table-cell">
                                    {{ deptAccountItem.allocate_group_code }}
                                </td>
                                <td class="text-center md:tw-table-cell">
                                    {{ deptAccountItem.target_account_code }}
                                </td>
                                <td class="text-left md:tw-table-cell">
                                    {{ deptAccountItem.target_sub_acc_code_desc }}
                                </td>
                                <td class="text-left md:tw-table-cell">
                                    {{ deptAccountItem.allocate_type_label }}
                                </td>
                                <td class="text-right md:tw-table-cell">
                                    {{ deptAccountItem.actual_amount ? Number(deptAccountItem.actual_amount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "0.00" }} 
                                </td>
                                <td class="text-right md:tw-table-cell">
                                    {{ deptAccountItem.avg_actual_amount ? Number(deptAccountItem.avg_actual_amount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "0.00" }} 
                                </td>
                                <td class="text-right md:tw-table-cell">
                                    {{ deptAccountItem.budget_amount ? Number(deptAccountItem.budget_amount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "0.00" }} 
                                </td>
                                <td class="text-right md:tw-table-cell">
                                    <vue-numeric 
                                        separator="," 
                                        v-bind:precision="2" 
                                        v-bind:minus="true"
                                        :name="`estimate_expense_amount_${index}`"
                                        :id="`input_estimate_expense_amount_${index}`"
                                        class="form-control input-sm text-right"
                                        :disabled="isLoading"
                                        v-model="deptAccountItem.estimate_expense_amount"
                                        @blur="onStdcostAccountEstimateExpenseAmountChanged(deptStdcostAccountItem, deptAccountItem)"
                                    ></vue-numeric>
                                    <!-- {{ deptAccountItem.estimate_expense_amount ? Number(deptAccountItem.estimate_expense_amount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "0.00" }}  -->
                                </td>
                                <td class="text-right md:tw-table-cell">
                                    <input type="text" 
                                        name="reason_name" 
                                        id="input_reason_name" 
                                        class="input-sm form-control" 
                                        :disabled="isLoading"
                                        v-model="deptAccountItem.reason_name" 
                                        @blur="onStdcostAccountReasonNameChanged(deptAccountItem)"
                                    />
                                    <!-- {{ deptAccountItem.reason_name }}  -->
                                </td>
                                
                                <td class="text-center text-nowrap">
                                <button class="btn btn-inline-block btn-xs btn-white"
                                        @click="onGetStdcostTargets(deptAccountItem)"
                                    > 
                                        <i class="fa fa-list tw-mr-1"></i> เป้าหมายที่รับปัน
                                    </button>
                                </td>

                            </tr>

                            <tr v-if="deptAccountItem.is_show_targets" :key="`targets_${index}_${indexT}`">
                                <td colspan="9">
                                    <table-std-cost-targets 
                                        :period-year-value="periodYear"
                                        :allocate-group-value="deptAccountItem.allocate_group"
                                        :stdcost-year="stdcostYearData"
                                        :stdcost-account="deptAccountItem"
                                        :stdcost-targets="stdcostTargets" 
                                        @onStdcostTargetsChanged="onStdcostTargetsChanged"
                                    >
                                    </table-std-cost-targets>
                                </td>
                            </tr>

                            <tr v-if="indexT == 0 && (!isTableDeptShowTargets || selectedDeptAllocateGroupCode != deptStdcostAccountItem.allocate_group_code) && filterAllAllocateGroupCode == 'ALL_DEPT'" :key="`targets_${index}_${indexT}`"> <td style="padding: 0px; border-color: #fff;" colspan="9"></td> </tr>

                        </template>

                    </template>

                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="11">
                            <h2 class="p-5 text-center text-muted">ไม่พบข้อมูล</h2>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-if="isTableDeptActive && deptStdcostAccountItems.length > 0">
            <table class="table table-bordered table-sticky mb-0">
                <thead>
                    <tr v-if="deptStdcostAccountItems.length > 0">
                        <td width="31%" class="text-left md:tw-table-cell" colspan="3" style="border-right: 0;">
                            <b> ประเภทการปันส่วน : {{ getAllocateGroupLevel(listAllocateGroups, 'DEPT') }} {{ getAllocateGroupLabel(listAllocateGroups, 'DEPT') }} </b>
                        </td>
                        <td width="5%" class="text-left md:tw-table-cell" style="border-left: 0;">
                            <b> รวม </b>
                        </td>
                        <td width="10%" class="text-right md:tw-table-cell" style="border-left: 0;" colspan="3">
                            <b v-if="filterDeptAllocateGroupCode"> {{ Number(deptSumFilteredActualAmount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) }}  </b>
                            <b v-else> {{ Number(deptTotalActualAmount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) }}  </b>
                        </td>
                        <td width="10%" class="text-right md:tw-table-cell" style="border-left: 0;" colspan="3">
                            <b v-if="filterDeptAllocateGroupCode"> {{ Number(deptSumFilteredAvgActualAmount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) }}  </b>
                            <b v-else> {{ Number(deptTotalAvgActualAmount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) }}  </b>
                        </td>
                        <td width="10%" class="text-right md:tw-table-cell" style="border-left: 0;" colspan="3">
                            <b v-if="filterDeptAllocateGroupCode"> {{ Number(deptSumFilteredBudgetAmount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) }}  </b>
                            <b v-else> {{ Number(deptTotalBudgetAmount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) }}  </b>
                        </td>
                        <td width="13%" class="text-right md:tw-table-cell" style="border-left: 0;" colspan="3">
                            <b v-if="filterDeptAllocateGroupCode"> {{ Number(deptSumFilteredEstimateExpenseAmount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) }}  </b>
                            <b v-else> {{ Number(deptTotalEstimateExpenseAmount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) }}  </b>
                        </td>
                        <td width="20%" class="text-left md:tw-table-cell">
                        </td>
                    </tr>
                </thead>
            </table>
        </div>

        <!-- ### COST -->

        <!-- <div v-if="isTableCostActive && listCostAllocateGroupCodes.length > 0" class="row tw-my-2">
            <label class="col-md-2 col-form-label tw-font-bold text-center tw-pl-4"> หน่วยงานที่ปัน : </label>
            <div class="col-md-4"> 
                <pm-el-select name="allocate_group_code" id="input_allocate_group_code" 
                    :select-options="listCostAllocateGroupCodes"
                    option-key="allocate_group_code_value"
                    option-value="allocate_group_code_value" 
                    option-label="allocate_group_code_label" 
                    :value="filterCostAllocateGroupCode"
                    :filterable="true"
                    @onSelected="onFilterCostAllocateGroupCodeChanged"
                />
            </div>
        </div> -->
        

        <div v-if="isTableCostActive" class="table-responsive" style="max-height: 600px;">

            <table class="table table-bordered table-sticky mb-0">
                <thead>
                    <tr>
                        <th width="7%" class="text-center tw-text-xs md:tw-table-cell" style="z-index: 2;"> หน่วยงานที่ปัน </th>
                        <th width="7%" class="text-center tw-text-xs md:tw-table-cell" style="z-index: 2;"> รหัสบัญชี </th>
                        <th width="13%" class="text-center tw-text-xs md:tw-table-cell" style="z-index: 2;"> ชื่อบัญชี </th>
                        <th width="10%" class="text-center tw-text-xs md:tw-table-cell" style="z-index: 2;"> เกณฑ์การปันส่วน </th>
                        <th width="10%" class="text-right tw-text-xs md:tw-table-cell" style="z-index: 2;"> ค่าใช้จ่ายจริง </th>
                        <th width="10%" class="text-right tw-text-xs md:tw-table-cell" style="z-index: 2;"> ค่าใช้จ่ายจริงเฉลี่ย </th>
                        <th width="10%" class="text-right tw-text-xs md:tw-table-cell" style="z-index: 2;"> ค่าใช้จ่ายตามงบประมาณ </th>
                        <th width="13%" class="text-right tw-text-xs md:tw-table-cell" style="z-index: 2;"> ค่าใช้จ่ายประมาณการ </th>
                        <th width="10%" class="text-center tw-text-xs md:tw-table-cell" style="z-index: 2;"> หมายเหตุ </th>
                        <th width="10%"></th>
                    </tr>
                </thead>
                <tbody v-if="costStdcostAccountItems.length > 0">

                    <template v-for="(costStdcostAccountItem, index) in costStdcostAccountItems">

                        <template v-for="(costAccountItem, indexT) in costStdcostAccountItem.account_items">
                        
                            <tr :key="`${index}_${indexT}`" 
                                :style="`${(indexT+1 == costStdcostAccountItem.count_account) ? 'border-bottom : 1px solid rgb(231 231 231);' : ''}`"
                                v-if="costAccountItem.is_show"
                            >

                                <td v-if="(indexT == 0)" :rowspan="costStdcostAccountItem.count_account + 1" style="border-bottom : 1px solid rgb(231 231 231); border-bottom : 1px solid rgb(231 231 231); border-left: 0; border-right: 0; vertical-align: top !important;" class="text-center md:tw-table-cell">
                                    {{ costAccountItem.allocate_group_code }}
                                </td>
                                <td class="text-center md:tw-table-cell">
                                    {{ costAccountItem.target_account_code }}
                                </td>
                                <td class="text-left md:tw-table-cell">
                                    {{ costAccountItem.target_sub_acc_code_desc }}
                                </td>
                                <td class="text-left md:tw-table-cell">
                                    {{ costAccountItem.allocate_type_label }}
                                </td>
                                <td class="text-right md:tw-table-cell">
                                    {{ costAccountItem.actual_amount ? Number(costAccountItem.actual_amount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "0.00" }} 
                                </td>
                                <td class="text-right md:tw-table-cell">
                                    {{ costAccountItem.avg_actual_amount ? Number(costAccountItem.avg_actual_amount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "0.00" }} 
                                </td>
                                <td class="text-right md:tw-table-cell">
                                    {{ costAccountItem.budget_amount ? Number(costAccountItem.budget_amount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "0.00" }} 
                                </td>
                                <td class="text-right md:tw-table-cell">
                                    <vue-numeric 
                                        separator="," 
                                        v-bind:precision="2" 
                                        v-bind:minus="true"
                                        :name="`estimate_expense_amount_${index}`"
                                        :id="`input_estimate_expense_amount_${index}`"
                                        class="form-control input-sm text-right"
                                        :disabled="isLoading"
                                        v-model="costAccountItem.estimate_expense_amount"
                                        @blur="onStdcostAccountEstimateExpenseAmountChanged(costStdcostAccountItem, costAccountItem)"
                                    ></vue-numeric>
                                    <!-- {{ costAccountItem.estimate_expense_amount ? Number(costAccountItem.estimate_expense_amount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "0.00" }}  -->
                                </td>
                                <td class="text-right md:tw-table-cell">
                                    <input type="text" 
                                        name="reason_name" 
                                        id="input_reason_name" 
                                        class="input-sm form-control" 
                                        :disabled="isLoading"
                                        v-model="costAccountItem.reason_name" 
                                        @blur="onStdcostAccountReasonNameChanged(costAccountItem)"
                                    />
                                    <!-- {{ costAccountItem.reason_name }}  -->
                                </td>
                                <td class="text-center text-nowrap">
                                <button class="btn btn-inline-block btn-xs btn-white"
                                        @click="onGetStdcostTargets(costAccountItem)"
                                    > 
                                        <i class="fa fa-list tw-mr-1"></i> เป้าหมายที่รับปัน
                                    </button>
                                </td>

                            </tr>

                            <tr v-if="costAccountItem.is_show_targets" :key="`targets_${index}_${indexT}`">
                                <td colspan="9">
                                    <table-std-cost-targets 
                                        :period-year-value="periodYear"
                                        :allocate-group-value="costAccountItem.allocate_group"
                                        :stdcost-year="stdcostYearData"
                                        :stdcost-account="costAccountItem"
                                        :stdcost-targets="stdcostTargets" 
                                        @onStdcostTargetsChanged="onStdcostTargetsChanged"
                                    >
                                    </table-std-cost-targets>
                                </td>
                            </tr>

                            <tr v-if="indexT == 0 && (!isTableCostShowTargets || selectedCostAllocateGroupCode != costStdcostAccountItem.allocate_group_code) && filterAllAllocateGroupCode == 'ALL_COST'" :key="`targets_${index}_${indexT}`"> <td style="padding: 0px; border-color: #fff;" colspan="9"></td> </tr>

                        </template>

                    </template>
                    
                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="10">
                            <h2 class="p-5 text-center text-muted">ไม่พบข้อมูล</h2>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-if="isTableCostActive && costStdcostAccountItems.length > 0">
            <table class="table table-bordered table-sticky mb-0">
                <thead>
                    <tr v-if="costStdcostAccountItems.length > 0">
                        <td width="32%" class="text-left md:tw-table-cell" colspan="4" style="border-right: 0;">
                            <b> ประเภทการปันส่วน : {{ getAllocateGroupLevel(listAllocateGroups, 'COST') }} {{ getAllocateGroupLabel(listAllocateGroups, 'COST') }} </b>
                        </td>
                        <td width="5%" class="text-left md:tw-table-cell" style="border-left: 0;">
                            <b> รวม </b>
                        </td>
                        <td width="10%" class="text-right md:tw-table-cell" style="border-left: 0;" colspan="3">
                            <b v-if="filterCostAllocateGroupCode"> {{ Number(costSumFilteredActualAmount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) }}  </b>
                            <b v-else> {{ Number(costTotalActualAmount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) }}  </b>
                        </td>
                        <td width="10%" class="text-right md:tw-table-cell" style="border-left: 0;" colspan="3">
                            <b v-if="filterCostAllocateGroupCode"> {{ Number(costSumFilteredAvgActualAmount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) }}  </b>
                            <b v-else> {{ Number(costTotalAvgActualAmount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) }}  </b>
                        </td>
                        <td width="10%" class="text-right md:tw-table-cell" style="border-left: 0;" colspan="3">
                            <b v-if="filterCostAllocateGroupCode"> {{ Number(costSumFilteredBudgetAmount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) }}  </b>
                            <b v-else> {{ Number(costTotalBudgetAmount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) }}  </b>
                        </td>
                        <td width="13%" class="text-right md:tw-table-cell" style="border-left: 0;" colspan="3">
                            <b v-if="filterCostAllocateGroupCode"> {{ Number(costSumFilteredEstimateExpenseAmount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) }}  </b>
                            <b v-else> {{ Number(costTotalEstimateExpenseAmount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) }}  </b>
                        </td>
                        <td width="20%" class="text-left md:tw-table-cell">
                        </td>
                    </tr>
                </thead>
            </table>
        </div>

        <!-- ### PRODUCT -->

        <!-- <div v-if="isTableProductActive && listProductAllocateGroupCodes.length > 0" class="row tw-my-2">
            <label class="col-md-2 col-form-label tw-font-bold text-center tw-pl-4"> ศูนย์ต้นทุนที่ปัน : </label>
            <div class="col-md-4"> 
                <pm-el-select name="allocate_group_code" id="input_allocate_group_code" 
                    :select-options="listProductAllocateGroupCodes"
                    option-key="allocate_group_code_value"
                    option-value="allocate_group_code_value" 
                    option-label="allocate_group_code_label" 
                    :value="filterProductAllocateGroupCode"
                    :filterable="true"
                    @onSelected="onFilterProductAllocateGroupCodeChanged"
                />
            </div>
        </div> -->

        <div v-if="isTableProductActive" class="table-responsive" style="max-height: 600px;">
            <table class="table table-bordered table-sticky mb-0">
                <thead>
                    <tr>
                        <th width="7%" class="text-center tw-text-xs md:tw-table-cell" style="z-index: 2;"> ศูนย์ต้นทุนที่ปัน </th>
                        <th width="7%" class="text-center tw-text-xs md:tw-table-cell" style="z-index: 2;"> รหัสบัญชี </th>
                        <th width="13%" class="text-center tw-text-xs md:tw-table-cell" style="z-index: 2;"> ชื่อบัญชี </th>
                        <th width="10%" class="text-center tw-text-xs md:tw-table-cell" style="z-index: 2;"> เกณฑ์การปันส่วน </th>
                        <th width="10%" class="text-right tw-text-xs md:tw-table-cell" style="z-index: 2;"> ค่าใช้จ่ายจริง </th>
                        <th width="10%" class="text-right tw-text-xs md:tw-table-cell" style="z-index: 2;"> ค่าใช้จ่ายจริงเฉลี่ย </th>
                        <th width="10%" class="text-right tw-text-xs md:tw-table-cell" style="z-index: 2;"> ค่าใช้จ่ายตามงบประมาณ </th>
                        <th width="13%" class="text-right tw-text-xs md:tw-table-cell" style="z-index: 2;"> ค่าใช้จ่ายประมาณการ </th>
                        <th width="10%"></th>
                    </tr>
                </thead>
                <tbody v-if="productStdcostAccountItems.length > 0">

                    <template v-for="(productStdcostAccountItem, index) in productStdcostAccountItems">

                        <template v-for="(productAccountItem, indexT) in productStdcostAccountItem.account_items">
                        
                            <tr :key="`${index}_${indexT}`" 
                                :style="`${(indexT+1 == productStdcostAccountItem.count_account) ? 'border-bottom : 1px solid rgb(231 231 231);' : ''}`"
                                v-if="productAccountItem.is_show"
                            >

                                <td v-if="(indexT == 0)" :rowspan="productStdcostAccountItem.count_account + 1" style="border-bottom : 1px solid rgb(231 231 231); border-left: 0; border-right: 0; vertical-align: top !important;" class="text-center md:tw-table-cell">
                                    {{ productAccountItem.allocate_group_code }}
                                </td>

                                <td class="text-center md:tw-table-cell">
                                    {{ productAccountItem.target_account_code }}
                                </td>
                                <td class="text-left md:tw-table-cell">
                                    {{ productAccountItem.target_sub_acc_code_desc }}
                                </td>
                                <td class="text-left md:tw-table-cell">
                                    {{ productAccountItem.allocate_type_label }}
                                </td>
                                <td class="text-right md:tw-table-cell">
                                    {{ productAccountItem.actual_amount ? Number(productAccountItem.actual_amount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "0.00" }} 
                                </td>
                                <td class="text-right md:tw-table-cell">
                                    {{ productAccountItem.avg_actual_amount ? Number(productAccountItem.avg_actual_amount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "0.00" }} 
                                </td>
                                <td class="text-right md:tw-table-cell">
                                    {{ productAccountItem.budget_amount ? Number(productAccountItem.budget_amount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "0.00" }} 
                                </td>
                                <td class="text-right md:tw-table-cell">
                                    <!-- <vue-numeric 
                                        separator="," 
                                        v-bind:precision="2" 
                                        v-bind:minus="true"
                                        :name="`estimate_expense_amount_${index}`"
                                        :id="`input_estimate_expense_amount_${index}`"
                                        class="form-control input-sm text-right"
                                        :disabled="isLoading"
                                        v-model="productAccountItem.estimate_expense_amount"
                                        @blur="onStdcostAccountEstimateExpenseAmountChanged(productStdcostAccountItem, productAccountItem)"
                                    ></vue-numeric> -->
                                    {{ productAccountItem.estimate_expense_amount ? Number(productAccountItem.estimate_expense_amount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "0.00" }} 
                                </td>
                                <td class="text-center text-nowrap">
                                <button class="btn btn-inline-block btn-xs btn-white"
                                        @click="onGetStdcostTargets(productAccountItem)"
                                    > 
                                        <i class="fa fa-list tw-mr-1"></i> เป้าหมายที่รับปัน
                                    </button>
                                </td>

                            </tr>

                            <tr v-if="productAccountItem.is_show_targets" :key="`targets_${index}_${indexT}`">
                                <td colspan="9">
                                    <table-std-cost-targets 
                                        :period-year-value="periodYear"
                                        :allocate-group-value="productAccountItem.allocate_group"
                                        :stdcost-year="stdcostYearData"
                                        :stdcost-account="productAccountItem"
                                        :stdcost-targets="stdcostTargets" 
                                        @onStdcostTargetsChanged="onStdcostTargetsChanged"
                                    >
                                    </table-std-cost-targets>
                                </td>
                            </tr>

                            <tr v-if="indexT == 0 && (!isTableProductShowTargets || selectedProductAllocateGroupCode != productStdcostAccountItem.allocate_group_code) && filterAllAllocateGroupCode == 'ALL_PRODUCT'" :key="`targets_${index}_${indexT}`"> <td style="padding: 0px; border-color: #fff;" colspan="9"></td> </tr>

                        </template>

                    </template>

                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="10">
                            <h2 class="p-5 text-center text-muted">ไม่พบข้อมูล</h2>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-if="isTableProductActive && productStdcostAccountItems.length > 0">
            <table class="table table-bordered table-sticky mb-0">
                <thead>
                    <tr v-if="productStdcostAccountItems.length > 0">
                        <td width="32%" class="text-left md:tw-table-cell" colspan="4" style="border-right: 0;">
                            <b> ประเภทการปันส่วน : {{ getAllocateGroupLevel(listAllocateGroups, 'PRODUCT') }} {{ getAllocateGroupLabel(listAllocateGroups, 'PRODUCT') }} </b>
                        </td>
                        <td width="5%" class="text-left md:tw-table-cell" style="border-left: 0;">
                            <b> รวม </b>
                        </td>
                        <td width="10%" class="text-right md:tw-table-cell" style="border-left: 0;" colspan="3">
                            <b v-if="filterProductAllocateGroupCode"> {{ Number(productSumFilteredActualAmount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) }}  </b>
                            <b v-else> {{ Number(productTotalActualAmount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) }}  </b>
                        </td>
                        <td width="10%" class="text-right md:tw-table-cell" style="border-left: 0;" colspan="3">
                            <b v-if="filterProductAllocateGroupCode"> {{ Number(productSumFilteredAvgActualAmount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) }}  </b>
                            <b v-else> {{ Number(productTotalAvgActualAmount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) }}  </b>
                        </td>
                        <td width="10%" class="text-right md:tw-table-cell" style="border-left: 0;" colspan="3">
                            <b v-if="filterProductAllocateGroupCode"> {{ Number(productSumFilteredBudgetAmount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) }}  </b>
                            <b v-else> {{ Number(productTotalBudgetAmount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) }}  </b>
                        </td>
                        <td width="13%" class="text-right md:tw-table-cell" style="border-left: 0;" colspan="3">
                            <b v-if="filterProductAllocateGroupCode"> {{ Number(productSumFilteredEstimateExpenseAmount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) }}  </b>
                            <b v-else> {{ Number(productTotalEstimateExpenseAmount).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) }}  </b>
                        </td>
                        <td width="10%" class="text-left md:tw-table-cell">
                        </td>
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

import TableStdCostTargets from "./TableStdCostTargets";

export default {
    
    props: [
        "periodYearValue", 
        "planVersionNoValue",
        "stdcostYear", 
        "stdcostAccounts", 
        "allocateTypes",
        "listAllocateGroups",
        "listAllAllocateGroupCodes",
        "listDeptAllocateGroupCodes",
        "listCostAllocateGroupCodes",
        "listProductAllocateGroupCodes",
    ],

    components: { Loading, VueNumeric, TableStdCostTargets },

    watch: {
        periodYearValue : function (value) {
            this.periodYear = value;
        },
        planVersionNoValue : function (value) {
            this.planVersionNo = value;
        },
        stdcostYear : function (value) {
            this.stdcostYearData = value;
        },
        stdcostAccounts : function (value) {

            this.stdcostAccountItems = value.map(item => {
                return {
                    ...item,
                    account_items: item.account_items.map(accItem => {
                        return {
                            ...accItem,
                            reason_name: accItem.reason_name ? accItem.reason_name : "",
                            estimate_expense_amount: accItem.estimate_expense_amount ? accItem.estimate_expense_amount : 0,
                            allocate_type_label: this.getAllocateTypeLabel(this.allocateTypes, accItem.allocate_type),
                            is_show: true,
                            is_show_targets: false,
                            marked_as_deleted: false,
                        }
                    })
                }
            });

            this.deptStdcostAccountItems = value.filter(item => {
                return item.allocate_group == "DEPT"
            }).map(item => {
                return {
                    ...item,
                    account_items: item.account_items.map(accItem => {
                        return {
                            ...accItem,
                            reason_name: accItem.reason_name ? accItem.reason_name : "",
                            estimate_expense_amount: accItem.estimate_expense_amount ? accItem.estimate_expense_amount : 0,
                            allocate_type_label: this.getAllocateTypeLabel(this.allocateTypes, accItem.allocate_type),
                            is_show: true,
                            is_show_targets: false,
                            marked_as_deleted: false,
                        }
                    })
                }
            });

            this.costStdcostAccountItems = value.filter(item => {
                return item.allocate_group == "COST"
            }).map(item => {
                return {
                    ...item,
                    account_items: item.account_items.map(accItem => {
                        return {
                            ...accItem,
                            reason_name: accItem.reason_name ? accItem.reason_name : "",
                            estimate_expense_amount: accItem.estimate_expense_amount ? accItem.estimate_expense_amount : 0,
                            allocate_type_label: this.getAllocateTypeLabel(this.allocateTypes, accItem.allocate_type),
                            is_show: true,
                            is_show_targets: false,
                            marked_as_deleted: false,
                        }
                    })
                }
            });

            this.productStdcostAccountItems = value.filter(item => {
                return item.allocate_group == "PRODUCT"
            }).map(item => {
                return {
                    ...item,
                    account_items: item.account_items.map(accItem => {
                        return {
                            ...accItem,
                            reason_name: accItem.reason_name ? accItem.reason_name : "",
                            estimate_expense_amount: accItem.estimate_expense_amount ? accItem.estimate_expense_amount : 0,
                            allocate_type_label: this.getAllocateTypeLabel(this.allocateTypes, accItem.allocate_type),
                            is_show: true,
                            is_show_targets: false,
                            marked_as_deleted: false,
                        }
                    })
                }
            });

        },
    },

    data() {

        return {

            periodYear: this.periodYearValue,
            planVersionNo: this.planVersionNoValue,
            isTableDeptActive: true,
            isTableCostActive: false,
            isTableProductActive: false,
            isTableDeptShowTargets: false,
            isTableCostShowTargets: false,
            isTableProductShowTargets: false,
            selectedDeptAllocateGroupCode: "",
            selectedCostAllocateGroupCode: "",
            selectedProductAllocateGroupCode: "",
            filterAllAllocateGroupCode: "ALL_DEPT",
            filterDeptAllocateGroupCode: "",
            filterCostAllocateGroupCode: "",
            filterProductAllocateGroupCode: "",
            stdcostYearData: this.stdcostYear,
            stdcostAccountItems: this.stdcostAccounts.map(item => {
                return {
                    ...item,
                    account_items: item.account_items.map(accItem => {
                        return {
                            ...accItem,
                            reason_name: accItem.reason_name ? accItem.reason_name : "",
                            estimate_expense_amount: accItem.estimate_expense_amount ? accItem.estimate_expense_amount : 0,
                            allocate_type_label: this.getAllocateTypeLabel(this.allocateTypes, accItem.allocate_type),
                            is_show: true,
                            is_show_targets: false,
                            marked_as_deleted: false,
                        }
                    })
                }
            }),
            deptStdcostAccountItems: this.stdcostAccounts.filter(item => item.allocate_group == "DEPT").map(item => {
                return {
                    ...item,
                    account_items: item.account_items.map(accItem => {
                        return {
                            ...accItem,
                            reason_name: accItem.reason_name ? accItem.reason_name : "",
                            estimate_expense_amount: accItem.estimate_expense_amount ? accItem.estimate_expense_amount : 0,
                            allocate_type_label: this.getAllocateTypeLabel(this.allocateTypes, accItem.allocate_type),
                            is_show: true,
                            is_show_targets: false,
                            marked_as_deleted: false,
                        }
                    })
                }
            }),
            costStdcostAccountItems: this.stdcostAccounts.filter(item => item.allocate_group == "COST").map(item => {
                return {
                    ...item,
                    account_items: item.account_items.map(accItem => {
                        return {
                            ...accItem,
                            reason_name: accItem.reason_name ? accItem.reason_name : "",
                            estimate_expense_amount: accItem.estimate_expense_amount ? accItem.estimate_expense_amount : 0,
                            allocate_type_label: this.getAllocateTypeLabel(this.allocateTypes, accItem.allocate_type),
                            is_show: true,
                            is_show_targets: false,
                            marked_as_deleted: false,
                        }
                    })
                }
            }),
            productStdcostAccountItems: this.stdcostAccounts.filter(item => item.allocate_group == "PRODUCT").map(item => {
                return {
                    ...item,
                    account_items: item.account_items.map(accItem => {
                        return {
                            ...accItem,
                            reason_name: accItem.reason_name ? accItem.reason_name : "",
                            estimate_expense_amount: accItem.estimate_expense_amount ? accItem.estimate_expense_amount : 0,
                            allocate_type_label: this.getAllocateTypeLabel(this.allocateTypes, accItem.allocate_type),
                            is_show: true,
                            is_show_targets: false,
                            marked_as_deleted: false,
                        }
                    })
                }
            }),
            stdcostTargets: [],
            totalEstimateExpenseAmount: this.stdcostAccounts.reduce((pv, cv) => pv + (cv.estimate_expense_amount ? parseFloat(cv.estimate_expense_amount) : 0), 0),
            deptTotalActualAmount: this.stdcostAccounts.filter(item => item.allocate_group == "DEPT").reduce((pv, cv) => pv + (cv.actual_amount ? parseFloat(cv.actual_amount) : 0), 0),
            deptTotalAvgActualAmount: this.stdcostAccounts.filter(item => item.allocate_group == "DEPT").reduce((pv, cv) => pv + (cv.avg_actual_amount ? parseFloat(cv.avg_actual_amount) : 0), 0),
            deptTotalBudgetAmount: this.stdcostAccounts.filter(item => item.allocate_group == "DEPT").reduce((pv, cv) => pv + (cv.budget_amount ? parseFloat(cv.budget_amount) : 0), 0),
            deptTotalEstimateExpenseAmount: this.stdcostAccounts.filter(item => item.allocate_group == "DEPT").reduce((pv, cv) => pv + (cv.estimate_expense_amount ? parseFloat(cv.estimate_expense_amount) : 0), 0),
            costTotalActualAmount: this.stdcostAccounts.filter(item => item.allocate_group == "COST").reduce((pv, cv) => pv + (cv.actual_amount ? parseFloat(cv.actual_amount) : 0), 0),
            costTotalAvgActualAmount: this.stdcostAccounts.filter(item => item.allocate_group == "COST").reduce((pv, cv) => pv + (cv.avg_actual_amount ? parseFloat(cv.avg_actual_amount) : 0), 0),
            costTotalBudgetAmount: this.stdcostAccounts.filter(item => item.allocate_group == "COST").reduce((pv, cv) => pv + (cv.budget_amount ? parseFloat(cv.budget_amount) : 0), 0),
            costTotalEstimateExpenseAmount: this.stdcostAccounts.filter(item => item.allocate_group == "COST").reduce((pv, cv) => pv + (cv.estimate_expense_amount ? parseFloat(cv.estimate_expense_amount) : 0), 0),
            productTotalActualAmount: this.stdcostAccounts.filter(item => item.allocate_group == "PRODUCT").reduce((pv, cv) => pv + (cv.actual_amount ? parseFloat(cv.actual_amount) : 0), 0),
            productTotalAvgActualAmount: this.stdcostAccounts.filter(item => item.allocate_group == "PRODUCT").reduce((pv, cv) => pv + (cv.avg_actual_amount ? parseFloat(cv.avg_actual_amount) : 0), 0),
            productTotalBudgetAmount: this.stdcostAccounts.filter(item => item.allocate_group == "PRODUCT").reduce((pv, cv) => pv + (cv.budget_amount ? parseFloat(cv.budget_amount) : 0), 0),
            productTotalEstimateExpenseAmount: this.stdcostAccounts.filter(item => item.allocate_group == "PRODUCT").reduce((pv, cv) => pv + (cv.estimate_expense_amount ? parseFloat(cv.estimate_expense_amount) : 0), 0),

            deptSumFilteredActualAmount: this.stdcostAccounts.filter(item => item.allocate_group == "DEPT").reduce((pv, cv) => pv + (cv.actual_amount ? parseFloat(cv.actual_amount) : 0), 0),
            deptSumFilteredAvgActualAmount: this.stdcostAccounts.filter(item => item.allocate_group == "DEPT").reduce((pv, cv) => pv + (cv.avg_actual_amount ? parseFloat(cv.avg_actual_amount) : 0), 0),
            deptSumFilteredBudgetAmount: this.stdcostAccounts.filter(item => item.allocate_group == "DEPT").reduce((pv, cv) => pv + (cv.budget_amount ? parseFloat(cv.budget_amount) : 0), 0),
            deptSumFilteredEstimateExpenseAmount: this.stdcostAccounts.filter(item => item.allocate_group == "DEPT").reduce((pv, cv) => pv + (cv.estimate_expense_amount ? parseFloat(cv.estimate_expense_amount) : 0), 0),
            costSumFilteredActualAmount: this.stdcostAccounts.filter(item => item.allocate_group == "COST").reduce((pv, cv) => pv + (cv.actual_amount ? parseFloat(cv.actual_amount) : 0), 0),
            costSumFilteredAvgActualAmount: this.stdcostAccounts.filter(item => item.allocate_group == "COST").reduce((pv, cv) => pv + (cv.avg_actual_amount ? parseFloat(cv.avg_actual_amount) : 0), 0),
            costSumFilteredBudgetAmount: this.stdcostAccounts.filter(item => item.allocate_group == "COST").reduce((pv, cv) => pv + (cv.budget_amount ? parseFloat(cv.budget_amount) : 0), 0),
            costSumFilteredEstimateExpenseAmount: this.stdcostAccounts.filter(item => item.allocate_group == "COST").reduce((pv, cv) => pv + (cv.estimate_expense_amount ? parseFloat(cv.estimate_expense_amount) : 0), 0),
            productSumFilteredActualAmount: this.stdcostAccounts.filter(item => item.allocate_group == "PRODUCT").reduce((pv, cv) => pv + (cv.actual_amount ? parseFloat(cv.actual_amount) : 0), 0),
            productSumFilteredAvgActualAmount: this.stdcostAccounts.filter(item => item.allocate_group == "PRODUCT").reduce((pv, cv) => pv + (cv.avg_actual_amount ? parseFloat(cv.avg_actual_amount) : 0), 0),
            productSumFilteredBudgetAmount: this.stdcostAccounts.filter(item => item.allocate_group == "PRODUCT").reduce((pv, cv) => pv + (cv.budget_amount ? parseFloat(cv.budget_amount) : 0), 0),
            productSumFilteredEstimateExpenseAmount: this.stdcostAccounts.filter(item => item.allocate_group == "PRODUCT").reduce((pv, cv) => pv + (cv.estimate_expense_amount ? parseFloat(cv.estimate_expense_amount) : 0), 0),
            
            isLoading: false

        }

    },

    mounted() {

        // this.emitStdcostAccountsChanged();

    },

    computed: {

    },
    methods: {

        toggleShowTable(showTable) {

            this.isTableDeptActive = false;
            this.isTableCostActive = false;
            this.isTableProductActive = false;

            this.deptStdcostAccountItems = this.deptStdcostAccountItems.map(item => {
                return { 
                    ...item, account_items: item.account_items.map(accItem => {
                        return { ...accItem, is_show: true, is_show_targets: false }
                    })
                }
            });
            this.costStdcostAccountItems = this.costStdcostAccountItems.map(item => {
                return { 
                    ...item, account_items: item.account_items.map(accItem => {
                        return { ...accItem, is_show: true, is_show_targets: false }
                    })
                }
            });
            this.productStdcostAccountItems = this.productStdcostAccountItems.map(item => {
                return { 
                    ...item, account_items: item.account_items.map(accItem => {
                        return { ...accItem, is_show: true, is_show_targets: false }
                    })
                }
            });

            this.$nextTick(() => {
                if(showTable == 'DEPT'){ this.isTableDeptActive = true; }
                if(showTable == 'COST'){ this.isTableCostActive = true; }
                if(showTable == 'PRODUCT'){ this.isTableProductActive = true; }
            });

        },

        async onGetStdcostTargets(stdcostAccountItem) {

            const resValidate = this.validateBeforeGetTargets(stdcostAccountItem);
            if(resValidate.valid) {

                this.stdcostTargets = [];

                const toggleShowTargets = !stdcostAccountItem.is_show_targets;
                stdcostAccountItem.is_show_targets = toggleShowTargets;

                if(stdcostAccountItem.allocate_group == "DEPT") {
                    this.deptStdcostAccountItems = this.deptStdcostAccountItems.map(item => {
                        return { 
                            ...item, account_items: item.account_items.map(accItem => { 
                                return { ...accItem, is_show_targets: accItem.target_account_code == stdcostAccountItem.target_account_code ? accItem.is_show_targets : false }
                            })
                        }
                    });
                } else if(stdcostAccountItem.allocate_group == "COST") {
                    this.costStdcostAccountItems = this.costStdcostAccountItems.map(item => {
                        return { 
                            ...item, account_items: item.account_items.map(accItem => { 
                                return { ...accItem, is_show_targets: accItem.target_account_code == stdcostAccountItem.target_account_code ? accItem.is_show_targets : false }
                            })
                        }
                    });
                } else if(stdcostAccountItem.allocate_group == "PRODUCT") {
                    this.productStdcostAccountItems = this.productStdcostAccountItems.map(item => {
                        return { 
                            ...item, account_items: item.account_items.map(accItem => { 
                                return { ...accItem, is_show_targets: accItem.target_account_code == stdcostAccountItem.target_account_code ? accItem.is_show_targets : false }
                            })
                        }
                    });
                }

                this.isTableDeptShowTargets = false;
                this.isTableCostShowTargets = false;
                this.isTableProductShowTargets = false;
                this.selectedDeptAllocateGroupCode = "";
                this.selectedCostAllocateGroupCode = "";
                this.selectedProductAllocateGroupCode = "";
                if(toggleShowTargets) {
                    if(stdcostAccountItem.allocate_group == "DEPT") { 
                        this.isTableDeptShowTargets = true; 
                        this.selectedDeptAllocateGroupCode = stdcostAccountItem.allocate_group_code; 
                    }
                    if(stdcostAccountItem.allocate_group == "COST") { 
                        this.isTableCostShowTargets = true; 
                        this.selectedCostAllocateGroupCode = stdcostAccountItem.allocate_group_code; 
                    }
                    if(stdcostAccountItem.allocate_group == "PRODUCT") { 
                        this.isTableProductShowTargets = true; 
                        this.selectedProductAllocateGroupCode = stdcostAccountItem.allocate_group_code; 
                    }
                    await this.getStdcostTargets(this.stdcostYearData, stdcostAccountItem);
                }

            } else {
                swal("เกิดข้อผิดพลาด", `${resValidate.message}`, "error");
            }

        },

        getAllocateTypeLabel(listAllocateTypes, allocateTypeValue) {
            let result = "";
            if(listAllocateTypes.length > 0 && allocateTypeValue) {
                const foundAllocateType = listAllocateTypes.find(item => item.allocate_type_value == allocateTypeValue);
                result = foundAllocateType ? foundAllocateType.allocate_type_label : "";
            }
            return result
        },

        getAllocateGroupLevel(listAllocateGroups, allocateGroupValue) {
            const foundAllocateGroup = listAllocateGroups.find(item => item.allocate_group == allocateGroupValue);
            return foundAllocateGroup ? foundAllocateGroup.level_no : "";
        },

        getAllocateGroupLabel(listAllocateGroups, allocateGroupValue) {
            const foundAllocateGroup = listAllocateGroups.find(item => item.allocate_group == allocateGroupValue);
            return foundAllocateGroup ? foundAllocateGroup.allocate_group_label : "";
        },

        async getStdcostTargets(stdcostYearData, stdcostAccountItem) {

            // SHOW LOADING
            this.isLoading = true;

            var params = { 
                period_year: this.periodYear,
                input_stdcost_year: JSON.stringify(stdcostYearData),
                input_stdcost_account: JSON.stringify(stdcostAccountItem),
            };

            await axios.get(`/ajax/ct/std-costs/targets`, { params })
            .then(res => {

                const resData = res.data.data;
                if(resData.status == "success") {
                    this.stdcostTargets = resData.stdcost_targets ? JSON.parse(resData.stdcost_targets) : [];
                } else {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูล | ${resData.message}`, "error");                    
                }

                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูล | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

        },

        isAllowAddStdcostAccount(stdcostAccounts) {

            let valid = true;

            const incompletedLines = stdcostAccounts.filter(item => {
                return item.is_new_line && (
                    !item.estimate_expense_amount
                );
            });

            if(incompletedLines.length > 0) {
                valid = false;
            }

            return valid;

        },

        async saveStdcostAccount(stdcostAccountItem) {

            const reqBody = {
                period_year: this.periodYear,
                input_stdcost_year: JSON.stringify(this.stdcostYear),
                input_stdcost_account: JSON.stringify(stdcostAccountItem)
            };

            // SHOW LOADING
            this.isLoading = true;

            await axios.post(`/ajax/ct/std-costs/account`, reqBody)
            .then(res => {

                const resData = res.data.data;
                const resMsg = resData.message;

                if(resData.status == "success") {
                    const resStdcostAccount = resData.stdcost_account ? JSON.parse(resData.stdcost_account) : null;
                    console.log(resStdcostAccount);
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

        async saveStdcostAccountExpense(stdcostAccountItem) {

            const reqBody = {
                period_year: this.periodYear,
                input_stdcost_year: JSON.stringify(this.stdcostYear),
                input_stdcost_account: JSON.stringify(stdcostAccountItem)
            };

            // SHOW LOADING
            this.isLoading = true;

            const resValidate = this.validateBeforeSaveAccount(stdcostAccountItem);
            if(resValidate.valid) {

                await axios.post(`/ajax/ct/std-costs/account-expense`, reqBody)
                .then(res => {

                    const resData = res.data.data;
                    const resMsg = resData.message;

                    if(resData.status == "success") {
                        const resStdcostAccount = resData.stdcost_account ? JSON.parse(resData.stdcost_account) : null;
                        console.log(resStdcostAccount);
                    }

                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `บันทึกข้อมูล | ${resMsg}`, "error");
                    }
                    
                    return resData;

                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `บันทึกข้อมูล | ${error.message}`, "error");
                });

            } else {
                // swal("เกิดข้อผิดพลาด", `บันทึกข้อมูล | ${resValidate.message}`, "error");
                console.log(`เกิดข้อผิดพลาด : บันทึกข้อมูล | ${resValidate.message}`);
            }

            // HIDE LOADING
            this.isLoading = false;

        },

        validateBeforeGetTargets(stdcostAccountItem) {

            const result = {
                valid: true,
                message: "",
            };

            // if(!stdcostAccountItem.estimate_expense_amount) {
            //     result.valid = false;
            //     result.message = `กรอกข้อมูลรายการบัญชีที่รับปันไม่ครบถ้วน กรุณาตรวจสอบ`
            // }

            return result;

        },

        validateBeforeSaveAccount(stdcostAccountItem) {

            const result = {
                valid: true,
                message: "",
            };

            if(stdcostAccountItem.estimate_expense_amount === undefined || stdcostAccountItem.estimate_expense_amount == null) {
                result.valid = false;
                result.message = `ข้อมูล "ค่าใช้จ่ายประมาณการ" ไม่ถูกต้อง กรุณาตรวจสอบ`
            }

            return result;

        },

        onFilterAllAllocateGroupCodeChanged(value) {

            this.filterAllAllocateGroupCode = value;
            const foundAllocateGroupCodeItem = this.listAllAllocateGroupCodes.find(item => item.allocate_group_code_value == value);
            if(foundAllocateGroupCodeItem) {
                this.isTableDeptActive = false;
                this.isTableCostActive = false;
                this.isTableProductActive = false;
                if(foundAllocateGroupCodeItem.allocate_group_code_type == "DEPT") {
                    this.isTableDeptActive = true;
                    this.onFilterDeptAllocateGroupCodeChanged(value);
                } else if(foundAllocateGroupCodeItem.allocate_group_code_type == "COST") {
                    this.isTableCostActive = true;
                    this.onFilterCostAllocateGroupCodeChanged(value);
                } else if(foundAllocateGroupCodeItem.allocate_group_code_type == "PRODUCT") {
                    this.isTableProductActive = true;
                    this.onFilterProductAllocateGroupCodeChanged(value);
                }
            }

        },

        onFilterDeptAllocateGroupCodeChanged(value) {

            this.filterDeptAllocateGroupCode = value;

            this.isTableDeptShowTargets = false;
            this.selectedDeptAllocateGroupCode = "";

            this.deptStdcostAccountItems = this.deptStdcostAccountItems.map(item => {
                return { 
                    ...item, 
                    account_items: item.account_items.map(accItem => {
                        const isShow = (this.filterDeptAllocateGroupCode == "" || this.filterDeptAllocateGroupCode == "ALL_DEPT" || this.filterDeptAllocateGroupCode == accItem.allocate_group_code);
                        return {  ...accItem, is_show: isShow, is_show_targets: false }
                    })
                }
            });

            this.calFilteredSummaryAmount("DEPT");

        },

        onFilterCostAllocateGroupCodeChanged(value) {

            this.filterCostAllocateGroupCode = value;

            this.isTableCostShowTargets = false;
            this.selectedCostAllocateGroupCode = "";

            this.costStdcostAccountItems = this.costStdcostAccountItems.map(item => {
                return { 
                    ...item, 
                    account_items: item.account_items.map(accItem => {
                        const isShow = (this.filterCostAllocateGroupCode == "" || this.filterCostAllocateGroupCode == "ALL_COST" || this.filterCostAllocateGroupCode == accItem.allocate_group_code);
                        return {  ...accItem, is_show: isShow, is_show_targets: false }
                    })
                }
            });

            this.calFilteredSummaryAmount("COST");

        },

        onFilterProductAllocateGroupCodeChanged(value) {

            this.filterProductAllocateGroupCode = value;

            this.isTableProductShowTargets = false;
            this.selectedProductAllocateGroupCode = "";

            this.productStdcostAccountItems = this.productStdcostAccountItems.map(item => {
                return { 
                    ...item, 
                    account_items: item.account_items.map(accItem => {
                        const isShow = (this.filterProductAllocateGroupCode == "" || this.filterProductAllocateGroupCode == "ALL_PRODUCT" || this.filterProductAllocateGroupCode == accItem.allocate_group_code);
                        return {  ...accItem, is_show: isShow, is_show_targets: false }
                    })
                }
            });

            this.calFilteredSummaryAmount("PRODUCT");

        },

        async calTotalSummaryAmount(allocateGroup) {

            if(allocateGroup == "DEPT") {

                this.deptTotalActualAmount = this.stdcostAccounts.filter(item => item.allocate_group == "DEPT").reduce((pv, cv) => pv + (cv.actual_amount ? parseFloat(cv.actual_amount) : 0), 0);
                this.deptTotalAvgActualAmount = this.stdcostAccounts.filter(item => item.allocate_group == "DEPT").reduce((pv, cv) => pv + (cv.avg_actual_amount ? parseFloat(cv.avg_actual_amount) : 0), 0);
                this.deptTotalBudgetAmount = this.stdcostAccounts.filter(item => item.allocate_group == "DEPT").reduce((pv, cv) => pv + (cv.budget_amount ? parseFloat(cv.budget_amount) : 0), 0);
                this.deptTotalEstimateExpenseAmount = this.stdcostAccounts.filter(item => item.allocate_group == "DEPT").reduce((pv, cv) => pv + (cv.estimate_expense_amount ? parseFloat(cv.estimate_expense_amount) : 0), 0);

            }

            if(allocateGroup == "COST") {

                this.costTotalActualAmount = this.stdcostAccounts.filter(item => item.allocate_group == "COST").reduce((pv, cv) => pv + (cv.actual_amount ? parseFloat(cv.actual_amount) : 0), 0);
                this.costTotalAvgActualAmount = this.stdcostAccounts.filter(item => item.allocate_group == "COST").reduce((pv, cv) => pv + (cv.avg_actual_amount ? parseFloat(cv.avg_actual_amount) : 0), 0);
                this.costTotalBudgetAmount = this.stdcostAccounts.filter(item => item.allocate_group == "COST").reduce((pv, cv) => pv + (cv.budget_amount ? parseFloat(cv.budget_amount) : 0), 0);
                this.costTotalEstimateExpenseAmount = this.stdcostAccounts.filter(item => item.allocate_group == "COST").reduce((pv, cv) => pv + (cv.estimate_expense_amount ? parseFloat(cv.estimate_expense_amount) : 0), 0);

            }

            if(allocateGroup == "PRODUCT") {
            
                this.productTotalActualAmount = this.stdcostAccounts.filter(item => item.allocate_group == "PRODUCT").reduce((pv, cv) => pv + (cv.actual_amount ? parseFloat(cv.actual_amount) : 0), 0);
                this.productTotalAvgActualAmount = this.stdcostAccounts.filter(item => item.allocate_group == "PRODUCT").reduce((pv, cv) => pv + (cv.avg_actual_amount ? parseFloat(cv.avg_actual_amount) : 0), 0);
                this.productTotalBudgetAmount = this.stdcostAccounts.filter(item => item.allocate_group == "PRODUCT").reduce((pv, cv) => pv + (cv.budget_amount ? parseFloat(cv.budget_amount) : 0), 0);
                this.productTotalEstimateExpenseAmount = this.stdcostAccounts.filter(item => item.allocate_group == "PRODUCT").reduce((pv, cv) => pv + (cv.estimate_expense_amount ? parseFloat(cv.estimate_expense_amount) : 0), 0);

            }

        },

        async calFilteredSummaryAmount(allocateGroup) {

            if(allocateGroup == "DEPT") {
                if(!this.filterDeptAllocateGroupCode || this.filterDeptAllocateGroupCode == "ALL_DEPT") {
                    this.deptSumFilteredActualAmount = this.deptTotalActualAmount;
                    this.deptSumFilteredAvgActualAmount = this.deptTotalAvgActualAmount;
                    this.deptSumFilteredBudgetAmount = this.deptTotalBudgetAmount;
                    this.deptSumFilteredEstimateExpenseAmount = this.deptTotalEstimateExpenseAmount;
                } else {
                    this.deptSumFilteredActualAmount = this.stdcostAccounts.filter(item => (item.allocate_group == "DEPT" && item.allocate_group_code == this.filterDeptAllocateGroupCode)).reduce((pv, cv) => pv + (cv.actual_amount ? parseFloat(cv.actual_amount) : 0), 0);
                    this.deptSumFilteredAvgActualAmount = this.stdcostAccounts.filter(item => (item.allocate_group == "DEPT" && item.allocate_group_code == this.filterDeptAllocateGroupCode)).reduce((pv, cv) => pv + (cv.avg_actual_amount ? parseFloat(cv.avg_actual_amount) : 0), 0);
                    this.deptSumFilteredBudgetAmount = this.stdcostAccounts.filter(item => (item.allocate_group == "DEPT" && item.allocate_group_code == this.filterDeptAllocateGroupCode)).reduce((pv, cv) => pv + (cv.budget_amount ? parseFloat(cv.budget_amount) : 0), 0);
                    this.deptSumFilteredEstimateExpenseAmount = this.stdcostAccounts.filter(item => (item.allocate_group == "DEPT" && item.allocate_group_code == this.filterDeptAllocateGroupCode)).reduce((pv, cv) => pv + (cv.estimate_expense_amount ? parseFloat(cv.estimate_expense_amount) : 0), 0);
                }
            }

            if(allocateGroup == "COST") {
                if(!this.filterCostAllocateGroupCode || this.filterCostAllocateGroupCode == "ALL_COST") {
                    this.costSumFilteredActualAmount = this.costTotalActualAmount;
                    this.costSumFilteredAvgActualAmount = this.costTotalAvgActualAmount;
                    this.costSumFilteredBudgetAmount = this.costTotalBudgetAmount;
                    this.costSumFilteredEstimateExpenseAmount = this.costTotalEstimateExpenseAmount;
                } else {
                    this.costSumFilteredActualAmount = this.stdcostAccounts.filter(item => (item.allocate_group == "COST" && item.allocate_group_code == this.filterCostAllocateGroupCode)).reduce((pv, cv) => pv + (cv.actual_amount ? parseFloat(cv.actual_amount) : 0), 0);
                    this.costSumFilteredAvgActualAmount = this.stdcostAccounts.filter(item => (item.allocate_group == "COST" && item.allocate_group_code == this.filterCostAllocateGroupCode)).reduce((pv, cv) => pv + (cv.avg_actual_amount ? parseFloat(cv.avg_actual_amount) : 0), 0);
                    this.costSumFilteredBudgetAmount = this.stdcostAccounts.filter(item => (item.allocate_group == "COST" && item.allocate_group_code == this.filterCostAllocateGroupCode)).reduce((pv, cv) => pv + (cv.budget_amount ? parseFloat(cv.budget_amount) : 0), 0);
                    this.costSumFilteredEstimateExpenseAmount = this.stdcostAccounts.filter(item => (item.allocate_group == "COST" && item.allocate_group_code == this.filterCostAllocateGroupCode)).reduce((pv, cv) => pv + (cv.estimate_expense_amount ? parseFloat(cv.estimate_expense_amount) : 0), 0);
                }
            }

            if(allocateGroup == "PRODUCT") {
                if(!this.filterProductAllocateGroupCode || this.filterProductAllocateGroupCode == "ALL_PRODUCT") {
                    this.productSumFilteredActualAmount = this.productTotalActualAmount;
                    this.productSumFilteredAvgActualAmount = this.productTotalAvgActualAmount;
                    this.productSumFilteredBudgetAmount = this.productTotalBudgetAmount;
                    this.productSumFilteredEstimateExpenseAmount = this.productTotalEstimateExpenseAmount;
                } else {
                    this.productSumFilteredActualAmount = this.stdcostAccounts.filter(item => (item.allocate_group == "PRODUCT" && item.allocate_group_code == this.filterProductAllocateGroupCode)).reduce((pv, cv) => pv + (cv.actual_amount ? parseFloat(cv.actual_amount) : 0), 0);
                    this.productSumFilteredAvgActualAmount = this.stdcostAccounts.filter(item => (item.allocate_group == "PRODUCT" && item.allocate_group_code == this.filterProductAllocateGroupCode)).reduce((pv, cv) => pv + (cv.avg_actual_amount ? parseFloat(cv.avg_actual_amount) : 0), 0);
                    this.productSumFilteredBudgetAmount = this.stdcostAccounts.filter(item => (item.allocate_group == "PRODUCT" && item.allocate_group_code == this.filterProductAllocateGroupCode)).reduce((pv, cv) => pv + (cv.budget_amount ? parseFloat(cv.budget_amount) : 0), 0);
                    this.productSumFilteredEstimateExpenseAmount = this.stdcostAccounts.filter(item => (item.allocate_group == "PRODUCT" && item.allocate_group_code == this.filterProductAllocateGroupCode)).reduce((pv, cv) => pv + (cv.estimate_expense_amount ? parseFloat(cv.estimate_expense_amount) : 0), 0);
                }
            }

        },

        async onStdcostAccountEstimateExpenseAmountChanged(stdCostAccountItem, accountItem){

            const sumStdCostAccountEstimateExpenseAmount = stdCostAccountItem.account_items.reduce((pv, cv) => pv + (cv.estimate_expense_amount ? parseFloat(cv.estimate_expense_amount) : 0), 0);
            stdCostAccountItem.estimate_expense_amount = sumStdCostAccountEstimateExpenseAmount;

            const mainStdcostAccountItem = this.stdcostAccounts.find(item => (item.allocate_group == stdCostAccountItem.allocate_group && item.allocate_group_code == stdCostAccountItem.allocate_group_code));
            if(mainStdcostAccountItem){
                mainStdcostAccountItem.estimate_expense_amount = sumStdCostAccountEstimateExpenseAmount;
            }
            
            await this.saveStdcostAccountExpense(accountItem);
            if(accountItem.is_show_targets) {
                this.onGetStdcostTargets(accountItem);
            }

            this.calTotalSummaryAmount(accountItem.allocate_group);
            this.calFilteredSummaryAmount(accountItem.allocate_group);

            // this.emitStdcostAccountsChanged();

        },

        async onStdcostAccountReasonNameChanged(accountItem) {
            
            await this.saveStdcostAccount(accountItem);
            if(accountItem.is_show_targets) {
                this.onGetStdcostTargets(accountItem);
            }
            // this.emitStdcostAccountsChanged();

        },

        onStdcostTargetsChanged(data) {
            this.stdcostTargets = data.stdcostTargets;
        },

        emitStdcostAccountsChanged() {
            this.$emit("onStdcostAccountsChanged", {
                stdcostAccounts: this.stdcostAccountItems
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
        },

        async onExportExcel() {
            
            // let reportItems = [];
            const foundAllocateGroupCodeItem = this.listAllAllocateGroupCodes.find(item => item.allocate_group_code_value == this.filterAllAllocateGroupCode);
            const allocateGroup = foundAllocateGroupCodeItem ? foundAllocateGroupCodeItem.allocate_group_code_type : "DEPT";
            const allocateGroupCode = foundAllocateGroupCodeItem ? foundAllocateGroupCodeItem.allocate_group_code_value : "ALL_DEPT";
            const reportItems = allocateGroup == "DEPT" ? this.deptStdcostAccountItems : this.costStdcostAccountItems;
            const reportSummaryItem = {
                actual_amount: allocateGroup == "DEPT" ? this.deptSumFilteredActualAmount : this.costSumFilteredActualAmount,
                avg_actual_amount: allocateGroup == "DEPT" ? this.deptSumFilteredAvgActualAmount : this.costSumFilteredAvgActualAmount,
                budget_amount: allocateGroup == "DEPT" ? this.deptSumFilteredBudgetAmount : this.costSumFilteredBudgetAmount,
                estimate_expense_amount: allocateGroup == "DEPT" ? this.deptSumFilteredEstimateExpenseAmount : this.costSumFilteredEstimateExpenseAmount,
            };

            const reqBody = {
                period_year: this.periodYear,
                version_no: this.stdcostYearData.version_no,
                plan_version_no: this.planVersionNo,
                period_name_from: this.stdcostYearData.period_name_from,
                period_name_to: this.stdcostYearData.period_name_to,
                allocate_group: allocateGroup,
                allocate_group_code: allocateGroupCode,
                list_all_allocate_group_codes: JSON.stringify(this.listAllAllocateGroupCodes),
                stdcost_year: JSON.stringify(this.stdcostYearData),
                report_items: JSON.stringify(reportItems),
                report_summary_item: JSON.stringify(reportSummaryItem),
            };

            // show loading
            this.isLoading = true;

            // CALL SAVE BEFORE SUBMIT APPROVAL
            await axios.post(`/ajax/ct/std-costs/export`, reqBody)
            .then(res => {
                const resData = res.data.data;
                const resMsg = resData.message;
                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถพิมพ์รายงาน | ${resMsg}`, "error");
                } else {
                    window.open(`/ct/files/download/ct/std-costs/export/excel/${resData.file_name}`, '_blank');
                }
                return resData;
            }).catch((error) => {
                console.log(error);
            });

            // hide loading
            this.isLoading = false;

        },

    }

}

</script>