<template>
    <div v-loading="loading">
        <form id="claim-form">
            <div class="row">
                <div class="form-group pl-12 pr-2 mb-0 col-lg-5 col-md-5 col-sm-5 col-xs-5 mt-2" >
                    <div class="control-label mb-2" style="padding-right: 25px;">
                        <strong> หัวข้อการเกิดเหตุ <span class="text-danger"> * </span> </strong>
                    </div>
                    <el-input 
                        name="claim_title"
                        ref="claim_title"
                        placeholder="หัวข้อการเกิดเหตุ"
                        v-model="header.claim_title"
                        size="medium"
                        maxlength="50"
                        show-word-limit
                        :disabled="disableFlag">
                    </el-input>
                    <div id="el_explode_claim_title" class="error_msg text-left"></div>
                </div>
                <div class="form-group pl-12 pr-2 mb-0 col-lg-3 col-md-3 col-sm-3 col-xs-3 offset-md-4 mt-2">
                    <div class="control-label mb-2"><strong> คืนงบตามใบสำคัญเลขที่ </strong> </div>
                    <el-input name="name" v-model="header.journal_number" placeholder="คืนงบตามใบสำคัญเลขที่" size="medium" autocomplete="off" disabled></el-input>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="col-lg-12">
                <div class="row mt-3">
                    <label class="col-md-2 col-form-label text-right">
                        <strong> ผู้แจ้งเหตุ <span class="text-danger"> * </span></strong>
                    </label>
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <el-input name="requestor_name" 
                            placeholder="ผู้แจ้งเหตุ" 
                            v-model="header.requestor_name" 
                            size="medium" 
                            autocomplete="off" 
                            ref="requestor_name" 
                            disabled>
                        </el-input>
                        <div id="el_explode_requestor_name" class="error_msg text-left"></div>
                    </div>
                    <label class="col-md-3 col-form-label text-right">
                        <strong> หน่วยงานผู้แจ้งเหตุ <span class="text-danger"> * </span></strong>
                    </label>
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <lov-department placeholder="หน่วยงานผู้แจ้งเหตุ"
                                    attrName="department_code"
                                    :set-data="header.department_code"
                                    :disabled="true"
                                    @change-lov="selDepartment"
                                    :errors="errors"
                        />
                        <div id="el_explode_department_code" class="error_msg text-left"></div>
                    </div>
                </div>

                <div class="row mt-3">
                    <label class="col-md-2 col-form-label text-right">
                        <strong> เบอร์โทรผู้แจ้งเหตุ <span class="text-danger"> * </span></strong>
                    </label>
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <el-input
                            name="requestor_tel"
                            placeholder="เบอร์โทรผู้แจ้งเหตุ"
                            v-model="header.requestor_tel"
                            maxlength="10"
                            size="medium"
                            autocomplete="off"
                            :disabled="disableFlag"
                            ref="requestor_tel">
                        </el-input>
                        <div id="el_explode_requestor_tel" class="error_msg text-left"></div>
                    </div>
                    <label class="col-md-3 col-form-label text-right">
                        <strong> วันที่แจ้งบริษัทประกัน </strong>
                    </label>
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <div class="input-group">
                            <datepicker-th
                                style="width: 100%;"
                                class="form-control md:tw-mb-0 tw-mb-2"
                                name="insurance_date"
                                id="insurance_date"
                                placeholder="วันที่แจ้งบริษัทประกัน"
                                p-type="date"
                                :value="header.insurance_date"
                                v-model="header.insurance_date"
                                format="DD/MM/YYYY"
                                :disabled="true"
                                @dateWasSelected="dateInsuranceDate"
                            />
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <label class="col-md-2 col-form-label text-right">
                        <strong> วันที่เกิดเหตุ <span class="text-danger"> * </span></strong>
                    </label>
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <datepicker-th
                            :style="'width: 100%; ' + (errors.accident_date? 'border: 1px solid red;' : '')"
                            class="form-control md:tw-mb-0 tw-mb-2" 
                            name="accident_date"
                            id="accident_date"
                            placeholder="วันที่แจ้งเหตุ"
                            p-type="date"
                            :value="header.accident_date"
                            v-model="header.accident_date"
                            format="DD/MM/YYYY"
                            @dateWasSelected="dateAccidentDate"
                            :disabled="disableFlag"
                            :notAfterDate="current_date"
                        />
                        <div id="el_explode_accident_date" class="error_msg text-left"></div>
                    </div>
                    <label class="col-md-3 col-form-label text-right">
                        <strong> สถานะปัจจุบัน </strong>
                    </label>
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <el-input
                            name="status"
                            placeholder="สถานะปัจจุบัน"
                            v-model="header.insurance_status"
                            size="medium"
                            autocomplete="off"
                            disabled>
                        </el-input>
                    </div>
                </div>

                <div class="row mt-3">
                    <label class="col-md-2 col-form-label text-right">
                        <strong> เวลาเกิดเหตุ <span class="text-danger"> * </span></strong>
                    </label>
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <el-time-picker
                            name="accident_time"
                            v-model="header.accident_time"
                            size="medium"
                            style="width: 100%;"
                            :picker-options="{
                                selectableRange: '00:00:00 - 23:59:59'
                            }"
                            placeholder="เวลาแจ้งเหตุ"
                            :disabled="disableFlag"
                            ref="accident_time">
                         </el-time-picker>

                        <div id="el_explode_accident_time" class="error_msg text-left"></div>
                    </div>
                    <label class="col-md-3 col-form-label text-right">
                        <strong> จำนวนเงินเรียกชดใช้โดยประมาณ </strong>
                    </label>
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <div class="input-group">
                            <vue-numeric style="width: 70%" name="claim_amount"
                            separator="," 
                            v-bind:precision="2" 
                            v-bind:minus="false"
                            :min="0"
                            :max="999999999"
                            class="form-control input-sm text-right"
                            v-model="header.claim_amount"
                            :disabled="disableFlag"
                            autocomplete="off"
                        ></vue-numeric>
                        <span class="input-group-addon"> THB </span>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <label class="col-md-2 col-form-label text-right">
                        <strong> สถานที่เกิดเหตุ <span class="text-danger"> * </span></strong>
                    </label>
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <el-input name="location_name"
                            placeholder="สถานที่เกิดเหตุ"
                            v-model="header.location_name"
                            size="medium"
                            autocomplete="off"
                            ref="location_name"
                            maxlength="150"
                            show-word-limit
                            :disabled="disableFlag">
                        </el-input>
                        <div id="el_explode_location_name" class="error_msg text-left"></div>
                    </div>
                    <label class="col-md-3 col-form-label text-right">
                        <strong> จำนวนเงินเรียกชดใช้รวม </strong>
                    </label>
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <div class="input-group">
                            <vue-numeric style="width: 70%" name="total_claim_amount"
                            separator="," 
                            v-bind:precision="2" 
                            v-bind:minus="false"
                            :min="0"
                            :max="999999999"
                            class="form-control input-sm text-right"
                            v-model="header.total_claim_amount"
                            autocomplete="off"
                            disabled
                        ></vue-numeric>
                        <span class="input-group-addon"> THB </span>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-lg-5">
                        <div class="row">
                            <label class="col-md-5 col-form-label text-right pr-4">
                                <strong> รายละเอียดเหตุการณ์ <span class="text-danger"> * </span></strong>
                            </label>
                            <div class="col-xl-7 col-lg-7 col-md-7 pl-1">
                                <el-input type="textarea" :rows="2"
                                    name="remarks"
                                    ref="remarks"
                                    placeholder="รายละเอียดเหตุการณ์"
                                    v-model="header.remarks"
                                    size="medium"
                                    maxlength="1000"
                                    show-word-limit
                                    :disabled="disableFlag">
                                </el-input>
                                <div id="el_explode_remarks" class="error_msg text-left"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="row mb-3">
                            <label class="col-md-5 col-form-label text-right" style="padding-right: 6px;">
                                <strong> จำนวนเงินเรียกเก็บ (ตั้งหนี้) </strong>
                            </label>
                            <div class="col-xl-5 col-lg-5 col-md-5" style="padding-right: 0%; margin-left: 1%;">
                                <div class="input-group">
                                    <vue-numeric style="width: 70%" name="ar_invoice_amount"
                                        separator="," 
                                        v-bind:precision="2" 
                                        v-bind:minus="false"
                                        :min="0"
                                        :max="999999999"
                                        class="form-control input-sm text-right"
                                        v-model="header.ar_invoice_amount"
                                        disabled
                                    ></vue-numeric>
                                    <span class="input-group-addon"> THB </span>
                                </div>
                            </div>
                        </div>
                        <!-- เอกสารแจ้งเหตุส่งบริษัทประกัน -->
                        <div class="row">
                            <label class="col-md-5 col-form-label text-right" style="padding-right: 6px;">
                                <strong> เอกสารแจ้งเหตุส่งบริษัทประกัน <span class="text-danger"> * </span></strong>
                                <div class="text-danger offset-md-3" style="margin: 0px;">
                                    <small> * สำหรับแนบเอกสารแจ้งความเสียหายส่งบริษัทประกันเท่านั้น
                                        <br> * ขนาดไฟล์ไม่เกิน 5 MB
                                        <br> สามารถเพิ่มได้อีก {{ maximum - fileListInsurance.length }} รูป สูงสุดไม่เกิน {{ maximum }} รูป
                                    </small>
                                </div>
                            </label>
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <el-upload
                                    class="upload-demo mt-2"
                                    name="fileListInsurance[]"
                                    :action="'/ir/ajax/claim-insurance/'+header.claim_header_id+'/attachment'"
                                    :headers="{ 'X-CSRF-TOKEN': token_csrf }"
                                    :on-success="handleSuccess"
                                    :limit="maximum"
                                    :file-list="fileListInsurance"
                                    :show-file-list="false"
                                    auto-upload
                                    :disabled="disableFlag || header.claim_header_id == '' || maximum == fileListInsurance.length">
                                    <el-button size="small" type="primary" :disabled="disableFlag || header.claim_header_id == '' || maximum == fileListInsurance.length"> เพิ่มเอกสารแนบ </el-button>
                                </el-upload>
                                <!-- List file for download -->
                                <div v-if="fileListInsurance.length" class="panel panel-default mt-2">
                                    <div class="panel-body" style="max-height: 100px; overflow-y: scroll; padding: 5px;">
                                        <template v-for="file in fileListInsurance">
                                            <div class="file-name pl-2"
                                                style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">
                                                <a style="font-size: 10px; word-wrap: break-word;" :href="`/ir/ajax/claim-accounting/${file.uid}/download`">
                                                        <i class="fa fa-download"></i> {{ file.name.substring(0, 35) + '...' }}
                                                </a>
                                                <template v-if="file.send_flag == 'Y'">
                                                    &nbsp; <i class="fa fa-check-circle text-success"></i>
                                                </template>
                                                <template v-if="file.send_flag != 'Y'">
                                                    <a style="font-size: 11px; word-wrap: break-word;" class="text-danger"
                                                        @click.prevent="removeFileIRP0010(file.uid)">
                                                        <i class="fa fa-trash-o"></i>
                                                    </a>
                                                </template>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                                <!-- end -->
                            </div>
                        </div>
                        <!-- เอกสารอื่นๆ -->
                        <div class="row">
                            <label class="col-md-5 col-form-label text-right" style="padding-right: 6px;">
                                <strong> เอกสารเพิ่มเติมอื่นๆ </strong>
                                <div class="text-danger offset-md-3" style="margin: 0px;">
                                    <small>
                                        * เช่น เอกสารอนุมัติการใช้งบ, การเรียกชดใช้เพิ่มเติม, แจ้งความเสียหายเพิ่มเติม เป็นต้น
                                        <br> * ขนาดไฟล์ไม่เกิน 5 MB
                                        <br> สามารถเพิ่มได้อีก {{ maximum - fileListApprove.length }} รูป สูงสุดไม่เกิน {{ maximum }} รูป
                                    </small>
                                </div>
                            </label>
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <el-upload
                                    class="upload-demo mt-2"
                                    name="fileListApprove[]"
                                    :action="'/ir/ajax/claim-insurance/'+header.claim_header_id+'/attachment'"
                                    :headers="{ 'X-CSRF-TOKEN': token_csrf }"
                                    :on-success="handleSuccess"
                                    :limit="maximum"
                                    :show-file-list="false"
                                    auto-upload
                                    :disabled="header.status == 'CANCELLED' || header.claim_header_id == '' || maximum == fileListApprove.length">
                                    <el-button size="small" type="primary" :disabled="header.status == 'CANCELLED' || header.claim_header_id == '' || maximum == fileListApprove.length"> เพิ่มเอกสารแนบ </el-button>
                                </el-upload>
                                <!-- List file for download -->
                                <div v-if="fileListApprove.length" class="panel panel-default mt-2">
                                    <div class="panel-body" style="max-height: 100px; overflow-y: scroll; padding: 5px;">
                                        <template v-for="file in fileListApprove">
                                            <div class="file-name pl-2"
                                                style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">
                                                <a style="font-size: 10px; word-wrap: break-word;" :href="`/ir/ajax/claim-accounting/${file.uid}/download`">
                                                        <i class="fa fa-download"></i> {{ file.name.substring(0, 35) + '...' }}
                                                </a>
                                                <template v-if="file.program_code == 'IRP0010'">
                                                    <a style="font-size: 11px; word-wrap: break-word;" class="text-danger"
                                                        @click.prevent="removeFileIRP0010(file.uid)">
                                                        <i class="fa fa-trash-o"></i>
                                                    </a>
                                                </template>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                                <!-- end -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row col-12 mt-4">
                <div class="col-lg-5 col-md-5">
                    <div v-if="header.cancelled_reason">
                        <strong class="text-danger"> <u> เหตุผลในการยกเลิก </u> : {{ header.cancelled_reason }} </strong>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7 text-right">
                    <button type="button" :class="btnTrans.save.class + ' btn-lg tw-w-25'" @click.prevent="submit()" :disabled="disableFlag">
                        <i :class="btnTrans.save.icon"></i> {{ btnTrans.save.text }}
                    </button>
                    <button v-if="header.claim_header_id != ''"
                        type="button" :class="btnTrans.irp10_report.class + ' btn-lg tw-w-25'" @click.prevent="getReportIRR9130()"
                        :disabled="header.status == 'CANCELLED'
                            || (header.insurance_status == 'CANCELLED' && (header.cancelled_reason != null || header.cancelled_reason != ''))"
                    >
                        <i :class="btnTrans.irp10_report.icon"></i> {{ btnTrans.irp10_report.text }}
                    </button>
                    <button v-if="header.claim_header_id != ''"
                        type="button" :class="btnTrans.cancel.class + ' btn-lg tw-w-25'" @click.prevent="cancelClaim()" :disabled="disableFlag">
                        <i :class="btnTrans.cancel.icon"></i> {{ btnTrans.cancel.text }}
                    </button>
                    <modalPreviewEmail
                        :pheader="header"
                        :purl="url"
                        :btnTrans="btnTrans"
                        :disable="disableFlag"
                        :attachments="fileListInsurance"
                        :profile="profile"
                        @comfirm="disableComfirm">
                    </modalPreviewEmail>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import moment from "moment";
    import lovDepartment from './lovDepartment.vue'
    import lovLocation from './lovLocation.vue'
    import modalPreviewEmail from './modalPreviewEmail.vue'
    export default {
        props:[
            'claim', 'fileInsurance', 'fileApprove', 'user', 'btnTrans', 'purl', 'profile'
        ],
        components: {
            lovDepartment, lovLocation, modalPreviewEmail
        },
        mounted(){
            var accDate = this.claim? this.claim.accident_date: moment().format('YYYY-MM-DD');
            var currentDate = moment().format('YYYY-MM-DD');
            var insuranceDate = this.claim? this.claim.insurance_date: '';
            this.header.accident_date = this.changeToTh(accDate);
            this.header.insurance_date = this.changeToTh(insuranceDate);
            this.current_date = this.changeToTh(currentDate);
            this.disableFlag = (!this.claim? false: (this.claim.status == 'CONFIRMED' || this.claim.status == 'CANCELLED'))? true: false;
        },
        data () {
            return {
                loading: false,
                url: this.purl,
                header: {
                    claim_header_id: this.claim? this.claim.claim_header_id: '',
                    journal_number: this.claim? this.claim.journal_number: '',
                    requestor_id: this.claim? this.claim.requestor_id: this.user.user_id,
                    requestor_name: this.claim? this.claim.requestor_name: this.user.name,
                    department_code: this.claim? this.claim.department_code: this.user.department_code,
                    requestor_tel: this.claim? this.claim.requestor_tel: '',
                    accident_date: this.claim? this.claim.accident_date: '',
                    accident_time: this.claim? this.claim.accident_time : moment().format('YYYY-MM-DD HH:mm'),
                    location_name: this.claim? this.claim.location_name: '',
                    claim_amount: this.claim? this.claim.claim_amount: 0,
                    insurance_date: this.claim? this.claim.insurance_date: '',
                    insurance_status: this.claim? this.claim.insurance_status: 'NEW',
                    total_claim_amount: this.claim? Number(this.claim.total_claim_amount): 0,
                    status: this.claim? this.claim.status: 'NEW',
                    remarks: this.claim? this.claim.remarks: '',
                    claim_title: this.claim? this.claim.claim_title: '',
                    cancelled_reason: this.claim? this.claim.cancelled_reason: '',
                    ar_invoice_amount: !this.claim? 0: (this.claim.insurance_status == 'NEW' || this.claim.insurance_status == 'แจ้งบริษัทประกันแล้ว')? 0 :this.claim.ar_invoice_amount,
                    period_year: this.claim? this.claim.year: '',
                },
                errors: {
                    requestor_name: false,
                    department_code: false,
                    requestor_tel: false,
                    accident_date: false,
                    accident_time: false,
                    location_name: false,
                    attac_insurance: false,
                    attac_approve: false,
                    claim_title: false,
                    remarks: false
                },
                maximum: 20,
                fileListInsurance: this.claim? this.fileInsurance: [],
                fileListApprove: this.claim? this.fileApprove: [],
                disableFlag: (!this.claim? false: this.claim.status == 'CONFIRMED' || this.claim.status == 'CANCELLED')? true: false,
                token_csrf: document.head.querySelector('meta[name="csrf-token"]').content,
                current_date: '',
            }
        },
        computed: {
            //
        },
        watch:{
            errors: {
                handler(val){
                     
                    val.requestor_name? this.setError('requestor_name') : this.resetError('requestor_name');
                    val.requestor_tel? this.setError('requestor_tel') : this.resetError('requestor_tel');
                    val.accident_time? this.setError('accident_time') : this.resetError('accident_time');
                    val.location_name? this.setError('location_name') : this.resetError('location_name');
                    val.claim_title? this.setError('claim_title') : this.resetError('claim_title');
                    val.remarks? this.setError('remarks') : this.resetError('remarks');
                },
                deep: true,
            },
        },
        methods: {
            selDepartment(value) {
                this.header.department_code = value.department_code
            },
            dateInsuranceDate(date){
                this.header.insurance_date = date? moment(date).format('DD-MM-YYYY'): '';
            },
            dateAccidentDate(date){
                this.header.accident_date = date? moment(date).format('DD-MM-YYYY'): '';
            },
            handleSuccess(res, file, fileList) {
                var vm = this
                if (res.status == 'S') {
                    vm.fileListInsurance = [];
                    vm.fileListApprove = [];
                    vm.fileListInsurance = res.file_insurance;
                    vm.fileListApprove = res.file_approve;
                    swal({
                        title: '<div class="mt-4"> แนบเอกสารแจ้งเหตุความเสียหาย </div>',
                        text: '<span style="font-size: 16px; text-align: left;"> ทำการแนบเอกสารแจ้งเหตุความเสียหายเรียบร้อยแล้ว </span>',
                        type: "success",
                        html: true
                    });
                }else{
                    swal({
                        title: '<div class="mt-4"> มีข้อผิดพลาด </div>',
                        text: '<span style="font-size: 16px; text-align: left;">'+res.msg+'</span>',
                        type: "error",
                        html: true
                    });
                }
            },
            // Store/Update
            async submit(){
                let vm = this;
                var form  = $('#claim-form');
                let formData = new FormData();
                let valid = true;
                let errorMsg = '';
                //-- ERROR
                vm.errors.requestor_name = false;
                vm.errors.department_code = false;
                vm.errors.requestor_tel = false;
                vm.errors.accident_date = false;
                vm.errors.accident_time = false;
                vm.errors.location_name = false;
                vm.errors.attac_insurance = false;
                vm.errors.attac_approve = false;
                vm.errors.claim_title = false;
                vm.errors.remarks = false;
                //-- MSG
                $(form).find("div[id='el_explode_requestor_name']").html("");
                $(form).find("div[id='el_explode_department_code']").html("");
                $(form).find("div[id='el_explode_requestor_tel']").html("");
                $(form).find("div[id='el_explode_accident_date']").html("");
                $(form).find("div[id='el_explode_accident_time']").html("");
                $(form).find("div[id='el_explode_location_name']").html("");
                $(form).find("div[id='el_explode_attac_insurance']").html("");
                $(form).find("div[id='el_explode_attac_approve']").html("");
                $(form).find("div[id='el_explode_claim_title']").html("");
                $(form).find("div[id='el_explode_remarks']").html("");

                if (vm.header.requestor_id == '' || vm.header.requestor_id == null){
                    vm.errors.requestor_name = true;
                    valid = false;
                    errorMsg = "กรุณาระบุชื่อผู้แจ้งเหตุ";
                    $(form).find("div[id='el_explode_requestor_name']").html(errorMsg);
                }
                if (vm.header.department_code == '' || vm.header.department_code == null){
                    vm.errors.department_code = true;
                    valid = false;
                    errorMsg = "กรุณาระบุหน่วยงานผู้แจ้งเหตุ";
                    $(form).find("div[id='el_explode_department_code']").html(errorMsg);
                }
                if (vm.header.requestor_tel == '' || vm.header.requestor_tel == null){
                    vm.errors.requestor_tel = true;
                    valid = false;
                    errorMsg = "กรุณาระบุเบอร์โทรผู้แจ้งเหตุ";
                    $(form).find("div[id='el_explode_requestor_tel']").html(errorMsg);
                }
                if (vm.header.accident_date == '' || vm.header.accident_date == null){
                    vm.errors.accident_date = true;
                    valid = false;
                    errorMsg = "กรุณาระบุวันที่แจ้งเหตุ";
                    $(form).find("div[id='el_explode_accident_date']").html(errorMsg);
                }
                if (vm.header.accident_time == '' || vm.header.accident_time == null ){
                    vm.errors.accident_time = true;
                    valid = false;
                    errorMsg = "กรุณาระบุเวลาแจ้งเหตุ";
                    $(form).find("div[id='el_explode_accident_time']").html(errorMsg);
                }
                if (vm.header.location_name == '' ||  vm.header.location_name == null){
                    vm.errors.location_name = true;
                    valid = false;
                    errorMsg = "กรุณาระบุสถานที่เกิดเหตุ";
                    $(form).find("div[id='el_explode_location_name']").html(errorMsg);
                }
                if (vm.header.claim_title == '' || vm.header.claim_title == null){
                    vm.errors.claim_title = true;
                    valid = false;
                    errorMsg = "กรุณาระบุหัวข้อการเกิดเหตุ";
                    $(form).find("div[id='el_explode_claim_title']").html(errorMsg);
                }
                if (vm.header.remarks == '' || vm.header.remarks == null){
                    vm.errors.remarks = true;
                    valid = false;
                    errorMsg = "กรุณาระบุรายละเอียดเหตุการณ์";
                    $(form).find("div[id='el_explode_remarks']").html(errorMsg);
                }
                if (vm.fileListInsurance.length <= 0 && vm.header.claim_header_id){
                    vm.errors.attac_insurance = true;
                    valid = false;
                    errorMsg = "กรุณาแนบไฟล์สำหรับส่งบริษัทประกัน";
                    // $(form).find("div[id='el_explode_attac_insurance']").html(errorMsg);
                    swal({
                        title: '<div class="mt-4"> มีข้อผิดพลาด </div>',
                        text: '<span style="font-size: 16px; text-align: left;">'+errorMsg+'</span>',
                        type: "error",
                        html: true
                    });
                }
                if (!valid) {
                    return;
                }

                //request
                formData.append('requestor_id', vm.header.requestor_id);
                formData.append('requestor_name', vm.header.requestor_name);
                formData.append('department_code', vm.header.department_code);
                formData.append('requestor_tel', vm.header.requestor_tel);
                formData.append('accident_date', vm.header.accident_date);
                formData.append('accident_time', vm.header.accident_time);
                formData.append('location_name', vm.header.location_name);
                formData.append('claim_amount', vm.header.claim_amount);
                formData.append('status', vm.header.status);
                formData.append('claim_title', vm.header.claim_title);
                formData.append('remarks', vm.header.remarks);
                // attachment
                // vm.fileListInsurance.forEach((file, index) => {
                //     if (file.status == 'ready') {
                //         formData.append('fileListInsurance[]', vm.fileListInsurance[index].raw);
                //     }
                // });
                // vm.fileListApprove.forEach((file, index) => {
                //     if (file.status == 'ready') {
                //         formData.append('fileListApprove[]', vm.fileListApprove[index].raw);
                //     }
                // });

                let res = await vm.create(formData);
                vm.loading = false;
                if(res.status == 'S'){
                    vm.loading = false;
                    if (vm.header.claim_header_id == '') {
                        swal({
                            title: '<div class="mt-4"> สร้างและอัพเดตแจ้งเหตุการเคลมประกันภัย </div>',
                            text: '<span style="font-size: 16px; text-align: left;"> ทำการสร้างและอัพเดตแจ้งเหตุการเคลมประกันภัยเรียบร้อยแล้ว </span>',
                            type: "success",
                            html: true
                        },
                        function(isConfirm){
                            if (isConfirm) {
                                vm.loading = true;
                                window.location.href = res.redirect_show_page;
                            }
                        });
                    }else{
                        vm.url = res.url;
                        vm.header.claim_header_id = res.header.claim_header_id;
                        vm.header.status = res.header.status;
                        vm.header.remarks = res.header.remarks;
                        vm.header.period_year = res.header.year;
                        vm.fileListInsurance = res.file_insurance;
                        vm.fileListApprove = res.file_approve;
                        swal({
                            title: '<div class="mt-4"> สร้างและอัพเดตแจ้งเหตุการเคลมประกันภัย </div>',
                            text: '<span style="font-size: 16px; text-align: left;"> ทำการสร้างและอัพเดตแจ้งเหตุการเคลมประกันภัยเรียบร้อยแล้ว </span>',
                            type: "success",
                            html: true
                        });
                    };
                }else{
                    swal({
                        title: '<div class="mt-4"> มีข้อผิดพลาด </div>',
                        text: '<span style="font-size: 16px; text-align: left;">'+res.msg+'</span>',
                        type: "error",
                        html: true
                    });
                }
            },
            async create(formData) {
                let vm2 = this;
                vm2.loading = true;
                let data = {
                    msg: ''
                };
                let url = vm2.header.claim_header_id != ''? vm2.url.ajax_update_claim: vm2.url.ajax_store_claim;
                await axios
                .post(url, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(res => {
                    data = res.data;
                })
                .catch(err => {
                    let msg = err;
                    swal({
                        title: '<div class="mt-4"> มีข้อผิดพลาด </div>',
                        text: msg.message,
                        type: "error",
                    });
                })
                .then(() => {
                    vm2.loading = false;
                });
                return data;
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
            changeToTh(date){
                var vm = this;
                var dateTh = '';
                if (date) {
                    dateTh = moment(date).add(543, 'year').format('DD-MM-YYYY');
                }
                return dateTh;
            },
            disableComfirm(res){
                if (res.confirm_status == 'S') {
                    this.disableFlag = res.disableFlag;
                    this.header.status = res.status;
                    this.header.insurance_date = this.changeToTh(res.insuranceDate);
                    this.header.insurance_status = res.insuranceStatus;
                    this.fileListInsurance = res.fileInsurance;
                }
            },
            async cancelClaim(){
                let vm = this;
                swal({
                    html: true,
                    title: '<div class="mt-4"> ยกเลิกรายการแจ้งเหตุการเคลมประกันภัย </div>',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการยกเลิกรายการแจ้งเหตุการเคลมประกันภัย ? </span></h2>',
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
                        vm.loading = true;
                        vm.cancel();
                    }
                });
            },
            async cancel(){
                let vm = this;
                await axios
                .get(vm.url.ajax_cancel_claim)
                .then(res => {
                    vm.loading = false;
                    if (res.data.data.status == 'S') {
                        vm.disableFlag = true;
                        vm.header.status = res.data.data.claim_status;
                        vm.header.insurance_status = res.data.data.insurance_status;
                        swal({
                            title: '<div class="mt-4"> ยกเลิกรายการแจ้งเหตุการเคลมประกันภัย </div>',
                            text: '<span style="font-size: 16px; text-align: left;"> ทำการยกเลิกรายการแจ้งเหตุการเคลมประกันภัยเรียบร้อย </span>',
                            type: "success",
                            html: true
                        });
                    }else{
                        swal({
                            title: '<div class="mt-4"> มีข้อผิดพลาด </div>',
                            text: '<span style="font-size: 16px; text-align: left;">'+res.data.data.msg+'</span>',
                            type: "warning",
                            html: true
                        });
                    }
                });
            },
            async getReportIRR9130(){
                let vm = this;
                let year = moment().format('YYYY');
                let url = vm.url.get_report_irr9130+'?year='+year;
                window.open(url, '_blank');
            },
            changeTh(dateTh){
                let date = moment(dateTh, 'YYYY-MM-DD');
                if (date.isValid()) {
                    date.subtract(543, 'years');
                    return date.format('YYYY-MM-DD');
                }
            },
            removeFileIRP0010(fileId) {
                let vm = this;
                swal({
                    html: true,
                    title: '<div class="mt-4"> ยืนยันลบเอกสารแจ้งเหตุความเสียหาย </div>',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการยืนยันลบเอกสารแจ้งเหตุความเสียหาย ? </span></h2>',
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
                        vm.loading = true;
                        vm.removeFile(fileId);
                    }
                });
            },
            async removeFile(fileId) {
                let vm = this;
                let params = {
                    claim_header_id: vm.header.claim_header_id,
                    attachment_id: fileId
                };
                await axios
                .post(vm.url.ajax_delete_file_irp0010, {params})
                .then(res => {
                    vm.loading = false;
                    if(res.data.data.status == 'S'){
                        vm.fileListInsurance = [];
                        vm.fileListApprove = [];
                        vm.fileListInsurance = res.data.data.file_insurance;
                        vm.fileListApprove = res.data.data.file_approve;
                        swal({
                            title: '<div class="mt-4"> ไฟล์แนบเอกสารแจ้งเหตุความเสียหาย </div>',
                            text: '<span style="font-size: 16px; text-align: left;"> ทำการลบไฟล์เอกสารแจ้งเหตุความเสียหายที่ต้องการเรียบร้อยแล้ว </span>',
                            type: "success",
                            html: true
                        });
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
                    let msg = err;
                    this.loading = false;
                    swal({
                        title: '<div class="mt-4"> มีข้อผิดพลาด </div>',
                        text: msg.message,
                        type: "error",
                        html: true
                    });
                })
            },
        }
    }
</script>

<style type="text/css">
    .el-upload-list__item-name{
        font-size: 10px;
    }
</style>