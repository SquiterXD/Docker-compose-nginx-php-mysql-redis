<template>
    <div class="">
        <form id="production-plan-form" action="">
            <div class="row">
                <div class="col-8 b-r">
                    <div class="row">
                        <div class="col-lg-3">
                            <dl class="row mb-0">
                                <div class="col-sm-7 pl-0 text-sm-right pl-0 pr-0">
                                    <dt>ปีงบประมาณ:</dt>
                                </div>
                                <div class="col-sm-5 text-sm-left">
                                    <dd class="mb-1">
                                        <!-- {{ adjustData.pp_bi_weekly.biweekly }} -->
                                        <div v-if="header && header.pp_period">
                                            {{ header.pp_period.period_year_thai }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <div class="col-lg-3">
                            <dl class="row mb-0">
                                <div class="col-sm-5 pl-0 text-sm-right pl-0 pr-0">
                                    <dt>ประจำเดือน:</dt>
                                </div>
                                <div class="col-sm-7 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="header && header.pp_period">
                                            {{ header.pp_period.thai_month }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <div class="col-lg-2">
                            <dl class="row mb-0">
                                <div class="col-sm-7 pl-0 text-sm-right pl-0 pr-0">
                                    <dt>ครั้งที่:</dt>
                                </div>
                                <div class="col-sm-5 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="header">
                                            {{ header.version_no }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <div class="col-lg-4">
                            <dl class="row mb-0">
                                <div class="col-sm-8 pl-0 text-sm-right pl-0 pr-0">
                                    <dt>ครั้งที่อนุมัติ:</dt>
                                </div>
                                <div class="col-sm-4 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="header">
                                            {{ header.approved_no }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="row">
                        <div class="col-lg-12">
                            <dl class="row mb-0">
                                <div class="col-sm-6 text-sm-right">
                                    <dt>วันที่สร้าง:</dt>
                                </div>
                                <div class="col-sm-6 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="header">
                                            {{ header.creation_date_format }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>


                            <!-- <dl class="row mb-0">
                                <div class="col-sm-6 text-sm-right">
                                    <dt title="as_of_date">วันที่สร้างแผน :</dt>
                                </div>
                                <div class="col-sm-6 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="header">
                                            {{ header.as_of_date_format }}
                                        </div>
                                    </dd>
                                </div>
                            </dl> -->

                            <dl class="row mb-0">
                                <div class="col-sm-6 text-sm-right">
                                    <dt title="">วันที่แก้ไขล่าสุด:</dt>
                                </div>
                                <div class="col-sm-6 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="header">
                                            {{ header.last_update_date_format }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>

                            <dl class="row mb-0">
                                <div class="col-sm-6 text-sm-right">
                                    <dt>สถานะ:</dt>
                                </div>
                                <div class="col-sm-6 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="header_p08">
                                            <span v-if="!status_flag" v-html="header_p08.status_lable_html"></span>
                                            <template v-if="canApprove">
                                                <button v-if="!status_flag" type="button" class="btn btn-xs btn-primary" @click="editStatus()">
                                                    <i class="fa fa-pencil-square"></i>
                                                </button>

                                                <el-select v-if="status_flag" v-model="header_p08.approved_status" size="small" placeholder="สถานะ" filterable>
                                                    <el-option
                                                       v-for="status in statusLists"
                                                        :key="status.label"
                                                        :label="status.label"
                                                        :value="status.value"
                                                    >
                                                    </el-option>
                                                </el-select>
                                                <div class="text-right mt-2">
                                                    <button v-if="status_flag" type="button" class="btn btn-xs btn-success" @click="saveStatus()">
                                                        <i class="fa fa-check-square"></i>
                                                    </button>
                                                    <button v-if="status_flag" type="button" class="btn btn-xs btn-danger" @click="cancleStatus()">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                            </template>
                                        </div>
                                    </dd>
                                </div>
                            </dl>

                            <dl class="row mb-0">
                                <div class="col-sm-6 text-sm-right">
                                    <dt>ผู้บันทึก:</dt>
                                </div>
                                <div class="col-sm-6 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="header">
                                            {{ header.updated_by ? header.updated_by.name : '-' }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                            <dl class="row mb-0">
                                <div class="col-sm-6 text-sm-right">
                                    <dt>วันที่อนุมัติ:</dt>
                                </div>
                                <div class="col-sm-6 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="header_p08">
                                            <span v-if="!status_flag"> {{ header_p08.approved_at_format }} </span>

                                            <datepicker-th v-if="status_flag"
                                                style="width: 100%"
                                                class="form-control md:tw-mb-0 tw-mb-2 approve_date"
                                                id="approved_at"
                                                placeholder="โปรดเลือกวันที่"
                                                :value=" header_p08.approve_date_format"
                                                v-model=" header_p08.approved_at_format"
                                                format="DD/MM/YYYY"
                                                @dateWasSelected="dateOrderFrom"
                                            />
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import moment from "moment";
    export default {
        props:[
            "header", "btnTrans", "canEdit", "url"
        ],
        data() {
            return {
                statusLists: [{
                        value: 'Approve',
                        label: 'Approve'
                    }, {
                        value: 'Inactive',
                        label: 'Inactive'
                    }],
                oldNote: this.adjustData ? this.adjustData['note'] : '',
                note: this.adjustData ? this.adjustData['note'] : '',
                loading: false,
                status_flag: false,
                header_p08: this.header,
                canApprove: this.header.can.approve,
            }
        },
        methods: {
            async updateNoteForm() {
                let vm = this;
                swal({
                    title: 'อัพเดทหมายเหตุ',
                    text: 'ยืนยันอัพเดทหมายเหตุ ?',
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
                        vm.update();
                    }
                });
            },
            async update() {
                let vm = this;
                let isSuccess = false;
                vm.loading = true;
                await axios.patch(vm.url.ajax_update_note)
                .then(res => {
                    if (res.data.data.status == 'S') {
                        isSuccess = true;
                        swal({
                            title: 'อัพเดทหมายเหตุ',
                            text: '<span style="font-size: 16px; text-align: left;"> อัพเดทหมายเหตุเรียบร้อย </span>',
                            type: "success",
                            html: true
                        });
                        vm.oldNote = vm.note;
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
                    vm.loading = false;
                    // swal.close();
                });

                // if (isSuccess) {

                //     vm.$set(vm.adjustData, 'note', '');
                //     vm.$set(vm.adjustData, 'note', vm.note);
                //     // vm.note = vm.adjustData['note'];
                //     console.log('update',  vm.adjustData['note'] = vm.note,  vm.adjustData['note'],  vm.note)
                // }
            },
            dateOrderFrom(date){
                this.header_p08.approved_date = date? moment(date).format('DD-MM-YYYY'): '';
            },
            editStatus(){
                this.status_flag = true;
            },
            cancleStatus(){
                this.status_flag = false;
            },
            async saveStatus(){
                let vm = this;
                vm.loading = true;
                await axios.post(vm.url.ajax_update_status,{
                    header: vm.header_p08
                })
                .then(res => {
                    if (res.data.data.status == 'S') {
                        swal({
                            title: 'อัพเดทประมาณการจัดซื้อแสตมป์รายเดือน',
                            text: '<span style="font-size: 16px; text-align: left;"> อัพเดทประมาณการจัดซื้อแสตมป์รายเดือนเรียบร้อย </span>',
                            type: "success",
                            html: true
                        });
                        vm.header_p08 = res.data.data.header;
                        vm.status_flag = false;
                        vm.canApprove = vm.header_p08.can.approve;
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
                    vm.loading = false;
                });
            },
        },
        watch:{
            // canEdit(newValue) {
            //     this.canEdit = newValue;
            // }
        },
        computed: {
            showSaveNote(){
                if (this.note != this.oldNote) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }
</script>