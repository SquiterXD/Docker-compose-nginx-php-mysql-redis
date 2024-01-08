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
                                        <!-- {{ followUp.pp_bi_weekly.biweekly }} -->
                                        <div v-if="followUp">
                                            {{ followUp.pp_bi_weekly.thai_year }}
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
                                        <div v-if="followUp">
                                            {{ followUp.pp_bi_weekly.biweekly }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                            <dl class="row mb-0">
                                <div class="col-sm-4 pl-0 text-sm-right">
                                    <!-- <dt>ส่งข้อมูลครั้งที่:</dt> -->
                                    <dt>ครั้งที่อนุมัติ:</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="followUp">
                                            {{ data.approve_no }}
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
                                        <div v-if="followUp">
                                            {{ followUp.pp_bi_weekly.thai_combine_date }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                            <dl class="row mb-0">
                                <div class="col-sm-4 pl-0 text-sm-right">
                                    <dt>ปรับครั้งที่:</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="followUp">
                                            {{ data.adjust_no }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                        </div>
                        <div class="col-lg-6" id="cluster_info">
                            <dl class="row mb-0">
                                <div class="col-sm-5  pl-0 text-sm-right">
                                    <dt>
                                        วันที่ผลิต:
                                    </dt>
                                </div>
                                <div class="col-sm-7 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="followUp">
                                            {{ product? product.previous_date_format: '' }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                            <dl class="row mb-0">
                                <div class="col-sm-5  pl-0 text-sm-right">
                                    <dt>
                                        คงคลังเช้า ณ วันที่:
                                    </dt>
                                </div>
                                <div class="col-sm-7 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="followUp">
                                            {{ product? product.as_of_date_format: '' }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                            <dl class="row mb-0">
                                <div class="col-sm-5  pl-0 text-sm-right">
                                    <dt>
                                        จำนวนวันขาย:
                                    </dt>
                                </div>
                                <div class="col-sm-7 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="followUp">
                                            {{ followUp.day_for_sale }} วัน
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                            <dl class="row mb-0">
                                <div class="col-sm-5  pl-0 text-sm-right">
                                    <dt>
                                        คงเหลือวันขาย:
                                    </dt>
                                </div>
                                <div class="col-sm-7 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="followUp">
                                            {{ product? product.remain_sale_day: 0 }} วัน
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
                                    <dt title="">วันที่ปัจจุบัน:</dt>
                                </div>
                                <div class="col-sm-6 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="followUp">
                                            {{ followUp.sysdate_format }}
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
<!-- as_of_date_format -->
<script>
    export default {
        props:[
            "followUp", "btnTrans", "canEdit", "url", "data"
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
                oldNote: this.followUp['note'],
                product: this.followUp.products[0],
                note: this.followUp['note'],
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

                //     vm.$set(vm.followUp, 'note', '');
                //     vm.$set(vm.followUp, 'note', vm.note);
                //     // vm.note = vm.followUp['note'];
                //     console.log('update',  vm.followUp['note'] = vm.note,  vm.followUp['note'],  vm.note)
                // }
            }
        },
        watch:{
            // showSaveNote(newValue) {
            //     return newValue
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