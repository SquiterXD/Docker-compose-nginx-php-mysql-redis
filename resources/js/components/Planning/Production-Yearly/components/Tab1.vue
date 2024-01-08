<template>
    <div v-loading="loading">
        <div class="form-group row">
            <label class="col-lg-2 col-form-label text-left">
                <strong> สั่งผลิต(%) </strong> &nbsp;&nbsp;
                {{ p01EfficiencyProduct }}
            </label>
        </div>
        <div v-html="html"></div>
    </div>
</template>

<script>

    export default {
        props:[
            "pDateFormat", "machineEfficiencyProd", "prodYearlyMain", "productType", "url", "workingHour", "selTabName", "pRefresh"
        ],
        data() {
            return {
                loading: false,
                html: '',
            }
        },
        mounted() {
            this.getProductPlanMachine();
        },
        methods: {
            getProductPlanMachine(){
                let vm = this;
                if ( !vm.productType || vm.selTabName != 'tab1') {
                    return;
                }
                vm.loading = true;
                let params = {
                    yearly_main_id: vm.prodYearlyMain.yearly_main_id,
                    product_type: vm.productType,
                }

                axios.get(vm.url.ajax_get_plan_machine, { params })
                .then(res => {
                    let data = res.data.data;
                    vm.html = data.html;
                })
                .catch(err => {
                    let msg = err.response.data;
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: msg.message,
                        type: "error",
                    });
                })
                .then(() => {
                    vm.loading = false;
                });
            },
        },
        watch:{
            productType() {
                this.getProductPlanMachine();
            },
            pRefresh : async function (value, oldValue) {
                this.getProductPlanMachine();
            },
        },
        computed: {
            p01EfficiencyProduct() {
                let vm = this;
                let p01EffiProd = '-';
                if (vm.prodYearlyMain) {
                    let efficiencyProduct = vm.machineEfficiencyProd.filter(o => o.product_type == vm.productType);
                    if (efficiencyProduct) {
                        p01EffiProd = efficiencyProduct[0]['efficiency_product']
                    }
                }

                return p01EffiProd;
            },
        },
    }
</script>