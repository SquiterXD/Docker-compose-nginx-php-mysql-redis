<template>
    <div class="" v-loading="loading.approveProcess">

        <div class="ibox float-e-margins mb-2" >
            <div class="col-12 text-right mt-1">

                <modal-search
                    :btn-trans="btnTrans"
                    :url="url"
                    :defaultYear="modalSearchInput.default_year"
                    :budgetYears="modalSearchInput.budget_years"
                    :biWeekly="modalSearchInput.bi_weekly"
                    :monthList="modalSearchInput.month_list"
                    :search="[]" />

                <modal-create
                    class="pr-2"
                    :btn-trans="btnTrans"
                    :url="url"
                    :defaultYear="modalCreateInput.default_year"
                    :defaultBiWeekly="modalCreateInput.default_bi_weekly"
                    :defaultDefaultMonth="modalCreateInput.default_month"
                    :budgetYears="modalCreateInput.budget_years"
                    :biWeekly="modalCreateInput.bi_weekly" />

                <button v-if="canEdit" type="button" :class="btnTrans.save.class + ' btn-lg tw-w-25'" @click.prevent="saveTab2AvgChange()">
                    <i :class="btnTrans.save.icon"></i>
                    {{ btnTrans.save.text }}
                </button>

                <button v-if="canApprove" type="button" :class="btnTrans.approve.class + ' btn-lg tw-w-25'" @click.prevent="checkApprove()">
                    <i :class="btnTrans.approve.icon"></i>
                    {{ btnTrans.approve.text }}
                </button>

                <a v-if="prodBiweeklyMain"
                    target="_blank"
                    :href="'/ir/reports/get-param?year='
                        +prodBiweeklyMain.period_year
                        +'&month='+prodBiweeklyMain.period_num
                        +'&biweekly='+prodBiweeklyMain.biweekly
                        +'&version_no='+prodBiweeklyMain.version_no
                        +'&product_type='+defaultInput.product_type
                        +'&program_code=PPR0002&function_name=PPR0002&output=pdf'"
                    type="button" :class="btnTrans.print.class + ' btn-lg tw-w-25'" >
                    <i :class="btnTrans.print.icon"></i>
                    {{ btnTrans.print.text }}
                </a>

            </div>
        </div>


        <div class="card border-primary mb-3 mt-3">
            <div class="card-body">
                <header-detail :lastUpdateDateFormat="lastUpdateDateFormat" :prod-biweekly-main="prodBiweeklyMain" />
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
                                            <el-radio-group v-model="defaultInput.product_type" size="small">
                                                <template v-for="(product, index) in productTypes">
                                                <el-radio :label="product.lookup_code" class="mr-1 mb-1" border>
                                                    {{ product.meaning }}
                                                </el-radio>
                                                </template>
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

        <div class="tabs-container">
            <ul class="nav nav-tabs" role="tablist">
                <li>
                    <a class="nav-link active" data-toggle="tab" href="#tab1" @click="selTabName = 'tab1'">
                        ประมาณกำลังการผลิต
                    </a>
                </li>
                <li>
                    <a class="nav-link " data-toggle="tab" href="#tab2" @click="selTabName = 'tab2'">
                        ประมาณการผลิตแยกรายตรา
                    </a>
                </li>
                <li>
                    <a class="nav-link " data-toggle="tab" href="#tab3" @click="selTabName = 'tab3'">
                        ประมาณการผลิตรายปักษ์
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" id="tab1" class="tab-pane active">
                    <div class="panel-body ">
                        <tab1
                            :machineEfficiencyProd="machineEfficiencyProd"
                            :product-type="defaultInput.product_type"
                            :default-bi-weekly="defaultInput.tab1_bi_weekly"
                            :pp-bi-weekly="ppBiWeekly"
                            :working-hour="workingHour"
                            :sel-tab-name="selTabName"
                            :url="url"
                            :pRefresh="refreshTab1"
                            :prod-biweekly-main="prodBiweeklyMain"/>
                    </div>
                </div>
                <div role="tabpanel" id="tab2" class="tab-pane ">
                    <div class="panel-body">
                        <tab2
                            :prod-biweekly-main="prodBiweeklyMain"
                            :product-type="defaultInput.product_type"
                            :omBiweeklyList="omBiweeklyList"
                            :cal-types="calTypes"
                            :pRefresh="refreshTab2"
                            :cal-type-default="calTypeDefault"
                            :p-date-format="pDateFormat"
                            :p-working-hour="workingHour"
                            :sel-tab-name="selTabName"
                            :pDefaultInput="pDefaultInput"

                            :canEdit="canEdit"
                            :btnTrans="btnTrans"
                            :biweeklyColorCode="biweeklyColorCode"
                            @tab2AvgChange='tab2AvgChange'
                            :url="url"
                        >
                        </tab2>
                    </div>
                </div>
                <div role="tabpanel" id="tab3" class="tab-pane ">
                    <div class="panel-body">
                        <tab3
                            :prod-biweekly-main="prodBiweeklyMain"
                            :product-type="defaultInput.product_type"
                            :pRefresh="refreshTab3"
                            :sel-tab-name="selTabName"
                            :url="url"
                        >
                        </tab3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>


    import ModalCreate      from './ModalCreate.vue';
    import ModalSearch      from './ModalSearch.vue';
    import HeaderDetail     from './components/HeaderDetail.vue';
    import Tab1             from './components/Tab1.vue';
    import Tab2             from './components/Tab2.vue';
    import Tab3             from './components/Tab3.vue';
    export default {
        components: {
            ModalCreate, ModalSearch, HeaderDetail, Tab1, Tab2, Tab3
        },
        props:[
            "machineEfficiencyProd",
            "modalCreateInput", "modalSearchInput", "biweeklyColorCode",

            "pDateFormat",
            "prodBiweeklyMain", "productTypes", "ppBiWeekly", "workingHour",
            "omBiweeklyList", "calTypes", "calTypeDefault",
            "pDefaultInput", "btnTrans", "url"
        ],
        data() {
            return {
                loading: {
                    approveProcess: false
                },
                defaultInput: (this.pDefaultInput != undefined && this.pDefaultInput != '') ? this.pDefaultInput : null,
                lastUpdateDateFormat: '',
                selTabName: 'tab1',
                refreshTab1: 0,
                refreshTab2: 0,
                refreshTab3: 0,
                canEdit: false,
                canApprove: false,
                tab2AvgChangeData: {},
            }
        },
        mounted() {
            if (this.prodBiweeklyMain != undefined && this.prodBiweeklyMain != '') {
                this.canEdit = this.prodBiweeklyMain.can.edit;
                this.canApprove = this.prodBiweeklyMain.can.approve;
            }

            if (this.prodBiweeklyMain != undefined && this.prodBiweeklyMain != '') {
                this.setLastUpdateDateFormat(this.prodBiweeklyMain.last_update_date_format);
            }
        },
        computed: {
        },
        watch:{
            selTabName : async function (value, oldValue) {
                if (value == 'tab1') {
                    this.refreshTab1 = this.refreshTab1 + 1;
                    this.tab2AvgChangeData = {}
                }
                if (value == 'tab2') {
                    this.refreshTab2 = this.refreshTab2 + 1;
                    this.tab2AvgChangeData = {}
                }
                if (value == 'tab3') {
                    this.refreshTab3 = this.refreshTab3 + 1;
                    this.tab2AvgChangeData = {}
                }
            }
        },
        methods: {
            setLastUpdateDateFormat(value) {
                this.lastUpdateDateFormat = value;
            },
            async tab2AvgChange(line) {
                let row = Object.keys(this.tab2AvgChangeData).length;
                // this.$set(this.tab2AvgChangeData, row, line);
                this.$set(this.tab2AvgChangeData, 'case'+ line.case + '-' + line.item_id, line);
            },
            async checkApprove() {
                let vm = this;
                if (!vm.canApprove) { return }

                    vm.loading.approveProcess = true;
                    await axios
                    .get(vm.url.ajax_check_approve, {lines: vm.tab2AvgChangeData})
                    .then(res => {
                        if (res.data.data.status == 'S') {
                            swal({
                                html: true,
                                title: 'อนุมัตประมาณการผลิตประจำปักษ์',
                                text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการอนุมัตประมาณการผลิตประจำปักษ์ ? </span></h2>',
                                showCancelButton: true,
                                confirmButtonText: vm.btnTrans.ok.text,
                                cancelButtonText: vm.btnTrans.cancel.text,
                                // confirmButtonClass: 'btn btn-danger',
                                // cancelButtonClass: 'btn btn-white',
                                confirmButtonClass: vm.btnTrans.ok.class + ' btn-lg tw-w-25',
                                cancelButtonClass: vm.btnTrans.cancel.class + ' btn-lg tw-w-25',
                                closeOnConfirm: false,
                                closeOnCancel: true,
                                showLoaderOnConfirm: true
                            },
                            async function(isConfirm){
                                if (isConfirm) {
                                    vm.approve();
                                }
                            });

                        } else {
                            swal({
                                title: 'อนุมัตประมาณการผลิตประจำปักษ์',
                                text: res.data.data.msg,
                                // type: "warning",
                                html: true,
                                showCancelButton: true,
                                confirmButtonText: vm.btnTrans.ok.text,
                                cancelButtonText: vm.btnTrans.cancel.text,
                                // confirmButtonClass: 'btn btn-danger',
                                // cancelButtonClass: 'btn btn-white',
                                confirmButtonClass: vm.btnTrans.ok.class + ' btn-lg tw-w-25',
                                cancelButtonClass: vm.btnTrans.cancel.class + ' btn-lg tw-w-25',
                                closeOnConfirm: false,
                                closeOnCancel: true,
                                showLoaderOnConfirm: true
                            },async function(isConfirm){
                                if (isConfirm) {
                                    console.log('Approve');
                                    vm.approve();
                                }
                            });
                        }
                    })
                    .catch(err => {
                        let data = err.response.data;
                        alert(data.message);
                    })
                    .then(() => {
                        vm.loading.approveProcess = false;
                        // swal.close();
                    });

            },
            async approve() {
                let vm = this;

                await axios
                .patch(vm.url.ajax_approve)
                .then(res => {
                    if (res.data.data.status == 'S') {
                        swal({
                            title: 'อนุมัตประมาณการผลิตประจำปักษ์',
                            text: '<span style="font-size: 16px; text-align: left;"> อนุมัตประมาณการผลิตประจำปักษ์เรียบร้อย </span>',
                            type: "success",
                            html: true
                        });
                        vm.tab2AvgChangeData = {};
                        if (vm.selTabName == 'tab2') {
                            vm.refreshTab2 = vm.refreshTab2 + 1;
                        }
                        vm.canEdit = false;
                        vm.canApprove = false;

                        vm.prodBiweeklyMain = res.data.data.prod_biweekly_main;
                    }

                    if (res.data.data.status != 'S') {
                        swal({
                            title: "Error !",
                            text: res.data.data.msg,
                            type: "error",
                            showConfirmButton: true
                        });
                    }
                })
                .catch(err => {
                    let data = err.response.data;
                    alert(data.message);
                })
                .then(() => {
                    // swal.close();
                });

            },
            async saveTab2AvgChange() {
                let vm = this;
                if (!vm.canEdit) {return}
                if (Object.keys(vm.tab2AvgChangeData).length == 0) {
                    swal({
                        title: 'อัพเดทแผนการผลิต',
                        text: '<span style="font-size: 16px; text-align: left;"> ไม่พบข้อูลการอัพเดท </span>',
                        type: "warning",
                        html: true
                    });
                    return;
                }
                let swalConfirm = swal({
                    html: true,
                    title: 'อัพเดทแผนการผลิต ?',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการอัพเดทแผนการผลิต ? </span></h2>',
                    showCancelButton: true,
                    confirmButtonText: vm.btnTrans.ok.text,
                    cancelButtonText: vm.btnTrans.cancel.text,
                    // confirmButtonClass: 'btn btn-danger',
                    // cancelButtonClass: 'btn btn-white',
                    confirmButtonClass: vm.btnTrans.ok.class + ' btn-lg tw-w-25',
                    cancelButtonClass: vm.btnTrans.cancel.class + ' btn-lg tw-w-25',
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                async function(isConfirm){
                    if (isConfirm) {

                        await axios
                        .patch(vm.url.ajax_production_biweekly_update, {lines: vm.tab2AvgChangeData})
                        .then(res => {
                            if (res.data.data.status == 'S') {
                                swal({
                                    title: 'อัพเดทแผนการผลิต',
                                    text: '<span style="font-size: 16px; text-align: left;"> อัพเดทแผนการผลิตสำเร็จ </span>',
                                    type: "success",
                                    html: true
                                });

                                vm.setLastUpdateDateFormat(res.data.data.last_update_date)
                                vm.tab2AvgChangeData = {};
                                if (vm.selTabName == 'tab2') {
                                    vm.refreshTab2 = vm.refreshTab2 + 1;
                                }
                            }

                            if (res.data.data.status != 'S') {
                                swal({
                                    title: "Error !",
                                    text: res.data.data.msg,
                                    type: "error",
                                    showConfirmButton: true
                                });
                            }
                        })
                        .catch(err => {
                            let data = err.response.data;
                            alert(data.message);
                        })
                        .then(() => {
                            // swal.close();
                        });
                    }
                });
            }
        }
    }
</script>