<template>
    <span :key="uuid">
        <button type="button" :class="btnTrans.detail.class + ' btn-sm tw-w-25'" style="margin: 0px" @click="openModal">
            <i :class="btnTrans.detail.icon"></i> {{ btnTrans.detail.text }}
        </button>

        <div class="modal fade" :id="'modal_detail_'+uuid" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" v-loading="loading">
                    <div class="modal-header">
                        <h4 style="font-size:22px; font-weight:400;" class="modal-title text-left">
                            รายละเอียด (Details)
                        </h4>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true"> &times; </span> <span class="sr-only"> Close </span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <form id="form-detail" onkeydown="return event.key != 'Enter';">
                            <template v-for="detail in detailList">
                                <template v-if="detail.company === company.company_code && detail.policy_number == company.policy_number">
                                    <div class="col-lg-12">
                                        <div class="row mt-3"> <h3> สถานะแจ้งบริษัทประกัน </h3> </div>
                                        <div class="row mt-3">
                                            <label class="col-md-4 offset-md-1 col-form-label text-right" style="font-weight: 500;">
                                                วันที่แจ้งบริษัทประกัน
                                            </label>
                                            <div class="col-xl-4 col-lg-4 col-md-4">
                                                <datepicker-th
                                                    style="width: 100%;"
                                                    class="form-control md:tw-mb-0 tw-mb-2" 
                                                    name="insurance_date"
                                                    id="insurance_date"
                                                    placeholder="วันที่แจ้งบริษัทประกัน"
                                                    p-type="date"
                                                    :value="detail.insurance_date"
                                                    v-model="detail.insurance_date"
                                                    format="DD/MM/YYYY"
                                                    @dateWasSelected="wasSelectInsuranceDate"
                                                    disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed mt-3" style="margin: 1px;"></div>
                                    <div class="col-lg-12">
                                        <div class="row mt-3"> <h3> สถานะบริษัทประกันยืนยันการชดใช้ </h3> </div>
                                        <!-- Invoice Date -->
                                        <div class="row mt-3">
                                            <label class="col-md-4 offset-md-1 col-form-label text-right" style="font-weight: 500;">
                                                Invoice Date
                                            </label>
                                            <div class="col-xl-4 col-lg-4 col-md-4">
                                                <div class="input-group">
                                                    <datepicker-th
                                                        style="width: 100%;"
                                                        class="form-control md:tw-mb-0 tw-mb-2"
                                                        name="invoice_date"
                                                        id="invoice_date"
                                                        placeholder="Invoice Date"
                                                        p-type="date"
                                                        :value="detail.invoice_date"
                                                        v-model="detail.invoice_date"
                                                        format="DD/MM/YYYY"
                                                        @dateWasSelected="wasSelectInvoiceDate"
                                                        disabled />
                                                </div>
                                                <div id="el_explode_invoice_date" class="error_msg text-left"></div>
                                            </div>
                                        </div>
                                        <!-- GL Date -->
                                        <div class="row mt-3">
                                            <label class="col-md-4 offset-md-1 col-form-label text-right" style="font-weight: 500;">
                                                GL Date
                                            </label>
                                            <div class="col-xl-4 col-lg-4 col-md-4">
                                                <div class="input-group">
                                                    <datepicker-th
                                                        style="width: 100%;"
                                                        class="form-control md:tw-mb-0 tw-mb-2"
                                                        name="gl_date"
                                                        id="gl_date"
                                                        placeholder="GL Date"
                                                        p-type="date"
                                                        :value="detail.gl_date"
                                                        v-model="detail.gl_date"
                                                        format="DD/MM/YYYY"
                                                        @dateWasSelected="wasSelectGlDate"
                                                        disabled />
                                                </div>
                                                <div id="el_explode_gl_date" class="error_msg text-left"></div>
                                            </div>
                                        </div>
                                        <!-- เลขที่อ้างอิงกับเอกสารระบบ AR -->
                                        <div class="row mt-3">
                                            <label class="col-md-4 offset-md-1 col-form-label text-right" style="font-weight: 500;">
                                                เลขที่อ้างอิงกับเอกสารระบบ AR
                                            </label>
                                            <div class="col-xl-4 col-lg-4 col-md-4">
                                                <div class="input-group">
                                                    <el-input name="ref_ar_number"
                                                            placeholder="เลขที่อ้างอิงกับเอกสารระบบ AR"
                                                            size="medium"
                                                            v-model="detail.ref_ar_number"
                                                            autocomplete="off"
                                                            disabled>
                                                    </el-input>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- เลขที่อ้างอิงกับเอกสารระบบ AR -->
                                        <div class="row mt-3">
                                            <label class="col-md-4 offset-md-1 col-form-label text-right" style="font-weight: 500;">
                                                เลขที่กรมธรรม์
                                            </label>
                                            <div class="col-xl-4 col-lg-4 col-md-4">
                                                <div class="input-group">
                                                    <el-input name="policy_number"
                                                            placeholder="เลขที่กรมธรรม์"
                                                            v-model="detail.policy_number"
                                                            size="medium"
                                                            autocomplete="off"
                                                            disabled >
                                                    </el-input>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed mt-3" style="margin: 1px;"></div>
                                    <div class="col-lg-12">
                                        <div class="row mt-3"> <h3> สถานะได้รับชดใช้แล้ว </h3> </div>
                                        <!-- วันที่ได้รับชดใช้ -->
                                        <div class="row mt-3">
                                            <label class="col-md-4 offset-md-1 col-form-label text-right" style="font-weight: 500;">
                                                วันที่ได้รับชดใช้
                                            </label>
                                            <div class="col-xl-4 col-lg-4 col-md-4">
                                                <div class="input-group">
                                                    <datepicker-th
                                                        style="width: 100%;"
                                                        class="form-control md:tw-mb-0 tw-mb-2"
                                                        name="receipt_date"
                                                        id="receipt_date"
                                                        placeholder="วันที่ได้รับชดใช้"
                                                        p-type="date"
                                                        :value="detail.receipt_date"
                                                        v-model="detail.receipt_date"
                                                        format="DD/MM/YYYY"
                                                        @dateWasSelected="wasSelectReceiptDate"
                                                        disabled/>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- เลขที่ใบเสร็จรับเงิน -->
                                        <div class="row mt-3">
                                            <label class="col-md-4 offset-md-1 col-form-label text-right" style="font-weight: 500;">
                                                เลขที่ใบเสร็จรับเงิน
                                            </label>
                                            <div class="col-xl-4 col-lg-4 col-md-4">
                                                <div class="input-group">
                                                    <el-input name="receipt_number"
                                                            v-model="detail.receipt_number"
                                                            placeholder="เลขที่ใบเสร็จรับเงิน"
                                                            size="medium"
                                                            autocomplete="off"
                                                            disabled>
                                                    </el-input>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- จำนวนเงินที่ได้รับ -->
                                        <div class="row mt-3">
                                            <label class="col-md-4 offset-md-1 col-form-label text-right" style="font-weight: 500;">
                                                จำนวนเงินที่ได้รับ
                                            </label>
                                            <div class="col-xl-4 col-lg-4 col-md-4">
                                                <div class="input-group">
                                                    <vue-numeric style="width: 1000%"
                                                        name="claim_amount"
                                                        separator="," 
                                                        v-bind:precision="2" 
                                                        v-bind:minus="false"
                                                        :min="0"
                                                        :max="999999999"
                                                        class="form-control input-sm text-right"
                                                        v-model="detail.receipt_amount"
                                                        disabled
                                                    ></vue-numeric>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </template>
                        </form>
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
        props:['header', 'index', 'btnTrans', 'company', 'policyList', 'detailLists'],
        data() {
            return {
                loading: false,
                detailList: this.detailLists,
                uuid: '',
            }
        },
        mounted() {
            this.uuid = uuidv1();
        },
        computed: {
            //
        },
        watch:{
            defaultDesc: async function (value, oldValue) {
                this.defaultDesc = value;
            },
        },
        methods: {
            wasSelectInsuranceDate(date){
                this.detailList.insurance_date = date? moment(date).format('DD/MM/YYYY'): '';
            },
            wasSelectInvoiceDate(date){
                this.detailList.invoice_date = date? moment(date).format('DD/MM/YYYY'): '';
                if (this.detailList.gl_date == '' || this.detailList.gl_date == null) {
                    this.detailList.gl_date = date? moment(date).format('DD/MM/YYYY'): '';
                }
            },
            wasSelectGlDate(date){
                this.detailList.gl_date = date? moment(date).format('DD/MM/YYYY'): '';
            },
            wasSelectReceiptDate(date){
                this.detailList.receipt_date = date? moment(date).format('DD/MM/YYYY'): '';
            },
            openModal() {
                let vm = this;
                $('#modal_detail_'+vm.uuid).modal('show');
            },
        }
    }
</script>