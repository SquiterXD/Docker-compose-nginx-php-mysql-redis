<template>
    <div>
        <div class="ibox float-e-margins mb-2" >
            <div class="row col-12 mb-2">
                <div class="form-group pl-2 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 mt-2">
                    <h3> ประมาณการกำลังผลิตประจำปักษ์ </h3>
                </div>
                <div class="form-group pl-2 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 mt-2 text-right">
                    <button class="btn btn-white btn-lg" @click.prevent="submit">
                        <i class="fa fa-search"></i> ค้นหา
                    </button>
                    <a :href="url.submit_p03" class="btn btn-white btn-lg">ล้าง</a>
                </div>
            </div>
            <div class="card border-primary mb-3 mt-3">
                <div class="card-body" >
                    <div class="row">
                        <div class="col-8 b-r">
                            <form id="machine-form" :action="url.submit_p03">
                                <div class="row">
                                    <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-6 col-xs-6 mt-2">
                                        <label class=" tw-font-bold tw-uppercase mb-1"> ปีงบประมาณ </label>
                                        <div class="input-group ">
                                            <input type="hidden" name="search[budget_year]" :value="budget_year">
                                            <el-select  v-model="budget_year" size="medium" placeholder="ปีงบประมาณ" filterable @change="getMonth" ref="budget_year">
                                                <el-option
                                                   v-for="(year, index) in budgetYears"
                                                    :key="index"
                                                    :label="year.thai_year"
                                                    :value="year.thai_year"
                                                >
                                                </el-option>
                                            </el-select>
                                        </div>
                                        <div id="el_explode_budget_year" class="error_msg text-left"></div>
                                    </div>

                                    <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                        <label class=" tw-font-bold tw-uppercase mb-1" > เดือน </label>
                                        <div class="">
                                            <input type="hidden" name="search[month]" :value="month">
                                            <el-select v-if="!budget_year" v-model="month" size="medium" placeholder="เดือน" ref="month" disabled>
                                                <el-option
                                                   v-for="(month, index) in monthLists"
                                                    :key="index"
                                                    :label="month.thai_month"
                                                    :value="month.period_num"
                                                >
                                                </el-option>
                                            </el-select>
                                            <el-select v-else v-model="month" size="medium" placeholder="เดือน" filterable @change="getBiWeeklySeq" v-loading="m_loading" ref="month">
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

                                    <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2">
                                        <label class=" tw-font-bold tw-uppercase mb-1" > ปักษ์ </label>
                                        <div class="">
                                            <input type="hidden" name="search[bi_weekly]" :value="bi_weekly">
                                            <el-select v-if="!month" v-model="bi_weekly" clearable size="medium" placeholder="ปักษ์" ref="bi_weekly" disabled>
                                               <el-option
                                                   v-for="(biweekly, index) in biWeeklyLists"
                                                    :key="index"
                                                    :label="biweekly.biweekly"
                                                    :value="biweekly.biweekly"
                                                >
                                                </el-option>
                                            </el-select>
                                            <el-select v-else v-model="bi_weekly" clearable size="medium" placeholder="ปักษ์" filterable @change="getBiWeeklyDetail" v-loading="b_loading" ref="bi_weekly">
                                               <el-option
                                                   v-for="(biweekly, index) in biWeeklyLists"
                                                    :key="index"
                                                    :label="biweekly.biweekly"
                                                    :value="biweekly.biweekly"
                                                >
                                                </el-option>
                                            </el-select>
                                        </div>
                                        <div id="el_explode_bi_weekly" class="error_msg text-left"></div>
                                    </div>

                                    <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                        <label class=" tw-font-bold tw-uppercase mb-1" > ประจำวันที่ </label>
                                        <div v-if="bi_weekly_detail" style="font-size: 14px;" class="p-1">
                                            {{ bi_weekly_detail }}
                                            <!-- <date-range-detail :date-range-detail="bi_weekly_detail"> </date-range-detail> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group pl-2 pr-2 mb-0 col-lg-10 col-md-10 col-sm-6 col-xs-6 mt-2">
                                        <label class=" tw-font-bold tw-uppercase mb-1" > ประมาณกำลังการผลิต </label>
                                        <div>
                                            <input type="hidden" name="search[product_type]" :value="product_type">
                                            <el-radio-group v-model="product_type" size="small" @change="changeProductType()">
                                                <template v-for="(product, index) in productTypes">
                                                    <el-radio :label="product.lookup_code" class="mr-1 mb-1" border>
                                                        {{ product.meaning }}
                                                    </el-radio>
                                                </template>
                                            </el-radio-group>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
                                                <div v-if="header && show_flag">
                                                    {{ header.created_at_format }}
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
                                                <div v-if="header && show_flag">
                                                    {{ header.updated_at_format? header.updated_at_format :header.created_at_format }}
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
                                                <div v-if="header && show_flag">
                                                    {{ creator }}
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

            <template v-if="search">
                <div class="row">
                    <div class="col-lg-12 mt-3">
                        <lines-machine-biweekly-component
                            :p-lines="lines"
                            :p-res-plan-date="resPlanDate"
                            :p-efficiency-machine-percent="efficiencyMachine"
                            :p-efficiency-product-percent="efficiencyProduct"
                            :p-working-hour="workingHour"
                            :p-working-holiday="workingHoliday"
                            :search="search"

                            :p-eamperformance-machines="eamperformanceMachines"
                            :p-efficiency-machines="efficiencyMachines"
                            :p-efficiency-products="efficiencyProducts"
                            :p-machine-maintenances="machineMaintenances"
                            :p-machine-downtimes="machineDowntimes"
                            :p-holidays="holidays"
                            :p-header="header"
                            :p-machine-groups="machineGroups"
                            :p-machine-desc="machineDesc"
                            :p-machine-dt-lines="machineDtLines"
                            :p-sale-forecasts="pSaleForecasts"
                            :p-sale-forecasts-html="saleForecastsHtml"

                            :p-edit-flag="edit_flag"
                            :p-show-flag="show_flag"
                            :p-date-format="dateFormat"
                            :btn-trans="btnTrans"
                            :url="url"
                            @updateEditFlag="updateEditFlag"

                            :p-efficiency-full-products="efficiencyFullProducts"
                            :version-lists="versionLists"
                            :holidaysHtml="holidaysHtml"
                            :lastUpdate="lastUpdate"
                        />
                            <!-- <div> -->
                            <!-- @include('planning.machine-biweekly._line')
                            @include('planning.machine-biweekly._om_sales_modal') -->
                            <!-- </div> -->
                        <!-- </lines-machine-biweekly-component> -->
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>

