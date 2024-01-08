<template>
    <div>
        <div class="row">
            <div class="col-md-2">
            </div>
             <div class="col-md-4">
                <label> ลำดับที่ <span class="text-danger">*</span></label>
                <el-input name="approver_number" v-model="approver_number"  type="text"></el-input>
            </div>
            <div class="col-md-4">
                <label> ผู้อนุมัติ<span class="text-danger">*</span></label>
                <input type="hidden" name="authority_id"  :value="authority_id" autocomplete="off">
                <el-select  v-model="authority_id"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" 
                                >              
                    <el-option  v-for="authoRityList in authoRityLists"
                                :key="authoRityList.authority_id"
                                :label="authoRityList.employee_name + ' : ' + authoRityList.position_name"
                                :value="authoRityList.authority_id">

                    </el-option>
                </el-select>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-2">
            </div>
            <div class="col-md-4">
                <label> วันที่เริ่มต้น </label>
                <datepicker-th
                    style="width: 100%;"
                    class="form-control md:tw-mb-0 tw-mb-2"
                    name="start_date"
                    placeholder="โปรดเลือกวันที่"
                    v-model="start_date"
                    format="DD-MM-YYYY"
                    @dateWasSelected="fromDateWasSelected">
                </datepicker-th>
                <!-- <el-date-picker 
                    v-model="start_date"
                    style="width: 100%;"
                    type="date"
                    placeholder="วันที่เริ่มต้น"
                    name="start_date"
                    format="dd-MM-yyyy"
                    >
                </el-date-picker>   -->
            </div>
            <div class="col-md-4">
                <label> วันที่สิ้นสุด </label>
                <datepicker-th
                    style="width: 100%;"
                    class="form-control md:tw-mb-0 tw-mb-2"
                    name="end_date"
                    placeholder="โปรดเลือกวันที่"
                    v-model="end_date"
                    format="DD-MM-YYYY"
                    :disabled-date-to="disabledDateTo">
                </datepicker-th>

                <!-- <el-date-picker 
                    v-model="end_date"
                    style="width: 100%;"
                    type="date"
                    placeholder="วันที่สิ้นสุด"
                    name="end_date"
                    format="dd-MM-yyyy"
                    @change="checkDate()">
                </el-date-picker>   -->
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-2">
            </div>
            <div class="col-md-2">
                <label> Default </label>
                <div>
                    <input type="checkbox" name="default_flag" v-model="default_flag">
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import moment from 'moment';
export default {
    props:['authoRityLists', 'defaultValue', 'old'],
    data() {
        return {
            authority_id:       this.old.authority_id    ? this.old.authority_id     : this.defaultValue  ? Number(this.defaultValue.authority_id) : '',
            start_date:         this.old.start_date      ? this.old.start_date       : this.defaultValue  ? this.defaultValue.start_date           : '',
            end_date:           this.old.end_date        ? this.old.end_date         : this.defaultValue  ? this.defaultValue.end_date             : '',
            approver_number:    this.old.approver_number ? this.old.approver_number  : this.defaultValue  ? this.defaultValue.approver_number      : '',
            default_flag:       this.old.default_flag    ? true : this.defaultValue  ? this.defaultValue.default_flag == 'Y' ? true : false : false,

            // สำหรับ เช็ค วันที่
            disabledDateTo:     this.start_date ? this.start_date : null,
            // customer_id: this.old.customer_id                      ? Number(this.old.customer_id) : this.defaultValue ? Number(this.defaultValue.customer_id) : '',
            // grant_special_flag: this.old.grant_special_flag == 'Y' ? true : this.defaultValue     ? this.defaultValue.grant_special_flag == 'Y' ? true : '' : '',
            // second_order_flag: this.old.second_order_flag == 'Y'   ? true : this.defaultValue     ? this.defaultValue.second_order_flag == 'Y' ? true : '' : '',
            // allowed_order_date: this.old.allowed_order_date        ? this.old.allowed_order_date  : this.defaultValue ? this.defaultValue.allowed_order_date : '',
        }
    },
    mounted() {
        console.log(this.start_date);
        if (!this.old.start_date || !this.old.end_date) {
            this.showDate();
        }
        // if (this.start_date) {
        //     this.disabledDateTo = this.start_date;
        //     // console.log('xxxx ---> ' + this.disabledDateTo);
        //     this.fromDateWasSelected();
        // }
    },
    methods: {
        onlyNumeric() {
            this.approver_number = this.approver_number.replace(/[^0-9 .]/g, '');
        },
        checkDate() {
            if (this.start_date) {
                if (moment(String(this.end_date)).format('yyyy-MM-DD') < moment(String(this.start_date)).format('yyyy-MM-DD')) {
                    this.$notify.error({
                        title: 'มีข้อผิดพลาด',
                        message: 'วันที่สิ้นสุดต้องไม่น้อยกว่าวันที่เริ่มต้น',
                    });
                    this.end_date = '';
                }
            } 
        },
        async showDate() {
            if (this.start_date) {
                // console.log('start_date -->' + this.start_date);
                // console.log(moment(String(this.start_date)).format('yyyy-MM-DD'));
                var date1 = await helperDate.parseToDateTh(this.start_date, 'yyyy-MM-DD');
                this.start_date = date1;
            }
            if (this.end_date) {
                // console.log('end_date -->' + this.end_date);
                var date2 = await helperDate.parseToDateTh(this.end_date, 'yyyy-MM-DD');
                this.end_date = date2;
            }
        },
        fromDateWasSelected(date) {
            // change disabled_date_to of to_date = from_date
            this.disabledDateTo = moment(date).format("DD/MM/YYYY");
            console.log('bbb ---> ' + this.disabledDateTo);
        },

    }
}
</script>