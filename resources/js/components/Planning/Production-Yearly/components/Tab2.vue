<template>
    <div>
        <div v-loading="loading" v-html="html"></div>
        <Tab2EstimateBrandTable
            :url="url"
            :btnTrans="btnTrans"
            :prodYearlyMain="prodYearlyMain"
            :product-type="productType"
            :pRefresh="refreshData"
            :p-working-hour="pWorkingHour"
            :canEdit="canEdit"
            :yearlyColorCode="yearlyColorCode"
            :p-loading="loading"
            :begin-onhand-qty-change-data="beginOnhandQtyChangeData"
            :total-qty-change-data="totalQtyChangeData"
            :total-plan-change-data="totalPlanChangeData"
            @summaryTotalPlaningTab2="summaryTotalPlaning"
        />
    </div>
</template>

<script>
    import Tab2EstimateBrandTable from './Tab2EstimateBrandTable'
    export default {
        components: {
            Tab2EstimateBrandTable
        },
        props:[
            "prodYearlyMain", 'url', 'pDateFormat', "pRefresh", "btnTrans", "yearlyColorCode", "selTabName", "productType", "pDefaultInput", "beginOnhandQtyChangeData", "totalQtyChangeData", "totalPlanChangeData"
            , "canEdit", 'pWorkingHour'
        ],
        data() {
            return {
                dateFormat: (this.pDateFormat != undefined && this.pDateFormat != '') ? this.pDateFormat : 'DD/MM/YYYY',
                loading: 0,
                refreshData: 0,
                html: '',
            }
        },
        mounted() {
            this.getData();
        },
        computed: {
        },
        methods: {
            async getData() {
                let vm = this;
                if (!vm.prodYearlyMain) {
                    return;
                }
                vm.refreshData = vm.refreshData + 1;
                vm.loading = true;
                vm.html = '';
                let params = {
                    yearly_main_id: vm.prodYearlyMain.yearly_main_id,
                    product_type: vm.productType,
                };
                await axios.get(vm.url.ajax_get_summary_working_hour, { params })
                    .then(res => {
                        vm.html = res.data.data.html
                    })
                    .catch(err => {
                        let data = err.response.data;
                        alert(data.message);
                    })
                    .then(() => {
                        vm.loading = false;
                    });
            },
            summaryTotalPlaning(res){
                this.$emit("summaryTotalPlaningTab2", res);
            }
        },
        watch: {
            productType : async function (value, oldValue) {
                if (this.selTabName != 'tab2') { return; }
                this.getData();
            },
            pRefresh : async function (value, oldValue) {
                if (this.selTabName != 'tab2') { return; }
                this.getData();
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