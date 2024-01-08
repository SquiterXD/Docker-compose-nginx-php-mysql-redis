<template>
    <div>
        <div class="m-t-lg m-b-lg" v-if="loading.omSalesForecastProcess">
            <div class="text-center sk-spinner sk-spinner-wave">
                <div class="sk-rect1"></div>
                <div class="sk-rect2"></div>
                <div class="sk-rect3"></div>
                <div class="sk-rect4"></div>
                <div class="sk-rect5"></div>
            </div>
        </div>
        <div v-else>
            <!-- <div class="table-responsive" v-html="html"></div> -->
            <h2> แผนการผลิต : {{ productName }} </h2>
            <form id="om-sales-form">
                <template v-if="omSalesForecasts.length">
                    <div class="row col-12" style="font-size: 15px;">
                        <div class="form-group pl-2 pr-2 mb-0 col-lg-1 col-md-4 col-sm-6 col-xs-6 mt-2">
                            <label class=" tw-font-bold tw-uppercase mb-1"> ปักษ์ : </label>
                            <span> {{ omSalesForecasts[0].biweekly_no }} </span>
                        </div>

                        <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-4 col-sm-6 col-xs-6 mt-2">
                            <label class=" tw-font-bold tw-uppercase mb-1"> ครั้งที่ : </label>
                            <span>
                                <el-select v-model="version_no" placeholder="ครั้งที่" size="small" style="width: 70%;" @change="changeVersion">
                                    <el-option
                                        v-for="(value, index) in versions"
                                        :key="index"
                                        :label="value.version"
                                        :value="value.version">
                                    </el-option>
                                </el-select>
                            </span>
                        </div>

                        <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-4 col-sm-6 col-xs-6 mt-2">
                            <label class=" tw-font-bold tw-uppercase mb-1"> จำนวนวันขาย : </label>
                            <span>
                                {{ omSalesForecasts[0].om_bi_weekly.day_for_sale? omSalesForecasts[0].om_bi_weekly.day_for_sale: 0 }} วัน
                            </span>
                        </div>

                        <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-4 col-sm-6 col-xs-6 mt-2">
                            <label class=" tw-font-bold tw-uppercase mb-1"> วันที่อนุมัติ : </label>
                            <span>
                                {{ omSalesForecasts[0].om_sales_forecast.approve_date_format? omSalesForecasts[0].om_sales_forecast.approve_date_format: '' }}
                            </span>
                        </div>
                        <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-4 col-sm-6 col-xs-6 mt-2">
                            <label class=" tw-font-bold tw-uppercase mb-1"> กำลังผลิตรวมทั้งปักษ์ : </label>
                            <span>
                                {{ totalEfficiencyP03[0].efficiency_product_per_min | number2Digit }} {{ unit }}
                            </span>
                        </div>
                    </div>
                </template>
                <div class="hr-line-dashed"></div>
                <div class="row col-12 mb-2" style="font-size: 12px; color: #000;">
                    <div class="col-md-6 pl-2">
                        <!-- <label class=" tw-font-bold tw-uppercase mb-1"> เรียกดู </label>
                        <div class="input-group">
                            <el-select v-model="type_module" placeholder="ประเภท" size="small" @change="getProductionPlan">
                                <el-option
                                    v-for="(type, index) in types"
                                    :key="index"
                                    :label="type.label"
                                    :value="type.value">
                                </el-option>
                            </el-select>
                        </div> -->
                    </div>
                    <template v-if="type_module == 'planning'">
                        <div class="col-md-2 p-1">
                            <span> &nbsp; <br> </span>
                        <div> <i class="fa fa-square-o fa-2x"></i> &nbsp; แผนประมาณการขายปกติ </div>
                        </div>
                        <div class="col-md-2 p-1">
                            <span> &nbsp; <br> </span>
                            <div> <i class="fa fa-square fa-2x" style="color: #67d0d4;"></i> &nbsp; แผนสั่งผลิตไม่ครบตามฝ่ายขาย </div>
                        </div>
                        <div class="col-md-2 p-1">
                            <span> &nbsp; <br> </span>
                            <div> <i class="fa fa-square fa-2x" style="color: #ff8800;"></i> &nbsp; แผนไม่สั่งผลิตตามฝ่ายขาย </div>
                        </div>
                    </template>
                    <template v-else>
                        <div class="col-md-2 p-1">
                            <span> &nbsp; <br> </span>
                            <div> <i class="fa fa-square-o fa-2x"></i> &nbsp; แผนการผลิตปกติ </div>
                        </div>
                        <div class="col-md-2 p-1">
                            <span> &nbsp; <br> </span>
                            <div> <i class="fa fa-square fa-2x" style="color: #ffcf00;"></i> &nbsp; ผลิตไม่ครบตามฝ่ายวางแผน </div>
                        </div>
                        <div class="col-md-2 p-1">
                            <span> &nbsp; <br> </span>
                            <div> <i class="fa fa-square fa-2x" style="color: #e20000;"></i> &nbsp; ผลิตไม่ตรงแผน (Back Order) </div>
                        </div>
                    </template>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" style="vertical-align: middle; width: 2%;">
                                   <div> ลำดับ </div> 
                                </th>
                                <th class="text-center" style="vertical-align: middle; width: 6%;">
                                   <div> รหัสบุหรี่ </div>
                                </th>
                                <th class="text-center" style="vertical-align: middle; width: 14%;">
                                   <div> ตราบุหรี่ </div>
                                </th>
                                <th class="text-center" style="vertical-align: middle; width: 8%;">
                                   <div> ประมาณการ<br>แผนขาย<br>(พันมวน) </div>
                                </th>
                                <th class="text-center" style="vertical-align: middle; width: 8%;">
                                   <div> ประมาณการ<br>แผนขาย<br>({{ unit }}) </div>
                                </th>
                                <th class="text-center" style="vertical-align: middle; width: 8%;">
                                   <div> สั่งผลิตในปักษ์<br>({{ unit }}) </div>
                                </th>
                                <th class="text-center" style="vertical-align: middle; width: 9%;">
                                   <div> เหลือประมาณการ<br>แผนขาย<br>({{ unit }}) </div>
                                </th>
                                <th class="text-center" style="vertical-align: middle; width: 8%;">
                                   <div> คงคลัง<br>ณ วันที่สร้าง<br>({{ unit }}) </div>
                                </th>
                                <template v-if="type_module == 'planning'">
                                    <th class="text-center" style="vertical-align: middle; width: 8%;">
                                       <div> ค่าเฉลี่ยขาย<br>10 วัน<br>({{ unit }}) </div>
                                    </th>
                                    <th class="text-center" style="vertical-align: middle; width: 8%;">
                                       <div> จำนวนวันพอใช้<br>({{ unit }}) </div>
                                    </th>
                                </template>
                                <template v-if="canViewProduction && type_module == 'production'">
                                    <th class="text-center" style="vertical-align: middle; width: 7%; border: 2px solid #000;">
                                       <div> สั่งผลิต<br>ย้อนหลัง 1 ปักษ์<br>({{ unit }}) </div>
                                    </th>
                                    <th class="text-center" style="vertical-align: middle; width: 7%; border: 2px solid #000;">
                                       <div> ผลผลิต<br>ย้อนหลัง 1 ปักษ์<br>({{ unit }}) </div>
                                    </th>
                                    <th class="text-center" style="vertical-align: middle; width: 7%; border: 2px solid #000;">
                                       <div> ผลผลิต<br>Back Order<br>({{ unit }}) </div>
                                    </th>
                                </template>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(saleForecast, index) in omSalesForecasts">
                                <!-- Planning -->
                                    <!-- alertSaleForcasts[saleForecast.item_code] > 0 && !totalQuantity[saleForecast.item_code] = ไม่สั่งผลิตตามฝ่ายขาย -->
                                    <!-- alertSaleForcasts[saleForecast.item_code] > 0  = สั่งผลิตไม่ครบ? -->
                                <template v-if="omSalesForecasts.length && type_module == 'planning'">
                                    <tr :style="alertSaleForcasts[saleForecast.item_code] > 0 && !totalQuantity[saleForecast.item_code]? 'font-weight: bold; background-color: #ff8800; color: #FFF;': (alertSaleForcasts[saleForecast.item_code] > 0? 'font-weight: bold; background-color: #67d0d4; color: #FFF;': '')">
                                        <td class="text-center">
                                            <div> {{ index+1 }} </div>
                                        </td>
                                        <td class="text-left">
                                            <div> {{ saleForecast.item_code }} </div>
                                        </td>
                                        <td class="text-left">
                                            <div> {{ saleForecast.item_description }} </div>
                                        </td>
                                        <td class="text-right">
                                            <div> {{ saleForecast.forecast_qty | number3Digit }} </div>
                                        </td>
                                        <td class="text-right">
                                            <div> {{ saleForecast.forecast_million_qty | number3Digit }} </div>
                                        </td>
                                        <td class="text-right">
                                            <div> {{ totalQuantity[saleForecast.item_code]? totalQuantity[saleForecast.item_code][0]: 0 | number2Digit }} </div>
                                        </td>
                                        <td class="text-right">
                                            <div> {{  totalQuantity[saleForecast.item_code]? saleForecast.forecast_million_qty - totalQuantity[saleForecast.item_code][0]: saleForecast.forecast_million_qty - 0 | number2Digit }} </div>
                                        </td>
                                        <td class="text-right">
                                            <div> {{ currOnhand[saleForecast.item_code]? currOnhand[saleForecast.item_code]: 0 | number2Digit }} </div>
                                        </td>
                                        <td class="text-right">
                                            <div> {{  omSales[saleForecast.item_code]? omSales[saleForecast.item_code]: 0 | number2Digit }} </div>
                                        </td>
                                        <td class="text-right">
                                            <div> {{  omSales[saleForecast.item_code] != 0? currOnhand[saleForecast.item_code]/omSales[saleForecast.item_code]: 0 | number2Digit }} </div>
                                        </td>
                                    </tr>
                                </template>
                                <!-- Production -->
                                    <!-- pmProducts[saleForecast.item_code] > 0 = ผลิตไม่ครบ -->
                                    <!-- pmProducts[saleForecast.item_code] < 0 = Back Order -->
                                <template v-else>
                                    <tr :style="canViewProduction && Number(pmProducts[saleForecast.item_code]) > 0 && prevTotalQuantity[saleForecast.item_code] && pmProducts[saleForecast.item_code]-prevTotalQuantity[saleForecast.item_code] < 0
                                        ? 'font-weight: bold; background-color: #ffcf00; color: #FFF;'
                                        : (canViewProduction && Number(pmProducts[saleForecast.item_code]) <= 0 && prevTotalQuantity[saleForecast.item_code]
                                        ? 'font-weight: bold; background-color: #e20000; color: #FFF;'
                                        : '')">
                                        <td class="text-center">
                                            <div> {{ index+1 }} </div>
                                        </td>
                                        <td class="text-left">
                                            <div> {{ saleForecast.item_code }} </div>
                                        </td>
                                        <td class="text-left">
                                            <div> {{ saleForecast.item_description }} </div>
                                        </td>
                                        <td class="text-right">
                                            <div> {{ saleForecast.forecast_qty | number3Digit }} </div>
                                        </td>
                                        <td class="text-right">
                                            <div> {{ saleForecast.forecast_million_qty | number3Digit }} </div>
                                        </td>
                                        <td class="text-right">
                                            <div> {{ totalQuantity[saleForecast.item_code]? totalQuantity[saleForecast.item_code][0]: 0 | number2Digit }} </div>
                                        </td>
                                        <td class="text-right">
                                            <div> {{  totalQuantity[saleForecast.item_code]? saleForecast.forecast_million_qty - totalQuantity[saleForecast.item_code][0]: saleForecast.forecast_million_qty - 0 | number2Digit }} </div>
                                        </td>
                                        <td class="text-right">
                                            <div> {{ currOnhand[saleForecast.item_code]? currOnhand[saleForecast.item_code]: 0 | number2Digit }} </div>
                                        </td>
                                        <template v-if="canViewProduction">
                                            <td class="text-right" style="border: 2px solid #000;">
                                                <div> {{  prevTotalQuantity[saleForecast.item_code]? prevTotalQuantity[saleForecast.item_code]: 0 | number2Digit }} </div>
                                            </td>
                                            <td class="text-right" style="border: 2px solid #000;">
                                                <div> {{  pmProducts[saleForecast.item_code]? pmProducts[saleForecast.item_code]: 0 | number2Digit }} </div>
                                            </td>
                                            <td class="text-right" style="border: 2px solid #000;">
                                                <div> {{  Number(pmProducts[saleForecast.item_code]) - prevTotalQuantity[saleForecast.item_code] | number2Digit }} </div>
                                            </td>
                                        </template>
                                    </tr>
                                </template>
                            </template>
                            <tr>
                                <th colspan="3" class="text-right">รวมประมาณการจำหน่าย</th>
                                <th style="background-color: #34d399;" class="text-right text-white">
                                    {{ forecast_qty | number3Digit }}
                                </th>
                                <th style="background-color: #34d399;" class="text-right text-white">
                                    {{ forecast_million_qty | number3Digit }}
                                </th>
                                <th style="background-color: #34d399;" class="text-right text-white">
                                    {{ daily_qty | number2Digit }}
                                </th>
                                <th style="background-color: #34d399;" class="text-right text-white">
                                    {{ balance_sale_forecast | number2Digit }}
                                </th>
                                <th style="background-color: #34d399;" class="text-right text-white">
                                    {{ curr_onhnad_qty | number2Digit }}
                                </th>
                                <template v-if="type_module == 'planning'">
                                    <th style="background-color: #34d399;" class="text-right text-white">
                                        {{ om_sale_qty | number2Digit }}
                                    </th>
                                    <th style="background-color: #34d399;" class="text-right text-white">
                                        {{ balance_days | number2Digit }}
                                    </th>
                                </template>
                                <template v-if="canViewProduction && type_module == 'production'">
                                    <th style="background-color: #34d399; border: 2px solid #000;" class="text-right text-white">
                                        {{ balance_daily | number2Digit }}
                                    </th>
                                    <th style="background-color: #34d399; border: 2px solid #000;" class="text-right text-white">
                                        {{ balance_product | number2Digit }}
                                    </th>
                                    <th style="background-color: #34d399; border: 2px solid #000;" class="text-right text-white">
                                        {{ balance_product-balance_daily | number2Digit }}
                                    </th>
                                </template>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</template>

