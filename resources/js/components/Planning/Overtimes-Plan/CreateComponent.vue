<template>
    <span>
        <button :class="btnTrans.create.class + ' btn-lg tw-w-25'" @click.prevent="openModal()">
            <i :class="btnTrans.create.icon"></i> {{ btnTrans.create.text }}
        </button>

        <div id="modal-overtimes" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 style="font-size:22px; font-weight:400;" class="modal-title text-left">
                            สร้างประมาณการค่าใช้จ่ายล่วงเวลา
                        </h3>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    </div>
                    <div class="modal-body text-left" v-loading="loading">
                        <form id="overtimes-create-form">
                            <div class="row col-12 m-0">
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2">
                                    <label class=" tw-font-bold tw-uppercase mb-1"> ปีงบประมาณ </label>
                                    <div class="input-group ">
                                        <input type="hidden" name="budget_year" :value="budget_year">
                                        <el-select  v-model="budget_year" size="medium" placeholder="ปีงบประมาณ" filterable @change="getMonth" ref="budget_year" :popper-append-to-body="false">
                                            <el-option
                                               v-for="(year, index) in budgetYears"
                                                :key="index"
                                                :label="year.thai_year"
                                                :value="year.thai_year">
                                            </el-option>
                                        </el-select>
                                    </div>
                                    <div id="el_explode_budget_year" class="error_msg text-left"></div>
                                </div>

                                <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2">
                                    <label class=" tw-font-bold tw-uppercase mb-1" > เดือน </label>
                                    <div class="">
                                        <input type="hidden" name="month" :value="month">
                                        <el-select v-if="!budget_year" v-model="month" size="medium" placeholder="เดือน" ref="month" disabled>
                                            <el-option
                                               v-for="(month, index) in monthLists"
                                                :key="index"
                                                :label="month.thai_month"
                                                :value="month.period_num">
                                            </el-option>
                                        </el-select>
                                        <el-select v-else v-model="month" size="medium" placeholder="เดือน" filterable @change="getBiWeeklySeq" v-loading="m_loading" ref="month" :popper-append-to-body="false">
                                            <el-option
                                               v-for="(month, index) in monthLists"
                                                :key="index"
                                                :label="month.thai_month"
                                                :value="month.period_num">
                                            </el-option>
                                        </el-select>
                                    </div>
                                    <div id="el_explode_month" class="error_msg text-left"></div>
                                </div>

                                <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2">
                                    <label class=" tw-font-bold tw-uppercase mb-1" > ปักษ์ </label>
                                    <div class="">
                                        <input type="hidden" name="bi_weekly" :value="bi_weekly">
                                        <el-select v-if="!month" v-model="bi_weekly" clearable size="medium" placeholder="ปักษ์" ref="bi_weekly" disabled>
                                           <el-option
                                               v-for="(biweekly, index) in biWeeklyLists"
                                                :key="index"
                                                :label="biweekly.biweekly"
                                                :value="biweekly.biweekly">
                                            </el-option>
                                        </el-select>
                                        <el-select v-else v-model="bi_weekly" clearable size="medium" placeholder="ปักษ์" filterable @change="getBiWeeklyDetail" v-loading="b_loading" ref="bi_weekly" :popper-append-to-body="false">
                                           <el-option
                                               v-for="(biweekly, index) in biWeeklyLists"
                                                :key="index"
                                                :label="biweekly.biweekly"
                                                :value="biweekly.biweekly">
                                            </el-option>
                                        </el-select>
                                    </div>
                                    <div id="el_explode_bi_weekly" class="error_msg text-left"></div>
                                </div>

                                <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-4 col-xs-4 mt-2">
                                    <input type="hidden" name="working_hour" :value="working_hour">
                                    <label class=" tw-font-bold tw-uppercase mb-1" > ชั่วโมงทำงานเริ่มต้น :</label>
                                    <el-select v-model="working_hour" size="medium" placeholder="ชั่วโมงทำงานเริ่มต้น" filterable :popper-append-to-body="false">
                                       <el-option
                                           v-for="(hour, index) in workingHoliday"
                                            :key="index"
                                            :label="hour.meaning"
                                            :value="hour.lookup_code">
                                        </el-option>
                                    </el-select>
                                </div>

                                <div class="form-group pl-2 pr-2 mb-0 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label class=" tw-font-bold tw-uppercase mt-1">&nbsp;<br></label>
                                    <div class="text-right">
                                        <button class="btn btn-primary btn-sm" @click.prevent="submit()">
                                            <i class="fa fa-plus"></i> สร้าง
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close">
                                            <i class="fa fa-times"></i> ยกเลิก
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </span>
</template>

