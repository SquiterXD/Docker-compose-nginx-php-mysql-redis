<template>
    <div class="" v-loading="loading.approveProcess || loading.copyProcess">

        <div class="ibox float-e-margins mb-2" >
            <div class="col-12 text-right mt-1">

                <modal-search
                    :btn-trans="btnTrans"
                    :url="url"
                    :defaultYear="pDefaultInput.budget_year"
                    :budgetYears="modalSearchInput.budget_years"
                    :search="[]" />

                <modal-create
                    class="pr-2"
                    :btn-trans="btnTrans"
                    :url="url"
                    :defaultYear="modalCreateInput.default_year"
                    :defaultWorkingHour="modalCreateInput.default_workingHour"
                />
                    <!-- :defaultBiWeekly="modalCreateInput.default_bi_weekly" :biWeekly="modalCreateInput.bi_weekly"
                    :defaultDefaultMonth="modalCreateInput.default_month" -->

                <button v-if="canEdit" type="button" :class="btnTrans.save.class + ' btn-lg tw-w-25'" @click.prevent="saveTab2EstChange()">
                    <i :class="btnTrans.save.icon"></i>
                    {{ btnTrans.save.text }}
                </button>

                <template v-if="prodYearlyMain">
                    <button v-if="canApprove" type="button" :class="btnTrans.approve.class + ' btn-lg tw-w-25'" @click.prevent="checkApprove()">
                        <i :class="btnTrans.approve.icon"></i>
                        {{ btnTrans.approve.text }}
                    </button>
                    <button v-else type="button" :class="btnTrans.unapprove.class + ' btn-lg tw-w-25'" @click.prevent="checkUnapprove()">
                        <i :class="btnTrans.unapprove.icon"></i>
                        {{ btnTrans.unapprove.text }}
                    </button>

                    <button type="button" :class="btnTrans.copy.class + ' btn-lg tw-w-25'" @click.prevent="copyPlan()">
                        <i :class="btnTrans.copy.icon"></i>
                        {{ btnTrans.copy.text }}แผน
                    </button>
                </template>

               <!--  <button type="button" :class="btnTrans.print.class + ' btn-lg tw-w-25'" >
                    <i :class="btnTrans.print.icon"></i>
                    {{ btnTrans.print.text }}
                </button> -->

            </div>
        </div>


        <div class="card border-primary mb-3 mt-3">
            <div class="card-body">
                <header-detail :lastUpdateDateFormat="lastUpdateDateFormat"
                    :prod-yearly-main="prodYearlyMain"
                    :product-types="productTypes"
                    :default-input="pDefaultInput"
                    :url="url"
                />
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
                    <a class="nav-link" data-toggle="tab" href="#tab2" @click="selTabName = 'tab2'">
                        ประมาณการผลิตแยกรายตรา
                    </a>
                </li>
                <li>
                    <a class="nav-link" data-toggle="tab" href="#tab3" @click="selTabName = 'tab3'">
                        ประมาณการผลิตทั้งปีงบประมาณ
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" id="tab1" class="tab-pane active">
                    <div class="panel-body ">
                        <tab1
                            v-if="prodYearlyMain"
                            :machineEfficiencyProd="machineEfficiencyProd"
                            :product-type="defaultInput.product_type"
                            :working-hour="workingHour"
                            :sel-tab-name="selTabName"
                            :url="url"
                            :pRefresh="refreshTab1"
                            :prod-yearly-main="prodYearlyMain"
                            :p-date-format="pDateFormat"/>
                    </div>
                </div>
                <div role="tabpanel" id="tab2" class="tab-pane">
                    <div class="panel-body">
                        <tab2
                            v-if="prodYearlyMain"
                            :prod-yearly-main="prodYearlyMain"
                            :product-type="defaultInput.product_type"
                            :pRefresh="refreshTab2"
                            :p-date-format="pDateFormat"
                            :p-working-hour="workingHour"
                            :sel-tab-name="selTabName"
                            :pDefaultInput="pDefaultInput"
                            :canEdit="canEdit"
                            :btnTrans="btnTrans"
                            :yearlyColorCode="yearlyColorCode"
                            :url="url"
                            :begin-onhand-qty-change-data="beginOnhandQtyChangeData"
                            :total-qty-change-data="totalQtyChangeData"
                            :total-plan-change-data="totalPlanChangeData"
                            @summaryTotalPlaningTab2="summaryTotalPlaning"
                        >
                        </tab2>
                    </div>
                </div>
                <div role="tabpanel" id="tab3" class="tab-pane">
                    <div class="panel-body">
                        <tab3
                            v-if="prodYearlyMain"
                            :prod-yearly-main="prodYearlyMain"
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
            "prodYearly", "modalCreateInput", "modalSearchInput", "yearlyColorCode",
            "machineEfficiencyProd", "pDateFormat","productTypes", "workingHour",
            "pDefaultInput", "btnTrans", "url"
        ],
        data() {
            return {
                loading: {
                    approveProcess: false,
                    copyProcess: false
                },
                prodYearlyMain: this.prodYearly,
                defaultInput: (this.pDefaultInput != undefined && this.pDefaultInput != '') ? this.pDefaultInput : null,
                lastUpdateDateFormat: '',
                selTabName: 'tab1',
                refreshTab1: 0,
                refreshTab2: 0,
                refreshTab3: 0,
                canEdit: false,
                canApprove: false,
                beginOnhandQtyChangeData: {},
                totalQtyChangeData: {},
                totalPlanChangeData: {},
                summaryPlanning: [],
            }
        },
        mounted() {
            if (this.prodYearlyMain != undefined && this.prodYearlyMain != '') {
                this.canEdit = this.prodYearlyMain.can.edit;
                this.canApprove = this.prodYearlyMain.can.approve;
            }

            if (this.prodYearlyMain != undefined && this.prodYearlyMain != '') {
                this.setLastUpdateDateFormat(this.prodYearlyMain.last_update_date_format);
            }
        },
        computed: {
        },
        watch:{
            selTabName : async function (value, oldValue) {
                if (value == 'tab1') {
                    this.refreshTab1 = this.refreshTab1 + 1;
                    this.beginOnhandQtyChangeData = {}
                    this.totalQtyChangeData = {}
                    this.totalPlanChangeData = {}
                }
                if (value == 'tab2') {
                    this.refreshTab2 = this.refreshTab2 + 1;
                    this.beginOnhandQtyChangeData = {}
                    this.totalQtyChangeData = {}
                    this.totalPlanChangeData = {}
                }
                if (value == 'tab3') {
                    this.refreshTab3 = this.refreshTab3 + 1;
                    this.beginOnhandQtyChangeData = {}
                    this.totalQtyChangeData = {}
                    this.totalPlanChangeData = {}
                }
            }
        },
        methods: {
            setLastUpdateDateFormat(value) {
                this.lastUpdateDateFormat = value;
            },
            async saveTab2EstChange() {
                let vm = this;
                if (!vm.canEdit) {return}
                if (Object.keys(vm.beginOnhandQtyChangeData).length == 0 && Object.keys(vm.totalPlanChangeData).length == 0) {
                    swal({
                        title: 'อัพเดทแผนการผลิตประจำปี',
                        text: '<span style="font-size: 16px; text-align: left;"> ไม่พบข้อมูลการอัพเดท </span>',
                        type: "warning",
                        html: true
                    });
                    return;
                }
                let swalConfirm = swal({
                    html: true,
                    title: 'อัพเดทแผนการผลิตประจำปี ?',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการอัพเดทแผนการผลิตประจำปี ? </span></h2>',
                    showCancelButton: true,
                    confirmButtonText: vm.btnTrans.ok.text,
                    cancelButtonText: vm.btnTrans.cancel.text,
                    confirmButtonClass: vm.btnTrans.ok.class + ' btn-lg tw-w-25',
                    cancelButtonClass: vm.btnTrans.cancel.class + ' btn-lg tw-w-25',
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                async function(isConfirm){
                    if (isConfirm) {
                        let params = {
                            product_type: vm.defaultInput.product_type,
                            begin_onhand_qty_data: vm.beginOnhandQtyChangeData,
                            total_qty_data: vm.totalQtyChangeData,
                            total_plan_data: vm.totalPlanChangeData,
                            summaryPlanning: vm.summaryPlanning
                        };
                        await axios
                        .patch(vm.url.ajax_production_yearly_update, {params})
                        .then(res => {
                            if (res.data.data.status == 'S') {
                                swal({
                                    title: 'อัพเดทแผนการผลิตประจำปี',
                                    text: '<span style="font-size: 16px; text-align: left;"> อัพเดทแผนการผลิตประจำปีสำเร็จ </span>',
                                    type: "success",
                                    html: true
                                });

                                vm.setLastUpdateDateFormat(res.data.data.last_update_date)
                                vm.beginOnhandQtyChangeData = {}
                                vm.totalQtyChangeData = {}
                                vm.totalPlanChangeData = {}
                                if (vm.selTabName == 'tab2') {
                                    vm.refreshTab2 = vm.refreshTab2 + 1;
                                }
                            }

                            if (res.data.data.status != 'S') {
                                swal({
                                    title: "มีข้อผิดพลาด",
                                    text: '<span style="font-size: 16px; text-align: left;">'+res.data.data.msg+'</span>',
                                    type: "warning",
                                    showConfirmButton: true,
                                    html: true
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
            },
            // Approve
            async checkApprove() {
                let vm = this;
                // if (Object.keys(vm.beginOnhandQtyChangeData).length > 0 || Object.keys(vm.totalQtyChangeData).length > 0) {
                //     swal({
                //         title: 'อนุมัติประมาณการผลิตประจำปี',
                //         text: '<span style="font-size: 16px; text-align: left;"> ไม่สามารถทำการอนุมัติประมาณการผลิตประจำปี เนื่องจากมีรายการที่แก้ไขอยู่ กรุณาตรวจสอบ </span>',
                //         type: "warning",
                //         html: true
                //     });
                //     return;
                // }
                if (!vm.canApprove) { return }
                vm.loading.approveProcess = true;
                let params = {
                    summaryPlanning: vm.summaryPlanning
                };
                await axios
                .get(vm.url.ajax_check_approve, {params})
                .then(res => {
                    if (res.data.data.status == 'S') {
                        swal({
                            html: true,
                            title: 'อนุมัติประมาณการผลิตประจำปี',
                            text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการอนุมัติประมาณการผลิตประจำปี? </span></h2>',
                            showCancelButton: true,
                            confirmButtonText: vm.btnTrans.ok.text,
                            cancelButtonText: vm.btnTrans.cancel.text,
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
                            title: 'ข้อผิดพลาด',
                            text: '<span style="font-size: 16px; text-align: left;">'+res.data.data.msg+'</span>',
                            type: "warning",
                            html: true
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
                            title: 'อนุมัติประมาณการผลิตประจำปักษ์',
                            text: '<span style="font-size: 16px; text-align: left;"> อนุมัติประมาณการผลิตประจำปีเรียบร้อย </span>',
                            type: "success",
                            html: true
                        });
                        vm.tab2AvgChangeData = {};
                        if (vm.selTabName == 'tab2') {
                            vm.refreshTab2 = vm.refreshTab2 + 1;
                        }
                        vm.canEdit = false;
                        vm.canApprove = false;

                        vm.prodYearlyMain = res.data.data.prod_yearly_main;
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
            // UnApprove
            async checkUnapprove() {
                let vm = this;
                if (vm.canApprove) { return }
                vm.loading.approveProcess = true;
                await axios
                .get(vm.url.ajax_check_unapprove)
                .then(res => {
                    if (res.data.data.status == 'S') {
                        swal({
                            html: true,
                            title: 'ยกเลิกอนุมัติประมาณการผลิตประจำปี',
                            text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการยกเลิกอนุมัติประมาณการผลิตประจำปี? </span></h2>',
                            showCancelButton: true,
                            confirmButtonText: vm.btnTrans.ok.text,
                            cancelButtonText: vm.btnTrans.cancel.text,
                            confirmButtonClass: vm.btnTrans.ok.class + ' btn-lg tw-w-25',
                            cancelButtonClass: vm.btnTrans.cancel.class + ' btn-lg tw-w-25',
                            closeOnConfirm: false,
                            closeOnCancel: true,
                            showLoaderOnConfirm: true
                        },
                        async function(isConfirm){
                            if (isConfirm) {
                                vm.unapprove();
                            }
                        });
                    } else {
                        swal({
                            title: 'ยกเลิกอนุมัติประมาณการผลิตประจำปักษ์',
                            text: res.data.data.msg,
                            html: true,
                            showCancelButton: true,
                            confirmButtonText: vm.btnTrans.ok.text,
                            cancelButtonText: vm.btnTrans.cancel.text,
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
            async unapprove() {
                let vm = this;
                await axios
                .patch(vm.url.ajax_unapprove)
                .then(res => {
                    if (res.data.data.status == 'S') {
                        swal({
                            title: 'ยกเลิกอนุมัติประมาณการผลิตประจำปักษ์',
                            text: '<span style="font-size: 16px; text-align: left;"> ยกเลิกอนุมัติประมาณการผลิตประจำปีเรียบร้อย </span>',
                            type: "success",
                            html: true
                        });
                        vm.tab2AvgChangeData = {};
                        if (vm.selTabName == 'tab2') {
                            vm.refreshTab2 = vm.refreshTab2 + 1;
                        }
                        vm.canEdit = true;
                        vm.canApprove = true;

                        vm.prodYearlyMain = res.data.data.prod_yearly_main;
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
            // Copy
            async copyPlan() {
                let vm = this;
                if (Object.keys(vm.beginOnhandQtyChangeData).length > 0 || Object.keys(vm.totalPlanChangeData).length > 0) {
                    swal({
                        title: 'อนุมัติประมาณการผลิตประจำปี',
                        text: '<span style="font-size: 16px; text-align: left;"> ไม่สามารถทำการอนุมัติประมาณการผลิตประจำปี เนื่องจากมีรายการที่แก้ไขอยู่ กรุณาตรวจสอบ </span>',
                        type: "warning",
                        html: true
                    });
                    return;
                }
                vm.loading.copyProcess = true;
                await axios
                .patch(vm.url.ajax_copy_plan)
                .then(res => {
                    if (res.data.data.status == 'S') {
                        swal({
                            title: 'คัดลอกแผนประมาณการผลิตประจำปักษ์',
                            text: '<span style="font-size: 16px; text-align: left;"> คัดลอกแผนประมาณการผลิตประจำปีเรียบร้อย </span>',
                            type: "success",
                            html: true
                        });
                        // window.open(res.data.data.redirect_show_page, '_blank');
                        window.location.href = res.data.data.redirect_show_page;
                    }else{
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
                    vm.loading.copyProcess = false;
                });
            },
            summaryTotalPlaning(res){
                this.summaryPlanning = res;
            },
        }
    }
</script>