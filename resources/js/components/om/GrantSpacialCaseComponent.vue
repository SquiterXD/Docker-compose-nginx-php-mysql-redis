<template>
    <div>
        <div class="row">
            <div class="col-md-1">
            </div>
            <div class="col-md-5">
                <label> รหัส - ชื่อลูกค้า <span class="text-danger">*</span></label>
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
                                :label="customer.customer_number ? customer.customer_number + ' : ' + customer.customer_name : customer.customer_name"
                                :value="customer.customer_id">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-5">
                <label> วันที่อนุญาติให้สั่งซื้อได้ <span class="text-danger">*</span></label>
                <datepicker-th
                    style="width: 100%;"
                    class="form-control md:tw-mb-0 tw-mb-2"
                    name="allowed_order_date"
                    placeholder="โปรดเลือกวันที่อนุญาติให้สั่งซื้อได้"
                    v-model="allowed_order_date"
                    format="DD-MM-YYYY"
                    >
                </datepicker-th>
                <!-- <el-date-picker 
                    v-model="allowed_order_date"
                    style="width: 100%;"
                    type="date"
                    placeholder="วันที่อนุญาติให้สั่งซื้อได้"
                    name="allowed_order_date"
                    format="dd-MM-yyyy"
                    >
                </el-date-picker>   -->
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-1">
            </div>
            <div class="col-md-5">
                <label> สั่งซื้อกรณีพิเศษ <span class="text-danger">*</span></label><br>
                <input type="checkbox" name="grant_special_flag" v-model="grant_special_flag">
            </div>
            <div class="col-md-5">
                <label> สั่งซื้อครั้งที่ 2 ในวัน <span class="text-danger">*</span></label><br>
                <input type="checkbox" name="second_order_flag" v-model="second_order_flag">
            </div>
        </div>
        <!-- <div class="row mt-2">
            <div class="col-md-1">
            </div>
            <div class="col-md-5">
                <label> วันที่เริ่มต้น</label>
                <el-date-picker 
                    v-model="start_date"
                    style="width: 100%;"
                    type="datetime"
                    placeholder="วันที่เริ่มต้น"
                    name="start_date"
                    format="dd-MM-yyyy"
                    >
                </el-date-picker>  
            </div>
            <div class="col-md-5">
                <label> วันที่สิ้นสุด</label>
                <el-date-picker 
                    v-model="end_date"
                    style="width: 100%;"
                    type="datetime"
                    placeholder="วันที่สิ้นสุด"
                    name="end_date"
                    format="dd-MM-yyyy"
                    >
                </el-date-picker>  
            </div>
        </div> -->
    </div>
</template>
<script>
export default {
    props:['customers', 'defaultValue', 'old'],
    data() {
        return {
            customer_id:        this.old.customer_id               ? Number(this.old.customer_id) : this.defaultValue ? Number(this.defaultValue.customer_id) : '',
            grant_special_flag: this.old.grant_special_flag == 'Y' ? true : this.defaultValue     ? this.defaultValue.grant_special_flag == 'Y' ? true : '' : '',
            second_order_flag:  this.old.second_order_flag == 'Y'  ? true : this.defaultValue     ? this.defaultValue.second_order_flag == 'Y' ? true : '' : '',
            allowed_order_date: this.old.allowed_order_date        ? this.old.allowed_order_date  : this.defaultValue ? this.defaultValue.allowed_order_date : '',
            // start_date:         this.old.start_date                ? this.old.start_date          : this.defaultValue ? this.defaultValue.start_date : '',
            // end_date:           this.old.end_date                  ? this.old.end_date            : this.defaultValue ? this.defaultValue.end_date   : '',
        }
    },
    mounted(){
        // console.log('old ----> ' + this.old);
        if (!this.old.allowed_order_date) {
            this.showDate();
        }
    },
    methods: {
        async showDate() {
            console.log('date ----> ' + this.allowed_order_date);
            if (this.allowed_order_date) {
                // console.log('start_date -->' + this.start_date);
                // console.log(moment(String(this.start_date)).format('yyyy-MM-DD'));
                var date1 = await helperDate.parseToDateTh(this.allowed_order_date, 'yyyy-MM-DD');
                this.allowed_order_date = date1;
            }
        },
    },
}
</script>