<template>
    <span>
        <template v-if="!validReport">
            <a :href="url.ajax_print_report_pr+'?pr_number='+line.pr_number" target="_blank"
                type="button" :class="btnTrans.print.class + ' btn-sm'">
                <i :class="btnTrans.print.icon"></i> พิมพ์รายงาน
            </a>
        </template>
        <template v-else>
            <a type="button" :class="btnTrans.print.class + ' btn-sm'" style="color: white;" disabled>
                <i :class="btnTrans.print.icon"></i> พิมพ์รายงาน
            </a>
        </template>

        <button type="button" :class="btnTrans.cancel.class + ' btn-sm'" @click="cancelPRModal()" :disabled="valid">
            <i :class="btnTrans.cancel.icon"></i> {{ btnTrans.cancel.text }}
        </button>

        <!-- Cancelled Reason -->
        <div class="modal fade" :id="'modal_cancel_pr'+index" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" v-loading="loading">
                    <div class="modal-header">
                        <h3 style="font-size:22px; font-weight:400;" class="modal-title text-left">
                            เหตุผลการยกเลิก
                        </h3>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    </div>
                    <div class="modal-body text-left">
                        <form :id="'cancel-pr-form'+index">
                            <div class="row col-12 m-0">
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
                                    <label class="tw-font-bold tw-uppercase mb-1"> เหตุผลการยกเลิก :</label>
                                    <div class="input-group mb-2">
                                        <el-input ref="cancelled_reason"
                                            type="textarea"
                                            :rows="3"
                                            placeholder="เหตุผลการยกเลิก"
                                            v-model="cancelled_reason">
                                        </el-input>
                                    </div>
                                    <div :id="'el_explode_cancelled_reason'+index" class="error_msg text-left"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer p-2" style="justify-content: right !important;">
                        <button type="button" @click.prevent="cancelInterfacePR()" :class="btnTrans.create.class + ' btn-lg tw-w-25'" >
                            ตกลง
                        </button>
                        <button type="button" class="btn btn-white btn-lg tw-w-25'" data-dismiss="modal"> ยกเลิก </button>
                    </div>
                </div>
            </div>
        </div>
    </span>
</template>

<script>
    import moment from "moment";
    export default {
        props:[
            'index', 'header', 'line', 'poLists', 'btnTrans', 'url'
        ],
        data() {
            return {
                loading: false,
                valid: false,
                validReport: false,
                cancelled_reason: '',
                errors: {
                    cancelled_reason: false,
                },
            }
        },
        mounted() {
            this.checkPRPOTransaction();
        },
        watch:{
            errors: {
                handler(val){
                    val.cancelled_reason? this.setError('cancelled_reason') : this.resetError('cancelled_reason');
                },
                deep: true,
            },
            'line': function(newValue) {
                this.checkPRPOTransaction();
            },
        },
        methods: {
            cancelPRModal(){
                this.cancelled_reason = '';
                $('#modal_cancel_pr'+this.index).modal('show');
            },
            checkPRPOTransaction(){
                let vm = this;
                vm.valid = false;
                vm.validReport = false;
                if (vm.line.pr_number == '' || vm.line.pr_number == null) {
                    vm.valid = true;
                    vm.validReport = true;
                    console.log('2222-----'+vm.validReport);
                }else if (vm.line.authorization_status == 'Cancelled') {
                    vm.valid = true;
                    vm.validReport = true;
                    console.log(vm.validReport);
                }

                vm.poLists.filter(function(po, index){
                    if (po.po_number != null) {
                        if (po.pr_number == vm.line.pr_number) {
                            if (po.po_number != '' || po.po_number != null || vm.line.pr_number == null) {
                                vm.valid = true;
                                console.log(vm.validReport);
                            }
                        }
                    }
                });
            },
            async cancelInterfacePR() {
                let vm = this;
                let form = $("#cancel-pr-form"+vm.index);
                var valid = true;
                var msg = '';
                vm.errors.cancelled_reason = false;
                $("div[id=el_explode_cancelled_reason"+vm.index+"]").html("");
                // Validate input
                if (vm.cancelled_reason == '') {
                    vm.errors.cancelled_reason = true;
                    valid = false;
                    msg = "กรุณาระบุเหตุผลขอการยกเลิก";
                    $("div[id=el_explode_cancelled_reason"+vm.index+"]").html(msg);
                }
                if (!valid) {
                    return;
                }
                // isPass -----------------------------------------------------------
                let swalConfirm = swal({
                    html: true,
                    title: '<span style="font-size: 22px"><strong> ยกเลิกรายการ PR </strong></span>',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 17px"> คุณต้องการยกเลิกรายการ PR นี้หรือไม่ ? </span></h2>',
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
                        vm.loading = true;
                        await axios
                        .post(vm.url.ajax_cancel_interface_pr,{
                            pr_number: vm.line.pr_number,
                            cancelled_reason: vm.cancelled_reason
                        })
                        .then(res => {
                            if (res.data.status == 'S') {
                                vm.$emit("updateInterfacePR", {interfaceTemps: res.data.interfaceTemps, poLists: res.data.poLists});
                                // vm.valid = true;
                                // vm.validReport = true;
                                swal({
                                    title: 'ยกเลิกรายการ PR',
                                    text: '<span style="font-size: 16px; text-align: left;">'+res.data.msg+'</span>',
                                    type: "success",
                                    html: true
                                });
                            }else{
                                swal({
                                    title: 'มีข้อผิดพลาด',
                                    text: '<span style="font-size: 15px; text-align: left;">'+res.data.msg+'</span>',
                                    type: "warning",
                                    html: true
                                });
                            }
                        })
                        .catch(err => {
                            swal({
                                title: 'มีข้อผิดพลาด',
                                text: '<span style="font-size: 15px; text-align: left;">'+err.response+'</span>',
                                type: "warning",
                                html: true
                            });
                        })
                        .then(() => {
                            $('#modal_cancel_pr'+vm.index).modal('hide');
                            vm.loading = false;
                        });
                    }
                });
            },
            setError(ref_name){
                let ref = this.$refs[ref_name].$refs.reference 
                        ? this.$refs[ref_name].$refs.reference.$refs.input 
                        : (this.$refs[ref_name].$refs.textarea 
                            ? this.$refs[ref_name].$refs.textarea 
                            : (this.$refs[ref_name].$refs.input.$refs 
                                ? this.$refs[ref_name].$refs.input.$refs.input 
                                : this.$refs[ref_name].$refs.input ));
                ref.style = "border: 1px solid red;";
            },
            resetError(ref_name){
                let ref = this.$refs[ref_name].$refs.reference 
                        ? this.$refs[ref_name].$refs.reference.$refs.input 
                        : (this.$refs[ref_name].$refs.textarea 
                            ? this.$refs[ref_name].$refs.textarea
                            : (this.$refs[ref_name].$refs.input.$refs 
                                ? this.$refs[ref_name].$refs.input.$refs.input 
                                : this.$refs[ref_name].$refs.input ));
                ref.style = "";
            },
            errorRef(res){
                var vm = this;
                vm.errors.start_date = res.err.start_date;
                vm.errors.end_date = res.err.end_date;
                vm.errors.machine_group = res.err.machine_group;
            }
        },
    }
</script>