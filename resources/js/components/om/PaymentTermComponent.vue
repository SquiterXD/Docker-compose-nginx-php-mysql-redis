<template>
    <div>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <label> รหัสการชำระเงิน <span class="text-danger">*</span></label>
                <div>
                    <input type="text" class="form-control col-12" name="name" v-model="name" :disabled="this.disableEdit">
                </div>
            </div>
            <div class="col-md-5">
                <label> เงื่อนไขการชำระเงิน <span class="text-danger">*</span></label>
                <div>
                    <input type="text" class="form-control col-12" name="description" v-model="description">
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <label> วันที่เริ่มใช้งาน <span class="text-danger">*</span></label>
                <!-- <el-date-picker 
                    v-model="start_date_active"
                    style="width: 100%;"
                    type="date"
                    placeholder="วันที่เริ่มใช้งาน"
                    name="start_date_active"
                    format="dd-MM-yyyy"
                    >
                </el-date-picker>   -->
                <datepicker-th
                    style="width: 100%;"
                    class="form-control md:tw-mb-0 tw-mb-2"
                    name="start_date_active"
                    placeholder="โปรดเลือกวันที่"
                    v-model="start_date_active"
                    format="DD-MM-YYYY"
                    @dateWasSelected="fromDateWasSelected"
                    >
                </datepicker-th>

            </div>
            <div class="col-md-5">
                <label> วันที่สิ้นสุดการใช้งาน </label>
                <!-- <input type="hidden" name="end_date_active" :value="end_date_active"> -->
                <!-- <el-date-picker 
                    v-model="end_date_active"
                    style="width: 100%;"
                    type="date"
                    placeholder="วันที่สิ้นสุดการใช้งาน"
                    name="end_date_active"
                    format="dd-MM-yyyy"
                    @change="checkDate()">
                </el-date-picker>  -->
                <datepicker-th
                    style="width: 100%;"
                    class="form-control md:tw-mb-0 tw-mb-2"
                    name="end_date_active"
                    placeholder="โปรดเลือกวันที่"
                    v-model="end_date_active"
                    format="DD-MM-YYYY"
                    :disabled-date-to="disabledDateTo"
                    >
                </datepicker-th>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <label> จำนวนวันปลอดดอก </label>
                <input type="text" class="form-control col-12" name="due_days" v-model="dueDays">
            </div>
        </div>
    </div>
</template>

<script>
import { helpers } from 'chart.js';
import moment from "moment";
    export default {
        props: ['old', 'defaultValue'],
        data(){
            // console.log(this.defaultValue);
            return {
                // start_date_active:  this.defaultValue ? moment(String(this.defaultValue.start_date_active)).format('DD/MM/YYYY')  : '',
                // end_date_active:    this.defaultValue ? moment(String(this.defaultValue.end_date_active)).format('DD/MM/YYYY')  : '',
                // start_date_active:  this.defaultValue ? helperDate.convertDate(moment(String(this.defaultValue.start_date_active)).format('DD/MM/YYYY'), 'DD/MM/YYYY')  : '',
                start_date_active:  this.defaultValue ? this.defaultValue.start_date_active  : '',
                end_date_active:    this.defaultValue ? this.defaultValue.end_date_active    : '',
                name:               this.defaultValue ? this.defaultValue.term_name          : '',
                description:        this.defaultValue ? this.defaultValue.description        : '',
                dueDays:            this.defaultValue ? this.defaultValue.due_days           : '',
                disableEdit:        this.defaultValue ? this.defaultValue.term_name          ? true : false : false,
               
               // สำหรับ เช็ค วันที่
               disabledDateTo:     this.start_date_active ? this.start_date_active : null
            }
        },
        mounted(){
            this.showDate();
        },
        methods: {
            checkDate() {
                if (this.start_date_active) {
                    if (moment(String(this.end_date_active)).format('yyyy-MM-DD') < moment(String(this.start_date_active)).format('yyyy-MM-DD')) {
                        this.$notify.error({
                            title: 'มีข้อผิดพลาด',
                            message: 'วันที่สิ้นสุดต้องไม่น้อยกว่าวันที่เริ่มต้น',
                        });
                        this.end_date_active = '';
                    }
                } 
            },

            async showDate() {
                if (this.start_date_active) {
                    var date1 = await helperDate.parseToDateTh(this.start_date_active, 'yyyy-MM-DD');
                    this.start_date_active = date1;
                }
                if (this.end_date_active) {
                    var date2 = await helperDate.parseToDateTh(this.end_date_active, 'yyyy-MM-DD');
                    this.end_date_active = date2;
                }
            },
            fromDateWasSelected(date) {
                // change disabled_date_to of to_date = from_date
                this.disabledDateTo = moment(date).format("DD/MM/YYYY");
            },
        }
    }
</script>
