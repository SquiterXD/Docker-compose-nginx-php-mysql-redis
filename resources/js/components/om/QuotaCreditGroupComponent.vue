<template>
    <div>
        <div class="row">
            <!-- <div class="col-md-1">
            </div> -->
            <div class="col-md-4">
                <label> รหัสผลิตภัณฑ์ <span class="text-danger">*</span></label>
                <input type="hidden" name="item_id"  :value="item_id" autocomplete="off">
                <el-select  v-model="item_id"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" 
                                @change="getSelectedItem()"
                                :disabled="this.disabledEdit"
                                >              
                    <el-option  v-for="item in items"
                                :key="item.item_id"
                                :label="item.item_code + ' : ' + item.ecom_item_description"
                                :value="item.item_id">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-4">
                <label> ชื่อผลิตภัณฑ์ </label>
                <el-input v-model="item_description" disabled></el-input>
            </div>
            <div class="col-md-4">
                <label> กลุ่มโควต้า</label>
                <input type="hidden" name="quota_group_code"  :value="quota_group_code" autocomplete="off">
                <el-select  v-model="quota_group_code"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" 
                                >              
                    <el-option  v-for="quota in quotaGroups"
                                :key="quota.lookup_code"
                                :label="quota.meaning + ' : ' + quota.description"
                                :value="quota.lookup_code">
                    </el-option>
                </el-select>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-4">
                <label> กลุ่มวงเงินเขื่อ <span class="text-danger">*</span></label>
                <input type="hidden" name="credit_group_code"  :value="credit_group_code" autocomplete="off">
                <el-select  v-model="credit_group_code"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" 
                                >              
                    <el-option  v-for="credit in creditGroups"
                                :key="credit.lookup_code"
                                :label="credit.description"
                                :value="credit.lookup_code">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-4">
                <label> วันที่เริ่มต้น</label>
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
                    type="date"
                    placeholder="วันที่เริ่มต้น"
                    name="start_date"
                    format="dd-MM-yyyy"
                    >
                </el-date-picker>   -->
            </div>
            <div class="col-md-4">
                <label> วันที่สิ้นสุด</label>
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
    props: ['items' ,'quotaGroups', 'creditGroups', 'defaultValue', 'old'],

    data(){
        return {
            item_id:           this.old.item_id           ? this.old.item_id           : this.defaultValue ? this.defaultValue.item_id           : '',
            quota_group_code:  this.old.quota_group_code  ? this.old.quota_group_code  : this.defaultValue ? this.defaultValue.quota_group_code  : '',
            credit_group_code: this.old.credit_group_code ? this.old.credit_group_code : this.defaultValue ? this.defaultValue.credit_group_code : '',
            disabledEdit:      this.defaultValue          ? true : false,
            start_date:        this.old.start_date        ? this.old.start_date        : this.defaultValue ? this.defaultValue.start_date : '',
            end_date:          this.old.end_date          ? this.old.end_date          : this.defaultValue ? this.defaultValue.end_date   : '',
            item_description:  '',

            // สำหรับ เช็ค วันที่
            disabledDateTo:     this.start_date ? this.start_date : null,
        }
    },
    mounted(){
        // console.log('xxx -->' + this.old);
        if (this.item_id) {
            this.getSelectedItem();
        }
        if (!this.old.start_date || !this.old.end_date) {
            this.showDate();
        }
    },
    methods: {
        getSelectedItem() {
            this.selectedItem = this.items.find( i => {
                return i.item_id == this.item_id;
            });
            
            if (this.item_id) {
                this.item_description = this.defaultValue ? this.defaultValue.item_description : this.selectedItem.ecom_item_description;
            } else {
                this.item_description = '';
            }
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
        },
    },
}
</script>