<template>
    <span>
        <button class="btn btn-info btn-md" style="padding-left: 7px;" @click="openModal">
            <i class="fa fa-eye"></i> รายละเอียดประมาณการจำหน่าย
        </button>
        <!-- <span v-html="omSalesForecast"></span> -->
        <div id="modal-om-sales" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg" style="width: 90%; max-width:980px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 style="font-size:24px; font-weight:400;" class="modal-title text-left">
                            รายละเอียดประมาณการจำหน่าย
                        </h3>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    </div>
                    <div class="modal-body text-left" v-loading="loading">
                        <template v-if="pSaleForecasts.length <= 0">
                            <div class="col-12 text-center">
                                <h2> ไม่พบข้อมูลประมาณการจำหน่าย </h2>
                            </div>
                        </template>
                        <template v-else>
                            <div class="row col-12" style="font-size: 15px;">
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-4 col-sm-6 col-xs-6 mt-2">
                                    <label class=" tw-font-bold tw-uppercase mb-1"> เดือน : </label>
                                    <span> {{ omMonth }} </span>
                                </div>

                                <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-6 col-xs-6 mt-2 text-left">
                                    <label class=" tw-font-bold tw-uppercase mb-1"> ครั้งที่ : </label>
                                    <!-- <span> {{ saleForecasts? saleForecasts[0].version: 0 }} </span> "-->
                                    <el-select v-model="version_no" placeholder="ครั้งที่" size="small" style="width: 70%;" @change="changeVersion" :popper-append-to-body="false">
                                        <el-option
                                            v-for="(value, index) in versionLists"
                                            :key="index"
                                            :label="value.version"
                                            :value="value.version">
                                        </el-option>
                                    </el-select>
                                </div>

                                <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-4 col-sm-6 col-xs-6 mt-2 text-left">
                                    <label class=" tw-font-bold tw-uppercase mb-1"> จำนวนวันขาย : </label>
                                    <span>
                                        {{ totalDayForOmSale }} วัน
                                    </span>
                                </div>

                                <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-4 col-sm-6 col-xs-6 mt-2 text-left">
                                    <label class=" tw-font-bold tw-uppercase mb-1"> วันที่อนุมัติ : </label>
                                    <span>
                                        {{ saleForecasts? saleForecasts[0].approve_date_format: '' }}
                                    </span>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="vertical-align: middle; width: 3%;">
                                           <div> ลำดับ </div> 
                                        </th>
                                        <th class="text-center" style="vertical-align: middle; width: 8%;">
                                           <div> รหัสบุหรี่ </div>
                                        </th>
                                        <th class="text-center" style="vertical-align: middle; width: 20%;">
                                           <div> ตราบุหรี่ </div>
                                        </th>
                                        <th class="text-center" style="vertical-align: middle; width: 10%;">
                                           <div> ประมาณการจำหน่าย<br>(พันมวน) </div>
                                        </th>
                                        <th class="text-center" style="vertical-align: middle; width: 10%;">
                                           <div> ประมาณการจำหน่าย<br>(ล้านมวน) </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-if="saleForecasts.length <= 0">
                                       <tr>
                                            <td colspan="5" class="text-center" style="vertical-align: middle;">
                                                <h2> ไม่พบข้อมูลที่ค้นหาในระบบ </h2>
                                            </td>
                                        </tr>
                                    </template>
                                    <template v-else>
                                        <tr v-for="(saleForecast, index) in saleForecasts">
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
                                                <div>
                                                    {{ saleForecast.forecast_qty | number3Digit }}
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <div>
                                                    {{ saleForecast.forecast_million_qty | number3Digit }}
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th colspan="3" class="text-right">รวมประมาณจำหน่าย</th>
                                            <th style="background-color: #34d399;" class="text-right text-white">
                                                {{ forecast_qty | number3Digit }}
                                            </th>
                                            <th style="background-color: #34d399;" class="text-right text-white">
                                                {{ forecast_million_qty | number3Digit }}
                                            </th>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </span>
</template>

<script>

    export default {
        props:[
            "omSalesForecast", "pSaleForecasts", 'versionLists', 'totalDayForOmSale', 'omMonth', 'url'
        ],
        data() {
            return {
                forecast_qty: 0,
                forecast_million_qty: 0,
                loading: false,
                saleForecasts: this.pSaleForecasts? this.pSaleForecasts: [],
                version_no: this.pSaleForecasts[0]? this.pSaleForecasts[0].version: 0,
            }
        },
        mounted() {
            //
        },
        computed: {
            totalForecast(){
                var vm = this;
                var total_forecast_qty = 0;
                var total_forecast_million_qty = 0;
                if (vm.pSaleForecasts.length) {
                    vm.saleForecasts.filter(function(line) {
                        total_forecast_qty += Number(line.forecast_qty);
                        total_forecast_million_qty += Number(line.forecast_million_qty);
                    });
                }
                vm.forecast_qty = total_forecast_qty;
                vm.forecast_million_qty = total_forecast_million_qty;
            },
        },
        watch:{
            totalForecast(newValue){
                return newValue;
            },
        },
        methods: {
            openModal() {
                $('#modal-om-sales').modal('show');
            },
            async changeVersion(){
                //  get data from version
                let vm = this;
                vm.loading = true;
                let params = {
                    version: vm.version_no,
                    budget_year: vm.saleForecasts[0].budget_year,
                    month_no: vm.saleForecasts[0].month_no
                };
                await axios
                .post(vm.url.get_sales_forecast_version, {params})
                .then(res => {
                    vm.loading = false;
                    console.log(res.data);
                    if (res.data.status == 'S') {
                        vm.saleForecasts = [];
                        vm.saleForecasts = res.data.saleForecasts;
                    }else{
                        swal({
                            title: '<span class="mt-2"> มีข้อผิดพลาด </span>',
                            text: '<span style="font-size: 16px; text-align: left;">'+res.data.msg+'</span>',
                            type: "warning",
                            html: true
                        });
                    }
                });
            }
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