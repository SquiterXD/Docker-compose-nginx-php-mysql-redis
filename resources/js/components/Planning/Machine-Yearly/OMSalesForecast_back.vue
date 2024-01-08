<template>
    <span>
        <!-- v-if="header.product_type != 'KK'" -->
        <button  class="btn btn-info btn-md" style="padding-left: 7px;" data-toggle="modal" data-target="#modal-om-sales" data-backdrop="static" data-keyboard="false"> <i class="fa fa-eye"></i> รายละเอียดประมาณการจำหน่าย </button>
        <div id="modal-om-sales" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 style="font-size:22px; font-weight:400;" class="modal-title text-left">
                            ประมาณการจำหน่าย
                        </h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div id="modal_content"> 
                            <form id="om-sales-form">
                                <div class="table-responsive" v-html="html"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </span>
</template>

<script>
    export default {
        props:[
            "header", "html"
        ],
        data() {
            return {
               //
            }
        },
        mounted() {
            //
        },
        computed: {
        },
        // methods: {
        //     getProductName(){
        //         let vm = this;
        //         vm.productTypes.filter(function(prod) {
        //             if (vm.productType == prod.lookup_code) {
        //                 return vm.productName = prod.meaning;
        //             }
        //         });
        //     },
        //     async getProductionPlan() {
        //         let vm = this;
        //         vm.getProductName();
        //         if (!vm.productType) {
        //             return;
        //         }

        //         let params = {
        //             budget_year: vm.machineBiweekly.budget_year,
        //             biweekly_id: vm.machineBiweekly.biweekly_id,
        //             product_type: vm.productType
        //         };
        //         vm.summaryData = '';
        //         vm.loading.omSalesForecastProcess = true;
        //         await axios.get(vm.url.ajax_get_om_sales_forecast, { params })
        //        .then(res => {
        //             var valid = true;
        //             vm.html = res.data.data.html
        //             vm.summaryData = res.data.data.summary;
        //             vm.itemLists = res.data.data.itemByOmSales;
        //             vm.$emit("omSalesForecast", vm.summaryData, vm.itemLists);
        //             if (res.data.data.status == 'E') {
        //                 valid = false;
        //                 swal({
        //                     title: 'ตรวจสอบข้อมูล',
        //                     text: '<span style="font-size: 16px; text-align: left;">'+res.data.data.msg+'</span>',
        //                     type: "info",
        //                     html: true
        //                 });
        //             }
        //             if (!valid) {
        //                 return;
        //             }
        //         })
        //         .catch(err => {
        //             console.log('error');
        //             console.log(err);
        //         })
        //         .then(() => {
        //             vm.loading.omSalesForecastProcess = false;
        //         });
        //     },
        // },
        // watch: {
        //     productType : async function (value, oldValue) {
        //         // this.getProductionPlan();
        //         // this.$emit("omSalesForecast", this.summaryData, this.itemLists);
        //         // this.html = '';
        //     },
        // },
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