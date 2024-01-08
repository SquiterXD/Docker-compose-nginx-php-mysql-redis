<template>
    <div>
        <div v-loading="loading" v-html="html"></div> 
    </div>
</template>

<script>
    export default {
        props:[
            'url',"pRefresh", "productType", "prodYearlyMain", "selTabName"
        ],
        data() {
            return {
                loading: false,
                refreshData: 0,
                html: ''
            }
        },
        mounted() {
            this.getEstByYearly();
        },
        computed: {
        },
        methods: {
            async getEstByYearly() {
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
                await axios.get(vm.url.ajax_get_est_by_yearly, { params })
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
            }
        },
        watch: {
            productType() {
                this.getEstByYearly();
            },
            pRefresh : async function (value, oldValue) {
                if (this.selTabName != 'tab3') { return; }
                this.getEstByYearly();
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