<template>
    <div class="" v-loading="loading.approveProcess? loading.approveProcess: loading.searchProcess">

        <div class="ibox float-e-margins mb-2" >
            <div class="col-12 text-right mt-1">
               <!--  <modal-search
                    :btn-trans="btnTrans"
                    :url="urlArr"
                    :budgetYears="modalSearchInput.budget_years"
                    :months="modalSearchInput.months"
                    :biWeekly="modalSearchInput.bi_weekly"
                    :default-input="pDefaultInput"
                    :search="[]" /> -->
                <button type="button" :class="btnTrans.search.class + ' btn-lg tw-w-25'" @click.prevent="submit()">
                    <i :class="btnTrans.search.icon"></i>
                    {{ btnTrans.search.text }}
                </button>
                <a :href="url.production_daily_reset" class="btn btn-white btn-lg">ล้าง</a>
                <template v-if="productDailyPlan != null">
                    <button v-if="canApprove && !isControlDisable" type="button" :class="btnTrans.approve.class + ' btn-lg tw-w-25'" @click.prevent="checkApprove()">
                        <i :class="btnTrans.approve.icon"></i>
                        {{ btnTrans.approve.text }}
                    </button>
                    <button v-if="!canApprove && !isControlDisable" type="button" :class="btnTrans.unapprove.class + ' btn-lg tw-w-25'" @click.prevent="checkUnapprove()">
                        <i :class="btnTrans.unapprove.icon"></i>
                        {{ btnTrans.unapprove.text }}
                    </button>
                </template>
            </div>
        </div>

        <div class="card border-primary mb-3 mt-3">
            <div class="card-body">
               <!--  <header-detail :machine-biweekly="machineBiweekly" :product-daily-plan="dailyPlan" :product-biweekly-main="productBiweeklyMain"/> -->
               <div class="row">
                    <div class="col-8 b-r">
                        <!-- <div class="row">
                            <div class="col-lg-6"> -->
                                <form id="search-form" :action="url.ajax_production_daily_search">
                                    <div class="row">
                                        <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-6 col-xs-6 mt-2">
                                            <label class="text-left tw-font-bold tw-uppercase mb-1"> ปีงบประมาณ </label>
                                            <div class="input-group ">
                                                <input type="hidden" name="search[budget_year]" :value="budgetYear">
                                                <el-select v-model="budgetYear" size="medium" placeholder="ปีงบประมาณ" @change="getMonth" clearable filterable ref="budget_year">
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
                                        <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-6 col-xs-6 mt-2">
                                            <input type="hidden" name="search[month]" :value="month">
                                            <label class=" tw-font-bold tw-uppercase mb-1" > เดือน </label>
                                            <div class="">
                                                <el-select v-if="!budgetYear" v-model="month" clearable size="medium" placeholder="เดือน" ref="month" disabled>
                                                    <el-option
                                                       v-for="(month, index) in monthLists"
                                                        :key="index"
                                                        :label="month.thai_month"
                                                        :value="month.period_num"
                                                    >
                                                    </el-option>
                                                </el-select>

                                                <el-select v-else v-model="month" clearable size="medium" placeholder="เดือน" filterable @change="getBiWeekly" ref="month">
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
                                        <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-6 col-xs-6 mt-2">
                                            <label class="text-left tw-font-bold tw-uppercase mb-1"> ปักษ์ที่ </label>
                                            <div class="">
                                                <input type="hidden" name="search[bi_weekly]" :value="biWeekly">
                                                <el-select v-if="!month" v-model="biWeekly" clearable size="medium" placeholder="ปักษ์" ref="bi_weekly" disabled>
                                                   <el-option
                                                       v-for="(biweekly, index) in biWeeklyLists"
                                                        :key="index"
                                                        :label="biweekly.biweekly"
                                                        :value="biweekly.biweekly"
                                                    >
                                                    </el-option>
                                                </el-select>

                                                <el-select v-else v-model="biWeekly" clearable size="medium" placeholder="ปักษ์" filterable ref="bi_weekly" @change="getBiWeeklyDetail()">
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
                                        <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-4 col-sm-6 col-xs-6 mt-2">
                                            <label class=" tw-font-bold tw-uppercase mb-1" > ประจำวันที่ </label>
                                            <div style="font-size: 14px;" class="p-1">
                                                {{ biWeeklyDetail }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group pl-2 pr-2 mb-0 col-lg-10 col-md-10 col-sm-6 col-xs-6 mt-2">
                                            <label class=" tw-font-bold tw-uppercase mb-1" > ประมาณกำลังการผลิต </label>
                                            <div>
                                                <input type="hidden" name="search[product_type]" :value="productType">
                                                <el-radio-group v-model="productType" size="small" @change="changeProductType()"> 
                                                    <template v-for="(product, index) in productTypes">
                                                        <el-radio :label="product.lookup_code" class="mr-1 mb-1" border>
                                                            {{ product.meaning }}
                                                        </el-radio>
                                                    </template>
                                                </el-radio-group>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div v-html="html"></div> -->
                                </form>
                                <!-- <div class="row">
                                    <div class="col-8 b-r">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <dl class="row mb-0">
                                                    <div class="col-sm-2 pl-0 text-sm-right">
                                                        <dt>ประมาณการผลิต:</dt>
                                                    </div>
                                                    <div class="col-sm-8 text-sm-left">
                                                        <div>
                                                            <el-radio-group v-model="productType" size="small" @change="getProductPlanDaily">
                                                                <template v-if="product.lookup_code != 'KK'" v-for="(product, index) in productTypes">
                                                                <el-radio :label="product.lookup_code"
                                                                    class="mr-1 mb-1" border>
                                                                    {{ product.meaning }}
                                                                </el-radio>
                                                                </template>
                                                            </el-radio-group>
                                                        </div>
                                                    </div>
                                                </dl>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                           <!--  </div>
                        </div> -->
                    </div>

                    <div class="col-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <dl class="row mb-1">
                                    <div class="col-sm-6 text-sm-right">
                                        <dt>วันที่สร้าง:</dt>
                                    </div>
                                    <div class="col-sm-6 text-sm-left">
                                        <dd class="mb-1">
                                            <div v-if="dailyPlan && showFlag">
                                                {{ dailyPlan.creation_date_format }}
                                            </div>
                                        </dd>
                                    </div>
                                </dl>
                                <dl class="row mb-1">
                                    <div class="col-sm-6 text-sm-right">
                                        <dt title="">วันที่แก้ไขล่าสุด:</dt>
                                    </div>
                                    <div class="col-sm-6 text-sm-left">
                                        <dd class="mb-1">
                                            <div v-if="dailyPlan && showFlag">
                                                {{ dailyPlan.plan_daily_t_last? dailyPlan.plan_daily_t_last.updated_at_format :dailyPlan.updated_at_format }}
                                            </div>
                                        </dd>
                                    </div>
                                </dl>
                                <dl class="row mb-1">
                                    <div class="col-sm-6 text-sm-right">
                                        <dt>สถานะ:</dt>
                                    </div>
                                    <div class="col-sm-6 text-sm-left">
                                        <dd class="mb-1">
                                            <div v-if="dailyPlan && showFlag">
                                                <span v-html="dailyPlan.status_lable_html"></span>
                                            </div>
                                        </dd>
                                    </div>
                                </dl>
                                <dl class="row mb-1">
                                    <div class="col-sm-6 text-sm-right">
                                        <dt>ผู้บันทึก:</dt>
                                    </div>
                                    <div class="col-sm-6 text-sm-left">
                                        <dd class="mb-1">
                                            <div v-if="productDailyPlan && showFlag">
                                                {{ creator }}
                                            </div>
                                        </dd>
                                    </div>
                                </dl>
                                <dl class="row mb-1">
                                    <div class="col-sm-6 text-sm-right">
                                        <dt>จำนวนครั้งที่อนุมัติ:</dt>
                                    </div>
                                    <div class="col-sm-6 text-sm-left">
                                        <dd class="mb-1">
                                            <div v-if="dailyPlan && showFlag">
                                                <span v-html="dailyPlan.approved_no? dailyPlan.approved_no: '-'"></span>
                                            </div>
                                        </dd>
                                    </div>
                                </dl>
                                <dl class="row mb-1">
                                    <div class="col-sm-6 text-sm-right">
                                        <dt>วันที่อนุมัติล่าสุด:</dt>
                                    </div>
                                    <div class="col-sm-6 text-sm-left">
                                        <dd class="mb-1">
                                            <div v-if="dailyPlan && showFlag">
                                                {{ dailyPlan.approved_at_format ? dailyPlan.approved_at_format: null }}
                                            </div>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <template v-if="!dailyPlan && searchFlag">
            <div class="col-12 text-center">
                <h2> ไม่พบข้อมูลที่ค้นหาในระบบ </h2>
            </div>
        </template >
        <!-- OM Sales Table 1-->
        <OMSalesForecast v-if="showFlag && dailyPlan"
            :daily-plan="dailyPlan"
            :machine-biweekly="machineBiweekly"
            :biweeklyColorCode="biweeklyColorCode"
            :product-types="productTypes"
            :product-type="productType"
            :versions="versions"
            :defaultInput="pDefaultInput"
            :btnTrans="btnTrans"
            :url="urlArr"
            :refreshOMSalesForecast="refreshOMSalesForecast"
            :canViewProduction="canViewProduction"
            @omSalesForecast="omSalesForecastData"
        />
        <template v-if="showFlag && omSalesForecasts.length > 0 && dailyPlan">
            <!-- Daily plan Table 2 -->
            <hr>
            <PlanDaily
                :machine-biweekly="machineBiweekly"
                :product-daily-plan="dailyPlan"
                :modal-control-input="modalControlInput"
                :item-production-main="itemProductionMain"
                :budget-years="modalControlInput.budget_years"
                :months="modalControlInput.months"
                :bi-weekly="modalControlInput.bi_weekly"
                :product-type="productType"
                :date-format="pDateFormat"
                :btn-trans="btnTrans"
                :url="urlArr"
                :search="search"
                :is-control-disable="isControlDisable"
                :messageCheckWKHHtml="messageCheckWKHHtml"
                :messageCheckMachineHtml="messageCheckMachineHtml"
                :isCurrBiweekly="isCurrBiweekly"
                @updateControlDisable="updateControlDisable"
                @fetchDataP07="fetchDataP07"
            />
            <hr>
            <!-- Item Plan Table 3 -->
            <ItemPlan v-if="showFlag && dailyPlan"
                :product-daily-plan="dailyPlan"
                :item-cigars="modalControlInput.itemCigarette"
                :item-production-main="itemProductionMain"
                :product-type="productType"
                :date-format="pDateFormat"
                :btn-trans="btnTrans"
                :url="urlArr"
            />
        </template>
    </div>
</template>

<script>
    import ModalSearch      from './ModalSearch.vue';
    import HeaderDetail     from './components/HeaderDetail.vue';
    import OMSalesForecast  from './components/OMSalesForecast.vue';
    import PlanDaily        from './components/PlanDaily.vue';
    import ItemPlan        from './components/ItemPlan.vue';
    import moment from "moment";

    export default {
        components: {
            ModalSearch, HeaderDetail, OMSalesForecast, PlanDaily, ItemPlan
        },
        props:[
            "machineBiweekly", "modalControlInput", "modalSearchInput", "biweeklyColorCode", "productTypes", "pDefaultInput", "machines", "productDailyPlan", "pDateFormat", "url", "btnTrans", "search", "biWeeklyDetails", "searchFlag", "versions"
        ],
        data() {
            return {
                loading: {
                    approveProcess: false,
                    searchProcess: false
                },
                defaultInput: (this.pDefaultInput != undefined && this.pDefaultInput != '') ? this.pDefaultInput : null,
                canApprove: false,
                dailyPlan: this.productDailyPlan,
                omSalesForecasts: '',
                itemProductionMain: [],
                urlArr: this.url,
                // Search
                budgetYears: this.modalSearchInput.budget_years,
                months: this.modalSearchInput.months,
                biWeeklies: this.modalSearchInput.bi_weekly,
                // Search input
                budgetYear: Object.values(this.search).length != 0? this.search.budget_year: this.pDefaultInput.current_year,
                month: this.search? String(this.search.month): '',
                biWeekly: this.search? String(this.search.biweekly): '',
                productType: Object.values(this.search).length != 0? this.search.product_type: this.pDefaultInput.product_type,
                errors: {
                    budget_year: false,
                    month: false,
                    bi_weekly: false
                },
                monthLists: [],
                biWeeklyLists: [],
                biWeeklyDetail: '',
                showFlag: true,
                setBudgetYear:  Object.values(this.search).length != 0? this.search.budget_year: this.pDefaultInput.current_year,
                setMonth: this.search? String(this.search.month): '',
                setBiWeekly: this.search? String(this.search.biweekly): '',
                setProductType: Object.values(this.search).length != 0? this.search.product_type: this.pDefaultInput.product_type,
                creator: this.productDailyPlan && this.productDailyPlan.updated_by? this.productDailyPlan.updated_by.name: (this.productDailyPlan && this.productDailyPlan.created_by? this.productDailyPlan.created_by.name: null),
                isControlDisable: false,
                isCurrBiweekly: false,
                // New Requirement : แจ้งเตือน to text
                messageCheckWKHHtml: '',
                messageCheckMachineHtml: '',
                refreshOMSalesForecast: false,
                canViewProduction: false,
            }
        },
        mounted() {
            if (this.dailyPlan != undefined && this.dailyPlan != '') {
                this.canApprove = this.dailyPlan.can.approve;
            }
            if (this.budgetYear) {
                this.getMonth();
            }
            if (this.month) {
                this.getBiWeekly();
            }
            this.getBiWeeklyDetail();
            this.getControlDisable();
        },
        watch: {
            errors: {
                handler(val){
                    val.budget_year? this.setError('budget_year') : this.resetError('budget_year');
                    val.month? this.setError('month') : this.resetError('month');
                    val.bi_weekly? this.setError('bi_weekly') : this.resetError('bi_weekly');
                },
                deep: true,
            },
            productType: async function (value, oldValue) {
                this.omSalesForecasts = '';
            },
        },
        methods: {
            async checkApprove() {
                let vm = this;
                if (!vm.canApprove) { return }
                vm.loading.approveProcess = true;
                await axios
                .get(vm.urlArr.ajax_check_approve)
                .then(res => {
                    var valid = true;
                    if (res.data.data.status == 'S') {
                        swal({
                            html: true,
                            title: 'อนุมัติประมาณการผลิตรายวัน',
                            text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการอนุมัติประมาณการผลิตรายวัน ? </span></h2>',
                            showCancelButton: true,
                            confirmButtonText: vm.btnTrans.ok.text,
                            cancelButtonText: vm.btnTrans.cancel.text,
                            confirmButtonClass: vm.btnTrans.ok.class + ' btn-lg tw-w-25',
                            cancelButtonClass: vm.btnTrans.cancel.class + ' btn-lg tw-w-25',
                            closeOnConfirm: false,
                            closeOnCancel: true,
                            showLoaderOnConfirm: true
                        },
                        async function(isConfirm){
                            if (isConfirm) {
                                vm.approve();
                            }
                        });
                    } else {
                        valid = false;
                        swal({
                            title: 'มีข้อผิดพลาด',
                            text: '<span style="font-size: 16px; text-align: left;">'+res.data.data.msg+'</span>',
                            type: "warning",
                            html: true
                        });
                        if (!valid) {
                            return;
                        }
                    }
                })
                .catch(err => {
                    let data = err.response.data;
                    alert(data.message);
                })
                .then(() => {
                    vm.loading.approveProcess = false;
                });
            },
            async approve() {
                let vm = this;
                await axios
                .patch(vm.urlArr.ajax_approve)
                .then(res => {
                    var valid = true;
                    if (res.data.data.status == 'S') {
                        vm.dailyPlan = res.data.data.dailyPlan;
                        vm.canApprove = vm.dailyPlan.can.approve;
                        swal({
                            title: 'อนุมัติประมาณการผลิตรายวัน',
                            text: '<span style="font-size: 16px; text-align: left;"> อนุมัติประมาณการผลิตรายวันเรียบร้อย </span>',
                            type: "success",
                            html: true
                        });
                    }else{
                        valid = false;
                        swal({
                            title: 'มีข้อผิดพลาด',
                            text: '<span style="font-size: 16px; text-align: left;">'+res.data.data.msg+'</span>',
                            type: "warning",
                            html: true
                        });
                        if (!valid) {
                            return;
                        }
                    }
                })
                .catch(err => {
                    // console.log(err);
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">'+err+'</span>',
                        type: "warning",
                        html: true
                    });
                })
                .then(() => {
                    vm.loading.approveProcess = false;
                });
            },
            // Un-Approve
            async checkUnapprove() {
                let vm = this;
                if (vm.canApprove) { return }
                vm.loading.approveProcess = true;
                await axios
                .get(vm.urlArr.ajax_check_unapprove)
                .then(res => {
                    var valid = true;
                    if (res.data.data.status == 'S') {
                        swal({
                            html: true,
                            title: 'ยกเลิกอนุมัติประมาณการผลิตรายวัน',
                            text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการยกเลิกอนุมัติประมาณการผลิตรายวัน ? </span></h2>',
                            showCancelButton: true,
                            confirmButtonText: vm.btnTrans.ok.text,
                            cancelButtonText: vm.btnTrans.cancel.text,
                            confirmButtonClass: vm.btnTrans.ok.class + ' btn-lg tw-w-25',
                            cancelButtonClass: vm.btnTrans.cancel.class + ' btn-lg tw-w-25',
                            closeOnConfirm: false,
                            closeOnCancel: true,
                            showLoaderOnConfirm: true
                        },
                        async function(isConfirm){
                            if (isConfirm) {
                                vm.unapprove();
                            }
                        });
                    } else {
                        valid = false;
                        swal({
                            title: 'มีข้อผิดพลาด',
                            text: '<span style="font-size: 16px; text-align: left;">'+res.data.data.msg+'</span>',
                            type: "warning",
                            html: true
                        });
                        if (!valid) {
                            return;
                        }
                    }
                })
                .catch(err => {
                    let data = err.response.data;
                    alert(data.message);
                })
                .then(() => {
                    vm.loading.approveProcess = false;
                });
            },
            async unapprove() {
                let vm = this;
                await axios
                .patch(vm.urlArr.ajax_unapprove)
                .then(res => {
                    var valid = true;
                    if (res.data.data.status == 'S') {
                        swal({
                            title: 'ยกเลิกอนุมัติประมาณการผลิตรายวัน',
                            text: '<span style="font-size: 16px; text-align: left;"> ยกเลิกอนุมัติประมาณการผลิตรายวันเรียบร้อย </span>',
                            type: "success",
                            html: true
                        });
                        vm.dailyPlan = res.data.data.dailyPlan;
                        vm.canApprove = vm.dailyPlan.can.approve;
                    }else{
                        valid = false;
                        swal({
                            title: 'มีข้อผิดพลาด',
                            text: '<span style="font-size: 16px; text-align: left;">'+res.data.data.msg+'</span>',
                            type: "warning",
                            html: true
                        });
                        if (!valid) {
                            return;
                        }
                    }
                })
                .catch(err => {
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">'+err+'</span>',
                        type: "warning",
                        html: true
                    });
                })
                .then(() => {
                    vm.loading.approveProcess = false;
                });
            },
            // get plan daily
            async getProductPlanDaily() {
                let vm = this;
                let params = {
                    product_type: vm.productType,
                };
                await axios.get(vm.urlArr.production_daily_show, { params })
               .then(res => {
                    vm.dailyPlan = res.data.productDailyPlan;
                    vm.urlArr = res.data.url;
                    if (this.dailyPlan != undefined && this.dailyPlan != '') {
                        this.canApprove = this.dailyPlan.can.approve;
                    }else{
                        this.canApprove = false;
                    }
                })
                .catch(err => {
                    console.log('error')
                    let data = err.response.data;
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">'+data.message+'</span>',
                        type: "error",
                        html: true
                    });
                })
                .then(() => {
                    vm.loading.approveProcess = false;
                });
            },
            omSalesForecastData(summary, items, flag){
                this.omSalesForecasts = summary;
                this.itemProductionMain = items;
                this.refreshOMSalesForecast = flag;
            },
            async submit() {
                let vm = this;
                let form = $('#search-form');
                let valid = true;
                let errorMsg = '';
                vm.errors.budget_year = false;
                vm.errors.month = false;
                vm.errors.bi_weekly = false;
                $(form).find("div[id='el_explode_budget_year']").html("");
                $(form).find("div[id='el_explode_month']").html("");
                $(form).find("div[id='el_explode_bi_weekly']").html("");
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
                if (vm.biWeekly == ''){
                    vm.errors.bi_weekly = true;
                    valid = false;
                    errorMsg = "กรุณาเลือกปักษ์";
                    $(form).find("div[id='el_explode_bi_weekly']").html(errorMsg);
                }
                if (!valid) {
                    return;
                }
                vm.loading.searchProcess = true;
                form.submit();
            },
            getMonth(){
                if (this.search) {
                    if(this.search['budget_year'] != this.budgetYear){
                        this.month = '';
                        this.biWeekly = '';
                        this.biWeeklyDetail = '';
                    }
                }else{
                    this.month = '';
                    this.biWeekly = '';
                    this.biWeeklyDetail = '';
                }
                this.monthLists = this.months;
                this.checkSearchCondition();
                // Check show data when change search
                // this.showFlag = true;
                // if (this.setProductType != this.product_type || this.setBudgetYear != this.budgetYear) {
                //     this.showFlag = false;
                // }
            },
            getBiWeekly(){
                if (this.search) {
                    if(this.search['month'] != this.month){
                        this.biWeekly = '';
                        this.biWeeklyDetail = '';
                    }
                }else{
                    this.biWeekly = '';
                    this.biWeeklyDetail = '';
                }
                this.biWeeklyLists = this.biWeeklies.filter(item => {
                    return item.period_num == this.month;
                });
                this.checkSearchCondition();
                // Check show data when change search
                // if (this.setMonth != this.month) {
                //     this.showFlag = false;
                // }else if(this.setBudgetYear == this.budgetYear && this.setMonth == this.month && this.biWeekly != ''){
                //     this.showFlag = true;
                // }
            },
            getBiWeeklyDetail(){
                var vm = this;
                if (vm.biWeekly == '' || vm.biWeekly == null) {vm.biWeeklyDetail = '';}
                vm.biWeeklyDetails.filter(item => {
                    if (item.thai_year == vm.budgetYear &&  item.period_num == vm.month &&  item.biweekly == vm.biWeekly) {
                        return vm.biWeeklyDetail = item.thai_combine_date;
                    }
                });
                this.checkSearchCondition();
                // Check show data when change search
                // vm.showFlag = true;
                // if (vm.setBiWeekly != vm.biWeekly || (vm.setBiWeekly == vm.biWeekly && vm.setProductType != vm.productType)) {
                //     vm.showFlag = false;
                // }
            },
            changeProductType(){
                this.checkSearchCondition();
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
            checkSearchCondition(){
                // Check show data when change search
                var vm = this;
                vm.showFlag = true;
                if (vm.dailyPlan) {
                    if (vm.setBudgetYear != vm.budgetYear || vm.setMonth != vm.month || vm.setBiWeekly != vm.biWeekly) {
                        vm.showFlag = false;
                    }else if(vm.setBudgetYear == vm.budgetYear && vm.month == '' && vm.biWeekly == ''){
                        vm.showFlag = false;
                    }else if(vm.setBudgetYear == vm.budgetYear && vm.setMonth == vm.month && (vm.biWeekly == '' || vm.setBiWeekly != vm.biWeekly)){
                        vm.showFlag = false;
                    }else if(vm.setBudgetYear == vm.budgetYear && vm.setMonth == vm.month && vm.setBiWeekly == vm.biWeekly && vm.setProductType != vm.productType) {
                        vm.showFlag = false;
                    }
                }
            },
            getControlDisable() {
                var vm = this;
                let date_from = '';
                let date_to = '';
                let curr_date = moment().format('YYYY-MM-DD');
                vm.modalControlInput.bi_weekly.filter(item => {
                    if (item.biweekly == vm.biWeekly && item.period_num == vm.month) {
                        date_from = moment(item.start_date).format('YYYY-MM-DD');
                        date_to = moment(item.end_date).format('YYYY-MM-DD');
                    }
                });
                //check disable process
                // vm.isControlDisable = false;
                if(curr_date > date_from && curr_date > date_to){
                    vm.isControlDisable = true;
                }
                // check current biweekly and future biweekly
                if(curr_date >= date_from && curr_date <= date_to || curr_date <= date_from && curr_date <= date_to){
                    vm.isCurrBiweekly = true;
                }

                // check current biweekly and future biweekly
                if(curr_date >= date_from && curr_date <= date_to || curr_date > date_from && curr_date > date_to){
                    vm.canViewProduction = true;
                }
                // check data change PM/Machine
                if (!vm.isControlDisable) {
                    vm.checkMachineP03P07();
                    vm.checkWorkingHourP03P07();
                }
            },
            checkMachineP03P07() {
                var vm = this;
                if (vm.machines.length != vm.modalControlInput.machines.length) {
                    vm.messageCheckMachineHtml = '<i class="fa fa-exclamation-circle"></i> เนื่องจากเครื่องจักรประมาณกำลังการผลิตประจำปักษ์ และ เครื่องจักรประมาณการผลิตรายวันไม่เท่ากัน กรุณาทำการอัพเดตเครื่องจักรประมาณกำลังการผลิตประจำปักษ์ก่อน';
                    vm.isControlDisable = true;
                }
            },
            async checkWorkingHourP03P07() { //checkEfficientcyP03P07
                var vm = this;
                let params = {
                    product_type: vm.productType,
                    budget_year: vm.budgetYear,
                    month: vm.month,
                    bi_weekly: vm.biWeekly
                };
                await axios.get(vm.url.ajax_check_working_hour, { params })
                .then(res => {
                    if (res.data.data.status == 'E') {
                        // swal({
                        //     title: 'มีข้อผิดพลาด',
                        //     text: '<span style="font-size: 15px; text-align: left;">'+res.data.data.msg+'</span>',
                        //     type: "warning",
                        //     html: true
                        // });
                        vm.messageCheckWKHHtml = res.data.data.msg;
                        vm.isControlDisable = true;
                    }
                })
                .catch(err => {
                    let data = err.response.data;
                    alert(data.message);
                });
            },
            updateControlDisable(res){
                this.isControlDisable = res;
            },
            fetchDataP07(res){
                this.refreshOMSalesForecast = true;
            }
        }
    }
</script>