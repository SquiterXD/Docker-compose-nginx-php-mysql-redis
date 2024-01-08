<template>
    <div id="PPP0006">
        <div class="card border-primary mb-3 mt-3">
            <div class="card-body">
                <header-detail :url="url" :btnTrans="btnTrans" :followUp="followUp" :data="data" />
                <div class="row">
                    <div class="col-8 b-r">
                        <div class="row">
                            <div class="col-lg-12">
                                <dl class="row mb-0">
                                    <div class="col-sm-2 pl-0 text-sm-right">
                                        <dt>ประมาณการผลิต:</dt>
                                    </div>
                                    <div class="col-sm-8 text-sm-left">
                                        <div>
                                            <el-radio-group v-model="data.default_input.product_type" size="small">
                                                <template v-for="(product, index) in data.product_types">
                                                <el-radio @click="getData" :label="product.lookup_code" class="mr-1 mb-1" border>
                                                    {{ product.meaning }}
                                                </el-radio>
                                                </template>
                                                <el-radio @click="getData" label="all" class="mr-1 mb-1" border>
                                                    แสดงทุกประเภท
                                                </el-radio>
                                            </el-radio-group>
                                        </div>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="tabs-container" v-loading="loading">
            <ul class="nav nav-tabs" role="tablist">
                <li>
                    <a class="nav-link active" data-toggle="tab" href="#tab1" @click="selTabName = 'tab1'">
                        คงคลังกองผลิตภัณฑ์
                    </a>
                </li>
                <li>
                    <a class="nav-link " data-toggle="tab" href="#tab2" @click="selTabName = 'tab2'">
                        คาดการณ์คงคลังล่วงหน้า
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" id="tab1" class="tab-pane active">
                    <div class="panel-body">
                        <!-- <template v-if="data.default_input.product_type != 'all'"> -->
                            <form id="ppp0006-tab1" :action="url.get_report_follow_ups_ppr0004" method="post" target="_blank">
                                <input type="hidden" name="product_type" :value="data.default_input.product_type">
                                <input type="hidden" name="_token" :value="token">
                                <div class="text-right">
                                    <button v-if="followUp" type="submit" :class="btnTrans.print.class + ' btn-lg tw-w-25'">
                                        <i :class="btnTrans.print.icon"></i>
                                        {{ btnTrans.print.text }}
                                    </button>
                                </div>
                                <div v-html="html['tab1']"></div>
                            </form>
                        <!-- </template> -->
                        <!-- <template v-else>
                            <div v-html="html['tab1']"></div>
                        </template> -->
                    </div>
                </div>
                <div role="tabpanel" id="tab2" class="tab-pane ">
                    <div class="panel-body">
                        <div v-html="html['tab2']"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    // import ModalCreate      from './ModalCreate.vue';
    import ModalSearch      from './ModalSearch.vue';
    import HeaderDetail     from './components/HeaderDetail.vue';
    import moment from "moment";
    export default {
        components: {
            // ModalCreate, ModalSearch, HeaderDetail, Tab1, Tab2, Tab3
            // ModalCreate, ModalSearch, HeaderDetail
            ModalSearch, HeaderDetail
        },
        props:[
            "followUp", "modalSearchInput", "colorCode", 'url', "btnTrans", "pData", 'token'
        ],
        data() {
            return {
                data: this.pData,
                loading: false,
                selTabName: 'tab1',
                html: {
                    tab1: '',
                    tab2: '',
                },
                canEdit: false,
                canApprove: false,
                cuurDate: moment().format('DD/MM/YYYY'),
                productType: this.pData.default_input.product_type,
            }
        },
        mounted() {
            this.getData();
        },
        computed: {
            product_type() {
                this.getData();
            }
        },
        watch:{
            product_type : async function (value, oldValue) {
                return data.default_input.product_type;
            },
            selTabName : async function (value, oldValue) {
                this.getData();
            }
        },
        methods: {
            async getData() {
                let vm = this;
                if (vm.selTabName == undefined || vm.selTabName == '') {
                    return;
                }
                if (!vm.followUp || !vm.selTabName) {
                    return;
                }

                vm.loading = true;
                let params = {
                    follow_main_id: vm.followUp.follow_main_id,
                    tab_name: vm.selTabName,
                    product_type: vm.data.default_input.product_type,
                };
                await axios.get(vm.url.ajax_follow_ups_get_data, { params })
                    .then(res => {
                        let data = res.data.data;
                        vm.html[vm.selTabName] = data.html;
                    })
                    .catch(err => {
                        console.log('error')
                        let data = err.response.data;
                        alert(data.message);
                    })
                    .then(() => {

                        vm.loading = false;
                    });

                $(function () {
                  $('[data-toggle="tooltip"]').tooltip({ placement: 'top' });
                })
            },
        }
    }
</script>

<style>
    #PPP0006 .xxxx {
        margin-left: 10px;
    }
</style>