<template>
    <span>
        <button type="button" :class="btnTrans.cancel.class + ' btn-lg tw-w-25'" @click.prevent="openModal()" :disabled="disableFlag">
                <i :class="btnTrans.cancel.icon"></i> {{ btnTrans.cancel.text }}การเคลมประกันภัย
            </button>

        <div class="modal fade" id="modal_cancel" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md">
                <div class="modal-content" v-loading="loading">
                    <div class="modal-header">
                        <h4 style="font-size:22px; font-weight:400;" class="modal-title text-left">
                            ยกเลิกการเคลมประกันภัย
                        </h4>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true"> &times; </span> <span class="sr-only"> Close </span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <form id="claim-form" onkeydown="return event.key != 'Enter';">
                            <div class="row col-12 m-0">
                                <div class="form-group pl-0 pr-2 mb-0 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2" >
                                    <div class="control-label mb-2" style="padding-right: 25px;">
                                        <strong> เหตุผลในการยกเลิก <span class="text-danger"> * </span> </strong>
                                    </div>
                                    <el-input type="textarea" :rows="4"
                                        name="reason"
                                        ref="reason"
                                        placeholder="เหตุผลในการยกเลิก"
                                        v-model="reason"
                                        size="medium"
                                        maxlength="250"
                                        show-word-limit>
                                    </el-input>
                                    <div id="el_explode_reason" class="error_msg text-left"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click.prevent="cancelClaim()" :class="btnTrans.confirm.class + ' btn-lg tw-w-25'">
                            {{ btnTrans.confirm.text }}
                        </button>
                        <button type="button" class="btn btn-danger btn-lg tw-w-25'" data-dismiss="modal"> ยกเลิก </button>
                    </div>
                </div>
            </div>
        </div>
    </span>
</template>
<script>
    import uuidv1 from 'uuid/v1';
    import moment from "moment";
    export default {
        props:['header', 'url', 'btnTrans', 'profile', 'disable'],
        data() {
            return {
                loading: false,
                disableFlag: this.disable,
                reason: this.header.cancelled_reason,
                errors: {
                    reason: false
                },
            }
        },
        mounted() {
            //
        },
        watch:{
            errors: {
                handler(val){
                     
                    val.reason? this.setError('reason') : this.resetError('reason');
                },
                deep: true,
            },
            disable: function(newValue) {
                this.disableFlag = newValue;
            },
        },
        methods: {
            openModal() {
                let vm = this;
                $('#modal_cancel').modal('show');
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
            async cancelClaim(){
                let vm = this;
                var form = $('#claim-form');
                if (vm.reason == ''){
                    vm.errors.reason = true;
                    valid = false;
                    errorMsg = "กรุณาระบุรายละเอียดเหตุการณ์";
                    $(form).find("div[id='el_explode_reason']").html(errorMsg);
                }
                vm.loading = true;
                let params = { reason: vm.reason };
                await axios
                .get(vm.url.ajax_cancel_claim, {params})
                .then(res => {
                    vm.loading = false;
                    if (res.data.data.status == 'S') {
                        vm.disableFlag = true;
                        vm.$emit("cancel", { disableFlag: vm.disableFlag, status: res.data.data.header.irp0011_status, reason: res.data.data.header.cancelled_reason });
                        swal({
                            title: 'ยกเลิกรายข้อมูลรายละเอียดการเคลมประกันภัย',
                            text: '<span style="font-size: 16px; text-align: left;"> ทำการยกเลิกรายข้อมูลรายละเอียดการเคลมประกันภัยเรียบร้อย </span>',
                            type: "success",
                            html: true
                        });
                        $('#modal_cancel').modal('hide');
                    }else{
                        swal({
                            title: 'มีข้อผิดพลาด',
                            text: '<span style="font-size: 16px; text-align: left;">'+res.data.data.msg+'</span>',
                            type: "warning",
                            html: true
                        });
                    }
                });
            },
        }
    }
</script>