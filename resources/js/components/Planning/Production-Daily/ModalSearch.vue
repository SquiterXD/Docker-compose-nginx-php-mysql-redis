<template>
    <span>
        <button type="button" @click="openModal" :class="btnTrans.search.class + ' btn-lg tw-w-25'" >
            <i :class="btnTrans.search.icon"></i>
            {{ btnTrans.search.text }}
        </button>
        <div class="modal fade" id="modal_search" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" >
                <div class="modal-content" v-loading="loading">
                    <div class="modal-header">
                        <h3 style="font-size:22px; font-weight:400;" class="modal-title text-left">
                            ค้นหาแผนประมาณการผลิต
                        </h3>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    </div>
                    <div class="modal-body text-left">
                        <form id="search-form">
                            <div class="row col-12">
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                    <label class="text-left tw-font-bold tw-uppercase mb-1"> ปีงบประมาณ :</label>
                                    <div class="input-group ">
                                        <input type="hidden" name="search[budget_year]" :value="budget_year">
                                        <el-select v-model="budget_year" size="large" placeholder="ปีงบประมาณ" @change="getMonth" clearable filterable ref="budget_year" :popper-append-to-body="false">
                                            <el-option
                                               v-for="(year, index) in budgetYears"
                                                :key="index"
                                                :label="year.thai_year"
                                                :value="year.thai_year"
                                            >
                                            </el-option>
                                        </el-select>
                                        <div id="el_explode_budget_year" class="error_msg text-left"></div>
                                    </div>
                                </div>
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-4 col-sm-6 col-xs-6 mt-2">
                                    <label class=" tw-font-bold tw-uppercase mb-1" > เดือน </label>
                                    <div class="">
                                        <el-select v-if="!budget_year" v-model="month" clearable size="large" placeholder="เดือน" ref="month" disabled>
                                            <el-option
                                               v-for="(month, index) in monthLists"
                                                :key="index"
                                                :label="month.thai_month"
                                                :value="month.period_num"
                                            >
                                            </el-option>
                                        </el-select>

                                        <el-select v-else v-model="month" clearable size="large" placeholder="เดือน" filterable @change="getBiWeekly" ref="month" :popper-append-to-body="false">
                                            <el-option
                                               v-for="(month, index) in monthLists"
                                                :key="index"
                                                :label="month.thai_month"
                                                :value="month.period_num"
                                            >
                                            </el-option>
                                        </el-select>
                                    </div>
                                    <div id="el_explode_month" class="error_msg text-left"></div>
                                </div>
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                    <label class="text-left tw-font-bold tw-uppercase mb-1"> ปักษ์ที่ :</label>
                                    <div class="">
                                        <input type="hidden" name="search[bi_weekly]" :value="bi_weekly">
                                        <el-select v-if="!month" v-model="bi_weekly" clearable size="large" placeholder="ปักษ์" ref="bi_weekly" disabled>
                                           <el-option
                                               v-for="(biweekly, index) in biWeeklyLists"
                                                :key="index"
                                                :label="biweekly.biweekly"
                                                :value="biweekly.biweekly"
                                            >
                                            </el-option>
                                        </el-select>

                                        <el-select v-else v-model="bi_weekly" clearable size="large" placeholder="ปักษ์" filterable :v-loading="b_loading" ref="bi_weekly" :popper-append-to-body="false">
                                           <el-option
                                               v-for="(biweekly, index) in biWeeklyLists"
                                                :key="index"
                                                :label="biweekly.biweekly"
                                                :value="biweekly.biweekly"
                                            >
                                            </el-option>
                                        </el-select>
                                        <div id="el_explode_bi_weekly" class="error_msg text-left"></div>
                                    </div>
                                </div>
                                <div class="form-group text-right  pr-2 mb-0 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <label class=" tw-font-bold tw-uppercase mt-2">&nbsp;</label>
                                    <div class="text-left">
                                        <button type="button" @click="searchForm" :class="btnTrans.search.class + ' btn-lg tw-w-25'" >
                                            <i :class="btnTrans.search.icon"></i>
                                            {{ btnTrans.search.text }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div v-html="html"></div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </span>
</template>
<script>
    export default {
        props:['budgetYears', 'months', 'biWeekly', 'search', 'productTypes', "btnTrans", "url", 'defaultInput'],
        data() {
            return {
                budget_year: this.defaultInput.current_year,
                month: '',
                bi_weekly: '',
                times: '',
                month: '',
                loading: false,
                b_loading: false,
                errors: {
                    budget_year: false,
                    bi_weekly: false
                },
                monthLists: [],
                biWeeklyLists: [],
                html: ''
            }
        },
        mounted() {
            if (this.budget_year) {
                // this.getBiWeekly();
                this.getMonth();
            }
        },
        computed: {
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
            openModal() {
                $('#modal_search').modal('show');
            },
            async searchForm() {
                let vm = this;
                let form = $('#search-form');
                let valid = true;
                let errorMsg = '';
                vm.errors.budget_year = false;
                vm.errors.bi_weekly = false;
                $(form).find("div[id='el_explode_budget_year']").html("");
                $(form).find("div[id='el_explode_month']").html("");
                $(form).find("div[id='el_explode_bi_weekly']").html("");
                if (vm.budget_year == ''){
                    vm.errors.budget_year = true;
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
                if (vm.bi_weekly == ''){
                    vm.errors.bi_weekly = true;
                    valid = false;
                    errorMsg = "กรุณาเลือกปักษ์";
                    $(form).find("div[id='el_explode_bi_weekly']").html(errorMsg);
                }
                if (!valid) {
                    return;
                }

                // vm.loading = true;
                vm.html = '\ <div class="m-t-lg m-b-lg">\
                                <div class="text-center sk-spinner sk-spinner-wave">\
                                    <div class="sk-rect1"></div>\
                                    <div class="sk-rect2"></div>\
                                    <div class="sk-rect3"></div>\
                                    <div class="sk-rect4"></div>\
                                    <div class="sk-rect5"></div>\
                                </div>\
                            </div>';
                await axios.get(vm.url.ajax_production_daily_search, {
                    params: {
                        search: {
                            budget_year: vm.budget_year,
                            month: vm.month,
                            bi_weekly: vm.bi_weekly,
                        },
                    }
                })
                .then(res => {
                    vm.html = '';
                    vm.html = res.data.data.html;
                })
                .catch(err => {
                    vm.html = '';
                    let data = err.response.data;
                    alert(data.message);
                })
                .then(() => {
                    // vm.html = '';
                    // vm.loading = false;
                });
            },
            getMonth(){
                this.month = '';
                this.bi_weekly = '';
                // this.monthLists = this.months.filter(item => {
                //     return item.thai_year.indexOf(this.budget_year) > -1;
                // });
                this.monthLists = this.months;
            },
            getBiWeekly(){
                if (!this.search) {
                    this.bi_weekly = '';
                }
                // this.biWeeklyLists = this.biWeekly.filter(item => {
                //     return item.period_num == this.month && item.thai_year.indexOf(this.budget_year) > -1;
                // });
                this.biWeeklyLists = this.biWeekly.filter(item => {
                    return item.period_num == this.month;
                });
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
            errorRef(res){
                var vm = this;
                vm.errors.budget_year = res.err.budget_year;
                vm.errors.month = res.err.month;
                vm.errors.bi_weekly = res.err.bi_weekly;
            },
        }
    }
</script>