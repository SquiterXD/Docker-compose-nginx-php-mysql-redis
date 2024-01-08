<template>
    <div v-loading="loading">
        <form id="claim-form" :action="url.submit_claim">
            <div class="col-lg-12">
                <div class="row mt-3">
                    <label class="col-md-3 col-form-label text-right">
                        <strong> ตั้งแต่ปี <!-- <span class="text-danger"> * </span> --></strong>
                    </label>
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <div class="input-group">
                            <datepicker-th
                                :style="'width: 100%; ' + (errors.start_year? 'border: 1px solid red;' : '')"
                                class="form-control md:tw-mb-0 tw-mb-2"
                                name="search[start_year]"
                                id="start_year"
                                placeholder="ตั้งแต่ปี"
                                p-type="year"
                                :value="searchInput.start_year"
                                v-model="searchInput.start_year"
                                format="YYYY"
                                @dateWasSelected="yearWasSelectedFrom"/>
                        </div>
                        <div id="el_explode_start_year" class="error_msg text-left"></div>
                    </div>
                    <label class="col-md-2 col-form-label text-right">
                        <strong> ถึง <!-- <span class="text-danger"> * </span> --></strong>
                    </label>
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <div class="input-group">
                            <datepicker-th
                                :style="'width: 100%; ' + (errors.end_year? 'border: 1px solid red;' : '')"
                                class="form-control md:tw-mb-0 tw-mb-2"
                                name="search[end_year]"
                                id="end_year"
                                p-type="year"
                                placeholder="ถึงปี"
                                :value="searchInput.end_year"
                                v-model="searchInput.end_year"
                                format="YYYY"
                                :disabledDateTo="searchInput.start_year"
                                @dateWasSelected="yearWasSelectedTo"/>
                        </div>
                        <div id="el_explode_end_year" class="error_msg text-left"></div>
                    </div>
                </div>

                <div class="row mt-3">
                    <label class="col-md-3 col-form-label text-right">
                        <strong> วันที่เกิดเหตุ </strong>
                    </label>
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <div class="input-group">
                            <datepicker-th
                                    style="width: 100%;"
                                    class="form-control md:tw-mb-0 tw-mb-2"
                                    name="search[accident_start_date]"
                                    id="accident_start_date"
                                    placeholder="วันที่เกิดเหตุ"
                                    :value="searchInput.accident_start_date"
                                    v-model="searchInput.accident_start_date"
                                    format="DD/MM/YYYY"
                                    @dateWasSelected="dateWasSelectedFrom"/>
                        </div>
                        <div id="el_explode_accident_start_date" class="error_msg text-left"></div>
                    </div>
                    <label class="col-md-2 col-form-label text-right">
                        <strong> ถึง </strong>
                    </label>
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <div class="input-group">
                            <datepicker-th
                                    style="width: 100%;"
                                    class="form-control md:tw-mb-0 tw-mb-2"
                                    name="search[accident_end_date]"
                                    id="accident_end_date"
                                    placeholder="ถึงวันที่เกิดเหตุ"
                                    :value="searchInput.accident_end_date"
                                    v-model="searchInput.accident_end_date"
                                    format="DD/MM/YYYY"
                                    :disabledDateTo="searchInput.accident_start_date"
                                    @dateWasSelected="dateWasSelectedTo"/>
                        </div>
                        <div id="el_explode_accident_end_date" class="error_msg text-left"></div>
                    </div>
                </div>

                <div class="row mt-3">
                    <label class="col-md-3 col-form-label text-right">
                        <strong> หน่วยงาน </strong>
                    </label>
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <input type="hidden" name="search[department_from]" :value="searchInput.department_from">
                        <lov-department placeholder="หน่วยงาน"
                                    attrName="search[department_from]"
                                    :set-data="searchInput.department_from"
                                    @change-lov="getDepartmentSt" />
                    </div>
                    <label class="col-md-2 col-form-label text-right">
                        <strong> ถึง </strong>
                    </label>
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <input type="hidden" name="search[department_to]" :value="searchInput.department_to">
                        <lov-department placeholder="หน่วยงาน"
                                    attrName="search[department_to]"
                                    :set-data="searchInput.department_to"
                                    @change-lov="getDepartmentEnd" />
                    </div>
                </div>

                <div class="row mt-3">
                    <label class="col-md-3 col-form-label text-right">
                        <strong> เลขที่เอกสาร </strong>
                    </label>
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <lov-document-number placeholder="เลขที่เอกสาร"
                                        attrName="search[document_from]"
                                        name="search[document_from]"
                                        :set-data="searchInput.document_from"
                                        @change-value="getDataDocumentNoSt" />
                    </div>
                    <label class="col-md-2 col-form-label text-right">
                        <strong> ถึง </strong>
                    </label>
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <lov-document-number placeholder="เลขที่เอกสาร"
                                        attrName="search[document_to]"
                                        name="search[document_to]"
                                        :set-data="searchInput.document_to"
                                        @change-value="getDataDocumentNoEnd" />
                    </div>
                </div>
                <template v-if="profile.program_code == 'IRP0011'">
                    <div class="row mt-3">
                        <label class="col-md-3 col-form-label text-right">
                            <strong> เลขที่อ้างอิงเอกสารในระบบ AR </strong>
                        </label>
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <lov-invoice-number-ar attrName="search[ar_invoice_num]"
                                            name="search[ar_invoice_num]"
                                            placeholder="เลขที่อ้างอิงเอกสารในระบบ AR"
                                            :set-data="searchInput.ar_invoice_num"
                                            @change-value="getDataArInvoiceNum" />
                        </div>
                        <label class="col-md-2 col-form-label text-right">
                            <strong> เลขที่กรมธรรม์ </strong>
                        </label>
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <lov-policy-number :set-data="searchInput.policy_number"
                                            attrName="search[policy_number]"
                                            name="search[policy_number]"
                                            placeholder="เลขที่กรมธรรม์"
                                            @change-lov="getValuePolicyNumber" />
                        </div>
                    </div>
                </template>

                <div class="row mt-3">
                    <label class="col-md-3 col-form-label text-right">
                        <strong> สถานะรายการ </strong>
                    </label>
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <dropdown-status-ir :value="searchInput.status"
                                        name="search[status]"
                                        :profile="profile"
                                        @change-dropdown="getValueStatus"
                                    />
                    </div>
                </div>
            </div>
            <div class="text-right el_field">
                <button type="button" :class="btnTrans.search.class + ' btn-lg tw-w-25'" @click.prevent="submit()">
                    <i :class="btnTrans.search.icon"></i> {{ btnTrans.search.text }}
                </button>
                <a :href="url.submit_claim" :class="btnTrans.reset.class + ' btn-lg tw-w-25'">
                    <i :class="btnTrans.reset.icon"></i> {{ btnTrans.reset.text }}
                </a>
            </div>
        </form>
    </div>
