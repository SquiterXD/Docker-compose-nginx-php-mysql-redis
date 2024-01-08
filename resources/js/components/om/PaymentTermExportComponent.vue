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
                <label> เงื่อนไขการขนส่ง </label>
                <input type="text" class="form-control col-12" name="shipment_condition" v-model="shipment_condition">
            </div>
            <div class="col-md-5">
                <label> จำนวนวันปลอดดอก </label>
                <input type="text" class="form-control col-12" name="due_days" v-model="dueDays">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <label> วันที่เริ่มใช้งาน <span class="text-danger">*</span></label>
                <el-date-picker 
                    v-model="start_date_active"
                    style="width: 100%;"
                    type="date"
                    placeholder="วันที่เริ่มใช้งาน"
                    name="start_date_active"
                    format="dd-MM-yyyy"
                    >
                </el-date-picker>  
                <!-- <datepicker-th
                    v-model="start_date_active"
                    class="form-control md:tw-mb-0 tw-mb-2"
                    style="width: 100%;"
                    type="datetime"
                    placeholder="วันที่เริ่มต้น"
                    name="start_date_active"
                    format="DD/MM/YYYY"
                    >
                </datepicker-th>  -->
            </div>
            <div class="col-md-5">
                <label> วันที่สิ้นสุดการใช้งาน </label>
                <!-- <input type="hidden" name="end_date_active" :value="end_date_active"> -->
                <el-date-picker 
                    v-model="end_date_active"
                    style="width: 100%;"
                    type="date"
                    placeholder="วันที่สิ้นสุดการใช้งาน"
                    name="end_date_active"
                    format="dd-MM-yyyy"
                    @change="checkDate()">
                </el-date-picker> 
                <!-- <datepicker-th
                                style="width: 100%"
                                class="form-control md:tw-mb-0 tw-mb-2"
                                placeholder="โปรดเลือกวันที่"
                                v-model="end_date_active"
                                name="end_date_active"
                                format="DD/MM/YYYY">
                </datepicker-th> -->
                <!-- <datepicker-th
                    v-model="end_date_active"
                    class="form-control md:tw-mb-0 tw-mb-2"
                    style="width: 100%;"
                    type="datetime"
                    placeholder="วันที่สิ้นสุด"
                    name="end_date_active"
                    format="DD/MM/YYYY"
                    >
                </datepicker-th>  -->
                
                 


                <!-- <datepicker-th
                                style="width: 100%"
                                class="form-control md:tw-mb-0 tw-mb-2"
                                name="end_date_active"
                                placeholder="โปรดเลือกวันที่"
                                v-model="end_date_active"
                                format="DD/MM/YYYY">
                </datepicker-th> -->
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
                disabledDateTo: '',
                shipment_condition: this.defaultValue ? this.defaultValue.shipment_condition : '',
            }
        },
        mounted(){
            // this.showDate();
            // if (this.start_date_active) {
            //     this.start_date_active = await helperDate.parseToDateTh(this.start_date_active, 'DD/MM/YYYY');

            //     console.log(this.start_date_active);
            // }
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
                // console.log('start date ',this.start_date_active);
                // console.log('end date ',this.end_date_active);
                // var date1 = await helperDate.convertDate(this.start_date_active, 'DD/MM/YYYY');
                var date1 = await helperDate.parseToDateTh(this.start_date_active, 'DD/MM/YYYY');
                var date2 = await helperDate.parseToDateTh(this.end_date_active, 'DD/MM/YYYY');

                this.start_date_active = date1;
                this.end_date_active  =  date2;

                // console.log(this.end_date_active);
                // this.end_date_active  = moment(String(this.end_date)).format('YYYY/DD/MM/');

                console.log('start_date ', this.start_date_active);
                console.log('end_date ', this.end_date_active);
            }
            // async showDate() {
                // var start_date = moment(String(this.start_date_active)).format('DD/MM/YYYY');
                // var test_date = moment(start_date, "DD/MM/YYYY").add(543, 'years').toDate();

                // var test_date = moment(String(this.start_date_active), "DD/MM/YYYY").add(543, 'years').toDate();

                // console.log('test ns ' + this.start_date_active);

                // var dateTest = await helperDate.convertDate(this.start_date_active, 'DD/MM/YYYY');

                // console.log('test agin ' + dateTest);

                // var dateTestA = await helperDate.parseToDateTh(moment(String(this.defaultValue.start_date_active)).format('DD/MM/YYYY'), 'DD/MM/YYYY');
                // console.log('test agin ' + dateTestA);
                // this.start_date_active = test_date;

                // console.log('test ns ' + this.start_date_active);
                // console.log(moment(start_date, "DD/MM/YYYY").add(543, 'years').toDate());
                // console.log(moment().add(543, 'years').toDate());
                // console.log('พศ.' + add_years(this.start_date_active, 543).toString());
                // console.log('คศ.' + this.start_date_active);
                // var start_date = moment(String(this.start_date_active)).format('DD/MM/YYYY');

                // this.start_date_active = start_date;
                // console.log('YYYYY');
                // console.log(start_date);
                // console.log(this.start_date_active.format('dd-MM-yyyy'));
                // console.log(this.start_date_active);
                // console.log('5555');
                // var date1 = await helperDate.convertDate(start_date, 'DD/MM/YYYY');
                // this.start_date_active = await helperDate.parseToDateTh(start_date, 'DD/MM/YYYY');
                // console.log(start_date);
                // console.log('testttttt');
                // console.log(start_date);
                
                // if (this.start_date_active) {
                //     var dateTest = await helperDate.convertDate(this.start_date_active, 'DD/MM/YYYY');
                // }

                // console.log(dateTest);
                
            // }
            
        }
    }
</script>
