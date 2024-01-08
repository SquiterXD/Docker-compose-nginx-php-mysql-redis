<template>
    <span>
        <button type="button" @click="openModal" :class="btnTrans.create.class + ' btn-lg tw-w-25'" >
            <i :class="btnTrans.create.icon"></i>
            {{ btnTrans.create.text }}ปรับแผน
        </button>

        <div class="modal inmodal fade" id="modal_create" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width: 90%; max-width:950px;">
                <div class="modal-content" v-loading="loading">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">ปรับแผนประมาณการผลิต</h4>
                        <small class="font-bold">
                            &nbsp;
                        </small>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row col-12">
                            <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> ปีงบประมาณ :</label>
                                <div class="input-group ">
                                    <el-input :value="modalCreateInput.pp04.period_year_thai" size="large" :readonly="true"> </el-input>
                                </div>
                            </div>

                            <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> ปักษ์ปัจจุบันที่ :</label>
                                <div class="">
                                    <el-input :value="modalCreateInput.pp04.biweekly" size="large" :readonly="true"> </el-input>
                                </div>
                            </div>

                            <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> ปรับครั้งที่ :</label>
                                <div class="">
                                    <el-input :value="modalCreateInput.pp04.adjust_no" size="large" :readonly="true"> </el-input>
                                </div>
                            </div>

                            <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> ประจำเดือน :</label>
                                <div class="">
                                    <el-input :value="modalCreateInput.pp04.thai_month" size="large" :readonly="true"> </el-input>
                                </div>
                            </div>
                        </div>
                        <div v-html="html"></div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                        <button type="button"  @click.prevent="submit()" :class="btnTrans.create.class + ' btn-lg tw-w-25'" >
                            <i :class="btnTrans.create.icon"></i>
                            {{ btnTrans.create.text }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </span>
</template>
<script>
    export default {
        props:["btnTrans", "url", "modalCreateInput"],
        data() {
            return {
                loading: false,
                html: ''
            }
        },
        mounted() {
            // if (this.period_year_thai) {
            //     this.getBiweekly();
            // }
        },
        computed: {
        },
        watch:{
            // errors: {
            //     handler(val){
            //         val.period_year_thai? this.setError('period_year_thai') : this.resetError('period_year_thai');
            //         val.biweekly? this.setError('biweekly') : this.resetError('biweekly');
            //     },
            //     deep: true,
            // },
        },
        methods: {
            openModal() {
                $('#modal_create').modal('show');
            },
            submit() {
                let vm = this;
                vm.loading = true;
                axios.post(vm.url.adjusts_store, {
                    product_main_id: vm.modalCreateInput.pp04.product_main_id,
                })
                .then(res => {
                    swal({
                        title: 'สร้างข้อมูลปรับแผน',
                        text: '<span style="font-size: 16px; text-align: left;"> สร้างข้อมูลปรับแผนรายปักษ์สำเร็จแล้ว </span>',
                        type: "success",
                        html: true
                    });
                    window.location.href = res.data.data.redirect_show_page;
                })
                .catch(err => {
                })
                .then(() => {
                    vm.loading = false;
                });

            },
            async searchForm() {
                let vm = this;
                vm.loading = true;

                await axios.get(vm.url.ajax_adjusts_search_create, {
                        params: {
                            period_year_thai: vm.period_year_thai,
                            biweekly: vm.biweekly,
                            approved_status: vm.status
                        }
                    })
                    .then(res => {
                        vm.html = res.data.data.html
                    })
                    .catch(err => {
                        vm.html = '';
                        let data = err.response.data;
                        alert(data.message);
                    })
                    .then(() => {
                        vm.loading = false;
                    });
            },
            getBiweekly(){
                if (!this.search) {
                    this.biweekly = '';
                    this.month = '';
                    this.times = '';
                }
                this.biWeeklyLists = this.pBiweekly.filter(item => {
                    return item.thai_year.indexOf(this.period_year_thai) > -1;
                });
            },
        }
    }
</script>