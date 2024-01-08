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
                <el-date-picker 
                    v-model="start_date"
                    style="width: 100%;"
                    type="date"
                    placeholder="วันที่เริ่มต้น"
                    name="start_date"
                    format="dd-MM-yyyy"
                    >
                </el-date-picker>  
            </div>
            <div class="col-md-4">
                <label> วันที่สิ้นสุด </label>
                <el-date-picker 
                    v-model="end_date"
                    style="width: 100%;"
                    type="date"
                    placeholder="วันที่สิ้นสุด"
                    name="end_date"
                    format="dd-MM-yyyy"
                    >
                </el-date-picker>  
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
        }
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
    }
}
</script>