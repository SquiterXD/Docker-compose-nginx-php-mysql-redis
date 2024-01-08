<template>
    <div>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <label> รหัสร้านค้า <span class="text-danger">*</span></label>
                <input type="hidden" name="customer_id"  :value="customer_id" autocomplete="off">
                <el-select  v-model="customer_id"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" 
                                @change="checkCustomer()"
                                :disabled="this.disableData">              
                    <el-option  v-for="customer in customers"
                                :key="customer.customer_id"
                                :label="customer.customer_number ? customer.customer_number + ' : ' + customer.customer_name : customer.customer_name"
                                :value="customer.customer_id">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-5">
                <label> ชื่อร้านค้า </label>
                <el-input v-model="customer_name" disabled></el-input>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <label> อำเภอ/เขต </label>
                <el-input v-model="city" disabled></el-input>
            </div>
            <div class="col-md-5">
                <label> จังหวัด </label>
                <el-input v-model="province_name" disabled></el-input>
            </div>
            
        </div>
        <div class="row mt-2">
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <label> วันที่ขนส่ง </label>
                <el-input v-model="transport_day" disabled></el-input>
            </div>
            <div class="col-md-5">
                <label> ช่วงเวลามาตราฐานการส่งมอบ <span class="text-danger">*</span></label>
                <input type="hidden" name="time_of_day"  :value="time_of_day" autocomplete="off">
                <el-select  v-model="time_of_day"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" 
                                >              
                    <el-option  v-for="time in times"
                                :key="time.value"
                                :label="time.label"
                                :value="time.value">
                    </el-option>
                </el-select>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <label> วันมาตราฐานการส่งมอบ </label>
                <input type="hidden" name="standard_transport_day"  :value="standard_transport_day" autocomplete="off">
                <el-select  v-model="standard_transport_day"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" 
                                >              
                    <el-option  v-for="day in days"
                                :key="day.meaning"
                                :label="day.meaning"
                                :value="day.meaning">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-5">
                <label> เวลามาตราฐานการส่งมอบ </label>
                <el-time-picker 
                    v-model="standard_transport_time"
                    style="width: 100%;"
                    placeholder="เวลามาตราฐานการส่งมอบ"
                    name="standard_transport_time"
                    format="H:mm" 
                    >
                </el-time-picker>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-1"></div>
            <div class="col-md-5">
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
                    type="date"
                    placeholder="วันที่เริ่มต้น"
                    name="start_date"
                    format="dd-MM-yyyy"
                    >
                </el-date-picker> -->
            </div>
            <div class="col-md-5">
                <label> วันที่สิ้นสุด  </label>
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
                </el-date-picker> -->
            </div>
        </div>

        <!-- <div class="col-12 mt-3">
            <hr>
            <div class="row clearfix m-t-lg text-right">
                <div class="col-sm-12">
                    <button v-if="defaultValue" class="btn btn-sm btn-primary" @click=update()>
                        <i class="fa fa-save"></i> บันทึก
                    </button>
                    <button v-if="!defaultValue" class="btn btn-sm btn-primary" @click=save()>
                        <i class="fa fa-save"></i> บันทึก
                    </button>
                    <a type="button" class="btn btn-sm btn-warning"> <i class="fa fa-times"></i> ยกเลิก </a>
                </div>
            </div>
        </div> -->
    </div>
</template>

