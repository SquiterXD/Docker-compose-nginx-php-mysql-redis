<template>
    <div>
        <div class="form-group pl-2 pr-2 m-0 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
            <button type="button" @click.prevent="getStampDailyTab3" :class="btnTrans.upload.class + ' btn-lg tw-w-25'" >
                อัพเดตข้อมูลรายการ PR
            </button>
        </div>
        <div class="hr-line-dashed mt-3"></div>
        <div class="m-t-lg m-b-lg" v-if="loading">
            <div class="text-center sk-spinner sk-spinner-wave">
                <div class="sk-rect1"></div>
                <div class="sk-rect2"></div>
                <div class="sk-rect3"></div>
                <div class="sk-rect4"></div>
                <div class="sk-rect5"></div>
            </div>
        </div>
        <template v-else>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" style="vertical-align: middle; width: 8%;">
                               <div> วันที่ส่งข้อมูล </div> 
                            </th>
                            <th class="text-center" style="vertical-align: middle; width: 8%;">
                               <div> วันที่จัดซื้อ </div>
                            </th>
                            <th class="text-center" style="vertical-align: middle; width: 10%;">
                                <div> เลขที่รายการ PR </div>
                            </th>
                            <th class="text-center" style="vertical-align: middle; width: 10%;">
                                <div> สถานะรายการ PR </div>
                            </th>
                            <th class="text-center" style="vertical-align: middle; width: 10%;">
                                <div> เลขที่รายการ PO </div>
                            </th>
                            <!-- <th class="text-center" style="vertical-align: middle; width: 10%;">
                                <div> สถานะรายการ PO </div>
                            </th> -->
                            <th class="text-center" style="vertical-align: middle; width: 15%;">
                                <div> เหตุผลการยกเลิก PR </div>
                            </th>
                            <th class="text-center" style="vertical-align: middle; width: 15%;">
                                <div> ข้อผิดพลาดการส่งข้อมูล </div>
                            </th>
                            <th class="text-center" style="vertical-align: middle; width: 15%;">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-if="lines.length <= 0">
                            <tr>
                                <td colspan="8" class="text-center" style="vertical-align: middle;">
                                    <h2> ไม่พบข้อมูลที่ค้นหาในระบบ </h2>
                                </td>
                            </tr>
                        </template>
                        <template v-else>
                            <template v-for="(line, index) in lines">
                                <tr :key="index+'_'+line.pr_number">
                                    <td class="text-center">
                                        {{ line.pr_create_date_format }}
                                    </td>
                                    <td class="text-center">
                                        {{ line.need_by_date_format }}
                                    </td>
                                    <td class="text-center">
                                        {{ line.pr_number }}
                                    </td>
                                    <td class="text-center">
                                        <span v-html="line.status_lable_html"></span>
                                    </td>
                                    <td class="text-center">
                                        <template v-for="(po, index) in poMaps">
                                            <template v-if="line.pr_number == po.pr_number">
                                                <!-- <template v-if="poMaps.length > index+1">
                                                    {{ po.po_number }} ,
                                                </template>
                                                <template v-else> -->
                                                    {{ po.po_number }}
                                                <!-- </template> -->
                                            </template>
                                        </template>
                                    </td>
                                    <!-- <td class="text-center">
                                        <template v-for="(po, index) in poMaps">
                                            <template v-if="line.pr_number == po.pr_number">
                                                {{ poMaps[0].po_approval_status }}
                                            </template>
                                        </template>
                                    </td> -->
                                    <td class="text-left">
                                        {{ line.cancelled_reason_pr }}
                                    </td>
                                    <td class="text-left">
                                        {{ line.interface_msg? line.interface_msg+' กรุณาติดต่อทาง IT เพื่อทำการตรวจสอบเพิ่มเติม': '' }}
                                    </td>
                                    <td class="text-center">
                                        <submit-pr-transaction :key="index+line.pr_number"
                                            :index="index"
                                            :header="header"
                                            :line="line"
                                            :poLists="poLists"
                                            :btnTrans="btnTrans"
                                            :url="url"
                                            @updateInterfacePR="updateInterfacePR"
                                        />
                                    </td>
                                </tr>
                            </template>
                        </template>
                    </tbody>
                </table>
            </div>
        </template>
    </div>
</template>

<script>
    import moment from "moment";
    import SubmitPrTransaction from './SubmitPRTransaction.vue';
    export default {
        components: {
            SubmitPrTransaction
        },
        props:[
            'header', 'interfaceTemps', 'poLists', 'btnTrans', 'url'
        ],
        data() {
            return {
                loading: false,
                valid: false,
                lines: this.interfaceTemps,
                poMaps: this.poLists,
            }
        },
        mounted() {
            //
        },
        watch: {
            'interfaceTemps': function(newValue) {
                this.lines = newValue;
            },
            'poLists': function(newValue) {
                this.poMaps = newValue;
            },
        },
        methods: {
            // Get PR INTERFACE
            async getStampDailyTab3() {
                let vm = this;
                vm.summaryDataTab3 = [];
                vm.loading = true;
                await axios.get(vm.url.ajax_get_stamp_daily_tab3, {
                    params: {
                        follow_stamp_main_id: vm.header.follow_stamp_main_id,
                    }
                })
               .then(res => {
                    vm.lines = res.data.interfaceTemps;
                    vm.poMaps = res.data.poLists;
                })
                .catch(err => {
                    let data = err.response.data;
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 15px; text-align: left;">'+data.message+'</span>',
                        type: "warning",
                        html: true
                    });
                })
                .then(() => {
                    vm.loading = false;
                });
            },
            updateInterfacePR(res){
                this.lines = res.interfaceTemps
                this.poMaps = res.poLists
            }
        },
    }
</script>