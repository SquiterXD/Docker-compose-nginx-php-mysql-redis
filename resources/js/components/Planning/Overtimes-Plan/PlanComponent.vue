<template>
    <div>
        <div class="ibox float-e-margins mb-2" >
            <div class="row col-12 m-0 mb-2">
                <div class="form-group pl-2 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 mt-3">
                    <h3> ประมาณการค่าใช้จ่ายล่วงเวลาประจำปักษ์ </h3>
                </div>
                <div class="form-group pl-2 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 mt-2 text-right">
                    <button class="btn btn-white btn-lg" @click.prevent="submit">
                        <i class="fa fa-search"></i> ค้นหา
                    </button>
                    <a :href="url.submit_p10" class="btn btn-white btn-lg">ล้าง</a>
                    <modalReportOt
                        :departments="deptReports"
                        :search="search"
                        :btnTrans="btnTrans"
                        :url="url"
                        :selDepartment="sel_department"
                    />
                </div>
            </div>
            <div class="card border-primary mb-3 mt-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <form id="overtimes-form" :action="url.submit_p10">
                                <div class="row">
                                    <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2">
                                        <label class=" tw-font-bold tw-uppercase mb-1"> ปีงบประมาณ </label>
                                        <div class="input-group ">
                                            <input type="hidden" name="budget_year" :value="budget_year">
                                            <el-select  v-model="budget_year" size="medium" placeholder="ปีงบประมาณ" filterable @change="getMonth" ref="budget_year">
                                                <el-option
                                                   v-for="(year, index) in budgetYears"
                                                    :key="index"
                                                    :label="year.thai_year"
                                                    :value="year.thai_year">
                                                </el-option>
                                            </el-select>
                                        </div>
                                        <div id="el_explode_budget_year" class="error_msg text-left"></div>
                                    </div>

                                    <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2">
                                        <label class=" tw-font-bold tw-uppercase mb-1" > เดือน </label>
                                        <div class="">
                                            <input type="hidden" name="month" :value="month">
                                            <el-select v-if="!budget_year" v-model="month" size="medium" placeholder="เดือน" ref="month" disabled>
                                                <el-option
                                                   v-for="(month, index) in monthLists"
                                                    :key="index"
                                                    :label="month.thai_month"
                                                    :value="month.period_num">
                                                </el-option>
                                            </el-select>
                                            <el-select v-else v-model="month" size="medium" placeholder="เดือน" filterable @change="getBiWeeklySeq" v-loading="m_loading" ref="month">
                                                <el-option
                                                   v-for="(month, index) in monthLists"
                                                    :key="index"
                                                    :label="month.thai_month"
                                                    :value="month.period_num">
                                                </el-option>
                                            </el-select>
                                        </div>
                                        <div id="el_explode_month" class="error_msg text-left"></div>
                                    </div>

                                    <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2">
                                        <label class=" tw-font-bold tw-uppercase mb-1" > ปักษ์ </label>
                                        <div class="">
                                            <input type="hidden" name="bi_weekly" :value="bi_weekly">
                                            <el-select v-if="!month" v-model="bi_weekly" clearable size="medium" placeholder="ปักษ์" ref="bi_weekly" disabled>
                                               <el-option
                                                   v-for="(biweekly, index) in biWeeklyLists"
                                                    :key="index"
                                                    :label="biweekly.biweekly"
                                                    :value="biweekly.biweekly">
                                                </el-option>
                                            </el-select>
                                            <el-select v-else v-model="bi_weekly" clearable size="medium" placeholder="ปักษ์" filterable @change="getBiWeeklyDetail" v-loading="b_loading" ref="bi_weekly">
                                               <el-option
                                                   v-for="(biweekly, index) in biWeeklyLists"
                                                    :key="index"
                                                    :label="biweekly.biweekly"
                                                    :value="biweekly.biweekly">
                                                </el-option>
                                            </el-select>
                                        </div>
                                        <div id="el_explode_bi_weekly" class="error_msg text-left"></div>
                                    </div>

                                    <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2">
                                        <label class=" tw-font-bold tw-uppercase mb-1" > ประจำวันที่ </label>
                                        <div v-if="bi_weekly_detail" style="font-size: 14px;" class="p-1">
                                            {{ bi_weekly_detail }}
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <template>
                <div class="row">
                    <div class="col-lg-12 mt-3">
                        <otPlan
                            :departments="departments"
                            :defaultInput="defaultInput"
                            :workingHoliday="workingHoliday"
                            :search="search"
                            :otMain="otMain"
                            :dateArr="dateArr"
                            :url="url"
                            :btnTrans="btnTrans"
                            :colorCode="colorCode"
                            @department="selDepartment"
                        />
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>

