<template>
    <div class="">
        <form id="production-plan-form" action="">
            <div class="row">
                <div class="col-8 b-r">
                    <div class="row">
                        <div class="col-lg-6">
                            <dl class="row mb-0">
                                <div class="col-sm-4 pl-0 text-sm-right">
                                    <dt>ปีงบประมาณ:</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1">
                                        <!-- {{ adjustData.pp_bi_weekly.biweekly }} -->
                                        <div v-if="adjustData">
                                            {{ adjustData.pp_bi_weekly.period_year_thai }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                            <dl class="row mb-0">
                                <div class="col-sm-4 pl-0 text-sm-right">
                                    <dt>ปักษ์ที่:</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="adjustData">
                                            {{ adjustData.biweekly }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                            <dl class="row mb-0">
                                <div class="col-sm-4 pl-0 text-sm-right">
                                    <dt>ครั้งที่:</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="adjustData">
                                            {{ adjustData.version_no }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                            <dl class="row mb-0">
                                <div class="col-sm-4 pl-0 text-sm-right">
                                    <dt>ประจำเดือน:</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="adjustData">
                                            {{ adjustData.pt_biweekly.pp_month }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                            <dl class="row mb-0">
                                <div class="col-sm-4 pl-0 text-sm-right">
                                    <dt>ประจำวันที่:</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="adjustData">
                                            {{ adjustData.pp_bi_weekly.thai_combine_date }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                            <dl class="row mb-0">
                                <div class="col-sm-4 pl-0 text-sm-right">
                                    <dt>ส่งข้อมูลครั้งที่:</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1 text-danger">
                                        <!-- <div v-if="adjustData">
                                            {{ adjustData.pp_bi_weekly.thai_combine_date }}
                                        </div> -->
                                    </dd>
                                </div>
                            </dl>

                        </div>
                        <div class="col-lg-6" id="cluster_info">
                            <dl class="row mb-0">
                                <div class="col-sm-3  pl-0 text-sm-right">
                                    <dt>
                                        ปรับครั้งที่:
                                    </dt>
                                </div>
                                <div class="col-sm-9 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="adjustData">
                                            {{ adjustData.adjust_no }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>

                            <dl class="row mb-0">
                                <div class="col-sm-3  pl-0 text-sm-right">
                                    <dt>
                                        หมายเหตุ:
                                    </dt>
                                </div>
                                <div class="col-sm-9 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="adjustData">
                                            <el-input :disabled="!canEdit"
                                                type="textarea"
                                                class="required"
                                                name="note"
                                                v-model="note"
                                                rows="4"
                                                maxlength="240"
                                                show-word-limit
                                                />

                                            <transition
                                                enter-active-class="animated fadeInUp"
                                                leave-active-class="animated fadeOutDown">
                                                <div class="text-right mt-2" v-if="showSaveNote">
                                                    <button @click="updateNoteForm" type="button" :class="btnTrans.save.class + ' btn-sm tw-w-25'" >
                                                        <i :class="btnTrans.save.icon"></i>
                                                        {{ btnTrans.save.text }}
                                                    </button>

                                                    <button  @click="note = oldNote" type="button" :class="btnTrans.cancel.class + ' btn-sm tw-w-25'" >
                                                        <i :class="btnTrans.cancel.icon"></i>
                                                        {{ btnTrans.cancel.text }}
                                                    </button>
                                                </div>
                                            </transition>
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
                                        <div v-if="adjustData">
                                            {{ adjustData.creation_date_format }}
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
                                        <div v-if="adjustData">
                                            {{ adjustData.as_of_date_format }}
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
                                        <div v-if="adjustData">
                                            {{ adjustData.last_update_date_format }}
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
                                        <div v-if="adjustData">
                                            <span v-html="adjustData.status_lable_html"></span>
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
                                        <div v-if="adjustData">
                                            {{ adjustData.updated_by ? adjustData.updated_by.name : '-' }}
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
                                        <div v-if="adjustData">
                                            {{ adjustData.approved_at_format }}
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
    export default {
        props:[
            "adjustData", "btnTrans", "canEdit", "url"
        ],
        data() {
            return {
                statusLists: [{
                        value: 'Active',
                        label: 'Active'
                    }, {
                        value: 'Inactive',
                        label: 'Inactive'
                    }],
                oldNote: this.adjustData ? this.adjustData['note'] : '',
                note: this.adjustData ? this.adjustData['note'] : '',
                loading: false,
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
            }
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