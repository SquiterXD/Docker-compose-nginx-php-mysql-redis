<template>
    <div>
        <div class="row">
            <div class="col-md-4">
                <label> Code <span class="text-danger">*</span></label>
                <el-input type="text" name="account_code" v-model="account_code" placeholder="Please enter a value" autocomplete="off" :disabled="this.disableEdit"></el-input>
            </div>
            <div class="col-md-4">
                <label> Description </label>
                <el-input type="text" name="description" v-model="description" placeholder="Please enter a value" autocomplete="off"></el-input>
            </div>
            <div class="col-md-4">
                <label> COMPANY </label>
                <input type="hidden" name="segment1"  :value="segment1" autocomplete="off">
                <el-select  v-model="segment1"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" 
                                >              
                    <el-option  v-for="company in companies"
                                :key="company.company_code"
                                :label="company.description"
                                :value="company.company_code">

                    </el-option>
                </el-select>
                <!-- <input-segment
                    set-name="TTM_GL_ACCT_CODE-COMPANY_CODE"
                    :set-data="segment1"
                    placeholder="Company"
                    name="segment1"
                >
                </input-segment> -->
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-4">
                <label> EVM </label>
                <!-- <input-segment 
                    set-name="TTM_GL_ACCT_CODE-EVM" 
                    :set-data="segment2" 
                    placeholder="EVM" 
                    name="segment2"
                >
                </input-segment> -->
                <input type="hidden" name="segment2"  :value="segment2" autocomplete="off">
                <el-select  v-model="segment2"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" 
                                >              
                    <el-option  v-for="evm in evms"
                                :key="evm.evm_code"
                                :label="evm.description"
                                :value="evm.evm_code">

                    </el-option>
                </el-select>
            </div>
            <div class="col-md-4">
                <label> DEPARTMENT </label>
                <!-- <input-segment
                    @coa="updateCoaFrom"
                    set-name="TTM_GL_ACCT_CODE-DEPT_CODE"
                    :set-data="segment3"
                    placeholder="Department"
                    name="segment3"
                >
                </input-segment> -->
               <input type="hidden" name="segment3"  :value="segment3" autocomplete="off">
                <el-select  v-model="segment3"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" 
                                @coa="updateCoaFrom"
                                >              
                    <el-option  v-for="department in departments"
                                :key="department.department_code"
                                :label="department.description"
                                :value="department.department_code">

                    </el-option>
                </el-select>
            </div>
            <div class="col-md-4">
                <label> COST CENTER </label>
                <template v-if="!segment3">
                            <el-select
                        v-model="value"
                        filterable
                        remote
                        clearable 
                        size="small"
                        class="w-100"
                        style="width: 100%;"
                        disabled
                    ></el-select>
                </template>
                <input-segment v-else
                    set-name="TTM_GL_ACCT_CODE-COST_CENTER"
                    :set-data="segment4"
                    :set-parent="segment3"
                    placeholder="Cost Center"
                    name="segment4"
                >
                </input-segment>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-4">
                <label> BUDGET YEAR </label>
                <!-- <input-segment 
                    set-name="TTM_GL_ACCT_CODE-BUDGET_YEAR"
                    :set-data="segment5"
                    placeholder="BUDGET YEAR"
                    name="segment5"
                >
                </input-segment> -->
                <input type="hidden" name="segment5"  :value="segment5" autocomplete="off">
                <el-select  v-model="segment5"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" 
                                >              
                    <el-option  v-for="budgetYear in budgetYears"
                                :key="budgetYear.budget_year"
                                :label="budgetYear.description"
                                :value="budgetYear.budget_year">

                    </el-option>
                </el-select>
            </div>
            <div class="col-md-4">
                <label> BUDGET TYPE </label>
                    <!-- <input-segment 
                    @coa="updateCoaFrom"
                    set-name="TTM_GL_ACCT_CODE-BUDGET_TYPE"
                    :set-data="segment6"
                    placeholder="BUDGET TYPE"
                    name="segment6"
                >
                </input-segment> -->
                <input type="hidden" name="segment6"  :value="segment6" autocomplete="off">
                <el-select  v-model="segment6"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" 
                                @coa="updateCoaFrom">              
                    <el-option  v-for="budgetType in budgetTypes"
                                :key="budgetType.budget_type"
                                :label="budgetType.description"
                                :value="budgetType.budget_type">

                    </el-option>
                </el-select>
            </div>
            <div class="col-md-4">
                <label> BUDGET DETAIL </label>
                <template v-if="!segment6">
                    <el-select
                        v-model="value"
                        filterable
                        remote
                        clearable 
                        size="small"
                        class="w-100"
                        style="width: 100%;"
                        disabled
                    ></el-select>
                </template>
                <input-segment v-else
                    set-name="TTM_GL_ACCT_CODE-BUDGET_DETAIL"
                    :set-data="segment7"
                    :set-parent="segment6"
                    placeholder="BUDGET DETAIL"
                    name="segment7"
                >
                </input-segment>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-4">
                <label> BUDGET REASON </label>
                <!-- <input-segment 
                    set-name="TTM_GL_ACCT_CODE-BUDGET_REASON"
                    :set-data="segment8"
                    placeholder="BUDGET REASON"
                    name="segment8"
                >
                </input-segment> -->
                <input type="hidden" name="segment8"  :value="segment8" autocomplete="off">
                <el-select  v-model="segment8"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" 
                                >              
                    <el-option  v-for="budgetReason in budgetReasons"
                                :key="budgetReason.budget_reason"
                                :label="budgetReason.description"
                                :value="budgetReason.budget_reason">

                    </el-option>
                </el-select>
            </div>
            <div class="col-md-4">
                <label> MAIN ACCOUNT </label>
                <!-- <input-segment 
                    @coa="updateCoaFrom"
                    set-name="TTM_GL_ACCT_CODE-MAIN_ACCOUNT"
                    :set-data="segment9"
                    placeholder="MAIN ACCOUNT"
                    name="segment9"
                >
                </input-segment> -->

                <input type="hidden" name="segment9"  :value="segment9" autocomplete="off">
                <el-select  v-model="segment9"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" 
                                @coa="updateCoaFrom"
                                >              
                    <el-option  v-for="mainAccount in mainAccounts"
                                :key="mainAccount.main_account"
                                :label="mainAccount.description"
                                :value="mainAccount.main_account">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-4">
                <label> SUB ACCOUNT </label>
                <template v-if="!segment9">
                    <el-select
                        v-model="value"
                        filterable
                        remote
                        clearable 
                        size="small"
                        class="w-100"
                        style="width: 100%;"
                        disabled
                    ></el-select>
                </template>
                <input-segment v-else
                    set-name="TTM_GL_ACCT_CODE-SUB_ACCOUNT"
                    :set-data="segment10"
                    :set-parent="segment9"
                    placeholder="SUB ACCOUNT"
                    name="segment10"
                >
                </input-segment>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-4">
                <label> RESERVED1 </label>
                <!-- <input-segment 
                    set-name="TTM_GL_ACCT_CODE-RESERVED1"
                    :set-data="segment11"
                    placeholder="RESERVED 1"
                    name="segment11"
                >
                </input-segment> -->
                <input type="hidden" name="segment11"  :value="segment11" autocomplete="off">
                <el-select  v-model="segment11"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" 
                                >              
                    <el-option  v-for="reserved in reserveds1"
                                :key="reserved.reserved1"
                                :label="reserved.description"
                                :value="reserved.reserved1">

                    </el-option>
                </el-select>
            </div>
            <div class="col-md-4">
                <label> RESERVED2 </label>
                <!-- <input-segment 
                    set-name="TTM_GL_ACCT_CODE-RESERVED2"
                    :set-data="segment12"
                    placeholder="RESERVED 2"
                    name="segment12"
                >
                </input-segment> -->
                <input type="hidden" name="segment12"  :value="segment12" autocomplete="off">
                <el-select  v-model="segment12"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" 
                                >              
                    <el-option  v-for="reserved in reserveds2"
                                :key="reserved.reserved2"
                                :label="reserved.description"
                                :value="reserved.reserved2">

                    </el-option>
                </el-select>
            </div>
            <div class="col-md-4">
                <label> Active </label>
                <div>
                    <input type="checkbox" class="i-checks" name="active_flag" checked>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-4">
                <label> Start Date </label>
                <el-date-picker 
                    v-model="start_date"
                    style="width: 100%;"
                    type="datetime"
                    placeholder="วันที่เริ่มต้น"
                    name="start_date"
                    format="dd-MM-yyyy"
                    >
                </el-date-picker>  
            </div>
            <div class="col-md-4">
                <label> End Date </label>
                <el-date-picker 
                    v-model="end_date"
                    style="width: 100%;"
                    type="datetime"
                    placeholder="วันที่สิ้นสุด"
                    name="end_date"
                    format="dd-MM-yyyy"
                    @change="checkDate()">
                </el-date-picker>  
            </div>
        </div>
    </div>
