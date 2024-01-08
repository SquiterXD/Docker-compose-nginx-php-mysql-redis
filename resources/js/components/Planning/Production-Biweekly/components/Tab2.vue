<template>
    <div>
        <template v-if="productType != 'KK'">
            
            <div class="form-group row">
                <label class="col-lg-1 col-form-label text-right"> แสดงข้อมูล</label>
                <div class="col-lg-3">
                    <el-select style="width: 100%" v-model="omBiweeklyId" size="large"
                        @change="changEestBiweeklyId"
                        placeholder="ปักษ์" filterable >
                       <el-option
                           v-for="(omBiweekly, index) in omBiweeklyList"
                            :key="index"
                            :label="'ประมาณการจำหน่ายรายปักษ์ที่ ' + omBiweekly.om_bi_weekly.biweekly_no"
                            :value="omBiweekly.om_biweekly_id"
                        >
                        </el-option>
                    </el-select>
                </div>
            </div>

            <table class="table">
                <tbody>
                    <tr>
                        <td width="10%" class="text-right font-weight-bold">ปักษ์ที่ </td>
                        <td width="3%">
                            <div v-if="omBiweeklyDetail">{{ omBiweeklyDetail.om_bi_weekly.biweekly_no }}</div>
                        </td>

                        <td width="10%" class="text-right font-weight-bold">จำนวนวันขาย</td>
                        <td width="3%">
                            <div v-if="omBiweeklyDetail">{{ omBiweeklyDetail.day_for_sale }}</div>
                        </td>

                        <td width="30%" class="text-right font-weight-bold">เฉลี่ยจำหน่าย/ต่อวันย้อนหลัง 10 วันตั้งแต่วันที่</td>
                        <td >
                            <span v-if="omBiweeklyDetail">{{ omBiweeklyDetail.back_sale_start_date_format }}</span>
                            <strong>&nbsp;&nbsp;&nbsp;ถึง&nbsp;&nbsp;&nbsp;</strong>
                            <span v-if="omBiweeklyDetail">{{ omBiweeklyDetail.back_sale_end_date_format }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="hr-line-dashed"></div>
            <div v-loading="loading.estBiweeklyTable" v-html="estBiweeklyTable"></div>
        </template>



        <div class="hr-line-dashed"></div>
        <tab2-avg-table
            :url="url"
            :btnTrans="btnTrans"
            :omBiweeklyDetail="omBiweeklyDetail"
            :prodBiweeklyMain="prodBiweeklyMain"
            :product-type="productType"
            :pRefresh="refreshAvgData"
            :p-working-hour="pWorkingHour"
            :calTypeDefault="calTypeDefault"
            :calTypes="calTypes"
            :canEdit="canEdit"
            :biweeklyColorCode="biweeklyColorCode"
            @tab2AvgChange='tab2AvgChange'
        >
        </tab2-avg-table>
        <!-- <plan-tab22-component
            :url="url"
            :est-biweekly-detail="omBiweeklyDetail"
            :product-plan-id="productPlanId"
            :product-type="productType"
            :pRefresh="refreshAvgData"
            :p-working-hour="pWorkingHour"

            :cal-type-default="calType"
            :cal-types="calTypes" /> -->
    </div>
</template>

<script>

    import Tab2AvgTable from './Tab2AvgTable'
    export default {
        components: {
          Tab2AvgTable
        },
        props:[
            'url', 'pDateFormat', "pRefresh", "btnTrans", "biweeklyColorCode",
            "prodBiweeklyMain", "selTabName",
            "calTypes", "calTypeDefault", "productType", "omBiweeklyList", "pDefaultInput", "canEdit",

            'productPlanId', 'EstBiWeekly', 'pWorkingHour'
        ],
        data() {
            return {
                dateFormat: (this.pDateFormat != undefined && this.pDateFormat != '') ? this.pDateFormat : 'DD/MM/YYYY',
                omBiweeklyId: (this.pDefaultInput != undefined && this.pDefaultInput != '') ? this.pDefaultInput.tab2_om_biweekly_id : null,
                omBiweeklyDetail: false,
                estBiweeklyTable: null,
                loading: {
                    estBiweeklyTable: false
                },
                calType:  (this.calTypeDefault != undefined && this.calTypeDefault != '') ? this.calTypeDefault : null,
                refreshAvgData: 0,
            }
        },
        mounted() {
            this.changEestBiweeklyId();
        },
        computed: {
        },
        methods: {
            tab2AvgChange(line) {
                this.$emit("tab2AvgChange", line);
            },
            async changEestBiweeklyId() {
                let data = this.omBiweeklyList.filter(o => {
                    return o.om_biweekly_id == this.omBiweeklyId;
                });

                this.omBiweeklyDetail = false;
                if (data.length > 0) {

                    this.omBiweeklyDetail = data[0];
                    let startDate = this.omBiweeklyDetail.back_sale_start_date;
                        startDate = await helperDate.parseToDateTh(startDate, 'YYYY-MM-DD');
                        startDate = await helperDate.parseToDateThFormat(startDate, this.dateFormat);

                    this.$set(this.omBiweeklyDetail, 'back_sale_start_date_format', startDate);

                    let endDate = this.omBiweeklyDetail.back_sale_end_date;
                        endDate = await helperDate.parseToDateTh(endDate, 'YYYY-MM-DD');
                        endDate = await helperDate.parseToDateThFormat(endDate, this.dateFormat);

                    this.$set(this.omBiweeklyDetail, 'back_sale_end_date_format', endDate);

                    this.getEstDataTable();
                }
            },
            async getEstDataTable() {
                let vm = this;
                if (vm.productType) {
                    vm.refreshAvgData = vm.refreshAvgData + 1;
                }
                if (!vm.omBiweeklyDetail || !vm.productType) {
                    return;
                }

                vm.loading.estBiweeklyTable = true;
                let params = {
                    product_main_id: vm.prodBiweeklyMain.product_main_id,
                    om_biweekly_id: vm.omBiweeklyDetail.om_biweekly_id,
                    product_type: vm.productType,
                };
                await axios.get(vm.url.ajax_get_est_data, { params })
                    .then(res => {
                        vm.estBiweeklyTable = res.data.data.html
                    })
                    .catch(err => {
                        let data = err.response.data;
                        alert(data.message);
                    })
                    .then(() => {
                        vm.loading.estBiweeklyTable = false;
                    });
            },
            async changCalType() {

            }
        },
        watch: {
            productType : async function (value, oldValue) {
                if (this.selTabName != 'tab2') { return; }
                this.getEstDataTable();
            },
            pRefresh : async function (value, oldValue) {
                if (this.selTabName != 'tab2') { return; }
                this.getEstDataTable();
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