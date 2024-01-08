<template>
    <div>
        <div class="row">
            <div class="col-md-1">
            </div>
            <div class="col-md-5">
                <label> เจ้าของรถขนส่ง <span class="text-danger">*</span></label>
                <el-input v-model="transport_owner_code" name="transport_owner_code"  size="medium">  </el-input>
            </div>
            <div class="col-md-5">
                <label> ชื่อเจ้าของรถขนส่ง <span class="text-danger">*</span></label>
                <el-input v-model="transport_owner_name" name="transport_owner_name"  size="medium" > </el-input>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-1">
            </div>
            <div class="col-md-5">
                <label> วันที่เริ่มต้น <span class="text-danger">*</span></label>
                <datepicker-th
                    size="medium"
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
                </el-date-picker> -->
            </div>
            <div class="col-md-5">
                <label> วันที่สิ้นสุด  </label>
                <datepicker-th
                    size="medium"
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
                    >
                </el-date-picker> -->
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-1">
            </div>
            <div class="col-md-5">
                <label> รหัสเจ้าหนี้ <span class="text-danger">*</span></label>
                <input type="hidden" name="vendor_id"  :value="vendor_id" autocomplete="off">
                <el-select  v-model="vendor_id"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100"
                                :remote-method="getVendorList"
                                size="medium"
                                >
                    <el-option  v-for="poVendor in VendorList"
                                :key="poVendor.vendor_id"
                                :label="poVendor.vendor_code+' - '+poVendor.vendor_name"
                                :value="poVendor.vendor_id">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-5">
                <label> API URL <span class="text-danger">*</span></label>
                <el-input v-model="api_url" name="api_url"  size="medium">  </el-input>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-1">
            </div>
            <div class="col-md-5">
                <label> API TOKEN <span class="text-danger">*</span></label>
                <el-input v-model="api_token" name="api_token"  size="medium" > </el-input>
            </div>
            <div class="col-md-5">
                <label> API USER <span class="text-danger">*</span></label>
                <el-input v-model="api_user" name="api_user"  size="medium">  </el-input>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-1">
            </div>
            <div class="col-md-5">
                <label> หยุดการใช้งาน </label><br>
                <input type="checkbox" name="stop_flag" v-model="stop_flag">
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
        props:[
            "po-vendors",
            "url",
            "url-return",
            "url-update",
            "default-value",
            "vendor-selected"
        ],
        data(){
            return {
                start_date:           this.defaultValue ? this.defaultValue.start_date    : "",
                end_date:             this.defaultValue ? this.defaultValue.end_date      : "",
                stop_flag:            this.defaultValue ? this.defaultValue.stop_flag == 'N'     ? false : true :  false,
                // enable_flag: true,
                vendor_id:            this.defaultValue ? Number(this.defaultValue.vendor_id)    : "",
                transport_owner_code: this.defaultValue ? this.defaultValue.transport_owner_code : "",
                transport_owner_name: this.defaultValue ? this.defaultValue.transport_owner_name : "",

                VendorList: [],

                // สำหรับ เช็ค วันที่
                disabledDateTo:     this.start_date ? this.start_date : null,

                api_url:   this.defaultValue ? this.defaultValue.api_url   : "",
                api_token: this.defaultValue ? this.defaultValue.api_token : "",
                api_user:  this.defaultValue ? this.defaultValue.api_user  : "",
            }
        },

    mounted() {
        this.getVendorList();

        // if (this.defaultValue) {
        //         this.start_date     = this.defaultValue.format_date_start;
        //         this.end_date       = this.defaultValue.format_date_end;
        //         // this.stop_flag = this.defaultValue.stop_flag,

        //         this.stop_flag      = this.defaultValue.stop_flag == 'N'
        //                             ? false
        //                             : true;
        //         // this.enable_flag =  this.defaultValue.stop_flag == 'Y'
        //         //                     ? false
        //         //                     : true;
        //         this.vendor_id = this.defaultValue
        //                             ? Number(this.defaultValue.vendor_id)
        //                             : "";
        //         this.transport_owner_code = this.defaultValue.transport_owner_code;
        //         this.transport_owner_name = this.defaultValue.transport_owner_name;
        // }

        this.showDate();
    },

    methods: {
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
        async getVendorList(query) {

            console.log('query --> ' + query);

            // this.vendor_id = '';
            let vender =  this.defaultValue ? this.defaultValue.vendor_id : "";
            console.log(vender);

            await axios.get("/om/ajax/vendor", {
                params: {
                    query: query,
                    vender: vender,
                }
            })
            .then(res => {
                this.VendorList = res.data;
            })
            .catch(err => {
                console.log(err)
            })
            .then( () => {
                this.loading = false;
            });
        },
        save() {
            console.log('xxxxxxx');
            this.loading = true;
            axios
                .post(this.url, {
                    start_date : this.start_date,
                    end_date : this.end_date,
                    stop_flag : this.stop_flag,
                    vendor_id : this.vendor_id,
                    transport_owner_code : this.transport_owner_code,
                    transport_owner_name : this.transport_owner_name,
                })
                .then(res => {
                    alert('complete');
                })
                .then(res => {
                    window.location.href = this.urlReturn;
                })
                .catch(error => {
                    alert(error);
                });
        },

        update() {
            console.log('update');
            this.loading = true;
            axios
                .put(this.urlUpdate, {
                    start_date : this.start_date,
                    end_date : this.end_date,
                    stop_flag : this.stop_flag,
                    vendor_id : this.vendor_id,
                    transport_owner_code : this.transport_owner_code,
                    transport_owner_name : this.transport_owner_name,
                })
                .then(res => {
                    alert('complete');
                })
                .then(res => {
                    window.location.href = this.urlReturn;
                })
                .catch(error => {
                    alert(error);
                });
        },
        enableFlag(result){
            this.enable_flag = false;
            this.stop_flag = false;
            if (result == 'N') {
                this.enable_flag = false;
                this.stop_flag = true;
            }

            if (result == 'Y') {
                this.enable_flag = true;
                this.stop_flag = false;
            }
        },

        },


    }
</script>

<style>

</style>
