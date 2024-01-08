<template>
    <div>
        <form id="stamp-adjust" :action="url.search">
            <div>
                <div class="row form-group">
                    <div class="col-md-3">
                        <div class="row">
                            <label class="col-md-4 col-form-label tw-font-bold tw-pt-0 required"> ปีงบประมาณ </label>
                            <div class="col-md-8">
                                <ct-el-select name="period_year" id="input_period_year" 
                                    :select-options="periodYears"
                                    option-key="period_year_value"
                                    option-value="period_year_value" 
                                    option-label="period_year_label" 
                                    :value="paramHeader.period_year"
                                    :filterable="true"
                                    :clearable="true"
                                    @onSelected="onPeriodYearChanged"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                            <label class="col-md-4 col-form-label tw-font-bold required"> งวดบัญชี </label>
                            <div class="col-md-8">
                                <input type="hidden" name="period_name" :value="paramHeader.period_name">
                                <ct-el-select name="period_number" id="input_period_number" 
                                    :select-options="periodNumbers"
                                    option-key="period_number_value"
                                    option-value="period_number_value" 
                                    option-label="period_number_full_label" 
                                    :value="paramHeader.period_number"
                                    :filterable="true"
                                    :clearable="true"
                                    @onSelected="onPeriodNumberChanged"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                            <label class="col-md-4 col-form-label tw-font-bold required"> ตั้งแต่วันที่ </label>
                            <div class="col-md-8">
                                <p class="col-form-label"> {{ paramHeader.start_date_thai ? paramHeader.start_date_thai : "-" }} </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                            <label class="col-md-4 col-form-label tw-font-bold required"> ถึงวันที่ </label>
                            <div class="col-md-8">
                                <p class="col-form-label"> {{ paramHeader.end_date_thai ? paramHeader.end_date_thai : "-" }} </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div>
                <div style="text-align: right;" class="tw-mb-2">
                    <button type="submit" class="btn btn-inline-block btn-sm btn-primary tw-w-40"
                        :disabled="!paramHeader.period_year || !paramHeader.period_name">
                        <i class="fa fa-search tw-mr-1"></i> แสดงข้อมูล 
                    </button>
                    <a :href="url.search" class="btn btn-inline-block btn-sm btn-white tw-w-40">
                        <i class="fa fa-times tw-mr-1"></i> ล้างการค้นหา
                    </a>

                    <template v-if="valid">
                        <modal-add-stamp v-if="!interfaceFlag"
                            :stamps="stamps"
                            :btnTrans="btnTrans"
                            :url="url"
                            :periodName="periodNameValue"
                            :manualTemps="manualTemps"
                        />
                        <!-- --------------------------------------------------------------------------------------- -->
                        <button v-if="!interfaceFlag" type="button" class="btn btn-inline-block btn-sm btn-info tw-w-40"
                            @click="stampInterfaceGL()">
                            <i class="fa fa-retweet tw-mr-1"></i> ส่งข้อมูลเข้า GL
                        </button>
                        <button v-else type="button" class="btn btn-inline-block btn-sm btn-danger tw-w-40"
                            @click="stampCancelInterfaceGL()">
                            <i class="fa fa-retweet tw-mr-1"></i> ยกเลิกส่งข้อมูลเข้า GL
                        </button>
                        <!-- -------------------------------------------------------------------------------------- -->
                        <a :href="'/ir/reports/get-param?period_name='+paramHeader.period_name+'&program_code=CTR0036&function_name=CTR0036&output=pdf'"
                            target="_blank" type="button"
                            :class="btnTrans.print.class + ' btn btn-inline-block btn-sm tw-w-40'">
                            <i :class="btnTrans.print.icon"></i> พิมพ์รายงาน
                        </a>
                    </template>
                </div>
            </div>
        </form>
        <loading :active.sync="isLoading" :is-full-page="true"></loading>
    </div>
</template>

