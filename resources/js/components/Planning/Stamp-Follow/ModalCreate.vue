<template>
    <span>
        <button type="button" @click="openModal" :class="btnTrans.create.class + ' btn-lg tw-w-25'" >
            <i :class="btnTrans.create.icon"></i>
            {{ btnTrans.create.text }}
        </button>

        <div class="modal fade" id="modal_create" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg" >
                <div class="modal-content" v-loading="loading">
                    <div class="modal-header">
                        <h3 style="font-size:22px; font-weight:400;" class="modal-title text-left">
                            สร้างการติดตามการใช้งานแสตมป์รายวัน
                        </h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row col-12 m-0">
                            <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> ปีงบประมาณ :</label>
                                <div class="input-group ">
                                    <el-select v-model="budgetYear" size="large" placeholder="ปีงบประมาณ" clearable filterable @change="getMonth" :popper-append-to-body="false">
                                        <el-option
                                           v-for="(year, index) in yearList"
                                            :key="index"
                                            :label="index"
                                            :value="index"
                                        >
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>

                            <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> ประมาณการใช้แสตมป์เดือน :</label>
                                <div class="input-group ">
                                    <el-select v-model="periodNo" size="large" placeholder="เดือน" clearable filterable :popper-append-to-body="false">
                                        <el-option
                                           v-for="(item, index) in monthList"
                                            :key="item.period_num"
                                            :label="item.thai_month"
                                            :value="item.period_num"
                                        >
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group pl-2 pr-2 mb-0 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label class=" tw-font-bold tw-uppercase mt-1">&nbsp;<br></label>
                            <div class="text-right">
                                <button type="button" :disabled="!periodNo" @click.prevent="submit()" :class="btnTrans.create.class + ' btn-md tw-w-25'" >
                                    <i :class="btnTrans.create.icon"></i>
                                    {{ btnTrans.create.text }}
                                </button>
                                <button type="button" class="btn btn-white btn-md tw-w-25" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </span>
</template>
<script>
    export default {
        props:["btnTrans", "url", "createInput"],
        data() {
            return {
                loading: false,
                loadingVerNo: false,
                yearList: this.createInput.year_list,
                monthList: this.createInput.month_list,
                budgetYear: this.createInput.def_period_year,
                periodNo: this.createInput.def_period_no,
                thaiMonth: '',
            }
        },
        mounted() {
            //
        },
        computed: {
            //
        },
        watch:{
            //
        },
        methods: {
            async openModal() {
                $('#modal_create').modal('show');
            },
            submit() {
                let vm = this;
                vm.loading = true;
                axios.post(vm.url.ajax_validate, {
                    budget_year: vm.budgetYear,
                    period_no: vm.periodNo,
                })
                .then(res => {
                    if (res.data.data.status == 'W') {
                        swal({
                            html: true,
                            title: 'สร้างข้อมูลการติดตามการใช้แสตมป์รายวัน',
                            text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> มีข้อมูลการติดตามการใช้แสตมป์รายวันอยู่แล้ว ต้องการอัพเดตข้อมูลหรือไม่ ? </span></h2>',
                            showCancelButton: true,
                            confirmButtonText: vm.btnTrans.ok.text,
                            cancelButtonText: vm.btnTrans.cancel.text,
                            confirmButtonClass: vm.btnTrans.ok.class + ' btn-lg tw-w-25',
                            cancelButtonClass: vm.btnTrans.cancel.class + ' btn-lg tw-w-25',
                            closeOnConfirm: false,
                            closeOnCancel: true,
                            showLoaderOnConfirm: true
                        },
                        function(isConfirm){
                            if (isConfirm) {
                                vm.create();
                            }
                            vm.loading = false;
                        });
                    }else if(res.data.data.status == 'E'){
                        swal({
                            title: 'มีข้อผิดพลาด',
                            text: '<span style="font-size: 15px; text-align: left;">'+res.data.data.msg+'</span>',
                            type: "warning",
                            html: true
                        });
                    }else{
                        vm.create();
                    }
                })
                .catch(err => {
                })
                .then(() => {
                    vm.loading = false;
                });
            },
            create() {
                let vm = this;
                vm.loading = true;
                axios.post(vm.url.ajax_store, {
                    budget_year: vm.budgetYear,
                    period_no: vm.periodNo,
                })
                .then(res => {
                    if(res.data.data.status == 'S'){
                        swal({
                            title: 'สร้างข้อมูลการติดตามการใช้แสตมป์รายวัน',
                            text: '<span style="font-size: 15px; text-align: left;">'+res.data.data.msg+'</span>',
                            type: "success",
                            html: true
                        });
                        window.setTimeout(function() {
                            window.location.href = res.data.data.redirect_page;
                        }, 500);
                    }else{
                        swal({
                            title: 'มีข้อผิดพลาด',
                            text: '<span style="font-size: 15px; text-align: left;">'+res.data.data.msg+'</span>',
                            type: "warning",
                            html: true
                        });
                    }
                })
                .catch(err => {
                })
                .then(() => {
                    vm.loading = false;
                });
            },
            async getDetail() {
                let vm = this;
                if (!vm.budgetYear && !vm.periodNo) { return; }
                vm.loadingVerNo = true;
                axios.get(vm.url.ajax_modal_create_details, { params : {
                    period_no: vm.periodNo,
                }}).then(res => {
                    let response = res.data.data;
                    vm.versionNo = response.version_no;
                    vm.loadingVerNo = false;
                });
            },
            getMonth(){
                this.periodNo = '';
                this.thaiMonth = '';
            }
        }
    }
</script>