<script>
    export default {
        components: {
            //
        },
        props:['workingHour', 'workingHoliday', 'productTypes', 'defaultInput', 'searchInput', 'budgetYears', 'biWeeklyDetails', 'dateFormat', 'btnTrans'
            , 'url'],
        data() {
            return {
                budget_year: this.defaultInput.current_year,
                month: this.defaultInput.current_month,
                bi_weekly: this.defaultInput.current_biweekly,
                working_hour: this.defaultInput.working_hour,
                month_lists: [],
                bi_weekly_lists: [],
                bi_weekly_detail: '',
                loading: false,
                valid: false,
                m_loading: false,
                b_loading: false,
                errors: {
                    budget_year: false,
                    month: false,
                    bi_weekly: false
                },
                // // Support Issue with IT
                // edit_flag: false,
                // show_flag: true,
                // set_budget_year: this.search? String(this.search['budget_year']): this.defaultInput.current_year,
                // set_month: this.search? String(this.search['month']): '',
                // set_bi_weekly: this.search? String(this.search['bi_weekly']): '',
                // set_product_type: ((this.header != undefined && this.header != '')? this.header.product_type: this.search)? this.search['product_type']: this.defaultInput.product_type,
                // valid_action: false,
                // creator: this.header && this.header.updated_by? this.header.updated_by.name: (this.header && this.header.created_by? this.header.created_by.name: null),
            }
        },
        mounted() {
            if (this.budget_year) {
                this.getMonth();
            }
            if (this.budget_year && this.month && this.bi_weekly) {
                this.getMonth();
                this.getBiWeeklySeq();
            }
            this.getBiWeeklyDetail();
        },
        computed: {
            monthLists: function () {
                return this.month_lists;
            },
            biWeeklyLists: function () {
                return this.bi_weekly_lists;
            }
        },
        watch:{
            errors: {
                handler(val){
                    val.budget_year? this.setError('budget_year') : this.resetError('budget_year');
                    val.month? this.setError('month') : this.resetError('month');
                    val.bi_weekly? this.setError('bi_weekly') : this.resetError('bi_weekly');
                },
                deep: true,
            },
        },
        methods: {
            openModal() {
                $('#modal-overtimes').modal('show');
            },
            getMonth(){
                var vm = this;
                vm.month_lists = vm.searchInput.months;
            },
            getBiWeeklySeq(){
                var vm = this;
                vm.bi_weekly_lists = vm.searchInput.bi_weekly.filter(item => {
                    return item.period_num == vm.month;
                });
            },
            getBiWeeklyDetail(){
                var vm = this;
                if (vm.biWeekly == '' || vm.biWeekly == null) {vm.biWeeklyDetail = '';}
                vm.biWeeklyDetails.filter(item => {
                    if (item.thai_year == vm.budget_year &&  item.period_num == vm.month &&  item.biweekly == vm.bi_weekly) {
                        return vm.bi_weekly_detail = item.thai_combine_date;
                    }
                });
            },
            async submit(){
                var form  = $('#overtimes-create-form');
                let inputs = form.serialize();
                let valid = true;
                let errorMsg = '';
                this.errors.budget_year = false;
                this.errors.month = false;
                this.errors.bi_weekly = false;
                $(form).find("div[id='budget_year']").html("");
                $(form).find("div[id='el_explode_month']").html("");
                $(form).find("div[id='el_explode_bi_weekly']").html("");

                if (this.budget_year == ''){
                    this.errors.budget_year = true;
                    valid = false;
                    errorMsg = "กรุณาเลือกปีงบประมาณ";
                    $(form).find("div[id='el_explode_budget_year']").html(errorMsg);
                }
                if (this.month == ''){
                    this.errors.month = true;
                    valid = false;
                    errorMsg = "กรุณาเลือกเดือน";
                    $(form).find("div[id='el_explode_month']").html(errorMsg);
                }
                if (this.bi_weekly == ''){
                    this.errors.bi_weekly = true;
                    valid = false;
                    errorMsg = "กรุณาเลือกปักษ์";
                    $(form).find("div[id='el_explode_bi_weekly']").html(errorMsg);
                }
                if (!valid) {
                    return;
                }
                this.loading = true;
                let res = await this.createOverTimesPlan(inputs);
                if(res.status == 'S'){
                    swal({
                        title: 'สร้างประมาณการค่าใช้จ่ายล่วงเวลา',
                        text: '<span style="font-size: 16px; text-align: left;"> ทำการสร้างข้อมูลประมาณการค่าใช้จ่ายล่วงเวลาประจำปักษ์เรียบร้อยแล้ว </span>',
                        type: "success",
                        html: true
                    });
                    //redirect
                    window.setTimeout(function() {
                        window.location.href = res.redirectPath;
                    }, 2000);
                }else{
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">'+res.msg+'</span>',
                        type: "warning",
                        html: true
                    });
                }
            },
            async createOverTimesPlan(inputs) {
                let data = [];
                let vm = this;
                await axios
                    .post(vm.url.ajax_create_ot_plan, inputs)
                    .then(res => {
                        data = res.data;
                    })
                    .catch(err => {
                        let msg = err.response.data;
                        swal({
                            title: 'มีข้อผิดพลาด',
                            text: msg.message,
                            type: "error",
                        });
                    })
                    .then(() => {
                        this.loading = false;
                    });

                return data;
            },

























            // async submit(){
            //     var form  = $('#machine-form');
            //     let inputs = form.serialize();
            //     let valid = true;
            //     let errorMsg = '';
            //     this.errors.budget_year = false;
            //     this.errors.month = false;
            //     this.errors.bi_weekly = false;
            //     $(form).find("div[id='el_explode_budget_year']").html("");
            //     $(form).find("div[id='el_explode_month']").html("");
            //     $(form).find("div[id='el_explode_bi_weekly']").html("");
            //     if (this.budget_year == ''){
            //         this.errors.budget_year = true;
            //         valid = false;
            //         errorMsg = "กรุณาเลือกปีงบประมาณ";
            //         $(form).find("div[id='el_explode_budget_year']").html(errorMsg);
            //     }
            //     if (this.month == ''){
            //         this.errors.month = true;
            //         valid = false;
            //         errorMsg = "กรุณาเลือกเดือน";
            //         $(form).find("div[id='el_explode_month']").html(errorMsg);
            //     }
            //     if (this.bi_weekly == ''){
            //         this.errors.bi_weekly = true;
            //         valid = false;
            //         errorMsg = "กรุณาเลือกปักษ์";
            //         $(form).find("div[id='el_explode_bi_weekly']").html(errorMsg);
            //     }
            //     if (!valid) {
            //         return;
            //     }
            //     this.loading = true;
            //     form.submit();
            // },
            // setError(ref_name){
            //     let ref = this.$refs[ref_name].$refs.reference 
            //             ? this.$refs[ref_name].$refs.reference.$refs.input 
            //             : (this.$refs[ref_name].$refs.textarea 
            //                 ? this.$refs[ref_name].$refs.textarea 
            //                 : (this.$refs[ref_name].$refs.input.$refs 
            //                     ? this.$refs[ref_name].$refs.input.$refs.input 
            //                     : this.$refs[ref_name].$refs.input ));
            //     ref.style = "border: 1px solid red;";
            // },
            // resetError(ref_name){
            //     let ref = this.$refs[ref_name].$refs.reference 
            //             ? this.$refs[ref_name].$refs.reference.$refs.input 
            //             : (this.$refs[ref_name].$refs.textarea 
            //                 ? this.$refs[ref_name].$refs.textarea
            //                 : (this.$refs[ref_name].$refs.input.$refs 
            //                     ? this.$refs[ref_name].$refs.input.$refs.input 
            //                     : this.$refs[ref_name].$refs.input ));
            //     ref.style = "";
            // },
            // checkSearchCondition(){
            //     // Check show data when change search
            //     var vm = this;
            //     if(vm.valid_action){
            //         swal({
            //             title: 'บันทึกหรือยกเลิกการเปลี่ยนแปลงข้อมูล',
            //             text: '<span style="font-size: 16px; text-align: left;"> กรุณาทำการบันทึกหรือยกเลิกการเปลี่ยนแปลงให้เรียบร้อย </span>',
            //             type: "warning",
            //             html: true
            //         })
            //         vm.budget_year = vm.set_budget_year;
            //         vm.month = vm.set_month;
            //         vm.bi_weekly = vm.set_bi_weekly;
            //         vm.product_type = vm.set_product_type;
            //         return;
            //     }
            //     vm.edit_flag = '';
            //     vm.show_flag = true;
            //     if (vm.set_budget_year != vm.budget_year || vm.set_month != vm.month || vm.set_bi_weekly != vm.bi_weekly) {
            //         vm.edit_flag = false;
            //         vm.show_flag = false;
            //     }else if(vm.set_budget_year == vm.budget_year && vm.month == '' && vm.bi_weekly == ''){
            //         vm.edit_flag = false;
            //         vm.show_flag = false;
            //     }else if(vm.set_budget_year == vm.budget_year && vm.set_month == vm.month && (vm.bi_weekly == '' || vm.set_bi_weekly != vm.bi_weekly)){
            //         vm.edit_flag = false;
            //         vm.show_flag = false;
            //     }else if(vm.set_budget_year == vm.budget_year && vm.set_month == vm.month && vm.set_bi_weekly == vm.bi_weekly && vm.set_product_type != vm.product_type) {
            //         vm.edit_flag = false;
            //         vm.show_flag = false;
            //     }
            // },
            // updateEditFlag(res){
            //     this.valid_action = res;
            // }
        }
    }
</script>