<template>
    <div>
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-4">
                <label> ช่วงหีบ <span class="text-danger">*</span></label>
                <el-input name="cbb_range_from" v-model="cbb_range_from"></el-input>
            </div>
            <div class="col-md-4">
                <label> ถึง <span class="text-danger">*</span></label>
                <el-input name="cbb_range_to" v-model="cbb_range_to"></el-input>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-2">
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
                    @dateWasSelected="fromDateWasSelected">
                </datepicker-th>
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
                    :disabled-date-to="disabledDateTo">
                </datepicker-th>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-2">
            </div>
            <div class="col-md-4">
                <label> กองบริหารขาย <span class="text-danger">*</span></label>
                <input type="hidden" name="sales_division_id"  :value="sales_division_id" autocomplete="off">
                <el-select  v-model="sales_division_id"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100"
                                placeholder="โปรดเลือก" 
                                @change="getDivisionAdditional()">              
                    <el-option  v-for="authoRityList in authoRityLists"
                                :key="authoRityList.authority_id"
                                :label="authoRityList.employee_name + ' : ' + authoRityList.position_name"
                                :value="authoRityList.authority_id">

                    </el-option>
                </el-select>
            </div>
            <div class="col-md-4">
                <label> ตำแหน่งที่แสดงในรายงาน <span class="text-danger">*</span></label>
                <input type="hidden" name="sales_division_additional"  :value="sales_division_additional" autocomplete="off">
                <el-input v-model="sales_division_additional" clearable />
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-2">
            </div>
            <div class="col-md-4">
                <label> ผู้เรียนพิจารณา 1 </label>
                <input type="hidden" name="authority_id1"  :value="authority_id1" autocomplete="off">
                <el-select  v-model="authority_id1"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" 
                                placeholder="โปรดเลือก"
                                @change="getId1Additional()">              
                    <el-option  v-for="authoRityList in authoRityLists"
                                :key="authoRityList.authority_id"
                                :label="authoRityList.employee_name + ' : ' + authoRityList.position_name"
                                :value="authoRityList.authority_id">

                    </el-option>
                </el-select>
            </div>
            <div class="col-md-4">
                <label> ตำแหน่งที่แสดงในรายงาน  </label>
                <input type="hidden" name="authority_id1_additional"  :value="authority_id1_additional" autocomplete="off">
                <el-input v-model="authority_id1_additional" clearable />
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-2">
            </div>
            <div class="col-md-4">
                <label> ผู้เรียนพิจารณา 2 </label>
                <input type="hidden" name="authority_id2"  :value="authority_id2" autocomplete="off">
                <el-select  v-model="authority_id2"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" 
                                placeholder="โปรดเลือก"
                                @change="getId2Additional()">              
                    <el-option  v-for="authoRityList in authoRityLists"
                                :key="authoRityList.authority_id"
                                :label="authoRityList.employee_name + ' : ' + authoRityList.position_name"
                                :value="authoRityList.authority_id">

                    </el-option>
                </el-select>
            </div>
            <div class="col-md-4">
                <label> ตำแหน่งที่แสดงในรายงาน </label>
                <input type="hidden" name="authority_id2_additional"  :value="authority_id2_additional" autocomplete="off">
                <el-input v-model="authority_id2_additional" clearable />
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-2">
            </div>
            <div class="col-md-4">
                <label> ผู้มีอำนาจอนุมัติ <span class="text-danger">*</span></label>
                <input type="hidden" name="authority_id3"  :value="authority_id3" autocomplete="off">
                <el-select  v-model="authority_id3"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100"
                                placeholder="โปรดเลือก" 
                                @change="getId3Additional()">              
                    <el-option  v-for="authoRityList in authoRityLists"
                                :key="authoRityList.authority_id"
                                :label="authoRityList.employee_name + ' : ' + authoRityList.position_name"
                                :value="authoRityList.authority_id">

                    </el-option>
                </el-select>
            </div>
            <div class="col-md-4">
                <label> ตำแหน่งที่แสดงในรายงาน  <span class="text-danger">*</span></label>
                <input type="hidden" name="authority_id3_additional"  :value="authority_id3_additional" autocomplete="off">
                <el-input v-model="authority_id3_additional" clearable />
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
            cbb_range_from    : this.old.cbb_range_from    ? this.old.cbb_range_from            : this.defaultValue ? this.defaultValue.cbb_range_from            : '',
            cbb_range_to      : this.old.cbb_range_to      ? this.old.cbb_range_to              : this.defaultValue ? this.defaultValue.cbb_range_to              : '',
            authority_id1     : this.old.authority_id1     ? Number(this.old.authority_id1)     : this.defaultValue ? this.defaultValue.authority_id1     ? Number(this.defaultValue.authority_id1)     : ''  : '',
            authority_id2     : this.old.authority_id2     ? Number(this.old.authority_id2)     : this.defaultValue ? this.defaultValue.authority_id2     ? Number(this.defaultValue.authority_id2)     : ''  : '',
            authority_id3     : this.old.authority_id3     ? Number(this.old.authority_id3)     : this.defaultValue ? this.defaultValue.authority_id3     ? Number(this.defaultValue.authority_id3)     : ''  : '',
            sales_division_id : this.old.sales_division_id ? Number(this.old.sales_division_id) : this.defaultValue ? this.defaultValue.sales_division_id ? Number(this.defaultValue.sales_division_id) : ''  : '',
            start_date        : this.old.start_date        ? this.old.start_date                : this.defaultValue ? this.defaultValue.start_date                : '',
            end_date          : this.old.end_date          ? this.old.end_date                  : this.defaultValue ? this.defaultValue.end_date                  : '',
            authority_id1_additional    : this.old.authority_id1_additional     ?   this.old.authority_id1_additional   : this.defaultValue ? this.defaultValue.authority_id1_additional    : '',
            authority_id2_additional    : this.old.authority_id2_additional     ?   this.old.authority_id2_additional   : this.defaultValue ? this.defaultValue.authority_id2_additional    : '',
            authority_id3_additional    : this.old.authority_id3_additional     ?   this.old.authority_id3_additional   : this.defaultValue ? this.defaultValue.authority_id3_additional    : '',
            sales_division_additional   : this.old.sales_division_additional    ?   this.old.sales_division_additional  : this.defaultValue ? this.defaultValue.sales_division_additional   : '',

            // สำหรับ เช็ค วันที่
            disabledDateTo:     this.start_date ? this.start_date : null,
        }
    },
    mounted() {
        console.log('xxxxxxxxxxxxxxxxxx', this.start_date);
        if (!this.old.start_date || !this.old.end_date) {
            this.showDate();
        }
    },
    methods: {
        checkDate() {
            console.log('1111 --->' + this.start_date);
            if (this.start_date) {
                console.log('start -----> ' + moment(String(this.end_date)).format('yyyy-MM-DD'));
                console.log('end -----> ' + moment(String(this.start_date)).format('yyyy-MM-DD'));
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
        getDivisionAdditional(){
            // sales_division_id
            // authority_id1_additional
            this.sales_division_additional = '';

            this.selectedData = this.authoRityLists.find( i => {
                return i.authority_id == this.sales_division_id;
            });

            if (this.sales_division_id) {
                this.sales_division_additional = this.selectedData.position_name;
            } else {
                this.sales_division_additional = '';
            }
        },
        getId1Additional(){
            // authority_id1
            // authority_id1_additional
            this.authority_id1_additional = '';

            this.selectedData = this.authoRityLists.find( i => {
                return i.authority_id == this.authority_id1;
            });
            
            if (this.authority_id1) {
                this.authority_id1_additional = this.selectedData.position_name;
            } else {
                this.authority_id1_additional = '';
            }
        },
        getId2Additional(){
            // authority_id2
            // authority_id2_additional

            this.authority_id2_additional = '';

            this.selectedData = this.authoRityLists.find( i => {
                return i.authority_id == this.authority_id2;
            });
            
            if (this.authority_id2) {
                this.authority_id2_additional = this.selectedData.position_name;
            } else {
                this.authority_id2_additional = '';
            }
        },
        getId3Additional(){
            // authority_id3
            // authority_id3_additional

            this.authority_id3_additional = '';

            this.selectedData = this.authoRityLists.find( i => {
                return i.authority_id == this.authority_id3;
            });
            
            if (this.authority_id3) {
                this.authority_id3_additional = this.selectedData.position_name;
            } else {
                this.authority_id3_additional = '';
            }
        }
    }
}
</script>