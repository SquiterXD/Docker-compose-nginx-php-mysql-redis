<template>
    <!-- <div> -->
        <div class="row">
            <form id="plan-daily-form" class="col-12">
                <div class="row col-12">
                    <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-4 col-sm-6 col-xs-6 mt-2">
                        <label class=" tw-font-bold tw-uppercase mb-1"> ปีงบประมาณ </label>
                        <div class="input-group">
                            <el-input v-model="budget_year" placeholder="ปีงบประมาณ" :disabled="true" ref="budget_year" size="medium"> </el-input>
                        </div>
                        <div id="el_explode_budget_year" class="error_msg text-left"></div>
                    </div>
                    <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-4 col-sm-6 col-xs-6 mt-2">
                        <label class=" tw-font-bold tw-uppercase mb-1" > เดือน </label>
                        <div class="input-group">
                            <el-input v-model="month_th" placeholder="เดือน" :disabled="true" ref="month" size="medium"> </el-input>
                        </div>
                        <div id="el_explode_month" class="error_msg text-left"></div>
                    </div>
                    <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-4 col-sm-6 col-xs-6 mt-2">
                        <label class=" tw-font-bold tw-uppercase mb-1" > ปักษ์ </label>
                        <div class="input-group">
                            <el-input v-model="bi_weekly" placeholder="ปักษ์" :disabled="true" ref="bi_weekly" size="medium"> </el-input>
                        </div>
                        <div id="el_explode_bi_weekly" class="error_msg text-left"></div>
                    </div>
                    <div class="form-group pl-2 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 mt-2">
                        <label> <br> &nbsp; </label>
                        <!-- ซ่อนการแสดงปุ่มแสดงข้อมูล 20112021 -->
                        <button :class="btnTrans.show.class + ' btn-lg mt-3'" @click.prevent="getData">
                            <i :class="btnTrans.show.icon"></i> {{ btnTrans.show.text }}
                        </button>
                        <ControlPlanDaily
                            :btn-trans="btnTrans"
                            :url="url"
                            :modal-control-input="modalControlInput"
                            :item-production-main="itemProductionMain"
                            :machine-biweekly="machineBiweekly"
                            :search="[]"
                            :product-type="productType"
                            :date-format="dateFormat"
                            :d-budget-year="budget_year"
                            :d-month="month"
                            :d-bi-weekly="bi_weekly"
                            :product-daily-plan="productDailyPlan"
                            :is-control-disable="isControlDisable"
                            @errorRef="errorRef"
                            @fetchDataP07="fetchDataP07"
                        />
                        <button v-if="productDailyPlan.can.edit && isCurrBiweekly" :class="btnTrans.edit.class + ' btn-lg mt-3'" @click.prevent="reFetchDataP03">
                            <i class="fa fa-calendar"></i> อัพเดตชั่วโมงการทำงาน
                        </button>
                    </div>
                </div>
                <div class="col-12 text-right">
                    <div v-if="msg.machine && isCurrBiweekly">
                        <h4 class="text-danger mt-3">
                            <div v-html="msg.machine"></div>
                        </h4>
                    </div>
                    <div v-if="msg.wkh && isCurrBiweekly">
                        <h4 class="text-danger mt-3">
                            <div v-html="msg.wkh"></div>
                        </h4>
                    </div>
                </div>
                <div class="form-group pl-2 pr-2 mb-0 col-lg-12 col-md-12 col-sm-6 col-xs-6 mt-2">
                    <div class="table-responsive" v-html="html"></div>
                </div>
            </form>
        </div>
    <!-- </div> -->
</template>

