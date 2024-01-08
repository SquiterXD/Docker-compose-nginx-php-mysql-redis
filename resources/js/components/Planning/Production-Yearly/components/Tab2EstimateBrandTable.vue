<template>
    <div v-if="!pLoading">
        <div class="hr-line-dashed"></div>
        <div class="table-responsive m-t"  >
            <div v-if="productType == 'KK'" v-html="estKkTableHtml"> </div>
            <table v-if="productType != 'KK'" class="table text-nowrap table-bordered table-hover" style="position: sticky;">
                <thead>
                    <tr>
                        <th style="background-color: #ffffff !important; border: 0px;" class="align-bottom sticky-col h1-col" colspan="4"> </th>
                        <th style="background-color: #ffffff !important; border: 0px;" class="align-bottom"> </th>
                        <th style="background-color: #ffffff !important; border: 0px;" class="align-bottom"> </th>
                        <template v-for="(thai_month, key, index) in periods">
                            <td style="background-color: #ffffff; border: 0px;" class="text-right" colspan="5">
                                <div class="row">
                                    <div class="col-md-3"> <strong> {{ thai_month }} </strong> </div>
                                    <div class="col-md-5"> ประมาณการผลิตสูงสุด </div>
                                    <div class="col-md-4" >
                                        <vue-numeric
                                            separator=","
                                            v-bind:precision="2"
                                            :min="0"
                                            :max="9999999999"
                                            v-bind:minus="false"
                                            class="form-control input-sm text-right"
                                            placeholder="ประมาณการผลิตสูงสุด"
                                            v-model="totalEffProductData[key]"
                                            disabled
                                        ></vue-numeric>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-5"> จำนวนวันขาย (วัน) </div>
                                    <div class="col-md-4" style="text-align: right;">
                                        <vue-numeric
                                            separator="," 
                                            v-bind:precision="2"
                                            :min="0"
                                            :max="9999999999"
                                            v-bind:minus="false"
                                            class="form-control input-sm text-right"
                                            placeholder="จำนวนวันขาย"
                                            v-model="omDayForSaleData[key]"
                                            disabled
                                        ></vue-numeric>
                                    </div>
                                </div>
                                <!-- Add new detail 20220314 -->
                                <div class="row mt-2">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-5"> ประมาณการผลิตสูงสุดหักขาย </div>
                                    <div class="col-md-4" style="text-align: right;">
                                        <Tab2EffProductPeriod
                                            placeholder = 'ประมาณการผลิตสูงสุดหักขาย'
                                            :totalEffProduct="totalEffProductData[key]"
                                            :summaryTotal="summaryTotalForcastQty[index].forcast_qty"
                                        />
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-5" style="font-size: 12px;"> ประมาณการผลิตสูงสุดหักผลิตที่กำหนด </div>
                                    <div class="col-md-4" style="text-align: right;">
                                        <Tab2EffProductPeriod
                                            placeholder = 'ประมาณการผลิตสูงสุดหักผลิตที่กำหนด'
                                            :totalEffProduct="totalEffProductData[key]"
                                            :summaryTotal="summaryTotalPlaningQty[index].planning_qty"
                                        />
                                    </div>
                                </div>
                            </td>
                        </template>
                    </tr>
                    <tr>
                        <th class="align-middle text-center sticky-col first-col" rowspan="2"> ลำดับ </th>
                        <th class="align-middle text-center sticky-col second-col" rowspan="2"> รหัสบุหรี่ </th>
                        <th class="align-middle text-center sticky-col th-col" rowspan="2"> ตราบุหรี่ </th>
                        <th class="align-middle text-center sticky-col fo-col" rowspan="2"> ผลิต/BATCH <br> (ล้านมวน) </th>
                        <th class="align-middle text-center" rowspan="2"> ปริมาณใช้ใบยาต่อ <br> 1 ล้านมวน (กก.) </th>
                        <th class="align-middle text-center" rowspan="2"> คาดการณ์คงคลัง  <br> (ล้านมวน) </th>
                        <template v-for="(thai_month, key, index) in periods">
                            <th class="text-center text-white" :style="'background-color: '+ yearlyColorCode[index]+'; border-right: 3px solid #646464;'" colspan="5"> {{ thai_month }} </th>
                        </template>
                        <th class="align-middle text-center text-white" colspan="3" style="background-color: #35d399;"> รวมทั้งปีงบประมาณ </th>
                    </tr>
                    <tr>
                        <template v-for="(thai_month, key, index) in periods">
                            <th class="text-center"> จำนวน (ชุด) </th>
                            <th class="text-center" :title="formula1"> ประมาณการผลิต <br> (ล้านมวน) </th>
                            <th class="text-center" :title="formula2"> ประมาณใช้ใบยา <br> (กก.) </th>
                            <th class="text-center"> ประมาณการขาย <br> (ล้านมวน) </th>
                            <th class="text-center" style="border-right: 3px solid #646464;" :title="formula3"> คงคลังสิ้นเดือน <br> (ล้านมวน) </th>
                        </template>
                        <th class="align-middle text-center"> รวมประมาณการผลิต <br> (ล้านมวน) </th>
                        <th class="align-middle text-center"> รวมประมาณการขาย <br> (ล้านมวน) </th>
                        <th class="align-middle text-center"> ผลต่างผลิตหักขาย <br> (ล้านมวน) </th>
                    </tr>
                </thead>
                <tbody>
                    <template v-for="(item, key, index) in items">
                        <tr>
                            <!-- :style="sel_item == item.item_code? 'background-color: #9AD9DB; vertical-align: middle;': 'vertical-align: middle;'" -->
                            <td class="text-center sticky-col first-col" style="vertical-align: middle;" @click="selItem(item.item_code)">
                                {{ index >= 0? Number(index)+1: key+1 }}
                            </td>
                            <td class="text-center sticky-col second-col" style="vertical-align: middle;" @click="selItem(item.item_code)">
                                {{ item.item_code }}
                            </td>
                            <td class="sticky-col th-col" style="vertical-align: middle;" @click="selItem(item.item_code)">
                                {{ item.item_description }}
                            </td>
                            <td class="text-center sticky-col fo-col" style="vertical-align: middle;" @click="selItem(item.item_code)">
                                {{ item.define_product_cigaret }}
                            </td>
                            <td class="text-right" style="vertical-align: middle;" @click="selItem(item.item_code)">
                                {{ Number(item.formula_qty) | number2Digit }}
                            </td>
                            <td class="text-right" style="vertical-align: middle;" @click="selItem(item.item_code)">
                                <input-onhand-quantity :line="item"
                                    :est-by-brand-data="estByBrandData"
                                    :begin-onhand-qty-change-data="beginOnhandQtyChangeData"
                                    :periods="periods"
                                    :period-cal="periodCal"
                                    :can-edit="canEdit"
                                />
                            </td>
                            <template v-for="(estByBrand, period) in estByBrandData">
                                <template v-for="(value, itemCode) in estByBrand">
                                    <template v-if="item.item_code == itemCode">
                                        <td class="text-right" style="vertical-align: middle;" @click="selItem(item.item_code)">
                                            <!-- <input-total-quantity :line="value"
                                                :total-qty-change-data="totalQtyChangeData"
                                                :can-edit="canEdit"
                                            /> -->
                                            {{ value.total_qty | number2Digit }}
                                        </td>
                                        <td class="text-right" style="vertical-align: middle;" @click="selItem(item.item_code)">
                                            <input-plan-quantity :line="value"
                                                :total-plan-change-data="totalPlanChangeData"
                                                :est-by-brand-data="estByBrandData"
                                                :periods="periods"
                                                :period-cal="periodCal"
                                                :can-edit="canEdit"
                                            />
                                        </td>
                                        <td class="text-right" style="vertical-align: middle;" @click="selItem(item.item_code)">
                                            {{ value.used_qty | number2Digit }}
                                        </td>
                                        <td class="text-right" style="vertical-align: middle;" @click="selItem(item.item_code)">
                                            {{ value.forcast_qty | number2Digit }}
                                        </td>
                                        <td class="text-right" :style="sel_item == item.item_code? 'background-color: #9AD9DB; vertical-align: middle; border-right: 3px solid #646464;': 'vertical-align: middle; border-right: 3px solid #646464;'" @click="selItem(item.item_code)">
                                            {{ value.bal_onhand_qty | number2Digit }}
                                        </td>
                                    </template>
                                </template>
                            </template>
                            <td class="text-right" style="vertical-align: middle;" @click="selItem(item.item_code)">
                                {{ Number(item.total_planning_qty) | number2Digit }}
                            </td>
                            <td class="text-right" style="vertical-align: middle;" @click="selItem(item.item_code)">
                                {{ Number(item.total_forcast_qty) | number2Digit }}
                            </td>
                            <td class="text-right" style="vertical-align: middle;" @click="selItem(item.item_code)">
                                {{ Number(item.total_final_qty) | number2Digit }}
                            </td>
                        </tr>
                    </template>
                    <tr>
                        <th colspan="4" class="text-right sticky-col t1-col"> รวม </th>
                        <th class="text-right" style="background-color: #34d399;"> </th>
                        <th class="text-right text-white" style="background-color: #34d399;">
                            {{ Number(totalBeginOnhand) | number2Digit }}
                        </th>
                        <template v-for="(period, index) in periodCal">
                            <th style="background-color: #34d399;" class="text-right text-white">
                                {{ Number(summaryTotalQty[index].total_qty) | number2Digit }}
                            </th>
                            <th style="background-color: #34d399;" class="text-right text-white">
                                {{ Number(summaryTotalPlaningQty[index].planning_qty) | number2Digit }}
                            </th>
                            <th style="background-color: #34d399;" class="text-right text-white">
                                {{ summaryByPeriodData[period].used_qty | number2Digit }}
                            </th>
                            <th style="background-color: #34d399;" class="text-right text-white">
                                {{ summaryByPeriodData[period].forcast_qty | number2Digit }}
                            </th>
                            <th style="background-color: #34d399; border-right: 3px solid #646464;" class="text-right text-white">
                                {{ Number(summaryTotalOnhandQty[index].bal_onhand_qty) | number2Digit }}
                            </th>
                        </template>
                        <th style="background-color: #34d399;" class="text-right text-white">
                            {{ Number(summaryTotalData['total_planning_qty']) | number2Digit }}
                        </th>
                        <th style="background-color: #34d399;" class="text-right text-white">
                            {{ Number(summaryTotalData['total_forcast_qty']) | number2Digit }}
                        </th>
                        <th style="background-color: #34d399;" class="text-right text-white">
                            {{ Number(summaryTotalData['total_final_qty']) | number2Digit }}
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    import InputOnhandQuantity   from './InputOnhandQuantity.vue';
    import InputTotalQuantity    from './InputTotalQuantity.vue';
    import InputPlanQuantity    from './InputPlanQuantity.vue';
    import Tab2EffProductPeriod from './Tab2EffProductPeriod.vue';
    import VueNumeric from 'vue-numeric';
    export default {
        components: {
            InputOnhandQuantity, InputTotalQuantity, InputPlanQuantity, Tab2EffProductPeriod, VueNumeric
        },
        props:[
            'url', "prodYearlyMain", "productType", "btnTrans", "yearlyColorCode", "canEdit", 'pRefresh', 'pWorkingHour', 'pLoading', "beginOnhandQtyChangeData", "totalQtyChangeData", "totalPlanChangeData"
        ],
        data() {
            return {
                loading: false,
                refresh: (this.pRefresh != undefined && this.pRefresh != '') ? this.pRefresh : false,
                items: [],
                periods: [],
                periodCal: [],
                summaryByPeriodData: [],
                summaryTotalData: [],
                estByBrandData: [],
                totalEffProductData: [],
                omDayForSaleData: [],
                estKkTableHtml: '',
                // By Period
                summaryTotalQty: [],
                summaryTotalPlaningQty: [],
                summaryTotalOnhandQty: [],
                summaryTotalForcastQty: [],
                sel_item: '',
                // สมการ tab1:table2
                formula1: 'ผลิต / Batch * จำนวน(ชุด)',
                formula2: 'ปริมานใช้ใบยาต่อ 1 ล้านมวน * ประมาณการผลิต (ล้านมวน)',
                formula3: 'คงคลัง (ล้านมวน) + ประมาณการผลิต (ล้านมวน) - ประมาณการขาย (ล้านมวน)',
            }
        },
        mounted() {
            this.getData();
            // this.totalPeriod();
        },
        methods: {
            async getData() {
                let vm = this;
                if (!vm.refresh) {
                    return;
                }
                vm.loading = true;
                vm.estByBrandData = false
                vm.estKkTableHtml = false;
                vm.summaryData = [];
                let params = {
                    yearly_main_id: vm.prodYearlyMain.yearly_main_id,
                    product_type: vm.productType,
                };
                await axios.get(vm.url.ajax_get_est_by_brand, { params })
                    .then(res => {
                        vm.items = res.data.data.items;
                        vm.periods = res.data.data.periods;
                        vm.periodCal = res.data.data.period_cal;
                        vm.estKkTableHtml = res.data.data.est_kk_table_html;
                        vm.estByBrandData = res.data.data.est_by_brand;
                        vm.totalEffProductData = res.data.data.total_eff_product;
                        vm.omDayForSaleData = res.data.data.om_day_for_sale;
                        vm.summaryByPeriodData = res.data.data.summary_by_period;
                        vm.summaryTotalData = res.data.data.summary_total;
                    })
                    .catch(err => {
                        console.log('error')
                        let data = err.response.data;
                        alert(data.message);
                    })
                    .then(() => {
                        vm.loading = false;
                    });
                vm.refresh = false;
            },
            selItem(item){
                this.sel_item = item;
            },
        },
        computed: {
            totalBeginOnhand() {
                return Object.values(this.items).reduce((accumulator, line) => {
                    return accumulator + parseFloat(line.begin_onhand_qty);
                }, 0);
            },
            totalQuantity() {
                var result = [];
                var res = [];
                let vm = this;
                if (vm.estByBrandData) {
                    Object.keys(vm.periods).filter(function(period){
                        return Object.values(vm.estByBrandData[period]).filter(function(val2){
                            if (!res[val2['period_no']]) {
                                res[val2['period_no']] = {period: val2['period_no'], total_qty: 0};
                                result.push(res[val2['period_no']]);
                            }
                            res[val2['period_no']].total_qty += parseFloat(val2['total_qty']);
                        });
                    }, 0);
                    vm.summaryTotalQty = result;
                }
            },
            totalPlanningQuantity() {
                var result = [];
                var res = [];
                let vm = this;
                if (vm.estByBrandData) {
                    Object.keys(vm.periods).filter(function(period){
                        return Object.values(vm.estByBrandData[period]).filter(function(val2){
                            if (!res[val2['period_no']]) {
                                res[val2['period_no']] = {period: val2['period_no'], planning_qty: 0};
                                result.push(res[val2['period_no']]);
                            }
                            res[val2['period_no']].planning_qty += parseFloat(val2['planning_qty']);
                        });
                    }, 0);
                    vm.summaryTotalPlaningQty = result;
                    this.$emit("summaryTotalPlaningTab2", this.summaryTotalPlaningQty);
                }
            },
            totalOnhandQuantity() {
                var result = [];
                var res = [];
                let vm = this;
                if (vm.estByBrandData) {
                    Object.keys(vm.periods).filter(function(period){
                        return Object.values(vm.estByBrandData[period]).filter(function(val2){
                            if (!res[val2['period_no']]) {
                                res[val2['period_no']] = {period: val2['period_no'], bal_onhand_qty: 0};
                                result.push(res[val2['period_no']]);
                            }
                            res[val2['period_no']].bal_onhand_qty += parseFloat(val2['bal_onhand_qty']);
                        });
                    }, 0);
                    this.summaryTotalOnhandQty = result;
                }
            },
            totalForcastQuantity() {
                var result = [];
                var res = [];
                let vm = this;
                if (vm.estByBrandData) {
                    Object.keys(vm.periods).filter(function(period){
                        return Object.values(vm.estByBrandData[period]).filter(function(val2){
                            if (!res[val2['period_no']]) {
                                res[val2['period_no']] = {period: val2['period_no'], forcast_qty: 0};
                                result.push(res[val2['period_no']]);
                            }
                            res[val2['period_no']].forcast_qty += parseFloat(val2['forcast_qty']);
                        });
                    }, 0);
                    this.summaryTotalForcastQty = result;
                }
            },
        },
        watch: {
            pRefresh : async function (value, oldValue) {
                this.refresh = true;
                this.getData();
            },
            totalQuantity(newValue){
                return newValue;
            },
            totalPlanningQuantity(newValue){
                return newValue;
            },
            totalOnhandQuantity(newValue){
                return newValue;
            },
            totalForcastQuantity(newValue){
                return newValue;
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

    .sticky-col {
        position: sticky;
        background-color: #f7f7f7 !important;
        z-index: 9999;
    }

    .first-col {
        width: 150px;
        min-width: 70px;
        max-width: 150px;
        left: 0px;
    }

    .second-col {
        width: 150px;
        min-width: 135px;
        max-width: 150px;
        left: 68px;
    }

    .th-col {
        width: 250px;
        min-width: 165px;
        max-width: 250px;
        left: 202px;
    }

    .fo-col {
        width: 200px;
        min-width: 100px;
        max-width: 200px;
        left: 365px;
    }

    .fi-col {
        width: 200px;
        min-width: 125px;
        max-width: 200px;
        left: 463px;
    }

    .t1-col {
        width: 200px;
        min-width: 150px;
        max-width: 200px;
        left: -5px;
    }

    .h1-col {
        width: 200px;
        min-width: 150px;
        max-width: 200px;
        left: -5px;
    }
</style>