</template>
<script>
import moment from 'moment';
export default {
    props:['companies', 'evms', 'departments', 'budgetYears', 'budgetTypes', 'budgetReasons', 'mainAccounts', 'reserveds1', 'reserveds2', 'defaultValue'],
    data() {
        return { 
            // account_code: '',
            // description: '',
            // segment1:'',
            // segment2:'',
            // segment3:'',
            // segment4:'',
            // segment5:'',
            // segment6:'',
            // segment7:'',
            // segment8:'',
            // segment9:'',
            // segment10:'',
            // segment11:'',
            // segment12:'',
            // value: '',
            // start_date: '',
            // end_date: '',

            account_code: this.defaultValue ? this.defaultValue.account_code  : '',
            description:  this.defaultValue ? this.defaultValue.description   : '',
            segment1:     this.defaultValue ? this.defaultValue.segment1     : '',
            segment2:     this.defaultValue ? this.defaultValue.segment2     : '',
            segment3:     this.defaultValue ? this.defaultValue.segment3     : '',
            segment4:     this.defaultValue ? this.defaultValue.segment4     : '',
            segment5:     this.defaultValue ? this.defaultValue.segment5     : '',
            segment6:     this.defaultValue ? this.defaultValue.segment6     : '',
            segment7:     this.defaultValue ? this.defaultValue.segment7     : '',
            segment8:     this.defaultValue ? this.defaultValue.segment8     : '',
            segment9:     this.defaultValue ? this.defaultValue.segment9     : '',
            segment10:    this.defaultValue ? this.defaultValue.segment10    : '',
            segment11:    this.defaultValue ? this.defaultValue.segment11    : '',
            segment12:    this.defaultValue ? this.defaultValue.segment12    : '',
            active_flag:  this.defaultValue ? this.defaultValue.active_flag == 'Y' ? true : false : true,
            start_date:   this.defaultValue ? this.defaultValue.start_date    : '',
            end_date:     this.defaultValue ? this.defaultValue.end_date      : '',
            disableEdit:  this.defaultValue ? this.defaultValue.account_code ? true : false : false,

            value: '',
        }
    },
    mounted() {
        // if (this.segment3 || this.segment6 || this.segment9) {
        //     this.updateCoaFrom();
        // }
        
    },
     methods: {
        updateCoaFrom(res){
            // if (res.name == 'TTM_GL_ACCT_CODE-COMPANY_CODE') { this.segment1 = res.segment1;}
            // if (res.name == 'TTM_GL_ACCT_CODE-EVM') { this.segment2 = res.segment2;}
            if (res.name == 'TTM_GL_ACCT_CODE-DEPT_CODE') { this.segment3 = res.segment3; this.segment4 = null}
            // if (res.name == 'TTM_GL_ACCT_CODE-COST_CENTER') { this.segment4 = res.segment4;}
            // if (res.name == 'TTM_GL_ACCT_CODE-BUDGET_YEAR') { this.segment5 = res.segment5;}
            if (res.name == 'TTM_GL_ACCT_CODE-BUDGET_TYPE') { this.segment6 = res.segment6; this.segment7 = null}
            // if (res.name == 'TTM_GL_ACCT_CODE-BUDGET_DETAIL') { this.segment7 = res.segment7;}
            // if (res.name == 'TTM_GL_ACCT_CODE-BUDGET_REASON') { this.segment8 = res.segment8;}
            if (res.name == 'TTM_GL_ACCT_CODE-MAIN_ACCOUNT') { this.segment9 = res.segment9; this.segment10 = null}
            // if (res.name == 'TTM_GL_ACCT_CODE-SUB_ACCOUNT') { this.segment10 = res.segment10;}
            // if (res.name == 'TTM_GL_ACCT_CODE-RESERVED1') { this.segment11 = res.segment11;}
            // if (res.name == 'TTM_GL_ACCT_CODE-RESERVED2') { this.segment12 = res.segment12;}
        },
        checkDate() {
            if (this.start_date) {
                if (moment(String(this.end_date)).format('yyyy-MM-DD') < moment(String(this.start_date)).format('yyyy-MM-DD')) {
                    this.$notify.error({
                        title: 'มีข้อผิดพลาด',
                        message: 'วันที่สิ้นสุดต้องไม่น้อยกว่าวันที่เริ่มต้น',
                    });
                    this.end_date = '';
                }
            } 
        }
    }
}
</script>