</template>

<script>
import moment from "moment";
import yearInput from '../components/calendar/yearInput.vue'
import dateInput from '../components/calendar/dateInput.vue'
import lovDepartment from './lovDepartment.vue'
import lovDocumentNumber from './lovDocumentNumber.vue'
import lovInvoiceNumberAr from './lovInvoiceNumberAr.vue'
import lovPolicyNumber from './lovPolicyNumber.vue'
import dropdownStatusIr from './statusIr.vue'
export default {
    props:[
        'search', 'btnTrans', 'url', 'profile'
    ],
    components: {
        yearInput, dateInput, lovDepartment, lovDocumentNumber, lovInvoiceNumberAr, lovPolicyNumber, dropdownStatusIr
    },
    data () {
        return {
            loading: false,
            searchInput: {
                start_year: this.search? this.search.start_year: '' ,
                end_year: this.search? this.search.end_year: '' ,
                accident_start_date: this.search? this.search.accident_start_date: '' ,
                accident_end_date: this.search? this.search.accident_end_date: '' ,
                department_from: this.search? this.search.department_from: '' ,
                department_to: this.search? this.search.department_to: '' ,
                document_from: this.search? this.search.document_from: '' ,
                document_to: this.search? this.search.document_to: '' ,
                ar_invoice_num: this.search? this.search.ar_invoice_num: '' ,
                policy_number: this.search? this.search.policy_number: '' ,
                status: this.search? this.search.status: '' 
            },
            errors: {
                start_year: false,
                end_year: false
            },
        }
    },

    computed: {
        //
    },
    methods: {
        async submit(){
            var form  = $('#claim-form');
            let inputs = form.serialize();
            let valid = true;
            let errorMsg = '';
            this.errors.start_year = false;
            this.errors.end_year = false;
            $(form).find("div[id='el_explode_start_year']").html("");
            $(form).find("div[id='el_explode_end_year']").html("");
            // if (this.searchInput.start_year == '' || this.searchInput.start_year == null){
            //     this.errors.start_year = true;
            //     valid = false;
            //     errorMsg = "กรุณาระบุปีเริ่มต้น";
            //     $(form).find("div[id='el_explode_start_year']").html(errorMsg);
            // }
            // if (this.searchInput.end_year == '' || this.searchInput.end_year == null){
            //     this.errors.end_year = true;
            //     valid = false;
            //     errorMsg = "กรุณาระบุปีสิ้นสุด";
            //     $(form).find("div[id='el_explode_end_year']").html(errorMsg);
            // }
            // if (!valid) {
            //     return;
            // }
            this.loading = true;
            form.submit();
        },
        getDepartmentSt(value) {
            this.searchInput.department_from = value.department_code
            this.searchInput.department_to = this.search? this.search.department_to: this.searchInput.department_from
        },
        getDepartmentEnd(value) {
            this.searchInput.department_to = value.department_code
        },
        getDataDocumentNoSt(value) {
            this.searchInput.document_from = value.document_no
            this.searchInput.document_to = this.search? this.search.document_to: this.searchInput.document_from
        },
        getDataDocumentNoEnd(value) {
            this.searchInput.document_to = value.document_no
        },
        getDataArInvoiceNum (value) {
            this.search.ar_invoice_num = value.invoice_no
        },
        getValuePolicyNumber (value) {
            this.searchInput.policy_number = value.policy_number
        },
        getValueStatus (value) {
            this.searchInput.status = value;
        },
        yearWasSelectedFrom(dateFrom){
            let form = $('#claim-form');
            this.errors.start_year = false;
            $(form).find("div[id='el_explode_start_year']").html("");
            this.searchInput.start_year = dateFrom;
            this.searchInput.end_year = this.searchInput.start_year;
        },
        yearWasSelectedTo(dateTo){
            let form = $('#claim-form');
            this.errors.end_year = false;
            $(form).find("div[id='el_explode_end_year']").html("");
            this.searchInput.end_year = dateTo;
        },
        dateWasSelectedFrom(dateFrom){
             
            this.searchInput.accident_start_date = dateFrom? moment(dateFrom).format('DD/MM/YYYY'): '';
            this.searchInput.accident_end_date = this.searchInput.accident_start_date;
        },
        dateWasSelectedTo(dateTo){
            this.searchInput.accident_end_date = dateTo? moment(dateTo).format('DD/MM/YYYY'): '';
        },
        getPolicyNumber(value) {
            this.searchInput.policy_number = value
        },
    },
}
</script>