<script>
    import DateRangeDetail from '../Commons/Machine/DateRangeDetail.vue';
    export default {
        components: {
            DateRangeDetail
        },
        props:['header', 'lines', 'resPlanDate', 'productTypes', 'budgetYears', 'defaultInput', 'searchInput', 'search', 'biWeeklyDetails'
            , 'workingHour', 'workingHoliday', 'eamperformanceMachines', 'efficiencyMachines', 'efficiencyProducts', 'machineMaintenances', 'machineDowntimes', 'machineDtLines', 'machineGroups', 'machineDesc', 'holidays', 'saleForecastsHtml', 'efficiencyFullProducts'
            ,'btnTrans', 'dateFormat', 'url', 'pSaleForecasts', 'versionLists', 'holidaysHtml', 'lastUpdate'],
        data() {
            return {
                budget_year: this.search? String(this.search['budget_year']): this.defaultInput.current_year,
                month: this.search? String(this.search['month']): '',
                bi_weekly: this.search? String(this.search['bi_weekly']): '',
                efficiency_machine: this.header? this.header.efficiency_machine: '',
                efficiency_product: this.header? this.header.efficiency_product: this.defaultInput.efficiency_product,
                product_type: ((this.header != undefined && this.header != '')? this.header.product_type: this.search)? this.search['product_type']: this.defaultInput.product_type,
                month_lists: [],
                bi_weekly_lists: [],
                loading: false,
                valid: false,
                m_loading: false,
                b_loading: false,
                errors: {
                    budget_year: false,
                    month: false,
                    bi_weekly: false
                },
                // Support Issue with IT
                edit_flag: false,
                show_flag: true,
                set_budget_year: this.search? String(this.search['budget_year']): this.defaultInput.current_year,
                set_month: this.search? String(this.search['month']): '',
                set_bi_weekly: this.search? String(this.search['bi_weekly']): '',
                set_product_type: ((this.header != undefined && this.header != '')? this.header.product_type: this.search)? this.search['product_type']: this.defaultInput.product_type,
                bi_weekly_detail: '',
                valid_action: false,
                creator: this.header && this.header.updated_by? this.header.updated_by.name: (this.header && this.header.created_by? this.header.created_by.name: null),
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
            },
            efficiencyMachine: function () {
                return this.efficiency_machine;
            },
            efficiencyProduct: function () {
                return this.efficiency_product;
            },
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
                this.checkSearchCondition();
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
                this.checkSearchCondition();
            },
            getBiWeeklyDetail(){
                var vm = this;
                if (vm.biWeekly == '' || vm.biWeekly == null) {vm.biWeeklyDetail = '';}
                vm.biWeeklyDetails.filter(item => {
                    if (item.thai_year == vm.budget_year &&  item.period_num == vm.month &&  item.biweekly == vm.bi_weekly) {
                        return vm.bi_weekly_detail = item.thai_combine_date;
                    }
                });
                this.checkSearchCondition();
            },
            changeProductType(){
                this.checkSearchCondition();
            },
            async submit(){
                var form  = $('#machine-form');
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
            checkSearchCondition(){
                // Check show data when change search
                var vm = this;
                if(vm.valid_action){
                    swal({
                        title: 'บันทึกหรือยกเลิกการเปลี่ยนแปลงข้อมูล',
                        text: '<span style="font-size: 16px; text-align: left;"> กรุณาทำการบันทึกหรือยกเลิกการเปลี่ยนแปลงให้เรียบร้อย </span>',
                        type: "warning",
                        html: true
                    })
                    vm.budget_year = vm.set_budget_year;
                    vm.month = vm.set_month;
                    vm.bi_weekly = vm.set_bi_weekly;
                    vm.product_type = vm.set_product_type;
                    return;
                }
                vm.edit_flag = '';
                vm.show_flag = true;
                if (vm.set_budget_year != vm.budget_year || vm.set_month != vm.month || vm.set_bi_weekly != vm.bi_weekly) {
                    vm.edit_flag = false;
                    vm.show_flag = false;
                }else if(vm.set_budget_year == vm.budget_year && vm.month == '' && vm.bi_weekly == ''){
                    vm.edit_flag = false;
                    vm.show_flag = false;
                }else if(vm.set_budget_year == vm.budget_year && vm.set_month == vm.month && (vm.bi_weekly == '' || vm.set_bi_weekly != vm.bi_weekly)){
                    vm.edit_flag = false;
                    vm.show_flag = false;
                }else if(vm.set_budget_year == vm.budget_year && vm.set_month == vm.month && vm.set_bi_weekly == vm.bi_weekly && vm.set_product_type != vm.product_type) {
                    vm.edit_flag = false;
                    vm.show_flag = false;
                }
            },
            updateEditFlag(res){
                this.valid_action = res;
            }
        }
    }
</script>