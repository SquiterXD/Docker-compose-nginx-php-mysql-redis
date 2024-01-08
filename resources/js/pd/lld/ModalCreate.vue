<template>
    <span>
        <button type="button" @click="openModal" :class="btnTrans.create.class + ' btn-lg tw-w-25'" >
            <i :class="btnTrans.create.icon"></i>
            {{ btnTrans.create.text }}
        </button>

        <div class="modal inmodal fade" id="modal_create" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg" style=" padding-top: 1%;">
                <div class="modal-content" v-loading="loading">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">{{ menu.menu_title }}</h4>
                        <small class="font-bold">
                            &nbsp;
                        </small>
                    </div>
                    <div class="modal-body text-left">


                        <div class="row col-12">
                            <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> ปีงบประมาณ :</label>
                                <div class="input-group ">
                                    <el-select :popper-append-to-body="false" size="large" v-model="budgetYear" placeholder=""  clearable filterable>
                                        <el-option v-for="(year, key, index) in budgetYearList"
                                            :key="key"
                                            :label="key"
                                            :value="key"
                                        >
                                        </el-option>
                                    </el-select>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                        <button type="button" :disabled="!budgetYear"  @click.prevent="submit()" :class="btnTrans.create.class + ' btn-lg tw-w-25'" >
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
        props:["btnTrans", "url", "createInput", "menu"],
        data() {
            return {
                loading: false,
                loadingVerNo: false,
                // yearList: this.createInput.budget_year_list,
                budgetYearList: this.createInput.budget_year_version_list,
                budgetYear: '',
                budgetYeaVersion: '',
                adjVersionNo: '',
            }
        },
        mounted() {
            // if (this.budget_year) {
            //     this.getBiweekly();
            // }
            // this.openModal()
        },
        computed: {
        },
        watch:{
            // createInput : async function (value, oldValue) {
            //     this.yearList = this.createInput.budget_year_list;
            // },
            // budgetYeaVersion : async function (value, oldValue) {
            //     this.budgetYear = '';
            // },
            // budgetYear : async function (value, oldValue) {
            //     this.versionNo = '';
            //     this.adjVersionNo = '';
            //     if (value) {
            //         this.getDetail();
            //     }
            // },
            // budgetYear : async function (value, oldValue) {
            //     this.budgetYeaVersion = '';
            // },
            // budgetYeaVersion : async function (value, oldValue) {
            //     this.versionNo = '';
            //     this.adjVersionNo = '';
            //     if (value) {
            //         this.getDetail();
            //     }
            // },
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
                    budget_year: vm.budgetYear,
                })
                .then(res => {
                    let data = res.data.data;
                    if (data.status == 'S') {
                        $('#modal_create').modal('hide');
                        this.$emit("selectRow", data);
                        // window.location.href = data.redirect_page;
                    }

                    if (data.status != 'S') {
                        swal({
                            title: "Error !",
                            text: data.msg,
                            type: "error",
                            showConfirmButton: true
                        });
                    }
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
                if (!vm.budgetYear && !vm.budgetYeaVersion) { return; }
                vm.loadingVerNo = true;
                axios.get(vm.url.ajax_modal_create_details, { params : {
                    budget_year: vm.budgetYear,
                    budget_year_version: vm.budgetYeaVersion,
                }}).then(res => {
                    let response = res.data.data;
                    vm.adjVersionNo = response.adj_version_no;
                    vm.loadingVerNo = false;
                });
            },
        }
    }
</script>