<script>
    import otPlan from './OTPlanComponent.vue';
    import modalReportOt from './ModalReportOT.vue';
    export default {
        components: {
            otPlan, modalReportOt
        },
        props:['search', 'otMain', 'workingHour', 'workingHoliday', 'productTypes', 'defaultInput', 'searchInput', 'budgetYears', 'biWeeklyDetails', 'dateFormat', 'btnTrans', 'url', 'departments', 'dateArr', 'colorCode', 'deptReports'],
        data() {
            return {
                budget_year: Object.values(this.search).length > 0? String(this.search['budget_year']): this.defaultInput.current_year,
                month: Object.values(this.search).length > 0? String(this.search['month']): '',
                bi_weekly: Object.values(this.search).length > 0? String(this.search['bi_weekly']): '',
                month_lists: [],
                bi_weekly_lists: [],
                bi_weekly_detail: '',
                loading: false,
                valid: false,
                m_loading: false,
                b_loading: false,
                errors: {
                    budget_year: false,
                    month: false,
                    bi_weekly: false
                },
                set_budget_year: Object.values(this.search).length > 0? String(this.search['budget_year']): this.defaultInput.current_year,
                set_month: Object.values(this.search).length > 0? String(this.search['month']): '',
                set_bi_weekly: Object.values(this.search).length > 0? String(this.search['bi_weekly']): '',
                sel_department:'',
            }
        },
        mounted() {
            if (this.budget_year) {
                this.getMonth();
            }
            if (this.budget_year && this.month && this.bi_weekly) {
                this.getMonth();
                this.getBiWeeklySeq();
            }
            this.getBiWeeklyDetail();
        },
        computed: {
            monthLists: function () {
                return this.month_lists;
            },
            biWeeklyLists: function () {
                return this.bi_weekly_lists;
            }
        },
        watch:{
            errors: {
                handler(val){
                    val.budget_year? this.setError('budget_year') : this.resetError('budget_year');
                    val.month? this.setError('month') : this.resetError('month');
                    val.bi_weekly? this.setError('bi_weekly') : this.resetError('bi_weekly');
                },
                deep: true,
            },
        },
        methods: {
            getMonth(){
                var vm = this;
                if (vm.search) {
                    if(vm.set_budget_year != vm.budget_year){
                        vm.month = '';
                        vm.bi_weekly = '';
                        vm.bi_weekly_detail = '';
                    }
                }else{
                    vm.month = '';
                    vm.bi_weekly = '';
                    vm.bi_weekly_detail = '';
                }
                vm.month_lists = vm.searchInput.months;
            },
            getBiWeeklySeq(){
                var vm = this;
                if (vm.search) {
                    if(vm.set_month != vm.month || vm.set_bi_weekly != vm.bi_weekly){
                        vm.bi_weekly = '';
                        vm.bi_weekly_detail = '';
                    }
                }else{
                    vm.bi_weekly = '';
                    vm.bi_weekly_detail = '';
                }
                vm.bi_weekly_lists = vm.searchInput.bi_weekly.filter(item => {
                    return item.period_num == vm.month;
                });
            },
            getBiWeeklyDetail(){
                var vm = this;
                if (vm.biWeekly == '' || vm.biWeekly == null) {vm.biWeeklyDetail = '';}
                vm.biWeeklyDetails.filter(item => {
                    if (item.thai_year == vm.budget_year &&  item.period_num == vm.month &&  item.biweekly == vm.bi_weekly) {
                        return vm.bi_weekly_detail = item.thai_combine_date;
                    }
                });
            },
            async submit(){
                var form  = $('#overtimes-form');
                let inputs = form.serialize();
                let valid = true;
                let errorMsg = '';
                this.errors.budget_year = false;
                this.errors.month = false;
                this.errors.bi_weekly = false;
                $(form).find("div[id='el_explode_budget_year']").html("");
                $(form).find("div[id='el_explode_month']").html("");
                $(form).find("div[id='el_explode_bi_weekly']").html("");
                if (this.budget_year == ''){
                    this.errors.budget_year = true;
                    valid = false;
                    errorMsg = "กรุณาเลือกปีงบประมาณ";
                    $(form).find("div[id='el_explode_budget_year']").html(errorMsg);
                }
                if (this.month == ''){
                    this.errors.month = true;
                    valid = false;
                    errorMsg = "กรุณาเลือกเดือน";
                    $(form).find("div[id='el_explode_month']").html(errorMsg);
                }
                if (this.bi_weekly == ''){
                    this.errors.bi_weekly = true;
                    valid = false;
                    errorMsg = "กรุณาเลือกปักษ์";
                    $(form).find("div[id='el_explode_bi_weekly']").html(errorMsg);
                }
                if (!valid) {
                    return;
                }
                this.loading = true;
                form.submit();
            },
            setError(ref_name){
                let ref = this.$refs[ref_name].$refs.reference 
                        ? this.$refs[ref_name].$refs.reference.$refs.input 
                        : (this.$refs[ref_name].$refs.textarea 
                            ? this.$refs[ref_name].$refs.textarea 
                            : (this.$refs[ref_name].$refs.input.$refs 
                                ? this.$refs[ref_name].$refs.input.$refs.input 
                                : this.$refs[ref_name].$refs.input ));
                ref.style = "border: 1px solid red;";
            },
            resetError(ref_name){
                let ref = this.$refs[ref_name].$refs.reference 
                        ? this.$refs[ref_name].$refs.reference.$refs.input 
                        : (this.$refs[ref_name].$refs.textarea 
                            ? this.$refs[ref_name].$refs.textarea
                            : (this.$refs[ref_name].$refs.input.$refs 
                                ? this.$refs[ref_name].$refs.input.$refs.input 
                                : this.$refs[ref_name].$refs.input ));
                ref.style = "";
            },
            selDepartment(res){
                this.sel_department = res;
            }
        }
    }
</script>