<template>
    <div>
        <div class="row">
            <div class="col-md-4">
                <label> รหัส - ชื่อร้านค้า <span class="text-danger">*</span></label>
                <input type="hidden" name="customer_id"  :value="customer_id" autocomplete="off">
                <el-select  v-model="customer_id"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" 
                                >     
                    <el-option  v-for="customer in customers"
                                :key="customer.customer_id"
                                :label="customer.customer_number + ' : ' + customer.customer_name "
                                :value="customer.customer_id">
                    </el-option>
                </el-select>
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
    </div>
</template>
<script>
import moment from 'moment';
export default {
    props:['customers', 'defaultValue', 'old'],
    data() {
        return {
            customer_id: this.old.customer_id ? Number(this.old.customer_id) : this.defaultValue  ? Number(this.defaultValue.customer_id) : '',
            start_date:  this.old.start_date  ? this.old.start_date          : this.defaultValue  ? this.defaultValue.start_date          : '',
            end_date:    this.old.end_date    ? this.old.end_date            : this.defaultValue  ? this.defaultValue.end_date            : '',

            // สำหรับ เช็ค วันที่
            disabledDateTo:     this.start_date ? this.start_date : null,
        }
    },
    mounted() {
        if (!this.old.start_date || !this.old.end_date) {
            this.showDate();
        }
    },
    methods: {
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
                var date1 = await helperDate.parseToDateTh(this.start_date, 'yyyy-MM-DD');
                this.start_date = date1;
            }
            if (this.end_date) {
                var date2 = await helperDate.parseToDateTh(this.end_date, 'yyyy-MM-DD');
                this.end_date = date2;
            }
        },
        fromDateWasSelected(date) {
            // change disabled_date_to of to_date = from_date
            this.disabledDateTo = moment(date).format("DD/MM/YYYY");
        },
    }
}
</script>