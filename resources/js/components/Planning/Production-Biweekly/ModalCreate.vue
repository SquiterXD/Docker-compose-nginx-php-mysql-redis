<template>
    <span>

        <button type="button" @click="openModal" :class="btnTrans.create.class + ' btn-lg tw-w-25'" >
            <i :class="btnTrans.create.icon"></i>
            {{ btnTrans.create.text }}
        </button>

        <div class="modal inmodal fade" id="modal_create" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width: 90%; max-width:950px;">
                <div class="modal-content" >
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">สร้างแผนประมาณการผลิต</h4>
                        <small class="font-bold">
                            &nbsp;
                        </small>
                    </div>
                    <div class="modal-body text-left">
                        <form id="production-plan-create-form">
                            <div class="row col-12 m-0">
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-6 col-xs-6 mt-2">
                                    <label class="tw-font-bold tw-uppercase mb-1"> ปีงบประมาณ :</label>
                                    <div class="input-group ">
                                        <el-input :readonly="true" placeholder="Please input" v-model="budget_year" size="large"></el-input>
                                        <!-- <el-select  v-model="budget_year" clearable size="large" placeholder="ปีงบประมาณ" filterable @change="getBiWeekly" ref="budget_year_create">
                                            <el-option
                                               v-for="(year, index) in budgetYears"
                                                :key="index"
                                                :label="year.thai_year"
                                                :value="year.thai_year"
                                            >
                                            </el-option>
                                        </el-select> -->
                                        <div id="el_explode_budget_year" class="error_msg text-left"></div>
                                    </div>
                                </div>
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2">
                                    <label class="tw-font-bold tw-uppercase mb-1"> ปักษ์ที่ :</label>
                                    <div class="">

                                        <el-input :readonly="true" placeholder="Please input" v-model="bi_weekly" size="large"></el-input>
                                        <!-- <el-select v-if="!budget_year" v-model="bi_weekly" clearable size="large" placeholder="ปักษ์" ref="bi_weekly_create" readonly>
                                           <el-option
                                               v-for="(biweekly, index) in biWeeklyLists"
                                                :key="index"
                                                :label="biweekly.biweekly"
                                                :value="biweekly.biweekly"
                                            >
                                            </el-option>
                                        </el-select> -->

                                        <!-- <el-select v-else v-model="bi_weekly" clearable size="large" placeholder="ปักษ์" filterable :v-loading="b_loading" ref="bi_weekly_create" @change="getDetail">
                                           <el-option
                                               v-for="(biweekly, index) in biWeeklyLists"
                                                :key="index"
                                                :label="biweekly.biweekly"
                                                :value="biweekly.biweekly"
                                            >
                                            </el-option>
                                        </el-select> -->
                                        <div id="el_explode_bi_weekly" class="error_msg text-left"></div>
                                    </div>
                                </div>
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2" >
                                    <label class="tw-font-bold tw-uppercase mb-1"> ครั้งที่ :</label>
                                    <el-input v-loading="timeLoading" placeholder="ครั้งที่" v-model="times" size="large" :readonly="true"> </el-input>
                                </div>
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-3 col-sm-6 col-xs-6 mt-2">
                                    <label class="tw-font-bold tw-uppercase mb-1"> ประจำเดือน :</label>
                                    <el-input placeholder="ประจำเดือน" v-model="month" size="large" :readonly="true"> </el-input>
                                </div>
                            </div>
                        </form>

                        <transition
                            enter-active-class="animated fadeInUp"
                            leave-active-class="animated fadeOutDown">
                            <div v-html="html" v-if="bi_weekly" class="mt-4"></div>
                        </transition>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white btn-lg tw-w-25'" data-dismiss="modal">Close</button>
                        <button type="button" v-loading="loading" @click.prevent="submit()" :class="btnTrans.create.class + ' btn-lg tw-w-25'" >
                            <i :class="btnTrans.create.icon"></i>
                            {{ btnTrans.create.text }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </span>
</template>
<script>
    export default {
        props:['budgetYears', 'biWeekly', 'search', "defaultYear", "defaultBiWeekly", "defaultDefaultMonth", "btnTrans", "url"],
        data() {
            return {
                budget_year: this.defaultYear ? this.defaultYear : '',
                bi_weekly: this.defaultBiWeekly? this.defaultBiWeekly : '',
                times: '',
                month: '',
                loading: false,
                b_loading: false,
                timeLoading: false,
                errors: {
                    budget_year: false,
                    bi_weekly: false
                },
                biWeeklyLists: [],

                html: '',
            }
        },
        mounted() {
            
        },
        computed: {
        },
        watch:{
            errors: {
                handler(val){
                    val.budget_year? this.setError('budget_year') : this.resetError('budget_year');
                    val.bi_weekly? this.setError('bi_weekly') : this.resetError('bi_weekly');
                },
                deep: true,
            },
        },
        methods: {
            openModal() {
                $('#modal_create').modal('show');
                this.getBiWeekly();
            },
            getBiWeekly(){
                this.bi_weekly = '';
                this.month = '';
                this.times = '';
                // this.biWeeklyLists = this.biWeekly.filter(item => {
                //     return item.thai_year.indexOf(this.budget_year) > -1;
                // });

                this.budget_year = this.defaultYear ? this.defaultYear : '',
                this.bi_weekly = this.defaultBiWeekly? this.defaultBiWeekly : '',
                this.month = this.defaultDefaultMonth? this.defaultDefaultMonth : '',

                this.getDetail();
            },
            async getDetail(){
                let vm = this;
                // this.biWeeklyLists.find(item => {
                //     if (item.biweekly == this.bi_weekly) {
                //         return this.month = item.thai_month;
                //     }
                // });
                vm.times = 1;
                vm.html = '';
                vm.timeLoading = true;
                axios.get(vm.url.ajax_modal_create_details, { params : {
                    budget_year: vm.budget_year,
                    bi_weekly: vm.bi_weekly
                }}).then(res => {
                    let response = res.data.data;
                    vm.times = response.times;
                    vm.html = response.html;
                    vm.timeLoading = false;

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
            async submit(){
                let vm = this;
                vm.loading = true;

                var form  = $('#modal_create');
                let inputs = form.serialize();
                let valid = true;
                let errorMsg = '';
                this.errors.budget_year = false;
                this.errors.bi_weekly = false;
                $(form).find("div[id='el_explode_budget_year']").html("");
                $(form).find("div[id='el_explode_bi_weekly']").html("");

                if (this.budget_year == ''){
                    this.errors.budget_year = true;
                    valid = false;
                    errorMsg = "กรุณาเลือกปีงบประมาณ";
                    $(form).find("div[id='el_explode_budget_year']").html(errorMsg);
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
                let res = await this.create();
                vm.loading = false;
                if(res.status == 'S'){
                    swal({
                        title: 'สร้างแผนประมาณการผลิต',
                        text: '<span style="font-size: 16px; text-align: left;"> ทำการสร้างข้อมูลแผนประมาณการผลิตเรียบร้อยแล้ว </span>',
                        type: "success",
                        html: true
                    });
                    //redirect
                    window.setTimeout(function() {
                        window.location.href = res.redirect_show_page;
                    }, 2000);
                }else{
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">'+res.msg+'</span>',
                        type: "error",
                        html: true
                    });
                }
            },
            async create() {
                let vm2 = this;
                let data = {
                    msg: ''
                };

                let params = {
                    budget_year: vm2.budget_year,
                    bi_weekly: vm2.bi_weekly
                };

                await axios
                    .post(vm2.url.ajax_production_biweekly_store, params)
                    .then(res => {
                        data = res.data.data;
                        vm2.redirect_show_page = data.redirect_show_page;
                    })
                    .catch(err => {
                        let msg = err.response.data.data;
                        data = {
                            msg: msg
                        }
                    })
                    .then(() => {
                        vm2.loading = false;
                    });

                return data;
            },
        }
    }
</script>