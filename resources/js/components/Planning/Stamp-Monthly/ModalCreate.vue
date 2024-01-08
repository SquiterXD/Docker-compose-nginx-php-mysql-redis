<template>
    <span>
        <button type="button" @click="openModal" :class="btnTrans.create.class + ' btn-lg tw-w-25'" >
            <i :class="btnTrans.create.icon"></i>
            {{ btnTrans.create.text }}
        </button>

        <div class="modal inmodal fade" id="modal_create" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg" >
                <div class="modal-content" v-loading="loading">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">สร้างประมาณการจัดซื้อแสตมป์รายตรา</h4>
                        <small class="font-bold">
                            &nbsp;
                        </small>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row col-12">
                            <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> ปีงบประมาณ :</label>
                                <div class="input-group ">
                                    <el-select v-model="budgetYear" size="large" placeholder="ปีงบประมาณ"  clearable filterable :popper-append-to-body="false">
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
                                    <el-select v-model="periodNo" size="large" placeholder="เดือน"  clearable filterable :popper-append-to-body="false">
                                        <el-option
                                           v-for="(item, index) in yearList[budgetYear]"
                                            :key="item.period_no"
                                            :label="item.thai_month"
                                            :value="item.period_no"
                                        >
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>

                            <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2" v-loading="loadingVerNo">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> ครั้งที่ :</label>
                                <div class="">
                                    <el-input  :value="versionNo" size="large" :readonly="true"> </el-input>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                        <button type="button" :disabled="!periodNo"  @click.prevent="submit()" :class="btnTrans.create.class + ' btn-lg tw-w-25'" >
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
        props:["btnTrans", "url", "createInput"],
        data() {
            return {
                loading: false,
                loadingVerNo: false,
                yearList: this.createInput.year_list,
                budgetYear: this.createInput.def_period_year,
                periodNo: this.createInput.def_period_no,
                versionNo: '',
            }
        },
        mounted() {
            // if (this.budget_year) {
            //     this.getBiweekly();
            // }
        },
        computed: {
        },
        watch:{
            budgetYear : async function (value, oldValue) {
                this.periodNo = '';
            },
            periodNo : async function (value, oldValue) {
                this.versionNo = '';
                if (value) {
                    this.getDetail();
                }
            },
        },
        methods: {
            async openModal() {
                await this.getDetail();
                $('#modal_create').modal('show');
            },
            submit() {
                let vm = this;
                vm.loading = true;
                axios.post(vm.url.ajax_store, {
                    period_no: vm.periodNo,
                    version_no: vm.versionNo,
                })
                .then(res => {
                    window.location.href = res.data.data.redirect_page;
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
                            budget_year: vm.budget_year,
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
        }
    }
</script>