<script>

    export default {
        props:[
            "dailyPlan", "machineBiweekly", "biweeklyColorCode", "productTypes", "productType", "versions", "defaultInput", "btnTrans", "url", "refreshOMSalesForecast", "canViewProduction"
        ],
        data() {
            return {
                loading: {
                    omSalesForecastProcess: false
                },
                version_no: this.defaultInput.last_om_version,
                omSalesForecasts: [],
                productName: '',
                itemLists: [],
                html: '',
                totalEfficiencyP03: '',
                unit: '',
                totalQuantity: [],
                currOnhand: [],
                omSales: [],
                // total
                forecast_qty: 0,
                forecast_million_qty: 0,
                daily_qty: 0,
                balance_sale_forecast: 0, // forecast_million_qty - daily_qty
                curr_onhnad_qty: 0,
                om_sale_qty: 0,
                balance_days: 0, // curr_onhnad_qty / om_sale_qty
                alertSaleForcasts: {},
                // ----------------------------------------------------------
                pmProducts: [],
                prevTotalQuantity: [],
                balance_product: 0, // pm_product
                balance_daily: 0, // prev_daily_qty
                types:  [{
                    value: 'planning',
                    label: 'แผนสั่งผลิตเทียบกับแผนขาย'
                }, {
                    value: 'production',
                    label: 'แผนสั่งผลิตเทียบกับผลผลิต'
                }],
                type_module: 'planning',
            }
        },
        mounted() {
            if (this.machineBiweekly) { this.getProductionPlan(); }
            this.getProductName();
            this.getUnitProductType();
        },
        computed: {
            totalForecastQty(){
                var vm = this;
                var total_forecast_qty = 0;
                var total_forecast_million_qty = 0;
                if (vm.omSalesForecasts) {
                    vm.omSalesForecasts.filter(function(line) {
                        total_forecast_qty += Number(line.forecast_qty);
                        total_forecast_million_qty += Number(line.forecast_million_qty);
                    });
                }
                vm.forecast_qty = total_forecast_qty;
                vm.forecast_million_qty = total_forecast_million_qty;
            },
            totalDailyQty(){
                var vm = this;
                var daily_qty = 0;
                if (vm.totalQuantity) {
                    Object.values(vm.totalQuantity).filter(function(line) {
                        daily_qty += Number(line[0]);
                    });
                }
                vm.daily_qty = daily_qty;
                vm.balance_sale_forecast = vm.forecast_million_qty - daily_qty;
            },
            totalCurrOnhandQty(){
                var vm = this;
                var currOnhand = 0;
                if (vm.currOnhand) {
                    Object.values(vm.currOnhand).filter(function(line) {
                        currOnhand += Number(line);
                    });
                }
                vm.curr_onhnad_qty = currOnhand;
            },
            totalOmSaleQty(){
                var vm = this;
                var omSale = 0;
                if (vm.omSales) {
                    Object.values(vm.omSales).filter(function(line) {
                        omSale += Number(line);
                    });
                }
                vm.om_sale_qty = omSale;
                vm.balance_days = vm.curr_onhnad_qty / omSale;
                vm.balance_days = omSale == 0? 0: vm.balance_days;
            },
            totalPrevPMProduct(){
                var vm = this;
                var product_qty = 0;
                if (vm.pmProducts) {
                    Object.values(vm.pmProducts).filter(function(line) {
                        product_qty += Number(line[0]);
                    });
                }
                vm.balance_product = product_qty;
            },
            totalPrevPlanDaily(){
                var vm = this;
                var daily_qty = 0;
                if (vm.prevTotalQuantity) {
                    Object.values(vm.prevTotalQuantity).filter(function(line) {
                        daily_qty += Number(line[0]);
                    });
                }
                vm.balance_daily = daily_qty;
            },
        },
        watch:{
            productType : async function (value, oldValue) {
                this.getProductionPlan();
                this.$emit("omSalesForecast", this.omSalesForecasts, this.itemLists, false);
                this.html = '';
            },
            totalForecastQty(newValue){
                return newValue;
            },
            totalDailyQty(newValue){
                return newValue;
            },
            totalCurrOnhandQty(newValue){
                return newValue;
            },
            totalOmSaleQty(newValue){
                return newValue;
            },
            totalPrevPMProduct(newValue){
                return newValue;
            },
            totalPrevPlanDaily(newValue){
                return newValue;
            },
            refreshOMSalesForecast : async function (newValue) {
                if (newValue === true) {
                    this.getProductionPlan();
                }
            },
        },
        methods: {
            getProductName(){
                let vm = this;
                vm.productTypes.filter(function(prod) {
                    if (vm.productType == prod.lookup_code) {
                        return vm.productName = prod.meaning;
                    }
                });
            },
            async getProductionPlan() {
                let vm = this;
                vm.getProductName();
                if (!vm.productType) {
                    return;
                }

                let params = {
                    budget_year: vm.machineBiweekly? vm.machineBiweekly.budget_year: null,
                    biweekly_id: vm.machineBiweekly? vm.machineBiweekly.biweekly_id: null,
                    product_type: vm.productType,
                    daily_id: vm.dailyPlan.daily_id,
                    version_no: vm.version_no
                };
                vm.omSalesForecasts = '';
                vm.loading.omSalesForecastProcess = true;
                await axios.get(vm.url.ajax_get_om_sales_forecast, { params })
               .then(res => {
                    var valid = true;
                    vm.html = res.data.data.html
                    vm.version_no = res.data.data.summary? res.data.data.summary[0].version: 0;
                    vm.omSalesForecasts = res.data.data.summary;
                    vm.itemLists = res.data.data.itemByOmSales;
                    vm.totalEfficiencyP03 = res.data.data.totalEfficiencyP03;
                    vm.totalQuantity = res.data.data.totalQuantity;
                    vm.omSales = res.data.data.omSales;
                    vm.currOnhand = res.data.data.currOnhand;
                    // ---------------------------------------------------------------------------
                    vm.pmProducts = res.data.data.pmProducts;
                    vm.prevTotalQuantity = res.data.data.prevTotalQuantity;

                    vm.$emit("omSalesForecast", vm.omSalesForecasts, vm.itemLists, false);
                    vm.alertSaleForcast();
                    if (res.data.data.status == 'E') {
                        valid = false;
                        swal({
                            title: 'ตรวจสอบข้อมูล',
                            text: '<span style="font-size: 16px; text-align: left;">'+res.data.data.msg+'</span>',
                            type: "info",
                            html: true
                        });
                    }
                    if (!valid) {
                        return;
                    }
                })
                .catch(err => {
                    console.log('error');
                    console.log(err);
                })
                .then(() => {
                    vm.loading.omSalesForecastProcess = false;
                });
            },
            getUnitProductType(){
                if (this.productType == '71' || this.productType == '78') {
                    this.unit = 'ล้านมวน';
                }else{
                    this.unit = 'ล้านชิ้น';
                }
            },
            changeVersion(){
                this.getProductionPlan();
            },
            alertSaleForcast(){
                var vm = this;
                vm.omSalesForecasts.filter(function(saleForecast) {
                    let i = 0;
                    i = vm.totalQuantity[saleForecast.item_code]? saleForecast.forecast_million_qty - vm.totalQuantity[saleForecast.item_code][0]: saleForecast.forecast_million_qty - 0;

                    Vue.set(vm.alertSaleForcasts, saleForecast.item_code, i);
                });
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

    .nav .label, .ibox .label {
        font-size: 12px;
    }
</style>