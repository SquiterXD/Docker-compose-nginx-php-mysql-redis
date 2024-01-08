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
                                            :label="year.thai_year"
                                            :value="year.thai_year"
                                        >
                                        </el-option>
                                    </el-select>
                                    <div id="el_explode_budget_year" class="error_msg text-left"></div>
                                </div>
                            </div>
                            <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> ปักษ์ที่ :</label>
                                <div class="">
                                    <input type="hidden" name="search[biweekly]" :value="biweekly">
                                    <el-select v-if="!budget_year" v-model="biweekly" clearable size="large" placeholder="ปักษ์" disabled>
                                       <el-option
                                           v-for="(biweekly, index) in biWeeklyLists"
                                            :key="index"
                                            :label="biweekly.biweekly"
                                            :value="biweekly.biweekly"
                                        >
                                        </el-option>
                                    </el-select>

                                    <el-select v-else v-model="biweekly" clearable size="large" placeholder="ปักษ์" filterable :v-loading="b_loading" :popper-append-to-body="false">
                                       <el-option
                                           v-for="(biweekly, index) in biWeeklyLists"
                                            :key="index"
                                            :label="biweekly.biweekly"
                                            :value="biweekly.biweekly"
                                        >
                                        </el-option>
                                    </el-select>
                                    <div id="el_explode_biweekly" class="error_msg text-left"></div>
                                </div>
                            </div>
                            <!-- <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> สถานะ :</label>
                                <div class="input-group ">
                                    <el-select v-model="status" size="large" placeholder="สถานะ" clearable filterable>
                                        <el-option
                                           v-for="(status, index) in statusLists"
                                            :key="status.value"
                                            :label="status.label"
                                            :value="status.value"
                                        >
                                        </el-option>
                                    </el-select>
                                    <div id="el_status" class="error_msg text-left"></div>
                                </div>
                            </div> -->


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
        props:['budgetYears', 'pBiweekly', 'search', 'productTypes', "btnTrans", "url"],
        data() {
            return {
                budget_year: this.search? this.search['budget_year']: '',
                biweekly: this.search? String(this.search['biweekly']): '',
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
                    val.biweekly? this.setError('biweekly') : this.resetError('biweekly');
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
                vm.loading = true;

                await axios.get(vm.url.ajax_follow_ups_search, {
                        params: {
                            budget_year: vm.budget_year,
                            biweekly: vm.biweekly,
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
                    this.biweekly = '';
                    this.month = '';
                    this.times = '';
                }
                this.biWeeklyLists = this.pBiweekly.filter(item => {
                    return item.thai_year.indexOf(this.budget_year) > -1;
                });
            },
        }
    }
</script>