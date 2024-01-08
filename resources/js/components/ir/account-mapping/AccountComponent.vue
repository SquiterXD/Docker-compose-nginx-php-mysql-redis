<template>
    <div>
        <div class="row">
            <div class="col-md-4">
                <label> Code <span class="text-danger">*</span></label>
                <el-input type="text" name="account_code" v-model="account_code" placeholder="Please enter a value" autocomplete="off" size="small" maxlength="5"></el-input>
            </div>
            <div class="col-md-4">
                <label> Description <span class="text-danger">*</span></label>
                <el-input type="text" name="description" v-model="description" placeholder="Please enter a value" autocomplete="off" size="small"></el-input>
            </div>
            <div class="col-md-4">
                <label> COMPANY <span class="text-danger">*</span></label>
                <input-segment
                    set-name="TTM_GL_ACCT_CODE-COMPANY_CODE"
                    :set-data="segment1"
                    placeholder="Company"
                    name="segment1"
                >
                </input-segment>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-4">
                <label> EVM <span class="text-danger">*</span></label>
                <input-segment 
                    set-name="TTM_GL_ACCT_CODE-EVM" 
                    :set-data="segment2" 
                    placeholder="EVM" 
                    name="segment2"
                >
                </input-segment>
            </div>
            <div class="col-md-4">
                <label> DEPARTMENT <span class="text-danger">*</span></label>
                <input-segment
                    @coa="updateCoaFrom"
                    set-name="TTM_GL_ACCT_CODE-DEPT_CODE"
                    :set-data="segment3"
                    placeholder="Department"
                    name="segment3"
                >
                </input-segment>
            </div>
            <div class="col-md-4">
                <label> COST CENTER <span class="text-danger">*</span></label>
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
                <label> BUDGET YEAR <span class="text-danger">*</span></label>
                <input-segment 
                    set-name="TTM_GL_ACCT_CODE-BUDGET_YEAR"
                    :set-data="segment5"
                    placeholder="BUDGET YEAR"
                    name="segment5"
                >
                </input-segment>
            </div>
            <div class="col-md-4">
                <label> BUDGET TYPE <span class="text-danger">*</span></label>
                    <input-segment 
                    @coa="updateCoaFrom"
                    set-name="TTM_GL_ACCT_CODE-BUDGET_TYPE"
                    :set-data="segment6"
                    placeholder="BUDGET TYPE"
                    name="segment6"
                >
                </input-segment>
            </div>
            <div class="col-md-4">
                <label> BUDGET DETAIL <span class="text-danger">*</span></label>
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
                <label> BUDGET REASON <span class="text-danger">*</span></label>
                <input-segment 
                    set-name="TTM_GL_ACCT_CODE-BUDGET_REASON"
                    :set-data="segment8"
                    placeholder="BUDGET REASON"
                    name="segment8"
                >
                </input-segment>
            </div>
            <div class="col-md-4">
                <label> MAIN ACCOUNT <span class="text-danger">*</span></label>
                <input-segment 
                    @coa="updateCoaFrom"
                    set-name="TTM_GL_ACCT_CODE-MAIN_ACCOUNT"
                    :set-data="segment9"
                    placeholder="MAIN ACCOUNT"
                    name="segment9"
                >
                </input-segment>
            </div>
            <div class="col-md-4">
                <label> SUB ACCOUNT <span class="text-danger">*</span></label>
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
                <label> RESERVED1 <span class="text-danger">*</span></label>
                <input-segment 
                    set-name="TTM_GL_ACCT_CODE-RESERVED1"
                    :set-data="segment11"
                    placeholder="RESERVED 1"
                    name="segment11"
                >
                </input-segment>
            </div>
            <div class="col-md-4">
                <label> RESERVED2 <span class="text-danger">*</span></label>
                <input-segment 
                    set-name="TTM_GL_ACCT_CODE-RESERVED2"
                    :set-data="segment12"
                    placeholder="RESERVED 2"
                    name="segment12"
                >
                </input-segment>
            </div>
            <div class="col-md-4">
                <label> Active </label>
                <div>
                    <input type="checkbox" class="i-checks" name="active_flag" v-model="active_flag">
                </div>
            </div>
        </div>
        
    </div>
</template>
<script>
export default {
    data() {
        return { 
            account_code: '',
            description: '',
            segment1:'',
            segment2:'',
            segment3:'',
            segment4:'',
            segment5:'',
            segment6:'',
            segment7:'',
            segment8:'',
            segment9:'',
            segment10:'',
            segment11:'',
            segment12:'',
            value: '',
            active_flag: true,
        }
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
        }
    }
}
</script>