<script>
    import ControlPlanDaily from './ModalControl.vue';
    export default {
        components: {
            ControlPlanDaily
        },
        props:[
            "machineBiweekly", "productDailyPlan", "modalControlInput", "budgetYears", "months", "biWeekly", "dateFormat", "productType", "btnTrans", "url", "search", "itemProductionMain", "isControlDisable", "messageCheckWKHHtml", "messageCheckMachineHtml", "isCurrBiweekly"
        ],
        data() {
            return {
                budget_year: this.search? this.search.budget_year: '',
                month: this.search? this.search.month: '',
                month_th: '',
                bi_weekly: this.search? this.search.biweekly: '',
                times: '',
                loading: false,
                m_loading: false,
                b_loading: false,
                errors: {
                    budget_year: false,
                    month: false,
                    bi_weekly: false
                },
                monthLists: [],
                biWeeklyLists: [],
                html: '',
                msg: {
                    wkh: this.messageCheckWKHHtml,
                    machine: this.messageCheckMachineHtml
                },
            }
        },
        mounted() {
            this.getSearch();
            this.getMonth();
            this.getData();
        },
        computed: {
        },
        methods: {
            async getData() {
                let vm = this;
                let form = $('#plan-daily-form');
                let valid = true;
                let errorMsg = '';
                vm.errors.budget_year = false;
                vm.errors.month = false;
                vm.errors.bi_weekly = false;
                $(form).find("div[id='el_explode_budget_year']").html("");
                $(form).find("div[id='el_explode_month']").html("");
                $(form).find("div[id='el_explode_bi_weekly']").html("");
                if (vm.budget_year == '' || vm.budget_year == null){
                    vm.errors.budget_year = true;
                    valid = false;
                    errorMsg = "กรุณาเลือกปีงบประมาณ";
                    $(form).find("div[id='el_explode_budget_year']").html(errorMsg);
                }
                if (vm.month == '' || vm.month == null){
                    vm.errors.month = true;
                    valid = false;
                    errorMsg = "กรุณาเลือกเดือน";
                    $(form).find("div[id='el_explode_month']").html(errorMsg);
                }
                if (vm.bi_weekly == '' || vm.bi_weekly == null){
                    vm.errors.bi_weekly = true;
                    valid = false;
                    errorMsg = "กรุณาเลือกปักษ์";
                    $(form).find("div[id='el_explode_bi_weekly']").html(errorMsg);
                }
                if (!valid) {
                    return;
                }

                vm.refreshData = vm.refreshData + 1;
                vm.loading = true;
                vm.html = '\ <div class="m-t-lg m-b-lg">\
                                <div class="text-center sk-spinner sk-spinner-wave">\
                                    <div class="sk-rect1"></div>\
                                    <div class="sk-rect2"></div>\
                                    <div class="sk-rect3"></div>\
                                    <div class="sk-rect4"></div>\
                                    <div class="sk-rect5"></div>\
                                </div>\
                            </div>';
                let params = {
                    product_type: vm.productType,
                    budget_year: vm.budget_year,
                    month: vm.month,
                    bi_weekly: vm.bi_weekly,
                };
                await axios.get(vm.url.ajax_get_production_machine, { params })
                    .then(res => {
                        vm.html = res.data.data.html
                    })
                    .catch(err => {
                        // vm.html = res.data.data.html
                        let data = err.response.data;
                        alert(data.message);
                    })
                    .then(() => {
                        vm.loading = false;
                    });
            },
            getSearch(){
                // this.monthLists = this.months.filter(item => {
                //     return item.thai_year.indexOf(this.budget_year) > -1;
                // });
                // this.biWeeklyLists = this.biWeekly.filter(item => {
                //     return item.period_num == this.month && item.thai_year.indexOf(this.budget_year) > -1;
                // });
                this.monthLists = this.months;
                this.biWeeklyLists = this.biWeekly.filter(item => {
                    return item.period_num == this.month;
                });
            },
            getMonth(){
                var vm = this;
                // this.month = '';
                // this.bi_weekly = '';
                // vm.monthLists = vm.months.filter(item => {
                //     return item.thai_year.indexOf(vm.budget_year) > -1;
                // });
                vm.monthLists = vm.months
                if (vm.monthLists[0].period_num == vm.month) {
                    vm.month_th = vm.monthLists[0].thai_month;
                }
            },
            getBiWeekly(){
                this.bi_weekly = '';
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
            async reFetchDataP03(){
                let vm = this;
                vm.html = '\ <div class="m-t-lg m-b-lg">\
                                <div class="text-center sk-spinner sk-spinner-wave">\
                                    <div class="sk-rect1"></div>\
                                    <div class="sk-rect2"></div>\
                                    <div class="sk-rect3"></div>\
                                    <div class="sk-rect4"></div>\
                                    <div class="sk-rect5"></div>\
                                </div>\
                            </div>';
                let params = {
                    product_type: vm.productType,
                    budget_year: vm.budget_year,
                    month: vm.month,
                    bi_weekly: vm.bi_weekly,
                };
                await axios.get(vm.url.ajax_update_working_hour, { params })
                .then(res => {
                    swal({
                        title: '<h2 style="margin-top: 30px;"> เปลี่ยนแปลงชั่วโมงการทำงาน </h2>',
                        text: '<span style="font-size: 16px; text-align: left;"> อัพเดตการเปลี่ยนแปลงชั่วโมงการทำงานเรียบร้อยแล้ว </span>',
                        type: "success",
                        html: true
                    });
                    this.getData();
                    this.$emit("updateControlDisable", false);
                    this.msg.machine = '';
                    this.msg.wkh = '';
                })
                .catch(err => {
                    let data = err.response.data;
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">'+data.message+'</span>',
                        type: "error",
                        html: true
                    });
                })
                .then(() => {
                    // vm.html = '';
                });
            },
            fetchDataP07(res){
                this.getData();
                this.$emit("fetchDataP07", res);
            }
        },
        watch: {
            productType: async function (value, oldValue) {
                this.html = '';
            },
            errors: {
                handler(val){
                    val.budget_year? this.setError('budget_year') : this.resetError('budget_year');
                    val.month? this.setError('month') : this.resetError('month');
                    val.bi_weekly? this.setError('bi_weekly') : this.resetError('bi_weekly');
                },
                deep: true,
            },
        },
    }
</script>

<style scope>
    .el-input--medium .el-input__inner {
        height: 30px !important;
        line-height: 36px;
    }
    .el-input--medium .el-input__icon {
        line-height: 30px;
    }
</style>