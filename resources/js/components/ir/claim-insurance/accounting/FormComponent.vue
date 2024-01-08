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
                            disabled>
                        </el-input>
                        <div id="el_explode_claim_title" class="error_msg text-left"></div>
                </div>
                <div class="form-group text-right pl-12 pr-2 mb-0 col-lg-3 col-md-3 col-sm-3 col-xs-3 mt-2">
                    <strong> เลขที่เอกสาร : {{ header.document_number }} </strong>
                </div>
                <div class="form-group pl-12 pr-2 mb-0 col-lg-3 col-md-3 col-sm-3 col-xs-3 offset-md-1 mt-2">
                    <div class="control-label mb-2"><strong> คืนงบตามใบสำคัญเลขที่ </strong> </div>
                    <el-input name="journal_number"
                        v-model="header.journal_number"
                        placeholder="คืนงบตามใบสำคัญเลขที่"
                        size="medium"
                        autocomplete="off"
                        maxlength="40"
                        show-word-limit
                        :disabled="header.insurance_status != 'ได้รับชดใช้แล้ว'">
                    </el-input>
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
                            disabled
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
                                disabled
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
                            disabled
                        />
                        <div id="el_explode_accident_date" class="error_msg text-left"></div>
                    </div>
                    <label class="col-md-3 col-form-label text-right">
                        <strong> สถานะปัจจุบัน </strong>
                    </label>
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <el-input v-if="header.insurance_status" 
                            name="insurance_status" 
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
                            :picker-options="{
                                selectableRange: '00:00:00 - 23:59:59'
                            }"
                            placeholder="เวลาแจ้งเหตุ"
                            disabled>
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
                            disabled
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
                            disabled>
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
                            :disabled="header.status == 'CANCELLED' || (!vshow && !confirmFlag && header.status != 'INTERFACE' )"
                            v-on:keypress.native="validateInput(true)"
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
                                    placeholder="รายละเอียดเหตุการณ์"
                                    v-model="header.remarks"
                                    size="medium"
                                    maxlength="1000"
                                    show-word-limit
                                    disabled>
                                </el-input>
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
                                    <vue-numeric :style="'width: 70%; ' + (errors.amount? 'border: 1px solid red;' : '')"
                                        name="ar_invoice_amount"
                                        separator="," 
                                        v-bind:precision="2" 
                                        v-bind:minus="false"
                                        :min="0"
                                        :max="999999999"
                                        class="form-control input-sm text-right"
                                        v-model="header.ar_invoice_amount"
                                        autocomplete="off"
                                        disabled
                                    ></vue-numeric>
                                    <span class="input-group-addon"> THB </span>
                                </div>
                                <div id="el_explode_ar_amount" class="error_msg text-left"></div>
                            </div>
                        </div>
                        <!-- เอกสารแจ้งเหตุส่งบริษัทประกัน -->
                        <div class="row">
                            <label class="col-md-5 col-form-label text-right" style="padding-right: 6px;">
                                <strong> เอกสารแจ้งเหตุส่งบริษัทประกัน <span class="text-danger"> * </span></strong>
                                <div class="text-danger offset-md-3" style="margin: 0px;">
                                    <small> * สำหรับแนบเอกสารแจ้งความเสียหายส่งบริษัทประกันเท่านั้น </small>
                                </div>
                            </label>
                            <div class="col-xl-6 col-lg-6 col-md-6 ml-2">
                                <div class="panel panel-default mt-2">
                                    <div class="panel-body" style="max-height: 100px; overflow-y: scroll; padding: 5px;">
                                        <template v-for="file in fileInsurance">
                                            <div class="file-name pl-2"
                                                style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">
                                                <a style="font-size: 10px; word-wrap: break-word;" :href="`/ir/ajax/claim-accounting/${file.uid}/download`">
                                                        <i class="fa fa-download"></i> {{ file.name.substring(0, 35) + '...' }}
                                                </a>
                                                <template v-if="file.send_flag == 'Y'">
                                                    &nbsp; <i class="fa fa-check-circle text-success"></i>
                                                </template>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- เอกสารอื่นๆ -->
                        <div class="row">
                            <label class="col-md-5 col-form-label text-right" style="padding-right: 6px;">
                                <strong> เอกสารเพิ่มเติมอื่นๆ <span class="text-danger"> * </span></strong>
                                <div class="text-danger offset-md-3" style="margin: 0px;">
                                    <small>
                                        * เช่น เอกสารอนุมัติการใช้งบ, การเรียกชดใช้เพิ่มเติม, แจ้งความเสียหายเพิ่มเติม เป็นต้น
                                        <br> * ขนาดไฟล์ไม่เกิน 5 MB
                                        <br> สามารถเพิ่มได้อีก {{ maximum - fileListApprove.length }} รูป สูงสุดไม่เกิน {{ maximum }} รูป
                                    </small>
                                </div>
                            </label>
                            <div class="col-xl-6 col-lg-6 col-md-6 ml-2">
                                <el-upload
                                    class="upload-demo mt-2"
                                    name="fileListApprove[]"
                                    :action="'/ir/ajax/claim-accounting/'+header.claim_header_id+'/attachment'"
                                    :headers="{ 'X-CSRF-TOKEN': token_csrf }"
                                    :on-success="handleSuccess"
                                    :limit="maximum"
                                    auto-upload
                                    :show-file-list="false"
                                    :disabled="maximum == fileListApprove.length">
                                    <el-button size="small" type="primary" :disabled="maximum == fileListApprove.length"> เพิ่มเอกสารแนบ </el-button>
                                </el-upload>
                                <!-- :on-preview="handlePreviewAdded"
                                    :before-remove="beforeRemoveAdded"
                                    :file-list="fileListAdded"
                                    :on-exceed="handleExceedAdded"
                                    :on-change="handleChangeAdded"
                                    :disabled="header.status == 'CANCELLED'"-->
                                <!-- LOV -->
                                <el-select style="width: 100%; font-size: 12px;" class="mt-3"
                                        v-model="chooseFile"
                                        size="small"
                                        :multiple="true"
                                        :limit="maximum"
                                        placeholder="เอกสารส่งบริษัทประกัน"
                                        filterable
                                        :disabled="disableFlag">
                                    <el-option
                                        v-for="file in fileListApprove"
                                        :key="file.uid"
                                        :label="file.name"
                                        :value="file.uid">
                                    </el-option>
                                </el-select>
                                <!-- List file for download -->
                                <div v-if="fileListAll.length" class="panel panel-default mt-2">
                                    <div class="panel-body" style="max-height: 100px; overflow-y: scroll; padding: 5px;">
                                        <template v-for="file in fileListAll">
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
                                                        @click.prevent="removeFileIRP0011(file.uid)">
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
                    <button v-if="header.status == 'INTERFACE'" type="button" :class="btnTrans.save.class + ' btn-lg tw-w-25'"
                        @click.prevent="updateClaimHeader()">
                        <i :class="btnTrans.save.icon"></i> {{ btnTrans.save.text }}
                    </button>
                    <modalPreviewEmail
                        :pheader="header"
                        :purl="url"
                        :btnTrans="btnTrans"
                        :profile="profile"
                        :disable="disableFlag"
                        :attachments="chooseFile"
                        @comfirm="disableComfirm">
                    </modalPreviewEmail>
                    <modalCancel
                        :header="header"
                        :url="url"
                        :btnTrans="btnTrans"
                        :profile="profile"
                        :disable="disableFlag || !confirmFlag"
                        @cancel="disableCancel"
                    >
                    </modalCancel>
                    <button
                        type="button" :class="btnTrans.add.class + ' btn-lg tw-w-25'" @click.prevent="addPolicyList()" :disabled="disableFlag || !confirmFlag">
                        <i :class="btnTrans.add.icon"></i> {{ btnTrans.add.text }}กลุ่มกรมธรรม์
                    </button>
                </div>
            </div>
            <div v-if="policyLists.length" class="hr-line-dashed mt-3" style="margin: 1px;"></div>
            <!-- กรมธรรม์ -->
            <headerList
                v-for="(row, index) in policyLists"
                :key="row.uid"
                :attribute="row"
                :index="index"
                :header="header"
                :insuranceLists="insuranceLists"
                :claimApplyDetail="clApplyDetail"
                :claimApplyComp="clApplyComp"
                :policyGroups="policyGroups"
                :policyGroupSets="policyGroupSets"
                :companies="companies"
                :policyLists="policyLists"
                :btnTrans="btnTrans"
                :disable="disableFlag || !confirmFlag"
                :url="purl"
                ref="headerList"
                @removeHeader="removeHeader"
                @removeLine="removeLine"
                @detailLists="getDetailLists"
                @validateInput="validateInput"
            />
            <div class="hr-line-dashed mt-3" style="margin: 1px;"></div>
            <div class="col-12 text-right mt-4 btnTab" v-if="policyLists.length || insuranceLists.length">
                <button type="button" :class="btnTrans.save.class + ' btn-lg tw-w-25'" @click.prevent="submit()"
                    :disabled="!confirmFlag">
                    <i :class="btnTrans.save.icon"></i> {{ btnTrans.save.text }}
                </button>
                <template v-if="!vshow">
                    <button type="button" :class="btnTrans.irp10_report.class + ' btn-lg tw-w-25'" @click.prevent="getReportIRR9140()">
                        <i :class="btnTrans.irp10_report.icon"></i> {{ btnTrans.irp10_report.text }}
                    </button>
                    <!-- --------------------------------- -->
                    <button v-if="confirmFlag"
                        type="button" :class="btnTrans.confirm.class + ' btn-lg tw-w-25'" @click.prevent="updateClaimStatus()" :disabled="disableFlag">
                        <i :class="btnTrans.confirm.icon"></i> {{ btnTrans.confirm.text }} (ล็อค)
                    </button>
                    <button v-else
                        type="button"
                        :class="btnTrans.cancel.class + ' btn-lg tw-w-25'"
                        @click="vshow = confirmFlag = !confirmFlag"
                        :disabled="disableFlag">
                        <i :class="btnTrans.edit.icon"></i> {{ btnTrans.edit.text }} (ปลดล็อค)
                    </button>
                </template>
            </div>

        </form>
    </div>
