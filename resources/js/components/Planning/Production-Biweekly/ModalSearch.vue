<template>
    <span>

        <button type="button" @click="openModal" :class="btnTrans.search.class + ' btn-lg tw-w-25'" >
            <i :class="btnTrans.search.icon"></i>
            {{ btnTrans.search.text }}
        </button>

        <div class="modal inmodal fade" id="modal_search" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width: 90%; max-width:950px;">
                <div class="modal-content" v-loading="loading">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">ค้นหาแผนประมาณการผลิต</h4>
                        <small class="font-bold">
                            &nbsp;
                        </small>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row col-12">
                            <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> ปีงบประมาณ :</label>
                                <div class="input-group ">
                                    <input type="hidden" name="search[budget_year]" :value="budget_year">
                                    <el-select v-model="budget_year" size="large" placeholder="ปีงบประมาณ" @change="getBiWeekly" clearable filterable :popper-append-to-body="false">
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
                                    <input type="hidden" :value="month">
                                    <el-select v-model="month" size="large" placeholder="เดือน" clearable filterable :popper-append-to-body="false">
                                        <el-option
                                           v-for="(month, index) in monthList[budget_year]"
                                            :key="index"
                                            :label="index"
                                            :value="index"
                                        >
                                        </el-option>
                                    </el-select>
                                    <div id="el_explode_month" class="error_msg text-left"></div>
                                </div>
                            </div>

                            <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> ปักษ์ที่ :</label>
                                <div class="">
                                    <input type="hidden" name="search[bi_weekly]" :value="bi_weekly">
                                    <el-select v-if="budget_year != '' && month != ''" v-model="bi_weekly" clearable size="large" placeholder="ปักษ์" :popper-append-to-body="false">
                                       <el-option
                                           v-for="(biweekly, index) in monthList[budget_year][month]"
                                            :key="index"
                                            :label="biweekly.biweekly"
                                            :value="biweekly.biweekly"
                                        >
                                        </el-option>
                                    </el-select>

                                    <el-select v-else v-model="bi_weekly" disabled clearable size="large" placeholder="ปักษ์" filterable >
                                       <el-option key="" label="" value="" ></el-option>
                                    </el-select>
                                    <div id="el_explode_bi_weekly" class="error_msg text-left"></div>
                                </div>
                            </div>

                            <div class="form-group text-right  pr-2 mb-0 col-lg-3 col-md-10 col-sm-12 col-xs-12">
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
        props:['budgetYears', 'monthList', 'biWeekly', 'search', 'productTypes', "btnTrans", "url", "defaultYear"],
        data() {
            return {
                budget_year: this.search.length? this.search['budget_year']: this.defaultYear,
                bi_weekly: '',
                times: '',
                month: '',
                loading: false,
                b_loading: false,
                errors: {
                    budget_year: false,
                    bi_weekly: false
                },
                biWeeklyLists: [],
                html: ''
            }
        },
        mounted() {
            if (this.budget_year) {
                this.getBiWeekly();
            }
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
            budget_year : async function (value, oldValue) {
                this.month = '';
            },
            month : async function (value, oldValue) {
                this.bi_weekly = '';
            },
        },
        methods: {
            openModal() {
                $('#modal_search').modal('show');
            },
            async searchForm() {
                let vm = this;
                vm.loading = true;

                await axios.get(vm.url.ajax_production_biweekly_search, {
                        params: {
                            search: {
                                budget_year: vm.budget_year,
                                thai_month: vm.month,
                                biweekly: vm.bi_weekly,
                            },
                        }
                    })
                    .then(res => {
                        vm.html = res.data.data.html
                    })
                    .catch(err => {
                        vm.html = '';
                        let data = err.response.data;
                        alert(data.message);
                    })
                    .then(() => {
                        vm.loading = false;
                    });
            },
            getBiWeekly(){
                if (!this.search) {
                    this.bi_weekly = '';
                    this.month = '';
                    this.times = '';
                }
                this.biWeeklyLists = this.biWeekly.filter(item => {
                    return item.period_year_thai.indexOf(this.budget_year) > -1;
                });
            },
        }
    }
</script>