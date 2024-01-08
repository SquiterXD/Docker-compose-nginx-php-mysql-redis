<div class="card">
    <div class="card-body" >
        <form id="fund-form" v-loading="">
            <div class="row">
                <div class="col-lg-5 form-inline">
                    <label> ปีงบประมาณ <span class="text-danger">*</span></label>
                    <el-input name="budget_year" v-model="budget_year" maxlength="4" @input="onlyNumeric()"></el-input>
                    {{-- <datepicker-th  style="width: 100%;"
                                    class="el-input__inner"
                                    name="budget_year"
                                    p-type="year"
                                    placeholder="ปี"
                                    v-model="budget_year">
                    </datepicker-th> --}}
                    {{-- <datepicker-th
                        style="width: 100%;"
                        class="form-control md:tw-mb-0 tw-mb-2"
                        name="budget_year"
                        p-type="year"
                        placeholder="โปรดเลือกปี"
                        v-model="budget_year"
                        :dateWasSelected="getValueStYear" 
                        >
                    </datepicker-th> --}}

                    {{-- <datepicker-th  style="width: 100%;"
                        class="el-input__inner"
                        name="`budget_year`"
                        p-type="year"
                        placeholder="โปรดเลือกปี"
                        v-model="budget_year"
                        format="YYYY"
                        @dateWasSelected="getValueStYear(...arguments)" /> --}}
{{-- 
                        <datepicker-th
                            style="width: 100%;"
                            class="form-control md:tw-mb-0 tw-mb-2"
                            name="budget_year"
                            placeholder="โปรดเลือกวันที่"
                            v-model="budget_year"
                            format="DD-MM-YYYY"
                            @dateWasSelected="fromDateWasSelected">
                        </datepicker-th> --}}

     
                </div>
                <div class="form-group pl-2 pr-2 mb-0 col-lg-5 col-md-4 col-sm-6 col-xs-6 mt-2">
                    <label class=" tw-font-bold tw-uppercase mb-0" >&nbsp;</label>
                    <div class="text-right">
                        <button class="btn btn-default btn-sm" @click.prevent="findPeriod()">
                            คำนวณงวดการสั่งซื้อ
                        </button>
                        <a href="{{ $actionUrl }}" class="btn btn-sm btn-danger"><i class="fa fa-undo"></i> รีเซ็ต </a>
                    </div>
                    
                    {{-- <input type="hidden" name="periodLists" v-model="periodLists"> --}}
                </div>
            </div>
        </form>
    </div>
</div>