</template>

<script>
    import moment from "moment";
    import uuidv1 from 'uuid/v1';
    import lovDepartment from '../lovDepartment.vue'
    import lovLocation from '../lovLocation.vue'
    import modalPreviewEmail from '../modalPreviewEmail.vue'
    import headerList from './Header.vue'
    import modalCancel from './modalCancel.vue'
    export default {
        props:[
            'claim', 'claimPolicyGroup', 'claimApplyDetail', 'claimApplyComp', 'policyGroups', 'policyGroupSets', 'companies', 'fileInsurance', 'fileApprove', 'fileAll', 'user', 'btnTrans', 'purl', 'profile'
        ],
        components: {
            lovDepartment, lovLocation, modalPreviewEmail, headerList, modalCancel
        },
        mounted(){
            var accDate = this.claim? this.claim.accident_date: moment().format('YYYY-MM-DD');
            var insuranceDate = this.claim? this.claim.insurance_date: '';
            this.header.accident_date = this.changeToTh(accDate);
            this.header.insurance_date = this.changeToTh(insuranceDate);
            this.disableFlag = (!this.claim? false: (this.claim.irp0011_status == 'CANCELLED' || this.claim.irp0011_status == 'INTERFACE'))? true: false;
            //--------------------
            this.loopPolicyList();
        },
        data () {
            return {
                
                loading: false,
                url: this.purl,
                header: {
                    claim_header_id: this.claim? this.claim.claim_header_id: '',
                    journal_number: this.claim? this.claim.journal_number: '',
                    document_number: this.claim? this.claim.document_number: '',
                    requestor_id: this.claim? this.claim.requestor_id: this.user.user_id,
                    requestor_name: this.claim? this.claim.requestor_name: this.user.name,
                    department_code: this.claim? this.claim.department_code: this.user.department_code,
                    requestor_tel: this.claim? this.claim.requestor_tel: '',
                    accident_date: this.claim? this.claim.accident_date: '',
                    accident_time: this.claim? this.claim.accident_time : moment().format('YYYY-MM-DD H:mm'),
                    location_name: this.claim? this.claim.location_name: '',
                    claim_amount: this.claim? this.claim.claim_amount: 0,
                    insurance_date: this.claim? this.claim.insurance_date: '',
                    total_claim_amount: this.claim? this.claim.total_claim_amount: 0,
                    status: this.claim? this.claim.irp0011_status: 'NEW',
                    insurance_status: this.claim? this.claim.irp0011_insurance_status: 'NEW',
                    claim_title: this.claim? this.claim.claim_title: '',
                    remarks: this.claim? this.claim.remarks: '',
                    cancelled_reason: this.claim? this.claim.cancelled_reason: '',
                    ar_invoice_amount: this.claim? this.claim.ar_invoice_amount: 0,
                    period_year: this.claim? this.claim.year: '',
                },
                errors: {
                    attac_approve: false
                },
                maximum: 20,
                fileListInsurance: this.claim? this.fileInsurance: [],
                fileListApprove: this.claim? this.fileApprove: [],
                fileListAll: this.claim? this.fileAll: [],
                fileListAdded: [],
                disableFlag: (!this.claim? false: this.claim.irp0011_status == 'CANCELLED' || this.claim.irp0011_status == 'INTERFACE')? true: false,
                confirmFlag: (!this.claim? false: this.claim.irp0011_status == 'NEW')? true: false,
                chooseFile: [],
                policyLists: [],
                insuranceLists: [],
                detailLists: [],
                //---------------------
                token_csrf: document.head.querySelector('meta[name="csrf-token"]').content ,
                summaryAmountPolicy: {},
                vshow: (!this.claim? false: this.claim.irp0011_status == 'NEW')? true: false,
                //---------------------
                clPolicyGroup: this.claimPolicyGroup,
                clApplyDetail: this.claimApplyDetail,
                clApplyComp: this.claimApplyComp,
            }
        },
        computed: {
            //total policyLists
            totalApply() {
                return this.policyLists.reduce((accumulator, line) => {
                    return accumulator + parseFloat(line.claim_amount);
                }, 0);
            },
            // call and push amount for check by policy
            summaryAmountByPolicy(){
                var result = [];
                this.insuranceLists.reduce(function(res, value) {
                    if (!res[value.policy]) {
                        res[value.policy] = { policy: value.policy, amount: 0 };
                        result.push(res[value.policy]);
                    }
                    res[value.policy].amount += Number(value.amount);
                    return res;
                }, {});
                this.summaryAmountPolicy = result;
            },
        },
        watch:{
            errors: {
                handler(val){
                    val.requestor_name? this.setError('requestor_name') : this.resetError('requestor_name');
                    val.requestor_tel? this.setError('requestor_tel') : this.resetError('requestor_tel');
                    val.accident_time? this.setError('accident_time') : this.resetError('accident_time');
                    val.location_name? this.setError('location_name') : this.resetError('location_name');
                },
                deep: true,
            },
            totalApply(newValue){
                this.header.ar_invoice_amount = newValue;
                return newValue;
            },
            summaryAmountByPolicy(newValue){
                return newValue;
            },
        },
        methods: {
            addPolicyList() {
                let vm = this;
                let valid = true;
                // Check data header/line is null 16062022
                vm.callCheckError();
                if (vm.policyLists.length >= 1) {
                    vm.policyLists.filter((head, indexH) => {
                        if (head.policy_group == '' && head.policy_set == '' && head.claim_amount <= 0) { valid = false; }
                    });
                }
                if (vm.insuranceLists.length >= 1) {
                    vm.insuranceLists.filter((item, index) => {
                        if (item.item == '' || item.amount == '') { valid = false; }
                    });
                }

                if (!valid) {
                    return;
                }
                //-------------------------------------------------------------------------------------------
                // New Requirement : Check Amount By Policy
                vm.policyLists.filter(pol => {
                    // get Desc Policy for show
                    let policyGroup = vm.policyGroups.find(item => item.group_header_id === pol.policy_group);
                    let policySet = vm.policyGroupSets.find(item => item.policy_set_header_id === pol.policy_set);

                    // Check Header 20220622
                    if (pol.policy_group == '' && pol.policy_set == '' && pol.claim_amount <= 0) {
                        valid = false;
                        swal({
                            title: '<div class="mt-4"> แจ้งเตือนข้อมูลกลุ่มกรมธรรม์ </div>',
                            text: '<span style="font-size: 16px; text-align: left;"> กรุณาระบุข้อมูลกลุ่มกรมธรรม์ให้ครบถ้วนก่อนเพิ่มรายการใหม่ </span>',
                            type: "error",
                            html: true
                        });
                    }

                    // check line 20220622
                    if (vm.summaryAmountPolicy.length <= 0) {
                        valid = false;
                        swal({
                            title: '<div class="mt-4"> แจ้งเตือนข้อมูลรายละเอียดความเสียหาย </div>',
                            text: '<span style="font-size: 16px; text-align: left;"> กรุณาระบุข้อมูลรายละเอียดความเสียหายอย่างน้อง 1 รายการ ของรายการกลุ่มกรมธรรม์: '+ policyGroup.group_code +', ชุดกรมธรรม์: '+ policySet.policy_set_header_id  +'</span>',
                            type: "error",
                            html: true
                        });
                    }

                    // Check data
                    if (vm.summaryAmountPolicy.length > 0) {
                        vm.summaryAmountPolicy.filter(sum => {
                            if (pol.policy_group+'|'+pol.policy_set == sum.policy && pol.claim_amount > sum.amount) {
                                valid = false;
                                swal({
                                    title: '<div class="mt-4"> แจ้งเตือนข้อมูลจำนวนเงิน </div>',
                                    text: '<span style="font-size: 16px; text-align: left;"> จำนวนเงินของรายการ กลุ่มกรมธรรม์: '+ policyGroup.group_code +', ชุดกรมธรรม์: '+ policySet.policy_set_header_id +' <br/>ไม่เท่ากับจำนวนเงินเรียกชดใช้ </span>',
                                    type: "error",
                                    html: true
                                });
                            }

                            let policyFlag = false;
                            let insuranceFlag = false;
                            vm.policyLists.filter(function(elem){
                                                if(elem.policy_group+'|'+elem.policy_set == sum.policy) {
                                                    return policyFlag = true;
                                                }
                                            });

                            vm.insuranceLists.filter(function(elem){
                                                if(elem.policy == pol.policy_group+'|'+pol.policy_set) {
                                                    return insuranceFlag = true;
                                                }
                                            });

                            if (!policyFlag || !insuranceFlag) {
                                valid = false;
                                swal({
                                    title: '<div class="mt-4"> แจ้งเตือนข้อมูลรายละเอียดความเสียหาย </div>',
                                    text: '<span style="font-size: 16px; text-align: left;"> กรุณาระบุข้อมูลรายละเอียดความเสียหายอย่างน้อง 1 รายการ ของรายการกลุ่มกรมธรรม์: '+ policyGroup.group_code +', ชุดกรมธรรม์: '+ policySet.policy_set_header_id +'</span>',
                                    type: "error",
                                    html: true
                                });
                            }
                        });
                    }
                });
                if (!valid) {
                    return;
                }
                // scoll down
                const el = this.$el.getElementsByClassName('btnTab')[0];
                if (el) {
                    el.scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
                }
                vm.vshow = true; //--เมื่อเพิ่มกลุ่มกรมธรรม์จะซ่อน ปุ่มยืนยัน
                vm.policyLists.push({
                    uid: uuidv1(),
                    id: '',
                    policy_group: '',
                    policy_set: '',
                    claim_amount: 0,
                });
            },
            loopPolicyList() {
                this.clPolicyGroup.filter(item => {
                    this.policyLists.push({
                        uid: uuidv1(),
                        id: item.claim_group_id,
                        policy_group: item.group_header_id,
                        policy_set: item.policy_set_header_id,
                        claim_amount: item.amount,
                    });
                })
            },
            validateInput(res){
                this.vshow = res; //--เมื่อเพิ่มกลุ่มกรมธรรม์จะซ่อน ปุ่มยืนยัน
            },
            removeHeader(res) {
                this.vshow = true; //--เมื่อเพิ่มกลุ่มกรมธรรม์จะซ่อน ปุ่มยืนยัน
                this.policyLists = this.policyLists.filter( item => {
                    return item.uid != res.uid;
                });
                // remove insuranceLists
                this.insuranceLists = this.insuranceLists.filter( list => {
                    return list.policy != res.policy_group+'|'+res.policy_set;
                });
            },
            removeLine(res) {
                this.vshow = true; //--เมื่อเพิ่มกลุ่มกรมธรรม์จะซ่อน ปุ่มยืนยัน
                this.insuranceLists = res.itemLines;
            },
            getDetailLists(detailLists) {
                detailLists.filter( list => {
                    this.detailLists.push(list);
                });
            },
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
                    vm.fileListApprove = [];
                    vm.fileListAll = [];
                    vm.fileListApprove = res.file_approve;
                    vm.fileListAll = res.file_all;
                    swal({
                        title: '<div class="mt-4"> เอกสารแจ้งเหตุความเสียหาย </div>',
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
            // Save
            async submit(){
                let vm = this;
                var form  = $('#claim-form');
                let valid = true;
                let errorMsg = '';
                // validate before save
                // Check data line is null 16062022
                vm.callCheckError();
                if (vm.policyLists.length >= 1) {
                    vm.policyLists.filter((head, indexH) => {
                        if (head.policy_group == '' && head.policy_set == '' && head.claim_amount <= 0) { valid = false; }
                    });
                }
                if (vm.insuranceLists.length >= 1) {
                    vm.insuranceLists.filter((item, index) => {
                        if (item.item == '' || item.amount == '') { valid = false; }
                    });
                }
                if (!valid) {
                    return;
                }
                //--------------------------------------------------------------------------
                // New Requirement : Check Amount By Policy
                vm.policyLists.filter(pol => {
                    // get Desc Policy for show
                    let policyGroup = vm.policyGroups.find(item => item.group_header_id === pol.policy_group);
                    let policySet = vm.policyGroupSets.find(item => item.policy_set_header_id === pol.policy_set);
                    // Check Header 20220622
                    if (pol.policy_group == '' && pol.policy_set == '' && pol.claim_amount <= 0) {
                        valid = false;
                        swal({
                            title: '<div class="mt-4"> แจ้งเตือนข้อมูลกลุ่มกรมธรรม์ </div>',
                            text: '<span style="font-size: 16px; text-align: left;"> กรุณาระบุข้อมูลกลุ่มกรมธรรม์ให้ครบถ้วนก่อนเพิ่มรายการใหม่ </span>',
                            type: "error",
                            html: true
                        });
                    }
                    // check line 20220622
                    if (vm.summaryAmountPolicy.length <= 0) {
                        valid = false;
                        swal({
                            title: '<div class="mt-4"> แจ้งเตือนข้อมูลรายละเอียดความเสียหาย </div>',
                            text: '<span style="font-size: 16px; text-align: left;"> กรุณาระบุข้อมูลรายละเอียดความเสียหายอย่างน้อง 1 รายการ ของรายการกลุ่มกรมธรรม์: '+ policyGroup.group_code +', ชุดกรมธรรม์: '+ policySet.policy_set_header_id  +'</span>',
                            type: "error",
                            html: true
                        });
                    }
                    // Check data
                    if (vm.summaryAmountPolicy.length > 0) {
                        vm.summaryAmountPolicy.filter(sum => {
                            if (pol.policy_group+'|'+pol.policy_set == sum.policy && pol.claim_amount > sum.amount) {
                                valid = false;
                                swal({
                                    title: '<div class="mt-4"> แจ้งเตือนข้อมูลจำนวนเงิน </div>',
                                    text: '<span style="font-size: 16px; text-align: left;"> จำนวนเงินของรายการ กลุ่มกรมธรรม์: '+ policyGroup.group_code +', ชุดกรมธรรม์: '+ policySet.policy_set_header_id +' <br/>ไม่เท่ากับจำนวนเงินเรียกชดใช้ </span>',
                                    type: "error",
                                    html: true
                                });
                            }

                            let policyFlag = false;
                            let insuranceFlag = false;
                            vm.policyLists.filter(function(elem){
                                                if(elem.policy_group+'|'+elem.policy_set == sum.policy) {
                                                    return policyFlag = true;
                                                }
                                            });

                            vm.insuranceLists.filter(function(elem){
                                                if(elem.policy == pol.policy_group+'|'+pol.policy_set) {
                                                    return insuranceFlag = true;
                                                }
                                            });

                            if (!policyFlag || !insuranceFlag) {
                                valid = false;
                                swal({
                                    title: '<div class="mt-4"> แจ้งเตือนข้อมูลรายละเอียดความเสียหาย </div>',
                                    text: '<span style="font-size: 16px; text-align: left;"> กรุณาระบุข้อมูลรายละเอียดความเสียหายอย่างน้อง 1 รายการ ของรายการกลุ่มกรมธรรม์: '+ policyGroup.group_code +', ชุดกรมธรรม์: '+ policySet.policy_set_header_id +'</span>',
                                    type: "error",
                                    html: true
                                });
                            }
                        });
                    }
                });
                if (!valid) {
                    return;
                }
                // -------------------
                swal({
                    html: true,
                    title: '<div class="mt-4"> บันทึกข้อมูลรายละเอียดการเคลมประกันภัย </div>',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 16px"> คุณต้องการยืนยันบันทึกข้อมูลรายละเอียดการเคลมประกันภัย ? </span></h2>',
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
                        let res = await vm.create();
                        vm.loading = false;
                        vm.vshow = false;
                        if(res.status == 'S'){
                            // -------------------------------------------------------
                            var accDate = res.header.accident_date;
                            var insuranceDate = res.header.insurance_date
                            vm.header.accident_date = vm.changeToTh(accDate);
                            vm.header.insurance_date = vm.changeToTh(insuranceDate);

                            vm.header.claim_header_id = res.header.claim_header_id;
                            vm.header.journal_number = res.header.journal_number;
                            vm.header.document_number = res.header.document_number;
                            vm.header.requestor_id = res.header.requestor_id;
                            vm.header.requestor_name = res.header.requestor_name;
                            vm.header.department_code = res.header.department_code;
                            vm.header.requestor_tel = res.header.requestor_tel;
                            // vm.header.accident_date = res.header.accident_date;
                            vm.header.accident_time = res.header.accident_time;
                            vm.header.location_name = res.header.location_name;
                            vm.header.claim_amount = res.header.claim_amount;
                            // vm.header.insurance_date = res.header.insurance_date;
                            vm.header.total_claim_amount = res.header.total_claim_amount;
                            vm.header.status = res.header.irp0011_status;
                            vm.header.insurance_status = res.header.irp0011_insurance_status;
                            vm.header.claim_title = res.header.claim_title;
                            vm.header.remarks = res.header.remarks
                            vm.header.cancelled_reason = res.header.cancelled_reason;
                            vm.header.ar_invoice_amount = res.header.ar_invoice_amount;
                            // -------------------------------------------------------
                            vm.clPolicyGroup = res.claimPolicyGroup;
                            vm.clApplyDetail = res.claimApplyDetail;
                            vm.clApplyComp = res.claimApplyComp;
                            vm.policyLists = [];
                            vm.insuranceLists = [];
                            vm.detailLists = [];
                            // loop data : policy group
                            res.claimPolicyGroup.filter(policy => {
                                vm.policyLists.push({
                                    uid: uuidv1(),
                                    id: policy.claim_group_id,
                                    policy_group: policy.group_header_id,
                                    policy_set: policy.policy_set_header_id,
                                    claim_amount: policy.amount
                                });
                            });
                            swal({
                                title: '<div class="mt-4"> บันทึกข้อมูลรายละเอียดการเคลมประกันภัย </div>',
                                text: '<span style="font-size: 16px; text-align: left;"> ทำการบันทึกข้อมูลรายละเอียดการเคลมประกันภัยเรียบร้อยแล้ว </span>',
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
                    }
                });
            },
            async create() {
                let vm = this;
                vm.loading = true;
                let data = {
                    msg: ''
                };
                let params = {
                    totalClaimAmount:  vm.header.total_claim_amount,
                    policyLists:  vm.policyLists,
                    insuranceLists: vm.insuranceLists,
                    detailLists: vm.detailLists,
                };
                await axios
                .post(vm.url.ajax_update_claim, {params})
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
                    vm.loading = false;
                });
                return data;
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
            disableComfirm(res){
                if (res.confirm_status == 'S') {
                    this.fileListAll = res.fileAll;
                    this.chooseFile.filter( file => {
                        this.fileListApprove = this.fileListApprove.filter( item => {
                            return item.uid != file;
                        });
                    });
                    this.chooseFile = [];
                }
            },
            disableCancel(res){
                this.disableFlag = res.disableFlag;
                this.header.status = res.status;
                this.header.insurance_status = res.status;
                this.header.cancelled_reason = res.reason;
            },
            async updateClaimStatus(){
                let vm = this;
                var form  = $('#claim-form');
                let valid = true;
                let errorMsg = '';
                swal({
                    html: true,
                    title: '<div class="mt-4"> ยืนยันข้อมูลรายละเอียดการเคลมประกันภัย </div>',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการยืนยันข้อมูลรายละเอียดการเคลมประกันภัย ? </span></h2>',
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
                        vm.updateConfirm();
                    }
                });
            },
            async updateConfirm(){
                let vm = this;
                // let params = {
                //     totalClaimAmount:  vm.header.total_claim_amount,
                //     policyLists:  vm.policyLists,
                //     insuranceLists: vm.insuranceLists,
                //     detailLists: vm.detailLists,
                // };
                await axios
                .get(vm.url.ajax_update_confirm)
                .then(res => {
                    vm.loading = false;
                    if (res.data.status == 'S') {
                        vm.confirmFlag = false;
                        vm.vshow = false;
                        // // -------------------------------------------------------
                        // var accDate = res.data.header.accident_date;
                        // var insuranceDate = res.data.header.insurance_date
                        // vm.header.accident_date = vm.changeToTh(accDate);
                        // vm.header.insurance_date = vm.changeToTh(insuranceDate);

                        // vm.header.claim_header_id = res.data.header.claim_header_id;
                        // vm.header.journal_number = res.data.header.journal_number;
                        // vm.header.document_number = res.data.header.document_number;
                        // vm.header.requestor_id = res.data.header.requestor_id;
                        // vm.header.requestor_name = res.data.header.requestor_name;
                        // vm.header.department_code = res.data.header.department_code;
                        // vm.header.requestor_tel = res.data.header.requestor_tel;
                        // // vm.header.accident_date = res.data.header.accident_date;
                        // vm.header.accident_time = res.data.header.accident_time;
                        // vm.header.location_name = res.data.header.location_name;
                        // vm.header.claim_amount = res.data.header.claim_amount;
                        // // vm.header.insurance_date = res.data.header.insurance_date;
                        // vm.header.total_claim_amount = res.data.header.total_claim_amount;
                        // vm.header.status = res.data.header.irp0011_status;
                        // vm.header.insurance_status = res.data.header.irp0011_insurance_status;
                        // vm.header.claim_title = res.data.header.claim_title;
                        // vm.header.remarks = res.data.header.remarks
                        // vm.header.cancelled_reason = res.data.header.cancelled_reason;
                        // vm.header.ar_invoice_amount = res.data.header.ar_invoice_amount;
                        // // -------------------------------------------------------
                        // vm.clPolicyGroup = res.data.claimPolicyGroup;
                        // vm.clApplyDetail = res.data.claimApplyDetail;
                        // vm.clApplyComp = res.data.claimApplyComp;
                        // vm.policyLists = [];
                        // vm.insuranceLists = [];
                        // vm.detailLists = [];
                        // // loop data : policy group
                        // res.data.claimPolicyGroup.filter(policy => {
                        //     vm.policyLists.push({
                        //         uid: uuidv1(),
                        //         id: policy.claim_group_id,
                        //         policy_group: policy.group_header_id,
                        //         policy_set: policy.policy_set_header_id,
                        //         claim_amount: policy.amount
                        //     });
                        // });
                        vm.header.status = res.data.irp0011_status;
                        swal({
                            title: '<div class="mt-4"> ยืนยันข้อมูลรายละเอียดการเคลมประกันภัย </div>',
                            text: '<span style="font-size: 16px; text-align: left;"> ทำการยืนยันข้อมูลรายละเอียดการเคลมประกันภัยเรียบร้อย </span>',
                            type: "success",
                            html: true
                        });
                    }else{
                        swal({
                            title: '<div class="mt-4"> มีข้อผิดพลาด </div>',
                            text: '<span style="font-size: 16px; text-align: left;">'+res.data.msg+'</span>',
                            type: "warning",
                            html: true
                        });
                    }
                });
            },
            async updateClaimHeader(){
                let vm = this;
                let params = {
                    journalNumber: vm.header.journal_number,
                    totalClaimAmount: vm.header.total_claim_amount,
                };
                vm.loading = true;
                await axios
                .post(vm.url.ajax_update_claim_header, {params})
                .then(res => {
                    vm.loading = false;
                    if (res.data.status == 'S') {
                        vm.header.journal_number = res.data.header.journal_number;
                        vm.header.total_claim_amount = res.data.header.total_claim_amount;
                        swal({
                            title: '<div class="mt-4"> บันทึกข้อมูลรายละเอียดการเคลมประกันภัย </div>',
                            text: '<span style="font-size: 16px; text-align: left;"> ทำการบันทึกข้อมูลรายละเอียดการเคลมประกันภัยเรียบร้อย </span>',
                            type: "success",
                            html: true
                        });
                    }else{
                        swal({
                            title: '<div class="mt-4"> มีข้อผิดพลาด </div>',
                            text: '<span style="font-size: 16px; text-align: left;">'+res.data.msg+'</span>',
                            type: "warning",
                            html: true
                        });
                    }
                });
            },
            async getReportIRR9140(){
                let vm = this;
                let url = vm.url.get_report_irr9140+'?year='+vm.claim.year;
                window.open(url, '_blank');
            },
            removeFileIRP0011(fileId) {
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
                .post(vm.url.ajax_delete_file_irp0011, {params})
                .then(res => {
                    if(res.data.data.status == 'S'){
                        vm.loading = false;
                        vm.fileListApprove = [];
                        vm.fileListAll = [];
                        vm.fileListApprove = res.data.data.file_approve;
                        vm.fileListAll = res.data.data.file_all;
                        swal({
                            title: '<div class="mt-4"> เอกสารแจ้งเหตุความเสียหาย </div>',
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
                    swal({
                        title: '<div class="mt-4"> มีข้อผิดพลาด </div>',
                        text: msg.message,
                        type: "error",
                        html: true
                    });
                })
            },
            callCheckError(){
                let vm = this;
                let valid = '';
                if (vm.policyLists.length >= 1) {
                    // Check Header 20220622
                    vm.policyLists.filter((head, indexH) => {
                        vm.$refs.headerList[indexH].checkListErrors();
                        if (head.policy_group == '' && head.policy_set == '' && head.claim_amount <= 0) { valid = false; }
                        // Check Line 20220622
                        if (vm.insuranceLists.length >= 1) {
                            vm.insuranceLists.filter((item, indexL) => {
                                vm.$refs.headerList[indexH].$refs.listItem[indexL].checkListErrors();
                                if (item.item == '' || item.amount == '') { valid = false; }
                            });
                        }
                    });
                }
                return valid;
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
        }
    }
</script>

<style type="text/css">
    .el-upload-list__item-name{
        font-size: 10px;
    }
</style>