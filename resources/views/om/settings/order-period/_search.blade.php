
<div class="card">
    <div class="card-body" >
        <form id="fund-form" v-loading="">
            <div class="row">
                <div class="col-lg-5 form-inline">
                    <label> ปีงบประมาณ <span class="text-danger">*</span></label>
                    {{-- <input type="text" name="search[budget_year]" v-model="budget_year"> --}}
                    {{-- <el-input name="budget_year" v-model="budget_year" maxlength="4" @input="onlyNumeric()"></el-input> --}}

                    <input type="hidden" name="budget_year" :value="budget_year" >
                    <el-select v-model="budget_year" :disabled="this.budgetYearList < 1" style="width: 100%;"
                        filterable
                        remote
                        clearable >
                        <el-option
                           v-for="budgetYear in budgetYearList"
                            :label="budgetYear.label"
                            :value="budgetYear.value"
                        >
                        </el-option>
                    </el-select>
                </div>
                <div class="form-group pl-2 pr-2 mb-0 col-lg-5 col-md-4 col-sm-6 col-xs-6 mt-2">
                    <label class=" tw-font-bold tw-uppercase mb-0" >&nbsp;</label>
                    <div class="text-right">
                        <button class="btn btn-default btn-sm" @click.prevent="findPeriod()">
                            <i class="fa fa-search"></i> ค้นหา
                        </button>
                        <a href="{{ $actionUrl }}" class="btn btn-sm btn-danger"><i class="fa fa-undo"></i> รีเซ็ต </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

