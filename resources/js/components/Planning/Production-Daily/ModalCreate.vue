<template>
    <span>
        <button type="button" @click="openModal" :class="btnTrans.create.class + ' btn-lg tw-w-25'" >
            <i :class="btnTrans.create.icon"></i>
            {{ btnTrans.create.text }}
        </button>
        <div class="modal fade" id="modal_create" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" >
                <div class="modal-content" v-loading="loading">
                    <div class="modal-header">
                        <h3 style="font-size:22px; font-weight:400;" class="modal-title text-left">
                            สร้างแผนประมาณการผลิตรายวัน
                        </h3>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    </div>
                    <div class="modal-body text-left" v-loading="loading">
                        <form id="create-form">
                            <div class="row col-12">
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                    <label class="text-left tw-font-bold tw-uppercase mb-1"> ปีงบประมาณ :</label>
                                    <div class="input-group ">
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

                                        <el-select v-else v-model="bi_weekly" clearable size="large" placeholder="ปักษ์" filterable ref="bi_weekly" :popper-append-to-body="false">
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
                                <div class="form-group text-right pr-2 mb-0 col-lg-2 col-md-10 col-sm-12 col-xs-12">
                                    <label class=" tw-font-bold tw-uppercase mt-1">&nbsp;</label>
                                    <div class="text-left">
                                        <button type="button" @click="createForm" :class="btnTrans.create.class + ' btn-lg tw-w-25'" >
                                            <i :class="btnTrans.create.icon"></i>
                                            {{ btnTrans.create.text }}
                                        </button>
                                    </div>
                                </div>
                            </div>
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
        props:['budgetYears', 'months', 'biWeekly', 'defaultInput', 'btnTrans', 'url'],
        data() {
            return {
                budget_year: this.defaultInput.current_year,
                month: '',
                bi_weekly: '',
                loading: false,
                errors: {
                    budget_year: false,
                    month: false,
                    bi_weekly: false
                },
                monthLists: [],
                biWeeklyLists: [],
            }
        },
        mounted() {
            this.getMonth();
            this.getBiWeekly();
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
                $('#modal_create').modal('show');
            },
            async createForm() {
                let vm = this;
                let form = $('#create-form');
                let valid = true;
                let errorMsg = '';
                vm.errors.budget_year = false;
                vm.errors.month = false;
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

                vm.loading = true;
                await axios.get(vm.url.ajax_machine_biweekly_create, {
                    params: {
                        search: {
                            budget_year: vm.budget_year,
                            month: vm.month,
                            bi_weekly: vm.bi_weekly,
                        },
                    }
                })
                .then(res => {
                    vm.loading = false;
                    if (res.data.data.status == 'E') {
                        swal({
                            title: 'ตรวจสอบข้อมูล',
                            text: '<span style="font-size: 16px; text-align: left;">'+res.data.data.msg+'</span>',
                            type: "warning",
                            html: true
                        });
                    }else{
                        swal({
                            title: 'สร้างประมาณการผลิตรายวัน',
                            text: '<span style="font-size: 16px; text-align: left;"> ทำการสร้างข้อมูลประมาณการผลิตรายวันเรียบร้อยแล้ว </span>',
                            type: "success",
                            html: true
                        });
                        //redirect
                        window.setTimeout(function() {
                            window.location.href = res.data.data.redirect_show_page;
                        }, 1000);
                    }
                })
                .catch(err => {
                    vm.loading = false;
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">'+err.response.data+'</span>',
                        type: "error",
                        html: true
                    });
                })
                .then(() => {
                    vm.loading = false;
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