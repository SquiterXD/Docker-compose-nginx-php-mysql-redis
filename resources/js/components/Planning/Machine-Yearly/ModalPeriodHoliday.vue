<template>
    <span>
        <button :class="btnTrans.holidayP01.class + ' btn-lg tw-w-25'" @click="">
            <i :class="btnTrans.holidayP01.icon"></i> {{ btnTrans.holidayP01.text }}
        </button>
        <div id="modal-period-holiday" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg" style="width: 90%; max-width:980px;">
                <div class="modal-content" v-loading="loading">
                    <div class="modal-header">
                        <h3 style="font-size:24px; font-weight:400;" class="modal-title text-left">
                            วันหยุดประจำปีงบประมาณ
                        </h3>
                        <button type="button" class="close" data-dismiss="modal" @click.prevent="cancel()"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    </div>
                    <div class="modal-body text-left">
                        <form id="period-holiday-form">
                            <!-- header -->
                            <div class="row col-lg-12 m-2 pl-1" v-if="show_flag && header">
                                <div class="col-md-12 text-left">
                                    <div class="form-group pl-2 pr-2 mb-0 col-lg-10 col-md-10 col-sm-6 col-xs-6 mt-2 text-right text-danger">
                                        <label class="tw-font-bold tw-uppercase mb-1">
                                            ดึงข้อมูลล่าสุดวันที่ : <!-- {{ msgPercent }} -->
                                        </label>
                                    </div>
                                    <button :class="btnTrans.holidayP01.class + ' btn-lg tw-w-25'" @click="">
                                        <i :class="btnTrans.holidayP01.icon"></i> {{ btnTrans.holidayP01.text }}
                                    </button>
                                </div>
                            </div>

                            <!-- v-html -->
                            <!-- <div v-html="html"></div> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </span>
</template>

<script>
    import moment from "moment";
    import uuidv1 from 'uuid/v1';
    import MachineList from './MachineList.vue';
    export default {
        components: {
            MachineList
        },
        props:['html', 'machineGroups'],
        data() {
            return {
                loading: false,
                vHtmlData: '',
                updatedDate: '',
            }
        },
        mounted() {
            // this.getDateByYearly();
            // if (this.machineDtLines) {
            //     this.filterMachineLine();
            // }
        },
        methods: {
            // New Requirement 05042022
            openModal() {
                $('#modal-period-holiday').modal('show');
            },
            async submit(){
                let vm = this;
                let form = $('#period-holiday-form');
                var valid = true;
                var msg = '';
                vm.loading = true;

                let res = await this.create();
                console.log(res);
                if(res.status == 'S'){
                    //return vHtml
                }else{
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">'+res.msg+'</span>',
                        type: "error",
                        html: true
                    });
                }
            },
            async create() {
                let vm = this;
                let data = {
                    status: '',
                    msg: ''
                };
                let params = {
                    header: vm.header,
                    machineLines: vm.machineLines,
                    removeMachineDt: vm.removeMachineDt
                };
                await axios
                .post(vm.url.machine_downtime, params)
                .then(res => {
                    data.status = res.data.status;
                    data.msg = res.data.msg;
                    data.redirect_show_page = res.data.redirect_show_page;
                })
                .catch(err => {
                    let msg = err.response.data.data;
                    data.status = 'E'
                    data.msg = msg;
                })
                .then(() => {
                    vm.loading = false;
                });
                return data;
            },
        }
    }
</script>