<script>
    import "vue-loading-overlay/dist/vue-loading.css";
    import Loading from "vue-loading-overlay";
    import moment from 'moment';
    import modalAddStamp from './ModalAddStamp.vue';

    export default {
        components: { Loading, modalAddStamp },
        props: ['periodYears', 'searchInputs', 'url', 'periodYearValue', 'periodNameValue', 'btnTrans', 'interfaceGlFlag', 'validData', 'stamps', 'manualTemps'],
        mounted() {
            if (this.periodYearValue) {
                // GET PERIOD NUMBERS
                this.getListPeriodNumbers(this.periodYearValue).then((value) => {
                    if(this.periodNameValue) {
                        this.paramHeader.period_number = this.getPeriodNumber(this.periodNumbers, this.periodNameValue);
                        this.paramHeader.start_date = this.getPeriodStartDate(this.periodNumbers, this.periodNameValue, "EN");
                        this.paramHeader.end_date = this.getPeriodEndDate(this.periodNumbers, this.periodNameValue, "EN");
                        this.paramHeader.start_date_thai = this.getPeriodStartDate(this.periodNumbers, this.periodNameValue, "TH");
                        this.paramHeader.end_date_thai = this.getPeriodEndDate(this.periodNumbers, this.periodNameValue, "TH");
                    }
                });
            }
        },
        data() {
            return {
                paramHeader: {
                    period_year: this.periodYearValue,
                    period_year_label: this.getPeriodYearLabel(this.periodYears, this.periodYearValue),
                    period_name: this.periodNameValue,
                    period_number: '',
                    start_date: '',
                    end_date: '',
                    start_date_thai: '',
                    end_date_thai: '',
                },
                periodNumbers: [],
                queryParams: [],
                isVerified: false,
                isLoading: false,
                interfaceFlag: this.interfaceGlFlag,
                valid: this.validData,
            }
        },
        methods: {
            setUrlParams() {
                var queryParams = new URLSearchParams(window.location.search);
                queryParams.set("period_year", this.paramHeader.period_year);
                queryParams.set("period_name", this.paramHeader.period_name);
                // queryParams.set("period_number", this.paramHeader.period_number);
                window.history.replaceState(null, null, "?"+queryParams.toString());
            },
            async getListPeriodNumbers(periodYear) {
                // show loading
                this.isLoading = true;
                // REFRESH DATA
                this.periodNumbers = [];
                var params = { 
                    period_year: periodYear
                };
                this.periodNumbers = await axios.get("/ajax/ct/workorders/processes/get-period-numbers", { params })
                .then(res => {
                    const resData = res.data.data;
                    return resData.period_numbers ? JSON.parse(resData.period_numbers) : [];
                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `ข้อมูลปี ${this.paramHeader.period_year_label} ไม่ถูกต้อง | ${error.message}`, "error");
                    return ;
                });

                // hide loading
                this.isLoading = false;
            },
            async onPeriodYearChanged(value) {
                this.paramHeader.period_year = value;
                this.paramHeader.period_year_label = this.getPeriodYearLabel(this.periodYears, value);
                this.paramHeader.period_name = '';
                this.paramHeader.period_number = '';
                this.paramHeader.start_date = '';
                this.paramHeader.end_date = '';
                this.paramHeader.start_date_thai = '';
                this.paramHeader.end_date_thai = '';

                this.getListPeriodNumbers(this.paramHeader.period_year);
            },
            async onPeriodNumberChanged(value) {
                this.paramHeader.period_name = value;
                this.paramHeader.period_number = this.getPeriodNumber(this.periodNumbers, value);
                this.paramHeader.start_date = this.getPeriodStartDate(this.periodNumbers, value, "EN");
                this.paramHeader.end_date = this.getPeriodEndDate(this.periodNumbers, value, "EN");
                this.paramHeader.start_date_thai = this.getPeriodStartDate(this.periodNumbers, value, "TH");
                this.paramHeader.end_date_thai = this.getPeriodEndDate(this.periodNumbers, value, "TH");
            },
            getPeriodYearLabel(periodYears, periodYear) {
                const foundPeriodYear = periodYears.find(item => item.period_year_value == periodYear);
                return foundPeriodYear ? foundPeriodYear.period_year_label : "";
            },
            getPeriodNumber(periodNumbers, periodName) {
                const foundPeriodNumber = periodNumbers.find(item => item.period_number_value == periodName);
                return foundPeriodNumber ? foundPeriodNumber.period_number_label : "";
            },
            getPeriodStartDate(periodNumbers, periodName, dateType) {
                let result = null;
                const foundPeriodNumber = periodNumbers.find(item => item.period_number_value == periodName);
                result = foundPeriodNumber ? foundPeriodNumber.start_date : "";
                if(dateType == "TH") {
                    result = foundPeriodNumber ? foundPeriodNumber.start_date_thai : "";
                }
                return result;
            },
            getPeriodEndDate(periodNumbers, periodName, dateType) {
                let result = null;
                const foundPeriodNumber = periodNumbers.find(item => item.period_number_value == periodName);
                result = foundPeriodNumber ? foundPeriodNumber.end_date : "";
                if(dateType == "TH") {
                    result = foundPeriodNumber ? foundPeriodNumber.end_date_thai : "";
                }
                return result;
            },
            async onClearParamHeader() {
                this.paramHeader.period_year = '';
                this.paramHeader.period_year_label = '';
                this.paramHeader.period_name = '';
                this.paramHeader.period_number = '';
                this.paramHeader.start_date = '';
                this.paramHeader.end_date = '';
                this.paramHeader.start_date_thai = '';
                this.paramHeader.end_date_thai = '';
                this.periodNumbers = [];
            },
            async stampInterfaceGL() {
                // GENERATE TRANSACTIONS
                const reqBody = {
                    period_year: this.paramHeader.period_year,
                    period_name: this.paramHeader.period_name,
                };
                /// -----------------------------------------------------------------------------------------
                let vm = this;
                let swalConfirm = swal({
                    html: true,
                    title: '<span style="font-size: 18px;"><strong> ส่งข้อมูลต้นทุนขายแยกแสตมป์และกองทุนเข้า GL </strong></span>',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 17px"> คุณต้องการส่งข้อมูลต้นทุนขายแยกแสตมป์และกองทุนเข้า GL ? </span></h2>',
                    showCancelButton: true,
                    confirmButtonText: vm.btnTrans.ok.text,
                    cancelButtonText: vm.btnTrans.cancel.text,
                    confirmButtonClass: vm.btnTrans.ok.class + ' btn-lg tw-w-25',
                    cancelButtonClass: vm.btnTrans.cancel.class + ' btn-lg tw-w-25',
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                async function(isConfirm){
                    if (isConfirm) {
                        await axios
                        .post(vm.url.ajax_interface_gl, reqBody)
                        .then(res => {
                            if (res.data.status == 'S') {
                                vm.interfaceFlag = res.data.interfaceGLFlag;
                                vm.$emit("updateInterfaceFlag", {flag: res.data.interfaceGLFlag});
                                swal({
                                    title: '<span style="font-size: 22px;"><strong> ส่งข้อมูลต้นทุนขายแยกแสตมป์และกองทุนเข้า GL </strong></span>',
                                    text: '<span style="font-size: 15px; text-align: left;"> ทำการส่งข้อมูลต้นทุนขายแยกแสตมป์และกองทุนเข้า GL เรียบร้อยแล้ว </span>',
                                    type: "success",
                                    html: true
                                });
                            }else{
                                swal({
                                    title: 'มีข้อผิดพลาด',
                                    text: '<span style="font-size: 15px; text-align: left;">'+res.data.msg+'</span>',
                                    type: "warning",
                                    html: true
                                });
                            }
                        })
                        .catch(err => {
                            console.log(err);
                            swal({
                                title: 'มีข้อผิดพลาด',
                                text: '<span style="font-size: 15px; text-align: left;">'+err.response+'</span>',
                                type: "warning",
                                html: true
                            });
                        })
                        .then(() => {
                            vm.isLoading = false;
                        });
                    }
                });
            },
            async stampCancelInterfaceGL() {
                // GENERATE TRANSACTIONS
                const reqBody = {
                    period_year: this.paramHeader.period_year,
                    period_name: this.paramHeader.period_name,
                };
                /// -----------------------------------------------------------------------------------------
                let vm = this;
                let swalConfirm = swal({
                    html: true,
                    title: '<span style="font-size: 18px;"> <strong> ยกเลิกข้อมูลต้นทุนขายแยกแสตมป์และกองทุนเข้า GL </strong> </span>',
                    text: '<h2 class="m-t-sm m-b-lg text-left"> <span style="font-size: 16px;"> คุณต้องการยกเลิกข้อมูลต้นทุนขายแยกแสตมป์และกองทุนเข้า GL ? </span> </h2>',
                    showCancelButton: true,
                    confirmButtonText: vm.btnTrans.ok.text,
                    cancelButtonText: vm.btnTrans.cancel.text,
                    confirmButtonClass: vm.btnTrans.ok.class + ' btn-lg tw-w-25',
                    cancelButtonClass: vm.btnTrans.cancel.class + ' btn-lg tw-w-25',
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                async function(isConfirm){
                    if (isConfirm) {
                        await axios
                        .post(vm.url.ajax_cancel_interface_gl, reqBody)
                        .then(res => {
                            if (res.data.status == 'S') {
                                vm.interfaceFlag = res.data.interfaceGLFlag;
                                vm.$emit("updateInterfaceFlag", {flag: res.data.interfaceGLFlag});
                                swal({
                                    title: '<span style="font-size: 20px;"><strong> ยกเลิกข้อมูลต้นทุนขายแยกแสตมป์และกองทุนเข้า GL </strong></span>',
                                    text: '<span style="font-size: 14.5px; text-align: left;"> ทำการยกเลิกข้อมูลต้นทุนขายแยกแสตมป์และกองทุนเข้า GL เรียบร้อยแล้ว </span>',
                                    type: "success",
                                    html: true
                                });
                            }else{
                                swal({
                                    title: 'มีข้อผิดพลาด',
                                    text: '<span style="font-size: 15px; text-align: left;">'+res.data.msg+'</span>',
                                    type: "warning",
                                    html: true
                                });
                            }
                        })
                        .catch(err => {
                            console.log(err);
                            swal({
                                title: 'มีข้อผิดพลาด',
                                text: '<span style="font-size: 15px; text-align: left;">'+err.response+'</span>',
                                type: "warning",
                                html: true
                            });
                        })
                        .then(() => {
                            vm.isLoading = false;
                        });
                    }
                });
            },
            // add btn 20221217
            async storeStampOther() {
                // GENERATE TRANSACTIONS
                const reqBody = {
                    period_year: this.paramHeader.period_year,
                    period_name: this.paramHeader.period_name,
                };
                /// -----------------------------------------------------------------------------------------
                let vm = this;
                let swalConfirm = swal({
                    html: true,
                    title: '<span style="font-size: 18px;"><strong> ส่งข้อมูลต้นทุนขายแยกแสตมป์และกองทุนเข้า GL </strong></span>',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 17px"> คุณต้องการส่งข้อมูลต้นทุนขายแยกแสตมป์และกองทุนเข้า GL ? </span></h2>',
                    showCancelButton: true,
                    confirmButtonText: vm.btnTrans.ok.text,
                    cancelButtonText: vm.btnTrans.cancel.text,
                    confirmButtonClass: vm.btnTrans.ok.class + ' btn-lg tw-w-25',
                    cancelButtonClass: vm.btnTrans.cancel.class + ' btn-lg tw-w-25',
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                async function(isConfirm){
                    if (isConfirm) {
                        await axios
                        .post(vm.url.ajax_interface_gl, reqBody)
                        .then(res => {
                            if (res.data.status == 'S') {
                                vm.interfaceFlag = res.data.interfaceGLFlag;
                                vm.$emit("updateInterfaceFlag", {flag: res.data.interfaceGLFlag});
                                swal({
                                    title: '<span style="font-size: 22px;"><strong> ส่งข้อมูลต้นทุนขายแยกแสตมป์และกองทุนเข้า GL </strong></span>',
                                    text: '<span style="font-size: 15px; text-align: left;"> ทำการส่งข้อมูลต้นทุนขายแยกแสตมป์และกองทุนเข้า GL เรียบร้อยแล้ว </span>',
                                    type: "success",
                                    html: true
                                });
                            }else{
                                swal({
                                    title: 'มีข้อผิดพลาด',
                                    text: '<span style="font-size: 15px; text-align: left;">'+res.data.msg+'</span>',
                                    type: "warning",
                                    html: true
                                });
                            }
                        })
                        .catch(err => {
                            console.log(err);
                            swal({
                                title: 'มีข้อผิดพลาด',
                                text: '<span style="font-size: 15px; text-align: left;">'+err.response+'</span>',
                                type: "warning",
                                html: true
                            });
                        })
                        .then(() => {
                            vm.isLoading = false;
                        });
                    }
                });
            },
        }
    }

</script>


