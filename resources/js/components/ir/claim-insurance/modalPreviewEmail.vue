<template>
    <span>
        <button v-if="header.claim_header_id != ''" 
            type="button" :class="btnTrans.irp10_confirm.class + ' btn-lg tw-w-25'" @click="openModal" :disabled="disableFlag">
            <i :class="btnTrans.irp10_confirm.icon"></i> {{ profile.program_code == 'IRP0010'? btnTrans.irp10_confirm.text: btnTrans.irp11_confirm.text }}
        </button>

        <div class="modal fade" id="modal_preview" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" v-loading="loading">
                    <div class="modal-header">
                        <h4 style="font-size:22px; font-weight:400;" class="modal-title text-left">
                            ตัวอย่างการส่ง Email ไปยังบริษัทประกันภัย
                        </h4>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    </div>
                    <div v-if="isShowFlag" class="modal-body text-left" style="line-height: 2.5; font-size: 14px;">
                        <form id="form">
                            <table style="width: 100%;">
                                <tr>
                                    <td>
                                        <img class="img-circlex"
                                            style="
                                                max-height: 90px;
                                                position: relative;
                                                padding: 6px 0;
                                                line-height: 90px;
                                                vertical-align: middle;"
                                            src="/img/logo-home2.png"
                                        >
                                    </td>
                                    <td> <h2> การยาสูบแห่งประเทศไทย </h2> </td>
                                </tr>
                            </table>
                            <div style="color: #acacac;">
                                <span><strong> สำเนา : {{ cc }} </strong></span>
                            </div>
                            <div class="hr-line-dashed" style="margin: 1px;"></div>
                            <div>
                                <span><strong> เรื่อง : {{ subject }} </strong></span>
                            </div>
                            <div>
                                <span><strong> เรียน : {{ receiverNames }} </strong></span>
                            </div>
                            <br>
                            <div>
                                <span><strong> หัวข้อการเกิดเหตุ : </strong> {{ header.claim_title }} </span>
                            </div>
                            <div>
                                <span><strong> ผู้แจ้งเหตุ : </strong> {{ header.requestor_name }} </span>
                            </div>
                            <div>
                                <span><strong> สถานที่เกิดเหตุ : </strong> {{ header.location_name }} </span>
                            </div>
                            <div>
                                <span><strong> วันที่เกิดเหตุ : </strong> {{ accidentDate }} </span>
                            </div>
                            <div>
                                <span><strong> เวลาเกิดเหตุ : </strong> {{ accidentTime }} น. </span>
                            </div>
                            <div>
                                <span><strong> รายละเอียดเหตุการณ์ : </strong> {{ header.remarks }} </span>
                            </div>
                            <br>
                            <template v-for="desc in defaultDesc">
                                <div class="row col-12">
                                    {{ desc.description }}
                                </div>
                            </template>
                            <div class="hr-line-dashed" style="margin-bottom: 3px;"></div>
                            <!-- Attachment -->
                            <div style="color: #acacac;">
                                <span><strong> ไฟล์แนบไปยังบริษัทประกันภัย </strong></span>
                            </div>
                            <div class="row col-12">
                                <template v-for="file in fileAttachment">
                                    <div class="col-lg-3 col-md-3" style="font-size: 10px !important;">
                                        <div class="file-box" style="width: 170px !important;">
                                            <div class="file">
                                                <span class="corner"></span>
                                                <div class="icon">
                                                    <i class="fa fa-file"></i>
                                                </div>
                                                <div class="file-name" style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden">
                                                    {{ file.original_file_name }}
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <i class="fa fa-file-archive-o mt-2"></i> &nbsp; {{ file.original_file_name }} -->
                                    </div>
                                </template>
                            </div>
                            <!-- <template v-if="attachments.length == 0 && profile.program_code == 'IRP0011'">
                                <h3 class="text-danger"> กรุณาเลือกไฟล์เอกสารก่อนทำการยืนยันการส่งบริษัทประกันภัย </h3>
                            </template> -->
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click.prevent="confirmClaim()" :class="btnTrans.irp10_confirm.class + ' btn-lg tw-w-25'">
                            ยืนยันส่งอีเมล
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
        props:['pheader', 'purl', 'btnTrans', 'disable', 'profile', 'attachments'],
        data() {
            return {
                loading: false,
                header: this.pheader,
                url: this.purl,
                disableFlag: this.disable,
                isShowFlag: false,
                defaultDesc: [],
                subject: '',
                receiverNames: '',
                cc: '',
                accidentDate: '',
                accidentTime: '',
                fileAttachment: [],
            }
        },
        mounted() {
            //
        },
        computed: {
            //
        },
        watch:{
            defaultDesc: async function (value, oldValue) {
                this.defaultDesc = value;
            },
            disable: function(newValue) {
                this.disableFlag = newValue;
            },
        },
        methods: {
            newLine(data){
                 
                 
                return data.replace(/(?:\r\n|\r|\n)/g, "'\n'");
            },
            openModal() {
                let vm = this;
                vm.loading = true;
                vm.getDataDefault();
                // if (vm.profile.program_code == 'IRP0011') {
                    if (vm.attachments.length == 0) {
                        swal({
                            title: 'มีข้อผิดพลาด',
                            text: '<span style="font-size: 16px; text-align: left;"> กรุณาเลือกไฟล์เอกสารก่อนทำการยืนยันการส่งบริษัทประกันภัย </span>',
                            type: "warning",
                            html: true
                        });
                        return;
                    }
                // }
                $('#modal_preview').modal('show');
            },
            async getDataDefault(){
                let vm = this;
                vm.isShowFlag = false;
                await axios
                .post(vm.purl.ajax_get_data_default, {
                    claimHeaderId: vm.header.claim_header_id,
                    attachments: vm.attachments
                })
                .then(res => {
                    if (res.data.data.status == 'S') {
                        vm.loading = false;
                        vm.isShowFlag = true;
                        vm.defaultDesc = res.data.data.defaultDesc;
                        vm.accidentDate = res.data.data.accidentDate;
                        vm.fileAttachment = res.data.data.attachments;
                        vm.accidentTime = res.data.data.accidentTime;
                        vm.subject = res.data.data.detail['subject'];
                        vm.receiverNames = res.data.data.detail['receiverNames'];
                        vm.cc = res.data.data.detail['ccReceiverName'];
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
            // Confirm
            async confirmClaim() {
                let vm = this;
                let param = {}
                if (vm.profile.program_code == 'IRP0011') {
                    param = { attachments: vm.attachments }
                }
                vm.loading = true;
                await axios
                .post(vm.purl.ajax_confirm_claim, {param})
                .then(res => {
                    if (res.data.data.status == 'S') {
                        if (vm.profile.program_code == 'IRP0010') {
                            vm.disableFlag = true;
                            swal({
                                title: '<div class="mt-4"> ยืนยันการส่งบริษัทประกัน<br>และกองบัญชีประมวล </div>',
                                text: '<span style="font-size: 16px; text-align: left;"> ยืนยันการส่งบริษัทประกันและกองบัญชีประมวลเรียบร้อย </span>',
                                type: "success",
                                html: true
                            });
                            vm.$emit("comfirm", { confirm_status: 'S'
                                                , disableFlag: vm.disableFlag
                                                , status: res.data.data.header.status
                                                , insuranceStatus: res.data.data.header.insurance_status
                                                , insuranceDate: res.data.data.header.insurance_date
                                                , fileInsurance: res.data.data.fileInsurance
                                            });
                            let year = vm.header.period_year;
                            let url = vm.purl.get_report_irr9130+'?year='+year;
                            window.open(url, '_blank');
                        }else{
                            swal({
                                title: '<div class="mt-4"> ยืนยันการส่งบริษัทประกัน </div>',
                                text: '<span style="font-size: 16px; text-align: left;"> ยืนยันการส่งบริษัทประกันเรียบร้อย </span>',
                                type: "success",
                                html: true
                            });
                            vm.$emit("comfirm", {confirm_status: 'S', fileAll: res.data.data.file_all});
                        }
                        $('#modal_preview').modal('hide');
                    }else{
                        swal({
                            title: '<div class="mt-4"> มีข้อผิดพลาด </div>',
                            text: '<span style="font-size: 16px; text-align: left;">'+res.data.data.msg+'</span>',
                            type: "warning",
                            html: true
                        });
                    }
                })
                .catch(err => {
                    swal({
                        title: '<div class="mt-4"> มีข้อผิดพลาด </div>',
                        text: '<span style="font-size: 16px; text-align: left;">'+err+'</span>',
                        type: "warning",
                        html: true
                    });
                })
                .then(() => {
                    vm.loading = false;
                });
            },
            changeToTh(date){
                // เปลี่ยน Format และ เปลี่ยน คศ -> พศ
                var vm = this;
                var dateTh = '';
                if (date) {
                    dateTh = moment(date).add(543, 'year').format('DD-MM-YYYY');
                }
                return dateTh;
            },
            changeThToEn(dateTh){
                // เปลี่ยน Format และ เปลี่ยน พศ -> คศ
                let date = moment(dateTh, 'YYYY-MM-DD');
                if (date.isValid()) {
                    date.subtract(543, 'years');
                    return date.format('YYYY-MM-DD');
                }
            }
        }
    }
</script>