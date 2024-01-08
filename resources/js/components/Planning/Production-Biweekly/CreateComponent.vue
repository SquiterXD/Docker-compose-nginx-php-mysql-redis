<template>
    <div id="modal-create" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 style="font-size:22px; font-weight:400;" class="modal-title text-left">
                        สร้างแผนประมาณการผลิต
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div id="modal_content_create">
                        <form id="production-plan-create-form">
                            <div class="row col-12 m-0">
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-3 col-sm-6 col-xs-6 mt-2">
                                    <label class="tw-font-bold tw-uppercase mb-1"> ปีงบประมาณ :</label>
                                    <div class="input-group ">
                                        <input type="hidden" name="search[budget_year]" :value="budget_year">
                                        <el-select  v-model="budget_year" clearable size="medium" placeholder="ปีงบประมาณ" filterable @change="getBiWeekly" ref="budget_year_create">
                                            <el-option
                                               v-for="(year, index) in budgetYears"
                                                :key="index"
                                                :label="year.period_year_thai"
                                                :value="year.period_year_thai"
                                            >
                                            </el-option>
                                        </el-select>
                                        <div id="el_explode_budget_year_create" class="error_msg text-left"></div>
                                    </div>
                                </div>
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2">
                                    <label class="tw-font-bold tw-uppercase mb-1"> ปักษ์ที่ :</label>
                                    <div class="">
                                        <input type="hidden" name="search[bi_weekly]" :value="bi_weekly">
                                        <el-select v-if="!budget_year" v-model="bi_weekly" clearable size="medium" placeholder="ปักษ์" ref="bi_weekly_create" disabled>
                                           <el-option
                                               v-for="(biweekly, index) in biWeeklyLists"
                                                :key="index"
                                                :label="biweekly.biweekly"
                                                :value="biweekly.biweekly"
                                            >
                                            </el-option>
                                        </el-select>

                                        <el-select v-else v-model="bi_weekly" clearable size="medium" placeholder="ปักษ์" filterable :v-loading="b_loading" ref="bi_weekly_create" @change="getDetail">
                                           <el-option
                                               v-for="(biweekly, index) in biWeeklyLists"
                                                :key="index"
                                                :label="biweekly.biweekly"
                                                :value="biweekly.biweekly"
                                            >
                                            </el-option>
                                        </el-select>
                                        <div id="el_explode_bi_weekly_create" class="error_msg text-left"></div>
                                    </div>
                                </div>
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-2 col-sm-6 col-xs-6 mt-2">
                                    <label class="tw-font-bold tw-uppercase mb-1"> ครั้งที่ :</label>
                                    <el-input placeholder="ครั้งที่" v-model="times" size="medium" disabled="disabled"> </el-input>
                                </div>
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-3 col-sm-6 col-xs-6 mt-2">
                                    <label class="tw-font-bold tw-uppercase mb-1"> ประจำเดือน :</label>
                                    <el-input placeholder="ประจำเดือน" v-model="month" size="medium" disabled="disabled"> </el-input>
                                </div>
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-4 col-sm-6 col-xs-6 mt-2">
                                    <label class=" tw-font-bold tw-uppercase mb-1" > ประมาณกำลังการผลิต :</label>
                                    <div class="">
                                        <input type="hidden" name="search[product_type]" :value="product_type">
                                        <el-select v-model="product_type" clearable size="medium" placeholder="ประมาณกำลังการผลิต" filterable ref="product_type">
                                            <el-option
                                                v-for="(product, index) in productTypes"
                                                :key="index"
                                                :label="product.meaning"
                                                :value="product.lookup_code"
                                            >
                                            </el-option>
                                        </el-select>
                                        <div id="el_explode_product_type" class="error_msg text-left"></div>
                                    </div>
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
    </div>
</template>

<script>
    export default {
        props:['budgetYears', 'biWeekly', 'search', 'productTypes', 'url'],
        data() {
            return {
                budget_year: this.search? this.search['budget_year']: '',
                bi_weekly: this.search? String(this.search['bi_weekly']): '',
                times: '',
                month: '',
                product_type: '',
                loading: false,
                b_loading: false,
                errors: {
                    budget_year: false,
                    bi_weekly: false
                },
                biWeeklyLists: [],
            }
        },
        mounted() {
            if (this.budget_year) {
                this.getBiWeekly();
            }
        },
        computed: {
        },
        watch:{
            errors: {
                handler(val){
                    val.budget_year? this.setError('budget_year') : this.resetError('budget_year');
                    val.bi_weekly? this.setError('bi_weekly') : this.resetError('bi_weekly');
                },
                deep: true,
            },
        },
        methods: {
            getBiWeekly(){
                if (!this.search) {
                    this.bi_weekly = '';
                    this.month = '';
                    this.times = '';
                }
                this.biWeeklyLists = this.biWeekly.filter(item => {
                    return item.period_year_thai.indexOf(this.budget_year) > -1;
                });
            },
            getDetail(){
                this.times = 1;
                this.biWeeklyLists.find(item => {
                    if (item.biweekly == this.bi_weekly) {
                        return this.month = item.thai_month;
                    }
                });
            },
            setError(ref_name){
                let ref = this.$refs[ref_name].$refs.reference
                        ? this.$refs[ref_name].$refs.reference.$refs.input
                        : (this.$refs[ref_name].$refs.textarea
                            ? this.$refs[ref_name].$refs.textarea
                            : (this.$refs[ref_name].$refs.input.$refs
                                ? this.$refs[ref_name].$refs.input.$refs.input
                                : this.$refs[ref_name].$refs.input ));
                ref.style = "border: 1px solid red;";
            },
            resetError(ref_name){
                let ref = this.$refs[ref_name].$refs.reference
                        ? this.$refs[ref_name].$refs.reference.$refs.input
                        : (this.$refs[ref_name].$refs.textarea
                            ? this.$refs[ref_name].$refs.textarea
                            : (this.$refs[ref_name].$refs.input.$refs
                                ? this.$refs[ref_name].$refs.input.$refs.input
                                : this.$refs[ref_name].$refs.input ));
                ref.style = "";
            },
            async submit(){
                var form  = $('#production-plan-create-form');
                let inputs = form.serialize();
                let valid = true;
                let errorMsg = '';
                this.errors.budget_year = false;
                this.errors.bi_weekly = false;
                $(form).find("div[id='el_explode_budget_year']").html("");
                $(form).find("div[id='el_explode_bi_weekly']").html("");

                if (this.budget_year == ''){
                    this.errors.budget_year = true;
                    valid = false;
                    errorMsg = "กรุณาเลือกปีงบประมาณ";
                    $(form).find("div[id='el_explode_budget_year']").html(errorMsg);
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
                let res = await this.create(inputs);
                let vm = this;
                if(res.status == 'S'){
                    swal({
                        title: 'สร้างแผนประมาณการผลิต',
                        text: '<span style="font-size: 16px; text-align: left;"> ทำการสร้างข้อมูลแผนประมาณการผลิตเรียบร้อยแล้ว </span>',
                        type: "success",
                        html: true
                    });
                    //redirect
                    window.setTimeout(function() {
                        window.location.href = vm.url.production_biweekly_index;
                    }, 2000);
                }else{
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">'+res.msg+'</span>',
                        type: "error",
                        html: true
                    });
                }
            },
            async create(inputs) {
                let data = [];
                await axios
                    // .post(`/planning/biweekly/production-plan`, inputs)
                    .post(this.url.ajax_production_biweekly_store, inputs)
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
        }
    }
</script>