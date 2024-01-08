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
                        <h4 class="modal-title">ค้นหาประมาณการจัดซื้อแสตมป์รายเดือน</h4>
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
                                    <el-select v-model="budget_year" size="large" placeholder="ปีงบประมาณ"  clearable filterable :popper-append-to-body="false">
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

                            <div class="form-group text-right  pr-2 mb-0 col-lg-2 col-md-10 col-sm-12 col-xs-12">
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
        props:['budgetYears', 'monthList', 'search', "btnTrans", "url", "defPeriodYear"],
        data() {
            return {
                budget_year: this.search.length? this.search['budget_year']: this.defPeriodYear,
                biweekly: '',
                month: '',
                status: 'Active',
                statusLists: [{
                    value: 'Active',
                    label: 'Active'
                }, {
                    value: 'Inactive',
                    label: 'Inactive'
                }],
                biWeeklyLists: [],
                loading: false,
                b_loading: false,
                html: ''
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
                    val.biweekly? this.setError('biweekly') : this.resetError('biweekly');
                },
                deep: true,
            },
            budget_year : async function (value, oldValue) {
                this.month = '';
            },
            month : async function (value, oldValue) {
                this.biweekly = '';
            },
        },
        methods: {
            openModal() {
                $('#modal_search').modal('show');
            },
            async searchForm() {
                let vm = this;
                vm.loading = true;

                await axios.get(vm.url.ajax_search, {
                        params: {
                            budget_year: vm.budget_year,
                            biweekly: vm.biweekly,
                            thai_month: vm.month,
                            // approved_status: vm.status
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
        }
    }
</script>