<template>
    <div>
        <div class="row">
            <!-- <div class="col-md-4">
                <label> ลำดับที่ <span class="text-danger">*</span></label> -->
                <!-- <el-input-number name="authority_number" v-model="authority_number" size="medium"></el-input-number> -->
                <!-- <el-input name="authority_number" v-model="authority_number"  type="number"></el-input>
            </div> -->
            <div class="col-md-2"></div>
            <div class="col-md-4">
                <label> ผู้มีอำนาจ <span class="text-danger">*</span></label>
                <input type="hidden" name="employee_number"  :value="employee_number" autocomplete="off">
                <el-select  v-model="employee_number"
                                filterable
                                :disabled="defaultValue != undefined"
                                remote
                                reserve-keyword
                                clearable
                                :remote-method="remoteMethod"
                                class="w-100" 
                                @change="getPosition()">              
                    <el-option  v-for="employee in employeesList"
                                :key="employee.pnps_psnl_no"
                                :label="employee.psn_name"
                                :value="employee.pnps_psnl_no">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-4">
                <label> ตำแหน่ง <span class="text-danger">*</span></label>
                <el-input name="position_name" v-model="position_name" ></el-input>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-2"></div>
            <div class="col-md-4">
                <label> วันที่เริ่มต้น </label>
                <datepicker-th
                    style="width: 100%;"
                    class="form-control md:tw-mb-0 tw-mb-2"
                    name="start_date"
                    placeholder="โปรดเลือกวันที่"
                    v-model="start_date"
                    format="DD-MM-YYYY"
                    @dateWasSelected="fromDateWasSelected"
                    >
                </datepicker-th>
                <!-- <el-date-picker 
                    v-model="start_date"
                    style="width: 100%;"
                    type="datetime"
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
                    :disabled-date-to="disabledDateTo"
                    >
                </datepicker-th>
                <!-- <el-date-picker 
                    v-model="end_date"
                    style="width: 100%;"
                    type="datetime"
                    placeholder="วันที่สิ้นสุด"
                    name="end_date"
                    format="dd-MM-yyyy"
                    >
                </el-date-picker>   -->
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment';
export default {
    props:['employees', 'defaultValue', 'old'],
    data() {
        return {
            // employee_number     : '000924',
            employeesList: this.employees,
            authority_number: this.old.authority_number ? this.old.authority_number : this.defaultValue ? this.defaultValue.authority_number : '',
            employee_number : this.old.employee_number  ? this.old.employee_number  : this.defaultValue ? this.defaultValue.employee_number  : '',
            position_name   : this.old.position_name    ? this.old.position_name    : this.defaultValue ? this.defaultValue.position_name    : '',
            start_date      : this.old.start_date       ? this.old.start_date       : this.defaultValue ? this.defaultValue.start_date       : '',
            end_date        : this.old.end_date         ? this.old.end_date         : this.defaultValue ? this.defaultValue.end_date         : '',
            // user_id: this.old.user ? this.old.user : this.defaultValue ? this.defaultValue.user : '',
            // grant_special_flag: this.old.grant_special_flag == 'Y' ? true : this.defaultValue ? this.defaultValue.grant_special_flag == 'Y' ? true : '' : '',
            // second_order_flag: this.old.second_order_flag == 'Y' ? true : this.defaultValue ? this.defaultValue.second_order_flag == 'Y' ? true : '' : '',
            // allowed_order_date: this.old.allowed_order_date ? this.old.allowed_order_date : this.defaultValue ? this.defaultValue.allowed_order_date : '',
            
            // สำหรับ เช็ค วันที่
            disabledDateTo:     this.start_date ? this.start_date : null,
        }
    },
    mounted(){
        if (!this.old.start_date || !this.old.end_date) {
            this.showDate();
        }
    },
    methods: {
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
        },
        
        getPosition() {
            this.position_name = '';

            this.selectedData = this.employeesList.find( i => {
                return i.pnps_psnl_no == this.employee_number;
            });

            if (this.employee_number) {
                this.position_name = this.selectedData.pnpm_pos_name;
            } else {
                this.position_name = '';
            }
        },
        remoteMethod(query) {
              if (query !== "") {
                this.getHr({ name: query});
              } else {
                this.users = [];
              }
            },
        async getHr(params) {
            // this.user = null;
            // this.loading = true;
            this.employeesList = [];
            axios.get('/om/settings/authority-list/create', { params }).then(res => {
                this.employeesList = res.data;
            });

            // this.loading = false;
            // this.users = res.data.data;
            // this.setUser();
        },
    },
}
</script>