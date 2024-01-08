<template>
    <div>
        <div v-loading="loading" v-html="html"></div>
    </div>
</template>

<script>
    export default {
        props:[
            'url',"pRefresh", "productType", "prodBiweeklyMain", "selTabName"
        ],
        data() {
            return {
                loading: false,
                refreshData: 0,
                html: ''
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
                if (!vm.prodBiweeklyMain) {
                    return;
                }
                vm.refreshData = vm.refreshData + 1;

                vm.loading = true;
                vm.html = '';

                let params = {
                    product_main_id: vm.prodBiweeklyMain.product_main_id,
                    product_type: vm.productType,
                };
                await axios.get(vm.url.ajax_get_est_by_biweekly, { params })
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
            pRefresh : async function (value, oldValue) {
                if (this.selTabName != 'tab3') { return; }
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