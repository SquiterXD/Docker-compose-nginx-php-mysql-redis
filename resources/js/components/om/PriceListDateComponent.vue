<template>
    <div>
<!-- --------------------------------------------------------------------Header------------------------------------------------------------------ -->
        <div class="row">
            <div class="col-md-4">
                <dl class="dl-horizontal form-inline">
                <dt>
                    ชื่อรายการราคาสินค้า
                </dt>
                <el-input name="nameHeader" v-model="nameHeader"> </el-input>
                </dl>
            </div>
            <div class="col-md-4">
                <dl class="dl-horizontal form-inline">
                <dt>
                    รายละเอียด
                </dt>
                <el-input name="description" v-model="description"> </el-input>
                </dl>
            </div>
            <div class="col-md-4">
                <dl class="dl-horizontal form-inline">
                <dt>
                    สกุลเงิน 
                </dt>
                <input type="hidden" name="currency_code"  :value="currency_code" autocomplete="off">
                <el-select  v-model="currency_code"
                                filterable
                                remote
                                reserve-keyword class="w-100">              
                    <el-option  v-for="currency in currencies"
                                :key="currency.currency_code"
                                :label="currency.currency_code + ' : ' + currency.name"
                                :value="currency.currency_code">
                    </el-option>
                </el-select>
                </dl>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <dl class="dl-horizontal form-inline">
                <dt>
                    วันที่ใช้งาน
                </dt>
                <date-picker
                    :default-value="defaultDate"
                    style="width: 100%;"
                    class="form-control md:tw-mb-0 tw-mb-2"
                    v-model="effective_dates_from"
                    name="effective_dates_from"
                    placeholder="วันที่ใช้งาน"
                    :lang="lang" 
                    format="DD/MM/YYYY"
                    @change="checkDate();"
                ></date-picker>
                <!-- <el-date-picker 
                    v-model="effective_dates_from"
                    style="width: 100%;"
                    type="date"
                    placeholder="วันที่เริ่มต้น"
                    name="effective_dates_from"
                    format="dd-MM-yyyy"
                    @change="validateHeaderDate(); checkDate();"
                    >
                </el-date-picker>   -->
                </dl>
            </div>
            <div class="col-md-4">
                <dl class="dl-horizontal form-inline">
                    <dt>
                    วันที่สิ้นสุด
                    </dt>
                    <date-picker
                        :default-value="defaultDate"
                        style="width: 100%;"
                        class="form-control md:tw-mb-0 tw-mb-2"
                        v-model="effective_dates_to"
                        name="effective_dates_to"
                        placeholder="วันที่ใช้งาน"
                        :lang="lang" 
                        format="DD/MM/YYYY"
                        @change="checkDate();"
                    ></date-picker>
                    <!-- <el-date-picker 
                        v-model="effective_dates_to"
                        style="width: 100%;"
                        type="date"
                        placeholder="วันที่เริ่มต้น"
                        name="effective_dates_to"
                        format="dd-MM-yyyy"
                        @change="validateHeaderDate(); checkDate();"
                    >
                    </el-date-picker>  -->
                </dl>
            </div>
            <div class="col-md-4">
                <dl class="dl-horizontal form-inline">
                    <dt>
                        หมายเหตุรายการ
                    </dt>
                    <el-input name="comments" v-model="comments"> </el-input>
                </dl>
            </div>
        </div>
        <div class="row"> 
            <div class="col-md-4">
                <dl class="dl-horizontal">
                    <dt>
                        Active
                    </dt>
                    <input type="checkbox" name="active_flag" v-model="active_flag" >
                </dl>
            </div>
        </div>
        <!-- <date-picker
            :default-value="defaultDate"
            style="width: 100%;"
            class="form-control md:tw-mb-0 tw-mb-2"
            v-model="start_date"
            name="start_date"
            placeholder="วันที่"
            :lang="lang" 
            format="DD/MM/YYYY"
        ></date-picker> -->
    </div>
</template>

<script>

import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
import moment from "moment";

export default {
    props: ["value", "name", "id", "inputClass", "placeholder", "disabledDateTo", 'currencies', 'items', 'uoms', 'defaultValue', 'old'],

    watch: {
        disabledDateTo : function (value) {
            if(moment(value, "DD/MM/YYYY").toDate() > this.date) {
                this.date = null;
            }
        }
    },

    components: {
        DatePicker
    },

    data() {
        return {
            date: this.value ? moment(this.value, "DD/MM/YYYY").toDate() : null,
            defaultDate: this.value ? moment(this.value, "DD/MM/YYYY").toDate() : moment().add(543, 'years').toDate(),
            lang: {
                formatLocale: {
                    months: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
                    monthsShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
                    weekdays: ['พฤหัสบดี', 'ศุกร์', 'เสาร์', 'อาทิตย์', 'จันทร์', 'อังคาร', 'อังคาร'],
                    weekdaysShort: ['พฤหัสบดี', 'ศุกร์', 'เสาร์', 'อาทิตย์', 'จันทร์', 'อังคาร', 'อังคาร'],
                    weekdaysMin: ['พฤ.', 'ศ.', 'ส.', 'อา.', 'จ.', 'อ.', 'พ.'],
                    firstDayOfWeek: 3,
                },
                yearFormat: 'YYYY',
                monthFormat: 'MMM',
                monthBeforeYear: true
            },
            disabledDate: (date) => {
                if(!this.disabledDateTo){ return }
                return date < moment(this.disabledDateTo, "DD/MM/YYYY").toDate();
            },
            //Header
            nameHeader             : this.old.name                 ? this.old.name                 : this.defaultValue ? this.defaultValue.name                 : '',
            description            : this.old.description          ? this.old.description          : this.defaultValue ? this.defaultValue.description          : '',
            currency_code          : this.old.currency             ? this.old.currency             : this.defaultValue ? this.defaultValue.currency             : '',
            effective_dates_from   : this.old.effective_dates_from ? this.old.effective_dates_from : this.defaultValue ? this.defaultValue.effective_dates_from : '',
            effective_dates_to     : this.old.effective_dates_to   ? this.old.effective_dates_to   : this.defaultValue ? this.defaultValue.effective_dates_to   : '',
            comments               : this.old.comments             ? this.old.comments             : this.defaultValue ? this.defaultValue.comments             : '',
            active_flag            : true,
            disabledData           : this.defaultValue ?  this.defaultValue.name ? true : false : false,

            //Line
            lines                  : [],
        };
    },

    methods: {
        dateWasSelected(date) {
            this.date = date;
            this.$emit("dateWasSelected", date);
        },
        checkDate(){
            if (this.effective_dates_from) {
                if (moment(String(this.effective_dates_from)).format('yyyy-MM-DD') > moment(String(this.effective_dates_to)).format('yyyy-MM-DD')) {
                this.$notify.error({
                    title: 'มีข้อผิดพลาด',
                    message: 'วันที่เริ่มต้นใช้งานและวันที่สิ้นสุดไม่ถูกต้อง',
                });
                this.effective_dates_to = '';
                } 
            }
            if (this.effective_dates_to) {
                if (moment(String(this.effective_dates_from)).format('yyyy-MM-DD') > moment(String(this.effective_dates_to)).format('yyyy-MM-DD')) {
                this.$notify.error({
                    title: 'มีข้อผิดพลาด',
                    message: 'วันที่เริ่มต้นใช้งานและวันที่สิ้นสุดไม่ถูกต้อง',
                });
                this.effective_dates_from = '';
                }
            }
        },
    }
};
</script>