<script>
    import moment from 'moment';
    export default {
        props:["days", "customers", "url", "url-return",
            "url-update",
            "defaultValue",
            // "vendor-selected"
        ],
        data(){
            return {
                transport_number:        this.defaultValue ? this.defaultValue.transport_number        : "",
                customer_id:             this.defaultValue ? Number(this.defaultValue.customer_id)     : "",
                transport_day:           this.defaultValue ? this.defaultValue.transport_day           : "",
                time_of_day:             this.defaultValue ? this.defaultValue.time_of_day             : "",
                standard_transport_day:  this.defaultValue ? this.defaultValue.standard_transport_day  : "",
                standard_transport_time: this.defaultValue ? this.defaultValue.standard_transport_time : "",
                customer_name: "",
                city: "",
                province_name: "",
                start_date:  this.defaultValue ? this.defaultValue.start_date : "",
                end_date:    this.defaultValue ? this.defaultValue.end_date   : "",
                times: [
                    {
                        value: 'เช้า',
                        label: 'เช้า'
                    },{
                        value: 'บ่าย',
                        label: 'บ่าย'
                    }
                ],
                disableData: this.defaultValue ? this.defaultValue.customer_id ? true : false : false,

                // สำหรับ เช็ค วันที่
                disabledDateTo:     this.start_date ? this.start_date : null,
            }
        },

        mounted() {
            
            // if (!this.old.start_date || !this.old.end_date) {
                this.showDate();
            // }

            if (this.customer_id) {
                this.checkCustomer()
            }
            if (this.standard_transport_time) {
                var today = new Date();
                this.setDate = moment(today).format('yyyy-MM-DD');

                this.standard_transport_time = this.setDate +  ' ' + this.standard_transport_time;
            }
        },

        methods: {
            // checkCustomer() {
                
            //     this.ship_to_site_id = '';
            //     this.loading         = true;
                
            //     if (this.customer_id) {
            //         // om/ajax/ship-to-site 
            //         axios.get("/om/ajax/ship-to-site", {
            //             params: {
            //                 customer_id: this.customer_id,
            //             }
            //         })
            //         .then(res => {
            //             this.customerShipToSites = res.data;
            //             // console.log(this.customerShipToSites);
            //             this.loading = false;
            //         })
            //         .catch(err => {
            //             console.log(err)
            //         });
                    
            //     } 
                
            // },
            checkCustomer() {
                this.customer_name   = '';
                this.city            = '';
                this.province_name   = '';
                this.transport_day   = '';

                this.selectedData = this.customers.find( i => {
                    return i.customer_id == this.customer_id;
                });

                this.customer_name  = this.selectedData.customer_name;
                this.city           = this.selectedData.city;
                this.province_name  = this.selectedData.province_name;
                this.transport_day  = this.selectedData.delivery_date;
            },
            onlyNumeric() {
                this.transport_number = this.transport_number.replace(/[^0-9 .]/g, '');
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
            // save() {
            //     console.log('xxxxxxx');
            //     this.loading = true;
            //     axios
            //         .post(this.url, {
            //             transport_number        : this.transport_number,
            //             customer_id             : this.customer_id,
            //             ship_to_site_id         : this.ship_to_site_id,
            //             transport_day           : this.transport_day,
            //             time_of_day             : this.time_of_day,
            //             standard_transport_day  : this.standard_transport_day,
            //             standard_transport_time : this.standard_transport_time,
            //             start_date              : this.start_date,
            //             end_date                : this.end_date,
            //         })
            //         .then(res => {
            //             alert('complete');
            //         })
            //         // .then(res => {
            //         //     window.location.href = this.urlReturn;
            //         // })
            //         // .catch(error => {
            //         //     alert(error);
            //         // });
            // },

            // update() {
            //     console.log('update');
            //     this.loading = true;
            //     axios
            //         .put(this.urlUpdate, {
            //             start_date : this.start_date,
            //             end_date : this.end_date,
            //             stop_flag : this.stop_flag,
            //             vendor_id : this.vendor_id,
            //             transport_owner_code : this.transport_owner_code,
            //             transport_owner_name : this.transport_owner_name,
            //         })
            //         .then(res => {
            //             alert('complete');
            //         })
            //         .then(res => {
            //             window.location.href = this.urlReturn;
            //         })
            //         .catch(error => {
            //             alert(error);
            //         });
            // },
            // enableFlag(result){
            //     this.enable_flag = false;
            //     this.stop_flag = false;
            //     if (result == 'N') {
            //         this.enable_flag = false;
            //         this.stop_flag = true;
            //     }

            //     if (result == 'Y') {
            //         this.enable_flag = true;
            //         this.stop_flag = false;
            //     }
            // },

        },


    }
</script>


