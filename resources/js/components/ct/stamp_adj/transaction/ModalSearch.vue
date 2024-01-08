<template>
    <span>
        <button type="button" @click="openModal" :class="btnTrans.search.class + ' btn-lg tw-w-25'" >
            <i :class="btnTrans.search.icon"></i>
            {{ btnTrans.search.text }}
        </button>

        <div class="modal fade" id="modal_search" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width: 90%; max-width:950px;">
                <div class="modal-content" v-loading="loading">
                    <div class="modal-header">
                        <h3 style="font-size:22px; font-weight:400;" class="modal-title text-left">
                            ค้นหาการติดตามการใช้งานแสตมป์รายวัน
                        </h3>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    </div>
                    <div class="modal-body text-left">
                        <form id="search-form" :action="url.search">
                            <div class="row col-12">
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                    <label class="text-left tw-font-bold tw-uppercase mb-1"> ปีงบประมาณ :</label>
                                    <div class="input-group ">
                                        <input type="hidden" name="search[budget_year]" :value="budget_year">
                                        <el-select v-model="budget_year" size="large" placeholder="ปีงบประมาณ" clearable filterable ref="budget_year" :popper-append-to-body="false">
                                            <el-option
                                               v-for="(year, index) in budgetYears"
                                                :key="index"
                                                :label="year"
                                                :value="year"
                                            >
                                            </el-option>
                                        </el-select>
                                        <div id="el_explode_budget_year" class="error_msg text-left"></div>
                                    </div>
                                </div>

                                <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                    <label class="text-left tw-font-bold tw-uppercase mb-1"> เดือน :</label>
                                    <div class="input-group ">
                                        <input type="hidden" :value="month" name="search[thai_month]">
                                        <el-select v-model="month" size="large" placeholder="เดือน" clearable filterable ref="month" :popper-append-to-body="false">
                                            <el-option
                                               v-for="(month, index) in monthList"
                                                :key="index"
                                                :label="month.thai_month"
                                                :value="month.thai_month"
                                            >
                                            </el-option>
                                        </el-select>
                                        <div id="el_explode_month" class="error_msg text-left"></div>
                                    </div>
                                </div>

                                <div class="form-group text-right pr-2 mb-0 col-lg-2 col-md-10 col-sm-12 col-xs-12">
                                    <label class=" tw-font-bold tw-uppercase mt-2">&nbsp;</label>
                                    <div class="text-left">
                                        <button type="button" @click.prevent="searchForm" :class="btnTrans.search.class + ' btn-lg tw-w-25'" >
                                            <i :class="btnTrans.search.icon"></i>
                                            {{ btnTrans.search.text }}
                                        </button>
                                    </div>
                                    <small class="font-bold">
                                        &nbsp;
                                    </small>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </span>
</template>
<script>
    export default {
        props:['budgetYears', 'monthList', 'defBudgetYear', "btnTrans", "url"],
        data() {
            return {
                budget_year: this.defBudgetYear,
                month: '',
                loading: false,
                errors: {
                    budget_year: false,
                    month: false
                },
            }
        },
        mounted() {
            //
        },
        computed: {
            //
        },
        watch:{
            errors: {
                handler(val){
                    val.budget_year? this.setError('budget_year') : this.resetError('budget_year');
                    val.month? this.setError('month') : this.resetError('month');
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
                vm.errors.month = false;
                $(form).find("div[id='el_explode_budget_year']").html("");
                $(form).find("div[id='el_explode_month']").html("");
                if (vm.budgetYear == ''){
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
                if (!valid) {
                    return;
                }

                vm.loading = true;
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
            errorRef(res){
                var vm = this;
                vm.errors.budget_year = res.err.budget_year;
                vm.errors.month = res.err.month;
            },
        }
    }
</script>